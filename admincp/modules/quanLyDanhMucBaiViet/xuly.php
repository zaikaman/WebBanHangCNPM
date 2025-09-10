<?php
// Authentication check
session_start();
if(!isset($_SESSION['dangNhap'])) {
    header('Location: ../../login.php');
    exit;
}

include('..//..//config/config.php');

function validateCategoryName($name) {
    // Tên danh mục 2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng
    return preg_match('/^[a-zA-Z0-9\s\p{L}]{2,100}$/u', trim($name));
}

function isDuplicateCategory($mysqli, $name, $excludeId = null) {
    $name = mysqli_real_escape_string($mysqli, trim($name));
    $sql = "SELECT COUNT(*) as count FROM tbl_danhmuc_baiviet WHERE tendanhmuc_baiviet = '$name'";
    if ($excludeId) {
        $sql .= " AND id_baiviet != $excludeId";
    }
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

if(isset($_POST['themDanhMucBaiViet'])) {
    $tenDanhMuc = trim($_POST['tendanhmucbaiviet']);
    
    // Validate empty
    if(empty($tenDanhMuc)) {
        echo "<script>
            alert('Tên danh mục không được để trống!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
        exit;
    }
    
    // Validate format
    if(!validateCategoryName($tenDanhMuc)) {
        echo "<script>
            alert('Tên danh mục không hợp lệ (2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng)');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
        exit;
    }
    
    // Validate duplicate
    if(isDuplicateCategory($mysqli, $tenDanhMuc)) {
        echo "<script>
            alert('Tên danh mục đã tồn tại!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
        exit;
    }

    // Insert category
    $sql_them = "INSERT INTO tbl_danhmuc_baiviet(tendanhmuc_baiviet) VALUE(?)";
    $stmt = mysqli_prepare($mysqli, $sql_them);
    mysqli_stmt_bind_param($stmt, "s", $tenDanhMuc);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Thêm danh mục thành công!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
    }

} elseif(isset($_POST['suaDanhMucBaiViet'])) {
    $tenDanhMuc = trim($_POST['tendanhmucbaiviet']);
    $id = $_GET['idbaiviet'];
    
    // Validate empty
    if(empty($tenDanhMuc)) {
        echo "<script>
            alert('Tên danh mục không được để trống!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=$id';
        </script>";
        exit;
    }
    
    // Validate format
    if(!validateCategoryName($tenDanhMuc)) {
        echo "<script>
            alert('Tên danh mục không hợp lệ (2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng)');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=$id';
        </script>";
        exit;
    }
    
    // Validate duplicate
    if(isDuplicateCategory($mysqli, $tenDanhMuc, $id)) {
        echo "<script>
            alert('Tên danh mục đã tồn tại!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=$id';
        </script>";
        exit;
    }

    // Update category
    $sql_update = "UPDATE tbl_danhmuc_baiviet SET tendanhmuc_baiviet=? WHERE id_baiviet=?";
    $stmt = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt, "si", $tenDanhMuc, $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Cập nhật danh mục thành công!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=$id';
        </script>";
    }

} else {
    // Delete category
    $id = $_GET['idbaiviet'];
    
    // Update articles to "no category" (id_danhmuc = 0)
    $sql_update_articles = "UPDATE tbl_baiviet SET id_danhmuc = 0 WHERE id_danhmuc = ?";
    $stmt = mysqli_prepare($mysqli, $sql_update_articles);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    // Delete the category
    $sql_xoa = "DELETE FROM tbl_danhmuc_baiviet WHERE id_baiviet = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Xóa danh mục thành công!');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyDanhMucBaiViet&query=them';
        </script>";
    }
}
?>
