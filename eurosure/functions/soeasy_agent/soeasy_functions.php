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
    $sql = 'select essesid_validate_batch from es_soeasy_import_data ORDER BY essesid_validate_batch desc LIMIT 1';
    $res = $db->query_fetch($sql);
    $batchNumber = $res['essesid_validate_batch'];
    if ($batchNumber == ''){
        $batchNumber = 0;
    }
    $batchNumber++;


    //$batchNumber = 1;//delete this line

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
            WHERE essesid_status = 'IMPORT' 
            #AND essesid_soeasy_import_data_ID > 1290
            #AND essesid_soeasy_import_data_ID < 1295
            #AND essesid_soeasy_import_data_ID < 11
            ORDER BY essesid_soeasy_import_data_ID ASC";
    $result = $db->query($sql);


    while ($row = $db->fetch_assoc($result)){

        //init
        $valNewData = [];
        $valNewData['fld_validation_status'] = 'OK';

        $policyNumberSplit = explode("/",$row['Policy_Number']);
        $newRenewal = strpos($row['Policy_Number'],"/");
        if ($newRenewal === false){
            $newRenewal = 'new';
        }
        else {
            $newRenewal = 'renewal';
        }
        //check if cancellation
        if ($row['Policy_Refund'] == '1'){
            $newRenewal = 'cancel';
        }

        echo " Validating Policy ".$row['Policy_Number'];

        //update the record to process status VALIDATING
        $newData['fld_validation_status'] = 'VALIDATING';
        $newData['fld_validate_batch'] = $batchNumber;
        $db->db_tool_update_row('es_soeasy_import_data',$newData,'essesid_soeasy_import_data_ID = '.$row['essesid_soeasy_import_data_ID']
        ,$row['essesid_soeasy_import_data_ID'],'fld_', 'execute','essesid_');

        $checkID = 1;
        //start validations
        //1. check if the policy already exists in synthesis ====================================================================================================================1
        $res2 = $syn->query_fetch("
                SELECT inpol_policy_serial FROM inpolicies 
                WHERE inpol_policy_number = '".$policyNumberSplit[0]."'
                AND inpol_starting_date = '".convertDate($row['Policy_Start_Date'])."'
                AND inpol_expiry_date = '".convertDate($row['Policy_Expiry_Date'])."'
                AND inpol_agent_serial = ".$agentSerial);
        if ($res2['inpol_policy_serial'] > 0){
            $valNewData['fld_validation_result'] .= '['.$checkID.'] Policy already exists. Policy will be skipped';
            $valNewData['fld_validation_status'] = 'SKIP';
        }
        else {//if policy did not already been imported
            $checkID++;
            //2. Check if the package exists in the table BrokerPlanImport===========================================================================================================2
            if ($brokerPlanImport[$row['Policy_Plan_Code']] == '') {
                $valNewData['fld_validation_result'] .= "[".$checkID."] - No package found\n";
                $valNewData['fld_validation_status'] = 'ERROR';
            }

            $checkID++;
            //3. Check if the policy number is valid from a list
            if ($valNewData['fld_validation_status'] != 'ERROR') {
                $validList = ['MED', 'EUMO', 'EUEL', 'MOEU'];
                $policyInsType = explode("-", $policyNumberSplit[0]);
                $isInsTypeValid = false;
                foreach ($validList as $val) {
                    if ($val == $policyInsType[0]) {
                        $isInsTypeValid = true;
                    }
                }
                if ($isInsTypeValid == false) {
                    $valNewData['fld_validation_result'] .= "[" . $checkID . "] - Invalid Policy number prefix [" . $policyInsType[0] . "]\n";
                    $valNewData['fld_validation_status'] = 'ERROR';
                }
            }//if no other error occurred before

            $checkID++;
            //4. check if other policies exists
            //4.a If new then check only by policy number and do more validations
            if ($valNewData['fld_validation_status'] != 'ERROR') {
                if ($newRenewal == 'new') {

                    //3.a.1 if another policy exists that also covers that starting date then needs cancellation
                    $res3 = $syn->query_fetch("
                        SELECT inpol_policy_serial FROM inpolicies 
                        WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                        AND '" . convertDate($row['Policy_Start_Date']) . "' BETWEEN inpol_starting_date AND inpol_expiry_date
                        AND inpol_agent_serial = " . $agentSerial);
                    if ($res3['inpol_policy_serial'] > 0) {
                        $valNewData['fld_validation_result'] .= "[" . $checkID . ".a.1] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                            . " found within the policies coverage and will need to be cancelled to proceed.\n";
                        $valNewData['fld_validation_status'] = 'ERROR';
                    }

                    //3.a.2 if a normal policy with same policy number. then needs to be lapsed
                    $res3 = $syn->query_fetch("
                SELECT inpol_policy_serial FROM inpolicies 
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                AND inpol_status = 'N'
                AND inpol_agent_serial = " . $agentSerial);
                    if ($res3['inpol_policy_serial'] > 0) {
                        $valNewData['fld_validation_result'] .= "[" . $checkID . ".a.2] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                            . " found as normal. Need to lapse it first to continue\n";
                        $valNewData['fld_validation_status'] = 'ERROR';
                    }

                    //3.a.3 if motor then check if vehicle is not covered in another policy and not lapsed
                    if ($row['MOT_Registration_Number'] != '' && strlen($row['MOT_Registration_Number']) > 4) {
                        $res3 = $syn->query_fetch("
                    SELECT
                    *
                    FROM
                    inpolicies
                    JOIN inpolicyitems ON inpit_policy_serial = inpol_policy_serial
                    JOIN initems ON initm_item_serial = inpit_item_serial
                    WHERE
                    inpol_status = 'N'
                    AND initm_item_code = '" . strtoupper($row['MOT_Registration_Number']) . "'
                    ");
                        if ($res3['inpol_policy_serial'] > 0) {
                            $valNewData['fld_validation_result'] .= "[" . $checkID . ".a.3] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                                . " found as normal using the same registration number. Need to lapse it first to continue\n";
                            $valNewData['fld_validation_status'] = 'ERROR';
                        }
                    }


                } else {//RENEWALS
                    //3.b.1 First check if there is a policy to renew
                    $renewalPol = $syn->query_fetch("
                SELECT inpol_policy_serial,inpol_expiry_date FROM inpolicies 
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                AND inpol_status = 'N'
                AND inpol_agent_serial = " . $agentSerial);
                    if ($renewalPol['inpol_policy_serial'] == '' || $renewalPol['inpol_policy_serial'] == 0) {
                        $valNewData['fld_validation_result'] .= "[" . $checkID . ".b.1] Policy[Renewal] cannot find a policy to renew\n";
                        $valNewData['fld_validation_status'] = 'ERROR';
                    }

                    //3.b.1 if the date of the policy found is not inpol_expiry+1 with policy start
                    //echo "<br>Expiry:".$renewalPol['inpol_expiry_date']." <br>New Date:".addOneDayIntoDate($renewalPol['inpol_expiry_date'])." <br>With:".convertDate($row['Policy_Start_Date']);
                    if (addOneDayIntoDate($renewalPol['inpol_expiry_date']) != convertDate($row['Policy_Start_Date'])) {
                        $valNewData['fld_validation_result'] .= "[" . $checkID
                            . ".b.1] Policy[Renewal] inpolicy expiry +1 does not equal with starting. Cannot be inserted as renewal. Actions needed\n";
                        $valNewData['fld_validation_status'] = 'ERROR';
                    }

                }
            }//if no other error occurred before


        }//if policy does not already exists


        //end of policy
        //update the records process status to Validated
        //if error is found then keep this record as IMPORT so it can be validated again
        $valNewData['fld_status'] = 'VALIDATED';
        if ($valNewData['fld_validation_status'] == 'ERROR'){
            $valNewData['fld_status'] = 'IMPORT';
        }

        //$valNewData['fld_status'] = 'IMPORT'; //DELETE THIS LINE
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

function addOneDayIntoDate($date){
    $date = convertDate($date);
    return date('Y-m-d', strtotime($date . ' +1 day'));
}

function checkNewPolicy($row){
    global $db;

}

function checkRenewPolicy($row){
    global $db;
}

function checkCancelPolicy($row){
    global $db;
}