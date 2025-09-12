<?php
session_start();
include("../../admincp/config/config.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';
$size = $_POST['size'] ?? '';

switch ($action) {
    case 'update_quantity':
        $new_quantity = intval($_POST['quantity'] ?? 0);
        if ($new_quantity < 1) {
            echo json_encode(['success' => false, 'message' => 'Số lượng phải lớn hơn 0']);
            exit;
        }
        
        // Kiểm tra số lượng tồn kho
        $sql_pro = "SELECT so_luong_con_lai FROM tbl_sanpham WHERE id_sp = '" . $id . "' LIMIT 1";
        $pro = mysqli_query($mysqli, $sql_pro);
        $row = mysqli_fetch_array($pro);
        
        if ($new_quantity > $row['so_luong_con_lai']) {
            echo json_encode(['success' => false, 'message' => 'Số lượng vượt quá tồn kho (' . $row['so_luong_con_lai'] . ')']);
            exit;
        }
        
        $product = array();
        $updated = false;
        foreach ($_SESSION['cart'] as $cart_item) {
            if ($cart_item['id'] == $id && $cart_item['size'] == $size) {
                $product[] = array(
                    'ten_sp' => $cart_item['ten_sp'],
                    'id' => $cart_item['id'],
                    'so_luong' => $new_quantity,
                    'gia_sp' => $cart_item['gia_sp'],
                    'hinh_anh' => $cart_item['hinh_anh'],
                    'ma_sp' => $cart_item['ma_sp'],
                    'size' => $cart_item['size']
                );
                $updated = true;
            } else {
                $product[] = $cart_item;
            }
        }
        
        if ($updated) {
            $_SESSION['cart'] = $product;
            echo json_encode(['success' => true, 'message' => 'Cập nhật số lượng thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }
        break;
        
    case 'update_size':
        $new_size = $_POST['new_size'] ?? '';
        if (empty($new_size)) {
            echo json_encode(['success' => false, 'message' => 'Size không được để trống']);
            exit;
        }
        
        $product = array();
        $updated = false;
        $found_duplicate = false;
        
        // Kiểm tra xem có sản phẩm cùng id và size mới không
        foreach ($_SESSION['cart'] as $cart_item) {
            if ($cart_item['id'] == $id && $cart_item['size'] == $new_size && $cart_item['size'] != $size) {
                $found_duplicate = true;
                break;
            }
        }
        
        if ($found_duplicate) {
            // Nếu có trùng, gộp số lượng
            foreach ($_SESSION['cart'] as $cart_item) {
                if ($cart_item['id'] == $id && $cart_item['size'] == $size) {
                    // Bỏ qua item cũ
                    $updated = true;
                    continue;
                } else if ($cart_item['id'] == $id && $cart_item['size'] == $new_size) {
                    // Cộng số lượng vào item có size mới
                    $old_quantity = 0;
                    foreach ($_SESSION['cart'] as $old_item) {
                        if ($old_item['id'] == $id && $old_item['size'] == $size) {
                            $old_quantity = $old_item['so_luong'];
                            break;
                        }
                    }
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'] + $old_quantity,
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp'],
                        'size' => $cart_item['size']
                    );
                } else {
                    $product[] = $cart_item;
                }
            }
        } else {
            // Nếu không trùng, chỉ cập nhật size
            foreach ($_SESSION['cart'] as $cart_item) {
                if ($cart_item['id'] == $id && $cart_item['size'] == $size) {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'],
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp'],
                        'size' => $new_size
                    );
                    $updated = true;
                } else {
                    $product[] = $cart_item;
                }
            }
        }
        
        if ($updated) {
            $_SESSION['cart'] = $product;
            echo json_encode(['success' => true, 'message' => 'Cập nhật size thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }
        break;
        
    case 'increase_quantity':
        $sql_pro = "SELECT so_luong_con_lai FROM tbl_sanpham WHERE id_sp = '" . $id . "' LIMIT 1";
        $pro = mysqli_query($mysqli, $sql_pro);
        $row = mysqli_fetch_array($pro);
        
        $product = array();
        $updated = false;
        foreach ($_SESSION['cart'] as $cart_item) {
            if ($cart_item['id'] == $id && $cart_item['size'] == $size) {
                if ($cart_item['so_luong'] < $row['so_luong_con_lai']) {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'] + 1,
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp'],
                        'size' => $cart_item['size']
                    );
                    $updated = true;
                } else {
                    $product[] = $cart_item;
                    echo json_encode(['success' => false, 'message' => 'Đã đạt số lượng tối đa']);
                    exit;
                }
            } else {
                $product[] = $cart_item;
            }
        }
        
        if ($updated) {
            $_SESSION['cart'] = $product;
            echo json_encode(['success' => true, 'message' => 'Tăng số lượng thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }
        break;
        
    case 'decrease_quantity':
        $product = array();
        $updated = false;
        foreach ($_SESSION['cart'] as $cart_item) {
            if ($cart_item['id'] == $id && $cart_item['size'] == $size) {
                if ($cart_item['so_luong'] > 1) {
                    $product[] = array(
                        'ten_sp' => $cart_item['ten_sp'],
                        'id' => $cart_item['id'],
                        'so_luong' => $cart_item['so_luong'] - 1,
                        'gia_sp' => $cart_item['gia_sp'],
                        'hinh_anh' => $cart_item['hinh_anh'],
                        'ma_sp' => $cart_item['ma_sp'],
                        'size' => $cart_item['size']
                    );
                    $updated = true;
                } else {
                    // Nếu số lượng = 1, xóa sản phẩm
                    $updated = true;
                }
            } else {
                $product[] = $cart_item;
            }
        }
        
        if ($updated) {
            $_SESSION['cart'] = $product;
            echo json_encode(['success' => true, 'message' => 'Giảm số lượng thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }
        break;
        
    case 'remove_item':
        $product = array();
        $updated = false;
        foreach ($_SESSION['cart'] as $cart_item) {
            if (!($cart_item['id'] == $id && $cart_item['size'] == $size)) {
                $product[] = $cart_item;
            } else {
                $updated = true;
            }
        }
        
        if ($updated) {
            $_SESSION['cart'] = $product;
            echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ']);
        break;
}
?>