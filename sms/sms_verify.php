<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 31/8/2021
 * Time: 1:52 μ.μ.
 */


include("../include/main.php");
include("sms_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "SMS Verify";

if ($_GET['lid'] == '') {
    header("Location: sms.php");
    exit();
}

$sms = new ME_SMS();
$sms->verifySms($_GET['lid']);
if ($sms->error == true){
    $db->generateSessionAlertError($sms->errorDescription);
}
else {
    $db->generateSessionAlertSuccess('SMS Verified Successfully');
}
header("Location: sms.php");
exit();
