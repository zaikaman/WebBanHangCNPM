<?php
include('../../config/config.php');

$id = $_GET['id'];

if (isset($id) && is_numeric($id)) {
    $sql_sua = "UPDATE tbl_taikhoan SET trang_thai = 2 WHERE id_dangky = '$id'";

    if (mysqli_query($mysqli, $sql_sua)) {
        header('Location:../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke');
        exit; 
    } else {
        echo "Có lỗi khi cập nhật trạng thái!";
    }
} else {
    echo "ID không hợp lệ!";
}
?>
