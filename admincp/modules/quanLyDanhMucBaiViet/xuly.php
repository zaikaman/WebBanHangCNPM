<?php
include('..//..//config/config.php');

$tendanhmucbv = $_POST['tendanhmucbaiviet'];
$thuTu = "";

if (isset($_POST['themDanhMucBaiViet'])) {
	$sql_them = "INSERT INTO tbl_danhmuc_baiviet(tendanhmuc_baiviet,thutu) VALUE('" . $tendanhmucbv . "','" . $thuTu . "')";
	mysqli_query($mysqli, $sql_them);
	header('Location:../../index.php?action=quanLyDanhMucBaiViet&query=them');
} elseif (isset($_POST['suaDanhMucBaiViet'])) {
	$sql_update = "UPDATE tbl_danhmuc_baiviet SET tendanhmuc_baiviet='" . $tendanhmucbv . "', thutu= '" . $thuTu . "'WHERE id_baiviet= '$_GET[idbaiviet]'";
	mysqli_query($mysqli, $sql_update);
	header('Location:../../index.php?action=quanLyDanhMucBaiViet&query=them');
} else {
	$id = $_GET['idbaiviet'];
	$sql_xoa = "DELETE FROM tbl_danhmuc_baiviet WHERE id_baiviet='" . $id . "'";
	mysqli_query($mysqli, $sql_xoa);
	header('Location:../../index.php?action=quanLyDanhMucBaiViet&query=them');
}
