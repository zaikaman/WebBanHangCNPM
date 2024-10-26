<?php
// Include database configuration to initialize $mysqli
include(dirname(__FILE__) . "/../../admincp/config/config.php");

// Handle form data and sanitize inputs
$ten_sp_filter = isset($_GET['ten_sp']) ? $_GET['ten_sp'] : '';
$danhmuc_filter = isset($_GET['danhmuc']) ? $_GET['danhmuc'] : '';
$gia_min_filter = isset($_GET['gia_min']) ? max(0, intval($_GET['gia_min'])) : '';
$gia_max_filter = isset($_GET['gia_max']) ? max(0, intval($_GET['gia_max'])) : '';
$tinh_trang_filter = isset($_GET['tinhtrang']) ? $_GET['tinhtrang'] : '';

// Ensure gia_min <= gia_max if both are set
if ($gia_min_filter !== '' && $gia_max_filter !== '' && $gia_min_filter > $gia_max_filter) {
    // Swap values if minimum is greater than maximum
    $temp = $gia_min_filter;
    $gia_min_filter = $gia_max_filter;
    $gia_max_filter = $temp;
}

// Construct query based on filters
$sql_pro = "SELECT * FROM tbl_sanpham WHERE 1";

if ($ten_sp_filter) {
    $sql_pro .= " AND ten_sp LIKE '%" . mysqli_real_escape_string($mysqli, $ten_sp_filter) . "%'";
}

if ($danhmuc_filter) {
    $sql_pro .= " AND id_dm = " . intval($danhmuc_filter);
}

if ($gia_min_filter !== '' && $gia_max_filter !== '') {
    $sql_pro .= " AND gia_sp BETWEEN " . $gia_min_filter . " AND " . $gia_max_filter;
} elseif ($gia_min_filter !== '') {
    $sql_pro .= " AND gia_sp >= " . $gia_min_filter;
} elseif ($gia_max_filter !== '') {
    $sql_pro .= " AND gia_sp <= " . $gia_max_filter;
}

if ($tinh_trang_filter !== '') {
    $sql_pro .= " AND tinh_trang = " . intval($tinh_trang_filter);
}

$query_pro = mysqli_query($mysqli, $sql_pro);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm sản phẩm</title>
</head>
<body>
    <form id="filterForm" method="GET" action="">
        <input type="text" name="ten_sp" placeholder="Tên sản phẩm" value="<?php echo htmlspecialchars($ten_sp_filter); ?>">
        <select name="danhmuc">
            <option value="">Chọn danh mục</option>
            <!-- Options for danh mục -->
            <option value="1" <?php echo $danhmuc_filter == '1' ? 'selected' : ''; ?>>Danh mục 1</option>
            <option value="2" <?php echo $danhmuc_filter == '2' ? 'selected' : ''; ?>>Danh mục 2</option>
            <!-- Add more categories as needed -->
        </select>
        <input type="number" name="gia_min" id="gia_min" placeholder="Giá tối thiểu" min="0" value="<?php echo htmlspecialchars($gia_min_filter); ?>" oninput="validatePriceRange()">
        <input type="number" name="gia_max" id="gia_max" placeholder="Giá tối đa" min="0" value="<?php echo htmlspecialchars($gia_max_filter); ?>" oninput="validatePriceRange()">
        <select name="tinhtrang">
            <option value="">Tất cả tình trạng</option>
            <option value="1" <?php echo $tinh_trang_filter === '1' ? 'selected' : ''; ?>>Mới</option>
            <option value="0" <?php echo $tinh_trang_filter === '0' ? 'selected' : ''; ?>>Cũ</option>
        </select>
        <button type="submit">Lọc</button>
    </form>

    <script>
        function validatePriceRange() {
            const minPrice = document.getElementById('gia_min');
            const maxPrice = document.getElementById('gia_max');

            // Kiểm tra giá trị âm
            if (minPrice.value < 0) minPrice.value = 0;
            if (maxPrice.value < 0) maxPrice.value = 0;

            // Kiểm tra gia_min không lớn hơn gia_max
            if (parseInt(minPrice.value) > parseInt(maxPrice.value)) {
                maxPrice.setCustomValidity("Giá tối đa phải lớn hơn hoặc bằng giá tối thiểu.");
            } else {
                maxPrice.setCustomValidity("");
            }
        }
    </script>

    <div class="main_with_sidebar">
        <?php include("./pages/sidebar/sidebar.php"); ?>
        <div class="main_content main_content_with_sidebar ">
            <div class="cate_title">
                <h3>Kết quả tìm kiếm :</h3>
            </div>
            <div class="container mt-3">
                <div class="row">
                    <?php while ($row = mysqli_fetch_array($query_pro)) { ?>
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
