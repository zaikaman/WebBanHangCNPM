<?php
    include("config/config.php");
    $sql_sua_danhmucbv= "SELECT * FROM tbl_danhmuc_baiviet WHERE id_baiviet='$_GET[idbaiviet]' LIMIT 1";
    $sua_danhmucbv= mysqli_query($mysqli,$sql_sua_danhmucbv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Sửa Danh Mục Bài Viết</h3>
    <?php while($dong = mysqli_fetch_array($sua_danhmucbv)) { ?>
    <form method="POST" action="modules/quanLyDanhMucBaiViet/xuly.php?idbaiviet=<?php echo $_GET['idbaiviet'] ?>">
        <div class="mb-3">
            <label for="tendanhmuc" class="form-label">Tên Danh Mục Bài Viết</label>
            <input type="text" class="form-control" id="tendanhmuc" value="<?php echo $dong['tendanhmuc_baiviet'] ?>" name="tendanhmucbaiviet">
        </div>
<!--         <div class="mb-3">
            <label for="thutu" class="form-label">Thứ Tự</label>
            <input type="text" class="form-control" id="thutu" value="<?php echo $dong['thutu'] ?>" name="thu_tu">
        </div> -->
        <button type="submit" name="suaDanhMucBaiViet" class="btn btn-primary">Sửa Danh Mục Bài Viết</button>
    </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
