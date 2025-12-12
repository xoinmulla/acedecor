-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 04, 2021 at 11:54 AM
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) NOT NULL,
  `product_description` varchar(200) NOT NULL,
  `product_dimensions` varchar(100) NOT NULL,
  `product_dimensionsid` int(11) NOT NULL,
  `product_item` varchar(200) NOT NULL,
  `product_itemid` int(11) NOT NULL,
  `item_category` varchar(100) NOT NULL,
  `item_catid` int(11) NOT NULL,
  `item_subcategory` varchar(100) NOT NULL,
  `item_subcatid` int(11) NOT NULL,
  `product_brand` varchar(100) NOT NULL,
  `product_brandid` int(11) NOT NULL,
  `product_itemcode` int(20) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_categoryid` int(11) NOT NULL,
  `product_subcategory` varchar(100) NOT NULL,
  `product_subcategoryid` int(11) NOT NULL,
  `product_quantity` int(10) NOT NULL,
  `product_store` varchar(50) NOT NULL,
  `product_unit` varchar(100) NOT NULL,
  `product_unitid` int(11) NOT NULL,
  `product_barcode` varchar(100) NOT NULL,
  `productID` varchar(100) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
