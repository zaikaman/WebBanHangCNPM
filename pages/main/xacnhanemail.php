<?php
session_start();
require_once __DIR__ . '/../../admincp/config/config.php';
require_once __DIR__ . '/../../mail/sendmail.php';

// Khởi tạo biến
$resend_message = '';
$verification_message = '';
$is_verification_success = false;

// Xử lý token xác nhận từ email
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
    
    // Kiểm tra token trong database
    $stmt = $mysqli->prepare("SELECT email, created_at, verified FROM tbl_xacnhanemail WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $created_at = $row['created_at'];
        $already_verified = $row['verified'];
        
        if ($already_verified == 1) {
            $verification_message = "Email này đã được xác nhận trước đó.";
            $is_verification_success = true;
        } else {
            // Kiểm tra token có hết hạn không (24 giờ)
            $created_time = strtotime($created_at);
            $current_time = time();
            $time_diff = $current_time - $created_time;
            
            if ($time_diff <= 86400) { // 24 giờ = 86400 giây
                // Token hợp lệ, cập nhật trạng thái
                $update_stmt = $mysqli->prepare("UPDATE tbl_xacnhanemail SET verified = 1, verified_at = NOW() WHERE token = ?");
                $update_stmt->bind_param("s", $token);
                
                if ($update_stmt->execute()) {
                        // Lấy thông tin user từ session (nếu có) để insert vào tbl_dangky
                        if (isset($_SESSION['user_info']) && $_SESSION['user_info']['email'] == $email) {
                            $user_info = $_SESSION['user_info'];

                            // Insert user vào bảng tbl_dangky
                            $insert_user = $mysqli->prepare("INSERT INTO tbl_dangky (ten_khachhang, email, dia_chi, mat_khau, dien_thoai) VALUES (?, ?, ?, ?, ?)");
                            $insert_user->bind_param("sssss",
                                $user_info['ten_khachhang'],
                                $user_info['email'],
                                $user_info['dia_chi'],
                                $user_info['mat_khau'],
                                $user_info['dien_thoai']
                            );

                            if ($insert_user->execute()) {
                                // Xóa thông tin user khỏi session sau khi đăng ký thành công
                                unset($_SESSION['user_info']);
                                $verification_message = "Xác nhận email thành công! Tài khoản của bạn đã được tạo.";
                            } else {
                                $verification_message = "Xác nhận email thành công nhưng có lỗi khi tạo tài khoản.";
                            }
                        } else {
                            // Nếu session không có thông tin user, cố gắng lấy từ bảng tạm tbl_dangky_temp
                            $temp_stmt = $mysqli->prepare("SELECT ten_khachhang, email, dien_thoai, mat_khau, dia_chi FROM tbl_dangky_temp WHERE token = ?");
                            if ($temp_stmt) {
                                $temp_stmt->bind_param("s", $token);
                                $temp_stmt->execute();
                                $temp_res = $temp_stmt->get_result();
                                if ($temp_res && $temp_res->num_rows > 0) {
                                    $temp_user = $temp_res->fetch_assoc();

                                    // Insert into tbl_dangky
                                    $insert_user = $mysqli->prepare("INSERT INTO tbl_dangky (ten_khachhang, email, dia_chi, mat_khau, dien_thoai) VALUES (?, ?, ?, ?, ?)");
                                    $insert_user->bind_param("sssss",
                                        $temp_user['ten_khachhang'],
                                        $temp_user['email'],
                                        $temp_user['dia_chi'],
                                        $temp_user['mat_khau'],
                                        $temp_user['dien_thoai']
                                    );

                                    if ($insert_user->execute()) {
                                        // Xóa bản ghi tạm sau khi tạo tài khoản
                                        $delete_temp = $mysqli->prepare("DELETE FROM tbl_dangky_temp WHERE token = ?");
                                        $delete_temp->bind_param("s", $token);
                                        $delete_temp->execute();

                                        $verification_message = "Xác nhận email thành công! Tài khoản của bạn đã được tạo.";
                                    } else {
                                        error_log('Lỗi khi chèn tbl_dangky từ tbl_dangky_temp: ' . $mysqli->error);
                                        $verification_message = "Xác nhận email thành công nhưng có lỗi khi tạo tài khoản.";
                                    }
                                } else {
                                    // Không tìm thấy dữ liệu tạm; chỉ xác nhận email
                                    $verification_message = "Xác nhận email thành công!";
                                }
                            } else {
                                error_log('Không thể chuẩn bị câu lệnh truy vấn tbl_dangky_temp: ' . $mysqli->error);
                                $verification_message = "Xác nhận email thành công!";
                            }
                        }
                    
                    $is_verification_success = true;
                } else {
                    $verification_message = "Có lỗi xảy ra khi xác nhận email. Vui lòng thử lại.";
                }
            } else {
                $verification_message = "Token đã hết hạn. Vui lòng yêu cầu gửi lại email xác nhận.";
            }
        }
    } else {
        $verification_message = "Token không hợp lệ hoặc đã được sử dụng.";
    }
}

// Xử lý gửi email xác nhận (cho trang hiển thị form)
if (isset($_SESSION['email']) && !isset($_GET['token'])) {
    $user_email = htmlspecialchars($_SESSION['email']); 
    $user_name = $_SESSION['ten_khachhang'];
    
    $token = bin2hex(random_bytes(16)); // Create a unique token

    // Store the token in the database
    $stmt = $mysqli->prepare("INSERT INTO tbl_xacnhanemail (email, token, created_at, verified) VALUES (?, ?, NOW(), 0) ON DUPLICATE KEY UPDATE token = VALUES(token), created_at = VALUES(created_at), verified = 0");
    $stmt->bind_param("ss", $user_email, $token);
    $stmt->execute();

    // Send email using PHPMailer
    $mailer = new Mailer();
    $emailSent = $mailer->sendVerificationEmail($user_email, $user_name, $token);

    // Feedback message
    if ($emailSent) {
        $resend_message = "Email xác nhận đã được gửi tới " . $user_email;
    } else {
        $resend_message = "Có lỗi xảy ra khi gửi email xác nhận. Vui lòng thử lại.";
    }
} elseif (!isset($_GET['token'])) {
    $resend_message = "Không tìm thấy email của bạn trong hệ thống.";
}

// Giả sử email của người dùng được lưu trong session sau khi đăng ký
if (isset($_SESSION['email'])) {
    $user_email = htmlspecialchars($_SESSION['email']); // Xử lý dữ liệu để tránh XSS
} else {
    // Trường hợp email không được thiết lập
    $user_email = 'your-email@example.com';
}

// Xử lý chức năng gửi lại email
if (isset($_POST['resend_email'])) {
    if (isset($_SESSION['email'])) {
        $user_email = $_SESSION['email'];
        $user_name = $_SESSION['ten_khachhang'];
        
        // Tạo token mới
        $new_token = bin2hex(random_bytes(16));
        // Cập nhật token mới trong database
        $stmt = $mysqli->prepare("UPDATE tbl_xacnhanemail SET token = ?, created_at = NOW() WHERE email = ?");
        $stmt->bind_param("ss", $new_token, $user_email);
        $stmt->execute();
        
        // Gửi email mới
        $mailer = new Mailer();
        $emailSent = $mailer->sendVerificationEmail($user_email, $user_name, $new_token);
        
        if ($emailSent) {
            $resend_message = "Email xác nhận đã được gửi lại tới " . $user_email;
        } else {
            $resend_message = "Có lỗi xảy ra khi gửi lại email xác nhận.";
        }
    } else {
        $resend_message = "Không tìm thấy thông tin phiên đăng ký.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh địa chỉ email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .verification-container {
            background-color: white;
            text-align: center;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .verification-container img {
            width: 60px;
            height: 60px;
        }
        .verification-container h1 {
            font-size: 24px;
            margin-top: 20px;
        }
        .verification-container p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
        }
        .verification-container .highlight {
            font-weight: bold;
            color: #4a4a4a;
        }
        .verification-container .buttons {
            margin-top: 20px;
        }
        .verification-container .buttons form {
            display: inline-block;
        }
        .verification-container .buttons input {
            text-decoration: none;
            background-color: #ff4d4d; /* Màu đỏ */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        .verification-container .buttons a {
            text-decoration: none;
            background-color: #ff4d4d; /* Màu đỏ */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
        }
        .verification-container .buttons input:hover,
        .verification-container .buttons a:hover {
            background-color: #e04343; /* Màu đỏ đậm hơn khi hover */
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
        .resend-message {
            margin-top: 15px;
            color: green;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <?php if (isset($_GET['token'])): ?>
            <!-- Trang xác nhận token -->
            <?php if ($is_verification_success): ?>
                <img src="../../images/anchor.svg" alt="Biểu tượng thành công" style="width: 60px; height: 60px; filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(86deg) brightness(118%) contrast(119%);">
                <h1>Xác nhận thành công!</h1>
                <p><?php echo $verification_message; ?></p>
                <div class="buttons">
                    <a href="../../index.php?quanly=dangnhap">Đăng nhập ngay</a>
                    <a href="../../index.php">Về trang chủ</a>
                </div>
            <?php else: ?>
                <img src="../../images/email.png" alt="Biểu tượng lỗi">
                <h1>Xác nhận thất bại</h1>
                <p style="color: red;"><?php echo $verification_message; ?></p>
                <div class="buttons">
                    <a href="../../index.php">Về trang chủ</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Trang gửi email xác nhận -->
            <img src="../../images/email.png" alt="Biểu tượng Email">
            <h1>Xác minh địa chỉ email của bạn</h1>
            <p>Chúng tôi đã gửi một liên kết xác minh tới <span class="highlight"><?php echo $user_email; ?></span>.</p>
            <p>Nhấn vào liên kết để hoàn tất quá trình xác minh. Bạn có thể cần kiểm tra trong thư mục spam.</p>
            
            <div class="buttons">
                <form action="" method="POST">
                    <input type="submit" name="resend_email" value="Gửi lại email">
                </form>
                <a href="../../index.php">Quay về trang chủ</a>
            </div>
            
            <?php if (!empty($resend_message)): ?>
                <div class="resend-message">
                    <?php echo $resend_message; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="footer">
            Vui lòng liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào.
        </div>
    </div>
</body>
</html>
