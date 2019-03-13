/*
Navicat MySQL Data Transfer

Source Server         : Mysql Local
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : reprodata

Target Server Type    : MYSQL
Target Server Version : 100130
File Encoding         : 65001

Date: 2019-03-07 12:15:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ac_accounts
-- ----------------------------
DROP TABLE IF EXISTS `ac_accounts`;
CREATE TABLE `ac_accounts` (
  `acacc_account_ID` int(11) NOT NULL AUTO_INCREMENT,
  `acacc_active` int(1) DEFAULT NULL,
  `acacc_type` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `acacc_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_balance` double DEFAULT '0',
  `acacc_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_mobile` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_work_tel` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_fax` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_website` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `acacc_created_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `acacc_created_by` int(8) DEFAULT NULL,
  `acacc_last_update_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `acacc_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`acacc_account_ID`),
  UNIQUE KEY `primary_ID` (`acacc_account_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ac_accounts
-- ----------------------------
INSERT INTO `ac_accounts` VALUES ('1', '1', 'Supplier', 'DAN', '0', 'Danniel Jackson', 'Danniel Jackson', '', '', '', '', '', '2019-01-22 14:45:57', '1', '2019-01-22 14:45:57', '1');
INSERT INTO `ac_accounts` VALUES ('2', '1', 'Supplier', 'VS', '0', 'Vape Scent', '', '', '', '', '', '', '2018-04-25 22:39:27', '1', '2018-04-25 22:39:27', '1');
INSERT INTO `ac_accounts` VALUES ('3', '1', 'Supplier', 'APH', '0', 'Aphrodite - Steve Paphos', '', '', '', '', '', '', '2018-04-25 21:43:07', '1', null, null);
INSERT INTO `ac_accounts` VALUES ('4', '1', 'Cash', 'TAMIO', '0', 'TAMIO', '', '', '', '', '', '', '2018-04-25 21:44:10', '1', null, null);
INSERT INTO `ac_accounts` VALUES ('5', '1', 'Bank', 'BOC1', '0', 'Bank of Cyprus Main Account', '', '', '', '', '', '', '2018-04-25 21:44:27', '1', null, null);
INSERT INTO `ac_accounts` VALUES ('6', '1', 'Supplier', 'ME', '0', 'Michael Ermogenous', '', '', '', '', '', '', '2018-04-25 22:46:37', '1', '2018-04-25 21:46:37', '1');
INSERT INTO `ac_accounts` VALUES ('7', '1', 'Customer', 'Cust0', '0', 'Test Customer', '', '', '', '', '', '', '2018-05-15 15:15:23', '1', null, null);

-- ----------------------------
-- Table structure for ac_transactions
-- ----------------------------
DROP TABLE IF EXISTS `ac_transactions`;
CREATE TABLE `ac_transactions` (
  `actrn_transaction_ID` int(11) NOT NULL AUTO_INCREMENT,
  `actrn_transaction_date` date DEFAULT NULL,
  `actrn_type` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `actrn_dr_cr` int(1) DEFAULT NULL COMMENT 'if purchase then -1 sale 1. if its dr or cr the account in transaction',
  `actrn_status` varchar(1) CHARACTER SET latin1 DEFAULT NULL,
  `actrn_account_ID` int(8) DEFAULT NULL,
  PRIMARY KEY (`actrn_transaction_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ac_transactions
-- ----------------------------
INSERT INTO `ac_transactions` VALUES ('1', '2019-01-22', 'Sale', null, null, '7');
INSERT INTO `ac_transactions` VALUES ('2', '2018-06-05', 'Purchase', null, 'O', '2');
INSERT INTO `ac_transactions` VALUES ('3', '0000-00-00', 'Purchase', null, 'O', '2');
INSERT INTO `ac_transactions` VALUES ('4', '2018-06-05', 'Purchase', null, 'O', '2');
INSERT INTO `ac_transactions` VALUES ('5', '2018-06-05', 'Purchase', null, 'O', '2');
INSERT INTO `ac_transactions` VALUES ('6', '0000-00-00', 'Purchase', null, 'O', '2');

-- ----------------------------
-- Table structure for ac_transaction_lines
-- ----------------------------
DROP TABLE IF EXISTS `ac_transaction_lines`;
CREATE TABLE `ac_transaction_lines` (
  `actrl_transaction_line_ID` int(8) NOT NULL AUTO_INCREMENT,
  `actrl_transaction_ID` int(8) DEFAULT NULL,
  `actrl_product_ID` int(8) DEFAULT NULL,
  `actrl_dr_cr` int(1) DEFAULT NULL COMMENT 'if is -1 then credit if 1 then debit.',
  `actrl_quantity` int(8) DEFAULT NULL,
  `actrl_cost_value` double DEFAULT NULL,
  `actrl_value` double DEFAULT NULL,
  `actrl_tax_value` double DEFAULT NULL,
  PRIMARY KEY (`actrl_transaction_line_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ac_transaction_lines
-- ----------------------------
INSERT INTO `ac_transaction_lines` VALUES ('1', '5', '1', '1', '2', '0', '1', '0');
INSERT INTO `ac_transaction_lines` VALUES ('2', '6', '1', '1', '2', '0', '5.25', '0');

-- ----------------------------
-- Table structure for agents
-- ----------------------------
DROP TABLE IF EXISTS `agents`;
CREATE TABLE `agents` (
  `agnt_agent_ID` int(8) NOT NULL AUTO_INCREMENT,
  `agnt_user_ID` int(8) DEFAULT NULL,
  `agnt_basic_account_ID` int(8) DEFAULT NULL,
  `agnt_status` varchar(10) DEFAULT NULL,
  `agnt_code` varchar(20) DEFAULT NULL,
  `agnt_name` varchar(50) DEFAULT NULL,
  `agnt_type` varchar(10) DEFAULT NULL COMMENT 'Issuer/Agent/SubAgent',
  `agnt_enable_commission_release` int(1) DEFAULT NULL,
  `agnt_commission_release_basic_account_ID` int(8) DEFAULT NULL,
  `agnt_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agnt_created_by` int(8) DEFAULT NULL,
  `agnt_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agnt_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`agnt_agent_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agents
-- ----------------------------
INSERT INTO `agents` VALUES ('1', '1', '7', 'Active', 'A1001', 'Michael Ermogenous', 'Agent', '1', '9', '2019-02-15 11:18:43', '1', '2019-02-15 11:18:43', '1');
INSERT INTO `agents` VALUES ('2', '4', '8', 'Active', 'A1002', 'Giorgos', 'Agent', '0', null, '2019-02-15 11:18:39', '1', '2019-02-15 11:18:39', '1');

-- ----------------------------
-- Table structure for agent_commission_types
-- ----------------------------
DROP TABLE IF EXISTS `agent_commission_types`;
CREATE TABLE `agent_commission_types` (
  `agcmt_agent_insurance_type_ID` int(8) NOT NULL AUTO_INCREMENT,
  `agcmt_agent_ID` int(8) DEFAULT NULL,
  `agcmt_insurance_company_ID` int(8) DEFAULT NULL,
  `agcmt_policy_type_ID` int(8) DEFAULT NULL,
  `agcmt_status` varchar(10) DEFAULT NULL,
  `agcmt_commission_amount` double DEFAULT NULL,
  `agcmt_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agcmt_created_by` int(8) DEFAULT NULL,
  `agcmt_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agcmt_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`agcmt_agent_insurance_type_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agent_commission_types
-- ----------------------------
INSERT INTO `agent_commission_types` VALUES ('1', '1', '1', '1', 'Active', '25.05', '2019-02-15 11:09:51', '1', '2019-02-15 11:09:51', '1');
INSERT INTO `agent_commission_types` VALUES ('2', '1', '1', '2', 'Active', '27', '2019-02-15 20:35:22', '1', '2019-02-15 20:35:22', null);
INSERT INTO `agent_commission_types` VALUES ('3', '1', '4', '2', 'Active', '28', '2019-02-15 20:35:35', '1', null, null);
INSERT INTO `agent_commission_types` VALUES ('4', '1', '4', '1', 'Active', '22.5', '2019-02-15 20:35:46', '1', null, null);

-- ----------------------------
-- Table structure for agreements
-- ----------------------------
DROP TABLE IF EXISTS `agreements`;
CREATE TABLE `agreements` (
  `agr_agreement_ID` int(8) NOT NULL AUTO_INCREMENT,
  `agr_customer_ID` int(8) DEFAULT NULL,
  `agr_status` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT 'P - Pending \r\nL - Locked \r\nA - Active \r\nE - Expired \r\nD - Deleted \r\nC - Cancelled \r\nR - Archived',
  `agr_process_status` varchar(12) CHARACTER SET utf8 DEFAULT NULL COMMENT 'New\r\nRenewal\r\nEndorsement',
  `agr_starting_date` date DEFAULT NULL,
  `agr_expiry_date` date DEFAULT NULL,
  `agr_agreement_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `agr_activated_period` int(2) DEFAULT NULL,
  `agr_activated_year` int(4) DEFAULT NULL,
  `agr_activated_by` int(8) DEFAULT NULL,
  `agr_replacing_agreement_ID` int(8) DEFAULT NULL,
  `agr_replaced_by_agreement_ID` int(8) DEFAULT NULL,
  `agr_created_date_time` datetime DEFAULT NULL,
  `agr_created_by` int(8) DEFAULT NULL,
  `agr_last_update_date_time` datetime DEFAULT NULL,
  `agr_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`agr_agreement_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of agreements
-- ----------------------------
INSERT INTO `agreements` VALUES ('11', '1', 'Archived', 'New', '2018-10-17', '2019-10-16', 'AGR-000074', '8', '2018', '1', '0', '12', '2018-10-17 21:36:37', '1', '2018-10-17 21:42:22', '1');
INSERT INTO `agreements` VALUES ('12', '1', 'Archived', 'Renewal', '2019-10-17', '2020-10-16', 'AGR-000074', '8', '2018', '1', '11', '13', '2018-10-17 21:41:33', '1', '2018-10-17 21:43:41', '1');
INSERT INTO `agreements` VALUES ('13', '1', 'Archived', 'Endorsement', '2019-10-17', '2020-10-16', 'AGR-000074', '8', '2018', '1', '12', '14', '2018-10-17 21:42:39', '1', '2018-10-17 23:57:20', '1');
INSERT INTO `agreements` VALUES ('14', '1', 'Active', 'Endorsement', '2019-10-17', '2020-10-16', 'AGR-000074', '8', '2018', '1', '13', '0', '2018-10-17 21:45:26', '1', '2018-10-17 23:57:20', '1');
INSERT INTO `agreements` VALUES ('15', '1', 'Archived', 'New', '2018-10-19', '2019-10-18', 'AGR-000075', '8', '2018', '1', '0', '16', '2018-10-19 12:54:09', '1', '2018-11-05 13:17:46', '1');
INSERT INTO `agreements` VALUES ('16', '1', 'Active', 'Endorsement', '2018-11-05', '2019-10-18', 'AGR-000075', '8', '2018', '1', '15', '0', '2018-11-05 13:15:09', '1', '2018-11-05 13:17:46', '1');
INSERT INTO `agreements` VALUES ('17', '1', 'Active', 'New', '2018-11-29', '2019-11-28', 'AGR-000076', '8', '2018', '1', '0', '0', '2018-11-29 22:35:29', '1', '2018-11-29 22:35:40', '1');
INSERT INTO `agreements` VALUES ('18', '1', 'Pending', 'New', '2018-12-12', '2019-12-11', 'AGR-000077', null, null, null, '0', '0', '2018-12-12 16:06:19', '1', null, null);

-- ----------------------------
-- Table structure for agreement_items
-- ----------------------------
DROP TABLE IF EXISTS `agreement_items`;
CREATE TABLE `agreement_items` (
  `agri_agreement_item_ID` int(8) NOT NULL AUTO_INCREMENT,
  `agri_agreement_ID` int(8) DEFAULT NULL,
  `agri_product_ID` int(8) DEFAULT NULL,
  `agri_status` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `agri_process_status` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `agri_line_number` int(8) DEFAULT NULL,
  `agri_agreement_type` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Rent -> Rental + CPC\r\nCPC -> Charge Per Copy\r\nMin -> Minimum Charge\r\nLabour -> Labour Only (Maintenance)\r\nNO -> No agreement',
  `agri_per_copy_black_cost` double DEFAULT NULL,
  `agri_per_copy_color_cost` double DEFAULT NULL,
  `agri_rent_cost` double DEFAULT NULL,
  `agri_add_remove_stock` int(1) DEFAULT '0',
  `agri_location` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `agri_created_date_time` datetime DEFAULT NULL,
  `agri_created_by` int(8) DEFAULT NULL,
  `agri_last_update_date_time` datetime DEFAULT NULL,
  `agri_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`agri_agreement_item_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of agreement_items
-- ----------------------------
INSERT INTO `agreement_items` VALUES ('22', '11', '1', 'Active', 'New', '1', 'Rent', '1', '11', '1', '-1', null, '2018-10-17 21:36:37', '1', null, null);
INSERT INTO `agreement_items` VALUES ('23', '11', '1', 'Active', 'New', '2', 'CPC', '2', '2', '2', '-1', null, '2018-10-17 21:36:37', '1', null, null);
INSERT INTO `agreement_items` VALUES ('24', '11', '3', 'Active', 'New', '3', 'Labour', '3', '3', '3', '-1', null, '2018-10-17 21:36:37', '1', null, null);
INSERT INTO `agreement_items` VALUES ('25', '12', '1', 'Deleted', 'Renewal', '1', 'Rent', '1', '11', '1', '1', null, '2018-10-17 21:41:33', '1', '2018-10-17 21:41:51', '1');
INSERT INTO `agreement_items` VALUES ('26', '12', '1', 'Active', 'Renewal', '2', 'CPC', '2', '2', '2', '0', null, '2018-10-17 21:41:33', '1', null, null);
INSERT INTO `agreement_items` VALUES ('27', '12', '3', 'Active', 'Renewal', '3', 'Labour', '3', '3', '3', '0', null, '2018-10-17 21:41:33', '1', null, null);
INSERT INTO `agreement_items` VALUES ('28', '13', '1', 'Deleted', 'Endorsement', '2', 'CPC', '2', '2', '2', '1', null, '2018-10-17 21:42:39', '1', '2018-10-17 21:42:57', '1');
INSERT INTO `agreement_items` VALUES ('29', '13', '3', 'Active', 'Endorsement', '3', 'Labour', '3', '3', '3', '0', null, '2018-10-17 21:42:39', '1', null, null);
INSERT INTO `agreement_items` VALUES ('30', '14', '3', 'Active', 'Endorsement', '3', 'Labour', '3', '3', '3', '0', null, '2018-10-17 21:45:26', '1', null, null);
INSERT INTO `agreement_items` VALUES ('37', '14', '1', 'Active', 'New', '4', 'No', '1', '1', '1', '-1', null, '2018-10-17 23:57:13', '1', null, null);
INSERT INTO `agreement_items` VALUES ('38', '15', '1', 'Active', 'New', '1', 'CPC', '0', '0', '0', '-1', 'Accountss', '2018-10-19 12:54:09', '1', '2018-11-02 13:02:30', '1');
INSERT INTO `agreement_items` VALUES ('40', '15', '3', 'Active', 'New', '2', 'CPC', '0', '0', '0', '-1', '', '2018-11-02 11:52:04', '1', '2018-11-02 13:02:30', '1');
INSERT INTO `agreement_items` VALUES ('41', '16', '1', 'Active', 'Endorsement', '1', 'CPC', '0', '0', '0', '0', null, '2018-11-05 13:15:09', '1', '2018-11-05 13:16:25', '1');
INSERT INTO `agreement_items` VALUES ('42', '16', '3', 'Deleted', 'Endorsement', '2', 'CPC', '0', '0', '0', '0', null, '2018-11-05 13:15:09', '1', '2018-11-05 13:16:25', '1');
INSERT INTO `agreement_items` VALUES ('43', '17', '3', 'Active', 'New', '1', 'Min', '1', '1', '0', '-1', 'Accounts', '2018-11-29 22:35:29', '1', null, null);
INSERT INTO `agreement_items` VALUES ('44', '18', '1', 'Active', 'New', '1', 'Min', '1', '1', '0', '-1', 'Management', '2018-12-12 16:06:19', '1', null, null);

-- ----------------------------
-- Table structure for bc_basic_accounts
-- ----------------------------
DROP TABLE IF EXISTS `bc_basic_accounts`;
CREATE TABLE `bc_basic_accounts` (
  `bcacc_basic_account_ID` int(8) NOT NULL AUTO_INCREMENT,
  `bcacc_name` varchar(50) DEFAULT NULL,
  `bcacc_description` varchar(255) DEFAULT NULL,
  `bcacc_type` varchar(20) DEFAULT NULL,
  `bcacc_balance` double DEFAULT NULL,
  `bcacc_work_tel` varchar(20) DEFAULT NULL,
  `bcacc_mobile` varchar(20) DEFAULT NULL,
  `bcacc_email` varchar(60) DEFAULT NULL,
  `bcacc_created_date_time` datetime DEFAULT NULL,
  `bcacc_created_by` int(8) DEFAULT NULL,
  `bcacc_last_update_date_time` datetime DEFAULT NULL,
  `bcacc_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`bcacc_basic_account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bc_basic_accounts
-- ----------------------------
INSERT INTO `bc_basic_accounts` VALUES ('1', 'Michael', 'Michaels Ermogenous', 'Customer', '0', '24123456', '99420544', 'ermogenousm@gmail.com', '2019-02-11 21:17:48', '1', '2019-02-11 21:34:31', '1');
INSERT INTO `bc_basic_accounts` VALUES ('2', 'Giorgos Georgiou', 'Giorgos Georgiou', 'Customer', '0', '24123456', '99123456', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('3', 'Andreas Andreou', 'Andreas Andreou', 'Customer', '0', '24123654', '99123654', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('4', 'Andreas ', 'Andreas ', 'Customer', '0', '', '', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('5', 'Maria ', 'Maria ', 'Customer', '0', '', '', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('6', 'dfsdfsd ', 'dfsdfsd ', 'Customer', '0', '', '', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('7', 'Michael Ermogenous Comm.', 'Michael Ermogenous A1001 Commission A/C', 'Agent', '0', '', null, 'it@ydrogios.com.cy', '2019-02-14 09:44:52', '1', '2019-02-14 11:13:51', '1');
INSERT INTO `bc_basic_accounts` VALUES ('8', 'Giorgos Comm.', 'Giorgos A1002 Commission A/C', 'Agent', '0', '', null, '', '2019-02-14 09:44:52', '1', '2019-02-15 11:18:33', '1');
INSERT INTO `bc_basic_accounts` VALUES ('9', 'Michael Ermogenous Comm. Release', 'Michael Ermogenous A1001 Commission Release A/C', 'Agent', '0', '', null, 'it@ydrogios.com.cy', '2019-02-14 11:09:39', '1', '2019-02-14 11:13:51', '1');

-- ----------------------------
-- Table structure for bc_basic_transactions
-- ----------------------------
DROP TABLE IF EXISTS `bc_basic_transactions`;
CREATE TABLE `bc_basic_transactions` (
  `bctra_basic_transactions` int(8) NOT NULL AUTO_INCREMENT,
  `bctra_basic_account_ID` int(8) DEFAULT NULL,
  `bctra_status` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `bctra_db_cr` int(1) DEFAULT NULL,
  `bctra_amount` double DEFAULT NULL,
  `bctra_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `bctra_created_by` int(8) DEFAULT NULL,
  `bctra_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `bctra_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`bctra_basic_transactions`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of bc_basic_transactions
-- ----------------------------

-- ----------------------------
-- Table structure for codes
-- ----------------------------
DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `cde_code_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cde_type` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cde_table_field` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `cde_table_field2` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `cde_table_field3` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `cde_value` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cde_value_label` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cde_value_2` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cde_value_label_2` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cde_option_value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cde_option_label` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cde_created_date_time` datetime DEFAULT NULL,
  `cde_created_by` int(8) DEFAULT NULL,
  `cde_last_update_date_time` datetime DEFAULT NULL,
  `cde_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`cde_code_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COMMENT='Codes';

-- ----------------------------
-- Records of codes
-- ----------------------------
INSERT INTO `codes` VALUES ('1', 'code', 'customers#cst_city_code_ID', null, null, 'Cities', 'City Name', 'CityShort', 'City Name Short', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('2', 'code', 'customers#cst_business_type_code_ID', null, null, 'BusinessType', 'Business Type', '', '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('3', 'BusinessType', null, null, null, 'Bank', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('4', 'BusinessType', null, null, null, 'Insurance', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('5', 'BusinessType', null, null, null, 'Private', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('6', 'Cities', null, null, null, 'Nicosia', 'City Name', 'NIC', 'City Name Short', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('7', 'Cities', null, null, null, 'Limassol', 'City Name', 'LIM', 'City Name Short', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('8', 'Cities', null, null, null, 'Larnaca', 'City Name', 'LAR', 'City Name Short', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('9', 'Cities', null, null, null, 'Paphos', 'City Name', 'PAF', 'City Name Short', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('10', 'Cities', null, null, null, 'Famagusta', 'City Name', 'FAM', 'City Name Short', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('11', 'BusinessType', null, null, null, 'Public School', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('12', 'BusinessType', null, null, null, 'Accounting', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('13', 'BusinessType', null, null, null, 'Law', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('14', 'BusinessType', null, null, null, 'Private School', 'Business Type', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('15', 'code', 'customers#cst_contact_person_title_code_ID', null, null, 'ContactPersonTitle', 'Contact Person Title', '', '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('16', 'ContactPersonTitle', null, null, null, 'Owner', 'Contact Person Title', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('17', 'ContactPersonTitle', null, null, null, 'Secretary', 'Contact Person Title', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('18', 'ContactPersonTitle', null, null, null, 'Director', 'Contact Person Title', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('19', 'ContactPersonTitle', null, null, null, 'IT Manager', 'Contact Person Title', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('20', 'ContactPersonTitle', null, null, null, 'IT Technitian', 'Contact Person Title', null, '', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('21', 'code', 'manufacturers#mnf_country_code_ID', null, null, 'Countries', 'Country Name', '', 'Short Code', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('22', 'Countries', null, null, null, 'Cyprus', 'Country Name', 'CYP', 'Short Code', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('23', 'Countries', null, null, null, 'Germany', 'Country Name', 'DEU', 'Short Code', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('24', 'Countries', null, null, null, 'Greece', 'Country Name', 'GRC', 'Short Code', null, null, null, null, null, null);
INSERT INTO `codes` VALUES ('25', 'code', 'products#prd_sub_type_code_ID', null, null, 'ProductsSubType', 'Products SubType', '', '', 'Machine#Consumables#Spare Parts#Other', 'For Type', null, null, '2018-12-05 17:04:52', '1');
INSERT INTO `codes` VALUES ('27', 'ProductsSubType', null, null, null, 'MultiFunction', 'Products SubType', null, '', 'Machine', null, '2018-08-13 23:03:56', '1', '2018-08-13 23:41:01', '1');
INSERT INTO `codes` VALUES ('28', 'ProductsSubType', null, null, null, 'Printer', 'Products SubType', null, '', 'Machine', null, '2018-08-13 23:45:21', '1', null, null);
INSERT INTO `codes` VALUES ('29', 'ProductsSubType', null, null, null, 'Toners', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:45:30', '1', null, null);
INSERT INTO `codes` VALUES ('30', 'ProductsSubType', null, null, null, 'Waste Box', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:45:39', '1', null, null);
INSERT INTO `codes` VALUES ('31', 'ProductsSubType', null, null, null, 'Stables', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:45:48', '1', null, null);
INSERT INTO `codes` VALUES ('32', 'ProductsSubType', null, null, null, 'Developers', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:45:58', '1', null, null);
INSERT INTO `codes` VALUES ('33', 'ProductsSubType', null, null, null, 'Drums', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:46:06', '1', null, null);
INSERT INTO `codes` VALUES ('34', 'ProductsSubType', null, null, null, 'CL.Blades', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:46:19', '1', null, null);
INSERT INTO `codes` VALUES ('35', 'ProductsSubType', null, null, null, 'Heat Rollers/Belts', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:46:35', '1', null, null);
INSERT INTO `codes` VALUES ('36', 'ProductsSubType', null, null, null, 'Press Rollers', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:46:45', '1', null, null);
INSERT INTO `codes` VALUES ('37', 'ProductsSubType', null, null, null, 'Feed Rollers', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:46:54', '1', null, null);
INSERT INTO `codes` VALUES ('38', 'ProductsSubType', null, null, null, 'Maintenance Kits', 'Products SubType', null, '', 'Consumables', null, '2018-08-13 23:47:05', '1', null, null);
INSERT INTO `codes` VALUES ('39', 'ProductsSubType', null, null, null, 'Spare Parts', 'Products SubType', null, '', 'Spare Parts', null, '2018-08-13 23:47:14', '1', null, null);
INSERT INTO `codes` VALUES ('40', 'ProductsSubType', null, null, null, 'A4 Paper', 'Products SubType', null, '', 'Other', null, '2018-12-05 17:05:16', '1', null, null);
INSERT INTO `codes` VALUES ('41', 'ProductsSubType', null, null, null, 'A3 Paper', 'Products SubType', null, '', 'Other', null, '2018-12-05 17:08:53', '1', null, null);

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `cst_customer_ID` int(8) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Customers';

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', null, '1', '786613', 'Michaels', 'Ermogenous', 'add1', 'add2', '8', null, '18', '24123456', '24654321', '24010101', '99420544', '99123456', 'ermogenousm@gmail.com', 'ermogenousm@gmail.com', '5', null, null, '2019-02-11 21:17:48', '1');
INSERT INTO `customers` VALUES ('2', null, '2', '123456', 'Giorgos', 'Georgiou', '', '', '8', '', '18', '24123456', '', '', '99123456', '', '', '', '12', '2018-08-24 00:51:42', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('3', null, '3', '99887766', 'Andreas', 'Andreou', '', '', '7', 'Andreas', '16', '24123654', '', '', '99123654', '', '', '', '5', '2018-10-02 10:16:06', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('4', null, '4', '1111', 'Andreas', '', '', '', '8', '', '16', '', '', '', '', '', '', '', '4', '2019-02-10 10:37:30', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('5', null, '5', '1212', 'Maria', '', '', '', '8', '', '18', '', '', '', '', '', '', '', '12', '2019-02-10 10:40:41', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('7', null, '6', '121212', 'dfsdfsd', '', '', '', '8', '', '18', '', '', '', '', '', '', '', '12', '2019-02-11 20:56:58', '1', '2019-02-11 20:58:55', '1');

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
  `inaic_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inaic_created_by` int(8) DEFAULT NULL,
  `inaic_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `inainc_created_date_time` datetime DEFAULT NULL,
  `inainc_created_by` int(8) NOT NULL DEFAULT '0',
  `inainc_last_update_date_time` datetime DEFAULT NULL,
  `inainc_last_update_by` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inainc_insurance_company_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_insurance_companies
-- ----------------------------
INSERT INTO `ina_insurance_companies` VALUES ('1', 'Active', 'AI', 'AIG', 'AIG', '22', '2019-01-23 10:02:29', '1', '2019-01-23 10:45:40', '1');
INSERT INTO `ina_insurance_companies` VALUES ('2', 'InActive', 'AL', 'ALLIANZ', 'ALLIANZ', '22', '2019-01-23 10:45:52', '1', '2019-02-11 19:44:13', '1');
INSERT INTO `ina_insurance_companies` VALUES ('3', 'Active', 'ALTIUS', 'ALTIUS', 'ALTIUS', '22', '2019-01-23 10:48:39', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('4', 'Active', 'ATLANTIC', 'ATLANTIC', 'ATLANTIC', '22', '2019-01-23 10:48:48', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('5', 'Active', 'CNP', 'CNP', 'CNP', '22', '2019-01-23 10:48:57', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('6', 'Active', 'COMMERCIAL GENERAL I', 'COMMERCIAL GENERAL INSURANCE', 'COMMERCIAL GENERAL INSURANCE', '22', '2019-01-23 10:49:08', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('7', 'Active', 'COSMOS', 'COSMOS', 'COSMOS', '22', '2019-01-23 10:49:17', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('8', 'Active', 'ETHNIKI GENERAL INSU', 'ETHNIKI GENERAL INSURANCE', 'ETHNIKI GENERAL INSURANCE', '22', '2019-01-23 10:49:26', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('9', 'Active', 'EUROSURE', 'EUROSURE', 'EUROSURE', '22', '2019-01-23 10:49:34', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('10', 'Active', 'GAN DIRECT', 'GAN DIRECT', 'GAN DIRECT', '22', '2019-01-23 10:49:42', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('11', 'Active', 'GENERAL INSURANCE OF', 'GENERAL INSURANCE OF CYPRUS', 'GENERAL INSURANCE OF CYPRUS', '22', '2019-01-23 10:50:31', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('12', 'Active', 'HYDRA', 'HYDRA', 'HYDRA', '22', '2019-01-23 10:50:44', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('13', 'Active', 'KENTRIKI', 'KENTRIKI', 'KENTRIKI', '22', '2019-01-23 10:50:52', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('14', 'Active', 'LUMEN', 'LUMEN', 'LUMEN', '22', '2019-01-23 10:51:01', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('15', 'Active', 'MINERVA', 'MINERVA', 'MINERVA', '22', '2019-01-23 10:51:19', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('16', 'Active', 'OLYMPIC', 'OLYMPIC', 'OLYMPIC', '22', '2019-01-23 10:51:27', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('17', 'Active', 'PANCYPRIAN', 'PANCYPRIAN', 'PANCYPRIAN', '22', '2019-01-23 10:51:36', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('18', 'Active', 'PRIME INSURANCE', 'PRIME INSURANCE', 'PRIME INSURANCE', '22', '2019-01-23 10:51:44', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('19', 'Active', 'PROGRESSIVE', 'PROGRESSIVE', 'PROGRESSIVE', '22', '2019-01-23 10:51:52', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('20', 'Active', 'ROYAL CROWN', 'ROYAL CROWN', 'ROYAL CROWN', '22', '2019-01-23 10:52:06', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('21', 'Active', 'TRADEWISE INSURANCE ', 'TRADEWISE INSURANCE COMPANY LIMITED', 'TRADEWISE INSURANCE COMPANY LIMITED', '22', '2019-01-23 10:52:16', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('22', 'Active', 'TRUST', 'TRUST', 'TRUST', '22', '2019-01-23 10:52:24', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('23', 'Active', 'YDROGIOS', 'YDROGIOS', 'YDROGIOS', '22', '2019-01-23 10:52:31', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('24', 'Active', 'ΚΟΙΝΟΠΡΑΞΙΑ', 'ΚΟΙΝΟΠΡΑΞΙΑ', 'ΚΟΙΝΟΠΡΑΞΙΑ', '22', '2019-01-23 10:52:39', '1', null, '0');
INSERT INTO `ina_insurance_companies` VALUES ('25', 'Active', 'Anytime', 'Anytime', 'Anytime', '22', '2019-01-23 10:57:03', '1', null, '0');

-- ----------------------------
-- Table structure for ina_policies
-- ----------------------------
DROP TABLE IF EXISTS `ina_policies`;
CREATE TABLE `ina_policies` (
  `inapol_policy_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapol_for_user_group_ID` int(8) DEFAULT NULL,
  `inapol_agent_ID` int(8) DEFAULT NULL,
  `inapol_insurance_company_ID` int(8) DEFAULT NULL,
  `inapol_customer_ID` int(8) DEFAULT NULL,
  `inapol_type_code_ID` int(8) DEFAULT NULL COMMENT 'Motor, Fire, EL, PL, PA, PI,',
  `inapol_policy_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `inapol_period_starting_date` date DEFAULT NULL,
  `inapol_starting_date` date DEFAULT NULL,
  `inapol_expiry_date` date DEFAULT NULL,
  `inapol_status` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `inapol_process_status` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `inapol_premium` double DEFAULT NULL,
  `inapol_mif` double DEFAULT NULL,
  `inapol_commission` double DEFAULT NULL,
  `inapol_fees` double DEFAULT NULL,
  `inapol_stamps` double DEFAULT NULL,
  `inapol_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapol_created_by` int(8) DEFAULT NULL,
  `inapol_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapol_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapol_policy_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policies
-- ----------------------------
INSERT INTO `ina_policies` VALUES ('3', '0', '1', '1', '1', '1', '123456789', '2019-01-01', '2019-01-01', '2019-12-31', 'Outstanding', null, '150', '12', '34', '20', '2', '2019-03-06 12:42:00', '1', '2019-03-06 12:42:00', '1');

-- ----------------------------
-- Table structure for ina_policy_installments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_installments`;
CREATE TABLE `ina_policy_installments` (
  `inapi_policy_installments_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapi_policy_ID` int(8) DEFAULT NULL,
  `inapi_paid_status` varchar(8) DEFAULT NULL COMMENT 'UnPaid\r\nPaid\r\nPartial\r\nAlert (when total installments commission is not equal with policy commission)\r\n',
  `inapi_insert_date` date DEFAULT NULL,
  `inapi_document_date` date DEFAULT NULL,
  `inapi_last_payment_date` date DEFAULT NULL,
  `inapi_amount` double DEFAULT NULL,
  `inapi_paid_amount` double DEFAULT NULL,
  `inapi_commission_amount` double DEFAULT NULL,
  `inapi_paid_commission_amount` double DEFAULT NULL,
  `inapi_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapi_created_by` int(8) DEFAULT NULL,
  `inapi_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapi_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapi_policy_installments_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_installments
-- ----------------------------
INSERT INTO `ina_policy_installments` VALUES ('117', '3', 'UnPaid', '2019-03-07', '2019-01-01', null, '46', '0', '8.5', '0', '2019-03-07 12:12:16', '1', '2019-03-07 12:12:16', '1');
INSERT INTO `ina_policy_installments` VALUES ('118', '3', 'UnPaid', '2019-03-07', '2019-02-01', null, '46', '0', '8.5', '0', '2019-03-07 12:12:16', '1', '2019-03-07 12:12:16', '1');
INSERT INTO `ina_policy_installments` VALUES ('119', '3', 'UnPaid', '2019-03-07', '2019-03-01', null, '46', '0', '8.5', null, '2019-03-07 10:50:07', '1', '2019-03-07 10:50:07', '1');
INSERT INTO `ina_policy_installments` VALUES ('120', '3', 'UnPaid', '2019-03-07', '2019-04-01', null, '46', '0', '8.5', null, '2019-03-07 10:50:07', '1', '2019-03-07 10:50:07', '1');

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
  `inapit_insured_amount` double DEFAULT NULL,
  `inapit_excess` double DEFAULT NULL,
  `inapit_premium` double DEFAULT NULL,
  `inapit_mif` double DEFAULT NULL,
  `inapit_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapit_created_by` int(8) DEFAULT NULL,
  `inapit_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapit_policy_item_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policy_items
-- ----------------------------
INSERT INTO `ina_policy_items` VALUES ('5', '3', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '0', '0', '120', '11.43', '2019-02-05 12:54:14', '1', null, null);

-- ----------------------------
-- Table structure for ina_policy_payments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments`;
CREATE TABLE `ina_policy_payments` (
  `inapp_policy_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapp_policy_ID` int(8) DEFAULT NULL,
  `inapp_status` varchar(12) DEFAULT NULL COMMENT 'Outstanding\r\nApplied\r\nPosted\r\nIncomplete',
  `inapp_payment_date` date DEFAULT NULL,
  `inapp_amount` double DEFAULT NULL,
  `inapp_commission_amount` double DEFAULT NULL,
  `inapp_allocated_amount` double DEFAULT NULL,
  `inapp_allocated_commission` double DEFAULT NULL,
  `inapp_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapp_created_by` int(8) DEFAULT NULL,
  `inapp_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapp_policy_payment_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments
-- ----------------------------
INSERT INTO `ina_policy_payments` VALUES ('6', '3', 'Outstanding', '2019-03-06', '50', '6', '0', '0', '2019-03-07 12:12:16', '1', '2019-03-07 12:12:16', '1');

-- ----------------------------
-- Table structure for ina_policy_payments_lines
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments_lines`;
CREATE TABLE `ina_policy_payments_lines` (
  `inappl_policy_payments_line_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inappl_policy_payment_ID` int(8) DEFAULT NULL,
  `inappl_policy_installment_ID` int(8) DEFAULT NULL,
  `inappl_previous_paid_amount` double DEFAULT NULL,
  `inappl_new_paid_amount` double DEFAULT NULL,
  `inappl_previous_commission_paid_amount` double DEFAULT NULL,
  `inappl_new_commission_paid_amount` double DEFAULT NULL,
  `inappl_previous_paid_status` varchar(12) DEFAULT NULL,
  `inappl_new_paid_status` varchar(12) DEFAULT NULL,
  `inappl_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inappl_created_by` int(8) DEFAULT NULL,
  `inappl_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inappl_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inappl_policy_payments_line_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments_lines
-- ----------------------------

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
  `inapot_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inapot_created_by` int(8) DEFAULT NULL,
  `inapot_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
INSERT INTO `ip_locations` VALUES ('1', '::1', '', '', '', '', '', '', '2019-03-06 12:16:34');
INSERT INTO `ip_locations` VALUES ('2', '127.0.0.1', '', '', '', '', '', '', '2019-03-05 11:05:32');

-- ----------------------------
-- Table structure for lcs_disc_test
-- ----------------------------
DROP TABLE IF EXISTS `lcs_disc_test`;
CREATE TABLE `lcs_disc_test` (
  `lcsdc_disc_test_ID` int(8) NOT NULL AUTO_INCREMENT,
  `lcsdc_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_tel` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_status` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_process_status` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_1` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_2` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_3` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_4` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_5` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_6` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_7` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_8` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_9` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_10` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_11` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_12` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_13` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_14` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_15` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_16` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_17` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_18` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_19` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_20` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_21` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_22` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_23` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_24` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_25` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_26` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_27` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_question_28` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `lcsdc_created_by` int(8) DEFAULT NULL,
  `lcsdc_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `lcsdc_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`lcsdc_disc_test_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of lcs_disc_test
-- ----------------------------
INSERT INTO `lcs_disc_test` VALUES ('1', 'Michael Ermogenous', '99420544', 'micacca@gmail.com', 'Outstanding', 'UnPaid', 'B', 'B', 'B', 'A', 'A', 'A', 'A', 'A', 'A', 'B', 'B', 'B', 'B', 'B', 'B', 'B', 'B', 'B', 'B', 'A', 'A', 'A', 'A', 'A', 'B', 'B', 'B', 'A', '2019-02-19 09:52:18', '1', '2019-02-19 09:52:18', '1');
INSERT INTO `lcs_disc_test` VALUES ('2', 'Test', '1233333', 'micacca@gmail.com', 'Outstanding', 'UnPaid', 'A', 'A', 'A', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'B', '2019-02-28 11:40:23', '1', '2019-02-28 11:40:23', '1');
INSERT INTO `lcs_disc_test` VALUES ('3', 'Andreas Andreou', '123456789', 'fsddfsa@gdfsd.com', 'Outstanding', 'UnPaid', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'B', 'B', 'B', 'A', 'B', 'A', 'A', 'B', 'A', 'B', 'B', 'A', 'B', 'B', 'A', '2019-02-19 10:05:27', '1', '2019-02-19 10:05:27', '1');
INSERT INTO `lcs_disc_test` VALUES ('4', 'Michalis Ermogenous', '99420544', 'micacca@gmail.com', 'Completed', 'Paid', 'B', 'A', 'A', 'B', 'A', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'A', 'B', 'B', 'A', 'A', '2019-02-19 10:22:10', '1', '2019-02-19 10:22:10', '1');
INSERT INTO `lcs_disc_test` VALUES ('5', 'Charis', '', 'email@email.com', 'Outstanding', 'Free', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-02-19 09:50:48', '1', '2019-02-19 09:50:48', '1');
INSERT INTO `lcs_disc_test` VALUES ('6', 'Another', '', '', 'Outstanding', 'Paid', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-02-19 09:58:17', '1', '2019-02-19 09:58:17', '1');
INSERT INTO `lcs_disc_test` VALUES ('7', 'Andreas Andreou', '123456789', 'micacca@gmail.com', 'Completed', 'Paid', 'B', 'B', 'A', 'A', 'A', 'B', 'A', 'A', 'B', 'B', 'B', 'A', 'A', 'A', 'B', 'B', 'B', 'A', 'A', 'B', 'A', 'B', 'A', 'A', 'A', 'A', 'A', 'A', '2019-02-21 13:24:40', '0', '2019-02-21 13:24:40', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=3181 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of log_file
-- ----------------------------

-- ----------------------------
-- Table structure for manufacturers
-- ----------------------------
DROP TABLE IF EXISTS `manufacturers`;
CREATE TABLE `manufacturers` (
  `mnf_manufacturer_ID` int(8) NOT NULL AUTO_INCREMENT,
  `mnf_code` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `mnf_active` int(1) DEFAULT NULL,
  `mnf_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `mnf_description` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `mnf_country_code_ID` int(8) DEFAULT NULL,
  `mnf_tel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `mnf_contact_person` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `mnf_created_date_time` datetime DEFAULT NULL,
  `mnf_created_by` int(8) DEFAULT NULL,
  `mnf_last_update_date_time` datetime DEFAULT NULL,
  `mnf_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`mnf_manufacturer_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Manufacturers';

-- ----------------------------
-- Records of manufacturers
-- ----------------------------
INSERT INTO `manufacturers` VALUES ('1', 'UTAX', '1', 'Utax Ltd', 'blah blah', '23', null, null, '2018-08-09 16:58:58', '1', '2018-09-19 20:17:12', '1');
INSERT INTO `manufacturers` VALUES ('2', 'PaperCoLtd', '1', 'Paper Company Ltd', 'Paper Company Ltd', '24', null, null, '2018-12-05 17:10:16', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `prd_product_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prd_manufacturer_ID` int(8) DEFAULT NULL,
  `prd_active` int(1) DEFAULT NULL,
  `prd_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `prd_sub_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `prd_size` varchar(20) CHARACTER SET utf8 DEFAULT '0',
  `prd_color` varchar(20) CHARACTER SET utf8 DEFAULT '0',
  `prd_model` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `prd_bar_code` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prd_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prd_description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `prd_current_stock` int(8) DEFAULT '0',
  `prd_stock_last_update` datetime DEFAULT NULL,
  `prd_created_date_time` datetime DEFAULT NULL,
  `prd_created_by` int(8) DEFAULT NULL,
  `prd_last_update_date_time` datetime DEFAULT NULL,
  `prd_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`prd_product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Products';

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '1', '1', 'Machine', 'Printer', 'A4', 'Black', 'LP 3130', '', 'LP 3130', 'LP 3130', '8', '2018-11-05 13:13:07', '2018-08-09 17:54:51', '1', '2018-11-05 13:13:07', '1');
INSERT INTO `products` VALUES ('2', '1', '1', 'SparePart', null, 'A4', 'Black', 'Developer Unit', '', 'Developer Unit', 'Developer Unit', '4', '2019-01-08 13:19:27', '2018-08-10 09:09:49', '1', '2019-01-08 13:19:27', '1');
INSERT INTO `products` VALUES ('3', '1', '1', 'Machine', 'selected', 'A4', 'Black', 'LP 3035', '', 'LP 3035', 'LP 3035', '7', '2018-11-29 22:35:37', '2018-08-10 09:10:56', '1', '2018-11-29 22:35:37', '1');
INSERT INTO `products` VALUES ('4', '1', '1', 'Consumable', 'Toners', 'A4', 'Black', 'TK-160/162', '', 'TK-160/162', 'TK-160/162', '3', '2019-01-08 13:34:45', '2018-08-10 11:26:36', '1', '2019-01-08 13:34:45', '1');
INSERT INTO `products` VALUES ('5', '1', '1', 'Consumable', 'Toners', 'A4', 'Color', 'PK-3010 Yellow', '', 'Yellow', 'PY-3010 Yellow', '1', '2019-01-08 13:34:45', '2018-08-11 12:41:46', '1', '2019-01-08 13:34:45', '1');
INSERT INTO `products` VALUES ('7', '1', '1', 'Consumable', 'Toners', 'A4', 'Color', 'PM-3010 Magenta', '', 'Magenta', 'PM-3010 Magenta', '2', '2019-01-08 13:34:45', '2018-08-11 12:43:06', '1', '2019-01-08 13:34:45', '1');
INSERT INTO `products` VALUES ('8', '1', '1', 'SparePart', 'Spare', 'A4', 'Black', 'Troxoui 2255', '', 'Troxoui', 'Troxoui', '8', '2019-01-08 13:19:27', '2018-11-29 22:18:27', '1', '2019-01-08 13:19:27', '1');
INSERT INTO `products` VALUES ('9', '2', '1', 'Other', 'A4 Paper', 'A4', 'Other', 'A4 Plain Paper', '', 'A4 Plain Paper Box 5x500', 'A4 Plain Paper Box 5x500', '9', '2019-01-08 13:19:27', '2018-12-05 17:09:26', '1', '2019-01-08 13:19:27', '1');
INSERT INTO `products` VALUES ('10', '1', '1', 'Other', 'A3 Paper', 'A3', 'Other', 'A3 Plain Paper', '', 'A3 Plain Paper Box 3X500', 'A3 Plain Paper Box 3X500', '14', '2019-01-08 13:34:45', '2018-12-05 17:09:50', '1', '2019-01-08 13:34:45', '1');

-- ----------------------------
-- Table structure for product_relations
-- ----------------------------
DROP TABLE IF EXISTS `product_relations`;
CREATE TABLE `product_relations` (
  `prdr_product_relations_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prdr_product_parent_ID` int(8) DEFAULT NULL,
  `prdr_child_type` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `prdr_product_child_ID` int(8) DEFAULT NULL,
  `prdr_created_date_time` datetime DEFAULT NULL,
  `prdr_created_by` int(8) DEFAULT NULL,
  `prdr_last_update_date_time` datetime DEFAULT NULL,
  `prdr__last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`prdr_product_relations_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Products Relations';

-- ----------------------------
-- Records of product_relations
-- ----------------------------
INSERT INTO `product_relations` VALUES ('17', '1', 'Consumable', '7', null, null, null, null);
INSERT INTO `product_relations` VALUES ('18', '1', 'Consumable', '4', null, null, null, null);
INSERT INTO `product_relations` VALUES ('19', '1', 'Consumable', '5', null, null, null, null);
INSERT INTO `product_relations` VALUES ('20', '1', 'SparePart', '2', null, null, null, null);
INSERT INTO `product_relations` VALUES ('21', '3', 'Consumable', '4', null, null, null, null);
INSERT INTO `product_relations` VALUES ('22', '3', 'SparePart', '2', null, null, null, null);
INSERT INTO `product_relations` VALUES ('23', '1', 'SparePart', '8', null, null, null, null);

-- ----------------------------
-- Table structure for schedules
-- ----------------------------
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `sch_schedule_ID` int(8) NOT NULL AUTO_INCREMENT,
  `sch_user_ID` int(8) DEFAULT '0',
  `sch_schedule_number` varchar(20) COLLATE utf8_bin DEFAULT '0',
  `sch_status` varchar(20) COLLATE utf8_bin DEFAULT '0',
  `sch_schedule_date` date DEFAULT NULL,
  `sch_created_date_time` datetime DEFAULT NULL,
  `sch_created_by` int(8) DEFAULT NULL,
  `sch_last_update_date_time` datetime DEFAULT NULL,
  `sch_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`sch_schedule_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of schedules
-- ----------------------------
INSERT INTO `schedules` VALUES ('1', '1', 'SCH-000010', 'Outstanding', '2019-01-08', '2019-01-04 18:47:56', '1', '2019-01-08 12:36:12', '1');
INSERT INTO `schedules` VALUES ('2', '1', 'SCH-000011', 'Outstanding', '2019-01-07', '2019-01-04 18:48:57', '1', '2019-01-08 13:35:19', '1');
INSERT INTO `schedules` VALUES ('3', '3', 'SCH-000012', 'Outstanding', '2019-01-10', '2019-01-04 18:52:35', '1', '2019-01-04 19:39:24', '1');

-- ----------------------------
-- Table structure for schedule_ticket
-- ----------------------------
DROP TABLE IF EXISTS `schedule_ticket`;
CREATE TABLE `schedule_ticket` (
  `scht_schedule_ticket_ID` int(8) NOT NULL AUTO_INCREMENT,
  `scht_schedule_ID` int(8) NOT NULL DEFAULT '0',
  `scht_ticket_ID` int(8) NOT NULL DEFAULT '0',
  `scht_time` time DEFAULT NULL,
  PRIMARY KEY (`scht_schedule_ticket_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of schedule_ticket
-- ----------------------------
INSERT INTO `schedule_ticket` VALUES ('4', '2', '4', '14:00:00');
INSERT INTO `schedule_ticket` VALUES ('11', '3', '1', null);
INSERT INTO `schedule_ticket` VALUES ('12', '3', '5', null);
INSERT INTO `schedule_ticket` VALUES ('15', '1', '1', '09:09:00');
INSERT INTO `schedule_ticket` VALUES ('17', '1', '4', '17:05:00');

-- ----------------------------
-- Table structure for send_auto_emails
-- ----------------------------
DROP TABLE IF EXISTS `send_auto_emails`;
CREATE TABLE `send_auto_emails` (
  `sae_send_auto_emails_serial` int(10) NOT NULL AUTO_INCREMENT,
  `sae_active` varchar(1) CHARACTER SET utf8 DEFAULT NULL COMMENT 'A -> Active',
  `sae_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `sae_created_datetime` datetime DEFAULT NULL,
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
  `sae_email_to` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_to_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_from` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_from_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_subject` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_reply_to` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_reply_to_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_cc` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_bcc` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `sae_email_body` text CHARACTER SET utf8,
  `sae_attachment_file` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sae_agent_code` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `sae_send_result_description` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`sae_send_auto_emails_serial`),
  UNIQUE KEY `unique_serial` (`sae_send_auto_emails_serial`),
  KEY `send_result` (`sae_send_result`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of send_auto_emails
-- ----------------------------
INSERT INTO `send_auto_emails` VALUES ('2', 'A', 'quotation', '2018-05-29 09:17:46', '0', null, '17', 'Quotation_ID', null, null, null, null, null, null, 'ermogenousm@gmail.com', 'Michael Ermogenous', '', '', 'A.K.Demetriou Development - Quotation', null, null, null, null, 'Please find attached our quotation', 'quotations/pdfFiles/17-20180529091746.pdf', null, null);
INSERT INTO `send_auto_emails` VALUES ('3', 'A', 'quotation', '2018-05-29 17:06:56', '0', null, '17', 'Quotation_ID', null, null, null, null, null, null, 'gsdfsd@fgdsf.com', 'sdf', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', 'A.K.Demetriou Development - Quotation', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', null, null, 'Please find attached our quotation', 'quotations/pdfFiles/17-20180529170656.pdf', null, null);
INSERT INTO `send_auto_emails` VALUES ('4', 'A', 'quotation', '2018-05-29 17:11:17', '0', null, '17', 'Quotation_ID', null, null, null, null, null, null, 'gsdfsd@fgdsf.com', 'sdf', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', 'A.K.Demetriou Development - Quotation', 'no-reply@akdemetriou.com', 'A.K.Demetriou Development - No-Reply', null, null, 'Please find attached our quotation', 'quotations/pdfFiles/17-20180529171116.pdf', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'admin_default_layout', 'insurance', '2019-03-06 12:17:11', '0');
INSERT INTO `settings` VALUES ('2', 'user_levels_extra_1_name', 'Agents No Group Option', '2018-04-18 12:41:59', '0');
INSERT INTO `settings` VALUES ('3', 'user_levels_extra_2_name', 'User 2', '2018-04-12 12:55:31', '0');
INSERT INTO `settings` VALUES ('4', 'user_levels_extra_3_name', 'User 3', '2018-04-12 12:55:34', '0');
INSERT INTO `settings` VALUES ('5', 'user_levels_extra_4_name', 'User 4', '2018-04-12 12:55:36', '0');
INSERT INTO `settings` VALUES ('6', 'user_levels_extra_5_name', 'User 5', '2018-04-12 12:55:38', '0');
INSERT INTO `settings` VALUES ('7', 'user_levels_extra_6_name', 'User 6', '2018-04-12 12:55:41', '0');
INSERT INTO `settings` VALUES ('8', 'stk_active_month', '8', '2018-08-21 13:43:27', '0');
INSERT INTO `settings` VALUES ('9', 'stk_active_year', '2018', null, '0');
INSERT INTO `settings` VALUES ('10', 'agr_agreement_number_prefix', 'AGR-', '2019-01-14 22:01:57', '1');
INSERT INTO `settings` VALUES ('11', 'agr_agreement_number_last_used', '77', '2018-12-12 16:06:19', '0');
INSERT INTO `settings` VALUES ('12', 'agr_agreement_number_leading_zeros', '6', '2018-09-21 18:05:59', '0');
INSERT INTO `settings` VALUES ('13', 'agr_agreement_status_on_insert', 'Pending', '2018-11-14 15:00:00', '0');
INSERT INTO `settings` VALUES ('14', 'layout_show_footer_stats', 'AdminYes', '2019-02-25 10:47:00', '1');
INSERT INTO `settings` VALUES ('15', 'tck_ticket_number_prefix', 'TCK-', null, '0');
INSERT INTO `settings` VALUES ('16', 'tck_ticket_number_leading_zeros', '6', null, '0');
INSERT INTO `settings` VALUES ('17', 'tck_ticket_number_last_used', '7', '2019-01-04 17:32:29', '0');
INSERT INTO `settings` VALUES ('18', 'sch_schedule_number_prefix', 'SCH-', null, '0');
INSERT INTO `settings` VALUES ('19', 'sch_schedule_number_leading_zeros', '6', null, '0');
INSERT INTO `settings` VALUES ('20', 'sch_schedule_number_last_used', '12', '2019-01-04 18:52:35', '0');
INSERT INTO `settings` VALUES ('21', 'stk_stock_enable', '1', '2019-01-16 15:22:14', '1');
INSERT INTO `settings` VALUES ('22', 'cst_customer_per_user', 'perUser', '2019-01-14 22:03:27', '1');
INSERT INTO `settings` VALUES ('23', 'cst_admin_customers', 'viewAll', '2019-01-16 15:27:05', '1');
INSERT INTO `settings` VALUES ('24', 'admin_imitate_user', 'No', '2019-01-23 10:48:05', '1');
INSERT INTO `settings` VALUES ('25', 'ina_enable_agent_insurance', '1', '2019-01-16 15:23:06', '1');
INSERT INTO `settings` VALUES ('26', 'accounts', 'basic', '2019-02-10 10:35:06', '1');

-- ----------------------------
-- Table structure for stock
-- ----------------------------
DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `stk_stock_ID` int(8) NOT NULL AUTO_INCREMENT,
  `stk_product_ID` int(8) NOT NULL DEFAULT '0',
  `stk_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `stk_description` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stk_status` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
  `stk_add_minus` int(1) DEFAULT NULL,
  `stk_amount` int(8) DEFAULT NULL,
  `stk_date_time` datetime DEFAULT NULL,
  `stk_month` int(2) DEFAULT NULL,
  `stk_year` int(4) DEFAULT NULL,
  `stk_created_date_time` datetime DEFAULT NULL,
  `stk_created_by` int(8) DEFAULT NULL,
  `stk_last_update_date_time` datetime DEFAULT NULL,
  `stk_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`stk_stock_ID`),
  KEY `yearPeriod` (`stk_month`,`stk_year`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of stock
-- ----------------------------
INSERT INTO `stock` VALUES ('21', '1', 'Transaction', 'Initial', 'Pending', '1', '5', '2018-10-02 10:42:27', '10', '2018', '2018-10-02 10:42:27', '1', null, null);
INSERT INTO `stock` VALUES ('22', '3', 'Transaction', 'Initial', 'Pending', '1', '4', '2018-10-02 10:42:49', '10', '2018', '2018-10-02 10:42:49', '1', null, null);
INSERT INTO `stock` VALUES ('37', '1', 'Transaction', 'Agreement AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:25:35', '10', '2018', '2018-10-02 11:25:35', '1', null, null);
INSERT INTO `stock` VALUES ('38', '3', 'Transaction', 'Agreement AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:25:35', '10', '2018', '2018-10-02 11:25:35', '1', null, null);
INSERT INTO `stock` VALUES ('39', '1', 'Transaction', 'Agreement UnLockAGR-000064', 'Pending', '1', '1', '2018-10-02 11:27:24', '10', '2018', '2018-10-02 11:27:24', '1', null, null);
INSERT INTO `stock` VALUES ('40', '3', 'Transaction', 'Agreement UnLockAGR-000064', 'Pending', '1', '1', '2018-10-02 11:27:24', '10', '2018', '2018-10-02 11:27:24', '1', null, null);
INSERT INTO `stock` VALUES ('41', '1', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:28:08', '10', '2018', '2018-10-02 11:28:08', '1', null, null);
INSERT INTO `stock` VALUES ('42', '3', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:28:08', '10', '2018', '2018-10-02 11:28:08', '1', null, null);
INSERT INTO `stock` VALUES ('43', '1', 'Transaction', 'Agreement UnLockAGR-000064', 'Pending', '1', '1', '2018-10-02 11:28:13', '10', '2018', '2018-10-02 11:28:13', '1', null, null);
INSERT INTO `stock` VALUES ('44', '3', 'Transaction', 'Agreement UnLockAGR-000064', 'Pending', '1', '1', '2018-10-02 11:28:13', '10', '2018', '2018-10-02 11:28:13', '1', null, null);
INSERT INTO `stock` VALUES ('45', '1', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:36:38', '10', '2018', '2018-10-02 11:36:38', '1', null, null);
INSERT INTO `stock` VALUES ('46', '3', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:36:38', '10', '2018', '2018-10-02 11:36:38', '1', null, null);
INSERT INTO `stock` VALUES ('47', '1', 'Transaction', 'Agreement UnLock AGR-000064', 'Pending', '1', '1', '2018-10-02 11:46:48', '10', '2018', '2018-10-02 11:46:48', '1', null, null);
INSERT INTO `stock` VALUES ('48', '3', 'Transaction', 'Agreement UnLock AGR-000064', 'Pending', '1', '1', '2018-10-02 11:46:48', '10', '2018', '2018-10-02 11:46:48', '1', null, null);
INSERT INTO `stock` VALUES ('49', '1', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:47:02', '10', '2018', '2018-10-02 11:47:02', '1', null, null);
INSERT INTO `stock` VALUES ('50', '3', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-02 11:47:02', '10', '2018', '2018-10-02 11:47:02', '1', null, null);
INSERT INTO `stock` VALUES ('51', '1', 'Transaction', 'Agreement Lock AGR-000065', 'Pending', '-1', '1', '2018-10-02 12:00:13', '10', '2018', '2018-10-02 12:00:13', '1', null, null);
INSERT INTO `stock` VALUES ('52', '1', 'Transaction', 'Agreement Lock AGR-000065', 'Pending', '-1', '1', '2018-10-02 12:00:13', '10', '2018', '2018-10-02 12:00:13', '1', null, null);
INSERT INTO `stock` VALUES ('53', '1', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-05 14:49:30', '10', '2018', '2018-10-05 14:49:30', '1', null, null);
INSERT INTO `stock` VALUES ('54', '3', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-05 14:49:30', '10', '2018', '2018-10-05 14:49:30', '1', null, null);
INSERT INTO `stock` VALUES ('55', '1', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-05 16:07:25', '10', '2018', '2018-10-05 16:07:25', '1', null, null);
INSERT INTO `stock` VALUES ('56', '3', 'Transaction', 'Agreement Lock AGR-000064', 'Pending', '-1', '1', '2018-10-05 16:07:25', '10', '2018', '2018-10-05 16:07:25', '1', null, null);
INSERT INTO `stock` VALUES ('57', '3', 'Transaction', 'Agreement Lock AGR-000065', 'Pending', '-1', '1', '2018-10-05 16:29:28', '10', '2018', '2018-10-05 16:29:28', '1', null, null);
INSERT INTO `stock` VALUES ('58', '1', 'Transaction', 'Manual', 'Pending', '1', '10', '2018-10-09 12:00:54', '10', '2018', '2018-10-09 12:00:54', '1', null, null);
INSERT INTO `stock` VALUES ('59', '3', 'Transaction', 'Manual', 'Pending', '1', '10', '2018-10-09 12:01:07', '10', '2018', '2018-10-09 12:01:07', '1', null, null);
INSERT INTO `stock` VALUES ('60', '1', 'Transaction', 'Agreement Lock AGR-000070', 'Pending', '-1', '1', '2018-10-15 11:59:10', '10', '2018', '2018-10-15 11:59:10', '1', null, null);
INSERT INTO `stock` VALUES ('62', '1', 'Transaction', 'Policy AGR-000070-Renewal-Deleted line', 'Pending', '1', '1', '2018-10-16 14:29:45', '10', '2018', '2018-10-16 14:29:45', '1', null, null);
INSERT INTO `stock` VALUES ('63', '1', 'Transaction', 'Agreement Lock AGR-000071', 'Pending', '-1', '1', '2018-10-16 16:06:53', '10', '2018', '2018-10-16 16:06:54', '1', null, null);
INSERT INTO `stock` VALUES ('67', '1', 'Transaction', 'Agreement Lock AGR-000071', 'Pending', '1', '1', '2018-10-17 19:37:42', '10', '2018', '2018-10-17 19:37:42', '1', null, null);
INSERT INTO `stock` VALUES ('68', '1', 'Transaction', 'Agreement UnLock AGR-000071', 'Pending', '-1', '1', '2018-10-17 19:38:02', '10', '2018', '2018-10-17 19:38:02', '1', null, null);
INSERT INTO `stock` VALUES ('69', '1', 'Transaction', 'Agreement Lock AGR-000071', 'Pending', '1', '1', '2018-10-17 19:58:08', '10', '2018', '2018-10-17 19:58:08', '1', null, null);
INSERT INTO `stock` VALUES ('70', '1', 'Transaction', 'Agreement UnLock AGR-000071', 'Pending', '-1', '1', '2018-10-17 20:01:28', '10', '2018', '2018-10-17 20:01:28', '1', null, null);
INSERT INTO `stock` VALUES ('71', '1', 'Transaction', 'Agreement Lock AGR-000072', 'Pending', '-1', '1', '2018-10-17 20:07:38', '10', '2018', '2018-10-17 20:07:38', '1', null, null);
INSERT INTO `stock` VALUES ('72', '1', 'Transaction', 'Agreement Lock AGR-000072', 'Pending', '-1', '1', '2018-10-17 20:07:38', '10', '2018', '2018-10-17 20:07:38', '1', null, null);
INSERT INTO `stock` VALUES ('73', '1', 'Transaction', 'Manual', 'Pending', '1', '2', '2018-10-17 20:30:21', '10', '2018', '2018-10-17 20:30:21', '1', null, null);
INSERT INTO `stock` VALUES ('74', '1', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '-1', '1', '2018-10-17 20:30:55', '10', '2018', '2018-10-17 20:30:55', '1', null, null);
INSERT INTO `stock` VALUES ('75', '3', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '-1', '1', '2018-10-17 20:30:55', '10', '2018', '2018-10-17 20:30:55', '1', null, null);
INSERT INTO `stock` VALUES ('76', '1', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '-1', '1', '2018-10-17 20:39:42', '10', '2018', '2018-10-17 20:39:42', '1', null, null);
INSERT INTO `stock` VALUES ('77', '3', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '1', '1', '2018-10-17 20:43:03', '10', '2018', '2018-10-17 20:43:03', '1', null, null);
INSERT INTO `stock` VALUES ('78', '1', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '1', '1', '2018-10-17 20:51:25', '10', '2018', '2018-10-17 20:51:25', '1', null, null);
INSERT INTO `stock` VALUES ('79', '1', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '-1', '1', '2018-10-17 20:51:25', '10', '2018', '2018-10-17 20:51:25', '1', null, null);
INSERT INTO `stock` VALUES ('80', '1', 'Transaction', 'Agreement UnLock AGR-000073', 'Pending', '-1', '1', '2018-10-17 20:51:46', '10', '2018', '2018-10-17 20:51:46', '1', null, null);
INSERT INTO `stock` VALUES ('81', '1', 'Transaction', 'Agreement UnLock AGR-000073', 'Pending', '1', '1', '2018-10-17 20:51:46', '10', '2018', '2018-10-17 20:51:46', '1', null, null);
INSERT INTO `stock` VALUES ('82', '1', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '1', '1', '2018-10-17 20:52:05', '10', '2018', '2018-10-17 20:52:05', '1', null, null);
INSERT INTO `stock` VALUES ('83', '1', 'Transaction', 'Agreement Lock AGR-000073', 'Pending', '-1', '1', '2018-10-17 20:52:05', '10', '2018', '2018-10-17 20:52:05', '1', null, null);
INSERT INTO `stock` VALUES ('84', '1', 'Transaction', 'Manual', 'Pending', '1', '2', '2018-10-17 21:35:23', '10', '2018', '2018-10-17 21:35:23', '1', null, null);
INSERT INTO `stock` VALUES ('85', '1', 'Transaction', 'Agreement Lock AGR-000074', 'Pending', '-1', '1', '2018-10-17 21:40:45', '10', '2018', '2018-10-17 21:40:45', '1', null, null);
INSERT INTO `stock` VALUES ('86', '1', 'Transaction', 'Agreement Lock AGR-000074', 'Pending', '-1', '1', '2018-10-17 21:40:45', '10', '2018', '2018-10-17 21:40:45', '1', null, null);
INSERT INTO `stock` VALUES ('87', '3', 'Transaction', 'Agreement Lock AGR-000074', 'Pending', '-1', '1', '2018-10-17 21:40:45', '10', '2018', '2018-10-17 21:40:45', '1', null, null);
INSERT INTO `stock` VALUES ('88', '1', 'Transaction', 'Agreement Lock AGR-000074', 'Pending', '1', '1', '2018-10-17 21:42:12', '10', '2018', '2018-10-17 21:42:12', '1', null, null);
INSERT INTO `stock` VALUES ('89', '1', 'Transaction', 'Agreement Lock AGR-000074', 'Pending', '1', '1', '2018-10-17 21:43:28', '10', '2018', '2018-10-17 21:43:28', '1', null, null);
INSERT INTO `stock` VALUES ('90', '1', 'Transaction', 'Agreement Lock AGR-000074', 'Pending', '-1', '1', '2018-10-17 23:57:18', '10', '2018', '2018-10-17 23:57:18', '1', null, null);
INSERT INTO `stock` VALUES ('91', '1', 'Transaction', 'Agreement Lock AGR-000075', 'Pending', '-1', '1', '2018-11-05 13:13:07', '11', '2018', '2018-11-05 13:13:07', '1', null, null);
INSERT INTO `stock` VALUES ('92', '3', 'Transaction', 'Agreement Lock AGR-000075', 'Pending', '-1', '1', '2018-11-05 13:13:07', '11', '2018', '2018-11-05 13:13:07', '1', null, null);
INSERT INTO `stock` VALUES ('93', '3', 'Transaction', 'Agreement Lock AGR-000076', 'Pending', '-1', '1', '2018-11-29 22:35:37', '11', '2018', '2018-11-29 22:35:37', '1', null, null);
INSERT INTO `stock` VALUES ('94', '2', 'Transaction', 'Initial', 'Pending', '1', '3', '2018-12-12 15:12:50', '12', '2018', '2018-12-12 15:12:50', '1', null, null);
INSERT INTO `stock` VALUES ('95', '8', 'Transaction', 'Initial', 'Pending', '1', '10', '2018-12-12 15:13:08', '12', '2018', '2018-12-12 15:13:08', '1', null, null);
INSERT INTO `stock` VALUES ('96', '9', 'Transaction', 'Initial', 'Pending', '1', '15', '2018-12-12 15:13:19', '12', '2018', '2018-12-12 15:13:19', '1', null, null);
INSERT INTO `stock` VALUES ('97', '10', 'Transaction', 'Initial', 'Pending', '1', '15', '2018-12-12 15:13:28', '12', '2018', '2018-12-12 15:13:28', '1', null, null);
INSERT INTO `stock` VALUES ('98', '7', 'Transaction', 'Initial', 'Pending', '1', '5', '2018-12-12 15:17:32', '12', '2018', '2018-12-12 15:17:32', '1', null, null);
INSERT INTO `stock` VALUES ('99', '4', 'Transaction', 'Initial', 'Pending', '1', '5', '2018-12-12 15:17:43', '12', '2018', '2018-12-12 15:17:43', '1', null, null);
INSERT INTO `stock` VALUES ('100', '5', 'Transaction', 'Initial', 'Pending', '1', '5', '2018-12-12 15:17:52', '12', '2018', '2018-12-12 15:17:52', '1', null, null);
INSERT INTO `stock` VALUES ('101', '2', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '1', '1', '2018-12-19 15:52:31', '12', '2018', '2018-12-19 15:52:31', '1', null, null);
INSERT INTO `stock` VALUES ('102', '7', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '1', '1', '2018-12-19 15:52:31', '12', '2018', '2018-12-19 15:52:31', '1', null, null);
INSERT INTO `stock` VALUES ('103', '9', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '1', '5', '2018-12-19 15:52:31', '12', '2018', '2018-12-19 15:52:31', '1', null, null);
INSERT INTO `stock` VALUES ('104', '5', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '1', '3', '2018-12-19 15:52:31', '12', '2018', '2018-12-19 15:52:31', '1', null, null);
INSERT INTO `stock` VALUES ('105', '2', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '-1', '1', '2018-12-19 15:53:21', '12', '2018', '2018-12-19 15:53:21', '1', null, null);
INSERT INTO `stock` VALUES ('106', '7', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '-1', '1', '2018-12-19 15:53:21', '12', '2018', '2018-12-19 15:53:21', '1', null, null);
INSERT INTO `stock` VALUES ('107', '9', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '-1', '5', '2018-12-19 15:53:21', '12', '2018', '2018-12-19 15:53:21', '1', null, null);
INSERT INTO `stock` VALUES ('108', '5', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '-1', '3', '2018-12-19 15:53:21', '12', '2018', '2018-12-19 15:53:21', '1', null, null);
INSERT INTO `stock` VALUES ('109', '2', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '1', '2018-12-19 15:54:36', '12', '2018', '2018-12-19 15:54:36', '1', null, null);
INSERT INTO `stock` VALUES ('110', '7', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '1', '2018-12-19 15:54:36', '12', '2018', '2018-12-19 15:54:36', '1', null, null);
INSERT INTO `stock` VALUES ('111', '9', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '5', '2018-12-19 15:54:36', '12', '2018', '2018-12-19 15:54:36', '1', null, null);
INSERT INTO `stock` VALUES ('112', '5', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '3', '2018-12-19 15:54:36', '12', '2018', '2018-12-19 15:54:36', '1', null, null);
INSERT INTO `stock` VALUES ('113', '2', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '1', '2018-12-19 15:55:21', '12', '2018', '2018-12-19 15:55:21', '1', null, null);
INSERT INTO `stock` VALUES ('114', '7', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '1', '2018-12-19 15:55:21', '12', '2018', '2018-12-19 15:55:21', '1', null, null);
INSERT INTO `stock` VALUES ('115', '9', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '5', '2018-12-19 15:55:21', '12', '2018', '2018-12-19 15:55:21', '1', null, null);
INSERT INTO `stock` VALUES ('116', '5', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '3', '2018-12-19 15:55:21', '12', '2018', '2018-12-19 15:55:21', '1', null, null);
INSERT INTO `stock` VALUES ('117', '2', 'Transaction', 'Ticket:2 Make Pending', 'Pending', '-1', '1', '2018-12-19 20:10:12', '12', '2018', '2018-12-19 20:10:12', '1', null, null);
INSERT INTO `stock` VALUES ('118', '4', 'Transaction', 'Ticket:2 Make Pending', 'Pending', '-1', '1', '2018-12-19 20:10:12', '12', '2018', '2018-12-19 20:10:12', '1', null, null);
INSERT INTO `stock` VALUES ('119', '2', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '1', '2018-12-19 20:19:50', '12', '2018', '2018-12-19 20:19:50', '1', null, null);
INSERT INTO `stock` VALUES ('120', '7', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '1', '2018-12-19 20:19:50', '12', '2018', '2018-12-19 20:19:50', '1', null, null);
INSERT INTO `stock` VALUES ('121', '9', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '5', '2018-12-19 20:19:50', '12', '2018', '2018-12-19 20:19:50', '1', null, null);
INSERT INTO `stock` VALUES ('122', '5', 'Transaction', 'Ticket:1 Make Pending', 'Pending', '-1', '3', '2018-12-19 20:19:50', '12', '2018', '2018-12-19 20:19:50', '1', null, null);
INSERT INTO `stock` VALUES ('123', '2', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:41:04', '1', '2019', '2019-01-04 17:41:04', '1', null, null);
INSERT INTO `stock` VALUES ('124', '7', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:41:04', '1', '2019', '2019-01-04 17:41:04', '1', null, null);
INSERT INTO `stock` VALUES ('125', '9', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:41:04', '1', '2019', '2019-01-04 17:41:04', '1', null, null);
INSERT INTO `stock` VALUES ('126', '2', 'Transaction', 'Ticket:5 Return back stock from Make Outstanding', 'Pending', '1', '1', '2019-01-04 17:44:53', '1', '2019', '2019-01-04 17:44:53', '1', null, null);
INSERT INTO `stock` VALUES ('127', '7', 'Transaction', 'Ticket:5 Return back stock from Make Outstanding', 'Pending', '1', '1', '2019-01-04 17:44:53', '1', '2019', '2019-01-04 17:44:53', '1', null, null);
INSERT INTO `stock` VALUES ('128', '9', 'Transaction', 'Ticket:5 Return back stock from Make Outstanding', 'Pending', '1', '1', '2019-01-04 17:44:53', '1', '2019', '2019-01-04 17:44:53', '1', null, null);
INSERT INTO `stock` VALUES ('129', '2', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:45:32', '1', '2019', '2019-01-04 17:45:32', '1', null, null);
INSERT INTO `stock` VALUES ('130', '7', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:45:32', '1', '2019', '2019-01-04 17:45:32', '1', null, null);
INSERT INTO `stock` VALUES ('131', '9', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:45:32', '1', '2019', '2019-01-04 17:45:32', '1', null, null);
INSERT INTO `stock` VALUES ('132', '2', 'Transaction', 'Ticket:5 Open Ticket', 'Pending', '-1', '1', '2019-01-04 17:45:32', '1', '2019', '2019-01-04 17:45:32', '1', null, null);
INSERT INTO `stock` VALUES ('133', '2', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '1', '2019-01-08 13:17:59', '1', '2019', '2019-01-08 13:17:59', '1', null, null);
INSERT INTO `stock` VALUES ('134', '7', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '1', '2019-01-08 13:17:59', '1', '2019', '2019-01-08 13:17:59', '1', null, null);
INSERT INTO `stock` VALUES ('135', '9', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '5', '2019-01-08 13:17:59', '1', '2019', '2019-01-08 13:17:59', '1', null, null);
INSERT INTO `stock` VALUES ('136', '5', 'Transaction', 'Ticket:1 Return back stock from Make Outstanding', 'Pending', '1', '3', '2019-01-08 13:17:59', '1', '2019', '2019-01-08 13:17:59', '1', null, null);
INSERT INTO `stock` VALUES ('137', '2', 'Transaction', 'Manual', 'Pending', '1', '5', '2019-01-08 13:19:15', '1', '2019', '2019-01-08 13:19:16', '1', null, null);
INSERT INTO `stock` VALUES ('138', '2', 'Transaction', 'Ticket:1 Open Ticket', 'Pending', '-1', '1', '2019-01-08 13:19:27', '1', '2019', '2019-01-08 13:19:27', '1', null, null);
INSERT INTO `stock` VALUES ('139', '7', 'Transaction', 'Ticket:1 Open Ticket', 'Pending', '-1', '1', '2019-01-08 13:19:27', '1', '2019', '2019-01-08 13:19:27', '1', null, null);
INSERT INTO `stock` VALUES ('140', '9', 'Transaction', 'Ticket:1 Open Ticket', 'Pending', '-1', '5', '2019-01-08 13:19:27', '1', '2019', '2019-01-08 13:19:27', '1', null, null);
INSERT INTO `stock` VALUES ('141', '5', 'Transaction', 'Ticket:1 Open Ticket', 'Pending', '-1', '3', '2019-01-08 13:19:27', '1', '2019', '2019-01-08 13:19:27', '1', null, null);
INSERT INTO `stock` VALUES ('142', '8', 'Transaction', 'Ticket:1 Open Ticket', 'Pending', '-1', '2', '2019-01-08 13:19:27', '1', '2019', '2019-01-08 13:19:27', '1', null, null);
INSERT INTO `stock` VALUES ('143', '7', 'Transaction', 'Ticket:4 Open Ticket', 'Pending', '-1', '1', '2019-01-08 13:34:44', '1', '2019', '2019-01-08 13:34:45', '1', null, null);
INSERT INTO `stock` VALUES ('144', '4', 'Transaction', 'Ticket:4 Open Ticket', 'Pending', '-1', '1', '2019-01-08 13:34:45', '1', '2019', '2019-01-08 13:34:45', '1', null, null);
INSERT INTO `stock` VALUES ('145', '5', 'Transaction', 'Ticket:4 Open Ticket', 'Pending', '-1', '1', '2019-01-08 13:34:45', '1', '2019', '2019-01-08 13:34:45', '1', null, null);
INSERT INTO `stock` VALUES ('146', '10', 'Transaction', 'Ticket:4 Open Ticket', 'Pending', '-1', '1', '2019-01-08 13:34:45', '1', '2019', '2019-01-08 13:34:45', '1', null, null);

-- ----------------------------
-- Table structure for tickets
-- ----------------------------
DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `tck_ticket_ID` int(8) NOT NULL AUTO_INCREMENT,
  `tck_ticket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tck_customer_ID` int(8) DEFAULT NULL,
  `tck_assigned_user_ID` int(8) DEFAULT NULL,
  `tck_status` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `tck_incident_date` date DEFAULT NULL,
  `tck_appointment_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tck_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tck_created_by` int(8) DEFAULT NULL,
  `tck_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tck_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`tck_ticket_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of tickets
-- ----------------------------
INSERT INTO `tickets` VALUES ('1', 'TCK-000003', '1', '1', 'Open', '2018-11-24', '2019-01-28 12:24:24', '2019-01-28 12:24:24', '1', '2019-01-28 12:24:24', '1');
INSERT INTO `tickets` VALUES ('2', 'TCK-000004', '1', '-1', 'Closed', '2018-12-05', '2018-12-27 17:13:43', '2018-12-27 17:13:43', '1', '2018-12-27 17:13:43', '1');
INSERT INTO `tickets` VALUES ('3', 'TCK-000005', '1', '-1', 'Deleted', '2018-12-20', '2018-12-27 17:52:49', '2018-12-27 17:52:49', '1', '2018-12-27 17:52:49', '1');
INSERT INTO `tickets` VALUES ('4', 'TCK-000006', '1', '4', 'Open', '2019-01-07', '2019-01-28 12:24:45', '2019-01-28 12:24:45', '1', '2019-01-28 12:24:45', '1');
INSERT INTO `tickets` VALUES ('5', 'TCK-000007', '2', '3', 'Open', '2019-01-04', '2019-01-04 17:45:32', '2019-01-04 17:45:32', '1', '2019-01-04 17:45:32', '1');

-- ----------------------------
-- Table structure for ticket_events
-- ----------------------------
DROP TABLE IF EXISTS `ticket_events`;
CREATE TABLE `ticket_events` (
  `tke_ticket_event_ID` int(8) NOT NULL AUTO_INCREMENT,
  `tke_ticket_ID` int(8) DEFAULT NULL,
  `tke_user_ID` int(8) DEFAULT NULL,
  `tke_unique_serial_ID` int(8) DEFAULT NULL,
  `tke_type` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `tke_incident_date` date DEFAULT NULL,
  `tke_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tke_created_by` int(8) DEFAULT NULL,
  `tke_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tke_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`tke_ticket_event_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ticket_events
-- ----------------------------
INSERT INTO `ticket_events` VALUES ('1', '1', '1', '15', 'MachineService', '2018-11-14', null, null, null, null);
INSERT INTO `ticket_events` VALUES ('2', '1', '1', '15', 'MachineError', '2018-11-14', null, null, null, null);
INSERT INTO `ticket_events` VALUES ('3', '1', '1', '18', 'MachineService', '2018-11-24', null, null, null, null);
INSERT INTO `ticket_events` VALUES ('4', '2', '1', '15', 'MachineError', '2018-12-05', null, null, null, null);
INSERT INTO `ticket_events` VALUES ('5', '5', '1', '15', 'MachineError', '2019-01-04', '2019-01-04 17:39:03', '1', null, null);
INSERT INTO `ticket_events` VALUES ('6', '5', '1', '18', 'MachineService', '2019-01-04', '2019-01-04 17:45:08', '1', null, null);
INSERT INTO `ticket_events` VALUES ('7', '4', '1', '15', 'Order', '2018-12-28', '2019-01-08 13:33:42', '1', '2019-01-08 13:33:42', '1');

-- ----------------------------
-- Table structure for ticket_products
-- ----------------------------
DROP TABLE IF EXISTS `ticket_products`;
CREATE TABLE `ticket_products` (
  `tkp_ticket_product_ID` int(8) NOT NULL AUTO_INCREMENT,
  `tkp_ticket_ID` int(8) DEFAULT NULL,
  `tkp_product_ID` int(8) DEFAULT NULL,
  `tkp_ticket_event_ID` int(8) DEFAULT NULL,
  `tkp_type` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `tkp_amount` int(8) DEFAULT NULL,
  `tkp_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tkp_created_by` int(8) DEFAULT NULL,
  `tkp_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tkp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`tkp_ticket_product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ticket_products
-- ----------------------------
INSERT INTO `ticket_products` VALUES ('13', '1', '2', '3', 'SparePart', '1', null, null, null, null);
INSERT INTO `ticket_products` VALUES ('14', '1', '7', '1', 'Consumable', '1', null, null, null, null);
INSERT INTO `ticket_products` VALUES ('15', '1', '9', '3', 'Other', '5', null, null, null, null);
INSERT INTO `ticket_products` VALUES ('16', '2', '2', '4', 'SparePart', '1', '2018-12-19 20:09:54', '1', '2018-12-19 20:09:54', '1');
INSERT INTO `ticket_products` VALUES ('17', '2', '4', '4', 'Consumable', '1', '2018-12-19 20:09:59', '1', '2018-12-19 20:09:59', '1');
INSERT INTO `ticket_products` VALUES ('18', '1', '5', '1', 'Consumable', '3', '2018-12-19 15:48:08', '1', null, null);
INSERT INTO `ticket_products` VALUES ('19', '5', '2', '5', 'SparePart', '1', '2019-01-04 17:40:05', '1', null, null);
INSERT INTO `ticket_products` VALUES ('20', '5', '7', '5', 'Consumable', '1', '2019-01-04 17:40:16', '1', null, null);
INSERT INTO `ticket_products` VALUES ('21', '5', '9', '5', 'Other', '1', '2019-01-04 17:40:30', '1', null, null);
INSERT INTO `ticket_products` VALUES ('22', '5', '2', '6', 'SparePart', '1', '2019-01-04 17:45:20', '1', null, null);
INSERT INTO `ticket_products` VALUES ('23', '1', '8', '2', 'SparePart', '2', '2019-01-08 13:18:39', '1', null, null);
INSERT INTO `ticket_products` VALUES ('24', '4', '7', '7', 'Consumable', '1', '2019-01-08 13:33:52', '1', null, null);
INSERT INTO `ticket_products` VALUES ('25', '4', '4', '7', 'Consumable', '1', '2019-01-08 13:33:59', '1', null, null);
INSERT INTO `ticket_products` VALUES ('26', '4', '5', '7', 'Consumable', '1', '2019-01-08 13:34:09', '1', null, null);
INSERT INTO `ticket_products` VALUES ('27', '4', '10', '7', 'Other', '1', '2019-01-08 13:34:29', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `users` VALUES ('2', '2', '1', 'Advanced User', 'advanced', 'advanced', '1', '', '', '', '', '', '', '0', '', '1', '0', '', '', '', null, null, '0', '0');
INSERT INTO `users` VALUES ('3', '3', '1', 'TEST ', '', '12345', '4', '', '', '', '', '', '', '0', '', '10', '0', 'No Group Option', '', '', '', '', '1', '0');
INSERT INTO `users` VALUES ('4', '3', '1', 'Giorgos', 'giorgos', 'giorgos', '3', '', '', '', '', '', '', '0', '', '0', '0', '', '', '', '', '', '1', '1');

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `usg_users_groups_ID` int(10) NOT NULL AUTO_INCREMENT,
  `usg_group_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `usg_permissions` text CHARACTER SET utf8,
  `usg_restrict_ip` varchar(25) CHARACTER SET utf8 NOT NULL,
  `usg_approvals` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`usg_users_groups_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('1', 'Administrators', null, '%', 'REQUEST');
INSERT INTO `users_groups` VALUES ('2', 'Advanced Users', '', '%', 'ANSWER');
INSERT INTO `users_groups` VALUES ('3', 'Agents', '', '', null);
INSERT INTO `users_groups` VALUES ('4', 'Michael', '', '', '');

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
