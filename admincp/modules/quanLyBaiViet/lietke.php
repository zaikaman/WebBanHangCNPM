<?php
	include("config/config.php");
    $sql_lietke = "SELECT * FROM tbl_baiviet,tbl_danhmuc_baiviet WHERE tbl_baiviet.id_danhmuc=tbl_danhmuc_baiviet.id_baiviet ORDER BY id DESC";
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Bài Viết</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Bài Viết</th>
                <th scope="col">Hình Ảnh</th>
                <th scope="col">Mã Danh Mục</th>
                <th scope="col">Tóm Tắt</th>
                <th scope="col">Nội Dung</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Quản Lý</th>
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
                <td><?php echo $row['tenbaiviet'] ?></td>
                <td><img src="modules/quanLybaiviet/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
                <td><?php echo $row['id_danhmuc'] ?></td>
                <td>
                         <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['noidung']) ?></textarea>
                    </td>
                    <td>
                        <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['tomtat']) ?></textarea>
                    </td>
                <td><?php echo ($row['tinhtrang'] == 1) ? 'Kích hoạt' : 'Ẩn'; ?></td>
                <td>
                    <a href="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                    <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
