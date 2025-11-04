-- ========================================
-- Tạo bảng khuyến mãi cho sản phẩm
-- ========================================

-- Bảng khuyến mãi
CREATE TABLE `tbl_khuyenmai` (
  `id_km` int(11) NOT NULL AUTO_INCREMENT,
  `ten_km` varchar(255) NOT NULL COMMENT 'Tên chương trình khuyến mãi',
  `mo_ta` text DEFAULT NULL COMMENT 'Mô tả chi tiết',
  `loai_km` enum('phan_tram','tien_mat','gia_moi') NOT NULL COMMENT 'Loại: phần trăm, tiền mặt, giá mới',
  `gia_tri_km` decimal(10,2) NOT NULL COMMENT 'Giá trị khuyến mãi',
  `ngay_bat_dau` datetime NOT NULL,
  `ngay_ket_thuc` datetime NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Kích hoạt, 0: Tắt',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_km`),
  KEY `idx_ngay` (`ngay_bat_dau`, `ngay_ket_thuc`),
  KEY `idx_trang_thai` (`trang_thai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Bảng quản lý khuyến mãi';

-- Bảng liên kết khuyến mãi với sản phẩm
CREATE TABLE `tbl_sanpham_khuyenmai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sp` int(11) NOT NULL COMMENT 'ID sản phẩm',
  `id_km` int(11) NOT NULL COMMENT 'ID khuyến mãi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_product_promotion` (`id_sp`, `id_km`),
  KEY `fk_sp` (`id_sp`),
  KEY `fk_km` (`id_km`),
  CONSTRAINT `fk_km` FOREIGN KEY (`id_km`) REFERENCES `tbl_khuyenmai` (`id_km`) ON DELETE CASCADE,
  CONSTRAINT `fk_sp` FOREIGN KEY (`id_sp`) REFERENCES `tbl_sanpham` (`id_sp`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Bảng liên kết sản phẩm và khuyến mãi';

-- Insert dữ liệu mẫu
INSERT INTO `tbl_khuyenmai` (`ten_km`, `mo_ta`, `loai_km`, `gia_tri_km`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
('Giảm 20% mùa World Cup', 'Giảm giá 20% cho tất cả áo bóng đá nhân dịp World Cup', 'phan_tram', 20.00, '2025-11-01 00:00:00', '2025-12-31 23:59:59', 1),
('Flash Sale 50K', 'Giảm ngay 50,000đ cho đơn hàng từ 300,000đ', 'tien_mat', 50000.00, '2025-11-04 00:00:00', '2025-11-10 23:59:59', 1),
('Giá đặc biệt áo MU', 'Giá ưu đãi đặc biệt chỉ 299,000đ', 'gia_moi', 299000.00, '2025-11-04 00:00:00', '2025-11-30 23:59:59', 1);

-- Áp dụng khuyến mãi cho một số sản phẩm mẫu
-- Giảm 20% cho các áo bóng đá
INSERT INTO `tbl_sanpham_khuyenmai` (`id_sp`, `id_km`) 
SELECT id_sp, 1 FROM tbl_sanpham WHERE id_dm = 65 LIMIT 5;

-- Giá đặc biệt cho áo MU (id_sp = 150)
INSERT INTO `tbl_sanpham_khuyenmai` (`id_sp`, `id_km`) VALUES (150, 3);

-- View để lấy thông tin sản phẩm kèm khuyến mãi (Optional - để query dễ hơn)
CREATE OR REPLACE VIEW `view_sanpham_khuyenmai` AS
SELECT 
    sp.*,
    km.id_km,
    km.ten_km,
    km.loai_km,
    km.gia_tri_km,
    km.ngay_bat_dau,
    km.ngay_ket_thuc,
    km.trang_thai as trang_thai_km,
    CASE 
        WHEN km.loai_km = 'phan_tram' THEN sp.gia_sp * (1 - km.gia_tri_km/100)
        WHEN km.loai_km = 'tien_mat' THEN sp.gia_sp - km.gia_tri_km
        WHEN km.loai_km = 'gia_moi' THEN km.gia_tri_km
        ELSE sp.gia_sp
    END as gia_sau_km
FROM tbl_sanpham sp
LEFT JOIN tbl_sanpham_khuyenmai spkm ON sp.id_sp = spkm.id_sp
LEFT JOIN tbl_khuyenmai km ON spkm.id_km = km.id_km 
    AND km.trang_thai = 1 
    AND NOW() BETWEEN km.ngay_bat_dau AND km.ngay_ket_thuc;
