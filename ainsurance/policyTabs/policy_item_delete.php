<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 1/2/2019
 * Time: 9:48 ΠΜ
 */

include("../../include/main.php");
include("../policy_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Item Delete";

if ($_GET['pid'] == '' || $_GET['lid'] == '' || $_GET['type'] == '') {
    header("Location ../../home.php");
    exit();
}


$policy = new Policy($_GET['pid']);
if ($policy->deletePolicyItem($_GET['lid']) == false){
    $db->generateSessionAlertError($policy->errorDescription);
}
else {
    $db->generateSessionAlertSuccess('Policy Items Deleted Successfully.');
}

header ("Location: policy_items.php?pid=".$_GET['pid']."&type=".$_GET['type']);
exit();

?>