-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: fdb1029.awardspace.net
-- Generation Time: Oct 24, 2024 at 05:01 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `4534038_dpt`
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
  `email` varchar(255) NOT NULL,
  `ten_sp` varchar(255) NOT NULL,
  `ma_gh` varchar(50) NOT NULL,
  `ma_sp` varchar(50) NOT NULL,
  `gia_sp` decimal(15,2) NOT NULL,
  `so_luong` int NOT NULL,
  `tong_tien` decimal(15,2) NOT NULL,
  `sent` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_cartsessions`
--

INSERT INTO `tbl_cartsessions` (`id`, `email`, `ten_sp`, `ma_gh`, `ma_sp`, `gia_sp`, `so_luong`, `tong_tien`, `sent`) VALUES
(1, 'thinhgpt1706@gmail.com', 'Áo bóng rổ 5', '', 'br5', 300000.00, 1, 300000.00, 1),
(2, 'thinhgpt1706@gmail.com', 'Áo MU', '', 'mu023', 400000.00, 1, 400000.00, 1),
(3, 'thinhgpt1706@gmail.com', 'Áo bóng rổ 5, Áo MU, Áo cầu lông 6', '', 'br5, mu023, ynex6', 300000.00, 3, 2100000.00, 1),
(4, 'thinhgpt1706@gmail.com', 'Áo bóng rổ 5, Áo MU, Áo cầu lông 6', '671a4b8a5e779', 'br5, mu023, ynex6', 300000.00, 3, 2100000.00, 1),
(5, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5', '671a633232733', 'ynex5', 400000.00, 1, 400000.00, 1),
(6, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5', '671a636ba3e0f', 'ynex5, br5', 400000.00, 1, 700000.00, 1),
(7, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5', '671a640c36408', 'ynex5, br5', 400000.00, 1, 1000000.00, 1),
(8, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5', '671a660a22903', 'ynex5, br5', 400000.00, 1, 1300000.00, 1),
(9, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5', '', 'ynex5, br5', 400000.00, 1, 1300000.00, 1),
(10, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5', '671a69484645a', 'ynex5, br5', 400000.00, 1, 1300000.00, 1),
(11, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5, Áo bóng rổ 4', '671a6a098d317', 'ynex5, br5, br4', 400000.00, 1, 1600000.00, 1),
(12, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5, Áo bóng rổ 4', '671a6ac022b1b', 'ynex5, br5, br4', 400000.00, 1, 1600000.00, 1),
(13, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5, Áo bóng rổ 4', '671a6afec8a23', 'ynex5, br5, br4', 400000.00, 1, 1600000.00, 1),
(14, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5, Áo bóng rổ 4', '671a6b6fb5177', 'ynex5, br5, br4', 400000.00, 1, 1900000.00, 1),
(15, 'thinhgpt1706@gmail.com', 'Áo cầu lông 5, Áo bóng rổ 5, Áo bóng rổ 4', '671a6c2a45f8a', 'ynex5, br5, br4', 400000.00, 1, 2200000.00, 1),
(16, 'thinhgpt1706@gmail.com', 'Áo bóng rổ 5', '671a767d7813c', 'br5', 300000.00, 1, 300000.00, 1),
(17, 'thinhgpt1706@gmail.com', 'Áo bóng rổ 4, Áo bóng rổ 2', '671a783a13383', 'br4, br2', 300000.00, 3, 1500000.00, 1),
(18, 'thinhgpt1706@gmail.com', 'Áo bóng rổ 4', '671a784b1d368', 'br4', 300000.00, 1, 300000.00, 0);

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
(81, '7804', 137, 1),
(82, '5692', 137, 1),
(83, '9596', 137, 1),
(84, '671a49dd87ab6', 137, 1),
(85, '671a49dd87ab6', 126, 1),
(86, '671a4b2855065', 137, 3),
(87, '671a4b2855065', 126, 1),
(88, '671a4b2855065', 132, 2),
(89, '671a4b8a5e779', 137, 3),
(90, '671a4b8a5e779', 126, 1),
(91, '671a4b8a5e779', 132, 2),
(92, '671a633232733', 131, 1),
(93, '671a636ba3e0f', 131, 1),
(94, '671a636ba3e0f', 137, 1),
(95, '671a640c36408', 131, 1),
(96, '671a640c36408', 137, 2),
(97, '671a660a22903', 131, 1),
(98, '671a660a22903', 137, 3),
(99, '', 131, 1),
(100, '', 137, 3),
(101, '671a69484645a', 131, 1),
(102, '671a69484645a', 137, 3),
(103, '671a6a098d317', 131, 1),
(104, '671a6a098d317', 137, 3),
(105, '671a6a098d317', 136, 1),
(106, '671a6ac022b1b', 131, 1),
(107, '671a6ac022b1b', 137, 3),
(108, '671a6ac022b1b', 136, 1),
(109, '671a6afec8a23', 131, 1),
(110, '671a6afec8a23', 137, 3),
(111, '671a6afec8a23', 136, 1),
(112, '671a6b6fb5177', 131, 1),
(113, '671a6b6fb5177', 137, 3),
(114, '671a6b6fb5177', 136, 2),
(115, '671a6c2a45f8a', 131, 1),
(116, '671a6c2a45f8a', 137, 4),
(117, '671a6c2a45f8a', 136, 2),
(118, '671a767d7813c', 137, 1),
(119, '671a783a13383', 136, 3),
(120, '671a783a13383', 134, 2),
(121, '671a784b1d368', 136, 1);

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
(15, 'Đinh Phúc Thịnh', 'zaikaman123@gmail.com', '536 Au Co', 'dc9417f67e802695ecb86dab88899c6d', '0931816175'),
(16, 'c', 'b@gmail.com', '', '4a8a08f09d37b73795649038408b5f33', ''),
(17, '123123123', 'zaikaman123@gmail.com', 'sadsadsad', 'f67c2bcbfcfa30fccb36f72dca22a817', 'asdasda'),
(18, '', 'zaikaman123@gmail.com', '536 Au Co', 'dc9417f67e802695ecb86dab88899c6d', '0931816175'),
(19, 'Đinh Phúc Thịnh', 'zaikaman123@gmail.com', '536 Au Co', 'd41d8cd98f00b204e9800998ecf8427e', '0931816175'),
(20, 'dmm', 'zaikaman123@gmail.com', '536 Au Co', 'dc9417f67e802695ecb86dab88899c6d', '0931816175'),
(21, 'Đinh Phúc Thịnh', 'zaikaman123@gmail.com', '536 Au Co', '4297f44b13955235245b2497399d7a93', '0931816175'),
(22, 'Đinh Phúc Thịnh', 'zaikaman123@gmail.com', '536 Au Co', '1b2de2499e5f93e00a5a90e79a9da4b1', '0931816175'),
(23, 'aaa a a ', 'aaa@gmail.com', 'abc 123', 'e99a18c428cb38d5f260853678922e03', '0937024435'),
(24, 'Trần Đăng Phát', 'phattran280704@gmail.com', 'TP.HCM', 'e10adc3949ba59abbe56e057f20f883e', '0779792132'),
(25, 'dang the vinh', 'capijim747@gmail.com', 'ádfasdfasdfasdfsa', 'd6eb8d33b00b06ea903b4c170b167487', '0359855353'),
(26, 'Đinh Phúc Thịnh', 'thinhgpt1706@gmail.com', '536 Au Co', 'dc9417f67e802695ecb86dab88899c6d', '0931816176'),
(27, 'Mia Liea', 'subthinh20@gmail.com', '536 Au CO', 'dc9417f67e802695ecb86dab88899c6d', '0931816172');

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
(0, 'truyentranh2', 34),
(9, 'truyentranh1', 3),
(14, 'danhmuc2', 2);

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
(3, 'Thinh Dinh', '93181617', '536/43/68A Âu Cơ', '123', 15),
(4, 'Thinh Dinh', '93181617', '536/43/68A Âu Cơ', '', 26);

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
(18, '15', '137', 1);

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
(33, 23, '4146', '2024-10-16 11:02:16', '', 0, 1),
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
(75, 15, '7804', '2024-10-24 19:01:24', 'tienmat', 3, 1),
(76, 26, '5692', '2024-10-24 19:03:38', 'tienmat', 4, 1),
(77, 26, '9596', '2024-10-24 19:06:24', 'tienmat', 4, 1),
(78, 26, '671a49dd87ab6', '2024-10-24 20:21:33', 'tienmat', 4, 1),
(79, 26, '671a4b2855065', '2024-10-24 20:27:04', 'tienmat', 4, 1),
(80, 26, '671a4b8a5e779', '2024-10-24 20:28:42', 'tienmat', 4, 1),
(81, 26, '671a633232733', '2024-10-24 22:09:38', 'tienmat', 4, 1),
(82, 26, '671a636ba3e0f', '2024-10-24 22:10:35', 'tienmat', 4, 1),
(83, 26, '671a640c36408', '2024-10-24 22:13:16', 'tienmat', 4, 1),
(84, 26, '671a660a22903', '2024-10-24 22:21:46', 'tienmat', 4, 1),
(85, 26, '', '2024-10-24 22:28:43', 'tienmat', 4, 1),
(86, 26, '671a69484645a', '2024-10-24 22:35:36', 'tienmat', 4, 1),
(87, 26, '671a6a098d317', '2024-10-24 22:38:49', 'tienmat', 4, 1),
(88, 26, '671a6ac022b1b', '2024-10-24 22:41:52', 'tienmat', 4, 1),
(89, 26, '671a6afec8a23', '2024-10-24 22:42:54', 'tienmat', 4, 1),
(90, 26, '671a6b6fb5177', '2024-10-24 22:44:47', 'tienmat', 4, 1),
(91, 26, '671a6c2a45f8a', '2024-10-24 22:47:54', 'tienmat', 4, 1),
(92, 26, '671a767d7813c', '2024-10-24 23:31:57', 'tienmat', 4, 1),
(93, 26, '671a783a13383', '2024-10-24 23:39:22', 'tienmat', 4, 1),
(94, 26, '671a784b1d368', '2024-10-24 23:39:39', '', 0, 1);

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
(1, ' liên hệ website chúng tôi \r\n liên hệ mới');

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
(116, 'Áo MC', '5', 400000, 110, -3, 'aoMC.png', 'áo', 'áo', 48, 1),
(122, 'áo mới', '1230', 100000, 9, 9, 'aoMC.png', 'a', 'a', 48, 1),
(123, 'áo mới', '1230', 100000, 9, 9, 'aoMC.png', 'a', 'a', 48, 1),
(124, 'áo mới', '1230', 100000, 9, 7, 'aoMC.png', 'a', 'a', 48, 1),
(125, 'áo mới', '1230', 100000, 9, 8, 'aoMC.png', 'a', 'a', 48, 1),
(126, 'Áo MU', 'mu023', 400000, 100, 96, 'aoMU.jpg', 'mu', 'mu', 48, 1),
(127, 'Áo Yonex', 'ynex123', 400000, 100, 100, 'aoYONEX.png', 'yonex', 'yonex', 51, 1),
(128, 'Áo cầu lông 2', 'ynex2', 400000, 100, 100, 'aocaulong2.jpg', '', '', 51, 1),
(129, 'Áo cầu lông 3', 'ynex3', 400000, 100, 100, 'aocaulong3.jpg', '', '', 51, 1),
(130, 'Áo cầu lông 4', 'ynex4', 400000, 100, 99, 'aocaulong4.jpg', '', '', 51, 1),
(131, 'Áo cầu lông 5', 'ynex5', 400000, 100, 85, 'aocaulong5.jpg', '', '', 51, 1),
(132, 'Áo cầu lông 6', 'ynex6', 400000, 100, 90, 'aocaulong6.jpg', '', '', 51, 1),
(133, 'Áo bóng rổ 1', 'br1', 300000, 100, 99, 'aobr1.jpg', '', '', 52, 1),
(134, 'Áo bóng rổ 2', 'br2', 300000, 100, 98, 'aobr2.jpg', '', '', 52, 1),
(135, 'Áo bóng rổ 3', 'br3', 300000, 100, 95, 'aobr3.jpg', '', '', 52, 1),
(136, 'Áo bóng rổ 4', 'br4', 300000, 100, 73, 'aobr4.jpg', '', '', 52, 1),
(137, 'Áo bóng rổ 5', 'br5', 300000, 100, 53, 'aobr5.jpg', '', '', 52, 1);

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
(5, '2024-10-14', 1, '400000', 1);

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
(5, '30000000', 'NCB', 'VNP14627884', 'ATM', 'Thanh toán đơn hàng', '20241023105846', 'IZK6416P', '14627884', '7191');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_ad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_baiviet`
--
ALTER TABLE `tbl_baiviet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_cartsessions`
--
ALTER TABLE `tbl_cartsessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_chitiet_gh`
--
ALTER TABLE `tbl_chitiet_gh`
  MODIFY `id_ctgh` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  MODIFY `id_dangky` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id_shipping` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_giohangtam`
--
ALTER TABLE `tbl_giohangtam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  MODIFY `id_gh` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tbl_lienhe`
--
ALTER TABLE `tbl_lienhe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_momo`
--
ALTER TABLE `tbl_momo`
  MODIFY `id_momo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `id_sp` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  MODIFY `id_vnpay` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
