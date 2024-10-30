<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Thêm Admin</h3>
    <form method="POST" action="modules/quanLyAdmin/xuly.php">
        <div class="mb-3">
            <label for="tenadmin" class="form-label">Tên :</label>
            <input type="text" class="form-control" id="tenadmin" name="tenadmin">
        </div>
        <div class="mb-3">
            <label for="matkhau" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="matkhau" name="matkhau">
        </div>
        <button type="submit" name="themAdmin" class="btn btn-success">Thêm tài khoản</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
