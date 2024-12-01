<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<?php
	include("config/config.php");
    $sql_lietke = "SELECT * FROM tbl_baiviet,tbl_danhmuc_baiviet WHERE tbl_baiviet.id_danhmuc=tbl_danhmuc_baiviet.id_baiviet ORDER BY id DESC";
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>

<div class="container mt-5">
    <h3 class="text-center">Thêm Bài Viết</h3>
    <form method="POST" action="modules/quanLyBaiViet/xuly.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tenbaiviet" class="form-label">Tên Bài Viết</label>
            <input type="text" class="form-control" id="tenbaiviet" name="tenbaiviet">
        </div>
        <div class="mb-3">
            <label for="hinhanh" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" id="hinhanh" name="hinhanh">
        </div>
        <div class="mb-3">
            <label for="tomtat" class="form-label">Tóm Tắt</label>
            <textarea rows="5" class="form-control" id="tomtat" name="tomtat"></textarea>
        </div>
        <div class="mb-3">
            <label for="noidung" class="form-label">Nội Dung</label>
            <textarea rows="5" class="form-control" id="noidung" name="noidung"></textarea>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" class="form-control" id="link" name="link">
        </div>
        <div class="mb-3">
            <label for="id_danhmuc" class="form-label">Danh Mục Bài Viết</label>
            <select class="form-select" id="id_danhmuc" name="id_danhmuc">
                <?php
                $sql_danhmuc = "SELECT * FROM tbl_danhmuc_baiviet ORDER BY id_baiviet DESC";
                $sql_query = mysqli_query($mysqli, $sql_danhmuc);
                while ($row_danhmuc = mysqli_fetch_array($sql_query)) {
                    echo "<option value='" . $row_danhmuc['id_baiviet'] . "'>" . $row_danhmuc['tendanhmuc_baiviet'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tinhtrang" class="form-label">Tình Trạng</label>
            <select class="form-select" id="tinhtrang" name="tinhtrang">
                <option value="1">Kích Hoạt</option>
                <option value="0">Ẩn</option>
            </select>
        </div>
        <button type="submit" name="thembaiviet" class="btn btn-success">Thêm Bài Viết</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
