<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2020
 * Time: 2:48 μ.μ.
 */

include("../include/main.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items Premium";

include('rcb_bank_class.php');


$db->show_header();

$rcb = new rcbConnection();
//$rcb->createOrder();
$rcb->testFunction();



$db->show_footer();