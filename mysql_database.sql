-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2015 at 12:21 AM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39318 ;

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
  `SelfChildID1` text,
  `SelfChildID2` text,
  `SelfChildID3` text,
  `SelfChildID4` text,
  `NFCID` text,
  PRIMARY KEY (`ParentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1711 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3109 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8715 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
