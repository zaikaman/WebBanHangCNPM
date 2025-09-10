<?php
// Authentication check
session_start();
if(!isset($_SESSION['admin'])) {
    header('Location: ../../login.php');
    exit;
}

include('../../config/config.php');

function validateArticle($data, $mysqli, $isEdit = false) {
    $errors = [];
    
    // Validate empty fields
    if(empty(trim($data['tenbaiviet']))) {
        $errors[] = 'Tên bài viết không được để trống';
    }
    
    if(!$isEdit && empty($_FILES['hinhanh']['name'])) {
        $errors[] = 'Hình ảnh không được để trống';
    }
    
    if(empty(trim($data['tomtat']))) {
        $errors[] = 'Tóm tắt không được để trống';
    }
    
    if(empty(trim($data['noidung']))) {
        $errors[] = 'Nội dung không được để trống';
    }
    
    if(empty(trim($data['link']))) {
        $errors[] = 'Link không được để trống';
    }
    
    if(empty($data['id_danhmuc'])) {
        $errors[] = 'Vui lòng chọn danh mục bài viết';
    }
    
    if(!isset($data['tinhtrang'])) {
        $errors[] = 'Vui lòng chọn tình trạng bài viết';
    }

    // Validate formats
    if(!empty($data['tenbaiviet']) && !preg_match('/^.{2,200}$/u', trim($data['tenbaiviet']))) {
        $errors[] = 'Tên bài viết không hợp lệ (2-200 ký tự)';
    }

    if(!filter_var($data['link'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Link không hợp lệ';
    }

    // Validate image if uploaded
    if(!empty($_FILES['hinhanh']['name'])) {
        $imageFileType = strtolower(pathinfo($_FILES['hinhanh']['name'], PATHINFO_EXTENSION));
        
        // Check if image file is actual image
        $check = getimagesize($_FILES['hinhanh']['tmp_name']);
        if($check === false) {
            $errors[] = 'File không phải là hình ảnh';
        }
        
        // Check file size (max 5MB)
        if ($_FILES['hinhanh']['size'] > 5000000) {
            $errors[] = 'File ảnh quá lớn! Vui lòng chọn file nhỏ hơn 5MB';
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors[] = 'Chỉ chấp nhận file JPG, JPEG, PNG & GIF';
        }
    }

    return $errors;
}

if(isset($_POST['thembaiviet'])) {
    $errors = validateArticle($_POST, $mysqli);
    
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLyBaiViet&query=them';
        </script>";
        exit();
    }

    // Process data and insert
    $tenBaiViet = mysqli_real_escape_string($mysqli, trim($_POST['tenbaiviet']));
    $tomtat = mysqli_real_escape_string($mysqli, str_replace("\r\n", "\n", trim($_POST['tomtat'])));
    $noidung = mysqli_real_escape_string($mysqli, str_replace("\r\n", "\n", trim($_POST['noidung']) ));
    $link = mysqli_real_escape_string($mysqli, trim($_POST['link']));
    $tinhtrang = $_POST['tinhtrang'];
    $iddm = $_POST['id_danhmuc'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];

    move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh);
    
    $sql_them = "INSERT INTO tbl_baiviet(tenbaiviet, hinhanh, tomtat, noidung, link, tinhtrang, id_danhmuc) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($mysqli, $sql_them);
    mysqli_stmt_bind_param($stmt, "sssssii", $tenBaiViet, $hinhanh, $tomtat, $noidung, $link, $tinhtrang, $iddm);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Thêm bài viết thành công!');
            window.location.href='../../index.php?action=quanLyBaiViet&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyBaiViet&query=them';
        </script>";
    }

} elseif(isset($_POST['suabaiviet'])) {
    $errors = validateArticle($_POST, $mysqli, true);
    
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLyBaiViet&query=sua&idbv=" . $_GET['idbv'] . "';
        </script>";
        exit();
    }

    $tenBaiViet = mysqli_real_escape_string($mysqli, trim($_POST['tenbaiviet']));
    $tomtat = mysqli_real_escape_string($mysqli, trim($_POST['tomtat']));
    $noidung = mysqli_real_escape_string($mysqli, trim($_POST['noidung']));
    $link = mysqli_real_escape_string($mysqli, trim($_POST['link']));
    $tinhtrang = $_POST['tinhtrang'];
    $iddm = $_POST['id_danhmuc'];

    if(!empty($_FILES['hinhanh']['name'])) {
        $hinhanh = $_FILES['hinhanh']['name'];
        $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
        
        // Delete old image
        $sql = "SELECT hinhanh FROM tbl_baiviet WHERE id = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_GET['idbv']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        if($row['hinhanh']) {
            unlink('uploads/' . $row['hinhanh']);
        }
        
        move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh);
        
        $sql_update = "UPDATE tbl_baiviet SET 
            tenbaiviet=?, hinhanh=?, tomtat=?, noidung=?, link=?, tinhtrang=?, id_danhmuc=? 
            WHERE id=?";
            
        $stmt = mysqli_prepare($mysqli, $sql_update);
        mysqli_stmt_bind_param($stmt, "sssssiis", 
            $tenBaiViet, $hinhanh, $tomtat, $noidung, $link, $tinhtrang, $iddm, $_GET['idbv']);
    } else {
        $sql_update = "UPDATE tbl_baiviet SET 
            tenbaiviet=?, tomtat=?, noidung=?, link=?, tinhtrang=?, id_danhmuc=? 
            WHERE id=?";
            
        $stmt = mysqli_prepare($mysqli, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssssiis", 
            $tenBaiViet, $tomtat, $noidung, $link, $tinhtrang, $iddm, $_GET['idbv']);
    }
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Cập nhật bài viết thành công!');
            window.location.href='../../index.php?action=quanLyBaiViet&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyBaiViet&query=sua&idbv=" . $_GET['idbv'] . "';
        </script>";
    }

} else {
    // Delete article
    $id = $_GET['idbv'];
    
    // Delete image file first
    $sql = "SELECT hinhanh FROM tbl_baiviet WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if($row['hinhanh']) {
        unlink('uploads/' . $row['hinhanh']);
    }
    
    // Delete article record
    $sql_xoa = "DELETE FROM tbl_baiviet WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Xóa bài viết thành công!');
            window.location.href='../../index.php?action=quanLyBaiViet&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra khi xóa bài viết: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyBaiViet&query=them';
        </script>";
    }
}
?>
