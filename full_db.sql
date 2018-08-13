-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for reprodata
DROP DATABASE IF EXISTS `reprodata`;
CREATE DATABASE IF NOT EXISTS `reprodata` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `reprodata`;

-- Dumping structure for table reprodata.codes
DROP TABLE IF EXISTS `codes`;
CREATE TABLE IF NOT EXISTS `codes` (
  `cde_code_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cde_type` varchar(30) DEFAULT NULL,
  `cde_table_field` varchar(60) DEFAULT NULL,
  `cde_table_field2` varchar(60) DEFAULT NULL,
  `cde_table_field3` varchar(60) DEFAULT NULL,
  `cde_value` varchar(100) DEFAULT NULL,
  `cde_value_label` varchar(30) DEFAULT NULL,
  `cde_value_2` varchar(100) DEFAULT NULL,
  `cde_value_label_2` varchar(30) DEFAULT NULL,
  `cde_option_value` varchar(255) DEFAULT NULL,
  `cde_option_label` varchar(30) DEFAULT NULL,
  `cde_created_date_time` datetime DEFAULT NULL,
  `cde_created_by` int(8) DEFAULT NULL,
  `cde_last_update_date_time` datetime DEFAULT NULL,
  `cde_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`cde_code_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 COMMENT='Codes';

-- Dumping data for table reprodata.codes: ~38 rows (approximately)
/*!40000 ALTER TABLE `codes` DISABLE KEYS */;
INSERT INTO `codes` (`cde_code_ID`, `cde_type`, `cde_table_field`, `cde_table_field2`, `cde_table_field3`, `cde_value`, `cde_value_label`, `cde_value_2`, `cde_value_label_2`, `cde_option_value`, `cde_option_label`, `cde_created_date_time`, `cde_created_by`, `cde_last_update_date_time`, `cde_last_update_by`) VALUES
	(1, 'code', 'customers#cst_city_code_ID', NULL, NULL, 'Cities', 'City Name', 'CityShort', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'code', 'customers#cst_business_type_code_ID', NULL, NULL, 'BusinessType', 'Business Type', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'BusinessType', NULL, NULL, NULL, 'Bank', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'BusinessType', NULL, NULL, NULL, 'Insurance', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'BusinessType', NULL, NULL, NULL, 'Private', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'Cities', NULL, NULL, NULL, 'Nicosia', 'City Name', 'NIC', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 'Cities', NULL, NULL, NULL, 'Limassol', 'City Name', 'LIM', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'Cities', NULL, NULL, NULL, 'Larnaca', 'City Name', 'LAR', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 'Cities', NULL, NULL, NULL, 'Paphos', 'City Name', 'PAF', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL),
	(10, 'Cities', NULL, NULL, NULL, 'Famagusta', 'City Name', 'FAM', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL),
	(11, 'BusinessType', NULL, NULL, NULL, 'Public School', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(12, 'BusinessType', NULL, NULL, NULL, 'Accounting', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(13, 'BusinessType', NULL, NULL, NULL, 'Law', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 'BusinessType', NULL, NULL, NULL, 'Private School', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(15, 'code', 'customers#cst_contact_person_title_code_ID', NULL, NULL, 'ContactPersonTitle', 'Contact Person Title', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
	(16, 'ContactPersonTitle', NULL, NULL, NULL, 'Owner', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(17, 'ContactPersonTitle', NULL, NULL, NULL, 'Secretary', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(18, 'ContactPersonTitle', NULL, NULL, NULL, 'Director', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(19, 'ContactPersonTitle', NULL, NULL, NULL, 'IT Manager', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(20, 'ContactPersonTitle', NULL, NULL, NULL, 'IT Technitian', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(21, 'code', 'manufacturers#mnf_country_code_ID', NULL, NULL, 'Countries', 'Country Name', '', 'Short Code', NULL, NULL, NULL, NULL, NULL, NULL),
	(22, 'Countries', NULL, NULL, NULL, 'Cyprus', 'Country Name', 'CYP', 'Short Code', NULL, NULL, NULL, NULL, NULL, NULL),
	(23, 'Countries', NULL, NULL, NULL, 'Germany', 'Country Name', 'DEU', 'Short Code', NULL, NULL, NULL, NULL, NULL, NULL),
	(24, 'Countries', NULL, NULL, NULL, 'Greece', 'Country Name', 'GRC', 'Short Code', NULL, NULL, NULL, NULL, NULL, NULL),
	(25, 'code', 'products#prd_sub_type_code_ID', NULL, NULL, 'ProductsSubType', 'Products SubType', '', '', 'Machine#Consumables#Spare Parts', 'For Type', NULL, NULL, '2018-08-13 23:00:29', 1),
	(27, 'ProductsSubType', NULL, NULL, NULL, 'MultiFunction', 'Products SubType', NULL, '', 'Machine', NULL, '2018-08-13 23:03:56', 1, '2018-08-13 23:41:01', 1),
	(28, 'ProductsSubType', NULL, NULL, NULL, 'Printer', 'Products SubType', NULL, '', 'Machine', NULL, '2018-08-13 23:45:21', 1, NULL, NULL),
	(29, 'ProductsSubType', NULL, NULL, NULL, 'Toners', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:45:30', 1, NULL, NULL),
	(30, 'ProductsSubType', NULL, NULL, NULL, 'Waste Box', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:45:39', 1, NULL, NULL),
	(31, 'ProductsSubType', NULL, NULL, NULL, 'Stables', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:45:48', 1, NULL, NULL),
	(32, 'ProductsSubType', NULL, NULL, NULL, 'Developers', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:45:58', 1, NULL, NULL),
	(33, 'ProductsSubType', NULL, NULL, NULL, 'Drums', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:46:06', 1, NULL, NULL),
	(34, 'ProductsSubType', NULL, NULL, NULL, 'CL.Blades', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:46:19', 1, NULL, NULL),
	(35, 'ProductsSubType', NULL, NULL, NULL, 'Heat Rollers/Belts', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:46:35', 1, NULL, NULL),
	(36, 'ProductsSubType', NULL, NULL, NULL, 'Press Rollers', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:46:45', 1, NULL, NULL),
	(37, 'ProductsSubType', NULL, NULL, NULL, 'Feed Rollers', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:46:54', 1, NULL, NULL),
	(38, 'ProductsSubType', NULL, NULL, NULL, 'Maintenance Kits', 'Products SubType', NULL, '', 'Consumables', NULL, '2018-08-13 23:47:05', 1, NULL, NULL),
	(39, 'ProductsSubType', NULL, NULL, NULL, 'Spare Parts', 'Products SubType', NULL, '', 'Spare Parts', NULL, '2018-08-13 23:47:14', 1, NULL, NULL);
/*!40000 ALTER TABLE `codes` ENABLE KEYS */;

-- Dumping structure for table reprodata.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `cst_customer_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cst_identity_card` int(20) DEFAULT NULL,
  `cst_name` varchar(100) DEFAULT NULL,
  `cst_surname` varchar(150) DEFAULT NULL,
  `cst_address_line_1` varchar(150) DEFAULT NULL,
  `cst_address_line_2` varchar(150) DEFAULT NULL,
  `cst_city_code_ID` varchar(30) DEFAULT NULL,
  `cst_contact_person` varchar(100) DEFAULT NULL,
  `cst_contact_person_title_code_ID` varchar(30) DEFAULT NULL,
  `cst_work_tel_1` varchar(30) DEFAULT NULL,
  `cst_work_tel_2` varchar(30) DEFAULT NULL,
  `cst_fax` varchar(30) DEFAULT NULL,
  `cst_mobile_1` varchar(30) DEFAULT NULL,
  `cst_mobile_2` varchar(30) DEFAULT NULL,
  `cst_email` varchar(50) DEFAULT NULL,
  `cst_email_newsletter` varchar(100) DEFAULT NULL,
  `cst_business_type_code_ID` int(8) DEFAULT NULL,
  `cst_created_date_time` datetime DEFAULT NULL,
  `cst_created_by` int(8) DEFAULT NULL,
  `cst_last_update_date_time` datetime DEFAULT NULL,
  `cst_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`cst_customer_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Customers';

-- Dumping data for table reprodata.customers: ~1 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`cst_customer_ID`, `cst_identity_card`, `cst_name`, `cst_surname`, `cst_address_line_1`, `cst_address_line_2`, `cst_city_code_ID`, `cst_contact_person`, `cst_contact_person_title_code_ID`, `cst_work_tel_1`, `cst_work_tel_2`, `cst_fax`, `cst_mobile_1`, `cst_mobile_2`, `cst_email`, `cst_email_newsletter`, `cst_business_type_code_ID`, `cst_created_date_time`, `cst_created_by`, `cst_last_update_date_time`, `cst_last_update_by`) VALUES
	(1, 786613, 'Michael', 'Ermogenous', 'add1', 'add2', '8', NULL, '18', 'tel1', 'tel2', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, '2018-08-12 12:01:30', 1);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping structure for table reprodata.ip_locations
DROP TABLE IF EXISTS `ip_locations`;
CREATE TABLE IF NOT EXISTS `ip_locations` (
  `ipl_ip_location_serial` int(10) NOT NULL AUTO_INCREMENT,
  `ipl_ip` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `ipl_hostname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ipl_city` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ipl_region` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ipl_country` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `ipl_location` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ipl_provider` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ipl_last_check` datetime DEFAULT NULL,
  PRIMARY KEY (`ipl_ip_location_serial`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.ip_locations: ~0 rows (approximately)
/*!40000 ALTER TABLE `ip_locations` DISABLE KEYS */;
INSERT INTO `ip_locations` (`ipl_ip_location_serial`, `ipl_ip`, `ipl_hostname`, `ipl_city`, `ipl_region`, `ipl_country`, `ipl_location`, `ipl_provider`, `ipl_last_check`) VALUES
	(1, '::1', '', '', '', '', '', '', '2018-08-06 10:29:44');
/*!40000 ALTER TABLE `ip_locations` ENABLE KEYS */;

-- Dumping structure for table reprodata.log_file
DROP TABLE IF EXISTS `log_file`;
CREATE TABLE IF NOT EXISTS `log_file` (
  `lgf_log_file_ID` int(10) NOT NULL AUTO_INCREMENT,
  `lgf_user_ID` int(10) DEFAULT NULL,
  `lgf_ip` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `lgf_date_time` datetime DEFAULT NULL,
  `lgf_table_name` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `lgf_row_serial` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `lgf_action` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `lgf_new_values` text COLLATE utf8_bin,
  `lgf_old_values` text COLLATE utf8_bin,
  `lgf_description` text COLLATE utf8_bin,
  PRIMARY KEY (`lgf_log_file_ID`),
  KEY `lgf_user_ID` (`lgf_user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.log_file: ~138 rows (approximately)
/*!40000 ALTER TABLE `log_file` DISABLE KEYS */;
INSERT INTO `log_file` (`lgf_log_file_ID`, `lgf_user_ID`, `lgf_ip`, `lgf_date_time`, `lgf_table_name`, `lgf_row_serial`, `lgf_action`, `lgf_new_values`, `lgf_old_values`, `lgf_description`) VALUES
	(1, 0, '::1', '2018-07-21 10:21:02', 'ip_locations', '1', 'UPDATE RECORD', 'ipl_last_check = \'2018-07-21 10:21:02\'\r\n', 'ipl_last_check = \'2018-07-05 12:15:49\'\r\n', 'UPDATE `ip_locations` SET \n`ipl_last_check` = \'2018-07-21 10:21:02\' \nWHERE ipl_ip_location_serial = 1'),
	(2, 0, '::1', '2018-08-06 10:29:44', 'ip_locations', '1', 'UPDATE RECORD', 'ipl_last_check = \'2018-08-06 10:29:44\'\r\n', 'ipl_last_check = \'2018-07-21 10:21:02\'\r\n', 'UPDATE `ip_locations` SET \n`ipl_last_check` = \'2018-08-06 10:29:44\' \nWHERE ipl_ip_location_serial = 1'),
	(3, 1, '::1', '2018-08-06 10:34:37', 'users', '3', 'UPDATE RECORD', 'usr_name = \'TEST \'\r\nusr_name_gr = \'\'\r\nusr_name_en = \'\'\r\nusr_username = \'\'\r\nusr_password = \'12345\'\r\n', 'usr_name = \'Agent TEST \'\r\nusr_name_gr = \'Ασφαλιστής\'\r\nusr_name_en = \'Agent\'\r\nusr_username = \'agentTest\'\r\nusr_password = \'agentTest12345\'\r\n', 'UPDATE `users` SET \n`usr_name` = \'TEST \' \n, `usr_name_gr` = \'\' \n, `usr_name_en` = \'\' \n, `usr_username` = \'\' \n, `usr_password` = \'12345\' \nWHERE `usr_users_ID` = 3'),
	(4, 1, '::1', '2018-08-06 11:52:26', 'codes', '1', 'UPDATE RECORD', 'cde_value_label = \'City Names\'\r\n', 'cde_value_label = \'City Name\'\r\n', 'UPDATE `codes` SET \n`cde_value_label` = \'City Names\' \nWHERE `cde_code_ID` = 1'),
	(5, 1, '::1', '2018-08-06 11:55:16', 'codes', '2', 'INSERT RECORD', 'cde_type = code \r\ncde_value_label = Business Type \r\ncde_value = BusinessType \r\ncde_value_label_2 =  \r\ncde_value_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'code\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'BusinessType\' \n , `cde_value_label_2` = \'\' \n , `cde_value_2` = \'\' \n'),
	(6, 1, '::1', '2018-08-06 12:28:37', 'codes', '3', 'INSERT RECORD', 'cde_type = code \r\ncde_value_label = Business Type \r\ncde_value = BANK \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'code\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'BANK\' \n , `cde_value_label_2` = \'\' \n'),
	(7, 1, '::1', '2018-08-06 12:34:14', 'codes', '4', 'INSERT RECORD', 'cde_type = Business Type \r\ncde_value_label = Business Type \r\ncde_value = Insurance \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Business Type\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'Insurance\' \n , `cde_value_label_2` = \'\' \n'),
	(8, 1, '::1', '2018-08-06 12:35:06', 'codes', '5', 'INSERT RECORD', 'cde_type = BusinessType \r\ncde_value_label = Business Type \r\ncde_value = Private \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'BusinessType\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'Private\' \n , `cde_value_label_2` = \'\' \n'),
	(9, 1, '::1', '2018-08-06 12:42:18', 'codes', '3', 'UPDATE RECORD', 'cde_value = \'Bank\'\r\n', 'cde_value = \'BANK\'\r\n', 'UPDATE `codes` SET \n`cde_value` = \'Bank\' \nWHERE `cde_code_ID` = 3'),
	(10, 1, '::1', '2018-08-06 12:45:00', 'codes', '1', 'UPDATE RECORD', 'cde_value_label_2 = \'City Name Short\'\r\ncde_value_2 = \'CityShort\'\r\n', 'cde_value_label_2 = \'\'\r\ncde_value_2 = \'\'\r\n', 'UPDATE `codes` SET \n`cde_value_label_2` = \'City Name Short\' \n, `cde_value_2` = \'CityShort\' \nWHERE `cde_code_ID` = 1'),
	(11, 1, '::1', '2018-08-06 12:45:11', 'codes', '6', 'INSERT RECORD', 'cde_type = Cities \r\ncde_value_label = City Names \r\ncde_value = Nicosia \r\ncde_value_label_2 = City Name Short \r\ncde_value_2 = NIC \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Cities\' \n , `cde_value_label` = \'City Names\' \n , `cde_value` = \'Nicosia\' \n , `cde_value_label_2` = \'City Name Short\' \n , `cde_value_2` = \'NIC\' \n'),
	(12, 1, '::1', '2018-08-06 12:51:15', 'codes', '1', 'UPDATE RECORD', 'cde_value_label = \'City Name\'\r\n', 'cde_value_label = \'City Names\'\r\n', 'UPDATE `codes` SET \n`cde_value_label` = \'City Name\' \nWHERE `cde_code_ID` = 1'),
	(13, 1, '::1', '2018-08-06 12:51:57', 'codes', '6', 'UPDATE RECORD', 'cde_value_label = \'City Name\'\r\n', 'cde_value_label = \'City Names\'\r\n', 'UPDATE `codes` SET \n`cde_value_label` = \'City Name\' \nWHERE `cde_code_ID` = 6'),
	(14, 1, '::1', '2018-08-06 12:52:23', 'codes', '7', 'INSERT RECORD', 'cde_type = Cities \r\ncde_value_label = City Name \r\ncde_value = Limassol \r\ncde_value_label_2 = City Name Short \r\ncde_value_2 = LIM \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Cities\' \n , `cde_value_label` = \'City Name\' \n , `cde_value` = \'Limassol\' \n , `cde_value_label_2` = \'City Name Short\' \n , `cde_value_2` = \'LIM\' \n'),
	(15, 1, '::1', '2018-08-06 12:52:37', 'codes', '8', 'INSERT RECORD', 'cde_type = Cities \r\ncde_value_label = City Name \r\ncde_value = Larnaca \r\ncde_value_label_2 = City Name Short \r\ncde_value_2 = LAR \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Cities\' \n , `cde_value_label` = \'City Name\' \n , `cde_value` = \'Larnaca\' \n , `cde_value_label_2` = \'City Name Short\' \n , `cde_value_2` = \'LAR\' \n'),
	(16, 1, '::1', '2018-08-06 12:52:48', 'codes', '9', 'INSERT RECORD', 'cde_type = Cities \r\ncde_value_label = City Name \r\ncde_value = Paphos \r\ncde_value_label_2 = City Name Short \r\ncde_value_2 = PAF \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Cities\' \n , `cde_value_label` = \'City Name\' \n , `cde_value` = \'Paphos\' \n , `cde_value_label_2` = \'City Name Short\' \n , `cde_value_2` = \'PAF\' \n'),
	(17, 1, '::1', '2018-08-06 12:53:07', 'codes', '10', 'INSERT RECORD', 'cde_type = Cities \r\ncde_value_label = City Name \r\ncde_value = Famagusta \r\ncde_value_label_2 = City Name Short \r\ncde_value_2 = FAM \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Cities\' \n , `cde_value_label` = \'City Name\' \n , `cde_value` = \'Famagusta\' \n , `cde_value_label_2` = \'City Name Short\' \n , `cde_value_2` = \'FAM\' \n'),
	(18, 1, '::1', '2018-08-06 12:53:56', 'codes', '11', 'INSERT RECORD', 'cde_type = BusinessType \r\ncde_value_label = Business Type \r\ncde_value = Public School \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'BusinessType\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'Public School\' \n , `cde_value_label_2` = \'\' \n'),
	(19, 1, '::1', '2018-08-06 12:54:09', 'codes', '12', 'INSERT RECORD', 'cde_type = BusinessType \r\ncde_value_label = Business Type \r\ncde_value = Accounting \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'BusinessType\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'Accounting\' \n , `cde_value_label_2` = \'\' \n'),
	(20, 1, '::1', '2018-08-06 12:54:18', 'codes', '13', 'INSERT RECORD', 'cde_type = BusinessType \r\ncde_value_label = Business Type \r\ncde_value = Law \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'BusinessType\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'Law\' \n , `cde_value_label_2` = \'\' \n'),
	(21, 1, '::1', '2018-08-06 12:54:31', 'codes', '14', 'INSERT RECORD', 'cde_type = BusinessType \r\ncde_value_label = Business Type \r\ncde_value = Private School \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'BusinessType\' \n , `cde_value_label` = \'Business Type\' \n , `cde_value` = \'Private School\' \n , `cde_value_label_2` = \'\' \n'),
	(22, 1, '::1', '2018-08-06 13:33:00', 'users_groups', '4', 'INSERT RECORD', 'usg_group_name = Michael \r\nusg_restrict_ip =  \r\nusg_permissions =  \r\nusg_approvals =  \r\n', '', 'INSERT INTO `users_groups` SET \n`usg_group_name` = \'Michael\' \n , `usg_restrict_ip` = \'\' \n , `usg_permissions` = \'\' \n , `usg_approvals` = \'\' \n'),
	(23, 1, '::1', '2018-08-06 13:36:52', 'customers', '1', 'INSERT RECORD', 'cst_business_type_ID = 12 \r\ncst_name = Michael \r\ncst_surname = Ermogenous \r\ncst_address_line_1 = add1 \r\ncst_address_line_2 = add2 \r\ncst_city_ID = 8 \r\ncst_work_tel_1 = tel1 \r\ncst_work_tel_2 = tel2 \r\n', '', 'INSERT INTO `customers` SET \n`cst_business_type_ID` = \'12\' \n , `cst_name` = \'Michael\' \n , `cst_surname` = \'Ermogenous\' \n , `cst_address_line_1` = \'add1\' \n , `cst_address_line_2` = \'add2\' \n , `cst_city_ID` = \'8\' \n , `cst_work_tel_1` = \'tel1\' \n , `cst_work_tel_2` = \'tel2\' \n'),
	(24, 1, '::1', '2018-08-06 13:41:42', 'customers', '1', 'UPDATE RECORD', 'cst_business_type_ID = \'5\'\r\n', 'cst_business_type_ID = \'12\'\r\n', 'UPDATE `customers` SET \n`cst_business_type_ID` = \'5\' \nWHERE `cst_customer_ID` = 1'),
	(25, 1, '::1', '2018-08-06 13:41:53', 'customers', '1', 'UPDATE RECORD', 'cst_name = \'Michaela\'\r\ncst_surname = \'Ermogenousa\'\r\ncst_address_line_1 = \'add1a\'\r\ncst_address_line_2 = \'add2a\'\r\ncst_work_tel_1 = \'tel1a\'\r\ncst_work_tel_2 = \'tel2a\'\r\n', 'cst_name = \'Michael\'\r\ncst_surname = \'Ermogenous\'\r\ncst_address_line_1 = \'add1\'\r\ncst_address_line_2 = \'add2\'\r\ncst_work_tel_1 = \'tel1\'\r\ncst_work_tel_2 = \'tel2\'\r\n', 'UPDATE `customers` SET \n`cst_name` = \'Michaela\' \n, `cst_surname` = \'Ermogenousa\' \n, `cst_address_line_1` = \'add1a\' \n, `cst_address_line_2` = \'add2a\' \n, `cst_work_tel_1` = \'tel1a\' \n, `cst_work_tel_2` = \'tel2a\' \nWHERE `cst_customer_ID` = 1'),
	(26, 1, '::1', '2018-08-06 13:42:03', 'customers', '1', 'UPDATE RECORD', 'cst_name = \'Michael\'\r\ncst_surname = \'Ermogenous\'\r\ncst_address_line_1 = \'add1\'\r\ncst_address_line_2 = \'add2\'\r\ncst_work_tel_1 = \'tel1\'\r\ncst_work_tel_2 = \'tel2\'\r\n', 'cst_name = \'Michaela\'\r\ncst_surname = \'Ermogenousa\'\r\ncst_address_line_1 = \'add1a\'\r\ncst_address_line_2 = \'add2a\'\r\ncst_work_tel_1 = \'tel1a\'\r\ncst_work_tel_2 = \'tel2a\'\r\n', 'UPDATE `customers` SET \n`cst_name` = \'Michael\' \n, `cst_surname` = \'Ermogenous\' \n, `cst_address_line_1` = \'add1\' \n, `cst_address_line_2` = \'add2\' \n, `cst_work_tel_1` = \'tel1\' \n, `cst_work_tel_2` = \'tel2\' \nWHERE `cst_customer_ID` = 1'),
	(27, 1, '::1', '2018-08-06 14:03:24', 'codes', '15', 'INSERT RECORD', 'cde_type = code \r\ncde_value_label = Contact Person Title \r\ncde_value = ContactPersonTitle \r\ncde_value_label_2 =  \r\ncde_value_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'code\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'ContactPersonTitle\' \n , `cde_value_label_2` = \'\' \n , `cde_value_2` = \'\' \n'),
	(28, 1, '::1', '2018-08-06 14:03:38', 'codes', '16', 'INSERT RECORD', 'cde_type = ContactPersonTitle \r\ncde_value_label = Contact Person Title \r\ncde_value = Owner \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ContactPersonTitle\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'Owner\' \n , `cde_value_label_2` = \'\' \n'),
	(29, 1, '::1', '2018-08-06 14:03:48', 'codes', '17', 'INSERT RECORD', 'cde_type = ContactPersonTitle \r\ncde_value_label = Contact Person Title \r\ncde_value = Secretary \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ContactPersonTitle\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'Secretary\' \n , `cde_value_label_2` = \'\' \n'),
	(30, 1, '::1', '2018-08-06 14:04:01', 'codes', '18', 'INSERT RECORD', 'cde_type = ContactPersonTitle \r\ncde_value_label = Contact Person Title \r\ncde_value = Director \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ContactPersonTitle\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'Director\' \n , `cde_value_label_2` = \'\' \n'),
	(31, 1, '::1', '2018-08-06 14:04:32', 'codes', '19', 'INSERT RECORD', 'cde_type = ContactPersonTitle \r\ncde_value_label = Contact Person Title \r\ncde_value = IT Manager \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ContactPersonTitle\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'IT Manager\' \n , `cde_value_label_2` = \'\' \n'),
	(32, 1, '::1', '2018-08-06 14:04:40', 'codes', '20', 'INSERT RECORD', 'cde_type = ContactPersonTitle \r\ncde_value_label = Contact Person Title \r\ncde_value = IT Technitian \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ContactPersonTitle\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'IT Technitian\' \n , `cde_value_label_2` = \'\' \n'),
	(33, 1, '::1', '2018-08-09 15:42:03', 'customers', '1', 'UPDATE RECORD', 'cst_identity_card = \'786613\'\r\ncst_contact_person_title_ID = \'16\'\r\n', 'cst_identity_card = \'\'\r\ncst_contact_person_title_ID = \'\'\r\n', 'UPDATE `customers` SET \n`cst_identity_card` = \'786613\' \n, `cst_contact_person_title_ID` = \'16\' \nWHERE `cst_customer_ID` = 1'),
	(34, 1, '::1', '2018-08-09 16:14:56', 'customers', '2', 'INSERT RECORD', 'cst_business_type_ID = 12 \r\ncst_identity_card = 342 \r\ncst_name = sdfs \r\ncst_surname =  \r\ncst_address_line_1 =  \r\ncst_address_line_2 =  \r\ncst_city_ID = 10 \r\ncst_contact_person =  \r\ncst_contact_person_title_ID = 18 \r\ncst_work_tel_1 =  \r\ncst_work_tel_2 =  \r\ncst_fax =  \r\ncst_mobile_1 =  \r\ncst_mobile_2 =  \r\ncst_email =  \r\ncst_email_newsletter =  \r\n`cst_created_date_time` = \'2018-08-09 16:14:56\'`cst_created_by` = \'1\'', '', 'INSERT INTO `customers` SET \n`cst_business_type_ID` = \'12\' \n , `cst_identity_card` = \'342\' \n , `cst_name` = \'sdfs\' \n , `cst_surname` = \'\' \n , `cst_address_line_1` = \'\' \n , `cst_address_line_2` = \'\' \n , `cst_city_ID` = \'10\' \n , `cst_contact_person` = \'\' \n , `cst_contact_person_title_ID` = \'18\' \n , `cst_work_tel_1` = \'\' \n , `cst_work_tel_2` = \'\' \n , `cst_fax` = \'\' \n , `cst_mobile_1` = \'\' \n , `cst_mobile_2` = \'\' \n , `cst_email` = \'\' \n , `cst_email_newsletter` = \'\' \n , `cst_created_date_time` = \'2018-08-09 16:14:56\' \n , `cst_created_by` = \'1\' \n'),
	(35, 1, '::1', '2018-08-09 16:21:17', 'customers', '2', 'UPDATE RECORD', 'cst_contact_person = \'Mike\'\r\n`cst_last_update_date_time` = \'2018-08-09 16:21:17\'`cst_last_update_by` = \'1\'', 'cst_contact_person = \'\'\r\n`cst_last_update_date_time` = \'\'`cst_last_update_by` = \'\'', 'UPDATE `customers` SET \n`cst_contact_person` = \'Mike\' \n , `cst_last_update_date_time` = \'2018-08-09 16:21:17\' \n , `cst_last_update_by` = \'1\' \nWHERE `cst_customer_ID` = 2'),
	(36, 1, '::1', '2018-08-09 16:22:47', 'customers', '2', 'UPDATE RECORD', 'cst_name = \'Test\'\r\n`cst_last_update_date_time` = \'2018-08-09 16:22:47\'`cst_last_update_by` = \'1\'', 'cst_name = \'sdfs\'\r\n`cst_last_update_date_time` = \'2018-08-09 16:21:17\'`cst_last_update_by` = \'1\'', 'UPDATE `customers` SET \n`cst_name` = \'Test\' \n , `cst_last_update_date_time` = \'2018-08-09 16:22:47\' \n , `cst_last_update_by` = \'1\' \nWHERE `cst_customer_ID` = 2'),
	(37, 1, '::1', '2018-08-09 16:24:42', 'customers', '2', 'UPDATE RECORD', 'cst_contact_person_title_ID = \'19\'\r\n`cst_last_update_date_time` = \'2018-08-09 16:24:42\'\n`cst_last_update_by` = \'1\'\n', 'cst_contact_person_title_ID = \'18\'\r\n`cst_last_update_date_time` = \'2018-08-09 16:22:47\'\n`cst_last_update_by` = \'1\'\n', 'UPDATE `customers` SET \n`cst_contact_person_title_ID` = \'19\' \n , `cst_last_update_date_time` = \'2018-08-09 16:24:42\' \n , `cst_last_update_by` = \'1\' \nWHERE `cst_customer_ID` = 2'),
	(38, 1, '::1', '2018-08-09 16:54:07', 'codes', '21', 'INSERT RECORD', 'cde_type = code \r\ncde_value_label = Countries \r\ncde_value = Country Name \r\ncde_value_label_2 = Short Code \r\ncde_value_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'code\' \n , `cde_value_label` = \'Countries\' \n , `cde_value` = \'Country Name\' \n , `cde_value_label_2` = \'Short Code\' \n , `cde_value_2` = \'\' \n'),
	(39, 1, '::1', '2018-08-09 16:54:25', 'codes', '21', 'UPDATE RECORD', 'cde_value_label = \'Country Name\'\r\ncde_value = \'Countries\'\r\n', 'cde_value_label = \'Countries\'\r\ncde_value = \'Country Name\'\r\n', 'UPDATE `codes` SET \n`cde_value_label` = \'Country Name\' \n, `cde_value` = \'Countries\' \nWHERE `cde_code_ID` = 21'),
	(40, 1, '::1', '2018-08-09 16:54:40', 'codes', '22', 'INSERT RECORD', 'cde_type = Countries \r\ncde_value_label = Country Name \r\ncde_value = Cyprus \r\ncde_value_label_2 = Short Code \r\ncde_value_2 = CYP \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Countries\' \n , `cde_value_label` = \'Country Name\' \n , `cde_value` = \'Cyprus\' \n , `cde_value_label_2` = \'Short Code\' \n , `cde_value_2` = \'CYP\' \n'),
	(41, 1, '::1', '2018-08-09 16:55:23', 'codes', '23', 'INSERT RECORD', 'cde_type = Countries \r\ncde_value_label = Country Name \r\ncde_value = Germany \r\ncde_value_label_2 = Short Code \r\ncde_value_2 = DEU \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Countries\' \n , `cde_value_label` = \'Country Name\' \n , `cde_value` = \'Germany\' \n , `cde_value_label_2` = \'Short Code\' \n , `cde_value_2` = \'DEU\' \n'),
	(42, 1, '::1', '2018-08-09 16:55:38', 'codes', '24', 'INSERT RECORD', 'cde_type = Countries \r\ncde_value_label = Country Name \r\ncde_value = Greece \r\ncde_value_label_2 = Short Code \r\ncde_value_2 = GRC \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'Countries\' \n , `cde_value_label` = \'Country Name\' \n , `cde_value` = \'Greece\' \n , `cde_value_label_2` = \'Short Code\' \n , `cde_value_2` = \'GRC\' \n'),
	(43, 1, '::1', '2018-08-09 16:58:58', 'manufacturers', '1', 'INSERT RECORD', 'mnf_code = UTAX \r\nmnf_name = Utax Ltd \r\nmnf_description =  \r\nmnf_country_code_ID = 23 \r\n`mnf_created_date_time` = \'2018-08-09 16:58:58\'\n`mnf_created_by` = \'1\'\n', '', 'INSERT INTO `manufacturers` SET \n`mnf_code` = \'UTAX\' \n , `mnf_name` = \'Utax Ltd\' \n , `mnf_description` = \'\' \n , `mnf_country_code_ID` = \'23\' \n , `mnf_created_date_time` = \'2018-08-09 16:58:58\' \n , `mnf_created_by` = \'1\' \n'),
	(44, 1, '::1', '2018-08-09 16:59:09', 'manufacturers', '1', 'UPDATE RECORD', 'mnf_description = \'blah blah\'\r\n`mnf_last_update_date_time` = \'2018-08-09 16:59:09\'\n`mnf_last_update_by` = \'1\'\n', 'mnf_description = \'\'\r\n`mnf_last_update_date_time` = \'\'\n`mnf_last_update_by` = \'\'\n', 'UPDATE `manufacturers` SET \n`mnf_description` = \'blah blah\' \n , `mnf_last_update_date_time` = \'2018-08-09 16:59:09\' \n , `mnf_last_update_by` = \'1\' \nWHERE `mnf_manufacturer_ID` = 1'),
	(45, 1, '::1', '2018-08-09 17:09:48', 'customers', '2', 'UPDATE RECORD', 'cst_city_code_ID = \'8\'\r\ncst_contact_person_title_code_ID = \'18\'\r\n`cst_last_update_date_time` = \'2018-08-09 17:09:48\'\n`cst_last_update_by` = \'1\'\n', 'cst_city_code_ID = \'10\'\r\ncst_contact_person_title_code_ID = \'19\'\r\n`cst_last_update_date_time` = \'2018-08-09 16:24:42\'\n`cst_last_update_by` = \'1\'\n', 'UPDATE `customers` SET \n`cst_city_code_ID` = \'8\' \n, `cst_contact_person_title_code_ID` = \'18\' \n , `cst_last_update_date_time` = \'2018-08-09 17:09:48\' \n , `cst_last_update_by` = \'1\' \nWHERE `cst_customer_ID` = 2'),
	(46, 1, '::1', '2018-08-09 17:51:56', 'manufacturers', '1', 'UPDATE RECORD', 'mnf_active = \'1\'\r\n`mnf_last_update_date_time` = \'2018-08-09 17:51:56\'\n`mnf_last_update_by` = \'1\'\n', 'mnf_active = \'\'\r\n`mnf_last_update_date_time` = \'2018-08-09 16:59:09\'\n`mnf_last_update_by` = \'1\'\n', 'UPDATE `manufacturers` SET \n`mnf_active` = \'1\' \n , `mnf_last_update_date_time` = \'2018-08-09 17:51:56\' \n , `mnf_last_update_by` = \'1\' \nWHERE `mnf_manufacturer_ID` = 1'),
	(47, 1, '::1', '2018-08-09 17:54:51', 'products', '1', 'INSERT RECORD', 'prd_code = LP 3130 \r\nprd_bar_code = 1 \r\nprd_name = LP 3130 \r\nprd_description =  \r\nprd_manufacturer_ID =  \r\n`prd_created_date_time` = \'2018-08-09 17:54:51\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_code` = \'LP 3130\' \n , `prd_bar_code` = \'1\' \n , `prd_name` = \'LP 3130\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'\' \n , `prd_created_date_time` = \'2018-08-09 17:54:51\' \n , `prd_created_by` = \'1\' \n'),
	(48, 1, '::1', '2018-08-09 17:55:15', 'products', '1', 'UPDATE RECORD', 'prd_bar_code = \'\'\r\nprd_manufacturer_ID = \'\'\r\n`prd_last_update_date_time` = \'2018-08-09 17:55:15\'\n`prd_last_update_by` = \'1\'\n', 'prd_bar_code = \'1\'\r\nprd_manufacturer_ID = \'0\'\r\n`prd_last_update_date_time` = \'\'\n`prd_last_update_by` = \'\'\n', 'UPDATE `products` SET \n`prd_bar_code` = \'\' \n, `prd_manufacturer_ID` = \'\' \n , `prd_last_update_date_time` = \'2018-08-09 17:55:15\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(49, 1, '::1', '2018-08-09 17:55:56', 'products', '1', 'UPDATE RECORD', 'prd_manufacturer_ID = \'1\'\r\n`prd_last_update_date_time` = \'2018-08-09 17:55:56\'\n`prd_last_update_by` = \'1\'\n', 'prd_manufacturer_ID = \'0\'\r\n`prd_last_update_date_time` = \'2018-08-09 17:55:15\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_manufacturer_ID` = \'1\' \n , `prd_last_update_date_time` = \'2018-08-09 17:55:56\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(50, 1, '::1', '2018-08-09 17:57:36', 'products', '1', 'UPDATE RECORD', 'prd_active = \'1\'\r\n`prd_last_update_date_time` = \'2018-08-09 17:57:36\'\n`prd_last_update_by` = \'1\'\n', 'prd_active = \'\'\r\n`prd_last_update_date_time` = \'2018-08-09 17:55:56\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_active` = \'1\' \n , `prd_last_update_date_time` = \'2018-08-09 17:57:36\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(51, 1, '::1', '2018-08-09 18:01:07', 'products', '1', 'UPDATE RECORD', 'prd_active = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:01:07\'\n`prd_last_update_by` = \'1\'\n', 'prd_active = \'1\'\r\n`prd_last_update_date_time` = \'2018-08-09 17:57:36\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_active` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-09 18:01:07\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(52, 1, '::1', '2018-08-09 18:02:35', 'products', '1', 'UPDATE RECORD', 'prd_active = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:02:35\'\n`prd_last_update_by` = \'1\'\n', 'prd_active = \'0\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:01:07\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_active` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-09 18:02:35\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(53, 1, '::1', '2018-08-09 18:03:18', 'products', '1', 'UPDATE RECORD', 'prd_active = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:03:18\'\n`prd_last_update_by` = \'1\'\n', 'prd_active = \'0\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:02:35\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_active` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-09 18:03:18\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(54, 1, '::1', '2018-08-09 18:03:36', 'products', '1', 'UPDATE RECORD', 'prd_active = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:03:36\'\n`prd_last_update_by` = \'1\'\n', 'prd_active = \'0\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:03:18\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_active` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-09 18:03:36\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(55, 1, '::1', '2018-08-09 18:04:08', 'products', '1', 'UPDATE RECORD', 'prd_type = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:04:08\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:03:36\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_type` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-09 18:04:08\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(56, 1, '::1', '2018-08-09 18:05:53', 'manufacturers', '1', 'UPDATE RECORD', 'mnf_active = \'0\'\r\n`mnf_last_update_date_time` = \'2018-08-09 18:05:53\'\n`mnf_last_update_by` = \'1\'\n', 'mnf_active = \'1\'\r\n`mnf_last_update_date_time` = \'2018-08-09 17:51:56\'\n`mnf_last_update_by` = \'1\'\n', 'UPDATE `manufacturers` SET \n`mnf_active` = \'0\' \n , `mnf_last_update_date_time` = \'2018-08-09 18:05:53\' \n , `mnf_last_update_by` = \'1\' \nWHERE `mnf_manufacturer_ID` = 1'),
	(57, 1, '::1', '2018-08-09 23:34:07', 'products', '1', 'UPDATE RECORD', 'prd_active = \'1\'\r\n`prd_last_update_date_time` = \'2018-08-09 23:34:07\'\n`prd_last_update_by` = \'1\'\n', 'prd_active = \'0\'\r\n`prd_last_update_date_time` = \'2018-08-09 18:04:08\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_active` = \'1\' \n , `prd_last_update_date_time` = \'2018-08-09 23:34:07\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(58, 1, '::1', '2018-08-09 23:34:16', 'products', '1', 'UPDATE RECORD', 'prd_type = \'Copier\'\r\n`prd_last_update_date_time` = \'2018-08-09 23:34:16\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 23:34:07\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_type` = \'Copier\' \n , `prd_last_update_date_time` = \'2018-08-09 23:34:16\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(59, 1, '::1', '2018-08-09 23:34:21', 'products', '1', 'UPDATE RECORD', 'prd_type = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 23:34:21\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'Copier\'\r\n`prd_last_update_date_time` = \'2018-08-09 23:34:16\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_type` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-09 23:34:21\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(60, 1, '::1', '2018-08-10 09:09:49', 'products', '2', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = SpareParts \r\nprd_code = Developer Unit \r\nprd_bar_code =  \r\nprd_name = Developer Unit \r\nprd_description = Developer Unit \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-10 9:09:49\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'SpareParts\' \n , `prd_code` = \'Developer Unit\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'Developer Unit\' \n , `prd_description` = \'Developer Unit\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-10 9:09:49\' \n , `prd_created_by` = \'1\' \n'),
	(61, 1, '::1', '2018-08-10 09:10:56', 'products', '3', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Printer \r\nprd_code = LP 3035 \r\nprd_bar_code =  \r\nprd_name = LP 3035 \r\nprd_description = LP 3035 \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-10 9:10:56\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Printer\' \n , `prd_code` = \'LP 3035\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'LP 3035\' \n , `prd_description` = \'LP 3035\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-10 9:10:56\' \n , `prd_created_by` = \'1\' \n'),
	(62, 1, '::1', '2018-08-10 11:26:36', 'products', '4', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Toner \r\nprd_code = TK-160/162 \r\nprd_bar_code =  \r\nprd_name = TK-160/162 \r\nprd_description =  \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-10 11:26:36\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Toner\' \n , `prd_code` = \'TK-160/162\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'TK-160/162\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-10 11:26:36\' \n , `prd_created_by` = \'1\' \n'),
	(63, 1, '::1', '2018-08-10 11:48:09', 'products', '1', 'UPDATE RECORD', 'prd_type = \'Machine\'\r\n`prd_last_update_date_time` = \'2018-08-10 11:48:09\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-09 23:34:21\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_type` = \'Machine\' \n , `prd_last_update_date_time` = \'2018-08-10 11:48:09\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(64, 1, '::1', '2018-08-10 11:53:09', 'codes', '25', 'INSERT RECORD', 'cde_type = code \r\ncde_value_label = Products SubType \r\ncde_value = ProductsSubType \r\ncde_value_label_2 =  \r\ncde_value_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'code\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'ProductsSubType\' \n , `cde_value_label_2` = \'\' \n , `cde_value_2` = \'\' \n'),
	(65, 1, '::1', '2018-08-11 09:31:27', 'products', '1', 'UPDATE RECORD', 'prd_size = \'A4\'\r\nprd_color = \'Black\'\r\n`prd_last_update_date_time` = \'2018-08-11 9:31:27\'\n`prd_last_update_by` = \'1\'\n', 'prd_size = \'0\'\r\nprd_color = \'0\'\r\n`prd_last_update_date_time` = \'2018-08-10 11:48:09\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_size` = \'A4\' \n, `prd_color` = \'Black\' \n , `prd_last_update_date_time` = \'2018-08-11 9:31:27\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(66, 1, '::1', '2018-08-11 09:39:24', 'products', '2', 'UPDATE RECORD', 'prd_type = \'SparePart\'\r\nprd_size = \'A4\'\r\nprd_color = \'Black\'\r\n`prd_last_update_date_time` = \'2018-08-11 9:39:24\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'SpareParts\'\r\nprd_size = \'0\'\r\nprd_color = \'0\'\r\n`prd_last_update_date_time` = \'\'\n`prd_last_update_by` = \'\'\n', 'UPDATE `products` SET \n`prd_type` = \'SparePart\' \n, `prd_size` = \'A4\' \n, `prd_color` = \'Black\' \n , `prd_last_update_date_time` = \'2018-08-11 9:39:24\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 2'),
	(67, 1, '::1', '2018-08-11 09:39:33', 'products', '3', 'UPDATE RECORD', 'prd_type = \'Machine\'\r\nprd_size = \'A4\'\r\nprd_color = \'Black\'\r\n`prd_last_update_date_time` = \'2018-08-11 9:39:33\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'Printer\'\r\nprd_size = \'0\'\r\nprd_color = \'0\'\r\n`prd_last_update_date_time` = \'\'\n`prd_last_update_by` = \'\'\n', 'UPDATE `products` SET \n`prd_type` = \'Machine\' \n, `prd_size` = \'A4\' \n, `prd_color` = \'Black\' \n , `prd_last_update_date_time` = \'2018-08-11 9:39:33\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 3'),
	(68, 1, '::1', '2018-08-11 09:39:40', 'products', '4', 'UPDATE RECORD', 'prd_type = \'Consumable\'\r\nprd_size = \'A4\'\r\nprd_color = \'Black\'\r\n`prd_last_update_date_time` = \'2018-08-11 9:39:40\'\n`prd_last_update_by` = \'1\'\n', 'prd_type = \'Toner\'\r\nprd_size = \'0\'\r\nprd_color = \'0\'\r\n`prd_last_update_date_time` = \'\'\n`prd_last_update_by` = \'\'\n', 'UPDATE `products` SET \n`prd_type` = \'Consumable\' \n, `prd_size` = \'A4\' \n, `prd_color` = \'Black\' \n , `prd_last_update_date_time` = \'2018-08-11 9:39:40\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 4'),
	(69, 1, '::1', '2018-08-11 10:06:13', 'product_relations', '1', 'INSERT RECORD', 'prdr_product_child_ID =  \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(70, 1, '::1', '2018-08-11 10:07:57', 'product_relations', '2', 'INSERT RECORD', 'prdr_product_child_ID = 4 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'4\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(71, 1, '::1', '2018-08-11 10:09:13', 'product_relations', '3', 'INSERT RECORD', 'prdr_product_child_ID = 4 \r\nprdr_child_type = Consumable \r\nprdr_product_parent_ID = 1 \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'4\' \n , `prdr_child_type` = \'Consumable\' \n , `prdr_product_parent_ID` = \'1\' \n'),
	(72, 1, '::1', '2018-08-11 10:15:57', 'product_relations', '4', 'INSERT RECORD', 'prdr_product_child_ID = 4 \r\nprdr_child_type = Consumable \r\nprdr_product_parent_ID = 1 \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'4\' \n , `prdr_child_type` = \'Consumable\' \n , `prdr_product_parent_ID` = \'1\' \n'),
	(73, 1, '::1', '2018-08-11 10:18:22', 'product_relations', '5', 'INSERT RECORD', 'prdr_product_child_ID = 4 \r\nprdr_child_type = Consumable \r\nprdr_product_parent_ID = 1 \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'4\' \n , `prdr_child_type` = \'Consumable\' \n , `prdr_product_parent_ID` = \'1\' \n'),
	(74, 1, '::1', '2018-08-11 10:48:10', 'product_relations', '6', 'INSERT RECORD', 'prdr_product_child_ID = 2 \r\nprdr_child_type = Consumable \r\nprdr_product_parent_ID = 1 \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'Consumable\' \n , `prdr_product_parent_ID` = \'1\' \n'),
	(75, 1, '::1', '2018-08-11 10:49:10', 'product_relations', '7', 'INSERT RECORD', 'prdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\nprdr_product_parent_ID = 1 \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n , `prdr_product_parent_ID` = \'1\' \n'),
	(76, 1, '::1', '2018-08-11 11:08:20', 'product_relations', '8', 'INSERT RECORD', 'prdr_product_parent_ID = 1 \r\nprdr_product_child_ID = 4 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'1\' \n , `prdr_product_child_ID` = \'4\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(77, 1, '::1', '2018-08-11 11:09:46', 'product_relations', '9', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(78, 1, '::1', '2018-08-11 11:10:57', 'product_relations', '10', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(79, 1, '::1', '2018-08-11 11:11:00', 'product_relations', '11', 'INSERT RECORD', 'prdr_product_parent_ID = 1 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'1\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(80, 1, '::1', '2018-08-11 11:11:02', 'product_relations', '12', 'INSERT RECORD', 'prdr_product_parent_ID = 1 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'1\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(81, 1, '::1', '2018-08-11 11:11:05', 'product_relations', '13', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(82, 1, '::1', '2018-08-11 11:11:08', 'product_relations', '14', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(83, 1, '::1', '2018-08-11 11:11:11', 'product_relations', '15', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(84, 1, '::1', '2018-08-11 11:15:21', 'product_relations', '4', 'UPDATE RECORD', 'prdr_product_parent_ID = \'3\'\r\n', 'prdr_product_parent_ID = \'1\'\r\n', 'UPDATE `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \nWHERE `prdr_product_relations_ID` = 4'),
	(85, 1, '::1', '2018-08-11 11:27:34', 'codes', '26', 'INSERT RECORD', 'cde_type = code \r\ncde_value_label =  \r\ncde_value =  \r\ncde_value_label_2 =  \r\ncde_value_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'code\' \n , `cde_value_label` = \'\' \n , `cde_value` = \'\' \n , `cde_value_label_2` = \'\' \n , `cde_value_2` = \'\' \n'),
	(86, 1, '::1', '2018-08-11 12:41:46', 'products', '5', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Consumable \r\nprd_size = A4 \r\nprd_color = Color \r\nprd_code = Yellow \r\nprd_bar_code =  \r\nprd_name = Yellow \r\nprd_description =  \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-11 12:41:46\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Consumable\' \n , `prd_size` = \'A4\' \n , `prd_color` = \'Color\' \n , `prd_code` = \'Yellow\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'Yellow\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-11 12:41:46\' \n , `prd_created_by` = \'1\' \n'),
	(87, 1, '::1', '2018-08-11 12:42:13', 'products', '6', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Consumable \r\nprd_size = A4 \r\nprd_color = Color \r\nprd_code = Yellow \r\nprd_bar_code =  \r\nprd_name = Yellow \r\nprd_description =  \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-11 12:42:13\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Consumable\' \n , `prd_size` = \'A4\' \n , `prd_color` = \'Color\' \n , `prd_code` = \'Yellow\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'Yellow\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-11 12:42:13\' \n , `prd_created_by` = \'1\' \n'),
	(88, 1, '::1', '2018-08-11 12:43:06', 'products', '7', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Consumable \r\nprd_size = A4 \r\nprd_color = Color \r\nprd_code = Magenta \r\nprd_bar_code =  \r\nprd_name = Magenta \r\nprd_description =  \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-11 12:43:06\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Consumable\' \n , `prd_size` = \'A4\' \n , `prd_color` = \'Color\' \n , `prd_code` = \'Magenta\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'Magenta\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-11 12:43:06\' \n , `prd_created_by` = \'1\' \n'),
	(89, 1, '::1', '2018-08-11 12:43:32', 'products', '8', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Consumable \r\nprd_size = A4 \r\nprd_color = Color \r\nprd_code = Magenta \r\nprd_bar_code =  \r\nprd_name = Magenta \r\nprd_description =  \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-11 12:43:32\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Consumable\' \n , `prd_size` = \'A4\' \n , `prd_color` = \'Color\' \n , `prd_code` = \'Magenta\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'Magenta\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-11 12:43:32\' \n , `prd_created_by` = \'1\' \n'),
	(90, 1, '::1', '2018-08-11 12:43:56', 'products', '9', 'INSERT RECORD', 'prd_active = 1 \r\nprd_type = Consumable \r\nprd_size = A4 \r\nprd_color = Color \r\nprd_code = Magenta \r\nprd_bar_code =  \r\nprd_name = Magenta \r\nprd_description =  \r\nprd_manufacturer_ID = 1 \r\n`prd_created_date_time` = \'2018-08-11 12:43:56\'\n`prd_created_by` = \'1\'\n', '', 'INSERT INTO `products` SET \n`prd_active` = \'1\' \n , `prd_type` = \'Consumable\' \n , `prd_size` = \'A4\' \n , `prd_color` = \'Color\' \n , `prd_code` = \'Magenta\' \n , `prd_bar_code` = \'\' \n , `prd_name` = \'Magenta\' \n , `prd_description` = \'\' \n , `prd_manufacturer_ID` = \'1\' \n , `prd_created_date_time` = \'2018-08-11 12:43:56\' \n , `prd_created_by` = \'1\' \n'),
	(91, 1, '::1', '2018-08-11 13:08:35', 'product_relations', '16', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 7 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'7\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(92, 1, '::1', '2018-08-12 10:52:39', 'product_relations', '17', 'INSERT RECORD', 'prdr_product_child_ID = 7 \r\nprdr_product_parent_ID = 1 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'7\' \n , `prdr_product_parent_ID` = \'1\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(93, 1, '::1', '2018-08-12 10:53:00', 'product_relations', '18', 'INSERT RECORD', 'prdr_product_child_ID = 4 \r\nprdr_product_parent_ID = 1 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'4\' \n , `prdr_product_parent_ID` = \'1\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(94, 1, '::1', '2018-08-12 10:53:34', 'product_relations', '19', 'INSERT RECORD', 'prdr_product_child_ID = 5 \r\nprdr_product_parent_ID = 1 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'5\' \n , `prdr_product_parent_ID` = \'1\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(95, 1, '::1', '2018-08-12 11:02:34', 'product_relations', '20', 'INSERT RECORD', 'prdr_product_child_ID = 2 \r\nprdr_product_parent_ID = 1 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_child_ID` = \'2\' \n , `prdr_product_parent_ID` = \'1\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(96, 1, '::1', '2018-08-12 11:20:05', 'product_relations', '21', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 4 \r\nprdr_child_type = Consumable \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'4\' \n , `prdr_child_type` = \'Consumable\' \n'),
	(97, 1, '::1', '2018-08-12 11:21:02', 'product_relations', '22', 'INSERT RECORD', 'prdr_product_parent_ID = 3 \r\nprdr_product_child_ID = 2 \r\nprdr_child_type = SparePart \r\n', '', 'INSERT INTO `product_relations` SET \n`prdr_product_parent_ID` = \'3\' \n , `prdr_product_child_ID` = \'2\' \n , `prdr_child_type` = \'SparePart\' \n'),
	(98, 1, '::1', '2018-08-12 11:32:26', 'codes', '1', 'UPDATE RECORD', 'cde_table_field = \'customers#cst_city_code_ID\'\r\n', 'cde_table_field = \'\'\r\n', 'UPDATE `codes` SET \n`cde_table_field` = \'customers#cst_city_code_ID\' \nWHERE `cde_code_ID` = 1'),
	(99, 1, '::1', '2018-08-12 11:32:56', 'codes', '2', 'UPDATE RECORD', 'cde_table_field = \'customers#cst_business_type_code_ID\'\r\n', 'cde_table_field = \'\'\r\n', 'UPDATE `codes` SET \n`cde_table_field` = \'customers#cst_business_type_code_ID\' \nWHERE `cde_code_ID` = 2'),
	(100, 1, '::1', '2018-08-12 11:33:09', 'codes', '15', 'UPDATE RECORD', 'cde_table_field = \'customers#cst_contact_person_title_code_ID\'\r\n', 'cde_table_field = \'\'\r\n', 'UPDATE `codes` SET \n`cde_table_field` = \'customers#cst_contact_person_title_code_ID\' \nWHERE `cde_code_ID` = 15'),
	(101, 1, '::1', '2018-08-12 11:33:51', 'codes', '21', 'UPDATE RECORD', 'cde_table_field = \'manufacturers#mnf_country_code_ID\'\r\n', 'cde_table_field = \'\'\r\n', 'UPDATE `codes` SET \n`cde_table_field` = \'manufacturers#mnf_country_code_ID\' \nWHERE `cde_code_ID` = 21'),
	(102, 1, '::1', '2018-08-12 11:53:51', 'codes', '15', 'UPDATE RECORD', 'cde_table_field = \'customers@cst_contact_person_title_code_ID\'\r\n', 'cde_table_field = \'customers#cst_contact_person_title_code_ID\'\r\n', 'UPDATE `codes` SET \n`cde_table_field` = \'customers@cst_contact_person_title_code_ID\' \nWHERE `cde_code_ID` = 15'),
	(103, 1, '::1', '2018-08-12 12:00:31', 'codes', '15', 'UPDATE RECORD', 'cde_table_field = \'customers#cst_contact_person_title_code_ID\'\r\n', 'cde_table_field = \'customers@cst_contact_person_title_code_ID\'\r\n', 'UPDATE `codes` SET \n`cde_table_field` = \'customers#cst_contact_person_title_code_ID\' \nWHERE `cde_code_ID` = 15'),
	(104, 1, '::1', '2018-08-12 12:01:30', 'customers', '1', 'UPDATE RECORD', 'cst_contact_person_title_code_ID = \'18\'\r\n`cst_last_update_date_time` = \'2018-08-12 12:01:30\'\n`cst_last_update_by` = \'1\'\n', 'cst_contact_person_title_code_ID = \'16\'\r\n`cst_last_update_date_time` = \'\'\n`cst_last_update_by` = \'\'\n', 'UPDATE `customers` SET \n`cst_contact_person_title_code_ID` = \'18\' \n , `cst_last_update_date_time` = \'2018-08-12 12:01:30\' \n , `cst_last_update_by` = \'1\' \nWHERE `cst_customer_ID` = 1'),
	(105, 1, '::1', '2018-08-12 17:50:05', 'codes', '26', 'INSERT RECORD', 'cde_type = ContactPersonTitle \r\ncde_value_label = Contact Person Title \r\ncde_value = Test \r\ncde_value_label_2 =  \r\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ContactPersonTitle\' \n , `cde_value_label` = \'Contact Person Title\' \n , `cde_value` = \'Test\' \n , `cde_value_label_2` = \'\' \n'),
	(106, 1, '::1', '2018-08-12 17:50:10', 'codes', '26', 'DELETE RECORD', '', 'cde_code_ID = 26\r\n		cde_type = ContactPersonTitle\r\n		cde_table_field = \r\n		cde_table_field2 = \r\n		cde_table_field3 = \r\n		cde_value = Test\r\n		cde_value_label = Contact Person Title\r\n		cde_value_2 = \r\n		cde_value_label_2 = \r\n		', ''),
	(107, 1, '::1', '2018-08-12 17:52:41', 'customers', '2', 'DELETE RECORD', '', 'cst_customer_ID = 2\r\n		cst_identity_card = 342\r\n		cst_name = Test\r\n		cst_surname = \r\n		cst_address_line_1 = \r\n		cst_address_line_2 = \r\n		cst_city_code_ID = 8\r\n		cst_contact_person = Mike\r\n		cst_contact_person_title_code_ID = 18\r\n		cst_work_tel_1 = \r\n		cst_work_tel_2 = \r\n		cst_fax = \r\n		cst_mobile_1 = \r\n		cst_mobile_2 = \r\n		cst_email = \r\n		cst_email_newsletter = \r\n		cst_business_type_code_ID = 12\r\n		cst_created_date_time = 2018-08-09 16:14:56\r\n		cst_created_by = 1\r\n		cst_last_update_date_time = 2018-08-09 17:09:48\r\n		cst_last_update_by = 1\r\n		', ''),
	(108, 1, '::1', '2018-08-12 17:53:58', 'manufacturers', '2', 'INSERT RECORD', 'mnf_active = 1 \r\nmnf_code = test \r\nmnf_name = asdf \r\nmnf_description =  \r\nmnf_country_code_ID = 22 \r\n`mnf_created_date_time` = \'2018-08-12 17:53:58\'\n`mnf_created_by` = \'1\'\n', '', 'INSERT INTO `manufacturers` SET \n`mnf_active` = \'1\' \n , `mnf_code` = \'test\' \n , `mnf_name` = \'asdf\' \n , `mnf_description` = \'\' \n , `mnf_country_code_ID` = \'22\' \n , `mnf_created_date_time` = \'2018-08-12 17:53:58\' \n , `mnf_created_by` = \'1\' \n'),
	(109, 1, '::1', '2018-08-12 17:54:53', 'manufacturers', '2', 'DELETE RECORD', '', 'mnf_manufacturer_ID = 2\r\n		mnf_code = test\r\n		mnf_active = 1\r\n		mnf_name = asdf\r\n		mnf_description = \r\n		mnf_country_code_ID = 22\r\n		mnf_tel = \r\n		mnf_contact_person = \r\n		mnf_created_date_time = 2018-08-12 17:53:58\r\n		mnf_created_by = 1\r\n		mnf_last_update_date_time = \r\n		mnf_last_update_by = \r\n		', ''),
	(110, 1, '::1', '2018-08-12 19:36:18', 'stock', '1', 'INSERT RECORD', 'stk_product_ID = 1 \r\nstk_type = transaction \r\nstk_description = Initial \r\nstk_status = Pending \r\nstk_add_minus = 1 \r\nstk_amount = 10 \r\nstk_date_time = 2018-08-12 19:36:18 \r\nstk_month = 08 \r\nstk_year = 2018 \r\n', '', 'INSERT INTO `stock` SET \n`stk_product_ID` = \'1\' \n , `stk_type` = \'transaction\' \n , `stk_description` = \'Initial\' \n , `stk_status` = \'Pending\' \n , `stk_add_minus` = \'1\' \n , `stk_amount` = \'10\' \n , `stk_date_time` = \'2018-08-12 19:36:18\' \n , `stk_month` = \'08\' \n , `stk_year` = \'2018\' \n'),
	(111, 1, '::1', '2018-08-12 19:37:35', 'stock', '1', 'INSERT RECORD', 'stk_product_ID = 1 \r\nstk_type = transaction \r\nstk_description = Initial \r\nstk_status = Pending \r\nstk_add_minus = 1 \r\nstk_amount = 10 \r\nstk_date_time = 2018-08-12 19:37:35 \r\nstk_month = 08 \r\nstk_year = 2018 \r\n', '', 'INSERT INTO `stock` SET \n`stk_product_ID` = \'1\' \n , `stk_type` = \'transaction\' \n , `stk_description` = \'Initial\' \n , `stk_status` = \'Pending\' \n , `stk_add_minus` = \'1\' \n , `stk_amount` = \'10\' \n , `stk_date_time` = \'2018-08-12 19:37:35\' \n , `stk_month` = \'08\' \n , `stk_year` = \'2018\' \n'),
	(112, 1, '::1', '2018-08-12 19:37:35', 'products', '1', 'UPDATE RECORD', 'prd_current_stock = \'10\'\r\n', 'prd_current_stock = \'0\'\r\n', 'UPDATE `products` SET \n`prd_current_stock` = \'10\' \nWHERE prd_product_ID = 1'),
	(113, 1, '::1', '2018-08-12 19:39:25', 'stock', '2', 'INSERT RECORD', 'stk_product_ID = 1 \r\nstk_type = transaction \r\nstk_description = Transaction \r\nstk_status = Pending \r\nstk_add_minus = 1 \r\nstk_amount = 5 \r\nstk_date_time = 2018-08-12 19:39:24 \r\nstk_month = 08 \r\nstk_year = 2018 \r\n`stk_created_date_time` = \'2018-08-12 19:39:24\'\n`stk_created_by` = \'1\'\n', '', 'INSERT INTO `stock` SET \n`stk_product_ID` = \'1\' \n , `stk_type` = \'transaction\' \n , `stk_description` = \'Transaction\' \n , `stk_status` = \'Pending\' \n , `stk_add_minus` = \'1\' \n , `stk_amount` = \'5\' \n , `stk_date_time` = \'2018-08-12 19:39:24\' \n , `stk_month` = \'08\' \n , `stk_year` = \'2018\' \n , `stk_created_date_time` = \'2018-08-12 19:39:24\' \n , `stk_created_by` = \'1\' \n'),
	(114, 1, '::1', '2018-08-12 19:39:25', 'products', '1', 'UPDATE RECORD', 'prd_current_stock = \'15\'\r\n`prd_last_update_date_time` = \'2018-08-12 19:39:25\'\n`prd_last_update_by` = \'1\'\n', 'prd_current_stock = \'10\'\r\n`prd_last_update_date_time` = \'2018-08-11 09:31:27\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_current_stock` = \'15\' \n , `prd_last_update_date_time` = \'2018-08-12 19:39:25\' \n , `prd_last_update_by` = \'1\' \nWHERE prd_product_ID = 1'),
	(118, 1, '::1', '2018-08-13 22:34:51', 'stock', '6', 'INSERT RECORD', 'stk_product_ID = 1 \r\nstk_type = transaction \r\nstk_description = Initial \r\nstk_status = Pending \r\nstk_add_minus = 1 \r\nstk_amount = 1 \r\nstk_date_time = 2018-08-13 22:34:51 \r\nstk_month = 08 \r\nstk_year = 2018 \r\n`stk_created_date_time` = \'2018-08-13 22:34:51\'\n`stk_created_by` = \'1\'\n', '', 'INSERT INTO `stock` SET \n`stk_product_ID` = \'1\' \n , `stk_type` = \'transaction\' \n , `stk_description` = \'Initial\' \n , `stk_status` = \'Pending\' \n , `stk_add_minus` = \'1\' \n , `stk_amount` = \'1\' \n , `stk_date_time` = \'2018-08-13 22:34:51\' \n , `stk_month` = \'08\' \n , `stk_year` = \'2018\' \n , `stk_created_date_time` = \'2018-08-13 22:34:51\' \n , `stk_created_by` = \'1\' \n'),
	(119, 1, '::1', '2018-08-13 22:34:51', 'product', '1', 'UPDATE RECORD', 'prd_current_stock = \'16\'\r\nprd_stock_last_update = \'2018-08-13 22:34:51\'\r\n', 'prd_current_stock = \'\'\r\nprd_stock_last_update = \'\'\r\n', 'UPDATE `product` SET \n`prd_current_stock` = \'16\' \n, `prd_stock_last_update` = \'2018-08-13 22:34:51\' \nWHERE prd_product_ID = 1'),
	(121, 1, '::1', '2018-08-13 22:37:30', 'Error', '0', '', '', '', 'SELECT * FROM `product` WHERE prd_product_ID = 1<hr>Table \'reprodata.product\' doesn\'t exist'),
	(123, 1, '::1', '2018-08-13 22:40:48', 'Error', '0', 'Stock Transaction', 'User:1', '$_GET->Array\n(\n    [pid] => 1\n)\n\\n$_POST->Array\n(\n    [fld_description] => Initial\n    [fld_amount] => 3\n    [action] => insert\n    [pid] => 1\n)\n', 'SELECT * FROM `product` WHERE prd_product_ID = 1<hr>Table \'reprodata.product\' doesn\'t exist'),
	(125, 1, '::1', '2018-08-13 22:45:48', 'Error', '0', 'Stock Transaction Section:Update product@addRemoveStock', 'User:1', '$_GET->Array\n(\n    [pid] => 1\n)\n\\n$_POST->Array\n(\n    [fld_description] => Transaction\n    [fld_amount] => 3\n    [action] => insert\n    [pid] => 1\n)\n', 'SELECT * FROM `product` WHERE prd_product_ID = 1<hr>Table \'reprodata.product\' doesn\'t exist'),
	(126, 1, '::1', '2018-08-13 23:00:11', 'Error', '0', 'Codes Modify Section:', 'User[ID]:Michael Ermogenous[1]', '$_GET->Array\n(\n    [lid] => 25\n    [codeSelection] => code\n)\n\\n$_POST->Array\n(\n    [fld_table_field] => products#prd_sub_type_code_ID\n    [fld_table_field2] => \n    [fld_table_field3] => \n    [fld_value_label] => Products SubType\n    [fld_option_values] => Machine#Consumables#Spare Parts\n    [fld_option_label] => For Type\n    [fld_value] => ProductsSubType\n    [fld_value_label_2] => \n    [fld_value_2] => \n    [action] => update\n    [lid] => 25\n    [codeSelection] => code\n)\n', 'UPDATE `codes` SET \n`cde_table_field` = \'products#prd_sub_type_code_ID\' \n, `cde_option_values` = \'Machine#Consumables#Spare Parts\' \n, `cde_option_label` = \'For Type\' \n , `cde_last_update_date_time` = \'2018-08-13 23:00:11\' \n , `cde_last_update_by` = \'1\' \nWHERE `cde_code_ID` = 25<hr>Unknown column \'cde_option_label\' in \'field list\''),
	(127, 1, '::1', '2018-08-13 23:00:29', 'codes', '25', 'UPDATE RECORD', 'cde_table_field = \'products#prd_sub_type_code_ID\'\r\ncde_option_values = \'Machine#Consumables#Spare Parts\'\r\ncde_option_label = \'For Type\'\r\n`cde_last_update_date_time` = \'2018-08-13 23:00:29\'\n`cde_last_update_by` = \'1\'\n', 'cde_table_field = \'\'\r\ncde_option_values = \'\'\r\ncde_option_label = \'\'\r\n`cde_last_update_date_time` = \'\'\n`cde_last_update_by` = \'\'\n', 'UPDATE `codes` SET \n`cde_table_field` = \'products#prd_sub_type_code_ID\' \n, `cde_option_values` = \'Machine#Consumables#Spare Parts\' \n, `cde_option_label` = \'For Type\' \n , `cde_last_update_date_time` = \'2018-08-13 23:00:29\' \n , `cde_last_update_by` = \'1\' \nWHERE `cde_code_ID` = 25'),
	(128, 1, '::1', '2018-08-13 23:03:56', 'codes', '27', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = test \r\ncde_value_label_2 =  \r\ncde_option_values = pp \r\n`cde_created_date_time` = \'2018-08-13 23:03:56\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'test\' \n , `cde_value_label_2` = \'\' \n , `cde_option_values` = \'pp\' \n , `cde_created_date_time` = \'2018-08-13 23:03:56\' \n , `cde_created_by` = \'1\' \n'),
	(129, 1, '::1', '2018-08-13 23:39:58', 'codes', '27', 'UPDATE RECORD', 'cde_option_values = \'Consumables\'\r\n`cde_last_update_date_time` = \'2018-08-13 23:39:58\'\n`cde_last_update_by` = \'1\'\n', 'cde_option_values = \'pp\'\r\n`cde_last_update_date_time` = \'\'\n`cde_last_update_by` = \'\'\n', 'UPDATE `codes` SET \n`cde_option_values` = \'Consumables\' \n , `cde_last_update_date_time` = \'2018-08-13 23:39:58\' \n , `cde_last_update_by` = \'1\' \nWHERE `cde_code_ID` = 27'),
	(130, 1, '::1', '2018-08-13 23:40:03', 'codes', '27', 'UPDATE RECORD', 'cde_option_values = \'Spare Parts\'\r\n`cde_last_update_date_time` = \'2018-08-13 23:40:03\'\n`cde_last_update_by` = \'1\'\n', 'cde_option_values = \'Consumables\'\r\n`cde_last_update_date_time` = \'2018-08-13 23:39:58\'\n`cde_last_update_by` = \'1\'\n', 'UPDATE `codes` SET \n`cde_option_values` = \'Spare Parts\' \n , `cde_last_update_date_time` = \'2018-08-13 23:40:03\' \n , `cde_last_update_by` = \'1\' \nWHERE `cde_code_ID` = 27'),
	(131, 1, '::1', '2018-08-13 23:41:01', 'codes', '27', 'UPDATE RECORD', 'cde_value = \'MultiFunction\'\r\ncde_option_values = \'Machine\'\r\n`cde_last_update_date_time` = \'2018-08-13 23:41:01\'\n`cde_last_update_by` = \'1\'\n', 'cde_value = \'test\'\r\ncde_option_values = \'Spare Parts\'\r\n`cde_last_update_date_time` = \'2018-08-13 23:40:03\'\n`cde_last_update_by` = \'1\'\n', 'UPDATE `codes` SET \n`cde_value` = \'MultiFunction\' \n, `cde_option_values` = \'Machine\' \n , `cde_last_update_date_time` = \'2018-08-13 23:41:01\' \n , `cde_last_update_by` = \'1\' \nWHERE `cde_code_ID` = 27'),
	(132, 1, '::1', '2018-08-13 23:42:18', 'Error', '0', 'Codes Modify Section:', 'User[ID]:Michael Ermogenous[1]', '$_GET->Array\n(\n    [lid] => 27\n    [codeSelection] => ProductsSubType\n)\n\\n$_POST->Array\n(\n    [fld_value_label] => Products SubType\n    [fld_value] => MultiFunction\n    [fld_value_label_2] => \n    [fld_option_values] => Machine\n    [action] => update\n    [lid] => 27\n    [codeSelection] => ProductsSubType\n)\n', 'UPDATE `codes` SET \n`cde_option_values` = \'Machine\' \n , `cde_last_update_date_time` = \'2018-08-13 23:42:18\' \n , `cde_last_update_by` = \'1\' \nWHERE `cde_code_ID` = 27<hr>Unknown column \'cde_option_values\' in \'field list\''),
	(133, 1, '::1', '2018-08-13 23:45:21', 'codes', '28', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Printer \r\ncde_value_label_2 =  \r\ncde_option_value = Machine \r\n`cde_created_date_time` = \'2018-08-13 23:45:21\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Printer\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Machine\' \n , `cde_created_date_time` = \'2018-08-13 23:45:21\' \n , `cde_created_by` = \'1\' \n'),
	(134, 1, '::1', '2018-08-13 23:45:30', 'codes', '29', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Toners \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:45:30\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Toners\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:45:30\' \n , `cde_created_by` = \'1\' \n'),
	(135, 1, '::1', '2018-08-13 23:45:39', 'codes', '30', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Waste Box \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:45:39\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Waste Box\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:45:39\' \n , `cde_created_by` = \'1\' \n'),
	(136, 1, '::1', '2018-08-13 23:45:48', 'codes', '31', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Stables \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:45:48\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Stables\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:45:48\' \n , `cde_created_by` = \'1\' \n'),
	(137, 1, '::1', '2018-08-13 23:45:58', 'codes', '32', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Developers \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:45:58\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Developers\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:45:58\' \n , `cde_created_by` = \'1\' \n'),
	(138, 1, '::1', '2018-08-13 23:46:06', 'codes', '33', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Drums \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:46:06\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Drums\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:46:06\' \n , `cde_created_by` = \'1\' \n'),
	(139, 1, '::1', '2018-08-13 23:46:19', 'codes', '34', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = CL.Blades \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:46:19\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'CL.Blades\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:46:19\' \n , `cde_created_by` = \'1\' \n'),
	(140, 1, '::1', '2018-08-13 23:46:35', 'codes', '35', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Heat Rollers/Belts \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:46:35\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Heat Rollers/Belts\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:46:35\' \n , `cde_created_by` = \'1\' \n'),
	(141, 1, '::1', '2018-08-13 23:46:45', 'codes', '36', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Press Rollers \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:46:45\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Press Rollers\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:46:45\' \n , `cde_created_by` = \'1\' \n'),
	(142, 1, '::1', '2018-08-13 23:46:54', 'codes', '37', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Feed Rollers \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:46:54\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Feed Rollers\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:46:54\' \n , `cde_created_by` = \'1\' \n'),
	(143, 1, '::1', '2018-08-13 23:47:05', 'codes', '38', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Maintenance Kits \r\ncde_value_label_2 =  \r\ncde_option_value = Consumables \r\n`cde_created_date_time` = \'2018-08-13 23:47:05\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Maintenance Kits\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Consumables\' \n , `cde_created_date_time` = \'2018-08-13 23:47:05\' \n , `cde_created_by` = \'1\' \n'),
	(144, 1, '::1', '2018-08-13 23:47:14', 'codes', '39', 'INSERT RECORD', 'cde_type = ProductsSubType \r\ncde_value_label = Products SubType \r\ncde_value = Spare Parts \r\ncde_value_label_2 =  \r\ncde_option_value = Spare Parts \r\n`cde_created_date_time` = \'2018-08-13 23:47:14\'\n`cde_created_by` = \'1\'\n', '', 'INSERT INTO `codes` SET \n`cde_type` = \'ProductsSubType\' \n , `cde_value_label` = \'Products SubType\' \n , `cde_value` = \'Spare Parts\' \n , `cde_value_label_2` = \'\' \n , `cde_option_value` = \'Spare Parts\' \n , `cde_created_date_time` = \'2018-08-13 23:47:14\' \n , `cde_created_by` = \'1\' \n'),
	(145, 1, '::1', '2018-08-14 00:11:40', 'Error', '0', 'Products Modify Section:', 'User[ID]:Michael Ermogenous[1]', '$_GET->Array\n(\n    [lid] => 1\n)\n\\n$_POST->Array\n(\n)\n', 'SELECT * FROM code WHERE cde_type = \'ProductsSubType\' ORDER BY cde_option_value ASC<hr>Table \'reprodata.code\' doesn\'t exist'),
	(146, 1, '::1', '2018-08-14 00:12:23', 'products', '1', 'UPDATE RECORD', 'prd_sub_type = \'MultiFunction\'\r\n`prd_last_update_date_time` = \'2018-08-14 0:12:23\'\n`prd_last_update_by` = \'1\'\n', 'prd_sub_type = \'\'\r\n`prd_last_update_date_time` = \'2018-08-12 19:39:25\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_sub_type` = \'MultiFunction\' \n , `prd_last_update_date_time` = \'2018-08-14 0:12:23\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1'),
	(147, 1, '::1', '2018-08-14 00:32:44', 'products', '1', 'UPDATE RECORD', 'prd_sub_type = \'Printer\'\r\n`prd_last_update_date_time` = \'2018-08-14 0:32:44\'\n`prd_last_update_by` = \'1\'\n', 'prd_sub_type = \'MultiFunction\'\r\n`prd_last_update_date_time` = \'2018-08-14 00:12:23\'\n`prd_last_update_by` = \'1\'\n', 'UPDATE `products` SET \n`prd_sub_type` = \'Printer\' \n , `prd_last_update_date_time` = \'2018-08-14 0:32:44\' \n , `prd_last_update_by` = \'1\' \nWHERE `prd_product_ID` = 1');
/*!40000 ALTER TABLE `log_file` ENABLE KEYS */;

-- Dumping structure for table reprodata.manufacturers
DROP TABLE IF EXISTS `manufacturers`;
CREATE TABLE IF NOT EXISTS `manufacturers` (
  `mnf_manufacturer_ID` int(8) NOT NULL AUTO_INCREMENT,
  `mnf_code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `mnf_active` int(1) DEFAULT NULL,
  `mnf_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mnf_description` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `mnf_country_code_ID` int(8) DEFAULT NULL,
  `mnf_tel` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `mnf_contact_person` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mnf_created_date_time` datetime DEFAULT NULL,
  `mnf_created_by` int(8) DEFAULT NULL,
  `mnf_last_update_date_time` datetime DEFAULT NULL,
  `mnf_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`mnf_manufacturer_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Manufacturers';

-- Dumping data for table reprodata.manufacturers: ~1 rows (approximately)
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` (`mnf_manufacturer_ID`, `mnf_code`, `mnf_active`, `mnf_name`, `mnf_description`, `mnf_country_code_ID`, `mnf_tel`, `mnf_contact_person`, `mnf_created_date_time`, `mnf_created_by`, `mnf_last_update_date_time`, `mnf_last_update_by`) VALUES
	(1, 'UTAX', 0, 'Utax Ltd', 'blah blah', 23, NULL, NULL, '2018-08-09 16:58:58', 1, '2018-08-09 18:05:53', 1);
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;

-- Dumping structure for table reprodata.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `prm_permissions_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prm_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prm_filename` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `prm_type` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `prm_parent` int(11) DEFAULT NULL,
  `prm_restricted` int(1) DEFAULT NULL,
  `prm_view` int(1) DEFAULT '0',
  `prm_insert` int(1) DEFAULT '0',
  `prm_update` int(1) DEFAULT '0',
  `prm_delete` int(1) DEFAULT '0',
  `prm_extra_1` int(1) DEFAULT '0',
  `prm_extra_2` int(1) DEFAULT '0',
  `prm_extra_3` int(1) DEFAULT '0',
  `prm_extra_4` int(1) DEFAULT '0',
  `prm_extra_5` int(1) DEFAULT '0',
  `prm_extra_name_1` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prm_extra_name_2` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prm_extra_name_3` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prm_extra_name_4` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prm_extra_name_5` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`prm_permissions_ID`),
  UNIQUE KEY `primary_serial` (`prm_permissions_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.permissions: ~8 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`prm_permissions_ID`, `prm_name`, `prm_filename`, `prm_type`, `prm_parent`, `prm_restricted`, `prm_view`, `prm_insert`, `prm_update`, `prm_delete`, `prm_extra_1`, `prm_extra_2`, `prm_extra_3`, `prm_extra_4`, `prm_extra_5`, `prm_extra_name_1`, `prm_extra_name_2`, `prm_extra_name_3`, `prm_extra_name_4`, `prm_extra_name_5`) VALUES
	(1, 'Users', 'users/users.php', 'menu', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(2, 'Users Folder', 'users', 'folder', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(3, 'Permissions', 'users/permissions.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(4, 'Permissions Modify', 'users/permissions_modify.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(5, 'Permissions Delete', 'users/permissions_delete.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(6, 'Groups', 'users/groups.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(7, 'Groups Modify', 'users/groups_modify.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
	(8, 'Groups Delete', 'users/groups_delete.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table reprodata.permissions_lines
DROP TABLE IF EXISTS `permissions_lines`;
CREATE TABLE IF NOT EXISTS `permissions_lines` (
  `prl_permissions_lines_ID` int(10) NOT NULL AUTO_INCREMENT,
  `prl_permissions_ID` int(10) DEFAULT NULL,
  `prl_users_groups_ID` int(11) DEFAULT NULL,
  `prl_view` int(1) DEFAULT NULL,
  `prl_insert` int(1) DEFAULT NULL,
  `prl_update` int(1) DEFAULT NULL,
  `prl_delete` int(1) DEFAULT NULL,
  `prl_extra_1` int(1) DEFAULT NULL,
  `prl_extra_2` int(1) DEFAULT NULL,
  `prl_extra_3` int(1) DEFAULT NULL,
  `prl_extra_4` int(1) DEFAULT NULL,
  `prl_extra_5` int(1) DEFAULT NULL,
  PRIMARY KEY (`prl_permissions_lines_ID`),
  UNIQUE KEY `primary_serial` (`prl_permissions_lines_ID`),
  KEY `permissions_serial` (`prl_permissions_ID`),
  KEY `users_groups_serial` (`prl_users_groups_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.permissions_lines: ~26 rows (approximately)
/*!40000 ALTER TABLE `permissions_lines` DISABLE KEYS */;
INSERT INTO `permissions_lines` (`prl_permissions_lines_ID`, `prl_permissions_ID`, `prl_users_groups_ID`, `prl_view`, `prl_insert`, `prl_update`, `prl_delete`, `prl_extra_1`, `prl_extra_2`, `prl_extra_3`, `prl_extra_4`, `prl_extra_5`) VALUES
	(1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(3, 2, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(4, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(5, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(6, 4, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(7, 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(8, 6, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(9, 7, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(10, 8, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(11, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(12, 4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(13, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(14, 6, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(15, 7, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(16, 8, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(17, 2, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0),
	(18, 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0),
	(19, 3, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(20, 4, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(21, 5, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(22, 6, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(23, 7, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(24, 8, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(25, 2, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(26, 1, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
/*!40000 ALTER TABLE `permissions_lines` ENABLE KEYS */;

-- Dumping structure for table reprodata.process_lock
DROP TABLE IF EXISTS `process_lock`;
CREATE TABLE IF NOT EXISTS `process_lock` (
  `pl_process_lock_ID` int(8) NOT NULL AUTO_INCREMENT,
  `pl_description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `pl_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `pl_user_serial` int(8) DEFAULT NULL,
  `pl_active` int(1) DEFAULT NULL,
  `pl_start_timestamp` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `pl_end_timestamp` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pl_process_lock_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.process_lock: ~0 rows (approximately)
/*!40000 ALTER TABLE `process_lock` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_lock` ENABLE KEYS */;

-- Dumping structure for table reprodata.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `prd_product_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prd_manufacturer_ID` int(8) DEFAULT NULL,
  `prd_active` int(1) DEFAULT NULL,
  `prd_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `prd_sub_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `prd_size` varchar(20) COLLATE utf8_bin DEFAULT '0',
  `prd_color` varchar(20) COLLATE utf8_bin DEFAULT '0',
  `prd_code` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `prd_bar_code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prd_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prd_description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `prd_current_stock` int(8) DEFAULT '0',
  `prd_stock_last_update` datetime DEFAULT NULL,
  `prd_created_date_time` datetime DEFAULT NULL,
  `prd_created_by` int(8) DEFAULT NULL,
  `prd_last_update_date_time` datetime DEFAULT NULL,
  `prd_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`prd_product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Products';

-- Dumping data for table reprodata.products: ~6 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`prd_product_ID`, `prd_manufacturer_ID`, `prd_active`, `prd_type`, `prd_sub_type`, `prd_size`, `prd_color`, `prd_code`, `prd_bar_code`, `prd_name`, `prd_description`, `prd_current_stock`, `prd_stock_last_update`, `prd_created_date_time`, `prd_created_by`, `prd_last_update_date_time`, `prd_last_update_by`) VALUES
	(1, 1, 1, 'Machine', 'Printer', 'A4', 'Black', 'LP 3130', '', 'LP 3130', '', 15, NULL, '2018-08-09 17:54:51', 1, '2018-08-14 00:32:44', 1),
	(2, 1, 1, 'SparePart', NULL, 'A4', 'Black', 'Developer Unit', '', 'Developer Unit', 'Developer Unit', 0, NULL, '2018-08-10 09:09:49', 1, '2018-08-11 09:39:24', 1),
	(3, 1, 1, 'Machine', NULL, 'A4', 'Black', 'LP 3035', '', 'LP 3035', 'LP 3035', 0, NULL, '2018-08-10 09:10:56', 1, '2018-08-11 09:39:33', 1),
	(4, 1, 1, 'Consumable', NULL, 'A4', 'Black', 'TK-160/162', '', 'TK-160/162', '', 0, NULL, '2018-08-10 11:26:36', 1, '2018-08-11 09:39:40', 1),
	(5, 1, 1, 'Consumable', NULL, 'A4', 'Color', 'Yellow', '', 'Yellow', '', 0, NULL, '2018-08-11 12:41:46', 1, NULL, NULL),
	(7, 1, 1, 'Consumable', NULL, 'A4', 'Color', 'Magenta', '', 'Magenta', '', 0, NULL, '2018-08-11 12:43:06', 1, NULL, NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table reprodata.product_relations
DROP TABLE IF EXISTS `product_relations`;
CREATE TABLE IF NOT EXISTS `product_relations` (
  `prdr_product_relations_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prdr_product_parent_ID` int(8) DEFAULT NULL,
  `prdr_child_type` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `prdr_product_child_ID` int(8) DEFAULT NULL,
  PRIMARY KEY (`prdr_product_relations_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Products Relations';

-- Dumping data for table reprodata.product_relations: ~6 rows (approximately)
/*!40000 ALTER TABLE `product_relations` DISABLE KEYS */;
INSERT INTO `product_relations` (`prdr_product_relations_ID`, `prdr_product_parent_ID`, `prdr_child_type`, `prdr_product_child_ID`) VALUES
	(17, 1, 'Consumable', 7),
	(18, 1, 'Consumable', 4),
	(19, 1, 'Consumable', 5),
	(20, 1, 'SparePart', 2),
	(21, 3, 'Consumable', 4),
	(22, 3, 'SparePart', 2);
/*!40000 ALTER TABLE `product_relations` ENABLE KEYS */;

-- Dumping structure for table reprodata.send_auto_emails
DROP TABLE IF EXISTS `send_auto_emails`;
CREATE TABLE IF NOT EXISTS `send_auto_emails` (
  `sae_send_auto_emails_serial` int(10) NOT NULL AUTO_INCREMENT,
  `sae_active` varchar(1) COLLATE utf8_bin DEFAULT NULL COMMENT 'A -> Active',
  `sae_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `sae_created_datetime` datetime DEFAULT NULL,
  `sae_send_result` int(3) DEFAULT NULL,
  `sae_send_datetime` datetime DEFAULT NULL,
  `sae_primary_serial` int(10) DEFAULT NULL,
  `sae_primary_label` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_secondary_serial` int(10) DEFAULT NULL,
  `sae_secondary_label` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_label1` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sae_label1_info` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `sae_label2` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sae_label2_info` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_to` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_to_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_from` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_from_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_subject` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_reply_to` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_reply_to_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_cc` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_bcc` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sae_email_body` text COLLATE utf8_bin,
  `sae_attachment_file` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `sae_agent_code` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `sae_send_result_description` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`sae_send_auto_emails_serial`),
  UNIQUE KEY `unique_serial` (`sae_send_auto_emails_serial`),
  KEY `send_result` (`sae_send_result`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.send_auto_emails: ~3 rows (approximately)
/*!40000 ALTER TABLE `send_auto_emails` DISABLE KEYS */;
INSERT INTO `send_auto_emails` (`sae_send_auto_emails_serial`, `sae_active`, `sae_type`, `sae_created_datetime`, `sae_send_result`, `sae_send_datetime`, `sae_primary_serial`, `sae_primary_label`, `sae_secondary_serial`, `sae_secondary_label`, `sae_label1`, `sae_label1_info`, `sae_label2`, `sae_label2_info`, `sae_email_to`, `sae_email_to_name`, `sae_email_from`, `sae_email_from_name`, `sae_email_subject`, `sae_email_reply_to`, `sae_email_reply_to_name`, `sae_email_cc`, `sae_email_bcc`, `sae_email_body`, `sae_attachment_file`, `sae_agent_code`, `sae_send_result_description`) VALUES
	(2, 'A', 'quotation', '2018-05-29 09:17:46', 0, NULL, 17, 'Quotation_ID', NULL, NULL, NULL, NULL, NULL, NULL, 'ermogenousm@gmail.com', 'Michael Ermogenous', '', '', 'A.K.Demetriou Development - Quotation', NULL, NULL, NULL, NULL, 'Please find attached our quotation', 'quotations/pdfFiles/17-20180529091746.pdf', NULL, NULL),
	(3, 'A', 'quotation', '2018-05-29 17:06:56', 0, NULL, 17, 'Quotation_ID', NULL, NULL, NULL, NULL, NULL, NULL, 'gsdfsd@fgdsf.com', 'sdf', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', 'A.K.Demetriou Development - Quotation', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', NULL, NULL, 'Please find attached our quotation', 'quotations/pdfFiles/17-20180529170656.pdf', NULL, NULL),
	(4, 'A', 'quotation', '2018-05-29 17:11:17', 0, NULL, 17, 'Quotation_ID', NULL, NULL, NULL, NULL, NULL, NULL, 'gsdfsd@fgdsf.com', 'sdf', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', 'A.K.Demetriou Development - Quotation', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', NULL, NULL, 'Please find attached our quotation', 'quotations/pdfFiles/17-20180529171116.pdf', NULL, NULL);
/*!40000 ALTER TABLE `send_auto_emails` ENABLE KEYS */;

-- Dumping structure for table reprodata.settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `stg_settings_ID` int(10) NOT NULL AUTO_INCREMENT,
  `stg_section` varchar(50) COLLATE utf8_bin NOT NULL,
  `stg_value` varchar(250) COLLATE utf8_bin NOT NULL,
  `stg_value_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`stg_settings_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.settings: ~7 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`stg_settings_ID`, `stg_section`, `stg_value`, `stg_value_date`) VALUES
	(1, 'admin_default_layout', 'generic', NULL),
	(2, 'user_levels_extra_1_name', 'Agents No Group Option', '2018-04-18 12:41:59'),
	(3, 'user_levels_extra_2_name', 'User 2', '2018-04-12 12:55:31'),
	(4, 'user_levels_extra_3_name', 'User 3', '2018-04-12 12:55:34'),
	(5, 'user_levels_extra_4_name', 'User 4', '2018-04-12 12:55:36'),
	(6, 'user_levels_extra_5_name', 'User 5', '2018-04-12 12:55:38'),
	(7, 'user_levels_extra_6_name', 'User 6', '2018-04-12 12:55:41');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table reprodata.stock
DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `stk_stock_ID` int(8) NOT NULL AUTO_INCREMENT,
  `stk_product_ID` int(8) NOT NULL DEFAULT '0',
  `stk_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `stk_description` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `stk_status` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `stk_add_minus` int(1) DEFAULT NULL,
  `stk_amount` int(8) DEFAULT NULL,
  `stk_date_time` datetime DEFAULT NULL,
  `stk_month` int(2) DEFAULT NULL,
  `stk_year` int(4) DEFAULT NULL,
  `stk_created_date_time` datetime DEFAULT NULL,
  `stk_created_by` int(8) DEFAULT NULL,
  `stk_last_update_date_time` datetime DEFAULT NULL,
  `stk_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`stk_stock_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.stock: ~4 rows (approximately)
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` (`stk_stock_ID`, `stk_product_ID`, `stk_type`, `stk_description`, `stk_status`, `stk_add_minus`, `stk_amount`, `stk_date_time`, `stk_month`, `stk_year`, `stk_created_date_time`, `stk_created_by`, `stk_last_update_date_time`, `stk_last_update_by`) VALUES
	(1, 1, 'transaction', 'Initial', 'Pending', 1, 10, '2018-08-12 19:37:35', 8, 2018, NULL, NULL, NULL, NULL),
	(2, 1, 'transaction', 'Transaction', 'Pending', 1, 5, '2018-08-12 19:39:24', 8, 2018, '2018-08-12 19:39:24', 1, NULL, NULL),
	(6, 1, 'transaction', 'Initial', 'Pending', 1, 1, '2018-08-13 22:34:51', 8, 2018, '2018-08-13 22:34:51', 1, NULL, NULL);
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;

-- Dumping structure for table reprodata.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usr_users_ID` int(8) NOT NULL AUTO_INCREMENT,
  `usr_users_groups_ID` int(8) DEFAULT NULL,
  `usr_active` int(1) NOT NULL,
  `usr_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `usr_username` varchar(100) COLLATE utf8_bin NOT NULL,
  `usr_password` varchar(30) COLLATE utf8_bin NOT NULL,
  `usr_user_rights` int(2) NOT NULL,
  `usr_restrict_ip` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `usr_email` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `usr_email2` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `usr_emailcc` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `usr_emailbcc` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `usr_tel` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `usr_is_agent` int(1) NOT NULL,
  `usr_agent_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usr_agent_level` int(2) NOT NULL,
  `usr_issuing_office_serial` int(10) NOT NULL,
  `usr_description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `usr_signature_gr` text COLLATE utf8_bin,
  `usr_signature_en` text COLLATE utf8_bin,
  `usr_name_gr` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `usr_name_en` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`usr_users_ID`),
  UNIQUE KEY `primary_serial` (`usr_users_ID`),
  KEY `group_serial` (`usr_users_groups_ID`),
  KEY `issuing` (`usr_issuing_office_serial`),
  KEY `active` (`usr_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`usr_users_ID`, `usr_users_groups_ID`, `usr_active`, `usr_name`, `usr_username`, `usr_password`, `usr_user_rights`, `usr_restrict_ip`, `usr_email`, `usr_email2`, `usr_emailcc`, `usr_emailbcc`, `usr_tel`, `usr_is_agent`, `usr_agent_code`, `usr_agent_level`, `usr_issuing_office_serial`, `usr_description`, `usr_signature_gr`, `usr_signature_en`, `usr_name_gr`, `usr_name_en`) VALUES
	(1, 1, 1, 'Michael Ermogenous', 'mike', 'mike', 0, 'ALL', 'it@ydrogios.com.cy', '', '', '', '', 1, '1001', 1, 0, 'Michael Ermogenous', 'Μιχάλης Ερμογένους', 'Michael Ermogenous', 'Michael Ermogenous', 'Michael Ermogenous'),
	(2, 2, 1, 'Advanced User', 'advanced', 'advanced', 1, '', '', '', '', '', '', 0, '', 1, 0, '', '', '', NULL, NULL),
	(3, 3, 1, 'TEST ', '', '12345', 4, '', '', '', '', '', '', 1, '', 10, 0, 'No Group Option', '', '', '', '');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table reprodata.users_groups
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE IF NOT EXISTS `users_groups` (
  `usg_users_groups_ID` int(10) NOT NULL AUTO_INCREMENT,
  `usg_group_name` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `usg_permissions` text COLLATE utf8_bin,
  `usg_restrict_ip` varchar(25) COLLATE utf8_bin NOT NULL,
  `usg_approvals` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`usg_users_groups_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table reprodata.users_groups: ~4 rows (approximately)
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` (`usg_users_groups_ID`, `usg_group_name`, `usg_permissions`, `usg_restrict_ip`, `usg_approvals`) VALUES
	(1, 'Administrators', NULL, '%', 'REQUEST'),
	(2, 'Advanced Users', '', '%', 'ANSWER'),
	(3, 'Agents', '', '', NULL),
	(4, 'Michael', '', '', '');
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
