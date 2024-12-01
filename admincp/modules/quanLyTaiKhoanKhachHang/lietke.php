<?php
	include("config/config.php");
    
    // Xử lý tìm kiếm
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
    
    $where_clause = "WHERE 1=1";
    if (!empty($search)) {
        switch ($search_field) {
            case 'ten_khachhang':
                $where_clause .= " AND ten_khachhang LIKE '%$search%'";
                break;
            case 'dien_thoai':
                $where_clause .= " AND dien_thoai LIKE '%$search%'";
                break;
            case 'email':
                $where_clause .= " AND email LIKE '%$search%'";
                break;
            case 'dia_chi':
                $where_clause .= " AND dia_chi LIKE '%$search%'";
                break;
            default:
                $where_clause .= " AND (ten_khachhang LIKE '%$search%' 
                                OR dien_thoai LIKE '%$search%'
                                OR email LIKE '%$search%'
                                OR dia_chi LIKE '%$search%')";
        }
    }
    
    $sql_lietke_khachhang = "SELECT * FROM tbl_dangky $where_clause ORDER BY id_dangky DESC";
    $lietke_khachhang = mysqli_query($mysqli, $sql_lietke_khachhang);
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h3 class="text-center mb-4">Liệt kê khách hàng</h3>

    <!-- Form Tìm Kiếm -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET" action="">
                <input type="hidden" name="action" value="quanLyTaiKhoanKhachHang">
                <input type="hidden" name="query" value="lietke">
                
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-3">
                    <select name="search_field" class="form-select">
                        <option value="all" <?php echo $search_field == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="ten_khachhang" <?php echo $search_field == 'ten_khachhang' ? 'selected' : ''; ?>>Tên khách hàng</option>
                        <option value="dien_thoai" <?php echo $search_field == 'dien_thoai' ? 'selected' : ''; ?>>Số điện thoại</option>
                        <option value="email" <?php echo $search_field == 'email' ? 'selected' : ''; ?>>Email</option>
                        <option value="dia_chi" <?php echo $search_field == 'dia_chi' ? 'selected' : ''; ?>>Địa chỉ</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Tìm</button>
                </div>

                <?php if (!empty($search)): ?>
                    <div class="col-md-12 mt-2">
                        <a href="?action=quanLyTaiKhoanKhachHang&query=lietke" class="btn btn-secondary">Xóa tìm kiếm</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <td >ID Khách hàng</td>
                <td >Tên khách hàng</td>
                <td >Địa chỉ</td>
                <td >Số điện thoại</td>
                <td >Email</td>
                <!-- <td >Trạng thái</td>              -->
                <td >Quản Lý</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($lietke_khachhang)) {
            ?>
            <tr>
                <td><?php echo $row['id_dangky']; ?></td>
                <td><?php echo $row['ten_khachhang']; ?></td>
                <td><?php echo $row['dia_chi']; ?></td>
                <td><?php echo $row['dien_thoai']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <!-- <td>
                        <?php
                        // if ($row['trang_thai'] == 1) {
                        //     echo "Đang kích hoạt";
                        // } elseif ($row['trang_thai'] == 0){
                        //     echo "Chưa kích hoạt";
                        // }else{
                        //     echo "Đã bị cấm!";
                        // }
                        ?>
                    </td> -->
                <td>
                    <a href="modules/quanLyTaiKhoanKhachHang/xuly.php?id=<?php echo $row['id_dangky']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>