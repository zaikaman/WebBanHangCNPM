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
-- Table structure for table `tbl_dangky_temp`
--

DROP TABLE IF EXISTS `tbl_dangky_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_dangky_temp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_khachhang` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dien_thoai` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi_chi_tiet` text COLLATE utf8mb4_general_ci,
  `quan_huyen` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tinh_thanh` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`),
  UNIQUE KEY `token_unique` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_dangky_temp`
--

LOCK TABLES `tbl_dangky_temp` WRITE;
/*!40000 ALTER TABLE `tbl_dangky_temp` DISABLE KEYS */;
INSERT INTO `tbl_dangky_temp` VALUES (3,'Dinh Phuc Thinh','subthinh5@gmail.com','0931816175','7ca4100f078350295c611e78355a57d4','536 Au Co',NULL,NULL,'2f2bb0ac0f1329a552c06cc8f1e5132c','2025-10-22 08:33:54'),(6,'Dinh Phuc Thinh','thinhnice3@gmail.com','0931816175','7ca4100f078350295c611e78355a57d4','536 Au Co',NULL,NULL,'f64a9baf036c8095b3671d27bbd0ae2f','2025-10-22 08:37:48'),(7,'Dinh Phuc Thinh','asdasdd@gmail.com','0931816175','ce9642a7df00bb973f5d9c55d5f67c49','536 Au Co',NULL,NULL,'670ade207c251b721faa3104ed8bb6d5','2025-10-22 13:04:42');
/*!40000 ALTER TABLE `tbl_dangky_temp` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:56:21
