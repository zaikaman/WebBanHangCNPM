
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
    $insert_cart = "INSERT INTO tbl_hoadon(id_khachhang,ma_gh,trang_thai,cart_date) VALUE('" . $id_khachhang . "','" . $ma_gh . "',1,'" . $now . "')";
    $cart_query = mysqli_query($mysqli, $insert_cart);
    // add gio hang chi tiet
    foreach ($_SESSION['cart'] as $key => $value) {
      $id_sp = $value['id'];
      $so_luong = $value['so_luong'];
      $thanhtien = $so_luong * $value['gia_sp'];
      $tong_tien += $thanhtien;
      $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua) VALUE('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "')";
      mysqli_query($mysqli, $insert_order_details);
      // cap nhat so luong san pham
      $update_stock = "UPDATE tbl_sanpham SET so_luong_con_lai = so_luong_con_lai - $so_luong WHERE id_sp = $id_sp";
      mysqli_query($mysqli, $update_stock);
    }
    $_SESSION['code_cart'] = $ma_gh;
    echo '!!!';
    header('Location: ' . $vnp_Url);
    die();
  } else {
    echo json_encode($returnData);
  }
} 

// Redirect to thank you page
header('Location:../../index.php?quanly=camon');
