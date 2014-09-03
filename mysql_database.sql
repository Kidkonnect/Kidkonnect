-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 12, 2014 at 08:28 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sunnybrook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `UserName` varchar(20) NOT NULL,
  `Password` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `AccessLevel` text NOT NULL COMMENT 'admin',
  `Notes` text,
  PRIMARY KEY (`UserName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`UserName`, `Password`, `FirstName`, `LastName`, `AccessLevel`, `Notes`) VALUES
('mhenson', 'mike', 'Mike', 'Henson', 'admin', 'Creator');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `UKey` int(11) NOT NULL AUTO_INCREMENT,
  `ChildID` text NOT NULL,
  `Grade` text NOT NULL,
  `AgeGroup` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Date` text NOT NULL,
  `YearMonthDay` text COMMENT 'example 20110625',
  `DayOfYear` text NOT NULL COMMENT '0-365',
  `InTime` text NOT NULL COMMENT 'Check in Time',
  `OutTime` text NOT NULL COMMENT 'Check Out Time',
  `Event` text,
  `ParentEmail` text,
  PRIMARY KEY (`UKey`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`UKey`, `ChildID`, `Grade`, `AgeGroup`, `FirstName`, `LastName`, `Date`, `YearMonthDay`, `DayOfYear`, `InTime`, `OutTime`, `Event`, `ParentEmail`) VALUES
(12, '0808', '1YearOlds', 'N-K', 'Thayton', 'Moreno', '10-18-2009', '20091018', '290', '0920', '1222', 'Sunday', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE IF NOT EXISTS `child` (
  `ChildID` varchar(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Address` text NOT NULL COMMENT 'House number where child lives',
  `City` text NOT NULL COMMENT 'street of house number',
  `Gender` text NOT NULL COMMENT 'Male or Female',
  `Grade` text NOT NULL COMMENT 'ex 4-5 year olds',
  `AgeGroup` text NOT NULL,
  `Birthday` text NOT NULL COMMENT '01/19/1985',
  `DateEntered` text NOT NULL COMMENT '01/19/1985',
  `Status` text NOT NULL COMMENT 'Checkedin',
  `StatusChange` text NOT NULL COMMENT 'Time of Status Change',
  `Allergies` text,
  `Notes` text,
  `ParentID1` text,
  `ParentID2` text,
  `ParentID3` text,
  `ParentID4` text,
  `ParentID5` text,
  `ParentID6` text,
  `ParentID7` text,
  `ParentID8` text,
  `SmallGroup` text,
  `CellPhone` text,
  `Email` text,
  `Twitter` text,
  `Instagram` text,
  PRIMARY KEY (`ChildID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`ChildID`, `FirstName`, `LastName`, `Address`, `City`, `Gender`, `Grade`, `AgeGroup`, `Birthday`, `DateEntered`, `Status`, `StatusChange`, `Allergies`, `Notes`, `ParentID1`, `ParentID2`, `ParentID3`, `ParentID4`, `ParentID5`, `ParentID6`, `ParentID7`, `ParentID8`, `SmallGroup`, `CellPhone`, `Email`, `Twitter`, `Instagram`) VALUES
('0827', 'Eliana', 'Timmons', '1822 E. 19th Avenue', 'Stw, 74074', 'F', '5YearOlds', 'N-K', '10/14/08', '08/10/09', 'Checked Out', '2014/01/05 12:23:06', 'none', 'none', '1', '2', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0655', 'Kaleb', 'Timmons', '1822 E. 19th Avenue', 'Stw, 74074', 'M', '2nd_Grade', '1-5', '02/02/06', '08/10/09', 'Checked Out', '2014/01/05 11:10:29', 'none', 'none', '1', '2', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
  `ParentID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Address` text NOT NULL,
  `City` text NOT NULL,
  `HomePhone` text NOT NULL,
  `CellPhone1` text,
  `Email` text,
  `VolunteerLocation` text,
  `VolunteerTitle` text,
  `ChildID1` text,
  `ChildID2` text,
  `ChildID3` text,
  `ChildID4` text,
  `ChildID5` text,
  `ChildID6` text,
  `ChildID7` text,
  `ChildID8` text,
  `ChildID9` text,
  `ChildID10` text,
  PRIMARY KEY (`ParentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`ParentID`, `FirstName`, `LastName`, `Address`, `City`, `HomePhone`, `CellPhone1`, `Email`, `VolunteerLocation`, `VolunteerTitle`, `ChildID1`, `ChildID2`, `ChildID3`, `ChildID4`, `ChildID5`, `ChildID6`, `ChildID7`, `ChildID8`, `ChildID9`, `ChildID10`) VALUES
(1, 'Delicia', 'Timmons', '1822 E. 19th Avenue', 'Stw', '918-810-9403', '918-808-1100', 'tristontimmons@sbcglobal.et', 'Fours', 'Teacher', '0655', '0827', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'TJ', 'Timmons', '1822 E. 19th Avenue', 'Stw', '918-810-9403', '918-808-1100', 'tristontimmons@sbcglobal.net', 'Fours', 'Teacher', '0655', '0827', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Mike', 'Henson', '1502 N Grandview', 'Stw', 'none', '405.760.0010', 'mikehenson@hotmail.com', 'Check In', 'Tech Man', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Sara', 'Henson', '1502 N Grandview', 'Stw', 'none', '405.760.4075', 'slhorses@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `smallgroup`
--

CREATE TABLE IF NOT EXISTS `smallgroup` (
  `Ukey` int(11) NOT NULL AUTO_INCREMENT,
  `ChildID` text,
  `Grade` text,
  `AgeGroup` text,
  `FirstName` text,
  `LastName` text,
  `Date` text,
  `YearMonthDay` text,
  `Event` text,
  `SmallGroup` text,
  PRIMARY KEY (`Ukey`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `smallgroup`
--

INSERT INTO `smallgroup` (`Ukey`, `ChildID`, `Grade`, `AgeGroup`, `FirstName`, `LastName`, `Date`, `YearMonthDay`, `Event`, `SmallGroup`) VALUES
(40, '9703', '11th_Grade', '9-12', 'Denver', 'Evans', '09-25-2013', '20130925', 'YG', 'JWhite'),
(39, '9600', '11th_Grade', '9-12', 'Luke', 'Davis', '09-25-2013', '20130925', 'YG', 'JWhite'),
(38, '9730', '11th_Grade', '9-12', 'Josh', 'Bullock', '09-25-2013', '20130925', 'YG', 'JWhite'),
(37, '9834', '10th_Grade', '9-12', 'Caitlyn', 'Sanchez', '09-25-2013', '20130925', 'YG', 'SOgle'),
(36, '9824', '10th_Grade', '9-12', 'Kaitlyn', 'Kirksey', '09-25-2013', '20130925', 'YG', 'SOgle'),
(35, '9727', '10th_Grade', '9-12', 'kami', 'killough', '09-25-2013', '20130925', 'YG', 'SOgle'),
(34, '9809', '10th_Grade', '9-12', 'Abigail', 'Henry', '09-25-2013', '20130925', 'YG', 'SOgle'),
(33, '9705', '10th_Grade', '9-12', 'Avery', 'Brown', '09-25-2013', '20130925', 'YG', 'SOgle'),
(32, '9617', '11th_Grade', '9-12', 'Natalie', 'Speer', '09-25-2013', '20130925', 'YG', 'PCarpenter'),
(31, '9713', '11th_Grade', '9-12', 'Audrey', 'McHendry', '09-25-2013', '20130925', 'YG', 'PCarpenter'),
(30, '9712', '11th_Grade', '9-12', 'Hailey', 'Kissee', '09-25-2013', '20130925', 'YG', 'PCarpenter'),
(29, '9615', '11th_Grade', '9-12', 'Hannah', 'Grant', '09-25-2013', '20130925', 'YG', 'PCarpenter'),
(28, '9704', '11th_Grade', '9-12', 'Mariah', 'Brien', '09-25-2013', '20130925', 'YG', 'PCarpenter'),
(27, '9715', '11th_Grade', '9-12', 'Rachel ', 'Bellah', '09-25-2013', '20130925', 'YG', 'PCarpenter'),
(26, '9827', '9th_Grade', '9-12', 'Reece', 'Thompson', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(25, '9813', '9th_Grade', '9-12', 'Brandon', 'Shields', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(24, '9823', '9th_Grade', '9-12', 'Dax', 'Russell', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(23, '9914', '9th_Grade', '9-12', 'Cole', 'Luetkemeyer', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(22, '9948', '9th_Grade', '9-12', 'Kade', 'Killough', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(21, 'yy00', '9th_Grade', '9-12', 'Ethan', 'Gonzalez', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(20, '9816', '9th_Grade', '9-12', 'Dylan', 'Gardner', '09-25-2013', '20130925', 'YG', 'ABellamy'),
(19, '9800', '9th_Grade', '9-12', 'Kacey', 'Franklin', '09-25-2013', '20130925', 'YG', 'ABellamy');

-- --------------------------------------------------------

--
-- Table structure for table `volunteerattendance`
--

CREATE TABLE IF NOT EXISTS `volunteerattendance` (
  `UKey` int(11) NOT NULL AUTO_INCREMENT,
  `ParentID` text NOT NULL,
  `VolunteerLocation` text,
  `VolunteerTitle` text,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Date` text NOT NULL,
  `DayOfYear` text NOT NULL COMMENT '0-365',
  `InTime` text NOT NULL COMMENT 'Check in Time',
  `OutTime` text NOT NULL COMMENT 'Check Out Time',
  `Event` text,
  PRIMARY KEY (`UKey`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `volunteerattendance`
--

INSERT INTO `volunteerattendance` (`UKey`, `ParentID`, `VolunteerLocation`, `VolunteerTitle`, `FirstName`, `LastName`, `Date`, `DayOfYear`, `InTime`, `OutTime`, `Event`) VALUES
(47, '44', NULL, 'Childrens Minister', 'Julie', 'Davis', '01-05-2014', '4', '1025', '', 'Nursery/Preschool'),
(48, '613', 'Ones', 'Helper', 'Alexandra', 'Fletes', '01-05-2014', '4', '1047', '', 'Nursery/Preschool'),
(49, '1117', 'Fives', 'Helper', 'Lyle', 'Fletes', '01-05-2014', '4', '1047', '', 'Nursery/Preschool'),
(50, '531', 'Fives', 'Teacher', 'Jen', 'Chessmore', '01-05-2014', '4', '1048', '', 'Nursery/Preschool'),
(51, '1162', NULL, NULL, 'Scott', 'Freeman', '01-05-2014', '4', '1048', '', 'Nursery/Preschool'),
(52, '1', 'Fours', 'Teacher', 'Delicia', 'Timmons', '01-05-2014', '4', '1048', '', 'Nursery/Preschool'),
(53, '116', 'Nursery', 'Helper', 'Jennifer', 'Veit', '01-05-2014', '4', '1049', '', 'Nursery/Preschool'),
(54, '2', 'Fours', 'Teacher', 'TJ', 'Timmons', '01-05-2014', '4', '1049', '', 'Nursery/Preschool'),
(55, '117', 'Nursery', 'Helper', 'Darrin', 'Veit', '01-05-2014', '4', '1049', '', 'Nursery/Preschool'),
(56, '984', NULL, 'Fives Helper', 'Lauren', 'Egleston', '01-05-2014', '4', '1049', '', 'Nursery/Preschool'),
(57, '50', NULL, NULL, 'Tiffany', 'Bays', '01-05-2014', '4', '1054', '', 'Nursery/Preschool'),
(58, '1506', 'Ones', 'Helper', 'Chelsea', 'Stewart', '01-05-2014', '4', '1055', '', 'Nursery/Preschool'),
(59, '833', 'Fives ', 'Helper', 'Avery', 'Brown', '01-05-2014', '4', '1055', '', 'Nursery/Preschool'),
(60, '727', 'Twos', 'Helper', 'Elise', 'Rackley', '01-05-2014', '4', '1055', '', 'Nursery/Preschool'),
(61, '1473', NULL, NULL, 'Laura', 'Frye', '01-05-2014', '4', '1058', '', 'Nursery/Preschool'),
(62, '44', NULL, 'Childrens Minister', 'Julie', 'Davis', '01-12-2014', '11', '0824', '', 'Nursery/Preschool');
