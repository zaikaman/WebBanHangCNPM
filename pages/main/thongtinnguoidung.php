<link rel="stylesheet" type="text/css" href="css/thongtinnguoidung.css?v=<?php echo time(); ?>">
<?php
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['id_khachhang'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem thông tin cá nhân!'); window.location.href='index.php?quanly=dangnhap';</script>";
    exit;
}

$id_khachhang = $_SESSION['id_khachhang'];
$thong_bao = '';
$loai_thong_bao = '';

// Xử lý cập nhật thông tin
if (isset($_POST['capNhatThongTin'])) {
    $ten_khachhang = mysqli_real_escape_string($mysqli, $_POST['ten_khachhang']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $dia_chi = mysqli_real_escape_string($mysqli, $_POST['dia_chi']);
    $dien_thoai = mysqli_real_escape_string($mysqli, $_POST['dien_thoai']);
    
    // Kiểm tra email có bị trùng với người dùng khác không
    $sql_check_email = "SELECT * FROM tbl_dangky WHERE email = '$email' AND id_dangky != '$id_khachhang'";
    $query_check_email = mysqli_query($mysqli, $sql_check_email);
    
    if (mysqli_num_rows($query_check_email) > 0) {
        $thong_bao = 'Email này đã được sử dụng bởi tài khoản khác!';
        $loai_thong_bao = 'error';
    } else {
        // Cập nhật thông tin
        $sql_update = "UPDATE tbl_dangky SET 
                       ten_khachhang = '$ten_khachhang',
                       email = '$email',
                       dia_chi = '$dia_chi',
                       dien_thoai = '$dien_thoai'
                       WHERE id_dangky = '$id_khachhang'";
        
        if (mysqli_query($mysqli, $sql_update)) {
            // Cập nhật session
            $_SESSION['dang_ky'] = $ten_khachhang;
            $_SESSION['email'] = $email;
            
            $thong_bao = 'Cập nhật thông tin thành công!';
            $loai_thong_bao = 'success';
        } else {
            $thong_bao = 'Có lỗi xảy ra khi cập nhật thông tin!';
            $loai_thong_bao = 'error';
        }
    }
}

// Lấy thông tin người dùng hiện tại
$sql_user = "SELECT * FROM tbl_dangky WHERE id_dangky = '$id_khachhang'";
$query_user = mysqli_query($mysqli, $sql_user);
$user_info = mysqli_fetch_array($query_user);
?>

<div class="main_content">
    <div class="user-profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="profile-title">
                <h1>Thông tin cá nhân</h1>
                <p>Quản lý thông tin tài khoản của bạn</p>
            </div>
        </div>

        <?php if ($thong_bao != ''): ?>
            <div class="notification <?php echo $loai_thong_bao; ?>">
                <i class="fas fa-<?php echo $loai_thong_bao == 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                <span><?php echo $thong_bao; ?></span>
            </div>
        <?php endif; ?>

        <div class="profile-content">
            <form method="POST" class="profile-form" id="profileForm">
                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Thông tin cơ bản</h3>
                    
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="ten_khachhang">
                                <i class="fas fa-user"></i>
                                Họ và tên <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   id="ten_khachhang" 
                                   name="ten_khachhang" 
                                   value="<?php echo htmlspecialchars($user_info['ten_khachhang']); ?>" 
                                   required
                                   placeholder="Nhập họ và tên">
                        </div>

                        <div class="form-field">
                            <label for="email">
                                <i class="fas fa-envelope"></i>
                                Email <span class="required">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($user_info['email']); ?>" 
                                   required
                                   placeholder="Nhập địa chỉ email">
                        </div>

                        <div class="form-field">
                            <label for="dien_thoai">
                                <i class="fas fa-phone"></i>
                                Số điện thoại <span class="required">*</span>
                            </label>
                            <input type="tel" 
                                   id="dien_thoai" 
                                   name="dien_thoai" 
                                   value="<?php echo htmlspecialchars($user_info['dien_thoai']); ?>" 
                                   required
                                   placeholder="Nhập số điện thoại">
                        </div>

                        <div class="form-field full-width">
                            <label for="dia_chi">
                                <i class="fas fa-map-marker-alt"></i>
                                Địa chỉ <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   id="dia_chi" 
                                   name="dia_chi" 
                                   value="<?php echo htmlspecialchars($user_info['dia_chi']); ?>" 
                                   required
                                   placeholder="Nhập địa chỉ">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="capNhatThongTin" class="btn-save">
                        <i class="fas fa-save"></i>
                        Lưu thay đổi
                    </button>
                    <button type="button" class="btn-cancel" onclick="resetForm()">
                        <i class="fas fa-undo"></i>
                        Hủy bỏ
                    </button>
                </div>
            </form>

            <div class="quick-actions">
                <h3><i class="fas fa-bolt"></i> Thao tác nhanh</h3>
                <div class="action-buttons">
                    <a href="index.php?quanly=doimatkhau" class="action-btn">
                        <i class="fas fa-key"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                    <a href="index.php?quanly=lichSuDonHang" class="action-btn">
                        <i class="fas fa-history"></i>
                        <span>Lịch sử đơn hàng</span>
                    </a>
                    <a href="index.php?quanly=donhangdadat" class="action-btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Đơn hàng của tôi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/thongtinnguoidung.js" defer></script>