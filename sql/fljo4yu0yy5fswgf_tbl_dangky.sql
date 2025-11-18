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
-- Table structure for table `tbl_dangky`
--

DROP TABLE IF EXISTS `tbl_dangky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_dangky` (
  `id_dangky` int NOT NULL AUTO_INCREMENT,
  `ten_khachhang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi_chi_tiet` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `quan_huyen` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tinh_thanh` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mat_khau` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `dien_thoai` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_dangky`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_dangky`
--

LOCK TABLES `tbl_dangky` WRITE;
/*!40000 ALTER TABLE `tbl_dangky` DISABLE KEYS */;
INSERT INTO `tbl_dangky` VALUES (14,'ngọc tuấn','ngoctuan090904@gmail.com','Hóc Môn',NULL,NULL,'202cb962ac59075b964b07152d234b70',NULL,NULL,'0768893544'),(27,'Đinh Phúc Thịnh','thinhgpt1706@gmail.com','536 Au Co',NULL,NULL,'7ca4100f078350295c611e78355a57d4',NULL,NULL,'0931816175'),(32,'Trần Đăng Phát','phattran280704@outlook.com','TP.HCM',NULL,NULL,'3b75b13a28364258df1f9f7cddb7b2f5',NULL,NULL,'0937024435'),(33,'Minh Vương','nnt090904@gmail.com','Hóc Môn',NULL,NULL,'69e4756805ff0abf358e132aeb6ab5ca',NULL,NULL,'0768893544'),(34,'dang the vinh','capijim747@gmail.com','ádfasdfasdfasdfsa',NULL,NULL,'d6eb8d33b00b06ea903b4c170b167487',NULL,NULL,'0359855353'),(36,'Đinh Phúc Thịnh','zaikaman123@gmail.com','536 Au Co',NULL,NULL,'dc9417f67e802695ecb86dab88899c6d',NULL,NULL,'0931816175'),(38,'Đinh Phúc Thịnh','subthinh18@gmail.com','536 Au Co',NULL,NULL,'ce9642a7df00bb973f5d9c55d5f67c49',NULL,NULL,'0931816175');
/*!40000 ALTER TABLE `tbl_dangky` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:54:43
