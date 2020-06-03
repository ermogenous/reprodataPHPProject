<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/11/2019
 * Time: 11:47 ΠΜ
 */

include("../../include/main.php");
include("insurance_company_class.php");
$db = new Main();
$db->admin_title = "AInsurance Company Modify";

if ($_GET['lid'] == ''){
    $db->generateSessionAlertError('Must provide insurance company id.');
    header("Location: insurance_companies.php");
    exit();
}

$insComp = new InsuranceCompany($_GET['lid']);

if ($insComp->delete() == true){
    $db->generateSessionAlertSuccess('Insurance Company Deleted Successfully.');
    header("Location: insurance_companies.php");
    exit();
}else {
    $db->generateSessionAlertError($insComp->errorDescription);
    header("Location: insurance_companies.php");
    exit();
}