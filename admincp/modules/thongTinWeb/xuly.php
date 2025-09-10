<?php
// Authentication check
session_start();
if(!isset($_SESSION['dangNhap'])) {
    header('Location: ../../login.php');
    exit;
}

include('..//..//config/config.php');

$thongtinlienhe = $_POST['thongtinlienhe'];
$id = $_GET['id'];

if (isset($_POST['submitlienhe'])) {
    $sql_update = "UPDATE tbl_lienhe SET thongtinlienhe='$thongtinlienhe' WHERE id='$id'";
    mysqli_query($mysqli, $sql_update);
    header('Location: ../../index.php?action=quanLyWeb&query=capnhat');
} else {
    $id = $_GET['idbaiviet'];
    $sql_xoa = "DELETE FROM tbl_danhmuc_baiviet WHERE id_baiviet='$id'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location: ../../index.php?action=quanLyDanhMucBaiViet&query=them');
}
