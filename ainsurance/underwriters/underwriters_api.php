<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/6/2019
 * Time: 1:10 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'UnderWriters API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'underwriter_commission_types_insurance_companies') {

    $sql = "SELECT
              inainc_insurance_company_ID as value, 
              inainc_name as label,
              inainc_status as clo_status
              FROM 
              ina_underwriter_companies
              JOIN ina_underwriters ON inaund_underwriter_ID = inaunc_underwriter_ID
              JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaunc_insurance_company_ID
              WHERE
              inaunc_status = 'Active' AND
              inaund_underwriter_ID = ".$_GET['underwriter']."
              LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:underwriter_commission_types_insurance_companies GET:'.print_r($_GET,true));
}
else if ($_GET['section'] == 'agent_commission_types_policy_types') {

    //get the underwriter to see which types are available
    $sqlTypes = "SELECT
            *
            FROM
            ina_underwriters
            WHERE
            inaund_underwriter_ID = '".$_GET['underwriter']."'";
    $undData = $db->query_fetch($sqlTypes);

    //print_r($undData);

    //bring the insurance company to see which types ara available
    $sqlInsComp = "SELECT
            *
            FROM
            ina_insurance_companies
            JOIN ina_underwriter_companies ON inaunc_insurance_company_ID = inainc_insurance_company_ID
            WHERE
            inainc_insurance_company_ID = '".$_GET['inscompany']."'
            AND inaunc_underwriter_ID = '".$_GET['underwriter']."'";
    $compData = $db->query_fetch($sqlInsComp);
    //print_r($compData);

    if ($undData['inaund_use_motor'] == 1 && $compData['inainc_use_motor']) {
        $newData['value'] = 'Motor';
        $newData['label'] = 'Motor';
        $data[] = $newData;
    }
    if ($undData['inaund_use_fire'] == 1 && $compData['inainc_use_fire']) {
        $newData['value'] = 'Fire';
        $newData['label'] = 'Fire';
        $data[] = $newData;
    }
    if ($undData['inaund_use_pa'] == 1 && $compData['inainc_use_pa']) {
        $newData['value'] = 'PA';
        $newData['label'] = 'Personal Accident';
        $data[] = $newData;
    }
    if ($undData['inaund_use_el'] == 1 && $compData['inainc_use_el']) {
        $newData['value'] = 'EL';
        $newData['label'] = 'Employers Liability';
        $data[] = $newData;
    }
    if ($undData['inaund_use_pi'] == 1 && $compData['inainc_use_pi']) {
        $newData['value'] = 'PI';
        $newData['label'] = 'Professional Indemnity';
        $data[] = $newData;
    }
    if ($undData['inaund_use_pl'] == 1 && $compData['inainc_use_pl']) {
        $newData['value'] = 'PL';
        $newData['label'] = 'Public Liability';
        $data[] = $newData;
    }
    if ($undData['inaund_use_medical'] == 1 && $compData['inainc_use_medical']) {
        $newData['value'] = 'Medical';
        $newData['label'] = 'Medical';
        $data[] = $newData;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:agent_commission_types_policy_types GET:'.print_r($_GET,true).'\n\n'.$sqlTypes.'\n\n'.$sqlInsComp);
}
else {
    $db->update_log_file_custom('NONE', 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();