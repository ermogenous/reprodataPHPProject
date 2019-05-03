<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/2/2019
 * Time: 7:26 ΜΜ
 */

Class Installments
{

    private $policyID;
    private $policyData;
    private $totalPolicyPremium;
    private $totalInstallments;

    public $error = false;
    public $errorDescription = '';

    function __construct($policyID)
    {
        global $db;
        $this->policyID = $policyID;

        $this->policyData = $db->query_fetch('SELECT * FROM ina_policies WHERE inapol_policy_ID = ' . $this->policyID);
        $this->totalPolicyPremium = ($this->policyData['inapol_premium'] + $this->policyData['inapol_mif'] + $this->policyData['inapol_fees'] + $this->policyData['inapol_stamps']);
        $this->policyCommission = $this->policyData['inapol_commission'];
        $instResult = $db->query('SELECT * FROM ina_policy_installments WHERE inapi_policy_ID = ' . $this->policyID);
        $this->totalInstallments = $db->num_rows($instResult);

    }

    public function updateInstallmentsAmountAndCommission()
    {
        global $db;

        $perInst = bcdiv(($this->totalPolicyPremium / $this->totalInstallments), 1, 2);
        $instSum = 0;
        //create array with each one installment
        for ($i = 0; $i < $this->totalInstallments; $i++) {
            $instAmount[$i] = $perInst;
            $instSum += $perInst;
        }

        //if there is a diff then add it to the first installment
        if ($instSum < $this->totalPolicyPremium) {
            $instAmount[0] += $this->totalPolicyPremium - $instSum;
        }

        //now calculate the commissions.
        $perInstComm = bcdiv(($this->policyCommission / $this->totalInstallments), 1, 2);
        $commSum = 0;
        for ($i = 0; $i < $this->totalInstallments; $i++) {
            $commAmount[$i] = $perInstComm;
            $commSum += $perInstComm;
        }
        //if there is a diff then add it to the first installment
        if ($commSum < $this->policyCommission) {
            $commAmount[0] += $this->policyCommission - $commSum;
        }

        $this->updateInstallments($instAmount, $commAmount);

    }

    private function updateInstallments($installmentsAmounts, $commissionAmounts)
    {
        global $db;

        //update db
        $i = 0;
        $instResult = $db->query('SELECT * FROM ina_policy_installments WHERE inapi_policy_ID = ' . $this->policyID);
        while ($row = $db->fetch_assoc($instResult)) {

            $data['amount'] = $installmentsAmounts[$i];
            $data['commission_amount'] = $commissionAmounts[$i];
            $db->db_tool_update_row('ina_policy_installments', $data, "`inapi_policy_installments_ID` = " . $row['inapi_policy_installments_ID'],
                $row["inapi_policy_installments_ID"], '', 'execute', 'inapi_');

            $i++;
        }

    }

    public function deleteAllInstallments()
    {
        global $db;
        if ($this->policyData['inapol_status'] == 'Outstanding') {
            $instResult = $db->query('SELECT * FROM ina_policy_installments WHERE inapi_policy_ID = ' . $this->policyID);
            while ($row = $db->fetch_assoc($instResult)) {

                $db->db_tool_delete_row('ina_policy_installments', $row['inapi_policy_installments_ID'], 'inapi_policy_installments_ID = ' . $row['inapi_policy_installments_ID']);

            }
            return true;
        } else {
            $this->error = true;
            $this->errorDescription = 'Policy must be Outstanding to delete all installments';
            return false;
        }
    }

    public function generateRecursiveInstallments($amount)
    {
        global $db;
        if ($this->policyData['inapol_status'] == 'Outstanding') {

            if ($this->totalInstallments > 0) {
                $this->error = true;
                $this->errorDescription = 'Cannot generate installments. Installments already exists. Clear all first.';
                return false;
            } //everything ok to proceed.
            else {
                $startingDate = explode('-', $this->policyData['inapol_starting_date']);

                for ($i = 0; $i < $amount; $i++) {
                    $date = date('Y-m-d', mktime(0, 0, 0, ($startingDate[1] + $i), $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $data['insert_date'] = date('Y-m-d');
                    $data['policy_ID'] = $this->policyID;
                    $data['paid_status'] = 'UnPaid';
                    $data['paid_amount'] = 0;

                    //check if the installment date is withing the range of the policy
                    $policyExpiryDateSplit = explode('-', $this->policyData['inapol_expiry_date']);
                    $policyExpiry = ($policyExpiryDateSplit[0] * 10000) + ($policyExpiryDateSplit[1] * 100) + $policyExpiryDateSplit[2];
                    $instDateSplit = explode('-', $date);
                    $instDate = ($instDateSplit[0] * 10000) + ($instDateSplit[1] * 100) + $instDateSplit[2];
                    if ($instDate > $policyExpiry) {
                        //reach more than the expiry of the policy.
                        //do nothing.
                        //save all installments upto here and notify the user
                        $db->generateAlertWarning('Policy period is not long enough to generate all the installments. Some created.');
                    } else {
                        $this->insertInstallment($data);
                    }
                }
                return true;
            }


        } else {
            $this->error = true;
            $this->errorDescription = 'Policy must be Outstanding to generate recursive installments';
            return false;
        }
    }

    public function generateDividedInstallments($amount)
    {
        global $db;
        if ($this->policyData['inapol_status'] == 'Outstanding') {
            if ($this->totalInstallments > 0) {
                $this->error = true;
                $this->errorDescription = 'Cannot generate installments. Installments already exists. Clear all first.';
                return false;
            } //everything ok to proceed.
            else {
                $startingDate = explode('-', $this->policyData['inapol_starting_date']);

                if ($amount == 12) {
                    for ($i = 0; $i < $amount; $i++) {
                        $date = date('Y-m-d', mktime(0, 0, 0, ($startingDate[1] + $i), $startingDate[2], $startingDate[0]));
                        $data['document_date'] = $date;
                        $data['insert_date'] = date('Y-m-d');
                        $data['policy_ID'] = $this->policyID;
                        $data['paid_status'] = 'UnPaid';
                        $data['paid_amount'] = 0;

                        //check if the installment date is withing the range of the policy
                        $policyExpiryDateSplit = explode('-', $this->policyData['inapol_expiry_date']);
                        $policyExpiry = ($policyExpiryDateSplit[0] * 10000) + ($policyExpiryDateSplit[1] * 100) + $policyExpiryDateSplit[2];
                        $instDateSplit = explode('-', $date);
                        $instDate = ($instDateSplit[0] * 10000) + ($instDateSplit[1] * 100) + $instDateSplit[2];
                        if ($instDate > $policyExpiry) {
                            //reach more than the expiry of the policy.
                            //do nothing.
                            //save all installments upto here
                        } else {
                            $this->insertInstallment($data);
                        }
                    }
                } else if ($amount == 4) {
                    $data['insert_date'] = date('Y-m-d');
                    $data['policy_ID'] = $this->policyID;
                    //insert first installment same with starting date.
                    $date = date('Y-m-d', mktime(0, 0, 0, $startingDate[1], $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $this->insertInstallment($data);

                    //insert second after 3 months
                    $date = date('Y-m-d', mktime(0, 0, 0, ($startingDate[1] + 3), $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $this->insertInstallment($data);

                    //insert third after 3 months
                    $date = date('Y-m-d', mktime(0, 0, 0, ($startingDate[1] + 6), $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $this->insertInstallment($data);

                    //insert fourth after 3 months
                    $date = date('Y-m-d', mktime(0, 0, 0, ($startingDate[1] + 9), $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $this->insertInstallment($data);
                } else if ($amount == 2) {
                    $data['insert_date'] = date('Y-m-d');
                    $data['policy_ID'] = $this->policyID;
                    //insert first installment same with starting date.
                    $date = date('Y-m-d', mktime(0, 0, 0, $startingDate[1], $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $this->insertInstallment($data);

                    //insert second after 6 months
                    $date = date('Y-m-d', mktime(0, 0, 0, ($startingDate[1] + 6), $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $this->insertInstallment($data);
                } else if ($amount == 1) {
                    $date = date('Y-m-d', mktime(0, 0, 0, $startingDate[1], $startingDate[2], $startingDate[0]));
                    $data['document_date'] = $date;
                    $data['insert_date'] = date('Y-m-d');
                    $data['policy_ID'] = $this->policyID;
                    $this->insertInstallment($data);
                }


                return true;
            }

        } else {
            $this->error = true;
            $this->errorDescription = 'Policy must be Outstanding to generate recursive installments';
            return false;
        }
    }

    private function insertInstallment($data)
    {
        global $db;
        $newId = $db->db_tool_insert_row('ina_policy_installments', $data, '', 1, 'inapi_');

        //update the total installments of the class
        $instResult = $db->query('SELECT * FROM ina_policy_installments WHERE inapi_policy_ID = ' . $this->policyID);
        $this->totalInstallments = $db->num_rows($instResult);
        return $newId;

    }

}