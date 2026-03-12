-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2026 at 11:04 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '',
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `worked_hours` decimal(5,2) DEFAULT '0.00',
  `ot_hours` decimal(5,2) DEFAULT '0.00',
  `ot_pay` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `emp_id`, `date`, `status`, `in_time`, `out_time`, `remarks`, `created_at`, `worked_hours`, `ot_hours`, `ot_pay`) VALUES
(92, 39, '2026-02-18', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-04 12:41:46', 2.50, 0.00, 0.00),
(90, 38, '2026-02-18', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-04 11:18:52', 2.50, 0.00, 0.00),
(93, 39, '2026-02-19', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:14:25', 2.50, 0.00, 0.00),
(94, 38, '2026-02-19', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:14:59', 2.50, 0.00, 0.00),
(95, 39, '2026-02-20', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:17:39', 2.50, 0.00, 0.00),
(96, 38, '2026-02-20', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:18:00', 2.50, 0.00, 0.00),
(97, 39, '2026-02-21', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:18:23', 2.50, 0.00, 0.00),
(98, 38, '2026-02-21', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:18:49', 2.50, 0.00, 0.00),
(99, 38, '2026-02-22', 'Present', '11:00:00', '20:00:00', 'Full Day', '2026-02-25 01:19:11', 9.00, 1.00, 100.00),
(100, 39, '2026-02-23', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:19:51', 2.50, 0.00, 0.00),
(101, 38, '2026-02-23', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:20:11', 2.50, 0.00, 0.00),
(102, 39, '2026-02-24', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:21:01', 2.50, 0.00, 0.00),
(103, 38, '2026-02-24', 'Hourly', '07:00:00', '09:30:00', 'Evening', '2026-02-25 01:21:24', 2.50, 0.00, 0.00),
(104, 39, '2026-02-25', 'Present', '11:00:00', '20:00:00', '', '2026-02-25 06:10:18', 9.00, 1.00, 100.00),
(105, 40, '2026-02-14', 'Present', '11:00:00', '20:00:00', 'zxczxc', '2026-02-25 06:12:10', 9.00, 1.00, 100.00),
(106, 40, '2026-02-13', 'Hourly', '07:00:00', '09:30:00', 'zxczxc', '2026-02-25 06:12:41', 2.50, 0.00, 0.00),
(107, 40, '2026-03-02', 'Present', '11:00:00', '19:30:00', '', '2026-03-02 07:42:22', 8.50, 0.50, 50.00),
(108, 40, '2026-02-23', 'Hourly', '10:00:00', '19:00:00', 'sASas', '2026-03-02 07:51:40', 9.00, 0.00, 0.00),
(109, 40, '2026-03-04', 'Absent', '00:00:00', '00:00:00', 'sdsd', '2026-03-02 07:52:24', 0.00, 0.00, 0.00),
(110, 40, '2026-03-05', '2 Days', '00:00:00', '00:00:00', 'CC', '2026-03-02 07:53:07', 0.00, 0.00, 0.00),
(111, 38, '2026-02-27', 'Half-day', '00:00:00', '00:00:00', 'adsas', '2026-03-02 08:38:53', 0.00, 0.00, 0.00);

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(200) NOT NULL,
  `brand_description` varchar(500) DEFAULT NULL,
  `brand_createdby` varchar(200) NOT NULL,
  `brand_modifiedby` varchar(200) NOT NULL,
  `brand_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `brand_modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=271 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_description`, `brand_createdby`, `brand_modifiedby`, `brand_createdon`, `brand_modifiedon`) VALUES
(264, 'Saraf', NULL, 'info@acedecors.in', 'info@acedecors.in', '2025-12-15 11:01:04', '2025-12-15 11:01:04'),
(263, 'Godrej', NULL, 'info@acedecors.in', 'info@acedecors.in', '2025-12-15 11:00:54', '2025-12-15 11:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `brand_category_mapping`
--

DROP TABLE IF EXISTS `brand_category_mapping`;
CREATE TABLE IF NOT EXISTS `brand_category_mapping` (
  `brandId` int NOT NULL,
  `item_categoryId` int NOT NULL,
  `createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(100) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `brandId` (`brandId`),
  KEY `item_categoryId` (`item_categoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand_category_mapping`
--

INSERT INTO `brand_category_mapping` (`brandId`, `item_categoryId`, `createdby`, `modifiedby`, `createdon`, `modifiedon`) VALUES
(64, 42, '', '', '2025-12-01 18:03:58', '2025-12-01 18:03:58'),
(64, 42, '', '', '2025-12-01 18:03:48', '2025-12-01 18:03:48'),
(60, 41, 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:35:28', '2025-12-01 11:35:28'),
(66, 43, '', '', '2025-12-01 18:07:03', '2025-12-01 18:07:03'),
(64, 43, '', '', '2025-12-01 18:07:03', '2025-12-01 18:07:03'),
(66, 42, '', '', '2025-12-01 18:04:31', '2025-12-01 18:04:31'),
(66, 42, '', '', '2025-12-01 18:03:58', '2025-12-01 18:03:58'),
(1, 3, 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:52:03', '2025-10-25 14:52:03'),
(2, 3, 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:52:03', '2025-10-25 14:52:03'),
(3, 3, 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:52:03', '2025-10-25 14:52:03'),
(1, 5, 'info@acedecors.in', 'info@acedecors.in', '2025-10-27 12:30:55', '2025-10-27 12:30:55'),
(2, 5, 'info@acedecors.in', 'info@acedecors.in', '2025-10-27 12:30:55', '2025-10-27 12:30:55'),
(59, 40, 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:35:13', '2025-12-01 11:35:13'),
(1, 6, '', '', '2025-10-28 17:45:03', '2025-10-28 17:45:03'),
(1, 19, '', '', '2025-10-29 17:12:52', '2025-10-29 17:12:52'),
(2, 19, '', '', '2025-10-29 17:12:52', '2025-10-29 17:12:52'),
(1, 21, 'info@acedecors.in', 'info@acedecors.in', '2025-10-30 13:29:06', '2025-10-30 13:29:06'),
(2, 21, 'info@acedecors.in', 'info@acedecors.in', '2025-10-30 13:29:06', '2025-10-30 13:29:06'),
(3, 21, 'info@acedecors.in', 'info@acedecors.in', '2025-10-30 13:29:06', '2025-10-30 13:29:06'),
(2, 22, 'info@acedecors.in', 'info@acedecors.in', '2025-10-30 13:29:24', '2025-10-30 13:29:24'),
(3, 22, 'info@acedecors.in', 'info@acedecors.in', '2025-10-30 13:29:24', '2025-10-30 13:29:24'),
(1, 25, '', '', '2025-10-31 12:19:08', '2025-10-31 12:19:08'),
(2, 25, '', '', '2025-10-31 12:19:08', '2025-10-31 12:19:08'),
(3, 25, '', '', '2025-10-31 12:19:08', '2025-10-31 12:19:08'),
(1, 24, '', '', '2025-10-31 12:19:16', '2025-10-31 12:19:16'),
(2, 24, '', '', '2025-10-31 12:19:16', '2025-10-31 12:19:16'),
(3, 24, '', '', '2025-10-31 12:19:16', '2025-10-31 12:19:16'),
(1, 22, '', '', '2025-10-31 12:19:20', '2025-10-31 12:19:20'),
(2, 22, '', '', '2025-10-31 12:19:20', '2025-10-31 12:19:20'),
(3, 22, '', '', '2025-10-31 12:19:20', '2025-10-31 12:19:20'),
(1, 36, 'info@acedecors.in', 'info@acedecors.in', '2025-10-31 16:37:42', '2025-10-31 16:37:42'),
(2, 36, 'info@acedecors.in', 'info@acedecors.in', '2025-10-31 16:37:42', '2025-10-31 16:37:42'),
(1, 37, 'info@acedecors.in', 'info@acedecors.in', '2025-11-04 11:49:34', '2025-11-04 11:49:34'),
(3, 37, 'info@acedecors.in', 'info@acedecors.in', '2025-11-04 11:49:34', '2025-11-04 11:49:34'),
(1, 38, 'info@acedecors.in', 'info@acedecors.in', '2025-11-04 11:49:51', '2025-11-04 11:49:51'),
(146, 49, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:11:25', '2025-12-03 12:11:25'),
(146, 47, '', '', '2025-12-03 11:56:30', '2025-12-03 11:56:30'),
(115, 47, '', '', '2025-12-03 11:56:30', '2025-12-03 11:56:30'),
(115, 45, '', '', '2025-12-03 11:55:30', '2025-12-03 11:55:30'),
(146, 46, '', '', '2025-12-03 11:56:05', '2025-12-03 11:56:05'),
(115, 46, '', '', '2025-12-03 11:56:05', '2025-12-03 11:56:05'),
(115, 50, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:12:54', '2025-12-03 12:12:54'),
(146, 50, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:12:54', '2025-12-03 12:12:54'),
(146, 51, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:15:32', '2025-12-03 12:15:32'),
(115, 52, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:49:57', '2025-12-03 12:49:57'),
(146, 52, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:49:57', '2025-12-03 12:49:57'),
(115, 53, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 12:50:25', '2025-12-03 12:50:25'),
(115, 54, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:42:23', '2025-12-03 13:42:23'),
(159, 55, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 17:11:54', '2025-12-03 17:11:54'),
(165, 58, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 18:23:58', '2025-12-03 18:23:58'),
(166, 59, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 18:25:14', '2025-12-03 18:25:14'),
(167, 60, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:05:36', '2025-12-03 19:05:36'),
(168, 61, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:13:43', '2025-12-03 19:13:43'),
(169, 62, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:15:09', '2025-12-03 19:15:09'),
(170, 63, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:17:52', '2025-12-03 19:17:52'),
(170, 64, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:27:44', '2025-12-03 19:27:44'),
(170, 65, 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:28:37', '2025-12-03 19:28:37'),
(170, 66, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:17:30', '2025-12-04 10:17:30'),
(170, 67, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:18:30', '2025-12-04 10:18:30'),
(170, 68, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:20:30', '2025-12-04 10:20:30'),
(171, 71, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:23:50', '2025-12-04 10:23:50'),
(170, 69, '', '', '2025-12-04 10:22:02', '2025-12-04 10:22:02'),
(170, 72, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:24:42', '2025-12-04 10:24:42'),
(175, 73, '', '', '2025-12-04 11:14:37', '2025-12-04 11:14:37'),
(175, 74, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:48:41', '2025-12-04 10:48:41'),
(176, 73, '', '', '2025-12-04 11:14:37', '2025-12-04 11:14:37'),
(204, 76, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:06:30', '2025-12-04 16:06:30'),
(204, 77, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:07:26', '2025-12-04 16:07:26'),
(204, 78, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:07:59', '2025-12-04 16:07:59'),
(204, 79, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:08:37', '2025-12-04 16:08:37'),
(205, 80, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:11:13', '2025-12-04 16:11:13'),
(180, 81, '', '', '2025-12-04 16:13:04', '2025-12-04 16:13:04'),
(178, 82, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:53:45', '2025-12-04 16:53:45'),
(180, 82, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:53:45', '2025-12-04 16:53:45'),
(227, 83, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:12:44', '2025-12-04 17:12:44'),
(227, 84, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:12:44', '2025-12-04 17:12:44'),
(229, 87, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:17:38', '2025-12-04 17:17:38'),
(229, 86, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:17:38', '2025-12-04 17:17:38'),
(229, 88, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:24:24', '2025-12-04 17:24:24'),
(229, 89, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:24:24', '2025-12-04 17:24:24'),
(229, 90, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:27:07', '2025-12-04 17:27:07'),
(229, 91, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:27:07', '2025-12-04 17:27:07'),
(230, 90, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:27:07', '2025-12-04 17:27:07'),
(230, 91, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:27:07', '2025-12-04 17:27:07'),
(229, 93, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:55:37', '2025-12-04 17:55:37'),
(230, 93, 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:55:37', '2025-12-04 17:55:37'),
(228, 94, 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 10:55:42', '2025-12-05 10:55:42'),
(228, 95, 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 11:06:36', '2025-12-05 11:06:36'),
(228, 96, 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 11:07:03', '2025-12-05 11:07:03'),
(228, 97, 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 11:27:50', '2025-12-05 11:27:50'),
(229, 97, 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 11:27:50', '2025-12-05 11:27:50'),
(237, 99, 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:19:33', '2025-12-05 12:19:33'),
(252, 115, 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:12:11', '2025-12-06 17:12:11'),
(230, 104, '', '', '2025-12-05 19:49:39', '2025-12-05 19:49:39'),
(246, 102, '', '', '2025-12-05 17:15:56', '2025-12-05 17:15:56'),
(235, 113, '', '', '2025-12-06 16:44:30', '2025-12-06 16:44:30'),
(247, 113, '', '', '2025-12-06 16:44:30', '2025-12-06 16:44:30'),
(250, 114, '', '', '2025-12-06 17:11:50', '2025-12-06 17:11:50'),
(251, 114, '', '', '2025-12-06 17:11:50', '2025-12-06 17:11:50'),
(253, 116, 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:12:55', '2025-12-06 17:12:55'),
(252, 118, '', '', '2025-12-06 19:01:41', '2025-12-06 19:01:41'),
(252, 119, 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 10:54:52', '2025-12-07 10:54:52'),
(250, 118, '', '', '2025-12-06 19:01:41', '2025-12-06 19:01:41'),
(263, 122, 'info@acedecors.in', 'info@acedecors.in', '2025-12-15 11:04:11', '2025-12-15 11:04:11'),
(264, 122, 'info@acedecors.in', 'info@acedecors.in', '2025-12-15 11:04:11', '2025-12-15 11:04:11'),
(262, 121, '', '', '2026-02-12 15:29:57', '2026-02-12 15:29:57'),
(262, 124, 'info@acedecors.in', 'info@acedecors.in', '2026-01-06 17:45:30', '2026-01-06 17:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `brand_matcat_mapping`
--

DROP TABLE IF EXISTS `brand_matcat_mapping`;
CREATE TABLE IF NOT EXISTS `brand_matcat_mapping` (
  `brandId` int NOT NULL,
  `material_categoryId` int NOT NULL,
  `createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(100) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `brandId` (`brandId`),
  KEY `material_categoryId` (`material_categoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand_matcat_mapping`
--

INSERT INTO `brand_matcat_mapping` (`brandId`, `material_categoryId`, `createdby`, `modifiedby`, `createdon`, `modifiedon`) VALUES
(263, 36, 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:24:17', '2026-02-13 15:24:17'),
(264, 37, 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:24:35', '2026-02-13 15:24:35'),
(270, 38, 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:24:45', '2026-02-13 15:24:45'),
(264, 39, 'info@acedecors.in', 'info@acedecors.in', '2026-02-19 13:31:39', '2026-02-19 13:31:39'),
(270, 39, 'info@acedecors.in', 'info@acedecors.in', '2026-02-19 13:31:39', '2026-02-19 13:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `businessdetails`
--

DROP TABLE IF EXISTS `businessdetails`;
CREATE TABLE IF NOT EXISTS `businessdetails` (
  `businessId` int NOT NULL AUTO_INCREMENT,
  `businessName` varchar(250) NOT NULL,
  `businessAddress` varchar(250) NOT NULL,
  `businessContact` varchar(15) NOT NULL,
  `businessContact2` varchar(50) DEFAULT NULL,
  `businessTagLine` varchar(500) NOT NULL,
  `businessEmail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ModifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `businessGSTIN` varchar(15) DEFAULT NULL,
  `logoImage` varchar(100) DEFAULT NULL,
  `aboutBusiness` longtext NOT NULL,
  `aboutHeader` varchar(255) DEFAULT NULL,
  `aboutSubheading` varchar(500) DEFAULT NULL,
  `aboutImage` varchar(255) DEFAULT NULL,
  `aboutTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`businessId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `businessdetails`
--

INSERT INTO `businessdetails` (`businessId`, `businessName`, `businessAddress`, `businessContact`, `businessContact2`, `businessTagLine`, `businessEmail`, `password`, `ModifiedDate`, `createdDate`, `businessGSTIN`, `logoImage`, `aboutBusiness`, `aboutHeader`, `aboutSubheading`, `aboutImage`, `aboutTitle`) VALUES
(1, 'Ace Decors', 'PB Road, Lakamanahalli BRTS Stop, Near Ozone Hotel\r\nDharwad-580004', '9742268112', '9742367112', 'Dharwad', 'info@acedecors.co.in', '', '2025-09-27 06:41:42', '2021-11-27 19:14:44', '29ABQFA0335B1ZM', 'employe icon.jpg', '<p>We as a Wooden and Steel Furniture Manufacturing Industry founded in the year 1985 by the name Royal Industries has grown today as a complete Interior Designing Company asÂ ACE DECORS, Adapted to the German CNC technology for highest precision and quality manufacturing which help us to achieve on-time completion of every single project with minimal wastage,making our quality products more affordable in this age of inflation.We have changed the name but not the game.With the experienced team of designers,we transform every individuals dream space to reality. \n<br />\n</p>', 'We At Ace Decors', 'Unfold Your Space From Sketch To Reality', 'SHowroom Image001.jpg', 'Ace Decors');

-- --------------------------------------------------------

--
-- Table structure for table `business_media`
--

DROP TABLE IF EXISTS `business_media`;
CREATE TABLE IF NOT EXISTS `business_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `businessId` int NOT NULL,
  `mediaType` enum('image','video') NOT NULL,
  `fileName` varchar(255) DEFAULT NULL,
  `videoUrl` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `businessId` (`businessId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business_media`
--

INSERT INTO `business_media` (`id`, `businessId`, `mediaType`, `fileName`, `videoUrl`, `caption`, `created_at`) VALUES
(5, 1, 'image', 'AD-Sliding Wardrobe-001.jpg', NULL, '', '2025-10-16 06:15:38'),
(6, 1, 'video', NULL, 'https://www.youtube.com/embed/dWryPSNXSv0?si=funHHQq8zmu5V8jw', '', '2025-11-25 06:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `cabinettype`
--

DROP TABLE IF EXISTS `cabinettype`;
CREATE TABLE IF NOT EXISTS `cabinettype` (
  `CabinetType_Id` int NOT NULL AUTO_INCREMENT,
  `CabinetType` varchar(100) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`CabinetType_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabinettype`
--

INSERT INTO `cabinettype` (`CabinetType_Id`, `CabinetType`, `CreatedBy`, `ModifiedBy`) VALUES
(4, 'Back', 'info@acedecors.in', 'info@acedecors.in'),
(5, 'Front', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `categoryId` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(200) NOT NULL,
  `categoryDescription` varchar(500) NOT NULL,
  `categoryCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categoryCreatedBy` varchar(200) NOT NULL,
  `categoryModifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `categorytModifiedBy` varchar(200) NOT NULL,
  `HasSubcategory` varchar(120) NOT NULL,
  `createdOn` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `categoryName` (`categoryName`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`, `categoryDescription`, `categoryCreatedOn`, `categoryCreatedBy`, `categoryModifiedOn`, `categorytModifiedBy`, `HasSubcategory`, `createdOn`, `modifiedOn`) VALUES
(59, 'Bed Rooms', 'Bed Rooms', '2025-10-08 13:54:08', 'info@acedecors.in', '2025-10-08 13:54:55', 'info@acedecors.in', '1', '2025-10-08 13:54:08', '2025-10-08 13:54:55'),
(60, 'Living Room', 'Living Room', '2025-10-08 13:55:31', 'info@acedecors.in', '2025-10-08 13:55:40', 'info@acedecors.in', '1', '2025-10-08 13:55:31', '2025-10-08 13:55:40'),
(54, 'Wordrobe', 'Wordrobe', '2025-10-07 16:49:29', 'info@acedecors.in', '2025-10-08 13:55:11', 'info@acedecors.in', '1', '2025-10-07 16:49:29', '2025-10-08 13:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `catsubcatmapping`
--

DROP TABLE IF EXISTS `catsubcatmapping`;
CREATE TABLE IF NOT EXISTS `catsubcatmapping` (
  `catId` int NOT NULL,
  `sucatId` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `catsubcatmapping`
--

INSERT INTO `catsubcatmapping` (`catId`, `sucatId`) VALUES
(43, 2),
(60, 90),
(54, 71),
(60, 91),
(59, 90);

-- --------------------------------------------------------

--
-- Table structure for table `cl_dimension`
--

DROP TABLE IF EXISTS `cl_dimension`;
CREATE TABLE IF NOT EXISTS `cl_dimension` (
  `CLDimensionId` int NOT NULL AUTO_INCREMENT,
  `CL_Dimensions` varchar(50) NOT NULL,
  PRIMARY KEY (`CLDimensionId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cl_dimension`
--

INSERT INTO `cl_dimension` (`CLDimensionId`, `CL_Dimensions`) VALUES
(1, 'Length'),
(2, 'Width'),
(4, 'Depth');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

DROP TABLE IF EXISTS `company_details`;
CREATE TABLE IF NOT EXISTS `company_details` (
  `companyid` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(250) NOT NULL,
  `company_address` varchar(250) NOT NULL,
  `company_contact` varchar(15) NOT NULL,
  `company_tag` varchar(500) NOT NULL,
  `company_branches` varchar(250) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ModifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_GSTIN` varchar(15) DEFAULT NULL,
  `company_BankName` varchar(100) DEFAULT NULL,
  `company_BankAccountNumber` varchar(100) DEFAULT NULL,
  `company_BankIFSC` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`companyid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`companyid`, `company_name`, `company_address`, `company_contact`, `company_tag`, `company_branches`, `company_email`, `password`, `ModifiedDate`, `created_date`, `company_GSTIN`, `company_BankName`, `company_BankAccountNumber`, `company_BankIFSC`) VALUES
(1, 'ACE DECORS', 'Opp Dodwad Oil Mill, Lakhmanhalli PB Road, Dharwad 580004', '9742367112', 'DREAMS COME TRUE', '', 'info@acedecors.in', 'Acedecors@123', '2025-09-06 11:45:38', '2021-05-01 18:47:39', '29ABQFA0355B1ZM', 'ICICI', '142505002388', 'ICIC0001425');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

DROP TABLE IF EXISTS `contents`;
CREATE TABLE IF NOT EXISTS `contents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `paragraph` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `brief` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `title`, `type`, `paragraph`, `image`, `created_at`, `brief`) VALUES
(6, 'Defining a Modular Living Space', 'main', 'In todayâ€™s fast-paced world, our homes are more than just four walls â€“ theyâ€™re spaces that reflect our personality, adapt to our lifestyle, and evolve with our needs. Thatâ€™s where modular furniture steps in. Functional, stylish, and highly flexible, modular designs have become a game-changer in modern interiors.\r\n\r\nModular furniture is built using independent units or modules that can be assembled, rearranged, or expanded. Unlike traditional fixed furniture, these pieces offer complete freedom in design and functionality. From modular kitchens to wardrobes and sofas, they provide a perfect balance of aesthetics and practicality.\r\n\r\nPopular Types of Modular Furniture\r\n1. Modular Kitchens\r\nDesigned with smart cabinets, pull-out accessories, and ergonomic layouts, modular kitchens blend functionality with style.\r\n\r\n2. Modular Wardrobes\r\nSliding doors, adjustable shelves, and customizable finishes make wardrobes both practical and elegant.\r\n\r\n3. Modular Sofas\r\nRearrangeable sections allow you to create different seating arrangements â€“ from cozy corners to spacious lounge setups.\r\n\r\n4. Modular Storage Units\r\nStackable shelves, TV units, and multipurpose cabinets keep homes organized while enhancing interiors.', '', '2025-09-20 16:51:00', 'In todayâ€™s fast-paced world, our homes are more than just four walls â€“ theyâ€™re spaces that reflect our personality, adapt to our lifestyle, and evolve with our needs. Thatâ€™s where modular furniture steps in. Functional, stylish, and highly flexible, modular designs have become a game-changer in modern interiors.'),
(7, 'A curation of timeless design stories.', 'post', 'At Ace Decors, every design is more than just furniture â€“ itâ€™s a story. A story of craft, creativity, and character. Our collection brings together pieces that balance modern functionality with classic elegance, ensuring they remain relevant for years to come. Each design is thoughtfully curated to not just fill a space, but to inspire it â€“ making your home a reflection of enduring style and individuality.', '', '2025-09-20 16:56:23', '');

-- --------------------------------------------------------

--
-- Table structure for table `content_media`
--

DROP TABLE IF EXISTS `content_media`;
CREATE TABLE IF NOT EXISTS `content_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content_id` int NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `caption` text,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_content_media_content` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content_media`
--

INSERT INTO `content_media` (`id`, `content_id`, `file_type`, `image_file`, `video_url`, `video_file`, `caption`, `alt_text`, `created_at`) VALUES
(1, 6, 'image', '1760618463_03-kitchen.jpg', NULL, NULL, '', '', '2025-10-16 12:41:03'),
(5, 6, 'image', '1760620294_02-kitchen.jpg', NULL, NULL, '', '', '2025-10-16 13:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customerId` int NOT NULL AUTO_INCREMENT,
  `enq_id` int NOT NULL,
  `customerCode` varchar(100) NOT NULL,
  `customerName` varchar(200) NOT NULL,
  `customerContactNumber` varchar(15) NOT NULL,
  `customerEmail` varchar(200) NOT NULL,
  `customerAddress` varchar(500) NOT NULL,
  `customerState` varchar(200) NOT NULL,
  `customerCountry` varchar(50) NOT NULL,
  `customerCity` varchar(200) NOT NULL,
  `isQuoteGenerated` tinyint(1) NOT NULL DEFAULT '0',
  `createdby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customerDOV` date NOT NULL,
  PRIMARY KEY (`customerId`),
  KEY `enq_id` (`enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `enq_id`, `customerCode`, `customerName`, `customerContactNumber`, `customerEmail`, `customerAddress`, `customerState`, `customerCountry`, `customerCity`, `isQuoteGenerated`, `createdby`, `createdon`, `modifiedby`, `modifiedon`, `customerDOV`) VALUES
(28, 85, 'AD-202602-M28', 'Mustafa1', '7896541230', 'fdsfdf9f@gmail.com', 'Dharwad', 'GOA', 'India', 'Mumbais', 1, 'info@acedecors.in', '2026-02-19 12:37:06', 'info@acedecors.in', '2026-02-26 11:51:19', '2026-02-19'),
(26, 83, 'AD-202602-M26', 'Moin8', '9517532488', 'taukeer8@gmail.com', 'Tippu Nagar Hubli, Old Hubli8', 'GOA', 'India', 'Hubli8', 1, 'info@acedecors.in', '2026-02-17 19:43:27', 'info@acedecors.in', '2026-02-26 11:30:23', '2026-02-17'),
(27, 84, 'AD-202602-T27', 'Taukeer23', '9517532482', 'taukeer2@gmail.com', 'Tippu Nagar Hubli, Old Hubl2', 'CHANDIGARH', 'India', 'Goa2', 0, 'info@acedecors.in', '2026-02-18 12:24:04', 'info@acedecors.in', '2026-02-19 12:33:28', '2026-02-18');

-- --------------------------------------------------------



-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `customerpaymentinfo`
--

DROP TABLE IF EXISTS `customerpaymentinfo`;
CREATE TABLE IF NOT EXISTS `customerpaymentinfo` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `quotation_id` varchar(50) DEFAULT NULL,
  `customer_id` varchar(100) NOT NULL,
  `total_amount` int DEFAULT NULL,
  `paid_amount` int DEFAULT NULL,
  `received_amount` int NOT NULL,
  `pending_amount` int DEFAULT NULL,
  `creditDiscount` decimal(10,2) DEFAULT '0.00',
  `payment_plan` varchar(100) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `RTGS_no` varchar(50) DEFAULT NULL,
  `cheque_img` varchar(100) NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_description` varchar(100) NOT NULL,
  `modifieddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(100) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `customer_id` (`customer_id`),
  KEY `quotation_id` (`quotation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=368 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `customerpaymentinfo`
--

INSERT INTO `customerpaymentinfo` (`payment_id`, `quotation_id`, `customer_id`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `creditDiscount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `modifieddate`, `modified_by`) VALUES
(366, 'M28-SW-01', 'AD-202602-M28', 1200, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 14:42:54', '0'),
(365, 'M28-SW-01', 'AD-202602-M28', 1200, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 14:41:47', '0'),
(364, 'M26-TU-01', 'AD-202602-M26', 10000, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 13:00:03', '0'),
(363, 'M26-TU-01', 'AD-202602-M26', 4500, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 12:59:30', '0'),
(361, 'M26-TU-01', 'AD-202602-M26', 4500, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 12:28:11', '0'),
(362, 'M26-TU-01', 'AD-202602-M26', 4500, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 12:58:37', '0'),
(360, 'M26-TU-01', 'AD-202602-M26', 4500, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-02-27 12:26:49', '0'),
(367, NULL, 'AD-202602-M28', 1200, NULL, 200, NULL, 0.00, 'Part Payment', 'Cash', NULL, '', NULL, 'sddsads', '2026-03-02 13:47:48', 'Admin');

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `designimages`
--

DROP TABLE IF EXISTS `designimages`;
CREATE TABLE IF NOT EXISTS `designimages` (
  `designImgId` int NOT NULL AUTO_INCREMENT,
  `customerId` int NOT NULL,
  `designFilePath` varchar(200) NOT NULL,
  `designDescription` varchar(500) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `designCategory` int DEFAULT NULL,
  PRIMARY KEY (`designImgId`),
  KEY `customerId` (`customerId`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dimensions`
--

DROP TABLE IF EXISTS `dimensions`;
CREATE TABLE IF NOT EXISTS `dimensions` (
  `dimensionsId` int NOT NULL AUTO_INCREMENT,
  `dimensionsName` varchar(200) NOT NULL,
  `dimensionsDescription` varchar(500) NOT NULL,
  `length` int DEFAULT NULL,
  `breadth` int DEFAULT NULL,
  `thickness` int DEFAULT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`dimensionsId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eb`
--

DROP TABLE IF EXISTS `eb`;
CREATE TABLE IF NOT EXISTS `eb` (
  `EB_Id` int NOT NULL AUTO_INCREMENT,
  `EB` varchar(50) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`EB_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eb_lw`
--

DROP TABLE IF EXISTS `eb_lw`;
CREATE TABLE IF NOT EXISTS `eb_lw` (
  `EBLW_Id` int NOT NULL AUTO_INCREMENT,
  `EB_LW` varchar(100) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`EBLW_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eb_lw`
--

INSERT INTO `eb_lw` (`EBLW_Id`, `EB_LW`, `CreatedBy`, `ModifiedBy`) VALUES
(3, '12', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `salary_type` enum('Daily','Weekly','Monthly') DEFAULT 'Daily',
  `salary_amount` decimal(10,2) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `working_hours` decimal(4,1) NOT NULL DEFAULT '8.0',
  `notes` text,
  `photo` varchar(255) DEFAULT NULL,
  `createdOn` datetime DEFAULT CURRENT_TIMESTAMP,
  `weekly_off_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT 'Sunday',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `designation`, `contact`, `email`, `address`, `doj`, `salary_type`, `salary_amount`, `hourly_rate`, `working_hours`, `notes`, `photo`, `createdOn`, `weekly_off_day`) VALUES
(39, 'Raju', 'Technician', '9999999991', 'raju1@gmail.com', 'Lakhmanhalli Dharwad', '2026-01-01', 'Daily', 600.00, 100.00, 8.0, 'asdasdasd', 'uploads/employee/1770204396_ChatGPT Image Feb 3, 2026, 11_34_05 AM.jpg', '2026-02-04 16:56:36', 'Friday'),
(38, 'Narendra', 'Technician', '9999999992', 'narendra1@gmail.com', 'Lakhmanhalli Dharwad', '2026-01-01', 'Daily', 600.00, 100.00, 8.0, '', 'uploads/employee/1770203912_ChatGPT Image Feb 3, 2026, 11_34_05 AM.jpg', '2026-02-04 16:48:32', 'Friday'),
(40, 'Taukeer', 'Electric Engineer', '8797854627', 'taukeer123@gmail.com', 'dfsdf', '2026-02-01', 'Daily', 800.00, 100.00, 8.0, 'sdf', 'uploads/employee/1771999916_Sunset+over+Lake+Washington,+Kirkland,+WA.webp', '2026-02-25 11:41:56', 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `employee_payment`
--

DROP TABLE IF EXISTS `employee_payment`;
CREATE TABLE IF NOT EXISTS `employee_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` enum('Cash','Bank Transfer','UPI','Cheque') DEFAULT 'Cash',
  `status` enum('Paid','Pending') DEFAULT 'Paid',
  `remarks` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `employee_payment`
--

INSERT INTO `employee_payment` (`id`, `emp_id`, `payment_date`, `amount`, `payment_type`, `status`, `remarks`, `created_at`) VALUES
(128, 39, '2026-02-25', 100.00, 'Cash', 'Paid', 'xzxzxzxz', '2026-02-25 10:40:41'),
(127, 40, '2026-02-25', 50.00, 'Cash', 'Paid', 'dsdfs', '2026-02-25 10:40:07'),
(129, 39, '2026-03-02', 100.00, 'Cash', 'Paid', 'asd', '2026-03-02 08:16:43'),
(130, 38, '2026-03-02', 200.00, 'Cash', 'Paid', 'ssad', '2026-03-02 08:17:08'),
(131, 40, '2026-03-02', 850.00, 'Cash', 'Paid', 'sd', '2026-03-02 08:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

DROP TABLE IF EXISTS `enquiry`;
CREATE TABLE IF NOT EXISTS `enquiry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Qualification` varchar(100) NOT NULL,
  `Trainings` varchar(40) NOT NULL,
  `Internship` varchar(40) NOT NULL,
  `Demo` varchar(100) NOT NULL,
  `Services` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `Modified_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `enquiry_category`
--

DROP TABLE IF EXISTS `enquiry_category`;
CREATE TABLE IF NOT EXISTS `enquiry_category` (
  `enq_catid` int NOT NULL AUTO_INCREMENT,
  `enq_cat_name` varchar(200) NOT NULL,
  `enq_cat_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enq_cat_createdby` varchar(200) NOT NULL,
  `enq_cat_modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enq_cat_modifiedby` varchar(200) NOT NULL,
  `enq_cat_type` varchar(100) NOT NULL DEFAULT 'Enquiry Category',
  PRIMARY KEY (`enq_catid`),
  UNIQUE KEY `uniq_cat_name_type` (`enq_cat_name`,`enq_cat_type`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_category`
--

INSERT INTO `enquiry_category` (`enq_catid`, `enq_cat_name`, `enq_cat_createdon`, `enq_cat_createdby`, `enq_cat_modifiedon`, `enq_cat_modifiedby`, `enq_cat_type`) VALUES
(26, 'Kitchensas', '2026-02-17 18:04:10', 'info@acedecors.in', '2026-02-17 18:04:10', 'info@acedecors.in', 'Enquiry Category'),
(25, 'Living Room', '2026-02-07 18:31:01', 'info@acedecors.in', '2026-02-07 18:31:01', 'info@acedecors.in', 'Enquiry Category'),
(24, 'Sliding Wardrobe', '2026-02-07 18:30:50', 'info@acedecors.in', '2026-02-07 18:30:50', 'info@acedecors.in', 'Enquiry Category'),
(22, 'Living Room', '2026-02-07 18:30:28', 'info@acedecors.in', '2026-02-07 18:30:28', 'info@acedecors.in', 'Design'),
(23, 'TV Unit', '2026-02-07 18:30:44', 'info@acedecors.in', '2026-02-07 18:30:44', 'info@acedecors.in', 'Enquiry Category');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_details`
--

DROP TABLE IF EXISTS `enquiry_details`;
CREATE TABLE IF NOT EXISTS `enquiry_details` (
  `enqid` int NOT NULL AUTO_INCREMENT,
  `enq_name` varchar(200) NOT NULL,
  `enq_email` varchar(200) NOT NULL,
  `enq_address` varchar(500) NOT NULL,
  `enq_city` varchar(150) NOT NULL,
  `enq_state` varchar(100) NOT NULL,
  `enq_country` varchar(50) NOT NULL,
  `enq_phone` varchar(10) NOT NULL,
  `enqStatus` enum('Attended','Unattended') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Unattended',
  `isCustomerCreated` tinyint(1) NOT NULL DEFAULT '0',
  `enq_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enq_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enq_modifiedBy` varchar(200) NOT NULL,
  `enq_preffered_contact_mode` varchar(20) NOT NULL,
  PRIMARY KEY (`enqid`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_details`
--

INSERT INTO `enquiry_details` (`enqid`, `enq_name`, `enq_email`, `enq_address`, `enq_city`, `enq_state`, `enq_country`, `enq_phone`, `enqStatus`, `isCustomerCreated`, `enq_createdOn`, `enq_modifiedOn`, `enq_modifiedBy`, `enq_preffered_contact_mode`) VALUES
(85, 'Mustafa1', 'fdsfdf9f@gmail.com', 'Dharwad', 'Mumbais', 'GOA', 'India', '7896541230', 'Attended', 1, '2026-02-19 12:36:44', '2026-02-19 12:37:54', '', ''),
(83, 'Moin8', 'taukeer8@gmail.com', 'Tippu Nagar Hubli, Old Hubli8', 'Hubli8', 'GOA', 'India', '9517532488', 'Attended', 1, '2026-02-17 19:43:16', '2026-02-17 20:05:18', '', ''),
(84, 'Taukeer23', 'taukeer2@gmail.com', 'Tippu Nagar Hubli, Old Hubl2', 'Goa2', 'CHANDIGARH', 'India', '9517532482', 'Attended', 1, '2026-02-18 12:23:52', '2026-02-19 12:33:28', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_followups`
--

DROP TABLE IF EXISTS `enquiry_followups`;
CREATE TABLE IF NOT EXISTS `enquiry_followups` (
  `followupid` int NOT NULL AUTO_INCREMENT,
  `followup_enq_id` int NOT NULL,
  `followup_comments` varchar(500) NOT NULL,
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(200) NOT NULL,
  PRIMARY KEY (`followupid`),
  KEY `followup_enq_id` (`followup_enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_followups`
--

INSERT INTO `enquiry_followups` (`followupid`, `followup_enq_id`, `followup_comments`, `followup_createdon`, `followup_by`) VALUES
(25, 0, '', '2025-11-26 16:54:02', 'info@acedecors.in'),
(24, 0, '', '2025-11-26 16:53:48', 'info@acedecors.in'),
(23, 0, '', '2025-11-26 16:53:33', 'info@acedecors.in'),
(22, 0, '', '2025-11-26 16:53:06', 'info@acedecors.in'),
(21, 0, '', '2025-11-22 17:38:48', 'info@acedecors.in'),
(20, 0, '', '2025-11-07 18:02:43', 'info@acedecors.in'),
(19, 0, '', '2025-11-07 18:02:21', 'info@acedecors.in'),
(18, 0, '', '2025-11-07 18:02:03', 'info@acedecors.in'),
(17, 0, '', '2025-11-07 18:01:36', 'info@acedecors.in'),
(16, 0, '', '2025-11-07 16:37:22', 'info@acedecors.in'),
(15, 0, '', '2025-10-24 16:40:58', 'info@acedecors.in'),
(26, 0, '', '2026-02-06 17:43:26', 'info@acedecors.in'),
(27, 0, '', '2026-02-06 18:05:35', 'info@acedecors.in'),
(28, 0, '', '2026-02-07 17:47:52', 'info@acedecors.in'),
(29, 0, '', '2026-02-07 18:30:19', 'info@acedecors.in'),
(30, 0, '', '2026-02-07 18:31:16', 'info@acedecors.in'),
(31, 0, '', '2026-02-09 18:20:30', 'info@acedecors.in'),
(32, 0, '', '2026-02-12 12:50:04', 'info@acedecors.in'),
(33, 0, '', '2026-02-12 12:50:22', 'info@acedecors.in'),
(34, 0, '', '2026-02-17 15:30:04', 'info@acedecors.in'),
(35, 0, '', '2026-02-17 15:31:33', 'info@acedecors.in'),
(36, 0, '', '2026-02-17 15:32:18', 'info@acedecors.in'),
(37, 0, '', '2026-02-17 15:32:55', 'info@acedecors.in'),
(38, 0, '', '2026-02-17 15:43:46', 'info@acedecors.in'),
(39, 0, '', '2026-02-17 15:44:01', 'info@acedecors.in'),
(40, 0, '', '2026-02-17 15:44:19', 'info@acedecors.in'),
(41, 0, '', '2026-02-17 16:25:01', 'info@acedecors.in'),
(42, 0, '', '2026-02-17 16:41:19', 'info@acedecors.in'),
(43, 0, '', '2026-02-17 16:42:33', 'info@acedecors.in'),
(44, 0, '', '2026-02-17 16:43:00', 'info@acedecors.in'),
(45, 0, '', '2026-02-17 16:55:29', 'info@acedecors.in'),
(46, 0, '', '2026-02-17 17:06:53', 'info@acedecors.in'),
(47, 0, '', '2026-02-17 17:11:08', 'info@acedecors.in'),
(48, 0, '', '2026-02-17 17:25:13', 'info@acedecors.in'),
(49, 0, '', '2026-02-17 18:29:04', 'info@acedecors.in'),
(50, 0, '', '2026-02-17 18:29:26', 'info@acedecors.in'),
(51, 0, '', '2026-02-17 18:47:20', 'info@acedecors.in'),
(52, 0, '', '2026-02-17 18:47:47', 'info@acedecors.in'),
(53, 0, '', '2026-02-17 18:52:50', 'info@acedecors.in'),
(54, 0, '', '2026-02-17 19:16:06', 'info@acedecors.in'),
(55, 0, '', '2026-02-17 19:17:03', 'info@acedecors.in'),
(56, 0, '', '2026-02-17 19:41:11', 'info@acedecors.in'),
(57, 0, '', '2026-02-17 19:43:16', 'info@acedecors.in'),
(58, 0, '', '2026-02-17 19:43:27', 'info@acedecors.in'),
(59, 0, '', '2026-02-17 19:45:21', 'info@acedecors.in'),
(60, 0, '', '2026-02-17 19:52:58', 'info@acedecors.in'),
(61, 0, '', '2026-02-17 19:55:47', 'info@acedecors.in'),
(62, 0, '', '2026-02-17 20:05:18', 'info@acedecors.in'),
(63, 0, '', '2026-02-18 12:23:17', 'info@acedecors.in'),
(64, 0, '', '2026-02-18 12:23:52', 'info@acedecors.in'),
(65, 0, '', '2026-02-18 12:24:04', 'info@acedecors.in'),
(66, 0, '', '2026-02-18 12:28:35', 'info@acedecors.in'),
(67, 84, '', '2026-02-19 12:33:28', 'info@acedecors.in'),
(68, 0, '', '2026-02-19 12:36:44', 'info@acedecors.in'),
(69, 85, '', '2026-02-19 12:37:06', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `enq_cat_mapping`
--

DROP TABLE IF EXISTS `enq_cat_mapping`;
CREATE TABLE IF NOT EXISTS `enq_cat_mapping` (
  `enq_id` int NOT NULL,
  `cat_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enq_cat_mapping`
--

INSERT INTO `enq_cat_mapping` (`enq_id`, `cat_id`) VALUES
(67, 24),
(65, 17),
(27, 1),
(26, 2),
(26, 1),
(64, 14),
(65, 15),
(35, 2),
(36, 2),
(36, 3),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(41, 2),
(41, 3),
(42, 1),
(42, 3),
(43, 2),
(44, 1),
(45, 3),
(46, 1),
(47, 1),
(48, 1),
(49, 2),
(50, 1),
(51, 1),
(52, 3),
(53, 1),
(56, 2),
(57, 2),
(65, 16),
(65, 1),
(58, 3),
(57, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(64, 15),
(68, 23),
(69, 24),
(70, 24),
(70, 23),
(71, 25),
(71, 24),
(72, 24),
(73, 25),
(73, 23),
(74, 23),
(75, 25),
(75, 24),
(76, 25),
(76, 24),
(77, 25),
(77, 23),
(78, 23),
(79, 25),
(79, 23),
(80, 23),
(83, 23),
(81, 23),
(81, 25),
(82, 25),
(82, 26),
(83, 25),
(84, 23),
(84, 24),
(85, 24);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
CREATE TABLE IF NOT EXISTS `expense` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `project_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `po_id` int DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `payment_type` enum('Cash','Bank Transfer','UPI','Cheque') DEFAULT 'Cash',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subcategory_id` int DEFAULT NULL,
  `subcategory_name` varchar(100) DEFAULT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=354 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `category`, `project_id`, `supplier_id`, `po_id`, `amount`, `expense_date`, `payment_type`, `notes`, `created_at`, `subcategory_id`, `subcategory_name`, `type`) VALUES
(346, 'Employee', NULL, NULL, NULL, 50.00, '2026-02-25', 'Cash', 'Employee Salary Payment', '2026-02-25 10:40:07', NULL, NULL, 'Expense'),
(343, 'Projects', 71, NULL, NULL, 100.00, '2026-02-25', 'Cash', 'cxvcvxcvx', '2026-02-25 08:41:02', 16, '', 'Expense'),
(341, ' General', NULL, NULL, NULL, 100.00, '2026-02-25', 'Cash', 'dgfggh', '2026-02-25 08:39:17', NULL, NULL, 'Expense'),
(347, 'Employee', NULL, NULL, NULL, 100.00, '2026-02-25', 'Cash', 'Employee Salary Payment', '2026-02-25 10:40:41', NULL, NULL, 'Expense'),
(345, 'Customer', NULL, NULL, NULL, 1000.00, '2026-02-25', 'Cash', 'gmmn', '2026-02-25 09:37:06', 0, 'Projects', 'Income'),
(348, 'Suppliers', NULL, 15, NULL, 350.00, '2026-02-25', 'Cash', 'bcvxbcv', '2026-02-25 11:14:10', NULL, NULL, 'Expense'),
(349, 'Suppliers', NULL, 15, NULL, 100.00, '2026-02-25', 'Cash', 'jghghj', '2026-02-25 11:20:49', NULL, NULL, 'Expense'),
(350, 'Employee', NULL, NULL, NULL, 100.00, '2026-03-02', 'Cash', 'Employee Salary Payment', '2026-03-02 08:16:43', NULL, NULL, 'Expense'),
(351, 'Employee', NULL, NULL, NULL, 200.00, '2026-03-02', 'Cash', 'Employee Salary Payment', '2026-03-02 08:17:08', NULL, NULL, 'Expense'),
(352, 'Employee', NULL, NULL, NULL, 850.00, '2026-03-02', 'Cash', 'Employee Salary Payment', '2026-03-02 08:17:19', NULL, NULL, 'Expense'),
(353, 'Customer', NULL, NULL, NULL, 200.00, '2026-03-02', 'Cash', 'sddsads', '2026-03-02 08:17:48', 0, 'Projects', 'Income');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

DROP TABLE IF EXISTS `expense_category`;
CREATE TABLE IF NOT EXISTS `expense_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `type` enum('Expense','Income') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`id`, `name`, `type`) VALUES
(5, 'Moin', 'Income'),
(4, 'Food', 'Expense'),
(6, 'Petrol', 'Expense'),
(7, 'Taukeer', 'Income');

-- --------------------------------------------------------

--
-- Table structure for table `finish`
--

DROP TABLE IF EXISTS `finish`;
CREATE TABLE IF NOT EXISTS `finish` (
  `FinishId` int NOT NULL AUTO_INCREMENT,
  `Finish` varchar(59) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `ModifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`FinishId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finish`
--

INSERT INTO `finish` (`FinishId`, `Finish`, `CreatedBy`, `ModifiedBy`) VALUES
(1, 'SIF', 'info@acedecors.in', 'info@acedecors.in'),
(2, '1SIF', 'info@acedecors.in', 'info@acedecors.in'),
(3, '2SIF', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `general_subcategory`
--

DROP TABLE IF EXISTS `general_subcategory`;
CREATE TABLE IF NOT EXISTS `general_subcategory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subcategory_name` varchar(150) NOT NULL,
  `category` varchar(50) DEFAULT 'General',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `general_subcategory`
--

INSERT INTO `general_subcategory` (`id`, `subcategory_name`, `category`, `created_at`) VALUES
(16, 'Petrols', 'General', '2025-12-22 07:30:29'),
(17, 'Petrol', 'General', '2025-12-22 09:40:07'),
(18, 'DFGDFSDF', 'General', '2025-12-22 09:40:12'),
(19, 'ASDASD', 'General', '2025-12-22 09:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `gl`
--

DROP TABLE IF EXISTS `gl`;
CREATE TABLE IF NOT EXISTS `gl` (
  `GL_Id` int NOT NULL AUTO_INCREMENT,
  `GL` varchar(50) NOT NULL,
  PRIMARY KEY (`GL_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl`
--

INSERT INTO `gl` (`GL_Id`, `GL`) VALUES
(1, '1x'),
(2, '2x'),
(3, '3x');

-- --------------------------------------------------------

--
-- Table structure for table `inputtype`
--

DROP TABLE IF EXISTS `inputtype`;
CREATE TABLE IF NOT EXISTS `inputtype` (
  `InputTypeId` int NOT NULL AUTO_INCREMENT,
  `InputType` varchar(100) NOT NULL,
  PRIMARY KEY (`InputTypeId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inputtype`
--

INSERT INTO `inputtype` (`InputTypeId`, `InputType`) VALUES
(1, 'Item'),
(2, 'Material'),
(3, 'Product'),
(4, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `inputtype_brand_mapping`
--

DROP TABLE IF EXISTS `inputtype_brand_mapping`;
CREATE TABLE IF NOT EXISTS `inputtype_brand_mapping` (
  `brandId` int NOT NULL,
  `InputTypeId` int NOT NULL,
  `ModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ModifiedBy` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inputtype_brand_mapping`
--

INSERT INTO `inputtype_brand_mapping` (`brandId`, `InputTypeId`, `ModifiedOn`, `ModifiedBy`, `CreatedBy`, `CreatedOn`) VALUES
(1, 1, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-01-21 09:14:12'),
(2, 1, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-01-21 09:14:22'),
(3, 1, '2025-10-25 14:11:31', 'info@acedecors.in', 'info@acedecors.in', '2022-01-21 09:14:34'),
(4, 2, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-01-21 09:14:45'),
(5, 1, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-01-21 09:15:28'),
(1, 1, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-02-18 03:56:07'),
(2, 1, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-02-18 03:56:23'),
(3, 1, '2025-09-06 11:45:38', 'info@acedecors.in', 'info@acedecors.in', '2022-02-18 03:56:39'),
(3, 1, '2025-10-25 14:11:31', 'info@acedecors.in', 'info@acedecors.in', '2022-02-18 03:56:39'),
(1, 2, '2025-10-25 14:10:15', 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:10:15'),
(1, 3, '2025-10-25 14:10:15', 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:10:15'),
(2, 2, '2025-10-25 14:10:48', 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:10:48'),
(2, 3, '2025-10-25 14:10:48', 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:10:48'),
(3, 2, '2025-10-25 14:11:31', 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:11:31'),
(3, 3, '2025-10-25 14:11:31', 'info@acedecors.in', 'info@acedecors.in', '2025-10-25 14:11:31'),
(4, 1, '2025-11-07 21:16:47', 'info@acedecors.in', 'info@acedecors.in', '2025-11-07 21:16:47'),
(5, 1, '2025-11-11 17:21:09', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:09'),
(6, 1, '2025-11-11 17:21:09', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:09'),
(5, 2, '2025-11-11 17:21:09', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:09'),
(6, 2, '2025-11-11 17:21:09', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:09'),
(8, 1, '2025-11-11 17:21:41', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:41'),
(7, 1, '2025-11-11 17:21:41', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:41'),
(9, 1, '2025-11-11 17:21:44', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:44'),
(10, 1, '2025-11-11 17:21:44', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:44'),
(9, 2, '2025-11-11 17:21:44', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:44'),
(10, 2, '2025-11-11 17:21:44', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:21:44'),
(11, 2, '2025-11-11 17:24:48', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:24:48'),
(12, 2, '2025-11-11 17:24:48', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:24:48'),
(14, 2, '2025-11-11 17:25:31', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:25:31'),
(13, 2, '2025-11-11 17:25:31', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:25:31'),
(16, 2, '2025-11-11 17:29:09', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:29:09'),
(15, 2, '2025-11-11 17:29:09', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:29:09'),
(17, 2, '2025-11-11 17:29:56', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:29:56'),
(18, 2, '2025-11-11 17:29:56', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:29:56'),
(19, 2, '2025-11-11 17:41:45', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:41:45'),
(20, 2, '2025-11-11 17:42:08', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:42:08'),
(21, 2, '2025-11-11 17:42:08', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:42:08'),
(22, 2, '2025-11-11 17:43:17', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:43:17'),
(23, 2, '2025-11-11 17:43:17', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:43:17'),
(24, 2, '2025-11-11 17:44:04', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:44:04'),
(25, 2, '2025-11-11 17:44:04', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:44:04'),
(26, 2, '2025-11-11 17:48:40', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:48:40'),
(27, 2, '2025-11-11 17:48:40', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:48:40'),
(28, 2, '2025-11-11 17:49:26', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:49:26'),
(29, 2, '2025-11-11 17:49:26', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:49:26'),
(30, 2, '2025-11-11 17:53:04', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:53:04'),
(31, 2, '2025-11-11 17:53:04', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:53:04'),
(33, 1, '2025-11-11 17:54:11', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:54:11'),
(32, 1, '2025-11-11 17:54:11', 'info@acedecors.in', 'info@acedecors.in', '2025-11-11 17:54:11'),
(34, 1, '2025-11-12 10:55:57', 'info@acedecors.in', 'info@acedecors.in', '2025-11-12 10:55:57'),
(35, 1, '2025-11-12 10:55:57', 'info@acedecors.in', 'info@acedecors.in', '2025-11-12 10:55:57'),
(36, 1, '2025-11-12 11:33:23', 'info@acedecors.in', 'info@acedecors.in', '2025-11-12 11:33:23'),
(37, 1, '2025-11-12 11:33:23', 'info@acedecors.in', 'info@acedecors.in', '2025-11-12 11:33:23'),
(38, 1, '2025-11-27 15:48:56', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:48:56'),
(39, 1, '2025-11-27 15:48:56', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:48:56'),
(40, 1, '2025-11-27 15:48:56', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:48:56'),
(41, 1, '2025-11-27 15:49:39', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:49:39'),
(42, 1, '2025-11-27 15:49:39', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:49:39'),
(43, 1, '2025-11-27 15:49:39', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:49:39'),
(44, 1, '2025-11-27 15:59:33', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:59:33'),
(45, 1, '2025-11-27 15:59:33', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:59:33'),
(46, 1, '2025-11-27 15:59:33', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 15:59:33'),
(48, 1, '2025-11-27 16:00:36', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:00:36'),
(47, 1, '2025-11-27 16:00:36', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:00:36'),
(49, 1, '2025-11-27 16:00:36', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:00:36'),
(50, 1, '2025-11-27 16:03:52', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:03:52'),
(51, 1, '2025-11-27 16:03:52', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:03:52'),
(52, 1, '2025-11-27 16:03:52', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:03:52'),
(53, 2, '2025-11-27 16:10:02', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:10:02'),
(55, 2, '2025-11-27 16:10:02', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:10:02'),
(54, 2, '2025-11-27 16:10:02', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:10:02'),
(56, 2, '2025-11-27 16:12:41', 'info@acedecors.in', 'info@acedecors.in', '2025-11-27 16:12:41'),
(58, 1, '2025-12-01 11:32:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:32:31'),
(58, 1, '2025-12-01 16:09:22', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:32:31'),
(59, 2, '2025-12-01 13:04:15', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:34:22'),
(59, 2, '2025-12-01 11:34:22', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:34:22'),
(60, 1, '2025-12-01 11:34:28', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:34:28'),
(60, 2, '2025-12-01 11:34:28', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:34:28'),
(61, 1, '2025-12-01 11:35:02', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:35:02'),
(61, 2, '2025-12-01 11:35:02', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 11:35:02'),
(62, 1, '2025-12-01 13:03:06', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 13:03:06'),
(58, 1, '2025-12-01 16:09:35', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:09:22'),
(63, 2, '2025-12-01 16:10:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:10:25'),
(63, 2, '2025-12-01 16:10:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:10:25'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:16:01'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:16:01'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:16:01'),
(65, 2, '2025-12-01 16:16:18', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:16:18'),
(65, 2, '2025-12-01 16:31:46', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 16:16:18'),
(63, 2, '2025-12-01 17:23:12', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:12'),
(63, 2, '2025-12-01 17:23:33', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:12'),
(63, 2, '2025-12-01 17:23:33', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:33'),
(63, 2, '2025-12-01 17:23:43', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:33'),
(63, 2, '2025-12-01 17:23:43', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:43'),
(63, 3, '2025-12-01 17:23:43', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:43'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:51'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:23:51'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:24:15'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:24:15'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:24:15'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-01 17:24:33'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:05:22'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:05:42'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:05:42'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:05:56'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:05:56'),
(66, 1, '2025-12-02 10:06:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:06:07'),
(66, 1, '2025-12-02 10:06:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:06:07'),
(66, 1, '2025-12-02 12:49:57', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 10:06:19'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:00:50'),
(64, 2, '2025-12-02 12:30:08', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:00:50'),
(64, 2, '2025-12-02 12:29:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:29:54'),
(67, 0, '2025-12-02 12:37:46', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:37:46'),
(113, 1, '2025-12-02 16:05:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:05:59'),
(69, 0, '2025-12-02 12:38:15', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:38:15'),
(70, 0, '2025-12-02 12:47:55', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:47:55'),
(71, 0, '2025-12-02 12:49:28', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:49:28'),
(72, 0, '2025-12-02 12:49:57', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:49:57'),
(73, 0, '2025-12-02 12:50:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:50:54'),
(104, 2, '2025-12-02 15:40:42', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 15:40:42'),
(104, 1, '2025-12-02 15:40:42', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 15:40:42'),
(74, 0, '2025-12-02 12:51:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:51:04'),
(75, 0, '2025-12-02 12:51:14', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:51:14'),
(76, 0, '2025-12-02 12:51:36', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:51:36'),
(77, 0, '2025-12-02 12:52:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:52:44'),
(78, 0, '2025-12-02 12:54:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:54:54'),
(79, 0, '2025-12-02 12:55:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:55:44'),
(80, 0, '2025-12-02 12:56:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:56:49'),
(81, 0, '2025-12-02 12:57:26', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:57:26'),
(71, 1, '2025-12-02 12:57:26', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:57:26'),
(82, 0, '2025-12-02 12:58:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:58:44'),
(83, 1, '2025-12-02 12:58:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:58:44'),
(83, 2, '2025-12-02 12:58:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:58:44'),
(84, 0, '2025-12-02 12:59:36', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:59:36'),
(85, 1, '2025-12-02 12:59:36', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:59:36'),
(85, 2, '2025-12-02 12:59:36', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 12:59:36'),
(86, 0, '2025-12-02 13:02:58', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 13:02:58'),
(97, 2, '2025-12-02 13:31:16', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 13:31:16'),
(98, 1, '2025-12-02 13:33:42', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 13:33:42'),
(99, 2, '2025-12-02 13:34:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 13:34:27'),
(99, 3, '2025-12-02 13:34:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 13:34:27'),
(99, 4, '2025-12-02 13:34:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 13:34:27'),
(113, 2, '2025-12-02 16:05:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:05:59'),
(147, 1, '2025-12-02 18:35:14', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 18:35:14'),
(115, 2, '2025-12-02 18:18:10', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 18:18:10'),
(115, 1, '2025-12-02 18:18:10', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 18:18:10'),
(119, 0, '2025-12-02 16:09:11', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:09:11'),
(121, 0, '2025-12-02 16:09:34', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:09:34'),
(123, 0, '2025-12-02 16:10:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:10:04'),
(125, 0, '2025-12-02 16:27:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:27:27'),
(127, 0, '2025-12-02 16:40:26', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 16:40:26'),
(129, 0, '2025-12-02 17:07:33', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 17:07:33'),
(142, 0, '2025-12-02 17:39:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 17:39:49'),
(148, 1, '2025-12-02 18:35:14', 'info@acedecors.in', 'info@acedecors.in', '2025-12-02 18:35:14'),
(172, 1, '2025-12-04 10:44:53', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:44:53'),
(149, 1, '2025-12-03 13:38:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:38:00'),
(149, 2, '2025-12-03 13:38:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:38:00'),
(150, 1, '2025-12-03 13:38:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:38:00'),
(150, 2, '2025-12-03 13:38:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:38:00'),
(151, 1, '2025-12-03 13:45:24', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:45:24'),
(152, 1, '2025-12-03 13:45:24', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:45:24'),
(152, 2, '2025-12-03 13:45:24', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:45:24'),
(151, 2, '2025-12-03 13:45:24', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 13:45:24'),
(153, 1, '2025-12-03 16:58:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 16:58:13'),
(154, 1, '2025-12-03 16:58:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 16:58:13'),
(155, 1, '2025-12-03 16:59:37', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 16:59:37'),
(156, 1, '2025-12-03 16:59:37', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 16:59:37'),
(157, 1, '2025-12-03 17:02:55', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 17:02:55'),
(159, 2, '2025-12-03 17:16:32', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 17:16:32'),
(159, 1, '2025-12-03 17:16:32', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 17:16:32'),
(162, 3, '2025-12-03 17:34:40', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 17:34:40'),
(162, 2, '2025-12-03 17:34:40', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 17:34:40'),
(163, 2, '2025-12-03 18:15:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 18:15:49'),
(164, 1, '2025-12-03 18:16:52', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 18:16:52'),
(165, 1, '2025-12-03 18:23:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 18:23:13'),
(168, 1, '2025-12-03 19:13:35', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:13:35'),
(167, 1, '2025-12-03 19:05:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:05:25'),
(170, 1, '2025-12-03 19:17:40', 'info@acedecors.in', 'info@acedecors.in', '2025-12-03 19:17:40'),
(171, 1, '2025-12-04 10:22:46', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:22:46'),
(172, 2, '2025-12-04 10:44:53', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:44:53'),
(173, 1, '2025-12-04 10:45:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:45:19'),
(173, 2, '2025-12-04 10:45:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:45:19'),
(174, 2, '2025-12-04 10:46:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:46:31'),
(174, 1, '2025-12-04 10:46:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:46:31'),
(175, 1, '2025-12-04 10:46:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:46:09'),
(175, 2, '2025-12-04 10:46:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:46:09'),
(175, 3, '2025-12-04 10:46:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 10:46:09'),
(176, 1, '2025-12-04 11:15:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:15:09'),
(177, 1, '2025-12-04 11:09:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:09:25'),
(176, 2, '2025-12-04 11:15:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:15:09'),
(178, 2, '2025-12-04 11:29:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:29:49'),
(178, 1, '2025-12-04 11:29:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:29:49'),
(179, 1, '2025-12-04 11:27:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:27:59'),
(179, 2, '2025-12-04 11:27:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:27:59'),
(179, 3, '2025-12-04 11:27:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:27:59'),
(180, 1, '2025-12-04 11:28:12', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:28:12'),
(180, 3, '2025-12-04 11:28:12', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:28:12'),
(181, 1, '2025-12-04 11:40:18', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:40:18'),
(181, 2, '2025-12-04 11:40:18', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:40:18'),
(182, 1, '2025-12-04 11:41:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:41:19'),
(182, 2, '2025-12-04 11:41:19', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 11:41:19'),
(183, 1, '2025-12-04 12:07:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:07:13'),
(183, 2, '2025-12-04 12:07:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:07:13'),
(184, 1, '2025-12-04 12:07:37', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:07:37'),
(184, 2, '2025-12-04 12:07:37', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:07:37'),
(185, 1, '2025-12-04 12:08:58', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:08:58'),
(185, 2, '2025-12-04 12:08:58', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:08:58'),
(186, 1, '2025-12-04 12:35:17', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:35:17'),
(187, 1, '2025-12-04 12:37:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:37:49'),
(188, 1, '2025-12-04 12:38:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:38:59'),
(189, 1, '2025-12-04 12:39:15', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:39:15'),
(190, 1, '2025-12-04 12:53:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:53:27'),
(191, 1, '2025-12-04 12:54:12', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:54:12'),
(192, 1, '2025-12-04 12:54:37', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:54:37'),
(193, 1, '2025-12-04 12:58:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:58:54'),
(194, 1, '2025-12-04 12:59:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:59:13'),
(194, 2, '2025-12-04 12:59:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 12:59:13'),
(195, 1, '2025-12-04 13:00:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:00:09'),
(195, 2, '2025-12-04 13:00:09', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:00:09'),
(196, 1, '2025-12-04 13:00:30', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:00:30'),
(197, 1, '2025-12-04 13:00:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:00:54'),
(198, 1, '2025-12-04 13:01:45', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:01:45'),
(199, 1, '2025-12-04 13:03:24', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:03:24'),
(200, 1, '2025-12-04 13:03:48', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:03:48'),
(201, 1, '2025-12-04 13:04:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:04:31'),
(202, 1, '2025-12-04 13:05:18', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 13:05:18'),
(203, 1, '2025-12-04 16:04:47', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:04:47'),
(204, 1, '2025-12-04 16:06:15', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:06:15'),
(205, 1, '2025-12-04 16:11:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:11:07'),
(206, 1, '2025-12-04 16:12:24', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:12:24'),
(207, 1, '2025-12-04 16:15:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:15:31'),
(208, 1, '2025-12-04 16:15:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:15:49'),
(208, 2, '2025-12-04 16:15:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:15:49'),
(209, 1, '2025-12-04 16:17:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:17:59'),
(210, 1, '2025-12-04 16:22:01', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:22:01'),
(210, 2, '2025-12-04 16:22:01', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:22:01'),
(211, 1, '2025-12-04 16:22:22', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:22:22'),
(211, 2, '2025-12-04 16:22:22', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:22:22'),
(212, 1, '2025-12-04 16:27:37', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:27:37'),
(213, 1, '2025-12-04 16:27:50', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:27:50'),
(214, 1, '2025-12-04 16:28:48', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:28:48'),
(215, 1, '2025-12-04 16:30:52', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:30:52'),
(215, 2, '2025-12-04 16:30:52', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:30:52'),
(216, 1, '2025-12-04 16:31:10', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:31:10'),
(217, 1, '2025-12-04 16:32:48', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:32:48'),
(218, 1, '2025-12-04 16:33:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:33:07'),
(218, 2, '2025-12-04 16:33:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:33:07'),
(219, 2, '2025-12-04 16:41:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:41:59'),
(219, 1, '2025-12-04 16:41:59', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:41:59'),
(220, 1, '2025-12-04 16:46:45', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:46:45'),
(220, 2, '2025-12-04 16:46:45', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:46:45'),
(221, 1, '2025-12-04 16:47:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:47:00'),
(221, 2, '2025-12-04 16:47:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:47:00'),
(222, 1, '2025-12-04 16:47:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:47:31'),
(222, 2, '2025-12-04 16:47:31', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:47:31'),
(223, 1, '2025-12-04 16:47:55', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:47:55'),
(223, 2, '2025-12-04 16:47:55', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:47:55'),
(224, 1, '2025-12-04 16:49:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:49:07'),
(224, 2, '2025-12-04 16:49:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:49:07'),
(225, 1, '2025-12-04 16:52:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:52:27'),
(225, 2, '2025-12-04 16:52:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:52:27'),
(226, 1, '2025-12-04 16:52:57', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 16:52:57'),
(227, 1, '2025-12-04 17:12:36', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:12:36'),
(227, 2, '2025-12-04 17:12:36', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:12:36'),
(228, 1, '2025-12-04 17:14:05', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:14:05'),
(228, 2, '2025-12-04 17:14:05', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:14:05'),
(229, 1, '2025-12-04 17:14:16', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:14:16'),
(229, 2, '2025-12-04 17:14:16', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:14:16'),
(230, 1, '2025-12-04 17:14:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:14:25'),
(230, 2, '2025-12-04 17:14:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-04 17:14:25'),
(231, 2, '2025-12-05 11:08:07', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 11:08:07'),
(233, 1, '2025-12-05 11:08:29', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 11:08:29'),
(234, 1, '2025-12-05 12:06:29', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:06:29'),
(234, 2, '2025-12-05 12:06:29', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:06:29'),
(235, 1, '2025-12-05 12:13:16', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:13:16'),
(235, 2, '2025-12-05 12:13:16', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:13:16'),
(236, 1, '2025-12-05 12:14:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:14:27'),
(236, 2, '2025-12-05 12:14:27', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:14:27'),
(237, 1, '2025-12-05 12:18:57', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 12:18:57'),
(238, 1, '2025-12-05 14:48:35', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:48:35'),
(239, 1, '2025-12-05 14:48:47', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:48:47'),
(240, 1, '2025-12-05 14:49:47', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:49:47'),
(240, 2, '2025-12-05 14:49:47', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:49:47'),
(241, 1, '2025-12-05 14:50:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:50:04'),
(242, 1, '2025-12-05 14:59:40', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:59:40'),
(242, 2, '2025-12-05 14:59:40', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:59:40'),
(243, 1, '2025-12-05 14:59:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:59:54'),
(243, 2, '2025-12-05 14:59:54', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 14:59:54'),
(244, 1, '2025-12-05 16:49:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 16:49:13'),
(244, 2, '2025-12-05 16:49:13', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 16:49:13'),
(245, 1, '2025-12-05 16:56:30', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 16:56:30'),
(245, 2, '2025-12-05 16:56:30', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 16:56:30'),
(246, 1, '2025-12-05 17:14:43', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 17:14:43'),
(247, 1, '2025-12-05 17:20:55', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 17:20:55'),
(248, 2, '2025-12-05 17:22:38', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 17:22:38'),
(248, 1, '2025-12-05 17:22:38', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 17:22:38'),
(249, 1, '2025-12-05 19:48:46', 'info@acedecors.in', 'info@acedecors.in', '2025-12-05 19:48:46'),
(251, 1, '2025-12-06 17:09:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:09:44'),
(250, 1, '2025-12-06 17:09:33', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:09:33'),
(251, 2, '2025-12-06 17:09:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:09:44'),
(252, 1, '2025-12-06 17:09:51', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:09:51'),
(252, 3, '2025-12-06 17:09:51', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:09:51'),
(253, 1, '2025-12-06 17:10:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:10:00'),
(253, 2, '2025-12-06 17:10:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:10:00'),
(253, 3, '2025-12-06 17:10:00', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:10:00'),
(254, 1, '2025-12-06 17:15:47', 'info@acedecors.in', 'info@acedecors.in', '2025-12-06 17:15:47'),
(255, 2, '2025-12-07 14:31:56', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 14:31:56'),
(256, 2, '2025-12-07 17:27:44', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:27:44'),
(257, 1, '2025-12-07 17:52:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:52:49'),
(257, 2, '2025-12-07 17:52:49', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:52:49'),
(258, 1, '2025-12-07 17:54:11', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:54:11'),
(258, 2, '2025-12-07 17:54:11', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:54:11'),
(258, 3, '2025-12-07 17:54:11', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:54:11'),
(259, 2, '2025-12-07 17:57:58', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 17:57:58'),
(260, 1, '2025-12-07 18:02:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 18:02:04'),
(260, 2, '2025-12-07 18:02:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 18:02:04'),
(261, 1, '2025-12-07 18:02:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 18:02:25'),
(261, 2, '2025-12-07 18:02:25', 'info@acedecors.in', 'info@acedecors.in', '2025-12-07 18:02:25'),
(262, 2, '2026-02-13 15:19:04', 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:19:04'),
(262, 1, '2026-02-13 15:19:04', 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:19:04'),
(264, 1, '2025-12-15 11:01:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-15 11:01:04'),
(264, 2, '2025-12-15 11:01:04', 'info@acedecors.in', 'info@acedecors.in', '2025-12-15 11:01:04'),
(265, 3, '2025-12-18 17:28:56', 'info@acedecors.in', 'info@acedecors.in', '2025-12-18 17:28:56'),
(265, 1, '2025-12-18 17:28:56', 'info@acedecors.in', 'info@acedecors.in', '2025-12-18 17:28:56'),
(266, 2, '2026-02-10 16:00:27', 'info@acedecors.in', 'info@acedecors.in', '2026-02-10 16:00:27'),
(267, 1, '2026-02-10 16:31:13', 'info@acedecors.in', 'info@acedecors.in', '2026-02-10 16:31:13'),
(268, 1, '2026-02-10 16:02:10', 'info@acedecors.in', 'info@acedecors.in', '2026-02-10 16:02:10'),
(269, 1, '2026-02-10 17:52:26', 'info@acedecors.in', 'info@acedecors.in', '2026-02-10 17:52:26'),
(270, 1, '2026-02-26 11:47:47', 'info@acedecors.in', 'info@acedecors.in', '2026-02-26 11:47:47'),
(263, 2, '2026-02-25 15:57:50', 'info@acedecors.in', 'info@acedecors.in', '2026-02-25 15:57:50'),
(263, 1, '2026-02-25 15:57:50', 'info@acedecors.in', 'info@acedecors.in', '2026-02-25 15:57:50');

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `itemallocation`
--

DROP TABLE IF EXISTS `itemallocation`;
CREATE TABLE IF NOT EXISTS `itemallocation` (
  `item_stockId` int NOT NULL,
  `ProjectId` int NOT NULL,
  `ItemId` int NOT NULL,
  `InputName` varchar(50) NOT NULL,
  `AllocatedQty` int NOT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `item_stockId` (`item_stockId`),
  KEY `ProjectId` (`ProjectId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemallocation`
--

INSERT INTO `itemallocation` (`item_stockId`, `ProjectId`, `ItemId`, `InputName`, `AllocatedQty`, `modifiedOn`) VALUES
(0, 74, 125, 'TV Units', 5, '2026-02-26 15:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `itemissues_followup`
--

DROP TABLE IF EXISTS `itemissues_followup`;
CREATE TABLE IF NOT EXISTS `itemissues_followup` (
  `followupId` int NOT NULL AUTO_INCREMENT,
  `followupPOID` int NOT NULL,
  `followup_ItemId` int NOT NULL,
  `followup_comments` varchar(200) NOT NULL,
  `Status` varchar(100) DEFAULT 'Open',
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(100) NOT NULL,
  PRIMARY KEY (`followupId`),
  KEY `followup_ItemId` (`followup_ItemId`),
  KEY `followupPOID` (`followupPOID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemissues_followup`
--

INSERT INTO `itemissues_followup` (`followupId`, `followupPOID`, `followup_ItemId`, `followup_comments`, `Status`, `followup_createdon`, `followup_by`) VALUES
(1, 4, 1, 'damaged', NULL, '2022-03-08 05:25:29', 'info@acedecors.in'),
(2, 87, 162, 'assdasd', 'Closed', '2026-01-21 19:48:36', 'info@acedecors.in'),
(3, 108, 175, 'broken', 'Open', '2026-02-25 06:21:53', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

DROP TABLE IF EXISTS `item_category`;
CREATE TABLE IF NOT EXISTS `item_category` (
  `item_catid` int NOT NULL AUTO_INCREMENT,
  `item_catName` varchar(200) NOT NULL,
  `item_catDescription` varchar(500) NOT NULL,
  `item_catCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_catCreatedBy` varchar(200) NOT NULL,
  `item_catModifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_catModifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`item_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`item_catid`, `item_catName`, `item_catDescription`, `item_catCreatedOn`, `item_catCreatedBy`, `item_catModifiedOn`, `item_catModifiedBy`) VALUES
(122, 'Living Room', 'Sofas', '2025-12-15 11:04:11', 'info@acedecors.in', '2025-12-15 11:04:11', 'info@acedecors.in'),
(121, 'Bed Rooms', 'Beds', '2025-12-15 11:01:31', 'info@acedecors.in', '2025-12-15 11:01:31', 'info@acedecors.in'),
(124, 'CUSTOMISATIONS', 'Bed', '2026-01-06 17:45:30', 'info@acedecors.in', '2026-01-06 17:45:30', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `item_companydetails`
--

DROP TABLE IF EXISTS `item_companydetails`;
CREATE TABLE IF NOT EXISTS `item_companydetails` (
  `item_compid` int NOT NULL AUTO_INCREMENT,
  `item_compName` varchar(200) NOT NULL,
  `item_compContactName` varchar(200) DEFAULT NULL,
  `item_compContactNumber` varchar(20) DEFAULT NULL,
  `item_compDescription` varchar(500) NOT NULL,
  `item_compGSTIN` varchar(20) NOT NULL,
  `item_compAccountno` varchar(100) NOT NULL,
  `item_compAccountname` varchar(100) NOT NULL,
  `item_compaccIFSCcode` varchar(100) NOT NULL,
  `item_compaccMICRcode` varchar(100) NOT NULL,
  `item_compAddress` varchar(1000) NOT NULL,
  `item_compLocation` varchar(150) NOT NULL,
  `item_compCreatedBy` varchar(200) NOT NULL,
  `item_compCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_compModifiedBy` varchar(200) NOT NULL,
  `item_compModifedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_complogo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_compid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_companydetails`
--

INSERT INTO `item_companydetails` (`item_compid`, `item_compName`, `item_compContactName`, `item_compContactNumber`, `item_compDescription`, `item_compGSTIN`, `item_compAccountno`, `item_compAccountname`, `item_compaccIFSCcode`, `item_compaccMICRcode`, `item_compAddress`, `item_compLocation`, `item_compCreatedBy`, `item_compCreatedOn`, `item_compModifiedBy`, `item_compModifedOn`, `item_complogo`) VALUES
(14, 'Moin The Distributer', NULL, NULL, 'fdfdgdfg', '29AAACH8849M1ZT', '45673456', 'Moin', 'ICIC12453', 'UIR012345', 'Tippu Nagar', 'Hubli', 'info@acedecors.in', '2026-01-20 16:38:27', 'info@acedecors.in', '2026-01-22 16:31:32', 'EKO & KALAMKAVAL.jpg'),
(15, 'Moin', NULL, NULL, 'CNR LLP', '29AAACH8845M1ZT', '234234252', 'CNR LLP', 'ICIC124534', 'UIR0123453', 'Nekar nagar', 'Dharwad', 'info@acedecors.in', '2026-01-22 17:25:08', 'info@acedecors.in', '2026-01-22 17:25:08', '00c914113991421.603326681d18f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_details`
--

DROP TABLE IF EXISTS `item_details`;
CREATE TABLE IF NOT EXISTS `item_details` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) NOT NULL,
  `item_description` varchar(500) NOT NULL,
  `item_catid` int NOT NULL,
  `item_subcatid` int NOT NULL,
  `item_compid` int NOT NULL,
  `item_image` varchar(200) NOT NULL,
  `item_createdby` varchar(200) NOT NULL,
  `item_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_modifiedby` varchar(200) NOT NULL,
  `item_modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_HSNcode` varchar(100) NOT NULL,
  `item_ArticleNo` varchar(100) NOT NULL,
  `item_SAPId` varchar(25) DEFAULT NULL,
  `Item_OrderNumber` varchar(25) DEFAULT NULL,
  `item_Size` int NOT NULL,
  `item_PackingUnit` int NOT NULL,
  `item_MRP` double NOT NULL,
  `item_Amount` double NOT NULL DEFAULT '0',
  `item_pp_MRP` double NOT NULL,
  `item_descriptionforcust` varchar(500) DEFAULT NULL,
  `item_GST` int NOT NULL,
  `item_Discount` decimal(10,2) DEFAULT '0.00',
  `item_Price` decimal(10,2) DEFAULT '0.00',
  `item_TotalValue` decimal(10,2) DEFAULT '0.00',
  `item_unit` varchar(100) NOT NULL,
  `item_unitFactor` double NOT NULL,
  `item_totalMRP` double NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=184 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_details`
--

INSERT INTO `item_details` (`item_id`, `item_name`, `item_description`, `item_catid`, `item_subcatid`, `item_compid`, `item_image`, `item_createdby`, `item_createdon`, `item_modifiedby`, `item_modifiedon`, `item_HSNcode`, `item_ArticleNo`, `item_SAPId`, `Item_OrderNumber`, `item_Size`, `item_PackingUnit`, `item_MRP`, `item_Amount`, `item_pp_MRP`, `item_descriptionforcust`, `item_GST`, `item_Discount`, `item_Price`, `item_TotalValue`, `item_unit`, `item_unitFactor`, `item_totalMRP`) VALUES
(182, 'Caoch', 'ffgdfgg', 122, 83, 263, '', 'info@acedecors.in', '2026-02-26 15:25:12', 'info@acedecors.in', '2026-02-26 16:22:25', '12343', '12344', NULL, NULL, 1, 10, 250, 12500, 0, NULL, 18, 20.00, 11800.00, 11800.00, '60', 30, 2500),
(183, 'Sinks', 'gdsfgdfg', 122, 85, 263, '', 'info@acedecors.in', '2026-02-27 11:04:50', 'info@acedecors.in', '2026-02-27 11:04:50', '12343', '12344', NULL, NULL, 1, 10, 250, 1250, 0, NULL, 18, 10.00, 1327.50, 13275.00, '60', 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_pricingissues`
--

DROP TABLE IF EXISTS `item_pricingissues`;
CREATE TABLE IF NOT EXISTS `item_pricingissues` (
  `PricingIssues_Id` int NOT NULL AUTO_INCREMENT,
  `InvoiceNo` int NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `ItemName` varchar(100) NOT NULL,
  `POID` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Issue_ModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ItemId` int DEFAULT NULL,
  PRIMARY KEY (`PricingIssues_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_pricingissues`
--

INSERT INTO `item_pricingissues` (`PricingIssues_Id`, `InvoiceNo`, `SupplierName`, `ItemName`, `POID`, `Status`, `Issue_ModifiedOn`, `ItemId`) VALUES
(26, 0, '', '', '', '', '2026-01-22 13:04:58', NULL),
(34, 0, '', '', '', '', '2026-01-22 16:12:05', NULL),
(8, 20014123, 'Moin The Distributer', 'slides', 'AD-202601-MTD86', 'Open', '2026-01-21 19:36:26', NULL),
(7, 20013, 'Moin The Distributer', 'slides', 'AD-202601-MTD86', 'Closed', '2026-01-21 19:35:37', NULL),
(6, 20014654, 'Moin The Distributer', 'Caoch', 'AD-202601-MTD87', 'Closed', '2026-01-21 19:35:57', NULL),
(12, 0, '', '', '', '', '2026-01-22 11:59:14', NULL),
(11, 0, '', '', '', '', '2026-01-22 11:58:57', NULL),
(18, 0, '', '', '', '', '2026-01-22 12:09:44', NULL),
(21, 0, '', '', '', '', '2026-01-22 12:15:18', NULL),
(19, 0, '', '', '', '', '2026-01-22 12:15:01', NULL),
(20, 0, '', '', '', '', '2026-01-22 12:15:01', NULL),
(17, 0, '', '', '', '', '2026-01-22 12:09:36', NULL),
(22, 0, '', '', '', '', '2026-01-22 12:15:18', NULL),
(23, 0, '', '', '', '', '2026-01-22 12:15:26', NULL),
(24, 0, '', '', '', '', '2026-01-22 12:15:35', NULL),
(25, 0, '', '', '', '', '2026-01-22 13:04:46', NULL),
(30, 0, '', '', '', '', '2026-01-22 16:11:26', NULL),
(29, 0, '', '', '', '', '2026-01-22 16:11:16', NULL),
(33, 0, '', '', '', '', '2026-01-22 16:11:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

DROP TABLE IF EXISTS `item_stock`;
CREATE TABLE IF NOT EXISTS `item_stock` (
  `item_stockid` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `ItemCode` varchar(50) NOT NULL,
  `ItemName` varchar(50) NOT NULL,
  `POID` int NOT NULL,
  `InvoiceNo` int NOT NULL,
  `Quantity` int NOT NULL,
  `Unit` varchar(100) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `TotalAmount` decimal(12,2) DEFAULT NULL,
  `GST` varchar(50) DEFAULT NULL,
  `ReceivedQtyAmt` decimal(12,2) DEFAULT NULL,
  `ReceivedQty` int DEFAULT NULL,
  `BalanceQty` int DEFAULT '0',
  `stockPDFName` varchar(100) DEFAULT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_stockid`),
  KEY `POID` (`POID`)
) ENGINE=MyISAM AUTO_INCREMENT=199 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock`
--

INSERT INTO `item_stock` (`item_stockid`, `item_id`, `ItemCode`, `ItemName`, `POID`, `InvoiceNo`, `Quantity`, `Unit`, `Price`, `TotalAmount`, `GST`, `ReceivedQtyAmt`, `ReceivedQty`, `BalanceQty`, `stockPDFName`, `modifiedOn`) VALUES
(186, 175, '12344', 'slides', 108, 20012, 10, 'U2', 10000.50, 0.00, '18', 50.00, 5, 5, NULL, '2026-02-20 11:32:27'),
(187, 177, '1234430', 'Caoch', 109, 20014, 10, 'U1', 94.40, 0.00, '18', 50.00, 1, 9, NULL, '2026-02-25 15:48:50'),
(188, 177, '1234430', 'Caoch', 110, 20014, 5, 'U1', 94.40, 0.00, '18', 1350.00, 1, 4, NULL, '2026-02-25 15:50:47'),
(189, 177, '1234430', 'Caoch', 111, 200146, 20, 'U1', 94.40, 0.00, '18', 460.00, 5, 15, NULL, '2026-02-25 15:51:49'),
(190, 178, '12344', 'Caoch', 112, 20014, 10, 'U1', 94.40, 0.00, '18', 500.00, 1, 9, NULL, '2026-02-25 16:00:52'),
(191, 122, '456', 'Sliding Door', 113, 20013, 10, 'U1', 492.80, 0.00, '10', 1350.00, 1, 9, NULL, '2026-02-25 16:01:32'),
(192, 123, '0012', 'TV Units', 115, 20012, 10, 'U1', 361.08, 0.00, '18', 100.00, 5, 5, NULL, '2026-02-26 11:56:33'),
(193, 124, '001265', 'Sliding Door', 116, 20014, 10, 'U1', 274.64, 0.00, '18', 50.00, 5, 5, NULL, '2026-02-26 11:56:48'),
(194, 179, '12344', 'Caoch', 117, 20014, 10, 'U1', 94.40, 0.00, '18', 94.00, 5, 5, NULL, '2026-02-26 13:42:53'),
(195, 180, '12344303', 'Sinks', 118, 20013, 10, 'U1', 265.50, 0.00, '18', 50.00, 2, 8, NULL, '2026-02-26 13:43:16'),
(196, 182, '12344', 'Caoch', 119, 20012, 10, 'U1', 236.00, 0.00, '18', 50.00, 2, 8, NULL, '2026-02-26 15:29:37'),
(197, 125, '0012', 'TV Units', 120, 200146, 10, 'U1', 94.40, 0.00, '18', 460.00, 5, 5, NULL, '2026-02-26 15:29:51'),
(198, 183, '12344', 'Sinks', 121, 200146, 10, 'U11', 1327.50, 0.00, '18', 500.00, 5, 5, NULL, '2026-02-27 11:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_subcategory`
--

DROP TABLE IF EXISTS `item_subcategory`;
CREATE TABLE IF NOT EXISTS `item_subcategory` (
  `item_subcatid` int NOT NULL AUTO_INCREMENT,
  `item_catid` int NOT NULL,
  `item_subcatName` varchar(200) NOT NULL,
  `item_subcatDescription` varchar(500) NOT NULL,
  `item_subcatCreatedBy` varchar(200) NOT NULL,
  `item_subcatCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_subcatModifiedBy` varchar(200) NOT NULL,
  `item_subcatModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_subcatid`),
  KEY `item_catid` (`item_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_subcategory`
--

INSERT INTO `item_subcategory` (`item_subcatid`, `item_catid`, `item_subcatName`, `item_subcatDescription`, `item_subcatCreatedBy`, `item_subcatCreatedOn`, `item_subcatModifiedBy`, `item_subcatModifiedon`) VALUES
(79, 121, 'Sleeping Bed', 'For Sleeping', 'info@acedecors.in', '2025-12-15 11:03:36', 'info@acedecors.in', '2025-12-15 11:17:03'),
(81, 124, 'Awesome Kitchen', 'Best Kitchens', 'info@acedecors.in', '2025-12-15 11:04:59', 'info@acedecors.in', '2026-01-06 17:45:47'),
(83, 122, 'Best Kitchens', 'Best Kitchens', 'info@acedecors.in', '2026-01-12 13:57:53', 'info@acedecors.in', '2026-01-12 13:57:53'),
(85, 122, 'Awesome KitcSASDASDSDhen', 'aSasASAS', 'info@acedecors.in', '2026-02-25 15:19:50', 'info@acedecors.in', '2026-02-25 15:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `Material_Id` int NOT NULL AUTO_INCREMENT,
  `Material_Name` varchar(100) NOT NULL,
  `Material_Code` varchar(100) NOT NULL,
  `Material_Description` varchar(100) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `SubCategory` varchar(100) NOT NULL,
  `Mat_Qty` int NOT NULL,
  `Brand` varchar(100) NOT NULL,
  `Mat_Thickness` varchar(100) NOT NULL,
  `Mat_Unit` varchar(100) NOT NULL,
  `Mat_factor` double NOT NULL,
  `Mat_HSNCode` varchar(100) NOT NULL,
  `Mat_SPU` int NOT NULL,
  `Mat_MRP` double NOT NULL,
  `Mat_GST` int NOT NULL,
  `Mat_TotalMRP` int NOT NULL,
  `Mat_PPMRP` int NOT NULL,
  `Mat_Image` varchar(200) NOT NULL,
  `Mat_Grains` varchar(100) NOT NULL,
  `Mat_createdBy` varchar(100) NOT NULL,
  `Mat_modifiedBy` varchar(100) NOT NULL,
  `MaterialDiscount` decimal(10,2) DEFAULT NULL,
  `MaterialAmount` double DEFAULT '0',
  `MaterialPrice` decimal(10,2) DEFAULT NULL,
  `MaterialTotalValue` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Material_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`Material_Id`, `Material_Name`, `Material_Code`, `Material_Description`, `Category`, `SubCategory`, `Mat_Qty`, `Brand`, `Mat_Thickness`, `Mat_Unit`, `Mat_factor`, `Mat_HSNCode`, `Mat_SPU`, `Mat_MRP`, `Mat_GST`, `Mat_TotalMRP`, `Mat_PPMRP`, `Mat_Image`, `Mat_Grains`, `Mat_createdBy`, `Mat_modifiedBy`, `MaterialDiscount`, `MaterialAmount`, `MaterialPrice`, `MaterialTotalValue`) VALUES
(126, 'Sturde1', '0012', 'ddfsd', '36', '33', 1, '263', '2', '60', 30, '2342', 10, 100, 18, 0, 0, '70530604_604.jpg', '3', 'info@acedecors.in', 'info@acedecors.in', 10.00, 500, 531.00, 5310.00),
(125, 'TV Units', '0012', 'hgjghj', '36', '33', 10, '263', '1', '60', 30, '2342', 10, 100, 18, 0, 0, 'ChatGPT Image Feb 25, 2026, 05_35_56 PM.jpg', '4', 'info@acedecors.in', 'info@acedecors.in', 20.00, 100, 94.40, 944.00);

-- --------------------------------------------------------

--
-- Table structure for table `materialissues_followup`
--

DROP TABLE IF EXISTS `materialissues_followup`;
CREATE TABLE IF NOT EXISTS `materialissues_followup` (
  `followup_Id` int NOT NULL AUTO_INCREMENT,
  `followup_POID` int NOT NULL,
  `followup_MaterialId` int NOT NULL,
  `followup_comments` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Open',
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(50) NOT NULL,
  PRIMARY KEY (`followup_Id`),
  KEY `followup_POID` (`followup_POID`),
  KEY `followup_MaterialId` (`followup_MaterialId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materialissues_followup`
--

INSERT INTO `materialissues_followup` (`followup_Id`, `followup_POID`, `followup_MaterialId`, `followup_comments`, `Status`, `followup_createdon`, `followup_by`) VALUES
(2, 88, 96, 'kfhvj', 'Open', '2026-01-22 15:38:39', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `material_category`
--

DROP TABLE IF EXISTS `material_category`;
CREATE TABLE IF NOT EXISTS `material_category` (
  `material_catId` int NOT NULL AUTO_INCREMENT,
  `material_catName` varchar(100) NOT NULL,
  `material_catDescription` varchar(100) NOT NULL,
  `material_catCreatedBy` varchar(100) NOT NULL,
  `material_catCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `material_catModifiedBy` varchar(50) NOT NULL,
  `material_catModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`material_catId`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_category`
--

INSERT INTO `material_category` (`material_catId`, `material_catName`, `material_catDescription`, `material_catCreatedBy`, `material_catCreatedOn`, `material_catModifiedBy`, `material_catModifiedOn`) VALUES
(39, 'PLCC', 'ddffcvcxv', 'info@acedecors.in', '2026-02-19 13:31:24', 'info@acedecors.in', '2026-02-19 13:31:39'),
(38, 'Bed Rooms', 'Beds', 'info@acedecors.in', '2026-02-13 15:24:45', 'info@acedecors.in', '2026-02-13 15:24:45'),
(37, 'Living Rooms', 'Beds', 'info@acedecors.in', '2026-02-13 15:24:35', 'info@acedecors.in', '2026-02-13 15:24:35'),
(36, 'Card Boards', 'Boards', 'info@acedecors.in', '2026-02-13 15:24:17', 'info@acedecors.in', '2026-02-13 15:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `material_pricingissues`
--

DROP TABLE IF EXISTS `material_pricingissues`;
CREATE TABLE IF NOT EXISTS `material_pricingissues` (
  `PricingIssues_Id` int NOT NULL AUTO_INCREMENT,
  `InvoiceNo` int NOT NULL,
  `SupplierName` varchar(50) NOT NULL,
  `MaterialName` varchar(50) NOT NULL,
  `POID` varchar(20) NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Open',
  `Issue_ModifiedOn` int NOT NULL,
  PRIMARY KEY (`PricingIssues_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `material_subcategory`
--

DROP TABLE IF EXISTS `material_subcategory`;
CREATE TABLE IF NOT EXISTS `material_subcategory` (
  `material_subcatId` int NOT NULL AUTO_INCREMENT,
  `material_catId` int NOT NULL,
  `material_subcatName` varchar(100) NOT NULL,
  `material_subcatDescription` varchar(100) NOT NULL,
  `material_subcatCreatedBy` varchar(100) NOT NULL,
  `material_subcatCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `material_subcatModifiedBy` varchar(50) NOT NULL,
  `material_subcatModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`material_subcatId`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_subcategory`
--

INSERT INTO `material_subcategory` (`material_subcatId`, `material_catId`, `material_subcatName`, `material_subcatDescription`, `material_subcatCreatedBy`, `material_subcatCreatedOn`, `material_subcatModifiedBy`, `material_subcatModifiedon`) VALUES
(34, 39, 'CardBoard', 'For Sitting', 'info@acedecors.in', '2026-02-19 13:32:00', 'info@acedecors.in', '2026-02-19 13:32:12'),
(33, 36, 'CardBoard', 'For Walls', 'info@acedecors.in', '2026-02-13 15:25:12', 'info@acedecors.in', '2026-02-13 15:25:12'),
(32, 37, 'Sofa', 'For Sitting', 'info@acedecors.in', '2026-02-13 15:25:03', 'info@acedecors.in', '2026-02-13 15:25:03'),
(31, 38, 'Beds', 'For Sleeping', 'info@acedecors.in', '2026-02-13 15:24:57', 'info@acedecors.in', '2026-02-13 15:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `module_id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `module_label` varchar(100) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `module_name` (`module_name`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `module_label`) VALUES
(1, 'dashboard', 'Dashboard'),
(2, 'enquiry', 'Enquiries'),
(3, 'channelpartner', 'Channel Partners'),
(4, 'inventory', 'Inventory'),
(5, 'employees', 'Employees'),
(6, 'customers', 'Customers'),
(7, 'projects', 'Projects'),
(8, 'purchase_orders', 'Purchase Orders'),
(9, 'payments', 'Payments');

-- --------------------------------------------------------

--
-- Table structure for table `module_actions`
--

DROP TABLE IF EXISTS `module_actions`;
CREATE TABLE IF NOT EXISTS `module_actions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) DEFAULT NULL,
  `action_key` varchar(50) DEFAULT NULL,
  `action_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `module_actions`
--

INSERT INTO `module_actions` (`id`, `module_name`, `action_key`, `action_label`) VALUES
(1, 'enquiry', 'enquiry_category', 'Enquiry Category'),
(2, 'enquiry', 'create_enquiry', 'Create Enquiry'),
(3, 'enquiry', 'follow_up', 'Follow Up'),
(4, 'enquiry', 'enquiry_info', 'Enquiry Info'),
(5, 'enquiry', 'create_customer', 'Create Customer'),
(6, 'enquiry', 'delete_enquiry', 'Delete Enquiry'),
(7, 'enquiry', 'edit_enquiry', 'Edit Enquiry'),
(8, 'channelpartner', 'brands', 'Brands'),
(9, 'channelpartner', 'suppliers', 'Suppliers'),
(10, 'inventory', 'details', 'Details'),
(11, 'inventory', 'item', 'Item'),
(12, 'inventory', 'material', 'Material'),
(13, 'inventory', 'stocklist', 'Stock List'),
(14, 'employees', 'employee', 'Employee'),
(15, 'employees', 'attendance', 'Attendance'),
(16, 'employees', 'attendance_reports', 'Attendance Reports'),
(17, 'employees', 'transaction', 'Transaction'),
(18, 'customers', 'edit_customer', 'Edit Customer'),
(19, 'customers', 'customer_info', 'Customer Info'),
(20, 'customers', 'designs', 'Designs'),
(21, 'customers', 'customer_inputs', 'Inputs'),
(22, 'customers', 'delete_customer', 'Delete Customer'),
(23, 'customers', 'input_list', 'Input List'),
(24, 'customers', 'quotation_customer_info', 'Customer Info'),
(25, 'customers', 'edit_quotation', 'Edit Quotation'),
(26, 'customers', 'quotation_info', 'Quotation Info'),
(27, 'customers', 'print_quote', 'Print Quote'),
(28, 'customers', 'delete_quotation', 'Delete Quotation'),
(29, 'projects', 'task_followup', 'FollowUp'),
(30, 'projects', 'task_edit', 'Edit Task'),
(31, 'projects', 'task_delete', 'Delete Task'),
(32, 'projects', 'ongoing_info', 'Project Info'),
(33, 'projects', 'ongoing_allocate', 'Project Allocation'),
(34, 'projects', 'pending_info', 'Project Info'),
(35, 'projects', 'pending_allocate', 'Project Allocation'),
(36, 'projects', 'pending_delete', 'Delete Project'),
(37, 'projects', 'completed_info', 'Project Info'),
(38, 'projects', 'completed_delete', 'Delete Project'),
(43, 'purchase_orders', 'po_general', 'General Purchase Order'),
(42, 'purchase_orders', 'po_view', 'View Purchase Order'),
(44, 'purchase_orders', 'po_transaction', 'Transaction'),
(45, 'payments', 'pay_dashboard', 'Dashboard'),
(46, 'payments', 'pay_subcategory', 'Subcategory'),
(47, 'payments', 'pay_transaction', 'Transaction');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `can_read` tinyint(1) DEFAULT '0',
  `can_write` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `postId` int NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(100) NOT NULL,
  `postUrl` varchar(100) NOT NULL,
  `LinkUnder` int NOT NULL,
  `appearOnHome` varchar(1) NOT NULL DEFAULT '0',
  `postDescription` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `postCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postCreatedBy` varchar(100) NOT NULL,
  `postModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titleTag` varchar(100) NOT NULL,
  `keywords` mediumtext NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`postId`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `postTitle`, `postUrl`, `LinkUnder`, `appearOnHome`, `postDescription`, `postCreatedOn`, `postCreatedBy`, `postModifiedOn`, `titleTag`, `keywords`, `modifiedBy`) VALUES
(71, 'Best-sofa', '/Best-sofa', 2, '0', '<p>Best-sofa\n<br />\n</p>\n', '2025-10-03 23:28:54', 'info@acedecors.in', '2025-10-03 23:28:54', 'Best-sofa', 'Best-sofa', 'info@acedecors.in'),
(72, 'Best-sofa', '/Best-sofa', 2, '0', '<p>Best-sofa\n<br />\n</p>\n', '2025-10-03 23:29:17', 'info@acedecors.in', '2025-10-03 23:29:17', 'Best-sofa', 'Best-sofa', 'info@acedecors.in'),
(73, 'Best-sofa', '/Best-sofa', 2, '1', '<p>Best-sofa\n<br />\n</p>\n', '2025-10-03 23:30:15', 'info@acedecors.in', '2025-10-03 23:30:15', 'Best-sofa', 'Best-sofa', 'info@acedecors.in'),
(88, 'L Shaped Island Kitchen', '/L-Shaped-Island-Kitchen', 2, '1', '<p><span size=\"large\">A white acrylic island kitchen with a quartz top is the perfect solution for a clean, modern, and durable kitchen space. The bright, reflective white finish creates an airy, open feel, while the quartz top adds luxury and practicality â€” scratch-resistant, easy to clean, and highly durable.</span><span align=\"justify\">\n</span><br />\n\n<br />\n</p>\n', '2025-10-09 10:29:53', 'info@acedecors.in', '2025-10-09 10:29:53', 'L Shaped Island Kitchen', 'L Shaped Island Kitchen', 'info@acedecors.in'),
(34, 'All Kitchen Accessories', '/All-Kitchen-Accessories', 1, '', '<p>xyz\n<br />\n</p>\n', '2022-01-22 17:27:48', 'info@acedecors.in', '2025-09-08 01:21:13', 'All Kitchen Accessories', 'All Kitchen Accessories', 'info@acedecors.in'),
(85, 'Topline Sliding Wardrobes', '/Topline-Sliding-Wardrobes', 2, '1', '<p>Sliding wardrobes are the perfect solution when space optimization matters. They offer a sleek, modern appearance while providing practical storage that adapts to your lifestyle. The smooth operation and clean lines help create a clutter-free, minimalist atmosphere.<span align=\"justify\">\n</span><br />\n\n<br />\n</p>\n', '2025-10-09 09:20:14', 'info@acedecors.in', '2025-10-09 09:21:01', 'Topline Sliding Wardrobes', 'Topline Sliding Wardrobes', 'info@acedecors.in'),
(86, 'Minimalist Wardrobes', '/Minimalist-Wardrobes', 2, '0', '<p>Minimalist wardrobes are the perfect blend of sleek design and smart storage. They focus on simplicity, allowing your space to feel open, organized, and calming. Whether you live in a compact apartment or a modern home, these wardrobes bring elegance and order without overwhelming the room.<span align=\"justify\">\n</span><br />\n\n<br />\n</p>\n', '2025-10-09 09:28:28', 'info@acedecors.in', '2025-10-09 09:28:28', 'Minimalist Wardrobes', 'Minimalist Wardrobes', 'info@acedecors.in'),
(79, 'Best-sofa', '/Best-sofa', 2, '1', '<p>Best-sofa\n<br />\n</p>\n', '2025-10-04 22:45:23', 'info@acedecors.in', '2025-10-04 22:45:23', 'Best-sofa', 'Best-sofa', 'info@acedecors.in'),
(87, 'The Aura Ensemble', '/The-Aura-Ensemble', 2, '1', '<p><span size=\"large\">Refined simplicity meets functional artistry in </span><em size=\"large\">The Aura Ensemble</em><span size=\"large\"> by </span><strong size=\"large\">Ace Decors</strong><span size=\"large\">. This modern wall-mounted TV unit is a symphony of clean lines, warm wood textures, and subtle lighting that enhances the ambiance of any contemporary living space. </span>\n\n</p>\n<p><span size=\"large\"> Thoughtfully designed with floating cabinets and open shelves, it blends sophistication with practicality â€” offering ample space for dÃ©cor accents, books, and entertainment essentials. The soft backlighting creates a serene visual frame, transforming your TV wall into a statement feature. </span>\n\n</p>\n<p><span size=\"large\"> Crafted with precision and a minimalist design philosophy, this unit embodies Ace Decorsâ€™ vision of </span><strong size=\"large\">modern comfort with timeless appeal</strong><span size=\"large\">. </span>\n<br />\n</p>\n', '2025-10-09 10:19:04', '', '2025-10-09 10:25:52', 'The Aura Ensemble', 'The Aura Ensemble', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `postcatmapping`
--

DROP TABLE IF EXISTS `postcatmapping`;
CREATE TABLE IF NOT EXISTS `postcatmapping` (
  `postId` int NOT NULL,
  `catId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `postcatmapping`
--

INSERT INTO `postcatmapping` (`postId`, `catId`) VALUES
(30, 21),
(31, 21),
(32, 21),
(33, 21),
(47, 21),
(48, 22),
(48, 23),
(48, 21),
(27, 21),
(45, 23),
(49, 23),
(50, 23),
(51, 23),
(52, 21),
(53, 26),
(54, 21),
(55, 21),
(56, 22),
(56, 26),
(57, 26),
(37, 27),
(38, 27),
(39, 27),
(40, 27),
(41, 27),
(42, 27),
(44, 27),
(43, 27),
(60, 21),
(61, 27),
(62, 21),
(59, 21);

-- --------------------------------------------------------

--
-- Table structure for table `postimages`
--

DROP TABLE IF EXISTS `postimages`;
CREATE TABLE IF NOT EXISTS `postimages` (
  `postImageId` int NOT NULL AUTO_INCREMENT,
  `postImage` longblob NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdBy` varchar(100) NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  `imageAlternateText` varchar(100) NOT NULL,
  `postId` int NOT NULL,
  PRIMARY KEY (`postImageId`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `postimages`
--

INSERT INTO `postimages` (`postImageId`, `postImage`, `createdOn`, `modifiedOn`, `createdBy`, `modifiedBy`, `imageAlternateText`, `postId`) VALUES
(16, 0x706f7374322e6a7067, '2022-01-21 16:16:28', '2025-09-08 01:27:25', 'info@acedecors.in', 'info@acedecors.in', 'Urban', 16),
(15, 0x706f7374312e6a7067, '2022-01-21 16:14:21', '2025-09-08 05:24:03', 'info@acedecors.in', 'info@acedecors.in', 'Pure', 15),
(17, 0x706f7374332e6a7067, '2022-01-21 16:20:31', '2025-09-08 05:24:03', 'info@acedecors.in', 'info@acedecors.in', 'Classic', 17),
(78, 0x41442d4b69746368656e30312e6a7067, '2025-10-09 10:29:53', '2025-10-09 10:29:53', 'info@acedecors.in', 'info@acedecors.in', 'L Shaped Island Kitchen', 88),
(75, 0x41442d536c6964696e672057617264726f62652d3030312e6a7067, '2025-10-09 09:20:14', '2025-10-09 09:20:14', 'info@acedecors.in', 'info@acedecors.in', 'Topline Sliding Wardrobes', 85),
(76, 0x41442d57617264726f62652d3030312e6a7067, '2025-10-09 09:28:28', '2025-10-09 09:28:28', 'info@acedecors.in', 'info@acedecors.in', 'Minimalist Wardrobes', 86),
(77, 0x545620556e69742e6a7067, '2025-10-09 10:19:04', '2025-10-09 10:19:04', '', '', 'The Aura Ensemble â€“ Modern Wall TV Unit', 87);

-- --------------------------------------------------------

--
-- Table structure for table `postkeywords`
--

DROP TABLE IF EXISTS `postkeywords`;
CREATE TABLE IF NOT EXISTS `postkeywords` (
  `keywordId` int NOT NULL AUTO_INCREMENT,
  `keyword` varchar(200) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdBy` varchar(100) NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`keywordId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `postsubcatmapping`
--

DROP TABLE IF EXISTS `postsubcatmapping`;
CREATE TABLE IF NOT EXISTS `postsubcatmapping` (
  `postId` int NOT NULL,
  `subCatId` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `postsubcatmapping`
--

INSERT INTO `postsubcatmapping` (`postId`, `subCatId`) VALUES
(87, 84),
(86, 86),
(88, 87),
(85, 85);

-- --------------------------------------------------------

--
-- Table structure for table `privacypolicy`
--

DROP TABLE IF EXISTS `privacypolicy`;
CREATE TABLE IF NOT EXISTS `privacypolicy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `privacypolicy`
--

INSERT INTO `privacypolicy` (`id`, `description`) VALUES
(1, '<p> lorem ipsum lorem lorem ipsum  ipsum  lorem ipsum  lorem ipsum  lorem ipsum  lorem ipsum \n<br />\n</p>'),
(4, '<p>\n<br />\n</p>'),
(5, '<p>vgfhfhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhgvbb\n<br />\n</p>'),
(6, '<p>lorem ipsum\n<br />\n \n<br />\n</p>'),
(7, '<p>Welcome \n<br />\n</p>'),
(8, '<p>Welcome to Acedecor\n<br />\n</p>'),
(9, '<p>At <strong>Ace Decors</strong>, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our Website www.acedecors.co.in or interact with our services.\n\n</p>\n<h2>1. Information We Collect</h2>\n<p>We may collect the following types of information when you use our Website or services:\n<br />\n</p>\n<ul>\n<li><strong>Personal Information</strong>: Name, email address, phone number, address, or other details you provide through forms, inquiries, or contracts.</li>\n<li><strong>Non-Personal Information</strong>: Browser type, device information, IP address, and browsing behavior (collected automatically).</li>\n<li><strong>Transactional Information</strong>: Payment details, billing address, and records of services availed (if applicable).</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. How We Use Your Information</h2>\n<p>We use the information collected to:\n<br />\n</p>\n<ul>\n<li>Respond to inquiries and provide requested services.</li>\n<li>Share quotations, proposals, and agreements.</li>\n<li>Improve our Website, services, and customer experience.</li>\n<li>Send updates, promotions, or newsletters (only if you opt-in).</li>\n<li>Comply with legal or regulatory requirements.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Cookies &amp; Tracking Technologies</h2>\n<ul>\n<li>Our Website may use cookies or similar technologies to enhance user experience, analyze traffic, and understand usage patterns.</li>\n<li>You may disable cookies through your browser settings, but some features of the Website may not function properly.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Data Sharing &amp; Disclosure</h2>\n<p>We do <strong>not</strong> sell or rent your personal information. However, we may share data with:\n<br />\n</p>\n<ul>\n<li><strong>Trusted service providers</strong> (IT support, payment gateways, marketing tools) who help us operate the Website and services.</li>\n<li><strong>Legal authorities</strong>, if required by law, regulation, or legal process.</li>\n<li><strong>Business transfers</strong>, if Ace Decors undergoes a merger, acquisition, or restructuring.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. Data Security</h2>\n<ul>\n<li>We implement reasonable security measures to protect your information from unauthorized access, alteration, disclosure, or destruction.</li>\n<li>However, no method of online transmission or storage is 100% secure. We cannot guarantee absolute security.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Your Rights</h2>\n<p>Depending on applicable laws, you may have rights to:\n<br />\n</p>\n<ul>\n<li>Access, correct, or update your personal information.</li>\n<li>Request deletion of your data.</li>\n<li>Opt out of receiving marketing communications.</li>\n<li>Restrict or object to certain processing of your data.</li>\n</ul>\n<p>To exercise these rights, contact us at the details provided below.\n\n</p>\n<h2>7. Third-Party Links</h2>\n<p>Our Website may contain links to external websites. Ace Decors is not responsible for the privacy practices or content of such third-party sites.\n\n</p>\n<h2>8. Childrenâ€™s Privacy</h2>\n<p>Our Website and services are not directed to individuals under 18 years of age. We do not knowingly collect information from minors.\n\n</p>\n<h2>9. Changes to this Policy</h2>\n<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised date.\n\n</p>\n<h2>10. Contact Us</h2>\n<p>If you have questions or concerns about this Privacy Policy, please contact us.\n\n</p>\n<p></p>'),
(10, '<p>At <strong>Ace Decors</strong>, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our Website www.acedecors.co.in or interact with our services.\n<br />\n</p>\n<h2>1. Information We Collect</h2>\n<p>We may collect the following types of information when you use our Website or services: \n<br />\n</p>\n<ul>\n<li><strong>Personal Information</strong>: Name, email address, phone number, address, or other details you provide through forms, inquiries, or contracts.</li>\n<li><strong>Non-Personal Information</strong>: Browser type, device information, IP address, and browsing behavior (collected automatically).</li>\n<li><strong>Transactional Information</strong>: Payment details, billing address, and records of services availed (if applicable).</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. How We Use Your Information</h2>\n<p>We use the information collected to: \n<br />\n</p>\n<ul>\n<li>Respond to inquiries and provide requested services.</li>\n<li>Share quotations, proposals, and agreements.</li>\n<li>Improve our Website, services, and customer experience.</li>\n<li>Send updates, promotions, or newsletters (only if you opt-in).</li>\n<li>Comply with legal or regulatory requirements.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Cookies &amp; Tracking Technologies</h2>\n<ul>\n<li>Our Website may use cookies or similar technologies to enhance user experience, analyze traffic, and understand usage patterns.</li>\n<li>You may disable cookies through your browser settings, but some features of the Website may not function properly.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Data Sharing &amp; Disclosure</h2>\n<p>We do <strong>not</strong> sell or rent your personal information. However, we may share data with: \n<br />\n</p>\n<ul>\n<li><strong>Trusted service providers</strong> (IT support, payment gateways, marketing tools) who help us operate the Website and services.</li>\n<li><strong>Legal authorities</strong>, if required by law, regulation, or legal process.</li>\n<li><strong>Business transfers</strong>, if Ace Decors undergoes a merger, acquisition, or restructuring.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. Data Security</h2>\n<ul>\n<li>We implement reasonable security measures to protect your information from unauthorized access, alteration, disclosure, or destruction.</li>\n<li>However, no method of online transmission or storage is 100% secure. We cannot guarantee absolute security.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Your Rights</h2>\n<p>Depending on applicable laws, you may have rights to: \n<br />\n</p>\n<ul>\n<li>Access, correct, or update your personal information.</li>\n<li>Request deletion of your data.</li>\n<li>Opt out of receiving marketing communications.</li>\n<li>Restrict or object to certain processing of your data.</li>\n</ul>\n<p>To exercise these rights, contact us at the details provided below.\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<p>Our Website may contain links to external websites. Ace Decors is not responsible for the privacy practices or content of such third-party sites.\n<br />\n</p>\n<h2>8. Childrenâ€™s Privacy</h2>\n<p>Our Website and services are not directed to individuals under 18 years of age. We do not knowingly collect information from minors.\n<br />\n</p>\n<h2>9. Changes to this Policy</h2>\n<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised date.\n<br />\n</p>\n<h2>10. Contact Us</h2>\n<p>If you have questions or concerns about this Privacy Policy, please contact us.\n\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n</li>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.\n</li>\n<h2>14. Contact Us</h2>\n<p>For questions regarding these Terms &amp; Conditions, please contact us.\n\n<br />\n</p>'),
(11, '<p>At <strong>Ace Decors</strong>, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our Website www.acedecors.co.in or interact with our services. \n<br />\n</p>\n<h2>1. Information We Collect</h2>\n<p>We may collect the following types of information when you use our Website or services: \n<br />\n</p>\n<ul>\n<li><strong>Personal Information</strong>: Name, email address, phone number, address, or other details you provide through forms, inquiries, or contracts.</li>\n<li><strong>Non-Personal Information</strong>: Browser type, device information, IP address, and browsing behavior (collected automatically).</li>\n<li><strong>Transactional Information</strong>: Payment details, billing address, and records of services availed (if applicable).</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. How We Use Your Information</h2>\n<p>We use the information collected to: \n<br />\n</p>\n<ul>\n<li>Respond to inquiries and provide requested services.</li>\n<li>Share quotations, proposals, and agreements.</li>\n<li>Improve our Website, services, and customer experience.</li>\n<li>Send updates, promotions, or newsletters (only if you opt-in).</li>\n<li>Comply with legal or regulatory requirements.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Cookies &amp; Tracking Technologies</h2>\n<ul>\n<li>Our Website may use cookies or similar technologies to enhance user experience, analyze traffic, and understand usage patterns.</li>\n<li>You may disable cookies through your browser settings, but some features of the Website may not function properly.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Data Sharing &amp; Disclosure</h2>\n<p>We do <strong>not</strong> sell or rent your personal information. However, we may share data with: \n<br />\n</p>\n<ul>\n<li><strong>Trusted service providers</strong> (IT support, payment gateways, marketing tools) who help us operate the Website and services.</li>\n<li><strong>Legal authorities</strong>, if required by law, regulation, or legal process.</li>\n<li><strong>Business transfers</strong>, if Ace Decors undergoes a merger, acquisition, or restructuring.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. Data Security</h2>\n<ul>\n<li>We implement reasonable security measures to protect your information from unauthorized access, alteration, disclosure, or destruction.</li>\n<li>However, no method of online transmission or storage is 100% secure. We cannot guarantee absolute security.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Your Rights</h2>\n<p>Depending on applicable laws, you may have rights to: \n<br />\n</p>\n<ul>\n<li>Access, correct, or update your personal information.</li>\n<li>Request deletion of your data.</li>\n<li>Opt out of receiving marketing communications.</li>\n<li>Restrict or object to certain processing of your data.</li>\n</ul>\n<p>To exercise these rights, contact us at the details provided below. \n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<p>Our Website may contain links to external websites. Ace Decors is not responsible for the privacy practices or content of such third-party sites. \n<br />\n</p>\n<h2>8. Childrenâ€™s Privacy</h2>\n<p>Our Website and services are not directed to individuals under 18 years of age. We do not knowingly collect information from minors. \n<br />\n</p>\n<h2>9. Changes to this Policy</h2>\n<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised date. \n<br />\n</p>\n<h2>10. Contact Us</h2>\n<p>If you have questions or concerns about this Privacy Policy, please contact us.\n<br />\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<p>\n<br />\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad</li>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.</li>\n<h2>14. Contact Us</h2>\n<ul>\n<li>For questions regarding these Terms &amp; Conditions, please contact us. </li>'),
(12, '<p>At <strong>Ace Decors</strong>, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our Website www.acedecors.co.in or interact with our services. \n\n</p>\n<h2>1. Information We Collect</h2>\n<p>			We may collect the following types of information when you use our Website or services: \n<br />\n<strong>Personal Information</strong>: Name, email address, phone number, address, or other details you provide through forms, inquiries, or contracts.\n<strong>Non-Personal Information</strong>: Browser type, device information, IP address, and browsing behavior (collected automatically).\n<strong>Transactional Information</strong>: Payment details, billing address, and records of services availed (if applicable).\n\n<br />\n</p>\n<h2>2. How We Use Your Information</h2>\n<p>			We use the information collected to: \n<br />\nRespond to inquiries and provide requested services.\nShare quotations, proposals, and agreements.\nImprove our Website, services, and customer experience.\nSend updates, promotions, or newsletters (only if you opt-in).\nComply with legal or regulatory requirements.\n\n<br />\n</p>\n<h2>3. Cookies &amp; Tracking Technologies</h2>\n<p>			Our Website may use cookies or similar technologies to enhance user experience, analyze traffic, and understand usage patterns.\n<br />\n			You may disable cookies through your browser settings, but some features of the Website may not function properly.\n\n</p>\n<h2>4. Data Sharing &amp; Disclosure</h2>\n<p>			We do <strong>not</strong> sell or rent your personal information. However, we may share data with: \n<br />\n<strong>Trusted service providers</strong> (IT support, payment gateways, marketing tools) who help us operate the Website and services.\n<strong>Legal authorities</strong>, if required by law, regulation, or legal process.\n<strong>Business transfers</strong>, if Ace Decors undergoes a merger, acquisition, or restructuring.\n\n<br />\n</p>\n<h2>5. Data Security</h2>\n<p>			We implement reasonable security measures to protect your information from unauthorized access, alteration, disclosure, or destruction.\n<br />\n			However, no method of online transmission or storage is 100% secure. We cannot guarantee absolute security.\n\n</p>\n<h2>6. Your Rights</h2>\n<p>			Depending on applicable laws, you may have rights to: \n<br />\nAccess, correct, or update your personal information.\nRequest deletion of your data.\nOpt out of receiving marketing communications.\nRestrict or object to certain processing of your data.\n			To exercise these rights, contact us at the details provided below. \n\n</p>\n<h2>7. Third-Party Links</h2>\n<p>			Our Website may contain links to external websites. Ace Decors is not responsible for the privacy practices or content of such third-party sites. \n\n</p>\n<h2>8. Childrenâ€™s Privacy</h2>\n<p>			Our Website and services are not directed to individuals under 18 years of age. We do not knowingly collect information from minors. \n\n</p>\n<h2>9. Changes to this Policy</h2>\n<p>			We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised date. \n\n</p>\n<h2>10. Contact Us</h2>\n<p>			If you have questions or concerns about this Privacy Policy, please contact us. \n\n</p>\n<h2>11. Privacy</h2>\n<p>			Your use of this Website is also governed by our <strong>Privacy Policy</strong>.\n<br />\n			By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.\n\n</p>\n<h2>12. Termination</h2>\n<p>			We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.\n\n</p>\n<h2>13. Governing Law &amp; Jurisdiction</h2>\n<p>			These Terms are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad\n<br />\n</p>\n<h2></h2>\n<h2>14. Amendments</h2>\n<p>			Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.\n\n</p>\n<h2>15. Contact Us</h2>\n<p>			For questions regarding these Terms &amp; Conditions, please contact us.\n\n</p>\n<h2></h2>\n<p>\n<br />\n</p>\n<h2></h2>');

-- --------------------------------------------------------

--
-- Table structure for table `processing`
--

DROP TABLE IF EXISTS `processing`;
CREATE TABLE IF NOT EXISTS `processing` (
  `ProcessingId` int NOT NULL AUTO_INCREMENT,
  `Processing` varchar(50) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `ModifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`ProcessingId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `processing`
--

INSERT INTO `processing` (`ProcessingId`, `Processing`, `CreatedBy`, `ModifiedBy`) VALUES
(1, '2 Stage', 'info@acedecors.in', 'info@acedecors.in'),
(2, '3 Stage', 'info@acedecors.in', 'info@acedecors.in'),
(3, '4 Stage', 'info@acedecors.in', 'info@acedecors.in'),
(4, 'None', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Length` int NOT NULL,
  `Width` int NOT NULL,
  `Quantity` int NOT NULL,
  `CL_ID` int NOT NULL,
  `CategoryId` int NOT NULL,
  `SubcategoryId` int NOT NULL,
  `FinishId` int NOT NULL,
  `Code` varchar(100) NOT NULL,
  `CabinetType` varchar(100) NOT NULL,
  `Mat_Brand` int NOT NULL,
  `Rotation` int NOT NULL,
  `Mat_Category` int NOT NULL,
  `Mat_Subcategory` int NOT NULL,
  `Thickness` int NOT NULL,
  `Material` int NOT NULL,
  `PEB` varchar(50) NOT NULL,
  `PEB_Thickness` varchar(50) NOT NULL,
  `SEB` varchar(50) NOT NULL,
  `SEB_Thickness` varchar(50) NOT NULL,
  `Comments` varchar(100) NOT NULL,
  `product_createdby` varchar(100) NOT NULL,
  `product_modifiedby` varchar(100) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `product_catid` int NOT NULL AUTO_INCREMENT,
  `product_catName` varchar(200) NOT NULL,
  `product_catDescription` varchar(200) NOT NULL,
  `product_catCreatedby` varchar(200) NOT NULL,
  `product_catModifiedby` varchar(200) NOT NULL,
  `product_catCreatedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_catmodifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_catid`, `product_catName`, `product_catDescription`, `product_catCreatedby`, `product_catModifiedby`, `product_catCreatedon`, `product_catmodifiedon`) VALUES
(1, 'IC', 'IC', 'info@acedecors.in', 'info@acedecors.in', '2022-02-11 00:33:21', '2025-09-06 11:45:39'),
(2, 'Table', 'tables', 'info@acedecors.in', 'info@acedecors.in', '2025-10-27 12:53:19', '2025-10-27 12:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_definition`
--

DROP TABLE IF EXISTS `product_definition`;
CREATE TABLE IF NOT EXISTS `product_definition` (
  `prodDefinition_Id` int NOT NULL AUTO_INCREMENT,
  `Prod_Name` varchar(100) NOT NULL,
  `Prod_Description` varchar(100) NOT NULL,
  `Rotation` int NOT NULL,
  `Override` varchar(10) NOT NULL,
  `Type` int NOT NULL,
  `Finish` int NOT NULL,
  `Prod_Category` int NOT NULL,
  `Prod_SubCategory` int NOT NULL,
  `Quantity` int NOT NULL,
  `LengthValue` int NOT NULL,
  `Dimension1` varchar(50) NOT NULL,
  `WidthValue` int NOT NULL,
  `Dimension2` varchar(50) NOT NULL,
  `DepthValue` int NOT NULL,
  `Dimension3` varchar(50) NOT NULL,
  `CLFormula` varchar(50) NOT NULL,
  `CW` varchar(50) NOT NULL,
  `GL` int NOT NULL,
  `FL` varchar(50) NOT NULL,
  `BL` varchar(50) NOT NULL,
  `RL` varchar(50) NOT NULL,
  `RW` varchar(50) NOT NULL,
  `EB_LW` int NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`prodDefinition_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_definition`
--

INSERT INTO `product_definition` (`prodDefinition_Id`, `Prod_Name`, `Prod_Description`, `Rotation`, `Override`, `Type`, `Finish`, `Prod_Category`, `Prod_SubCategory`, `Quantity`, `LengthValue`, `Dimension1`, `WidthValue`, `Dimension2`, `DepthValue`, `Dimension3`, `CLFormula`, `CW`, `GL`, `FL`, `BL`, `RL`, `RW`, `EB_LW`, `CreatedBy`, `ModifiedBy`) VALUES
(2, 'qwerty', 'qwerty', 1, '1', 5, 2, 1, 1, 20, 1, 'Length', 2, 'Width', 3, 'Depth', '1*Length-2*Width-3*Depth', '1*Length-2*Width-3*Depth', 1, 'PEB Thickness', 'SEB Thickness', 'SEB Thickness', 'PEB Thickness', 3, 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategory`
--

DROP TABLE IF EXISTS `product_subcategory`;
CREATE TABLE IF NOT EXISTS `product_subcategory` (
  `product_subcatid` int NOT NULL AUTO_INCREMENT,
  `product_catid` int DEFAULT NULL,
  `product_subcatName` varchar(200) NOT NULL,
  `product_subcatDescription` varchar(200) NOT NULL,
  `product_subcatCreatedby` varchar(100) NOT NULL,
  `product_subcatModifiedby` varchar(100) NOT NULL,
  `product_subcatCreatedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_subcatModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_subcatid`),
  KEY `product_catid` (`product_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`product_subcatid`, `product_catid`, `product_subcatName`, `product_subcatDescription`, `product_subcatCreatedby`, `product_subcatModifiedby`, `product_subcatCreatedon`, `product_subcatModifiedon`) VALUES
(1, 1, 'BU', 'BU', 'info@acedecors.in', 'info@acedecors.in', '2022-02-11 00:34:20', '2025-09-06 11:45:39'),
(2, 2, 'Sitting Tables', 'Sitting Tables', 'info@acedecors.in', 'info@acedecors.in', '2025-10-27 12:53:47', '2025-10-27 12:53:47');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `projectId` int NOT NULL AUTO_INCREMENT,
  `projectCode` varchar(100) NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `custId` varchar(50) NOT NULL,
  `quoteId` varchar(50) NOT NULL,
  `project_status` varchar(50) NOT NULL DEFAULT 'In Progress',
  `progressNote` varchar(100) DEFAULT NULL,
  `createdOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`projectId`),
  KEY `quoteId` (`quoteId`),
  KEY `custId` (`custId`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectId`, `projectCode`, `customerName`, `custId`, `quoteId`, `project_status`, `progressNote`, `createdOn`) VALUES
(74, 'AD-PROJ-0226 -M74', 'Moin8', 'AD-202602-M26', 'M26-TU-01', 'In Progress', NULL, '2026-02-26 11:32:06'),
(75, 'AD-PROJ-0226 -M75', 'Mustafa1', 'AD-202602-M28', 'M28-SW-01', 'In Progress', '', '2026-03-09 13:08:18');

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `projecttasks`
--

DROP TABLE IF EXISTS `projecttasks`;
CREATE TABLE IF NOT EXISTS `projecttasks` (
  `TaskId` int NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `TaskDescription` varchar(100) NOT NULL,
  `ContactPerson` varchar(100) NOT NULL,
  `ContactNo` int NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Task_modifiedBy` varchar(100) NOT NULL,
  `Task_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Task_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Task_createdBy` varchar(100) NOT NULL,
  PRIMARY KEY (`TaskId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_issues`
--

DROP TABLE IF EXISTS `project_issues`;
CREATE TABLE IF NOT EXISTS `project_issues` (
  `IssueId` int NOT NULL AUTO_INCREMENT,
  `Issue_ProjectId` int NOT NULL,
  `Issue_ProjCode` varchar(50) NOT NULL,
  `Issue_Description` varchar(100) NOT NULL,
  `Issue_ContactName` varchar(50) NOT NULL,
  `Issue_ContactDetails` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Open',
  `Issue_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Issue_createdby` varchar(100) NOT NULL,
  `Issue_modifiedby` varchar(50) NOT NULL,
  `issue_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IssueId`),
  KEY `followup_ProjCode` (`Issue_ProjCode`),
  KEY `followup_ProjectId` (`Issue_ProjectId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_issues`
--

INSERT INTO `project_issues` (`IssueId`, `Issue_ProjectId`, `Issue_ProjCode`, `Issue_Description`, `Issue_ContactName`, `Issue_ContactDetails`, `Status`, `Issue_createdon`, `Issue_createdby`, `Issue_modifiedby`, `issue_modifiedOn`) VALUES
(3, 68, 'AD-PROJ-0226', 'material delayed', 'chandrakanth', '9999999999', 'Open', '2026-02-25 06:23:34', 'info@acedecors.in', 'info@acedecors.in', '2026-02-25 06:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_lineitem`
--

DROP TABLE IF EXISTS `purchaseorder_lineitem`;
CREATE TABLE IF NOT EXISTS `purchaseorder_lineitem` (
  `POlineitemId` int NOT NULL AUTO_INCREMENT,
  `POID` varchar(100) DEFAULT NULL,
  `Item_id` int DEFAULT NULL,
  `InputName` varchar(50) NOT NULL,
  `SupplierId` int NOT NULL,
  `Quantity` varchar(20) DEFAULT NULL,
  `Price` varchar(20) DEFAULT NULL,
  `TotalAmt` varchar(20) NOT NULL DEFAULT '0',
  `GST` varchar(50) NOT NULL,
  `Modified_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`POlineitemId`),
  KEY `Item_id` (`Item_id`),
  KEY `POID` (`POID`),
  KEY `SupplierId` (`SupplierId`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder_lineitem`
--

INSERT INTO `purchaseorder_lineitem` (`POlineitemId`, `POID`, `Item_id`, `InputName`, `SupplierId`, `Quantity`, `Price`, `TotalAmt`, `GST`, `Modified_Date`) VALUES
(136, '121', 183, 'Sinks', 15, '10', '', '0', '', '2026-02-27 11:06:47'),
(135, '120', 125, 'TV Units', 15, '10', '', '0', '', '2026-02-26 15:29:23'),
(134, '119', 182, 'Caoch', 15, '10', '', '0', '', '2026-02-26 15:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
CREATE TABLE IF NOT EXISTS `purchase_order` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `POcode` varchar(20) NOT NULL,
  `SupplierId` int DEFAULT NULL,
  `Item_id` int NOT NULL,
  `InventoryType` enum('item','material') NOT NULL,
  `ProjectId` varchar(11) DEFAULT NULL,
  `PurchasedDate` date NOT NULL,
  `TotalAmt` int DEFAULT NULL,
  `purchasePDFName` varchar(100) DEFAULT NULL,
  `Status` int DEFAULT '0',
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `SupplierId` (`SupplierId`),
  KEY `Item_id` (`Item_id`),
  KEY `ProjectId` (`ProjectId`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`Id`, `POcode`, `SupplierId`, `Item_id`, `InventoryType`, `ProjectId`, `PurchasedDate`, `TotalAmt`, `purchasePDFName`, `Status`, `createdon`, `Modified_date`) VALUES
(121, 'AD-202602-M121', 15, 183, 'item', '', '2026-02-27', NULL, NULL, 0, '2026-02-27 11:06:47', '2026-02-27 11:06:47'),
(120, 'AD-202602-M120', 15, 125, 'material', '', '2026-02-26', NULL, NULL, 0, '2026-02-26 15:29:23', '2026-02-26 15:29:23'),
(119, 'AD-202602-M119', 15, 182, 'item', '', '2026-02-26', NULL, NULL, 0, '2026-02-26 15:27:33', '2026-02-26 15:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

DROP TABLE IF EXISTS `quotation_details`;
CREATE TABLE IF NOT EXISTS `quotation_details` (
  `quoteId` int NOT NULL AUTO_INCREMENT,
  `quo_enq_id` int NOT NULL,
  `enqCatId` int NOT NULL,
  `customerId` int NOT NULL,
  `quoteCode` varchar(100) NOT NULL,
  `quoteValue` decimal(10,2) DEFAULT NULL,
  `unitId` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `quoteDescription` varchar(500) DEFAULT NULL,
  `itemListName` varchar(200) DEFAULT NULL,
  `orderListName` varchar(200) DEFAULT NULL,
  `quo_type` enum('General','Bank') NOT NULL,
  `quo_pdf_name` varchar(100) DEFAULT NULL,
  `inputType` int NOT NULL,
  `quo_createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `quo_status` enum('pending','rejected','Approved') NOT NULL DEFAULT 'pending',
  `quo_comments` varchar(500) DEFAULT NULL,
  `quo_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`quoteId`),
  KEY `quo_enq_id` (`quo_enq_id`),
  KEY `customerId` (`customerId`),
  KEY `enqCatId` (`enqCatId`),
  KEY `unitId` (`unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=265 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`quoteId`, `quo_enq_id`, `enqCatId`, `customerId`, `quoteCode`, `quoteValue`, `unitId`, `quantity`, `quoteDescription`, `itemListName`, `orderListName`, `quo_type`, `quo_pdf_name`, `inputType`, `quo_createdby`, `modifiedby`, `modifiedon`, `quo_status`, `quo_comments`, `quo_createdon`) VALUES
(263, 83, 23, 26, 'M26-TU-01', 10000.00, 60, 5, 'hfgghgh', '', '', '', '', 1, 'info@acedecors.in', 'info@acedecors.in', '2026-02-27 14:42:29', 'pending', 'ghfhfg', '2026-02-27 14:42:29'),
(264, 85, 24, 28, 'M28-SW-01', 1200.00, 61, 5, 'asdsad', '', '', '', '', 2, 'info@acedecors.in', 'info@acedecors.in', '2026-02-27 14:42:54', 'Approved', 'dfsdfsdf', '2026-02-27 14:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `quotelineitem`
--

DROP TABLE IF EXISTS `quotelineitem`;
CREATE TABLE IF NOT EXISTS `quotelineitem` (
  `lineItemId` int NOT NULL AUTO_INCREMENT,
  `quoteId` int NOT NULL,
  `itemId` int NOT NULL,
  `inputType` int NOT NULL,
  `InputName` varchar(255) NOT NULL,
  `item_catid` int NOT NULL,
  `item_subcatid` int NOT NULL,
  `quantity` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  `totalValue` decimal(10,0) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `discount1` decimal(10,2) DEFAULT NULL,
  `discount1Amt` decimal(10,2) DEFAULT NULL,
  `discount2` decimal(10,2) DEFAULT NULL,
  `discount2Amt` decimal(10,2) DEFAULT NULL,
  `GSTAmount` decimal(10,2) NOT NULL,
  `GST` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `billedAmount` decimal(10,2) DEFAULT NULL,
  `createdby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lineItemId`)
) ENGINE=MyISAM AUTO_INCREMENT=349 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotelineitem`
--

INSERT INTO `quotelineitem` (`lineItemId`, `quoteId`, `itemId`, `inputType`, `InputName`, `item_catid`, `item_subcatid`, `quantity`, `amount`, `value`, `totalValue`, `totalAmount`, `discount1`, `discount1Amt`, `discount2`, `discount2Amt`, `GSTAmount`, `GST`, `totalPrice`, `billedAmount`, `createdby`, `createdon`, `modifiedby`, `modifiedon`) VALUES
(346, 263, 182, 1, 'Caoch', 122, 83, 10, 2360.00, 0, 2360, 2500.00, 10.00, 250.00, NULL, NULL, 405.00, 18.00, 2655.00, NULL, 'info@acedecors.in', '2026-02-26 15:26:54', 'info@acedecors.in', '2026-02-26 15:26:54'),
(347, 263, 125, 2, 'TV Units', 36, 33, 15, 1416.00, 0, 1888, 1500.00, 5.00, 75.00, NULL, NULL, 256.50, 18.00, 1681.50, NULL, 'info@acedecors.in', '2026-02-26 15:26:54', 'info@acedecors.in', '2026-02-26 15:26:54'),
(348, 264, 126, 2, 'Sturde1', 36, 33, 1, 531.00, 0, 5310, 500.00, 10.00, 50.00, NULL, NULL, 81.00, 18.00, 531.00, NULL, 'info@acedecors.in', '2026-02-27 14:39:06', 'info@acedecors.in', '2026-02-27 14:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `permission_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Table structure for table `rotation`
--

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE IF NOT EXISTS `rotation` (
  `rotationId` int NOT NULL AUTO_INCREMENT,
  `sides` varchar(100) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` varchar(100) NOT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rotationId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rotation`
--

INSERT INTO `rotation` (`rotationId`, `sides`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'Left', 'info@acedecors.in', '2021-11-23 14:50:40', 'info@acedecors.in', '2025-09-06 11:45:39'),
(2, 'Right', 'info@acedecors.in', '2021-11-23 14:50:52', 'info@acedecors.in', '2025-09-06 11:45:39'),
(3, 'Top', 'info@acedecors.in', '2021-11-23 14:50:56', 'info@acedecors.in', '2025-09-06 11:45:39'),
(5, 'Bottoms', 'info@acedecors.in', '2026-02-28 17:20:43', 'info@acedecors.in', '2026-02-28 17:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `currency` varchar(10) DEFAULT '₹',
  `hours_per_day` decimal(5,2) DEFAULT '8.00',
  `ot_multiplier` decimal(4,2) DEFAULT '1.50',
  `half_day_threshold` decimal(5,2) DEFAULT NULL,
  `weekly_off_paid` tinyint(1) DEFAULT '0',
  `time_presets` text,
  `org_name` varchar(255) DEFAULT '',
  `org_address` text,
  `auto_sync` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `currency`, `hours_per_day`, `ot_multiplier`, `half_day_threshold`, `weekly_off_paid`, `time_presets`, `org_name`, `org_address`, `auto_sync`, `created_at`, `updated_at`) VALUES
(1, '₹', 8.00, 1.00, 4.00, 0, '[{\"desc\":\"2 Days\",\"hours\":\"16\",\"type\":\"preset\"},{\"desc\":\"1.5 Day\",\"hours\":\"12\",\"type\":\"preset\"},{\"desc\":\"Present\",\"hours\":\"8\",\"type\":\"preset\"},{\"desc\":\"Half Day\",\"hours\":\"4\",\"type\":\"preset\"},{\"desc\":\"OT\",\"hours\":\"Present+OT\",\"type\":\"input\"}]', 'Ace Decors', '', 1, '2025-10-09 11:25:26', '2026-01-30 12:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `sliderimages`
--

DROP TABLE IF EXISTS `sliderimages`;
CREATE TABLE IF NOT EXISTS `sliderimages` (
  `imageId` int NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alternatetext` varchar(200) NOT NULL,
  `imageCaption` varchar(500) NOT NULL,
  `modifiedBY` varchar(100) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  `fileType` enum('image','video') DEFAULT 'image',
  `videoUrl` varchar(500) DEFAULT NULL,
  `videoFile` varchar(255) DEFAULT NULL,
  `postId` int DEFAULT NULL,
  PRIMARY KEY (`imageId`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sliderimages`
--

INSERT INTO `sliderimages` (`imageId`, `image`, `createdOn`, `modifiedOn`, `alternatetext`, `imageCaption`, `modifiedBY`, `createdBy`, `fileType`, `videoUrl`, `videoFile`, `postId`) VALUES
(28, 'AD-Kitchen01.jpg', '2025-09-19 21:03:54', '2025-09-19 21:03:54', 'Kitchens', 'Kitchens', 'info@acedecors.in', 'info@acedecors.in', 'image', NULL, NULL, NULL),
(29, 'AD-Wardrobe-001.jpg', '2025-09-19 21:04:24', '2025-09-19 21:04:24', 'Wardrobes', 'Wardrobes', 'info@acedecors.in', 'info@acedecors.in', 'image', NULL, NULL, NULL),
(37, 'AD-Wardrobe-001.jpg', '2025-09-29 06:45:06', '2025-09-29 06:45:06', 'Minimalist Wardrobes', 'Minimalist Wardrobes', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 0),
(32, 'AD-Sliding Wardrobe-001.jpg', '2025-09-27 00:05:07', '2025-09-27 00:05:07', 'TopLine Sliding', 'TopLine Sliding', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 60),
(33, '', '2025-09-27 00:05:19', '2025-09-27 00:05:19', 'TopLine Sliding', 'TopLine Sliding', 'info@acedecors.in', 'info@acedecors.in', 'video', 'https://www.youtube.com/embed/dWryPSNXSv0?si=QVp_hxkjwd_-5807', '', 60),
(34, 'post1.jpg', '2025-09-27 06:45:57', '2025-09-27 06:45:57', 'Sofa', 'Sofa', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 67),
(36, 'AD-Sliding Wardrobe-001.jpg', '2025-09-29 06:44:36', '2025-09-29 06:44:36', 'Sliding Wardrobes', 'Sliding Wardrobes', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 0),
(62, '1760032800_DMLS-001.jpg', '2026-03-11 14:44:29', '2026-03-11 14:44:29', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 0),
(39, 'AD-Sliding Wardrobe-001.jpg', '2025-10-03 04:36:14', '2025-10-03 04:36:14', 'Minimalist Wardrobes', 'Minimalist Wardrobes', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 65),
(40, '03-kitchen.jpg', '2025-10-03 04:41:09', '2025-10-03 04:41:09', 'Best-Kitchens', 'Best-Kitchens', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 68),
(41, 'post3.jpg', '2025-10-03 04:43:04', '2025-10-03 04:43:04', 'Best-Doors', 'Best-Doors', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 69),
(42, 'TV Unit.jpg', '2025-10-03 11:31:40', '2025-10-03 11:31:40', 'Modern TV Units', 'Modern TV Units', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 70),
(45, 'TV Unit-1.jpg', '2025-10-03 11:47:20', '2025-10-03 11:47:20', 'Modern TV Units', 'Modern TV Units', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 70),
(46, 'AD-Sliding Wardrobe-001.jpg', '2025-10-03 23:55:13', '2025-10-03 23:55:13', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 60),
(47, 'AD-Sliding Wardrobe-001.jpg', '2025-10-04 03:23:33', '2025-10-04 03:23:33', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 75),
(48, 'AD-Kitchen01.jpg', '2025-10-04 10:30:16', '2025-10-04 10:30:16', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 76),
(49, 'AD-Kitchen01.jpg', '2025-10-04 10:33:37', '2025-10-04 10:33:37', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 76),
(50, 'AD-Sliding Wardrobe-001.jpg', '2025-10-04 22:44:06', '2025-10-04 22:44:06', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 78),
(51, 'AD-Kitchen01.jpg', '2025-10-04 22:58:21', '2025-10-04 22:58:21', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 81),
(52, 'AD-Sliding Wardrobe-001.jpg', '2025-10-07 08:26:31', '2025-10-07 08:26:31', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 82),
(54, 'AD-Sliding Wardrobe-001.jpg', '2025-10-09 09:21:28', '2025-10-09 09:21:28', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 85),
(55, 'AD-Wardrobe-001.jpg', '2025-10-09 09:29:09', '2025-10-09 09:29:09', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 86),
(56, 'TV Unit.jpg', '2025-10-09 10:19:43', '2025-10-09 10:19:43', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 87),
(57, 'TV Unit-1.jpg', '2025-10-09 10:20:18', '2025-10-09 10:20:18', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 87),
(60, 'AD-Kitchen01.jpg', '2025-10-09 10:30:18', '2025-10-09 10:30:18', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 88),
(61, '1000010432.jpg', '2025-10-10 10:44:40', '2025-10-10 10:44:40', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 85);

-- --------------------------------------------------------

--
-- Table structure for table `socialmediahandle`
--

DROP TABLE IF EXISTS `socialmediahandle`;
CREATE TABLE IF NOT EXISTS `socialmediahandle` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `handle` varchar(500) NOT NULL,
  `icon` varchar(2000) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(500) NOT NULL,
  `modifiedBy` varchar(500) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `socialmediahandle`
--

INSERT INTO `socialmediahandle` (`Id`, `name`, `handle`, `icon`, `createdon`, `createdBy`, `modifiedBy`, `modifiedon`) VALUES
(10, 'Facebook', 'https://www.facebook.com/https://www.facebook.com/profile.php?id=61582170084177', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-facebook\" viewBox=\"0 0 16 16\">\n            <path d=\"M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z\"/>\n          </svg>', '2025-10-09 11:31:00', 'info@acedecors.in', 'info@acedecors.in', '2025-10-09 11:31:00'),
(2, 'Twitter', 'https://www.twitter.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-twitter\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z\"/>\r\n</svg>', '2021-12-13 19:43:57', 'info@acedecors.in', 'info@acedecors.in', '2025-09-08 05:24:03'),
(3, 'Instagram', 'https://www.instagram.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-instagram\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z\"/>\r\n</svg>', '2021-12-13 19:45:16', 'info@acedecors.in', 'info@acedecors.in', '2025-09-08 05:24:03'),
(7, 'Pinterest', 'https://www.pinterest.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pinterest\" viewBox=\"0 0 16 16\">\r\n            <path d=\"M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z\"/>\r\n          </svg>', '2021-12-15 17:52:21', 'info@acedecors.in', 'info@acedecors.in', '2025-09-08 05:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `subCategoryId` int NOT NULL AUTO_INCREMENT,
  `subCategoryName` varchar(200) NOT NULL,
  `subCategoryDescription` varchar(500) NOT NULL,
  `subCategoryCreatedBy` varchar(200) NOT NULL,
  `subCategoryCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subCategoryModifiedBy` varchar(200) NOT NULL,
  `subCategoryModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subCategoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subCategoryId`, `subCategoryName`, `subCategoryDescription`, `subCategoryCreatedBy`, `subCategoryCreatedOn`, `subCategoryModifiedBy`, `subCategoryModifiedon`) VALUES
(91, 'Best Kitchens', 'Best Kitchens', 'info@acedecors.in', '2025-10-08 13:56:04', 'info@acedecors.in', '2025-10-08 13:56:04'),
(90, 'Awesome Kitchen', 'Awesome Kitchen', 'info@acedecors.in', '2025-10-08 13:54:30', 'info@acedecors.in', '2025-10-08 13:54:30'),
(71, 'Ultimate Kitchen Designs', 'Ultimate Kitchen Designs', 'info@acedecors.in', '2025-09-23 14:10:16', 'info@acedecors.in', '2025-09-23 14:10:16');

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `suppliercontactdetails`
--

DROP TABLE IF EXISTS `suppliercontactdetails`;
CREATE TABLE IF NOT EXISTS `suppliercontactdetails` (
  `contactId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `supplierId` int NOT NULL,
  `emailId` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`contactId`),
  KEY `supplierId` (`supplierId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliercontactdetails`
--

INSERT INTO `suppliercontactdetails` (`contactId`, `name`, `supplierId`, `emailId`, `designation`, `phone`, `createdby`, `modifiedby`, `modifiedon`, `createdon`) VALUES
(9, 'Shashi', 21, 'shashi@gmail.com', 'Sales', '9999999999', 'info@acedecors.in', 'info@acedecors.in', '2025-09-06 11:45:39', '2021-06-11 22:53:33'),
(6, 'Athar Shaikh', 22, 'atharshaikh1@gmail.com', 'Manager', '8007961759', 'ACE DECORS', 'ACE DECORS', '2025-09-06 11:45:39', '2021-06-11 02:20:26'),
(8, 'Reyaz', 21, 'ajayh@gmail.com', 'ASM', '9888888888', 'info@acedecors.in', 'info@acedecors.in', '2025-09-06 11:45:39', '2021-06-11 22:52:48'),
(10, 'Moin', 14, 'taukeer123@gmail.com', 'hfjf', '9517532486', 'info@acedecors.in', 'info@acedecors.in', '2026-01-21 18:38:48', '2026-01-21 18:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `supplierpaymentinfo`
--

DROP TABLE IF EXISTS `supplierpaymentinfo`;
CREATE TABLE IF NOT EXISTS `supplierpaymentinfo` (
  `supplierpaymentId` int NOT NULL AUTO_INCREMENT,
  `supplierId` int NOT NULL,
  `POID` int NOT NULL,
  `total_amount` int NOT NULL,
  `paid_amount` int NOT NULL,
  `received_amount` int NOT NULL,
  `pending_amount` int NOT NULL,
  `payment_plan` varchar(50) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `RTGS_no` varchar(100) NOT NULL,
  `cheque_img` varchar(100) NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_description` varchar(200) NOT NULL,
  `paymentPDFName` varchar(100) DEFAULT NULL,
  `modifieddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(25) NOT NULL,
  PRIMARY KEY (`supplierpaymentId`),
  KEY `supplierId` (`supplierId`),
  KEY `POID` (`POID`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierpaymentinfo`
--

INSERT INTO `supplierpaymentinfo` (`supplierpaymentId`, `supplierId`, `POID`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `paymentPDFName`, `modifieddate`, `modified_by`) VALUES
(126, 15, 121, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-27 11:06:47', ''),
(125, 15, 120, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-26 15:29:23', ''),
(124, 15, 119, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-26 15:27:33', ''),
(123, 15, 118, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-26 13:42:29', ''),
(122, 14, 117, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-26 13:38:41', ''),
(121, 15, 116, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-26 11:56:13', ''),
(120, 15, 115, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-02-26 11:55:56', '');

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `supplier_brand_mapping`
--

DROP TABLE IF EXISTS `supplier_brand_mapping`;
CREATE TABLE IF NOT EXISTS `supplier_brand_mapping` (
  `supplierId` int NOT NULL,
  `brandId` int NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`supplierId`,`brandId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_brand_mapping`
--

INSERT INTO `supplier_brand_mapping` (`supplierId`, `brandId`, `createdby`, `modifiedby`, `createdon`, `modifiedon`) VALUES
(20, 9, '', '', '2021-06-05 00:16:06', '2025-09-06 11:45:39'),
(22, 13, '', '', '2021-11-06 15:15:35', '2025-09-06 11:45:39'),
(21, 8, '', '', '2021-10-11 12:25:09', '2025-09-06 11:45:39'),
(22, 11, '', '', '2021-11-06 15:15:35', '2025-09-06 11:45:39'),
(2, 264, '', '', '2025-12-18 16:50:47', '2025-12-18 16:50:47'),
(1, 263, '', '', '2025-12-18 16:52:00', '2025-12-18 16:52:00'),
(4, 263, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 11:49:08', '2026-01-20 11:49:08'),
(4, 262, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 11:49:08', '2026-01-20 11:49:08'),
(5, 263, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 11:52:32', '2026-01-20 11:52:32'),
(5, 262, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 11:52:32', '2026-01-20 11:52:32'),
(6, 263, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 11:53:49', '2026-01-20 11:53:49'),
(6, 262, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 11:53:49', '2026-01-20 11:53:49'),
(7, 262, '', '', '2026-01-20 12:37:35', '2026-01-20 12:37:35'),
(7, 263, '', '', '2026-01-20 12:37:35', '2026-01-20 12:37:35'),
(8, 262, '', '', '2026-01-20 12:38:57', '2026-01-20 12:38:57'),
(8, 263, '', '', '2026-01-20 12:38:57', '2026-01-20 12:38:57'),
(9, 262, '', '', '2026-01-20 13:08:41', '2026-01-20 13:08:41'),
(9, 263, '', '', '2026-01-20 13:08:41', '2026-01-20 13:08:41'),
(13, 263, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 13:33:36', '2026-01-20 13:33:36'),
(13, 262, 'info@acedecors.in', 'info@acedecors.in', '2026-01-20 13:33:36', '2026-01-20 13:33:36'),
(14, 263, 'info@acedecors.in', 'info@acedecors.in', '2026-01-22 20:10:38', '2026-01-22 20:10:38'),
(15, 264, 'info@acedecors.in', 'info@acedecors.in', '2026-01-22 17:25:08', '2026-01-22 17:25:08'),
(15, 263, 'info@acedecors.in', 'info@acedecors.in', '2026-01-22 17:25:08', '2026-01-22 17:25:08'),
(15, 262, 'info@acedecors.in', 'info@acedecors.in', '2026-01-22 17:25:08', '2026-01-22 17:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `tax_table`
--

DROP TABLE IF EXISTS `tax_table`;
CREATE TABLE IF NOT EXISTS `tax_table` (
  `tax_id` int NOT NULL AUTO_INCREMENT,
  `GST` decimal(4,2) NOT NULL,
  `SGST` decimal(4,2) DEFAULT NULL,
  `CGST` decimal(4,2) DEFAULT NULL,
  `IGST` decimal(4,2) DEFAULT NULL,
  `Modified_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_By` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `Modified_By` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tax_table`
--

INSERT INTO `tax_table` (`tax_id`, `GST`, `SGST`, `CGST`, `IGST`, `Modified_Date`, `Created_Date`, `Created_By`, `Modified_By`) VALUES
(51, 12.00, 6.00, 18.00, NULL, '2026-02-28 16:49:54', '2026-02-28 16:49:54', 'info@acedecors.in', 'info@acedecors.in'),
(52, 18.00, NULL, NULL, 18.00, '2026-02-28 16:49:43', '2026-02-28 16:49:43', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `termsandconditions`
--

DROP TABLE IF EXISTS `termsandconditions`;
CREATE TABLE IF NOT EXISTS `termsandconditions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `termsandconditions`
--

INSERT INTO `termsandconditions` (`id`, `description`) VALUES
(1, '<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum\n\n</p>\n<p></p>'),
(26, '<p>Welcome\n<br />\n</p>'),
(27, '<p>Welcome to Acedecor\n<br />\n</p>'),
(28, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website.\n\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree:\n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation of these Terms or misuse of the Website.\n\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy.</strong></li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<p>\n<br />\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>.</li>\n<li>Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice.</li>\n<li>Continued use of the Website after changes constitutes your acceptance of the updated Terms.</li>\n</ul>\n<p>\n<br />\n</p>'),
(29, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website.\n<br />\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation of these Terms or misuse of the Website.\n<br />\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy.</strong></li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>.\nAny disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n</li>\n<h2>13. Amendments</h2>\n<p>Ace Decors may update or modify these Terms at any time without prior notice.\nContinued use of the Website after changes constitutes your acceptance of the updated Terms.\n\n<br />\n</p>\n<h2>14. Contact Us</h2>\n<p>For questions regarding these Terms &amp; Conditions, please contact us.\n<br />\n</p>'),
(30, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website.\n\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree:\n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation of these Terms or misuse of the Website.\n\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<p>\n<br />\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>.</li>\n<li>Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice.</li>\n<li>Continued use of the Website after changes constitutes your acceptance of the updated Terms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>14. Contact Us</h2>\n<ul>\n<li>For questions regarding these Terms &amp; Conditions, please contact us.</li>'),
(31, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website.\n<br />\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation of these Terms or misuse of the Website.\n<br />\n</p>\n<h2></h2>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>.\nAny disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n</li>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice.\nContinued use of the Website after changes constitutes your acceptance of the updated Terms.\n</li>\n<h2>14. Contact Us</h2>\n<p>For questions regarding these Terms &amp; Conditions, please contact us.\n</p>'),
(32, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website. \n<br />\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation of these Terms or misuse of the Website. \n\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<p>\n<br />\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.</li>\n<p>\n<br />\n</p>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.</li>\n<p>\n<br />\n</p>\n<h2>14. Contact Us</h2>\n<ul>\n<li>For questions regarding these Terms &amp; Conditions, please contact us.</li>'),
(33, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website. \n<br />\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation of these Terms or misuse of the Website.\n\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<ul>\n<li>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.</li>\n<p>\n<br />\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<ul>\n<li>These Terms are governed by the laws of <strong>India</strong>. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.</li>\n<p>\n<br />\n</p>\n<h2>13. Amendments</h2>\n<ul>\n<li>Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.</li>\n<p>\n<br />\n</p>\n<h2>14. Contact Us</h2>\n<ul>\n<li>For questions regarding these Terms &amp; Conditions, please contact us.</li>'),
(34, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website. \n<br />\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>          You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation othese Terms or misuse of the Website.\n<br />\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n11. Termination\n<br />\nWe reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.\n\n</p>\n<p>12. Governing Law &amp; Jurisdiction\n<br />\nThese Terms are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n\n</p>\n<p>13. Amendments\n<br />\nAce Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.\n\n</p>\n<p>14. Contact Us\n<br />\n</p>\n<h2>For questions regarding these Terms &amp; Conditions, please contact us.</h2>'),
(35, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website. \n<br />\n</p>\n<h2>1. Introduction</h2>\n<ul>\n<li>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.</li>\n<li>These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>2. Eligibility</h2>\n<ul>\n<li>You must be at least 18 years old to use this Website or avail of our services.</li>\n<li>By using this Website, you represent that you have the legal capacity to enter into binding contracts.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>3. Services</h2>\n<ul>\n<li>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.</li>\n<li>Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.</li>\n<li>We reserve the right to refuse service to anyone at any time without notice.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>4. Intellectual Property</h2>\n<ul>\n<li>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.</li>\n<li>You may not reproduce, distribute, modify, or use any content without our prior written consent.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n</p>\n<ul>\n<li>Not to misuse or interfere with the functionality of the Website.</li>\n<li>Not to upload or transmit any harmful code, spam, or unlawful material.</li>\n<li>To provide accurate and truthful information when submitting inquiries or forms.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<ul>\n<li>Any pricing mentioned on the Website (if applicable) is indicative and subject to change.</li>\n<li>Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.</li>\n<li>Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>7. Third-Party Links</h2>\n<ul>\n<li>The Website may contain links to third-party sites.</li>\n<li>Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>8. Limitation of Liability</h2>\n<ul>\n<li>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.</li>\n<li>We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, or expenses resulting from your violation othese Terms or misuse of the Website. \n<br />\n</p>\n<h2>10. Privacy</h2>\n<ul>\n<li>Your use of this Website is also governed by our <strong>Privacy Policy</strong>.</li>\n<li>By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.</li>\n</ul>\n<p>\n<br />\n</p>\n<h2>11. Termination</h2>\n<p>	We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.\n<br />\n</p>\n<h2></h2>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<p>	These Terms are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n\n</p>\n<h2>13. Amendments</h2>\n<p>   Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms.\n<br />\n \n<br />\n</p>\n<h2>14. Contact Us</h2>\n<p>For questions regarding these Terms &amp; Conditions, please contact us.\n\n</p>\n<p></p>'),
(36, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website. \n<br />\n</p>\n<h2>1. Introduction</h2>\n<p>		Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website.\n<br />\n		These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.\n\n</p>\n<h2>2. Eligibility</h2>\n<p>		You must be at least 18 years old to use this Website or avail of our services.\n<br />\n		By using this Website, you represent that you have the legal capacity to enter into binding contracts.\n\n</p>\n<h2>3. Services</h2>\n<p>		Information, designs, and concepts displayed on the Website are for general guidance and inspiration only.\n<br />\n		Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client.\n<br />\n		We reserve the right to refuse service to anyone at any time without notice.\n\n</p>\n<h2>4. Intellectual Property</h2>\n<p>		All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated.\n<br />\n		You may not reproduce, distribute, modify, or use any content without our prior written consent.\n\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n		Not to misuse or interfere with the functionality of the Website.\n<br />\n		Not to upload or transmit any harmful code, spam, or unlawful material.\n<br />\n		To provide accurate and truthful information when submitting inquiries or forms.\n\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<p>		Any pricing mentioned on the Website (if applicable) is indicative and subject to change.\n<br />\n		Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon.\n<br />\n		Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.\n\n</p>\n<h2>7. Third-Party Links</h2>\n<p>		The Website may contain links to third-party sites.\n<br />\n		Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.\n\n</p>\n<h2>8. Limitation of Liability</h2>\n<p>		While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted.\n<br />\n		We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.\n\n</p>\n<h2>9. Indemnity</h2>\n<p>		You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, \n<br />\n		Or expenses resulting from your violation othese Terms or misuse of the Website.\n\n</p>\n<h2>10. Privacy</h2>\n<p>		Your use of this Website is also governed by our <strong>Privacy Policy</strong>.\n<br />\n		By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.\n\n</p>\n<h2>11. Termination</h2>\n<p>		We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms. \n\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<p>		These Terms are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n\n</p>\n<h2>13. Amendments</h2>\n<p>		Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms. \n<br />\n \n<br />\n</p>\n<h2>14. Contact Us</h2>\n<p>		For questions regarding these Terms &amp; Conditions, please contact us.\n<br />\n</p>'),
(37, '<p>Welcome to <strong>Ace Decors</strong>. By accessing or using our website www.acedecors.co.in, you agree to comply with and be bound by the following Terms &amp; Conditions (â€œTermsâ€). Please read these carefully before using our services. If you do not agree with these Terms, you should not use this Website. \n\n</p>\n<h2>1. Introduction</h2>\n<p>Ace Decors provides interior design consultation, design execution, furniture, and related services through this Website. \n<br />\n These Terms govern the use of our Website and any purchase, inquiry, or communication made through it.\n\n</p>\n<h2>2. Eligibility</h2>\n<p>You must be at least 18 years old to use this Website or avail of our services. \n<br />\n By using this Website, you represent that you have the legal capacity to enter into binding contracts.\n\n</p>\n<h2>3. Services</h2>\n<p>Information, designs, and concepts displayed on the Website are for general guidance and inspiration only. \n<br />\n Final execution, pricing, and timelines will be based on written agreements, quotations, and contracts signed between Ace Decors and the client. \n<br />\n We reserve the right to refuse service to anyone at any time without notice.\n\n</p>\n<h2>4. Intellectual Property</h2>\n<p>All content on this Website, including but not limited to text, images, design concepts, graphics, and logos, are the intellectual property of <strong>Ace Decors</strong> unless otherwise stated. \n<br />\n You may not reproduce, distribute, modify, or use any content without our prior written consent.\n\n</p>\n<h2>5. User Obligations</h2>\n<p>When using our Website, you agree: \n<br />\n Not to misuse or interfere with the functionality of the Website. \n<br />\n Not to upload or transmit any harmful code, spam, or unlawful material. \n<br />\n To provide accurate and truthful information when submitting inquiries or forms.\n\n</p>\n<h2>6. Pricing &amp; Payments</h2>\n<p>Any pricing mentioned on the Website (if applicable) is indicative and subject to change. \n<br />\n Final costs will be provided in a written quotation/contract and are binding only once mutually agreed upon. \n<br />\n Payments must be made as per agreed terms in the contract. Late payments may attract interest charges.\n\n</p>\n<h2>7. Third-Party Links</h2>\n<p>The Website may contain links to third-party sites. \n<br />\n Ace Decors is not responsible for the accuracy, safety, or content of such external websites. Accessing them is at your own risk.\n\n</p>\n<h2>8. Limitation of Liability</h2>\n<p>While we strive to ensure accuracy of information, Ace Decors makes no warranties that the Website or its content will be error-free or uninterrupted. \n<br />\n We are not liable for any direct, indirect, incidental, or consequential damages arising from use of our Website or services.\n\n</p>\n<h2>9. Indemnity</h2>\n<p>You agree to indemnify and hold harmless <strong>Ace Decors</strong>, its directors, employees, and affiliates from any claims, damages, losses, \n<br />\n Or expenses resulting from your violation othese Terms or misuse of the Website.\n\n</p>\n<h2>10. Privacy</h2>\n<p>Your use of this Website is also governed by our <strong>Privacy Policy</strong>. \n<br />\n By using the Website, you consent to the collection and use of your information as outlined in the Privacy Policy.\n\n</p>\n<h2>11. Termination</h2>\n<p>We reserve the right to suspend or terminate access to our Website or services at our discretion, without prior notice, if we believe you have violated these Terms.\n\n</p>\n<h2>12. Governing Law &amp; Jurisdiction</h2>\n<p>These Terms are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Dharwad.\n\n</p>\n<h2>13. Amendments</h2>\n<p>Ace Decors may update or modify these Terms at any time without prior notice. Continued use of the Website after changes constitutes your acceptance of the updated Terms. \n\n</p>\n<h2>14. Contact Us</h2>\n<p>For questions regarding these Terms &amp; Conditions, please contact us. \n<br />\n</p>');

-- --------------------------------------------------------

--
-- Table structure for table `thickness`
--

DROP TABLE IF EXISTS `thickness`;
CREATE TABLE IF NOT EXISTS `thickness` (
  `Thickness_Id` int NOT NULL AUTO_INCREMENT,
  `Thickness` varchar(20) NOT NULL,
  `Thickness_createdby` varchar(20) NOT NULL,
  `Thickness_modifiedby` varchar(20) NOT NULL,
  PRIMARY KEY (`Thickness_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `thickness`
--

INSERT INTO `thickness` (`Thickness_Id`, `Thickness`, `Thickness_createdby`, `Thickness_modifiedby`) VALUES
(2, '6', 'info@acedecors.in', 'info@acedecors.in'),
(4, '15', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `unitId` int NOT NULL AUTO_INCREMENT,
  `unitName` varchar(200) NOT NULL,
  `unitDescription` varchar(500) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unitId`, `unitName`, `unitDescription`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(60, 'U11', 'testfgh', '2025-12-18 13:17:50', 'info@acedecors.in', '2026-02-26 16:22:02', 'info@acedecors.in'),
(61, 'U2', 'fsdsdffghhfgghf', '2026-02-16 10:43:33', 'info@acedecors.in', '2026-02-19 13:27:44', 'info@acedecors.in'),
(62, 'U3', 'sdsdfasl', '2026-02-19 13:28:02', 'info@acedecors.in', '2026-02-19 13:28:02', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `unitsfactor`
--

DROP TABLE IF EXISTS `unitsfactor`;
CREATE TABLE IF NOT EXISTS `unitsfactor` (
  `unitFactorId` int NOT NULL AUTO_INCREMENT,
  `unitId` int NOT NULL,
  `unitFactor` int NOT NULL,
  `unitFactorDescription` varchar(500) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`unitFactorId`),
  KEY `unitId` (`unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unitsfactor`
--

INSERT INTO `unitsfactor` (`unitFactorId`, `unitId`, `unitFactor`, `unitFactorDescription`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(30, 60, 5, 'test', '2025-12-18 13:18:18', 'info@acedecors.in', '2026-02-26 16:22:25', 'info@acedecors.in'),
(31, 61, 10, 'test', '2026-02-16 10:43:50', 'info@acedecors.in', '2026-02-16 10:43:50', 'info@acedecors.in'),
(32, 62, 2, 'testret', '2026-02-19 13:28:21', 'info@acedecors.in', '2026-02-19 13:28:21', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL,
  `user_contact` varchar(15) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_type` enum('Admin','Manager') NOT NULL,
  `user_status` enum('Enable','Disable') NOT NULL,
  `user_created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role_id` int DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_contact`, `user_email`, `user_password`, `user_type`, `user_status`, `user_created_on`, `ModifiedDate`, `role_id`) VALUES
(2, 'info@acedecors.in', '9742367112', 'info@acedecors.in', 'Acedecors@123', 'Admin', 'Enable', '2021-05-01 18:47:39', '2025-09-06 11:45:39', NULL),
(11, 'Moin', '8951199655', 'moinmulla652@gmail.com', 'Xoin@@369', '', 'Enable', '2026-03-03 12:21:12', '2026-03-03 12:21:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_action_permissions`
--

DROP TABLE IF EXISTS `user_action_permissions`;
CREATE TABLE IF NOT EXISTS `user_action_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action_id` int DEFAULT NULL,
  `allowed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=498 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `user_action_permissions`
--

INSERT INTO `user_action_permissions` (`id`, `user_id`, `action_id`, `allowed`) VALUES
(497, 11, 42, 1),
(496, 11, 37, 1),
(495, 11, 34, 1),
(494, 11, 32, 1),
(493, 11, 29, 1),
(492, 11, 26, 1),
(491, 11, 24, 1),
(490, 11, 19, 1),
(489, 11, 16, 1),
(488, 11, 13, 1),
(487, 11, 10, 1),
(486, 11, 9, 1),
(485, 11, 4, 1),
(484, 11, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `permission_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `can_read` tinyint(1) DEFAULT '0',
  `can_write` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`permission_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
