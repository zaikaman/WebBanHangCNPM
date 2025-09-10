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

<div class="container mt-2">
    <h2 class="text-center mb-4">Quản Lý Người Dùng</h2>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector([6, 12, 18, 24]); ?>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyAdmin">
                <input type="hidden" name="query" value="lietke">
                <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
                
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Nhập tên người dùng..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <div class="col-md-2">
                    <a href="index.php?action=quanLyAdmin&query=lietke" class="btn btn-secondary w-100">
                        <i class="fas fa-refresh"></i> Làm mới
                    </a>
                </div>
            </form>
        </div>
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
