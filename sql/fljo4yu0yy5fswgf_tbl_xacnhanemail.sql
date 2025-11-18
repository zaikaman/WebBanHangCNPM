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
-- Table structure for table `tbl_xacnhanemail`
--

DROP TABLE IF EXISTS `tbl_xacnhanemail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_xacnhanemail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` tinyint(1) DEFAULT '0' COMMENT 'Trạng thái xác nhận email (0: chưa xác nhận, 1: đã xác nhận)',
  `verified_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian xác nhận email',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  KEY `idx_token` (`token`),
  KEY `idx_verified` (`verified`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_xacnhanemail`
--

LOCK TABLES `tbl_xacnhanemail` WRITE;
/*!40000 ALTER TABLE `tbl_xacnhanemail` DISABLE KEYS */;
INSERT INTO `tbl_xacnhanemail` VALUES (22,'zaikaman123@gmail.com','ef88dfbaa4a7221fc47bc3cfbe767790','2025-09-09 05:16:51',1,'2025-09-09 05:17:16'),(28,'subthinh18@gmail.com','c5e2f55a24f783f4672befe4e0cae55f','2025-09-12 16:58:37',1,'2025-09-12 16:58:48'),(31,'subthinh5@gmail.com','2f2bb0ac0f1329a552c06cc8f1e5132c','2025-10-22 08:33:54',0,NULL),(34,'thinhnice3@gmail.com','f64a9baf036c8095b3671d27bbd0ae2f','2025-10-22 08:37:48',0,NULL),(35,'asdasdd@gmail.com','670ade207c251b721faa3104ed8bb6d5','2025-10-22 13:04:42',0,NULL),(36,'bichle13111968@gmail.com','c09c4f4d64d02b7eebca1c5f6bf15eec','2025-11-18 06:46:12',0,NULL);
/*!40000 ALTER TABLE `tbl_xacnhanemail` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:54:30
