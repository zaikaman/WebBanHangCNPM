<?php
include('..//..//config/config.php');
$tenLoaisp = $_POST['name_sp'];
$thuTu = "";
if(isset($_POST['themDanhMuc'])){
	$sql_them= "INSERT INTO tbl_danhmucqa(name_sp,thu_tu) VALUE('".$tenLoaisp."','".$thuTu."')";
	mysqli_query($mysqli,$sql_them);
	header('Location:../../index.php?action=quanLyDanhMucSanPham&query=them');
}elseif(isset($_POST['suaDanhMuc'])) {
	$sql_update= "UPDATE tbl_danhmucqa SET name_sp='".$tenLoaisp."', thu_tu= '".$thuTu."'WHERE id_dm= '$_GET[idsp]'";
	mysqli_query($mysqli,$sql_update);
	header('Location:../../index.php?action=quanLyDanhMucSanPham&query=them');
}else{
	$id=$_GET['idsp'];
	$sql_xoa = "DELETE FROM tbl_danhmucqa WHERE id_dm='".$id."'";
	mysqli_query($mysqli,$sql_xoa);
	header('Location:../../index.php?action=quanLyDanhMucSanPham&query=them');
}
?>
