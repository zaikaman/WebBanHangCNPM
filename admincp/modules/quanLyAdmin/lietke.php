<?php
	include("config/config.php");
    include("includes/pagination.php");

    // Xử lý tham số phân trang
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 6; // 6 cards per page

    // Xử lý tìm kiếm
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Xây dựng WHERE clause cho tìm kiếm
    $where_clause = "";
    if (!empty($search)) {
        $where_clause = " WHERE user_name LIKE '%$search%'";
    }

    // Đếm tổng số bản ghi
    $sql_count = "SELECT COUNT(*) as total FROM tbl_admin $where_clause";
    $count_result = mysqli_query($mysqli, $sql_count);
    $total_records = mysqli_fetch_array($count_result)['total'];

    // Tạo pagination object
    $query_params = $_GET;
    unset($query_params['page']);
    $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);

    $sql_lietke_danhmucbv = "SELECT * FROM tbl_admin $where_clause ORDER BY id_ad DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
    $lietke_danhmucbv = mysqli_query($mysqli, $sql_lietke_danhmucbv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
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

/* Custom scrollbar for table */
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
    
    /* Search form responsive */
    .search-form-container {
        padding: 15px;
    }
    
    .search-form-container .row.g-3 {
        gap: 10px;
    }
    
    .search-form-container .col-lg-8,
    .search-form-container .col-lg-4,
    .search-form-container .col-md-7,
    .search-form-container .col-md-5 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    /* Table responsive */
    .table th, .table td {
        padding: 0.5rem;
        font-size: 0.9rem;
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
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .search-form-container {
        padding: 10px;
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
    
    /* Hide some columns on very small screens */
    .table th:nth-child(3),
    .table td:nth-child(3) {
        display: none;
    }
}
</style>
<div class="container px-0 py-0">
    <!-- Header với nút thêm danh mục bài viết -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="text-7tcc mb-0 fw-bold">
            <i class="fas fa-list me-2"></i>Quản Lý Tài Khoản Admin
        </h3>
    </div>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm Người Dùng Admin</h6>
        <form class="row g-3" method="GET" action="index.php">
            <input type="hidden" name="action" value="quanLyAdmin">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="col-lg-9 col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Nhập tên người dùng..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLyAdmin&query=lietke" class="btn btn-refresh flex-fill">
                        <i class="fas fa-sync-alt"></i>
                        <span>Làm mới</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="row justify-content-center">
        <?php
        while ($row = mysqli_fetch_array($lietke_danhmucbv)) {
        ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user me-2"></i>Thông tin người dùng
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-id-badge me-2"></i>
                        <?php echo htmlspecialchars($row['user_name']) ?>
                    </h5>
                    <div class="mt-3 d-flex gap-2">
                        <a href="?action=quanLyAdmin&query=doimatkhau&id=<?php echo $row['id_ad'] ?>" 
                           class="btn btn-warning">
                            <i class="fas fa-key me-1"></i> Đổi mật khẩu
                        </a>
                        <a href="?action=quanLyAdmin&query=sua&id=<?php echo $row['id_ad'] ?>" 
                           class="btn btn-info">
                            <i class="fas fa-edit me-1"></i> Đổi tên
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <!-- Pagination -->
    <?php echo $pagination->render(); ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
