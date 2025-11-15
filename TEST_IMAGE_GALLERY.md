# 🎨 HƯỚNG DẪN TEST GALLERY 3 ẢNH

## ✅ ĐÃ CẬP NHẬT

### 1. Database ✔️
- Thêm 2 trường: `hinh_anh_2`, `hinh_anh_3`
- Chạy SQL: `sql/update_product_images.sql`

### 2. Trang Chi Tiết Sản Phẩm ✔️
- Gallery slider hiện đại với 3 ảnh
- Thumbnail navigation
- Previous/Next arrows
- Image counter
- Responsive design
- Touch/Swipe support cho mobile

### 3. Form Thêm/Sửa Sản Phẩm ✔️
- Upload 3 ảnh riêng biệt
- Preview trước khi upload
- Xóa ảnh phụ khi sửa

---

## 🚀 CÁCH TEST

### Bước 1: Chạy SQL Update
```sql
-- Vào phpMyAdmin và chạy:
ALTER TABLE `tbl_sanpham` 
ADD COLUMN `hinh_anh_2` VARCHAR(50) NULL AFTER `hinh_anh`,
ADD COLUMN `hinh_anh_3` VARCHAR(50) NULL AFTER `hinh_anh_2`;
```

### Bước 2: Test Thêm Sản Phẩm Mới
1. Vào Admin Panel → Quản Lý Sản Phẩm → Thêm Sản Phẩm
2. Upload 3 ảnh:
   - Ảnh 1: Mặt trước áo
   - Ảnh 2: Mặt sau áo
   - Ảnh 3: Chi tiết logo
3. Lưu sản phẩm

### Bước 3: Xem Gallery
1. Vào trang chi tiết sản phẩm vừa tạo
2. Kiểm tra:
   - ✅ 3 ảnh hiển thị trong gallery
   - ✅ Click thumbnail để chuyển ảnh
   - ✅ Click mũi tên trái/phải
   - ✅ Counter hiển thị đúng (1/3, 2/3, 3/3)
   - ✅ Swipe trái/phải trên mobile

### Bước 4: Test Sửa Sản Phẩm Cũ
1. Chọn 1 sản phẩm đã có (chỉ có 1 ảnh)
2. Click "Sửa"
3. Upload thêm Ảnh 2 và Ảnh 3
4. Lưu lại
5. Xem gallery có đủ 3 ảnh không

---

## 🎯 TÍNH NĂNG GALLERY

### 1. Main Image Display
- **Kích thước**: Vuông (1:1 aspect ratio)
- **Background**: Xám nhạt (#f8f9fa)
- **Border radius**: 16px
- **Shadow**: Đẹp, hiện đại
- **Animation**: Fade in/out mượt mà

### 2. Navigation Arrows
- **Vị trí**: Trái và phải ảnh chính
- **Style**: Tròn, nền trắng
- **Hover effect**: 
  - Background đổi thành đỏ (#dc0021)
  - Scale lên 1.1x
  - Icon đổi màu trắng

### 3. Thumbnail Gallery
- **Số lượng**: Tối đa 3 ảnh
- **Kích thước**: 80x80px
- **Active state**: 
  - Border đỏ (#dc0021)
  - Không có overlay
- **Hover effect**:
  - Overlay đen nhẹ
  - Scale ảnh lên 1.05x

### 4. Image Counter
- **Vị trí**: Góc dưới phải
- **Format**: "1 / 3"
- **Style**: Nền đen mờ, chữ trắng
- **Current image**: Màu đỏ, in đậm

### 5. Keyboard Navigation
- **Arrow Left** ←: Ảnh trước
- **Arrow Right** →: Ảnh tiếp

### 6. Touch/Swipe (Mobile)
- **Swipe Left**: Ảnh tiếp
- **Swipe Right**: Ảnh trước
- **Threshold**: 50px

---

## 📱 RESPONSIVE DESIGN

### Desktop (> 768px)
- Gallery max-width: 500px
- Arrows: 44x44px
- Thumbnails: 80x80px

### Tablet (≤ 768px)
- Gallery: 100% width
- Arrows: 38x38px
- Thumbnails: 65x65px

### Mobile (≤ 480px)
- Thumbnails: 55x55px
- Padding ảnh: 12px (giảm)

---

## 🎨 THIẾT KẾ

### Colors
```css
Primary Red: #dc0021
Background: #f8f9fa
Border: transparent → #dc0021 (active)
Overlay: rgba(0,0,0,0.3)
Shadow: rgba(0,0,0,0.08)
```

### Transitions
```css
Image fade: 0.4s ease-in-out
Thumbnail: 0.3s ease
Button hover: 0.3s ease
Scale: 0.6s ease
```

### Fonts
```css
Font-family: 'Inter', sans-serif
Counter: 13px, weight 600
```

---

## ⚡ PERFORMANCE

### Optimizations
- Lazy loading cho ảnh (opacity 0 → 1)
- Chỉ 1 ảnh active tại 1 thời điểm
- CSS transitions thay vì JavaScript animations
- Touch events chỉ khi có > 1 ảnh

### Image Best Practices
- **Format**: JPG cho photos, PNG cho graphics
- **Size**: 800x800px ideal
- **Weight**: < 200KB mỗi ảnh
- **Aspect ratio**: 1:1 (square)

---

## 🐛 XỬ LÝ EDGE CASES

### 1 ảnh duy nhất
- ✅ Không hiển thị arrows
- ✅ Không hiển thị counter
- ✅ Không hiển thị thumbnails
- ✅ Vẫn hiển thị đẹp

### 2 ảnh
- ✅ Hiển thị đầy đủ features
- ✅ 2 thumbnails

### 3 ảnh (ideal)
- ✅ Full gallery experience
- ✅ 3 thumbnails
- ✅ Tất cả features

### Không có ảnh nào
- ✅ Hiển thị "no-image.jpg" (cần tạo)

---

## 📝 CODE STRUCTURE

### PHP (sanpham.php)
```php
// Lấy tất cả ảnh
$product_images = [];
if (!empty($info['hinh_anh'])) $product_images[] = ...
if (!empty($info['hinh_anh_2'])) $product_images[] = ...
if (!empty($info['hinh_anh_3'])) $product_images[] = ...

// Loop qua ảnh
foreach ($product_images as $index => $image) {
    // Display image với active class cho ảnh đầu
}
```

### CSS (sanpham.css)
```css
.product_img_gallery { ... }
.main_image_container { ... }
.gallery_nav { ... }
.thumbnail_gallery { ... }
```

### JavaScript
```javascript
let currentImageIndex = 0;
function changeMainImage(direction) { ... }
function selectImage(index) { ... }
```

---

## 🎯 TEST CHECKLIST

### Desktop
- [ ] Gallery hiển thị đúng layout
- [ ] Click arrow trái → ảnh trước
- [ ] Click arrow phải → ảnh tiếp
- [ ] Click thumbnail → chuyển ảnh
- [ ] Counter cập nhật đúng
- [ ] Hover effects hoạt động
- [ ] Keyboard arrows hoạt động

### Mobile
- [ ] Gallery responsive
- [ ] Swipe trái → ảnh tiếp
- [ ] Swipe phải → ảnh trước
- [ ] Thumbnails vừa màn hình
- [ ] Arrows size phù hợp
- [ ] Touch không conflict với scroll

### Edge Cases
- [ ] 1 ảnh: Không có navigation
- [ ] 2 ảnh: Vẫn hoạt động tốt
- [ ] 3 ảnh: Perfect
- [ ] Loop: Ảnh cuối → Ảnh đầu

---

## 🌟 BONUS FEATURES (Optional)

### Auto-play Slider (Đã comment trong code)
Uncomment để bật auto-play 5s:
```javascript
startAutoPlay();
mainImageContainer.addEventListener('mouseenter', stopAutoPlay);
mainImageContainer.addEventListener('mouseleave', startAutoPlay);
```

### Zoom on Click
Thêm lightbox/zoom khi click ảnh lớn:
```javascript
mainImageWrapper.addEventListener('click', function() {
    // Open fullscreen lightbox
});
```

### Image Preloading
Preload ảnh 2 và 3 khi load trang:
```javascript
images.forEach(img => {
    new Image().src = img.src;
});
```

---

## 📞 TROUBLESHOOTING

### Ảnh không hiển thị
**Kiểm tra**:
1. File có trong folder `uploads/` không?
2. Tên file trong database đúng không?
3. Đường dẫn `admincp/modules/quanLySanPham/uploads/` đúng không?

### Gallery không chuyển ảnh
**Kiểm tra**:
1. Console có lỗi JS không?
2. Class `.active` được add/remove đúng không?
3. `currentImageIndex` cập nhật đúng không?

### Thumbnails không click được
**Kiểm tra**:
1. `onclick="selectImage(<?php echo $index; ?>)"` có đúng không?
2. Index truyền vào có đúng (0, 1, 2) không?

### Swipe không hoạt động
**Kiểm tra**:
1. Touch events có được attach không?
2. `mainImageContainer` element tồn tại không?
3. `totalImages > 1` không?

---

## 🎉 KẾT QUẢ MONG ĐỢI

Sau khi hoàn thành, bạn sẽ có:

✨ **Gallery hiện đại** với 3 ảnh
🖼️ **Thumbnails** để preview nhanh
⬅️➡️ **Navigation arrows** mượt mà
📱 **Mobile-friendly** với swipe
⌨️ **Keyboard support** (arrow keys)
🎨 **Thiết kế đẹp** theo design system
🚀 **Performance tốt** với CSS transitions

---

**Good luck! Gallery của bạn sẽ trông rất chuyên nghiệp! 🎊**
