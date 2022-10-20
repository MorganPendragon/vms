-- MySQL dump 10.13  Distrib 8.0.30, for Linux (x86_64)
--
-- Host: localhost    Database: Vaccine
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.22.04.1

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
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` text,
  `address` mediumtext,
  `tel` text,
  `firstdose` date DEFAULT NULL,
  `seconddose` date DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand` (`brand`),
  CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `vacBrand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES ('b','fname mname lname','Female','2018-07-15','test@gmail.com','add','tel','2017-08-16',NULL,'brimdaddy'),('ea','fname mname lname','Female','2019-07-16','test@gmail.com','add','tel','2019-08-17',NULL,NULL),('id','fname mname lname','Male','2017-07-13','test2@gmail.cpom','add','tel','2020-08-16','2019-07-15',NULL),('test','reee','Female','2022-09-26','reese@gmail.com','easda','12341','2022-09-25',NULL,NULL),('x','fname mname lname','Female','2019-08-17','test@gmail.com','add','tel','2019-08-16',NULL,'brimdaddy'),('y','fname mname lname','Female','2019-08-17','test@gmail.com','add','tel','2016-08-16',NULL,'test'),('z','fname mname lname','Female','2018-07-15','test@gmail.com','add','tel','2019-07-16',NULL,NULL);
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` varchar(30) NOT NULL COMMENT 'Primary Key',
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` mediumtext,
  `tel` varchar(255) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` mediumtext,
  `firstdose` date DEFAULT NULL,
  `seconddose` date DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand` (`brand`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `vacBrand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('2','test2 test2 test2','test@gmail.com','test','Male','2001-01-01','test','2001-01-01','2001-01-01',NULL),('3','test3 test3 test3','.exclamationtrueisequaltofalse@gmail.com','124','Female','2001-01-01','reee','2001-01-01','2001-01-01',NULL),('5','test5 test5 test5','randomizedgg9@gmail.com','555','Female','2000-10-04','555','2001-01-01','2001-01-01',NULL),('6','test6 tset6 test6','randomizedgg9@gmail.com','666','Female','2022-10-12','111','2001-01-01','2001-01-01',NULL),('7','test7 test7 test7','randomizedgg9@gmail.com','777','Male','2022-10-19','777','2001-01-01','2001-01-01',NULL),('ea','fname mname lname','test1@gmail.com','tel','Female','2017-07-16','add','2019-07-16',NULL,'meh'),('id','fname mname lname','test2@gmail.cpom','435','Female','2016-07-14','add','2001-01-01','2001-01-01',NULL),('reeee','fname mname lname','test1@gmail.com','tel','Female','2020-07-15','add','2001-01-01','2001-01-01',NULL),('reeeese','fname mname lname','test1@gmail.com','tel','Female','2019-08-15','add','2001-01-01','2001-01-01',NULL),('te','fname mname lname','test1@gmail.com','tel','Female','2019-07-15','add','2022-10-15',NULL,NULL),('test1','fname mname lname','test2@gmail.cpom','435','Female','2018-07-15','123',NULL,'2001-01-01',NULL),('test2','fname mname lname','test1@gmail.com','tel','Female','2013-07-14','add','2021-08-16','2020-07-16',NULL),('test4','fname mname lname','test1@gmail.com','tel','Female','2017-07-14','add',NULL,'2020-07-15',NULL),('x','fname mname lname','test1@gmail.com','tel','Male','2017-08-15','add',NULL,NULL,NULL),('y','fname mname lname','test1@gmail.com','tel','Female','2019-08-17','add','2019-08-16',NULL,'brimdaddy'),('z','fname mname lname','test1@gmail.com','tel','Female','2019-08-17','add','2019-08-16',NULL,'brimdaddy');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacBrand`
--

DROP TABLE IF EXISTS `vacBrand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacBrand` (
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacBrand`
--

LOCK TABLES `vacBrand` WRITE;
/*!40000 ALTER TABLE `vacBrand` DISABLE KEYS */;
INSERT INTO `vacBrand` VALUES ('astra'),('brimdaddy'),('meh'),('test');
/*!40000 ALTER TABLE `vacBrand` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-20 14:19:57
