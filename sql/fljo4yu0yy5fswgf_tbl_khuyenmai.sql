-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: a5s42n4idx9husyc.cbetxkdyhwsb.us-east-1.rds.amazonaws.com    Database: fljo4yu0yy5fswgf
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `tbl_khuyenmai`
--

DROP TABLE IF EXISTS `tbl_khuyenmai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_khuyenmai` (
  `id_km` int NOT NULL AUTO_INCREMENT,
  `ten_km` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Tên chương trình khuyến mãi',
  `mo_ta` text COLLATE utf8mb4_general_ci COMMENT 'Mô tả chi tiết',
  `loai_km` enum('phan_tram','tien_mat','gia_moi') COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Loại: phần trăm, tiền mặt, giá mới',
  `gia_tri_km` decimal(10,2) NOT NULL COMMENT 'Giá trị khuyến mãi',
  `ngay_bat_dau` datetime NOT NULL,
  `ngay_ket_thuc` datetime NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Kích hoạt, 0: Tắt',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_km`),
  KEY `idx_ngay` (`ngay_bat_dau`,`ngay_ket_thuc`),
  KEY `idx_trang_thai` (`trang_thai`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Bảng quản lý khuyến mãi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_khuyenmai`
--

LOCK TABLES `tbl_khuyenmai` WRITE;
/*!40000 ALTER TABLE `tbl_khuyenmai` DISABLE KEYS */;
INSERT INTO `tbl_khuyenmai` VALUES (1,'Giảm 20% mùa World Cup','Giảm giá 20% cho tất cả áo bóng đá nhân dịp World Cup','phan_tram',20.00,'2025-11-01 00:00:00','2025-12-31 23:59:59',1,'2025-11-04 03:08:33','2025-11-04 03:08:33'),(2,'Flash Sale 50K','Giảm ngay 50,000đ cho đơn hàng từ 300,000đ','tien_mat',50000.00,'2025-11-04 00:00:00','2025-11-10 23:59:59',1,'2025-11-04 03:08:33','2025-11-04 03:08:33'),(3,'Giá đặc biệt áo MU','Giá ưu đãi đặc biệt chỉ 299,000đ','gia_moi',299000.00,'2025-11-04 00:00:00','2025-11-30 23:59:59',1,'2025-11-04 03:08:33','2025-11-04 03:08:33');
/*!40000 ALTER TABLE `tbl_khuyenmai` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-18 13:54:37
