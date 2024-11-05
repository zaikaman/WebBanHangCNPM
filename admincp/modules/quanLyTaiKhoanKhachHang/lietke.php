<?php
	include("config/config.php");
    $sql_lietke_khachhang = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
    $lietke_khachhang = mysqli_query($mysqli, $sql_lietke_khachhang);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .col-id { width: 150px; }
    .col-name { width: 250px; }
    .col-address { width: 400px; }
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }
</style>

<div class="container mt-5">
    <h3 class="text-center">Liệt kê khách hàng</h3>
    <table class="table table-bordered table-fixed">
        <thead class="table-dark">
            <tr>
                <td scope="col" class="col-id">ID Khách hàng</td>
                <td scope="col" class="col-name">Tên khách hàng</td>
                <td scope="col" class="col-address">Địa chỉ</td>
                <td scope="col">Số điện thoại</td>
                <td scope="col">Email</td>
                <td scope="col">Trạng thái</td>             
                <td scope="col">Quản Lý</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($lietke_khachhang)) {
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
