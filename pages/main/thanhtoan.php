
<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die('Giỏ hàng rỗng.');
}
include('../../admincp/config/config.php');
require('../../Carbon-3.8.0/autoload.php');
$config = include 'brevo_config.php';
require_once('config_vnpay.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$logFilePath = __DIR__ . '/cart-error.log'; // Define log file path

$ma_gh = uniqid();

// Khai báo các chuỗi rỗng để chứa dữ liệu đã ghép lại
$tong_tien = 0;
$ten_sp_arr = [];
$ma_sp_arr = [];
$gia_sp_arr = [];
$so_luong_arr = [];
$thanhtien_arr = [];

// Lặp qua giỏ hàng và ghép dữ liệu lại
foreach ($_SESSION['cart'] as $key => $value) {
    $email = $_SESSION['email']; // Email từ session của người dùng
    $ten_sp = $value['ten_sp'];
    $ma_sp = $value['ma_sp'];
    $gia_sp = $value['gia_sp'];
    $so_luong = $value['so_luong'];
    $thanhtien = $so_luong * $gia_sp; // Tính tổng tiền cho từng sản phẩm
    $tong_tien += $thanhtien; // Tổng tiền đơn hàng

    // Thêm các giá trị vào mảng tương ứng
    $ten_sp_arr[] = $ten_sp;
    $ma_sp_arr[] = $ma_sp;
    $gia_sp_arr[] = $gia_sp;
    $so_luong_arr[] = $so_luong;
    $thanhtien_arr[] = $thanhtien;
}

// Ghép các giá trị trong mảng thành chuỗi và ngăn cách bằng dấu phẩy
$ten_sp_str = implode(", ", $ten_sp_arr);
$ma_sp_str = implode(", ", $ma_sp_arr);
$gia_sp_str = implode(", ", $gia_sp_arr);
$so_luong_str = implode(", ", $so_luong_arr);
$thanhtien_str = implode(", ", $thanhtien_arr);

// // Chèn dữ liệu vào bảng tbl_cartsessions
// $insertCartSession = "
//     INSERT INTO tbl_cartsessions (email, ten_sp, ma_gh, ma_sp, gia_sp, so_luong, tong_tien) 
//     VALUES ('$email', '$ten_sp_str', '$ma_gh', '$ma_sp_str', '$gia_sp_str', '$so_luong_str', $tong_tien)
// ";

// // Kiểm tra truy vấn
// if (!mysqli_query($mysqli, $insertCartSession)) {
//     die('Error inserting data into tbl_cartsessions: ' . mysqli_error($mysqli));
// }

foreach ($_SESSION['cart'] as $key => $value) {
  $thanhtien = $value['so_luong'] * $value['gia_sp'];
  $tong_tien += $thanhtien;
  error_log('Product ID: ' . $value['id'] . ', Quantity: ' . $value['so_luong'] . ', Subtotal: ' . $thanhtien, 3, $logFilePath);
}

$now = Carbon::now('Asia/Ho_Chi_Minh');
$id_khachhang = $_SESSION['id_khachhang'];
$cart_payment = $_POST['payment'];
$expire = Carbon::now('Asia/Ho_Chi_Minh')->addHours(2)->format('YmdHis');

// Fetch shipping info and log details
$id_dangky = $_SESSION['id_khachhang'];
$sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_dangky' LIMIT 1");
$row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
$id_shipping = $row_get_vanchuyen['id_shipping'];

// Log before looping through cart items
error_log('Processing cart items...', 3, $logFilePath);

if ($cart_payment == 'tienmat' || $cart_payment == 'chuyenkhoan') {
    // Log before inserting cart into tbl_hoadon
    error_log('Inserting cart into tbl_hoadon for customer: ' . $id_khachhang, 3, $logFilePath);

    $insert_cart = "INSERT INTO tbl_hoadon(id_khachhang, ma_gh, trang_thai, cart_date, cart_payment, cart_shipping) 
                VALUES ('$id_khachhang', '$ma_gh', 1, '$now', '$cart_payment', '$id_shipping')";
    $cart_query = mysqli_query($mysqli, $insert_cart);
    if (!$cart_query) {
        error_log("SQL Error in tbl_hoadon insert: " . mysqli_error($mysqli), 3, $logFilePath);
    }
    
    // Insert each product into tbl_chitiet_gh
    foreach ($_SESSION['cart'] as $key => $value) {
      $id_sp = $value['id'];
      $so_luong = $value['so_luong'];
      $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh, id_sp, so_luong_mua) 
                              VALUES ('$ma_gh', '$id_sp', '$so_luong')";
      mysqli_query($mysqli, $insert_order_details);

      // Update stock
      $update_stock = "UPDATE tbl_sanpham SET so_luong_con_lai = so_luong_con_lai - $so_luong WHERE id_sp = $id_sp";
      mysqli_query($mysqli, $update_stock);
    }
    header('Location:../../index.php?quanly=camon');
} elseif ($cart_payment === 'vnpay') {
  //thanh toan vnpay
  $vnp_TxnRef = $ma_gh; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang vnpay
  $vnp_OrderInfo = 'Thanh toán đơn hàng';
  $vnp_OrderType = 'billpayment';
  $vnp_Amount = $tong_tien * 100;
  $vnp_Locale = 'vn';
  $vnp_BankCode = 'NCB';
  $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
  //Add Params of 2.0.1 Version
  $vnp_ExpireDate = $expire;

  $inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate" => $vnp_ExpireDate

  );

  if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
  }
  // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
  //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
  // }

  //var_dump($inputData);
  ksort($inputData);
  $query = "";
  $i = 0;
  $hashdata = "";
  foreach ($inputData as $key => $value) {
    if ($i == 1) {
      $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
      $hashdata .= urlencode($key) . "=" . urlencode($value);
      $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
  }

  $vnp_Url = $vnp_Url . "?" . $query;
  if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
  }
  $returnData = array(
    'code' => '00',
    'message' => 'success',
    'data' => $vnp_Url
  );
  if (isset($_POST['thanhToan'])) {
    // $insert_cart = "INSERT INTO tbl_hoadon(id_khachhang,ma_gh,trang_thai,cart_date) VALUE('" . $id_khachhang . "','" . $ma_gh . "',1,'" . $now . "')";
    // $cart_query = mysqli_query($mysqli, $insert_cart);
    // // add gio hang chi tiet
    // foreach ($_SESSION['cart'] as $key => $value) {
    //   $id_sp = $value['id'];
    //   $so_luong = $value['so_luong'];
    //   $thanhtien = $so_luong * $value['gia_sp'];
    //   $tong_tien += $thanhtien;
    //   $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua) VALUE('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "')";
    //   mysqli_query($mysqli, $insert_order_details);
    //   // cap nhat so luong san pham
    //   $update_stock = "UPDATE tbl_sanpham SET so_luong_con_lai = so_luong_con_lai - $so_luong WHERE id_sp = $id_sp";
    //   mysqli_query($mysqli, $update_stock);
    // }
    // unset($_SESSION['cart']);
    $_SESSION['code_cart'] = $ma_gh;
    echo '!!!';
    header('Location: ' . $vnp_Url);
    die();
  } else {
    echo json_encode($returnData);
  }
} 

$logFilePath = __DIR__ . '/php-email-error.log';

$tong_tien = 0; // Initialize total amount

foreach ($_SESSION['cart'] as $key => $value) {
  $thanhtien = $value['so_luong'] * $value['gia_sp'];
  $tong_tien += $thanhtien;
  error_log('Product ID: ' . $value['id'] . ', Quantity: ' . $value['so_luong'] . ', Subtotal: ' . $thanhtien, 3, $logFilePath);
}

// Gửi email xác nhận đơn hàng qua Brevo
$apiKey = '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';
$url = 'https://api.brevo.com/v3/smtp/email';

$tieude = "Đặt hàng website 7TCC thành công!";

$noidung = "
<div style='font-family: Arial, sans-serif; color: #333;'>
    <div style='background-color: #e60000; padding: 20px; text-align: center; color: #fff;'>
        <h2>7TCC - Xác nhận đơn hàng</h2>
    </div>
    <p>Chào " . $_SESSION['ten_khachhang'] . ",</p>
    <p>Cảm ơn bạn đã đặt hàng với mã đơn hàng: <strong>" . $ma_gh . "</strong>.</p>
    <h4 style='color: #e60000;'>Chi tiết đơn hàng:</h4>
    <table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>
        <thead>
            <tr style='background-color: #f8f8f8;'>
                <th style='border: 1px solid #ddd; padding: 8px;'>Tên sản phẩm</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Mã sản phẩm</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Giá</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Số lượng</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Thành tiền</th>
            </tr>
        </thead>
        <tbody>";

// Thêm các sản phẩm vào email
$tong_tien = 0;
foreach ($_SESSION['cart'] as $item) {
    $ten_sp = $item['ten_sp'];
    $ma_sp = $item['ma_sp'];
    $gia_sp = number_format($item['gia_sp'], 0, ',', ',') . " VND";
    $so_luong = $item['so_luong'];
    $thanhtien = number_format($so_luong * $item['gia_sp'], 0, ',', ',') . " VND";
    $tong_tien += $so_luong * $item['gia_sp'];

    $noidung .= "
        <tr>
            <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>$ten_sp</td>
            <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>$ma_sp</td>
            <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>$gia_sp</td>
            <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>$so_luong</td>
            <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>$thanhtien</td>
        </tr>";
}

// Tổng tiền của đơn hàng
$noidung .= "
        </tbody>
    </table>
    <h4 style='text-align: right; color: #e60000; margin-top: 10px;'>Tổng tiền: " . number_format($tong_tien, 0, ',', '.') . " VND</h4>
    <p>Chúng tôi sẽ liên hệ để xác nhận và giao hàng trong thời gian sớm nhất. Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ.</p>
    <p>Trân trọng,<br>Đội ngũ 7TCC</p>
    <div style='background-color: #f8f8f8; padding: 10px; text-align: center; font-size: 12px; color: #555;'>
        <p>7TCC - Địa chỉ liên hệ: 123 Đường ABC, TP. XYZ</p>
        <p>Email: support@7tcc.vn | Hotline: 0123 456 789</p>
    </div>
</div>";

// Chuẩn bị dữ liệu email
$emailData = [
    'sender' => [
        'name' => '7TCC Team',
        'email' => 'zaikaman123@gmail.com'
    ],
    'to' => [
        [
            'email' => $_SESSION['email'],
            'name' => $_SESSION['ten_khachhang']
        ]
    ],
    'subject' => $tieude,
    'htmlContent' => $noidung
];

// Cấu hình cURL để gửi email
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'api-key: ' . $config['apiKey'],
    'content-type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));

// Gửi email
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// Log curl errors
if ($curlError) {
  error_log('cURL Error: ' . $curlError, 3, $logFilePath);
} else {
  if ($httpCode != 201 && $httpCode != 200) {
      error_log('Failed to send email. HTTP Response Code: ' . $httpCode, 3, $logFilePath);
      error_log('Response: ' . $response, 3, $logFilePath);
  } else {
      error_log('Email sent successfully.', 3, $logFilePath);
  }
}

error_log(print_r($_SESSION['cart'], true), 3, $logFilePath);

if ($httpCode == 201 || $httpCode == 200) {
  unset($_SESSION['cart']); 
}

// Redirect to thank you page
header('Location:../../index.php?quanly=camon');
