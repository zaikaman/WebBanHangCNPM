<?php
	include("config/config.php");
    $sql_lietke_khachhang = "SELECT * FROM tbl_dangky ORDER BY id_dangky";
    $lietke_khachhang = mysqli_query($mysqli, $sql_lietke_khachhang);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center mb-4">Liệt kê khách hàng</h3>
    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <td >ID Khách hàng</td>
                <td >Tên khách hàng</td>
                <td >Địa chỉ</td>
                <td >Số điện thoại</td>
                <td >Email</td>
                <!-- <td >Trạng thái</td>              -->
                <td >Quản Lý</td>
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
                <!-- <td>
                        <?php
                        // if ($row['trang_thai'] == 1) {
                        //     echo "Đang kích hoạt";
                        // } elseif ($row['trang_thai'] == 0){
                        //     echo "Chưa kích hoạt";
                        // }else{
                        //     echo "Đã bị cấm!";
                        // }
                        ?>
                    </td> -->
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
