<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 29/5/2021
 * Time: 9:52 π.μ.
 */

ini_set('max_execution_time', 1800);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../lib/odbccon.php');


$db = new Main(0);
$db->admin_title = "Eurosure - Uploads - Scheduler";
//This file is executed every day so no need to control the executions

$sybase = new ODBCCON();

//upload the data for the online reports loss ratio
echo "Send report Loss Ratio";
//include('send_report_loss_ratio.php');
echo "<hr>";
//upload data for report claims
echo "Send report claims";
include('send_report_claims.php');
echo "<hr>";
echo "Send report gross written premium";
//include('send_gross_written_premium.php');
echo "<hr>";

