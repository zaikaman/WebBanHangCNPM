<?php

use Carbon\Carbon;
use Carbon\CarbonInterval;

require('../../../Carbon-3.8.0/autoload.php');
include('..//..//config/config.php');

$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
if (isset($_GET['code'])) {
	$code_cart = $_GET['code'];
	$sql_update = "UPDATE tbl_giohang SET trang_thai = '0' WHERE ma_gh = '$code_cart'";
	$query = mysqli_query($mysqli, $sql_update);
}

// Thống kê doanh thu
$sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh, tbl_sanpham WHERE tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp AND tbl_chitiet_gh.ma_gh = '$code_cart' ORDER BY tbl_chitiet_gh.id_ctgh DESC";
$query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

$sql_thongke = "SELECT * FROM tbl_thongke WHERE ngaydat = '$now'";
$query_thongke = mysqli_query($mysqli, $sql_thongke);

$soluongmua = 0;
$doanhthu = 0;
$donhang = 0;

while ($row = mysqli_fetch_array($query_lietke_dh)) {
	$soluongmua += (int)$row['so_luong_mua'];
	$doanhthu += (int)$row['gia_sp'];
}

if ($query_thongke->num_rows == 0) {
	$donhang = 1;
	$stmt = $mysqli->prepare("INSERT INTO tbl_thongke (ngaydat, soluongdaban, doanhthu, donhang) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("siii", $now, $soluongmua, $doanhthu, $donhang);
	if (!$stmt->execute()) {
		echo "Error on INSERT: " . $stmt->error; // Kiểm tra lỗi
	}
} else {
	$row_tk = $query_thongke->fetch_assoc();
	$soluongban = $row_tk['soluongdaban'] + $soluongmua;
	$doanhthu = $row_tk['doanhthu'] + $doanhthu;
	$donhang = $row_tk['donhang'] + 1;

	$stmt = $mysqli->prepare("UPDATE tbl_thongke SET soluongdaban = ?, doanhthu = ?, donhang = ? WHERE ngaydat = ?");
	$stmt->bind_param("iiis", $soluongban, $doanhthu, $donhang, $now);
	if (!$stmt->execute()) {
		echo "Error on UPDATE: " . $stmt->error; // Kiểm tra lỗi
	}
}

header('Location:../../index.php?action=quanLyDonHang&query=lietke');
