<div class="main_content">
    <div style="width : 100%; display : flex; flex-direction : column; justify-content : center; align-items : center">
        <h4 style="margin-bottom : 5px; font-size : 18px">Cảm ơn bạn đã mua hàng, chúng tôi sẽ liên hệ trong thời gian sớm nhất</h4>
        <img style="margin-top: 0px;" src="images/camon.png" alt="EmtpyCart" width="200px" height="200px">
        <a style="font-size: 13px; font-weight : 400; color : blue; text-decoration : underline;" href="index.php?">Quay lại trang chủ</a>
    </div>
</div>
<?php

include('admincp/config/config.php');
require('Carbon-3.8.0/autoload.php');
require('mail/sendmail.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$id_khachhang = $_SESSION['id_khachhang'];
$now = Carbon::now('Asia/Ho_Chi_Minh');

if (isset($_GET['partnerCode'])) {
    $id_khachhang = $_SESSION['id_khachhang'];
    
    // Sử dụng orderId từ MoMo làm mã đơn hàng chính để đảm bảo tính nhất quán
    $ma_gh = $_GET['orderId']; // Sử dụng orderId từ MoMo
    
    //lay id thong tin van chuyen
    $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_khachhang' LIMIT 1");
    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
    $id_shipping = $row_get_vanchuyen['id_shipping'] ?? 0; // Xử lý trường hợp null

    $partnerCode = $_GET['partnerCode'];
    $orderId = $_GET['orderId'];
    $amount = $_GET['amount'];
    $orderInfo = $_GET['orderInfo'];
    $orderType = $_GET['orderType'];
    $transId = $_GET['transId'];
    $payType = $_GET['payType'];
    $cart_payment = 'momo';

    //insert database momo - sử dụng cùng mã đơn hàng
    $insert_momo = "INSERT INTO tbl_momo (partner_code,order_id,amount,order_info,order_type,trans_id,pay_type,code_cart) VALUES ('" . $partnerCode . "','" . $orderId . "','" . $amount . "','" . $orderInfo . "','" . $orderType . "','" . $transId . "','" . $payType . "','" . $ma_gh . "')";
    $cart_query = mysqli_query($mysqli, $insert_momo);
    if ($cart_query) {
        $insert_cart = "INSERT INTO tbl_hoadon(id_khachhang,ma_gh,trang_thai,cart_date,cart_payment,cart_shipping) VALUES('" . $id_khachhang . "','" . $ma_gh . "',1,'" . $now . "','" . $cart_payment . "','" . $id_shipping . "')";
        $cart_query = mysqli_query($mysqli, $insert_cart);
        // add gio hang chi tiet
        //insert gio hang
        foreach ($_SESSION['cart'] as $key => $value) {
            $id_sp = $value['id'];
            $so_luong = $value['so_luong'];
            $size = isset($value['size']) ? $value['size'] : 'M';
            $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua,size) VALUES('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "','" . $size . "')";
            mysqli_query($mysqli, $insert_order_details);
            // cap nhat so luong san pham
            $update_stock = "UPDATE tbl_sanpham SET so_luong_con_lai = so_luong_con_lai - $so_luong WHERE id_sp = $id_sp";
            mysqli_query($mysqli, $update_stock);
        }

        // Gửi email xác nhận đơn hàng cho thanh toán MoMo
        if (isset($_SESSION['email']) && isset($_SESSION['cart'])) {
            try {
                $mailer = new Mailer();
                
                // Sử dụng tên mặc định nếu không có tên trong session
                $customerName = $_SESSION['ten_khachhang'] ?? 'Khách hàng';
                
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
                    $customerName,
                    $ma_gh,
                    $cartItems,
                    $tong_tien
                );

                // Log kết quả gửi email với chi tiết hơn
                error_log('MoMo Order #' . $ma_gh . ' - Email attempt: ' . json_encode([
                    'to_email' => $_SESSION['email'],
                    'customer_name' => $customerName,
                    'cart_items_count' => count($cartItems),
                    'total_amount' => $tong_tien,
                    'success' => $emailSent
                ]), 3, __DIR__ . '/momo-email.log');
                
            } catch (Exception $e) {
                error_log('MoMo Email Error: ' . $e->getMessage(), 3, __DIR__ . '/momo-email.log');
            }
        } else {
            // Log thông tin session để debug
            $sessionInfo = [
                'email' => isset($_SESSION['email']) ? $_SESSION['email'] : 'NOT_SET',
                'ten_khachhang' => isset($_SESSION['ten_khachhang']) ? $_SESSION['ten_khachhang'] : 'NOT_SET',
                'cart' => isset($_SESSION['cart']) ? 'HAS_CART' : 'NO_CART'
            ];
            error_log('MoMo Order #' . $ma_gh . ' - Missing session data: ' . json_encode($sessionInfo), 3, __DIR__ . '/momo-email.log');
        }
      
    } else {
        echo 'Giao dịch MOMO thất bại';
    }
    
    // Chỉ xóa cart sau khi đã gửi email thành công
    unset($_SESSION['cart']);
    
} else if (isset($_GET['vnp_Amount'])) {
    // Xử lý VNPay callback
    $ma_gh = $_SESSION['code_cart']; // Sử dụng code_cart đã được set từ thanhtoan.php
    
    //lay id thong tin van chuyen
    $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_khachhang' LIMIT 1");
    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
    $id_shipping = $row_get_vanchuyen['id_shipping'] ?? 0;
    
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
                    VALUES ('$vnp_Amount', '$vnp_BankCode', '$vnp_BankTranNo', '$vnp_CardType', '$vnp_OrderInfo', '$vnp_PayDate', '$vnp_TmnCode', '$vnp_TransactionNo','$code_cart')";
    $cart_query = mysqli_query($mysqli, $insert_vnpay);
    if ($cart_query) {
         $insert_cart = "INSERT INTO tbl_hoadon(id_khachhang,ma_gh,trang_thai,cart_date,cart_payment, cart_shipping) VALUES('" . $id_khachhang . "','" . $ma_gh . "',1,'" . $now . "','vnpay','" . $id_shipping . "')";
        $cart_query = mysqli_query($mysqli, $insert_cart);
        // add gio hang chi tiet
        $tong_tien = 0; // Khởi tạo biến tong_tien
        foreach ($_SESSION['cart'] as $key => $value) {
          $id_sp = $value['id'];
          $so_luong = $value['so_luong'];
          $size = isset($value['size']) ? $value['size'] : 'M';
          $thanhtien = $so_luong * $value['gia_sp'];
          $tong_tien += $thanhtien;
          $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua,size) VALUES('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "','" . $size . "')";
          mysqli_query($mysqli, $insert_order_details);
          // cap nhat so luong san pham
          $update_stock = "UPDATE tbl_sanpham SET so_luong_con_lai = so_luong_con_lai - $so_luong WHERE id_sp = $id_sp";
          mysqli_query($mysqli, $update_stock);
        }

        // Gửi email xác nhận đơn hàng cho thanh toán VNPay
        if (isset($_SESSION['email']) && isset($_SESSION['cart'])) {
            try {
                $mailer = new Mailer();
                
                // Sử dụng tên mặc định nếu không có tên trong session
                $customerName = $_SESSION['ten_khachhang'] ?? 'Khách hàng';
                
                // Chuẩn bị dữ liệu giỏ hàng để gửi email
                $cartItems = [];
                $tong_tien_email = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $cartItems[] = [
                        'ten_sp' => $item['ten_sp'],
                        'ma_sp' => $item['ma_sp'],
                        'gia_sp' => $item['gia_sp'],
                        'so_luong' => $item['so_luong']
                    ];
                    $tong_tien_email += $item['so_luong'] * $item['gia_sp'];
                }

                // Gửi email xác nhận đơn hàng
                $emailSent = $mailer->sendOrderConfirmation(
                    $_SESSION['email'],
                    $customerName,
                    $ma_gh,
                    $cartItems,
                    $tong_tien_email
                );

                // Log kết quả gửi email
                error_log('VNPay Order #' . $ma_gh . ' - Email sent: ' . ($emailSent ? 'SUCCESS' : 'FAILED') . ' to: ' . $_SESSION['email'], 3, __DIR__ . '/vnpay-email.log');
                
            } catch (Exception $e) {
                error_log('VNPay Email Error: ' . $e->getMessage(), 3, __DIR__ . '/vnpay-email.log');
            }
        } else {
            // Log thông tin session để debug
            $sessionInfo = [
                'email' => isset($_SESSION['email']) ? $_SESSION['email'] : 'NOT_SET',
                'ten_khachhang' => isset($_SESSION['ten_khachhang']) ? $_SESSION['ten_khachhang'] : 'NOT_SET',
                'cart' => isset($_SESSION['cart']) ? 'HAS_CART' : 'NO_CART'
            ];
            error_log('VNPay Order #' . $ma_gh . ' - Missing session data: ' . json_encode($sessionInfo), 3, __DIR__ . '/vnpay-email.log');
        }
        
        // unset($_SESSION['cart']);
    } else {
        echo 'Giao dịch thất bại';
        return;
    }
    unset($_SESSION['cart']);
    unset($_GET['vnp_Amount']);
}
?>
