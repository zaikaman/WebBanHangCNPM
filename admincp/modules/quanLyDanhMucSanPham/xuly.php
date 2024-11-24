<?php
include('..//..//config/config.php');

function validateCategoryName($name) {
    // Tên danh mục 2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng
    return preg_match('/^[a-zA-Z0-9\s\p{L}]{2,100}$/u', trim($name));
}
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
    if(!validateCategoryName($tenLoaisp)) {
        echo "<script>
            alert('Tên danh mục không hợp lệ (2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng)');
            window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';
        </script>";
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
    if(!validateCategoryName($tenLoaisp)) {
        echo "<script>
            alert('Tên danh mục không hợp lệ (2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng)');
            window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';
        </script>";
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
    // Delete category
    $id = $_GET['idsp'];
    
    // Kiểm tra xem có sản phẩm nào trong danh mục không
    $sql_check = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE id_dm = ?";
    $stmt = mysqli_prepare($mysqli, $sql_check);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['count'] > 0) {
        echo "<script>
            alert('Không thể xóa danh mục này vì đang có " . $row['count'] . " sản phẩm thuộc danh mục!');
            window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';
        </script>";
    } else {
        // Thực hiện xóa danh mục khi không có sản phẩm
        $sql_xoa = "DELETE FROM tbl_danhmucqa WHERE id_dm = ?";
        $stmt = mysqli_prepare($mysqli, $sql_xoa);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if(mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('Xóa danh mục thành công!');
                window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';
            </script>";
        } else {
            echo "<script>
                alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
                window.location.href='../../index.php?action=quanLyDanhMucSanPham&query=them';
            </script>";
        }
    }
}
?>
