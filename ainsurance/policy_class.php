<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/1/2019
 * Time: 11:11 ΠΜ
 */

class Policy
{

    public $policyID;
    public $newEndorsementID;
    public $newRenewalID;
    public $newCancellationID;
    public $installmentID;
    public $policyData;
    public $totalPremium;
    public $mif;
    public $fees;
    public $commission;
    private $validForActive = false;
    private $totalItems = 0;

    public $error = false;
    public $errorDescription;

    function __construct($policyID)
    {
        global $db;
        $this->policyID = $policyID;
        $result = $db->query('
          SELECT * FROM 
          ina_policies 
          LEFT OUTER JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
          LEFT OUTER JOIN customers ON inapol_customer_ID = cst_customer_ID
          WHERE 
          inapol_underwriter_ID ' . $this->getAgentWhereClauseSql() . '
          AND inapol_policy_ID = ' . $policyID);
        $this->policyData = $db->fetch_assoc($result);

        //if no record then redirect to policies for security
        if ($db->num_rows($result) < 1) {
            header("Location: policies.php?notAllowed");
            exit();
        }

        $this->installmentID = $this->policyData['inapol_installment_ID'];

        $this->totalPremium = round(($this->policyData['inapol_premium'] + /*$this->policyData['inapol_mif'] +*/
            $this->policyData['inapol_fees'] + $this->policyData['inapol_stamps']), 2);
        $this->commission = $this->policyData['inapol_commission'];

        $result = $db->query_fetch('SELECT COUNT(*)as clo_total FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);
        $this->totalItems = $result['clo_total'];

    }

    public static function getAgentWhereClauseSql($whatToReturn = 'where')
    {
        global $db;

        //first get the underwriter
        $underwriter = $db->query_fetch('SELECT * FROM ina_underwriters WHERE inaund_user_ID = ' . $db->user_data['usr_users_ID']);

        $totalFound = 1;
        //initialize and add current user
        $whereClause = 'IN (' . $underwriter['inaund_underwriter_ID'] . ",";

        //find all the users that are of the same group and lower level
        $sql = "
          SELECT * FROM 
          users
          JOIN users_groups ON usr_users_groups_ID = usg_users_groups_ID
		  JOIN ina_underwriters ON inaund_user_ID = usr_users_ID 
          WHERE 
          usg_users_groups_ID = " . $db->user_data['usr_users_groups_ID'] . "
          AND inaund_vertical_level > " . $underwriter['inaund_vertical_level'];
        //echo $sql;
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)) {
            //print_r($row);
            $totalFound++;
            $whereClause .= $row['inaund_underwriter_ID'] . ",";
            //echo "<br><br>".$row['inaund_underwriter_ID'];
        }
        $whereClause = $db->remove_last_char($whereClause);
        $whereClause .= ")";
        //echo "<br>".$totalFound."->".$whereClause."<br>";
        if ($whatToReturn == 'where') {
            return $whereClause;
        } else if ($whatToReturn == 'totalFound') {
            return $totalFound;
        }

    }

    //updates the policy premium by sum the policyItems premium/mif/commission
    public function updatePolicyPremium()
    {
        global $db;

        //get the total premium
        $sql = "
            SELECT
            SUM(inapit_premium) as clo_total_premium,
            SUM(inapit_mif)as clo_total_mif
            FROM
            ina_policy_items
            WHERE
            inapit_policy_ID = " . $this->policyID;
        $total = $db->query_fetch($sql);

        $data['premium'] = round($total['clo_total_premium'], 2);
        //$data['mif'] = round($total['clo_total_mif'], 2);

        $db->db_tool_update_row('ina_policies', $data, 'inapol_policy_ID = ' . $this->policyID, $this->policyID, '', 'execute', 'inapol_');

    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }

    public function checkInsuranceTypeChange($newInsType)
    {
        global $db;

        //get current type tab name
        $currentType = $this->policyData['inapol_type_code'];

        if ($currentType == $newInsType) {
            return true;
        } else {
            return false;
        }
    }

    public function getTypeFullName()
    {
        if ($this->policyData['inapol_type_code'] == 'Motor') {
            return 'Vehicles';
        }

        return $this->policyData['inapol_type_code'];
    }

    //affects the input form
    public function getInputType()
    {
        if ($this->policyData['inapol_type_code'] == 'Motor') {
            return 'Vehicles';
        } else if ($this->policyData['inapol_type_code'] == 'Fire') {
            return 'RiskLocation';
        }
    }

    public function deletePolicyItem($inapitID)
    {
        global $db;
        if ($this->policyData['inapol_status'] == 'Outstanding') {

            $db->db_tool_delete_row('ina_policy_items', $inapitID, 'inapit_policy_item_ID = ' . $inapitID);

            $this->updatePolicyPremium();

            return true;

        } else {
            $this->error = true;
            $this->errorDescription = 'To delete policy item status must be outstanding.';
            return false;
        }

    }

    public function deletePolicy()
    {
        global $db;

        if ($this->policyData['inapol_status'] == 'Outstanding') {
            //first delete the policy items

            $result = $db->query_fetch('SELECT * FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);
            while ($pit = $db->fetch_assoc($result)) {

                $db->db_tool_delete_row('ina_policy_items', $pit['inapit_policy_item_ID'], 'inapit_policy_item_ID = ' . $pit['inapit_policy_item_ID']);

            }

            //delete the policy
            $db->db_tool_delete_row('ina_policies', $this->policyID, 'inapol_policy_ID = ' . $this->policyID);

            return true;
        } else {
            $this->error = true;
            $this->errorDescription = 'To delete policy status must be outstanding.';
            return false;
        }
    }

    public function activatePolicy()
    {
        global $db;
        if ($this->policyData['inapol_status'] == 'Outstanding') {
            //perform validations.
            //1. Check if any installments exists.
            $totalInstallments = $db->query_fetch("SELECT COUNT(*)as clo_total_installments FROM ina_policy_installments WHERE inapi_policy_ID = ".$this->installmentID);
            if ($totalInstallments['clo_total_installments'] < 1){
                $this->error = true;
                $this->errorDescription = 'No installments found. You can automatically generate.';
                return false;
            }

            //2. Check if premium is equal to total premium of items
            $premCheck = $db->query_fetch('SELECT 
              SUM(inapit_premium)as clo_total_premium,
              SUM(inapit_mif) as clo_total_mif 
              FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);

            if ($this->policyData['inapol_premium'] != $premCheck['clo_total_premium']
                && $this->policyData['inapol_process_status'] != 'Endorsement'
                && $this->policyData['inapol_process_status'] != 'Cancellation') {
                $this->error = true;
                $this->errorDescription = 'Policy Premium is not equal with total items premium';
                return false;
            }

            /*
            if ($this->policyData['inapol_mif'] != $premCheck['clo_total_mif'] && $this->policyData['inapol_process_status'] != 'Endorsement'
                && $this->policyData['inapol_type_code'] == 'Motor') {
                $this->error = true;
                $this->errorDescription = 'Policy MIF is not equal with total items MIF';
                return false;
            }
            */

            //2. Check if total installments premium/commission is correct
            $instCheck = $db->query_fetch('SELECT
                    SUM(ROUND(inapi_amount,2)) as clo_total_amount,
                    SUM(ROUND(inapi_commission_amount,2)) as clo_total_commission_amount
                    FROM ina_policy_installments
                    WHERE
                    inapi_policy_ID = ' . $this->policyID);

            if ($this->totalPremium != $instCheck['clo_total_amount']
                && $this->policyData['inapol_process_status'] != 'Endorsement'
                && $this->policyData['inapol_process_status'] != 'Cancellation') {
                $this->error = true;
                $this->errorDescription = 'Installments Premium is not equal with policy premium. Re-Calculate installments.';
                return false;
            }

            if ($this->policyData['inapol_commission'] != $instCheck['clo_total_commission_amount']
                && $this->policyData['inapol_process_status'] != 'Endorsement'
                && $this->policyData['inapol_process_status'] != 'Cancellation') {
                $this->error = true;
                $this->errorDescription = 'Installments Commission is not equal with policy commission. Re-Calculate installments.';
                return false;
            }

            //if endorsement or cancellation apply the installments changes.
            if ($this->policyData['inapol_process_status'] == 'Endorsement' || $this->policyData['inapol_process_status'] == 'Cancellation') {
                $this->applyEndorsementAmount();
            }


        } else {
            $this->error = true;
            $this->errorDescription = 'Policy must be outstanding to activate.';
            return false;
        }

        //if all validations are ok!
        if ($this->error == false) {
            //update the policy to active
            $newData['status'] = 'Active';
            //in case of cancellation is not active but archived. Cannot consider a cancellation as active.
            if ($this->policyData['inapol_process_status'] == 'Cancellation') {
                $newData['status'] = 'Archived';
            }
            $db->db_tool_update_row('ina_policies',
                $newData,
                'inapol_policy_ID = ' . $this->policyID,
                $this->policyID,
                '',
                'execute',
                'inapol_');

            //check if is replacing other policy to set to archive.


            if ($this->policyData['inapol_replacing_ID'] > 0) {
                $archNewData['status'] = 'Archived';
                $db->db_tool_update_row('ina_policies',
                    $archNewData,
                    'inapol_policy_ID = ' . $this->policyData['inapol_replacing_ID'],
                    $this->policyData['inapol_replacing_ID'],
                    '',
                    'execute',
                    'inapol_');

            }
        }


        //$this->validForActive = true;
        //$this->errorDescription = 'Some error. Activate function needs build';
        return true;
    }

    private function issueAccountTransactions()
    {
        global $db;

        //for basic accounts
        if ($db->dbSettings['accounts']['value'] == 'basic') {

        }
    }

    public function cancelPolicy($cancelDate, $premium)
    {
        global $db;

        if ($this->policyData['inapol_status'] != 'Active') {
            $this->error = true;
            $this->errorDescription = 'Only Active policies can be cancelled.';
            return false;
        }

        //if all ok proceed to create the new phase.
        //load the new data
        foreach ($this->policyData as $name => $value) {
            if (substr($name, 0, 7) == 'inapol_') {
                $newData[$name] = $value;
            }
        }

        $newData['inapol_starting_date'] = $db->convert_date_format($cancelDate, 'dd/mm/yyyy', 'yyyy-mm-dd');
        $newData['inapol_status'] = 'Outstanding';
        $newData['inapol_process_status'] = 'Cancellation';
        $newData['inapol_premium'] = $premium;
        //$newData['inapol_mif'] = 0;
        $newData['inapol_commission'] = 0;
        $newData['inapol_fees'] = 0;
        $newData['inapol_stamps'] = 0;
        $newData['inapol_replacing_ID'] = $this->policyID;
        $instNewData['inapol_installment_ID'] = $this->policyData['inapol_installment_ID'];

        unset($newData['inapol_created_date_time']);
        unset($newData['inapol_created_by']);
        unset($newData['inapol_last_update_date_time']);
        unset($newData['inapol_last_update_by']);
        unset($newData['inapol_replaced_by_ID']);
        unset($newData['inapol_policy_ID']);

        $newPolicyID = $db->db_tool_insert_row('ina_policies', $newData, '', 1);
        $this->newCancellationID = $newPolicyID;

        //update the current
        //echo "Update Current<br>\n";
        $curNewData['inapol_replaced_by_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $curNewData, 'inapol_policy_ID = ' . $this->policyID,
            $this->policyID, '', 'execute', '');


        //$this->error = true;
        //$this->errorDescription = 'Some error. Cancel function needs build';
        //return false;
        return true;
    }

    public function reviewPolicy($expiryDate = null)
    {
        //check the policy if active
        if ($this->policyData['inapol_status'] != 'Active') {
            $this->error = true;
            $this->errorDescription = 'Cannot review. Policy not active';
        }
        //check if its replaced
        if ($this->policyData['inapol_replaced_by_ID'] > 0) {
            $this->error = true;
            $this->errorDescription = 'Cannot review. Policy is already being replaced by another.';
        }


        if ($this->error == false) {
            $this->renewPolicy($expiryDate);
        }

        if ($this->error == true) {
            return false;
        } else {
            return true;
        }

    }

    /***
     * @param null $expiryDate ->Format: dd/mm/yyyy
     * @return true/false
     */
    private function renewPolicy($expiryDate = null)
    {
        global $db;
        $db->start_transaction();

        //prepare the expiry date
        if ($expiryDate == null) {
            //find the current duration.
            $dateDiff = $db->dateDiff($this->policyData['inapol_starting_date'], $this->policyData['inapol_expiry_date'], 'yyyy-mm-dd');
            $months = $dateDiff->m + ($dateDiff->y * 12);
            //if days are more than 26 then its another full month
            if ($dateDiff->d > 26) {
                $months++;
            }
            $startingDate = $this->policyData['inapol_expiry_date'];
            $startingDate = explode('-', $startingDate);
            $newStartingDate = date('d/m/Y', mktime(0, 0, 0, $startingDate[1], $startingDate[2] + 1, $startingDate[0]));
            $newStartingDateParts = explode('/', $newStartingDate);
            $newExpiryDateParts = $db->getNewExpiryDate($newStartingDate, $months);

        } else {
            //use the provided one
            $newExpiryDateParts = explode('/', $expiryDate);
            $startingDate = $this->policyData['inapol_expiry_date'];
            $startingDate = explode('-', $startingDate);
            $newStartingDate = date('d/m/Y', mktime(0, 0, 0, $startingDate[1], $startingDate[2] + 1, $startingDate[0]));
            $newStartingDateParts = explode('/', $newStartingDate);

        }

        //load the new data
        foreach ($this->policyData as $name => $value) {
            if (substr($name, 0, 7) == 'inapol_') {
                $newData[$name] = $value;
            }
        }
        $newData['inapol_starting_date'] = $newStartingDateParts[2] . "-" . $newStartingDateParts[1] . "-" . $newStartingDateParts[0];
        $newData['inapol_expiry_date'] = $newExpiryDateParts['year'] . "-" . $newExpiryDateParts['month'] . "-" . $newExpiryDateParts['day'];
        $newData['inapol_status'] = 'Outstanding';
        $newData['inapol_process_status'] = 'Renewal';
        //$newData['inapol_premium'] = 'Renewal';
        //$newData['inapol_mif'] = 'Renewal';
        //$newData['inapol_commission'] = 'Renewal';
        //$newData['inapol_fees'] = 'Renewal';
        //$newData['inapol_stamps'] = 'Renewal';
        $newData['inapol_replacing_ID'] = $this->policyID;

        unset($newData['inapol_created_date_time']);
        unset($newData['inapol_created_by']);
        unset($newData['inapol_last_update_date_time']);
        unset($newData['inapol_last_update_by']);
        unset($newData['inapol_replaced_by_ID']);
        unset($newData['inapol_policy_ID']);

        //create the record in db
        //echo "Create policy<br>\n";
        //print_r($newData);
        $newPolicyID = $db->db_tool_insert_row('ina_policies', $newData, '', 1);
        $this->newRenewalID = $newPolicyID;
        //update the installment ID
        $instNewData['inapol_installment_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $instNewData, 'inapol_policy_ID = ' . $newPolicyID,
            $newPolicyID, '', 'execute', '');

        //update the current
        //echo "Update Current<br>\n";
        $curNewData['inapol_replaced_by_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $curNewData, 'inapol_policy_ID = ' . $this->policyID,
            $this->policyID, '', 'execute', '');

        //create the items.
        //get them all
        $result = $db->query("SELECT * FROM ina_policy_items WHERE inapit_policy_ID = " . $this->policyID . " ORDER BY inapit_policy_item_ID ASC");
        while ($item = $db->fetch_assoc($result)) {
            $newItemData = $item;
            $newItemData['inapit_policy_ID'] = $newPolicyID;
            unset($newItemData['inapit_created_date_time']);
            unset($newItemData['inapit_created_by']);
            unset($newItemData['inapit_last_update_date_time']);
            unset($newItemData['inapit_last_update_by']);
            unset($newItemData['inapit_policy_item_ID']);
            //echo "Create Item<br>\n";
            $db->db_tool_insert_row('ina_policy_items', $newItemData, '');
        }
        //echo "Create Installments<br>\n";
        //create the installments
        include('policyTabs/installments_class.php');
        $installments = new Installments($newPolicyID);
        if ($installments->generateInstallmentsRenewal() == false) {
            $this->error = true;
            $this->errorDescription = $installments->errorDescription;
            $db->rollback_transaction();
            return false;
        } else {
            $installments->updateInstallmentsAmountAndCommission();
        }

        return true;
    }

    /**
     * @param $endorsementDate 'dd/mm/yyyy'
     * @param $premium 'the new premium -+'
     * @return bool
     */
    public function endorsePolicy($endorsementDate, $premium)
    {
        if ($this->policyData['inapol_status'] != 'Active') {
            $this->error = true;
            $this->errorDescription = 'Policy must be active to Endorse';
            return false;
        }
        if ($this->policyData['inapol_replaced_by_ID'] > 0) {
            $this->error = true;
            $this->errorDescription = 'This policy is already being replaced. Find the last phase to endorse.';
            return false;
        }

        $this->makeEndorsement($endorsementDate, $premium);

        if ($this->error == true) {
            return false;
        } else {
            return true;
        }

    }

    private function makeEndorsement($endorsementDate, $premium)
    {
        global $db;

        $db->start_transaction();

        //load the new data
        foreach ($this->policyData as $name => $value) {
            if (substr($name, 0, 7) == 'inapol_') {
                $newData[$name] = $value;
            }
        }
        $newStartingDateParts = explode('/', $endorsementDate);
        $newData['inapol_starting_date'] = $newStartingDateParts[2] . "-" . $newStartingDateParts[1] . "-" . $newStartingDateParts[0];
        $newData['inapol_status'] = 'Outstanding';
        $newData['inapol_process_status'] = 'Endorsement';
        $newData['inapol_premium'] = $premium;
        $newData['inapol_mif'] = 0;
        $newData['inapol_commission'] = 0;
        $newData['inapol_fees'] = 0;
        $newData['inapol_stamps'] = 0;
        $newData['inapol_replacing_ID'] = $this->policyID;

        unset($newData['inapol_created_date_time']);
        unset($newData['inapol_created_by']);
        unset($newData['inapol_last_update_date_time']);
        unset($newData['inapol_last_update_by']);
        unset($newData['inapol_replaced_by_ID']);
        unset($newData['inapol_policy_ID']);

        //create the record in db
        //echo "Create policy<br>\n";
        //print_r($newData);
        $newPolicyID = $db->db_tool_insert_row('ina_policies', $newData, '', 1);
        $this->newEndorsementID = $newPolicyID;
        //update the current
        //echo "Update Current<br>\n";
        $curNewData['inapol_replaced_by_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $curNewData, 'inapol_policy_ID = ' . $this->policyID,
            $this->policyID, '', 'execute', '');

        //create the items.
        //get them all
        $result = $db->query("SELECT * FROM ina_policy_items WHERE inapit_policy_ID = " . $this->policyID . " ORDER BY inapit_policy_item_ID ASC");
        while ($item = $db->fetch_assoc($result)) {
            $newItemData = $item;
            $newItemData['inapit_policy_ID'] = $newPolicyID;
            unset($newItemData['inapit_created_date_time']);
            unset($newItemData['inapit_created_by']);
            unset($newItemData['inapit_last_update_date_time']);
            unset($newItemData['inapit_last_update_by']);
            unset($newItemData['inapit_policy_item_ID']);
            //echo "Create Item<br>\n";
            $db->db_tool_insert_row('ina_policy_items', $newItemData, '');
        }

        //no installments for the endorsement

        //if all ok commit
        //$db->commit_transaction();
        return true;


    }

    public function applyEndorsementAmount()
    {
        global $db;

        echo "applyEndorsementAmount()<br>";

        if ($this->policyData['inapol_process_status'] != 'Endorsement' && $this->policyData['inapol_process_status'] != 'Cancellation') {
            $this->error = true;
            $this->errorDescription = 'Policy must be endorsement/cancellation to apply endorsement amount';
            return false;
        }

        //first get the changes to the installments
        $changes = $this->getSplitEndorsementAmount();
        //print_r($changes);echo "\n\n";exit();
        $total = 0;
        $totalComm = 0;
        foreach ($changes as $name => $value) {
            $total += $value['amount'];
            $totalComm += $value['commission'];
        }
        //echo "Total Amount:" . $total." Total Comm:".$totalComm."\n\n";
        //return true;

        if ($this->error == true) {
            return false;
        }

        //get all the current installments amounts
        $sql = "SELECT * FROM ina_policy_installments
                WHERE
                inapi_policy_ID = " . $this->policyData['inapol_installment_ID'] . "
                AND inapi_paid_status IN ('UnPaid','Partial')
                ORDER BY inapi_policy_installments_ID ASC;";
        $result = $db->query($sql);
        $totalInstallments = $db->num_rows($result);

        //if installments exists to split the amounts
        if ($totalInstallments > 0) {
            while ($row = $db->fetch_assoc($result)) {
                $currentAmounts[$row['inapi_policy_installments_ID']]['amount'] = $row['inapi_amount'];
                $currentAmounts[$row['inapi_policy_installments_ID']]['paid'] = $row['inapi_paid_amount'];
                $currentAmounts[$row['inapi_policy_installments_ID']]['commAmount'] = $row['inapi_commission_amount'];
                $currentAmounts[$row['inapi_policy_installments_ID']]['commPaid'] = $row['inapi_paid_commission_amount'];

                //loop into the changes.
                foreach ($changes as $name => $value) {
                    //create the unallocated afterwards
                    //find the change that applies to this installment.
                    if ($name != 'unallocated'
                        && $name != 'new'
                        && $name == $row['inapi_policy_installments_ID']) {

                        //echo "<br>".$name." -> ".$value['amount']." -> ".$value['commission']."<br>";
                        //echo "Working ON:".$name." Val:".$value."<br>";
                        $newData['amount'] = $currentAmounts[$name]['amount'] + $value['amount'];
                        $newData['commission_amount'] = $currentAmounts[$name]['commAmount'] + $value['commission'];
                        //echo "Inst new Amount:".$newData['amount']."<br>";
                        //check if now the installment is paid
                        //echo $name." -> newdata Amount:".$newData['amount']." -> CurrentAmounts[name]:".$currentAmounts[$name]."\n\n\n\n";
                        if ($newData['amount'] == $currentAmounts[$name]['paid']) {
                            //echo $newData['amount']." == ".$currentAmounts[$name]['paid']."<br>";
                            $newData['paid_status'] = 'Paid';
                        }

                        //echo "final updates<br>";
                        //print_r($newData);
                        //echo "<br>";

                        $db->db_tool_update_row('ina_policy_installments', $newData,
                            'inapi_policy_installments_ID = ' . $name, $name, '', 'execute', 'inapi_');

                        //reset the paid status
                        unset($newData['paid_status']);
                    }
                }

                //echo "<br>here";//exit();
            }
        } //if no installments exists to split the amount then need to create a new record.
        else {
            if ($changes['new']['amount'] != 0 || $changes['new']['commission'] != 0) {
                $newData['policy_ID'] = $this->installmentID;
                $newData['installment_type'] = 'Endorsement';
                $newData['amount'] = $changes['new']['amount'];
                $newData['commission_amount'] = $changes['new']['commission'];
                $newData['insert_date'] = date('Y-m-d');
                $newData['document_date'] = date('Y-m-d');
                $newData['last_payment_date'] = date('Y-m-d');

                if ($changes['new']['commission'] < 0 || $changes['new']['amount'] < 0) {
                    $newData['paid_amount'] = $changes['new']['amount'];
                    $newData['paid_commission_amount'] = $changes['new']['commission'];
                    $newData['paid_status'] = 'Paid';
                } else {
                    $newData['paid_amount'] = 0;
                    $newData['paid_commission_amount'] = 0;
                    $newData['paid_status'] = 'UnPaid';
                }

                $db->db_tool_insert_row('ina_policy_installments', $newData, '', '0', 'inapi_', 'execute');
                //echo "\n\n";
            }
        }


        //echo 'Create unallocated Entry.';
        if ($changes['unallocated']['amount'] != 0) {
            $unAllData['inapp_policy_ID'] = $this->policyID;
            $unAllData['inapp_customer_ID'] = $this->policyData['inapol_customer_ID'];
            $unAllData['inapp_status'] = 'Unallocated';
            $unAllData['inapp_payment_date'] = date('Y-m-d');
            $unAllData['inapp_amount'] = $changes['unallocated']['amount'] * -1;
            $unAllData['inapp_commission_amount'] = 0;
            $unAllData['inapp_allocated_amount'] = 0;
            $unAllData['inapp_allocated_commission'] = 0;
            $db->db_tool_insert_row('ina_policy_payments', $unAllData, '', 0, '', 'execute');
            //echo "\n\n";
        }

        //all payments that are applied need to be locked
        //in case of reverse it will mess up the data now because this function modifies the installments and so any reverse will mess it up.
        //fix one by one record to create log file entry.
        $sql = "
            SELECT * FROM ina_policy_payments WHERE inapp_policy_ID = " . $this->installmentID . " 
            AND inapp_status = 'Applied'";
        $result = $db->query($sql);
        while ($pay = $db->fetch_assoc($result)) {
            $payNewData['locked'] = 1;
            $db->db_tool_update_row('ina_policy_payments',
                $payNewData,
                'inapp_policy_payment_ID = ' . $pay['inapp_policy_payment_ID'],
                $pay['inapp_policy_payment_ID'],'','execute','inapp_');

        }

        return true;


    }

    /**
     * if endorsement -> Gets the endorse amount and split it into the installments of the period phase.
     * Checks all the installments. If unpaid or partial it splits the difference into them. If leftover then an unallocated payment needs to be created.
     * Returns an array with each installment ID and the amount needs to be added/subtracted
     */
    public function getSplitEndorsementAmount()
    {
        global $db;

        $amountToAllocate = $this->totalPremium;
        $commToAllocate = $this->commission;
        $fixes['unallocated']['amount'] = 0;
        $fixes['new']['amount'] = 0;
        $fixes['new']['commission'] = 0;

        //get all unpaid or partial installments.
        $result = $db->query('SELECT * FROM ina_policy_installments 
                WHERE
                inapi_policy_ID = ' . $this->policyData['inapol_installment_ID'] . "
                AND inapi_paid_status IN ('UnPaid','Partial')
                ORDER BY inapi_policy_installments_ID ASC
                ");

        $totalInstallments = $db->num_rows($result);
        if ($totalInstallments > 0) {
            //split the difference to the remaining installments.
            $perInstallment = round((floor(($amountToAllocate / $totalInstallments) * 100) / 100), 2);
            $perInstallmentComm = round((floor(($commToAllocate / $totalInstallments) * 100) / 100), 2);


        } else {
            $perInstallment = $amountToAllocate;
            $perInstallmentComm = $commToAllocate;
        }

        //if installments exists to split the amounts
        if ($totalInstallments > 0) {
            $currentNumInstallment = 0;
            while ($inst = $db->fetch_assoc($result)) {
                //Create an array of the changes
                $currentNumInstallment++;
                $lastInstallmentID = $inst['inapi_policy_installments_ID'];

                //echo "Working on :".$inst['inapi_policy_installments_ID']."<br>";
                //check if the premium is negative
                //if negative then check if its enough to substract from the installment.
                //if not the remaining divide to the rest of the installments.
                if ($amountToAllocate < 0) {

                    //if perinstallment is negative and more than the remaining.
                    if (($inst['inapi_amount'] - $inst['inapi_paid_amount']) < ($perInstallment * -1)) {
                        //allocate the amount
                        $fixes[$inst['inapi_policy_installments_ID']]['amount'] = round((($inst['inapi_amount'] - $inst['inapi_paid_amount']) * -1), 2);
                        $fixes[$inst['inapi_policy_installments_ID']]['commission'] = round((($inst['inapi_commission_amount'] - $inst['inapi_paid_commission_amount']) * -1), 2);
                        //remove the allocated amount from the amount to allocate
                        $amountToAllocate += round(($inst['inapi_amount'] - $inst['inapi_paid_amount']), 2);
                        $commToAllocate += round(($inst['inapi_commission_amount'] - $inst['inapi_paid_commission_amount']), 2);
                        //The remaining split in the rest of the installments.
                        //if the amount remaining is more than the unpaid then create unallocated entry.
                        if (($totalInstallments - $currentNumInstallment) == 0 && $amountToAllocate < 0) {
                            $fixes['unallocated']['amount'] = $amountToAllocate;
                            $amountToAllocate = 0;
                            //all the remaining commission add it into this last record as negative
                            $fixes[$inst['inapi_policy_installments_ID']]['commission'] += $commToAllocate;
                            $commToAllocate = 0;
                        } else {
                            //echo "AmountToAllocate: " . $amountToAllocate . " TotalInstallments: " . $totalInstallments;
                            $perInstallment = round((floor(($amountToAllocate / ($totalInstallments - $currentNumInstallment)) * 100) / 100), 2);
                            $perInstallmentComm = round((floor(($commToAllocate / ($totalInstallments - $currentNumInstallment)) * 100) / 100), 2);
                            //echo "Substracting: " . round(($inst['inapi_amount'] - $inst['inapi_paid_amount']), 2);
                        }

                    } else {
                        $fixes[$inst['inapi_policy_installments_ID']]['amount'] = $perInstallment;
                        $fixes[$inst['inapi_policy_installments_ID']]['commission'] = $perInstallmentComm;
                        //remove the allocated amount from the amount to allocate
                        $amountToAllocate -= $perInstallment;
                        $commToAllocate -= $perInstallmentComm;
                        //echo "Substracting: ".$perInstallment;
                    }

                } else {
                    $fixes[$inst['inapi_policy_installments_ID']]['amount'] = $perInstallment;
                    $fixes[$inst['inapi_policy_installments_ID']]['commission'] = $perInstallmentComm;
                    $amountToAllocate -= $perInstallment;
                    $commToAllocate -= $perInstallmentComm;
                    //echo "Substracting: ".$perInstallment."<br>";
                }


                //$amountToAllocate = round($amountToAllocate, 2);
                //echo " Amount to allocate:".$amountToAllocate."<br>";
            }//while loop all installments
        } //if no installments exists then need to create a new record
        else {
            //in case if its return amount (-)
            if ($amountToAllocate < 0) {
                //the amount will be created as new unallocated
                $fixes['unallocated']['amount'] = $amountToAllocate;
                $fixes['new']['amount'] = 0;
                $amountToAllocate = 0;
                //the commission will create a new installment as paid with the return commission
                $fixes['new']['commission'] = $commToAllocate;
                $commToAllocate = 0;
            } else {
                //the amount will be created as new unallocated
                //$fixes['unallocated']['amount'] = $amountToAllocate;
                //the commission will create a new installment as paid with the return commission
                $fixes['new']['commission'] = $commToAllocate;
                $commToAllocate = 0;
                $fixes['new']['amount'] = $amountToAllocate;
                $amountToAllocate = 0;
            }
        }


        //check if there is any remaining amount to allocate. In case if possitve then just allocate to the last installment.
        if ($amountToAllocate > 0) {
            //$fixes['unallocated'] = $amountToAllocate;
            //$fixes[$lastInstallmentID] += $amountToAllocate;
        }

        //loop into the results and check if the total amount is correct.
        //if not add the difference to the last installment.
        $totalCalculated = 0;
        $totalCalculatedCommission = 0;
        foreach ($fixes as $name => $value) {
            $totalCalculated += $value['amount'];
            $lastID = $name;

            $totalCalculatedCommission += $value['commission'];
        }
        if ($totalCalculated < $this->totalPremium) {
            $fixes[$lastID]['amount'] += ($this->totalPremium - $totalCalculated);
        }
        //fix commission
        if ($totalCalculatedCommission < $this->commission) {
            $fixes[$lastID]['commission'] += ($this->commission - $totalCalculatedCommission);
        }

        $totalCalculated = 0;
        foreach ($fixes as $name => $value) {
            $totalCalculated += $value['amount'];
            $lastID = $name;
        }
        //final check. if wrong stop the whole procedure
        if ($totalCalculated != $this->totalPremium) {
            $this->error = true;
            $this->errorDescription = 'Leftover amount on allocation. Please contact the administrator.';
        }
        //echo "Total Allocated:".$totalCalculated."<br>";
        return $fixes;
    }

    /**
     * returns array with
     * ['totalAmount'] = total amount
     * ['totalPaid'] = total amount paid
     * ['totalCommission'] = total commission
     * ['totalCommissionPaid'] = total commission paid
     * ['unpaidInstallment'] = how many unpaid/partial(Not paid) installment/s exists
     * ['paymentTotalAmount'] =
     * ['paymentTotalCommission'] =
     * ['paymentTotalAllocated'] =
     * ['paymentTotalAllocatedCommission'] =
     * ['paymentTotalUnPosted'] = true/false how many un posted payments exists
     */
    public function getInstallmentsInfo()
    {
        global $db;


        //get installment information
        $installmentData = $db->query_fetch("SELECT
        SUM(inapi_amount)as clo_total_amount,
        SUM(inapi_paid_amount)as clo_total_paid_amount,
        SUM(inapi_commission_amount)as clo_total_commission_amount,
        SUM(inapi_paid_commission_amount)as clo_total_paid_commission_amount,
        SUM(IF(inapi_paid_status != 'Paid',1,0))as clo_unpaid_total
        FROM
        ina_policy_installments
        WHERE
        inapi_policy_ID = " . $this->installmentID);

        $return['totalAmount'] = $installmentData['clo_total_amount'];
        $return['totalPaid'] = $installmentData['clo_total_paid_amount'];
        $return['totalCommission'] = $installmentData['clo_total_commission_amount'];
        $return['totalCommissionPaid'] = $installmentData['clo_total_paid_commission_amount'];
        $return['unpaidInstallment'] = $installmentData['clo_unpaid_total'];

        //get payments information
        $paymentData = $db->query_fetch("SELECT
        SUM(inapp_amount)as clo_total_amount,
        SUM(inapp_commission_amount)as clo_total_commission,
        SUM(inapp_allocated_amount)as clo_total_allocated,
        SUM(inapp_allocated_commission)as clo_total_allocated_commission,
        SUM(IF(inapp_status != 'Posted',1,0))as clo_unposted_total
        FROM
        ina_policy_payments
        WHERE
        inapp_policy_ID = " . $this->installmentID);

        $return['paymentTotalAmount'] = $paymentData['clo_total_amount'];
        $return['paymentTotalCommission'] = $paymentData['clo_total_commission'];
        $return['paymentTotalAllocated'] = $paymentData['clo_total_allocated'];
        $return['paymentTotalAllocatedCommission'] = $paymentData['clo_total_allocated_commission'];
        $return['paymentTotalUnPosted'] = $paymentData['clo_unposted_total'];
        $return['paymentTotalUnpaid'] = $installmentData['clo_total_amount'] - $paymentData['clo_total_amount'];
        return $return;
    }


}

function getPolicyClass($status)
{
    return 'inapol' . $status . 'Color';
}