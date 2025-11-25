# Hướng Dẫn Cập Nhật Giá Khuyến Mãi

## Vấn đề
Giá khuyến mãi chỉ hiển thị trên frontend nhưng không được áp dụng khi mua hàng. Đơn hàng vẫn tính theo giá gốc.

## Nguyên nhân
Bảng `tbl_chitiet_gh` không lưu giá tại thời điểm mua. Khi xem đơn hàng, hệ thống JOIN với `tbl_sanpham` để lấy giá gốc hiện tại thay vì giá đã mua (có khuyến mãi).

## Giải pháp
Thêm cột `gia_mua` vào bảng `tbl_chitiet_gh` để lưu giá tại thời điểm đặt hàng (đã bao gồm khuyến mãi nếu có).

## Các bước thực hiện

### Bước 1: Chạy SQL Migration
Mở phpMyAdmin hoặc MySQL client và chạy file SQL:
```sql
-- File: sql/add_gia_mua_column.sql

-- Thêm cột gia_mua vào bảng tbl_chitiet_gh
ALTER TABLE `tbl_chitiet_gh` 
ADD COLUMN `gia_mua` DECIMAL(10,2) DEFAULT 0 AFTER `size`;

-- Cập nhật giá cho các đơn hàng cũ (lấy giá hiện tại từ tbl_sanpham)
UPDATE tbl_chitiet_gh c
INNER JOIN tbl_sanpham s ON c.id_sp = s.id_sp
SET c.gia_mua = s.gia_sp
WHERE c.gia_mua = 0 OR c.gia_mua IS NULL;
```

### Bước 2: Các file đã được cập nhật

#### 1. `pages/main/themgiohang.php` (✅ Đã có sẵn)
- Khi thêm sản phẩm vào giỏ, đã tính giá khuyến mãi từ đầu
- Code đã áp dụng `calculatePromotionPrice()` 

#### 2. `pages/main/giohang.php` (✅ Đã có sẵn)
- Cập nhật giá khuyến mãi cho các sản phẩm trong giỏ hàng
- Tính toán lại giá mỗi lần xem giỏ hàng

#### 3. `pages/main/thanhtoan.php` (✅ Đã cập nhật)
- Lưu `gia_mua` vào database khi tạo đơn hàng
- Sử dụng giá từ session (đã có khuyến mãi)

#### 4. `pages/main/camon.php` (✅ Đã cập nhật)
- Lưu `gia_mua` cho thanh toán MoMo và VNPay
- Đảm bảo giá khuyến mãi được lưu đúng

#### 5. `admincp/modules/quanLyDonHang/xemDonHang.php` (✅ Đã cập nhật)
- Sử dụng `COALESCE(c.gia_mua, s.gia_sp)` để hiển thị giá
- Ưu tiên giá đã lưu, fallback sang giá gốc nếu null

#### 6. `admincp/modules/quanLyDonHang/indonhang.php` (✅ Đã cập nhật)
- Cập nhật query để sử dụng `gia_mua`

#### 7. `pages/main/xemdonhang.php` (✅ Đã cập nhật)
- Cập nhật query để hiển thị giá đã mua

### Bước 3: Kiểm tra

1. **Test flow hoàn chỉnh:**
   - Tạo khuyến mãi cho sản phẩm
   - Thêm sản phẩm vào giỏ hàng
   - Kiểm tra giá trong giỏ hàng (phải là giá sau khuyến mãi)
   - Thanh toán đơn hàng
   - Xem đơn hàng trong lịch sử (phải hiển thị giá đã mua)

2. **Kiểm tra database:**
```sql
-- Kiểm tra cột mới
DESCRIBE tbl_chitiet_gh;

-- Kiểm tra dữ liệu
SELECT c.id_ctgh, c.ma_gh, c.id_sp, c.so_luong_mua, c.size, c.gia_mua, s.gia_sp, s.ten_sp
FROM tbl_chitiet_gh c
INNER JOIN tbl_sanpham s ON c.id_sp = s.id_sp
ORDER BY c.id_ctgh DESC
LIMIT 10;
```

## Flow hoàn chỉnh sau khi sửa

### 1. Thêm sản phẩm vào giỏ hàng
- File: `pages/main/themgiohang.php`
- Kiểm tra khuyến mãi với `getActivePromotion()`
- Tính giá sau khuyến mãi với `calculatePromotionPrice()`
- Lưu vào `$_SESSION['cart']` với giá đã giảm

### 2. Xem giỏ hàng
- File: `pages/main/giohang.php`
- Cập nhật lại giá khuyến mãi cho từng sản phẩm
- Hiển thị tổng tiền với giá đã giảm

### 3. Thanh toán
- File: `pages/main/thanhtoan.php` hoặc `camon.php`
- INSERT vào `tbl_chitiet_gh` với cột `gia_mua` = giá từ session
- Giá này đã bao gồm khuyến mãi nếu có

### 4. Xem đơn hàng
- File: `xemdonhang.php`, `xemDonHang.php`, `indonhang.php`
- SELECT với `COALESCE(c.gia_mua, s.gia_sp)`
- Hiển thị giá đã mua (có khuyến mãi)

## Lưu ý quan trọng

1. **Đơn hàng cũ:** Sau khi chạy migration, các đơn hàng cũ sẽ có giá hiện tại của sản phẩm (có thể không chính xác nếu giá đã thay đổi)

2. **Đơn hàng mới:** Từ bây giờ, mọi đơn hàng mới sẽ lưu chính xác giá tại thời điểm mua (có khuyến mãi)

3. **Backup:** Nên backup database trước khi chạy ALTER TABLE

## Rollback (nếu cần)
```sql
ALTER TABLE `tbl_chitiet_gh` DROP COLUMN `gia_mua`;
```
