<?php
/**
 * Newsletter API - Gửi email welcome khi đăng ký
 */
header('Content-Type: application/json; charset=utf-8');

// Include mail helper
require_once __DIR__ . '/../mail/sendmail.php';

// Chỉ chấp nhận POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Lấy email từ request
$email = '';
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if (strpos($contentType, 'application/json') !== false) {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
} else {
    $email = $_POST['email'] ?? '';
}

// Validate email
if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập email']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
    exit;
}

// Gửi email welcome
$mailer = new Mailer();
$result = $mailer->sendNewsletterWelcome($email);

if ($result) {
    echo json_encode([
        'success' => true, 
        'message' => 'Đăng ký thành công! Vui lòng kiểm tra email của bạn.'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.'
    ]);
}
