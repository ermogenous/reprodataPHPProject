<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 5:19 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);


//first check if underwriter exists. if not logout and generate error
$sql = "SELECT * FROM ina_underwriters WHERE inaund_user_ID = ".$db->user_data['usr_users_ID'];
$undCheck = $db->query_fetch($sql);
if ($undCheck['inaund_underwriter_ID'] == ''){
    $db->generateSessionAlertError('No underwriter found for this user.');
    header("Location: ".$main["site_url"]."/login.php?action=logout");
    exit();
}



header("Location: ainsurance/policies.php");
exit();