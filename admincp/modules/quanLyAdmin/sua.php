<?php
    include("config/config.php");
    $sql_sua_danhmucbv= "SELECT * FROM tbl_admin WHERE id_ad='$_GET[id]' LIMIT 1";
    $sua_danhmucbv= mysqli_query($mysqli,$sql_sua_danhmucbv);
    
    $error_message = '';
    if(isset($_POST['suaTen'])) {
        $tenadmin = trim($_POST['tenadmin']);
        if(empty($tenadmin)) {
            $error_message = "Tên người dùng không được để trống";
        } elseif(!preg_match('/^[a-zA-Z0-9\s]+$/', $tenadmin)) {
            $error_message = "Tên người dùng không được chứa ký tự đặc biệt";
        }
    }
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Sửa tên người dùng</h3>
    
    <?php if(!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <?php while($dong = mysqli_fetch_array($sua_danhmucbv)) { ?>
    <form method="POST" action="modules/quanLyAdmin/xuly.php?id=<?php echo $_GET['id'] ?>" onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="tenadmin" class="form-label">Tên người dùng :</label>
            <input type="text" class="form-control" id="tenadmin" value="<?php echo $dong['user_name'] ?>" name="tenadmin" required>
            <div class="invalid-feedback">
                Tên người dùng không được để trống và không chứa ký tự đặc biệt
            </div>
        </div>
        <button type="submit" name="suaTen" class="btn btn-primary">Sửa</button>
        <a href="index.php?action=quanLyAdmin&query=them" class="btn btn-primary">Quay lại</a>
    </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validateForm() {
    const tenadmin = document.getElementById('tenadmin').value.trim();
    if(tenadmin === '') {
        alert('Tên người dùng không được để trống');
        return false;
    }
    if(!/^[a-zA-Z0-9\s]+$/.test(tenadmin)) {
        alert('Tên người dùng không được chứa ký tự đặc biệt');
        return false;
    }
    return true;
}
</script>