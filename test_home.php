<?php
// Test file để debug trang chủ
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'admincp/config/config.php';
require_once 'includes/promotion_helper.php';

echo "<h1>Testing Homepage Queries</h1>";

// Test query 1: Featured products
echo "<h2>1. Featured Products Query</h2>";
$sql_featured = "SELECT tbl_sanpham.*, tbl_danhmucqa.name_sp as ten_dm FROM tbl_sanpham, tbl_danhmucqa 
                 WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm 
                 AND tbl_sanpham.so_luong > 0
                 ORDER BY RAND() LIMIT 4";
$featured_pro = mysqli_query($mysqli, $sql_featured);
if (!$featured_pro) {
    echo "<p style='color: red;'>ERROR: " . mysqli_error($mysqli) . "</p>";
} else {
    $count = mysqli_num_rows($featured_pro);
    echo "<p style='color: green;'>SUCCESS: Found $count products</p>";
    while ($row = mysqli_fetch_array($featured_pro)) {
        echo "<p>- {$row['ten_sp']} (Category: {$row['ten_dm']})</p>";
    }
}

// Test query 2: Newest products
echo "<h2>2. Newest Products Query</h2>";
$sql_newest = "SELECT tbl_sanpham.*, tbl_danhmucqa.name_sp as ten_dm FROM tbl_sanpham, tbl_danhmucqa 
               WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm 
               ORDER BY tbl_sanpham.id_sp DESC LIMIT 4";
$newest_pro = mysqli_query($mysqli, $sql_newest);
if (!$newest_pro) {
    echo "<p style='color: red;'>ERROR: " . mysqli_error($mysqli) . "</p>";
} else {
    $count = mysqli_num_rows($newest_pro);
    echo "<p style='color: green;'>SUCCESS: Found $count products</p>";
    while ($row = mysqli_fetch_array($newest_pro)) {
        echo "<p>- {$row['ten_sp']} (Category: {$row['ten_dm']})</p>";
    }
}

// Test query 3: Discount products
echo "<h2>3. Discount Products Query</h2>";
$sql_discount = "SELECT sp.*, dm.name_sp as ten_dm, km.loai_km, km.gia_tri_km,
                 CASE 
                     WHEN km.loai_km = 'phan_tram' THEN km.gia_tri_km
                     WHEN km.loai_km = 'tien' THEN (km.gia_tri_km / sp.gia_sp * 100)
                     ELSE 0
                 END as discount_percent
                 FROM tbl_sanpham sp
                 INNER JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm
                 INNER JOIN tbl_sanpham_khuyenmai spkm ON sp.id_sp = spkm.id_sp
                 INNER JOIN tbl_khuyenmai km ON spkm.id_km = km.id_km
                 WHERE km.trang_thai = 1 
                 AND NOW() BETWEEN km.ngay_bat_dau AND km.ngay_ket_thuc
                 ORDER BY discount_percent DESC
                 LIMIT 4";
$discount_pro = mysqli_query($mysqli, $sql_discount);
if (!$discount_pro) {
    echo "<p style='color: red;'>ERROR: " . mysqli_error($mysqli) . "</p>";
} else {
    $count = mysqli_num_rows($discount_pro);
    echo "<p style='color: green;'>SUCCESS: Found $count discount products</p>";
    while ($row = mysqli_fetch_array($discount_pro)) {
        echo "<p>- {$row['ten_sp']} (Discount: {$row['discount_percent']}%)</p>";
    }
}

// Test query 4: Categories
echo "<h2>4. Categories Query</h2>";
$sql_categories = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC LIMIT 3";
$categories = mysqli_query($mysqli, $sql_categories);
if (!$categories) {
    echo "<p style='color: red;'>ERROR: " . mysqli_error($mysqli) . "</p>";
} else {
    $count = mysqli_num_rows($categories);
    echo "<p style='color: green;'>SUCCESS: Found $count categories</p>";
    while ($row = mysqli_fetch_array($categories)) {
        echo "<p>- {$row['name_sp']}</p>";
    }
}

echo "<h2>Test Completed!</h2>";
?>
