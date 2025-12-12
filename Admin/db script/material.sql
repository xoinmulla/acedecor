-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 27, 2021 at 11:56 AM
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
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `Material_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Material_Name` varchar(100) NOT NULL,
  `Material_Code` varchar(100) NOT NULL,
  `Material_Description` varchar(100) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `SubCategory` varchar(100) NOT NULL,
  `Brand` varchar(100) NOT NULL,
  `Mat_Unit` varchar(100) NOT NULL,
  `Mat_factor` double NOT NULL,
  `Mat_Image` varchar(200) NOT NULL,
  `Mat_Rotation` varchar(100) NOT NULL,
  `Mat_createdBy` varchar(100) NOT NULL,
  `Mat_modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`Material_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`Material_Id`, `Material_Name`, `Material_Code`, `Material_Description`, `Category`, `SubCategory`, `Brand`, `Mat_Unit`, `Mat_factor`, `Mat_Image`, `Mat_Rotation`, `Mat_createdBy`, `Mat_modifiedBy`) VALUES
(1, 'AAA', 'AAA123', 'aaa', '52', '38', '13', '54', 2, '', '1', 'info@acedecors.in', 'info@acedecors.in');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
