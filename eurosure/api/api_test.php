<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 10:47 π.μ.
 */

include("../../include/main.php");
$db = new Main(0);
$db->working_section = 'Eurosure Test API';

$db->update_log_file('TEST API',0,'TEST API','TEST API');
