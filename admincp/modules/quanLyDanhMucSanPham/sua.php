<?php
    include("config/config.php");
    $sql_sua = "SELECT * FROM tbl_danhmucqa WHERE id_dm='$_GET[idsp]' LIMIT 1";
    $sua = mysqli_query($mysqli, $sql_sua);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Sửa Danh Mục Sản Phẩm</h3>
    <?php while ($dong = mysqli_fetch_array($sua)) { ?>
    <form method="POST" action="modules/quanLyDanhMucSanPham/xuly.php?idsp=<?php echo $_GET['idsp'] ?>" id="categoryForm">
        <div class="mb-3">
            <label for="name_sp" class="form-label">Tên Danh Mục</label>
            <input type="text" class="form-control" id="name_sp" value="<?php echo $dong['name_sp'] ?>" name="name_sp">
        </div>
        <button type="submit" name="suaDanhMuc" class="btn btn-primary">Sửa Danh Mục</button>
    </form>
    <?php } ?>
</div>

<script>
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    if (!validateAdminForm('categoryForm', validationRules.categoryForm)) {
        e.preventDefault();
    }
});
</script>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
