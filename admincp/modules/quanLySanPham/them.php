<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<?php
	include("config/config.php");
	$sql_lietke= "SELECT * FROM tbl_sanpham, tbl_danhmucqa WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm ORDER BY id_sp DESC";
	$lietke= mysqli_query($mysqli, $sql_lietke);
?>

<div class="container mt-5">
    <h3 class="text-center">Thêm Sản Phẩm</h3>
    <form method="POST" action="modules/quanLySanPham/xuly.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="ten_sp" class="form-label">Tên Sản Phẩm</label>
            <input type="text" class="form-control" name="ten_sp">
        </div>
        <div class="mb-3">
            <label for="ma_sp" class="form-label">Mã Sản Phẩm</label>
            <input type="text" class="form-control" name="ma_sp">
        </div>
        <div class="mb-3">
            <label for="gia_sp" class="form-label">Giá Sản Phẩm</label>
            <input type="text" class="form-control" name="gia_sp">
        </div>
        <div class="mb-3">
            <label for="so_luong" class="form-label">Số Lượng</label>
            <input type="text" class="form-control" name="so_luong">
        </div>
        <div class="mb-3">
            <label for="hinh_anh" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" name="hinh_anh">
        </div>
        <div class="mb-3">
            <label for="tom_tat" class="form-label">Tóm Tắt</label>
            <textarea rows="4" class="form-control" name="tom_tat"></textarea>
        </div>
        <div class="mb-3">
            <label for="noi_dung" class="form-label">Nội Dung</label>
            <textarea rows="4" class="form-control" name="noi_dung"></textarea>
        </div>
        <div class="mb-3">
            <label for="id_dm" class="form-label">Danh Mục</label>
            <select name="id_dm" class="form-select">
                <?php
                $sql_danhmuc= "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC";
                $sql_query= mysqli_query($mysqli,$sql_danhmuc);
                while($row_danhmuc= mysqli_fetch_array($sql_query)){
                    echo '<option value="'.$row_danhmuc['id_dm'].'">'.$row_danhmuc['name_sp'].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tinh_trang" class="form-label">Tình Trạng</label>
            <select name="tinh_trang" class="form-select">
                <option value="1">Kích Hoạt</option>
                <option value="0">Ẩn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="themSanPham">Thêm Sản Phẩm</button>
    </form>
</div>