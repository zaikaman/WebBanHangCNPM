<?php
// Authentication check
session_start();
if(!isset($_SESSION['dangNhap'])) {
    header('Location: ../../login.php');
    exit;
}

// Start output buffering
ob_start();

include('../../config/config.php');

// Debug function - ghi log vào file
function debug_log($message) {
    $log_file = __DIR__ . '/../../debug_xuly.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
}

// LOG EVERYTHING FIRST
debug_log("==========================================");
debug_log("Script started");
debug_log("POST keys: " . implode(', ', array_keys($_POST)));
debug_log("Has themsanpham: " . (isset($_POST['themsanpham']) ? 'YES' : 'NO'));
debug_log("Has suaSanPham: " . (isset($_POST['suaSanPham']) ? 'YES' : 'NO'));
debug_log("GET idsp: " . (isset($_GET['idsp']) ? $_GET['idsp'] : 'NONE'));
debug_log("==========================================");

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
    
    // Disable quantity empty check - allow 0 quantity for specific sizes
    // if(empty(trim($data['so_luong']))) {
    //     $errors[] = 'Số lượng không được để trống';
    // }
    
    if(!$isEdit && empty($_FILES['hinh_anh']['name'])) {
        $errors[] = 'Ảnh chính không được để trống';
    }
    
    if(empty(trim($data['tom_tat']))) {
        $errors[] = 'Mô tả không được để trống';
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

    // Disable quantity validation - allow 0 or positive numbers for specific sizes
    // if(!empty($data['so_luong']) && (!is_numeric($data['so_luong']) || $data['so_luong'] < 0)) {
    //     $errors[] = 'Số lượng phải là số dương';
    // }

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

    // Validate images if uploaded (kiểm tra cả 3 ảnh)
    $imageFields = ['hinh_anh', 'hinh_anh_2', 'hinh_anh_3'];
    foreach($imageFields as $field) {
        if(!empty($_FILES[$field]['name'])) {
            // Check if file was uploaded without errors
            if($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Có lỗi khi upload $field";
            } else {
                $imageFileType = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
                
                // Check if image file is actual image
                $check = getimagesize($_FILES[$field]['tmp_name']);
                if($check === false) {
                    $errors[] = "File $field không phải là hình ảnh";
                }
                
                // Check file size (max 5MB)
                if ($_FILES[$field]['size'] > 5000000) {
                    $errors[] = "File $field quá lớn! Vui lòng chọn file nhỏ hơn 5MB";
                }
                
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $errors[] = "File $field chỉ chấp nhận JPG, JPEG, PNG & GIF";
                }
            }
        }
    }

    return $errors;
}

// Helper function to upload image
function uploadImage($fileInputName, $masp, $imageNumber = '') {
    if(empty($_FILES[$fileInputName]['name'])) {
        debug_log("uploadImage: No file for $fileInputName");
        return null;
    }
    
    debug_log("uploadImage: Processing $fileInputName");
    debug_log("File info: " . print_r($_FILES[$fileInputName], true));
    
    $file_extension = strtolower(pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION));
    $suffix = $imageNumber ? '_' . $imageNumber : '';
    $safe_filename = $masp . $suffix . '_' . time() . '.' . $file_extension;
    
    // Create uploads directory if it doesn't exist
    $upload_dir = 'uploads/';
    if (!file_exists($upload_dir)) {
        debug_log("Creating uploads directory...");
        if(!mkdir($upload_dir, 0755, true)) {
            debug_log("ERROR: Failed to create uploads directory");
            return null;
        }
    }
    
    $target_path = $upload_dir . $safe_filename;
    debug_log("Attempting to move file to: $target_path");
    
    if(move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $target_path)) {
        debug_log("SUCCESS: File uploaded to $target_path");
        return $safe_filename;
    } else {
        debug_log("ERROR: Failed to move uploaded file");
        return null;
    }
}

if(isset($_POST['themsanpham'])) {
    // Debug logging
    debug_log("=== THEM SAN PHAM START ===");
    debug_log("POST data: " . print_r($_POST, true));
    debug_log("FILES data: " . print_r($_FILES, true));
    
    $errors = validateProduct($_POST, $mysqli);
    
    if(!empty($errors)) {
        debug_log("Validation errors: " . implode(', ', $errors));
        $error_message = urlencode(implode('. ', $errors));
        
        while(ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header("Location: ../../index.php?action=quanLySanPham&query=lietke&error=$error_message", true, 302);
        exit();
    }

    // Process data and insert
    $tenLoaisp = mysqli_real_escape_string($mysqli, trim($_POST['ten_sp']));
    $masp = mysqli_real_escape_string($mysqli, trim($_POST['ma_sp']));
    $giasp = (int)trim($_POST['gia_sp']);
    
    debug_log("Product info - Name: $tenLoaisp, Code: $masp, Price: $giasp");
    
    // Get quantities for each size
    $sizes = [
        'S' => (int)($_POST['so_luong_s'] ?? 0),
        'M' => (int)($_POST['so_luong_m'] ?? 0),
        'L' => (int)($_POST['so_luong_l'] ?? 0),
        'XL' => (int)($_POST['so_luong_xl'] ?? 0),
        'XXL' => (int)($_POST['so_luong_xxl'] ?? 0)
    ];
    $total_quantity = array_sum($sizes);

    debug_log("Total quantity: $total_quantity");
    debug_log("Sizes: " . print_r($sizes, true));

    if ($total_quantity <= 0) {
        debug_log("ERROR: Total quantity is 0");
        $error_message = urlencode("Tổng số lượng sản phẩm phải lớn hơn 0.");
        
        while(ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header("Location: ../../index.php?action=quanLySanPham&query=lietke&error=$error_message", true, 302);
        exit();
    }

    // Upload 3 ảnh
    debug_log("Starting image upload...");
    $hinhanh = uploadImage('hinh_anh', $masp, '1');
    $hinhanh_2 = uploadImage('hinh_anh_2', $masp, '2');
    $hinhanh_3 = uploadImage('hinh_anh_3', $masp, '3');
    
    // Convert null to empty string for optional images (MySQL compatibility)
    $hinhanh_2 = $hinhanh_2 ?? '';
    $hinhanh_3 = $hinhanh_3 ?? '';
    
    debug_log("Image 1: " . ($hinhanh ?: 'NULL'));
    debug_log("Image 2: " . ($hinhanh_2 ?: 'NULL'));
    debug_log("Image 3: " . ($hinhanh_3 ?: 'NULL'));
    
    if(!$hinhanh) {
        debug_log("ERROR: Failed to upload main image");
        
        while(ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header("Location: ../../index.php?action=quanLySanPham&query=lietke&error=" . urlencode("Không thể upload ảnh chính!"), true, 302);
        exit();
    }

    $tomtat = mysqli_real_escape_string($mysqli, str_replace("\r\n", "\n", trim($_POST['tom_tat'])));
    $noidung = ''; // Không còn sử dụng nội dung chi tiết
    $tinhtrang = (int)$_POST['tinh_trang'];
    $iddm = (int)$_POST['id_dm'];
    
    debug_log("Preparing SQL insert...");
    debug_log("Values: name=$tenLoaisp, code=$masp, price=$giasp, qty=$total_quantity, img1=$hinhanh, img2=$hinhanh_2, img3=$hinhanh_3");
    
    $sql_them = "INSERT INTO tbl_sanpham(ten_sp, ma_sp, gia_sp, so_luong, so_luong_con_lai, hinh_anh, hinh_anh_2, hinh_anh_3, tom_tat, noi_dung, tinh_trang, id_dm) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                 
    $stmt = mysqli_prepare($mysqli, $sql_them);
    
    if(!$stmt) {
        debug_log("ERROR: Failed to prepare statement: " . mysqli_error($mysqli));
        
        while(ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header("Location: ../../index.php?action=quanLySanPham&query=lietke&error=" . urlencode("Lỗi chuẩn bị câu lệnh SQL: " . mysqli_error($mysqli)), true, 302);
        exit();
    }
    
    // Bind parameters - use empty string for NULL images
    // Bind parameters - use empty string for NULL images
    mysqli_stmt_bind_param($stmt, "ssiisssssiii", $tenLoaisp, $masp, $giasp, $total_quantity, $total_quantity, $hinhanh, $hinhanh_2, $hinhanh_3, $tomtat, $noidung, $tinhtrang, $iddm);
    
    debug_log("Executing SQL insert...");
    if(mysqli_stmt_execute($stmt)) {
        $new_product_id = mysqli_insert_id($mysqli);
        debug_log("Product inserted successfully! ID: $new_product_id");

        // Insert into tbl_sanpham_sizes
        $sql_size_insert = "INSERT INTO tbl_sanpham_sizes (id_sp, size, so_luong) VALUES (?, ?, ?)";
        $stmt_size = mysqli_prepare($mysqli, $sql_size_insert);

        $sizes_inserted = 0;
        foreach ($sizes as $size => $quantity) {
            if ($quantity > 0) {
                mysqli_stmt_bind_param($stmt_size, "isi", $new_product_id, $size, $quantity);
                if(mysqli_stmt_execute($stmt_size)) {
                    $sizes_inserted++;
                    debug_log("Inserted size $size with quantity $quantity");
                } else {
                    debug_log("ERROR inserting size $size: " . mysqli_error($mysqli));
                }
            }
        }
        mysqli_stmt_close($stmt_size);
        mysqli_stmt_close($stmt);
        
        debug_log("Total sizes inserted: $sizes_inserted");
        debug_log("Redirecting to success page...");

        // Clear ALL output buffers
        while(ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Redirect
        header("Location: ../../index.php?action=quanLySanPham&query=lietke&success=add", true, 302);
        exit();
    } else {
        debug_log("ERROR executing SQL: " . mysqli_error($mysqli));
        debug_log("SQL Error number: " . mysqli_errno($mysqli));
        mysqli_stmt_close($stmt);
        $error_message = urlencode("Có lỗi xảy ra: " . mysqli_error($mysqli));
        
        while(ob_get_level() > 0) {
            ob_end_clean();
        }
        
        header("Location: ../../index.php?action=quanLySanPham&query=lietke&error=$error_message", true, 302);
        exit();
    }

} elseif(isset($_POST['suaSanPham'])) {
    // Validation logic can be improved, but for now, we focus on the update mechanism.
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
    $giasp = (int)trim($_POST['gia_sp']);
    $tomtat = mysqli_real_escape_string($mysqli, str_replace("\r\n", "\n", trim($_POST['tom_tat'])));
    $noidung = ''; // Không còn sử dụng nội dung chi tiết
    $tinhtrang = (int)$_POST['tinh_trang'];
    $iddm = (int)$_POST['id_dm'];

    // Get quantities for each size
    $sizes = [
        'S' => (int)($_POST['so_luong_s'] ?? 0),
        'M' => (int)($_POST['so_luong_m'] ?? 0),
        'L' => (int)($_POST['so_luong_l'] ?? 0),
        'XL' => (int)($_POST['so_luong_xl'] ?? 0),
        'XXL' => (int)($_POST['so_luong_xxl'] ?? 0)
    ];
    $total_quantity = array_sum($sizes);

    // Get product ID from ma_sp
    $sql_get_id = "SELECT id_sp, hinh_anh, hinh_anh_2, hinh_anh_3 FROM tbl_sanpham WHERE ma_sp = ? LIMIT 1";
    $stmt_get_id = mysqli_prepare($mysqli, $sql_get_id);
    mysqli_stmt_bind_param($stmt_get_id, "s", $_GET['idsp']);
    mysqli_stmt_execute($stmt_get_id);
    $result_get_id = mysqli_stmt_get_result($stmt_get_id);
    $product_row = mysqli_fetch_assoc($result_get_id);
    $product_id = $product_row['id_sp'];
    $old_hinhanh = $product_row['hinh_anh'];
    $old_hinhanh_2 = $product_row['hinh_anh_2'];
    $old_hinhanh_3 = $product_row['hinh_anh_3'];
    mysqli_stmt_close($stmt_get_id);

    if (!$product_id) {
        echo "<script>alert('Lỗi: Không tìm thấy sản phẩm.'); window.history.back();</script>";
        exit();
    }

    // Xử lý upload ảnh 1 (ảnh chính)
    $hinhanh_to_update = $old_hinhanh;
    if(!empty($_FILES['hinh_anh']['name'])) {
        if ($old_hinhanh && file_exists('uploads/' . $old_hinhanh)) {
            unlink('uploads/' . $old_hinhanh);
        }
        $hinhanh_to_update = uploadImage('hinh_anh', $masp, '1');
        if(!$hinhanh_to_update) {
            $hinhanh_to_update = $old_hinhanh; // Giữ ảnh cũ nếu upload thất bại
        }
    }

    // Xử lý upload ảnh 2
    $hinhanh_2_to_update = $old_hinhanh_2;
    if(isset($_POST['xoa_anh_2']) && $_POST['xoa_anh_2'] == '1') {
        // Xóa ảnh 2
        if ($old_hinhanh_2 && file_exists('uploads/' . $old_hinhanh_2)) {
            unlink('uploads/' . $old_hinhanh_2);
        }
        $hinhanh_2_to_update = NULL;
    } elseif(!empty($_FILES['hinh_anh_2']['name'])) {
        if ($old_hinhanh_2 && file_exists('uploads/' . $old_hinhanh_2)) {
            unlink('uploads/' . $old_hinhanh_2);
        }
        $hinhanh_2_to_update = uploadImage('hinh_anh_2', $masp, '2');
        if(!$hinhanh_2_to_update) {
            $hinhanh_2_to_update = $old_hinhanh_2; // Giữ ảnh cũ nếu upload thất bại
        }
    }

    // Xử lý upload ảnh 3
    $hinhanh_3_to_update = $old_hinhanh_3;
    if(isset($_POST['xoa_anh_3']) && $_POST['xoa_anh_3'] == '1') {
        // Xóa ảnh 3
        if ($old_hinhanh_3 && file_exists('uploads/' . $old_hinhanh_3)) {
            unlink('uploads/' . $old_hinhanh_3);
        }
        $hinhanh_3_to_update = NULL;
    } elseif(!empty($_FILES['hinh_anh_3']['name'])) {
        if ($old_hinhanh_3 && file_exists('uploads/' . $old_hinhanh_3)) {
            unlink('uploads/' . $old_hinhanh_3);
        }
        $hinhanh_3_to_update = uploadImage('hinh_anh_3', $masp, '3');
        if(!$hinhanh_3_to_update) {
            $hinhanh_3_to_update = $old_hinhanh_3; // Giữ ảnh cũ nếu upload thất bại
        }
    }

    // Update main product table
    $sql_update = "UPDATE tbl_sanpham SET 
        ten_sp=?, ma_sp=?, gia_sp=?, so_luong=?, so_luong_con_lai=?,
        hinh_anh=?, hinh_anh_2=?, hinh_anh_3=?, tom_tat=?, noi_dung=?, tinh_trang=?, id_dm=? 
        WHERE id_sp=?";
    $stmt_update = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssiiisssssiii", 
        $tenLoaisp, $masp, $giasp, $total_quantity, $total_quantity,
        $hinhanh_to_update, $hinhanh_2_to_update, $hinhanh_3_to_update, $tomtat, $noidung, $tinhtrang, $iddm, $product_id);

    if(mysqli_stmt_execute($stmt_update)) {
        // Update sizes table: delete old entries and insert new ones
        $sql_delete_sizes = "DELETE FROM tbl_sanpham_sizes WHERE id_sp = ?";
        $stmt_delete = mysqli_prepare($mysqli, $sql_delete_sizes);
        mysqli_stmt_bind_param($stmt_delete, "i", $product_id);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);

        $sql_size_insert = "INSERT INTO tbl_sanpham_sizes (id_sp, size, so_luong) VALUES (?, ?, ?)";
        $stmt_size = mysqli_prepare($mysqli, $sql_size_insert);
        foreach ($sizes as $size => $quantity) {
            if ($quantity >= 0) { // Also save sizes with 0 quantity
                mysqli_stmt_bind_param($stmt_size, "isi", $product_id, $size, $quantity);
                mysqli_stmt_execute($stmt_size);
            }
        }
        mysqli_stmt_close($stmt_size);

        echo "<script>
            alert('Cập nhật sản phẩm thành công!');
            window.location.href='../../index.php?action=quanLySanPham&query=lietke';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra khi cập nhật: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLySanPham&query=sua&idsp=" . $_GET['idsp'] . "';
        </script>";
    }
    mysqli_stmt_close($stmt_update);
} elseif(isset($_GET['idsp']) && !isset($_POST['themsanpham']) && !isset($_POST['suaSanPham'])) {
    // Delete product - only execute if explicitly requested via GET parameter without POST data
    $id = $_GET['idsp'];
    
    // Get product info including all images
    $sql = "SELECT id_sp, hinh_anh, hinh_anh_2, hinh_anh_3 FROM tbl_sanpham WHERE ma_sp = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    
    if($row) {
        $product_id = $row['id_sp'];
        
        // Delete all image files
        if($row['hinh_anh'] && file_exists('uploads/' . $row['hinh_anh'])) {
            unlink('uploads/' . $row['hinh_anh']);
        }
        if($row['hinh_anh_2'] && file_exists('uploads/' . $row['hinh_anh_2'])) {
            unlink('uploads/' . $row['hinh_anh_2']);
        }
        if($row['hinh_anh_3'] && file_exists('uploads/' . $row['hinh_anh_3'])) {
            unlink('uploads/' . $row['hinh_anh_3']);
        }
        
        // Delete from sizes table first
        $sql_delete_sizes = "DELETE FROM tbl_sanpham_sizes WHERE id_sp = ?";
        $stmt_delete_sizes = mysqli_prepare($mysqli, $sql_delete_sizes);
        mysqli_stmt_bind_param($stmt_delete_sizes, "i", $product_id);
        mysqli_stmt_execute($stmt_delete_sizes);
        mysqli_stmt_close($stmt_delete_sizes);
        
        // Delete product record
        $sql_xoa = "DELETE FROM tbl_sanpham WHERE ma_sp = ?";
        $stmt_delete = mysqli_prepare($mysqli, $sql_xoa);
        mysqli_stmt_bind_param($stmt_delete, "s", $id);
        
        if(mysqli_stmt_execute($stmt_delete)) {
            echo "<script>
                alert('Xóa sản phẩm thành công!');
                window.location.href='../../index.php?action=quanLySanPham&query=lietke';
            </script>";
        } else {
            echo "<script>
                alert('Có lỗi xảy ra khi xóa sản phẩm: " . mysqli_error($mysqli) . "');
                window.location.href='../../index.php?action=quanLySanPham&query=lietke';
            </script>";
        }
        mysqli_stmt_close($stmt_delete);
    } else {
        echo "<script>
            alert('Không tìm thấy sản phẩm cần xóa!');
            window.location.href='../../index.php?action=quanLySanPham&query=lietke';
        </script>";
    }
    mysqli_stmt_close($stmt);
}
?>
