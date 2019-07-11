
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policies
-- ----------------------------
INSERT INTO `ina_policies` VALUES ('1', '1', '1', '1', '8', '1', 'Motor', '1901-000001', '2019-06-26', '2019-06-26', '2019-12-25', 'Archived', 'New', '250.00', null, '50.00', '25.00', '2.00', null, '3', '2019-06-26 12:16:42', '1', '2019-06-26 17:08:02', '1');
INSERT INTO `ina_policies` VALUES ('3', '1', '1', '1', '8', '1', 'Motor', '1901-000001', '2019-06-26', '2019-06-30', '2019-12-25', 'Archived', 'Cancellation', '-100.00', '0.00', '-5.00', '0.00', '0.00', '1', null, null, null, '2019-06-26 17:08:02', '1');
INSERT INTO `ina_policies` VALUES ('4', '1', '1', '1', '8', '4', 'Motor', '1901-000002', '2019-06-28', '2019-06-28', '2020-06-27', 'Archived', 'New', '250.00', null, '50.00', '25.00', '2.00', null, '5', '2019-06-28 13:48:35', '1', '2019-06-28 15:05:21', '1');
INSERT INTO `ina_policies` VALUES ('5', '1', '1', '1', '8', '4', 'Motor', '1901-000002', '2019-06-28', '2019-06-29', '2020-06-27', 'Archived', 'Cancellation', '-100.00', '0.00', '0.00', '0.00', '0.00', '4', null, null, null, '2019-06-28 15:05:20', '1');
INSERT INTO `ina_policies` VALUES ('6', '1', '1', '1', '1', '6', 'Fire', '1712-000001', '2019-06-28', '2019-06-28', '2020-06-27', 'Active', 'New', '250.00', null, '50.00', '50.00', '2.00', null, null, '2019-06-28 16:30:19', '1', '2019-06-28 16:35:11', '1');
INSERT INTO `ina_policies` VALUES ('7', '1', '1', '3', '8', '7', 'PL', '2201-000001', '2019-06-28', '2019-06-28', '2020-06-27', 'Active', 'New', '250.00', null, '75.00', '50.00', '2.00', null, null, '2019-06-28 18:24:04', '1', '2019-06-28 18:25:07', '1');
INSERT INTO `ina_policies` VALUES ('8', '1', '1', '1', '1', '8', 'Motor', '1901-010101', '2019-07-02', '2019-07-02', '2020-07-01', 'Outstanding', 'New', '0.00', null, '75.00', '25.00', '2.00', null, null, '2019-07-02 12:54:01', '1', '2019-07-03 12:53:16', '1');
INSERT INTO `ina_policies` VALUES ('9', '5', '6', '1', '10', '9', 'Motor', '1901-010101', '2019-07-02', '2019-07-02', '2020-07-01', 'Active', 'New', '250.00', null, '50.00', '25.00', '2.00', null, null, '2019-07-02 16:31:24', '5', '2019-07-02 16:32:07', '5');
INSERT INTO `ina_policies` VALUES ('10', '1', '1', '1', '1', '10', 'Fire', '1901-010101', '2019-07-03', '2019-07-03', '2020-07-02', 'Archived', 'New', '200.00', null, '52.60', '10.00', '2.00', null, '14', '2019-07-03 10:18:49', '1', '2019-07-04 11:27:11', '1');
INSERT INTO `ina_policies` VALUES ('11', '1', '1', '1', '1', '11', 'Fire', '1701-010101', '2019-07-03', '2019-07-03', '2020-07-02', 'Outstanding', 'New', null, null, null, null, null, null, null, '2019-07-03 11:52:55', '1', '2019-07-03 15:47:03', '1');
INSERT INTO `ina_policies` VALUES ('12', '1', '1', '1', '1', '12', 'Motor', '1901-010102', '2019-07-03', '2019-07-03', '2020-07-02', 'Outstanding', 'New', null, null, null, null, null, null, null, '2019-07-03 15:48:30', '1', '2019-07-03 15:49:13', '1');
INSERT INTO `ina_policies` VALUES ('14', '1', '1', '1', '1', '10', 'Fire', '1901-010101', '2019-07-03', '2020-01-01', '2020-07-02', 'Active', 'Endorsement', '-100.00', '0.00', '-25.00', '10.00', '0.00', '10', null, null, null, '2019-07-04 11:27:11', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

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
INSERT INTO `ina_policy_installments` VALUES ('17', '7', 'Recursive', 'UnPaid', '2019-06-28', '2019-06-28', null, '50.35', '0.00', '12.50', '0.00', '2019-06-28 18:24:54', '1', '2019-06-28 18:24:54', '1');
INSERT INTO `ina_policy_installments` VALUES ('18', '7', 'Recursive', 'UnPaid', '2019-06-28', '2019-07-28', null, '50.33', '0.00', '12.50', '0.00', '2019-06-28 18:24:54', '1', '2019-06-28 18:24:54', '1');
INSERT INTO `ina_policy_installments` VALUES ('19', '7', 'Recursive', 'UnPaid', '2019-06-28', '2019-08-28', null, '50.33', '0.00', '12.50', '0.00', '2019-06-28 18:24:54', '1', '2019-06-28 18:24:54', '1');
INSERT INTO `ina_policy_installments` VALUES ('20', '7', 'Recursive', 'UnPaid', '2019-06-28', '2019-09-28', null, '50.33', '0.00', '12.50', '0.00', '2019-06-28 18:24:54', '1', '2019-06-28 18:24:54', '1');
INSERT INTO `ina_policy_installments` VALUES ('21', '7', 'Recursive', 'UnPaid', '2019-06-28', '2019-10-28', null, '50.33', '0.00', '12.50', '0.00', '2019-06-28 18:24:54', '1', '2019-06-28 18:24:54', '1');
INSERT INTO `ina_policy_installments` VALUES ('22', '7', 'Recursive', 'UnPaid', '2019-06-28', '2019-11-28', null, '50.33', '0.00', '12.50', '0.00', '2019-06-28 18:24:54', '1', '2019-06-28 18:24:54', '1');
INSERT INTO `ina_policy_installments` VALUES ('27', '8', 'Recursive', 'UnPaid', '2019-07-02', '2019-07-02', null, '94.25', '0.00', '18.75', '0.00', '2019-07-02 12:55:35', '1', '2019-07-02 12:55:35', '1');
INSERT INTO `ina_policy_installments` VALUES ('28', '8', 'Recursive', 'UnPaid', '2019-07-02', '2019-08-02', null, '94.25', '0.00', '18.75', '0.00', '2019-07-02 12:55:35', '1', '2019-07-02 12:55:35', '1');
INSERT INTO `ina_policy_installments` VALUES ('29', '8', 'Recursive', 'UnPaid', '2019-07-02', '2019-09-02', null, '94.25', '0.00', '18.75', '0.00', '2019-07-02 12:55:35', '1', '2019-07-02 12:55:35', '1');
INSERT INTO `ina_policy_installments` VALUES ('30', '8', 'Recursive', 'UnPaid', '2019-07-02', '2019-10-02', null, '94.25', '0.00', '18.75', '0.00', '2019-07-02 12:55:35', '1', '2019-07-02 12:55:35', '1');
INSERT INTO `ina_policy_installments` VALUES ('31', '9', 'Recursive', 'Paid', '2019-07-02', '2019-07-02', null, '92.34', '92.34', '16.68', '16.68', '2019-07-02 16:32:02', '5', '2019-07-02 16:38:07', '5');
INSERT INTO `ina_policy_installments` VALUES ('32', '9', 'Recursive', 'Partial', '2019-07-02', '2019-08-02', null, '92.33', '84.66', '16.66', '15.28', '2019-07-02 16:32:02', '5', '2019-07-02 16:38:07', '5');
INSERT INTO `ina_policy_installments` VALUES ('33', '9', 'Recursive', 'UnPaid', '2019-07-02', '2019-09-02', null, '92.33', '0.00', '16.66', '0.00', '2019-07-02 16:32:02', '5', '2019-07-02 16:32:02', '5');
INSERT INTO `ina_policy_installments` VALUES ('34', '10', 'Recursive', 'Paid', '2019-07-03', '2019-07-03', null, '70.68', '70.68', '17.54', '17.54', '2019-07-03 11:21:35', '1', '2019-07-03 11:22:43', '1');
INSERT INTO `ina_policy_installments` VALUES ('35', '10', 'Recursive', 'Paid', '2019-07-03', '2019-08-03', null, '70.66', '70.66', '17.53', '17.53', '2019-07-03 11:21:35', '1', '2019-07-04 11:16:58', '1');
INSERT INTO `ina_policy_installments` VALUES ('36', '10', 'Recursive', 'Paid', '2019-07-03', '2019-09-03', null, '70.66', '70.66', '17.53', '17.53', '2019-07-03 11:21:35', '1', '2019-07-04 11:16:58', '1');
INSERT INTO `ina_policy_installments` VALUES ('37', '10', 'Endorsement', 'Paid', '2019-07-04', '2019-07-04', '2019-07-04', '0.00', '0.00', '-25.00', '-25.00', '2019-07-04 11:27:11', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ina_policy_items
-- ----------------------------
INSERT INTO `ina_policy_items` VALUES ('1', '1', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '5000.00', '500.00', '250.00', null, '2019-06-26 12:17:09', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('2', '4', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '5000.00', '500.00', '250.00', null, '2019-06-28 13:48:52', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('3', '6', 'RiskLocation', null, null, null, null, null, null, null, null, 'Larnaka', 'apt101', '35', '7000', '8', 'Apartment', '5000.00', '500.00', '250.00', null, '2019-06-28 16:30:43', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('4', '7', 'PublicLiability', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '10000.00', '100.00', '100.00', null, '2019-06-28 18:24:15', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('5', '7', 'PublicLiability', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '50000.00', '222.00', '150.00', null, '2019-06-28 18:24:24', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('7', '9', 'Vehicles', 'KWA089', '9', '2200', '13', '2006', 'IS220D', '5', '15', null, null, null, null, null, null, '5000.00', '500.00', '250.00', null, '2019-07-02 16:31:47', '5', null, null);
INSERT INTO `ina_policy_items` VALUES ('8', '10', 'RiskLocation', null, null, null, null, null, null, null, null, 'Larnaka', '', '35', '7000', '10', 'House', '10000.00', '500.00', '200.00', null, '2019-07-03 11:09:17', '1', null, null);
INSERT INTO `ina_policy_items` VALUES ('10', '14', 'RiskLocation', '', '0', '0', '0', '0', '', '0', '0', 'Larnaka', '', '35', '7000', '10', 'House', '10000.00', '500.00', '200.00', '0.00', null, null, null, null);

-- ----------------------------
-- Table structure for ina_policy_payments
-- ----------------------------
DROP TABLE IF EXISTS `ina_policy_payments`;
CREATE TABLE `ina_policy_payments` (
  `inapp_policy_payment_ID` int(8) NOT NULL AUTO_INCREMENT,
  `inapp_policy_ID` int(8) DEFAULT NULL,
  `inapp_customer_ID` int(8) DEFAULT NULL,
  `inapp_status` varchar(12) DEFAULT NULL COMMENT 'Outstanding\r\nApplied\r\nPosted\r\nIncomplete',
  `inapp_process_status` varchar(12) DEFAULT NULL,
  `inapp_payment_date` date DEFAULT NULL,
  `inapp_amount` decimal(10,2) DEFAULT NULL,
  `inapp_commission_amount` decimal(10,2) DEFAULT NULL,
  `inapp_allocated_amount` decimal(10,2) DEFAULT NULL,
  `inapp_allocated_commission` decimal(10,2) DEFAULT NULL,
  `inapp_locked` int(1) DEFAULT '0',
  `inapp_created_payment_ID` int(8) DEFAULT '0',
  `inapp_replaced_by_payment_ID` int(8) DEFAULT '0',
  `inapp_created_date_time` datetime DEFAULT NULL,
  `inapp_created_by` int(8) DEFAULT NULL,
  `inapp_last_update_date_time` datetime DEFAULT NULL,
  `inapp_last_update_by` int(8) DEFAULT NULL,
  PRIMARY KEY (`inapp_policy_payment_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments
-- ----------------------------
INSERT INTO `ina_policy_payments` VALUES ('1', '1', '8', 'Applied', 'Policy', '2019-06-26', '150.00', null, '150.00', '27.08', '1', '0', '0', '2019-06-26 12:18:14', '1', '2019-06-26 12:18:17', '1');
INSERT INTO `ina_policy_payments` VALUES ('2', '4', '8', 'Applied', 'Policy', '2019-06-28', '150.00', null, '150.00', '27.08', '1', '0', '0', '2019-06-28 14:00:39', '1', '2019-06-28 15:05:20', '1');
INSERT INTO `ina_policy_payments` VALUES ('3', '1', '8', 'Outstanding', 'Policy', '2019-06-28', '27.00', null, null, null, '0', '0', '0', '2019-06-28 16:09:28', '1', null, null);
INSERT INTO `ina_policy_payments` VALUES ('4', '4', '8', 'Applied', 'Policy', '2019-06-28', '27.00', null, '27.00', '22.92', '0', '0', '0', '2019-06-28 16:24:12', '1', '2019-06-28 16:24:21', '1');
INSERT INTO `ina_policy_payments` VALUES ('5', '9', '10', 'Applied', 'Policy', '2019-07-02', '177.00', null, '177.00', '31.96', '0', '0', '0', '2019-07-02 16:32:16', '5', '2019-07-02 16:38:07', '5');
INSERT INTO `ina_policy_payments` VALUES ('6', '10', '1', 'Applied', 'Policy', '2019-07-03', '100.00', null, '100.00', '24.81', '1', '0', '0', '2019-07-03 11:22:40', '1', '2019-07-04 11:27:11', '1');
INSERT INTO `ina_policy_payments` VALUES ('7', '10', '1', 'Applied', 'Policy', '2019-07-03', '112.00', null, '112.00', '27.79', '1', '0', '0', '2019-07-03 16:15:27', '1', '2019-07-04 11:27:11', '1');
INSERT INTO `ina_policy_payments` VALUES ('8', '14', '1', 'Outstanding', 'Unallocated', '2019-07-04', '90.00', '0.00', '0.00', '0.00', '0', '0', '0', null, null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_policy_payments_lines
-- ----------------------------
INSERT INTO `ina_policy_payments_lines` VALUES ('1', '1', '5', '0.00', '92.34', '0.00', '16.68', 'UnPaid', 'Paid', '2019-06-26 12:18:17', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('2', '1', '6', '0.00', '57.66', '0.00', '10.40', 'UnPaid', 'Partial', '2019-06-26 12:18:17', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('3', '2', '8', '0.00', '92.34', '0.00', '16.68', 'UnPaid', 'Paid', '2019-06-28 14:00:46', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('4', '2', '9', '0.00', '57.66', '0.00', '10.40', 'UnPaid', 'Partial', '2019-06-28 14:00:46', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('5', '4', '10', '0.00', '27.00', '0.00', '22.92', 'UnPaid', 'Paid', '2019-06-28 16:24:21', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('10', '5', '31', '0.00', '92.34', '0.00', '16.68', 'UnPaid', 'Paid', '2019-07-02 16:38:07', '5', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('11', '5', '32', '0.00', '84.66', '0.00', '15.28', 'UnPaid', 'Partial', '2019-07-02 16:38:07', '5', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('12', '6', '34', '0.00', '70.68', '0.00', '17.54', 'UnPaid', 'Paid', '2019-07-03 11:22:43', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('13', '6', '35', '0.00', '29.32', '0.00', '7.27', 'UnPaid', 'Partial', '2019-07-03 11:22:43', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('14', '7', '35', '29.32', '70.66', '7.27', '17.53', 'Partial', 'Paid', '2019-07-04 11:16:58', '1', null, null);
INSERT INTO `ina_policy_payments_lines` VALUES ('15', '7', '36', '0.00', '70.66', '0.00', '17.53', 'UnPaid', 'Paid', '2019-07-04 11:16:58', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ina_underwriters
-- ----------------------------
INSERT INTO `ina_underwriters` VALUES ('1', '1', 'Active', '1', '1', '1', '1', '1', '1', '1', '0', null, null, '2019-06-24 13:08:35', '1');
INSERT INTO `ina_underwriters` VALUES ('2', '2', 'Active', '1', '1', '1', '1', '1', '1', '1', '0', null, null, '2019-06-21 11:46:23', '1');
INSERT INTO `ina_underwriters` VALUES ('4', '3', 'Active', '1', '1', '1', '1', '1', '1', '1', '1', null, null, '2019-06-21 11:46:39', '1');
INSERT INTO `ina_underwriters` VALUES ('5', '4', 'Active', '1', '1', '1', '1', '1', '1', '1', '2', '2019-06-21 11:46:59', '1', null, null);
INSERT INTO `ina_underwriters` VALUES ('6', '5', 'Active', '1', '1', '1', '1', '1', '1', '1', '0', '2019-07-02 15:45:05', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

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
INSERT INTO `ina_underwriter_companies` VALUES ('97', '6', '1', 'Active', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('98', '6', '3', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('99', '6', '4', 'Active', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('100', '6', '25', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('101', '6', '5', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('102', '6', '6', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('103', '6', '7', 'Active', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('104', '6', '8', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('105', '6', '9', 'Active', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('106', '6', '10', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('107', '6', '11', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('108', '6', '12', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('109', '6', '13', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('110', '6', '14', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('111', '6', '15', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('112', '6', '16', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('113', '6', '17', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('114', '6', '18', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('115', '6', '19', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('116', '6', '20', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('117', '6', '21', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('118', '6', '22', 'Active', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('119', '6', '23', 'Active', '2019-07-02 15:45:05', '1', null, null);
INSERT INTO `ina_underwriter_companies` VALUES ('120', '6', '24', 'Inactive', '2019-07-02 15:45:05', '1', null, null);
