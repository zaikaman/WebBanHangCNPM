# Hướng Dẫn Sửa Lỗi PDF - 7TCC

## Lỗi Đã Sửa

### Vấn đề gốc:
```
Warning: fopen(C:\xampp\htdocs\WebBanHang\tfpdf/font/unifont/DejaVuSansCondensed.ttf): Failed to open stream: No such file or directory
```

### Nguyên nhân:
- File `dejavusanscondensed.mtx.php` chứa đường dẫn cứng sai
- Đường dẫn trỏ đến thư mục cũ `WebBanHang` thay vì `WebBanHangCNPM`

### Giải pháp:
1. **Sửa đường dẫn trong file font config**:
   ```php
   // Thay đổi từ:
   $ttffile='C:\xampp\htdocs\WebBanHang\tfpdf/font/unifont/DejaVuSansCondensed.ttf';
   
   // Thành:
   $ttffile=dirname(__FILE__).'/DejaVuSansCondensed.ttf';
   ```

2. **Cải thiện file indonhang.php**:
   - Thêm thông tin công ty
   - Hiển thị thông tin khách hàng chi tiết
   - Định dạng PDF đẹp hơn
   - Thêm header và footer chuyên nghiệp

## Cấu Trúc Font

### Thư mục font:
```
tfpdf/
├── font/
│   └── unifont/
│       ├── DejaVuSansCondensed.ttf (file font chính)
│       ├── dejavusanscondensed.mtx.php (cấu hình font)
│       └── ... (các font khác)
```

### Cách sử dụng font Unicode:
```php
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',12);
```

## Test PDF

### File test: `test_pdf.php`
Chạy file này để kiểm tra PDF có hoạt động:
```
http://localhost/WebBanHangCNPM/test_pdf.php
```

### In đơn hàng:
```
pages/main/indonhang.php?code=[mã_đơn_hàng]
```

## Các Lỗi Thường Gặp

### 1. Font không tìm thấy
- **Triệu chứng**: "Can't open file ..."
- **Giải pháp**: Kiểm tra đường dẫn trong file `.mtx.php`

### 2. Ký tự tiếng Việt bị lỗi
- **Triệu chứng**: Hiển thị ký tự lạ
- **Giải pháp**: Sử dụng font Unicode (DejaVu)

### 3. PDF không hiển thị
- **Triệu chứng**: Trang trắng hoặc lỗi PHP
- **Giải pháp**: Kiểm tra require đường dẫn đúng

## Cấu Hình Khuyến Nghị

### Sử dụng đường dẫn tương đối:
```php
// Tốt
$ttffile=dirname(__FILE__).'/DejaVuSansCondensed.ttf';

// Tránh
$ttffile='C:\xampp\htdocs\WebBanHangCNPM\tfpdf/font/unifont/DejaVuSansCondensed.ttf';
```

### Header PDF chuyên nghiệp:
```php
$pdf->SetFillColor(70, 130, 180);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 15, '7TCC - THOI TRANG THE THAO', 0, 1, 'C', true);
```

## Backup và Bảo Trì

### Backup quan trọng:
- File `dejavusanscondensed.mtx.php`
- Thư mục `tfpdf/font/`
- File `indonhang.php`

### Kiểm tra định kỳ:
- Test file `test_pdf.php` sau mỗi lần update
- Kiểm tra in đơn hàng mẫu
- Verify font hiển thị đúng ký tự tiếng Việt
