<?php
    include("config/config.php");
    $sql_sua_danhmucbv= "SELECT * FROM tbl_admin WHERE id_ad='$_GET[id]' LIMIT 1";
    $sua_danhmucbv= mysqli_query($mysqli,$sql_sua_danhmucbv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Sửa tên người dùng</h3>
    <?php while($dong = mysqli_fetch_array($sua_danhmucbv)) { ?>
    <form method="POST" action="modules/quanLyAdmin/xuly.php?id=<?php echo $_GET['id'] ?>">
        <div class="mb-3">
            <label for="tenadmin" class="form-label">Tên người dùng :</label>
            <input type="text" class="form-control" id="tenadmin" value="<?php echo $dong['user_name'] ?>" name="tenadmin">
        </div>
        <button type="submit" name="suaTen" class="btn btn-primary">Sửa</button>
        <a href="index.php?action=quanLyAdmin&query=them" class="btn btn-primary">Quay lại</a>
    </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>