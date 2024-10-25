<?php
session_start();
require 'db_connection.php'; // Replace with actual database connection

// Check if token is provided
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token in the database
    $stmt = $pdo->prepare("SELECT * FROM email_verification WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Token is valid, save registration info to users table
        // Example query:
        // $stmt = $pdo->prepare("INSERT INTO users (email, name, ...) VALUES (?, ?, ...)");
        // $stmt->execute([$user['email'], $user['name'], ...]);

        // Delete token after successful verification
        $stmt = $pdo->prepare("DELETE FROM email_verification WHERE token = ?");
        $stmt->execute([$token]);

        // Redirect to confirmation page
        header("Location: index.php?quanly=emaildaxacnhan");
        exit;
    } else {
        echo "Token không hợp lệ hoặc đã hết hạn.";
    }
} else {
    echo "Không tìm thấy mã xác thực.";
}
?>
