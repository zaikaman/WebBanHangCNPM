<?php
session_start();
include("../../admincp/config/config.php");
// thêm vào giỏ hàng
if (isset($_POST['themgiohang'])) {
    //    RESET SESSTION 
    // if (session_status() == PHP_SESSION_NONE) {
    //     session_start();
    // }
    // session_destroy();
    $id = $_GET['idsanpham'];
    $so_luong = $_POST['so_luong'];
    $sql = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '" . $id . "' LIMIT 1 ";
    $query = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
        $new_product = array(array(
            'ten_sp' => $row['ten_sp'],
            'id' => $id,
            'so_luong' => $so_luong,
            'gia_sp' => $row['gia_sp'],
            'hinh_anh' => $row['hinh_anh'],
            'ma_sp' => $row['ma_sp']
        ));
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            $found = false;
            $product = array();
            foreach ($_SESSION['cart'] as $cart_item) {
                // nếu trùng sản phẩm
                if ($cart_item['id'] == $id) {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'] + $so_luong,
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp']
                    );
                    $found = true;
                } else {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'],
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp']

                    );
                }
            }
            if ($found == false) {
                $_SESSION['cart'] = array_merge($product, $new_product);
                // echo 'ko trùng';
                // print_r($_SESSION['cart']);
            } else {
                $_SESSION['cart'] = $product;
                // echo 'trùng';
                // print_r($_SESSION['cart']);
            }
        } else {
            $_SESSION['cart'] = $new_product;
            // echo 'Tạo mới session';
            // print_r($_SESSION['cart']);
        }
    }
    header('Location:../../index.php?quanly=sanpham&id=' . $id . '&additem_success=1');
}

// xóa tất cả
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['cart']);
    header('Location:../../index.php?quanly=giohang');
}
// xóa sản phẩm
if (isset($_GET['xoa']) && isset($_SESSION['cart'])) {
    $id = $_GET['xoa'];
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] != $id) {
            $product[] = array(
                'ten_sp' => $cart_item['ten_sp'],
                'id' => $cart_item['id'],
                'so_luong' => $cart_item['so_luong'],
                'gia_sp' => $cart_item['gia_sp'],
                'hinh_anh' => $cart_item['hinh_anh'],
                'ma_sp' => $cart_item['ma_sp']
            );
        }
        $_SESSION['cart'] = $product;
    }
    echo "<script>window.location.href='../../index.php?quanly=giohang';</script>";
}
//thêm số lượng

if (isset($_GET['cong'])) {
    $id = $_GET['cong'];
    $sql_pro = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '" . $id . "' LIMIT 1";
    $pro = mysqli_query($mysqli, $sql_pro);
    $row = mysqli_fetch_array($pro);
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] != $id) {
            $product[] = array(
                'ten_sp' => $cart_item['ten_sp'],
                'id' => $cart_item['id'],
                'so_luong' => $cart_item['so_luong'],
                'gia_sp' => $cart_item['gia_sp'],
                'hinh_anh' => $cart_item['hinh_anh'],
                'ma_sp' => $cart_item['ma_sp']
            );
            $_SESSION['cart'] = $product;
        } else {
            if ($cart_item['so_luong'] <= $row['so_luong']) {
                $tangso_luong = $cart_item['so_luong'] + 1;
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $tangso_luong,
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp']
                );
            } else {
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $cart_item['so_luong'],
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp']
                );
            }
            $_SESSION['cart'] = $product;
        }
    }
    header('Location:../../index.php?quanly=giohang');
}
// trừ số lượng
if (isset($_GET['tru'])) {
    $id = $_GET['tru'];
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] != $id) {
            $product[] = array(
                'ten_sp' => $cart_item['ten_sp'],
                'id' => $cart_item['id'],
                'so_luong' => $cart_item['so_luong'],
                'gia_sp' => $cart_item['gia_sp'],
                'hinh_anh' => $cart_item['hinh_anh'],
                'ma_sp' => $cart_item['ma_sp']
            );
            $_SESSION['cart'] = $product;
        } else {
            if ($cart_item['so_luong'] == 0) {
            } elseif ($cart_item['so_luong'] > 0) {
                $tangso_luong = $cart_item['so_luong'] - 1;
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $tangso_luong,
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp']
                );
            } else {
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $cart_item['so_luong'],
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp']
                );
            }
            $_SESSION['cart'] = $product;
        }
    }
    header('Location:../../index.php?quanly=giohang');
}
