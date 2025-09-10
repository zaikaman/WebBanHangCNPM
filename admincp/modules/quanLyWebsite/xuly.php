<?php
// Authentication check
session_start();
if(!isset($_SESSION['dangNhap'])) {
    header('Location: ../../login.php');
    exit;
}

include('..//..//config/config.php');

function validateContactInfo($data) {
    $errors = [];
    
    // Validate empty fields
    $required_fields = ['diachi', 'sodienthoai', 'email', 'tencongty'];
    foreach($required_fields as $field) {
        if(empty(trim($data[$field]))) {
            $errors[] = ucfirst($field) . ' không được để trống';
        }
    }
    
    // Validate formats
    if(!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ';
    }
    
    if(!empty($data['sodienthoai']) && !preg_match('/^[0-9]{10,11}$/', $data['sodienthoai'])) {
        $errors[] = 'Số điện thoại không hợp lệ (10-11 số)';
    }
    
    if(!empty($data['tencongty']) && !preg_match('/^[a-zA-Z0-9\s\p{L}]{2,100}$/u', $data['tencongty'])) {
        $errors[] = 'Tên công ty không hợp lệ';
    }
    
    return $errors;
}

if(isset($_POST['capnhatthongtin'])) {
    $errors = validateContactInfo($_POST);
    
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLyWebsite&query=capnhat';
        </script>";
        exit;
    }
    
    $diachi = mysqli_real_escape_string($mysqli, trim($_POST['diachi']));
    $sodienthoai = mysqli_real_escape_string($mysqli, trim($_POST['sodienthoai']));
    $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    $tencongty = mysqli_real_escape_string($mysqli, trim($_POST['tencongty']));
    
    $sql_update = "UPDATE tbl_lienhe SET 
                   diachi=?, sodienthoai=?, email=?, tencongty=?";
    
    $stmt = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt, "ssss", $diachi, $sodienthoai, $email, $tencongty);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Cập nhật thông tin liên hệ thành công!');
            window.location.href='../../index.php?action=quanLyWebsite&query=capnhat';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyWebsite&query=capnhat';
        </script>";
    }
}
?> 