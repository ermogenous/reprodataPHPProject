<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/7/2019
 * Time: 12:50 ΠΜ
 */


include("../../include/main.php");
include("../policy_class.php");
$db = new Main(1);
$db->working_section = 'Policy Review API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'reviewPolicy') {

    sleep(1);
    $policy = new Policy($_GET['policyID']);
    $db->start_transaction();
    if ($policy->reviewPolicy() == true){
        $db->commit_transaction();
        $data['result'] = true;
        $data['resultDescription'] = 'Policy Reviewed Successfully';
    }
    else {
        $db->rollback_transaction();
        $data['result'] = false;
        $data['resultDescription'] = $policy->errorDescription;
    }

    $db->update_log_file_custom($sql, 'Policy Review API:reviewPolicy GET:' . print_r($_GET, true));
}
else if ($_GET['section'] == 'startNewBatch'){
    //find the last batch number
    $sql = 'SELECT MAX(inarev_batch_ID)as clo_last_batch FROM ina_review_batch';
    $lastBatch = $db->query_fetch($sql);
    $newBatch = $lastBatch['clo_last_batch'] + 1;

    $data['newBatch'] = $newBatch;
    $db->update_log_file_custom($sql, 'Policy Review API:startNewBatch('.$newBatch.') GET:' . print_r($_GET, true));
}
//creates new line into ina_review_batch
//batchID
//policyID
//result true/false
//resultDescription text
else if ($_GET['section'] == 'addLineToBatch'){

    $newData['batch_ID'] = $_GET['batchID'];
    $newData['policy_ID'] = $_GET['policyID'];
    $newData['user_ID'] = $db->user_data['usr_users_ID'];
    $newData['batch_date_time'] = date('Y-m-d G:i:s');
    if ($_GET['result'] == 'true'){
        $newData['result'] = 1;
    }
    else {
        $newData['result'] = 0;
    }
    $newData['result_description'] = $_GET['resultDescription'];
    
    $db->db_tool_insert_row('ina_review_batch',
        $newData,
        '',
        0,
        'inarev_');
    $data['result'] = true;

    $db->update_log_file_custom($sql, 'Policy Review API:addLineToBatch GET:' . print_r($_GET, true));
}
else {
    $db->update_log_file_custom('NONE', 'Policy Review API:none GET:' . print_r($_GET, true));
}

echo json_encode($data);
exit();