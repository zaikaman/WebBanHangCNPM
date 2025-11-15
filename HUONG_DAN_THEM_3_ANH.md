# HƯỚNG DẪN THÊM 3 ẢNH CHO SẢN PHẨM

## 📋 Tổng Quan
Mỗi sản phẩm hiện tại hỗ trợ **3 ảnh**:
- **Ảnh 1 (Ảnh chính)**: Bắt buộc - Ảnh này sẽ hiển thị đầu tiên
- **Ảnh 2 (Ảnh phụ 1)**: Tùy chọn - Ảnh bổ sung góc nhìn khác
- **Ảnh 3 (Ảnh phụ 2)**: Tùy chọn - Ảnh chi tiết hoặc góc nhìn khác

---

## 🔧 BƯỚC 1: CẬP NHẬT DATABASE

### Chạy SQL sau trong phpMyAdmin:

```sql
-- Thêm 2 trường ảnh mới vào bảng tbl_sanpham
ALTER TABLE `tbl_sanpham` 
ADD COLUMN `hinh_anh_2` VARCHAR(50) NULL AFTER `hinh_anh`,
ADD COLUMN `hinh_anh_3` VARCHAR(50) NULL AFTER `hinh_anh_2`;

-- Cập nhật comment cho các cột
ALTER TABLE `tbl_sanpham` 
MODIFY COLUMN `hinh_anh` VARCHAR(50) NOT NULL COMMENT 'Ảnh chính',
MODIFY COLUMN `hinh_anh_2` VARCHAR(50) NULL COMMENT 'Ảnh phụ 1',
MODIFY COLUMN `hinh_anh_3` VARCHAR(50) NULL COMMENT 'Ảnh phụ 2';
```

**Hoặc import file**: `sql/update_product_images.sql`

### Cách thực hiện:
1. Mở **phpMyAdmin**
2. Chọn database `webbanhang_cnpm`
3. Vào tab **SQL**
4. Copy & paste đoạn SQL trên
5. Click **Go** để thực thi

---

## 📝 BƯỚC 2: THÊM SẢN PHẨM MỚI VỚI 3 ẢNH

### Vào trang admin:
1. Đăng nhập vào Admin Panel
2. Vào **Quản Lý Sản Phẩm** > **Thêm Sản Phẩm**
3. Điền thông tin sản phẩm như bình thường

### Tải lên 3 ảnh:
Bạn sẽ thấy 3 phần upload ảnh:

#### **Ảnh 1 - Ảnh Chính** (BẮT BUỘC)
- Click vào khung "Nhấp để chọn ảnh chính"
- Chọn ảnh đại diện chính của sản phẩm
- Ảnh này sẽ hiển thị đầu tiên trong danh sách sản phẩm

#### **Ảnh 2 - Ảnh Phụ 1** (Tùy chọn)
- Click vào khung "Nhấp để chọn ảnh phụ 1"
- Chọn ảnh góc nhìn khác hoặc chi tiết sản phẩm
- Có thể bỏ qua nếu không cần

#### **Ảnh 3 - Ảnh Phụ 2** (Tùy chọn)
- Click vào khung "Nhấp để chọn ảnh phụ 2"
- Chọn ảnh thêm nếu muốn
- Có thể bỏ qua nếu không cần

### Yêu cầu về ảnh:
- **Định dạng**: JPG, JPEG, PNG, GIF
- **Kích thước tối đa**: 5MB/ảnh
- **Khuyến nghị**: 
  - Độ phân giải: 800x800px trở lên
  - Tỷ lệ: Vuông (1:1) cho đẹp nhất
  - Nền trắng hoặc trong suốt

---

## ✏️ BƯỚC 3: SỬA SẢN PHẨM ĐÃ CÓ - THÊM ẢNH

### Để thêm 2 ảnh cho sản phẩm đã có:

1. Vào **Quản Lý Sản Phẩm** > **Danh Sách Sản Phẩm**
2. Click nút **Sửa** ở sản phẩm cần thêm ảnh
3. Cuộn xuống phần **Hình Ảnh Sản Phẩm**

### Bạn sẽ thấy 3 phần:

#### **Ảnh 1 - Ảnh Chính**
- Hiển thị ảnh hiện tại (nếu có)
- Upload ảnh mới nếu muốn thay đổi
- Để trống nếu giữ nguyên ảnh cũ

#### **Ảnh 2 - Ảnh Phụ 1**
- Nếu CHƯA có: Upload ảnh mới
- Nếu ĐÃ có: 
  - Hiển thị ảnh hiện tại
  - Upload ảnh mới để thay thế
  - Hoặc tick "Xóa ảnh này" để xóa

#### **Ảnh 3 - Ảnh Phụ 2**
- Tương tự Ảnh 2

4. Click **Sửa Sản Phẩm** để lưu

---

## 💡 MẸO VÀ LƯU Ý

### ✅ Nên làm:
- Luôn upload Ảnh 1 (ảnh chính) cho sản phẩm mới
- Sử dụng ảnh chất lượng cao, rõ nét
- Đặt tên file có ý nghĩa (vd: `ao-man-city-trang.jpg`)
- Upload đủ 3 ảnh để khách hàng xem rõ sản phẩm

### ❌ Không nên:
- Upload ảnh quá lớn (> 5MB) - sẽ load chậm
- Dùng ảnh mờ, chất lượng kém
- Quên upload ảnh chính khi thêm sản phẩm mới

### 🔍 Kiểm tra sau khi upload:
1. Vào trang sản phẩm để xem ảnh hiển thị đúng chưa
2. Kiểm tra cả 3 ảnh đều hiển thị rõ ràng
3. Đảm bảo ảnh không bị méo, vỡ

---

## 🗂️ THÊM HÀNG LOẠT (Cho sản phẩm đã có)

Nếu bạn có nhiều sản phẩm cần thêm ảnh:

### Cách 1: Qua giao diện Admin (Khuyến nghị)
1. Vào từng sản phẩm
2. Click **Sửa**
3. Upload 2 ảnh mới vào Ảnh 2 và Ảnh 3
4. Lưu lại

### Cách 2: Qua SQL (Nâng cao - Cẩn thận!)
Nếu đã upload ảnh vào folder `admincp/modules/quanLySanPham/uploads/`:

```sql
-- Ví dụ: Cập nhật ảnh cho sản phẩm có mã MCIH2324
UPDATE tbl_sanpham 
SET 
    hinh_anh_2 = 'MCIH2324_2_1234567890.jpg',
    hinh_anh_3 = 'MCIH2324_3_1234567890.jpg'
WHERE ma_sp = 'MCIH2324';
```

**⚠️ Lưu ý**: Tên file phải đúng với file đã upload!

---

## 📁 CẤU TRÚC THỨ MỤC

```
admincp/
└── modules/
    └── quanLySanPham/
        └── uploads/          ← Tất cả ảnh lưu ở đây
            ├── MCIH2324_1_1699999999.jpg   (Ảnh chính)
            ├── MCIH2324_2_1699999999.jpg   (Ảnh phụ 1)
            └── MCIH2324_3_1699999999.jpg   (Ảnh phụ 2)
```

---

## 🆘 XỬ LÝ LỖI THƯỜNG GẶP

### Lỗi: "File quá lớn"
- **Nguyên nhân**: Ảnh > 5MB
- **Giải pháp**: Nén ảnh bằng TinyPNG hoặc Photoshop

### Lỗi: "File không phải là hình ảnh"
- **Nguyên nhân**: Upload file không đúng định dạng
- **Giải pháp**: Chỉ upload JPG, PNG, GIF

### Lỗi: "Ảnh chính không được để trống"
- **Nguyên nhân**: Chưa upload Ảnh 1 khi thêm sản phẩm mới
- **Giải pháp**: Bắt buộc phải upload Ảnh 1

### Ảnh không hiển thị sau khi upload
- **Kiểm tra**:
  1. File có trong folder `uploads/` chưa?
  2. Tên file trong database có đúng không?
  3. Quyền folder có đủ không? (chmod 755)

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề, kiểm tra:
1. ✅ Đã chạy SQL update database chưa?
2. ✅ File code đã được cập nhật chưa?
3. ✅ Folder `uploads/` có quyền ghi không?
4. ✅ Dung lượng hosting còn đủ không?

---

## 📸 DEMO NHANH

### Thêm sản phẩm mới:
```
1. Điền tên: "Áo Manchester City 2025"
2. Mã SP: "MCIH2025"
3. Upload Ảnh 1: mci-trang.jpg
4. Upload Ảnh 2: mci-sau.jpg
5. Upload Ảnh 3: mci-logo.jpg
6. Click "Lưu Sản Phẩm"
```

### Sửa sản phẩm cũ:
```
1. Tìm sản phẩm "Áo Manchester City 2023"
2. Click "Sửa"
3. Giữ nguyên Ảnh 1 (để trống)
4. Upload Ảnh 2 mới
5. Upload Ảnh 3 mới
6. Click "Sửa Sản Phẩm"
```

---

**✨ Hoàn thành! Giờ mỗi sản phẩm của bạn có thể có đến 3 ảnh đẹp!**
