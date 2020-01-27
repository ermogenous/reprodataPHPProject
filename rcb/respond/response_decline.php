<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 27/1/2020
 * Time: 10:35 π.μ.
 */

include("../../include/main.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "RCB Payment response decline";

include('../rcb_bank_class.php');
$rcb = new rcbConnection();
$rcb->getResponseDecline($_GET['ID']);
