<?php
    // Kết nối config
    if (file_exists("../../config/config.php")) {
        include("../../config/config.php");
    } else {
        include("config/config.php");
    }

    // Lấy id sản phẩm an toàn
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id <= 0) {
        echo '<div class="alert alert-danger m-3">ID sản phẩm không hợp lệ.</div>';
        return;
    }

    // Truy vấn thông tin sản phẩm
    $sql = "SELECT sp.*, dm.name_sp AS ten_danh_muc
            FROM tbl_sanpham sp
            LEFT JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm
            WHERE sp.id_sp = $id
            LIMIT 1";
    $result = mysqli_query($mysqli, $sql);
    if (!$result || mysqli_num_rows($result) === 0) {
        echo '<div class="alert alert-warning m-3">Không tìm thấy sản phẩm.</div>';
        return;
    }
    $sp = mysqli_fetch_assoc($result);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Chi tiết sản phẩm</h4>
        <div>
            <a href="?action=quanLySanPham&query=lietke" class="btn btn-secondary btn-sm">Quay lại</a>
            <a href="?action=quanLySanPham&query=sua&idsp=<?php echo urlencode($sp['ma_sp']); ?>" class="btn btn-warning btn-sm">Sửa</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height:320px;">
                    <?php if (!empty($sp['hinh_anh'])): ?>
                        <img src="modules/quanLySanPham/uploads/<?php echo htmlspecialchars($sp['hinh_anh']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($sp['ten_sp']); ?>">
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
                        <div class="col-sm-4 fw-semibold">Tên sản phẩm</div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($sp['ten_sp']); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Mã sản phẩm</div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($sp['ma_sp']); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Danh mục</div>
                        <div class="col-sm-8"><?php echo htmlspecialchars(isset($sp['ten_danh_muc']) ? $sp['ten_danh_muc'] : ''); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Giá</div>
                        <div class="col-sm-8 text-danger"><?php echo number_format((float)$sp['gia_sp'], 0, ',', '.'); ?> VND</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Số lượng</div>
                        <div class="col-sm-8"><?php echo (int)$sp['so_luong']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Còn lại</div>
                        <div class="col-sm-8"><?php echo (int)$sp['so_luong_con_lai']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Trạng thái</div>
                        <div class="col-sm-8"><?php echo ((int)$sp['tinh_trang'] === 1) ? 'Kích hoạt' : 'Ẩn'; ?></div>
                    </div>
                    <div class="mb-2">
                        <div class="fw-semibold mb-1">Tóm tắt</div>
                        <div class="border rounded p-2" style="white-space:pre-wrap;"><?php echo htmlspecialchars(str_replace('\n', "\n", (string)$sp['tom_tat'])); ?></div>
                    </div>
                    <div class="mb-2">
                        <div class="fw-semibold mb-1">Nội dung</div>
                        <div class="border rounded p-2" style="white-space:pre-wrap;"><?php echo htmlspecialchars(str_replace('\n', "\n", (string)$sp['noi_dung'])); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
