# 🔄 SCRIPT CÂP NHẬT ẢNH HÀNG LOẠT

## Dành cho sản phẩm đã có - Thêm ảnh 2 và ảnh 3

---

## ⚠️ CHÚ Ý QUAN TRỌNG

**TRƯỚC KHI CHẠY SCRIPT:**
1. ✅ Đã chạy SQL update database (thêm 2 cột mới)
2. ✅ Đã backup database
3. ✅ Đã chuẩn bị ảnh theo đúng tên file

---

## 📋 CHUẨN BỊ ẢNH

### Quy tắc đặt tên file:

Nếu sản phẩm hiện có ảnh chính là: `MCIH2324_1_1699999999.jpg`

Thì 2 ảnh mới phải đặt tên:
- Ảnh 2: `MCIH2324_2_1699999999.jpg`
- Ảnh 3: `MCIH2324_3_1699999999.jpg`

**HOẶC** đơn giản hơn (không cần timestamp):
- Ảnh 2: `MCIH2324_2.jpg`
- Ảnh 3: `MCIH2324_3.jpg`

---

## 📁 UPLOAD ẢNH

### Bước 1: Chuẩn bị ảnh
1. Đặt tên file theo format: `MASP_2.jpg` và `MASP_3.jpg`
2. Ví dụ:
   ```
   MCIH2324_2.jpg
   MCIH2324_3.jpg
   MCIA2324_2.jpg
   MCIA2324_3.jpg
   LIVH2425_2.jpg
   LIVH2425_3.jpg
   ```

### Bước 2: Upload vào server
Upload tất cả ảnh vào:
```
admincp/modules/quanLySanPham/uploads/
```

### Bước 3: Chạy SQL cập nhật

---

## 🗄️ SQL CẬP NHẬT

### Option 1: Cập nhật từng sản phẩm (An toàn)

```sql
-- Manchester City Home 2023/2024
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MCIH2324_2.jpg',
    hinh_anh_3 = 'MCIH2324_3.jpg'
WHERE ma_sp = 'MCIH2324';

-- Manchester City Away 2023/2024
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MCIA2324_2.jpg',
    hinh_anh_3 = 'MCIA2324_3.jpg'
WHERE ma_sp = 'MCIA2324';

-- Manchester City Third 2023/2024
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MCIT2324_2.jpg',
    hinh_anh_3 = 'MCIT2324_3.jpg'
WHERE ma_sp = 'MCIT2324';

-- Liverpool Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'LIVH2425_2.jpg',
    hinh_anh_3 = 'LIVH2425_3.jpg'
WHERE ma_sp = 'LIVH2425';

-- Chelsea Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'CHEH2425_2.jpg',
    hinh_anh_3 = 'CHEH2425_3.jpg'
WHERE ma_sp = 'CHEH2425';

-- Manchester United Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MNUH2425_2.jpg',
    hinh_anh_3 = 'MNUH2425_3.jpg'
WHERE ma_sp = 'MNUH2425';

-- Manchester United Home 2023/2024
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MNUH2324_2.jpg',
    hinh_anh_3 = 'MNUH2324_3.jpg'
WHERE ma_sp = 'MNUH2324';

-- Arsenal Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'ARSH2425_2.jpg',
    hinh_anh_3 = 'ARSH2425_3.jpg'
WHERE ma_sp = 'ARSH2425';

-- Real Madrid Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'REAH2425_2.jpg',
    hinh_anh_3 = 'REAH2425_3.jpg'
WHERE ma_sp = 'REAH2425';

-- Barcelona Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'BARH2425_2.jpg',
    hinh_anh_3 = 'BARH2425_3.jpg'
WHERE ma_sp = 'BARH2425';

-- Barcelona Away 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'BARA2425_2.jpg',
    hinh_anh_3 = 'BARA2425_3.jpg'
WHERE ma_sp = 'BARA2425';

-- AC Milan Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'ACMH2425_2.jpg',
    hinh_anh_3 = 'ACMH2425_3.jpg'
WHERE ma_sp = 'ACMH2425';

-- Inter Milan Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'INTH2425_2.jpg',
    hinh_anh_3 = 'INTH2425_3.jpg'
WHERE ma_sp = 'INTH2425';

-- Napoli Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'NAPH2425_2.jpg',
    hinh_anh_3 = 'NAPH2425_3.jpg'
WHERE ma_sp = 'NAPH2425';

-- Napoli Away 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'NAPA2425_2.jpg',
    hinh_anh_3 = 'NAPA2425_3.jpg'
WHERE ma_sp = 'NAPA2425';

-- Bayern Munich Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'BAYH2425_2.jpg',
    hinh_anh_3 = 'BAYH2425_3.jpg'
WHERE ma_sp = 'BAYH2425';

-- Borussia Dortmund Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'BVBH2425_2.jpg',
    hinh_anh_3 = 'BVBH2425_3.jpg'
WHERE ma_sp = 'BVBH2425';

-- Tottenham Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'TOTH2425_2.jpg',
    hinh_anh_3 = 'TOTH2425_3.jpg'
WHERE ma_sp = 'TOTH2425';

-- Newcastle Home 2024/2025
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'NEWH2425_2.jpg',
    hinh_anh_3 = 'NEWH2425_3.jpg'
WHERE ma_sp = 'NEWH2425';
```

---

### Option 2: Auto-detect (Nâng cao - Cẩn thận!)

**Chỉ dùng nếu bạn đã upload ĐỦ ảnh với đúng tên!**

```sql
-- Script này sẽ tự động cập nhật nếu file tồn tại
-- TRƯỚC KHI CHẠY: Backup database!

UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = CONCAT(SUBSTRING_INDEX(hinh_anh, '_', 1), '_2', SUBSTRING(hinh_anh, LOCATE('_', hinh_anh, LOCATE('_', hinh_anh) + 1))),
    hinh_anh_3 = CONCAT(SUBSTRING_INDEX(hinh_anh, '_', 1), '_3', SUBSTRING(hinh_anh, LOCATE('_', hinh_anh, LOCATE('_', hinh_anh) + 1)))
WHERE hinh_anh IS NOT NULL 
  AND hinh_anh != '';
```

**⚠️ CHÚ Ý**: Script này giả định tên file có format `MASP_1_timestamp.jpg`

---

## 🎨 GỢI Ý NỘI DUNG ẢNH

### Áo bóng đá:
- **Ảnh 1 (Chính)**: Mặt trước áo, logo rõ
- **Ảnh 2**: Mặt sau áo, số áo (nếu có)
- **Ảnh 3**: Chi tiết logo, chất liệu, hoặc góc nghiêng

### Áo bóng chuyền/cầu lông:
- **Ảnh 1**: Mặt trước
- **Ảnh 2**: Mặt sau hoặc sườn áo
- **Ảnh 3**: Chi tiết đường may, logo

### Áo bóng rổ:
- **Ảnh 1**: Mặt trước, số áo rõ
- **Ảnh 2**: Mặt sau
- **Ảnh 3**: Logo team, chi tiết

---

## 🔍 KIỂM TRA SAU KHI CẬP NHẬT

### SQL Check
```sql
-- Kiểm tra sản phẩm đã có đủ 3 ảnh
SELECT 
    ma_sp,
    ten_sp,
    hinh_anh,
    hinh_anh_2,
    hinh_anh_3,
    CASE 
        WHEN hinh_anh IS NOT NULL AND hinh_anh_2 IS NOT NULL AND hinh_anh_3 IS NOT NULL 
        THEN 'ĐỦ 3 ẢNH'
        WHEN hinh_anh IS NOT NULL AND hinh_anh_2 IS NOT NULL 
        THEN 'CÓ 2 ẢNH'
        WHEN hinh_anh IS NOT NULL 
        THEN 'CHỈ 1 ẢNH'
        ELSE 'KHÔNG CÓ ẢNH'
    END as trang_thai_anh
FROM tbl_sanpham
ORDER BY trang_thai_anh DESC, ma_sp ASC;

-- Đếm số sản phẩm theo trạng thái ảnh
SELECT 
    CASE 
        WHEN hinh_anh IS NOT NULL AND hinh_anh_2 IS NOT NULL AND hinh_anh_3 IS NOT NULL 
        THEN 'ĐỦ 3 ẢNH'
        WHEN hinh_anh IS NOT NULL AND hinh_anh_2 IS NOT NULL 
        THEN 'CÓ 2 ẢNH'
        WHEN hinh_anh IS NOT NULL 
        THEN 'CHỈ 1 ẢNH'
        ELSE 'KHÔNG CÓ ẢNH'
    END as trang_thai_anh,
    COUNT(*) as so_luong
FROM tbl_sanpham
GROUP BY trang_thai_anh
ORDER BY so_luong DESC;
```

### File Check
1. Vào folder `admincp/modules/quanLySanPham/uploads/`
2. Kiểm tra có đủ file không
3. Tên file có đúng format không

### Frontend Check
1. Vào 1 sản phẩm đã cập nhật
2. Kiểm tra gallery hiển thị đủ 3 ảnh
3. Test navigation arrows
4. Test thumbnails click

---

## 📝 TEMPLATE SQL NHANH

Copy và thay MÃ_SP, TÊN_FILE:

```sql
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MÃ_SP_2.jpg',
    hinh_anh_3 = 'MÃ_SP_3.jpg'
WHERE ma_sp = 'MÃ_SP';
```

---

## 🚀 WORKFLOW KHUYẾN NGHỊ

### Làm từng danh mục:

1. **Áo bóng đá** (20 sản phẩm)
   - Upload 40 ảnh mới (20 sản phẩm × 2 ảnh)
   - Chạy SQL cho 20 sản phẩm
   - Test 2-3 sản phẩm

2. **Áo bóng rổ** (24 sản phẩm)
   - Upload 48 ảnh mới
   - Chạy SQL
   - Test

3. **Áo bóng chuyền** (15 sản phẩm)
   - Upload 30 ảnh mới
   - Chạy SQL
   - Test

4. **Áo cầu lông** (19 sản phẩm)
   - Upload 38 ảnh mới
   - Chạy SQL
   - Test

---

## ⏱️ THỜI GIAN ƯỚC TÍNH

- **Chuẩn bị ảnh**: 2-3 ngày (chụp/chỉnh sửa)
- **Upload**: 30 phút
- **SQL update**: 15 phút
- **Kiểm tra**: 1 giờ
- **TỔNG**: ~3-4 ngày (nếu làm full-time)

---

## 💡 MẸO

### Tự động hóa:
1. Đặt tên file theo template ngay khi chụp
2. Batch resize ảnh bằng Photoshop/GIMP
3. Upload qua FTP client nhanh hơn cPanel

### Chất lượng ảnh:
- Size: 800x800px
- Format: JPG, quality 85%
- Background: Trắng hoặc trong suốt
- Lighting: Đồng đều

### Backup:
- Export database trước khi update
- Backup folder uploads/
- Test trên 1-2 sản phẩm trước

---

**Chúc bạn cập nhật ảnh thành công! 📸**
