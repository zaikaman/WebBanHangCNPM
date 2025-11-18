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
$where_clause = "";

if (!empty($search)) {
    switch ($search_field) {
        case 'ten_khachhang':
            $where_clause = " WHERE ten_khachhang LIKE '%$search%'";
            break;
        case 'email':
            $where_clause = " WHERE email LIKE '%$search%'";
            break;
        case 'dien_thoai':
            $where_clause = " WHERE dien_thoai LIKE '%$search%'";
            break;
        case 'dia_chi':
            $where_clause = " WHERE dia_chi LIKE '%$search%'";
            break;
        default:
            $where_clause = " WHERE (ten_khachhang LIKE '%$search%' 
                            OR email LIKE '%$search%' 
                            OR dien_thoai LIKE '%$search%'
                            OR dia_chi LIKE '%$search%')";
    }
}

// Đếm tổng số bản ghi
$sql_count = "SELECT COUNT(*) as total FROM tbl_dangky $where_clause";
$count_result = mysqli_query($mysqli, $sql_count);
$total_records = mysqli_fetch_array($count_result)['total'];

// Tạo pagination object
$query_params = $_GET;
unset($query_params['page']);
$pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);

$sql_lietke = "SELECT *, dia_chi_chi_tiet as dia_chi FROM tbl_dangky $where_clause ORDER BY id_dangky DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<style>
    .text-7tcc {
        color: #dc0021 !important;
    }

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
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
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
        .table th,
        .table td {
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

        .table th,
        .table td {
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
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h3 class="text-7tcc mb-0 fw-bold">
            <i class="fas fa-users me-2"></i>Danh Sách Tài Khoản Khách Hàng
        </h3>
        <button type="button" class="btn btn-success" onclick="exportCustomers()">
            <i class="fas fa-file-excel me-2"></i>Xuất Excel
        </button>
    </div>

    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>

    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm & Lọc Tài Khoản Khách Hàng</h6>
        <form class="row g-3" method="GET" action="index.php">
            <input type="hidden" name="action" value="quanLyTaiKhoanKhachHang">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">

            <div class="col-lg-5 col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
            </div>

            <div class="col-lg-4 col-md-6">
                <select name="search_field" class="form-select">
                    <option value="all" <?php echo ($search_field == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                    <option value="ten_khachhang" <?php echo ($search_field == 'ten_khachhang') ? 'selected' : ''; ?>>Tên khách hàng</option>
                    <option value="email" <?php echo ($search_field == 'email') ? 'selected' : ''; ?>>Email</option>
                    <option value="dien_thoai" <?php echo ($search_field == 'dien_thoai') ? 'selected' : ''; ?>>Số điện thoại</option>
                    <option value="dia_chi" <?php echo ($search_field == 'dia_chi') ? 'selected' : ''; ?>>Địa chỉ</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-12">
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLyTaiKhoanKhachHang&query=lietke" class="btn btn-refresh flex-fill">
                        <i class="fas fa-sync-alt"></i>
                        <span>Làm mới</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $start_number = $pagination->getOffset();
                $i = $start_number;
                while ($row = mysqli_fetch_array($lietke)) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['ten_khachhang'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['dien_thoai'] ?></td>
                        <td><?php echo $row['dia_chi'] ?></td>
                        <td>
                            <a href="modules/quanLyTaiKhoanKhachHang/xuly.php?id=<?php echo $row['id_dangky'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
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

<!-- Link Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to export customers to Excel
    function exportCustomers() {
        // Get current search parameters
        var search = $('input[name="search"]').val() || '';
        var search_field = $('select[name="search_field"]').val() || 'all';

        // Build export URL with current filters
        var exportUrl = 'modules/quanLyTaiKhoanKhachHang/export.php?action=export';
        if (search) exportUrl += '&search=' + encodeURIComponent(search);
        if (search_field) exportUrl += '&search_field=' + encodeURIComponent(search_field);

        // Download file
        window.open(exportUrl, '_blank');
    }
</script>