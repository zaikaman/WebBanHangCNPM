-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: gtizpe105piw2gfq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com
-- Generation Time: Nov 11, 2024 at 12:11 PM
-- Server version: 8.0.35
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kv0l93tcry5svq6w`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_ad` int NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `admin_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_ad`, `user_name`, `password`, `admin_status`) VALUES
(4, 'admin', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_baiviet`
--

CREATE TABLE `tbl_baiviet` (
  `id` int NOT NULL,
  `tenbaiviet` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tomtat` text COLLATE utf8mb4_general_ci,
  `noidung` longtext COLLATE utf8mb4_general_ci,
  `id_danhmuc` int NOT NULL,
  `tinhtrang` int NOT NULL,
  `hinhanh` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_baiviet`
--

INSERT INTO `tbl_baiviet` (`id`, `tenbaiviet`, `tomtat`, `noidung`, `id_danhmuc`, `tinhtrang`, `hinhanh`, `link`) VALUES
(2, 'MU chậm sa thải Ten Hag', 'Summary for MU chậm sa thải Ten Hag', 'Content for MU chậm sa thải Ten Hag', 14, 1, 'tin1.jpg', 'https://www.24h.com.vn/bong-da/nong-bang-xep-hang-ngoai-hang-anh-mu-te-nhat-lich-su-chelsea-lung-lay-top-4-c48a1608578.html'),
(3, 'BXH Ngoại hạng Anh: MU tệ nhất lịch sử, Chelsea lung lay top 4', 'Summary for BXH Ngoại hạng Anh', 'Content for BXH Ngoại hạng Anh', 14, 1, 'tin2.jpg', 'https://www.24h.com.vn/bong-da/ten-hag-biet-cui-dau-ai-da-cuu-thay-tam-song-sot-qua-giong-bao-c48a1608663.html'),
(4, 'Ten Hag cúi đầu: Ai đã cứu thầy tạm sống sót?', 'Summary for Ten Hag cúi đầu', 'Content for Ten Hag cúi đầu', 14, 1, 'tin3.jpg', 'https://www.24h.com.vn/bong-da/lewandowski-ghi-3-ban-dinh-cao-bat-kip-haaland-dua-chiec-giay-vang-c48a1608595.html'),
(5, 'Lewandowski ghi 3 bàn đỉnh cao, bắt kịp Haaland đua Chiếc Giày Vàng', 'Summary for Lewandowski', 'Content for Lewandowski', 14, 1, 'tin4.jpg', 'https://www.24h.com.vn/bong-da/xau-ho-dan-sao-mu-thua-ong-gia-36-tuoi-rashford-bi-nghi-noi-xau-ten-hag-c48a1608619.html'),
(6, 'Xấu hổ: Dàn sao MU thua ông già 36 tuổi, Rashford bị nghi nói xấu Ten Hag', 'Summary for MU thua ông già 36 tuổi', 'Content for MU thua ông già 36 tuổi', 14, 1, 'tin5.jpg', 'https://www.24h.com.vn/bong-da/video-bong-da-brighton-tottenham-hang-cong-thang-hoa-ngoai-hang-anh-c48a1608573.html'),
(8, 'Video bóng đá: Brighton - Tottenham, hàng công thăng hoa', 'Summary for Brighton vs Tottenham', 'Content for Brighton vs Tottenham', 14, 1, 'tin7.jpg', 'https://www.24h.com.vn/bong-da/video-bong-da-sociedad-atletico-alvarez-ghi-ban-giay-51-la-liga-c48a1608577.html'),
(9, 'Video futsal: Brazil - Argentina, đăng quang kịch tính chung kết Futsal World Cup', 'Summary for Brazil vs Argentina Futsal', 'Content for Brazil vs Argentina Futsal', 14, 1, 'tin8.jpg', 'https://www.24h.com.vn/bong-da/video-futsal-brazil-argentina-dang-quang-kich-tinh-chung-ket-futsal-world-cup-c48a1608596.html'),
(10, 'Video bóng đá: Sociedad - Atletico, Alvarez ghi bàn giây 51', 'Summary for Sociedad vs Atletico', 'Content for Sociedad vs Atletico', 14, 1, 'tin9.jpg', 'https://www.24h.com.vn/bong-da/video-bong-da-sociedad-atletico-alvarez-ghi-ban-giay-51-la-liga-c48a1608577.html');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cartsessions`
--

CREATE TABLE `tbl_cartsessions` (
  `id` int NOT NULL,
  `ten_sp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ma_sp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `gia` decimal(15,2) NOT NULL,
  `so_luong` int NOT NULL,
  `tong_tien` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cartsessions`
--

INSERT INTO `tbl_cartsessions` (`id`, `ten_sp`, `ma_sp`, `gia`, `so_luong`, `tong_tien`) VALUES
(1, 'Áo bóng rổ 5', 'br5', 300000.00, 1, 300000.00),
(2, 'Áo bóng rổ 5', 'br5', 300000.00, 1, 300000.00),
(3, 'Áo bóng rổ 4', 'br4', 300000.00, 1, 300000.00),
(4, 'Áo bóng rổ 2', 'br2', 300000.00, 1, 300000.00),
(5, 'Áo cầu lông 5', 'ynex5', 400000.00, 1, 400000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_history`
--

CREATE TABLE `tbl_chat_history` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `message` text NOT NULL,
  `response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_chat_history`
--

INSERT INTO `tbl_chat_history` (`id`, `user_id`, `message`, `response`, `created_at`) VALUES
(1, NULL, 'chào bạn, web này có tổng cộng bao nhiêu sản phẩm', 'Xin chào bạn, hiện tại website của 7TCC đang có 0 sản phẩm ạ.', '2024-11-11 12:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chitiet_gh`
--

CREATE TABLE `tbl_chitiet_gh` (
  `id_ctgh` int NOT NULL,
  `ma_gh` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_sp` int NOT NULL,
  `so_luong_mua` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chitiet_gh`
--

INSERT INTO `tbl_chitiet_gh` (`id_ctgh`, `ma_gh`, `id_sp`, `so_luong_mua`) VALUES
(14, '2946', 113, 1),
(15, '8262', 114, 1),
(16, '6879', 112, 1),
(17, '3410', 113, 2),
(18, '3410', 112, 2),
(19, '2870', 113, 2),
(20, '2870', 112, 2),
(21, '2870', 110, 3),
(22, '4500', 104, 10),
(23, '8654', 114, 2),
(26, '9405', 115, 5),
(27, '9886', 115, 1),
(28, '260', 116, 1),
(29, '7286', 116, 1),
(30, '9014', 115, 1),
(31, '9900', 116, 1),
(32, '963', 116, 1),
(33, '1412', 116, 1),
(34, '4051', 116, 1),
(35, '7050', 116, 1),
(36, '7411', 116, 1),
(37, '4146', 114, 1),
(38, '9023', 114, 1),
(39, '7587', 114, 1),
(40, '478', 114, 2),
(41, '2100', 128, 2),
(42, '1773', 128, 1),
(43, '9875', 128, 1),
(44, '6212', 128, 1),
(45, '5743', 128, 1),
(46, '9191', 128, 1),
(47, '9151', 128, 1),
(48, '6486', 126, 1),
(49, '8436', 136, 2),
(50, '7340', 137, 1),
(51, '4302', 136, 1),
(52, '6632', 136, 1),
(53, '843', 136, 1),
(54, '7748', 136, 1),
(55, '5935', 136, 1),
(56, '7220', 137, 1),
(57, '7679', 137, 1),
(58, '1535', 135, 1),
(59, '588', 136, 1),
(60, '5191', 116, 3),
(61, '5191', 137, 1),
(62, '3520', 135, 1),
(63, '8297', 136, 1),
(64, '2247', 136, 1),
(65, '8995', 132, 2),
(66, '7535', 137, 1),
(67, '8420', 132, 1),
(68, '5411', 137, 1),
(69, '5411', 125, 1),
(70, '8749', 136, 1),
(71, '8380', 136, 1),
(72, '7436', 136, 1),
(73, '4190', 136, 1),
(74, '6736', 135, 1),
(75, '5487', 136, 1),
(76, '7191', 137, 1),
(77, '8233', 131, 2),
(78, '45', 131, 1),
(79, '5781', 130, 1),
(80, '2948', 135, 1),
(81, '3494', 114, 2),
(82, '3494', 137, 1),
(83, '1839', 137, 1),
(84, '761', 137, 1),
(85, '4207', 137, 1),
(86, '8393', 137, 1),
(87, '4390', 137, 1),
(88, '8612', 137, 1),
(89, '2092', 137, 1),
(90, '4793', 137, 1),
(91, '8538', 137, 1),
(92, '4984', 137, 1),
(93, '3740', 137, 1),
(94, '4207', 137, 2),
(95, '2485', 137, 1),
(96, '7680', 137, 1),
(97, '671a414c4c19a', 136, 1),
(98, '671a4383ecb9b', 132, 1),
(99, '671a444debad2', 127, 1),
(100, '671a44cd85c83', 134, 1),
(101, '671a455319fee', 131, 1),
(102, '671a7a343d8e3', 137, 1),
(103, '672c69263562d', 137, 1),
(104, '7120', 137, 1),
(105, '4234', 127, 1),
(106, '9712', 134, 1),
(107, '7692', 130, 1),
(108, '672c792dd9fe3', 130, 2),
(109, '67315037b7010', 137, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dangky`
--

CREATE TABLE `tbl_dangky` (
  `id_dangky` int NOT NULL,
  `ten_khachhang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `mat_khau` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dien_thoai` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dangky`
--

INSERT INTO `tbl_dangky` (`id_dangky`, `ten_khachhang`, `email`, `dia_chi`, `mat_khau`, `dien_thoai`) VALUES
(11, 'Lương Thanh Tuấn', 'luongthanhtuan525@gmail.com', 'PJ3X+GH8, KDC 13E, Đô thị mới Nam Thành Phố, Ấp 5, Bình Chánh, TP. Hồ Chí Minh', '202cb962ac59075b964b07152d234b70', '0363296105'),
(13, 'thanh thanh', 'luongthanhtuan474@gmail.com', 'luongthanhtuan525@gmail.comluongthanhtuan525@gmail.comluongthanhtuan525@gmail.comluongthanhtuan525@gmail.com', '202cb962ac59075b964b07152d234b70', '213414124'),
(14, 'ngọc tuấn', 'ngoctuan090904@gmail.com', 'Hóc Môn', '202cb962ac59075b964b07152d234b70', '0768893544'),
(23, 'aaa a a ', 'aaa@gmail.com', 'abc 123', 'e99a18c428cb38d5f260853678922e03', '0937024435'),
(25, 'dang the vinh', 'capijim747@gmail.com', 'ádfasdfasdfasdfsa', 'd6eb8d33b00b06ea903b4c170b167487', '0359855353'),
(27, 'Đinh Phúc Thịnh', 'thinhgpt1706@gmail.com', '536 Au Co', '7ca4100f078350295c611e78355a57d4', '0931816175'),
(28, 'TUẤN NGỌC', 'nguyenngoctuan090904@gmail.com', 'Hóc Môn', 'a7d0de81da0392d5a03cac78a26a2485', '0768893544'),
(29, 'TUẤN NGỌC', 'nnt090904@gmail.com', 'Hóc Môn', 'a7d0de81da0392d5a03cac78a26a2485', '0768893544'),
(30, 'Trần Đăng Kha', 'phattran280704@outlook.com', 'TP.HCM', 'c3fb37909d398f646387bef207be49b4', '0937024435');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmucqa`
--

CREATE TABLE `tbl_danhmucqa` (
  `id_dm` int NOT NULL,
  `name_sp` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `thu_tu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_danhmucqa`
--

INSERT INTO `tbl_danhmucqa` (`id_dm`, `name_sp`, `thu_tu`) VALUES
(48, 'Bóng đá', 1),
(51, 'Cầu lông', 2),
(52, 'Bóng rổ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmuc_baiviet`
--

CREATE TABLE `tbl_danhmuc_baiviet` (
  `id_baiviet` int NOT NULL,
  `tendanhmuc_baiviet` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `thutu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_danhmuc_baiviet`
--

INSERT INTO `tbl_danhmuc_baiviet` (`id_baiviet`, `tendanhmuc_baiviet`, `thutu`) VALUES
(0, 'CẦU LÔNG', 34),
(9, 'BÓNG RỔ', 3),
(14, 'BÓNG ĐÁ', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giaohang`
--

CREATE TABLE `tbl_giaohang` (
  `id_shipping` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `note` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_dangky` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_giaohang`
--

INSERT INTO `tbl_giaohang` (`id_shipping`, `name`, `phone`, `address`, `note`, `id_dangky`) VALUES
(1, 'Nguyễn Ngọc Tuấn', '0768893544', 'xã Bà Điểm Hóc Môm', '', 14),
(2, 'h', 'h', 'h', '', 25),
(3, 'Thinh Dinh', '93181617', '536/43/68A Âu Cơ', '123123', 16),
(4, 'Thinh Dinh', '93181617', '536/43/68A Âu Cơ', '123', 26),
(5, 'Thinh Dinh', '0931816175', '536 Au Co', '', 27);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giohangtam`
--

CREATE TABLE `tbl_giohangtam` (
  `id` int NOT NULL,
  `id_khachhang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_sanpham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `so_luong` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_giohangtam`
--

INSERT INTO `tbl_giohangtam` (`id`, `id_khachhang`, `id_sanpham`, `so_luong`) VALUES
(14, '', '136', 2),
(15, '', '131', 3),
(18, '14', '116', 1),
(19, '14', '137', 10),
(20, '27', '137', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hoadon`
--

CREATE TABLE `tbl_hoadon` (
  `id_gh` int NOT NULL,
  `id_khachhang` int NOT NULL,
  `ma_gh` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cart_date` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cart_payment` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cart_shipping` int NOT NULL,
  `trang_thai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_hoadon`
--

INSERT INTO `tbl_hoadon` (`id_gh`, `id_khachhang`, `ma_gh`, `cart_date`, `cart_payment`, `cart_shipping`, `trang_thai`) VALUES
(10, 11, '2946', '', '', 0, 0),
(11, 11, '8262', '', '', 0, 0),
(12, 11, '6879', '', '', 0, 0),
(13, 11, '3410', '', '', 0, 0),
(14, 11, '2870', '', '', 0, 0),
(15, 11, '4500', '', '', 0, 0),
(16, 14, '8654', '', '', 0, 1),
(21, 14, '9405', '2024-10-09 18:48:02', '', 0, 1),
(22, 14, '9886', '2024-10-09 18:51:13', '', 0, 1),
(23, 14, '260', '2024-10-09 18:55:35', '', 0, 1),
(24, 14, '7286', '2024-10-09 18:57:16', '', 0, 1),
(25, 14, '9014', '2024-10-09 19:00:38', '', 0, 1),
(26, 14, '9900', '2024-10-09 19:05:20', '', 0, 1),
(27, 15, '963', '2024-10-09 19:23:25', '', 0, 1),
(28, 15, '9790', '2024-10-09 19:26:35', '', 0, 1),
(29, 15, '1412', '2024-10-09 19:26:56', '', 0, 1),
(30, 15, '4051', '2024-10-09 20:22:02', '', 0, 1),
(31, 15, '7050', '2024-10-09 20:29:44', '', 0, 1),
(32, 16, '7411', '2024-10-11 15:38:20', '', 0, 0),
(33, 23, '4146', '2024-10-16 11:02:16', '', 0, 0),
(34, 24, '9023', '2024-10-16 11:02:40', '', 0, 1),
(35, 23, '7587', '2024-10-16 11:02:55', '', 0, 1),
(36, 14, '478', '2024-10-17 11:30:40', '', 0, 1),
(37, 14, '2100', '2024-10-17 12:11:10', 'tienmat', 0, 1),
(38, 23, '1773', '2024-10-21 10:20:48', 'chuyenkhoan', 0, 1),
(39, 23, '9875', '2024-10-21 10:21:42', 'tienmat', 0, 1),
(40, 23, '6212', '2024-10-21 10:22:09', 'tienmat', 0, 1),
(41, 23, '5743', '2024-10-21 10:22:37', 'tienmat', 0, 1),
(42, 23, '9191', '2024-10-21 10:22:52', 'tienmat', 0, 1),
(43, 23, '9151', '2024-10-21 10:26:37', 'chuyenkhoan', 0, 1),
(44, 24, '6486', '2024-10-21 10:50:29', 'chuyenkhoan', 0, 1),
(45, 14, '8436', '2024-10-23 08:39:54', '', 0, 1),
(46, 25, '7340', '2024-10-23 08:47:47', '', 0, 1),
(47, 25, '4302', '2024-10-23 08:52:14', '', 0, 1),
(48, 25, '6632', '2024-10-23 08:59:25', '', 0, 1),
(49, 25, '843', '2024-10-23 09:03:54', '', 0, 1),
(50, 25, '7748', '2024-10-23 09:25:22', 'tienmat', 0, 1),
(51, 25, '5935', '2024-10-23 09:26:21', 'tienmat', 0, 1),
(52, 25, '7220', '2024-10-23 09:29:10', 'tienmat', 0, 1),
(53, 25, '7679', '2024-10-23 09:31:34', 'tienmat', 0, 1),
(54, 25, '1535', '2024-10-23 10:06:23', 'tienmat', 0, 1),
(55, 25, '588', '2024-10-23 10:12:18', '', 0, 1),
(56, 15, '5191', '2024-10-23 10:14:20', 'tienmat', 0, 1),
(57, 25, '3520', '2024-10-23 10:14:53', 'tienmat', 0, 1),
(58, 25, '8297', '2024-10-23 10:15:31', 'tienmat', 0, 1),
(59, 25, '2247', '2024-10-23 10:17:34', 'tienmat', 2, 1),
(60, 25, '8995', '2024-10-23 10:18:10', 'tienmat', 2, 1),
(61, 15, '7535', '2024-10-23 10:20:12', 'tienmat', 0, 1),
(62, 25, '8420', '2024-10-23 10:25:12', 'tienmat', 2, 1),
(63, 25, '5411', '2024-10-23 10:42:22', '', 0, 1),
(64, 25, '8749', '2024-10-23 10:45:47', '', 0, 1),
(65, 25, '8380', '2024-10-23 10:48:02', '', 0, 1),
(66, 25, '7436', '2024-10-23 10:49:14', '', 0, 1),
(67, 25, '4190', '2024-10-23 10:52:56', '', 0, 1),
(68, 25, '6736', '2024-10-23 10:54:09', '', 0, 1),
(69, 25, '5487', '2024-10-23 10:56:18', 'tienmat', 2, 1),
(70, 25, '7191', '2024-10-23 10:58:19', '', 0, 1),
(71, 14, '8233', '2024-10-23 11:36:22', 'tienmat', 1, 1),
(72, 14, '45', '2024-10-23 11:41:03', 'tienmat', 1, 1),
(73, 14, '5781', '2024-10-23 11:43:40', 'chuyenkhoan', 1, 1),
(74, 14, '2948', '2024-10-24 14:29:40', '', 0, 1),
(75, 16, '3494', '2024-10-24 17:39:37', 'tienmat', 3, 1),
(76, 26, '1839', '2024-10-24 17:42:20', 'tienmat', 4, 1),
(77, 26, '761', '2024-10-24 17:45:55', 'tienmat', 4, 1),
(78, 26, '4207', '2024-10-24 17:52:25', 'tienmat', 4, 1),
(79, 26, '8393', '2024-10-24 17:55:18', 'tienmat', 4, 1),
(80, 26, '4390', '2024-10-24 18:01:58', 'tienmat', 4, 1),
(81, 26, '8612', '2024-10-24 18:04:40', 'tienmat', 4, 1),
(82, 26, '2092', '2024-10-24 18:20:47', 'tienmat', 4, 1),
(83, 26, '4793', '2024-10-24 18:24:59', 'tienmat', 4, 1),
(84, 26, '8538', '2024-10-24 18:36:56', 'tienmat', 4, 1),
(85, 26, '4984', '2024-10-24 18:44:34', 'tienmat', 4, 1),
(86, 26, '3740', '2024-10-24 18:49:22', 'tienmat', 4, 1),
(87, 26, '4207', '2024-10-24 18:57:31', 'tienmat', 4, 1),
(88, 26, '2485', '2024-10-24 19:32:39', 'tienmat', 4, 1),
(89, 26, '7680', '2024-10-24 19:43:09', 'tienmat', 4, 1),
(90, 26, '671a414c4c19a', '2024-10-24 19:45:00', 'tienmat', 4, 1),
(91, 26, '671a4383ecb9b', '2024-10-24 19:54:27', 'tienmat', 4, 1),
(92, 26, '671a444debad2', '2024-10-24 19:57:49', 'tienmat', 4, 1),
(93, 26, '671a44cd85c83', '2024-10-24 19:59:57', 'tienmat', 4, 1),
(94, 26, '671a455319fee', '2024-10-24 20:02:11', 'tienmat', 4, 1),
(95, 26, '671a7a343d8e3', '2024-10-24 23:47:48', 'tienmat', 4, 1),
(96, 27, '672c69263562d', '2024-11-07 14:15:50', 'tienmat', 0, 1),
(97, 27, '7120', '2024-11-07 14:16:51', '', 0, 1),
(98, 14, '4234', '2024-11-07 15:12:54', '', 0, 1),
(99, 14, '6414', '2024-11-07 15:14:06', '', 0, 1),
(100, 14, '7664', '2024-11-07 15:14:17', '', 0, 1),
(101, 14, '510', '2024-11-07 15:14:31', '', 0, 1),
(102, 14, '9712', '2024-11-07 15:16:33', '', 0, 1),
(103, 14, '7692', '2024-11-07 15:19:16', 'momo', 0, 1),
(104, 14, '672c792dd9fe3', '2024-11-07 15:24:13', 'tienmat', 1, 1),
(105, 30, '67315037b7010', '2024-11-11 07:30:47', 'chuyenkhoan', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_khuyenmai`
--

CREATE TABLE `tbl_khuyenmai` (
  `id_km` int NOT NULL,
  `ten` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `giamgia` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lienhe`
--

CREATE TABLE `tbl_lienhe` (
  `id` int NOT NULL,
  `thongtinlienhe` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_lienhe`
--

INSERT INTO `tbl_lienhe` (`id`, `thongtinlienhe`) VALUES
(1, 'Thông Tin Liên Hệ 7TCC<br><br>\r\n\r\nCửa Hàng Chính<br>\r\n- Địa chỉ: 273 An Dương Vương, Phường 3, Quận 5, TP.HCM<br>\r\n- Điện thoại: 0938688079<br>\r\n- Email: support@7tcc.vn<br>\r\n- Giờ làm việc: 8:00 - 22:00 (Tất cả các ngày trong tuần)<br><br>\r\n\r\nBộ Phận Hỗ Trợ Khách Hàng<br>\r\n- Tổng đài hỗ trợ: 0909888888 (Miễn phí cuộc gọi)<br>\r\n- Email hỗ trợ: cskh@7tcc.vn<br>\r\n- Thời gian hỗ trợ: 8:00 - 21:00 (Tất cả các ngày trong tuần)<br><br>\r\n\r\nChính Sách & Quy Định<br>\r\n- Chúng tôi cam kết phản hồi mọi thắc mắc của quý khách trong vòng 24 giờ làm việc<br>\r\n- Mọi yêu cầu hỗ trợ sẽ được xử lý theo thứ tự ưu tiên<br>\r\n- Đối với các vấn đề khẩn cấp, vui lòng liên hệ trực tiếp qua tổng đài hỗ trợ<br><br>\r\n\r\nKết Nối Với Chúng Tôi<br>\r\n- Facebook: facebook.com/7tcc.vn<br>\r\n- Instagram: instagram.com/7tcc.vn<br>\r\n- Zalo: zalo.me/7tcc<br><br>\r\n\r\nRất hân hạnh được phục vụ quý khách!');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_momo`
--

CREATE TABLE `tbl_momo` (
  `id_momo` int NOT NULL,
  `partner_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `order_id` int NOT NULL,
  `amount` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `order_info` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `trans_id` int NOT NULL,
  `pay_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `code_cart` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_momo`
--

INSERT INTO `tbl_momo` (`id_momo`, `partner_code`, `order_id`, `amount`, `order_info`, `order_type`, `trans_id`, `pay_type`, `code_cart`) VALUES
(1, 'MOMOBKUN20180529', 1730967443, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '9170');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sanpham`
--

CREATE TABLE `tbl_sanpham` (
  `id_sp` int NOT NULL,
  `ten_sp` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `ma_sp` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `gia_sp` int NOT NULL,
  `so_luong` int NOT NULL,
  `so_luong_con_lai` int NOT NULL,
  `hinh_anh` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tom_tat` text COLLATE utf8mb4_general_ci,
  `noi_dung` longtext COLLATE utf8mb4_general_ci,
  `id_dm` int NOT NULL,
  `tinh_trang` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sanpham`
--

INSERT INTO `tbl_sanpham` (`id_sp`, `ten_sp`, `ma_sp`, `gia_sp`, `so_luong`, `so_luong_con_lai`, `hinh_anh`, `tom_tat`, `noi_dung`, `id_dm`, `tinh_trang`) VALUES
(116, 'Áo MC', '5', 400000, 110, 1, 'aoMC.png', 'áo', 'áo', 48, 1),
(122, 'áo mới', '1230', 100000, 9, 9, 'aoMC.png', 'a', 'a', 48, 1),
(123, 'áo mới', '1230', 100000, 9, 9, 'aoMC.png', 'a', 'a', 48, 1),
(124, 'áo mới', '1230', 100000, 9, 7, 'aoMC.png', 'a', 'a', 48, 1),
(125, 'áo mới', '1230', 100000, 9, 8, 'aoMC.png', 'a', 'a', 48, 1),
(126, 'Áo MU', 'mu023', 400000, 100, 99, 'aoMU.jpg', 'mu', 'mu', 48, 1),
(127, 'Áo Yonex', 'ynex123', 400000, 100, 98, 'aoYONEX.png', 'yonex', 'yonex', 51, 1),
(128, 'Áo cầu lông 2', 'ynex2', 400000, 100, 100, 'aocaulong2.jpg', '', '', 51, 1),
(129, 'Áo cầu lông 3', 'ynex3', 400000, 100, 100, 'aocaulong3.jpg', '', '', 51, 1),
(130, 'Áo cầu lông 4', 'ynex4', 400000, 100, 97, 'aocaulong4.jpg', '', '', 51, 1),
(131, 'Áo cầu lông 5', 'ynex5', 400000, 100, 95, 'aocaulong5.jpg', '', '', 51, 1),
(132, 'Áo cầu lông 6', 'ynex6', 400000, 100, 93, 'aocaulong6.jpg', '', '', 51, 1),
(133, 'Áo bóng rổ 1', 'br1', 300000, 100, 99, 'aobr1.jpg', '', '', 52, 1),
(134, 'Áo bóng rổ 2', 'br2', 300000, 100, 98, 'aobr2.jpg', '', '', 52, 1),
(135, 'Áo bóng rổ 3', 'br3', 300000, 100, 95, 'aobr3.jpg', '', '', 52, 1),
(136, 'Áo bóng rổ 4', 'br4', 300000, 100, 83, 'aobr4.jpg', '', '', 52, 1),
(137, 'Áo bóng rổ 5', 'br5', 300000, 100, 72, 'aobr5.jpg', '', '', 52, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taikhoan`
--

CREATE TABLE `tbl_taikhoan` (
  `id_dangky` int NOT NULL,
  `ten_khachhang` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dia_chi` varchar(200) NOT NULL,
  `dien_thoai` int NOT NULL,
  `trang_thai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_taikhoan`
--

INSERT INTO `tbl_taikhoan` (`id_dangky`, `ten_khachhang`, `email`, `dia_chi`, `dien_thoai`, `trang_thai`) VALUES
(11, 'ab', 'ab', 'ab', 123456789, 0),
(12, 'acb', 'acb', 'acb', 133456789, 1),
(13, 'cacb', 'accb', 'accb', 135456789, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thongke`
--

CREATE TABLE `tbl_thongke` (
  `id` int NOT NULL,
  `ngaydat` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `donhang` int NOT NULL,
  `doanhthu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `soluongdaban` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_thongke`
--

INSERT INTO `tbl_thongke` (`id`, `ngaydat`, `donhang`, `doanhthu`, `soluongdaban`) VALUES
(1, '2024-10-09', 4, '800000', 4),
(2, '2024-10-01', 1, '100000', 4),
(3, '2024-09-01', 2, '200000', 10),
(4, '2024-08-01', 5, '2500000', 5),
(5, '2024-10-14', 1, '400000', 1),
(6, '2024-11-07', 1, '0', 0),
(7, '2024-11-11', 1, '300000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thuonghieu`
--

CREATE TABLE `tbl_thuonghieu` (
  `id_thuonghieu` int NOT NULL,
  `tenthuonghieu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vnpay`
--

CREATE TABLE `tbl_vnpay` (
  `id_vnpay` int NOT NULL,
  `vnp_amount` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_bankcode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_banktranno` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_cardtype` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_orderinfo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_paydate` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_tmncode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `vnp_transactionno` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `code_cart` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vnpay`
--

INSERT INTO `tbl_vnpay` (`id_vnpay`, `vnp_amount`, `vnp_bankcode`, `vnp_banktranno`, `vnp_cardtype`, `vnp_orderinfo`, `vnp_paydate`, `vnp_tmncode`, `vnp_transactionno`, `code_cart`) VALUES
(1, '30000000', 'NCB', 'VNP14627857', 'ATM', 'Thanh toán đơn hàng', '20241023104944', 'IZK6416P', '14627857', '7436'),
(2, '30000000', 'NCB', 'VNP14627868', 'ATM', 'Thanh toán đơn hàng', '20241023105333', 'IZK6416P', '14627868', '4190'),
(3, '30000000', 'NCB', 'VNP14627868', 'ATM', 'Thanh toán đơn hàng', '20241023105333', 'IZK6416P', '14627868', '4190'),
(4, '30000000', 'NCB', 'VNP14627871', 'ATM', 'Thanh toán đơn hàng', '20241023105436', 'IZK6416P', '14627871', '6736'),
(5, '30000000', 'NCB', 'VNP14627884', 'ATM', 'Thanh toán đơn hàng', '20241023105846', 'IZK6416P', '14627884', '7191'),
(6, '60000000', 'VNPAY', '', 'QRCODE', 'Thanh toán đơn hàng', '20241107141649', 'IZK6416P', '0', '672c695f965b4'),
(7, '80000000', 'NCB', 'VNP14656365', 'ATM', 'Thanh toán đơn hàng', '20241107151250', 'IZK6416P', '14656365', '672c76578ae43'),
(11, '60000000', 'NCB', 'VNP14656379', 'ATM', 'Thanh toán đơn hàng', '20241107151629', 'IZK6416P', '14656379', '672c7752e01bb');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_xacnhanemail`
--

CREATE TABLE `tbl_xacnhanemail` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_xacnhanemail`
--

INSERT INTO `tbl_xacnhanemail` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'zaikaman123@gmail.com', '82cb92674c72ef3f45a9f31bf423af4f', '2024-11-07 07:09:13'),
(2, 'zaikaman123@gmail.com', 'b09d779a31201452522534bf60fbe1bb', '2024-11-07 07:10:34'),
(3, 'zaikaman123@gmail.com', 'e7e5d86ba3c36c021ef07b3e5f611dec', '2024-11-07 07:12:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_ad`);

--
-- Indexes for table `tbl_baiviet`
--
ALTER TABLE `tbl_baiviet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_danhmuc` (`id_danhmuc`);

--
-- Indexes for table `tbl_cartsessions`
--
ALTER TABLE `tbl_cartsessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chat_history`
--
ALTER TABLE `tbl_chat_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chitiet_gh`
--
ALTER TABLE `tbl_chitiet_gh`
  ADD PRIMARY KEY (`id_ctgh`);

--
-- Indexes for table `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  ADD PRIMARY KEY (`id_dangky`);

--
-- Indexes for table `tbl_danhmucqa`
--
ALTER TABLE `tbl_danhmucqa`
  ADD PRIMARY KEY (`id_dm`);

--
-- Indexes for table `tbl_danhmuc_baiviet`
--
ALTER TABLE `tbl_danhmuc_baiviet`
  ADD PRIMARY KEY (`id_baiviet`);

--
-- Indexes for table `tbl_giaohang`
--
ALTER TABLE `tbl_giaohang`
  ADD PRIMARY KEY (`id_shipping`);

--
-- Indexes for table `tbl_giohangtam`
--
ALTER TABLE `tbl_giohangtam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  ADD PRIMARY KEY (`id_gh`);

--
-- Indexes for table `tbl_khuyenmai`
--
ALTER TABLE `tbl_khuyenmai`
  ADD PRIMARY KEY (`id_km`);

--
-- Indexes for table `tbl_lienhe`
--
ALTER TABLE `tbl_lienhe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_momo`
--
ALTER TABLE `tbl_momo`
  ADD PRIMARY KEY (`id_momo`);

--
-- Indexes for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD PRIMARY KEY (`id_sp`);

--
-- Indexes for table `tbl_taikhoan`
--
ALTER TABLE `tbl_taikhoan`
  ADD PRIMARY KEY (`id_dangky`);

--
-- Indexes for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_thuonghieu`
--
ALTER TABLE `tbl_thuonghieu`
  ADD PRIMARY KEY (`id_thuonghieu`);

--
-- Indexes for table `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  ADD PRIMARY KEY (`id_vnpay`);

--
-- Indexes for table `tbl_xacnhanemail`
--
ALTER TABLE `tbl_xacnhanemail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_ad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_baiviet`
--
ALTER TABLE `tbl_baiviet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_cartsessions`
--
ALTER TABLE `tbl_cartsessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_chat_history`
--
ALTER TABLE `tbl_chat_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_chitiet_gh`
--
ALTER TABLE `tbl_chitiet_gh`
  MODIFY `id_ctgh` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  MODIFY `id_dangky` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_danhmucqa`
--
ALTER TABLE `tbl_danhmucqa`
  MODIFY `id_dm` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_danhmuc_baiviet`
--
ALTER TABLE `tbl_danhmuc_baiviet`
  MODIFY `id_baiviet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_giaohang`
--
ALTER TABLE `tbl_giaohang`
  MODIFY `id_shipping` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_giohangtam`
--
ALTER TABLE `tbl_giohangtam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  MODIFY `id_gh` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `tbl_lienhe`
--
ALTER TABLE `tbl_lienhe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_momo`
--
ALTER TABLE `tbl_momo`
  MODIFY `id_momo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `id_sp` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  MODIFY `id_vnpay` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_xacnhanemail`
--
ALTER TABLE `tbl_xacnhanemail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
