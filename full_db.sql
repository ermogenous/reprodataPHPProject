/*
Navicat MySQL Data Transfer

Source Server         : Mysql Local
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : reprodata

Target Server Type    : MYSQL
Target Server Version : 100130
File Encoding         : 65001

Date: 2019-06-06 13:55:59
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `agreements` VALUES ('19', '1', 'Active', 'New', '2019-03-07', '2020-03-06', 'AGR-000078', '8', '2018', '1', '0', '0', '2019-03-07 13:28:21', '1', '2019-03-07 13:29:25', '1');
INSERT INTO `agreements` VALUES ('20', '1', 'Active', 'New', '2019-03-07', '2020-03-06', 'AGR-000079', '8', '2018', '1', '0', '0', '2019-03-07 13:32:34', '1', '2019-03-07 13:32:43', '1');
INSERT INTO `agreements` VALUES ('21', '8', 'Active', 'New', '2019-03-07', '2020-03-06', 'AGR-000080', '8', '2018', '1', '0', '0', '2019-03-07 13:53:19', '1', '2019-03-07 13:53:27', '1');
INSERT INTO `agreements` VALUES ('22', '1', 'Archived', 'New', '2019-03-07', '2021-03-06', 'AGR-000081', '8', '2018', '1', '0', '23', '2019-03-07 13:59:41', '1', '2019-03-07 14:05:13', '1');
INSERT INTO `agreements` VALUES ('23', '1', 'Active', 'Renewal', '2021-03-07', '2022-03-06', 'AGR-000081', '8', '2018', '1', '22', '0', '2019-03-07 14:01:00', '1', '2019-03-07 14:05:13', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `agreement_items` VALUES ('45', '19', '1', 'Active', 'New', '1', 'Labour', '0', '0', '0', '-1', 'logistirio', '2019-03-07 13:28:21', '1', '2019-03-07 13:28:35', '1');
INSERT INTO `agreement_items` VALUES ('46', '20', '1', 'Active', 'New', '1', 'Labour', '0', '0', '0', '-1', 'dfgdgfd', '2019-03-07 13:32:34', '1', null, null);
INSERT INTO `agreement_items` VALUES ('47', '21', '11', 'Active', 'New', '1', 'Labour', '0', '0', '0', '-1', 'reg', '2019-03-07 13:53:19', '1', null, null);
INSERT INTO `agreement_items` VALUES ('48', '22', '11', 'Active', 'New', '1', 'No', '0', '0', '0', '-1', '', '2019-03-07 13:59:41', '1', '2019-03-07 14:00:09', '1');
INSERT INTO `agreement_items` VALUES ('49', '23', '11', 'Active', 'Renewal', '1', 'Labour', '0', '0', '0', '0', null, '2019-03-07 14:01:00', '1', '2019-03-07 14:01:12', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bc_basic_accounts
-- ----------------------------
INSERT INTO `bc_basic_accounts` VALUES ('1', 'Michael', 'Michael Ermogenous', 'Customer', '0', '24123456', '99420544', 'ermogenousm@gmail.com', '2019-02-11 21:17:48', '1', '2019-03-07 13:12:12', '1');
INSERT INTO `bc_basic_accounts` VALUES ('2', 'Giorgos Georgiou', 'Giorgos Georgiou', 'Customer', '0', '24123456', '99123456', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('3', 'Andreas Andreou', 'Andreas Andreou', 'Customer', '0', '24123654', '99123654', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('4', 'Andreas ', 'Andreas ', 'Customer', '0', '', '', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('5', 'Maria ', 'Maria ', 'Customer', '0', '', '', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('6', 'dfsdfsd ', 'dfsdfsd ', 'Customer', '0', '', '', '', '2019-02-11 20:58:55', '1', null, null);
INSERT INTO `bc_basic_accounts` VALUES ('7', 'Michael Ermogenous Comm.', 'Michael Ermogenous A1001 Commission A/C', 'Agent', '0', '', null, 'it@ydrogios.com.cy', '2019-02-14 09:44:52', '1', '2019-02-14 11:13:51', '1');
INSERT INTO `bc_basic_accounts` VALUES ('8', 'Giorgos Comm.', 'Giorgos A1002 Commission A/C', 'Agent', '0', '', null, '', '2019-02-14 09:44:52', '1', '2019-02-15 11:18:33', '1');
INSERT INTO `bc_basic_accounts` VALUES ('9', 'Michael Ermogenous Comm. Release', 'Michael Ermogenous A1001 Commission Release A/C', 'Agent', '0', '', null, 'it@ydrogios.com.cy', '2019-02-14 11:09:39', '1', '2019-02-14 11:13:51', '1');
INSERT INTO `bc_basic_accounts` VALUES ('10', 'Ermis Ermou', 'Ermis Ermou', 'Customer', '0', '', '', '', '2019-03-07 13:31:57', '1', null, null);

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
INSERT INTO `customers` VALUES ('1', null, '1', '786613', 'Michael', 'Ermogenous', 'add1', 'add2', '8', null, '18', '24123456', '24654321', '24010101', '99420544', '99123456', 'ermogenousm@gmail.com', 'ermogenousm@gmail.com', '5', null, null, '2019-03-07 13:12:12', '1');
INSERT INTO `customers` VALUES ('2', null, '2', '123456', 'Giorgos', 'Georgiou', '', '', '8', '', '18', '24123456', '', '', '99123456', '', '', '', '12', '2018-08-24 00:51:42', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('3', null, '3', '99887766', 'Andreas', 'Andreou', '', '', '7', 'Andreas', '16', '24123654', '', '', '99123654', '', '', '', '5', '2018-10-02 10:16:06', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('4', null, '4', '1111', 'Andreas', '', '', '', '8', '', '16', '', '', '', '', '', '', '', '4', '2019-02-10 10:37:30', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('5', null, '5', '1212', 'Maria', '', '', '', '8', '', '18', '', '', '', '', '', '', '', '12', '2019-02-10 10:40:41', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('7', null, '6', '121212', 'dfsdfsd', '', '', '', '8', '', '18', '', '', '', '', '', '', '', '12', '2019-02-11 20:56:58', '1', '2019-02-11 20:58:55', '1');
INSERT INTO `customers` VALUES ('8', null, '10', '4534543', 'Ermis', 'Ermou', '', '', '8', '', '19', '', '', '', '', '', '', '', '5', '2019-03-07 13:31:57', '1', '2019-03-07 13:31:57', '1');

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
  `inapol_agent_ID` int(8) DEFAULT NULL,
  `inapol_insurance_company_ID` int(8) DEFAULT NULL,
  `inapol_customer_ID` int(8) DEFAULT NULL,
  `inapol_type_code` varchar(12) COLLATE utf8_bin DEFAULT NULL COMMENT 'Motor, Fire, EL, PL, PA, PI,',
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
  `inapol_created_date_time` datetime DEFAULT NULL,
  `inapol_created_by` int(8) DEFAULT NULL,
  `inapol_last_update_date_time` datetime DEFAULT NULL,
  `inapol_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapol_policy_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policies
-- ----------------------------
INSERT INTO `ina_policies` VALUES ('3', '0', '1', '1', '1', '1', '123456789', '2019-01-01', '2019-01-01', '2019-12-31', 'Active', null, '184', '11.43', '34', '20.57', '2', '2019-04-22 11:58:43', '1', '2019-04-22 11:58:43', '1');
INSERT INTO `ina_policies` VALUES ('4', '0', '0', null, '0', null, '', '0000-00-00', '0000-00-00', '0000-00-00', 'Outstanding', null, null, null, null, null, null, '2019-04-22 12:48:04', '1', null, null);
INSERT INTO `ina_policies` VALUES ('5', '0', '1', '23', '1', 'Motor', '1901-001234', '2019-04-26', '2019-04-26', '2019-05-25', 'Active', null, null, null, null, null, null, '2019-04-26 19:04:11', '1', '2019-04-26 19:04:11', '1');
INSERT INTO `ina_policies` VALUES ('6', '0', '1', '23', '1', 'Motor', '1901-001235', '2019-05-01', '2019-05-01', '2020-04-30', 'Active', null, '175', '5.65', '25', '20', '2', '2019-05-01 18:55:58', '1', '2019-05-01 18:55:58', '1');
INSERT INTO `ina_policies` VALUES ('7', '0', '1', '1', '1', 'Motor', '1901-123456', '2019-05-27', '2019-05-27', '2020-05-26', 'Outstanding', null, '200', '6', null, null, null, '2019-05-29 14:33:37', '1', '2019-05-29 14:33:37', '1');
INSERT INTO `ina_policies` VALUES ('8', '0', '1', '1', '1', 'Motor', '123456789', '2019-05-29', '2019-05-29', '2020-05-28', 'Active', null, '200', '6', '50', '25', '2', '2019-05-29 15:05:16', '1', '2019-05-29 15:05:16', '1');

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
  `inapi_paid_commission_amount` double DEFAULT '0',
  `inapi_created_date_time` datetime DEFAULT NULL,
  `inapi_created_by` int(8) DEFAULT NULL,
  `inapi_last_update_date_time` datetime DEFAULT NULL,
  `inapi_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapi_policy_installments_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_installments
-- ----------------------------
INSERT INTO `ina_policy_installments` VALUES ('117', '3', 'Paid', '2019-03-07', '2019-01-01', null, '54.5', '46', '8.5', '6', '2019-04-22 11:54:12', '1', '2019-04-22 11:54:12', '1');
INSERT INTO `ina_policy_installments` VALUES ('118', '3', 'Partial', '2019-03-07', '2019-02-01', null, '54.5', '4', '8.5', '0', '2019-04-22 11:54:12', '1', '2019-04-22 11:54:12', '1');
INSERT INTO `ina_policy_installments` VALUES ('119', '3', 'UnPaid', '2019-03-07', '2019-03-01', null, '54.5', '0', '8.5', '0', '2019-05-29 13:02:18', '1', '2019-05-29 13:02:18', '1');
INSERT INTO `ina_policy_installments` VALUES ('120', '3', 'UnPaid', '2019-03-07', '2019-04-01', null, '54.5', '0', '8.5', '0', '2019-05-29 13:02:19', '1', '2019-05-29 13:02:19', '1');
INSERT INTO `ina_policy_installments` VALUES ('136', '6', 'UnPaid', '2019-05-01', '2019-05-01', null, '67.55', '0', '8.34', '0', '2019-05-29 14:30:51', '1', '2019-05-29 14:30:51', '1');
INSERT INTO `ina_policy_installments` VALUES ('137', '6', 'UnPaid', '2019-05-01', '2019-06-01', null, '67.55', '0', '8.33', '0', '2019-05-29 14:30:51', '1', '2019-05-29 14:30:51', '1');
INSERT INTO `ina_policy_installments` VALUES ('138', '6', 'UnPaid', '2019-05-01', '2019-07-01', null, '67.55', '0', '8.33', '0', '2019-05-29 13:02:20', '1', '2019-05-29 13:02:20', '1');
INSERT INTO `ina_policy_installments` VALUES ('142', '8', 'Paid', '0000-00-00', '2019-06-01', null, '58.25', '58.25', '12.5', '12.5', '2019-05-29 15:51:38', '1', '2019-05-29 16:51:00', '1');
INSERT INTO `ina_policy_installments` VALUES ('143', '8', 'Paid', '2019-05-29', '2019-06-29', null, '58.25', '58.25', '12.5', '12.5', '2019-05-29 15:52:18', '1', '2019-05-29 16:51:00', '1');
INSERT INTO `ina_policy_installments` VALUES ('144', '8', 'Partial', '2019-05-29', '2019-07-29', null, '58.25', '41.5', '12.5', '8.91', '2019-05-29 14:44:14', '1', '2019-05-29 16:51:00', '1');
INSERT INTO `ina_policy_installments` VALUES ('145', '8', 'UnPaid', '2019-05-29', '2019-08-29', null, '58.25', '0', '12.5', '0', '2019-05-29 14:44:14', '1', '2019-05-29 14:44:14', '1');

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
  `inapit_created_date_time` datetime DEFAULT NULL,
  `inapit_created_by` int(8) DEFAULT NULL,
  `inapit_last_update_date_time` datetime DEFAULT NULL,
  `inapit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapit_policy_item_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policy_items
-- ----------------------------
INSERT INTO `ina_policy_items` VALUES ('5', '3', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '0', '0', '184', '11.43', '2019-04-22 11:53:25', '1', '2019-04-22 11:53:25', '1');
INSERT INTO `ina_policy_items` VALUES ('6', '6', '', 'KWA089', '9', '2200', '13', '1999', 'IS220D', '5', '15', null, null, null, null, null, null, '5000', '200', '175', '5.65', '2019-05-01 18:55:10', '1', '2019-05-01 18:55:10', '1');
INSERT INTO `ina_policy_items` VALUES ('7', '7', 'Vehicles', 'KWA089', '9', '2200', '14', '2006', 'IS220D', '5', '15', 'Larnaka', 'apt101', '35', '7000', '10', 'House', '6000', '200', '200', '6', '2019-05-29 14:33:37', '1', '2019-05-29 14:33:37', '1');
INSERT INTO `ina_policy_items` VALUES ('8', '8', 'Vehicles', 'KWA089', '9', '1234', '13', '2006', 'IS220D', '5', '16', null, null, null, null, null, null, '6000', '200', '200', '6', '2019-05-29 14:34:53', '1', null, null);

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
  `inapp_created_date_time` datetime DEFAULT NULL,
  `inapp_created_by` int(8) DEFAULT NULL,
  `inapp_last_update_date_time` datetime DEFAULT NULL,
  `inapp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapp_policy_payment_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments
-- ----------------------------
INSERT INTO `ina_policy_payments` VALUES ('6', '3', 'Applied', '2019-03-06', '50', '6', '50', '6', '2019-04-22 11:37:51', '1', '2019-04-22 11:37:51', '1');
INSERT INTO `ina_policy_payments` VALUES ('7', '6', 'Outstanding', '2019-05-29', '50', '12', '0', '0', '2019-05-29 14:30:51', '1', '2019-05-29 14:30:51', '1');
INSERT INTO `ina_policy_payments` VALUES ('8', '6', 'Outstanding', '2019-05-29', '50', '5', '0', '0', '2019-05-29 14:30:39', '1', '2019-05-29 14:30:39', '1');
INSERT INTO `ina_policy_payments` VALUES ('15', '8', 'Applied', '2019-05-29', '30', null, '30', '6.44', '2019-05-29 16:15:18', '1', '2019-05-29 16:50:25', '1');
INSERT INTO `ina_policy_payments` VALUES ('16', '8', 'Applied', '2019-05-29', '28', null, '28', '6.01', '2019-05-29 16:15:32', '1', '2019-05-29 16:50:31', '1');
INSERT INTO `ina_policy_payments` VALUES ('17', '8', 'Applied', '2019-05-29', '100', null, '100', '33.91', '2019-05-29 16:17:13', '1', '2019-05-29 16:51:00', '1');

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
  `inappl_created_date_time` datetime DEFAULT NULL,
  `inappl_created_by` int(8) DEFAULT NULL,
  `inappl_last_update_date_time` datetime DEFAULT NULL,
  `inappl_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inappl_policy_payments_line_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments_lines
-- ----------------------------
INSERT INTO `ina_policy_payments_lines` VALUES ('1', '6', '117', '0', '46', '0', '6', 'UnPaid', 'Paid', '2019-04-22 11:37:51', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('2', '6', '118', '0', '4', '0', '0', 'UnPaid', 'Partial', '2019-04-22 11:37:51', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('37', '15', '142', '0', '30', '0', '6.44', 'UnPaid', 'Partial', '2019-05-29 16:50:25', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('38', '16', '142', '30', '58', '6.44', '12.45', 'Partial', 'Partial', '2019-05-29 16:50:31', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('39', '17', '142', '58', '58.25', '12.45', '12.5', 'Partial', 'Paid', '2019-05-29 16:51:00', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('40', '17', '143', '0', '58.25', '0', '12.5', 'UnPaid', 'Paid', '2019-05-29 16:51:00', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('41', '17', '144', '0', '41.5', '0', '8.91', 'UnPaid', 'Partial', '2019-05-29 16:51:00', '1', null, null);

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
  `inaund_created_date_time` datetime DEFAULT NULL,
  `inaund_created_by` int(8) DEFAULT NULL,
  `inaund_last_update_date_time` datetime DEFAULT NULL,
  `inaund_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inaund_underwriter_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_underwriters
-- ----------------------------
INSERT INTO `ina_underwriters` VALUES ('1', '1', 'Active', '1', '1', '0', '0', '0', '1', '0', null, null, '2019-05-27 18:11:50', '1');
INSERT INTO `ina_underwriters` VALUES ('2', '2', 'Active', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `ina_underwriters` VALUES ('4', '3', 'Active', null, null, null, null, null, null, null, null, null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

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
INSERT INTO `ina_underwriter_companies` VALUES ('25', '2', '1', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('26', '2', '3', 'Inactive', null, null, null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('27', '2', '4', 'Inactive', null, null, null, null);
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
INSERT INTO `ina_underwriter_companies` VALUES ('50', '4', '3', 'Inactive', null, null, null, null);
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
INSERT INTO `ip_locations` VALUES ('1', '::1', '', '', '', '', '', '', '2019-05-23 13:00:32');
INSERT INTO `ip_locations` VALUES ('2', '127.0.0.1', '', '', '', '', '', '', '2019-06-03 09:22:09');

-- ----------------------------
-- Table structure for lcs_disc_batch
-- ----------------------------
DROP TABLE IF EXISTS `lcs_disc_batch`;
CREATE TABLE `lcs_disc_batch` (
  `lcsdb_disc_batch_ID` int(8) NOT NULL AUTO_INCREMENT,
  `lcsdb_batch_name` varchar(50) DEFAULT NULL,
  `lcsdb_link_name` varchar(100) DEFAULT NULL,
  `lcsdb_status` varchar(12) DEFAULT NULL,
  `lcsdb_max_tests` int(4) DEFAULT NULL,
  `lcsdb_used_tests` int(4) DEFAULT '0',
  `lcsdb_created_date_time` datetime DEFAULT NULL,
  `lcsdb_created_by` int(8) DEFAULT NULL,
  `lcsdb_last_update_date_time` datetime DEFAULT NULL,
  `lcsdb_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`lcsdb_disc_batch_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lcs_disc_batch
-- ----------------------------
INSERT INTO `lcs_disc_batch` VALUES ('1', 'Test Company', 'testCompanyDiscTest', 'Outstanding', '5', '2', '2019-05-03 12:26:00', '1', '2019-05-03 13:22:31', '1');
INSERT INTO `lcs_disc_batch` VALUES ('2', 'fdssdf', 'testtest', 'Outstanding', '12', '1', '2019-05-03 13:31:01', '1', '2019-05-03 13:31:13', '1');
INSERT INTO `lcs_disc_batch` VALUES ('3', 'Another Test', 'My Mic Test', 'Completed', '3', '3', '2019-05-05 12:35:31', '1', '2019-05-05 12:47:19', '1');

-- ----------------------------
-- Table structure for lcs_disc_test
-- ----------------------------
DROP TABLE IF EXISTS `lcs_disc_test`;
CREATE TABLE `lcs_disc_test` (
  `lcsdc_disc_test_ID` int(8) NOT NULL AUTO_INCREMENT,
  `lcsdc_batch_ID` int(8) DEFAULT '0',
  `lcsdc_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_tel` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `lcsdc_company_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
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
  `lcsdc_created_date_time` datetime DEFAULT NULL,
  `lcsdc_created_by` int(8) DEFAULT NULL,
  `lcsdc_last_update_date_time` datetime DEFAULT NULL,
  `lcsdc_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`lcsdc_disc_test_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of lcs_disc_test
-- ----------------------------
INSERT INTO `lcs_disc_test` VALUES ('1', '0', 'Michael Ermogenous', '99420544', 'micacca@gmail.com', null, 'Completed', 'UnPaid', 'B', 'B', 'A', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'B', 'A', 'A', 'A', 'B', 'B', 'B', 'A', 'B', 'B', 'B', 'B', 'A', 'A', 'B', 'A', 'A', 'A', '2019-02-19 09:52:18', '1', '2019-03-27 10:09:14', '1');
INSERT INTO `lcs_disc_test` VALUES ('2', '0', 'Test', '1233333', 'micacca@gmail.com', null, 'Outstanding', 'UnPaid', 'A', 'A', 'A', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'B', '2019-02-28 11:40:23', '1', '2019-02-28 11:40:23', '1');
INSERT INTO `lcs_disc_test` VALUES ('3', '0', 'Andreas Andreou', '123456789', 'fsddfsa@gdfsd.com', null, 'Outstanding', 'UnPaid', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'B', 'B', 'B', 'A', 'B', 'A', 'A', 'B', 'A', 'B', 'B', 'A', 'B', 'B', 'A', '2019-02-19 10:05:27', '1', '2019-02-19 10:05:27', '1');
INSERT INTO `lcs_disc_test` VALUES ('4', '0', 'Michalis Ermogenous', '99420544', 'micacca@gmail.com', null, 'Completed', 'Paid', 'B', 'A', 'A', 'B', 'A', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'A', 'B', 'A', 'A', 'B', 'B', 'A', 'A', '2019-02-19 10:22:10', '1', '2019-02-19 10:22:10', '1');
INSERT INTO `lcs_disc_test` VALUES ('5', '0', 'Charis', '', 'email@email.com', null, 'Outstanding', 'Free', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-02-19 09:50:48', '1', '2019-02-19 09:50:48', '1');
INSERT INTO `lcs_disc_test` VALUES ('6', '0', 'Another', '', '', null, 'Deleted', 'Paid', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-02-19 09:58:17', '1', '2019-04-09 12:02:08', '1');
INSERT INTO `lcs_disc_test` VALUES ('7', '0', 'Andreas Andreou', '123456789', 'micacca@gmail.com', null, 'Completed', 'Paid', 'B', 'B', 'A', 'A', 'A', 'B', 'A', 'A', 'B', 'B', 'B', 'A', 'A', 'A', 'B', 'B', 'B', 'A', 'A', 'B', 'A', 'B', 'A', 'A', 'A', 'A', 'A', 'A', '2019-02-21 13:24:40', '0', '2019-02-21 13:24:40', '1');
INSERT INTO `lcs_disc_test` VALUES ('8', '0', 'Anthimoullis', '', 'ant@ant.com', null, 'Completed', 'Free', 'A', 'B', 'B', 'B', 'A', 'A', 'B', 'A', 'B', 'A', 'B', 'A', 'A', 'A', 'B', 'B', 'A', 'A', 'A', 'B', 'B', 'B', 'B', 'A', 'B', 'A', 'A', 'B', '2019-03-12 11:45:26', '1', '2019-03-12 11:45:26', '1');
INSERT INTO `lcs_disc_test` VALUES ('9', '0', 'υτρτυθτυ', '', 'test@test.com', 'safdsf company', 'Outstanding', 'UnPaid', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-02 10:34:17', '1', '2019-05-03 13:41:58', '1');
INSERT INTO `lcs_disc_test` VALUES ('10', '1', 'test batch', '99420544', 'mike@mike.com', 'test company', 'Outstanding', null, 'A', 'B', 'A', 'B', 'B', 'A', 'A', 'A', 'B', 'B', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-03 14:04:11', '0', null, null);
INSERT INTO `lcs_disc_test` VALUES ('11', '1', 'test batch2', '99420544', 'mike@mike.com', 'test company', 'Outstanding', null, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-03 14:12:15', '0', null, null);
INSERT INTO `lcs_disc_test` VALUES ('12', '2', 'mic', '99420544', 'mic@mic.mic', 'micmic', 'Completed', null, 'A', 'A', 'A', 'B', 'A', 'B', 'B', 'A', 'A', 'B', 'A', 'B', 'B', 'A', 'A', 'A', 'A', 'A', 'A', 'B', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '2019-05-05 12:10:10', '0', '2019-05-05 12:15:17', '0');
INSERT INTO `lcs_disc_test` VALUES ('13', '3', 'dsafsa', '99420544', 'mike@mike.com', 'test company', 'Outstanding', null, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-05 12:41:07', '0', null, null);
INSERT INTO `lcs_disc_test` VALUES ('14', '3', 'test batch', '99420544', 'mike@mike.com', 'test company', 'Outstanding', null, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-05 12:42:05', '0', null, null);
INSERT INTO `lcs_disc_test` VALUES ('15', '3', 'test batch', '99420544', 'micacca@gmail.com', 'test company', 'Outstanding', 'UnPaid', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-05 12:42:52', '0', '2019-06-05 10:15:01', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=4789 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of log_file
-- ----------------------------
INSERT INTO `log_file` VALUES ('4762', '1', '::1', '2019-06-03 12:47:11', 'Error', '0', 'Reprodata Development Section:', 0x557365725B49445D3A4D69636861656C2045726D6F67656E6F75735B315D, 0x245F4745542D3E41727261790A280A290A5C6E245F504F53542D3E41727261790A280A202020205B66696C7465725F757365725F616374696F6E5D203D3E206368616E67650A202020205B66696C7465725F757365725F73656C65637465645D203D3E20320A202020205B666C745F6E756D6265725D203D3E200A202020205B66696C7465725D203D3E2046696C7465720A290A, 0x53454C454354202A202C20286F71715F66656573202B206F71715F7374616D7073202B206F71715F7072656D69756D29617320636C6F5F746F74616C5F70726963652046524F4D206F71745F71756F746174696F6E7320204A4F494E20606F71745F71756F746174696F6E735F747970657360204F4E206F7171745F71756F746174696F6E735F74797065735F4944203D206F71715F71756F746174696F6E735F747970655F49442020574845524520313D31206F71715F75736572735F4944203D2032204F52444552204259206F71715F71756F746174696F6E735F49442044455343203C68723E596F75206861766520616E206572726F7220696E20796F75722053514C2073796E7461783B20636865636B20746865206D616E75616C207468617420636F72726573706F6E647320746F20796F7572204D617269614442207365727665722076657273696F6E20666F72207468652072696768742073796E74617820746F20757365206E65617220276F71715F75736572735F4944203D2032204F52444552204259206F71715F71756F746174696F6E735F4944204445534327206174206C696E652031);
INSERT INTO `log_file` VALUES ('4763', '1', '::1', '2019-06-03 12:49:13', 'Error', '0', 'Reprodata Development Section:', 0x557365725B49445D3A4D69636861656C2045726D6F67656E6F75735B315D, 0x245F4745542D3E41727261790A280A290A5C6E245F504F53542D3E41727261790A280A202020205B66696C7465725F757365725F616374696F6E5D203D3E206368616E67650A202020205B66696C7465725F757365725F73656C65637465645D203D3E20414C4C0A202020205B666C745F6E756D6265725D203D3E200A202020205B66696C7465725D203D3E2046696C7465720A290A, 0x53454C454354202A202C20286F71715F66656573202B206F71715F7374616D7073202B206F71715F7072656D69756D29617320636C6F5F746F74616C5F70726963652046524F4D206F71745F71756F746174696F6E7320204A4F494E20606F71745F71756F746174696F6E735F747970657360204F4E206F7171745F71756F746174696F6E735F74797065735F4944203D206F71715F71756F746174696F6E735F747970655F49442020574845524520313D3120414E44206F71715F75736572735F4944203D20414C4C204F52444552204259206F71715F71756F746174696F6E735F49442044455343203C68723E596F75206861766520616E206572726F7220696E20796F75722053514C2073796E7461783B20636865636B20746865206D616E75616C207468617420636F72726573706F6E647320746F20796F7572204D617269614442207365727665722076657273696F6E20666F72207468652072696768742073796E74617820746F20757365206E65617220274F52444552204259206F71715F71756F746174696F6E735F4944204445534327206174206C696E652031);
INSERT INTO `log_file` VALUES ('4764', '1', '::1', '2019-06-03 12:49:29', 'Error', '0', 'Reprodata Development Section:', 0x557365725B49445D3A4D69636861656C2045726D6F67656E6F75735B315D, 0x245F4745542D3E41727261790A280A290A5C6E245F504F53542D3E41727261790A280A202020205B66696C7465725F757365725F616374696F6E5D203D3E206368616E67650A202020205B66696C7465725F757365725F73656C65637465645D203D3E20414C4C0A202020205B666C745F6E756D6265725D203D3E200A202020205B66696C7465725D203D3E2046696C7465720A290A, 0x53454C454354202A202C20286F71715F66656573202B206F71715F7374616D7073202B206F71715F7072656D69756D29617320636C6F5F746F74616C5F70726963652046524F4D206F71745F71756F746174696F6E7320204A4F494E20606F71745F71756F746174696F6E735F747970657360204F4E206F7171745F71756F746174696F6E735F74797065735F4944203D206F71715F71756F746174696F6E735F747970655F49442020574845524520313D3120414E44206F71715F75736572735F4944203D20414C4C204F52444552204259206F71715F71756F746174696F6E735F49442044455343203C68723E596F75206861766520616E206572726F7220696E20796F75722053514C2073796E7461783B20636865636B20746865206D616E75616C207468617420636F72726573706F6E647320746F20796F7572204D617269614442207365727665722076657273696F6E20666F72207468652072696768742073796E74617820746F20757365206E65617220274F52444552204259206F71715F71756F746174696F6E735F4944204445534327206174206C696E652031);
INSERT INTO `log_file` VALUES ('4765', '1', '::1', '2019-06-03 12:49:37', 'Error', '0', 'Reprodata Development Section:', 0x557365725B49445D3A4D69636861656C2045726D6F67656E6F75735B315D, 0x245F4745542D3E41727261790A280A290A5C6E245F504F53542D3E41727261790A280A202020205B66696C7465725F757365725F616374696F6E5D203D3E206368616E67650A202020205B66696C7465725F757365725F73656C65637465645D203D3E20414C4C0A202020205B666C745F6E756D6265725D203D3E200A202020205B66696C7465725D203D3E2046696C7465720A290A, 0x53454C454354202A202C20286F71715F66656573202B206F71715F7374616D7073202B206F71715F7072656D69756D29617320636C6F5F746F74616C5F70726963652046524F4D206F71745F71756F746174696F6E7320204A4F494E20606F71745F71756F746174696F6E735F747970657360204F4E206F7171745F71756F746174696F6E735F74797065735F4944203D206F71715F71756F746174696F6E735F747970655F49442020574845524520313D3120414E44206F71715F75736572735F4944203D20414C4C204F52444552204259206F71715F71756F746174696F6E735F49442044455343203C68723E596F75206861766520616E206572726F7220696E20796F75722053514C2073796E7461783B20636865636B20746865206D616E75616C207468617420636F72726573706F6E647320746F20796F7572204D617269614442207365727665722076657273696F6E20666F72207468652072696768742073796E74617820746F20757365206E65617220274F52444552204259206F71715F71756F746174696F6E735F4944204445534327206174206C696E652031);
INSERT INTO `log_file` VALUES ('4766', '1', '::1', '2019-06-03 13:10:46', 'send_auto_emails', '84', 'UPDATE RECORD', 0x7361655F73656E645F726573756C74203D202730270D0A7361655F73656E645F6461746574696D65203D2027323031392D30352D3330270D0A7361655F656D61696C5F66726F6D203D20276167656E747363797072757340676D61696C2E636F6D7C7C4B656D74657220496E737572616E6365204167656E63696573205375622D4167656E63696573202620436F6E73756C74616E74732C204C696D6173736F6C202D20437970727573270D0A7361655F656D61696C5F7265706C795F746F203D20276167656E747363797072757340676D61696C2E636F6D7C7C4B656D74657220496E737572616E6365204167656E63696573205375622D4167656E63696573202620436F6E73756C74616E74732C204C696D6173736F6C202D20437970727573270D0A7361655F656D61696C5F626F6479203D20274E657720636F766572206E6F746520686173206265656E2063726561746564206279204D69636861656C2045726D6F67656E6F75733C62723E0D0A436F766572204E6F74652049443A2033353C62723E0D0A436F766572204E6F7465204E756D6265723A204B4D43453230303032303C62723E0D0A4F70656E20636F766572206E6F7465203C6120687265663D5C22687474703A2F2F6C6F63616C686F73742F726570726F646174612F64796E616D69635F71756F746174696F6E732F71756F746174696F6E735F6D6F646966792E7068703F71756F746174696F6E5F747970653D325C226174696F6E3D33355C223E486572653C2F613E3C62723E0D0A5669657720504446205265706F7274203C6120687265663D5C22687474703A2F2F6C6F63616C686F73742F726570726F646174612F64796E616D69635F71756F746174696F6E732F71756F746174696F6E5F7072696E742E7068703F71756F746174696F6E3D3335267064663D315C223E486572653C2F613E3C62723E0D0A3C62723E0D0A3C7374726F6E673E4B656D74657220496E737572616E63653C2F7374726F6E673E270D0A, 0x7361655F73656E645F726573756C74203D202731270D0A7361655F73656E645F6461746574696D65203D2027323031392D30352D33302031353A35343A3539270D0A7361655F656D61696C5F66726F6D203D20276167656E747363797072757340676D61696C2E636F6D7C7C4B656D74657220496E737572616E6365204167656E63696573205375622D4167656E636965732026616D703B20436F6E73756C74616E74732C204C696D6173736F6C202D20437970727573270D0A7361655F656D61696C5F7265706C795F746F203D20276167656E747363797072757340676D61696C2E636F6D7C7C4B656D74657220496E737572616E6365204167656E63696573205375622D4167656E636965732026616D703B20436F6E73756C74616E74732C204C696D6173736F6C202D20437970727573270D0A7361655F656D61696C5F626F6479203D20274E657720636F766572206E6F746520686173206265656E2063726561746564206279204D69636861656C2045726D6F67656E6F75733C62723E0D0A436F766572204E6F74652049443A2033353C62723E0D0A436F766572204E6F7465204E756D6265723A204B4D43453230303032303C62723E0D0A4F70656E20636F766572206E6F7465203C6120687265663D22687474703A2F2F6C6F63616C686F73742F726570726F646174612F64796E616D69635F71756F746174696F6E732F71756F746174696F6E735F6D6F646966792E7068703F71756F746174696F6E5F747970653D322671756F746174696F6E3D3335223E486572653C2F613E3C62723E0D0A5669657720504446205265706F7274203C6120687265663D22687474703A2F2F6C6F63616C686F73742F726570726F646174612F64796E616D69635F71756F746174696F6E732F71756F746174696F6E5F7072696E742E7068703F71756F746174696F6E3D3335267064663D31223E486572653C2F613E3C62723E0D0A3C62723E0D0A3C7374726F6E673E4B656D74657220496E737572616E63653C2F7374726F6E673E270D0A, 0x555044415445206073656E645F6175746F5F656D61696C736020534554200A607361655F73656E645F726573756C7460203D20273027200A2C20607361655F73656E645F6461746574696D6560203D2027323031392D30352D333027200A2C20607361655F656D61696C5F66726F6D60203D20276167656E747363797072757340676D61696C2E636F6D7C7C4B656D74657220496E737572616E6365204167656E63696573205375622D4167656E63696573202620436F6E73756C74616E74732C204C696D6173736F6C202D2043797072757327200A2C20607361655F656D61696C5F7265706C795F746F60203D20276167656E747363797072757340676D61696C2E636F6D7C7C4B656D74657220496E737572616E6365204167656E63696573205375622D4167656E63696573202620436F6E73756C74616E74732C204C696D6173736F6C202D2043797072757327200A2C20607361655F656D61696C5F626F647960203D20274E657720636F766572206E6F746520686173206265656E2063726561746564206279204D69636861656C2045726D6F67656E6F75733C62723E0D0A436F766572204E6F74652049443A2033353C62723E0D0A436F766572204E6F7465204E756D6265723A204B4D43453230303032303C62723E0D0A4F70656E20636F766572206E6F7465203C6120687265663D5C22687474703A2F2F6C6F63616C686F73742F726570726F646174612F64796E616D69635F71756F746174696F6E732F71756F746174696F6E735F6D6F646966792E7068703F71756F746174696F6E5F747970653D325C226174696F6E3D33355C223E486572653C2F613E3C62723E0D0A5669657720504446205265706F7274203C6120687265663D5C22687474703A2F2F6C6F63616C686F73742F726570726F646174612F64796E616D69635F71756F746174696F6E732F71756F746174696F6E5F7072696E742E7068703F71756F746174696F6E3D3335267064663D315C223E486572653C2F613E3C62723E0D0A3C62723E0D0A3C7374726F6E673E4B656D74657220496E737572616E63653C2F7374726F6E673E27200A574845524520607361655F73656E645F6175746F5F656D61696C735F73657269616C60203D203834);
INSERT INTO `log_file` VALUES ('4767', '1', '::1', '2019-06-03 13:12:16', 'send_auto_emails', '84', 'UPDATE RECORD', 0x7361655F73656E645F726573756C74203D202730270D0A7361655F73656E645F6461746574696D65203D2027323031392D30362D3033270D0A, 0x7361655F73656E645F726573756C74203D202731270D0A7361655F73656E645F6461746574696D65203D2027323031392D30362D30332031333A31303A3532270D0A, 0x555044415445206073656E645F6175746F5F656D61696C736020534554200A607361655F73656E645F726573756C7460203D20273027200A2C20607361655F73656E645F6461746574696D6560203D2027323031392D30362D303327200A574845524520607361655F73656E645F6175746F5F656D61696C735F73657269616C60203D203834);
INSERT INTO `log_file` VALUES ('4768', '1', '::1', '2019-06-04 14:44:38', 'codes', '23', 'UPDATE RECORD', 0x6364655F6F7074696F6E5F76616C7565203D20274F70656E270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30342031343A34343A3338270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x6364655F6F7074696F6E5F76616C7565203D2027417070726F76616C270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30342D31352031353A32353A3132270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x5550444154452060636F6465736020534554200A606364655F6F7074696F6E5F76616C756560203D20274F70656E27200A202C20606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30342031343A34343A333827200A202C20606364655F6C6173745F7570646174655F627960203D20273127200A574845524520606364655F636F64655F494460203D203233);
INSERT INTO `log_file` VALUES ('4769', '1', '::1', '2019-06-04 16:34:44', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_insurance_companies GET:Array\n(\n    [section] => agent_commission_types_insurance_companies\n    [agent] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F49442061732076616C75652C200D0A2020202020202020202020202020434F4E43415428696E61696E635F636F64652C202720272C20696E61696E635F6E616D6529206173206C6162656C2C0D0A2020202020202020202020202020696E61696E635F73746174757320617320636C6F5F7374617475730D0A202020202020202020202020202046524F4D200D0A2020202020202020202020202020696E615F756E6465727772697465725F636F6D70616E6965730D0A20202020202020202020202020204A4F494E20696E615F756E64657277726974657273204F4E20696E61756E645F756E6465727772697465725F4944203D20696E61756E635F756E6465727772697465725F49440D0A20202020202020202020202020204A4F494E20696E615F696E737572616E63655F636F6D70616E696573204F4E20696E61696E635F696E737572616E63655F636F6D70616E795F4944203D20696E61756E635F696E737572616E63655F636F6D70616E795F49440D0A202020202020202020202020202057484552450D0A2020202020202020202020202020696E61756E635F737461747573203D20274163746976652720414E440D0A2020202020202020202020202020696E61756E645F757365725F4944203D20310D0A20202020202020202020202020204C494D495420302C3235);
INSERT INTO `log_file` VALUES ('4770', '1', '::1', '2019-06-04 16:34:44', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_policy_types GET:Array\n(\n    [section] => agent_commission_types_policy_types\n    [agent] => 1\n    [inscompany] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202A0D0A20202020202020202020202046524F4D0D0A202020202020202020202020696E615F696E737572616E63655F636F6D70616E6965730D0A2020202020202020202020204A4F494E20696E615F756E6465727772697465725F636F6D70616E696573204F4E20696E61756E635F696E737572616E63655F636F6D70616E795F4944203D20696E61696E635F696E737572616E63655F636F6D70616E795F49440D0A20202020202020202020202057484552450D0A202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F4944203D202731270D0A202020202020202020202020414E4420696E61756E635F756E6465727772697465725F4944203D20273127);
INSERT INTO `log_file` VALUES ('4771', '1', '::1', '2019-06-05 08:37:17', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_insurance_companies GET:Array\n(\n    [section] => agent_commission_types_insurance_companies\n    [agent] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F49442061732076616C75652C200D0A2020202020202020202020202020434F4E43415428696E61696E635F636F64652C202720272C20696E61696E635F6E616D6529206173206C6162656C2C0D0A2020202020202020202020202020696E61696E635F73746174757320617320636C6F5F7374617475730D0A202020202020202020202020202046524F4D200D0A2020202020202020202020202020696E615F756E6465727772697465725F636F6D70616E6965730D0A20202020202020202020202020204A4F494E20696E615F756E64657277726974657273204F4E20696E61756E645F756E6465727772697465725F4944203D20696E61756E635F756E6465727772697465725F49440D0A20202020202020202020202020204A4F494E20696E615F696E737572616E63655F636F6D70616E696573204F4E20696E61696E635F696E737572616E63655F636F6D70616E795F4944203D20696E61756E635F696E737572616E63655F636F6D70616E795F49440D0A202020202020202020202020202057484552450D0A2020202020202020202020202020696E61756E635F737461747573203D20274163746976652720414E440D0A2020202020202020202020202020696E61756E645F757365725F4944203D20310D0A20202020202020202020202020204C494D495420302C3235);
INSERT INTO `log_file` VALUES ('4772', '1', '::1', '2019-06-05 08:37:17', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_policy_types GET:Array\n(\n    [section] => agent_commission_types_policy_types\n    [agent] => 1\n    [inscompany] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202A0D0A20202020202020202020202046524F4D0D0A202020202020202020202020696E615F696E737572616E63655F636F6D70616E6965730D0A2020202020202020202020204A4F494E20696E615F756E6465727772697465725F636F6D70616E696573204F4E20696E61756E635F696E737572616E63655F636F6D70616E795F4944203D20696E61696E635F696E737572616E63655F636F6D70616E795F49440D0A20202020202020202020202057484552450D0A202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F4944203D202731270D0A202020202020202020202020414E4420696E61756E635F756E6465727772697465725F4944203D20273127);
INSERT INTO `log_file` VALUES ('4773', '1', '::1', '2019-06-05 08:42:05', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_insurance_companies GET:Array\n(\n    [section] => agent_commission_types_insurance_companies\n    [agent] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F49442061732076616C75652C200D0A2020202020202020202020202020434F4E43415428696E61696E635F636F64652C202720272C20696E61696E635F6E616D6529206173206C6162656C2C0D0A2020202020202020202020202020696E61696E635F73746174757320617320636C6F5F7374617475730D0A202020202020202020202020202046524F4D200D0A2020202020202020202020202020696E615F756E6465727772697465725F636F6D70616E6965730D0A20202020202020202020202020204A4F494E20696E615F756E64657277726974657273204F4E20696E61756E645F756E6465727772697465725F4944203D20696E61756E635F756E6465727772697465725F49440D0A20202020202020202020202020204A4F494E20696E615F696E737572616E63655F636F6D70616E696573204F4E20696E61696E635F696E737572616E63655F636F6D70616E795F4944203D20696E61756E635F696E737572616E63655F636F6D70616E795F49440D0A202020202020202020202020202057484552450D0A2020202020202020202020202020696E61756E635F737461747573203D20274163746976652720414E440D0A2020202020202020202020202020696E61756E645F757365725F4944203D20310D0A20202020202020202020202020204C494D495420302C3235);
INSERT INTO `log_file` VALUES ('4774', '1', '::1', '2019-06-05 08:42:05', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_policy_types GET:Array\n(\n    [section] => agent_commission_types_policy_types\n    [agent] => 1\n    [inscompany] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202A0D0A20202020202020202020202046524F4D0D0A202020202020202020202020696E615F696E737572616E63655F636F6D70616E6965730D0A2020202020202020202020204A4F494E20696E615F756E6465727772697465725F636F6D70616E696573204F4E20696E61756E635F696E737572616E63655F636F6D70616E795F4944203D20696E61696E635F696E737572616E63655F636F6D70616E795F49440D0A20202020202020202020202057484552450D0A202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F4944203D202731270D0A202020202020202020202020414E4420696E61756E635F756E6465727772697465725F4944203D20273127);
INSERT INTO `log_file` VALUES ('4775', '1', '::1', '2019-06-05 09:29:00', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_insurance_companies GET:Array\n(\n    [section] => agent_commission_types_insurance_companies\n    [agent] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F49442061732076616C75652C200D0A2020202020202020202020202020434F4E43415428696E61696E635F636F64652C202720272C20696E61696E635F6E616D6529206173206C6162656C2C0D0A2020202020202020202020202020696E61696E635F73746174757320617320636C6F5F7374617475730D0A202020202020202020202020202046524F4D200D0A2020202020202020202020202020696E615F756E6465727772697465725F636F6D70616E6965730D0A20202020202020202020202020204A4F494E20696E615F756E64657277726974657273204F4E20696E61756E645F756E6465727772697465725F4944203D20696E61756E635F756E6465727772697465725F49440D0A20202020202020202020202020204A4F494E20696E615F696E737572616E63655F636F6D70616E696573204F4E20696E61696E635F696E737572616E63655F636F6D70616E795F4944203D20696E61756E635F696E737572616E63655F636F6D70616E795F49440D0A202020202020202020202020202057484552450D0A2020202020202020202020202020696E61756E635F737461747573203D20274163746976652720414E440D0A2020202020202020202020202020696E61756E645F757365725F4944203D20310D0A20202020202020202020202020204C494D495420302C3235);
INSERT INTO `log_file` VALUES ('4776', '1', '::1', '2019-06-05 09:29:00', 'CUSTOM', '0', 'Insurance Companies From commission Types API:agent_commission_types_policy_types GET:Array\n(\n    [section] => agent_commission_types_policy_types\n    [agent] => 1\n    [inscompany] => 1\n)\n', 0x435553544F4D, 0x435553544F4D, 0x53454C4543540D0A2020202020202020202020202A0D0A20202020202020202020202046524F4D0D0A202020202020202020202020696E615F696E737572616E63655F636F6D70616E6965730D0A2020202020202020202020204A4F494E20696E615F756E6465727772697465725F636F6D70616E696573204F4E20696E61756E635F696E737572616E63655F636F6D70616E795F4944203D20696E61696E635F696E737572616E63655F636F6D70616E795F49440D0A20202020202020202020202057484552450D0A202020202020202020202020696E61696E635F696E737572616E63655F636F6D70616E795F4944203D202731270D0A202020202020202020202020414E4420696E61756E635F756E6465727772697465725F4944203D20273127);
INSERT INTO `log_file` VALUES ('4777', '1', '::1', '2019-06-05 10:15:01', 'lcs_disc_test', '15', 'UPDATE RECORD', 0x6C637364635F656D61696C203D20276D69636163636140676D61696C2E636F6D270D0A6C637364635F70726F636573735F737461747573203D2027556E50616964270D0A606C637364635F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30352031303A31353A3031270A606C637364635F6C6173745F7570646174655F627960203D202731270A, 0x6C637364635F656D61696C203D20276D696B65406D696B652E636F6D270D0A6C637364635F70726F636573735F737461747573203D2027270D0A606C637364635F6C6173745F7570646174655F646174655F74696D6560203D2027270A606C637364635F6C6173745F7570646174655F627960203D2027270A, 0x55504441544520606C63735F646973635F746573746020534554200A606C637364635F656D61696C60203D20276D69636163636140676D61696C2E636F6D27200A2C20606C637364635F70726F636573735F73746174757360203D2027556E5061696427200A202C20606C637364635F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30352031303A31353A303127200A202C20606C637364635F6C6173745F7570646174655F627960203D20273127200A574845524520606C637364635F646973635F746573745F494460203D203135);
INSERT INTO `log_file` VALUES ('4778', '1', '::1', '2019-06-05 11:23:32', 'oqt_quotations_types', '1', 'UPDATE RECORD', 0x6F7171745F61646465645F6669656C645F63697479203D202731270D0A606F7171745F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30352031313A32333A3332270A606F7171745F6C6173745F7570646174655F627960203D202731270A, 0x6F7171745F61646465645F6669656C645F63697479203D202730270D0A606F7171745F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30352D33302031353A31363A3335270A606F7171745F6C6173745F7570646174655F627960203D202731270A, 0x55504441544520606F71745F71756F746174696F6E735F74797065736020534554200A606F7171745F61646465645F6669656C645F6369747960203D20273127200A202C20606F7171745F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30352031313A32333A333227200A202C20606F7171745F6C6173745F7570646174655F627960203D20273127200A574845524520606F7171745F71756F746174696F6E735F74797065735F494460203D2031);
INSERT INTO `log_file` VALUES ('4779', '1', '::1', '2019-06-05 16:26:06', 'oqt_items', '2', 'UPDATE RECORD', 0x6F7169745F696E73757265645F616D6F756E745F33203D2027536F6369616C205365637572697479204E756D626572204669656C642031270D0A6F7169745F696E73757265645F616D6F756E745F34203D2027536F6369616C205365637572697479204E756D626572204669656C642032270D0A6F7169745F696E73757265645F616D6F756E745F35203D2027536F6369616C205365637572697479204E756D626572204669656C642033270D0A6F7169745F726174655F34203D20274745545F46524F4D5F464F524D270D0A6F7169745F726174655F35203D20274745545F46524F4D5F464F524D270D0A606F7169745F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30352031363A32363A3036270A606F7169745F6C6173745F7570646174655F627960203D202731270A, 0x6F7169745F696E73757265645F616D6F756E745F33203D2027536F6369616C205365637572697479204E756D626572270D0A6F7169745F696E73757265645F616D6F756E745F34203D2027270D0A6F7169745F696E73757265645F616D6F756E745F35203D2027270D0A6F7169745F726174655F34203D2027270D0A6F7169745F726174655F35203D2027270D0A606F7169745F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30332D32362031303A33333A3337270A606F7169745F6C6173745F7570646174655F627960203D202731270A, 0x55504441544520606F71745F6974656D736020534554200A606F7169745F696E73757265645F616D6F756E745F3360203D2027536F6369616C205365637572697479204E756D626572204669656C64203127200A2C20606F7169745F696E73757265645F616D6F756E745F3460203D2027536F6369616C205365637572697479204E756D626572204669656C64203227200A2C20606F7169745F696E73757265645F616D6F756E745F3560203D2027536F6369616C205365637572697479204E756D626572204669656C64203327200A2C20606F7169745F726174655F3460203D20274745545F46524F4D5F464F524D27200A2C20606F7169745F726174655F3560203D20274745545F46524F4D5F464F524D27200A202C20606F7169745F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30352031363A32363A303627200A202C20606F7169745F6C6173745F7570646174655F627960203D20273127200A574845524520606F7169745F6974656D735F494460203D2032);
INSERT INTO `log_file` VALUES ('4780', '1', '::1', '2019-06-06 10:15:43', 'codes', '372', 'INSERT RECORD', 0x6364655F74797065203D20636F6465200D0A6364655F737461747573203D20416374697665200D0A6364655F7461626C655F6669656C64203D202323200D0A6364655F7461626C655F6669656C6432203D20200D0A6364655F7461626C655F6669656C6433203D20200D0A6364655F76616C7565203D204F636375706174696F6E73200D0A6364655F76616C75655F6C6162656C203D204F636375706174696F6E200D0A6364655F6F7074696F6E5F76616C7565203D203023312332233323342335200D0A6364655F6F7074696F6E5F6C6162656C203D20536F7274200D0A6364655F6F7074696F6E5F76616C75655F32203D20200D0A6364655F6F7074696F6E5F6C6162656C5F32203D20200D0A6364655F76616C75655F6C6162656C5F32203D20200D0A6364655F76616C75655F32203D20200D0A606364655F637265617465645F646174655F74696D6560203D2027323031392D30362D30362031303A31353A3433270A606364655F637265617465645F627960203D202731270A, '', 0x494E5345525420494E544F2060636F6465736020534554200A606364655F7479706560203D2027636F646527200A202C20606364655F73746174757360203D202741637469766527200A202C20606364655F7461626C655F6669656C6460203D2027232327200A202C20606364655F7461626C655F6669656C643260203D202727200A202C20606364655F7461626C655F6669656C643360203D202727200A202C20606364655F76616C756560203D20274F636375706174696F6E7327200A202C20606364655F76616C75655F6C6162656C60203D20274F636375706174696F6E27200A202C20606364655F6F7074696F6E5F76616C756560203D2027302331233223332334233527200A202C20606364655F6F7074696F6E5F6C6162656C60203D2027536F727427200A202C20606364655F6F7074696F6E5F76616C75655F3260203D202727200A202C20606364655F6F7074696F6E5F6C6162656C5F3260203D202727200A202C20606364655F76616C75655F6C6162656C5F3260203D202727200A202C20606364655F76616C75655F3260203D202727200A202C20606364655F637265617465645F646174655F74696D6560203D2027323031392D30362D30362031303A31353A343327200A202C20606364655F637265617465645F627960203D20273127200A);
INSERT INTO `log_file` VALUES ('4781', '1', '::1', '2019-06-06 10:16:14', 'codes', '373', 'INSERT RECORD', 0x6364655F74797065203D204F636375706174696F6E73200D0A6364655F737461747573203D20416374697665200D0A6364655F76616C7565203D204141414141414141200D0A6364655F76616C75655F6C6162656C203D204F636375706174696F6E200D0A6364655F76616C75655F6C6162656C5F32203D20200D0A6364655F6F7074696F6E5F76616C7565203D2030200D0A6364655F6F7074696F6E5F6C6162656C203D20536F7274200D0A6364655F6F7074696F6E5F6C6162656C5F32203D20200D0A606364655F637265617465645F646174655F74696D6560203D2027323031392D30362D30362031303A31363A3134270A606364655F637265617465645F627960203D202731270A, '', 0x494E5345525420494E544F2060636F6465736020534554200A606364655F7479706560203D20274F636375706174696F6E7327200A202C20606364655F73746174757360203D202741637469766527200A202C20606364655F76616C756560203D2027414141414141414127200A202C20606364655F76616C75655F6C6162656C60203D20274F636375706174696F6E27200A202C20606364655F76616C75655F6C6162656C5F3260203D202727200A202C20606364655F6F7074696F6E5F76616C756560203D20273027200A202C20606364655F6F7074696F6E5F6C6162656C60203D2027536F727427200A202C20606364655F6F7074696F6E5F6C6162656C5F3260203D202727200A202C20606364655F637265617465645F646174655F74696D6560203D2027323031392D30362D30362031303A31363A313427200A202C20606364655F637265617465645F627960203D20273127200A);
INSERT INTO `log_file` VALUES ('4782', '1', '::1', '2019-06-06 11:36:36', 'codes', '372', 'UPDATE RECORD', 0x6364655F76616C75655F6C6162656C5F32203D20274B656D746572204944270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A33363A3336270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x6364655F76616C75655F6C6162656C5F32203D2027270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027270A606364655F6C6173745F7570646174655F627960203D2027270A, 0x5550444154452060636F6465736020534554200A606364655F76616C75655F6C6162656C5F3260203D20274B656D74657220494427200A202C20606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A33363A333627200A202C20606364655F6C6173745F7570646174655F627960203D20273127200A574845524520606364655F636F64655F494460203D20333732);
INSERT INTO `log_file` VALUES ('4783', '1', '::1', '2019-06-06 11:36:45', 'codes', '373', 'UPDATE RECORD', 0x6364655F76616C75655F6C6162656C5F32203D20274B656D746572204944270D0A6364655F76616C75655F32203D2027313131270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A33363A3435270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x6364655F76616C75655F6C6162656C5F32203D2027270D0A6364655F76616C75655F32203D2027270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027270A606364655F6C6173745F7570646174655F627960203D2027270A, 0x5550444154452060636F6465736020534554200A606364655F76616C75655F6C6162656C5F3260203D20274B656D74657220494427200A2C20606364655F76616C75655F3260203D202731313127200A202C20606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A33363A343527200A202C20606364655F6C6173745F7570646174655F627960203D20273127200A574845524520606364655F636F64655F494460203D20333733);
INSERT INTO `log_file` VALUES ('4784', '1', '::1', '2019-06-06 11:51:48', 'codes', '372', 'UPDATE RECORD', 0x6364655F6F7074696F6E5F76616C7565203D202730233123322333233423352336233723382339233130233131233132233133270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A35313A3438270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x6364655F6F7074696F6E5F76616C7565203D20273023312332233323342335270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A33363A3336270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x5550444154452060636F6465736020534554200A606364655F6F7074696F6E5F76616C756560203D20273023312332233323342335233623372338233923313023313123313223313327200A202C20606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A35313A343827200A202C20606364655F6C6173745F7570646174655F627960203D20273127200A574845524520606364655F636F64655F494460203D20333732);
INSERT INTO `log_file` VALUES ('4785', '1', '::1', '2019-06-06 12:05:20', 'codes', '372', 'UPDATE RECORD', 0x6364655F6F7074696F6E5F76616C7565203D20273130233131233132233133233134233135233136233137233138233139233230270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031323A30353A3230270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x6364655F6F7074696F6E5F76616C7565203D202730233123322333233423352336233723382339233130233131233132233133270D0A606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031313A35313A3438270A606364655F6C6173745F7570646174655F627960203D202731270A, 0x5550444154452060636F6465736020534554200A606364655F6F7074696F6E5F76616C756560203D2027313023313123313223313323313423313523313623313723313823313923323027200A202C20606364655F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031323A30353A323027200A202C20606364655F6C6173745F7570646174655F627960203D20273127200A574845524520606364655F636F64655F494460203D20333732);
INSERT INTO `log_file` VALUES ('4786', '1', '::1', '2019-06-06 12:12:36', 'oqt_quotations', '34', 'UPDATE RECORD', 0x6F71715F737461747573203D202744656C65746564270D0A606F71715F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031323A31323A3336270A606F71715F6C6173745F7570646174655F627960203D202731270A, 0x6F71715F737461747573203D20274F75747374616E64696E67270D0A606F71715F6C6173745F7570646174655F646174655F74696D6560203D2027270A606F71715F6C6173745F7570646174655F627960203D2027270A, 0x55504441544520606F71745F71756F746174696F6E736020534554200A606F71715F73746174757360203D202744656C6574656427200A202C20606F71715F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031323A31323A333627200A202C20606F71715F6C6173745F7570646174655F627960203D20273127200A5748455245206F71715F71756F746174696F6E735F4944203D203334);
INSERT INTO `log_file` VALUES ('4787', '1', '::1', '2019-06-06 13:45:20', 'oqt_quotations_underwriters', '1', 'UPDATE RECORD', 0x6F71756E5F616C6C6F775F6D6666203D202731270D0A606F71756E5F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031333A34353A3230270A606F71756E5F6C6173745F7570646174655F627960203D202731270A, 0x6F71756E5F616C6C6F775F6D6666203D2027270D0A606F71756E5F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30332030393A33363A3134270A606F71756E5F6C6173745F7570646174655F627960203D202731270A, 0x55504441544520606F71745F71756F746174696F6E735F756E646572777269746572736020534554200A606F71756E5F616C6C6F775F6D666660203D20273127200A202C20606F71756E5F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031333A34353A323027200A202C20606F71756E5F6C6173745F7570646174655F627960203D20273127200A574845524520606F71756E5F71756F746174696F6E735F756E6465727772697465725F494460203D2031);
INSERT INTO `log_file` VALUES ('4788', '1', '::1', '2019-06-06 13:46:19', 'oqt_quotations_underwriters', '2', 'UPDATE RECORD', 0x6F71756E5F616C6C6F775F6D6666203D202731270D0A6F71756E5F616C6C6F775F6D63203D202731270D0A6F71756E5F6578636573735F67656E6572616C5F636172676F203D202730270D0A6F71756E5F6578636573735F76656869636C6573203D202730270D0A6F71756E5F6578636573735F6D616368696E657279203D202730270D0A6F71756E5F6578636573735F74656D705F6E6F5F6D656174203D202730270D0A6F71756E5F6578636573735F74656D705F6D656174203D202730270D0A6F71756E5F6578636573735F7370656369616C5F636F766572203D202730270D0A6F71756E5F6578636573735F70726F5F7061636B6564203D202730270D0A6F71756E5F6578636573735F6F776E65725F7061636B6564203D202730270D0A6F71756E5F6578636573735F6F74686572203D202730270D0A606F71756E5F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031333A34363A3139270A606F71756E5F6C6173745F7570646174655F627960203D202731270A, 0x6F71756E5F616C6C6F775F6D6666203D2027270D0A6F71756E5F616C6C6F775F6D63203D2027270D0A6F71756E5F6578636573735F67656E6572616C5F636172676F203D2027270D0A6F71756E5F6578636573735F76656869636C6573203D2027270D0A6F71756E5F6578636573735F6D616368696E657279203D2027270D0A6F71756E5F6578636573735F74656D705F6E6F5F6D656174203D2027270D0A6F71756E5F6578636573735F74656D705F6D656174203D2027270D0A6F71756E5F6578636573735F7370656369616C5F636F766572203D2027270D0A6F71756E5F6578636573735F70726F5F7061636B6564203D2027270D0A6F71756E5F6578636573735F6F776E65725F7061636B6564203D2027270D0A6F71756E5F6578636573735F6F74686572203D2027270D0A606F71756E5F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30352D30372031323A33363A3532270A606F71756E5F6C6173745F7570646174655F627960203D202731270A, 0x55504441544520606F71745F71756F746174696F6E735F756E646572777269746572736020534554200A606F71756E5F616C6C6F775F6D666660203D20273127200A2C20606F71756E5F616C6C6F775F6D6360203D20273127200A2C20606F71756E5F6578636573735F67656E6572616C5F636172676F60203D20273027200A2C20606F71756E5F6578636573735F76656869636C657360203D20273027200A2C20606F71756E5F6578636573735F6D616368696E65727960203D20273027200A2C20606F71756E5F6578636573735F74656D705F6E6F5F6D65617460203D20273027200A2C20606F71756E5F6578636573735F74656D705F6D65617460203D20273027200A2C20606F71756E5F6578636573735F7370656369616C5F636F76657260203D20273027200A2C20606F71756E5F6578636573735F70726F5F7061636B656460203D20273027200A2C20606F71756E5F6578636573735F6F776E65725F7061636B656460203D20273027200A2C20606F71756E5F6578636573735F6F7468657260203D20273027200A202C20606F71756E5F6C6173745F7570646174655F646174655F74696D6560203D2027323031392D30362D30362031333A34363A313927200A202C20606F71756E5F6C6173745F7570646174655F627960203D20273127200A574845524520606F71756E5F71756F746174696F6E735F756E6465727772697465725F494460203D2032);

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
INSERT INTO `oqt_items` VALUES ('2', '1', '2', 'mff_insurance_period_2', 'Insurance Period', 0xCEA0CEB5CF81CEAFCEBFCEB4CEBFCF8220CE91CF83CF86CEACCEBBCEB9CF83CEB7CF82, 0x506572696F64206F6620496E737572616E6365, '1', '1', 'Package Plan Selection', 'Employers Liability selection', 'Social Security Number Field 1', 'Social Security Number Field 2', 'Social Security Number Field 3', '', '', '', '', '', '', '', '', '', '', 'A100||A200||A350', 'A25', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', '', '', '', '', '', '', '', '', '', '', 'Insurance Period Start', 'Insurance Period End', null, null, null, null, '2019-06-05 16:26:06', '1');
INSERT INTO `oqt_items` VALUES ('3', '2', '1', 'mc_shipment_details_3', 'Shipment Details', 0x536869706D656E742044657461696C73, 0x536869706D656E742044657461696C73, '1', '1', 'Type of Shipment', 'Insured Value Currency', 'Insured Value', 'Commodity', 'Coverage Option (not used for later)', 'Conveyance', 'Conveyance - Vessel Name', 'Conveyance - Approved Steamer if not known', 'Packing / Shipment Method', 'Country of Origin', 'Via Country', 'Destination Country', 'Conditions of Insurance', '', '', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', '', '', '', '', '', '', '2019-03-27 11:57:26', '1', '2019-05-27 14:58:09', '1');
INSERT INTO `oqt_items` VALUES ('4', '2', '2', 'mc_cargo_details_4', 'Cargo Information', 0x436172676F20496E666F726D6174696F6E, 0x436172676F20496E666F726D6174696F6E, '1', '1', 'Full Description of Cargo', 'Marks & Numbers', 'Letter of Credit Conditions', 'Notes', 'Supplier', '', '', '', '', '', '', '', '', '', '', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', 'GET_FROM_FORM', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2019-03-28 16:49:28', '1', '2019-04-18 14:40:35', '1');

-- ----------------------------
-- Table structure for oqt_quotations
-- ----------------------------
DROP TABLE IF EXISTS `oqt_quotations`;
CREATE TABLE `oqt_quotations` (
  `oqq_quotations_ID` int(10) NOT NULL AUTO_INCREMENT,
  `oqq_quotations_type_ID` int(10) DEFAULT NULL,
  `oqq_users_ID` int(11) DEFAULT NULL,
  `oqq_number` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `oqq_status` varchar(12) COLLATE utf8_bin DEFAULT NULL COMMENT 'Outstanding/Active/Deleted/Pending/Approved/Rejected',
  `oqq_effective_date` datetime DEFAULT NULL COMMENT 'activation date',
  `oqq_language` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_name` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_tel` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_mobile` text COLLATE utf8_bin,
  `oqq_insureds_address` text COLLATE utf8_bin,
  `oqq_insureds_city` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_contact_person` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqq_insureds_postal_code` text COLLATE utf8_bin,
  `oqq_situation_address` text COLLATE utf8_bin,
  `oqq_situation_postal_code` text COLLATE utf8_bin,
  `oqq_fees` double DEFAULT NULL,
  `oqq_stamps` double DEFAULT NULL,
  `oqq_premium` double DEFAULT NULL,
  `oqq_custom_premium1` double DEFAULT NULL,
  `oqq_custom_premium2` double DEFAULT NULL,
  `oqq_detail_price_array` text COLLATE utf8_bin,
  `oqq_extra_details` text COLLATE utf8_bin,
  `oqq_starting_date` datetime DEFAULT NULL,
  `oqq_expiry_date` datetime DEFAULT NULL,
  `oqq_replaced_by_ID` int(8) DEFAULT NULL,
  `oqq_replacing_ID` int(8) DEFAULT NULL,
  `oqq_created_date_time` datetime DEFAULT NULL,
  `oqq_created_by` int(8) DEFAULT NULL,
  `oqq_last_update_date_time` datetime DEFAULT NULL,
  `oqq_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`oqq_quotations_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of oqt_quotations
-- ----------------------------
INSERT INTO `oqt_quotations` VALUES ('14', '1', '1', null, 'Outstanding', '2019-04-16 16:19:11', 'gr', 'Mike', '786613', '54345', null, 0x737079726F75206B79707269616E6F75, null, '', '', 0x36303534, '', '', '12', '2', '350', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A284D696B65293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28343335293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A286B75706F75726F73293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28343335293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E332A2841333530293C2F623E3D3E2623383336343B3C623E3335303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E302A28413235293C2F623E3D3E2623383336343B3C623E303C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-05-23 13:00:38', '2019-05-23 13:00:38', '26', null, null, null, '2019-05-23 13:00:38', '1');
INSERT INTO `oqt_quotations` VALUES ('15', '2', '1', null, 'Pending', '2019-04-09 14:33:55', 'en', 'Michael Ermogenous', '786613', '99420544', null, 0x6C61726E616B61, null, 'micacca@gmail.com', 'Michael', 0x36303538, '', '', '0', '0', '0', '0', '0', 0x0A3C623E332D323C2F623E20412D3E3C623E302A2820424244293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C75652043757272656E6379293C62723E0A3C623E332D333C2F623E20412D3E3C623E302A2831293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C7565293C62723E0A3C623E332D343C2F623E20412D3E3C623E302A2847656E6572616C20436172676F2026204D65726368616E64697365293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6D6D6F64697479293C62723E0A3C623E332D363C2F623E20412D3E3C623E302A28416972293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E766579616E6365293C62723E0A3C623E332D393C2F623E20412D3E3C623E302A2847656E6572616C293C2F623E3D3E2623383336343B3C623E303C2F623E20285061636B696E67202F20536869706D656E74204D6574686F64293C62723E0A3C623E332D31303C2F623E20412D3E3C623E302A283233293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279206F66204F726967696E293C62723E0A3C623E332D31313C2F623E20412D3E3C623E302A28313739293C2F623E3D3E2623383336343B3C623E303C2F623E202856696120436F756E747279293C62723E0A3C623E332D31323C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E202844657374696E6174696F6E20436F756E747279293C62723E0A3C623E342D313C2F623E20412D3E3C623E302A28736466293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204465736372697074696F6E206F6620436172676F293C62723E0A3C623E342D323C2F623E20412D3E3C623E302A2873646673293C2F623E3D3E2623383336343B3C623E303C2F623E20284D61726B732026204E756D62657273293C62723E0A3C623E342D353C2F623E20412D3E3C623E302A286473666473293C2F623E3D3E2623383336343B3C623E303C2F623E2028537570706C696572293C62723E466565733A300A3C62723E5374616D70733A30, '', null, null, null, null, null, null, '2019-05-10 14:21:36', '1');
INSERT INTO `oqt_quotations` VALUES ('16', '2', '1', null, 'Deleted', null, 'en', 'Michael Ermogenous', '786613', '99420544', null, 0x6C61726E616B61, null, null, null, 0x36303538, '', '', '0', '0', '0', '0', '0', 0x466565733A300A3C62723E5374616D70733A30, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, null, null, null, null, null, null, '2019-04-09 14:28:29', '1');
INSERT INTO `oqt_quotations` VALUES ('18', '2', '1', 'CNMC-000006', 'Active', '2019-04-18 14:49:19', 'en', 'Michael Ermogenous', '786613', '99420544', null, 0x6C61726E616B61, null, 'micacca@gmail.com', 'Michael', 0x36303538, '', '', '0', '0', '0', '0', '0', 0x0A3C623E332D313C2F623E20412D3E3C623E302A28426F6F6B65642F436F6E6669726D65642F426F756E64293C2F623E3D3E2623383336343B3C623E303C2F623E202854797065206F6620536869706D656E74293C62723E0A3C623E332D323C2F623E20412D3E3C623E302A2820455552293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C75652043757272656E6379293C62723E0A3C623E332D333C2F623E20412D3E3C623E302A28313530293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C7565293C62723E0A3C623E332D343C2F623E20412D3E3C623E302A285370656369616C20436F766572204D6F62696C652050686F6E65732C20456C656374726F6E69632045717569706D656E74293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6D6D6F64697479293C62723E0A3C623E332D363C2F623E20412D3E3C623E302A284C616E64293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E766579616E6365293C62723E0A3C623E332D393C2F623E20412D3E3C623E302A284F74686572293C2F623E3D3E2623383336343B3C623E303C2F623E20285061636B696E67202F20536869706D656E74204D6574686F64293C62723E0A3C623E332D31303C2F623E20412D3E3C623E302A28323134293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279206F66204F726967696E293C62723E0A3C623E332D31313C2F623E20412D3E3C623E302A283233293C2F623E3D3E2623383336343B3C623E303C2F623E202856696120436F756E747279293C62723E0A3C623E332D31323C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E202844657374696E6174696F6E20436F756E747279293C62723E0A3C623E342D313C2F623E20412D3E3C623E302A284D7920636172676F206465736372697074696F6E293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204465736372697074696F6E206F6620436172676F293C62723E0A3C623E342D323C2F623E20412D3E3C623E302A28313231320D0A3535353535293C2F623E3D3E2623383336343B3C623E303C2F623E20284D61726B732026204E756D62657273293C62723E0A3C623E342D333C2F623E20412D3E3C623E302A28736F6D6520636F6E646974696F6E73293C2F623E3D3E2623383336343B3C623E303C2F623E20284C6574746572206F662043726564697420436F6E646974696F6E73293C62723E0A3C623E342D353C2F623E20412D3E3C623E302A2841204368696E65736520666163746F7279293C2F623E3D3E2623383336343B3C623E303C2F623E2028537570706C696572293C62723E466565733A300A3C62723E5374616D70733A30, '', null, null, null, null, null, null, '2019-04-18 14:49:19', '1');
INSERT INTO `oqt_quotations` VALUES ('19', '1', '1', 'KEFM200006', 'Active', '2019-04-24 11:46:06', 'gr', 'Michael Ermogenous', '786613', '99420544', null, 0x6C61726E616B61, null, '', '', 0x36303538, '', '', '12', '2', '200', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A284D696B65293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28343335293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A286B75706F75726F73293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28343335293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E322A2841323030293C2F623E3D3E2623383336343B3C623E3230303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E302A28413235293C2F623E3D3E2623383336343B3C623E303C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-05-23 15:23:39', '2019-05-23 15:23:39', '27', null, null, null, '2019-05-23 15:23:39', '1');
INSERT INTO `oqt_quotations` VALUES ('20', '1', '1', 'CNMF-000005', 'Active', '2019-04-24 11:27:21', 'en', 'Michael', '7896613', '99420544', 0x3939343230353434, 0x4C61726E616B61, null, '', '', 0x37303830, '', '', '12', '2', '225', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A2847656F726765293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28437970727573293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A2850726F6772616D6D6572293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28313233343536293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E322A2841323030293C2F623E3D3E2623383336343B3C623E3230303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E312A28413235293C2F623E3D3E2623383336343B3C623E32353C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E0A3C623E322D333C2F623E20412D3E3C623E302A28313233342F312F31323334293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-05-23 15:22:17', '2019-05-23 15:22:17', '31', null, null, null, '2019-05-23 16:42:53', '1');
INSERT INTO `oqt_quotations` VALUES ('21', '2', '1', 'KMCE200019', 'Pending', '2019-05-02 18:41:08', 'gr', 'Michael Ermogenous', '7896613', '54345', null, 0x4C61726E616B61, null, 'micacca@gmail.com', 'Michael', 0x37303830, '', '', '0', '0', '0', '0', '0', 0x0A3C623E332D323C2F623E20412D3E3C623E302A2820415544293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C75652043757272656E6379293C62723E0A3C623E332D333C2F623E20412D3E3C623E302A28353030293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C7565293C62723E0A3C623E332D343C2F623E20412D3E3C623E302A284F74686572293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6D6D6F64697479293C62723E0A3C623E332D363C2F623E20412D3E3C623E302A284C616E64293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E766579616E6365293C62723E0A3C623E332D393C2F623E20412D3E3C623E302A284C6F6F7365293C2F623E3D3E2623383336343B3C623E303C2F623E20285061636B696E67202F20536869706D656E74204D6574686F64293C62723E0A3C623E332D31303C2F623E20412D3E3C623E302A28313831293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279206F66204F726967696E293C62723E0A3C623E332D31313C2F623E20412D3E3C623E302A28313839293C2F623E3D3E2623383336343B3C623E303C2F623E202856696120436F756E747279293C62723E0A3C623E332D31323C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E202844657374696E6174696F6E20436F756E747279293C62723E0A3C623E342D313C2F623E20412D3E3C623E302A282046756C6C204465736372697074696F6E206F6620436172676F2F476F6F647320496E737572656420293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204465736372697074696F6E206F6620436172676F293C62723E0A3C623E342D323C2F623E20412D3E3C623E302A28204D61726B732026204E756D6265727320293C2F623E3D3E2623383336343B3C623E303C2F623E20284D61726B732026204E756D62657273293C62723E0A3C623E342D333C2F623E20412D3E3C623E302A2868686A6868293C2F623E3D3E2623383336343B3C623E303C2F623E20284C6574746572206F662043726564697420436F6E646974696F6E73293C62723E0A3C623E342D353C2F623E20412D3E3C623E302A286E6573746C65293C2F623E3D3E2623383336343B3C623E303C2F623E2028537570706C696572293C62723E466565733A300A3C62723E5374616D70733A30, '', null, null, null, null, null, null, '2019-05-09 11:40:49', '1');
INSERT INTO `oqt_quotations` VALUES ('22', '2', '1', null, 'Approved', '2019-04-24 13:20:18', 'en', 'Michael Ermogenous', '7896613', '99420544', null, 0x4C61726E616B61, null, 'micacca@gmail.com', 'Michael', 0x37303830, '', '', '0', '0', '0', '0', '0', 0x0A3C623E332D313C2F623E20412D3E3C623E302A28496E636F6D706C657465293C2F623E3D3E2623383336343B3C623E303C2F623E202854797065206F6620536869706D656E74293C62723E0A3C623E332D323C2F623E20412D3E3C623E302A2820424946293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C75652043757272656E6379293C62723E0A3C623E332D333C2F623E20412D3E3C623E302A28353030293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C7565293C62723E0A3C623E332D343C2F623E20412D3E3C623E302A2847656E6572616C20436172676F2026204D65726368616E64697365293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6D6D6F64697479293C62723E0A3C623E332D363C2F623E20412D3E3C623E302A28416972293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E766579616E6365293C62723E0A3C623E332D393C2F623E20412D3E3C623E302A2847656E6572616C293C2F623E3D3E2623383336343B3C623E303C2F623E20285061636B696E67202F20536869706D656E74204D6574686F64293C62723E0A3C623E332D31303C2F623E20412D3E3C623E302A28333536293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279206F66204F726967696E293C62723E0A3C623E332D31313C2F623E20412D3E3C623E302A28323430293C2F623E3D3E2623383336343B3C623E303C2F623E202856696120436F756E747279293C62723E0A3C623E332D31323C2F623E20412D3E3C623E302A283233293C2F623E3D3E2623383336343B3C623E303C2F623E202844657374696E6174696F6E20436F756E747279293C62723E0A3C623E342D313C2F623E20412D3E3C623E302A28676668666768293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204465736372697074696F6E206F6620436172676F293C62723E0A3C623E342D323C2F623E20412D3E3C623E302A28666768666768293C2F623E3D3E2623383336343B3C623E303C2F623E20284D61726B732026204E756D62657273293C62723E0A3C623E342D333C2F623E20412D3E3C623E302A2866676866293C2F623E3D3E2623383336343B3C623E303C2F623E20284C6574746572206F662043726564697420436F6E646974696F6E73293C62723E0A3C623E342D353C2F623E20412D3E3C623E302A2867686668293C2F623E3D3E2623383336343B3C623E303C2F623E2028537570706C696572293C62723E466565733A300A3C62723E5374616D70733A30, '', null, null, null, null, null, null, '2019-04-24 13:20:18', '1');
INSERT INTO `oqt_quotations` VALUES ('23', '1', '1', 'KEFM200010', 'Active', '2019-05-07 10:28:41', 'gr', 'Mike', '7896613', '99420544', null, 0x4C61726E616B61, null, '', '', 0x37303830, '', '', '12', '2', '100', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A2847656F726765293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28437970727573293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A2850726F6772616D6D6572293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28313233343536293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E312A2841313030293C2F623E3D3E2623383336343B3C623E3130303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E302A28413235293C2F623E3D3E2623383336343B3C623E303C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, null, null, null, null, null, null, '2019-05-07 10:28:41', '1');
INSERT INTO `oqt_quotations` VALUES ('24', '1', '1', 'KEFM200011', 'Active', '2019-05-07 12:30:57', 'gr', 'Michael Ermogenous', '7896613', '99420544', null, 0x4C61726E616B61, null, '', '', 0x37303830, '', '', '12', '2', '100', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A2847656F726765293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28437970727573293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A2850726F6772616D6D6572293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28313233343536293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E312A2841313030293C2F623E3D3E2623383336343B3C623E3130303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E302A28413235293C2F623E3D3E2623383336343B3C623E303C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, null, null, null, null, null, null, '2019-05-07 12:30:57', '1');
INSERT INTO `oqt_quotations` VALUES ('25', '1', '1', '', 'Outstanding', '2019-04-16 16:19:11', 'gr', 'Mike', '786613', '54345', '', 0x737079726F75206B79707269616E6F75, null, '', '', 0x36303534, '', '', '12', '2', '350', '0', '0', '', 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-11-20 00:00:00', '2020-08-19 00:00:00', null, null, '2019-05-23 12:43:56', '1', null, null);
INSERT INTO `oqt_quotations` VALUES ('26', '1', '1', '', 'Outstanding', '2019-04-16 16:19:11', 'gr', 'Mike', '786613', '54345', '', 0x737079726F75206B79707269616E6F75, null, '', '', 0x36303534, '', '', '12', '2', '350', '0', '0', '', 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-11-20 00:00:00', '2020-11-19 00:00:00', '0', '14', '2019-05-23 13:00:38', '1', null, null);
INSERT INTO `oqt_quotations` VALUES ('27', '1', '1', 'KEFM200006', 'Outstanding', '2019-04-24 11:46:06', 'gr', 'Michael Ermogenous', '786613', '99420544', '', 0x6C61726E616B61, null, '', '', 0x36303538, '', '', '12', '2', '200', '0', '0', '', 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-08-23 00:00:00', '2019-11-22 00:00:00', '0', '19', '2019-05-23 15:23:39', '1', null, null);
INSERT INTO `oqt_quotations` VALUES ('28', '1', '1', 'KEFM200013', 'Active', '2019-05-23 16:32:48', 'gr', 'Michael Ermogenous', '7896613', '99420544', null, 0x4C61726E616B61, null, '', '', 0x37303830, '', '', '12', '2', '100', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A2847656F726765293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28437970727573293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A2850726F6772616D6D6572293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28313233343536293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A283232293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E312A2841313030293C2F623E3D3E2623383336343B3C623E3130303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E302A28413235293C2F623E3D3E2623383336343B3C623E303C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-05-23 00:00:00', '2019-08-22 00:00:00', '29', null, null, null, '2019-05-23 16:38:36', '1');
INSERT INTO `oqt_quotations` VALUES ('29', '1', '1', 'KEFM200013', 'Outstanding', '2019-05-23 16:32:48', 'gr', 'Michael Ermogenous', '7896613', '99420544', '', 0x4C61726E616B61, null, '', '', 0x37303830, '', '', '12', '2', '100', '0', '0', '', 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-08-23 00:00:00', '2019-11-22 00:00:00', '0', '28', '2019-05-23 16:38:36', '1', null, null);
INSERT INTO `oqt_quotations` VALUES ('31', '1', '1', '', 'Outstanding', '2019-04-24 11:27:21', 'en', 'Michael', '7896613', '99420544', 0x3939343230353434, 0x4C61726E616B61, null, '', '', 0x37303830, '', '', '12', '2', '225', '0', '0', '', 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-05-24 00:00:00', '2019-08-23 00:00:00', '0', '20', '2019-05-23 16:42:53', '1', null, null);
INSERT INTO `oqt_quotations` VALUES ('32', '2', '1', null, 'Outstanding', null, 'en', 'Michael', '7896613', '99420544', null, 0x4C61726E616B61, null, 'micacca@gmail.com', 'Michael', 0x37303830, '', '', '0', '0', '0', '0', '0', 0x0A3C623E332D323C2F623E20412D3E3C623E302A282042474E293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C75652043757272656E6379293C62723E0A3C623E332D333C2F623E20412D3E3C623E302A28353030293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C7565293C62723E0A3C623E332D343C2F623E20412D3E3C623E302A2847656E6572616C20436172676F2026204D65726368616E64697365293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6D6D6F64697479293C62723E0A3C623E332D363C2F623E20412D3E3C623E302A28416972293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E766579616E6365293C62723E0A3C623E332D393C2F623E20412D3E3C623E302A284F74686572293C2F623E3D3E2623383336343B3C623E303C2F623E20285061636B696E67202F20536869706D656E74204D6574686F64293C62723E0A3C623E332D31303C2F623E20412D3E3C623E302A28313934293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279206F66204F726967696E293C62723E0A3C623E332D31313C2F623E20412D3E3C623E302A28313839293C2F623E3D3E2623383336343B3C623E303C2F623E202856696120436F756E747279293C62723E0A3C623E332D31323C2F623E20412D3E3C623E302A28313931293C2F623E3D3E2623383336343B3C623E303C2F623E202844657374696E6174696F6E20436F756E747279293C62723E0A3C623E332D31333C2F623E20412D3E3C623E302A28436C617573652042293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E646974696F6E73206F6620496E737572616E6365293C62723E0A3C623E342D313C2F623E20412D3E3C623E302A2867666473677364293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204465736372697074696F6E206F6620436172676F293C62723E0A3C623E342D323C2F623E20412D3E3C623E302A2867646673293C2F623E3D3E2623383336343B3C623E303C2F623E20284D61726B732026204E756D62657273293C62723E0A3C623E342D353C2F623E20412D3E3C623E302A28666467647366293C2F623E3D3E2623383336343B3C623E303C2F623E2028537570706C696572293C62723E466565733A300A3C62723E5374616D70733A30, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, null, null);
INSERT INTO `oqt_quotations` VALUES ('33', '1', '1', 'KEFM200014', 'Active', '2019-05-30 15:16:35', 'gr', 'Michael Ermogenous', '786613', '24123456', 0x3939343230353434, 0x41646472657373737373737373, 'Larnaka', '', '', 0x36303538, '', '', '12', '2', '225', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A2820CE8CCEBDCEBFCEBCCEB120CE91CF83CF86CEB1CEBBCEB9CEB6CF8CCEBCCEB5CEBDCEBFCF8520293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A2820CEA4CF8CCF80CEBFCF8220CEA3CF85CEBDCEAECEB8CEBFCF85CF8220CE95CF81CEB3CEB1CF83CEAFCEB1CF8220293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A28CE95CF80CEACCEB3CEB3CEB5CEBBCEBCCEB1293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A2820CE91CF81CEB9CEB8CEBCCF8CCF8220CE94CEB9CEB1CEB2CEB1CF84CEB7CF81CEAFCEBFCF8520293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A28323630293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E322A2841323030293C2F623E3D3E2623383336343B3C623E3230303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E312A28413235293C2F623E3D3E2623383336343B3C623E32353C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E0A3C623E322D333C2F623E20412D3E3C623E302A2831323334293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572204669656C642031293C62723E0A3C623E322D343C2F623E20412D3E3C623E302A2835293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572204669656C642032293C62723E0A3C623E322D353C2F623E20412D3E3C623E302A2836373839293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572204669656C642033293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-06-05 00:00:00', '2020-06-04 00:00:00', '34', null, null, null, '2019-05-30 15:17:09', '1');
INSERT INTO `oqt_quotations` VALUES ('34', '1', '1', '', 'Deleted', '2019-05-30 15:16:35', 'gr', 'kjhk', 'jkh', 'kjh', '', 0x6B68, null, '', '', 0x6B, '', '', '12', '2', '200', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A286A6B68293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A286B6A68293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A286B68293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A286B6A68293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A28323630293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E322A2841323030293C2F623E3D3E2623383336343B3C623E3230303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E302A28413235293C2F623E3D3E2623383336343B3C623E303C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2020-06-05 00:00:00', '2020-09-04 00:00:00', '0', '33', '2019-05-30 15:17:09', '1', '2019-06-06 12:12:36', '1');
INSERT INTO `oqt_quotations` VALUES ('35', '2', '1', 'KMCE200020', 'Active', '2019-05-30 15:54:53', 'en', 'ljhljhkj', 'khkh', 'hh', null, 0x686B6A, null, 'kjh@sdfs.com', 'jk', 0x686B, '', '', '0', '0', '0', '0', '0', 0x0A3C623E332D323C2F623E20412D3E3C623E302A2820424454293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C75652043757272656E6379293C62723E0A3C623E332D333C2F623E20412D3E3C623E302A2832353030293C2F623E3D3E2623383336343B3C623E303C2F623E2028496E73757265642056616C7565293C62723E0A3C623E332D343C2F623E20412D3E3C623E302A28506572736F6E616C20456666656374732070726F66657373696F6E616C6C79207061636B6564293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6D6D6F64697479293C62723E0A3C623E332D363C2F623E20412D3E3C623E302A28416972293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E766579616E6365293C62723E0A3C623E332D393C2F623E20412D3E3C623E302A2847656E6572616C293C2F623E3D3E2623383336343B3C623E303C2F623E20285061636B696E67202F20536869706D656E74204D6574686F64293C62723E0A3C623E332D31303C2F623E20412D3E3C623E302A283233293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279206F66204F726967696E293C62723E0A3C623E332D31313C2F623E20412D3E3C623E302A28333438293C2F623E3D3E2623383336343B3C623E303C2F623E202856696120436F756E747279293C62723E0A3C623E332D31323C2F623E20412D3E3C623E302A28313931293C2F623E3D3E2623383336343B3C623E303C2F623E202844657374696E6174696F6E20436F756E747279293C62723E0A3C623E332D31333C2F623E20412D3E3C623E302A28436C617573652041293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F6E646974696F6E73206F6620496E737572616E6365293C62723E0A3C623E342D313C2F623E20412D3E3C623E302A287364667364293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204465736372697074696F6E206F6620436172676F293C62723E0A3C623E342D323C2F623E20412D3E3C623E302A28736466293C2F623E3D3E2623383336343B3C623E303C2F623E20284D61726B732026204E756D62657273293C62723E0A3C623E342D353C2F623E20412D3E3C623E302A2873646664293C2F623E3D3E2623383336343B3C623E303C2F623E2028537570706C696572293C62723E466565733A300A3C62723E5374616D70733A30, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '2019-05-30 15:54:53', '1');
INSERT INTO `oqt_quotations` VALUES ('36', '1', '1', null, 'Outstanding', null, 'gr', 'Michael Ermogenous', '7896613', '24123456', 0x3939343230353434, 0x4D616B6172696F75203233, 'Λάρνακα', '', '', 0x37303830, '', '', '12', '2', '225', '0', '0', 0x0A3C623E312D313C2F623E20412D3E3C623E302A28CE8CCEBDCEBFCEBCCEB120CE91CF83CF86CEB1CEBBCEB9CEB6CF8CCEBCCEB5CEBDCEBFCF85293C2F623E3D3E2623383336343B3C623E303C2F623E202846756C6C204E616D65293C62723E0A3C623E312D323C2F623E20412D3E3C623E302A28CEA4CF8CCF80CEBFCF8220CEA3CF85CEBDCEAECEB8CEBFCF85CF8220CE95CF81CEB3CEB1CF83CEAFCEB1CF82293C2F623E3D3E2623383336343B3C623E303C2F623E2028506C616365206F6620757375616C20627573696E657373293C62723E0A3C623E312D333C2F623E20412D3E3C623E302A28343734293C2F623E3D3E2623383336343B3C623E303C2F623E20284F636375706174696F6E293C62723E0A3C623E312D343C2F623E20412D3E3C623E302A28CE91CF81CEB9CEB8CEBCCF8CCF8220CE94CEB9CEB1CEB2CEB1CF84CEB7CF81CEAFCEBFCF85293C2F623E3D3E2623383336343B3C623E303C2F623E202850617373706F7274204E756D626572293C62723E0A3C623E312D353C2F623E20412D3E3C623E302A28313933293C2F623E3D3E2623383336343B3C623E303C2F623E2028436F756E747279293C62723E0A3C623E312D363C2F623E20412D3E3C623E302A284D616C65293C2F623E3D3E2623383336343B3C623E303C2F623E202847656E646572293C62723E0A3C623E322D313C2F623E20412D3E3C623E322A2841323030293C2F623E3D3E2623383336343B3C623E3230303C2F623E20285061636B61676520506C616E2053656C656374696F6E293C62723E0A3C623E322D323C2F623E20412D3E3C623E312A28413235293C2F623E3D3E2623383336343B3C623E32353C2F623E2028456D706C6F79657273204C696162696C6974792073656C656374696F6E293C62723E0A3C623E322D333C2F623E20412D3E3C623E302A2831323333293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572204669656C642031293C62723E0A3C623E322D343C2F623E20412D3E3C623E302A2831293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572204669656C642032293C62723E0A3C623E322D353C2F623E20412D3E3C623E302A2835363536293C2F623E3D3E2623383336343B3C623E303C2F623E2028536F6369616C205365637572697479204E756D626572204669656C642033293C62723E466565733A31320A3C62723E5374616D70733A32, 0x202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020, '2019-06-13 00:00:00', '2020-03-12 00:00:00', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for oqt_quotations_items
-- ----------------------------
DROP TABLE IF EXISTS `oqt_quotations_items`;
CREATE TABLE `oqt_quotations_items` (
  `oqqit_quotations_items_ID` int(10) NOT NULL AUTO_INCREMENT,
  `oqqit_quotations_ID` int(10) DEFAULT NULL,
  `oqqit_items_ID` int(10) DEFAULT NULL,
  `oqqit_insured_amount_1` double DEFAULT NULL,
  `oqqit_insured_amount_2` double DEFAULT NULL,
  `oqqit_insured_amount_3` double DEFAULT NULL,
  `oqqit_insured_amount_4` double DEFAULT NULL,
  `oqqit_insured_amount_5` double DEFAULT NULL,
  `oqqit_insured_amount_6` double DEFAULT NULL,
  `oqqit_insured_amount_7` double DEFAULT NULL,
  `oqqit_insured_amount_8` double DEFAULT NULL,
  `oqqit_insured_amount_9` double DEFAULT NULL,
  `oqqit_insured_amount_10` double DEFAULT NULL,
  `oqqit_insured_amount_11` double DEFAULT NULL,
  `oqqit_insured_amount_12` double DEFAULT NULL,
  `oqqit_insured_amount_13` double DEFAULT NULL,
  `oqqit_insured_amount_14` double DEFAULT NULL,
  `oqqit_insured_amount_15` double DEFAULT NULL,
  `oqqit_rate_1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_3` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_4` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_5` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_6` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_7` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_8` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_9` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_10` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_11` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_12` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_13` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_14` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_rate_15` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqit_date_1` date DEFAULT NULL,
  `oqqit_date_2` date DEFAULT NULL,
  `oqit_date_3` date DEFAULT NULL,
  `oqit_date_4` date DEFAULT NULL,
  `oqqit_created_date_time` datetime DEFAULT NULL,
  `oqqit_created_by` int(8) DEFAULT NULL,
  `oqqit_last_update_date_time` datetime DEFAULT NULL,
  `oqqit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`oqqit_quotations_items_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of oqt_quotations_items
-- ----------------------------
INSERT INTO `oqt_quotations_items` VALUES ('1', '14', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'Mike', '435', 'kupouros', '435', '22', 'Male', null, null, null, null, null, null, null, null, null, '1954-05-24', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('2', '14', '2', '3', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '', null, null, null, null, null, null, null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('3', '15', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', ' BBD', '1', 'General Cargo & Merchandise', '', 'Air', '', '', 'General', '23', '179', '22', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('4', '16', '3', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('6', '18', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Booked/Confirmed/Bound', ' EUR', '150', 'Special Cover Mobile Phones, Electronic Equipment', '', 'Land', '', '', 'Other', '214', '23', '22', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('7', '18', '4', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'My cargo description', '1212\r\n55555', 'some conditions', '', 'A Chinese factory', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('8', '19', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'Mike', '435', 'kupouros', '435', '22', 'Male', null, null, null, null, null, null, null, null, null, '1979-05-24', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('9', '19', '2', '2', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '', null, null, null, null, null, null, null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('10', '20', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', null, null, null, null, null, null, null, null, null, '1980-01-01', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('11', '20', '2', '2', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '1234/1/1234', null, null, null, null, null, null, null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('12', '21', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', ' AUD', '500', 'Other', '', 'Land', '', '', 'Loose', '181', '189', '22', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('13', '21', '4', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, ' Full Description of Cargo/Goods Insured ', ' Marks & Numbers ', 'hhjhh', '', 'nestle', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('14', '22', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Incomplete', ' BIF', '500', 'General Cargo & Merchandise', '', 'Air', '', '', 'General', '356', '240', '23', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('15', '22', '4', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'gfhfgh', 'fghfgh', 'fghf', '', 'ghfh', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('16', '23', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', null, null, null, null, null, null, null, null, null, '1979-05-24', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('17', '23', '2', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '', null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-02', '2019-05-31', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('18', '24', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', null, null, null, null, null, null, null, null, null, '1979-05-24', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('19', '24', '2', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '', null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-07', '2020-05-06', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('20', '15', '4', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'sdf', 'sdfs', '', '', 'dsfds', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('21', '25', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Mike', '435', 'kupouros', '435', '22', 'Male', '', '', '', '', '', '', '', '', '', '1954-05-24', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('22', '25', '2', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('23', '26', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Mike', '435', 'kupouros', '435', '22', 'Male', '', '', '', '', '', '', '', '', '', '1954-05-24', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('24', '26', '2', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('25', '27', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Mike', '435', 'kupouros', '435', '22', 'Male', '', '', '', '', '', '', '', '', '', '1979-05-24', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('26', '27', '2', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('27', '28', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', null, null, null, null, null, null, null, null, null, '1979-05-24', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('28', '28', '2', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '', null, null, null, null, null, null, null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('29', '29', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', '', '', '', '', '', '', '', '', '', '1979-05-24', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('30', '29', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('31', '30', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', '', '', '', '', '', '', '', '', '', '1980-01-01', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('32', '30', '2', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '1234/1/1234', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('33', '31', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'George', 'Cyprus', 'Programmer', '123456', '22', 'Male', '', '', '', '', '', '', '', '', '', '1980-01-01', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('34', '31', '2', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '1234/1/1234', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('35', '32', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null, '', ' BGN', '500', 'General Cargo & Merchandise', '', 'Air', '', '', 'Other', '194', '189', '191', 'Clause B', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('36', '32', '4', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'gfdsgsd', 'gdfs', '', '', 'fdgdsf', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('37', '33', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, ' Όνομα Ασφαλιζόμενου ', ' Τόπος Συνήθους Εργασίας ', 'Επάγγελμα', ' Αριθμός Διαβατηρίου ', '260', 'Male', null, null, null, null, null, null, null, null, null, '1980-01-01', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('38', '33', '2', '2', '1', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '1234', '5', '6789', null, null, null, null, null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('39', '34', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'jkh', 'kjh', 'kh', 'kjh', '260', 'Male', '', '', '', '', '', '', '', '', '', '1980-01-01', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('40', '34', '2', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'A100||A200||A350', 'A25', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('41', '35', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null, '', ' BDT', '2500', 'Personal Effects professionally packed', '', 'Air', '', '', 'General', '23', '348', '191', 'Clause A', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('42', '35', '4', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'sdfsd', 'sdf', '', '', 'sdfd', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('43', '36', '1', '0', '0', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, 'Όνομα Ασφαλιζόμενου', 'Τόπος Συνήθους Εργασίας', '474', 'Αριθμός Διαβατηρίου', '193', 'Male', null, null, null, null, null, null, null, null, null, '1979-05-24', null, null, null, null, null, null, null);
INSERT INTO `oqt_quotations_items` VALUES ('44', '36', '2', '2', '1', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, 'A100||A200||A350', 'A25', '1233', '1', '5656', null, null, null, null, null, null, null, null, null, null, '0000-00-00', '0000-00-00', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for oqt_quotations_types
-- ----------------------------
DROP TABLE IF EXISTS `oqt_quotations_types`;
CREATE TABLE `oqt_quotations_types` (
  `oqqt_quotations_types_ID` int(10) NOT NULL AUTO_INCREMENT,
  `oqqt_status` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_quotation_or_cover_note` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_name` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_quotation_label_gr` text COLLATE utf8_bin,
  `oqqt_quotation_label_en` text COLLATE utf8_bin,
  `oqqt_language` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT 'Both, English, Greek',
  `oqqt_functions_file` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_print_layout` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_type` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_class` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_fees` double DEFAULT NULL,
  `oqqt_stamps` double DEFAULT NULL,
  `oqqt_premium_rounding` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_minimum_premium` double DEFAULT NULL,
  `oqqt_js_file` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_enable_premium` int(1) DEFAULT NULL,
  `oqqt_enable_search_autofill` int(1) DEFAULT NULL,
  `oqqt_active_send_mail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_active_send_mail_cc` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_active_send_mail_bcc` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_active_send_mail_subject` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_active_send_mail_body` text COLLATE utf8_bin,
  `oqqt_allowed_user_groups` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_allow_print_outstanding` int(1) DEFAULT NULL,
  `oqqt_added_field_email` int(1) DEFAULT NULL,
  `oqqt_added_field_contact_person` int(1) DEFAULT NULL,
  `oqqt_added_field_extra_details` int(1) DEFAULT NULL,
  `oqqt_added_field_mobile` int(1) DEFAULT NULL,
  `oqqt_added_field_city` int(1) DEFAULT '0',
  `oqqt_quotation_number_prefix` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_quotation_number_leading_zeros` int(8) DEFAULT NULL,
  `oqqt_quotation_number_last_used` int(8) DEFAULT NULL,
  `oqqt_attach_print_filename` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `oqqt_enable_renewal` int(1) DEFAULT '0',
  `oqqt_renewal_issue_new_number` int(1) DEFAULT '0',
  `oqqt_created_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oqqt_created_by` int(8) DEFAULT NULL,
  `oqqt_last_update_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oqqt_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`oqqt_quotations_types_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of oqt_quotations_types
-- ----------------------------
INSERT INTO `oqt_quotations_types` VALUES ('1', 'A', 'CN', 'Medical For Foreigners Cover Notes', 0x4D65646963616C20466F7220466F726569676E657273, 0x4D65646963616C20466F7220466F726569676E657273, 'BothGr', 'mff_medical_foreigners/mff_functions.php', 'mff_medical_foreigners/mff_quotation_print.php', 'Medical', 'NonMotor', '12', '2', 'NoRounding', '0', 'mff_medical_foreigners/mff_js_functions.php', '0', '0', 'micacca@gmail.com||Michael Ermogenous', null, null, 'Kemter - New Cover Note [QTNUMBER] has been created ', 0x6B656D746572406B656D746572696E737572616E63652E636F6D7C7C4B656D7465720D0A3C62723E0D0A4E657720636F766572206E6F746520686173206265656E2063726561746564206279205B55534552534E414D455D3C62723E0D0A436F766572204E6F74652049443A205B515449445D3C62723E0D0A436F766572204E6F7465204E756D6265723A205B51544E554D4245525D3C62723E0D0A4F70656E20636F766572206E6F7465203C6120687265663D225B51544C494E4B5D223E486572653C2F613E3C62723E0D0A5669657720504446205265706F7274203C6120687265663D225B5044464C494E4B5D223E486572653C2F613E3C62723E0D0A3C62723E0D0A3C7374726F6E673E4B656D74657220496E737572616E63653C2F7374726F6E673E, '', '1', '0', null, '1', '1', '1', 'KEFM2', '5', '14', 'MedicalForeigner-[QTNUMBER].pdf', '1', '1', '2019-06-05 11:23:32', null, '2019-06-05 11:23:32', '1');
INSERT INTO `oqt_quotations_types` VALUES ('2', 'A', 'CN', 'Marine Cargo', 0x4D6172696E6520436172676F, 0x4D6172696E6520436172676F, 'English', 'mc_marine_cargo/mc_functions.php', 'mc_marine_cargo/mc_quotation_print.php', 'MarineCargo', 'NonMotor', '0', '0', 'NoRounding', '0', 'mc_marine_cargo/mc_js_functions.php', '0', '1', 'micacca@gmail.com||Ermogenous Michael', '', '', 'Kemter - New Cover Note [QTNUMBER] has been created ', 0x4E657720636F766572206E6F746520686173206265656E2063726561746564206279205B55534552534E414D455D3C62723E0D0A436F766572204E6F74652049443A205B515449445D3C62723E0D0A436F766572204E6F7465204E756D6265723A205B51544E554D4245525D3C62723E0D0A4F70656E20636F766572206E6F7465203C6120687265663D225B51544C494E4B5D223E486572653C2F613E3C62723E0D0A5669657720504446205265706F7274203C6120687265663D225B5044464C494E4B5D223E486572653C2F613E3C62723E0D0A3C62723E0D0A3C7374726F6E673E4B656D74657220496E737572616E63653C2F7374726F6E673E, '', '1', '1', '1', null, null, '0', 'KMCE2', '5', '20', '[QTNUMBER].pdf', '0', '0', '2019-05-30 15:54:53', '1', '2019-05-30 15:54:53', '1');

-- ----------------------------
-- Table structure for oqt_quotations_underwriters
-- ----------------------------
DROP TABLE IF EXISTS `oqt_quotations_underwriters`;
CREATE TABLE `oqt_quotations_underwriters` (
  `oqun_quotations_underwriter_ID` int(8) NOT NULL AUTO_INCREMENT,
  `oqun_user_ID` int(8) DEFAULT NULL,
  `oqun_status` varchar(10) DEFAULT NULL,
  `oqun_allow_mff` int(1) DEFAULT NULL,
  `oqun_allow_mc` int(1) DEFAULT NULL,
  `oqun_mf_age_restriction` int(2) DEFAULT NULL,
  `oqun_open_cover_number` varchar(50) DEFAULT NULL,
  `oqun_excess_general_cargo` varchar(100) DEFAULT NULL,
  `oqun_excess_vehicles` varchar(100) DEFAULT NULL,
  `oqun_excess_machinery` varchar(100) DEFAULT NULL,
  `oqun_excess_temp_no_meat` varchar(100) DEFAULT NULL,
  `oqun_excess_temp_meat` varchar(100) DEFAULT NULL,
  `oqun_excess_special_cover` varchar(100) DEFAULT NULL,
  `oqun_excess_pro_packed` varchar(100) DEFAULT NULL,
  `oqun_excess_owner_packed` varchar(100) DEFAULT NULL,
  `oqun_excess_other` varchar(100) DEFAULT NULL,
  `oqun_created_date_time` datetime DEFAULT NULL,
  `oqun_created_by` int(8) DEFAULT NULL,
  `oqun_last_update_date_time` datetime DEFAULT NULL,
  `oqun_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`oqun_quotations_underwriter_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oqt_quotations_underwriters
-- ----------------------------
INSERT INTO `oqt_quotations_underwriters` VALUES ('1', '1', 'Active', '1', null, '65', 'ocn-100001-2019', '5', '6', '7', '8', '9', '10', '11', '12', '13', null, null, '2019-06-06 13:45:20', '1');
INSERT INTO `oqt_quotations_underwriters` VALUES ('2', '4', 'Active', '1', '1', '65', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null, '2019-06-06 13:46:19', '1');
INSERT INTO `oqt_quotations_underwriters` VALUES ('3', '2', 'Active', null, null, '65', null, null, null, null, null, null, null, null, null, null, null, null, '2019-05-07 12:36:56', '1');

-- ----------------------------
-- Table structure for oqt_quotation_approvals
-- ----------------------------
DROP TABLE IF EXISTS `oqt_quotation_approvals`;
CREATE TABLE `oqt_quotation_approvals` (
  `oqqp_quotation_approval_ID` int(8) NOT NULL AUTO_INCREMENT,
  `oqqp_quotation_ID` int(8) DEFAULT NULL,
  `oqqp_status` varchar(20) DEFAULT NULL COMMENT 'Open/Approved/Rejected',
  `oqqp_description` varchar(255) DEFAULT NULL,
  `oqqp_created_date_time` datetime DEFAULT NULL,
  `oqqp_created_by` int(8) DEFAULT NULL,
  `oqqp_last_update_date_time` datetime DEFAULT NULL,
  `oqqp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`oqqp_quotation_approval_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oqt_quotation_approvals
-- ----------------------------
INSERT INTO `oqt_quotation_approvals` VALUES ('2', '18', 'Delete', 'Via Country: Germany Needs Approval.<br>', '2019-04-15 15:47:14', '1', '2019-04-15 15:57:30', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('3', '18', 'Delete', 'Via Country: Germany Needs Approval.<br>', '2019-04-15 15:56:34', '1', '2019-04-15 15:57:30', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('4', '18', 'Delete', 'Via Country: Germany Needs Approval.<br>', '2019-04-15 15:57:30', '1', '2019-04-15 16:31:37', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('5', '18', 'Delete', 'Via Country: Germany Needs Approval.<br>', '2019-04-15 16:31:37', '1', '2019-04-15 16:32:07', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('6', '18', 'Delete', 'Via Country: Germany Needs Approval.<br>', '2019-04-15 16:32:07', '1', '2019-04-15 16:33:01', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('7', '18', 'Approved', 'Via Country: Germany Needs Approval.<br>', '2019-04-15 16:33:01', '1', '2019-04-16 15:45:32', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('8', '18', 'Approved', 'Via Country: Germany Needs Approval.<br>', '2019-04-16 15:50:14', '1', '2019-04-16 15:52:53', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('9', '18', 'Approved', 'Via Country: Germany Needs Approval.<br>', '2019-04-17 11:42:53', '1', '2019-04-17 11:43:09', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('10', '18', 'Approved', 'Via Country: Germany Needs Approval.<br>', '2019-04-17 15:09:21', '1', '2019-04-17 15:09:30', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('11', '18', 'Approved', 'Via Country: Germany Needs Approval.<br>', '2019-04-18 14:43:14', '1', '2019-04-18 14:43:53', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('12', '22', 'Approved', 'Destination Country: Germany Needs Approval.<br>', '2019-04-24 13:15:58', '1', '2019-04-24 13:20:18', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('13', '21', 'Pending', 'Commodity Other Needs Approval.<br>', '2019-05-09 11:40:49', '1', null, null);
INSERT INTO `oqt_quotation_approvals` VALUES ('14', '15', 'Delete', 'Origin Country: Germany Needs Approval.<br>', '2019-05-10 13:34:44', '1', '2019-05-10 14:02:25', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('15', '15', 'Delete', 'Origin Country: Germany Needs Approval.<br>', '2019-05-10 14:02:25', '1', '2019-05-10 14:21:36', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('16', '15', 'Pending', 'Origin Country: Germany Needs Approval.<br>', '2019-05-10 14:21:36', '1', null, null);
INSERT INTO `oqt_quotation_approvals` VALUES ('17', '35', 'Approved', 'Origin Country: Germany Needs Approval.<br>Commodity Other Needs Approval.<br>', '2019-05-30 15:33:25', '1', '2019-05-30 15:33:58', '1');
INSERT INTO `oqt_quotation_approvals` VALUES ('18', '35', 'Approved', 'Origin Country: Germany Needs Approval.<br>', '2019-05-30 15:40:46', '1', '2019-05-30 15:54:46', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Products';

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '1', '1', 'Machine', 'Printer', 'A4', 'Black', 'LP 3130', '', 'LP 3130', 'LP 3130', '6', '2019-03-07 13:32:41', '2018-08-09 17:54:51', '1', '2019-03-07 13:32:41', '1');
INSERT INTO `products` VALUES ('2', '1', '1', 'SparePart', null, 'A4', 'Black', 'Developer Unit', '', 'Developer Unit', 'Developer Unit', '3', '2019-03-07 13:36:03', '2018-08-10 09:09:49', '1', '2019-03-07 13:36:03', '1');
INSERT INTO `products` VALUES ('3', '1', '1', 'Machine', 'selected', 'A4', 'Black', 'LP 3035', '', 'LP 3035', 'LP 3035', '7', '2018-11-29 22:35:37', '2018-08-10 09:10:56', '1', '2018-11-29 22:35:37', '1');
INSERT INTO `products` VALUES ('4', '1', '1', 'Consumable', 'Toners', 'A4', 'Black', 'TK-160/162', '', 'TK-160/162', 'TK-160/162', '3', '2019-01-08 13:34:45', '2018-08-10 11:26:36', '1', '2019-01-08 13:34:45', '1');
INSERT INTO `products` VALUES ('5', '1', '1', 'Consumable', 'Toners', 'A4', 'Color', 'PK-3010 Yellow', '', 'Yellow', 'PY-3010 Yellow', '1', '2019-01-08 13:34:45', '2018-08-11 12:41:46', '1', '2019-01-08 13:34:45', '1');
INSERT INTO `products` VALUES ('7', '1', '1', 'Consumable', 'Toners', 'A4', 'Color', 'PM-3010 Magenta', '', 'Magenta', 'PM-3010 Magenta', '1', '2019-03-07 13:36:03', '2018-08-11 12:43:06', '1', '2019-03-07 13:36:03', '1');
INSERT INTO `products` VALUES ('8', '1', '1', 'SparePart', 'Spare', 'A4', 'Black', 'Troxoui 2255', '', 'Troxoui', 'Troxoui', '8', '2019-01-08 13:19:27', '2018-11-29 22:18:27', '1', '2019-01-08 13:19:27', '1');
INSERT INTO `products` VALUES ('9', '2', '1', 'Other', 'A4 Paper', 'A4', 'Other', 'A4 Plain Paper', '', 'A4 Plain Paper Box 5x500', 'A4 Plain Paper Box 5x500', '7', '2019-03-07 13:36:03', '2018-12-05 17:09:26', '1', '2019-03-07 13:36:03', '1');
INSERT INTO `products` VALUES ('10', '1', '1', 'Other', 'A3 Paper', 'A3', 'Other', 'A3 Plain Paper', '', 'A3 Plain Paper Box 3X500', 'A3 Plain Paper Box 3X500', '14', '2019-01-08 13:34:45', '2018-12-05 17:09:50', '1', '2019-01-08 13:34:45', '1');
INSERT INTO `products` VALUES ('11', '1', '1', 'Machine', 'MultiFunction', 'A3', 'Black', '4062i', '', '4062i', '4062i', '3', '2019-03-07 14:00:35', '2019-03-07 13:49:53', '1', '2019-03-07 14:00:35', '1');
INSERT INTO `products` VALUES ('12', '1', '1', 'Consumable', 'Toners', 'A3', 'Black', '4062i Black', '', '4062i Black', '4062i Black', '0', null, '2019-03-07 13:50:39', '1', null, null);
INSERT INTO `products` VALUES ('13', '1', '1', 'SparePart', 'Spare Parts', 'Other', 'Black', 'Heat Roller', '', 'Heat Roller', 'Heat Roller', '0', null, '2019-03-07 13:51:25', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Products Relations';

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
INSERT INTO `product_relations` VALUES ('24', '11', 'Consumable', '12', '2019-03-07 13:51:35', '1', null, null);
INSERT INTO `product_relations` VALUES ('25', '11', 'SparePart', '13', '2019-03-07 13:51:40', '1', null, null);

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
INSERT INTO `schedules` VALUES ('1', '1', 'SCH-000010', 'Outstanding', '2019-03-07', '2019-01-04 18:47:56', '1', '2019-03-07 13:41:47', '1');
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
-- Records of send_auto_emails
-- ----------------------------
INSERT INTO `send_auto_emails` VALUES ('15', '1', 'A', 'Cover Note', '1', '2019-04-17 13:50:02', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael\r\nermogenousm@gmail.com Michael Ermogenous', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Some subject', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New quotation has been created', '', 'Message has been sent  ', '2019-04-17 13:49:23', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('16', '1', 'A', 'Cover Note', '1', '2019-04-17 13:58:30', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael\r\nermogenousm@gmail.com Michael Ermogenous', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Some subject', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New quotation has been created', '', 'Message has been sent  ', '2019-04-17 13:58:27', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('17', '1', 'A', 'Cover Note', '1', '2019-04-17 13:59:47', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael\r\nermogenousm@gmail.com Michael Ermogenous', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Some subject', 'micacca@gmail.com Kemter Insurance', null, 'agentscyprus@gmail.com Kemter Insurance', '', 'New quotation has been created', '', 'Message has been sent  ', '2019-04-17 13:59:44', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('18', '1', 'A', 'Cover Note', '1', '2019-04-17 14:03:41', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Some subject', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New quotation has been created', '', 'Message has been sent  ', '2019-04-17 14:03:38', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('19', '1', 'A', 'Cover Note', '1', '2019-04-17 15:09:37', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New quotation has been created', '', 'Message has been sent  ', '2019-04-17 15:09:34', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('20', '1', 'A', 'Cover Note', '1', '2019-04-17 15:16:33', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Michael Ermogenous', 'micacca@gmail.com Kemter Insurance', null, '', '', 'Michael Ermogenous', '', 'Message has been sent  ', '2019-04-17 15:16:31', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('21', '1', 'A', 'Cover Note', '1', '2019-04-17 15:18:49', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18\r\nCover Note Number: <br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 15:18:46', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('22', '1', 'A', 'Cover Note', '1', '2019-04-17 15:22:36', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: <br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"Michael Ermogenous\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 15:22:34', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('23', '1', 'A', 'Cover Note', '1', '2019-04-17 15:23:30', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: <br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 15:23:28', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('24', '1', 'A', 'Cover Note', '1', '2019-04-17 16:13:44', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: <br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 16:13:41', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('25', '1', 'A', 'Cover Note', '1', '2019-04-17 16:15:39', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: <br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 16:15:37', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('26', '1', 'A', 'Cover Note', '1', '2019-04-17 16:19:24', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance', null, 'Kemter - New Cover Note 18 has been created ', 'micacca@gmail.com Kemter Insurance', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: CNMC-000002<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 16:19:22', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('27', '1', 'A', 'Cover Note', '1', '2019-04-17 16:35:30', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com Ermogenous Michael', '', 'agentscyprus@gmail.com Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMC-000003 has been created ', 'agentscyprus@gmail.com Kemter Insurance Agencies S', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: CNMC-000003<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 16:35:27', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('29', '1', 'A', 'Cover Note', '1', '2019-04-17 16:41:06', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMC-000004 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies ', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: CNMC-000004<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 16:41:04', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('30', '1', 'A', 'Cover Note', '1', '2019-04-17 16:42:45', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMC-000005 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: CNMC-000005<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-17 16:42:43', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('31', '1', 'A', 'Cover Note', '1', '2019-04-18 11:15:20', '19', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael\r\nermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'New quotation has been created', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'body data', '', 'Message has been sent  ', '2019-04-18 11:15:16', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('32', '1', 'A', 'Cover Note', '1', '2019-04-18 11:17:39', '19', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael\r\nermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'New quotation has been created', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'body data', '', 'Message has been sent  ', '2019-04-18 11:17:37', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('33', '1', 'A', 'Cover Note', '1', '2019-04-18 11:19:15', '19', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael\r\nermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMF-000003 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 19<br>\r\nCover Note Number: CNMF-000003<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=19\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=19&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-18 11:19:12', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('34', '1', 'A', 'Cover Note', '1', '2019-04-23 12:55:55', '18', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMC-000006 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 18<br>\r\nCover Note Number: CNMC-000006<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2\"ation=18\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=18&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-18 14:49:19', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('36', '1', 'A', 'Cover Note', '1', '2019-04-24 11:24:38', '20', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael\r\nermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMF-000004 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 20<br>\r\nCover Note Number: CNMF-000004<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=20\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=20&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-24 11:24:34', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('37', '1', 'A', 'Cover Note', '1', '2019-04-24 11:27:24', '20', 'Cover Note SERIAL', '0', '', null, null, null, null, 'kemter@kemterinsurance.com||Kemter\r\nermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMF-000005 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 20<br>\r\nCover Note Number: CNMF-000005<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=20\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=20&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-24 11:27:21', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('38', '1', 'A', 'Cover Note', '1', '2019-04-24 11:46:09', '19', 'Cover Note SERIAL', '0', '', null, null, null, null, 'kemter@kemterinsurance.com||Kemter\r\nermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200006 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 19<br>\r\nCover Note Number: KEFM200006<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=19\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=19&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-24 11:46:06', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('39', '1', 'A', 'Cover Note', '1', '2019-05-02 16:09:44', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note CNMC-000007 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: CNMC-000007<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2\"ation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-04-24 12:48:57', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('40', '1', 'A', 'Cover Note', '1', '2019-05-02 16:29:11', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200008 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200008<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:29:08', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('41', '1', 'A', 'Cover Note', '1', '2019-05-02 16:38:56', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200009 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200009<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:38:54', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('42', '1', 'A', 'Cover Note', '1', '2019-05-02 16:41:32', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200010 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200010<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:41:28', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('43', '1', 'A', 'Cover Note', '1', '2019-05-02 16:44:32', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200011 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200011<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:44:29', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('44', '1', 'A', 'Cover Note', '1', '2019-05-02 16:44:42', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200012 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200012<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:44:39', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('45', '1', 'A', 'Cover Note', '1', '2019-05-02 16:46:44', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200013 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200013<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:46:41', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('46', '1', 'A', 'Cover Note', '1', '2019-05-02 16:49:09', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200014 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200014<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:49:06', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('48', '1', 'A', 'Cover Note', '1', '2019-05-02 16:57:03', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200015 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200015<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:56:59', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('49', '1', 'A', 'Cover Note', '1', '2019-05-02 16:58:01', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200016 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200016<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 16:57:58', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('50', '1', 'A', 'Cover Note', '1', '2019-05-02 18:13:36', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200017 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200017<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2\"ation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 17:02:05', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('51', '1', 'A', 'Cover Note', '1', '2019-05-02 18:41:15', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200018 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200018<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '', 'Message has been sent  ', '2019-05-02 18:13:31', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('52', '1', 'A', 'Cover Note', '1', '2019-05-02 18:44:58', '21', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200019 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 21<br>\r\nCover Note Number: KMCE200019<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2&quotation=21\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=21&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190502184110000000.pdf||KMCE200019.pdf', 'Message has been sent  ', '2019-05-02 18:41:10', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('61', '1', 'A', 'Cover Note', '1', '2019-05-07 10:18:06', '23', 'Cover Note SERIAL', '0', '', null, null, null, null, 'ermogenousm@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200007 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 23<br>\r\nCover Note Number: KEFM200007<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=23\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=23&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190507101802000000.pdf||MedicalForeigner-KEFM200007.pdf', 'Message has been sent  \nError Attachment File Cannot find file - 20190507101802000000.pdf MedicalForeigner-KEFM200007.pdf', '2019-05-07 10:18:03', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('77', '1', 'A', 'Cover Note', '1', '2019-05-07 10:25:15', '23', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200008 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 23<br>\r\nCover Note Number: KEFM200008<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=23\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=23&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190507102511000000.pdf||MedicalForeigner-KEFM200008.pdf', 'Message has been sent  ', '2019-05-07 10:25:11', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('78', '1', 'A', 'Cover Note', '1', '2019-05-07 10:26:56', '23', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200009 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 23<br>\r\nCover Note Number: KEFM200009<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=23\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=23&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190507102652000000.pdf||MedicalForeigner-KEFM200009.pdf', 'Message has been sent  ', '2019-05-07 10:26:52', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('79', '1', 'A', 'Cover Note', '1', '2019-05-07 10:28:46', '23', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200010 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 23<br>\r\nCover Note Number: KEFM200010<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=23\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=23&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190507102842000000.pdf||MedicalForeigner-KEFM200010.pdf', 'Message has been sent  ', '2019-05-07 10:28:42', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('80', '1', 'A', 'Cover Note', '1', '2019-05-07 12:31:04', '24', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200011 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 24<br>\r\nCover Note Number: KEFM200011<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=24\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=24&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190507123059000000.pdf||MedicalForeigner-KEFM200011.pdf', 'Message has been sent  ', '2019-05-07 12:31:00', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('81', '1', 'A', 'Cover Note', '1', '2019-05-23 16:28:37', '28', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200012 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 28<br>\r\nCover Note Number: KEFM200012<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=28\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=28&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190523162832000000.pdf||MedicalForeigner-KEFM200012.pdf', 'Message has been sent  ', '2019-05-23 16:28:32', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('82', '1', 'A', 'Cover Note', '1', '2019-05-23 16:32:54', '28', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200013 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 28<br>\r\nCover Note Number: KEFM200013<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=28\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=28&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190523163249000000.pdf||MedicalForeigner-KEFM200013.pdf', 'Message has been sent  ', '2019-05-23 16:32:50', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('83', '1', 'A', 'Cover Note', '1', '2019-05-30 15:16:42', '33', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Michael Ermogenous', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KEFM200014 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus', null, '', '', 'kemter@kemterinsurance.com||Kemter\r\n<br>\r\nNew cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 33<br>\r\nCover Note Number: KEFM200014<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=1&quotation=33\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=33&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190530151636000000.pdf||MedicalForeigner-KEFM200014.pdf', 'Message has been sent  ', '2019-05-30 15:16:37', '1', null, null);
INSERT INTO `send_auto_emails` VALUES ('84', '1', 'A', 'Cover Note', '-1', '2019-06-03 13:12:20', '35', 'Cover Note SERIAL', '0', '', null, null, null, null, 'micacca@gmail.com||Ermogenous Michael', '', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, 'Kemter - New Cover Note KMCE200020 has been created ', 'agentscyprus@gmail.com||Kemter Insurance Agencies Sub-Agencies & Consultants, Limassol - Cyprus', null, '', '', 'New cover note has been created by Michael Ermogenous<br>\r\nCover Note ID: 35<br>\r\nCover Note Number: KMCE200020<br>\r\nOpen cover note <a href=\"http://localhost/reprodata/dynamic_quotations/quotations_modify.php?quotation_type=2\"ation=35\">Here</a><br>\r\nView PDF Report <a href=\"http://localhost/reprodata/dynamic_quotations/quotation_print.php?quotation=35&pdf=1\">Here</a><br>\r\n<br>\r\n<strong>Kemter Insurance</strong>', '20190530155455000000.pdf||KMCE200020.pdf', 'Message could not be sent. Could not instantiate mail function. \nError Attachment File Cannot find file - 20190530155455000000.pdf KMCE200020.pdf', '2019-05-30 15:54:55', '1', null, null);

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
INSERT INTO `settings` VALUES ('1', 'admin_default_layout', 'kemter', '2019-06-05 11:16:44', '0');
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
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `stock` VALUES ('147', '1', 'Transaction', 'Agreement Lock AGR-000078', 'Pending', '-1', '1', '2019-03-07 13:29:00', '3', '2019', '2019-03-07 13:29:00', '1', null, null);
INSERT INTO `stock` VALUES ('148', '1', 'Transaction', 'Agreement Lock AGR-000079', 'Pending', '-1', '1', '2019-03-07 13:32:41', '3', '2019', '2019-03-07 13:32:41', '1', null, null);
INSERT INTO `stock` VALUES ('149', '2', 'Transaction', 'Ticket:6 Open Ticket', 'Pending', '-1', '1', '2019-03-07 13:36:03', '3', '2019', '2019-03-07 13:36:03', '1', null, null);
INSERT INTO `stock` VALUES ('150', '7', 'Transaction', 'Ticket:6 Open Ticket', 'Pending', '-1', '1', '2019-03-07 13:36:03', '3', '2019', '2019-03-07 13:36:03', '1', null, null);
INSERT INTO `stock` VALUES ('151', '9', 'Transaction', 'Ticket:6 Open Ticket', 'Pending', '-1', '2', '2019-03-07 13:36:03', '3', '2019', '2019-03-07 13:36:03', '1', null, null);
INSERT INTO `stock` VALUES ('152', '11', 'Transaction', 'Initial', 'Pending', '1', '5', '2019-03-07 13:51:48', '3', '2019', '2019-03-07 13:51:48', '1', null, null);
INSERT INTO `stock` VALUES ('153', '11', 'Transaction', 'Agreement Lock AGR-000080', 'Pending', '-1', '1', '2019-03-07 13:53:24', '3', '2019', '2019-03-07 13:53:24', '1', null, null);
INSERT INTO `stock` VALUES ('154', '11', 'Transaction', 'Agreement Lock AGR-000081', 'Pending', '-1', '1', '2019-03-07 14:00:35', '3', '2019', '2019-03-07 14:00:35', '1', null, null);

-- ----------------------------
-- Table structure for therapies
-- ----------------------------
DROP TABLE IF EXISTS `therapies`;
CREATE TABLE `therapies` (
  `trp_therapy_ID` int(8) NOT NULL AUTO_INCREMENT,
  `trp_customer_ID` int(8) DEFAULT NULL,
  `trp_therapy_type_ID` int(8) DEFAULT NULL,
  `trp_therapy_blend_ID` int(8) DEFAULT NULL,
  `trp_notes` mediumtext,
  `trp_date_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `trp_duration` int(8) DEFAULT NULL,
  `trp_created_date_time` datetime DEFAULT NULL,
  `trp_created_by` int(8) DEFAULT NULL,
  `trp_last_update_date_time` datetime DEFAULT NULL,
  `trp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`trp_therapy_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of therapies
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of tickets
-- ----------------------------
INSERT INTO `tickets` VALUES ('1', 'TCK-000003', '1', '1', 'Open', '2018-11-24', '2019-01-28 12:24:24', '2019-01-28 12:24:24', '1', '2019-01-28 12:24:24', '1');
INSERT INTO `tickets` VALUES ('2', 'TCK-000004', '1', '-1', 'Closed', '2018-12-05', '2018-12-27 17:13:43', '2018-12-27 17:13:43', '1', '2018-12-27 17:13:43', '1');
INSERT INTO `tickets` VALUES ('3', 'TCK-000005', '1', '-1', 'Deleted', '2018-12-20', '2018-12-27 17:52:49', '2018-12-27 17:52:49', '1', '2018-12-27 17:52:49', '1');
INSERT INTO `tickets` VALUES ('4', 'TCK-000006', '1', '4', 'Open', '2019-01-07', '2019-01-28 12:24:45', '2019-01-28 12:24:45', '1', '2019-01-28 12:24:45', '1');
INSERT INTO `tickets` VALUES ('5', 'TCK-000007', '2', '3', 'Open', '2019-01-04', '2019-01-04 17:45:32', '2019-01-04 17:45:32', '1', '2019-01-04 17:45:32', '1');
INSERT INTO `tickets` VALUES ('6', 'TCK-000008', '1', '4', 'Open', '2019-03-07', '2019-03-07 13:36:39', '2019-03-07 13:36:39', '1', '2019-03-07 13:36:39', '1');
INSERT INTO `tickets` VALUES ('7', 'TCK-000009', '1', '1', 'Open', '2019-03-07', '2019-03-07 13:40:27', '2019-03-07 13:40:27', '1', '2019-03-07 13:40:27', '1');
INSERT INTO `tickets` VALUES ('8', 'TCK-000010', '8', '1', 'Outstanding', '2019-03-07', '2019-03-07 00:00:00', '2019-03-07 13:52:53', '1', '2019-03-07 13:52:53', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `ticket_events` VALUES ('8', '6', '1', '15', 'Delivery', '2019-03-07', '2019-03-07 13:34:41', '1', null, null);
INSERT INTO `ticket_events` VALUES ('9', '6', '1', '18', 'MachineService', '2019-03-07', '2019-03-07 13:35:12', '1', null, null);
INSERT INTO `ticket_events` VALUES ('10', '7', '1', '15', 'Delivery', '2019-03-07', '2019-03-07 13:37:29', '1', null, null);
INSERT INTO `ticket_events` VALUES ('11', '8', '1', '22', 'Delivery', '2019-03-07', '2019-03-07 13:54:39', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
INSERT INTO `ticket_products` VALUES ('28', '6', '2', '9', 'SparePart', '1', '2019-03-07 13:35:24', '1', '2019-03-07 13:35:24', '1');
INSERT INTO `ticket_products` VALUES ('29', '6', '7', '8', 'Consumable', '1', '2019-03-07 13:35:39', '1', null, null);
INSERT INTO `ticket_products` VALUES ('30', '6', '9', '8', 'Other', '2', '2019-03-07 13:35:49', '1', null, null);

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
INSERT INTO `users` VALUES ('2', '2', '0', 'Advanced User', 'advanced', 'advanced', '2', '', '', '', '', '', '', '0', '', '1', '0', '', '', '', null, null, '0', '0');
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
  `vit_market_prices` mediumtext COLLATE utf8_bin,
  `vit_created_date_time` datetime DEFAULT NULL,
  `vit_created_by` int(8) DEFAULT NULL,
  `vit_last_update_date_time` datetime DEFAULT NULL,
  `vit_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`vit_vitamin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of vitamins
-- ----------------------------
INSERT INTO `vitamins` VALUES ('1', '1', 'Vitamin', 'Osteoformula', 'Osteoformula', 'Calcium Magnesium  Vit D OsteoFormula', 'Large', '1000', '23.3', '44.99', '90', '8', '12', '15', 0x202048423A, '2019-05-27 01:06:09', '1', '2019-05-28 11:23:27', '1');
INSERT INTO `vitamins` VALUES ('2', '1', 'Supplement', 'Turmeric', 'Turmeric', 'Turmeric', 'Small', '500', '24.24', '42.99', '40', '0', '0', '0', 0x48423A203630306D67783130303D32342E39352C0D0A48423A203430306D67783130303D31362E3435, '2019-05-28 11:29:34', '1', '2019-05-28 11:30:26', '1');
INSERT INTO `vitamins` VALUES ('3', '1', 'Vitamin', 'Spirulina', 'Spirulina', 'Spirulina', 'Small', '90', '2.8', '5.99', '40', '0', '0', '0', 0x48423A203530306D6720783230303D32372E39350D0A48423A203530306D67207836303D31322E3935, '2019-05-28 11:38:43', '1', '2019-05-28 13:28:07', '1');
INSERT INTO `vitamins` VALUES ('4', '1', 'Vitamin', 'Collagen Marine', 'Collagen Marine', 'Collagen Marine', 'Small', '360', '12.5', '23.99', '40', '8', '11', '18', 0x48423A3730304D477836303D33322E393520287834303D323229, '2019-05-28 11:40:25', '1', '2019-05-28 11:45:12', '1');
INSERT INTO `vitamins` VALUES ('5', '1', 'Vitamin', 'C+', 'Vitamin C+', 'Vitamin C+', 'Large', '360', '7.46', '15.99', '90', '9', '11', '14', 0x48423A20313030306D67783132303D31382E393520287839303D31342E323029, '2019-05-28 12:12:00', '1', '2019-05-28 12:14:27', '1');
INSERT INTO `vitamins` VALUES ('6', '1', 'Vitamin', 'Green Coffee', 'Green Coffee', 'Green Coffee', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x4842203430306D67207834323D31342E3935, '2019-05-28 13:03:02', '1', null, null);
INSERT INTO `vitamins` VALUES ('7', '1', 'Vitamin', 'Macca', 'Macca', 'Macca', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x4842203530306D67207836303D31342E3935, '2019-05-28 13:03:59', '1', null, null);
INSERT INTO `vitamins` VALUES ('8', '1', 'Vitamin', 'D3', 'D3', 'D3', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48422032356D672078313030203D2031302E3935, '2019-05-28 13:05:14', '1', null, null);
INSERT INTO `vitamins` VALUES ('9', '1', 'Vitamin', 'Siberian Ginseng', 'Siberian Ginseng', 'Siberian Ginseng', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A203530306D6720783130303D32302E3935, '2019-05-28 13:05:52', '1', null, null);
INSERT INTO `vitamins` VALUES ('10', '1', 'Supplement', 'Glucosamine & Chodroitine', 'Glucosamine & Chodroitine', 'Glucosamine & Chodroitine', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A207836303D33302E39350D0A48423A204A6F696E742043617265206869676820737472656E6774682078313230203D2035302E3935, '2019-05-28 13:07:31', '1', '2019-05-28 13:25:14', '1');
INSERT INTO `vitamins` VALUES ('11', '1', 'Vitamin', 'Magnesium', 'Magnesium', 'Magnesium', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A203235306D6720783230303D32332E3935, '2019-05-28 13:10:00', '1', null, null);
INSERT INTO `vitamins` VALUES ('12', '1', 'Supplement', 'Omega 3 Extra', 'Omega 3 Extra', 'Omega 3 Extra', 'Large', '0', '0', '0', '0', '0', '0', '0', 0x48423A20466973684F696C20783130303D32302E39350D0A48423A204578747261207836303D33322E3935, '2019-05-28 13:11:43', '1', '2019-05-28 13:12:57', '1');
INSERT INTO `vitamins` VALUES ('13', '1', 'Supplement', 'Digestive Enzymes', 'Digestive Enzymes', 'Digestive Enzymes', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A204D756C7469207839303D392E34350D0A48423A20456E7A796D657320783130303D31382E3935, '2019-05-28 13:16:00', '1', null, null);
INSERT INTO `vitamins` VALUES ('14', '1', 'Supplement', 'Activated Charcoal', 'Activated Charcoal', 'Activated Charcoal', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A203236306D672078313030203D20382E3735, '2019-05-28 13:17:06', '1', null, null);
INSERT INTO `vitamins` VALUES ('15', '1', 'Supplement', 'Colon Cleanse', 'Colon Cleanse', 'Colon Cleanse', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A2078323430203D2032322E3935, '2019-05-28 13:18:15', '1', null, null);
INSERT INTO `vitamins` VALUES ('16', '1', 'Supplement', 'Probiotic Max', 'Probiotic Max', 'Probiotic Max', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A203362696C6C696F6E20783130303D31362E3435, '2019-05-28 13:20:50', '1', null, null);
INSERT INTO `vitamins` VALUES ('17', '1', 'Supplement', 'Apple Cider Vinegar', 'Apple Cider Vinegar', 'Apple Cider Vinegar', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A20506C61696E204369646572203330306D672078323030203D2031322E39350D0A48423A20436F6D706C6578207834303D31322E3435, '2019-05-28 13:33:14', '1', null, null);
INSERT INTO `vitamins` VALUES ('18', '1', 'Supplement', '5HTP', '5HTP', '5HTP 100mg', 'Small', '0', '0', '0', '40', '10', '13', '16', 0x48423A2035306D672078313230203D2033382E3935, '2019-05-28 13:39:28', '1', '2019-05-28 13:40:04', '1');
INSERT INTO `vitamins` VALUES ('19', '1', 'Mineral', 'Zinc', 'Zinc', 'Zinc', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A2032356D672078313030203D2031312E3935, '2019-05-28 13:43:04', '1', null, null);
INSERT INTO `vitamins` VALUES ('20', '1', 'Supplement', 'CoEnzyme Q10', 'CoEnzyme Q10', 'CoEnzyme Q10 30mg', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A2033306D672078323030203D2033352E3935, '2019-05-28 13:48:25', '1', null, null);
INSERT INTO `vitamins` VALUES ('21', '1', 'Supplement', 'Cod Liver Oil', 'Cod Liver Oil', 'Cod Liver Oil', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A20313030306D672078313230203D2031332E3935, '2019-05-28 13:50:36', '1', null, null);
INSERT INTO `vitamins` VALUES ('22', '1', 'Supplement', 'Super Garlic', 'Super Garlic', 'Super Garlic', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A20343030306D6720783235303D33382E39350D0A48423A203530306D672078313530203D2032322E3935, '2019-05-28 13:52:40', '1', null, null);
INSERT INTO `vitamins` VALUES ('23', '1', 'Supplement', 'Gingo Biloba', 'Gingo Biloba', 'Gingo Biloba', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A202035306D6720783132303D32302E39350D0A48423A203132306D6720783132303D33342E3935, '2019-05-28 13:56:43', '1', null, null);
INSERT INTO `vitamins` VALUES ('24', '1', 'Supplement', 'FlaxSeed Oil', 'FlaxSeed Oil', 'FlaxSeed Oil 1000mg', 'Large', '0', '0', '0', '90', '0', '0', '0', 0x48423A203530306D67207836303D20392E39350D0A48423A20313030306D672078313230203D2031382E3935, '2019-05-28 14:02:28', '1', '2019-05-28 14:07:08', '1');
INSERT INTO `vitamins` VALUES ('25', '1', 'Vitamin', 'Vitamin E', 'Vitamin E', 'Vitamin E 100 IU', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A203130306975207820323530203D2031342E3935, '2019-05-28 14:04:57', '1', null, null);
INSERT INTO `vitamins` VALUES ('26', '1', 'Supplement', 'Milk Thistle', 'Milk Thistle', 'Milk Thistle 100mg', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A203130306D6720783330203D2031332E3435, '2019-05-28 14:08:50', '1', null, null);
INSERT INTO `vitamins` VALUES ('27', '1', 'Supplement', 'Oregano Oil', 'Oregano Oil', 'Oregano Oil 25mg', 'Small', '0', '0', '0', '0', '0', '0', '0', 0x48423A2032356D6720783930203D2031342E3935, '2019-05-28 14:10:02', '1', null, null);
