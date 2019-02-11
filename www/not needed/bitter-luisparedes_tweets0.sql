CREATE DATABASE  IF NOT EXISTS `bitter-luisparedes` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bitter-luisparedes`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bitter-luisparedes
-- ------------------------------------------------------
-- Server version	5.7.21

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
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_text` varchar(280) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `original_tweet_id` int(11) NOT NULL DEFAULT '0',
  `reply_to_tweet_id` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tweet_id`),
  KEY `FK_tweets` (`user_id`),
  CONSTRAINT `FK_tweets` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (14,'my first tweet',38,0,0,'2018-10-26 17:54:06'),(15,'my second tweet',38,0,0,'2018-10-26 18:00:49'),(16,'nick first tweet',39,0,0,'2018-10-26 18:02:21'),(17,'nick second tweet',39,0,0,'2018-10-26 18:04:53'),(18,'nick third post',39,0,0,'2018-10-26 18:06:58'),(19,'my post',38,0,0,'2018-10-26 18:09:34'),(20,'test',38,0,0,'2018-10-26 18:56:14'),(21,'another test',38,0,0,'2018-10-26 18:58:38'),(22,'fsdafdas',39,0,0,'2018-10-31 16:37:24'),(23,'hello post',39,0,0,'2018-10-31 16:40:34'),(24,'wegrgqwe',38,0,0,'2018-10-31 17:12:42'),(25,'hello',38,0,0,'2018-11-01 18:32:04'),(26,'duplicated tweets',38,0,0,'2018-11-05 18:57:47'),(27,'my first tweet',40,0,0,'2018-11-05 19:15:19'),(28,'trying tweet class',38,0,0,'2018-11-05 19:21:33'),(29,'Luis\'',38,0,0,'2018-11-06 13:05:26'),(30,'my first tweet',38,27,0,'2018-11-06 13:44:05'),(31,'hello post',38,23,0,'2018-11-06 14:43:50'),(32,'hello post',38,31,0,'2018-11-07 18:52:44'),(33,'hello post',38,32,0,'2018-11-07 19:18:46'),(34,'paola first test. original',41,0,0,'2018-11-07 19:44:35'),(35,'can I still tweet?',38,0,0,'2018-11-07 19:50:01'),(36,'going back',38,0,0,'2018-11-07 19:59:36'),(37,'xc ',38,0,0,'2018-11-07 20:01:57'),(38,'posting',38,0,0,'2018-11-07 20:05:14'),(39,'what',38,0,38,'2018-11-09 04:05:57'),(40,'posting',41,38,0,'2018-11-09 14:28:18'),(41,'reply testing',41,0,38,'2018-11-09 14:36:38'),(42,'Reply',41,0,40,'2018-11-09 15:01:46'),(43,'here',41,0,38,'2018-11-09 15:03:20'),(44,'erg',41,0,38,'2018-11-09 15:05:21'),(45,'grqe',41,0,40,'2018-11-09 15:06:22'),(46,'brtw',41,0,40,'2018-11-09 15:07:12'),(47,'what',39,39,0,'2018-11-09 16:48:48'),(48,'katy\'s posting something',40,0,0,'2018-11-09 16:51:08'),(49,'what a bad tweet',38,0,48,'2018-11-09 16:51:46'),(50,'test',38,0,48,'2018-11-09 17:37:26'),(51,'please dont break',38,0,48,'2018-11-09 17:40:48'),(52,'one more reply test',41,0,0,'2018-11-09 17:46:02'),(53,'replying to original tweet test',38,0,52,'2018-11-09 17:46:40'),(54,'second test replying to original tweet',38,0,52,'2018-11-09 17:52:07'),(55,'third test',38,0,52,'2018-11-09 17:53:20');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-09 14:45:22
