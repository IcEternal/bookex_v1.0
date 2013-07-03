-- MySQL dump 10.13  Distrib 5.1.67, for debian-linux-gnu (x86_64)
--
-- Host: 172.16.6.107    Database: bookex
-- ------------------------------------------------------
-- Server version	5.1.66-0ubuntu0.11.10.3

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `price` double DEFAULT NULL,
  `publisher` varchar(32) NOT NULL,
  `ISBN` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `uploader` varchar(20) NOT NULL,
  `subscriber` varchar(20) NOT NULL DEFAULT 'N',
  `originprice` double NOT NULL,
  `subscribetime` datetime NOT NULL,
  `finishtime` datetime NOT NULL,
  `img` longblob NOT NULL,
  `hasimg` tinyint(1) NOT NULL,
  `class` varchar(256) DEFAULT NULL,
  `show_phone` tinyint(1) NOT NULL,
  `use_phone` tinyint(1) NOT NULL,
  `del` tinyint(1) NOT NULL,
  `deltime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2179 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `book_collect`
--

DROP TABLE IF EXISTS `book_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_collect` (
  `bc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `translator` varchar(128) NOT NULL,
  `price` varchar(50) DEFAULT NULL,
  `publisher` varchar(32) NOT NULL,
  `pubdate` varchar(32) NOT NULL,
  `ISBN` varchar(32) NOT NULL,
  `img` longblob NOT NULL,
  PRIMARY KEY (`bc_id`),
  KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB AUTO_INCREMENT=2592 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `book_search`
--

DROP TABLE IF EXISTS `book_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_search` (
  `bs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_info` varchar(63) DEFAULT NULL,
  `uploader` varchar(63) DEFAULT NULL,
  `subscriber` varchar(63) DEFAULT NULL,
  `no_reserve` tinyint(1) DEFAULT '1',
  `reserved` tinyint(1) DEFAULT '1',
  `traded` tinyint(1) DEFAULT '1',
  `admin_name` varchar(63) NOT NULL,
  `bs_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bs_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `student_number` varchar(10) NOT NULL,
  `show_phone` tinyint(1) NOT NULL,
  `dormitory` varchar(128) DEFAULT NULL,
  `alipay` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=645 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_search`
--

DROP TABLE IF EXISTS `user_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_search` (
  `us_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(63) DEFAULT NULL,
  `phone` varchar(63) DEFAULT NULL,
  `email` varchar(63) DEFAULT NULL,
  `student_number` varchar(63) DEFAULT NULL,
  `order_by_up` tinyint(1) DEFAULT '1',
  `admin_name` varchar(63) NOT NULL,
  `us_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`us_id`)
) ENGINE=MyISAM AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-03 22:02:03
