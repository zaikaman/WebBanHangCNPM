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
            $stmt = $mysqli->prepare("INSERT INTO tbl_dangky (ten_khachhang, email, dia_chi_chi_tiet, mat_khau, dien_thoai) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $user['ten_khachhang'], $user['email'], $user['dia_chi'], $user['mat_khau'], $user['dien_thoai']);
            if ($stmt->execute()) {
                // Delete token entry from tbl_xacnhanemail
                $del = $mysqli->prepare("DELETE FROM tbl_xacnhanemail WHERE email = ?");
                $del->bind_param("s", $email);
                $del->execute();

                echo "Email xác nhận thành công! Đang tự động chuyển hướng...";
                echo "<script>
                        setTimeout(function() {
                            window.location.href='index.php?quanly=dangnhap';
                        }, 3000);
                    </script>";
                unset($_SESSION['user_info']); // Clear session data
            } else {
                error_log('Lỗi khi chèn tbl_dangky: ' . $mysqli->error);
                echo "Xác nhận email nhưng không thể tạo tài khoản do lỗi hệ thống. Vui lòng liên hệ quản trị viên.";
            }
        } else {
            // Thử lấy dữ liệu tạm từ tbl_dangky_temp theo token
            $temp_stmt = $mysqli->prepare("SELECT ten_khachhang, email, dien_thoai, mat_khau, dia_chi_chi_tiet FROM tbl_dangky_temp WHERE token = ?");
            if ($temp_stmt) {
                $temp_stmt->bind_param("s", $token);
                $temp_stmt->execute();
                $temp_res = $temp_stmt->get_result();
                if ($temp_res && $temp_res->num_rows > 0) {
                    $temp_user = $temp_res->fetch_assoc();
                    $ins = $mysqli->prepare("INSERT INTO tbl_dangky (ten_khachhang, email, dia_chi_chi_tiet, mat_khau, dien_thoai) VALUES (?, ?, ?, ?, ?)");
                    $ins->bind_param("sssss", $temp_user['ten_khachhang'], $temp_user['email'], $temp_user['dia_chi_chi_tiet'], $temp_user['mat_khau'], $temp_user['dien_thoai']);
                    if ($ins->execute()) {
                        // Remove temp and token entries
                        $del_temp = $mysqli->prepare("DELETE FROM tbl_dangky_temp WHERE token = ?");
                        $del_temp->bind_param("s", $token);
                        $del_temp->execute();

                        $del = $mysqli->prepare("DELETE FROM tbl_xacnhanemail WHERE email = ?");
                        $del->bind_param("s", $email);
                        $del->execute();

                        echo "Email xác nhận thành công! Đang tự động chuyển hướng...";
                        echo "<script>
                                setTimeout(function() {
                                    window.location.href='index.php?quanly=dangnhap';
                                }, 3000);
                            </script>";
                    } else {
                        error_log('Lỗi khi chèn tbl_dangky từ tbl_dangky_temp: ' . $mysqli->error);
                        echo "Xác nhận email nhưng không thể tạo tài khoản do lỗi hệ thống. Vui lòng liên hệ quản trị viên.";
                    }
                } else {
                    error_log('Xác nhận token cho email ' . $email . ' nhưng không có session và không tìm thấy bản ghi temp.');
                    echo "Vui lòng mở email và xác nhận trên cùng trình duyệt (vì session đăng ký lưu tạm trên trình duyệt). Nếu không, liên hệ admin để hỗ trợ.";
                }
            } else {
                error_log('Không thể chuẩn bị câu lệnh truy vấn tbl_dangky_temp: ' . $mysqli->error);
                echo "Vui lòng mở email và xác nhận trên cùng trình duyệt (vì session đăng ký lưu tạm trên trình duyệt). Nếu không, liên hệ admin để hỗ trợ.";
            }
        }
    } else {
        echo "Token không hợp lệ hoặc đã hết hạn.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
