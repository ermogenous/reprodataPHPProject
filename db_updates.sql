-- noinspection SqlDialectInspectionForFile

-- noinspection SqlNoDataSourceInspectionForFile

// 09/8/2018 VORKE
/*
CREATE TABLE `manufacturers` (
	`mnf_manufacturer_ID` INT(8) NOT NULL AUTO_INCREMENT,
	`mnf_code` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`mnf_active` INT(1) NULL DEFAULT NULL,
	`mnf_name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`mnf_description` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`mnf_country_code_ID` INT(8) NULL DEFAULT NULL,
	`mnf_tel` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`mnf_contact_person` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`mnf_created_date_time` DATETIME NULL DEFAULT NULL,
	`mnf_created_by` INT(8) NULL DEFAULT NULL,
	`mnf_last_update_date_time` DATETIME NULL DEFAULT NULL,
	`mnf_last_update_by` INT(8) NULL DEFAULT NULL,
	PRIMARY KEY (`mnf_manufacturer_ID`)
)
COLLATE='utf8_bin'
ENGINE=InnoDB
;


CREATE TABLE `products` (
	`prd_product_ID` INT(8) NOT NULL AUTO_INCREMENT,
	`prd_manufacturer_ID` INT(8) NULL DEFAULT NULL,
	`prd_active` INT(1) NULL DEFAULT NULL,
	`prd_type` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`prd_code` VARCHAR(20) NOT NULL DEFAULT '0' COLLATE 'utf8_bin',
	`prd_bar_code` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`prd_name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`prd_description` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`prd_created_date_time` DATETIME NULL DEFAULT NULL,
	`prd_created_by` INT(8) NULL DEFAULT NULL,
	`prd_last_update_date_time` DATETIME NULL DEFAULT NULL,
	`prd_last_update_by` INT(8) NULL DEFAULT NULL,
	PRIMARY KEY (`prd_product_ID`)
)
COLLATE='utf8_bin'
ENGINE=InnoDB
;


CREATE TABLE `product_relations` (
	`prdr_product_relations_ID` INT(8) NOT NULL AUTO_INCREMENT,
	`prdr_product_parent_ID` INT(8) NULL DEFAULT NULL,
	`prdr_child_type` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
	`prdr_product_child_ID` INT(8) NULL DEFAULT NULL,
	PRIMARY KEY (`prdr_product_relations_ID`)
)
COLLATE='utf8_bin'
ENGINE=InnoDB
;


ALTER TABLE `customers`
	ADD COLUMN IF NOT EXISTS `cst_created_date_time` DATETIME NULL DEFAULT NULL AFTER `cst_business_type_ID`,
	ADD COLUMN IF NOT EXISTS `cst_created_by` INT(8) NULL DEFAULT NULL AFTER `cst_created_date_time`,
	ADD COLUMN IF NOT EXISTS `cst_last_update_date_time` DATETIME NULL DEFAULT NULL AFTER `cst_created_by`,
	ADD COLUMN IF NOT EXISTS `cst_last_update_by` INT(8) NULL DEFAULT NULL AFTER `cst_last_update_date_time`;

ALTER TABLE `customers`
	CHANGE COLUMN `cst_contact_person_title_ID` `cst_contact_person_title_code_ID` VARCHAR(30) NULL DEFAULT NULL AFTER `cst_contact_person`,
	CHANGE COLUMN `cst_business_type_ID` `cst_business_type_code_ID` INT(8) NULL DEFAULT NULL AFTER `cst_email_newsletter`
	CHANGE COLUMN `cst_city_ID` `cst_city_code_ID` VARCHAR(30) NULL DEFAULT NULL AFTER `cst_address_line_2`;

*/