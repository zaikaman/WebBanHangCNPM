<?php
$error = '';
$success = '';
$km = null;

// Lấy thông tin khuyến mãi nếu đang sửa
if (isset($_GET['id'])) {
    $id_km = (int)$_GET['id'];
    $sql = "SELECT * FROM tbl_khuyenmai WHERE id_km = $id_km";
    $result = mysqli_query($mysqli, $sql);
    $km = mysqli_fetch_array($result);
    
    if (!$km) {
        $error = "Không tìm thấy khuyến mãi!";
    }
}

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_km = mysqli_real_escape_string($mysqli, $_POST['ten_km']);
    $mo_ta = mysqli_real_escape_string($mysqli, $_POST['mo_ta']);
    $loai_km = mysqli_real_escape_string($mysqli, $_POST['loai_km']);
    $gia_tri_km = floatval($_POST['gia_tri_km']);
    $ngay_bat_dau = mysqli_real_escape_string($mysqli, $_POST['ngay_bat_dau']);
    $ngay_ket_thuc = mysqli_real_escape_string($mysqli, $_POST['ngay_ket_thuc']);
    $trang_thai = isset($_POST['trang_thai']) ? 1 : 0;
    
    // Validate
    if (empty($ten_km)) {
        $error = "Vui lòng nhập tên khuyến mãi!";
    } elseif ($gia_tri_km <= 0) {
        $error = "Giá trị khuyến mãi phải lớn hơn 0!";
    } elseif ($loai_km == 'phan_tram' && $gia_tri_km > 100) {
        $error = "Phần trăm giảm giá không được vượt quá 100%!";
    } elseif (strtotime($ngay_bat_dau) >= strtotime($ngay_ket_thuc)) {
        $error = "Ngày kết thúc phải sau ngày bắt đầu!";
    } else {
        if (isset($_GET['id'])) {
            // Cập nhật
            $sql = "UPDATE tbl_khuyenmai SET 
                    ten_km = '$ten_km',
                    mo_ta = '$mo_ta',
                    loai_km = '$loai_km',
                    gia_tri_km = $gia_tri_km,
                    ngay_bat_dau = '$ngay_bat_dau',
                    ngay_ket_thuc = '$ngay_ket_thuc',
                    trang_thai = $trang_thai
                    WHERE id_km = $id_km";
            
            if (mysqli_query($mysqli, $sql)) {
                $success = "Cập nhật khuyến mãi thành công!";
                // Refresh data
                $result = mysqli_query($mysqli, "SELECT * FROM tbl_khuyenmai WHERE id_km = $id_km");
                $km = mysqli_fetch_array($result);
            } else {
                $error = "Lỗi: " . mysqli_error($mysqli);
            }
        } else {
            // Thêm mới
            $sql = "INSERT INTO tbl_khuyenmai (ten_km, mo_ta, loai_km, gia_tri_km, ngay_bat_dau, ngay_ket_thuc, trang_thai) 
                    VALUES ('$ten_km', '$mo_ta', '$loai_km', $gia_tri_km, '$ngay_bat_dau', '$ngay_ket_thuc', $trang_thai)";
            
            if (mysqli_query($mysqli, $sql)) {
                $success = "Thêm khuyến mãi thành công!";
                header("Location: ?action=quanlykhuyenmai&query=lietke&msg=add_success");
                exit();
            } else {
                $error = "Lỗi: " . mysqli_error($mysqli);
            }
        }
    }
}

$page_title = isset($_GET['id']) ? "Sửa Khuyến Mãi" : "Thêm Khuyến Mãi";
$page_icon = isset($_GET['id']) ? "fa-edit" : "fa-plus-circle";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.page-header {
    background: #dc0021;
    color: white;
    padding: 1.5rem 2rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-section {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-left: 4px solid #dc0021;
    margin-bottom: 1.5rem;
}

.btn-7tcc {
    background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
    color: white;
    border: none;
    padding: 0.625rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-7tcc:hover {
    background: linear-gradient(135deg, #a90019 0%, #dc0021 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 0, 33, 0.3);
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.required::after {
    content: " *";
    color: #dc0021;
}
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h3 class="mb-0"><i class="fas <?php echo $page_icon; ?>"></i> <?php echo $page_title; ?></h3>
    </div>

    <div class="form-section">
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label required">Tên khuyến mãi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        <input type="text" name="ten_km" class="form-control" 
                               placeholder="VD: Giảm giá mùa hè 2024"
                               value="<?php echo $km ? htmlspecialchars($km['ten_km']) : ''; ?>" 
                               required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label required">Loại khuyến mãi</label>
                    <select name="loai_km" class="form-select" id="loai_km" required>
                        <option value="phan_tram" <?php echo ($km && $km['loai_km'] == 'phan_tram') ? 'selected' : ''; ?>>
                            <i class="fas fa-percent"></i> Giảm theo phần trăm (%)
                        </option>
                        <option value="tien_mat" <?php echo ($km && $km['loai_km'] == 'tien_mat') ? 'selected' : ''; ?>>
                            Giảm theo số tiền (VNĐ)
                        </option>
                        <option value="gia_moi" <?php echo ($km && $km['loai_km'] == 'gia_moi') ? 'selected' : ''; ?>>
                            Giá mới cố định (VNĐ)
                        </option>
                    </select>
                </div>
            </div>
            
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="3" 
                              placeholder="Mô tả chi tiết về chương trình khuyến mãi..."><?php echo $km ? htmlspecialchars($km['mo_ta']) : ''; ?></textarea>
                </div>
            </div>
            
            <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <label class="form-label required">Giá trị</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input type="number" name="gia_tri_km" class="form-control" 
                               value="<?php echo $km ? $km['gia_tri_km'] : ''; ?>" 
                               step="0.01" min="0" required>
                        <span class="input-group-text fw-bold" id="unit-display">%</span>
                    </div>
                    <small class="form-text text-muted" id="value-hint">
                        <i class="fas fa-info-circle"></i> Nhập phần trăm giảm giá (0-100)
                    </small>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required">Ngày bắt đầu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="datetime-local" name="ngay_bat_dau" class="form-control" 
                               value="<?php echo $km ? date('Y-m-d\TH:i', strtotime($km['ngay_bat_dau'])) : ''; ?>" 
                               required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required">Ngày kết thúc</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                        <input type="datetime-local" name="ngay_ket_thuc" class="form-control" 
                               value="<?php echo $km ? date('Y-m-d\TH:i', strtotime($km['ngay_ket_thuc'])) : ''; ?>" 
                               required>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="trang_thai" 
                               name="trang_thai" <?php echo (!$km || $km['trang_thai'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="trang_thai">
                            <i class="fas fa-toggle-on"></i> Kích hoạt khuyến mãi ngay
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                <a href="?action=quanlykhuyenmai&query=lietke" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
                <button type="submit" class="btn btn-7tcc btn-lg">
                    <i class="fas fa-save"></i> <?php echo isset($_GET['id']) ? 'Cập nhật' : 'Thêm mới'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('loai_km').addEventListener('change', function() {
    const unit = document.getElementById('unit-display');
    const hint = document.getElementById('value-hint');
    
    if (this.value === 'phan_tram') {
        unit.textContent = '%';
        hint.textContent = 'Nhập phần trăm giảm giá (0-100)';
    } else {
        unit.textContent = 'VNĐ';
        hint.textContent = 'Nhập số tiền ' + (this.value === 'gia_moi' ? 'giá mới' : 'giảm giá');
    }
});

// Trigger change on page load
document.getElementById('loai_km').dispatchEvent(new Event('change'));
</script>
