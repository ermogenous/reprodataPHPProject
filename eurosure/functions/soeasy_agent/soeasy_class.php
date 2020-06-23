<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 29/05/2020
 * Time: 11:01
 */

class soeasyClass
{

    private $agentSerial = 231;
    private $brokerPlanImport = [];

    //this will be loaded from validateNew to be used in lapsePolicy
    private $policyNumberForLapse = '';


    function __construct()
    {
    }

    public function validateAllRecords()
    {
        global $db, $syn;
        $db->start_transaction();
        $agentSerial = 231;

        //first find the last validate batch number
        $sql = 'select MAX(essesid_validate_batch)as clo_last_validate_batch from es_soeasy_import_data';
        $res = $db->query_fetch($sql);
        $batchNumber = $res['clo_last_validate_batch'];
        if ($batchNumber == '') {
            $batchNumber = 0;
        }
        $batchNumber++;

        echo "Batch Number to be used: " . $batchNumber . " And check against agent serial " . $agentSerial . "<br><hr>";

        //get all the records
        $sql = "SELECT * FROM es_soeasy_import_data
            WHERE essesid_status = 'IMPORT' 
            #AND essesid_soeasy_import_data_ID > 1290
            #AND essesid_soeasy_import_data_ID < 1295
            #AND essesid_soeasy_import_data_ID < 11         
            #AND Policy_Number = 'MOEU-10009'
            ORDER BY essesid_soeasy_import_data_ID ASC";
        $allRecordsResult = $db->query($sql);


        while ($row = $db->fetch_assoc($allRecordsResult)) {
            //init
            $valNewData = [];
            $valNewData['fld_validation_status'] = 'OK';

            $policyNumberSplit = explode("/", $row['Policy_Number']);
            $policyType = strpos($row['Policy_Number'], "/");
            echo " Validating Policy " . $row['Policy_Number'];
            //first validate the policy number
            $result = $this->validatePolicyNumber($row['Policy_Number']);
            if ($result['validation_status'] == 'OK') {
                //proceed with the rest of the validations
                //check if cancellation
                $result = [];
                if ($row['Policy_Refund'] == '1') {
                    echo "[CANCELLATION]";
                    $result = $this->validateCancellation($row);
                } else if ($policyType === false) {
                    echo "[NEW]";
                    $result = $this->validateNew($row);
                } else {
                    echo "[RENEWAL]";
                    $result = $this->validateRenewal($row);
                }
            }
            //print_r($result);
            if ($result['validation_status'] == 'ERROR') {
                echo '<span class="alert-danger">[' . $result['validation_status'] . '] ' . $result['message'] . "</span>";
            } else if ($result['validation_status'] == 'SKIP') {
                echo '<span class="alert-warning">[' . $result['validation_status'] . '] ' . $result['message'] . "</span>";
            } else if ($result['validation_status'] == 'LAPSE') {
                echo '<span class="alert-warning">[' . $result['validation_status'] . '] ' . $result['message'] . "</span>";
                $valNewData['fld_lapse'] = 'LAPSE';
                $valNewData['fld_lapse_policy_ID'] = $result['policyLapseSerial'];
            } else {
                echo '<span class="alert-success">[' . $result['validation_status'] . '] ' . $result['message'] . "</span>";
            }
            $valNewData['fld_status'] = 'VALIDATED';
            $valNewData['fld_validation_status'] = $result['validation_status'];
            $valNewData['fld_validation_result'] = $result['message'];
            //in case of error reset the row so it can validate again next time
            if ($result['validation_status'] == 'ERROR') {
                $valNewData['fld_status'] = 'IMPORT';
            }
            //if record already has a validation batch then keep that
            if ($row['essesid_validate_batch'] > 0){
                //already exists then do replace
                $valNewData['fld_validate_batch'] = $row['essesid_validate_batch'];
            }
            else {
                $valNewData['fld_validate_batch'] = $batchNumber;
            }

            //$valNewData['fld_status'] = 'IMPORT'; //DELETE THIS LINE
            $db->db_tool_update_row('es_soeasy_import_data', $valNewData
                , 'essesid_soeasy_import_data_ID = ' . $row['essesid_soeasy_import_data_ID']
                , $row['essesid_soeasy_import_data_ID'], 'fld_', 'execute', 'essesid_');


            echo "<br>";

        }
        $db->commit_transaction();

    }

    private function validateCancellation($row)
    {
        global $db, $syn;
        $policyNumberSplit = explode("/", $row['Policy_Number']);
        $return = [];
        //1. check if the policy already exists in synthesis ====================================================================================================================1
        $res2 = [];
        $res2 = $syn->query_fetch("
                SELECT inpol_policy_serial,inpol_status,inped_phase_status,inped_process_status
                FROM inpolicies
                LEFT OUTER JOIN inpolicyendorsement ON inpol_policy_serial = inped_financial_policy_abs
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                //AND inpol_starting_date = '" . $this->convertDate($row['Policy_Start_Date']) . "'
                //AND inpol_expiry_date = '" . $this->convertDate($row['Policy_Expiry_Date']) . "'
                AND inpol_agent_serial = " . $this->agentSerial."
                ORDER BY
                inped_endorsement_serial DESC");
        if (@$res2['inpol_policy_serial'] > 0) {
            //1.a check if the policy is normal
            if ($res2['inped_phase_status'] == 'N') {
                $return['message'] = '';
                $return['validation_status'] = 'OK';
            } else {
                if ($res2['inped_process_status'] == 'C' && $res2['inped_phase_status'] == 'A'){
                    $return['message'] = " " . $row['MOT_Registration_Number'] . '[1.a] Policy [' . $res2['inpol_policy_serial'] . '] is already cancelled and posted [' . $res2['inped_phase_status'] . ']';
                    $return['validation_status'] = 'SKIP';
                }
                else if ($res2['inped_process_status'] == 'L' && $res2['inped_phase_status'] == 'A') {
                    $return['message'] = " " . $row['MOT_Registration_Number'] . '[1.a] Policy [' . $res2['inpol_policy_serial'] . '] Is lapsed and cannot be cancelled';
                    $return['validation_status'] = 'ERROR';
                }
                else {
                    $return['message'] = " " . $row['MOT_Registration_Number'] . '[1.a] Policy [' . $res2['inpol_policy_serial'] . '] is not normal [' . $res2['inped_phase_status'] . '] to cancel';
                    $return['validation_status'] = 'ERROR';
                }

            }

        } else {
            $return['message'] = " " . $row['MOT_Registration_Number'] . ' [1] Cannot find the policy to cancel';
            $return['validation_status'] = 'SKIP';
        }

        return $return;

    }

    private function validateNew($row)
    {
        global $db, $syn;
        $policyNumberSplit = explode("/", $row['Policy_Number']);
        $return = [];
        $return['message'] .= "";
        $return['validation_status'] = 'OK';
        //2. check if the policy already exists in synthesis ====================================================================================================================1
        $res2 = $syn->query_fetch("
                SELECT inpol_policy_serial FROM inpolicies 
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                AND inpol_starting_date = '" . $this->convertDate($row['Policy_Start_Date']) . "'
                AND inpol_expiry_date = '" . $this->convertDate($row['Policy_Expiry_Date']) . "'
                AND inpol_agent_serial = " . $this->agentSerial);
        if ($res2['inpol_policy_serial'] > 0) {
            $return['message'] .= '[2] Policy already exists. Policy will be skipped';
            $return['validation_status'] = 'SKIP';
            return $return;
        }

        //3. Check if the package exists in the table BrokerPlanImport===========================================================================================================2
        $this->loadBrokerPlanCodes();
        if ($this->brokerPlanImport[$row['Policy_Plan_Code']] == '') {
            $return['message'] .= "[3] - No package found";
            $return['validation_status'] = 'ERROR';
            return $return;
        }

        //4.a.1 if another policy with same policy number exists that also covers that starting date then needs cancellation
        $res3 = $syn->query_fetch("
                        SELECT inpol_policy_serial FROM inpolicies 
                        WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                        AND '" . $this->convertDate($row['Policy_Start_Date']) . "' BETWEEN inpol_starting_date AND inpol_expiry_date
                        AND inpol_agent_serial = " . $this->agentSerial);
        if ($res3['inpol_policy_serial'] > 0) {
            $return['message'] .= "[4.a.1] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                . " found within the policies coverage and will need to be cancelled to proceed.";
            $return['validation_status'] = 'ERROR';
            return $return;
        }

        //4.a.2 if a normal policy with same policy number. then needs to be lapsed
        $res3 = $syn->query_fetch("
                SELECT inpol_policy_serial, inpol_expiry_date, inpol_policy_number FROM inpolicies 
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                AND inpol_status = 'N'
                AND inpol_agent_serial = " . $this->agentSerial);
        if ($res3['inpol_policy_serial'] > 0) {
            //if policy expiry date is before today then need to lapse
            if ($db->compare2dates(date("dd/mm/YYYY"), $db->convertDateFormat($res3['inpol_expiry_date'], 'dd/mm/yyyy')) == 1) {
                $return['message'] .= "[4.a.2] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                    . " found as normal. Need to lapse it first to continue";
                $return['validation_status'] = 'LAPSE';
                $this->policyNumberForLapse = $res3['inpol_policy_number'];
                $return['policyLapseSerial'] = $res3['inpol_policy_serial'];
                return $return;
            } //if policy expiry date is after today then error.
            else {
                $return['message'] .= "[4.a.2] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                    . " found as normal. Need to lapse but its expiry date is later than today";
                $return['validation_status'] = 'ERROR';
                return $return;
            }
        }

        //4.a.3 if motor then check if vehicle is not covered in another policy and not lapsed
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
                if ($db->compare2dates(date("dd/mm/YYYY"), $db->convertDateFormat($res3['inpol_expiry_date'], 'dd/mm/yyyy')) == 1) {
                    $return['message'] .= "[4.a.3] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                        . " found as normal using the same registration number. Need to lapse it first to continue";
                    $return['validation_status'] = 'LAPSE';
                    $this->policyNumberForLapse = $res3['inpol_policy_number'];
                    $return['policyLapseSerial'] = $res3['inpol_policy_serial'];
                    return $return;
                } else {
                    $return['message'] .= "[4.a.3] Policy[NEW] with serial " . $res3['inpol_policy_serial']
                        . " found as normal using the same registration number. Need to lapse but its expiry date is later than today";
                    $return['validation_status'] = 'ERROR';
                    return $return;
                }


            }
        }
        //4.a.4 check if motor and if the starting date of this policy is already covered with the same registration
        if ($row['MOT_Registration_Number'] != '' && strlen($row['MOT_Registration_Number']) > 4) {
            $sql = "SELECT
                    *
                    FROM
                    inpolicies
                    JOIN inpolicyitems ON inpit_policy_serial = inpol_policy_serial
                    JOIN initems ON initm_item_serial = inpit_item_serial
                    WHERE
                    inpol_status IN ('N','A')
                    AND initm_item_code = '" . strtoupper($row['MOT_Registration_Number']) . "'
                    AND '" . $this->convertDate($row['Policy_Start_Date']) . "' BETWEEN inpol_starting_date AND inpol_expiry_date";
            $resultData = $syn->query_fetch($sql);
            if ($resultData['inpol_policy_serial'] > 0) {
                /*$return['message'] = 'Found policy '.$resultData['inpol_policy_number']." [".$resultData['inpol_policy_serial']."]"
                        ."D:".$db->convertDateToEU($resultData['inpol_starting_date'])." E:".$db->convertDateToEU($resultData['inpol_expiry_date'])
                        ." That has cover on the same dates. Either cancel that policy or change the starting of the import policy";
                $return['validation_status'] = 'ERROR';
                return $return;
                */
            }
        }

        return $return;
    }

    private function validateRenewal($row)
    {
        global $db, $syn;
        $policyNumberSplit = explode("/", $row['Policy_Number']);
        $return = [];
        $return['message'] .= "";
        $return['validation_status'] = 'OK';
        //2. check if the policy already exists in synthesis ====================================================================================================================1
        $res2 = $syn->query_fetch("
                SELECT inpol_policy_serial FROM inpolicies 
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                AND inpol_starting_date = '" . $this->convertDate($row['Policy_Start_Date']) . "'
                AND inpol_expiry_date = '" . $this->convertDate($row['Policy_Expiry_Date']) . "'
                AND inpol_agent_serial = " . $this->agentSerial);
        if ($res2['inpol_policy_serial'] > 0) {
            $return['message'] .= '[2] Policy already exists. Policy will be skipped';
            $return['validation_status'] = 'SKIP';
            return $return;
        }

        //3. Check if the package exists in the table BrokerPlanImport===========================================================================================================2
        $this->loadBrokerPlanCodes();
        if ($this->brokerPlanImport[$row['Policy_Plan_Code']] == '') {
            $return['message'] .= "[3] - No package found\n";
            $return['validation_status'] = 'ERROR';
            return $return;
        }

        //4.b.1 First check if there is a policy to renew
        $renewalPol = $syn->query_fetch("
                SELECT inpol_policy_serial,inpol_expiry_date FROM inpolicies 
                WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'
                AND inpol_status = 'N'
                AND inpol_agent_serial = " . $this->agentSerial);
        if ($renewalPol['inpol_policy_serial'] == '' || $renewalPol['inpol_policy_serial'] == 0) {
            $return['message'] .= "[4.b.1] Policy[Renewal] cannot find a policy to renew";
            $return['validation_status'] = 'ERROR';
            return $return;
        }

        //4.b.1 if the date of the policy found is not inpol_expiry+1 with policy start
        //echo "<br>Expiry:".$renewalPol['inpol_expiry_date']." <br>New Date:".addOneDayIntoDate($renewalPol['inpol_expiry_date'])." <br>With:".convertDate($row['Policy_Start_Date']);
        if (addOneDayIntoDate($renewalPol['inpol_expiry_date']) != convertDate($row['Policy_Start_Date'])) {
            $return['message'] .= "[4.b.1] Policy[Renewal] inpolicy expiry +1 does not equal with starting. Cannot be inserted as renewal. Actions needed";
            $return['validation_status'] = 'ERROR';
            return $return;
        }

        return $return;
    }

    private function loadBrokerPlanCodes()
    {
        global $syn;
        if (count($this->brokerPlanImport) > 0) {
            //no need to retrieve again
        } else {
            $arr1Result = $syn->query("SELECT 
            bpi_plan_code, bpi_synthesis_insurance_type
            FROM BrokerPlanImport");
            while ($arr = $syn->fetch_assoc($arr1Result)) {
                $this->brokerPlanImport[$arr['bpi_plan_code']] = $arr['bpi_synthesis_insurance_type'];
            }
        }

    }

    private function validatePolicyNumber($policy)
    {
        $policyNumberSplit = explode("/", $policy);
        $validList = ['MED', 'EUMO', 'EUEL', 'MOEU', 'EL', 'EUIM'];
        $policyInsType = explode("-", $policyNumberSplit[0]);
        $isInsTypeValid = false;
        foreach ($validList as $val) {
            if ($val == $policyInsType[0]) {
                $isInsTypeValid = true;
            }
        }
        $return = [];
        if ($isInsTypeValid == false) {
            $return['message'] = "[2] - Invalid Policy number prefix [" . $policyInsType[0] . "]\n";
            $return['validation_status'] = 'ERROR';
        } else {
            $return['message'] = "";
            $return['validation_status'] = 'OK';
        }
        return $return;
    }

    public function lapseAllPolicies()
    {
        global $db, $syn;

        $sql = 'SELECT * FROM es_soeasy_import_data WHERE essesid_lapse = "LAPSE" 
                AND essesid_status = "VALIDATED"';

        $result = $db->query($sql);
        $row = [];
        $db->start_transaction();

        while ($row = $db->fetch_assoc($result)) {
            //first check if indeed it needs lapse
            //if needs lapse then it should be a new policy (not renewal not cancel)
            //print_r($row);
            ?>
            <div class="row">
                <div class="col-12">
                    <?php
                    $val = $this->validateNew($row);
                    echo $row['Policy_Number'] . " - ";
                    if ($val['validation_status'] != 'LAPSE') {
                        echo " Not validated ok. Does not need lapse. -> " . $val['message'];
                    } else {
                        echo " Validated ok for lapse.";
                        $this->lapsePolicy($row['essesid_soeasy_import_data_ID']);
                    }

                    ?>
                </div>
            </div>
            <?php
        }
        $db->commit_transaction();
    }

    private function lapsePolicy($policySerial)
    {
        global $db, $syn, $sySyn;

        echo " -> Inserting record into scheduler into " . $syn->getDatabaseName() . " ";
        if ($this->policyNumberForLapse == '') {
            echo " <span class='alert-danger'>Cannot find the policy number to lapse.</span>";
            return false;
        }

        $dbCompany = $syn->getDatabaseName();
        $policyNumber = $this->policyNumberForLapse;
        $comment = 'LAPSE AG488 POLICY - NEW POLICY TO IMPORT! TRIGGERED FROM INTRANET PRE-PRE-PROCESS!';
        $lapseCodeSerial = 32289;

        $insertSql = "
        INSERT INTO syscheduletask
            (syst_created_by, syst_start_in, syst_target) VALUES
	    (
	        'INTRANET',
	        'C:\\SynInSys',
	        'C:\\SynInSys\\Synthesi.exe \"/schedule:FUSINIMP:FUS123456:" . $dbCompany . ":LAPSE_ONE:<Line-01><Dwo-dw_selection><xclo_policy_number>" . $policyNumber . "</xclo_policy_number>";
        $insertSql .= "<xclo_comment>" . $comment . "</xclo_comment>";
        $insertSql .= "<xclo_lapse_cancel_code_serial>" . $lapseCodeSerial . "</xclo_lapse_cancel_code_serial></Dwo-dw_selection></Line-01>\"');";
        $insertSql .= "SELECT @@IDENTITY as cloLastID;";

        $sySyn->beginTransaction();
        $result = $sySyn->query($insertSql);
        $newId = $sySyn->fetch_assoc($result);
        $sySyn->commit();
        //echo "<br><br>".$insertSql."<br><br>";
        echo " -> Row inserted Serial [" . $newId['cloLastID'] . "]";
        //update the record
        $newData['fld_lapse'] = 'LAPSE_SEND';
        $newData['fld_lapse_syscheduler_ID'] = $newId['cloLastID'];
        $db->db_tool_update_row('es_soeasy_import_data', $newData, 'essesid_soeasy_import_data_ID = ' . $policySerial,
            $policySerial, 'fld_', 'execute', 'essesid_');
        return true;
    }

    public function validateLapsed()
    {
        global $sySyn, $db, $syn;

        $sql = "
        SELECT * FROM es_soeasy_import_data 
                WHERE essesid_status = 'VALIDATED' 
                AND essesid_validation_status = 'LAPSE'
                AND essesid_lapse IN ('LAPSE_SEND','LAPSE_ERROR')  
        ";
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)) {
            //validate from the scheduler
            $schData = $sySyn->query_fetch("SELECT * FROM syscheduletask WHERE syst_auto_serial = " . $row['essesid_lapse_syscheduler_ID']);
            //find the actual policy and check if its lapsed.
            $polData = $syn->query_fetch('
                SELECT TOP 1
                inped_process_status
                ,inped_phase_status
                FROM
                inpolicies
                JOIN inpolicyendorsement ON inped_financial_policy_abs = inpol_policy_serial
                WHERE
                inpol_policy_serial = ' . $row['essesid_lapse_policy_ID'] . '
                ORDER BY inped_endorsement_serial DESC
                '
            );
            ?>
            <div class="row form-group">
                <div class="col-12">
                    <?php
                    echo $row['Policy_Number'] . " - Scheduler ID:" . $row['essesid_lapse_syscheduler_ID'];
                    echo " - Scheduler Result: " . $schData['syst_status_flag'];
                    echo " Policy Serial: " . $row['essesid_lapse_policy_ID'];
                    echo " - Policy Process Status: " . $polData['inped_process_status'];
                    //init fields
                    $newData = [];
                    if ($schData['syst_status_flag'] != 'C' || $polData['inped_process_status'] != 'L') {
                        echo ' <span class="alert-danger">Something went wrong on the lapsation</span>';
                        $newData['fld_lapse'] = 'LAPSE_ERROR';
                        $db->db_tool_update_row('es_soeasy_import_data', $newData, 'essesid_soeasy_import_data_ID = ' . $row['essesid_soeasy_import_data_ID'],
                            $row['essesid_soeasy_import_data_ID'], 'fld_', 'execute', 'essesid_');
                    } else {
                        echo ' <span class="alert-success">Policy Lapsed succesfully</span>';
                        $newData['fld_lapse'] = 'LAPSE_DONE';
                        $newData['fld_validation_status'] = 'OK';
                        $db->db_tool_update_row('es_soeasy_import_data', $newData, 'essesid_soeasy_import_data_ID = ' . $row['essesid_soeasy_import_data_ID'],
                            $row['essesid_soeasy_import_data_ID'], 'fld_', 'execute', 'essesid_');
                    }
                    ?>
                </div>
            </div>
            <?php
        }


    }

    public function validatePolicies($exportBatchID)
    {
        global $db, $syn;

        $sql = 'SELECT * FROM es_soeasy_import_data 
                WHERE essesid_export_batch = ' . $exportBatchID . "
                #AND essesid_soeasy_import_data_ID < 10";
        $result = $db->query($sql);
        $successPolicies = 0;
        $errorPolicies = 0;
        $html = '';
        while ($row = $db->fetch_assoc($result)) {
            $policyNumberSplit = explode("/", $row['Policy_Number']);

            $synimportSQL = "SELECT * FROM inimportpolicies
                                WHERE inipol_policy_number = '" . $policyNumberSplit[0] . "'";
            $synImpData = $syn->query_fetch($synimportSQL);

            $synSql = "SELECT * FROM inpolicies 
                        WHERE inpol_policy_number = '" . $policyNumberSplit[0] . "'";
            $synData = $syn->query_fetch($synSql);

            if ($synImpData['inipol_auto_serial'] > 0) {
                $html .= ' Found import ' . $synImpData['inipol_auto_serial'];
                if ($synImpData['inipol_row_status'] == 'E') {
                    $errorMessage = $synImpData['inipol_error_messages'];
                    $errorMessage = str_replace(PHP_EOL," ",$errorMessage);
                    $errorMessage = $db->prepare_text_as_html($errorMessage);
                    $html = '<span class="alert-danger">';
                    $html .= '<u><b>Validating policy: [' . $row['essesid_soeasy_import_data_ID'] . '] ' . $row['Policy_Number'] . "</b></u>";
                    $html .= ' Start:' . $row['Policy_Start_Date'] . " Expiry:" . $row['Policy_Expiry_Date'];
                    $html .= ' Row Status ERROR! [' . $synImpData['inipol_row_status'] . ']</span>';
                    $html .= '<br>Error - ' . $errorMessage;
                    $errorPolicies++;
                } else {
                    //find the policy and see its status
                    $sqlVal = "SELECT inpol_status,inpol_policy_number,inpol_policy_serial
                                FROM inpolicies WHERE inpol_policy_serial = ".$synImpData['inipol_policy_serial'];
                    $valData = $syn->query_fetch($sqlVal);
                    $html = '<u><b>Validating policy: [' . $row['essesid_soeasy_import_data_ID'] . '] ' . $row['Policy_Number'] . "</b></u>";
                    $html .= ' Row Status [' . $synImpData['inipol_row_status'] . ']';
                    $html .= ' SynPolicy['.$valData['inpol_policy_serial']."] Status[".$valData['inpol_status']."]";
                    $html .= " Number[".$valData['inpol_policy_number']."]";
                    $successPolicies++;
                }


            } else {
                $html .= '<span class="alert-danger">Cannot find any import policy record</span>';
            }

            /*
            if ($synData['inpol_policy_serial'] > 0 ){
                $html .= 'Found policy with serial '.$synData['inpol_policy_serial'];
            }
            else {
                $html .= '<span class="alert-danger">Cannot find any policy</span>';
            }
            */

            ?>
            <div class="row form-group">
                <div class="col-12">
                    <?php echo $html; ?>
                </div>
            </div>
            <?php
        }
        ?>
            <div class="row form-group">
                <div class="col-12">
                    Total Successful: <?php echo $successPolicies;?><br>
                    Total Errors: <?php echo $errorPolicies;?>
                </div>
            </div>
        <?php
    }

    private function convertDate($date)
    {
        global $db;
        return $db->convertDateFormat($date, 'yyyy-mm-dd');
    }

    private function addOneDayIntoDate($date)
    {
        $date = convertDate($date);
        return date('Y-m-d', strtotime($date . ' +1 day'));
    }
}