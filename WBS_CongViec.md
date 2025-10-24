**WBS Công Việc - Dự án Website bán quần áo thể thao (WebBanHangCNPM)**

Mục tiêu: Phân rã công việc (Work Breakdown Structure - WBS) theo công việc (tasks) để giao, ước lượng và theo dõi tiến độ. Mỗi work package kèm mapping tới file/folder liên quan trong codebase để dễ đánh giá effort.

1. Quản lý dự án
 - 1.1 Lập kế hoạch dự án: timeline, milestones, WBS chi tiết (file: tài liệu nhóm)
 - 1.2 Họp kick-off và phân công
 - 1.3 Báo cáo tiến độ

2. Phân tích & Thiết kế
 - 2.1 Phân tích yêu cầu: rà soát hiện trạng (tham khảo `webbanhang_cnpm.sql`, `pages/`)
 - 2.2 Thiết kế kiến trúc hệ thống: mô tả endpoints, DB changes (tham khảo `src/`, `vendor/`, `webbanhang_cnpm.sql`)
 - 2.3 Thiết kế giao diện (UI/UX): mockups, responsive

3. Phát triển Backend
 - 3.1 Thiết lập môi trường dev & cấu hình (PHP, Composer, DB)
 - 3.2 API & Xử lý dữ liệu
   - 3.2.1 Đăng nhập/Đăng ký/Quản lý người dùng — relevant files: `includes/`, `pages/` (login/register xử lý), `webbanhang_cnpm.sql` (bảng `tbl_khachhang`, `tbl_admin`)
   - 3.2.2 Giỏ hàng & Hoá đơn — files: `js/giohang.js`, `pages/xuLyThanhToanMomo.php`, `sql` tables `tbl_giohangtam`, `tbl_hoadon`
   - 3.2.3 Thanh toán (MoMo, VNPAY) — files: `pages/xuLyThanhToanMomo.php`, `webbanhang_cnpm.sql` (tbl_momo, tbl_vnpay), `pages/xuLyThanhToanMomo.php`
   - 3.2.4 Xử lý sản phẩm/catalog — files: `pages/`, `js/sanpham.js`, `sql` tables `tbl_sanpham`, `tbl_sanpham_sizes`
   - 3.2.5 Chat & hỗ trợ khách hàng — files: `api/chat.php`, `js/chat.js`, DB `tbl_chat_history`
   - 3.2.6 Email gửi xác nhận/khôi phục mật khẩu — files: `mail/sendmail.php`, `mail/PHPMailer/`

 - 3.3 Admin Backend
   - 3.3.1 Quản lý sản phẩm/size/danh mục — folder: `admincp/`, `modules/` (admin management)
   - 3.3.2 Quản lý đơn hàng & thống kê — files: `admincp/`, `modules/thongke.php`, DB `tbl_hoadon`, `tbl_thongke`

4. Phát triển Frontend
 - 4.1 Trang chủ, menu, slide — files: `pages/main/`, `pages/slideimg.php`, `css/`, `js/script.js`
 - 4.2 Trang sản phẩm & chi tiết — files: `pages/`, `js/sanpham.js`, `images/`
 - 4.3 Giỏ hàng & checkout flow — files: `js/giohang.js`, `pages/xuLyThanhToanMomo.php`, `css/giohang.css`
 - 4.4 Người dùng: profile, lịch sử đặt hàng — files: `pages/xemdonhang.php`, `pages/thongtinnguoidung.php`, `css/thongtinnguoidung.css`

5. Kiểm thử (Testing)
 - 5.1 Unit / tích hợp backend: test endpoints, DB migrations
 - 5.2 Test chức năng thanh toán (MoMo/VNPAY): test success/fail/callback
 - 5.3 Test UI/UX & responsive trên nhiều thiết bị
 - 5.4 Kiểm thử bảo mật cơ bản: SQL injection, XSS, CSRF trên các trang nhập liệu

6. Triển khai (Deployment)
 - 6.1 Chuẩn bị tài liệu deploy & scripts (`deploy.sh`, `deploy.ps1` có trong repo)
 - 6.2 Thiết lập DB prod (import `webbanhang_cnpm.sql`)
 - 6.3 Kiểm tra môi trường production

7. Tài liệu & Bảo trì
 - 7.1 Viết README vận hành (cấu hình .env, composer install, import DB)
 - 7.2 Hướng dẫn chạy dev server và test
 - 7.3 Hướng dẫn xử lý sự cố thanh toán và logs

8. Mapping Work Packages (chi tiết công việc có thể giao cho 1 dev hoặc nhóm nhỏ)
 - WP-1: Chuẩn bị môi trường dev (1.1, 3.1)
 - WP-2: Đăng nhập/Đăng ký + session (3.2.1) — files: `admincp/login.php`, `admincp/logout.php`, `pages/` auth handlers
 - WP-3: Giỏ hàng + lưu tạm (3.2.2) — files: `js/giohang.js`, DB `tbl_giohangtam`
 - WP-4: Thanh toán MoMo (3.2.3) — files: `pages/xuLyThanhToanMomo.php`, DB `tbl_momo`
 - WP-5: Quản lý sản phẩm (3.2.4 & 3.3.1) — files: `modules/`, `admincp/` CRUD
 - WP-6: Chat & scripts (3.2.5) — files: `api/chat.php`, `js/chat_new.js` / `js/chat.js`
 - WP-7: Email & reset password (3.2.6) — files: `mail/`, `pages/quenmatkhau.php`
 - WP-8: Kiểm thử chức năng (5.x) — test cases cho WP2-WP7
 - WP-9: Triển khai & scripts (6.x)

Ghi chú:
- File/Folder nêu trên là ví dụ mapping nhanh dựa trên cấu trúc repo. Có thể cần rà soát chi tiết từng file khi ước lượng effort.
- Nếu bạn cần WBS công việc chuyển thành bảng (task, owner, estimate, phụ thuộc) mình sẽ tạo file `WBS_CongViec.csv` hoặc `WBS_CongViec.xlsx` tiếp theo.

-- Hết --
