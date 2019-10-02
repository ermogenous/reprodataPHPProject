<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/9/2019
 * Time: 11:19 ΜΜ
 */


include("../include/main.php");
$db = new Main();

$db->check_restriction_area('delete');

if ($_GET["lid"] != "") {
    $db->db_tool_delete_row('vitamins',$_GET["lid"],"`vit_vitamin_ID` = ".$_GET["lid"]);
    $db->generateSessionDismissSuccess('Vitamin Record Deleted.');
    header("Location: vitamins.php");
    exit();
}
else {
    header("Location vitamins.php");
    exit();
}