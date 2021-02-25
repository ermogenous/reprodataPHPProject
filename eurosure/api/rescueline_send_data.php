<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 1/12/2020
 * Time: 4:49 ΜΜ
 */
$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1200);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure vehicles Rescueline update extranet table';

$log = 'Starting Extranet Rescueline Vehicle Update'.PHP_EOL;

//step 1 collect the data from sybase
$syn = new ODBCCON();
$sql = "
SELECT
sp_car_id,
sp_registration_num,
incl_identity_card,
inpol_policy_number,
sp_make,
sp_model,
sp_body_type,
sp_colour,
sp_engineCC,
sp_weight,
sp_firstdate,
sp_expireddate,
sp_price,
sp_Breakdown,
sp_Accident,
sp_car_type,
sp_begindate,
sp_city_home
FROM
sp_rescueline_export('".date("Y-m-d")."','Y','N')
JOIN inpolicies on inpol_policy_serial = sp_policy_serial
JOIN inclients on incl_client_serial = inpol_client_serial
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
while ($row = $syn->fetch_assoc($result)){
    $i++;
    $totalVehicles++;
    $sql .= "
        (
        '".$row['sp_car_id']."',
        '".$row['sp_registration_num']."',
        '".$row['incl_identity_card']."',
        '".$row['inpol_policy_number']."',
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
        '".$row['sp_Breakdown']."',
        '".$row['sp_Accident']."',
        '".$row['sp_city_home']."',
        0,
        '".$createdOn."',
        '0',
        '".$createdOn."',
        '0'
        )".PHP_EOL.",";
    //echo $row['sp_registration_num']." ";
    //do it per 100 to save time
    if ($i > 50){

        $sql = '
        INSERT INTO `es_rescueline_vehicles` 
                    (
                    `esrsc_car_id`,
                    `esrsc_registration`,
                    `esrsc_client_id`,
                    `esrsc_policy_number`,
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
                    `esrsc_breakdown`, 
                    `esrsc_accident`, 
                    `esrsc_home_city`, 
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

$log .= '<br>Total rows found: '.$totalVehicles.PHP_EOL;
$time_elapsed_secs = microtime(true) - $startTime;
$log .= '<br>Total Execution Seconds: '.$time_elapsed_secs;
$db->update_log_file('import rescueline api',0,$log,'test');
echo $log;
$time_elapsed_secs = microtime(true) - $startTime;
echo "<br>Total Execution Time seconds: ".$time_elapsed_secs;
