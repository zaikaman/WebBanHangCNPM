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
        case 'ma_gh':
            $where_clause = " AND tbl_hoadon.ma_gh LIKE '%$search%'";
            break;
        case 'ten_khachhang':
            $where_clause = " AND tbl_dangky.ten_khachhang LIKE '%$search%'";
            break;
        case 'dien_thoai':
            $where_clause = " AND tbl_dangky.dien_thoai LIKE '%$search%'";
            break;
        case 'dia_chi':
            $where_clause = " AND tbl_dangky.dia_chi LIKE '%$search%'";
            break;
        case 'trang_thai':
            $status = ($search == 'đã xử lý' || $search == '0') ? 0 : 1;
            $where_clause = " AND tbl_hoadon.trang_thai = $status";
            break;
        default:
            $where_clause = " AND (tbl_hoadon.ma_gh LIKE '%$search%' 
                            OR tbl_dangky.ten_khachhang LIKE '%$search%' 
                            OR tbl_dangky.dien_thoai LIKE '%$search%'
                            OR tbl_dangky.dia_chi LIKE '%$search%')";
    }
}

// Đếm tổng số bản ghi
$sql_count = "SELECT COUNT(*) as total FROM tbl_hoadon 
               INNER JOIN tbl_dangky ON tbl_hoadon.id_khachhang = tbl_dangky.id_dangky 
               WHERE 1=1 $where_clause";
$count_result = mysqli_query($mysqli, $sql_count);
$total_records = mysqli_fetch_array($count_result)['total'];

// Tạo pagination object
$query_params = $_GET;
unset($query_params['page']);
$pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);

$sql_lietke = "SELECT tbl_hoadon.*, tbl_dangky.ten_khachhang, tbl_dangky.dien_thoai, tbl_dangky.dia_chi, tbl_dangky.email 
               FROM tbl_hoadon 
               INNER JOIN tbl_dangky ON tbl_hoadon.id_khachhang = tbl_dangky.id_dangky 
               WHERE 1=1 $where_clause
               ORDER BY tbl_hoadon.id_gh DESC 
               LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Danh Sách Đơn Hàng</h3>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="search-form-container">
        <h6><i class="fas fa-search me-2"></i>Tìm Kiếm & Lọc Đơn Hàng</h6>
        <form class="row g-3" method="GET" action="index.php">
            <input type="hidden" name="action" value="quanLyDonHang">
            <input type="hidden" name="query" value="lietke">
            <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
            
            <div class="col-lg-4 col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-lg-4 col-md-6">
                <select name="search_field" class="form-select">
                    <option value="all" <?php echo ($search_field == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                    <option value="ma_gh" <?php echo ($search_field == 'ma_gh') ? 'selected' : ''; ?>>Mã đơn hàng</option>
                    <option value="ten_khachhang" <?php echo ($search_field == 'ten_khachhang') ? 'selected' : ''; ?>>Tên khách hàng</option>
                    <option value="dien_thoai" <?php echo ($search_field == 'dien_thoai') ? 'selected' : ''; ?>>Số điện thoại</option>
                    <option value="dia_chi" <?php echo ($search_field == 'dia_chi') ? 'selected' : ''; ?>>Địa chỉ</option>
                    <option value="trang_thai" <?php echo ($search_field == 'trang_thai') ? 'selected' : ''; ?>>Trạng thái</option>
                </select>
            </div>
            
            <div class="col-lg-4 col-md-12">
                <div class="search-refresh-container">
                    <button type="submit" class="btn btn-search flex-fill">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="index.php?action=quanLyDonHang&query=lietke" class="btn btn-refresh flex-fill">
                        <i class="fas fa-sync-alt"></i>
                        <span>Làm mới</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Thanh toán</th>
                    <th colspan="2">Quản lý</th>
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
                        <td><?php echo $row['ma_gh'] ?></td>
                        <td><?php echo $row['ten_khachhang'] ?></td>
                        <td><?php echo $row['dia_chi'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['dien_thoai'] ?></td>
                        <td>
                            <?php if($row['trang_thai'] == 0) { ?>
                                <span class="badge bg-success">Đã xử lý</span>
                            <?php } else { ?>
                                <a href="modules/quanLyDonHang/xuLy.php?code=<?php echo $row['ma_gh'] ?>&action=process" class="btn btn-warning btn-sm">Đơn hàng mới</a>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['cart_date'] ?></td>
                        <td><?php echo $row['cart_payment'] ?></td>
                        <td>
                            <a href="index.php?action=donHang&query=xemDonHang&code=<?php echo $row['ma_gh'] ?>" class="btn btn-info btn-sm">Xem đơn hàng</a>
                        </td>
                        <td>
                            <a href="modules/quanLyDonHang/indonhang.php?code=<?php echo $row['ma_gh'] ?>" class="btn btn-primary btn-sm">In đơn hàng</a>
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
