<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/6/2019
 * Time: 4:04 ΜΜ
 */

class aInsuranceBalance
{

    private $customerID;

    function __construct($customerID)
    {
        $this->customerID = $customerID;

    }

    public function changeCustomer($customerID)
    {
        $this->customerID = $customerID;
    }

    public function getBalanceSql()
    {
        global $db;
        if ($this->customerID > 0) {
            $sql = "SELECT
                SUM(inapi_amount)as clo_total_amount,
                SUM(inapi_paid_amount)as clo_total_paid
                FROM
                ina_policies
                JOIN ina_policy_installments ON inapol_policy_ID = inapi_policy_ID
                WHERE
                inapol_customer_ID = " . $this->customerID . "
                AND inapol_status = 'Active'
                AND (inapi_paid_status = 'UnPaid' OR inapi_paid_status = 'Partial') 
        ";
            return $sql;
        } else {
            return null;
        }
    }

    public function getBalance()
    {
        global $db;
        if ($this->customerID > 0) {
            $result = $db->query_fetch($this->getBalanceSql());
            $balance = $result['clo_total_amount'] - $result['clo_total_paid'];
            return $balance;
        } else {
            return null;
        }
    }


}