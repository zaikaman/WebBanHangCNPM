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
        $where_clause = " WHERE name_sp LIKE '%$search%'";
    }

    // Đếm tổng số bản ghi
    $sql_count = "SELECT COUNT(*) as total FROM tbl_danhmucqa $where_clause";
    $count_result = mysqli_query($mysqli, $sql_count);
    $total_records = mysqli_fetch_array($count_result)['total'];

    // Tạo pagination object
    $query_params = $_GET;
    unset($query_params['page']);
    $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);

    $sql_lietke = "SELECT * FROM tbl_danhmucqa $where_clause ORDER BY thu_tu LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Danh Mục Sản Phẩm</h3>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyDanhMucSanPham">
                <input type="hidden" name="query" value="lietke">
                <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
                
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Nhập tên danh mục..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <div class="col-md-2">
                    <a href="index.php?action=quanLyDanhMucSanPham&query=lietke" class="btn btn-secondary w-100">
                        <i class="fas fa-refresh"></i> Làm mới
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Danh Mục</th>
                <th scope="col">Quản Lý</th>
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
                <td><?php echo $row['name_sp'] ?></td>
                <td>
                    <a href="modules/quanLyDanhMucSanPham/xuly.php?idsp=<?php echo $row['id_dm'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    <a href="?action=quanLyDanhMucSanPham&query=sua&idsp=<?php echo $row['id_dm'] ?>" class="btn btn-warning btn-sm">Sửa</a>
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
