/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : insurance

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 31/08/2020 17:27:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for _files
-- ----------------------------
DROP TABLE IF EXISTS `_files`;
CREATE TABLE `_files`  (
  `fle_file_ID` int(11) NOT NULL AUTO_INCREMENT,
  `fle_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fle_alt_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fle_file_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fle_file_location` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fle_file_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fle_addon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fle_addon_ID` int(8) NULL DEFAULT NULL,
  `fle_order` int(3) NULL DEFAULT NULL,
  `fle_primary` int(1) NULL DEFAULT NULL,
  `fle_created_date_time` datetime(0) NULL DEFAULT NULL,
  `fle_created_by` int(8) NULL DEFAULT NULL,
  `fle_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `fle_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`fle_file_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of _files
-- ----------------------------
INSERT INTO `_files` VALUES (26, 'dsffgdg', '', '26_1396282813980.jpg', '_files', 'jpg', 'EventsEvent', 2, 3, 0, '2019-11-27 16:00:33', 1, '2019-11-27 19:21:41', 1);
INSERT INTO `_files` VALUES (27, 'My title', 'Alt Name', '27_53845843_10155831316095755_7984942505093234688_n.jpg', '_files', 'jpg', 'EventsEvent', 2, 5, 0, '2019-11-27 16:26:15', 1, '2019-11-27 19:21:29', 1);
INSERT INTO `_files` VALUES (28, 'Belly', 'Belly', '28_54432316_10156291910983763_8406645891980591104_n.jpg', '_files', 'jpg', 'EventsEvent', 2, 4, 1, '2019-11-27 19:17:59', 1, '2019-11-27 19:21:34', 1);
INSERT INTO `_files` VALUES (29, 'Test', 'test', '29_54432316_10156291910983763_8406645891980591104_n.jpg', '_files', 'jpg', 'EventsEvent', 4, 1, 1, '2019-11-27 19:59:41', 1, NULL, NULL);
INSERT INTO `_files` VALUES (36, '', '', '36_I-can-do-it.jpg', '_files', 'jpg', 'EventsEvent', 5, 1, 1, '2019-12-16 20:30:40', 1, NULL, NULL);
INSERT INTO `_files` VALUES (37, '', '', '37_20160219_080639.jpg', '_files', 'jpg', 'EventsEvent', 5, 3, 0, '2019-12-16 20:30:48', 1, '2019-12-16 20:31:05', 1);
INSERT INTO `_files` VALUES (38, '', '', '38_calm in chaos.jpg', '_files', 'jpg', 'EventsEvent', 5, 2, 0, '2019-12-16 20:31:00', 1, '2019-12-16 20:31:05', 1);

-- ----------------------------
-- Table structure for _usr_users
-- ----------------------------
DROP TABLE IF EXISTS `_usr_users`;
CREATE TABLE `_usr_users`  (
  `usr_users_ID` int(8) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`usr_users_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of _usr_users
-- ----------------------------

-- ----------------------------
-- Table structure for ac_account_types
-- ----------------------------
DROP TABLE IF EXISTS `ac_account_types`;
CREATE TABLE `ac_account_types`  (
  `actpe_account_type_ID` int(8) NOT NULL AUTO_INCREMENT,
  `actpe_active` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actpe_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actpe_category` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actpe_owner_ID` int(8) NULL DEFAULT NULL,
  `actpe_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actpe_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actpe_created_date_time` datetime(0) NULL DEFAULT NULL,
  `actpe_created_by` int(8) NULL DEFAULT NULL,
  `actpe_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `actpe_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`actpe_account_type_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_account_types
-- ----------------------------
INSERT INTO `ac_account_types` VALUES (1, 'Active', 'Type', 'FixedAsset', NULL, '10', 'Fixed Assets', '2019-07-11 17:53:00', 1, '2019-09-23 15:37:55', 1);
INSERT INTO `ac_account_types` VALUES (2, 'Active', 'Type', 'Investment', NULL, '20', 'Investments', '2019-07-11 18:07:32', 1, '2019-09-23 15:38:00', 1);
INSERT INTO `ac_account_types` VALUES (3, 'Active', 'Type', 'CurrentAsset', NULL, '30', 'Current Assets', '2019-09-23 13:51:08', 1, '2019-09-23 15:38:04', 1);
INSERT INTO `ac_account_types` VALUES (4, 'Active', 'Type', 'CurrentLiability', NULL, '40', 'Current Liabilities', '2019-09-23 13:51:40', 1, '2019-09-23 15:38:09', 1);
INSERT INTO `ac_account_types` VALUES (5, 'Active', 'Type', 'LongTermLiability', NULL, '50', 'Long Term Liabilities', '2019-09-23 13:51:48', 1, '2019-09-23 15:38:13', 1);
INSERT INTO `ac_account_types` VALUES (6, 'Active', 'Type', 'CapitalReserve', NULL, '60', 'Capital & Reserves', '2019-09-23 13:52:03', 1, '2019-10-22 12:23:21', 1);
INSERT INTO `ac_account_types` VALUES (7, 'Active', 'Type', 'Revenue', NULL, '70', 'Operating Revenues', '2019-09-23 13:53:23', 1, '2019-10-22 12:24:27', 1);
INSERT INTO `ac_account_types` VALUES (8, 'Active', 'Type', 'Expense', NULL, '90', 'Operating Expenses', '2019-09-23 13:53:31', 1, '2019-10-22 12:25:04', 1);
INSERT INTO `ac_account_types` VALUES (9, 'Active', 'SubType', 'FixedAsset', 1, '1020', 'Furniture, Fixture & Fittings Cost', '2019-09-23 15:23:26', 1, '2019-09-23 15:54:25', 1);
INSERT INTO `ac_account_types` VALUES (10, 'Active', 'SubType', 'FixedAsset', 1, '1021', 'Furniture, Fixture & Fittings Depreciation', '2019-09-23 16:01:57', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (11, 'Active', 'SubType', 'FixedAsset', 1, '1030', 'Computer Hardware Cost', '2019-09-23 16:03:25', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (12, 'Active', 'SubType', 'FixedAsset', 1, '1031', 'Computer Hardware Depreciation', '2019-09-23 16:03:44', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (13, 'Active', 'SubType', 'FixedAsset', 1, '1035', 'Computer Software Cost', '2019-09-23 16:04:00', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (14, 'Active', 'SubType', 'FixedAsset', 1, '1036', 'Computer Software Depreciation', '2019-09-23 16:04:16', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (15, 'Active', 'SubType', 'FixedAsset', 1, '1040', 'Office Equipment Cost', '2019-09-23 16:04:43', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (16, 'Active', 'SubType', 'FixedAsset', 1, '1041', 'Office Equipment Depreciation', '2019-09-23 16:05:02', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (17, 'Active', 'SubType', 'FixedAsset', 1, '1050', 'Motor Vehicle', '2019-09-23 16:06:19', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (18, 'Active', 'SubType', 'FixedAsset', 1, '1051', 'Motor Vehicle Depreciation', '2019-09-23 16:06:43', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (19, 'Active', 'SubType', 'FixedAsset', 1, '1055', 'Curtains Cost', '2019-09-23 16:07:52', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (20, 'Active', 'SubType', 'FixedAsset', 1, '1056', 'Curtains Depreciation', '2019-09-23 16:08:07', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (21, 'Active', 'SubType', 'FixedAsset', 1, '1060', 'Air-Conditions Cost', '2019-09-23 16:12:11', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (22, 'Active', 'SubType', 'FixedAsset', 1, '1061', 'Air-Conditions Depreciation', '2019-09-23 16:12:24', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (23, 'Active', 'SubType', 'FixedAsset', 1, '1065', 'Electrical Installations Cost', '2019-09-23 16:14:56', 1, '2019-09-23 16:15:27', 1);
INSERT INTO `ac_account_types` VALUES (24, 'Active', 'SubType', 'FixedAsset', 1, '1066', 'Elecrical Installations Depreciation', '2019-09-23 16:15:19', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (25, 'Active', 'SubType', 'FixedAsset', 1, '1070', 'Telephones Cost', '2019-09-23 16:18:51', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (26, 'Active', 'SubType', 'FixedAsset', 1, '1071', 'Telephones Depreciation', '2019-09-23 16:19:05', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (27, 'Active', 'SubType', 'FixedAsset', 1, '1080', 'Machinery Cost', '2019-09-23 16:40:27', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (28, 'Active', 'SubType', 'FixedAsset', 1, '1081', 'Machinery Depreciation', '2019-09-23 16:40:40', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (29, 'Active', 'SubType', 'FixedAsset', 1, '1090', 'Investment Property Cost', '2019-09-23 16:41:17', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (30, 'Active', 'SubType', 'FixedAsset', 1, '1091', 'Investment Property Depreciation', '2019-09-23 16:41:30', 1, '2019-09-23 16:59:18', 1);
INSERT INTO `ac_account_types` VALUES (31, 'Active', 'SubType', 'FixedAsset', 1, '1000', 'Fixed Assets', '2019-10-14 09:58:23', 1, '2019-10-14 10:00:40', 1);
INSERT INTO `ac_account_types` VALUES (33, 'Active', 'SubType', 'CurrentAsset', 3, '3000', 'Current Assets', '2019-10-14 10:04:57', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (35, 'Active', 'SubType', 'CurrentAsset', 3, '3020', 'Trade Debtors', '2019-10-14 10:05:39', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (36, 'Active', 'SubType', 'CurrentAsset', 3, '3025', 'Other Debtors', '2019-10-14 10:06:17', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (37, 'Active', 'SubType', 'CurrentAsset', 3, '3030', 'Prepayments', '2019-10-14 10:07:01', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (38, 'Active', 'SubType', 'CurrentAsset', 3, '3040', 'Cash in Hand', '2019-10-14 10:07:39', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (39, 'Active', 'SubType', 'CurrentAsset', 3, '3050', 'Rent Receivable', '2019-10-14 10:08:49', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (40, 'Active', 'SubType', 'CurrentLiability', 4, '4000', 'Current Liabilities', '2019-10-14 10:09:51', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (41, 'Active', 'SubType', 'CurrentLiability', 4, '4010', 'Other Creditors', '2019-10-14 10:10:18', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (42, 'Active', 'SubType', 'CurrentLiability', 4, '4020', 'Trade Creditors', '2019-10-14 15:17:57', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (43, 'Active', 'SubType', 'CurrentLiability', 4, '4050', 'Short Term Bank Loans', '2019-10-14 15:18:54', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (44, 'Active', 'SubType', 'CurrentLiability', 4, '4080', 'Dividents', '2019-10-14 15:19:44', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (45, 'Active', 'SubType', 'LongTermLiability', 5, '5000', 'Long Term Liabilities', '2019-10-14 15:20:34', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (46, 'Active', 'SubType', 'LongTermLiability', 5, '5010', 'Long Term Loans', '2019-10-14 15:21:04', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (47, 'Active', 'SubType', 'CapitalReserve', 6, '6000', 'Capital & Reserves', '2019-10-14 15:21:52', 1, '2019-10-22 12:23:29', 1);
INSERT INTO `ac_account_types` VALUES (48, 'Active', 'SubType', 'CapitalReserve', 6, '6010', 'Share Capital', '2019-10-14 15:22:44', 1, '2019-10-22 12:23:50', 1);
INSERT INTO `ac_account_types` VALUES (49, 'Active', 'SubType', 'CapitalReserve', 6, '6090', 'Suspense Accounts', '2019-10-14 15:23:49', 1, '2019-10-22 12:23:59', 1);
INSERT INTO `ac_account_types` VALUES (50, 'Active', 'SubType', 'Revenue', 7, '7000', 'Operating Revenues', '2019-10-14 15:31:06', 1, '2019-10-22 12:24:36', 1);
INSERT INTO `ac_account_types` VALUES (51, 'Active', 'SubType', 'Revenue', 7, '7010', 'Commission Receivable', '2019-10-14 15:31:31', 1, '2019-10-22 12:24:43', 1);
INSERT INTO `ac_account_types` VALUES (52, 'Active', 'SubType', 'Revenue', 7, '7020', 'Cost of Sales', '2019-10-14 15:32:02', 1, '2019-10-22 12:24:50', 1);
INSERT INTO `ac_account_types` VALUES (53, 'Active', 'SubType', 'Revenue', 7, '7030', 'Other Income', '2019-10-14 15:32:40', 1, '2019-10-22 12:24:58', 1);
INSERT INTO `ac_account_types` VALUES (54, 'Active', 'SubType', 'Expense', 8, '9000', 'Operating Expenses', '2019-10-14 15:33:36', 1, '2019-10-22 12:25:12', 1);
INSERT INTO `ac_account_types` VALUES (55, 'Active', 'SubType', 'Expense', 8, '9010', 'Other Expenses', '2019-10-14 15:35:54', 1, '2019-10-22 12:25:18', 1);
INSERT INTO `ac_account_types` VALUES (56, 'Active', 'SubType', 'Expense', 8, '9020', 'Financial Expenses', '2019-10-14 15:36:13', 1, '2019-10-22 12:25:23', 1);
INSERT INTO `ac_account_types` VALUES (57, 'Active', 'SubType', 'Expense', 8, '9030', 'Third Party Commissions', '2019-10-14 15:36:48', 1, '2019-10-22 12:25:29', 1);
INSERT INTO `ac_account_types` VALUES (58, 'Active', 'SubType', 'Expense', 8, '9040', 'Taxation Expenses', '2019-10-14 15:37:07', 1, '2019-10-22 12:25:34', 1);
INSERT INTO `ac_account_types` VALUES (59, 'Active', 'SubType', 'FixedAsset', 1, '1010', 'Cash in Hand', '2019-10-15 09:59:59', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (60, 'Active', 'SubType', 'CurrentLiability', 4, '4070', 'Bank Accounts & Overdrafts', '2019-10-15 11:52:22', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (61, 'Active', 'SubType', 'CurrentAsset', 3, '3021', 'Insurance Comapnies Commission Receivables', '2019-11-06 15:28:52', 1, '2019-11-06 15:29:29', 1);
INSERT INTO `ac_account_types` VALUES (62, 'Active', 'SubType', 'Revenue', 7, '7011', 'Insurance Comapnies Commission Received', '2019-11-06 15:31:16', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (63, 'Active', 'SubType', 'Expense', 8, '9050', 'Sub Agents Commissions', '2019-11-16 19:45:22', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (64, 'Active', 'SubType', 'CurrentLiability', 4, '4090', 'Sub Agents Commissions Payable', '2019-11-16 19:48:11', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (65, 'Active', 'SubType', 'CurrentLiability', 4, '4030', 'Corporation Tax & Defence', '2020-01-07 13:48:31', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (66, 'Active', 'SubType', 'CurrentLiability', 4, '4060', 'Directors Current Accounts', '2020-01-07 13:49:02', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (67, 'Active', 'SubType', 'CurrentLiability', 4, '4085', 'Accruals', '2020-01-07 16:26:23', 1, NULL, NULL);
INSERT INTO `ac_account_types` VALUES (68, 'Active', 'SubType', 'CapitalReserve', 6, '6020', 'Reserves', '2020-01-07 16:28:37', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ac_accounts
-- ----------------------------
DROP TABLE IF EXISTS `ac_accounts`;
CREATE TABLE `ac_accounts`  (
  `acacc_account_ID` int(12) NOT NULL AUTO_INCREMENT,
  `acacc_active` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `acacc_entity_ID` int(8) NULL DEFAULT NULL,
  `acacc_control` int(1) NOT NULL DEFAULT 0,
  `acacc_parent_ID` int(12) NULL DEFAULT NULL,
  `acacc_account_type_ID` int(8) NULL DEFAULT NULL,
  `acacc_account_sub_type_ID` int(8) NULL DEFAULT NULL,
  `acacc_debit_credit` int(1) NULL DEFAULT NULL,
  `acacc_code` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_balance` decimal(10, 0) NULL DEFAULT 0,
  `acacc_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_work_tel` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_fax` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_website` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `acacc_created_on` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `acacc_created_by` int(8) NULL DEFAULT NULL,
  `acacc_last_update_on` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `acacc_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`acacc_account_ID`) USING BTREE,
  UNIQUE INDEX `primary_ID`(`acacc_account_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_accounts
-- ----------------------------
INSERT INTO `ac_accounts` VALUES (1, 'Active', NULL, 1, 0, 1, -1, 1, '10', 'Fixed Assets', 0, 'Fixed Assets Control', '', '', '', '', '', '2019-10-14 15:56:45', 1, '2019-10-14 15:56:45', 1);
INSERT INTO `ac_accounts` VALUES (3, 'Active', NULL, 1, 0, 3, -1, 1, '30', 'Current Assets', 0, 'Current Assets Control', '', '', '', '', '', '2019-10-10 16:14:54', 1, '2019-10-10 16:14:54', 1);
INSERT INTO `ac_accounts` VALUES (4, 'Active', NULL, 1, 0, 4, -1, 1, '40', 'Current Liabilities', 0, 'Current Liabilities Control', '', '', '', '', '', '2019-10-10 16:15:09', 1, '2019-10-10 16:15:09', 1);
INSERT INTO `ac_accounts` VALUES (5, 'Active', NULL, 1, 0, 5, -1, 1, '50', 'Long Term Liabilities', 0, 'Long Term Liabilities Control', '', '', '', '', '', '2019-10-10 16:15:17', 1, '2019-10-10 16:15:17', 1);
INSERT INTO `ac_accounts` VALUES (6, 'Active', NULL, 1, 0, 6, -1, 1, '60', 'Capital & Reserves', 0, 'Capital & Reserves Control', '', '', '', '', '', '2019-10-10 16:15:24', 1, '2019-10-10 16:15:24', 1);
INSERT INTO `ac_accounts` VALUES (7, 'Active', NULL, 1, 0, 7, -1, 1, '70', 'Operating Revenues', 0, 'Profit & Loss Control', '', '', '', '', '', '2019-10-18 12:23:10', 1, '2019-10-18 12:23:10', 1);
INSERT INTO `ac_accounts` VALUES (8, 'Active', NULL, 1, 0, 8, -1, 1, '90', 'Operating Expenses', 0, 'Expenses Control', '', '', '', '', '', '2019-10-18 12:23:34', 1, '2019-10-18 12:23:34', 1);
INSERT INTO `ac_accounts` VALUES (9, 'Active', NULL, 1, 0, 1, -1, 1, '1020', 'Furniture, Fixture & Fittings', 0, '', '', '', '', '', '', '2019-10-10 13:04:13', 1, '2019-10-10 13:04:13', 1);
INSERT INTO `ac_accounts` VALUES (10, 'Active', NULL, 1, 0, 1, -1, 1, '1030', 'Computer Hardware', 0, '', '', '', '', '', '', '2019-10-10 16:10:27', 1, '2019-10-10 16:10:27', 1);
INSERT INTO `ac_accounts` VALUES (11, 'Active', NULL, 1, 23, 1, -1, 1, '1035', 'Computer Software', 0, '', '', '', '', '', '', '2019-10-10 16:10:34', 1, '2019-10-10 16:10:34', 1);
INSERT INTO `ac_accounts` VALUES (12, 'Active', NULL, 1, 0, 1, 15, 1, '1040', 'Office Equipment', 0, '', '', '', '', '', '', '2019-10-23 13:04:47', 1, '2019-10-23 13:04:47', 1);
INSERT INTO `ac_accounts` VALUES (13, 'Active', NULL, 1, 23, 1, -1, 1, '1050', 'Motor Vehicle', 0, '', '', '', '', '', '', '2019-10-10 16:10:49', 1, '2019-10-10 16:10:49', 1);
INSERT INTO `ac_accounts` VALUES (14, 'Active', NULL, 0, 1, 1, 9, 1, '1020010', 'Furniture, Fixture & Fittings Cost', 0, '', '', '', '', '', '', '2019-10-21 15:53:42', 1, '2019-10-21 15:53:42', 1);
INSERT INTO `ac_accounts` VALUES (15, 'Active', NULL, 0, 9, 1, 10, 1, '1020020', 'Furniture, Fixture & Fittings Depreciation', 0, '', '', '', '', '', '', '2019-10-15 09:41:30', 1, '2019-10-15 09:41:30', 1);
INSERT INTO `ac_accounts` VALUES (16, 'Active', NULL, 0, 10, 1, 11, 1, '1030010', 'Computer Hardware Cost', 0, '', '', '', '', '', '', '2019-10-15 09:40:49', 1, '2019-10-15 09:40:49', 1);
INSERT INTO `ac_accounts` VALUES (17, 'Active', NULL, 0, 10, 1, 12, 1, '1030020', 'Computer Hardware Depreciation', 0, '', '', '', '', '', '', '2019-10-15 09:41:16', 1, '2019-10-15 09:41:16', 1);
INSERT INTO `ac_accounts` VALUES (18, 'Active', NULL, 0, 11, 1, 13, 1, '1035010', 'Computer Software Cost', 0, '', '', '', '', '', '', '2019-10-15 09:41:45', 1, '2019-10-15 09:41:45', 1);
INSERT INTO `ac_accounts` VALUES (19, 'Active', NULL, 0, 11, 1, 14, 1, '1035020', 'Computer Software Depreciation', 0, '', '', '', '', '', '', '2019-10-15 09:41:56', 1, '2019-10-15 09:41:56', 1);
INSERT INTO `ac_accounts` VALUES (20, 'Active', NULL, 0, 23, 1, 12, 1, '1031001', 'Supplier AAAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2019-10-22 12:44:32', 1, '2019-10-22 12:44:32', 1);
INSERT INTO `ac_accounts` VALUES (21, 'Active', 14, 0, 0, 8, 63, 1, '9050002', 'Anthimos Commissions', 0, '', '', '', '', '', '', '2019-11-20 12:09:54', 1, '2019-11-20 12:09:54', 1);
INSERT INTO `ac_accounts` VALUES (22, 'Active', NULL, 0, 7, 7, 50, -1, '7000001', 'AIG Commissions', 0, '', '', '', '', '', '', '2019-10-18 12:22:39', 1, '2019-10-18 12:22:39', 1);
INSERT INTO `ac_accounts` VALUES (23, 'Active', NULL, 1, 0, 8, -1, 1, '999', 'Commissions', 0, '', '', '', '', '', '', '2019-10-10 16:16:19', 1, '2019-10-10 16:16:19', 1);
INSERT INTO `ac_accounts` VALUES (24, 'Active', NULL, 0, 7, 8, 54, 1, '701001', 'Ydrogios Commissions', 0, '', '', '', '', '', '', '2019-10-15 09:42:32', 1, '2019-10-15 09:42:32', 1);
INSERT INTO `ac_accounts` VALUES (25, 'Active', NULL, 1, 0, 3, 35, 1, '3020', 'Trade Debtors', 0, '', '', '', '', '', '', '2019-10-23 13:37:48', 1, '2019-10-23 13:37:48', 1);
INSERT INTO `ac_accounts` VALUES (26, 'Active', NULL, 1, 4, 4, 42, -1, '4020', 'Trade Creditors', 0, '', '', '', '', '', '', '2019-10-25 14:50:25', 1, '2019-10-25 14:50:25', 1);
INSERT INTO `ac_accounts` VALUES (27, 'Active', 1, 0, 8, 8, 63, 1, '9050001', 'Michael Ermogenous Commissions', 0, '', '', '', '', '', '', '2019-11-20 12:12:28', 1, '2019-11-20 12:12:28', 1);
INSERT INTO `ac_accounts` VALUES (28, 'Active', NULL, 0, 0, 3, 38, 1, '3040000', 'Office Cash', 0, '', '', '', '', '', '', '2019-10-22 15:59:07', 1, '2019-10-22 15:59:07', 1);
INSERT INTO `ac_accounts` VALUES (29, 'Active', NULL, 0, 6, 6, 47, -1, '6000001', 'Capital', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (30, 'Active', NULL, 0, 4, 4, 60, -1, '4070010', 'Alpha Bank', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (31, 'Active', NULL, 1, 0, 1, 31, 1, '20', 'Investments', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (32, 'Active', NULL, 0, 25, 3, 35, 1, '3020001', 'Test Debtor', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (33, 'Active', NULL, 0, 25, 3, 35, 1, '3020002', 'Another test debtor', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (34, 'Active', 1, 0, 25, 3, 35, 1, '3020003', 'Michael Ermogenous', 0, '', '99420544', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (37, 'Active', 1, 0, 26, 4, 42, 1, '4020001', 'Michael Ermogenous', 0, '', '99420544', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (38, 'Active', 3, 0, 25, 3, 35, 1, '3020004', 'Michalis', 0, 'Michalis - Ermogenous', '99420544', '24123456', '24010101', 'ermogenousm@gmail.com', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (39, 'Active', 3, 0, 26, 4, 42, 1, '4020002', 'Michalis', 0, 'Michalis - Ermogenous', '99420544', '24123456', '24010101', 'ermogenousm@gmail.com', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (40, 'Active', 5, 0, 25, 3, 35, 1, '3020005', 'Cleopatra Skampartoni', 0, 'Cleopatra - Skampartoni', '', '234242342', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (42, 'Active', 5, 0, 26, 4, 42, 1, '4020003', 'Cleopatra Skampartoni', 0, 'Cleopatra - Skampartoni', '', '234242342', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (43, 'Active', NULL, 1, 3, 3, 61, 1, '3021', 'Insurance Comapnies Commission Receivables', 0, '', '', '', '', '', '', '2019-11-06 15:29:42', 1, '2019-11-06 15:29:42', 1);
INSERT INTO `ac_accounts` VALUES (44, 'Active', NULL, 1, 7, 7, 62, 1, '7011', 'Insurance Comapnies Commission Received', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (54, 'Active', 11, 0, 43, 3, 61, 1, '3021002', 'AIG Commission Receivable', 0, 'AIG Commission Receivable', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (55, 'Active', 11, 0, 44, 7, 62, 1, '7011002', 'AIG Commission Received', 0, 'AIG Commission Received', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (56, 'Active', 12, 0, 43, 3, 61, 1, '3021003', 'AIG Commission Receivable', 0, 'AIG Commission Receivable', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (57, 'Active', 12, 0, 44, 7, 62, 1, '7011003', 'AIG Commission Received', 0, 'AIG Commission Received', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (58, 'Active', 0, 1, 8, 8, 63, 1, '9050', 'Sub Agents Commissions', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (59, 'Active', 13, 0, 58, 8, 63, 1, '9050003', 'Agent 3 Paid', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (60, 'Active', 0, 0, 61, 4, 64, 1, '4090001', 'Agent 3 Commission Payable', 0, '', '', '', '', '', '', '2019-11-16 19:50:51', 1, '2019-11-16 19:50:51', 1);
INSERT INTO `ac_accounts` VALUES (61, 'Active', 0, 1, 4, 4, 64, 1, '4090', 'Sub Agents Commissions Payable', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (62, 'Active', 1, 0, 61, 4, 64, 1, '4090002', 'Michael Ermogenous Commissions Payable', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (63, 'Active', 14, 0, 61, 4, 64, 1, '4090003', 'Anthimos Anthimou Commissions Payable', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (64, 'Active', 15, 0, 43, 3, 61, 1, '3021004', 'ANYTIME Commission Receivable', 0, 'ANYTIME Commission Receivable', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (65, 'Active', 15, 0, 44, 7, 62, 1, '7011004', 'ANYTIME Commission Received', 0, 'ANYTIME Commission Received', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (66, 'Active', 16, 0, 43, 3, 61, 1, '3021005', 'DCARE Commission Receivable', 0, 'DCARE Commission Receivable', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (67, 'Active', 16, 0, 44, 7, 62, 1, '7011005', 'DCARE Commission Received', 0, 'DCARE Commission Received', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (68, 'Active', 17, 0, 43, 3, 61, 1, '3021006', 'ALTIUS Commission Receivable', 0, 'ALTIUS Commission Receivable', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (69, 'Active', 17, 0, 44, 7, 62, 1, '7011006', 'ALTIUS Commission Received', 0, 'ALTIUS Commission Received', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (70, 'Active', 2234, 0, 58, 8, 63, 1, '9050004', 'Agent 1 Paid Commissions', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (71, 'Active', 2235, 0, 58, 8, 63, 1, '9050005', 'Agent 2 Paid Commissions', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (72, 'Active', 2234, 0, 61, 4, 64, 1, '4090004', 'Agent 1 Commissions Payable', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);
INSERT INTO `ac_accounts` VALUES (73, 'Active', 2235, 0, 61, 4, 64, 1, '4090005', 'Agent 2 Commissions Payable', 0, '', '', '', '', '', '', NULL, 1, NULL, NULL);

-- ----------------------------
-- Table structure for ac_documents
-- ----------------------------
DROP TABLE IF EXISTS `ac_documents`;
CREATE TABLE `ac_documents`  (
  `acdoc_document_ID` int(8) NOT NULL AUTO_INCREMENT,
  `acdoc_active` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acdoc_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acdoc_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acdoc_number_prefix` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acdoc_number_leading_zeros` int(12) NULL DEFAULT NULL,
  `acdoc_number_last_used` int(8) NULL DEFAULT NULL,
  `acdoc_created_date_time` datetime(0) NULL DEFAULT NULL,
  `acdoc_created_by` int(8) NULL DEFAULT NULL,
  `acdoc_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `acdoc_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`acdoc_document_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_documents
-- ----------------------------
INSERT INTO `ac_documents` VALUES (1, 'Active', 'JSE', 'Journal Entries', 'JSE-', 6, 1, '2019-07-12 14:33:11', 1, '2019-10-15 11:07:08', 1);
INSERT INTO `ac_documents` VALUES (2, 'Active', 'JCC', 'JCC Card Payment', 'JCCCP-', 6, 0, '2019-07-12 15:20:23', 1, '2019-07-12 16:05:23', 1);
INSERT INTO `ac_documents` VALUES (3, 'Active', 'INSCOMM', 'Insurance Commissions', 'INSCOM-', 6, 182, '2019-08-24 20:32:22', 1, '2020-04-16 14:43:47', 1);

-- ----------------------------
-- Table structure for ac_entities
-- ----------------------------
DROP TABLE IF EXISTS `ac_entities`;
CREATE TABLE `ac_entities`  (
  `acet_entity_ID` int(8) NOT NULL AUTO_INCREMENT,
  `acet_active` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_mobile` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_work_tel` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_fax` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_website` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_birthdate` date NULL DEFAULT NULL,
  `acet_comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acet_tmp_import_ID` int(8) NULL DEFAULT NULL,
  `acet_created_date_time` datetime(0) NULL DEFAULT NULL,
  `acet_created_by` int(8) NULL DEFAULT NULL,
  `acet_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `acet_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`acet_entity_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2238 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_entities
-- ----------------------------
INSERT INTO `ac_entities` VALUES (1, 'Active', 'Michael Ermogenous', '', '99420544', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2, 'Active', 'Another Entity', 'Another Entity', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (3, 'Active', 'Michalis', 'Michalis - Ermogenous', '99420544', '24123456', '24010101', 'ermogenousm@gmail.com', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (4, 'Active', 'Mikes Mikelss', 'Mikes - Mikelss', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, 1);
INSERT INTO `ac_entities` VALUES (5, 'Active', 'Cleopatra Skampartoni', 'Cleopatra - Skampartoni', '', '234242342', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, 1);
INSERT INTO `ac_entities` VALUES (12, 'Active', 'AIG', 'AIG', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (13, 'Active', 'Agent 3', '', '', '', '', '', '', NULL, 'ag3333', NULL, NULL, 1, NULL, 1);
INSERT INTO `ac_entities` VALUES (14, 'Active', 'Anthimos Anthimou', '', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (15, 'Active', 'ANYTIME', 'ANYTIME', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (16, 'Active', 'DCARE', 'DCARE', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (17, 'Active', 'ALTIUS', 'ALTIUS', '', '', '', '', '', NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (19, 'Active', 'GREGORY CHARALAMBOUS', '', '99435723', '', '', 'gregory_sas@hotmail.com', '', '1979-03-21', '', 34247, '2020-01-05 08:51:57', 1, '2020-01-05 08:53:50', 1);
INSERT INTO `ac_entities` VALUES (20, 'Active', 'LEONIDAS DEMETRIS CHARALAMBOUS', '', '99435723', '', '', 'gregory_sas@hotmail.com', NULL, '2015-06-13', '', 34250, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (21, 'Active', 'LEONIDAS DEMETRIS CHARALAMBOUS', '', '99435723', '', '', 'gregory_sas@hotmail.com', NULL, '2015-06-13', '', 34251, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (22, 'Active', 'GEORGIA ZETA IOANNOU', '', '99552727', '', '', 'ncldmaria16@yahoo.com', NULL, '2015-05-08', '', 31808, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (23, 'Active', 'NIKOS KONSTANTA', '', '99614971', '', '', 'savnik11@yahoo.com', NULL, '0000-00-00', '', 34802, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (24, 'Active', 'CHRYSANTHI ATHINA GRIGORA', '', '24626332', '', '', 'agregoras@yahoo.com', NULL, '2011-10-03', '', 31928, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (25, 'Active', 'GRIGORIS GRIGORAS', '', '24626332', '', '', 'agregoras@yahoo.com', NULL, '2014-03-01', '', 31929, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (26, 'Active', 'MARIA-EIRINI TZIRKA', '', '24634344', '', '', 'mtzirka@hotmail.com', NULL, '1980-11-10', '', 34963, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (27, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΙΚΑΤΕΡΙΝΗ ', '', '', '', '', '', NULL, '0000-00-00', '', 32659, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (28, 'Active', 'XRISTOS SAVVA', '', '99423241', '', '', '', NULL, '1944-02-21', '', 31979, '2020-01-05 13:14:10', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (29, 'Active', 'ΔΙΑΓΡΑΦΗ ΚΩΣΤΑΣ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32738, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (30, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΤΥΛΙΑΝΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32757, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (31, 'Active', 'DOTOV VICHO', '', '99844368', '', '', '', NULL, '0000-00-00', '', 40802, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (32, 'Active', 'GIANAKIS XALIOS', '', '99107524', '', '', '', NULL, '1940-08-06', '', 31920, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (33, 'Active', 'AGGELIKI PIPIDE', '', '', '', '', '', NULL, '0000-00-00', '', 41108, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (34, 'Active', 'VACARU IVLIANA GINA', '', '99668303', '', '', 'ivliana_giulia93@yahoo.com', NULL, '1993-11-09', '', 34752, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (35, 'Active', 'ELENA SIMION', '', '96505141', '', '', 'simionelena1976@gmail.com', NULL, '0000-00-00', '', 41010, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (36, 'Active', 'ΒΑΣΙΛΕΙΟΣ ΠΑΡΑΣΧΙΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41384, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (37, 'Active', 'NIMADOLMA TAMANG', '', '99755852', '', '', '', NULL, '1987-02-21', '', 40699, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (38, 'Active', 'ΓΕΩΡΓΙΟΥ ΕΛΕΝΗ & ΠΕΤΡΟΣ ΓΕΩΡΓΙΟΥ & ΑΝΔΡΕΑΣ ΓΕΩΡΓΙΟ', '', '99533800', '', '', '', NULL, '0000-00-00', '', 33000, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (39, 'Active', 'ΕΡΜΗΝΕΙΑ ΒΡΑΧΙΜΗ', '', '99466032', '', '', '', NULL, '0000-00-00', '', 40872, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (40, 'Active', 'ΕΥΤΥΧΙΑ ΠΙΕΡΡΕΤΗ', '', '99665942', '', '', '', NULL, '0000-00-00', '', 41232, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (41, 'Active', 'GIANNIS GREGORIOU', '', '99300322', '', '', 'akis9197@gmail.com', NULL, '1991-06-01', '', 34885, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (42, 'Active', 'NIKOLINA PAPAPOLYVIOU', '', '99689690', '', '', '', NULL, '1995-06-21', '', 35775, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (43, 'Active', 'CHRISTINA GKRITZALI', '', '', '', '', 'gritzali25@gmail.com', NULL, '1994-05-25', '', 35701, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (44, 'Active', 'CHARIS SPYROU', '', '99973686', '', '', 'xaipiou@hotmail.co.uk', NULL, '1990-02-24', '', 40351, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (45, 'Active', 'ANDREAS CHRISTOFOROU', '', '97865898', '', '', 'andrechrismusic@gmail.com', NULL, '1190-11-25', '', 40449, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (46, 'Active', 'ΣΤΕΛΛΑ ΣΤΥΛΙΑΝΟΥ', '', '99626318', '', '', '', NULL, '0000-00-00', '', 40904, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (47, 'Active', 'ERRIKOS GREGORIOU', '', '99623811', '', '', 'akis9197@gmail.com', NULL, '1997-02-05', '', 34897, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (48, 'Active', 'IRAKLIS FENERIDES', '', '99807529', '', '', 'eraclenio028@hotmail.com', NULL, '1996-04-08', '', 40354, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (49, 'Active', 'ΑΝΤΡΕΑΣ ΜΙΧΑΗΛΙΔΗΣ', '', '99539148', '', '', '', NULL, '0000-00-00', '', 40868, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (50, 'Active', 'ΜΑΡΙΛΕΝΗ ΑΓΓΕΛΙΔΟΥ', '', '', '', '', '', NULL, '1996-03-08', '', 40784, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (51, 'Active', 'THEODOROS PIERIDES', '', '999045592', '', '', 'theodoros.pierides@live.com', NULL, '1992-02-16', '', 40680, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (52, 'Active', 'SOTIROULLA MAGIROY', '', '96329879', '', '', 'sotgraphicdesigner@gmail.com', NULL, '1992-02-17', '', 41231, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (53, 'Active', 'ΕΛΕΝΗ ΣΠΥΡΙΔΗ', '', '', '', '', '', NULL, '1990-05-31', '', 41037, '2020-01-05 13:22:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (54, 'Active', 'IOANNIS KATSIOU', '', '99292627', '', '', 'ioannis.katsios2000@gmail.com', NULL, '2000-02-11', '', 41215, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (55, 'Active', 'PANAGIOTA PIERETTI', '', '99234039', '', '', 'pa.pi11@@hotmail.com', NULL, '1998-06-30', '', 34866, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (56, 'Active', 'OURANIA MICHAEL', '', '', '', '', 'rania.michael@gmail.com', NULL, '1995-08-21', '', 40213, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (57, 'Active', 'ANDRIA THEODOSI', '', '', '', '', 'ctheodosi65@gmail.com', NULL, '2000-05-05', '', 40452, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (58, 'Active', 'STELLA CHRISTOFI', '', '', '', '', 'popi_demetriou@hotmail.gr', NULL, '1988-08-02', 'ΔΙΑΜΟΝΗ ΕΛΛΑΔΑ', 34890, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (59, 'Active', 'IOANNIS IOULIANOU', '', '24626161', '', '', 'marinosioulianou@gmail.com', NULL, '2000-09-03', '', 31932, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (60, 'Active', 'FEDRA STEFANOY', '', '99940999', '', '', '', NULL, '1990-07-31', '', 31887, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (61, 'Active', 'ΑΛΕΞΑΝΔΡΑ ΜΙΣΟΥ ', '', '99510080', '', '', '', NULL, '0000-00-00', '', 41260, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (62, 'Active', 'Stephanie Tsangari', '', '99048282', '77787770', '25251181', 'stephanie@aplus.com.cy', NULL, '1986-12-15', '', 32050, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (63, 'Active', 'KONSTANTINOS GIANNAKOU', '', '', '', '', '', NULL, '1988-07-05', '', 41227, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (64, 'Active', 'STYLIANOS CHRISTODOULOU', '', '', '', '', 'stelios1987@hotmail.com', NULL, '1987-04-16', '', 35324, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (65, 'Active', 'AGGELOS CHIMONAS', '', '', '', '', '', NULL, '0000-00-00', '', 40805, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (66, 'Active', 'IOANNA NIKA', '', '99852808', '', '', 'nana11982@gmail.com', NULL, '2000-07-26', '', 35202, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (67, 'Active', 'THEOCHARIS THEOCHARIDES', '', '99448134', '', '', 'theocy@hotmail.com', NULL, '1945-09-22', '', 35433, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (68, 'Active', 'ALEXANDROS LAPPAS', '', '99660452', '', '', 'lappask@gmail.com', NULL, '2000-09-16', '', 41226, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (69, 'Active', 'AIMILIA-TATIANA KARAVIOTI', '', '', '', '', 'aktoemterprises@cytanet.com.cy', NULL, '1999-01-22', '', 33493, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (70, 'Active', 'ANDREAS CONSTANTINOU', '', '99773456', '', '', 'ackonstantinou@hotmail.com', NULL, '1988-12-17', '', 40277, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (71, 'Active', 'ANGELOS NICOLAOU', '', '99812061', '', '', 'angelos@nicolaou.co', NULL, '1988-05-04', '', 40344, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (72, 'Active', 'NIKOLAS ANASTASIOU', '', '99913922', '', '', 'elenisn.world@gmail.com', NULL, '1987-08-10', '', 40227, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (73, 'Active', 'PANTELIS VOURIS', '', '96743885', '', '', 'akisvouris@gmail.com', NULL, '1988-06-22', '', 34861, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (74, 'Active', 'ANGELOS PETROU', '', '', '', '', '', NULL, '2001-02-04', '', 40259, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (75, 'Active', 'ELENA PANAYIOTOU', '', '99599335', '', '', 'stavros_5102@hotmail.com', NULL, '1987-08-21', '', 40967, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (76, 'Active', 'IOANNIS IOYLIANOU', '', '99223019', '', '', '', NULL, '1987-08-12', '', 31872, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (77, 'Active', 'NICHOLAS GEORGIOU', '', '99581263', '', '', 'nicholas.georgiou.85@gmail.com', NULL, '1985-08-29', '', 35696, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (78, 'Active', 'ΔΙΑΓΡΑΦΗ ΛΟΥΚΙΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32813, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (79, 'Active', 'Savvas Eleftheriou', '', '99668303', '', '', 'mpalourti@gmail.com', NULL, '2001-03-12', '', 32435, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (80, 'Active', 'ΠΑΡΑΣΚΕΥΗ ΜΠΛΕΤΣΑ', '', '99343339', '', '', '', NULL, '0000-00-00', '', 32806, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (81, 'Active', 'ANTONIOS KATECHAKIS', '', '', '', '', '', NULL, '0000-00-00', '', 35667, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (82, 'Active', 'ΣΤΑΥΡΟΣ ΣΤΑΥΡΑΚΗ', '', '99868792', '', '', '', NULL, '2000-04-09', '', 40370, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (83, 'Active', 'ΓΕΩΡΓΙΑΝΑ ΣΤΑΥΡΑΚΗ ', '', '', '', '', '', NULL, '2001-04-09', '', 41158, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (84, 'Active', 'ΑΝΑΣΤΑΣΗΣ ΓΡΗΓΟΡΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40287, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (85, 'Active', 'EYRIPIDI MOYSIKOS', '', '99940240', '', '', '', NULL, '1988-01-18', '', 31999, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (86, 'Active', 'FLORENTIA NICOLAOU', '', '99776880', '', '', 'fnicolaou@hotmail.com', NULL, '1988-01-23', '', 35685, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (87, 'Active', 'ΓΙΩΤΑ ΚΥΡΙΑΚΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40506, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (88, 'Active', 'MARINA MARCOU', '', '99853219', '', '', 'marinamarcou7@gmail.com', NULL, '2001-06-20', '', 41218, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (89, 'Active', 'IOANNA DEMETRIOU', '', '', '', '', '', NULL, '1988-01-13', '', 40466, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (90, 'Active', 'MARILIA KALOGIROU', '', '99397387', '', '', 'kalogiroumarilia@gmail.com', NULL, '2001-06-18', '', 41148, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (91, 'Active', 'MARIOS GEORGIOU', '', '99742965', '', '', 'g.marios@hotmail.com', NULL, '1987-12-12', '', 34819, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (92, 'Active', 'ΑΝΝΑ ΧΡΙΣΤΑΚΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40999, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (93, 'Active', 'ANDREAS CHRISTODOULOU', '', '96341380', '', '', '', NULL, '0000-00-00', '', 41301, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (94, 'Active', 'ΑΧΙΛΛΕΑΣ ΣΩΤΗΡΕΛΛΗΣ', '', '99404209', '', '', '', NULL, '1975-08-18', '', 31849, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (95, 'Active', 'STEFANI HARALAMBOUS', '', '99740048', '', '', '', NULL, '1988-10-05', '', 31921, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (96, 'Active', 'PETER VRACHAS', '', '99907836', '', '', 'petervrachas@gmail.com', NULL, '0000-00-00', '', 33639, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (97, 'Active', 'ANTREAS MAKROMALLIS', '', '', '', '', 'makromallis.a@gmail.com', NULL, '1988-04-08', '', 33498, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (98, 'Active', 'ELPINIKI NIKOLAOU', '', '99374873', '', '', 'e.nikolaou@avvapharma.com', NULL, '1987-08-10', '', 34919, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (99, 'Active', 'IOANNA MICHAILA', '', '24530288', '', '', 'chris.michaelas@gmail.com', NULL, '2005-04-05', '', 34277, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (100, 'Active', 'ANDREAS IOANNOU', '', '99347233', '', '', 'ioannoumarilena@yahoo.com', NULL, '2002-04-10', '', 33497, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (101, 'Active', 'ELEFTHERIOS THEMISTOCLEOUS', '', '', '', '', 'cthemistokleous@gmail.com', NULL, '2002-06-05', '', 34004, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (102, 'Active', 'IOANNA STEPHANOU', '', '99262025', '', '', 'ioanna.stephanou22@gmail.com', NULL, '1988-05-22', '', 35331, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (103, 'Active', 'PAVLOS CHARALAMBOUS', '', '96499610', '', '', 'icon-a@cytanet.com.cy', NULL, '1974-03-21', '', 35198, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (104, 'Active', 'ΧΡΙΣΤΑΚΗΣ ΓΕΩΡΓΙΟΥ', '', '96799091', '', '', '', NULL, '0000-00-00', '', 32997, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (105, 'Active', 'ATHANASIOS LENAS HADJISTYLLIS', '', '', '', '', '', NULL, '1992-09-29', '', 35164, '2020-01-05 13:22:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (106, 'Active', 'CONSTANTINOS HADJISTYLLIS', '', '99650575', '', '', '', NULL, '1990-08-28', '', 35163, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (107, 'Active', 'ANDREA CHRISTOFIDES', '', '99903332', '', '', 'christofides.andrea@gmail.com', NULL, '1988-12-07', '', 35654, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (108, 'Active', 'MARIA PANAGI', '', '', '', '', 'panagi.const@gmail.com', NULL, '2003-01-18', '', 34316, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (109, 'Active', 'MARIOS NARKISSOU', '', '', '', '', '', NULL, '1988-03-15', '', 40271, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (110, 'Active', 'MARIOS CHARALAMBOUS', '', '99900402', '', '', 'icon-a@cytanet.com.cy', NULL, '2000-02-02', '', 40206, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (111, 'Active', 'ΙΒΕΤΑ ΞΕΝΟΦΩΝΤΟΣ', '', '', '', '', '', NULL, '1994-10-25', '', 40713, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (112, 'Active', 'STELIOS THEODORIDES', '', '99941013', '', '', 'maria_kallishi@hotmail.com', NULL, '0000-00-00', '', 40499, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (113, 'Active', 'ΑΛΕΞΑΝΔΡΑ ΚΑΛΟΥΔΗ', '', '', '', '', '', NULL, '0000-00-00', '', 41165, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (114, 'Active', 'MARIELENA HADJIIANASTASIOU', '', '99317207', '', '', 'marilena.hadjianastasiou@gmail.com', NULL, '0000-00-00', '', 40766, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (115, 'Active', 'KONSTANTINOS AVRAAM KYRIACOU', '', '99434597', '', '', 'atermonas.engineering@gmail.com', NULL, '1990-05-14', '', 35303, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (116, 'Active', 'IOANNIS CONSTANTINOU', '', '97678716', '', '', 'trelos1948@gmail.com', NULL, '0000-00-00', '', 34796, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (117, 'Active', ' ', '', '96842884', '', '', '', NULL, '0000-00-00', '', 32996, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (118, 'Active', 'ANTRONIKOS THEOFILOU', '', '', '', '', '', NULL, '0000-00-00', '', 35689, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (119, 'Active', 'CHRYSI HARRINGTON IACOVOU', '', '99139670', '', '', '', NULL, '1978-03-04', '', 31834, '2020-01-05 13:22:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (120, 'Active', 'ΔΙΑΓΡΑΦΗ ΘΕΟΦΑΝΗΣ ΑΓΑΜΕΜΝΩΝΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 32812, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (121, 'Active', 'SYLVANA PIGASIOU', '', '', '', '', '', NULL, '2004-01-30', '', 40203, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (122, 'Active', 'THEOFANIS THEMISTOCLEOUS', '', '99443390', '', '', 'cthemistokleous@gmail.com', NULL, '2004-03-04', '', 34005, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (123, 'Active', 'NIKOLAS MILTIADOUS', '', '', '', '', '', NULL, '2004-04-28', '', 40166, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (124, 'Active', 'GEORGE IAN KOSSTRIN', '', '', '', '', '', NULL, '0000-00-00', '', 40799, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (125, 'Active', 'KYRIACOS + MARIA  SAVVIDE', '', '99581804', '', '', '', NULL, '0000-00-00', '', 31959, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (126, 'Active', 'VICTORIA DIDICHENKO', '', '491788190029', '', '', 'vicdidichenko@outlook.com', NULL, '1996-08-03', '', 33913, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (127, 'Active', 'KONSTANTINA  IOANNOU', '', '99552727', '', '', 'ncldmaria16@yahoo.com', NULL, '2004-09-20', 'American Express // 3777 556 710 13732 // 04/18 // MARIA NIKOLAIDOU', 31805, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (128, 'Active', 'ΑΝΑΤΟΛΗ ΠΑΝΚΕΒΙΤΣ', '', '99619558', '', '', '', NULL, '0000-00-00', '', 41229, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (129, 'Active', 'JOHN KYRIAKOU', '', '9635228', '', '', 'kenkyriacou@yahoo.ca', NULL, '1982-07-23', '', 35700, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (130, 'Active', 'YE QUN MILIOTIS', '', '97744209', '', '', 'zhangye', NULL, '1976-09-03', '', 40264, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (131, 'Active', 'KYRIAKI PANAGI', '', '', '', '', 'panagi.const@gmail.com', NULL, '2005-07-27', '', 34317, '2020-01-05 13:24:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (132, 'Active', 'Kyriakos Eleftheriou', '', '99668303', '', '', 'mpalourti@gmail.com', NULL, '2005-08-13', '', 32436, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (133, 'Active', 'STEPHANIE SYMEONIDI', '', '', '', '', '', NULL, '2005-09-05', '', 40335, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (134, 'Active', 'VICA KITSIOU', '', '99814415', '', '', '', NULL, '0000-00-00', 'ΑΝΔΡΟΜΕΔΑΣ ΠΛΑΤΕΙΑ 6 ΑΓ. ΑΝΑΡΓΥΡΟΙ', 32741, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (135, 'Active', 'CONSTANTIN KYRIAKOU', '', '99244966', '', '', 'kenkyriacou@yahoo.com', NULL, '0000-00-00', '', 35698, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (136, 'Active', 'ALEXANDROS IOANNOU', '', '99552727', '', '', 'ncldmaria16@yahoo.com', NULL, '2006-06-05', 'American Express // 3777 556 710 13732 // 04/18 // MARIA NIKOLAIDOU', 31804, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (137, 'Active', 'ΚΩΣΤΑΣ  ΠΑΤΣΑΛΟΣ', '', '99575333', '', '', '', NULL, '0000-00-00', 'ΠΑΝΑΓΙΑΣ ΑΙΜΑΤΟΥΣΗΣ ΛΕΩΦ. 63 ', 32739, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (138, 'Active', 'ANDRIANA MEMTSOUDI', '', '', '', '', '', NULL, '0000-00-00', '', 40411, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (139, 'Active', 'ANNA PIGASIOU', '', '', '', '', '', NULL, '2007-04-10', '', 40204, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (140, 'Active', 'Andreas Thoma', '', '', '', '', '', NULL, '2007-06-08', '', 31833, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (141, 'Active', 'ALEXANDROS ANDREOU', '', '', '', '', '', NULL, '2008-06-13', '', 40685, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (142, 'Active', 'TRIANTAFYLLOS MEMTSOUDIS', '', '', '', '', '', NULL, '0000-00-00', '', 40412, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (143, 'Active', 'CHRISTINA IOANNOU', '', '99552727', '', '', 'ncldmaria16@yahoo.com', NULL, '2008-12-27', 'American Express // 3777 556 710 13732 // 04/18 // MARIA NIKOLAIDOU', 31807, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (144, 'Active', 'APOSTOLOS MEMTSOUDIS', '', '96663272', '', '', 'apostolosmemtsoudis@gmail.com', NULL, '1973-07-26', '', 40409, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (145, 'Active', 'ΑΛΙΝΑ ΙΩΣΗΦ', '', '99879545', '', '', '', NULL, '1977-11-23', '', 31886, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (146, 'Active', 'STEFANOS THEMISTOCLEOUS', '', '99443390', '', '', 'cthemistokleous@gmail.com', NULL, '2009-09-21', '', 34043, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (147, 'Active', 'THEODOROS PANAGI', '', '', '', '', 'panagi.const@gmail.com', NULL, '2010-01-20', '', 34318, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (148, 'Active', 'ΑΝΤΡΙΑΝΑ ΜΑΡΙΑ ΖΑΧΑΡΙΑ', '', '', '', '', '', NULL, '0000-00-00', '', 35119, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (149, 'Active', 'CONSTANTINOS KAIMAKLIOTIS', '', '', '', '', '', NULL, '0000-00-00', '', 35662, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (150, 'Active', 'ΧΡΙΣΤΙΝΑ ΠΑΝΤΕΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 41039, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (151, 'Active', 'GEORGIA VARNAVA', '', '', '', '', '', NULL, '2011-03-30', '', 40568, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (152, 'Active', 'KATERINA PEREPELYTSYA', '', '99767844', '', '', 'perepelitsa@gmail.com', NULL, '1993-06-23', '', 41142, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (153, 'Active', 'THEA BUTTAFUOCO', '', '', '', '', '', NULL, '2011-03-30', '', 40258, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (154, 'Active', 'CHRISTINA PIGASIOU', '', '', '', '', '', NULL, '0000-00-00', '', 40205, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (155, 'Active', 'LOUKAS DIMITRIOU', '', '', '', '', '', NULL, '2011-08-08', '', 40225, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (156, 'Active', 'PETROS KOSTA', '', '', '', '', '', NULL, '2012-01-17', '', 40576, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (157, 'Active', 'MARILENA SOLOMOU', '', '', '', '', '', NULL, '2012-02-24', '', 40469, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (158, 'Active', 'ΙΩΑΝΝΗΣ ΔΡΑΚΟΣ', '', '99205484', '', '', '', NULL, '0000-00-00', '', 32736, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (159, 'Active', 'ATHINA STAVROU', '', '99579737', '', '', 'drstavrou@drstavrou.com', NULL, '2010-10-28', '', 34215, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (160, 'Active', 'ANGELOS PANAGI', '', '99581320', '', '', '', NULL, '2012-07-30', '', 33989, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (161, 'Active', 'CONSTANTINOS THEOFILOU', '', '', '', '', '', NULL, '0000-00-00', '', 35690, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (162, 'Active', 'SAVVAS ANASTASIOU', '', '', '', '', '', NULL, '2012-10-25', '', 40229, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (163, 'Active', 'MARILIA ERMOGENOUS', '', '', '', '', '', NULL, '2012-11-24', '', 40357, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (164, 'Active', 'EIRINI CHARALAMBOUS', '', '99886385', '', '', 'eirini.charalambous@hotmail.co.uk', NULL, '0000-00-00', '', 41162, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (165, 'Active', 'HARIS DIMITRIOU', '', '', '', '', '', NULL, '2013-04-22', '', 40226, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (166, 'Active', 'PAVLOS PARPERI', '', '', '', '', '', NULL, '2013-08-14', '', 40329, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (167, 'Active', 'STAVROS STAVROU', '', '99579737', '', '', 'drstavrou@drstavrou.com', NULL, '2013-08-05', '', 34246, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (168, 'Active', 'THEOCHARIS KAIMAKLIOTIS', '', '', '', '', '', NULL, '0000-00-00', '', 35663, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (169, 'Active', 'MARIAM KONSTANTINOU', '', '', '', '', '', NULL, '0000-00-00', '', 40497, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (170, 'Active', 'ANTHIA CHRISTOU', '', '99778967', '', '', 'antreas90maria@hotmail.com', NULL, '2014-06-04', '', 35007, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (171, 'Active', 'ΟΦΗΛΙΑ ΒΟΣΚΑΝΙΑΝ ΛΕΩΝΙΔΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41084, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (172, 'Active', 'ELEONORA MOVSEYAN', '', '99383260', '', '', '', NULL, '0000-00-00', '', 41264, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (173, 'Active', 'MARINA KOSTA', '', '', '', '', '', NULL, '2014-11-22', '', 40577, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (174, 'Active', 'VARVARA ARZHAKOVA', '', '', '', '', 'v.arzhakova@gmail.com', NULL, '1998-06-26', '', 40255, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (175, 'Active', 'ΚΩΣΤΑΣ ΠΑΝΑΓΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40955, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (176, 'Active', 'ANDREAS KARITTEVLI', '', '', '', '', '', NULL, '1945-01-27', '', 32032, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (177, 'Active', 'SIMI ABOUTBOUL', '', '99760987', '', '', 'simi.aboutboul@gmail.com', NULL, '1952-09-29', '', 35277, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (178, 'Active', 'ANDREAS GEORGIOU', '', '', '', '', '', NULL, '2015-09-08', '', 35697, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (179, 'Active', 'GEORGIA SOTERIOU', '', '', '', '', '', NULL, '0000-00-00', '', 40768, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (180, 'Active', 'THEODOROS THEODORIDES', '', '', '', '', '', NULL, '0000-00-00', '', 35694, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (181, 'Active', 'IOANNA SOLOMOU', '', '', '', '', '', NULL, '2015-11-16', '', 40470, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (182, 'Active', 'ELEFTHERIOS KONSTANTINOU', '', '', '', '', '', NULL, '0000-00-00', '', 40498, '2020-01-05 13:24:13', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (183, 'Active', 'HALA EVI ABDALLA', '', '', '', '', '', NULL, '2016-02-14', '', 40642, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (184, 'Active', 'DR ELLADA KALAITSIDOU ', '', '99174876', '', '', 'ellada.kalaitsidou@outlook.com', NULL, '0000-00-00', '', 41376, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (185, 'Active', 'STAVROS NEOPHYTOU', '', '', '', '', '', NULL, '0000-00-00', '', 40592, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (186, 'Active', 'NIKOLAS THEODORIDES', '', '', '', '', '', NULL, '0000-00-00', '', 40501, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (187, 'Active', 'ELEANNA PAPAGIANNI', '', '96647023', '', '', 'mpapagiannis@gmail.com', NULL, '0000-00-00', '', 40738, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (188, 'Active', 'SAVVAS HADJINIKOLAOU', '', '95172025', '', '', '', NULL, '0000-00-00', '', 41228, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (189, 'Active', 'ΝΙΚΟΛΕΤΤΑ ΤΣΟΥΜΕΝΗ ', '', '', '', '', '', NULL, '1990-03-16', '', 41338, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (190, 'Active', 'KLEOPATRA EVAGGELOU', '', '', '', '', '', NULL, '0000-00-00', '', 40326, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (191, 'Active', 'ADRIANA STYLIANIDES', '', '', '', '', '', NULL, '0000-00-00', '', 40448, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (192, 'Active', 'ELIAS BOU KHEIR', '', '96690638', '', '', '', NULL, '1988-05-24', '', 35208, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (193, 'Active', 'CELINA MARIA CHARALAMBOUS', '', '', '', '', 'gregory_sas@hotmail.gr', NULL, '2017-03-08', '', 33456, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (194, 'Active', 'IOANNA EVANGELOU', '', '', '', '', 'p.evangelou@ecoroad.com.cy', NULL, '2007-03-22', '', 33491, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (195, 'Active', 'ΒΑΣΙΛΕΙΟΣ ΚΑΛΛΙΝΙΚΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41223, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (196, 'Active', 'IRAKLIS ANASTASIOU', '', '', '', '', '', NULL, '2017-10-21', '', 40230, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (197, 'Active', 'ANDRIANA PARPERI', '', '', '', '', '', NULL, '2017-10-29', '', 40330, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (198, 'Active', 'NEFELI CHRISTOU', '', '99778967', '', '', 'antreas90maria@hotmail.com', NULL, '2017-11-02', '', 35008, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (199, 'Active', 'ARMINE SOGHOMONYAN ANTONIOU', '', '96894945', '', '', 'arminesoghomonyanantoniou@gmail.com', NULL, '1981-11-20', '', 40211, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (200, 'Active', 'ΙΩΑΝΝΗΣ ΣΤΥΛΙΑΝΟΥ', '', '', '', '', '', NULL, '2018-03-16', '', 40332, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (201, 'Active', 'IOULIA RICHARDS', '', '96002895', '', '', 'ioulia.jilly@gmail.com', NULL, '1995-03-14', '', 41214, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (202, 'Active', 'SOTIRIS MICHAEL', '', '', '', '', '', NULL, '0000-00-00', '', 35665, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (203, 'Active', 'IRENE ANDREA THEODORIDE', '', '', '', '', '', NULL, '0000-00-00', '', 40502, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (204, 'Active', 'ΜΑΡΙΑ ΣΤΥΛΙΑΝΟΥ', '', '93957165', '', '', '', NULL, '0000-00-00', '', 40759, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (205, 'Active', 'OLIVIER MICHEL REMI SAX', '', '', '', '', 'saxoliversax@gmail.com', NULL, '1971-10-26', '', 41265, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (206, 'Active', 'ΑΝΑΣΤΑΣΙΟΣ ΠΑΝΑΓΙΩΤΟΥ', '', '99650226', '', '', '', NULL, '0000-00-00', '', 41302, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (207, 'Active', 'ΙΩΑΝΝΗΣ ΕΠΑΜΕΙΝΩΝΤΑΣ', '', '99584141', '', '', '', NULL, '0000-00-00', '', 40891, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (208, 'Active', 'CHRYSTALLA  ARGYRIDOU', '', '99629561', '', '', '', NULL, '0000-00-00', '', 40935, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (209, 'Active', 'VICTORIA ANISIMOVA', '', '', '', '', '', NULL, '0000-00-00', '', 41177, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (210, 'Active', 'MARINA LEMYRE', '', '99900528', '', '', 'info@marinalemyre.com', NULL, '1986-09-09', '', 40643, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (211, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ ΝΕΟΦΥΤΟΥ', '', '99427685', '', '', '', NULL, '0000-00-00', '', 41388, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (212, 'Active', 'ΘΕΚΛΑ ΤΣΑΓΚΑΡΟΓΛΟΥ', '', '99800361', '', '', '', NULL, '0000-00-00', '', 41392, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (213, 'Active', 'ΓΙΩΡΓΟΣ ΣΤΑΣΗΣ', '', '', '', '', '', NULL, '1964-10-10', '', 31838, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (214, 'Active', 'ΑΝΔΡΕΑΣ ΝΙΚΑΝΔΡΟΥ', '', '22376360', '', '', '', NULL, '0000-00-00', '', 41194, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (215, 'Active', 'ΜΑΡΩ ΓΕΡΟΛΑΤΣΙΤΗ', '', '99644740', '', '', '', NULL, '0000-00-00', '', 40876, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (216, 'Active', 'diagrafi willia ', '', '24665315', '', '', '', NULL, '0000-00-00', '', 32836, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (217, 'Active', 'YOSEF AZOULAY', '', '24000300', '', '', '', NULL, '1959-08-07', '', 40285, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (218, 'Active', 'GLUHOVSKY VLADISLAV', '', '', '', '', '', NULL, '0000-00-00', '', 40976, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (219, 'Active', 'YISHAI HAIBI', '', '97885588', '', '', 'yishai.haibi@gmail.com', NULL, '1973-11-10', '', 40550, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (220, 'Active', 'GEORGIOS & THEODORA NICOLAOU ', '', '99058206', '', '', '', NULL, '0000-00-00', '', 35090, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (221, 'Active', 'ΦΑΙΔΡΑ ΣΤΕΦΑΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41193, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (222, 'Active', 'ΜΑΡΟΥΛΛΑ ΧΑΤΖΗΜΙΧΑΗΛ', '', '99805223', '', '', '', NULL, '0000-00-00', '', 40828, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (223, 'Active', 'ΑΝΤΩΝΗΣ ΑΝΤΩΝΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40840, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (224, 'Active', 'ΧΡΥΣΟΥΛΑ ΦΟΥΡΝΟΥ ΣΥΜΕΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40874, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (225, 'Active', 'ΑΝΔΡΕΑΣ ΜΟΥΣΚΟΣ', '', '99593434', '', '', '', NULL, '0000-00-00', '', 33020, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (226, 'Active', 'ΑΛΕΞΑΝΔΡΟΣ ΑΦΡΙΚΑΝΟΣ', '', '95147690', '', '', '', NULL, '0000-00-00', '', 40744, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (227, 'Active', 'ΕΛΕΝΗ ΕΥΘΥΜΙΟΥ', '', '99634294', '', '', '', NULL, '0000-00-00', '', 41407, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (228, 'Active', 'ΑΝΘΗ ΑΝΔΡΕΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40942, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (229, 'Active', 'ΛΕΑΝΔΡΟΣ ΜΙΧΑΗΛ', '', '99350372', '', '', '', NULL, '0000-00-00', '', 40871, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (230, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΥΛΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32807, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (231, 'Active', 'ΓΕΩΡΓΙΟΣ ΕΥΘΥΜΙΟΥ', '', '99634294', '', '', '', NULL, '0000-00-00', '', 40912, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (232, 'Active', 'ΑΝΔΡΕΑΣ ΟΡΦΑΝΟΥ', '', '99434271', '', '', '', NULL, '0000-00-00', '', 41234, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (233, 'Active', 'ΠΑΡΑΣΚΕΥΑΣ-ΧΡΗΣΤΟΣ ΠΑΠΑΓΕΩΡΓΙΟΥ', '', '99300269', '', '', '', NULL, '0000-00-00', '', 32808, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (234, 'Active', 'ΓΙΩΡΓΟΣ ΜΙΣΣΙΗ', '', '99665161', '', '', '', NULL, '0000-00-00', '', 41202, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (235, 'Active', 'NATASHA IRISE LINTON', '', '99876815', '', '', '', NULL, '0000-00-00', '', 32752, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (236, 'Active', 'JANISE MASLEN', '', '99475669', '', '', '', NULL, '0000-00-00', '', 32449, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (237, 'Active', 'IVANOV NIKIFOROV ATANAS', '', '99655149', '99833786', '', '', NULL, '1951-12-20', '', 31858, '2020-01-05 13:24:14', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (238, 'Active', 'ΜΑΡΙΑ ΒΕΝΙΖΕΛΟΥ', '', '99649447', '', '', '', NULL, '0000-00-00', '', 41239, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (239, 'Active', 'KYRIAKI KTORIDOU', '', '99994987', '', '', '', NULL, '0000-00-00', '', 41327, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (240, 'Active', 'ΔΙΑΓΡΑΦΗ NIKOS ATHANASIOY', '', '', '', '', '', NULL, '0000-00-00', '', 31970, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (241, 'Active', 'ΚΥΡΙΑΚΟΥ ΠΑΠΑΔΟΠΟΥΛΟΥ', '', '24428004', '', '', '', NULL, '0000-00-00', '', 40869, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (242, 'Active', 'JURIS KUKLIS', '', '', '', '', '', NULL, '0000-00-00', '', 40960, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (243, 'Active', 'ΝΙΚΟΛΑΣ ΒΑΤΥΛΙΩΤΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40481, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (244, 'Active', 'ΔΗΜΗΤΡΙΟΣ ΜΑΡΑΒΕΛΙΑΣ', '', '96152850', '', '', '', NULL, '0000-00-00', '', 40482, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (245, 'Active', 'ΚΥΠΡΟΣ ΓΡΗΓΟΡΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40483, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (246, 'Active', 'ΠΑΥΛΟΣ ΘΕΜΙΣΤΟΚΛΕΟΥΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40477, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (247, 'Active', 'ΕΛΠΙΔΑ ΠΑΛΑΙΧΩΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40480, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (248, 'Active', 'ΧΑΡΑΛΑΜΠΙΑ ΘΕΟΚΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40479, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (249, 'Active', 'ΦΑΝΟΣ ΘΕΟΦΑΝΟΥΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40478, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (250, 'Active', 'ΕΛΕΥΘΕΡΙΑ ΧΑΤΖΗΣΥΜΕΟΥ', '', '25622081', '', '', '', NULL, '0000-00-00', '', 41188, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (251, 'Active', 'ΣΤΥΛΙΑΝΗ ΑΔΩΝΗ', '', '99201766', '', '', '', NULL, '1948-09-13', '', 31851, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (252, 'Active', 'ΑΝΔΡΕΑΣ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '1947-06-14', '', 31485, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (253, 'Active', 'STEVEN SMITH', '', '99047763', '', '', '', NULL, '1958-06-07', '', 31913, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (254, 'Active', 'ΔΗΜΗΤΡΑ  ΑΝΔΡΕΟΥ', '', '99699837', '', '', '', NULL, '1948-10-26', '', 31968, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (255, 'Active', 'ΠΑΝΤΕΛΗΣ ΧΑΤΖΗΜΙΛΤΙΑΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40826, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (256, 'Active', 'ΦΩΤΕΙΝΗ ΓΙΑΝΝΟΥΛΛΑΚΗ', '', '99350859', '', '', '', NULL, '1947-11-09', '', 31836, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (257, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΤΑΥΡΟΣ ', '', '', '', '', '', NULL, '1948-05-04', '', 31916, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (258, 'Active', 'ΚΩΣΤΑΣ ΚΙΤΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41274, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (259, 'Active', 'ANNA ΣABBA', '', '', '', '', '', NULL, '1945-12-13', '', 31865, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (260, 'Active', 'ΓΕΩΡΓΙΟΣ ΝΙΚΟΛΑΟΥ', '', '99540033', '', '', '', NULL, '0000-00-00', '', 40878, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (261, 'Active', 'ΑΛΕΞΑΝΔΡΟΣ ΧΑΡΑΛΑΜΠΟΥΣ', '', '99664832', '', '', '', NULL, '0000-00-00', '', 40910, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (262, 'Active', 'ΕΛΛΗ  ΑΛΑΜΠΡΙΤΗ', '', '24532110', '', '', '', NULL, '0000-00-00', '', 40278, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (263, 'Active', 'ANDREAS PALLOURAS', '', '99537707', '', '', '', NULL, '0000-00-00', '', 31911, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (264, 'Active', 'ΣΒΕΤΛΑΝΑ ΜΙΝΑΣΙΔΟΥ ', '', '', '', '', '', NULL, '1970-01-01', '', 40673, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (265, 'Active', 'διαγραμμενοσ  ', '', '99638796', '', '', '', NULL, '1947-11-17', '', 31936, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (266, 'Active', 'ΜΙΧΑΛΑΚΗΣ ΣΤΕΛΙΟΥ', '', '99345509', '', '', '', NULL, '0000-00-00', '', 33027, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (267, 'Active', 'VACARU IVLIANA GINA', '', '96701463', '', '', 'ivliana_giulia93@yahoo.com', NULL, '1993-11-09', '', 34749, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (268, 'Active', 'GEORGIA IOANNOY', '', '99299637', '', '', '', NULL, '1949-10-12', '', 31986, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (269, 'Active', 'MICHALIS HADJIMICHAEL', '', '99358630', '', '', 'magdahadjimichael@visitcyprus.com', NULL, '1948-12-26', '', 41373, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (270, 'Active', 'ΚΥΡΙΑΚΗ ΛΟΥΚΑ', '', '', '', '', '', NULL, '0000-00-00', '', 40974, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (271, 'Active', 'ΔΑΦΝΗ ΦΙΝΟΠΟΥΛΟΥ', '', '99338053', '', '', '', NULL, '0000-00-00', '', 41349, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (272, 'Active', 'ΔΙΑΓΡΑΦΗ ΙΩΑΝΝΑ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32991, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (273, 'Active', 'ΓΕΩΡΓΙΟΣ ΝΙΚΟΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41102, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (274, 'Active', 'ANDREAS KYPRIANOY', '', '99924196', '', '', '', NULL, '1953-03-25', '', 31967, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (275, 'Active', 'ΑΝΘΗ ΚΑΜΙΝΑΡΙΔΟΥ', '', '99470507', '', '', '', NULL, '0000-00-00', '', 40875, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (276, 'Active', 'ΧΡΗΣΤΟΣ ΧΡΥΣΑΦΗΣ-ACCEPTUS GYM', '', '', '', '', '', NULL, '0000-00-00', '', 40612, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (277, 'Active', 'ΓΕΩΡΓΙΟΣ  ΜΑΝΟΥΣΑΡΙΔΗΣ', '', '99595474', '', '', '', NULL, '1954-02-17', '', 40658, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (278, 'Active', 'KYRIACOS KYRIAKOY', '', '24533373', '', '', '', NULL, '1955-06-04', '', 31978, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (279, 'Active', 'ΦΟΣΤΙΡΑ ΓΑΒΡΗΙΛ', '', '99479751', '', '', '', NULL, '1954-06-23', '', 31860, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (280, 'Active', 'ΦΑΝΗ ΠΑΣΙΑΛΗ', '', '99336072', '', '', '', NULL, '0000-00-00', '', 41235, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (281, 'Active', 'ΝΙΚΟΣ ΜΙΧΑΗΛ', '', '99695027', '', '', '', NULL, '0000-00-00', '', 41221, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (282, 'Active', 'Άντρη Ζανεττή', '', '99407917', '', '', '', NULL, '0000-00-00', '', 32447, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (283, 'Active', 'CHARALAMBOS MAIMARIS', '', '22385643', '', '', 'mamimarisb@gmail.com', NULL, '1951-12-30', '', 33708, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (284, 'Active', 'DIAGRAFH MIXALI ', '', '99688786', '', '', '', NULL, '1953-04-01', '', 32039, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (285, 'Active', 'FANOURIOS PAPAKYRIAKOU', '', '99317712', '', '', '', NULL, '1955-08-27', '', 35539, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (286, 'Active', 'GAVRIEL MINA', '', '99620794', '', '', 'gavrielmina@cytanet.com.cy', NULL, '1955-05-20', '', 35462, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (287, 'Active', 'LAMPROS SPYROU', '', '99634016', '', '', 'alandreou21@yahoo.com', NULL, '1956-06-11', '', 34891, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (288, 'Active', 'MAROULLA TSITOURI', '', '', '', '', 'gt@cubectrl.com', NULL, '1955-12-22', '', 35657, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (289, 'Active', 'ELENI KYPRIANOY', '', '99337618', '', '', '', NULL, '1955-11-22', '', 32034, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (290, 'Active', 'Androulla Theodoulou', '', '22621844', '', '', 'andeloboutique@gmail.com', NULL, '1950-01-25', '', 34792, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (291, 'Active', 'Demetrios Tzirkas', '', '24634344', '', '', 'dimitristzirkas@gmail.com', NULL, '1952-04-02', '', 34964, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (292, 'Active', 'ΜΑΡΙΑ ΚΑΡΑΚΩΣΤΑ', '', '24423057', '', '', '', NULL, '0000-00-00', '', 40503, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (293, 'Active', 'ΔΙΑΓΡΑΦΗ ΚΟΔΡΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32815, '2020-01-05 13:24:15', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (294, 'Active', 'ΔΙΑΓΡΑΦΗ ΝΑΚΟΥ ΝΑΚΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 32656, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (295, 'Active', 'DANIELLA BEATRIC CALINCIUC', '', '', '', '', '', NULL, '0000-00-00', '', 41081, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (296, 'Active', 'DIAGRAFI DRESCA BOGDAN', '', '', '', '', '', NULL, '1977-09-24', '', 31853, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (297, 'Active', 'ΕΥΑΓΓΕΛΟΣ ΔΕΤΣΙΚΑΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41001, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (298, 'Active', 'RYS MIROSLAW', '', '99874106', '', '', '', NULL, '0000-00-00', '', 41180, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (299, 'Active', 'ΔΙΑΓΡΑΦΗ ΜΑΡΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32780, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (300, 'Active', 'ΘΕΟΔΩΡΟΣ ΑΡΑΜΠΑΜΠΑΣΛΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 33013, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (301, 'Active', 'SOFIYA KHALMURZAYEVA', '', '96816178', '', '', '', NULL, '1979-09-10', '', 32063, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (302, 'Active', 'IOAN GHEORGHE GROZA', '', '', '', '', '', NULL, '0000-00-00', '', 41184, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (303, 'Active', 'LUBOS VASUT', '', '', '', '', '', NULL, '0000-00-00', '', 41082, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (304, 'Active', 'HECTOR AUGUSTO GUZMAN', '', '95957165', '', '', '', NULL, '0000-00-00', '', 40743, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (305, 'Active', 'OLGA DYNYAK', '', '', '', '', '99885360', NULL, '0000-00-00', '', 40746, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (306, 'Active', 'KYRIAKOS KYRIAKOU', '', '99462732', '', '', 'kenkyriacou@yahoo.ca', NULL, '1954-08-07', '', 35699, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (307, 'Active', 'ΜΑΡΙΑ ΝΙΚΟΛΑΙΔΟΥ', '', '99567029', '', '', '', NULL, '1954-01-01', '', 40748, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (308, 'Active', 'SUZAN ELISABETH LOURENSZ', '', '', '', '', 'slourensz@icloud.com', NULL, '1962-06-21', '', 35341, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (309, 'Active', 'ELENI KAIMAKLIOTI', '', '99301360', '', '', 'gabriel@kaimakliotislaw.com', NULL, '1955-02-05', '', 32079, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (310, 'Active', 'RONALD STEPHEN BUSWELL', '', '99164641', '', '', '', NULL, '1956-01-02', '', 35706, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (311, 'Active', 'IAKOV VAYSMAN', '', '', '', '', '', NULL, '0000-00-00', '', 40293, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (312, 'Active', 'EVRIPIDES STYLIANOU', '', '99567206', '', '', 'cstylianou86@hotmail.co.uk', NULL, '1957-02-17', '', 35463, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (313, 'Active', 'ΧΡΙΣΤΟΘΕΑ ΣΟΛΩΜΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40865, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (314, 'Active', 'ROONEY WOOLLISCROFT', '', '97611092', '', '', 'rodneywoolliscroft@hotmail.com', NULL, '1955-12-07', '', 40623, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (315, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΑΘΑΝΑΣΙΟΥ', '', '99698207', '', '', '', NULL, '0000-00-00', '', 41240, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (316, 'Active', 'Megan Darbyshire', '', '99811642', '', '', 'magicalmarcos69@yahoo.com', NULL, '0000-00-00', '4548 9134 0019 6759 // 03/19 // MARK MORLAND DARBYSHIRE', 31800, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (317, 'Active', 'ΑΝΔΡΕΑΣ ΚΟΥΠΠΗΣ', '', '99570656', '', '', '', NULL, '0000-00-00', '', 41262, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (318, 'Active', 'ΑΝΔΡΕΑΣ ΧΡΥΣΟΧΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40892, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (319, 'Active', 'ΚΑΤΕΡΙΝΑ ΑΓΑΘΟΚΛΕΟΥΣ', '', '99485809', '', '', '', NULL, '0000-00-00', '', 41391, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (320, 'Active', 'GEORGE KATECHAKIS', '', '', '', '', 'george.katechakis@krinera.com', NULL, '1967-05-12', '', 35655, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (321, 'Active', 'ΠΑΥΛΟΣ ΠΑΥΛΟΥ', '', '99688070', '', '', '', NULL, '0000-00-00', '', 41222, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (322, 'Active', 'ΑΝΔΡΟΥΛΑ ΧΑΠΟΥΠΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40614, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (323, 'Active', 'FADIEL CHARALAMBOU', '', '', '', '', '', NULL, '1945-10-28', '', 35048, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (324, 'Active', 'KYPROS PROESTOS', '', '99584891', '', '', '', NULL, '1957-09-17', '', 35719, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (325, 'Active', 'ANDROULA  XENOFONDOS', '', '24530639', '', '', '', NULL, '0000-00-00', '', 31989, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (326, 'Active', 'EMILIOS RICHARD', '', '97835492', '', '', 'emiliosmrichards@gmail.com', NULL, '1998-08-20', '', 41150, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (327, 'Active', 'NICOLA KIRBY', '', '99681735', '', '', 'nickykirby_1999@yahoo.co.uk', NULL, '1970-03-02', '', 41114, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (328, 'Active', 'ANDREW  HOGG', '', '97786100', '', '', 'andrew@granco.it', NULL, '1965-06-21', '', 41380, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (329, 'Active', 'ΘΕΟΠΙΣΤΗ ΛΟΥΚΑ', '', '99332031', '', '', '', NULL, '0000-00-00', '', 41195, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (330, 'Active', 'ΓΙΑΝΝΑΚΗΣ ΑΝΔΡΕΟΥ', '', '99337277', '', '', '', NULL, '0000-00-00', '', 41035, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (331, 'Active', 'DEBRA HARRIS', '', '97672379', '', '', 'wavelyrrus2002@yahoo.co.uk', NULL, '1958-11-24', '', 40703, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (332, 'Active', 'DEMETRIS GREGORIOU', '', '99623411', '', '', 'akis9197@gmail.com', NULL, '1958-03-20', '', 34894, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (333, 'Active', 'ΚΥΡΙΑΚΟΣ ΜΑΛΛΙΑΠΠΗΣ ', '', '99497548', '', '', '', NULL, '1950-07-27', '', 41419, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (334, 'Active', 'ΚΑΤΕΡΙΝΑ ΑΧΑΙΟΥ', '', '96728835', '', '', '', NULL, '0000-00-00', '', 32990, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (335, 'Active', 'ΜΑΡΓΑΡΙΤΑ ΔΙΠΛΑΡΟΥ', '', '99589365', '', '', '', NULL, '1959-06-03', '', 31848, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (336, 'Active', 'AGGELOS XAROYS', '', '99665367', '', '', '', NULL, '1959-07-03', '', 31984, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (337, 'Active', 'GEORGIOS XASAPIS', '', '99652188', '', '', '', NULL, '1958-07-09', '', 31882, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (338, 'Active', 'ΣΑΒΒΑΣ ΟΝΗΣΙΦΟΡΟΥ', '', '99688045', '', '', '', NULL, '1960-02-05', '', 32009, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (339, 'Active', 'GIANNA LOUKA', '', '', '', '', 'gianna.louka@swissport.com', NULL, '1959-05-27', '', 35461, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (340, 'Active', 'ALEXANDER WILKIE BRACELAND ', '', '', '', '', '', NULL, '1959-04-06', '', 40289, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (341, 'Active', 'ANNA PETROY', '', '99145636', '', '', '', NULL, '1960-03-14', '', 31905, '2020-01-05 13:24:16', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (342, 'Active', 'ΣΤΕΛΙΟΣ ΛΟΡΔΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40797, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (343, 'Active', 'ΑΓΓΕΛΙΚΗ ΑΓΑΠΙΟΥ', '', '99517175', '', '', '', NULL, '1958-08-05', '', 40280, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (344, 'Active', 'ΑΥΓΗ ΧΡΙΣΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40224, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (345, 'Active', 'ALEXANDRA GAVRIILIDOU', '', '97771440', '', '', '', NULL, '0000-00-00', '', 41090, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (346, 'Active', 'KYRIACOS PANAYI', '', '99348770', '96409662', '', '', NULL, '1960-04-08', '', 31953, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (347, 'Active', 'ΑΝΑΣΤΑΣΙΑ ΝΙΚΟΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40862, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (348, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΖΑΝΝΕΤΟΥ', '', '97668669', '', '', '', NULL, '0000-00-00', '', 40758, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (349, 'Active', 'YIANNAKIS PAPALI', '', '99619904', '', '', 'chrystalla.p@ctcgroup.com', NULL, '1959-04-11', '', 41020, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (350, 'Active', 'LOUKIA SAVVIDOU', '', '', '', '', 'savvidou_loukia@hotmail.com', NULL, '1959-01-06', '', 41056, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (351, 'Active', 'CHRISTAKIS NEOFYTOU', '', '99631162', '', '', 'neofytouchristakis@gmail.com', NULL, '1959-12-25', '', 41201, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (352, 'Active', 'ΝΕΟΦΥΤΟΣ ΠΟΛΥΒΙΟΥ', '', '99307553', '99337618', '', '', NULL, '1962-01-05', '', 31845, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (353, 'Active', 'PHILIOS PHYLAKTOU', '', '', '', '', '', NULL, '0000-00-00', '', 35085, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (354, 'Active', 'MICHALAKIS MOUSICOU', '', '', '', '', '', NULL, '1962-06-14', '', 40437, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (355, 'Active', 'MICHAEL CHAELIS', '', '6977771028', '', '', 'm.chaelis@eurofreighthellas.com', NULL, '0000-00-00', '', 40965, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (356, 'Active', 'ΕΥΡΟΥΛΛΑ ΙΩΑΝΝΟΥ', '', '22665346', '', '', '', NULL, '0000-00-00', '', 35067, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (357, 'Active', 'COSTAS KAKOPIEROS', '', '99668400', '', '', 'costas@delrock.com.cy', NULL, '1959-12-27', '', 40926, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (358, 'Active', 'THEODOROS THEODOROU', '', '99620133', '', '', 'theos.theodorou@yahoo.com', NULL, '1961-09-06', '', 41110, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (359, 'Active', 'DEMETRIS MELIOS', '', '99963051', '', '', 'dmelios@cytanet.com.cy', NULL, '1963-01-05', '', 35620, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (360, 'Active', 'PANAYIOTIS NICOLAIDES', '', '99659755', '', '', '', NULL, '0000-00-00', '', 41161, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (361, 'Active', 'ΔΗΜΗΤΡΗΣ ΙΩΑΝΝΟΥ', '', '99530886', '', '', '', NULL, '0000-00-00', '', 40823, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (362, 'Active', 'ΔΙΑΓΡΑΦΗ ΓΛΥΚ ', '', '', '', '', '', NULL, '0000-00-00', '', 32750, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (363, 'Active', 'COSTAS PISSIDES', '', '99677180', '', '', 'annaioannou_74@outlook.com', NULL, '1961-10-10', '', 35687, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (364, 'Active', 'ΑΘΑΝΑΣΙΟΣ ΚΑΓΙΑΣ', '', '99425722', '', '', '', NULL, '1959-04-09', '', 32075, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (365, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ  ΕΥΑΓΓΕΛΟΥ', '', '99680934', '', '', '', NULL, '1962-07-22', '', 40698, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (366, 'Active', 'ΜΕΛΠΟΜΕΝΗ ΦΕΚΚΑ', '', '', '', '', '', NULL, '0000-00-00', '', 41281, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (367, 'Active', 'ΓΙΑΝΝΑΚΗΣ ΑΝΤΖΟΥΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40671, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (368, 'Active', 'XRISTAKIS MOYSKOY', '', '99499898', '', '', '', NULL, '1962-07-05', '', 31951, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (369, 'Active', 'SOLON  SOLOMOU', '', '99450990', '', '', '', NULL, '1963-06-16', 'ADDRESS: PAVLOU LIASIDE NO.25,6043 LARNACA', 34672, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (370, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΑ ΓΡΗΓΟΡΙΟΥ', '', '99445815', '', '', '', NULL, '0000-00-00', '', 40861, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (371, 'Active', 'ODYSSEAS MARDAPITTAS', '', '99403479', '', '', 'a.ioannou1@outlook.com', NULL, '1962-08-24', '', 35264, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (372, 'Active', 'ΓΙΑΝΝΑΚΗΣ ΑΝΔΡΕΟΥ', '', '96391563', '', '', '', NULL, '0000-00-00', '', 41389, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (373, 'Active', 'ΚΥΡΙΑΚΟΣ ΚΥΡΙΑΚΟΥ', '', '', '', '', '', NULL, '1961-09-25', '', 40596, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (374, 'Active', 'diagrafi ΠΑΝΙΚΟΣ ', '', '', '', '', '', NULL, '1964-02-07', '', 31862, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (375, 'Active', 'ΜΑΡΙΑ ΧΑΜΑΤΙΛΛΑ ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40870, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (376, 'Active', 'ΤΟΝΙΑ ΚΥΡΙΑΚΟΥ ', '', '99380351', '', '', '', NULL, '1974-01-01', '', 41280, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (377, 'Active', 'ΚΩΣΤΑΣ ΚΑΠΙΤΑΝΗΣ', '', '9634646', '24365551', '99450478ΛΙΝΑ', '', NULL, '1964-05-21', '', 31903, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (378, 'Active', 'IOANNIS KASSINIS', '', '', '', '', '', NULL, '1961-05-28', '', 34817, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (379, 'Active', 'ΜΙΧΑΗΛ  ΧΑΡΑΛΑΜΠΟΣ', '', '99459944', '', '', '', NULL, '0000-00-00', '', 32682, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (380, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ  ΜΙΧΑΗΛ', '', '', '', '', '', NULL, '0000-00-00', '', 32684, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (381, 'Active', 'COSTAS GEORGIOU', '', '99654411', '', '', '', NULL, '0000-00-00', '', 31505, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (382, 'Active', 'ΓΙΩΡΓΟΣ ΣΤΑΣΗΣ', '', '24653903', '', '', '', NULL, '1964-10-10', '', 31839, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (383, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΤΑΣΗ ΓΙΩΡΓΟΣ & ΜΑΡΙΑ', '', '', '', '', '', NULL, '0000-00-00', '', 32819, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (384, 'Active', 'MARIA KYPRIANOU', '', '99652477', '', '', 'mkyprianou@visitcyprus.com', NULL, '1963-02-20', '', 35478, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (385, 'Active', 'GEORGE CHARALAMBOUS', '', '', '', '', '', NULL, '1964-01-30', '', 35726, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (386, 'Active', 'ΣΤΑΥΡΟΣ ΤΤΟΦΑΡΗΣ', '', '99493888', '', '', '', NULL, '0000-00-00', '', 40958, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (387, 'Active', 'ΝΕΦΕΛΗ ΑΝΤΩΝΙΟΥ', '', '22442323', '', '', '', NULL, '0000-00-00', '', 41251, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (388, 'Active', 'NICOS NICOLAOU', '', '99653532', '', '', 'polydoroudly@cytanet.com.cy', NULL, '1962-03-29', '', 34863, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (389, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΠΑΧ ', '', '', '', '', '', NULL, '0000-00-00', 'ΙΔΙΟΚΤΗΤΗΣ EUROFREIGHT', 32679, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (390, 'Active', 'ΔΩΡΑ  ΙΩΑΝΝΙΔΟΥ', '', '99617446', '', '', '', NULL, '1963-07-27', '', 32048, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (391, 'Active', 'ADAMOS HADJIPANAYIS', '', '99623171', '', '', 'adamos@paidiatros.com', NULL, '1963-06-24', '', 35419, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (392, 'Active', 'ΕΛΕΝΗ ΧΑΤΖΗΑΝΑΣΤΑΣΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40817, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (393, 'Active', 'ΛΟΙΖΟΣ ΒΙΟΛΕΤΤΗΣ', '', '99542098', '', '', '', NULL, '0000-00-00', '', 32678, '2020-01-05 13:24:17', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (394, 'Active', 'SYMEON PAPADAMOU', '', '99546472', '', '', 'symeon.papadamou@gmail.com', NULL, '1964-03-05', '', 40978, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (395, 'Active', 'MARIA GIALLOURIDOU PIERIDOU', '', '99449242', '', '', 'mariayiallourides@gmail.com', NULL, '1966-02-04', '', 40681, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (396, 'Active', 'διαγραφη ΛΕΩΝΙΔΑΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32658, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (397, 'Active', 'THEKLA SARMALLI', '', '99780353', '', '', '', NULL, '1963-03-03', '', 35153, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (398, 'Active', 'Despo Charalambous', '', '99044696', '', '', 'despo@emafoods.com.cy', NULL, '1963-06-24', '', 35256, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (399, 'Active', 'ΝΤΙΝΑ ΞΕΝΟΦΩΝΤΟΣ', '', '99828703', '', '', '', NULL, '1965-02-08', '', 40650, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (400, 'Active', 'CHRYSTALLA CHAELIS', '', '00306974829456', '', '', 'cchaeli@gmail.com', NULL, '1965-07-20', '', 40644, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (401, 'Active', 'ΣΤΕΦΑΝΟΣ ΣΤΕΦΑΝΗ', '', '24821082', '', '', '', NULL, '0000-00-00', '', 32833, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (402, 'Active', 'ΔΙΑΓΡΑΦΗ ΓΕΩΡΓΙΟΣ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32782, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (403, 'Active', 'SOFRONIOS PANAYIDES', '', '', '', '', '', NULL, '1966-04-03', '', 41305, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (404, 'Active', 'CHRISTAKIS CHARALAMBOUS', '', '', '', '', '', NULL, '1965-05-03', '', 35023, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (405, 'Active', 'ΜΙΧΑΗΛ ΜΙΧΑΛΑΚΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41052, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (406, 'Active', 'CONSTANTINOS ZOURIDES', '', '24823733', '', '', 'costas.zourides@zenonndc.com', NULL, '1964-04-17', '', 34652, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (407, 'Active', 'XRISTODULOS PARTOY', '', '99676986', '', '', '', NULL, '1963-07-22', '', 31942, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (408, 'Active', 'THEONI KOUPEPIA', '', '99642348', '', '', '', NULL, '0000-00-00', '', 31803, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (409, 'Active', 'STELLIOS HADJISTYLLIS', '', '99650575', '', '', '', NULL, '1963-02-05', '', 35195, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (410, 'Active', 'ANDROULLA MOYSIKOY', '', '99305766', '', '', '', NULL, '1961-08-17', '', 31888, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (411, 'Active', 'ΙΩΑΝΝΗΣ ΣΤΕΦΑΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40785, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (412, 'Active', 'SONIA DEMOSTHENOUS', '', '99496222', '', '', 'soniademosthenous@hotmail.com', NULL, '1964-08-02', '', 40450, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (413, 'Active', 'ΓΕΩΡΓΙΟΣ ΤΟΥΒΑΝΑΣ', '', '99598325', '', '', '', NULL, '0000-00-00', '', 41350, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (414, 'Active', 'MAKSIM KOROTAYEV', '', '99341058', '', '', '', NULL, '1969-02-04', '', 31923, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (415, 'Active', 'ΑΝΤΩΝΗΣ  ΑΝΤΩΝΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41340, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (416, 'Active', 'NEOFYTA NEOFYTOU', '', '', '', '', '', NULL, '1965-02-09', '', 35757, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (417, 'Active', 'CHRISTOS PAPANICOLAOU', '', '99495239', '', '', '', NULL, '1969-12-25', '', 40548, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (418, 'Active', 'EROTOKRITOS EROTOKRITOY MARINA GIANOY', '', '99546871', '', '', '', NULL, '0000-00-00', '', 31988, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (419, 'Active', 'ELENA CHRISTODOULOU', '', '99434007', '', '', 'elena@aplus.com.cy', NULL, '1966-10-23', '', 35320, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (420, 'Active', 'ΔΙΑΓΡΑΦΗ ΕΛΕΝΗ ', '', '', '', '', '', NULL, '0000-00-00', '', 33024, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (421, 'Active', 'FROSO IRAKLI NIKA', '', '99057621', '', '', 'nikas@cytanet.com.cy', NULL, '1966-11-06', '', 35342, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (422, 'Active', 'ΛΟΙΖΟΣ ΠΑΠΑΣΠΥΡΟΥ', '', '99215616', '', '', '', NULL, '0000-00-00', '', 41036, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (423, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΑΝΑΣΤΑΣΙΟΥ', '', '99103313', '', '', '', NULL, '1966-01-24', '', 31501, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (424, 'Active', 'KOULLA ZOURIDOU', '', '24823733', '', '', 'costas.zourides@zenonndc.com', NULL, '1965-03-13', '', 34662, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (425, 'Active', 'HRISTO KODZHEYKOV', '', '99923233', '', '', 'gnkahristo@gmail.com', NULL, '0000-00-00', '', 41277, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (426, 'Active', 'ELENI MANOLI', '', '99157913', '', '', 'eleniman1963@gmail.com', NULL, '1966-11-06', '', 35196, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (427, 'Active', 'POLYVIOS PAPAPOLYVIOU', '', '', '', '', '', NULL, '1964-10-13', '', 35751, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (428, 'Active', 'KONSTANTINOS THEODOSIOU', '', '99606819', '', '', 'p.avraamides@kalypsisinsurance.com', NULL, '1965-10-22', '', 34731, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (429, 'Active', 'AMIR SUERBAEV', '', '', '', '', '', NULL, '0000-00-00', '', 41009, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (430, 'Active', 'LEONTIOS IERODIAKONOU', '', '99680073', '', '', '', NULL, '1966-11-11', '', 34862, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (431, 'Active', 'MARIA CHRISTODOULOU', '', '', '', '', '', NULL, '1967-11-13', '', 35716, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (432, 'Active', 'ΓΙΑΝΝΟΣ ΓΕΩΡΓΙΟΥ ΚΑΙ ΜΑΡΙΑ ΓΡΗΓΟΡΙΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 40395, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (433, 'Active', 'KSENIA OSTAPCHENKO', '', '', '', '', '', NULL, '1980-12-26', '', 40286, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (434, 'Active', 'STELIOS ANTHIMOY', '', '99368804', '99345509', '', '', NULL, '0000-00-00', '', 31857, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (435, 'Active', 'διαγραφη ΣΩΤΗΡΟΥΛΛΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 32740, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (436, 'Active', 'VASILIS ANDREOU', '', '99333375', '', '', 'viomar@cytanet.com.cy', NULL, '1964-08-08', '', 34898, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (437, 'Active', 'TRIFONAS PATSALIDES', '', '99410834', '', '', 'trifonasp64@hotmail.com', NULL, '1964-12-18', '', 34859, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (438, 'Active', 'STELLA  PARIDOY', '', '99612929', '', '', '', NULL, '1966-06-18', '', 31908, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (439, 'Active', 'KYPRIANOS COSTI', '', '99648593', '', '', '', NULL, '1965-10-02', '', 35691, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (440, 'Active', 'ΛΟΙΖΟΣ ΑΛΑΜΠΡΙΤΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40839, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (441, 'Active', 'MARIOS NEOFYTOU', '', '99404752', '', '', '', NULL, '1964-05-16', '', 31952, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (442, 'Active', 'ΛΟΥΚΙΑ ΚΥΠΡΗ ΣΠΥΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41367, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (443, 'Active', 'PANARETOS KYPRIANOU', '', '99006924', '', '', '', NULL, '1967-05-12', '', 31904, '2020-01-05 13:24:18', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (444, 'Active', 'CHRISTOFOROS CHRISTOFOROU', '', '96777748', '', '', 'chkaffas@gmail.com', NULL, '1968-05-15', '', 35333, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (445, 'Active', 'ΜΙΧΑΛΑΚΗΣ ΛΑΖΑΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41386, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (446, 'Active', 'ΧΡΙΣΤΟΣ ΜΟΥΣΚΗΣ', '', '24721671', '', '', '', NULL, '0000-00-00', '', 32847, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (447, 'Active', 'Loukia Kagia', '', '99388920', '', '', '', NULL, '1964-05-27', '', 32431, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (448, 'Active', 'VALENTINA KINASH', '', '', '', '', '', NULL, '0000-00-00', '', 41176, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (449, 'Active', 'ΦΛΩΡΟΣ ΒΩΝΙΑΤΗΣ', '', '99627987', '', '', '', NULL, '1967-10-22', '', 32011, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (450, 'Active', 'ΚΟΣΜΑΣ ΙΑΚΩΒΟΥ', '', '99663509', '', '', '', NULL, '1967-10-04', '', 32054, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (451, 'Active', 'ANTONIS GAITANOU', '', '', '', '', '', NULL, '0000-00-00', '', 34382, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (452, 'Active', 'GEORGIOS VATYLIOTIS', '', '99431421', '', '', 'georgev@ac.cy', NULL, '1967-08-16', '', 40994, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (453, 'Active', 'STELIOS PIERIDES', '', '', '', '', '', NULL, '1967-06-13', '', 40674, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (454, 'Active', 'ΔΙΑΓΡΑΦΗ ΔΙΑΓΡΑΦΗ', '', '', '', '', '', NULL, '0000-00-00', '', 32680, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (455, 'Active', 'MARIA ANDONIOU', '', '', '', '', '', NULL, '0000-00-00', '', 31910, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (456, 'Active', 'ΜΑΡΙΑ ΠΑΝΑΓΗ', '', '99384398', '', '', '', NULL, '0000-00-00', '', 40279, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (457, 'Active', 'KYRIAKOS NIKAS', '', '99404658', '', '', 'nikask@cytanet.com.cy', NULL, '1966-07-20', '', 35343, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (458, 'Active', 'TASOS CHRISTODOULOU', '', '99643922', '', '', 'tasos.christodoulou@apollonion.com.cy', NULL, '1966-02-13', '', 34956, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (459, 'Active', 'MARINOS IOULIANOU', '', '003579931290', '', '', 'marinosioulianou@gmail.com', NULL, '1969-01-13', '', 33393, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (460, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΝΔΡΕΑΣ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32737, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (461, 'Active', 'ΓΙΑΝΝΑΚΗΣ ΙΟΑΝΝΟΥ', '', '99624719', '', '', '', NULL, '1968-02-12', '', 31897, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (462, 'Active', 'ΓΙΑΝΝΑΚΗΣ ΙΩΑΝΝΟΥ & ΦΡΟΣΩ ΓΕΩΡΓΙΟΥ', '', '24639418', '', '', '', NULL, '0000-00-00', '', 32821, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (463, 'Active', 'ΧΡΙΣΤΑΚΗΣ ΜΑΚΡΟΜΑΛΛΗΣ', '', '99676077', '', '', '', NULL, '1967-08-18', '', 32015, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (464, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΠΑΝΑΓΙΩΤΟΥ', '', '97665981', '', '', '', NULL, '0000-00-00', '', 41170, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (465, 'Active', 'ΕΛΕΝΗ ΜΠΑΡΟΝ ', '', '99664178', '', '', '', NULL, '1968-06-06', '', 41400, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (466, 'Active', 'PANAGIOTIS MICHAEL', '', '99485725', '', '', 'panicos.m@cytanet.com.cy', NULL, '1971-02-24', '', 35055, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (467, 'Active', 'SAVVAS VAKCHOS', '', '99550681', '', '', 'vakchos@cytanet.com.cy', NULL, '1967-04-29', '', 35298, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (468, 'Active', 'ΕΛΕΝΗ ΑΡΤΕΜΙΟΥ', '', '99207007', '', '', '', NULL, '0000-00-00', '', 41104, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (469, 'Active', 'GEORGIOS KASTANOS', '', '99483141', '', '', 'info@kastanosjewels.com', NULL, '1969-08-10', '', 31945, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (470, 'Active', 'KETI LIPERTI', '', '97606960', '', '', 'keiperti@papd.mof.gov.cy', NULL, '1969-12-26', '', 41113, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (471, 'Active', 'ΑΛΕΚΟΣ ΦΩΚΑ', '', '99624719', '', '', '', NULL, '1969-12-04', 'COVER ΝΟΤΕ', 31863, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (472, 'Active', 'ΚΩΣΤΑΣ ΓΙΑΝΝΑΚΗ', '', '99659531', '', '', '', NULL, '0000-00-00', '', 41397, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (473, 'Active', 'ΘΕΟΔΩΡΟΣ ΘΕΟΔΩΡΙΔΗΣ', '', '99620880', '', '', '', NULL, '0000-00-00', '', 40317, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (474, 'Active', 'FROSEL GEORGIOU', '', '99624719', '99412145', '', '', NULL, '1962-09-03', '', 31885, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (475, 'Active', 'ELENI  PANTELI', '', '99638620', '', '', '', NULL, '1971-01-27', '', 32010, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (476, 'Active', 'ΝΙΚΟΣ  ΙΩΑΝΝΙΔΗΣ', '', '99489800', '', '', '', NULL, '1968-05-07', '', 32060, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (477, 'Active', 'CHRYSOULA CHARALAMBOUS', '', '99353872', '', '', 'gpouspouti@cytanet.com.cy', NULL, '1970-05-11', '', 35725, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (478, 'Active', 'ΕΥΣΤΑΘΙΟΣ ΕΥΣΤΑΘΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41016, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (479, 'Active', 'GEORGIOS KYRIAKOU', '', '99404120', '', '', '', NULL, '1970-07-02', '', 35424, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (480, 'Active', 'διαγραφη ΤΕΡΨΙΧΟΡΗ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32762, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (481, 'Active', 'DEMETRA ATHANASIOU', '', '24626161', '', '', 'marinosioulianou@gmail.com', NULL, '1968-06-20', '', 31943, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (482, 'Active', 'KATIA GKRITZALI', '', '99653836', '', '', 'katia.gkritzali@krimera.com', NULL, '1967-12-30', '', 35702, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (483, 'Active', 'ΛΟΥΚΑ ΓΕΡΑΣΙΜΟΣ', '', '99156680', '', '', '', NULL, '0000-00-00', '', 41023, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (484, 'Active', 'CHRISTINA MILTIADOU', '', '', '', '', '', NULL, '1971-04-12', '', 40165, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (485, 'Active', 'KOSTAS PAPAXARALAMBOUS', '', '99688025', '', '', '', NULL, '1970-12-18', '', 31906, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (486, 'Active', 'ΜΑΡΙΑ ΧΡΥΣΟΣΤΟΜΟΥ', '', '24840840', '', '', '', NULL, '0000-00-00', '', 32841, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (487, 'Active', 'XRISTAKIS NIKOLAOY', '', '99388314', '', '', '', NULL, '1971-04-20', '', 31993, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (488, 'Active', 'ΠΑΜΠΟΣ ΦΑΡΜΑΚΑΣ', '', '9962844', '', '', '', NULL, '1968-12-30', '', 31902, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (489, 'Active', 'ΠΑΝΙΚΟΣ ΜΟΣΚΟΒΙΑΣ', '', '99617781', '', '', '', NULL, '0000-00-00', '', 35118, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (490, 'Active', 'ΜΑΡΙΑ  ΠΑΠΑΝΤΩΝΙΟΥ', '', '24638147', '', '', '', NULL, '0000-00-00', '', 32681, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (491, 'Active', 'DIAGRAFI ΑΔΩΝΗΣ ΑΔΩΝΗ & ΓΙΑΝΟΥΛΛΑ ΧΡΙΣΤΟΔΟΥΛΟΥ ', '', '24823034', '', '', '', NULL, '0000-00-00', '', 32792, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (492, 'Active', 'ADONIS ADONI', '', '99516624', '', '', 'adonis@southcoast.com.cy', NULL, '1971-08-14', '', 35339, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (493, 'Active', 'ΑΝΝΑ ΚΥΡΙΑΚΟΥ', '', '99429207', '', '', '', NULL, '0000-00-00', '', 40693, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (494, 'Active', 'διαγραφη ΑΝΔΡΕΑΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32743, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (495, 'Active', 'ΛΟΥΚΑΣ ΚΑΨΗΣ', '', '99105029', '', '', '', NULL, '1968-10-10', '', 31859, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (496, 'Active', 'ΑΣΤΕΡΩ ΓΡΗΓΟΡΙΑΔΟΥ', '', '99728489', '', '', 'agregoriadou@gmail.com', NULL, '1971-02-07', '', 35069, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (497, 'Active', 'ANTHOULIS GEORGIOU', '', '99209205', '', '', '', NULL, '1971-10-06', '', 35197, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (498, 'Active', 'XRISTAKI KAI MARIA GEORGIOY', '', ' 99388314', '', '', '', NULL, '0000-00-00', '', 31892, '2020-01-05 13:24:19', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (499, 'Active', 'STELLA PIERETTI', '', '99482055', '', '', 'pierettistella@gmail.com', NULL, '1969-01-17', '', 34865, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (500, 'Active', 'LOIZOS MOUYIS', '', '', '', '', 'loizosmougis@cytanet.com.cy', NULL, '1968-11-30', '', 40197, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (501, 'Active', 'MARIA ARTEMI', '', '99308117', '', '', '', NULL, '0000-00-00', '', 31914, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (502, 'Active', 'ΑΝΤΡΟΥΛΑ ΓΑΒΡΙΗΛΙΔΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40913, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (503, 'Active', 'ΓΕΩΡΓΙΟΣ ΣΑΒΒΑ', '', '99599208', '', '', '', NULL, '1970-10-04', '', 32444, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (504, 'Active', 'ΠΑΝΙΚΟΣ ΣΤΑΥΡAKH', '', '', '', '', '', NULL, '0000-00-00', 'COVER ΝΟΤΕ', 33031, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (505, 'Active', 'ΧΡΗΣΤΑΚΗΣ ΧΑΤΖΗΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41244, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (506, 'Active', 'ΔΙΑΓΡΑΦΗ ΜΑΡΚΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32676, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (507, 'Active', 'ΔΙΑΓΡΑΦΗ ΜΕΛΙΝΑ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32755, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (508, 'Active', 'διαγραφη ΙΩΑΝΝΗΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 33003, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (509, 'Active', 'XENOPHON NICOLAOU', '', '99897587', '', '', 'nicola_nicolaou@yahoo.com', NULL, '1983-03-15', '', 33504, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (510, 'Active', 'WILLIAM HOOPER', '', '', '', '', '', NULL, '0000-00-00', '', 41293, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (511, 'Active', 'AGGELOS MISOS', '', '99510080', '', '', '', NULL, '1971-03-07', '', 31909, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (512, 'Active', 'ELENI NICOLAOU', '', '99832828', '', '', 'krouka14@gmail.com', NULL, '1963-04-20', 'ADDRESS : IERONYMOU VARLAAM 19A, 6042', 34673, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (513, 'Active', 'MAUREEN SHIELDS WATT', '', '96783112', '', '', 'maureen.watt@yahoo.com', NULL, '1961-06-13', '', 35731, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (514, 'Active', 'ΙΛΙΑΔΑ ΕΥΡΙΠΙΔΟΥ', '', '99425926', '', '', '', NULL, '1969-07-11', '', 32066, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (515, 'Active', 'ILIADA EYRIPIDOY', '', '99425926', '', '', '', NULL, '1969-07-11', '', 31954, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (516, 'Active', 'ΑΝΔΡΕΑΣ ΜΑΥΡΟΜΙΧΑΛΗΣ ', '', '99677915', '', '', '', NULL, '0000-00-00', '', 41160, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (517, 'Active', 'ΑΝΤΡΙ ΜΟΡΦΙΤΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40475, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (518, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΤΥΛΙΑΝΟΣ ΚΟΚΚΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 32851, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (519, 'Active', 'CONSTANTINOS ATALIOTIS', '', '99673336', '', '', 'constantinos@nicheadv.com', NULL, '1970-08-05', '4460402700067153//09/17//Constantinos Ataliotis', 32008, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (520, 'Active', 'IOANNIS PAPADAPOULOS', '', '99656152', '', '', '', NULL, '1970-04-05', '', 31994, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (521, 'Active', 'ΕΥΘΥΜΙΟΣ ΕΥΘΥΜΙΟΥ ΚΕΡΤΕΠΕΝΕ', '', '99432676', '', '', '', NULL, '1971-11-01', '', 31980, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (522, 'Active', 'NIKOS RODOSTHENOUS', '', '99607208', '', '', 'elena.christofi1@gmail.com', NULL, '1970-11-15', '', 35619, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (523, 'Active', 'ANAΣΤΑΣΙΑ ΣΚΟΥΡΟΥΜΟΥΗ', '', '99472261', '', '', '', NULL, '1972-11-11', '', 31850, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (524, 'Active', 'ΜΑΡΙΑ ΘΕΟΚΛΕΟΥΣ', '', '', '', '', '', NULL, '0000-00-00', '', 35117, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (525, 'Active', 'NIKI THEODOSI', '', '', '', '', '', NULL, '0000-00-00', '', 40455, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (526, 'Active', 'ELENA STEFANOY', '', '99582255', '', '', '', NULL, '1969-03-10', '', 31956, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (527, 'Active', 'ΦΩΤΟΥΛΑ ΜΑΡΚΟΥ', '', '99634312', '', '', '', NULL, '1970-05-22', '', 31977, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (528, 'Active', 'ΑΝΔΡΕΑΣ ΚΟΚΚΙΝΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40954, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (529, 'Active', 'CHRISTOS MICHAILAS', '', '24530288', '', '', 'chris.michaelas@gmail.com', NULL, '1973-07-26', '', 34274, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (530, 'Active', 'THEODOULOS EFTHYVOULOU', '', '96841599', '', '', 'christos@acpapanicolaou.com', NULL, '1972-09-19', '', 34737, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (531, 'Active', 'διαγραφη ΧΡΥΣΤΑΛΛΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 32793, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (532, 'Active', 'VASOS KOYTSIOYNTAS', '', '', '', '', '', NULL, '1972-02-08', '', 31875, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (533, 'Active', 'GEORGIOS PANAGI', '', '', '', '', 'georgiospanagi40@gmail.com', NULL, '1972-10-30', '', 34319, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (534, 'Active', 'AGGELA VASILI', '', '99187109', '', '', '', NULL, '1964-12-21', '', 32036, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (535, 'Active', 'NIKOS NIKOLAOY', '', '99447691', '', '', '', NULL, '1972-10-30', '', 32037, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (536, 'Active', 'ANNA BABISH', '', '95583887', '', '', 'george.j.nasr@gmail.com', NULL, '1981-05-07', '', 33502, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (537, 'Active', 'EVGENY SHAPIN', '', '', '', '', '', NULL, '0000-00-00', '', 41022, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (538, 'Active', 'SOPHIA HADJINEOPHYTOU', '', '99517206', '', '', 'shadjineophytou@gmail.com', NULL, '1972-06-03', '', 41092, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (539, 'Active', 'SOTRIS NIKOLAIDIS', '', '99617213', '', '', '', NULL, '1972-01-29', '', 31919, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (540, 'Active', 'ΣΤΑΜΑΤΙΑ ΘΕΜΙΣΤΟΚΛΕΟΥΣ', '', '', '', '', '', NULL, '1973-04-25', '', 32445, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (541, 'Active', 'SAVVAS HADJIMICHAIL', '', '96410681', '', '', '', NULL, '1973-09-16', '', 35001, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (542, 'Active', 'RUSLAN SUERBAEV', '', '97740466', '', '', 'suerbaev@gmail.com', NULL, '0000-00-00', '', 41008, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (543, 'Active', 'ΠΑΝΤΕΛΙΤΣΑ ΜΥΛΩΝΑ', '', '9991132', '', '', '', NULL, '0000-00-00', '', 40691, '2020-01-05 13:24:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (544, 'Active', 'ΑΥΓΗ ΕΥΘΥΜΙΟΥ ΚΑΣΟΥΛΙΔΗ', '', '99640810', '', '', '', NULL, '0000-00-00', '', 32067, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (545, 'Active', 'TRYFONAS TRYFONOS', '', '99654272', '', '', 'tryfonastryfonos2@cytanet.com.cy', NULL, '1971-11-13', 'ADDRESS : EAROS 5, 6041 LARNACA CYPRUS', 34676, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (546, 'Active', 'ΧΑΡΙΣ ΜΙΚΕΛΙΔΟΥ', '', '99499882', '', '', '', NULL, '0000-00-00', '', 40877, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (547, 'Active', 'EIRINI EFRAIMI', '', '99347233', '', '', 'ioannoumarilena@yahoo.com', NULL, '1972-06-19', '', 33495, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (548, 'Active', 'ANTONIS GRIGORAS', '', '99617217', '', '', 'agregoras@yahoo.com', NULL, '1973-08-03', '', 31926, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (549, 'Active', 'EYTYXIA XALIOY ARGYRIDOY', '', '99627955', '', '', '', NULL, '1971-06-27', '', 31912, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (550, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΟ ', '', '', '', '', '', NULL, '0000-00-00', '', 32846, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (551, 'Active', 'MINAS KARAOLIS', '', '99214915', '', '', '', NULL, '1971-10-29', '', 31941, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (552, 'Active', 'Maria Palourti', '', '99668303', '', '', 'mpalourti@gmail.com', NULL, '1972-07-23', '', 32434, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (553, 'Active', 'ANDREAS KARACHRISTOU', '', '99443691', '', '', 'andreas.karachristos@gmail.com', NULL, '0000-00-00', '', 35480, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (554, 'Active', 'Errikos Georgiadis', '', '99352746', '', '', 'chehrian@gmail.co', NULL, '1973-08-20', 'chsgmg@gmail.com', 32046, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (555, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΥΞΕΝΤΙΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32744, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (556, 'Active', 'ΞΕΝΑΚΗΣ ΞΙΟΥΡΟΥΠΠΑΣ', '', '99320224', '', '', '', NULL, '0000-00-00', '', 41154, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (557, 'Active', 'KYRIACOS NEOCLEOUS', '', '', '', '', 'kneocleous@yahoo.co.uk', NULL, '1973-01-31', '', 35458, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (558, 'Active', 'ANTONITSA CONSTANTINOU', '', '99777440', '', '', 'a3xen@aol.com', NULL, '1973-04-05', '', 34883, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (559, 'Active', 'DR THEKLA KOTZIA ', '', '99779548', '', '', '', NULL, '0000-00-00', '', 41346, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (560, 'Active', 'GEORGIOS PAPANASTASIOU', '', '97772200', '22676791', '', 'george.papanastasiou@yahoo.gr', NULL, '1974-06-09', '', 31997, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (561, 'Active', 'ΚΑΤΕΡΙΝΑ ΞΥΣΤΟΥΡΗ', '', '99499626', '', '', '', NULL, '0000-00-00', '', 32818, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (562, 'Active', 'ΚΑΤΕΡΙΝΑ ΞΥΣΤΟΥΡΗ ΚΑΙ ΧΡΙΣΤΟΣ ΤΣΙΤΣΟΣ', '', '99443073', '', '', '', NULL, '0000-00-00', '', 32021, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (563, 'Active', 'Eleftherios  Eleftheriou', '', '99668303', '', '', 'mpalourti@gmail.com', NULL, '1972-08-05', '', 32433, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (564, 'Active', 'ΑΝΔΡΕΑΣ ΜΙΧΑΗΛ', '', '99515957', '', '', '', NULL, '0000-00-00', '', 32784, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (565, 'Active', 'ΝΙΚΟΛΑΣ ΝΤΙΓΚΡΙΝΤΑΚΗΣ', '', '99421934', '', '', '', NULL, '0000-00-00', '', 33018, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (566, 'Active', 'ELENA  YIASOUMI', '', '96300500', '24821240', '', '', NULL, '1973-03-15', '', 31869, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (567, 'Active', 'PANAYIOTIS PANAYI', '', '99906042', '', '', '', NULL, '1972-05-13', '', 31950, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (568, 'Active', 'ΧΡΙΣΤΑΚΗΣ & ΦΛΩΡΑ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '99617595', '', '', '', NULL, '0000-00-00', '', 40761, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (569, 'Active', 'ΑΝΑΣΤΑΣΙΑ ΣΚΟΥΡΟΥΜΟΥΝΗ', '', '9972261', '', '', '', NULL, '1972-11-11', '', 31896, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (570, 'Active', 'ANNA IOANNOU', '', '', '', '', '', NULL, '0000-00-00', '', 35688, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (571, 'Active', 'CHRISTOS PIGASIOU', '', '99413413', '', '', 'cpigasiou@gmail.com', NULL, '1972-05-29', '', 40201, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (572, 'Active', 'ΜΑΡΙΑ ΧΡΙΣΤΙΝΑ ΚΟΛΟΚΑΣΙΔΟΥ', '', '99440955', '', '', '', NULL, '1974-12-24', '', 40934, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (573, 'Active', 'ΕΙΡΗΝΗ ΣΤΥΛΙΑΝΟΥ', '', '24742805', '', '', '', NULL, '1974-11-09', '', 32016, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (574, 'Active', 'SOFI XRISTODOULOU LOIZOY', '', '99834233', '', '', '', NULL, '1970-07-30', '', 31966, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (575, 'Active', 'KETI ALEXANDROU FOTIADOU', '', '97770783', '', '', 'kate.alexandrou@gmail.com', NULL, '0000-00-00', '', 34763, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (576, 'Active', 'DIMITRIOS PARTOY', '', '99688775', '', '', '', NULL, '1973-10-27', '', 31878, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (577, 'Active', 'AVGUSTA NEOFYTOU MICHAELIDOU', '', '99201058', '', '', '', NULL, '1974-01-26', '', 35704, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (578, 'Active', 'SPYROS PAVLIDES', '', '99224212', '', '', 's.pavlides@gpa.com.cy', NULL, '1972-09-19', '', 40755, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (579, 'Active', 'SPYROS SAVVIDIS', '', '99441660', '', '', 's.s.weather.control@gmail.com', NULL, '1973-12-04', 'ADDRESS : GARIFALO 1 KATO LAKATAMIA NICOSIA , 2128', 34666, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (580, 'Active', 'ΑΝΤΩΝΗΣ ΑΝΤΩΝΙΟΥ', '', '99579869', '', '', '', NULL, '0000-00-00', '', 33022, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (581, 'Active', 'ELENI ANTONIOU', '', '', '', '', 'eleanto1@hotmail.com', NULL, '1975-03-20', '', 40451, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (582, 'Active', 'GEORGIA ALEXANDROU', '', '99682194', '', '', 'Lchhairspa@hotmail.com', NULL, '1974-06-27', '', 40388, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (583, 'Active', 'GEORGIA KYMITRI STYLIANOU', '', '99483414', '', '', 'stylianou23g@yahoo.com', NULL, '1974-04-23', '', 41375, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (584, 'Active', 'EVGENIA TAVELI', '', '99698893', '', '', 'ast4028@gmail.com', NULL, '1976-02-12', '', 40931, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (585, 'Active', 'XARALAMBOS KARITTEVLI', '', '99695957', '', '', '', NULL, '1973-09-26', '', 31939, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (586, 'Active', 'NEOFYTOS NEOFYTOU', '', '99438811', '', '', 'koullaneophytpu@gmail.com', NULL, '1976-03-23', '', 35622, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (587, 'Active', 'MARIA AVRAAMIDOU', '', '99478179', '', '', '', NULL, '1973-04-10', '', 34857, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (588, 'Active', 'IOANNIS ATHANASIOU', '', '99652783', '', '', '', NULL, '1976-01-12', '', 32038, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (589, 'Active', 'STELLA KOUALI MEMTSOUDI', '', '', '', '', '', NULL, '0000-00-00', '', 40410, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (590, 'Active', 'NIKOLAS LAMBROU', '', '96440872', '', '', 'nikolas_lambrou@hotmail.com', NULL, '1976-07-04', '', 34884, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (591, 'Active', 'MYRIANTHI KOKKINOU', '', '99347042', '', '', 'myria741@cytanet.com.cy', NULL, '1974-07-27', '', 34733, '2020-01-05 13:24:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (592, 'Active', 'VICTOR BUTTAFUOCO', '', '96736548', '', '', 'woodmach2000@yahoo.gr', NULL, '1974-07-31', '', 40256, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (593, 'Active', 'VICTOR VODENKO', '', '', '', '', 'vodenko_victor@mail.ru', NULL, '0000-00-00', '', 41138, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (594, 'Active', 'PATROKLOS KOKKINOS', '', '99597016', '', '', 'patrokloskok@gmail.com', NULL, '1976-07-21', '', 35337, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (595, 'Active', 'ANDRIANI PARASKEVA', '', '99557605', '', '', 'apgiagkos@hotmail.com', NULL, '1975-10-27', '', 34860, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (596, 'Active', 'ANDREAS KOUNNAPIS', '', '99474817', '', '', '', NULL, '1976-09-26', '', 35477, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (597, 'Active', 'ELSI SOUZANA STAVROY', '', '', '24664520', '', '', NULL, '1956-09-22', '', 31987, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (598, 'Active', 'ΜΙΧΑΗΛ ΚΥΠΡΟΥΛΛΑ', '', '', '', '', '', NULL, '0000-00-00', '', 41210, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (599, 'Active', 'AXILLEAS ELEFTHERIOY', '', '99308902', '', '', '', NULL, '1976-01-17', '', 31918, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (600, 'Active', 'ΔΙΑΓΡΑΦΗ MIXALIS NTANKAN MAKAI ', '', '', '', '', '', NULL, '1976-08-20', '', 31949, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (601, 'Active', 'ΝΙΚΟΣ ΝΙΚΟΛΑΟΥ', '', '99094443', '', '', '', NULL, '0000-00-00', '', 40460, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (602, 'Active', 'ΣΤΕΛΙΟΣ ΣΤΥΛΙΑΝΟΥ ΧΡΥΣΤΑΛΛΑ ΧΑΤΖΗΕΦΡΑΙΜ', '', '', '', '', '', NULL, '0000-00-00', '', 41303, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (603, 'Active', 'ΔΙΑΓΡΑΦΗ ΜΑΡΙΑ Σ ', '', '', '', '', '', NULL, '0000-00-00', '', 32820, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (604, 'Active', 'ΔΙΑΓΡΑΦΙ ΚΑΛΟΓΗΡΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 32735, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (605, 'Active', 'DIMITRIS + DIMITRA  KALOGIROY', '', '24532826', '', '', '', NULL, '0000-00-00', '', 31961, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (606, 'Active', 'MARIA MOYSEOS', '', '99527837', '', '', 'maria.mo@live.com', NULL, '1974-08-12', '', 40772, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (607, 'Active', 'ΝΙΚΟΛΑΟΣ ΑΝΤΩΝΙΑΔΗΣ', '', '99482447', '', '', '', NULL, '0000-00-00', '', 40896, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (608, 'Active', 'ΜΑΡΙΑΝΝΑ  ΜΑΡΤΟΥΔΗ', '', '99681820', '', '', '', NULL, '0000-00-00', '', 32825, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (609, 'Active', 'CHRISTAKIS GEORGIOU', '', '99454422', '', '', '', NULL, '1975-12-25', '', 35056, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (610, 'Active', 'ΧΡΙΣΤΑΚΗΣ ΓΕΩΡΓΙΟΥ ΒΟΥΛΑ ΑΛΕΞΑΝΔΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41175, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (611, 'Active', 'CHRYSTALLA ELEFTHERIOU MIRACHI', '', '99318221', '', '', 'nmirachis@gmail.com', NULL, '1977-05-21', '', 34730, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (612, 'Active', 'ΑΝΤΡΕΑΣ ΠΑΝΑΓΙΩΤΟΥ', '', '99682641', '', '', '', NULL, '1974-10-08', '', 32051, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (613, 'Active', 'ΣΤΑΥΡΟΣ ΠΑΠΑΣΤΡΑΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40473, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (614, 'Active', 'ΛΟΥΚΙΑ ΚΑΡΙΤΤΕΒΛΗ', '', '99652783', '', '', '', NULL, '0000-00-00', '', 32849, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (615, 'Active', 'ΖΩΟΥΛΑ ΝΙΚΟΛΑ', '', '', '', '', '', NULL, '0000-00-00', '', 41013, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (616, 'Active', 'ΣΟΦΙΑ ΜΙΛΛΩΣΙΑ & ΠΑΥΛΙΝΑ ΘΕΟΔΟΥΛΟΥ', '', '24652236', '', '', '', NULL, '0000-00-00', '', 32822, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (617, 'Active', 'Neofytos  Ioannou', '', '', '', '', '', NULL, '1977-08-10', '', 31487, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (618, 'Active', 'PERIKLIS ZAVRIDES', '', '', '', '', 'zavridis@painclinic.com.cy', NULL, '1977-09-27', '', 34302, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (619, 'Active', 'SAVVAKI SAVVA', '', '99447901', '24817816', '', '', NULL, '1976-08-29', '', 31998, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (620, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΝΔΡΕΑΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32848, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (621, 'Active', 'KATERINA MICHAILA', '', '24530288', '', '', 'chris.michaelas@gmail.com', NULL, '1975-03-28', '', 34275, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (622, 'Active', 'ΜΑΡΙΑ & ΙΑΚΩΒΟΣ ΑΛΕΞΑΝΔΡΟΥ & ΙΑΚΩΒΟΥ', '', '99955462', '', '', '', NULL, '0000-00-00', '', 41279, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (623, 'Active', 'ΣΟΦΙΑ ΠΑΠΑΝΙΚΟΛΑΟΥ', '', '24638627', '', '', '', NULL, '0000-00-00', '', 32657, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (624, 'Active', 'KATERINA STAVROU', '', '99665981', '', '', 'stavrouk@windowslive.com', NULL, '1973-01-26', '', 34762, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (625, 'Active', 'COSTAS MATHEOU', '', '99433592', '26221697', '', 'c.matheou.insurance@gmail.com', NULL, '1975-08-25', '', 34740, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (626, 'Active', 'ΜΑΡΙΑ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40873, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (627, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΕΩΡΓΙΟΥ', '', '99660686', '', '', '', NULL, '0000-00-00', '', 32810, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (628, 'Active', 'ELENI GIORGALLA', '', '99595455', '', '', 'elena@theikoepiplo.com', NULL, '1976-09-22', 'ADDRESS : TRION IERARXON 24, 7101 LARNACA', 34674, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (629, 'Active', 'ANTONIS THEODORIDES', '', '99404340', '', '', 'atheos10@gmail.com', NULL, '1976-06-02', '', 35692, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (630, 'Active', 'MICHALIS ERMOGENOUS', '', '99420544', '', '', 'ermogenousm@gmail.com', NULL, '1979-05-24', '', 40356, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (631, 'Active', 'ΔΗΜΗΤΡΑ ΚΥΡΙΑΖΗ', '', '97740660', '', '', '', NULL, '0000-00-00', '', 40631, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (632, 'Active', 'IOANNA IOANNOU', '', '99518573', '', '', 'ioanna_2999@yahoo.com', NULL, '1976-11-09', '', 35614, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (633, 'Active', 'ANTIGONI HATZIGIANNI', '', '24654001', '', '', '', NULL, '1977-02-05', '', 40645, '2020-01-05 13:24:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (634, 'Active', 'ANTHIMOS ANTHIMOU', '', '', '', '', '', NULL, '0000-00-00', '', 34041, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (635, 'Active', 'διαγραφη ηλια ', '', '99473247', '', '', '', NULL, '1975-12-17', '', 32451, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (636, 'Active', 'MARIA PERREA PAPADAMOU', '', '', '', '', '', NULL, '0000-00-00', '', 40979, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (637, 'Active', 'DIMITRAKIS STYLIANOU', '', '99493725', '', '', '', NULL, '1977-10-27', '', 40970, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (638, 'Active', 'ΧΛΟΗ ΚΥΡΙΑΚΟΥ', '', '99404209', '', '', '', NULL, '1977-08-25', '', 31844, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (639, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΥΜΕΩΝ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32654, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (640, 'Active', 'KOSTAS THEODOSI', '', '99572956', '', '', 'ctheodosi65@gmail.com', NULL, '1965-02-19', '', 40454, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (641, 'Active', 'ΑΝΘΗ ΧΡΙΣΤΟΦΟΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40611, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (642, 'Active', 'COSTAKIS KONSTANTINOU', '', '99327267', '', '', 'c.constantinou721@gmail.com', NULL, '1978-11-06', '', 35024, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (643, 'Active', 'ANTRI KOUSIAPPA', '', '', '', '', '', NULL, '0000-00-00', '', 34383, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (644, 'Active', 'JOHANNE ELIZABETH BANKS', '', '96815647', '', '', 'jochristodoulidou@hotmail.com', NULL, '1968-10-14', '', 35014, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (645, 'Active', 'MICHALIS PAVLIDES', '', '99697556', '', '', 'm.pavlides@gpa.com.cy', NULL, '1975-05-02', '', 35418, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (646, 'Active', 'DIMITRA MINA KALOGIROY', '', '24360536', '', '', '', NULL, '1977-01-26', '', 31891, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (647, 'Active', 'ΔΙΑΓΡΑΦΗ ΛΟΥΚΙΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 32811, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (648, 'Active', 'ΕΛΕΝΑ ΠΑΡΠΑ', '', '', '', '', '', NULL, '0000-00-00', '', 41198, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (649, 'Active', 'THEODOULOS THEODOULOU', '', '99458384', '', '', '', NULL, '1976-05-19', '', 35338, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (650, 'Active', 'ELENA XATZILOIZOU', '', '99473347', '', '', '', NULL, '1976-03-18', '', 31982, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (651, 'Active', 'LOUKIA PIGASIOU', '', '99514151', '', '', '', NULL, '1978-09-12', '', 40202, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (652, 'Active', 'SOTEROULA KAMPOURI', '', '', '', '', '', NULL, '1977-09-30', '', 40257, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (653, 'Active', 'ΑΝΝΑ ΠΑΠΑΝΙΚΟΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40458, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (654, 'Active', 'ΔΙΑΓΡΑΦΗ ΛΕ ', '', '', '', '', '', NULL, '0000-00-00', '', 32832, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (655, 'Active', 'SAVVAS HADJICHAMBIS', '', '99345632', '', '', 'mlysiotou@hotmail.com', NULL, '1978-09-13', '', 35420, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (656, 'Active', 'ELIANA CONSTANTINIDOU', '', '99339607', '', '', 'eliana_con@yahoo.com', NULL, '1979-04-07', '', 34804, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (657, 'Active', 'ΜΑΤΘΑΙΟΣ ΜΑΤΘΑΙΟΥ', '', '96458474', '', '', '', NULL, '1977-10-16', '', 40546, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (658, 'Active', 'MARIOS MAVROMOUSTAKIS', '', '99262257', '', '', 'zuzzyquatro@gmail.com', NULL, '0000-00-00', '', 40919, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (659, 'Active', 'ΛΙΖΑ ΑΛΑΜΠΡΙΤΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40927, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (660, 'Active', 'ΓΙΑΝΝΟΥΛΑ ΔΗΜΗΤΡΙΟΥ ', '', '', '', '', '', NULL, '1962-02-04', '', 41383, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (661, 'Active', 'ELIAS ANTONIADES', '', '99201599', '', '', 'director@myradioart.com', NULL, '1979-10-09', '', 34736, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (662, 'Active', 'GIORGOS CHRISTODOULOU', '', '961440706', '', '', 'louiza.ioannidou@gmail.com', NULL, '1979-01-18', '', 41261, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (663, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΚΕΚΙΟΠΟΥΛΟΣ', '', '99313872', '', '', '', NULL, '1965-05-08', '', 32652, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (664, 'Active', 'GAVRIELA PAVLI', '', '99614539', '', '', 'gavriellapavli@gmail.com', NULL, '1978-02-16', '', 40684, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (665, 'Active', 'IOANNIS CHRISTODOULOU', '', '99412505', '', '', 'ioannischristodoulou@hotmail.com', NULL, '1977-11-28', '', 34909, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (666, 'Active', 'DIMITRIS STAVROU', '', '99579737', '', '', 'drstavrou@drstavrou.com', NULL, '1979-01-15', '', 34213, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (667, 'Active', 'EVEL NEOCLEOUS', '', '99834856', '', '', 'evel.neocleus@gmail.com', NULL, '1977-12-08', '', 41268, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (668, 'Active', 'ΚΥΡΙΑΚΟΣ ΝΕΟΚΛΕΟΥΣ', '', '96511059', '', '', '', NULL, '0000-00-00', '', 41406, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (669, 'Active', 'ΚΥΡΙΑΚΟΣ ΣΕΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40745, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (670, 'Active', 'ΑΝΝΑ ΓΕΩΡΓΙΟΥ', '', '99470390', '', '', '', NULL, '1978-11-12', '', 40747, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (671, 'Active', 'LEONIDAS THEODOSIOU', '', '', '', '', '', NULL, '0000-00-00', '', 33637, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (672, 'Active', 'Antri Gaitanou', '', '', '', '', '', NULL, '1977-08-17', '', 31837, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (673, 'Active', 'KYRIACOS KYRIACOU', '', '99562537', '', '', '', NULL, '1977-11-25', '', 35022, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (674, 'Active', 'KYRIAKOS SOKRATOUS', '', '99597062', '', '', 'kullissokratous@gmail.com', NULL, '1980-05-03', '', 40682, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (675, 'Active', 'SOPHIA SCHIZA', '', '99511543', '', '', 'sophiaschiza@gmail.com', NULL, '1979-05-11', '', 35481, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (676, 'Active', 'STAVROS ANAGNOSTOU', '', '99172010', '', '', '', NULL, '1977-05-27', '', 34803, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (677, 'Active', 'MARIA MICHAEL', '', '99667902', '', '', 'michaelmaria787@gmail.com', NULL, '1978-10-08', '', 35465, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (678, 'Active', 'PAVLOS MARKOU', '', '99573796', '', '', '', NULL, '1978-04-14', '', 31944, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (679, 'Active', 'ΔΙΑΓΡΑΦΙ ΓΙΑΣΕΜΙ ', '', '', '', '', '', NULL, '0000-00-00', '', 32791, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (680, 'Active', 'ΔΙΑΓΡΑΦΙ ΡΟΔΟΥ ', '', '97688753', '', '', '', NULL, '0000-00-00', '', 32839, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (681, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΑΝΔΡΕΟΥ', '', '99327713', '', '', '', NULL, '0000-00-00', '', 40394, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (682, 'Active', 'ΧΡΙΣΤΙΑΝΑ ΧΡΙΣΤΟΥ', '', '99692408', '', '', '', NULL, '0000-00-00', '', 41271, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (683, 'Active', 'ΚΑΤΕΡΙΝΑ ΦΙΛΙΠΠΟΥ', '', '99378891', '', '', '', NULL, '1979-10-18', '', 40373, '2020-01-05 13:24:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (684, 'Active', 'ΕΙΡΗΝΗ ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '99579771', '', '', '', NULL, '0000-00-00', '', 40905, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (685, 'Active', 'MYRIA THEOCHARIDES', '', '', '', '', '', NULL, '1980-08-21', '', 35661, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (686, 'Active', 'IOANNA THEOCHARIDOU', '', '', '', '', '', NULL, '1978-08-04', '', 40336, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (687, 'Active', 'ANDREAS ANDREOU', '', '99519646', '', '', 'andros.andreou@primehome.com', NULL, '1980-04-11', '', 35457, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (688, 'Active', 'CONSTANTINOS PANAGI', '', '99581320', '', '', 'panagi.const@gmail.com', NULL, '1980-06-15', '', 33917, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (689, 'Active', 'διαγραφη ΑΒΡΑΑΜ ', '', '', '', '', '', NULL, '0000-00-00', '', 32809, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (690, 'Active', 'ANDREAS PAPAYIANNIS', '', '99799393', '', '', 'apapayiannis@parliament.cy', NULL, '1980-01-25', '', 35615, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (691, 'Active', 'CONSTANTINOS KITROMILIS', '', '99146141', '', '', 'kon.kitromilis@gmail.com', NULL, '1980-12-31', '', 40968, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (692, 'Active', 'ΝΙΚΟΣ  ΜΑΚΡΙΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40442, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (693, 'Active', 'ΕΛΕΝΗ ΣΩΤΗΡΙΟΥ', '', '', '', '', '', NULL, '1979-05-10', '', 41266, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (694, 'Active', 'ΚΥΡΙΑΚΟΣ ΑΣΙΗΚΑΛΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41405, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (695, 'Active', 'CHRYSOVALANTO ACHAIOU XENOFONTOS', '', '99658302', '', '', 'valanto2011xenofontos@hotmail.com', NULL, '0000-00-00', '', 35540, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (696, 'Active', 'STAVROS CHARALAMBOUS', '', '99786842', '', '', 'stavrosch@gmail.com', NULL, '1981-07-09', '', 41066, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (697, 'Active', 'ΠΑΝΤΕΛΗΣ ΣΤΑΥΡΟΥ', '', '99264037', '', '', '', NULL, '1980-03-22', '', 32047, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (698, 'Active', 'MARTINOS SOLOMOU', '', '99340750', '', '', 'solomou2412@gmail.com', NULL, '1980-07-11', '', 40467, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (699, 'Active', 'PARASKEVOULA GERASIMOU', '', '24626332', '', '', 'agregoras@yahoo.com', NULL, '1979-11-05', '', 31927, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (700, 'Active', 'FILOTHEI LIASI', '', '', '', '', '', NULL, '0000-00-00', '', 40496, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (701, 'Active', 'ΣΑΒΒΑΣ ΣΤΕΦΑΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40474, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (702, 'Active', 'ΠΑΥΛΑΚΗΣ ΠΑΥΛΟΥ', '', '99694793', '', '', '', NULL, '0000-00-00', '', 41250, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (703, 'Active', 'VASILIOS TSIANNIS', '', '99897587', '', '', '', NULL, '1983-03-15', '', 33505, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (704, 'Active', 'διαγραφη ΛΟΙΖΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32995, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (705, 'Active', 'Maria Nikolaidou', '', '99552727', '', '', 'ncldmaria16@yahoo.com', NULL, '1979-10-16', '', 31489, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (706, 'Active', 'CHRISTINA NEGUS', '', '99475669', '', '', '', NULL, '1952-12-30', '', 32012, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (707, 'Active', 'MARIA EIRINI TZIRKA', '', '24634344', '', '', 'mtzirka@hotmail.com', NULL, '1980-11-10', '', 34961, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (708, 'Active', 'διαγραφη ΜΑΡΙΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 32994, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (709, 'Active', 'ΑΝΔΡΕΑΣ ΕΥΤΥΧΙΟΥ', '', '96194120', '', '', '', NULL, '1979-10-29', '', 40303, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (710, 'Active', 'ΜΑΡΙΟΣ ΤΣΙΑΤΤΑΛΟΣ', '', '99589009', '', '', '', NULL, '0000-00-00', '', 40762, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (711, 'Active', 'ANTONIS GEORGALLIDES', '', '99533343', '', '', '', NULL, '1982-01-30', '', 34915, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (712, 'Active', 'Ευανθία Σώζου', '', '', '', '', '', NULL, '1980-06-06', '', 31484, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (713, 'Active', 'ΚΩΝΣΝΤΑΝΤΙΝΟΣ DHEERE', '', '99595029', '', '', '', NULL, '0000-00-00', '', 41099, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (714, 'Active', 'ANASTASIA MICHAEL', '', '99486414', '', '', 'costas_sp@hotmail.com', NULL, '1981-11-23', '', 41024, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (715, 'Active', 'ELENA DHEERE', '', '99339229', '', '', '', NULL, '0000-00-00', '', 40909, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (716, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ ΧΡΥΣΑΝΘΟΥ', '', '99403971', '', '', '', NULL, '0000-00-00', '', 41230, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (717, 'Active', 'GEORGIA SKORTIDOU', '', '99820992', '', '', 'Georgia.skortidou@yahoo.com', NULL, '0000-00-00', '', 40884, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (718, 'Active', 'ADAMOS MICHAEL', '', '99550749', '', '', 'adamos.michael@hotmail.com', NULL, '1980-11-06', '', 34955, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (719, 'Active', 'MARIA MATHEOU', '', '99541464', '', '', 'jantmaria@hotmail.com', NULL, '1981-12-04', '', 34739, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (720, 'Active', 'ΑΝΔΡΕΑΣ ΑΝΔΡΕΟΥ', '', '99481826', '', '', '', NULL, '1982-06-25', '', 32013, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (721, 'Active', 'IOANNIS MAVROKORDATOS', '', '99540945', '', '', 'yiamaco@gmail.com', NULL, '0000-00-00', '', 41168, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (722, 'Active', 'STAVROS AGAPIOU', '', '99153412', '', '', 'elianagregoriou@yahoo.com', NULL, '1982-11-15', '', 34283, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (723, 'Active', 'EIRINI KAGIA', '', '99531844', '', '', '', NULL, '0000-00-00', '', 31960, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (724, 'Active', 'ANNA PAPACHRISTOFOROU', '', '', '', '', '', NULL, '1982-02-12', '', 35693, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (725, 'Active', 'GEORGIOS TERTAS', '', '99467698', '', '', '', NULL, '1983-01-20', '', 35730, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (726, 'Active', 'ΑΝΤΡΕΑΣ ΓΕΡΑΣΙΜΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41238, '2020-01-05 13:24:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (727, 'Active', 'PANAYIOTIS MILTIADOUS', '', '99566245', '', '', 'aqpanic1954@gmail.com', NULL, '1982-02-25', '', 35723, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (728, 'Active', 'ANASTASIA KASTANOU', '', '99483141', '', '', 'info@kastanosjewels.com', NULL, '1973-05-06', '', 31957, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (729, 'Active', 'PANIKOS PARMAXI', '', '99405092', '22741327', '', '', NULL, '1966-09-10', '', 31876, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (730, 'Active', 'ΓΕΩΡΓΙΟΣ ΙΩΑΝΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40807, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (731, 'Active', 'ΦΛΩΡΑ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41236, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (732, 'Active', 'APOSTOLOS IOANNOU', '', '', '', '', '', NULL, '0000-00-00', '', 34916, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (733, 'Active', 'ANDREAS KONSTANTINOU', '', '99594436', '', '', '', NULL, '1980-05-10', '', 31877, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (734, 'Active', 'SANTO AGOSTINO', '', '', '', '', '', NULL, '0000-00-00', '', 40924, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (735, 'Active', 'GEORGIA KIMOULIATI', '', '9974556', '', '', 'gogosikinos@gmail.com', NULL, '1981-06-10', '', 41107, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (736, 'Active', 'ANTONIS TOFIAS', '', '99672531', '', '', '', NULL, '1996-02-14', '', 33323, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (737, 'Active', 'POLYDOROS KOSTA', '', '', '', '', '', NULL, '1982-06-15', '', 40575, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (738, 'Active', 'MARIA ANTONIOU', '', '99712972', '', '', 'mariaantoniou0106@gmail.com', NULL, '1976-12-02', '', 33458, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (739, 'Active', 'MARIA DIONYSIOU', '', '99565100', '', '', 'mariadionisiou@yahoo.gr', NULL, '1981-06-10', '', 40574, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (740, 'Active', 'ΝΙΚΟΛΕΤΤΑ ΕΛΕΥΘΕΡΙΟΥ', '', '99340081', '', '', '', NULL, '0000-00-00', '', 41263, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (741, 'Active', 'KETI PANAGI', '', '', '', '', 'georgiospanagi40@gmail.com', NULL, '1982-01-20', '', 34315, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (742, 'Active', 'ΦΡΟΣΑ ΠΑΤΣΑΛΟΣ', '', '99315995', '', '', '', NULL, '0000-00-00', '', 32835, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (743, 'Active', 'δΙΑΓΡΑΦΗ ΝΕΚΟΥΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32781, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (744, 'Active', 'VANIA TOUMAZI', '', '99530955', '', '', 'toumazis@cytanet.com.cy', NULL, '1983-08-31', '', 35482, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (745, 'Active', 'ΜΑΡΙΟΣ ΠΕΡΔΙΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41083, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (746, 'Active', 'ΓΙΩΡΓΟΣ ΚΑΝΟΝΙΣΤΗΣ', '', '97900054', '', '', '', NULL, '1980-09-06', '', 40676, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (747, 'Active', 'POPI  KARAGIANNIDI', '', '99128703', '', '', 'p_karagiannidi@hotmail.com', NULL, '1981-11-03', '', 35063, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (748, 'Active', 'DEMETRIS KONOMIS', '', '', '', '', '', NULL, '0000-00-00', '', 41169, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (749, 'Active', 'MARIA  PAOUROU', '', '99466261', '', '', '', NULL, '1980-07-06', '', 31948, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (750, 'Active', 'ΑΝΤΡΕΑΣ ΠΑΠΑΘΑΝΑΣΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40231, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (751, 'Active', 'CHRISTOFOROS CHRISTOFI', '', '99557992', '', '', '', NULL, '1977-10-05', '', 31907, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (752, 'Active', 'ZACHARIAS KTORIS', '', '', '', '', '', NULL, '1982-07-06', '', 40294, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (753, 'Active', 'NIKOLAS STAVROU', '', '99524530', '', '', '', NULL, '1983-02-05', '', 31873, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (754, 'Active', 'ΣΤΥΛΙΑΝΟΣ ΚΥΡΙΑΚΟΥ', '', '99449114', '', '', '', NULL, '0000-00-00', '', 40522, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (755, 'Active', 'ΕΛΕΝΑ ΚΟΚΚΙΝΟΦΤΑ', '', '', '', '', '', NULL, '0000-00-00', '', 41079, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (756, 'Active', 'NIKOLAS LEVENTIS', '', '99335830', '', '', 'leventisnikolas@yahoo.com', NULL, '0000-00-00', '', 40880, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (757, 'Active', 'ILIANA GREGORIOU', '', '99153412', '', '', 'elianagregoriou@yahoo.com', NULL, '1981-10-10', '', 34297, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (758, 'Active', 'PANAGIOTIS CHARITOU', '', '99596971', '', '', 'panagiotischaritou@gmail.com', NULL, '1983-07-26', '', 35203, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (759, 'Active', 'PAVLOS PAVLOU', '', '99407574', '', '', 'pavlos81@hotmail.com', NULL, '1981-06-10', '', 40376, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (760, 'Active', 'ΔΙΑΓΡΑΦΗ ΚΑΤΕΡΙΝΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 32749, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (761, 'Active', 'CHRISTOS SHAMMAS', '', '99435311', '', '', 'c.shammas@avvapharma.com', NULL, '1979-08-21', '', 34921, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (762, 'Active', 'ΔΙΑΓΡΑΦΗ ΚΕΥΗ ', '', '', '', '', '', NULL, '0000-00-00', '', 32742, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (763, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΝΤΩΝ ', '', '', '', '', '', NULL, '0000-00-00', '', 32783, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (764, 'Active', 'GIORGOS GEORGIOU', '', '99821872', '', '', 'demetriouanthi@hotmail.com', NULL, '1983-09-25', '', 35000, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (765, 'Active', 'AIMILIA KONSTANTINOU', '', '', '', '', '', NULL, '1983-01-12', '', 40468, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (766, 'Active', 'MICHALIS MICHAEL', '', '99876877', '', '', 'mariaauth@gmail.com', NULL, '1983-12-26', '', 34856, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (767, 'Active', 'VARNAVAS VARNAVA', '', '', '', '', '', NULL, '1983-08-12', '', 40567, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (768, 'Active', 'MARIOS NEOPHYTOU', '', '99779142', '', '', 'neofytou.mario@gmail.com', NULL, '1985-01-31', '', 40969, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (769, 'Active', 'MARIA KARAMANLI', '', '', '', '', '', NULL, '0000-00-00', '', 35664, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (770, 'Active', 'ΔΗΜΗΤΡΗΣ ΤΣΙΒΙΚΟΣ ', '', '99489142', '', '', '', NULL, '1981-04-10', '', 40936, '2020-01-05 13:24:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (771, 'Active', 'STAVROS STAVROU', '', '99303127', '', '', 's.stavrou@sotlaw.com.cy', NULL, '1986-03-15', '', 34949, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (772, 'Active', 'IVAN VERESIE', '', '99598412', '', '', 'veresies@gmail.com', NULL, '1983-07-22', '', 31972, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (773, 'Active', 'LOUIZA VERESIE', '', '9989538', '', '', '', NULL, '0000-00-00', '', 31486, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (774, 'Active', 'GEORGIA CHRYSOSTOMOU', '', '99380351', '', '', 'georgia_chrysostomou@hotmail.com', NULL, '1982-10-21', 'ADDRESS : KLISTHENOUS 35, 2335 NICOSIA', 34668, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (775, 'Active', 'ΝΙΚΟΣ ΝΙΚΟΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41078, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (776, 'Active', 'XRISTOFORA KAGIA', '', '99388920', '', '', '', NULL, '1984-03-30', '', 31937, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (777, 'Active', 'MARIA KAI GORGOS TORNARI', '', '99518223', '', '', '', NULL, '0000-00-00', '', 31895, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (778, 'Active', 'ΓΕΩΡΓΙΟΣ ΑΛΑΜΠΡΙΤΗΣ', '', '24532110', '', '', '', NULL, '0000-00-00', '', 33006, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (779, 'Active', 'STELIOS STYLIANOU', '', '99486965', '', '', 'stelios077@hotmail.com', NULL, '1985-04-30', '', 35455, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (780, 'Active', 'KONSTADINOS IOANNIDES', '', '99882966', '', '', '', NULL, '1982-10-21', '', 31976, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (781, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΕΩΡΓΙΟΥ', '', '99407197', '', '', '', NULL, '1984-07-24', '', 31491, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (782, 'Active', 'MARIA STYLIANOU', '', '99305033', '', '', 'ioannougiannos14@gmail.com', NULL, '1983-12-23', '', 35297, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (783, 'Active', 'ΔΕΣΠΟΙΝΑ ΧΡΥΣΑΝΘΟΥ', '', '96248001', '', '', '', NULL, '1983-10-12', '', 41200, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (784, 'Active', 'GAVRIIL KAIMAKLIOTIS', '', '', '', '', 'gabriel@kaimakliotislaw.com', NULL, '1980-06-30', '', 35603, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (785, 'Active', 'ΜΑΡΙΟΣ ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '99597207', '', '', '', NULL, '1984-05-08', '', 40725, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (786, 'Active', 'ΓΙΑΜΑΝΗ ΔΗΜΗΤΡΙΟΣ & ΧΡΥΣΟΥΛΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 40476, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (787, 'Active', 'ANDREAS MITSIDES', '', '99382329', '', '', 'mitsidesandreas@hotmail.com', NULL, '0000-00-00', '', 40881, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (788, 'Active', 'CHARIS KANAKAS', '', '99578598', '', '', 'kanakasophia@gmail.com', NULL, '1985-04-02', '', 41068, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (789, 'Active', 'MARIEVI ADAMIDOU', '', '', '', '', '', NULL, '0000-00-00', '', 40447, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (790, 'Active', 'ΜΑΡΙΑΝΝΑ ΠΙΕΡΕΤΤΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40962, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (791, 'Active', 'VIVIA  KARAYIANNI', '', '99488443', '', '', 'viviakarayianni@gmail.com', NULL, '1983-10-29', '', 40573, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (792, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΝ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32827, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (793, 'Active', 'ΚΡΙΣ ΧΡΙΣΤΟΦΟΡΟΥ', '', '99584735', '', '', '', NULL, '1984-07-10', '', 31499, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (794, 'Active', 'IOANNA LOIZOY', '', '99843938', '', '', '', NULL, '1983-08-05', '', 31965, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (795, 'Active', 'MARIA PAVLOU', '', '99544450', '', '', '', NULL, '0000-00-00', '', 40359, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (796, 'Active', 'GIANNAKIS KAMBOURIS', '', '99473146', '', '', 'joannagiannakou@yahoo.com', NULL, '1985-03-27', '', 41070, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (797, 'Active', 'ΠΑΡΑΣΚΕΥΗ ΠΑΡΑΣΚΕΥΑ', '', '', '', '', '', NULL, '1986-04-22', '', 40331, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (798, 'Active', 'SAVVAS CHRISTOFI', '', '99861471', '', '', 'savvas.christofi@gmail.com', NULL, '1985-11-14', '', 35201, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (799, 'Active', 'ΑΝΤΩΝΗΣ ΜΗΛΤΙΑΔΟΥΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40914, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (800, 'Active', 'ΜΙΧΑΕΛΛΑ ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '99472516', '', '', '', NULL, '1975-08-02', '', 40369, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (801, 'Active', 'ΙΩΑΝΝΗΣ ΓΙΑΚΟΥΜΗ', '', '99320478', '', '', '', NULL, '0000-00-00', '', 40944, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (802, 'Active', 'CHARRIS KOUFETTAS', '', '99755852', '', '', 'harris@koufettaslaw.com', NULL, '1986-06-14', '', 35479, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (803, 'Active', 'ELENI KIZA', '', '99827982', '', '', 'eleni.kiza@gmail.com', NULL, '1985-09-02', '', 35368, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (804, 'Active', 'SPYROS PHOTIOU', '', '97619013', '', '', '', NULL, '1985-12-12', 'ADDRESS: AIGLIS 6A ANTHOUPOLI NICOSIA 2304', 34667, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (805, 'Active', 'ΛΟΥΚΑΣ ΚΟΥΜΑΝΤΑΡΗ', '', '', '', '', '', NULL, '0000-00-00', '', 39630, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (806, 'Active', 'ELENI XRISTODOULOU', '', '99088968', '', '', '', NULL, '1982-08-02', '', 32035, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (807, 'Active', 'ANDREAS ANDREOU', '', '', '', '', '', NULL, '1986-06-27', '', 40781, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (808, 'Active', 'IOANNIS CONSTANTINOU', '', '99895986', '', '', 'ikonst01@gmail.com', NULL, '1986-11-19', '', 40690, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (809, 'Active', 'ΔΗΜΗΤΡΗΣ ΧΡΙΣΤΟΥ', '', '', '', '', '', NULL, '1986-07-09', '', 40594, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (810, 'Active', 'ΧΡΙΣΤΟΣ ΤΣΙΑΤΤΑΛΟΣ', '', '', '', '', '', NULL, '1986-06-12', '', 40635, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (811, 'Active', 'XENIA ZOUVANI', '', '99129858', '', '', 'xenia.zouvani@hotmail.com', NULL, '1985-02-04', '', 40679, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (812, 'Active', 'DEMETRIS CHRISTOFI', '', '99275375', '', '', 'demetris.christofi@engineer.com', NULL, '0000-00-00', '', 41007, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (813, 'Active', 'XRISTIANA LIASSIDI', '', '96331332', '', '', '', NULL, '1984-09-26', '', 32040, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (814, 'Active', 'CHRISTODOULOS PARPERI', '', '99583124', '', '', 'christosparperi@gmail.com', NULL, '1985-05-31', '', 40327, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (815, 'Active', 'ΠΕΡΣΕΦΩΝΗ ΕΥΡΙΠΙΔΟΥ', '', '', '', '', '', NULL, '1985-03-01', '', 40595, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (816, 'Active', 'ΜΑΡΙΑ ΚΑΛΛΟΥΔΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40953, '2020-01-05 13:24:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (817, 'Active', 'ELISAVET AVRAAMIDOU', '', '99898085', '', '', '', NULL, '1984-05-21', '', 35013, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (818, 'Active', 'διαγραφη ΜΑΡΙΑ ', '', '', '', '', '', NULL, '0000-00-00', '', 32655, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (819, 'Active', 'ANDREAS THEOXARIDES', '', '99429544', '24654981', '', '', NULL, '1986-01-18', '', 31995, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (820, 'Active', 'KLEARCHOS STYLIANIDES', '', '99531730', '', '', 'mrvadam@gmail.com', NULL, '1984-05-11', '', 40446, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (821, 'Active', 'ANTONIS MAKRIS', '', '96690335', '', '', 'antonis1makris@gmail.com', NULL, '1985-02-27', '', 40465, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (822, 'Active', 'ΜΑΡΙΑ ΓΕΡΑΣΙΜΟΥ', '', '99197025', '', '', '', NULL, '1983-11-01', '', 40957, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (823, 'Active', 'ROBERT KEN STAVROY', '', '6/10/1975', '', '', '', NULL, '0000-00-00', '', 32033, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (824, 'Active', 'ΣΤΑΜΑΤΙΑ ΘΕΜΣΤΟΚΛΕΟΥΣ', '', '99', '', '', '', NULL, '0000-00-00', '', 33455, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (825, 'Active', 'PANAGIOTIS GEORGIOU', '', '99699159', '', '26222333', 'audit@ligelaw.eu', NULL, '1987-05-18', 'ADDRESS : AMFITRITIS 10,FLAT 1 PETINOS COURT', 34677, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (826, 'Active', 'CHRYSO KYRIAKOU', '', '99972352', '', '', 'chryso87@yahoo.gr', NULL, '1987-02-23', '', 40566, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (827, 'Active', 'XRISTOS XASAPIS', '', '96516528', '', '', '', NULL, '1985-09-12', '', 31881, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (828, 'Active', 'ΑΛΕΞΑΝΔΡΑ ΜΟΥΣΚΗ', '', '99009200', '', '', '', NULL, '1987-06-23', '', 32020, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (829, 'Active', 'ΙΩΑΝΝΗΣ ΦΙΑΚΚΟΥ', '', '99874106', '', '', '', NULL, '0000-00-00', '', 41278, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (830, 'Active', 'ELENI ACHILLEOS', '', '96218530', '', '', 'eleniachilleos75@gmail.com', NULL, '0000-00-00', '', 41005, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (831, 'Active', 'MARKISIA ELEFTHERIOU', '', '', '', '', '', NULL, '1986-11-30', '', 40328, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (832, 'Active', 'ΜΙΧΑΛΗΣ ΠΑΝΤΕΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 41015, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (833, 'Active', 'ΧΡΙΣΤΟΣ  ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '99769382', '', '', '', NULL, '1987-07-28', '', 40551, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (834, 'Active', 'IRENE ATHANASIOU', '', '', '', '', 'iathanasiou@hotmail.com', NULL, '1982-02-15', '', 35543, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (835, 'Active', 'SOPHOCLIS PAPADOPOULOS', '', '96593533', '', '', 'sophoclespapadopoulos1978@hotmail.com', NULL, '0000-00-00', '', 40897, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (836, 'Active', 'ANDREAS ANDREOU', '', '99572782', '', '', 'a.andreou@internationalaudit.com', NULL, '1987-09-03', '', 41203, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (837, 'Active', 'PANAYIOTIS CHRISTODOULOU', '', '99532612', '', '', 'panchristodoulou@hotmail.com', NULL, '1987-12-10', 'ADDRESS : MANIS 1 STREET AP. 301', 34678, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (838, 'Active', 'EVI THEOFANOUS', '', '99305739', '', '', 'evtheo@gmail.com', NULL, '1986-04-06', '', 40161, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (839, 'Active', 'KORINA TEREZ CONSTANTNIDES', '', '99352742', '', '', 'corinatereza2014@gmail.com', NULL, '1972-05-11', '', 35204, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (840, 'Active', 'διαγραφη κουσι ', '', '', '', '', '', NULL, '0000-00-00', '', 33023, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (841, 'Active', 'POLYVIOS EVANGELOU', '', '0035799723565', '', '', 'p.evangelou@ecoroad.com.cy', NULL, '1985-11-15', '', 33324, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (842, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΤΥΛΙΑΝΗ ', '', '', '', '', '', NULL, '0000-00-00', '', 32789, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (843, 'Active', 'MAPIA KOKKINOY', '', '9979962', '', '', '', NULL, '1987-01-27', '', 31855, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (844, 'Active', 'NICOLAS LARTIDES', '', '96393491', '', '', 'foodcom@mail.com', NULL, '1985-10-16', '', 35016, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (845, 'Active', 'EVGENIA SPYROU', '', '99917872', '', '', 'gabriel.m.gabriel@gmail.com', NULL, '1987-10-13', '', 40219, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (846, 'Active', 'ΑΝΤΩΝΙΑ ΤΑΛΙΑΔΩΡΟΥ', '', '96233239', '', '', '', NULL, '1985-10-27', '', 40716, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (847, 'Active', 'ΝΙΚΟΣ ΧΡΙΣΤΑΚΗ', '', '99795948', '', '', '', NULL, '0000-00-00', '', 40806, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (848, 'Active', 'THEODOROS KYRIAKOU', '', '99307561', '', '', 'k.theodoros88@gmail.com', NULL, '1988-02-26', '', 31975, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (849, 'Active', 'STELLA KALLI', '', '', '', '', '', NULL, '1980-06-19', '', 34973, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (850, 'Active', 'ELPIDA VASILIOU', '', '96658931', '', '', 'panayiotavasiliou70@gmail.com', NULL, '1999-03-30', '', 41347, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (851, 'Active', 'PANAYIOTIS IOANNOU', '', '99527837', '', '', 'maria.mo@live.com', NULL, '1999-04-27', '', 40773, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (852, 'Active', 'EKATERINI ZAMBA', '', '99799190', '', '', 'zambakate30198@gmail.com', NULL, '1998-01-30', '', 35205, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (853, 'Active', 'CHARALAMBOUS ', '', '99691722', '', '', '', NULL, '1999-07-19', '', 35729, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (854, 'Active', 'OLYMPIA PATSALIDOU', '', '', '', '', 'trifonasp64@hotmail.com', NULL, '1998-01-26', '', 35656, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (855, 'Active', 'ANTREAS CHRISTOFOROU', '', '96767688', '', '', '', NULL, '1999-02-08', '', 35296, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (856, 'Active', 'KYRIACOS DEMETRIOU', '', '96848366', '', '', '', NULL, '1999-01-09', '', 41219, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (857, 'Active', 'ANASTASIS MICHAILAS', '', '24530288', '', '', 'chris.michaelas@gmail.com', NULL, '1998-09-11', '', 34278, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (858, 'Active', 'ANDREAS RODOSTHENOUS', '', '96687280', '', '', 'elena.christofi1@gmail.com', NULL, '1999-09-08', '', 35707, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (859, 'Active', 'STAVROS SHIKKIS', '', '99286393', '', '', 'ssiikis@hotmail.com', NULL, '1998-12-01', '', 35319, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (860, 'Active', 'STYLIANI PAPADAMOU', '', '97857072', '', '', 'stylianoula7@hotmail.com', NULL, '0000-00-00', '', 41011, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (861, 'Active', 'MARIA ANASTASIOU', '', '99103313', '', '', 'mariaanastasiou98@outlook.com.gr', NULL, '1998-06-15', '', 34954, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (862, 'Active', 'DEMETRIANOS HADJISTYLLIS', '', '', '', '', '', NULL, '1998-06-16', '', 35151, '2020-01-05 13:24:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (863, 'Active', 'ELINA VONIATI', '', '99060340', '', '', 'f.voniatis@fgholdingsgrou.com', NULL, '1998-07-04', '', 34793, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (864, 'Active', 'MELINA PAPASAVVA', '', '96440024', '', '', 'melinapapasavva@hotmail.com', NULL, '1998-03-28', '', 33910, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (865, 'Active', 'THEOFILOS THEOFILOU', '', '99677180', '', '', 'annaioannou_74@outlook.com', NULL, '1998-01-28', '', 35695, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (866, 'Active', 'LOUKAS ANTONIOU', '', '96443588', '', '', 'loucant9813@gmail.com', NULL, '1998-08-13', '', 35250, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (867, 'Active', 'MARILLENA  IOANNOU', '', '99347233', '', '', 'ioannoumarilena@yahoo.com', NULL, '0000-00-00', '', 33496, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (868, 'Active', 'LORIA CHRISTODOULOU', '', '96297420', '', '', 'loriachristodoulou0498@gmail.com', NULL, '1998-04-22', '', 33914, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (869, 'Active', 'LOUIZA MAKRI', '', '', '', '', '', NULL, '1997-06-17', '', 40352, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (870, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΝ ', '', '', '', '', '', NULL, '0000-00-00', '', 32845, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (871, 'Active', 'LOIZOS ZINONOS', '', '99682172', '', '', '', NULL, '1997-10-07', '', 35246, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (872, 'Active', 'ΛΕΥΤΕΡΗΣ ΠΑΝΑΓH', '', '99906042', '', '', '', NULL, '1997-10-15', '', 32049, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (873, 'Active', 'ANGELINA FOTIADOU', '', '', '', '', 'aphotiadou@gmail.com', NULL, '1997-05-21', '', 33992, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (874, 'Active', 'MARIA ANTONIOU', '', '', '', '', 'marieantoniou97@hotmail.com', NULL, '1997-08-12', '', 35422, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (875, 'Active', 'ΘΕΟΔΩΡΟΣ ΠΑΠΑΝΙΚΟΛΑΟΥ', '', '96711828', '', '', '', NULL, '0000-00-00', '', 41100, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (876, 'Active', 'CONSTANTINA MARDAPITTA', '', '99403479', '', '', 'a.ioannou1@outlook.com', NULL, '1997-01-03', '', 35263, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (877, 'Active', 'ALEXANDROS MAKROMALIS', '', '99851876', '', '', '', NULL, '1997-01-22', '', 32029, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (878, 'Active', 'KONSTANTINOS KASTANOS', '', '99483141', '', '', 'info@kastanosjewels.com', NULL, '1997-04-02', '', 31962, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (879, 'Active', 'DANIEL STAVROU', '', '99928164', '', '', 'dani9hd@hotmail.com', NULL, '1997-02-19', '', 34864, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (880, 'Active', 'ATHINA VASILIOU', '', '96428255', '', '', 'panayiotavasiliou70@gmail.com', NULL, '1996-12-20', '', 41348, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (881, 'Active', 'CHRYSTALLA KYRIAKOU', '', '', '', '', '', NULL, '1996-10-04', '', 35004, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (882, 'Active', 'MILTIADIS SOLOMOU', '', '99198188', '', '', 'miltos.careerac@gmail.com', NULL, '1996-04-20', '', 34728, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (883, 'Active', 'KYRIAKI SOFRONIOU', '', '99114312', '', '', 'koullasofroniou@gmail.com', NULL, '0000-00-00', '', 40963, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (884, 'Active', 'GIANNIS KOUDELLAS', '', '', '', '', '', NULL, '1995-04-12', '', 35485, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (885, 'Active', 'ANDREAS KOUDELLAS', '', '', '', '', '', NULL, '1995-04-12', '', 35484, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (886, 'Active', 'CONSTANTINA CHARALAMBOUS', '', '99012299', '', '', 'constantina_c95@hotmail.com', NULL, '1995-08-22', '', 35727, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (887, 'Active', 'MICHALIS PIERIDES', '', '', '', '', 'michalispierides@gmail.com', NULL, '1995-05-05', '', 40678, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (888, 'Active', 'MARIANNA THEODOSI', '', '', '', '', 'mariannatheodosi@hotmail.com', NULL, '1995-05-01', '', 40453, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (889, 'Active', 'CHARIS NIKA', '', '99374658', '', '', 'charis_nika@hotmail.com', NULL, '1994-04-02', '', 35156, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (890, 'Active', 'CHARALAMBOS KAGIAS', '', '99185452', '', '', 'kagias@live.com', NULL, '1994-05-19', '', 35065, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (891, 'Active', 'ANTONIS EFRAIM', '', '99043683', '', '', 'antonisefraim@yahoo.com', NULL, '1994-06-26', '', 35476, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (892, 'Active', 'ΑΘΑΝΑΣΙΟΣ ΙΟΥΛΙΑΝΟΥ', '', '99312290', '', '', '', NULL, '0000-00-00', '', 31504, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (893, 'Active', 'ELENI ANASTASIOU', '', '', '', '', '', NULL, '1989-02-11', '', 40228, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (894, 'Active', 'ΔΙΑΓΡΑΦΗ ΧΡ ', '', '', '', '', '', NULL, '0000-00-00', '', 32045, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (895, 'Active', 'ELPIDA KYRIAKOU', '', '99262205', '', '', 'elpidakyriakou18@gmail.com', NULL, '1994-10-27', '', 32005, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (896, 'Active', 'MARIA ANTONIOU', '', '99546613', '', '', 'marant3635@gmail.com', NULL, '1995-11-18', '', 35304, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (897, 'Active', 'ΜΑΡΙΑ ΦΡΑΝΓΚΕΣΚΟΥ', '', '97739330', '', '', '', NULL, '1994-11-25', '', 31856, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (898, 'Active', 'ΣΤΑΥΡΟΣ ΠΡΟΚΟΠΙΟΥ', '', '99479751', '', '', '', NULL, '1993-01-18', '', 31867, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (899, 'Active', 'ELENI ZACHARIA NEOPHYTOU', '', '', '', '', '', NULL, '0000-00-00', '', 40591, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (900, 'Active', 'GIORGOS KOUDELLAS', '', '', '', '', '', NULL, '1993-08-04', '', 35486, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (901, 'Active', 'STEPHANOS AFRICANOS', '', '99880190', '', '', '', NULL, '1994-07-12', '', 35724, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (902, 'Active', 'GEORGIOS NIKOLOPOULOS', '', '6942059040', '', '', 'zakzgrapa@hotmail.com', NULL, '1979-02-28', '', 41212, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (903, 'Active', 'ΓΕΩΡΓΙΑ ΑΠΟΣΤΟΛΟΥ', '', '99044636', '', '', 'giwrgosman@hotmail.com', NULL, '0000-00-00', '', 40659, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (904, 'Active', 'ΚΑΤΕΡΙΝΑ ΚΑΙΚΟΥΣΙΗ', '', '', '', '', '', NULL, '1990-08-07', '', 40749, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (905, 'Active', 'ΓΙΩΡΓΟΣ ΜΑΚΡΟΜΑΛΛΗΣ', '', '99676077', '', '', '', NULL, '1994-12-11', '', 32017, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (906, 'Active', 'ANASTASIA HADJISTYLLI', '', '99650575', '', '', '', NULL, '1994-11-15', '', 35152, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (907, 'Active', 'ANDREAS CHRISTOU', '', '', '', '', 'antreas90maria@hotmail.com', NULL, '1990-11-16', '', 35006, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (908, 'Active', 'PANAGIOTIS PAPAZACHARIOU', '', '99163129', '', '', 'p.papazachariou@gmail.com', NULL, '1993-07-30', '', 40407, '2020-01-05 13:24:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (909, 'Active', 'MARIA IOULIANOU', '', '99031004', '', '', 'mariaioulianou92@gmail.com', NULL, '1992-01-04', '', 34764, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (910, 'Active', 'ΒΑΡΝΑΒΑΣ ΚΩΣΤΑ ', '', '', '', '', '', NULL, '1993-11-22', '', 41091, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (911, 'Active', 'ATHANASIOS POUGKAKIOTIS', '', '99550204', '', '', 'thanasispougkakiotis@hotmail.com', NULL, '0000-00-00', '', 40741, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (912, 'Active', 'ELENI ANTONIOU', '', '', '', '', 'eleniantwniou@hotmail.com', NULL, '1993-11-26', '', 35421, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (913, 'Active', 'Ανδρέας Μουσκής', '', '99026100', '', '', '', NULL, '1993-12-15', '', 32443, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (914, 'Active', 'MARIOS NICOLAOU', '', '99594840', '', '', 'marnic1294@yahoo.com', NULL, '0000-00-00', '', 41399, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (915, 'Active', 'ΓΕΩΡΓΙΟΣ ΧΑΤΖΙΗΣΤΑΣΗ', '', '99524530', '', '', '', NULL, '0000-00-00', '', 32850, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (916, 'Active', 'PAVLINA THEODOULOU', '', '', '', '', 'pavlinatheodoulou@gmail.com', NULL, '1992-04-29', '', 35456, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (917, 'Active', 'MARIA KALLISHI', '', '', '', '', '', NULL, '0000-00-00', '', 40500, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (918, 'Active', 'ANDRI CHRISTOFOROU', '', '', '', '', 'andri.ch1@cytanet.com.cy', NULL, '1993-12-04', '', 35508, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (919, 'Active', 'STELIOS THEODOSIOU', '', '99991082', '', '', 'p.avraamides@kalypsisinsurance.com', NULL, '1993-10-27', '', 34732, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (920, 'Active', 'PANAGIOTIS KYRIAKOU', '', '99869101', '', '', 'panagiotis_kyriakou@yahoo.com', NULL, '1992-10-20', '', 32006, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (921, 'Active', 'GIANNAKIS SIANTONAS', '', '99794759', '', '', 'giannis_vr@hotmail.com', NULL, '1991-07-22', '', 40732, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (922, 'Active', 'Pavlos Solomou', '', '99305774', '', '', 'pavlos_30@hotmail.com', NULL, '1991-12-09', '', 32442, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (923, 'Active', 'LEFTERIS KAROLIDIS', '', '96316407', '', '', 'lefteris@hotmail.com', NULL, '1993-12-13', '', 41426, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (924, 'Active', 'YIANNIS MICHAEL', '', '99006966', '', '', 'gmichael834@gmail.com', NULL, '1999-10-20', '', 41199, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (925, 'Active', 'IRENE POLYDOROU', '', '99961425', '', '', 'eirinipolydorou18@gmail.com', NULL, '1993-08-18', '', 34773, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (926, 'Active', 'PARASKEVAS ANASTASIOU', '', '99044696', '', '', 'despo@emafoods.com.cy', NULL, '1992-09-04', '', 34313, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (927, 'Active', 'ELENA NICOLAOU', '', '99208495', '', '', 'tatiananicolova@gmail.com', NULL, '1993-05-04', '', 35082, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (928, 'Active', 'CHARALAMBOS CHARITOU', '', '96842171', '', '', 'charitoucharalambos@gmailcom', NULL, '1992-06-04', '', 35200, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (929, 'Active', 'EMILI KOSTADINOU', '', '99986987', '', '', '', NULL, '1991-01-28', '', 31955, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (930, 'Active', 'ΔΙΑΓΡΑΦΙ ΑΝΔΡΙΑΝΗ ', '', '', '', '', '', NULL, '0000-00-00', '', 33021, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (931, 'Active', 'AGGELIKI ARGYROU', '', '99889718', '', '', 'aggelaargyrou@hotmail.com', NULL, '1992-09-09', '', 40254, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (932, 'Active', 'KOMODROMOS  ', '', '99364589', '', '', 'komodromosano@hotmail.com', NULL, '1991-02-15', '', 41270, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (933, 'Active', 'CHRISTOS TSANGARIS', '', '', '', '', '', NULL, '1191-09-02', '', 33991, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (934, 'Active', 'ΑΝΔΡΕΑΣ ΚΙΤΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41241, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (935, 'Active', 'MAGDALINI STAVRINIDI', '', '', '', '', '', NULL, '1992-01-15', '', 40325, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (936, 'Active', 'ANNITA MARDAPITTA', '', '99403479', '', '', 'a.ioannou1@outlook.com', NULL, '1992-01-16', '', 35262, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (937, 'Active', 'CHRYSTALA KYRIAKOU', '', '004917687860100', '', '', 'chrystallakyriacou@yahoo.com', NULL, '1990-05-28', '', 32007, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (938, 'Active', 'ΠΕΤΡΟΣ ΚΟΥΣΙΑΠΠΑΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41136, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (939, 'Active', 'ANDROULLA ANDREOU', '', '', '', '', '', NULL, '0000-00-00', '', 41182, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (940, 'Active', 'LOUKAS XAROYS', '', '99746750', '', '', '', NULL, '1990-10-03', '', 31964, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (941, 'Active', 'ELISAVET PERICLEOUS', '', '', '', '', '', NULL, '1991-04-06', '', 40641, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (942, 'Active', 'FLOROS GEROLEMOY', '', '99990385', '', '', '', NULL, '1989-09-02', '', 31879, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (943, 'Active', 'ΣΤΑΥΡΟΥΛΛΑ ΓΡΗΓΟΡΙΟΥ', '', '99445815', '', '', '', NULL, '1989-11-30', '', 40368, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (944, 'Active', 'ΑΓΑΘΟΚΛΗΣ ΠΑΠΑΧΡΙΣΤΟΔΟΥΛΟΥ', '', '99689622', '', '', '', NULL, '1989-07-02', '', 31502, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (945, 'Active', 'ALEXANDROS CHRISTODOULIDES', '', '', '', '', '', NULL, '1989-04-13', '', 40490, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (946, 'Active', 'IAKOVOS XASAPIS', '', '99006260', '', '', '', NULL, '1989-02-24', '', 31880, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (947, 'Active', 'STEFANI CHRISTODOULOU', '', '99165199', '', '', 's.christodoulou15@gmail.com', NULL, '0000-00-00', '', 41324, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (948, 'Active', 'ISABELLA KAPITANI', '', '', '', '', '', NULL, '1991-09-05', '', 31871, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (949, 'Active', 'DEMETRA KATECHAKI', '', '', '', '', '', NULL, '0000-00-00', '', 35666, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (950, 'Active', 'STEFANOS MELIOU', '', '9700856', '', '', 's.melios4@gmail.com', NULL, '1991-09-04', '', 40646, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (951, 'Active', 'GEORGIA ANTONIOU', '', '99782472', '', '', 'antreasglikis@outlook.com.gr', NULL, '1990-06-20', '', 35720, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (952, 'Active', 'STAVROS KASTANOS', '', '99483141', '', '', 'info@kastanosjewels.com', NULL, '1995-01-07', '', 31958, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (953, 'Active', 'NATALIA EVANGELIDOU', '', '99860431', '', '', 'nataliaaev@hotmail.com', NULL, '1991-03-10', '', 41337, '2020-01-05 13:24:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (954, 'Active', 'MARIA SIATHA', '', '99778967', '', '', 'antreas90maria@hotmail.com', NULL, '1990-05-07', '', 35009, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (955, 'Active', 'Andreas Sokratous', '', '99048282', '77787770', '25251181', 'asocratous@aplus.com.cy', NULL, '1990-03-27', '', 32052, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (956, 'Active', 'NIKOLAS KLAPPIS', '', '99794867', '', '', 'nikolas_kl@yahoo.com', NULL, '1990-02-14', '', 35732, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (957, 'Active', 'KONSTANTINA PAPAPOLYVIOU', '', '99758880', '', '', 'konstantina.papapolyviou.com', NULL, '1990-02-22', '', 35750, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (958, 'Active', 'ANGELOS TSIANNIS', '', '', '', '', 'atsiannis@gmail.com', NULL, '0000-00-00', '', 33494, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (959, 'Active', 'RENOS PAPANICOLAOU', '', '', '', '', '', NULL, '0000-00-00', '', 33420, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (960, 'Active', 'ANDRIANI LYSSANDROU', '', '99781563', '', '', 'andriani.lysandrou@gmail.com', NULL, '1989-06-22', '', 35367, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (961, 'Active', 'ELPIDA GEORGIOU', '', '', '', '', '', NULL, '1986-04-27', '', 35717, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (962, 'Active', 'CHRYSOSTOMOS ZANNETIS', '', '99407917', '', '', 'amolri@terrameolacy.com', NULL, '0000-00-00', '', 33712, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (963, 'Active', 'ΛΟΥΚΑΣ ΚΥΠΡΗ', '', '', '', '', '', NULL, '0000-00-00', '', 41369, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (964, 'Active', 'CHRYSOVALANTO KARASAMANI', '', '9945582', '', '', 'valentinakarasamani@gmail.com', NULL, '1989-01-16', '', 40217, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (965, 'Active', 'GEORGIOS DELIYIANNIS', '', '', '', '', '', NULL, '0000-00-00', '', 40408, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (966, 'Active', 'ΑΙΚΑΤΕΡΙΝΗ ΚΥΡΙΑΖΗ', '', '96744289', '', '', '', NULL, '0000-00-00', '', 40973, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (967, 'Active', 'AGGELOS SOLOMOU', '', '99113851', '', '', 'aggelion@gmail.com', NULL, '1989-11-08', '', 40210, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (968, 'Active', 'ΧΡΙΣΤΟΣ ΜΕΛΙΟΣ', '', '96376130', '', '', '', NULL, '1989-01-18', '', 40649, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (969, 'Active', 'MARIA PANAYIOTOU', '', '99819802', '', '', 'panayiotou2007@hotmail.com', NULL, '0000-00-00', '', 40804, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (970, 'Active', 'KYRIAKI BOGDANOU', '', '6944285940', '', '', 'kiriakibogdanoucup@gmail.com', NULL, '1962-01-19', '', 41336, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (971, 'Active', 'EIRINI TSEZAILIDOU', '', '6942839448', '', '', 'tsezailidou.ioanna@gmail.com', NULL, '0000-00-00', '', 41253, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (972, 'Active', 'PANAGIOTIS ALIBERTIS', '', '000306944602848', '', '', 's.alimpertis@yahoo.com', NULL, '2000-04-14', '', 40647, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (973, 'Active', 'TAXIARCHOULA ANDREADELLI', '', '00306944602848', '', '', 's_alimpertis@yahoo.GR', NULL, '1973-07-08', '', 40648, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (974, 'Active', 'GEORGIOS KYRIAZIS', '', '6956204023', '', '', 'giwrgoskiriazis@gmail.com', NULL, '1959-01-31', '', 41382, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (975, 'Active', 'MARKOS CHALHOUB FRANGISTAS', '', '99912400', '', '', 'mc.rookie939@gmail.com', NULL, '1971-06-22', '', 41088, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (976, 'Active', 'ANGELIKI GLYPTI', '', '6934415241', '', '', 'angeliki.glyptis@hotmail.com', NULL, '1954-09-22', '', 41106, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (977, 'Active', 'PANAGIOTIS GKLEKAS', '', '96874870', '', '', 'info@aeoliki.com', NULL, '1993-08-02', '', 35073, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (978, 'Active', 'IOANNIS GKLEKAS', '', '96670327', '', '', 'igklekas@aeoliki.com', NULL, '1961-01-01', '', 35075, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (979, 'Active', 'DIMITRIOS GKLEKAS', '', '99232559', '', '', 'info@aeoliki.com', NULL, '1961-01-01', '', 35074, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (980, 'Active', 'ELENI OIKONOMIDOU', '', '6944468303', '', '', 'elenaoikonomidou@yahoo.gr', NULL, '1965-11-07', '', 40808, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (981, 'Active', 'IRENE VRACHLIOTI', '', '6955971627', '', '', 'ivrachlioti@gmail.com', NULL, '1980-04-03', '', 40809, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (982, 'Active', 'DESPOINA LENIKAKI', '', '99670994', '', '', '', NULL, '1975-05-23', '', 40572, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (983, 'Active', 'KLEANTHI ZACHARIOUDAKI', '', '99319345', '', '', 'kleiozacharioudaki@gmail.com', NULL, '1991-07-01', '', 41304, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (984, 'Active', 'LOUKAS KYLAFIS', '', '99646655', '', '', 'christinaavgousti@yahoo.com', NULL, '0000-00-00', '', 40898, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (985, 'Active', 'KONSTANTINOS VERDOULIS', '', '6945505500', '', '', 'kverdouli@gmail.com', NULL, '0000-00-00', '', 41021, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (986, 'Active', 'MANOUELLA EMMANOLOPOULOU', '', '99835545', '', '', 'manuella.emmanolopoulou@yahoo.gr', NULL, '0000-00-00', '', 40885, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (987, 'Active', 'CHRISTINA MOUSTAKA', '', '6948080893', '', '', 'xristinamoustaka@hotmail.com', NULL, '1982-10-05', '', 41370, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (988, 'Active', 'EFTHYMIA RIGOPOULOU', '', '6987104352', '', '', 'mike@oikobrokers.com', NULL, '1992-02-17', '', 40945, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (989, 'Active', 'CHRYSILIA GKLEKA', '', '96670327', '', '', 'igklekas@aeoliki.com', NULL, '1995-07-26', '', 35076, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (990, 'Active', 'SABINA BIKOVA', '', '6936992001', '', '', 'asfetkou@gmail.com', NULL, '0000-00-00', '', 41149, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (991, 'Active', 'ANNA CHRISTAKI', '', '99579737', '', '', 'drstavrou@drstavrou.com', NULL, '1974-03-06', '', 34214, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (992, 'Active', 'CHRISTOS GKARGKANITIS', '', '99564932', '', '', '', NULL, '1979-12-24', '', 40688, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (993, 'Active', 'KONSTANTINOS MITSAKIS', '', '6932750970', '', '', 'xemoni@doctors.org.uk', NULL, '1963-07-17', '', 41069, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (994, 'Active', 'MIKIS GIANNAKOPOULOS', '', '6942420422', '', '', 'mikis.g@healthwatch.gr', NULL, '1970-10-06', '', 40754, '2020-01-05 13:24:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (995, 'Active', 'ASIMINA ROUSSOU', '', '6946745776', '', '', 'roussouas@piraeusbank.gr', NULL, '0000-00-00', '', 41328, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (996, 'Active', 'AIKATERINI VENEDIKTI FOURNARIDI', '', '6944468303', '', '', 'elenaoikonomidou@yahoo.com', NULL, '0000-00-00', '', 40810, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (997, 'Active', 'LOUKIA VAROTSI', '', '6976120597', '', '', 'lu_xu_rian@hotmail.com', NULL, '0000-00-00', '', 40899, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (998, 'Active', 'PARASKEVI MANTRATZI', '', '6977287879', '', '', 'elpinikos8@gmail.com', NULL, '1968-08-10', '', 41065, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (999, 'Active', 'IOANNIS NTOMOTSIDIS', '', '99314594', '', '', 'anjelika73@nikiforidou@gmail.com', NULL, '2001-01-05', '', 34273, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1000, 'Active', 'ANZELIKA NIKIFORIDOU', '', '99314594', '', '', 'anjelika73@nikiforidou@gmail.com', NULL, '1973-09-19', '', 34272, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1001, 'Active', 'ALEXANDROS ILIADES', '', '6907823729', '', '', 'a.iliadis@gmail.com', NULL, '1979-09-30', '', 41147, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1002, 'Active', 'FOTIOS BORAS', '', '6951796391', '', '', 'fotisboras78@gmail.com', NULL, '0000-00-00', '', 40742, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1003, 'Active', 'ALTANI BATOUDAKI', '', '', '', '', 'altouib@gmail.com', NULL, '1970-09-03', '', 39621, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1004, 'Active', 'MARIA CHATZIGEORGIOU', '', '6977781777', '', '', '', NULL, '0000-00-00', '', 40735, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1005, 'Active', 'IOANNIS NTOMOTSIDIS', '', '99314594', '', '', 'anjelika73@nikiforidou@gmail.com', NULL, '2001-01-05', '', 34258, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1006, 'Active', 'GNENRI POLYCHRONIDIS', '', '995624889', '', '', '', NULL, '0000-00-00', '', 41224, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1007, 'Active', 'KONSTANTINOS MAMOPOULOS', '', '6974431154', '', '', 'mk@covermarketinsurance.com', NULL, '0000-00-00', '', 41064, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1008, 'Active', 'AFRODITI KRAVARI', '', '6944765159', '', '', 'afrodite.kravari@gmail.com', NULL, '1980-08-01', '', 40930, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1009, 'Active', 'MARIA TSISKARI', '', '', '', '', 'zavridis@painclinic.com.cy', NULL, '1982-01-28', '', 34303, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1010, 'Active', 'STAVROS CHRYSOSTALLIS', '', '6978331900', '', '', 't-per@otenet.gr', NULL, '0000-00-00', '', 40900, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1011, 'Active', 'MIRELLA FOURNARIDI', '', '6944468303', '', '', 'elenaoikonomidou@yahoo.com', NULL, '1965-11-07', '', 40811, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1012, 'Active', 'HARALAMBOS POLYCHRONAKIS', '', '2104412755', '', '', 'polychronakis.babis@gmail.com', NULL, '0000-00-00', '', 40801, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1013, 'Active', 'EVANGELIA PSYLLA', '', '6944024904', '', '', 'Lilian.psilla@gmail.com', NULL, '0000-00-00', '', 41076, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1014, 'Active', 'ANNA MOUTSIOU', '', '6977764985', '', '', 'a.moutsiou@acg.edu', NULL, '1994-11-10', '', 41205, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1015, 'Active', 'CHARIS NTOMOTSIDIS', '', '99314594', '', '', 'anjelika73@nikiforidou@gmail.com', NULL, '1973-09-26', '', 34270, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1016, 'Active', 'ΔΙΑΓΡΑΦΗ ΖΩΗ  ', '', '', '', '', '', NULL, '0000-00-00', '', 32790, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1017, 'Active', 'KONSTANTINOS ROGDAKIS', '', '96542702', '', '', 'mrizioti@gmail.com', NULL, '1974-06-17', '', 41074, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1018, 'Active', 'STAVROULA ILIADOU', '', '6948504660', '', '', 'siliadou@hotmail.com', NULL, '1979-09-05', '', 41390, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1019, 'Active', 'OURANIA SKOURLI', '', '96597472', '', '', 'raniask8@hotmail.co.uk', NULL, '0000-00-00', '', 40739, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1020, 'Active', 'EFSTATHIA KAPIZIONI', '', '6932311174', '', '', 'info@tkinox.gr', NULL, '1956-02-23', '', 41089, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1021, 'Active', 'KYRIAKOS ARGYROUDIS', '', '6937273402', '', '', 'kyril3455@gmail.com', NULL, '1955-03-04', '', 40771, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1022, 'Active', 'ELENI SPYROPOULOU', '', '', '', '', '', NULL, '0000-00-00', '', 35683, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1023, 'Active', 'NERMIN AMPA', '', '0030693279237', '', '', 'misethenermin@gmail.com', NULL, '1987-08-21', '', 40599, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1024, 'Active', 'NESTORAS PAPAGEORGIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35771, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1025, 'Active', 'ELPNIKI SYRMALENIOU', '', '', '', '', 'icon-a@cytanet.com.cy', NULL, '1974-05-16', '', 35542, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1026, 'Active', 'NICOLE PHOTINI PAPAGEORGIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35770, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1027, 'Active', 'LYDIA FLOURI', '', '699985572', '', '', '', NULL, '0000-00-00', '', 40733, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1028, 'Active', 'ALEXIA POULANTZA', '', '6944440455', '', '', 'apoulantza@gmail.com', NULL, '1974-08-05', '', 41216, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1029, 'Active', 'ELPINIKI MITSAKI', '', '6977287879', '', '', 'elpinikos8@gmail.co ', NULL, '0000-00-00', '', 41077, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1030, 'Active', 'GEORGIA LIARI', '', '6938738904', '', '', 'georgia.liari@gmail.com', NULL, '1982-03-19', '', 41233, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1031, 'Active', 'PHOTINI DESPINA PAPAGEORGIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35773, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1032, 'Active', 'THRASIVOULOS RAPHAEL PAPAGEORGIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35772, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1033, 'Active', 'MIRTO SINNI', '', '6944631150', '', '', 'sinnimirto@gmail.com', NULL, '1980-09-29', '', 41157, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1034, 'Active', 'PAPASPYROPOULOS ', '', '6938944700', '', '', 'spyros.papaspyropoulos@gmail.com', NULL, '1977-05-08', '', 40734, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1035, 'Active', 'GEORGIOS NTOMOTSIDIS', '', '99314594', '', '', 'anjelika73@nikiforidou@gmail.com', NULL, '2004-11-01', '', 34266, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1036, 'Active', 'IULIAN MARIA LEONTE', '', '', '', '', '', NULL, '0000-00-00', '', 41018, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1037, 'Active', 'SPYROS GIANNARAS', '', '', '', '', '', NULL, '0000-00-00', '', 40813, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1038, 'Active', 'C.C EASYTECH COMPUTER SERVICE', '', '99582298', '24819350', '', '', NULL, '0000-00-00', '', 31883, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1039, 'Active', 'ANNA SUSKE', '', '', '', '', '', NULL, '0000-00-00', '', 40977, '2020-01-05 13:24:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1040, 'Active', 'ΧΡΙΣΤΟΣ ΚΑΙ ΑΝΤΡΗ ΖΑΝΝΕΤΤΗ', '', '22879439', '', '', '', NULL, '0000-00-00', '', 32042, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1041, 'Active', 'VASILIS GIANNARAS', '', '', '', '', '', NULL, '0000-00-00', '', 40814, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1042, 'Active', 'MILTOS MICHAILAS', '', '24534788', '', '', 'Gkyriakou@uclancyprus.ac.uk', NULL, '1977-05-22', '', 34279, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1043, 'Active', 'TANG LIJIE', '', '', '', '', '', NULL, '0000-00-00', '', 32993, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1044, 'Active', 'GEORGE NASR', '', '95583887', '', '', 'george.j.nasr@gmail.com', NULL, '1966-04-26', '', 33499, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1045, 'Active', 'ASIMINA GIANNARA', '', '', '', '', '', NULL, '0000-00-00', '', 40815, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1046, 'Active', 'ΕΛΑΝΗ ΚΑΦΑΛΗ', '', '99032143', '', '', '', NULL, '1976-05-21', '', 31854, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1047, 'Active', 'JACQUES NASR', '', '95583887', '', '', 'george.j.nasr@gmail.com', NULL, '2004-12-11', '', 33503, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1048, 'Active', 'SAMIR MARCEL SAAD', '', '', '', '', '', NULL, '0000-00-00', '', 41423, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1049, 'Active', 'RITA BEYROUTHY EP YVES SFEIR', '', '', '', '', '', NULL, '0000-00-00', '', 41424, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1050, 'Active', 'CHRYSTALLENI MYLONAS', '', '24426755', '', '', 'chrystalleni.mylonas@yahoo.com', NULL, '1979-11-29', '', 33537, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1051, 'Active', 'PANAYIOTA HADJIGEORGIOU', '', '99178032', '', '', 'info@yiotatheo.com', NULL, '1993-07-21', '', 34741, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1052, 'Active', 'ELHAM HADDAD', '', '99000300', '', '', '', NULL, '0000-00-00', '', 41004, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1053, 'Active', 'AIKATERINI ANTONIOU', '', '2297091057', '', '', 'studiosmeltemi@hotmail.com', NULL, '0000-00-00', '', 40736, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1054, 'Active', 'GIANNIS KAPIZIONIS', '', '6932311174', '', '', 'info@tkinox.gr', NULL, '1951-03-23', '', 41087, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1055, 'Active', 'PRABHATH WASANTHA MUDIYANSE LAGE THENAKOON', '', '96491473', '', '', '', NULL, '0000-00-00', '', 41183, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1056, 'Active', 'KONSTANTINA NIKOLAOU', '', '99153412', '', '', 'elianagregoriou@yahoo.com', NULL, '2007-11-15', '', 34299, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1057, 'Active', 'NIKITA SENKOVSKIY', '', '', '', '', '', NULL, '0000-00-00', '', 41179, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1058, 'Active', 'KONSTANTINOS ROUSSOS', '', '6972007288', '', '', 'roussouas@piraeusbank.gr', NULL, '1977-08-29', '', 40995, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1059, 'Active', 'SARAH HUNTER', '', '94040458', '', '', 'sarah_hunter@btinternet.com', NULL, '1974-07-09', '', 40971, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1060, 'Active', 'ANDREAS AGAPIOU', '', '99153412', '', '', 'elianagregoriou@yahoo.com', NULL, '2014-11-24', '', 34301, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1061, 'Active', 'WILLIAM EL KHOURY', '', '99000300', '', '', '', NULL, '0000-00-00', '', 41003, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1062, 'Active', 'RUSLAN PINTEA', '', '95575954', '', '', 'ispirpinteacaterina@yahoo.com', NULL, '1976-09-20', '', 40683, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1063, 'Active', 'THOMAS LEKKAKOS', '', '6972313017', '', '', 'tommylek1@gmail.com', NULL, '1980-03-12', '', 41097, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1064, 'Active', 'CHRISTINA-NICOLLETA GEVREKI', '', '6939998621', '', '', 'x.gevreki3@gmail.com', NULL, '1976-10-05', '', 41283, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1065, 'Active', 'ANGELIKI ARGYROUDI', '', '97972550', '', '', 'aargiroudi@hotmail.com', NULL, '1982-03-29', '', 40737, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1066, 'Active', 'THEODOROS ARETAS', '', '99278927', '', '', 'taretas@gmail.com', NULL, '1964-10-22', '', 34794, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1067, 'Active', 'DESPOINA ROBERLE', '', '6974163223', '', '', 'takisroberle@yahoo.gr', NULL, '0000-00-00', '', 41254, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1068, 'Active', 'MARIA KLOTSOTIRA', '', '6971966688', '', '', 'mariaklotsotira@gmail.com', NULL, '0000-00-00', '', 40803, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1069, 'Active', 'GIORGOS PANTELIS', '', '6986277827', '', '', 'g.pantelis91@hotmail.com', NULL, '0000-00-00', '', 40901, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1070, 'Active', 'EIRINI DALKITSI', '', '96677419', '', '', 'eirdalkitsi@gmail.com', NULL, '0000-00-00', '', 41096, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1071, 'Active', 'EVELIN MELIN', '', '97657728', '', '', 'evelin.melin@gmail.com', NULL, '1976-08-09', '', 35541, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1072, 'Active', 'RAMIRO DANIEL GONZALEZ', '', '99323990', '', '', 'n_saitti@yahoo.com', NULL, '1980-07-23', '', 35452, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1073, 'Active', 'MARCO FLORIAN', '', '00306989764621', '', '', 'marcofloriancemb@gmail.com', NULL, '1969-09-18', '', 41055, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1074, 'Active', 'FABRIZIO DE IORIO', '', '99286175', '', '', 'fdi@europe.com', NULL, '1987-09-07', '', 35129, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1075, 'Active', 'ΑΘΑΝΑΣΙΑ ΒΑΣΙΛΕΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41171, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1076, 'Active', 'ASHRAF MOHAMED FAROUK ELSAYED ELKADY', '', '', '', '', '', NULL, '0000-00-00', '', 33012, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1077, 'Active', 'SINGUREAN LIDIA', '', '24642969', '', '', '', NULL, '0000-00-00', '', 32844, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1078, 'Active', 'NIKOLAOS SIAMANIS', '', '99670995', '', '', '', NULL, '1967-06-19', '', 40569, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1079, 'Active', 'STAVROS PIPINIS', '', '97710535', '', '', 'angelamarina@yahoo.gr', NULL, '1977-09-11', '', 40333, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1080, 'Active', 'PETROS MANTIS', '', '6980980017', '', '', 'mantis@madeira.gr', NULL, '1970-01-08', '', 41159, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1081, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΜΠΙΛΛΑΛΗΣ', '', '99339607', '', '', 'eliana_con@yahoo.com', NULL, '1978-08-07', '', 34907, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1082, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΚΑΡΑΤΙΣΟΓΛΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41379, '2020-01-05 13:24:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1083, 'Active', 'ANDREAS GARINIS', '', '99448537', '', '', 'elenaioannou77@hotmail.com', NULL, '1974-11-01', '', 35148, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1084, 'Active', 'ANGELIKI ANTONOPOULOU', '', '0035799723565', '', '', 'p.evangelou@ecoroad.com.cy', NULL, '1987-11-16', '', 33391, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1085, 'Active', 'KONSTANTINOS ROGDAKIS I.E.P.E', '', '96542702', '', '', 'mrizioti@gmail.com', NULL, '0000-00-00', '', 35149, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1086, 'Active', 'STEFANOS MAMALIS', '', '6942952802', '', '', 'mamalis.stefa@gmail.com', NULL, '1995-05-25', '', 41112, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1087, 'Active', 'MICHALIS MICHALAKIS', '', '96802300', '', '', 'mmichalakis@gmail.com', NULL, '1971-07-07', '', 34953, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1088, 'Active', 'MIRANTA GIANNOULAKI', '', '', '', '', '', NULL, '0000-00-00', '', 35769, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1089, 'Active', 'MAIRILYN EMMANOULLOPOULOU', '', '00447843886944', '', '', 'emmanoulopoulou.marilyn@gmail.com', NULL, '1997-08-15', '', 41040, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1090, 'Active', 'CHRISTOS THEMISTOCLEOUS', '', '99443390', '', '', 'c.themistokleous@gmail.com', NULL, '1971-12-25', 'ADDRESS : TRIKALON 1 STREET, 7102 ARADIPPOU', 34679, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1091, 'Active', 'IRODOTOS MOUSIKOS', '', '99316271', '', '24530665', 'sychronioikia@cytanet.com.cy', NULL, '1974-05-18', 'ADDRESS : 2 APOSTOLOU VARNAVA STREET , 7103 ARADIPPOU', 34680, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1092, 'Active', 'ΧΡΙΣΤΟΣ ΠΑΠΑΝΙΚΟΛΑΟΥ ΚΑΙ ΕΛΕΝΗ ΜΠΑΡΟΝ ', '', '99631278', '', '', '', NULL, '0000-00-00', '', 41402, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1093, 'Active', 'EVANGELOS PANTELI', '', '6944368781', '', '', 'g.pantelis91@hotmail.com', NULL, '0000-00-00', '', 40902, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1094, 'Active', 'ΔΗΜΗΤΡΙΟΣ ΡΟΥΜΕΛΙΩΤΗΣ', '', '', '', '', '', NULL, '1967-02-13', '', 40633, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1095, 'Active', 'ATHENA SAMAKLIS', '', '6972244407', '', '', 'athena.samaklis@gmail.com', NULL, '1973-07-09', '', 40972, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1096, 'Active', 'MERIDIAN TRUST', '', '', '', '', 'info@meridian-trust.com', NULL, '0000-00-00', '', 33399, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1097, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ ΠΙΤΣΙΛΛΗΣ', '', '', '', '', 'c.pitsillis@accessfunds.com.cy', NULL, '0000-00-00', '', 33385, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1098, 'Active', 'CLEMENTS EUROPE Ltd', '', '', '', '', '', NULL, '0000-00-00', '', 34682, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1099, 'Active', 'ΣΤΑΥΡΟΣ Γ. ΚΑΣΙΑΝΟΣ ΛΤΔ', '', '24424343', '', '', '', NULL, '0000-00-00', '', 33794, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1100, 'Active', 'ΔΙΑΓΡΑΦΗ ΚΗΠΟΥΡ', '', '', '', '', '', NULL, '0000-00-00', '', 32999, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1101, 'Active', 'K.MARCOU PETROL STATION LTD', '', '24652236', '', '', '', NULL, '0000-00-00', '', 33386, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1102, 'Active', 'STOCKWATCH LTD', '', '99473247', '', '', '', NULL, '0000-00-00', '', 32786, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1103, 'Active', 'ISUZU GARAGE-ΓΕΩΡΓΙΟΣ ΚΑΖΙΚΑΣ & ΣΙΑ ΛΤΔ(ΠΡΑΣΤΙΤΗΣ)', '', '24651519', '', '', '', NULL, '0000-00-00', '', 33328, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1104, 'Active', 'ORTHODOXOU travel& tours ltd', '', '', '', '', 'orthodoxou@cytanet.com.cy', NULL, '0000-00-00', '', 33462, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1105, 'Active', 'KPMG Limited-Larnaca', '', '', '', '', 'Larnaca@kpmg.com.cy', NULL, '0000-00-00', '', 33396, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1106, 'Active', 'CABLENET', '', '11888', '', '', '', NULL, '0000-00-00', '', 33336, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1107, 'Active', 'D & K TELECOM \"KILLIS\" LTD', '', '', '', '', 'dktelecom@cytanet.com.cy', NULL, '0000-00-00', '', 33579, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1108, 'Active', 'V.M. CAVAWAY LTD', '', '24637177', '', '', 'v.m.cavaway@cytanet.com.cy', NULL, '0000-00-00', '', 33765, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1109, 'Active', 'V.HADJIMATHEOU SERVICES LIMITED', '', '24655024', '', '', '', NULL, '0000-00-00', '', 33440, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1110, 'Active', 'ASTROSUN LTD', '', '99473247', '', '', '', NULL, '0000-00-00', '', 32785, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1111, 'Active', 'DHL (CYPRUS) LTD', '', '0035722799000', '', '', 'DHL.Cyprus@dhl.com.cy', NULL, '0000-00-00', '', 33325, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1112, 'Active', 'A A SMILEY GROUP LTD ', '', '', '', '', '', NULL, '0000-00-00', '', 40524, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1113, 'Active', 'ΚΛΙΝΙΚΑ ΕΡΓΑΣΤΗΡΙΑ ΓΙΩΡΓΑΛΛΙΔΗ ΛΤΔ', '', '24656241', '', '', '', NULL, '0000-00-00', '', 33001, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1114, 'Active', 'CYTA ', '', '', '', '', '', NULL, '0000-00-00', '', 33335, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1115, 'Active', 'ΔΙΑΓΡΑΦΗ ΘΕΟΔΩΡΟΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 32674, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1116, 'Active', 'KARYATIS INSURANCE LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33454, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1117, 'Active', 'DIAGRAFI', '', '99434719', '', '', '', NULL, '0000-00-00', '', 32816, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1118, 'Active', 'ΔΙΑΓΡΑΦΗ', '', '24530588', '', '', '', NULL, '0000-00-00', '', 32814, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1119, 'Active', 'MEDIGENCE HOME HEALTHCARE LTD ', '', '22029610', '', '', '', NULL, '0000-00-00', '', 32831, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1120, 'Active', 'ΑΡΓΥΡΙΔΟΥ & ΠΑΠΑΧΡΥΣΟΣΤΟΜΟΥ ΛΤΔ', '', '26622699', '', '', '', NULL, '0000-00-00', 'ΕΣΤΙΑΤΟΡΙΟ', 33028, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1121, 'Active', 'ΔΙΑΓΡΑΦΗ UR', '', '', '', '', '', NULL, '0000-00-00', '', 33007, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1122, 'Active', 'SEGOMEX ENTERPRISES LTD', '', '24000300', '', '', '', NULL, '0000-00-00', '', 32998, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1123, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΜΙΝΗ', '', '', '', '', '', NULL, '0000-00-00', '', 33004, '2020-01-05 13:24:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1124, 'Active', 'ARDENNORTH COMPANY LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33010, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1125, 'Active', 'G.L.ECOWASH LTD', '', '99300322', '', '', '', NULL, '0000-00-00', '', 40638, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1126, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΓΓΕΛΟΣ ΛΤΔ', '', '24531322', '', '', '', NULL, '0000-00-00', '', 32675, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1127, 'Active', 'DIAGRAFH', '', '99434719', '', '', '', NULL, '0000-00-00', '', 32817, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1128, 'Active', 'ΔΙΑΓΡΑΦΗ ΓΕΡΜ', '', '', '', '', '', NULL, '0000-00-00', '', 32653, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1129, 'Active', 'ΦΑΡΜΑ ΑΔΕΡΦΩΝ ΘΕΟΔΩΡΟΥ ΚΥΡΙΑΚΟΥ', '', '24532965', '', '', '', NULL, '0000-00-00', '', 32788, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1130, 'Active', 'ΣΩΤΗΡΗΣ & ΑΡΤΕΜΗΣ ΑΡΤΕΜΙΟΥ', '', '99308117', '', '', '', NULL, '0000-00-00', '', 32454, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1131, 'Active', 'ΔΙΑΧΕΙΡΙΣΤΙΚΗ ΕΠΙΤΡΟΠΗ ΜΟΥΣΚΟΣ', '', '99648280', '', '', '', NULL, '0000-00-00', '', 33011, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1132, 'Active', 'ΜΑΡΙΑ & ΑΡΓΥΡΗΣ ΑΡΓΥΡΟΥ', '', '99426879', '', '', '', NULL, '0000-00-00', '', 32450, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1133, 'Active', 'DIAGRAFI LI', '', '', '', '', '', NULL, '0000-00-00', '', 32826, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1134, 'Active', 'ALPHA BANK CYPRUS Ltd', '', '', '', '', '', NULL, '0000-00-00', '', 33397, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1135, 'Active', 'G.ZOURIDES SERVICES LTD ', '', '', '', '', '', NULL, '0000-00-00', '', 40547, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1136, 'Active', 'Metlife Europe Ltd(Cyprus Branch)', '', '22545845', '', '', 'contact@metlife.com.cy', NULL, '0000-00-00', '', 33400, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1137, 'Active', 'MB23 LTD ', '', '95137962', '', '', '', NULL, '0000-00-00', '', 40372, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1138, 'Active', 'ACL AUTHENTIC CHARISMA LTD ', '', '95799260', '', '', '', NULL, '0000-00-00', '', 40398, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1139, 'Active', 'Almooond Ltd', '', '', '', '', '', NULL, '0000-00-00', 'BULGARIA', 34653, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1140, 'Active', 'ΛΟΥΚΙΑ ΚΑΓΙΑ ΤΥΡΟΚΟΜΕΙΑ ΛΤΔ', '', '99425722', '', '', '', NULL, '0000-00-00', '', 31503, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1141, 'Active', 'CYCROSS MEDICAL SERVICES LTD', '', '24642661', '', '', '', NULL, '0000-00-00', '', 41190, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1142, 'Active', 'ST.RAPHAEL RADIOLOGY DEPARMENT LTD ', '', '24840840', '', '', '', NULL, '0000-00-00', '', 40853, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1143, 'Active', 'DIAGRAFI PANOS', '', '', '', '', 'panossteakhouse@gmail', NULL, '0000-00-00', '', 32448, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1144, 'Active', 'O.N.MOOSIK ', '', '', '', '', '', NULL, '0000-00-00', '', 40798, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1145, 'Active', 'CONSTANTINOS GEORGIOU I.E.P.E. ', '', '99654411', '', '', '', NULL, '0000-00-00', '', 41259, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1146, 'Active', 'IOANNIS A.KALOUDI I.E.P.E. ', '', '99466162', '', '', '', NULL, '0000-00-00', '', 41258, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1147, 'Active', 'PAM-AZON GROSS-UNDEINZECHNDELS LTD', '', '99468096', '', '', '', NULL, '0000-00-00', '', 32058, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1148, 'Active', 'P &A MAISON DE JOIE LTD ', '', '99340144', '', '', '', NULL, '0000-00-00', '', 40675, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1149, 'Active', 'ACTSERV LIMITED ', '', '', '', '', '', NULL, '0000-00-00', '', 40553, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1150, 'Active', 'VERESIE DLC', '', '99598412', '', '', '', NULL, '0000-00-00', '', 41163, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1151, 'Active', 'CHARIS STYLIANOU I.E.P.E. ', '', '99433133', '', '', '', NULL, '0000-00-00', '', 40941, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1152, 'Active', 'KLEANTHI ZACHARIOUDAKI I.E.P.E. ', '', '99329345', '', '', 'kleiozacharioudaki@gmail.com', NULL, '0000-00-00', '', 41335, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1153, 'Active', 'BEAUTY & SOUL SPA BY GABIE ', '', '99614539', '', '', '', NULL, '0000-00-00', '', 40915, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1154, 'Active', 'SAMERON LTD', '', '99131062', '', '', '', NULL, '0000-00-00', '', 40630, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1155, 'Active', 'MTN Cyprus Ltd', '', '', '', '', '', NULL, '0000-00-00', '', 33398, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1156, 'Active', 'DUAL CORPORATE RISKS LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 35672, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1157, 'Active', 'C.MICHAELAS & CO LTD', '', '', '', '', 'info@michaelasgroup.com', NULL, '0000-00-00', '', 33389, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1158, 'Active', 'SAFE SKIES Ltd', '', '', '', '', '', NULL, '0000-00-00', '', 34001, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1159, 'Active', 'A.P MICAHELAS & SONS LTD', '', '99465020', '', '', 'chris.michaelas@gmail.com', NULL, '0000-00-00', '', 34815, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1160, 'Active', 'EUROFREIGHT LOGISTICS CY LTD ', '', '', '', '', '', NULL, '0000-00-00', '', 35625, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1161, 'Active', 'K & C WAFFLE WORLD LTD ', '', '', '', '', '', NULL, '0000-00-00', '', 34814, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1162, 'Active', 'INTERAMERICAN PROPERTY & CASUALTY INS CO S.A. ', '', '', '', '', '', NULL, '0000-00-00', '', 35241, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1163, 'Active', 'DYNAMIC WORKS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 34902, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1164, 'Active', 'A & C Papanikolaou Insurance & Consultants', '', '', '', '', '', NULL, '0000-00-00', '', 32446, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1165, 'Active', 'ST.RAPHAEL PRIVATE HOSPITAL', '', '', '24840840', '', '', NULL, '0000-00-00', '', 31801, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1166, 'Active', 'SANTA KATERINA', '', '', '', '', '', NULL, '0000-00-00', '', 40940, '2020-01-05 13:24:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1167, 'Active', 'A.K. Design Ltd', '', 'T:24628898', '', '', 'a.design@cytane.com.cy', NULL, '0000-00-00', '', 34813, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1168, 'Active', 'G & N IOANNOU (MACHINERY) LTD', '', '23741359', '', '', 'gnioannou@cytanet.com.cy', NULL, '0000-00-00', '', 35121, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1169, 'Active', 'P.PIRILLOS DISTRIBUTORS LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 34997, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1170, 'Active', 'A.K. Demetriou Insurance Agents Sub-Agents & Consu', '', '', '24822622', '', 'info@akdemetriou.com', NULL, '0000-00-00', '', 20413, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1171, 'Active', 'SEMELI HOTELS LIMITED', '', '99583395', '', '', '', NULL, '0000-00-00', '', 40457, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1172, 'Active', 'APOSTOLOS IOANNOUMEDICAL SUPPLIES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35068, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1173, 'Active', 'E.GOLSORSH THERMOMASTERS LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 41208, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1174, 'Active', 'SPYRIDONOV 19 CO LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41073, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1175, 'Active', 'EASYTECH COMPUTER SERVICES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33337, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1176, 'Active', 'V.K.C.A. QUALITY LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35671, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1177, 'Active', 'GIALETTO LTD', '', '', '', '', '', NULL, '0000-00-00', '', 34442, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1178, 'Active', 'SAY WEAR LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 41404, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1179, 'Active', 'LA FEE BEAUTY BY MARIA THEOCLEOUS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 34994, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1180, 'Active', 'HEALTHWATCH CYPRUS LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 40184, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1181, 'Active', 'KEMTER INSURANCE AGENCIES SUB-AGENCIES AND CONSULT', '', '25755954', '', '', 'kemter@kemterinsurance.com', NULL, '0000-00-00', '', 35046, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1182, 'Active', 'AOS CYPRUS HOLDING LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35660, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1183, 'Active', 'CH.PIZZA MOU LIMITED ', '', '', '', '', '', NULL, '0000-00-00', '', 40887, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1184, 'Active', 'ELIAS CHRISTOFI & CO LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40221, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1185, 'Active', 'FF2 IT SOLUTIONS LTD', '', '', '', '', 'FF2Solutions@cytanet.com.cy', NULL, '0000-00-00', '', 40380, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1186, 'Active', 'M.P.Y. Agent Supporting Ltd', '', '70008070', '', 'ΦΑΞ 70008071', 'info@agentsupporing.com', NULL, '0000-00-00', '', 33384, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1187, 'Active', 'HAIR ETC INSTITUTION LTD', '', '99779142', '', '', 'hairetcstudio@icloud.com', NULL, '0000-00-00', '', 34820, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1188, 'Active', 'DELROCK INVESTMENTS LTD', '', '22464584', '', '', '', NULL, '0000-00-00', '', 40933, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1189, 'Active', 'NELBAY LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 41289, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1190, 'Active', 'G.P. AUDITWORLD LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40657, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1191, 'Active', 'IQ OPTION EUROPE LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40712, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1192, 'Active', 'STRONG TITANES SPORTS CENTER LTD', '', '', '', '', '', NULL, '0000-00-00', '', 34993, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1193, 'Active', 'TUS AIRWAYS Ltd', '', '', '', '', '', NULL, '0000-00-00', '', 35210, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1194, 'Active', 'P & M KOSTA LTD ', '', '99054849', '', '', '', NULL, '0000-00-00', '', 35355, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1195, 'Active', 'IVERA GRACE LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41130, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1196, 'Active', 'PROPWELL PROPERTY L.L.C.', '', '', '', '', '', NULL, '0000-00-00', '', 34992, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1197, 'Active', 'SOLID CHOICE CONSTRUCTIONS LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 41243, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1198, 'Active', 'G.KAIMAKLIOTIS & Co LtD', '', '24628501', '', '', '', NULL, '0000-00-00', '', 34364, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1199, 'Active', 'ARDENNORTH COMPANY LTD', '', '24000300', '', '', '', NULL, '0000-00-00', '', 41220, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1200, 'Active', 'WOLFSON BERG LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 35569, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1201, 'Active', 'N.S. NEWLINE SERVICES LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 40707, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1202, 'Active', 'N.S. NEWLINE SERVICES LIMITED ', '', '', '', '', '', NULL, '0000-00-00', '', 40709, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1203, 'Active', 'H.L. PROPERTY BROKERS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41334, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1204, 'Active', 'BRANDERBURG MARINE INSURANCE BROKERS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41181, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1205, 'Active', 'NEXTCORNER SERVICES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40711, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1206, 'Active', 'MAINTRIX LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41421, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1207, 'Active', 'P.ATTIKOURIS & CO LLC', '', '', '', '', '', NULL, '0000-00-00', '', 40710, '2020-01-05 13:24:35', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1208, 'Active', 'EXENCON LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41345, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1209, 'Active', 'ΕΡΓΟΛΑΒΟΣ ΟΔΟΠΟΙΙΑΣ ΣΤΑΥΡΟΣ Μ.ΣΤΑΥΡΟΥ ΛΤΔ', '', '', '', '', '', NULL, '0000-00-00', '', 41344, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1210, 'Active', 'B.D.BLACK DOG CREATIVE AGENCY LTD ', '', '99520522', '', '', '', NULL, '0000-00-00', '', 40374, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1211, 'Active', 'SDZ SUPPORT AND TECHNOLOGIES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40993, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1212, 'Active', 'SECU5 LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40692, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1213, 'Active', 'ULTIMATE Fintech PTE LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40922, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1214, 'Active', 'QCL QUAD CODE CY LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 41287, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1215, 'Active', 'KONSTANTIN KAUZ CLOUD SOLUTIONS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40564, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1216, 'Active', 'PCSOLO LTD', '', '96685320', '', '', 'solowojcik@gmail.com', NULL, '0000-00-00', '', 40234, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1217, 'Active', 'ΝΚΑ ΚΡΗΤΙΚΟΣ SUPERMARKET CASH & CARRY LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41017, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1218, 'Active', 'C.P. KAIMAKLIOTIS PROPERY VALUATIONS L.L.C.', '', '', '', '', '', NULL, '0000-00-00', '', 40818, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1219, 'Active', 'HAND OF KIKO LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41387, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1220, 'Active', 'A & CHR AVRAAMIDES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35627, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1221, 'Active', 'C & M STEEL MASTER LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35626, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1222, 'Active', 'COSMARI PRINTERS LTD', '', '24664520', '', '', 'cosmari@cytanet.com.cy', NULL, '0000-00-00', '', 34787, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1223, 'Active', 'ALTO CEMENTOCHEMICA LTD ', '', '', '', '', '', NULL, '0000-00-00', '', 35335, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1224, 'Active', 'LE MAISON DE L ANTIQUAIRE', '', '22102405', '', '', '', NULL, '0000-00-00', '', 41255, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1225, 'Active', 'Tsiakkastel OFFICE LINE LTD', '', 'SUPPLIES 22862700', 'ACCOUNTS 22862805', '', '', NULL, '0000-00-00', '', 33426, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1226, 'Active', 'GLASS MARKET BY LAMPROS PAMPOSKIS', '', '25716838', '', '', '', NULL, '0000-00-00', '', 35568, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1227, 'Active', 'EMERGO WEALTH LTD', '', '', '', '', '', NULL, '0000-00-00', '', 41025, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1228, 'Active', 'Π.ΑΝΑΣΤΑΣΙΟΥ ΜΕΤΑΦΟΡΕΣ ΛΤΔ', '', '', '', '', '', NULL, '0000-00-00', '', 40610, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1229, 'Active', 'ANASTASIA CONSTANTI', '', '99459024', '', '', '', NULL, '2015-03-07', '', 33806, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1230, 'Active', 'TATIANA KOVGANKO', '', '99459024', '', '', '', NULL, '1982-12-27', '', 33810, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1231, 'Active', 'COSTAS CONSTANTI', '', '99459024', '', '', '', NULL, '1973-12-04', '', 33811, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1232, 'Active', 'NOTIS KIOURTZIDIS', '', '99851013', '', '', 'edheere327@gmail.com', NULL, '1961-01-02', '', 40774, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1233, 'Active', 'NICKOLA NEVILLE MUNRO', '', '99424067', '', '', 'nicky_munroe@yahoo.com', NULL, '1974-07-11', '', 34742, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1234, 'Active', 'ESLAM ABDALLA', '', '97715315', '', '', 'smsmeslam75@yahoo.com', NULL, '1988-08-02', '', 40640, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1235, 'Active', 'JANET HELEN SWAINGER', '', '96519456', '', '', 'swaingerjanet@gmail.com', NULL, '1952-05-01', '', 35244, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1236, 'Active', 'diagrafi ', '', '', '', '', '', NULL, '0000-00-00', '', 32824, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1237, 'Active', 'ORIT COHEN SHEMESH ', '', '96942227', '', '', '', NULL, '1985-10-23', '', 40666, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1238, 'Active', 'SHAI BAR', '', '', '', '', '', NULL, '1988-01-15', '', 40261, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1239, 'Active', 'FABRIZIO DE IORIO', '', '99286175', '', '', 'fdi@europe.com', NULL, '1987-09-07', '', 35130, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1240, 'Active', 'NATAN COHEN ', '', '96942227', '', '', '', NULL, '1983-08-18', '', 40667, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1241, 'Active', 'AMALIA TSAKMAKI', '', '99778967', '', '', 'trelos1948@gmail.com', NULL, '1963-06-12', '', 34795, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1242, 'Active', 'ETEL BAR', '', '96636005', '', '', 'cohen.etel@gmail.com', NULL, '1988-11-23', '', 40260, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1243, 'Active', 'EMILY BAR', '', '', '', '', '', NULL, '2018-07-04', '', 40262, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1244, 'Active', 'JASMINE BAR', '', '', '', '', '', NULL, '2018-07-04', '', 40263, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1245, 'Active', 'ΑΛΕΞΑΝΔΡΟΣ ΔΑΒΙΔΗΣ ', '', '97721104', '', '', '', NULL, '1970-06-07', '', 40856, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1246, 'Active', 'ZVEZDELIN  SPASOV', '', '99996952', '', '', 'asteris.spasov@gmail.com', NULL, '1984-03-11', '', 34746, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1247, 'Active', 'LOUISE DIANA RAMADAN', '', '96573211', '', '', 'louise.ramadan@gmail.com', NULL, '1983-02-26', '', 34910, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1248, 'Active', 'SUZAN ELISABETH LOURENSZ', '', '99285668', '', '', 'slourensz@icloud.com', NULL, '1962-06-21', '', 35340, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1249, 'Active', 'NORMAN JAMES PACEY', '', '99394574', '', '', 'norman@njpaceylandscaping.co.uk', NULL, '1954-06-04', '', 40549, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1250, 'Active', 'JANE WOOLLISCROFT', '', '', '', '', '', NULL, '0000-00-00', '', 40624, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1251, 'Active', 'MARGARET REID BRACELAND', '', '', '', '', 'margaret.braceland@yahoo.co.uk', NULL, '1963-01-18', '', 40167, '2020-01-05 13:24:36', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1252, 'Active', 'FROSA COONEY', '', '97663392', '', '', 'frosauk@gmail.com', NULL, '1963-08-03', '', 34858, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1253, 'Active', 'DIMITRIS GEORGIOU', '', '99546565', '', '', 'kedoltd@cytanet.com.cy', NULL, '1998-04-23', '', 34047, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1254, 'Active', 'POLINA KOROTAEVA', '', '99341058', '', '', 'maxim2k@yahoo.com', NULL, '2007-05-23', '', 33508, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1255, 'Active', 'JULIA KOROTAEVA', '', '99341058', '', '', 'maxim2k@yahoo.com', NULL, '2009-08-05', '', 33509, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1256, 'Active', 'LEV VAYSMAN', '', '', '', '', '', NULL, '2012-12-10', '', 40292, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1257, 'Active', 'CRAIG NIXON', '', '95728145', '', '', 'cnixonuae@gmail.com', NULL, '1966-02-24', '', 34948, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1258, 'Active', 'CONSTANTINOS HADJINICOLAS', '', '99923276', '', '', 'contactdino@gmail.com', NULL, '1976-12-14', '', 41146, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1259, 'Active', 'FADIEL CHARALAMBOU', '', '99170486', '', '', '', NULL, '1945-10-28', '', 35066, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1260, 'Active', 'PANAYIOTA PLOUTARCHOU', '', '07597115829', '', '', 'yiotaspl@hotmail.com', NULL, '1989-04-11', '', 31809, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1261, 'Active', 'CONSTANTINOS PLOUTARCHOU', '', '99347650', '', '', 'andplo@mtnmail.com.cy', NULL, '1995-12-20', '', 33912, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1262, 'Active', 'IRINA POLYAKOVA', '', '96521352', '', '', 'irinacyprus@gmail.com', NULL, '1988-02-18', '', 34786, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1263, 'Active', 'ELENA NURMAGAMBETOVA', '', '99811642', '', '', 'magicalmarcos69@yahoo.com', NULL, '1979-06-10', '4548 9134 0019 6759 // 03/19 // MARK MORLAND DARBYSHIRE', 31802, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1264, 'Active', 'Maksim Korotaev', '', '99341058', '', '', 'maxim2k@yahoo.com', NULL, '1969-02-04', '', 32080, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1265, 'Active', 'Elena Diadichenko', '', '99341058', '', '', 'maxim2k@yahoo.com', NULL, '1982-04-03', '', 32426, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1266, 'Active', 'KONSTANTIN VAYSMAN', '', '99737415', '', '', 'kvaysman@gmail.com', NULL, '1969-10-14', '', 40290, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1267, 'Active', 'KSENIA VAYSMAN', '', '', '', '', '', NULL, '1981-06-11', '', 40291, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1268, 'Active', 'HELEN PRICE', '', '99120782', '', '', '', NULL, '1967-03-28', '', 41109, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1269, 'Active', 'DAVID HAMILTON MULVANNY', '', '99922104', '', '', 'davidmulvanny@yahoo.com', NULL, '1956-05-25', '', 40207, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1270, 'Active', 'ALAN BETCHLEY', '', '99900411', '', '', 'alan@betchley.com', NULL, '1952-08-19', '', 35448, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1271, 'Active', 'ALEWANDER WINKIE BRACELAND', '', '', '', '', 'alex.braceland@yahoo.co.uk', NULL, '0000-00-00', '', 40168, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1272, 'Active', 'ZVEZDELIN SPASOV', '', '99996952', '', '', 'asteris.spasov@gmail.com', NULL, '1984-03-11', '', 34748, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1273, 'Active', 'RUDOLF WIJNS', '', '99245751', '', '', 'stone-fieldsphotmail.com', NULL, '1960-09-22', '', 40601, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1274, 'Active', 'Polina Korotaeva', '', '99341058', '', '', 'maxim2k@yahoo.com', NULL, '2007-05-23', '', 32427, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1275, 'Active', 'Julia Korotaeva', '', '99341058', '', '', 'maxim2k@yahoo.com', NULL, '2009-08-05', '', 32428, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1276, 'Active', 'GANG WANG', '', '99492883', '', '', '', NULL, '1974-08-15', '', 35248, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1277, 'Active', 'ALEXANDRA POPOVICH', '', '99593012', '', '', 'popovichalexandra19@gmail.com', NULL, '1992-07-19', '', 35621, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1278, 'Active', 'VLADISLAV MILEV', '', '96607508', '', '', 'vladi.sliven70@gmail.com', NULL, '1970-12-04', '', 41237, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1279, 'Active', 'YA KOU', '', '96074409', '', '', '', NULL, '1978-10-10', '', 35199, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1280, 'Active', 'Mark Morland Darbyshire', '', '99811642', '', '', 'magicalmarcos69@yahoo.com', NULL, '1957-11-25', '4548 9134 0019 6759 // 03/19 // MARK MORLAND DARBYSHIRE', 31818, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1281, 'Active', 'MARIA PAPAKOSTA GEORGIOU', '', '99546565', '', '', 'kedoltd@cytanet.com.cy', NULL, '1976-01-11', '', 34071, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1282, 'Active', 'TINA PAPALEONTIOU', '', '97676039', '', '', 'tinapapaleontiou@gmail.com', NULL, '1967-06-02', '', 34887, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1283, 'Active', 'NICOLAS GEORGIOU', '', '99546565', '', '', 'kedoltd@cytanet.com.cy', NULL, '2005-12-07', '', 34050, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1284, 'Active', 'MICHALIS GEORGIOU', '', '99546565', '', '', 'kedoltd@cytanet.com.cy', NULL, '0000-00-00', '', 34048, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1285, 'Active', 'RUSLAN  SHAKHBAZOV', '', '24000300', '', '', '', NULL, '1992-10-21', '', 40552, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1286, 'Active', 'SEMEN PROKHOROV', '', '99910821', '', '', 'samprohorov@gmail.com', NULL, '0000-00-00', '', 41256, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1287, 'Active', 'ELISABETH MARIA BEATRIZ', '', '99623811', '', '', 'akis9197@gmail.com', NULL, '1965-03-06', '', 34892, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1288, 'Active', 'ANDREY GOLOBOKOV', '', '95192095', '', '', 'andrew3763@gmail.com', NULL, '1963-12-05', '', 35028, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1289, 'Active', 'OLGA YURGENSON', '', '97872441', '', '', 'rosnovskaya@bk.ru', NULL, '1987-11-07', '', 41211, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1290, 'Active', 'DMITRY KATAEV', '', '96220536', '', '', 'd.kataev@gmail.com', NULL, '1986-03-22', '', 34765, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1291, 'Active', 'OKSANA POLIAKOVA', '', '95757162', '', '', '', NULL, '0000-00-00', '', 40778, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1292, 'Active', 'OLGA LOGUTOVA', '', '96628191', '', '', 'log310@mail.ru', NULL, '0000-00-00', '', 40883, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1293, 'Active', 'MATTHEW PLATTEN', '', '99288897', '', '', 'matt@platten.fr', NULL, '0000-00-00', '', 41006, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1294, 'Active', 'NICHOLAS MASKELL', '', '96490791', '', '', 'maskellchristine@yahoo.co.uk', NULL, '1980-02-18', '', 41197, '2020-01-05 13:24:37', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1295, 'Active', 'BUDACH JOSCHKA', '', '', '', '', '', NULL, '1992-09-01', '', 35057, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1296, 'Active', 'REBECCA THEODORA ARAMPAMPASLI', '', '99421934', '', '', 'theo.arampampaslis@gmail.com', NULL, '2004-09-10', '', 33908, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1297, 'Active', 'SARRA DEGERMENTZIDOU ARAMPAMPASLI', '', '99421934', '', '', 'theo.arampampaslis@gmail.com', NULL, '1972-10-01', '', 33905, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1298, 'Active', 'CHRISTOS ARAMPAMPASLIS', '', '99421934', '', '', 'theo.arampampaslis@gmail.com', NULL, '2001-09-10', '', 33906, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1299, 'Active', 'ANTONIOS LAZAROS ARAMPAMPASLIS', '', '99421934', '', '', 'theo.arampampaslis@gmail.com', NULL, '2002-11-18', '', 33907, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1300, 'Active', 'THEODOROS ARAMPAMPASLIS', '', '99421934', '', '', 'theo.arampampaslis@gmail.com', NULL, '1970-06-04', '', 33821, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1301, 'Active', 'ALI IBRAHIM EISH MOHAMEND EL ', '', '99020109', '', '', '', NULL, '0000-00-00', '', 41155, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1302, 'Active', 'Savvas Grigoriades', '', '+306980073770', '', '+302310252547', 'info@grigoriadis.org', NULL, '1967-10-21', '1 Pavlou Mela, Thessaloniki, Greece, 54621', 32056, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1303, 'Active', 'ΔΗΜΗΤΡΙΟΣ ΧΑΤΖΗΣ', '', '99811109', '', '', '', NULL, '1959-05-05', '', 40371, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1304, 'Active', 'Eleni Polyzoidou', '', '+306980073770', '', '+302310252547', 'info@grigoriadis.org', NULL, '1976-11-01', '1 Pavlou Mela, Thessaloniki, Greece, 54621', 32057, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1305, 'Active', 'ALEXANDRA SIAMANI', '', '', '', '', '', NULL, '2015-12-04', '', 40571, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1306, 'Active', 'MARIA ELEFTHERIA KARAOLIDOU', '', '', '', '', '', NULL, '0000-00-00', '', 35684, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1307, 'Active', 'MICHAELA MARIA SIAMANI', '', '', '', '', '', NULL, '2011-08-12', '', 40570, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1308, 'Active', 'GKARGKANITIS ', '', '', '', '', '', NULL, '2015-03-17', '', 40689, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1309, 'Active', 'WITEK MARCIN', '', '', '', '', '', NULL, '1981-05-28', '', 40296, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1310, 'Active', 'Chrysoula Maria Grigoriadou', '', '+306980073770', '', '+302310252547', 'info@grigoriadis.org', NULL, '2011-06-28', '1 Pavlou Mela, Thessaloniki, Greece, 54621', 32059, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1311, 'Active', 'ZUZANA MAVROMOUSTAKIS ZAJACOVA', '', '99262257', '', '', 'suzzyquatro@gmail.com', NULL, '1990-07-14', '', 34920, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1312, 'Active', 'CYCROSS MEDICAL SERVICES', '', '24642661', '', '', '', NULL, '0000-00-00', '', 31940, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1313, 'Active', 'ΔΙΑΓΡΑΦΗ   THEOHARIDES LIMITED', '', '99429544', '', '', '', NULL, '1986-11-18', '', 31985, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1314, 'Active', 'METALPOL', '', '99214915', '', '', '', NULL, '0000-00-00', '', 31969, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1315, 'Active', 'TORSTEN MICHAEL JAEGER', '', '97746310', '', '', 'sattelite.de@gmail.com', NULL, '1966-09-23', '', 33800, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1316, 'Active', 'UTE LIPPELT GEB BRUCKNER', '', '97746310', '', '', 'sattelite.de@gmail.com', NULL, '1972-11-25', '', 33801, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1317, 'Active', 'ΑΔΕΛΦΟΙ Χ. ΚΑΓΙΑ ΛΤΔ', '', '99617701', '', '', '', NULL, '0000-00-00', '', 31963, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1318, 'Active', 'C.C EASYTECH COMPUTER SERVICE', '', '99582298', '24819350', '', '', NULL, '0000-00-00', '', 31884, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1319, 'Active', 'LUIS ANTON JANTSCH', '', '', '', '', 'luisjantsch@gmx.de', NULL, '1998-05-07', '', 35242, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1320, 'Active', 'TERRAMEDIA INTERACTIVE LTD', '', '99407917', '', '', '', NULL, '0000-00-00', '', 32030, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1321, 'Active', 'IMER MEDICAL SERVICES LTD', '', '22763001', '', '', '', NULL, '0000-00-00', '', 31991, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1322, 'Active', 'YAMBOLA TRADING LTD', '', '', '', '', '', NULL, '0000-00-00', '', 31900, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1323, 'Active', 'HAGULAND TRADING LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 32043, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1324, 'Active', 'ΤΟ ΓΛΕΝΤΙ ΤΩΝ ΓΕΥΣΕΩΝ', '', '99432676', '', '', '', NULL, '0000-00-00', '', 31915, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1325, 'Active', 'SOTEROULA GEORGIOU THEMISTOCLEOUS', '', '99443390', '', '', 'cthemistokleous@gmail.com', NULL, '1976-02-16', '', 34044, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1326, 'Active', 'FIETE DUWEL', '', '', '', '', '', NULL, '2003-04-04', '', 40343, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1327, 'Active', 'RONNY DUWEL', '', '004917623593865', '', '', 'vouuyduewel@online.de', NULL, '1977-06-20', '', 40340, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1328, 'Active', 'STINE DUWEL', '', '', '', '', '', NULL, '2001-06-22', '', 40342, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1329, 'Active', 'ANTJE DUWEL', '', '', '', '', '', NULL, '1980-03-14', '', 40341, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1330, 'Active', 'AΓΓΕΛΟΣ ΧΑΡΟΥΣ', '', '99665367', '24531322', '', '', NULL, '1959-07-03', '', 31864, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1331, 'Active', 'ΔΙΑΓΡΑΦΗ STAVROS ', '', '', '', '', '', NULL, '0000-00-00', '', 31990, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1332, 'Active', 'MICHAEL ROMAN WEBERS', '', '', '', '', '', NULL, '1964-07-16', '', 35425, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1333, 'Active', 'OLIVER HUEGELMANN', '', '+14846659569', '', '', 'oliver@voc-consulting.me', NULL, '1980-07-07', '', 34734, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1334, 'Active', 'VENIERA LTD', '', '25871330', '', '', '', NULL, '0000-00-00', '', 32044, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1335, 'Active', 'COSAMRI PRINTERS LTD', '', '99617419', '', '', '', NULL, '0000-00-00', '', 31898, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1336, 'Active', 'diagrammenos pelatis', '', '', '', '', '', NULL, '0000-00-00', '', 31901, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1337, 'Active', 'STEFAN BERNS', '', '4915140004509', '', '', 'stefanberns@googlemail.com', NULL, '1971-10-28', '', 33805, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1338, 'Active', 'HERM WOLFGANG', '', '0049015125315551', '', '', 'mail@herm.consulting', NULL, '0000-00-00', '', 40886, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1339, 'Active', 'SIMBA MOTORS', '', '99624719', '', '', '', NULL, '0000-00-00', '', 31852, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1340, 'Active', 'SΙΜΒΑ ΜΟΤΟRS LΤD', '', '99624719', '', '', '', NULL, '0000-00-00', '', 31899, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1341, 'Active', 'CLAUDIA MARIA VILORIA', '', '457675727', '', '', 'info@schwarzwald-jaegerhof.de', NULL, '1962-08-07', '', 33797, '2020-01-05 13:24:38', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1342, 'Active', 'VASILLIOS ANDREAS KOKKALIS', '', '', '', '', 'vassili@voc-consulting.me', NULL, '1974-07-07', '', 34816, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1343, 'Active', 'LILI YAO', '', '', '', '', '', NULL, '0000-00-00', '', 41173, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1344, 'Active', 'MARIOS OTHONOS', '', '99537883', '', '', 'mariosotho@hotmail.com', NULL, '1984-06-19', '', 34729, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1345, 'Active', 'ANDREAS KARITTEVLIS', '', '99599697', '', '', 'andreask@ambrosia.com.cy', NULL, '1957-10-24', '', 33915, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1346, 'Active', 'Panayiotis Ioannou', '', '26941762', '0097477951319', '99552552', 'panaos84@hotmail.com', NULL, '1984-09-11', 'No 163, NUAIJA, 41 HILAL WEST, RAWDAT AL KHAIL STR 330. PO BOX 12924, DOHA, QATAR', 31819, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1347, 'Active', 'LIU HOUFU', '', '', '', '', '', NULL, '0000-00-00', '', 40757, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1348, 'Active', 'PANAYIOTA SOTERIOU', '', '24633176', '', '', 'drsoteriou@gmail.com', NULL, '1954-03-27', '', 31930, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1349, 'Active', 'ADAMOS HADJIPANAGIS', '', '', '', '', '', NULL, '1963-06-24', '', 35084, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1350, 'Active', 'IRYNA MOUSIKOU', '', '99316271', '', '', 'sychronioikia@cytanet.com.cy', NULL, '1977-02-04', '', 34308, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1351, 'Active', 'Stephanie Nastashia Charalambous', '', '22771079', '', '', 'stephanie.nc@gmail.com', NULL, '1988-06-02', '', 31832, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1352, 'Active', 'CHRISTOS THEMISTOCLEOUS', '', '99443390', '', '', 'cthemistokleous@gmail.com', NULL, '1971-12-25', '', 34045, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1353, 'Active', 'CHARALAMBOS MICHAEL', '', '', '', '', '', NULL, '1961-02-09', '', 33815, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1354, 'Active', 'IOANNIS KARAOLIDES', '', '97785344', '', '', 'karaolid@yahoo.com', NULL, '1973-06-22', '', 35682, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1355, 'Active', 'MARLEY ELISA JAEGER', '', '97746310', '', '', 'sattelite.de@gmail.com', NULL, '2010-09-26', '', 33804, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1356, 'Active', 'KEO JAEGER', '', '97746310', '', '', 'sattelite.de@gmail.com', NULL, '2008-11-04', '', 33803, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1357, 'Active', 'DUO SUN', '', '', '', '', '', NULL, '1977-05-12', '', 35294, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1358, 'Active', 'THERESA BORJE DURAN ', '', '', '', '', '', NULL, '1983-10-28', '', 40695, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1359, 'Active', 'DAGMARA KAROLINA JANSEEN', '', '', '', '', 'dag7@wp.pl', NULL, '1978-09-06', '', 35705, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1360, 'Active', 'AGNISZKA WOJCIK', '', '', '', '', '', NULL, '1987-11-23', '', 40236, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1361, 'Active', 'VICTORIA MARIA WOJCIK', '', '', '', '', '', NULL, '2013-04-28', '', 40237, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1362, 'Active', 'MARCIN RAFAL WOJCIK', '', '', '', '', '', NULL, '1987-01-05', '', 40235, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1363, 'Active', 'JAN JERZY  ORZESZKO', '', '', '', '', '', NULL, '0000-00-00', '', 41377, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1364, 'Active', 'George Nasr', '', '95583887', '', '', 'george.j.nasr@gmail.com', NULL, '1966-04-26', '', 32053, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1365, 'Active', 'MARIA INIATI', '', '99190279', '', '', 'maria@gfdigital.eu', NULL, '1963-05-13', '', 34738, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1366, 'Active', 'MARKOS TSIORBATZUDIS', '', '97676039', '', '', 'tinapapaleontiou@gmail.com', NULL, '2011-05-13', '', 34889, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1367, 'Active', 'VASILIS ANDREOU', '', '0035799648215', '', '', 'vandreou@drstavrou.com', NULL, '1993-11-17', '', 34073, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1368, 'Active', 'VASILEIA-EIRINI MICHAILA', '', '24530288', '', '', 'Gkyriakou@uclancyprus.ac.uk', NULL, '2010-05-24', '', 34282, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1369, 'Active', 'NICHOLE MOUSIKOS', '', '99316271', '', '', 'sychronioikia@cytanet.com.cy', NULL, '2002-11-30', '', 34305, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1370, 'Active', 'EVANGELOS MOUSIKOS', '', '99316271', '', '', 'sychronioikia@cytanet.com.cy', NULL, '2006-10-26', '', 34306, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1371, 'Active', 'ORTHODOXOS GEORGIOU', '', '99546565', '', '', 'kedoltd@cytanet.com.cy', NULL, '0000-00-00', '', 34072, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1372, 'Active', 'PANAGIOTIS PROKOPIOU', '', '+447403306823', '', '', 'panayiotis_procopiou@hotmail.com', NULL, '1989-07-21', '', 33816, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1373, 'Active', 'PERIKLEIA DIMITRIOU', '', '99654434', '', '', 'andreoutasoula@yahoo.com', NULL, '2006-04-10', '', 34254, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1374, 'Active', 'RENA KYRIAKIDES', '', '', '', '', 'renakyriakides@gmail.com', NULL, '1992-11-16', '', 33820, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1375, 'Active', 'MARIA KYRIAKIDES', '', '0035799320333', '', '', 'mariakyriakide16@hotmail.com', NULL, '1995-02-16', '', 33818, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1376, 'Active', 'LEONIDAS SOTERIOU', '', '24633176', '', '', 'drsoteriou@gmail.com', NULL, '1978-11-25', '', 34304, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1377, 'Active', 'ELEANA OTHONOS', '', '99537883', '', '', 'mariosotho@hotmail.com', NULL, '2011-07-04', '', 34314, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1378, 'Active', 'AIGLI TELOUDI', '', '0035799717740', '', '', 'aigli10@hotmail.com', NULL, '1998-09-08', '', 33817, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1379, 'Active', 'CHRISTOFOROS ZINONOS', '', '', '', '', 'christoforos_zinonos@hotmail.com', NULL, '1994-07-15', '', 33990, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1380, 'Active', 'PANAYIOTA HADJIGEORGIOU', '', '99178032', '', '', 'info@yiotatheo.com', NULL, '1993-07-21', '', 34727, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1381, 'Active', 'GEORGIA KYRIAKOU', '', '24534788', '', '', 'Gkyriakou@uclancyprus.ac.uk', NULL, '1980-09-11', '', 34280, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1382, 'Active', 'CHRISTOS MICHAILAS', '', '24534788', '', '', 'Gkyriakou@uclancyprus.ac.uk', NULL, '2007-08-04', '', 34281, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1383, 'Active', 'ELENA MARIA THEODOULOU', '', '', '', '', 'elenamariath@gmail.com', NULL, '1984-04-10', '', 35453, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1384, 'Active', 'KYRIAKOS DIMITRIOU', '', '99654434', '', '', 'andreoutasoula@yahoo.com', NULL, '2001-04-10', '', 34253, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1385, 'Active', 'ADONIS VASILIOU', '', '0039296432596', '', '', 'vasiliouy@gmail.com', NULL, '1994-04-25', '', 34252, '2020-01-05 13:24:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1386, 'Active', 'MARO MICHAEL', '', '', '', '', '', NULL, '1964-02-13', '', 33814, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1387, 'Active', 'ANTONIA HADJIANASTASIOU', '', '99454751', '', '', 'haugloose@cytanet.com.cy', NULL, '1983-01-03', '', 34900, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1388, 'Active', 'Pavlina  Theodoulou', '', '07712862483', '', '', 'pavlinatheodoulou@gmail.com', NULL, '1992-04-29', '4659436345439881 // 08/18 // Mrs S Millosia', 31831, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1389, 'Active', 'IRODOTOS MOUSIKOS', '', '99316271', '', '', 'sychronioikia@cytanet.com.cy', NULL, '1974-05-18', '', 34309, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1390, 'Active', 'PARASKEVI KARITTEVLI', '', '99599697', '', '', 'andreask@ambrosia.com.cy', NULL, '1963-04-15', '', 33916, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1391, 'Active', 'ALEXANDER ARZHAKOV', '', '', '', '', 'atri.techno@gmail.com', NULL, '1955-10-24', '', 33492, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1392, 'Active', 'SOFIA KYRIACOU', '', '0035799562537', '', '', '', NULL, '2015-07-01', '', 33392, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1393, 'Active', 'AKSANA ZHALAVA', '', '', '', '', 'oksana.gulida@gmail.com', NULL, '1982-08-24', '', 41213, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1394, 'Active', 'STAVROS LOUKAIDES', '', '99699900', '', '', '', NULL, '1946-06-15', '', 34998, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1395, 'Active', 'DIMITRIS DIMITRIOU', '', '99654434', '', '', 'andreoutasoula@yahoo.com', NULL, '1972-08-29', '', 34257, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1396, 'Active', 'GEORGIA CONSTANTINOU', '', '96329611', '', '', 'georgia.constantinou28@hotmail.com', NULL, '1996-06-28', '', 33909, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1397, 'Active', 'MARIA MATSANGIDOU', '', '0035799524396', '', '', 'matsangidou.m@gmail.com', NULL, '1990-03-29', '', 33994, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1398, 'Active', 'APHRODITE PAPACHRISTODOULOU', '', '', '', '', 'afroditipapa@live.com', NULL, '1992-08-21', '', 34361, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1399, 'Active', 'ANDREA HADJIPANAYI', '', '23811088', '', '', 'h-andr3a@hotmail.com', NULL, '1990-06-18', '', 33799, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1400, 'Active', 'IOULIA ANDREOU', '', '07845635497', '', '', 'juliandreou@hotmail.com', NULL, '1996-11-15', '', 33993, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1401, 'Active', 'MARIANNA MORGAN', '', '99633954', '', '', '', NULL, '0000-00-00', '', 35257, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1402, 'Active', 'MAROULA MAYER', '', '25747877', '', '', 'jomeyer@spidernet.com.cy', NULL, '1956-01-15', '', 34827, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1403, 'Active', 'RISHAT SPARIPOV', '', '420737442012', '', '', 'sparipov-richat@hotmail.com', NULL, '1970-12-14', '', 35224, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1404, 'Active', 'THANASIS ATHANASIOU', '', '25572200', '', '', 'a.n@avvapharma.com', NULL, '1976-03-04', '', 34918, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1405, 'Active', 'TASOULA DIMITRIOU', '', '99654434', '', '', 'andreoutasoula@yahoo.com', NULL, '1972-11-22', '', 34256, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1406, 'Active', 'IIYA BASHARIMOV', '', '', '', '', '', NULL, '2016-04-16', '', 40270, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1407, 'Active', 'VYACHESLAV BASHARIMOV', '', '96953115', '', '', 'basharimovvv@gmail.com', NULL, '1980-12-02', '', 40266, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1408, 'Active', 'OLGA BASHARIMOVA', '', '', '', '', '', NULL, '1984-04-03', '', 40267, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1409, 'Active', 'PAVEL BASHARIMOV', '', '', '', '', '', NULL, '2008-07-12', '', 40268, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1410, 'Active', 'TIMOTEY BASHARIMOV', '', '', '', '', '', NULL, '2013-08-30', '', 40269, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1411, 'Active', 'NETHANJIA MARC FOCKING', '', '99127296', '', '', '', NULL, '0000-00-00', '', 40844, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1412, 'Active', 'LUKAS RADER', '', '95743943', '', '', 'mail.raeder@gmail.com', NULL, '1990-02-17', '', 34735, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1413, 'Active', 'ADAM GREGOR BUTKIEWICZ', '', '004907253262', '', '', 'adamb@gmx.com', NULL, '0000-00-00', '', 40882, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1414, 'Active', 'STEFANIE SCHAEDEL', '', '4915120741420', '', '', 'stefanie.schaedel@gmx.net', NULL, '1981-03-23', '', 34312, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1415, 'Active', 'MANAL GEORGES ZAHAR', '', '24000300', '', '', '', NULL, '1976-01-14', '', 40307, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1416, 'Active', 'RIMA GEORGES ZAHAR', '', '', '', '', '', NULL, '1970-07-30', '', 40304, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1417, 'Active', 'HANNA BADIH SOUAID', '', '24000300', '', '', '', NULL, '1960-03-25', '', 40306, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1418, 'Active', 'MARC FOCKING', '', '', '', '', '', NULL, '0000-00-00', '', 41374, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1419, 'Active', 'STANISLAVA ZIEZDRYS', '', '99171718', '', '', 'anastasiukas@gmail.com', NULL, '1986-06-27', '', 40337, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1420, 'Active', 'SAU LIUS VIRSILAS', '', '', '', '', '', NULL, '1976-08-01', '', 40338, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1421, 'Active', 'EVA NIKITA VIRSILAITE', '', '', '', '', '', NULL, '2006-07-18', '', 40339, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1422, 'Active', 'CHRISTIAN VAN DER VEER', '', '96138974', '', '', 'tom@hellasboost.gr', NULL, '1969-03-19', '', 35247, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1423, 'Active', 'PETROV RETAR', '', '', '', '', '', NULL, '0000-00-00', '', 41105, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1424, 'Active', 'KARYNA PODDUYEVA', '', '', '', '', '', NULL, '1997-07-03', '', 40334, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1425, 'Active', 'MAY ZAHAR EP. HANNA SOUAID', '', '24000300', '', '', '', NULL, '0000-00-00', '', 40305, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1426, 'Active', 'JOSEPH  KAHI', '', '', '', '', '', NULL, '1962-01-18', '', 40527, '2020-01-05 13:24:40', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1427, 'Active', 'MARLEINE NASR EP JOSEPH KAHI ', '', '', '', '', '', NULL, '1966-06-13', '', 40526, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1428, 'Active', 'RAMONA SFIRLEA', '', '97733050', '', '', '', NULL, '1986-04-03', '', 40705, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1429, 'Active', 'Elisabeth Anna Naepflin', '', '97722031', '', '', 'elizarte52@live.com', NULL, '1952-11-16', '', 32055, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1430, 'Active', 'HANS ULRICH STAUBLI', '', '99675472', '', '', '', NULL, '1948-02-06', '', 35259, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1431, 'Active', 'ΑΘΑΝΑΣΙΟΣ ΣΑΡΡΗΣ', '', '99032135', '', '', '', NULL, '1973-11-05', '', 32061, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1432, 'Active', 'FABRIZIO DE IORIO', '', '99286175', '', '', 'fdi@europe.com', NULL, '1987-09-07', '', 35127, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1433, 'Active', 'AYA MOHAMED ABDELMONAM  SAYED AHMED', '', '99020177', '', '', '', NULL, '0000-00-00', '', 41156, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1434, 'Active', 'ΚΛΕΟΠΑΤΡΑ ΣΚΑΜΠΑΡΔΩΝΗ ', '', '99006838', '', '', '', NULL, '0000-00-00', '', 41075, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1435, 'Active', 'KONSTANTINOS BARMPOUNIS', '', '', '', '', '', NULL, '1982-03-03', '', 35243, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1436, 'Active', 'ΜΙΡΑΝΤΑ ΓΙΑΝΝΟΥΛΑΚΗ', '', '', '', '', '', NULL, '1974-01-11', '', 40401, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1437, 'Active', 'MARIOS OTHONOS', '', '99527019', '', '', 'mariosotho@hotmail.com', NULL, '1984-06-19', 'ADDRESS: 2 THISEOS STREET, 8011 PAPHOS', 34675, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1438, 'Active', 'SOTIRIS SOTIRIOU', '', '24633176', '', '', 'drsoteriou@gmail.com', NULL, '1947-02-09', '', 31931, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1439, 'Active', 'Chrystalleni Mylona', '', '99657273', '', '', 'chrystalleni.mylonas@yahoo.com', NULL, '1979-11-29', '', 32432, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1440, 'Active', 'LIANA HADJIANASTASIOU', '', '99454751', '', '', 'haugloose@cytanet.com.cy', NULL, '1985-03-25', '', 34901, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1441, 'Active', 'KYRIAKOS TSIORBATZUDIS', '', '97676039', '', '', 'tinapapaleontiou@gmail.com', NULL, '2009-11-14', '', 34888, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1442, 'Active', 'STAVROS LOUKAIDES', '', '', '', '', '', NULL, '1946-06-15', '', 35011, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1443, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ Λ. ΘΕΟΔΟΣΙΟΥ ', '', '24636883', '', '', '', NULL, '0000-00-00', '', 35039, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1444, 'Active', 'MAN HE', '', '', '', '', '', NULL, '0000-00-00', '', 40702, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1445, 'Active', 'ALEXANDROS PAPAGEORGIOU', '', '', '', '', '', NULL, '0000-00-00', '', 40793, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1446, 'Active', 'PANAGIOTA KLEOVOULOU', '', '', '', '', '', NULL, '0000-00-00', '', 40834, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1447, 'Active', 'RAISA BESLIU', '', '', '', '', '', NULL, '0000-00-00', '', 40792, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1448, 'Active', 'IOANNA KOUMARTZI', '', '', '', '', '', NULL, '0000-00-00', '', 40835, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1449, 'Active', 'SYLVIA PATRICIA HILL', '', '', '', '', '', NULL, '0000-00-00', '', 40879, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1450, 'Active', 'CHRISTINA VERYKOKIDI', '', '', '', '', '', NULL, '0000-00-00', '', 40832, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1451, 'Active', 'STEFAN POLYAKOV', '', '', '', '', '', NULL, '0000-00-00', '', 40836, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1452, 'Active', 'TIMOFEI KUKHLIVSKII', '', '', '', '', '', NULL, '0000-00-00', '', 40831, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1453, 'Active', 'MARIOS PAPAYIANNIS', '', '', '', '', '', NULL, '0000-00-00', '', 40833, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1454, 'Active', 'FILIPPOS ANTONIOU', '', '', '', '', '', NULL, '0000-00-00', '', 41034, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1455, 'Active', 'THAER ABDUL BARI', '', '', '', '', '', NULL, '0000-00-00', '', 41166, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1456, 'Active', 'IRENE CHYRVA', '', '', '', '', '', NULL, '0000-00-00', '', 41339, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1457, 'Active', 'OLGA RATIEVA', '', '', '', '', '', NULL, '0000-00-00', '', 41167, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1458, 'Active', 'ΓΙΩΡΓΟΣ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41185, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1459, 'Active', 'PETER ANDREWS', '', '', '', '', '', NULL, '1955-11-12', '', 41207, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1460, 'Active', 'MICHAEL BURRELL', '', '', '', '', '', NULL, '1953-09-22', '', 41206, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1461, 'Active', 'ELENI TZANNOU', '', '', '', '', '', NULL, '0000-00-00', '', 41217, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1462, 'Active', 'ALEXANDROS ARSIOTIS', '', '', '', '', '', NULL, '0000-00-00', '', 41246, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1463, 'Active', 'THEODOROS POLYVIOU', '', '', '', '', '', NULL, '0000-00-00', '', 41247, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1464, 'Active', 'MARIOS POLYVIOU', '', '', '', '', '', NULL, '0000-00-00', '', 41257, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1465, 'Active', 'PRAXOULA PAPADOPOULOU', '', '', '', '', '', NULL, '0000-00-00', '', 41282, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1466, 'Active', 'ΠΑΡΑΣΚΕΥΗ ΧΑΡΙΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41310, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1467, 'Active', 'ΝΕΟΚΛΗΣ ΧΑΡΙΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41309, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1468, 'Active', 'ΙΩΑΝΝΗΣ ΠΡΙΜΠΑΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41187, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1469, 'Active', 'Χριστάκης Χατζηγεωργίου', '', '', '', '', '', NULL, '0000-00-00', '', 33321, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1470, 'Active', 'Κώστας Ματθαίου', '', '', '', '', '', NULL, '0000-00-00', '', 33322, '2020-01-05 13:24:41', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1471, 'Active', 'ΛΕΩΝΙΔΑΣ  ΣΑΖΟΣ', '', '99451951', '', '', 'leonidassazos@gmail.com', NULL, '0000-00-00', '', 33342, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1472, 'Active', 'ΚΥΡΙΑΚΟΣ ΑΝΤΟΥΝΑΣ', '', '', '', '', '', NULL, '0000-00-00', '', 33343, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1473, 'Active', 'ΠΟΠΗ ΔΗΜΗΤΡΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 33344, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1474, 'Active', 'PAN LEON INSURANCE AGENTS & CONSULTANTS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33345, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1475, 'Active', 'A.K. ANDONIOU INSURANCE AGENTS, SUB-AGENTS AND CON', '', '', '', '', '', NULL, '0000-00-00', '', 33346, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1476, 'Active', 'ΣΠΥΡΟΣ ΠΑΠΑΣΠΥΡΟΠΟΥΛΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 33347, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1477, 'Active', 'V.P. PERFECT INSURANCE AGENTS & CONSULTANTS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33348, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1478, 'Active', 'PRIMOLINE INSURANCE AGENCY & CONSULTANTS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33349, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1479, 'Active', 'KEY PARTNERS GENERAL INSURANCE AGENTS & SUB-AGENTS', '', '', '', '', '', NULL, '0000-00-00', '', 33350, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1480, 'Active', 'CYNOSURE INSURANCE AGENCY & CONSULTANCY SERVICES (', '', '', '', '', '', NULL, '0000-00-00', '', 33351, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1481, 'Active', 'ΑΛΕΞΙΑ ΨΑΡΟΠΟΥΛΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 33352, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1482, 'Active', 'PHOTIADES & ANDREOU ACCOUNTANTS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 33353, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1483, 'Active', 'ΑΝΘΙΜΟΣ ΑΝΘΙΜΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 34721, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1484, 'Active', 'PRIMOLINE INSURANCE AGENCY & CONSULTANTS LTD ', '', '', '', '', '', NULL, '0000-00-00', '', 34722, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1485, 'Active', 'PA KALYPSIS insurance agents sub - agents & consul', '', '', '', '', '', NULL, '0000-00-00', '', 34723, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1486, 'Active', 'CHRYSO GAITANOU', '', '', '', '', '', NULL, '0000-00-00', '', 35064, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1487, 'Active', 'ΑΝΔΡΕΟΥ ΠΑΝΑΓΙΩΤΑ & ΑΝΤΡΕΟΥ ΣΑΒΒΑΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 41308, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1488, 'Active', 'ΧΡΥΣΟΒΑΛΑΝΤΩ ΚΟΣΜΑ', '', '', '', '', '', NULL, '0000-00-00', '', 41352, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1489, 'Active', 'ΑΝΔΡΕΑΣ ΑΝΔΡΕΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40780, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1490, 'Active', 'ELLI ATTARD', '', '', '', '', '', NULL, '0000-00-00', '', 40600, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1491, 'Active', 'ΟΙΚΟΝΟΜΑΚΟΣ ΜΙΧΑΗΛ & ΣΙΑ ΟΕ', '', '', '', '', '', NULL, '0000-00-00', '', 40946, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1492, 'Active', 'PRODROMOU & MAKRIYIANNIS ', '', '', '', '', '', NULL, '0000-00-00', '', 41000, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1493, 'Active', 'ΑΝΔΡΕΑΣ ΤΖΑΒΑΡΑΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41103, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1494, 'Active', 'ΠΑΜΠΟΣ ΣΤΑΜΑΤΑΡΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 41178, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1495, 'Active', 'ΣΤΑΥΡΟΣ ΑΓΑΠΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35765, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1496, 'Active', 'ΑΝΤΡΕΑΣ ΦΩΚΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40393, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1497, 'Active', 'ΓΙΩΡΓΟΣ ΚΥΠΡΟΥ', '', '99497224', '', '', '', NULL, '0000-00-00', '', 40893, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1498, 'Active', 'ΚΩΣΤΑΣ ΔΗΜΗΤΡΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41351, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1499, 'Active', 'ΣΩΤΗΡΗΣ ΝΙΚΟΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41174, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1500, 'Active', 'ΛΟΥΚΙΑ ΑΓΑΠΙΟΥ', '', '99770348', '', '', '', NULL, '0000-00-00', '', 41019, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1501, 'Active', 'ΜΙΧΑΛΗΣ ΧΑΤΖΗΜΙΧΑΗΛ', '', '', '', '', '', NULL, '0000-00-00', '', 41385, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1502, 'Active', 'ΝΙΚΗ ΑΝΔΡΕΟΥ & ΓΕΩΡΓΙΑ ΚΥΠΡΙΑΝΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 40906, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1503, 'Active', 'ΧΡΙΣΤΑΚΗΣ ΕΛΕΥΘΕΡΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40907, '2020-01-05 13:24:42', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1504, 'Active', 'ΜΥΡΙΑΝΘΗ ΜΕΝΕΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41095, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1505, 'Active', 'ΑΝΤΡΙΑ ΠΑΠΑΝΙΚΟΛΑΟΥ', '', '99328582', '', '', '', NULL, '0000-00-00', '', 40816, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1506, 'Active', 'ΑΝΔΡΕΟΥ ΑΝΔΡΕΑΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40903, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1507, 'Active', 'ΧΡΙΣΤΟΣ ΔΙΑΜΑΝΤΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40908, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1508, 'Active', ' ', '', '', '', '', '', NULL, '0000-00-00', '', 41101, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1509, 'Active', 'ΧΑΡΑ ΝΕΟΚΛΕΟΥΣ', '', '22313525', '', '', '', NULL, '0000-00-00', '', 40825, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1510, 'Active', 'Legacy Migration Company', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 20419, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1511, 'Active', 'Cigna', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28157, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1512, 'Active', 'Ydrogios', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28158, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1513, 'Active', 'Aetna', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28164, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1514, 'Active', 'Europesure', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28166, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1515, 'Active', 'AIG Insurance', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28167, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1516, 'Active', 'April', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28168, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1517, 'Active', 'Cosmos', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28171, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1518, 'Active', 'Trust', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28173, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1519, 'Active', 'IMG', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28175, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1520, 'Active', 'Eurorisk', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28176, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1521, 'Active', 'Unilife', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28177, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1522, 'Active', 'Allianz', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 28178, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1523, 'Active', 'AS User 1', '', '', '', '', '', NULL, '0000-00-00', '', 31471, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1524, 'Active', 'CABLENET', '', '', '', '', '', NULL, '0000-00-00', '', 31806, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1525, 'Active', 'MEDLIFE ALICO', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 32487, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1526, 'Active', 'INTERGLOBAL', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 32532, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1527, 'Active', 'Status Insurance/Europe Ltd', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 32533, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1528, 'Active', 'TITAN', '', '', '', '', '', NULL, '0000-00-00', '', 32549, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1529, 'Active', 'A.TH. PETROU', '', '', '', '', '', NULL, '0000-00-00', '', 32550, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1530, 'Active', 'DCare', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 34720, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1531, 'Active', 'KEMTER INSUANCE', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 35059, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1532, 'Active', 'RKH Speciality Limited', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 35624, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1533, 'Active', 'ASUA BUSINESS TRAVEL', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 35658, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1534, 'Active', 'Eurosure Insurance Company Ltd', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 40218, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1535, 'Active', 'CROMAR INSURANCE BROKERS LTD', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 40554, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1536, 'Active', 'ΚΑΡΑΒΙΑΣ ΜΕΣΙΤΕΣ & ΣΥΜΒΟΥΛΟΙ ΑΣΦΑΛΙΣΕΩΝ ΑΕ', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 40555, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1537, 'Active', 'ΕΘΝΙΚΗ ΑΣΦΑΛΙΣΤΙΚΗ', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 40819, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1538, 'Active', 'ΙΝΤERAMERICAN INSURANCE', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 40820, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1539, 'Active', 'SOEASY INSURANCE BROKERS LTD', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 40867, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1540, 'Active', 'PRICE FORBES', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 41306, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1541, 'Active', 'UNIVERSAL LIFE', '', '', '', '', '', NULL, '0000-00-00', 'INSCOMP', 41366, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1542, 'Active', 'LG INSURANCE', '', '', '', '', '', NULL, '0000-00-00', '', 40672, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1543, 'Active', 'ΟΙΚΟΝΟΜΑΚΟΣ ΜΙΧΑΗΛ & ΣΙΑ ΟΕ', '', '', '', '', '', NULL, '0000-00-00', '', 40956, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1544, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΜΑΜΟΠΟΥΛΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40966, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1545, 'Active', 'IMS INSURANCE BROKERS LP', '', '', '', '', '', NULL, '0000-00-00', '', 40740, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1546, 'Active', 'KEMTER INSURANCE AGENCIES SUB-AGENCIES &CONSULTANT', '', '', '', '', '', NULL, '0000-00-00', '', 40921, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1547, 'Active', 'ΔΙΑΧ.ΠΕΡΙΟΥΣΙΑΣ ΑΠΟΒΙΩΣΑΝΤΟΣ ΠΡΟΔΡΟΜΟΥ ΧΡΙΣΤΑΚΗ ', '', '99795948', '', '', '', NULL, '0000-00-00', '', 40894, '2020-01-05 13:27:20', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1548, 'Active', 'G.KAIMAKLIOTIS & Co LtD', '', '', '', '', '', NULL, '0000-00-00', '', 34368, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1549, 'Active', 'CYPRUS SYMPHONY ORCHESTRA FOUNDATION', '', '22463144', '', '', '', NULL, '0000-00-00', '', 40767, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1550, 'Active', 'ΔΗΜΗΤΡΗΣ ΧΑΤΖΗΜΙΤΣΗΣ', '', '99695257', '', '', 'car-graphics@cytanet.com.cy', NULL, '0000-00-00', '', 35206, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1551, 'Active', 'CHRISTOS NIKOLAOU', '', '', '', '', '', NULL, '0000-00-00', '', 35721, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1552, 'Active', 'Μ.ΜΟΔΕΣΤΟΥ', '', '99945721', '', '', '', NULL, '0000-00-00', '', 34966, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1553, 'Active', 'ΣΩΤΗΡΗΣ ΣΑΒΒΑ', '', '', '', '', '', NULL, '0000-00-00', '', 40938, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1554, 'Active', 'ΝΙΚΟΣ ΚΟΚΚΙΝΟΣ & ΣΑΒΒΑΣ ΣΙΗΚΚΗΣ', '', '97688782', '', '', '', NULL, '0000-00-00', '', 40405, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1555, 'Active', 'Michaels Automotive Ltd', '', '0035724664670', '', '', 'www.fordcyprus.com', NULL, '0000-00-00', '', 33395, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1556, 'Active', 'ΑΓΓΕΛΟΣ ΧΑΡΟΥΣ ΛΙΜΙΤΕΔ', '', '', '', '', '', NULL, '0000-00-00', '', 35747, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1557, 'Active', 'SAPO GIVEAWAYS PUBLIC LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35432, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1558, 'Active', 'GADE AC SERVICES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 34432, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1559, 'Active', 'A&N OFFICESERV BUSINESS SOLUTIONS LTD ', '', '22666700', '', '', 'info@officeserv.com.com.cy', NULL, '0000-00-00', '', 34329, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1560, 'Active', 'AZNET TRADING LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35502, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1561, 'Active', 'RΕMITONIA Co LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35596, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1562, 'Active', 'A.Y.K. Co Ltd', '', '22879525', '', '', 'aykhome@cytanet.com.cy', NULL, '0000-00-00', '', 35025, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1563, 'Active', 'PRINT STUDIO DESING & PRINTING SERVICES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 35680, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1564, 'Active', 'T.C. Multiklima engineering ltd ', '', '', '', '', '', NULL, '0000-00-00', '', 35258, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1565, 'Active', 'Lexact Solutions Ltd', '', '22003164', '', '', 'info@lexact.com.cy', NULL, '0000-00-00', '', 34812, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1566, 'Active', 'ACTION GLOBAL COMMUNICATIONS', '', '22818884', '', '', 'action@actiongroup.com', NULL, '0000-00-00', '', 34822, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1567, 'Active', 'ΑΝΤΩΝΗΣ & ΦΟΥΛΗΣ ΗΛΕΚΤΡΑΓΟΡΑ ', '', '', '', '', 'antonis.foulis@cytanet.com.cy', NULL, '0000-00-00', '', 35428, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1568, 'Active', 'ΑΡΧΗ ΗΛΕΚΤΡΙΣΜΟΥ ΚΥΠΡΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 35207, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1569, 'Active', 'EUROFREIGHT HELLAS M.EPE ', '', '', '', '', '', NULL, '0000-00-00', '', 40964, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1570, 'Active', 'PANAYIOTIDES & SONS LTD', '', '22518400', '', '', '', NULL, '0000-00-00', '', 41420, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1571, 'Active', 'APPLE ID', '', '', '', '', '', NULL, '0000-00-00', '', 33640, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1572, 'Active', 'ΑΝΔΡΕΑΣ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35157, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1573, 'Active', 'ΣΤΑΥΡΟΣ ΣΤΑΥΡΟΥ', '', '99414338', '', '', '', NULL, '0000-00-00', '', 35120, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1574, 'Active', 'ΕΙΡΗΝΗ ΓΕΩΡΓΙΑΔΟΥ', '', '99599469', '', '', '', NULL, '0000-00-00', '', 41002, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1575, 'Active', 'DIZZY FREEZY HAIRDRESSING SALON', '', '99687797', '', '', '', NULL, '0000-00-00', '', 41329, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1576, 'Active', 'E TH PRINTOUT DIGITAL PRINTING LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 40433, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1577, 'Active', 'STATUS INSURANCE AGENTS SUB AGENTS & CONSULTANTS C', '', '', '', '', '', NULL, '0000-00-00', '', 40613, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1578, 'Active', 'GADE AC SERVICES LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40507, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1579, 'Active', 'Vindex air fresh ltd', '', '', '', '', '', NULL, '0000-00-00', '', 40434, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1580, 'Active', 'A & N OFFICESERV BUSINESS SOLUTIONS LTD', '', '', '', '', 'info@oficeserv.com.cy', NULL, '0000-00-00', '', 35600, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1581, 'Active', 'RGB Desing & Publication Ltd ', '', '22451071', '', '', '', NULL, '0000-00-00', '', 40980, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1582, 'Active', 'TECVAULT LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40998, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1583, 'Active', 'TECVAULT LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40991, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1584, 'Active', 'D.SIZINOS & ASSOCIATES LLC', '', '24828333', '', '', 'info@sizinos.com', NULL, '0000-00-00', '', 34431, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1585, 'Active', 'Δ.ΠΑΡΤΟΥ % Ε.ΖΑΧΑΡΙΟΥ', '', '99688775', '', '', '', NULL, '0000-00-00', '', 40381, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1586, 'Active', 'YONG LI', '', '', '', '', '', NULL, '0000-00-00', '', 40701, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1587, 'Active', 'XUEMEI ZHANG', '', '', '', '', '', NULL, '0000-00-00', '', 40700, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1588, 'Active', 'JACK TIMOTHY LE HURAY ', '', '', '', '', '', NULL, '0000-00-00', '', 35093, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1589, 'Active', 'ΑΝΑΣΤΑΣΙΟΣ & ΜΑΡΙΑ ΑΦΡΙΚΑΝΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 40314, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1590, 'Active', 'ΜΑΝΟΛΙΤΟ ΓΕΩΡΓΙΑΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 35365, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1591, 'Active', 'ΔΗΜΗΤΡΑ ΚΑΛΟΓΗΡΟΥ ΜΗΝΑ & ΔΗΜΗΤΡΗΣ ΚΑΛΟΓΗΡΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 40316, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1592, 'Active', 'GEORGIOS TSITOURIS', '', '', '', '', 'gt@cubectrl.com', NULL, '1978-07-25', '', 35659, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1593, 'Active', 'ΜΑΡΙΟΣ ΠΑΠΑΓΙΑΝΝΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40923, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1594, 'Active', 'HUNJAN TEJINDER', '', '', '', '', '', NULL, '1956-08-30', '', 35212, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1595, 'Active', 'GEOFREY LIONEL & SYLVIA PATRICIA HILL ', '', '', '', '', '', NULL, '0000-00-00', '', 35733, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1596, 'Active', 'RISHAT SPARIPOV', '', '', '', '', '', NULL, '1970-12-14', '', 35222, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1597, 'Active', 'LEONIDAS ALIBERTIS', '', '00306944602848', '', '', 's_alimpertis@yahoo.gr', NULL, '1996-11-27', '', 40625, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1598, 'Active', 'Ανδρόνικος Ανδρονίκου & Μαρία Σουρμελή ', '', '', '', '', '', NULL, '0000-00-00', '', 40459, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1599, 'Active', 'ΓΙΩΡΓΟΣ ΠΑΝΑΓΙΩΤΟΥ', '', '99424734', '', '', '', NULL, '0000-00-00', '', 35369, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1600, 'Active', 'ΑΝΔΡΕΑΣ ΚΥΠΡΙΑΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40581, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1601, 'Active', 'NICOLAOS DIGRIDAKIS', '', '', '', '', '', NULL, '0000-00-00', '', 35087, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1602, 'Active', 'ΜΑΡΙΛΕΝΑ ΚΥΡΙΑΚΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35230, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1603, 'Active', 'GIORGOS ZANGOULOS ', '', '', '', '', '', NULL, '0000-00-00', '', 35089, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1604, 'Active', 'ELLADA PASPALI', '', '', '', '', '', NULL, '0000-00-00', '', 35088, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1605, 'Active', 'FOTINI & THRASYVOULOS GIANNOULAKI', '', '', '', '', '', NULL, '0000-00-00', '', 35086, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1606, 'Active', 'SIMON  GEORGIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35305, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1607, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΠΑΝΑΓΙΩΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40580, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1608, 'Active', 'ELENI ANDREA', '', '', '', '', '', NULL, '0000-00-00', '', 40669, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1609, 'Active', 'VERIKOKIDI CHRISTINA ', '', '', '', '', '', NULL, '0000-00-00', '', 40769, '2020-01-05 13:27:21', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1610, 'Active', 'GEORGHIOU AGATHOU', '', '', '', '', '', NULL, '0000-00-00', '', 35058, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1611, 'Active', 'CHRISTAKIS EFRAIM', '', '', '', '', '', NULL, '0000-00-00', '', 35005, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1612, 'Active', 'KATERINA KASSIANOU', '', '', '', '', '', NULL, '0000-00-00', '', 35135, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1613, 'Active', 'ANTONIA HADJIEFTYCHIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35136, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1614, 'Active', 'CHRISTIANA DEMETRIOU', '', '99896776', '', '', 'christianademet@gmail.com', NULL, '0000-00-00', '', 35137, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1615, 'Active', 'NICOLETTA NICOLAOU', '', '97778993', '', '', 'koulanic@hotmail.com', NULL, '0000-00-00', '', 35138, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1616, 'Active', 'MARIOS MYLONAS', '', '99586755', '', '', 'mzmylonas@gmail.com', NULL, '0000-00-00', '', 35139, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1617, 'Active', 'ROMAN SHAMOV', '', '', '', '', '', NULL, '0000-00-00', '', 40222, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1618, 'Active', 'SOTERIS IOANNOU', '', '', '', '', '', NULL, '0000-00-00', '', 40390, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1619, 'Active', 'YIASMIN ALASAAD SEHAM', '', '', '', '', '', NULL, '0000-00-00', '', 40417, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1620, 'Active', 'AGGELIKI SOTERIOU', '', '', '', '', '', NULL, '2019-01-03', '', 40827, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1621, 'Active', 'ΑΘΑΝΑΣΙΑ ΧΑΤΖΗΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40961, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1622, 'Active', 'ΜΑΡΙΑ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40579, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1623, 'Active', 'SOTERIS SOTERIOU', '', '', '', '', '', NULL, '0000-00-00', '', 34971, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1624, 'Active', 'PANTELIS ELIADES', '', '', '', '', '', NULL, '0000-00-00', '', 34972, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1625, 'Active', 'CHRYSO GAITANOU', '', '', '', '', '', NULL, '0000-00-00', '', 34995, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1626, 'Active', 'ANTIGONI  NICOLAOU AGENT,SUB AGENT & CONSULTANT LT', '', '', '', '', '', NULL, '0000-00-00', '', 35081, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1627, 'Active', 'ANDREAS SYMEOU', '', '', '', '', '', NULL, '0000-00-00', '', 35154, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1628, 'Active', 'EVA IVANOVA', '', '', '', '', '', NULL, '0000-00-00', '', 35211, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1629, 'Active', 'ΚΥΠΡΙΑΝΟΣ ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '', '', '', NULL, '0000-00-00', '', 35356, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1630, 'Active', 'MICHALIS MAVRIDES', '', '', '', '', '', NULL, '0000-00-00', '', 35454, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1631, 'Active', 'LEONIDAS THEODOSIOU', '', '', '', '', '', NULL, '0000-00-00', '', 35598, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1632, 'Active', 'GIANNOS STEPHANOU', '', '', '', '', '', NULL, '0000-00-00', '', 35703, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1633, 'Active', 'ANDREAS KOKKINIS & ELENI TOFARIDOU KOKKINI ', '', '', '', '', '', NULL, '0000-00-00', '', 35767, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1634, 'Active', 'ΔΙΑΧ.ΠΕΡΙΟΥΣΙΑΣ ΑΠΟΒΙΩΣΑΝΤΟΣ ΝΤΙΝΟΥ ΑΠΟΣΤΟΛΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 40952, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1635, 'Active', 'ΚΟΥΛΛΑ ΒΑΓΓΑ', '', '99030844', '', '', '', NULL, '0000-00-00', '', 40860, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1636, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΚΥΠΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 41422, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1637, 'Active', 'ΔΕΣΠΟΙΝΑ ΘΕΟΔΟΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 34922, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1638, 'Active', 'ΚΑΤΕΡΙΝΑ ΠΟΛΥΚΑΡΠΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 34923, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1639, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ & ΣΤΕΛΛΑ ΛΑΖΑΡΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 35768, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1640, 'Active', 'ΑΝΔΡΕΑΣ ΣΙΑΜΤΑΝΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 34931, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1641, 'Active', 'ΑΝΤΩΝΑΚΗΣ ΑΝΤΩΝΙΟΥ ', '', '', '', '', '', NULL, '0000-00-00', '', 34927, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1642, 'Active', 'ARSHAK MANASOR', '', '', '', '', '', NULL, '0000-00-00', '', 34928, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1643, 'Active', 'SVETLANA GEVORGYAN', '', '', '', '', '', NULL, '0000-00-00', '', 35451, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1644, 'Active', 'KRONOS EXPRESS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40190, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1645, 'Active', 'PASCAL EDUCATION', '', '', '', '', '', NULL, '0000-00-00', '', 35610, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1646, 'Active', 'ΧΡΙΣΤΙΑΝΑ ΧΡΙΣΤΟΔΟΥΛΙΔΟΥ ΚΑΙ ΧΡΗΣΤΟΣ ΧΑΡΑΛΑΜΠΟΥΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 40491, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1647, 'Active', 'ANTIGONI NICOLAOU INSURANCE AGENT,SUB-AGENT & CONS', '', '', '', '', '', NULL, '0000-00-00', '', 35070, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1648, 'Active', 'ΓΕΩΡΓΙΟΥ & ΚΟΥΛΕΝΔΡΟΣ ΑΣΦΑΛΙΣΤΙΚΗ ΕΤΑΙΡΕΙΑ ΠΡΑΚΤΟΡ', '', '', '', '', '', NULL, '0000-00-00', '', 35080, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1649, 'Active', 'TOP QUOTES', '', '', '', '', '', NULL, '0000-00-00', '', 35245, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1650, 'Active', 'YIANNAKIS TERNAS INSURANCE AGENCY LTD', '', '', '', '', 'george@tertasinsurance.com', NULL, '0000-00-00', '', 35323, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1651, 'Active', 'INSURANCE LINK ', '', '', '', '', '', NULL, '0000-00-00', '', 35509, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1652, 'Active', 'FRANTZIS INSURANCE', '', '', '', '', '', NULL, '0000-00-00', '', 40321, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1653, 'Active', 'ARMOU GOLF SOCIETY', '', '', '', '', '', NULL, '0000-00-00', '', 40414, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1654, 'Active', 'Panaidis Eyewear Boutique Ltd', '', '', '', '', '', NULL, '0000-00-00', '', 34974, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1655, 'Active', 'EDRINGTON MIDDLE EAST & AFRICA LIMITED', '', '', '', '', '', NULL, '0000-00-00', '', 34924, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1656, 'Active', 'P.E. Trades & Trading Ltd', '', '24400650', '', '', '', NULL, '0000-00-00', '', 34937, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1657, 'Active', 'KYROS TRADING LTD', '', '', '', '', '', NULL, '0000-00-00', '', 34976, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1658, 'Active', 'DIPLOMAT DISTRIBUTORS CYPRUS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40829, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1659, 'Active', 'AGORASTI PATRONIDOU', '', '', '', '', '', NULL, '0000-00-00', '', 41153, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1660, 'Active', 'ΓΙΑΝΝΟΥΛΑ ΠΑΠΑ', '', '', '', '', '', NULL, '0000-00-00', '', 35602, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1661, 'Active', 'ΖΑΧΑΡΙΑΣ ΠΑΠΑΔΗΜΗΤΡΙΟΥ & ΕΛΕΝΑ ΟΙΚΟΝΟΜΙΔΟΥ', '', '99812490', '', '', '', NULL, '0000-00-00', '', 31488, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1662, 'Active', 'ΓΙΩΡΓΟΣ ΟΡΘΟΔΟΞΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 34990, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1663, 'Active', 'ΗΛΙΑΣ ΑΝΤΩΝΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 34991, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1664, 'Active', 'ΧΡΙΣΤΟΣ ΚΥΡΙΑΚΙΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 34996, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1665, 'Active', 'ΠΑΡΑΣΚΕΥΗ ΤΖΙΩΡΤΖΗ', '', '', '', '', '', NULL, '0000-00-00', '', 35231, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1666, 'Active', 'ΜΟΥΣΚΗΣ ΧΡΗΣΤΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 35078, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1667, 'Active', 'ΘΕΟΦΙΛΟΣ ΚΥΠΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35071, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1668, 'Active', 'BICHUK BOHDAN', '', '', '', '', '', NULL, '0000-00-00', '', 35077, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1669, 'Active', 'ΧΡΙΣΤΙΝΑ ΜΑΚΡΟΜΑΛΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 34904, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1670, 'Active', 'ΔΗΜΗΤΡΑ ΑΡΤΕΜΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 34903, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1671, 'Active', 'ΛΟΥΚΑ ΑΝΤΡΗ', '', '', '', '', '', NULL, '0000-00-00', '', 34906, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1672, 'Active', 'ΝΙΚΟΣ ΓΙΑΚΟΥΜΗ', '', '', '', '', '', NULL, '0000-00-00', '', 41144, '2020-01-05 13:27:22', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1673, 'Active', 'ΕΛΕΝΗ ΘΕΟΔΩΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40787, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1674, 'Active', 'LASZLO SOLTEZ', '', '', '', '', '', NULL, '0000-00-00', '', 35232, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1675, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΠΙΡΙΛΛΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 35234, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1676, 'Active', 'RADU IOAN VEZOC', '', '', '', '', '', NULL, '0000-00-00', '', 35072, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1677, 'Active', 'SANDHU GURCHETTAN', '', '', '', '', '', NULL, '0000-00-00', '', 35233, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1678, 'Active', 'ΚΑΚΙΑ ΜΑΡΤΕΖΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35236, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1679, 'Active', 'PETKO GEORGIEV', '', '', '', '', '', NULL, '0000-00-00', '', 35218, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1680, 'Active', 'ΑΝΔΡΕΑΣ ΠΑΝΑΓΙΩΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35435, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1681, 'Active', 'PETROVA KATYA VALKOVA', '', '', '', '', '', NULL, '0000-00-00', '', 35501, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1682, 'Active', 'MILEN ASENOV MINCEV', '', '', '', '', '', NULL, '0000-00-00', '', 35500, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1683, 'Active', 'ΛΕΥΤΕΡΗΣ ΜΗΛΙΩΤΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 35601, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1684, 'Active', 'ΓΕΩΡΓΙΟΣ ΦΙΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 35764, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1685, 'Active', 'ΧΡΙΣΤΙΝΑ ΠΑΝΑΓΗ', '', '', '', '', '', NULL, '0000-00-00', '', 39631, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1686, 'Active', 'ΧΡΥΣΩ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40182, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1687, 'Active', 'ΑΝΔΡΕΑΣ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40656, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1688, 'Active', 'ΣΤΕΦΑΝΗ ΡΟΥΣΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40655, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1689, 'Active', 'ΚΥΡΙΑΚΟΣ ΚΑΛΟΥΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40653, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1690, 'Active', 'ΓΙΑΝΝΟΥΛΑ ΑΓΑΠΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40654, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1691, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΙΩΑΝΝΙΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40670, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1692, 'Active', 'ΖΑΧΑΡΙΑΣ ΚΙΤΣΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40791, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1693, 'Active', 'ΧΡΙΣΤΟΣ ΜΑΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40786, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1694, 'Active', 'ΧΡΙΣΤΟΣ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40788, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1695, 'Active', 'ΓΙΩΡΓΟΣ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40789, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1696, 'Active', 'ΚΥΡΙΑΚΗ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40790, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1697, 'Active', 'ΜΙΧΑΗΛ ΡΑΦΑΗΛ', '', '', '', '', '', NULL, '0000-00-00', '', 40782, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1698, 'Active', 'ΧΡΙΣΤΟΔΟΥΛΟΣ ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40783, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1699, 'Active', 'ΚΥΡΙΑΚΟΣ ΑΓΓΕΛΗ', '', '', '', '', '', NULL, '0000-00-00', '', 40837, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1700, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40838, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1701, 'Active', 'ΝΙΚΟΣ ΝΙΚΟΛΑΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35213, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1702, 'Active', 'ΕΥΑΝΘΙΑ ΓΕΩΡΓΟΥΔΗ ΧΑΤΖΗΜΑΡΚΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35226, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1703, 'Active', 'ΚΩΣΤΑΣ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35146, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1704, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΕΩΡΓΟΥΔΗΣ', '', '99654295', '', '', '', NULL, '0000-00-00', '', 35132, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1705, 'Active', 'VALENTINA ZLATINOVA', '', '', '', '', '', NULL, '0000-00-00', '', 35214, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1706, 'Active', 'TSONEV MILEN PETROV', '', '', '', '', '', NULL, '0000-00-00', '', 35221, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1707, 'Active', 'ΖΑΦΕΙΡΩ ΦΙΛΙΠΠΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 35745, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1708, 'Active', 'ΕΛΕΝΗ ΙΑΚΩΒΟΥ', '', '99776425', '', '', '', NULL, '0000-00-00', '', 40842, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1709, 'Active', 'ΣΑΒΒΑΣ ΑΝΔΡΕΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40841, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1710, 'Active', 'ΑΝΤΡΙΕΝ Χ`ΑΛΕΞΑΝΔΡΟΥ', '', '', '', '', '', NULL, '1987-02-19', '', 40750, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1711, 'Active', 'ΔΙΑΓΡΑΦΗ ΣΚΟΥΡΟΥΜΟΥΝΗ', '', '', '', '', '', NULL, '0000-00-00', '', 39975, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1712, 'Active', 'διαγραφι ΓΙΑΝΝΑΚΗΣ ', '', '', '', '', '', NULL, '0000-00-00', '', 40081, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1713, 'Active', 'COSMARI PRINTERS LTD', '', '', '99617419', '', '', NULL, '0000-00-00', '', 39674, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1714, 'Active', 'SIMBA MOTORS LTD', '', '', '99624719', '', '', NULL, '0000-00-00', '', 40077, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1715, 'Active', 'ΔΙΑΓΡΑΦΗ ΙΩΑΝΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40010, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1716, 'Active', 'ΣΤΥΛΙΑΝΗ  ΑΔΩΝΗ', '', '', '99201766', '', '', NULL, '0000-00-00', '', 40014, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1717, 'Active', 'DRESCA GHEORGHE BOGDAN', '', '', '99043554', '', '', NULL, '0000-00-00', '', 40053, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1718, 'Active', 'ΑΓΓΕΛΟΣ ΧΑΡΟΥΣ ΛΤΔ', '', '', '24813116 99665367', '24813115', '', NULL, '0000-00-00', '', 39894, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1719, 'Active', 'WELLCARE LTD', '', '', '', '24821481', '', NULL, '0000-00-00', '', 39792, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1720, 'Active', 'GIALLETTO LTD', '', '', '', '24252000', 'www.prognosisniri.com', NULL, '0000-00-00', '', 39956, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1721, 'Active', 'diagrafi', '', '', '24620263', '', '', NULL, '0000-00-00', '', 39991, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1722, 'Active', 'ΣΤΑΥΡΟΣ& ΦΙΛΙΠΠΟΣ ΜΕΤΑΛΛΙΚΕΣ ΚΑΤΑΣΚΕΥΕΣ ΛΤΔ', '', '', '24531166', '', '', NULL, '0000-00-00', '', 39969, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1723, 'Active', 'ΛΟΙΖΟΣ ΧΑΡΟΥΣ', '', '', '99787661', '', '', NULL, '0000-00-00', '', 39818, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1724, 'Active', 'ΡΟΠΕΡΤ ΚΕΝ ΣΤΑΥΡΟΥ', '', '', '99617419', '', '', NULL, '0000-00-00', '', 39869, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1725, 'Active', 'ΠΑΝΙΚΟΣ ΣΤΑΥΡΙΑΝΟΣ', '', '', '99207222', '', '', NULL, '0000-00-00', '', 40067, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1726, 'Active', 'ΑΓΓΕΛΟΣ ΧΑΡΟΥΣ', '', '', '99665367', '', '', NULL, '0000-00-00', '', 39817, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1727, 'Active', 'ΑΝΔΡΕΑΣ  ΜΑΚΡΟΜΑΛΛΗΣ', '', '', '99142186', '', '', NULL, '0000-00-00', '', 40097, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1728, 'Active', 'THEONI KOUPEPIA', '', '', '99648348/99654411', '24663900', '', NULL, '0000-00-00', '', 40132, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1729, 'Active', 'διαγραφη ΑΓΓΕΛΑ  ΒΑ', '', '', '', '', '', NULL, '0000-00-00', '', 39994, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1730, 'Active', 'MAKSIM KOROTAYEV', '', '', '99341058', '', '', NULL, '0000-00-00', '', 40028, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1731, 'Active', 'διαγραφη  ΜΙΣΟΣ', '', '', '99510080', '', '', NULL, '0000-00-00', '', 40032, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1732, 'Active', 'EYTYXIA ΑΡΓΥΡΙΔΟΥ ΧΑΛΙΟΥ', '', '', '99627955', '', '', NULL, '0000-00-00', '', 39989, '2020-01-05 13:27:23', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1733, 'Active', 'STEVEN DAVID SMITH', '', '', '99047763', '', '', NULL, '0000-00-00', '', 40019, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1734, 'Active', 'E.K.ΤΟ ΓΛΕΝΤΙ ΤΩΝ ΓΕΥΣΕΩΝ', '', '', '99432676', '', '', NULL, '0000-00-00', '', 40105, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1735, 'Active', 'ΣΤΑΥΡΟΣ ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '99627174', '', '', NULL, '0000-00-00', '', 39967, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1736, 'Active', 'ΑΧΙΛΛΕΑΣ  ΕΛΕΥΘΕΡΙΟΥ', '', '', '99308902', '', '', NULL, '0000-00-00', '', 40116, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1737, 'Active', 'ΜΑΡΙΑ ΑΧΑΙΟΥ', '', '', '24822623 99210230', '', '', NULL, '0000-00-00', '', 39913, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1738, 'Active', 'ΣΟΦΙΑ ΣΟΥΡΗ', '', '', '99688478', '', '', NULL, '0000-00-00', '', 39813, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1739, 'Active', 'ΔΙΑΓΡΑΦΗ ΧΡΙΣΤΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 39717, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1740, 'Active', 'KYRIACOS ANGELI', '', '', '99787496', '', '', NULL, '0000-00-00', '', 39905, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1741, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΑΝΑΣΤΑΣΙΟΥ', '', '', '99634312', '', '', NULL, '0000-00-00', '', 39855, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1742, 'Active', 'ANNA ELIA', '', '', '99629543', '', '', NULL, '0000-00-00', '', 40129, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1743, 'Active', 'ELIAS KAMBOURIS', '', '', '99682908', '', 'elias.kambouris@hotmail.com', NULL, '0000-00-00', '', 40131, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1744, 'Active', 'GADE ACCOUNTING SERVICES LTD', '', '', '99412145', '', 'gadeserv@cytanet.com.cy', NULL, '0000-00-00', '', 39963, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1745, 'Active', 'ANDREAS ROUSOUNIDES', '', '', '22661064 99609598', '', 'rousounides@cytanet.com.cy', NULL, '0000-00-00', '', 40063, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1746, 'Active', 'ΛΟΥΚΙΑ ΚΑΡΙΤΤΕΒΛΗ', '', '', '99688840', '', '', NULL, '0000-00-00', '', 39945, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1747, 'Active', 'ΔΙΑΓΡΑΦΙ ΣΤΕΦΑΝ', '', '', '', '', '', NULL, '0000-00-00', '', 39999, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1748, 'Active', 'DIAGRFI SAVVIDE', '', '', '', '24626826', '', NULL, '0000-00-00', '', 39942, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1749, 'Active', 'ΕΙΡΗΝΗ ΚΑΓΙΑ', '', '', '99531844', '', '', NULL, '0000-00-00', '', 39667, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1750, 'Active', 'ΛΟΥΚΑΣ ΧΑΡΟΥΣ', '', '', '99746750', '', '', NULL, '0000-00-00', '', 39819, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1751, 'Active', 'EDWARD HADJIHANNAS', '', '', '99484480', '22512373', 'e.hadjihannas@areterio.com', NULL, '0000-00-00', '', 40130, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1752, 'Active', 'ΓΙΩΡΓΟΣ ΧΑΤΖΗΣΤΑΣΗ', '', '', '99204014', '', '', NULL, '0000-00-00', '', 39694, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1753, 'Active', 'ΔΙΑΓΡΑΦ', '', '', '99432676', '', '', NULL, '0000-00-00', '', 39854, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1754, 'Active', 'ΘΕΟΔΩΡΟΣ ΚΥΡΙΑΚΟΥ & ΥΙΟΙ ΛΤΔ', '', '', '', '', '', NULL, '0000-00-00', '', 40100, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1755, 'Active', 'A.K.DEMETRIOU (INSURANCE AGENTS & CONSULTANTS)LTD', '', '', '', '24822623', 'info@akdemetriou.com', NULL, '0000-00-00', '', 39960, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1756, 'Active', 'JOANNA GAUDET', '', '', '', '', '', NULL, '0000-00-00', '', 39928, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1757, 'Active', 'ΓΕΩΡΓΙΟΣ ΠΑΠΑΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '24638147 99648330', '', 'george.papa@eurofreight.com', NULL, '0000-00-00', '', 39990, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1758, 'Active', 'ΠΑΡΑΣΚΕΥΑΣ ΗΛΙΑ', '', '', '99473247', '', '', NULL, '0000-00-00', '', 40041, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1759, 'Active', 'ΕΛΕΝΗ ΘΕΟΔΟΥΛΟΥ', '', '', '99596376 Κώστας 99594734', '', '', NULL, '0000-00-00', '', 39957, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1760, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΑΧΑΙΟΥ', '', '', '99594402 99218901', '', '', NULL, '0000-00-00', '', 39968, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1761, 'Active', 'ΔΙΑΓΡΑΦΗ  ΙΑΚΩΒΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39984, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1762, 'Active', 'ΜΑΡΙΑ ΚΑΡΙΤΤΕΒΛΗ ΔΗΜΗΤΡΙΟΥ', '', '', '24530034 99533184', '', '', NULL, '0000-00-00', '', 39828, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1763, 'Active', 'ΑΝΤΩΝΗΣ ΝΙΚΟΛΑΟΥ', '', '', '00441623511257 99180765', '', '', NULL, '0000-00-00', '', 40005, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1764, 'Active', 'ΑΝΔΡΕΑΣ ΝΕΟΚΛΕΟΥΣ', '', '', '22201642 99666667', '', '', NULL, '0000-00-00', '', 39976, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1765, 'Active', 'ΜΑΡΙΑ ΣΤΑΥΡΟΥ', '', '', '99523564', '', '', NULL, '0000-00-00', '', 40027, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1766, 'Active', 'ST.RAPHAEL RADIOLOGY DEPARTMENT LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40122, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1767, 'Active', 'DIAGRAFI HOSPITAL', '', '', '', '', '', NULL, '0000-00-00', '', 40120, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1768, 'Active', 'LEONIDAS SOTERIOU', '', '', '99659177', '', '', NULL, '0000-00-00', '', 39961, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1769, 'Active', 'CONSTANTINOS NICOLAIDES', '', '', '99676161', '', '', NULL, '0000-00-00', '', 40136, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1770, 'Active', 'ΣΥΝΕΣΕΙΟ ΦΑΡΜΑΚΕΙΟ', '', '', '99800210', '24254008', '', NULL, '0000-00-00', '', 39965, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1771, 'Active', 'ΜΙΧΑΛΗΣ ΠΑΠΑΓΡΗΓΟΡΙΟΥ', '', '', '24530653 99688786', '', '', NULL, '0000-00-00', '', 39762, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1772, 'Active', 'ΕΥΦΡΟΣΥΝΗ ΔΗΜΗΤΡΙΟΥ', '', '', '24631540', '', '', NULL, '0000-00-00', '', 39643, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1773, 'Active', 'ΛΕΩΝΙΔΑΣ ΛΕΩΝΙΔΟΥ', '', '', '24847170', '', '', NULL, '0000-00-00', '', 39941, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1774, 'Active', 'ΜΙΧΑΛΗΣ Α. ΓΕΡΜΑΝΟΣ & ΥΙΟΙ ΛΤΔ', '', '', '99669300', '', '', NULL, '0000-00-00', '', 39958, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1775, 'Active', 'ΣΥΜΕΩΝ  ΑΝΤΩΝΙΟΥ', '', '', '24631828', '', '', NULL, '0000-00-00', '', 40091, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1776, 'Active', 'ΜΑΡΙΑ ΛΟΙΖΟΥ', '', '', '24847000 99338359', '', '', NULL, '0000-00-00', '', 39971, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1777, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΝΑΚΟΥ', '', '', '99654920', '', '', NULL, '0000-00-00', '', 39972, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1778, 'Active', 'ΑΝΤΡΟΥΛΛΑ  ΓΕΩΡΓΙΟΥ', '', '', '24433493 99402858', '', '', NULL, '0000-00-00', '', 39973, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1779, 'Active', 'ΑΙΚΑΤΕΡΙΝΗ ΠΑΤΣΑΛΟΥ', '', '', '24659153 99315995', '', '', NULL, '0000-00-00', '', 40087, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1780, 'Active', 'ΜΑΡΚΟΣ ΜΑΡΚΟΥ', '', '', '99305778', '', '', NULL, '0000-00-00', '', 40066, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1781, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΛΥΚΗΣ', '', '', '24627691 99648745', '', '', NULL, '0000-00-00', '', 40006, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1782, 'Active', 'ΜΑΡΙΑ ΣΙΑΚΑΛΛΗ', '', '', '24653774 97903976', '', '', NULL, '0000-00-00', '', 40015, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1783, 'Active', 'ΑΝΔΡΕΑΣ  ΚΥΡΙΑΚΟΥ', '', '', '24533373', '', '', NULL, '0000-00-00', '', 40016, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1784, 'Active', 'ΘΕΟΔΩΡΟΣ ΚΥΡΙΑΚΟΥ', '', '', '24533373', '', '', NULL, '0000-00-00', '', 40017, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1785, 'Active', 'ΧΡΙΣΤΟΣ ΚΥΡΙΑΚΟΥ', '', '', '24533373', '', '', NULL, '0000-00-00', '', 40022, '2020-01-05 13:27:24', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1786, 'Active', 'ΜΑΡΙΑ ΚΥΡΙΑΚΟΥ', '', '', '99434712', '', '', NULL, '0000-00-00', '', 39712, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1787, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ  ΑΝΤΩΝΙΟΥ', '', '', '96303810', '', '', NULL, '0000-00-00', '', 40025, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1788, 'Active', 'ΕΥΑΝΘΙΑ ΠΕΡΟΥ', '', '', '24532965', '', '', NULL, '0000-00-00', '', 39760, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1789, 'Active', 'ΘΕΟΔΩΡΟΣ ΚΥΡΙΑΚΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40026, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1790, 'Active', 'ΜΙΧΑΗΛ ΘΕΟΔΩΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40029, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1791, 'Active', 'ΝΙΚΟΛΑΣ  ΓΕΩΡΓΙΟΥ  ΑΔΩΝΗΣ', '', '', '99516624', '', '', NULL, '0000-00-00', '', 40102, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1792, 'Active', 'H. & K. UNITED CONCRETE CO. LTD', '', '', '24530961 99695734', '24530917', '', NULL, '0000-00-00', '', 40098, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1793, 'Active', 'ΔΗΜΗΤΡΑΚΗΣ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '24533373', '', '', NULL, '0000-00-00', '', 40099, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1794, 'Active', 'ΦΑΡΜΑ ΑΔΕΛΦΩΝ ΘΕΟΔΩΡΟΥ ΚΥΡΙΑΚΟΥ ΛΤΔ', '', '', '', '', '', NULL, '0000-00-00', '', 40055, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1795, 'Active', 'ΜΗΝΑΣ ΘΕΟΔΩΡΟΥ & ΧΡΙΣΤΟΣ ΚΥΡΙΑΚΟΥ & ΠΑΝΤΕΛΗΣ ΚΥΡΙΑ', '', '', '', '', '', NULL, '0000-00-00', '', 40101, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1796, 'Active', 'ΜΗΝΑΣ ΘΕΟΔΩΡΟΥ ΚΥΡΙΑΚΟΥ', '', '', '24533373 99434712', '', '', NULL, '0000-00-00', '', 40114, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1797, 'Active', 'ANZELIKA NIKIFORIDOU', '', '', '99314594', '', '', NULL, '0000-00-00', '', 40148, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1798, 'Active', 'CHRYSTALLA ARGYRIDOU', '', '', '99629561', '', '', NULL, '0000-00-00', '', 40137, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1799, 'Active', 'STYLIANOS KOKKIS', '', '', '99219833', '24252000', 'stkokkis@hotmail.com', NULL, '0000-00-00', '', 40044, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1800, 'Active', 'TRADOMATICS HOLDINGS LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40127, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1801, 'Active', 'ΔΗΜΗΤΡΗΣ ΣΤΑΥΡΟΥ', '', '', '99579737', '', 'drstavrou@cyplastsurg.com', NULL, '0000-00-00', '', 39730, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1802, 'Active', 'ΚΥΡΙΑΚΟΥΛΛΑ ΑΡΙΣΤΟΔΗΜΟΥ', '', '', '99609598', '', '', NULL, '0000-00-00', '', 39832, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1803, 'Active', 'BRANKA PETROVIC KYRIAKIDE', '', '', '25377033 99627747', '', '', NULL, '0000-00-00', '', 39820, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1804, 'Active', 'ΚΑΤΕΡΙΝΑ  ΞΥΣΤΟΥΡΗ', '', '', '99499626', '', '', NULL, '0000-00-00', '', 39895, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1805, 'Active', 'ΧΡΥΣΑΝΘΗ ΘΕΟΧΑΡΙΔΗ', '', '', '99448134', '', '', NULL, '0000-00-00', '', 39896, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1806, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΠΑΓΕΩΡΓΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39897, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1807, 'Active', 'THEO. TH.THEOCHARIDES LIMITED', '', '', '99429544', '', '', NULL, '0000-00-00', '', 39798, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1808, 'Active', 'diagrafh iliada', '', '', '', '', 'dr_evripidou_iliada@hotmail.com', NULL, '0000-00-00', '', 40140, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1809, 'Active', 'ΔΗΜΗΤΡΗΣ ΚΑΛΟΓΗΡΟΥ', '', '', '99424303', '', '', NULL, '0000-00-00', '', 39850, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1810, 'Active', 'ΚΑΤΕΡΙΝΑ ΕΥΘΥΜΙΟΥ', '', '', '99688775/99449935', '', '', NULL, '0000-00-00', '', 39959, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1811, 'Active', 'ΙΩΑΝΝΗΣ ΔΡΑΚΟΣ', '', '', '99205484', '', '', NULL, '0000-00-00', '', 39974, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1812, 'Active', 'JOTRON CONSULTING LTD', '', '', '99176621', '', '', NULL, '0000-00-00', '', 40036, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1813, 'Active', 'ΚΩΣΤΑΣ ΑΓΓΕΛΗ', '', '', '99787496', '', '', NULL, '0000-00-00', '', 39977, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1814, 'Active', 'ΣΩΤΗΡΟΥΛΛΑ ΦΡΑΓΚΟΥΛΗ', '', '', '24360357 99676077', '', '', NULL, '0000-00-00', '', 40002, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1815, 'Active', 'MEGHARI MARCEL', '', '', '99916973', '', '', NULL, '0000-00-00', '', 40007, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1816, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ  ΝΙΚΟΛΑΙΔΗΣ', '', '', '24652042 99362085', '', '', NULL, '0000-00-00', '', 39723, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1817, 'Active', 'ΜΑΡΙΑ ΣΥΜΕΟΥ', '', '', '24742970', '', '', NULL, '0000-00-00', '', 40013, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1818, 'Active', 'DIAGRAFI FROSA', '', '', '', '', '', NULL, '0000-00-00', '', 40030, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1819, 'Active', 'ΧΡΥΣΤΑΛΛΑ ΣΤΑΜΠΟΛΗ', '', '', '99665472', '', '', NULL, '0000-00-00', '', 40031, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1820, 'Active', 'ΑΝΔΡΕΑΣ ΣΤΑΜΠΟΛΗΣ', '', '', '24815544 99665472', '', '', NULL, '0000-00-00', '', 40119, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1821, 'Active', 'DIAGRAFI  LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40123, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1822, 'Active', 'IOANNIS KALOUDIS', '', '', '24669091 99466162', '24669093', '', NULL, '0000-00-00', '', 40133, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1823, 'Active', 'ΑΝΔΡΕΑΣ ΘΕΟΧΑΡΙΔΗΣ', '', '', '24652098 99429544', '', '', NULL, '0000-00-00', '', 39930, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1824, 'Active', 'ΓΙΩΡΓΟΣ  ΜΑΚΡΟΜΑΛΛΗΣ', '', '', '99676077', '', '', NULL, '0000-00-00', '', 39793, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1825, 'Active', 'ΑΓΓΕΛΙΚΗ ΚΑΡΑΤΖΙΑ', '', '', '99447691', '', '', NULL, '0000-00-00', '', 40115, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1826, 'Active', 'TIMOTHEOS TIMOTHEOU', '', '', '99630779', '', 'dr.timotheou@cytanet.com.cy', NULL, '0000-00-00', '', 40143, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1827, 'Active', 'diagrafi yiasoum', '', '', '96300500', '', 'elena@yiasoumi.eu', NULL, '0000-00-00', '', 40038, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1828, 'Active', 'ΠΑΝΑΓΙΩΤΑ  ΜΙΧΑΗΛ', '', '', '24634690', '', '', NULL, '0000-00-00', '', 39826, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1829, 'Active', 'ΣΤΕΛΙΟΣ ΣΤΥΛΙΑΝΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39821, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1830, 'Active', 'PARIS CHRISTOU', '', '', '97877370', '', '', NULL, '0000-00-00', '', 39919, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1831, 'Active', 'ΑΝΤΩΝΗΣ ΚΥΡΙΑΚΙΔΗΣ', '', '', '25705600', '', '', NULL, '0000-00-00', '', 39822, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1832, 'Active', 'ΛΟΪΖΟΣ ΧΑΤΖΗΛΟΪΖΟΥ', '', '', '99473347', '', '', NULL, '0000-00-00', '', 39851, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1833, 'Active', 'ΓΙΩΡΓΟΣ  ΚΟΥΜΑ', '', '', 'ΑΝΤΡΙΑΝΑ 99581804 9965504', '', '', NULL, '0000-00-00', '', 39852, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1834, 'Active', 'ΓΕΩΡΓΙΟΣ ΜΑΥΡΟΒΕΛΗΣ', '', '', '99499780', '', '', NULL, '0000-00-00', '', 39853, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1835, 'Active', 'ΜΑΡΙΝΟΣ ΙΟΥΛΙΑΝΟΥ', '', '', '99312290', '', '', NULL, '0000-00-00', '', 39718, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1836, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΑΝΤΡΕΟΥ', '', '', '24813420 99338765', '', '', NULL, '0000-00-00', '', 39898, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1837, 'Active', 'ΙΩΑΝΝΗΣ ΙΩΑΝΝΟΥ', '', '', '99448880', '', '', NULL, '0000-00-00', '', 39906, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1838, 'Active', 'ΗΛΙΑΣ ΚΩΝΣΤΑΝΤΙΝΟΥ', '', '', '99646236', '', '', NULL, '0000-00-00', '', 39907, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1839, 'Active', 'ΑΝΔΡΙΑΝΗ ΕΥΡΙΠΙΔΟΥ ΝΤΙΝΤΙΤΣΕΓΚΟ', '', '', '99511690', '', 'andri.evripidou@cytanet.com.cy', NULL, '0000-00-00', '', 39908, '2020-01-05 13:27:25', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1840, 'Active', 'IVI GEORGIOU NICOLAIDE', '', '', '99695002', '24813801', 'ivigeorgiou@cytanet.com.cy', NULL, '0000-00-00', '', 40144, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1841, 'Active', 'SUNSET GARDENS OWNERS COMMITTEE', '', '', '24929210 99172413', '', 'lespennington@yahoo.com', NULL, '0000-00-00', '', 39927, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1842, 'Active', 'CHRISTINA NEGUS', '', '', '99475669', '', '', NULL, '0000-00-00', '', 39940, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1843, 'Active', 'ΜΕΛΙΝΑ ΚΑΦΑΤΑΡΗ & ΜΑΡΚΟΣ ΜΑΡΚΟΥ', '', '', '99775888', '', '', NULL, '0000-00-00', '', 39933, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1844, 'Active', 'ΓΙΑΝΝΟΣ & ΔΩΡΑ ΠΙΚΗ', '', '', '23828082', '', '', NULL, '0000-00-00', '', 39948, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1845, 'Active', 'ΣΤΥΛΙΑΝΟΣ  ΜΑΡΚΟΥ', '', '', '99337097', '', '', NULL, '0000-00-00', '', 39937, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1846, 'Active', 'ΑΝΝΑ ΠΑΠΑΓΡΗΓΟΡΙΟΥ', '', '', '24530653', '', '', NULL, '0000-00-00', '', 39979, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1847, 'Active', 'ΠΑΡΑΣΚΕΥΗ ΧΑΤΖΗΣΤΑΣΗ', '', '', '99518997', '', '', NULL, '0000-00-00', '', 39980, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1848, 'Active', 'MADELEINE STAVROU', '', '', '99593644', '', '', NULL, '0000-00-00', '', 39981, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1849, 'Active', 'ΑΝΔΡΕΑΣ ΛΥΣΙΩΤΗΣ', '', '', '99654920', '', '', NULL, '0000-00-00', '', 40000, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1850, 'Active', 'ΧΡΙΣΤΟΔΟΥΛΟΣ ΟΙΚΟΝΟΜΙΔΗΣ', '', '', '24363821 99617501', '', '', NULL, '0000-00-00', '', 40004, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1851, 'Active', 'ΔΙΑΓΡΑΜΜΕΝΟΣ ΠΕΛΑΤΗ', '', '', '99009200', '', '', NULL, '0000-00-00', '', 40018, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1852, 'Active', 'NICOLAOS MICHAELIDES', '', '', '97774474', '', 'dr_michailides@hotmail.com', NULL, '0000-00-00', '', 40134, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1853, 'Active', 'ΘΕΟΔΟΥΛΟΣ ΘΕΟΔΟΥΛΟΥ', '', '', '24534858 99458384', '', '', NULL, '0000-00-00', '', 39816, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1854, 'Active', 'ΚΩΝΣΤΑΝΤΙΝ ΚΥΡΙΑΚΟΥ', '', '', '99244966', '', '', NULL, '0000-00-00', '', 39856, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1855, 'Active', 'ΑΚΥΡΩΣΗ ΑΔΩΝ', '', '', '', '', '', NULL, '0000-00-00', '', 39835, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1856, 'Active', 'ΜΙΧΑΛΗΣ  ΜΑΤΣΑΓΓΙΔΗΣ', '', '', '24623520 99041630', '', '', NULL, '0000-00-00', '', 39861, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1857, 'Active', 'ΣΤΑΥΡΟΣ ΑΝΔΡΕΟΥ', '', '', '99830140', '', '', NULL, '0000-00-00', '', 39862, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1858, 'Active', 'ΧΡΙΣΤΙΑΝΑ ΣΤΕΛΙΟΥ', '', '', '99317522', '', '', NULL, '0000-00-00', '', 39863, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1859, 'Active', 'ΑΡΙΣΤΟΤΕΛΗΣ ΚΩΜΟΔΡΟΜΟΣ', '', '', '99617520', '', '', NULL, '0000-00-00', '', 39864, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1860, 'Active', 'DIAGRAFI ADAM', '', '', '', '', '', NULL, '0000-00-00', '', 39931, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1861, 'Active', 'ANDREAS CHAROUS', '', '', '97640402', '', '', NULL, '0000-00-00', '', 39685, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1862, 'Active', 'ΣΤΑΥΡΟΣ ΣΤΑΥΡΟΥ', '', '', '99642648', '22377259', 'drstavrosstavrou@gmail.com', NULL, '0000-00-00', '', 39728, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1863, 'Active', 'MARO PETROU', '', '', '99749432', '22354487', 'petrou.maro@gmail.com', NULL, '0000-00-00', '', 40146, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1864, 'Active', 'ΙΩΑΝΝΑ ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '99445979', '', '', NULL, '0000-00-00', '', 40088, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1865, 'Active', 'ΕΛΛΗ ΑΤΤΑΡΤ', '', '', '22533465 99596520', '', '', NULL, '0000-00-00', '', 39934, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1866, 'Active', 'WILLIAM HAYES', '', '', '24665315', '', '', NULL, '0000-00-00', '', 39943, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1867, 'Active', 'ΙΩΑΝΝΗΣ & ΦΡΟΣΩ ΚΑΛΟΥΔΗ', '', '', '24669091', '', '', NULL, '0000-00-00', '', 39951, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1868, 'Active', 'NICOS ADONIS LTD', '', '', '99516624', '', '', NULL, '0000-00-00', '', 39676, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1869, 'Active', 'ΤΕΡΨΙΧΟΡΗ ΚΥΡΙΑΚΟΥ', '', '25737996', '99695874', '', '', NULL, '0000-00-00', '', 39982, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1870, 'Active', 'ΓΙΑΝΟΥΛΑ ΚΑΥΚΑΡΙΔΟΥ', '', '', '24533497 99023700', '', '', NULL, '0000-00-00', '', 39983, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1871, 'Active', 'ΑΥΞΕΝΤΙΟΣ ΑΝΔΡΕΟΥ', '', '', '99905050', '', '', NULL, '0000-00-00', '', 39716, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1872, 'Active', 'ΔΙΑΓΡΑΦΗ ΦΩ', '', '', '', '', '', NULL, '0000-00-00', '', 40001, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1873, 'Active', 'ΖΩΗ  ΚΟΝΣΟΥΛΑ', '', '', '96820308 96812137', '', '', NULL, '0000-00-00', '', 40008, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1874, 'Active', 'ΑΛΕΞΑΝΔΡΟΣ ΑΝΑΣΤΑΣΙΟΥ', '', '', '99217898', '', '', NULL, '0000-00-00', '', 39809, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1875, 'Active', 'ΠΑΥΛΟΣ  ΧΑΡΑΛΑΜΠΟΣ', '', '', '99475669', '', '', NULL, '0000-00-00', '', 39827, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1876, 'Active', 'ΑΝΔΡΕΑΣ ΚΑΣΟΥΛΙΔΗΣ', '', '', '24530079 99640810', '', '', NULL, '0000-00-00', '', 39857, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1877, 'Active', 'ΔΟΜΝΙΚΗ ΚΑΛΛΗ', '', '', '26942427 99456182', '', '', NULL, '0000-00-00', '', 39858, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1878, 'Active', 'διαγραφη', '', '', '25770842 99462732', '', '', NULL, '0000-00-00', '', 39859, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1879, 'Active', 'ΤΖΩΝ ΚΥΡΙΑΚΟΥ', '', '', 'fax.26951480 96352228', '', '', NULL, '0000-00-00', '', 39860, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1880, 'Active', 'ΠΑΥΛΙΝΑ ΚΛΕΑΝΘΟΥΣ', '', '', '99421525', '', '', NULL, '0000-00-00', '', 39865, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1881, 'Active', 'ΔΩΡΑ ΦΩΤΙΟΥ', '', '', '99630144', '', '', NULL, '0000-00-00', '', 39866, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1882, 'Active', 'ΣΤΥΛΙΑΝΗ ΠΑΝΤΕΛΗ', '', '', '24251000 99319810', '', '', NULL, '0000-00-00', '', 39867, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1883, 'Active', 'ΣΩΤΗΡΙΑ ΜΕΣΑΡΙΤΗ', '', '', '24637940 99309843', '', '', NULL, '0000-00-00', '', 39868, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1884, 'Active', 'ΝΙΚΟΣ ΙΩΑΝΝΙΔΗΣ', '', '', '99489800', '', '', NULL, '0000-00-00', '', 39871, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1885, 'Active', 'GAVRIEL MINA', '', '', '99620794', '', '', NULL, '0000-00-00', '', 40139, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1886, 'Active', 'ΓΕΩΡΓΙΑ ΚΑΓΙΑ', '', '', '99833384', '', '', NULL, '0000-00-00', '', 39900, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1887, 'Active', 'ΑΝΤΡΙΑ ΜΟΥΣΚΟΥ', '', '', '99771753', '', '', NULL, '0000-00-00', '', 39901, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1888, 'Active', 'ΜΙΧΑΛΗΣ ΧΑΤΖΗΜΙΤΣΗΣ', '', '', '99230585', '', '', NULL, '0000-00-00', '', 39909, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1889, 'Active', 'RANIA KAPITANI', '', '', '96792968', '', 'rania_ze95@hotmail.com', NULL, '0000-00-00', '', 39910, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1890, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ ΖΗΝΩΝΟΣ', '', '', '99682172', '', '', NULL, '0000-00-00', '', 39911, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1891, 'Active', 'ΠΑΥΛΟΣ  ΚΕΚΙΟΠΟΥΛΟΣ', '', '', '99313872', '', '', NULL, '0000-00-00', '', 40117, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1892, 'Active', 'ΑΝΔΡΕΑΣ ΔΗΜΗΤΡΙΟΥ & ΜΑΡΙΑ ΚΑΡΙΤΕΒΛΗ', '', '', '', '24822623', '', NULL, '0000-00-00', '', 39952, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1893, 'Active', 'ΜΑΡΙΑ ΜΙΧΑΗΛ', '', '', '99657139', '', '', NULL, '0000-00-00', '', 40035, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1894, 'Active', 'ΔΙΑΓΡΑΦΗ ΝΙΚΟΛΑΣ ΣΤΑΥΡΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39985, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1895, 'Active', 'ΓΙΩΡΓΟΣ ΕΦΡΑΙΜ', '', '', '99817891', '', '', NULL, '0000-00-00', '', 39995, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1896, 'Active', 'ΒΑΣΙΛΙΚΗ ΑΝΤΩΝΙΟΥ', '', '', '99832059', '', '', NULL, '0000-00-00', '', 40069, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1897, 'Active', 'ΜΥΡΩΝ ΣΙΗΚΚΗΣ', '', '', '99433162', '', '', NULL, '0000-00-00', '', 39986, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1898, 'Active', 'ΑΝΔΡΕΑΣ ΜΙΧΑΗΛ', '', '', '99515957', '', '', NULL, '0000-00-00', '', 39987, '2020-01-05 13:27:26', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1899, 'Active', 'VICA ΚΙΤΣΙΟΥ', '', '', '99814415', '', '', NULL, '0000-00-00', '', 40009, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1900, 'Active', 'TIMOTHY GREGORY COONEY', '', '', '97806266', '', '', NULL, '0000-00-00', '', 40056, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1901, 'Active', 'diagrafh pelati', '', '', '97663392', '', '', NULL, '0000-00-00', '', 40034, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1902, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΟΙΚΟΝΟΜΙΔΗΣ', '', '', '99406953', '', '', NULL, '0000-00-00', '', 39889, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1903, 'Active', 'DIAGRAFI SCH', '', '', '', '', 'sophiaschiza@gmail.com', NULL, '0000-00-00', '', 40138, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1904, 'Active', 'ΝΕΟΦΥΤΟΣ ΝΕΟΦΥΤΟΥ', '', '', '24530751 99370995', '', '', NULL, '0000-00-00', '', 39846, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1905, 'Active', 'PEGGY KALAYDJIAN', '', '', '24655095 99432624', '', '', NULL, '0000-00-00', '', 39847, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1906, 'Active', 'ΧΡΙΣΤΟΣ  ΤΟΥΜΑΖΗΣ', '', '', '24657880', '', 'toumazis@cytanet.com.cy', NULL, '0000-00-00', '', 39848, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1907, 'Active', 'ΠΑΝΤΕΛΙΤΣΑ ΜΑΠΠΟΥΡΑ', '', '', '99588770', '', '', NULL, '0000-00-00', '', 39870, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1908, 'Active', 'ΝΙΚΟΛΙΝΑ ΜΗΝΑ', '', '', '22453399 99488844', '', '', NULL, '0000-00-00', '', 39872, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1909, 'Active', 'ΣΤΕΛΙΟΣ ΑΓΓΕΛΗ', '', '', '99426013', '', 'ste.aggeli@gmail.com', NULL, '0000-00-00', '', 39873, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1910, 'Active', 'ΜΑΡΚΟΣ ΜΙΛΛΩΣΙΑΣ', '', '', '24532154 99576299', '', '', NULL, '0000-00-00', '', 39874, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1911, 'Active', 'ΑΝΤΩΝΗΣ ΚΟΥΜΑΣ', '', '', '99688606', '', '', NULL, '0000-00-00', '', 39875, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1912, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΑΙΤΑΝΟΥ', '', '', '99012063', '', '', NULL, '0000-00-00', '', 39876, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1913, 'Active', 'ΜΑΡΙΑ ΓΙΑΣΕΜΗ', '', '', '96300500 99669858', '', '', NULL, '0000-00-00', '', 39877, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1914, 'Active', 'ΝΕΚΤΑΡΙΑ ΚΑΤΣΙΚΙΔΟΥ', '', '', '25752522 99722060', '', '', NULL, '0000-00-00', '', 39878, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1915, 'Active', 'ΘΕΟΔΟΥΛΟΣ ΜΙΧΑΗΛ', '', '', '24423010', '', '', NULL, '0000-00-00', '', 39879, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1916, 'Active', 'ΑΝΤΩΝΗΣ ΜΙΧΑΗΛ', '', '', '24423010', '', '', NULL, '0000-00-00', '', 39880, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1917, 'Active', 'ΓΕΩΡΓΙΟΣ ΑΝΑΣΤΑΣΙΟΥ', '', '', '24631486 99582441', '', '', NULL, '0000-00-00', '', 39881, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1918, 'Active', 'ΝΙΚΗ ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '99561701', '', '', NULL, '0000-00-00', '', 39902, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1919, 'Active', 'ΑΝΔΡΕΑΣ ΣΤΥΛΙΑΝΟΥ', '', '', '99357660', '', '', NULL, '0000-00-00', '', 39912, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1920, 'Active', 'ΟΡΘΟΔΟΞΟΣ  ΓΕΩΡΓΙΟΥ', '', '', '99648215', '', '', NULL, '0000-00-00', '', 39711, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1921, 'Active', 'ΡΟΔΟΥ ΓΙΑΝΝΗ & ΑΝΔΡΙΑΝΗ ΓΙΑΝΝΗ', '', '', '97688753', '', '', NULL, '0000-00-00', '', 39944, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1922, 'Active', 'ΔΙΑΓΡΑΦΗ ΑΥΓΗ', '', '', '', '', '', NULL, '0000-00-00', '', 39992, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1923, 'Active', 'ΧΡΙΣΤΑΚΗΣ ΜΑΚΡΟΜΑΛΛΗΣ', '', '', '99676077', '', '', NULL, '0000-00-00', '', 39993, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1924, 'Active', 'ΛΟΥΚΙΟΣ  ΝΟΥΣΙΟΣ', '', '', '97743921', '', '', NULL, '0000-00-00', '', 40011, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1925, 'Active', 'ΚΟΔΡΟΣ ΝΟΥΣΙΟΣ', '', '', '24251613 99931061', '', '', NULL, '0000-00-00', '', 40012, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1926, 'Active', 'ΑΝΤΡΗ ΚΛΕΑΝΘΟΥΣ', '', '', '99515957', '', '', NULL, '0000-00-00', '', 40023, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1927, 'Active', 'ΔΙΑΓΡΑΦΗ ΦΑΡΜΑ', '', '', '', '', '', NULL, '0000-00-00', '', 40121, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1928, 'Active', 'ΣΥΝΔΕΣΜΟΣ ΑΓΕΛΑΔΟΤΡΟΦΩΝ ΑΡΑΔΙΠΠΟΥ ΛΤΔ', '', '', '', '', '', NULL, '0000-00-00', '', 40124, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1929, 'Active', 'diagrafi papa', '', '', '97772200', '', 'george.papanastasiou@yahoo.gr', NULL, '0000-00-00', '', 40135, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1930, 'Active', 'ΠΑΝΑΓΙΩΤΑ  ΔΙΑΚΟΥ', '', '', '24625942 99337063', '', 'maria.anastasia@cytanet.com.cy', NULL, '0000-00-00', '', 39916, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1931, 'Active', 'ΧΡΙΣΤΟΣ  ΚΟΥΠΠΑΡΗΣ', '', '', '99446827', '', '', NULL, '0000-00-00', '', 39849, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1932, 'Active', 'ΓΕΩΡΓΙΟΣ ΠΕΤΡΟΥ', '', '', '99498276', '', '', NULL, '0000-00-00', '', 39883, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1933, 'Active', 'ΒΑΣΟΥΛΛΑ ΝΙΚΟΛΑΟΥ', '', '', '99518528', '', '', NULL, '0000-00-00', '', 39885, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1934, 'Active', 'ΑΝΔΡΕΑΣ ΠΑΥΛΟΥ', '', '', '99327064', '', '', NULL, '0000-00-00', '', 39904, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1935, 'Active', 'LITTLE ACORNS NURSERY SCHOOL', '', '', '24828599 99104497', '', '', NULL, '0000-00-00', '', 39823, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1936, 'Active', 'ΑΝΔΡΟΥΛΛΑ ΠΕΛΕΚΑΝΟΥ', '', '', '24642978', '', '', NULL, '0000-00-00', '', 39829, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1937, 'Active', 'CONSTANTINOS STYLIANIDES', '', '', '99458566', '22354587', 'drstylianides@hotmail.com', NULL, '0000-00-00', '', 40149, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1938, 'Active', 'ΑΔΩΝΗΣ ΑΔΩΝΗ &  ΓΙΑΝΟΥΛΛΑ ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '24823034', '', '', NULL, '0000-00-00', '', 39935, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1939, 'Active', 'ΧΡΥΣΤΑΛΛΑ ΚΟΜΩΔΡΟΜΟΥ', '', '', '24663509 99663509', '', '', NULL, '0000-00-00', '', 39936, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1940, 'Active', 'ΠΑΡΑΣΚΕΥΗ ΜΠΛΕΤΣΑ', '', '', '24533425 99343339', '', '', NULL, '0000-00-00', '', 39747, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1941, 'Active', 'ΑΒΡΑΑΜ ΞΕΝΟΦΩΝΤΟΣ', '', '', '99409828', '', '', NULL, '0000-00-00', '', 39996, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1942, 'Active', 'PARASKEVAS PAPAGEORGIOU', '', '', '99300269', '', '', NULL, '0000-00-00', '', 39997, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1943, 'Active', 'ΛΟΥΚΙΑ ΜΗΝΑ', '', '', '24531704 99455809', '', '', NULL, '0000-00-00', '', 39998, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1944, 'Active', 'ΘΕΟΦΑΝΗΣ ΑΓΑΜΕΜΝΩΝΟΣ', '', '', '24653903', '', '', NULL, '0000-00-00', '', 40003, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1945, 'Active', 'ΔΗΜΗΤΡΗΣ ΠΡΟΞΕΝΟΥ', '', '', '99638796', '', '', NULL, '0000-00-00', '', 40024, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1946, 'Active', 'H&K UNITED CONCRETE PUMPS LTD', '', '', '99434719', '', '', NULL, '0000-00-00', '', 40125, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1947, 'Active', 'EUROCOSMETICS LD & AD LIMITED', '', '', '99434719', '', '', NULL, '0000-00-00', '', 40126, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1948, 'Active', 'SIMON GEORGHIOU', '', '', '99402858/96799091', '', '', NULL, '0000-00-00', '', 39753, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1949, 'Active', 'ΕΥΑΓΓΕΛΟΣ ΣΙΗΚΚΗΣ', '', '', '24534948 99531844', '', '', NULL, '0000-00-00', '', 39810, '2020-01-05 13:27:27', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1950, 'Active', 'ΑΛΙΟΝΑ ΔΗΜΗΤΡΙΟΥ', '', '', '99451134', '', '', NULL, '0000-00-00', '', 39811, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1951, 'Active', 'ΑΔΑΜ ΔΗΜΗΤΡΙΟΥ', '', '', '99451134', '', '', NULL, '0000-00-00', '', 39812, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1952, 'Active', 'ΔΗΜΗΤΡΗΣ ΧΑΤΖΗΜΙΤΣΗΣ', '', '', '99536627', '', '', NULL, '0000-00-00', '', 39824, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1953, 'Active', 'ΚΥΡΙΑΚΟΣ  ΜΑΡΚΟΥ', '', '', '99583733', '', '', NULL, '0000-00-00', '', 39886, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1954, 'Active', 'ΚΑΤΕΡΙΝΑ ΠΛΟΥΤΑΡΧΟΥ', '', '', '24667706 99347650', '', '', NULL, '0000-00-00', '', 39887, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1955, 'Active', 'ΚΥΡΙΑΚΟΣ ΓΕΡΟΛΕΜΟΥ', '', '', '24812295 99607308', '24819694', '', NULL, '0000-00-00', '', 39890, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1956, 'Active', 'ΙΟΥΛΙΑΝΟΣ ΙΟΥΛΙΑΝΟΥ', '', '', '24633610 99624602', '24819694', '', NULL, '0000-00-00', '', 39891, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1957, 'Active', 'ΙΕΡΩΝΥΜΟΣ ΓΕΡΟΛΕΜΟΥ', '', '', '24658489 99648451', '24819694', '', NULL, '0000-00-00', '', 39892, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1958, 'Active', 'ΑΝΤΡΙΑ  ΛΙΑΣΣΙΔΟΥ', '', '', '96842884', '', '', NULL, '0000-00-00', '', 40039, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1959, 'Active', 'CHRISTAKIS GEORGIOU', '', '', '99724828', '', 'chrisgeo1@hotmail.co.uk', NULL, '0000-00-00', '', 40082, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1960, 'Active', 'SEGOMEX ENTERPRISES LTD', '', '', '', '24000301', '', NULL, '0000-00-00', '', 39641, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1961, 'Active', 'PANAYIOTIS KERIMIS', '', '', '99870077', '25351110', 'info@entkerimis.com', NULL, '0000-00-00', '', 40150, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1962, 'Active', 'Χ Ζ ΚΗΠΟΥΡΟΤΕΧΝΙΚΗ ΛΤΔ', '', '', '99682172', '', '', NULL, '0000-00-00', '', 40128, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1963, 'Active', 'MAKSIM DIDICHENKO', '', '', '99533800', '', 'maxara@cytanet.com.cy', NULL, '0000-00-00', '', 40151, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1964, 'Active', 'ΧΡΙΣΤΑΚΗΣ ΝΙΚΟΛΑΟΥ', '', '', '24360114 99388314', '', '', NULL, '0000-00-00', '', 39814, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1965, 'Active', 'ΒΑΣΟΣ ΚΟΥΤΣΙΟΥΝΤΑΣ', '', '', '22897237', '', '', NULL, '0000-00-00', '', 40078, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1966, 'Active', 'ΕΛΙΣΑΒΕΤ ΘΕΟΚΛΗ', '', '', '97675613', '', '', NULL, '0000-00-00', '', 39917, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1967, 'Active', 'ΕΛΕΝΗ & ΠΕΤΡΟΣ & ΑΝΤΡΕΑΣ ΓΕΩΡΓΙΟΥ', '', '', '99499587', '', '', NULL, '0000-00-00', '', 39946, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1968, 'Active', 'V.G.HADJIANASTASIOU DLC', '', '', '97640932/97811818', '', 'vassilis@doctors.org.uk.', NULL, '0000-00-00', '', 40152, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1969, 'Active', 'ΚΛΙΝΙΚΑ ΕΡΓΑΣΤΗΡΙΑ ΓΕΩΡΓΑΛΛΙΔΗ ΛΤΔ', '', '', '24656241', '', '', NULL, '0000-00-00', '', 39962, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1970, 'Active', 'ΙΩΑΝΝΗΣ  ΙΩΑΝΝΟΥ', '', '', '99594765', '', '', NULL, '0000-00-00', '', 40107, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1971, 'Active', 'ΣΑΒΒΑΚΗΣ  ΣΑΒΒΑ', '', '', '24638281 99447901', '', '', NULL, '0000-00-00', '', 39815, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1972, 'Active', 'ΚΩΣΤΑΣ ΠΑΠΑΧΑΡΑΛΑΜΠΟΥΣ', '', '', '99688025', '', 'coskvid@hotmail.com', NULL, '0000-00-00', '', 39914, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1973, 'Active', 'ΜΙΧΑΛΗΣ ΝΤΑΝΚΑΝ ΜΑΚΑΙ ΧΕΙΣ', '', '', '99016163', '', '', NULL, '0000-00-00', '', 39893, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1974, 'Active', 'ΗΛΙΑΣ  ΗΛΙΑΔΗΣ', '', '', '24725935 99771069', '', '', NULL, '0000-00-00', '', 39955, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1975, 'Active', 'ΛΟΥΚΙΑ ΚΑΓΙΑ ΤΥΡΟΚΟΜΕΙΑ ΛΤΔ', '', '', '99425722', '', '', NULL, '0000-00-00', '', 40110, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1976, 'Active', 'ΓΕΩΡΓΙΟΣ ΓΕΩΡΓΙΟΥ', '', '', '99407197', '', 'ggeorge32@outlook.com', NULL, '0000-00-00', '', 39734, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1977, 'Active', 'ΜΕΤΑΦΟΡΙΚΗ ΕΤΑΙΡΕΙΑ (ΠΑΜΙΝΙ) ΛΤΔ', '', '', '24533373 99434712', '', '', NULL, '0000-00-00', '', 40113, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1978, 'Active', 'ΣΤΕΛΛΑ  ΠΑΡΙΔΟΥ', '', '', '99612929', '', 'stellaparidou@cytanet.com.cy', NULL, '0000-00-00', '', 39918, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1979, 'Active', 'AΚΥΡΩΣΗ DEMETRIS ', '', '', '', '', 'drstavrou@cyplastsurg.com', NULL, '0000-00-00', '', 40141, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1980, 'Active', 'CHRISTOS  TRYFONIDES', '', '', '99372092', '', 'christostryfonides@hotmail.com', NULL, '0000-00-00', '', 40160, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1981, 'Active', 'VERESIES CLINIC LTD', '', '', '99598412', '24645320', '', NULL, '0000-00-00', '', 40142, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1982, 'Active', 'CHARILAOS STYLIANOU', '', '', '99433133', '', 'chstylianou@gmail.com', NULL, '0000-00-00', '', 40153, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1983, 'Active', 'ΧΑΡΑΛΑΜΠΙΑ ΣΟΦΟΥ', '', '', '99741747', '', 'chara_sofou22@hotmail.com', NULL, '0000-00-00', '', 39915, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1984, 'Active', 'ΔΙΑΧΕΙΡΙΣΤΕΣ ΤΗΣ ΠΕΡΙΟΥΣΙΑΣ ΤΟΥ ΑΠΟΒΙΩΣ. ΓΕΩΡΓΙΟΥ ', '', '', '99643108', '', '', NULL, '0000-00-00', '', 40104, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1985, 'Active', 'ΔΙΑΓΡΑΦΗ ΓΙΩΡΓΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40043, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1986, 'Active', 'ΚΑΛΛΙΣΘΕΝΗ ΦΩΤΙΑΔΟΥ', '', '', '99312246', '', 'kallistheniph@hotmail.com', NULL, '0000-00-00', '', 39899, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1987, 'Active', 'ΜΑΡΙΑ ΒΑΡΝΑΒΑ', '', '', '24323400 99057685', '', '', NULL, '0000-00-00', '', 39825, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1988, 'Active', 'ΕΥΑΓΓΕΛΟΣ  ΜΟΥΣΚΟΣ', '', '', '99593434', '', '', NULL, '0000-00-00', '', 39954, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1989, 'Active', 'ΔΙΑΧΕΙΡΙΣΤΙΚΗ ΕΠΙΤΡΟΠΗ MOUSKOS PLAZA', '', '', '99648280', '', '', NULL, '0000-00-00', '', 39929, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1990, 'Active', 'ΔΗΜΗΤΡΗΣ  ΠΡΟΞΕΝΟΥ', '', '', '99638796', '', '', NULL, '0000-00-00', '', 39770, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1991, 'Active', 'ΕΛΕΝΗ  ΙΩΑΝΝΟΥ ΞΕΝΟΦΩΝΤΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 39830, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1992, 'Active', 'ΑΡΓΥΡΙΔΟΥ & ΠΑΠΑΧΡΥΣΟΣΤΟΜΟΥ ΛΤΔ', '', '26622699', '', '26813756', '', NULL, '0000-00-00', '', 39834, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1993, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΓΕΩΡΓΙΟΥ', '', '', '99516225  ΑΝΤΡΙΑΝΑ 994468', '', '', NULL, '0000-00-00', '', 39882, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1994, 'Active', 'PANAGIOTIS LIMIATIS', '', '', '99244028', '', '', NULL, '0000-00-00', '', 40155, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1995, 'Active', 'ΑΝΔΡΙΑΝΗ ΓΕΩΡΓΙΟΥ', '', '', '99156486', '', '', NULL, '0000-00-00', '', 40045, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1996, 'Active', 'ARDENNORTH COMPANY LTD', '', '', '', '', '', NULL, '0000-00-00', '', 39953, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1997, 'Active', 'CHRYSTALLENI MYLONAS', '', '', '99657273', '', 'chrystalleni.mylonas@yahoo.com', NULL, '0000-00-00', '', 40156, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1998, 'Active', 'STEFAN BERNS', '', '', '', '', '', NULL, '0000-00-00', '', 40046, '2020-01-05 13:27:28', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (1999, 'Active', 'ΑΝΤΩΝΗΣ  ΑΝΤΩΝΙΟΥ', '', '', '99579869', '', '', NULL, '0000-00-00', '', 40047, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2000, 'Active', 'ΜΑΡΓΑΡΙΤΑ ΚΟΥΣΙΑΠΑ', '', '', '99449650', '', '', NULL, '0000-00-00', '', 39661, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2001, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΛΟΥΤΑΡΧΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39831, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2002, 'Active', 'ΕΛΕΝΗ ΚΩΝΣΤΑΝΤΗ ΚΕΚΙΟΠΟΥΛΟΥ', '', '', '99313872', '', '', NULL, '0000-00-00', '', 40048, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2003, 'Active', 'ΦΛΩΡΕΝΤΖΟΣ ΙΟΥΛΙΑΝΟΥ', '', '', '97737294', '', '', NULL, '0000-00-00', '', 39920, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2004, 'Active', 'URBAN EYE ELECTRONICS & SECURITY SYSTEMS', '', '', '99327064', '', '', NULL, '0000-00-00', '', 40106, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2005, 'Active', 'ΑΝΤΡΕΑΣ  ΚΑΨΗΣ', '', '', '99105029', '', '', NULL, '0000-00-00', '', 40049, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2006, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΝΑΓΙΩΤΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39700, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2007, 'Active', 'ΔΙΑΓΡΑΜΜΕΝΟΣ ΠΕΛΑΤΗ', '', '', '95140089', '', '', NULL, '0000-00-00', '', 39769, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2008, 'Active', 'ΕΛΕΝΗ ΠΑΤΣΑΛΟΣ', '', '', '99315995', '', '', NULL, '0000-00-00', '', 40050, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2009, 'Active', 'ΓΙΩΡΓΟΣ ΚΕΡΤΕΠΕΝΕ', '', '', '99479751', '', '', NULL, '0000-00-00', '', 40051, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2010, 'Active', 'ΠΑΥΛΟΣ  ΧΡΙΣΤΟΥ', '', '', '99023700', '', '', NULL, '0000-00-00', '', 40108, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2011, 'Active', 'GUNDUR GAARDBO', '', '', '96934458', '', '', NULL, '0000-00-00', '', 39837, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2012, 'Active', 'KRYSTYNA MANISTOVA', '', '', '96934458', '', '', NULL, '0000-00-00', '', 39838, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2013, 'Active', 'PAM-AZON GROSS UND EINZELHANDELS LTD', '', '', '99468096', '', '', NULL, '0000-00-00', '', 39715, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2014, 'Active', 'ΕΛΕΝΑ  ΛΟΥΚΑ ΧΑΤΖΗΛΟΙΖΟΥ', '', '', '99473347', '', '', NULL, '0000-00-00', '', 40083, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2015, 'Active', 'ILIAS BROUNTZOS', '', '', '00302109636721 97777461', '', 'ebrountz@med.uoa.gr', NULL, '0000-00-00', '', 40154, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2016, 'Active', 'διαγραφη αντρεα', '', '', '', '', '', NULL, '0000-00-00', '', 40037, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2017, 'Active', 'ΑΝΔΡΟΥΛΑ  ΞΕΝΟΦΩΝΤΟΣ ΖΑΝΝΕΤΤΗ', '', '', '22879439 99407917', '', '', NULL, '0000-00-00', '', 40075, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2018, 'Active', 'ΑΝΘΟΥΛΗΣ ΖΑΧΑΡΙΑ', '', '', '99925055', '', '', NULL, '0000-00-00', '', 40068, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2019, 'Active', 'PANOS STEAK HOUSE & COMPANY LTD', '', '', '99493249/99682565', '24255471', 'panossteakhouse@gmail', NULL, '0000-00-00', '', 39640, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2020, 'Active', 'ΜΑΡΙΑ  ΧΡIΣΤΟΦΗ', '', '99426879', '', '', '', NULL, '0000-00-00', '', 39970, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2021, 'Active', 'MAN HE', '', '', '99281389', '', '', NULL, '0000-00-00', '', 39839, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2022, 'Active', 'JING JIA', '', '', '99107621', '', '', NULL, '0000-00-00', '', 39840, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2023, 'Active', 'ΚΑΤΕΡΙΝΑ ΜΑΥΡΟΜΙΧΑΛΟΥ', '', '', '24629436 99559305', '', '', NULL, '0000-00-00', '', 39888, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2024, 'Active', 'MARIA TSITSKARI I.E.P.E', '', '', '97777461', '', '', NULL, '0000-00-00', '', 40145, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2025, 'Active', 'TRATTORIA LA VIGNA LIMITED', '', '', '99306033', '26931318', '', NULL, '0000-00-00', '', 39964, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2026, 'Active', 'ΜΕΛΑΝΗ ΚΑΦΑΤΑΡΗ', '', '', '99305778', '', '', NULL, '0000-00-00', '', 40054, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2027, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΧΡΙΣΤΟΦΟΡΟΥ', '', '', '99491834', '', '', NULL, '0000-00-00', '', 40118, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2028, 'Active', 'ΑΝΔΡΕΑΣ ΜΑΥΡΟΜΙΧΑΛΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 39833, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2029, 'Active', 'ΜΙΧΑΛΗΣ ΜΑΥΡΟΜΙΧΑΛΟΣ', '', '', '24629436 99223414', '', '', NULL, '0000-00-00', '', 39978, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2030, 'Active', 'ΣΤΕΛΙΟΣ   ΜΑΥΡΟΜΙΧΑΛΟΣ', '', '', '99654015', '', '', NULL, '0000-00-00', '', 39932, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2031, 'Active', 'STELLA CHARALAMPOUS', '', '', '99567839', '', 'stella.ohara1@gmail.com', NULL, '0000-00-00', '', 40158, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2032, 'Active', 'ΜΑΡΩ  ΧΠΑΝΑΓΗ ΝΙΚΟΛΑΟΥ', '', '', '99623171', '', '', NULL, '0000-00-00', '', 40021, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2033, 'Active', 'ΙΩΑΝΝΗΣ ΝΟΥΣΙΟΣ', '', '', '99427760', '', '', NULL, '0000-00-00', '', 40057, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2034, 'Active', 'ZLATINA KONSTANTINOU', '', '', '99808515', '', '', NULL, '0000-00-00', '', 39884, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2035, 'Active', 'SVETLANA  GRIGORI', '', '', '99769437', '', '', NULL, '0000-00-00', '', 40058, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2036, 'Active', 'ΘΕΟΔΟΣΙΑ & ΜΙΧΑΛΗΣ  ΜΑΥΡΟΜΙΧΑΛΟΥ', '', '', '24629439 99223414', '', '', NULL, '0000-00-00', '', 39938, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2037, 'Active', 'ΑΝΤΡΕΑΣ ΦΩΚΟΥ', '', '', '24669054 99669490', '', '', NULL, '0000-00-00', '', 40033, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2038, 'Active', 'ΠΑΝΑΓΙΩΤΑ ΣΥΖΙΝΟΥ', '', '', '99945606', '', 'yiotasyz@hotmail.com', NULL, '0000-00-00', '', 40059, '2020-01-05 13:27:29', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2039, 'Active', 'ΜΑΡΙΑ ΙΩΑΝΝΟΥ', '', '', '97768676', '', '', NULL, '0000-00-00', '', 40061, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2040, 'Active', 'ΚΥΡΙΑΚΗ ΚΑΡΙΤΤΕΒΛΗ', '', '', '24530412', '', '', NULL, '0000-00-00', '', 40060, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2041, 'Active', 'ΑΦΡΟΔΙΤΗ ΧΑΤΖΗΠΑΝΑΓΗ', '', '', '99623171', '', '', NULL, '0000-00-00', '', 39988, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2042, 'Active', 'ΑΝΤΡΕΑ ΟΝΗΣΙΦΟΡΟΥ', '', '', '99688045', '', '', NULL, '0000-00-00', '', 39922, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2043, 'Active', 'ΕΥΘΥΜΙΟΣ ΟΝΗΣΙΦΟΡΟΥ', '', '', '99688045', '', '', NULL, '0000-00-00', '', 39923, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2044, 'Active', 'ΑΝΤΩΝΙΑ  ΧΑΤΖΗΕΥΤΥΧΙΟΥ', '', '', '99570530', '', '', NULL, '0000-00-00', '', 40020, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2045, 'Active', 'ΑΝΔΡΕΑΣ ΦΑΝΤΑΡΟΣ', '', '', '99594863', '', '', NULL, '0000-00-00', '', 39701, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2046, 'Active', 'ΕΛΕΥΘΕΡΙΑ ΜΠΑΛΑΜΩΤΗ', '', '', '96405377', '', '', NULL, '0000-00-00', '', 40062, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2047, 'Active', 'ΔΗΜΗΤΡΑ ΝΙΚΟΛΑΟΥ', '', '', '99594840 Δήμητρα Νικολάου', '', '', NULL, '0000-00-00', '', 39903, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2048, 'Active', 'YIANNAKIS VASILIOU I.E.P.E', '', '', '99671768', '', 'vasiliou@gmail.com', NULL, '0000-00-00', '', 40159, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2049, 'Active', 'QIAN YU', '', '', '96618591', '', '', NULL, '0000-00-00', '', 39841, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2050, 'Active', 'ΑΝΤΩΝΗΣ  ΣΤΥΛΙΑΝΟΥ', '', '', '96846961', '', '', NULL, '0000-00-00', '', 40064, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2051, 'Active', 'ΑΝΝΑ ΣΩΦΡΟΝΙΟΥ', '', '', '99742704', '', '', NULL, '0000-00-00', '', 40065, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2052, 'Active', 'A&N OFFICESERV BUSIN.SOLUT.LTD', '', '', '22666700', '', '', NULL, '0000-00-00', '', 40103, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2053, 'Active', 'ΧΡΥΣΤΑΛΛΑ ΦΛΟΚΚΑ', '', '', '99816510', '', 'christallaflokka@yahoo.gr', NULL, '0000-00-00', '', 39924, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2054, 'Active', 'ΜΑΡΙΛΕΝΑ ΖΟΥΡΙΔΟΥ', '', '', '97904237', '', 'marilena-zouridou@hotmail.com', NULL, '0000-00-00', '', 39925, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2055, 'Active', 'ELCHIN SHAKHBAZOV', '', '', '24000300', '', '', NULL, '0000-00-00', '', 39842, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2056, 'Active', 'KYRIAKOS  SAVVIDES', '', '', '0027824915990', '', '', NULL, '0000-00-00', '', 39949, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2057, 'Active', 'VADIM BIBE', '', '', '24000300', '', '', NULL, '0000-00-00', '', 39843, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2058, 'Active', 'ANTREAS & SABINE  PEHNACK', '', '', '96202142', '', '', NULL, '0000-00-00', '', 40071, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2059, 'Active', 'ΓΕΩΡΓΟΥΛΛΑ ΧΡΙΣΤΟΥ', '', '', '99241177', '', '', NULL, '0000-00-00', '', 39836, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2060, 'Active', 'ΕΡΣΗ  ΠΑΠΑΓΙΑΝΝΗ', '', '', '99646090', '', 'opnicole@cytanet.com', NULL, '0000-00-00', '', 39950, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2061, 'Active', 'ΑΘΑΝΑΣΙΑ ΠΟΥΙΚΑ', '', '', '96422446', '', '', NULL, '0000-00-00', '', 40072, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2062, 'Active', 'ELENA CHIRICUTA', '', '', '96616661', '', '', NULL, '0000-00-00', '', 39697, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2063, 'Active', 'KAIFANG ZHANG', '', '', '96090998', '', '', NULL, '0000-00-00', '', 39844, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2064, 'Active', 'ΝΙΚΟΣ  ΝΙΚΟΛΑΟΥ', '', '', '99594840', '', '', NULL, '0000-00-00', '', 39921, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2065, 'Active', 'MARY GOODMAN', '', '', '96650425', '', '', NULL, '0000-00-00', '', 39947, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2066, 'Active', 'ΑΝΔΡΟΥΛΑ  ΚΕΛΙΡΗ', '', '', '99630640', '', '', NULL, '0000-00-00', '', 40073, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2067, 'Active', 'ΝΙΚΟΛΑΟΣ  ΣΟΛΩΜΟΥ', '', '', '96816829', '', '', NULL, '0000-00-00', '', 39713, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2068, 'Active', 'BLESILDA ABABAO MACATO', '', '', '99749513', '', '', NULL, '0000-00-00', '', 39845, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2069, 'Active', 'ΕΛΕΝΗ ΣΙΗΚΚΗ', '', '', '99433162', '', '', NULL, '0000-00-00', '', 40074, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2070, 'Active', 'CHRYSOSTOMOS  PETROU', '', '', '99256570', '', '', NULL, '0000-00-00', '', 39926, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2071, 'Active', 'LUKASZ KALEDKIEWICS ROMAN', '', '', '99487483', '', '', NULL, '0000-00-00', '', 40109, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2072, 'Active', 'ALEXANDRA KATERINI', '', '', '', '', '', NULL, '0000-00-00', '', 40076, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2073, 'Active', 'ΑΝΤΡΕΑΣ  ΦΕΚΚΑΣ', '', '', '99180700', '', '', NULL, '0000-00-00', '', 39686, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2074, 'Active', 'ΘΕΜΙΣ ΛΟΙΖΟΥ', '', '', '99783704', '', 'themida_l@hotmail.com', NULL, '0000-00-00', '', 39662, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2075, 'Active', 'ΕΡΙΛΕΝΑ  ΠΕΛΑΓΙΑ', '', '', '96662114', '', '', NULL, '0000-00-00', '', 39687, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2076, 'Active', 'MΑΡΙΑ ΦΙΛΙΠΠΟΥ', '', '', '24422281 99661149', '', '', NULL, '0000-00-00', '', 39688, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2077, 'Active', 'ΣΤΕΛΛΑ ΘΕΟΔΟΥΛΟΥ', '', '', '96650158', '', '', NULL, '0000-00-00', '', 39689, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2078, 'Active', 'ΓΕΩΡΓΙΟΣ ΠΑΝΑΓΗ', '', '', '97661638', '', '', NULL, '0000-00-00', '', 39785, '2020-01-05 13:27:30', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2079, 'Active', 'JOHN WILLIAM  THOMPSON', '', '', '99375284', '', 'medic50@cytanet.com.cy', NULL, '0000-00-00', '', 39690, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2080, 'Active', 'DEALMANIA LIMITED', '', '', '99341058', '', '', NULL, '0000-00-00', '', 39799, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2081, 'Active', 'LEONID ROTARESCU IONEL', '', '', '96444251', '', '', NULL, '0000-00-00', '', 39691, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2082, 'Active', 'ΙΟΡΔΑΝΗΣ ΙΟΡΔΑΝΟΥ', '', '', '99425042', '', '', NULL, '0000-00-00', '', 39786, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2083, 'Active', 'AURELIA VASILE', '', '', '99064916', '', '', NULL, '0000-00-00', '', 39692, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2084, 'Active', 'ΜΑΙΛΙΝΤΑ ΑΘΑΝΑΣΙΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 39693, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2085, 'Active', 'ΜΑΡΙΑ ΧΡΙΣΤΟΥ ΛΑΖΑΡΟΥ', '', '', '99626105', '', '', NULL, '0000-00-00', '', 39966, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2086, 'Active', 'ΛΑΖΑΡΟΥ ΛΕΝΟΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40042, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2087, 'Active', 'KRISTINA ANTONIOU', '', '', '99878401', '', '', NULL, '0000-00-00', '', 39645, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2088, 'Active', 'ELYMPUS SERVICES LTD', '', '', '99513612', '', '', NULL, '0000-00-00', '', 39802, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2089, 'Active', 'DR THEODOROS CHRISTOFI DLC', '', '', '99244944', '22512361', 't.christofi@aretaeio.com', NULL, '0000-00-00', '', 39804, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2090, 'Active', 'ΣΩΚΡΑΤΗΣ ΜΑΝΕΝΤΖΟΣ', '', '', '99410417', '', '', NULL, '0000-00-00', '', 39695, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2091, 'Active', 'ΣΚΕΥΗ ΑΠΟΣΤΟΛΟΥ', '', '', '99883122', '', '', NULL, '0000-00-00', '', 39696, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2092, 'Active', 'PAMBOS LEMONAS', '', '', '99215444', '', 'pamboslemonas@yahoo.com', NULL, '0000-00-00', '', 39805, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2093, 'Active', 'ΓΙΩΡΓΟΣ ΠΑΓΙΑΣΗΣ', '', '', '99568204', '', '', NULL, '0000-00-00', '', 39698, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2094, 'Active', 'ΛΟΥΚΑΣ ΝΕΟΦΥΤΟΥ', '', '', '99515575', '', '', NULL, '0000-00-00', '', 39699, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2095, 'Active', 'TAMZIN ERRIN CLOETE', '', '', '96379116', '', '', NULL, '0000-00-00', '', 39646, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2096, 'Active', 'ΨΑΡΟΝΟΣΤΗΜΙΕΣ ( PRONOE TRADING LTD )', '', '', '', '25340431', 'pronoetrading@yahoo.com', NULL, '0000-00-00', '', 39675, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2097, 'Active', 'ΣΠΥΡΟΥ ΟΜΗΡΟΣ', '', '', '22484967', '', '', NULL, '0000-00-00', '', 39787, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2098, 'Active', 'ΛΟΥΚΙΑ ΦΥΣΕΝΤΖΟΥ', '', '', '99748026', '', '', NULL, '0000-00-00', '', 39702, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2099, 'Active', 'ΚΥΡΙΑΚΗ ΑΠΟΣΤΟΛΟΥ', '', '', '99883122', '', '', NULL, '0000-00-00', '', 40052, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2100, 'Active', 'ΕΙΡΗΝΑΙΟΣ ΛΟΙΖΟΥ', '', '', '97643500', '', '', NULL, '0000-00-00', '', 40079, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2101, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ  ΓΕΩΡΓΙΟΥ', '', '', '24532568 97798565', '', '', NULL, '0000-00-00', '', 39638, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2102, 'Active', 'ΓΙΩΡΓΟΣ ΣΩΤΗΡΙΟΥ', '', '', '99638796', '', '', NULL, '0000-00-00', '', 39703, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2103, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΓΚΟΥΤΑΡΑΣ', '', '', '96126384', '', '', NULL, '0000-00-00', '', 39704, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2104, 'Active', 'ΔΗΜΗΤΡΑ ΕΓΓΛΕΖΟΥ', '', '', '99537939', '', '', NULL, '0000-00-00', '', 39705, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2105, 'Active', 'ΜΑΡΙΑ ΠΑΠΑΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '99472261', '', '', NULL, '0000-00-00', '', 39706, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2106, 'Active', 'ΜΑΡΙΑΝΝΑ  ΠΑΠΑΣΟΖΩΜΕΝΟΥ', '', '', '99486303', '', '', NULL, '0000-00-00', '', 40080, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2107, 'Active', 'ΒΑΣΟΣ ΚΟΙΛΑΝΗΣ', '', '', '99662955', '', '', NULL, '0000-00-00', '', 39707, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2108, 'Active', 'ΣΤΥΛΙΑΝΗ ΑΒΡΑΑΜΙΔΟΥ', '', '', '99420112', '', '', NULL, '0000-00-00', '', 39708, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2109, 'Active', 'ΧΡΙΣΤΟΣ  ΑΝΤΩΝΙΑΔΗΣ', '', '', '99611162', '', '', NULL, '0000-00-00', '', 39709, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2110, 'Active', 'MAILINTA ATHANASIOU', '', '', '99969937', '', 'mailindaathanasiou@yahoo.gr', NULL, '0000-00-00', '', 39806, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2111, 'Active', 'ΣΑΒΒΑΣ ΦΑΝΤΑΡΟΣ', '', '', '99594863', '', '', NULL, '0000-00-00', '', 39710, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2112, 'Active', 'ΑΝΤΡΙΑΝΗ ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '96816829', '', '', NULL, '0000-00-00', '', 39714, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2113, 'Active', 'ΣΤΑΥΡΟΣ ΧΑΡΑΛΑΜΠΟΥΣ ΚΑΙ  ΕΙΡΗΝΗ ΠΑΜΠΟΥΛΟΥ', '', '', '24531166', '', '', NULL, '0000-00-00', '', 39673, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2114, 'Active', 'ICE LAB LTD', '', '', '99660452', '', '', NULL, '0000-00-00', '', 39800, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2115, 'Active', 'STOYANOVA IVANOVA EVA VESKA', '', '', '99655149', '', '', NULL, '0000-00-00', '', 39719, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2116, 'Active', 'COLLINT SERVICES LTD', '', '', '99654269', '', '', NULL, '0000-00-00', '', 39684, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2117, 'Active', 'J.J.B. COFFEE ART LIMITED', '', '', '99300269', '', '', NULL, '0000-00-00', '', 39677, '2020-01-05 13:27:31', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2118, 'Active', 'GHPA DESIGN AND CONSTRUCTION LTD', '', '', '97788750', '', '', NULL, '0000-00-00', '', 39721, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2119, 'Active', 'ΔΙΑΓΡΑΦΗ ΠΑΡΑΣΚΕΥΑΣ', '', '', '99300269', '', '', NULL, '0000-00-00', '', 39720, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2120, 'Active', 'ΔΕΣΠΟΙΝΑ ΚΑΓΚΕΛΛΑΡΗ', '', '', '22489988 99750664', '', '', NULL, '0000-00-00', '', 39722, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2121, 'Active', 'ΟΔΟΝΤΙΑΤΡΕΙΟ ΤΡΟΥΛΛΙΩΤΗΣ ΓΕΩΡΓΙΟΣ', '', '', '22355684 99431045', '', '', NULL, '0000-00-00', '', 39679, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2122, 'Active', 'M.L.COFFEE LTD', '', '', '99220188', '', '', NULL, '0000-00-00', '', 39678, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2123, 'Active', 'ΑΝΔΡΕΑΣ  ΓΕΩΡΓΙΟΥ ΜΑΟΣ', '', '', '24422407', '', '', NULL, '0000-00-00', '', 39639, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2124, 'Active', 'ΝΑΠΟΛΕΩΝ ΣIΜIΤΖΗΣ', '', '', '96865181', '', '', NULL, '0000-00-00', '', 39724, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2125, 'Active', 'DAMIT FERESCU', '', '', '99490655', '', '', NULL, '0000-00-00', '', 39725, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2126, 'Active', 'ΜΑΡΙΑ  ΘΕΟΧΑΡΙΔΟΥ', '', '', '99598938', '', '', NULL, '0000-00-00', '', 39766, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2127, 'Active', 'ΕΛΕΝΗ  ΚΩΝΣΤΑΝΤΙΝΙΔΟΥ', '', '', '99684945', '', 'elenconnidou@gmail.com', NULL, '0000-00-00', '', 39726, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2128, 'Active', 'ANASTASIS ANASTASIADIS I.E.P.E', '', '', '99586063', '', 'an.anastasiadis@gmail.com', NULL, '0000-00-00', '', 40157, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2129, 'Active', 'DEMETRIS STAVROY DLC', '', '', '', '', '', NULL, '0000-00-00', '', 39680, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2130, 'Active', 'ΚΡΙΣΤΙΑΝ  ΓΚΙΟΝΑ', '', '', '99074669', '', '', NULL, '0000-00-00', '', 39727, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2131, 'Active', 'ΑΥΓΗ  ΧΡΙΣΤΟΥ', '', '', '70088002', '', '', NULL, '0000-00-00', '', 39729, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2132, 'Active', 'ROMAN KAZIMIERZ ZIEMIAN', '', '', '24000300', '', '', NULL, '0000-00-00', '', 39647, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2133, 'Active', 'ΜΑΡΙΑ  ΕΥΑΓΓΕΛΟΥ', '', '', '96126384', '', '', NULL, '0000-00-00', '', 39731, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2134, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΑ ΛΥΔΙΑ ΜΠΟΥΡΑΙΜΗ', '', '', '96606670', '', '', NULL, '0000-00-00', '', 39732, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2135, 'Active', 'ΧΡΙΣΤΟΣ  ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '99769382', '', '', NULL, '0000-00-00', '', 39794, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2136, 'Active', 'TΑΣΟΣ  ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '99769382', '', '', NULL, '0000-00-00', '', 39795, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2137, 'Active', 'DIAGRAFI KOR', '', '', '', '', '', NULL, '0000-00-00', '', 39788, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2138, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΑΝΤΩΝΙΟΥ', '', '', '99621276', '', '', NULL, '0000-00-00', '', 39733, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2139, 'Active', 'ΜΑΡΙΟΣ ΛΟΙΖΙΔΗΣ', '', '', '96447642', '', '', NULL, '0000-00-00', '', 39736, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2140, 'Active', 'ΓΙΩΡΓΟΣ ΒΑΣΙΛΕΙΟΥ', '', '', '99684995', '', '', NULL, '0000-00-00', '', 39789, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2141, 'Active', 'G AND A STROVOLOS PIZZA LIMITED', '', '', '97714901', '', '', NULL, '0000-00-00', '', 39681, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2142, 'Active', 'ΔΗΜΗΤΡΗΣ  ΑΠΟΣΤΟΛΟΥ', '', '', '97879457', '', '', NULL, '0000-00-00', '', 39735, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2143, 'Active', 'IGOR KAMENSKIKH', '', '', '99341058', '', '', NULL, '0000-00-00', '', 39737, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2144, 'Active', 'ΓΕΩΡΓΙΑ ΛΟΙΖΟΥ', '', '', '24530014 99665042', '', '', NULL, '0000-00-00', '', 39738, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2145, 'Active', 'ΧΡΙΣΤΟΔΟΥΛΟΣ ΠΑΡΛΑΣ', '', '', '96585000', '', 'ch.parlas@gmail.com', NULL, '0000-00-00', '', 39739, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2146, 'Active', 'PIROV EVGENI', '', '', '96577618', '', '', NULL, '0000-00-00', '', 39740, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2147, 'Active', 'ΑΝΔΡΕΑΣ  ΒΑΣΙΛΕΙΟΥ', '', '', '99316848', '', 'chris_fella@hotmail.com', NULL, '0000-00-00', '', 39663, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2148, 'Active', 'SUOAD M IMHEMED GIBREL', '', '', '', '', '', NULL, '0000-00-00', '', 39648, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2149, 'Active', 'FARAG ISAM FARAG BEN JLIEL', '', '', '', '', '', NULL, '0000-00-00', '', 39649, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2150, 'Active', 'MICHAL ANDRZEJ PLUTA', '', '', '99880905', '', '', NULL, '0000-00-00', '', 39650, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2151, 'Active', 'BULAN SUWANMON', '', '', '', '', '', NULL, '0000-00-00', '', 39651, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2152, 'Active', 'ΧΡΙΣΤΟΣ ΙΩΝΑ', '', '', '99376271', '', '', NULL, '0000-00-00', '', 39790, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2153, 'Active', 'ΑΛΕΞΑΝΔΡΟΣ ΔΗΜΗΤΡΙΑΔΗΣ', '', '', '96293166', '', '', NULL, '0000-00-00', '', 39741, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2154, 'Active', 'ΚΩΣΤΑΣ ΑΛΑΜΠΡΙΤΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40084, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2155, 'Active', 'ΚΩΣΤΑΝΤΙΝΟΣ ΚΩΣΤΑΝΤΙΝΟΥ', '', '', '99553346', '', '', NULL, '0000-00-00', '', 40085, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2156, 'Active', 'MIKHAIL POPOV', '', '', '', '', '', NULL, '0000-00-00', '', 40086, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2157, 'Active', 'ΧΡΙΣΤΟΣ  ΣΑΚΚΑΣ', '', '', '96498380', '', '', NULL, '0000-00-00', '', 40111, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2158, 'Active', 'KOEV DOBRIN DIMITROV', '', '', '25332352 99031067', '', '', NULL, '0000-00-00', '', 39742, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2159, 'Active', 'KONSTANTINOS ROGDAKIS I.E.P.E', '', '', '96542702', '', '', NULL, '0000-00-00', '', 40147, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2160, 'Active', 'DIMITROV MARIYAN YULIYANOV', '', '', '', '', '', NULL, '0000-00-00', '', 40089, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2161, 'Active', 'ΓΙΩΤΑ ΚΥΡΙΑΚΟΥ', '', '', '99837399', '', 'yiota_ky_88@hotmail.com', NULL, '0000-00-00', '', 40096, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2162, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ ΧΑΡΙΤΟΥ', '', '', '96892171', '', '', NULL, '0000-00-00', '', 40090, '2020-01-05 13:27:32', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2163, 'Active', 'ΜΑΡΙΑ ΕΓΓΛΕΖΟΥ', '', '', '99611162', '', '', NULL, '0000-00-00', '', 39743, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2164, 'Active', 'PENEV GEORGI KRASTEV', '', '', '96729109', '', '', NULL, '0000-00-00', '', 39776, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2165, 'Active', 'DONCHEV VASIL ANGELOV', '', '', '96891171', '', '', NULL, '0000-00-00', '', 39744, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2166, 'Active', 'CHENOV STANIMIR STEFANOV', '', '', '96713869', '', '', NULL, '0000-00-00', '', 39745, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2167, 'Active', 'ΕΛΕΝΗ  ΜΠΛΙΤΣΑ', '', '', '96955849', '', 'elenimplitsa@gmail.com', NULL, '0000-00-00', '', 39746, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2168, 'Active', 'ΓΙΩΡΓΟΣ ΤΣΙΑΤΤΑΛΟΣ', '', '', '99623873', '', '', NULL, '0000-00-00', '', 39748, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2169, 'Active', 'G.S. HOUSE MASTERS PROPERTY DEVELOPMENT LTD', '', '', '99685207', '', '', NULL, '0000-00-00', '', 39668, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2170, 'Active', 'ΑΝΤΩΝΙΑ ΚΑΛΛΙΟΠΗ ΜΠΕΛΕΓΡΙΝΗ', '', '', '94292881', '', '', NULL, '0000-00-00', '', 39749, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2171, 'Active', 'SVELTA STAMENOVA STEFANOVA', '', '', '99996007', '', '', NULL, '0000-00-00', '', 39750, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2172, 'Active', 'IVAN  IVANOV KIRILOV', '', '', '96810569', '', '', NULL, '0000-00-00', '', 39751, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2173, 'Active', 'RUSINOV  NIKOLAY', '', '', '96383883', '', '', NULL, '0000-00-00', '', 39752, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2174, 'Active', 'ORELIANO LIMITED', '', '', '96365105', '', '', NULL, '0000-00-00', '', 39801, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2175, 'Active', 'ΕΜΜΑΝΟΥΗΛ & ΚΑΛΟΜΟΙΡΑ  ΛΟΙΖΟΥ', '', '', '99388451', '', 'kalomira.loizou@cytanet.com.cy', NULL, '0000-00-00', '', 39669, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2176, 'Active', 'ΕΛΕΝΑ ΜΑΡΙΑ', '', '', '99445714', '', '', NULL, '0000-00-00', '', 39670, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2177, 'Active', 'METODI  METODIEV', '', '', '99787796', '', '', NULL, '0000-00-00', '', 39754, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2178, 'Active', 'ANNA ANDREEVA', '', '', '', '', '', NULL, '0000-00-00', '', 39652, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2179, 'Active', 'ΔΗΜΗΤΡΗΣ ΚΟΥΠΠΑΡΗΣ', '', '', '97823359', '', '', NULL, '0000-00-00', '', 39791, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2180, 'Active', 'ΒΑΣΙΛΙΚΗ ΓΡΗΓΟΡΙΟΥ', '', '', '99643164', '', '', NULL, '0000-00-00', '', 39755, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2181, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΧΑΡΑΛΑΜΠΙΔΗΣ', '', '', '99062864', '', '', NULL, '0000-00-00', '', 39756, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2182, 'Active', 'ΧΑΡΑΛΑΜΠΟΣ ΚΕΚΚΟΣ', '', '', '25339810 99484422', '', '', NULL, '0000-00-00', '', 39757, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2183, 'Active', 'ΣΥΝΩΠΗ ΠΑΠΑΔΟΠΟΥΛΟΥ ΚΕΚΚΟΥ', '', '', '99484422', '', '', NULL, '0000-00-00', '', 39758, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2184, 'Active', 'QIAN TIANYI', '', '', '96618591', '', '', NULL, '0000-00-00', '', 39653, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2185, 'Active', 'BAI YAMEI', '', '', '99109258', '', '', NULL, '0000-00-00', '', 39654, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2186, 'Active', 'ILAN UZAN', '', '', '24000300', '', '', NULL, '0000-00-00', '', 39655, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2187, 'Active', 'IVANKA  HRISTOVA', '', '', '97843424', '', '', NULL, '0000-00-00', '', 39759, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2188, 'Active', 'ΠΑΝΤΕΛΗΣ ΚΥΡΙΑΚΟΥ', '', '', '24533373', '', '', NULL, '0000-00-00', '', 39761, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2189, 'Active', 'YASMEEN MOHAMED ALI GOMAA ABOUHASHISH', '', '', '', '', '', NULL, '0000-00-00', '', 39656, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2190, 'Active', 'HUSSEIN MOHAMED ALI GOMAA ABOUHASHISH', '', '', '', '', '', NULL, '0000-00-00', '', 39657, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2191, 'Active', 'ΜΑΡΙΑΝΝΑ  ΖΑΝΝΕΤΤΗ', '', '', '99407917', '', '', NULL, '0000-00-00', '', 39642, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2192, 'Active', 'ΑΝΔΡΕΑΣ ΠΙΠΕΡΙΔΗΣ', '', '', '99567825', '', '', NULL, '0000-00-00', '', 39763, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2193, 'Active', 'ΛΕΑΝΔΡΟΣ ΛΑΖΑΡΟΥ', '', '', '99581246', '', '', NULL, '0000-00-00', '', 39939, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2194, 'Active', 'ΠΑΝΑΓΙΩΤΗΣ ΠΑΡΑΣΚΕΥΟΠΟΥΛΟΣ', '', '', '96126831', '', '', NULL, '0000-00-00', '', 39764, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2195, 'Active', 'ΕΥΑΓΓΕΛΟΣ ΔΗΜΗΤΡΙΑΔΗΣ', '', '', '99628359', '', 'classK.larnaka@gmail.com', NULL, '0000-00-00', '', 39765, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2196, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ  ΠΑΝΑΓΙΩΤΟΥ', '', '', '96824512', '', '', NULL, '0000-00-00', '', 39796, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2197, 'Active', 'ΓΙΩΡΓΟΣ  ΕΥΑΓΓΕΛΟΥ', '', '', '99230750', '', '', NULL, '0000-00-00', '', 39767, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2198, 'Active', 'A&C PAPANICOLAOU INSURANCE AGENCY & CONSULTANTS LT', '', '', '99631278', '', '', NULL, '0000-00-00', '', 39797, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2199, 'Active', 'ΑΙΚΑΤΕΡΙΝΗ ΜΑΡΟΚΟΥ', '', '', '99185128', '', '', NULL, '0000-00-00', '', 39768, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2200, 'Active', 'DANY BOU SALEH', '', '', '24000300', '', '', NULL, '0000-00-00', '', 39658, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2201, 'Active', 'KARAM THERESE', '', '', '24000300', '', '', NULL, '0000-00-00', '', 39659, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2202, 'Active', 'ΚΩΣΤΑΣ ΦΛΟΥΡΕΝΤΖΟΥ', '', '', '99448470', '', '', NULL, '0000-00-00', '', 39771, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2203, 'Active', 'ΚΥΡΙΑΚΟΣ  ΑΔΑΜΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40092, '2020-01-05 13:27:33', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2204, 'Active', 'ΑΓΙΣ ΟΙΚΟΝΟΜΙΔΗΣ', '', '', '99643109', '', '', NULL, '0000-00-00', '', 39666, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2205, 'Active', 'NYAGOLOV HRISTO DIMITROV', '', '', '96322248', '', '', NULL, '0000-00-00', '', 39772, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2206, 'Active', 'ΑΝΑΣΤΑΣΙΟΣ  ΜΠΑΛΟΓΛΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40093, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2207, 'Active', 'ΓΕΩΡΓΙΟΣ  ΑΝΤΩΝΙΑΔΗΣ', '', '', '', '', '', NULL, '0000-00-00', '', 40094, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2208, 'Active', 'ΠΕΤΡΟΣ ΧΡΙΣΤΟΔΟΥΛΟΥ', '', '', '', '', '', NULL, '0000-00-00', '', 40112, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2209, 'Active', 'DICRAN OUZOUNIAN AND COMPANY LTD', '', '', '', '', '', NULL, '0000-00-00', '', 40095, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2210, 'Active', 'ΣΤΕΛΛΑ  ΚΑΛΟΥΔΗ', '', '', '99017165', '', '', NULL, '0000-00-00', '', 40070, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2211, 'Active', 'ΔΕΣΠΟΙΝΑ ΦΡΑΓΚΟΥ', '', '', '96544617', '', '', NULL, '0000-00-00', '', 39773, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2212, 'Active', 'ΑΓΓΕΛΑ ΒΑΣΙΛΗ  & ΛΥΣΑΝΔΡΟΣ ΛΥΣΑΝΔΡΟΥ', '', '', '97877425', '', 'lysandroscy@hotmail.com', NULL, '0000-00-00', '', 39774, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2213, 'Active', 'CHRISTAKIS CHRISTODOULOU', '', '', '99635137', '22377155', 'cchristodoulou666@gmail.com', NULL, '0000-00-00', '', 39807, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2214, 'Active', 'ΛΕΟΝΤΙΟΣ ΜΙΧΑΗΛ', '', '', '99653593', '', '', NULL, '0000-00-00', '', 39775, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2215, 'Active', 'ΓΕΩΡΓΙΑ  ΑΛΕΞΑΝΔΡΟΥ ΑΛΕΞΑΝΔΡΟΥ', '', '', '99682194', '', '', NULL, '0000-00-00', '', 39682, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2216, 'Active', 'ΓΙΩΡΓΟΣ  ΧΑΡΑΛΑΜΠΟΥΣ', '', '', '99886300', '', '', NULL, '0000-00-00', '', 39777, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2217, 'Active', 'ΓΕΩΡΓΙΑ  ΚΩNΣΤΑΝΤΙΝΟΥ', '', '', '99031348', '', '', NULL, '0000-00-00', '', 39778, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2218, 'Active', 'ΣΟΦΙΑ ΑΔΑΜ', '', '', '97718002', '', '', NULL, '0000-00-00', '', 39779, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2219, 'Active', 'ΚΩΝΣΤΑΝΤΙΝΟΣ ΧΑΤΖΗΧΡΙΣΤΟΦΟΡΟΥ', '', '', '99770927', '', '', NULL, '0000-00-00', '', 39780, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2220, 'Active', 'ΕΛΙΣΑΒΕΤ ΚΑΠΑΚΙΩΤΗ', '', '', '22757173 99625934', '', 'elizabeth.kapakiotis@marathontrading.com', NULL, '0000-00-00', '', 39644, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2221, 'Active', 'KARIYAWASAM WARUWANGODAGE NADEESHA', '', '', '22757173', '', '', NULL, '0000-00-00', '', 39660, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2222, 'Active', 'ΓΕΩΡΓΙΟΣ ΛΕΜΕΣΙΗΣ', '', '', '99309855', '', 'geolemesiis1992@gmail.com', NULL, '0000-00-00', '', 40040, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2223, 'Active', 'ΔΗΜΗΤΡΗΣ ΛΙΠΕΡΤΗ', '', '', '99039695', '', '', NULL, '0000-00-00', '', 39781, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2224, 'Active', 'ΑΠΟΣΤΟΛΟΥ ΝΙΚΟΛΑΟΣ', '', '', '99789361', '', '', NULL, '0000-00-00', '', 39782, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2225, 'Active', 'ΕΛΕΝΑ ΣΩΤΗΡΙΟΥ ΚΑΙ  ΜΙΧΑΛΗΣ ΚΟΚΚΙΝΟΦΤΑ', '', '', '99754545', '', '', NULL, '0000-00-00', '', 39671, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2226, 'Active', 'TAEKWON DO CLUB GEORGE', '', '', '99872524', '', '', NULL, '0000-00-00', '', 39683, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2227, 'Active', 'ΗΛΙΑΝΑ ΓΡΗΓΟΡΙΟΥ', '', '', '99153412', '', '', NULL, '0000-00-00', '', 39672, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2228, 'Active', 'ELYMPUS AUDIT LTD', '', '', '99653615', '', '', NULL, '0000-00-00', '', 39803, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2229, 'Active', 'ANNA IOANNOU', '', '', '97851484', '', 'dr.ioannouanna@gmail.com', NULL, '0000-00-00', '', 39808, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2230, 'Active', 'ΘΕΟΦΑΝΗΣ ΧΑΤΖΗΜΙΧΑΗΛ', '', '', '99298889', '', '', NULL, '0000-00-00', '', 39783, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2231, 'Active', 'ΧΡΙΣΤΙΝΑ ΧΡΙΣΤΟΦΗ', '', '', '99812398', '', '', NULL, '0000-00-00', '', 39784, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2232, 'Active', 'KARINE BONNAUD', '', '', '99799225', '', '', NULL, '0000-00-00', '', 39664, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2233, 'Active', 'ΦΟΙΒΟΣ ΧΑΤΖΗΜΙΤΣΗΣ', '', '', '96457624', '', 'fivosHadjimitsis@gmail.com', NULL, '0000-00-00', '', 39665, '2020-01-05 13:27:34', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2234, 'Active', 'Agent 1', '', '', '', '', '', '', '0000-00-00', '', NULL, '2020-03-16 10:35:05', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2235, 'Active', 'Agent 2', '', '', '', '', '', '', '0000-00-00', '', NULL, '2020-03-16 10:35:12', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2236, 'Active', 'Clary Skarpantoni', '', '', '', '', '', '', '0000-00-00', '', NULL, '2020-03-20 16:37:39', 1, NULL, NULL);
INSERT INTO `ac_entities` VALUES (2237, 'Active', 'Test Customer', 'Test - Customer', '', '', '', '', '', NULL, NULL, NULL, '2020-03-20 17:18:44', 6, NULL, NULL);

-- ----------------------------
-- Table structure for ac_settings
-- ----------------------------
DROP TABLE IF EXISTS `ac_settings`;
CREATE TABLE `ac_settings`  (
  `acstg_setting_ID` int(8) NOT NULL AUTO_INCREMENT,
  `acstg_bs_assets_accounts` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `acstg_auto_ac_debtors_control_ID` int(8) NULL DEFAULT NULL,
  `acstg_auto_ac_creditors_control_ID` int(8) NULL DEFAULT NULL,
  `acstg_auto_account_suffix_num` int(2) NULL DEFAULT NULL,
  `acstg_created_on` datetime(0) NULL DEFAULT NULL,
  `acstg_created_by` int(8) NULL DEFAULT NULL,
  `acstg_last_update_on` datetime(0) NULL DEFAULT NULL,
  `acstg_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`acstg_setting_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_settings
-- ----------------------------
INSERT INTO `ac_settings` VALUES (1, NULL, 25, 26, 3, NULL, 1, NULL, 1);

-- ----------------------------
-- Table structure for ac_transaction_lines
-- ----------------------------
DROP TABLE IF EXISTS `ac_transaction_lines`;
CREATE TABLE `ac_transaction_lines`  (
  `actrl_transaction_line_ID` int(8) NOT NULL AUTO_INCREMENT,
  `actrl_transaction_ID` int(8) NULL DEFAULT NULL,
  `actrl_account_ID` int(8) NULL DEFAULT NULL,
  `actrl_line_number` int(3) NULL DEFAULT NULL,
  `actrl_dr_cr` int(1) NULL DEFAULT NULL COMMENT 'if is -1 then credit if 1 then debit.',
  `actrl_value` decimal(10, 2) NOT NULL DEFAULT 0,
  `actrl_reference` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `actrl_created_date_time` datetime(0) NULL DEFAULT NULL,
  `actrl_created_by` int(8) NULL DEFAULT NULL,
  `actrl_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `actrl_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`actrl_transaction_line_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 482 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_transaction_lines
-- ----------------------------
INSERT INTO `ac_transaction_lines` VALUES (1, 1, 25, 1, 1, 33.00, '', '2019-10-15 10:31:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (2, 1, 22, 2, -1, 33.00, '', '2019-10-15 10:31:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (3, 1, 27, 3, 1, 21.00, '', '2019-10-15 10:31:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (4, 1, 26, 4, -1, 21.00, '', '2019-10-15 10:31:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (5, 2, 28, 1, 1, 15000.00, '', '2019-10-15 11:08:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (6, 2, 29, 2, -1, 15000.00, '', '2019-10-15 11:08:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (7, 3, 30, 1, -1, 2500.00, '', '2019-10-15 11:56:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (8, 3, 28, 2, 1, 2500.00, '', '2019-10-15 11:56:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (9, 4, 25, 1, 1, 153.00, '', '2019-10-18 12:16:57', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (10, 4, 22, 2, -1, 153.00, '', '2019-10-18 12:16:57', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (11, 4, 27, 3, 1, 117.00, '', '2019-10-18 12:16:57', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (12, 4, 26, 4, -1, 117.00, '', '2019-10-18 12:16:57', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (13, 5, 18, 1, 1, 500.00, '', '2019-10-21 16:29:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (14, 5, 30, 2, -1, 500.00, '', '2019-10-21 16:29:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (16, 6, 24, 1, 1, 100.00, '1111', '2019-11-01 15:06:03', 1, '2019-11-01 15:39:34', 1);
INSERT INTO `ac_transaction_lines` VALUES (17, 6, 22, 2, -1, 150.00, '3333', '2019-11-01 15:06:03', 1, '2019-11-01 15:43:53', 1);
INSERT INTO `ac_transaction_lines` VALUES (19, 6, 21, 3, 1, 50.00, '', '2019-11-01 15:43:53', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (20, 7, 24, 1, -1, 100.00, '', '2019-11-01 15:59:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (21, 7, 37, 2, 1, 100.00, '', '2019-11-01 15:59:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (22, 8, 40, 1, 1, 100.00, '', '2019-11-06 12:16:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (23, 8, 32, 2, -1, 100.00, '', '2019-11-06 12:16:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (24, 9, 37, 1, 1, 75.00, '', '2019-11-06 12:23:02', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (25, 9, 34, 2, -1, 75.00, '', '2019-11-06 12:23:02', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (26, 10, 56, 1, 1, 33.00, '', '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (27, 10, 57, 2, -1, 33.00, '', '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (28, 10, 27, 3, 1, 11.00, '', '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (29, 10, 62, 4, -1, 11.00, '', '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (30, 10, 59, 5, 1, 11.00, '', '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (31, 10, 60, 6, -1, 11.00, '', '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (32, 11, 56, 1, 1, 24.00, '', '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (33, 11, 57, 2, -1, 24.00, '', '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (34, 11, 21, 3, 1, 9.00, '', '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (35, 11, 63, 4, -1, 9.00, '', '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (36, 11, 27, 5, 1, 9.00, '', '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (37, 11, 62, 6, -1, 9.00, '', '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (38, 12, 56, 1, 1, 24.00, '', '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (39, 12, 57, 2, -1, 24.00, '', '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (40, 13, 21, 1, 1, 9.00, '', '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (41, 13, 63, 2, -1, 9.00, '', '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (42, 14, 27, 1, 1, 9.00, '', '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (43, 14, 62, 2, -1, 9.00, '', '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (44, 15, 56, 1, 1, 24.00, '', '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (45, 15, 57, 2, -1, 24.00, '', '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (46, 16, 21, 1, 1, 9.00, '', '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (47, 16, 63, 2, -1, 9.00, '', '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (48, 17, 27, 1, 1, 9.00, '', '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (49, 17, 62, 2, -1, 9.00, '', '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (52, 19, 56, 1, 1, 24.00, '', '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (53, 19, 57, 2, -1, 24.00, '', '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (54, 20, 21, 1, 1, 9.00, '', '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (55, 20, 63, 2, -1, 9.00, '', '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (56, 21, 27, 1, 1, 9.00, '', '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (57, 21, 62, 2, -1, 9.00, '', '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (118, 52, 56, 1, 1, 22.00, '', '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (119, 52, 57, 2, -1, 22.00, '', '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (120, 53, 21, 1, 1, 8.12, '', '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (121, 53, 63, 2, -1, 8.12, '', '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (122, 54, 27, 1, 1, 8.12, '', '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (123, 54, 62, 2, -1, 8.12, '', '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (124, 55, 56, 1, 1, 22.00, '', '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (125, 55, 57, 2, -1, 22.00, '', '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (126, 56, 21, 1, 1, 8.12, '', '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (127, 56, 63, 2, -1, 8.12, '', '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (128, 57, 27, 1, 1, 8.24, '', '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (129, 57, 62, 2, -1, 8.24, '', '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (130, 58, 56, 1, 1, 22.00, '', '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (131, 58, 57, 2, -1, 22.00, '', '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (132, 59, 21, 1, 1, 8.12, '', '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (133, 59, 63, 2, -1, 8.12, '', '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (134, 60, 27, 1, 1, 8.24, '', '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (135, 60, 62, 2, -1, 8.24, '', '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (136, 61, 56, 1, 1, 9.70, '', '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (137, 61, 57, 2, -1, 9.70, '', '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (138, 62, 21, 1, 1, 3.58, '', '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (139, 62, 63, 2, -1, 3.58, '', '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (140, 63, 27, 1, 1, 3.63, '', '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (141, 63, 62, 2, -1, 3.63, '', '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (142, 64, 56, 1, 1, 4.84, '', '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (143, 64, 57, 2, -1, 4.84, '', '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (144, 65, 21, 1, 1, 1.79, '', '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (145, 65, 63, 2, -1, 1.79, '', '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (146, 66, 27, 1, 1, 1.81, '', '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (147, 66, 62, 2, -1, 1.81, '', '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (148, 67, 56, 1, 1, 7.46, '', '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (149, 67, 57, 2, -1, 7.46, '', '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (150, 68, 21, 1, 1, 2.75, '', '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (151, 68, 63, 2, -1, 2.75, '', '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (152, 69, 27, 1, 1, 2.79, '', '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (153, 69, 62, 2, -1, 2.79, '', '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (154, 70, 56, 1, 1, 9.70, '', '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (155, 70, 57, 2, -1, 9.70, '', '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (156, 71, 21, 1, 1, 3.58, '', '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (157, 71, 63, 2, -1, 3.58, '', '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (158, 72, 27, 1, 1, 3.63, '', '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (159, 72, 62, 2, -1, 3.63, '', '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (160, 73, 68, 1, 1, 27.31, '', '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (161, 73, 69, 2, -1, 27.31, '', '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (162, 74, 21, 1, 1, 0.00, '', '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (163, 74, 63, 2, -1, 0.00, '', '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (164, 75, 27, 1, 1, 0.00, '', '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (165, 75, 62, 2, -1, 0.00, '', '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (166, 76, 66, 1, 1, 51.96, '', '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (167, 76, 67, 2, -1, 51.96, '', '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (168, 77, 21, 1, 1, 11.55, '', '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (169, 77, 63, 2, -1, 11.55, '', '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (170, 78, 27, 1, 1, 17.32, '', '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (171, 78, 62, 2, -1, 17.32, '', '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (172, 79, 66, 1, 1, 51.97, '', '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (173, 79, 67, 2, -1, 51.97, '', '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (174, 80, 21, 1, 1, 11.55, '', '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (175, 80, 63, 2, -1, 11.55, '', '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (176, 81, 27, 1, 1, 17.32, '', '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (177, 81, 62, 2, -1, 17.32, '', '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (178, 82, 66, 1, 1, 22.50, '', '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (179, 82, 67, 2, -1, 22.50, '', '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (180, 83, 70, 1, 1, 25.00, '', '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (181, 83, 72, 2, -1, 25.00, '', '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (182, 84, 71, 1, 1, 25.00, '', '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (183, 84, 73, 2, -1, 25.00, '', '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (184, 85, 66, 1, 1, 22.50, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (185, 85, 67, 2, -1, 22.50, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (186, 86, 70, 1, 1, 8.75, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (187, 86, 72, 2, -1, 8.75, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (188, 87, 71, 1, 1, 5.00, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (189, 87, 73, 2, -1, 5.00, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (190, 88, 59, 1, 1, 5.00, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (191, 88, 60, 2, -1, 5.00, '', '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (192, 89, 66, 1, 1, 22.50, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (193, 89, 67, 2, -1, 22.50, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (194, 90, 70, 1, 1, 8.75, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (195, 90, 72, 2, -1, 8.75, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (196, 91, 71, 1, 1, 5.00, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (197, 91, 73, 2, -1, 5.00, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (198, 92, 59, 1, 1, 5.00, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (199, 92, 60, 2, -1, 5.00, '', '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (200, 93, 66, 1, 1, 8.17, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (201, 93, 67, 2, -1, 8.17, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (202, 94, 70, 1, 1, 3.17, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (203, 94, 72, 2, -1, 3.17, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (204, 95, 71, 1, 1, 1.81, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (205, 95, 73, 2, -1, 1.81, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (206, 96, 59, 1, 1, 1.81, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (207, 96, 60, 2, -1, 1.81, '', '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (208, 97, 66, 1, 1, 3.20, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (209, 97, 67, 2, -1, 3.20, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (210, 98, 70, 1, 1, 1.24, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (211, 98, 72, 2, -1, 1.24, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (212, 99, 71, 1, 1, 0.71, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (213, 99, 73, 2, -1, 0.71, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (214, 100, 59, 1, 1, 0.71, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (215, 100, 60, 2, -1, 0.71, '', '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (216, 101, 66, 1, 1, 50.00, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (217, 101, 67, 2, -1, 50.00, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (218, 102, 70, 1, 1, 11.87, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (219, 102, 72, 2, -1, 11.87, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (220, 103, 71, 1, 1, 11.87, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (221, 103, 73, 2, -1, 11.87, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (222, 104, 59, 1, 1, 11.87, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (223, 104, 60, 2, -1, 11.87, '', '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (224, 105, 66, 1, 1, 63.33, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (225, 105, 67, 2, -1, 63.33, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (226, 106, 70, 1, 1, 15.04, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (227, 106, 72, 2, -1, 15.04, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (228, 107, 71, 1, 1, 15.04, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (229, 107, 73, 2, -1, 15.04, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (230, 108, 59, 1, 1, 15.04, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (231, 108, 60, 2, -1, 15.04, '', '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (232, 109, 66, 1, 1, 90.43, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (233, 109, 67, 2, -1, 90.43, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (234, 110, 70, 1, 1, 22.60, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (235, 110, 72, 2, -1, 22.60, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (236, 111, 71, 1, 1, 22.60, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (237, 111, 73, 2, -1, 22.60, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (238, 112, 59, 1, 1, 22.60, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (239, 112, 60, 2, -1, 22.60, '', '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (240, 113, 66, 1, 1, 100.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (241, 113, 67, 2, -1, 100.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (242, 114, 70, 1, 1, 23.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (243, 114, 72, 2, -1, 23.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (244, 115, 71, 1, 1, 24.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (245, 115, 73, 2, -1, 24.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (246, 116, 59, 1, 1, 25.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (247, 116, 60, 2, -1, 25.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (248, 117, 21, 1, 1, 15.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (249, 117, 63, 2, -1, 15.00, '', '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (250, 118, 66, 1, 1, 54.00, '', '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (251, 118, 67, 2, -1, 54.00, '', '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (252, 119, 70, 1, 1, 20.25, '', '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (253, 119, 72, 2, -1, 20.25, '', '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (254, 120, 27, 1, 1, 2.97, '', '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (255, 120, 62, 2, -1, 2.97, '', '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (256, 121, 66, 1, 1, 43.34, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (257, 121, 67, 2, -1, 43.34, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (258, 122, 70, 1, 1, 8.66, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (259, 122, 72, 2, -1, 8.66, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (260, 123, 71, 1, 1, 9.53, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (261, 123, 73, 2, -1, 9.53, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (262, 124, 59, 1, 1, 10.83, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (263, 124, 60, 2, -1, 10.83, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (264, 125, 21, 1, 1, 6.50, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (265, 125, 63, 2, -1, 6.50, '', '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (266, 126, 66, 1, 1, 86.66, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (267, 126, 67, 2, -1, 86.66, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (268, 127, 70, 1, 1, 17.33, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (269, 127, 72, 2, -1, 17.33, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (270, 128, 71, 1, 1, 19.06, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (271, 128, 73, 2, -1, 19.06, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (272, 129, 59, 1, 1, 21.66, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (273, 129, 60, 2, -1, 21.66, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (274, 130, 21, 1, 1, 12.99, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (275, 130, 63, 2, -1, 12.99, '', '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (276, 131, 66, 1, 1, 40.00, '', '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (277, 131, 67, 2, -1, 40.00, '', '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (278, 132, 70, 1, 1, 30.00, '', '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (279, 132, 72, 2, -1, 30.00, '', '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (280, 133, 27, 1, 1, 4.00, '', '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (281, 133, 62, 2, -1, 4.00, '', '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (282, 134, 56, 1, 1, 62.22, '', '2020-04-16 10:25:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (283, 134, 57, 2, -1, 62.22, '', '2020-04-16 10:25:04', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (284, 135, 66, 1, 1, -40.00, '', '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (285, 135, 67, 2, -1, -40.00, '', '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (286, 136, 70, 1, 1, 0.00, '', '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (287, 136, 72, 2, -1, 0.00, '', '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (288, 137, 27, 1, 1, 0.00, '', '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (289, 137, 62, 2, -1, 0.00, '', '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (290, 138, 66, 1, 1, -40.00, '', '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (291, 138, 67, 2, -1, -40.00, '', '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (292, 139, 70, 1, 1, 30.00, '', '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (293, 139, 72, 2, -1, 30.00, '', '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (294, 140, 27, 1, 1, 4.00, '', '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (295, 140, 62, 2, -1, 4.00, '', '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (296, 141, 66, 1, 1, -40.00, '', '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (297, 141, 67, 2, -1, -40.00, '', '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (298, 142, 70, 1, 1, -30.00, '', '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (299, 142, 72, 2, -1, -30.00, '', '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (300, 143, 27, 1, 1, -4.00, '', '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (301, 143, 62, 2, -1, -4.00, '', '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (302, 144, 66, 1, 1, 25.00, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (303, 144, 67, 2, -1, 25.00, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (304, 145, 70, 1, 1, 5.75, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (305, 145, 72, 2, -1, 5.75, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (306, 146, 71, 1, 1, 6.00, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (307, 146, 73, 2, -1, 6.00, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (308, 147, 59, 1, 1, 6.25, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (309, 147, 60, 2, -1, 6.25, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (310, 148, 21, 1, 1, 3.75, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (311, 148, 63, 2, -1, 3.75, '', '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (312, 149, 66, 1, 1, 18.33, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (313, 149, 67, 2, -1, 18.33, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (314, 150, 70, 1, 1, 4.30, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (315, 150, 72, 2, -1, 4.30, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (316, 151, 71, 1, 1, 4.49, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (317, 151, 73, 2, -1, 4.49, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (318, 152, 59, 1, 1, 4.68, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (319, 152, 60, 2, -1, 4.68, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (320, 153, 21, 1, 1, 2.80, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (321, 153, 63, 2, -1, 2.80, '', '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (322, 154, 66, 1, 1, 18.33, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (323, 154, 67, 2, -1, 18.33, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (324, 155, 70, 1, 1, 4.30, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (325, 155, 72, 2, -1, 4.30, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (326, 156, 71, 1, 1, 4.49, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (327, 156, 73, 2, -1, 4.49, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (328, 157, 59, 1, 1, 4.68, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (329, 157, 60, 2, -1, 4.68, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (330, 158, 21, 1, 1, 2.80, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (331, 158, 63, 2, -1, 2.80, '', '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (332, 159, 66, 1, 1, 18.34, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (333, 159, 67, 2, -1, 18.34, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (334, 160, 70, 1, 1, 4.30, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (335, 160, 72, 2, -1, 4.30, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (336, 161, 71, 1, 1, 4.49, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (337, 161, 73, 2, -1, 4.49, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (338, 162, 59, 1, 1, 4.68, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (339, 162, 60, 2, -1, 4.68, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (340, 163, 21, 1, 1, 2.80, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (341, 163, 63, 2, -1, 2.80, '', '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (342, 164, 66, 1, 1, 25.00, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (343, 164, 67, 2, -1, 25.00, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (344, 165, 70, 1, 1, 6.25, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (345, 165, 72, 2, -1, 6.25, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (346, 166, 71, 1, 1, 6.25, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (347, 166, 73, 2, -1, 6.25, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (348, 167, 59, 1, 1, 6.25, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (349, 167, 60, 2, -1, 6.25, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (350, 168, 21, 1, 1, 3.75, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (351, 168, 63, 2, -1, 3.75, '', '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (352, 169, 66, 1, 1, 18.33, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (353, 169, 67, 2, -1, 18.33, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (354, 170, 70, 1, 1, 10.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (355, 170, 72, 2, -1, 10.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (356, 171, 71, 1, 1, 10.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (357, 171, 73, 2, -1, 10.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (358, 172, 59, 1, 1, 10.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (359, 172, 60, 2, -1, 10.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (360, 173, 21, 1, 1, 6.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (361, 173, 63, 2, -1, 6.00, '', '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (362, 174, 66, 1, 1, 25.00, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (363, 174, 67, 2, -1, 25.00, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (364, 175, 70, 1, 1, 6.25, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (365, 175, 72, 2, -1, 6.25, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (366, 176, 71, 1, 1, 6.25, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (367, 176, 73, 2, -1, 6.25, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (368, 177, 59, 1, 1, 6.25, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (369, 177, 60, 2, -1, 6.25, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (370, 178, 21, 1, 1, 3.75, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (371, 178, 63, 2, -1, 3.75, '', '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (372, 179, 66, 1, 1, 25.00, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (373, 179, 67, 2, -1, 25.00, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (374, 180, 70, 1, 1, 6.25, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (375, 180, 72, 2, -1, 6.25, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (376, 181, 71, 1, 1, 6.25, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (377, 181, 73, 2, -1, 6.25, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (378, 182, 59, 1, 1, 6.25, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (379, 182, 60, 2, -1, 6.25, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (380, 183, 21, 1, 1, 3.75, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (381, 183, 63, 2, -1, 3.75, '', '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (382, 184, 66, 1, 1, 18.33, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (383, 184, 67, 2, -1, 18.33, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (384, 185, 70, 1, 1, 4.58, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (385, 185, 72, 2, -1, 4.58, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (386, 186, 71, 1, 1, 4.58, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (387, 186, 73, 2, -1, 4.58, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (388, 187, 59, 1, 1, 4.58, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (389, 187, 60, 2, -1, 4.58, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (390, 188, 21, 1, 1, 4.00, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (391, 188, 63, 2, -1, 4.00, '', '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (392, 189, 66, 1, 1, 18.33, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (393, 189, 67, 2, -1, 18.33, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (394, 190, 70, 1, 1, 4.58, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (395, 190, 72, 2, -1, 4.58, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (396, 191, 71, 1, 1, 4.58, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (397, 191, 73, 2, -1, 4.58, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (398, 192, 59, 1, 1, 4.58, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (399, 192, 60, 2, -1, 4.58, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (400, 193, 21, 1, 1, 0.00, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (401, 193, 63, 2, -1, 0.00, '', '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (402, 194, 66, 1, 1, 18.34, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (403, 194, 67, 2, -1, 18.34, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (404, 195, 70, 1, 1, 4.59, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (405, 195, 72, 2, -1, 4.59, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (406, 196, 71, 1, 1, 4.59, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (407, 196, 73, 2, -1, 4.59, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (408, 197, 59, 1, 1, 4.59, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (409, 197, 60, 2, -1, 4.59, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (410, 198, 21, 1, 1, 0.50, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (411, 198, 63, 2, -1, 0.50, '', '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (412, 199, 66, 1, 1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (413, 199, 67, 2, -1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (414, 200, 70, 1, 1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (415, 200, 72, 2, -1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (416, 201, 71, 1, 1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (417, 201, 73, 2, -1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (418, 202, 59, 1, 1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (419, 202, 60, 2, -1, -25.00, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (420, 203, 21, 1, 1, -18.75, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (421, 203, 63, 2, -1, -18.75, '', '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (422, 204, 66, 1, 1, 25.00, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (423, 204, 67, 2, -1, 25.00, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (424, 205, 70, 1, 1, 6.25, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (425, 205, 72, 2, -1, 6.25, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (426, 206, 71, 1, 1, 6.25, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (427, 206, 73, 2, -1, 6.25, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (428, 207, 59, 1, 1, 6.25, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (429, 207, 60, 2, -1, 6.25, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (430, 208, 21, 1, 1, 3.75, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (431, 208, 63, 2, -1, 3.75, '', '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (432, 209, 66, 1, 1, 75.00, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (433, 209, 67, 2, -1, 75.00, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (434, 210, 70, 1, 1, 18.75, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (435, 210, 72, 2, -1, 18.75, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (436, 211, 71, 1, 1, 18.75, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (437, 211, 73, 2, -1, 18.75, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (438, 212, 59, 1, 1, 18.75, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (439, 212, 60, 2, -1, 18.75, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (440, 213, 21, 1, 1, 11.25, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (441, 213, 63, 2, -1, 11.25, '', '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (442, 214, 66, 1, 1, -20.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (443, 214, 67, 2, -1, -20.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (444, 215, 70, 1, 1, -55.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (445, 215, 72, 2, -1, -55.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (446, 216, 71, 1, 1, -55.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (447, 216, 73, 2, -1, -55.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (448, 217, 59, 1, 1, -55.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (449, 217, 60, 2, -1, -55.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (450, 218, 21, 1, 1, -33.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (451, 218, 63, 2, -1, -33.00, '', '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (452, 219, 66, 1, 1, 35.59, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (453, 219, 67, 2, -1, 35.59, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (454, 220, 70, 1, 1, 8.89, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (455, 220, 72, 2, -1, 8.89, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (456, 221, 71, 1, 1, 8.89, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (457, 221, 73, 2, -1, 8.89, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (458, 222, 59, 1, 1, 8.89, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (459, 222, 60, 2, -1, 8.89, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (460, 223, 21, 1, 1, 5.33, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (461, 223, 63, 2, -1, 5.33, '', '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (462, 224, 66, 1, 1, 44.41, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (463, 224, 67, 2, -1, 44.41, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (464, 225, 70, 1, 1, 11.11, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (465, 225, 72, 2, -1, 11.11, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (466, 226, 71, 1, 1, 11.11, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (467, 226, 73, 2, -1, 11.11, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (468, 227, 59, 1, 1, 11.11, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (469, 227, 60, 2, -1, 11.11, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (470, 228, 21, 1, 1, 1.34, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (471, 228, 63, 2, -1, 1.34, '', '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (472, 229, 66, 1, 1, -20.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (473, 229, 67, 2, -1, -20.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (474, 230, 70, 1, 1, -5.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (475, 230, 72, 2, -1, -5.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (476, 231, 71, 1, 1, -5.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (477, 231, 73, 2, -1, -5.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (478, 232, 59, 1, 1, -5.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (479, 232, 60, 2, -1, -5.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (480, 233, 21, 1, 1, -3.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transaction_lines` VALUES (481, 233, 63, 2, -1, -3.00, '', '2020-04-16 14:43:47', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ac_transactions
-- ----------------------------
DROP TABLE IF EXISTS `ac_transactions`;
CREATE TABLE `ac_transactions`  (
  `actrn_transaction_ID` int(11) NOT NULL AUTO_INCREMENT,
  `actrn_document_ID` int(11) NULL DEFAULT NULL,
  `actrn_entity_ID` int(11) NULL DEFAULT NULL,
  `actrn_status` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Outstanding,Active,Locked',
  `actrn_transaction_number` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `actrn_transaction_date` date NULL DEFAULT NULL,
  `actrn_reference_date` date NULL DEFAULT NULL,
  `actrn_period` int(2) NULL DEFAULT NULL,
  `actrn_year` int(4) NULL DEFAULT NULL COMMENT 'if purchase then -1 sale 1. if its dr or cr the account in transaction',
  `actrn_activated_on` datetime(0) NULL DEFAULT NULL,
  `actrn_comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `actrn_from_module` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `actrn_from_ID_description` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `actrn_from_ID` int(8) NULL DEFAULT NULL,
  `actrn_created_date_time` datetime(0) NULL DEFAULT NULL,
  `actrn_created_by` int(8) NULL DEFAULT NULL,
  `actrn_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `actrn_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`actrn_transaction_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 234 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_transactions
-- ----------------------------
INSERT INTO `ac_transactions` VALUES (1, 3, 25, 'Active', 'INSCOM-000000', '2019-10-15', '2019-10-15', 7, 2019, '2019-10-15 13:33:00', '', 'AInsurance', 'PolicyID', 22, '2019-10-15 10:31:19', 1, '2019-10-15 13:33:00', 1);
INSERT INTO `ac_transactions` VALUES (2, 1, 29, 'Active', 'JSE-000001', '2019-10-15', '2019-10-15', 7, 2019, '2019-10-15 11:08:20', '', NULL, NULL, NULL, '2019-10-15 11:08:04', 1, '2019-10-15 11:08:20', 1);
INSERT INTO `ac_transactions` VALUES (3, 1, 30, 'Active', 'JSE-000001', '2019-10-15', '2019-10-15', 7, 2019, '2019-10-15 11:56:19', '', NULL, NULL, NULL, '2019-10-15 11:56:12', 1, '2019-10-15 11:56:19', 1);
INSERT INTO `ac_transactions` VALUES (4, 3, 25, 'Active', 'INSCOM-000000', '2019-10-18', '2019-10-18', 10, 2019, '2019-10-18 12:17:19', 'Policy ID:23 Commissions', 'AInsurance', 'PolicyID', 23, '2019-10-18 12:16:57', 1, '2019-10-18 12:17:19', 1);
INSERT INTO `ac_transactions` VALUES (5, 1, 2, 'Active', 'JSE-000001', '2019-10-21', '2019-10-21', 7, 2019, '2019-11-01 15:58:37', '', NULL, NULL, NULL, '2019-10-21 16:29:07', 1, '2019-11-01 15:58:37', 1);
INSERT INTO `ac_transactions` VALUES (6, 2, 1, 'Active', 'JSE-000001', '2019-11-01', '2019-11-01', 7, 2019, '2019-11-01 15:58:17', '', NULL, NULL, NULL, '2019-11-01 10:39:16', 1, '2019-11-01 15:58:17', 1);
INSERT INTO `ac_transactions` VALUES (7, 1, 1, 'Outstanding', 'JSE-000001', '2019-11-01', '2019-11-01', 7, 2019, NULL, '', NULL, NULL, NULL, '2019-11-01 15:59:42', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (8, 1, 5, 'Outstanding', 'JSE-000001', '2019-11-06', '2019-11-06', 7, 2019, NULL, '', NULL, NULL, NULL, '2019-11-06 12:16:55', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (9, 2, 1, 'Outstanding', 'JCCCP-000000', '2019-11-06', '2019-11-06', 7, 2019, NULL, '', NULL, NULL, NULL, '2019-11-06 12:23:02', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (10, 3, 12, 'Outstanding', 'INSCOM-000000', '2019-11-19', '2019-11-19', 11, 2019, NULL, 'Policy ID:25 Commissions', 'AInsurance', 'PolicyID', 25, '2019-11-19 14:25:21', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (11, 3, 12, 'Outstanding', 'INSCOM-000000', '2019-11-19', '2019-11-19', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-19 16:56:48', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (12, 3, 12, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (13, 3, 0, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (14, 3, 0, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:03:54', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (15, 3, 12, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (16, 3, 0, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (17, 3, 0, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:05:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (19, 3, 12, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (20, 3, 14, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (21, 3, 1, 'Outstanding', 'INSCOM-000000', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:12:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (52, 3, 12, 'Outstanding', 'INSCOM-000001', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (53, 3, 14, 'Outstanding', 'INSCOM-000002', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (54, 3, 1, 'Outstanding', 'INSCOM-000003', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:20:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (55, 3, 12, 'Outstanding', 'INSCOM-000004', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (56, 3, 14, 'Outstanding', 'INSCOM-000005', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (57, 3, 1, 'Outstanding', 'INSCOM-000006', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:21:46', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (58, 3, 12, 'Outstanding', 'INSCOM-000007', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (59, 3, 14, 'Outstanding', 'INSCOM-000008', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (60, 3, 1, 'Outstanding', 'INSCOM-000009', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 12:25:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (61, 3, 12, 'Outstanding', 'INSCOM-000010', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (62, 3, 14, 'Outstanding', 'INSCOM-000011', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (63, 3, 1, 'Outstanding', 'INSCOM-000012', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:34:11', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (64, 3, 12, 'Outstanding', 'INSCOM-000013', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (65, 3, 14, 'Outstanding', 'INSCOM-000014', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (66, 3, 1, 'Outstanding', 'INSCOM-000015', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:36:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (67, 3, 12, 'Outstanding', 'INSCOM-000016', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (68, 3, 14, 'Outstanding', 'INSCOM-000017', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (69, 3, 1, 'Outstanding', 'INSCOM-000018', '2019-11-20', '2019-11-20', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PolicyID', 26, '2019-11-20 17:38:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (70, 3, 12, 'Outstanding', 'INSCOM-000019', '2019-11-22', '2019-11-22', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PaymentID', 29, '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (71, 3, 14, 'Outstanding', 'INSCOM-000020', '2019-11-22', '2019-11-22', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PaymentID', 29, '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (72, 3, 1, 'Outstanding', 'INSCOM-000021', '2019-11-22', '2019-11-22', 11, 2019, NULL, 'Policy ID:26 Commissions', 'AInsurance', 'PaymentID', 29, '2019-11-22 18:41:51', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (73, 3, 17, 'Outstanding', 'INSCOM-000022', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:7 Commissions', 'AInsurance', 'PaymentID', 30, '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (74, 3, 14, 'Outstanding', 'INSCOM-000023', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:7 Commissions', 'AInsurance', 'PaymentID', 30, '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (75, 3, 1, 'Outstanding', 'INSCOM-000024', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:7 Commissions', 'AInsurance', 'PaymentID', 30, '2019-11-23 11:44:52', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (76, 3, 16, 'Outstanding', 'INSCOM-000025', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:27 Commissions', 'AInsurance', 'PaymentID', 31, '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (77, 3, 14, 'Outstanding', 'INSCOM-000026', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:27 Commissions', 'AInsurance', 'PaymentID', 31, '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (78, 3, 1, 'Outstanding', 'INSCOM-000027', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:27 Commissions', 'AInsurance', 'PaymentID', 31, '2019-11-23 17:21:01', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (79, 3, 16, 'Outstanding', 'INSCOM-000028', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:27 Commissions', 'AInsurance', 'PaymentID', 32, '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (80, 3, 14, 'Outstanding', 'INSCOM-000029', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:27 Commissions', 'AInsurance', 'PaymentID', 32, '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (81, 3, 1, 'Outstanding', 'INSCOM-000030', '2019-11-23', '2019-11-23', 11, 2019, NULL, 'Policy ID:27 Commissions', 'AInsurance', 'PaymentID', 32, '2019-11-23 17:21:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (82, 3, 16, 'Outstanding', 'INSCOM-000031', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:34 Commissions', 'AInsurance', 'PaymentID', 33, '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (83, 3, 2234, 'Outstanding', 'INSCOM-000032', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:34 Commissions', 'AInsurance', 'PaymentID', 33, '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (84, 3, 2235, 'Outstanding', 'INSCOM-000033', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:34 Commissions', 'AInsurance', 'PaymentID', 33, '2020-03-16 11:32:42', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (85, 3, 16, 'Outstanding', 'INSCOM-000034', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 34, '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (86, 3, 2234, 'Outstanding', 'INSCOM-000035', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 34, '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (87, 3, 2235, 'Outstanding', 'INSCOM-000036', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 34, '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (88, 3, 13, 'Outstanding', 'INSCOM-000037', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 34, '2020-03-16 12:31:17', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (89, 3, 16, 'Outstanding', 'INSCOM-000038', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 36, '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (90, 3, 2234, 'Outstanding', 'INSCOM-000039', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 36, '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (91, 3, 2235, 'Outstanding', 'INSCOM-000040', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 36, '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (92, 3, 13, 'Outstanding', 'INSCOM-000041', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 36, '2020-03-16 12:42:16', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (93, 3, 16, 'Outstanding', 'INSCOM-000042', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 37, '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (94, 3, 2234, 'Outstanding', 'INSCOM-000043', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 37, '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (95, 3, 2235, 'Outstanding', 'INSCOM-000044', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 37, '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (96, 3, 13, 'Outstanding', 'INSCOM-000045', '2020-03-16', '2020-03-16', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 37, '2020-03-16 12:52:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (97, 3, 16, 'Outstanding', 'INSCOM-000046', '2020-03-23', '2020-03-23', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 38, '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (98, 3, 2234, 'Outstanding', 'INSCOM-000047', '2020-03-23', '2020-03-23', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 38, '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (99, 3, 2235, 'Outstanding', 'INSCOM-000048', '2020-03-23', '2020-03-23', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 38, '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (100, 3, 13, 'Outstanding', 'INSCOM-000049', '2020-03-23', '2020-03-23', 3, 2020, NULL, 'Policy ID:35 Commissions', 'AInsurance', 'PaymentID', 38, '2020-03-23 11:13:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (101, 3, 16, 'Outstanding', 'INSCOM-000050', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 39, '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (102, 3, 2234, 'Outstanding', 'INSCOM-000051', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 39, '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (103, 3, 2235, 'Outstanding', 'INSCOM-000052', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 39, '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (104, 3, 13, 'Outstanding', 'INSCOM-000053', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 39, '2020-03-27 12:09:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (105, 3, 16, 'Outstanding', 'INSCOM-000054', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 40, '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (106, 3, 2234, 'Outstanding', 'INSCOM-000055', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 40, '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (107, 3, 2235, 'Outstanding', 'INSCOM-000056', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 40, '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (108, 3, 13, 'Outstanding', 'INSCOM-000057', '2020-03-27', '2020-03-27', 3, 2020, NULL, 'Policy ID:61 Commissions', 'AInsurance', 'PaymentID', 40, '2020-03-27 12:11:19', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (109, 3, 16, 'Outstanding', 'INSCOM-000058', '2020-04-01', '2020-04-01', 4, 2020, NULL, 'Policy ID:70 Commissions', 'AInsurance', 'PaymentID', 41, '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (110, 3, 2234, 'Outstanding', 'INSCOM-000059', '2020-04-01', '2020-04-01', 4, 2020, NULL, 'Policy ID:70 Commissions', 'AInsurance', 'PaymentID', 41, '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (111, 3, 2235, 'Outstanding', 'INSCOM-000060', '2020-04-01', '2020-04-01', 4, 2020, NULL, 'Policy ID:70 Commissions', 'AInsurance', 'PaymentID', 41, '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (112, 3, 13, 'Outstanding', 'INSCOM-000061', '2020-04-01', '2020-04-01', 4, 2020, NULL, 'Policy ID:70 Commissions', 'AInsurance', 'PaymentID', 41, '2020-04-01 11:38:38', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (113, 3, 16, 'Outstanding', 'INSCOM-000062', '2020-04-11', '2020-04-11', 4, 2020, NULL, 'Policy ID:76 Commissions', 'AInsurance', 'PaymentID', 43, '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (114, 3, 2234, 'Outstanding', 'INSCOM-000063', '2020-04-11', '2020-04-11', 4, 2020, NULL, 'Policy ID:76 Commissions', 'AInsurance', 'PaymentID', 43, '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (115, 3, 2235, 'Outstanding', 'INSCOM-000064', '2020-04-11', '2020-04-11', 4, 2020, NULL, 'Policy ID:76 Commissions', 'AInsurance', 'PaymentID', 43, '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (116, 3, 13, 'Outstanding', 'INSCOM-000065', '2020-04-11', '2020-04-11', 4, 2020, NULL, 'Policy ID:76 Commissions', 'AInsurance', 'PaymentID', 43, '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (117, 3, 14, 'Outstanding', 'INSCOM-000066', '2020-04-11', '2020-04-11', 4, 2020, NULL, 'Policy ID:76 Commissions', 'AInsurance', 'PaymentID', 43, '2020-04-11 14:07:09', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (118, 3, 16, 'Outstanding', 'INSCOM-000067', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:82 Commissions', 'AInsurance', 'PaymentID', 44, '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (119, 3, 2234, 'Outstanding', 'INSCOM-000068', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:82 Commissions', 'AInsurance', 'PaymentID', 44, '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (120, 3, 1, 'Outstanding', 'INSCOM-000069', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:82 Commissions', 'AInsurance', 'PaymentID', 44, '2020-04-12 12:05:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (121, 3, 16, 'Outstanding', 'INSCOM-000070', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 45, '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (122, 3, 2234, 'Outstanding', 'INSCOM-000071', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 45, '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (123, 3, 2235, 'Outstanding', 'INSCOM-000072', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 45, '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (124, 3, 13, 'Outstanding', 'INSCOM-000073', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 45, '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (125, 3, 14, 'Outstanding', 'INSCOM-000074', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 45, '2020-04-12 12:50:23', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (126, 3, 16, 'Outstanding', 'INSCOM-000075', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 46, '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (127, 3, 2234, 'Outstanding', 'INSCOM-000076', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 46, '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (128, 3, 2235, 'Outstanding', 'INSCOM-000077', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 46, '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (129, 3, 13, 'Outstanding', 'INSCOM-000078', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 46, '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (130, 3, 14, 'Outstanding', 'INSCOM-000079', '2020-04-12', '2020-04-12', 4, 2020, NULL, 'Policy ID:89 Commissions', 'AInsurance', 'PaymentID', 46, '2020-04-12 12:57:06', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (131, 3, 16, 'Outstanding', 'INSCOM-000080', '2020-04-15', '2020-04-15', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 47, '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (132, 3, 2234, 'Outstanding', 'INSCOM-000081', '2020-04-15', '2020-04-15', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 47, '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (133, 3, 1, 'Outstanding', 'INSCOM-000082', '2020-04-15', '2020-04-15', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 47, '2020-04-15 12:30:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (134, 3, 12, 'Outstanding', 'INSCOM-000083', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:18 Commissions', 'AInsurance', 'PaymentID', 16, '2020-04-16 10:25:04', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (135, 3, 16, 'Outstanding', 'INSCOM-000084', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (136, 3, 2234, 'Outstanding', 'INSCOM-000085', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (137, 3, 1, 'Outstanding', 'INSCOM-000086', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 10:39:26', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (138, 3, 16, 'Outstanding', 'INSCOM-000087', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (139, 3, 2234, 'Outstanding', 'INSCOM-000088', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (140, 3, 1, 'Outstanding', 'INSCOM-000089', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 10:59:18', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (141, 3, 16, 'Outstanding', 'INSCOM-000090', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (142, 3, 2234, 'Outstanding', 'INSCOM-000091', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (143, 3, 1, 'Outstanding', 'INSCOM-000092', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:95 Commissions', 'AInsurance', 'PaymentID', 76, '2020-04-16 11:29:55', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (144, 3, 16, 'Outstanding', 'INSCOM-000093', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 78, '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (145, 3, 2234, 'Outstanding', 'INSCOM-000094', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 78, '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (146, 3, 2235, 'Outstanding', 'INSCOM-000095', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 78, '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (147, 3, 13, 'Outstanding', 'INSCOM-000096', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 78, '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (148, 3, 14, 'Outstanding', 'INSCOM-000097', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 78, '2020-04-16 11:38:36', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (149, 3, 16, 'Outstanding', 'INSCOM-000098', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 79, '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (150, 3, 2234, 'Outstanding', 'INSCOM-000099', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 79, '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (151, 3, 2235, 'Outstanding', 'INSCOM-000100', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 79, '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (152, 3, 13, 'Outstanding', 'INSCOM-000101', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 79, '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (153, 3, 14, 'Outstanding', 'INSCOM-000102', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 79, '2020-04-16 12:22:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (154, 3, 16, 'Outstanding', 'INSCOM-000103', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 83, '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (155, 3, 2234, 'Outstanding', 'INSCOM-000104', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 83, '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (156, 3, 2235, 'Outstanding', 'INSCOM-000105', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 83, '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (157, 3, 13, 'Outstanding', 'INSCOM-000106', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 83, '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (158, 3, 14, 'Outstanding', 'INSCOM-000107', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 83, '2020-04-16 12:40:12', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (159, 3, 16, 'Outstanding', 'INSCOM-000108', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 85, '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (160, 3, 2234, 'Outstanding', 'INSCOM-000109', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 85, '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (161, 3, 2235, 'Outstanding', 'INSCOM-000110', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 85, '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (162, 3, 13, 'Outstanding', 'INSCOM-000111', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 85, '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (163, 3, 14, 'Outstanding', 'INSCOM-000112', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:97 Commissions', 'AInsurance', 'PaymentID', 85, '2020-04-16 12:43:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (164, 3, 16, 'Outstanding', 'INSCOM-000113', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 86, '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (165, 3, 2234, 'Outstanding', 'INSCOM-000114', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 86, '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (166, 3, 2235, 'Outstanding', 'INSCOM-000115', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 86, '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (167, 3, 13, 'Outstanding', 'INSCOM-000116', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 86, '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (168, 3, 14, 'Outstanding', 'INSCOM-000117', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 86, '2020-04-16 12:47:50', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (169, 3, 16, 'Outstanding', 'INSCOM-000118', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 87, '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (170, 3, 2234, 'Outstanding', 'INSCOM-000119', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 87, '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (171, 3, 2235, 'Outstanding', 'INSCOM-000120', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 87, '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (172, 3, 13, 'Outstanding', 'INSCOM-000121', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 87, '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (173, 3, 14, 'Outstanding', 'INSCOM-000122', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:99 Commissions', 'AInsurance', 'PaymentID', 87, '2020-04-16 13:01:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (174, 3, 16, 'Outstanding', 'INSCOM-000123', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:101 Commissions', 'AInsurance', 'PaymentID', 88, '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (175, 3, 2234, 'Outstanding', 'INSCOM-000124', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:101 Commissions', 'AInsurance', 'PaymentID', 88, '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (176, 3, 2235, 'Outstanding', 'INSCOM-000125', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:101 Commissions', 'AInsurance', 'PaymentID', 88, '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (177, 3, 13, 'Outstanding', 'INSCOM-000126', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:101 Commissions', 'AInsurance', 'PaymentID', 88, '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (178, 3, 14, 'Outstanding', 'INSCOM-000127', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:101 Commissions', 'AInsurance', 'PaymentID', 88, '2020-04-16 13:37:29', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (179, 3, 16, 'Outstanding', 'INSCOM-000128', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 89, '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (180, 3, 2234, 'Outstanding', 'INSCOM-000129', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 89, '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (181, 3, 2235, 'Outstanding', 'INSCOM-000130', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 89, '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (182, 3, 13, 'Outstanding', 'INSCOM-000131', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 89, '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (183, 3, 14, 'Outstanding', 'INSCOM-000132', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 89, '2020-04-16 13:39:22', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (184, 3, 16, 'Outstanding', 'INSCOM-000133', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 90, '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (185, 3, 2234, 'Outstanding', 'INSCOM-000134', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 90, '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (186, 3, 2235, 'Outstanding', 'INSCOM-000135', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 90, '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (187, 3, 13, 'Outstanding', 'INSCOM-000136', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 90, '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (188, 3, 14, 'Outstanding', 'INSCOM-000137', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 90, '2020-04-16 13:51:08', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (189, 3, 16, 'Outstanding', 'INSCOM-000138', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 91, '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (190, 3, 2234, 'Outstanding', 'INSCOM-000139', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 91, '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (191, 3, 2235, 'Outstanding', 'INSCOM-000140', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 91, '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (192, 3, 13, 'Outstanding', 'INSCOM-000141', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 91, '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (193, 3, 14, 'Outstanding', 'INSCOM-000142', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 91, '2020-04-16 13:56:25', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (194, 3, 16, 'Outstanding', 'INSCOM-000143', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 92, '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (195, 3, 2234, 'Outstanding', 'INSCOM-000144', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 92, '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (196, 3, 2235, 'Outstanding', 'INSCOM-000145', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 92, '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (197, 3, 13, 'Outstanding', 'INSCOM-000146', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 92, '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (198, 3, 14, 'Outstanding', 'INSCOM-000147', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 92, '2020-04-16 14:04:56', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (199, 3, 16, 'Outstanding', 'INSCOM-000148', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 95, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (200, 3, 2234, 'Outstanding', 'INSCOM-000149', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 95, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (201, 3, 2235, 'Outstanding', 'INSCOM-000150', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 95, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (202, 3, 13, 'Outstanding', 'INSCOM-000151', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 95, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (203, 3, 14, 'Outstanding', 'INSCOM-000152', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:102 Commissions', 'AInsurance', 'PaymentID', 95, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (204, 3, 16, 'Outstanding', 'INSCOM-000153', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 97, '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (205, 3, 2234, 'Outstanding', 'INSCOM-000154', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 97, '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (206, 3, 2235, 'Outstanding', 'INSCOM-000155', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 97, '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (207, 3, 13, 'Outstanding', 'INSCOM-000156', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 97, '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (208, 3, 14, 'Outstanding', 'INSCOM-000157', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 97, '2020-04-16 14:20:28', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (209, 3, 16, 'Outstanding', 'INSCOM-000158', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 98, '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (210, 3, 2234, 'Outstanding', 'INSCOM-000159', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 98, '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (211, 3, 2235, 'Outstanding', 'INSCOM-000160', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 98, '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (212, 3, 13, 'Outstanding', 'INSCOM-000161', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 98, '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (213, 3, 14, 'Outstanding', 'INSCOM-000162', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 98, '2020-04-16 14:21:20', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (214, 3, 16, 'Outstanding', 'INSCOM-000163', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 99, '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (215, 3, 2234, 'Outstanding', 'INSCOM-000164', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 99, '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (216, 3, 2235, 'Outstanding', 'INSCOM-000165', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 99, '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (217, 3, 13, 'Outstanding', 'INSCOM-000166', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 99, '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (218, 3, 14, 'Outstanding', 'INSCOM-000167', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:105 Commissions', 'AInsurance', 'PaymentID', 99, '2020-04-16 14:23:13', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (219, 3, 16, 'Outstanding', 'INSCOM-000168', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 101, '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (220, 3, 2234, 'Outstanding', 'INSCOM-000169', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 101, '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (221, 3, 2235, 'Outstanding', 'INSCOM-000170', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 101, '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (222, 3, 13, 'Outstanding', 'INSCOM-000171', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 101, '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (223, 3, 14, 'Outstanding', 'INSCOM-000172', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 101, '2020-04-16 14:25:10', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (224, 3, 16, 'Outstanding', 'INSCOM-000173', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 102, '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (225, 3, 2234, 'Outstanding', 'INSCOM-000174', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 102, '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (226, 3, 2235, 'Outstanding', 'INSCOM-000175', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 102, '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (227, 3, 13, 'Outstanding', 'INSCOM-000176', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 102, '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (228, 3, 14, 'Outstanding', 'INSCOM-000177', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 102, '2020-04-16 14:34:07', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (229, 3, 16, 'Outstanding', 'INSCOM-000178', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 103, '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (230, 3, 2234, 'Outstanding', 'INSCOM-000179', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 103, '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (231, 3, 2235, 'Outstanding', 'INSCOM-000180', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 103, '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (232, 3, 13, 'Outstanding', 'INSCOM-000181', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 103, '2020-04-16 14:43:47', 1, NULL, NULL);
INSERT INTO `ac_transactions` VALUES (233, 3, 14, 'Locked', 'INSCOM-000182', '2020-04-16', '2020-04-16', 4, 2020, NULL, 'Policy ID:107 Commissions', 'AInsurance', 'PaymentID', 103, '2020-04-16 14:43:47', 1, '2020-06-26 12:11:22', 1);

-- ----------------------------
-- Table structure for agent_commission_types
-- ----------------------------
DROP TABLE IF EXISTS `agent_commission_types`;
CREATE TABLE `agent_commission_types`  (
  `agcmt_agent_insurance_type_ID` int(8) NOT NULL AUTO_INCREMENT,
  `agcmt_agent_ID` int(8) NULL DEFAULT NULL,
  `agcmt_insurance_company_ID` int(8) NULL DEFAULT NULL,
  `agcmt_policy_type_ID` int(8) NULL DEFAULT NULL,
  `agcmt_status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `agcmt_commission_amount` double NULL DEFAULT NULL,
  `agcmt_created_date_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `agcmt_created_by` int(8) NULL DEFAULT NULL,
  `agcmt_last_update_date_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `agcmt_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`agcmt_agent_insurance_type_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agent_commission_types
-- ----------------------------
INSERT INTO `agent_commission_types` VALUES (1, 1, 1, 1, 'Active', 25.05, '2019-02-15 11:09:51', 1, '2019-02-15 11:09:51', 1);
INSERT INTO `agent_commission_types` VALUES (2, 1, 1, 2, 'Active', 27, '2019-02-15 20:35:22', 1, '2019-02-15 20:35:22', NULL);
INSERT INTO `agent_commission_types` VALUES (3, 1, 4, 2, 'Active', 28, '2019-02-15 20:35:35', 1, NULL, NULL);
INSERT INTO `agent_commission_types` VALUES (4, 1, 4, 1, 'Active', 22.5, '2019-02-15 20:35:46', 1, NULL, NULL);

-- ----------------------------
-- Table structure for agents
-- ----------------------------
DROP TABLE IF EXISTS `agents`;
CREATE TABLE `agents`  (
  `agnt_agent_ID` int(8) NOT NULL AUTO_INCREMENT,
  `agnt_user_ID` int(8) NULL DEFAULT NULL,
  `agnt_basic_account_ID` int(8) NULL DEFAULT NULL,
  `agnt_status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `agnt_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `agnt_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `agnt_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Issuer/Agent/SubAgent',
  `agnt_enable_commission_release` int(1) NULL DEFAULT NULL,
  `agnt_commission_release_basic_account_ID` int(8) NULL DEFAULT NULL,
  `agnt_created_date_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `agnt_created_by` int(8) NULL DEFAULT NULL,
  `agnt_last_update_date_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `agnt_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`agnt_agent_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agents
-- ----------------------------
INSERT INTO `agents` VALUES (1, 1, 7, 'Active', 'A1001', 'Michael Ermogenous', 'Agent', 1, 9, '2019-02-15 11:18:43', 1, '2019-02-15 11:18:43', 1);
INSERT INTO `agents` VALUES (2, 4, 8, 'Active', 'A1002', 'Giorgos', 'Agent', 0, NULL, '2019-02-15 11:18:39', 1, '2019-02-15 11:18:39', 1);


-- ----------------------------
-- Table structure for codes
-- ----------------------------
DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes`  (
  `cde_code_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cde_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cde_table_field` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_table_field2` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_table_field3` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_value` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_value_label` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_value_2` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_value_label_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_value_3` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_value_label_3` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_option_label` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_option_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cde_option_label_2` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cde_option_value_2` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cde_created_date_time` datetime(0) NULL DEFAULT NULL,
  `cde_created_by` int(8) NULL DEFAULT NULL,
  `cde_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `cde_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`cde_code_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 540 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Codes' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of codes
-- ----------------------------
INSERT INTO `codes` VALUES (1, 'code', NULL, 'customers#cst_city_code_ID', NULL, NULL, 'Cities', 'City Name', 'CityShort', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (2, 'code', NULL, 'customers#cst_business_type_code_ID', NULL, NULL, 'BusinessType', 'Business Type', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (3, 'BusinessType', NULL, NULL, NULL, NULL, 'Bank', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (4, 'BusinessType', NULL, NULL, NULL, NULL, 'Insurance', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (5, 'BusinessType', NULL, NULL, NULL, NULL, 'Private', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (6, 'Cities', NULL, NULL, NULL, NULL, 'Nicosia', 'City Name', 'NIC', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (7, 'Cities', NULL, NULL, NULL, NULL, 'Limassol', 'City Name', 'LIM', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (8, 'Cities', NULL, NULL, NULL, NULL, 'Larnaca', 'City Name', 'LAR', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (9, 'Cities', NULL, NULL, NULL, NULL, 'Paphos', 'City Name', 'PAF', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (10, 'Cities', NULL, NULL, NULL, NULL, 'Famagusta', 'City Name', 'FAM', 'City Name Short', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (11, 'BusinessType', NULL, NULL, NULL, NULL, 'Public School', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (12, 'BusinessType', NULL, NULL, NULL, NULL, 'Accounting', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (13, 'BusinessType', NULL, NULL, NULL, NULL, 'Law', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (14, 'BusinessType', NULL, NULL, NULL, NULL, 'Private School', 'Business Type', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (15, 'code', NULL, 'customers#cst_contact_person_title_code_ID', NULL, NULL, 'ContactPersonTitle', 'Contact Person Title', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (16, 'ContactPersonTitle', NULL, NULL, NULL, NULL, 'Owner', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (17, 'ContactPersonTitle', NULL, NULL, NULL, NULL, 'Secretary', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (18, 'ContactPersonTitle', NULL, NULL, NULL, NULL, 'Director', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (19, 'ContactPersonTitle', NULL, NULL, NULL, NULL, 'IT Manager', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (20, 'ContactPersonTitle', NULL, NULL, NULL, NULL, 'IT Technitian', 'Contact Person Title', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (21, 'code', 'Active', 'manufacturers#mnf_country_code_ID', NULL, NULL, 'Countries', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Open#Approval#Reject', NULL, NULL, NULL, NULL, '2019-04-15 13:38:00', 1);
INSERT INTO `codes` VALUES (22, 'Countries', 'Active', NULL, NULL, NULL, 'Cyprus', 'Country Name', 'CYP', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, '2019-03-27 16:58:18', 1);
INSERT INTO `codes` VALUES (23, 'Countries', 'Active', NULL, NULL, NULL, 'Germany', 'Country Name', 'DEU', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Open', NULL, NULL, NULL, NULL, '2019-06-04 14:44:38', 1);
INSERT INTO `codes` VALUES (24, 'Countries', 'Active', NULL, NULL, NULL, 'Greece', 'Country Name', 'GRC', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, '2019-03-27 16:58:23', 1);
INSERT INTO `codes` VALUES (25, 'code', NULL, 'products#prd_sub_type_code_ID', NULL, NULL, 'ProductsSubType', 'Products SubType', '', '', NULL, NULL, 'For Type', 'Machine#Consumables#Spare Parts#Other', NULL, NULL, NULL, NULL, '2018-12-05 17:04:52', 1);
INSERT INTO `codes` VALUES (27, 'ProductsSubType', NULL, NULL, NULL, NULL, 'MultiFunction', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Machine', NULL, NULL, '2018-08-13 23:03:56', 1, '2018-08-13 23:41:01', 1);
INSERT INTO `codes` VALUES (28, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Printer', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Machine', NULL, NULL, '2018-08-13 23:45:21', 1, NULL, NULL);
INSERT INTO `codes` VALUES (29, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Toners', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:45:30', 1, NULL, NULL);
INSERT INTO `codes` VALUES (30, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Waste Box', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:45:39', 1, NULL, NULL);
INSERT INTO `codes` VALUES (31, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Stables', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:45:48', 1, NULL, NULL);
INSERT INTO `codes` VALUES (32, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Developers', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:45:58', 1, NULL, NULL);
INSERT INTO `codes` VALUES (33, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Drums', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:46:06', 1, NULL, NULL);
INSERT INTO `codes` VALUES (34, 'ProductsSubType', NULL, NULL, NULL, NULL, 'CL.Blades', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:46:19', 1, NULL, NULL);
INSERT INTO `codes` VALUES (35, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Heat Rollers/Belts', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:46:35', 1, NULL, NULL);
INSERT INTO `codes` VALUES (36, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Press Rollers', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:46:45', 1, NULL, NULL);
INSERT INTO `codes` VALUES (37, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Feed Rollers', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:46:54', 1, NULL, NULL);
INSERT INTO `codes` VALUES (38, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Maintenance Kits', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Consumables', NULL, NULL, '2018-08-13 23:47:05', 1, NULL, NULL);
INSERT INTO `codes` VALUES (39, 'ProductsSubType', NULL, NULL, NULL, NULL, 'Spare Parts', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Spare Parts', NULL, NULL, '2018-08-13 23:47:14', 1, NULL, NULL);
INSERT INTO `codes` VALUES (40, 'ProductsSubType', NULL, NULL, NULL, NULL, 'A4 Paper', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Other', NULL, NULL, '2018-12-05 17:05:16', 1, NULL, NULL);
INSERT INTO `codes` VALUES (41, 'ProductsSubType', NULL, NULL, NULL, NULL, 'A3 Paper', 'Products SubType', NULL, '', NULL, NULL, NULL, 'Other', NULL, NULL, '2018-12-05 17:08:53', 1, NULL, NULL);
INSERT INTO `codes` VALUES (42, 'code', 'Active', 'oqt_quotations_items#oqqit_rate_2', '', '', 'Currency', 'Currency Code', 'CurrencyLong', 'Currency Long', NULL, NULL, '', '', NULL, NULL, '2019-03-27 12:48:41', 1, '2019-03-29 11:16:23', 1);
INSERT INTO `codes` VALUES (45, 'Currency', 'Active', NULL, NULL, NULL, 'AED', 'Currency Code', 'UAE Dirham', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (46, 'Currency', 'Active', NULL, NULL, NULL, 'AFN', 'Currency Code', 'Afghani', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (47, 'Currency', 'Active', NULL, NULL, NULL, 'ALL', 'Currency Code', 'Lek', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (48, 'Currency', 'Active', NULL, NULL, NULL, 'AMD', 'Currency Code', 'Armenian Dram', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (49, 'Currency', 'Active', NULL, NULL, NULL, 'ANG', 'Currency Code', 'Netherlands Antillian Guilder', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (50, 'Currency', 'Active', NULL, NULL, NULL, 'AOA', 'Currency Code', 'Kwanza', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (51, 'Currency', 'Active', NULL, NULL, NULL, 'ARS', 'Currency Code', 'Argentine Peso', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (52, 'Currency', 'Active', NULL, NULL, NULL, 'AUD', 'Currency Code', 'Australian Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (53, 'Currency', 'Active', NULL, NULL, NULL, 'AWG', 'Currency Code', 'Aruban Guilder', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (54, 'Currency', 'Active', NULL, NULL, NULL, 'AZN', 'Currency Code', 'Azerbaijanian Manat', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (55, 'Currency', 'Active', NULL, NULL, NULL, 'BAM', 'Currency Code', 'Convertible Marks', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (56, 'Currency', 'Active', NULL, NULL, NULL, 'BBD', 'Currency Code', 'Barbados Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (57, 'Currency', 'Active', NULL, NULL, NULL, 'BDT', 'Currency Code', 'Taka', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (58, 'Currency', 'Active', NULL, NULL, NULL, 'BGN', 'Currency Code', 'Bulgarian Lev', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (59, 'Currency', 'Active', NULL, NULL, NULL, 'BHD', 'Currency Code', 'Bahraini Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (60, 'Currency', 'Active', NULL, NULL, NULL, 'BIF', 'Currency Code', 'Burundi Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (61, 'Currency', 'Active', NULL, NULL, NULL, 'BMD', 'Currency Code', 'Bermudian Dollar (customarily known as Bermuda Dollar)', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (62, 'Currency', 'Active', NULL, NULL, NULL, 'BND', 'Currency Code', 'Brunei Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (63, 'Currency', 'Active', NULL, NULL, NULL, 'BOB', 'Currency Code', 'Boliviano Mvdol', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (64, 'Currency', 'Active', NULL, NULL, NULL, 'BRL', 'Currency Code', 'Brazilian Real', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (65, 'Currency', 'Active', NULL, NULL, NULL, 'BSD', 'Currency Code', 'Bahamian Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (66, 'Currency', 'Active', NULL, NULL, NULL, 'BWP', 'Currency Code', 'Pula', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (67, 'Currency', 'Active', NULL, NULL, NULL, 'BYR', 'Currency Code', 'Belarussian Ruble', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (68, 'Currency', 'Active', NULL, NULL, NULL, 'BZD', 'Currency Code', 'Belize Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (69, 'Currency', 'Active', NULL, NULL, NULL, 'CAD', 'Currency Code', 'Canadian Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (70, 'Currency', 'Active', NULL, NULL, NULL, 'CDF', 'Currency Code', 'Congolese Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (71, 'Currency', 'Active', NULL, NULL, NULL, 'CHF', 'Currency Code', 'Swiss Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (72, 'Currency', 'Active', NULL, NULL, NULL, 'CLP', 'Currency Code', 'Chilean Peso Unidades de fomento', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (73, 'Currency', 'Active', NULL, NULL, NULL, 'CNY', 'Currency Code', 'Yuan Renminbi', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (74, 'Currency', 'Active', NULL, NULL, NULL, 'COP', 'Currency Code', 'Colombian Peso Unidad de Valor Real', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (75, 'Currency', 'Active', NULL, NULL, NULL, 'CRC', 'Currency Code', 'Costa Rican Colon', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (76, 'Currency', 'Active', NULL, NULL, NULL, 'CUP', 'Currency Code', 'Cuban Peso Peso Convertible', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (77, 'Currency', 'Active', NULL, NULL, NULL, 'CVE', 'Currency Code', 'Cape Verde Escudo', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (78, 'Currency', 'Active', NULL, NULL, NULL, 'CZK', 'Currency Code', 'Czech Koruna', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (79, 'Currency', 'Active', NULL, NULL, NULL, 'DJF', 'Currency Code', 'Djibouti Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (80, 'Currency', 'Active', NULL, NULL, NULL, 'DKK', 'Currency Code', 'Danish Krone', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (81, 'Currency', 'Active', NULL, NULL, NULL, 'DOP', 'Currency Code', 'Dominican Peso', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (82, 'Currency', 'Active', NULL, NULL, NULL, 'DZD', 'Currency Code', 'Algerian Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (83, 'Currency', 'Active', NULL, NULL, NULL, 'EEK', 'Currency Code', 'Kroon', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (84, 'Currency', 'Active', NULL, NULL, NULL, 'EGP', 'Currency Code', 'Egyptian Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (85, 'Currency', 'Active', NULL, NULL, NULL, 'ERN', 'Currency Code', 'Nakfa', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (86, 'Currency', 'Active', NULL, NULL, NULL, 'ETB', 'Currency Code', 'Ethiopian Birr', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (87, 'Currency', 'Active', NULL, NULL, NULL, 'EUR', 'Currency Code', 'Euro', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (88, 'Currency', 'Active', NULL, NULL, NULL, 'FJD', 'Currency Code', 'Fiji Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (89, 'Currency', 'Active', NULL, NULL, NULL, 'FKP', 'Currency Code', 'Falkland Islands Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (90, 'Currency', 'Active', NULL, NULL, NULL, 'GBP', 'Currency Code', 'Pound Sterling', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (91, 'Currency', 'Active', NULL, NULL, NULL, 'GEL', 'Currency Code', 'Lari', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (92, 'Currency', 'Active', NULL, NULL, NULL, 'GHS', 'Currency Code', 'Cedi', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (93, 'Currency', 'Active', NULL, NULL, NULL, 'GIP', 'Currency Code', 'Gibraltar Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (94, 'Currency', 'Active', NULL, NULL, NULL, 'GMD', 'Currency Code', 'Dalasi', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (95, 'Currency', 'Active', NULL, NULL, NULL, 'GNF', 'Currency Code', 'Guinea Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (96, 'Currency', 'Active', NULL, NULL, NULL, 'GTQ', 'Currency Code', 'Quetzal', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (97, 'Currency', 'Active', NULL, NULL, NULL, 'GYD', 'Currency Code', 'Guyana Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (98, 'Currency', 'Active', NULL, NULL, NULL, 'HKD', 'Currency Code', 'Hong Kong Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (99, 'Currency', 'Active', NULL, NULL, NULL, 'HNL', 'Currency Code', 'Lempira', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (100, 'Currency', 'Active', NULL, NULL, NULL, 'HRK', 'Currency Code', 'Croatian Kuna', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (101, 'Currency', 'Active', NULL, NULL, NULL, 'HTG', 'Currency Code', 'Gourde US Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (102, 'Currency', 'Active', NULL, NULL, NULL, 'HUF', 'Currency Code', 'Forint', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (103, 'Currency', 'Active', NULL, NULL, NULL, 'IDR', 'Currency Code', 'Rupiah', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (104, 'Currency', 'Active', NULL, NULL, NULL, 'ILS', 'Currency Code', 'New Israeli Sheqel', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (105, 'Currency', 'Active', NULL, NULL, NULL, 'INR', 'Currency Code', 'Indian Rupee', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (106, 'Currency', 'Active', NULL, NULL, NULL, 'BTN', 'Currency Code', 'Indian Rupee Ngultrum', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (107, 'Currency', 'Active', NULL, NULL, NULL, 'IQD', 'Currency Code', 'Iraqi Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (108, 'Currency', 'Active', NULL, NULL, NULL, 'IRR', 'Currency Code', 'Iranian Rial', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (109, 'Currency', 'Active', NULL, NULL, NULL, 'ISK', 'Currency Code', 'Iceland Krona', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (110, 'Currency', 'Active', NULL, NULL, NULL, 'JMD', 'Currency Code', 'Jamaican Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (111, 'Currency', 'Active', NULL, NULL, NULL, 'JOD', 'Currency Code', 'Jordanian Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (112, 'Currency', 'Active', NULL, NULL, NULL, 'JPY', 'Currency Code', 'Yen', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (113, 'Currency', 'Active', NULL, NULL, NULL, 'KES', 'Currency Code', 'Kenyan Shilling', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (114, 'Currency', 'Active', NULL, NULL, NULL, 'KGS', 'Currency Code', 'Som', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (115, 'Currency', 'Active', NULL, NULL, NULL, 'KHR', 'Currency Code', 'Riel', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (116, 'Currency', 'Active', NULL, NULL, NULL, 'KMF', 'Currency Code', 'Comoro Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (117, 'Currency', 'Active', NULL, NULL, NULL, 'KPW', 'Currency Code', 'North Korean Won', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (118, 'Currency', 'Active', NULL, NULL, NULL, 'KRW', 'Currency Code', 'Won', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (119, 'Currency', 'Active', NULL, NULL, NULL, 'KWD', 'Currency Code', 'Kuwaiti Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (120, 'Currency', 'Active', NULL, NULL, NULL, 'KYD', 'Currency Code', 'Cayman Islands Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (121, 'Currency', 'Active', NULL, NULL, NULL, 'KZT', 'Currency Code', 'Tenge', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (122, 'Currency', 'Active', NULL, NULL, NULL, 'LAK', 'Currency Code', 'Kip', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (123, 'Currency', 'Active', NULL, NULL, NULL, 'LBP', 'Currency Code', 'Lebanese Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (124, 'Currency', 'Active', NULL, NULL, NULL, 'LKR', 'Currency Code', 'Sri Lanka Rupee', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (125, 'Currency', 'Active', NULL, NULL, NULL, 'LRD', 'Currency Code', 'Liberian Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (126, 'Currency', 'Active', NULL, NULL, NULL, 'LTL', 'Currency Code', 'Lithuanian Litas', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (127, 'Currency', 'Active', NULL, NULL, NULL, 'LVL', 'Currency Code', 'Latvian Lats', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (128, 'Currency', 'Active', NULL, NULL, NULL, 'LYD', 'Currency Code', 'Libyan Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (129, 'Currency', 'Active', NULL, NULL, NULL, 'MAD', 'Currency Code', 'Moroccan Dirham', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (130, 'Currency', 'Active', NULL, NULL, NULL, 'MDL', 'Currency Code', 'Moldovan Leu', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (131, 'Currency', 'Active', NULL, NULL, NULL, 'MGA', 'Currency Code', 'Malagasy Ariary', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (132, 'Currency', 'Active', NULL, NULL, NULL, 'MKD', 'Currency Code', 'Denar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (133, 'Currency', 'Active', NULL, NULL, NULL, 'MMK', 'Currency Code', 'Kyat', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (134, 'Currency', 'Active', NULL, NULL, NULL, 'MNT', 'Currency Code', 'Tugrik', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (135, 'Currency', 'Active', NULL, NULL, NULL, 'MOP', 'Currency Code', 'Pataca', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (136, 'Currency', 'Active', NULL, NULL, NULL, 'MRO', 'Currency Code', 'Ouguiya', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (137, 'Currency', 'Active', NULL, NULL, NULL, 'MUR', 'Currency Code', 'Mauritius Rupee', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (138, 'Currency', 'Active', NULL, NULL, NULL, 'MVR', 'Currency Code', 'Rufiyaa', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (139, 'Currency', 'Active', NULL, NULL, NULL, 'MWK', 'Currency Code', 'Kwacha', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (140, 'Currency', 'Active', NULL, NULL, NULL, 'MXN', 'Currency Code', 'Mexican Peso Mexican Unidad de Inversion (UDI)', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (141, 'Currency', 'Active', NULL, NULL, NULL, 'MYR', 'Currency Code', 'Malaysian Ringgit', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (142, 'Currency', 'Active', NULL, NULL, NULL, 'MZN', 'Currency Code', 'Metical', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (143, 'Currency', 'Active', NULL, NULL, NULL, 'NGN', 'Currency Code', 'Naira', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (144, 'Currency', 'Active', NULL, NULL, NULL, 'NIO', 'Currency Code', 'Cordoba Oro', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (145, 'Currency', 'Active', NULL, NULL, NULL, 'NOK', 'Currency Code', 'Norwegian Krone', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (146, 'Currency', 'Active', NULL, NULL, NULL, 'NPR', 'Currency Code', 'Nepalese Rupee', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (147, 'Currency', 'Active', NULL, NULL, NULL, 'NZD', 'Currency Code', 'New Zealand Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (148, 'Currency', 'Active', NULL, NULL, NULL, 'OMR', 'Currency Code', 'Rial Omani', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (149, 'Currency', 'Active', NULL, NULL, NULL, 'PAB', 'Currency Code', 'Balboa US Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (150, 'Currency', 'Active', NULL, NULL, NULL, 'PEN', 'Currency Code', 'Nuevo Sol', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (151, 'Currency', 'Active', NULL, NULL, NULL, 'PGK', 'Currency Code', 'Kina', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (152, 'Currency', 'Active', NULL, NULL, NULL, 'PHP', 'Currency Code', 'Philippine Peso', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (153, 'Currency', 'Active', NULL, NULL, NULL, 'PKR', 'Currency Code', 'Pakistan Rupee', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (154, 'Currency', 'Active', NULL, NULL, NULL, 'PLN', 'Currency Code', 'Zloty', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (155, 'Currency', 'Active', NULL, NULL, NULL, 'PYG', 'Currency Code', 'Guarani', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (156, 'Currency', 'Active', NULL, NULL, NULL, 'QAR', 'Currency Code', 'Qatari Rial', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (157, 'Currency', 'Active', NULL, NULL, NULL, 'RON', 'Currency Code', 'New Leu', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (158, 'Currency', 'Active', NULL, NULL, NULL, 'RSD', 'Currency Code', 'Serbian Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (159, 'Currency', 'Active', NULL, NULL, NULL, 'RUB', 'Currency Code', 'Russian Ruble', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (160, 'Currency', 'Active', NULL, NULL, NULL, 'RWF', 'Currency Code', 'Rwanda Franc', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (161, 'Currency', 'Active', NULL, NULL, NULL, 'SAR', 'Currency Code', 'Saudi Riyal', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (162, 'Currency', 'Active', NULL, NULL, NULL, 'SBD', 'Currency Code', 'Solomon Islands Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (163, 'Currency', 'Active', NULL, NULL, NULL, 'SCR', 'Currency Code', 'Seychelles Rupee', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (164, 'Currency', 'Active', NULL, NULL, NULL, 'SDG', 'Currency Code', 'Sudanese Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (165, 'Currency', 'Active', NULL, NULL, NULL, 'SEK', 'Currency Code', 'Swedish Krona', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (166, 'Currency', 'Active', NULL, NULL, NULL, 'SGD', 'Currency Code', 'Singapore Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (167, 'Currency', 'Active', NULL, NULL, NULL, 'SHP', 'Currency Code', 'Saint Helena Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (168, 'Currency', 'Active', NULL, NULL, NULL, 'SLL', 'Currency Code', 'Leone', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (169, 'Currency', 'Active', NULL, NULL, NULL, 'SOS', 'Currency Code', 'Somali Shilling', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (170, 'Currency', 'Active', NULL, NULL, NULL, 'SRD', 'Currency Code', 'Surinam Dollar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (171, 'Currency', 'Active', NULL, NULL, NULL, 'STD', 'Currency Code', 'Dobra', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (172, 'Currency', 'Active', NULL, NULL, NULL, 'SVC', 'Currency Code', 'El Salvador Colon', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (173, 'Currency', 'Active', NULL, NULL, NULL, 'SYP', 'Currency Code', 'Syrian Pound', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (174, 'Currency', 'Active', NULL, NULL, NULL, 'SZL', 'Currency Code', 'Lilangeni', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (175, 'Currency', 'Active', NULL, NULL, NULL, 'THB', 'Currency Code', 'Baht', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (176, 'Currency', 'Active', NULL, NULL, NULL, 'TJS', 'Currency Code', 'Somoni', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (177, 'Currency', 'Active', NULL, NULL, NULL, 'TMT', 'Currency Code', 'Manat', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (178, 'Currency', 'Active', NULL, NULL, NULL, 'TND', 'Currency Code', 'Tunisian Dinar', 'Currency Long', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (179, 'Countries', 'Active', NULL, NULL, NULL, 'Albania', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (180, 'Countries', 'Active', NULL, NULL, NULL, 'Algeria', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (181, 'Countries', 'Active', NULL, NULL, NULL, 'Andorra', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (182, 'Countries', 'Active', NULL, NULL, NULL, 'Angola', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (183, 'Countries', 'Active', NULL, NULL, NULL, 'Antigua & Barbuda', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (184, 'Countries', 'Active', NULL, NULL, NULL, 'Argentina', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (185, 'Countries', 'Active', NULL, NULL, NULL, 'Armenia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (186, 'Countries', 'Active', NULL, NULL, NULL, 'Aruba', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (187, 'Countries', 'Active', NULL, NULL, NULL, 'Australia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (188, 'Countries', 'Active', NULL, NULL, NULL, 'Azerbaijan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (189, 'Countries', 'Active', NULL, NULL, NULL, 'Bahamas', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (190, 'Countries', 'Active', NULL, NULL, NULL, 'Bahrain', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (191, 'Countries', 'Active', NULL, NULL, NULL, 'Bangladesh', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (192, 'Countries', 'Active', NULL, NULL, NULL, 'Barbados', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (193, 'Countries', 'Active', NULL, NULL, NULL, 'Belarus', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (194, 'Countries', 'Active', NULL, NULL, NULL, 'Belgium', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (195, 'Countries', 'Active', NULL, NULL, NULL, 'Belize', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (196, 'Countries', 'Active', NULL, NULL, NULL, 'Benin', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (197, 'Countries', 'Active', NULL, NULL, NULL, 'Bermuda', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (198, 'Countries', 'Active', NULL, NULL, NULL, 'Bhutan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (199, 'Countries', 'Active', NULL, NULL, NULL, 'Bolivia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (200, 'Countries', 'Active', NULL, NULL, NULL, 'Bosnia & Herzegovina', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (201, 'Countries', 'Active', NULL, NULL, NULL, 'Botswana', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (202, 'Countries', 'Active', NULL, NULL, NULL, 'Brazil', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (203, 'Countries', 'Active', NULL, NULL, NULL, 'Bulgaria', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (204, 'Countries', 'Active', NULL, NULL, NULL, 'Burkina Faso', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (205, 'Countries', 'Active', NULL, NULL, NULL, 'Burundi', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (206, 'Countries', 'Active', NULL, NULL, NULL, 'Cambodia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (207, 'Countries', 'Active', NULL, NULL, NULL, 'Cameroon', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (208, 'Countries', 'Active', NULL, NULL, NULL, 'Canada', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (209, 'Countries', 'Active', NULL, NULL, NULL, 'Cape Verde', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (210, 'Countries', 'Active', NULL, NULL, NULL, 'Cayman Islands', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (211, 'Countries', 'Active', NULL, NULL, NULL, 'Central African Republic', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (212, 'Countries', 'Active', NULL, NULL, NULL, 'Chad', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (213, 'Countries', 'Active', NULL, NULL, NULL, 'Chile', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (214, 'Countries', 'Active', NULL, NULL, NULL, 'China', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (215, 'Countries', 'Active', NULL, NULL, NULL, 'Colombia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (216, 'Countries', 'Active', NULL, NULL, NULL, 'Comoros', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (217, 'Countries', 'Active', NULL, NULL, NULL, 'Costa Rica', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (218, 'Countries', 'Active', NULL, NULL, NULL, 'Croatia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (219, 'Countries', 'Active', NULL, NULL, NULL, 'Curacao', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (220, 'Countries', 'Active', NULL, NULL, NULL, 'Cyprus', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (221, 'Countries', 'Active', NULL, NULL, NULL, 'Czech Republic', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (222, 'Countries', 'Active', NULL, NULL, NULL, 'Denmark', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (223, 'Countries', 'Active', NULL, NULL, NULL, 'Djibouti', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (224, 'Countries', 'Active', NULL, NULL, NULL, 'Dominica', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (225, 'Countries', 'Active', NULL, NULL, NULL, 'Dominican Republic', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (226, 'Countries', 'Active', NULL, NULL, NULL, 'East Timor', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (227, 'Countries', 'Active', NULL, NULL, NULL, 'Ecuador', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (228, 'Countries', 'Active', NULL, NULL, NULL, 'Egypt', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (229, 'Countries', 'Active', NULL, NULL, NULL, 'El Salvador', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (230, 'Countries', 'Active', NULL, NULL, NULL, 'Equatorial Guinea', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (231, 'Countries', 'Active', NULL, NULL, NULL, 'Eritrea', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (232, 'Countries', 'Active', NULL, NULL, NULL, 'Estonia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (233, 'Countries', 'Active', NULL, NULL, NULL, 'Ethiopia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (234, 'Countries', 'Active', NULL, NULL, NULL, 'Fiji', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (235, 'Countries', 'Active', NULL, NULL, NULL, 'Finland', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (236, 'Countries', 'Active', NULL, NULL, NULL, 'France', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (237, 'Countries', 'Active', NULL, NULL, NULL, 'Gabon', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (238, 'Countries', 'Active', NULL, NULL, NULL, 'Gambia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (239, 'Countries', 'Active', NULL, NULL, NULL, 'Georgia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (240, 'Countries', 'Active', NULL, NULL, NULL, 'Germany', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (241, 'Countries', 'Active', NULL, NULL, NULL, 'Ghana', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (242, 'Countries', 'Active', NULL, NULL, NULL, 'Grenada', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (243, 'Countries', 'Active', NULL, NULL, NULL, 'Guam', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (244, 'Countries', 'Active', NULL, NULL, NULL, 'Guinea', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (245, 'Countries', 'Active', NULL, NULL, NULL, 'Guinea-Bissau', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (246, 'Countries', 'Active', NULL, NULL, NULL, 'Guyana', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (247, 'Countries', 'Active', NULL, NULL, NULL, 'Haiti', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (248, 'Countries', 'Active', NULL, NULL, NULL, 'Honduras', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (249, 'Countries', 'Active', NULL, NULL, NULL, 'Hong Kong', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (250, 'Countries', 'Active', NULL, NULL, NULL, 'Hungary', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (251, 'Countries', 'Active', NULL, NULL, NULL, 'Iceland', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (252, 'Countries', 'Active', NULL, NULL, NULL, 'India', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (253, 'Countries', 'Active', NULL, NULL, NULL, 'Indonesia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (254, 'Countries', 'Active', NULL, NULL, NULL, 'Ireland', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (255, 'Countries', 'Active', NULL, NULL, NULL, 'Israel & the Palestinian Authority', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (256, 'Countries', 'Active', NULL, NULL, NULL, 'Italy', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (257, 'Countries', 'Active', NULL, NULL, NULL, 'Jamaica', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (258, 'Countries', 'Active', NULL, NULL, NULL, 'Japan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (259, 'Countries', 'Active', NULL, NULL, NULL, 'Jordan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (260, 'Countries', 'Active', NULL, NULL, NULL, 'Kazakhstan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (261, 'Countries', 'Active', NULL, NULL, NULL, 'Kenya', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (262, 'Countries', 'Active', NULL, NULL, NULL, 'Kiribati', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (263, 'Countries', 'Active', NULL, NULL, NULL, 'Kuwait', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (264, 'Countries', 'Active', NULL, NULL, NULL, 'Kyrgyzstan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (265, 'Countries', 'Active', NULL, NULL, NULL, 'Laos', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (266, 'Countries', 'Active', NULL, NULL, NULL, 'Latvia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (267, 'Countries', 'Active', NULL, NULL, NULL, 'Lebanon', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (268, 'Countries', 'Active', NULL, NULL, NULL, 'Lesotho', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (269, 'Countries', 'Active', NULL, NULL, NULL, 'Liechtenstein', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (270, 'Countries', 'Active', NULL, NULL, NULL, 'Lithuania', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (271, 'Countries', 'Active', NULL, NULL, NULL, 'Luxembourg', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (272, 'Countries', 'Active', NULL, NULL, NULL, 'Macau', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (273, 'Countries', 'Active', NULL, NULL, NULL, 'Macedonia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (274, 'Countries', 'Active', NULL, NULL, NULL, 'Madagascar', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (275, 'Countries', 'Active', NULL, NULL, NULL, 'Malawi', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (276, 'Countries', 'Active', NULL, NULL, NULL, 'Malaysia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (277, 'Countries', 'Active', NULL, NULL, NULL, 'Maldives', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (278, 'Countries', 'Active', NULL, NULL, NULL, 'Mali', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (279, 'Countries', 'Active', NULL, NULL, NULL, 'Malta', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (280, 'Countries', 'Active', NULL, NULL, NULL, 'Marshall Islands', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (281, 'Countries', 'Active', NULL, NULL, NULL, 'Mauritania', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (282, 'Countries', 'Active', NULL, NULL, NULL, 'Mauritius', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (283, 'Countries', 'Active', NULL, NULL, NULL, 'Micronesia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (284, 'Countries', 'Active', NULL, NULL, NULL, 'Monaco', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (285, 'Countries', 'Active', NULL, NULL, NULL, 'Mongolia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (286, 'Countries', 'Active', NULL, NULL, NULL, 'Morocco', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (287, 'Countries', 'Active', NULL, NULL, NULL, 'Mozambique', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (288, 'Countries', 'Active', NULL, NULL, NULL, 'Namibia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (289, 'Countries', 'Active', NULL, NULL, NULL, 'Nauru', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (290, 'Countries', 'Active', NULL, NULL, NULL, 'Nepal', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (291, 'Countries', 'Active', NULL, NULL, NULL, 'Netherlands', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (292, 'Countries', 'Active', NULL, NULL, NULL, 'New Zealand', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (293, 'Countries', 'Active', NULL, NULL, NULL, 'Nicaragua', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (294, 'Countries', 'Active', NULL, NULL, NULL, 'Niger', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (295, 'Countries', 'Active', NULL, NULL, NULL, 'Norway', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (296, 'Countries', 'Active', NULL, NULL, NULL, 'Oman', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (297, 'Countries', 'Active', NULL, NULL, NULL, 'Pakistan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (298, 'Countries', 'Active', NULL, NULL, NULL, 'Palau', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (299, 'Countries', 'Active', NULL, NULL, NULL, 'Panama', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (300, 'Countries', 'Active', NULL, NULL, NULL, 'Papua New Guinea', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (301, 'Countries', 'Active', NULL, NULL, NULL, 'Paraguay', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (302, 'Countries', 'Active', NULL, NULL, NULL, 'Peru', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (303, 'Countries', 'Active', NULL, NULL, NULL, 'Philippines', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (304, 'Countries', 'Active', NULL, NULL, NULL, 'Poland', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (305, 'Countries', 'Active', NULL, NULL, NULL, 'Portugal', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (306, 'Countries', 'Active', NULL, NULL, NULL, 'Puerto Rico', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (307, 'Countries', 'Active', NULL, NULL, NULL, 'Qatar', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (308, 'Countries', 'Active', NULL, NULL, NULL, 'Romania', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (309, 'Countries', 'Active', NULL, NULL, NULL, 'Russia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (310, 'Countries', 'Active', NULL, NULL, NULL, 'Rwanda', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (311, 'Countries', 'Active', NULL, NULL, NULL, 'Saint Kitts & Nevis', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (312, 'Countries', 'Active', NULL, NULL, NULL, 'Saint Lucia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (313, 'Countries', 'Active', NULL, NULL, NULL, 'Samoa', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (314, 'Countries', 'Active', NULL, NULL, NULL, 'Sao Tome & Principe', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (315, 'Countries', 'Active', NULL, NULL, NULL, 'Saudi Arabia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (316, 'Countries', 'Active', NULL, NULL, NULL, 'Senegal', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (317, 'Countries', 'Active', NULL, NULL, NULL, 'Serbia & Montenegro', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (318, 'Countries', 'Active', NULL, NULL, NULL, 'Seychelles', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (319, 'Countries', 'Active', NULL, NULL, NULL, 'Sierra Leone', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (320, 'Countries', 'Active', NULL, NULL, NULL, 'Singapore', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (321, 'Countries', 'Active', NULL, NULL, NULL, 'Slovakia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (322, 'Countries', 'Active', NULL, NULL, NULL, 'Slovenia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (323, 'Countries', 'Active', NULL, NULL, NULL, 'Solomon Islands', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (324, 'Countries', 'Active', NULL, NULL, NULL, 'Somalia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (325, 'Countries', 'Active', NULL, NULL, NULL, 'South Africa', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (326, 'Countries', 'Active', NULL, NULL, NULL, 'Spain', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (327, 'Countries', 'Active', NULL, NULL, NULL, 'Sri Lanka', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (328, 'Countries', 'Active', NULL, NULL, NULL, 'Suriname', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (329, 'Countries', 'Active', NULL, NULL, NULL, 'Swaziland', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (330, 'Countries', 'Active', NULL, NULL, NULL, 'Sweden', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (331, 'Countries', 'Active', NULL, NULL, NULL, 'Switzerland', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (332, 'Countries', 'Active', NULL, NULL, NULL, 'Taiwan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (333, 'Countries', 'Active', NULL, NULL, NULL, 'Tajikistan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (334, 'Countries', 'Active', NULL, NULL, NULL, 'Tanzania', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (335, 'Countries', 'Active', NULL, NULL, NULL, 'Thailand', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (336, 'Countries', 'Active', NULL, NULL, NULL, 'The Channel Islands', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (337, 'Countries', 'Active', NULL, NULL, NULL, 'The Netherlands Antilles', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (338, 'Countries', 'Active', NULL, NULL, NULL, 'Togo', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (339, 'Countries', 'Active', NULL, NULL, NULL, 'Tonga', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (340, 'Countries', 'Active', NULL, NULL, NULL, 'Trinidad & Tobago', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (341, 'Countries', 'Active', NULL, NULL, NULL, 'Tunisia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (342, 'Countries', 'Active', NULL, NULL, NULL, 'Turkey', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (343, 'Countries', 'Active', NULL, NULL, NULL, 'Turkmenistan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (344, 'Countries', 'Active', NULL, NULL, NULL, 'Tuvalu', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (345, 'Countries', 'Active', NULL, NULL, NULL, 'UAE', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (346, 'Countries', 'Active', NULL, NULL, NULL, 'Uganda', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (347, 'Countries', 'Active', NULL, NULL, NULL, 'UK', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (348, 'Countries', 'Active', NULL, NULL, NULL, 'Ukraine', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (349, 'Countries', 'Active', NULL, NULL, NULL, 'Uruguay', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (350, 'Countries', 'Active', NULL, NULL, NULL, 'Uzbekistan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (351, 'Countries', 'Active', NULL, NULL, NULL, 'Vanuatu', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (352, 'Countries', 'Active', NULL, NULL, NULL, 'Venezuela', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (353, 'Countries', 'Active', NULL, NULL, NULL, 'Vietnam', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (354, 'Countries', 'Active', NULL, NULL, NULL, 'Virgin Island', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (355, 'Countries', 'Active', NULL, NULL, NULL, 'Zambia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Reffered (Permission)', 'Open', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (356, 'Countries', 'Active', NULL, NULL, NULL, 'Afghanistan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:19:39', 1, '2019-04-15 13:38:19', 1);
INSERT INTO `codes` VALUES (357, 'Countries', 'Active', NULL, NULL, NULL, 'Congo / DR Congo', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:00', 1, '2019-04-15 13:38:30', 1);
INSERT INTO `codes` VALUES (358, 'Countries', 'Active', NULL, NULL, NULL, 'Cote d\' lvoire', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:10', 1, '2019-04-15 13:38:38', 1);
INSERT INTO `codes` VALUES (359, 'Countries', 'Active', NULL, NULL, NULL, 'Cuba', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:18', 1, '2019-04-15 13:39:46', 1);
INSERT INTO `codes` VALUES (360, 'Countries', 'Active', NULL, NULL, NULL, 'Guatemala', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:25', 1, '2019-04-15 13:39:52', 1);
INSERT INTO `codes` VALUES (361, 'Countries', 'Active', NULL, NULL, NULL, 'Iran', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:32', 1, '2019-04-15 13:39:57', 1);
INSERT INTO `codes` VALUES (362, 'Countries', 'Active', NULL, NULL, NULL, 'Iraq', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:39', 1, '2019-04-15 13:40:03', 1);
INSERT INTO `codes` VALUES (363, 'Countries', 'Active', NULL, NULL, NULL, 'Liberia', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:47', 1, '2019-04-15 13:40:10', 1);
INSERT INTO `codes` VALUES (364, 'Countries', 'Active', NULL, NULL, NULL, 'Libya', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:20:53', 1, '2019-04-15 13:40:25', 1);
INSERT INTO `codes` VALUES (365, 'Countries', 'Active', NULL, NULL, NULL, 'Mexico', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:01', 1, '2019-04-15 13:40:30', 1);
INSERT INTO `codes` VALUES (366, 'Countries', 'Active', NULL, NULL, NULL, 'Myanmar', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:09', 1, '2019-04-15 13:40:36', 1);
INSERT INTO `codes` VALUES (367, 'Countries', 'Active', NULL, NULL, NULL, 'North Korea', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:17', 1, '2019-04-15 13:40:41', 1);
INSERT INTO `codes` VALUES (368, 'Countries', 'Active', NULL, NULL, NULL, 'Sudan', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:24', 1, '2019-04-15 13:40:47', 1);
INSERT INTO `codes` VALUES (369, 'Countries', 'Active', NULL, NULL, NULL, 'Syria', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:31', 1, '2019-04-15 13:40:52', 1);
INSERT INTO `codes` VALUES (370, 'Countries', 'Active', NULL, NULL, NULL, 'Yemen', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:37', 1, '2019-04-15 13:41:00', 1);
INSERT INTO `codes` VALUES (371, 'Countries', 'Active', NULL, NULL, NULL, 'Zimbabwe', 'Country Name', '', 'Short Code', NULL, NULL, 'Open/Approval/Reject', 'Reject', '', NULL, '2019-03-29 11:21:44', 1, '2019-04-15 13:38:14', 1);
INSERT INTO `codes` VALUES (372, 'code', 'Active', '##', '', '', 'Occupations', 'Occupation', '', 'Kemter ID', NULL, NULL, 'Sort', '10#11#12#13#14#15#16#17#18#19#20', '', '', '2019-06-06 10:15:43', 1, '2019-06-06 12:05:20', 1);
INSERT INTO `codes` VALUES (374, 'Occupations', 'Active', NULL, NULL, NULL, 'ACCOUNTANT', 'Occupation', '2', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (375, 'Occupations', 'Active', NULL, NULL, NULL, 'AGRICULTURE LABOURER', 'Occupation', '3', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (376, 'Occupations', 'Active', NULL, NULL, NULL, 'ASSISTANT DENTIST', 'Occupation', '4', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (377, 'Occupations', 'Active', NULL, NULL, NULL, 'ASSISTANT MANAGER', 'Occupation', '5', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (378, 'Occupations', 'Active', NULL, NULL, NULL, 'ΞΕΝΟΔΟΧΕΙΑ ΚΑΙ ΕΣΤΙΑΤΟΡΙΑ', 'Occupation', '06', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (379, 'Occupations', 'Active', NULL, NULL, NULL, 'BAKER', 'Occupation', '6', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (380, 'Occupations', 'Active', NULL, NULL, NULL, 'BARMAN', 'Occupation', '7', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (381, 'Occupations', 'Active', NULL, NULL, NULL, 'BUSINESSMAN', 'Occupation', '8', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (382, 'Occupations', 'Active', NULL, NULL, NULL, 'BUSINESSWOMAN', 'Occupation', '9', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (383, 'Occupations', 'Active', NULL, NULL, NULL, 'CARETAKER', 'Occupation', '10', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (384, 'Occupations', 'Active', NULL, NULL, NULL, 'CASHIER', 'Occupation', '11', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (385, 'Occupations', 'Active', NULL, NULL, NULL, 'CHAMBERMAID', 'Occupation', '12', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (386, 'Occupations', 'Active', NULL, NULL, NULL, 'CHIEF OFFICER', 'Occupation', '13', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (387, 'Occupations', 'Active', NULL, NULL, NULL, 'CHILD', 'Occupation', '14', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (388, 'Occupations', 'Active', NULL, NULL, NULL, 'CHOCOLATE SPECIALIST', 'Occupation', '15', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (389, 'Occupations', 'Active', NULL, NULL, NULL, 'CHOREOGRAPHER', 'Occupation', '16', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (390, 'Occupations', 'Active', NULL, NULL, NULL, 'CLEANER', 'Occupation', '17', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (391, 'Occupations', 'Active', NULL, NULL, NULL, 'COOK', 'Occupation', '18', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (392, 'Occupations', 'Active', NULL, NULL, NULL, 'COOK A', 'Occupation', '19', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (393, 'Occupations', 'Active', NULL, NULL, NULL, 'COOK B', 'Occupation', '20', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (394, 'Occupations', 'Active', NULL, NULL, NULL, 'DIPLOMATIC STAFF', 'Occupation', '21', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (395, 'Occupations', 'Active', NULL, NULL, NULL, 'DIRECTOR', 'Occupation', '22', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (396, 'Occupations', 'Active', NULL, NULL, NULL, 'DOMESTIC WORKER', 'Occupation', '23', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (397, 'Occupations', 'Active', NULL, NULL, NULL, 'FARM LABOURER', 'Occupation', '24', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (398, 'Occupations', 'Active', NULL, NULL, NULL, 'FARMER', 'Occupation', '25', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (399, 'Occupations', 'Active', NULL, NULL, NULL, 'FISH FARM LABOURER', 'Occupation', '26', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (400, 'Occupations', 'Active', NULL, NULL, NULL, 'GENERAL MANAGER', 'Occupation', '27', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (401, 'Occupations', 'Active', NULL, NULL, NULL, 'HEAD OF CUSTOME SERVICE', 'Occupation', '28', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (402, 'Occupations', 'Active', NULL, NULL, NULL, 'HOTEL EMPLOYEE', 'Occupation', '29', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (403, 'Occupations', 'Active', NULL, NULL, NULL, 'HOUSEBOY', 'Occupation', '30', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (404, 'Occupations', 'Active', NULL, NULL, NULL, 'HOUSEKEEPER', 'Occupation', '31', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (405, 'Occupations', 'Active', NULL, NULL, NULL, 'HOUSEWIFE', 'Occupation', '32', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (406, 'Occupations', 'Active', NULL, NULL, NULL, 'KEY PERSONNEL', 'Occupation', '33', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (407, 'Occupations', 'Active', NULL, NULL, NULL, 'KITCHEN ASSISTANT', 'Occupation', '34', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (408, 'Occupations', 'Active', NULL, NULL, NULL, 'LABOURER', 'Occupation', '35', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (409, 'Occupations', 'Active', NULL, NULL, NULL, 'MANAGER', 'Occupation', '36', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (410, 'Occupations', 'Active', NULL, NULL, NULL, 'MECHANIC', 'Occupation', '37', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (411, 'Occupations', 'Active', NULL, NULL, NULL, 'OFFICE ADMINISTRATOR', 'Occupation', '38', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (412, 'Occupations', 'Active', NULL, NULL, NULL, 'PAINTER', 'Occupation', '39', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (413, 'Occupations', 'Active', NULL, NULL, NULL, 'PRIEST', 'Occupation', '40', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (414, 'Occupations', 'Active', NULL, NULL, NULL, 'PRIVATE EMPLOYEE', 'Occupation', '41', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (415, 'Occupations', 'Active', NULL, NULL, NULL, 'PUPIL', 'Occupation', '42', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (416, 'Occupations', 'Active', NULL, NULL, NULL, 'QUARRY LABOURER', 'Occupation', '43', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (417, 'Occupations', 'Active', NULL, NULL, NULL, 'RESTAURANT EMPLOYEE', 'Occupation', '44', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (418, 'Occupations', 'Active', NULL, NULL, NULL, 'SALES ACCOUNT MANAGER', 'Occupation', '45', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (419, 'Occupations', 'Active', NULL, NULL, NULL, 'SALES ASSISTANT', 'Occupation', '46', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (420, 'Occupations', 'Active', NULL, NULL, NULL, 'SALES WOMAN', 'Occupation', '47', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (421, 'Occupations', 'Active', NULL, NULL, NULL, 'SECRETARY', 'Occupation', '48', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (422, 'Occupations', 'Active', NULL, NULL, NULL, 'SELF EMPLOYEED', 'Occupation', '49', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (423, 'Occupations', 'Active', NULL, NULL, NULL, 'SERVICE OFFICER', 'Occupation', '50', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (424, 'Occupations', 'Active', NULL, NULL, NULL, 'SPA THERAPIST', 'Occupation', '51', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (425, 'Occupations', 'Active', NULL, NULL, NULL, 'STUDENT', 'Occupation', '52', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (426, 'Occupations', 'Active', NULL, NULL, NULL, 'SUPERMARKET EMPLOYEE', 'Occupation', '53', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (427, 'Occupations', 'Active', NULL, NULL, NULL, 'TEACHER', 'Occupation', '54', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (428, 'Occupations', 'Active', NULL, NULL, NULL, 'TECHNICIAN', 'Occupation', '55', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (429, 'Occupations', 'Active', NULL, NULL, NULL, 'TENNNIS COACH', 'Occupation', '56', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (430, 'Occupations', 'Active', NULL, NULL, NULL, 'TOURIST REPRESENTATIVE', 'Occupation', '57', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (431, 'Occupations', 'Active', NULL, NULL, NULL, 'TRAVEL AGENT', 'Occupation', '58', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (432, 'Occupations', 'Active', NULL, NULL, NULL, 'TREASURER', 'Occupation', '59', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (433, 'Occupations', 'Active', NULL, NULL, NULL, 'VISITOR', 'Occupation', '60', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (434, 'Occupations', 'Active', NULL, NULL, NULL, 'VOLLEY BALL PLAYER', 'Occupation', '61', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (435, 'Occupations', 'Active', NULL, NULL, NULL, 'WAITRESS', 'Occupation', '62', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (436, 'Occupations', 'Active', NULL, NULL, NULL, 'HEALTH STAFF', 'Occupation', '63', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (437, 'Occupations', 'Active', NULL, NULL, NULL, 'BUILDER TECHNICIAN', 'Occupation', '64', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (438, 'Occupations', 'Active', NULL, NULL, NULL, 'CHEF', 'Occupation', '65', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (439, 'Occupations', 'Active', NULL, NULL, NULL, 'BUILDER', 'Occupation', '66', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (440, 'Occupations', 'Active', NULL, NULL, NULL, 'COMPUTER PROGRAMMER', 'Occupation', '67', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (441, 'Occupations', 'Active', NULL, NULL, NULL, 'BUILDING CONTRACTOR', 'Occupation', '68', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (442, 'Occupations', 'Active', NULL, NULL, NULL, 'TRANSLATOR', 'Occupation', '69', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (443, 'Occupations', 'Active', NULL, NULL, NULL, 'ASSISTANT STOCK KEEPER', 'Occupation', '70', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (444, 'Occupations', 'Active', NULL, NULL, NULL, 'HEAD RECEPTIONIST', 'Occupation', '71', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (445, 'Occupations', 'Active', NULL, NULL, NULL, 'HAIRDRESSER', 'Occupation', '72', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (446, 'Occupations', 'Active', NULL, NULL, NULL, 'MASSEUR', 'Occupation', '73', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (447, 'Occupations', 'Active', NULL, NULL, NULL, 'SALESMAN', 'Occupation', '74', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (448, 'Occupations', 'Active', NULL, NULL, NULL, 'POOL CLEANER', 'Occupation', '75', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (449, 'Occupations', 'Active', NULL, NULL, NULL, 'BARMAID', 'Occupation', '76', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (450, 'Occupations', 'Active', NULL, NULL, NULL, 'CUSTOMER SUPPORT', 'Occupation', '77', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (451, 'Occupations', 'Active', NULL, NULL, NULL, 'TAILOR', 'Occupation', '78', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (452, 'Occupations', 'Active', NULL, NULL, NULL, 'VESSEL OPERATOR', 'Occupation', '79', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (453, 'Occupations', 'Active', NULL, NULL, NULL, 'WELDER AT HEIGHTS', 'Occupation', '80', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (454, 'Occupations', 'Active', NULL, NULL, NULL, 'CATERING SERVICES', 'Occupation', '81', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (455, 'Occupations', 'Active', NULL, NULL, NULL, 'DANCER', 'Occupation', '82', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (456, 'Occupations', 'Active', NULL, NULL, NULL, 'HAIRDRESSER', 'Occupation', '83', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (457, 'Occupations', 'Active', NULL, NULL, NULL, 'FOOTBALL PLAYER', 'Occupation', '84', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (458, 'Occupations', 'Active', NULL, NULL, NULL, 'COACH', 'Occupation', '85', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (459, 'Occupations', 'Active', NULL, NULL, NULL, 'BEAUTICIAN', 'Occupation', '86', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (460, 'Occupations', 'Active', NULL, NULL, NULL, 'WINDOW CLEANER', 'Occupation', '87', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (461, 'Occupations', 'Active', NULL, NULL, NULL, 'LAWYER', 'Occupation', '88', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (462, 'Occupations', 'Active', NULL, NULL, NULL, 'BACK OFFICE STAFF', 'Occupation', '89', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (463, 'Occupations', 'Active', NULL, NULL, NULL, 'GARDENER', 'Occupation', '90', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (464, 'Occupations', 'Active', NULL, NULL, NULL, 'GENERAL LABOUR', 'Occupation', '91', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (465, 'Occupations', 'Active', NULL, NULL, NULL, 'FINANCIAL AND CONSULTING SERVICES', 'Occupation', '92', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (466, 'Occupations', 'Active', NULL, NULL, NULL, 'WORKER', 'Occupation', '93', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (467, 'Occupations', 'Active', NULL, NULL, NULL, 'HEAD OF ELECTRONIC TRADING DEVELOPMENT', 'Occupation', '94', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (468, 'Occupations', 'Active', NULL, NULL, NULL, 'PHARMACEUTICAL', 'Occupation', '95', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (469, 'Occupations', 'Active', NULL, NULL, NULL, 'CONSTRUCTIONS', 'Occupation', '96', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (470, 'Occupations', 'Active', NULL, NULL, NULL, 'STOCK KEEPER', 'Occupation', '97', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (471, 'Occupations', 'Active', NULL, NULL, NULL, 'BLACKSMITH', 'Occupation', '98', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (472, 'Occupations', 'Active', NULL, NULL, NULL, 'FLORIST', 'Occupation', '99', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (473, 'Occupations', 'Active', NULL, NULL, NULL, 'OFFSHORE TRADING COMPANY', 'Occupation', '100', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (474, 'Occupations', 'Active', NULL, NULL, NULL, 'ASSISTANT BAKER', 'Occupation', '101', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (475, 'Occupations', 'Active', NULL, NULL, NULL, 'OFFICE EMPLOYEE', 'Occupation', '102', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (476, 'Occupations', 'Active', NULL, NULL, NULL, 'ASSISTANT IN KITCHEN', 'Occupation', '103', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (477, 'Occupations', 'Active', NULL, NULL, NULL, 'CHARITY', 'Occupation', '104', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (478, 'Occupations', 'Active', NULL, NULL, NULL, 'SUPERVISOR', 'Occupation', '105', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (479, 'Occupations', 'Active', NULL, NULL, NULL, 'WAITER', 'Occupation', '106', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (480, 'Occupations', 'Active', NULL, NULL, NULL, 'TOUR OPERATOR', 'Occupation', '107', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (481, 'Occupations', 'Active', NULL, NULL, NULL, 'SALES MANAGER', 'Occupation', '108', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (482, 'Occupations', 'Active', NULL, NULL, NULL, 'IT SPECIALIST', 'Occupation', '109', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (483, 'Occupations', 'Active', NULL, NULL, NULL, 'DELIVERY DRIVER', 'Occupation', '110', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (484, 'Occupations', 'Active', NULL, NULL, NULL, 'HEAVES', 'Occupation', '111', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (485, 'Occupations', 'Active', NULL, NULL, NULL, 'PROJECT AND PRODUCT MANAGER', 'Occupation', '112', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (486, 'Occupations', 'Active', NULL, NULL, NULL, 'ROBOTIC MACHINE OPERATOR', 'Occupation', '113', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (487, 'Occupations', 'Active', NULL, NULL, NULL, 'OFFICE STAFF', 'Occupation', '114', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (488, 'Occupations', 'Active', NULL, NULL, NULL, 'WEB DEVELOPER', 'Occupation', '115', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (489, 'Occupations', 'Active', NULL, NULL, NULL, 'INVESTMENT COMPANY', 'Occupation', '116', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (490, 'Occupations', 'Active', NULL, NULL, NULL, 'DEVELOPER', 'Occupation', '117', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (491, 'Occupations', 'Active', NULL, NULL, NULL, 'ΟΙΚΙΑΚΕΣ ΥΠΗΡΕΣΙΕΣ', 'Occupation', '118', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (492, 'Occupations', 'Active', NULL, NULL, NULL, 'CLIENT RELATIONS MANAGER', 'Occupation', '119', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (493, 'Occupations', 'Active', NULL, NULL, NULL, 'ΓΡΑΦΕΙΑΚΕΣ ΥΠΗΡΕΣΙΕΣ', 'Occupation', '120', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (494, 'Occupations', 'Active', NULL, NULL, NULL, 'DENTIST', 'Occupation', '121', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (495, 'Occupations', 'Active', NULL, NULL, NULL, 'ΚΤΗΝΟΤΡΟΦΙΚΕΣ ΕΡΓΑΣΙΕΣ', 'Occupation', '122', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (496, 'Occupations', 'Active', NULL, NULL, NULL, 'ΓΕΩΡΓΙΚΕΣ ΕΡΓΑΣΙΕΣ', 'Occupation', '123', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (497, 'Occupations', 'Active', NULL, NULL, NULL, 'ΕΡΓΑΣΙΕΣ ΦΑΡΜΑΣ', 'Occupation', '124', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (498, 'Occupations', 'Active', NULL, NULL, NULL, 'ΓΕΩΡΓΟΚΤΗΝΟΤΡΟΦΙΚΕΣ ΕΡΓΑΣΙΕΣ', 'Occupation', '125', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (499, 'Occupations', 'Active', NULL, NULL, NULL, 'TECHNICAL ENGINEER', 'Occupation', '126', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (500, 'Occupations', 'Active', NULL, NULL, NULL, 'ARCHITECT', 'Occupation', '127', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (501, 'Occupations', 'Active', NULL, NULL, NULL, 'ΚΑΘΑΡΙΣΤΡΙΑ ΞΕΝΟΔΟΧΕΙΟΥ', 'Occupation', '128', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (502, 'Occupations', 'Active', NULL, NULL, NULL, 'DEVELOPMENT AND OPERATIONS MANAGER', 'Occupation', '129', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (503, 'Occupations', 'Active', NULL, NULL, NULL, 'ΕΡΓΑΣΙΕΣ ΙΧΘΥΟΤΡΟΦΕΙΟΥ', 'Occupation', '130', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (504, 'Occupations', 'Active', NULL, NULL, NULL, 'ΤΕΧΝΙΚΟΣ ΦΩΤΟΒΟΛΤΑΙΚΩΝ', 'Occupation', '131', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (505, 'Occupations', 'Active', NULL, NULL, NULL, 'KINDERGARTEN TEACHER', 'Occupation', '132', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (506, 'Occupations', 'Active', NULL, NULL, NULL, 'REAL ESTATE CONSULTANT', 'Occupation', '133', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (507, 'Occupations', 'Active', NULL, NULL, NULL, 'IT ADMINISTRATOR', 'Occupation', '134', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (508, 'Occupations', 'Active', NULL, NULL, NULL, 'ΦΙΛΑΝΘΡΩΠΙΚΟΣ ΟΡΓΑΝΙΣΜΟΣ', 'Occupation', '135', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (509, 'Occupations', 'Active', NULL, NULL, NULL, 'DEPUTY HEAD OF ADMINISTRATION', 'Occupation', '136', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (510, 'Occupations', 'Active', NULL, NULL, NULL, 'CUSTOMER SUPPORT REPRESENTATIVE', 'Occupation', '137', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (511, 'Occupations', 'Active', NULL, NULL, NULL, 'BUSINESS CONSULTANT', 'Occupation', '138', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (512, 'Occupations', 'Active', NULL, NULL, NULL, 'GYM INSTRUCTOR', 'Occupation', '139', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (513, 'Occupations', 'Active', NULL, NULL, NULL, 'AUDITOR', 'Occupation', '140', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (514, 'Occupations', 'Active', NULL, NULL, NULL, 'CAR WASH EMPLOYEE', 'Occupation', '141', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (515, 'Occupations', 'Active', NULL, NULL, NULL, 'ΚΗΠΟΥΡΟΙ', 'Occupation', '142', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (516, 'Occupations', 'Active', NULL, NULL, NULL, 'CHIEF ACCOUNTANT', 'Occupation', '143', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (517, 'Occupations', 'Active', NULL, NULL, NULL, 'SURVEYING ENGINEER', 'Occupation', '144', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (518, 'Occupations', 'Active', NULL, NULL, NULL, 'JAVA DEVELOPER', 'Occupation', '145', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (519, 'Occupations', 'Active', NULL, NULL, NULL, 'SETTLEMENT\'S AND BANK OFFICE REPRESENTATIVE', 'Occupation', '146', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (520, 'Occupations', 'Active', NULL, NULL, NULL, 'ENTERTAINER', 'Occupation', '147', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (521, 'Occupations', 'Active', NULL, NULL, NULL, 'BEAUTY SALOON MANAGER', 'Occupation', '148', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (522, 'Occupations', 'Active', NULL, NULL, NULL, 'LEGAL CONSULTANT', 'Occupation', '149', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (523, 'Occupations', 'Active', NULL, NULL, NULL, 'INTERNET GAME DEVELOPER', 'Occupation', '150', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (524, 'Occupations', 'Active', NULL, NULL, NULL, 'FASHION DESIGNER', 'Occupation', '151', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (525, 'Occupations', 'Active', NULL, NULL, NULL, 'ΑΡΤΟΠΟΙΕΙΟ', 'Occupation', '152', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (526, 'Occupations', 'Active', NULL, NULL, NULL, 'WAKESURE TEACHER', 'Occupation', '153', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (527, 'Occupations', 'Active', NULL, NULL, NULL, 'SOFTWARE DEVELOPER', 'Occupation', '154', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (528, 'Occupations', 'Active', NULL, NULL, NULL, 'CONSULTANT', 'Occupation', '155', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (529, 'Occupations', 'Active', NULL, NULL, NULL, 'ΧΡΗΜΑΤΟΟΙΚΟΝΟΜΙΚΕΣ ΥΠΗΡΕΣΙΕΣ', 'Occupation', '156', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (530, 'Occupations', 'Active', NULL, NULL, NULL, 'STOCK EXCHANGE', 'Occupation', '157', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (531, 'Occupations', 'Active', NULL, NULL, NULL, 'LEAD FINANCE SPECIALIST', 'Occupation', '158', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (532, 'Occupations', 'Active', NULL, NULL, NULL, 'MAINTENANCE', 'Occupation', '159', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (533, 'Occupations', 'Active', NULL, NULL, NULL, 'DIVER', 'Occupation', '160', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (534, 'Occupations', 'Active', NULL, NULL, NULL, 'COMPUTER & NETWORK SECURITY', 'Occupation', '161', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (535, 'Occupations', 'Active', NULL, NULL, NULL, 'CHEF EXECUTIVE OFFICER', 'Occupation', '162', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (536, 'Occupations', 'Active', NULL, NULL, NULL, 'UN  OFFICER', 'Occupation', '163', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (537, 'Occupations', 'Active', NULL, NULL, NULL, 'BUSINESS ANALYTIC', 'Occupation', '164', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (538, 'Occupations', 'Active', NULL, NULL, NULL, 'INTERPRETER', 'Occupation', '165', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `codes` VALUES (539, 'Occupations', 'Active', NULL, NULL, NULL, 'ONLINE GAMES', 'Occupation', '166', 'Kemter ID', NULL, NULL, 'Sort', '20', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for customer_group_relation
-- ----------------------------
DROP TABLE IF EXISTS `customer_group_relation`;
CREATE TABLE `customer_group_relation`  (
  `cstg_customer_group_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cstg_customer_ID` int(8) NOT NULL DEFAULT 0,
  `cstg_customer_groups_ID` int(8) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cstg_customer_group_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_group_relation
-- ----------------------------
INSERT INTO `customer_group_relation` VALUES (1, 1, 2);
INSERT INTO `customer_group_relation` VALUES (2, 1, 1);
INSERT INTO `customer_group_relation` VALUES (3, 2, 1);
INSERT INTO `customer_group_relation` VALUES (4, 3, 1);
INSERT INTO `customer_group_relation` VALUES (5, 3, 2);

-- ----------------------------
-- Table structure for customer_groups
-- ----------------------------
DROP TABLE IF EXISTS `customer_groups`;
CREATE TABLE `customer_groups`  (
  `csg_customer_group_ID` int(8) NOT NULL AUTO_INCREMENT,
  `csg_for_user_group_ID` int(8) NOT NULL DEFAULT 0,
  `csg_active` int(1) NOT NULL DEFAULT 0,
  `csg_code` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `csg_description` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`csg_customer_group_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_groups
-- ----------------------------
INSERT INTO `customer_groups` VALUES (1, 0, 1, 'testGroup', 'A test customer Groups');
INSERT INTO `customer_groups` VALUES (2, 0, 1, 'test2', 'Test2');

-- ----------------------------
-- Table structure for customer_products
-- ----------------------------
DROP TABLE IF EXISTS `customer_products`;
CREATE TABLE `customer_products`  (
  `cspr_customer_product_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cspr_customer_ID` int(8) NULL DEFAULT NULL,
  `cspr_product_ID` int(8) NULL DEFAULT NULL,
  `cspr_deal_type_code_ID` int(8) NULL DEFAULT NULL,
  `cspr_sold_date` date NULL DEFAULT NULL,
  `cspr_active` int(1) NULL DEFAULT NULL,
  `cspr_inactive_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cspr_created_date_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `cspr_created_by` int(8) NULL DEFAULT NULL,
  `cspr_last_update_date_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `cspr_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`cspr_customer_product_ID`) USING BTREE,
  INDEX `customer_ID`(`cspr_customer_ID`) USING BTREE,
  INDEX `product_ID`(`cspr_product_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_products
-- ----------------------------

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `cst_customer_ID` int(8) NOT NULL AUTO_INCREMENT,
  `cst_user_ID` int(8) NULL DEFAULT NULL,
  `cst_for_user_group_ID` int(8) NULL DEFAULT NULL,
  `cst_basic_account_ID` int(8) NULL DEFAULT NULL,
  `cst_entity_ID` int(8) NULL DEFAULT NULL,
  `cst_identity_card` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_surname` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_address_line_1` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_address_line_2` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_city_code_ID` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_contact_person` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_contact_person_title_code_ID` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_work_tel_1` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_work_tel_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_fax` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_mobile_1` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_mobile_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_email_newsletter` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cst_business_type_code_ID` int(8) NULL DEFAULT NULL,
  `cst_birthdate` date NULL DEFAULT NULL,
  `cst_credit_card_ID` int(8) NULL DEFAULT NULL,
  `cst_created_date_time` datetime(0) NULL DEFAULT NULL,
  `cst_created_by` int(8) NULL DEFAULT NULL,
  `cst_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `cst_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`cst_customer_ID`) USING BTREE,
  INDEX `name-surname-id-allTel`(`cst_identity_card`, `cst_name`, `cst_surname`, `cst_work_tel_1`, `cst_work_tel_2`, `cst_fax`, `cst_mobile_1`, `cst_mobile_2`) USING BTREE,
  INDEX `customerID`(`cst_customer_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Customers' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (1, 1, 1, 1, 3, '786613', 'Michalis', 'Ermogenous', 'add1', 'add2', '8', NULL, '18', '24123456', '24654321', '24010101', '99420544', '99123456', 'ermogenousm@gmail.com', 'ermogenousm@gmail.com', 5, '0000-00-00', NULL, NULL, NULL, '2019-11-06 11:10:31', 1);
INSERT INTO `customers` VALUES (2, 1, 1, 2, NULL, '123456', 'Giorgos', 'Georgiou', '', '', '8', '', '18', '24123456', '', '', '99123456', '', '', '', 12, NULL, NULL, '2018-08-24 00:51:42', 1, '2019-02-11 20:58:55', 1);
INSERT INTO `customers` VALUES (3, 1, 1, 3, NULL, '242424', 'Andreas', 'Andreou', '', '', '7', 'Andreas', '16', '24123654', '', '', '99123654', '', '', '', 5, '0000-00-00', NULL, '2018-10-02 10:16:06', 1, '2019-08-07 13:47:18', 1);
INSERT INTO `customers` VALUES (4, 1, 1, 4, NULL, '', 'Andreas', '', '', '', '8', '', '16', '', '', '', '', '', '', '', 4, '0000-00-00', NULL, '2019-02-10 10:37:30', 1, '2019-09-18 17:08:57', 1);
INSERT INTO `customers` VALUES (5, 1, 1, 5, NULL, '1212', 'Maria', 'Mariou', '', '', '8', '', '18', '', '', '', '', '', '', '', 12, '0000-00-00', NULL, '2019-02-10 10:40:41', 1, '2020-04-15 12:28:17', 1);
INSERT INTO `customers` VALUES (7, 1, 1, 6, NULL, '121212', 'dfsdfsd', '', '', '', '8', '', '18', '', '', '', '', '', '', '', 12, NULL, NULL, '2019-02-11 20:56:58', 1, '2019-02-11 20:58:55', 1);
INSERT INTO `customers` VALUES (8, 1, 1, 10, NULL, '4534543', 'Andreas', 'Georgiou', '', '', '8', '', '19', '', '', '', '', '', '', '', 5, '0000-00-00', NULL, '2019-03-07 13:31:57', 1, '2019-08-07 13:47:33', 1);
INSERT INTO `customers` VALUES (9, 1, 0, 11, NULL, '123456', 'Giorkos', 'Giorkou', '', '', '8', '', '', '', '', '', '', '', '', '', 12, NULL, NULL, '2019-07-02 12:36:29', 1, '2019-07-02 12:36:29', 1);
INSERT INTO `customers` VALUES (10, 5, 5, NULL, NULL, '111111', 'Anthimos', 'Anthimou', '', '', '8', '', '', '', '', '', '', '', '', '', 4, NULL, NULL, '2019-07-02 16:10:28', 5, NULL, NULL);
INSERT INTO `customers` VALUES (11, 5, 5, NULL, NULL, '646583', 'Froso', 'Irakli Nika', '', '', '8', '', '', '', '', '', '', '', '', '', 540, NULL, NULL, '2019-07-31 17:06:01', 5, NULL, NULL);
INSERT INTO `customers` VALUES (13, 1, 1, NULL, 4, '12121212', 'Mikes', 'Mikelss', '', '', '8', '', '', '', '', '', '', '', '', '', 5, '0000-00-00', NULL, '2019-11-06 11:53:54', 1, '2019-11-06 12:04:05', 1);
INSERT INTO `customers` VALUES (14, 1, 1, NULL, 5, '3746832', 'Cleopatra', 'Skampartoni', '', '', '8', '', '', '234242342', '', '', '', '', '', '', 5, '0000-00-00', NULL, '2019-11-06 12:13:54', 1, '2019-11-06 12:14:33', 1);
INSERT INTO `customers` VALUES (15, 6, 2, NULL, 2237, '123456', 'Test', 'Customer', '', '', '8', '', '', '', '', '', '', '', '', '', 12, '0000-00-00', NULL, '2020-03-20 17:18:44', 6, '2020-03-20 17:18:44', 6);


-- ----------------------------
-- Table structure for ina_credit_card_payments
-- ----------------------------
DROP TABLE IF EXISTS `ina_credit_card_payments`;
CREATE TABLE `ina_credit_card_payments`  (
  `inacrp_credit_card_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inacrp_credit_card_ID` int(8) NULL DEFAULT NULL,
  `inacrp_policy_primary_ID` int(8) NULL DEFAULT NULL,
  `inacrp_customer_ID` int(8) NULL DEFAULT NULL,
  `inacrp_status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inacrp_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inacrp_transaction_date_time` datetime(0) NULL DEFAULT NULL,
  `inacrp_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inacrp_created_by` int(8) NULL DEFAULT NULL,
  `inacrp_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inacrp_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inacrp_credit_card_payment_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_credit_card_payments
-- ----------------------------

-- ----------------------------
-- Table structure for ina_credit_cards
-- ----------------------------
DROP TABLE IF EXISTS `ina_credit_cards`;
CREATE TABLE `ina_credit_cards`  (
  `inacrc_credit_card_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inacrc_credit_card_remote_ID` int(8) NULL DEFAULT NULL COMMENT 'The id that comes from the remote payment system',
  `inacrc_status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inacrc_credit_card` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inacrc_remote_string` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `inacrc_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inacrc_created_by` int(8) NULL DEFAULT NULL,
  `inacrc_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inacrc_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inacrc_credit_card_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_credit_cards
-- ----------------------------

-- ----------------------------
-- Table structure for ina_input_forms
-- ----------------------------
DROP TABLE IF EXISTS `ina_input_forms`;
CREATE TABLE `ina_input_forms`  (
  `inaif_input_form_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaif_insurance_company_ID` int(8) NOT NULL,
  `inaif_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaif_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaif_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaif_description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaif_form_filename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaif_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaif_created_by` int(8) NULL DEFAULT NULL,
  `inaif_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaif_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaif_input_form_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_input_forms
-- ----------------------------
INSERT INTO `ina_input_forms` VALUES (1, 26, 'Active', 'Medical', 'Dcare Medical Form', 'Main form for the Dcare medical policies', 'dcare_medical.php', NULL, NULL, '2020-03-13 13:03:09', 1);

-- ----------------------------
-- Table structure for ina_insurance_codes
-- ----------------------------
DROP TABLE IF EXISTS `ina_insurance_codes`;
CREATE TABLE `ina_insurance_codes`  (
  `inaic_insurance_code_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaic_section` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inaic_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inaic_tab_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inaic_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inaic_description` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inaic_order` int(8) NULL DEFAULT NULL,
  `inaic_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaic_created_by` int(8) NULL DEFAULT NULL,
  `inaic_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaic_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaic_insurance_code_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_insurance_codes
-- ----------------------------
INSERT INTO `ina_insurance_codes` VALUES (1, 'policy_type', 'Fire', 'Risk Locations', 'Fire', 'Fire', 1, '2019-01-29 09:42:25', NULL, '2019-01-29 09:42:25', NULL);
INSERT INTO `ina_insurance_codes` VALUES (2, 'policy_type', 'Motor', 'Vehicles', 'Motor', 'Motor', 0, '2019-01-29 09:42:23', NULL, '2019-01-29 09:42:23', NULL);
INSERT INTO `ina_insurance_codes` VALUES (3, 'policy_type', 'EL', 'Members', 'EL', 'Employers Liability', 2, '2019-01-28 19:24:00', NULL, '2019-01-28 19:24:00', NULL);
INSERT INTO `ina_insurance_codes` VALUES (4, 'policy_type', 'PL', 'Members', 'PL', 'Public Liability', 3, '2019-01-28 19:24:02', NULL, '2019-01-28 19:24:02', NULL);
INSERT INTO `ina_insurance_codes` VALUES (5, 'policy_type', 'PI', 'Members', 'PI', 'Proffessional Indemnity', 7, '2019-01-28 19:24:04', NULL, '2019-01-28 19:24:04', NULL);
INSERT INTO `ina_insurance_codes` VALUES (6, 'policy_type', 'CAR', 'Risk Locations', 'CAR', 'Constructors All Risk', 6, '2019-01-29 09:42:29', NULL, '2019-01-29 09:42:29', NULL);
INSERT INTO `ina_insurance_codes` VALUES (7, 'policy_type', 'PA', 'Members', 'PA', 'Personal Accident', 4, '2019-01-28 19:24:05', NULL, '2019-01-28 19:24:05', NULL);
INSERT INTO `ina_insurance_codes` VALUES (8, 'policy_type', 'Medical', 'Members', 'Medical', 'Medical', 5, '2019-01-28 19:24:05', NULL, '2019-01-28 19:24:05', NULL);
INSERT INTO `ina_insurance_codes` VALUES (9, 'vehicle_body_type', 'Sedan', NULL, 'Sedan', 'Sedan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_insurance_codes` VALUES (10, 'vehicle_body_type', 'SUV', NULL, 'SUV', 'SUV', NULL, '2019-01-29 10:06:12', NULL, '2019-01-29 10:06:12', NULL);
INSERT INTO `ina_insurance_codes` VALUES (11, 'vehicle_body_type', 'MPV', NULL, 'MPV', 'MPV', NULL, '2019-01-29 10:06:17', NULL, '2019-01-29 10:06:17', NULL);
INSERT INTO `ina_insurance_codes` VALUES (12, 'vehicle_body_type', 'DoubleCabin', NULL, 'Double Cabin', 'Double Cabin', NULL, '2019-01-29 10:07:12', NULL, '2019-01-29 10:07:12', NULL);
INSERT INTO `ina_insurance_codes` VALUES (13, 'vehicle_make', 'Opel', NULL, 'Opel', 'Opel', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_insurance_codes` VALUES (14, 'vehicle_make', 'Toyota', NULL, 'Toyota', 'Toyota', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_insurance_codes` VALUES (15, 'vehicle_color', 'White', NULL, 'White', 'White', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_insurance_codes` VALUES (16, 'vehicle_color', 'Black', NULL, 'Black', 'Black', NULL, '2019-01-29 10:38:06', NULL, '2019-01-29 10:38:06', NULL);
INSERT INTO `ina_insurance_codes` VALUES (17, 'vehicle_color', 'Silver', NULL, 'Silver', 'Silver', NULL, '2019-01-29 10:38:09', NULL, '2019-01-29 10:38:09', NULL);

-- ----------------------------
-- Table structure for ina_insurance_companies
-- ----------------------------
DROP TABLE IF EXISTS `ina_insurance_companies`;
CREATE TABLE `ina_insurance_companies`  (
  `inainc_insurance_company_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inainc_entity_ID` int(8) NULL DEFAULT NULL,
  `inainc_status` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inainc_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `inainc_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `inainc_description` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inainc_country_code_ID` int(8) NOT NULL DEFAULT 0,
  `inainc_debtor_account_ID` int(8) NULL DEFAULT NULL,
  `inainc_revenue_account_ID` int(8) NULL DEFAULT NULL,
  `inainc_enable_commission_release` int(1) NULL DEFAULT NULL,
  `inainc_brokerage_agent` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inainc_use_motor` int(1) NOT NULL DEFAULT 0,
  `inainc_use_fire` int(1) NOT NULL DEFAULT 0,
  `inainc_use_pa` int(1) NOT NULL DEFAULT 0,
  `inainc_use_el` int(1) NOT NULL DEFAULT 0,
  `inainc_use_pi` int(1) NOT NULL DEFAULT 0,
  `inainc_use_pl` int(1) NOT NULL DEFAULT 0,
  `inainc_use_medical` int(1) NOT NULL DEFAULT 0,
  `inainc_use_travel` int(1) NULL DEFAULT NULL,
  `inainc_commission_motor_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_motor_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_fire_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_fire_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_pa_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_pa_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_el_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_el_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_pi_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_pi_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_pl_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_pl_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_medical_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_medical_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_travel_new` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_commission_travel_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inainc_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inainc_created_by` int(8) NOT NULL DEFAULT 0,
  `inainc_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inainc_last_update_by` int(8) NOT NULL DEFAULT 0,
  PRIMARY KEY (`inainc_insurance_company_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_insurance_companies
-- ----------------------------
INSERT INTO `ina_insurance_companies` VALUES (1, 12, 'Active', 'AI', 'AIG', 'AIG', 22, 56, 57, 1, 'brokerage', 1, 1, 1, 1, 1, 1, 1, 1, 11.00, 11.00, 12.00, 12.00, 13.00, 13.00, 14.00, 14.00, 15.00, 15.00, 16.00, 16.00, 17.00, 17.00, 18.00, 18.00, '2019-01-23 10:02:29', 1, '2020-06-12 16:14:18', 1);
INSERT INTO `ina_insurance_companies` VALUES (2, NULL, 'InActive', 'AL', 'ALLIANZ', 'ALLIANZ', 22, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:45:52', 1, '2019-05-27 16:56:11', 1);
INSERT INTO `ina_insurance_companies` VALUES (3, 17, 'Active', 'ALTIUS', 'ALTIUS', 'ALTIUS', 22, 68, 69, 1, NULL, 0, 0, 0, 0, 0, 1, 1, 0, 25.00, NULL, 30.00, NULL, 22.00, NULL, 22.00, NULL, 22.00, NULL, 22.00, NULL, 18.00, NULL, 25.00, NULL, '2019-01-23 10:48:39', 1, '2019-11-23 11:43:33', 1);
INSERT INTO `ina_insurance_companies` VALUES (4, NULL, 'Active', 'ATLANTIC', 'ATLANTIC', 'ATLANTIC', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 20.00, NULL, 19.00, NULL, 18.00, NULL, 17.00, NULL, 16.00, NULL, 15.00, NULL, 14.00, NULL, 13.00, NULL, '2019-01-23 10:48:48', 1, '2019-11-06 14:05:24', 1);
INSERT INTO `ina_insurance_companies` VALUES (5, NULL, 'Active', 'CNP', 'CNP', 'CNP', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:48:57', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (6, NULL, 'Active', 'COMMERCIAL GENERAL I', 'COMMERCIAL GENERAL INSURANCE', 'COMMERCIAL GENERAL INSURANCE', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:49:08', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (7, NULL, 'Active', 'COSMOS', 'COSMOS', 'COSMOS', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:49:17', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (8, NULL, 'Active', 'ETHNIKI GENERAL INSU', 'ETHNIKI GENERAL INSURANCE', 'ETHNIKI GENERAL INSURANCE', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:49:26', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (9, NULL, 'Active', 'EUROSURE', 'EUROSURE', 'EUROSURE', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:49:34', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (10, NULL, 'Active', 'GAN DIRECT', 'GAN DIRECT', 'GAN DIRECT', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:49:42', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (11, NULL, 'Active', 'GENERAL INSURANCE OF', 'GENERAL INSURANCE OF CYPRUS', 'GENERAL INSURANCE OF CYPRUS', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:50:31', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (12, NULL, 'Active', 'HYDRA', 'HYDRA', 'HYDRA', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:50:44', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (13, NULL, 'Active', 'KENTRIKI', 'KENTRIKI', 'KENTRIKI', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:50:52', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (14, NULL, 'Active', 'LUMEN', 'LUMEN', 'LUMEN', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:51:01', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (15, NULL, 'Active', 'MINERVA', 'MINERVA', 'MINERVA', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:51:19', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (16, NULL, 'Active', 'OLYMPIC', 'OLYMPIC', 'OLYMPIC', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:51:27', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (17, NULL, 'Active', 'PANCYPRIAN', 'PANCYPRIAN', 'PANCYPRIAN', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:51:36', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (18, NULL, 'Active', 'PRIME INSURANCE', 'PRIME INSURANCE', 'PRIME INSURANCE', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:51:44', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (19, NULL, 'Active', 'PROGRESSIVE', 'PROGRESSIVE', 'PROGRESSIVE', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:51:52', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (20, NULL, 'Active', 'ROYAL CROWN', 'ROYAL CROWN', 'ROYAL CROWN', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:52:06', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (21, NULL, 'Active', 'TRADEWISE INSURANCE ', 'TRADEWISE INSURANCE COMPANY LIMITED', 'TRADEWISE INSURANCE COMPANY LIMITED', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:52:16', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (22, NULL, 'Active', 'TRUST', 'TRUST', 'TRUST', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:52:24', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (23, NULL, 'Active', 'YDROGIOS', 'YDROGIOS', 'YDROGIOS', 22, 24, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 0, 25.00, NULL, 30.00, NULL, 25.00, NULL, 22.00, NULL, 22.00, NULL, 22.00, NULL, 20.00, NULL, 25.00, NULL, '2019-01-23 10:52:31', 1, '2019-08-23 14:52:48', 1);
INSERT INTO `ina_insurance_companies` VALUES (24, NULL, 'Active', 'ΚΟΙΝΟΠΡΑΞΙΑ', 'ΚΟΙΝΟΠΡΑΞΙΑ', 'ΚΟΙΝΟΠΡΑΞΙΑ', 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:52:39', 1, NULL, 0);
INSERT INTO `ina_insurance_companies` VALUES (25, 15, 'Active', 'ANYTIME', 'ANYTIME', 'ANYTIME', 22, 64, 65, 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-23 10:57:03', 1, '2019-11-22 18:47:51', 1);
INSERT INTO `ina_insurance_companies` VALUES (26, 16, 'Active', 'DCARE', 'DCARE', 'DCARE', 22, 66, 67, 1, NULL, 0, 0, 0, 0, 0, 0, 1, 0, 20.00, 19.00, 25.00, 24.00, 23.00, 22.00, 27.00, 26.00, 22.00, 21.00, 20.00, 19.00, 20.00, 18.00, 27.00, 25.00, '2019-11-22 18:49:34', 1, '2020-04-13 10:01:10', 1);

-- ----------------------------
-- Table structure for ina_insurance_company_packages
-- ----------------------------
DROP TABLE IF EXISTS `ina_insurance_company_packages`;
CREATE TABLE `ina_insurance_company_packages`  (
  `inaincpk_insurance_company_package_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaincpk_insurance_company_ID` int(8) NULL DEFAULT NULL,
  `inaincpk_status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaincpk_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaincpk_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaincpk_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaincpk_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaincpk_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaincpk_created_by` int(8) NULL DEFAULT NULL,
  `inaincpk_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaincpk_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaincpk_insurance_company_package_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_insurance_company_packages
-- ----------------------------
INSERT INTO `ina_insurance_company_packages` VALUES (1, 23, 'Active', 'Motor', 'MINI', 'Mini Comprehensive', 'Mini Comprehensive', '2019-07-22 11:49:21', 1, '2019-07-22 11:50:11', 1);
INSERT INTO `ina_insurance_company_packages` VALUES (2, 23, 'Active', 'Motor', 'MAXI', 'Maxi Comprehensive', 'Maxi Comprehensive', '2019-07-22 11:50:04', 1, NULL, NULL);
INSERT INTO `ina_insurance_company_packages` VALUES (3, 26, 'Active', 'Medical', 'Core', 'Core', 'Core', '2019-11-23 11:25:12', 1, NULL, NULL);
INSERT INTO `ina_insurance_company_packages` VALUES (4, 26, 'Active', 'Medical', 'Classic', 'Classic', 'Classic', '2019-11-23 11:25:25', 1, NULL, NULL);
INSERT INTO `ina_insurance_company_packages` VALUES (5, 26, 'Active', 'Medical', 'Prime', 'Prime', 'Prime', '2019-11-23 11:25:47', 1, NULL, NULL);
INSERT INTO `ina_insurance_company_packages` VALUES (6, 26, 'Active', 'Medical', 'Basic', 'Basic', 'Basic', '2019-11-23 11:27:05', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_issuing
-- ----------------------------
DROP TABLE IF EXISTS `ina_issuing`;
CREATE TABLE `ina_issuing`  (
  `inaiss_issue_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaiss_insurance_company_ID` int(8) NULL DEFAULT NULL,
  `inaiss_insurance_type` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_issue_number` int(1) NULL DEFAULT NULL,
  `inaiss_number_prefix` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_number_leading_zeros` int(12) NULL DEFAULT NULL,
  `inaiss_number_last_used` int(8) NULL DEFAULT NULL,
  `inaiss_certificate_issue_file` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_schedule_issue_file` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_item_custom_input_file` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_item_custom_view_file` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaiss_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaiss_created_by` int(8) NULL DEFAULT NULL,
  `inaiss_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaiss_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaiss_issue_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_issuing
-- ----------------------------
INSERT INTO `ina_issuing` VALUES (1, 26, 'Medical', 'DCare Medical Policies', 1, 'DCI-19', 7, 27, 'dcare/dcare_certificate.php', '', 'dcare/dcare_custom_member_item.php', 'dcare/dcare_custom_member_item_view.php', '2019-12-04 10:42:20', 1, '2020-08-13 10:07:57', 1);

-- ----------------------------
-- Table structure for ina_overwrite_agents
-- ----------------------------
DROP TABLE IF EXISTS `ina_overwrite_agents`;
CREATE TABLE `ina_overwrite_agents`  (
  `inaova_overwrite_agent_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaova_overwrite_ID` int(8) NULL DEFAULT NULL,
  `inaova_underwriter_ID` int(8) NULL DEFAULT NULL,
  `inaova_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaova_comm_motor_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_motor_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_fire_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_fire_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_pa_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_pa_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_el_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_el_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_pi_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_pi_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_pl_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_pl_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_medical_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_medical_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_travel_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_comm_travel_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaova_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaova_created_by` int(8) NULL DEFAULT NULL,
  `inaova_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaova_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaova_overwrite_agent_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_overwrite_agents
-- ----------------------------
INSERT INTO `ina_overwrite_agents` VALUES (1, 1, 2, 'Active', 2.01, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.20, 2.00, '2020-04-08 10:51:07', 1, '2020-04-09 19:56:07', 1);
INSERT INTO `ina_overwrite_agents` VALUES (2, 1, 4, 'Active', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, '2020-04-08 11:51:33', 1, NULL, NULL);
INSERT INTO `ina_overwrite_agents` VALUES (3, 2, 2, 'Active', 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, '2020-04-09 10:38:38', 1, '2020-04-12 09:49:34', 1);
INSERT INTO `ina_overwrite_agents` VALUES (4, 2, 5, 'Active', 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, 3.00, 2.00, '2020-04-09 10:45:28', 1, '2020-04-12 09:49:26', 1);
INSERT INTO `ina_overwrite_agents` VALUES (5, 1, 5, 'Active', 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, 2.00, '2020-04-09 10:45:44', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_overwrites
-- ----------------------------
DROP TABLE IF EXISTS `ina_overwrites`;
CREATE TABLE `ina_overwrites`  (
  `inaovr_overwrite_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaovr_underwriter_ID` int(8) NULL DEFAULT NULL,
  `inaovr_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `inaovr_dr_account_ID` int(8) NULL DEFAULT NULL,
  `inaovr_cr_account_ID` int(8) NULL DEFAULT NULL,
  `inaovr_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaovr_created_by` int(8) NULL DEFAULT NULL,
  `inaovr_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaovr_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaovr_overwrite_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_overwrites
-- ----------------------------
INSERT INTO `ina_overwrites` VALUES (1, 1, 'Active', 27, 62, '2020-04-03 17:21:54', 1, '2020-04-12 11:11:15', 1);
INSERT INTO `ina_overwrites` VALUES (2, 6, 'Active', 21, 63, '2020-04-08 11:57:47', 1, '2020-04-12 11:05:40', 1);

-- ----------------------------
-- Table structure for ina_policies
-- ----------------------------
DROP TABLE IF EXISTS `ina_policies`;
CREATE TABLE `ina_policies`  (
  `inapol_policy_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapol_for_user_group_ID` int(8) NULL DEFAULT NULL,
  `inapol_underwriter_ID` int(8) NULL DEFAULT NULL,
  `inapol_insurance_company_ID` int(8) NULL DEFAULT NULL,
  `inapol_customer_ID` int(8) NULL DEFAULT NULL,
  `inapol_installment_ID` int(8) NULL DEFAULT NULL,
  `inapol_issue_ID` int(8) NULL DEFAULT NULL,
  `inapol_type_code` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT 'Motor, Fire, EL, PL, PA, PI,',
  `inapol_policy_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapol_period_starting_date` date NULL DEFAULT NULL,
  `inapol_starting_date` date NULL DEFAULT NULL,
  `inapol_financial_date` date NULL DEFAULT NULL,
  `inapol_expiry_date` date NULL DEFAULT NULL,
  `inapol_status` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Outstanding\r\nActive\r\nArchived',
  `inapol_process_status` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapol_premium` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_mif` decimal(10, 2) NULL DEFAULT 0,
  `inapol_fees` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_stamps` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_special_discount` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_commission_released` decimal(10, 2) NULL DEFAULT 0,
  `inapol_subagent_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_subsubagent_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level1_ID` int(8) NULL DEFAULT NULL,
  `inapol_agent_level1_percent` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level1_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level1_released` decimal(10, 2) NULL DEFAULT 0,
  `inapol_agent_level2_ID` int(8) NULL DEFAULT NULL,
  `inapol_agent_level2_percent` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level2_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level2_released` decimal(10, 2) NULL DEFAULT 0,
  `inapol_agent_level3_ID` int(8) NULL DEFAULT NULL,
  `inapol_agent_level3_percent` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level3_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_agent_level3_released` decimal(10, 2) NULL DEFAULT 0,
  `inapol_overwrite_ID` int(8) NULL DEFAULT NULL,
  `inapol_overwrite_agent_ID` int(8) NULL DEFAULT NULL,
  `inapol_overwrite_percent` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_overwrite_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_overwrite_released` decimal(10, 2) NULL DEFAULT NULL,
  `inapol_credit_card_ID` int(8) NULL DEFAULT NULL,
  `inapol_replacing_ID` int(8) NULL DEFAULT 0,
  `inapol_replaced_by_ID` int(8) NULL DEFAULT 0,
  `inapol_comments` longtext CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `inapol_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inapol_created_by` int(8) NULL DEFAULT NULL,
  `inapol_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inapol_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inapol_policy_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 113 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_policies
-- ----------------------------
INSERT INTO `ina_policies` VALUES (1, 1, 1, 1, 8, 1, NULL, 'Motor', '1901-000001', '2019-06-26', '2019-06-26', '2019-06-26', '2019-12-25', 'Archived', 'New', 250.00, NULL, 25.00, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, '2019-06-26 12:16:42', 1, '2019-06-26 17:08:02', 1);
INSERT INTO `ina_policies` VALUES (3, 1, 1, 1, 8, 1, NULL, 'Motor', '1901-000001', '2019-06-26', '2019-06-30', '2019-06-30', '2019-12-25', 'Archived', 'Cancellation', -100.00, 0.00, 0.00, 0.00, NULL, -5.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, '2019-06-26 17:08:02', 1);
INSERT INTO `ina_policies` VALUES (4, 1, 1, 1, 8, 4, NULL, 'Motor', '1901-000002', '2019-06-28', '2019-06-28', '2019-06-28', '2020-06-27', 'Archived', 'New', 250.00, NULL, 25.00, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, NULL, '2019-06-28 13:48:35', 1, '2019-06-28 15:05:21', 1);
INSERT INTO `ina_policies` VALUES (5, 1, 1, 1, 8, 4, NULL, 'Motor', '1901-000002', '2019-06-28', '2019-06-29', '2019-06-29', '2020-06-27', 'Archived', 'Cancellation', -100.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 0, NULL, NULL, NULL, '2019-06-28 15:05:20', 1);
INSERT INTO `ina_policies` VALUES (6, 1, 1, 1, 1, 6, NULL, 'Fire', '1712-000001', '2019-06-28', '2019-06-28', '2019-06-28', '2020-06-27', 'Active', 'New', 250.00, NULL, 50.00, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-06-28 16:30:19', 1, '2019-06-28 16:35:11', 1);
INSERT INTO `ina_policies` VALUES (7, 1, 1, 3, 8, 7, NULL, 'PL', '2201-000001', '2019-06-28', '2019-06-28', '2019-06-28', '2020-06-27', 'Active', 'New', 250.00, NULL, 50.00, 2.00, NULL, 75.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-06-28 18:24:04', 1, '2019-07-09 10:55:19', 1);
INSERT INTO `ina_policies` VALUES (8, 1, 1, 1, 1, 8, NULL, 'Motor', '1901-010101', '2019-07-02', '2019-07-02', '2019-07-02', '2020-07-01', 'Active', 'New', 265.00, NULL, 25.00, 2.00, NULL, 75.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-02 12:54:01', 1, '2019-07-23 14:24:49', 1);
INSERT INTO `ina_policies` VALUES (9, 5, 6, 1, 10, 9, NULL, 'Motor', '1901-010101', '2019-07-02', '2019-07-02', '2019-07-02', '2020-07-01', 'Active', 'New', 250.00, NULL, 25.00, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-02 16:31:24', 5, '2019-07-02 16:32:07', 5);
INSERT INTO `ina_policies` VALUES (10, 1, 1, 1, 1, 10, NULL, 'Fire', '1901-010101', '2019-07-03', '2019-07-03', '2019-07-03', '2020-07-02', 'Archived', 'New', 200.00, NULL, 10.00, 2.00, NULL, 52.60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 14, NULL, '2019-07-03 10:18:49', 1, '2019-07-04 11:27:11', 1);
INSERT INTO `ina_policies` VALUES (11, 1, 1, 1, 1, 11, NULL, 'Fire', '1701-010101', '2019-07-03', '2019-07-03', '2019-07-03', '2020-07-02', 'Outstanding', 'New', 525.00, NULL, 25.00, 2.00, NULL, 63.00, NULL, 157.50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-03 11:52:55', 1, '2019-08-25 20:33:18', 1);
INSERT INTO `ina_policies` VALUES (12, 1, 1, 1, 1, 12, NULL, 'Motor', '1901-010102', '2018-06-03', '2018-06-03', '2018-06-03', '2019-06-02', 'Active', 'New', 150.00, NULL, 25.00, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 67, NULL, '2019-07-03 15:48:30', 1, '2019-07-19 00:03:39', 1);
INSERT INTO `ina_policies` VALUES (14, 1, 1, 1, 1, 10, NULL, 'Fire', '1901-010101', '2019-07-03', '2020-01-01', '2020-01-01', '2020-07-02', 'Active', 'Endorsement', -100.00, 0.00, 10.00, 0.00, NULL, -25.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0, NULL, NULL, NULL, '2019-07-09 10:42:55', 1);
INSERT INTO `ina_policies` VALUES (15, 1, 1, 1, 1, 15, NULL, 'Fire', '123456', '2019-07-11', '2019-07-11', '2019-07-11', '2020-07-10', 'Archived', 'New', 150.00, 0.00, 25.04, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 16, NULL, '2019-07-11 12:16:37', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policies` VALUES (16, 1, 1, 1, 1, 15, NULL, 'Fire', '123456', '2019-07-11', '2019-07-31', '2019-07-31', '2020-07-10', 'Archived', 'Cancellation', -140.00, 0.00, 0.00, 0.00, NULL, -40.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 0, NULL, '2019-07-11 12:30:25', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policies` VALUES (17, 1, 1, 1, 1, 17, NULL, 'Fire', '111111', '2019-07-11', '2019-07-11', '2019-07-11', '2020-07-10', 'Active', 'New', 250.00, 0.00, 25.00, 2.00, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-11 12:32:58', 1, '2019-07-11 12:36:16', 1);
INSERT INTO `ina_policies` VALUES (18, 1, 1, 1, 1, 18, NULL, 'Motor', '1901-011111', '2018-07-10', '2018-07-10', '2018-07-10', '2019-07-09', 'Active', 'New', 415.00, 0.00, 25.00, 2.00, NULL, 110.00, 62.22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 68, NULL, '2019-07-18 23:44:38', 1, '2020-04-16 10:25:04', 1);
INSERT INTO `ina_policies` VALUES (19, 1, 1, 23, 1, 19, NULL, 'Medical', '1101-000111', '2019-07-22', '2019-07-22', '2019-07-22', '2020-07-21', 'Active', 'New', 675.00, 0.00, 27.49, 2.00, NULL, 135.00, NULL, 95.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-22 10:29:57', 1, '2019-08-25 20:21:55', 1);
INSERT INTO `ina_policies` VALUES (20, 1, 1, 23, 3, 20, NULL, 'Medical', '1101-000001', '2019-07-01', '2019-07-01', '2019-07-01', '2020-06-30', 'Active', 'New', 1120.00, 0.00, 60.00, 2.00, NULL, 150.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-07-22 19:19:40', 1, '2019-07-22 19:23:11', 1);
INSERT INTO `ina_policies` VALUES (21, 1, 1, 1, 1, 21, NULL, 'Motor', '1901-023456', '2019-08-05', '2019-08-05', '2019-08-05', '2020-08-04', 'Active', 'New', 870.00, 0.00, 30.00, 2.00, NULL, 110.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-08-05 23:33:28', 1, '2019-08-12 20:33:07', 1);
INSERT INTO `ina_policies` VALUES (22, 1, 1, 1, 1, 22, NULL, 'Motor', '11111111111', '2019-09-03', '2019-09-03', '2019-09-03', '2020-09-02', 'Active', 'New', 300.00, 0.00, 25.00, 2.00, NULL, 33.11, NULL, 21.07, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-09-03 10:41:51', 1, '2019-10-15 10:31:19', 1);
INSERT INTO `ina_policies` VALUES (23, 1, 1, 1, 1, 23, NULL, 'Medical', '11121245', '2019-10-15', '2019-10-15', '2019-11-01', '2020-10-14', 'Active', 'New', 900.00, 0.00, 60.00, 2.00, NULL, 153.00, NULL, 117.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-10-15 10:34:51', 1, '2019-10-18 12:16:57', 1);
INSERT INTO `ina_policies` VALUES (24, 1, 5, 1, 2, 24, NULL, 'Fire', '1701-112243', '2019-10-18', '2019-10-18', '2019-10-18', '2020-10-17', 'Outstanding', 'New', 350.00, 0.00, 35.00, 2.00, NULL, 42.00, NULL, 0.00, NULL, 2, 11.00, 3.51, NULL, 4, 10.00, 21.01, NULL, 5, 4.00, 14.01, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-10-18 14:38:09', 1, '2019-12-03 15:12:54', 1);
INSERT INTO `ina_policies` VALUES (25, 1, 5, 1, 2, 25, NULL, 'Fire', '1701-112233', '2019-10-18', '2019-10-18', '2019-10-18', '2020-10-17', 'Active', 'New', 275.00, 0.00, 20.00, 2.00, NULL, 33.00, NULL, 11.00, 11.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-10-18 14:39:08', 1, '2019-11-19 14:25:21', 1);
INSERT INTO `ina_policies` VALUES (26, 1, 1, 1, 1, 26, NULL, 'Motor', '56565656', '2019-11-01', '2019-11-01', '2019-11-01', '2020-10-31', 'Active', 'New', 200.00, 0.00, 25.00, 2.00, NULL, 22.00, NULL, 8.12, 8.24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-11-19 16:44:18', 1, '2019-11-20 15:15:13', 1);
INSERT INTO `ina_policies` VALUES (27, 1, 1, 26, 2, 27, NULL, 'Medical', '11010101', '2019-11-22', '2019-11-22', '2019-11-22', '2020-11-21', 'Active', 'New', 1200.00, 0.00, 45.00, 2.00, NULL, 216.00, NULL, 48.00, 72.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-11-22 18:46:54', 1, '2019-11-23 17:18:14', 1);
INSERT INTO `ina_policies` VALUES (28, 1, 5, 1, 2, 28, NULL, 'Motor', '01010101', '2019-12-02', '2019-12-02', '2019-12-02', '2020-12-01', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 10.00, NULL, NULL, 4, 9.00, NULL, NULL, 5, 8.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-12-02 11:29:57', 1, '2019-12-02 14:13:33', 1);
INSERT INTO `ina_policies` VALUES (29, 1, 2, 26, 1, 29, NULL, 'Medical', NULL, '2019-12-05', '2019-12-05', '2019-12-05', '2020-12-04', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 15.00, NULL, NULL, 0, 0.00, NULL, NULL, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-12-05 10:24:57', 1, '2019-12-05 10:24:57', 1);
INSERT INTO `ina_policies` VALUES (30, 1, 2, 26, 1, 30, 1, 'Medical', 'DCI-190000001', '2019-12-05', '2019-12-05', '2019-12-05', '2020-12-04', 'Outstanding', 'New', 500.00, 0.00, 40.00, 2.00, NULL, 45.00, NULL, NULL, NULL, 2, 15.00, 37.50, NULL, 0, 0.00, NULL, NULL, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2019-12-05 10:28:25', 1, '2019-12-18 11:55:51', 1);
INSERT INTO `ina_policies` VALUES (34, 1, 5, 26, 1, 34, 1, 'Medical', 'DCI-190000002', '2020-03-13', '2020-03-13', '2020-03-13', '2021-03-12', 'Active', 'New', 500.00, 0.00, 50.00, 2.00, NULL, 90.00, NULL, NULL, NULL, 2, 15.00, 25.00, NULL, 4, 10.00, 25.00, NULL, 5, 5.00, 25.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-13 13:17:38', 1, '2020-03-16 11:30:57', 1);
INSERT INTO `ina_policies` VALUES (35, 1, 5, 26, 1, 35, 1, 'Medical', 'DCI-190000003', '2020-03-16', '2020-03-16', '2020-03-16', '2021-03-15', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, NULL, 90.00, 56.37, NULL, NULL, 2, 15.00, 35.00, 21.91, 4, 10.00, 20.00, 12.52, 5, 5.00, 20.00, 12.52, NULL, NULL, NULL, NULL, NULL, NULL, 0, 55, NULL, '2020-03-16 11:51:06', 1, '2020-03-23 11:22:57', 1);
INSERT INTO `ina_policies` VALUES (36, 1, 5, 26, 1, 36, 1, 'Medical', 'DCI-190000004', '2020-03-20', '2020-03-20', '2020-03-20', '2021-03-19', 'Outstanding', 'New', 750.00, 0.00, 30.00, 2.00, NULL, 90.00, 0.00, NULL, NULL, 2, 15.00, 25.00, 0.00, 4, 10.00, 25.00, 0.00, 5, 5.00, 25.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-20 15:58:51', 1, '2020-03-21 13:51:30', 1);
INSERT INTO `ina_policies` VALUES (43, 2, 5, 26, 15, 43, 1, 'Medical', 'DCI-190000005', '2020-03-21', '2020-03-21', '2020-03-21', '2021-03-20', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-21 12:59:47', 6, '2020-03-21 12:59:47', 6);
INSERT INTO `ina_policies` VALUES (44, 1, 5, 26, 1, 44, 1, 'Medical', 'DCI-190000006', '2020-03-21', '2020-03-21', '2020-03-21', '2021-03-20', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-21 13:10:27', 1, '2020-03-21 13:10:27', 1);
INSERT INTO `ina_policies` VALUES (45, 3, 5, 26, 1, 45, 1, 'Medical', 'DCI-190000007', '2020-03-21', '2020-03-21', '2020-03-21', '2021-03-20', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-21 13:14:49', 1, '2020-03-21 13:14:49', 1);
INSERT INTO `ina_policies` VALUES (46, 3, 5, 26, 1, 46, 1, 'Medical', 'DCI-190000008', '2020-03-21', '2020-03-21', '2020-03-21', '2021-03-20', 'Outstanding', 'New', 400.00, 0.00, 30.00, 2.00, NULL, 72.00, 0.00, NULL, NULL, 2, 15.00, 20.00, 0.00, 4, 10.00, 20.00, 0.00, 5, 5.00, 20.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-21 13:46:40', 6, '2020-03-23 11:43:41', 1);
INSERT INTO `ina_policies` VALUES (54, 3, 4, 26, 19, 54, 1, 'Medical', 'DCI-190000896', '2020-03-01', '2020-03-01', '2020-03-01', '2021-02-28', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 0, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-03-30 12:27:50', 7, '2020-03-30 12:35:20', 7);
INSERT INTO `ina_policies` VALUES (55, 1, 5, 26, 1, 35, 1, 'Medical', 'DCI-190000003', '2020-03-16', '2020-03-23', '2020-03-23', '2021-03-15', 'Active', 'Endorsement', -100.00, 0.00, 0.00, 0.00, NULL, -18.00, 0.00, 0.00, 0.00, 2, 15.00, -7.01, 0.00, 4, 8.00, -4.00, 0.00, 5, 4.00, -4.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 35, 59, NULL, '2020-03-23 11:12:08', 1, '2020-03-23 12:04:06', 1);
INSERT INTO `ina_policies` VALUES (59, 1, 5, 26, 1, 35, 1, 'Medical', 'DCI-190000003', '2020-03-16', '2020-03-31', '2020-03-23', '2021-03-15', 'Outstanding', 'Cancellation', -250.00, 0.00, -20.00, 0.00, NULL, -50.00, 0.00, 0.00, 0.00, 2, 15.00, -7.01, 0.00, 4, 8.00, -4.00, 0.00, 5, 4.00, -4.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 55, 0, NULL, '2020-03-23 12:04:06', 1, NULL, NULL);
INSERT INTO `ina_policies` VALUES (60, 3, 5, 1, 15, 60, NULL, 'Motor', '11111111', '2020-03-23', '2020-03-23', '2020-03-23', '2021-03-22', 'Outstanding', 'New', 100.00, 0.00, 30.00, 2.00, -50.00, 11.00, 0.00, NULL, NULL, 2, 10.00, 0.90, 0.00, 4, 9.00, 0.90, 0.00, 5, 8.00, 7.20, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2020-03-23 18:41:55', 1, '2020-03-26 21:36:05', 1);
INSERT INTO `ina_policies` VALUES (61, 3, 5, 26, 1, 61, 1, 'Medical', 'DCI-190000009', '2020-03-27', '2020-03-27', '2020-03-27', '2021-03-26', 'Archived', 'New', 1000.00, 0.00, 60.00, 2.00, -50.00, 200.00, 113.33, NULL, NULL, 2, 15.00, 47.50, 26.91, 4, 10.00, 47.50, 26.91, 5, 5.00, 47.50, 26.91, NULL, NULL, NULL, NULL, NULL, NULL, 0, 62, '', '2020-03-27 10:52:11', 1, '2020-03-27 12:11:19', 1);
INSERT INTO `ina_policies` VALUES (62, 3, 5, 26, 1, 61, 1, 'Medical', 'DCI-190000009', '2020-03-27', '2020-03-31', '2020-03-31', '2021-03-26', 'Active', 'Endorsement', 200.00, 0.00, 0.00, 0.00, 0.00, 40.00, 0.00, 0.00, 0.00, 2, 14.25, 9.50, 0.00, 4, 9.50, 9.50, 0.00, 5, 4.75, 9.50, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 61, 66, '', '2020-03-27 12:09:50', 1, '2020-03-27 12:10:52', 1);
INSERT INTO `ina_policies` VALUES (63, 3, 5, 26, 1, 63, NULL, 'Medical', 'Mic123', '2020-03-29', '2020-03-29', '2020-03-29', '2021-03-28', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-03-29 10:40:31', 1, '2020-03-29 10:40:31', 1);
INSERT INTO `ina_policies` VALUES (64, 3, 5, 26, 1, 64, 1, 'Medical', 'DCI-190000010', '2020-03-29', '2020-03-29', '2020-03-29', '2021-03-28', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-03-29 10:52:41', 1, '2020-03-29 10:52:41', 1);
INSERT INTO `ina_policies` VALUES (65, 3, 5, 26, 1, 65, 1, 'Medical', 'DCI-190000011', '2020-03-01', '2020-03-01', '2020-03-01', '2021-02-28', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-03-29 10:54:34', 1, '2020-03-29 10:54:34', 1);
INSERT INTO `ina_policies` VALUES (66, 3, 5, 26, 1, 66, 1, 'Medical', 'DCI-190000009', '2020-03-27', '2021-03-27', '2021-03-27', '2022-02-26', 'Outstanding', 'Renewal', 1200.00, 0.00, 0.00, 0.00, -50.00, 240.00, 0.00, 0.00, 0.00, 2, 14.25, 9.50, 0.00, 4, 9.50, 9.50, 0.00, 5, 4.75, 9.50, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 62, 0, '', NULL, NULL, NULL, NULL);
INSERT INTO `ina_policies` VALUES (67, 1, 1, 1, 1, 67, 0, 'Motor', '1901-010102', '2018-06-03', '2019-06-03', '2019-06-03', '2020-06-02', 'Outstanding', 'Renewal', 150.00, 0.00, 0.00, 0.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 12, 0, '', NULL, NULL, NULL, NULL);
INSERT INTO `ina_policies` VALUES (68, 1, 1, 1, 1, 68, 0, 'Motor', '1901-011111', '2018-07-10', '2019-07-10', '2019-07-10', '2020-07-09', 'Outstanding', 'Renewal', 415.00, 0.00, 0.00, 0.00, 0.00, 110.00, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 18, 0, '', NULL, NULL, NULL, NULL);
INSERT INTO `ina_policies` VALUES (69, 3, 2, 26, 1, 69, 1, 'Medical', 'tst000001', '2020-03-31', '2020-03-31', '2020-03-31', '2021-03-30', 'Active', 'New', 540.00, 0.00, 60.00, 2.00, 0.00, 108.00, 0.00, NULL, NULL, 2, 15.00, 81.00, 0.00, 0, 0.00, NULL, 0.00, 0, 0.00, NULL, 0.00, 1, 1, 2.50, 13.50, NULL, NULL, 0, 75, '', '2020-03-30 19:06:26', 1, '2020-04-10 12:09:33', 1);
INSERT INTO `ina_policies` VALUES (70, 3, 5, 26, 1, 70, 1, 'Medical', 'fgfdsgdfgd111', '2020-03-31', '2020-03-31', '2020-03-31', '2021-03-30', 'Archived', 'New', 550.00, 0.00, 60.00, 2.00, -50.00, 110.00, 90.43, NULL, NULL, 2, 15.00, 27.50, 22.60, 4, 10.00, 27.50, 22.60, 5, 5.00, 27.50, 22.60, NULL, NULL, NULL, NULL, NULL, NULL, 0, 72, '', '2020-03-30 19:26:40', 1, '2020-04-01 11:47:12', 1);
INSERT INTO `ina_policies` VALUES (72, 3, 5, 26, 1, 70, 1, 'Medical', 'fgfdsgdfgd111', '2020-03-31', '2020-04-30', '2020-03-31', '2021-03-30', 'Archived', 'Cancellation', -300.00, 0.00, 0.00, 0.00, 0.00, -55.00, 90.43, 0.00, 0.00, 2, 15.00, -15.00, 22.60, 4, 10.00, -15.00, 22.60, 5, 5.00, -15.00, 22.60, NULL, NULL, NULL, NULL, NULL, NULL, 70, 0, '', '2020-04-01 11:41:08', 1, '2020-04-01 11:47:12', 1);
INSERT INTO `ina_policies` VALUES (75, 3, 2, 26, 1, 75, 1, 'Medical', 'tst000001', '2020-03-31', '2021-03-31', '2021-03-31', '2022-03-30', 'Outstanding', 'Renewal', 540.00, 0.00, NULL, 0.00, 0.00, 108.00, 0.00, 0.00, 0.00, 2, 15.00, 81.00, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 1, 1, 2.50, 13.50, NULL, NULL, 69, 0, '', NULL, NULL, '2020-04-10 12:09:33', 1);
INSERT INTO `ina_policies` VALUES (76, 3, 5, 26, 1, 76, 1, 'Medical', 'DCI-190000012', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 100.00, NULL, NULL, 2, 15.00, 23.00, 23.00, 4, 10.00, 24.00, 24.00, 5, 5.00, 25.00, 25.00, 2, 6, 3.00, 15.00, 15.00, NULL, 0, 78, '', '2020-04-10 14:15:04', 1, '2020-04-12 10:03:11', 1);
INSERT INTO `ina_policies` VALUES (78, 3, 5, 26, 1, 76, 1, 'Medical', 'DCI-190000012', '2020-04-01', '2020-04-12', '2020-04-12', '2021-03-31', 'Active', 'Endorsement', 50.00, 0.00, 0.00, 0.00, 0.00, 10.00, 0.00, 0.00, 0.00, 2, 14.40, 2.29, 0.00, 4, 9.80, 2.40, 0.00, 5, 5.00, 2.50, 0.00, 2, 6, 3.00, 15.00, 15.00, NULL, 76, 81, '', '2020-04-12 10:02:44', 1, '2020-04-12 11:05:20', 1);
INSERT INTO `ina_policies` VALUES (81, 3, 5, 26, 1, 81, 1, 'Medical', 'DCI-190000012', '2020-04-01', '2021-04-01', '2021-04-01', '2022-02-28', 'Outstanding', 'Renewal', 550.00, 0.00, NULL, 0.00, 0.00, 110.00, 0.00, 0.00, 0.00, 2, 14.40, 2.29, 0.00, 4, 9.80, 2.40, 0.00, 5, 5.00, 2.50, 0.00, 2, 6, 2.00, 11.00, 15.00, NULL, 78, 0, '', NULL, NULL, NULL, NULL);
INSERT INTO `ina_policies` VALUES (82, 3, 2, 26, 1, 82, 1, 'Medical', 'DCI-190000013', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 54.00, NULL, NULL, 2, 15.00, 75.00, 20.25, 0, 0.00, NULL, 0.00, 0, 0.00, NULL, 0.00, 1, 1, 2.20, 11.00, 2.97, NULL, 0, 86, '', '2020-04-12 11:12:20', 1, '2020-04-12 12:05:34', 1);
INSERT INTO `ina_policies` VALUES (86, 3, 2, 26, 1, 82, 1, 'Medical', 'DCI-190000013', '2020-04-01', '2020-04-13', '2020-04-13', '2021-03-31', 'Archived', 'Endorsement', 770.00, 0.00, 0.00, 0.00, 0.00, 154.00, 0.00, 0.00, 0.00, 2, 15.00, 115.50, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 1, 1, 2.20, 16.94, 0.00, NULL, 82, 88, '', '2020-04-12 11:26:34', 1, '2020-04-12 11:47:24', 1);
INSERT INTO `ina_policies` VALUES (88, 3, 2, 26, 1, 82, 1, 'Medical', 'DCI-190000013', '2020-04-01', '2020-04-30', '2020-04-13', '2021-03-31', 'Archived', 'Cancellation', -1000.00, 0.00, 0.00, 0.00, 0.00, -200.00, 0.00, 0.00, 0.00, 2, 15.00, -150.00, 0.00, 0, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 1, 1, 2.20, -22.00, 0.00, NULL, 86, 0, '', '2020-04-12 11:46:20', 1, '2020-04-12 11:47:24', 1);
INSERT INTO `ina_policies` VALUES (89, 3, 5, 26, 1, 89, 1, 'Medical', 'DCI-190000014', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 130.00, NULL, NULL, 2, 15.00, 20.00, 25.99, 4, 10.00, 22.00, 28.59, 5, 5.00, 25.00, 32.49, 2, 6, 3.00, 15.00, 19.49, NULL, 0, 90, '', '2020-04-12 12:12:48', 1, '2020-04-12 12:57:06', 1);
INSERT INTO `ina_policies` VALUES (90, 3, 5, 26, 1, 89, 1, 'Medical', 'DCI-190000014', '2020-04-01', '2020-04-12', '2020-04-12', '2021-03-31', 'Active', 'Endorsement', 150.00, 0.00, 0.00, 0.00, 0.00, 30.00, 0.00, 0.00, 0.00, 2, 13.40, 6.00, 0.00, 4, 9.40, 6.60, 0.00, 5, 5.00, 7.50, 0.00, 2, 6, 3.00, 4.50, 0.00, NULL, 89, 0, '', '2020-04-12 12:16:51', 1, '2020-04-12 12:17:20', 1);
INSERT INTO `ina_policies` VALUES (91, 3, 5, 26, 1, 91, 1, 'Medical', 'DCI-190000015', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-04-13 10:40:19', 1, '2020-04-13 10:40:19', 1);
INSERT INTO `ina_policies` VALUES (92, 1, 6, 26, 1, 92, 1, 'Medical', 'DCI-190000016', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Outstanding', 'Renewal', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0, 0.00, NULL, 0.00, 0, 0.00, NULL, 0.00, 0, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-04-13 10:41:23', 1, '2020-04-13 10:41:23', 1);
INSERT INTO `ina_policies` VALUES (93, 3, 5, 26, 1, 93, 1, 'Medical', 'DCI-190000017', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Outstanding', 'New', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 15.00, NULL, 0.00, 4, 10.00, NULL, 0.00, 5, 5.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-04-13 10:41:48', 1, '2020-04-13 10:41:48', 1);
INSERT INTO `ina_policies` VALUES (94, 3, 5, 26, 1, 94, 1, 'Medical', 'DCI-190000018', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Outstanding', 'Renewal', NULL, 0.00, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 2, 14.00, NULL, 0.00, 4, 9.00, NULL, 0.00, 5, 4.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '2020-04-13 10:43:56', 1, '2020-04-13 10:43:56', 1);
INSERT INTO `ina_policies` VALUES (95, 3, 2, 26, 5, 95, 1, 'Medical', 'DCI-190000019', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 200.00, 0.00, 60.00, 2.00, 0.00, 40.00, -80.00, NULL, NULL, 2, 15.00, 30.00, 30.00, 0, 0.00, NULL, 0.00, 0, 0.00, NULL, 0.00, 1, 1, 2.00, 4.00, 4.00, NULL, 0, 96, '', '2020-04-15 12:28:36', 1, '2020-04-16 11:29:55', 1);
INSERT INTO `ina_policies` VALUES (96, 3, 2, 26, 5, 95, 1, 'Medical', 'DCI-190000019', '2020-04-01', '2020-04-15', '2020-04-01', '2021-03-31', 'Archived', 'Cancellation', -200.00, 0.00, 0.00, 0.00, 0.00, -40.00, 40.00, NULL, NULL, 2, 15.00, -30.00, 30.00, 0, NULL, NULL, 0.00, 0, NULL, NULL, 0.00, 1, 1, 2.00, -4.00, 4.00, NULL, 95, 0, NULL, '2020-04-15 12:30:59', 1, '2020-04-16 10:34:53', 1);
INSERT INTO `ina_policies` VALUES (97, 3, 5, 26, 1, 97, 1, 'Medical', 'DCI-190000020', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 80.00, NULL, NULL, 2, 15.00, 23.00, 18.65, 4, 10.00, 24.00, 19.47, 5, 5.00, 25.00, 20.29, 2, 6, 3.00, 15.00, 12.15, NULL, 0, 98, '', '2020-04-16 11:37:00', 1, '2020-04-16 12:43:08', 1);
INSERT INTO `ina_policies` VALUES (98, 3, 5, 26, 1, 97, 1, 'Medical', 'DCI-190000020', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Active', 'Endorsement', -100.00, 0.00, 10.00, 0.00, 0.00, -20.00, 0.00, 0.00, 0.00, 2, 14.40, -4.60, 0.00, 4, 9.80, -4.80, 0.00, 5, 5.00, -5.00, 0.00, 2, 6, 3.00, -3.00, 3.75, NULL, 97, 0, NULL, '2020-04-16 11:50:06', 1, '2020-04-16 12:12:03', 1);
INSERT INTO `ina_policies` VALUES (99, 3, 5, 26, 1, 99, 1, 'Medical', 'DCI-190000021', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 43.33, NULL, NULL, 2, 15.00, 25.00, 16.25, 4, 10.00, 25.00, 16.25, 5, 5.00, 25.00, 16.25, 2, 6, 3.00, 15.00, 9.75, NULL, 0, 100, '', '2020-04-16 12:44:18', 1, '2020-04-16 13:01:10', 1);
INSERT INTO `ina_policies` VALUES (100, 3, 5, 26, 1, 99, 1, 'Medical', 'DCI-190000021', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Active', 'Endorsement', -100.00, 0.00, 10.00, 0.00, 0.00, -20.00, 0.00, 0.00, 0.00, 2, 15.00, -5.00, 0.00, 4, 10.00, -5.00, 0.00, 5, 5.00, -5.00, 0.00, 2, 6, 3.00, -3.00, 3.75, NULL, 99, 0, NULL, '2020-04-16 12:48:28', 1, '2020-04-16 12:49:35', 1);
INSERT INTO `ina_policies` VALUES (101, 3, 5, 26, 1, 101, 1, 'Medical', 'DCI-190000022', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Active', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 0.00, NULL, NULL, 2, 15.00, 25.00, 0.00, 4, 10.00, 25.00, 0.00, 5, 5.00, 25.00, 0.00, 2, 6, 3.00, 15.00, NULL, NULL, 0, 0, '', '2020-04-16 13:26:54', 1, '2020-04-16 13:28:06', 1);
INSERT INTO `ina_policies` VALUES (102, 3, 5, 26, 1, 102, 1, 'Medical', 'DCI-190000023', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 55.00, NULL, NULL, 2, 15.00, 25.00, -5.00, 4, 10.00, 25.00, -5.00, 5, 5.00, 25.00, -5.00, 2, 6, 3.00, 15.00, -10.50, NULL, 0, 103, '', '2020-04-16 13:38:28', 1, '2020-04-16 14:15:34', 1);
INSERT INTO `ina_policies` VALUES (103, 3, 5, 26, 1, 102, 1, 'Medical', 'DCI-190000023', '2020-04-01', '2020-04-16', '2020-04-16', '2021-03-31', 'Archived', 'Endorsement', -100.00, 0.00, 10.00, 0.00, 0.00, -20.00, 0.00, 0.00, 0.00, 2, 15.00, -5.00, 0.00, 4, 10.00, -5.00, 0.00, 5, 5.00, -5.00, 0.00, 2, 6, 3.00, -3.00, 3.75, NULL, 102, 104, NULL, '2020-04-16 13:40:09', 1, '2020-04-16 14:15:34', 1);
INSERT INTO `ina_policies` VALUES (104, 3, 5, 26, 1, 102, 1, 'Medical', 'DCI-190000023', '2020-04-01', '2020-04-30', '2020-04-16', '2021-03-31', 'Archived', 'Cancellation', -100.00, 0.00, 0.00, 0.00, 0.00, -25.00, 0.00, 0.00, 0.00, 2, 15.00, -5.00, 0.00, 4, 10.00, -5.00, 0.00, 5, 5.00, -5.00, 0.00, 2, 6, 3.00, -3.00, 3.75, NULL, 103, 0, NULL, '2020-04-16 14:10:55', 1, '2020-04-16 14:15:34', 1);
INSERT INTO `ina_policies` VALUES (105, 1, 5, 26, 1, 105, 1, 'Medical', 'DCI-190000024', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 80.00, NULL, NULL, 2, 15.00, 25.00, -30.00, 4, 10.00, 25.00, -30.00, 5, 5.00, 25.00, -30.00, 2, 6, 3.00, 15.00, -18.00, NULL, 0, 106, '', '2020-04-16 14:18:45', 1, '2020-04-16 14:23:13', 1);
INSERT INTO `ina_policies` VALUES (106, 1, 5, 26, 1, 105, 1, 'Medical', 'DCI-190000024', '2020-04-01', '2020-04-16', '2020-04-01', '2021-03-31', 'Archived', 'Cancellation', -100.00, 0.00, 0.00, 0.00, 0.00, -20.00, 100.00, NULL, NULL, 2, 15.00, -5.00, 25.00, 4, 10.00, -5.00, 25.00, 5, 5.00, -5.00, 25.00, 2, 6, 3.00, -3.00, 15.00, NULL, 105, 0, NULL, '2020-04-16 14:22:24', 1, '2020-04-16 14:22:43', 1);
INSERT INTO `ina_policies` VALUES (107, 3, 5, 26, 1, 107, 1, 'Medical', 'DCI-190000025', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Archived', 'New', 500.00, 0.00, 60.00, 2.00, 0.00, 100.00, 60.00, NULL, NULL, 2, 15.00, 25.00, 15.00, 4, 10.00, 25.00, 15.00, 5, 5.00, 25.00, 15.00, 2, 6, 3.00, 15.00, 3.67, NULL, 0, 108, '', '2020-04-16 14:24:03', 1, '2020-04-16 14:43:47', 1);
INSERT INTO `ina_policies` VALUES (108, 3, 5, 26, 1, 107, 1, 'Medical', 'DCI-190000025', '2020-04-01', '2020-04-02', '2020-04-02', '2021-03-31', 'Archived', 'Endorsement', -100.00, 0.00, 10.00, 0.00, 0.00, -20.00, 0.00, 0.00, 0.00, 2, 15.00, -5.00, 0.00, 4, 10.00, -5.00, 0.00, 5, 5.00, -5.00, 0.00, 2, 6, 3.00, -3.00, 5.33, NULL, 107, 109, NULL, '2020-04-16 14:26:07', 1, '2020-04-16 14:35:04', 1);
INSERT INTO `ina_policies` VALUES (109, 3, 5, 26, 1, 107, 1, 'Medical', 'DCI-190000025', '2020-04-01', '2020-04-30', '2020-04-02', '2021-03-31', 'Archived', 'Cancellation', -100.00, 0.00, 0.00, 0.00, 0.00, -20.00, 0.00, 0.00, 0.00, 2, 15.00, -5.00, 0.00, 4, 10.00, -5.00, 0.00, 5, 5.00, -5.00, 0.00, 2, 6, 3.00, -3.00, 0.00, NULL, 108, 0, NULL, '2020-04-16 14:34:26', 1, '2020-04-16 14:35:04', 1);
INSERT INTO `ina_policies` VALUES (110, 3, 5, 26, 1, 110, 1, 'Medical', 'DCI-190000026', '2020-04-01', '2020-04-01', '2020-04-01', '2021-03-31', 'Active', 'New', 500.00, 0.00, 50.00, 2.00, 0.00, 100.00, 0.00, NULL, NULL, 2, 15.00, 25.00, 0.00, 4, 10.00, 25.00, 0.00, 5, 5.00, 25.00, 0.00, 2, 6, 3.00, 15.00, NULL, NULL, 0, 0, '', '2020-04-16 15:45:30', 1, '2020-04-27 11:57:46', 1);
INSERT INTO `ina_policies` VALUES (111, 3, 2, 1, 2, 111, NULL, 'Motor', 'MOT123456', '2020-04-15', '2020-04-01', '2020-04-01', '2020-05-14', 'Outstanding', 'New', 250.00, 12.50, 25.00, 2.00, 0.00, 27.50, 0.00, NULL, NULL, 2, 10.00, 25.00, 0.00, 0, 0.00, NULL, 0.00, 0, 0.00, NULL, 0.00, 1, 1, 2.01, 5.02, NULL, NULL, 0, 0, '', '2020-04-27 11:43:50', 1, '2020-08-12 19:12:54', 1);
INSERT INTO `ina_policies` VALUES (112, 3, 5, 26, 2, 112, 1, 'Medical', 'DCI-190000027', '2020-08-13', '2020-08-13', '2020-08-13', '2021-08-12', 'Outstanding', 'New', 250.00, 0.00, 30.00, 2.00, 0.00, 50.00, 0.00, NULL, NULL, 2, 15.00, 12.50, 0.00, 4, 10.00, 12.50, 0.00, 5, 5.00, 12.50, 0.00, 0, 0, 0.00, 0.00, NULL, NULL, 0, 0, '', '2020-08-13 09:58:07', 1, '2020-08-13 10:14:01', 1);

-- ----------------------------
-- Table structure for ina_policy_installments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_installments`;
CREATE TABLE `ina_policy_installments`  (
  `inapi_policy_installments_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapi_policy_ID` int(8) NULL DEFAULT NULL,
  `inapi_installment_type` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapi_paid_status` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'UnPaid\r\nPaid\r\nPartial\r\nAlert (when total installments commission is not equal with policy commission)\r\n',
  `inapi_insert_date` date NULL DEFAULT NULL,
  `inapi_document_date` date NULL DEFAULT NULL,
  `inapi_last_payment_date` date NULL DEFAULT NULL,
  `inapi_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapi_paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapi_commission_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapi_paid_commission_amount` decimal(10, 2) NULL DEFAULT 0,
  `inapi_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inapi_created_by` int(8) NULL DEFAULT NULL,
  `inapi_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inapi_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inapi_policy_installments_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 354 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_policy_installments
-- ----------------------------
INSERT INTO `ina_policy_installments` VALUES (5, 1, 'Recursive', 'Paid', '2019-06-26', '2019-06-26', NULL, 92.34, 92.34, 16.68, 16.68, '2019-06-26 12:17:32', 1, '2019-06-26 12:18:17', 1);
INSERT INTO `ina_policy_installments` VALUES (6, 1, 'Recursive', 'Paid', '2019-06-26', '2019-07-26', NULL, 57.66, 57.66, 10.40, 10.40, '2019-06-26 12:17:33', 1, '2019-06-26 17:08:02', 1);
INSERT INTO `ina_policy_installments` VALUES (7, 1, 'Recursive', 'Paid', '2019-06-26', '2019-08-26', NULL, 27.00, 0.00, 17.92, 0.00, '2019-06-26 12:17:33', 1, '2019-06-26 17:08:02', 1);
INSERT INTO `ina_policy_installments` VALUES (8, 4, 'Recursive', 'Paid', '2019-06-28', '2019-06-28', NULL, 92.34, 92.34, 16.68, 16.68, '2019-06-28 14:00:07', 1, '2019-06-28 14:00:46', 1);
INSERT INTO `ina_policy_installments` VALUES (9, 4, 'Recursive', 'Paid', '2019-06-28', '2019-07-28', NULL, 57.66, 57.66, 10.40, 10.40, '2019-06-28 14:00:07', 1, '2019-06-28 15:05:20', 1);
INSERT INTO `ina_policy_installments` VALUES (10, 4, 'Recursive', 'Paid', '2019-06-28', '2019-08-28', NULL, 27.00, 27.00, 22.92, 22.92, '2019-06-28 14:00:07', 1, '2019-06-28 16:24:20', 1);
INSERT INTO `ina_policy_installments` VALUES (14, 6, 'Recursive', 'UnPaid', '2019-06-28', '2019-06-28', NULL, 100.68, 0.00, 16.68, 0.00, '2019-06-28 16:35:01', 1, '2019-06-28 16:35:02', 1);
INSERT INTO `ina_policy_installments` VALUES (15, 6, 'Recursive', 'UnPaid', '2019-06-28', '2019-07-28', NULL, 100.66, 0.00, 16.66, 0.00, '2019-06-28 16:35:02', 1, '2019-06-28 16:35:02', 1);
INSERT INTO `ina_policy_installments` VALUES (16, 6, 'Recursive', 'UnPaid', '2019-06-28', '2019-08-28', NULL, 100.66, 0.00, 16.66, 0.00, '2019-06-28 16:35:02', 1, '2019-06-28 16:35:02', 1);
INSERT INTO `ina_policy_installments` VALUES (17, 7, 'Recursive', 'Paid', '2019-06-28', '2019-06-28', NULL, 50.35, 50.35, 12.50, 12.50, '2019-06-28 18:24:54', 1, '2019-11-23 11:44:38', 1);
INSERT INTO `ina_policy_installments` VALUES (18, 7, 'Recursive', 'Paid', '2019-06-28', '2019-07-28', NULL, 50.33, 50.33, 12.50, 12.50, '2019-06-28 18:24:54', 1, '2019-11-23 11:44:38', 1);
INSERT INTO `ina_policy_installments` VALUES (19, 7, 'Recursive', 'Partial', '2019-06-28', '2019-08-28', NULL, 50.33, 9.32, 12.50, 2.31, '2019-06-28 18:24:54', 1, '2019-11-23 11:44:38', 1);
INSERT INTO `ina_policy_installments` VALUES (20, 7, 'Recursive', 'UnPaid', '2019-06-28', '2019-09-28', NULL, 50.33, 0.00, 12.50, 0.00, '2019-06-28 18:24:54', 1, '2019-06-28 18:24:54', 1);
INSERT INTO `ina_policy_installments` VALUES (21, 7, 'Recursive', 'UnPaid', '2019-06-28', '2019-10-28', NULL, 50.33, 0.00, 12.50, 0.00, '2019-06-28 18:24:54', 1, '2019-06-28 18:24:54', 1);
INSERT INTO `ina_policy_installments` VALUES (22, 7, 'Recursive', 'UnPaid', '2019-06-28', '2019-11-28', NULL, 50.33, 0.00, 12.50, 0.00, '2019-06-28 18:24:54', 1, '2019-06-28 18:24:54', 1);
INSERT INTO `ina_policy_installments` VALUES (27, 8, 'Recursive', 'Paid', '0000-00-00', '2019-07-02', NULL, 73.00, 73.00, 18.75, 18.75, '2019-07-02 12:55:35', 1, '2019-07-23 14:26:28', 1);
INSERT INTO `ina_policy_installments` VALUES (28, 8, 'Recursive', 'Partial', '2019-07-02', '2019-08-02', NULL, 73.00, 19.00, 18.75, 4.88, '2019-07-02 12:55:35', 1, '2019-07-23 14:26:28', 1);
INSERT INTO `ina_policy_installments` VALUES (29, 8, 'Recursive', 'UnPaid', '2019-07-02', '2019-09-02', NULL, 73.00, 0.00, 18.75, 0.00, '2019-07-02 12:55:35', 1, '2019-07-23 14:24:43', 1);
INSERT INTO `ina_policy_installments` VALUES (30, 8, 'Recursive', 'UnPaid', '2019-07-02', '2019-10-02', NULL, 73.00, 0.00, 18.75, 0.00, '2019-07-02 12:55:35', 1, '2019-07-23 14:24:43', 1);
INSERT INTO `ina_policy_installments` VALUES (31, 9, 'Recursive', 'Paid', '2019-07-02', '2019-07-02', NULL, 92.34, 92.34, 16.68, 16.68, '2019-07-02 16:32:02', 5, '2019-07-02 16:38:07', 5);
INSERT INTO `ina_policy_installments` VALUES (32, 9, 'Recursive', 'Partial', '2019-07-02', '2019-08-02', NULL, 92.33, 84.66, 16.66, 15.28, '2019-07-02 16:32:02', 5, '2019-07-02 16:38:07', 5);
INSERT INTO `ina_policy_installments` VALUES (33, 9, 'Recursive', 'UnPaid', '2019-07-02', '2019-09-02', NULL, 92.33, 0.00, 16.66, 0.00, '2019-07-02 16:32:02', 5, '2019-07-02 16:32:02', 5);
INSERT INTO `ina_policy_installments` VALUES (34, 10, 'Recursive', 'Paid', '2019-07-03', '2019-07-03', NULL, 70.68, 70.68, 17.54, 17.54, '2019-07-03 11:21:35', 1, '2019-07-03 11:22:43', 1);
INSERT INTO `ina_policy_installments` VALUES (35, 10, 'Recursive', 'Paid', '2019-07-03', '2019-08-03', NULL, 70.66, 70.66, 17.53, 17.53, '2019-07-03 11:21:35', 1, '2019-07-04 11:16:58', 1);
INSERT INTO `ina_policy_installments` VALUES (36, 10, 'Recursive', 'Paid', '2019-07-03', '2019-09-03', NULL, 70.66, 70.66, 17.53, 17.53, '2019-07-03 11:21:35', 1, '2019-07-04 11:16:58', 1);
INSERT INTO `ina_policy_installments` VALUES (37, 10, 'Endorsement', 'Paid', '2019-07-04', '2019-07-04', '2019-07-04', 0.00, 0.00, -25.00, -25.00, '2019-07-04 11:27:11', 1, NULL, NULL);
INSERT INTO `ina_policy_installments` VALUES (52, 15, 'Recursive', 'Paid', '2019-07-11', '2019-07-11', NULL, 35.44, 35.44, 10.00, 10.00, '2019-07-11 12:23:47', 1, '2019-07-11 12:25:34', 1);
INSERT INTO `ina_policy_installments` VALUES (53, 15, 'Recursive', 'Partial', '2019-07-11', '2019-08-11', NULL, 14.56, 14.56, 4.11, 4.11, '2019-07-11 12:23:47', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policy_installments` VALUES (54, 15, 'Recursive', 'Paid', '2019-07-11', '2019-09-11', NULL, 0.00, 0.00, 0.00, 0.00, '2019-07-11 12:23:47', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policy_installments` VALUES (55, 15, 'Recursive', 'Paid', '2019-07-11', '2019-10-11', NULL, 0.00, 0.00, 0.00, 0.00, '2019-07-11 12:23:47', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policy_installments` VALUES (56, 15, 'Recursive', 'Paid', '2019-07-11', '2019-11-11', NULL, 0.00, 0.00, -4.11, 0.00, '2019-07-11 12:23:47', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policy_installments` VALUES (57, 17, 'Recursive', 'Paid', '2019-07-11', '2019-07-11', NULL, 92.34, 92.34, 16.68, 16.68, '2019-07-11 12:33:57', 1, '2019-07-11 12:36:27', 1);
INSERT INTO `ina_policy_installments` VALUES (58, 17, 'Recursive', 'Paid', '2019-07-11', '2019-08-11', NULL, 92.33, 92.33, 16.66, 16.66, '2019-07-11 12:33:57', 1, '2019-07-11 12:36:48', 1);
INSERT INTO `ina_policy_installments` VALUES (59, 17, 'Recursive', 'Partial', '2019-07-11', '2019-09-11', NULL, 92.33, 65.33, 16.66, 11.79, '2019-07-11 12:33:57', 1, '2019-07-11 12:36:48', 1);
INSERT INTO `ina_policy_installments` VALUES (60, 18, 'Recursive', 'Paid', '2019-07-18', '2018-07-10', NULL, 147.34, 147.34, 36.68, 36.68, '2019-07-18 23:45:59', 1, '2019-07-18 23:46:17', 1);
INSERT INTO `ina_policy_installments` VALUES (61, 18, 'Recursive', 'Paid', '2019-07-18', '2018-08-10', NULL, 147.33, 147.33, 36.66, 36.66, '2019-07-18 23:45:59', 1, '2020-04-16 10:25:51', 1);
INSERT INTO `ina_policy_installments` VALUES (62, 18, 'Recursive', 'Partial', '2019-07-18', '2018-09-10', NULL, 147.33, 55.33, 36.66, 13.77, '2019-07-18 23:45:59', 1, '2020-04-16 10:25:51', 1);
INSERT INTO `ina_policy_installments` VALUES (63, 12, 'Recursive', 'Paid', '2019-07-19', '2018-06-03', NULL, 88.50, 88.50, 25.00, 25.00, '2019-07-19 00:03:33', 1, '2019-07-19 00:05:28', 1);
INSERT INTO `ina_policy_installments` VALUES (64, 12, 'Recursive', 'Paid', '2019-07-19', '2018-07-03', NULL, 88.50, 88.50, 25.00, 25.00, '2019-07-19 00:03:33', 1, '2019-07-19 00:05:28', 1);
INSERT INTO `ina_policy_installments` VALUES (65, 19, 'Recursive', 'UnPaid', '2019-07-22', '2019-07-22', NULL, 234.83, 0.00, 45.00, 0.00, '2019-07-22 12:05:01', 1, '2019-08-24 21:19:52', 1);
INSERT INTO `ina_policy_installments` VALUES (66, 19, 'Recursive', 'UnPaid', '2019-07-22', '2019-08-22', NULL, 234.83, 0.00, 45.00, 0.00, '2019-07-22 12:05:01', 1, '2019-08-24 21:19:52', 1);
INSERT INTO `ina_policy_installments` VALUES (67, 19, 'Recursive', 'UnPaid', '2019-07-22', '2019-09-22', NULL, 234.83, 0.00, 45.00, 0.00, '2019-07-22 12:05:01', 1, '2019-08-24 21:19:52', 1);
INSERT INTO `ina_policy_installments` VALUES (68, 20, 'Divided', 'Paid', '2019-07-22', '2019-07-01', NULL, 98.50, 98.50, 12.50, 12.50, '2019-07-22 19:21:55', 1, '2019-07-22 19:23:55', 1);
INSERT INTO `ina_policy_installments` VALUES (69, 20, 'Divided', 'Paid', '2019-07-22', '2019-08-01', NULL, 98.50, 98.50, 12.50, 12.50, '2019-07-22 19:21:55', 1, '2019-08-07 15:52:33', 1);
INSERT INTO `ina_policy_installments` VALUES (70, 20, 'Divided', 'Paid', '2019-07-22', '2019-09-01', NULL, 98.50, 98.50, 12.50, 12.50, '2019-07-22 19:21:55', 1, '2019-08-07 15:52:33', 1);
INSERT INTO `ina_policy_installments` VALUES (71, 20, 'Divided', 'Paid', '2019-07-22', '2019-10-01', NULL, 98.50, 98.50, 12.50, 12.50, '2019-07-22 19:21:55', 1, '2019-08-07 15:52:35', 1);
INSERT INTO `ina_policy_installments` VALUES (72, 20, 'Divided', 'Paid', '2019-07-22', '2019-11-01', NULL, 98.50, 98.50, 12.50, 12.50, '2019-07-22 19:21:55', 1, '2019-08-07 15:52:35', 1);
INSERT INTO `ina_policy_installments` VALUES (73, 20, 'Divided', 'Partial', '2019-07-22', '2019-12-01', NULL, 98.50, 56.00, 12.50, 7.11, '2019-07-22 19:21:55', 1, '2019-08-07 15:52:35', 1);
INSERT INTO `ina_policy_installments` VALUES (74, 20, 'Divided', 'UnPaid', '2019-07-22', '2020-01-01', NULL, 98.50, 0.00, 12.50, 0.00, '2019-07-22 19:21:55', 1, '2019-07-22 19:21:55', 1);
INSERT INTO `ina_policy_installments` VALUES (75, 20, 'Divided', 'UnPaid', '2019-07-22', '2020-02-01', NULL, 98.50, 0.00, 12.50, 0.00, '2019-07-22 19:21:55', 1, '2019-07-22 19:21:55', 1);
INSERT INTO `ina_policy_installments` VALUES (76, 20, 'Divided', 'UnPaid', '2019-07-22', '2020-03-01', NULL, 98.50, 0.00, 12.50, 0.00, '2019-07-22 19:21:55', 1, '2019-07-22 19:21:55', 1);
INSERT INTO `ina_policy_installments` VALUES (77, 20, 'Divided', 'UnPaid', '2019-07-22', '2020-04-01', NULL, 98.50, 0.00, 12.50, 0.00, '2019-07-22 19:21:55', 1, '2019-07-22 19:21:55', 1);
INSERT INTO `ina_policy_installments` VALUES (78, 20, 'Divided', 'UnPaid', '2019-07-22', '2020-05-01', NULL, 98.50, 0.00, 12.50, 0.00, '2019-07-22 19:21:55', 1, '2019-07-22 19:21:55', 1);
INSERT INTO `ina_policy_installments` VALUES (79, 20, 'Divided', 'UnPaid', '2019-07-22', '2020-06-01', NULL, 98.50, 0.00, 12.50, 0.00, '2019-07-22 19:21:55', 1, '2019-07-22 19:21:55', 1);
INSERT INTO `ina_policy_installments` VALUES (87, 21, 'Recursive', 'Paid', '2019-08-12', '2019-08-05', NULL, 300.68, 300.68, 36.68, 36.68, '2019-08-12 20:32:22', 1, '2019-08-12 20:34:27', 1);
INSERT INTO `ina_policy_installments` VALUES (88, 21, 'Recursive', 'Partial', '2019-08-12', '2019-09-05', NULL, 300.66, 49.32, 36.66, 6.01, '2019-08-12 20:32:22', 1, '2019-08-12 20:34:27', 1);
INSERT INTO `ina_policy_installments` VALUES (89, 21, 'Recursive', 'UnPaid', '2019-08-12', '2019-10-05', NULL, 300.66, 0.00, 36.66, 0.00, '2019-08-12 20:32:22', 1, '2019-08-12 20:32:22', 1);
INSERT INTO `ina_policy_installments` VALUES (93, 22, 'Recursive', 'Paid', '2019-10-15', '2019-09-03', NULL, 109.00, 109.00, 11.05, 11.05, '2019-10-15 10:30:27', 1, '2019-10-15 10:32:21', 1);
INSERT INTO `ina_policy_installments` VALUES (94, 22, 'Recursive', 'Partial', '2019-10-15', '2019-10-03', NULL, 109.00, 51.00, 11.03, 5.16, '2019-10-15 10:30:27', 1, '2019-10-15 10:32:21', 1);
INSERT INTO `ina_policy_installments` VALUES (95, 22, 'Recursive', 'UnPaid', '2019-10-15', '2019-11-03', NULL, 109.00, 0.00, 11.03, 0.00, '2019-10-15 10:30:27', 1, '2019-10-15 10:30:27', 1);
INSERT INTO `ina_policy_installments` VALUES (96, 23, 'Divided', 'UnPaid', '2019-10-15', '2019-10-15', NULL, 80.24, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (97, 23, 'Divided', 'UnPaid', '2019-10-15', '2019-11-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (98, 23, 'Divided', 'UnPaid', '2019-10-15', '2019-12-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (99, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-01-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (100, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-02-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (101, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-03-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (102, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-04-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (103, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-05-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (104, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-06-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (105, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-07-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (106, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-08-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (107, 23, 'Divided', 'UnPaid', '2019-10-15', '2020-09-15', NULL, 80.16, 0.00, 12.75, 0.00, '2019-10-15 10:37:03', 1, '2019-10-15 10:37:03', 1);
INSERT INTO `ina_policy_installments` VALUES (108, 25, 'Recursive', 'UnPaid', '2019-11-19', '2019-10-18', NULL, 148.50, 0.00, 16.50, 0.00, '2019-11-19 14:23:28', 1, '2019-11-19 14:23:28', 1);
INSERT INTO `ina_policy_installments` VALUES (109, 25, 'Recursive', 'UnPaid', '2019-11-19', '2019-11-18', NULL, 148.50, 0.00, 16.50, 0.00, '2019-11-19 14:23:28', 1, '2019-11-19 14:23:28', 1);
INSERT INTO `ina_policy_installments` VALUES (125, 26, 'Recursive', 'Paid', '2019-11-19', '2019-11-01', NULL, 75.68, 75.68, 7.34, 7.34, '2019-11-19 16:54:34', 1, '2019-11-22 18:41:17', 1);
INSERT INTO `ina_policy_installments` VALUES (126, 26, 'Recursive', 'Partial', '2019-11-19', '2019-12-01', NULL, 75.66, 24.32, 7.33, 2.36, '2019-11-19 16:54:34', 1, '2019-11-22 18:41:17', 1);
INSERT INTO `ina_policy_installments` VALUES (127, 26, 'Recursive', 'UnPaid', '2019-11-19', '2020-01-01', NULL, 75.66, 0.00, 7.33, 0.00, '2019-11-19 16:54:34', 1, '2019-11-20 17:38:24', 1);
INSERT INTO `ina_policy_installments` VALUES (140, 27, 'Recursive', 'Paid', '2019-11-23', '2019-11-22', NULL, 415.68, 415.68, 72.00, 72.00, '2019-11-23 17:17:55', 1, '2019-11-23 17:20:35', 1);
INSERT INTO `ina_policy_installments` VALUES (141, 27, 'Recursive', 'Partial', '2019-11-23', '2019-12-22', NULL, 415.66, 184.32, 72.00, 31.93, '2019-11-23 17:17:55', 1, '2019-11-23 17:20:35', 1);
INSERT INTO `ina_policy_installments` VALUES (142, 27, 'Recursive', 'UnPaid', '2019-11-23', '2020-01-22', NULL, 415.66, 0.00, 72.00, 0.00, '2019-11-23 17:17:55', 1, '2019-11-23 17:17:55', 1);
INSERT INTO `ina_policy_installments` VALUES (143, 24, 'Recursive', 'UnPaid', '2019-11-28', '2019-10-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (144, 24, 'Recursive', 'UnPaid', '2019-11-28', '2019-11-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (145, 24, 'Recursive', 'UnPaid', '2019-11-28', '2019-12-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (146, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-01-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (147, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-02-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (148, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-03-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (149, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-04-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (150, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-05-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (151, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-06-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (152, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-07-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (153, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-08-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (154, 24, 'Recursive', 'UnPaid', '2019-11-28', '2020-09-18', NULL, 32.25, 0.00, 8.75, 0.00, '2019-11-28 11:36:09', 1, '2019-11-28 11:36:09', 1);
INSERT INTO `ina_policy_installments` VALUES (161, 30, 'Divided', 'UnPaid', '2020-02-26', '2019-12-05', NULL, 45.24, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (162, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-01-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (163, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-02-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (164, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-03-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (165, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-04-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (166, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-05-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (167, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-06-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (168, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-07-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (169, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-08-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (170, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-09-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (171, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-10-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (172, 30, 'Divided', 'UnPaid', '2020-02-26', '2020-11-05', NULL, 45.16, 0.00, 3.75, 0.00, '2020-02-26 10:45:26', 1, '2020-02-26 10:45:26', 1);
INSERT INTO `ina_policy_installments` VALUES (205, 34, 'Divided', 'Paid', '2020-03-16', '2020-03-13', NULL, 138.00, 138.00, 22.50, 22.50, '2020-03-16 11:30:52', 1, '2020-03-16 11:31:51', 1);
INSERT INTO `ina_policy_installments` VALUES (206, 34, 'Divided', 'UnPaid', '2020-03-16', '2020-06-13', NULL, 138.00, 0.00, 22.50, 0.00, '2020-03-16 11:30:52', 1, '2020-03-16 11:30:52', 1);
INSERT INTO `ina_policy_installments` VALUES (207, 34, 'Divided', 'UnPaid', '2020-03-16', '2020-09-13', NULL, 138.00, 0.00, 22.50, 0.00, '2020-03-16 11:30:52', 1, '2020-03-16 11:30:52', 1);
INSERT INTO `ina_policy_installments` VALUES (208, 34, 'Divided', 'UnPaid', '2020-03-16', '2020-12-13', NULL, 138.00, 0.00, 22.50, 0.00, '2020-03-16 11:30:52', 1, '2020-03-16 11:30:52', 1);
INSERT INTO `ina_policy_installments` VALUES (209, 35, 'Divided', 'Paid', '2020-03-16', '2020-03-16', NULL, 140.50, 140.50, 22.50, 22.50, '2020-03-16 11:52:50', 1, '2020-03-16 11:53:15', 1);
INSERT INTO `ina_policy_installments` VALUES (210, 35, 'Divided', 'Paid', '2020-03-16', '2020-06-16', NULL, 140.50, 140.50, 22.50, 22.50, '2020-03-16 11:52:50', 1, '2020-03-16 12:42:04', 1);
INSERT INTO `ina_policy_installments` VALUES (211, 35, 'Divided', 'Partial', '2020-03-16', '2020-09-16', NULL, 90.50, 71.00, 13.50, 11.37, '2020-03-16 11:52:50', 1, '2020-03-23 11:22:57', 1);
INSERT INTO `ina_policy_installments` VALUES (212, 35, 'Divided', 'UnPaid', '2020-03-16', '2020-12-16', NULL, 90.50, 0.00, 13.50, 0.00, '2020-03-16 11:52:50', 1, '2020-03-23 11:22:57', 1);
INSERT INTO `ina_policy_installments` VALUES (213, 36, 'Divided', 'UnPaid', '2020-03-20', '2020-03-20', NULL, 133.00, 0.00, 22.50, 0.00, '2020-03-20 16:14:13', 1, '2020-03-20 16:14:13', 1);
INSERT INTO `ina_policy_installments` VALUES (214, 36, 'Divided', 'UnPaid', '2020-03-20', '2020-06-20', NULL, 133.00, 0.00, 22.50, 0.00, '2020-03-20 16:14:13', 1, '2020-03-20 16:14:13', 1);
INSERT INTO `ina_policy_installments` VALUES (215, 36, 'Divided', 'UnPaid', '2020-03-20', '2020-09-20', NULL, 133.00, 0.00, 22.50, 0.00, '2020-03-20 16:14:13', 1, '2020-03-20 16:14:13', 1);
INSERT INTO `ina_policy_installments` VALUES (216, 36, 'Divided', 'UnPaid', '2020-03-20', '2020-12-20', NULL, 133.00, 0.00, 22.50, 0.00, '2020-03-20 16:14:13', 1, '2020-03-20 16:14:13', 1);
INSERT INTO `ina_policy_installments` VALUES (218, 46, 'Divided', 'UnPaid', '0000-00-00', '2020-03-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:52', 1);
INSERT INTO `ina_policy_installments` VALUES (219, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-04-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (220, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-05-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (221, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-06-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (222, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-07-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (223, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-08-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (224, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-09-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (225, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-10-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (226, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-11-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (227, 46, 'Divided', 'UnPaid', '2020-03-23', '2020-12-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (228, 46, 'Divided', 'UnPaid', '2020-03-23', '2021-01-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (229, 46, 'Divided', 'UnPaid', '2020-03-23', '2021-02-21', NULL, 36.00, 0.00, 6.00, 0.00, '2020-03-23 11:43:49', 1, '2020-03-23 11:43:49', 1);
INSERT INTO `ina_policy_installments` VALUES (230, 61, 'Divided', 'Paid', '2020-03-27', '2020-03-27', NULL, 253.00, 253.00, 50.00, 50.00, '2020-03-27 12:06:58', 1, '2020-03-27 12:08:57', 1);
INSERT INTO `ina_policy_installments` VALUES (231, 61, 'Divided', 'Paid', '2020-03-27', '2020-06-27', NULL, 319.66, 319.66, 63.33, 63.33, '2020-03-27 12:06:58', 1, '2020-03-27 12:11:11', 1);
INSERT INTO `ina_policy_installments` VALUES (232, 61, 'Divided', 'UnPaid', '2020-03-27', '2020-09-27', NULL, 319.66, 0.00, 63.33, 0.00, '2020-03-27 12:06:58', 1, '2020-03-27 12:10:52', 1);
INSERT INTO `ina_policy_installments` VALUES (233, 61, 'Divided', 'UnPaid', '2020-03-27', '2020-12-27', NULL, 319.68, 0.00, 63.34, 0.00, '2020-03-27 12:06:58', 1, '2020-03-27 12:10:52', 1);
INSERT INTO `ina_policy_installments` VALUES (234, 66, 'Divided', 'UnPaid', '2020-03-29', '2021-03-27', NULL, 287.50, 0.00, 60.00, 0.00, '2020-03-29 12:01:36', 1, '2020-03-29 12:01:36', 1);
INSERT INTO `ina_policy_installments` VALUES (235, 66, 'Divided', 'UnPaid', '2020-03-29', '2021-06-27', NULL, 287.50, 0.00, 60.00, 0.00, '2020-03-29 12:01:36', 1, '2020-03-29 12:01:36', 1);
INSERT INTO `ina_policy_installments` VALUES (236, 66, 'Divided', 'UnPaid', '2020-03-29', '2021-09-27', NULL, 287.50, 0.00, 60.00, 0.00, '2020-03-29 12:01:36', 1, '2020-03-29 12:01:36', 1);
INSERT INTO `ina_policy_installments` VALUES (237, 66, 'Divided', 'UnPaid', '2020-03-29', '2021-12-27', NULL, 287.50, 0.00, 60.00, 0.00, '2020-03-29 12:01:36', 1, '2020-03-29 12:01:36', 1);
INSERT INTO `ina_policy_installments` VALUES (238, 67, 'Recursive', 'UnPaid', '2020-03-29', '2019-06-03', NULL, 75.00, 0.00, 25.00, 0.00, '2020-03-29 12:01:57', 1, '2020-03-29 12:01:57', 1);
INSERT INTO `ina_policy_installments` VALUES (239, 67, 'Recursive', 'UnPaid', '2020-03-29', '2019-07-03', NULL, 75.00, 0.00, 25.00, 0.00, '2020-03-29 12:01:57', 1, '2020-03-29 12:01:57', 1);
INSERT INTO `ina_policy_installments` VALUES (240, 68, 'Recursive', 'UnPaid', '2020-03-29', '2019-07-10', NULL, 138.34, 0.00, 36.68, 0.00, '2020-03-29 12:01:58', 1, '2020-03-29 12:01:58', 1);
INSERT INTO `ina_policy_installments` VALUES (241, 68, 'Recursive', 'UnPaid', '2020-03-29', '2019-08-10', NULL, 138.33, 0.00, 36.66, 0.00, '2020-03-29 12:01:58', 1, '2020-03-29 12:01:58', 1);
INSERT INTO `ina_policy_installments` VALUES (242, 68, 'Recursive', 'UnPaid', '2020-03-29', '2019-09-10', NULL, 138.33, 0.00, 36.66, 0.00, '2020-03-29 12:01:58', 1, '2020-03-29 12:01:58', 1);
INSERT INTO `ina_policy_installments` VALUES (243, 70, 'Divided', 'Paid', '2020-04-01', '2020-03-31', NULL, 140.50, 140.50, 27.50, 27.50, '2020-04-01 11:37:50', 1, '2020-04-01 11:38:35', 1);
INSERT INTO `ina_policy_installments` VALUES (244, 70, 'Divided', 'Paid', '2020-04-01', '2020-07-01', NULL, 140.50, 140.50, 27.50, 27.50, '2020-04-01 11:37:53', 1, '2020-04-01 11:38:35', 1);
INSERT INTO `ina_policy_installments` VALUES (245, 70, 'Divided', 'Paid', '2020-04-01', '2020-10-01', NULL, 140.50, 140.50, 27.50, 27.50, '2020-04-01 11:37:55', 1, '2020-04-01 11:38:35', 1);
INSERT INTO `ina_policy_installments` VALUES (246, 70, 'Divided', 'Paid', '2020-04-01', '2020-12-31', NULL, 40.50, 40.50, -27.50, 7.93, '2020-04-01 11:37:57', 1, '2020-04-01 11:47:12', 1);
INSERT INTO `ina_policy_installments` VALUES (247, 69, 'Recursive', 'UnPaid', '2020-04-10', '2020-03-31', NULL, 602.00, 0.00, 108.00, 0.00, '2020-04-10 11:26:47', 1, '2020-04-10 11:26:47', 1);
INSERT INTO `ina_policy_installments` VALUES (250, 75, 'Recursive', 'UnPaid', '2020-04-10', '2021-03-31', NULL, 540.00, 0.00, 108.00, 0.00, '2020-04-10 12:09:20', 1, '2020-04-10 12:09:20', 1);
INSERT INTO `ina_policy_installments` VALUES (251, 76, 'Recursive', 'Paid', '2020-04-10', '2020-04-01', NULL, 562.00, 562.00, 100.00, 100.00, '2020-04-10 14:19:00', 1, '2020-04-11 14:06:50', 1);
INSERT INTO `ina_policy_installments` VALUES (253, 76, 'Endorsement', 'UnPaid', '2020-04-12', '2020-04-12', '2020-04-12', 50.00, 0.00, 10.00, 0.00, '2020-04-12 10:03:11', 1, NULL, NULL);
INSERT INTO `ina_policy_installments` VALUES (256, 81, 'Recursive', 'UnPaid', '2020-04-12', '2021-04-01', NULL, 550.00, 0.00, 110.00, 0.00, '2020-04-12 11:05:51', 1, '2020-04-12 11:05:51', 1);
INSERT INTO `ina_policy_installments` VALUES (257, 82, 'Recursive', 'Paid', '2020-04-12', '2020-04-01', NULL, 110.66, 110.66, 18.00, 18.00, '2020-04-12 11:13:54', 1, '2020-04-12 12:05:24', 1);
INSERT INTO `ina_policy_installments` VALUES (258, 82, 'Recursive', 'Paid', '2020-04-12', '2020-05-01', NULL, 110.65, 110.65, 17.99, 17.99, '2020-04-12 11:13:54', 1, '2020-04-12 12:05:24', 1);
INSERT INTO `ina_policy_installments` VALUES (259, 82, 'Recursive', 'Paid', '2020-04-12', '2020-06-01', NULL, 110.69, 110.69, 18.01, 18.01, '2020-04-12 11:13:54', 1, '2020-04-12 12:05:24', 1);
INSERT INTO `ina_policy_installments` VALUES (260, 89, 'Recursive', 'Paid', '2020-04-12', '2020-04-01', NULL, 237.34, 237.34, 43.34, 43.34, '2020-04-12 12:16:32', 1, '2020-04-12 12:23:17', 1);
INSERT INTO `ina_policy_installments` VALUES (261, 89, 'Recursive', 'Paid', '2020-04-12', '2020-05-01', NULL, 237.33, 237.33, 43.33, 43.33, '2020-04-12 12:16:32', 1, '2020-04-12 12:57:00', 1);
INSERT INTO `ina_policy_installments` VALUES (262, 89, 'Recursive', 'Paid', '2020-04-12', '2020-06-01', NULL, 237.33, 237.33, 43.33, 43.33, '2020-04-12 12:16:32', 1, '2020-04-12 12:57:00', 1);
INSERT INTO `ina_policy_installments` VALUES (263, 95, 'Divided', 'Paid', '2020-04-15', '2020-04-01', NULL, 262.00, 262.00, 40.00, 40.00, '2020-04-15 12:30:01', 1, '2020-04-15 12:30:25', 1);
INSERT INTO `ina_policy_installments` VALUES (289, 95, 'Endorsement', 'Paid', '2020-04-16', '2020-04-16', '2020-04-16', -200.00, -200.00, -40.00, -40.00, '2020-04-16 10:34:53', 1, NULL, NULL);
INSERT INTO `ina_policy_installments` VALUES (290, 97, 'Divided', 'Paid', '2020-04-16', '2020-04-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 11:37:46', 1, '2020-04-16 11:38:18', 1);
INSERT INTO `ina_policy_installments` VALUES (291, 97, 'Divided', 'Paid', '2020-04-16', '2020-07-01', NULL, 110.50, 110.50, 18.33, 18.33, '2020-04-16 11:37:46', 1, '2020-04-16 12:22:19', 1);
INSERT INTO `ina_policy_installments` VALUES (292, 97, 'Divided', 'Paid', '2020-04-16', '2020-10-01', NULL, 110.50, 110.50, 18.33, 18.33, '2020-04-16 11:37:46', 1, '2020-04-16 12:39:32', 1);
INSERT INTO `ina_policy_installments` VALUES (293, 97, 'Divided', 'Paid', '2020-04-16', '2021-01-01', NULL, 110.50, 110.50, 18.34, 18.34, '2020-04-16 11:37:46', 1, '2020-04-16 12:43:02', 1);
INSERT INTO `ina_policy_installments` VALUES (294, 99, 'Divided', 'Paid', '2020-04-16', '2020-04-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 12:47:08', 1, '2020-04-16 12:47:39', 1);
INSERT INTO `ina_policy_installments` VALUES (295, 99, 'Divided', 'Paid', '2020-04-16', '2020-07-01', NULL, 110.50, 110.50, 18.33, 18.33, '2020-04-16 12:47:08', 1, '2020-04-16 12:50:08', 1);
INSERT INTO `ina_policy_installments` VALUES (296, 99, 'Divided', 'UnPaid', '2020-04-16', '2020-10-01', NULL, 110.50, 0.00, 18.33, 0.00, '2020-04-16 12:47:08', 1, '2020-04-16 12:49:35', 1);
INSERT INTO `ina_policy_installments` VALUES (297, 99, 'Divided', 'UnPaid', '2020-04-16', '2021-01-01', NULL, 110.50, 0.00, 18.34, 0.00, '2020-04-16 12:47:08', 1, '2020-04-16 12:49:35', 1);
INSERT INTO `ina_policy_installments` VALUES (298, 101, 'Divided', 'Paid', '2020-04-16', '2020-04-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 13:28:01', 1, '2020-04-16 13:28:46', 1);
INSERT INTO `ina_policy_installments` VALUES (299, 101, 'Divided', 'UnPaid', '2020-04-16', '2020-07-01', NULL, 140.50, 0.00, 25.00, 0.00, '2020-04-16 13:28:01', 1, '2020-04-16 13:28:01', 1);
INSERT INTO `ina_policy_installments` VALUES (300, 101, 'Divided', 'UnPaid', '2020-04-16', '2020-10-01', NULL, 140.50, 0.00, 25.00, 0.00, '2020-04-16 13:28:01', 1, '2020-04-16 13:28:01', 1);
INSERT INTO `ina_policy_installments` VALUES (301, 101, 'Divided', 'UnPaid', '2020-04-16', '2021-01-01', NULL, 140.50, 0.00, 25.00, 0.00, '2020-04-16 13:28:01', 1, '2020-04-16 13:28:01', 1);
INSERT INTO `ina_policy_installments` VALUES (302, 102, 'Divided', 'Paid', '2020-04-16', '2020-04-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 13:38:56', 1, '2020-04-16 13:39:14', 1);
INSERT INTO `ina_policy_installments` VALUES (303, 102, 'Divided', 'Paid', '2020-04-16', '2020-07-01', NULL, 110.50, 110.50, 18.33, 18.33, '2020-04-16 13:38:56', 1, '2020-04-16 13:41:11', 1);
INSERT INTO `ina_policy_installments` VALUES (304, 102, 'Divided', 'Paid', '2020-04-16', '2020-10-01', NULL, 110.50, 110.50, 18.33, 18.33, '2020-04-16 13:38:56', 1, '2020-04-16 13:54:46', 1);
INSERT INTO `ina_policy_installments` VALUES (305, 102, 'Divided', 'Paid', '2020-04-16', '2021-01-01', NULL, 110.50, 110.50, 18.34, 18.34, '2020-04-16 13:38:56', 1, '2020-04-16 13:57:49', 1);
INSERT INTO `ina_policy_installments` VALUES (308, 102, 'Endorsement', 'Paid', '2020-04-16', '2020-04-16', '2020-04-16', -100.00, -100.00, -25.00, -25.00, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ina_policy_installments` VALUES (309, 105, 'Divided', 'Paid', '2020-04-16', '2020-04-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 14:19:58', 1, '2020-04-16 14:20:26', 1);
INSERT INTO `ina_policy_installments` VALUES (310, 105, 'Divided', 'Paid', '2020-04-16', '2020-07-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 14:19:58', 1, '2020-04-16 14:21:17', 1);
INSERT INTO `ina_policy_installments` VALUES (311, 105, 'Divided', 'Paid', '2020-04-16', '2020-10-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 14:19:58', 1, '2020-04-16 14:21:17', 1);
INSERT INTO `ina_policy_installments` VALUES (312, 105, 'Divided', 'Paid', '2020-04-16', '2021-01-01', NULL, 140.50, 140.50, 25.00, 25.00, '2020-04-16 14:19:58', 1, '2020-04-16 14:21:17', 1);
INSERT INTO `ina_policy_installments` VALUES (313, 105, 'Endorsement', 'Paid', '2020-04-16', '2020-04-16', '2020-04-16', -100.00, -100.00, -20.00, -20.00, '2020-04-16 14:22:43', 1, NULL, NULL);
INSERT INTO `ina_policy_installments` VALUES (314, 107, 'Divided', 'Paid', '2020-04-16', '2020-04-01', NULL, 472.00, 472.00, 80.00, 80.00, '2020-04-16 14:24:31', 1, '2020-04-16 14:34:05', 1);
INSERT INTO `ina_policy_installments` VALUES (315, 107, 'Endorsement', 'Paid', '2020-04-16', '2020-04-16', '2020-04-16', -100.00, -100.00, -20.00, -20.00, '2020-04-16 14:35:04', 1, NULL, NULL);
INSERT INTO `ina_policy_installments` VALUES (319, 110, 'Divided', 'UnPaid', '2020-04-27', '2020-04-01', NULL, 138.00, 0.00, 25.00, 0.00, '2020-04-27 11:57:40', 1, '2020-04-27 11:57:40', 1);
INSERT INTO `ina_policy_installments` VALUES (320, 110, 'Divided', 'UnPaid', '2020-04-27', '2020-07-01', NULL, 138.00, 0.00, 25.00, 0.00, '2020-04-27 11:57:40', 1, '2020-04-27 11:57:40', 1);
INSERT INTO `ina_policy_installments` VALUES (321, 110, 'Divided', 'UnPaid', '2020-04-27', '2020-10-01', NULL, 138.00, 0.00, 25.00, 0.00, '2020-04-27 11:57:40', 1, '2020-04-27 11:57:40', 1);
INSERT INTO `ina_policy_installments` VALUES (322, 110, 'Divided', 'UnPaid', '2020-04-27', '2021-01-01', NULL, 138.00, 0.00, 25.00, 0.00, '2020-04-27 11:57:40', 1, '2020-04-27 11:57:40', 1);
INSERT INTO `ina_policy_installments` VALUES (341, 111, 'Recursive', 'UnPaid', '2020-07-27', '2020-04-01', NULL, 289.50, NULL, 27.50, 0.00, '2020-07-27 13:38:14', 7, '2020-07-27 13:38:14', 7);
INSERT INTO `ina_policy_installments` VALUES (342, 112, 'Divided', 'UnPaid', '2020-08-13', '2020-08-13', NULL, 23.50, NULL, 4.24, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (343, 112, 'Divided', 'UnPaid', '2020-08-13', '2020-09-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (344, 112, 'Divided', 'UnPaid', '2020-08-13', '2020-10-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (345, 112, 'Divided', 'UnPaid', '2020-08-13', '2020-11-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (346, 112, 'Divided', 'UnPaid', '2020-08-13', '2020-12-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (347, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-01-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (348, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-02-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (349, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-03-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (350, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-04-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (351, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-05-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (352, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-06-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);
INSERT INTO `ina_policy_installments` VALUES (353, 112, 'Divided', 'UnPaid', '2020-08-13', '2021-07-13', NULL, 23.50, NULL, 4.16, 0.00, '2020-08-13 10:09:33', 1, '2020-08-13 10:09:33', 1);

-- ----------------------------
-- Table structure for ina_policy_items
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_items`;
CREATE TABLE `ina_policy_items`  (
  `inapit_policy_item_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapit_policy_ID` int(8) NULL DEFAULT NULL,
  `inapit_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_vh_registration` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_vh_body_type_code_ID` int(8) NULL DEFAULT NULL,
  `inapit_vh_cubic_capacity` int(8) NULL DEFAULT NULL,
  `inapit_vh_make_code_ID` int(8) NULL DEFAULT NULL,
  `inapit_vh_manufacture_year` int(6) NULL DEFAULT NULL,
  `inapit_vh_model` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_vh_passengers` int(3) NULL DEFAULT NULL,
  `inapit_vh_color_code_ID` int(8) NULL DEFAULT NULL,
  `inapit_rl_address_1` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_rl_address_2` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_rl_address_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_rl_postal_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapit_rl_city_code_ID` int(8) NULL DEFAULT NULL,
  `inapit_rl_construction_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_mb_full_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_mb_birth_date` date NULL DEFAULT NULL,
  `inapit_mb_nationality_ID` int(8) NULL DEFAULT NULL,
  `inapit_package_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_package_ID` int(8) NULL DEFAULT NULL,
  `inapit_insured_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapit_excess` decimal(10, 2) NULL DEFAULT NULL,
  `inapit_premium` decimal(10, 2) NULL DEFAULT NULL,
  `inapit_mif` decimal(10, 2) NULL DEFAULT NULL,
  `inapit_first_entry_date` date NULL DEFAULT NULL,
  `inapit_char_1` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_char_2` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_char_3` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_char_4` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_char_5` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inapit_longtext_1` longtext CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `inapit_longtext_2` longtext CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `inapit_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inapit_created_by` int(8) NULL DEFAULT NULL,
  `inapit_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inapit_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inapit_policy_item_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 91 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_policy_items
-- ----------------------------
INSERT INTO `ina_policy_items` VALUES (1, 1, 'Vehicles', 'KWA089', 9, 2200, 13, 2006, 'IS220D', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000.00, 500.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-26 12:17:09', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (2, 4, 'Vehicles', 'KWA089', 9, 2200, 13, 2006, 'IS220D', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000.00, 500.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-28 13:48:52', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (3, 6, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Larnaka', 'apt101', '35', '7000', 8, 'Apartment', NULL, NULL, NULL, NULL, NULL, 5000.00, 500.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-28 16:30:43', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (4, 7, 'PublicLiability', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000.00, 100.00, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-28 18:24:15', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (5, 7, 'PublicLiability', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 50000.00, 222.00, 150.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-28 18:24:24', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (7, 9, 'Vehicles', 'KWA089', 9, 2200, 13, 2006, 'IS220D', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000.00, 500.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 16:31:47', 5, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (8, 10, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Larnaka', '', '35', '7000', 10, 'House', NULL, NULL, NULL, NULL, NULL, 10000.00, 500.00, 200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-03 11:09:17', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (10, 14, 'RiskLocation', '', 0, 0, 0, 0, '', 0, 0, 'Larnaka', '', '35', '7000', 10, 'House', NULL, NULL, NULL, NULL, NULL, 10000.00, 500.00, 200.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (11, 15, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Larnaka', 'apt101', '35', '7000', 8, 'House', NULL, NULL, NULL, NULL, NULL, 10000.00, 200.00, 150.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-11 12:19:59', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (12, 17, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Larnaka', 'apt101', '35', '6050', 10, 'House', NULL, NULL, NULL, NULL, NULL, 10000.00, 500.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-11 12:33:43', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (13, 18, 'Vehicles', 'ABL890', 9, 2200, 13, 2006, 'dfdfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000.00, 0.00, 235.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-18 23:45:10', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (14, 18, 'Vehicles', 'KWW011', 9, 1200, 13, 2015, 'dfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6000.00, 0.00, 180.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-18 23:45:42', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (15, 12, 'Vehicles', 'ABC123', 9, 1200, 13, 2015, 'dfdfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000.00, 0.00, 150.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-19 00:03:16', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (17, 19, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Ermogenous', '0000-00-00', NULL, '', 0, 1000000.00, 500.00, 675.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-22 13:05:18', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (18, 20, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Ermogenous', '0000-00-00', NULL, '', 0, 500000.00, 250.00, 670.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-22 19:21:14', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (19, 20, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Marilia Ermogenous', '0000-00-00', NULL, '', 0, 500000.00, 0.00, 450.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-22 19:21:36', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (20, 8, 'Vehicle', 'ABC123', 9, 1200, 13, 2015, 'IS220D', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 6000.00, 200.00, 265.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-23 12:43:46', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (21, 21, 'Vehicle', 'CBA321', 9, 1200, 13, 2015, 'Astra', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '', 0, 60000.00, 500.00, 550.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-08-05 23:33:59', 1, '2019-08-12 20:23:57', 1);
INSERT INTO `ina_policy_items` VALUES (22, 21, 'Vehicle', 'ABC123', 9, 1600, 14, 2015, 'Yaris', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '', 0, 8000.00, 250.00, 320.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-08-07 15:35:59', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (23, 11, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Larnaka', 'apt101', '35', '7000', 10, 'House', NULL, '0000-00-00', NULL, '', 0, 50000.00, 150.00, 525.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-08-25 20:33:02', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (24, 22, 'Vehicle', 'AAA', 9, 1000, 13, 2015, 'dfdfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'fgd', 0, 10000.00, 2000.00, 300.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-03 10:42:20', 1, '2019-10-15 10:28:08', 1);
INSERT INTO `ina_policy_items` VALUES (25, 23, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lkjdshfalks', '1950-01-01', NULL, 'dsfas', 0, 1000000.00, 0.00, 500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-10-15 10:36:03', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (26, 23, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fgdfgds', '1955-02-02', NULL, 'jhkh', 0, 1000000.00, 0.00, 400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-10-15 10:36:25', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (27, 24, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfs', 'sdf', 'dsf', '2121', 10, 'House', NULL, '0000-00-00', NULL, '', 0, 25000.00, 0.00, 350.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-10-18 14:49:03', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (28, 25, 'RiskLocation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Larnaka', 'apt101', 'dsf', '2121', 10, 'House', NULL, '0000-00-00', NULL, '', 0, 75000.00, 0.00, 275.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-06 13:58:44', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (29, 26, 'Vehicle', 'ABL890', 9, 1200, 13, 2015, 'dfdfd', 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '', 0, 10000.00, 150.00, 200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-19 16:45:12', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (30, 27, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Test', '1970-01-01', NULL, '', 5, 2000000.00, 650.00, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-23 11:32:58', 1, '2019-11-23 17:13:45', 1);
INSERT INTO `ina_policy_items` VALUES (31, 27, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wife', '1970-01-02', NULL, '', 5, 2000000.00, 650.00, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-23 11:33:30', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (32, 30, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Ermogenous', '1979-05-24', 220, NULL, 5, NULL, 0.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-06 11:24:36', 1, '2019-12-06 11:55:33', 1);
INSERT INTO `ina_policy_items` VALUES (33, 30, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 2', '2012-11-24', 220, NULL, 3, NULL, 150.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-18 11:55:51', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (34, 34, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '1979-05-24', 220, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Group', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-16 09:59:44', 1, '2020-03-16 10:23:08', 1);
INSERT INTO `ina_policy_items` VALUES (35, 35, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '1980-01-01', 220, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-16 11:51:34', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (36, 36, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '1979-05-24', 220, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-20 16:14:01', 1, '2020-03-21 13:50:33', 1);
INSERT INTO `ina_policy_items` VALUES (37, 36, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ttt', '2020-03-10', 188, NULL, 3, NULL, 650.00, 250.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-21 13:51:26', 1, '2020-03-21 13:51:30', 1);
INSERT INTO `ina_policy_items` VALUES (38, 47, 'Member', '', 0, 0, 0, 0, '', 0, 0, '', '', '', '', 0, '', 'Member 1', '1980-01-01', 220, '', 3, 0.00, 650.00, 500.00, 0.00, '0000-00-00', 'Individual', 'Medical Cover on Full Application', 'Worldwide', '', '', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (39, 48, 'Member', '', 0, 0, 0, 0, '', 0, 0, '', '', '', '', 0, '', 'Member 1', '1980-01-01', 220, '', 3, 0.00, 650.00, 500.00, 0.00, '0000-00-00', 'Individual', 'Medical Cover on Full Application', 'Worldwide', '', '', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (46, 55, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '1980-01-01', 220, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-23 11:12:08', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (47, 46, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '1980-01-01', 356, NULL, 3, NULL, 650.00, 400.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-23 11:42:28', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (48, 60, 'Vehicle', 'dsfs', 9, 121, 13, 121, '121', 12, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '121', 0, 121.00, 1212.00, 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-23 21:26:03', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (49, 61, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'erere', '1980-01-01', 186, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-03-27 10:52:37', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (50, 61, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdga', '1980-01-01', 187, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-03-27 12:04:34', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (51, 62, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'erere', '1980-01-01', 186, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-27 12:09:50', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (52, 62, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdga', '1980-01-01', 187, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-03-27 12:09:50', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (53, 66, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'erere', '1980-01-01', 186, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (54, 66, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdga', '1980-01-01', 187, NULL, 3, NULL, 650.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (55, 67, 'Vehicles', 'ABC123', 9, 1200, 13, 2015, 'dfdfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000.00, 0.00, 150.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (56, 68, 'Vehicles', 'ABL890', 9, 2200, 13, 2006, 'dfdfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000.00, 0.00, 235.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (57, 68, 'Vehicles', 'KWW011', 9, 1200, 13, 2015, 'dfd', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6000.00, 0.00, 180.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (58, 70, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dsf', '2020-04-01', 180, NULL, 3, NULL, 650.00, 550.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-01 11:35:11', 1, '2020-04-01 11:37:16', 1);
INSERT INTO `ina_policy_items` VALUES (59, 69, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '2020-04-07', 356, NULL, 4, NULL, 650.00, 540.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-07 16:07:13', 1, '2020-04-07 16:19:07', 1);
INSERT INTO `ina_policy_items` VALUES (62, 75, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '2020-04-07', 356, NULL, 4, NULL, 650.00, 540.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (63, 76, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdgds', '2020-04-01', 190, NULL, 3, NULL, 150.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-10 14:17:11', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (65, 78, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdgds', '2020-04-01', 190, NULL, 3, NULL, 150.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-04-12 10:02:44', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (68, 81, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdgds', '2020-04-01', 190, NULL, 3, NULL, 150.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (69, 82, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdgsd', '2020-04-01', 356, NULL, 6, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-12 11:12:44', 1, '2020-04-12 11:12:47', 1);
INSERT INTO `ina_policy_items` VALUES (73, 86, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdgsd', '2020-04-01', 356, NULL, 6, NULL, 0.00, 520.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-12 11:26:34', 1, '2020-04-12 11:35:38', 1);
INSERT INTO `ina_policy_items` VALUES (74, 86, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdsgdf', '2020-04-13', 187, NULL, 3, NULL, 0.00, 250.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-12 11:29:21', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (75, 89, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kjhk', '2020-04-01', 188, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-12 12:13:41', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (76, 90, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kjhk', '2020-04-01', 188, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-04-12 12:16:51', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (77, 95, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fgfdsgf', '2020-04-01', 189, NULL, 3, NULL, 0.00, 200.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-15 12:29:04', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (78, 97, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdfs', '2020-04-01', 188, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-16 11:37:15', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (79, 98, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdfs', '2020-04-01', 188, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-04-16 11:50:06', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (80, 99, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdasdf', '2020-04-01', 189, NULL, 4, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-16 12:44:34', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (81, 100, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fdasdf', '2020-04-01', 189, NULL, 4, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-04-16 12:48:28', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (82, 101, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '2020-04-01', 190, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Continuing Personal Medical Exclusions', 'Worldwide', NULL, NULL, '', '', '2020-04-16 13:27:23', 1, '2020-04-16 13:27:24', 1);
INSERT INTO `ina_policy_items` VALUES (83, 102, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sadfsda', '2020-04-01', 191, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Continuing Personal Medical Exclusions', 'Worldwide', NULL, NULL, '', '', '2020-04-16 13:38:41', 1, '2020-04-16 13:38:42', 1);
INSERT INTO `ina_policy_items` VALUES (84, 103, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sadfsda', '2020-04-01', 191, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Continuing Personal Medical Exclusions', 'Worldwide', NULL, NULL, NULL, NULL, '2020-04-16 13:40:09', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (85, 105, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dafsd', '2020-04-01', 188, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-16 14:18:59', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (86, 107, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fsgfd', '2020-04-01', 189, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-16 14:24:15', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (87, 108, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fsgfd', '2020-04-01', 189, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-04-16 14:26:07', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (88, 110, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdafdsf', '2020-04-01', 189, NULL, 3, NULL, 0.00, 500.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, '', '', '2020-04-16 15:49:02', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (89, 111, 'Vehicle', 'dsfs', 9, 1212, 13, 1222, 'gggg', 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '', 0, 0.00, 0.00, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-27 11:44:25', 1, NULL, NULL);
INSERT INTO `ina_policy_items` VALUES (90, 112, 'Member', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Member 1', '2020-08-13', 220, NULL, 3, NULL, 0.00, 250.00, NULL, NULL, 'Individual', 'Medical Cover on Full Application', 'Worldwide', NULL, NULL, NULL, NULL, '2020-08-13 10:08:37', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_policy_payments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments`;
CREATE TABLE `ina_policy_payments`  (
  `inapp_policy_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapp_policy_ID` int(8) NULL DEFAULT NULL,
  `inapp_current_policy_ID` int(8) NULL DEFAULT NULL,
  `inapp_customer_ID` int(8) NULL DEFAULT NULL,
  `inapp_status` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Outstanding\r\nApplied\r\nPosted\r\nIncomplete',
  `inapp_process_status` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapp_payment_type` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapp_payment_date` date NULL DEFAULT NULL,
  `inapp_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapp_commission_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapp_allocated_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inapp_allocated_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapp_allocated_sub_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapp_allocated_sub_sub_commission` decimal(10, 2) NULL DEFAULT NULL,
  `inapp_locked` int(1) NULL DEFAULT 0,
  `inapp_created_payment_ID` int(8) NULL DEFAULT 0,
  `inapp_replaced_by_payment_ID` int(8) NULL DEFAULT 0,
  `inapp_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inapp_created_by` int(8) NULL DEFAULT NULL,
  `inapp_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inapp_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inapp_policy_payment_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 113 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_policy_payments
-- ----------------------------
INSERT INTO `ina_policy_payments` VALUES (1, 1, NULL, 8, 'Applied', 'Policy', NULL, '2019-06-26', 150.00, NULL, 150.00, 27.08, NULL, NULL, 1, 0, 0, '2019-06-26 12:18:14', 1, '2019-06-26 12:18:17', 1);
INSERT INTO `ina_policy_payments` VALUES (2, 4, NULL, 8, 'Applied', 'Policy', NULL, '2019-06-28', 150.00, NULL, 150.00, 27.08, NULL, NULL, 1, 0, 0, '2019-06-28 14:00:39', 1, '2019-06-28 15:05:20', 1);
INSERT INTO `ina_policy_payments` VALUES (3, 1, NULL, 8, 'Outstanding', 'Policy', NULL, '2019-06-28', 27.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2019-06-28 16:09:28', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (4, 4, NULL, 8, 'Applied', 'Policy', NULL, '2019-06-28', 27.00, NULL, 27.00, 22.92, NULL, NULL, 0, 0, 0, '2019-06-28 16:24:12', 1, '2019-06-28 16:24:21', 1);
INSERT INTO `ina_policy_payments` VALUES (5, 9, NULL, 10, 'Applied', 'Policy', NULL, '2019-07-02', 177.00, NULL, 177.00, 31.96, NULL, NULL, 0, 0, 0, '2019-07-02 16:32:16', 5, '2019-07-02 16:38:07', 5);
INSERT INTO `ina_policy_payments` VALUES (6, 10, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-03', 100.00, NULL, 100.00, 24.81, NULL, NULL, 1, 0, 0, '2019-07-03 11:22:40', 1, '2019-07-04 11:27:11', 1);
INSERT INTO `ina_policy_payments` VALUES (7, 10, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-03', 112.00, NULL, 112.00, 27.79, NULL, NULL, 1, 0, 0, '2019-07-03 16:15:27', 1, '2019-07-04 11:27:11', 1);
INSERT INTO `ina_policy_payments` VALUES (8, 14, NULL, 1, 'Deleted', 'Unallocated', NULL, '2019-07-04', 90.00, 0.00, 0.00, 0.00, NULL, NULL, 0, 9, 10, NULL, NULL, '2019-07-04 15:18:07', 1);
INSERT INTO `ina_policy_payments` VALUES (9, 6, NULL, 1, 'Outstanding', 'Policy', NULL, '2019-07-04', 40.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2019-07-04 15:18:07', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (10, 6, NULL, 1, 'Outstanding', 'Unallocated', NULL, '2019-07-04', 50.00, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2019-07-04 15:18:07', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (11, 15, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-11', 50.00, NULL, 50.00, 14.11, NULL, NULL, 1, 0, 0, '2019-07-11 12:25:29', 1, '2019-07-11 12:31:23', 1);
INSERT INTO `ina_policy_payments` VALUES (12, 15, NULL, 1, 'Outstanding', 'Policy', NULL, '2019-07-11', 100.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2019-07-11 12:28:56', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (13, 16, NULL, 1, 'Outstanding', 'Unallocated', NULL, '2019-07-11', 12.96, 0.00, 0.00, 0.00, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (14, 17, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-11', 150.00, NULL, 150.00, 27.08, NULL, NULL, 0, 0, 0, '2019-07-11 12:36:24', 1, '2019-07-11 12:36:27', 1);
INSERT INTO `ina_policy_payments` VALUES (15, 17, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-11', 100.00, NULL, 100.00, 18.05, NULL, NULL, 0, 0, 0, '2019-07-11 12:36:45', 1, '2019-07-11 12:36:48', 1);
INSERT INTO `ina_policy_payments` VALUES (16, 18, NULL, 1, 'Active', 'Policy', NULL, '2019-07-18', 250.00, NULL, 250.00, 62.22, NULL, NULL, 0, 0, 0, '2019-07-18 23:46:14', 1, '2020-04-16 10:25:04', 1);
INSERT INTO `ina_policy_payments` VALUES (17, 12, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-19', 177.00, NULL, 177.00, 50.00, NULL, NULL, 0, 0, 0, '2019-07-19 00:05:26', 1, '2019-07-19 00:05:28', 1);
INSERT INTO `ina_policy_payments` VALUES (18, 20, NULL, 3, 'Applied', 'Policy', NULL, '2019-07-02', 98.50, NULL, 98.50, 12.50, NULL, NULL, 0, 0, 0, '2019-07-22 19:23:52', 1, '2019-07-22 19:23:55', 1);
INSERT INTO `ina_policy_payments` VALUES (19, 8, NULL, 1, 'Applied', 'Policy', NULL, '2019-07-23', 92.00, NULL, 92.00, 23.63, NULL, NULL, 0, 0, 0, '2019-07-23 14:26:25', 1, '2019-07-23 14:26:28', 1);
INSERT INTO `ina_policy_payments` VALUES (20, 20, NULL, 3, 'Applied', 'Policy', NULL, '2019-07-17', 200.00, NULL, 200.00, 25.38, NULL, NULL, 0, 0, 0, '2019-08-07 15:52:17', 1, '2019-08-07 15:52:33', 1);
INSERT INTO `ina_policy_payments` VALUES (21, 20, NULL, 3, 'Applied', 'Policy', NULL, '2019-08-02', 250.00, NULL, 250.00, 31.73, NULL, NULL, 0, 0, 0, '2019-08-07 15:52:30', 1, '2019-08-07 15:52:35', 1);
INSERT INTO `ina_policy_payments` VALUES (22, 21, NULL, 1, 'Applied', 'Policy', NULL, '2019-08-12', 150.00, NULL, 150.00, 18.30, NULL, NULL, 0, 0, 0, '2019-08-12 20:33:42', 1, '2019-08-12 20:33:49', 1);
INSERT INTO `ina_policy_payments` VALUES (23, 21, NULL, 1, 'Applied', 'Policy', NULL, '2019-08-12', 200.00, NULL, 200.00, 24.39, NULL, NULL, 0, 0, 0, '2019-08-12 20:34:23', 1, '2019-08-12 20:34:27', 1);
INSERT INTO `ina_policy_payments` VALUES (24, 22, NULL, 1, 'Applied', 'Policy', NULL, '2019-10-15', 80.00, NULL, 80.00, 8.11, NULL, NULL, 0, 0, 0, '2019-10-15 10:31:41', 1, '2019-10-15 10:31:45', 1);
INSERT INTO `ina_policy_payments` VALUES (25, 22, NULL, 1, 'Applied', 'Policy', NULL, '2019-10-15', 80.00, NULL, 80.00, 8.10, NULL, NULL, 0, 0, 0, '2019-10-15 10:32:17', 1, '2019-10-15 10:32:21', 1);
INSERT INTO `ina_policy_payments` VALUES (29, 26, NULL, 1, 'Active', 'Policy', NULL, '2019-11-20', 100.00, NULL, 100.00, 9.70, NULL, NULL, 0, 0, 0, '2019-11-20 18:26:49', 1, '2019-11-22 18:41:51', 1);
INSERT INTO `ina_policy_payments` VALUES (30, 7, NULL, 8, 'Active', 'Policy', NULL, '2019-11-23', 110.00, NULL, 110.00, 27.31, NULL, NULL, 0, 0, 0, '2019-11-23 11:44:36', 1, '2019-11-23 11:44:52', 1);
INSERT INTO `ina_policy_payments` VALUES (31, 27, NULL, 2, 'Active', 'Policy', NULL, '2019-11-23', 300.00, NULL, 300.00, 51.96, NULL, NULL, 0, 0, 0, '2019-11-23 17:20:00', 1, '2019-11-23 17:21:01', 1);
INSERT INTO `ina_policy_payments` VALUES (32, 27, NULL, 2, 'Active', 'Policy', NULL, '2019-11-23', 300.00, NULL, 300.00, 51.97, NULL, NULL, 0, 0, 0, '2019-11-23 17:20:32', 1, '2019-11-23 17:21:04', 1);
INSERT INTO `ina_policy_payments` VALUES (33, 34, NULL, 1, 'Active', 'Policy', NULL, '2020-03-16', 138.00, NULL, 138.00, 22.50, NULL, NULL, 0, 0, 0, '2020-03-16 10:46:53', 1, '2020-03-16 11:32:42', 1);
INSERT INTO `ina_policy_payments` VALUES (34, 35, NULL, 1, 'Active', 'Policy', NULL, '2020-03-16', 140.50, NULL, 140.50, 22.50, NULL, NULL, 0, 0, 0, '2020-03-16 11:53:11', 1, '2020-03-16 12:31:17', 1);
INSERT INTO `ina_policy_payments` VALUES (36, 35, NULL, 1, 'Active', 'Policy', NULL, '2020-03-16', 140.50, NULL, 140.50, 22.50, NULL, NULL, 0, 0, 0, '2020-03-16 12:42:01', 1, '2020-03-16 12:42:16', 1);
INSERT INTO `ina_policy_payments` VALUES (37, 35, NULL, 1, 'Active', 'Policy', NULL, '2020-03-16', 51.00, NULL, 51.00, 8.17, NULL, NULL, 0, 0, 0, '2020-03-16 12:52:12', 1, '2020-03-16 12:52:26', 1);
INSERT INTO `ina_policy_payments` VALUES (38, 35, NULL, 1, 'Active', 'Policy', NULL, '2020-03-23', 20.00, NULL, 20.00, 3.20, NULL, NULL, 0, 0, 0, '2020-03-23 11:13:17', 1, '2020-03-23 11:13:25', 1);
INSERT INTO `ina_policy_payments` VALUES (39, 61, NULL, 1, 'Active', 'Policy', NULL, '2020-03-27', 253.00, NULL, 253.00, 50.00, NULL, NULL, 0, 0, 0, '2020-03-27 12:08:54', 1, '2020-03-27 12:09:04', 1);
INSERT INTO `ina_policy_payments` VALUES (40, 61, NULL, 1, 'Active', 'Policy', NULL, '2020-03-27', 319.66, NULL, 319.66, 63.33, NULL, NULL, 0, 0, 0, '2020-03-27 12:11:06', 1, '2020-03-27 12:11:19', 1);
INSERT INTO `ina_policy_payments` VALUES (41, 70, NULL, 1, 'Active', 'Policy', NULL, '2020-04-01', 462.00, NULL, 462.00, 90.43, NULL, NULL, 0, 0, 0, '2020-04-01 11:38:32', 1, '2020-04-01 11:38:38', 1);
INSERT INTO `ina_policy_payments` VALUES (42, 72, NULL, 1, 'Outstanding', 'Unallocated', NULL, '2020-04-01', 200.00, 0.00, 0.00, 0.00, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (43, 76, NULL, 1, 'Active', 'Policy', NULL, '2020-04-11', 562.00, NULL, 562.00, 100.00, NULL, NULL, 0, 0, 0, '2020-04-11 14:06:47', 1, '2020-04-11 14:07:09', 1);
INSERT INTO `ina_policy_payments` VALUES (44, 82, NULL, 1, 'Active', 'Policy', NULL, '2020-04-12', 332.00, NULL, 332.00, 54.00, NULL, NULL, 0, 0, 0, '2020-04-12 12:05:19', 1, '2020-04-12 12:05:34', 1);
INSERT INTO `ina_policy_payments` VALUES (45, 89, NULL, 1, 'Active', 'Policy', NULL, '2020-04-12', 237.34, NULL, 237.34, 43.34, NULL, NULL, 0, 0, 0, '2020-04-12 12:23:15', 1, '2020-04-12 12:50:23', 1);
INSERT INTO `ina_policy_payments` VALUES (46, 89, NULL, 1, 'Active', 'Policy', NULL, '2020-04-12', 474.66, NULL, 474.66, 86.66, NULL, NULL, 0, 0, 0, '2020-04-12 12:56:57', 1, '2020-04-12 12:57:06', 1);
INSERT INTO `ina_policy_payments` VALUES (47, 95, NULL, 5, 'Active', 'Policy', NULL, '2020-04-15', 262.00, NULL, 262.00, 40.00, NULL, NULL, 0, 0, 0, '2020-04-15 12:30:23', 1, '2020-04-15 12:30:28', 1);
INSERT INTO `ina_policy_payments` VALUES (72, 82, NULL, 1, 'Outstanding', 'Policy', NULL, '2020-04-16', -50.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2020-04-16 09:42:19', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (73, 18, NULL, 1, 'Applied', 'Policy', NULL, '2020-04-16', 100.00, NULL, 100.00, 24.89, NULL, NULL, 0, 0, 0, '2020-04-16 10:25:14', 1, '2020-04-16 10:25:51', 1);
INSERT INTO `ina_policy_payments` VALUES (76, 95, 96, 5, 'Active', 'Policy', 'Return', '2020-04-16', -200.00, 0.00, -200.00, -40.00, NULL, NULL, 0, 0, 0, NULL, NULL, '2020-04-16 11:29:55', 1);
INSERT INTO `ina_policy_payments` VALUES (77, 96, NULL, 5, 'Outstanding', 'Unallocated', NULL, '2020-04-16', 200.00, 0.00, 0.00, 0.00, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (78, 97, 97, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 140.50, NULL, 140.50, 25.00, NULL, NULL, 0, 0, 0, '2020-04-16 11:38:15', 1, '2020-04-16 11:38:36', 1);
INSERT INTO `ina_policy_payments` VALUES (79, 97, 98, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.33, NULL, NULL, 0, 0, 0, '2020-04-16 12:12:32', 1, '2020-04-16 12:22:28', 1);
INSERT INTO `ina_policy_payments` VALUES (83, 97, 98, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.33, NULL, NULL, 0, 0, 0, '2020-04-16 12:39:28', 1, '2020-04-16 12:40:12', 1);
INSERT INTO `ina_policy_payments` VALUES (85, 97, 98, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.34, NULL, NULL, 0, 0, 0, '2020-04-16 12:40:37', 1, '2020-04-16 12:43:08', 1);
INSERT INTO `ina_policy_payments` VALUES (86, 99, 99, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 140.50, NULL, 140.50, 25.00, NULL, NULL, 0, 0, 0, '2020-04-16 12:47:25', 1, '2020-04-16 12:47:50', 1);
INSERT INTO `ina_policy_payments` VALUES (87, 99, 100, 1, 'Applied', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.33, NULL, NULL, 0, 0, 0, '2020-04-16 12:50:06', 1, '2020-04-16 13:01:10', 1);
INSERT INTO `ina_policy_payments` VALUES (88, 101, 101, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 140.50, NULL, 140.50, 25.00, NULL, NULL, 0, 0, 0, '2020-04-16 13:28:41', 1, '2020-04-16 13:37:29', 1);
INSERT INTO `ina_policy_payments` VALUES (89, 102, 102, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 140.50, NULL, 140.50, 25.00, NULL, NULL, 0, 0, 0, '2020-04-16 13:39:12', 1, '2020-04-16 13:39:22', 1);
INSERT INTO `ina_policy_payments` VALUES (90, 102, 103, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.33, NULL, NULL, 0, 0, 0, '2020-04-16 13:41:09', 1, '2020-04-16 13:51:08', 1);
INSERT INTO `ina_policy_payments` VALUES (91, 102, 103, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.33, NULL, NULL, 0, 0, 0, '2020-04-16 13:54:44', 1, '2020-04-16 13:56:25', 1);
INSERT INTO `ina_policy_payments` VALUES (92, 102, 103, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 110.50, NULL, 110.50, 18.34, NULL, NULL, 0, 0, 0, '2020-04-16 13:57:46', 1, '2020-04-16 14:04:56', 1);
INSERT INTO `ina_policy_payments` VALUES (95, 102, 104, 1, 'Active', 'Policy', 'Return', '2020-04-16', -100.00, 0.00, -100.00, -25.00, NULL, NULL, 0, 0, 0, '2020-04-16 14:15:34', 1, '2020-04-16 14:15:34', 1);
INSERT INTO `ina_policy_payments` VALUES (96, 102, 104, 1, 'Outstanding', 'Unallocated', NULL, '2020-04-16', 100.00, 0.00, 0.00, 0.00, NULL, NULL, 0, 0, 0, '2020-04-16 14:15:34', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (97, 105, 105, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 140.50, NULL, 140.50, 25.00, NULL, NULL, 0, 0, 0, '2020-04-16 14:20:21', 1, '2020-04-16 14:20:28', 1);
INSERT INTO `ina_policy_payments` VALUES (98, 105, 105, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 421.50, NULL, 421.50, 75.00, NULL, NULL, 0, 0, 0, '2020-04-16 14:21:10', 1, '2020-04-16 14:21:20', 1);
INSERT INTO `ina_policy_payments` VALUES (99, 105, 106, 1, 'Active', 'Policy', 'Return', '2020-04-16', -100.00, 0.00, -100.00, -20.00, NULL, NULL, 1, 0, 0, '2020-04-16 14:22:43', 1, '2020-04-16 14:23:13', 1);
INSERT INTO `ina_policy_payments` VALUES (100, 105, 106, 1, 'Outstanding', 'Unallocated', NULL, '2020-04-16', 100.00, 0.00, 0.00, 0.00, NULL, NULL, 0, 0, 0, '2020-04-16 14:22:43', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (101, 107, 107, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 200.00, NULL, 200.00, 35.59, NULL, NULL, 0, 0, 0, '2020-04-16 14:24:54', 1, '2020-04-16 14:25:10', 1);
INSERT INTO `ina_policy_payments` VALUES (102, 107, 108, 1, 'Active', 'Policy', 'Payment', '2020-04-16', 272.00, NULL, 272.00, 44.41, NULL, NULL, 0, 0, 0, '2020-04-16 14:34:01', 1, '2020-04-16 14:34:07', 1);
INSERT INTO `ina_policy_payments` VALUES (103, 107, 109, 1, 'Active', 'Policy', 'Return', '2020-04-16', -100.00, 0.00, -100.00, -20.00, NULL, NULL, 1, 0, 0, '2020-04-16 14:35:04', 1, '2020-04-16 14:43:47', 1);
INSERT INTO `ina_policy_payments` VALUES (104, 107, 109, 1, 'Outstanding', 'Unallocated', NULL, '2020-04-16', 100.00, 0.00, 0.00, 0.00, NULL, NULL, 0, 0, 0, '2020-04-16 14:35:04', 1, NULL, NULL);
INSERT INTO `ina_policy_payments` VALUES (108, 111, NULL, 2, 'Prepayment', 'Policy', 'Payment', '2020-07-29', 99.99, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2020-07-29 11:47:03', 1, '2020-08-12 19:23:54', 1);
INSERT INTO `ina_policy_payments` VALUES (112, 111, NULL, 2, 'Outstanding', 'Policy', 'Payment', '2020-08-03', 25.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2020-08-03 18:09:10', 1, '2020-08-12 19:22:33', 1);

-- ----------------------------
-- Table structure for ina_policy_payments_lines
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments_lines`;
CREATE TABLE `ina_policy_payments_lines`  (
  `inappl_policy_payments_line_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inappl_policy_payment_ID` int(8) NULL DEFAULT NULL,
  `inappl_policy_installment_ID` int(8) NULL DEFAULT NULL,
  `inappl_previous_paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inappl_new_paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inappl_previous_commission_paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inappl_new_commission_paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `inappl_previous_paid_status` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inappl_new_paid_status` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inappl_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inappl_created_by` int(8) NULL DEFAULT NULL,
  `inappl_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inappl_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inappl_policy_payments_line_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 107 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_policy_payments_lines
-- ----------------------------
INSERT INTO `ina_policy_payments_lines` VALUES (1, 1, 5, 0.00, 92.34, 0.00, 16.68, 'UnPaid', 'Paid', '2019-06-26 12:18:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (2, 1, 6, 0.00, 57.66, 0.00, 10.40, 'UnPaid', 'Partial', '2019-06-26 12:18:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (3, 2, 8, 0.00, 92.34, 0.00, 16.68, 'UnPaid', 'Paid', '2019-06-28 14:00:46', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (4, 2, 9, 0.00, 57.66, 0.00, 10.40, 'UnPaid', 'Partial', '2019-06-28 14:00:46', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (5, 4, 10, 0.00, 27.00, 0.00, 22.92, 'UnPaid', 'Paid', '2019-06-28 16:24:21', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (10, 5, 31, 0.00, 92.34, 0.00, 16.68, 'UnPaid', 'Paid', '2019-07-02 16:38:07', 5, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (11, 5, 32, 0.00, 84.66, 0.00, 15.28, 'UnPaid', 'Partial', '2019-07-02 16:38:07', 5, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (12, 6, 34, 0.00, 70.68, 0.00, 17.54, 'UnPaid', 'Paid', '2019-07-03 11:22:43', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (13, 6, 35, 0.00, 29.32, 0.00, 7.27, 'UnPaid', 'Partial', '2019-07-03 11:22:43', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (14, 7, 35, 29.32, 70.66, 7.27, 17.53, 'Partial', 'Paid', '2019-07-04 11:16:58', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (15, 7, 36, 0.00, 70.66, 0.00, 17.53, 'UnPaid', 'Paid', '2019-07-04 11:16:58', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (16, 11, 52, 0.00, 35.44, 0.00, 10.00, 'UnPaid', 'Paid', '2019-07-11 12:25:34', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (17, 11, 53, 0.00, 14.56, 0.00, 4.11, 'UnPaid', 'Partial', '2019-07-11 12:25:34', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (26, 14, 57, 0.00, 92.34, 0.00, 16.68, 'UnPaid', 'Paid', '2019-07-11 12:36:27', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (27, 14, 58, 0.00, 57.66, 0.00, 10.40, 'UnPaid', 'Partial', '2019-07-11 12:36:27', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (28, 15, 58, 57.66, 92.33, 10.40, 16.66, 'Partial', 'Paid', '2019-07-11 12:36:48', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (29, 15, 59, 0.00, 65.33, 0.00, 11.79, 'UnPaid', 'Partial', '2019-07-11 12:36:48', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (30, 16, 60, 0.00, 147.34, 0.00, 36.68, 'UnPaid', 'Paid', '2019-07-18 23:46:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (31, 16, 61, 0.00, 102.66, 0.00, 25.54, 'UnPaid', 'Partial', '2019-07-18 23:46:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (32, 17, 63, 0.00, 88.50, 0.00, 25.00, 'UnPaid', 'Paid', '2019-07-19 00:05:28', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (33, 17, 64, 0.00, 88.50, 0.00, 25.00, 'UnPaid', 'Paid', '2019-07-19 00:05:28', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (34, 18, 68, 0.00, 98.50, 0.00, 12.50, 'UnPaid', 'Paid', '2019-07-22 19:23:55', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (35, 19, 27, 0.00, 73.00, 0.00, 18.75, 'UnPaid', 'Paid', '2019-07-23 14:26:28', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (36, 19, 28, 0.00, 19.00, 0.00, 4.88, 'UnPaid', 'Partial', '2019-07-23 14:26:28', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (37, 20, 69, 0.00, 98.50, 0.00, 12.50, 'UnPaid', 'Paid', '2019-08-07 15:52:33', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (38, 20, 70, 0.00, 98.50, 0.00, 12.50, 'UnPaid', 'Paid', '2019-08-07 15:52:33', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (39, 20, 71, 0.00, 3.00, 0.00, 0.38, 'UnPaid', 'Partial', '2019-08-07 15:52:33', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (40, 21, 71, 3.00, 98.50, 0.38, 12.50, 'Partial', 'Paid', '2019-08-07 15:52:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (41, 21, 72, 0.00, 98.50, 0.00, 12.50, 'UnPaid', 'Paid', '2019-08-07 15:52:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (42, 21, 73, 0.00, 56.00, 0.00, 7.11, 'UnPaid', 'Partial', '2019-08-07 15:52:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (43, 22, 87, 0.00, 150.00, 0.00, 18.30, 'UnPaid', 'Partial', '2019-08-12 20:33:49', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (44, 23, 87, 150.00, 300.68, 18.30, 36.68, 'Partial', 'Paid', '2019-08-12 20:34:27', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (45, 23, 88, 0.00, 49.32, 0.00, 6.01, 'UnPaid', 'Partial', '2019-08-12 20:34:27', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (46, 24, 93, 0.00, 80.00, 0.00, 8.11, 'UnPaid', 'Partial', '2019-10-15 10:31:45', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (47, 25, 93, 80.00, 109.00, 8.11, 11.05, 'Partial', 'Paid', '2019-10-15 10:32:21', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (48, 25, 94, 0.00, 51.00, 0.00, 5.16, 'UnPaid', 'Partial', '2019-10-15 10:32:21', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (51, 26, 125, 0.00, 75.68, 0.00, 7.34, 'UnPaid', 'Paid', '2019-11-20 15:17:19', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (52, 26, 126, 0.00, 24.32, 0.00, 2.36, 'UnPaid', 'Partial', '2019-11-20 15:17:19', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (53, 27, 126, 24.32, 74.32, 2.36, 7.20, 'Partial', 'Partial', '2019-11-20 15:18:16', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (54, 28, 126, 74.32, 75.66, 7.20, 7.33, 'Partial', 'Paid', '2019-11-20 17:38:24', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (55, 28, 127, 0.00, 75.66, 0.00, 7.33, 'UnPaid', 'Paid', '2019-11-20 17:38:24', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (60, 29, 125, 0.00, 75.68, 0.00, 7.34, 'UnPaid', 'Paid', '2019-11-22 18:41:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (61, 29, 126, 0.00, 24.32, 0.00, 2.36, 'UnPaid', 'Partial', '2019-11-22 18:41:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (62, 30, 17, 0.00, 50.35, 0.00, 12.50, 'UnPaid', 'Paid', '2019-11-23 11:44:38', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (63, 30, 18, 0.00, 50.33, 0.00, 12.50, 'UnPaid', 'Paid', '2019-11-23 11:44:38', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (64, 30, 19, 0.00, 9.32, 0.00, 2.31, 'UnPaid', 'Partial', '2019-11-23 11:44:38', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (65, 31, 140, 0.00, 300.00, 0.00, 51.96, 'UnPaid', 'Partial', '2019-11-23 17:20:03', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (66, 32, 140, 300.00, 415.68, 51.96, 72.00, 'Partial', 'Paid', '2019-11-23 17:20:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (67, 32, 141, 0.00, 184.32, 0.00, 31.93, 'UnPaid', 'Partial', '2019-11-23 17:20:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (68, 33, 205, 0.00, 138.00, 0.00, 22.50, 'UnPaid', 'Paid', '2020-03-16 11:31:51', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (69, 34, 209, 0.00, 140.50, 0.00, 22.50, 'UnPaid', 'Paid', '2020-03-16 11:53:15', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (71, 36, 210, 0.00, 140.50, 0.00, 22.50, 'UnPaid', 'Paid', '2020-03-16 12:42:04', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (72, 37, 211, 0.00, 51.00, 0.00, 8.17, 'UnPaid', 'Partial', '2020-03-16 12:52:14', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (73, 38, 211, 51.00, 71.00, 8.17, 11.37, 'Partial', 'Partial', '2020-03-23 11:13:20', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (74, 39, 230, 0.00, 253.00, 0.00, 50.00, 'UnPaid', 'Paid', '2020-03-27 12:08:57', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (75, 40, 231, 0.00, 319.66, 0.00, 63.33, 'UnPaid', 'Paid', '2020-03-27 12:11:11', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (76, 41, 243, 0.00, 140.50, 0.00, 27.50, 'UnPaid', 'Paid', '2020-04-01 11:38:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (77, 41, 244, 0.00, 140.50, 0.00, 27.50, 'UnPaid', 'Paid', '2020-04-01 11:38:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (78, 41, 245, 0.00, 140.50, 0.00, 27.50, 'UnPaid', 'Paid', '2020-04-01 11:38:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (79, 41, 246, 0.00, 40.50, 0.00, 7.93, 'UnPaid', 'Partial', '2020-04-01 11:38:35', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (80, 43, 251, 0.00, 562.00, 0.00, 100.00, 'UnPaid', 'Paid', '2020-04-11 14:06:50', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (81, 44, 257, 0.00, 110.66, 0.00, 18.00, 'UnPaid', 'Paid', '2020-04-12 12:05:24', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (82, 44, 258, 0.00, 110.65, 0.00, 17.99, 'UnPaid', 'Paid', '2020-04-12 12:05:24', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (83, 44, 259, 0.00, 110.69, 0.00, 18.01, 'UnPaid', 'Paid', '2020-04-12 12:05:24', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (84, 45, 260, 0.00, 237.34, 0.00, 43.34, 'UnPaid', 'Paid', '2020-04-12 12:23:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (85, 46, 261, 0.00, 237.33, 0.00, 43.33, 'UnPaid', 'Paid', '2020-04-12 12:57:00', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (86, 46, 262, 0.00, 237.33, 0.00, 43.33, 'UnPaid', 'Paid', '2020-04-12 12:57:00', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (87, 47, 263, 0.00, 262.00, 0.00, 40.00, 'UnPaid', 'Paid', '2020-04-15 12:30:25', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (88, 73, 61, 102.66, 147.33, 25.54, 36.66, 'Partial', 'Paid', '2020-04-16 10:25:51', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (89, 73, 62, 0.00, 55.33, 0.00, 13.77, 'UnPaid', 'Partial', '2020-04-16 10:25:51', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (90, 78, 290, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 11:38:18', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (91, 79, 291, 0.00, 110.50, 0.00, 18.33, 'UnPaid', 'Paid', '2020-04-16 12:22:19', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (92, 83, 292, 0.00, 110.50, 0.00, 18.33, 'UnPaid', 'Paid', '2020-04-16 12:39:32', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (93, 85, 293, 0.00, 110.50, 0.00, 18.34, 'UnPaid', 'Paid', '2020-04-16 12:43:02', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (94, 86, 294, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 12:47:39', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (95, 87, 295, 0.00, 110.50, 0.00, 18.33, 'UnPaid', 'Paid', '2020-04-16 12:50:08', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (96, 88, 298, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 13:28:46', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (97, 89, 302, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 13:39:14', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (98, 90, 303, 0.00, 110.50, 0.00, 18.33, 'UnPaid', 'Paid', '2020-04-16 13:41:11', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (99, 91, 304, 0.00, 110.50, 0.00, 18.33, 'UnPaid', 'Paid', '2020-04-16 13:54:46', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (100, 92, 305, 0.00, 110.50, 0.00, 18.34, 'UnPaid', 'Paid', '2020-04-16 13:57:49', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (101, 97, 309, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 14:20:26', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (102, 98, 310, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 14:21:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (103, 98, 311, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 14:21:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (104, 98, 312, 0.00, 140.50, 0.00, 25.00, 'UnPaid', 'Paid', '2020-04-16 14:21:17', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (105, 101, 314, 0.00, 200.00, 0.00, 35.59, 'UnPaid', 'Partial', '2020-04-16 14:24:56', 1, NULL, NULL);
INSERT INTO `ina_policy_payments_lines` VALUES (106, 102, 314, 200.00, 472.00, 35.59, 80.00, 'Partial', 'Paid', '2020-04-16 14:34:05', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_policy_types
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_types`;
CREATE TABLE `ina_policy_types`  (
  `inapot_policy_type_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapot_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapot_status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapot_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapot_description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapot_input_data_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inapot_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inapot_created_by` int(8) NULL DEFAULT NULL,
  `inapot_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inapot_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inapot_policy_type_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_policy_types
-- ----------------------------
INSERT INTO `ina_policy_types` VALUES (1, 'Motor', 'Active', 'Motor', 'Motor', 'Vehicles', '2019-02-16 11:13:35', 1, '2019-02-16 11:13:35', 1);
INSERT INTO `ina_policy_types` VALUES (2, 'Fire', 'Active', 'Fire', 'Fire', 'RiskLocation', '2019-02-11 00:58:23', 1, NULL, NULL);
INSERT INTO `ina_policy_types` VALUES (3, 'EL', 'Active', 'Employers Liability', 'Employers Liability', 'Member', '2019-02-16 10:59:12', 1, NULL, NULL);
INSERT INTO `ina_policy_types` VALUES (4, 'PL', 'Active', 'Public Liability', 'Public Liability', 'Member', '2019-02-16 10:59:26', 1, NULL, NULL);
INSERT INTO `ina_policy_types` VALUES (5, 'PA', 'Active', 'Personal Accident', 'Personal Accident', 'Member', '2019-02-16 10:59:42', 1, NULL, NULL);
INSERT INTO `ina_policy_types` VALUES (6, 'CAR', 'Active', 'Contructors All Risk', 'Contructors All Risk', 'RiskLocation', '2019-02-16 11:00:20', 1, NULL, NULL);
INSERT INTO `ina_policy_types` VALUES (7, 'Medical', 'Active', 'Medical', 'Medical', 'Member', '2019-02-16 11:00:33', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_review_batch
-- ----------------------------
DROP TABLE IF EXISTS `ina_review_batch`;
CREATE TABLE `ina_review_batch`  (
  `inarev_review_batch_ID` int(10) NOT NULL AUTO_INCREMENT,
  `inarev_batch_ID` int(10) NULL DEFAULT NULL,
  `inarev_policy_ID` int(10) NULL DEFAULT NULL,
  `inarev_user_ID` int(8) NULL DEFAULT NULL,
  `inarev_batch_date_time` datetime(0) NULL DEFAULT NULL,
  `inarev_result` int(1) NULL DEFAULT NULL,
  `inarev_result_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inarev_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inarev_created_by` int(8) NULL DEFAULT NULL,
  `inarev_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inarev_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inarev_review_batch_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_review_batch
-- ----------------------------
INSERT INTO `ina_review_batch` VALUES (1, 1, 6, 1, '2019-07-19 02:42:11', 1, 'Policy Reviewed Successfully', '2019-07-19 02:42:11', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (2, 1, 12, 1, '2019-07-19 02:42:11', 1, 'Policy Reviewed Successfully', '2019-07-19 02:42:11', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (3, 1, 14, 1, '2019-07-19 02:42:11', 1, 'Installments are not divided or recursive', '2019-07-19 02:42:11', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (4, 1, 17, 1, '2019-07-19 02:42:12', 1, 'Policy Reviewed Successfully', '2019-07-19 02:42:12', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (5, 1, 18, 1, '2019-07-19 02:42:12', 1, 'Policy Reviewed Successfully', '2019-07-19 02:42:12', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (6, 2, 14, 1, '2019-07-19 02:48:49', 0, 'Installments are not divided or recursive', '2019-07-19 02:48:49', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (7, 3, 14, 1, '2019-07-19 02:49:30', 0, 'Installments are not divided or recursive', '2019-07-19 02:49:30', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (8, 4, 14, 1, '2019-07-19 02:58:48', 1, 'Policy Reviewed Successfully', '2019-07-19 02:58:48', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (9, 5, 6, 1, '2019-07-19 03:22:19', 1, 'Policy Reviewed Successfully', '2019-07-19 03:22:19', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (10, 5, 12, 1, '2019-07-19 03:22:19', 1, 'Policy Reviewed Successfully', '2019-07-19 03:22:19', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (11, 5, 14, 1, '2019-07-19 03:22:19', 1, 'Policy Reviewed Successfully', '2019-07-19 03:22:20', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (12, 5, 17, 1, '2019-07-19 03:22:20', 1, 'Policy Reviewed Successfully', '2019-07-19 03:22:20', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (13, 5, 18, 1, '2019-07-19 03:22:20', 1, 'Policy Reviewed Successfully', '2019-07-19 03:22:20', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (14, 6, 7, 1, '2019-07-19 03:41:36', 1, 'Policy Reviewed Successfully', '2019-07-19 03:41:36', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (15, 7, 6, 1, '2019-07-19 13:52:09', 1, 'Policy Reviewed Successfully', '2019-07-19 13:52:09', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (16, 7, 7, 1, '2019-07-19 13:52:11', 1, 'Policy Reviewed Successfully', '2019-07-19 13:52:11', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (17, 7, 12, 1, '2019-07-19 13:52:12', 1, 'Policy Reviewed Successfully', '2019-07-19 13:52:12', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (18, 7, 14, 1, '2019-07-19 13:52:14', 1, 'Policy Reviewed Successfully', '2019-07-19 13:52:14', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (19, 7, 17, 1, '2019-07-19 13:52:16', 1, 'Policy Reviewed Successfully', '2019-07-19 13:52:16', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (20, 7, 18, 1, '2019-07-19 13:52:17', 1, 'Policy Reviewed Successfully', '2019-07-19 13:52:17', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (21, 8, 12, 1, '2020-03-29 11:52:35', 0, 'undefined', '2020-03-29 11:52:35', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (22, 8, 18, 1, '2020-03-29 11:52:36', 0, 'undefined', '2020-03-29 11:52:36', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (23, 9, 12, 1, '2020-03-29 12:01:57', 1, 'Policy Reviewed Successfully', '2020-03-29 12:01:57', 1, NULL, NULL);
INSERT INTO `ina_review_batch` VALUES (24, 9, 18, 1, '2020-03-29 12:01:58', 1, 'Policy Reviewed Successfully', '2020-03-29 12:01:58', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_settings
-- ----------------------------
DROP TABLE IF EXISTS `ina_settings`;
CREATE TABLE `ina_settings`  (
  `inaset_setting_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaset_enable_acc_transactions` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaset_ins_comp_dr_control_account_ID` int(8) NULL DEFAULT NULL,
  `inaset_ins_comp_cr_control_account_ID` int(8) NULL DEFAULT NULL,
  `inaset_ins_comm_ac_document_ID` int(8) NULL DEFAULT NULL,
  `inaset_auto_create_entity_from_client` int(1) NULL DEFAULT NULL,
  `inaset_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaset_created_by` int(8) NULL DEFAULT NULL,
  `inaset_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaset_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaset_setting_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_settings
-- ----------------------------
INSERT INTO `ina_settings` VALUES (1, '1', 43, 44, 3, 1, '2019-08-23 13:04:27', 1, '2019-11-06 15:32:02', 1);

-- ----------------------------
-- Table structure for ina_underwriter_companies
-- ----------------------------
DROP TABLE IF EXISTS `ina_underwriter_companies`;
CREATE TABLE `ina_underwriter_companies`  (
  `inaunc_underwriter_company_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaunc_underwriter_ID` int(8) NULL DEFAULT NULL,
  `inaunc_insurance_company_ID` int(8) NULL DEFAULT NULL,
  `inaunc_status` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaunc_commission_calculation` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaunc_commission_motor_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_motor_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_fire_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_fire_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_pa_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_pa_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_el_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_el_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_pi_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_pi_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_pl_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_pl_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_medical_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_medical_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_travel_new` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_commission_travel_renewal` decimal(10, 2) NULL DEFAULT NULL,
  `inaunc_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaunc_created_by` int(8) NULL DEFAULT NULL,
  `inaunc_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaunc_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaunc_underwriter_company_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 151 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_underwriter_companies
-- ----------------------------
INSERT INTO `ina_underwriter_companies` VALUES (1, 1, 1, 'Active', 'commNetPremFees', 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, NULL, NULL, '2019-11-19 16:38:24', 1);
INSERT INTO `ina_underwriter_companies` VALUES (2, 1, 3, 'Active', NULL, 30.00, NULL, 29.00, NULL, 28.00, NULL, 27.00, NULL, 26.00, NULL, 25.00, NULL, 24.00, NULL, NULL, NULL, NULL, NULL, '2019-07-29 11:30:02', 1);
INSERT INTO `ina_underwriter_companies` VALUES (3, 1, 4, 'Active', NULL, 25.00, NULL, 24.00, NULL, 23.00, NULL, 22.00, NULL, 21.00, NULL, 20.00, NULL, 19.00, NULL, NULL, NULL, NULL, NULL, '2019-07-29 11:31:24', 1);
INSERT INTO `ina_underwriter_companies` VALUES (4, 1, 25, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (5, 1, 5, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (6, 1, 6, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (7, 1, 7, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (8, 1, 8, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (9, 1, 9, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (10, 1, 10, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (11, 1, 11, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (12, 1, 12, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (13, 1, 13, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (14, 1, 14, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (15, 1, 15, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (16, 1, 16, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (17, 1, 17, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (18, 1, 18, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (19, 1, 19, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (20, 1, 20, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (21, 1, 21, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (22, 1, 22, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (23, 1, 23, 'Active', 'commNetPrem', 20.00, NULL, 19.00, NULL, 18.00, NULL, 17.00, NULL, 16.00, NULL, 15.00, NULL, 14.00, NULL, 10.00, NULL, NULL, NULL, '2019-08-23 14:53:04', 1);
INSERT INTO `ina_underwriter_companies` VALUES (24, 1, 24, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (25, 2, 1, 'Active', 'commNetPrem', 10.00, NULL, 11.00, NULL, 12.00, NULL, 13.00, NULL, 14.00, NULL, 15.00, NULL, 16.00, NULL, 17.00, NULL, NULL, NULL, '2019-11-06 14:04:15', 1);
INSERT INTO `ina_underwriter_companies` VALUES (26, 2, 3, 'Active', 'commNetPrem', 24.00, NULL, 29.00, NULL, 21.00, NULL, 21.00, NULL, 21.00, NULL, 21.00, NULL, 17.00, NULL, 24.00, NULL, NULL, NULL, '2019-11-06 14:04:26', 1);
INSERT INTO `ina_underwriter_companies` VALUES (27, 2, 4, 'Active', 'commNetPrem', 19.00, NULL, 18.00, NULL, 17.00, NULL, 16.00, NULL, 15.00, NULL, 14.00, NULL, 13.00, NULL, 12.00, NULL, NULL, NULL, '2019-11-06 14:05:53', 1);
INSERT INTO `ina_underwriter_companies` VALUES (28, 2, 25, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (29, 2, 5, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (30, 2, 6, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (31, 2, 7, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (32, 2, 8, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (33, 2, 9, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (34, 2, 10, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (35, 2, 11, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (36, 2, 12, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (37, 2, 13, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (38, 2, 14, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (39, 2, 15, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (40, 2, 16, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (41, 2, 17, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (42, 2, 18, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (43, 2, 19, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (44, 2, 20, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (45, 2, 21, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (46, 2, 22, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (47, 2, 23, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (48, 2, 24, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (49, 4, 1, 'Active', 'commNetPrem', 9.00, NULL, 10.00, NULL, 11.00, NULL, 12.00, NULL, 13.00, NULL, 14.00, NULL, 15.00, NULL, 16.00, NULL, NULL, NULL, '2019-11-06 14:24:23', 1);
INSERT INTO `ina_underwriter_companies` VALUES (50, 4, 3, 'Active', 'commNetPrem', 23.00, NULL, 28.00, NULL, 20.00, NULL, 20.00, NULL, 20.00, NULL, 20.00, NULL, 16.00, NULL, 23.00, NULL, NULL, NULL, '2019-11-06 14:24:31', 1);
INSERT INTO `ina_underwriter_companies` VALUES (51, 4, 4, 'Active', 'commNetPrem', 18.00, NULL, 17.00, NULL, 16.00, NULL, 15.00, NULL, 14.00, NULL, 13.00, NULL, 12.00, NULL, 11.00, NULL, NULL, NULL, '2019-11-06 14:24:38', 1);
INSERT INTO `ina_underwriter_companies` VALUES (52, 4, 25, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (53, 4, 5, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (54, 4, 6, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (55, 4, 7, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (56, 4, 8, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (57, 4, 9, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (58, 4, 10, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (59, 4, 11, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (60, 4, 12, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (61, 4, 13, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (62, 4, 14, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (63, 4, 15, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (64, 4, 16, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (65, 4, 17, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (66, 4, 18, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (67, 4, 19, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (68, 4, 20, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (69, 4, 21, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (70, 4, 22, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (71, 4, 23, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (72, 4, 24, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (73, 5, 1, 'Active', 'commNetPrem', 8.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, 4.00, NULL, '2019-06-21 11:46:59', 1, '2019-11-16 20:20:49', 1);
INSERT INTO `ina_underwriter_companies` VALUES (74, 5, 3, 'Active', 'commNetPrem', 22.00, NULL, 27.00, NULL, 19.00, NULL, 19.00, NULL, 19.00, NULL, 19.00, NULL, 15.00, NULL, 22.00, NULL, '2019-06-21 11:46:59', 1, '2019-11-06 14:25:07', 1);
INSERT INTO `ina_underwriter_companies` VALUES (75, 5, 4, 'Active', 'commNetPrem', 17.00, NULL, 16.00, NULL, 15.00, NULL, 14.00, NULL, 13.00, NULL, 12.00, NULL, 11.00, NULL, 10.00, NULL, '2019-06-21 11:46:59', 1, '2019-11-06 14:25:14', 1);
INSERT INTO `ina_underwriter_companies` VALUES (76, 5, 25, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (77, 5, 5, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (78, 5, 6, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (79, 5, 7, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (80, 5, 8, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (81, 5, 9, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (82, 5, 10, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (83, 5, 11, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (84, 5, 12, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (85, 5, 13, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (86, 5, 14, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (87, 5, 15, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (88, 5, 16, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (89, 5, 17, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (90, 5, 18, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (91, 5, 19, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (92, 5, 20, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (93, 5, 21, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (94, 5, 22, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (95, 5, 23, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (96, 5, 24, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-21 11:46:59', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (97, 6, 1, 'Active', 'commNetPrem', 8.00, NULL, 8.00, NULL, 8.00, NULL, 8.00, NULL, 8.00, NULL, 8.00, NULL, 8.00, NULL, 8.00, NULL, '2019-07-02 15:45:05', 1, '2019-11-19 16:37:25', 1);
INSERT INTO `ina_underwriter_companies` VALUES (98, 6, 3, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (99, 6, 4, 'Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (100, 6, 25, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (101, 6, 5, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (102, 6, 6, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (103, 6, 7, 'Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (104, 6, 8, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (105, 6, 9, 'Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (106, 6, 10, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (107, 6, 11, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (108, 6, 12, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (109, 6, 13, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (110, 6, 14, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (111, 6, 15, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (112, 6, 16, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (113, 6, 17, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (114, 6, 18, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (115, 6, 19, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (116, 6, 20, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (117, 6, 21, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (118, 6, 22, 'Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (119, 6, 23, 'Active', 'commNetPrem', 15.00, NULL, 15.00, NULL, 15.00, NULL, 15.00, NULL, 15.00, NULL, 15.00, NULL, 15.00, NULL, 15.00, NULL, '2019-07-02 15:45:05', 1, '2019-12-02 09:59:23', 1);
INSERT INTO `ina_underwriter_companies` VALUES (120, 6, 24, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-02 15:45:05', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (121, 1, 26, 'Active', 'commNetPrem', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 6.00, NULL, 0.00, NULL, '2019-11-23 11:27:45', 1, '2019-11-23 11:31:44', 1);
INSERT INTO `ina_underwriter_companies` VALUES (122, 6, 26, 'Active', 'commNetPrem', 10.00, 9.00, 9.00, 8.00, 10.00, 9.00, 9.00, 8.00, 10.00, 9.00, 9.00, 8.00, 10.00, 9.00, 9.00, 8.00, '2019-11-23 11:30:47', 1, '2020-04-13 10:02:10', 1);
INSERT INTO `ina_underwriter_companies` VALUES (123, 5, 26, 'Active', 'commNetPrem', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 4.00, 0.00, 0.00, '2019-12-02 10:29:47', 1, '2020-04-13 10:43:32', 1);
INSERT INTO `ina_underwriter_companies` VALUES (124, 2, 26, 'Active', 'commNetPrem', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15.00, 14.00, 0.00, 0.00, '2019-12-02 10:45:05', 1, '2020-04-13 10:43:02', 1);
INSERT INTO `ina_underwriter_companies` VALUES (125, 4, 26, 'Active', 'commNetPrem', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 10.00, 9.00, 0.00, 0.00, '2019-12-02 10:45:37', 1, '2020-04-13 10:43:18', 1);
INSERT INTO `ina_underwriter_companies` VALUES (126, 7, 1, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (127, 7, 3, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (128, 7, 25, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (129, 7, 4, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (130, 7, 5, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (131, 7, 6, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (132, 7, 7, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (133, 7, 26, 'Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (134, 7, 8, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (135, 7, 9, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (136, 7, 10, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (137, 7, 11, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (138, 7, 12, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (139, 7, 13, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (140, 7, 14, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (141, 7, 15, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (142, 7, 16, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (143, 7, 17, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:57', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (144, 7, 18, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (145, 7, 19, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (146, 7, 20, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (147, 7, 21, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (148, 7, 22, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (149, 7, 23, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);
INSERT INTO `ina_underwriter_companies` VALUES (150, 7, 24, 'Inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-20 16:33:58', 1, NULL, NULL);

-- ----------------------------
-- Table structure for ina_underwriters
-- ----------------------------
DROP TABLE IF EXISTS `ina_underwriters`;
CREATE TABLE `ina_underwriters`  (
  `inaund_underwriter_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inaund_user_ID` int(8) NULL DEFAULT NULL,
  `inaund_status` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaund_vertical_level` int(2) NULL DEFAULT 0,
  `inaund_subagent` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `inaund_subagent_ID` int(8) NULL DEFAULT 0,
  `inaund_subagent_dr_account_ID` int(8) NULL DEFAULT NULL,
  `inaund_subagent_cr_account_ID` int(8) NULL DEFAULT NULL,
  `inaund_use_motor` int(1) NULL DEFAULT NULL,
  `inaund_use_fire` int(1) NULL DEFAULT NULL,
  `inaund_use_pa` int(1) NULL DEFAULT NULL,
  `inaund_use_el` int(1) NULL DEFAULT NULL,
  `inaund_use_pi` int(1) NULL DEFAULT NULL,
  `inaund_use_pl` int(1) NULL DEFAULT NULL,
  `inaund_use_medical` int(1) NULL DEFAULT NULL,
  `inaund_use_travel` int(1) NULL DEFAULT NULL,
  `inaund_created_date_time` datetime(0) NULL DEFAULT NULL,
  `inaund_created_by` int(8) NULL DEFAULT NULL,
  `inaund_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `inaund_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`inaund_underwriter_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ina_underwriters
-- ----------------------------
INSERT INTO `ina_underwriters` VALUES (1, 1, 'Active', 0, '3', 6, 27, 62, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, '2019-12-02 10:41:02', 1);
INSERT INTO `ina_underwriters` VALUES (2, 2, 'Active', 0, '1', -1, 70, 72, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, '2020-03-16 10:38:44', 1);
INSERT INTO `ina_underwriters` VALUES (4, 3, 'Active', 0, '2', 2, 71, 73, 1, 1, 1, 1, 1, 1, 1, 0, NULL, NULL, '2020-03-16 10:38:58', 1);
INSERT INTO `ina_underwriters` VALUES (5, 4, 'Active', 2, '3', 4, 59, 60, 1, 1, 1, 1, 1, 1, 1, 0, '2019-06-21 11:46:59', 1, '2019-12-04 17:08:06', 1);
INSERT INTO `ina_underwriters` VALUES (6, 5, 'Active', 1, '0', -1, 21, 63, 1, 1, 1, 1, 1, 1, 1, 0, '2019-07-02 15:45:05', 1, '2019-12-02 10:44:34', 1);
INSERT INTO `ina_underwriters` VALUES (7, 6, 'Active', 0, '0', 0, 14, 14, 0, 0, 0, 0, 0, 0, 1, 0, '2020-03-20 16:33:57', 1, '2020-03-20 17:14:30', 1);

-- ----------------------------
-- Table structure for ip_locations
-- ----------------------------
DROP TABLE IF EXISTS `ip_locations`;
CREATE TABLE `ip_locations`  (
  `ipl_ip_location_serial` int(10) NOT NULL AUTO_INCREMENT,
  `ipl_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_hostname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_region` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_country` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_location` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_provider` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ipl_last_check` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`ipl_ip_location_serial`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ip_locations
-- ----------------------------
INSERT INTO `ip_locations` VALUES (1, '::1', '', '', '', '', '', '', '2020-08-02 13:52:57');
INSERT INTO `ip_locations` VALUES (2, '127.0.0.1', '', '', '', '', '', '', '2020-07-13 12:48:53');


-- ----------------------------
-- Table structure for log_file
-- ----------------------------
DROP TABLE IF EXISTS `log_file`;
CREATE TABLE `log_file`  (
  `lgf_log_file_ID` int(10) NOT NULL AUTO_INCREMENT,
  `lgf_user_ID` int(10) NULL DEFAULT NULL,
  `lgf_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lgf_date_time` datetime(0) NULL DEFAULT NULL,
  `lgf_table_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lgf_row_serial` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lgf_action` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `lgf_new_values` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `lgf_old_values` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `lgf_description` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  PRIMARY KEY (`lgf_log_file_ID`) USING BTREE,
  INDEX `lgf_user_ID`(`lgf_user_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compressed;

-- ----------------------------
-- Table structure for parameters
-- ----------------------------
DROP TABLE IF EXISTS `parameters`;
CREATE TABLE `parameters`  (
  `prm_parametrs_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prm_agreements_last_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`prm_parametrs_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parameters
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `prm_permissions_ID` int(8) NOT NULL AUTO_INCREMENT,
  `prm_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_filename` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_type` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_parent` int(11) NULL DEFAULT NULL,
  `prm_restricted` int(1) NULL DEFAULT NULL,
  `prm_view` int(1) NULL DEFAULT 0,
  `prm_insert` int(1) NULL DEFAULT 0,
  `prm_update` int(1) NULL DEFAULT 0,
  `prm_delete` int(1) NULL DEFAULT 0,
  `prm_extra_1` int(1) NULL DEFAULT 0,
  `prm_extra_2` int(1) NULL DEFAULT 0,
  `prm_extra_3` int(1) NULL DEFAULT 0,
  `prm_extra_4` int(1) NULL DEFAULT 0,
  `prm_extra_5` int(1) NULL DEFAULT 0,
  `prm_extra_name_1` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_extra_name_2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_extra_name_3` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_extra_name_4` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `prm_extra_name_5` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`prm_permissions_ID`) USING BTREE,
  UNIQUE INDEX `primary_serial`(`prm_permissions_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'Users', 'users/users.php', 'menu', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (2, 'Users Folder', 'users', 'folder', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (3, 'Permissions', 'users/permissions.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (4, 'Permissions Modify', 'users/permissions_modify.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (5, 'Permissions Delete', 'users/permissions_delete.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (6, 'Groups', 'users/groups.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (7, 'Groups Modify', 'users/groups_modify.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (8, 'Groups Delete', 'users/groups_delete.php', 'file', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '');
INSERT INTO `permissions` VALUES (9, 'Agreements', 'agreements', 'folder', 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 'StatusChange', '', '', '', '');

-- ----------------------------
-- Table structure for permissions_lines
-- ----------------------------
DROP TABLE IF EXISTS `permissions_lines`;
CREATE TABLE `permissions_lines`  (
  `prl_permissions_lines_ID` int(10) NOT NULL AUTO_INCREMENT,
  `prl_permissions_ID` int(10) NULL DEFAULT NULL,
  `prl_users_groups_ID` int(11) NULL DEFAULT NULL,
  `prl_view` int(1) NULL DEFAULT NULL,
  `prl_insert` int(1) NULL DEFAULT NULL,
  `prl_update` int(1) NULL DEFAULT NULL,
  `prl_delete` int(1) NULL DEFAULT NULL,
  `prl_extra_1` int(1) NULL DEFAULT NULL,
  `prl_extra_2` int(1) NULL DEFAULT NULL,
  `prl_extra_3` int(1) NULL DEFAULT NULL,
  `prl_extra_4` int(1) NULL DEFAULT NULL,
  `prl_extra_5` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`prl_permissions_lines_ID`) USING BTREE,
  UNIQUE INDEX `primary_serial`(`prl_permissions_lines_ID`) USING BTREE,
  INDEX `permissions_serial`(`prl_permissions_ID`) USING BTREE,
  INDEX `users_groups_serial`(`prl_users_groups_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions_lines
-- ----------------------------
INSERT INTO `permissions_lines` VALUES (1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (3, 2, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (4, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (5, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (6, 4, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (7, 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (8, 6, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (9, 7, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (10, 8, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (11, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (12, 4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (13, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (14, 6, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (15, 7, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (16, 8, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (17, 2, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (18, 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (19, 3, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (20, 4, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (21, 5, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (22, 6, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (23, 7, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (24, 8, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (25, 2, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (26, 1, 214, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (27, 9, 2, 1, 1, 1, 1, 1, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (28, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (29, 4, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (30, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (31, 6, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (32, 7, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (33, 8, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (34, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (35, 9, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (36, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (37, 9, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (38, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (39, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (40, 5, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (41, 6, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (42, 7, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (43, 8, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (44, 2, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (45, 9, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (46, 1, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (47, 3, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (48, 4, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (49, 5, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (50, 6, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (51, 7, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (52, 8, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (53, 2, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (54, 9, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `permissions_lines` VALUES (55, 1, 6854, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- ----------------------------
-- Table structure for process_lock
-- ----------------------------
DROP TABLE IF EXISTS `process_lock`;
CREATE TABLE `process_lock`  (
  `pl_process_lock_ID` int(8) NOT NULL AUTO_INCREMENT,
  `pl_description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pl_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pl_user_serial` int(8) NULL DEFAULT NULL,
  `pl_active` int(1) NULL DEFAULT NULL,
  `pl_start_timestamp` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `pl_end_timestamp` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`pl_process_lock_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of process_lock
-- ----------------------------


-- ----------------------------
-- Table structure for rcb_credit_card_payments
-- ----------------------------
DROP TABLE IF EXISTS `rcb_credit_card_payments`;
CREATE TABLE `rcb_credit_card_payments`  (
  `rcbcrp_credit_card_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `rcbcrp_credit_card_ID` int(8) NULL DEFAULT NULL,
  `rcbcrp_session_status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrp_status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrp_amount` decimal(10, 2) NULL DEFAULT NULL,
  `rcbcrp_transaction_date_time` datetime(0) NULL DEFAULT NULL,
  `rcbcrp_session` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrp_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrp_foreign_identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrp_payment_return_string` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `rcbcrp_created_date_time` datetime(0) NULL DEFAULT NULL,
  `rcbcrp_created_by` int(8) NULL DEFAULT NULL,
  `rcbcrp_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `rcbcrp_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`rcbcrp_credit_card_payment_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rcb_credit_card_payments
-- ----------------------------
INSERT INTO `rcb_credit_card_payments` VALUES (1, 7, 'Success', 'APPROVED', 3.76, '2020-04-24 01:05:53', '40F5CBCDCA4BB4974A154AC9F8E804C9', 'A test payment', '1101-001212', NULL, '2020-04-23 23:53:30', 1, '2020-04-24 01:05:54', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (4, 7, 'Outstanding', 'Outstanding', 5.75, NULL, NULL, 'Another test payment', '1101-001214', NULL, '2020-04-24 01:16:33', 1, NULL, NULL);
INSERT INTO `rcb_credit_card_payments` VALUES (5, 7, 'Success', 'APPROVED', 5.75, '2020-04-24 01:18:21', '18EF9047359583E3157DE0019BC5DE8A', 'Another test payment', '1101-001214', NULL, '2020-04-24 01:18:21', 1, '2020-04-24 01:18:22', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (6, 7, 'Success', 'APPROVED', 5.75, '2020-04-24 01:19:27', '9333AC46FC2B6B5C4520FC17543BB25E', 'Another test payment', '1101-001214', NULL, '2020-04-24 01:19:26', 1, '2020-04-24 01:19:28', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (7, 8, 'Success', 'DECLINED', 3.76, '2020-04-27 12:10:05', '29DA50B7D7FF54FFE267848E55D5ADDB', 'A test payment', '1101-001212', NULL, '2020-04-27 12:10:04', 1, '2020-04-27 12:10:06', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (8, 9, 'Success', 'DECLINED', 3.76, '2020-04-27 12:22:35', '80A14529AD5A784090E4E3F0DD1500F9', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:22:57\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138957\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:22:57\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:22:34', 1, '2020-04-27 12:22:36', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (9, 10, 'Success', 'DECLINED', 3.76, '2020-04-27 12:24:16', 'BA7518F8552AC8ED089207F5A89F285B', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:24:39\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138959\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:24:39\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:24:16', 1, '2020-04-27 12:24:17', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (10, 11, 'Success', 'DECLINED', 3.76, '2020-04-27 12:25:23', '0DAC5E64B8D5D2F60BD6FB35CD68D036', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:25:45\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138961\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:25:45\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:25:22', 1, '2020-04-27 12:25:24', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (11, 12, 'Success', 'DECLINED', 3.76, '2020-04-27 12:27:27', 'D34C8BFF2E5CCA410F43751EBCB5201D', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:27:49\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138962\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:27:49\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:27:26', 1, '2020-04-27 12:27:28', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (12, 13, 'Success', 'DECLINED', 3.76, '2020-04-27 12:34:30', '6CFAFA2AE10285739849499BAE772547', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:34:52\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138969\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:34:52\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:34:29', 1, '2020-04-27 12:34:31', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (13, 14, 'Success', 'DECLINED', 3.76, '2020-04-27 12:35:46', '1D2FBE1CC0B5691EFF10EF33091126C8', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:36:09\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138973\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:36:09\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:35:45', 1, '2020-04-27 12:35:47', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (14, 15, 'Success', 'DECLINED', 3.76, '2020-04-27 12:36:06', 'BC3F840FC9580AB27CDB5727D9A9E293', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:36:28\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138975\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:36:28\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:36:05', 1, '2020-04-27 12:36:07', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (15, 16, 'Success', 'DECLINED', 3.76, '2020-04-27 12:39:34', 'A463DAB3CDF08435B517473758FC411D', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:39:59\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138980\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:39:59\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:39:33', 1, '2020-04-27 12:39:37', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (16, 17, 'Success', 'DECLINED', 3.76, '2020-04-27 12:40:15', 'F0A177386039552B8F7F1ACB6E1FFB00', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010480\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:40:40\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138982\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:40:40\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:40:12', 1, '2020-04-27 12:40:18', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (17, 20, 'Success', '54', 3.76, '2020-04-27 12:43:40', '199CCE7082F62906FCD90DF46F1CE4E5', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [Response] => SimpleXMLElement Object\n        (\n            [Operation] => Purchase\n            [Status] => 54\n        )\n\n)\n', '2020-04-27 12:43:38', 1, '2020-04-27 12:43:41', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (18, 21, 'Success', 'DECLINED', 3.76, '2020-04-27 12:45:04', '9D495CEB813E2B96D9125F05FE88A77B', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 069\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010490\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:45:26\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138989\n                    [TransactionType] => Purchase\n                    [PAN] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:45:26\n                    [ResponseCode] => 069\n                    [Brand] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [OrderStatus] => DECLINED\n                    [ApprovalCode] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [ApprovalCodeScr] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => DECLINED\n                    [RezultOperation] => Transaction Result\n                )\n\n        )\n\n)\n', '2020-04-27 12:45:02', 1, '2020-04-27 12:45:05', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (19, 22, 'Success', 'APPROVED', 3.76, '2020-04-27 12:46:19', '93823A16D4F2220D65692F2DE9043CA5', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 000\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => F\n                            [value] => 212323 A\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#&R01#&r33294716#&p33294716#\n                        )\n\n                )\n\n            [3] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => g\n                            [value] => 184538695=2104\n                        )\n\n                )\n\n            [4] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010500\n                        )\n\n                )\n\n            [5] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => t\n                            [value] => 33294716\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:46:42\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138993\n                    [TransactionType] => Purchase\n                    [RRN] => 33294716\n                    [PAN] => 554037XXXXXX0931\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:46:42\n                    [ResponseCode] => 000\n                    [Brand] => MC\n                    [OrderStatus] => APPROVED\n                    [ApprovalCode] => 212323\n                    [ApprovalCodeScr] => 212323\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => APPROVED\n                    [RezultOperation] => Transaction Result\n                    [Response_g] => 184538695=2104\n                )\n\n        )\n\n)\n', '2020-04-27 12:46:18', 1, '2020-04-27 12:46:21', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (20, 23, 'Success', 'APPROVED', 3.76, '2020-04-27 12:48:37', '6E7D033F39A9B8C69CF5089110B77F03', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 000\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => F\n                            [value] => 212324 A\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#&R01#&r33294811#&p33294811#\n                        )\n\n                )\n\n            [3] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => g\n                            [value] => 184538695=2104\n                        )\n\n                )\n\n            [4] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010510\n                        )\n\n                )\n\n            [5] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => t\n                            [value] => 33294811\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 12:49:03\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 138995\n                    [TransactionType] => Purchase\n                    [RRN] => 33294811\n                    [PAN] => 554037XXXXXX0931\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 12:49:03\n                    [ResponseCode] => 000\n                    [Brand] => MC\n                    [OrderStatus] => APPROVED\n                    [ApprovalCode] => 212324\n                    [ApprovalCodeScr] => 212324\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => APPROVED\n                    [RezultOperation] => Transaction Result\n                    [Response_g] => 184538695=2104\n                )\n\n        )\n\n)\n', '2020-04-27 12:48:36', 1, '2020-04-27 12:48:41', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (21, 24, 'Success', 'APPROVED', 3.76, '2020-04-27 15:08:33', '12F60BCED963B4D516DE0F63B1F383E7', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 000\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => F\n                            [value] => 215325 A\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#&R01#&r33299660#&p33299660#\n                        )\n\n                )\n\n            [3] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => g\n                            [value] => 184538695=2104\n                        )\n\n                )\n\n            [4] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010520\n                        )\n\n                )\n\n            [5] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => t\n                            [value] => 33299660\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 15:08:58\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 139158\n                    [TransactionType] => Purchase\n                    [RRN] => 33299660\n                    [PAN] => 554037XXXXXX0931\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 15:08:58\n                    [ResponseCode] => 000\n                    [Brand] => MC\n                    [OrderStatus] => APPROVED\n                    [ApprovalCode] => 215325\n                    [ApprovalCodeScr] => 215325\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => APPROVED\n                    [RezultOperation] => Transaction Result\n                    [Response_g] => 184538695=2104\n                )\n\n        )\n\n)\n', '2020-04-27 15:08:33', 1, '2020-04-27 15:08:36', 1);
INSERT INTO `rcb_credit_card_payments` VALUES (22, 25, 'Success', 'APPROVED', 3.76, '2020-04-27 15:09:01', '6E3E1CC7E90C4988EFD10599E6530CE8', 'A test payment', '1101-001212', 'SimpleXMLElement Object\n(\n    [l] => SimpleXMLElement Object\n        (\n            [@attributes] => Array\n                (\n                    [name] => ResponseCode\n                    [value] => 000\n                )\n\n        )\n\n    [f] => Array\n        (\n            [0] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => F\n                            [value] => 215326 A\n                        )\n\n                )\n\n            [1] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => R\n                            [value] => D\n                        )\n\n                )\n\n            [2] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => a\n                            [value] => &C978#&R01#&r33299673#&p33299673#\n                        )\n\n                )\n\n            [3] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => g\n                            [value] => 184538695=2104\n                        )\n\n                )\n\n            [4] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => h\n                            [value] => 0010010530\n                        )\n\n                )\n\n            [5] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [name] => t\n                            [value] => 33299673\n                        )\n\n                )\n\n        )\n\n    [XMLOut] => SimpleXMLElement Object\n        (\n            [Message] => SimpleXMLElement Object\n                (\n                    [@attributes] => Array\n                        (\n                            [date] => 27/04/2020 15:09:25\n                        )\n\n                    [Version] => 1.0\n                    [OrderID] => 139159\n                    [TransactionType] => Purchase\n                    [RRN] => 33299673\n                    [PAN] => 554037XXXXXX0931\n                    [PurchaseAmount] => 376\n                    [PurchaseAmountScr] => 3.76\n                    [Currency] => 978\n                    [TranDateTime] => 27/04/2020 15:09:25\n                    [ResponseCode] => 000\n                    [Brand] => MC\n                    [OrderStatus] => APPROVED\n                    [ApprovalCode] => 215326\n                    [ApprovalCodeScr] => 215326\n                    [AcqFee] => 0\n                    [AcqFeeScr] => 0.00\n                    [OrderDescription] => Test1\n                    [CardHolderName] => SimpleXMLElement Object\n                        (\n                        )\n\n                    [CurrencyScr] => EUR\n                    [OrderStatusScr] => APPROVED\n                    [RezultOperation] => Transaction Result\n                    [Response_g] => 184538695=2104\n                )\n\n        )\n\n)\n', '2020-04-27 15:09:00', 1, '2020-04-27 15:09:03', 1);

-- ----------------------------
-- Table structure for rcb_credit_cards
-- ----------------------------
DROP TABLE IF EXISTS `rcb_credit_cards`;
CREATE TABLE `rcb_credit_cards`  (
  `rcbcrc_credit_card_ID` int(8) NOT NULL AUTO_INCREMENT,
  `rcbcrc_status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrc_token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrc_credit_card_number` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rcbcrc_expiry_year` int(4) NULL DEFAULT NULL,
  `rcbcrc_expiry_month` int(2) NULL DEFAULT NULL,
  `rcbcrc_ccv` int(6) NULL DEFAULT NULL,
  `rcbcrc_created_date_time` datetime(0) NULL DEFAULT NULL,
  `rcbcrc_created_by` int(8) NULL DEFAULT NULL,
  `rcbcrc_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `rcbcrc_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`rcbcrc_credit_card_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rcb_credit_cards
-- ----------------------------
INSERT INTO `rcb_credit_cards` VALUES (44, NULL, NULL, 'SmszakZ2SzRnS0ZicUxhKzZxT2hnUT09OjrseGIE4nh08JlopfC5Oont', 2020, 1, 123, '2020-05-06 14:45:56', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (45, NULL, NULL, 'ckFlMzQvRHJXOUtySXpYbU1zMUE5QT09OjrhYn_PckE7_8SCZtMVxK94', 2020, 1, 123, '2020-05-06 21:34:12', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (46, NULL, NULL, 'dU9WeTRHbzFMZTUrSmg3Q0ZqU0tBZz09Ojog5Oawk9I2MxEOrKl0d3bk', 2020, 1, 123, '2020-05-06 21:35:07', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (47, NULL, NULL, 'V21iZjVTanVSSTE5T3Y5TjRYNjd4QT09OjrPxF50FG6i9ytP-y44JESI', 2020, 1, 123, '2020-05-06 21:36:08', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (48, NULL, NULL, 'T1BJeEZSUUY0Qm5xR296WEgyVnZodz09OjqReEV0Rc5D5TxxrebhOp-l', 2020, 1, 123, '2020-05-06 21:37:05', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (49, NULL, NULL, 'bEI3STMyUjNJUVZUeEFrdFYzL2FWUT09OjoKvzXFPQr6MSyqNcWbFjR1', 2020, 1, 123, '2020-05-06 21:37:31', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (50, NULL, NULL, 'Q2p0cGpHY1p1VDNNbkhsVjU5WjIzdz09OjqXsEqVk9wExuu4UJsx-Qmz', 2020, 1, 123, '2020-05-06 21:38:15', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (51, NULL, NULL, 'UUJaZVhkQjZXZ2d1RlNvOVFZWHZmUT09Ojotivz9rip0ShxJBt7OPGFn', 2020, 1, 123, '2020-05-06 21:38:51', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (52, NULL, NULL, 'aS9meVRzVDdpNWZsYnVIR1JFVWF2QT09OjoP22qvLxRNn20qlHWDNaT5', 2020, 1, 123, '2020-05-06 21:39:31', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (53, NULL, NULL, 'dDVydFB5WTZ5VldCYnNsVDhIZmpJZz09OjpTWItZsuGGJPyGLnsxkoyL', 2020, 1, 123, '2020-05-06 21:40:03', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (54, NULL, NULL, 'RXhPNVBLNVRUNzV5bzRKM1JFbjRyQT09OjpyMfiltWDcq7KZpJAwRczB', 2020, 1, 123, '2020-05-06 21:41:14', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (55, NULL, NULL, 'NHkrRmV4VCt6dlNPQ01ndzFwUmVoUT09OjpzcrTkjyPqY1Jaj1TGw573', 2020, 1, 123, '2020-05-06 22:29:19', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (56, NULL, NULL, 'd2NuV1U0b1pCNVFZTGs4ZzhObDRKdz09Ojr6VxXhv8ZsprGJLSndaIjr', 2020, 1, 123, '2020-05-06 22:32:50', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (57, NULL, NULL, 'bC94MlgwUDRQMWFlMUw1OVg2Z0NWUT09Ojq8ALNGd7lDW4nqyETqMjYs', 2020, 1, 123, '2020-05-06 22:49:48', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (58, NULL, NULL, 'SUtuYmlMaTRSVHo2by9vM2xheE5JUT09Ojpqc0ZzFxZ9bVNEwqB_P-2H', 2020, 1, 123, '2020-05-06 23:11:45', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (59, NULL, NULL, 'TnFVc3FodkhDSVN4cUJONTMybjRydz09OjpPQ-k_gyIE2cZ9-kGDT4-X', 2020, 1, 123, '2020-05-06 23:13:48', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (60, NULL, NULL, 'RkhEbDZSV01waGJaWVo2dXhScnY2Zz09OjqbrjMZLs8Hlt75l5WQ_HxB', 2020, 1, 123, '2020-05-06 23:14:15', 7, NULL, NULL);
INSERT INTO `rcb_credit_cards` VALUES (61, NULL, NULL, 'T1E3MUhyZUlLOTY3K2VldGNsSGc0dz09OjredRzdFB2ffHZjk9JltIBB', 2020, 1, 123, '2020-05-06 23:42:50', 7, NULL, NULL);

-- ----------------------------
-- Table structure for rcb_payments
-- ----------------------------
DROP TABLE IF EXISTS `rcb_payments`;
CREATE TABLE `rcb_payments`  (
  `rcbp_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `rcbp_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rcbp_online_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rcbp_order_ID` int(20) NULL DEFAULT NULL,
  `rcbp_session_ID` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rcbp_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rcbp_payment_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`rcbp_payment_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rcb_payments
-- ----------------------------

-- ----------------------------
-- Table structure for rcb_token_list
-- ----------------------------
DROP TABLE IF EXISTS `rcb_token_list`;
CREATE TABLE `rcb_token_list`  (
  `rcbtl_token_list_ID` int(8) NOT NULL AUTO_INCREMENT,
  `rcbtl_token` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rcbtl_expiration` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rcbtl_card_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`rcbtl_token_list_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rcb_token_list
-- ----------------------------
INSERT INTO `rcb_token_list` VALUES (4, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (5, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (6, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (7, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (8, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (9, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (10, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (11, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (12, NULL, NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (13, '', NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (14, '', NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (15, '235578552=2104', NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (16, '235578552=2104', NULL, '554**********931');
INSERT INTO `rcb_token_list` VALUES (17, '235578552', '2104', '554**********931');
INSERT INTO `rcb_token_list` VALUES (18, '235578552', '2104', '554**********931');
INSERT INTO `rcb_token_list` VALUES (19, '184538695', '2104', '554**********931');

-- ----------------------------
-- Table structure for rcb_transactions
-- ----------------------------
DROP TABLE IF EXISTS `rcb_transactions`;
CREATE TABLE `rcb_transactions`  (
  `rcbtr_transaction_ID` int(8) NOT NULL AUTO_INCREMENT,
  `rcbtr_token_list_ID` int(8) NULL DEFAULT NULL,
  `rcbtr_transaction_date_time` datetime(0) NULL DEFAULT NULL,
  `rcbtr_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rcbtr_foreign_identifier` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rcbtr_amount` decimal(10, 2) NULL DEFAULT NULL,
  `rcbtr_session` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rcbtr_order_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rcbtr_payment_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`rcbtr_transaction_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rcb_transactions
-- ----------------------------
INSERT INTO `rcb_transactions` VALUES (3, 4, '2020-02-05 16:53:27', 'Test Payment', '1101-000001', 100.00, 'BDF26475872EB1D7CF0F8935F9B49B48', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (4, 5, '2020-02-05 16:55:05', 'Test Payment', '1101-000001', 100.00, 'C3389D17131E27F29749B1FFDF0A5FF3', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (5, 6, '2020-02-05 16:56:01', 'Test Payment', '1101-000001', 100.00, 'D65C00E205557DC29ADC1B52C2A3ACEC', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (6, 7, '2020-02-05 16:56:40', 'Test Payment', '1101-000001', 100.00, 'FD624232163D132F16D3C0D32B5E1906', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (7, 8, '2020-02-05 16:58:04', 'Test Payment', '1101-000001', 100.00, 'B8D702F35195A04E8303D3715364C8DB', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (8, 9, '2020-02-05 17:00:38', 'Test Payment', '1101-000001', 100.00, '03FF00054E9FFB9260487155F1EF070B', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (9, 10, '2020-02-05 17:01:03', 'Test Payment', '1101-000001', 100.00, '1DAB7A05711A6F639E1E4E2AC5458EDE', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (10, 11, '2020-02-05 17:02:35', 'Test Payment', '1101-000001', 100.00, '9B823D2A68FB30A31208073F5310E241', 'Success', '10');
INSERT INTO `rcb_transactions` VALUES (11, 12, '2020-02-06 12:07:10', 'Test Payment', '1101-000001', 100.00, 'E86E37E9506F4AACEBBCBDAAE359F289', 'Success', '10');
INSERT INTO `rcb_transactions` VALUES (12, 13, '2020-02-06 12:21:29', 'Test Payment', '1101-000001', 100.00, '101D49AADD79B1202C79491307DEF417', 'Success', 'DECLINED');
INSERT INTO `rcb_transactions` VALUES (13, 14, '2020-02-06 12:38:18', 'Test Payment', '1101-000001', 250.00, '5143203ED5E97F782552511C92084444', 'Success', 'DECLINED');
INSERT INTO `rcb_transactions` VALUES (14, 15, '2020-02-06 13:14:10', 'Test Payment', '1101-000001', 250.00, '0FBCCA8B82F48855967CDA6E09BA573E', 'Success', 'APPROVED');
INSERT INTO `rcb_transactions` VALUES (15, 16, '2020-02-06 13:15:05', 'Test Payment', '1101-000001', 250.00, 'C434AF3AE5661929A8A038B2E94693DC', 'Success', 'APPROVED');
INSERT INTO `rcb_transactions` VALUES (16, 15, '2020-02-06 16:31:52', 'Some Description', '1101-000001', 252.00, '3189DEF6073277957570BF4AB42BEB4D', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (17, 15, '2020-02-06 16:33:50', 'Some Description', '1101-000001', 252.00, '499A709125F67E857DA863467BE20F42', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (18, 15, '2020-02-06 16:34:05', 'Some Description', '1101-000001', 252.00, '9883F41F8F1F4E3D0A3CC9A7CF110531', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (19, 15, '2020-02-06 16:34:21', 'Some Description', '1101-000001', 252.00, '6711AB7449722255C418953C392BFFAC', 'Success', NULL);
INSERT INTO `rcb_transactions` VALUES (20, 15, '2020-02-06 16:35:42', 'Some Description', '1101-000001', 252.00, 'D04ED904517A5F484E76B1E191A9EE56', 'Success', 'DECLINED');
INSERT INTO `rcb_transactions` VALUES (21, 15, '2020-02-06 16:36:07', 'Some Description', '1101-000002', 252.00, 'D1CEFE8724925F831856D2145CD6C302', 'Success', 'DECLINED');
INSERT INTO `rcb_transactions` VALUES (22, 15, '2020-02-06 16:36:30', 'Some Description', '1101-000002', 252.00, '1E230EAD14ADF5F5F06DA12FCBA732D5', 'Success', 'DECLINED');
INSERT INTO `rcb_transactions` VALUES (23, 17, '2020-02-06 16:59:11', 'Test Payment', '1101-000001', 250.00, 'EAA18C1AAFE5E4B3E79B5C866F22121A', 'Success', 'APPROVED');
INSERT INTO `rcb_transactions` VALUES (24, 17, '2020-02-06 16:59:49', 'Some Description', '1101-000002', 252.00, '8AD7EDB0C378F6FDAD343948285CECA1', 'Success', 'APPROVED');
INSERT INTO `rcb_transactions` VALUES (25, 17, '2020-02-06 17:00:54', 'Some Description Anthimos', '1101-000100', 354.00, '0C9D089AC8A57D1245BA198793D9E9A0', 'Success', 'APPROVED');
INSERT INTO `rcb_transactions` VALUES (26, 18, '2020-02-06 17:02:00', 'Test Payment', '1101-000001', 250.00, '2C74ED12DD8AC562E918D3FE6B0B161C', 'Success', 'APPROVED');
INSERT INTO `rcb_transactions` VALUES (27, 19, '2020-04-23 23:45:17', 'Test Payment', '1101-000001', 250.00, '4E30D29D355378F65F7E6DDF649C0287', 'Success', 'APPROVED');


-- ----------------------------
-- Table structure for send_auto_emails
-- ----------------------------
DROP TABLE IF EXISTS `send_auto_emails`;
CREATE TABLE `send_auto_emails`  (
  `sae_send_auto_emails_serial` int(10) NOT NULL AUTO_INCREMENT,
  `sae_user_ID` int(8) NULL DEFAULT NULL,
  `sae_active` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'A -> Active',
  `sae_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_send_result` int(3) NULL DEFAULT 0,
  `sae_send_datetime` datetime(0) NULL DEFAULT NULL,
  `sae_primary_serial` int(10) NULL DEFAULT NULL,
  `sae_primary_label` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_secondary_serial` int(10) NULL DEFAULT NULL,
  `sae_secondary_label` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_label1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_label1_info` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_label2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_label2_info` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_to` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_to_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_from` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_from_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_subject` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_reply_to` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_reply_to_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_cc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_bcc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_email_body` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sae_attachment_files` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_send_result_description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sae_created_date_time` datetime(0) NULL DEFAULT NULL,
  `sae_created_by` int(8) NULL DEFAULT NULL,
  `sae_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `sae_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`sae_send_auto_emails_serial`) USING BTREE,
  UNIQUE INDEX `unique_serial`(`sae_send_auto_emails_serial`) USING BTREE,
  INDEX `send_result`(`sae_send_result`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 118 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of send_auto_emails
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `stg_settings_ID` int(10) NOT NULL AUTO_INCREMENT,
  `stg_section` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stg_value` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stg_value_date` datetime(0) NULL DEFAULT NULL,
  `stg_fetch_on_startup` int(1) NULL DEFAULT 0,
  PRIMARY KEY (`stg_settings_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'admin_default_layout', 'insurance', '2019-07-16 12:05:00', 0);
INSERT INTO `settings` VALUES (2, 'user_levels_extra_1_name', 'Agents No Group Option', '2018-04-18 12:41:59', 0);
INSERT INTO `settings` VALUES (3, 'user_levels_extra_2_name', 'User 2', '2018-04-12 12:55:31', 0);
INSERT INTO `settings` VALUES (4, 'user_levels_extra_3_name', 'User 3', '2018-04-12 12:55:34', 0);
INSERT INTO `settings` VALUES (5, 'user_levels_extra_4_name', 'User 4', '2018-04-12 12:55:36', 0);
INSERT INTO `settings` VALUES (6, 'user_levels_extra_5_name', 'User 5', '2018-04-12 12:55:38', 0);
INSERT INTO `settings` VALUES (7, 'user_levels_extra_6_name', 'User 6', '2018-04-12 12:55:41', 0);
INSERT INTO `settings` VALUES (8, 'stk_active_month', '8', '2018-08-21 13:43:27', 0);
INSERT INTO `settings` VALUES (9, 'stk_active_year', '2018', NULL, 0);
INSERT INTO `settings` VALUES (10, 'agr_agreement_number_prefix', 'AGR-', '2019-01-14 22:01:57', 1);
INSERT INTO `settings` VALUES (11, 'agr_agreement_number_last_used', '81', '2019-03-07 13:59:40', 0);
INSERT INTO `settings` VALUES (12, 'agr_agreement_number_leading_zeros', '6', '2018-09-21 18:05:59', 0);
INSERT INTO `settings` VALUES (13, 'agr_agreement_status_on_insert', 'Pending', '2018-11-14 15:00:00', 0);
INSERT INTO `settings` VALUES (14, 'layout_show_footer_stats', 'No', '2019-04-24 09:10:30', 1);
INSERT INTO `settings` VALUES (15, 'tck_ticket_number_prefix', 'TCK-', NULL, 0);
INSERT INTO `settings` VALUES (16, 'tck_ticket_number_leading_zeros', '6', NULL, 0);
INSERT INTO `settings` VALUES (17, 'tck_ticket_number_last_used', '10', '2019-03-07 13:52:05', 0);
INSERT INTO `settings` VALUES (18, 'sch_schedule_number_prefix', 'SCH-', NULL, 0);
INSERT INTO `settings` VALUES (19, 'sch_schedule_number_leading_zeros', '6', NULL, 0);
INSERT INTO `settings` VALUES (20, 'sch_schedule_number_last_used', '12', '2019-01-04 18:52:35', 0);
INSERT INTO `settings` VALUES (21, 'stk_stock_enable', '1', '2019-01-16 15:22:14', 1);
INSERT INTO `settings` VALUES (22, 'cst_customer_per_user', 'perUser', '2019-01-14 22:03:27', 1);
INSERT INTO `settings` VALUES (23, 'cst_admin_customers', 'viewAll', '2019-01-16 15:27:05', 1);
INSERT INTO `settings` VALUES (24, 'admin_imitate_user', 'No', '2019-04-24 09:11:36', 1);
INSERT INTO `settings` VALUES (25, 'ina_enable_agent_insurance', '1', '2019-01-16 15:23:06', 1);
INSERT INTO `settings` VALUES (26, 'accounts', 'advanced', '2019-02-10 10:35:06', 1);
INSERT INTO `settings` VALUES (27, 'vit_gbp_rate', '1.2', NULL, 0);
INSERT INTO `settings` VALUES (28, 'vit_bottle_cost_small', '1.2', NULL, 0);
INSERT INTO `settings` VALUES (29, 'vit_bottle_cost_large', '1.2', NULL, 0);
INSERT INTO `settings` VALUES (30, 'vit_courier_cost_per_pill', '0.009', NULL, 0);
INSERT INTO `settings` VALUES (31, 'user_max_user_accounts', 'SVpuNTl5TzhuejlWU3h2VHhQYlkvZz09OjpqrZ48CLfo_jL16ziyLobv', NULL, 0);
INSERT INTO `settings` VALUES (32, 'prd_enable_products', '0', '2019-07-02 12:17:00', 0);
INSERT INTO `settings` VALUES (33, 'agr_agreements_enable', '1', '2019-07-02 16:44:08', 0);
INSERT INTO `settings` VALUES (34, 'tck_tickets_enable', '1', NULL, 0);
INSERT INTO `settings` VALUES (35, 'ac_advanced_accounts_enable', '1', NULL, 0);
INSERT INTO `settings` VALUES (36, 'ac_open_period', '7', '2019-07-16 12:25:20', 1);
INSERT INTO `settings` VALUES (37, 'ac_open_year', '2019', '2019-07-16 12:25:21', 1);
INSERT INTO `settings` VALUES (38, 'biv_enable_basic_invoice', '1', NULL, 1);


-- ----------------------------
-- Table structure for user_settings
-- ----------------------------
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE `user_settings`  (
  `usrst_user_settings_ID` int(8) NOT NULL AUTO_INCREMENT,
  `usrst_for_user_ID` int(8) NOT NULL DEFAULT 0 COMMENT 'if -1 then default',
  `usrst_section` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `usrst_value` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `usrst_value_date` date NULL DEFAULT NULL,
  `usrst_created_date_time` datetime(0) NULL DEFAULT NULL,
  `usrst_created_by` int(8) NULL DEFAULT NULL,
  `usrst_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `usrst_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`usrst_user_settings_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_settings
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `usr_users_ID` int(8) NOT NULL AUTO_INCREMENT,
  `usr_users_groups_ID` int(8) NULL DEFAULT NULL,
  `usr_active` int(1) NOT NULL,
  `usr_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usr_username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usr_password` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usr_user_rights` int(2) NOT NULL,
  `usr_restrict_ip` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_email2` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_emailcc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_emailbcc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_tel` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_is_agent` int(1) NULL DEFAULT NULL,
  `usr_agent_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_agent_level` int(2) NULL DEFAULT NULL,
  `usr_issuing_office_serial` int(10) NULL DEFAULT NULL,
  `usr_description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_signature_gr` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `usr_signature_en` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `usr_name_gr` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_name_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usr_is_service` int(1) NULL DEFAULT 0,
  `usr_is_delivery` int(1) NULL DEFAULT 0,
  `usr_default_lang` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT 'eng',
  PRIMARY KEY (`usr_users_ID`) USING BTREE,
  UNIQUE INDEX `primary_serial`(`usr_users_ID`) USING BTREE,
  INDEX `group_serial`(`usr_users_groups_ID`) USING BTREE,
  INDEX `issuing`(`usr_issuing_office_serial`) USING BTREE,
  INDEX `active`(`usr_active`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 1, 'Michael Ermogenous', 'mike', 'mike', 0, 'ALL', 'it@ydrogios.com.cy', '', '', '', '', 0, '1001', 1, 0, 'Michael Ermogenous', 'Μιχάλης Ερμογένους', 'Michael Ermogenous', 'Michael Ermogenous', 'Michael Ermogenous', 1, 1, 'eng');
INSERT INTO `users` VALUES (2, 3, 1, 'Agent 1', 'agent1', 'agent1', 3, '', '', '', '', '', '', 0, '', 1, 0, '', '', '', NULL, NULL, 0, 0, 'gre');
INSERT INTO `users` VALUES (3, 3, 1, 'Agent2', 'agent2', 'agent2', 3, '', '', '', '', '', '', 0, '', 10, 0, 'No Group Option', '', '', '', '', 1, 0, 'eng');
INSERT INTO `users` VALUES (4, 3, 1, 'Agent3', 'agent3', 'agent3', 3, '', '', '', '', '', '', 0, '', 0, 0, '', '', '', '', '', 1, 1, 'eng');
INSERT INTO `users` VALUES (5, 1, 1, 'Anthimos Anthimou', 'anthimos', 'anthimos', 3, '', '', '', '', '', '', 0, NULL, NULL, NULL, 'Anthimos Anthimou', 'Anthimos Anthimou', 'Anthimos Anthimou', 'Anthimos Anthimou', 'Anthimos Anthimou', 0, 0, 'eng');
INSERT INTO `users` VALUES (6, 2, 1, 'Clary', 'clary', 'clary', 2, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', '', '', '', '', 0, 0, 'eng');
INSERT INTO `users` VALUES (7, 2, 1, 'Credit Card Remote User', 'ccrRemote', 'ccrRemote', 3, '', '', '', '', '', '', 0, NULL, NULL, NULL, 'Credit Card Remote User', '', '', 'Credit Card Remote User', 'Credit Card Remote User', 0, 0, 'eng');

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups`  (
  `usg_users_groups_ID` int(10) NOT NULL AUTO_INCREMENT,
  `usg_active` int(1) NULL DEFAULT NULL,
  `usg_group_name` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usg_permissions` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `usg_restrict_ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usg_approvals` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usg_created_date_time` datetime(0) NULL DEFAULT NULL,
  `usg_created_by` int(8) NULL DEFAULT NULL,
  `usg_last_update_date_time` datetime(0) NULL DEFAULT NULL,
  `usg_last_update_by` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`usg_users_groups_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES (1, 1, 'Administrators', NULL, '%', 'REQUEST', NULL, NULL, NULL, NULL);
INSERT INTO `users_groups` VALUES (2, 1, 'Advanced Users', '', '%', 'ANSWER', NULL, NULL, NULL, NULL);
INSERT INTO `users_groups` VALUES (3, 1, 'Agents', '', '', 'NO', NULL, NULL, NULL, NULL);
INSERT INTO `users_groups` VALUES (4, 1, 'Michael', '', '', 'NO', NULL, NULL, NULL, NULL);
INSERT INTO `users_groups` VALUES (5, 1, 'Anthimos Anthimou', '', '', 'NO', NULL, NULL, NULL, NULL);


-- ----------------------------
-- View structure for vac_sub_types
-- ----------------------------
DROP VIEW IF EXISTS `vac_sub_types`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vac_sub_types` AS SELECT
actpe_account_type_ID as vacstpe_account_type_ID,
actpe_active as vacstpe_active,
actpe_type as vacstpe_type,
actpe_category as vacstpe_category,
actpe_owner_ID as vacstpe_owner_ID,
actpe_code as vacstpe_code,
actpe_name as vacstpe_name,
actpe_created_date_time as vacstpe_created_date_time,
actpe_created_by as vacstpe_created_by,
actpe_last_update_date_time as vacstpe_last_update_date_time,
actpe_last_update_by as vacstpe_last_update_by
FROM
ac_account_types
WHERE
actpe_type = 'SubType' ;


-- ----------------------------
-- View structure for vac_types
-- ----------------------------
DROP VIEW IF EXISTS `vac_types`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vac_types` AS SELECT
actpe_account_type_ID as vactpe_account_type_ID,
actpe_active as vactpe_active,
actpe_type as vactpe_type,
actpe_category as vactpe_category,
actpe_owner_ID as vactpe_owner_ID,
actpe_code as vactpe_code,
actpe_name as vactpe_name,
actpe_created_date_time as vactpe_created_date_time,
actpe_created_by as vactpe_created_by,
actpe_last_update_date_time as vactpe_last_update_date_time,
actpe_last_update_by as vactpe_last_update_by
FROM
ac_account_types
WHERE
actpe_type = 'Type' ;

-- ----------------------------
-- Records of vitamins
-- ----------------------------

-- ----------------------------
-- Function structure for getPolicyAsAtDateBalance
-- ----------------------------
DROP FUNCTION IF EXISTS `getPolicyAsAtDateBalance`;
delimiter ;;
CREATE FUNCTION `getPolicyAsAtDateBalance`(`policyNumber` INT, `asAtDate` DATE)
 RETURNS decimal(10,2)
BEGIN
	
	#Declarations
  DECLARE balance DECIMAL(10,2) DEFAULT 0;
	DECLARE installmentsBalance DECIMAL(10,2) DEFAULT 0;
	DECLARE paymentsBalance DECIMAL(10,2) DEFAULT 0;

	#Get the installments balance
	SELECT
	SUM(inapi_amount) into installmentsBalance
	FROM
	ina_policies
	JOIN ina_policy_installments ON inapi_policy_ID = inapol_policy_ID
	WHERE
	inapi_document_date < asAtDate
	AND inapol_policy_number = policyNumber
	AND inapi_paid_status IN ('Paid','Partial','UnPaid')
	AND inapol_status IN ('Active','Archived');

	#Get the payments balance
	SELECT
	SUM(inapp_amount) into paymentsBalance
	FROM
	ina_policies
	JOIN ina_policy_payments ON inapp_policy_ID = inapol_policy_ID
	WHERE
	inapp_payment_date < asAtDate
	AND inapol_policy_number = policyNumber
	AND inapp_status = 'Applied'
	AND inapol_status IN ('Active','Archived');

	set balance = installmentsBalance - paymentsBalance;
    
  RETURN balance;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
