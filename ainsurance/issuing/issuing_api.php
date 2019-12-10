<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/12/2019
 * Time: 9:19 π.μ.
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'Issuing API';
$db->apiGetReadHeaders();


/**
 * Check if issuing exists and returns the issuing row
 * @argument: compID -> Insurance Company ID
 * @argument: insType -> Insurance Type [Motor,Fire,PI,Medical etc]
 */
if ($_GET['section'] == 'findIssuing') {

    $sql = "SELECT 
            *
            FROM
            ina_issuing
            JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaiss_insurance_company_ID
            WHERE
            inainc_insurance_company_ID = ".$_GET['compID']."
            AND inaiss_insurance_type = '".$_GET['insType']."'";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'AInsurance Issuing API:none GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'AInsurance Issuing API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();