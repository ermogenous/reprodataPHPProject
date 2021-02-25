<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 4:59 μ.μ.
 */

/*
 * DELETE THIS FILE. NOT NECESSARY
 * This file sits on extranet
 * gets as GET value the last id (esoin_incident_id@es_odyky_incidents) and returns as json
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1200);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure return the latests odyky incidents';
$db->update_log_file($db->working_section,0,
    $db->working_section
    ,$db->working_section);


