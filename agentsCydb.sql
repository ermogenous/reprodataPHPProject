/*
Navicat MySQL Data Transfer

Source Server         : Mysql Local
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : reprodata

Target Server Type    : MYSQL
Target Server Version : 100130
File Encoding         : 65001

Date: 2019-06-28 17:05:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for codes
-- ----------------------------
DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `cde_code_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cde_type` varchar(30) DEFAULT NULL,
  `cde_status` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `cde_table_field` varchar(60) DEFAULT NULL,
  `cde_table_field2` varchar(60) DEFAULT NULL,
  `cde_table_field3` varchar(60) DEFAULT NULL,
  `cde_value` varchar(100) DEFAULT NULL,
  `cde_value_label` varchar(30) DEFAULT NULL,
  `cde_value_2` varchar(100) DEFAULT NULL,
  `cde_value_label_2` varchar(30) DEFAULT NULL,
  `cde_value_3` varchar(100) DEFAULT NULL,
  `cde_value_label_3` varchar(30) DEFAULT NULL,
  `cde_option_label` varchar(30) DEFAULT NULL,
  `cde_option_value` varchar(255) DEFAULT NULL,
  `cde_option_label_2` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `cde_option_value_2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cde_created_date_time` datetime DEFAULT NULL,
  `cde_created_by` int(8) DEFAULT NULL,
  `cde_last_update_date_time` datetime DEFAULT NULL,
  `cde_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`cde_code_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=540 DEFAULT CHARSET=utf8 COMMENT='Codes';

-- ----------------------------
-- Records of codes
-- ----------------------------
INSERT INTO `codes` VALUES ('1', 'code', null, 'customers#cst_city_code_ID', null, null, 'Cities', 'City Name', 'CityShort', 'City Name Short', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('2', 'code', null, 'customers#cst_business_type_code_ID', null, null, 'BusinessType', 'Business Type', '', '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('3', 'BusinessType', null, null, null, null, 'Bank', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('4', 'BusinessType', null, null, null, null, 'Insurance', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('5', 'BusinessType', null, null, null, null, 'Private', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('6', 'Cities', null, null, null, null, 'Nicosia', 'City Name', 'NIC', 'City Name Short', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('7', 'Cities', null, null, null, null, 'Limassol', 'City Name', 'LIM', 'City Name Short', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('8', 'Cities', null, null, null, null, 'Larnaca', 'City Name', 'LAR', 'City Name Short', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('9', 'Cities', null, null, null, null, 'Paphos', 'City Name', 'PAF', 'City Name Short', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('10', 'Cities', null, null, null, null, 'Famagusta', 'City Name', 'FAM', 'City Name Short', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('11', 'BusinessType', null, null, null, null, 'Public School', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('12', 'BusinessType', null, null, null, null, 'Accounting', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('13', 'BusinessType', null, null, null, null, 'Law', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('14', 'BusinessType', null, null, null, null, 'Private School', 'Business Type', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('15', 'code', null, 'customers#cst_contact_person_title_code_ID', null, null, 'ContactPersonTitle', 'Contact Person Title', '', '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('16', 'ContactPersonTitle', null, null, null, null, 'Owner', 'Contact Person Title', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('17', 'ContactPersonTitle', null, null, null, null, 'Secretary', 'Contact Person Title', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('18', 'ContactPersonTitle', null, null, null, null, 'Director', 'Contact Person Title', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('19', 'ContactPersonTitle', null, null, null, null, 'IT Manager', 'Contact Person Title', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('20', 'ContactPersonTitle', null, null, null, null, 'IT Technitian', 'Contact Person Title', null, '', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('21', 'code', 'Active', 'manufacturers#mnf_country_code_ID', null, null, 'Countries', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Open#Approval#Reject', null, null, null, null, '2019-04-15 13:38:00', '1');
INSERT INTO `codes` VALUES ('22', 'Countries', 'Active', null, null, null, 'Cyprus', 'Country Name', 'CYP', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, '2019-03-27 16:58:18', '1');
INSERT INTO `codes` VALUES ('23', 'Countries', 'Active', null, null, null, 'Germany', 'Country Name', 'DEU', 'Short Code', null, null, 'Open/Approval/Reject', 'Open', null, null, null, null, '2019-06-04 14:44:38', '1');
INSERT INTO `codes` VALUES ('24', 'Countries', 'Active', null, null, null, 'Greece', 'Country Name', 'GRC', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, '2019-03-27 16:58:23', '1');
INSERT INTO `codes` VALUES ('25', 'code', null, 'products#prd_sub_type_code_ID', null, null, 'ProductsSubType', 'Products SubType', '', '', null, null, 'For Type', 'Machine#Consumables#Spare Parts#Other', null, null, null, null, '2018-12-05 17:04:52', '1');
INSERT INTO `codes` VALUES ('27', 'ProductsSubType', null, null, null, null, 'MultiFunction', 'Products SubType', null, '', null, null, null, 'Machine', null, null, '2018-08-13 23:03:56', '1', '2018-08-13 23:41:01', '1');
INSERT INTO `codes` VALUES ('28', 'ProductsSubType', null, null, null, null, 'Printer', 'Products SubType', null, '', null, null, null, 'Machine', null, null, '2018-08-13 23:45:21', '1', null, null);
INSERT INTO `codes` VALUES ('29', 'ProductsSubType', null, null, null, null, 'Toners', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:45:30', '1', null, null);
INSERT INTO `codes` VALUES ('30', 'ProductsSubType', null, null, null, null, 'Waste Box', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:45:39', '1', null, null);
INSERT INTO `codes` VALUES ('31', 'ProductsSubType', null, null, null, null, 'Stables', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:45:48', '1', null, null);
INSERT INTO `codes` VALUES ('32', 'ProductsSubType', null, null, null, null, 'Developers', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:45:58', '1', null, null);
INSERT INTO `codes` VALUES ('33', 'ProductsSubType', null, null, null, null, 'Drums', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:46:06', '1', null, null);
INSERT INTO `codes` VALUES ('34', 'ProductsSubType', null, null, null, null, 'CL.Blades', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:46:19', '1', null, null);
INSERT INTO `codes` VALUES ('35', 'ProductsSubType', null, null, null, null, 'Heat Rollers/Belts', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:46:35', '1', null, null);
INSERT INTO `codes` VALUES ('36', 'ProductsSubType', null, null, null, null, 'Press Rollers', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:46:45', '1', null, null);
INSERT INTO `codes` VALUES ('37', 'ProductsSubType', null, null, null, null, 'Feed Rollers', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:46:54', '1', null, null);
INSERT INTO `codes` VALUES ('38', 'ProductsSubType', null, null, null, null, 'Maintenance Kits', 'Products SubType', null, '', null, null, null, 'Consumables', null, null, '2018-08-13 23:47:05', '1', null, null);
INSERT INTO `codes` VALUES ('39', 'ProductsSubType', null, null, null, null, 'Spare Parts', 'Products SubType', null, '', null, null, null, 'Spare Parts', null, null, '2018-08-13 23:47:14', '1', null, null);
INSERT INTO `codes` VALUES ('40', 'ProductsSubType', null, null, null, null, 'A4 Paper', 'Products SubType', null, '', null, null, null, 'Other', null, null, '2018-12-05 17:05:16', '1', null, null);
INSERT INTO `codes` VALUES ('41', 'ProductsSubType', null, null, null, null, 'A3 Paper', 'Products SubType', null, '', null, null, null, 'Other', null, null, '2018-12-05 17:08:53', '1', null, null);
INSERT INTO `codes` VALUES ('42', 'code', 'Active', 'oqt_quotations_items#oqqit_rate_2', '', '', 'Currency', 'Currency Code', 'CurrencyLong', 'Currency Long', null, null, '', '', null, null, '2019-03-27 12:48:41', '1', '2019-03-29 11:16:23', '1');
INSERT INTO `codes` VALUES ('45', 'Currency', 'Active', null, null, null, 'AED', 'Currency Code', 'UAE Dirham', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('46', 'Currency', 'Active', null, null, null, ' AFN', 'Currency Code', 'Afghani', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('47', 'Currency', 'Active', null, null, null, ' ALL', 'Currency Code', 'Lek', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('48', 'Currency', 'Active', null, null, null, ' AMD', 'Currency Code', 'Armenian Dram', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('49', 'Currency', 'Active', null, null, null, ' ANG', 'Currency Code', 'Netherlands Antillian Guilder', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('50', 'Currency', 'Active', null, null, null, ' AOA', 'Currency Code', 'Kwanza', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('51', 'Currency', 'Active', null, null, null, ' ARS', 'Currency Code', 'Argentine Peso', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('52', 'Currency', 'Active', null, null, null, ' AUD', 'Currency Code', 'Australian Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('53', 'Currency', 'Active', null, null, null, ' AWG', 'Currency Code', 'Aruban Guilder', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('54', 'Currency', 'Active', null, null, null, ' AZN', 'Currency Code', 'Azerbaijanian Manat', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('55', 'Currency', 'Active', null, null, null, ' BAM', 'Currency Code', 'Convertible Marks', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('56', 'Currency', 'Active', null, null, null, ' BBD', 'Currency Code', 'Barbados Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('57', 'Currency', 'Active', null, null, null, ' BDT', 'Currency Code', 'Taka', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('58', 'Currency', 'Active', null, null, null, ' BGN', 'Currency Code', 'Bulgarian Lev', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('59', 'Currency', 'Active', null, null, null, ' BHD', 'Currency Code', 'Bahraini Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('60', 'Currency', 'Active', null, null, null, ' BIF', 'Currency Code', 'Burundi Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('61', 'Currency', 'Active', null, null, null, ' BMD', 'Currency Code', 'Bermudian Dollar (customarily known as Bermuda Dollar)', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('62', 'Currency', 'Active', null, null, null, ' BND', 'Currency Code', 'Brunei Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('63', 'Currency', 'Active', null, null, null, ' BOB', 'Currency Code', 'Boliviano Mvdol', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('64', 'Currency', 'Active', null, null, null, ' BRL', 'Currency Code', 'Brazilian Real', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('65', 'Currency', 'Active', null, null, null, ' BSD', 'Currency Code', 'Bahamian Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('66', 'Currency', 'Active', null, null, null, ' BWP', 'Currency Code', 'Pula', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('67', 'Currency', 'Active', null, null, null, ' BYR', 'Currency Code', 'Belarussian Ruble', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('68', 'Currency', 'Active', null, null, null, ' BZD', 'Currency Code', 'Belize Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('69', 'Currency', 'Active', null, null, null, ' CAD', 'Currency Code', 'Canadian Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('70', 'Currency', 'Active', null, null, null, ' CDF', 'Currency Code', 'Congolese Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('71', 'Currency', 'Active', null, null, null, ' CHF', 'Currency Code', 'Swiss Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('72', 'Currency', 'Active', null, null, null, ' CLP', 'Currency Code', 'Chilean Peso Unidades de fomento', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('73', 'Currency', 'Active', null, null, null, ' CNY', 'Currency Code', 'Yuan Renminbi', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('74', 'Currency', 'Active', null, null, null, ' COP', 'Currency Code', 'Colombian Peso Unidad de Valor Real', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('75', 'Currency', 'Active', null, null, null, ' CRC', 'Currency Code', 'Costa Rican Colon', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('76', 'Currency', 'Active', null, null, null, ' CUP', 'Currency Code', 'Cuban Peso Peso Convertible', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('77', 'Currency', 'Active', null, null, null, ' CVE', 'Currency Code', 'Cape Verde Escudo', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('78', 'Currency', 'Active', null, null, null, ' CZK', 'Currency Code', 'Czech Koruna', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('79', 'Currency', 'Active', null, null, null, ' DJF', 'Currency Code', 'Djibouti Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('80', 'Currency', 'Active', null, null, null, ' DKK', 'Currency Code', 'Danish Krone', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('81', 'Currency', 'Active', null, null, null, ' DOP', 'Currency Code', 'Dominican Peso', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('82', 'Currency', 'Active', null, null, null, ' DZD', 'Currency Code', 'Algerian Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('83', 'Currency', 'Active', null, null, null, ' EEK', 'Currency Code', 'Kroon', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('84', 'Currency', 'Active', null, null, null, ' EGP', 'Currency Code', 'Egyptian Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('85', 'Currency', 'Active', null, null, null, ' ERN', 'Currency Code', 'Nakfa', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('86', 'Currency', 'Active', null, null, null, ' ETB', 'Currency Code', 'Ethiopian Birr', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('87', 'Currency', 'Active', null, null, null, ' EUR', 'Currency Code', 'Euro', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('88', 'Currency', 'Active', null, null, null, ' FJD', 'Currency Code', 'Fiji Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('89', 'Currency', 'Active', null, null, null, ' FKP', 'Currency Code', 'Falkland Islands Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('90', 'Currency', 'Active', null, null, null, ' GBP', 'Currency Code', 'Pound Sterling', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('91', 'Currency', 'Active', null, null, null, ' GEL', 'Currency Code', 'Lari', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('92', 'Currency', 'Active', null, null, null, ' GHS', 'Currency Code', 'Cedi', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('93', 'Currency', 'Active', null, null, null, ' GIP', 'Currency Code', 'Gibraltar Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('94', 'Currency', 'Active', null, null, null, ' GMD', 'Currency Code', 'Dalasi', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('95', 'Currency', 'Active', null, null, null, ' GNF', 'Currency Code', 'Guinea Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('96', 'Currency', 'Active', null, null, null, ' GTQ', 'Currency Code', 'Quetzal', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('97', 'Currency', 'Active', null, null, null, ' GYD', 'Currency Code', 'Guyana Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('98', 'Currency', 'Active', null, null, null, ' HKD', 'Currency Code', 'Hong Kong Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('99', 'Currency', 'Active', null, null, null, ' HNL', 'Currency Code', 'Lempira', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('100', 'Currency', 'Active', null, null, null, ' HRK', 'Currency Code', 'Croatian Kuna', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('101', 'Currency', 'Active', null, null, null, ' HTG', 'Currency Code', 'Gourde US Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('102', 'Currency', 'Active', null, null, null, ' HUF', 'Currency Code', 'Forint', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('103', 'Currency', 'Active', null, null, null, ' IDR', 'Currency Code', 'Rupiah', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('104', 'Currency', 'Active', null, null, null, ' ILS', 'Currency Code', 'New Israeli Sheqel', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('105', 'Currency', 'Active', null, null, null, ' INR', 'Currency Code', 'Indian Rupee', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('106', 'Currency', 'Active', null, null, null, ' BTN', 'Currency Code', 'Indian Rupee Ngultrum', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('107', 'Currency', 'Active', null, null, null, ' IQD', 'Currency Code', 'Iraqi Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('108', 'Currency', 'Active', null, null, null, ' IRR', 'Currency Code', 'Iranian Rial', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('109', 'Currency', 'Active', null, null, null, ' ISK', 'Currency Code', 'Iceland Krona', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('110', 'Currency', 'Active', null, null, null, ' JMD', 'Currency Code', 'Jamaican Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('111', 'Currency', 'Active', null, null, null, ' JOD', 'Currency Code', 'Jordanian Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('112', 'Currency', 'Active', null, null, null, ' JPY', 'Currency Code', 'Yen', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('113', 'Currency', 'Active', null, null, null, ' KES', 'Currency Code', 'Kenyan Shilling', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('114', 'Currency', 'Active', null, null, null, ' KGS', 'Currency Code', 'Som', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('115', 'Currency', 'Active', null, null, null, ' KHR', 'Currency Code', 'Riel', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('116', 'Currency', 'Active', null, null, null, ' KMF', 'Currency Code', 'Comoro Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('117', 'Currency', 'Active', null, null, null, ' KPW', 'Currency Code', 'North Korean Won', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('118', 'Currency', 'Active', null, null, null, ' KRW', 'Currency Code', 'Won', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('119', 'Currency', 'Active', null, null, null, ' KWD', 'Currency Code', 'Kuwaiti Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('120', 'Currency', 'Active', null, null, null, ' KYD', 'Currency Code', 'Cayman Islands Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('121', 'Currency', 'Active', null, null, null, ' KZT', 'Currency Code', 'Tenge', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('122', 'Currency', 'Active', null, null, null, ' LAK', 'Currency Code', 'Kip', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('123', 'Currency', 'Active', null, null, null, ' LBP', 'Currency Code', 'Lebanese Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('124', 'Currency', 'Active', null, null, null, ' LKR', 'Currency Code', 'Sri Lanka Rupee', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('125', 'Currency', 'Active', null, null, null, ' LRD', 'Currency Code', 'Liberian Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('126', 'Currency', 'Active', null, null, null, ' LTL', 'Currency Code', 'Lithuanian Litas', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('127', 'Currency', 'Active', null, null, null, ' LVL', 'Currency Code', 'Latvian Lats', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('128', 'Currency', 'Active', null, null, null, ' LYD', 'Currency Code', 'Libyan Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('129', 'Currency', 'Active', null, null, null, ' MAD', 'Currency Code', 'Moroccan Dirham', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('130', 'Currency', 'Active', null, null, null, ' MDL', 'Currency Code', 'Moldovan Leu', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('131', 'Currency', 'Active', null, null, null, ' MGA', 'Currency Code', 'Malagasy Ariary', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('132', 'Currency', 'Active', null, null, null, ' MKD', 'Currency Code', 'Denar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('133', 'Currency', 'Active', null, null, null, ' MMK', 'Currency Code', 'Kyat', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('134', 'Currency', 'Active', null, null, null, ' MNT', 'Currency Code', 'Tugrik', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('135', 'Currency', 'Active', null, null, null, ' MOP', 'Currency Code', 'Pataca', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('136', 'Currency', 'Active', null, null, null, ' MRO', 'Currency Code', 'Ouguiya', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('137', 'Currency', 'Active', null, null, null, ' MUR', 'Currency Code', 'Mauritius Rupee', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('138', 'Currency', 'Active', null, null, null, ' MVR', 'Currency Code', 'Rufiyaa', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('139', 'Currency', 'Active', null, null, null, ' MWK', 'Currency Code', 'Kwacha', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('140', 'Currency', 'Active', null, null, null, ' MXN', 'Currency Code', 'Mexican Peso Mexican Unidad de Inversion (UDI)', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('141', 'Currency', 'Active', null, null, null, ' MYR', 'Currency Code', 'Malaysian Ringgit', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('142', 'Currency', 'Active', null, null, null, ' MZN', 'Currency Code', 'Metical', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('143', 'Currency', 'Active', null, null, null, ' NGN', 'Currency Code', 'Naira', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('144', 'Currency', 'Active', null, null, null, ' NIO', 'Currency Code', 'Cordoba Oro', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('145', 'Currency', 'Active', null, null, null, ' NOK', 'Currency Code', 'Norwegian Krone', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('146', 'Currency', 'Active', null, null, null, ' NPR', 'Currency Code', 'Nepalese Rupee', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('147', 'Currency', 'Active', null, null, null, ' NZD', 'Currency Code', 'New Zealand Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('148', 'Currency', 'Active', null, null, null, ' OMR', 'Currency Code', 'Rial Omani', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('149', 'Currency', 'Active', null, null, null, ' PAB', 'Currency Code', 'Balboa US Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('150', 'Currency', 'Active', null, null, null, ' PEN', 'Currency Code', 'Nuevo Sol', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('151', 'Currency', 'Active', null, null, null, ' PGK', 'Currency Code', 'Kina', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('152', 'Currency', 'Active', null, null, null, ' PHP', 'Currency Code', 'Philippine Peso', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('153', 'Currency', 'Active', null, null, null, ' PKR', 'Currency Code', 'Pakistan Rupee', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('154', 'Currency', 'Active', null, null, null, ' PLN', 'Currency Code', 'Zloty', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('155', 'Currency', 'Active', null, null, null, ' PYG', 'Currency Code', 'Guarani', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('156', 'Currency', 'Active', null, null, null, ' QAR', 'Currency Code', 'Qatari Rial', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('157', 'Currency', 'Active', null, null, null, ' RON', 'Currency Code', 'New Leu', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('158', 'Currency', 'Active', null, null, null, ' RSD', 'Currency Code', 'Serbian Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('159', 'Currency', 'Active', null, null, null, ' RUB', 'Currency Code', 'Russian Ruble', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('160', 'Currency', 'Active', null, null, null, ' RWF', 'Currency Code', 'Rwanda Franc', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('161', 'Currency', 'Active', null, null, null, ' SAR', 'Currency Code', 'Saudi Riyal', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('162', 'Currency', 'Active', null, null, null, ' SBD', 'Currency Code', 'Solomon Islands Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('163', 'Currency', 'Active', null, null, null, ' SCR', 'Currency Code', 'Seychelles Rupee', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('164', 'Currency', 'Active', null, null, null, ' SDG', 'Currency Code', 'Sudanese Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('165', 'Currency', 'Active', null, null, null, ' SEK', 'Currency Code', 'Swedish Krona', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('166', 'Currency', 'Active', null, null, null, ' SGD', 'Currency Code', 'Singapore Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('167', 'Currency', 'Active', null, null, null, ' SHP', 'Currency Code', 'Saint Helena Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('168', 'Currency', 'Active', null, null, null, ' SLL', 'Currency Code', 'Leone', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('169', 'Currency', 'Active', null, null, null, ' SOS', 'Currency Code', 'Somali Shilling', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('170', 'Currency', 'Active', null, null, null, ' SRD', 'Currency Code', 'Surinam Dollar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('171', 'Currency', 'Active', null, null, null, ' STD', 'Currency Code', 'Dobra', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('172', 'Currency', 'Active', null, null, null, ' SVC', 'Currency Code', 'El Salvador Colon', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('173', 'Currency', 'Active', null, null, null, ' SYP', 'Currency Code', 'Syrian Pound', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('174', 'Currency', 'Active', null, null, null, ' SZL', 'Currency Code', 'Lilangeni', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('175', 'Currency', 'Active', null, null, null, ' THB', 'Currency Code', 'Baht', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('176', 'Currency', 'Active', null, null, null, ' TJS', 'Currency Code', 'Somoni', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('177', 'Currency', 'Active', null, null, null, ' TMT', 'Currency Code', 'Manat', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('178', 'Currency', 'Active', null, null, null, ' TND', 'Currency Code', 'Tunisian Dinar', 'Currency Long', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('179', 'Countries', 'Active', null, null, null, 'Albania', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('180', 'Countries', 'Active', null, null, null, 'Algeria', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('181', 'Countries', 'Active', null, null, null, 'Andorra', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('182', 'Countries', 'Active', null, null, null, 'Angola', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('183', 'Countries', 'Active', null, null, null, 'Antigua & Barbuda', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('184', 'Countries', 'Active', null, null, null, 'Argentina', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('185', 'Countries', 'Active', null, null, null, 'Armenia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('186', 'Countries', 'Active', null, null, null, 'Aruba', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('187', 'Countries', 'Active', null, null, null, 'Australia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('188', 'Countries', 'Active', null, null, null, 'Azerbaijan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('189', 'Countries', 'Active', null, null, null, 'Bahamas', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('190', 'Countries', 'Active', null, null, null, 'Bahrain', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('191', 'Countries', 'Active', null, null, null, 'Bangladesh', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('192', 'Countries', 'Active', null, null, null, 'Barbados', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('193', 'Countries', 'Active', null, null, null, 'Belarus', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('194', 'Countries', 'Active', null, null, null, 'Belgium', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('195', 'Countries', 'Active', null, null, null, 'Belize', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('196', 'Countries', 'Active', null, null, null, 'Benin', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('197', 'Countries', 'Active', null, null, null, 'Bermuda', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('198', 'Countries', 'Active', null, null, null, 'Bhutan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('199', 'Countries', 'Active', null, null, null, 'Bolivia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('200', 'Countries', 'Active', null, null, null, 'Bosnia & Herzegovina', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('201', 'Countries', 'Active', null, null, null, 'Botswana', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('202', 'Countries', 'Active', null, null, null, 'Brazil', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('203', 'Countries', 'Active', null, null, null, 'Bulgaria', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('204', 'Countries', 'Active', null, null, null, 'Burkina Faso', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('205', 'Countries', 'Active', null, null, null, 'Burundi', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('206', 'Countries', 'Active', null, null, null, 'Cambodia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('207', 'Countries', 'Active', null, null, null, 'Cameroon', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('208', 'Countries', 'Active', null, null, null, 'Canada', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('209', 'Countries', 'Active', null, null, null, 'Cape Verde', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('210', 'Countries', 'Active', null, null, null, 'Cayman Islands', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('211', 'Countries', 'Active', null, null, null, 'Central African Republic', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('212', 'Countries', 'Active', null, null, null, 'Chad', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('213', 'Countries', 'Active', null, null, null, 'Chile', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('214', 'Countries', 'Active', null, null, null, 'China', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('215', 'Countries', 'Active', null, null, null, 'Colombia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('216', 'Countries', 'Active', null, null, null, 'Comoros', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('217', 'Countries', 'Active', null, null, null, 'Costa Rica', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('218', 'Countries', 'Active', null, null, null, 'Croatia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('219', 'Countries', 'Active', null, null, null, 'Curacao', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('220', 'Countries', 'Active', null, null, null, 'Cyprus', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('221', 'Countries', 'Active', null, null, null, 'Czech Republic', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('222', 'Countries', 'Active', null, null, null, 'Denmark', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('223', 'Countries', 'Active', null, null, null, 'Djibouti', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('224', 'Countries', 'Active', null, null, null, 'Dominica', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('225', 'Countries', 'Active', null, null, null, 'Dominican Republic', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('226', 'Countries', 'Active', null, null, null, 'East Timor', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('227', 'Countries', 'Active', null, null, null, 'Ecuador', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('228', 'Countries', 'Active', null, null, null, 'Egypt', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('229', 'Countries', 'Active', null, null, null, 'El Salvador', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('230', 'Countries', 'Active', null, null, null, 'Equatorial Guinea', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('231', 'Countries', 'Active', null, null, null, 'Eritrea', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('232', 'Countries', 'Active', null, null, null, 'Estonia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('233', 'Countries', 'Active', null, null, null, 'Ethiopia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('234', 'Countries', 'Active', null, null, null, 'Fiji', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('235', 'Countries', 'Active', null, null, null, 'Finland', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('236', 'Countries', 'Active', null, null, null, 'France', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('237', 'Countries', 'Active', null, null, null, 'Gabon', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('238', 'Countries', 'Active', null, null, null, 'Gambia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('239', 'Countries', 'Active', null, null, null, 'Georgia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('240', 'Countries', 'Active', null, null, null, 'Germany', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('241', 'Countries', 'Active', null, null, null, 'Ghana', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('242', 'Countries', 'Active', null, null, null, 'Grenada', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('243', 'Countries', 'Active', null, null, null, 'Guam', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('244', 'Countries', 'Active', null, null, null, 'Guinea', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('245', 'Countries', 'Active', null, null, null, 'Guinea-Bissau', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('246', 'Countries', 'Active', null, null, null, 'Guyana', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('247', 'Countries', 'Active', null, null, null, 'Haiti', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('248', 'Countries', 'Active', null, null, null, 'Honduras', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('249', 'Countries', 'Active', null, null, null, 'Hong Kong', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('250', 'Countries', 'Active', null, null, null, 'Hungary', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('251', 'Countries', 'Active', null, null, null, 'Iceland', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('252', 'Countries', 'Active', null, null, null, 'India', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('253', 'Countries', 'Active', null, null, null, 'Indonesia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('254', 'Countries', 'Active', null, null, null, 'Ireland', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('255', 'Countries', 'Active', null, null, null, 'Israel & the Palestinian Authority', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('256', 'Countries', 'Active', null, null, null, 'Italy', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('257', 'Countries', 'Active', null, null, null, 'Jamaica', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('258', 'Countries', 'Active', null, null, null, 'Japan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('259', 'Countries', 'Active', null, null, null, 'Jordan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('260', 'Countries', 'Active', null, null, null, 'Kazakhstan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('261', 'Countries', 'Active', null, null, null, 'Kenya', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('262', 'Countries', 'Active', null, null, null, 'Kiribati', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('263', 'Countries', 'Active', null, null, null, 'Kuwait', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('264', 'Countries', 'Active', null, null, null, 'Kyrgyzstan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('265', 'Countries', 'Active', null, null, null, 'Laos', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('266', 'Countries', 'Active', null, null, null, 'Latvia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('267', 'Countries', 'Active', null, null, null, 'Lebanon', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('268', 'Countries', 'Active', null, null, null, 'Lesotho', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('269', 'Countries', 'Active', null, null, null, 'Liechtenstein', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('270', 'Countries', 'Active', null, null, null, 'Lithuania', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('271', 'Countries', 'Active', null, null, null, 'Luxembourg', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('272', 'Countries', 'Active', null, null, null, 'Macau', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('273', 'Countries', 'Active', null, null, null, 'Macedonia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('274', 'Countries', 'Active', null, null, null, 'Madagascar', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('275', 'Countries', 'Active', null, null, null, 'Malawi', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('276', 'Countries', 'Active', null, null, null, 'Malaysia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('277', 'Countries', 'Active', null, null, null, 'Maldives', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('278', 'Countries', 'Active', null, null, null, 'Mali', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('279', 'Countries', 'Active', null, null, null, 'Malta', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('280', 'Countries', 'Active', null, null, null, 'Marshall Islands', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('281', 'Countries', 'Active', null, null, null, 'Mauritania', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('282', 'Countries', 'Active', null, null, null, 'Mauritius', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('283', 'Countries', 'Active', null, null, null, 'Micronesia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('284', 'Countries', 'Active', null, null, null, 'Monaco', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('285', 'Countries', 'Active', null, null, null, 'Mongolia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('286', 'Countries', 'Active', null, null, null, 'Morocco', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('287', 'Countries', 'Active', null, null, null, 'Mozambique', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('288', 'Countries', 'Active', null, null, null, 'Namibia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('289', 'Countries', 'Active', null, null, null, 'Nauru', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('290', 'Countries', 'Active', null, null, null, 'Nepal', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('291', 'Countries', 'Active', null, null, null, 'Netherlands', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('292', 'Countries', 'Active', null, null, null, 'New Zealand', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('293', 'Countries', 'Active', null, null, null, 'Nicaragua', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('294', 'Countries', 'Active', null, null, null, 'Niger', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('295', 'Countries', 'Active', null, null, null, 'Norway', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('296', 'Countries', 'Active', null, null, null, 'Oman', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('297', 'Countries', 'Active', null, null, null, 'Pakistan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('298', 'Countries', 'Active', null, null, null, 'Palau', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('299', 'Countries', 'Active', null, null, null, 'Panama', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('300', 'Countries', 'Active', null, null, null, 'Papua New Guinea', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('301', 'Countries', 'Active', null, null, null, 'Paraguay', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('302', 'Countries', 'Active', null, null, null, 'Peru', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('303', 'Countries', 'Active', null, null, null, 'Philippines', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('304', 'Countries', 'Active', null, null, null, 'Poland', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('305', 'Countries', 'Active', null, null, null, 'Portugal', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('306', 'Countries', 'Active', null, null, null, 'Puerto Rico', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('307', 'Countries', 'Active', null, null, null, 'Qatar', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('308', 'Countries', 'Active', null, null, null, 'Romania', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('309', 'Countries', 'Active', null, null, null, 'Russia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('310', 'Countries', 'Active', null, null, null, 'Rwanda', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('311', 'Countries', 'Active', null, null, null, 'Saint Kitts & Nevis', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('312', 'Countries', 'Active', null, null, null, 'Saint Lucia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('313', 'Countries', 'Active', null, null, null, 'Samoa', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('314', 'Countries', 'Active', null, null, null, 'Sao Tome & Principe', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('315', 'Countries', 'Active', null, null, null, 'Saudi Arabia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('316', 'Countries', 'Active', null, null, null, 'Senegal', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('317', 'Countries', 'Active', null, null, null, 'Serbia & Montenegro', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('318', 'Countries', 'Active', null, null, null, 'Seychelles', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('319', 'Countries', 'Active', null, null, null, 'Sierra Leone', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('320', 'Countries', 'Active', null, null, null, 'Singapore', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('321', 'Countries', 'Active', null, null, null, 'Slovakia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('322', 'Countries', 'Active', null, null, null, 'Slovenia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('323', 'Countries', 'Active', null, null, null, 'Solomon Islands', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('324', 'Countries', 'Active', null, null, null, 'Somalia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('325', 'Countries', 'Active', null, null, null, 'South Africa', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('326', 'Countries', 'Active', null, null, null, 'Spain', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('327', 'Countries', 'Active', null, null, null, 'Sri Lanka', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('328', 'Countries', 'Active', null, null, null, 'Suriname', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('329', 'Countries', 'Active', null, null, null, 'Swaziland', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('330', 'Countries', 'Active', null, null, null, 'Sweden', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('331', 'Countries', 'Active', null, null, null, 'Switzerland', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('332', 'Countries', 'Active', null, null, null, 'Taiwan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('333', 'Countries', 'Active', null, null, null, 'Tajikistan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('334', 'Countries', 'Active', null, null, null, 'Tanzania', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('335', 'Countries', 'Active', null, null, null, 'Thailand', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('336', 'Countries', 'Active', null, null, null, 'The Channel Islands', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('337', 'Countries', 'Active', null, null, null, 'The Netherlands Antilles', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('338', 'Countries', 'Active', null, null, null, 'Togo', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('339', 'Countries', 'Active', null, null, null, 'Tonga', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('340', 'Countries', 'Active', null, null, null, 'Trinidad & Tobago', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('341', 'Countries', 'Active', null, null, null, 'Tunisia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('342', 'Countries', 'Active', null, null, null, 'Turkey', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('343', 'Countries', 'Active', null, null, null, 'Turkmenistan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('344', 'Countries', 'Active', null, null, null, 'Tuvalu', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('345', 'Countries', 'Active', null, null, null, 'UAE', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('346', 'Countries', 'Active', null, null, null, 'Uganda', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('347', 'Countries', 'Active', null, null, null, 'UK', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('348', 'Countries', 'Active', null, null, null, 'Ukraine', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('349', 'Countries', 'Active', null, null, null, 'Uruguay', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('350', 'Countries', 'Active', null, null, null, 'Uzbekistan', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('351', 'Countries', 'Active', null, null, null, 'Vanuatu', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('352', 'Countries', 'Active', null, null, null, 'Venezuela', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('353', 'Countries', 'Active', null, null, null, 'Vietnam', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('354', 'Countries', 'Active', null, null, null, 'Virgin Island', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('355', 'Countries', 'Active', null, null, null, 'Zambia', 'Country Name', '', 'Short Code', null, null, 'Open/Reffered (Permission)', 'Open', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('356', 'Countries', 'Active', null, null, null, 'Afghanistan', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:19:39', '1', '2019-04-15 13:38:19', '1');
INSERT INTO `codes` VALUES ('357', 'Countries', 'Active', null, null, null, 'Congo / DR Congo', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:00', '1', '2019-04-15 13:38:30', '1');
INSERT INTO `codes` VALUES ('358', 'Countries', 'Active', null, null, null, 'Cote d\' lvoire', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:10', '1', '2019-04-15 13:38:38', '1');
INSERT INTO `codes` VALUES ('359', 'Countries', 'Active', null, null, null, 'Cuba', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:18', '1', '2019-04-15 13:39:46', '1');
INSERT INTO `codes` VALUES ('360', 'Countries', 'Active', null, null, null, 'Guatemala', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:25', '1', '2019-04-15 13:39:52', '1');
INSERT INTO `codes` VALUES ('361', 'Countries', 'Active', null, null, null, 'Iran', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:32', '1', '2019-04-15 13:39:57', '1');
INSERT INTO `codes` VALUES ('362', 'Countries', 'Active', null, null, null, 'Iraq', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:39', '1', '2019-04-15 13:40:03', '1');
INSERT INTO `codes` VALUES ('363', 'Countries', 'Active', null, null, null, 'Liberia', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:47', '1', '2019-04-15 13:40:10', '1');
INSERT INTO `codes` VALUES ('364', 'Countries', 'Active', null, null, null, 'Libya', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:20:53', '1', '2019-04-15 13:40:25', '1');
INSERT INTO `codes` VALUES ('365', 'Countries', 'Active', null, null, null, 'Mexico', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:01', '1', '2019-04-15 13:40:30', '1');
INSERT INTO `codes` VALUES ('366', 'Countries', 'Active', null, null, null, 'Myanmar', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:09', '1', '2019-04-15 13:40:36', '1');
INSERT INTO `codes` VALUES ('367', 'Countries', 'Active', null, null, null, 'North Korea', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:17', '1', '2019-04-15 13:40:41', '1');
INSERT INTO `codes` VALUES ('368', 'Countries', 'Active', null, null, null, 'Sudan', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:24', '1', '2019-04-15 13:40:47', '1');
INSERT INTO `codes` VALUES ('369', 'Countries', 'Active', null, null, null, 'Syria', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:31', '1', '2019-04-15 13:40:52', '1');
INSERT INTO `codes` VALUES ('370', 'Countries', 'Active', null, null, null, 'Yemen', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:37', '1', '2019-04-15 13:41:00', '1');
INSERT INTO `codes` VALUES ('371', 'Countries', 'Active', null, null, null, 'Zimbabwe', 'Country Name', '', 'Short Code', null, null, 'Open/Approval/Reject', 'Reject', '', null, '2019-03-29 11:21:44', '1', '2019-04-15 13:38:14', '1');
INSERT INTO `codes` VALUES ('372', 'code', 'Active', '##', '', '', 'Occupations', 'Occupation', '', 'Kemter ID', null, null, 'Sort', '10#11#12#13#14#15#16#17#18#19#20', '', '', '2019-06-06 10:15:43', '1', '2019-06-06 12:05:20', '1');
INSERT INTO `codes` VALUES ('374', 'Occupations', 'Active', null, null, null, 'ACCOUNTANT', 'Occupation', '2', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('375', 'Occupations', 'Active', null, null, null, 'AGRICULTURE LABOURER', 'Occupation', '3', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('376', 'Occupations', 'Active', null, null, null, 'ASSISTANT DENTIST', 'Occupation', '4', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('377', 'Occupations', 'Active', null, null, null, 'ASSISTANT MANAGER', 'Occupation', '5', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('378', 'Occupations', 'Active', null, null, null, 'ΞΕΝΟΔΟΧΕΙΑ ΚΑΙ ΕΣΤΙΑΤΟΡΙΑ', 'Occupation', '06', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('379', 'Occupations', 'Active', null, null, null, 'BAKER', 'Occupation', '6', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('380', 'Occupations', 'Active', null, null, null, 'BARMAN', 'Occupation', '7', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('381', 'Occupations', 'Active', null, null, null, 'BUSINESSMAN', 'Occupation', '8', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('382', 'Occupations', 'Active', null, null, null, 'BUSINESSWOMAN', 'Occupation', '9', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('383', 'Occupations', 'Active', null, null, null, 'CARETAKER', 'Occupation', '10', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('384', 'Occupations', 'Active', null, null, null, 'CASHIER', 'Occupation', '11', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('385', 'Occupations', 'Active', null, null, null, 'CHAMBERMAID', 'Occupation', '12', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('386', 'Occupations', 'Active', null, null, null, 'CHIEF OFFICER', 'Occupation', '13', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('387', 'Occupations', 'Active', null, null, null, 'CHILD', 'Occupation', '14', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('388', 'Occupations', 'Active', null, null, null, 'CHOCOLATE SPECIALIST', 'Occupation', '15', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('389', 'Occupations', 'Active', null, null, null, 'CHOREOGRAPHER', 'Occupation', '16', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('390', 'Occupations', 'Active', null, null, null, 'CLEANER', 'Occupation', '17', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('391', 'Occupations', 'Active', null, null, null, 'COOK', 'Occupation', '18', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('392', 'Occupations', 'Active', null, null, null, 'COOK A', 'Occupation', '19', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('393', 'Occupations', 'Active', null, null, null, 'COOK B', 'Occupation', '20', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('394', 'Occupations', 'Active', null, null, null, 'DIPLOMATIC STAFF', 'Occupation', '21', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('395', 'Occupations', 'Active', null, null, null, 'DIRECTOR', 'Occupation', '22', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('396', 'Occupations', 'Active', null, null, null, 'DOMESTIC WORKER', 'Occupation', '23', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('397', 'Occupations', 'Active', null, null, null, 'FARM LABOURER', 'Occupation', '24', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('398', 'Occupations', 'Active', null, null, null, 'FARMER', 'Occupation', '25', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('399', 'Occupations', 'Active', null, null, null, 'FISH FARM LABOURER', 'Occupation', '26', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('400', 'Occupations', 'Active', null, null, null, 'GENERAL MANAGER', 'Occupation', '27', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('401', 'Occupations', 'Active', null, null, null, 'HEAD OF CUSTOME SERVICE', 'Occupation', '28', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('402', 'Occupations', 'Active', null, null, null, 'HOTEL EMPLOYEE', 'Occupation', '29', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('403', 'Occupations', 'Active', null, null, null, 'HOUSEBOY', 'Occupation', '30', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('404', 'Occupations', 'Active', null, null, null, 'HOUSEKEEPER', 'Occupation', '31', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('405', 'Occupations', 'Active', null, null, null, 'HOUSEWIFE', 'Occupation', '32', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('406', 'Occupations', 'Active', null, null, null, 'KEY PERSONNEL', 'Occupation', '33', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('407', 'Occupations', 'Active', null, null, null, 'KITCHEN ASSISTANT', 'Occupation', '34', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('408', 'Occupations', 'Active', null, null, null, 'LABOURER', 'Occupation', '35', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('409', 'Occupations', 'Active', null, null, null, 'MANAGER', 'Occupation', '36', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('410', 'Occupations', 'Active', null, null, null, 'MECHANIC', 'Occupation', '37', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('411', 'Occupations', 'Active', null, null, null, 'OFFICE ADMINISTRATOR', 'Occupation', '38', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('412', 'Occupations', 'Active', null, null, null, 'PAINTER', 'Occupation', '39', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('413', 'Occupations', 'Active', null, null, null, 'PRIEST', 'Occupation', '40', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('414', 'Occupations', 'Active', null, null, null, 'PRIVATE EMPLOYEE', 'Occupation', '41', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('415', 'Occupations', 'Active', null, null, null, 'PUPIL', 'Occupation', '42', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('416', 'Occupations', 'Active', null, null, null, 'QUARRY LABOURER', 'Occupation', '43', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('417', 'Occupations', 'Active', null, null, null, 'RESTAURANT EMPLOYEE', 'Occupation', '44', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('418', 'Occupations', 'Active', null, null, null, 'SALES ACCOUNT MANAGER', 'Occupation', '45', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('419', 'Occupations', 'Active', null, null, null, 'SALES ASSISTANT', 'Occupation', '46', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('420', 'Occupations', 'Active', null, null, null, 'SALES WOMAN', 'Occupation', '47', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('421', 'Occupations', 'Active', null, null, null, 'SECRETARY', 'Occupation', '48', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('422', 'Occupations', 'Active', null, null, null, 'SELF EMPLOYEED', 'Occupation', '49', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('423', 'Occupations', 'Active', null, null, null, 'SERVICE OFFICER', 'Occupation', '50', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('424', 'Occupations', 'Active', null, null, null, 'SPA THERAPIST', 'Occupation', '51', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('425', 'Occupations', 'Active', null, null, null, 'STUDENT', 'Occupation', '52', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('426', 'Occupations', 'Active', null, null, null, 'SUPERMARKET EMPLOYEE', 'Occupation', '53', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('427', 'Occupations', 'Active', null, null, null, 'TEACHER', 'Occupation', '54', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('428', 'Occupations', 'Active', null, null, null, 'TECHNICIAN', 'Occupation', '55', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('429', 'Occupations', 'Active', null, null, null, 'TENNNIS COACH', 'Occupation', '56', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('430', 'Occupations', 'Active', null, null, null, 'TOURIST REPRESENTATIVE', 'Occupation', '57', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('431', 'Occupations', 'Active', null, null, null, 'TRAVEL AGENT', 'Occupation', '58', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('432', 'Occupations', 'Active', null, null, null, 'TREASURER', 'Occupation', '59', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('433', 'Occupations', 'Active', null, null, null, 'VISITOR', 'Occupation', '60', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('434', 'Occupations', 'Active', null, null, null, 'VOLLEY BALL PLAYER', 'Occupation', '61', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('435', 'Occupations', 'Active', null, null, null, 'WAITRESS', 'Occupation', '62', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('436', 'Occupations', 'Active', null, null, null, 'HEALTH STAFF', 'Occupation', '63', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('437', 'Occupations', 'Active', null, null, null, 'BUILDER TECHNICIAN', 'Occupation', '64', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('438', 'Occupations', 'Active', null, null, null, 'CHEF', 'Occupation', '65', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('439', 'Occupations', 'Active', null, null, null, 'BUILDER', 'Occupation', '66', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('440', 'Occupations', 'Active', null, null, null, 'COMPUTER PROGRAMMER', 'Occupation', '67', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('441', 'Occupations', 'Active', null, null, null, 'BUILDING CONTRACTOR', 'Occupation', '68', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('442', 'Occupations', 'Active', null, null, null, 'TRANSLATOR', 'Occupation', '69', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('443', 'Occupations', 'Active', null, null, null, 'ASSISTANT STOCK KEEPER', 'Occupation', '70', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('444', 'Occupations', 'Active', null, null, null, 'HEAD RECEPTIONIST', 'Occupation', '71', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('445', 'Occupations', 'Active', null, null, null, 'HAIRDRESSER', 'Occupation', '72', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('446', 'Occupations', 'Active', null, null, null, 'MASSEUR', 'Occupation', '73', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('447', 'Occupations', 'Active', null, null, null, 'SALESMAN', 'Occupation', '74', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('448', 'Occupations', 'Active', null, null, null, 'POOL CLEANER', 'Occupation', '75', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('449', 'Occupations', 'Active', null, null, null, 'BARMAID', 'Occupation', '76', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('450', 'Occupations', 'Active', null, null, null, 'CUSTOMER SUPPORT', 'Occupation', '77', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('451', 'Occupations', 'Active', null, null, null, 'TAILOR', 'Occupation', '78', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('452', 'Occupations', 'Active', null, null, null, 'VESSEL OPERATOR', 'Occupation', '79', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('453', 'Occupations', 'Active', null, null, null, 'WELDER AT HEIGHTS', 'Occupation', '80', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('454', 'Occupations', 'Active', null, null, null, 'CATERING SERVICES', 'Occupation', '81', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('455', 'Occupations', 'Active', null, null, null, 'DANCER', 'Occupation', '82', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('456', 'Occupations', 'Active', null, null, null, 'HAIRDRESSER', 'Occupation', '83', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('457', 'Occupations', 'Active', null, null, null, 'FOOTBALL PLAYER', 'Occupation', '84', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('458', 'Occupations', 'Active', null, null, null, 'COACH', 'Occupation', '85', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('459', 'Occupations', 'Active', null, null, null, 'BEAUTICIAN', 'Occupation', '86', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('460', 'Occupations', 'Active', null, null, null, 'WINDOW CLEANER', 'Occupation', '87', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('461', 'Occupations', 'Active', null, null, null, 'LAWYER', 'Occupation', '88', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('462', 'Occupations', 'Active', null, null, null, 'BACK OFFICE STAFF', 'Occupation', '89', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('463', 'Occupations', 'Active', null, null, null, 'GARDENER', 'Occupation', '90', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('464', 'Occupations', 'Active', null, null, null, 'GENERAL LABOUR', 'Occupation', '91', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('465', 'Occupations', 'Active', null, null, null, 'FINANCIAL AND CONSULTING SERVICES', 'Occupation', '92', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('466', 'Occupations', 'Active', null, null, null, 'WORKER', 'Occupation', '93', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('467', 'Occupations', 'Active', null, null, null, 'HEAD OF ELECTRONIC TRADING DEVELOPMENT', 'Occupation', '94', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('468', 'Occupations', 'Active', null, null, null, 'PHARMACEUTICAL', 'Occupation', '95', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('469', 'Occupations', 'Active', null, null, null, 'CONSTRUCTIONS', 'Occupation', '96', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('470', 'Occupations', 'Active', null, null, null, 'STOCK KEEPER', 'Occupation', '97', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('471', 'Occupations', 'Active', null, null, null, 'BLACKSMITH', 'Occupation', '98', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('472', 'Occupations', 'Active', null, null, null, 'FLORIST', 'Occupation', '99', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('473', 'Occupations', 'Active', null, null, null, 'OFFSHORE TRADING COMPANY', 'Occupation', '100', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('474', 'Occupations', 'Active', null, null, null, 'ASSISTANT BAKER', 'Occupation', '101', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('475', 'Occupations', 'Active', null, null, null, 'OFFICE EMPLOYEE', 'Occupation', '102', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('476', 'Occupations', 'Active', null, null, null, 'ASSISTANT IN KITCHEN', 'Occupation', '103', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('477', 'Occupations', 'Active', null, null, null, 'CHARITY', 'Occupation', '104', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('478', 'Occupations', 'Active', null, null, null, 'SUPERVISOR', 'Occupation', '105', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('479', 'Occupations', 'Active', null, null, null, 'WAITER', 'Occupation', '106', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('480', 'Occupations', 'Active', null, null, null, 'TOUR OPERATOR', 'Occupation', '107', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('481', 'Occupations', 'Active', null, null, null, 'SALES MANAGER', 'Occupation', '108', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('482', 'Occupations', 'Active', null, null, null, 'IT SPECIALIST', 'Occupation', '109', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('483', 'Occupations', 'Active', null, null, null, 'DELIVERY DRIVER', 'Occupation', '110', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('484', 'Occupations', 'Active', null, null, null, 'HEAVES', 'Occupation', '111', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('485', 'Occupations', 'Active', null, null, null, 'PROJECT AND PRODUCT MANAGER', 'Occupation', '112', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('486', 'Occupations', 'Active', null, null, null, 'ROBOTIC MACHINE OPERATOR', 'Occupation', '113', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('487', 'Occupations', 'Active', null, null, null, 'OFFICE STAFF', 'Occupation', '114', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('488', 'Occupations', 'Active', null, null, null, 'WEB DEVELOPER', 'Occupation', '115', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('489', 'Occupations', 'Active', null, null, null, 'INVESTMENT COMPANY', 'Occupation', '116', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('490', 'Occupations', 'Active', null, null, null, 'DEVELOPER', 'Occupation', '117', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('491', 'Occupations', 'Active', null, null, null, 'ΟΙΚΙΑΚΕΣ ΥΠΗΡΕΣΙΕΣ', 'Occupation', '118', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('492', 'Occupations', 'Active', null, null, null, 'CLIENT RELATIONS MANAGER', 'Occupation', '119', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('493', 'Occupations', 'Active', null, null, null, 'ΓΡΑΦΕΙΑΚΕΣ ΥΠΗΡΕΣΙΕΣ', 'Occupation', '120', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('494', 'Occupations', 'Active', null, null, null, 'DENTIST', 'Occupation', '121', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('495', 'Occupations', 'Active', null, null, null, 'ΚΤΗΝΟΤΡΟΦΙΚΕΣ ΕΡΓΑΣΙΕΣ', 'Occupation', '122', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('496', 'Occupations', 'Active', null, null, null, 'ΓΕΩΡΓΙΚΕΣ ΕΡΓΑΣΙΕΣ', 'Occupation', '123', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('497', 'Occupations', 'Active', null, null, null, 'ΕΡΓΑΣΙΕΣ ΦΑΡΜΑΣ', 'Occupation', '124', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('498', 'Occupations', 'Active', null, null, null, 'ΓΕΩΡΓΟΚΤΗΝΟΤΡΟΦΙΚΕΣ ΕΡΓΑΣΙΕΣ', 'Occupation', '125', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('499', 'Occupations', 'Active', null, null, null, 'TECHNICAL ENGINEER', 'Occupation', '126', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('500', 'Occupations', 'Active', null, null, null, 'ARCHITECT', 'Occupation', '127', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('501', 'Occupations', 'Active', null, null, null, 'ΚΑΘΑΡΙΣΤΡΙΑ ΞΕΝΟΔΟΧΕΙΟΥ', 'Occupation', '128', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('502', 'Occupations', 'Active', null, null, null, 'DEVELOPMENT AND OPERATIONS MANAGER', 'Occupation', '129', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('503', 'Occupations', 'Active', null, null, null, 'ΕΡΓΑΣΙΕΣ ΙΧΘΥΟΤΡΟΦΕΙΟΥ', 'Occupation', '130', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('504', 'Occupations', 'Active', null, null, null, 'ΤΕΧΝΙΚΟΣ ΦΩΤΟΒΟΛΤΑΙΚΩΝ', 'Occupation', '131', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('505', 'Occupations', 'Active', null, null, null, 'KINDERGARTEN TEACHER', 'Occupation', '132', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('506', 'Occupations', 'Active', null, null, null, 'REAL ESTATE CONSULTANT', 'Occupation', '133', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('507', 'Occupations', 'Active', null, null, null, 'IT ADMINISTRATOR', 'Occupation', '134', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('508', 'Occupations', 'Active', null, null, null, 'ΦΙΛΑΝΘΡΩΠΙΚΟΣ ΟΡΓΑΝΙΣΜΟΣ', 'Occupation', '135', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('509', 'Occupations', 'Active', null, null, null, 'DEPUTY HEAD OF ADMINISTRATION', 'Occupation', '136', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('510', 'Occupations', 'Active', null, null, null, 'CUSTOMER SUPPORT REPRESENTATIVE', 'Occupation', '137', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('511', 'Occupations', 'Active', null, null, null, 'BUSINESS CONSULTANT', 'Occupation', '138', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('512', 'Occupations', 'Active', null, null, null, 'GYM INSTRUCTOR', 'Occupation', '139', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('513', 'Occupations', 'Active', null, null, null, 'AUDITOR', 'Occupation', '140', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('514', 'Occupations', 'Active', null, null, null, 'CAR WASH EMPLOYEE', 'Occupation', '141', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('515', 'Occupations', 'Active', null, null, null, 'ΚΗΠΟΥΡΟΙ', 'Occupation', '142', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('516', 'Occupations', 'Active', null, null, null, 'CHIEF ACCOUNTANT', 'Occupation', '143', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('517', 'Occupations', 'Active', null, null, null, 'SURVEYING ENGINEER', 'Occupation', '144', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('518', 'Occupations', 'Active', null, null, null, 'JAVA DEVELOPER', 'Occupation', '145', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('519', 'Occupations', 'Active', null, null, null, 'SETTLEMENT\'S AND BANK OFFICE REPRESENTATIVE', 'Occupation', '146', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('520', 'Occupations', 'Active', null, null, null, 'ENTERTAINER', 'Occupation', '147', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('521', 'Occupations', 'Active', null, null, null, 'BEAUTY SALOON MANAGER', 'Occupation', '148', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('522', 'Occupations', 'Active', null, null, null, 'LEGAL CONSULTANT', 'Occupation', '149', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('523', 'Occupations', 'Active', null, null, null, 'INTERNET GAME DEVELOPER', 'Occupation', '150', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('524', 'Occupations', 'Active', null, null, null, 'FASHION DESIGNER', 'Occupation', '151', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('525', 'Occupations', 'Active', null, null, null, 'ΑΡΤΟΠΟΙΕΙΟ', 'Occupation', '152', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('526', 'Occupations', 'Active', null, null, null, 'WAKESURE TEACHER', 'Occupation', '153', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('527', 'Occupations', 'Active', null, null, null, 'SOFTWARE DEVELOPER', 'Occupation', '154', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('528', 'Occupations', 'Active', null, null, null, 'CONSULTANT', 'Occupation', '155', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('529', 'Occupations', 'Active', null, null, null, 'ΧΡΗΜΑΤΟΟΙΚΟΝΟΜΙΚΕΣ ΥΠΗΡΕΣΙΕΣ', 'Occupation', '156', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('530', 'Occupations', 'Active', null, null, null, 'STOCK EXCHANGE', 'Occupation', '157', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('531', 'Occupations', 'Active', null, null, null, 'LEAD FINANCE SPECIALIST', 'Occupation', '158', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('532', 'Occupations', 'Active', null, null, null, 'MAINTENANCE', 'Occupation', '159', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('533', 'Occupations', 'Active', null, null, null, 'DIVER', 'Occupation', '160', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('534', 'Occupations', 'Active', null, null, null, 'COMPUTER & NETWORK SECURITY', 'Occupation', '161', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('535', 'Occupations', 'Active', null, null, null, 'CHEF EXECUTIVE OFFICER', 'Occupation', '162', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('536', 'Occupations', 'Active', null, null, null, 'UN  OFFICER', 'Occupation', '163', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('537', 'Occupations', 'Active', null, null, null, 'BUSINESS ANALYTIC', 'Occupation', '164', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('538', 'Occupations', 'Active', null, null, null, 'INTERPRETER', 'Occupation', '165', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('539', 'Occupations', 'Active', null, null, null, 'ONLINE GAMES', 'Occupation', '166', 'Kemter ID', null, null, 'Sort', '20', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `cst_customer_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cst_user_ID` int(8) DEFAULT NULL,
  `cst_for_user_group_ID` int(8) DEFAULT NULL,
  `cst_basic_account_ID` int(8) DEFAULT NULL,
  `cst_identity_card` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `cst_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cst_surname` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `cst_address_line_1` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `cst_address_line_2` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `cst_city_code_ID` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_contact_person` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cst_contact_person_title_code_ID` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_work_tel_1` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_work_tel_2` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_fax` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_mobile_1` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_mobile_2` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cst_email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `cst_email_newsletter` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cst_business_type_code_ID` int(8) DEFAULT NULL,
  `cst_created_date_time` datetime DEFAULT NULL,
  `cst_created_by` int(8) DEFAULT NULL,
  `cst_last_update_date_time` datetime DEFAULT NULL,
  `cst_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`cst_customer_ID`),
  KEY `name-surname-id-allTel` (`cst_identity_card`,`cst_name`,`cst_surname`,`cst_work_tel_1`,`cst_work_tel_2`,`cst_fax`,`cst_mobile_1`,`cst_mobile_2`),
  KEY `customerID` (`cst_customer_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Customers';

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', '1', '1', '1', '786613', 'Michael', 'Ermogenous', 'add1', 'add2', '8', null, '18', '24123456', '24654321', '24010101', '99420544', '99123456', 'ermogenousm@gmail.com', 'ermogenousm@gmail.com', '5', null, null, '2019-03-07 13:12:12', '1');
INSERT INTO `customers` VALUES ('2', '1', '1', '2', '123456', 'Giorgos', 'Georgiou', '', '', '8', '', '18', '24123456', '', '', '99123456', '', '', '', '12', '2018-08-24 00:51:42', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('3', '1', '1', '3', '99887766', 'Andreas', 'Andreou', '', '', '7', 'Andreas', '16', '24123654', '', '', '99123654', '', '', '', '5', '2018-10-02 10:16:06', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('4', '1', '1', '4', '1111', 'Andreas', '', '', '', '8', '', '16', '', '', '', '', '', '', '', '4', '2019-02-10 10:37:30', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('5', '1', '1', '5', '1212', 'Maria', '', '', '', '8', '', '18', '', '', '', '', '', '', '', '12', '2019-02-10 10:40:41', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('7', '1', '1', '6', '121212', 'dfsdfsd', '', '', '', '8', '', '18', '', '', '', '', '', '', '', '12', '2019-02-11 20:56:58', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('8', '1', '1', '10', '4534543', 'Ermis', 'Ermou', '', '', '8', '', '19', '', '', '', '', '', '', '', '5', '2019-03-07 13:31:57', '1', '2019-03-07 13:31:57', '1');

-- ----------------------------
-- Table structure for customer_groups
-- ----------------------------
DROP TABLE IF EXISTS `customer_groups`;
CREATE TABLE `customer_groups` (
  `csg_customer_group_ID` int(8) NOT NULL AUTO_INCREMENT,
  `csg_for_user_group_ID` int(8) NOT NULL DEFAULT '0',
  `csg_active` int(1) NOT NULL DEFAULT '0',
  `csg_code` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `csg_description` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`csg_customer_group_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of customer_groups
-- ----------------------------
INSERT INTO `customer_groups` VALUES ('1', '0', '1', 'testGroup', 'A test customer Groups');
INSERT INTO `customer_groups` VALUES ('2', '0', '1', 'test2', 'Test2');

-- ----------------------------
-- Table structure for customer_group_relation
-- ----------------------------
DROP TABLE IF EXISTS `customer_group_relation`;
CREATE TABLE `customer_group_relation` (
  `cstg_customer_group_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cstg_customer_ID` int(8) NOT NULL DEFAULT '0',
  `cstg_customer_groups_ID` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cstg_customer_group_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of customer_group_relation
-- ----------------------------
INSERT INTO `customer_group_relation` VALUES ('1', '1', '2');
INSERT INTO `customer_group_relation` VALUES ('2', '1', '1');
INSERT INTO `customer_group_relation` VALUES ('3', '2', '1');
INSERT INTO `customer_group_relation` VALUES ('4', '3', '1');
INSERT INTO `customer_group_relation` VALUES ('5', '3', '2');

-- ----------------------------
-- Table structure for customer_products
-- ----------------------------
DROP TABLE IF EXISTS `customer_products`;
CREATE TABLE `customer_products` (
  `cspr_customer_product_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cspr_customer_ID` int(8) DEFAULT NULL,
  `cspr_product_ID` int(8) DEFAULT NULL,
  `cspr_deal_type_code_ID` int(8) DEFAULT NULL,
  `cspr_sold_date` date DEFAULT NULL,
  `cspr_active` int(1) DEFAULT NULL,
  `cspr_inactive_reason` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cspr_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `cspr_created_by` int(8) DEFAULT NULL,
  `cspr_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `cspr_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`cspr_customer_product_ID`),
  KEY `customer_ID` (`cspr_customer_ID`),
  KEY `product_ID` (`cspr_product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of customer_products
-- ----------------------------

-- ----------------------------
-- Table structure for ina_insurance_codes
-- ----------------------------
DROP TABLE IF EXISTS `ina_insurance_codes`;
CREATE TABLE `ina_insurance_codes` (
  `inaic_insurance_code_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaic_section` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `inaic_code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `inaic_tab_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `inaic_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `inaic_description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `inaic_order` int(8) DEFAULT NULL,
  `inaic_created_date_time` datetime DEFAULT NULL,
  `inaic_created_by` int(8) DEFAULT NULL,
  `inaic_last_update_date_time` datetime DEFAULT NULL,
  `inaic_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inaic_insurance_code_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_insurance_codes
-- ----------------------------
INSERT INTO `ina_insurance_codes` VALUES ('1', 'policy_type', 'Fire', 'Risk Locations', 'Fire', 'Fire', '1', '2019-01-29 09:42:25', null, '2019-01-29 09:42:25', null);
INSERT INTO `ina_insurance_codes` VALUES ('2', 'policy_type', 'Motor', 'Vehicles', 'Motor', 'Motor', '0', '2019-01-29 09:42:23', null, '2019-01-29 09:42:23', null);
INSERT INTO `ina_insurance_codes` VALUES ('3', 'policy_type', 'EL', 'Members', 'EL', 'Employers Liability', '2', '2019-01-28 19:24:00', null, '2019-01-28 19:24:00', null);
INSERT INTO `ina_insurance_codes` VALUES ('4', 'policy_type', 'PL', 'Members', 'PL', 'Public Liability', '3', '2019-01-28 19:24:02', null, '2019-01-28 19:24:02', null);
INSERT INTO `ina_insurance_codes` VALUES ('5', 'policy_type', 'PI', 'Members', 'PI', 'Proffessional Indemnity', '7', '2019-01-28 19:24:04', null, '2019-01-28 19:24:04', null);
INSERT INTO `ina_insurance_codes` VALUES ('6', 'policy_type', 'CAR', 'Risk Locations', 'CAR', 'Constructors All Risk', '6', '2019-01-29 09:42:29', null, '2019-01-29 09:42:29', null);
INSERT INTO `ina_insurance_codes` VALUES ('7', 'policy_type', 'PA', 'Members', 'PA', 'Personal Accident', '4', '2019-01-28 19:24:05', null, '2019-01-28 19:24:05', null);
INSERT INTO `ina_insurance_codes` VALUES ('8', 'policy_type', 'Medical', 'Members', 'Medical', 'Medical', '5', '2019-01-28 19:24:05', null, '2019-01-28 19:24:05', null);
INSERT INTO `ina_insurance_codes` VALUES ('9', 'vehicle_body_type', 'Sedan', null, 'Sedan', 'Sedan', null, null, null, null, null);
INSERT INTO `ina_insurance_codes` VALUES ('10', 'vehicle_body_type', 'SUV', null, 'SUV', 'SUV', null, '2019-01-29 10:06:12', null, '2019-01-29 10:06:12', null);
INSERT INTO `ina_insurance_codes` VALUES ('11', 'vehicle_body_type', 'MPV', null, 'MPV', 'MPV', null, '2019-01-29 10:06:17', null, '2019-01-29 10:06:17', null);
INSERT INTO `ina_insurance_codes` VALUES ('12', 'vehicle_body_type', 'DoubleCabin', null, 'Double Cabin', 'Double Cabin', null, '2019-01-29 10:07:12', null, '2019-01-29 10:07:12', null);
INSERT INTO `ina_insurance_codes` VALUES ('13', 'vehicle_make', 'Opel', null, 'Opel', 'Opel', null, null, null, null, null);
INSERT INTO `ina_insurance_codes` VALUES ('14', 'vehicle_make', 'Toyota', null, 'Toyota', 'Toyota', null, null, null, null, null);
INSERT INTO `ina_insurance_codes` VALUES ('15', 'vehicle_color', 'White', null, 'White', 'White', null, null, null, null, null);
INSERT INTO `ina_insurance_codes` VALUES ('16', 'vehicle_color', 'Black', null, 'Black', 'Black', null, '2019-01-29 10:38:06', null, '2019-01-29 10:38:06', null);
INSERT INTO `ina_insurance_codes` VALUES ('17', 'vehicle_color', 'Silver', null, 'Silver', 'Silver', null, '2019-01-29 10:38:09', null, '2019-01-29 10:38:09', null);

-- ----------------------------
-- Table structure for ina_insurance_companies
-- ----------------------------
DROP TABLE IF EXISTS `ina_insurance_companies`;
CREATE TABLE `ina_insurance_companies` (
  `inainc_insurance_company_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inainc_status` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `inainc_code` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `inainc_name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `inainc_description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `inainc_country_code_ID` int(8) NOT NULL DEFAULT '0',
  `inainc_use_motor` int(1) NOT NULL DEFAULT '0',
  `inainc_use_fire` int(1) NOT NULL DEFAULT '0',
  `inainc_use_pa` int(1) NOT NULL DEFAULT '0',
  `inainc_use_el` int(1) NOT NULL DEFAULT '0',
  `inainc_use_pi` int(1) NOT NULL DEFAULT '0',
  `inainc_use_pl` int(1) NOT NULL DEFAULT '0',
  `inainc_use_medical` int(1) NOT NULL DEFAULT '0',
  `inainc_created_date_time` datetime DEFAULT NULL,
  `inainc_created_by` int(8) NOT NULL DEFAULT '0',
  `inainc_last_update_date_time` datetime DEFAULT NULL,
  `inainc_last_update_by` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inainc_insurance_company_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_insurance_companies
-- ----------------------------
INSERT INTO `ina_insurance_companies` VALUES ('1', 'Active', 'AI', 'AIG', 'AIG', '22', '1', '1', '0', '0', '0', '0', '0', '2019-01-23 10:02:29', '1', '2019-05-27 16:56:02', '1');
INSERT INTO `ina_insurance_companies` VALUES ('2', 'InActive', 'AL', 'ALLIANZ', 'ALLIANZ', '22', '0', '0', '1', '1', '0', '0', '0', '2019-01-23 10:45:52', '1', '2019-05-27 16:56:11', '1');
INSERT INTO `ina_insurance_companies` VALUES ('3', 'Active', 'ALTIUS', 'ALTIUS', 'ALTIUS', '22', '0', '0', '0', '0', '0', '1', '1', '2019-01-23 10:48:39', '1', '2019-05-27 18:11:39', '1');
INSERT INTO `ina_insurance_companies` VALUES ('4', 'Active', 'ATLANTIC', 'ATLANTIC', 'ATLANTIC', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:48:48', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('5', 'Active', 'CNP', 'CNP', 'CNP', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:48:57', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('6', 'Active', 'COMMERCIAL GENERAL I', 'COMMERCIAL GENERAL INSURANCE', 'COMMERCIAL GENERAL INSURANCE', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:49:08', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('7', 'Active', 'COSMOS', 'COSMOS', 'COSMOS', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:49:17', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('8', 'Active', 'ETHNIKI GENERAL INSU', 'ETHNIKI GENERAL INSURANCE', 'ETHNIKI GENERAL INSURANCE', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:49:26', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('9', 'Active', 'EUROSURE', 'EUROSURE', 'EUROSURE', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:49:34', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('10', 'Active', 'GAN DIRECT', 'GAN DIRECT', 'GAN DIRECT', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:49:42', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('11', 'Active', 'GENERAL INSURANCE OF', 'GENERAL INSURANCE OF CYPRUS', 'GENERAL INSURANCE OF CYPRUS', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:50:31', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('12', 'Active', 'HYDRA', 'HYDRA', 'HYDRA', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:50:44', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('13', 'Active', 'KENTRIKI', 'KENTRIKI', 'KENTRIKI', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:50:52', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('14', 'Active', 'LUMEN', 'LUMEN', 'LUMEN', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:51:01', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('15', 'Active', 'MINERVA', 'MINERVA', 'MINERVA', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:51:19', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('16', 'Active', 'OLYMPIC', 'OLYMPIC', 'OLYMPIC', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:51:27', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('17', 'Active', 'PANCYPRIAN', 'PANCYPRIAN', 'PANCYPRIAN', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:51:36', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('18', 'Active', 'PRIME INSURANCE', 'PRIME INSURANCE', 'PRIME INSURANCE', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:51:44', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('19', 'Active', 'PROGRESSIVE', 'PROGRESSIVE', 'PROGRESSIVE', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:51:52', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('20', 'Active', 'ROYAL CROWN', 'ROYAL CROWN', 'ROYAL CROWN', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:52:06', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('21', 'Active', 'TRADEWISE INSURANCE ', 'TRADEWISE INSURANCE COMPANY LIMITED', 'TRADEWISE INSURANCE COMPANY LIMITED', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:52:16', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('22', 'Active', 'TRUST', 'TRUST', 'TRUST', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:52:24', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('23', 'Active', 'YDROGIOS', 'YDROGIOS', 'YDROGIOS', '22', '1', '1', '1', '1', '1', '1', '1', '2019-01-23 10:52:31', '1', '2019-04-26 19:01:56', '1');
INSERT INTO `ina_insurance_companies` VALUES ('24', 'Active', 'ΚΟΙΝΟΠΡΑΞΙΑ', 'ΚΟΙΝΟΠΡΑΞΙΑ', 'ΚΟΙΝΟΠΡΑΞΙΑ', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:52:39', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('25', 'Active', 'Anytime', 'Anytime', 'Anytime', '22', '0', '0', '0', '0', '0', '0', '0', '2019-01-23 10:57:03', '1', null, '0');

-- ----------------------------
-- Table structure for ina_policies
-- ----------------------------
DROP TABLE IF EXISTS `ina_policies`;
CREATE TABLE `ina_policies` (
  `inapol_policy_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapol_for_user_group_ID` int(8) DEFAULT NULL,
  `inapol_underwriter_ID` int(8) DEFAULT NULL,
  `inapol_insurance_company_ID` int(8) DEFAULT NULL,
  `inapol_customer_ID` int(8) DEFAULT NULL,
  `inapol_installment_ID` int(8) DEFAULT NULL,
  `inapol_type_code` varchar(12) COLLATE utf8_bin DEFAULT NULL COMMENT 'Motor, Fire, EL, PL, PA, PI,',
  `inapol_policy_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `inapol_period_starting_date` date DEFAULT NULL,
  `inapol_starting_date` date DEFAULT NULL,
  `inapol_expiry_date` date DEFAULT NULL,
  `inapol_status` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `inapol_process_status` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `inapol_premium` decimal(10,2) DEFAULT NULL,
  `inapol_mif` decimal(10,2) DEFAULT NULL,
  `inapol_commission` decimal(10,2) DEFAULT NULL,
  `inapol_fees` decimal(10,2) DEFAULT NULL,
  `inapol_stamps` decimal(10,2) DEFAULT NULL,
  `inapol_replacing_ID` int(8) DEFAULT NULL,
  `inapol_replaced_by_ID` int(8) DEFAULT NULL,
  `inapol_created_date_time` datetime DEFAULT NULL,
  `inapol_created_by` int(8) DEFAULT NULL,
  `inapol_last_update_date_time` datetime DEFAULT NULL,
  `inapol_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapol_policy_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policies
-- ----------------------------
INSERT INTO `ina_policies` VALUES ('1', '1', '1', '1', '8', '1', 'Motor', '1901-000001', '2019-06-26', '2019-06-26', '2019-12-25', 'Archived', 'New', '250.00', null, '50.00', '25.00', '2.00', null, '3', '2019-06-26 12:16:42', '1', '2019-06-26 17:08:02', '1');
INSERT INTO `ina_policies` VALUES ('3', '1', '1', '1', '8', '1', 'Motor', '1901-000001', '2019-06-26', '2019-06-30', '2019-12-25', 'Archived', 'Cancellation', '-100.00', '0.00', '-5.00', '0.00', '0.00', '1', null, null, null, '2019-06-26 17:08:02', '1');
INSERT INTO `ina_policies` VALUES ('4', '1', '1', '1', '8', '4', 'Motor', '1901-000002', '2019-06-28', '2019-06-28', '2020-06-27', 'Archived', 'New', '250.00', null, '50.00', '25.00', '2.00', null, '5', '2019-06-28 13:48:35', '1', '2019-06-28 15:05:21', '1');
INSERT INTO `ina_policies` VALUES ('5', '1', '1', '1', '8', '4', 'Motor', '1901-000002', '2019-06-28', '2019-06-29', '2020-06-27', 'Archived', 'Cancellation', '-100.00', '0.00', '0.00', '0.00', '0.00', '4', null, null, null, '2019-06-28 15:05:20', '1');
INSERT INTO `ina_policies` VALUES ('6', '1', '1', '1', '1', '6', 'Fire', '1712-000001', '2019-06-28', '2019-06-28', '2020-06-27', 'Active', 'New', '250.00', null, '50.00', '50.00', '2.00', null, null, '2019-06-28 16:30:19', '1', '2019-06-28 16:35:11', '1');

-- ----------------------------
-- Table structure for ina_policy_installments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_installments`;
CREATE TABLE `ina_policy_installments` (
  `inapi_policy_installments_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapi_policy_ID` int(8) DEFAULT NULL,
  `inapi_installment_type` varchar(12) DEFAULT NULL,
  `inapi_paid_status` varchar(8) DEFAULT NULL COMMENT 'UnPaid\r\nPaid\r\nPartial\r\nAlert (when total installments commission is not equal with policy commission)\r\n',
  `inapi_insert_date` date DEFAULT NULL,
  `inapi_document_date` date DEFAULT NULL,
  `inapi_last_payment_date` date DEFAULT NULL,
  `inapi_amount` decimal(10,2) DEFAULT NULL,
  `inapi_paid_amount` decimal(10,2) DEFAULT NULL,
  `inapi_commission_amount` decimal(10,2) DEFAULT NULL,
  `inapi_paid_commission_amount` decimal(10,2) DEFAULT '0.00',
  `inapi_created_date_time` datetime DEFAULT NULL,
  `inapi_created_by` int(8) DEFAULT NULL,
  `inapi_last_update_date_time` datetime DEFAULT NULL,
  `inapi_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapi_policy_installments_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_installments
-- ----------------------------
INSERT INTO `ina_policy_installments` VALUES ('5', '1', 'Recursive', 'Paid', '2019-06-26', '2019-06-26', null, '92.34', '92.34', '16.68', '16.68', '2019-06-26 12:17:32', '1', '2019-06-26 12:18:17', '1');
INSERT INTO `ina_policy_installments` VALUES ('6', '1', 'Recursive', 'Paid', '2019-06-26', '2019-07-26', null, '57.66', '57.66', '10.40', '10.40', '2019-06-26 12:17:33', '1', '2019-06-26 17:08:02', '1');
INSERT INTO `ina_policy_installments` VALUES ('7', '1', 'Recursive', 'Paid', '2019-06-26', '2019-08-26', null, '27.00', '0.00', '17.92', '0.00', '2019-06-26 12:17:33', '1', '2019-06-26 17:08:02', '1');
INSERT INTO `ina_policy_installments` VALUES ('8', '4', 'Recursive', 'Paid', '2019-06-28', '2019-06-28', null, '92.34', '92.34', '16.68', '16.68', '2019-06-28 14:00:07', '1', '2019-06-28 14:00:46', '1');
INSERT INTO `ina_policy_installments` VALUES ('9', '4', 'Recursive', 'Paid', '2019-06-28', '2019-07-28', null, '57.66', '57.66', '10.40', '10.40', '2019-06-28 14:00:07', '1', '2019-06-28 15:05:20', '1');
INSERT INTO `ina_policy_installments` VALUES ('10', '4', 'Recursive', 'Paid', '2019-06-28', '2019-08-28', null, '27.00', '27.00', '22.92', '22.92', '2019-06-28 14:00:07', '1', '2019-06-28 16:24:20', '1');
INSERT INTO `ina_policy_installments` VALUES ('14', '6', 'Recursive', 'UnPaid', '2019-06-28', '2019-06-28', null, '100.68', '0.00', '16.68', '0.00', '2019-06-28 16:35:01', '1', '2019-06-28 16:35:02', '1');
INSERT INTO `ina_policy_installments` VALUES ('15', '6', 'Recursive', 'UnPaid', '2019-06-28', '2019-07-28', null, '100.66', '0.00', '16.66', '0.00', '2019-06-28 16:35:02', '1', '2019-06-28 16:35:02', '1');
INSERT INTO `ina_policy_installments` VALUES ('16', '6', 'Recursive', 'UnPaid', '2019-06-28', '2019-08-28', null, '100.66', '0.00', '16.66', '0.00', '2019-06-28 16:35:02', '1', '2019-06-28 16:35:02', '1');

-- ----------------------------
-- Table structure for ina_policy_items
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_items`;
CREATE TABLE `ina_policy_items` (
  `inapit_policy_item_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapit_policy_ID` int(8) DEFAULT NULL,
  `inapit_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_vh_registration` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_vh_body_type_code_ID` int(8) DEFAULT NULL,
  `inapit_vh_cubic_capacity` int(8) DEFAULT NULL,
  `inapit_vh_make_code_ID` int(8) DEFAULT NULL,
  `inapit_vh_manufacture_year` int(6) DEFAULT NULL,
  `inapit_vh_model` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_vh_passengers` int(3) DEFAULT NULL,
  `inapit_vh_color_code_ID` int(8) DEFAULT NULL,
  `inapit_rl_address_1` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_rl_address_2` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_rl_address_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_rl_postal_code` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `inapit_rl_city_code_ID` int(8) DEFAULT NULL,
  `inapit_rl_construction_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `inapit_insured_amount` decimal(10,2) DEFAULT NULL,
  `inapit_excess` decimal(10,2) DEFAULT NULL,
  `inapit_premium` decimal(10,2) DEFAULT NULL,
  `inapit_mif` decimal(10,2) DEFAULT NULL,
  `inapit_created_date_time` datetime DEFAULT NULL,
  `inapit_created_by` int(8) DEFAULT NULL,
  `inapit_last_update_date_time` datetime DEFAULT NULL,
  `inapit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapit_policy_item_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policy_items
-- ----------------------------
INSERT INTO `ina_policy_items` VALUES ('1', '1', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '5000.00', '500.00', '250.00', null, '2019-06-26 12:17:09', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('2', '4', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '5000.00', '500.00', '250.00', null, '2019-06-28 13:48:52', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('3', '6', 'RiskLocation', null, null, null, null, null, null, null, null, 'Larnaka', 'apt101', '35', '7000', '8', 'Apartment', '5000.00', '500.00', '250.00', null, '2019-06-28 16:30:43', '1', null, null);

-- ----------------------------
-- Table structure for ina_policy_payments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments`;
CREATE TABLE `ina_policy_payments` (
  `inapp_policy_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapp_policy_ID` int(8) DEFAULT NULL,
  `inapp_customer_ID` int(8) DEFAULT NULL,
  `inapp_status` varchar(12) DEFAULT NULL COMMENT 'Outstanding\r\nApplied\r\nPosted\r\nIncomplete',
  `inapp_payment_date` date DEFAULT NULL,
  `inapp_amount` decimal(10,2) DEFAULT NULL,
  `inapp_commission_amount` decimal(10,2) DEFAULT NULL,
  `inapp_allocated_amount` decimal(10,2) DEFAULT NULL,
  `inapp_allocated_commission` decimal(10,2) DEFAULT NULL,
  `inapp_locked` int(1) DEFAULT '0',
  `inapp_created_date_time` datetime DEFAULT NULL,
  `inapp_created_by` int(8) DEFAULT NULL,
  `inapp_last_update_date_time` datetime DEFAULT NULL,
  `inapp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapp_policy_payment_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments
-- ----------------------------
INSERT INTO `ina_policy_payments` VALUES ('1', '1', '8', 'Applied', '2019-06-26', '150.00', null, '150.00', '27.08', '1', '2019-06-26 12:18:14', '1', '2019-06-26 12:18:17', '1');
INSERT INTO `ina_policy_payments` VALUES ('2', '4', '8', 'Applied', '2019-06-28', '150.00', null, '150.00', '27.08', '1', '2019-06-28 14:00:39', '1', '2019-06-28 15:05:20', '1');
INSERT INTO `ina_policy_payments` VALUES ('3', '1', '8', 'Outstanding', '2019-06-28', '27.00', null, null, null, '0', '2019-06-28 16:09:28', '1', null, null);
INSERT INTO `ina_policy_payments` VALUES ('4', '4', '8', 'Applied', '2019-06-28', '27.00', null, '27.00', '22.92', '0', '2019-06-28 16:24:12', '1', '2019-06-28 16:24:21', '1');

-- ----------------------------
-- Table structure for ina_policy_payments_lines
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments_lines`;
CREATE TABLE `ina_policy_payments_lines` (
  `inappl_policy_payments_line_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inappl_policy_payment_ID` int(8) DEFAULT NULL,
  `inappl_policy_installment_ID` int(8) DEFAULT NULL,
  `inappl_previous_paid_amount` decimal(10,2) DEFAULT NULL,
  `inappl_new_paid_amount` decimal(10,2) DEFAULT NULL,
  `inappl_previous_commission_paid_amount` decimal(10,2) DEFAULT NULL,
  `inappl_new_commission_paid_amount` decimal(10,2) DEFAULT NULL,
  `inappl_previous_paid_status` varchar(12) DEFAULT NULL,
  `inappl_new_paid_status` varchar(12) DEFAULT NULL,
  `inappl_created_date_time` datetime DEFAULT NULL,
  `inappl_created_by` int(8) DEFAULT NULL,
  `inappl_last_update_date_time` datetime DEFAULT NULL,
  `inappl_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inappl_policy_payments_line_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments_lines
-- ----------------------------
INSERT INTO `ina_policy_payments_lines` VALUES ('1', '1', '5', '0.00', '92.34', '0.00', '16.68', 'UnPaid', 'Paid', '2019-06-26 12:18:17', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('2', '1', '6', '0.00', '57.66', '0.00', '10.40', 'UnPaid', 'Partial', '2019-06-26 12:18:17', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('3', '2', '8', '0.00', '92.34', '0.00', '16.68', 'UnPaid', 'Paid', '2019-06-28 14:00:46', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('4', '2', '9', '0.00', '57.66', '0.00', '10.40', 'UnPaid', 'Partial', '2019-06-28 14:00:46', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('5', '4', '10', '0.00', '27.00', '0.00', '22.92', 'UnPaid', 'Paid', '2019-06-28 16:24:21', '1', null, null);

-- ----------------------------
-- Table structure for ina_policy_types
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_types`;
CREATE TABLE `ina_policy_types` (
  `inapot_policy_type_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapot_code` varchar(20) DEFAULT NULL,
  `inapot_status` varchar(10) DEFAULT NULL,
  `inapot_name` varchar(20) DEFAULT NULL,
  `inapot_description` varchar(100) DEFAULT NULL,
  `inapot_input_data_type` varchar(30) DEFAULT NULL,
  `inapot_created_date_time` datetime DEFAULT NULL,
  `inapot_created_by` int(8) DEFAULT NULL,
  `inapot_last_update_date_time` datetime DEFAULT NULL,
  `inapot_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapot_policy_type_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_types
-- ----------------------------
INSERT INTO `ina_policy_types` VALUES ('1', 'Motor', 'Active', 'Motor', 'Motor', 'Vehicles', '2019-02-16 11:13:35', '1', '2019-02-16 11:13:35', '1');
INSERT INTO `ina_policy_types` VALUES ('2', 'Fire', 'Active', 'Fire', 'Fire', 'RiskLocation', '2019-02-11 00:58:23', '1', null, null);
INSERT INTO `ina_policy_types` VALUES ('3', 'EL', 'Active', 'Employers Liability', 'Employers Liability', 'Member', '2019-02-16 10:59:12', '1', null, null);
INSERT INTO `ina_policy_types` VALUES ('4', 'PL', 'Active', 'Public Liability', 'Public Liability', 'Member', '2019-02-16 10:59:26', '1', null, null);
INSERT INTO `ina_policy_types` VALUES ('5', 'PA', 'Active', 'Personal Accident', 'Personal Accident', 'Member', '2019-02-16 10:59:42', '1', null, null);
INSERT INTO `ina_policy_types` VALUES ('6', 'CAR', 'Active', 'Contructors All Risk', 'Contructors All Risk', 'RiskLocation', '2019-02-16 11:00:20', '1', null, null);
INSERT INTO `ina_policy_types` VALUES ('7', 'Medical', 'Active', 'Medical', 'Medical', 'Member', '2019-02-16 11:00:33', '1', null, null);

-- ----------------------------
-- Table structure for ina_underwriters
-- ----------------------------
DROP TABLE IF EXISTS `ina_underwriters`;
CREATE TABLE `ina_underwriters` (
  `inaund_underwriter_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaund_user_ID` int(8) DEFAULT NULL,
  `inaund_status` varchar(8) DEFAULT NULL,
  `inaund_use_motor` int(1) DEFAULT NULL,
  `inaund_use_fire` int(1) DEFAULT NULL,
  `inaund_use_pa` int(1) DEFAULT NULL,
  `inaund_use_el` int(1) DEFAULT NULL,
  `inaund_use_pi` int(1) DEFAULT NULL,
  `inaund_use_pl` int(1) DEFAULT NULL,
  `inaund_use_medical` int(1) DEFAULT NULL,
  `inaund_vertical_level` int(2) DEFAULT '0',
  `inaund_created_date_time` datetime DEFAULT NULL,
  `inaund_created_by` int(8) DEFAULT NULL,
  `inaund_last_update_date_time` datetime DEFAULT NULL,
  `inaund_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inaund_underwriter_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_underwriters
-- ----------------------------
INSERT INTO `ina_underwriters` VALUES ('1', '1', 'Active', '1', '1', '1', '1', '1', '1', '1', '0', null, null, '2019-06-24 13:08:35', '1');
INSERT INTO `ina_underwriters` VALUES ('2', '2', 'Active', '1', '1', '1', '1', '1', '1', '1', '0', null, null, '2019-06-21 11:46:23', '1');
INSERT INTO `ina_underwriters` VALUES ('4', '3', 'Active', '1', '1', '1', '1', '1', '1', '1', '1', null, null, '2019-06-21 11:46:39', '1');
INSERT INTO `ina_underwriters` VALUES ('5', '4', 'Active', '1', '1', '1', '1', '1', '1', '1', '2', '2019-06-21 11:46:59', '1', null, null);

-- ----------------------------
-- Table structure for ina_underwriter_companies
-- ----------------------------
DROP TABLE IF EXISTS `ina_underwriter_companies`;
CREATE TABLE `ina_underwriter_companies` (
  `inaunc_underwriter_company_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaunc_underwriter_ID` int(8) DEFAULT NULL,
  `inaunc_insurance_company_ID` int(8) DEFAULT NULL,
  `inaunc_status` varchar(8) DEFAULT NULL,
  `inaunc_created_date_time` datetime DEFAULT NULL,
  `inaunc_created_by` int(8) DEFAULT NULL,
  `inaunc_last_update_date_time` datetime DEFAULT NULL,
  `inaunc_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inaunc_underwriter_company_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_underwriter_companies
-- ----------------------------
INSERT INTO `ina_underwriter_companies` VALUES ('1', '1', '1', 'Active', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('2', '1', '3', 'Active', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('3', '1', '4', 'Active', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('4', '1', '25', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('5', '1', '5', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('6', '1', '6', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('7', '1', '7', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('8', '1', '8', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('9', '1', '9', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('10', '1', '10', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('11', '1', '11', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('12', '1', '12', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('13', '1', '13', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('14', '1', '14', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('15', '1', '15', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('16', '1', '16', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('17', '1', '17', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('18', '1', '18', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('19', '1', '19', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('20', '1', '20', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('21', '1', '21', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('22', '1', '22', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('23', '1', '23', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('24', '1', '24', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('25', '2', '1', 'Active', null, null, '2019-06-21 11:46:23', '1');
INSERT INTO `ina_underwriter_companies` VALUES ('26', '2', '3', 'Active', null, null, '2019-06-21 11:46:23', '1');
INSERT INTO `ina_underwriter_companies` VALUES ('27', '2', '4', 'Active', null, null, '2019-06-21 11:46:23', '1');
INSERT INTO `ina_underwriter_companies` VALUES ('28', '2', '25', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('29', '2', '5', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('30', '2', '6', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('31', '2', '7', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('32', '2', '8', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('33', '2', '9', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('34', '2', '10', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('35', '2', '11', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('36', '2', '12', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('37', '2', '13', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('38', '2', '14', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('39', '2', '15', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('40', '2', '16', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('41', '2', '17', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('42', '2', '18', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('43', '2', '19', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('44', '2', '20', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('45', '2', '21', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('46', '2', '22', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('47', '2', '23', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('48', '2', '24', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('49', '4', '1', 'Active', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('50', '4', '3', 'Active', null, null, '2019-06-21 11:46:39', '1');
INSERT INTO `ina_underwriter_companies` VALUES ('51', '4', '4', 'Active', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('52', '4', '25', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('53', '4', '5', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('54', '4', '6', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('55', '4', '7', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('56', '4', '8', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('57', '4', '9', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('58', '4', '10', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('59', '4', '11', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('60', '4', '12', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('61', '4', '13', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('62', '4', '14', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('63', '4', '15', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('64', '4', '16', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('65', '4', '17', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('66', '4', '18', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('67', '4', '19', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('68', '4', '20', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('69', '4', '21', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('70', '4', '22', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('71', '4', '23', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('72', '4', '24', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('73', '5', '1', 'Active', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('74', '5', '3', 'Active', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('75', '5', '4', 'Active', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('76', '5', '25', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('77', '5', '5', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('78', '5', '6', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('79', '5', '7', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('80', '5', '8', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('81', '5', '9', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('82', '5', '10', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('83', '5', '11', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('84', '5', '12', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('85', '5', '13', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('86', '5', '14', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('87', '5', '15', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('88', '5', '16', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('89', '5', '17', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('90', '5', '18', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('91', '5', '19', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('92', '5', '20', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('93', '5', '21', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('94', '5', '22', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('95', '5', '23', 'Inactive', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('96', '5', '24', 'Inactive', '2019-06-21 11:46:59', '1', null, null);

-- ----------------------------
-- Table structure for ip_locations
-- ----------------------------
DROP TABLE IF EXISTS `ip_locations`;
CREATE TABLE `ip_locations` (
  `ipl_ip_location_serial` int(10) NOT NULL AUTO_INCREMENT,
  `ipl_ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_hostname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_city` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_region` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_country` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_location` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_provider` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ipl_last_check` datetime DEFAULT NULL,
  PRIMARY KEY (`ipl_ip_location_serial`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ip_locations
-- ----------------------------
INSERT INTO `ip_locations` VALUES ('1', '::1', '', '', '', '', '', '', '2019-06-24 13:07:13');
INSERT INTO `ip_locations` VALUES ('2', '127.0.0.1', '', '', '', '', '', '', '2019-06-03 09:22:09');


-- ----------------------------
-- Table structure for log_file
-- ----------------------------
DROP TABLE IF EXISTS `log_file`;
CREATE TABLE `log_file` (
  `lgf_log_file_ID` int(10) NOT NULL AUTO_INCREMENT,
  `lgf_user_ID` int(10) DEFAULT NULL,
  `lgf_ip` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `lgf_date_time` datetime DEFAULT NULL,
  `lgf_table_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `lgf_row_serial` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `lgf_action` text CHARACTER SET utf8,
  `lgf_new_values` text COLLATE utf8_bin,
  `lgf_old_values` text COLLATE utf8_bin,
  `lgf_description` text COLLATE utf8_bin,
  PRIMARY KEY (`lgf_log_file_ID`),
  KEY `lgf_user_ID` (`lgf_user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6715 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- ----------------------------
-- Table structure for parameters
-- ----------------------------
DROP TABLE IF EXISTS `parameters`;
CREATE TABLE `parameters` (
  `prm_parametrs_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prm_agreements_last_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`prm_parametrs_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of parameters
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `prm_permissions_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prm_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prm_filename` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `prm_type` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
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
  `prm_extra_name_1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prm_extra_name_2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prm_extra_name_3` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prm_extra_name_4` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prm_extra_name_5` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`prm_permissions_ID`),
  UNIQUE KEY `primary_serial` (`prm_permissions_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'Users', 'users/users.php', 'menu', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('2', 'Users Folder', 'users', 'folder', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('3', 'Permissions', 'users/permissions.php', 'file', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('4', 'Permissions Modify', 'users/permissions_modify.php', 'file', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('5', 'Permissions Delete', 'users/permissions_delete.php', 'file', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('6', 'Groups', 'users/groups.php', 'file', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('7', 'Groups Modify', 'users/groups_modify.php', 'file', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('8', 'Groups Delete', 'users/groups_delete.php', 'file', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `permissions` VALUES ('9', 'Agreements', 'agreements', 'folder', '0', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', 'StatusChange', '', '', '', '');

-- ----------------------------
-- Table structure for permissions_lines
-- ----------------------------
DROP TABLE IF EXISTS `permissions_lines`;
CREATE TABLE `permissions_lines` (
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of permissions_lines
-- ----------------------------
INSERT INTO `permissions_lines` VALUES ('1', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('2', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('3', '2', '6', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('4', '1', '6', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('5', '3', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('6', '4', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('7', '5', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('8', '6', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('9', '7', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('10', '8', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('11', '3', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('12', '4', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('13', '5', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('14', '6', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('15', '7', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('16', '8', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('17', '2', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('18', '1', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('19', '3', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('20', '4', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('21', '5', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('22', '6', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('23', '7', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('24', '8', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('25', '2', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('26', '1', '214', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('27', '9', '2', '1', '1', '1', '1', '1', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('28', '3', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('29', '4', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('30', '5', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('31', '6', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('32', '7', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('33', '8', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('34', '2', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('35', '9', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('36', '1', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('37', '9', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('38', '3', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('39', '4', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('40', '5', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('41', '6', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('42', '7', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('43', '8', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('44', '2', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('45', '9', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions_lines` VALUES ('46', '1', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for process_lock
-- ----------------------------
DROP TABLE IF EXISTS `process_lock`;
CREATE TABLE `process_lock` (
  `pl_process_lock_ID` int(8) NOT NULL AUTO_INCREMENT,
  `pl_description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `pl_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pl_user_serial` int(8) DEFAULT NULL,
  `pl_active` int(1) DEFAULT NULL,
  `pl_start_timestamp` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `pl_end_timestamp` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pl_process_lock_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of process_lock
-- ----------------------------


-- ----------------------------
-- Table structure for send_auto_emails
-- ----------------------------
DROP TABLE IF EXISTS `send_auto_emails`;
CREATE TABLE `send_auto_emails` (
  `sae_send_auto_emails_serial` int(10) NOT NULL AUTO_INCREMENT,
  `sae_user_ID` int(8) DEFAULT NULL,
  `sae_active` varchar(1) CHARACTER SET utf8 DEFAULT NULL COMMENT 'A -> Active',
  `sae_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `sae_send_result` int(3) DEFAULT NULL,
  `sae_send_datetime` datetime DEFAULT NULL,
  `sae_primary_serial` int(10) DEFAULT NULL,
  `sae_primary_label` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_secondary_serial` int(10) DEFAULT NULL,
  `sae_secondary_label` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_label1` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_label1_info` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `sae_label2` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_label2_info` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_to` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_to_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_from` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_from_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_subject` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_reply_to` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_reply_to_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_cc` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_bcc` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_body` text CHARACTER SET utf8,
  `sae_attachment_files` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sae_send_result_description` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `sae_created_date_time` datetime DEFAULT NULL,
  `sae_created_by` int(8) DEFAULT NULL,
  `sae_last_update_date_time` datetime DEFAULT NULL,
  `sae_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`sae_send_auto_emails_serial`),
  UNIQUE KEY `unique_serial` (`sae_send_auto_emails_serial`),
  KEY `send_result` (`sae_send_result`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `stg_settings_ID` int(10) NOT NULL AUTO_INCREMENT,
  `stg_section` varchar(50) CHARACTER SET utf8 NOT NULL,
  `stg_value` varchar(250) CHARACTER SET utf8 NOT NULL,
  `stg_value_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `stg_fetch_on_startup` int(1) DEFAULT '0',
  PRIMARY KEY (`stg_settings_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'admin_default_layout', 'insurance', '2019-06-13 16:08:08', '0');
INSERT INTO `settings` VALUES ('2', 'user_levels_extra_1_name', 'Agents No Group Option', '2018-04-18 12:41:59', '0');
INSERT INTO `settings` VALUES ('3', 'user_levels_extra_2_name', 'User 2', '2018-04-12 12:55:31', '0');
INSERT INTO `settings` VALUES ('4', 'user_levels_extra_3_name', 'User 3', '2018-04-12 12:55:34', '0');
INSERT INTO `settings` VALUES ('5', 'user_levels_extra_4_name', 'User 4', '2018-04-12 12:55:36', '0');
INSERT INTO `settings` VALUES ('6', 'user_levels_extra_5_name', 'User 5', '2018-04-12 12:55:38', '0');
INSERT INTO `settings` VALUES ('7', 'user_levels_extra_6_name', 'User 6', '2018-04-12 12:55:41', '0');
INSERT INTO `settings` VALUES ('8', 'stk_active_month', '8', '2018-08-21 13:43:27', '0');
INSERT INTO `settings` VALUES ('9', 'stk_active_year', '2018', null, '0');
INSERT INTO `settings` VALUES ('10', 'agr_agreement_number_prefix', 'AGR-', '2019-01-14 22:01:57', '1');
INSERT INTO `settings` VALUES ('11', 'agr_agreement_number_last_used', '81', '2019-03-07 13:59:40', '0');
INSERT INTO `settings` VALUES ('12', 'agr_agreement_number_leading_zeros', '6', '2018-09-21 18:05:59', '0');
INSERT INTO `settings` VALUES ('13', 'agr_agreement_status_on_insert', 'Pending', '2018-11-14 15:00:00', '0');
INSERT INTO `settings` VALUES ('14', 'layout_show_footer_stats', 'No', '2019-04-24 09:10:30', '1');
INSERT INTO `settings` VALUES ('15', 'tck_ticket_number_prefix', 'TCK-', null, '0');
INSERT INTO `settings` VALUES ('16', 'tck_ticket_number_leading_zeros', '6', null, '0');
INSERT INTO `settings` VALUES ('17', 'tck_ticket_number_last_used', '10', '2019-03-07 13:52:05', '0');
INSERT INTO `settings` VALUES ('18', 'sch_schedule_number_prefix', 'SCH-', null, '0');
INSERT INTO `settings` VALUES ('19', 'sch_schedule_number_leading_zeros', '6', null, '0');
INSERT INTO `settings` VALUES ('20', 'sch_schedule_number_last_used', '12', '2019-01-04 18:52:35', '0');
INSERT INTO `settings` VALUES ('21', 'stk_stock_enable', '1', '2019-01-16 15:22:14', '1');
INSERT INTO `settings` VALUES ('22', 'cst_customer_per_user', 'perUser', '2019-01-14 22:03:27', '1');
INSERT INTO `settings` VALUES ('23', 'cst_admin_customers', 'viewAll', '2019-01-16 15:27:05', '1');
INSERT INTO `settings` VALUES ('24', 'admin_imitate_user', 'No', '2019-04-24 09:11:36', '1');
INSERT INTO `settings` VALUES ('25', 'ina_enable_agent_insurance', '1', '2019-01-16 15:23:06', '1');
INSERT INTO `settings` VALUES ('26', 'accounts', 'basic', '2019-02-10 10:35:06', '1');
INSERT INTO `settings` VALUES ('27', 'vit_gbp_rate', '1.2', null, '0');
INSERT INTO `settings` VALUES ('28', 'vit_bottle_cost_small', '1.2', null, '0');
INSERT INTO `settings` VALUES ('29', 'vit_bottle_cost_large', '1.2', null, '0');
INSERT INTO `settings` VALUES ('30', 'vit_courier_cost_per_pill', '0.009', null, '0');
INSERT INTO `settings` VALUES ('31', 'user_max_user_accounts', 'MXpUNURxd0M0UmJVTkNZYW82QUphQT09OjrVPptFZlC4D3TLQANp__KX', null, '0');


-- ----------------------------
-- Table structure for unique_serials
-- ----------------------------
DROP TABLE IF EXISTS `unique_serials`;
CREATE TABLE `unique_serials` (
  `uqs_unique_serial_ID` int(8) NOT NULL AUTO_INCREMENT,
  `uqs_product_ID` int(8) DEFAULT NULL,
  `uqs_agreement_ID` int(8) DEFAULT NULL,
  `uqs_line_number` int(8) DEFAULT NULL,
  `uqs_agreement_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `uqs_unique_serial` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `uqs_status` varchar(12) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Active,\r\nInActive\r\n',
  `uqs_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `uqs_created_by` int(8) DEFAULT NULL,
  `uqs_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `uqs_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`uqs_unique_serial_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of unique_serials
-- ----------------------------
INSERT INTO `unique_serials` VALUES ('9', '1', '11', '1', 'AGR-000074', '11111', 'Deleted', '2018-10-17 21:41:51', '1', '2018-10-17 21:41:51', '1');
INSERT INTO `unique_serials` VALUES ('10', '1', '11', '2', 'AGR-000074', '22222', 'Deleted', '2018-10-17 21:42:57', '1', '2018-10-17 21:42:57', '1');
INSERT INTO `unique_serials` VALUES ('11', '3', '11', '3', 'AGR-000074', '33333', 'Active', '2018-10-17 21:36:37', '1', null, null);
INSERT INTO `unique_serials` VALUES ('15', '1', '14', '4', 'AGR-000074', '11111', 'Active', '2018-10-17 23:57:13', '1', null, null);
INSERT INTO `unique_serials` VALUES ('16', '1', '15', '1', 'AGR-000075', '112233', 'Active', '2018-10-19 12:54:09', '1', null, null);
INSERT INTO `unique_serials` VALUES ('17', '3', '15', '2', 'AGR-000075', '555555', 'Deleted', '2018-11-05 13:16:25', '1', '2018-11-05 13:16:25', '1');
INSERT INTO `unique_serials` VALUES ('18', '3', '17', '1', 'AGR-000076', '258258', 'Active', '2018-11-29 22:35:29', '1', null, null);
INSERT INTO `unique_serials` VALUES ('19', '1', '18', '1', 'AGR-000077', '123123', 'Active', '2018-12-12 16:06:19', '1', null, null);
INSERT INTO `unique_serials` VALUES ('20', '1', '19', '1', 'AGR-000078', '12345555555', 'Active', '2019-03-07 13:28:21', '1', null, null);
INSERT INTO `unique_serials` VALUES ('21', '1', '20', '1', 'AGR-000079', '212121212121', 'Active', '2019-03-07 13:32:34', '1', null, null);
INSERT INTO `unique_serials` VALUES ('22', '11', '21', '1', 'AGR-000080', '313543', 'Active', '2019-03-07 13:53:19', '1', null, null);
INSERT INTO `unique_serials` VALUES ('23', '11', '22', '1', 'AGR-000081', '54646546456', 'Active', '2019-03-07 13:59:41', '1', null, null);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `usr_users_ID` int(8) NOT NULL AUTO_INCREMENT,
  `usr_users_groups_ID` int(8) DEFAULT NULL,
  `usr_active` int(1) NOT NULL,
  `usr_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `usr_username` varchar(100) CHARACTER SET utf8 NOT NULL,
  `usr_password` varchar(30) CHARACTER SET utf8 NOT NULL,
  `usr_user_rights` int(2) NOT NULL,
  `usr_restrict_ip` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `usr_email` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `usr_email2` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `usr_emailcc` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `usr_emailbcc` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `usr_tel` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `usr_is_agent` int(1) NOT NULL,
  `usr_agent_code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `usr_agent_level` int(2) NOT NULL,
  `usr_issuing_office_serial` int(10) NOT NULL,
  `usr_description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `usr_signature_gr` text CHARACTER SET utf8,
  `usr_signature_en` text CHARACTER SET utf8,
  `usr_name_gr` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `usr_name_en` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `usr_is_service` int(1) DEFAULT '0',
  `usr_is_delivery` int(1) DEFAULT '0',
  PRIMARY KEY (`usr_users_ID`),
  UNIQUE KEY `primary_serial` (`usr_users_ID`),
  KEY `group_serial` (`usr_users_groups_ID`),
  KEY `issuing` (`usr_issuing_office_serial`),
  KEY `active` (`usr_active`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '1', '1', 'Michael Ermogenous', 'mike', 'mike', '0', 'ALL', 'it@ydrogios.com.cy', '', '', '', '', '0', '1001', '1', '0', 'Michael Ermogenous', 'Μιχάλης Ερμογένους', 'Michael Ermogenous', 'Michael Ermogenous', 'Michael Ermogenous', '1', '1');
INSERT INTO `users` VALUES ('2', '3', '1', 'Agent 1', 'agent1', 'agent1', '3', '', '', '', '', '', '', '0', '', '1', '0', '', '', '', null, null, '0', '0');
INSERT INTO `users` VALUES ('3', '3', '1', 'agent2', 'agent2', 'agent2', '3', '', '', '', '', '', '', '0', '', '10', '0', 'No Group Option', '', '', '', '', '1', '0');
INSERT INTO `users` VALUES ('4', '3', '1', 'agent3', 'agent3', 'agent3', '3', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '1', '1');

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `usg_users_groups_ID` int(10) NOT NULL AUTO_INCREMENT,
  `usg_active` int(1) DEFAULT NULL,
  `usg_group_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `usg_permissions` text CHARACTER SET utf8,
  `usg_restrict_ip` varchar(25) CHARACTER SET utf8 NOT NULL,
  `usg_approvals` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `usg_created_date_time` datetime DEFAULT NULL,
  `usg_created_by` int(8) DEFAULT NULL,
  `usg_last_update_date_time` datetime DEFAULT NULL,
  `usg_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`usg_users_groups_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('1', '1', 'Administrators', null, '%', 'REQUEST', null, null, null, null);
INSERT INTO `users_groups` VALUES ('2', '1', 'Advanced Users', '', '%', 'ANSWER', null, null, null, null);
INSERT INTO `users_groups` VALUES ('3', '1', 'Agents', '', '', 'NO', null, null, null, null);
INSERT INTO `users_groups` VALUES ('4', '1', 'Michael', '', '', 'NO', null, null, null, null);

-- ----------------------------
-- Table structure for user_settings
-- ----------------------------
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE `user_settings` (
  `usrst_user_settings_ID` int(8) NOT NULL AUTO_INCREMENT,
  `usrst_for_user_ID` int(8) NOT NULL DEFAULT '0' COMMENT 'if -1 then default',
  `usrst_section` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `usrst_value` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `usrst_value_date` date DEFAULT NULL,
  `usrst_created_date_time` datetime DEFAULT NULL,
  `usrst_created_by` int(8) DEFAULT NULL,
  `usrst_last_update_date_time` datetime DEFAULT NULL,
  `usrst_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`usrst_user_settings_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of user_settings
-- ----------------------------

-- ----------------------------
-- Table structure for vitamins
-- ----------------------------
DROP TABLE IF EXISTS `vitamins`;
CREATE TABLE `vitamins` (
  `vit_vitamin_ID` int(8) NOT NULL AUTO_INCREMENT,
  `vit_active` int(1) DEFAULT '0',
  `vit_type` varchar(20) COLLATE utf8_bin DEFAULT '0',
  `vit_code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `vit_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `vit_description` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vit_bottle_size` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `vit_cost_quantity` int(6) DEFAULT NULL,
  `vit_cost_wholesale` double DEFAULT NULL,
  `vit_cost_retail` double DEFAULT NULL,
  `vit_quantity` int(3) DEFAULT NULL,
  `vit_super_wholesale` double DEFAULT NULL,
  `vit_wholesale` double DEFAULT NULL,
  `vit_retail` double DEFAULT NULL,
  `vit_retail_one_plus_one` double DEFAULT NULL,
  `vit_market_prices` mediumtext COLLATE utf8_bin,
  `vit_created_date_time` datetime DEFAULT NULL,
  `vit_created_by` int(8) DEFAULT NULL,
  `vit_last_update_date_time` datetime DEFAULT NULL,
  `vit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`vit_vitamin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of vitamins
-- ----------------------------
INSERT INTO `vitamins` VALUES ('1', '1', 'Vitamin', 'Osteoformula', 'Osteoformula', 'Calcium Magnesium  Vit D OsteoFormula', 'Large', '1000', '23.3', '44.99', '90', '8', '9.45', '15', '26', 0x48423A, '2019-05-27 01:06:09', '1', '2019-06-06 23:09:21', '4');
INSERT INTO `vitamins` VALUES ('2', '1', 'Supplement', 'Turmeric', 'Turmeric', 'Turmeric 500mg', 'Small', '500', '24.24', '42.99', '40', '8', '7.27', '12', '20', 0x48423A203630306D67783130303D32342E39352C0D0A48423A203430306D67783130303D31362E3435, '2019-05-28 11:29:34', '1', '2019-06-06 23:25:59', '4');
INSERT INTO `vitamins` VALUES ('3', '1', 'Vitamin', 'Spirulina', 'Spirulina', 'Spirulina 500mg', 'Small', '90', '2.8', '5.99', '40', '6', '6.55', '10', '18', 0x48423A203530306D6720783230303D32372E39350D0A48423A203530306D67207836303D31322E3935, '2019-05-28 11:38:43', '1', '2019-06-06 23:26:08', '4');
INSERT INTO `vitamins` VALUES ('4', '1', 'Vitamin', 'Collagen Marine', 'Collagen Marine', 'Collagen Marine 400mg', 'Small', '360', '12.5', '23.99', '40', '8', '9.09', '15', '25', 0x48423A3730304D477836303D33322E393520287834303D323229, '2019-05-28 11:40:25', '1', '2019-06-06 23:26:18', '4');
INSERT INTO `vitamins` VALUES ('5', '1', 'Vitamin', 'C+', 'Vitamin C+', 'Vitamin C+', 'Large', '360', '7.46', '15.99', '90', '9', '8.36', '14', '23', 0x48423A20313030306D67783132303D31382E393520287839303D31342E323029, '2019-05-28 12:12:00', '1', '2019-06-06 23:26:26', '4');
INSERT INTO `vitamins` VALUES ('6', '1', 'Vitamin', 'Green Coffee', 'Green Coffee', 'Green Coffee 1000mg', 'Small', '60', '2.24', '0', '40', '9', '10.18', '18', '28', 0x4842203430306D67207834323D31342E3935, '2019-05-28 13:03:02', '1', '2019-06-06 23:26:33', '4');
INSERT INTO `vitamins` VALUES ('7', '1', 'Vitamin', 'Macca', 'Macca', 'Macca 500mg', 'Small', '100', '2.8', '0', '90', '10', '10.18', '16', '28', 0x4842203530306D67207836303D31342E39352028783930203D2032322E343329, '2019-05-28 13:03:59', '1', '2019-06-06 23:27:04', '4');
INSERT INTO `vitamins` VALUES ('8', '1', 'Vitamin', 'Vitamin D3', 'Vitamin D3', 'Vitamin D3 125mg 5000IU', 'Small', '1000', '12.32', '0', '120', '9', '10.18', '15', '28', 0x48422032356D672078313030203D2031302E39352028313030304955292028783132303D31332E313429, '2019-05-28 13:05:14', '1', '2019-06-10 20:19:20', '1');
INSERT INTO `vitamins` VALUES ('9', '1', 'Vitamin', 'Siberian Ginseng', 'Siberian Ginseng', 'Siberian Ginseng 1000mg', 'Small', '100', '2.33', '0', '120', '12', '13.09', '19', '36', 0x48423A203530306D6720783130303D32302E39352028783132303D32352E313429, '2019-05-28 13:05:52', '1', '2019-06-06 23:27:17', '4');
INSERT INTO `vitamins` VALUES ('10', '1', 'Supplement', 'Glucosamine & Chodroitine', 'Glucosamine & Chodroitine', 'Glucosamine & Chodroitine', 'Small', '365', '19.04', '0', '40', '10', '10.91', '19.25', '30', 0x48423A207836303D33302E393520287834303D32302E3633290D0A48423A204A6F696E742043617265206869676820737472656E6774682078313230203D2035302E3935, '2019-05-28 13:07:31', '1', '2019-06-06 23:27:26', '4');
INSERT INTO `vitamins` VALUES ('11', '1', 'Vitamin', 'Magnesium', 'Magnesium', 'Magnesium 500mg', 'Small', '1000', '15.57', '0', '40', '5', '5.09', '8', '14', 0x48423A203235306D6720783230303D32332E393520287834303D342E373929, '2019-05-28 13:10:00', '1', '2019-06-06 23:27:34', '4');
INSERT INTO `vitamins` VALUES ('12', '1', 'Supplement', 'Omega 3 Extra', 'Omega 3 Extra', 'Omega 3 Extra 330EPA 220DHA', 'Large', '360', '12.32', '0', '90', '13', '14.55', '25', '40', 0x48423A20466973684F696C20783130303D32302E393520287839303D31382E3836290D0A48423A204578747261207836303D33322E3935202834392E343229, '2019-05-28 13:11:43', '1', '2019-06-06 23:27:41', '4');
INSERT INTO `vitamins` VALUES ('13', '1', 'Supplement', 'Digestive Enzymes', 'Digestive Enzymes', 'Digestive Enzymes', 'Small', '360', '11.31', '0', '60', '9.45', '9.45', '15', '26', 0x48423A204D756C7469207839303D392E343520287836303D362E33290D0A48423A20456E7A796D657320783130303D31382E393520287836303D31312E333729, '2019-05-28 13:16:00', '1', '2019-06-06 23:27:48', '4');
INSERT INTO `vitamins` VALUES ('14', '1', 'Supplement', 'Activated Charcoal', 'Activated Charcoal', 'Activated Charcoal 400mg', 'Small', '120', '3.33', '7.99', '30', '7', '7.27', '12', '20', 0x48423A203236306D672078313030203D20382E373520287833303D322E363329, '2019-05-28 13:17:06', '1', '2019-06-06 23:27:56', '4');
INSERT INTO `vitamins` VALUES ('15', '1', 'Supplement', 'Colon Cleanse/Formula', 'Colon Cleanse', 'Colon Cleanse', 'Small', '60', '2.24', '0', '30', '6', '7.27', '11', '20', 0x48423A2078323430203D2032322E393520287833303D322E383729, '2019-05-28 13:18:15', '1', '2019-06-10 19:52:38', '1');
INSERT INTO `vitamins` VALUES ('16', '1', 'Supplement', 'Probiotic Max', 'Probiotic Max', 'Probiotic Max 6billion', 'Small', '365', '13.06', '0', '40', '7', '7.27', '12', '20', 0x48423A203362696C6C696F6E20783130303D31362E343520287834303D362E353829, '2019-05-28 13:20:50', '1', '2019-06-06 23:28:14', '4');
INSERT INTO `vitamins` VALUES ('17', '1', 'Supplement', 'Apple Cider Vinegar', 'Apple Cider Vinegar', 'Apple Cider Vinegar Complex', 'Large', '84', '3.26', '0', '90', '10', '14.55', '25', '40', 0x48423A506C61696E43696465723330306D67783230303D31322E393520287839303D352E3833290D0A48423A20436F6D706C6578207834303D31322E343520287839303D323829, '2019-05-28 13:33:14', '1', '2019-06-06 23:28:23', '4');
INSERT INTO `vitamins` VALUES ('18', '1', 'Supplement', '5HTP', '5HTP', '5HTP 100mg', 'Small', '365', '16.11', '0', '40', '9', '9.45', '15', '26', 0x48423A2035306D672078313230203D2033382E393520287834303D313329, '2019-05-28 13:39:28', '1', '2019-06-06 23:28:33', '4');
INSERT INTO `vitamins` VALUES ('19', '1', 'Mineral', 'Zinc', 'Zinc', 'Zinc 50mg', 'Small', '1000', '11.2', '17.99', '90', '7', '8.72', '14', '24', 0x48423A2032356D672078313030203D2031312E3935, '2019-05-28 13:43:04', '1', '2019-06-06 23:30:41', '4');
INSERT INTO `vitamins` VALUES ('20', '1', 'Supplement', 'CoEnzyme Q10', 'CoEnzyme Q10', 'CoEnzyme Q10 30mg', 'Small', '120', '4.66', '0', '60', '9', '8', '13', '22', 0x48423A2033306D672078323030203D2033352E393520287836303D31302E373929, '2019-05-28 13:48:25', '1', '2019-06-06 23:28:52', '4');
INSERT INTO `vitamins` VALUES ('21', '1', 'Supplement', 'Cod Liver Oil', 'Cod Liver Oil', 'Cod Liver Oil 1000mg', 'Large', '360', '6.1', '0', '90', '7', '8.73', '14', '24', 0x48423A20313030306D672078313230203D2031332E393520287839303D31302E343629, '2019-05-28 13:50:36', '1', '2019-06-06 23:29:01', '4');
INSERT INTO `vitamins` VALUES ('22', '1', 'Supplement', 'Super Garlic', 'Super Garlic', 'Super Garlic 6000mg', 'Small', '1000', '17.43', '0', '60', '7', '8', '13', '22', 0x48423A20343030306D6720783235303D33382E393520287836303D392E3334290D0A48423A203530306D672078313530203D2032322E3935, '2019-05-28 13:52:40', '1', '2019-06-06 22:32:46', '4');
INSERT INTO `vitamins` VALUES ('23', '1', 'Supplement', 'Gingo Biloba', 'Gingo Biloba', 'Gingo Biloba 120mg', 'Small', '1000', '20', '0', '40', '6', '8', '13', '22', 0x48423A202035306D6720783132303D32302E39350D0A48423A203132306D6720783132303D33342E393520287834303D31312E363529, '2019-05-28 13:56:43', '1', '2019-06-06 22:37:32', '4');
INSERT INTO `vitamins` VALUES ('24', '1', 'Supplement', 'FlaxSeed Oil', 'FlaxSeed Oil', 'FlaxSeed Oil 1000mg', 'Large', '1000', '17.86', '0', '90', '8', '9.45', '15', '26', 0x48423A203530306D67207836303D20392E393520287839303D31342E3933290D0A48423A20313030306D672078313230203D2031382E393520287839303D31342E323129, '2019-05-28 14:02:28', '1', '2019-06-06 23:30:20', '4');
INSERT INTO `vitamins` VALUES ('25', '1', 'Vitamin', 'Vitamin E', 'Vitamin E', 'Vitamin E 100 IU', 'Small', '200', '3.26', '0', '90', '6', '8', '13', '22', 0x48423A203130306975207820323530203D2031342E393520287839303D352E333829, '2019-05-28 14:04:57', '1', '2019-06-06 22:42:10', '4');
INSERT INTO `vitamins` VALUES ('26', '1', 'Supplement', 'Milk Thistle', 'Milk Thistle', 'Milk Thistle 100mg', 'Small', '120', '2.8', '0', '60', '9', '12.36', '20', '34', 0x48423A203130306D6720783330203D2031332E343520287836303D32362E393029, '2019-05-28 14:08:50', '1', '2019-06-06 22:44:51', '4');
INSERT INTO `vitamins` VALUES ('27', '1', 'Supplement', 'Oregano Oil', 'Oregano Oil', 'Oregano Oil 25mg', 'Small', '1000', '21.11', '0', '90', '7.5', '10.18', '16', '28', 0x48423A2032356D6720783930203D2031342E3935, '2019-05-28 14:10:02', '1', '2019-06-06 22:47:20', '4');
INSERT INTO `vitamins` VALUES ('28', '1', 'Mineral', 'Iron', 'Iron', 'Iron', 'Small', '360', '2.91', '0', '90', '6', '8', '12', '22', '', '2019-06-06 23:47:17', '4', '2019-06-10 14:02:59', '1');
INSERT INTO `vitamins` VALUES ('29', '1', 'Vitamin', 'Ginger', 'Ginger', 'Ginger 500mg', 'Small', '90', '2.8', '0', '90', '9', '9.45', '14', '26', '', '2019-06-06 23:48:40', '4', '2019-06-10 19:34:03', '1');
INSERT INTO `vitamins` VALUES ('30', '1', 'Supplement', 'Detox & Cleanse', 'Detox & Cleanse', 'Detox & Cleanse', 'Small', '90', '3.26', '6.99', '40', '8', '10.18', '16', '28', '', '2019-06-06 23:50:53', '4', '2019-06-10 19:36:48', '1');
INSERT INTO `vitamins` VALUES ('31', '1', 'Supplement', 'L-Arginine', 'L-Arginine', 'L-Arginine 500mg', 'Small', '90', '2.8', '0', '40', '5.82', '9.46', '13', '22', '', '2019-06-06 23:51:23', '4', '2019-06-10 19:30:29', '1');
INSERT INTO `vitamins` VALUES ('32', '1', 'Vitamin', 'L-Glutamine', 'L-Glutamine', 'L-Glutamine 500mg', 'Small', '90', '2.8', '0', '40', '9', '10.18', '16', '28', '', '2019-06-06 23:51:48', '4', '2019-06-10 20:21:23', '1');
INSERT INTO `vitamins` VALUES ('33', '1', 'Vitamin', 'Dandelion', 'Dandelion', 'Dandelion', 'Large', '60', '2.33', '0', '90', '10', '11.64', '18', '32', '', '2019-06-06 23:52:23', '4', '2019-06-10 19:40:18', '1');
INSERT INTO `vitamins` VALUES ('34', '1', 'Supplement', 'Glucomannan', 'Glucomannan', 'Glucomannan 500mg', 'Large', '1000', '33.74', '0', '90', '11', '11.64', '18', '32', '', '2019-06-06 23:52:52', '4', '2019-06-10 19:42:58', '1');
INSERT INTO `vitamins` VALUES ('35', '1', 'Vitamin', 'Multi Daily', 'Multi Vitamins Daily', 'Multi Vitamins Daily', 'Small', '360', '7', '0', '40', '6', '8', '12', '22', '', '2019-06-10 14:07:35', '1', '2019-06-10 14:08:09', '1');
