<?php
    // Include env helper if available
    if (file_exists(__DIR__ . '/../admincp/config/env_helper.php')) {
        require_once __DIR__ . '/../admincp/config/env_helper.php';
    }

    include "PHPMailer/src/PHPMailer.php";
    include "PHPMailer/src/Exception.php";
    include "PHPMailer/src/OAuth.php";
    //include "PHPMailer/src/OAuthTokenProvider.php";
    include "PHPMailer/src/POP3.php";
    include "PHPMailer/src/SMTP.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
class Mailer {

    private function getMailConfig() {
        // Sử dụng env helper để lấy cấu hình email
        if (function_exists('mail_config')) {
            return mail_config();
        } else {
            // Fallback nếu không có env helper
            return [
                
            ];
        }
    }

    private function setupSMTP($mail) {
        $config = $this->getMailConfig();
        
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['encryption'];
        $mail->Port = (int)$config['port'];
        $mail->CharSet = "utf8";
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );
    }

    public function dathang($tieude,$noidung, $maildathang) {
        $mail = new PHPMailer(true);
        $config = $this->getMailConfig();
        
        try{
            $this->setupSMTP($mail);
    
            //recipients
            $mail->setFrom($config['from_address'], $config['from_name']);
            $mail->addAddress($maildathang,'7TCC'); //Add a recipient
            $mail->addAddress('zaikaman123@gmail.com'); //Name is optional 
            $mail->addCC($config['from_address']);
    
            //content 
            $mail->isHTML(true);
            $mail->Subject = $tieude;
            $mail->Body = $noidung;
    
            $mail->send();
            return true;
    
        } catch(Exception $e){
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function sendVerificationEmail($email, $name, $token) {
        $mail = new PHPMailer(true);
        $config = $this->getMailConfig();
        
        try {
            $this->setupSMTP($mail);
            
            // Recipients
            $mail->setFrom($config['from_address'], $config['from_name']);
            $mail->addAddress($email, $name);
            
            // Create dynamic verification link based on APP_URL
            if (function_exists('app_url')) {
                $baseUrl = app_url();
            } else {
                $baseUrl = rtrim(getenv('APP_URL') ?: 'http://localhost/WebBanHangCNPM', '/');
            }
            $verificationLink = $baseUrl . '/pages/main/xacnhanemail.php?token=' . $token;
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Xác nhận đăng ký tài khoản - 7TCC Store';
            
            $mail->Body = $this->getVerificationEmailTemplate($name, $verificationLink);
            
            $mail->send();
            return true;
            
        } catch(Exception $e) {
            error_log('Verification Email Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function sendOrderConfirmation($email, $customerName, $orderId, $cartItems, $totalAmount) {
        $mail = new PHPMailer(true);
        $config = $this->getMailConfig();
        
        try {
            $this->setupSMTP($mail);
            
            // Recipients
            $mail->setFrom($config['from_address'], $config['from_name']);
            $mail->addAddress($email, $customerName);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Xác nhận đơn hàng - 7TCC Store';
            
            $mail->Body = $this->getOrderConfirmationTemplate($customerName, $orderId, $cartItems, $totalAmount);
            
            $mail->send();
            return true;
            
        } catch(Exception $e) {
            error_log('Order Confirmation Email Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function getOrderConfirmationTemplate($customerName, $orderId, $cartItems, $totalAmount) {
        $productRows = '';
        foreach ($cartItems as $item) {
            $productRows .= "
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>{$item['ten_sp']}</td>
                    <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>{$item['ma_sp']}</td>
                    <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>" . number_format($item['gia_sp'], 0, ',', ',') . " VND</td>
                    <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>{$item['so_luong']}</td>
                    <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>" . number_format($item['so_luong'] * $item['gia_sp'], 0, ',', ',') . " VND</td>
                </tr>";
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Xác nhận đơn hàng</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 700px; margin: 0 auto; padding: 20px; }
                .header { background: #e60000; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .order-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .order-table th { background: #f8f8f8; border: 1px solid #ddd; padding: 12px; text-align: center; }
                .order-table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                .total { text-align: right; color: #e60000; font-weight: bold; font-size: 18px; margin-top: 15px; }
                .footer { text-align: center; font-size: 12px; color: #666; margin-top: 30px; background: #f8f8f8; padding: 15px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>7TCC Store</h1>
                    <h2>Xác nhận đơn hàng</h2>
                </div>
                <div class='content'>
                    <p>Chào <strong>$customerName</strong>,</p>
                    <p>Cảm ơn bạn đã đặt hàng tại 7TCC Store! Đơn hàng của bạn đã được tiếp nhận thành công.</p>
                    <p><strong>Mã đơn hàng:</strong> $orderId</p>
                    
                    <h3 style='color: #e60000;'>Chi tiết đơn hàng:</h3>
                    <table class='order-table'>
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Mã sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            $productRows
                        </tbody>
                    </table>
                    
                    <div class='total'>
                        Tổng tiền: " . number_format($totalAmount, 0, ',', ',') . " VND
                    </div>
                    
                    <p style='margin-top: 30px;'>Chúng tôi sẽ liên hệ với bạn để xác nhận và giao hàng trong thời gian sớm nhất.</p>
                    <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua:</p>
                    <ul>
                        <li>Email: support@7tcc.vn</li>
                        <li>Hotline: 0909888888</li>
                    </ul>
                    
                    <p>Trân trọng,<br><strong>Đội ngũ 7TCC Store</strong></p>
                </div>
                <div class='footer'>
                    <p><strong>© 2024 7TCC Store - Thời trang thể thao chất lượng</strong></p>
                    <p>Địa chỉ: 273 An Dương Vương – Phường 3 – Quận 5, TP.HCM</p>
                    <p>Email: support@7tcc.vn | Hotline: 0909888888</p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getVerificationEmailTemplate($name, $verificationLink) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Xác nhận đăng ký</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #dc0521; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .button { 
                    display: inline-block; 
                    background: #dc0521; 
                    color: white !important; 
                    padding: 12px 30px; 
                    text-decoration: none; 
                    border-radius: 5px; 
                    margin: 20px 0;
                }
                .footer { text-align: center; font-size: 12px; color: #666; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>7TCC Store</h1>
                    <p>Xác nhận đăng ký tài khoản</p>
                </div>
                <div class='content'>
                    <h2>Xin chào $name,</h2>
                    <p>Cảm ơn bạn đã đăng ký tài khoản tại 7TCC Store!</p>
                    <p>Để hoàn tất quá trình đăng ký, vui lòng nhấn vào nút bên dưới để xác nhận địa chỉ email của bạn:</p>
                    
                    <center>
                        <a href='$verificationLink' class='button'>Xác nhận email</a>
                    </center>
                    
                    <p>Hoặc copy và paste đường link sau vào trình duyệt:</p>
                    <p><a href='$verificationLink'>$verificationLink</a></p>
                    
                    <p><strong>Lưu ý:</strong> Link xác nhận này có hiệu lực trong 24 giờ.</p>
                    
                    <p>Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email này.</p>
                </div>
                <div class='footer'>
                    <p>© 2024 7TCC Store - Thời trang thể thao chất lượng</p>
                    <p>Địa chỉ: 273 An Dương Vương – Phường 3 – Quận 5, TP.HCM</p>
                    <p>Hotline: 0909888888</p>
                </div>
            </div>
        </body>
        </html>";
    }

    public function sendPasswordResetEmail($email, $name, $token) {
        $mail = new PHPMailer(true);
        $config = $this->getMailConfig();
        
        try {
            $this->setupSMTP($mail);
            
            // Recipients
            $mail->setFrom($config['from_address'], $config['from_name']);
            $mail->addAddress($email, $name);
            
            // Create dynamic reset link based on APP_URL
            if (function_exists('app_url')) {
                $baseUrl = app_url();
            } else {
                $baseUrl = rtrim(getenv('APP_URL') ?: 'http://localhost/WebBanHangCNPM', '/');
            }
            $resetLink = $baseUrl . '/index.php?quanly=datlaimatkhau&token=' . $token;
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Yêu cầu đặt lại mật khẩu - 7TCC Store';
            
            $mail->Body = $this->getPasswordResetTemplate($name, $resetLink);
            
            $mail->send();
            return true;
            
        } catch(Exception $e) {
            error_log('Password Reset Email Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function getPasswordResetTemplate($name, $resetLink) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Đặt lại mật khẩu</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #dc0521; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .button { 
                    display: inline-block; 
                    background: #dc0521; 
                    color: white !important; 
                    padding: 12px 30px; 
                    text-decoration: none; 
                    border-radius: 5px; 
                    margin: 20px 0;
                }
                .footer { text-align: center; font-size: 12px; color: #666; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>7TCC Store</h1>
                    <p>Yêu cầu đặt lại mật khẩu</p>
                </div>
                <div class='content'>
                    <h2>Xin chào $name,</h2>
                    <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
                    <p>Để đặt lại mật khẩu, vui lòng nhấn vào nút bên dưới:</p>
                    
                    <center>
                        <a href='$resetLink' class='button'>Đặt lại mật khẩu</a>
                    </center>
                    
                    <p>Hoặc copy và paste đường link sau vào trình duyệt:</p>
                    <p><a href='$resetLink'>$resetLink</a></p>
                    
                    <p><strong>Lưu ý:</strong> Link này chỉ có hiệu lực trong 15 phút. Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                </div>
                <div class='footer'>
                    <p>© ".date("Y")." 7TCC Store - Thời trang thể thao chất lượng</p>
                    <p>Địa chỉ: 273 An Dương Vương – Phường 3 – Quận 5, TP.HCM</p>
                    <p>Hotline: 0909888888</p>
                </div>
            </div>
        </body>
        </html>";
    }
}
?>
