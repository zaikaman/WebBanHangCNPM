-- Thêm cột gia_mua vào bảng tbl_chitiet_gh để lưu giá tại thời điểm mua
ALTER TABLE `tbl_chitiet_gh` 
ADD COLUMN `gia_mua` DECIMAL(10,2) DEFAULT 0 AFTER `size`;

-- Cập nhật giá cho các đơn hàng cũ (lấy giá hiện tại từ tbl_sanpham)
UPDATE tbl_chitiet_gh c
INNER JOIN tbl_sanpham s ON c.id_sp = s.id_sp
SET c.gia_mua = s.gia_sp
WHERE c.gia_mua = 0 OR c.gia_mua IS NULL;
