<?php
	// Check if files exist and include accordingly
	if (file_exists("../../config/config.php")) {
		// Direct access to this file
		include("../../config/config.php");
		include("../../includes/pagination.php");
	} else {
		// Access through index.php
		include("config/config.php");
		include("includes/pagination.php");
	}
    
    if(isset($_GET['ajax_search'])) {
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
        $price_min = isset($_GET['price_min']) ? floatval($_GET['price_min']) : '';
        $price_max = isset($_GET['price_max']) ? floatval($_GET['price_max']) : '';
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        
        // Ensure minimum values
        $current_page = max(1, $current_page);
        $records_per_page = max(1, $records_per_page);
        
        $where_clause = "WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm";
        
        if (!empty($search) || !empty($price_min) || !empty($price_max)) {
            if (!empty($search)) {
                $search = mysqli_real_escape_string($mysqli, $search);
                switch ($search_field) {
                    case 'ten_sp':
                        $where_clause .= " AND tbl_sanpham.ten_sp LIKE '%$search%'";
                        break;
                    case 'ma_sp':
                        $where_clause .= " AND tbl_sanpham.ma_sp LIKE '%$search%'";
                        break;
                    case 'tinh_trang':
                        $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                        $where_clause .= " AND tbl_sanpham.tinh_trang = $status";
                        break;
                    default:
                        $where_clause .= " AND (tbl_sanpham.ten_sp LIKE '%$search%' 
                                        OR tbl_sanpham.ma_sp LIKE '%$search%' 
                                        OR tbl_sanpham.noi_dung LIKE '%$search%'
                                        OR tbl_sanpham.tom_tat LIKE '%$search%')";
                }
            }
            
            if (!empty($price_min)) {
                $where_clause .= " AND tbl_sanpham.gia_sp >= $price_min";
            }
            if (!empty($price_max)) {
                $where_clause .= " AND tbl_sanpham.gia_sp <= $price_max";
            }
        }
        
        // Đếm tổng số bản ghi cho AJAX
        $sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham, tbl_danhmucqa $where_clause";
        $count_result = mysqli_query($mysqli, $sql_count);
        
        if (!$count_result) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Database error: ' . mysqli_error($mysqli)]);
            exit;
        }
        
        $total_records = mysqli_fetch_array($count_result)['total'];
        
        // Tạo pagination object cho AJAX
        $query_params = $_GET;
        unset($query_params['page'], $query_params['ajax_search']);
        $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);
        
        $sql_lietke = "SELECT * FROM tbl_sanpham, tbl_danhmucqa $where_clause ORDER BY id_sp DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
        $lietke = mysqli_query($mysqli, $sql_lietke);
        
        if (!$lietke) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Database error: ' . mysqli_error($mysqli)]);
            exit;
        }

        ob_start();
        $start_number = $pagination->getOffset();
        $i = $start_number;
        while ($row = mysqli_fetch_array($lietke)) {
            $i++;
            ?>
            <tr class="product-row" data-id="<?php echo (int)$row['id_sp']; ?>">
                <td><?php echo $i ?></td>
                <td><?php echo htmlspecialchars($row['ten_sp']) ?></td>
                <td><img src="modules/quanLySanPham/uploads/<?php echo htmlspecialchars($row['hinh_anh']) ?>" width="100px" alt="Product Image"></td>
                <td><?php echo number_format($row['gia_sp'], 0, ',', '.').' VND' ?></td>
                <td><?php echo $row['so_luong'] ?></td>
                <td><?php echo $row['so_luong_con_lai'] ?></td>
                <td><?php echo htmlspecialchars($row['name_sp']) ?></td>
                <td><?php echo htmlspecialchars($row['ma_sp']) ?></td>
                <td>
                    <textarea class="form-control" rows="3" readonly><?php echo htmlspecialchars(str_replace('\n', "\n", $row['noi_dung'])) ?></textarea>
                </td>
                <td>
                    <textarea class="form-control" rows="3" readonly><?php echo htmlspecialchars(str_replace('\n', "\n", $row['tom_tat'])) ?></textarea>
                </td>
                <td><?php echo ($row['tinh_trang'] == 1) ? 'Kích hoạt' : 'Ẩn' ?></td>
                <td>
                    <a href="modules/quanLySanPham/xuly.php?idsp=<?php echo urlencode($row['ma_sp']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    <a href="?action=quanLySanPham&query=sua&idsp=<?php echo urlencode($row['ma_sp']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                </td>
            </tr>
            <?php
        }
        $table_content = ob_get_clean();
        
        // Trả về JSON response với cả table content và pagination
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'table_content' => $table_content,
            'pagination' => $pagination->render(),
            'total_records' => $total_records,
            'current_page' => $current_page
        ]);
        exit;
    }
    
    // Initial query for page load
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
    $price_min = isset($_GET['price_min']) ? floatval($_GET['price_min']) : '';
    $price_max = isset($_GET['price_max']) ? floatval($_GET['price_max']) : '';
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
    
    $where_clause = "WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm";
    
    if (!empty($search) || !empty($price_min) || !empty($price_max)) {
        if (!empty($search)) {
            switch ($search_field) {
                case 'ten_sp':
                    $where_clause .= " AND tbl_sanpham.ten_sp LIKE '%$search%'";
                    break;
                case 'ma_sp':
                    $where_clause .= " AND tbl_sanpham.ma_sp LIKE '%$search%'";
                    break;
                case 'tinh_trang':
                    $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                    $where_clause .= " AND tbl_sanpham.tinh_trang = $status";
                    break;
                default:
                    $where_clause .= " AND (tbl_sanpham.ten_sp LIKE '%$search%' 
                                    OR tbl_sanpham.ma_sp LIKE '%$search%' 
                                    OR tbl_sanpham.noi_dung LIKE '%$search%'
                                    OR tbl_sanpham.tom_tat LIKE '%$search%')";
            }
        }
        
        if (!empty($price_min)) {
            $where_clause .= " AND tbl_sanpham.gia_sp >= $price_min";
        }
        if (!empty($price_max)) {
            $where_clause .= " AND tbl_sanpham.gia_sp <= $price_max";
        }
    }
    
    // Đếm tổng số bản ghi
    $sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham, tbl_danhmucqa $where_clause";
    $count_result = mysqli_query($mysqli, $sql_count);
    $total_records = mysqli_fetch_array($count_result)['total'];
    
    // Tạo pagination object
    $query_params = $_GET;
    unset($query_params['page']);
    $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);
    
    $sql_lietke = "SELECT * FROM tbl_sanpham, tbl_danhmucqa $where_clause ORDER BY id_sp DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
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
#addProductModal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 999999 !important;
    background: rgba(0, 0, 0, 0.8) !important;
    display: none !important;
}

#addProductModal.show {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

#addProductModal .modal-dialog {
    position: relative !important;
    z-index: 1000000 !important;
    margin: 0 !important;
    max-width: 95vw !important;
    max-height: 95vh !important;
    width: 1200px !important;
}

#addProductModal .modal-content {
    position: relative !important;
    z-index: 1000001 !important;
    max-height: 95vh !important;
    overflow-y: auto !important;
}

/* Modal responsive improvements */
@media (max-width: 1200px) {
    #addProductModal .modal-dialog {
        width: 95vw !important;
        max-width: 95vw !important;
    }
}

@media (max-width: 768px) {
    #addProductModal .modal-dialog {
        width: 98vw !important;
        max-width: 98vw !important;
        margin: 1vh !important;
    }
    
    #addProductModal .modal-content {
        max-height: 98vh !important;
    }
    
    #addProductModal .modal-header {
        padding: 15px;
    }
    
    #addProductModal .modal-body {
        padding: 15px;
    }
    
    #addProductModal .modal-footer {
        padding: 15px;
        flex-direction: column;
        gap: 10px;
    }
    
    #addProductModal .modal-footer .btn {
        width: 100%;
    }
}

/* Hide backdrop since we're using our own */
.modal-backdrop {
    display: none !important;
}

/* Force override all other z-indexes when modal is open */
body.modal-open * {
    z-index: 1 !important;
}

body.modal-open #addProductModal,
body.modal-open #addProductModal * {
    z-index: 999999 !important;
}

body.modal-open .navbar,
body.modal-open .admin-sidebar {
    z-index: 1 !important;
    opacity: 0.3 !important;
}

/* Ensure modal content is clickable */
body.modal-open #addProductModal .modal-content,
body.modal-open #addProductModal .modal-content * {
    pointer-events: auto !important;
    z-index: 1000000 !important;
}

/* Loading state for table */
.loading {
    position: relative;
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #dc0021;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 1000;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Custom scrollbar for product table */
.table-responsive::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 8px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
    border-radius: 8px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #a90019 0%, #dc0021 100%);
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
    
    /* Hide some columns on very small screens */
    .table th:nth-child(6),
    .table td:nth-child(6),
    .table th:nth-child(7),
    .table td:nth-child(7) {
        display: none;
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
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="text-7tcc mb-0 fw-bold">
            <i class="fas fa-box me-2"></i>Quản Lý Sản Phẩm
        </h3>
        <div class="btn-group d-flex flex-wrap">
            <button type="button" class="btn btn-success" onclick="exportProducts()">
                <i class="fas fa-file-excel me-2"></i><span class="d-none d-md-inline">Xuất Excel</span><span class="d-md-none">Excel</span>
            </button>
            <button type="button" class="btn btn-7tcc" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus me-2"></i><span class="d-none d-md-inline">Thêm Sản Phẩm</span><span class="d-md-none">Thêm</span>
            </button>
        </div>
    </div>
    
    <!-- Success/Error Messages -->
    <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Thành công!</strong> 
        <?php 
        switch($_GET['success']) {
            case 'add': echo 'Sản phẩm đã được thêm thành công!'; break;
            case 'update': echo 'Sản phẩm đã được cập nhật thành công!'; break;
            case 'delete': echo 'Sản phẩm đã được xóa thành công!'; break;
            default: echo 'Thao tác thành công!';
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Lỗi!</strong> <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm & Lọc Sản Phẩm</h6>
        <form class="row g-3" method="GET" action="index.php" id="searchForm">
            <input type="hidden" name="action" value="quanLySanPham">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="col-lg-3 col-md-6 col-12">
                <label class="form-label fw-bold">Từ khóa tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-lg-2 col-md-6 col-12">
                <label class="form-label fw-bold">Tìm theo</label>
                <select name="search_field" class="form-select">
                    <option value="all" <?php echo ($search_field == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                    <option value="ten_sp" <?php echo ($search_field == 'ten_sp') ? 'selected' : ''; ?>>Tên sản phẩm</option>
                    <option value="ma_sp" <?php echo ($search_field == 'ma_sp') ? 'selected' : ''; ?>>Mã sản phẩm</option>
                    <option value="tinh_trang" <?php echo ($search_field == 'tinh_trang') ? 'selected' : ''; ?>>Trạng thái</option>
                </select>
            </div>
            
            <div class="col-lg-2 col-md-6 col-12">
                <label class="form-label fw-bold">Giá tối thiểu</label>
                <input type="number" name="price_min" class="form-control" placeholder="0" value="<?php echo $price_min; ?>">
            </div>
            
            <div class="col-lg-2 col-md-6 col-12">
                <label class="form-label fw-bold">Giá tối đa</label>
                <input type="number" name="price_max" class="form-control" placeholder="999999999" value="<?php echo $price_max; ?>">
            </div>
            
            <div class="col-lg-3 col-md-12 col-12">
                <label class="form-label fw-bold d-block">&nbsp;</label>
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLySanPham&query=lietke" class="btn btn-refresh flex-fill">
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
                    <th>Id</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Hình Ảnh</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Còn lại</th>
                    <th>Danh Mục</th>
                    <th>Mã SP</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <?php
                $start_number = $pagination->getOffset();
                $i = $start_number;
                while ($row = mysqli_fetch_array($lietke)) {
                    $i++;
                ?>
                    <tr class="product-row" data-id="<?php echo (int)$row['id_sp']; ?>">
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['ten_sp'] ?></td>
                        <td><img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" width="100px"></td>
                        <td><?php echo number_format($row['gia_sp'], 0, ',', '.').' VND' ?></td>
                        <td><?php echo $row['so_luong'] ?></td>
                        <td><?php echo $row['so_luong_con_lai'] ?></td>
                        <td><?php echo $row['name_sp'] ?></td>
                        <td><?php echo $row['ma_sp'] ?></td>
                        
                        <td><?php echo ($row['tinh_trang'] == 1) ? 'Kích hoạt' : 'Ẩn' ?></td>
                        <td>
                            <a href="modules/quanLySanPham/xuly.php?idsp=<?php echo $row['ma_sp'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                            <a href="?action=quanLySanPham&query=sua&idsp=<?php echo $row['ma_sp'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div id="paginationContainer">
        <?php echo $pagination->render(); ?>
    </div>
</div>

<!-- Modal Thêm Sản Phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #a90019;">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Thêm Sản Phẩm Mới
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="modules/quanLySanPham/xuly.php" enctype="multipart/form-data" id="productForm">
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-info-circle me-2"></i>Thông Tin Cơ Bản
                        </h6>
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
                                    <?php
                                    $sql_dm = "SELECT * FROM tbl_danhmucqa ORDER BY name_sp ASC";
                                    $danhmuc = mysqli_query($mysqli, $sql_dm);
                                    while($dm = mysqli_fetch_array($danhmuc)) { 
                                    ?>
                                        <option value="<?php echo $dm['id_dm'] ?>"><?php echo $dm['name_sp'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-section">
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-image me-2"></i>Hình Ảnh Sản Phẩm
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="file-upload-area" onclick="document.getElementById('hinh_anh').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-7tcc mb-2"></i>
                                    <h6>Nhấp để chọn hình ảnh</h6>
                                    <p class="text-muted mb-0 small">Hỗ trợ: JPG, PNG, GIF (tối đa 5MB)</p>
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
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-file-alt me-2"></i>Nội Dung & Mô Tả
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tom_tat" class="form-label fw-bold">Tóm Tắt</label>
                                <textarea rows="3" class="form-control" name="tom_tat" id="tom_tat" 
                                          placeholder="Nhập tóm tắt ngắn gọn về sản phẩm..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="noi_dung" class="form-label fw-bold">Nội Dung Chi Tiết</label>
                                <textarea rows="3" class="form-control" name="noi_dung" id="noi_dung" 
                                          placeholder="Nhập mô tả chi tiết về sản phẩm..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-section">
                        <h6 class="text-7tcc mb-3">
                            <i class="fas fa-toggle-on me-2"></i>Trạng Thái
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tinh_trang" class="form-label fw-bold">Hiển Thị</label>
                                <select class="form-select" name="tinh_trang" id="tinh_trang">
                                    <option value="1" selected>Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy
                </button>
                <button type="button" class="btn btn-7tcc" onclick="submitAddForm()">
                    <i class="fas fa-save me-2"></i>Lưu Sản Phẩm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Link jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    
    // Custom modal handling - bypass Bootstrap's modal
    $('[data-bs-toggle="modal"][data-bs-target="#addProductModal"]').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Show modal manually
        showCustomModal();
    });
    
    // Custom modal show function
    function showCustomModal() {
        // Add modal-open class and prevent scrolling
        $('body').addClass('modal-open').css({
            'overflow': 'hidden',
            'padding-right': '0px'
        });
        
        // Show modal
        $('#addProductModal').addClass('show').css('display', 'flex');
        
        // Focus first input
        setTimeout(function() {
            $('#ten_sp').focus();
        }, 100);
    }
    
    // Custom modal hide function
    function hideCustomModal() {
        // Hide modal
        $('#addProductModal').removeClass('show').css('display', 'none');
        
        // Reset form
        document.getElementById('productForm').reset();
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('uploadInfo').innerHTML = '<small>Chưa chọn file nào</small>';
        
        // Remove validation classes
        $('#addProductModal').find('.is-invalid').removeClass('is-invalid');
        
        // Restore body
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
    }
    
    // Close modal on backdrop click
    $('#addProductModal').on('click', function(e) {
        if (e.target === this) {
            hideCustomModal();
        }
    });
    
    // Close modal on close button click
    $('#addProductModal .btn-close, #addProductModal [data-bs-dismiss="modal"]').on('click', function(e) {
        e.preventDefault();
        hideCustomModal();
    });
    
    // Close modal on Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#addProductModal').hasClass('show')) {
            hideCustomModal();
        }
    });
    
    function performSearch() {
        var formData = $('#searchForm').serialize();
        
        $.ajax({
            url: 'modules/quanLySanPham/lietke.php',
            type: 'GET',
            data: formData + '&ajax_search=1',
            dataType: 'json',
            beforeSend: function() {
                $('#productTableBody').addClass('loading');
            },
            success: function(response) {
                if (response && response.success && response.table_content && response.pagination) {
                    $('#productTableBody').html(response.table_content);
                    $('#paginationContainer').html(response.pagination);
                } else if (response && response.error) {
                    alert('Lỗi server: ' + response.error);
                } else {
                    alert('Phản hồi từ server không hợp lệ');
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra khi tìm kiếm');
            },
            complete: function() {
                $('#productTableBody').removeClass('loading');
            }
        });
    }

    // Real-time search on any input change
    $('#searchForm input, #searchForm select').on('input change', function() {
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(performSearch, 300);
    });

    // Click row to view detail (delegate for both initial and AJAX content)
    $(document).on('click', '.product-row', function(e) {
        // Ignore clicks on buttons/links/inputs inside the row
        if ($(e.target).closest('a, button, .btn, input, textarea, select, label').length) {
            return;
        }
        var id = $(this).data('id');
        if (id) {
            window.location.href = '?action=quanLySanPham&query=chitiet&id=' + id;
        }
    });
    
    // Handle pagination clicks
    $(document).on('click', '#paginationContainer .page-link', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $link = $(this);
        var page = $link.data('page');
        
        if (!page || $link.closest('.page-item').hasClass('disabled') || $link.closest('.page-item').hasClass('active')) {
            return false;
        }
        
        // Get current form data
        var formData = $('#searchForm').serialize();
        
        // Add page and ajax parameters
        var finalData = formData + '&page=' + page + '&ajax_search=1';
        
        $.ajax({
            url: 'modules/quanLySanPham/lietke.php',
            type: 'GET',
            data: finalData,
            dataType: 'json',
            beforeSend: function() {
                $('#productTableBody').addClass('loading');
                $link.addClass('loading');
            },
            success: function(response) {
                if (response && response.success && response.table_content && response.pagination) {
                    $('#productTableBody').html(response.table_content);
                    $('#paginationContainer').html(response.pagination);
                } else if (response && response.error) {
                    alert('Lỗi server: ' + response.error);
                } else {
                    alert('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
                }
            },
            error: function(xhr, status, error) {
                alert('Không thể tải trang. Vui lòng kiểm tra kết nối và thử lại.');
            },
            complete: function() {
                $('#productTableBody').removeClass('loading');
                $link.removeClass('loading');
            }
        });
        
        return false;
    });

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

// Auto-generate product code from name
$(document).on('input', '#ten_sp', function() {
    var name = this.value;
    var code = name.toLowerCase()
                   .replace(/[^\w\s]/gi, '')
                   .replace(/\s+/g, '-');
    if (code && !document.getElementById('ma_sp').value) {
        document.getElementById('ma_sp').value = code.substring(0, 20);
    }
});

// Submit form function
function submitAddForm() {
    var form = document.getElementById('productForm');
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

// Remove old Bootstrap modal handlers
$('#addProductModal').off('show.bs.modal shown.bs.modal hidden.bs.modal');

// Show success/error message if redirected with parameters
<?php if(isset($_GET['success'])): ?>
$(document).ready(function() {
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert-success').alert('close');
    }, 5000);
    
    // Remove success parameter from URL
    const url = new URL(window.location);
    url.searchParams.delete('success');
    window.history.replaceState({}, '', url);
    
    // Reload the product list
    performSearch();
});
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
$(document).ready(function() {
    // Auto-hide after 10 seconds for errors (longer to read)
    setTimeout(function() {
        $('.alert-danger').alert('close');
    }, 10000);
    
    // Remove error parameter from URL
    const url = new URL(window.location);
    url.searchParams.delete('error');
    window.history.replaceState({}, '', url);
});
<?php endif; ?>

// Function to export products to Excel
function exportProducts() {
    // Get current search parameters
    var search = $('#searchForm input[name="search"]').val() || '';
    var search_field = $('#searchForm select[name="search_field"]').val() || 'all';
    var price_min = $('#searchForm input[name="price_min"]').val() || '';
    var price_max = $('#searchForm input[name="price_max"]').val() || '';
    
    // Build export URL with current filters
    var exportUrl = 'modules/quanLySanPham/export.php?action=export';
    if (search) exportUrl += '&search=' + encodeURIComponent(search);
    if (search_field) exportUrl += '&search_field=' + encodeURIComponent(search_field);
    if (price_min) exportUrl += '&price_min=' + encodeURIComponent(price_min);
    if (price_max) exportUrl += '&price_max=' + encodeURIComponent(price_max);
    
    // Download file
    window.open(exportUrl, '_blank');
}


</script>

<!-- Thêm SweetAlert2 cho thông báo -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
