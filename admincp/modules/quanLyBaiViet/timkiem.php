<?php
include("config/config.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';

$where_clause = "WHERE tbl_baiviet.id_danhmuc = tbl_danhmucbaiviet.id_baiviet";

if (!empty($search)) {
    switch ($search_field) {
        case 'ten_baiviet':
            $where_clause .= " AND tbl_baiviet.ten_baiviet LIKE '%$search%'";
            break;
        case 'tomtat':
            $where_clause .= " AND tbl_baiviet.tomtat LIKE '%$search%'";
            break;
        case 'danhmuc':
            $where_clause .= " AND tbl_danhmucbaiviet.tendanhmuc_baiviet LIKE '%$search%'";
            break;
        case 'trang_thai':
            $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
            $where_clause .= " AND tbl_baiviet.tinhtrang = $status";
            break;
        default:
            $where_clause .= " AND (tbl_baiviet.ten_baiviet LIKE '%$search%' 
                            OR tbl_baiviet.tomtat LIKE '%$search%'
                            OR tbl_danhmucbaiviet.tendanhmuc_baiviet LIKE '%$search%')";
    }
}

$sql_lietke = "SELECT tbl_baiviet.*, tbl_danhmucbaiviet.tendanhmuc_baiviet 
               FROM tbl_baiviet 
               INNER JOIN tbl_danhmucbaiviet ON tbl_baiviet.id_danhmuc = tbl_danhmucbaiviet.id_baiviet 
               $where_clause 
               ORDER BY tbl_baiviet.id DESC";
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
                        <option value="ten_baiviet" <?php echo $search_field == 'ten_baiviet' ? 'selected' : ''; ?>>Tên bài viết</option>
                        <option value="tomtat" <?php echo $search_field == 'tomtat' ? 'selected' : ''; ?>>Tóm tắt</option>
                        <option value="danhmuc" <?php echo $search_field == 'danhmuc' ? 'selected' : ''; ?>>Danh mục</option>
                        <option value="trang_thai" <?php echo $search_field == 'trang_thai' ? 'selected' : ''; ?>>Trạng thái</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <?php if (!empty($search)): ?>
                    <div class="col-md-2">
                        <a href="index.php?action=quanLyBaiViet&query=them" class="btn btn-secondary w-100">Quay lại</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên bài viết</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Tóm tắt</th>
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
                        <td><?php echo $row['ten_baiviet'] ?></td>
                        <td>
                            <img src="modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" width="100px">
                        </td>
                        <td><?php echo $row['tendanhmuc_baiviet'] ?></td>
                        <td><?php echo $row['tomtat'] ?></td>
                        <td>
                            <?php if($row['tinhtrang'] == 1) { ?>
                                <span class="badge bg-success">Kích hoạt</span>
                            <?php } else { ?>
                                <span class="badge bg-warning">Ẩn</span>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="modules/quanLyBaiViet/xuly.php?idbaiviet=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                                <a href="?action=quanLyBaiViet&query=sua&idbaiviet=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Link Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 