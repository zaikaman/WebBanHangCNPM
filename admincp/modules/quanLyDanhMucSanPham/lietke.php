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
<link href="../../css/bootstrap-override.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center mb-4">Liệt Kê Danh Mục Sản Phẩm</h3>
    
    <!-- Page Size Selector -->
    <div class="mb-3">
        <?php echo $pagination->renderPageSizeSelector(); ?>
    </div>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm Danh Mục Sản Phẩm</h6>
        <form class="row g-3" method="GET" action="index.php">
            <input type="hidden" name="action" value="quanLyDanhMucSanPham">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="col-lg-9 col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Nhập tên danh mục..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLyDanhMucSanPham&query=lietke" class="btn btn-refresh flex-fill">
                        <i class="fas fa-sync-alt"></i>
                        <span>Làm mới</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Tên Danh Mục</th>
                    <th scope="col" class="text-center">Quản Lý</th>
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
                    <td class="text-center"><?php echo $i ?></td>
                    <td><?php echo $row['name_sp'] ?></td>
                    <td class="text-center">
                        <div class="d-flex flex-column flex-md-row justify-content-center gap-2">
                            <a href="modules/quanLyDanhMucSanPham/xuly.php?idsp=<?php echo $row['id_dm'] ?>" class="btn btn-danger btn-sm mb-1 mb-md-0 me-md-2" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                            <a href="?action=quanLyDanhMucSanPham&query=sua&idsp=<?php echo $row['id_dm'] ?>" class="btn btn-warning btn-sm">
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
    <div class="d-flex justify-content-center">
        <?php echo $pagination->render(); ?>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
