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
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`follow_id`),
  KEY `FK_follows` (`from_id`),
  KEY `FK_follows2` (`to_id`),
  CONSTRAINT `FK_follows` FOREIGN KEY (`from_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `FK_follows2` FOREIGN KEY (`to_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (21,39,38),(22,38,39),(23,40,38),(24,38,40),(25,41,38),(26,41,40),(27,41,39),(28,38,41),(29,39,41),(30,40,39),(31,38,43),(32,40,41),(33,40,41);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  KEY `FK_tweet_id_idx` (`tweet_id`),
  KEY `FK_user_id_idx` (`user_id`),
  CONSTRAINT `FK_tweet_id` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`tweet_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,65,38,'2018-12-03 18:11:32'),(2,63,38,'2018-12-03 18:44:12'),(3,64,38,'2018-12-03 18:44:34'),(7,72,41,'2018-12-05 00:47:28'),(8,73,40,'2018-12-05 18:50:59'),(9,75,38,'2018-12-05 19:04:29'),(10,75,40,'2018-12-05 19:13:07'),(11,73,38,'2018-12-05 19:14:58');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message_text` varchar(255) NOT NULL,
  `date_sent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_toid_idx` (`id`,`from_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (7,38,39,'hello','2018-12-03 18:55:09'),(8,38,39,'try','2018-12-03 18:57:46'),(9,40,38,'hello Luis','2018-12-03 19:06:02'),(10,38,40,'Hello Katy','2018-12-05 14:32:33'),(11,41,40,'Hello katy it\'s pao','2018-12-05 14:35:52'),(12,40,41,'hello katy is pao','2018-12-05 14:49:54');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (14,'my first tweet',38,0,0,'2018-10-26 17:54:06'),(15,'my second tweet',38,0,0,'2018-10-26 18:00:49'),(16,'nick first tweet',39,0,0,'2018-10-26 18:02:21'),(17,'nick second tweet',39,0,0,'2018-10-26 18:04:53'),(18,'nick third post',39,0,0,'2018-10-26 18:06:58'),(19,'my post',38,0,0,'2018-10-26 18:09:34'),(20,'test',38,0,0,'2018-10-26 18:56:14'),(21,'another test',38,0,0,'2018-10-26 18:58:38'),(22,'fsdafdas',39,0,0,'2018-10-31 16:37:24'),(23,'hello post',39,0,0,'2018-10-31 16:40:34'),(24,'wegrgqwe',38,0,0,'2018-10-31 17:12:42'),(25,'hello',38,0,0,'2018-11-01 18:32:04'),(26,'duplicated tweets',38,0,0,'2018-11-05 18:57:47'),(27,'my first tweet',40,0,0,'2018-11-05 19:15:19'),(28,'trying tweet class',38,0,0,'2018-11-05 19:21:33'),(29,'Luis\'',38,0,0,'2018-11-06 13:05:26'),(30,'my first tweet',38,27,0,'2018-11-06 13:44:05'),(31,'hello post',38,23,0,'2018-11-06 14:43:50'),(32,'hello post',38,31,0,'2018-11-07 18:52:44'),(33,'hello post',38,32,0,'2018-11-07 19:18:46'),(34,'paola first test. original',41,0,0,'2018-11-07 19:44:35'),(35,'can I still tweet?',38,0,0,'2018-11-07 19:50:01'),(36,'going back',38,0,0,'2018-11-07 19:59:36'),(37,'xc ',38,0,0,'2018-11-07 20:01:57'),(38,'posting',38,0,0,'2018-11-07 20:05:14'),(39,'what',38,0,38,'2018-11-09 04:05:57'),(40,'posting',41,38,0,'2018-11-09 14:28:18'),(41,'reply testing',41,0,38,'2018-11-09 14:36:38'),(42,'Reply',41,0,40,'2018-11-09 15:01:46'),(43,'here',41,0,38,'2018-11-09 15:03:20'),(44,'erg',41,0,38,'2018-11-09 15:05:21'),(45,'grqe',41,0,40,'2018-11-09 15:06:22'),(46,'brtw',41,0,40,'2018-11-09 15:07:12'),(47,'what',39,39,0,'2018-11-09 16:48:48'),(48,'katy\'s posting something',40,0,0,'2018-11-09 16:51:08'),(49,'what a bad tweet',38,0,48,'2018-11-09 16:51:46'),(50,'test',38,0,48,'2018-11-09 17:37:26'),(51,'please dont break',38,0,48,'2018-11-09 17:40:48'),(52,'one more reply test',41,0,0,'2018-11-09 17:46:02'),(53,'replying to original tweet test',38,0,52,'2018-11-09 17:46:40'),(54,'second test replying to original tweet',38,0,52,'2018-11-09 17:52:07'),(55,'third test',38,0,52,'2018-11-09 17:53:20'),(56,'test',38,0,0,'2018-11-14 18:41:18'),(57,'reply',38,0,56,'2018-11-14 18:41:27'),(58,'test 2',38,0,0,'2018-11-14 18:44:06'),(59,'reply 2',38,0,58,'2018-11-14 18:44:15'),(60,'test 3',38,0,0,'2018-11-14 18:46:08'),(61,'replpy 4',38,0,60,'2018-11-14 18:46:16'),(62,'test 4',38,0,0,'2018-11-14 18:47:12'),(63,'reply 4',38,0,62,'2018-11-14 18:47:22'),(64,'try tweets count',38,0,0,'2018-11-14 19:42:14'),(65,'like tweets',38,0,0,'2018-12-03 17:59:22'),(66,'try tweets count',38,64,0,'2018-12-03 18:44:31'),(67,'like tweets',39,65,0,'2018-12-04 22:17:00'),(68,'Notification test',40,0,0,'2018-12-04 22:35:38'),(69,'Notification test',38,68,0,'2018-12-04 22:36:03'),(70,'Notification test',41,68,0,'2018-12-04 23:52:04'),(71,'notification second test',40,0,0,'2018-12-05 00:41:29'),(72,'notification third test',40,0,0,'2018-12-05 00:43:41'),(73,'is wampserver up?',41,0,0,'2018-12-05 17:36:07'),(74,'is wampserver up?',40,73,0,'2018-12-05 18:51:37'),(75,'trying notifications for paola',41,0,0,'2018-12-05 19:04:12');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `screen_name` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address` varchar(200) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `contact_number` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(50) NOT NULL,
  `description` varchar(160) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (38,'Luis','Paredes','luisparedes04','$2y$10$YnjqkOpVs8KFUJodWnpnkODeJHDkWNQy.y4bh5..1MIrtmj5PWFSy','street','New Brunswick','E3B2S3','5062598411','luissao_20@hotmail.com','https://www.example.com','My official bitter account','Fredericton','2018-10-26 17:53:32','38.jpeg'),(39,'Nick','Taggart','nick','$2y$10$ttxIMYTpPmtnfPFbheeF/.Xr.Ph5TO2/sOP5ioEXAdwZ5Qa8wizLq','nbcc','New Brunswick','A1A 1A1','506 123 4567','nick.taggart@nbcc.ca','https://www.example.com','Nick test account','Fredericton','2018-10-26 17:59:20',NULL),(40,'Katherine','Vasquez','katherinedvl','$2y$10$GH8jknK18hoy//3eBykK/uKenPQLuDWRK3t5PjpJZ32qSCO5J4XFm','some st','New Brunswick','A1A 1A1','5061234567','kvasquez@gmail.com','https://www.example.com','katys page','Fredericton','2018-11-01 14:44:58',NULL),(41,'Paola','Echeverria','paolae97','$2y$10$QaZMYZZsCj0O.31cDljyzOH2qimqr0sX2zmJTQUHEBqJb9qws74nu','some st','New Brunswick','A1A 1A1','5063456789','paola@gmail.com','https://www.example.com','paolas page','Fredericton','2018-11-05 18:05:04','41.jpeg'),(42,'Dorys','Perez','dorysperez','$2y$10$p.PX62Vpd4SD3G29OSvON.Jiw1xtROoSrV8Zc5v3sihJJns18rhWG','some st','Prince Edward Island','E3B2S3','506 123 4567','dorysperez@hotmail.com','https://www.example.com','Dorys\' page','Fredericton','2018-11-21 19:05:07',NULL),(43,'Alfredo','Paredes','alfredoepd','$2y$10$wjLRDfhP9lbp75jS2U6ArOwnvNzAcVgCXHTjFBkOJGXIdeSI8gyxm','some st','New Brunswick','E3B2S3','506 123 4567','alfredo@gmail.com','https://www.example.com','Alfred\'s page','Fredericton','2018-11-21 19:13:50',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-07 12:01:05
