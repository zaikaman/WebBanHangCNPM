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
-- Table structure for table `tbl_lienhe`
--

DROP TABLE IF EXISTS `tbl_lienhe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_lienhe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thongtinlienhe` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lienhe`
--

LOCK TABLES `tbl_lienhe` WRITE;
/*!40000 ALTER TABLE `tbl_lienhe` DISABLE KEYS */;
INSERT INTO `tbl_lienhe` VALUES (1,'Thông Tin Liên Hệ 7TCC<br><br>\r\n\r\nCửa Hàng Chính<br>\r\n- Địa chỉ: 273 An Dương Vương, Phường 3, Quận 5, TP.HCM<br>\r\n- Điện thoại: 0938688079<br>\r\n- Email: support@7tcc.vn<br>\r\n- Giờ làm việc: 8:00 - 22:00 (Tất cả các ngày trong tuần)<br><br>\r\n\r\nBộ Phận Hỗ Trợ Khách Hàng<br>\r\n- Tổng đài hỗ trợ: 0909888888 (Miễn phí cuộc gọi)<br>\r\n- Email hỗ trợ: cskh@7tcc.vn<br>\r\n- Thời gian hỗ trợ: 8:00 - 21:00 (Tất cả các ngày trong tuần)<br><br>\r\n\r\nChính Sách & Quy Định<br>\r\n- Chúng tôi cam kết phản hồi mọi thắc mắc của quý khách trong vòng 24 giờ làm việc<br>\r\n- Mọi yêu cầu hỗ trợ sẽ được xử lý theo thứ tự ưu tiên<br>\r\n- Đối với các vấn đề khẩn cấp, vui lòng liên hệ trực tiếp qua tổng đài hỗ trợ<br><br>\r\n\r\nKết Nối Với Chúng Tôi<br>\r\n- Facebook: facebook.com/7tcc.vn<br>\r\n- Instagram: instagram.com/7tcc.vn<br>\r\n- Zalo: zalo.me/7tcc<br><br>\r\n\r\nRất hân hạnh được phục vụ quý khách!');
/*!40000 ALTER TABLE `tbl_lienhe` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:55:03
