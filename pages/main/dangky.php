<?php

$registration_error = '';

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

        // Construct verification link
        $siteURL = 'https://web7tcc-a9aaa5d624b4.herokuapp.com/';
        $verificationLink = "$siteURL/verify.php?token=$token";

        // Prepare email content
        $tieude = "Xác nhận đăng ký của bạn";
        $noidung = "<p>Cảm ơn bạn đã đăng ký! Vui lòng nhấp vào liên kết bên dưới để xác nhận email:</p>";
        $noidung .= "<p><a href='$verificationLink'>Xác nhận email của bạn</a></p>";

        // Send email with Brevo
        $apiKey = getenv('API_KEY');
        $url = 'https://api.brevo.com/v3/smtp/email';

        $emailData = [
            'sender' => [
                'name' => 'Your Company',
                'email' => 'zaikaman123@gmail.com'
            ],
            'to' => [
                [
                    'email' => $email,
                    'name' => $ten_khachhang
                ]
            ],
            'subject' => $tieude,
            'htmlContent' => $noidung
        ];

        // Initialize cURL for Brevo API request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'api-key: ' . $apiKey,
            'content-type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 201 || $httpCode == 200) {
            echo "Email xác nhận đã được gửi. Vui lòng kiểm tra email để hoàn tất đăng ký!";
        } else {
            // Show email error response for debugging
            echo "Lỗi gửi email: " . $response;
            unset($_SESSION['user_info']); // Clear session if email sending fails
        }
        curl_close($ch);
    }
}
?>

    <div class="login_container">
        <p style="font-weight: bold; font-size : 20px; margin : 20px 0 20px 0;">Đăng ký</p>
        <form action="" method="POST" class="login_content" id="registerForm">
            <div class="register_input_box">
                <label for="ten_khachhang">Họ và tên :</label>
                <input type="text" id="ten_khachhang" name="ten_khachhang">
                <div id="ten_khachhang_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; margin-bottom: 15px; font-size : 14px; align-items : center;">Họ và tên không đúng định dạng</div>
            </div>
            <div class="register_input_box">
                <label for="email">Email :</label>
                <input id="email" type="text" name="email">
            </div>
            <div id="email_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start;margin-bottom: 15px; font-size : 14px; align-items : center;">Email không đúng định dạng</div>
            <div class="register_input_box">
                 <label for="mat_khau">Mật khẩu :</label>
                 <input type="password" id="mat_khau" name="mat_khau">
                 <div id="mat_khau_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; margin-bottom: 15px; font-size : 14px; align-items : center;">Mật khẩu không được để trống</div>
            </div>
            <div class="register_input_box">
                <label for="dien_thoai">Số điện thoại :</label>
                <input type="text" id="dien_thoai" name="dien_thoai">
                <div id="dien_thoai_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; margin-bottom: 15px; font-size : 14px; align-items : center;">Số điện thoại không được để trống</div>
            </div>
            <div class="register_input_box">
                <label for="dia_chi">Địa chỉ :</label>
                <input type="text" id="dia_chi" name="dia_chi">
                <div id="dia_chi_error" style="display : none; width : 100%; color :red; padding : 4px 8px; justify-content : start; margin-bottom: 15px; font-size : 14px; align-items : center;">Địa chỉ không được để trống</div>
            </div>
            <input class="login_form_btn" type="submit" name="dang_ky" value="Đăng ký">
            <p>Đã có tài khoản?<a class="registerlink" href="index.php?quanly=dangnhap">Đăng nhập</a></p>
            <?php if (!empty($registration_error)) { ?>
                <div id="registration_error" style="display : flex; width : 100%; color :red; padding : 4px 8px; justify-content : center; align-items : center;"><?php echo $registration_error; ?></div>
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
