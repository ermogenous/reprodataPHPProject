<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12-Aug-18
 * Time: 10:05 AM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Manufacturers Modify";

$db->check_restriction_area('delete');

if ($_GET["lid"] == ''){
    header("Location: relations.php");
    exit();
}

//first check if there is any records being used
//check in products
$sql = 'SELECT * FROM products WHERE prd_manufacturer_ID = '.$_GET['lid'];
$prdResult = $db->query($sql);
$totalErrors = 0;
while ($prd = $db->fetch_assoc($prdResult)){
    $totalErrors++;
    $prdNames .= '<br>['.$prd['prd_product_ID'].'] - '.$prd['prd_name'];
}

if ($totalErrors > 0){

    $prdNames = $db->remove_last_char($prdNames);
    $db->generateAlertError('Cannot delete. Used in products '.$prdNames.'<br><br><a href="manufacturers.php">Go back</a>');

    $db->show_header();
    $db->show_footer();

}
else {
    $db->db_tool_delete_row('manufacturers',$_GET['lid'],'mnf_manufacturer_ID = '.$_GET['lid']);
    $db->generateSessionDismissSuccess('Manufacturer Deleted.');
    header('Location: manufacturers.php');
    exit();
}