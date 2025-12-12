-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2022 at 10:35 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

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
  `ModifiedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(200) NOT NULL,
  `categoryDescription` varchar(500) NOT NULL,
  `categoryCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `categoryCreatedBy` varchar(200) NOT NULL,
  `categoryModifiedOn` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `Modified_Date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`id`, `Name`, `Email`, `Phone`, `Qualification`, `Trainings`, `Internship`, `Demo`, `Services`, `status`, `Modified_Date`) VALUES
(1, 'Hifza', 'info@dharwadhubballitutor.com', '09741237334', '', 'some query', '', '', '', 1, '2022-01-03 06:53:58'),
(2, 'Athar', 'atharshaikh1@gmail.com', '807961759', '', 'hello', '', '', '', 1, '2022-01-03 06:53:58');

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
  `postCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `postCreatedBy` varchar(100) NOT NULL,
  `postModifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
-- Table structure for table `sliderimages`
--

DROP TABLE IF EXISTS `sliderimages`;
CREATE TABLE IF NOT EXISTS `sliderimages` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `modifiedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(500) NOT NULL,
  `modifiedBy` varchar(500) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `subCategoryCreatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `subCategoryModifiedBy` varchar(200) NOT NULL,
  `subCategoryModifiedon` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`subCategoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `termsandconditions`
--

DROP TABLE IF EXISTS `termsandconditions`;
CREATE TABLE IF NOT EXISTS `termsandconditions` (
  `id` int(150) NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `termsandconditions`
--

INSERT INTO `termsandconditions` (`id`, `description`) VALUES
(1, '<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum\n\n</p>\n<p></p>');

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
  `user_created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `ModifiedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_contact`, `user_email`, `user_password`, `user_type`, `user_status`, `user_created_on`, `ModifiedDate`) VALUES
(2, 'info@acedecors.in', '9742367112', 'info@acedecors.in', 'Acedecors@123', 'Admin', 'Enable', '2021-05-01 18:47:39', '2022-01-03 06:53:58');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
