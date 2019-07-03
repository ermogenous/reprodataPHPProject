<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/7/2019
 * Time: 10:21 ΠΜ
 */

include("../include/main.php");
include("policy_class.php");
$db = new Main(1);
$db->working_section = 'Policy API';
$db->apiGetReadHeaders();


/**
 * @policyID
 */
if ($_GET['section'] == 'policy_num_of_items') {

    $sql = "
        SELECT
        COUNT(*)as clo_total_items
        FROM
        ina_policy_items
        WHERE
        inapit_policy_ID = ".$_GET['policyID'];
    $data = $db->query_fetch($sql);


    $db->update_log_file_custom($sql, 'Policy API:policy_num_of_items GET:'.print_r($_GET,true));
} /**
 * @policyNumber
 * @policyID -> exclude this policy id which is the one looking
 */
else if ($_GET['section'] == 'check_if_policy_number_exists'){

    $sql = "
        SELECT
        COUNT(*)as clo_total_policies
        FROM
        ina_policies
        WHERE
        inapol_underwriter_ID ".Policy::getAgentWhereClauseSql()."
        AND inapol_policy_number = '".$_GET['policyNumber']."'
        AND inapol_policy_ID != '".$_GET['policyID']."'
    ";
    $data = $db->query_fetch($sql);
    $db->update_log_file_custom($sql, 'Policy API:check_if_policy_number_exists GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Policy API:none GET:'.print_r($_GET,true));
}

echo json_encode($data);
exit();