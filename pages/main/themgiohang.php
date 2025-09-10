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
    $size = $_POST['size'];
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
            'ma_sp' => $row['ma_sp'],
            'size' => $size
        ));
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            $found = false;
            $product = array();
            foreach ($_SESSION['cart'] as $cart_item) {
                // nếu trùng sản phẩm VÀ cùng size
                if ($cart_item['id'] == $id && $cart_item['size'] == $size) {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'] + $so_luong,
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp'],
                        'size' => $cart_item['size']
                    );
                    $found = true;
                } else {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'],
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp'],
                        'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'

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
    header('Location:/WebBanHangCNPM/index.php?quanly=sanpham&id=' . $id . '&additem_success=1');
}

// xóa tất cả
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['cart']);
    header('Location:/WebBanHangCNPM/index.php?quanly=giohang');
}
// xóa sản phẩm
if (isset($_GET['xoa']) && isset($_SESSION['cart'])) {
    $id = $_GET['xoa'];
    $size = isset($_GET['size']) ? $_GET['size'] : '';
    $product = array();
    foreach ($_SESSION['cart'] as $cart_item) {
        // Nếu có thông tin size, chỉ xóa sản phẩm có cùng id và size
        if ($size != '') {
            if (!($cart_item['id'] == $id && isset($cart_item['size']) && $cart_item['size'] == $size)) {
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $cart_item['so_luong'],
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp'],
                    'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
                );
            }
        } else {
            // Nếu không có thông tin size, xóa tất cả sản phẩm có cùng id
            if ($cart_item['id'] != $id) {
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $cart_item['so_luong'],
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp'],
                    'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
                );
            }
        }
    }
    $_SESSION['cart'] = $product;
    echo "<script>window.location.href='/WebBanHangCNPM/index.php?quanly=giohang';</script>";
}
//thêm số lượng

if (isset($_GET['cong'])) {
    $id = $_GET['cong'];
    $size = isset($_GET['size']) ? $_GET['size'] : '';
    $sql_pro = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '" . $id . "' LIMIT 1";
    $pro = mysqli_query($mysqli, $sql_pro);
    $row = mysqli_fetch_array($pro);
    $product = array();
    foreach ($_SESSION['cart'] as $cart_item) {
        // Cần check cả id và size
        $is_target_item = ($size != '') ? 
            ($cart_item['id'] == $id && isset($cart_item['size']) && $cart_item['size'] == $size) : 
            ($cart_item['id'] == $id);
            
        if (!$is_target_item) {
            $product[] = array(
                'ten_sp' => $cart_item['ten_sp'],
                'id' => $cart_item['id'],
                'so_luong' => $cart_item['so_luong'],
                'gia_sp' => $cart_item['gia_sp'],
                'hinh_anh' => $cart_item['hinh_anh'],
                'ma_sp' => $cart_item['ma_sp'],
                'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
            );
        } else {
            if ($cart_item['so_luong'] < $row['so_luong_con_lai']) {
                $tangso_luong = $cart_item['so_luong'] + 1;
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $tangso_luong,
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp'],
                    'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
                );
            } else {
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $cart_item['so_luong'],
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp'],
                    'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
                );
            }
        }
    }
    $_SESSION['cart'] = $product;
    header('Location:/WebBanHangCNPM/index.php?quanly=giohang');
}
// trừ số lượng
if (isset($_GET['tru'])) {
    $id = $_GET['tru'];
    $size = isset($_GET['size']) ? $_GET['size'] : '';
    $product = array();
    foreach ($_SESSION['cart'] as $cart_item) {
        // Cần check cả id và size
        $is_target_item = ($size != '') ? 
            ($cart_item['id'] == $id && isset($cart_item['size']) && $cart_item['size'] == $size) : 
            ($cart_item['id'] == $id);
            
        if (!$is_target_item) {
            $product[] = array(
                'ten_sp' => $cart_item['ten_sp'],
                'id' => $cart_item['id'],
                'so_luong' => $cart_item['so_luong'],
                'gia_sp' => $cart_item['gia_sp'],
                'hinh_anh' => $cart_item['hinh_anh'],
                'ma_sp' => $cart_item['ma_sp'],
                'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
            );
        } else {
            if ($cart_item['so_luong'] > 1) {
                $tangso_luong = $cart_item['so_luong'] - 1;
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $tangso_luong,
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp'],
                    'size' => isset($cart_item['size']) ? $cart_item['size'] : 'M'
                );
            } else {
                // Nếu số lượng = 1, không thêm vào giỏ (tức là xóa)
            }
        }
    }
    $_SESSION['cart'] = $product;
    header('Location:/WebBanHangCNPM/index.php?quanly=giohang');
}
