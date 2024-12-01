<?php
include("config/config.php");

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

$where_clause = "WHERE tbl_hoadon.id_khachhang = tbl_dangky.id_dangky";

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
        case 'email':
            $where_clause .= " AND tbl_dangky.email LIKE '%$search%'";
            break;
        default:
            $where_clause .= " AND (tbl_hoadon.ma_gh LIKE '%$search%' 
                            OR tbl_dangky.ten_khachhang LIKE '%$search%'
                            OR tbl_dangky.dien_thoai LIKE '%$search%'
                            OR tbl_dangky.email LIKE '%$search%')";
    }
}

if ($status_filter !== '') {
    $where_clause .= " AND tbl_hoadon.trang_thai = '$status_filter'";
}

if (!empty($date_from)) {
    $where_clause .= " AND DATE(tbl_hoadon.cart_date) >= '$date_from'";
}

if (!empty($date_to)) {
    $where_clause .= " AND DATE(tbl_hoadon.cart_date) <= '$date_to'";
}

$sql_lietke_dh = "SELECT * FROM tbl_hoadon,tbl_dangky $where_clause ORDER BY tbl_hoadon.id_gh DESC";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center mb-4">Liệt Kê Đơn Hàng</h3>

    <!-- Form Tìm Kiếm -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="">
                <input type="hidden" name="action" value="quanLyDonHang">
                <input type="hidden" name="query" value="lietke">
                
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-2">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="ma_gh" <?php echo $search_field == 'ma_gh' ? 'selected' : ''; ?>>Mã đơn hàng</option>
                        <option value="ten_khachhang" <?php echo $search_field == 'ten_khachhang' ? 'selected' : ''; ?>>Tên khách hàng</option>
                        <option value="dien_thoai" <?php echo $search_field == 'dien_thoai' ? 'selected' : ''; ?>>Số điện thoại</option>
                        <option value="email" <?php echo $search_field == 'email' ? 'selected' : ''; ?>>Email</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="" <?php echo $status_filter === '' ? 'selected' : ''; ?>>Tất cả trạng thái</option>
                        <option value="1" <?php echo $status_filter === '1' ? 'selected' : ''; ?>>Đơn hàng mới</option>
                        <option value="0" <?php echo $status_filter === '0' ? 'selected' : ''; ?>>Đã xử lý</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" placeholder="Từ ngày" value="<?php echo $date_from; ?>">
                </div>

                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" placeholder="Đến ngày" value="<?php echo $date_to; ?>">
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Tìm</button>
                </div>

                <?php if (!empty($search) || $status_filter !== '' || !empty($date_from) || !empty($date_to)): ?>
                    <div class="col-md-12 mt-2">
                        <a href="?action=quanLyDonHang&query=lietke" class="btn btn-secondary">Xóa tìm kiếm</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Mã Giỏ Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Địa Chỉ</th>
                <th>Email</th>
                <th>SDT</th>
                <th>Trạng Thái</th>
                <th>Ngày Đặt</th>
                <th>Phương Thức Thanh Toán</th>
                <th>Quản Lý</th>
                <th>In Đơn Hàng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($lietke_dh)) {
                $i++;
            ?>
                <tr>
                    <td> <?php echo $i ?></td>
                    <td> <?php echo $row['ma_gh'] ?></td>
                    <td> <?php echo $row['ten_khachhang'] ?></td>
                    <td> <?php echo $row['dia_chi'] ?></td>
                    <td> <?php echo $row['email'] ?></td>
                    <td> <?php echo $row['dien_thoai'] ?></td>
                    <td>
                        <?php
                        if ($row['trang_thai'] == 1) {
                            echo '<a href="modules/quanLyDonHang/xuLy.php?code=' . $row['ma_gh'] . '&action=process" class="btn btn-warning btn-sm">Đơn Hàng Mới</a>';
                        } else {
                            echo '<span class="badge bg-success">Đã Xử Lý</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo $row['cart_date'] ?></td>
                    <td><?php echo $row['cart_payment'] ?></td>
                    <td>
                        <a href="index.php?action=donHang&query=xemDonHang&code=<?php echo $row['ma_gh'] ?>" class="btn btn-info btn-sm">Xem Đơn Hàng</a>
                    </td>
                    <td>
                        <a href="modules/quanLyDonHang/indonhang.php?code=<?php echo $row['ma_gh'] ?>" class="btn btn-primary btn-sm">In Đơn Hàng</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
