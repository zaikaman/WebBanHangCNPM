<?php
include('../../config/config.php');

// Helper function to validate product
function validateProduct($data, $mysqli, $isEdit = false, $currentId = null) {
    $errors = [];
    
    // Validate empty fields
    if(empty(trim($data['ten_sp']))) {
        $errors[] = 'Tên sản phẩm không được để trống';
    }
    
    if(empty(trim($data['ma_sp']))) {
        $errors[] = 'Mã sản phẩm không được để trống';
    }
    
    if(empty(trim($data['gia_sp']))) {
        $errors[] = 'Giá sản phẩm không được để trống';
    }
    
    if(empty(trim($data['so_luong']))) {
        $errors[] = 'Số lượng không được để trống';
    }
    
    if(!$isEdit && empty($_FILES['hinh_anh']['name'])) {
        $errors[] = 'Hình ảnh không được để trống';
    }
    
    if(empty(trim($data['tom_tat']))) {
        $errors[] = 'Tóm tắt không được để trống';
    }
    
    if(empty(trim($data['noi_dung']))) {
        $errors[] = 'Nội dung không được để trống';
    }
    
    if(empty($data['id_dm'])) {
        $errors[] = 'Vui lòng chọn danh mục sản phẩm';
    }
    
    if(!isset($data['tinh_trang'])) {
        $errors[] = 'Vui lòng chọn tình trạng sản phẩm';
    }

    // Validate formats
    if(!empty($data['ten_sp']) && !preg_match('/^.{2,100}$/u', trim($data['ten_sp']))) {
        $errors[] = 'Tên sản phẩm không hợp lệ (2-100 ký tự)';
    }

    if(!empty($data['ma_sp']) && !preg_match('/^[A-Za-z0-9-]{2,20}$/', trim($data['ma_sp']))) {
        $errors[] = 'Mã sản phẩm không hợp lệ (2-20 ký tự, chỉ chứa chữ cái, số và dấu gạch ngang)';
    }

    if(!empty($data['so_luong']) && (!is_numeric($data['so_luong']) || $data['so_luong'] < 0)) {
        $errors[] = 'Số lượng phải là số dương';
    }

    if(!empty($data['gia_sp']) && (!is_numeric($data['gia_sp']) || $data['gia_sp'] < 0)) {
        $errors[] = 'Giá sản phẩm phải là số dương';
    }

    // Check for duplicates only if the fields are not empty
    if(!empty($data['ten_sp'])) {
        $sql_check_name = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE ten_sp = '" . mysqli_real_escape_string($mysqli, trim($data['ten_sp'])) . "'";
        if($isEdit) {
            $sql_check_name .= " AND ma_sp != '" . mysqli_real_escape_string($mysqli, $currentId) . "'";
        }
        $query_check_name = mysqli_query($mysqli, $sql_check_name);
        if($query_check_name) {
            $row_check_name = mysqli_fetch_assoc($query_check_name);
            if($row_check_name['count'] > 0) {
                $errors[] = 'Tên sản phẩm đã tồn tại';
            }
        }
    }
    
    if(!empty($data['ma_sp'])) {
        $sql_check_code = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE ma_sp = '" . mysqli_real_escape_string($mysqli, trim($data['ma_sp'])) . "'";
        if($isEdit) {
            $sql_check_code .= " AND ma_sp != '" . mysqli_real_escape_string($mysqli, $currentId) . "'";
        }
        $query_check_code = mysqli_query($mysqli, $sql_check_code);
        if($query_check_code) {
            $row_check_code = mysqli_fetch_assoc($query_check_code);
            if($row_check_code['count'] > 0) {
                $errors[] = 'Mã sản phẩm đã tồn tại';
            }
        }
    }

    // Validate image if uploaded
    if(!empty($_FILES['hinh_anh']['name'])) {
        // Check if file was uploaded without errors
        if($_FILES['hinh_anh']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Có lỗi khi upload file';
        } else {
            $imageFileType = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
            
            // Check if image file is actual image
            $check = getimagesize($_FILES['hinh_anh']['tmp_name']);
            if($check === false) {
                $errors[] = 'File không phải là hình ảnh';
            }
            
            // Check file size (max 5MB)
            if ($_FILES['hinh_anh']['size'] > 5000000) {
                $errors[] = 'File ảnh quá lớn! Vui lòng chọn file nhỏ hơn 5MB';
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $errors[] = 'Chỉ chấp nhận file JPG, JPEG, PNG & GIF';
            }
        }
    }

    return $errors;
}

if(isset($_POST['themsanpham'])) {
    $errors = validateProduct($_POST, $mysqli);
    
    if(!empty($errors)) {
        $error_message = urlencode(implode('. ', $errors));
        header("Location: ../../index.php?action=quanLySanPham&query=them&error=$error_message");
        exit();
    }

    // Process data and insert
    $tenLoaisp = mysqli_real_escape_string($mysqli, trim($_POST['ten_sp']));
    $masp = mysqli_real_escape_string($mysqli, trim($_POST['ma_sp']));
    $giasp = (int)trim($_POST['gia_sp']);
    $soluong = (int)trim($_POST['so_luong']);
    $hinhanh = $_FILES['hinh_anh']['name'];
    $hinhanh_tmp = $_FILES['hinh_anh']['tmp_name'];
    // Thay thế các ký tự xuống dòng Windows thành Unix style trước khi escape
    $tomtat = mysqli_real_escape_string($mysqli, str_replace("\r\n", "\n", trim($_POST['tom_tat'])));
    $noidung = mysqli_real_escape_string($mysqli, str_replace("\r\n", "\n", trim($_POST['noi_dung'])));
    $tinhtrang = (int)$_POST['tinh_trang'];
    $iddm = (int)$_POST['id_dm'];

    // Create uploads directory if it doesn't exist
    if (!file_exists('uploads/')) {
        mkdir('uploads/', 0755, true);
    }
    
    // Generate safe filename
    $file_extension = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
    $safe_filename = $masp . '_' . time() . '.' . $file_extension;
    
    // Move uploaded file
    if(!move_uploaded_file($hinhanh_tmp, 'uploads/' . $safe_filename)) {
        header("Location: ../../index.php?action=quanLySanPham&query=them&error=" . urlencode("Không thể upload file ảnh!"));
        exit();
    }
    
    // Use safe filename for database
    $hinhanh = $safe_filename;
    
    $sql_them = "INSERT INTO tbl_sanpham(ten_sp, ma_sp, gia_sp, so_luong, so_luong_con_lai, hinh_anh, tom_tat, noi_dung, tinh_trang, id_dm) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                 
    $stmt = mysqli_prepare($mysqli, $sql_them);
    mysqli_stmt_bind_param($stmt, "ssiissssii", $tenLoaisp, $masp, $giasp, $soluong, $soluong, $hinhanh, $tomtat, $noidung, $tinhtrang, $iddm);
    
    if(mysqli_stmt_execute($stmt)) {
        header("Location: ../../index.php?action=quanLySanPham&query=them&success=add");
        exit();
    } else {
        $error_message = urlencode("Có lỗi xảy ra: " . mysqli_error($mysqli));
        header("Location: ../../index.php?action=quanLySanPham&query=them&error=$error_message");
        exit();
    }

} elseif(isset($_POST['suaSanPham'])) {
    $errors = validateProduct($_POST, $mysqli, true, $_GET['idsp']);
    
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLySanPham&query=sua&idsp=" . $_GET['idsp'] . "';
        </script>";
        exit();
    }

    $tenLoaisp = mysqli_real_escape_string($mysqli, trim($_POST['ten_sp']));
    $masp = mysqli_real_escape_string($mysqli, trim($_POST['ma_sp']));
    $giasp = mysqli_real_escape_string($mysqli, trim($_POST['gia_sp']));
    $soluong = mysqli_real_escape_string($mysqli, trim($_POST['so_luong']));
    $soluongconlai = mysqli_real_escape_string($mysqli, trim($_POST['so_luong_con_lai']));
    $tomtat = mysqli_real_escape_string($mysqli, trim($_POST['tom_tat']));
    $noidung = mysqli_real_escape_string($mysqli, trim($_POST['noi_dung']));
    $tinhtrang = $_POST['tinh_trang'];
    $iddm = $_POST['id_dm'];

    if(!empty($_FILES['hinh_anh']['name'])) {
        $hinhanh = $_FILES['hinh_anh']['name'];
        $hinhanh_tmp = $_FILES['hinh_anh']['tmp_name'];
        
        // Delete old image
        $sql = "SELECT hinh_anh FROM tbl_sanpham WHERE ma_sp = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $_GET['idsp']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        if($row['hinh_anh']) {
            unlink('uploads/' . $row['hinh_anh']);
        }
        
        move_uploaded_file($hinhanh_tmp, 'uploads/' . $hinhanh);
        
        $sql_update = "UPDATE tbl_sanpham SET 
            ten_sp=?, ma_sp=?, gia_sp=?, so_luong=?, so_luong_con_lai=?,
            hinh_anh=?, tom_tat=?, noi_dung=?, tinh_trang=?, id_dm=? 
            WHERE ma_sp=?";
            
        $stmt = mysqli_prepare($mysqli, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssdddsssiis", 
            $tenLoaisp, $masp, $giasp, $soluong, $soluongconlai,
            $hinhanh, $tomtat, $noidung, $tinhtrang, $iddm, $_GET['idsp']);
    } else {
        $sql_update = "UPDATE tbl_sanpham SET 
            ten_sp=?, ma_sp=?, gia_sp=?, so_luong=?, so_luong_con_lai=?,
            tom_tat=?, noi_dung=?, tinh_trang=?, id_dm=? 
            WHERE ma_sp=?";
            
        $stmt = mysqli_prepare($mysqli, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssdddssiis", 
            $tenLoaisp, $masp, $giasp, $soluong, $soluongconlai,
            $tomtat, $noidung, $tinhtrang, $iddm, $_GET['idsp']);
    }
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Cập nhật sản phẩm thành công!');
            window.location.href='../../index.php?action=quanLySanPham&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLySanPham&query=sua&idsp=" . $_GET['idsp'] . "';
        </script>";
    }

} else {
    // Delete product
    $id = $_GET['idsp'];
    
    // Delete image file first
    $sql = "SELECT hinh_anh FROM tbl_sanpham WHERE ma_sp = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if($row['hinh_anh']) {
        unlink('uploads/' . $row['hinh_anh']);
    }
    
    // Delete product record
    $sql_xoa = "DELETE FROM tbl_sanpham WHERE ma_sp = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "s", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Xóa sản phẩm thành công!');
            window.location.href='../../index.php?action=quanLySanPham&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra khi xóa sản phẩm: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLySanPham&query=them';
        </script>";
    }
}
?>
