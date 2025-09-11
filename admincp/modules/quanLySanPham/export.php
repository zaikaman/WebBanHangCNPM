<?php
session_start();
require_once '../../config/config.php';
require_once '../../exports/ExcelExporter.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['dangNhap'])) {
    die('Không có quyền truy cập');
}

if (!isset($_GET['action'])) {
    die('Không có hành động được chỉ định');
}

// Khởi tạo exporter
$exporter = new ExcelExporter($mysqli);

// Lấy tham số tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';

switch ($_GET['action']) {
    case 'export':
        $exporter->exportProducts($search, $search_field, $price_min, $price_max);
        break;
    default:
        die('Hành động không hợp lệ');
}
?>
