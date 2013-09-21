-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: internal-db.s93492.gridserver.com
-- Generation Time: Sep 21, 2013 at 08:59 AM
-- Server version: 5.1.55-rel12.6
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db93492_mcbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `position` tinyint(4) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `excerpt` varchar(1000) NOT NULL,
  `subtitle` varchar(200) NOT NULL,
  `bulletin_date` date NOT NULL,
  `graphic` varchar(150) DEFAULT NULL,
  `alt_text` varchar(100) DEFAULT NULL,
  `graphic_link` varchar(150) DEFAULT NULL,
  `thumbnail` varchar(100) DEFAULT NULL,
  `bookmark` varchar(20) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `date_position` (`bulletin_date`,`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
