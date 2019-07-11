<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/2/2019
 * Time: 9:08 ΠΜ
 */

include("../include/main.php");
include("policy_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Item Delete";

if ( $_GET['lid'] == '' ) {
    header("Location ../../home.php");
    exit();
}

$db->start_transaction();
$policy = new Policy($_GET['lid']);
if ($policy->deletePolicy() == false){
    $db->generateSessionAlertError($policy->errorDescription);
    $db->rollback_transaction();
}
else {
    $db->generateSessionAlertSuccess('Policy Deleted Successfully.');
    $db->commit_transaction();
}

header ("Location: policies.php");
exit();
?>