<?php
if (isset($_POST['doiMatKhau'])) {
    $taikhoan = $_POST['email'];
    $mat_khau_cu = md5($_POST['mat_khau_cu']);
    $mat_khau_moi = md5($_POST['mat_khau_moi']);
    $sql = "SELECT * FROM tbl_dangky WHERE email = '" . $taikhoan . "' AND mat_khau = '" . $mat_khau_cu . "' LIMIT 1 ";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count > 0) {
        $old_email_password = true;
        $sql_query = mysqli_query($mysqli, "UPDATE tbl_dangky SET mat_khau = '" . $mat_khau_moi . "' WHERE email='" . $taikhoan . "'");
        echo "<script>window.location.href='index.php?quanly=doimatkhau&changepassword=1';</script>";
    } else {
        echo "<script>window.location.href='index.php?quanly=doimatkhau&changepassword=0';</script>";
    }
}
?>
<div class="main_content">
    <div class="login_container">
        <p style="font-weight: bold; font-size : 20px; margin : 20px 0 20px 0;">Đổi mật khẩu</p>
        <form action="" method="POST" class="login_content">
            <div class="register_input_box">
                <label for="email">Tài khoản :</label>
                <input type="text" name="email">
            </div>
            <div class="register_input_box">
                <label for="mat_khau_cu">Mật khẩu cũ :</label>
                <input type="text" name="mat_khau_cu">
            </div>
            <div class="register_input_box">
                <label for="mat_khau_moi">Mật khẩu mới :</label>
                <input type="text" name="mat_khau_moi">
            </div>
            <input class="login_form_btn" style="margin-bottom : 20px;" type="submit" name="doiMatKhau" value="Đổi mật khẩu">
            <?php if (isset($_GET['changepassword'])) {
                if ($_GET['changepassword']) { ?>
                    <div id="login_fail" style="display : flex; width : 100%; color :red; padding : 4px 8px; justify-content : center; align-items : center;">Tài khoản hoặc mật khẩu cũ không đúng !!!</div>
            <?php }
            } ?>
        </form>
    </div>
    <!-- <form action="" autocomplete="off" method="POST">
        <table border="1" class="table_login" style="text-align: center; border-collapse: collapse;">
            <tr>
                <td colspan="2">
                    <h3>Doi mat khau</h3>
                </td>
            </tr>
            <tr>
                <td>Tài Khoản</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td>Mật Khẩu Cu</td>
                <td><input type="text" name="mat_khau_cu"></td>
            </tr>
            <tr>
                <td>Mật Khẩu Moi</td>
                <td><input type="text" name="mat_khau_moi"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="Submit" name="doiMatKhau" value="Doi mat khau"></td>
            </tr>
        </table>
    </form> -->
</div>