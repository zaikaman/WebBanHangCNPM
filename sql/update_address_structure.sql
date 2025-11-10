-- Migration: Cập nhật cấu trúc địa chỉ
-- Thêm các cột mới cho Quận/Huyện và Tỉnh/Thành phố
-- Ngày: 2024-12-01

-- ===== Cập nhật bảng tbl_giaohang =====

-- Thêm 2 cột mới
ALTER TABLE `tbl_giaohang` 
ADD COLUMN `quan_huyen` VARCHAR(100) DEFAULT NULL AFTER `address`,
ADD COLUMN `tinh_thanh` VARCHAR(100) DEFAULT NULL AFTER `quan_huyen`;

-- Đổi tên cột address thành dia_chi_chi_tiet
ALTER TABLE `tbl_giaohang` 
CHANGE COLUMN `address` `dia_chi_chi_tiet` VARCHAR(200) NOT NULL;

-- ===== Cập nhật bảng tbl_dangky =====

-- Thêm 2 cột mới
ALTER TABLE `tbl_dangky` 
ADD COLUMN `quan_huyen` VARCHAR(100) DEFAULT NULL AFTER `dia_chi`,
ADD COLUMN `tinh_thanh` VARCHAR(100) DEFAULT NULL AFTER `quan_huyen`;

-- Đổi tên cột dia_chi thành dia_chi_chi_tiet  
ALTER TABLE `tbl_dangky` 
CHANGE COLUMN `dia_chi` `dia_chi_chi_tiet` VARCHAR(200) NOT NULL;

-- ===== Cập nhật bảng tbl_dangky_temp =====

-- Thêm 2 cột mới
ALTER TABLE `tbl_dangky_temp` 
ADD COLUMN `quan_huyen` VARCHAR(100) DEFAULT NULL AFTER `dia_chi`,
ADD COLUMN `tinh_thanh` VARCHAR(100) DEFAULT NULL AFTER `quan_huyen`;

-- Đổi tên cột dia_chi thành dia_chi_chi_tiet
ALTER TABLE `tbl_dangky_temp` 
CHANGE COLUMN `dia_chi` `dia_chi_chi_tiet` TEXT DEFAULT NULL;

-- ===== Cập nhật dữ liệu mẫu (Tùy chọn) =====
-- Có thể thêm logic để tách địa chỉ cũ thành 3 phần nếu cần
-- UPDATE tbl_giaohang SET 
--   tinh_thanh = 'TP.HCM',
--   quan_huyen = 'Quận 1'
-- WHERE id_shipping = 1;

COMMIT;
