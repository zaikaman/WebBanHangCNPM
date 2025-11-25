<?php
$code = $_GET['code'];

// Lấy thông tin chi tiết đơn hàng - Sử dụng gia_mua từ tbl_chitiet_gh nếu có, fallback sang gia_sp
$sql_lietke_dh = "SELECT c.*, s.ten_sp, 
                  COALESCE(c.gia_mua, s.gia_sp) as gia_sp 
                  FROM tbl_chitiet_gh c 
                  INNER JOIN tbl_sanpham s ON c.id_sp = s.id_sp 
                  WHERE c.ma_gh='" . $code . "' 
                  ORDER BY c.id_ctgh DESC";
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

<link rel="stylesheet" type="text/css" href="css/xemdonhang.css?v=<?php echo time(); ?>">

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
                        <a href="index.php?quanly=lichSuDonHang" class="btn btn-secondary btn-sm me-2 btn-order-action">
                            <i class="fas fa-arrow-left me-2"></i>Quay Lại Lịch Sử
                        </a>
                        <a href="pages/main/indonhang.php?&code=<?php echo $code ?>" class="btn btn-outline-primary btn-sm btn-order-action" target="_blank">
                            <i class="fas fa-print me-2"></i>In Đơn Hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>