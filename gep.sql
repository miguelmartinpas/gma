-- MySQL dump 10.13  Distrib 5.5.39, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: gep
-- ------------------------------------------------------
-- Server version	5.5.39

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
-- Table structure for table `Status`
--

DROP TABLE IF EXISTS `Status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `colour` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `isDefaultStatus` int(11) NOT NULL,
  `idNextStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7CAC602A12583920` (`idNextStatus`),
  CONSTRAINT `FK_7CAC602A12583920` FOREIGN KEY (`idNextStatus`) REFERENCES `Status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Status`
--

LOCK TABLES `Status` WRITE;
/*!40000 ALTER TABLE `Status` DISABLE KEYS */;
INSERT INTO `Status` VALUES (1,'Sin estado','glyphicon-minus','btn',1,2),(2,'Activo','glyphicon-ok','btn-success',0,3),(3,'Inactivo','glyphicon-remove','btn-danger',0,4),(4,'Reserva','glyphicon-asterisk','btn-warning',0,1);
/*!40000 ALTER TABLE `Status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SystemParam`
--

DROP TABLE IF EXISTS `SystemParam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SystemParam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AF4E1FB78A90ABA9` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SystemParam`
--

LOCK TABLES `SystemParam` WRITE;
/*!40000 ALTER TABLE `SystemParam` DISABLE KEYS */;
INSERT INTO `SystemParam` VALUES (1,'adminname','superadmin'),(2,'adminpass','5a5bffd1b2ad0285463636f8527cfd15'),(3,'adminid','999999999'),(4,'path','/web');
/*!40000 ALTER TABLE `SystemParam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `isadmin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA179778D93D649` (`user`),
  UNIQUE KEY `UNIQ_2DA17977E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'inmacerezo','a364a403cd69620cdd5d7c2803bcfce0','Inma Cerezo','inmacerezo@hotmail.com',0),(2,'lola','e1894e698158e13b90812d05064b61a5','Lola Martin','dmherrera@malaga.eu',0),(3,'mariajesus','4a8e17a1fbc2da095dc301c1d59246f1','Maria Jesus','mjgallegopa@hotmail.com',0),(4,'sandra','0bbd3d1e8c0d1180c254014415d4aac0','Sandra Armada','slarmada@hotmail.com',0),(5,'marisa ','92c0b564bdd2987b17806c2950ff8bfb','Marisa','mlmerida@malaga.eu',0),(6,'joseantonio ','93ff8a4946afd40e3de9c58831781ab3','Jose Antonio','martosgea@hotmail.com',0),(7,'joserosado','8f64cf6de6416d1bb04fe54cf409609f','Jose Rosado','joserosadoblanco@gmail.com',0),(8,'pacosaldana','e2022f7ee66fbac28cf7d3e16d9d339b','Paco Saldana','fransalpe@hotmail.com',0),(9,'juanantonio','52593fb14199f8cc1de5ddca07dd8cc8','Juan Antonio','jrios1986@hotmail.com',0),(10,'rosario','3d9dbff9d7cb6258362a4d85102bfb66','Rosario','rvalera@malaga.eu',0),(11,'paloma','951562c743cb698ee3baf0a81ac2888c','Paloma','polveira@malaga.eu',0),(12,'miguelangel','6e4147ccff0b59ac1d28ac0b5aa005ca','Miguel Angel','miguebau@hotmail.com',0),(13,'mar','90901171d71d7c1ef6564403fef88495','Mar','mmmerchan@malaga.eu',0),(14,'juan','6238ce3f53bc3181fedc80650817c8f8','Juan Mendez','jjmendez@malaga.eu',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserWeek`
--

DROP TABLE IF EXISTS `UserWeek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserWeek` (
  `idUser` int(11) NOT NULL,
  `idWeek` int(11) NOT NULL,
  `idStatus` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idWeek`,`idStatus`),
  KEY `IDX_A463DCD9FE6E88D7` (`idUser`),
  KEY `IDX_A463DCD928A7375E` (`idWeek`),
  KEY `IDX_A463DCD91811CD86` (`idStatus`),
  CONSTRAINT `FK_A463DCD91811CD86` FOREIGN KEY (`idStatus`) REFERENCES `Status` (`id`),
  CONSTRAINT `FK_A463DCD928A7375E` FOREIGN KEY (`idWeek`) REFERENCES `Week` (`id`),
  CONSTRAINT `FK_A463DCD9FE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `User` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserWeek`
--

LOCK TABLES `UserWeek` WRITE;
/*!40000 ALTER TABLE `UserWeek` DISABLE KEYS */;
INSERT INTO `UserWeek` VALUES (1,49,1),(1,50,1),(1,51,1),(1,52,1),(2,49,1),(2,50,1),(2,51,1),(2,52,1),(3,49,1),(3,50,1),(3,51,1),(3,52,1),(4,49,1),(4,50,1),(4,51,1),(4,52,1),(5,49,1),(5,50,1),(5,51,1),(5,52,1),(6,49,1),(6,50,1),(6,51,1),(6,52,1),(7,49,1),(7,50,1),(7,51,1),(7,52,1),(8,49,1),(8,50,1),(8,51,1),(8,52,1),(9,49,1),(9,50,1),(9,51,1),(9,52,1),(10,49,1),(10,50,1),(10,51,1),(10,52,1),(11,49,2),(11,50,2),(11,51,2),(11,52,2),(12,49,1),(12,50,1),(12,51,1),(12,52,1),(13,49,1),(13,50,1),(13,51,1),(13,52,1),(14,49,2),(14,50,2),(14,51,2),(14,52,2);
/*!40000 ALTER TABLE `UserWeek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Week`
--

DROP TABLE IF EXISTS `Week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Week`
--

LOCK TABLES `Week` WRITE;
/*!40000 ALTER TABLE `Week` DISABLE KEYS */;
INSERT INTO `Week` VALUES (1,1,2014),(2,2,2014),(3,3,2014),(4,4,2014),(5,5,2014),(6,6,2014),(7,7,2014),(8,8,2014),(9,9,2014),(10,10,2014),(11,11,2014),(12,12,2014),(13,13,2014),(14,14,2014),(15,15,2014),(16,16,2014),(17,17,2014),(18,18,2014),(19,19,2014),(20,20,2014),(21,21,2014),(22,22,2014),(23,23,2014),(24,24,2014),(25,25,2014),(26,26,2014),(27,27,2014),(28,28,2014),(29,29,2014),(30,30,2014),(31,31,2014),(32,32,2014),(33,33,2014),(34,34,2014),(35,35,2014),(36,36,2014),(37,37,2014),(38,38,2014),(39,39,2014),(40,40,2014),(41,41,2014),(42,42,2014),(43,43,2014),(44,44,2014),(45,45,2014),(46,46,2014),(47,47,2014),(48,48,2014),(49,49,2014),(50,50,2014),(51,51,2014),(52,52,2014);
/*!40000 ALTER TABLE `Week` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-12 18:37:34
