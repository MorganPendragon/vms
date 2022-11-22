-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: Vaccine
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
INSERT INTO `faculty` VALUES ('F1-123414','gavsdv:ghjg:ghchg','test@email.com','09284617234','Female','2022-11-19','asf'),('F1-231232','xfac:sad:asd','test@email.com','09284617234','Male','2022-12-08','asd'),('F1-412412','lkjasfl:lhl:dcnvbc','test@email.com','09284617234','Male','2022-11-19','fgak'),('F2-123132','xacas:sda:zxc','eme@email.com','09432345256','Female','2022-11-12','licaong NE'),('F2-142412','jkhk:nbmn:cdgh','test@email.com','09284617234','Male','2022-11-11','jhkh'),('F2-212313','klajsd:kjg:ghd','test@email.com','09284617234','Female','2022-11-04','ljkk');
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
INSERT INTO `logcredentials` VALUES ('12-321234','wkffs46m'),('12-326732','7ofo2ja2'),('12-372345','7imxxarl'),('12-372743','lkmz8qzq'),('12-372747','8f4m8eib'),('21-123728','73ep3xce'),('21-232134','sjld149o'),('23-212654','qv7hm6m3'),('31-123128','y2g9igf7'),('43-123215','0o8rus0u'),('F1-123414','xbqdrp2w'),('F1-231232','lmlc082w'),('F1-412412','pn8yrujj'),('F2-123132','2qn3vseu'),('F2-142412','l7llazpl'),('F2-212313','60iiqkfj');
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
INSERT INTO `student` VALUES ('12-321234','qwe:qwe:as','Grade 9','Enrolled','testa@gmail.com','09224521234','Male','2022-11-08','asdsd'),('12-326732','asd:asd:asd','Grade 8','Enrolled','test@gmail.com','09224521234','Male','2022-11-20','test'),('12-372345','asdq:asd:aa','Grade 10','Enrolled','testa@gmail.com','09224521234','Female','2022-11-09','asdsd'),('12-372743','asd:s:sasd','Grade 9','Enrolled','test@gmail.com','09224521234','Male','2022-11-21','asdsd'),('12-372747','asd:asd:asd','Grade 8','Enrolled','test@gmail.com','09224521234','Male','2022-11-08','add'),('21-123728','aasd:asd:s','Grade 9','Dropped','testa@gmail.com','09224521234','Female','2022-11-02','add'),('21-232134','asd:asd:asd','Grade 7','Enrolled','test@gmail.com','09224521234','Male','2022-11-24','asdsd'),('23-212654','asd:a:sdasd','Grade 9','Enrolled','testa@gmail.com','09224521234','Female','2022-11-01','add'),('31-123128','asd:a:asds','Grade 7','Dropped','testa@gmail.com','09224521234','Male','2022-11-21','test'),('43-123215','as:h:gajsd','Grade 7','Enrolled','test@gmail.com','09224521234','Male','2022-11-09','asdsd');
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
INSERT INTO `vacbrand` VALUES ('astra'),('j&j'),('moderna'),('pfizer'),('sino');
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
INSERT INTO `vaccinestatus` VALUES ('12-321234','2022-11-10','asd','2022-11-14','asd','sino','2022-11-21','sda','astra'),('12-326732','2022-11-17','sda','2022-11-09','asd','j&j','2022-11-25','asda','j&j'),('12-372345','2022-11-09','asda','2022-11-14','asd','moderna','2022-11-30','asd','pfizer'),('12-372743','2022-11-14','asdw','2022-11-20','asd','astra','2022-11-10','asda','moderna'),('12-372747','2022-11-11','happy','2022-11-07','happy','j&j','2022-11-01','happy','j&j'),('21-123728','2022-11-17','asdad','2022-11-12','asd','sino','2022-11-29','asd','pfizer'),('21-232134','2022-11-09','asda','2022-11-16','asd','pfizer','2022-11-18','asda','astra'),('23-212654','2022-11-17','asd','2022-11-22','asd','j&j','2022-11-06','asda','astra'),('31-123128','2022-11-15','asd','2022-11-16','asda','j&j','2022-11-14','asd','moderna'),('43-123215','2022-11-08','asd','2022-11-23','asd','astra','2022-11-24','asd','pfizer'),('F1-123414','2022-11-19','af','2022-11-18','dsga','astra','2022-11-26','jkh','pfizer'),('F1-231232','2022-12-02','ad','2022-11-17','qwe','pfizer','2022-11-12','qwe','j&j'),('F1-412412','2022-11-19','klj','2022-11-10','jhkjh','moderna','2022-11-05','nmb','j&j'),('F2-123132','2022-11-19','aweqw','2022-11-19','rqwtrfcas','astra','2022-11-19','ASDW','moderna'),('F2-142412','2022-11-05','mnb','2022-11-12','bnvc','astra','2022-11-12','nbmnb','sino'),('F2-212313','2022-11-03','hjgjhg','2022-11-25','hjgjhg','j&j','2022-12-03','hjgjhgj','sino');
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

-- Dump completed on 2022-11-23  1:08:35
