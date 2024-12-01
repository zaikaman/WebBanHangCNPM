<?php
	include("config/config.php");
    
    // Search functionality
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
    $price_min = isset($_GET['price_min']) ? floatval($_GET['price_min']) : '';
    $price_max = isset($_GET['price_max']) ? floatval($_GET['price_max']) : '';
    
    $where_clause = "";
    if (!empty($search) || !empty($price_min) || !empty($price_max)) {
        $where_clause = "AND (1=1";
        
        if (!empty($search)) {
            switch ($search_field) {
                case 'ten_sp':
                    $where_clause .= " AND tbl_sanpham.ten_sp LIKE '%$search%'";
                    break;
                case 'ma_sp':
                    $where_clause .= " AND tbl_sanpham.ma_sp LIKE '%$search%'";
                    break;
                case 'tinh_trang':
                    $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                    $where_clause .= " AND tbl_sanpham.tinh_trang = $status";
                    break;
                default:
                    $where_clause .= " AND (tbl_sanpham.ten_sp LIKE '%$search%' 
                                    OR tbl_sanpham.ma_sp LIKE '%$search%' 
                                    OR tbl_sanpham.noi_dung LIKE '%$search%'
                                    OR tbl_sanpham.tom_tat LIKE '%$search%')";
            }
        }
        
        if (!empty($price_min)) {
            $where_clause .= " AND tbl_sanpham.gia_sp >= $price_min";
        }
        if (!empty($price_max)) {
            $where_clause .= " AND tbl_sanpham.gia_sp <= $price_max";
        }
        
        $where_clause .= ")";
    }
    
	$sql_lietke = "SELECT * FROM tbl_sanpham, tbl_danhmucqa 
                   WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm 
                   $where_clause 
                   ORDER BY id_sp DESC";
	$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center">Liệt Kê Sản Phẩm</h3>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="">
                <input type="hidden" name="action" value="quanLySanPham">
                <input type="hidden" name="query" value="lietke">
                
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-2">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="ten_sp" <?php echo $search_field == 'ten_sp' ? 'selected' : ''; ?>>Tên sản phẩm</option>
                        <option value="ma_sp" <?php echo $search_field == 'ma_sp' ? 'selected' : ''; ?>>Mã sản phẩm</option>
                        <option value="tinh_trang" <?php echo $search_field == 'tinh_trang' ? 'selected' : ''; ?>>Trạng thái</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <input type="number" name="price_min" class="form-control" placeholder="Giá tối thiểu" value="<?php echo $price_min; ?>">
                </div>
                
                <div class="col-md-2">
                    <input type="number" name="price_max" class="form-control" placeholder="Giá tối đa" value="<?php echo $price_max; ?>">
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
                
                <?php if (!empty($search) || !empty($price_min) || !empty($price_max)): ?>
                    <div class="col-md-12 mt-2">
                        <a href="?action=quanLySanPham&query=lietke" class="btn btn-secondary">Xóa tìm kiếm</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-striped table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Tên Sản Phẩm</th>
                <th>Hình Ảnh</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Còn lại</th>
                <th>Danh Mục</th>
                <th>Mã SP</th>
                <th>Nội Dung</th>
                <th>Tóm Tắt</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
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
                    <td><?php echo $row['ten_sp'] ?></td>
                    <td><img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" width="100px"></td>
                    <td><?php echo number_format($row['gia_sp'], 0, ',', '.').' VND' ?></td>
                    <td><?php echo $row['so_luong'] ?></td>
                    <td><?php echo $row['so_luong_con_lai'] ?></td>
                    <td><?php echo $row['name_sp'] ?></td>
                    <td><?php echo $row['ma_sp'] ?></td>
                    <td>
                         <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['noi_dung']) ?></textarea>
                    </td>
                    <td>
                        <textarea class="form-control" rows="3" readonly><?php echo str_replace('\n', "\n", $row['tom_tat']) ?></textarea>
                    </td>
                    <td><?php echo ($row['tinh_trang'] == 1) ? 'Kích hoạt' : 'Ẩn' ?></td>
                    <td>
                        <a href="modules/quanLySanPham/xuly.php?idsp=<?php echo $row['ma_sp'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                        <a href="?action=quanLySanPham&query=sua&idsp=<?php echo $row['ma_sp'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Link Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
