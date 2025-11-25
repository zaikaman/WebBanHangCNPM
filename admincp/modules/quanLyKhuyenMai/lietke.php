<?php
// Include pagination class nếu chưa được include
if (!class_exists('Pagination')) {
    require_once('includes/pagination.php');
}

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;

// Tạo query với điều kiện search nếu có
$where_clause = "";
$search = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($mysqli, $_GET['search']);
    $where_clause = "WHERE ten_km LIKE '%$search%' OR mo_ta LIKE '%$search%'";
}

// Đếm tổng số bản ghi
$sql_count = "SELECT COUNT(*) as total FROM tbl_khuyenmai $where_clause";
$count_result = mysqli_query($mysqli, $sql_count);
$total_records = mysqli_fetch_array($count_result)['total'];

// Tạo pagination
$query_params = $_GET;
unset($query_params['page']);
$pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);

// Lấy danh sách khuyến mãi
$sql_lietke = "SELECT * FROM tbl_khuyenmai $where_clause ORDER BY id_km DESC LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
.text-7tcc { color: #dc0021 !important; }
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

.badge { font-size: 0.85em; padding: 0.35em 0.65em; }

.table-responsive::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 8px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
    border-radius: 8px;
}
</style>

<div class="container-fluid">
    <!-- Success/Error Messages -->
    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'add_success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <strong>Thành công!</strong> Thêm khuyến mãi mới thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['msg'] == 'update_success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <strong>Thành công!</strong> Cập nhật khuyến mãi thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['msg'] == 'delete_success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <strong>Thành công!</strong> Xóa khuyến mãi thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['msg'] == 'delete_error'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <strong>Lỗi!</strong> Không thể xóa khuyến mãi!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <h3 class="mb-0"><i class="fas fa-tags"></i> Quản Lý Khuyến Mãi</h3>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="?action=quanlykhuyenmai&query=them" class="btn btn-7tcc">
            <i class="fas fa-plus"></i> Thêm Khuyến Mãi
        </a>
    </div>

    <div class="form-section">
        <!-- Form tìm kiếm -->
        <form method="GET" action="" class="mb-3">
            <input type="hidden" name="action" value="quanlykhuyenmai">
            <input type="hidden" name="query" value="lietke">
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Tìm kiếm theo tên hoặc mô tả khuyến mãi..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-7tcc w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bảng danh sách -->
    <div class="form-section">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead style="background-color: #dc0021; color: white;">
                    <tr>
                        <th width="5%" class="text-center">ID</th>
                        <th width="22%">Tên khuyến mãi</th>
                        <th width="12%" class="text-center">Loại</th>
                        <th width="10%" class="text-center">Giá trị</th>
                        <th width="16%">Thời gian</th>
                        <th width="10%" class="text-center">Trạng thái</th>
                        <th width="10%" class="text-center">Sản phẩm</th>
                        <th width="15%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = $pagination->getOffset();
                    if (mysqli_num_rows($lietke) > 0) {
                        while ($row = mysqli_fetch_array($lietke)) {
                            $i++;
                            
                            // Đếm số sản phẩm áp dụng
                            $sql_count_sp = "SELECT COUNT(*) as total FROM tbl_sanpham_khuyenmai WHERE id_km = " . $row['id_km'];
                            $count_sp = mysqli_fetch_array(mysqli_query($mysqli, $sql_count_sp))['total'];
                            
                            // Format loại khuyến mãi
                            $badge_class = '';
                            $loai_icon = '';
                            switch($row['loai_km']) {
                                case 'phan_tram':
                                    $badge_class = 'bg-success';
                                    $loai_icon = '<i class="fas fa-percent"></i>';
                                    $loai_text = 'Giảm %';
                                    $gia_tri = $row['gia_tri_km'] . '%';
                                    break;
                                case 'tien_mat':
                                    $badge_class = 'bg-primary';
                                    $loai_icon = '<i class="fas fa-money-bill-wave"></i>';
                                    $loai_text = 'Giảm tiền';
                                    $gia_tri = number_format($row['gia_tri_km'], 0, ',', '.') . 'đ';
                                    break;
                                case 'gia_moi':
                                    $badge_class = 'bg-warning text-dark';
                                    $loai_icon = '<i class="fas fa-tag"></i>';
                                    $loai_text = 'Giá mới';
                                    $gia_tri = number_format($row['gia_tri_km'], 0, ',', '.') . 'đ';
                                    break;
                            }
                            
                            // Kiểm tra trạng thái
                            $now = date('Y-m-d H:i:s');
                            $is_active = ($row['trang_thai'] == 1 && 
                                         $now >= $row['ngay_bat_dau'] && 
                                         $now <= $row['ngay_ket_thuc']);
                            
                            $status_badge = $is_active 
                                ? '<span class="badge bg-success rounded-pill"><i class="fas fa-check-circle"></i> Hoạt động</span>' 
                                : '<span class="badge bg-secondary rounded-pill"><i class="fas fa-pause-circle"></i> Tạm dừng</span>';
                        ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo $i; ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['ten_km']); ?></div>
                                <small class="text-muted d-block mt-1"><?php echo htmlspecialchars(substr($row['mo_ta'], 0, 70)); ?>...</small>
                            </td>
                            <td class="text-center">
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $loai_icon . ' ' . $loai_text; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <strong class="text-danger" style="font-size: 1.1em;"><?php echo $gia_tri; ?></strong>
                            </td>
                            <td>
                                <small class="d-block">
                                    <i class="fas fa-play-circle text-success"></i> <?php echo date('d/m/Y H:i', strtotime($row['ngay_bat_dau'])); ?>
                                </small>
                                <small class="d-block mt-1">
                                    <i class="fas fa-stop-circle text-danger"></i> <?php echo date('d/m/Y H:i', strtotime($row['ngay_ket_thuc'])); ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <?php echo $status_badge; ?>
                            </td>
                            <td class="text-center">
                                <a href="?action=quanlykhuyenmai&query=sanpham&id=<?php echo $row['id_km']; ?>" 
                                   class="btn btn-sm btn-outline-info" title="Quản lý sản phẩm">
                                    <i class="fas fa-box"></i> <?php echo $count_sp; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="?action=quanlykhuyenmai&query=sua&id=<?php echo $row['id_km']; ?>" 
                                       class="btn btn-sm btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="modules/quanLyKhuyenMai/xuly.php?id=<?php echo $row['id_km']; ?>" 
                                       onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này?')" 
                                       class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                        }
                    } else {
                        echo '<tr><td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Không có khuyến mãi nào!</p>
                              </td></tr>';
                    }
                    ?>
                </tbody>
                </table>
            </div>

        </div>
        
        <!-- Phân trang -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="text-muted">
                <i class="fas fa-list"></i> Hiển thị <strong><?php echo $pagination->getOffset() + 1; ?></strong> 
                đến <strong><?php echo min($pagination->getOffset() + $records_per_page, $total_records); ?></strong> 
                trong tổng số <strong><?php echo $total_records; ?></strong> bản ghi
            </div>
            <nav>
                <?php echo $pagination->render(); ?>
            </nav>
        </div>
    </div>
</div>

<style>
.badge {
    font-size: 0.85em;
    padding: 0.4em 0.7em;
    font-weight: 500;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.table > :not(caption) > * > * {
    padding: 0.75rem 0.5rem;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

// Remove msg parameter from URL after showing alert
if (window.location.search.includes('msg=')) {
    const url = new URL(window.location);
    url.searchParams.delete('msg');
    window.history.replaceState({}, '', url);
}
</script>