<?php
include("config/config.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';

$where_clause = "WHERE 1=1";

if (!empty($search)) {
    switch ($search_field) {
        case 'ten_khachhang':
            $where_clause .= " AND ten_khachhang LIKE '%$search%'";
            break;
        case 'email':
            $where_clause .= " AND email LIKE '%$search%'";
            break;
        case 'dien_thoai':
            $where_clause .= " AND dien_thoai LIKE '%$search%'";
            break;
        case 'dia_chi':
            $where_clause .= " AND dia_chi LIKE '%$search%'";
            break;
        default:
            $where_clause .= " AND (ten_khachhang LIKE '%$search%' 
                            OR email LIKE '%$search%' 
                            OR dien_thoai LIKE '%$search%'
                            OR dia_chi LIKE '%$search%')";
    }
}

$sql_lietke = "SELECT *, dia_chi_chi_tiet as dia_chi FROM tbl_dangky $where_clause ORDER BY id_dangky DESC";
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Kết Quả Tìm Kiếm Tài Khoản Khách Hàng</h3>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyTaiKhoanKhachHang">
                <input type="hidden" name="query" value="timkiem">
                
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-4">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="ten_khachhang" <?php echo $search_field == 'ten_khachhang' ? 'selected' : ''; ?>>Tên khách hàng</option>
                        <option value="email" <?php echo $search_field == 'email' ? 'selected' : ''; ?>>Email</option>
                        <option value="dien_thoai" <?php echo $search_field == 'dien_thoai' ? 'selected' : ''; ?>>Số điện thoại</option>
                        <option value="dia_chi" <?php echo $search_field == 'dia_chi' ? 'selected' : ''; ?>>Địa chỉ</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <?php if (!empty($search)): ?>
                    <div class="col-md-12 mt-2">
                        <a href="index.php?action=quanLyTaiKhoanKhachHang&query=lietke" class="btn btn-secondary">Quay lại</a>
                    </div>
                <?php endif; ?>
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
                $i = 0;
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
                            <a href="modules/quanLyTaiKhoanKhachHang/xuly.php?id=<?php echo $row['id_dangky'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Link Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 