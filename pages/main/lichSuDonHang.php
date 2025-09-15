<?php
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['id_khachhang'])) {
    ?>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div class="main_content">
        <div class="cart_content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="text-center py-5">
                            <i class="fas fa-lock fa-5x text-warning mb-4"></i>
                            <h3 class="text-primary mb-3">Bạn cần đăng nhập</h3>
                            <p class="text-muted mb-4">
                                Để xem lịch sử đơn hàng, bạn cần đăng nhập vào tài khoản của mình.
                                <br>Nếu chưa có tài khoản, hãy đăng ký ngay để theo dõi đơn hàng dễ dàng hơn!
                            </p>
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="index.php?quanly=dangnhap" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập
                                </a>
                                <a href="index.php?quanly=dangky" class="btn btn-outline-success">
                                    <i class="fas fa-user-plus me-2"></i>Đăng Ký
                                </a>
                            </div>
                            <div class="mt-4">
                                <a href="index.php" class="text-decoration-none">
                                    <i class="fas fa-home me-2"></i>Quay về trang chủ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    return;
}

$id_khachhang = $_SESSION['id_khachhang'];

// Phân trang
$limit = 10; // Số đơn hàng mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Đếm tổng số đơn hàng
$sql_count = "SELECT COUNT(*) as total FROM tbl_hoadon WHERE id_khachhang = '" . $id_khachhang . "'";
$count_result = mysqli_query($mysqli, $sql_count);
$count_row = mysqli_fetch_array($count_result);
$count_orders = $count_row['total'];

// Tính tổng số trang
$total_pages = ceil($count_orders / $limit);

// Lấy dữ liệu đơn hàng theo trang
$sql_lietke_dh = "SELECT * FROM tbl_hoadon, tbl_dangky 
                  WHERE tbl_hoadon.id_khachhang = '" . $id_khachhang . "' 
                  AND tbl_dangky.id_dangky = '" . $id_khachhang . "' 
                  ORDER BY tbl_hoadon.id_gh DESC 
                  LIMIT $limit OFFSET $offset";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/lichSuDonHang.css?v=<?php echo time(); ?>">

<div class="main_content">
    <div class="cart_content">
        <div class="wrapper-2">
            <div class="arrow-steps clearfix">
                <div class="step done"> <span> <a href="index.php?quanly=giohang"> Giỏ hàng</a></span> </div>
                <div class="step done"> <span><a href="index.php?quanly=vanChuyen"> Vận chuyển</a></span> </div>
                <div class="step done"> <span><a href="index.php?quanly=thongTinThanhToan">Thanh toán</a></span> </div>
                <div class="step current"> <span><a href="index.php?quanly=lichSuDonHang">Lịch sử</a></span> </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h4 class="page-title"><i class="fas fa-history me-2"></i>LỊCH SỬ ĐƠN HÀNG</h4>
        </div>
        
        <?php if ($count_orders == 0): ?>
            <div class="text-center py-5 empty-history-card">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                <h5 class="text-muted">Bạn chưa có đơn hàng nào</h5>
                <p class="text-muted mb-4">Hãy bắt đầu mua sắm để tạo đơn hàng đầu tiên của bạn!</p>
                <a href="index.php" class="btn btn-start-shopping">
                    <i class="fas fa-shopping-bag me-2"></i>Bắt đầu mua sắm
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" style="margin-top : 20px">
                    <thead>
                        <tr>
                            <th><i class="fas fa-calendar me-2"></i>Ngày Đặt</th>
                            <th><i class="fas fa-receipt me-2"></i>Mã Đơn Hàng</th>
                            <th><i class="fas fa-map-marker-alt me-2"></i>Địa Chỉ</th>
                            <th><i class="fas fa-credit-card me-2"></i>Thanh Toán</th>
                            <th><i class="fas fa-info-circle me-2"></i>Trạng Thái</th>
                            <th><i class="fas fa-eye me-2"></i>Chi tiết</th>
                            <th><i class="fas fa-print me-2"></i>In Đơn Hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_array($lietke_dh)) {
                        $i++;
                    ?>
                        <tr>
                            <td data-label="Ngày Đặt"><?php echo date('d/m/Y H:i', strtotime($row['cart_date'])) ?></td>
                            <td data-label="Mã Đơn Hàng"><strong>#<?php echo $row['ma_gh'] ?></strong></td>
                            <td data-label="Địa Chỉ"> 
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                <?php echo $row['dia_chi'] ?>
                            </td>
                            <td data-label="Thanh Toán">
                                <?php
                                $payment_method = '';
                                $payment_class = '';
                                switch($row['cart_payment']) {
                                    case 'tienmat':
                                        $payment_method = '<i class="fas fa-money-bill-wave me-1"></i>Tiền mặt';
                                        $payment_class = 'success';
                                        break;
                                    case 'chuyenkhoan':
                                        $payment_method = '<i class="fas fa-university me-1"></i>Chuyển khoản';
                                        $payment_class = 'info';
                                        break;
                                    case 'momo':
                                        $payment_method = '<i class="fas fa-mobile-alt me-1"></i>MoMo';
                                        $payment_class = 'warning';
                                        break;
                                    case 'vnpay':
                                        $payment_method = '<i class="fas fa-credit-card me-1"></i>VNPay';
                                        $payment_class = 'primary';
                                        break;
                                    default:
                                        $payment_method = '<i class="fas fa-question-circle me-1"></i>Khác';
                                        $payment_class = 'secondary';
                                }
                                echo '<span class="badge bg-' . $payment_class . '">' . $payment_method . '</span>';
                                ?>
                            </td>
                            <td data-label="Trạng Thái">
                                <?php
                                if ($row['trang_thai'] == 1) {
                                    echo '<span class="badge bg-status-processing"><i class="fas fa-clock me-1"></i>Đang xử lý</span>';
                                } else {
                                    echo '<span class="badge bg-status-delivered"><i class="fas fa-check-circle me-1"></i>Đã giao hàng</span>';
                                }
                                ?>
                            </td>
                            <td data-label="Chi tiết">
                                <a href="index.php?quanly=xemDonHang&code=<?php echo $row['ma_gh'] ?>" class="btn btn-view-order btn-sm">
                                    <i class="fas fa-eye me-1"></i>Xem
                                </a>
                            </td>
                            <td data-label="In Đơn Hàng">
                                <a href="pages/main/indonhang.php?&code=<?php echo $row['ma_gh'] ?>" class="btn btn-print-order btn-sm" target="_blank">
                                    <i class="fas fa-print me-1"></i>In
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            </div>
        
        <!-- Phân trang -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Phân trang đơn hàng" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Nút Previous -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?quanly=lichSuDonHang&page=<?php echo $page - 1; ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                        </li>
                    <?php endif; ?>
                    
                    <!-- Các số trang -->
                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);
                    
                    if ($start_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?quanly=lichSuDonHang&page=1">1</a>
                        </li>
                        <?php if ($start_page > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif;
                    endif;
                    
                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?quanly=lichSuDonHang&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor;
                    
                    if ($end_page < $total_pages): ?>
                        <?php if ($end_page < $total_pages - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?quanly=lichSuDonHang&page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
                        </li>
                    <?php endif; ?>
                    
                    <!-- Nút Next -->
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?quanly=lichSuDonHang&page=<?php echo $page + 1; ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <!-- Thông tin phân trang -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    Hiển thị <?php echo ($offset + 1); ?>-<?php echo min($offset + $limit, $count_orders); ?> 
                    trong tổng số <?php echo $count_orders; ?> đơn hàng
                </small>
            </div>
        <?php endif; ?>
        
        <?php endif; ?>
    </div>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>