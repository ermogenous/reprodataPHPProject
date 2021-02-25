<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 23/2/2021
 * Time: 5:36 μ.μ.
 */


include("../../include/main.php");
$db = new Main(0);
$db->working_section = 'Eurosure Get New Incident from Odyky API';

$data = json_decode(file_get_contents('php://input'), true);

$db->update_log_file('Odyky New incident api',0,'import rescueline','test');
