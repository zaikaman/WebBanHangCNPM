<?php
// Authentication check
session_start();
if(!isset($_SESSION['dangNhap'])) {
    header('Location: ../../login.php');
    exit;
}

include('../../config/config.php');

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Check if customer has any orders before deleting
    $sql_check_orders = "SELECT COUNT(*) as count FROM tbl_hoadon WHERE id_khachhang = ?";
    $stmt_check = mysqli_prepare($mysqli, $sql_check_orders);
    mysqli_stmt_bind_param($stmt_check, "i", $id);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt_check);
    
    if($row['count'] > 0) {
        echo "<script>
            alert('Không thể xóa tài khoản này vì khách hàng đã có " . $row['count'] . " đơn hàng!\\nBạn có thể vô hiệu hóa tài khoản thay vì xóa.');
            window.location.href='../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke';
        </script>";
        exit;
    }
    
    // Delete customer account if no orders
    $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Xóa tài khoản khách hàng thành công!');
            window.location.href='../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke';
        </script>";
    }
    mysqli_stmt_close($stmt);
    
} else {
    echo "<script>
        alert('ID không hợp lệ!');
        window.location.href='../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke';
    </script>";
}
