<?php
$login_success = null;
if (isset($_POST['dangNhap'])) {
    $email = $_POST['email'];
    $mat_khau = md5($_POST['mat_khau']);
    $sql = "SELECT * FROM tbl_dangky WHERE email = '" . $email . "' AND mat_khau = '" . $mat_khau . "' LIMIT 1 ";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count > 0) {
        $row_data = mysqli_fetch_array($row);
        $login_success = true;
        $_SESSION['dang_ky'] = $row_data['ten_khachhang'];
        $_SESSION['email'] = $row_data['email'];
        $_SESSION['id_khachhang'] = $row_data['id_dangky'];
        //lay gio hang
        $sql = "SELECT * FROM tbl_giohangtam WHERE tbl_giohangtam.id_khachhang = '" . $row_data['id_dangky'] . "'"; 
        $query = mysqli_query($mysqli, $sql);

        $product = array();  // Khởi tạo mảng sản phẩm

        // Duyệt qua các sản phẩm trong giỏ hàng tạm
        while ($rows_item = mysqli_fetch_assoc($query)) {
            $id = $rows_item['id_sanpham'];
            $so_luong = $rows_item['so_luong'];

            // Lấy thông tin sản phẩm từ bảng tbl_sanpham
            $sql_product = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '" . $id . "' LIMIT 1";
            $query_product = mysqli_query($mysqli, $sql_product);
            
            if ($row = mysqli_fetch_assoc($query_product)) {
                // Thêm sản phẩm vào mảng product
                $product[] = array(
                    'ten_sp'   => $row['ten_sp'],
                    'id'       => $id,
                    'so_luong' => $so_luong,
                    'gia_sp'   => $row['gia_sp'],
                    'hinh_anh' => $row['hinh_anh'],
                    'ma_sp'    => $row['ma_sp']
                );
            }
        }

        // Lưu giỏ hàng vào session
        $_SESSION['cart'] = $product;
        // Xóa giỏ hàng tạm của khách hàng sau khi lưu vào session
        $delete_sql = "DELETE FROM tbl_giohangtam WHERE id_khachhang = '" . $row_data['id_dangky'] . "'";
        mysqli_query($mysqli, $delete_sql);
        // header('Location:../../index.php?quanly=giohang');
        echo "<script>window.location.href='index.php?';</script>";
        exit;
    } else {
        $login_success = false;
    }
}
?>
<div class="main_content">
    <div class="login_container">
        <p style="font-weight: bold; font-size : 20px; margin : 20px 0 10px 0;">Đăng nhập</p>
        <form method="POST" class="login_content" id="loginForm">
            <div class="input-box">
                <label>Email :</label>
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="text" id="email" class="email" name="email" required>
            </div>
            <div id="email_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; font-size : 14px; margin-top: 10px; align-items : center;">Email không đúng định dạng</div>
            <div class="input-box">
                <!-- <span class="icon"><ion-icon name="lock-closed"></ion-icon></span> -->
                <label>Mật khẩu :</label>
                <input type="password" id="mat_khau" name="mat_khau" class="password" required>
            </div>
            <div class="remember-forgot">
                <a href="index.php?quanly=quenmatkhau">Quên mật khẩu?</a>
            </div>
            <button class="login_form_btn" type="submit" name="dangNhap">Đăng nhập</button>
            <p>Chưa có tài khoản?<a class="registerlink" href="index.php?quanly=dangky">Đăng ký</a></p>
            <?php if ($login_success === false) { ?>
                <div id="login_fail" style="display : flex; width : 100%; color :red; padding : 4px 8px; justify-content : center; align-items : center;">Tài khoản hoặc mật khẩu không đúng !!!</div>
            <?php } ?>
        </form>
    </div>
</div>
<script>
    // VANLIDATE EMAIL
    // document.getElementById('email').addEventListener('blur', function() {
    //     var email = document.getElementById('email').value;
    //     var email_error = document.getElementById('email_error');
        
    //     // Regular expression to validate the email format
    //     var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        
    //     // Check if email matches the pattern
    //     if (!emailPattern.test(email)) {
    //         email_error.style.display = 'flex';  // Show error message
    //     } else {
    //         email_error.style.display = 'none';   // Hide error message
    //     }
    // });

    document.getElementById('loginForm').addEventListener('submit', function(event) {
        var email = document.getElementById('email').value;
        var email_error = document.getElementById('email_error');
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        // Check email again before submission
        if (!emailPattern.test(email)) {
            email_error.style.display = 'flex';  // Show error message
            event.preventDefault();  // Prevent form from submitting
        }
    });
</script>
