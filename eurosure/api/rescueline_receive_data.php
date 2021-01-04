<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/12/2020
 * Time: 4:32 ΜΜ
 */

ini_set("memory_limit","1024M");
ini_set('max_execution_time', 600);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure vehicles Rescueline import extranet table';

$data = json_decode(file_get_contents('php://input'), true);

//$db->update_log_file('import rescueline api',0,'import rescueline','test');


//first clear the table
$sql = 'TRUNCATE es_rescueline_vehicles';
$db->query($sql);
$log = '';
foreach($data as $value){


    //print_r($value);

    $sql = "INSERT INTO es_rescueline_vehicles
        SET 
        esrsc_registration = '".$value['sp_registration_num']."',
        esrsc_make = '".$value['sp_make']."',
        esrsc_model = '".$value['sp_model']."',
        esrsc_body_type = '".$value['sp_body_type']."',
        esrsc_color = '".$value['sp_colour']."',
        esrsc_engine_cc = '".$value['sp_engineCC']."',
        esrsc_weight = '".$value['sp_weight']."',
        esrsc_starting_date = '".$value['sp_begindate']."',
        esrsc_period_starting_date = '".$value['sp_firstdate']."',
        esrsc_expiry_date = '".$value['sp_expireddate']."',
        esrsc_price = '".$value['sp_price']."',
        esrsc_cover_type = '".$value['sp_car_type']."',
        esrsc_breakdown = '".$value['sp_Breakdown']."',
        esrsc_accident = '".$value['sp_Accident']."',
        esrsc_home_city = '".$value['sp_city_home']."';
        ";
    $db->query($sql);
    //echo $sql."<br><br>\n\n";

    //$db->db_tool_insert_row('es_rescueline_vehicles',$newRow,'esrsc_',0,'esrsc_','execute');
    $output = "Insert: ".$value['sp_registration_num']."<br>";
    echo $output;
    $log .= $output."\n";
}

$db->update_log_file('import rescueline api',0,$log,'test');
