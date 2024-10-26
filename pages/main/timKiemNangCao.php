<?php
// Include database configuration to initialize $mysqli
include(dirname(__FILE__) . "/../../admincp/config/config.php");

// Handle form data and sanitize inputs
$ten_sp_filter = isset($_GET['ten_sp']) ? $_GET['ten_sp'] : '';
$danhmuc_filter = isset($_GET['danhmuc']) ? $_GET['danhmuc'] : '';
$gia_min_filter = isset($_GET['gia_min']) ? $_GET['gia_min'] : '';
$gia_max_filter = isset($_GET['gia_max']) ? $_GET['gia_max'] : '';
$tinh_trang_filter = isset($_GET['tinhtrang']) ? $_GET['tinhtrang'] : '';

// Construct query based on filters
$sql_pro = "SELECT * FROM tbl_sanpham WHERE 1";

if ($ten_sp_filter) {
    $sql_pro .= " AND ten_sp LIKE '%" . mysqli_real_escape_string($mysqli, $ten_sp_filter) . "%'";
}

if ($danhmuc_filter) {
    $sql_pro .= " AND id_dm = " . intval($danhmuc_filter);
}

if ($gia_min_filter && $gia_max_filter) {
    $sql_pro .= " AND gia_sp BETWEEN " . intval($gia_min_filter) . " AND " . intval($gia_max_filter);
} elseif ($gia_min_filter) {
    $sql_pro .= " AND gia_sp >= " . intval($gia_min_filter);
} elseif ($gia_max_filter) {
    $sql_pro .= " AND gia_sp <= " . intval($gia_max_filter);
}

if ($tinh_trang_filter !== '') {
    $sql_pro .= " AND tinh_trang = " . intval($tinh_trang_filter);
}

$query_pro = mysqli_query($mysqli, $sql_pro);
?>

<div class="main_with_sidebar">
    <?php include("./pages/sidebar/sidebar.php"); ?>
    <div class="main_content main_content_with_sidebar">
        <div class="cate_title">
            <h3>Kết quả tìm kiếm :</h3>
        </div>
        <div class="container mt-3">
            <div class="row">
                <?php
                while ($row = mysqli_fetch_array($query_pro)) {
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product card h-100">
                            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp'] ?>" class="text-decoration-none text-dark">
                                <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                <div class="card-body text-center">
                                    <p class="title_product card-title"><?php echo $row['ten_sp'] ?></p>
                                    <p class="price_product card-text text-danger"><?php echo number_format($row['gia_sp'], 0, ',', ',') . 'vnđ' ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Filter form section with input validation -->
<div class="filter-section">
    <label for="gia_min">Giá tối thiểu:</label>
    <input type="number" id="gia_min" name="gia_min" min="0" oninput="validatePriceInput()" placeholder="0">
    <label for="gia_max">Giá tối đa:</label>
    <input type="number" id="gia_max" name="gia_max" min="0" oninput="validatePriceInput()" placeholder="0">
</div>

<script>
    function validatePriceInput() {
        const giaMin = document.getElementById('gia_min');
        const giaMax = document.getElementById('gia_max');

        // Giá trị hiện tại của các ô nhập
        const minValue = parseInt(giaMin.value, 10);
        const maxValue = parseInt(giaMax.value, 10);

        // Kiểm tra nhập số âm
        if (minValue < 0) {
            giaMin.value = '';
        }
        if (maxValue < 0) {
            giaMax.value = '';
        }

        // Kiểm tra điều kiện min <= max
        if (minValue && maxValue && minValue > maxValue) {
            giaMax.value = ''; // Xóa giá trị không hợp lệ của ô giá tối đa
        }
    }
</script>
