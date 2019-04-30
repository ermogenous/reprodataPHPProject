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
              FROM 
              ina_underwriter_companies
              JOIN ina_underwriters ON inaund_underwriter_ID = inaunc_underwriter_ID
              JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaunc_insurance_company_ID
              WHERE
              inaunc_status = 'Active' AND
              inaund_user_ID = ".$_GET['agent']."
              LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}
else if ($_GET['section'] == 'agent_commission_types_policy_types') {

    $sql = "SELECT
            *
            FROM
            ina_underwriters
            JOIN ina_underwriter_companies ON inaund_underwriter_ID = inaunc_underwriter_ID
            JOIN ina_insurance_companies ON inaunc_insurance_company_ID = inainc_insurance_company_ID
            WHERE
            inaund_user_ID = '".$_GET['agent']."'
            AND inainc_insurance_company_ID = ".$_GET['inscompany']."
            
	        LIMIT 0,25";

    $undData = $db->query_fetch($sql);
    if ($undData['inainc_use_motor'] == 1) {
        $newData['value'] = 'Motor';
        $newData['label'] = 'Motor';
        $data[] = $newData;
    }
    if ($undData['inainc_use_fire'] == 1) {
        $newData['value'] = 'Fire';
        $newData['label'] = 'Fire';
        $data[] = $newData;
    }
    if ($undData['inainc_use_pa'] == 1) {
        $newData['value'] = 'PA';
        $newData['label'] = 'Personal Accident';
        $data[] = $newData;
    }
    if ($undData['inainc_use_el'] == 1) {
        $newData['value'] = 'EL';
        $newData['label'] = 'Employers Liability';
        $data[] = $newData;
    }
    if ($undData['inainc_use_pi'] == 1) {
        $newData['value'] = 'PI';
        $newData['label'] = 'Professional Indemnity';
        $data[] = $newData;
    }
    if ($undData['inainc_use_pl'] == 1) {
        $newData['value'] = 'PL';
        $newData['label'] = 'Public Liability';
        $data[] = $newData;
    }
    if ($undData['inainc_use_medical'] == 1) {
        $newData['value'] = 'Medical';
        $newData['label'] = 'Medical';
        $data[] = $newData;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();