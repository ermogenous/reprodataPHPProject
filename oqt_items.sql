/*
Navicat MySQL Data Transfer

Source Server         : Mysql Local
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : reprodata

Target Server Type    : MYSQL
Target Server Version : 100130
File Encoding         : 65001

Date: 2019-06-03 10:27:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for oqt_items
-- ----------------------------
DROP TABLE IF EXISTS `oqt_items`;
CREATE TABLE `oqt_items` (
  `oqit_items_ID` int(10) NOT NULL AUTO_INCREMENT,
  `oqit_quotations_types_ID` int(11) DEFAULT NULL,
  `oqit_sort` int(5) DEFAULT NULL,
  `oqit_function` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `oqit_name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `oqit_label_gr` text COLLATE utf8_bin,
  `oqit_label_en` text COLLATE utf8_bin,
  `oqit_start_expanded` int(11) DEFAULT NULL,
  `oqit_disable_expansion` int(11) DEFAULT NULL,
  `oqit_insured_amount_1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_3` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_4` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_5` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_6` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_7` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_8` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_9` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_10` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_11` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_12` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_13` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_14` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_insured_amount_15` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_3` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_4` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_5` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_6` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_7` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_8` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_9` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_10` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_11` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_12` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_13` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_14` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_rate_15` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_date_1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_date_2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_date_3` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_date_4` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqit_created_date_time` datetime DEFAULT NULL,
  `oqit_created_by` int(8) DEFAULT NULL,
  `oqit_last_update_date_time` datetime DEFAULT NULL,
  `oqit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`oqit_items_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of oqt_items
-- ----------------------------
INSERT INTO `oqt_items` VALUES ('1', '1', '1', 'mff_insured_details_1', 'Insured Data', 0xCE92CEB1CF83CEB9CEBACEADCF8220CEA0CEBBCEB7CF81CEBFCF86CEBFCF81CEAFCEB5CF8220CE91CF83CF86CEB1CEBBCEB9CEB6CEBFCEBCCEADCEBDCEBFCF85, 0x496E737572656420426173696320496E666F726D6174696F6E, '0', '1', 'Full Name', 'Place of usual business', 'Occupation', 'Passport Number', 'Country', 'Gender', '', '', '', '', '', '', '', '', '', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', '', '', '', '', '', '', '', '', '', 'Date of birth', null, null, null, null, null, '2019-03-14 14:57:16', '1');
INSERT INTO `oqt_items` VALUES ('2', '1', '2', 'mff_insurance_period_2', 'Insurance Period', 0xCEA0CEB5CF81CEAFCEBFCEB4CEBFCF8220CE91CF83CF86CEACCEBBCEB9CF83CEB7CF82, 0x506572696F64206F6620496E737572616E6365, '1', '1', 'Package Plan Selection', 'Employers Liability selection', 'Social Security Number', '', '', '', '', '', '', '', '', '', '', '', '', 'A100||A200||A350', 'A25', 'GET_FROM_FORM', '', '', '', '', '', '', '', '', '', '', '', '', 'Insurance Period Start', 'Insurance Period End', null, null, null, null, '2019-03-26 10:33:37', '1');
INSERT INTO `oqt_items` VALUES ('3', '2', '1', 'mc_shipment_details_3', 'Shipment Details', 0x536869706D656E742044657461696C73, 0x536869706D656E742044657461696C73, '1', '1', 'Type of Shipment', 'Insured Value Currency', 'Insured Value', 'Commodity', 'Coverage Option (not used for later)', 'Conveyance', 'Conveyance - Vessel Name', 'Conveyance - Approved Steamer if not known', 'Packing / Shipment Method', 'Country of Origin', 'Via Country', 'Destination Country', 'Conditions of Insurance', '', '', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', '', '', '', '', '', '', '2019-03-27 11:57:26', '1', '2019-05-27 14:58:09', '1');
INSERT INTO `oqt_items` VALUES ('4', '2', '2', 'mc_cargo_details_4', 'Cargo Information', 0x436172676F20496E666F726D6174696F6E, 0x436172676F20496E666F726D6174696F6E, '1', '1', 'Full Description of Cargo', 'Marks & Numbers', 'Letter of Credit Conditions', 'Notes', 'Supplier', '', '', '', '', '', '', '', '', '', '', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2019-03-28 16:49:28', '1', '2019-04-18 14:40:35', '1');
