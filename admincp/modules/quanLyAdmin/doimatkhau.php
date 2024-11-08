<?php
include("config/config.php");

// Initialize variables for error message
$error_message = '';
$success_message = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the admin's current password
    $sql_sua_danhmucbv = "SELECT * FROM tbl_admin WHERE id_ad='$_GET[id]' LIMIT 1";
    $sua_danhmucbv = mysqli_query($mysqli, $sql_sua_danhmucbv);
    // Get the old and new passwords from the form
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $id_admin = $_GET['id'];

    // Validate new password length
    if (strlen($new_password) <= 3 || strlen($new_password) > 20) {
        $error_message = "Mật khẩu mới phải có độ dài từ 4 đến 20 ký tự.";
    } else {
        // Fetch the current admin's information
        $admin = mysqli_fetch_array($sua_danhmucbv);

        // Check if the old password is correct
        if (md5($old_password) === $admin['password']) {
            // Hash the new password
            $hashed_new_password = md5($new_password);

            // Update the password in the database
            $sql_update_password = "UPDATE tbl_admin SET password='$hashed_new_password' WHERE id_ad='$id_admin'";
            if (mysqli_query($mysqli, $sql_update_password)) {
                $success_message = "Mật khẩu đã được thay đổi thành công.";
            } else {
                $error_message = "Có lỗi xảy ra khi thay đổi mật khẩu.";
            }
        } else {
            $error_message = "Mật khẩu cũ không đúng.";
        }
    }
}
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Đổi mật khẩu</h3>

    <!-- Display error or success messages -->
    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <?php if (!empty($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } ?>

    <?php
    $sql_sua_danhmucbv = "SELECT * FROM tbl_admin WHERE id_ad='$_GET[id]' LIMIT 1";
    $sua_danhmucbv = mysqli_query($mysqli, $sql_sua_danhmucbv);
    while ($dong = mysqli_fetch_array($sua_danhmucbv)) { ?>
        <!-- The form is moved outside the password check -->
        <form method="POST" action="" onsubmit="return validatePassword()">
            <div class="mb-3">
                <label for="old_password" class="form-label">Mật khẩu cũ :</label>
                <input type="password" class="form-control" id="old_password" name="old_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới :</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <div class="form-text">Mật khẩu phải có độ dài từ 4 đến 20 ký tự.</div>
            </div>
            <button type="submit" name="suaTen" class="btn btn-primary">Sửa</button>
            <a href="index.php?action=quanLyAdmin&query=them" class="btn btn-primary">Quay lại</a>
        </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validatePassword() {
    const newPassword = document.getElementById('new_password').value;
    if (newPassword.length <= 3 || newPassword.length > 20) {
        alert('Mật khẩu mới phải có độ dài từ 4 đến 20 ký tự.');
        return false;
    }
    return true;
}
</script>