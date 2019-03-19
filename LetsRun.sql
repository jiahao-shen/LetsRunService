-- MySQL dump 10.17  Distrib 10.3.12-MariaDB, for osx10.14 (x86_64)
--
-- Host: localhost    Database: LetsRun
-- ------------------------------------------------------
-- Server version	10.3.12-MariaDB

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
-- Table structure for table `add_friend_request`
--

DROP TABLE IF EXISTS `add_friend_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `add_friend_request` (
  `from_telephone` varchar(20) NOT NULL,
  `to_telephone` varchar(20) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`from_telephone`,`to_telephone`),
  KEY `to_telephone` (`to_telephone`),
  CONSTRAINT `add_friend_request_ibfk_1` FOREIGN KEY (`from_telephone`) REFERENCES `user_list` (`telephone`),
  CONSTRAINT `add_friend_request_ibfk_2` FOREIGN KEY (`to_telephone`) REFERENCES `user_list` (`telephone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `add_friend_request`
--

LOCK TABLES `add_friend_request` WRITE;
/*!40000 ALTER TABLE `add_friend_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `add_friend_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `fuck` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (1,'fuck',1),(2,'test',0);
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_list`
--

DROP TABLE IF EXISTS `user_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_list` (
  `telephone` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `qq_id` varchar(255) DEFAULT NULL,
  `wechat_id` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(5) DEFAULT NULL,
  `blood` varchar(5) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `register_time` datetime NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `friend_list` varchar(20000) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `goal_steps` int(5) DEFAULT 10000,
  `is_count_step` int(2) DEFAULT 1,
  PRIMARY KEY (`telephone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_list`
--

LOCK TABLES `user_list` WRITE;
/*!40000 ALTER TABLE `user_list` DISABLE KEYS */;
INSERT INTO `user_list` VALUES ('13915558435','$2y$10$LLY2Cw91pryz9NXtKykPv.pIqxxBYTiaNpIoylC/6Cl7GF1laCDa2','身价好',NULL,NULL,'2019-03-19','男','O',175,60,'2019-03-19 23:16:49','7f8180ba4a77a35a36f1f2820194fa01',NULL,'随你不敢发的','HUAWEI',10000,1);
/*!40000 ALTER TABLE `user_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-20  0:44:38
