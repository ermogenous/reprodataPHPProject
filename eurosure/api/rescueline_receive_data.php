<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/12/2020
 * Time: 4:32 ΜΜ
 */

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure vehicles Rescueline import extranet table';



$db->update_log_file('import recueline api',0,'import recueline',print_r($_POST,true));


print_r($_POST);
