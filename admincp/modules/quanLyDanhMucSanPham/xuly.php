<?php
include('..//..//config/config.php');

function isDuplicateCategory($mysqli, $name, $excludeId = null) {
    $sql = "SELECT COUNT(*) as count FROM tbl_danhmucqa WHERE name_sp = '$name'";
    if ($excludeId) {
        $sql .= " AND id_dm != $excludeId";
    }
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

if(isset($_POST['themDanhMuc'])) {
    $tenLoaisp = trim($_POST['name_sp']);
    
    // Validate empty
    if(empty($tenLoaisp)) {
        echo "<script>alert('Tên danh mục không được để trống!'); window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';</script>";
        exit;
    }
    
    // Validate duplicate
    if(isDuplicateCategory($mysqli, $tenLoaisp)) {
        echo "<script>alert('Tên danh mục đã tồn tại!'); window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';</script>";
        exit;
    }

    $sql_them = "INSERT INTO tbl_danhmucqa(name_sp) VALUE(?)";
    $stmt = mysqli_prepare($mysqli, $sql_them);
    mysqli_stmt_bind_param($stmt, "s", $tenLoaisp);
    mysqli_stmt_execute($stmt);
    header('Location:../../index.php?action=quanLyDanhMucSanPham&query=them');

} elseif(isset($_POST['suaDanhMuc'])) {
    $tenLoaisp = trim($_POST['name_sp']);
    $id = $_GET['idsp'];
    
    // Validate empty
    if(empty($tenLoaisp)) {
        echo "<script>alert('Tên danh mục không được để trống!'); window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=sua&idsp=$id';</script>";
        exit;
    }
    
    // Validate duplicate
    if(isDuplicateCategory($mysqli, $tenLoaisp, $id)) {
        echo "<script>alert('Tên danh mục đã tồn tại!'); window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=sua&idsp=$id';</script>";
        exit;
    }

    $sql_update = "UPDATE tbl_danhmucqa SET name_sp=? WHERE id_dm=?";
    $stmt = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt, "si", $tenLoaisp, $id);
    mysqli_stmt_execute($stmt);
    header('Location:../../index.php?action=quanLyDanhMucSanPham&query=them');

} else {
    $id = $_GET['idsp'];
    
    // Update products to "no category" before deleting the category
    $sql_update_products = "UPDATE tbl_sanpham SET id_dm = 0 WHERE id_dm = ?";
    $stmt = mysqli_prepare($mysqli, $sql_update_products);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    // Delete the category
    $sql_xoa = "DELETE FROM tbl_danhmucqa WHERE id_dm = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    header('Location:../../index.php?action=quanLyDanhMucSanPham&query=them');
}
?>
