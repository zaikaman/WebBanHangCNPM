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

switch ($_GET['action']) {
    case 'export':
        $exporter->exportOrders($search, $search_field);
        break;
    default:
        die('Hành động không hợp lệ');
}
?>
