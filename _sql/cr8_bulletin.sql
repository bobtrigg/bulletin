-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2013 at 03:45 PM
-- Server version: 5.5.33
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bobtrigg_bulletin`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `item_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `position` tinyint(4) NOT NULL,
  `title` varchar(80) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `excerpt` varchar(200) NOT NULL,
  `subtitle` varchar(80) NOT NULL,
  `bulletin_date` date NOT NULL,
  `graphic` varchar(150) NOT NULL,
  `alt_text` varchar(100) NOT NULL,
  `thumbnail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `position`, `title`, `content`, `excerpt`, `subtitle`, `bulletin_date`, `graphic`, `alt_text`, `thumbnail`) VALUES
(1, 1, 'First', 'thisnthat', 'excerpt this', 'Item', '2013-08-07', 'Images/2013/SRTwilight.jpg', 'San Rafael Twilight Criterium', 'Images/2013/SRTwilight.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
