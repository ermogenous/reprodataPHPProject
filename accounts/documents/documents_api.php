<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/7/2019
 * Time: 2:26 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->admin_title = 'Accounts Documents API';

$db->apiGetReadHeaders();

if ($_GET['section'] == 'validateDocCode') {

    $db->working_section = 'Documents API: validateDocCode';

    $sql = "SELECT COUNT(*) as clo_total FROM ac_documents WHERE acdoc_code = '" . $_GET["value"] . "'";
    $data = $db->query_fetch($sql);

    $db->update_log_file_custom($sql, 'Documents API:validateDocCode');
}
else if ($_GET['section'] == 'searchDocuments') {

    $db->working_section = 'Documents API: searchDocuments';

    $sql = "SELECT 
            acdoc_code as document_code
            ,CONCAT(acdoc_code,' - ',acdoc_name) as label
            ,acdoc_document_ID as value
            ,ac_documents.* 
            FROM ac_documents 
            WHERE 
            acdoc_code LIKE '%" . $_GET["term"] . "%'
            OR acdoc_name LIKE '%" . $_GET["term"] . "%'
            ";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){
        
        //generate last number used
        $row['clo_last_number_used'] = $db->buildNumber($row['acdoc_number_prefix'], $row['acdoc_number_leading_zeros'], $row['acdoc_number_last_used']);
        
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Documents API:searchDocuments');
}
else if ($_GET['section'] == 'getFirstDocumentByCode') {

    $db->working_section = 'Documents API: getFirstDocumentByCode';

    $sql = "SELECT 
            acdoc_code as document_code
            ,CONCAT(acdoc_code,' - ',acdoc_name) as label
            ,acdoc_document_ID as value
            ,ac_documents.* 
            FROM ac_documents WHERE acdoc_code LIKE '" . $_GET["term"] . "%' LIMIT 1";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){

        //generate last number used
        $row['clo_last_number_used'] = $db->buildNumber($row['acdoc_number_prefix'], $row['acdoc_number_leading_zeros'], $row['acdoc_number_last_used']);

        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Documents API:getFirstDocumentByCode');
}
else {
    $db->update_log_file_custom('NONE', 'Documents API:none');
}

echo json_encode($data);
exit();