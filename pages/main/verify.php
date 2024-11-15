<?php
session_start();
include '../../admincp/config/config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Fetch email associated with the token
    $stmt = $mysqli->prepare("SELECT email FROM tbl_xacnhanemail WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Get user info from session and insert into tbl_dangky
        if (isset($_SESSION['user_info']) && $_SESSION['user_info']['email'] === $email) {
            $user = $_SESSION['user_info'];
            $stmt = $mysqli->prepare("INSERT INTO tbl_dangky (ten_khachhang, email, dia_chi, mat_khau, dien_thoai) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $user['ten_khachhang'], $user['email'], $user['dia_chi'], $user['mat_khau'], $user['dien_thoai']);
            $stmt->execute();

            // Delete token entry from tbl_xacnhanemail
            $stmt = $mysqli->prepare("DELETE FROM tbl_xacnhanemail WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            echo "Email xác nhận thành công! Đang tự động chuyển hướng...";
            echo "<script>
                    setTimeout(function() {
                        window.location.href='index.php?quanly=dangnhap';
                    }, 3000);
                </script>";
            unset($_SESSION['user_info']); // Clear session data
        } else {
            echo "Vui lòng đăng nhập trên cùng trình duyệt đã dùng để đăng ký.";
        }
    } else {
        echo "Token không hợp lệ hoặc đã hết hạn.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
