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

<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Chi tiết bài viết</h4>
        <div>
            <a href="?action=quanLyBaiViet&query=lietke" class="btn btn-secondary btn-sm">Quay lại</a>
            <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo (int)$bv['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
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
