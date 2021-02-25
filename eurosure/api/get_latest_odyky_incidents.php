<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 4:52 μ.μ.
 */

/*
 * SITS ON INTRANET
 * checks the extranet if there is any new incidents in the table es_odyky_incidents
 * saves in the settings table the last id esoin_incident_id found
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1200);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure check extranet to get the latests odyky incidents';
$db->update_log_file('Eurosure check extranet to get the latests odyky incidents',0,
    'Eurosure check extranet to get the latests odyky incidents'
    ,'Eurosure check extranet to get the latests odyky incidents');
$log = 'Starting Intranet Get latest odyky incidents'.PHP_EOL;

//connect to extranet
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('import rescueline api',0,$log,'');
    exit();
}
//find the last incident id (primary of the table es_odyky_incidents) saved in the settings table
$lastIncidentID = $db->get_setting('eurosure_last_odyky_incident');

//now find on extranet any new incidents where the primary key is higher
//$sql = 'SELECT * FROM es_odyky_incidents WHERE esoin_incident_id > '.$lastIncidentID;
$sql = 'SELECT * FROM es_odyky_incidents WHERE esoin_processed = 0';

$result = $extranet->query($sql);
$lastID = 0;
while ($row = $result->fetch_assoc()){
    $lastID = $row['esoin_incident_id'];
    //connect to odyky api to get the information and files for this incident
    getOdykyFiles($row['esoin_odyky_incident_id']);

    //update extranet that this record has been processed
    $sql = 'UPDATE es_odyky_incidents SET esoin_processed = 1 WHERE esoin_incident_id = '.$row['esoin_incident_id'];
    //$extranet->query($sql);

}

//update settings
if ($lastID > $lastIncidentID){
    //temp disable
    //$db->update_setting('eurosure_last_odyky_incident',$lastID);
}


function getOdykyFiles($odykyID){

    $ch = curl_init();
// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
// in most cases, you should set it to true
    $url = 'https://portal.odyky.com/webservices/eurosure/search_documents_by_id.json?user=eurosure&pass=Tt04U17paE7WSJvNwFFz&incident='.$odykyID;
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    $obj = json_decode($result);
    //echo $obj->access_token;
    print_r($obj);

}
