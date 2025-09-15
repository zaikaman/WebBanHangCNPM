<?php
include("config/config.php");
$sql_sua_sp = "SELECT * FROM tbl_sanpham WHERE ma_sp='$_GET[idsp]' LIMIT 1";
$sua_sp = mysqli_query($mysqli, $sql_sua_sp);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<style>
    .text-7tcc {
        color: #dc0021 !important;
    }

    .btn-7tcc {
        background-color: #dc0021;
        border-color: #dc0021;
        color: white;
    }

    .btn-7tcc:hover {
        background-color: #a90019;
        border-color: #a90019;
        color: white;
    }

    .form-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #dc0021;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        /* Header responsive */
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 15px;
        }

        h3 {
            font-size: 1.5rem;
            text-align: center;
        }

        .form-section {
            padding: 15px;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        /* Button group responsive */
        .d-flex.flex-column.flex-md-row {
            flex-direction: column;
        }

        .d-flex.flex-column.flex-md-row .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        h3 {
            font-size: 1.3rem;
        }

        .form-section {
            padding: 10px;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control {
            font-size: 0.9rem;
        }

        /* Button responsive for mobile */
        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* Header responsive for mobile */
        .d-flex.justify-content-between {
            text-align: center;
        }
    }
</style>
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-center align-items-center mb-4">
        <h3 class="text-7tcc mb-0 fw-bold text-center">
            Sửa Sản Phẩm
        </h3>
    </div>
    <form method="POST" action="modules/quanLySanPham/xuly.php?idsp=<?php echo $_GET['idsp']; ?>" enctype="multipart/form-data">
        <?php while ($row = mysqli_fetch_array($sua_sp)) { ?>
            <div class="mb-3">
                <label for="ten_sp" class="form-label fw-bold">Tên Sản Phẩm:</label>
                <input type="text" class="form-control" value="<?php echo $row['ten_sp'] ?>" name="ten_sp">
            </div>
            <div class="mb-3">
                <label for="ma_sp" class="form-label fw-bold">Mã Sản Phẩm:</label>
                <input type="text" class="form-control" value="<?php echo $row['ma_sp'] ?>" name="ma_sp">
            </div>
            <div class="mb-3">
                <label for="gia_sp" class="form-label fw-bold">Giá Sản Phẩm:</label>
                <input type="text" class="form-control" value="<?php echo $row['gia_sp'] ?>" name="gia_sp">
            </div>
            <?php
            // Fetch existing sizes for the product
            $product_id = $row['id_sp'];
            $sql_sizes = "SELECT size, so_luong FROM tbl_sanpham_sizes WHERE id_sp = '$product_id'";
            $query_sizes = mysqli_query($mysqli, $sql_sizes);
            $sizes = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0, 'XXL' => 0];
            if ($query_sizes) {
                while ($row_size = mysqli_fetch_assoc($query_sizes)) {
                    if (isset($sizes[$row_size['size']])) {
                        $sizes[$row_size['size']] = $row_size['so_luong'];
                    }
                }
            }
            ?>
            <div class="mb-3">
                <label class="form-label fw-bold">Số Lượng Theo Size:</label>
                <div class="row g-2">
                    <div class="col">
                        <label for="so_luong_s" class="form-label fw-bold">Size S:</label>
                        <input type="number" class="form-control" name="so_luong_s" id="so_luong_s" min="0" value="<?php echo $sizes['S']; ?>">
                    </div>
                    <div class="col">
                        <label for="so_luong_m" class="form-label fw-bold">Size M:</label>
                        <input type="number" class="form-control" name="so_luong_m" id="so_luong_m" min="0" value="<?php echo $sizes['M']; ?>">
                    </div>
                    <div class="col">
                        <label for="so_luong_l" class="form-label fw-bold">Size L:</label>
                        <input type="number" class="form-control" name="so_luong_l" id="so_luong_l" min="0" value="<?php echo $sizes['L']; ?>">
                    </div>
                    <div class="col">
                        <label for="so_luong_xl" class="form-label fw-bold">Size XL:</label>
                        <input type="number" class="form-control" name="so_luong_xl" id="so_luong_xl" min="0" value="<?php echo $sizes['XL']; ?>">
                    </div>
                    <div class="col">
                        <label for="so_luong_xxl" class="form-label fw-bold">Size XXL:</label>
                        <input type="number" class="form-control" name="so_luong_xxl" id="so_luong_xxl" min="0" value="<?php echo $sizes['XXL']; ?>">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="hinh_anh" class="form-label fw-bold">Hình Ảnh:</label>
                <input type="file" class="form-control" name="hinh_anh">
                <img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" width='150px'>
            </div>
            <div class="mb-3">
                <label for="tom_tat" class="form-label fw-bold">Tóm Tắt:</label>
                <textarea class="form-control" rows="3" name="tom_tat"><?php echo str_replace('\n', "\n", $row['tom_tat']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="noi_dung" class="form-label fw-bold">Nội Dung:</label>
                <textarea class="form-control" rows="3" name="noi_dung">><?php echo str_replace('\n', "\n", $row['noi_dung']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="id_dm" class="form-label fw-bold">Danh Mục:</label>
                <select name="id_dm" class="form-select">
                    <?php
                    $sql_danhmuc = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC";
                    $sql_query = mysqli_query($mysqli, $sql_danhmuc);
                    while ($row_danhmuc = mysqli_fetch_array($sql_query)) {
                        if ($row_danhmuc['id_dm'] == $row['id_dm']) {
                            echo '<option selected value="' . $row_danhmuc['id_dm'] . '">' . $row_danhmuc['name_sp'] . '</option>';
                        } else {
                            echo '<option value="' . $row_danhmuc['id_dm'] . '">' . $row_danhmuc['name_sp'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tinh_trang" class="form-label fw-bold">Tình Trạng:</label>
                <select name="tinh_trang" class="form-select">
                    <option value="1" <?php echo ($row['tinh_trang'] == 1) ? 'selected' : '' ?>>Kích Hoạt</option>
                    <option value="0" <?php echo ($row['tinh_trang'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" name="suaSanPham">Sửa Sản Phẩm</button>
                <a href="index.php?action=quanLySanPham&query=lietke" class="btn btn-secondary">Quay lại</a>
            </div>
        <?php } ?>
    </form>
</div>