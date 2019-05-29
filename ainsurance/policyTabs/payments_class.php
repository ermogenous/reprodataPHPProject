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
    private $policyID;

    function __construct($paymentID)
    {
        global $db;
        $this->paymentData = $db->query_fetch('
          SELECT * FROM 
            ina_policy_payments
            JOIN ina_policies ON inapp_policy_ID = inapol_policy_ID
            WHERE inapp_policy_payment_ID = ' . $paymentID);
        $this->paymentID = $paymentID;
        $this->policyID = $this->paymentData['inapp_policy_ID'];

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

        if ($this->error == true) {
            return false;
        }

        $db->db_tool_delete_row('ina_policy_payments', $this->paymentID, 'inapp_policy_payment_ID = ' . $this->paymentID);
        return true;

    }

    public function postPayment(){
        global $db;

        if ($this->paymentData['inapol_status'] != 'Active'){
            $this->error = true;
            $this->errorDescription = 'Policy must be Active to post payments';
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
        $minPaymentID = $db->query_fetch("SELECT MIN(inapp_policy_payment_ID)as clo_min FROM ina_policy_payments WHERE inapp_policy_ID = ".$this->policyID." AND inapp_status = 'Outstanding'");
        if ($minPaymentID['clo_min'] != $this->paymentID){
            $this->error = true;
            $this->errorDescription = 'Only the first outstanding payment can be applied';
        }

        if ($this->error == true) {
            return false;
        }

        //if no error proceed to post
        //loop into all installments which are unpaid or partial
        $sql = 'SELECT * FROM ina_policy_installments 
                WHERE inapi_policy_ID = ' . $this->paymentData['inapp_policy_ID'] . "
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
                if ($amountToAllocate >=  $installmentRemainingAmount) {


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
                    $analogy = ($installment['inapi_commission_amount'] - $installment['inapi_paid_commission_amount']) /  ($installment['inapi_amount'] - $installment['inapi_paid_amount']);
                    $newData['paid_commission_amount'] = round(($amountToAllocate * $analogy),2) + $installment['inapi_paid_commission_amount'] ;
                    $totalAllocatedCommission += round(($amountToAllocate * $analogy),2);
                    //verify that the paid commission is not more than the total comm.
                    if ($newData['paid_commission_amount'] > $installment['inapi_commission_amount']){
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
            $payNewData['status'] = 'Applied';
            $payNewData['allocated_amount'] = $totalAllocatedAmount;
            $payNewData['allocated_commission'] = $totalAllocatedCommission;
            $db->db_tool_update_row('ina_policy_payments', $payNewData,
                'inapp_policy_payment_ID = ' . $this->paymentID, $this->paymentID,
                '', 'execute', 'inapp_');
            return true;

        } else if ($totalAllocatedAmount < $this->paymentData['inapp_amount']) {
            $payNewData['status'] = 'Incomplete';
            $payNewData['allocated_amount'] = $totalAllocatedAmount;
            $payNewData['allocated_commission'] = $totalAllocatedCommission;
            $db->generateAlertError('Error');
            $db->rollback_transaction();
            return false;

        }

    }


    function reversePostPayment()
    {
        global $db;

        //Checks
        if ($this->paymentData['inapp_status'] != 'Applied') {
            $this->error = true;
            $this->errorDescription = 'Must be applied to reverse';
        }

        //check if its the last applied payment
        $maxPaymentID = $db->query_fetch("SELECT MAX(inapp_policy_payment_ID)as clo_max FROM ina_policy_payments WHERE inapp_policy_ID = ".$this->policyID." AND inapp_status = 'Applied'");
        if ($maxPaymentID['clo_max'] != $this->paymentID){
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
            $db->db_tool_delete_row('ina_policy_payments_lines',$line['inappl_policy_payments_line_ID'],
            'inappl_policy_payments_line_ID = '.$line['inappl_policy_payments_line_ID']);
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

    function updateInstallmentsCommissions()
    {
        global $db;

        //loop into all the installments

    }
}