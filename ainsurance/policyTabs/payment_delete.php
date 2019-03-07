<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/3/2019
 * Time: 4:23 ΜΜ
 */

include("../../include/main.php");
include("payments_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Payment Delete";

if ($_GET['pid'] == '' || $_GET['lid'] == '') {
    header("Location ../../home.php");
    exit();
}


$payment = new PolicyPayment($_GET['lid']);
if ($payment->deletePayment() == false){
    $db->generateSessionAlertError($payment->errorDescription);
}
else {
    $db->generateSessionAlertSuccess('Policy Payment Deleted Successfully.');
}

header ("Location: payments.php?pid=".$_GET['pid']);
exit();