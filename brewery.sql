-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for debian-linux-gnueabihf (armv7l)
--
-- Host: localhost    Database: brewery
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `brewery`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `brewery` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `brewery`;

--
-- Table structure for table `fermenter`
--

DROP TABLE IF EXISTS `fermenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fermenter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos` int(11) DEFAULT NULL,
  `gpio` int(11) DEFAULT NULL,
  `temp_serial` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fermenter`
--

LOCK TABLES `fermenter` WRITE;
/*!40000 ALTER TABLE `fermenter` DISABLE KEYS */;
INSERT INTO `fermenter` VALUES (1,1,17,'28-0417711245ff'),(2,2,27,NULL),(3,3,22,NULL),(4,4,5,NULL),(5,5,6,NULL),(6,6,13,NULL),(7,7,19,NULL),(8,8,26,NULL);
/*!40000 ALTER TABLE `fermenter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fermenting`
--

DROP TABLE IF EXISTS `fermenting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fermenting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ferm_pos` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fermenting`
--

LOCK TABLES `fermenting` WRITE;
/*!40000 ALTER TABLE `fermenting` DISABLE KEYS */;
INSERT INTO `fermenting` VALUES (1,1,2,'2019-06-22 15:03:01'),(2,3,4,NULL),(3,3,4,'0000-00-00 00:00:00'),(4,3,4,'2019-06-23 14:41:54'),(5,3,4,'2019-06-23 14:44:00');
/*!40000 ALTER TABLE `fermenting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe`
--

LOCK TABLES `recipe` WRITE;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` VALUES (1,'updated'),(2,'Parkway Pale Ale'),(3,'RoundAbout Stout'),(4,'OnRamp Golden Ale'),(5,'The Bees Knees Honey Ale'),(6,'Test Recipe');
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_intervals`
--

DROP TABLE IF EXISTS `recipe_intervals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_interval` int(11) DEFAULT NULL,
  `start_temp` int(11) DEFAULT NULL,
  `end_temp` int(11) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_intervals`
--

LOCK TABLES `recipe_intervals` WRITE;
/*!40000 ALTER TABLE `recipe_intervals` DISABLE KEYS */;
INSERT INTO `recipe_intervals` VALUES (1,1,66,66,21,1);
/*!40000 ALTER TABLE `recipe_intervals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-24  5:27:44
