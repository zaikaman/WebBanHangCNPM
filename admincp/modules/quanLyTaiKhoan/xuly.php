<?php
// Authentication check
session_start();
if(!isset($_SESSION['dangNhap'])) {
    header('Location: ../../login.php');
    exit;
}

include('..//..//config/config.php');

if(isset($_GET['id'])) {
    $id_khachhang = $_GET['id'];
    
    // Delete customer account
    $sql_xoa = "DELETE FROM tbl_khachhang WHERE id_khachhang = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id_khachhang);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Xóa tài khoản thành công!');
            window.location.href='../../index.php?action=quanLyTaiKhoan&query=lietke';
        </script>";
    }
}
?> 