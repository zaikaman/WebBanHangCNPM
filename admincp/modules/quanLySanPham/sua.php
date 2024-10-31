<?php
include("config/config.php");
$sql_sua_sp= "SELECT * FROM tbl_sanpham WHERE ma_sp='$_GET[idsp]' LIMIT 1";
$sua_sp= mysqli_query($mysqli,$sql_sua_sp);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Sửa Sản Phẩm</h3>
    <form method="POST" action="modules/quanLySanPham/xuly.php?idsp=<?php echo $_GET['idsp']; ?>" enctype="multipart/form-data">
        <?php while($row= mysqli_fetch_array($sua_sp)) { ?>
        <div class="mb-3">
            <label for="ten_sp" class="form-label">Tên Sản Phẩm</label>
            <input type="text" class="form-control" value="<?php echo $row['ten_sp'] ?>" name="ten_sp">
        </div>
        <div class="mb-3">
            <label for="ma_sp" class="form-label">Mã Sản Phẩm</label>
            <input type="text" class="form-control" value="<?php echo $row['ma_sp'] ?>" name="ma_sp">
        </div>
        <div class="mb-3">
            <label for="gia_sp" class="form-label">Giá Sản Phẩm</label>
            <input type="text" class="form-control" value="<?php echo $row['gia_sp'] ?>" name="gia_sp">
        </div>
        <div class="mb-3">
            <label for="so_luong" class="form-label">Số Lượng</label>
            <input type="text" class="form-control" value="<?php echo $row['so_luong'] ?>" name="so_luong">
        </div>
        <div class="mb-3">
            <label for="so_luong" class="form-label">Số Lượng còn lại</label>
            <input type="text" class="form-control" value="<?php echo $row['so_luong_con_lai'] ?>" name="so_luong_con_lai">
        </div>
        <div class="mb-3">
            <label for="hinh_anh" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" name="hinh_anh">
            <img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" width='150px'>
        </div>
        <div class="mb-3">
            <label for="tom_tat" class="form-label">Tóm Tắt</label>
            <textarea rows="4" class="form-control" name="tom_tat"><?php echo $row['tom_tat'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="noi_dung" class="form-label">Nội Dung</label>
            <textarea rows="4" class="form-control" name="noi_dung"><?php echo $row['noi_dung'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="id_dm" class="form-label">Danh Mục</label>
            <select name="id_dm" class="form-select">
                <?php
                $sql_danhmuc= "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC";
                $sql_query= mysqli_query($mysqli,$sql_danhmuc);
                while($row_danhmuc= mysqli_fetch_array($sql_query)){
                    if($row_danhmuc['id_dm'] == $row['id_dm']) {
                        echo '<option selected value="'.$row_danhmuc['id_dm'].'">'.$row_danhmuc['name_sp'].'</option>';
                    } else {
                        echo '<option value="'.$row_danhmuc['id_dm'].'">'.$row_danhmuc['name_sp'].'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tinh_trang" class="form-label">Tình Trạng</label>
            <select name="tinh_trang" class="form-select">
                <option value="1" <?php echo ($row['tinh_trang'] == 1) ? 'selected' : '' ?>>Kích Hoạt</option>
                <option value="0" <?php echo ($row['tinh_trang'] == 0) ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="suaSanPham">Sửa Sản Phẩm</button>
        <?php } ?>
    </form>
</div>