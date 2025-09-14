<!-- Bootstrap CSS -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

<div class="container px-0 py-0 mb-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-7tcc mb-0 fw-bold">
            <i class="fas fa-plus me-2"></i>Thêm Danh Mục Sản Phẩm
        </h3>
    </div>

    <!-- Form Section -->
    <div class="form-section">
        <form method="POST" action="modules/quanLyDanhMucSanPham/xuly.php" id="categoryForm" autocomplete="off">
            <div class="mb-3">
                <label for="name_sp" class="form-label fw-bold">Tên Danh Mục Sản Phẩm:</label>
                <input type="text" class="form-control" id="name_sp" name="name_sp" placeholder="Nhập tên danh mục sản phẩm..." required>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                <button type="submit" name="themDanhMuc" class="btn btn-7tcc">
                    <i class="fas fa-save me-2"></i>Thêm Danh Mục
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Form validation
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        const nameInput = document.getElementById('name_sp');
        const nameValue = nameInput.value.trim();

        if (!nameValue) {
            e.preventDefault();
            alert('Vui lòng nhập tên danh mục sản phẩm!');
            nameInput.focus();
            return false;
        }

        if (nameValue.length < 2) {
            e.preventDefault();
            alert('Tên danh mục phải có ít nhất 2 ký tự!');
            nameInput.focus();
            return false;
        }

        if (typeof validateAdminForm === 'function' && typeof validationRules !== 'undefined') {
            if (!validateAdminForm('categoryForm', validationRules.categoryForm)) {
                e.preventDefault();
            }
        }
    });

    // Auto focus on name input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('name_sp').focus();
    });
</script>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>