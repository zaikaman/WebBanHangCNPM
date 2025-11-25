<?php
session_start();
include('config/config.php');

// Test insert simple product
$ten_sp = "Test Product " . time();
$ma_sp = "TEST" . time();
$gia_sp = 100000;
$so_luong = 10;
$hinh_anh = "test.jpg";
$tom_tat = "Test description";
$tinh_trang = 1;
$id_dm = 1;

$sql = "INSERT INTO tbl_sanpham(ten_sp, ma_sp, gia_sp, so_luong, so_luong_con_lai, hinh_anh, tom_tat, tinh_trang, id_dm) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "ssiiissii", $ten_sp, $ma_sp, $gia_sp, $so_luong, $so_luong, $hinh_anh, $tom_tat, $tinh_trang, $id_dm);

if(mysqli_stmt_execute($stmt)) {
    $new_id = mysqli_insert_id($mysqli);
    echo "SUCCESS! Product ID: $new_id<br>";
    echo "Name: $ten_sp<br>";
    echo "Code: $ma_sp<br>";
    
    // Check if it's in database
    $check = mysqli_query($mysqli, "SELECT * FROM tbl_sanpham WHERE id_sp = $new_id");
    $row = mysqli_fetch_assoc($check);
    echo "<pre>";
    print_r($row);
    echo "</pre>";
} else {
    echo "ERROR: " . mysqli_error($mysqli);
}

mysqli_stmt_close($stmt);
?>
