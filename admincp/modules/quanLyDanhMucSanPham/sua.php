<?php
include("config/config.php");
$sql_sua = "SELECT * FROM tbl_danhmucqa WHERE id_dm='$_GET[idsp]' LIMIT 1";
$sua = mysqli_query($mysqli, $sql_sua);
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
        <h3 class="text-7tcc mb-0 fw-bold">
            Sửa Danh Mục Sản Phẩm
        </h3>
    </div>
    <?php while ($dong = mysqli_fetch_array($sua)) { ?>
        <div class="form-section">
            <form method="POST" action="modules/quanLyDanhMucSanPham/xuly.php?idsp=<?php echo $_GET['idsp'] ?>" id="categoryForm">
                <div class="mb-3">
                    <label for="name_sp" class="form-label fw-bold">Tên Danh Mục Sản Phẩm Mới:</label>
                    <input type="text" class="form-control" id="name_sp" name="name_sp" placeholder="Nhập tên danh mục sản phẩm mới..." required>
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                    <button type="submit" name="suaDanhMuc" class="btn btn-primary"><i class="fas fa-save me-2"></i>Sửa Danh Mục</button>
                    </ <div>

            </form>
        </div>
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