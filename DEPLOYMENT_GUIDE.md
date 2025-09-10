# InfinityFree Deployment Guide

## 📋 Hướng dẫn deploy lên InfinityFree

### Bước 1: Chuẩn bị trước khi deploy

1. **Tạo tài khoản InfinityFree**
   - Đăng ký tại: https://infinityfree.net/
   - Tạo subdomain hoặc domain của bạn

2. **Tạo database MySQL**
   - Vào Control Panel → MySQL Databases
   - Tạo database mới
   - Ghi lại thông tin: hostname, database name, username, password

### Bước 2: Cập nhật cấu hình

1. **Cập nhật file .env.production**
   ```env
   # Thay đổi các thông tin sau theo database của bạn:
   DB_HOST=sql000.infinityfree.com
   DB_DATABASE=if0_XXXXXXXX_webbanhang_cnpm
   DB_USERNAME=if0_XXXXXXXX
   DB_PASSWORD=your_database_password
   
   # Cập nhật domain của bạn:
   APP_URL=https://yourdomain.infinityfreeapp.com
   ```

2. **Import database**
   - Upload file `sql.sql` vào phpMyAdmin của InfinityFree
   - Hoặc chạy các câu lệnh SQL trực tiếp

### Bước 3: Upload files

1. **Files cần upload** (thông qua File Manager hoặc FTP):
   ```
   htdocs/
   ├── admincp/
   ├── api/
   ├── css/
   ├── js/
   ├── images/
   ├── pages/
   ├── mail/
   ├── vendor/
   ├── favicon_io/
   ├── tfpdf/
   ├── Carbon-3.8.0/
   ├── index.php
   ├── .htaccess
   ├── .env.production (đổi tên thành .env)
   └── sitemap.xml
   ```

2. **Files KHÔNG upload**:
   - `.env` (file local)
   - `composer.json`, `composer.lock`
   - `README.md`
   - `PHPMAILER_MIGRATION.md`
   - `CHAT_UPDATE_GUIDE.md`
   - `repomix-output.txt`
   - `sql.sql`

### Bước 4: Cấu hình sau khi upload

1. **Đổi tên file**:
   - Đổi `.env.production` thành `.env`

2. **Kiểm tra permissions**:
   - Các thư mục cần chmod 755
   - Các file PHP cần chmod 644

3. **Test website**:
   - Truy cập domain của bạn
   - Kiểm tra admin panel
   - Test các chức năng chính

### Bước 5: Cấu hình bảo mật

1. **Bật HTTPS**:
   - Uncomment dòng force HTTPS trong .htaccess
   - Kiểm tra SSL certificate

2. **Cấu hình email**:
   - Verify SMTP settings
   - Test gửi email

### Bước 6: Tối ưu hóa

1. **Cache configuration**:
   - File .htaccess đã có cấu hình cache
   - Kiểm tra compression

2. **Performance check**:
   - Test tốc độ loading
   - Optimize images nếu cần

## 🔧 Troubleshooting

### Lỗi thường gặp:

1. **Database connection error**:
   - Kiểm tra thông tin database trong .env
   - Verify hostname, username, password

2. **File permission errors**:
   - Chmod 755 cho thư mục
   - Chmod 644 cho file

3. **Email không gửi được**:
   - Kiểm tra SMTP settings
   - Verify Gmail app password

4. **CSS/JS không load**:
   - Kiểm tra đường dẫn tuyệt đối
   - Verify .htaccess rules

## 📞 Hỗ trợ

Nếu gặp vấn đề, hãy kiểm tra:
- Error logs trong Control Panel
- PHP error messages
- Browser console errors

## ✅ Checklist sau khi deploy

- [ ] Website load được
- [ ] Admin panel hoạt động
- [ ] Database kết nối thành công
- [ ] Email gửi được
- [ ] Payment gateway test
- [ ] HTTPS hoạt động
- [ ] Chatbot AI hoạt động
- [ ] All pages render correctly
