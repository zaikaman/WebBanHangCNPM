<?php
include('..//..//config/config.php');

if(isset($_POST['themSanPham'])) {
    // Validate required fields
    $errors = [];
    
    // Validate empty fields
    if(empty(trim($_POST['ten_sp']))) {
        $errors[] = 'Tên sản phẩm không được để trống';
    }
    
    if(empty(trim($_POST['ma_sp']))) {
        $errors[] = 'Mã sản phẩm không được để trống';
    }
    
    if(empty(trim($_POST['gia_sp']))) {
        $errors[] = 'Giá sản phẩm không được để trống';
    }
    
    if(empty(trim($_POST['so_luong']))) {
        $errors[] = 'Số lượng không được để trống';
    }
    
    if(empty($_FILES['hinh_anh']['name'])) {
        $errors[] = 'Hình ảnh không được để trống';
    }
    
    if(empty(trim($_POST['tom_tat']))) {
        $errors[] = 'Tóm tắt không được để trống';
    }
    
    if(empty(trim($_POST['noi_dung']))) {
        $errors[] = 'Nội dung không được để trống';
    }
    
    if(empty($_POST['id_dm'])) {
        $errors[] = 'Vui lòng chọn danh mục sản phẩm';
    }
    
    if(!isset($_POST['tinh_trang'])) {
        $errors[] = 'Vui lòng chọn tình trạng sản phẩm';
    }

    // Validate product name format
    if(!preg_match('/^[a-zA-Z0-9\s\p{L}]{2,100}$/u', trim($_POST['ten_sp']))) {
        $errors[] = 'Tên sản phẩm không hợp lệ (2-100 ký tự, chỉ chứa chữ cái, số và khoảng trắng)';
    }

    // Validate quantity format
    if(!is_numeric($_POST['so_luong']) || $_POST['so_luong'] < 0) {
        $errors[] = 'Số lượng phải là số dương';
    }

    // Validate price format 
    if(!is_numeric($_POST['gia_sp']) || $_POST['gia_sp'] < 0) {
        $errors[] = 'Giá sản phẩm phải là số dương';
    }

    // If there are validation errors
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLySanPham&query=them';
        </script>";
        exit();
    }

    // If validation passes, proceed with product insertion
    if(empty($errors)) {
        $tenLoaisp = mysqli_real_escape_string($mysqli, trim($_POST['ten_sp']));
        $masp = mysqli_real_escape_string($mysqli, trim($_POST['ma_sp']));
        $giasp = mysqli_real_escape_string($mysqli, trim($_POST['gia_sp']));
        $soluong = mysqli_real_escape_string($mysqli, trim($_POST['so_luong']));
        $hinhanh = $_FILES['hinh_anh']['name'];
        $hinhanh_tmp = $_FILES['hinh_anh']['tmp_name'];
        $tomtat = mysqli_real_escape_string($mysqli, trim($_POST['tom_tat']));
        $noidung = mysqli_real_escape_string($mysqli, trim($_POST['noi_dung']));
        $tinhtrang = $_POST['tinh_trang'];
        $iddm = $_POST['id_dm'];
        
        // Check if product code already exists
        $sql_check = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE ma_sp = '$masp'";
        $query_check = mysqli_query($mysqli, $sql_check);
        $row_check = mysqli_fetch_assoc($query_check);
        
        if($row_check['count'] > 0) {
            echo "<script>
                alert('Mã sản phẩm đã tồn tại!');
                window.location.href='../../index.php?action=quanLySanPham&query=them';
            </script>";
            exit();
        }

        // Process image upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($hinhanh);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is actual image
        $check = getimagesize($hinhanh_tmp);
        if($check === false) {
            echo "<script>
                alert('File không phải là hình ảnh!');
                window.location.href='../../index.php?action=quanLySanPham&query=them';
            </script>";
            exit();
        }
        
        // Check file size (max 5MB)
        if ($_FILES["hinh_anh"]["size"] > 5000000) {
            echo "<script>
                alert('File ảnh quá lớn! Vui lòng chọn file nhỏ hơn 5MB');
                window.location.href='../../index.php?action=quanLySanPham&query=them';
            </script>";
            exit();
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "<script>
                alert('Chỉ chấp nhận file JPG, JPEG, PNG & GIF!');
                window.location.href='../../index.php?action=quanLySanPham&query=them';
            </script>";
            exit();
        }

        // Move uploaded file
        move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh);
        
        // Insert product into database
        $sql_them = "INSERT INTO tbl_sanpham(ten_sp, ma_sp, gia_sp, so_luong, so_luong_con_lai, hinh_anh, tom_tat, noi_dung, tinh_trang, id_dm) 
                     VALUES ('$tenLoaisp', '$masp', '$giasp', '$soluong', '$soluong', '$hinhanh', '$tomtat', '$noidung', '$tinhtrang', '$iddm')";
        
        if(mysqli_query($mysqli, $sql_them)) {
            echo "<script>
                alert('Thêm sản phẩm thành công!');
                window.location.href='../../index.php?action=quanLySanPham&query=them';
            </script>";
        } else {
            echo "<script>
                alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
                window.location.href='../../index.php?action=quanLySanPham&query=them';
            </script>";
        }
    }
} elseif (isset($_POST['suaSanPham'])) {
	if ($hinhanh != '') {
		move_uploaded_file($hinhanh_tmp, 'uploads/' . $hinhanh);
		$sql = "SELECT * FROM tbl_sanpham WHERE ma_sp ='$_GET[idsp]' LIMIT 1";
		$query = mysqli_query($mysqli, $sql);
		while ($row = mysqli_fetch_array($query)) {
			unlink('uploads/' . $row['hinh_anh']);
		}
		$sql_update = "UPDATE tbl_sanpham SET ten_sp='" . $tenLoaisp . "', ma_sp='" . $masp . "', gia_sp='" . $giasp . "', so_luong='" . $soluong . "', so_luong_con_lai='" . $soluongconlai . "',hinh_anh='" . $hinhanh . "', tom_tat='" . $tomtat . "', noi_dung='" . $noidung . "', tinh_trang='" . $tinhtrang . "', id_dm='" . $iddm . "' WHERE ma_sp='$_GET[idsp]'";
	} else {
		$sql_update = "UPDATE tbl_sanpham SET ten_sp='" . $tenLoaisp . "', ma_sp='" . $masp . "', gia_sp='" . $giasp . "', so_luong='" . $soluong . "', so_luong_con_lai='" . $soluongconlai . "',tom_tat='" . $tomtat . "', noi_dung='" . $noidung . "', tinh_trang='" . $tinhtrang . "', id_dm='" . $iddm . "' WHERE ma_sp='$_GET[idsp]'";
	}
	mysqli_query($mysqli, $sql_update);
	header('Location:../../index.php?action=quanLySanPham&query=them');
} else {
	$id = $_GET['idsp'];
	$sql = "SELECT * FROM tbl_sanpham WHERE ma_sp ='$id' LIMIT 1";
	$query = mysqli_query($mysqli, $sql);
	while ($row = mysqli_fetch_array($query)) {
		unlink('uploads/' . $row['hinh_anh']);
	}
	$sql_xoa = "DELETE FROM tbl_sanpham WHERE ma_sp='" . $id . "'";
	mysqli_query($mysqli, $sql_xoa);
	// header('Location:../../index.php?action=quanLySanPham&query=them');
	echo "<script>window.location.href='../../index.php?action=quanLySanPham&query=them';</script>";
}
