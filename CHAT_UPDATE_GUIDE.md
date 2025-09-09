# Hướng dẫn sử dụng tính năng Chat AI mới

## Các tính năng đã được cải thiện:

### 1. **Lưu trữ lịch sử chat**
- Chat sẽ được lưu lại ngay cả khi bạn chuyển trang hoặc đóng/mở lại trình duyệt
- Lịch sử chat được lưu trữ cả ở phía client (localStorage) và server (database)

### 2. **Nút "Cuộc trò chuyện mới"**
- Có nút "+" ở góc trên bên phải của chat box
- Click vào để bắt đầu cuộc trò chuyện mới
- Sẽ có xác nhận trước khi xóa lịch sử chat hiện tại

### 3. **Session Management**
- Mỗi phiên chat có một session ID riêng
- Chat sẽ được nhóm theo session để quản lý tốt hơn

## Cách hoạt động:

1. **Lần đầu mở chat**: Hệ thống tạo session ID mới và hiển thị tin nhắn chào mừng
2. **Chuyển trang**: Chat history vẫn được giữ nguyên
3. **Đóng/mở trình duyệt**: Lịch sử chat vẫn được khôi phục
4. **Nhấn "Cuộc trò chuyện mới"**: Xóa toàn bộ lịch sử và bắt đầu session mới

## Cập nhật Database:

Đã thêm cột `session_id` vào bảng `tbl_chat_history`:
- Kiểu dữ liệu: VARCHAR(100)
- Có thể NULL (cho dữ liệu cũ)
- Có index để tăng hiệu suất

## Files đã được cập nhật:

1. **js/chat.js** - Thêm logic lưu/load state chat
2. **api/chat.php** - Hỗ trợ session ID
3. **css/chat.css** - Style cho nút "Cuộc trò chuyện mới"  
4. **index.php** - Thêm nút "Cuộc trò chuyện mới"
5. **sql.sql** - Cập nhật cấu trúc database

## Lưu ý:

- Chat history được lưu trong localStorage với key: `chatHistory_[sessionId]`
- Session ID được lưu trong localStorage với key: `chatSessionId`
- Dữ liệu localStorage sẽ tự động dọn dẹp khi tạo cuộc trò chuyện mới
