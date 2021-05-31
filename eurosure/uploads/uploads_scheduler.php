<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 21/5/2021
 * Time: 10:50 π.μ.
 */

ini_set('max_execution_time', 1800);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../lib/odbccon.php');


$db = new Main(0);
$db->admin_title = "Eurosure - Uploads - Scheduler";
//This file is executed every hour so no need to control the executions

$sybase = new ODBCCON();

//upload the data for the live statistics
include('send_gross_written_premium.php');

