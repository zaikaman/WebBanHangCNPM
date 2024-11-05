<?php
include('..//..//config/config.php');

if (isset($_POST['xoaTaiKhoan'])) {
    $id = $_GET['id'];
    $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke');
}
