<?php
include("config/config.php");

// Nhận parameter từ URL - có thể là 'code' hoặc 'id_gh'
if(isset($_GET['code'])) {
    $ma_gh = $_GET['code'];
    // Truy vấn theo mã giỏ hàng
    $sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh c, tbl_sanpham s WHERE c.id_sp = s.id_sp AND c.ma_gh='".$ma_gh."' ORDER BY c.id_ctgh DESC";
} elseif(isset($_GET['id_gh'])) {
    $id_gh = $_GET['id_gh'];
    // Lấy mã giỏ hàng từ id_gh
    $sql_get_ma_gh = "SELECT ma_gh FROM tbl_hoadon WHERE id_gh = '$id_gh'";
    $result_ma_gh = mysqli_query($mysqli, $sql_get_ma_gh);
    if($row_ma_gh = mysqli_fetch_array($result_ma_gh)) {
        $ma_gh = $row_ma_gh['ma_gh'];
        $sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh c, tbl_sanpham s WHERE c.id_sp = s.id_sp AND c.ma_gh='".$ma_gh."' ORDER BY c.id_ctgh DESC";
    } else {
        echo "<div class='alert alert-danger'>Không tìm thấy đơn hàng!</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>Thiếu thông tin đơn hàng!</div>";
    exit;
}

$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h3>Xem Đơn Hàng</h3>
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
            <a href="index.php?action=donHang&query=lietke" class="btn btn-secondary">Quay Lại</a>
            <a href="modules/quanLyDonHang/indonhang.php?code=<?php echo $ma_gh ?>" class="btn btn-primary">In Đơn Hàng</a>
        </div>
    </div>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
