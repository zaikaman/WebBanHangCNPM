<?php
include('..//..//config/config.php');

if (isset($_POST['themAdmin'])) {
    $tenadmin = $_POST['tenadmin'];
    $matkhau = $_POST['matkhau'];
    $admin_status = 1;
    $hashed_password = md5($matkhau);
    $sql_them = "INSERT INTO tbl_admin(user_name, password, admin_status) VALUE('" . $tenadmin . "','" . $hashed_password . "','" . $admin_status . "')";
    mysqli_query($mysqli, $sql_them);
    header('Location:../../index.php?action=quanLyAdmin&query=them');
} elseif (isset($_POST['suaTen'])) {
    $tenadmin = $_POST['tenadmin'];
    $sql_update = "UPDATE tbl_admin SET user_name='" . $tenadmin . "' WHERE id_ad= '$_GET[id]'";
    mysqli_query($mysqli, $sql_update);
    header('Location:../../index.php?action=quanLyAdmin&query=them');
} else {
    $id = $_GET['id'];
    $sql_xoa = "DELETE FROM tbl_admin WHERE id_ad='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../../index.php?action=quanLyAdmin&query=them');
}
