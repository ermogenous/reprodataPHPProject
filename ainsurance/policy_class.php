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

        $data['premium'] = $total['clo_total_premium'];
        $data['mif'] = $total['clo_total_mif'];

        $db->db_tool_update_row('ina_policies', $data, 'inapol_policy_ID = '.$this->policyID, $this->policyID,'', 'execute', 'inapol_');

    }


}