<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/4/2019
 * Time: 3:12 ΜΜ
 */


include("../../include/main.php");
include("../../include/tables.php");
$db = new Main();


if ($_GET['lid'] == ''){
    header("Location: underwriters.php");
    exit();
}

//check if this underwriter has policies

$sql = 'SELECT COUNT(*)as clo_total_policies FROM ina_policies WHERE inapol_underwriter_ID = '.$_GET['lid'];
$res = $db->query_fetch($sql);

if ($res['clo_total_policies'] > 0){
    $db->generateSessionAlertError('Cannot delete this underwriter. Found policies connected');
    header("Location: underwriters.php");
    exit();
}
else {
    $db->db_tool_delete_row('ina_underwriters',$_GET['lid'],'inaund_underwriter_ID = '.$_GET['lid']);
    $db->generateSessionAlertSuccess('Underwriter Deleted Successfully');
    header("Location: underwriters.php");
    exit();
}
