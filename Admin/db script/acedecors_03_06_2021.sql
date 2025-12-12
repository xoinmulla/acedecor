-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 03, 2021 at 10:37 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--



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
  `customerName` varchar(200) NOT NULL,
  `customerContactNumber` varchar(15) NOT NULL,
  `customerEmail` varchar(200) NOT NULL,
  `customerAddress` varchar(500) NOT NULL,
  `customerState` varchar(200) NOT NULL,
  `customerCity` varchar(200) NOT NULL,
  `createdby` varchar(200) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customerDOV` datetime NOT NULL,
  PRIMARY KEY (`customerId`),
  KEY `enq_id` (`enq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--



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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dimensions`
--


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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_category`
--

INSERT INTO `enquiry_category` (`enq_catid`, `enq_cat_name`, `enq_cat_createdon`, `enq_cat_createdby`, `enq_cat_modifiedon`, `enq_cat_modifiedby`) VALUES
(1, 'Modular Kitchen', '2021-05-18 11:55:41', 'info@acedecors.in', '2021-05-18 11:55:41', 'info@acedecors.in'),
(2, 'Living Room', '2021-05-18 15:08:21', 'info@acedecors.in', '2021-05-18 15:08:21', 'info@acedecors.in');

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
  `isCustomerCreated` tinyint(1) NOT NULL DEFAULT '0',
  `enq_createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enq_modifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enq_modifiedBy` varchar(200) NOT NULL,
  `enq_preffered_contact_mode` varchar(20) NOT NULL,
  PRIMARY KEY (`enqid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_details`
--


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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_followups`
--


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
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--



-- --------------------------------------------------------

--
-- Table structure for table `item_companydetails`
--

DROP TABLE IF EXISTS `item_companydetails`;
CREATE TABLE IF NOT EXISTS `item_companydetails` (
  `item_compid` int(11) NOT NULL AUTO_INCREMENT,
  `item_compName` varchar(200) NOT NULL,
  `item_compContactName` varchar(200) NOT NULL,
  `item_compContactNumber` varchar(20) NOT NULL,
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
  `item_complogo` varchar(100) NOT NULL,
  PRIMARY KEY (`item_compid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_companydetails`
--


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
  `item_SAPId` varchar(25) NOT NULL,
  `Item_OrderNumber` varchar(25) NOT NULL,
  `item_Size` int(11) NOT NULL,
  `item_PackingUnit` int(11) NOT NULL,
  `item_MRP` double NOT NULL,
  `item_pp_MRP` double NOT NULL,
  `item_descriptionforcust` varchar(500) NOT NULL,
  `item_GST` int(11) NOT NULL,
  `item_unit` varchar(100) NOT NULL,
  `item_unitFactor` double NOT NULL,
  `item_totalMRP` double NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

DROP TABLE IF EXISTS `item_stock`;
CREATE TABLE IF NOT EXISTS `item_stock` (
  `item_stockid` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_stockbatchno` varchar(200) NOT NULL,
  `item_stockquantity` int(11) NOT NULL,
  `item_stockinwarddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_stockcomments` varchar(500) NOT NULL,
  `item_stockdescription` varchar(500) NOT NULL,
  `item_stockcreatedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_stockcreatedby` varchar(200) NOT NULL,
  `item_stockmodifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_stockmodifiedby` varchar(200) NOT NULL,
  PRIMARY KEY (`item_stockid`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_subcategory`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

DROP TABLE IF EXISTS `quotation_details`;
CREATE TABLE IF NOT EXISTS `quotation_details` (
  `quoid` int(11) NOT NULL AUTO_INCREMENT,
  `quo_enq_id` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `quoteDescription` varchar(500) DEFAULT NULL,
  `itemListName` varchar(200) DEFAULT NULL,
  `orderListName` varchar(200) DEFAULT NULL,
  `quo_type` enum('General','Bank') NOT NULL,
  `quo_pdf_name` varchar(25) DEFAULT NULL,
  `quo_createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quo_createdby` varchar(100) NOT NULL,
  `modifiedby` varchar(200) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `quo_status` enum('pending','rejected','Approved') NOT NULL DEFAULT 'pending',
  `quo_comments` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`quoid`),
  KEY `quo_enq_id` (`quo_enq_id`),
  KEY `customerId` (`customerId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `quotelineitem`
--

DROP TABLE IF EXISTS `quotelineitem`;
CREATE TABLE IF NOT EXISTS `quotelineitem` (
  `lineItemId` int(11) NOT NULL AUTO_INCREMENT,
  `quoteId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotelineitem`
--


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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tax_table`
--


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
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--


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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unitsfactor`
--


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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
