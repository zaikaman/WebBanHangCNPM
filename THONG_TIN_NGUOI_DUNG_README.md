# Trang Thông Tin Người Dùng - Hướng Dẫn Sử Dụng

## Tổng Quan
Trang thông tin người dùng cho phép khách hàng đã đăng nhập xem và chỉnh sửa thông tin cá nhân của họ. Trang này tập trung vào việc quản lý thông tin cá nhân với giao diện hiện đại, màu chủ đạo đỏ và trắng.

### Tính năng chính:
1. **Thông tin cá nhân** - Xem và chỉnh sửa thông tin cơ bản
2. **Thao tác nhanh** - Liên kết đến các trang khác (đổi mật khẩu, lịch sử đơn hàng)

## Cách Truy Cập
- **URL**: `index.php?quanly=thongtinnguoidung`
- **Menu**: Sau khi đăng nhập → Click vào tên người dùng → Chọn "Thông tin cá nhân"

## Tính Năng Chi Tiết

### 1. Thông Tin Cá Nhân
**Các trường có thể chỉnh sửa:**
- Họ và tên (`ten_khachhang`)
- Email (`email`) 
- Số điện thoại (`dien_thoai`)
- Địa chỉ (`dia_chi`)

**Validation:**
- Email phải đúng định dạng
- Số điện thoại phải có 10-11 chữ số
- Email không được trùng với tài khoản khác
- Tất cả trường đều bắt buộc

### 2. Thao Tác Nhanh
**Các liên kết nhanh:**
- **Đổi mật khẩu**: Chuyển đến trang đổi mật khẩu riêng
- **Lịch sử đơn hàng**: Xem lịch sử đơn hàng chi tiết
- **Đơn hàng của tôi**: Quản lý đơn hàng hiện tại

## Thiết Kế Giao Diện

### Màu Sắc Chủ Đạo
- **Màu đỏ**: `#dc3545` (Bootstrap danger) - Dùng cho header, buttons, icons
- **Màu trắng**: `#ffffff` - Background chính
- **Màu xám nhạt**: `#f8f9fa` - Background phụ

### Layout
- **Header**: Gradient đỏ với avatar và tiêu đề
- **Form**: Grid layout 2 cột, responsive
- **Buttons**: Gradient đỏ cho nút chính, outline cho nút phụ
- **Quick Actions**: Card layout với icons

## Cấu Trúc Database Liên Quan

### Bảng `tbl_dangky` (Thông tin người dùng)
```sql
- id_dangky (Primary Key)
- ten_khachhang (Họ tên)
- email (Email)
- dia_chi (Địa chỉ)  
- mat_khau (Mật khẩu - MD5)
- dien_thoai (Số điện thoại)
```

## Bảo Mật
- Kiểm tra session đăng nhập trước khi truy cập
- Sử dụng `mysqli_real_escape_string()` để tránh SQL injection
- Validation dữ liệu đầu vào
- Mã hóa mật khẩu bằng MD5

## Responsive Design
- **Desktop**: Grid 2 cột cho form
- **Tablet**: Grid 1 cột, header flex column
- **Mobile**: Full responsive, padding điều chỉnh

## Files Liên Quan
- `pages/main/thongtinnguoidung.php` - File chính
- `pages/main.php` - Router (đã thêm route)
- `pages/header.php` - Menu dropdown (đã thêm link)
- `index.php` - Thêm Font Awesome

## Cách Sử Dụng
1. Người dùng phải đăng nhập trước
2. Click vào tên người dùng ở header
3. Chọn "Thông tin cá nhân" từ dropdown
4. Chỉnh sửa thông tin trong form
5. Click "Lưu thay đổi" để cập nhật
6. Click "Hủy bỏ" để reset form về trạng thái ban đầu

## Thông Báo Lỗi/Thành Công
- **Thành công**: Background xanh lá với icon check-circle
- **Lỗi**: Background đỏ nhạt với icon exclamation-triangle
- **Validation**: Border đỏ/xanh cho input fields

## JavaScript Features
- **Real-time validation**: Email và số điện thoại
- **Form reset**: Nút hủy bỏ reset form và border colors
- **Submit validation**: Kiểm tra trước khi gửi form
- **Responsive**: Tự động điều chỉnh layout

## Cải Tiến So Với Phiên Bản Cũ
- ✅ Bỏ tab navigation, tập trung vào thông tin cá nhân
- ✅ Thiết kế mới với màu đỏ-trắng
- ✅ Layout grid hiện đại
- ✅ Quick actions thay vì tabs riêng biệt
- ✅ Validation UX tốt hơn
- ✅ Responsive design cải thiện