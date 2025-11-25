<?php
include("config/config.php");

// Nhận parameter từ URL - có thể là 'code' hoặc 'id_gh'
if (isset($_GET['code'])) {
    $ma_gh = $_GET['code'];
    // Truy vấn theo mã giỏ hàng - Sử dụng gia_mua từ tbl_chitiet_gh nếu có, fallback sang gia_sp
    $sql_lietke_dh = "SELECT c.*, s.ten_sp, 
                      COALESCE(c.gia_mua, s.gia_sp) as gia_sp 
                      FROM tbl_chitiet_gh c 
                      INNER JOIN tbl_sanpham s ON c.id_sp = s.id_sp 
                      WHERE c.ma_gh='" . $ma_gh . "' 
                      ORDER BY c.id_ctgh DESC";
    // Lấy thông tin đơn hàng và khách hàng
    $sql_hoadon = "SELECT h.*, d.ten_khachhang, d.dien_thoai, d.dia_chi_chi_tiet as dia_chi 
                   FROM tbl_hoadon h 
                   LEFT JOIN tbl_dangky d ON h.id_khachhang = d.id_dangky 
                   WHERE h.ma_gh = '$ma_gh'";
} elseif (isset($_GET['id_gh'])) {
    $id_gh = $_GET['id_gh'];
    // Lấy mã giỏ hàng từ id_gh
    $sql_get_ma_gh = "SELECT ma_gh FROM tbl_hoadon WHERE id_gh = '$id_gh'";
    $result_ma_gh = mysqli_query($mysqli, $sql_get_ma_gh);
    if ($row_ma_gh = mysqli_fetch_array($result_ma_gh)) {
        $ma_gh = $row_ma_gh['ma_gh'];
        $sql_lietke_dh = "SELECT c.*, s.ten_sp, 
                          COALESCE(c.gia_mua, s.gia_sp) as gia_sp 
                          FROM tbl_chitiet_gh c 
                          INNER JOIN tbl_sanpham s ON c.id_sp = s.id_sp 
                          WHERE c.ma_gh='" . $ma_gh . "' 
                          ORDER BY c.id_ctgh DESC";
        // Lấy thông tin đơn hàng và khách hàng
        $sql_hoadon = "SELECT h.*, d.ten_khachhang, d.dien_thoai, d.dia_chi_chi_tiet as dia_chi 
                       FROM tbl_hoadon h 
                       LEFT JOIN tbl_dangky d ON h.id_khachhang = d.id_dangky 
                       WHERE h.id_gh = '$id_gh'";
    } else {
        echo "<div class='alert alert-danger'>Không tìm thấy đơn hàng!</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>Thiếu thông tin đơn hàng!</div>";
    exit;
}

$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
$result_hoadon = mysqli_query($mysqli, $sql_hoadon);
$hoadon = mysqli_fetch_array($result_hoadon);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .card {
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        border-bottom: none;
        font-weight: 600;
    }

    .badge {
        padding: 8px 12px;
        font-size: 0.9em;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 0.95em;
    }

    .table th {
        background-color: #dc3545;
        color: white;
        font-weight: 600;
        border: none;
    }

    .table-striped>tbody>tr:nth-of-type(odd)>td {
        background-color: rgba(0, 0, 0, .02);
    }

    /* Custom scrollbar styles */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #a90019 0%, #dc0021 100%);
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }
        
        .card-header h5 {
            font-size: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .table th, .table td {
            padding: 0.5rem;
            font-size: 0.9rem;
        }
        
        .badge {
            font-size: 0.8rem;
            padding: 6px 10px;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .d-flex.flex-column.flex-md-row .btn:last-child {
            margin-bottom: 0;
        }
    }

    @media (max-width: 576px) {
        h3 {
            font-size: 1.5rem;
            text-align: center;
        }
        
        .card-header h5 {
            font-size: 0.9rem;
        }
        
        .table th, .table td {
            padding: 0.4rem;
            font-size: 0.8rem;
        }
        
        .text-muted {
            font-size: 0.85rem;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 4px 8px;
        }
    }
</style>

<div class="container">
    <div class="flex column justify-center align-center">
        <h3 style="align-items: center; justify-content:center; text-align:center; font-weight:bold; margin-bottom : 20px;"> Đơn Hàng #<?php echo isset($hoadon['id_gh']) ? $hoadon['id_gh'] : ''; ?></h3>

        <!-- Thông tin khách hàng và đơn hàng -->
        <div class="row mb-4 g-0" style="display: flex; flex-wrap: nowrap; gap: 10px;">
            <div style="flex: 1; min-width: 0;">
                <div class="card bg-light h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <strong><i class="fas fa-user-tag me-2"></i>Tên khách hàng:</strong>
                            <div class="text-muted"><?php echo $hoadon['ten_khachhang'] ? $hoadon['ten_khachhang'] : 'Khách vãng lai'; ?></div>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-phone me-2"></i>Số điện thoại:</strong>
                            <div class="text-muted"><?php echo $hoadon['dien_thoai'] ? $hoadon['dien_thoai'] : 'Không có'; ?></div>
                        </div>
                        <div class="flex-fill">
                            <strong><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ:</strong>
                            <div class="text-muted"><?php echo $hoadon['dia_chi'] ? $hoadon['dia_chi'] : 'Không có'; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 1; min-width: 0;">
                <div class="card bg-light h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <strong><i class="fas fa-hashtag me-2"></i>Mã đơn hàng:</strong>
                            <div class="text-muted">#<?php echo $hoadon['id_gh']; ?></div>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-shopping-bag me-2"></i>Mã giỏ hàng:</strong>
                            <div class="text-muted"><?php echo $hoadon['ma_gh']; ?></div>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-calendar me-2"></i>Ngày đặt:</strong>
                            <div class="text-muted"><?php echo date('d/m/Y H:i:s', strtotime($hoadon['cart_date'])); ?></div>
                        </div>
                        <div class="flex-fill">
                            <strong><i class="fas fa-info-circle me-2"></i>Trạng thái:</strong>
                            <div class="mt-2">
                                <?php if ($hoadon['trang_thai'] == 0) { ?>
                                    <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Đã xử lý</span>
                                <?php } elseif ($hoadon['trang_thai'] == 2) { ?>
                                    <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i>Đã hủy</span>
                                <?php } else { ?>
                                    <span class="badge bg-warning fs-6"><i class="fas fa-clock me-1"></i>Chờ xử lý</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <h5 class="mb-3"><i class="fas fa-shopping-bag"></i> Chi tiết sản phẩm</h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã Giỏ Hàng</th>
                        <th>Tên Sản Phẩm</th>
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
                            <td> <?php echo $i ?></td>
                            <td> <?php echo $row['ma_gh'] ?></td>
                            <td> <?php echo $row['ten_sp'] ?></td>
                            <td> <?php echo $row['so_luong_mua'] ?></td>
                            <td> <?php echo number_format($row['gia_sp'], 0, ',', '.') . ' VND' ?></td>
                            <td> <?php echo number_format($thanhtien, 0, ',', '.') . ' VND' ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="table-warning">
                        <td colspan="5" class="text-end"><strong>Tổng Tiền:</strong></td>
                        <td><strong><?php echo number_format($tongtien, 0, ',', '.') . ' VND' ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer text-center">
        <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
            <a href="index.php?action=donHang&query=lietke" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại
            </a>
            <a href="modules/quanLyDonHang/indonhang.php?code=<?php echo $ma_gh ?>" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>In Đơn Hàng
            </a>
        </div>
    </div>
</div>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>