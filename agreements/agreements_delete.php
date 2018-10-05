<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/9/2018
 * Time: 7:31 ΜΜ
 */

include("../include/main.php");
include("agreements_functions.php");
$db = new Main();
$db->admin_title = "Agreements Modify";
$db->check_restriction_area('insert');

$db->working_section = 'Agreements Delete Start';

if ($_GET['lid'] == '') {
    header("Location: agreements.php");
    exit();
}

$data = $db->query_fetch("SELECT * FROM agreements WHERE agr_agreement_ID = ".$_GET['lid']);
if ($data['agr_agreement_ID'] > 0){

    $agr = new Agreements($_GET["lid"]);
    $result = $agr->deleteAgreement();

    if ($result == true){
        $db->generateAlertSuccess('Agreement #'.$_GET['lid']." was deleted successfully");
        header("Location: agreements.php");
        exit();
    }
    else {
        $db->generateAlertError($agr->errorDescription);
        header("Location: agreements.php");
        exit();
    }

}else {
    header("Location: agreements.php");
    exit();
}