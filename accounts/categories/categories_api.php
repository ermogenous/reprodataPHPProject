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

if ($_GET['section'] == 'validateCategoryCode') {

    $sql = "SELECT COUNT(*)as clo_total FROM ac_categories WHERE accat_code = '" . $_GET["value"] . "'";
    $data = $db->query_fetch($sql);

    $db->update_log_file_custom($sql, 'Accounts Category API: validateCategoryCode');

}

else {
    $db->update_log_file_custom('NONE', 'Transaction API:none');
}


echo json_encode($data);
exit();