# Hướng dẫn chuyển đổi từ Brevo sang PHPMailer

## ✅ Đã hoàn thành

Hệ thống đã được chuyển đổi thành công từ **Brevo** sang **PHPMailer** để gửi email xác nhận đơn hàng.

## 📋 Các thay đổi đã thực hiện

### 1. Cập nhật class Mailer (`mail/sendmail.php`)
- ✅ Thêm method `sendOrderConfirmation()` để gửi email xác nhận đơn hàng
- ✅ Thêm method `getOrderConfirmationTemplate()` để tạo template HTML email đẹp
- ✅ Cập nhật `getMailConfig()` để sử dụng cấu hình từ file `.env`
- ✅ Cải thiện template email với styling CSS chuyên nghiệp

### 2. Cập nhật file thanh toán (`pages/main/thanhtoan.php`)
- ✅ Loại bỏ code Brevo (API key, cURL requests)
- ✅ Thay thế bằng PHPMailer với class Mailer
- ✅ Tối ưu hóa code và cải thiện error handling
- ✅ Đảm bảo chỉ xóa giỏ hàng khi gửi email thành công

### 3. Cấu hình email (`.env`)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=thinhgpt1706@gmail.com
MAIL_PASSWORD="ugmz jado thur fzdb"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=thinhgpt1706@gmail.com
MAIL_FROM_NAME="7TCC Store"
```

## 🚀 Cách sử dụng

### 1. Test email
Truy cập: `http://localhost/WebBanHangCNPM/pages/main/test_email.php`
- Sửa email test trong file để nhận email thử nghiệm
- Kiểm tra xem email có được gửi thành công không

### 2. Sử dụng trong production
- Email sẽ tự động được gửi khi khách hàng đặt hàng thành công
- Áp dụng cho tất cả phương thức thanh toán: tiền mặt, chuyển khoản, VNPay, MoMo

## 📧 Template email mới

### Tính năng:
- **Design đẹp**: Header màu đỏ với logo 7TCC
- **Responsive**: Hiển thị tốt trên mobile và desktop  
- **Chi tiết đầy đủ**: Bảng sản phẩm, giá, số lượng, tổng tiền
- **Thông tin liên hệ**: Email và hotline hỗ trợ
- **Branding**: Thống nhất với thương hiệu 7TCC

### Nội dung email gồm:
- Lời chào và cảm ơn khách hàng
- Mã đơn hàng duy nhất
- Bảng chi tiết sản phẩm đã đặt
- Tổng tiền đơn hàng
- Thông tin liên hệ hỗ trợ

## 🔧 Cấu hình SMTP

### Gmail Setup:
1. Bật 2-Step Verification trong Gmail
2. Tạo App Password: `Google Account > Security > App passwords`
3. Cập nhật thông tin trong file `.env`:
   - `MAIL_USERNAME`: Email Gmail của bạn
   - `MAIL_PASSWORD`: App password (không phải mật khẩu Gmail)

### Các SMTP provider khác:
Bạn có thể dễ dàng thay đổi sang Outlook, Yahoo, hay SMTP server khác bằng cách cập nhật file `.env`:

```env
# Outlook/Hotmail
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587

# Yahoo
MAIL_HOST=smtp.mail.yahoo.com  
MAIL_PORT=587

# Custom SMTP
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
```

## 🐛 Troubleshooting

### Lỗi thường gặp:

1. **"SMTP Error: Could not authenticate"**
   - Kiểm tra username/password trong `.env`
   - Đảm bảo đã bật App Password cho Gmail

2. **"SMTP connect() failed"**
   - Kiểm tra MAIL_HOST và MAIL_PORT
   - Đảm bảo server có thể kết nối internet

3. **Email không được gửi**
   - Kiểm tra log file: `pages/main/php-email-error.log`
   - Kiểm tra folder spam của người nhận

### Debug:
- Bật debug mode trong PHPMailer để xem chi tiết lỗi
- Kiểm tra log files để theo dõi quá trình gửi email

## 📝 Lưu ý quan trọng

1. **Bảo mật**: Không commit file `.env` lên git
2. **Performance**: PHPMailer nhanh hơn và ổn định hơn API calls
3. **Reliability**: Ít phụ thuộc vào dịch vụ bên thứ 3
4. **Cost**: Không tốn phí như các dịch vụ email marketing

## 🎯 Lợi ích của việc chuyển đổi

✅ **Tốc độ**: Gửi email nhanh hơn qua SMTP trực tiếp  
✅ **Độ tin cậy**: Ít lỗi hơn, không phụ thuộc API bên ngoài  
✅ **Chi phí**: Miễn phí hoàn toàn  
✅ **Tùy biến**: Dễ dàng thay đổi template và cấu hình  
✅ **Bảo mật**: Kiểm soát hoàn toàn dữ liệu email  
✅ **Scalability**: Dễ dàng mở rộng và bảo trì  

---

**🎉 Chúc mừng! Hệ thống email của bạn đã được nâng cấp thành công!**
