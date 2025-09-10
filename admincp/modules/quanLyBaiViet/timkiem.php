<?php
include("config/config.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';

$where_clause = "WHERE tbl_baiviet.id_danhmuc=tbl_danhmuc_baiviet.id_baiviet";
if (!empty($search)) {
    switch ($search_field) {
        case 'tenbaiviet':
            $where_clause .= " AND tbl_baiviet.tenbaiviet LIKE '%$search%'";
            break;
        case 'noidung':
            $where_clause .= " AND tbl_baiviet.noidung LIKE '%$search%'";
            break;
        case 'tinhtrang':
            $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
            $where_clause .= " AND tbl_baiviet.tinhtrang = $status";
            break;
        default:
            $where_clause .= " AND (tbl_baiviet.tenbaiviet LIKE '%$search%' 
                            OR tbl_baiviet.noidung LIKE '%$search%' 
                            OR tbl_baiviet.tomtat LIKE '%$search%')";
    }
}

$sql_lietke = "SELECT * FROM tbl_baiviet,tbl_danhmuc_baiviet $where_clause ORDER BY id DESC";
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-override.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Kết Quả Tìm Kiếm Bài Viết</h3>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php">
                <input type="hidden" name="action" value="quanLyBaiViet">
                <input type="hidden" name="query" value="timkiem">
                
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-4">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="tenbaiviet" <?php echo $search_field == 'tenbaiviet' ? 'selected' : ''; ?>>Tên bài viết</option>
                        <option value="noidung" <?php echo $search_field == 'noidung' ? 'selected' : ''; ?>>Nội dung</option>
                        <option value="tinhtrang" <?php echo $search_field == 'tinhtrang' ? 'selected' : ''; ?>>Trạng thái</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <div class="col-md-2">
                    <a href="index.php?action=quanLyBaiViet&query=lietke" class="btn btn-secondary w-100">
                        <i class="fas fa-list"></i> Xem tất cả
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($search)): ?>
    <div class="alert alert-info">
        Kết quả tìm kiếm cho: <strong><?php echo htmlspecialchars($search); ?></strong>
        <?php if ($search_field != 'all'): ?>
            trong <strong><?php echo htmlspecialchars($search_field); ?></strong>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên bài viết</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Tóm tắt</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($lietke)) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['tenbaiviet'] ?></td>
                        <td><img src="modules/quanLybaiviet/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
                        <td><?php echo $row['id_danhmuc'] ?></td>
                        <td>
                            <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['tomtat']) ?></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['noidung']) ?></textarea>
                        </td>
                        <td>
                            <?php if($row['tinhtrang'] == 1) { ?>
                                <span class="badge bg-success">Kích hoạt</span>
                            <?php } else { ?>
                                <span class="badge bg-warning">Ẩn</span>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                                <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                if ($i == 0) {
                    echo '<tr><td colspan="8" class="text-center">Không tìm thấy kết quả nào</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 