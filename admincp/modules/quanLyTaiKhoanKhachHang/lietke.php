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

$sql_lietke = "SELECT * FROM tbl_dangky $where_clause ORDER BY id_dangky DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Danh Sách Tài Khoản Khách Hàng</h3>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyTaiKhoanKhachHang">
                <input type="hidden" name="query" value="lietke">
                <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
                
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-3">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo ($search_field == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="ten_khachhang" <?php echo ($search_field == 'ten_khachhang') ? 'selected' : ''; ?>>Tên khách hàng</option>
                        <option value="email" <?php echo ($search_field == 'email') ? 'selected' : ''; ?>>Email</option>
                        <option value="dien_thoai" <?php echo ($search_field == 'dien_thoai') ? 'selected' : ''; ?>>Số điện thoại</option>
                        <option value="dia_chi" <?php echo ($search_field == 'dia_chi') ? 'selected' : ''; ?>>Địa chỉ</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <div class="col-md-1">
                    <a href="index.php?action=quanLyTaiKhoanKhachHang&query=lietke" class="btn btn-secondary w-100">
                        <i class="fas fa-refresh"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
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