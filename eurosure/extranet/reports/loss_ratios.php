<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 28/5/2021
 * Time: 12:05 μ.μ.
 */



$db = new Main(1);
$db->admin_title = "Eurosure - Extranet Reports - Loss Ratio";

//$db->show_header();
$db->show_empty_header();

$lang = 'ENG';
$year = date('Y');
$period = date('m');
//echo $year . "/" . $period;
