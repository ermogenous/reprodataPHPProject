<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 5/8/2021
 * Time: 6:03 μ.μ.
 */

include("../include/main.php");
include("sms_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "SMS Send";

if ($_GET['lid'] == '') {
    header("Location: sms.php");
    exit();
}

$sms = new ME_SMS();
$sms->sendSMS($_GET['lid']);
//if ($sms->error == true){
//}
header("Location: sms.php");
exit();
