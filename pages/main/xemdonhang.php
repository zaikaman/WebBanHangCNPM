<?php
$code = $_GET['code'];
$sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh,tbl_sanpham WHERE tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp AND tbl_chitiet_gh.ma_gh='" . $code . "' ORDER BY tbl_chitiet_gh.id_ctgh DESC ";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="main_content">
    <div class="cart_content">
        <div class="card" style="width : 90%">
            <div class="card-header text-center bg-primary text-white">
                <h3>Chi tiết Đơn Hàng</h3>
            </div>
            <div class="card-body">
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
            <div class="card-footer text-center">
                <a href="index.php?quanly=lichSuDonHang" class="btn btn-secondary">Quay Lại</a>
                <a href="pages/main/indonhang.php?&code=<?php echo $row['ma_gh'] ?>" class="btn btn-primary" style="margin : 0">In Đơn Hàng</a>
            </div>
        </div>
    </div>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>