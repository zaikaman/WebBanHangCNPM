<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Thêm Danh Mục Bài Viết</h3>
    <form method="POST" action="modules/quanLyDanhMucBaiViet/xuly.php">
        <div class="mb-3">
            <label for="tendanhmuc" class="form-label">Tên Danh Mục Bài Viết</label>
            <input type="text" class="form-control" id="tendanhmuc" name="tendanhmucbaiviet">
        </div>
<!--         <div class="mb-3">
            <label for="thutu" class="form-label">Thứ Tự</label>
            <input type="text" class="form-control" id="thutu" name="thu_tu">
        </div> -->
        <button type="submit" name="themDanhMucBaiViet" class="btn btn-success">Thêm Danh Mục Bài Viết</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
