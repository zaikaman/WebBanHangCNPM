
<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die('Giỏ hàng rỗng.');
}
include('../../admincp/config/config.php');
require('../../Carbon-3.8.0/autoload.php');
require('../../mail/sendmail.php');
require_once('config_vnpay.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$logFilePath = __DIR__ . '/cart-error.log'; // Define log file path

// ===== PHẦN LƯU THÔNG TIN VẬN CHUYỂN =====
// Kiểm tra và lưu thông tin vận chuyển từ form
$id_khachhang = $_SESSION['id_khachhang'];
if (isset($_POST['shipping_name']) && isset($_POST['shipping_phone']) && isset($_POST['shipping_address'])) {
    $shipping_name = mysqli_real_escape_string($mysqli, $_POST['shipping_name']);
    $shipping_phone = mysqli_real_escape_string($mysqli, $_POST['shipping_phone']);
    $shipping_address = mysqli_real_escape_string($mysqli, $_POST['shipping_address']);
    $shipping_note = isset($_POST['shipping_note']) ? mysqli_real_escape_string($mysqli, $_POST['shipping_note']) : '';
    
    // Kiểm tra xem đã có record vận chuyển chưa
    $check_shipping = mysqli_query($mysqli, "SELECT id_shipping FROM tbl_giaohang WHERE id_dangky='$id_khachhang' LIMIT 1");
    $count_shipping = mysqli_num_rows($check_shipping);
    
    if ($count_shipping > 0) {
        // Cập nhật thông tin vận chuyển
        $update_shipping = "UPDATE tbl_giaohang SET name='$shipping_name', phone='$shipping_phone', address='$shipping_address', note='$shipping_note' WHERE id_dangky='$id_khachhang'";
        mysqli_query($mysqli, $update_shipping);
    } else {
        // Thêm thông tin vận chuyển mới
        $insert_shipping = "INSERT INTO tbl_giaohang(name, phone, address, note, id_dangky) VALUES ('$shipping_name', '$shipping_phone', '$shipping_address', '$shipping_note', '$id_khachhang')";
        mysqli_query($mysqli, $insert_shipping);
    }
}
// ===== END: PHẦN LƯU THÔNG TIN VẬN CHUYỂN =====

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

// foreach ($_SESSION['cart'] as $key => $value) {
//   $thanhtien = $value['so_luong'] * $value['gia_sp'];
//   $tong_tien += $thanhtien;
//   error_log('Product ID: ' . $value['id'] . ', Quantity: ' . $value['so_luong'] . ', Subtotal: ' . $thanhtien, 3, $logFilePath);
// }

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
      $size = isset($value['size']) ? $value['size'] : 'M';
      $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh, id_sp, so_luong_mua, size) 
                              VALUES ('$ma_gh', '$id_sp', '$so_luong', '$size')";
      mysqli_query($mysqli, $insert_order_details);

      // --- START: New stock update logic ---

      // 1. Update the specific size's stock in tbl_sanpham_sizes
      $update_size_stock_sql = "UPDATE tbl_sanpham_sizes SET so_luong = so_luong - ? WHERE id_sp = ? AND size = ?";
      $stmt_size = mysqli_prepare($mysqli, $update_size_stock_sql);
      mysqli_stmt_bind_param($stmt_size, "iis", $so_luong, $id_sp, $size);
      mysqli_stmt_execute($stmt_size);
      mysqli_stmt_close($stmt_size);

      // 2. Update the total stock in tbl_sanpham (for consistency)
      $update_total_stock_sql = "UPDATE tbl_sanpham SET so_luong_con_lai = so_luong_con_lai - ? WHERE id_sp = ?";
      $stmt_total = mysqli_prepare($mysqli, $update_total_stock_sql);
      mysqli_stmt_bind_param($stmt_total, "ii", $so_luong, $id_sp);
      mysqli_stmt_execute($stmt_total);
      mysqli_stmt_close($stmt_total);
      
      // --- END: New stock update logic ---
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

// Gửi email xác nhận đơn hàng qua PHPMailer
$mailer = new Mailer();

// Chuẩn bị dữ liệu giỏ hàng để gửi email
$cartItems = [];
$tong_tien = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartItems[] = [
        'ten_sp' => $item['ten_sp'],
        'ma_sp' => $item['ma_sp'],
        'gia_sp' => $item['gia_sp'],
        'so_luong' => $item['so_luong']
    ];
    $tong_tien += $item['so_luong'] * $item['gia_sp'];
}

// Gửi email xác nhận đơn hàng
$emailSent = $mailer->sendOrderConfirmation(
    $_SESSION['email'],
    $_SESSION['ten_khachhang'],
    $ma_gh,
    $cartItems,
    $tong_tien
);

// Log kết quả gửi email
if ($emailSent) {
    error_log('Order confirmation email sent successfully to: ' . $_SESSION['email'], 3, $logFilePath);
    unset($_SESSION['cart']); // Chỉ xóa giỏ hàng khi email gửi thành công
} else {
    error_log('Failed to send order confirmation email to: ' . $_SESSION['email'], 3, $logFilePath);
    // Vẫn xóa giỏ hàng nhưng ghi log lỗi
    unset($_SESSION['cart']);
}

error_log(print_r($cartItems, true), 3, $logFilePath);

// Redirect to thank you page
header('Location:../../index.php?quanly=camon');
