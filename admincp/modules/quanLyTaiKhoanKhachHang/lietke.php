<?php
	include("config/config.php");
    $sql_lietke_khachhang= "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC ";
    $lietke_khachhang= mysqli_query($mysqli,$sql_lietke_khachhang);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt kê khách hàng</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID Khách hàng</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Mật khẩu</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Trạng thái</th>             
                <th scope="col">Quản Lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($lietke_khachhang)) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['ten_khachhang'] ?></td>
                <td><?php echo $row['mat_khau'] ?></td>
                <td><?php echo $row['dia_chi'] ?></td>
                <td><?php echo $row['dien_thoai'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo 1 ?></td>
                <td>
                    <a href="modules/quanLyTaiKhoanKhachHang/sua.php?id=<?php echo $row['id_dangky'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
