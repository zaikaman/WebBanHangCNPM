<?php
// Không cần include config và sendmail ở đây vì nó sẽ được include trong file index.php gốc

$message = '';

if (isset($_POST['submit_email'])) {
    // Include các file cần thiết
    require_once 'admincp/config/config.php';
    require_once 'mail/sendmail.php';

    $email = $_POST['email'];

    // Check if email exists
    $sql = "SELECT * FROM tbl_dangky WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        
        // Set token expiration to 15 minutes from now
        $expires = new DateTime('now');
        $expires->add(new DateInterval('PT15M'));
        $expiry_time = $expires->format('Y-m-d H:i:s');

        // Store token in the database
        $sql_update = "UPDATE tbl_dangky SET reset_token = ?, reset_token_expires = ? WHERE email = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param("sss", $token, $expiry_time, $email);
        
        if ($stmt_update->execute()) {
            // Send email
            $mailer = new Mailer();
            if ($mailer->sendPasswordResetEmail($email, $user['ten_khachhang'], $token)) {
                $message = "<div class='alert alert-success'>Nếu email tồn tại trong hệ thống, bạn sẽ nhận được một liên kết để đặt lại mật khẩu. Vui lòng kiểm tra hộp thư của bạn.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Không thể gửi email. Vui lòng thử lại sau.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Đã xảy ra lỗi. Vui lòng thử lại.</div>";
        }
    } else {
        // For security, show the same message whether the email exists or not
        $message = "<div class='alert alert-success'>Nếu email tồn tại trong hệ thống, bạn sẽ nhận được một liên kết để đặt lại mật khẩu. Vui lòng kiểm tra hộp thư của bạn.</div>";
    }
    $stmt->close();
    $mysqli->close();
}
?>

<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="card mx-auto" style="max-width: 700px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <div class="card-body" style="padding: 40px;">
            <h3 class="card-title text-center" style="font-weight: bold; margin-bottom: 20px;">Quên Mật Khẩu</h3>
            <p class="card-text text-center text-muted" style="margin-bottom: 30px;">Vui lòng nhập địa chỉ email của bạn. Chúng tôi sẽ gửi một liên kết để đặt lại mật khẩu.</p>
            
            <?php echo $message; ?>

            <form method="POST" id="forgotPasswordForm">
                <div class="form-group" style="display: block !important; width: 100% !important; text-align: center;">
                    <label for="email" style="font-weight: 600; margin-bottom: 10px; width: 100% !important; text-align: center !important;">Địa chỉ email:</label>
                    <div class="input-group" style="margin: 0 auto; max-width: 450px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><ion-icon name="mail-outline"></ion-icon></span>
                        </div>
                        <input type="email" id="email" class="form-control" name="email" required placeholder="your.email@example.com">
                    </div>
                </div>
                <button class="btn btn-danger btn-block" type="submit" name="submit_email" style="margin-top: 30px; border-radius: 8px; padding: 12px; max-width: 450px; margin-left: auto; margin-right: auto;">Gửi liên kết đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
</div>

<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>