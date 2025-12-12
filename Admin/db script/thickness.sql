-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2021 at 12:09 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acedecors`
--

-- --------------------------------------------------------

--
-- Table structure for table `thickness`
--

DROP TABLE IF EXISTS `thickness`;
CREATE TABLE IF NOT EXISTS `thickness` (
  `Thickness_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Thickness` varchar(100) NOT NULL,
  `Thickness_createdby` varchar(100) NOT NULL,
  `Thickness_modifiedby` varchar(100) NOT NULL,
  `Thickness_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Thickness_modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Thickness_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thickness`
--

INSERT INTO `thickness` (`Thickness_Id`, `Thickness`, `Thickness_createdby`, `Thickness_modifiedby`, `Thickness_createdOn`, `Thickness_modifiedOn`) VALUES
(1, '40mm', 'info@acedecors.in', 'info@acedecors.in', '2021-12-08 16:09:14', '2021-12-08 16:09:14');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
