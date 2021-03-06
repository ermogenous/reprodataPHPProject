<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/3/2019
 * Time: 4:24 ΜΜ
 */

class PolicyPayment
{

    public $paymentID;
    public $paymentData;
    public $error = false;
    public $errorDescription = '';

    public $newPaymentID = 0;
    public $newUnAllocatedID = 0;

    private $policyID; //the primary policy which is the first new or renewal
    private $currentPolicyID;// the current policy that created the payment
    private $installmentID; //the id of the primary policy which holds the commissions. In case of endorsements/cancellations
    private $allowedModify = true;

    private $policy;//the policy object

    function __construct($paymentID)
    {
        global $db;
        $this->paymentData = $db->query_fetch('
          SELECT * FROM 
            ina_policy_payments
            JOIN ina_policies ON inapp_policy_ID = inapol_policy_ID
            LEFT OUTER JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
            LEFT OUTER JOIN customers ON inapol_customer_ID = cst_customer_ID
            WHERE inapp_policy_payment_ID = ' . $paymentID);
        $this->paymentID = $paymentID;
        $this->installmentID = $this->paymentData['inapol_installment_ID'];
        $this->policyID = $this->paymentData['inapol_installment_ID'];
        $this->currentPolicyID = $this->paymentData['inapp_current_policy_ID'];
        include_once ($db->settings['local_url']."/ainsurance/policy_class.php");

        $this->policy = new Policy($this->paymentData['inapp_policy_ID']);

        if ($this->paymentData['inapp_locked'] == 1 || $this->paymentData['inapp_status'] != 'Outstanding') {
            $this->allowedModify = false;
        }

    }

    public function isPaymentAllowedForModify()
    {
        return $this->allowedModify;
    }

    public function deletePayment()
    {
        global $db;

        if ($this->paymentData['inapp_policy_payment_ID'] == '' || $this->paymentData['inapp_policy_payment_ID'] == 0) {
            $this->error = true;
            $this->errorDescription = 'Payment Does not exists';
        }
        if ($this->paymentData['inapp_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Payment must be outstanding to delete';
        }

        if ($this->paymentData['inapp_status'] == 'Prepayment'){
            $this->error = true;
            $this->errorDescription = 'Cannot delete a Prepayment. You can only apply/post it.';
        }

        if ($this->error == true) {
            return false;
        }

        $db->db_tool_delete_row('ina_policy_payments', $this->paymentID, 'inapp_policy_payment_ID = ' . $this->paymentID);
        return true;

    }

    public function applyPayment()
    {
        global $db;

        //echo $this->paymentData['inapol_status'];exit();

        if ($this->paymentData['inapol_status'] != 'Active' && $this->paymentData['inapol_status'] != 'Archived') {
            $this->error = true;
            $this->errorDescription = 'Policy must be Active to apply payments';
        }

        if ($this->paymentData['inapp_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Payment must be Outstanding to post';
        }
        if ($this->paymentID == '' || $this->paymentID == 0) {
            $this->error = true;
            $this->errorDescription = 'Payment ID is empty';
        }

        //only the first outstanding can be applied
        $minPaymentID = $db->query_fetch("
                  SELECT MIN(inapp_policy_payment_ID)as clo_min FROM ina_policy_payments 
                  WHERE inapp_policy_ID = " . $this->policyID . " AND inapp_status = 'Outstanding' AND inapp_process_status = 'Policy' AND inapp_locked != 1");
        if ($minPaymentID['clo_min'] != $this->paymentID) {
            $this->error = true;
            $this->errorDescription = 'Only the first outstanding payment can be applied';
        }

        if ($this->error == true) {
            return false;
        }

        //if no error proceed to post
        //loop into all installments which are unpaid or partial
        $sql = 'SELECT * FROM ina_policy_installments 
                WHERE inapi_policy_ID = ' . $this->policyID . "
                AND inapi_paid_status IN ('UnPaid', 'Partial')
                ORDER BY inapi_document_date ASC";
        $result = $db->query($sql);
        if ($db->num_rows($result) == 0) {
            $this->error = true;
            $this->errorDescription = 'Cannot find any installments';
            return false;
        }

        //init
        $amountToAllocate = $this->paymentData['inapp_amount'];
        $totalAllocatedAmount = 0;
        $totalAllocatedCommission = 0;

        //loop into all installments one by one order by date asc
        while ($installment = $db->fetch_assoc($result)) {

            //print_r($installment);
            //echo "Installment:".$installment['inapi_policy_installments_ID']."\n";
            //echo "Start - Amount to allocate:".$amountToAllocate."\n\n";


            //check if is any remaining amount to allocate
            if ($amountToAllocate > 0) {

                $installmentRemainingAmount = ($installment['inapi_amount'] - $installment['inapi_paid_amount']);
                //if the amount to allocate is more than installment then do full paid
                if ($amountToAllocate >= $installmentRemainingAmount) {


                    //subtract the amount from remaining
                    $newData['paid_amount'] = $installment['inapi_amount'];
                    $newData['paid_status'] = 'Paid';
                    $amountToAllocate -= $installmentRemainingAmount;
                    $totalAllocatedAmount += $installmentRemainingAmount;
                    //also full paid the commission
                    $newData['paid_commission_amount'] = $installment['inapi_commission_amount'];
                    $totalAllocatedCommission += $installment['inapi_commission_amount'] - $installment['inapi_paid_commission_amount'];

                    //if the amount to allocate is lower then proceed to partial paid.
                } else if ($amountToAllocate < $installmentRemainingAmount) {

                    $newData['paid_amount'] = $amountToAllocate + $installment['inapi_paid_amount'];
                    $newData['paid_status'] = 'Partial';

                    //commission paid analogy of the payment.
                    //first find the analogy of the commission.
                    // (total comm - paid comm) / (total amount - paid amount)
                    $analogy = ($installment['inapi_commission_amount'] - $installment['inapi_paid_commission_amount']) / ($installment['inapi_amount'] - $installment['inapi_paid_amount']);
                    $newData['paid_commission_amount'] = round(($amountToAllocate * $analogy), 2) + $installment['inapi_paid_commission_amount'];
                    $totalAllocatedCommission += round(($amountToAllocate * $analogy), 2);
                    //verify that the paid commission is not more than the total comm.
                    if ($newData['paid_commission_amount'] > $installment['inapi_commission_amount']) {
                        $newData['paid_commission_amount'] = $installment['inapi_commission_amount'];
                    }

                    $totalAllocatedAmount += $amountToAllocate;
                    $amountToAllocate -= $amountToAllocate;

                }

                //update the installment with the new data.
                $db->db_tool_update_row('ina_policy_installments', $newData,
                    'inapi_policy_installments_ID = ' . $installment['inapi_policy_installments_ID'],
                    $installment['inapi_policy_installments_ID'], '', 'execute', 'inapi_');

                //insert line into the ina_policy_payments_lines for future rolling back
                $lineData['policy_payment_ID'] = $this->paymentID;
                $lineData['policy_installment_ID'] = $installment['inapi_policy_installments_ID'];
                $lineData['previous_paid_amount'] = $installment['inapi_paid_amount'];
                $lineData['new_paid_amount'] = $newData['paid_amount'];
                $lineData['previous_commission_paid_amount'] = $installment['inapi_paid_commission_amount'];
                $lineData['new_commission_paid_amount'] = $newData['paid_commission_amount'];
                $lineData['previous_paid_status'] = $installment['inapi_paid_status'];
                $lineData['new_paid_status'] = $newData['paid_status'];
                $db->db_tool_insert_row('ina_policy_payments_lines', $lineData, '', 0, 'inappl_', 'execute');


            }//if amount to allocate > 0


            //echo "End - Amount to allocate:".$amountToAllocate."\n\n\n\n\n-------------------------------------";
        }//while in all the installments

        //echo "Total Allocated amount:".$totalAllocatedAmount." Payment amount:".$this->paymentData['inapp_amount'];
        if ($totalAllocatedAmount == $this->paymentData['inapp_amount']) {
            //echo "First";
            $payNewData['status'] = 'Applied';
            $payNewData['allocated_amount'] = $totalAllocatedAmount;
            $payNewData['allocated_commission'] = $totalAllocatedCommission;
            //sub agent
            //echo "Total Amount:".$totalAllocatedAmount."<br>";
            $totalPremium = $this->paymentData['inapol_premium'] + $this->paymentData['inapol_fees']
                + $this->paymentData['inapol_stamps'] + $this->paymentData['inapol_special_discount'];
            //echo "Total Premium:".$totalPremium."<br>";
            $percentAllocated = $totalAllocatedAmount / $totalPremium;
            //echo "Percent:".$percentAllocated."<br>";
            if ($this->paymentData['inapol_subagent_commission'] > 0) {
                //$payNewData['']
            }
            //exit();
            //$percentAllocated =
            $db->db_tool_update_row('ina_policy_payments', $payNewData,
                'inapp_policy_payment_ID = ' . $this->paymentID, $this->paymentID,
                '', 'execute', 'inapp_');
            return true;

        } else if ($totalAllocatedAmount < $this->paymentData['inapp_amount']) {
            //echo "Second";
            $payNewData['status'] = 'Incomplete';
            $payNewData['allocated_amount'] = $totalAllocatedAmount;
            $payNewData['allocated_commission'] = $totalAllocatedCommission;
            $this->error = true;
            $this->errorDescription = 'Total allocated amount('.$totalAllocatedAmount.')
             is not equal with the total payment('.$this->paymentData['inapp_amount'].'). Contact administrator.';
            //$db->generateAlertError('Error');
            //$db->rollback_transaction();
            return false;

        }

    }

    //make a payment from outstanding to prepayment
    //this is only allowed when the policy is outstanding. When done then fields of the policy are restricted
    /**
     * A prepayment is when you get prepaid for a policy which is not yet posted.
     *
     */
    public function prepaymentPayment(){
        global $db;

        if ($this->paymentID == '' || $this->paymentID == 0){
            $this->error = true;
            $this->errorDescription = 'Payment ID is not set';
            return false;
        }

        if ($this->paymentData['inapol_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Policy must be Outstanding to set payment as prepaid';
            return false;
        }

        if ($this->paymentData['inapp_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Payment must be Outstanding to set as prepaid';
            return false;
        }

        $newData['fld_status'] = 'Prepayment';
        $db->db_tool_update_row('ina_policy_payments',$newData,'inapp_policy_payment_ID = '.$this->paymentID,
            $this->paymentID,'fld_','execute','inapp_');

        return true;

    }

    public function makePrepaymentToOutstanding(){
        global $db;

        if ($this->paymentData['inapp_status'] != 'Prepayment') {
            $this->error = true;
            $this->errorDescription = 'Payment must be Prepayment to set as Outstanding';
            return false;
        }

        if ($this->paymentData['inapol_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Policy must be Outstanding to set Prepayment as Outstanding';
            return false;
        }

        $newData['fld_status'] = 'Outstanding';
        $db->db_tool_update_row('ina_policy_payments',$newData,'inapp_policy_payment_ID = '.$this->paymentID,
            $this->paymentID,'fld_','execute','inapp_');

        return true;
    }

    public function postPayment()
    {
        global $db,$main;

        //validations
        if ($this->paymentData['inapp_status'] != 'Applied') {
            $this->error = true;
            $this->errorDescription = 'Cannot post non applied payment';
        }

        if ($this->error == true) {
            return false;
        }

        $policy = new Policy($this->policyID);
        //get period total premiums before the update of the payment so it can take the total paid and unpaid
        $periodPremiums = $policy->getPeriodTotalPremiums();

        $newData['fld_status'] = 'Active';
        $db->db_tool_update_row('ina_policy_payments', $newData, 'inapp_policy_payment_ID = ' . $this->paymentID, $this->paymentID,
            'fld_', 'execute', 'inapp_');

        if ($policy->policyData['inainc_enable_commission_release'] == 1) {

            $transactions = $policy->getAccountTransactionsList();

            //check if this payment is the last payment that pays off all the remaining amount
            $lastPayment = false;
            if ($periodPremiums['totalUnpaid'] == $this->paymentData['inapp_allocated_amount']) {
                $lastPayment = true;
            }

            //find the rate of the payment. Each commission will be multiplied by this amount
            //$paymentRate = $this->paymentData['inapp_allocated_commission'] / $policy->policyData['inapol_commission'];
            //find the total unpaid premium


            $paymentRate = $this->paymentData['inapp_allocated_amount'] / $periodPremiums['totalUnpaid'];

            //in case this payment is a return then premiums need to change and rate
            //because amounts in the payment need to go exactly as is in the accounts are returns
            /*
             * no need
            if ($this->paymentData['inapp_payment_type'] == 'Returns') {
                //need to get the policy data of the current policy and not the primary
                $currentPolicyData = $db->query_fetch('SELECT * FROM ina_policies WHERE inapol_policy_ID = ' . $this->currentPolicyID);
                $periodPremiums['agent_level1_commission'] = $currentPolicyData['inapol_agent_level1_commission'];
                $periodPremiums['agent_level2_commission'] = $currentPolicyData['inapol_agent_level2_commission'];
                $periodPremiums['agent_level3_commission'] = $currentPolicyData['inapol_agent_level3_commission'];
                $periodPremiums['overwrite_commission'] = $currentPolicyData['inapol_overwrite_commission'];
                //set the rate to 1 so all the amount to go as is
                $paymentRate = 1;
            }*/

            //check if any subagents exists from ina_policy
            //Agent 1
            if ($policy->policyData['inapol_agent_level1_commission'] > 0) {
                //$agents1Commission = $policy->policyData['inapol_agent_level1_commission'] * $paymentRate;
                $agents1Commission = ($periodPremiums['agent_level1_commission'] - $periodPremiums['agent_level1_released']) * $paymentRate;
                if ($lastPayment) {
                    $agents3Commission = $periodPremiums['agent_level1_commission'] - $periodPremiums['agent_level1_released'];
                }
                $agents1Commission = $db->floorp($agents1Commission, 2);
                $policyNewData['fld_agent_level1_released'] = $policy->policyData['inapol_agent_level1_released'] + $agents1Commission;
            }
            //Agent 2
            if ($policy->policyData['inapol_agent_level2_commission'] > 0) {
                //$agents2Commission = $policy->policyData['inapol_agent_level2_commission'] * $paymentRate;
                $agents2Commission = ($periodPremiums['agent_level2_commission'] - $periodPremiums['agent_level2_released']) * $paymentRate;
                if ($lastPayment) {
                    $agents3Commission = $periodPremiums['agent_level2_commission'] - $periodPremiums['agent_level2_released'];
                }
                $agents2Commission = $db->floorp($agents2Commission, 2);
                $policyNewData['fld_agent_level2_released'] = $policy->policyData['inapol_agent_level2_released'] + $agents2Commission;
            }
            //Agent 3
            if ($policy->policyData['inapol_agent_level3_commission'] > 0) {
                //$agents3Commission = $policy->policyData['inapol_agent_level3_commission'] * $paymentRate;
                $agents3Commission = ($periodPremiums['agent_level3_commission'] - $periodPremiums['agent_level3_released']) * $paymentRate;
                if ($lastPayment) {
                    $agents3Commission = $periodPremiums['agent_level3_commission'] - $periodPremiums['agent_level3_released'];
                }
                $agents3Commission = $db->floorp($agents3Commission, 2);
                $policyNewData['fld_agent_level3_released'] = $policy->policyData['inapol_agent_level3_released'] + $agents3Commission;
            }
            //Overwrite Agent
            $overwriteCommission = 0;
            if ($policy->policyData['inapol_overwrite_agent_ID'] > 0) {
                //$overwriteCommission = $policy->policyData['inapol_overwrite_commission'] * $paymentRate;
                $overwriteCommission = ($periodPremiums['overwrite_commission'] - $periodPremiums['overwrite_released']) * $paymentRate;
                //check if this is the last payment then just use all the remaining balance
                if ($lastPayment) {
                    $overwriteCommission = $periodPremiums['overwrite_commission'] - $periodPremiums['overwrite_released'];
                }
                $overwriteCommission = $db->floorp($overwriteCommission, 2);

                $policyNewData['fld_overwrite_released'] = $policy->policyData['inapol_overwrite_released'] + $overwriteCommission;
            }
            $policyNewData['fld_commission_released'] = $policy->policyData['inapol_commission_released'] + $this->paymentData['inapp_allocated_commission'];
            //update the policy with the new release amounts
            //update the primary policy with installment id
            $db->db_tool_update_row('ina_policies', $policyNewData, 'inapol_policy_ID = ' . $this->installmentID,
                $this->policyID, 'fld_', 'execute', 'inapol_');

/*
            echo "Allocated Amount:".$this->paymentData['inapp_allocated_amount'].PHP_EOL;
            echo "Gross Premium:".$periodPremiums['gross_premium'].PHP_EOL;
            echo "Unpaid:".$periodPremiums['totalUnpaid'].PHP_EOL;
            echo "Paid:".$periodPremiums['totalPaid'].PHP_EOL;
            echo "Agent 1 Commission:".$agents1Commission.PHP_EOL;
            echo "Agent 2 Commission:".$agents2Commission.PHP_EOL;
            echo "Agent 3 Commission:".$agents3Commission.PHP_EOL;
            echo "Overwrite Commission:".$overwriteCommission.PHP_EOL;
            echo "Payment Rate:".$paymentRate.PHP_EOL;
            echo "LastPayment:".$lastPayment.PHP_EOL;
            print_r($periodPremiums);
            print_r($policy->policyData);
            exit();
*/


            $insuranceSettings = $db->query_fetch('SELECT * FROM ina_settings');
            //header data
            $headerData['documentID'] = $insuranceSettings['inaset_ins_comm_ac_document_ID'];
            $headerData['entityID'] = $transactions[1]['entityID'];
            $headerData['comments'] = 'Policy ID:' . $this->policyID . " Commissions";
            $headerData['fromModule'] = 'AInsurance';
            $headerData['fromIDDescription'] = 'PaymentID';
            $headerData['fromID'] = $this->paymentID;

            //Set 1 main office commissions
            //get the transactions
            $allTransactionsData = $policy->getAccountTransactionsList();
            $transactionsData[1] = $allTransactionsData[1];
            $transactionsData[2] = $allTransactionsData[2];
            //fix the amounts with the release only amounts
            $transactionsData[1]['amount'] = $this->paymentData['inapp_allocated_commission'];
            $transactionsData[2]['amount'] = $this->paymentData['inapp_allocated_commission'];
            include_once($main["local_url"].'/accounts/transactions/transactions_class.php');
            $transaction = new AccountsTransaction(0);
            $transaction->makeNewTransaction($headerData, $transactionsData);
            if ($transaction->error == true) {
                $this->error = true;
                $this->errorDescription = $transaction->errorDescription;
                return false;
            }
            //set 2 agent 1 commissions
            if ($policy->policyData['inapol_agent_level1_commission'] > 0) {
                unset($transactionsData);
                $transactionsData[1] = $allTransactionsData[3];
                $transactionsData[2] = $allTransactionsData[4];
                //fix the amounts
                $transactionsData[1]['amount'] = $agents1Commission;
                $transactionsData[2]['amount'] = $agents1Commission;
                $headerData['entityID'] = $transactions[3]['entityID'];
                $transaction->makeNewTransaction($headerData, $transactionsData);
                if ($transaction->error == true) {
                    $this->error = true;
                    $this->errorDescription = $transaction->errorDescription;
                    return false;
                }
            }

            //set 3 agent 2 commissions
            if ($policy->policyData['inapol_agent_level2_commission'] > 0) {
                unset($transactionsData);
                $transactionsData[1] = $allTransactionsData[5];
                $transactionsData[2] = $allTransactionsData[6];
                //fix the amounts
                $transactionsData[1]['amount'] = $agents2Commission;
                $transactionsData[2]['amount'] = $agents2Commission;
                $headerData['entityID'] = $transactions[5]['entityID'];
                $transaction->makeNewTransaction($headerData, $transactionsData);
                if ($transaction->error == true) {
                    $this->error = true;
                    $this->errorDescription = $transaction->errorDescription;
                    return false;
                }
            }

            //set 4agent 3 commissions
            if ($policy->policyData['inapol_agent_level3_commission'] > 0) {
                unset($transactionsData);
                $transactionsData[1] = $allTransactionsData[7];
                $transactionsData[2] = $allTransactionsData[8];
                //fix the amounts
                $transactionsData[1]['amount'] = $agents3Commission;
                $transactionsData[2]['amount'] = $agents3Commission;
                $headerData['entityID'] = $transactions[7]['entityID'];
                $transaction->makeNewTransaction($headerData, $transactionsData);
                if ($transaction->error == true) {
                    $this->error = true;
                    $this->errorDescription = $transaction->errorDescription;
                    return false;
                }
            }

            //set Overwrite agent commissions
            if ($policy->policyData['inapol_overwrite_agent_ID'] > 0) {
                unset($transactionsData);
                $transactionsData[1] = $allTransactionsData[9];
                $transactionsData[2] = $allTransactionsData[10];
                //fix the amounts
                $transactionsData[1]['amount'] = $overwriteCommission;
                $transactionsData[2]['amount'] = $overwriteCommission;
                $headerData['entityID'] = $transactions[9]['entityID'];
                $transaction->makeNewTransaction($headerData, $transactionsData);
                if ($transaction->error == true) {
                    $this->error = true;
                    $this->errorDescription = $transaction->errorDescription;
                    return false;
                }
            }

            //check if brokerage then need to transfer the commissions receivable to commissions received.
            //and also move customers (debtor) amount to
            if ($policy->policyData['inainc_brokerage_agent'] == 'brokerage'){
                unset($transactionsData);
                if ($lastPayment == true){
                    $transCommission = $this->policy->getTotalInstallmentCommissionAmount() - $this->policy->getTotalInstallmentCommissionPaidAmount();
                }
                else {
                    $transCommission = $this->paymentData['inapp_allocated_commission'];
                }

                //1. credit a 7011 insurance company received
                //   debit a 3021 company receivables
                unset($result);
                $accountID = $this->paymentData['inainc_debtor_account_ID'];
                $accountDetails = $db->query_fetch('SELECT acacc_name,acacc_code,acacc_entity_ID FROM ac_accounts WHERE acacc_account_ID = ' . $accountID);
                $accountName = $accountDetails['acacc_name'];
                $accountCode = $accountDetails['acacc_code'];
                $result[1]['type'] = 'Dr';
                $result[1]['name'] = $accountName;
                $result[1]['code'] = $accountCode;
                $result[1]['accountID'] = $accountID;
                $result[1]['entityID'] = $this->policy->policyData['cst_entity_ID'];//$accountDetails['acacc_entity_ID'];
                $result[1]['amount'] = $transCommission;

                $accountID = $this->paymentData['inainc_revenue_account_ID'];
                $accountDetails = $db->query_fetch('SELECT acacc_name,acacc_code,acacc_entity_ID FROM ac_accounts WHERE acacc_account_ID = ' . $accountID);
                $accountName = $accountDetails['acacc_name'];
                $accountCode = $accountDetails['acacc_code'];
                $result[2]['type'] = 'Cr';
                $result[2]['name'] = $accountName;
                $result[2]['code'] = $accountCode;
                $result[2]['accountID'] = $accountID;
                $result[2]['entityID'] = $this->policy->policyData['cst_entity_ID'];//$accountDetails['acacc_entity_ID'];
                $result[2]['amount'] = $transCommission;

                /* make both in one journal
                unset($transactionsData);

                $transactionsData[1] = $result[1];
                $transactionsData[2] = $result[2];
                //fix the amounts
                $headerData['entityID'] = $result[1]['entityID'];
                $headerData['comments'] = 'Policy ID:' . $this->policyID . " Ins.Expense";
                $transaction->makeNewTransaction($headerData, $transactionsData);
                if ($transaction->error == true) {
                    $this->error = true;
                    $this->errorDescription = "Ins. Expense (".$result[1]['code']." - ".$result[2]['code'].") "
                        .$transaction->errorDescription;
                    return false;
                }
                */

                //2. Credit the debtor 3020
                //   Debit a current asset 3020001
//**************THIS NEED TO BE FIXED. ON PAYMENT THE USER WILL SELECT THE PAYMENT METHOD AND THE ACCOUNT WILL BE DEFINED THERE***************************************************************************
                $accountCode = '3020100';
                $accountDetails = $db->query_fetch('SELECT acacc_name,acacc_code,acacc_entity_ID FROM ac_accounts WHERE acacc_code = "' . $accountCode.'"');
                //check if the account exists
                if ($accountDetails['acacc_code'] != $accountCode){
                    $this->error = true;
                    $this->errorDescription = 'Temporary account 3020100 does not exists';
                    return false;
                }
                $accountName = $accountDetails['acacc_name'];
                $accountCode = $accountDetails['acacc_code'];
                $result[3]['type'] = 'Dr';
                $result[3]['name'] = $accountName;
                $result[3]['code'] = $accountCode;
                $result[3]['accountID'] = $accountID;
                $result[3]['entityID'] = $this->policy->policyData['cst_entity_ID'];//$accountDetails['acacc_entity_ID'];
                $result[3]['amount'] = $this->paymentData['inapp_amount'];

                //find the customers A/C
                $accountID = $this->paymentData['inainc_revenue_account_ID'];
                $accountDetails = $db->query_fetch('SELECT acacc_name,acacc_code,acacc_entity_ID FROM ac_accounts WHERE acacc_account_ID = ' . $accountID);
                $accountName = $accountDetails['acacc_name'];
                $accountCode = $accountDetails['acacc_code'];
                $result[4]['type'] = 'Cr';
                $result[4]['name'] = $accountName;
                $result[4]['code'] = $accountCode;
                $result[4]['accountID'] = $accountID;
                $result[4]['entityID'] = $this->policy->policyData['cst_entity_ID'];//$accountDetails['acacc_entity_ID'];
                $result[4]['amount'] = $this->paymentData['inapp_amount'];

                unset($transactionsData);
                $transactionsData[1] = $result[1];
                $transactionsData[2] = $result[2];
                $transactionsData[3] = $result[3];
                $transactionsData[4] = $result[4];
                //fix the amounts
                $headerData['entityID'] = $result[1]['entityID'];
                $headerData['comments'] = 'Policy ID:' . $this->policyID . " Customer Payment";
                $transaction->makeNewTransaction($headerData, $transactionsData);
                if ($transaction->error == true) {
                    $this->error = true;
                    $this->errorDescription = "Customer Dr/Cr.(".$result[1]['code']." - ".$result[2]['code'].") ".$transaction->errorDescription;
                    return false;
                }
                //print_r($this->policy);
                //echo "Tot Inst:".$this->paymentData['inapp_amount'];;
                //exit();

            }



            //get all accounting transactions of this policy to verify that total amount of commission is correct.
            //if not add the difference in this transaction


        }//if commission release

        return true;
    }

    /** NOT WORKING. Accounting transactions are not reversed
     * @return bool
     */
    public function reversePostPayment()
    {
        global $db;
        $this->errorDescription = 'Reverse post payment not fully functional. A/c transactions are not reversed';
        $this->error = true;
        return false;
        //Checks
        if ($this->paymentData['inapp_status'] != 'Applied') {
            $this->error = true;
            $this->errorDescription = 'Must be applied to reverse';
        }

        //check if the payment is not locked
        if ($this->paymentData['inapp_locked'] == 1) {
            $this->error = true;
            $this->errorDescription = 'This payment is locked because endorsement/cancellation was activated after the payment. Permanent locked payment.';
        }

        //check if its the last applied payment
        $maxPaymentID = $db->query_fetch("SELECT MAX(inapp_policy_payment_ID)as clo_max FROM ina_policy_payments WHERE inapp_policy_ID = " . $this->policyID . " AND inapp_status = 'Applied'");
        if ($maxPaymentID['clo_max'] != $this->paymentID) {
            $this->error = true;
            $this->errorDescription = 'Can only reverse the last applied payment.';
        }


        if ($this->error == true) {
            return false;
        }

        //fetch the lines
        $sql = "SELECT * FROM ina_policy_payments_lines WHERE inappl_policy_payment_ID = " . $this->paymentID;
        $result = $db->query($sql);
        while ($line = $db->fetch_assoc($result)) {
            $newData['paid_status'] = $line['inappl_previous_paid_status'];
            $newData['paid_amount'] = $line['inappl_previous_paid_amount'];
            $newData['paid_commission_amount'] = $line['inappl_previous_commission_paid_amount'];
            $db->db_tool_update_row('ina_policy_installments', $newData,
                'inapi_policy_installments_ID = ' . $line['inappl_policy_installment_ID'],
                $line['inappl_policy_installment_ID'], '', 'execute', 'inapi_');

            //delete the line
            $db->db_tool_delete_row('ina_policy_payments_lines', $line['inappl_policy_payments_line_ID'],
                'inappl_policy_payments_line_ID = ' . $line['inappl_policy_payments_line_ID']);
        }

        //fix the payment.
        $newPaymentData['status'] = 'Outstanding';
        $newPaymentData['allocated_amount'] = '0';
        $newPaymentData['allocated_commission'] = '0';
        $db->db_tool_update_row('ina_policy_payments', $newPaymentData,
            'inapp_policy_payment_ID = ' . $this->paymentID, $this->paymentID
            , '', 'execute', 'inapp_');

        return true;
    }

    public function updateInstallmentsCommissions()
    {
        global $db;

        //loop into all the installments

    }

    /**
     * This will create another payment and set the unallocated one as deleted. If partial then the same and a new unallocated will be created.
     * @param $policyID
     * @param $amount
     * @return true/false
     */
    function applyUnallocatedPayment($policyID, $amount)
    {
        global $db;

        if ($this->paymentData['inapp_process_status'] != 'Unallocated') {
            $this->error = true;
            $this->errorDescription = 'Must be unallocated record to allocate';
            return false;
        }

        if ($this->paymentData['inapp_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Payment must be outstanding to apply unallocated.';
            return false;
        }

        if ($policyID == '' || $policyID == 0) {
            $this->error = true;
            $this->errorDescription = 'Must supply the policy which will be allocated.';
            return false;
        }

        if ($amount == '' || $amount == 0) {
            $this->error = true;
            $this->errorDescription = 'Must provide an amount for the allocation.';
            return false;
        }

        $policyData = $db->query_fetch('SELECT * FROM ina_policies WHERE inapol_policy_ID = ' . $policyID);

        //make the payment
        $newData['amount'] = $amount;
        $newData['policy_ID'] = $policyID;
        $newData['customer_ID'] = $policyData['inapol_customer_ID'];
        $newData['status'] = 'Outstanding';
        $newData['process_status'] = 'Policy';
        $newData['payment_date'] = date('Y-m-d');
        $newData['locked'] = 0;
        $newPaymentID = $db->db_tool_insert_row('ina_policy_payments', $newData, '', 1, 'inapp_');
        $this->newPaymentID = $newPaymentID;

        if ($this->paymentData['inapp_amount'] > $amount) {
            //Partial. need to create another unallocated record.

            $newUnAll['amount'] = $this->paymentData['inapp_amount'] - $amount;
            $newUnAll['policy_ID'] = $policyID;
            $newUnAll['customer_ID'] = $this->paymentData['inapp_customer_ID'];
            $newUnAll['status'] = 'Outstanding';
            $newUnAll['process_status'] = 'Unallocated';
            $newUnAll['payment_date'] = date('Y-m-d');
            $newUnAll['locked'] = 1;
            $newUnallID = $db->db_tool_insert_row('ina_policy_payments', $newUnAll, '', 1, 'inapp_');
            $this->newUnAllocatedID = $newUnallID;

        } else {
            //full allocation. no need to create another record.
        }

        //update the current unallocated record
        $curUnAll['status'] = 'Deleted';
        $curUnAll['created_payment_ID'] = $newPaymentID;
        $curUnAll['replaced_by_payment_ID'] = $newUnallID;
        $db->db_tool_update_row('ina_policy_payments', $curUnAll,
            'inapp_policy_payment_ID = ' . $this->paymentID, $this->policyID,
            '', 'execute', 'inapp_');

        return true;

    }
}