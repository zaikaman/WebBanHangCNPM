-- Script để thêm cột size vào bảng tbl_chitiet_gh
-- Chạy script này trong phpMyAdmin hoặc MySQL console

-- Thêm cột size với giá trị mặc định là 'M'
ALTER TABLE `tbl_chitiet_gh` ADD COLUMN `size` VARCHAR(10) DEFAULT 'M' AFTER `so_luong_mua`;

-- Cập nhật dữ liệu mẫu cho các bản ghi hiện có (optional - chỉ để test)
UPDATE `tbl_chitiet_gh` SET `size` = 'L' WHERE `id_ctgh` IN (15, 17, 20, 29, 32, 36, 38, 42, 46, 49);
UPDATE `tbl_chitiet_gh` SET `size` = 'XL' WHERE `id_ctgh` IN (19, 22, 31, 37, 41, 47, 51, 57, 61, 67);
UPDATE `tbl_chitiet_gh` SET `size` = 'S' WHERE `id_ctgh` IN (27, 34, 44, 54, 64, 71, 81, 88, 95);
-- Các bản ghi còn lại sẽ giữ giá trị mặc định 'M'
