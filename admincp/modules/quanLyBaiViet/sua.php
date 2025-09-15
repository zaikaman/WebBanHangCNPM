<?php
include("config/config.php");
$sql_sua_bv = "SELECT * FROM tbl_baiviet WHERE id='$_GET[idbv]' LIMIT 1";
$sua_bv = mysqli_query($mysqli, $sql_sua_bv);
?>
<!-- Bootstrap CSS -->
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
            Sửa Bài Viết
        </h3>
    </div>
    <?php while ($row = mysqli_fetch_array($sua_bv)) { ?>
        <form method="POST" action="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tenbaiviet" class="form-label fw-bold">Tên Bài Viết:</label>
                <input type="text" class="form-control" id="tenbaiviet" value="<?php echo $row['tenbaiviet'] ?>" name="tenbaiviet">
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label fw-bold">Hình Ảnh:</label>
                <input type="file" class="form-control" id="hinhanh" name="hinhanh">
                <img src="modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" width="150px" class="mt-2">
            </div>
            <div class="mb-3">
                <label for="tomtat" class="form-label fw-bold">Tóm Tắt:</label>
                <textarea rows="5" class="form-control" id="tomtat" name="tomtat"><?php echo str_replace('\n', "\n", $row['tomtat']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="noidung" class="form-label fw-bold">Nội Dung:</label>
                <textarea rows="5" class="form-control" id="noidung" name="noidung"><?php echo str_replace('\n', "\n", $row['noidung']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="link" class="form-label fw-bold">Link:</label>
                <input type="text" class="form-control" id="link" value="<?php echo $row['link'] ?>" name="link">
            </div>
            <div class="mb-3">
                <label for="id_danhmuc" class="form-label fw-bold">Danh Mục Bài Viết:</label>
                <select class="form-select" id="id_danhmuc" name="id_danhmuc">
                    <?php
                    $sql_danhmuc = "SELECT * FROM tbl_danhmuc_baiviet ORDER BY id_baiviet DESC";
                    $sql_query = mysqli_query($mysqli, $sql_danhmuc);
                    while ($row_danhmuc = mysqli_fetch_array($sql_query)) {
                        $selected = ($row_danhmuc['id_baiviet'] == $row['id_danhmuc']) ? 'selected' : '';
                        echo "<option value='" . $row_danhmuc['id_baiviet'] . "' $selected>" . $row_danhmuc['tendanhmuc_baiviet'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tinhtrang" class="form-label fw-bold">Tình Trạng:</label>
                <select class="form-select" id="tinhtrang" name="tinhtrang">
                    <option value="1" <?php echo ($row['tinhtrang'] == 1) ? 'selected' : '' ?>>Kích Hoạt</option>
                    <option value="0" <?php echo ($row['tinhtrang'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>
            <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                <button type="submit" name="suabaiviet" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Sửa Bài Viết
                </button>
                <a href="index.php?action=quanLyBaiViet&query=lietke" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </form>
    <?php } ?>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>