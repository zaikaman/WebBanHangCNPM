<?php
// Authentication check
session_start();
if(!isset($_SESSION['admin'])) {
    header('Location: ../../login.php');
    exit;
}

include('../../config/config.php');

function validateAdmin($username, $password) {
    $errors = [];
    
    if(empty(trim($username))) {
        $errors[] = 'Tên admin không được để trống';
    } elseif(strlen(trim($username)) < 3 || strlen(trim($username)) > 50) {
        $errors[] = 'Tên admin phải từ 3-50 ký tự';
    } elseif(!preg_match('/^[a-zA-Z0-9_]{3,50}$/', trim($username))) {
        $errors[] = 'Tên admin chỉ chứa chữ cái, số và dấu gạch dưới';
    }
    
    if(empty($password)) {
        $errors[] = 'Mật khẩu không được để trống';
    } elseif(strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải ít nhất 6 ký tự';
    }
    
    return $errors;
}

function checkDuplicateUsername($mysqli, $username, $excludeId = null) {
    $sql = "SELECT COUNT(*) as count FROM tbl_admin WHERE user_name = ?";
    if($excludeId) {
        $sql .= " AND id_ad != ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "si", $username, $excludeId);
    } else {
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $row['count'] > 0;
}

if (isset($_POST['themAdmin'])) {
    $tenadmin = trim($_POST['tenadmin']);
    $matkhau = $_POST['matkhau'];
    
    // Validation
    $errors = validateAdmin($tenadmin, $matkhau);
    
    if(checkDuplicateUsername($mysqli, $tenadmin)) {
        $errors[] = 'Tên admin đã tồn tại';
    }
    
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
        exit;
    }
    
    $admin_status = 1;
    $hashed_password = md5($matkhau); // Note: Consider using password_hash() for better security
    
    $sql_them = "INSERT INTO tbl_admin(user_name, password, admin_status) VALUES(?, ?, ?)";
    $stmt = mysqli_prepare($mysqli, $sql_them);
    mysqli_stmt_bind_param($stmt, "ssi", $tenadmin, $hashed_password, $admin_status);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Thêm admin thành công!');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
    }
    mysqli_stmt_close($stmt);
    
} elseif (isset($_POST['suaTen'])) {
    $tenadmin = trim($_POST['tenadmin']);
    $id = (int)$_GET['id'];
    
    // Validation  
    $errors = validateAdmin($tenadmin, 'dummy'); // Skip password validation for edit
    array_pop($errors); // Remove password error
    
    if(checkDuplicateUsername($mysqli, $tenadmin, $id)) {
        $errors[] = 'Tên admin đã tồn tại';
    }
    
    if(!empty($errors)) {
        $error_message = implode('\n', $errors);
        echo "<script>
            alert('$error_message');
            window.location.href='../../index.php?action=quanLyAdmin&query=sua&id=$id';
        </script>";
        exit;
    }
    
    $sql_update = "UPDATE tbl_admin SET user_name=? WHERE id_ad=?";
    $stmt = mysqli_prepare($mysqli, $sql_update);
    mysqli_stmt_bind_param($stmt, "si", $tenadmin, $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Cập nhật admin thành công!');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyAdmin&query=sua&id=$id';
        </script>";
    }
    mysqli_stmt_close($stmt);
    
} else {
    // Delete admin
    $id = (int)$_GET['id'];
    
    // Check if trying to delete self
    if($id == $_SESSION['admin']['id_ad']) {
        echo "<script>
            alert('Không thể xóa tài khoản của chính mình!');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
        exit;
    }
    
    // Check if this is the last admin
    $sql_count = "SELECT COUNT(*) as count FROM tbl_admin WHERE admin_status = 1";
    $result = mysqli_query($mysqli, $sql_count);
    $row = mysqli_fetch_assoc($result);
    
    if($row['count'] <= 1) {
        echo "<script>
            alert('Không thể xóa admin cuối cùng!');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
        exit;
    }
    
    $sql_xoa = "DELETE FROM tbl_admin WHERE id_ad=?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Xóa admin thành công!');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
    } else {
        echo "<script>
            alert('Có lỗi xảy ra: " . mysqli_error($mysqli) . "');
            window.location.href='../../index.php?action=quanLyAdmin&query=them';
        </script>";
    }
    mysqli_stmt_close($stmt);
}
