<?php
include("config/config.php");
$sql_lietke = "SELECT tbl_hoadon.*, tbl_dangky.ten_khachhang, tbl_dangky.dien_thoai, tbl_dangky.dia_chi, tbl_dangky.email 
               FROM tbl_hoadon 
               INNER JOIN tbl_dangky ON tbl_hoadon.id_khachhang = tbl_dangky.id_dangky 
               ORDER BY tbl_hoadon.id_gh DESC";
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Danh Sách Đơn Hàng</h3>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyDonHang">
                <input type="hidden" name="query" value="timkiem">
                
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm...">
                </div>
                
                <div class="col-md-4">
                    <select name="search_field" class="form-select">
                        <option value="all">Tất cả</option>
                        <option value="ma_gh">Mã đơn hàng</option>
                        <option value="ten_khachhang">Tên khách hàng</option>
                        <option value="dien_thoai">Số điện thoại</option>
                        <option value="dia_chi">Địa chỉ</option>
                        <option value="trang_thai">Trạng thái</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
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
