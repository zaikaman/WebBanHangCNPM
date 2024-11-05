<?php
include('../../config/config.php');

$id = $_GET['id'];
$sql_sua = "UPDATE tbl_dangky SET id_taikhoan = 2 WHERE id_dangky = '" . $id . "'";
mysqli_query($mysqli, $sql_sua);
header('Location:../../index.php?action=quanLyTaiKhoanKhachHang&query=lietke');
?>
