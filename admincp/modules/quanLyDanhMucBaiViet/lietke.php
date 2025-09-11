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

    $sql_lietke_danhmucbv = "SELECT * FROM tbl_danhmuc_baiviet $where_clause ORDER BY thutu DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
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
</style>

<div class="container mt-5">
    <!-- Header với nút thêm danh mục bài viết -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-7tcc mb-0">
            <i class="fas fa-list me-2"></i>Liệt Kê Danh Mục Bài Viết
        </h3>
        <!-- <a href="?action=quanLyDanhMucBaiViet&query=them" class="btn btn-7tcc">
            <i class="fas fa-plus me-2"></i>Thêm Danh Mục Bài Viết
        </a> -->
    </div>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm Danh Mục Bài Viết</h6>
        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="quanLyDanhMucBaiViet">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="row g-3 align-items-end">
                <div class="col-lg-8 col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="Nhập tên danh mục bài viết..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-lg-4 col-md-5">
                    <div class="search-refresh-container">
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search"></i>
                            <span>Tìm kiếm</span>
                        </button>
                        <a href="index.php?action=quanLyDanhMucBaiViet&query=lietke" class="btn btn-refresh">
                            <i class="fas fa-sync-alt"></i>
                            <span>Làm mới</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Danh Mục Bài Viết</th>
                <th scope="col">Quản Lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $start_number = $pagination->getOffset();
            $i = $start_number;
            while ($row = mysqli_fetch_array($lietke_danhmucbv)) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tendanhmuc_baiviet'] ?></td>
                <td>
                    <a href="modules/quanLyDanhMucBaiViet/xuly.php?idbaiviet=<?php echo $row['id_baiviet'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    <a href="?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=<?php echo $row['id_baiviet'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <!-- Pagination -->
    <?php echo $pagination->render(); ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
