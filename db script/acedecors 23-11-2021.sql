-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 23, 2021 at 12:10 PM
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
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(200) NOT NULL,
  `brand_description` varchar(500) DEFAULT NULL,
  `brand_createdby` varchar(200) NOT NULL,
  `brand_modifiedby` varchar(200) NOT NULL,
  `brand_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `brand_modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_description`, `brand_createdby`, `brand_modifiedby`, `brand_createdon`, `brand_modifiedon`) VALUES
(13, 'Rehau', NULL, '', '', '2021-06-04 09:17:57', '2021-06-04 09:17:57'),
(8, 'Hettich', NULL, 'info@acedecors.in', 'info@acedecors.in', '2021-06-04 08:02:58', '2021-06-04 08:02:58'),
(9, 'GLO', NULL, 'info@acedecors.in', 'info@acedecors.in', '2021-06-04 08:03:06', '2021-06-04 09:17:06'),
(11, 'Green Panel', NULL, '', '', '2021-06-04 09:17:18', '2021-06-04 09:17:18'),
(12, 'Green Ply', NULL, '', '', '2021-06-04 09:17:47', '2021-06-04 09:17:47'),
(14, 'TESA', NULL, '', '', '2021-06-04 09:18:07', '2021-06-04 09:18:07'),
(16, 'ASIS', NULL, '', '', '2021-06-05 22:52:16', '2021-06-05 22:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `brand_category_mapping`
--

DROP TABLE IF EXISTS `brand_category_mapping`;
CREATE TABLE IF NOT EXISTS `brand_category_mapping` (
  `brandId` int(11) NOT NULL,
  `item_categoryId` int(11) NOT NULL,
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
(13, 65, 'info@acedecors.in', 'info@acedecors.in', '2021-11-18 15:20:50', '2021-11-18 15:20:50'),
(8, 65, 'info@acedecors.in', 'info@acedecors.in', '2021-11-18 15:20:50', '2021-11-18 15:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

DROP TABLE IF EXISTS `company_details`;
CREATE TABLE IF NOT EXISTS `company_details` (
  `companyid` int(12) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`companyid`, `company_name`, `company_address`, `company_contact`, `company_tag`, `company_branches`, `company_email`, `password`, `ModifiedDate`, `created_date`, `company_GSTIN`, `company_BankName`, `company_BankAccountNumber`, `company_BankIFSC`) VALUES
(1, 'ACE DECORS', 'Opp Dodwad Oil Mill, Lakhmanhalli PB Road, Dharwad 580004', '9742367112', 'DREAMS COME TRUE', '', 'info@acedecors.in', 'Acedecors@123', '2021-05-01 18:47:39', '2021-05-01 18:47:39', '29ABQFA0355B1ZM', 'ICICI', '142505002388', 'ICIC0001425');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customerId` int(11) NOT NULL AUTO_INCREMENT,
  `enq_id` int(11) NOT NULL,
  `customerCode` varchar(100) NOT NULL,
  `customerName` varchar(200) NOT NULL,
  `customerContactNumber` varchar(15) NOT NULL,
  `customerEmail` varchar(200) NOT NULL,
  `customerAddress` varchar(500) NOT NULL,
  `customerState` varchar(200) NOT NULL,
  `customerCity` varchar(200) NOT NULL,
  `isQuoteGenerated` tinyint(1) NOT NULL DEFAULT '0',
  `createdby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customerDOV` date NOT NULL,
  PRIMARY KEY (`customerId`),
  KEY `enq_id` (`enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `enq_id`, `customerCode`, `customerName`, `customerContactNumber`, `customerEmail`, `customerAddress`, `customerState`, `customerCity`, `isQuoteGenerated`, `createdby`, `createdon`, `modifiedby`, `modifiedon`, `customerDOV`) VALUES
(18, 17, 'AD-202111-SB18', 'Swathi B', '23456989', 'swathibk95@gmail.com', 'hubballi', 'KARNATAKA', 'hubballi', 0, 'info@acedecors.in', '2021-11-22 11:34:45', 'info@acedecors.in', '2021-11-22 11:34:45', '2021-11-22');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerbalanceamt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerbalanceamt`;
CREATE TABLE IF NOT EXISTS `customerbalanceamt` (
`Total` decimal(65,0)
,`Id` varchar(100)
,`CustomerId` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerlastm`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerlastm`;
CREATE TABLE IF NOT EXISTS `customerlastm` (
`Customers` bigint(21)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `customerpaymentinfo`
--

DROP TABLE IF EXISTS `customerpaymentinfo`;
CREATE TABLE IF NOT EXISTS `customerpaymentinfo` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(100) NOT NULL,
  `total_amount` int(100) DEFAULT NULL,
  `paid_amount` int(100) DEFAULT NULL,
  `received_amount` int(100) NOT NULL,
  `pending_amount` int(100) DEFAULT NULL,
  `payment_plan` varchar(100) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `RTGS_no` varchar(50) DEFAULT NULL,
  `cheque_img` varchar(100) NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_description` varchar(100) NOT NULL,
  `modifieddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(100) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customerpaymentinfo`
--

INSERT INTO `customerpaymentinfo` (`payment_id`, `customer_id`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `modifieddate`, `modified_by`) VALUES
(11, 'AD-202111-w6', 20000, 0, 0, 20000, '0', '0', '0', '', NULL, '0', '2021-11-16 16:44:10', '0'),
(12, 'AD-202111-SB7', 75000, 0, 0, 75000, '0', '0', '0', '', NULL, '0', '2021-11-16 17:03:43', '0'),
(10, 'AD-202111-SB5', 72000, 0, 0, 72000, '0', '0', '0', '', NULL, '0', '2021-11-16 16:35:59', '0'),
(9, 'AD-202111-SB4', 130000, 0, 0, 130000, '0', '0', '0', '', NULL, '0', '2021-11-16 16:27:18', '0'),
(5, 'AD-202109-SB3', 10000, 0, 0, 10000, '0', '0', '0', '', NULL, '0', '2021-10-08 16:38:06', '0'),
(6, 'AD-202110-Q1', 21000, 0, 0, 21000, '0', '0', '0', '', NULL, '0', '2021-10-11 12:40:38', '0'),
(7, 'AD-202110-Q1', 21000, 1000, 1000, 20000, 'Part Payment', 'Cash', '', '', '2021-10-26', 'qwertyytu', '2021-10-22 11:57:26', 'info@acedecors.in'),
(8, 'AD-202110-Q1', 21000, 3800, 2800, 17200, 'Part Payment', 'Cash', '', '', '2021-10-29', 'cash', '2021-10-22 12:02:05', 'info@acedecors.in'),
(13, 'AD-202111-SB8', 70000, 0, 0, 70000, '0', '0', '0', '', NULL, '0', '2021-11-16 17:08:10', '0'),
(14, 'AD-202111-SB9', 140000, 0, 0, 140000, '0', '0', '0', '', NULL, '0', '2021-11-16 17:12:40', '0'),
(15, 'AD-202111-SB10', 2000, 0, 0, 2000, '0', '0', '0', '', NULL, '0', '2021-11-16 17:19:47', '0'),
(16, 'AD-202111-SB11', 52000, 0, 0, 52000, '0', '0', '0', '', NULL, '0', '2021-11-16 17:23:46', '0');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerpaymentlastq`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerpaymentlastq`;
CREATE TABLE IF NOT EXISTS `customerpaymentlastq` (
`ReceivedAmt` decimal(65,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `designimages`
--

DROP TABLE IF EXISTS `designimages`;
CREATE TABLE IF NOT EXISTS `designimages` (
  `designImgId` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) NOT NULL,
  `designFilePath` varchar(200) NOT NULL,
  `designDescription` varchar(500) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`designImgId`),
  KEY `customerId` (`customerId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designimages`
--

INSERT INTO `designimages` (`designImgId`, `customerId`, `designFilePath`, `designDescription`, `createdby`, `modifiedby`, `modifiedon`, `createdon`) VALUES
(8, 3, 'unnamed.png', 'qwrty', 'info@acedecors.in', 'info@acedecors.in', '2021-10-08 15:35:35', '2021-10-08 15:35:35'),
(9, 18, 'unnamed.png', 'logo', 'info@acedecors.in', 'info@acedecors.in', '2021-11-22 11:35:27', '2021-11-22 11:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `dimensions`
--

DROP TABLE IF EXISTS `dimensions`;
CREATE TABLE IF NOT EXISTS `dimensions` (
  `dimensionsId` int(11) NOT NULL AUTO_INCREMENT,
  `dimensionsName` varchar(200) NOT NULL,
  `dimensionsDescription` varchar(500) NOT NULL,
  `length` int(11) DEFAULT NULL,
  `breadth` int(11) DEFAULT NULL,
  `thickness` int(11) DEFAULT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`dimensionsId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dimensions`
--

INSERT INTO `dimensions` (`dimensionsId`, `dimensionsName`, `dimensionsDescription`, `length`, `breadth`, `thickness`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(2, '720x560x18', '720x560x18', 720, 560, 18, '2021-06-04 06:46:18', 'info@acedecors.in', '2021-06-04 06:46:18', 'info@acedecors.in'),
(3, 'Top/Bottom', '900mm Carcase', 864, 560, 18, '2021-06-12 12:18:08', 'info@acedecors.in', '2021-06-12 12:18:08', 'info@acedecors.in'),
(4, 'Top/Bottom', '800mm Carcase', 764, 560, 18, '2021-06-12 12:18:39', 'info@acedecors.in', '2021-06-12 12:18:39', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Stand-in structure for view `enquirylastm`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `enquirylastm`;
CREATE TABLE IF NOT EXISTS `enquirylastm` (
`Enquiries` bigint(21)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_category`
--

DROP TABLE IF EXISTS `enquiry_category`;
CREATE TABLE IF NOT EXISTS `enquiry_category` (
  `enq_catid` int(11) NOT NULL AUTO_INCREMENT,
  `enq_cat_name` varchar(200) NOT NULL,
  `enq_cat_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enq_cat_createdby` varchar(200) NOT NULL,
  `enq_cat_modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enq_cat_modifiedby` varchar(200) NOT NULL,
  PRIMARY KEY (`enq_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_category`
--

INSERT INTO `enquiry_category` (`enq_catid`, `enq_cat_name`, `enq_cat_createdon`, `enq_cat_createdby`, `enq_cat_modifiedon`, `enq_cat_modifiedby`) VALUES
(82, 'Modular Wardrobes', '2021-06-10 04:06:08', '', '2021-06-10 04:06:08', ''),
(83, 'Modular Kitchen', '2021-06-10 12:27:13', '', '2021-06-10 12:27:58', '');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_details`
--

DROP TABLE IF EXISTS `enquiry_details`;
CREATE TABLE IF NOT EXISTS `enquiry_details` (
  `enqid` int(11) NOT NULL AUTO_INCREMENT,
  `enq_name` varchar(200) NOT NULL,
  `enq_email` varchar(200) NOT NULL,
  `enq_address` varchar(500) NOT NULL,
  `enq_phone` varchar(10) NOT NULL,
  `enqStatus` enum('Attended','Unattended') CHARACTER SET utf8 NOT NULL DEFAULT 'Unattended',
  `isCustomerCreated` tinyint(1) NOT NULL DEFAULT '0',
  `enq_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enq_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enq_modifiedBy` varchar(200) NOT NULL,
  `enq_preffered_contact_mode` varchar(20) NOT NULL,
  PRIMARY KEY (`enqid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_details`
--

INSERT INTO `enquiry_details` (`enqid`, `enq_name`, `enq_email`, `enq_address`, `enq_phone`, `enqStatus`, `isCustomerCreated`, `enq_createdOn`, `enq_modifiedOn`, `enq_modifiedBy`, `enq_preffered_contact_mode`) VALUES
(17, 'Swathi B', 'swathibk95@gmail.com', 'hubballi', '23456989', 'Attended', 1, '2021-11-22 11:34:39', '2021-11-22 11:34:45', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_followups`
--

DROP TABLE IF EXISTS `enquiry_followups`;
CREATE TABLE IF NOT EXISTS `enquiry_followups` (
  `followupid` int(11) NOT NULL AUTO_INCREMENT,
  `followup_enq_id` int(11) NOT NULL,
  `followup_comments` varchar(500) NOT NULL,
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(200) NOT NULL,
  PRIMARY KEY (`followupid`),
  KEY `followup_enq_id` (`followup_enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_followups`
--

INSERT INTO `enquiry_followups` (`followupid`, `followup_enq_id`, `followup_comments`, `followup_createdon`, `followup_by`) VALUES
(19, 11, 'test comments', '2021-06-04 09:27:41', '/'),
(20, 11, 'test comments 1', '2021-06-04 09:28:10', '/'),
(21, 11, '', '2021-06-05 10:24:33', 'info@acedecors.in'),
(22, 11, 'test 2', '2021-06-10 04:07:34', '/'),
(23, 12, 'test', '2021-06-10 04:08:21', '/'),
(24, 50, 'Shashi Kumar', '2021-06-10 04:15:18', '/'),
(25, 50, 'shashi kumar 2', '2021-06-10 04:15:52', '/'),
(26, 50, 'test', '2021-06-10 07:02:31', '/'),
(27, 51, 'Hello there its testing', '2021-06-10 07:53:57', 'info@acedecors.in'),
(28, 52, 'testing1', '2021-06-10 08:03:19', 'info@acedecors.in'),
(29, 51, '', '2021-06-10 08:29:27', 'info@acedecors.in'),
(30, 0, '', '2021-06-10 08:46:12', 'info@acedecors.in'),
(31, 0, '', '2021-06-10 08:49:40', '/'),
(32, 0, '', '2021-06-10 08:49:46', '/'),
(33, 54, '123 test', '2021-06-10 09:16:49', '/'),
(34, 0, '', '2021-06-24 07:35:27', 'info@acedecors.in'),
(35, 0, '', '2021-06-24 07:35:34', 'info@acedecors.in'),
(36, 0, '', '2021-06-24 07:35:38', 'info@acedecors.in'),
(37, 54, '', '2021-06-24 07:35:59', 'info@acedecors.in'),
(38, 0, '', '2021-06-24 07:36:03', 'info@acedecors.in'),
(39, 0, '', '2021-06-24 07:36:07', 'info@acedecors.in'),
(40, 0, '', '2021-06-24 07:39:07', 'info@acedecors.in'),
(41, 56, 'Construction Work in Progress', '2021-06-24 23:41:32', 'info@acedecors.in'),
(42, 12, 'test2', '2021-06-25 00:58:50', 'info@acedecors.in'),
(43, 50, 'test2', '2021-06-25 00:59:17', 'info@acedecors.in'),
(44, 50, '', '2021-06-25 01:00:29', 'info@acedecors.in'),
(45, 57, 'INITIAL CONTACT PENDING', '2021-07-07 06:04:54', 'info@acedecors.in'),
(46, 57, '', '2021-07-07 06:05:36', 'info@acedecors.in'),
(47, 56, 'dfad', '2021-09-14 16:52:45', 'info@acedecors.in'),
(48, 53, 'interested', '2021-10-08 13:09:51', 'info@acedecors.in'),
(49, 53, 'sswef', '2021-10-08 13:11:43', 'info@acedecors.in'),
(50, 53, 'wxfet', '2021-10-08 13:15:14', 'info@acedecors.in'),
(51, 53, 'fcretg', '2021-10-08 13:26:58', 'info@acedecors.in'),
(52, 1, 'rwerw', '2021-10-08 15:13:26', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `enq_cat_mapping`
--

DROP TABLE IF EXISTS `enq_cat_mapping`;
CREATE TABLE IF NOT EXISTS `enq_cat_mapping` (
  `enq_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enq_cat_mapping`
--

INSERT INTO `enq_cat_mapping` (`enq_id`, `cat_id`) VALUES
(50, 82),
(50, 3),
(57, 82),
(56, 83),
(56, 82),
(59, 82),
(1, 82),
(1, 83),
(17, 83);

-- --------------------------------------------------------

--
-- Table structure for table `itemallocation`
--

DROP TABLE IF EXISTS `itemallocation`;
CREATE TABLE IF NOT EXISTS `itemallocation` (
  `item_stockId` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `AllocatedQty` int(11) NOT NULL,
  KEY `item_stockId` (`item_stockId`),
  KEY `ProjectId` (`ProjectId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `itemissues_followup`
--

DROP TABLE IF EXISTS `itemissues_followup`;
CREATE TABLE IF NOT EXISTS `itemissues_followup` (
  `followupId` int(11) NOT NULL AUTO_INCREMENT,
  `followup_ItemId` int(11) NOT NULL,
  `followup_comments` varchar(200) NOT NULL,
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(100) NOT NULL,
  PRIMARY KEY (`followupId`),
  KEY `followup_ItemId` (`followup_ItemId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemissues_followup`
--

INSERT INTO `itemissues_followup` (`followupId`, `followup_ItemId`, `followup_comments`, `followup_createdon`, `followup_by`) VALUES
(1, 11, 'broken', '2021-10-01 16:41:09', 'info@acedecors.in'),
(2, 11, 'not  found', '2021-10-01 16:43:25', 'info@acedecors.in'),
(3, 7, 'broken', '2021-10-09 16:57:34', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

DROP TABLE IF EXISTS `item_category`;
CREATE TABLE IF NOT EXISTS `item_category` (
  `item_catid` int(11) NOT NULL AUTO_INCREMENT,
  `item_catName` varchar(200) NOT NULL,
  `item_catDescription` varchar(500) NOT NULL,
  `item_catCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_catCreatedBy` varchar(200) NOT NULL,
  `item_catModifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_catModifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`item_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`item_catid`, `item_catName`, `item_catDescription`, `item_catCreatedOn`, `item_catCreatedBy`, `item_catModifiedOn`, `item_catModifiedBy`) VALUES
(52, 'Furniture Fittings', 'Fixtures', '2021-06-04 10:41:56', '', '2021-06-04 10:41:56', ''),
(56, 'Furniture accessories', 'Furniture Accesories', '2021-06-10 05:13:47', 'info@acedecors.in', '2021-08-06 15:32:48', 'info@acedecors.in'),
(65, 'PANELS', 'Pre-laminated', '2021-11-18 15:20:50', 'info@acedecors.in', '2021-11-18 15:20:50', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `item_companydetails`
--

DROP TABLE IF EXISTS `item_companydetails`;
CREATE TABLE IF NOT EXISTS `item_companydetails` (
  `item_compid` int(11) NOT NULL AUTO_INCREMENT,
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
  `item_compCreatedBy` varchar(200) NOT NULL,
  `item_compCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_compModifiedBy` varchar(200) NOT NULL,
  `item_compModifedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_complogo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_compid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_companydetails`
--

INSERT INTO `item_companydetails` (`item_compid`, `item_compName`, `item_compContactName`, `item_compContactNumber`, `item_compDescription`, `item_compGSTIN`, `item_compAccountno`, `item_compAccountname`, `item_compaccIFSCcode`, `item_compaccMICRcode`, `item_compAddress`, `item_compCreatedBy`, `item_compCreatedOn`, `item_compModifiedBy`, `item_compModifedOn`, `item_complogo`) VALUES
(21, 'Hettich india Pvt Ltd', 'Abhishek', '+91 9999999999', 'Interior & Exterior', '29AAACH8849M1ZT', '00012334555', '00012334555', 'ICIC001234', '223344', 'Mumbai', 'info@acedecors.in', '2021-06-05 02:13:49', 'info@acedecors.in', '2021-10-11 12:25:09', 'hettich logo.gif'),
(22, 'South India Ply Distributors', 'Abhishek', '+91 9999999999', 'Company Description', '29AAACH8849M1ZT', '00012334555', '00012334555', 'ICIC001234', '223344', 'Bangalore', 'info@acedecors.in', '2021-06-05 02:17:29', 'info@acedecors.in', '2021-06-05 03:05:36', 'download.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_details`
--

DROP TABLE IF EXISTS `item_details`;
CREATE TABLE IF NOT EXISTS `item_details` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) NOT NULL,
  `item_description` varchar(500) NOT NULL,
  `item_catid` int(11) NOT NULL,
  `item_subcatid` int(11) NOT NULL,
  `item_compid` int(11) NOT NULL,
  `item_image` varchar(200) NOT NULL,
  `item_createdby` varchar(200) NOT NULL,
  `item_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_modifiedby` varchar(200) NOT NULL,
  `item_modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_HSNcode` varchar(100) NOT NULL,
  `item_ArticleNo` varchar(100) NOT NULL,
  `item_SAPId` varchar(25) DEFAULT NULL,
  `Item_OrderNumber` varchar(25) DEFAULT NULL,
  `item_Size` int(11) NOT NULL,
  `item_PackingUnit` int(11) NOT NULL,
  `item_MRP` double NOT NULL,
  `item_pp_MRP` double NOT NULL,
  `item_descriptionforcust` varchar(500) DEFAULT NULL,
  `item_GST` int(11) NOT NULL,
  `item_unit` varchar(100) NOT NULL,
  `item_unitFactor` double NOT NULL,
  `item_totalMRP` double NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_details`
--

INSERT INTO `item_details` (`item_id`, `item_name`, `item_description`, `item_catid`, `item_subcatid`, `item_compid`, `item_image`, `item_createdby`, `item_createdon`, `item_modifiedby`, `item_modifiedon`, `item_HSNcode`, `item_ArticleNo`, `item_SAPId`, `Item_OrderNumber`, `item_Size`, `item_PackingUnit`, `item_MRP`, `item_pp_MRP`, `item_descriptionforcust`, `item_GST`, `item_unit`, `item_unitFactor`, `item_totalMRP`) VALUES
(7, 'SAH130 & L H', '50N Capacity PVC White', 52, 38, 8, 'highly-durable-slim-tandem-box-582.jpg', 'info@acedecors.in', '2021-06-05 00:57:19', 'info@acedecors.in', '2021-08-17 11:36:03', '8302', '79724-l', '1001', '123456', 10, 250, 60, 6, 'White PVC', 18, '54', 2, 1500),
(11, 'Skirting - 2400mmX100mm', 'Black PVC', 52, 38, 13, '', 'info@acedecors.in', '2021-06-10 05:17:17', 'info@acedecors.in', '2021-07-22 17:30:11', '12345', 'BLB111', NULL, NULL, 1, 1, 750, 375, NULL, 18, '56', 4, 750),
(12, 'SOMBER ACACIA - 2400mmX1200mmX18mm', 'High Density Board', 65, 40, 11, '', 'info@acedecors.in', '2021-11-18 16:30:44', 'info@acedecors.in', '2021-11-18 16:30:44', '123456', 'PL1137', NULL, NULL, 20, 5, 2752, 4.3, NULL, 18, '55', 3, 688);

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

DROP TABLE IF EXISTS `item_stock`;
CREATE TABLE IF NOT EXISTS `item_stock` (
  `item_stockid` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `POID` int(11) NOT NULL,
  `InvoiceNo` int(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Unit` varchar(100) NOT NULL,
  `Price` int(100) NOT NULL,
  `TotalAmount` int(200) NOT NULL,
  `GST` varchar(50) DEFAULT NULL,
  `ReceivedQtyAmt` int(100) DEFAULT NULL,
  `ReceivedQty` int(100) DEFAULT NULL,
  `BalanceQty` int(20) DEFAULT '0',
  `stockPDFName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_stockid`),
  KEY `POID` (`POID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock`
--

INSERT INTO `item_stock` (`item_stockid`, `item_id`, `POID`, `InvoiceNo`, `Quantity`, `Unit`, `Price`, `TotalAmount`, `GST`, `ReceivedQtyAmt`, `ReceivedQty`, `BalanceQty`, `stockPDFName`) VALUES
(3, 7, 1, 78965, 20, 'Pc', 800, 16000, '18', 5000, 5, 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_subcategory`
--

DROP TABLE IF EXISTS `item_subcategory`;
CREATE TABLE IF NOT EXISTS `item_subcategory` (
  `item_subcatid` int(11) NOT NULL AUTO_INCREMENT,
  `item_catid` int(11) NOT NULL,
  `item_subcatName` varchar(200) NOT NULL,
  `item_subcatDescription` varchar(500) NOT NULL,
  `item_subcatCreatedBy` varchar(200) NOT NULL,
  `item_subcatCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_subcatModifiedBy` varchar(200) NOT NULL,
  `item_subcatModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_subcatid`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_subcategory`
--

INSERT INTO `item_subcategory` (`item_subcatid`, `item_catid`, `item_subcatName`, `item_subcatDescription`, `item_subcatCreatedBy`, `item_subcatCreatedOn`, `item_subcatModifiedBy`, `item_subcatModifiedon`) VALUES
(36, 51, 'HWR', 'Water Resistant', '', '2021-06-04 10:43:13', '', '2021-06-04 10:43:13'),
(37, 51, 'HMR', 'Water Resistant', '', '2021-06-04 10:43:35', '', '2021-06-04 10:43:35'),
(38, 52, 'Cabinet Suspension', 'Wall Mount', '', '2021-06-04 10:50:57', '', '2021-06-10 09:58:47'),
(39, 51, 'BWP', 'Water Proof', '', '2021-06-06 21:19:57', '', '2021-06-06 21:19:57'),
(40, 65, 'BWP', 'Bottom Cover', 'info@acedecors.in', '2021-06-10 05:15:07', 'info@acedecors.in', '2021-11-18 16:10:37'),
(41, 52, 'Plinth', 'Bottom Cover', '', '2021-06-10 10:16:06', '', '2021-06-10 10:16:06');

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
  `product_itemcode` varchar(100) NOT NULL,
  `product_brand` varchar(100) NOT NULL,
  `product_brandid` int(11) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_categoryid` int(11) NOT NULL,
  `product_subcategory` varchar(100) NOT NULL,
  `product_subcategoryid` int(11) NOT NULL,
  `product_unit` varchar(100) NOT NULL,
  `product_unitid` int(11) NOT NULL,
  `productCode` varchar(100) NOT NULL,
  `rotation` varchar(100) NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `product_createdby` varchar(100) NOT NULL,
  `product_modifiedby` varchar(100) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `product_catid` int(11) NOT NULL AUTO_INCREMENT,
  `product_catName` varchar(200) NOT NULL,
  `product_catDescription` varchar(200) NOT NULL,
  `product_catCreatedby` varchar(200) NOT NULL,
  `product_catModifiedby` varchar(200) NOT NULL,
  `product_catCreatedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_catmodifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_catid`, `product_catName`, `product_catDescription`, `product_catCreatedby`, `product_catModifiedby`, `product_catCreatedon`, `product_catmodifiedon`) VALUES
(1, 'Modular Kitchen', 'Cabinets For Kitchen', '', '', '2021-06-04 10:54:22', '2021-06-04 10:54:22'),
(2, 'Wardrobe', 'Cabinets For Bedroom', '', '', '2021-06-06 21:16:42', '2021-06-06 21:16:42'),
(3, '123', '345', '', '', '2021-06-07 06:46:16', '2021-06-07 06:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategory`
--

DROP TABLE IF EXISTS `product_subcategory`;
CREATE TABLE IF NOT EXISTS `product_subcategory` (
  `product_subcatid` int(11) NOT NULL AUTO_INCREMENT,
  `product_catid` int(11) DEFAULT NULL,
  `product_subcatName` varchar(200) NOT NULL,
  `product_subcatDescription` varchar(200) NOT NULL,
  `product_subcatCreatedby` varchar(100) NOT NULL,
  `product_subcatModifiedby` varchar(100) NOT NULL,
  `product_subcatCreatedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_subcatModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_subcatid`),
  KEY `product_catid` (`product_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`product_subcatid`, `product_catid`, `product_subcatName`, `product_subcatDescription`, `product_subcatCreatedby`, `product_subcatModifiedby`, `product_subcatCreatedon`, `product_subcatModifiedon`) VALUES
(1, 1, 'Carcase', 'Cabinets', '', '', '2021-06-04 10:55:15', '2021-06-04 10:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `projectId` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `projectslastm`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `projectslastm`;
CREATE TABLE IF NOT EXISTS `projectslastm` (
`Projects` bigint(21)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_lineitem`
--

DROP TABLE IF EXISTS `purchaseorder_lineitem`;
CREATE TABLE IF NOT EXISTS `purchaseorder_lineitem` (
  `POlineitemId` int(11) NOT NULL AUTO_INCREMENT,
  `POID` varchar(100) DEFAULT NULL,
  `Item_id` int(11) DEFAULT NULL,
  `SupplierId` int(11) NOT NULL,
  `Quantity` varchar(20) DEFAULT NULL,
  `Price` varchar(20) DEFAULT NULL,
  `TotalAmt` varchar(20) NOT NULL DEFAULT '0',
  `GST` varchar(50) NOT NULL,
  `Modified_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`POlineitemId`),
  KEY `Item_id` (`Item_id`),
  KEY `POID` (`POID`),
  KEY `SupplierId` (`SupplierId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder_lineitem`
--

INSERT INTO `purchaseorder_lineitem` (`POlineitemId`, `POID`, `Item_id`, `SupplierId`, `Quantity`, `Price`, `TotalAmt`, `GST`, `Modified_Date`) VALUES
(2, '2', 7, 21, '25', '950', '23750', '', '2021-11-16 15:35:28'),
(3, '1', 7, 22, '20', '800', '16000.00', '', '2021-11-17 11:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
CREATE TABLE IF NOT EXISTS `purchase_order` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `POcode` varchar(20) NOT NULL,
  `SupplierId` int(11) DEFAULT NULL,
  `Item_id` int(11) NOT NULL,
  `ProjectId` varchar(11) DEFAULT NULL,
  `PurchasedDate` date NOT NULL,
  `TotalAmt` int(100) DEFAULT NULL,
  `purchasePDFName` varchar(100) DEFAULT NULL,
  `Status` int(11) DEFAULT '0',
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `SupplierId` (`SupplierId`),
  KEY `Item_id` (`Item_id`),
  KEY `ProjectId` (`ProjectId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`Id`, `POcode`, `SupplierId`, `Item_id`, `ProjectId`, `PurchasedDate`, `TotalAmt`, `purchasePDFName`, `Status`, `createdon`, `Modified_date`) VALUES
(1, 'AD-202111-SIPD1', 22, 10, '', '2021-11-15', NULL, NULL, 0, '2021-11-15 14:27:10', '2021-11-15 14:27:10'),
(2, 'AD-202111-HiPL2', 21, 7, '1', '2021-11-15', NULL, NULL, 0, '2021-11-15 15:14:48', '2021-11-15 15:14:48'),
(3, 'AD-202111-SIPD3', 22, 10, '', '2021-11-17', NULL, NULL, 0, '2021-11-17 17:41:02', '2021-11-17 17:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

DROP TABLE IF EXISTS `quotation_details`;
CREATE TABLE IF NOT EXISTS `quotation_details` (
  `quoid` int(11) NOT NULL AUTO_INCREMENT,
  `quo_enq_id` int(11) NOT NULL,
  `enqCatId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `quoteCode` varchar(100) NOT NULL,
  `quoteValue` decimal(10,2) DEFAULT NULL,
  `unitId` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quoteDescription` varchar(500) DEFAULT NULL,
  `itemListName` varchar(200) DEFAULT NULL,
  `orderListName` varchar(200) DEFAULT NULL,
  `quo_type` enum('General','Bank') NOT NULL,
  `quo_pdf_name` varchar(100) DEFAULT NULL,
  `quo_createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `quo_status` enum('pending','rejected','Approved') NOT NULL DEFAULT 'pending',
  `quo_comments` varchar(500) DEFAULT NULL,
  `quo_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`quoid`),
  KEY `quo_enq_id` (`quo_enq_id`),
  KEY `customerId` (`customerId`),
  KEY `enqCatId` (`enqCatId`),
  KEY `unitId` (`unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`quoid`, `quo_enq_id`, `enqCatId`, `customerId`, `quoteCode`, `quoteValue`, `unitId`, `quantity`, `quoteDescription`, `itemListName`, `orderListName`, `quo_type`, `quo_pdf_name`, `quo_createdby`, `modifiedby`, `modifiedon`, `quo_status`, `quo_comments`, `quo_createdon`) VALUES
(1, 1, 82, 3, 'SB3-MW-01', '22000.00', 53, 42, '', '', '', 'General', 'AD-202109-SB3_PROFORMA_Invoice.pdf', 'info@acedecors.in', 'info@acedecors.in', '2021-10-27 17:04:09', 'Approved', '', '2021-10-27 17:04:09'),
(2, 5, 82, 4, 'SB4-MW-01', '130000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 16:27:18', 'Approved', '', '2021-11-16 16:27:18'),
(3, 6, 82, 5, 'SB5-MW-01', '72000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 16:35:59', 'Approved', '', '2021-11-16 16:35:59'),
(4, 3, 82, 6, 'w6-MW-01', '20000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 16:44:10', 'Approved', '', '2021-11-16 16:44:10'),
(5, 7, 82, 7, 'SB7-MW-01', '75000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 17:03:43', 'Approved', '', '2021-11-16 17:03:43'),
(6, 8, 82, 8, 'SB8-MW-01', '70000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 17:08:10', 'Approved', '', '2021-11-16 17:08:10'),
(7, 9, 83, 9, 'SB9-MK-01', '140000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 17:12:40', 'Approved', '', '2021-11-16 17:12:40'),
(8, 10, 82, 10, 'SB10-MW-01', '2000.00', 53, 100, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 17:19:47', 'Approved', '', '2021-11-16 17:19:47'),
(9, 11, 82, 11, 'SB11-MW-01', '52000.00', 53, 20, '', '', '', 'General', '', 'info@acedecors.in', 'info@acedecors.in', '2021-11-16 17:23:46', 'Approved', '', '2021-11-16 17:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `quotelineitem`
--

DROP TABLE IF EXISTS `quotelineitem`;
CREATE TABLE IF NOT EXISTS `quotelineitem` (
  `lineItemId` int(11) NOT NULL AUTO_INCREMENT,
  `quoteId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `item_catid` int(20) NOT NULL,
  `item_subcatid` int(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotelineitem`
--

INSERT INTO `quotelineitem` (`lineItemId`, `quoteId`, `itemId`, `item_catid`, `item_subcatid`, `quantity`, `amount`, `totalAmount`, `discount1`, `discount1Amt`, `discount2`, `discount2Amt`, `GSTAmount`, `GST`, `totalPrice`, `billedAmount`, `createdby`, `createdon`, `modifiedby`, `modifiedon`) VALUES
(1, 1, 7, 52, 38, 25, '150.00', '150.00', '2.00', '147.00', '0.00', '0.00', '26.46', '18.00', '173.46', NULL, 'info@acedecors.in', '2021-10-26 11:45:55', 'info@acedecors.in', '2021-10-26 11:45:55'),
(2, 1, 11, 52, 38, 27, '20250.00', '20250.00', '2.00', '19845.00', '0.00', '0.00', '3572.10', '18.00', '23417.10', NULL, 'info@acedecors.in', '2021-10-26 11:45:55', 'info@acedecors.in', '2021-10-26 11:45:55'),
(3, 1, 10, 51, 39, 10, '27520.00', '27520.00', '2.00', '26969.60', '0.00', '26969.60', '4854.53', '18.00', '31824.13', NULL, 'info@acedecors.in', '2021-10-27 12:56:02', 'info@acedecors.in', '2021-10-27 12:56:02'),
(4, 1, 11, 52, 38, 10, '7500.00', '7500.00', '1.00', '7425.00', '0.00', '7425.00', '1336.50', '18.00', '8761.50', NULL, 'info@acedecors.in', '2021-11-12 14:42:46', 'info@acedecors.in', '2021-11-12 14:42:46'),
(5, 2, 10, 51, 39, 47, '129344.00', '129344.00', '2.00', '126757.12', '0.00', '0.00', '22816.28', '18.00', '149573.40', NULL, 'info@acedecors.in', '2021-11-16 16:27:04', 'info@acedecors.in', '2021-11-16 16:27:04'),
(6, 3, 10, 51, 39, 25, '68800.00', '68800.00', '2.00', '67424.00', '0.00', '0.00', '12136.32', '18.00', '79560.32', NULL, 'info@acedecors.in', '2021-11-16 16:35:43', 'info@acedecors.in', '2021-11-16 16:35:43'),
(7, 4, 11, 52, 38, 25, '18750.00', '18750.00', '2.00', '18375.00', '0.00', '0.00', '3307.50', '18.00', '21682.50', NULL, 'info@acedecors.in', '2021-11-16 16:43:53', 'info@acedecors.in', '2021-11-16 16:43:53'),
(8, 5, 10, 51, 39, 25, '68800.00', '68800.00', '2.00', '67424.00', '0.00', '0.00', '12136.32', '18.00', '79560.32', NULL, 'info@acedecors.in', '2021-11-16 17:03:33', 'info@acedecors.in', '2021-11-16 17:03:33'),
(9, 6, 10, 51, 39, 25, '68800.00', '68800.00', '2.00', '67424.00', '0.00', '0.00', '12136.32', '18.00', '79560.32', NULL, 'info@acedecors.in', '2021-11-16 17:08:01', 'info@acedecors.in', '2021-11-16 17:08:01'),
(10, 7, 10, 51, 39, 50, '137600.00', '137600.00', '4.00', '132096.00', '0.00', '0.00', '23777.28', '18.00', '155873.28', NULL, 'info@acedecors.in', '2021-11-16 17:12:30', 'info@acedecors.in', '2021-11-16 17:12:30'),
(11, 8, 7, 52, 38, 168, '1008.00', '1008.00', '2.00', '399.84', '0.00', '0.00', '71.97', '18.00', '1008.00', NULL, 'info@acedecors.in', '2021-11-16 17:19:33', 'info@acedecors.in', '2021-11-16 17:19:33'),
(12, 9, 11, 52, 38, 65, '48750.00', '48750.00', '2.00', '47775.00', '0.00', '0.00', '8599.50', '18.00', '56374.50', NULL, 'info@acedecors.in', '2021-11-16 17:23:38', 'info@acedecors.in', '2021-11-16 17:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `rotation`
--

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE IF NOT EXISTS `rotation` (
  `rotationId` int(11) NOT NULL AUTO_INCREMENT,
  `sides` varchar(100) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` varchar(100) NOT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rotationId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rotation`
--

INSERT INTO `rotation` (`rotationId`, `sides`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'Left', 'info@acedecors.in', '2021-11-23 14:50:40', 'info@acedecors.in', '2021-11-23 14:50:40'),
(2, 'Right', 'info@acedecors.in', '2021-11-23 14:50:52', 'info@acedecors.in', '2021-11-23 14:50:52'),
(3, 'Top', 'info@acedecors.in', '2021-11-23 14:50:56', 'info@acedecors.in', '2021-11-23 14:50:56'),
(4, 'Bottom', 'info@acedecors.in', '2021-11-23 14:51:00', 'info@acedecors.in', '2021-11-23 14:51:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `supplierbalanceamt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `supplierbalanceamt`;
CREATE TABLE IF NOT EXISTS `supplierbalanceamt` (
`Total` decimal(65,0)
,`Id` int(11)
,`Supplier_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `suppliercontactdetails`
--

DROP TABLE IF EXISTS `suppliercontactdetails`;
CREATE TABLE IF NOT EXISTS `suppliercontactdetails` (
  `contactId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `emailId` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`contactId`),
  KEY `supplierId` (`supplierId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliercontactdetails`
--

INSERT INTO `suppliercontactdetails` (`contactId`, `name`, `supplierId`, `emailId`, `designation`, `phone`, `createdby`, `modifiedby`, `modifiedon`, `createdon`) VALUES
(9, 'Shashi', 21, 'shashi@gmail.com', 'Sales', '9999999999', 'info@acedecors.in', 'info@acedecors.in', '2021-06-11 22:53:33', '2021-06-11 22:53:33'),
(6, 'Athar Shaikh', 22, 'atharshaikh1@gmail.com', 'Manager', '8007961759', 'ACE DECORS', 'ACE DECORS', '2021-06-11 02:20:26', '2021-06-11 02:20:26'),
(8, 'Reyaz', 21, 'ajayh@gmail.com', 'ASM', '9888888888', 'info@acedecors.in', 'info@acedecors.in', '2021-06-11 22:52:48', '2021-06-11 22:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `supplierpaymentinfo`
--

DROP TABLE IF EXISTS `supplierpaymentinfo`;
CREATE TABLE IF NOT EXISTS `supplierpaymentinfo` (
  `supplierpaymentId` int(11) NOT NULL AUTO_INCREMENT,
  `supplierId` int(11) NOT NULL,
  `POID` int(11) NOT NULL,
  `total_amount` int(100) NOT NULL,
  `paid_amount` int(100) NOT NULL,
  `received_amount` int(100) NOT NULL,
  `pending_amount` int(100) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierpaymentinfo`
--

INSERT INTO `supplierpaymentinfo` (`supplierpaymentId`, `supplierId`, `POID`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `paymentPDFName`, `modifieddate`, `modified_by`) VALUES
(1, 22, 1, 16000, 0, 0, 16000, '0', '0', '', '', NULL, '0', NULL, '2021-11-15 14:40:46', ''),
(2, 21, 2, 23750, 0, 0, 23750, '0', '0', '', '', NULL, '0', NULL, '2021-11-16 15:35:28', ''),
(3, 22, 1, 16000, 1000, 1000, 15000, 'Part Payment', 'Cash', '', '', '2021-11-23', 'cash', NULL, '2021-11-16 15:35:58', 'info@acedecors.in'),
(4, 22, 1, 16000, 16000, 15000, 0, 'Full Payment', 'Cash', '', '', NULL, 'cash', NULL, '2021-11-17 11:04:03', 'info@acedecors.in'),
(6, 21, 2, 23750, 1000, 1000, 22750, 'Part Payment', 'Cash', '', '', '2021-11-27', 'cash', NULL, '2021-11-20 13:08:19', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Stand-in structure for view `supplierpaymentlastq`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `supplierpaymentlastq`;
CREATE TABLE IF NOT EXISTS `supplierpaymentlastq` (
`PaidAmt` decimal(65,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_brand_mapping`
--

DROP TABLE IF EXISTS `supplier_brand_mapping`;
CREATE TABLE IF NOT EXISTS `supplier_brand_mapping` (
  `supplierId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_brand_mapping`
--

INSERT INTO `supplier_brand_mapping` (`supplierId`, `brandId`, `createdby`, `modifiedby`, `createdon`, `modifiedon`) VALUES
(20, 9, '', '', '2021-06-05 00:16:06', '2021-06-05 00:16:06'),
(22, 13, '', '', '2021-11-06 15:15:35', '2021-11-06 15:15:35'),
(21, 8, '', '', '2021-10-11 12:25:09', '2021-10-11 12:25:09'),
(22, 11, '', '', '2021-11-06 15:15:35', '2021-11-06 15:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `tax_table`
--

DROP TABLE IF EXISTS `tax_table`;
CREATE TABLE IF NOT EXISTS `tax_table` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `GST` decimal(4,2) NOT NULL,
  `SGST` decimal(4,2) DEFAULT NULL,
  `CGST` decimal(4,2) DEFAULT NULL,
  `IGST` decimal(4,2) DEFAULT NULL,
  `Modified_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_By` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Modified_By` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tax_table`
--

INSERT INTO `tax_table` (`tax_id`, `GST`, `SGST`, `CGST`, `IGST`, `Modified_Date`, `Created_Date`, `Created_By`, `Modified_By`) VALUES
(3, '18.00', '9.00', '9.00', NULL, '2021-06-03 22:16:41', '2021-06-03 22:16:41', '', 'info@acedecors.in'),
(4, '12.00', '6.00', '6.00', NULL, '2021-06-04 02:57:48', '2021-06-04 02:57:48', '', 'info@acedecors.in'),
(5, '18.00', NULL, NULL, '18.00', '2021-06-04 02:57:55', '2021-06-04 02:57:55', '', 'info@acedecors.in'),
(6, '12.00', NULL, NULL, '12.00', '2021-06-04 02:58:01', '2021-06-04 02:58:01', '', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `unitId` int(11) NOT NULL AUTO_INCREMENT,
  `unitName` varchar(200) NOT NULL,
  `unitDescription` varchar(500) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unitId`, `unitName`, `unitDescription`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(53, 'mm', 'milimeter', '2021-06-04 02:59:06', 'info@acedecors.in', '2021-06-04 02:59:06', 'info@acedecors.in'),
(54, 'Pc', 'Piece', '2021-06-04 02:59:20', '', '2021-06-04 10:47:10', ''),
(55, 'sft', 'square feet', '2021-06-05 10:52:13', 'info@acedecors.in', '2021-06-05 10:52:13', 'info@acedecors.in'),
(56, 'Len', 'Length', '2021-06-05 22:40:49', '', '2021-06-05 22:40:49', '');

-- --------------------------------------------------------

--
-- Table structure for table `unitsfactor`
--

DROP TABLE IF EXISTS `unitsfactor`;
CREATE TABLE IF NOT EXISTS `unitsfactor` (
  `unitFactorId` int(11) NOT NULL AUTO_INCREMENT,
  `unitId` int(11) NOT NULL,
  `unitFactor` int(11) NOT NULL,
  `unitFactorDescription` varchar(500) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(200) NOT NULL,
  `modifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` varchar(200) NOT NULL,
  PRIMARY KEY (`unitFactorId`),
  KEY `unitId` (`unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unitsfactor`
--

INSERT INTO `unitsfactor` (`unitFactorId`, `unitId`, `unitFactor`, `unitFactorDescription`, `createdOn`, `createdBy`, `modifiedOn`, `modifiedBy`) VALUES
(2, 54, 1, 'test', '2021-06-04 06:45:31', '', '2021-06-04 10:50:10', ''),
(3, 55, 32, 'test', '2021-06-05 10:53:01', 'info@acedecors.in', '2021-06-05 10:53:01', 'info@acedecors.in'),
(4, 56, 2, 'test', '2021-06-05 22:41:11', '', '2021-06-05 22:41:11', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(12) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL,
  `user_contact` varchar(15) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_type` enum('Admin','Manager') NOT NULL,
  `user_status` enum('Enable','Disable') NOT NULL,
  `user_created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_contact`, `user_email`, `user_password`, `user_type`, `user_status`, `user_created_on`, `ModifiedDate`) VALUES
(2, 'info@acedecors.in', '9742367112', 'info@acedecors.in', 'Acedecors@123', 'Admin', 'Enable', '2021-05-01 18:47:39', '2021-05-01 18:47:39');

-- --------------------------------------------------------

--
-- Structure for view `customerbalanceamt`
--
DROP TABLE IF EXISTS `customerbalanceamt`;

DROP VIEW IF EXISTS `customerbalanceamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerbalanceamt`  AS  (select (`cp`.`total_amount` - sum(`cp`.`received_amount`)) AS `Total`,`cp`.`customer_id` AS `Id`,`c`.`customerCode` AS `CustomerId` from (`customerpaymentinfo` `cp` join `customer` `c` on((convert(`c`.`customerCode` using utf8) = `cp`.`customer_id`))) group by `Id`) ;

-- --------------------------------------------------------

--
-- Structure for view `customerlastm`
--
DROP TABLE IF EXISTS `customerlastm`;

DROP VIEW IF EXISTS `customerlastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerlastm`  AS  (select count(0) AS `Customers`,monthname((now() + interval -(2) month)) AS `MONTH` from `customer` where (monthname(`customer`.`createdon`) = monthname((now() + interval -(2) month)))) union select count(0) AS `Customers`,monthname((now() + interval -(1) month)) AS `MONTH` from `customer` where (monthname(`customer`.`createdon`) = monthname((now() + interval -(1) month))) union select count(0) AS `Customers`,monthname((now() - 1)) AS `MONTH` from `customer` where (monthname(`customer`.`createdon`) = monthname((now() - 1))) ;

-- --------------------------------------------------------

--
-- Structure for view `customerpaymentlastq`
--
DROP TABLE IF EXISTS `customerpaymentlastq`;

DROP VIEW IF EXISTS `customerpaymentlastq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerpaymentlastq`  AS  (select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname((now() + interval -(2) month)) AS `MONTH` from `customerpaymentinfo` where (monthname(`customerpaymentinfo`.`modifieddate`) = monthname((now() + interval -(2) month)))) union select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname((now() + interval -(1) month)) AS `MONTH` from `customerpaymentinfo` where (monthname(`customerpaymentinfo`.`modifieddate`) = monthname((now() + interval -(1) month))) union select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname((now() - 1)) AS `MONTH` from `customerpaymentinfo` where (monthname(`customerpaymentinfo`.`modifieddate`) = monthname((now() - 1))) ;

-- --------------------------------------------------------

--
-- Structure for view `enquirylastm`
--
DROP TABLE IF EXISTS `enquirylastm`;

DROP VIEW IF EXISTS `enquirylastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `enquirylastm`  AS  (select count(0) AS `Enquiries`,monthname((now() + interval -(2) month)) AS `MONTH` from `enquiry_details` where (monthname(`enquiry_details`.`enq_createdOn`) = monthname((now() + interval -(2) month)))) union select count(0) AS `Enqueries`,monthname((now() + interval -(1) month)) AS `MONTH` from `enquiry_details` where (monthname(`enquiry_details`.`enq_createdOn`) = monthname((now() + interval -(1) month))) union select count(0) AS `Enqueries`,monthname((now() - 1)) AS `MONTH` from `enquiry_details` where (monthname(`enquiry_details`.`enq_createdOn`) = monthname((now() - 1))) ;

-- --------------------------------------------------------

--
-- Structure for view `projectslastm`
--
DROP TABLE IF EXISTS `projectslastm`;

DROP VIEW IF EXISTS `projectslastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `projectslastm`  AS  (select count(0) AS `Projects`,monthname((now() + interval -(2) month)) AS `MONTH` from `projects` where ((`projects`.`project_status` = 'Completed') and (monthname(`projects`.`createdOn`) = monthname((now() + interval -(2) month))))) union select count(0) AS `Projects`,monthname((now() + interval -(1) month)) AS `MONTH` from `projects` where ((`projects`.`project_status` = 'Completed') and (monthname(`projects`.`createdOn`) = monthname((now() + interval -(1) month)))) union select count(0) AS `Projects`,monthname((now() - 1)) AS `MONTH` from `projects` where ((`projects`.`project_status` = 'Completed') and (monthname(`projects`.`createdOn`) = monthname((now() - 1)))) ;

-- --------------------------------------------------------

--
-- Structure for view `supplierbalanceamt`
--
DROP TABLE IF EXISTS `supplierbalanceamt`;

DROP VIEW IF EXISTS `supplierbalanceamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `supplierbalanceamt`  AS  (select (`sp`.`total_amount` - sum(`sp`.`received_amount`)) AS `Total`,`sp`.`supplierId` AS `Id`,`s`.`item_compid` AS `Supplier_id` from (`supplierpaymentinfo` `sp` join `item_companydetails` `s` on((convert(`s`.`item_compid` using utf8) = `sp`.`supplierId`))) group by `Id`) ;

-- --------------------------------------------------------

--
-- Structure for view `supplierpaymentlastq`
--
DROP TABLE IF EXISTS `supplierpaymentlastq`;

DROP VIEW IF EXISTS `supplierpaymentlastq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `supplierpaymentlastq`  AS  (select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname((now() + interval -(2) month)) AS `MONTH` from `supplierpaymentinfo` where (monthname(`supplierpaymentinfo`.`modifieddate`) = monthname((now() + interval -(2) month)))) union select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname((now() + interval -(1) month)) AS `MONTH` from `supplierpaymentinfo` where (monthname(`supplierpaymentinfo`.`modifieddate`) = monthname((now() + interval -(1) month))) union select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname((now() - 1)) AS `MONTH` from `supplierpaymentinfo` where (monthname(`supplierpaymentinfo`.`modifieddate`) = monthname((now() - 1))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
