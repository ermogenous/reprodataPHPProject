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
        $this->policyData = $db->query_fetch('
          SELECT * FROM 
          ina_policies 
          LEFT OUTER JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
          LEFT OUTER JOIN customers ON inapol_customer_ID = cst_customer_ID
          WHERE inapol_policy_ID = ' . $policyID);

        $this->totalPremium = round(($this->policyData['inapol_premium'] + $this->policyData['inapol_mif'] + $this->policyData['inapol_fees'] + $this->policyData['inapol_stamps']), 2);

        $result = $db->query_fetch('SELECT COUNT(*)as clo_total FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);
        $this->totalItems = $result['clo_total'];

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
        $data['mif'] = round($total['clo_total_mif'], 2);

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
    public function getInputType(){
        if ($this->policyData['inapol_type_code'] == 'Motor') {
            return 'Vehicles';
        }
        else if ($this->policyData['inapol_type_code'] == 'Fire') {
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
            //1. Check if premium is equal to total premium of items
            $premCheck = $db->query_fetch('SELECT 
              SUM(inapit_premium)as clo_total_premium,
              SUM(inapit_mif) as clo_total_mif 
              FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);

            if ($this->policyData['inapol_premium'] != $premCheck['clo_total_premium']) {
                $this->error = true;
                $this->errorDescription = 'Policy Premium is not equal with total items premium';
                return false;
            }

            if ($this->policyData['inapol_mif'] != $premCheck['clo_total_mif']) {
                $this->error = true;
                $this->errorDescription = 'Policy MIF is not equal with total items MIF';
                return false;
            }

            //2. Check if total installments premium/commission is correct
            $instCheck = $db->query_fetch('SELECT
                    SUM(ROUND(inapi_amount,2)) as clo_total_amount,
                    SUM(ROUND(inapi_commission_amount,2)) as clo_total_commission_amount
                    FROM ina_policy_installments
                    WHERE
                    inapi_policy_ID = ' . $this->policyID);

            if ($this->totalPremium != $instCheck['clo_total_amount']) {
                $this->error = true;
                $this->errorDescription = 'Installments Premium is not equal with policy premium. Re-Calculate installments.';
                return false;
            }

            if ($this->policyData['inapol_commission'] != $instCheck['clo_total_commission_amount']) {
                $this->error = true;
                $this->errorDescription = 'Installments Commission is not equal with policy commission. Re-Calculate installments.';
                return false;
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
            $db->db_tool_update_row('ina_policies',
                $newData,
                'inapol_policy_ID = ' . $this->policyID,
                $this->policyID,
                '',
                'execute',
                'inapol_');
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

    public function cancelPolicy()
    {
        global $db;
        $this->errorDescription = 'Some error. Cancel function needs build';
        return false;
    }

    public function reviewPolicy($expiryDate = null){
        //check the policy if active
        if ($this->policyData['inapol_status'] != 'Active'){
            $this->error = true;
            $this->errorDescription = 'Cannot review. Policy not active';
        }
        //check if its replaced
        if ($this->policyData['inapol_replaced_by_ID'] > 0){
            $this->error = true;
            $this->errorDescription = 'Cannot review. Policy is already being replaced by another.';
        }


        if ($this->error == false){
            $this->renewPolicy($expiryDate);
        }

        if ($this->error == true){
            return false;
        }
        else {
            return true;
        }

    }

    /***
     * @param null $expiryDate ->Format: dd/mm/yyyy
     * @return true/false
     */
    private function renewPolicy($expiryDate = null){
        global $db;
        $db->start_transaction();

        //prepare the expiry date
        if ($expiryDate == null){
            //find the current duration.
            $dateDiff = $db->dateDiff($this->policyData['inapol_starting_date'], $this->policyData['inapol_expiry_date'],'yyyy-mm-dd');
            $months = $dateDiff->m + ($dateDiff->y * 12);
            //if days are more than 26 then its another full month
            if ($dateDiff->d > 26) {
                $months++;
            }
            $startingDate = $this->policyData['inapol_expiry_date'];
            $startingDate = explode('-', $startingDate);
            $newStartingDate = date('d/m/Y',mktime(0,0,0,$startingDate[1],$startingDate[2]+1,$startingDate[0]));
            $newStartingDateParts = explode('/',$newStartingDate);
            $newExpiryDateParts = $db->getNewExpiryDate($newStartingDate, $months);

        }
        else {
            //use the provided one
            $newExpiryDateParts = explode('/',$expiryDate);
            $startingDate = $this->policyData['inapol_expiry_date'];
            $startingDate = explode('-', $startingDate);
            $newStartingDate = date('d/m/Y',mktime(0,0,0,$startingDate[1],$startingDate[2]+1,$startingDate[0]));
            $newStartingDateParts = explode('/',$newStartingDate);

        }

        //load the new data
        foreach($this->policyData as $name => $value){
            if (substr($name,0,7) == 'inapol_'){
                $newData[$name] = $value;
            }
        }
        $newData['inapol_starting_date'] = $newStartingDateParts[2]."-".$newStartingDateParts[1]."-".$newStartingDateParts[0];
        $newData['inapol_expiry_date'] = $newExpiryDateParts['year']."-".$newExpiryDateParts['month']."-".$newExpiryDateParts['day'];
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
        $newPolicyID = $db->db_tool_insert_row('ina_policies', $newData,'',1);
        //update the current
        //echo "Update Current<br>\n";
        $curNewData['inapol_replaced_by_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $curNewData, 'inapol_policy_ID = '.$this->policyID,
            $this->policyID,'','execute','');

        //create the items.
        //get them all
        $result = $db->query("SELECT * FROM ina_policy_items WHERE inapit_policy_ID = ".$this->policyID." ORDER BY inapit_policy_item_ID ASC");
        while ($item = $db->fetch_assoc($result)){
            $newItemData = $item;
            $newItemData['inapit_policy_ID'] = $newPolicyID;
            unset($newItemData['inapit_created_date_time']);
            unset($newItemData['inapit_created_by']);
            unset($newItemData['inapit_last_update_date_time']);
            unset($newItemData['inapit_last_update_by']);
            unset($newItemData['inapit_policy_item_ID']);
            echo "Create Item<br>\n";
            $db->db_tool_insert_row('ina_policy_items', $newItemData, '');
        }
        //echo "Create Installments<br>\n";
        //create the installments
        include('policyTabs/installments_class.php');
        $installments = new Installments($newPolicyID);
        if ($installments->generateInstallmentsRenewal() == false){
            $this->error = true;
            $this->errorDescription = $installments->errorDescription;
            $db->rollback_transaction();
            return false;
        }
        else {
            $installments->updateInstallmentsAmountAndCommission();
        }
        //if all ok commit
        $db->commit_transaction();
        return true;
    }

    /**
     * @param $endorsementDate 'dd/mm/yyyy'
     * @param $premium 'the new premium -+'
     * @return bool
     */
    public function endorsePolicy($endorsementDate,$premium){
        if ($this->policyData['inapol_status'] != 'Active'){
            $this->error = true;
            $this->errorDescription = 'Policy must be active to Endorse';
            return false;
        }
        if ($this->policyData['inapol_replaced_by_ID'] > 0){
            $this->error = true;
            $this->errorDescription = 'This policy is already being replaced. Find the last phase to endorse.';
            return false;
        }

        //$this->makeEndorsement($endorsementDate,$premium);

        if ($this->error == true){
            return false;
        }
        else {
            return true;
        }

    }

    private function makeEndorsement($endorsementDate,$premium){
        global $db;

        $db->start_transaction();

        //load the new data
        foreach($this->policyData as $name => $value){
            if (substr($name,0,7) == 'inapol_'){
                $newData[$name] = $value;
            }
        }
        $newStartingDateParts = explode('/',$endorsementDate);
        $newData['inapol_starting_date'] = $newStartingDateParts[2]."-".$newStartingDateParts[1]."-".$newStartingDateParts[0];
        $newData['inapol_status'] = 'Outstanding';
        $newData['inapol_process_status'] = 'Endorsement';
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
        $newPolicyID = $db->db_tool_insert_row('ina_policies', $newData,'',1);
        //update the current
        //echo "Update Current<br>\n";
        $curNewData['inapol_replaced_by_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $curNewData, 'inapol_policy_ID = '.$this->policyID,
            $this->policyID,'','execute','');

        //create the items.
        //get them all
        $result = $db->query("SELECT * FROM ina_policy_items WHERE inapit_policy_ID = ".$this->policyID." ORDER BY inapit_policy_item_ID ASC");
        while ($item = $db->fetch_assoc($result)){
            $newItemData = $item;
            $newItemData['inapit_policy_ID'] = $newPolicyID;
            unset($newItemData['inapit_created_date_time']);
            unset($newItemData['inapit_created_by']);
            unset($newItemData['inapit_last_update_date_time']);
            unset($newItemData['inapit_last_update_by']);
            unset($newItemData['inapit_policy_item_ID']);
            echo "Create Item<br>\n";
            $db->db_tool_insert_row('ina_policy_items', $newItemData, '');
        }
        //echo "Create Installments<br>\n";
        //create the installments
        include('policyTabs/installments_class.php');
        $installments = new Installments($newPolicyID);
        if ($installments->generateInstallmentsRenewal() == false){
            $this->error = true;
            $this->errorDescription = $installments->errorDescription;
            $db->rollback_transaction();
            return false;
        }
        else {
            $installments->updateInstallmentsAmountAndCommission();
        }
        //if all ok commit
        $db->commit_transaction();
        return true;


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
    public function getInstallmentsInfo(){
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
        inapi_policy_ID = ".$this->policyID);

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
        inapp_policy_ID = ".$this->policyID);

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