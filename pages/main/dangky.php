<div class="main_content">
    <?php
    // Include Mailer class for email sending
    require_once(__DIR__ . '/../../mail/sendmail.php');
    $registration_error = '';
    $registration_success = '';

    if (isset($_POST['dang_ky'])) {
        $ten_khachhang = $_POST['ten_khachhang'];
        $email = $_POST['email'];
        $dien_thoai = $_POST['dien_thoai'];
        $mat_khau = $_POST['mat_khau'];
        $dia_chi = $_POST['dia_chi'];

        // Database connection assumed as $mysqli
        $check_email_query = mysqli_query($mysqli, "SELECT * FROM tbl_dangky WHERE email = '$email'");
        if (mysqli_num_rows($check_email_query) > 0) {
            $registration_error = "Email đã tồn tại, vui lòng sử dụng email khác!";
        } elseif (!preg_match("/^[A-Za-zÀ-ỹ]+ [A-Za-zÀ-ỹ\s]+$/u", $ten_khachhang)) {
            $registration_error = "Họ và tên sai định dạng!";
        } elseif (strlen($mat_khau) < 6) {
            $registration_error = "Độ dài mật khẩu quá ngắn!";
        } elseif (preg_match("/\s/", $mat_khau)) {
            $registration_error = "Mật khẩu không được có dấu cách!";
        } elseif (!preg_match("/^0[0-9]{9,10}$/", $dien_thoai)) {
            $registration_error = "Số điện thoại sai định dạng!";
        } elseif (empty($dia_chi)) {
            $registration_error = "Địa chỉ không được để trống!";
        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $mat_khau)) {
            $registration_error = "Mật khẩu phải có ít nhất 1 chữ thường, 1 chữ hoa và 1 chữ số!";
        } else {
            // Encrypt password and generate token for email verification
            $hashed_password = md5($mat_khau);
            $token = bin2hex(random_bytes(16));

            // Save registration info in session
            $_SESSION['user_info'] = [
                'ten_khachhang' => $ten_khachhang,
                'email' => $email,
                'dien_thoai' => $dien_thoai,
                'mat_khau' => $hashed_password,
                'dia_chi' => $dia_chi,
                'token' => $token // Store token in session as well
            ];

            $created_at = date("Y-m-d H:i:s");

            // Insert email, token, created_at into tbl_xacnhanemail with verified = 0
            $insert_token_stmt = $mysqli->prepare("INSERT INTO tbl_xacnhanemail (email, token, created_at, verified) VALUES (?, ?, NOW(), 0) ON DUPLICATE KEY UPDATE token = VALUES(token), created_at = NOW(), verified = 0");
            $insert_token_stmt->bind_param("ss", $email, $token);
            $insert_token_result = $insert_token_stmt->execute();

            // Also persist registration data in temporary table so verification works across browsers
            $insert_temp_stmt = $mysqli->prepare("INSERT INTO tbl_dangky_temp (ten_khachhang, email, dien_thoai, mat_khau, dia_chi, token, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE ten_khachhang=VALUES(ten_khachhang), dien_thoai=VALUES(dien_thoai), mat_khau=VALUES(mat_khau), dia_chi=VALUES(dia_chi), token=VALUES(token), created_at=VALUES(created_at)");
            if ($insert_temp_stmt) {
                $insert_temp_stmt->bind_param("ssssss", $ten_khachhang, $email, $dien_thoai, $hashed_password, $dia_chi, $token);
                $insert_temp_result = $insert_temp_stmt->execute();
            } else {
                error_log('Không thể chuẩn bị câu lệnh chèn tbl_dangky_temp: ' . $mysqli->error);
                $insert_temp_result = false;
            }

            if ($insert_token_result) {
                // Send email using PHPMailer
                try {
                    $mailer = new Mailer();
                    $emailSent = $mailer->sendVerificationEmail($email, $ten_khachhang, $token);

                    if ($emailSent) {
                        $registration_success = "Email xác nhận đã được gửi. Vui lòng kiểm tra email để hoàn tất đăng ký!";
                    } else {
                        $registration_error = "Lỗi gửi email. Vui lòng thử lại sau.";
                        unset($_SESSION['user_info']); // Clear session if email sending fails
                    }
                } catch (Exception $e) {
                    error_log('Exception khi gửi email: ' . $e->getMessage());
                    $registration_error = "Lỗi hệ thống khi gửi email. Vui lòng thử lại sau.";
                    unset($_SESSION['user_info']);
                }
            } else {
                $registration_error = "Lỗi: Không thể lưu thông tin xác nhận email.";
            }
        }
    }
    ?>

    <div class="login_container">
        <p style="font-weight: bold; font-size : 20px; margin : 20px 0 20px 0;">Đăng ký</p>
        <form action="" method="POST" class="login_content" id="registerForm">
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="ten_khachhang">Họ và tên :</label>
                    <input type="text" id="ten_khachhang" name="ten_khachhang">
                </div>
                <div id="ten_khachhang_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Họ và tên không đúng định dạng</div>
            </div>
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="email">Email :</label>
                    <input id="email" type="text" name="email">
                </div>
                <div id="email_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start;; font-size : 14px; align-items : center;">Email không đúng định dạng</div>
            </div>
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="mat_khau">Mật khẩu :</label>
                    <input type="password" id="mat_khau" name="mat_khau">
                </div>
                <div id="mat_khau_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Mật khẩu không được để trống</div>
            </div>
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">

                    <label for="dien_thoai">Số điện thoại :</label>
                    <input type="text" id="dien_thoai" name="dien_thoai">
                </div>
                <div id="dien_thoai_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Số điện thoại không được để trống</div>
            </div>
            <div class="register_input_box">
                <div style="width : 100%; display : flex; flex-direction : row">
                    <label for="dia_chi">Địa chỉ :</label>
                    <input type="text" id="dia_chi" name="dia_chi">
                </div>
                <div id="dia_chi_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; ; font-size : 14px; align-items : center;">Địa chỉ không được để trống</div>
            </div>
            <input class="login_form_btn" type="submit" name="dang_ky" value="Đăng ký">
            <p>Đã có tài khoản?<a class="registerlink" href="index.php?quanly=dangnhap">Đăng nhập</a></p>
            <?php if (!empty($registration_error)) { ?>
                <div id="registration_error" style="display : flex; width : 100%; color :red; padding : 4px 8px; justify-content : center; align-items : center;"><?php echo $registration_error; ?></div>
            <?php } ?>
            <?php if (!empty($registration_success)) { ?>
                <div id="registration_success" style="display : flex; width : 100%; color : green; padding : 4px 8px; justify-content : center; align-items : center;"><?php echo $registration_success; ?></div>
            <?php } ?>
        </form>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        var email = document.getElementById('email').value;
        var ten_khachhang = document.getElementById('ten_khachhang').value;
        var mat_khau = document.getElementById('mat_khau').value;
        var dien_thoai = document.getElementById('dien_thoai').value;
        var dia_chi = document.getElementById('dia_chi').value;
        var email_error = document.getElementById('email_error');
        var ten_khachhang_error = document.getElementById('ten_khachhang_error');
        var mat_khau_error = document.getElementById('mat_khau_error');
        var dien_thoai_error = document.getElementById('dien_thoai_error');
        var dia_chi_error = document.getElementById('dia_chi_error');

        var namePattern = /^[A-Za-zÀ-ỹ]+ [A-Za-zÀ-ỹ\s]+$/u;
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        var phonePattern = /^0[0-9]{9,10}$/;
        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
        var isValid = true;

        // Kiểm tra 'Họ và tên'
        if (ten_khachhang.trim() === '') {
            ten_khachhang_error.textContent = 'Họ và tên không được để trống';
            ten_khachhang_error.style.display = 'flex';
            isValid = false;
        } else if (!namePattern.test(ten_khachhang)) {
            ten_khachhang_error.textContent = 'Họ và tên sai định dạng, vui lòng nhập đúng họ và tên trong CCCD!';
            ten_khachhang_error.style.display = 'flex';
            isValid = false;
        } else {
            ten_khachhang_error.style.display = 'none';
        }

        // Kiểm tra email
        if (email.trim() === '') {
            email_error.textContent = 'Email không được để trống';
            email_error.style.display = 'flex';
            isValid = false;
        } else if (!emailPattern.test(email)) {
            email_error.textContent = 'Email không đúng định dạng';
            email_error.style.display = 'flex';
            isValid = false;
        } else {
            email_error.style.display = 'none';
        }

        // Kiểm tra mật khẩu
        if (mat_khau.trim() === '') {
            mat_khau_error.textContent = 'Mật khẩu không được để trống';
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

        // Kiểm tra số điện thoại
        if (dien_thoai.trim() === '') {
            dien_thoai_error.textContent = 'Số điện thoại không được để trống';
            dien_thoai_error.style.display = 'flex';
            isValid = false;
        } else if (!phonePattern.test(dien_thoai)) {
            dien_thoai_error.textContent = 'Số điện thoại sai định dạng, vui lòng nhập số di động hợp lệ';
            dien_thoai_error.style.display = 'flex';
            isValid = false;
        } else {
            dien_thoai_error.style.display = 'none';
        }

        // Kiểm tra địa chỉ
        if (dia_chi.trim() === '') {
            dia_chi_error.textContent = 'Địa chỉ không được để trống';
            dia_chi_error.style.display = 'flex';
            isValid = false;
        } else {
            dia_chi_error.style.display = 'none';
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
