<?php
    include("config/config.php");
    include("includes/pagination.php");
    
    // Xử lý tham số phân trang
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
    
    // Xử lý tìm kiếm
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
    
    // Xây dựng WHERE clause cho tìm kiếm
    $where_clause = "WHERE tbl_baiviet.id_danhmuc=tbl_danhmuc_baiviet.id_baiviet";
    
    if (!empty($search)) {
        switch ($search_field) {
            case 'tenbaiviet':
                $where_clause .= " AND tbl_baiviet.tenbaiviet LIKE '%$search%'";
                break;
            case 'noidung':
                $where_clause .= " AND tbl_baiviet.noidung LIKE '%$search%'";
                break;
            case 'tinhtrang':
                $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                $where_clause .= " AND tbl_baiviet.tinhtrang = $status";
                break;
            default:
                $where_clause .= " AND (tbl_baiviet.tenbaiviet LIKE '%$search%' 
                                OR tbl_baiviet.noidung LIKE '%$search%' 
                                OR tbl_baiviet.tomtat LIKE '%$search%')";
        }
    }
    
    // Đếm tổng số bản ghi
    $sql_count = "SELECT COUNT(*) as total FROM tbl_baiviet,tbl_danhmuc_baiviet $where_clause";
    $count_result = mysqli_query($mysqli, $sql_count);
    $total_records = mysqli_fetch_array($count_result)['total'];
    
    // Tạo pagination object
    $query_params = $_GET;
    unset($query_params['page']); // Loại bỏ page khỏi query params
    $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);
    
    // Query với LIMIT và OFFSET
    $sql_lietke = "SELECT * FROM tbl_baiviet,tbl_danhmuc_baiviet 
                   $where_clause 
                   ORDER BY id DESC 
                   LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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

.form-section {
    background: #f8f9fa;
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

/* FORCE MODAL ABOVE EVERYTHING - NUCLEAR OPTION */
#addPostModal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 999999 !important;
    background: rgba(0, 0, 0, 0.8) !important;
    display: none !important;
}

#addPostModal.show {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

#addPostModal .modal-dialog {
    position: relative !important;
    z-index: 1000000 !important;
    margin: 0 !important;
    max-width: 95vw !important;
    max-height: 95vh !important;
    width: 1200px !important;
}

#addPostModal .modal-content {
    position: relative !important;
    z-index: 1000001 !important;
    max-height: 95vh !important;
    overflow-y: auto !important;
}

/* Hide backdrop since we're using our own */
.modal-backdrop {
    display: none !important;
}

/* Force override all other z-indexes when modal is open */
body.modal-open * {
    z-index: 1 !important;
}

body.modal-open #addPostModal,
body.modal-open #addPostModal * {
    z-index: 999999 !important;
}

body.modal-open .navbar,
body.modal-open .admin-sidebar {
    z-index: 1 !important;
    opacity: 1 !important;
}

/* Ensure modal content is clickable */
body.modal-open #addPostModal .modal-content,
body.modal-open #addPostModal .modal-content * {
    pointer-events: auto !important;
    z-index: 1000000 !important;
}


/* Responsive styles */
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
    
    /* Header responsive */
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 15px;
    }
    
    .btn-group {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-group .btn {
        width: 100%;
    }
    
    /* Pagination responsive */
    .pagination {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
    
    /* Search form responsive */
    .search-form-container {
        padding: 15px;
    }
    
    .search-form-container .row.g-3 {
        gap: 10px;
    }
    
    .search-form-container .col-lg-3,
    .search-form-container .col-lg-2,
    .search-form-container .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    /* Table responsive */
    .table th, .table td {
        padding: 0.5rem;
        font-size: 0.9rem;
    }
    
    .table img {
        width: 60px !important;
        height: 60px;
        object-fit: cover;
    }
    
    /* Modal responsive */
    #addProductModal .modal-dialog {
        max-width: 95vw !important;
        width: 95vw !important;
        margin: 10px !important;
    }
    
    #addProductModal .modal-content {
        max-height: 90vh !important;
    }
    
    .form-section {
        padding: 15px;
    }
    
    .form-section .row.g-3 {
        gap: 10px;
    }
    
    .form-section .col-md-6,
    .form-section .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    /* File upload responsive */
    .file-upload-area {
        padding: 15px;
    }
    
    .image-preview {
        max-width: 150px;
        max-height: 150px;
    }
}

@media (max-width: 576px) {
    h3 {
        font-size: 1.5rem;
        text-align: center;
    }
    
    .table th, .table td {
        padding: 0.4rem;
        font-size: 0.8rem;
    }
    
    .table img {
        width: 50px !important;
        height: 50px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .search-form-container {
        padding: 10px;
    }
    
    .form-section {
        padding: 10px;
    }
    
    .file-upload-area {
        padding: 10px;
    }
    
    .image-preview {
        max-width: 120px;
        max-height: 120px;
    }
    
    /* Pagination responsive for mobile */
    .pagination {
        font-size: 0.8rem;
    }
    
    .pagination .page-link {
        padding: 0.4rem 0.6rem;
    }
    
    /* Page size selector responsive */
    .page-size-selector {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .page-size-selector select {
        width: auto;
        min-width: 80px;
    }
}
</style>

<div class="container px-0 py-0">
    <!-- Header với nút thêm sản phẩm và export -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 ">
        <h3 class="text-7tcc mb-0 fw-bold">
            <i class="fas fa-newspaper me-2"></i>Quản Lý Bài Viết
        </h3>
        <div class="btn-group d-flex flex-wrap">
            <button type="button" class="btn btn-success" onclick="exportPosts()">
            <i class="fas fa-file-excel me-2"></i><span class="d-none d-md-inline">Xuất Excel </span><span class="d-md-none">Excel</span>
            </button>
            <button type="button" class="btn btn-7tcc" data-bs-toggle="modal" data-bs-target="#addPostModal">
                <i class="fas fa-plus me-2"></i>Thêm Bài Viết
            </button>
        </div>
    </div>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm & Lọc Bài Viết</h6>
        <form class="row g-3" method="GET" action="index.php" id="searchForm">
            <input type="hidden" name="action" value="quanLyBaiViet">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="col-lg-4 col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-lg-4 col-md-6">
                <select name="search_field" class="form-select">
                    <option value="all" <?php echo ($search_field == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                    <option value="tenbaiviet" <?php echo ($search_field == 'tenbaiviet') ? 'selected' : ''; ?>>Tên bài viết</option>
                    <option value="noidung" <?php echo ($search_field == 'noidung') ? 'selected' : ''; ?>>Nội dung</option>
                    <option value="tinhtrang" <?php echo ($search_field == 'tinhtrang') ? 'selected' : ''; ?>>Trạng thái</option>
                </select>
            </div>
            
            <div class="col-lg-4 col-md-12">
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLyBaiViet&query=lietke" class="btn btn-refresh flex-fill">
                        <i class="fas fa-sync-alt"></i>
                        <span>Làm mới</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive mb-3" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên bài viết</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $start_number = $pagination->getOffset();
                $i = $start_number;
                while ($row = mysqli_fetch_array($lietke)) {
                    $i++;
                ?>
                    <tr class="post-row" data-id="<?php echo (int)$row['id']; ?>">
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['tenbaiviet'] ?></td>
                        <td><img src="modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
                        <td><?php echo isset($row['tendanhmuc_baiviet']) ? $row['tendanhmuc_baiviet'] : $row['id_danhmuc'] ?></td>
                        
                        <td>
                            <?php if($row['tinhtrang'] == 1) { ?>
                                <span class="badge bg-success">Kích hoạt</span>
                            <?php } else { ?>
                                <span class="badge bg-warning">Ẩn</span>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="fas fa-trash-alt"></i> Xóa</a>
                                <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php echo $pagination->render(); ?>
</div>

<!-- Modal Thêm Bài Viết -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #a90019;">
                <h5 class="modal-title" id="addPostModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Thêm Bài Viết Mới
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="modules/quanLyBaiViet/xuly.php" enctype="multipart/form-data" id="addPostForm">
                    <input type="hidden" name="thembaiviet" value="1">

                    <!-- Basic Information -->
                    <div class="form-section">
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-info-circle me-2"></i>Thông Tin Cơ Bản
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tenbaiviet" class="form-label fw-bold">Tên Bài Viết <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tenbaiviet" name="tenbaiviet" required>
                            </div>
                            <div class="col-md-6">
                                <label for="link" class="form-label fw-bold">Link Bài Viết</label>
                                <input type="text" class="form-control" id="link" name="link" placeholder="Nhập link bài viết (nếu có)">
                            </div>
                            <div class="col-md-6">
                                <label for="id_danhmuc" class="form-label fw-bold">Danh Mục Bài Viết <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_danhmuc" name="id_danhmuc" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php
                                    $sql_danhmuc = "SELECT * FROM tbl_danhmuc_baiviet ORDER BY id_baiviet DESC";
                                    $sql_query = mysqli_query($mysqli, $sql_danhmuc);
                                    while ($row_danhmuc = mysqli_fetch_array($sql_query)) {
                                        echo "<option value='" . $row_danhmuc['id_baiviet'] . "'>" . $row_danhmuc['tendanhmuc_baiviet'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tinhtrang" class="form-label fw-bold">Trạng Thái</label>
                                <select class="form-select" id="tinhtrang" name="tinhtrang">
                                    <option value="1" selected>Kích Hoạt</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-section">
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-image me-2"></i>Hình Ảnh Bài Viết
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="file-upload-area" onclick="document.getElementById('hinhanh').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-7tcc mb-2"></i>
                                    <h6>Nhấp để chọn hình ảnh</h6>
                                    <p class="text-muted mb-0 small">Hỗ trợ: JPG, PNG, GIF (tối đa 5MB)</p>
                                </div>
                                <input type="file" class="d-none" name="hinhanh" id="hinhanh" accept="image/*" onchange="previewImage(this)">
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
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-file-alt me-2"></i>Nội Dung & Mô Tả
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tomtat" class="form-label fw-bold">Tóm Tắt</label>
                                <textarea rows="4" class="form-control" id="tomtat" name="tomtat" placeholder="Nhập tóm tắt ngắn gọn về bài viết..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="noidung" class="form-label fw-bold">Nội Dung Chi Tiết <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" id="noidung" name="noidung" placeholder="Nhập nội dung chi tiết của bài viết..." required></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy
                </button>
                <button type="button" class="btn btn-7tcc" onclick="submitAddPostForm()">
                    <i class="fas fa-save me-2"></i>Lưu Bài Viết
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Reset form khi đóng modal
document.getElementById('addPostModal').addEventListener('hidden.bs.modal', function (event) {
    document.getElementById('addPostForm').reset();
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('uploadInfo').innerHTML = '<small>Chưa chọn file nào</small>';
    
    // Remove validation classes
    $('#addPostModal').find('.is-invalid').removeClass('is-invalid');
});

// Validation form trước khi submit
document.getElementById('addPostForm').addEventListener('submit', function(e) {
    const tenbaiviet = document.getElementById('tenbaiviet').value.trim();
    const noidung = document.getElementById('noidung').value.trim();
    const id_danhmuc = document.getElementById('id_danhmuc').value;
    
    if (!tenbaiviet || !noidung || !id_danhmuc) {
        e.preventDefault();
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
        return false;
    }
});

// Image preview function for modal
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

// Submit form function
function submitAddPostForm() {
    var form = document.getElementById('addPostForm');
    var required = form.querySelectorAll('[required]');
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
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
        return;
    }

    // Submit form
    form.submit();
}

// Function to export posts to Excel
function exportPosts() {
    // Get current search parameters
    var search = $('input[name="search"]').val() || '';
    var search_field = $('select[name="search_field"]').val() || 'all';
    
    // Build export URL with current filters
    var exportUrl = 'modules/quanLyBaiViet/export.php?action=export';
    if (search) exportUrl += '&search=' + encodeURIComponent(search);
    if (search_field) exportUrl += '&search_field=' + encodeURIComponent(search_field);
    
    // Download file
    window.open(exportUrl, '_blank');
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Click row to view detail (delegate for list)
$(document).on('click', '.post-row', function(e) {
    if ($(e.target).closest('a, button, .btn, input, textarea, select, label, img').length) {
        return;
    }
    var id = $(this).data('id');
    if (id) {
        window.location.href = '?action=quanLyBaiViet&query=chitiet&id=' + id;
    }
});
</script>
