<?php
include("config/config.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';

$where_clause = "WHERE 1=1";

if (!empty($search)) {
    switch ($search_field) {
        case 'ma_gh':
            $where_clause .= " AND tbl_hoadon.ma_gh LIKE '%$search%'";
            break;
        case 'ten_khachhang':
            $where_clause .= " AND tbl_dangky.ten_khachhang LIKE '%$search%'";
            break;
        case 'dien_thoai':
            $where_clause .= " AND tbl_dangky.dien_thoai LIKE '%$search%'";
            break;
        case 'dia_chi':
            $where_clause .= " AND tbl_dangky.dia_chi_chi_tiet LIKE '%$search%'";
            break;
        case 'trang_thai':
            $status = ($search == 'đã xử lý' || $search == '1') ? 1 : 0;
            $where_clause .= " AND tbl_hoadon.trang_thai = $status";
            break;
        default:
            $where_clause .= " AND (tbl_hoadon.ma_gh LIKE '%$search%' 
                            OR tbl_dangky.ten_khachhang LIKE '%$search%' 
                            OR tbl_dangky.dien_thoai LIKE '%$search%'
                            OR tbl_dangky.dia_chi_chi_tiet LIKE '%$search%')";
    }
}

$sql_lietke = "SELECT tbl_hoadon.*, tbl_dangky.ten_khachhang, tbl_dangky.dien_thoai, tbl_dangky.dia_chi_chi_tiet as dia_chi, tbl_dangky.email 
               FROM tbl_hoadon 
               INNER JOIN tbl_dangky ON tbl_hoadon.id_khachhang = tbl_dangky.id_dangky 
               $where_clause 
               ORDER BY tbl_hoadon.id_gh DESC";
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Kết Quả Tìm Kiếm Đơn Hàng</h3>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyDonHang">
                <input type="hidden" name="query" value="timkiem">
                
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-4">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="ma_gh" <?php echo $search_field == 'ma_gh' ? 'selected' : ''; ?>>Mã đơn hàng</option>
                        <option value="ten_khachhang" <?php echo $search_field == 'ten_khachhang' ? 'selected' : ''; ?>>Tên khách hàng</option>
                        <option value="dien_thoai" <?php echo $search_field == 'dien_thoai' ? 'selected' : ''; ?>>Số điện thoại</option>
                        <option value="dia_chi" <?php echo $search_field == 'dia_chi' ? 'selected' : ''; ?>>Địa chỉ</option>
                        <option value="trang_thai" <?php echo $search_field == 'trang_thai' ? 'selected' : ''; ?>>Trạng thái</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <?php if (!empty($search)): ?>
                    <div class="col-md-2">
                        <a href="index.php?action=quanLyDonHang&query=lietke" class="btn btn-secondary w-100">Quay lại</a>
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
                $i = 0;
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
</div>

<!-- Link Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
