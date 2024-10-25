<?php
include("config/config.php");
$sql_lietke_dh = "SELECT * FROM tbl_hoadon,tbl_dangky WHERE tbl_hoadon.id_khachhang = tbl_dangky.id_dangky ORDER BY tbl_hoadon.id_gh DESC ";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center mb-4">Liệt Kê Đơn Hàng</h3>

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
                            echo '<a href="modules/quanLyDonHang/xuLy.php?code=' . $row['ma_gh'] . '" class="btn btn-warning btn-sm">Đơn Hàng Mới</a>';
                        } else {
                            echo '<span class="badge bg-success">Đã Xử Lý</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo $row['cart_date'] ?></td>
                    <td>
                        <a href="index.php?action=donHang&query=xemDonHang&code=<?php echo $row['ma_gh'] ?>" class="btn btn-info btn-sm">Xem Đơn Hàng</a>
                    </td>
                    <td>
                        <a href="modules/quanLyDonHang/indonhang.php?&code=<?php echo $row['ma_gh'] ?>" class="btn btn-primary btn-sm">In Đơn Hàng</a>
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
