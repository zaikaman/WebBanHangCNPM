<?php
include('admincp/config/config.php');
require('Carbon-3.8.0/autoload.php');
require('mail/sendmail.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$id_khachhang = $_SESSION['id_khachhang'];
$now = Carbon::now('Asia/Ho_Chi_Minh');

// Biến để kiểm tra trạng thái thanh toán
$payment_success = false;
$payment_message = '';

if (isset($_GET['partnerCode'])) {
    // Xử lý callback từ MoMo
    $resultCode = isset($_GET['resultCode']) ? $_GET['resultCode'] : '-1';
    
    // resultCode = 0 nghĩa là giao dịch thành công
    if ($resultCode != '0') {
        $payment_success = false;
        $payment_message = 'Giao dịch MoMo thất bại hoặc bị hủy. Mã lỗi: ' . $resultCode;
        error_log('MoMo Payment Failed - resultCode: ' . $resultCode . ' - orderId: ' . ($_GET['orderId'] ?? 'N/A'), 3, __DIR__ . '/payment-error.log');
    } else {
        $payment_success = true;
        
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
                $gia_mua = $value['gia_sp']; // Giá đã bao gồm khuyến mãi nếu có
                $insert_order_details = "INSERT INTO tbl_chitiet_gh(ma_gh,id_sp,so_luong_mua,size,gia_mua) VALUES('" . $ma_gh . "','" . $id_sp . "','" . $so_luong . "','" . $size . "','" . $gia_mua . "')";
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
            
            $payment_message = 'Thanh toán MoMo thành công!';
        } else {
            $payment_success = false;
            $payment_message = 'Giao dịch MOMO thất bại';
            error_log('MoMo DB Insert Failed - orderId: ' . $orderId, 3, __DIR__ . '/payment-error.log');
        }
        
        // Chỉ xóa cart sau khi đã xử lý thành công
        if ($payment_success) {
            unset($_SESSION['cart']);
        }
    }
} else {
    // Không có thông tin thanh toán - có thể là thanh toán tiền mặt hoặc chuyển khoản
    $payment_success = true;
    $payment_message = 'Cảm ơn bạn đã mua hàng!';
}
?>

<div class="main_content">
    <div style="width : 100%; display : flex; flex-direction : column; justify-content : center; align-items : center">
        <?php if ($payment_success): ?>
            <h4 style="margin-bottom : 5px; font-size : 18px; color: #28a745;"><?php echo $payment_message; ?></h4>
            <p style="font-size: 14px; margin-bottom: 10px;">Chúng tôi sẽ liên hệ trong thời gian sớm nhất</p>
            <img style="margin-top: 0px;" src="images/camon.png" alt="ThankYou" width="200px" height="200px">
        <?php else: ?>
            <h4 style="margin-bottom : 5px; font-size : 18px; color: #dc3545;"><?php echo $payment_message; ?></h4>
            <p style="font-size: 14px; margin-bottom: 10px;">Vui lòng thử lại hoặc chọn phương thức thanh toán khác</p>
            <a style="font-size: 13px; font-weight : 400; color : blue; text-decoration : underline; margin-top: 10px;" href="index.php?quanly=giohang">Quay lại giỏ hàng</a>
        <?php endif; ?>
        <a style="font-size: 13px; font-weight : 400; color : blue; text-decoration : underline; margin-top: 5px;" href="index.php?">Quay lại trang chủ</a>
    </div>
</div>
