<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 6/4/2021
 * Time: 1:19 μ.μ.
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1800);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure Send Odyky Export File to emails';
$log = $db->working_section.PHP_EOL;

$syn = new ODBCCON();

$sql = "call sp_Road_Assistance_Export_Monthly(null)";
$log.='Starting Export'.PHP_EOL;
$syn->query($sql);

$time_elapsed_secs = microtime(true) - $startTime;
$log .= 'Finished. Time in seconds:'.$time_elapsed_secs;

$db->update_log_file('Email Odyky Export File',0,$log,'');
