<div class="main_content">
    <div style="width : 100%; display : flex; flex-direction : column; justify-content : center; align-items : center">
        <h4 style="margin-bottom : 5px; font-size : 18px">Cảm ơn bạn đã mua hàng, chúng tôi sẽ liên hệ trong thời gian sớm nhất</h4>
        <img style="margin-top: 0px;" src="../images/camon.png" alt="EmtpyCart" width="200px" height="200px">
        <a style="font-size: 13px; font-weight : 400; color : blue; text-decoration : underline;" href="index.php?">Quay lại trang chủ</a>
    </div>
</div>
<?php

include('admincp/config/config.php');
require('Carbon-3.8.0/autoload.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$now = Carbon::now('Asia/Ho_Chi_Minh');
if (isset($_GET['partnerCode'])) {
    $id_khachhang = $_SESSION['id_khachhang'];
    $code_order = rand(0, 9999);

    //lay id thong tin van chuyen
    $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_dangky' LIMIT 1");
    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
    $id_shipping = $row_get_vanchuyen['id_shipping'];

    $partnerCode = $_GET['partnerCode'];
    $orderId = $_GET['orderId'];
    $amount = $_GET['amount'];
    $orderInfo = $_GET['orderInfo'];
    $orderType = $_GET['orderType'];
    $transId = $_GET['transId'];
    $payType = $_GET['payType'];
    $cart_payment = 'momo';

    //insert database momo
    $insert_momo = "INSERT INTO tbl_momo (partner_code,order_id,amount,order_info,order_type,trans_id,pay_type,code_cart) VALUES ('" . $partnerCode . "','" . $orderId . "','" . $amount . "','" . $orderInfo . "','" . $orderType . "','" . $transId . "','" . $payType . "','" . $code_order . "')";
    $cart_query = mysqli_query($mysqli, $insert_momo);
    if ($cart_query) {
        $insert_cart = "INSERT INTO tbl_hoadon(id_khachhang,ma_gh,trang_thai,cart_date,cart_payment,cart_shipping) VALUES('" . $id_khachhang . "','" . $ma_gh . "',1,'" . $now . "','" . $cart_payment . "','" . $id_shipping . "')";
        $cart_query = mysqli_query($mysqli, $insert_cart);
        // add gio hang chi tiet
        //insert gio hang
        foreach ($_SESSION['cart'] as $key => $value) {
            $id_sp = $value['id'];
            $so_luong = $value['so_luong'];
            $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua) VALUES('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "')";
            mysqli_query($mysqli, $insert_order_details);
        }
        echo '<h3>Giao dịch thanh toán bằng MOMO thành công!</h3>';
        echo '<p>Vui lòng vào trang <a target = "_blank" href = "http://localhost/DeAnCNPM-main/WebBanHang/index.php?quanly=donHangDaDat">Lịch sử đơn hàng</a> để xem chi tiết đơn hàng của bạn</p>';
    } else {
        echo 'Giao dịch MOMO thất bại';
    }
    unset($_SESSION['cart']);
} else if (isset($_GET['vnp_Amount'])) {
    $vnp_Amount = $_GET['vnp_Amount'];
    $vnp_BankCode = $_GET['vnp_BankCode'];
    $vnp_BankTranNo = $_GET['vnp_BankTranNo'];
    $vnp_CardType = $_GET['vnp_CardType'];
    $vnp_OrderInfo = $_GET['vnp_OrderInfo'];
    $vnp_PayDate = $_GET['vnp_PayDate'];
    $vnp_TmnCode = $_GET['vnp_TmnCode'];
    $vnp_TransactionNo = $_GET['vnp_TransactionNo'];
    $code_cart = $_SESSION['code_cart'];
    $insert_vnpay = "INSERT INTO tbl_vnpay(vnp_amount, vnp_bankcode, vnp_banktranno, vnp_cardtype, vnp_orderinfo, vnp_paydate, vnp_tmncode, vnp_transactionno,code_cart) 
                    VALUE ('$vnp_Amount', '$vnp_BankCode', '$vnp_BankTranNo', '$vnp_CardType', '$vnp_OrderInfo', '$vnp_PayDate', '$vnp_TmnCode', '$vnp_TransactionNo','$code_cart')";
    $cart_query = mysqli_query($mysqli, $insert_vnpay);
    if ($cart_query) {
        echo '<h3>Giao dịch thanh toán bằng VNPAY thành công</h3>';
        echo '<p>Vui lòng vào trang cá nhân <a target="_blank" href="#">lịch sử đơn hàng</a> để xem chi tiết đơn hàng của bạn</p>';
    } else {
        echo 'Giao dịch thất bại';
        return;
    }
}
$tong_tien = 0; // Initialize total amount

foreach ($_SESSION['cart'] as $key => $value) {
  $thanhtien = $value['so_luong'] * $value['gia_sp'];
  $tong_tien += $thanhtien;
  error_log('Product ID: ' . $value['id'] . ', Quantity: ' . $value['so_luong'] . ', Subtotal: ' . $thanhtien, 3, $logFilePath);
}

// Gửi email xác nhận đơn hàng qua Brevo
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
?>
