<?php
	include("config/config.php");
    $sql_lietke_danhmucbv= "SELECT * FROM tbl_admin ORDER BY id_ad DESC ";
    $lietke_danhmucbv= mysqli_query($mysqli,$sql_lietke_danhmucbv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container mt-2">
    <h2 class="text-center mb-4">Quản Lý Người Dùng</h2>
    <div class="row justify-content-center">
        <?php
        while ($row = mysqli_fetch_array($lietke_danhmucbv)) {
        ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user me-2"></i>Thông tin người dùng
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-id-badge me-2"></i>
                        <?php echo htmlspecialchars($row['user_name']) ?>
                    </h5>
                    <div class="mt-3 d-flex gap-2">
                        <a href="?action=quanLyAdmin&query=doimatkhau&id=<?php echo $row['id_ad'] ?>" 
                           class="btn btn-warning">
                            <i class="fas fa-key me-1"></i> Đổi mật khẩu
                        </a>
                        <a href="?action=quanLyAdmin&query=sua&id=<?php echo $row['id_ad'] ?>" 
                           class="btn btn-info">
                            <i class="fas fa-edit me-1"></i> Đổi tên
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
