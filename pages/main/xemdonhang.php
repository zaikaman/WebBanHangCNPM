<?php
$code = $_GET['code'];

// Lấy thông tin chi tiết đơn hàng
$sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh,tbl_sanpham WHERE tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp AND tbl_chitiet_gh.ma_gh='" . $code . "' ORDER BY tbl_chitiet_gh.id_ctgh DESC ";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

// Lấy thông tin đơn hàng và khách hàng
$sql_don_hang = "SELECT hd.*, dk.ten_khachhang, dk.email, dk.dien_thoai, gh.address, gh.name as ten_nguoi_nhan, gh.phone as sdt_nguoi_nhan 
                FROM tbl_hoadon hd 
                LEFT JOIN tbl_dangky dk ON hd.id_khachhang = dk.id_dangky 
                LEFT JOIN tbl_giaohang gh ON hd.cart_shipping = gh.id_shipping 
                WHERE hd.ma_gh = '$code'";
$don_hang = mysqli_query($mysqli, $sql_don_hang);
$info_don_hang = mysqli_fetch_array($don_hang);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="main_content">
    <div class="cart_content">
        <div class="container-fluid px-3">
            <div class="row">
                <div class="col-12">
                    <!-- Thông tin đơn hàng (responsive cards) -->
                    <div class="order-cards mb-4">
                        <div class="order-cards-row d-flex flex-column flex-lg-row gap-3">
                        <div class="card flex-fill shadow-sm">
                            <div class="card-body py-3">
                                <h6 class="card-title text-primary mb-2"><i class="fas fa-calendar me-2"></i>Ngày đặt hàng</h6>
                                <p class="mb-2 small text-muted"><?php echo isset($info_don_hang['cart_date']) ? date('d/m/Y H:i:s', strtotime($info_don_hang['cart_date'])) : 'N/A'; ?></p>

                                <h6 class="card-title text-primary mb-2"><i class="fas fa-credit-card me-2"></i>Phương thức thanh toán</h6>
                                <p class="mb-0">
                                    <?php
                                    if (isset($info_don_hang['cart_payment'])) {
                                        switch($info_don_hang['cart_payment']) {
                                            case 'tienmat':
                                                echo '<span class="badge bg-success"><i class="fas fa-money-bill-wave me-1"></i>Tiền mặt</span>';
                                                break;
                                            case 'chuyenkhoan':
                                                echo '<span class="badge bg-info"><i class="fas fa-university me-1"></i>Chuyển khoản</span>';
                                                break;
                                            case 'momo':
                                                echo '<span class="badge bg-warning"><i class="fas fa-mobile-alt me-1"></i>MoMo</span>';
                                                break;
                                            case 'vnpay':
                                                echo '<span class="badge bg-primary"><i class="fas fa-credit-card me-1"></i>VNPay</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-secondary">Khác</span>';
                                        }
                                    } else {
                                        echo '<span class="badge bg-secondary">N/A</span>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="card flex-fill shadow-sm">
                            <div class="card-body py-3">
                                <h6 class="card-title text-primary mb-2"><i class="fas fa-info-circle me-2"></i>Trạng thái</h6>
                                <p class="mb-2">
                                    <?php
                                    if (isset($info_don_hang['trang_thai'])) {
                                        if ($info_don_hang['trang_thai'] == 1) {
                                            echo '<span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Đang xử lý</span>';
                                        } else {
                                            echo '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã giao hàng</span>';
                                        }
                                    } else {
                                        echo '<span class="badge bg-secondary">N/A</span>';
                                    }
                                    ?>
                                </p>

                                <h6 class="card-title text-primary mb-2"><i class="fas fa-truck me-2"></i>Địa chỉ giao hàng</h6>
                                <p class="mb-2 small text-muted"><?php echo isset($info_don_hang['address']) ? $info_don_hang['address'] : 'N/A'; ?></p>

                                <?php if (isset($info_don_hang['ten_nguoi_nhan']) && $info_don_hang['ten_nguoi_nhan']): ?>
                                <h6 class="card-title text-primary mb-2"><i class="fas fa-user me-2"></i>Người nhận</h6>
                                <p class="mb-0 small text-muted"><?php echo $info_don_hang['ten_nguoi_nhan'] . ' - ' . $info_don_hang['sdt_nguoi_nhan']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết sản phẩm -->
                <div class="card product-details-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Chi Tiết Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Mã Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Đơn Giá</th>
                                    <th>Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $tongtien = 0;
                                while ($row = mysqli_fetch_array($lietke_dh)) {
                                    $i++;
                                    $thanhtien = $row['so_luong_mua'] * $row['gia_sp'];
                                    $tongtien += $thanhtien;
                                ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class="text-start">
                                            <strong><?php echo $row['ten_sp'] ?></strong>
                                        </td>
                                        <td><?php echo $row['ma_sp'] ?></td>
                                        <td><span class="badge bg-primary"><?php echo $row['so_luong_mua'] ?></span></td>
                                        <td><?php echo number_format($row['gia_sp'], 0, ',', '.') . ' ₫' ?></td>
                                        <td><strong><?php echo number_format($thanhtien, 0, ',', '.') . ' ₫' ?></strong></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-warning">
                                    <td colspan="5" class="text-end"><strong><i class="fas fa-calculator me-2"></i>Tổng Tiền:</strong></td>
                                    <td><strong class="text-danger fs-5"><?php echo number_format($tongtien, 0, ',', '.') . ' ₫' ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php?quanly=lichSuDonHang" class="btn btn-secondary btn-sm me-2" style="font-size: 0.9rem; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left me-2"></i>Quay Lại Lịch Sử
                        </a>
                        <a href="pages/main/indonhang.php?&code=<?php echo $code ?>" class="btn btn-outline-primary btn-sm" target="_blank" style="font-size: 0.9rem; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-print me-2"></i>In Đơn Hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main layout with red and white theme */
.main_content {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
    background: linear-gradient(135deg, #fff 0%, #fef7f7 100%);
    min-height: 100vh;
}
.cart_content {
    margin-bottom: 0 !important;
    padding: 20px 0 !important;
    max-width: 100% !important;
    width: 100% !important;
}

/* Full width container */
.container-fluid {
    max-width: 100% !important;
    padding-left: 15px !important;
    padding-right: 15px !important;
}

/* Page title */
.page-title {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    padding: 20px;
    margin: -20px -15px 25px -15px;
    border-radius: 0 0 15px 15px;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}
.page-title h2 {
    margin: 0;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* Order info cards with red theme */
.order-cards {
    margin-bottom: 25px !important;
}
.order-cards .order-cards-row {
    align-items: stretch;
    gap: 20px !important;
}
.order-cards .card {
    border: 2px solid #dc3545;
    border-radius: 12px !important;
    overflow: hidden;
    flex: 1;
    min-width: 0;
    background: white;
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.15);
    transition: all 0.3s ease;
}
.order-cards .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(220, 53, 69, 0.25);
}
.order-cards .card .card-body {
    min-height: 140px;
    padding: 20px !important;
    background: linear-gradient(135deg, #fff 0%, #fef9f9 100%);
}
.order-cards .card-title {
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 10px !important;
    color: #dc3545;
    display: flex;
    align-items: center;
}
.order-cards .card-title i {
    color: #dc3545;
    margin-right: 8px;
    font-size: 1.1em;
}

/* Status badges with theme colors */
.badge.bg-success {
    background-color: #28a745 !important;
}
.badge.bg-warning {
    background-color: #dc3545 !important;
    color: white !important;
}
.badge.bg-info {
    background-color: #6c757d !important;
}
.badge.bg-primary {
    background-color: #dc3545 !important;
}

/* Product details card */
.product-details-card {
    border: 2px solid #dc3545;
    border-radius: 12px !important;
    overflow: hidden;
    background: white;
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.15);
}
.product-details-card .card-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    color: white !important;
    padding: 18px 25px !important;
    border: none !important;
    border-radius: 0 !important;
}
.product-details-card .card-header h5 {
    margin: 0;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* Table with red theme */
.table {
    margin-bottom: 0 !important;
    font-size: 0.95rem;
    border-collapse: separate;
    border-spacing: 0;
}
.table th {
    background: linear-gradient(135deg, #343a40 0%, #23272b 100%) !important;
    color: white !important;
    font-weight: 700;
    border: none !important;
    padding: 15px 12px !important;
    text-align: center;
    position: relative;
}
.table th:first-child {
    border-radius: 8px 0 0 0;
}
.table th:last-child {
    border-radius: 0 8px 0 0;
}
.table td {
    padding: 15px 12px !important;
    vertical-align: middle !important;
    border-bottom: 1px solid #dee2e6;
    background: white;
}
.table tbody tr:hover {
    background-color: #fef9f9 !important;
}
.table tbody tr:hover td {
    background-color: #fef9f9 !important;
}

/* Total row with red accent */
.table tfoot tr {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}
.table tfoot td {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    font-weight: 700;
    border: 2px solid #dc3545;
    padding: 18px 12px !important;
}
.table tfoot td:first-child {
    border-radius: 0 0 0 8px;
    color: #343a40;
}
.table tfoot td:last-child {
    border-radius: 0 0 8px 0;
    color: #dc3545;
    font-size: 1.2em;
}

/* Card body and footer */
.product-details-card .card-body {
    padding: 0 !important;
    background: white;
}
.product-details-card .card-footer {
    padding: 20px 25px !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    border-top: 2px solid #dc3545;
    border-radius: 0 !important;
}

/* Buttons with theme colors */
.btn-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
    border: none !important;
    font-weight: 600;
    padding: 10px 20px !important;
    border-radius: 8px !important;
    transition: all 0.3s ease;
}
.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
}
.btn-outline-primary {
    color: #dc3545 !important;
    border: 2px solid #dc3545 !important;
    background: white !important;
    font-weight: 600;
    padding: 10px 20px !important;
    border-radius: 8px !important;
    transition: all 0.3s ease;
}
.btn-outline-primary:hover {
    background: #dc3545 !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
}

/* Quantity badge */
.badge.bg-primary {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    color: white !important;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
}

/* Reduce excessive spacing */
.mb-4 {
    margin-bottom: 25px !important;
}
.mb-2 {
    margin-bottom: 10px !important;
}

/* Better responsive layout */
@media (min-width: 992px) {
    .order-cards .order-cards-row {
        display: flex !important;
        flex-wrap: nowrap !important;
    }
    .order-cards .card {
        flex: 1 1 50% !important;
        max-width: 50% !important;
    }
}

/* Mobile responsive */
@media (max-width: 767.98px) {
    .container-fluid {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
    .page-title {
        margin: -20px -10px 20px -10px;
        padding: 15px;
    }
    .order-cards .order-cards-row {
        gap: 15px !important;
    }
    .order-cards .card .card-body {
        min-height: auto;
        padding: 15px !important;
    }
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }
    .table th, .table td {
        padding: 10px 8px !important;
        font-size: 0.9rem;
    }
}

/* Remove default Bootstrap container constraints */
@media (min-width: 1200px) {
    .container-fluid {
        max-width: none !important;
    }
}

/* Animation for cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.order-cards .card, .product-details-card {
    animation: fadeInUp 0.6s ease-out;
}
</style>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>