<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/1/2019
 * Time: 11:11 ΠΜ
 */

class Policy {

    public $policyID;
    public $policyData;
    public $totalPremium;
    public $mif;
    public $fees;
    public $commission;

    public $error = false;
    public $errorDescription;

    function __construct($policyID)
    {
        global $db;
        $this->policyID = $policyID;
        $this->policyData = $db->query_fetch('SELECT * FROM ina_policies WHERE inapol_policy_ID = '.$policyID);

    }
    //updates the policy premium by sum the policyItems premium/mif/commission
    public function updatePolicyPremium(){
        global $db;

        //get the total premium
        $sql = "
            SELECT
            SUM(inapit_premium) as clo_total_premium,
            SUM(inapit_mif)as clo_total_mif
            FROM
            ina_policy_items
            WHERE
            inapit_policy_ID = ".$this->policyID;
        $total = $db->query_fetch($sql);

        $data['premium'] = round($total['clo_total_premium'],2);
        $data['mif'] = round($total['clo_total_mif'],2);

        $db->db_tool_update_row('ina_policies', $data, 'inapol_policy_ID = '.$this->policyID, $this->policyID,'', 'execute', 'inapol_');

    }

    public function checkInsuranceTypeChange($newInsType){
        global $db;

        //get current type tab name
        $currentType = $db->query_fetch('SELECT * FROM ina_insurance_codes WHERE inaic_insurance_code_ID = '.$this->policyData['inapol_type_code_ID']);
        $newType = $db->query_fetch('SELECT * FROM ina_insurance_codes WHERE inaic_insurance_code_ID = '.$newInsType);

        if ($currentType == $newType){
            return true;
        }
        else {
            return false;
        }
    }

    public function deletePolicyItem($inapitID){
        global $db;
        if ($this->policyData['inapol_status'] == 'Outstanding'){

            $db->db_tool_delete_row('ina_policy_items', $inapitID,'inapit_policy_item_ID = '.$inapitID);

            $this->updatePolicyPremium();

            return true;

        }
        else {
            $this->error = true;
            $this->errorDescription = 'To delete policy item status must be outstanding.';
            return false;
        }

    }

    public function deletePolicy(){
        global $db;

        if ($this->policyData['inapol_status'] == 'Outstanding'){
            //first delete the policy items

            $result = $db->query_fetch('SELECT * FROM ina_policy_items WHERE inapit_policy_ID = '.$this->policyID);
            while ($pit = $db->fetch_assoc($result)){

                $db->db_tool_delete_row('ina_policy_items', $pit['inapit_policy_item_ID'],'inapit_policy_item_ID = '.$pit['inapit_policy_item_ID']);

            }

            //delete the policy
            $db->db_tool_delete_row('ina_policies', $this->policyID, 'inapol_policy_ID = '.$this->policyID);

            return true;
        }
        else {
            $this->error = true;
            $this->errorDescription = 'To delete policy status must be outstanding.';
            return false;
        }
    }

    public function activatePolicy(){
        global $db;
        $this->errorDescription = 'Some error. Activate function needs build';
        return false;
    }

    public function cancelPolicy(){
        global $db;
        $this->errorDescription = 'Some error. Cancel function needs build';
        return false;
    }


}

function getPolicyClass($status){
    return 'inapol'.$status.'Color';
}