<?php
include('..//..//config/config.php');
$tenBaiViet = $_POST['tenbaiviet'];
$tomtat = $_POST['tomtat'];
$noidung = $_POST['noidung'];
$tinhtrang = $_POST['tinhtrang'];
$iddm = $_POST['id_danhmuc'];
// hinh anh
$hinhanh = $_FILES['hinhanh']['name'];
$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];

if (isset($_POST['thembaiviet'])) {
    $sql_them = "INSERT INTO tbl_baiviet(tenbaiviet,hinhanh,tomtat,noidung,tinhtrang,id_danhmuc) VALUE('" . $tenBaiViet . "','" . $hinhanh . "','" . $tomtat . "','" . $noidung . "','" . $tinhtrang . "','" . $iddm . "')";
    mysqli_query($mysqli, $sql_them);
    move_uploaded_file($hinhanh_tmp, 'uploads/' . $hinhanh);
    header('Location:../../index.php?action=quanLyBaiViet&query=them');
} elseif (isset($_POST['suabaiviet'])) {
    if ($hinhanh != '') {
        move_uploaded_file($hinhanh_tmp, 'uploads/' . $hinhanh);
        $sql = "SELECT * FROM tbl_baiviet WHERE id ='$_GET[idbv]' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($query)) {
            unlink('uploads/' . $row['hinh_anh']);
        }
        $sql_update = "UPDATE tbl_baiviet SET tenbaiviet='" . $tenBaiViet . "', hinhanh='" . $hinhanh . "', tomtat='" . $tomtat . "', noidung='" . $noidung . "', tinhtrang='" . $tinhtrang . "', id_danhmuc='" . $iddm . "' WHERE id='$_GET[idbv]'";
    } else {
        $sql_update = "UPDATE tbl_baiviet SET tenbaiviet='" . $tenBaiViet . "', tomtat='" . $tomtat . "', noidung='" . $noidung . "', tinhtrang='" . $tinhtrang . "', id_danhmuc='" . $iddm . "' WHERE id='$_GET[idbv]'";
    }
    mysqli_query($mysqli, $sql_update);
    header('Location:../../index.php?action=quanLyBaiViet&query=them');
} else {
    $id = $_GET['idbv'];
    $sql = "SELECT * FROM tbl_baiviet WHERE id ='$id' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_array($query)) {
        unlink('uploads/' . $row['hinh_anh']);
    }
    $sql_xoa = "DELETE FROM tbl_baiviet WHERE id='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../../index.php?action=quanLyBaiViet&query=them');
}
