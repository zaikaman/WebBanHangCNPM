<?php
if (isset($_POST['doiMatKhau'])) {
    $id = $_SESSION['id_khachhang'];
    $id = $_SESSION['id_khachhang'];
    $mat_khau_cu = md5($_POST['mat_khau_cu']);
    $mat_khau_moi = md5($_POST['mat_khau_moi']);
    $sql = "SELECT * FROM tbl_dangky WHERE tbl_dangky.id_dangky = '" . $id . "' AND mat_khau = '" . $mat_khau_cu . "' LIMIT 1 ";
    $sql = "SELECT * FROM tbl_dangky WHERE tbl_dangky.id_dangky = '" . $id . "' AND mat_khau = '" . $mat_khau_cu . "' LIMIT 1 ";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count < 1) {
        $registration_error = "Mật khẩu cũ không đúng!";
    } else {
        mysqli_query($mysqli, "UPDATE tbl_dangky SET mat_khau = '" . $mat_khau_moi . "' WHERE tbl_dangky.id_dangky = '" . $id . "'");
    if ($count < 1) {
        $registration_error = "Mật khẩu cũ không đúng!";
    } else {
        mysqli_query($mysqli, "UPDATE tbl_dangky SET mat_khau = '" . $mat_khau_moi . "' WHERE tbl_dangky.id_dangky = '" . $id . "'");
        echo "<script>window.location.href='index.php?quanly=doimatkhau&changepassword=1';</script>";
    }
}
?>
<div class="main_content">
    <div class="login_container">
        <p style="font-weight: bold; font-size : 20px; margin : 20px 0 20px 0;">Đổi mật khẩu</p>
        <form action="" method="POST" class="login_content" id="registerForm">
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="mat_khau">Mật khẩu cũ:</label>
                    <input type="password" id="mat_khau_cu" name="mat_khau_cu">
                </div>
                <div id="mat_khau_cu_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Mật khẩu không được để trống</div>
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="mat_khau">Mật khẩu cũ:</label>
                    <input type="password" id="mat_khau_cu" name="mat_khau_cu">
                </div>
                <div id="mat_khau_cu_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Mật khẩu không được để trống</div>
            </div>
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="mat_khau_moi">Mật khẩu mới:</label>
                    <input type="password" id="mat_khau_moi" name="mat_khau_moi">
                </div>
                <div id="mat_khau_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Mật khẩu không được để trống</div>
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="mat_khau_moi">Mật khẩu mới:</label>
                    <input type="password" id="mat_khau_moi" name="mat_khau_moi">
                </div>
                <div id="mat_khau_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Mật khẩu không được để trống</div>
            </div>
            <input class="login_form_btn" style="margin-bottom : 20px;" type="submit" name="doiMatKhau" value="Đổi mật khẩu">
            <?php if (!empty($registration_error)) { ?>
                <div id="registration_error" style="display : flex; width : 100%; color :red; padding : 4px 8px; justify-content : center; align-items : center;"><?php echo $registration_error; ?></div>
            <?php } ?>
            <?php if (!empty($registration_error)) { ?>
                <div id="registration_error" style="display : flex; width : 100%; color :red; padding : 4px 8px; justify-content : center; align-items : center;"><?php echo $registration_error; ?></div>
            <?php } ?>
        </form>
    </div>
</div>


<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        var mat_khau = document.getElementById('mat_khau_moi').value;
        var mat_khau_error = document.getElementById('mat_khau_error');

        var mat_khau_cu = document.getElementById('mat_khau_cu').value;
        var mat_khau_cu_error = document.getElementById('mat_khau_cu_error');

        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
        var isValid = true;

        // kiểm tra mật khẩu cũ
        if (mat_khau_cu.trim() === '') {
            mat_khau_cu_error.textContent = 'Mật khẩu cũ không được để trống';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        }else if (mat_khau_cu.length < 6) {
            mat_khau_cu_error.textContent = 'Độ dài mật khẩu quá ngắn, vui lòng nhập ít nhất 6 ký tự';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        } else if (/\s/.test(mat_khau_cu)) {
            mat_khau_cu_error.textContent = 'Mật khẩu sai định dạng, không được có dấu cách';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        } else if (!passwordPattern.test(mat_khau_cu)) {
            mat_khau_cu_error.textContent = 'Mật khẩu phải có ít nhất 1 chữ thường, 1 chữ hoa và 1 chữ số';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        } else {
            mat_khau_cu_error.style.display = 'none';
        }

        // Kiểm tra mật khẩu mới
        if (mat_khau.trim() === '') {
            mat_khau_error.textContent = 'Mật khẩu mới không được để trống';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else if (mat_khau.length < 6) {
            mat_khau_error.textContent = 'Độ dài mật khẩu quá ngắn, vui lòng nhập ít nhất 6 ký tự';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else if (/\s/.test(mat_khau)) {
            mat_khau_error.textContent = 'Mật khẩu sai định dạng, không được có dấu cách';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else if (!passwordPattern.test(mat_khau)) {
            mat_khau_error.textContent = 'Mật khẩu phải có ít nhất 1 chữ thường, 1 chữ hoa và 1 chữ số';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else {
            mat_khau_error.style.display = 'none';
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>


<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        var mat_khau = document.getElementById('mat_khau_moi').value;
        var mat_khau_error = document.getElementById('mat_khau_error');

        var mat_khau_cu = document.getElementById('mat_khau_cu').value;
        var mat_khau_cu_error = document.getElementById('mat_khau_cu_error');

        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
        var isValid = true;

        // kiểm tra mật khẩu cũ
        if (mat_khau_cu.trim() === '') {
            mat_khau_cu_error.textContent = 'Mật khẩu cũ không được để trống';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        }else if (mat_khau_cu.length < 6) {
            mat_khau_cu_error.textContent = 'Độ dài mật khẩu quá ngắn, vui lòng nhập ít nhất 6 ký tự';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        } else if (/\s/.test(mat_khau_cu)) {
            mat_khau_cu_error.textContent = 'Mật khẩu sai định dạng, không được có dấu cách';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        } else if (!passwordPattern.test(mat_khau_cu)) {
            mat_khau_cu_error.textContent = 'Mật khẩu phải có ít nhất 1 chữ thường, 1 chữ hoa và 1 chữ số';
            mat_khau_cu_error.style.display = 'flex';
            isValid = false;
        } else {
            mat_khau_cu_error.style.display = 'none';
        }

        // Kiểm tra mật khẩu mới
        if (mat_khau.trim() === '') {
            mat_khau_error.textContent = 'Mật khẩu mới không được để trống';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else if (mat_khau.length < 6) {
            mat_khau_error.textContent = 'Độ dài mật khẩu quá ngắn, vui lòng nhập ít nhất 6 ký tự';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else if (/\s/.test(mat_khau)) {
            mat_khau_error.textContent = 'Mật khẩu sai định dạng, không được có dấu cách';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else if (!passwordPattern.test(mat_khau)) {
            mat_khau_error.textContent = 'Mật khẩu phải có ít nhất 1 chữ thường, 1 chữ hoa và 1 chữ số';
            mat_khau_error.style.display = 'flex';
            isValid = false;
        } else {
            mat_khau_error.style.display = 'none';
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>