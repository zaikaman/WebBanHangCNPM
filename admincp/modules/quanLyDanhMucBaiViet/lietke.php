<?php
	include("config/config.php");
    include("includes/pagination.php");

    // Xử lý tham số phân trang
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;

    // Xử lý tìm kiếm
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Xây dựng WHERE clause cho tìm kiếm
    $where_clause = "";
    if (!empty($search)) {
        $where_clause = " WHERE tendanhmuc_baiviet LIKE '%$search%'";
    }

    // Đếm tổng số bản ghi
    $sql_count = "SELECT COUNT(*) as total FROM tbl_danhmuc_baiviet $where_clause";
    $count_result = mysqli_query($mysqli, $sql_count);
    $total_records = mysqli_fetch_array($count_result)['total'];

    // Tạo pagination object
    $query_params = $_GET;
    unset($query_params['page']);
    $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);

    $sql_lietke_danhmucbv = "SELECT dm.*, (SELECT COUNT(*) FROM tbl_baiviet bv WHERE bv.id_danhmuc = dm.id_baiviet) AS post_count
                             FROM tbl_danhmuc_baiviet dm
                             " . ($where_clause ? str_replace('tbl_danhmuc_baiviet', 'dm', $where_clause) : '') . "
                             ORDER BY dm.thutu DESC
                             LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
    $lietke_danhmucbv = mysqli_query($mysqli, $sql_lietke_danhmucbv);
?>
<!-- Bootstrap CSS -->
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
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="text-7tcc mb-0 fw-bold">
            <i class="fas fa-list me-2"></i>Quản Lý Danh Mục Bài Viết
        </h3>
    </div>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm & Lọc Danh Mục Bài Viết</h6>
        <form class="row g-3" method="GET" action="index.php" id="searchForm">
            <input type="hidden" name="action" value="quanLyDanhMucBaiViet">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="col-lg-8 col-md-6 col-12">
                <label class="form-label fw-bold">Tên danh mục bài viết</label>
                <input type="text" name="search" class="form-control" placeholder="Nhập tên danh mục bài viết..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-lg-4 col-md-6 col-12">
                <label class="form-label fw-bold d-block">&nbsp;</label>
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLyDanhMucBaiViet&query=lietke" class="btn btn-refresh flex-fill">
                        <i class="fas fa-sync-alt"></i>
                        <span>Làm mới</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Danh Mục Bài Viết</th>
                    <th>Số Bài Viết</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $start_number = $pagination->getOffset();
                $i = $start_number;
                while ($row = mysqli_fetch_array($lietke_danhmucbv)) {
                    $i++;
                ?>
                <tr class="category-row" data-id="<?php echo (int)$row['id_baiviet']; ?>">
                    <td><?php echo $i ?></td>
                    <td><?php echo htmlspecialchars($row['tendanhmuc_baiviet']) ?></td>
                    <td><span class="badge bg-info"><?php echo (int)$row['post_count']; ?></span></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="modules/quanLyDanhMucBaiViet/xuly.php?idbaiviet=<?php echo $row['id_baiviet'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo (int)$row['post_count'] > 0 ? 'Danh mục còn bài viết (' . (int)$row['post_count'] . '). Không thể xóa!' : 'Bạn có chắc chắn muốn xóa?'; ?>'); return <?php echo (int)$row['post_count'] > 0 ? 'false' : 'true'; ?>;">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                            <a href="?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=<?php echo $row['id_baiviet'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div id="paginationContainer">
        <?php echo $pagination->render(); ?>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Click row to view detail (delegate for list)
$(document).on('click', '.category-row', function(e) {
    if ($(e.target).closest('a, button, .btn, input, textarea, select, label').length) {
        return;
    }
    var id = $(this).data('id');
    if (id) {
        window.location.href = '?action=quanLyDanhMucBaiViet&query=chitiet&id=' + id;
    }
});
</script>
