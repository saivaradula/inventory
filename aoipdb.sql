-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2017 at 07:39 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.5.38

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aoipdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activate_data`
--

CREATE TABLE IF NOT EXISTS `activate_data` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `imei` varchar(50) DEFAULT NULL,
  `added_on` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `act_status` varchar(20) DEFAULT NULL,
  `added_by` bigint(21) DEFAULT NULL,
  `company` bigint(21) DEFAULT NULL,
  `promocode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `activate_data`
--

INSERT INTO `activate_data` (`id`, `imei`, `added_on`, `status`, `act_status`, `added_by`, `company`, `promocode`) VALUES
(27, '123', '2017-08-25 03:29:58', 0, 'ACTIVATED', 1, 0, 'AGWP0V0');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(200) DEFAULT NULL,
  `LAST_NAME` varchar(200) DEFAULT NULL,
  `EMAILID` varchar(200) DEFAULT NULL,
  `STATE` varchar(30) DEFAULT NULL,
  `ZIPCODE` varchar(10) DEFAULT NULL,
  `USAC_FORM` varchar(200) DEFAULT NULL,
  `BATCH_DATE` date DEFAULT NULL,
  `AG_GROUP` varchar(100) NOT NULL,
  `DMA` varchar(50) DEFAULT NULL,
  `BATCH_YEAR` varchar(5) DEFAULT NULL,
  `PARENT_CMPNY` int(5) DEFAULT NULL,
  `ENROLLMENT_NUMBER` varchar(100) DEFAULT NULL,
  `ENROLLMENT_CHANNEL` varchar(100) DEFAULT NULL,
  `Q_STATUS` varchar(50) DEFAULT NULL,
  `STATUS_ID` int(5) DEFAULT NULL,
  `CREATED_ON` datetime DEFAULT NULL,
  `CREATED_BY` bigint(21) DEFAULT NULL,
  `HEADSHOT_FILE` varchar(200) DEFAULT NULL,
  `GOVID_FILE` varchar(200) DEFAULT NULL,
  `DISCLOSURE_FILE` varchar(200) DEFAULT NULL,
  `BG_AUTH_FILE` varchar(200) DEFAULT NULL,
  `COMP_CERT_FILE` varchar(200) DEFAULT NULL,
  `USER_ID` varchar(30) DEFAULT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `ACTION` varchar(20) DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  `LOCATION_ID` bigint(21) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `SOCIAL` tinytext,
  `PROMOCODE` varchar(100) DEFAULT NULL,
  `DL` varchar(100) DEFAULT NULL,
  `SUBCNT` bigint(21) DEFAULT NULL,
  PRIMARY KEY (`ID`,`AG_GROUP`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`ID`, `FIRST_NAME`, `LAST_NAME`, `EMAILID`, `STATE`, `ZIPCODE`, `USAC_FORM`, `BATCH_DATE`, `AG_GROUP`, `DMA`, `BATCH_YEAR`, `PARENT_CMPNY`, `ENROLLMENT_NUMBER`, `ENROLLMENT_CHANNEL`, `Q_STATUS`, `STATUS_ID`, `CREATED_ON`, `CREATED_BY`, `HEADSHOT_FILE`, `GOVID_FILE`, `DISCLOSURE_FILE`, `BG_AUTH_FILE`, `COMP_CERT_FILE`, `USER_ID`, `PHONE`, `ACTION`, `STATUS`, `LOCATION_ID`, `DOB`, `SOCIAL`, `PROMOCODE`, `DL`, `SUBCNT`) VALUES
(1, 'Agent One', 'One', 'agentone@gmail.com', 'LA', '08452', 'YES', '0000-00-00', 'GRP993', 'DMA990', '', 1, '0934934', '09344034', 'QUALIFIED', 1, '2017-08-25 03:09:25', 1, '', '', '', '', '', '20170825030925', '5417896325', '', 1, 89, '0000-00-00', NULL, 'AGWP0V0', NULL, 20170825011424),
(2, 'Sai', 'Varadula', 'sai.varadula@gmail.com', 'AL', '08452', 'YES', '0000-00-00', 'GP2', '88801', '', 1, 'ENR083', 'ENRC89834', 'QUALIFIED', 1, '2017-08-25 03:13:36', 20170825031301, '', '', '', '', '', '20170825031336', '5426398520', 'SELF', 1, 89, '0000-00-00', NULL, 'AVR0X2', NULL, 20170825011424),
(3, '', '', 'Test@gmail.com', '', '', '', '0000-00-00', '', '', '', 1, '', '', 'QUALIFIED', 1, '2017-08-25 03:15:08', 20170825031301, '', '', '', '', '', '20170825031508', '', 'SELF', 1, 0, '0000-00-00', NULL, '', NULL, 0),
(4, '', '', 'hanu424@gmail.com', '', '', '', '0000-00-00', '', '', '', 1, '', '', 'QUALIFIED', 1, '2017-08-25 03:17:34', 20170825031301, '', '', '', '', '', '20170825031734', '', 'SELF', 1, 0, '0000-00-00', NULL, '', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(200) DEFAULT NULL,
  `TYPE` varchar(20) DEFAULT NULL,
  `ADDRESS` text,
  `PHONE` varchar(20) DEFAULT NULL,
  `WEBSITE` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `PARENT` bigint(21) DEFAULT '0',
  `STATUS` tinyint(2) DEFAULT '1',
  `SCS` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`ID`, `NAME`, `TYPE`, `ADDRESS`, `PHONE`, `WEBSITE`, `EMAIL`, `PARENT`, `STATUS`, `SCS`) VALUES
(1, 'REN PHONES', 'COMPANY', 'RenPhones, \r\nDepartment of Ren Wing\r\n2050 Bamako Place\r\nWashington, DC 20521-2050.', '023882038244', 'http://www.renphones.com', 'contact@renphones.com', 0, 1, 1),
(2, 'TOUCH PHONES', 'COMPANY', 'American Consul\r\nDepartment of Touch\r\n6170 Peshwar Place\r\nWashington, DC 20521-6170', '038489387454', 'http://www.touchphones.com', 'contact@touchphones.com', 0, 1, 0),
(3, 'New Company-Test', 'COMPANY', 'California', '4567895412', '', 'company@company.com', 0, 0, 0),
(4, 'company four', 'COMPANY', 'company four', '4567894565', 'www.companyfour.com', 'companyfour@companyfour.cc', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_users`
--

CREATE TABLE IF NOT EXISTS `company_users` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `USER_ID` varchar(20) DEFAULT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `PARENT` bigint(21) DEFAULT '0',
  `ROLE_ID` bigint(21) DEFAULT NULL,
  `ROLE_NAME` varchar(50) DEFAULT NULL,
  `PROFILE_PIC` varchar(150) DEFAULT NULL,
  `EMAIL_ID` varchar(100) DEFAULT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `COMPANY` bigint(21) DEFAULT NULL,
  `SUBCONTRACTOR` bigint(21) DEFAULT '0',
  `ADDED_ON` datetime DEFAULT NULL,
  `ADDED_BY` varchar(200) DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  `DOB` date DEFAULT NULL,
  `SOCIAL` varchar(50) DEFAULT NULL,
  `ADDRESS_ONE` text,
  `ADDRESS_TWO` text,
  `STATE` text,
  `ZIP_CODE` text,
  `DL` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `company_users`
--

INSERT INTO `company_users` (`ID`, `USER_ID`, `NAME`, `PARENT`, `ROLE_ID`, `ROLE_NAME`, `PROFILE_PIC`, `EMAIL_ID`, `PHONE`, `COMPANY`, `SUBCONTRACTOR`, `ADDED_ON`, `ADDED_BY`, `STATUS`, `DOB`, `SOCIAL`, `ADDRESS_ONE`, `ADDRESS_TWO`, `STATE`, `ZIP_CODE`, `DL`) VALUES
(1, '1', 'IVAN', NULL, 1, 'SUPERADMIN', NULL, 'manager2@gmail.com', '', 0, 0, NULL, NULL, 1, '0000-00-00', 'lkjlj', 'l', NULL, NULL, NULL, NULL),
(2, '-1', 'OEM', 0, -1, 'OEM', NULL, 'manager2@gmail.com', '', 0, 0, '2017-07-07 21:00:11', NULL, 1, '0000-00-00', 'lkjlj', 'l', NULL, NULL, NULL, NULL),
(6, '20170825011115', 'staff', 1, 4, 'STAFF', NULL, 'staff@gmail.com', '8965230147', 1, 0, '2017-08-25 01:11:15', '1', 1, '0000-00-00', 'JURIJ43L', 'street no 4', '', 'CA', '56982', 'ERT5KI6'),
(7, '20170825011424', 'subcon', 0, 3, 'SUB CONTRACTOR', NULL, 'subcon@gmail.com', '7896521403', 1, 0, '2017-08-25 01:14:24', '1', 1, '1995-08-24', 'JDFIUE67JFDG', '', '', '', '', '4DFDSF6G'),
(8, '20170825024712', 'R Director', 1, 2, 'DIRECTOR', NULL, 'rdirector@gmail.com', '5425643025', 1, 0, '2017-08-25 02:47:12', '1', 1, '1990-08-01', 'SSN00348', 'Address one', 'Address Two', 'AL', '08542', 'DL08343535'),
(9, '20170825025435', 'Manager One', 20170825011424, 6, 'MANAGER', NULL, 'manager1@gmail.com', '5147829634', 1, 20170825011424, '2017-08-25 02:54:35', '20170825011424', 1, '1999-08-04', 'SSN0098034', 'Address One', '', 'AZ', '08452', 'DL00834'),
(10, '20170825030340', 'Self Manager', 20170825011424, 6, 'MANAGER', NULL, 'manager3@gmail.com', '5412036985', 1, 20170825011424, '2017-08-25 03:03:40', '20170825011424', 1, '1999-02-04', 'SSN)998834', 'Address One', 'Address Two', 'KS', '08452', 'DL09834'),
(11, '20170825031301', 'Employee One', 0, 7, 'EMPLOYEE', NULL, 'empone@gmail.com', '5412365236', 1, 0, '2017-08-25 03:13:01', '1', 1, '0000-00-00', 'SSN90834', 'Lane 5-98', 'Address Line Two', 'IL', '05428', 'DL990834');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE IF NOT EXISTS `credentials` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `USER_NAME` varchar(50) DEFAULT NULL,
  `PASS_WORD` varchar(150) DEFAULT NULL,
  `LOGIN_DT` datetime DEFAULT NULL,
  `USER_ID` varchar(100) DEFAULT NULL,
  `PRE_FIX` varchar(35) DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`ID`, `USER_NAME`, `PASS_WORD`, `LOGIN_DT`, `USER_ID`, `PRE_FIX`, `STATUS`) VALUES
(1, 'ivan', '2c42e5cf1cdbafea04ed267018ef1511', '2017-08-25 03:29:44', '1', 'SU', 1),
(5, 'stafff', 'e7626ee3faf17d01eb55cd05d4de6daa', '2017-08-25 01:12:17', '20170825011115', 'STF', 1),
(6, 'subcon', '351fe0ebd8eeb4683f9d3b43e4b84f37', '2017-08-25 02:49:54', '20170825011424', 'SBC', 1),
(7, 'rdirector', 'e10adc3949ba59abbe56e057f20f883e', '2017-08-25 02:47:59', '20170825024712', 'DIR', 1),
(8, 'manager1', 'e10adc3949ba59abbe56e057f20f883e', '2017-08-25 03:06:34', '20170825025435', 'MGR', 1),
(9, 'manager2', 'e10adc3949ba59abbe56e057f20f883e', NULL, '20170825030340', 'MGR', 1),
(10, 'empone', 'e10adc3949ba59abbe56e057f20f883e', '2017-08-25 03:13:18', '20170825031301', 'EMP', 1);

-- --------------------------------------------------------

--
-- Table structure for table `import_data`
--

CREATE TABLE IF NOT EXISTS `import_data` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(50) DEFAULT NULL,
  `imei` varchar(100) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `added_on` datetime DEFAULT NULL,
  `company` bigint(21) DEFAULT NULL,
  `added_by` bigint(21) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=334 ;

--
-- Dumping data for table `import_data`
--

INSERT INTO `import_data` (`id`, `po_number`, `imei`, `status`, `added_on`, `company`, `added_by`) VALUES
(329, '238', '11181', 1, '2017-08-25 01:15:34', 1, 20170825011115),
(330, '238', '11182', 1, '2017-08-25 01:15:34', 1, 20170825011115),
(331, '238', '11183', 1, '2017-08-25 01:15:34', 1, 20170825011115),
(332, '238', '11184', 1, '2017-08-25 01:15:34', 1, 20170825011115),
(333, 'PO0987', '123', 1, '2017-08-25 03:32:33', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `IMEI` varchar(30) DEFAULT NULL,
  `USER_TYPE` varchar(50) DEFAULT NULL,
  `IMEI_STATUS` varchar(30) DEFAULT NULL,
  `PO_NUMBER` varchar(50) DEFAULT NULL,
  `ADDED_BY` bigint(21) DEFAULT NULL,
  `ADDED_ON` datetime DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  `ASSIGNED_TO` bigint(21) DEFAULT NULL,
  `MODIFIED_ON` datetime DEFAULT NULL,
  `USER_ID` bigint(21) DEFAULT NULL,
  `MODIFIED_BY` bigint(21) DEFAULT NULL,
  `UNIQUE_ID` bigint(21) DEFAULT NULL,
  `HAVE_ACCESS` text,
  `TRACKING` varchar(50) DEFAULT NULL,
  `PER_PO_NUMBER` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4521 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`ID`, `IMEI`, `USER_TYPE`, `IMEI_STATUS`, `PO_NUMBER`, `ADDED_BY`, `ADDED_ON`, `STATUS`, `ASSIGNED_TO`, `MODIFIED_ON`, `USER_ID`, `MODIFIED_BY`, `UNIQUE_ID`, `HAVE_ACCESS`, `TRACKING`, `PER_PO_NUMBER`) VALUES
(4515, '5623987', 'SUPERADMIN', 'SHIPPED_IN', '2017082513140849', 20170825011115, '2017-08-25 01:12:47', 1, 20170825011424, '2017-08-25 01:14:49', 1, 1, 201708250112472421, '20170825011115 20170825011424', NULL, 'PO6'),
(4516, '11181', 'SUPERADMIN', 'SHIPPED_IN', '2017082514290807', 20170825011115, '2017-08-25 01:16:26', 1, 20170825011424, '2017-08-25 02:29:07', 1, 1, 201708250116263877, '20170825011115 20170825011424', NULL, '238'),
(4517, '123', 'MANAGER', 'ACTIVATED', '2017082515060808', 20170825024712, '2017-08-25 02:56:21', 0, 20170825030925, '2017-08-25 03:30:06', 20170825030925, 1, 201708250256212899, '20170825025435', NULL, 'PO0987'),
(4518, '234', 'DIRECTOR', 'SHIPPED [R]', '2017082515070831', 20170825024712, '2017-08-25 02:56:21', 1, 20170825024712, '2017-08-25 03:07:31', 20170825025435, 20170825025435, 201708250256212899, '20170825011424 20170825025435 20170825024712', NULL, 'PO0987'),
(4519, '345', 'DIRECTOR', 'CHECKED_IN', 'PO0987', 20170825024712, '2017-08-25 02:56:21', 1, 0, '2017-08-25 02:56:21', 20170825024712, 20170825024712, 201708250256212899, '20170825024712', NULL, 'PO0987'),
(4520, '23456', 'DIRECTOR', 'CHECKED_IN', 'PO0987', 20170825024712, '2017-08-25 02:56:21', 1, 0, '2017-08-25 02:56:21', 20170825024712, 20170825024712, 201708250256212899, '20170825024712', NULL, 'PO0987');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_log`
--

CREATE TABLE IF NOT EXISTS `inventory_log` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `IMEI` varchar(30) DEFAULT NULL,
  `USER_TYPE` varchar(50) DEFAULT NULL,
  `IMEI_STATUS` varchar(30) DEFAULT NULL,
  `PO_NUMBER` varchar(50) DEFAULT NULL,
  `ADDED_BY` bigint(21) DEFAULT NULL,
  `ADDED_ON` datetime DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  `ASSIGNED_TO` bigint(21) DEFAULT NULL,
  `DESCRIPTION` text,
  `UNIQUE_ID` bigint(21) DEFAULT NULL,
  `TRACKING` varchar(35) DEFAULT NULL,
  `REASON` text,
  `REASON_SMALL` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5839 ;

--
-- Dumping data for table `inventory_log`
--

INSERT INTO `inventory_log` (`ID`, `IMEI`, `USER_TYPE`, `IMEI_STATUS`, `PO_NUMBER`, `ADDED_BY`, `ADDED_ON`, `STATUS`, `ASSIGNED_TO`, `DESCRIPTION`, `UNIQUE_ID`, `TRACKING`, `REASON`, `REASON_SMALL`) VALUES
(5821, '5623987', 'STAFF', 'CHECKED_IN', 'PO6', 20170825011115, '2017-08-25 01:12:47', 1, 0, 'Checked in by staff ( STAFF)', 201708250112472421, '', '', ''),
(5822, '5623987', 'SUPERADMIN', 'SHIPPED_IN', '2017082513140849', 1, '2017-08-25 01:14:49', 1, 20170825011424, 'Shipped to subcon ( SUB CONTRACTOR)', 201708250112472421, '2017082513140849', '', ''),
(5823, '11181', 'STAFF', 'CHECKED_IN', '238', 20170825011115, '2017-08-25 01:16:26', 1, 0, 'Checked in by staff ( STAFF)', 201708250116263877, '', '', ''),
(5824, '11181', 'SUPERADMIN', 'SHIPPED_IN', '2017082514290807', 1, '2017-08-25 02:29:07', 1, 20170825011424, 'Shipped to subcon ( SUB CONTRACTOR)', 201708250116263877, '2017082514290807', '', ''),
(5825, '123', 'DIRECTOR', 'CHECKED_IN', 'PO0987', 20170825024712, '2017-08-25 02:56:21', 1, 0, 'Checked in by R Director ( DIRECTOR)', 201708250256212899, '', '', ''),
(5826, '234', 'DIRECTOR', 'CHECKED_IN', 'PO0987', 20170825024712, '2017-08-25 02:56:21', 1, 0, 'Checked in by R Director ( DIRECTOR)', 201708250256212899, '', '', ''),
(5827, '345', 'DIRECTOR', 'CHECKED_IN', 'PO0987', 20170825024712, '2017-08-25 02:56:21', 1, 0, 'Checked in by R Director ( DIRECTOR)', 201708250256212899, '', '', ''),
(5828, '23456', 'DIRECTOR', 'CHECKED_IN', 'PO0987', 20170825024712, '2017-08-25 02:56:21', 1, 0, 'Checked in by R Director ( DIRECTOR)', 201708250256212899, '', '', ''),
(5829, '123', 'DIRECTOR', 'SHIPPED_IN', '2017082514570823', 20170825024712, '2017-08-25 02:57:23', 1, 20170825011424, 'Shipped to subcon ( SUB CONTRACTOR)', 201708250256212899, '2017082514570823', '', ''),
(5830, '234', 'DIRECTOR', 'SHIPPED_IN', '2017082514570823', 20170825024712, '2017-08-25 02:57:23', 1, 20170825011424, 'Shipped to subcon ( SUB CONTRACTOR)', 201708250256212899, '2017082514570823', '', ''),
(5831, '123', 'SUB CONTRACTOR', 'CHECKED_IN', '2017082514570823', 20170825011424, '2017-08-25 03:05:08', 1, 0, 'Checked in by subcon ( SUB CONTRACTOR)', 201708250256212899, '', '', ''),
(5832, '234', 'SUB CONTRACTOR', 'CHECKED_IN', '2017082514570823', 20170825011424, '2017-08-25 03:05:08', 1, 0, 'Checked in by subcon ( SUB CONTRACTOR)', 201708250256212899, '', '', ''),
(5833, '123', 'SUB CONTRACTOR', 'SHIPPED_IN', '2017082515060808', 20170825011424, '2017-08-25 03:06:08', 1, 89, 'Shipped to LOCATION ONE', 201708250256212899, '2017082515060808', '', ''),
(5834, '234', 'SUB CONTRACTOR', 'SHIPPED_IN', '2017082515060808', 20170825011424, '2017-08-25 03:06:08', 1, 89, 'Shipped to LOCATION ONE', 201708250256212899, '2017082515060808', '', ''),
(5835, '123', 'MANAGER', 'CHECKED_IN', '2017082515060808', 20170825025435, '2017-08-25 03:07:00', 1, 0, 'Checked in by Manager One ( MANAGER)', 201708250256212899, '', '', ''),
(5836, '234', 'DIRECTOR', 'SHIPPED [R]', '2017082515070831', 20170825025435, '2017-08-25 03:07:31', 1, 20170825024712, 'Returned to R Director ( DIRECTOR) ', 201708250256212899, '2017082515070831', 'Damaged Phone Returned', 'DAMAGED'),
(5837, '123', 'MANAGER', 'ASSIGNED', '', 20170825030925, '2017-08-25 03:10:49', 1, 20170825030925, 'Assigned to Agent Agent One One ( AGENT ) ', 0, '', '', ''),
(5838, '123', 'SUPERADMIN', 'ACTIVATED', '2017082515060808', 1, '2017-08-25 03:30:06', 1, 0, 'IMEI has been activated.', 201708250256212899, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_po`
--

CREATE TABLE IF NOT EXISTS `inventory_po` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `PO_NUMBER` varchar(50) DEFAULT NULL,
  `ADDED_ON` datetime DEFAULT NULL,
  `ADDED_BY` bigint(21) DEFAULT NULL,
  `USER_TYPE` varchar(50) DEFAULT NULL,
  `PO_STATUS` varchar(50) DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  `ASSIGNED_TO` bigint(21) DEFAULT '0',
  `UNIQUE_ID` bigint(21) DEFAULT NULL,
  `TRACKING` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219 ;

--
-- Dumping data for table `inventory_po`
--

INSERT INTO `inventory_po` (`ID`, `PO_NUMBER`, `ADDED_ON`, `ADDED_BY`, `USER_TYPE`, `PO_STATUS`, `STATUS`, `ASSIGNED_TO`, `UNIQUE_ID`, `TRACKING`) VALUES
(214, 'PO6', '2017-08-25 01:12:47', 20170825011115, 'STAFF', 'CHECKED_IN', 1, 0, 201708250112472421, NULL),
(215, '238', '2017-08-25 01:16:26', 20170825011115, 'STAFF', 'CHECKED_IN', 1, 0, 201708250116263877, NULL),
(216, 'PO0987', '2017-08-25 02:56:21', 20170825024712, 'DIRECTOR', 'CHECKED_IN', 1, 0, 201708250256212899, NULL),
(217, '2017082514570823', '2017-08-25 03:05:08', 20170825011424, 'SUB CONTRACTOR', 'CHECKED_IN', 1, 0, 201708250256212899, NULL),
(218, '2017082515060808', '2017-08-25 03:07:00', 20170825025435, 'MANAGER', 'CHECKED_IN', 1, 0, 201708250256212899, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(200) DEFAULT NULL,
  `DIRECTOR` bigint(21) DEFAULT NULL,
  `SUBCONTRACTOR` bigint(21) DEFAULT NULL,
  `MANAGER` bigint(21) DEFAULT NULL,
  `ADDRESS` text,
  `COMPANY` bigint(21) DEFAULT NULL,
  `ADDED_BY` bigint(21) DEFAULT NULL,
  `ADDED_ON` datetime DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT '1',
  `IS_SELF` tinyint(2) DEFAULT '0',
  `ADDRESS_1` text,
  `ADDRESS_2` text,
  `ZIPCODE` varchar(10) DEFAULT NULL,
  `STATE` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`ID`, `NAME`, `DIRECTOR`, `SUBCONTRACTOR`, `MANAGER`, `ADDRESS`, `COMPANY`, `ADDED_BY`, `ADDED_ON`, `STATUS`, `IS_SELF`, `ADDRESS_1`, `ADDRESS_2`, `ZIPCODE`, `STATE`) VALUES
(89, 'LOCATION ONE', 20170825024712, 20170825011424, 20170825025435, 'Address One Address One 05489', 1, 1, '2017-08-25 02:51:38', 1, 0, 'Address One', 'Address two', '05489', 'AL'),
(90, 'SELF LOCATION ONE', 0, 20170825011424, 20170825030340, 'Address One Address One 08542', 1, 20170825011424, '2017-08-25 02:58:21', 1, 1, 'Address One', 'Address Two', '08542', 'AL');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) DEFAULT NULL,
  `M_CODE` varchar(10) DEFAULT NULL,
  `PARENT_ID` bigint(21) DEFAULT '0',
  `STATUS` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`ID`, `NAME`, `M_CODE`, `PARENT_ID`, `STATUS`) VALUES
(1, 'MANAGE USERS & LOCATION', 'UL', 0, 1),
(2, 'MANAGE INVENTORY', 'INV', 0, 1),
(3, 'MANAGE DIRECTORS', 'DIR', 1, 1),
(4, 'MANAGE SUB-CONTRACTORS', 'SUBC', 1, 1),
(5, 'MANAGE MANAGERS', 'MGR', 1, 1),
(6, 'MANAGE AGENTS', 'AGNT', 1, 1),
(7, 'MANAGE STAFF', 'STF', 1, 1),
(8, 'MANAGE EMPLOYEE', 'EMP', 1, 1),
(9, 'CHECKIN INVENTORY', 'CINV', 2, 1),
(10, 'SHIP INVENTORY', 'SINV', 2, 1),
(11, 'ASSIGN INVENTORY', 'AINV', 2, 1),
(12, 'INVENTORY STATUS', 'INVS', 0, 0),
(13, 'RE-CHECKIN', 'INVD', 2, 1),
(14, 'UN-USED', 'INVUU', 2, 0),
(15, 'PRE-QUALIFIED', 'INVPQ', 2, 0),
(16, 'QUALIFIED', 'INVQ', 2, 0),
(17, 'MANAGE LOCATION', 'LOC', 1, 1),
(18, 'RETURN INVENTORY', 'RINV', 2, 1),
(19, 'IMPORT & VERIFY', 'IMV', 2, 1),
(20, 'ACTIVATION', 'ACT', 2, 1),
(21, 'MANAGE AGENT APPLICATION', 'AGAP', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(20) DEFAULT NULL,
  `PERMISSIONS` varchar(200) DEFAULT NULL,
  `ROLE_DESC` text,
  `ADDED_BY` bigint(21) DEFAULT NULL,
  `ADDED_ON` datetime DEFAULT NULL,
  `STATUS` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`ID`, `ROLE_NAME`, `PERMISSIONS`, `ROLE_DESC`, `ADDED_BY`, `ADDED_ON`, `STATUS`) VALUES
(1, 'SUPERADMIN', '', NULL, NULL, NULL, 1),
(2, 'DIRECTOR', '1,2,4,5,7,8,17,9,10,13,18,19,20', NULL, NULL, NULL, 1),
(3, 'SUB CONTRACTOR', '1,2,5,17,9,10,11,18', NULL, NULL, NULL, 1),
(4, 'STAFF', '2,9,19,20', NULL, NULL, NULL, 1),
(5, 'AGENTS', '', NULL, NULL, NULL, 1),
(6, 'MANAGER', '1,2,6,9,11,13,18', NULL, NULL, NULL, 1),
(7, 'EMPLOYEE', '1,6,21', NULL, NULL, NULL, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
