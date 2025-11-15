-- Thêm 2 trường ảnh mới vào bảng tbl_sanpham
ALTER TABLE `tbl_sanpham` 
ADD COLUMN `hinh_anh_2` VARCHAR(50) NULL AFTER `hinh_anh`,
ADD COLUMN `hinh_anh_3` VARCHAR(50) NULL AFTER `hinh_anh_2`;

-- Cập nhật comment cho các cột
ALTER TABLE `tbl_sanpham` 
MODIFY COLUMN `hinh_anh` VARCHAR(50) NOT NULL COMMENT 'Ảnh chính',
MODIFY COLUMN `hinh_anh_2` VARCHAR(50) NULL COMMENT 'Ảnh phụ 1',
MODIFY COLUMN `hinh_anh_3` VARCHAR(50) NULL COMMENT 'Ảnh phụ 2';
