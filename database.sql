-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: vaccine
-- ------------------------------------------------------
-- Server version	8.0.31

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
INSERT INTO `faculty` VALUES ('F1-382123','jay:h:pascual','eme@email.com','09284617234','Male','2022-11-07','licaong NE'),('F2-123456','jay','test@email.com','09234567890','Male','2022-01-01','nueva ecija');
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logcredentials`
--

DROP TABLE IF EXISTS `logcredentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logcredentials` (
  `id` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logcredentials`
--

LOCK TABLES `logcredentials` WRITE;
/*!40000 ALTER TABLE `logcredentials` DISABLE KEYS */;
INSERT INTO `logcredentials` VALUES ('12-123456','123456'),('12-432124','xzeexyal'),('12-473723','3kfmn36m'),('12-854634','6hw41ov9'),('12-987654','t57qys3d'),('F2-123456','123456');
/*!40000 ALTER TABLE `logcredentials` ENABLE KEYS */;
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
INSERT INTO `student` VALUES ('12-123456','vincent :s:agustin','Grade 7','Enrolled','test@email.com','09234312341','Male','2022-01-01','tarlac'),('12-432124','happy:s:agustin','Grade 10','Enrolled','test@gmail.com','09224521234','Male','2022-11-09','asd'),('12-473723','jay:asd:asda','Grade 7','Enrolled','test@gmail.com','09224521234','Female','2022-11-25','wqeqwe'),('12-854634','asd:asda:asd','Grade 9','Enrolled','test@gmail.com','09224521234','Female','2022-11-20','test'),('12-987654','edgar:s:batumbakal','Grade 11','Enrolled','test@gmail.com','09224521234','Male','2022-12-02','wqeqwe');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacbrand`
--

DROP TABLE IF EXISTS `vacbrand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacbrand` (
  `brand` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  UNIQUE KEY `brand1` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacbrand`
--

LOCK TABLES `vacbrand` WRITE;
/*!40000 ALTER TABLE `vacbrand` DISABLE KEYS */;
INSERT INTO `vacbrand` VALUES ('astra'),('brimdaddy'),('meh'),('num'),('test');
/*!40000 ALTER TABLE `vacbrand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccinestatus`
--

DROP TABLE IF EXISTS `vaccinestatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccinestatus` (
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
-- Dumping data for table `vaccinestatus`
--

LOCK TABLES `vaccinestatus` WRITE;
/*!40000 ALTER TABLE `vaccinestatus` DISABLE KEYS */;
INSERT INTO `vaccinestatus` VALUES ('12-123456',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('12-432124','2022-11-06','happy','2022-11-26','pogi','meh','2022-11-18','jay','astra'),('12-473723','2022-11-06','asda',NULL,NULL,'brimdaddy',NULL,NULL,NULL),('12-854634','2022-11-14','asd',NULL,NULL,'astra',NULL,NULL,NULL),('12-987654','2022-11-12','johny bravo',NULL,NULL,'astra',NULL,NULL,NULL),('F1-382123','2022-11-28','happy',NULL,NULL,'meh',NULL,NULL,NULL),('F2-123456',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `vaccinestatus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-22 23:18:59
