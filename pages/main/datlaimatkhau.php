<?php
// Không cần include config ở đây vì nó sẽ được include trong file index.php gốc

$message = '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$show_form = false;

if (empty($token)) {
    $message = "<div class='alert alert-danger'>Token không hợp lệ hoặc đã hết hạn.</div>";
} else {
    // Include config chỉ khi cần thiết
    require_once 'admincp/config/config.php';

    // Validate token
    $sql = "SELECT * FROM tbl_dangky WHERE reset_token = ? AND reset_token_expires > NOW()";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $show_form = true;
        $user = $result->fetch_assoc();

        if (isset($_POST['reset_password'])) {
            $password = $_POST['mat_khau'];
            $password_confirm = $_POST['mat_khau_nhaplai'];

            if (strlen($password) < 6) {
                $message = "<div class='alert alert-danger'>Mật khẩu phải có ít nhất 6 ký tự.</div>";
            } elseif ($password !== $password_confirm) {
                $message = "<div class='alert alert-danger'>Mật khẩu không khớp. Vui lòng thử lại.</div>";
            } else {
                // Update password
                $hashed_password = md5($password);
                $sql_update = "UPDATE tbl_dangky SET mat_khau = ?, reset_token = NULL, reset_token_expires = NULL WHERE id_dangky = ?";
                $stmt_update = $mysqli->prepare($sql_update);
                $stmt_update->bind_param("si", $hashed_password, $user['id_dangky']);

                if ($stmt_update->execute()) {
                    $message = "<div class='alert alert-success'>Mật khẩu của bạn đã được cập nhật thành công. <a href='index.php?quanly=dangnhap'>Đăng nhập ngay</a>.</div>";
                    $show_form = false;
                } else {
                    $message = "<div class='alert alert-danger'>Đã xảy ra lỗi khi cập nhật mật khẩu. Vui lòng thử lại.</div>";
                }
                $stmt_update->close();
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Token không hợp lệ hoặc đã hết hạn.</div>";
    }
    $stmt->close();
}
?>
<link rel="stylesheet" type="text/css" href="css/datlaimatkhau.css?v=<?php echo time(); ?>">
<div class="main_content">
    <div class="login_container" style="max-width: 500px; margin: 0 auto;">
        <p style="font-weight: bold; font-size: 20px; margin: 20px 0 10px 0;">Đặt Lại Mật Khẩu</p>
        
        <?php echo $message; ?>

        <?php if ($show_form): ?>
        <form method="POST" action="index.php?quanly=datlaimatkhau&token=<?php echo htmlspecialchars($token); ?>" class="login_content" id="resetPasswordForm">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="input-box">
                <label>Mật khẩu mới:</label>
                <input type="password" name="mat_khau" class="password" required>
            </div>
            <div class="input-box" style="margin-top: 15px;">
                <label>Nhập lại mật khẩu mới:</label>
                <input type="password" name="mat_khau_nhaplai" class="password" required>
            </div>
            <button class="login_form_btn" type="submit" name="reset_password" style="margin-top: 20px;">Đặt lại mật khẩu</button>
        </form>
        <?php endif; ?>
    </div>
</div>