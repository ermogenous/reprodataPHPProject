<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/7/2019
 * Time: 2:23 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'Accounts Categories API';

$db->apiGetReadHeaders();


/**
 * value -> code to search for
 * exclude -> one record to exclude. itself
 */
if ($_GET['section'] == 'validateAccountTypeCode') {

    if ($_GET['exclude'] != ''){
        $exclude = "AND actpe_account_type_ID != '".$_GET['exclude']."'";
    }

    $sql = "SELECT COUNT(*)as clo_total FROM ac_account_types WHERE actpe_code = '" . $_GET["value"] . "' ".$exclude;
    $data = $db->query_fetch($sql);

    $db->update_log_file_custom($sql, 'Accounts Category API: validateAccountTypeCode');

}

else {
    $db->update_log_file_custom('NONE', 'Transaction API:none');
}


echo json_encode($data);
exit();