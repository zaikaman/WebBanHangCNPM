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
-- Table structure for table `tbl_hoadon`
--

DROP TABLE IF EXISTS `tbl_hoadon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_hoadon` (
  `id_gh` int NOT NULL AUTO_INCREMENT,
  `id_khachhang` int NOT NULL,
  `ma_gh` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cart_date` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cart_payment` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cart_shipping` int NOT NULL,
  `trang_thai` int NOT NULL,
  PRIMARY KEY (`id_gh`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_hoadon`
--

LOCK TABLES `tbl_hoadon` WRITE;
/*!40000 ALTER TABLE `tbl_hoadon` DISABLE KEYS */;
INSERT INTO `tbl_hoadon` VALUES (119,27,'674bdcce68b6a','2024-12-01 10:49:34','tienmat',5,0),(120,27,'674bdcfe92da9','2024-12-01 10:50:22','tienmat',5,0),(121,27,'674bdd277d116','2024-12-01 10:51:03','tienmat',5,0),(124,27,'674bde81f1c4f','2024-12-01 10:56:49','chuyenkhoan',5,0),(125,34,'674be6ac478ea','2024-12-01 11:31:40','tienmat',0,0),(126,33,'674be8a702a18','2024-12-01 11:40:07','tienmat',8,0),(127,33,'2769','2024-12-01 11:47:33','tienmat',8,0),(128,33,'4457','2024-12-01 11:57:59','vnpay',8,0),(130,33,'674bf0628551d','2024-12-01 12:13:06','tienmat',8,0),(132,33,'2321','2024-12-01 12:16:20','vnpay',8,0),(133,33,'7228','2024-12-01 12:31:07','vnpay',8,0),(134,32,'5955','2024-12-01 13:12:08','vnpay',7,0),(135,0,'214','2024-12-01 13:18:02','vnpay',6,0),(136,0,'4756','2024-12-01 13:24:09','momo',6,0),(137,0,'945','2024-12-01 13:27:32','momo',6,0),(138,27,'674c077e9976a','2024-12-01 13:51:42','tienmat',5,0),(139,33,'674c2ee4c9070','2024-12-01 16:39:48','tienmat',8,0),(140,33,'674c2efbc25c4','2024-12-01 16:40:11','tienmat',8,0),(141,33,'7511','2024-12-01 17:13:12','momo',8,1),(142,33,'674c38c81a9b2','2024-12-01 17:22:00','tienmat',8,0),(143,33,'674c3952ac6a8','2024-12-01 17:24:18','tienmat',8,1),(144,14,'9683','2024-12-01 17:28:33','vnpay',1,1),(145,14,'674c3a6d2a95f','2024-12-01 17:29:01','tienmat',1,1),(146,14,'674c3a989d199','2024-12-01 17:29:44','tienmat',1,1),(147,27,'674c3a9f7cd07','2024-12-01 17:29:51','tienmat',5,1),(148,27,'674c3c95d3aab','2024-12-01 17:38:13','tienmat',5,1),(149,27,'674c3fd0e0d96','2024-12-01 17:52:00','tienmat',5,1),(150,27,'674c41589e279','2024-12-01 17:58:32','tienmat',5,1),(151,27,'674c56a51a56f','2024-12-01 19:29:25','tienmat',5,1),(152,27,'674c57b6c851b','2024-12-01 19:33:58','tienmat',5,1),(153,27,'674c57ea8e53c','2024-12-01 19:34:50','tienmat',5,1),(154,27,'674c58205f123','2024-12-01 19:35:44','tienmat',5,1),(155,27,'674c585775003','2024-12-01 19:36:39','tienmat',5,1),(156,27,'674c594ee2732','2024-12-01 19:40:46','tienmat',5,1),(157,27,'674c598515f16','2024-12-01 19:41:41','tienmat',5,1),(158,27,'674c59b8d2401','2024-12-01 19:42:32','tienmat',5,1),(159,32,'636','2024-12-01 19:43:12','vnpay',7,1),(160,27,'674c59eca1f9f','2024-12-01 19:43:24','tienmat',5,1),(161,27,'674c5a1f34d06','2024-12-01 19:44:15','tienmat',5,1),(162,32,'890','2024-12-01 19:44:18','vnpay',7,1),(163,27,'674c5a5d05930','2024-12-01 19:45:17','tienmat',5,1),(164,32,'8704','2024-12-01 19:45:25','vnpay',7,1),(165,27,'674c5a8b9e3a2','2024-12-01 19:46:03','tienmat',5,1),(166,32,'4192','2024-12-01 19:46:25','vnpay',7,1),(167,32,'3557','2024-12-01 19:47:20','vnpay',7,1),(168,27,'674c5ae9e854b','2024-12-01 19:47:37','tienmat',5,1),(169,32,'1214','2024-12-01 19:48:04','vnpay',7,1),(170,27,'674c5b27ddf1b','2024-12-01 19:48:39','tienmat',5,1),(171,32,'8786','2024-12-01 19:49:01','vnpay',7,1),(172,32,'7605','2024-12-01 19:49:48','vnpay',7,1),(173,27,'674c5b7ab0578','2024-12-01 19:50:02','tienmat',5,1),(174,32,'802','2024-12-01 19:50:54','vnpay',7,1),(175,27,'674c5bdd3d5f2','2024-12-01 19:51:41','tienmat',5,1),(176,32,'74','2024-12-01 19:51:49','vnpay',7,1),(177,32,'8810','2024-12-01 19:53:07','vnpay',7,1),(178,27,'674c5c361194f','2024-12-01 19:53:10','tienmat',5,1),(179,32,'1547','2024-12-01 19:53:41','vnpay',7,1),(180,32,'4800','2024-12-01 19:54:35','vnpay',7,1),(181,27,'674c5c8feda00','2024-12-01 19:54:39','tienmat',5,1),(182,32,'4154','2024-12-01 19:55:17','vnpay',7,1),(183,32,'5462','2024-12-01 19:56:06','vnpay',7,1),(184,32,'1238','2024-12-01 19:57:48','momo',7,1),(185,32,'8915','2024-12-01 19:59:23','momo',7,1),(186,32,'1083','2024-12-01 20:00:47','momo',7,1),(187,32,'3610','2024-12-01 20:01:56','momo',7,1),(188,32,'2948','2024-12-01 20:03:37','momo',7,1),(189,32,'6538','2024-12-01 20:04:44','momo',7,1),(190,32,'438','2024-12-01 20:05:49','momo',7,1),(191,32,'4723','2024-12-01 20:06:55','momo',7,1),(192,32,'9424','2024-12-01 20:08:56','momo',7,1),(193,32,'4597','2024-12-01 20:10:05','momo',7,1),(194,32,'9620','2024-12-01 20:11:19','momo',7,1),(195,32,'4746','2024-12-01 20:12:57','momo',7,1),(196,32,'2851','2024-12-01 20:15:03','momo',7,1),(197,32,'8314','2024-12-01 20:15:59','momo',7,1),(198,32,'1708','2024-12-01 20:17:10','momo',7,1),(199,27,'674c633024694','2024-12-01 20:22:56','tienmat',5,1),(200,27,'674c636329b39','2024-12-01 20:23:47','tienmat',5,1),(201,27,'674c6398a17f2','2024-12-01 20:24:40','tienmat',5,0),(202,27,'674c63cb03836','2024-12-01 20:25:31','tienmat',5,1),(204,27,'674c6440cc0b3','2024-12-01 20:27:28','tienmat',5,0),(222,36,'68c125f6a3aa1','2025-09-10 14:17:10','tienmat',9,0),(223,36,'1757507613','2025-09-10 19:35:02','momo',9,0),(224,36,'68c40966246ad','2025-09-12 18:52:10','tienmat',9,1),(225,36,'68c82da16256e','2025-09-15 22:15:45','tienmat',9,2),(226,36,'68f88288c3ac3','2025-10-22 14:06:48','tienmat',9,1),(227,36,'1761116830','2025-10-22 14:07:36','momo',9,1),(228,36,'68f88a1041e80','2025-10-22 14:39:19','vnpay',9,1),(229,36,'68f897f03d03c','2025-10-22 15:38:08','tienmat',9,1),(230,36,'68f8a0aeca728','2025-10-22 16:15:26','tienmat',9,2),(231,36,'68f8a0e40256b','2025-10-22 16:16:32','vnpay',9,0);
/*!40000 ALTER TABLE `tbl_hoadon` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:55:55
