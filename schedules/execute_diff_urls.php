<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 10:58 π.μ.
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 2800);

//this file is executed by the windows task scheduler every 10 minutes. Write below the other files you want to execute
include("../include/main.php");
$db = new Main(0);
$db->working_section = 'Eurosure Test API';

$db->update_log_file('Execute Diff Urls file', 0, 'Execute Diff Urls file', 'Execute Diff Urls file');

/*
 * 1************************************1****************************1***************************1*********************1
 */
//Update extranet with vehicles for odyky api
$lastExecute = $db->get_setting('eurosure_send_vehicles_extranet', 'value_date');
//execute this once a day after 18:00 hours
$today = (date('Y') * 10000) + (date('m') * 100) + date('d');
$lastExecuteParts = explode('-', explode(' ', $lastExecute)[0]);
$lastExecuteDay = ($lastExecuteParts[0] * 10000) + ($lastExecuteParts[1] * 100) + $lastExecuteParts[2];
//echo $today . " - " . $lastExecuteDay;
if ($today == $lastExecuteDay || $today < $lastExecuteDay) {
    //process already executed today
} else if ($today > $lastExecuteDay) {
    //needs to be executed.
    //check if the time is after 18:00
    if (date("G") > 15) {
        echo "execute";
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "http://126.0.0.13/intranet/eurosure/api/rescueline_send_data.php");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // grab URL and pass it to the browser
        curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
    }
}

/*
 * 2************************************2****************************2***************************2*********************2
 * Verifies that all the incidents in odyky exists in extranet
 */
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://126.0.0.13/intranet/eurosure/api/verify_odyky_incidents_by_day.php");
curl_setopt($ch, CURLOPT_HEADER, 0);
// grab URL and pass it to the browser
curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);


/*
 * 3************************************3****************************3***************************3*********************3
 * Downloads all the files from odyky
 */

$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://126.0.0.13/intranet/eurosure/api/get_latest_odyky_incidents.php");
curl_setopt($ch, CURLOPT_HEADER, 0);
// grab URL and pass it to the browser
curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);
