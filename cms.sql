-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 30, 2021 at 10:05 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8  */;

--
-- Database: `cms`
--

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
  `businessTagLine` varchar(500) NOT NULL,
  `businessEmail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ModifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `businessGSTIN` varchar(15) DEFAULT NULL,
  `logoImage` varchar(100) DEFAULT NULL,
  `aboutBusiness` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`businessId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businessdetails`
--

INSERT INTO `businessdetails` (`businessId`, `businessName`, `businessAddress`, `businessContact`, `businessTagLine`, `businessEmail`, `password`, `createdDate`, `businessGSTIN`, `logoImage`, `aboutBusiness`) VALUES
(1, 'Dharwadhubballitutor', 'J. G. Nippani complex, beside SBI Bank, Gandhi Nagar Dharwad 580004', '+91 8007961759', 'learn Transform Succeed', 'info@dharwadhubballitutor.com', '', '2021-11-27 19:14:44', '22AAAAA0000A1Z5', 'Copy of Copy of D (2).png', '<p>Introducing DharwadHubballitutor as a Brand for jobseekers to avail of Training, Internships, and job Assistance.\n\n</p>\n<h3></h3>\n<h3><strong>Why is it named so?</strong></h3>\n<p>\n<br />\nWe have the vision to collaborate the two cities Dharwad and Hubballi, in terms of Education, Placement opportunity, Internships and Service Providers. To start two way contacts and communication between the two cities, in a view to use each other’s resources to convert our city to a “smart city”.\n\n</p>\n<p><span indent=\"4\">\n</span><br />\n</p>');

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
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `categoryName` (`categoryName`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`, `categoryDescription`, `categoryCreatedOn`, `categoryCreatedBy`, `categorytModifiedBy`) VALUES
(6, 'Courses', 'The well-structured study material for students to excel in their careers.', '2021-12-28 17:24:14', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `catsubcatmapping`
--

DROP TABLE IF EXISTS `catsubcatmapping`;
CREATE TABLE IF NOT EXISTS `catsubcatmapping` (
  `catId` int NOT NULL,
  `sucatId` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

--
-- Dumping data for table `catsubcatmapping`
--

INSERT INTO `catsubcatmapping` (`catId`, `sucatId`) VALUES
(43, 2),
(6, 50),
(6, 49);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`id`, `Name`, `Email`, `Phone`, `Qualification`, `Trainings`, `Internship`, `Demo`, `Services`, `status`) VALUES
(1, 'Hifza', 'info@dharwadhubballitutor.com', '09741237334', '', 'some query', '', '', '', 1),
(2, 'Athar', 'atharshaikh1@gmail.com', '807961759', '', 'hello', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `postId` int NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(100) NOT NULL,
  `postUrl` varchar(100) NOT NULL,
  `appearOnHome` tinyint(1) NOT NULL DEFAULT '0',
  `postDescription` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `postCreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postCreatedBy` varchar(100) NOT NULL,
  `postModifiedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titleTag` varchar(100) NOT NULL,
  `keywords` mediumtext NOT NULL,
  `modifiedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`postId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `postTitle`, `postUrl`, `appearOnHome`, `postDescription`, `postCreatedOn`, `postCreatedBy`, `titleTag`, `keywords`, `modifiedBy`) VALUES
(11, 'Python Programming', '/dharwadhubballitutor/Python-Programming-Training', 1, '<h2><strong>WHAT IS PYTHON PROGRAMMING??</strong></h2>\n<p>\n<br />\nPython is an interpreted, high-level, and general purpose programming language.It is being used for:\n\n</p>\n<ul>\n<li>Development of Website (server-side).</li>\n<li>Software Development.</li>\n<li>In mathematics.</li>\n<li>System Scripting.</li>\n</ul>\n<h2></h2>\n<h2><strong>WHY LEARN PYTHON PROGRAMMING?</strong></h2>\n<p>\n<br />\n</p>\n<ul>\n<li>Python’s popularity &amp; high salary</li>\n<li>Python is simple &amp; easy to learn</li>\n<li>Python is portable &amp; extensible</li>\n<li>Python is used in Data Science</li>\n<li>Python is used in scripting &amp; automation</li>\n<li>Python used with Big Data</li>\n<li>Python supports Testing</li>\n<li>Computer Graphics in Python</li>\n<li>Python used in Artificial Intelligence</li>\n<li>Python in Web Development</li>\n</ul>\n<p>\n<br />\n</p>\n<h2><strong>CAREER AND JOBS</strong></h2>\n<p>\n<br />\nIn contrast to other programming languages such as R, Scala, Java, Python certifications will easily help one land a job. Here\'s a list of opportunities for python careers that a python programmer may choose.\n<br />\n</p>\n<ul>\n<li>Python Developer</li>\n<li>Data Scientist/Sr.Data Scientist</li>\n<li>DevOps Engineer</li>\n<li>Data Analyst</li>\n<li>Software Engineer</li>\n<li>Machine Learning Engineer</li>\n<li>Quality Assurance Engineer</li>\n<li>GIS Analyst</li>\n</ul>\n<p>\n\n</p>\n<h2><strong>COURSE SYLLABUS</strong></h2>\n<p>\n<br />\n</p>\n<ul>\n<li>Introduction to Python</li>\n<li>Environment Setup</li>\n<li>Control Statements</li>\n<li>List, Ranges &amp; Tuples in Python</li>\n<li>Python Dictionaries &amp; Sets</li>\n<li>Input/Output in Python</li>\n<li>Python Built-in Functions</li>\n<li>Python Object-Oriented</li>\n<li>Exceptions</li>\n<li>Python Regular Expressions</li>\n<li>Python Multithreaded Programming</li>\n<li>Using Database in Python</li>\n</ul>\n<p>\n\n</p>\n<p></p>\n', '2021-12-28 18:13:30', 'info@acedecors.in', 'python-programming-training', 'Python Programming,python,python programming training,python programming training in dharwad,python language,python coaching in dharwad,python coaching,python language,python language training, python language coaching in dharwad,python tutorial in dharwad,python tutorial,python basics,python programming for beginners,python for beginners in dharwad', 'info@acedecors.in'),
(12, 'Java Programming', '/dharwadhubballitutor/java-programming', 1, '<h2><strong>What are Programming Languages?</strong></h2>\n<p>\n<br />\nA programming language is a formal computer language or constructed language designed to communicate instructions to a machine. Programming languages can be used to create programs to control the behavior of a machine to express algorithms.<span align=\"justify\">\n</span><br />\n\n<br />\n</p>\n<h2><strong>Programming Languages we provide Training for:</strong></h2>\n<h3></h3>\n<h3><strong>C Language</strong></h3>\n<p>\n<br />\nC programming, developed in 1972 by Dennis M. Ritchie at the Bell Telephone Laboratories to create the UNIX operating system, is a general-purpose, procedural, imperative computer programming language.<span align=\"justify\">\n</span><br />\n</p>\n<h3></h3>\n<h3><strong>C++ Language</strong></h3>\n<p>\n<br />\nC++ is a cross-platform language that can be used to build software for high performance. It can be found in today\'s Graphical User interface, Operating systems, and Embedded system.<span align=\"justify\">\n</span><br />\n\n<br />\n</p>\n<h3><strong>Java</strong></h3>\n<p>\n<br />\nJava is a language for programming and a forum. Java is a high-level, robust programming language that is object-oriented and stable. In 1995, Java was developed by Sun Microsystems (which is now Oracle\'s subsidiary).<span align=\"justify\">\n\n</span></p>\n<h2><strong>CAREER IN &quot;C/C++ PROGRAMMING&quot;</strong></h2>\n<p>\n<br />\n</p>\n<ul>\n<li>Junior Programmer</li>\n<li>Senior Programmer</li>\n<li>Software Developer</li>\n<li>Quality Analyst</li>\n<li>Game Programmer</li>\n<li>Programming Architect</li>\n<li>Backend Developer</li>\n<li>Embedded Engineer</li>\n<li>Database Developer</li>\n</ul>\n<p><span style=\"color: white;\">r</span>\n<br />\n</p>\n<h3>CAREER IN &quot;JAVA&quot;</h3>\n<ul>\n<li>Java Programmer</li>\n<li>Java Web Developer</li>\n<li>Java WebMaster</li>\n<li>Java Software Engineer</li>\n<li>Java Architect</li>\n<li>Database Administrator</li>\n<li>Senior Developer</li>\n<li>Module lead</li>\n<li>Application Develop<span style=\"color: white;\">er</span></li>\n</ul>\n<p>\n<br />\n</p>\n<h3>Syllabus for &quot;C&quot;</h3>\n<p>\n<br />\n</p>\n<ul>\n<li>Introduction to Principles of programming</li>\n<li>Introduction to C Programming</li>\n<li>Operators and Expressions</li>\n<li>Data Types and Input/Output Operators</li>\n<li>Control Statements and Decision Making</li>\n<li>Arrays and Strings</li>\n<li>Structures and Unions</li>\n</ul>\n<p>\n<br />\n</p>\n<h3>Syllabus for &quot;C++&quot;</h3>\n<ul>\n<li>Introduction to Principles of programming</li>\n<li>Introduction to C++ Programming</li>\n<li>Introduction to OOP\'s</li>\n<li>Classes and Objects</li>\n<li>Control Statements and Decision Making</li>\n<li>Function</li>\n<li>Inheritance and Composition</li>\n<li>Polymorphism</li>\n</ul>\n<p>\n<br />\n</p>\n<h3>Syllabus for &quot;JAVA&quot;</h3>\n<ul>\n<li>Basics of Java</li>\n<li>Packages</li>\n<li>Introduction to OOP\'s</li>\n<li>The Java Environment</li>\n<li>Exception Handling</li>\n<li>Classes and Objects</li>\n<li>Collection Framework</li>\n<li>Multithreading</li>\n<li>Array and Strings</li>\n<li>Event Handling</li>\n</ul>\n<p>\n<br />\n</p>\n', '2021-12-28 18:24:34', 'info@acedecors.in', 'java-programming', 'C coaching in dharwad,C coaching center near me,C coaching center in dharwad,C language,C programming,C programming training in dharwad,C programming training near me,C programming,C training,C programming language,C++ programming,C++ programming training in dharwad,C++ programming coaching in dharwad,C++ programming coaching near me,C++ programming,C++ training,C++ language tarining,C++ language,C++ langauge coaching in Dharwad,C++ coaching in dharwad,C++ coaching near me,java,java coaching near me,java coaching in dharwad,java training,java training in dharwad,java coaching center in dharwad,java coaching center near me,java coaching,java coding tarining,java coding,java course,java course in dharwad,java course near me,programming languages,programming,', 'info@acedecors.in');

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

--
-- Dumping data for table `postimages`
--

INSERT INTO `postimages` (`postImageId`, `postImage`, `createdOn`, `createdBy`, `modifiedBy`, `imageAlternateText`, `postId`) VALUES
(11, 0x507974686f6e57454c434f4d452e6a7067, '2021-12-28 18:13:30', 'info@acedecors.in', 'info@acedecors.in', 'python-programming-training', 11),
(12, 0x50726f6772616d6d696e6757454c434f4d452e6a7067, '2021-12-28 18:24:34', 'info@acedecors.in', 'info@acedecors.in', 'java-programming', 12);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

-- --------------------------------------------------------

--
-- Table structure for table `postsubcatmapping`
--

DROP TABLE IF EXISTS `postsubcatmapping`;
CREATE TABLE IF NOT EXISTS `postsubcatmapping` (
  `postId` int NOT NULL,
  `subCatId` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

--
-- Dumping data for table `postsubcatmapping`
--

INSERT INTO `postsubcatmapping` (`postId`, `subCatId`) VALUES
(11, 49),
(12, 49);

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
  PRIMARY KEY (`imageId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

--
-- Dumping data for table `sliderimages`
--

INSERT INTO `sliderimages` (`imageId`, `image`, `createdOn`, `alternatetext`, `imageCaption`, `modifiedBY`, `createdBy`) VALUES
(4, '1.jpg', '2021-11-26 18:56:50', 'slide', 'slide', 'info@acedecors.in', 'info@acedecors.in'),
(6, '2.jpg', '2021-12-15 12:47:28', 'sliders', 'sliders', 'info@acedecors.in', 'info@acedecors.in'),
(5, 'Copy of Learning Helps Earning.png', '2021-11-29 11:46:52', 'Top Skill', 'Top Skill', 'info@acedecors.in', 'info@acedecors.in');

-- --------------------------------------------------------

--
-- Table structure for table `socialmediahandle`
--

DROP TABLE IF EXISTS `socialmediahandle`;
CREATE TABLE IF NOT EXISTS `socialmediahandle` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `handle` varchar(500) NOT NULL,
  `icon` varchar(2000) CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL,
  `createdon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(500) NOT NULL,
  `modifiedBy` varchar(500) NOT NULL,
  `modifiedon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci ;

--
-- Dumping data for table `socialmediahandle`
--

INSERT INTO `socialmediahandle` (`Id`, `name`, `handle`, `icon`, `createdon`, `createdBy`, `modifiedBy`) VALUES
(4, 'Facebook', 'https://www.facebook.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-facebook\" viewBox=\"0 0 16 16\">\r\n            <path d=\"M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z\"/>\r\n          </svg>', '2021-12-14 13:12:42', 'info@acedecors.in', 'info@acedecors.in'),
(2, 'Twitter', 'https://www.twitter.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-twitter\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z\"/>\r\n</svg>', '2021-12-13 19:43:57', 'info@acedecors.in', 'info@acedecors.in'),
(3, 'Instagram', 'https://www.instagram.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-instagram\" viewBox=\"0 0 16 16\">\r\n  <path d=\"M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z\"/>\r\n</svg>', '2021-12-13 19:45:16', 'info@acedecors.in', 'info@acedecors.in'),
(7, 'Pinterest', 'https://www.pinterest.com/DharwadhubballiTutor', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pinterest\" viewBox=\"0 0 16 16\">\r\n            <path d=\"M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z\"/>\r\n          </svg>', '2021-12-15 17:52:21', 'info@acedecors.in', 'info@acedecors.in');

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
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subCategoryId`, `subCategoryName`, `subCategoryDescription`, `subCategoryCreatedBy`, `subCategoryCreatedOn`, `subCategoryModifiedBy`) VALUES
(49, 'Programming Language', 'A programming language is a formal language comprising a set of strings that produce various kinds of machine code output. Programming languages are one kind of computer language and are used in computer programming to implement algorithms.', 'info@acedecors.in', '2021-12-28 17:32:23', 'info@acedecors.in'),
(50, 'Web Designing', 'Web design refers to the design of websites that are displayed on the internet. It usually refers to the user experience aspects of website development rather than software development. Web design used to be focused on designing websites for desktop browsers; however, since the mid-2010s, design for mobile and tablet browsers has become ever-increasingly important.', 'info@acedecors.in', '2021-12-29 11:05:14', 'info@acedecors.in');

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
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_contact`, `user_email`, `user_password`, `user_type`, `user_status`, `user_created_on`) VALUES
(2, 'info@acedecors.in', '9742367112', 'info@acedecors.in', 'Acedecors@123', 'Admin', 'Enable', '2021-05-01 18:47:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
