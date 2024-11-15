<?php
// Include database configuration to initialize $mysqli
include(dirname(__FILE__) . "/../../admincp/config/config.php");

// Handle form data and sanitize inputs
$ten_sp_filter = isset($_GET['ten_sp']) ? urldecode($_GET['ten_sp']) : '';

$danhmuc_filter = isset($_GET['danhmuc']) ? $_GET['danhmuc'] : '';
$gia_min_filter = isset($_GET['gia_min']) ? $_GET['gia_min'] : '';
$gia_max_filter = isset($_GET['gia_max']) ? $_GET['gia_max'] : '';
$tinh_trang_filter = isset($_GET['tinhtrang']) ? $_GET['tinhtrang'] : '';

// Initialize an empty error message
$error_message = '';

// Sanitize and validate gia_min and gia_max inputs
$gia_min_filter = isset($_GET['gia_min']) && $_GET['gia_min'] !== '' ? intval($_GET['gia_min']) : null;
$gia_max_filter = isset($_GET['gia_max']) && $_GET['gia_max'] !== '' ? intval($_GET['gia_max']) : null;

// Validate price inputs
if (($gia_min_filter !== null && $gia_min_filter < 0) || ($gia_max_filter !== null && $gia_max_filter < 0)) {
    $error_message = "Vui lòng nhập giá trị dương";
} elseif ($gia_min_filter !== null && $gia_max_filter !== null && $gia_min_filter > $gia_max_filter) {
    $error_message = "Vui lòng nhập giá đến lớn hơn hoặc bằng giá từ";
}

// Only construct the query and perform the search if there are no errors
if (empty($error_message)) {
    // Construct query based on filters
    $sql_pro = "SELECT * FROM tbl_sanpham WHERE 1";

    if ($ten_sp_filter) {
        $search_term = mysqli_real_escape_string($mysqli, trim($ten_sp_filter));
        $sql_pro .= " AND ten_sp LIKE '%" . $search_term . "%'";
    }

    if ($danhmuc_filter) {
        $sql_pro .= " AND id_dm = " . intval($danhmuc_filter);
    }

    // Only add price filters if they are set
    if ($gia_min_filter !== null && $gia_max_filter !== null) {
        $sql_pro .= " AND gia_sp BETWEEN $gia_min_filter AND $gia_max_filter";
    } elseif ($gia_min_filter !== null) {
        $sql_pro .= " AND gia_sp >= $gia_min_filter";
    } elseif ($gia_max_filter !== null) {
        $sql_pro .= " AND gia_sp <= $gia_max_filter";
    }

    if ($tinh_trang_filter !== '') {
        $sql_pro .= " AND tinh_trang = " . intval($tinh_trang_filter);
    }

    $query_pro = mysqli_query($mysqli, $sql_pro);
}
?>

<div class="main_with_sidebar">
    <?php include("./pages/sidebar/sidebar.php"); ?>
    <div class="main_content main_content_with_sidebar">
        <div class="cate_title">
            <h3>Kết quả tìm kiếm :</h3>
        </div>
        <div class="container mt-3">
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php else: ?>
                <div class="row">
                    <?php while ($row = mysqli_fetch_array($query_pro)): ?>
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
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
