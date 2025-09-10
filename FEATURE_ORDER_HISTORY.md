# Tính Năng Lịch Sử Đơn Hàng - 7TCC

## Tổng Quan
Tính năng lịch sử đơn hàng cho phép khách hàng đã đăng nhập xem và quản lý tất cả các đơn hàng của họ một cách dễ dàng.

## Các Tính Năng Chính

### 1. Xem Lịch Sử Đơn Hàng
- **Đường dẫn**: `index.php?quanly=lichSuDonHang`
- **Yêu cầu**: Người dùng phải đăng nhập
- **Hiển thị**:
  - Ngày đặt hàng (định dạng dd/mm/yyyy hh:mm)
  - Mã đơn hàng
  - Địa chỉ giao hàng
  - Phương thức thanh toán (với biểu tượng):
    - 💵 Tiền mặt
    - 🏦 Chuyển khoản  
    - 📱 MoMo
    - 💳 VNPay
  - Trạng thái đơn hàng:
    - 🟡 Đang xử lý
    - 🟢 Đã giao hàng
  - Nút xem chi tiết và in đơn hàng

### 2. Xem Chi Tiết Đơn Hàng
- **Đường dẫn**: `index.php?quanly=xemDonHang&code=[mã_đơn_hàng]`
- **Hiển thị**:
  - Thông tin đơn hàng: ngày đặt, phương thức thanh toán, trạng thái
  - Thông tin giao hàng: địa chỉ, người nhận, số điện thoại
  - Chi tiết sản phẩm: tên, mã, số lượng, đơn giá, thành tiền
  - Tổng tiền đơn hàng

### 3. In Đơn Hàng
- **Đường dẫn**: `pages/main/indonhang.php?code=[mã_đơn_hàng]`
- Mở trong tab mới để in hoặc lưu PDF

## Cách Truy Cập

### Cho Người Dùng Đã Đăng Nhập:
1. **Menu chính**: Nhấp vào "Lịch sử đơn hàng" trong menu điều hướng
2. **Dropdown tài khoản**: Nhấp vào tên tài khoản → chọn "Lịch sử đơn hàng"
3. **URL trực tiếp**: Truy cập `index.php?quanly=lichSuDonHang`

### Cho Người Dùng Chưa Đăng Nhập:
- Hiển thị trang thông báo yêu cầu đăng nhập
- Cung cấp link đăng nhập và đăng ký
- Link quay về trang chủ

## Giao Diện Người Dùng

### Responsive Design
- Desktop: Hiển thị đầy đủ thông tin trong bảng
- Mobile: Menu hamburger với link lịch sử đơn hàng

### Bootstrap Styling
- Sử dụng Bootstrap 5 cho giao diện hiện đại
- Font Awesome icons cho biểu tượng trực quan
- Color coding cho trạng thái đơn hàng

### Empty State
- Hiển thị thông báo thân thiện khi chưa có đơn hàng
- Icon giỏ hàng lớn
- Nút "Bắt đầu mua sắm" dẫn về trang chủ

## Cấu Trúc Database

### Bảng Liên Quan:
- `tbl_hoadon`: Thông tin đơn hàng
- `tbl_chitiet_gh`: Chi tiết sản phẩm trong đơn hàng  
- `tbl_dangky`: Thông tin khách hàng
- `tbl_giaohang`: Thông tin giao hàng
- `tbl_sanpham`: Thông tin sản phẩm

### Query Chính:
```sql
SELECT * FROM tbl_hoadon, tbl_dangky 
WHERE tbl_hoadon.id_khachhang = '[id_khachhang]' 
AND tbl_dangky.id_dangky = '[id_khachhang]' 
ORDER BY tbl_hoadon.id_gh DESC
```

## Bảo Mật
- Kiểm tra session đăng nhập trước khi hiển thị
- Chỉ hiển thị đơn hàng của chính người dùng đó
- Sanitize input parameters để tránh SQL injection

## Tương Lai Phát Triển
- Thêm tính năng lọc đơn hàng theo trạng thái
- Tìm kiếm đơn hàng theo mã hoặc ngày
- Theo dõi vận chuyển chi tiết
- Đánh giá sản phẩm từ lịch sử đơn hàng
- Đặt lại đơn hàng cũ
