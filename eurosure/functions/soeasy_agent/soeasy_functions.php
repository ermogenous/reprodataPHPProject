<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 14/05/2020
 * Time: 14:52
 */

function fix_field_name($fieldName){

    $fixed = str_replace(" ","_",$fieldName);
    $fixed = str_replace("/","_",$fixed);
    $fixed = str_replace(".","",$fixed);
    $fixed = str_replace(",","",$fixed);
    $fixed = str_replace("__","_",$fixed);
    $fixed = str_replace("__","_",$fixed);
    $fixed = str_replace("_(String_delimited)","",$fixed);

    return $fixed;
}


function validateRecords(){
    global $db,$syn;
    $db->start_transaction();
    $agentSerial = 231;

    //first find the last batch number
    $sql = 'select essesid_batch from es_soeasy_import_data ORDER BY essesid_batch desc LIMIT 1';
    $res = $db->query_fetch($sql);
    $batchNumber = $res['essesid_batch'];
    if ($batchNumber == ''){
        $batchNumber = 0;
    }
    $batchNumber++;

    //delete this line
    $batchNumber = 1;

    echo "Batch Number to be used: ".$batchNumber." And check against agent serial ".$agentSerial."<br><hr>";

    //arrays to be used in validations
    //1. for validation 1
    $arr1Result = $syn->query("SELECT 
            bpi_plan_code, bpi_synthesis_insurance_type
            FROM BrokerPlanImport");
    while ($arr = $syn->fetch_assoc($arr1Result)){
        $brokerPlanImport[$arr['bpi_plan_code']] = $arr['bpi_synthesis_insurance_type'];
    }


    //get all the records
    $sql = "SELECT * FROM es_soeasy_import_data
            WHERE essesid_status = 'IMPORT' AND essesid_process_status = 'NEED_VALIDATION' 
            #AND essesid_soeasy_import_data_ID > 1617
            #AND essesid_soeasy_import_data_ID = 1292
            ORDER BY essesid_soeasy_import_data_ID ASC";
    $result = $db->query($sql);


    while ($row = $db->fetch_assoc($result)){

        $policyNumberSplit = explode("/",$row['Policy_Number']);

        echo " Validating Policy ".$row['Policy_Number'];

        //update the record to process status VALIDATING
        $newData['fld_process_status'] = 'VALIDATING';
        $newData['fld_batch'] = $batchNumber;
        $db->db_tool_update_row('es_soeasy_import_data',$newData,'essesid_soeasy_import_data_ID = '.$row['essesid_soeasy_import_data_ID']
        ,$row['essesid_soeasy_import_data_ID'],'fld_', 'execute','essesid_');

        $valNewData = [];
        //start validations
        //1. Check if the package exists in the table BrokerPlanImport===========================================================================================================1
        if ($brokerPlanImport[$row['Policy_Plan_Code']] == ''){
            $valNewData['fld_validation_result'] .= "[1] - No package found";
        }

        //2. check if the policy already exists in synthesis ====================================================================================================================2
        $res2 = $syn->query_fetch("
                SELECT inpol_policy_serial FROM inpolicies 
                WHERE inpol_policy_number = '".$policyNumberSplit[0]."'
                AND inpol_starting_date = '".convertDate($row['Policy_Start_Date'])."'
                AND inpol_agent_serial = ".$agentSerial);
        if ($res2['inpol_policy_serial'] > 0){
            $valNewData['fld_validation_result'] .= "[2] Policy already exists";
        }


        //end of policy
        //update the records process status to Validated
        $valNewData['fld_process_status'] = 'VALIDATED';
        $valNewData['fld_process_status'] = 'NEED_VALIDATION'; //DELETE THIS LINE
        $db->db_tool_update_row('es_soeasy_import_data',$valNewData,'essesid_soeasy_import_data_ID = '.$row['essesid_soeasy_import_data_ID']
            ,$row['essesid_soeasy_import_data_ID'],'fld_', 'execute','essesid_');

        if ($policyNumberSplit[1] > 0){
            echo "[RENEWAL]";
        }

        if ($valNewData['fld_validation_result'] != ''){
            echo ' <span class="alert-danger">'.$valNewData['fld_validation_result'].'</span>';
        }

        echo "<br>";
    }

    $db->commit_transaction();

}

function convertDate($date){
    global $db;
    return $db->convertDateFormat($date,'yyyy-mm-dd');
}