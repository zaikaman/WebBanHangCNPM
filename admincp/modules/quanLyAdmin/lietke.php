<?php
	include("config/config.php");
    $sql_lietke_danhmucbv= "SELECT * FROM tbl_admin ORDER BY id_ad DESC ";
    $lietke_danhmucbv= mysqli_query($mysqli,$sql_lietke_danhmucbv);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt kê người dùng</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên người dùng</th>
                <th scope="col">Quản Lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($lietke_danhmucbv)) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['user_name'] ?></td>
                <td>
                    <a href="?action=quanLyAdmin&query=doimatkhau&id=<?php echo $row['id_ad'] ?>" class="btn btn-warning btn-sm">Đổi mật khẩu</a>
                    <a href="?action=quanLyAdmin&query=sua&id=<?php echo $row['id_ad'] ?>" class="btn btn-warning btn-sm">Đổi tên</a>
                    <a href="modules/quanLyAdmin/xuly.php?id=<?php echo $row['id_ad'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
