<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/4/2019
 * Time: 11:57 ΠΜ
 */

include("../include/main.php");
include('disc_class.php');

$db = new Main();
$db->admin_title = "LCS Disc Test Delete";

if ($_GET["lid"] == ''){
    header("Location:disc_list.php");
    exit();
}

$disc = new DiscTest($_GET['lid']);
if ($disc->deleteTest() == true){
    $db->generateSessionAlertSuccess('Disc Test marked as deleted succesfully.');
}
else {
    $db->generateSessionAlertError($disc->errorDescription);
}

header("Location:disc_list.php");
exit();