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
        // Sử dụng env helper nếu có, nếu không dùng default
        if (function_exists('env')) {
            return [
                'host' => env('MAIL_HOST', 'smtp.gmail.com'),
                'username' => env('MAIL_USERNAME', 'luutrithon1996@gmail.com'),
                'password' => env('MAIL_PASSWORD', 'xwxx lyju spew lpvg'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'from_address' => env('MAIL_FROM_ADDRESS', 'luutrithon1996@gmail.com'),
                'from_name' => env('MAIL_FROM_NAME', '7TCC Store')
            ];
        } else {
            return [
                'host' => 'smtp.gmail.com',
                'username' => 'luutrithon1996@gmail.com',
                'password' => 'xwxx lyju spew lpvg',
                'port' => 587,
                'encryption' => 'tls',
                'from_address' => 'luutrithon1996@gmail.com',
                'from_name' => '7TCC Store'
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
        $mail->Port = $config['port'];
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
            $mail->addAddress($maildathang,'Wolfdabest'); //Add a recipient
            $mail->addAddress('nnt090904@gmail.com'); //Name is optional 
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
}
?>
