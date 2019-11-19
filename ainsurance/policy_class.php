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
    public $companyCommission;//holds the commission % based on the underwriter/type/company
    public $commissionCalculation;
    private $insuranceSettings;

    public $error = false;
    public $errorDescription;


    //Accounts
    private $accountsUsed;

    function __construct($policyID)
    {
        global $db;
        $this->policyID = $policyID;

        //check what type of accounts this has from settings
        $this->accountsUsed = $db->get_setting('ac_advanced_accounts_enable');
        if ($this->accountsUsed == 1) {
            $this->accountsUsed = 'Advanced';
        }
        $this->loadInsuranceSettings();

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


        //get the company commission
        //if advanced accounts then get it from companies
        //if not advanced accounts then get it from the underwriter
        $typeCode = strtolower($this->policyData['inapol_type_code']);
        if ($this->accountsUsed == 'Advanced') {

            $this->companyCommission = $this->policyData['inainc_commission_' . $typeCode];

        } else {

            //find the underwriter company commission record
            $sql = "SELECT
                    *
                    FROM
                    ina_underwriter_companies
                    WHERE inaunc_underwriter_ID = " . $this->policyData['inapol_underwriter_ID'] . "
                    AND inaunc_insurance_company_ID = " . $this->policyData['inapol_insurance_company_ID'];
            $commData = $db->query_fetch($sql);
            $this->companyCommission = $commData['inaunc_commission_' . $typeCode];

        }

        $this->commissionCalculation = $commData['inaunc_commission_calculation'];

        $this->installmentID = $this->policyData['inapol_installment_ID'];

        $this->totalPremium = round(($this->policyData['inapol_premium'] + /*$this->policyData['inapol_mif'] +*/
            $this->policyData['inapol_fees'] + $this->policyData['inapol_stamps']), 2);
        $this->commission = $this->policyData['inapol_commission'];

        $result = $db->query_fetch('SELECT COUNT(*)as clo_total FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);
        $this->totalItems = $result['clo_total'];

    }

    //STATIC FUNCTIONS
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

        //if admin then remove all so to have access to all
        if ($db->user_data['usr_user_rights'] == 0){
            $whereClause = ' > 0';
        }

        //echo "<br>".$totalFound."->".$whereClause."<br>";
        if ($whatToReturn == 'where') {
            return $whereClause;
        } else if ($whatToReturn == 'totalFound') {
            return $totalFound;
        }

    }

    public static function getUnderwriterData()
    {
        global $db;

        $sql = "SELECT * FROM ina_underwriters WHERE inaund_user_ID = " . $db->user_data['usr_users_ID'];
        return $db->query_fetch($sql);

    }

    public function getPolicyUnderwriterData()
    {
        global $db;

        $sql = "SELECT * FROM 
                  ina_underwriters 
                  JOIN users ON usr_users_ID = inaund_user_ID
                  WHERE inaund_underwriter_ID = " . $this->policyData['inapol_underwriter_ID'];
        $data = $db->query_fetch($sql);

        //get commission
        $typeCode = strtolower($this->policyData['inapol_type_code']);
        $sql = "SELECT * FROM
                  ina_underwriter_companies 
                  WHERE
                  inaunc_underwriter_ID = " . $this->policyData['inapol_underwriter_ID'] . "
                  AND inaunc_insurance_company_ID = " . $this->policyData['inapol_insurance_company_ID'];
        $commData = $db->query_fetch($sql);
        $data['clo_commission_percent'] = $commData['inaunc_commission_' . $typeCode];
        return $data;
    }

    public function getParentUnderwriterData(){
        global $db;

        $underwriter = $db->query_fetch('SELECT * FROM ina_underwriters WHERE inaund_underwriter_ID = '.$this->policyData['inapol_underwriter_ID']);

        $sql = "SELECT * FROM 
                  ina_underwriters 
                  JOIN users ON usr_users_ID = inaund_user_ID
                  WHERE inaund_underwriter_ID = " .$underwriter['inaund_subagent_ID'] ;
        $data = $db->query_fetch($sql);

        //get commission
        $typeCode = strtolower($this->policyData['inapol_type_code']);
        $sql = "SELECT * FROM
                  ina_underwriter_companies 
                  WHERE
                  inaunc_underwriter_ID = " . $data['inaund_underwriter_ID'] . "
                  AND inaunc_insurance_company_ID = " . $this->policyData['inapol_insurance_company_ID'];
        $commData = $db->query_fetch($sql);
        $data['clo_commission_percent'] = $commData['inaunc_commission_' . $typeCode];
        return $data;
    }

    public function getPeriodTotalPremiums()
    {
        global $db;

        $sql = "SELECT * FROM ina_policies WHERE inapol_installment_ID = " . $this->policyData['inapol_installment_ID'];
        $result = $db->query($sql);
        $return = [];
        while ($row = $db->fetch_assoc($result)) {
            $return['premium'] += $row['inapol_premium'];
            $return['commission'] += $row['inapol_commission'];
            $return['fees'] += $row['inapol_fees'];
            $return['stamps'] += $row['inapol_stamps'];
        }
        return $return;
    }

    public function validatePolicyNumber()
    {
        global $db;
        $sql = "
        SELECT
        COUNT(*)as clo_total_policies
        FROM
        ina_policies
        WHERE
        inapol_underwriter_ID " . $this->getAgentWhereClauseSql() . "
        AND inapol_policy_number = '" . $this->policyData['inapol_policy_number'] . "'
        AND inapol_policy_ID != '" . $this->policyID . "'
        ";
        $check = $db->query_fetch($sql);
        if ($check['clo_total_policies'] > 0) {
            $this->error = true;
            $this->errorDescription = 'Policy is already been used by another policy.';
            return false;
        } else {
            return true;
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
            //everything ok.
            return true;
        } else {
            //need to check if items exists.
            $sql = "SELECT
            COUNT(*)as clo_total_items
            FROM
            ina_policy_items
            WHERE
            inapit_policy_ID = " . $this->policyID;
            $check = $db->query_fetch($sql);
            if ($check['clo_total_items'] > 0) {
                //items found -> error
                $this->error = true;
                $this->errorDescription = 'Cannot change policy type without deleting all items first.';
                return false;
            } else {
                return true;
            }

        }
    }

    public function getTypeFullName()
    {
        global $db;
        if ($this->policyData['inapol_type_code'] == 'Motor') {
            return $db->showLangText('Vehicles', 'Αυτοκίνητα');
        } else if ($this->policyData['inapol_type_code'] == 'Fire') {
            return $db->showLangText('Risk Location', 'Τοποθεσία Κινδύνου');
        } else if ($this->policyData['inapol_type_code'] == 'PA') {
            return $db->showLangText('Members', 'Άτομα');
        } else if ($this->policyData['inapol_type_code'] == 'EL') {
            return $db->showLangText('Members', 'Άτομα');
        } else if ($this->policyData['inapol_type_code'] == 'PI') {
            return $db->showLangText('Members', 'Άτομα');
        } else if ($this->policyData['inapol_type_code'] == 'PL') {
            return $db->showLangText('Risk Location', 'Τοποθεσία Κινδύνου');
        } else if ($this->policyData['inapol_type_code'] == 'Medical') {
            return $db->showLangText('Members', 'Άτομα');
        } else if ($this->policyData['inapol_type_code'] == 'Travel') {
            return $db->showLangText('Members', 'Άτομα');
        }

        return $this->policyData['inapol_type_code'];
    }

    //affects the input form
    public function getInputType()
    {
        if ($this->policyData['inapol_type_code'] == 'Motor') {
            return 'Vehicle';
        } else if ($this->policyData['inapol_type_code'] == 'Fire') {
            return 'RiskLocation';
        } else if ($this->policyData['inapol_type_code'] == 'PA') {
            return 'Member';
        } else if ($this->policyData['inapol_type_code'] == 'EL') {
            return 'Member';
        } else if ($this->policyData['inapol_type_code'] == 'PI') {
            return 'Member';
        } else if ($this->policyData['inapol_type_code'] == 'PL') {
            return 'RiskLocation';
        } else if ($this->policyData['inapol_type_code'] == 'Medical') {
            return 'Member';
        }

        return $this->policyData['inapol_type_code'];
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
            //delete one by one for log file entries
            $result = $db->query_fetch('SELECT * FROM ina_policy_items WHERE inapit_policy_ID = ' . $this->policyID);
            while ($pit = $db->fetch_assoc($result)) {

                $db->db_tool_delete_row('ina_policy_items', $pit['inapit_policy_item_ID'], 'inapit_policy_item_ID = ' . $pit['inapit_policy_item_ID']);

            }

            //delete installments if any
            $instResult = $db->query('SELECT * FROM ina_policy_installments WHERE inapi_policy_ID = ' . $this->policyID);
            while ($inst = $db->fetch_assoc($instResult)) {
                $db->db_tool_delete_row('ina_policy_installments', $inst['inapi_policy_installments_ID'], 'inapi_policy_installments_ID = ' . $inst['inapi_policy_installments_ID']);
            }

            //if its replacing another policy. fix previous policy
            if ($this->policyData['inapol_replacing_ID'] > 0) {
                $newData['replaced_by_ID'] = null;
                $db->db_tool_update_row('ina_policies', $newData, 'inapol_policy_ID = ' . $this->policyData['inapol_replacing_ID'], $this->policyData['inapol_replacing_ID'],
                    '', 'execute', 'inapol_');
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
            $totalInstallments = $db->query_fetch("SELECT COUNT(*)as clo_total_installments FROM ina_policy_installments WHERE inapi_policy_ID = " . $this->installmentID);
            if ($totalInstallments['clo_total_installments'] < 1) {
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

            //if advanced accounts send the transactions for commissions and sub agent commissions
            if ($this->accountsUsed == 'Advanced'){
                $this->insertAccountTransactions();
            }
        }


        //$this->validForActive = true;
        //$this->errorDescription = 'Some error. Activate function needs build';
        return true;
    }

    public function cancelPolicy($cancelDate, $premium, $fees, $commission)
    {
        global $db;

        if ($this->policyData['inapol_status'] != 'Active') {
            $this->error = true;
            $this->errorDescription = 'Only Active policies can be cancelled.';
            return false;
        }

        if ($premium > 0) {
            $this->error = true;
            $this->errorDescription = 'Cancellation premium must be negative.';
            return false;
        }

        if ($fees > 0) {
            $this->error = true;
            $this->errorDescription = 'Cancellation fees must be negative.';
            return false;
        }

        if ($commission > 0) {
            $this->error = true;
            $this->errorDescription = 'Cancellation commission must be negative.';
            return false;
        }

        //check min max premiums.
        $totalPeriodPrem = $this->getPeriodTotalPremiums();

        if ($premium < ($totalPeriodPrem['premium'] * -1)) {
            $this->error = true;
            $this->errorDescription = 'Cancellation premium cannot be less than ' . ($totalPeriodPrem['premium'] * -1) . '.';
            return false;
        }

        if ($fees < ($totalPeriodPrem['fees'] * -1)) {
            $this->error = true;
            $this->errorDescription = 'Cancellation fees cannot be less than ' . ($totalPeriodPrem['fees'] * -1) . '.';
            return false;
        }

        if ($commission < ($totalPeriodPrem['commission'] * -1)) {
            $this->error = true;
            $this->errorDescription = 'Cancellation commission cannot be less than ' . ($totalPeriodPrem['commission'] * -1) . '.';
            return false;
        }

        //if all ok proceed to create the new phase.
        //load the new data
        foreach ($this->policyData as $name => $value) {
            if (substr($name, 0, 7) == 'inapol_') {
                $newData[substr($name, 7)] = $value;
            }
        }

        $newData['starting_date'] = $db->convert_date_format($cancelDate, 'dd/mm/yyyy', 'yyyy-mm-dd');
        $newData['status'] = 'Outstanding';
        $newData['process_status'] = 'Cancellation';
        $newData['premium'] = $premium;
        $newData['mif'] = 0;
        $newData['commission'] = $commission;
        $newData['fees'] = $fees;
        $newData['stamps'] = 0;
        $newData['replacing_ID'] = $this->policyID;
        $instNewData['installment_ID'] = $this->policyData['inapol_installment_ID'];


        unset($newData['created_date_time']);
        unset($newData['created_by']);
        unset($newData['last_update_date_time']);
        unset($newData['last_update_by']);
        unset($newData['replaced_by_ID']);
        unset($newData['policy_ID']);

        $newPolicyID = $db->db_tool_insert_row('ina_policies', $newData, '', 1, 'inapol_');
        $this->newCancellationID = $newPolicyID;

        //update the current
        //echo "Update Current<br>\n";
        $curNewData['replaced_by_ID'] = $newPolicyID;
        $db->db_tool_update_row('ina_policies', $curNewData, 'inapol_policy_ID = ' . $this->policyID,
            $this->policyID, '', 'execute', 'inapol_');


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
            return false;
        }
        //check if its replaced
        if ($this->policyData['inapol_replaced_by_ID'] > 0) {
            $this->error = true;
            $this->errorDescription = 'Cannot review. Policy is already being replaced by another.';
            return false;
        }

        return $this->renewPolicy($expiryDate);


    }

    /***
     * @param null $expiryDate ->Format: dd/mm/yyyy
     * @return true/false
     */
    private function renewPolicy($expiryDate = null)
    {
        global $db;

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
        $newData['inapol_financial_date'] = $newData['inapol_starting_date'];
        $newData['inapol_expiry_date'] = $newExpiryDateParts['year'] . "-" . $newExpiryDateParts['month'] . "-" . $newExpiryDateParts['day'];
        $newData['inapol_status'] = 'Outstanding';
        $newData['inapol_process_status'] = 'Renewal';

        //find the total amounts from all the phases if endorsements exists
        $sql = 'SELECT
            SUM(inapol_premium)as clo_premium,
            SUM(inapol_commission)as clo_commission
            FROM
            ina_policies
            WHERE
            inapol_installment_ID = ' . $this->policyData['inapol_installment_ID'];
        $totalAmounts = $db->query_fetch($sql);

        $newData['inapol_premium'] = $totalAmounts['clo_premium'];
        $newData['inapol_mif'] = 0;
        $newData['inapol_commission'] = $totalAmounts['clo_commission'];
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

            //remove all the empty fields
            foreach ($newItemData as $name => $value) {
                if ($value == '') {
                    unset($newItemData[$name]);
                }
            }
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
            //$db->rollback_transaction();
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

        //load the new data
        foreach ($this->policyData as $name => $value) {
            if (substr($name, 0, 7) == 'inapol_') {
                $newData[$name] = $value;
            }
        }
        $newStartingDateParts = explode('/', $endorsementDate);
        $newData['inapol_starting_date'] = $newStartingDateParts[2] . "-" . $newStartingDateParts[1] . "-" . $newStartingDateParts[0];
        $newData['inapol_financial_date'] = $newData['inapol_starting_date'];
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
            $unAllData['inapp_status'] = 'Outstanding';
            $unAllData['inapp_process_status'] = 'Unallocated';
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
                $pay['inapp_policy_payment_ID'], '', 'execute', 'inapp_');

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

    //Advanced Accounts Functions
    private function issueAccountTransactions()
    {
        global $db;

        //for basic accounts
        if ($db->dbSettings['accounts']['value'] == 'basic') {

        }
    }

    private function loadInsuranceSettings()
    {
        global $db;
        $this->insuranceSettings = $db->query_fetch('SELECT * FROM ina_settings');
    }

    public function getAccountTransactionsList()
    {
        global $db;

        if ($this->accountsUsed != 'Advanced') {
            $this->errorDescription = 'Advanced Accounts are not enabled';
            return [
                "Error" => $this->errorDescription
            ];
        }

        if ($this->insuranceSettings['inaset_enable_acc_transactions'] != 1) {
            $this->errorDescription = 'Auto Generate Accounting transactions is set to NO';
            return [
                "Error" => $this->errorDescription
            ];
        }

        if ($this->policyData['inainc_debtor_account_ID'] == '') {
            $this->error = true;
            $this->errorDescription = 'No debtor account defined for this company';
            return [
                "Error" => $this->errorDescription
            ];
        }

        if ($this->policyData['inainc_revenue_account_ID'] == '') {
            $this->error = true;
            $this->errorDescription = 'No revenue account defined for this company';
            return [
                "Error" => $this->errorDescription
            ];
        }

        //Company transactions
        $companyData = $db->query_fetch('
          SELECT * FROM ina_insurance_companies WHERE inainc_insurance_company_ID = '.$this->policyData['inapol_insurance_company_ID']);
        //1. Debit
        $companyDrAccountID = $companyData['inainc_debtor_account_ID'];
        $companyDrAccountDetails = $db->query_fetch('SELECT acacc_name,acacc_code FROM ac_accounts WHERE acacc_account_ID = ' . $companyDrAccountID);
        $companyDrAccountName = $companyDrAccountDetails['acacc_name'];
        $companyDrAccountCode = $companyDrAccountDetails['acacc_code'];
        $result[1]['type'] = 'Dr';
        $result[1]['name'] = $companyDrAccountName;
        $result[1]['code'] = $companyDrAccountCode;
        $result[1]['accountID'] = $companyDrAccountID;
        $result[1]['amount'] = $this->policyData['inapol_commission'];
        //echo "Dr Account: ".$companyDrAccountCode." - ".$companyDrAccountName." Amount:".$result[1]['ammount']."<br>";

        //2. Credit
        $companyCrAccountID = $companyData['inainc_revenue_account_ID'];
        //get the name of the account
        $companyCrAccountDetails = $db->query_fetch('SELECT acacc_name,acacc_code FROM ac_accounts WHERE acacc_account_ID = ' . $companyCrAccountID);
        $companyCrAccountName = $companyCrAccountDetails['acacc_name'];
        $companyCrAccountCode = $companyCrAccountDetails['acacc_code'];
        $result[2]['type'] = 'Cr';
        $result[2]['name'] = $companyCrAccountName;
        $result[2]['code'] = $companyCrAccountCode;
        $result[2]['accountID'] = $companyCrAccountID;
        $result[2]['amount'] = $this->policyData['inapol_commission'];
        //echo "Cr Account: ".$companyCrAccountCode.' - '.$companyCrAccountName." Amount:".$result[2]['ammount']."<br>";

        //Sub Agent Transactions

        //First check if the agent is sub-sub agent
        $subAgent = false;
        $subSubAgent = false;
        $subAgentData = $this->getPolicyUnderwriterData();
        $subSubAgentData = [];
        if ($subAgentData['inaund_subagent_ID'] == 0 || $subAgentData['inaund_subagent_ID'] == ''){
            $subAgent = false;
            $subSubAgent = false;
        }
        else if ($subAgentData['inaund_subagent_ID'] == -1){
            $subAgent = true;
            $subSubAgent = false;
        }
        else if ($subAgentData['inaund_subagent_ID'] > 0){
            $subAgent = true;
            $subSubAgent = true;
            $subSubAgentData = $db->query_fetch('SELECT * FROM ina_underwriters WHERE inaund_underwriter_ID = '.$subAgentData['inaund_underwriter_ID']);
        }

        //First check if the agent is sub agent

        //if -1 then is top sub agent
        if ($subAgent == true) {

            //1.Dr
            $subAgentDrAccountID = $subAgentData['inaund_subagent_dr_account_ID'];
            $subAgentDrAccountDetails = $db->query_fetch('SELECT acacc_name,acacc_code FROM ac_accounts WHERE acacc_account_ID = ' . $subAgentDrAccountID);
            $subAgentDrAccountName = $subAgentDrAccountDetails['acacc_name'];
            $subAgentDrAccountCode = $subAgentDrAccountDetails['acacc_code'];
            $result[3]['type'] = 'Dr';
            $result[3]['name'] = $subAgentDrAccountName;
            $result[3]['code'] = $subAgentDrAccountCode;
            $result[3]['accountID'] = $subAgentDrAccountID;
            $result[3]['amount'] = $this->policyData['inapol_subagent_commission'];
            //echo "<br>Dr Account: ".$subAgentDrAccountCode.' - '.$subAgentDrAccountName." Amount:".$result[3]['ammount']."<br>";

            //2.Cr
            $subAgentCrAccountID = $subAgentData['inaund_subagent_cr_account_ID'];
            $subAgentCrAccountDetails = $db->query_fetch('SELECT acacc_name,acacc_code FROM ac_accounts WHERE acacc_account_ID = ' . $subAgentCrAccountID);
            $subAgentCrAccountName = $subAgentCrAccountDetails['acacc_name'];
            $subAgentCrAccountCode = $subAgentCrAccountDetails['acacc_code'];
            $result[4]['type'] = 'Cr';
            $result[4]['name'] = $subAgentCrAccountName;
            $result[4]['code'] = $subAgentCrAccountCode;
            $result[4]['accountID'] = $subAgentCrAccountID;
            $result[4]['amount'] = $this->policyData['inapol_subagent_commission'];
            //echo $result[4]['type']." Account: ".$subAgentCrAccountCode.' - '.$subAgentCrAccountName." Amount:".$result[4]['ammount']."<br>";

        }


        return $result;
    }

    private function insertAccountTransactions(){
        global $db;
        include('../accounts/transactions/transactions_class.php');

        $transactions = $this->getAccountTransactionsList();
        $headerData['documentID'] = $this->insuranceSettings['inaset_ins_comm_ac_document_ID'];
        $headerData['accountID'] = $transactions[1]['accountID'];
        $headerData['comments'] = 'Policy ID:'.$this->policyID." Commissions";
        $headerData['fromModule'] = 'AInsurance';
        $headerData['fromIDDescription'] = 'PolicyID';
        $headerData['fromID'] = $this->policyID;

        $transaction = new AccountsTransaction(0);
        $result = $transaction->makeNewTransaction($headerData, $transactions);

        if ($result == true){
            $this->error = true;
            $this->errorDescription = $transaction->errorDescription;
        }
    }

}

function getPolicyClass($status)
{
    return 'inapol' . $status . 'Color';
}