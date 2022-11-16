-- MySQL dump 10.13  Distrib 8.0.31, for Linux (x86_64)
--
-- Host: localhost    Database: Vaccine
-- ------------------------------------------------------
-- Server version	8.0.31-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faculty` (
  `id` varchar(30) NOT NULL,
  `name` varchar(1500) NOT NULL,
  `email` text,
  `tel` varchar(20) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logCredentials`
--

DROP TABLE IF EXISTS `logCredentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logCredentials` (
  `id` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logCredentials`
--

LOCK TABLES `logCredentials` WRITE;
/*!40000 ALTER TABLE `logCredentials` DISABLE KEYS */;
INSERT INTO `logCredentials` VALUES ('12-123456','9uhc4azd'),('21-654321','lrofuif8');
/*!40000 ALTER TABLE `logCredentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` varchar(30) NOT NULL COMMENT 'Primary Key',
  `name` varchar(1500) NOT NULL,
  `yearLevel` varchar(30) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `email` mediumtext,
  `tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('12-987654','jack mah boi','Grade 7','Enrolled','lordbatumbakal@email.com','09123456789','Female','2020-09-12','guimba'),('21-345678','percy val damn','Grade 8','Dropped','lordbatumbakal@email.com','09123456789','Female','2019-08-12','guimba'),('21-654321','jay emma sadboi','Grade 8','Enrolled','lordbatumbakal@email.com','09123456789','Female','2019-08-11','guimba');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacBrand`
--

DROP TABLE IF EXISTS `vacBrand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacBrand` (
  `brand` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  UNIQUE KEY `brand1` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacBrand`
--

LOCK TABLES `vacBrand` WRITE;
/*!40000 ALTER TABLE `vacBrand` DISABLE KEYS */;
INSERT INTO `vacBrand` VALUES ('astra'),('brimdaddy'),('meh'),('num'),('test');
/*!40000 ALTER TABLE `vacBrand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccineStatus`
--

DROP TABLE IF EXISTS `vaccineStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccineStatus` (
  `id` varchar(30) NOT NULL,
  `firstdose` date DEFAULT NULL,
  `firstdoctor` varchar(1500) DEFAULT NULL,
  `seconddose` date DEFAULT NULL,
  `seconddoctor` varchar(1500) DEFAULT NULL,
  `vacbrand` varchar(100) DEFAULT NULL,
  `booster` date DEFAULT NULL,
  `boosterdoctor` varchar(1500) DEFAULT NULL,
  `boosterbrand` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccineStatus`
--

LOCK TABLES `vaccineStatus` WRITE;
/*!40000 ALTER TABLE `vaccineStatus` DISABLE KEYS */;
INSERT INTO `vaccineStatus` VALUES ('12-987654',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('21-345678',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('21-654321','2017-08-11','gad',NULL,NULL,'meh',NULL,NULL,NULL);
/*!40000 ALTER TABLE `vaccineStatus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-16 19:15:58
