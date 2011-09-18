# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.15-55-log)
# Database: spotify_imdb
# Generation Time: 2011-09-17 16:56:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table movie
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movie`;

CREATE TABLE `movie` (
  `id` int(11) unsigned NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `original_title` varchar(255) DEFAULT NULL,
  `description` varchar(511) DEFAULT NULL,
  `year` smallint(4) NOT NULL,
  `director` varchar(128) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `rank` smallint(6) unsigned NOT NULL DEFAULT '0',
  `rating` decimal(2,2) unsigned NOT NULL DEFAULT '0.00',
  `votes` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_idx` (`title`),
  KEY `year_idx` (`year`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
