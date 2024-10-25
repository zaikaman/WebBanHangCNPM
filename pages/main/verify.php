<?php
include '../../admincp/config/config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Fetch user information associated with the token
    $stmt = $mysqli->prepare("SELECT ten_khachhang, email, dia_chi, mat_khau, dien_thoai FROM tbl_xacnhanemail WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Insert user data into tbl_dangky
        $stmt = $mysqli->prepare("INSERT INTO tbl_dangky (ten_khachhang, email, dia_chi, mat_khau, dien_thoai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user['ten_khachhang'], $user['email'], $user['dia_chi'], $user['mat_khau'], $user['dien_thoai']);
        $stmt->execute();

        // Delete the token entry from tbl_xacnhanemail
        $stmt = $mysqli->prepare("DELETE FROM tbl_xacnhanemail WHERE email = ?");
        $stmt->bind_param("s", $user['email']);
        $stmt->execute();

        echo "Email xác nhận thành công! Bạn có thể đăng nhập.";
        echo "Đang tự động chuyển hướng...";
        echo "<script>
                setTimeout(function() {
                    window.location.href='index.php?quanly=dangnhap';
                }, 3000);
            </script>";
    } else {
        echo "Token không hợp lệ hoặc đã hết hạn.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
