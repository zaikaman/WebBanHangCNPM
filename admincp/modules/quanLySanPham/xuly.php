<?php
include('..//..//config/config.php');
$tenLoaisp = $_POST['ten_sp'];
$masp = $_POST['ma_sp'];
$giasp= $_POST['gia_sp'];
$soluong= $_POST['so_luong'];
$tomtat= $_POST['tom_tat'];
$noidung= $_POST['noi_dung'];
$tinhtrang= $_POST['tinh_trang'];
$iddm= $_POST['id_dm'];
// hinh anh
$hinhanh = $_FILES['hinh_anh']['name'];
$hinhanh_tmp = $_FILES['hinh_anh']['tmp_name'];

if(isset($_POST['themSanPham'])){
	$sql_them= "INSERT INTO tbl_sanpham(ten_sp,ma_sp,gia_sp,so_luong,hinh_anh,tom_tat,noi_dung,tinh_trang,id_dm) VALUE('".$tenLoaisp."','".$masp."','".$giasp."','".$soluong."','".$hinhanh."','".$tomtat."','".$noidung."','".$tinhtrang."','".$iddm."')";
	mysqli_query($mysqli,$sql_them);
	move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
	header('Location:../../index.php?action=quanLySanPham&query=them');
}elseif(isset($_POST['suaSanPham'])) {
	if($hinhanh!= ''){
		move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh);
		$sql = "SELECT * FROM tbl_sanpham WHERE ma_sp ='$_GET[idsp]' LIMIT 1";
		$query = mysqli_query($mysqli,$sql);
		while($row= mysqli_fetch_array($query)){
			unlink('uploads/'.$row['hinh_anh']);
		}
    	$sql_update = "UPDATE tbl_sanpham SET ten_sp='".$tenLoaisp."', ma_sp='".$masp."', gia_sp='".$giasp."', so_luong='".$soluong."', hinh_anh='".$hinhanh."', tom_tat='".$tomtat."', noi_dung='".$noidung."', tinh_trang='".$tinhtrang."', id_dm='".$iddm."' WHERE ma_sp='$_GET[idsp]'";
	}else {
    	$sql_update = "UPDATE tbl_sanpham SET ten_sp='".$tenLoaisp."', ma_sp='".$masp."', gia_sp='".$giasp."', so_luong='".$soluong."',tom_tat='".$tomtat."', noi_dung='".$noidung."', tinh_trang='".$tinhtrang."', id_dm='".$iddm."' WHERE ma_sp='$_GET[idsp]'";
	}
	mysqli_query($mysqli,$sql_update);
	header('Location:../../index.php?action=quanLySanPham&query=them');
}else{
	$id=$_GET['idsp'];
	$sql = "SELECT * FROM tbl_sanpham WHERE ma_sp ='$id' LIMIT 1";
	$query = mysqli_query($mysqli,$sql);
	while($row= mysqli_fetch_array($query)){
		unlink('uploads/'.$row['hinh_anh']);
	}
	$sql_xoa = "DELETE FROM tbl_sanpham WHERE ma_sp='".$id."'";
	mysqli_query($mysqli,$sql_xoa);
	header('Location:../../index.php?action=quanLySanPham&query=them');
}
?>