<?php
	include("config/config.php");
    $sql_lietke_danhmucbv= "SELECT * FROM tbl_danhmuc_baiviet ORDER BY thutu DESC ";
    $lietke_danhmucbv= mysqli_query($mysqli,$sql_lietke_danhmucbv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Danh Mục Bài Viết</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Danh Mục Bài Viết</th>
                <th scope="col">Quản Lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($lietke_danhmucbv)) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tendanhmuc_baiviet'] ?></td>
                <td>
                    <a href="modules/quanLyDanhMucBaiViet/xuly.php?idbaiviet=<?php echo $row['id_baiviet'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                    <a href="?action=quanLyDanhMucBaiViet&query=sua&idbaiviet=<?php echo $row['id_baiviet'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
