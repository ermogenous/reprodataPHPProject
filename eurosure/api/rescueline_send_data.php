<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 1/12/2020
 * Time: 4:49 ΜΜ
 */

/*
 * This file retrieves all the now active vehicles from synthesis, empties the extranet table es_rescueline_vehicles
 * then inserts all the vehicles
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1200);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure vehicles Rescueline update extranet table';
$db->update_log_file('Eurosure send vehicles to extranet',0,'Eurosure send vehicles to extranet'
    ,'Eurosure send vehicles to extranet');
$log = 'Starting Extranet Rescueline Vehicle Update'.PHP_EOL;

//insert into settings the time this process starts
$db->update_setting('eurosure_send_vehicles_extranet',1,0,date('Y-m-d G:i:s'));


//step 1 collect the data from sybase
$syn = new ODBCCON();

$sql = "
SELECT
sp_car_id,
sp_registration_num,
incl_identity_card,
IF incl_district = '' OR incl_district is null then incl_mail_district else incl_district endif as clo_client_district,
inpol_policy_number,
inag_agent_code,
sp_make,
sp_model,
sp_body_type,
sp_colour,
sp_engineCC,
sp_weight,
sp_firstdate,
sp_expireddate,
sp_price,
sp_Breakdown as sp_road_assistance,
sp_Accident as sp_accident_care,
sp_car_type,
sp_begindate,
sp_city_home
FROM
sp_rescueline_export('".date("Y-m-d")."','Y','N')
JOIN inpolicies on inpol_policy_serial = sp_policy_serial
JOIN inclients on incl_client_serial = inpol_client_serial
JOIN inagents ON inag_agent_serial = inpol_agent_serial
ORDER BY sp_registration_num
";


//step 2: connect to extranet
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('import rescueline api',0,$log,'test');
    exit();
}

$result = $syn->query($sql);
$log .= 'Total Vehicles Found: '.$syn->num_rows($result).PHP_EOL;

//empty the extranet database
$log .= '<br>Truncate Extranet Vehicles'.PHP_EOL;
$sql = 'TRUNCATE es_rescueline_vehicles';
$extranet->query($sql);
$log .= '<br>TRUNCATE completed '.PHP_EOL;
$sql = '';
$createdOn = date('Y-m-d G:i:s');
$totalVehicles = 0;
$perPage = 50;
while ($row = $syn->fetch_assoc($result)){
    $i++;
    $totalVehicles++;
    $sql .= "
        (
        '".$row['sp_car_id']."',
        '".$row['sp_registration_num']."',
        '".$row['incl_identity_card']."',
        '".$row['clo_client_district']."',
        '".$row['inpol_policy_number']."',
        '".$row['inag_agent_code']."',
        '".$row['sp_make']."',
        '".$row['sp_model']."',
        '".$row['sp_body_type']."',
        '".$row['sp_colour']."',
        '".$row['sp_engineCC']."',
        '".$row['sp_weight']."',
        '".$row['sp_begindate']."',
        '".$row['sp_firstdate']."',
        '".$row['sp_expireddate']."',
        '".$row['sp_price']."',
        '".$row['sp_car_type']."',
        '".$row['sp_city_home']."',
        '".$row['sp_road_assistance']."',
        '".$row['sp_accident_care']."',
        0,
        '".$createdOn."',
        '0',
        '".$createdOn."',
        '0'
        )".PHP_EOL.",";
    //echo $row['sp_registration_num']." ";
    //do it per 100 to save time
    if ($i > $perPage){

        $sql = '
        INSERT INTO `es_rescueline_vehicles` 
                    (
                    `esrsc_car_id`,
                    `esrsc_registration`,
                    `esrsc_client_id`,
                    `esrsc_client_district`,
                    `esrsc_policy_number`,
                    `esrsc_agent_code`,
                    `esrsc_make`, 
                    `esrsc_model`, 
                    `esrsc_body_type`, 
                    `esrsc_color`, 
                    `esrsc_engine_cc`, 
                    `esrsc_weight`, 
                    `esrsc_starting_date`, 
                    `esrsc_period_starting_date`, 
                    `esrsc_expiry_date`, 
                    `esrsc_price`, 
                    `esrsc_cover_type`, 
                    `esrsc_home_city`, 
                    `esrsc_road_assistance`,
                    `esrsc_accident_care`,
                    `esrsc_is_cover_note`,
                    `esrsc_created_on`, 
                    `esrsc_created_by`, 
                    `esrsc_last_update_on`, 
                    `esrsc_last_update_by`
                    ) VALUES '.PHP_EOL.$db->remove_last_char($sql);
        //echo $sql.PHP_EOL.PHP_EOL."<hr>";exit();
        $extranet->query($sql) or die ($extranet->error);
        $sql = '';
        $i=0;
    }


}
//check if any left to send
if ($sql != ''){
    $sql = '
        INSERT INTO `es_rescueline_vehicles` 
                    (
                    `esrsc_car_id`,
                    `esrsc_registration`,
                    `esrsc_client_id`,
                    `esrsc_client_district`,
                    `esrsc_policy_number`,
                    `esrsc_agent_code`,
                    `esrsc_make`, 
                    `esrsc_model`, 
                    `esrsc_body_type`, 
                    `esrsc_color`, 
                    `esrsc_engine_cc`, 
                    `esrsc_weight`, 
                    `esrsc_starting_date`, 
                    `esrsc_period_starting_date`, 
                    `esrsc_expiry_date`, 
                    `esrsc_price`, 
                    `esrsc_cover_type`, 
                    `esrsc_home_city`, 
                    `esrsc_road_assistance`,
                    `esrsc_accident_care`,
                    `esrsc_is_cover_note`,
                    `esrsc_created_on`, 
                    `esrsc_created_by`, 
                    `esrsc_last_update_on`, 
                    `esrsc_last_update_by`
                    ) VALUES '.PHP_EOL.$db->remove_last_char($sql);
    //echo $sql.PHP_EOL.PHP_EOL."<hr>";exit();
    $extranet->query($sql) or die ($extranet->error);
}

$log .= '<br>Total rows found: '.$totalVehicles.PHP_EOL;
$time_elapsed_secs = microtime(true) - $startTime;
$log .= '<br>Policies Total Execution Seconds: '.$time_elapsed_secs;




/*COVER NOTES*/
$startTime = microtime(true);
$log .= '<br>Preparing Cover Notes';
$sql = "
SELECT 
initm_item_code,
incl_identity_card,
IF incl_district = '' OR incl_district is null then incl_mail_district else incl_district endif as clo_client_district,
inpol_policy_number,
inag_agent_code,
inmkc_long_description as clo_make,
inmdl_long_description as clo_model,
inbdc_long_description as clo_body_type,
incd_long_description as clo_colour,
initm_cubic_capacity as clo_engineCC,
initm_gross_vehicle_weight as clo_weight,
inpol_starting_date,
inpol_period_starting_date, 
inpol_expiry_date, 
(case inpol_cover when 'A' then 'Third Party' when 'B' then 'Fire & Theft' when 'C' then 'Comprehensive' else '' end) as clo_car_type,

-- Breakdown and Accident
      (select LIST(distinct(case when b.inldg_claim_reserve_group in( 768 ) then 'R' /* Road Assistance */
        else 'A' /* Accident Care */
        end),'' order by(if b.inldg_claim_reserve_group in( 768 ) then 0 else 1 endif) asc)
        from inpolicyloadings as a
          join inloadings as b on a.inplg_loading_serial = b.inldg_loading_serial
          and b.inldg_claim_reserve_group in( 768,769 )  /* BreakDown */ /* Accident Care */
          and a.inplg_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial) as clo_breakdown_accident,
if clo_breakdown_accident in( 'RA','R' ) then '1' else '0' endif as clo_road_assistance, /*Road Assistance*/
if clo_breakdown_accident in( 'RA','A','R' ) then '1' else '0' endif as clo_accident_care, /*When road assistance exists then also accident exists*/


LIST(DISTINCT incn_cover_note_number) as clo_cover_note_number,
LIST(DISTINCT incn_issuing_reason) as clo_issuing_reason,
inpol_policy_serial, 
inpol_created_by, 
inpol_created_on,
MIN(indpl_document_type) as clo_document_type,
COUNT(IF indpl_print_copies > 0 AND indpl_secondary_serial = inpit_pit_auto_serial THEN indpl_print_copies ELSE NULL ENDIF) as clo_printed,
MIN(IF indpl_print_copies > 0 AND indpl_secondary_serial = inpit_pit_auto_serial THEN indpl_print_date ELSE NULL ENDIF) as clo_printed_on,
COUNT(IF indpl_print_copies < 0 AND indpl_secondary_serial = inpit_pit_auto_serial THEN 1 ELSE NULL ENDIF) as clo_prepared,
COUNT(IF indpl_secondary_serial <> inpit_pit_auto_serial THEN 1 ELSE NULL ENDIF) as clo_OTHER

FROM ininsurancetypes
JOIN inpolicies ON inpol_insurance_type_serial = inity_insurance_type_serial
JOIN inagents ON inag_agent_serial = inpol_agent_serial
JOIN inpolicyitems ON inpol_policy_serial = inpit_policy_serial
JOIN initems ON initm_item_serial = inpit_item_serial

left outer join incarmakecodes on inmkc_pcode_serial = initm_make_serial
left outer join inmodelcodes on inmdl_pcode_serial = initm_model_serial
left outer join incolourcodes on incd_pcode_serial = initm_color_serial
left outer join inbodycodes on inbdc_pcode_serial = initm_body_type_serial

LEFT OUTER JOIN incovernotes ON incn_pit_auto_serial = inpit_pit_auto_serial
LEFT OUTER JOIN indocumprnlog 
             ON indpl_primary_serial = inpit_policy_serial 
      --    AND indpl_secondary_serial = inpit_pit_auto_serial 
             AND indpl_document_type IN ('CVN'/*Printed CoverNote*/, 'CVNN'/* Got Number But Not Printed */)
JOIN inclients ON incl_client_serial = inpol_client_serial
LEFT OUTER JOIN ccuserparameters ON 1=1
WHERE inity_insurance_form = 'M'
AND inpol_process_status = 'N' 
AND inpol_status = 'Q'
AND COALESCE(ccusp_user_date, Today()) BETWEEN inpol_starting_date AND inpol_expiry_date
GROUP BY inpol_policy_serial, 
inpol_policy_number, 
inpol_starting_date,
inpol_period_starting_date, 
inpol_expiry_date, 
inpol_created_by, 
inpol_created_on,
initm_item_code,
incl_identity_card,
clo_make,
clo_model,
clo_body_type,
clo_colour,
clo_engineCC,
clo_weight,
incl_identity_card,
clo_client_district,
inag_agent_code,

clo_car_type,
clo_breakdown_accident
HAVING 
clo_prepared <> 1
ORDER BY inpol_policy_serial desc
";
$result = $syn->query($sql);
$todayDateTime = date('Y-m-d G:i:s');
$totalCoverNotesInserted = 0;
$totalPoliciesDeleted = 0;
while ($cvn = $syn->fetch_assoc($result)){

    //1. Check if the cover note already exists on extranet to choose the latest one to use
    $checkSql = 'SELECT * FROM es_rescueline_vehicles WHERE esrsc_registration = "'.$cvn['initm_item_code'].'"';
    $checkResult = $extranet->query($checkSql);
    $fetchedData = $checkResult->fetch_assoc();
    //init
    $insertNewRecord = true;
    $deleteOnlineRecord = false;

    if ($checkResult->num_rows > 0){

        //init
        $insertNewRecord = true; //unless one of the validations makes it false
        $deleteOnlineRecord = true;//unless one of the validations makes it false
        //do validations. if any validation is true then the cv is discarded. if not then its uploaded and the one online gets removed.
        //1. Check if this cover note has a starting date before the online one
        if ($db->compare2dates($fetchedData['esrsc_starting_date'],$cvn['inpol_starting_date'],'yyyy-mm-dd') == 1) {
            //echo "Cover note starts before online";
            $insertNewRecord = false;
            $deleteOnlineRecord = false;
        }
        //2. if cover note expiry date is before today and less than online
        if ($db->compare2dates($cvn['inpol_expiry_date'],date('Y-m-d'),'yyyy-mm-dd') == -1) {
            //echo "Cover note expiry is lower than today";
            $insertNewRecord = false;
            $deleteOnlineRecord = false;
        }

        //echo "<br>Found this vehicle online:".$cvn['initm_item_code']."<br>";

        //echo "Online dates:Starting:".$fetchedData['esrsc_starting_date']." Expiry: ".$fetchedData['esrsc_expiry_date'];
        //echo "<br>Local CV dates:".$cvn['inpol_starting_date']." Expiry:".$cvn['inpol_expiry_date'];
    }
    else {
        $insertNewRecord = true;
        $deleteOnlineRecord = false;
        //echo "Vehicle Not found: ".$cvn['initm_item_code']."<br>";
    }

    //echo "<br>Insert new: ".$insertNewRecord;
    //echo "<br>Delete online:".$deleteOnlineRecord."<br>";
    //echo "<hr>";
    //insert the new record/cover note
    if ($insertNewRecord == true){
        $totalCoverNotesInserted++;
        $sqlInsert = '
        INSERT INTO `es_rescueline_vehicles` 
                    SET
                    `esrsc_car_id` = "07-'.$cvn['inpol_policy_number'].'", 
                    `esrsc_registration` = "'.$cvn['initm_item_code'].'",
                    `esrsc_client_id` = "'.$cvn['incl_identity_card'].'",
                    `esrsc_client_district` = "'.$cvn['clo_client_district'].'",
                    `esrsc_policy_number` = "'.$cvn['inpol_policy_number'].'",
                    `esrsc_agent_code` = "'.$cvn['inag_agent_code'].'",
                    `esrsc_make` = "'.$cvn['clo_make'].'",
                    `esrsc_model` = "'.$cvn['clo_model'].'",
                    `esrsc_body_type` = "'.$cvn['clo_body_type'].'",
                    `esrsc_color` = "'.$cvn['clo_colour'].'",
                    `esrsc_engine_cc` = "'.$cvn['clo_engineCC'].'",
                    `esrsc_weight` = "'.$cvn['clo_weight'].'",
                    `esrsc_starting_date` = "'.$cvn['inpol_starting_date'].'",
                    `esrsc_period_starting_date` = "'.$cvn['inpol_period_starting_date'].'",
                    `esrsc_expiry_date` = "'.$cvn['inpol_expiry_date'].'",
                    `esrsc_price` = 0,
                    `esrsc_cover_type` = "'.$cvn['clo_car_type'].'",
                    `esrsc_home_city` = "'.$cvn['clo_client_district'].'",
                    `esrsc_road_assistance` = "'.$cvn['clo_road_assistance'].'",
                    `esrsc_accident_care` = "'.$cvn['clo_accident_care'].'",
                    `esrsc_is_cover_note` = 1,
                    `esrsc_created_on` = "'.$todayDateTime.'",
                    `esrsc_created_by` = 0,
                    `esrsc_last_update_on` = "'.$todayDateTime.'",
                    `esrsc_last_update_by` = 0';
        $extranet->query($sqlInsert);
    }
    //remove the existing one online
    if ($deleteOnlineRecord == true){
        $totalPoliciesDeleted++;
        $sqlDelete = '
        DELETE FROM es_rescueline_vehicles
        WHERE
        esrsc_resculine_vehicle_ID = '.$fetchedData['esrsc_resculine_vehicle_ID'];
        $extranet->query($sqlDelete);
    }
}



$time_elapsed_secs = microtime(true) - $startTime;
$log .= '<br>Total Cover Notes Inserted: '.$totalCoverNotesInserted;
$log .= '<br>Total Policies Deleted: '.$totalPoliciesDeleted;
$log .= "<br>Total Cover Notes Execution Time seconds: ".$time_elapsed_secs;



//insert Motor trade policies
$startTime = microtime(true);
$log .= '<br>Starting Import Motor Trade';
$totalMotorTrade = 0;
$sql = "
SELECT
inpol_policy_number,
'MTR'as clo_registration,
incl_identity_card,
IF incl_district = '' OR incl_district is null then incl_mail_district else incl_district endif as clo_client_district,
inpol_policy_number,
inag_agent_code,
inpol_starting_date,
inpol_period_starting_date,
inpol_expiry_date,
(case inpol_cover when 'A' then 'Third Party' when 'B' then 'Fire & Theft' when 'C' then 'Comprehensive' else '' end) as clo_car_type,
-- Breakdown and Accident
      (select LIST(distinct(case when b.inldg_claim_reserve_group in( 768 ) then 'R' /* Road Assistance */
        else 'A' /* Accident Care */
        end),'' order by(if b.inldg_claim_reserve_group in( 768 ) then 0 else 1 endif) asc)
        from inpolicyloadings as a
          join inloadings as b on a.inplg_loading_serial = b.inldg_loading_serial
          and b.inldg_claim_reserve_group in( 768,769 )  /* BreakDown */ /* Accident Care */
          and a.inplg_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial) as clo_breakdown_accident,
if clo_breakdown_accident in( 'RA','R' ) then '1' else '0' endif as clo_road_assistance, /*Road Assistance*/
if clo_breakdown_accident in( 'RA','A','R' ) then '1' else '0' endif as clo_accident_care, /*When road assistance exists then also accident exists*/
*
FROM
inpolicies
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyitems ON inpit_policy_serial = inpol_policy_serial
JOIN inagents ON inag_agent_serial = inpol_agent_serial
JOIN inclients ON incl_client_serial = inpol_client_serial
LEFT OUTER JOIN ccuserparameters ON 1=1
WHERE
inity_insurance_type = 'MTV'
AND inpol_process_status = 'N' 
AND COALESCE(ccusp_user_date, Today()) BETWEEN inpol_starting_date AND inpol_expiry_date
";
$result = $syn->query($sql);
while($mtv = $syn->fetch_assoc($result)){
    $totalMotorTrade++;
    $sqlInsert = '
        INSERT INTO `es_rescueline_vehicles` 
                    SET
                    `esrsc_car_id` = "07-'.$mtv['inpol_policy_number'].'", 
                    `esrsc_registration` = "'.$mtv['clo_registration'].'",
                    `esrsc_client_id` = "'.$mtv['incl_identity_card'].'",
                    `esrsc_client_district` = "'.$mtv['clo_client_district'].'",
                    `esrsc_policy_number` = "'.$mtv['inpol_policy_number'].'",
                    `esrsc_agent_code` = "'.$mtv['inag_agent_code'].'",
                    `esrsc_make` = "MTR",
                    `esrsc_model` = "MTR",
                    `esrsc_body_type` = "MTR",
                    `esrsc_color` = "MTR",
                    `esrsc_engine_cc` = "0",
                    `esrsc_weight` = "0",
                    `esrsc_starting_date` = "'.$mtv['inpol_starting_date'].'",
                    `esrsc_period_starting_date` = "'.$mtv['inpol_period_starting_date'].'",
                    `esrsc_expiry_date` = "'.$mtv['inpol_expiry_date'].'",
                    `esrsc_price` = 0,
                    `esrsc_cover_type` = "'.$mtv['clo_car_type'].'",
                    `esrsc_home_city` = "'.$mtv['clo_client_district'].'",
                    `esrsc_road_assistance` = "'.$mtv['clo_road_assistance'].'",
                    `esrsc_accident_care` = "'.$mtv['clo_accident_care'].'",
                    `esrsc_is_cover_note` = 0,
                    `esrsc_created_on` = "'.$todayDateTime.'",
                    `esrsc_created_by` = 0,
                    `esrsc_last_update_on` = "'.$todayDateTime.'",
                    `esrsc_last_update_by` = 0';
    $extranet->query($sqlInsert);
}

$time_elapsed_secs = microtime(true) - $startTime;
$log .= '<br>Total Motor Trade Inserted: '.$totalMotorTrade;
$db->update_log_file('import rescueline api',0,$log,'test');
echo $log;
