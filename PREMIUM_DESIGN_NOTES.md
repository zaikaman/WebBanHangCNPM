# 🎨 Premium Design - Trang Chủ & Header

## ✨ Tổng Quan Thay Đổi

Đã nâng cấp hoàn toàn thiết kế trang chủ và header lên phong cách cao cấp, hiện đại với tông màu đỏ-trắng.

## 📁 Files Mới Được Tạo

### CSS Files
1. **css/homepage-premium.css** - Thiết kế trang chủ cao cấp
2. **css/header-premium.css** - Thiết kế header cao cấp
3. **css/menu-premium.css** - Thiết kế menu cao cấp
4. **css/premium-overrides.css** - CSS override cho compatibility

### PHP Files
1. **pages/header-premium.php** - Header component cao cấp
2. **pages/main/index-premium.php** - Trang chủ cao cấp
3. **pages/slideimg-premium.php** - Slide premium (placeholder)

## 🎯 Tính Năng Mới

### 1. Hero Section
- Banner hero lớn với gradient background
- Typography hiện đại, font size lớn
- Call-to-action buttons nổi bật
- Responsive hoàn toàn

### 2. Featured Categories
- Grid layout 3 cột
- Hover effects mượt mà
- Overlay gradient
- Category count display

### 3. Products Grid
- Grid 4 cột responsive
- Product cards cao cấp
- Badge "Mới" / "Hết hàng"
- Rating stars
- Price với giá cũ gạch ngang
- Hover actions (yêu thích, xem nhanh)
- Animation khi scroll

### 4. Brand Story Section
- 2 cột layout
- Brand features grid
- Icons với màu đỏ
- Typography chuyên nghiệp

### 5. Newsletter Section
- Background đen
- Email subscription form
- Modern input design

### 6. Header Premium
- **Top Bar**: Thông tin liên hệ, social links
- **Main Header**: 
  - Logo với hover effect
  - Search bar với border-radius tròn
  - Hotline button
  - User dropdown menu cao cấp
  - Shopping cart với số lượng
  - Sticky header khi scroll
  - Scroll effects

### 7. Menu Premium
- Menu ngang hiện đại
- Underline animation khi hover
- Dropdown submenu
- Mobile drawer với overlay
- Smooth transitions

## 🎨 Design Elements

### Colors
- Primary Red: `#DC0021`
- Dark Red: `#A90019`
- White: `#FFFFFF`
- Black: `#000000`
- Light Gray: `#F8F8F8`

### Typography
- Font chính: **Inter**
- Font sizes: 72px (Hero), 48px (Sections), 18-22px (Body)
- Letter spacing: -2px đến 3px tùy context
- Font weights: 400, 500, 600, 700

### Spacing
- Container max-width: **1400px**
- Padding: **60px** (desktop), **20px** (mobile)
- Section padding: **100px** vertical
- Grid gaps: **30px**

### Effects
- **Transitions**: 0.3s - 0.6s ease
- **Hover transforms**: translateY(-8px)
- **Box shadows**: 0 20px 40px rgba(0,0,0,0.1)
- **Border radius**: 12px - 24px

## 📱 Responsive Breakpoints

```css
- Desktop: > 1200px (full layout)
- Tablet: 992px - 1200px (3 columns)
- Mobile: 768px - 992px (2 columns)
- Small Mobile: < 768px (1 column)
```

## 🔧 Cách Sử Dụng

### Trang chủ sẽ tự động dùng premium design
- File `index.php` đã được cập nhật
- Class `premium-home` tự động thêm khi ở trang chủ
- Header premium áp dụng cho TẤT CẢ trang

### Thêm ảnh sản phẩm
1. Thay thế placeholder images trong:
   - `images/banner3.avif`
   - `images/banner6.jpg`
   - `images/banner7.jpg`

2. Upload ảnh sản phẩm vào:
   - `admincp/modules/quanLySanPham/uploads/`

### Customize colors
Sửa trong các file CSS premium:
```css
:root {
    --primary-red: #DC0021;
    --dark-red: #A90019;
    /* ... */
}
```

## ✅ Checklist Hoàn Thành

- [x] Hero section với CTA buttons
- [x] Featured categories grid
- [x] Premium product cards
- [x] Brand story section
- [x] Newsletter section
- [x] Premium header
- [x] Premium menu
- [x] Responsive design
- [x] Hover effects & animations
- [x] Mobile drawer menu
- [x] Scroll effects

## 🎯 Bước Tiếp Theo

1. **Thêm ảnh thực tế**
   - Hero background image
   - Category images
   - Product images
   - Brand story image

2. **Tùy chỉnh nội dung**
   - Hero title & description
   - Brand story text
   - Newsletter text

3. **Test responsive**
   - Kiểm tra trên mobile
   - Kiểm tra trên tablet
   - Fix layout nếu cần

4. **Optimize performance**
   - Compress images
   - Lazy loading
   - Minify CSS

## 📝 Notes

- Giữ nguyên file cũ (header.php, index.php trong main/) để backup
- Premium design chỉ áp dụng cho trang chủ
- Các trang khác vẫn dùng layout cũ (có thể nâng cấp sau)
- Responsive hoàn toàn từ 320px - 1920px+

---

**Designed with ❤️ for 7TCC**
