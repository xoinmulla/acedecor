-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 30, 2026 at 02:06 AM
-- Server version: 10.11.18-MariaDB-cll-lve
-- PHP Version: 8.4.23

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

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '',
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `worked_hours` decimal(5,2) DEFAULT 0.00,
  `ot_hours` decimal(5,2) DEFAULT 0.00,
  `ot_pay` decimal(10,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `availableqty`
-- (See below for the actual view)
--
CREATE TABLE `availableqty` (
`AvailableQty` decimal(33,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(200) NOT NULL,
  `brand_description` varchar(500) DEFAULT NULL,
  `brand_createdby` varchar(200) NOT NULL,
  `brand_modifiedby` varchar(200) NOT NULL,
  `brand_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `brand_modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_description`, `brand_createdby`, `brand_modifiedby`, `brand_createdon`, `brand_modifiedon`) VALUES
(277, 'GP', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-03-30 21:49:19', '2026-07-29 09:07:22'),
(276, 'Te', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-03-30 21:49:04', '2026-07-29 09:05:08'),
(274, 'eb', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-03-30 21:47:50', '2026-07-29 09:04:54'),
(273, 'He', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-03-30 12:13:42', '2026-07-29 09:04:38'),
(280, 'GR', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:22:37', '2026-07-29 11:22:37'),
(279, 'ME', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 09:59:58', '2026-07-29 10:00:26'),
(281, 'VI', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 13:28:51', '2026-07-29 13:28:51'),
(282, 'we', NULL, 'info@acedecors.in', 'info@acedecors.in', '2026-07-30 00:27:51', '2026-07-30 00:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `brand_category_mapping`
--

CREATE TABLE `brand_category_mapping` (
  `brandId` int(11) NOT NULL,
  `item_categoryId` int(11) NOT NULL,
  `createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(100) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(262, 124, 'info@acedecors.in', 'info@acedecors.in', '2026-01-06 17:45:30', '2026-01-06 17:45:30'),
(271, 126, 'info@acedecors.in', 'info@acedecors.in', '2026-03-20 02:52:46', '2026-03-20 02:52:46'),
(282, 131, 'info@acedecors.in', 'info@acedecors.in', '2026-07-30 00:28:31', '2026-07-30 00:28:31'),
(274, 130, '', '', '2026-07-29 11:23:49', '2026-07-29 11:23:49'),
(277, 130, '', '', '2026-07-29 11:23:49', '2026-07-29 11:23:49'),
(273, 130, '', '', '2026-07-29 11:23:49', '2026-07-29 11:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `brand_matcat_mapping`
--

CREATE TABLE `brand_matcat_mapping` (
  `brandId` int(11) NOT NULL,
  `material_categoryId` int(11) NOT NULL,
  `createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(100) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brand_matcat_mapping`
--

INSERT INTO `brand_matcat_mapping` (`brandId`, `material_categoryId`, `createdby`, `modifiedby`, `createdon`, `modifiedon`) VALUES
(263, 36, 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:24:17', '2026-02-13 15:24:17'),
(264, 37, 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:24:35', '2026-02-13 15:24:35'),
(270, 38, 'info@acedecors.in', 'info@acedecors.in', '2026-02-13 15:24:45', '2026-02-13 15:24:45'),
(264, 39, 'info@acedecors.in', 'info@acedecors.in', '2026-02-19 13:31:39', '2026-02-19 13:31:39'),
(270, 39, 'info@acedecors.in', 'info@acedecors.in', '2026-02-19 13:31:39', '2026-02-19 13:31:39'),
(276, 43, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 13:34:21', '2026-07-29 13:34:21'),
(277, 42, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 13:28:04', '2026-07-29 13:28:04'),
(281, 43, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 13:34:21', '2026-07-29 13:34:21');

-- --------------------------------------------------------

--
-- Table structure for table `businessdetails`
--

CREATE TABLE `businessdetails` (
  `businessId` int(11) NOT NULL,
  `businessName` varchar(250) NOT NULL,
  `businessAddress` varchar(250) NOT NULL,
  `businessContact` varchar(15) NOT NULL,
  `businessContact2` varchar(50) DEFAULT NULL,
  `businessTagLine` varchar(500) NOT NULL,
  `businessEmail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ModifiedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `businessGSTIN` varchar(15) DEFAULT NULL,
  `logoImage` varchar(100) DEFAULT NULL,
  `aboutBusiness` longtext NOT NULL,
  `aboutHeader` varchar(255) DEFAULT NULL,
  `aboutSubheading` varchar(500) DEFAULT NULL,
  `aboutImage` varchar(255) DEFAULT NULL,
  `aboutTitle` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `businessdetails`
--

INSERT INTO `businessdetails` (`businessId`, `businessName`, `businessAddress`, `businessContact`, `businessContact2`, `businessTagLine`, `businessEmail`, `password`, `ModifiedDate`, `createdDate`, `businessGSTIN`, `logoImage`, `aboutBusiness`, `aboutHeader`, `aboutSubheading`, `aboutImage`, `aboutTitle`) VALUES
(1, 'Ace Decors', 'PB Road, Lakamanahalli BRTS Stop, Near Ozone Hotel\r\nDharwad-580004', '9742268112', '9742367112', 'Dharwad', 'info@acedecors.co.in', '', '2025-09-27 06:41:42', '2021-11-27 19:14:44', '29ABQFA0335B1ZM', 'employe icon.jpg', '<p>We as a Wooden and Steel Furniture Manufacturing Industry founded in the year 1985 by the name Royal Industries has grown today as a complete Interior Designing Company asÂ ACE DECORS, Adapted to the German CNC technology for highest precision and quality manufacturing which help us to achieve on-time completion of every single project with minimal wastage,making our quality products more affordable in this age of inflation.We have changed the name but not the game.With the experienced team of designers,we transform every individuals dream space to reality. \n<br />\n</p>', 'We At Ace Decors', 'Unfold Your Space From Sketch To Reality', 'SHowroom Image001.jpg', 'Ace Decors');

-- --------------------------------------------------------

--
-- Table structure for table `business_media`
--

CREATE TABLE `business_media` (
  `id` int(11) NOT NULL,
  `businessId` int(11) NOT NULL,
  `mediaType` enum('image','video') NOT NULL,
  `fileName` varchar(255) DEFAULT NULL,
  `videoUrl` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `cabinettype` (
  `CabinetType_Id` int(11) NOT NULL,
  `CabinetType` varchar(100) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(200) NOT NULL,
  `categoryDescription` varchar(500) NOT NULL,
  `categoryCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `categoryCreatedBy` varchar(200) NOT NULL,
  `categoryModifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categorytModifiedBy` varchar(200) NOT NULL,
  `HasSubcategory` varchar(120) NOT NULL,
  `createdOn` datetime DEFAULT current_timestamp(),
  `modifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`, `categoryDescription`, `categoryCreatedOn`, `categoryCreatedBy`, `categoryModifiedOn`, `categorytModifiedBy`, `HasSubcategory`, `createdOn`, `modifiedOn`) VALUES
(65, 'Inspiration', 'Inspiration', '2026-06-04 11:59:15', 'info@acedecors.in', '2026-06-04 11:59:15', 'info@acedecors.in', '0', '2026-06-04 11:59:15', '2026-06-04 11:59:15'),
(64, 'Furniture', 'Furniture', '2026-06-04 11:58:40', 'info@acedecors.in', '2026-06-04 11:58:40', 'info@acedecors.in', '0', '2026-06-04 11:58:40', '2026-06-04 11:58:40'),
(61, 'Interiors', 'Interiors', '2026-03-16 04:47:18', 'info@acedecors.in', '2026-06-04 11:59:35', 'info@acedecors.in', '1', '2026-03-16 04:47:18', '2026-06-04 11:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `catsubcatmapping`
--

CREATE TABLE `catsubcatmapping` (
  `catId` int(11) NOT NULL,
  `sucatId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `catsubcatmapping`
--

INSERT INTO `catsubcatmapping` (`catId`, `sucatId`) VALUES
(43, 2),
(60, 90),
(54, 71),
(60, 91),
(59, 90),
(61, 96),
(61, 94),
(61, 93);

-- --------------------------------------------------------

--
-- Table structure for table `cl_dimension`
--

CREATE TABLE `cl_dimension` (
  `CLDimensionId` int(11) NOT NULL,
  `CL_Dimensions` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cl_dimension`
--

INSERT INTO `cl_dimension` (`CLDimensionId`, `CL_Dimensions`) VALUES
(1, 'Length'),
(2, 'Width'),
(4, 'Depth');

-- --------------------------------------------------------

--
-- Table structure for table `cms_brands`
--

CREATE TABLE `cms_brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cms_brands`
--

INSERT INTO `cms_brands` (`id`, `name`, `image`, `status`, `created_at`) VALUES
(19, 'ebco', '1780601176_ebco.png', 1, '2026-06-04 19:26:16'),
(18, 'Tesa', '1780601049_Tesa.png', 1, '2026-06-04 19:24:09'),
(17, 'Royal Touche', '1780600977_RT.png', 1, '2026-06-04 19:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `cms_brand_section`
--

CREATE TABLE `cms_brand_section` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `paragraph` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cms_brand_section`
--

INSERT INTO `cms_brand_section` (`id`, `heading`, `paragraph`) VALUES
(2, 'Our Signature Brand Collective', 'Our Signature Brand Collective\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `companyid` int(11) NOT NULL,
  `company_name` varchar(250) NOT NULL,
  `company_address` varchar(250) NOT NULL,
  `company_contact` varchar(15) NOT NULL,
  `company_tag` varchar(500) NOT NULL,
  `company_branches` varchar(250) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ModifiedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `company_GSTIN` varchar(15) DEFAULT NULL,
  `company_BankName` varchar(100) DEFAULT NULL,
  `company_BankAccountNumber` varchar(100) DEFAULT NULL,
  `company_BankIFSC` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`companyid`, `company_name`, `company_address`, `company_contact`, `company_tag`, `company_branches`, `company_email`, `password`, `ModifiedDate`, `created_date`, `company_GSTIN`, `company_BankName`, `company_BankAccountNumber`, `company_BankIFSC`) VALUES
(1, 'ACE DECORS', 'Opp Dodwad Oil Mill, Lakhmanhalli PB Road, Dharwad 580004', '9742367112', 'DREAMS COME TRUE', '', 'info@acedecors.in', 'Acedecors@123', '2025-09-06 11:45:38', '2021-05-01 18:47:39', '29ABQFA0355B1ZM', 'ICICI', '142505002388', 'ICIC0001425');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `paragraph` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `brief` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `content_media` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `content_media`
--

INSERT INTO `content_media` (`id`, `content_id`, `file_type`, `image_file`, `video_url`, `video_file`, `caption`, `alt_text`, `created_at`) VALUES
(6, 6, 'image', '1780599930_DMLS-001.jpg', NULL, NULL, '', '', '2026-06-04 19:05:30'),
(7, 6, 'image', '1780599940_DMLS-002.jpg', NULL, NULL, '', '', '2026-06-04 19:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` int(11) NOT NULL,
  `enq_id` int(11) NOT NULL,
  `customerCode` varchar(100) NOT NULL,
  `customerName` varchar(200) NOT NULL,
  `customerContactNumber` varchar(15) NOT NULL,
  `customerEmail` varchar(200) NOT NULL,
  `customerAddress` varchar(500) NOT NULL,
  `customerState` varchar(200) NOT NULL,
  `customerCountry` varchar(50) NOT NULL,
  `customerCity` varchar(200) NOT NULL,
  `isQuoteGenerated` tinyint(1) NOT NULL DEFAULT 0,
  `createdby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customerDOV` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `enq_id`, `customerCode`, `customerName`, `customerContactNumber`, `customerEmail`, `customerAddress`, `customerState`, `customerCountry`, `customerCity`, `isQuoteGenerated`, `createdby`, `createdon`, `modifiedby`, `modifiedon`, `customerDOV`) VALUES
(34, 88, 'AD-202607-RA34', 'Riyaz Ahmed', '9517532486', '123@gmail.com', 'Gandhi Nagar', 'KARNATAKA', 'India', 'Dharwad', 1, 'info@acedecors.in', '2026-07-29 13:36:51', 'info@acedecors.in', '2026-07-29 13:46:14', '2026-07-30');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerbalanceamt`
-- (See below for the actual view)
--
CREATE TABLE `customerbalanceamt` (
`Total` decimal(33,0)
,`Id` varchar(100)
,`CustomerId` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerlastm`
-- (See below for the actual view)
--
CREATE TABLE `customerlastm` (
`Customers` bigint(21)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `customerpaymentinfo`
--

CREATE TABLE `customerpaymentinfo` (
  `payment_id` int(11) NOT NULL,
  `quotation_id` varchar(50) DEFAULT NULL,
  `customer_id` varchar(100) NOT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `paid_amount` int(11) DEFAULT NULL,
  `received_amount` int(11) NOT NULL,
  `pending_amount` int(11) DEFAULT NULL,
  `creditDiscount` decimal(10,2) DEFAULT 0.00,
  `payment_plan` varchar(100) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `RTGS_no` varchar(50) DEFAULT NULL,
  `cheque_img` varchar(100) NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_description` varchar(100) NOT NULL,
  `modifieddate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_by` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `customerpaymentinfo`
--

INSERT INTO `customerpaymentinfo` (`payment_id`, `quotation_id`, `customer_id`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `creditDiscount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `modifieddate`, `modified_by`) VALUES
(394, 'RA34-SW-01', 'AD-202607-RA34', 15000, NULL, 0, NULL, 0.00, '0', '0', NULL, '', NULL, '0', '2026-07-29 14:09:35', '0');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerpaymentlastq`
-- (See below for the actual view)
--
CREATE TABLE `customerpaymentlastq` (
`ReceivedAmt` decimal(32,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `designimages`
--

CREATE TABLE `designimages` (
  `designImgId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `designFilePath` varchar(200) NOT NULL,
  `designDescription` varchar(500) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `designCategory` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `designimages`
--

INSERT INTO `designimages` (`designImgId`, `customerId`, `designFilePath`, `designDescription`, `createdby`, `modifiedby`, `modifiedon`, `createdon`, `designCategory`) VALUES
(41, 29, '6db3e2883e74d92c7d153ae4bc5a0110.jpg', 'Shoe Cabinet', 'info@acedecors.in', 'info@acedecors.in', '2026-04-01 04:50:25', '2026-04-01 04:50:25', 22),
(42, 29, 'aston-martin-car-outline-vector-illustration_507315-64.jpg', 'Car', 'info@acedecors.in', 'info@acedecors.in', '2026-04-01 04:50:44', '2026-04-01 04:50:44', 27),
(43, 34, '972add52-35a5-46d9-9d06-ae51e54fbb90.png', 'Living Room', 'info@acedecors.in', 'info@acedecors.in', '2026-07-30 01:38:44', '2026-07-30 01:38:44', 22);

-- --------------------------------------------------------

--
-- Table structure for table `dimensions`
--

CREATE TABLE `dimensions` (
  `dimensionsId` int(11) NOT NULL,
  `dimensionsName` varchar(200) NOT NULL,
  `dimensionsDescription` varchar(500) NOT NULL,
  `length` int(11) DEFAULT NULL,
  `breadth` int(11) DEFAULT NULL,
  `thickness` int(11) DEFAULT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedBy` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eb`
--

CREATE TABLE `eb` (
  `EB_Id` int(11) NOT NULL,
  `EB` varchar(50) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eb_lw`
--

CREATE TABLE `eb_lw` (
  `EBLW_Id` int(11) NOT NULL,
  `EB_LW` varchar(100) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `salary_type` enum('Daily','Weekly','Monthly') DEFAULT 'Daily',
  `salary_amount` decimal(10,2) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `working_hours` decimal(4,1) NOT NULL DEFAULT 8.0,
  `notes` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `createdOn` datetime DEFAULT current_timestamp(),
  `weekly_off_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT 'Sunday'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `designation`, `contact`, `email`, `address`, `doj`, `salary_type`, `salary_amount`, `hourly_rate`, `working_hours`, `notes`, `photo`, `createdOn`, `weekly_off_day`) VALUES
(42, 'Narendra', 'Technician', '8722773751', '123@gmail.com', 'Gandhinagar', '2026-01-01', 'Daily', 600.00, 100.00, 8.0, '', 'uploads/employee/1781242032_Screenshot 2025-06-14 002019.png', '2026-06-09 12:06:07', 'Friday'),
(41, 'Raju', 'Technician', '8722773751', 'raju@gmail.com', 'Gandhinagar', '2026-03-01', 'Daily', 600.00, 100.00, 8.0, 'Contract Employees', 'uploads/employee/1776182028_employe icon.jpg', '2026-04-01 05:09:18', 'Friday');

-- --------------------------------------------------------

--
-- Table structure for table `employee_payment`
--

CREATE TABLE `employee_payment` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` enum('Cash','Bank Transfer','UPI','Cheque') DEFAULT 'Cash',
  `status` enum('Paid','Pending') DEFAULT 'Paid',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Qualification` varchar(100) NOT NULL,
  `Trainings` varchar(40) NOT NULL,
  `Internship` varchar(40) NOT NULL,
  `Demo` varchar(100) NOT NULL,
  `Services` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `Modified_Date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `enquirylastm`
-- (See below for the actual view)
--
CREATE TABLE `enquirylastm` (
`Enquiries` bigint(21)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_category`
--

CREATE TABLE `enquiry_category` (
  `enq_catid` int(11) NOT NULL,
  `enq_cat_name` varchar(200) NOT NULL,
  `enq_cat_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `enq_cat_createdby` varchar(200) NOT NULL,
  `enq_cat_modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `enq_cat_modifiedby` varchar(200) NOT NULL,
  `enq_cat_type` varchar(100) NOT NULL DEFAULT 'Enquiry Category'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enquiry_category`
--

INSERT INTO `enquiry_category` (`enq_catid`, `enq_cat_name`, `enq_cat_createdon`, `enq_cat_createdby`, `enq_cat_modifiedon`, `enq_cat_modifiedby`, `enq_cat_type`) VALUES
(26, 'Kitchen', '2026-02-17 18:04:10', 'info@acedecors.in', '2026-03-30 22:20:05', 'info@acedecors.in', 'Enquiry Category'),
(25, 'Living Room', '2026-02-07 18:31:01', 'info@acedecors.in', '2026-02-07 18:31:01', 'info@acedecors.in', 'Enquiry Category'),
(24, 'Sliding Wardrobe', '2026-02-07 18:30:50', 'info@acedecors.in', '2026-02-07 18:30:50', 'info@acedecors.in', 'Enquiry Category'),
(22, 'Living Room', '2026-02-07 18:30:28', 'info@acedecors.in', '2026-02-07 18:30:28', 'info@acedecors.in', 'Design'),
(23, 'TV Unit', '2026-02-07 18:30:44', 'info@acedecors.in', '2026-04-13 22:33:04', 'info@acedecors.in', 'Enquiry Category'),
(27, 'Pooja Unit', '2026-03-19 23:40:47', 'info@acedecors.in', '2026-03-19 23:40:47', 'info@acedecors.in', 'Design');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_details`
--

CREATE TABLE `enquiry_details` (
  `enqid` int(11) NOT NULL,
  `enq_name` varchar(200) NOT NULL,
  `enq_email` varchar(200) NOT NULL,
  `enq_address` varchar(500) NOT NULL,
  `enq_city` varchar(150) NOT NULL,
  `enq_state` varchar(100) NOT NULL,
  `enq_country` varchar(50) NOT NULL,
  `enq_phone` varchar(10) NOT NULL,
  `enqStatus` enum('Attended','Unattended') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Unattended',
  `isCustomerCreated` tinyint(1) NOT NULL DEFAULT 0,
  `enq_createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `enq_modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `enq_modifiedBy` varchar(200) NOT NULL,
  `enq_preffered_contact_mode` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enquiry_details`
--

INSERT INTO `enquiry_details` (`enqid`, `enq_name`, `enq_email`, `enq_address`, `enq_city`, `enq_state`, `enq_country`, `enq_phone`, `enqStatus`, `isCustomerCreated`, `enq_createdOn`, `enq_modifiedOn`, `enq_modifiedBy`, `enq_preffered_contact_mode`) VALUES
(89, 'vijay L', 'admin@boutique.com', 'hubli', '', '', 'India', '999999999', 'Attended', 0, '2026-04-21 08:20:16', '2026-07-22 23:45:53', '', ''),
(88, 'Riyaz Ahmed', '123@gmail.com', 'Gandhi Nagar', 'Dharwad', 'KARNATAKA', 'India', '9517532486', 'Attended', 1, '2026-04-04 01:17:58', '2026-07-29 13:36:51', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_followups`
--

CREATE TABLE `enquiry_followups` (
  `followupid` int(11) NOT NULL,
  `followup_enq_id` int(11) NOT NULL,
  `followup_comments` varchar(500) NOT NULL,
  `followup_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `followup_by` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enquiry_followups`
--

INSERT INTO `enquiry_followups` (`followupid`, `followup_enq_id`, `followup_comments`, `followup_createdon`, `followup_by`) VALUES
(75, 89, 'interested', '2026-04-21 08:22:07', 'info@acedecors.in'),
(74, 88, 'interested', '2026-04-21 08:21:43', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `enq_cat_mapping`
--

CREATE TABLE `enq_cat_mapping` (
  `enq_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(86, 24),
(81, 23),
(81, 25),
(82, 25),
(82, 26),
(83, 23),
(84, 23),
(84, 24),
(85, 24),
(83, 25),
(86, 26),
(87, 24),
(87, 25),
(88, 24),
(88, 26),
(89, 26),
(88, 23);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `payment_type` enum('Cash','Bank Transfer','UPI','Cheque') DEFAULT 'Cash',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `subcategory_id` int(11) DEFAULT NULL,
  `subcategory_name` varchar(100) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('Expense','Income') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finish`
--

CREATE TABLE `finish` (
  `FinishId` int(11) NOT NULL,
  `Finish` varchar(59) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `ModifiedBy` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `general_subcategory` (
  `id` int(11) NOT NULL,
  `subcategory_name` varchar(150) NOT NULL,
  `category` varchar(50) DEFAULT 'General',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_subcategory`
--

INSERT INTO `general_subcategory` (`id`, `subcategory_name`, `category`, `created_at`) VALUES
(20, 'hARDWARE', 'General', '2026-04-01 12:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `gl`
--

CREATE TABLE `gl` (
  `GL_Id` int(11) NOT NULL,
  `GL` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `inputtype` (
  `InputTypeId` int(11) NOT NULL,
  `InputType` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `inputtype_brand_mapping` (
  `brandId` int(11) NOT NULL,
  `InputTypeId` int(11) NOT NULL,
  `ModifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ModifiedBy` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(263, 1, '2026-02-25 15:57:50', 'info@acedecors.in', 'info@acedecors.in', '2026-02-25 15:57:50'),
(271, 1, '2026-03-20 02:51:07', 'info@acedecors.in', 'info@acedecors.in', '2026-03-20 02:51:07'),
(272, 2, '2026-03-20 02:51:23', 'info@acedecors.in', 'info@acedecors.in', '2026-03-20 02:51:23'),
(273, 1, '2026-07-29 11:06:45', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:06:45'),
(274, 1, '2026-07-29 11:06:11', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:06:11'),
(275, 2, '2026-03-30 21:48:12', 'info@acedecors.in', 'info@acedecors.in', '2026-03-30 21:48:12'),
(279, 2, '2026-07-29 10:00:26', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 10:00:26'),
(277, 1, '2026-07-29 09:07:22', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 09:07:22'),
(278, 2, '2026-06-06 04:03:23', 'info@acedecors.in', 'info@acedecors.in', '2026-06-06 04:03:23'),
(277, 2, '2026-07-29 09:07:22', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 09:07:22'),
(276, 2, '2026-07-29 11:07:14', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:07:14'),
(280, 1, '2026-07-29 11:22:37', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:22:37'),
(281, 2, '2026-07-29 13:28:51', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 13:28:51'),
(282, 1, '2026-07-30 00:27:51', 'info@acedecors.in', 'info@acedecors.in', '2026-07-30 00:27:51');

-- --------------------------------------------------------

--
-- Stand-in structure for view `inwardedlastq`
-- (See below for the actual view)
--
CREATE TABLE `inwardedlastq` (
`ReceivedQty` decimal(32,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `itemallocation`
--

CREATE TABLE `itemallocation` (
  `item_stockId` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `InputName` varchar(50) NOT NULL,
  `AllocatedQty` int(11) NOT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `itemallocation`
--

INSERT INTO `itemallocation` (`item_stockId`, `ProjectId`, `ItemId`, `InputName`, `AllocatedQty`, `modifiedOn`) VALUES
(0, 74, 125, 'TV Units', 5, '2026-02-26 15:31:08'),
(0, 78, 127, 'Mat1', 10, '2026-04-01 05:32:24'),
(0, 80, 185, '0CSCH-35', 0, '2026-04-08 08:07:44'),
(206, 82, 188, '0CH', 2, '2026-07-29 05:00:22'),
(206, 82, 188, '0CH', 2, '2026-07-29 05:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `itemissues_followup`
--

CREATE TABLE `itemissues_followup` (
  `followupId` int(11) NOT NULL,
  `followupPOID` int(11) NOT NULL,
  `followup_ItemId` int(11) NOT NULL,
  `followup_comments` varchar(200) NOT NULL,
  `Status` varchar(100) DEFAULT 'Open',
  `followup_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `followup_by` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `item_catid` int(11) NOT NULL,
  `item_catName` varchar(200) NOT NULL,
  `item_catDescription` varchar(500) NOT NULL,
  `item_catCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `item_catCreatedBy` varchar(200) NOT NULL,
  `item_catModifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `item_catModifiedBy` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`item_catid`, `item_catName`, `item_catDescription`, `item_catCreatedOn`, `item_catCreatedBy`, `item_catModifiedOn`, `item_catModifiedBy`) VALUES
(131, 'eI', 'H', '2026-07-30 00:28:31', 'info@acedecors.in', '2026-07-30 00:28:31', 'info@acedecors.in'),
(130, 'H', 'H', '2026-07-29 11:10:12', 'info@acedecors.in', '2026-07-29 11:10:12', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `item_companydetails`
--

CREATE TABLE `item_companydetails` (
  `item_compid` int(11) NOT NULL,
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
  `item_compCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `item_compModifiedBy` varchar(200) NOT NULL,
  `item_compModifedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `item_complogo` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_companydetails`
--

INSERT INTO `item_companydetails` (`item_compid`, `item_compName`, `item_compContactName`, `item_compContactNumber`, `item_compDescription`, `item_compGSTIN`, `item_compAccountno`, `item_compAccountname`, `item_compaccIFSCcode`, `item_compaccMICRcode`, `item_compAddress`, `item_compLocation`, `item_compCreatedBy`, `item_compCreatedOn`, `item_compModifiedBy`, `item_compModifedOn`, `item_complogo`) VALUES
(17, 'RGLHBL', NULL, NULL, 'Hardware', '29AACFM6853B1ZB', '123456789', 'RGLHBL', 'abcdefgh', '123qwe', 'Industrial Area', 'Hubli', 'info@acedecors.in', '2026-03-30 22:01:40', 'info@acedecors.in', '2026-07-29 10:12:08', 'images.jpg'),
(16, 'RHHBL', NULL, NULL, 'Hardware', '29AAACH8849M1ZT', '123456789', 'RHSHBL1', 'abcdefgh', '123qwe', 'Industrial Area', 'Hubli', 'info@acedecors.in', '2026-03-30 21:55:07', 'info@acedecors.in', '2026-07-29 10:13:43', 'images.png'),
(18, 'SDHBL', NULL, NULL, 'Hardware', '29AAACH8845M1ZT', '123456789', 'SDHBL', 'abcdefgh', '123qwe', 'Industrial Area', 'Hubli', 'info@acedecors.in', '2026-03-30 22:10:08', 'info@acedecors.in', '2026-07-29 10:13:01', 'images (1).jpg'),
(19, 'SLHBL', NULL, NULL, 'Hardware', '29BGNPM4181J1ZS', '1458697236', 'SLHBL', '4125639', '523689', 'Karwar Road', 'Hubli', 'info@acedecors.in', '2026-07-29 10:05:16', 'info@acedecors.in', '2026-07-29 10:14:37', 'images (2).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_details`
--

CREATE TABLE `item_details` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_description` varchar(500) NOT NULL,
  `item_catid` int(11) NOT NULL,
  `item_subcatid` int(11) NOT NULL,
  `item_compid` int(11) NOT NULL,
  `item_image` varchar(200) NOT NULL,
  `item_createdby` varchar(200) NOT NULL,
  `item_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `item_modifiedby` varchar(200) NOT NULL,
  `item_modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `item_HSNcode` varchar(100) NOT NULL,
  `item_ArticleNo` varchar(100) NOT NULL,
  `item_SAPId` varchar(25) DEFAULT NULL,
  `Item_OrderNumber` varchar(25) DEFAULT NULL,
  `item_Size` int(11) NOT NULL,
  `item_PackingUnit` int(11) NOT NULL,
  `item_MRP` double NOT NULL,
  `item_Amount` double NOT NULL DEFAULT 0,
  `item_pp_MRP` double NOT NULL,
  `item_descriptionforcust` varchar(500) DEFAULT NULL,
  `item_GST` int(11) NOT NULL,
  `item_Discount` decimal(10,2) DEFAULT 0.00,
  `item_Price` decimal(10,2) DEFAULT 0.00,
  `item_TotalValue` decimal(10,2) DEFAULT 0.00,
  `item_unit` varchar(100) NOT NULL,
  `item_unitFactor` double NOT NULL,
  `item_totalMRP` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_details`
--

INSERT INTO `item_details` (`item_id`, `item_name`, `item_description`, `item_catid`, `item_subcatid`, `item_compid`, `item_image`, `item_createdby`, `item_createdon`, `item_modifiedby`, `item_modifiedon`, `item_HSNcode`, `item_ArticleNo`, `item_SAPId`, `Item_OrderNumber`, `item_Size`, `item_PackingUnit`, `item_MRP`, `item_Amount`, `item_pp_MRP`, `item_descriptionforcust`, `item_GST`, `item_Discount`, `item_Price`, `item_TotalValue`, `item_unit`, `item_unitFactor`, `item_totalMRP`) VALUES
(192, '0CH', '0CHAH', 130, 92, 277, 'images (2).png', 'info@acedecors.in', '2026-07-29 11:26:41', 'info@acedecors.in', '2026-07-29 11:27:14', '123', '0CHAHGP', NULL, NULL, 1, 50, 180, 180, 0, NULL, 18, 30.00, 148.68, 7434.00, '63', 33, 0),
(189, '0CH', '0CHAH', 130, 92, 274, 'images (1).png', 'info@acedecors.in', '2026-07-29 11:14:37', 'info@acedecors.in', '2026-07-29 11:24:27', '123', '0CHAHeb', NULL, NULL, 1, 50, 150, 150, 0, NULL, 18, 30.00, 123.90, 6195.00, '63', 33, 0),
(191, '0CH', '0CHAH', 130, 92, 273, 'images.png', 'info@acedecors.in', '2026-07-29 11:21:18', 'info@acedecors.in', '2026-07-29 11:25:48', '123', '0CHAHHe', NULL, NULL, 1, 50, 215, 215, 0, NULL, 18, 30.00, 177.59, 8879.50, '63', 33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_pricingissues`
--

CREATE TABLE `item_pricingissues` (
  `PricingIssues_Id` int(11) NOT NULL,
  `InvoiceNo` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `ItemName` varchar(100) NOT NULL,
  `POID` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Issue_ModifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ItemId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

CREATE TABLE `item_stock` (
  `item_stockid` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `ItemCode` varchar(50) NOT NULL,
  `ItemName` varchar(50) NOT NULL,
  `POID` int(11) NOT NULL,
  `InvoiceNo` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Unit` varchar(100) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `TotalAmount` decimal(12,2) DEFAULT NULL,
  `GST` varchar(50) DEFAULT NULL,
  `ReceivedQtyAmt` decimal(12,2) DEFAULT NULL,
  `ReceivedQty` int(11) DEFAULT NULL,
  `BalanceQty` int(11) DEFAULT 0,
  `stockPDFName` varchar(100) DEFAULT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_subcategory`
--

CREATE TABLE `item_subcategory` (
  `item_subcatid` int(11) NOT NULL,
  `item_catid` int(11) NOT NULL,
  `item_subcatName` varchar(200) NOT NULL,
  `item_subcatDescription` varchar(500) NOT NULL,
  `item_subcatCreatedBy` varchar(200) NOT NULL,
  `item_subcatCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `item_subcatModifiedBy` varchar(200) NOT NULL,
  `item_subcatModifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_subcategory`
--

INSERT INTO `item_subcategory` (`item_subcatid`, `item_catid`, `item_subcatName`, `item_subcatDescription`, `item_subcatCreatedBy`, `item_subcatCreatedOn`, `item_subcatModifiedBy`, `item_subcatModifiedon`) VALUES
(92, 130, 'AH', 'AH', 'info@acedecors.in', '2026-07-29 11:10:38', 'info@acedecors.in', '2026-07-29 11:10:38'),
(93, 130, 'SC', 'SC', 'info@acedecors.in', '2026-07-29 11:21:50', 'info@acedecors.in', '2026-07-29 11:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `Material_Id` int(11) NOT NULL,
  `Material_Name` varchar(100) NOT NULL,
  `Material_Code` varchar(100) NOT NULL,
  `Material_Description` varchar(100) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `SubCategory` varchar(100) NOT NULL,
  `Mat_Qty` int(11) NOT NULL,
  `Brand` varchar(100) NOT NULL,
  `Mat_Thickness` varchar(100) NOT NULL,
  `Mat_Unit` varchar(100) NOT NULL,
  `Mat_factor` double NOT NULL,
  `Mat_HSNCode` varchar(100) NOT NULL,
  `Mat_SPU` int(11) NOT NULL,
  `Mat_MRP` double NOT NULL,
  `Mat_GST` int(11) NOT NULL,
  `Mat_TotalMRP` int(11) NOT NULL,
  `Mat_PPMRP` int(11) NOT NULL,
  `Mat_Image` varchar(200) NOT NULL,
  `Mat_Grains` varchar(100) NOT NULL,
  `Mat_createdBy` varchar(100) NOT NULL,
  `Mat_modifiedBy` varchar(100) NOT NULL,
  `MaterialDiscount` decimal(10,2) DEFAULT NULL,
  `MaterialAmount` double DEFAULT 0,
  `MaterialPrice` decimal(10,2) DEFAULT NULL,
  `MaterialTotalValue` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`Material_Id`, `Material_Name`, `Material_Code`, `Material_Description`, `Category`, `SubCategory`, `Mat_Qty`, `Brand`, `Mat_Thickness`, `Mat_Unit`, `Mat_factor`, `Mat_HSNCode`, `Mat_SPU`, `Mat_MRP`, `Mat_GST`, `Mat_TotalMRP`, `Mat_PPMRP`, `Mat_Image`, `Mat_Grains`, `Mat_createdBy`, `Mat_modifiedBy`, `MaterialDiscount`, `MaterialAmount`, `MaterialPrice`, `MaterialTotalValue`) VALUES
(131, 'AEHF', 'AEHFVI', 'AEHF', '43', '40', 1, '281', '7', '64', 34, '456', 1, 120, 18, 0, 0, 'images.png', '2', 'info@acedecors.in', 'info@acedecors.in', 0.00, 4200, 4200.00, 4200.00),
(130, 'ABR', 'ABRGP', 'ABR', '42', '39', 1, '277', '7', '64', 34, '456', 1, 100, 18, 0, 0, 'images.jpg', '1', 'info@acedecors.in', 'info@acedecors.in', 0.00, 3500, 3500.00, 3500.00),
(132, 'AEHF', 'AEHFTe', 'AEHF', '43', '40', 1, '276', '7', '64', 34, '456', 1, 110, 18, 0, 0, 'images (1).png', '3', 'info@acedecors.in', 'info@acedecors.in', 0.00, 3850, 3850.00, 3850.00);

-- --------------------------------------------------------

--
-- Table structure for table `materialissues_followup`
--

CREATE TABLE `materialissues_followup` (
  `followup_Id` int(11) NOT NULL,
  `followup_POID` int(11) NOT NULL,
  `followup_MaterialId` int(11) NOT NULL,
  `followup_comments` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Open',
  `followup_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `followup_by` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_category`
--

CREATE TABLE `material_category` (
  `material_catId` int(11) NOT NULL,
  `material_catName` varchar(100) NOT NULL,
  `material_catDescription` varchar(100) NOT NULL,
  `material_catCreatedBy` varchar(100) NOT NULL,
  `material_catCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `material_catModifiedBy` varchar(50) NOT NULL,
  `material_catModifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `material_category`
--

INSERT INTO `material_category` (`material_catId`, `material_catName`, `material_catDescription`, `material_catCreatedBy`, `material_catCreatedOn`, `material_catModifiedBy`, `material_catModifiedOn`) VALUES
(43, 'HF', 'HF', 'info@acedecors.in', '2026-07-29 13:29:44', 'info@acedecors.in', '2026-07-29 13:29:44'),
(42, 'PL', 'PL', 'info@acedecors.in', '2026-07-29 11:29:45', 'info@acedecors.in', '2026-07-29 11:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `material_pricingissues`
--

CREATE TABLE `material_pricingissues` (
  `PricingIssues_Id` int(11) NOT NULL,
  `InvoiceNo` int(11) NOT NULL,
  `SupplierName` varchar(50) NOT NULL,
  `MaterialName` varchar(50) NOT NULL,
  `POID` varchar(20) NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Open',
  `Issue_ModifiedOn` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_subcategory`
--

CREATE TABLE `material_subcategory` (
  `material_subcatId` int(11) NOT NULL,
  `material_catId` int(11) NOT NULL,
  `material_subcatName` varchar(100) NOT NULL,
  `material_subcatDescription` varchar(100) NOT NULL,
  `material_subcatCreatedBy` varchar(100) NOT NULL,
  `material_subcatCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `material_subcatModifiedBy` varchar(50) NOT NULL,
  `material_subcatModifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `material_subcategory`
--

INSERT INTO `material_subcategory` (`material_subcatId`, `material_catId`, `material_subcatName`, `material_subcatDescription`, `material_subcatCreatedBy`, `material_subcatCreatedOn`, `material_subcatModifiedBy`, `material_subcatModifiedon`) VALUES
(39, 42, 'BR', 'BR', 'info@acedecors.in', '2026-07-29 13:23:10', 'info@acedecors.in', '2026-07-29 13:23:10'),
(40, 43, 'EHF', 'EHF', 'info@acedecors.in', '2026-07-29 13:30:39', 'info@acedecors.in', '2026-07-29 13:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_label` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `module_actions` (
  `id` int(11) NOT NULL,
  `module_name` varchar(50) DEFAULT NULL,
  `action_key` varchar(50) DEFAULT NULL,
  `action_label` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `can_read` tinyint(1) DEFAULT 0,
  `can_write` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postId` int(11) NOT NULL,
  `postTitle` varchar(100) NOT NULL,
  `postUrl` varchar(100) NOT NULL,
  `LinkUnder` int(11) NOT NULL,
  `appearOnHome` varchar(1) NOT NULL DEFAULT '0',
  `postDescription` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `postCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `postCreatedBy` varchar(100) NOT NULL,
  `postModifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `titleTag` varchar(100) NOT NULL,
  `keywords` mediumtext NOT NULL,
  `modifiedBy` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `postTitle`, `postUrl`, `LinkUnder`, `appearOnHome`, `postDescription`, `postCreatedOn`, `postCreatedBy`, `postModifiedOn`, `titleTag`, `keywords`, `modifiedBy`) VALUES
(88, 'L Shaped Island Kitchen', '/L-Shaped-Island-Kitchen', 2, '1', '<p>A white acrylic island kitchen with a quartz top is the perfect solution for a clean, modern, and durable kitchen space. The bright, reflective white finish creates an airy, open feel, while the quartz top adds luxury and practicality â€” scratch-resistant, easy to clean, and highly durable. \n<br />\n \n<br />\n</p>\n', '2025-10-09 10:29:53', 'info@acedecors.in', '2026-06-04 12:01:01', 'L Shaped Island Kitchen', 'L Shaped Island Kitchen', 'info@acedecors.in'),
(85, 'Topline Sliding Wardrobes', '/Topline-Sliding-Wardrobes', 2, '1', '<p>Sliding wardrobes are the perfect solution when space optimization matters. They offer a sleek, modern appearance while providing practical storage that adapts to your lifestyle. The smooth operation and clean lines help create a clutter-free, minimalist atmosphere. \n<br />\n \n<br />\n</p>\n', '2025-10-09 09:20:14', 'info@acedecors.in', '2026-03-16 17:39:41', 'Topline Sliding Wardrobes', 'Topline Sliding Wardrobes', 'info@acedecors.in'),
(86, 'Minimalist Wardrobes', '/Minimalist-Wardrobes', 2, '0', '<p>Minimalist wardrobes are the perfect blend of sleek design and smart storage. They focus on simplicity, allowing your space to feel open, organized, and calming. Whether you live in a compact apartment or a modern home, these wardrobes bring elegance and order without overwhelming the room. \n<br />\n \n<br />\n</p>\n', '2025-10-09 09:28:28', 'info@acedecors.in', '2026-03-16 17:37:36', 'Minimalist Wardrobes', 'Minimalist Wardrobes', 'info@acedecors.in'),
(87, 'The Aura Ensemble', '/The-Aura-Ensemble', 2, '1', '<p>Refined simplicity meets functional artistry in <em>The Aura Ensemble</em> by <strong>Ace Decors</strong>. This modern wall-mounted TV unit is a symphony of clean lines, warm wood textures, and subtle lighting that enhances the ambiance of any contemporary living space. \n<br />\n Thoughtfully designed with floating cabinets and open shelves, it blends sophistication with practicality â€” offering ample space for dÃ©cor accents, books, and entertainment essentials. The soft backlighting creates a serene visual frame, transforming your TV wall into a statement feature. \n<br />\n Crafted with precision and a minimalist design philosophy, this unit embodies Ace Decorsâ€™ vision of <strong>modern comfort with timeless appeal</strong>. \n<br />\n</p>\n', '2025-10-09 10:19:04', '', '2026-03-19 01:56:24', 'The Aura Ensemble', 'The Aura Ensemble', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `postcatmapping`
--

CREATE TABLE `postcatmapping` (
  `postId` int(11) NOT NULL,
  `catId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `postimages` (
  `postImageId` int(11) NOT NULL,
  `postImage` longblob NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdBy` varchar(100) NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  `imageAlternateText` varchar(100) NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `postimages`
--

INSERT INTO `postimages` (`postImageId`, `postImage`, `createdOn`, `modifiedOn`, `createdBy`, `modifiedBy`, `imageAlternateText`, `postId`) VALUES
(78, 0x41442d4b69746368656e30312e6a7067, '2025-10-09 10:29:53', '2025-10-09 10:29:53', 'info@acedecors.in', 'info@acedecors.in', 'L Shaped Island Kitchen', 88),
(75, 0x41442d536c6964696e672057617264726f62652d3030312e6a7067, '2025-10-09 09:20:14', '2025-10-09 09:20:14', 'info@acedecors.in', 'info@acedecors.in', 'Topline Sliding Wardrobes', 85),
(76, 0x41442d57617264726f62652d3030312e6a7067, '2025-10-09 09:28:28', '2025-10-09 09:28:28', 'info@acedecors.in', 'info@acedecors.in', 'Minimalist Wardrobes', 86),
(77, 0x545620556e69742e6a7067, '2025-10-09 10:19:04', '2025-10-09 10:19:04', '', '', 'The Aura Ensemble â€“ Modern Wall TV Unit', 87);

-- --------------------------------------------------------

--
-- Table structure for table `postkeywords`
--

CREATE TABLE `postkeywords` (
  `keywordId` int(11) NOT NULL,
  `keyword` varchar(200) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdBy` varchar(100) NOT NULL,
  `modifiedBy` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postsubcatmapping`
--

CREATE TABLE `postsubcatmapping` (
  `postId` int(11) NOT NULL,
  `subCatId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `postsubcatmapping`
--

INSERT INTO `postsubcatmapping` (`postId`, `subCatId`) VALUES
(87, 96),
(86, 94),
(85, 94),
(88, 93);

-- --------------------------------------------------------

--
-- Table structure for table `privacypolicy`
--

CREATE TABLE `privacypolicy` (
  `id` int(11) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `processing` (
  `ProcessingId` int(11) NOT NULL,
  `Processing` varchar(50) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `ModifiedBy` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Length` int(11) NOT NULL,
  `Width` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `CL_ID` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `SubcategoryId` int(11) NOT NULL,
  `FinishId` int(11) NOT NULL,
  `Code` varchar(100) NOT NULL,
  `CabinetType` varchar(100) NOT NULL,
  `Mat_Brand` int(11) NOT NULL,
  `Rotation` int(11) NOT NULL,
  `Mat_Category` int(11) NOT NULL,
  `Mat_Subcategory` int(11) NOT NULL,
  `Thickness` int(11) NOT NULL,
  `Material` int(11) NOT NULL,
  `PEB` varchar(50) NOT NULL,
  `PEB_Thickness` varchar(50) NOT NULL,
  `SEB` varchar(50) NOT NULL,
  `SEB_Thickness` varchar(50) NOT NULL,
  `Comments` varchar(100) NOT NULL,
  `product_createdby` varchar(100) NOT NULL,
  `product_modifiedby` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_catid` int(11) NOT NULL,
  `product_catName` varchar(200) NOT NULL,
  `product_catDescription` varchar(200) NOT NULL,
  `product_catCreatedby` varchar(200) NOT NULL,
  `product_catModifiedby` varchar(200) NOT NULL,
  `product_catCreatedon` datetime NOT NULL DEFAULT current_timestamp(),
  `product_catmodifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_definition`
--

CREATE TABLE `product_definition` (
  `prodDefinition_Id` int(11) NOT NULL,
  `Prod_Name` varchar(100) NOT NULL,
  `Prod_Description` varchar(100) NOT NULL,
  `Rotation` int(11) NOT NULL,
  `Override` varchar(10) NOT NULL,
  `Type` int(11) NOT NULL,
  `Finish` int(11) NOT NULL,
  `Prod_Category` int(11) NOT NULL,
  `Prod_SubCategory` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `LengthValue` int(11) NOT NULL,
  `Dimension1` varchar(50) NOT NULL,
  `WidthValue` int(11) NOT NULL,
  `Dimension2` varchar(50) NOT NULL,
  `DepthValue` int(11) NOT NULL,
  `Dimension3` varchar(50) NOT NULL,
  `CLFormula` varchar(50) NOT NULL,
  `CW` varchar(50) NOT NULL,
  `GL` int(11) NOT NULL,
  `FL` varchar(50) NOT NULL,
  `BL` varchar(50) NOT NULL,
  `RL` varchar(50) NOT NULL,
  `RW` varchar(50) NOT NULL,
  `EB_LW` int(11) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_definition`
--

INSERT INTO `product_definition` (`prodDefinition_Id`, `Prod_Name`, `Prod_Description`, `Rotation`, `Override`, `Type`, `Finish`, `Prod_Category`, `Prod_SubCategory`, `Quantity`, `LengthValue`, `Dimension1`, `WidthValue`, `Dimension2`, `DepthValue`, `Dimension3`, `CLFormula`, `CW`, `GL`, `FL`, `BL`, `RL`, `RW`, `EB_LW`, `CreatedBy`, `ModifiedBy`) VALUES
(2, 'qwerty', 'qwerty', 1, '1', 5, 2, 1, 1, 20, 1, 'Length', 2, 'Width', 3, 'Depth', '1*Length-2*Width-3*Depth', '1*Length-2*Width-3*Depth', 1, 'PEB Thickness', 'SEB Thickness', 'SEB Thickness', 'PEB Thickness', 3, 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategory`
--

CREATE TABLE `product_subcategory` (
  `product_subcatid` int(11) NOT NULL,
  `product_catid` int(11) DEFAULT NULL,
  `product_subcatName` varchar(200) NOT NULL,
  `product_subcatDescription` varchar(200) NOT NULL,
  `product_subcatCreatedby` varchar(100) NOT NULL,
  `product_subcatModifiedby` varchar(100) NOT NULL,
  `product_subcatCreatedon` datetime NOT NULL DEFAULT current_timestamp(),
  `product_subcatModifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `projects` (
  `projectId` int(11) NOT NULL,
  `projectCode` varchar(100) NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `custId` varchar(50) NOT NULL,
  `quoteId` varchar(50) NOT NULL,
  `project_status` varchar(50) NOT NULL DEFAULT 'In Progress',
  `progressNote` varchar(100) DEFAULT NULL,
  `createdOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectId`, `projectCode`, `customerName`, `custId`, `quoteId`, `project_status`, `progressNote`, `createdOn`) VALUES
(83, 'AD-PROJ-0726 -RA83', 'Riyaz Ahmed', 'AD-202607-RA34', 'RA34-SW-01', 'In Progress', NULL, '2026-07-29 14:09:35');

-- --------------------------------------------------------

--
-- Stand-in structure for view `projectslastm`
-- (See below for the actual view)
--
CREATE TABLE `projectslastm` (
`Projects` bigint(21)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `projecttasks`
--

CREATE TABLE `projecttasks` (
  `TaskId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `TaskDescription` varchar(100) NOT NULL,
  `ContactPerson` varchar(100) NOT NULL,
  `ContactNo` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Task_modifiedBy` varchar(100) NOT NULL,
  `Task_modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Task_createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `Task_createdBy` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_issues`
--

CREATE TABLE `project_issues` (
  `IssueId` int(11) NOT NULL,
  `Issue_ProjectId` int(11) NOT NULL,
  `Issue_ProjCode` varchar(50) NOT NULL,
  `Issue_Description` varchar(100) NOT NULL,
  `Issue_ContactName` varchar(50) NOT NULL,
  `Issue_ContactDetails` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Open',
  `Issue_createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `Issue_createdby` varchar(100) NOT NULL,
  `Issue_modifiedby` varchar(50) NOT NULL,
  `issue_modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_lineitem`
--

CREATE TABLE `purchaseorder_lineitem` (
  `POlineitemId` int(11) NOT NULL,
  `POID` varchar(100) DEFAULT NULL,
  `Item_id` int(11) DEFAULT NULL,
  `InputName` varchar(50) NOT NULL,
  `SupplierId` int(11) NOT NULL,
  `Quantity` varchar(20) DEFAULT NULL,
  `Price` varchar(20) DEFAULT NULL,
  `TotalAmt` varchar(20) NOT NULL DEFAULT '0',
  `GST` varchar(50) NOT NULL,
  `Modified_Date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchaseorder_lineitem`
--

INSERT INTO `purchaseorder_lineitem` (`POlineitemId`, `POID`, `Item_id`, `InputName`, `SupplierId`, `Quantity`, `Price`, `TotalAmt`, `GST`, `Modified_Date`) VALUES
(139, '124', 188, '0CH', 16, '3', '', '0', '', '2026-06-06 09:12:26'),
(155, '134', 130, 'ABR', 18, '2', '', '0', '', '2026-07-30 01:50:58'),
(156, '134', 191, '0CH', 18, '3', '', '0', '', '2026-07-30 01:50:58'),
(158, '134', 192, '0CH', 18, '4', '0', '0', '', '2026-07-30 01:52:40'),
(150, '132', 129, '9mm Boilo Plain', 17, '2', '', '0', '', '2026-07-29 05:57:17'),
(152, '132', 128, '18mm Boilo Plain', 17, '5', '0', '0', '', '2026-07-29 05:57:39'),
(153, '133', 188, '0CH', 18, '1', '', '0', '', '2026-07-29 06:06:21'),
(154, '133', 128, '18mm Boilo Plain', 18, '3', '', '0', '', '2026-07-29 06:06:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `Id` int(11) NOT NULL,
  `POcode` varchar(20) NOT NULL,
  `SupplierId` int(11) DEFAULT NULL,
  `Item_id` int(11) NOT NULL,
  `InventoryType` enum('item','material') NOT NULL,
  `ProjectId` varchar(11) DEFAULT NULL,
  `PurchasedDate` date NOT NULL,
  `TotalAmt` int(11) DEFAULT NULL,
  `purchasePDFName` varchar(100) DEFAULT NULL,
  `Status` int(11) DEFAULT 0,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `Modified_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`Id`, `POcode`, `SupplierId`, `Item_id`, `InventoryType`, `ProjectId`, `PurchasedDate`, `TotalAmt`, `purchasePDFName`, `Status`, `createdon`, `Modified_date`) VALUES
(134, 'AD-202607-S134', 18, 130, 'material', '0', '2026-07-30', NULL, NULL, 0, '2026-07-30 01:50:58', '2026-07-30 01:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `quoteId` int(11) NOT NULL,
  `quo_enq_id` int(11) NOT NULL,
  `enqCatId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `quoteCode` varchar(100) NOT NULL,
  `quoteValue` decimal(10,2) DEFAULT NULL,
  `tradePrice` decimal(10,2) DEFAULT 0.00,
  `unitId` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quoteDescription` varchar(500) DEFAULT NULL,
  `itemListName` varchar(200) DEFAULT NULL,
  `orderListName` varchar(200) DEFAULT NULL,
  `quo_type` enum('General','Bank') NOT NULL,
  `quo_pdf_name` varchar(100) DEFAULT NULL,
  `inputType` int(11) NOT NULL,
  `quo_createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `quo_status` enum('pending','rejected','Approved') NOT NULL DEFAULT 'pending',
  `quo_comments` varchar(500) DEFAULT NULL,
  `quo_createdon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`quoteId`, `quo_enq_id`, `enqCatId`, `customerId`, `quoteCode`, `quoteValue`, `tradePrice`, `unitId`, `quantity`, `quoteDescription`, `itemListName`, `orderListName`, `quo_type`, `quo_pdf_name`, `inputType`, `quo_createdby`, `modifiedby`, `modifiedon`, `quo_status`, `quo_comments`, `quo_createdon`) VALUES
(278, 88, 24, 34, 'RA34-SW-01', 15000.00, 0.00, 63, 150, 'D1', '', '', '', '_BOQ_WOQ.pdf', 1, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 14:09:35', 'Approved', 'C1', '2026-07-29 14:09:35'),
(279, 88, 26, 34, 'RA34-K-02', 3000.00, 0.00, NULL, NULL, '', '', '', '', '', 1, 'info@acedecors.in', 'info@acedecors.in', '2026-07-30 01:46:29', 'pending', '', '2026-07-30 01:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `quotelineitem`
--

CREATE TABLE `quotelineitem` (
  `lineItemId` int(11) NOT NULL,
  `quoteId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `inputType` int(11) NOT NULL,
  `InputName` varchar(255) NOT NULL,
  `item_catid` int(11) NOT NULL,
  `item_subcatid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
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
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reference` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quotelineitem`
--

INSERT INTO `quotelineitem` (`lineItemId`, `quoteId`, `itemId`, `inputType`, `InputName`, `item_catid`, `item_subcatid`, `quantity`, `amount`, `value`, `totalValue`, `totalAmount`, `discount1`, `discount1Amt`, `discount2`, `discount2Amt`, `GSTAmount`, `GST`, `totalPrice`, `billedAmount`, `createdby`, `createdon`, `modifiedby`, `modifiedon`, `reference`, `note`) VALUES
(371, 275, 187, 1, '0CH', 127, 90, 10, 826.00, 20, 4130, 1000.00, 30.00, 300.00, NULL, NULL, 0.00, 18.00, 944.00, NULL, 'info@acedecors.in', '2026-06-06 08:58:09', 'info@acedecors.in', '2026-06-06 08:58:09', 'BU', 'C7'),
(370, 275, 129, 2, '9mm Boilo Plain', 41, 38, 1, 3500.00, 0, 3500, 3500.00, 0.00, 0.00, NULL, NULL, 0.00, 18.00, 3500.00, NULL, 'info@acedecors.in', '2026-06-06 08:56:37', 'info@acedecors.in', '2026-06-06 08:56:37', 'zxc', 'mnb'),
(369, 275, 188, 1, '0CH', 127, 90, 2, 474.36, 25, 474, 600.00, 33.00, 198.00, NULL, NULL, 0.00, 18.00, 531.00, NULL, 'info@acedecors.in', '2026-06-06 06:56:29', 'info@acedecors.in', '2026-06-06 06:56:29', 'BU', 'C4'),
(374, 278, 189, 1, '0CH', 130, 92, 5, 0.00, 0, 6195, 750.00, 15.00, 92.92, NULL, NULL, 0.00, 18.00, 752.25, NULL, 'info@acedecors.in', '2026-07-29 13:46:14', '', '2026-07-29 14:05:11', 'R1', 'N1'),
(378, 278, 132, 2, 'AEHF', 43, 40, 2, 7700.00, 0, 7700, 7700.00, 0.00, 0.00, NULL, NULL, 0.00, 18.00, 7700.00, NULL, 'info@acedecors.in', '2026-07-29 14:05:56', 'info@acedecors.in', '2026-07-29 14:05:56', 'R4', 'N4'),
(365, 275, 187, 1, '0CH', 127, 90, 1, 82.60, 0, 4130, 100.00, 10.00, 10.00, NULL, NULL, 16.20, 18.00, 106.20, NULL, 'info@acedecors.in', '2026-06-06 05:17:48', 'info@acedecors.in', '2026-06-06 05:17:48', 'OU', 'C5'),
(367, 275, 128, 2, '18mm Boilo Plain', 41, 38, 3, 21000.00, 0, 21000, 21000.00, 0.00, 0.00, NULL, NULL, 3780.00, 18.00, 735000.00, NULL, 'info@acedecors.in', '2026-06-06 05:17:48', 'info@acedecors.in', '2026-06-06 05:17:48', 'BU', 'C3'),
(366, 275, 128, 2, '18mm Boilo Plain', 41, 38, 2, 14000.00, 0, 14000, 14000.00, 0.00, 0.00, NULL, NULL, 2520.00, 18.00, 490000.00, NULL, 'info@acedecors.in', '2026-06-06 05:17:48', 'info@acedecors.in', '2026-06-06 05:17:48', 'BU', 'C6'),
(376, 278, 191, 1, '0CH', 130, 92, 5, 887.95, 0, 8880, 1075.00, 20.00, 215.00, NULL, NULL, 154.80, 18.00, 1014.80, NULL, 'info@acedecors.in', '2026-07-29 13:46:14', 'info@acedecors.in', '2026-07-29 13:46:14', 'R2', 'N2'),
(379, 279, 189, 1, '0CH', 130, 92, 1, 123.90, 0, 6195, 150.00, 10.00, 15.00, NULL, NULL, 24.30, 18.00, 159.30, NULL, 'info@acedecors.in', '2026-07-30 01:46:29', 'info@acedecors.in', '2026-07-30 01:46:29', 'R1', 'N1'),
(377, 278, 130, 2, 'ABR', 42, 39, 1, 3500.00, 0, 3500, 3500.00, 0.00, 0.00, NULL, NULL, 630.00, 18.00, 3500.00, NULL, 'info@acedecors.in', '2026-07-29 13:46:14', 'info@acedecors.in', '2026-07-29 13:46:14', 'R3', 'N3'),
(380, 279, 191, 1, '0CH', 130, 92, 1, 177.59, 0, 8880, 215.00, 25.00, 53.75, NULL, NULL, 29.03, 18.00, 190.28, NULL, 'info@acedecors.in', '2026-07-30 01:46:29', 'info@acedecors.in', '2026-07-30 01:46:29', 'R2', 'N2');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rotation`
--

CREATE TABLE `rotation` (
  `rotationId` int(11) NOT NULL,
  `sides` varchar(100) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedBy` varchar(100) NOT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rotation`
--

INSERT INTO `rotation` (`rotationId`, `sides`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'Left', 'info@acedecors.in', '2021-11-23 14:50:40', 'info@acedecors.in', '2025-09-06 11:45:39'),
(2, 'Right', 'info@acedecors.in', '2021-11-23 14:50:52', 'info@acedecors.in', '2025-09-06 11:45:39'),
(3, 'Top', 'info@acedecors.in', '2021-11-23 14:50:56', 'info@acedecors.in', '2025-09-06 11:45:39'),
(5, 'BY', 'info@acedecors.in', '2026-02-28 17:20:43', 'info@acedecors.in', '2026-03-30 12:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `currency` varchar(10) DEFAULT '₹',
  `hours_per_day` decimal(5,2) DEFAULT 8.00,
  `ot_multiplier` decimal(4,2) DEFAULT 1.50,
  `half_day_threshold` decimal(5,2) DEFAULT NULL,
  `weekly_off_paid` tinyint(1) DEFAULT 0,
  `time_presets` text DEFAULT NULL,
  `org_name` varchar(255) DEFAULT '',
  `org_address` text DEFAULT NULL,
  `auto_sync` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `currency`, `hours_per_day`, `ot_multiplier`, `half_day_threshold`, `weekly_off_paid`, `time_presets`, `org_name`, `org_address`, `auto_sync`, `created_at`, `updated_at`) VALUES
(1, '₹', 8.00, 1.00, 4.00, 0, '[{\"desc\":\"2 Days\",\"hours\":\"16\",\"type\":\"preset\"},{\"desc\":\"1.5 Day\",\"hours\":\"12\",\"type\":\"preset\"},{\"desc\":\"Present\",\"hours\":\"8\",\"type\":\"preset\"},{\"desc\":\"Half Day\",\"hours\":\"4\",\"type\":\"preset\"},{\"desc\":\"OT\",\"hours\":\"Present+OT\",\"type\":\"input\"}]', 'Ace Decors', '', 1, '2025-10-09 11:25:26', '2026-01-30 12:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `sliderimages`
--

CREATE TABLE `sliderimages` (
  `imageId` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alternatetext` varchar(200) NOT NULL,
  `imageCaption` varchar(500) NOT NULL,
  `modifiedBY` varchar(100) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  `fileType` enum('image','video') DEFAULT 'image',
  `videoUrl` varchar(500) DEFAULT NULL,
  `videoFile` varchar(255) DEFAULT NULL,
  `postId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sliderimages`
--

INSERT INTO `sliderimages` (`imageId`, `image`, `createdOn`, `modifiedOn`, `alternatetext`, `imageCaption`, `modifiedBY`, `createdBy`, `fileType`, `videoUrl`, `videoFile`, `postId`) VALUES
(28, 'AD-Kitchen01.jpg', '2025-09-19 21:03:54', '2025-09-19 21:03:54', 'Kitchens', 'Kitchens', 'info@acedecors.in', 'info@acedecors.in', 'image', NULL, NULL, NULL),
(29, 'AD-Wardrobe-001.jpg', '2025-09-19 21:04:24', '2025-09-19 21:04:24', 'Wardrobes', 'Wardrobes', 'info@acedecors.in', 'info@acedecors.in', 'image', NULL, NULL, NULL),
(76, 'AD-Kitchen01.jpg', '2026-06-04 11:52:29', '2026-06-04 11:52:29', 'Modular Kitchen', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 0),
(32, 'AD-Sliding Wardrobe-001.jpg', '2025-09-27 00:05:07', '2025-09-27 00:05:07', 'TopLine Sliding', 'TopLine Sliding', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 60),
(33, '', '2025-09-27 00:05:19', '2025-09-27 00:05:19', 'TopLine Sliding', 'TopLine Sliding', 'info@acedecors.in', 'info@acedecors.in', 'video', 'https://www.youtube.com/embed/dWryPSNXSv0?si=QVp_hxkjwd_-5807', '', 60),
(34, 'post1.jpg', '2025-09-27 06:45:57', '2025-09-27 06:45:57', 'Sofa', 'Sofa', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 67),
(75, 'AD-Wardrobe-001.jpg', '2026-06-04 11:50:50', '2026-06-04 11:50:50', 'Wardrobes', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 0),
(74, 'TV Unit-1.jpg', '2026-06-04 11:50:10', '2026-06-04 11:50:10', 'TV Unit', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 0),
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
(55, 'AD-Wardrobe-001.jpg', '2025-10-09 09:29:09', '2025-10-09 09:29:09', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 86),
(56, 'TV Unit.jpg', '2025-10-09 10:19:43', '2025-10-09 10:19:43', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 87),
(57, 'TV Unit-1.jpg', '2025-10-09 10:20:18', '2025-10-09 10:20:18', '', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 87),
(78, 'AD-Kitchen01.jpg', '2026-06-04 12:02:26', '2026-06-04 12:02:26', 'L Shaped Kitchen', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 88),
(77, 'AD-Sliding Wardrobe-001.jpg', '2026-06-04 11:55:51', '2026-06-04 11:55:51', 'Sliding Wardrobe', '', 'info@acedecors.in', 'info@acedecors.in', 'image', '', '', 85);

-- --------------------------------------------------------

--
-- Table structure for table `socialmediahandle`
--

CREATE TABLE `socialmediahandle` (
  `Id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `handle` varchar(500) NOT NULL,
  `icon` varchar(2000) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(500) NOT NULL,
  `modifiedBy` varchar(500) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `subcategory` (
  `subCategoryId` int(11) NOT NULL,
  `subCategoryName` varchar(200) NOT NULL,
  `subCategoryDescription` varchar(500) NOT NULL,
  `subCategoryCreatedBy` varchar(200) NOT NULL,
  `subCategoryCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `subCategoryModifiedBy` varchar(200) NOT NULL,
  `subCategoryModifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subCategoryId`, `subCategoryName`, `subCategoryDescription`, `subCategoryCreatedBy`, `subCategoryCreatedOn`, `subCategoryModifiedBy`, `subCategoryModifiedon`) VALUES
(93, 'Modular Kitchen', 'Modular Kitchen', 'info@acedecors.in', '2026-03-17 00:36:05', 'info@acedecors.in', '2026-06-04 11:59:35'),
(94, 'Wardrobes', 'Wardrobes', 'info@acedecors.in', '2026-03-17 00:37:03', 'info@acedecors.in', '2026-06-04 11:59:53'),
(96, 'TV Units', 'TV Units', 'info@acedecors.in', '2026-06-04 12:00:07', 'info@acedecors.in', '2026-06-04 12:00:07');

-- --------------------------------------------------------

--
-- Stand-in structure for view `supplierbalanceamt`
-- (See below for the actual view)
--
CREATE TABLE `supplierbalanceamt` (
`Total` decimal(33,0)
,`Id` int(11)
,`Supplier_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `suppliercontactdetails`
--

CREATE TABLE `suppliercontactdetails` (
  `contactId` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `emailId` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdon` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `suppliercontactdetails`
--

INSERT INTO `suppliercontactdetails` (`contactId`, `name`, `supplierId`, `emailId`, `designation`, `phone`, `createdby`, `modifiedby`, `modifiedon`, `createdon`) VALUES
(12, 'Contact 1', 17, 'Des@gmail.com', 'Designation1', '987654321', 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 10:20:44', '2026-07-29 10:20:44'),
(11, 'RH-EMP1', 16, 'rhemp1@gmail.com', 'Sales Head', '999999999', 'info@acedecors.in', 'info@acedecors.in', '2026-03-30 21:57:51', '2026-03-30 21:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `supplierpaymentinfo`
--

CREATE TABLE `supplierpaymentinfo` (
  `supplierpaymentId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `POID` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `received_amount` int(11) NOT NULL,
  `pending_amount` int(11) NOT NULL,
  `payment_plan` varchar(50) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `RTGS_no` varchar(100) NOT NULL,
  `cheque_img` varchar(100) NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_description` varchar(200) NOT NULL,
  `paymentPDFName` varchar(100) DEFAULT NULL,
  `modifieddate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_by` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplierpaymentinfo`
--

INSERT INTO `supplierpaymentinfo` (`supplierpaymentId`, `supplierId`, `POID`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `paymentPDFName`, `modifieddate`, `modified_by`) VALUES
(139, 18, 134, 0, 0, 0, 0, '0', '0', '', '', NULL, '0', NULL, '2026-07-30 01:50:58', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `supplierpaymentlastq`
-- (See below for the actual view)
--
CREATE TABLE `supplierpaymentlastq` (
`PaidAmt` decimal(32,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_brand_mapping`
--

CREATE TABLE `supplier_brand_mapping` (
  `supplierId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(15, 262, 'info@acedecors.in', 'info@acedecors.in', '2026-01-22 17:25:08', '2026-01-22 17:25:08'),
(16, 274, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:08:18', '2026-07-29 11:08:18'),
(17, 276, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 10:12:08', '2026-07-29 10:12:08'),
(18, 277, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:08:56', '2026-07-29 11:08:56'),
(18, 273, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:08:56', '2026-07-29 11:08:56'),
(19, 279, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 10:14:37', '2026-07-29 10:14:37'),
(16, 273, 'info@acedecors.in', 'info@acedecors.in', '2026-07-29 11:08:18', '2026-07-29 11:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `tax_table`
--

CREATE TABLE `tax_table` (
  `tax_id` int(11) NOT NULL,
  `GST` decimal(4,2) NOT NULL,
  `SGST` decimal(4,2) DEFAULT NULL,
  `CGST` decimal(4,2) DEFAULT NULL,
  `IGST` decimal(4,2) DEFAULT NULL,
  `Modified_Date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_Date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` varchar(200) NOT NULL,
  `Modified_By` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tax_table`
--

INSERT INTO `tax_table` (`tax_id`, `GST`, `SGST`, `CGST`, `IGST`, `Modified_Date`, `Created_Date`, `Created_By`, `Modified_By`) VALUES
(51, 18.00, 9.00, 9.00, NULL, '2026-03-30 12:11:58', '2026-03-30 12:11:58', 'info@acedecors.in', 'info@acedecors.in'),
(52, 18.00, NULL, NULL, 18.00, '2026-02-28 16:49:43', '2026-02-28 16:49:43', 'info@acedecors.in', 'info@acedecors.in'),
(54, 12.00, 6.00, 6.00, NULL, '2026-03-30 12:14:07', '2026-03-30 12:14:07', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `termsandconditions`
--

CREATE TABLE `termsandconditions` (
  `id` int(11) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `thickness` (
  `Thickness_Id` int(11) NOT NULL,
  `Thickness` varchar(20) NOT NULL,
  `Thickness_createdby` varchar(20) NOT NULL,
  `Thickness_modifiedby` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thickness`
--

INSERT INTO `thickness` (`Thickness_Id`, `Thickness`, `Thickness_createdby`, `Thickness_modifiedby`) VALUES
(6, '12', 'info@acedecors.in', 'info@acedecors.in'),
(5, '6', 'info@acedecors.in', 'info@acedecors.in'),
(7, '18', 'info@acedecors.in', 'info@acedecors.in'),
(8, '24', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unitId` int(11) NOT NULL,
  `unitName` varchar(200) NOT NULL,
  `unitDescription` varchar(500) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedBy` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unitId`, `unitName`, `unitDescription`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(65, 'U145', 'Unit3', '2026-03-30 12:04:08', 'info@acedecors.in', '2026-03-30 21:46:49', 'info@acedecors.in'),
(64, 'U35', 'Unit3', '2026-03-30 12:03:54', 'info@acedecors.in', '2026-07-29 10:33:44', 'info@acedecors.in'),
(63, 'U1', 'Unit1', '2026-03-30 12:03:41', 'info@acedecors.in', '2026-03-30 12:11:06', 'info@acedecors.in'),
(66, 'U200', 'Unit4', '2026-03-30 12:14:43', 'info@acedecors.in', '2026-03-30 21:47:00', 'info@acedecors.in'),
(67, 'U10', 'Unit10', '2026-03-30 23:05:59', 'info@acedecors.in', '2026-03-30 23:05:59', 'info@acedecors.in'),
(68, 'U1', 'Set', '2026-07-29 10:33:59', 'info@acedecors.in', '2026-07-29 10:33:59', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `unitsfactor`
--

CREATE TABLE `unitsfactor` (
  `unitFactorId` int(11) NOT NULL,
  `unitId` int(11) NOT NULL,
  `unitFactor` int(11) NOT NULL,
  `unitFactorDescription` varchar(500) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedBy` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `unitsfactor`
--

INSERT INTO `unitsfactor` (`unitFactorId`, `unitId`, `unitFactor`, `unitFactorDescription`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(35, 65, 145, 'Hundred Forty Five', '2026-03-30 12:05:27', 'info@acedecors.in', '2026-03-30 21:45:44', 'info@acedecors.in'),
(34, 64, 35, 'Thirty Five', '2026-03-30 12:05:13', 'info@acedecors.in', '2026-03-30 12:05:13', 'info@acedecors.in'),
(33, 63, 1, 'One', '2026-03-30 12:04:39', 'info@acedecors.in', '2026-03-30 12:04:39', 'info@acedecors.in'),
(36, 66, 200, 'Two Hundred', '2026-03-30 12:16:35', 'info@acedecors.in', '2026-03-30 12:16:35', 'info@acedecors.in'),
(38, 67, 10, 'Ten', '2026-03-30 23:06:15', 'info@acedecors.in', '2026-03-30 23:06:15', 'info@acedecors.in'),
(39, 63, 1, 'ufgytftf5', '2026-07-29 10:35:27', 'info@acedecors.in', '2026-07-29 10:35:27', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_contact` varchar(15) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_type` enum('Admin','Manager') NOT NULL,
  `user_status` enum('Enable','Disable') NOT NULL,
  `user_created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `ModifiedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `user_action_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `allowed` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_action_permissions`
--

INSERT INTO `user_action_permissions` (`id`, `user_id`, `action_id`, `allowed`) VALUES
(629, 11, 47, 1),
(628, 11, 46, 1),
(627, 11, 45, 1),
(626, 11, 44, 1),
(625, 11, 42, 1),
(624, 11, 43, 1),
(623, 11, 38, 1),
(622, 11, 37, 1),
(621, 11, 36, 1),
(620, 11, 35, 1),
(619, 11, 34, 1),
(618, 11, 33, 1),
(617, 11, 32, 1),
(616, 11, 31, 1),
(615, 11, 30, 1),
(614, 11, 29, 1),
(613, 11, 28, 1),
(612, 11, 27, 1),
(611, 11, 26, 1),
(610, 11, 25, 1),
(609, 11, 24, 1),
(608, 11, 23, 1),
(607, 11, 22, 1),
(606, 11, 21, 1),
(605, 11, 20, 1),
(604, 11, 19, 1),
(603, 11, 18, 1),
(602, 11, 17, 1),
(601, 11, 16, 1),
(600, 11, 15, 1),
(599, 11, 14, 1),
(598, 11, 13, 1),
(597, 11, 12, 1),
(596, 11, 11, 1),
(595, 11, 10, 1),
(594, 11, 9, 1),
(593, 11, 8, 1),
(592, 11, 7, 1),
(591, 11, 6, 1),
(590, 11, 5, 1),
(589, 11, 4, 1),
(588, 11, 3, 1),
(587, 11, 2, 1),
(586, 11, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `permission_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `can_read` tinyint(1) DEFAULT 0,
  `can_write` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `brand_category_mapping`
--
ALTER TABLE `brand_category_mapping`
  ADD KEY `brandId` (`brandId`),
  ADD KEY `item_categoryId` (`item_categoryId`);

--
-- Indexes for table `brand_matcat_mapping`
--
ALTER TABLE `brand_matcat_mapping`
  ADD KEY `brandId` (`brandId`),
  ADD KEY `material_categoryId` (`material_categoryId`);

--
-- Indexes for table `businessdetails`
--
ALTER TABLE `businessdetails`
  ADD PRIMARY KEY (`businessId`);

--
-- Indexes for table `business_media`
--
ALTER TABLE `business_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businessId` (`businessId`);

--
-- Indexes for table `cabinettype`
--
ALTER TABLE `cabinettype`
  ADD PRIMARY KEY (`CabinetType_Id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `categoryName` (`categoryName`);

--
-- Indexes for table `cl_dimension`
--
ALTER TABLE `cl_dimension`
  ADD PRIMARY KEY (`CLDimensionId`);

--
-- Indexes for table `cms_brands`
--
ALTER TABLE `cms_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_brand_section`
--
ALTER TABLE `cms_brand_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`companyid`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_media`
--
ALTER TABLE `content_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_content_media_content` (`content_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`),
  ADD KEY `enq_id` (`enq_id`);

--
-- Indexes for table `customerpaymentinfo`
--
ALTER TABLE `customerpaymentinfo`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `quotation_id` (`quotation_id`);

--
-- Indexes for table `designimages`
--
ALTER TABLE `designimages`
  ADD PRIMARY KEY (`designImgId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `dimensions`
--
ALTER TABLE `dimensions`
  ADD PRIMARY KEY (`dimensionsId`);

--
-- Indexes for table `eb`
--
ALTER TABLE `eb`
  ADD PRIMARY KEY (`EB_Id`);

--
-- Indexes for table `eb_lw`
--
ALTER TABLE `eb_lw`
  ADD PRIMARY KEY (`EBLW_Id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_payment`
--
ALTER TABLE `employee_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry_category`
--
ALTER TABLE `enquiry_category`
  ADD PRIMARY KEY (`enq_catid`),
  ADD UNIQUE KEY `uniq_cat_name_type` (`enq_cat_name`,`enq_cat_type`);

--
-- Indexes for table `enquiry_details`
--
ALTER TABLE `enquiry_details`
  ADD PRIMARY KEY (`enqid`);

--
-- Indexes for table `enquiry_followups`
--
ALTER TABLE `enquiry_followups`
  ADD PRIMARY KEY (`followupid`),
  ADD KEY `followup_enq_id` (`followup_enq_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finish`
--
ALTER TABLE `finish`
  ADD PRIMARY KEY (`FinishId`);

--
-- Indexes for table `general_subcategory`
--
ALTER TABLE `general_subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl`
--
ALTER TABLE `gl`
  ADD PRIMARY KEY (`GL_Id`);

--
-- Indexes for table `inputtype`
--
ALTER TABLE `inputtype`
  ADD PRIMARY KEY (`InputTypeId`);

--
-- Indexes for table `itemallocation`
--
ALTER TABLE `itemallocation`
  ADD KEY `item_stockId` (`item_stockId`),
  ADD KEY `ProjectId` (`ProjectId`);

--
-- Indexes for table `itemissues_followup`
--
ALTER TABLE `itemissues_followup`
  ADD PRIMARY KEY (`followupId`),
  ADD KEY `followup_ItemId` (`followup_ItemId`),
  ADD KEY `followupPOID` (`followupPOID`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`item_catid`);

--
-- Indexes for table `item_companydetails`
--
ALTER TABLE `item_companydetails`
  ADD PRIMARY KEY (`item_compid`);

--
-- Indexes for table `item_details`
--
ALTER TABLE `item_details`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_pricingissues`
--
ALTER TABLE `item_pricingissues`
  ADD PRIMARY KEY (`PricingIssues_Id`);

--
-- Indexes for table `item_stock`
--
ALTER TABLE `item_stock`
  ADD PRIMARY KEY (`item_stockid`),
  ADD KEY `POID` (`POID`);

--
-- Indexes for table `item_subcategory`
--
ALTER TABLE `item_subcategory`
  ADD PRIMARY KEY (`item_subcatid`),
  ADD KEY `item_catid` (`item_catid`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`Material_Id`);

--
-- Indexes for table `materialissues_followup`
--
ALTER TABLE `materialissues_followup`
  ADD PRIMARY KEY (`followup_Id`),
  ADD KEY `followup_POID` (`followup_POID`),
  ADD KEY `followup_MaterialId` (`followup_MaterialId`);

--
-- Indexes for table `material_category`
--
ALTER TABLE `material_category`
  ADD PRIMARY KEY (`material_catId`);

--
-- Indexes for table `material_pricingissues`
--
ALTER TABLE `material_pricingissues`
  ADD PRIMARY KEY (`PricingIssues_Id`);

--
-- Indexes for table `material_subcategory`
--
ALTER TABLE `material_subcategory`
  ADD PRIMARY KEY (`material_subcatId`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `module_actions`
--
ALTER TABLE `module_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postId`);

--
-- Indexes for table `postimages`
--
ALTER TABLE `postimages`
  ADD PRIMARY KEY (`postImageId`);

--
-- Indexes for table `postkeywords`
--
ALTER TABLE `postkeywords`
  ADD PRIMARY KEY (`keywordId`);

--
-- Indexes for table `privacypolicy`
--
ALTER TABLE `privacypolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `processing`
--
ALTER TABLE `processing`
  ADD PRIMARY KEY (`ProcessingId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_catid`);

--
-- Indexes for table `product_definition`
--
ALTER TABLE `product_definition`
  ADD PRIMARY KEY (`prodDefinition_Id`);

--
-- Indexes for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  ADD PRIMARY KEY (`product_subcatid`),
  ADD KEY `product_catid` (`product_catid`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projectId`),
  ADD KEY `quoteId` (`quoteId`),
  ADD KEY `custId` (`custId`);

--
-- Indexes for table `projecttasks`
--
ALTER TABLE `projecttasks`
  ADD PRIMARY KEY (`TaskId`);

--
-- Indexes for table `project_issues`
--
ALTER TABLE `project_issues`
  ADD PRIMARY KEY (`IssueId`),
  ADD KEY `followup_ProjCode` (`Issue_ProjCode`),
  ADD KEY `followup_ProjectId` (`Issue_ProjectId`);

--
-- Indexes for table `purchaseorder_lineitem`
--
ALTER TABLE `purchaseorder_lineitem`
  ADD PRIMARY KEY (`POlineitemId`),
  ADD KEY `Item_id` (`Item_id`),
  ADD KEY `POID` (`POID`),
  ADD KEY `SupplierId` (`SupplierId`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `SupplierId` (`SupplierId`),
  ADD KEY `Item_id` (`Item_id`),
  ADD KEY `ProjectId` (`ProjectId`);

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`quoteId`),
  ADD KEY `quo_enq_id` (`quo_enq_id`),
  ADD KEY `customerId` (`customerId`),
  ADD KEY `enqCatId` (`enqCatId`),
  ADD KEY `unitId` (`unitId`);

--
-- Indexes for table `quotelineitem`
--
ALTER TABLE `quotelineitem`
  ADD PRIMARY KEY (`lineItemId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `rotation`
--
ALTER TABLE `rotation`
  ADD PRIMARY KEY (`rotationId`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliderimages`
--
ALTER TABLE `sliderimages`
  ADD PRIMARY KEY (`imageId`);

--
-- Indexes for table `socialmediahandle`
--
ALTER TABLE `socialmediahandle`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subCategoryId`);

--
-- Indexes for table `suppliercontactdetails`
--
ALTER TABLE `suppliercontactdetails`
  ADD PRIMARY KEY (`contactId`),
  ADD KEY `supplierId` (`supplierId`);

--
-- Indexes for table `supplierpaymentinfo`
--
ALTER TABLE `supplierpaymentinfo`
  ADD PRIMARY KEY (`supplierpaymentId`),
  ADD KEY `supplierId` (`supplierId`),
  ADD KEY `POID` (`POID`);

--
-- Indexes for table `supplier_brand_mapping`
--
ALTER TABLE `supplier_brand_mapping`
  ADD PRIMARY KEY (`supplierId`,`brandId`);

--
-- Indexes for table `tax_table`
--
ALTER TABLE `tax_table`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `termsandconditions`
--
ALTER TABLE `termsandconditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thickness`
--
ALTER TABLE `thickness`
  ADD PRIMARY KEY (`Thickness_Id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unitId`);

--
-- Indexes for table `unitsfactor`
--
ALTER TABLE `unitsfactor`
  ADD PRIMARY KEY (`unitFactorId`),
  ADD KEY `unitId` (`unitId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_action_permissions`
--
ALTER TABLE `user_action_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `businessdetails`
--
ALTER TABLE `businessdetails`
  MODIFY `businessId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_media`
--
ALTER TABLE `business_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cabinettype`
--
ALTER TABLE `cabinettype`
  MODIFY `CabinetType_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `cl_dimension`
--
ALTER TABLE `cl_dimension`
  MODIFY `CLDimensionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms_brands`
--
ALTER TABLE `cms_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cms_brand_section`
--
ALTER TABLE `cms_brand_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `companyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `content_media`
--
ALTER TABLE `content_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `customerpaymentinfo`
--
ALTER TABLE `customerpaymentinfo`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;

--
-- AUTO_INCREMENT for table `designimages`
--
ALTER TABLE `designimages`
  MODIFY `designImgId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `dimensions`
--
ALTER TABLE `dimensions`
  MODIFY `dimensionsId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eb`
--
ALTER TABLE `eb`
  MODIFY `EB_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `eb_lw`
--
ALTER TABLE `eb_lw`
  MODIFY `EBLW_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `employee_payment`
--
ALTER TABLE `employee_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `enquiry_category`
--
ALTER TABLE `enquiry_category`
  MODIFY `enq_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `enquiry_details`
--
ALTER TABLE `enquiry_details`
  MODIFY `enqid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `enquiry_followups`
--
ALTER TABLE `enquiry_followups`
  MODIFY `followupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=375;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `finish`
--
ALTER TABLE `finish`
  MODIFY `FinishId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `general_subcategory`
--
ALTER TABLE `general_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gl`
--
ALTER TABLE `gl`
  MODIFY `GL_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inputtype`
--
ALTER TABLE `inputtype`
  MODIFY `InputTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `itemissues_followup`
--
ALTER TABLE `itemissues_followup`
  MODIFY `followupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `item_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `item_companydetails`
--
ALTER TABLE `item_companydetails`
  MODIFY `item_compid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `item_details`
--
ALTER TABLE `item_details`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `item_pricingissues`
--
ALTER TABLE `item_pricingissues`
  MODIFY `PricingIssues_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `item_stockid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `item_subcategory`
--
ALTER TABLE `item_subcategory`
  MODIFY `item_subcatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `Material_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `materialissues_followup`
--
ALTER TABLE `materialissues_followup`
  MODIFY `followup_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_category`
--
ALTER TABLE `material_category`
  MODIFY `material_catId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `material_pricingissues`
--
ALTER TABLE `material_pricingissues`
  MODIFY `PricingIssues_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_subcategory`
--
ALTER TABLE `material_subcategory`
  MODIFY `material_subcatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `module_actions`
--
ALTER TABLE `module_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `postimages`
--
ALTER TABLE `postimages`
  MODIFY `postImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `postkeywords`
--
ALTER TABLE `postkeywords`
  MODIFY `keywordId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privacypolicy`
--
ALTER TABLE `privacypolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `processing`
--
ALTER TABLE `processing`
  MODIFY `ProcessingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_definition`
--
ALTER TABLE `product_definition`
  MODIFY `prodDefinition_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  MODIFY `product_subcatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `projecttasks`
--
ALTER TABLE `projecttasks`
  MODIFY `TaskId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_issues`
--
ALTER TABLE `project_issues`
  MODIFY `IssueId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchaseorder_lineitem`
--
ALTER TABLE `purchaseorder_lineitem`
  MODIFY `POlineitemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `quoteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT for table `quotelineitem`
--
ALTER TABLE `quotelineitem`
  MODIFY `lineItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rotation`
--
ALTER TABLE `rotation`
  MODIFY `rotationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliderimages`
--
ALTER TABLE `sliderimages`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `socialmediahandle`
--
ALTER TABLE `socialmediahandle`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `suppliercontactdetails`
--
ALTER TABLE `suppliercontactdetails`
  MODIFY `contactId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplierpaymentinfo`
--
ALTER TABLE `supplierpaymentinfo`
  MODIFY `supplierpaymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `tax_table`
--
ALTER TABLE `tax_table`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `termsandconditions`
--
ALTER TABLE `termsandconditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `thickness`
--
ALTER TABLE `thickness`
  MODIFY `Thickness_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `unitsfactor`
--
ALTER TABLE `unitsfactor`
  MODIFY `unitFactorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_action_permissions`
--
ALTER TABLE `user_action_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=630;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

-- --------------------------------------------------------

--
-- Structure for view `availableqty`
--
DROP TABLE IF EXISTS `availableqty`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `availableqty`  AS SELECT sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty` AS `AvailableQty`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM (`item_stock` `s` join `itemallocation` `a`) WHERE monthname(`s`.`modifiedOn`) = monthname(current_timestamp() + interval -2 month)union select sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty` AS `AvailableQty`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where monthname(`s`.`modifiedOn`) = monthname(current_timestamp() + interval -1 month) union select sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty` AS `AvailableQty`,monthname(current_timestamp() - 1) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where monthname(`s`.`modifiedOn`) = monthname(current_timestamp() - 1)  ;

-- --------------------------------------------------------

--
-- Structure for view `customerbalanceamt`
--
DROP TABLE IF EXISTS `customerbalanceamt`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `customerbalanceamt`  AS SELECT sum(`cp`.`total_amount`) - sum(`cp`.`received_amount`) AS `Total`, `cp`.`customer_id` AS `Id`, `c`.`customerCode` AS `CustomerId` FROM (`customerpaymentinfo` `cp` join `customer` `c` on(convert(`c`.`customerCode` using utf8mb3) = `cp`.`customer_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `customerlastm`
--
DROP TABLE IF EXISTS `customerlastm`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `customerlastm`  AS SELECT count(0) AS `Customers`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM `quotation_details` WHERE monthname(`quotation_details`.`modifiedon`) = monthname(current_timestamp() + interval -2 month) AND `quotation_details`.`quo_status` = 'Approved'union select count(0) AS `Customers`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from `quotation_details` where monthname(`quotation_details`.`modifiedon`) = monthname(current_timestamp() + interval -1 month) and `quotation_details`.`quo_status` = 'Approved' union select count(0) AS `Customers`,monthname(current_timestamp() - 1) AS `MONTH` from `quotation_details` where monthname(`quotation_details`.`modifiedon`) = monthname(current_timestamp() - 1) and `quotation_details`.`quo_status` = 'Approved'  ;

-- --------------------------------------------------------

--
-- Structure for view `customerpaymentlastq`
--
DROP TABLE IF EXISTS `customerpaymentlastq`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `customerpaymentlastq`  AS SELECT sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM `customerpaymentinfo` WHERE monthname(`customerpaymentinfo`.`modifieddate`) = monthname(current_timestamp() + interval -2 month)union select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from `customerpaymentinfo` where monthname(`customerpaymentinfo`.`modifieddate`) = monthname(current_timestamp() + interval -1 month) union select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname(current_timestamp() - 1) AS `MONTH` from `customerpaymentinfo` where monthname(`customerpaymentinfo`.`modifieddate`) = monthname(current_timestamp() - 1)  ;

-- --------------------------------------------------------

--
-- Structure for view `enquirylastm`
--
DROP TABLE IF EXISTS `enquirylastm`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `enquirylastm`  AS SELECT count(0) AS `Enquiries`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM `enquiry_details` WHERE monthname(`enquiry_details`.`enq_createdOn`) = monthname(current_timestamp() + interval -2 month)union select count(0) AS `Enqueries`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from `enquiry_details` where monthname(`enquiry_details`.`enq_createdOn`) = monthname(current_timestamp() + interval -1 month) union select count(0) AS `Enqueries`,monthname(current_timestamp() - 1) AS `MONTH` from `enquiry_details` where monthname(`enquiry_details`.`enq_createdOn`) = monthname(current_timestamp() - 1)  ;

-- --------------------------------------------------------

--
-- Structure for view `inwardedlastq`
--
DROP TABLE IF EXISTS `inwardedlastq`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `inwardedlastq`  AS SELECT sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM `item_stock` WHERE monthname(`item_stock`.`modifiedOn`) = monthname(current_timestamp() + interval -2 month)union select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from `item_stock` where monthname(`item_stock`.`modifiedOn`) = monthname(current_timestamp() + interval -1 month) union select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname(current_timestamp() - 1) AS `MONTH` from `item_stock` where monthname(`item_stock`.`modifiedOn`) = monthname(current_timestamp() - 1)  ;

-- --------------------------------------------------------

--
-- Structure for view `projectslastm`
--
DROP TABLE IF EXISTS `projectslastm`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `projectslastm`  AS SELECT count(0) AS `Projects`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM `projects` WHERE `projects`.`project_status` = 'Completed' AND monthname(`projects`.`createdOn`) = monthname(current_timestamp() + interval -2 month)union select count(0) AS `Projects`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from `projects` where `projects`.`project_status` = 'Completed' and monthname(`projects`.`createdOn`) = monthname(current_timestamp() + interval -1 month) union select count(0) AS `Projects`,monthname(current_timestamp() - 1) AS `MONTH` from `projects` where `projects`.`project_status` = 'Completed' and monthname(`projects`.`createdOn`) = monthname(current_timestamp() - 1)  ;

-- --------------------------------------------------------

--
-- Structure for view `supplierbalanceamt`
--
DROP TABLE IF EXISTS `supplierbalanceamt`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `supplierbalanceamt`  AS SELECT `sp`.`total_amount`- sum(`sp`.`received_amount`) AS `Total`, `sp`.`supplierId` AS `Id`, `s`.`item_compid` AS `Supplier_id` FROM (`supplierpaymentinfo` `sp` join `item_companydetails` `s` on(convert(`s`.`item_compid` using utf8mb3) = `sp`.`supplierId`)) GROUP BY `sp`.`supplierId` ;

-- --------------------------------------------------------

--
-- Structure for view `supplierpaymentlastq`
--
DROP TABLE IF EXISTS `supplierpaymentlastq`;

CREATE ALGORITHM=UNDEFINED DEFINER=``@`localhost` SQL SECURITY DEFINER VIEW `supplierpaymentlastq`  AS SELECT sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`, monthname(current_timestamp() + interval -2 month) AS `MONTH` FROM `supplierpaymentinfo` WHERE monthname(`supplierpaymentinfo`.`modifieddate`) = monthname(current_timestamp() + interval -2 month)union select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname(current_timestamp() + interval -1 month) AS `MONTH` from `supplierpaymentinfo` where monthname(`supplierpaymentinfo`.`modifieddate`) = monthname(current_timestamp() + interval -1 month) union select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname(current_timestamp() - 1) AS `MONTH` from `supplierpaymentinfo` where monthname(`supplierpaymentinfo`.`modifieddate`) = monthname(current_timestamp() - 1)  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
