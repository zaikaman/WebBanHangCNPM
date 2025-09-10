<?php
    include("config/config.php");
    include("includes/pagination.php");
    
    // Xử lý tham số phân trang
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
    
    // Xử lý tìm kiếm
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
    
    // Xây dựng WHERE clause cho tìm kiếm
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
    
    // Đếm tổng số bản ghi
    $sql_count = "SELECT COUNT(*) as total FROM tbl_baiviet,tbl_danhmuc_baiviet $where_clause";
    $count_result = mysqli_query($mysqli, $sql_count);
    $total_records = mysqli_fetch_array($count_result)['total'];
    
    // Tạo pagination object
    $query_params = $_GET;
    unset($query_params['page']); // Loại bỏ page khỏi query params
    $pagination = new Pagination($current_page, $total_records, $records_per_page, $query_params);
    
    // Query với LIMIT và OFFSET
    $sql_lietke = "SELECT * FROM tbl_baiviet,tbl_danhmuc_baiviet 
                   $where_clause 
                   ORDER BY id DESC 
                   LIMIT " . $pagination->getLimit() . " OFFSET " . $pagination->getOffset();
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Bài Viết</h3>
    
    <!-- Page Size Selector -->
    <?php echo $pagination->renderPageSizeSelector(); ?>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="index.php" id="searchForm">
                <input type="hidden" name="action" value="quanLyBaiViet">
                <input type="hidden" name="query" value="lietke">
                <input type="hidden" name="per_page" value="<?php echo $records_per_page; ?>">
                
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-4">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo ($search_field == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="tenbaiviet" <?php echo ($search_field == 'tenbaiviet') ? 'selected' : ''; ?>>Tên bài viết</option>
                        <option value="noidung" <?php echo ($search_field == 'noidung') ? 'selected' : ''; ?>>Nội dung</option>
                        <option value="tinhtrang" <?php echo ($search_field == 'tinhtrang') ? 'selected' : ''; ?>>Trạng thái</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
                
                <div class="col-md-2">
                    <a href="index.php?action=quanLyBaiViet&query=lietke" class="btn btn-secondary w-100">
                        <i class="fas fa-refresh"></i> Làm mới
                    </a>
                </div>
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
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $start_number = $pagination->getOffset();
                $i = $start_number;
                while ($row = mysqli_fetch_array($lietke)) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['tenbaiviet'] ?></td>
                        <td><img src="modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
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
                                <a href="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                                <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php echo $pagination->render(); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
