<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/2/2019
 * Time: 8:19 ΜΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Agents API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'agent_commission_types_insurance_companies') {

    $sql = "SELECT 
              inainc_insurance_company_ID as value, 
              CONCAT(inainc_code, ' ', inainc_name) as label,
              inainc_status as clo_status
              FROM agent_commission_types
              JOIN ina_insurance_companies ON agcmt_insurance_company_ID = inainc_insurance_company_ID 
              WHERE 
              agcmt_agent_ID = '".$_GET['agent']."'
              GROUP BY
              inainc_insurance_company_ID, inainc_code, inainc_name, inainc_status
	          LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}
else if ($_GET['section'] == 'agent_commission_types_policy_types') {

    $sql = "SELECT 
              inapot_policy_type_ID as value, 
              CONCAT(inapot_code, ' ', inapot_name) as label,
              inapot_status as clo_status
              FROM agent_commission_types
              JOIN ina_policy_types ON inapot_policy_type_ID = agcmt_policy_type_ID 
              WHERE 
              agcmt_insurance_company_ID = '".$_GET['inscompany']."'
              AND agcmt_agent_ID = '".$_GET['agent']."'
	          LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();