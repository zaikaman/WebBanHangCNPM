# Triển khai Web lên Heroku (Hướng dẫn cho dự án PHP)

Tệp này mô tả các bước để tải toàn bộ website PHP (mã nguồn trong repo này) lên Heroku. Hướng dẫn bằng tiếng Việt, kèm các lệnh cho PowerShell (`pwsh`).

**Tóm tắt**
- Heroku hỗ trợ ứng dụng PHP qua buildpack PHP (dò bằng `composer.json`).
- Tạo `Procfile` để chỉ định web server (`heroku-php-apache2` hoặc `heroku-php-nginx`).
- Nếu trang dùng MySQL, cần thêm add-on MySQL (ClearDB / JawsDB) hoặc kết nối DB bên ngoài; lưu ý filesystem dyno là tạm (uploads sẽ biến mất).

**Yêu cầu trước khi bắt đầu**
- Tài khoản Heroku (https://heroku.com)
- Cài Heroku CLI (https://devcenter.heroku.com/articles/heroku-cli)
- Git và repo đã commit (nếu chưa có git, khởi tạo dưới hướng dẫn)
- (Tuỳ chọn) chuẩn hoá cấu hình database để đọc từ biến môi trường

---

**1) Chuẩn bị repo**
- Đảm bảo có `composer.json` ở gốc (repo này có sẵn). Heroku phát hiện ứng dụng PHP dựa trên tệp này.
- Tạo `Procfile` ở gốc (nội dung mẫu bên dưới). Procfile nói Heroku dùng Apache để phục vụ thư mục gốc.

**Procfile mẫu**
```
web: heroku-php-apache2 .
```

(Hoặc nếu bạn muốn dùng Nginx: `web: heroku-php-nginx .`)

---

**2) Các lệnh PowerShell (đưa lên Heroku)**
- Đăng nhập Heroku CLI:

```powershell
heroku login
```

- Trong thư mục dự án (gốc chứa `composer.json`, `index.php`):

```powershell
# Nếu repo chưa là git
git init
git add .
git commit -m "Prepare app for Heroku"

# Tạo app trên Heroku (tự động đặt tên ngẫu nhiên), hoặc dùng tên riêng
heroku create my-app-name
# hoặc để Heroku chọn tên:
# heroku create

# Kéo thay đổi lên Heroku (branch chính là 'main' hoặc 'master')
git push heroku main
# Nếu branch tên khác:
# git push heroku your-branch:main

# Mở website
heroku open
```

- Nếu cần xem log khi có lỗi:

```powershell
heroku logs --tail
```

---

**3) Cấu hình biến môi trường & database**
- Nếu ứng dụng dùng MySQL, dùng add-on ClearDB hoặc JawsDB:

```powershell
# Thêm ClearDB (ví dụ)
heroku addons:create cleardb:ignite
# Lấy URL kết nối
heroku config | Select-String CLEARDB_DATABASE_URL
```

- Heroku lưu URL kết nối MySQL trong biến `CLEARDB_DATABASE_URL`. Bạn cần cập nhật file cấu hình PHP để phân tích URL này và thiết lập host/user/password/db. Ví dụ PHP để parse:

```php
// ví dụ lấy CLEARDB_DATABASE_URL
$cleardb_url = getenv('CLEARDB_DATABASE_URL');
if ($cleardb_url) {
    $url = parse_url($cleardb_url);
    $db_host = $url['host'];
    $db_user = $url['user'];
    $db_pass = $url['pass'];
    $db_name = substr($url['path'], 1);
    // gán vào config của bạn
}
```

- Hoặc đặt biến môi trường tuỳ biến:

```powershell
heroku config:set DB_HOST=... DB_DATABASE=... DB_USERNAME=... DB_PASSWORD=...
```

Rồi trong PHP đọc `getenv('DB_HOST')` v.v.

---

**4) Lưu ý về lưu trữ file tĩnh & uploads**
- Dyno của Heroku có filesystem tạm: bất kỳ file upload nào lưu trên dyno sẽ bị mất khi dyno restart hoặc deploy mới.
- Giải pháp: dùng external storage (Amazon S3, Cloudinary, v.v.) và sửa code upload để lưu trên đó.
- Tạm thời, nếu bạn chỉ deploy tĩnh (các file `images/` đã có trong repo), chúng sẽ được phục vụ nhưng không thể dùng để lưu uploads runtime.

---

**5) HTTPS, domain, và môi trường**
- Heroku cung cấp HTTPS mặc định cho appname.herokuapp.com.
- Thêm domain riêng trong dashboard hoặc `heroku domains:add yourdomain.com`.

**6) Một số lỗi phổ biến & cách kiểm tra**
- 500 lỗi: xem `heroku logs --tail` để biết chi tiết. Thông thường do thiếu ext PHP (ví dụ ext-mysqli) hoặc lỗi kết nối DB.
- Composer dependencies không cài: kiểm tra `composer.json` và đảm bảo không dùng các path-local packages.

---

**7) Gợi ý cấu hình `composer.json` (nếu muốn ép PHP version)**
- Để yêu cầu phiên bản PHP, thêm trong `composer.json`:

```json
"require": {
  "php": "^8.0"
}
```

Heroku sẽ sử dụng phiên bản PHP tương thích.

---

**Tóm tắt ngắn**
- Tạo `Procfile` với `web: heroku-php-apache2 .` ở gốc repo.
- Commit, tạo app Heroku, push lên Heroku bằng `git push heroku main`.
- Cấu hình DB thông qua add-on hoặc `heroku config:set` và cập nhật code đọc biến môi trường.
- Di chuyển upload sang S3 nếu cần lưu bền.

---

Nếu bạn muốn, tôi có thể:
- Tạo `Procfile` cho bạn (tôi đã tạo file mẫu `Procfile`).
- Thêm mẫu đoạn code PHP để parse `CLEARDB_DATABASE_URL` vào `config/env_helper.php` nếu bạn muốn (tự động kết nối từ biến môi trường).

