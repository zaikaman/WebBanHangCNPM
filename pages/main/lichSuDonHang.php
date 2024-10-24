<?php
$id_khachhang = $_SESSION['id_khachhang'];
$sql_lietke_dh = "SELECT * FROM tbl_hoadon, tbl_dangky WHERE tbl_hoadon.id_khachhang = '" . $id_khachhang . "' AND tbl_dangky.id_dangky = '" . $id_khachhang . "' ORDER BY tbl_hoadon.id_gh DESC";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h4>LỊCH SỬ ĐƠN HÀNG</h4>
        <table class="table table-bordered table-hover text-center" style="margin-top : 20px">
            <thead class="table-dark">
                <tr>
                    <th>Tên Khách Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Email</th>
                    <th>SDT</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>
                    <th>Chi tiết</th>
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
                        <td> <?php echo $row['ten_khachhang'] ?></td>
                        <td> <?php echo $row['dia_chi'] ?></td>
                        <td> <?php echo $row['email'] ?></td>
                        <td> <?php echo $row['dien_thoai'] ?></td>
                        <td>
                            <?php
                            if ($row['trang_thai'] == 1) {
                                echo '<span class="btn btn-warning btn-sm">Đơn hàng mới</span>';
                            } else {
                                echo '<span class="badge bg-success">Đã Xử Lý</span>';
                            }
                            ?>
                        </td>
                        <td><?php echo $row['cart_date'] ?></td>
                        <td>
                            <a href="index.php?quanly=xemDonHang&code=<?php echo $row['ma_gh'] ?>" class="btn btn-info btn-sm">Xem Đơn Hàng</a>
                        </td>
                        <td>
                            <a href="pages/main/indonhang.php?&code=<?php echo $row['ma_gh'] ?>" class="btn btn-primary btn-sm">In Đơn Hàng</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>