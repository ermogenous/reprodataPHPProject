<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 5:34 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");
include('policy_class.php');
include("reports/customers_due_collect.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Index";

$db->show_header();

$report = customers_due_collect(date('d/m/Y'),
    date('d/m/Y',mktime(0,0,0,date('m')+1,date('d'),date('Y'))));
echo $report;


$db->show_footer();
?>