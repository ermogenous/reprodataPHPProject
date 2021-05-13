<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 30/3/2021
 * Time: 9:10 π.μ.
 */


/*
 * SITS ON INTRANET
 * Uses the search incidents by date range of odyky to verify that extranet has all the incidents
 * Everyime the have an incident the inform the extranet but sometimes they dont
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1800);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure verify extranet that has the latests odyky incidents';
$log = 'Starting Intranet Verify latest odyky incidents'.PHP_EOL;

//connect to extranet
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('import rescueline api',0,$log,'');
    exit();
}


//retrieve all the incidents based on date range
//always use from yesterday to today
//$startDate = '2021-02-28';
//$endDate = '2021-03-31';
$startDate = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-3,date('Y')   ));
$endDate = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y')   ));

//echo $startDate." -> ".$endDate;exit();

$log .= "<br>StartDate:".$startDate." EndDate:".$endDate;
$ch = curl_init();
// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
// in most cases, you should set it to true
$url = 'https://portal.odyky.com/webservices/eurosure/search_by_date.json?user=eurosure&pass=Tt04U17paE7WSJvNwFFz&start='.$startDate."&end=".$endDate;
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$allData = json_decode(curl_exec($ch));
curl_close($ch);

foreach ($allData as $incident){

    $incidentID = $incident->Incident->incident_id;
    $registration = $incident->Incident->vehicle_registration;
    $acceptedDate = $incident->Incident->accepted_at;
    $log .= "\n<br>";
    $log .= $incidentID." ".$registration." Accepted at:".$acceptedDate;

    //print_r($incident);

    //check if this incident already exists in extranet. If not create it
    $sql = 'SELECT * FROM es_odyky_incidents WHERE esoin_odyky_incident_id = '.$incidentID;
    $result = $extranet->query($sql);
    $resultData = $result->fetch_assoc();
    if ($resultData['esoin_incident_id'] > 0){
        //incident already exists on extranet
        $log .= " -> Already Exists";
    }
    else {
        $log .= " -> Does not exists";
        //create it by calling the extranet api
        $ch = curl_init();
        $url = 'http://www.eurosure.net/eurosure/api/new_odyky_incident.php?incident_id='.$incidentID.'&usr=odyky_usr&psw=odod-21_aa(36^';
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $createResult = json_decode(curl_exec($ch));
        curl_close($ch);
        $log .= " Created";
    }


}

$db->update_log_file('import rescueline api',0,$log,'test');
echo $log;
//print_r($allData);
