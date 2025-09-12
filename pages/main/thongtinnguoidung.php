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

<style>
/* Container chính */
.user-profile-container {
    max-width: 900px;
    margin: 20px auto;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1);
    overflow: hidden;
    border: 2px solid #f8f9fa;
}

/* Header profile */
.profile-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    padding: 40px 30px;
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-avatar {
    font-size: 80px;
    color: rgba(255, 255, 255, 0.9);
}

.profile-title h1 {
    margin: 0;
    font-size: 32px;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.profile-title p {
    margin: 5px 0 0 0;
    font-size: 16px;
    opacity: 0.9;
    font-weight: 300;
}

/* Thông báo */
.notification {
    margin: 20px;
    padding: 15px 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
    border-left: 4px solid;
}

.notification.success {
    background: #d1e7dd;
    color: #0f5132;
    border-left-color: #198754;
}

.notification.error {
    background: #f8d7da;
    color: #842029;
    border-left-color: #dc3545;
}

.notification i {
    font-size: 18px;
}

/* Nội dung profile */
.profile-content {
    padding: 30px;
}

/* Form section */
.form-section {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.form-section h3 {
    margin: 0 0 20px 0;
    color: #dc3545;
    font-size: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 10px;
}

/* Form grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-field.full-width {
    grid-column: 1 / -1;
}

.form-field label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-weight: 600;
    color: #495057;
    font-size: 14px;
}

.form-field label i {
    color: #dc3545;
    width: 16px;
}

.required {
    color: #dc3545;
    font-weight: 700;
}

.form-field input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #ffffff;
    box-sizing: border-box;
}

.form-field input:focus {
    outline: none;
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    background: #fff;
}

.form-field input:valid {
    border-color: #28a745;
}

.form-field input:invalid:not(:focus):not(:placeholder-shown) {
    border-color: #dc3545;
}

/* Form actions */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
}

.btn-save {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
}

.btn-cancel {
    background: #ffffff;
    color: #6c757d;
    border: 2px solid #e9ecef;
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8f9fa;
    border-color: #dc3545;
    color: #dc3545;
}

/* Quick actions */
.quick-actions {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 25px;
    margin-top: 25px;
}

.quick-actions h3 {
    margin: 0 0 20px 0;
    color: #dc3545;
    font-size: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-btn {
    background: #ffffff;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 20px;
    text-decoration: none;
    color: #495057;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    text-align: center;
}

.action-btn:hover {
    border-color: #dc3545;
    color: #dc3545;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
    text-decoration: none;
}

.action-btn i {
    font-size: 24px;
    color: #dc3545;
}

.action-btn span {
    font-weight: 600;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .user-profile-container {
        margin: 10px;
        border-radius: 0;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
    }
    
    .profile-avatar {
        font-size: 60px;
    }
    
    .profile-title h1 {
        font-size: 24px;
    }
    
    .profile-content {
        padding: 20px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .form-section, .quick-actions {
        padding: 20px;
    }
    
    .profile-header {
        padding: 25px 15px;
    }
    
    .profile-content {
        padding: 15px;
    }
}
</style>

<script>
// Reset form về giá trị ban đầu
function resetForm() {
    document.getElementById('profileForm').reset();
    // Reset border colors
    const inputs = document.querySelectorAll('.form-field input');
    inputs.forEach(input => {
        input.style.borderColor = '#e9ecef';
        input.setCustomValidity('');
    });
}

// Validation cho email và số điện thoại
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('dien_thoai');
    
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            
            if (email && !emailPattern.test(email)) {
                this.style.borderColor = '#dc3545';
                this.setCustomValidity('Email không đúng định dạng');
            } else {
                this.style.borderColor = '#28a745';
                this.setCustomValidity('');
            }
        });
    }
    
    if (phoneInput) {
        phoneInput.addEventListener('blur', function() {
            const phone = this.value;
            const phonePattern = /^[0-9]{10,11}$/;
            
            if (phone && !phonePattern.test(phone)) {
                this.style.borderColor = '#dc3545';
                this.setCustomValidity('Số điện thoại phải có 10-11 ch�� số');
            } else {
                this.style.borderColor = '#28a745';
                this.setCustomValidity('');
            }
        });
    }
    
    // Form validation trước khi submit
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    input.style.borderColor = '#28a745';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            }
        });
    }
});
</script>