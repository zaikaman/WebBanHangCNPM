<?php 
// File dashboard.php đã được include từ main.php, và main.php đã được include từ index.php
// Do đó $mysqli đã có sẵn từ config.php ở index.php, không cần include lại

// Kiểm tra mysqli connection
if (!isset($mysqli) || !$mysqli) {
    echo "<div class='alert alert-danger'>Database connection not available</div>";
    return;
}

// Lấy thống kê tổng quan
$sql_donhang = "SELECT COUNT(*) as total_orders FROM tbl_hoadon";
$query_donhang = mysqli_query($mysqli, $sql_donhang);
$total_orders = mysqli_fetch_array($query_donhang)['total_orders'];

// Tính doanh thu từ chi tiết giỏ hàng và giá sản phẩm
$sql_doanhthu = "SELECT SUM(c.so_luong_mua * s.gia_sp) as total_revenue 
                 FROM tbl_chitiet_gh c 
                 JOIN tbl_sanpham s ON c.id_sp = s.id_sp 
                 JOIN tbl_hoadon h ON c.ma_gh = h.ma_gh 
                 WHERE h.trang_thai = 1";
$query_doanhthu = mysqli_query($mysqli, $sql_doanhthu);
$result_doanhthu = mysqli_fetch_array($query_doanhthu);
$total_revenue = $result_doanhthu ? $result_doanhthu['total_revenue'] : 0;

$sql_sanpham = "SELECT COUNT(*) as total_products FROM tbl_sanpham";
$query_sanpham = mysqli_query($mysqli, $sql_sanpham);
$total_products = mysqli_fetch_array($query_sanpham)['total_products'];

$sql_khachhang = "SELECT COUNT(*) as total_customers FROM tbl_dangky";
$query_khachhang = mysqli_query($mysqli, $sql_khachhang);
$total_customers = mysqli_fetch_array($query_khachhang)['total_customers'];

// Lấy đơn hàng hôm nay
$today = date('Y-m-d');
$sql_donhang_today = "SELECT COUNT(*) as today_orders FROM tbl_hoadon WHERE DATE(STR_TO_DATE(cart_date, '%Y-%m-%d %H:%i:%s')) = '$today'";
$query_donhang_today = mysqli_query($mysqli, $sql_donhang_today);
$today_orders = mysqli_fetch_array($query_donhang_today)['today_orders'];

// Lấy doanh thu hôm nay
$sql_doanhthu_today = "SELECT SUM(c.so_luong_mua * s.gia_sp) as today_revenue 
                       FROM tbl_chitiet_gh c 
                       JOIN tbl_sanpham s ON c.id_sp = s.id_sp 
                       JOIN tbl_hoadon h ON c.ma_gh = h.ma_gh 
                       WHERE DATE(STR_TO_DATE(h.cart_date, '%Y-%m-%d %H:%i:%s')) = '$today' AND h.trang_thai = 1";
$query_doanhthu_today = mysqli_query($mysqli, $sql_doanhthu_today);
$result_doanhthu_today = mysqli_fetch_array($query_doanhthu_today);
$today_revenue = $result_doanhthu_today ? $result_doanhthu_today['today_revenue'] : 0;
?>

<!-- Statistics Cards Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card orders">
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3 title="<?php echo number_format($total_orders); ?> đơn hàng">
                <?php echo number_format($total_orders); ?>
            </h3>
            <p>Tổng đơn hàng</p>
            <small class="text-muted">
                <i class="fas fa-calendar-day mr-1"></i>
                Hôm nay: <?php echo number_format($today_orders); ?>
            </small>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card revenue">
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <h3 title="<?php echo number_format($total_revenue ? $total_revenue : 0); ?> ₫">
                <?php 
                $revenue = $total_revenue ? $total_revenue : 0;
                if ($revenue >= 1000000) {
                    echo number_format($revenue / 1000000, 1) . 'M ₫';
                } elseif ($revenue >= 1000) {
                    echo number_format($revenue / 1000, 1) . 'K ₫';
                } else {
                    echo number_format($revenue) . ' ₫';
                }
                ?>
            </h3>
            <p>Tổng doanh thu</p>
            <small class="text-muted">
                <i class="fas fa-calendar-day mr-1"></i>
                Hôm nay: 
                <?php 
                $today_rev = $today_revenue ? $today_revenue : 0;
                if ($today_rev >= 1000000) {
                    echo number_format($today_rev / 1000000, 1) . 'M ₫';
                } elseif ($today_rev >= 1000) {
                    echo number_format($today_rev / 1000, 1) . 'K ₫';
                } else {
                    echo number_format($today_rev) . ' ₫';
                }
                ?>
            </small>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card products">
            <div class="icon">
                <i class="fas fa-tshirt"></i>
            </div>
            <h3><?php echo number_format($total_products); ?></h3>
            <p>Tổng sản phẩm</p>
            <small class="text-muted">
                <i class="fas fa-boxes mr-1"></i>
                Áo bóng đá chính hãng
            </small>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card customers">
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <h3><?php echo number_format($total_customers); ?></h3>
            <p>Tổng khách hàng</p>
            <small class="text-muted">
                <i class="fas fa-user-plus mr-1"></i>
                Thành viên đăng ký
            </small>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line mr-2"></i>
                        Thống kê đơn hàng theo: <span id="text-date" class="text-warning"></span>
                    </h4>
                    <select class="form-select select_date" style="width: 200px;">
                        <option value="7ngay">7 ngày qua</option>
                        <option value="28ngay">28 ngày qua</option>
                        <option value="90ngay">90 ngày qua</option>
                        <option value="365ngay" selected>365 ngày qua</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div id="chart" style="height: 350px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-history mr-2"></i>
                    Đơn hàng gần đây
                </h4>
            </div>
            <div class="card-body">
                <?php
                $sql_recent_orders = "SELECT h.id_gh, h.cart_date, h.trang_thai, h.ma_gh, d.ten_khachhang,
                                             SUM(c.so_luong_mua * s.gia_sp) as tongtien
                                     FROM tbl_hoadon h 
                                     LEFT JOIN tbl_dangky d ON h.id_khachhang = d.id_dangky 
                                     LEFT JOIN tbl_chitiet_gh c ON h.ma_gh = c.ma_gh
                                     LEFT JOIN tbl_sanpham s ON c.id_sp = s.id_sp
                                     GROUP BY h.id_gh
                                     ORDER BY h.cart_date DESC 
                                     LIMIT 5";
                $query_recent_orders = mysqli_query($mysqli, $sql_recent_orders);
                
                if(mysqli_num_rows($query_recent_orders) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($query_recent_orders)) { ?>
                            <tr>
                                <td><strong>#<?php echo $row['id_gh']; ?></strong></td>
                                <td><?php echo $row['ten_khachhang'] ? $row['ten_khachhang'] : 'Khách vãng lai'; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['cart_date'])); ?></td>
                                <td><strong class="text-danger"><?php echo number_format($row['tongtien'] ? $row['tongtien'] : 0); ?> ₫</strong></td>
                                <td>
                                    <?php if($row['trang_thai'] == 1) { ?>
                                        <span class="badge badge-success">Đã xử lý</span>
                                    <?php } else { ?>
                                        <span class="badge badge-warning">Đang xử lý</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="index.php?action=donHang&query=xemDonHang&id_gh=<?php echo $row['id_gh']; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Chưa có đơn hàng nào</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
