<?php
include("config/config.php");

// API endpoint cho Ajax
if(isset($_GET['ajax_search'])) {
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

    // Trả về HTML cho bảng
    ob_start();
    while ($row = mysqli_fetch_array($lietke_khachhang)) {
    ?>
    <tr>
        <td><?php echo $row['id_dangky']; ?></td>
        <td><?php echo $row['ten_khachhang']; ?></td>
        <td><?php echo $row['dia_chi']; ?></td>
        <td><?php echo $row['dien_thoai']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td>
            <a href="modules/quanLyTaiKhoanKhachHang/xuly.php?id=<?php echo $row['id_dangky']; ?>" class="btn btn-danger btn-sm">Xóa</a>
        </td>
    </tr>
    <?php
    }
    echo ob_get_clean();
    exit;
}

$sql_lietke_khachhang = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
$lietke_khachhang = mysqli_query($mysqli, $sql_lietke_khachhang);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-5">
    <h3 class="text-center mb-4">Liệt kê khách hàng</h3>

    <!-- Form Tìm Kiếm -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" id="searchForm">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm...">
                </div>
                
                <div class="col-md-3">
                    <select name="search_field" class="form-select">
                        <option value="all">Tất cả</option>
                        <option value="ten_khachhang">Tên khách hàng</option>
                        <option value="dien_thoai">Số điện thoại</option>
                        <option value="email">Email</option>
                        <option value="dia_chi">Địa chỉ</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Tìm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <td>ID Khách hàng</td>
                    <td>Tên khách hàng</td>
                    <td>Địa chỉ</td>
                    <td>Số điện thoại</td>
                    <td>Email</td>
                    <td>Quản Lý</td>
                </tr>
            </thead>
            <tbody id="customerTableBody">
                <?php
                while ($row = mysqli_fetch_array($lietke_khachhang)) {
                ?>
                <tr>
                    <td><?php echo $row['id_dangky']; ?></td>
                    <td><?php echo $row['ten_khachhang']; ?></td>
                    <td><?php echo $row['dia_chi']; ?></td>
                    <td><?php echo $row['dien_thoai']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="modules/quanLyTaiKhoanKhachHang/xuly.php?id=<?php echo $row['id_dangky']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    function performSearch() {
        var formData = $('#searchForm').serialize();
        
        $.ajax({
            url: 'modules/quanLyTaiKhoanKhachHang/lietke.php?ajax_search=1',
            type: 'GET',
            data: formData,
            success: function(response) {
                $('#customerTableBody').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Xử lý submit form
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Tự động tìm kiếm khi thay đổi select
    $('#searchForm select').on('change', function() {
        performSearch();
    });

    // Tự động tìm kiếm khi gõ
    var searchTimeout;
    $('#searchForm input[type="text"]').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performSearch();
        }, 300); // Đợi 300ms sau khi người dùng ngừng gõ
    });
});
</script>