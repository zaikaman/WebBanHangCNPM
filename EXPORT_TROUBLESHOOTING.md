# Hướng Dẫn Khắc Phục Sự Cố Export Excel

## Vấn Đề: Click nút "Xuất Excel" không có gì xảy ra

### Các Bước Kiểm Tra và Khắc Phục

#### Bước 1: Kiểm tra Console Browser
1. Mở **Developer Tools** (F12)
2. Vào tab **Console**
3. Click nút "Xuất Excel"
4. Xem có lỗi JavaScript nào không

**Các lỗi thường gặp:**
- `exportProducts is not defined` → Thiếu function JavaScript
- `$ is not defined` → Thiếu jQuery
- `Swal is not defined` → Thiếu SweetAlert2

#### Bước 2: Test Debug Files
Truy cập các file test sau để kiểm tra:

1. **Test tổng quát**: `/admincp/test_export.html`
2. **Debug sản phẩm**: `/admincp/modules/quanLySanPham/debug_export.php`
3. **Test đơn giản**: `/admincp/modules/quanLySanPham/test_simple_export.php`

#### Bước 3: Kiểm tra Session Admin
File export chỉ hoạt động khi admin đã đăng nhập.

**Kiểm tra:**
```php
// Trong PHP
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die('Không có quyền truy cập');
}
```

#### Bước 4: Test Export Trực Tiếp
Thử truy cập trực tiếp các URL sau:
- `/admincp/modules/quanLySanPham/export.php?action=export`
- `/admincp/modules/quanLyDonHang/export.php?action=export`
- `/admincp/modules/quanLyBaiViet/export.php?action=export`
- `/admincp/modules/quanLyTaiKhoanKhachHang/export.php?action=export`

**Kết quả mong đợi:**
- File Excel được tải xuống HOẶC
- Thông báo lỗi cụ thể

#### Bước 5: Kiểm tra Thư Viện
Đảm bảo PhpSpreadsheet đã được cài đặt:
```bash
composer require phpoffice/phpspreadsheet:^1.29 --ignore-platform-reqs
```

#### Bước 6: Kiểm tra Cấu Hình PHP
Trong `php.ini`:
```ini
memory_limit = 256M
max_execution_time = 300
post_max_size = 50M
upload_max_filesize = 50M
```

### Các Giải Pháp Thường Gặp

#### Giải Pháp 1: Sửa JavaScript
Nếu function không hoạt động, thêm vào cuối trang:

```javascript
// Backup function
window.exportProducts = function() {
    console.log('Export function called');
    
    // Simple download method
    var url = 'modules/quanLySanPham/export.php?action=export';
    
    // Method 1: Direct link
    var link = document.createElement('a');
    link.href = url;
    link.download = 'san_pham.xlsx';
    link.click();
    
    // Method 2: Window open
    setTimeout(function() {
        window.open(url, '_blank');
    }, 100);
};
```

#### Giải Pháp 2: Sửa Export File
Thêm debug vào đầu file export:

```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log để debug
file_put_contents(__DIR__ . '/export_log.txt', 
    date('Y-m-d H:i:s') . " - Export started\n", 
    FILE_APPEND
);

session_start();
require_once '../../config/config.php';
require_once '../../exports/ExcelExporter.php';

// ... rest of code
?>
```

#### Giải Pháp 3: Alternative Export Method
Tạo export đơn giản không dùng PhpSpreadsheet:

```php
<?php
// Simple CSV export as backup
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=san_pham.csv');

$output = fopen('php://output', 'w');

// UTF-8 BOM for Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Headers
fputcsv($output, ['STT', 'Tên SP', 'Giá', 'Số lượng']);

// Data
$sql = "SELECT * FROM tbl_sanpham LIMIT 100";
$result = mysqli_query($mysqli, $sql);
$i = 1;
while ($row = mysqli_fetch_array($result)) {
    fputcsv($output, [$i++, $row['ten_sp'], $row['gia_sp'], $row['so_luong']]);
}

fclose($output);
?>
```

### Test Nhanh

#### Test 1: JavaScript
Mở Console và chạy:
```javascript
exportProducts();
```

#### Test 2: Direct URL
Paste vào browser:
```
http://localhost/WebBanHangCNPM/admincp/modules/quanLySanPham/export.php?action=export
```

#### Test 3: Check Files
Kiểm tra các file tồn tại:
- `/admincp/exports/ExcelExporter.php`
- `/admincp/config/config.php`
- `/vendor/autoload.php`

### Liên Hệ Debug
Nếu vẫn không hoạt động, gửi thông tin:
1. Lỗi trong Console browser
2. Kết quả của `/admincp/modules/quanLySanPham/debug_export.php`
3. Phiên bản PHP và các extension đã cài

### Backup Solution - CSV Export
Nếu Excel không hoạt động, có thể dùng CSV:

```php
// Thêm vào menu
<button onclick="exportCSV()" class="btn btn-secondary">
    <i class="fas fa-file-csv me-2"></i>Xuất CSV
</button>

<script>
function exportCSV() {
    window.open('modules/quanLySanPham/export_csv.php', '_blank');
}
</script>
```
