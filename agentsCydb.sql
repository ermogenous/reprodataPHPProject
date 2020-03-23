-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for view insurance.vac_sub_types
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vac_sub_types` (
	`vacstpe_account_type_ID` INT(8) NOT NULL,
	`vacstpe_active` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`vacstpe_type` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`vacstpe_category` VARCHAR(20) NULL COLLATE 'utf8_general_ci',
	`vacstpe_owner_ID` INT(8) NULL,
	`vacstpe_code` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`vacstpe_name` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`vacstpe_created_date_time` DATETIME NULL,
	`vacstpe_created_by` INT(8) NULL,
	`vacstpe_last_update_date_time` DATETIME NULL,
	`vacstpe_last_update_by` INT(8) NULL
) ENGINE=MyISAM;

-- Dumping structure for view insurance.vac_types
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vac_types` (
	`vactpe_account_type_ID` INT(8) NOT NULL,
	`vactpe_active` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`vactpe_type` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`vactpe_category` VARCHAR(20) NULL COLLATE 'utf8_general_ci',
	`vactpe_owner_ID` INT(8) NULL,
	`vactpe_code` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`vactpe_name` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`vactpe_created_date_time` DATETIME NULL,
	`vactpe_created_by` INT(8) NULL,
	`vactpe_last_update_date_time` DATETIME NULL,
	`vactpe_last_update_by` INT(8) NULL
) ENGINE=MyISAM;

-- Dumping structure for view insurance.vac_sub_types
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vac_sub_types`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vac_sub_types` AS SELECT
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

-- Dumping structure for view insurance.vac_types
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vac_types`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vac_types` AS SELECT
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

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
