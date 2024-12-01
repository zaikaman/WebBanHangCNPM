<?php
	include("config/config.php");
    
    // Search functionality
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
    
    $where_clause = "";
    if (!empty($search)) {
        switch ($search_field) {
            case 'tenbaiviet':
                $where_clause = "AND tbl_baiviet.tenbaiviet LIKE '%$search%'";
                break;
            case 'noidung':
                $where_clause = "AND tbl_baiviet.noidung LIKE '%$search%'";
                break;
            case 'tinhtrang':
                $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                $where_clause = "AND tbl_baiviet.tinhtrang = $status";
                break;
            default:
                $where_clause = "AND (tbl_baiviet.tenbaiviet LIKE '%$search%' 
                                OR tbl_baiviet.noidung LIKE '%$search%' 
                                OR tbl_baiviet.tomtat LIKE '%$search%')";
        }
    }
    
    $sql_lietke = "SELECT * FROM tbl_baiviet,tbl_danhmuc_baiviet 
                   WHERE tbl_baiviet.id_danhmuc=tbl_danhmuc_baiviet.id_baiviet 
                   $where_clause 
                   ORDER BY id DESC";
    $lietke = mysqli_query($mysqli, $sql_lietke);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Bài Viết</h3>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="d-flex gap-2" method="GET" action="">
                <input type="hidden" name="action" value="quanLyBaiViet">
                <input type="hidden" name="query" value="lietke">
                <div class="flex-grow-1">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div>
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="tenbaiviet" <?php echo $search_field == 'tenbaiviet' ? 'selected' : ''; ?>>Tên bài viết</option>
                        <option value="noidung" <?php echo $search_field == 'noidung' ? 'selected' : ''; ?>>Nội dung</option>
                        <option value="tinhtrang" <?php echo $search_field == 'tinhtrang' ? 'selected' : ''; ?>>Trạng thái</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <?php if (!empty($search)): ?>
                    <a href="?action=quanLyBaiViet&query=lietke" class="btn btn-secondary">Xóa tìm kiếm</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Bài Viết</th>
                <th scope="col">Hình Ảnh</th>
                <th scope="col">Mã Danh Mục</th>
                <th scope="col">Tóm Tắt</th>
                <th scope="col">Nội Dung</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Quản Lý</th>
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
                         <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['noidung']) ?></textarea>
                    </td>
                    <td>
                        <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['tomtat']) ?></textarea>
                    </td>
                <td><?php echo ($row['tinhtrang'] == 1) ? 'Kích hoạt' : 'Ẩn'; ?></td>
                <td>
                    <a href="modules/quanLyBaiViet/xuly.php?idbv=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                    <a href="?action=quanLyBaiViet&query=sua&idbv=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>