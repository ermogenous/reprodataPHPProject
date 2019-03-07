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

    function __construct($paymentID)
    {
        global $db;
        $this->paymentData = $db->query_fetch('SELECT * FROM ina_policy_payments WHERE inapp_policy_payment_ID = ' . $paymentID);
        $this->paymentID = $paymentID;

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

    public function postPayment()
    {
        global $db;

        if ($this->paymentData['inapp_status'] != 'Outstanding') {
            $this->error = true;
            $this->errorDescription = 'Payment must be Outstanding to post';
        }
        if ($this->paymentID == '' || $this->paymentID == 0) {
            $this->error = true;
            $this->errorDescription = 'Payment ID is empty';
        }

        if ($this->error == true) {
            return false;
        }

        //if no error proceed to post
        //loop into all installments
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

        $amountToAllocate = $this->paymentData['inapp_amount'] - $this->paymentData['inapp_allocated_amount'];
        $commissionToAllocate = $this->paymentData['inapp_commission_amount'] - $this->paymentData['inapp_allocated_commission'];
        $totalAllocatedAmount = 0;
        $totalAllocatedCommission = 0;

        while ($installment = $db->fetch_assoc($result)) {

            //if amount is equal with the installment
            //print_r($installment);
            //echo "<br><br>";

            //check if is any remaining amount to allocate
            if ($amountToAllocate > 0) {

                if ($amountToAllocate >= $installment['inapi_amount']) {

                    //subtract the amount from remaining
                    $newData['paid_amount'] = $installment['inapi_amount'];
                    $newData['paid_status'] = 'Paid';
                    $amountToAllocate -= $installment['inapi_amount'];
                    $totalAllocatedAmount += $installment['inapi_amount'];

                } else if ($amountToAllocate < $installment['inapi_amount']) {

                    $newData['paid_amount'] = $amountToAllocate;
                    $newData['paid_status'] = 'Partial';
                    $totalAllocatedAmount += $amountToAllocate;
                    $amountToAllocate -= $amountToAllocate;

                }

                $newData['paid_commission_amount'] = 0;
                if ($commissionToAllocate > 0) {

                    if ($commissionToAllocate >= $installment['inapi_commission_amount']) {
                        $newData['paid_commission_amount'] = $installment['inapi_commission_amount'];
                        $totalAllocatedCommission += $installment['inapi_commission_amount'];
                        $commissionToAllocate -= $installment['inapi_commission_amount'];
                    } else if ($commissionToAllocate < $installment['inapi_commission_amount']) {
                        $newData['paid_commission_amount'] = $commissionToAllocate;
                        $totalAllocatedCommission += $commissionToAllocate;
                        $commissionToAllocate -= $commissionToAllocate;
                    }
                }

                $db->db_tool_update_row('ina_policy_installments', $newData,
                    'inapi_policy_installments_ID = ' . $installment['inapi_policy_installments_ID'],
                    $installment['inapi_policy_installments_ID'], '', 'execute', 'inapi_');

                //insert line
                $lineData['policy_payment_ID'] = $this->paymentID;
                $lineData['policy_installment_ID'] = $installment['inapi_policy_installments_ID'];
                $lineData['previous_paid_amount'] = $installment['inapi_paid_amount'];
                $lineData['new_paid_amount'] = $newData['paid_amount'];
                $lineData['previous_commission_paid_amount'] = $installment['inapi_paid_commission_amount'];
                $lineData['new_commission_paid_amount'] = $newData['paid_commission_amount'];
                $lineData['previous_paid_status'] = $installment['inapi_paid_status'];
                $lineData['new_paid_status'] = $newData['paid_status'];
                $db->db_tool_insert_row('ina_policy_payments_lines', $lineData, '', 0, 'inappl_', 'execute');


            }
        }


        if ($totalAllocatedAmount == $this->paymentData['inapp_amount']) {
            $payNewData['status'] = 'Applied';
            $payNewData['allocated_amount'] = $totalAllocatedAmount;
            $payNewData['allocated_commission'] = $totalAllocatedCommission;
        } else if ($totalAllocatedAmount < $this->paymentData['inapp_amount']) {
            $payNewData['status'] = 'Incomplete';
            $payNewData['allocated_amount'] = $totalAllocatedAmount;
            $payNewData['allocated_commission'] = $totalAllocatedCommission;
        }
        $db->db_tool_update_row('ina_policy_payments', $payNewData,
            'inapp_policy_payment_ID = ' . $this->paymentID, $this->paymentID,
            '', 'execute', 'inapp_');
        return true;
    }

    function reversePostPayment()
    {
        global $db;

        //Checks
        if ($this->paymentData['inapp_status'] != 'Applied') {
            $this->error = true;
            $this->errorDescription = 'Must be applied to reverse';
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