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
-- Table structure for table `tbl_momo`
--

DROP TABLE IF EXISTS `tbl_momo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_momo` (
  `id_momo` int NOT NULL AUTO_INCREMENT,
  `partner_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `order_id` int NOT NULL,
  `amount` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `order_info` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `trans_id` int NOT NULL,
  `pay_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `code_cart` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_momo`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_momo`
--

LOCK TABLES `tbl_momo` WRITE;
/*!40000 ALTER TABLE `tbl_momo` DISABLE KEYS */;
INSERT INTO `tbl_momo` VALUES (1,'MOMOBKUN20180529',1730967443,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','9170'),(2,'MOMOBKUN20180529',1733025351,'2190000','Thanh toán qua mã QR MoMo','momo_wallet',2147483647,'','2885'),(3,'MOMOBKUN20180529',1733029455,'360000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','8630'),(4,'MOMOBKUN20180529',1733030049,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','7975'),(5,'MOMOBKUN20180529',1733033937,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1419'),(6,'MOMOBKUN20180529',1733034371,'420000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6455'),(7,'MOMOBKUN20180529',1733047929,'250000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6824'),(8,'MOMOBKUN20180529',1733057813,'450000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6331'),(9,'MOMOBKUN20180529',1733057921,'370000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6221'),(10,'MOMOBKUN20180529',1733058007,'450000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','8939'),(11,'MOMOBKUN20180529',1733058085,'349000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','4826'),(12,'MOMOBKUN20180529',1733058147,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6607'),(13,'MOMOBKUN20180529',1733058238,'360000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','375'),(14,'MOMOBKUN20180529',1733058304,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','7740'),(15,'MOMOBKUN20180529',1733058376,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6513'),(16,'MOMOBKUN20180529',1733058472,'390000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','2994'),(17,'MOMOBKUN20180529',1733058571,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','5411'),(18,'MOMOBKUN20180529',1733058636,'300000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','7220'),(19,'MOMOBKUN20180529',1733058720,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','2543'),(20,'MOMOBKUN20180529',1733058840,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','2540'),(21,'MOMOBKUN20180529',1733058920,'350000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','4565'),(22,'MOMOBKUN20180529',1733058987,'450000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','6922'),(23,'MOMOBKUN20180529',1757482356,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1181'),(24,'MOMOBKUN20180529',1757482720,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','2327'),(25,'MOMOBKUN20180529',1757483270,'200000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757483270'),(26,'MOMOBKUN20180529',1757483675,'800000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757483675'),(27,'MOMOBKUN20180529',1757483976,'1200000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757483976'),(28,'MOMOBKUN20180529',1757484202,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757484202'),(29,'MOMOBKUN20180529',1757484202,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757484202'),(30,'MOMOBKUN20180529',1757484374,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757484374'),(31,'MOMOBKUN20180529',1757507613,'1200000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'napas','1757507613'),(32,'MOMOBKUN20180529',1761116830,'400000','Thanh toán qua MoMo ATM','momo_wallet',2147483647,'','1761116830');
/*!40000 ALTER TABLE `tbl_momo` ENABLE KEYS */;
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

-- Dump completed on 2025-11-18 13:54:50
