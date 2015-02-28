CREATE DATABASE  IF NOT EXISTS `exam` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `exam`;
-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: exam
-- ------------------------------------------------------
-- Server version 5.5.41-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Apply`
--

DROP TABLE IF EXISTS `Apply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Apply_1_idx` (`exam_id`),
  CONSTRAINT `fk_Apply_1` FOREIGN KEY (`exam_id`) REFERENCES `Exam` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Apply`
--

LOCK TABLES `Apply` WRITE;
/*!40000 ALTER TABLE `Apply` DISABLE KEYS */;
/*!40000 ALTER TABLE `Apply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Attempt`
--

DROP TABLE IF EXISTS `Attempt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apply_id` int(11) DEFAULT NULL,
  `choice_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Try_1_idx` (`apply_id`),
  KEY `fk_Try_2_idx` (`choice_id`),
  CONSTRAINT `fk_Try_1` FOREIGN KEY (`apply_id`) REFERENCES `Apply` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Try_2` FOREIGN KEY (`choice_id`) REFERENCES `Choice` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Attempt`
--

LOCK TABLES `Attempt` WRITE;
/*!40000 ALTER TABLE `Attempt` DISABLE KEYS */;
INSERT INTO `Attempt` VALUES (2,NULL,1);
/*!40000 ALTER TABLE `Attempt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Choice`
--

DROP TABLE IF EXISTS `Choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Option_1_idx` (`question_id`),
  CONSTRAINT `fk_Option_1` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Choice`
--

LOCK TABLES `Choice` WRITE;
/*!40000 ALTER TABLE `Choice` DISABLE KEYS */;
INSERT INTO `Choice` VALUES (1,1,'get_methods','2015-02-25 14:14:23',NULL),(2,1,'get_class','2015-02-25 14:15:39',NULL),(3,1,'get_operators','2015-02-25 14:15:39',NULL),(4,1,'get_func_names','2015-02-25 14:15:40',NULL);
/*!40000 ALTER TABLE `Choice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Exam`
--

DROP TABLE IF EXISTS `Exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Exam`
--

LOCK TABLES `Exam` WRITE;
/*!40000 ALTER TABLE `Exam` DISABLE KEYS */;
INSERT INTO `Exam` VALUES (1,'ZCE','zce','Exam about php zend certified engineer','2015-02-25 13:48:09',NULL),(2,'LP1','lp1','Exam about linux centification level one','2015-02-26 00:42:21',NULL),(3,'LP2','lp2','Exam about linux centification level two','2015-02-26 00:42:22',NULL),(4,'Mysql db admin','mysql-db-admin','Exam about mysql','2015-02-26 00:42:22',NULL),(5,'Java','java','Exam about Java','2015-02-26 00:42:23',NULL);
/*!40000 ALTER TABLE `Exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Question`
--

DROP TABLE IF EXISTS `Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `choice_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Question_1_idx` (`exam_id`),
  CONSTRAINT `fk_Question_1` FOREIGN KEY (`exam_id`) REFERENCES `Exam` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question`
--

LOCK TABLES `Question` WRITE;
/*!40000 ALTER TABLE `Question` DISABLE KEYS */;
INSERT INTO `Question` VALUES (1,1,'Which function return all methods of an object?',1,'2015-02-25 13:48:09',NULL,'which-function-return-all'),(2,1,'Which these words are not reserveds in php 5.5?',NULL,'2015-02-25 13:48:09',NULL,'which-these-words-are-not');
/*!40000 ALTER TABLE `Question` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-28  2:47:45
