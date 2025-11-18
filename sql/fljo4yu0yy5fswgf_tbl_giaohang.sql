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
-- Table structure for table `tbl_giaohang`
--

DROP TABLE IF EXISTS `tbl_giaohang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_giaohang` (
  `id_shipping` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi_chi_tiet` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `quan_huyen` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tinh_thanh` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_dangky` int NOT NULL,
  PRIMARY KEY (`id_shipping`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_giaohang`
--

LOCK TABLES `tbl_giaohang` WRITE;
/*!40000 ALTER TABLE `tbl_giaohang` DISABLE KEYS */;
INSERT INTO `tbl_giaohang` VALUES (1,'Nguyễn Ngọc Tuấn','0768893544','xã Bà Điểm Hóc Môn',NULL,NULL,'',14),(2,'h','h','h',NULL,NULL,'',25),(3,'Thinh Dinh','93181617','536/43/68A Âu Cơ',NULL,NULL,'123123',16),(4,'Thinh Dinh','93181617','536/43/68A Âu Cơ',NULL,NULL,'123',26),(5,'Thinh Dinh','0931816175','536 Au Co',NULL,NULL,'',27),(6,'Trần Đăng Phát','0779792312','Đồng Nai',NULL,NULL,'',0),(7,'Trần Đăng Phát','0779792132','Đồng Nai',NULL,NULL,'',32),(8,'Minh Vương','0768893544','Trường Đại học Sài Gòn',NULL,NULL,'',33),(9,'Thinh Dinhasd','0931816174','536/43/68A Âu C','Quận Tân Phú','Thành phố Hồ Chí Minh','GIAO CHAM THOI',36);
/*!40000 ALTER TABLE `tbl_giaohang` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:55:09
