-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 31, 2022 at 11:50 AM
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
-- Stand-in structure for view `availableqty`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `availableqty`;
CREATE TABLE IF NOT EXISTS `availableqty` (
`AvailableQty` decimal(65,0)
,`MONTH` varchar(9)
);

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
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_description`, `brand_createdby`, `brand_modifiedby`, `brand_createdon`, `brand_modifiedon`) VALUES
(13, 'Rehau', NULL, '', '', '2021-06-04 09:17:57', '2021-06-04 09:17:57'),
(8, 'Hettich', NULL, 'info@acedecors.in', 'info@acedecors.in', '2021-06-04 08:02:58', '2021-06-04 08:02:58'),
(28, 'GLO', NULL, 'info@acedecors.in', 'info@acedecors.in', '2022-01-04 12:03:47', '2022-01-04 12:03:47'),
(11, 'Green Panel', NULL, '', '', '2021-06-04 09:17:18', '2021-06-04 09:17:18'),
(12, 'Green Ply', NULL, '', '', '2021-06-04 09:17:47', '2021-06-04 09:17:47'),
(24, 'TESA', NULL, 'info@acedecors.in', 'info@acedecors.in', '2021-12-25 12:43:47', '2021-12-25 12:43:47'),
(23, 'ASIS', NULL, 'info@acedecors.in', 'info@acedecors.in', '2021-12-24 14:46:46', '2022-01-03 11:51:18');

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
(8, 65, 'info@acedecors.in', 'info@acedecors.in', '2021-11-18 15:20:50', '2021-11-18 15:20:50'),
(23, 66, 'info@acedecors.in', 'info@acedecors.in', '2021-12-29 11:52:07', '2021-12-29 11:52:07'),
(28, 56, '', '', '2022-01-06 12:41:29', '2022-01-06 12:41:29'),
(24, 56, '', '', '2022-01-06 12:41:29', '2022-01-06 12:41:29'),
(8, 67, 'info@acedecors.in', 'info@acedecors.in', '2022-01-22 12:26:34', '2022-01-22 12:26:34'),
(8, 68, 'info@acedecors.in', 'info@acedecors.in', '2022-01-22 16:30:02', '2022-01-22 16:30:02'),
(8, 69, 'info@acedecors.in', 'info@acedecors.in', '2022-02-02 12:55:39', '2022-02-02 12:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `brand_matcat_mapping`
--

DROP TABLE IF EXISTS `brand_matcat_mapping`;
CREATE TABLE IF NOT EXISTS `brand_matcat_mapping` (
  `brandId` int(100) NOT NULL,
  `material_categoryId` int(100) NOT NULL,
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
(9, 1, 'info@acedecors.in', 'info@acedecors.in', '2021-12-20 17:30:46', '2021-12-20 17:30:46'),
(12, 1, 'info@acedecors.in', 'info@acedecors.in', '2021-12-20 17:31:02', '2021-12-20 17:31:02'),
(13, 2, 'info@acedecors.in', 'info@acedecors.in', '2021-12-25 12:41:07', '2021-12-25 12:41:07'),
(24, 3, 'info@acedecors.in', 'info@acedecors.in', '2021-12-25 12:45:51', '2021-12-25 12:45:51'),
(24, 4, 'info@acedecors.in', 'info@acedecors.in', '2022-02-04 15:22:38', '2022-02-04 15:22:38'),
(8, 5, 'info@acedecors.in', 'info@acedecors.in', '2022-02-25 14:57:18', '2022-02-25 14:57:18'),
(24, 5, 'info@acedecors.in', 'info@acedecors.in', '2022-02-25 14:57:18', '2022-02-25 14:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `businessdetails`
--

DROP TABLE IF EXISTS `businessdetails`;
CREATE TABLE IF NOT EXISTS `businessdetails` (
  `businessId` int(11) NOT NULL AUTO_INCREMENT,
  `businessName` varchar(250) NOT NULL,
  `businessAddress` varchar(250) NOT NULL,
  `businessContact` varchar(15) NOT NULL,
  `businessTagLine` varchar(500) NOT NULL,
  `businessEmail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ModifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `businessGSTIN` varchar(15) DEFAULT NULL,
  `logoImage` varchar(100) DEFAULT NULL,
  `aboutBusiness` longtext NOT NULL,
  PRIMARY KEY (`businessId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businessdetails`
--

INSERT INTO `businessdetails` (`businessId`, `businessName`, `businessAddress`, `businessContact`, `businessTagLine`, `businessEmail`, `password`, `ModifiedDate`, `createdDate`, `businessGSTIN`, `logoImage`, `aboutBusiness`) VALUES
(1, 'Ace Decor', '22B,Lakamanahalli Industrial Area,\r\nDharwad-580004', '+91-9742367112', 'UAE', 'info@acedecors.in', '', '2022-01-24 13:54:14', '2021-11-27 19:14:44', '22AAAAA0000A1Z5', 'Ace decor1.png', '<p><span style=\"color: #000000;\">SieMatic is globally recognised for its luxurious kitchens and quality workmanship since 1929. This remarkable international success is based on exemplary in technology, design, and quality. In the UAE, we are represented by Al Gurg Living, a company that is part of the Easa Saleh Al Gurg Group.Â </span> \n<br />\n</p>');

-- --------------------------------------------------------

--
-- Table structure for table `cabinettype`
--

DROP TABLE IF EXISTS `cabinettype`;
CREATE TABLE IF NOT EXISTS `cabinettype` (
  `CabinetType_Id` int(11) NOT NULL AUTO_INCREMENT,
  `CabinetType` varchar(100) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`CabinetType_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabinettype`
--

INSERT INTO `cabinettype` (`CabinetType_Id`, `CabinetType`, `CreatedBy`, `ModifiedBy`) VALUES
(3, 'Carcase', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(200) NOT NULL,
  `categoryDescription` varchar(500) NOT NULL,
  `categoryCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categoryCreatedBy` varchar(200) NOT NULL,
  `categoryModifiedOn` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `categorytModifiedBy` varchar(200) NOT NULL,
  `HasSubcategory` varchar(120) NOT NULL,
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `categoryName` (`categoryName`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`, `categoryDescription`, `categoryCreatedOn`, `categoryCreatedBy`, `categoryModifiedOn`, `categorytModifiedBy`, `HasSubcategory`) VALUES
(22, 'CUSTOMISATION', 'CUSTOMISATION', '2022-01-19 10:43:04', 'info@acedecors.in', '2022-01-22 16:41:35', 'info@acedecors.in', '0'),
(23, 'SHOWROOM', 'SHOWROOM', '2022-01-19 10:43:29', 'info@acedecors.in', '2022-01-21 13:12:36', 'info@acedecors.in', '0'),
(21, 'KITCHEN DESIGNS', 'KITCHEN DESIGNS', '2022-01-19 10:37:40', 'info@acedecors.in', '2022-01-21 13:12:27', 'info@acedecors.in', '0');

-- --------------------------------------------------------

--
-- Table structure for table `catsubcatmapping`
--

DROP TABLE IF EXISTS `catsubcatmapping`;
CREATE TABLE IF NOT EXISTS `catsubcatmapping` (
  `catId` int(11) NOT NULL,
  `sucatId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catsubcatmapping`
--

INSERT INTO `catsubcatmapping` (`catId`, `sucatId`) VALUES
(43, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cl_dimension`
--

DROP TABLE IF EXISTS `cl_dimension`;
CREATE TABLE IF NOT EXISTS `cl_dimension` (
  `CLDimensionId` int(11) NOT NULL AUTO_INCREMENT,
  `CL_Dimensions` varchar(50) NOT NULL,
  PRIMARY KEY (`CLDimensionId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cl_dimension`
--

INSERT INTO `cl_dimension` (`CLDimensionId`, `CL_Dimensions`) VALUES
(6, 'Length'),
(2, 'Width'),
(4, 'Depth');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `enq_id`, `customerCode`, `customerName`, `customerContactNumber`, `customerEmail`, `customerAddress`, `customerState`, `customerCountry`, `customerCity`, `isQuoteGenerated`, `createdby`, `createdon`, `modifiedby`, `modifiedon`, `customerDOV`) VALUES
(1, 26, 'AD-202205-A1', 'AAAA', '56576786', 'aaa@gmail.com', 'dharwad', 'KARNATAKA', 'India', 'hubballi', 0, 'ganeshsweets', '2022-05-23 15:46:20', 'ganeshsweets', '2022-05-23 15:46:20', '2022-05-23');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customerbalanceamt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerbalanceamt`;
CREATE TABLE IF NOT EXISTS `customerbalanceamt` (
`Total` decimal(65,0)
,`Id` varchar(100)
,`QuoteId` varchar(100)
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
  `quotation_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `total_amount` int(100) DEFAULT NULL,
  `paid_amount` int(100) DEFAULT NULL,
  `received_amount` int(100) NOT NULL,
  `pending_amount` int(100) DEFAULT NULL,
  `creditDiscount` int(100) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customerpaymentinfo`
--

INSERT INTO `customerpaymentinfo` (`payment_id`, `quotation_id`, `customer_id`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `creditDiscount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `modifieddate`, `modified_by`) VALUES
(10, 'w31-MW-01', 'AD-202203-w31', 7000, 0, 0, 7000, NULL, '0', '0', '0', '', NULL, '0', '2022-03-08 16:00:16', '0'),
(9, 'SBK27-MK-01', 'AD-202201-SBK27', 30000, 0, 0, 30000, NULL, '0', '0', '0', '', NULL, '0', '2022-03-05 14:56:06', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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
-- Table structure for table `eb`
--

DROP TABLE IF EXISTS `eb`;
CREATE TABLE IF NOT EXISTS `eb` (
  `EB_Id` int(11) NOT NULL AUTO_INCREMENT,
  `EB` varchar(50) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`EB_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eb`
--

INSERT INTO `eb` (`EB_Id`, `EB`, `CreatedBy`, `ModifiedBy`) VALUES
(1, '30mm', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `eb_lw`
--

DROP TABLE IF EXISTS `eb_lw`;
CREATE TABLE IF NOT EXISTS `eb_lw` (
  `EBLW_Id` int(11) NOT NULL AUTO_INCREMENT,
  `EB_LW` varchar(100) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`EBLW_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eb_lw`
--

INSERT INTO `eb_lw` (`EBLW_Id`, `EB_LW`, `CreatedBy`, `ModifiedBy`) VALUES
(2, '12', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

DROP TABLE IF EXISTS `enquiry`;
CREATE TABLE IF NOT EXISTS `enquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `enq_country` varchar(50) NOT NULL,
  `enq_phone` varchar(10) NOT NULL,
  `enqStatus` enum('Attended','Unattended') CHARACTER SET utf8 NOT NULL DEFAULT 'Unattended',
  `isCustomerCreated` tinyint(1) NOT NULL DEFAULT '0',
  `enq_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enq_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enq_modifiedBy` varchar(200) NOT NULL,
  `enq_preffered_contact_mode` varchar(20) NOT NULL,
  PRIMARY KEY (`enqid`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_details`
--

INSERT INTO `enquiry_details` (`enqid`, `enq_name`, `enq_email`, `enq_address`, `enq_country`, `enq_phone`, `enqStatus`, `isCustomerCreated`, `enq_createdOn`, `enq_modifiedOn`, `enq_modifiedBy`, `enq_preffered_contact_mode`) VALUES
(19, 'qwerty', 'qwerty@gmail.com', 'Dharwad', '', '7458961214', 'Attended', 0, '2022-02-18 12:45:28', '2022-03-02 17:47:56', '', ''),
(17, 'Swathi B K', 'swathibk29@gmail.com', 'hubballi', '', '23456989', 'Attended', 1, '2021-11-22 11:34:39', '2022-01-15 18:49:47', '', ''),
(26, 'AAAA', 'aaa@gmail.com', 'dharwad', 'India', '56576786', 'Attended', 1, '2022-03-03 11:19:19', '2022-05-23 15:46:20', '', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(19, 82),
(18, 83),
(50, 82),
(50, 3),
(57, 82),
(56, 83),
(56, 82),
(59, 82),
(1, 82),
(1, 83),
(17, 83),
(18, 82),
(19, 83),
(26, 82),
(26, 83);

-- --------------------------------------------------------

--
-- Table structure for table `finish`
--

DROP TABLE IF EXISTS `finish`;
CREATE TABLE IF NOT EXISTS `finish` (
  `FinishId` int(11) NOT NULL AUTO_INCREMENT,
  `Finish` varchar(59) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `ModifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`FinishId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finish`
--

INSERT INTO `finish` (`FinishId`, `Finish`, `CreatedBy`, `ModifiedBy`) VALUES
(7, 'SIF', 'info@acedecors.in', 'info@acedecors.in'),
(2, '1SIF', 'info@acedecors.in', 'info@acedecors.in'),
(3, '2SIF', 'info@acedecors.in', 'info@acedecors.in'),
(4, '3SIF', 'info@acedecors.in', 'info@acedecors.in'),
(8, 'None', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `gl`
--

DROP TABLE IF EXISTS `gl`;
CREATE TABLE IF NOT EXISTS `gl` (
  `GL_Id` int(11) NOT NULL AUTO_INCREMENT,
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
  `InputTypeId` int(11) NOT NULL AUTO_INCREMENT,
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
  `brandId` int(11) NOT NULL,
  `InputTypeId` int(11) NOT NULL,
  `ModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ModifiedBy` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inputtype_brand_mapping`
--

INSERT INTO `inputtype_brand_mapping` (`brandId`, `InputTypeId`, `ModifiedOn`, `ModifiedBy`, `CreatedBy`, `CreatedOn`) VALUES
(28, 3, '2022-01-04 14:32:02', 'info@acedecors.in', 'info@acedecors.in', '2022-01-04 12:03:47'),
(8, 2, '2022-02-04 12:52:21', 'info@acedecors.in', 'info@acedecors.in', '2022-01-13 15:49:36'),
(8, 2, '2022-02-04 12:52:21', 'info@acedecors.in', 'info@acedecors.in', '2022-01-13 15:50:08'),
(24, 2, '2022-01-13 15:52:46', 'info@acedecors.in', 'info@acedecors.in', '2022-01-13 15:52:46'),
(8, 2, '2022-02-04 12:52:21', 'info@acedecors.in', 'info@acedecors.in', '2022-01-15 18:43:44'),
(8, 2, '2022-02-04 12:47:24', 'info@acedecors.in', 'info@acedecors.in', '2022-02-04 12:47:24'),
(8, 2, '2022-02-05 12:34:45', 'info@acedecors.in', 'info@acedecors.in', '2022-02-05 12:34:45'),
(8, 1, '2022-02-05 12:35:56', 'info@acedecors.in', 'info@acedecors.in', '2022-02-05 12:35:56');

-- --------------------------------------------------------

--
-- Stand-in structure for view `inwardedlastq`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `inwardedlastq`;
CREATE TABLE IF NOT EXISTS `inwardedlastq` (
`ReceivedQty` decimal(65,0)
,`MONTH` varchar(9)
);

-- --------------------------------------------------------

--
-- Table structure for table `itemallocation`
--

DROP TABLE IF EXISTS `itemallocation`;
CREATE TABLE IF NOT EXISTS `itemallocation` (
  `item_stockId` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `InputName` varchar(50) NOT NULL,
  `AllocatedQty` int(11) NOT NULL,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  `followupPOID` int(11) NOT NULL,
  `followup_ItemId` int(11) NOT NULL,
  `followup_comments` varchar(200) NOT NULL,
  `Status` varchar(100) DEFAULT 'Open',
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(100) NOT NULL,
  PRIMARY KEY (`followupId`),
  KEY `followup_ItemId` (`followup_ItemId`),
  KEY `followupPOID` (`followupPOID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemissues_followup`
--

INSERT INTO `itemissues_followup` (`followupId`, `followupPOID`, `followup_ItemId`, `followup_comments`, `Status`, `followup_createdon`, `followup_by`) VALUES
(1, 3, 7, 'broken', 'Open', '2022-03-01 17:15:34', 'info@acedecors.in');

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
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`item_catid`, `item_catName`, `item_catDescription`, `item_catCreatedOn`, `item_catCreatedBy`, `item_catModifiedOn`, `item_catModifiedBy`) VALUES
(68, 'PANELS', 'Pre-Laminated', '2022-01-22 16:30:02', 'info@acedecors.in', '2022-01-22 16:30:02', 'info@acedecors.in'),
(69, 'Furniture', 'Furniture', '2022-02-02 12:55:39', 'info@acedecors.in', '2022-02-02 12:55:39', 'info@acedecors.in'),
(67, 'Furniture accessories', 'Furniture Accesories', '2022-01-22 12:26:34', 'info@acedecors.in', '2022-01-22 12:26:34', 'info@acedecors.in');

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_details`
--

INSERT INTO `item_details` (`item_id`, `item_name`, `item_description`, `item_catid`, `item_subcatid`, `item_compid`, `item_image`, `item_createdby`, `item_createdon`, `item_modifiedby`, `item_modifiedon`, `item_HSNcode`, `item_ArticleNo`, `item_SAPId`, `Item_OrderNumber`, `item_Size`, `item_PackingUnit`, `item_MRP`, `item_pp_MRP`, `item_descriptionforcust`, `item_GST`, `item_unit`, `item_unitFactor`, `item_totalMRP`) VALUES
(7, 'SAH130 & L H', '50N Capacity PVC White', 69, 2, 8, 'highly-durable-slim-tandem-box-582.jpg', 'info@acedecors.in', '2021-06-05 00:57:19', 'info@acedecors.in', '2022-02-15 12:19:53', '8302', '79724-l', '1001', '123456', 10, 250, 60, 6, 'White PVC', 18, '54', 2, 1500),
(11, 'Skirting - 2400mmX100mm', 'Black PVC', 65, 40, 8, '', 'info@acedecors.in', '2021-06-10 05:17:17', 'info@acedecors.in', '2021-12-11 12:24:00', '12345', 'BLB111', NULL, NULL, 1, 1, 750, 375, NULL, 18, '56', 4, 750),
(12, 'SOMBER ACACIA - 2400mmX1200mmX18mm', 'High Density Board', 68, 1, 8, '', 'info@acedecors.in', '2021-11-18 16:30:44', 'info@acedecors.in', '2022-02-05 12:41:44', '123456', 'PL1137', NULL, NULL, 20, 5, 2752, 4.3, NULL, 18, '55', 3, 688);

-- --------------------------------------------------------

--
-- Table structure for table `item_pricingissues`
--

DROP TABLE IF EXISTS `item_pricingissues`;
CREATE TABLE IF NOT EXISTS `item_pricingissues` (
  `PricingIssues_Id` int(11) NOT NULL AUTO_INCREMENT,
  `InvoiceNo` int(50) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `ItemName` varchar(100) NOT NULL,
  `POID` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL DEFAULT 'Open',
  `Issue_ModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PricingIssues_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_pricingissues`
--

INSERT INTO `item_pricingissues` (`PricingIssues_Id`, `InvoiceNo`, `SupplierName`, `ItemName`, `POID`, `Status`, `Issue_ModifiedOn`) VALUES
(1, 10026, 'Hettich india Pvt Ltd', 'SAH130 & L H', 'AD-202112-HiPL2', 'Closed', '2021-12-31 16:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

DROP TABLE IF EXISTS `item_stock`;
CREATE TABLE IF NOT EXISTS `item_stock` (
  `item_stockid` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `ItemCode` varchar(50) NOT NULL,
  `ItemName` varchar(50) NOT NULL,
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
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_stockid`),
  KEY `POID` (`POID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock`
--

INSERT INTO `item_stock` (`item_stockid`, `item_id`, `ItemCode`, `ItemName`, `POID`, `InvoiceNo`, `Quantity`, `Unit`, `Price`, `TotalAmount`, `GST`, `ReceivedQtyAmt`, `ReceivedQty`, `BalanceQty`, `stockPDFName`, `modifiedOn`) VALUES
(1, 7, '1232434', 'trgtg', 3, 10001, 65, 'Pc', 350, 22750, '18', 600, 40, 25, NULL, '2022-03-08 11:36:40');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_subcategory`
--

INSERT INTO `item_subcategory` (`item_subcatid`, `item_catid`, `item_subcatName`, `item_subcatDescription`, `item_subcatCreatedBy`, `item_subcatCreatedOn`, `item_subcatModifiedBy`, `item_subcatModifiedon`) VALUES
(1, 68, 'BWP', 'qwety', 'info@acedecors.in', '2022-02-02 15:16:01', 'info@acedecors.in', '2022-02-02 15:16:01'),
(2, 69, 'Cabinet', 'Cabinet', 'info@acedecors.in', '2022-02-15 12:15:53', 'info@acedecors.in', '2022-02-15 12:15:53');

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
  `Mat_Qty` int(100) NOT NULL,
  `Brand` varchar(100) NOT NULL,
  `Mat_Thickness` varchar(100) NOT NULL,
  `Mat_Unit` varchar(100) NOT NULL,
  `Mat_factor` double NOT NULL,
  `Mat_HSNCode` varchar(100) NOT NULL,
  `Mat_SPU` int(100) NOT NULL,
  `Mat_MRP` double NOT NULL,
  `Mat_GST` int(11) NOT NULL,
  `Mat_TotalMRP` int(100) NOT NULL,
  `Mat_PPMRP` int(100) NOT NULL,
  `Mat_Image` varchar(200) NOT NULL,
  `Mat_Grains` varchar(100) NOT NULL,
  `Mat_createdBy` varchar(100) NOT NULL,
  `Mat_modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`Material_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`Material_Id`, `Material_Name`, `Material_Code`, `Material_Description`, `Category`, `SubCategory`, `Mat_Qty`, `Brand`, `Mat_Thickness`, `Mat_Unit`, `Mat_factor`, `Mat_HSNCode`, `Mat_SPU`, `Mat_MRP`, `Mat_GST`, `Mat_TotalMRP`, `Mat_PPMRP`, `Mat_Image`, `Mat_Grains`, `Mat_createdBy`, `Mat_modifiedBy`) VALUES
(7, 'trgtg', '1232434', 'trgtg', '3', '3', 56, '24', '1', '54', 2, '3423543', 500, 1000, 18, 8929, 18, 'serviceimg.png', '1', 'info@acedecors.in', 'info@acedecors.in'),
(6, 'qwrty', '4567899', 'qwrty', '5', '5', 45, '24', '2', '54', 2, '657899787', 650, 3000, 18, 43333, 67, 'unnamed.png', '2', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `materialissues_followup`
--

DROP TABLE IF EXISTS `materialissues_followup`;
CREATE TABLE IF NOT EXISTS `materialissues_followup` (
  `followup_Id` int(11) NOT NULL AUTO_INCREMENT,
  `followup_POID` int(50) NOT NULL,
  `followup_MaterialId` int(50) NOT NULL,
  `followup_comments` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Open',
  `followup_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_by` varchar(50) NOT NULL,
  PRIMARY KEY (`followup_Id`),
  KEY `followup_POID` (`followup_POID`),
  KEY `followup_MaterialId` (`followup_MaterialId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materialissues_followup`
--

INSERT INTO `materialissues_followup` (`followup_Id`, `followup_POID`, `followup_MaterialId`, `followup_comments`, `Status`, `followup_createdon`, `followup_by`) VALUES
(1, 3, 7, 'mat Broken', 'Open', '2022-03-01 15:53:07', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `material_category`
--

DROP TABLE IF EXISTS `material_category`;
CREATE TABLE IF NOT EXISTS `material_category` (
  `material_catId` int(11) NOT NULL AUTO_INCREMENT,
  `material_catName` varchar(100) NOT NULL,
  `material_catDescription` varchar(100) NOT NULL,
  `material_catCreatedBy` varchar(100) NOT NULL,
  `material_catCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `material_catModifiedBy` varchar(50) NOT NULL,
  `material_catModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`material_catId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_category`
--

INSERT INTO `material_category` (`material_catId`, `material_catName`, `material_catDescription`, `material_catCreatedBy`, `material_catCreatedOn`, `material_catModifiedBy`, `material_catModifiedOn`) VALUES
(3, 'WWW', 'WWW', 'info@acedecors.in', '2021-12-25 12:45:51', 'info@acedecors.in', '2022-02-07 09:23:40'),
(4, 'ZZZ', 'zzz', 'info@acedecors.in', '2022-02-04 15:22:38', 'info@acedecors.in', '2022-02-04 15:22:38'),
(5, 'PLP', 'PLP', 'info@acedecors.in', '2022-02-25 14:57:18', 'info@acedecors.in', '2022-02-25 14:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `material_pricingissues`
--

DROP TABLE IF EXISTS `material_pricingissues`;
CREATE TABLE IF NOT EXISTS `material_pricingissues` (
  `PricingIssues_Id` int(11) NOT NULL AUTO_INCREMENT,
  `InvoiceNo` int(50) NOT NULL,
  `SupplierName` varchar(50) NOT NULL,
  `MaterialName` varchar(50) NOT NULL,
  `POID` varchar(20) NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Open',
  `Issue_ModifiedOn` int(11) NOT NULL,
  PRIMARY KEY (`PricingIssues_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `material_subcategory`
--

DROP TABLE IF EXISTS `material_subcategory`;
CREATE TABLE IF NOT EXISTS `material_subcategory` (
  `material_subcatId` int(11) NOT NULL AUTO_INCREMENT,
  `material_catId` int(11) NOT NULL,
  `material_subcatName` varchar(100) NOT NULL,
  `material_subcatDescription` varchar(100) NOT NULL,
  `material_subcatCreatedBy` varchar(100) NOT NULL,
  `material_subcatCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `material_subcatModifiedBy` varchar(50) NOT NULL,
  `material_subcatModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`material_subcatId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_subcategory`
--

INSERT INTO `material_subcategory` (`material_subcatId`, `material_catId`, `material_subcatName`, `material_subcatDescription`, `material_subcatCreatedBy`, `material_subcatCreatedOn`, `material_subcatModifiedBy`, `material_subcatModifiedon`) VALUES
(2, 1, 'YYY', 'yyyyyy', 'info@acedecors.in', '2021-12-22 13:19:10', 'info@acedecors.in', '2021-12-22 14:24:21'),
(3, 3, 'YYY', 'yyy', 'info@acedecors.in', '2021-12-25 15:16:50', 'info@acedecors.in', '2021-12-25 15:16:50'),
(4, 4, 'aaa', 'aAA', 'info@acedecors.in', '2022-02-04 15:22:47', 'info@acedecors.in', '2022-02-04 15:22:47'),
(5, 5, 'OSL', 'OSL', 'info@acedecors.in', '2022-02-25 14:57:35', 'info@acedecors.in', '2022-02-25 14:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `postId` int(11) NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(100) NOT NULL,
  `postUrl` varchar(100) NOT NULL,
  `LinkUnder` int(2) NOT NULL,
  `appearOnHome` varchar(1) NOT NULL DEFAULT '0',
  `postDescription` longtext CHARACTER SET latin1 NOT NULL,
  `postCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postCreatedBy` varchar(100) NOT NULL,
  `postModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titleTag` varchar(100) NOT NULL,
  `keywords` mediumtext NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`postId`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `postTitle`, `postUrl`, `LinkUnder`, `appearOnHome`, `postDescription`, `postCreatedOn`, `postCreatedBy`, `postModifiedOn`, `titleTag`, `keywords`, `modifiedBy`) VALUES
(26, 'All Kitchen Designs', '/cms/All-Kitchen-Designs', 1, '', '<p><span style=\"color: #000000;\">It is now possible to design elegant and timeless kitchens with SieMaticÂ Kitchen Style Collections. URBAN, PURE, and CLASSIC allow each space to be customised to your individuality and lifestyle. All of our kitchens are designed and manufactured in Germany as per best production practices and latest interior design trends.</span> \n<br />\n</p>\n', '2022-01-22 16:34:46', 'info@acedecors.in', '2022-01-24 12:40:46', 'All Kitchen Designs', 'All Kitchen Designs', 'info@acedecors.in'),
(27, 'Pure Kitchen Designs', '/cms/Pure-Kitchen-Designs', 1, '1', '<p><span style=\"color: #000000;\">The SieMatic PURE style collection opens up many creative choices with its graceful and modest language of form. The furniture elements from this style collection places attention on what really counts - everlasting values of the exquisite materials and precision workmanship.</span> \n<br />\n \n<br />\n<span style=\"color: #000000;\">Under the PURE Style Collection, SieMatic has introduced a cost effective series, SLC. This range comes in laminate and lacquered finishes and features all the standard SieMatic colours. This range can be used for commercial projects or kitchens withÂ tighter budgets. It has a modern design and a unique character. The design features a thin 2cm frame aroundÂ the furniture providing a further highlight. The SLC range has been developed in collaboration with the Berlin design team KINZO.</span> \n<br />\n <img src=\"https://www.siematic-uae.com/fileadmin/_processed_/2/8/csm_Pure-kitchen-design-1_f00629ea9d.jpg\" /> \n<br />\n \n<br />\n</p>\n', '2022-01-22 16:36:37', 'info@acedecors.in', '2022-01-24 15:51:51', 'Pure Kitchen Designs', 'PURE', 'info@acedecors.in'),
(28, 'Urban Kitchen Designs', '/cms/Urban-Kitchen-Designs', 1, '1', '<p><span style=\"color: #000000;\">Each object is carefully selected and juxtaposed making it unconventional. This is why the SieMatic style collection URBAN is very distinctive. Every element of the design tells a story with its aesthetics, values and contrasts which shapes the overall personality of the kitchen.Â </span> \n<br />\n</p>\n', '2022-01-22 16:38:03', 'info@acedecors.in', '2022-01-24 15:51:29', 'Urban Kitchen Designs', 'URBAN', 'info@acedecors.in'),
(29, 'Classic Kitchen Designs', '/cms/Classic-Kitchen-Designs', 1, '1', '<p><span style=\"color: #000000;\">There are endless possibilities when it comes to the SieMatic CLASSIC collection. The furniture concepts go beyond the traditional kitchen design. SieMatic has brought to you this style and room concepts in collaboration with illustrious international designers.</span> \n<br />\n</p>\n', '2022-01-22 17:00:19', 'info@acedecors.in', '2022-01-24 15:52:14', 'Classic Kitchen Designs', 'CLASSIC', 'info@acedecors.in'),
(30, 'Design Services', '/cms/Designs-Services', 1, '', '<p><span style=\"color: #000000;\">In line with our holistic room concept, we attach great importance to a comprehensive range of services from beginning to the end. Our consultants and designers are experienced kitchen planners who are at your disposal with know-how and plenty of flexibility for your wishes, even for extraordinary projects. From design to implementation - your personal kitchen dream is in the best hands at our kitchen studio in Dubai.</span> \n<br />\n</p>\n', '2022-01-22 17:19:01', 'info@acedecors.in', '2022-01-24 11:10:27', 'Design Services', 'Design Services', 'info@acedecors.in'),
(31, 'Design Insights', '/cms/Design-Insights', 1, '', '<p><span style=\"color: #000000;\">Getting adequate design inspiration is vital. Let us provide you more insights for your next kitchen project.</span> \n<br />\n</p>\n', '2022-01-22 17:21:11', 'info@acedecors.in', '2022-01-24 11:10:42', 'Design Insights', 'Design Insights', 'info@acedecors.in'),
(32, 'Brochures', '/cms/Brochures', 1, '', '<p>Brochures \n<br />\n</p>\n', '2022-01-22 17:23:14', 'info@acedecors.in', '2022-01-24 11:12:24', 'Brochures', 'Brochures', 'info@acedecors.in'),
(33, 'Wardrobes', '/cms/Wardrobes', 1, '', '<p>Wardrobes \n<br />\n</p>\n', '2022-01-22 17:24:19', 'info@acedecors.in', '2022-01-24 11:12:41', 'Wardrobes', 'Wardrobes', 'info@acedecors.in'),
(34, 'All Kitchen Accessories', '/cms/All-Kitchen-Accessories', 1, '', '<p>xyz\n<br />\n</p>\n', '2022-01-22 17:27:48', 'info@acedecors.in', '2022-01-22 17:27:48', 'All Kitchen Accessories', 'All Kitchen Accessories', 'info@acedecors.in'),
(35, 'All Kitchen Accessories', '/cms/All-Kitchen-Accessories', 1, '', '<p><span style=\"color: #000000;\">You will discover a perfect new world behind every drawer: surprising material combinations unlike anything you\'ve ever seen or felt. A fascinating harmony of form and colour - inside and out. SieMatic has completely rethought the inner life of the kitchen from the ground up. The intelligently developed and sensitively designed details combineÂ to create an unmistakable whole: the features by which you recognize every SieMatic.</span> \n<br />\n</p>\n', '2022-01-22 17:29:31', 'info@acedecors.in', '2022-01-24 11:13:22', 'All Kitchen Accessories', 'All Kitchen Accessories', 'info@acedecors.in'),
(37, 'Colors And Materials', '/cms/Colors-And-Materials', 1, '', '<p>Colour and choice of material areÂ the most significant design components of any kitchen interior, as it subconsciously makes a first impression on our mood. The selection of colours decides if a room is seen as welcoming, spacious, luxurious, cool, or comfortable. Accomplishing a nuanced blend of the various materials and door fronts in a kitchen and making the ideal combination requires a highly sensitive use of different hues as well as an effectively thought out concept.Â \n<br />\n That is the reason the SieMatic ColourSystem was created. It offers numerous attractive matt and glossy hues, which are available through all the SieMatic programs. The 1,950 individual matte and gloss hues of the SieMatic Individual ColourSystem are also available for SQ lacquer. \n<br />\n</p>\n', '2022-01-22 17:37:59', 'info@acedecors.in', '2022-01-24 11:15:51', 'Colors And Materials', 'Colors And Materials', 'info@acedecors.in'),
(38, 'Drawers and Pullouts', '/cms/Drawers-and-Pullouts', 1, '', '<p>SieMatic drawers are flawlessÂ in both performance and aesthetics. Regardless of whether in base units or kitchen islands, no technical detail comes in between the appearance of the furniture. The drawers are strong, easy to open, and comeÂ in widths from 25 to 120 cm. They give you the opportunity of planning your kitchen details. \n<br />\n Kitchen design from the outside in: Whether you incline toward the perfectionist, urban or traditional style collection, your SieMatic kitchen designer offers three distinct systems with intriguing possibilities to design the inside of base units or islands as per your own preferences,Â elegantly planned to be in harmony with the surfaces of kitchen furniture and accessories. \n<br />\n</p>\n', '2022-01-22 17:40:18', 'info@acedecors.in', '2022-01-24 11:16:20', 'Drawers and Pullouts', 'Drawers and Pullouts', 'info@acedecors.in'),
(39, 'Kitchen Cabinets', '/cms/Kitchen-Cabinets', 1, '', '<p>The exceptionally adaptable and easy to-deal with MultiMatic interior accessories system is based around exquisite aluminum trays and frames in different widths and depths that are attached to the SieMatic multifunction track with no visible hooks. This multifunctional track can be equipped independently and practically with various MultiMatic accessories so that everything truly finds its ideal place. With the versatile MultiMatic system and professional storage planning by your SieMatic kitchen designer, you canÂ carefullyÂ plan to suit your current space. See for yourself. \n<br />\n With MultiMatic, the design philosophy of the SieMatic interior accessories for pull outs and drawers has been applied for all tall, base, and wall units. This profoundly versatile, award winning interior accessories system which is signature to SieMatic, offers a similar aesthetic that comes from a sophisticated combination of high quality materials such as aluminum, valuable woods, and fine porcelain as well as various other functions perfected down to the last detail. \n<br />\n</p>\n', '2022-01-22 17:41:19', 'info@acedecors.in', '2022-01-24 11:16:41', 'Kitchen Cabinets', 'Kitchen Cabinets', 'info@acedecors.in'),
(40, 'Kitchen Countertops', '/cms/Kitchen-Countertops', 1, '', '<p>The appearance and nature of worktops make a big difference to the overall kitchen design. Regardless of whether the space is comfortable or practical, luxurious or simple, the character of the kitchen can be emphasised or contrasted through the different types of worktop and backsplash material. There is a big range of high quality worktop designsÂ at SieMatic â€“ from the material, to the thickness, to the type of edge, you have numerous options. Even the most extravagant material is reï¬ned to such an extent at SieMatic, that it can be used for evenÂ heavy duty workÂ in the kitchen. \n<br />\n Worktops and backsplash panels of natural or composite stone will never go out of fashion as it will always upgrade the character of a kitchen. But countertops of large stone are generally offered by their fabricators in minimum design options. Interestingly, SieMatic StoneDesign offers various design options. Since these worktops comprise of a light support material, topped by a 1-cm-thick chunk of natural marble, granite, slate, limestone, volcanic stone or composite stone, or 6.5 mm ceramic. Additionally we offerÂ many options in wood, stainless steel, ceramic, and high quality laminate, which can likewise be joined with SieMatic StoneDesign. \n<br />\n</p>\n', '2022-01-22 17:44:36', 'info@acedecors.in', '2022-01-24 11:17:59', 'Kitchen Countertops', 'Kitchen Countertops', 'info@acedecors.in'),
(41, 'Kitchen Appliances', '/cms/Kitchen-Appliances', 1, '', '<p>Siemens is a high end German household appliance brand, which sets new worldwide standards when it comes to innovation, advancement and design for home appliances. Since 1967, Siemens has built a strong heritage of performance, innovation, quality, and resource-efficiency that yielded in prestigious awards such as the iF Design Award and the Red Dot Award. BetterLife has had an extremely positive partnership with BSH throughout the years.Â \n<br />\n In both function and design, Gaggenau is the brand for professionals and personifies the absolute high-end aspiration for integrated kitchen appliances. The Gaggenau brand has been a part of the BSH brand portfolio since 1994. Its history stretches back to 1683. It stands for innovative technology, durable materials, bold lines, ease of use and lasting workmanship and through its uncompromising performance sets standards for culinary and domestic culture. Gaggenau products take their lead from the requirements of a professional kitchen. The brand\'s high creative standards are confirmed by numerous design awards. \n<br />\n</p>\n', '2022-01-22 17:45:38', 'info@acedecors.in', '2022-01-24 11:18:23', 'Kitchen Appliances', 'Kitchen Appliances', 'info@acedecors.in'),
(42, 'Taps and Sinks', '/cms/Taps-and-Sinks', 1, '', '<p><span style=\"color: #000000;\">We work with world renowned brands to ensure your dream kitchen is both functional and delightful.</span> \n<br />\n</p>\n', '2022-01-22 17:47:01', 'info@acedecors.in', '2022-01-24 11:18:39', 'Taps and Sinks', 'Taps and Sinks', 'info@acedecors.in'),
(43, 'Flooring Solutions', '/cms/Flooring-Solutions', 1, '', '<p>From a local wooden utility goods craftsman, in the forests of southern Sweden, to a world-leading inventor and producer of modern hardwood floors;Â the 160-year history of KÃ¤hrs is the story of a strong passion for nature and for wood as a material, combined with innovative thinking and a commitment to highest quality standards. \n<br />\n Nordic Homeworx was established in 2006 by Swedish native Pauline Madani and is today the exclusive agent of KÃ¤hrs of Sweden in the UAE and Middle East, offering turnkey supply and installation services of KÃ¤hrs wood flooring for both residential and commercial clients. \n<br />\n</p>\n', '2022-01-22 17:48:37', 'info@acedecors.in', '2022-01-24 10:43:32', 'Flooring Solutions', 'Flooring Solutions', 'info@acedecors.in'),
(44, 'Lighting Solutions', '/cms/Lighting-Solutions', 1, '', '<p>LED lights are homogeneous lights. They can be dimmed and the light temperature adjusted from warm white to cold white. SieMatic spotlights are elegantly integrated in the wall cabinets or in the underside of the shelf. These are available with either halogen bulbs or energy saving LED technology. \n<br />\n The SieMatic light shelf element is truly multifaceted. It\'s various light functions - from perfect work light to atmospheric mood lighting - can be configured individually. It also offers a wide range of design solutions and can be equipped with numerous functional elements. \n<br />\n</p>\n', '2022-01-24 11:21:13', 'info@acedecors.in', '2022-01-24 14:31:46', 'Lighting Solutions', 'Lighting Solutions', 'info@acedecors.in'),
(45, 'Showroom Location', '/cms/Showroom-Location', 1, '', '<p><span style=\"color: #000000;\">Get to touch and feel samples in our showroom to make an informed choice that suits you unique needs. Experience our premium kitchens, walk-in wardrobes, range-cookers and lifestyle products with a refreshing beverage in a quiet ambience. Bring your family or your interior designer along - our showroom in Dubai has a lot to discover.</span> \n<br />\n</p>\n', '2022-01-24 11:27:52', 'info@acedecors.in', '2022-01-24 11:49:58', 'Showroom Location', 'Showroom Location', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `postcatmapping`
--

DROP TABLE IF EXISTS `postcatmapping`;
CREATE TABLE IF NOT EXISTS `postcatmapping` (
  `postId` int(11) NOT NULL,
  `catId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postcatmapping`
--

INSERT INTO `postcatmapping` (`postId`, `catId`) VALUES
(26, 21),
(30, 21),
(31, 21),
(32, 21),
(33, 21),
(35, 22),
(37, 22),
(38, 22),
(39, 22),
(40, 22),
(41, 22),
(42, 22),
(43, 22),
(44, 22),
(45, 23),
(28, 21),
(27, 21),
(29, 21);

-- --------------------------------------------------------

--
-- Table structure for table `postimages`
--

DROP TABLE IF EXISTS `postimages`;
CREATE TABLE IF NOT EXISTS `postimages` (
  `postImageId` int(11) NOT NULL AUTO_INCREMENT,
  `postImage` longblob NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdBy` varchar(100) NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  `imageAlternateText` varchar(100) NOT NULL,
  `postId` int(11) NOT NULL,
  PRIMARY KEY (`postImageId`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postimages`
--

INSERT INTO `postimages` (`postImageId`, `postImage`, `createdOn`, `modifiedOn`, `createdBy`, `modifiedBy`, `imageAlternateText`, `postId`) VALUES
(16, 0x706f7374322e6a7067, '2022-01-21 16:16:28', '2022-01-21 16:16:28', 'info@acedecors.in', 'info@acedecors.in', 'Urban', 16),
(15, 0x706f7374312e6a7067, '2022-01-21 16:14:21', '2022-01-21 16:14:21', 'info@acedecors.in', 'info@acedecors.in', 'Pure', 15),
(17, 0x706f7374332e6a7067, '2022-01-21 16:20:31', '2022-01-21 16:20:31', 'info@acedecors.in', 'info@acedecors.in', 'Classic', 17),
(21, 0x6b69746368656e2e6a7067, '2022-01-22 16:34:46', '2022-01-22 16:34:46', 'info@acedecors.in', 'info@acedecors.in', 'All Kitchen Designs', 26),
(22, 0x706f7374312e6a7067, '2022-01-22 16:36:37', '2022-01-22 16:36:37', 'info@acedecors.in', 'info@acedecors.in', 'Pure Kitchen Designs', 27),
(23, 0x706f7374322e6a7067, '2022-01-22 16:38:03', '2022-01-22 16:38:03', 'info@acedecors.in', 'info@acedecors.in', 'Urban Kitchen Designs', 28),
(24, 0x706f7374332e6a7067, '2022-01-22 17:00:19', '2022-01-22 17:00:19', 'info@acedecors.in', 'info@acedecors.in', 'Classic Kitchen Designs', 29),
(25, 0x706f737420342e6a7067, '2022-01-22 17:19:01', '2022-01-22 17:19:01', 'info@acedecors.in', 'info@acedecors.in', 'Design Services', 30),
(26, 0x30322d6b69746368656e2e6a7067, '2022-01-22 17:21:11', '2022-01-22 17:21:11', 'info@acedecors.in', 'info@acedecors.in', 'Design Insights', 31),
(27, 0x706f7374322e6a7067, '2022-01-22 17:23:14', '2022-01-22 17:23:14', 'info@acedecors.in', 'info@acedecors.in', 'Brochures', 32),
(28, 0x6b69746368656e312e6a7067, '2022-01-22 17:24:19', '2022-01-22 17:24:19', 'info@acedecors.in', 'info@acedecors.in', 'Wardrobes', 33),
(29, 0x706f7374352e6a7067, '2022-01-22 17:29:31', '2022-01-22 17:29:31', 'info@acedecors.in', 'info@acedecors.in', 'xwe', 35),
(31, 0x706f7374362e6a7067, '2022-01-22 17:37:59', '2022-01-22 17:37:59', 'info@acedecors.in', 'info@acedecors.in', 'Colors And Materials', 37),
(32, 0x70372e6a7067, '2022-01-22 17:40:18', '2022-01-22 17:40:18', 'info@acedecors.in', 'info@acedecors.in', 'Drawers and Pullouts', 38),
(33, 0x706f7374312e6a7067, '2022-01-22 17:41:19', '2022-01-22 17:41:19', 'info@acedecors.in', 'info@acedecors.in', 'Kitchen Cabinets', 39),
(34, 0x706f7374332e6a7067, '2022-01-22 17:44:36', '2022-01-22 17:44:36', 'info@acedecors.in', 'info@acedecors.in', 'Kitchen Countertops', 40),
(35, 0x706f7374322e6a7067, '2022-01-22 17:45:38', '2022-01-22 17:45:38', 'info@acedecors.in', 'info@acedecors.in', 'Kitchen Appliances', 41),
(36, 0x706f737420342e6a7067, '2022-01-22 17:47:01', '2022-01-22 17:47:01', 'info@acedecors.in', 'info@acedecors.in', 'Taps and Sinks', 42),
(37, 0x706f7374322e6a7067, '2022-01-22 17:48:37', '2022-01-22 17:48:37', 'info@acedecors.in', 'info@acedecors.in', 'Flooring Solutions', 43),
(38, 0x706f7374362e6a7067, '2022-01-24 11:21:13', '2022-01-24 11:21:13', 'info@acedecors.in', 'info@acedecors.in', 'Lighting Solutions', 44),
(39, 0x70372e6a7067, '2022-01-24 11:27:52', '2022-01-24 11:27:52', 'info@acedecors.in', 'info@acedecors.in', 'Showroom Location', 45);

-- --------------------------------------------------------

--
-- Table structure for table `postkeywords`
--

DROP TABLE IF EXISTS `postkeywords`;
CREATE TABLE IF NOT EXISTS `postkeywords` (
  `keywordId` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(200) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdBy` varchar(100) NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`keywordId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `postsubcatmapping`
--

DROP TABLE IF EXISTS `postsubcatmapping`;
CREATE TABLE IF NOT EXISTS `postsubcatmapping` (
  `postId` int(11) NOT NULL,
  `subCatId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `privacypolicy`
--

DROP TABLE IF EXISTS `privacypolicy`;
CREATE TABLE IF NOT EXISTS `privacypolicy` (
  `id` int(120) NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privacypolicy`
--

INSERT INTO `privacypolicy` (`id`, `description`) VALUES
(1, '<p> lorem ipsum lorem lorem ipsum  ipsum  lorem ipsum  lorem ipsum  lorem ipsum  lorem ipsum \n<br />\n</p>'),
(4, '<p>\n<br />\n</p>'),
(5, '<p>vgfhfhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhgvbb\n<br />\n</p>'),
(6, '<p>lorem ipsum\n<br />\n \n<br />\n</p>');

-- --------------------------------------------------------

--
-- Table structure for table `processing`
--

DROP TABLE IF EXISTS `processing`;
CREATE TABLE IF NOT EXISTS `processing` (
  `ProcessingId` int(11) NOT NULL AUTO_INCREMENT,
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
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Length` int(50) NOT NULL,
  `Width` int(50) NOT NULL,
  `Quantity` int(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_catid`, `product_catName`, `product_catDescription`, `product_catCreatedby`, `product_catModifiedby`, `product_catCreatedon`, `product_catmodifiedon`) VALUES
(1, 'Modular Kitchen', 'Cabinets For Kitchen', '', '', '2021-06-04 10:54:22', '2021-06-04 10:54:22'),
(2, 'Wardrobe', 'Cabinets For Bedroom', '', '', '2021-06-06 21:16:42', '2021-06-06 21:16:42'),
(3, '123', '345', '', '', '2021-06-07 06:46:16', '2021-06-07 06:46:16'),
(5, 'Hallway', 'Cabinets for Hallway', 'info@acedecors.in', 'info@acedecors.in', '2022-02-01 16:00:25', '2022-02-01 16:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_definition`
--

DROP TABLE IF EXISTS `product_definition`;
CREATE TABLE IF NOT EXISTS `product_definition` (
  `prodDefinition_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prod_Name` varchar(100) NOT NULL,
  `Prod_Description` varchar(100) NOT NULL,
  `Rotation` int(10) NOT NULL,
  `Override` varchar(10) NOT NULL,
  `Type` int(10) NOT NULL,
  `Finish` int(10) NOT NULL,
  `Prod_Category` int(10) NOT NULL,
  `Prod_SubCategory` int(10) NOT NULL,
  `Quantity` int(10) NOT NULL,
  `LengthValue` int(50) NOT NULL,
  `Dimension1` varchar(50) NOT NULL,
  `WidthValue` int(50) NOT NULL,
  `Dimension2` varchar(50) NOT NULL,
  `DepthValue` int(50) NOT NULL,
  `Dimension3` varchar(50) NOT NULL,
  `CLFormula` varchar(50) NOT NULL,
  `CW` varchar(50) NOT NULL,
  `GL` int(10) NOT NULL,
  `FL` varchar(50) NOT NULL,
  `BL` varchar(50) NOT NULL,
  `RL` varchar(50) NOT NULL,
  `RW` varchar(50) NOT NULL,
  `EB_LW` int(10) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`prodDefinition_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_definition`
--

INSERT INTO `product_definition` (`prodDefinition_Id`, `Prod_Name`, `Prod_Description`, `Rotation`, `Override`, `Type`, `Finish`, `Prod_Category`, `Prod_SubCategory`, `Quantity`, `LengthValue`, `Dimension1`, `WidthValue`, `Dimension2`, `DepthValue`, `Dimension3`, `CLFormula`, `CW`, `GL`, `FL`, `BL`, `RL`, `RW`, `EB_LW`, `CreatedBy`, `ModifiedBy`) VALUES
(1, 'qwerty', 'qwerty', 1, 'Yes', 3, 2, 1, 1, 20, 1, 'Length', 2, 'Width', 3, 'Depth', '1*Length-2*Width-3*Depth', '1*Length-2*Width-3*Depth', 2, 'SEB Thickness', 'PEB Thickness', 'PEB Thickness', 'SEB Thickness', 2, '', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`product_subcatid`, `product_catid`, `product_subcatName`, `product_subcatDescription`, `product_subcatCreatedby`, `product_subcatModifiedby`, `product_subcatCreatedon`, `product_subcatModifiedon`) VALUES
(1, 1, 'Carcase', 'cabinets', 'info@acedecors.in', 'info@acedecors.in', '2021-06-04 10:55:15', '2022-01-24 14:35:05');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectId`, `projectCode`, `customerName`, `custId`, `quoteId`, `project_status`, `progressNote`, `createdOn`) VALUES
(13, 'AD-PROJ-0322 -SBK13', 'Swathi B K', 'AD-202201-SBK27', 'SBK27-MK-01', 'In Progress', '', '2022-03-08 12:15:01');

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
-- Table structure for table `projecttasks`
--

DROP TABLE IF EXISTS `projecttasks`;
CREATE TABLE IF NOT EXISTS `projecttasks` (
  `TaskId` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `TaskDescription` varchar(100) NOT NULL,
  `ContactPerson` varchar(100) NOT NULL,
  `ContactNo` int(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Task_modifiedBy` varchar(100) NOT NULL,
  `Task_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Task_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Task_createdBy` varchar(100) NOT NULL,
  PRIMARY KEY (`TaskId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projecttasks`
--

INSERT INTO `projecttasks` (`TaskId`, `Date`, `TaskDescription`, `ContactPerson`, `ContactNo`, `Status`, `Task_modifiedBy`, `Task_modifiedOn`, `Task_createdOn`, `Task_createdBy`) VALUES
(1, '2021-12-11', 'qwerty', 'www', 789056545, 'Closed', 'info@acedecors.in', '2021-12-30 15:55:19', '2021-12-11 16:55:33', 'info@acedecors.in'),
(3, '2022-02-12', 'qwqr', 'rwf', 5676, 'Open', 'info@acedecors.in', '2022-02-12 12:24:34', '2022-02-12 12:24:34', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `project_issues`
--

DROP TABLE IF EXISTS `project_issues`;
CREATE TABLE IF NOT EXISTS `project_issues` (
  `IssueId` int(11) NOT NULL AUTO_INCREMENT,
  `Issue_ProjectId` int(11) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_issues`
--

INSERT INTO `project_issues` (`IssueId`, `Issue_ProjectId`, `Issue_ProjCode`, `Issue_Description`, `Issue_ContactName`, `Issue_ContactDetails`, `Status`, `Issue_createdon`, `Issue_createdby`, `Issue_modifiedby`, `issue_modifiedOn`) VALUES
(1, 13, 'AD-PROJ-0322', 'jfugjkn', 'SWATHI', '45654756', 'Open', '2022-03-07 16:13:08', 'info@acedecors.in', 'info@acedecors.in', '2022-03-07 16:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_lineitem`
--

DROP TABLE IF EXISTS `purchaseorder_lineitem`;
CREATE TABLE IF NOT EXISTS `purchaseorder_lineitem` (
  `POlineitemId` int(11) NOT NULL AUTO_INCREMENT,
  `POID` varchar(100) DEFAULT NULL,
  `Item_id` int(11) DEFAULT NULL,
  `InputName` varchar(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder_lineitem`
--

INSERT INTO `purchaseorder_lineitem` (`POlineitemId`, `POID`, `Item_id`, `InputName`, `SupplierId`, `Quantity`, `Price`, `TotalAmt`, `GST`, `Modified_Date`) VALUES
(5, '3', 7, 'trgtg', 22, '65', '350', '22750', '', '2022-03-01 14:57:30');

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
(3, 'AD-202203-SIPD3', 22, 7, '12', '2022-03-01', NULL, NULL, 0, '2022-03-01 14:57:18', '2022-03-02 12:51:20');

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
  `inputType` int(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`quoid`, `quo_enq_id`, `enqCatId`, `customerId`, `quoteCode`, `quoteValue`, `unitId`, `quantity`, `quoteDescription`, `itemListName`, `orderListName`, `quo_type`, `quo_pdf_name`, `inputType`, `quo_createdby`, `modifiedby`, `modifiedon`, `quo_status`, `quo_comments`, `quo_createdon`) VALUES
(19, 17, 83, 27, 'SBK27-MK-01', '35000.00', 53, 60, '', '', '', 'General', '', 1, 'info@acedecors.in', 'admin1', '2022-03-09 15:41:42', 'Approved', '', '2022-03-09 15:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `quotelineitem`
--

DROP TABLE IF EXISTS `quotelineitem`;
CREATE TABLE IF NOT EXISTS `quotelineitem` (
  `lineItemId` int(11) NOT NULL AUTO_INCREMENT,
  `quoteId` int(11) NOT NULL,
  `InputType` varchar(100) NOT NULL,
  `InputName` varchar(100) NOT NULL,
  `itemId` int(11) NOT NULL,
  `item_catid` int(20) NOT NULL,
  `item_subcatid` int(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `totalValue` varchar(100) DEFAULT NULL,
  `discount1` decimal(10,2) DEFAULT NULL,
  `discount1Amt` decimal(10,2) DEFAULT NULL,
  `GSTAmount` decimal(10,2) NOT NULL,
  `GST` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `billedAmount` decimal(10,2) DEFAULT NULL,
  `createdby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lineItemId`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotelineitem`
--

INSERT INTO `quotelineitem` (`lineItemId`, `quoteId`, `InputType`, `InputName`, `itemId`, `item_catid`, `item_subcatid`, `quantity`, `amount`, `totalAmount`, `value`, `totalValue`, `discount1`, `discount1Amt`, `GSTAmount`, `GST`, `totalPrice`, `billedAmount`, `createdby`, `createdon`, `modifiedby`, `modifiedon`) VALUES
(27, 19, '2', 'qwrty', 6, 5, 5, 25, '1675.00', '1675.00', '600', '15000', '10.00', '1507.50', '271.35', '18.00', '1778.85', NULL, 'info@acedecors.in', '2022-03-04 12:29:57', 'info@acedecors.in', '2022-03-04 12:29:57'),
(26, 19, '1', 'SAH130 & L H', 7, 69, 2, 25, '150.00', '150.00', '600', '12000', '10.00', '135.00', '24.30', '18.00', '159.30', NULL, 'info@acedecors.in', '2022-03-04 12:29:57', 'info@acedecors.in', '2022-03-04 16:31:07');

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
-- Table structure for table `sliderimages`
--

DROP TABLE IF EXISTS `sliderimages`;
CREATE TABLE IF NOT EXISTS `sliderimages` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alternatetext` varchar(200) NOT NULL,
  `imageCaption` varchar(500) NOT NULL,
  `modifiedBY` varchar(100) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  PRIMARY KEY (`imageId`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sliderimages`
--

INSERT INTO `sliderimages` (`imageId`, `image`, `createdOn`, `modifiedOn`, `alternatetext`, `imageCaption`, `modifiedBY`, `createdBy`) VALUES
(21, 'kitchen2.jpg', '2022-01-19 17:08:06', '2022-01-19 17:08:06', 'kitchen', 'kitchen', 'info@acedecors.in', 'info@acedecors.in'),
(19, 'kitchen.jpg', '2022-01-19 17:07:21', '2022-01-19 17:07:21', 'kitchen', 'kitchen', 'info@acedecors.in', 'info@acedecors.in'),
(20, 'kitchen1.jpg', '2022-01-19 17:07:45', '2022-01-19 17:07:45', 'kitchen', 'kitchen', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `socialmediahandle`
--

DROP TABLE IF EXISTS `socialmediahandle`;
CREATE TABLE IF NOT EXISTS `socialmediahandle` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `handle` varchar(500) NOT NULL,
  `icon` varchar(2000) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(500) NOT NULL,
  `modifiedBy` varchar(500) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `socialmediahandle`
--

INSERT INTO `socialmediahandle` (`Id`, `name`, `handle`, `icon`, `createdon`, `createdBy`, `modifiedBy`, `modifiedon`) VALUES
(4, 'Facebook', 'https://www.facebook.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-facebook\" viewBox=\"0 0 16 16\">\r\n            <path d=\"M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z\"/>\r\n          </svg>', '2021-12-14 13:12:42', 'info@acedecors.in', 'info@acedecors.in', '2022-01-03 06:53:58'),
(2, 'Twitter', 'https://www.twitter.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-twitter\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z\"/>\r\n</svg>', '2021-12-13 19:43:57', 'info@acedecors.in', 'info@acedecors.in', '2022-01-03 06:53:58'),
(3, 'Instagram', 'https://www.instagram.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-instagram\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z\"/>\r\n</svg>', '2021-12-13 19:45:16', 'info@acedecors.in', 'info@acedecors.in', '2022-01-03 06:53:58'),
(7, 'Pinterest', 'https://www.pinterest.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pinterest\" viewBox=\"0 0 16 16\">\r\n            <path d=\"M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z\"/>\r\n          </svg>', '2021-12-15 17:52:21', 'info@acedecors.in', 'info@acedecors.in', '2022-01-03 06:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `subCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `subCategoryName` varchar(200) NOT NULL,
  `subCategoryDescription` varchar(500) NOT NULL,
  `subCategoryCreatedBy` varchar(200) NOT NULL,
  `subCategoryCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subCategoryModifiedBy` varchar(200) NOT NULL,
  `subCategoryModifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subCategoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierpaymentinfo`
--

INSERT INTO `supplierpaymentinfo` (`supplierpaymentId`, `supplierId`, `POID`, `total_amount`, `paid_amount`, `received_amount`, `pending_amount`, `payment_plan`, `payment_mode`, `RTGS_no`, `cheque_img`, `due_date`, `payment_description`, `paymentPDFName`, `modifieddate`, `modified_by`) VALUES
(3, 22, 3, 22750, 0, 0, 22750, '0', '0', '', '', NULL, '0', NULL, '2022-03-01 14:57:30', '');

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
(22, 11, '', '', '2022-02-24 17:08:17', '2022-02-24 17:08:17'),
(21, 8, '', '', '2021-10-11 12:25:09', '2021-10-11 12:25:09'),
(22, 13, '', '', '2022-02-24 17:08:17', '2022-02-24 17:08:17'),
(23, 8, 'info@acedecors.in', 'info@acedecors.in', '2022-02-04 13:01:48', '2022-02-04 13:01:48'),
(23, 12, 'info@acedecors.in', 'info@acedecors.in', '2022-02-04 13:01:48', '2022-02-04 13:01:48'),
(22, 24, '', '', '2022-02-24 17:08:17', '2022-02-24 17:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `taskfollowup`
--

DROP TABLE IF EXISTS `taskfollowup`;
CREATE TABLE IF NOT EXISTS `taskfollowup` (
  `FollowUp_Id` int(11) NOT NULL AUTO_INCREMENT,
  `TaskID` int(11) NOT NULL,
  `FollowUp_Comments` varchar(100) NOT NULL,
  `FollowUp_modifiedBy` varchar(100) DEFAULT NULL,
  `FollowUp_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `FollowUp_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FollowUp_createdBy` varchar(100) NOT NULL,
  PRIMARY KEY (`FollowUp_Id`),
  KEY `TaskID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskfollowup`
--

INSERT INTO `taskfollowup` (`FollowUp_Id`, `TaskID`, `FollowUp_Comments`, `FollowUp_modifiedBy`, `FollowUp_modifiedOn`, `FollowUp_createdOn`, `FollowUp_createdBy`) VALUES
(1, 1, 'qwrty', NULL, '2022-02-12 12:06:36', '2022-02-12 12:06:36', 'info@acedecors.in'),
(2, 2, 'poiuyrrsyk', NULL, '2022-02-12 12:16:48', '2022-02-12 12:16:48', 'info@acedecors.in');

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
-- Table structure for table `termsandconditions`
--

DROP TABLE IF EXISTS `termsandconditions`;
CREATE TABLE IF NOT EXISTS `termsandconditions` (
  `id` int(150) NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `termsandconditions`
--

INSERT INTO `termsandconditions` (`id`, `description`) VALUES
(1, '<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum\n\n</p>\n<p></p>');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thickness`
--

INSERT INTO `thickness` (`Thickness_Id`, `Thickness`, `Thickness_createdby`, `Thickness_modifiedby`, `Thickness_createdOn`, `Thickness_modifiedOn`) VALUES
(1, '40mm', 'info@acedecors.in', 'info@acedecors.in', '2021-12-08 16:09:14', '2021-12-08 16:09:14'),
(2, '18mm', 'info@acedecors.in', 'info@acedecors.in', '2022-01-27 17:06:19', '2022-01-27 17:06:19');

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
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
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
(2, 'info@acedecors.in', '9742367112', 'info@acedecors.in', 'Acedecors@123', 'Admin', 'Enable', '2021-05-01 18:47:39', '2022-01-03 06:53:58');

-- --------------------------------------------------------

--
-- Structure for view `availableqty`
--
DROP TABLE IF EXISTS `availableqty`;

DROP VIEW IF EXISTS `availableqty`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `availableqty`  AS  (select (sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty`) AS `AvailableQty`,monthname((now() + interval -(2) month)) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where (monthname(`s`.`modifiedOn`) = monthname((now() + interval -(2) month)))) union select (sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty`) AS `AvailableQty`,monthname((now() + interval -(1) month)) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where (monthname(`s`.`modifiedOn`) = monthname((now() + interval -(1) month))) union select (sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty`) AS `AvailableQty`,monthname((now() - 1)) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where (monthname(`s`.`modifiedOn`) = monthname((now() - 1))) ;

-- --------------------------------------------------------

--
-- Structure for view `customerbalanceamt`
--
DROP TABLE IF EXISTS `customerbalanceamt`;

DROP VIEW IF EXISTS `customerbalanceamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerbalanceamt`  AS  (select (`cp`.`total_amount` - sum(`cp`.`received_amount`)) AS `Total`,`cp`.`customer_id` AS `Id`,`cp`.`quotation_id` AS `QuoteId`,`c`.`customerCode` AS `CustomerId` from (`customerpaymentinfo` `cp` join `customer` `c` on((convert(`c`.`customerCode` using utf8) = `cp`.`customer_id`))) group by `QuoteId`) ;

-- --------------------------------------------------------

--
-- Structure for view `customerlastm`
--
DROP TABLE IF EXISTS `customerlastm`;

DROP VIEW IF EXISTS `customerlastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerlastm`  AS  (select count(0) AS `Customers`,monthname((now() + interval -(2) month)) AS `MONTH` from `quotation_details` where ((monthname(`quotation_details`.`modifiedon`) = monthname((now() + interval -(2) month))) and (`quotation_details`.`quo_status` = 'Approved'))) union select count(0) AS `Customers`,monthname((now() + interval -(1) month)) AS `MONTH` from `quotation_details` where ((monthname(`quotation_details`.`modifiedon`) = monthname((now() + interval -(1) month))) and (`quotation_details`.`quo_status` = 'Approved')) union select count(0) AS `Customers`,monthname((now() - 1)) AS `MONTH` from `quotation_details` where ((monthname(`quotation_details`.`modifiedon`) = monthname((now() - 1))) and (`quotation_details`.`quo_status` = 'Approved')) ;

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
-- Structure for view `inwardedlastq`
--
DROP TABLE IF EXISTS `inwardedlastq`;

DROP VIEW IF EXISTS `inwardedlastq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inwardedlastq`  AS  (select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname((now() + interval -(2) month)) AS `MONTH` from `item_stock` where (monthname(`item_stock`.`modifiedOn`) = monthname((now() + interval -(2) month)))) union select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname((now() + interval -(1) month)) AS `MONTH` from `item_stock` where (monthname(`item_stock`.`modifiedOn`) = monthname((now() + interval -(1) month))) union select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname((now() - 1)) AS `MONTH` from `item_stock` where (monthname(`item_stock`.`modifiedOn`) = monthname((now() - 1))) ;

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
