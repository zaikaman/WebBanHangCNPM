-- Bảng đánh giá sản phẩm
CREATE TABLE IF NOT EXISTS `tbl_danhgia_sp` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `id_sp` INT(11) NOT NULL,
    `id_dangky` INT(11) NOT NULL,
    `rating` INT(1) NOT NULL,
    `noi_dung` TEXT COLLATE utf8mb4_general_ci,
    `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `trang_thai` TINYINT(1) DEFAULT 1 COMMENT '0: ẩn, 1: hiển thị',
    PRIMARY KEY (`id`),
    KEY `idx_product` (`id_sp`),
    KEY `idx_customer` (`id_dangky`),
    KEY `idx_status` (`trang_thai`),
    CONSTRAINT `fk_danhgia_sanpham` FOREIGN KEY (`id_sp`) REFERENCES `tbl_sanpham` (`id_sp`) ON DELETE CASCADE,
    CONSTRAINT `fk_danhgia_khachhang` FOREIGN KEY (`id_dangky`) REFERENCES `tbl_dangky` (`id_dangky`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Thêm một số đánh giá mẫu cho sản phẩm (có thể bỏ qua nếu không cần)
-- INSERT INTO tbl_danhgia_sp (id_sp, id_dangky, rating, noi_dung, ngay_tao) VALUES
-- (140, 14, 5, 'Sản phẩm rất tốt, chất lượng vượt mong đợi!', NOW()),
-- (140, 27, 4, 'Đẹp, vải mềm mại. Giao hàng nhanh.', NOW()),
-- (141, 32, 5, 'Mua lần 2 rồi, rất hài lòng', NOW()),
-- (150, 33, 5, 'Áo đẹp lắm, chất liệu thoáng mát', NOW()),
-- (151, 34, 4, 'Đúng như mô tả, giao hàng nhanh', NOW());
