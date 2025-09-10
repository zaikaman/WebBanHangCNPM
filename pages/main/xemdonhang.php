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
        <div class="row">
            <div class="col-md-12">
                <!-- Thông tin đơn hàng -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Thông Tin Đơn Hàng #<?php echo $code; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-calendar me-2"></i>Ngày đặt hàng:</h6>
                                <p><?php echo isset($info_don_hang['cart_date']) ? date('d/m/Y H:i:s', strtotime($info_don_hang['cart_date'])) : 'N/A'; ?></p>
                                
                                <h6><i class="fas fa-credit-card me-2"></i>Phương thức thanh toán:</h6>
                                <p>
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
                            <div class="col-md-6">
                                <h6><i class="fas fa-info-circle me-2"></i>Trạng thái:</h6>
                                <p>
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
                                
                                <h6><i class="fas fa-truck me-2"></i>Địa chỉ giao hàng:</h6>
                                <p><?php echo isset($info_don_hang['address']) ? $info_don_hang['address'] : 'N/A'; ?></p>
                                
                                <?php if (isset($info_don_hang['ten_nguoi_nhan']) && $info_don_hang['ten_nguoi_nhan']): ?>
                                <h6><i class="fas fa-user me-2"></i>Người nhận:</h6>
                                <p><?php echo $info_don_hang['ten_nguoi_nhan'] . ' - ' . $info_don_hang['sdt_nguoi_nhan']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết sản phẩm -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
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
.main_content {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
.cart_content {
    margin-bottom: 0 !important;
    padding-bottom: 10px !important;
}
</style>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>