<?php
	include("config/config.php");
    $sql_lietke_khachhang = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
    $lietke_khachhang = mysqli_query($mysqli, $sql_lietke_khachhang);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- <style>
    .col-id { width: 150px; }
    .col-name { width: 250px; }
    .col-address { width: 400px; }
</style> -->

<div class="container mt-5">
    <h3 class="text-center">Liệt kê khách hàng</h3>
    <table class="table table-bordered">
        <thead class="table-dark" style="text-align:center">
            <tr>
                <td >ID Khách hàng</td>
                <td >Tên khách hàng</td>
                <td >Địa chỉ</td>
                <td >Số điện thoại</td>
                <td >Email</td>
                <td >Trạng thái</td>             
                <td >Quản Lý</td>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($lietke_khachhang)) {
                $i++;
            ?>
            <tr>
                <td><?php echo $row['id_dangky']; ?></td>
                <td><?php echo $row['ten_khachhang']; ?></td>
                <td><?php echo $row['dia_chi']; ?></td>
                <td><?php echo $row['dien_thoai']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['trang_thai'] == 1 ? 'Đã kích hoạt' : 'Chưa kích hoạt'; ?></td>
                <td>
                    <a href="modules/quanLyTaiKhoanKhachHang/xuly.php?id=<?php echo $row['id_dangky']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
