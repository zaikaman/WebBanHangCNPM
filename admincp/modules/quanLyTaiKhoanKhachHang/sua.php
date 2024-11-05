<?php
    include("config/config.php");
    $sql_sua_khachhang= "SELECT * FROM tbl_dangky WHERE id_dangky='$_GET[id]' LIMIT 1";
    $sua_khachhang= mysqli_query($mysqli,$sql_sua_khachhang);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Xoá tài khoản người dùng</h3>
    <?php while($dong = mysqli_fetch_array($sua_khachhang)) { ?>
    <form method="POST" action="modules/quanLyTaiKhoanKhachHang/sua.php?id=<?php echo $_GET['id'] ?>">
    </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>