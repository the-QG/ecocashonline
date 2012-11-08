-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2012 at 10:52 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "Africa/Harare";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `your_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `loga`
--

CREATE TABLE IF NOT EXISTS `loga` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `yaya` varchar(300) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `loga`
--

INSERT INTO `loga` (`rid`, `yaya`, `timestamp`) VALUES
(18, '"admi=1&amount=2.00&approval_code=121105.1604.C00011&new_balance=16.82&sender=SMITCH+JOHNS&time_sms_got_in=2012-11-07+07%3A18%3A26&merchant_key=takunda&digest=d7a20cee18cdd6f40e9bd0af253a8738a2bfb573a748001c7a03dc2c81f3b398"', '2012-11-07 07:40:23'),
(19, '"admi=2&amount=2.00&approval_code=121107.0942.C00012&new_balance=18.82&sender=ANDY+PARK&time_sms_got_in=2012-11-07+07%3A42%3A36&merchant_key=takunda&digest=8f164f17e1f49486c2ff0782af9576eae2d7995c1c548bc9652b2ffefe5079f6"', '2012-11-07 07:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `admi` int(11) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `approval_code` varchar(50) NOT NULL,
  `new_balance` varchar(9) NOT NULL,
  `time_sms_got_in` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`),
  UNIQUE KEY `approval_code` (`approval_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `trackid` varchar(20) NOT NULL,
  `artistid` varchar(20) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`trackid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
