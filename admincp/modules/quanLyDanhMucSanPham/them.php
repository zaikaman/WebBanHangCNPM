<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Thêm Danh Mục Sản Phẩm</h3>
    <form method="POST" action="modules/quanLyDanhMucSanPham/xuly.php">
        <div class="mb-3">
            <label for="name_sp" class="form-label">Tên Danh Mục</label>
            <input type="text" class="form-control" id="name_sp" name="name_sp">
        </div>
        <div class="mb-3">
            <label for="thu_tu" class="form-label">Thứ Tự</label>
            <input type="text" class="form-control" id="thu_tu" name="thu_tu">
        </div>
        <button type="submit" name="themDanhMuc" class="btn btn-success">Thêm Danh Mục</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
