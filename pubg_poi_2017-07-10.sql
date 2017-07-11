# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.28)
# Database: pubg_poi
# Generation Time: 2017-07-11 02:10:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table map_pois
# ------------------------------------------------------------

DROP TABLE IF EXISTS `map_pois`;

CREATE TABLE `map_pois` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext,
  `type` int(11) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `long` float DEFAULT NULL,
  `mapname` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `map_pois` WRITE;
/*!40000 ALTER TABLE `map_pois` DISABLE KEYS */;

INSERT INTO `map_pois` (`id`, `name`, `type`, `lat`, `long`, `mapname`)
VALUES
	(1,'Deadeye Rock',0,-215,115,'quaid'),
	(2,'Another Place',0,-420,220,'deadeye'),
	(3,'Test',1,-188.5,266,'deadeye'),
	(4,'Test',1,-188.5,266,'deadeye'),
	(5,'Test',1,-350.5,243,'deadeye'),
	(6,'Test',1,-350.5,243,'deadeye'),
	(7,'Test',1,-160.5,194,'deadeye'),
	(8,'Test',1,-160.5,194,'deadeye'),
	(9,'Test',1,-127.5,374,'deadeye'),
	(10,'Test',1,-127.5,374,'deadeye'),
	(11,'Test',1,-160.5,194,'deadeye'),
	(12,'Test',1,-160.5,194,'deadeye'),
	(14,'Test',1,-160.5,194,'deadeye'),
	(15,'Test',1,-160.5,194,'deadeye'),
	(16,'Test',1,-127.5,374,'deadeye'),
	(17,'Test',1,-127.5,374,'deadeye'),
	(18,'Test',1,-147,210.5,'quaid'),
	(19,'Test',1,-147,210.5,'quaid'),
	(20,'Test',1,-147,157,'quaid'),
	(21,'Test',1,-147,157,'quaid'),
	(22,'Test',1,-147,157,'quaid'),
	(23,'Test',1,-147,157,'quaid'),
	(24,'Test',1,-147,157,'quaid'),
	(25,'Test',1,-147,157,'quaid'),
	(26,'Test',1,-147,157,'quaid'),
	(27,'Test',1,-147,157,'quaid'),
	(28,'Test',1,-147,157,'quaid'),
	(29,'Test',1,-147,157,'quaid'),
	(30,'Test',1,-147,157,'quaid'),
	(31,'Test',1,-147,157,'quaid'),
	(32,'Test',1,-147,157,'quaid'),
	(33,'Test',1,-147,157,'quaid'),
	(34,'Test',1,-300.5,220,'quaid'),
	(35,'Test',1,-300.5,220,'quaid'),
	(36,'Test',1,-305.5,340.5,'quaid'),
	(37,'Test',1,-305.5,340.5,'quaid');

/*!40000 ALTER TABLE `map_pois` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
