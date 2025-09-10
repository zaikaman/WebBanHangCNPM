<!-- Link Bootstrap CSS and custom styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
.text-7tcc { color: #dc0021 !important; }
.btn-7tcc { 
    background-color: #dc0021; 
    border-color: #dc0021; 
    color: white;
}
.btn-7tcc:hover { 
    background-color: #a90019; 
    border-color: #a90019; 
    color: white;
}
.form-container {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.form-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #dc0021;
}
.image-preview {
    max-width: 200px;
    max-height: 200px;
    border-radius: 8px;
    border: 2px dashed #dc0021;
    padding: 10px;
    display: none;
}
.file-upload-area {
    border: 2px dashed #dc0021;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}
.file-upload-area:hover {
    background-color: #f8f9fa;
    border-color: #a90019;
}
</style>

<?php
include("config/config.php");
$sql_dm = "SELECT * FROM tbl_danhmucqa ORDER BY name_sp ASC";
$danhmuc = mysqli_query($mysqli, $sql_dm);
?>

<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-7tcc mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Thêm Sản Phẩm Mới
                </h2>
                <a href="?action=quanLySanPham&query=lietke" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay Lại
                </a>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="modules/quanLySanPham/xuly.php" enctype="multipart/form-data" id="productForm">
            
            <!-- Basic Information -->
            <div class="form-section">
                <h5 class="text-7tcc mb-3">
                    <i class="fas fa-info-circle me-2"></i>Thông Tin Cơ Bản
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="ten_sp" class="form-label fw-bold">Tên Sản Phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ten_sp" id="ten_sp" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ma_sp" class="form-label fw-bold">Mã Sản Phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ma_sp" id="ma_sp" required>
                    </div>
                    <div class="col-md-4">
                        <label for="gia_sp" class="form-label fw-bold">Giá Sản Phẩm (VND) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="gia_sp" id="gia_sp" min="0" required>
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="so_luong" class="form-label fw-bold">Số Lượng <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="so_luong" id="so_luong" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="id_dm" class="form-label fw-bold">Danh Mục <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_dm" id="id_dm" required>
                            <option value="">Chọn danh mục</option>
                            <?php while($dm = mysqli_fetch_array($danhmuc)) { ?>
                                <option value="<?php echo $dm['id_dm'] ?>"><?php echo $dm['name_sp'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="form-section">
                <h5 class="text-7tcc mb-3">
                    <i class="fas fa-image me-2"></i>Hình Ảnh Sản Phẩm
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="file-upload-area" onclick="document.getElementById('hinh_anh').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-7tcc mb-3"></i>
                            <h6>Nhấp để chọn hình ảnh</h6>
                            <p class="text-muted mb-0">Hỗ trợ: JPG, PNG, GIF (tối đa 5MB)</p>
                        </div>
                        <input type="file" class="d-none" name="hinh_anh" id="hinh_anh" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <div class="col-md-6">
                        <img id="imagePreview" class="image-preview" alt="Preview">
                        <div id="uploadInfo" class="mt-2 text-muted">
                            <small>Chưa chọn file nào</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="form-section">
                <h5 class="text-7tcc mb-3">
                    <i class="fas fa-file-alt me-2"></i>Nội Dung & Mô Tả
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tom_tat" class="form-label fw-bold">Tóm Tắt</label>
                        <textarea rows="4" class="form-control" name="tom_tat" id="tom_tat" 
                                  placeholder="Nhập tóm tắt ngắn gọn về sản phẩm..."></textarea>
                        <div class="form-text">Mô tả ngắn gọn sẽ hiển thị trong danh sách sản phẩm</div>
                    </div>
                    <div class="col-md-6">
                        <label for="noi_dung" class="form-label fw-bold">Nội Dung Chi Tiết</label>
                        <textarea rows="4" class="form-control" name="noi_dung" id="noi_dung" 
                                  placeholder="Nhập mô tả chi tiết về sản phẩm..."></textarea>
                        <div class="form-text">Mô tả chi tiết sẽ hiển thị trong trang sản phẩm</div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-section">
                <h5 class="text-7tcc mb-3">
                    <i class="fas fa-toggle-on me-2"></i>Trạng Thái
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <label for="tinh_trang" class="form-label fw-bold">Hiển Thị</label>
                        <select class="form-select" name="tinh_trang" id="tinh_trang">
                            <option value="1" selected>Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                        <div class="form-text">Chọn trạng thái hiển thị của sản phẩm trên website</div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="text-center">
                <button type="submit" name="themsanpham" class="btn btn-7tcc btn-lg me-3">
                    <i class="fas fa-save me-2"></i>Lưu Sản Phẩm
                </button>
                <button type="reset" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-undo me-2"></i>Đặt Lại
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Image preview function
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('uploadInfo').innerHTML = 
                '<strong>File đã chọn:</strong> ' + input.files[0].name + 
                ' (' + Math.round(input.files[0].size / 1024) + ' KB)';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-generate product code from name
document.getElementById('ten_sp').addEventListener('input', function() {
    var name = this.value;
    var code = name.toLowerCase()
                   .replace(/[^\w\s]/gi, '')
                   .replace(/\s+/g, '-');
    if (code && !document.getElementById('ma_sp').value) {
        document.getElementById('ma_sp').value = code.substring(0, 20);
    }
});

// Form validation
document.getElementById('productForm').addEventListener('submit', function(e) {
    var required = this.querySelectorAll('[required]');
    var valid = true;
    
    required.forEach(function(field) {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            valid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!valid) {
        e.preventDefault();
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
    }
});

// Price formatting
document.getElementById('gia_sp').addEventListener('input', function() {
    // Remove non-digits
    var value = this.value.replace(/\D/g, '');
    
    // Format with commas
    if (value) {
        this.setAttribute('data-value', value);
    }
});
</script>
