<?php
	include("config/config.php");
	$sql_lietke= "SELECT * FROM tbl_sanpham, tbl_danhmucqa WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm ORDER BY id_sp DESC";
	$lietke= mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Sản Phẩm</h3>
    <table class="table table-striped table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Tên Sản Phẩm</th>
                <th>Hình Ảnh</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Còn lại</th>
                <th>Danh Mục</th>
                <th>Mã SP</th>
                <th>Nội Dung</th>
                <th>Tóm Tắt</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
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
                    <td><?php echo $row['ten_sp'] ?></td>
                    <td><img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" width="100px"></td>
                    <td><?php echo number_format($row['gia_sp'], 0, ',', '.').' VND' ?></td>
                    <td><?php echo $row['so_luong'] ?></td>
                    <td><?php echo $row['so_luong_con_lai'] ?></td>
                    <td><?php echo $row['name_sp'] ?></td>
                    <td><?php echo $row['ma_sp'] ?></td>
                    <td>
                        <textarea class="form-control" rows="3" readonly><?php echo $row['noi_dung'] ?></textarea>
                    </td>
                    <td>
                        <textarea class="form-control" rows="3" readonly><?php echo $row['tom_tat'] ?></textarea>
                    </td>
                    <td><?php echo ($row['tinh_trang'] == 1) ? 'Kích hoạt' : 'Ẩn' ?></td>
                    <td>
                        <a href="modules/quanLySanPham/xuly.php?idsp=<?php echo $row['ma_sp'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                        <a href="?action=quanLySanPham&query=sua&idsp=<?php echo $row['ma_sp'] ?>" class="btn btn-warning btn-sm">Sửa</a>
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
