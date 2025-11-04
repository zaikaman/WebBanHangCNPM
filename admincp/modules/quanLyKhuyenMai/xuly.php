<?php
include("../../config/config.php");

if (isset($_GET['id'])) {
    $id_km = (int)$_GET['id'];
    
    // Xóa các liên kết sản phẩm trước
    $sql_delete_links = "DELETE FROM tbl_sanpham_khuyenmai WHERE id_km = $id_km";
    mysqli_query($mysqli, $sql_delete_links);
    
    // Xóa khuyến mãi
    $sql_delete = "DELETE FROM tbl_khuyenmai WHERE id_km = $id_km";
    
    if (mysqli_query($mysqli, $sql_delete)) {
        header("Location: ../../index.php?action=quanlykhuyenmai&query=lietke&msg=delete_success");
    } else {
        header("Location: ../../index.php?action=quanlykhuyenmai&query=lietke&msg=delete_error");
    }
} else {
    header("Location: ../../index.php?action=quanlykhuyenmai&query=lietke");
}
exit();
?>
