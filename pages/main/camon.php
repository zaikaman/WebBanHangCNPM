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
        // $insert_cart = "INSERT INTO tbl_giohang(id_khachhang,ma_gh,trang_thai,cart_date,cart_payment,cart_shipping) VALUES('" . $id_khachhang . "','" . $ma_gh . "',1,'" . $now . "','" . $cart_payment . "','" . $id_shipping . "')";
        // $cart_query = mysqli_query($mysqli, $insert_cart);
        // // add gio hang chi tiet
        // //insert gio hang
        // foreach ($_SESSION['cart'] as $key => $value) {
        //     $id_sp = $value['id'];
        //     $so_luong = $value['so_luong'];
        //     $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua) VALUES('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "')";
        //     mysqli_query($mysqli, $insert_order_details);
        // }
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
    unset($_SESSION['cart']);
}
?>