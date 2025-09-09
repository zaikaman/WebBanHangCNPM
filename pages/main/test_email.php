<?php
// Test file để kiểm tra PHPMailer
include('../../admincp/config/config.php');
require('../../mail/sendmail.php');

$mailer = new Mailer();

// Test email
$testCartItems = [
    [
        'ten_sp' => 'Áo MU Test',
        'ma_sp' => 'MU001',
        'gia_sp' => 500000,
        'so_luong' => 2
    ],
    [
        'ten_sp' => 'Quần Liverpool Test',
        'ma_sp' => 'LIV001',
        'gia_sp' => 400000,
        'so_luong' => 1
    ]
];

$totalAmount = 1400000;

echo "Đang test gửi email...<br>";

$result = $mailer->sendOrderConfirmation(
    'test@example.com', // Thay bằng email test của bạn
    'Nguyễn Test',
    'TEST001',
    $testCartItems,
    $totalAmount
);

if ($result) {
    echo "✅ Gửi email thành công!";
} else {
    echo "❌ Gửi email thất bại!";
}
?>
