<?php
session_start();

$apiKey = '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';
$url = 'https://api.brevo.com/v3/smtp/email';
$siteURL = 'https://web7tcc-a9aaa5d624b4.herokuapp.com/'; // Replace with your actual website URL

// Generate a unique token
if (isset($_SESSION['email'])) {
    $user_email = htmlspecialchars($_SESSION['email']); 
    $user_name = $_SESSION['ten_khachhang'];
    
    $token = bin2hex(random_bytes(16)); // Create a unique token
    $verificationLink = "$siteURL/verify.php?token=$token"; // Construct the verification link

    // Store the token in the database
    // Here you should use your own database connection and save the token with the user's email
    // For example:
    // $stmt = $pdo->prepare("INSERT INTO email_verification (email, token) VALUES (?, ?)");
    // $stmt->execute([$user_email, $token]);

    // Prepare email content
    $tieude = "Xác nhận đăng ký của bạn";
    $noidung = "<p>Bạn gần hoàn thành quá trình đăng ký. Vui lòng nhấn vào liên kết bên dưới để xác nhận email:</p>";
    $noidung .= "<p><a href='$verificationLink'>Xác nhận email của bạn</a></p>";
    
    // Email data array for Brevo API
    $emailData = [
        'sender' => [
            'name' => 'Your Company',
            'email' => 'zaikaman123@gmail.com'
        ],
        'to' => [
            [
                'email' => $user_email,
                'name' => $user_name
            ]
        ],
        'subject' => $tieude,
        'htmlContent' => $noidung
    ];

    // Send email using Brevo API
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
    curl_close($ch);

    // Feedback message
    if ($httpCode == 201 || $httpCode == 200) {
        $resend_message = "Email xác nhận đã được gửi lại tới " . $user_email;
    } else {
        $resend_message = "Có lỗi xảy ra khi gửi email xác nhận.";
    }
} else {
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
    // Thêm logic để gửi lại email xác nhận tại đây
    // Ví dụ, bạn có thể gửi lại email xác nhận bằng hàm mail hoặc API gửi email

    // Phản hồi sau khi gửi lại email
    $resend_message = "Email xác nhận đã được gửi lại tới " . $user_email;
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
        <img src="../../images/email.png" alt="Biểu tượng Email">
        <h1>Xác minh địa chỉ email của bạn</h1>
        <p>Chúng tôi đã gửi một liên kết xác minh tới <span class="highlight"><?php echo $user_email; ?></span>.</p>
        <p>Nhấn vào liên kết để hoàn tất quá trình xác minh. Bạn có thể cần kiểm tra trong thư mục spam.</p>
        
        <div class="buttons">
            <form action="" method="POST">
                <input type="submit" name="resend_email" value="Gửi lại email">
            </form>
            <a href="index.php">Quay về trang chủ</a>
        </div>
        
        <?php if (isset($resend_message)): ?>
            <div class="resend-message">
                <?php echo $resend_message; ?>
            </div>
        <?php endif; ?>

        <div class="footer">
            Vui lòng liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào.
        </div>
    </div>
</body>
</html>
