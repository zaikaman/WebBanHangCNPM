# Hệ Thống Quản Lý Khuyến Mãi / Giảm Giá

## Tổng quan
Hệ thống quản lý khuyến mãi cho phép admin tạo và quản lý các chương trình giảm giá cho sản phẩm với nhiều loại khuyến mãi khác nhau.

## Các loại khuyến mãi

### 1. Giảm giá theo phần trăm (%)
- Giảm một phần trăm nhất định từ giá gốc
- Ví dụ: Giảm 20% → Sản phẩm 100,000đ còn 80,000đ

### 2. Giảm giá theo số tiền (VNĐ)
- Giảm một số tiền cố định từ giá gốc
- Ví dụ: Giảm 50,000đ → Sản phẩm 300,000đ còn 250,000đ

### 3. Giá mới cố định
- Đặt một mức giá mới cho sản phẩm
- Ví dụ: Giá đặc biệt 299,000đ (bất kể giá gốc là bao nhiêu)

## Cài đặt

### Bước 1: Tạo bảng database
```bash
# Truy cập phpMyAdmin hoặc MySQL
# Import file: sql/create_promotions_table.sql
```

Hoặc chạy lệnh SQL trực tiếp:
```sql
mysql -u root -p webbanhang_cnpm < sql/create_promotions_table.sql
```

### Bước 2: Kiểm tra các file đã tạo

**Backend (AdminCP):**
- `admincp/modules/quanLyKhuyenMai/lietke.php` - Danh sách khuyến mãi
- `admincp/modules/quanLyKhuyenMai/them.php` - Thêm khuyến mãi
- `admincp/modules/quanLyKhuyenMai/sua.php` - Sửa khuyến mãi
- `admincp/modules/quanLyKhuyenMai/sanpham.php` - Quản lý sản phẩm áp dụng
- `admincp/modules/quanLyKhuyenMai/xuly.php` - Xóa khuyến mãi

**Frontend (Helper & CSS):**
- `includes/promotion_helper.php` - Functions xử lý khuyến mãi
- `css/khuyenmai.css` - Styles hiển thị khuyến mãi
- `includes/promotion_usage_guide.php` - Hướng dẫn sử dụng

### Bước 3: Tích hợp vào các trang hiển thị sản phẩm

#### 3.1. Thêm CSS vào header
```php
<!-- Thêm vào <head> của file header -->
<link rel="stylesheet" href="css/khuyenmai.css">
```

#### 3.2. Include helper
```php
<?php
// Thêm vào đầu các file cần hiển thị khuyến mãi
require_once('includes/promotion_helper.php');
?>
```

#### 3.3. Sử dụng trong vòng lặp sản phẩm
```php
<?php
while ($row = mysqli_fetch_array($lietke)) {
    // Lấy thông tin khuyến mãi
    $promotion = getActivePromotion($row['id_sp'], $mysqli);
    $gia_goc = $row['gia_sp'];
    $gia_hien_thi = $promotion ? calculatePromotionPrice($gia_goc, $promotion) : $gia_goc;
?>
    <div class="product-card <?php echo $promotion ? 'has-promotion' : ''; ?>">
        <!-- Badge khuyến mãi -->
        <?php if ($promotion): ?>
            <?php echo displayPromotionBadge($promotion); ?>
        <?php endif; ?>
        
        <img src="..." alt="">
        
        <h3><?php echo $row['ten_sp']; ?></h3>
        
        <!-- Hiển thị giá -->
        <?php echo displayProductPrice($gia_goc, $promotion); ?>
    </div>
<?php } ?>
```

## Hướng dẫn sử dụng Admin

### Tạo chương trình khuyến mãi mới

1. **Đăng nhập Admin** → Vào menu "Khuyến mãi"
2. **Click "Thêm Khuyến Mãi"**
3. **Điền thông tin:**
   - Tên chương trình (VD: "Flash Sale cuối tuần")
   - Mô tả chi tiết
   - Loại khuyến mãi (Chọn 1 trong 3 loại)
   - Giá trị (số % hoặc số tiền)
   - Ngày bắt đầu và kết thúc
   - Tích chọn "Kích hoạt" để áp dụng ngay

4. **Click "Thêm mới"**

### Áp dụng khuyến mãi cho sản phẩm

1. **Vào danh sách khuyến mãi**
2. **Click vào số sản phẩm** (icon hộp) của chương trình muốn áp dụng
3. **Chọn sản phẩm** từ danh sách bên phải
4. **Click "Thêm các sản phẩm đã chọn"**

### Xóa sản phẩm khỏi khuyến mãi

1. **Vào quản lý sản phẩm** của chương trình
2. **Click nút X màu đỏ** bên cạnh sản phẩm muốn xóa

### Sửa/Xóa khuyến mãi

- **Sửa:** Click icon bút chì màu xanh
- **Xóa:** Click icon thùng rác màu đỏ (sẽ xóa cả liên kết với sản phẩm)

## API Functions (Helper)

### getActivePromotion($id_sp, $mysqli)
Lấy thông tin khuyến mãi đang hoạt động của sản phẩm
```php
$promotion = getActivePromotion(150, $mysqli);
// Returns: array hoặc null
```

### calculatePromotionPrice($gia_goc, $km)
Tính giá sau khuyến mãi
```php
$gia_sau_km = calculatePromotionPrice(350000, $promotion);
// Returns: 280000 (nếu giảm 20%)
```

### calculateDiscountPercent($gia_goc, $gia_km)
Tính % giảm giá
```php
$percent = calculateDiscountPercent(350000, 280000);
// Returns: 20
```

### displayPromotionBadge($km)
Hiển thị badge khuyến mãi
```php
echo displayPromotionBadge($promotion);
// Output: <span class="promotion-badge">-20%</span>
```

### displayProductPrice($gia_goc, $km)
Hiển thị giá sản phẩm với HTML đầy đủ
```php
echo displayProductPrice(350000, $promotion);
// Output: HTML với giá gốc gạch ngang + giá KM màu đỏ + badge %
```

### getPromotionalProducts($mysqli, $limit)
Lấy danh sách sản phẩm đang có khuyến mãi
```php
$products = getPromotionalProducts($mysqli, 10);
while ($row = mysqli_fetch_array($products)) {
    // Hiển thị sản phẩm
}
```

### hasPromotion($id_sp, $mysqli)
Kiểm tra sản phẩm có khuyến mãi không
```php
if (hasPromotion(150, $mysqli)) {
    echo "Sản phẩm đang có khuyến mãi!";
}
```

### getPromotionText($km)
Lấy text mô tả khuyến mãi
```php
echo getPromotionText($promotion);
// Output: "Giảm 20%"
```

### getPromotionTimeRemaining($km)
Lấy thời gian còn lại của khuyến mãi
```php
echo getPromotionTimeRemaining($promotion);
// Output: "Còn 5 ngày"
```

## Cấu trúc Database

### tbl_khuyenmai
Lưu thông tin chương trình khuyến mãi

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id_km | INT | ID khuyến mãi (Primary Key) |
| ten_km | VARCHAR(255) | Tên chương trình |
| mo_ta | TEXT | Mô tả chi tiết |
| loai_km | ENUM | Loại: phan_tram, tien_mat, gia_moi |
| gia_tri_km | DECIMAL(10,2) | Giá trị khuyến mãi |
| ngay_bat_dau | DATETIME | Ngày bắt đầu |
| ngay_ket_thuc | DATETIME | Ngày kết thúc |
| trang_thai | TINYINT(1) | 1: Kích hoạt, 0: Tắt |

### tbl_sanpham_khuyenmai
Bảng liên kết sản phẩm và khuyến mãi (Many-to-Many)

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | INT | ID (Primary Key) |
| id_sp | INT | ID sản phẩm (Foreign Key) |
| id_km | INT | ID khuyến mãi (Foreign Key) |

### view_sanpham_khuyenmai (Optional)
View để query dễ dàng hơn, tự động tính giá sau khuyến mãi

## Lưu ý quan trọng

### 1. Xử lý giỏ hàng
Khi thêm sản phẩm vào giỏ hàng, cần lưu:
- Giá sau khuyến mãi (`gia_sp`)
- Giá gốc (`gia_goc`) - để hiển thị so sánh
- ID khuyến mãi (`id_km`) - để tracking

### 2. Kiểm tra tồn kho
Đảm bảo kiểm tra số lượng còn lại trước khi áp dụng khuyến mãi

### 3. Hiệu suất
- Sử dụng index trên `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`
- Cache danh sách sản phẩm khuyến mãi nếu cần

### 4. Bảo mật
- Validate input khi tạo/sửa khuyến mãi
- Kiểm tra quyền admin trước khi thao tác

## Ví dụ thực tế

### Tạo khuyến mãi "Black Friday"
```
Tên: Black Friday - Giảm 50%
Mô tả: Giảm giá sốc nhân dịp Black Friday
Loại: Giảm theo phần trăm
Giá trị: 50
Từ: 24/11/2025 00:00
Đến: 30/11/2025 23:59
```

### Áp dụng cho toàn bộ danh mục Bóng đá
```sql
-- Thêm tất cả sản phẩm bóng đá vào khuyến mãi
INSERT INTO tbl_sanpham_khuyenmai (id_sp, id_km)
SELECT id_sp, 1 FROM tbl_sanpham WHERE id_dm = 65;
```

## Troubleshooting

### Khuyến mãi không hiển thị?
1. Kiểm tra trạng thái khuyến mãi (phải = 1)
2. Kiểm tra thời gian (NOW() phải nằm giữa ngày bắt đầu và kết thúc)
3. Kiểm tra sản phẩm đã được add vào bảng `tbl_sanpham_khuyenmai`

### Giá hiển thị sai?
1. Kiểm tra logic trong helper function
2. Xem loại khuyến mãi có đúng không
3. Debug bằng `var_dump($promotion);`

### Không thấy menu Khuyến mãi?
1. Kiểm tra đã sửa file `menu.php` chưa
2. Kiểm tra đã sửa file `main.php` chưa
3. Clear cache trình duyệt

## Mở rộng trong tương lai

- [ ] Khuyến mãi tự động theo danh mục
- [ ] Combo/Bundle deals
- [ ] Mã giảm giá (coupon codes)
- [ ] Tích điểm thành viên
- [ ] Flash sale với countdown timer
- [ ] Khuyến mãi theo giỏ hàng (mua X tặng Y)

## Liên hệ hỗ trợ

Nếu gặp vấn đề, vui lòng liên hệ team dev hoặc tạo issue trên GitHub.

---
**Version:** 1.0.0  
**Last Updated:** November 2025  
**Author:** 7TCC Team
