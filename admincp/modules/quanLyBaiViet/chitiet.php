<?php
    // Kết nối config
    if (file_exists("../../config/config.php")) {
        include("../../config/config.php");
    } else {
        include("config/config.php");
    }

    // Lấy id bài viết an toàn
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id <= 0) {
        echo '<div class="alert alert-danger m-3">ID bài viết không hợp lệ.</div>';
        return;
    }

    // Truy vấn thông tin bài viết
    $sql = "SELECT bv.*, dm.tendanhmuc_baiviet AS ten_danh_muc
            FROM tbl_baiviet bv
            LEFT JOIN tbl_danhmuc_baiviet dm ON bv.id_danhmuc = dm.id_baiviet
            WHERE bv.id = $id
            LIMIT 1";
    $result = mysqli_query($mysqli, $sql);
    if (!$result || mysqli_num_rows($result) === 0) {
        echo '<div class="alert alert-warning m-3">Không tìm thấy bài viết.</div>';
        return;
    }
    $bv = mysqli_fetch_assoc($result);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

    /* Custom button styles */
    .btn-group .btn {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .btn-group .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border-color: #6c757d;
        color: #fff;
    }

    .btn-group .btn-secondary:hover {
        background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        border-color: #495057;
        color: #fff;
    }

    .btn-group .btn-warning {
        background: linear-gradient(135deg, #ffe300 0%, #ffd700 100%);
        border-color: #ffe300;
        color: #333;
    }

    .btn-group .btn-warning:hover {
        background: linear-gradient(135deg, #ffd700 0%, #ffe300 100%);
        border-color: #ffd700;
        color: #333;
    }

    .btn-group .btn i {
        font-size: 14px;
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

        .btn-group {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-group .btn {
            width: 100%;
            margin-bottom: 0;
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

        .btn-group .btn {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .btn-group .btn i {
            font-size: 12px;
        }

        /* Header responsive for mobile */
        .d-flex.justify-content-between {
            text-align: center;
        }
    }
</style>
<div class="container py-3">
<div class="d-flex justify-content-between align-items-center mb-3">
<!-- Header -->
<div class="d-flex justify-content-between align-items-center">
        <h3 class="text-7tcc mb-0 fw-bold">
            Chi tiết Bài Viết
        </h3>
    </div>
    <div class="btn-group" role="group">
            <a href="?action=quanLyBaiViet&query=lietke" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
            <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo (int)$bv['id']; ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit me-2"></i>Sửa</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height:320px;">
                    <?php if (!empty($bv['hinhanh'])): ?>
                        <img src="modules/quanLyBaiViet/uploads/<?php echo htmlspecialchars($bv['hinhanh']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($bv['tenbaiviet']); ?>">
                    <?php else: ?>
                        <div class="text-muted">Chưa có hình ảnh</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Tiêu đề</div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($bv['tenbaiviet']); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Danh mục</div>
                        <div class="col-sm-8"><?php echo htmlspecialchars(isset($bv['ten_danh_muc']) ? $bv['ten_danh_muc'] : ''); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Trạng thái</div>
                        <div class="col-sm-8"><?php echo ((int)$bv['tinhtrang'] === 1) ? 'Kích hoạt' : 'Ẩn'; ?></div>
                    </div>
                    <?php if (!empty($bv['link'])): ?>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Link</div>
                        <div class="col-sm-8"><a href="<?php echo htmlspecialchars($bv['link']); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($bv['link']); ?></a></div>
                    </div>
                    <?php endif; ?>
                    <div class="mb-2">
                        <div class="fw-semibold mb-1">Tóm tắt</div>
                        <div class="border rounded p-2" style="white-space:pre-wrap;"><?php echo htmlspecialchars(str_replace('\n', "\n", (string)$bv['tomtat'])); ?></div>
                    </div>
                    <div class="mb-2">
                        <div class="fw-semibold mb-1">Nội dung</div>
                        <div class="border rounded p-2" style="white-space:pre-wrap;"><?php echo htmlspecialchars(str_replace('\n', "\n", (string)$bv['noidung'])); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
