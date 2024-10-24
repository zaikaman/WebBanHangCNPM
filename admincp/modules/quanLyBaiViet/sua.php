<?php
    include("config/config.php");
    $sql_sua_bv = "SELECT * FROM tbl_baiviet WHERE id='$_GET[idbv]' LIMIT 1";
    $sua_bv = mysqli_query($mysqli, $sql_sua_bv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Sửa Bài Viết</h3>
    <?php while ($row = mysqli_fetch_array($sua_bv)) { ?>
    <form method="POST" action="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tenbaiviet" class="form-label">Tên Bài Viết</label>
            <input type="text" class="form-control" id="tenbaiviet" value="<?php echo $row['tenbaiviet'] ?>" name="tenbaiviet">
        </div>
        <div class="mb-3">
            <label for="hinhanh" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" id="hinhanh" name="hinhanh">
            <img src="modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" width="150px" class="mt-2">
        </div>
        <div class="mb-3">
            <label for="tomtat" class="form-label">Tóm Tắt</label>
            <textarea rows="5" class="form-control" id="tomtat" name="tomtat"><?php echo $row['tomtat'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="noidung" class="form-label">Nội Dung</label>
            <textarea rows="5" class="form-control" id="noidung" name="noidung"><?php echo $row['noidung'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" class="form-control" id="link" value="<?php echo $row['link'] ?>" name="link">
        </div>
        <div class="mb-3">
            <label for="id_danhmuc" class="form-label">Danh Mục Bài Viết</label>
            <select class="form-select" id="id_danhmuc" name="id_danhmuc">
                <?php
                $sql_danhmuc = "SELECT * FROM tbl_danhmuc_baiviet ORDER BY id_baiviet DESC";
                $sql_query = mysqli_query($mysqli, $sql_danhmuc);
                while ($row_danhmuc = mysqli_fetch_array($sql_query)) {
                    $selected = ($row_danhmuc['id_baiviet'] == $row['id_danhmuc']) ? 'selected' : '';
                    echo "<option value='" . $row_danhmuc['id_baiviet'] . "' $selected>" . $row_danhmuc['tendanhmuc_baiviet'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tinhtrang" class="form-label">Tình Trạng</label>
            <select class="form-select" id="tinhtrang" name="tinhtrang">
                <option value="1" <?php echo ($row['tinhtrang'] == 1) ? 'selected' : '' ?>>Kích Hoạt</option>
                <option value="0" <?php echo ($row['tinhtrang'] == 0) ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>
        <button type="submit" name="suabaiviet" class="btn btn-primary">Sửa Bài Viết</button>
    </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
