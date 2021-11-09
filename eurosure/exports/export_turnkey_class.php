<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 19/8/2021
 * Time: 10:57 π.μ.
 */


class exportTurnkey {



    public function __construct()
    {

    }

    public function exportPoliciesToDB($policies){
        global $estkCon,$db;

        foreach ($policies as $row){

            //if motor
            if ($row['pclo_major_category'] == 'MOTOR'){
                $row['iaipol_product_code'] = 'EUR-MOTOR';
            }

            //if endorsement
            $cancellationdate = '';
            if ($row['iaipol_process_status'] == 'E'){
                $endorsementSql = ",DATE('".$row['iaipol_phase_starting_date']."') as iaipol_cancellation_date".PHP_EOL;
                $endorsementSql .= ",".$row['pclo_end_refund_premium']." as iaipol_refund_premium".PHP_EOL;
                $endorsementSql .= ",".$row['pclo_end_refund_mif']." as iaipol_refund_mif".PHP_EOL;
                $endorsementSql .= ",".$row['pclo_end_refund_stamps']." as iaipol_refund_stamps".PHP_EOL;
                $endorsementSql .= ",".$row['pclo_end_refund_fees']." as iaipol_refund_fees".PHP_EOL;
                $endorsementSql .= ",".round($row['pclo_end_charge_premium'] + $row['pclo_end_charge_fees']
                        + $row['pclo_end_charge_stamps'] + $row['pclo_end_charge_mif'],2)." as iaipol_client_value".PHP_EOL;
                $endorsementSql .= ",".round($row['pclo_end_refund_premium'] + $row['pclo_end_refund_mif']
                        + $row['pclo_end_refund_stamps'] + $row['pclo_end_refund_fees'],2)." as iaipol_refund_client_value".PHP_EOL;


                $row['iaipol_premium'] = $row['pclo_end_charge_premium'];
                $row['iaipol_fees'] = $row['pclo_end_charge_fees'];
                $row['iaipol_stamps'] = $row['pclo_end_charge_stamps'];
                $row['iaipol_mif'] = $row['pclo_end_charge_mif'];
            }

            //Client value is the total premium owed by the client
            $row['iaipol_client_value'] = $row['iaipol_premium'] + $row['iaipol_fees'] + $row['iaipol_stamps'] + $row['iaipol_mif'];

            $sql = "
                INSERT INTO iaimportpolicies WITH AUTO NAME
                SELECT '".$row['iaipol_synthesis_in_out']."' as iaipol_synthesis_in_out,
                       '".$row['iaipol_row_created_by']."' as iaipol_row_created_by,
                       '".$row['iaipol_row_last_edit_by']."' as iaipol_row_last_edit_by,
                       '".$row['iaipol_row_status']."' as iaipol_row_status,
                       '".$row['iaipol_row_status_last_update_by']."' as iaipol_row_status_last_update_by,
                       '".$row['iaipol_policy_import_reference']."' as iaipol_policy_import_reference,
                       '".$row['iaipol_policy_number']."' as iaipol_policy_number,
                       '".$row['iaipol_internal_reference']."' as iaipol_internal_reference,
                       '".$row['iaipol_inscomp_code']."' as iaipol_inscomp_code, /* Eurosure */ 
                       '".$row['iaipol_agent_code']."' as iaipol_agent_code,
                       '".$row['iaipol_client_code']."' as iaipol_client_code,
                       '".$row['iaipol_product_code']."' as iaipol_product_code,
                       '".$row['iaipol_status_flag']."' as iaipol_status_flag, /* Allways outstanding!*/
                       '".$row['iaipol_process_status']."' as iaipol_process_status,
                       '".$row['iaipol_currency_code']."' as iaipol_currency_code,
                       1 as iaipol_currency_rate,
                       'EUR' as iaipol_origin_currency_code,
                       1 as iaipol_origin_currency_rate,
                       'CYP' as iaipol_alpha_key1, /* Required optino from DesignMode!*/
                       DATE('".$row['iaipol_period_starting_date']."') as iaipol_period_starting_date,
                       DATE('".$row['iaipol_phase_starting_date']."') as iaipol_phase_starting_date,
                       ".$row['iaipol_policy_period']." as iaipol_policy_period,
                       ".$row['iaipol_policy_year']." as iaipol_policy_year,
                       DATE('".$row['iaipol_expiry_date']."') as iaipol_expiry_date,
                       
                       ".$row['iaipol_premium']." as iaipol_premium,
                       ".$row['iaipol_fees']." as iaipol_fees,
                       ".$row['iaipol_stamps']." as iaipol_stamps,
                       ".$row['iaipol_mif']." as iaipol_mif,
                       
                       ".$row['iaipol_client_value']." as iaipol_client_value,
                       ".$row['iaipol_comm_perc_ins_comp01']." as iaipol_comm_perc_ins_comp01,
                       ".$row['iaipol_comm_value_ins_comp01']." as iaipol_comm_value_ins_comp01,
                       ".$row['iaipol_agency_fee']." as iaipol_agency_fee,
                       ".$row['iaipol_ins_comp_value']." as iaipol_ins_comp_value,
                       '".$row['iaipol_agency_collect']."' as iaipol_agency_collect,
                       '".$row['iaipol_embedded_commission']."' as iaipol_embedded_commission,
                       '".$row['iaipol_ins_comp_embedded_commission']."' as iaipol_ins_comp_embedded_commission,
                       '".$row['iaipol_reins_embedded_commission']."' as iaipol_reins_embedded_commission,
                       '".$row['iaipol_process_retention']."' as iaipol_process_retention,
                       '".$row['iaipol_original_module']."' as iaipol_original_module, /* Important */
                       '".$row['iaipol_original_table']."' as iaipol_original_table, /* Important */
                       '".$row['iaipol_original_auto_serial']."' as iaipol_original_auto_serial, /* Important */
                       'EUROSURE DUMMY' as iaipol_dummy_retention_reinsurer
                       ".$endorsementSql."
                FROM DUMMY; COMMIT;
            ";
            //print_r($row);
            //echo "<hr>".$sql;
            //exit();
            if ($this->checkIfPolicyExists($row)){
                //client already exists. Do nothing
                echo "Policy:".$row['iaipol_policy_number']."(".$row['iaipol_policy_import_reference'].") Already exists. Skip<br>";
            }
            else {
                $estkCon->query($sql);
                echo "Policy:".$row['iaipol_policy_number']."(".$row['iaipol_policy_import_reference'].") Executed ";
                if ($this->checkIfPolicyExists($row)){
                    echo "Validated - Inserted<br>";
                }
                else {
                    echo "Validated - NOT INSERTED. CHECK FOR ERRORS<br>";
                }

            }
        }
    }

    public function exportClientsToDB($clients){
        global $estkCon;

        //loop into the client
        foreach($clients as $row){

            //fixes
            //1. if is company the fields first_name and salutation must be null
            if ($row['iaicl_account_type'] == 'C'){
                $salutation = 'null';
                $firstName = 'null';
            }
            else {
                $salutation = "'".$row['iaicl_salutation']."'";
                $firstName = "'".$row['iaicl_first_name']."'";
            }


            $sql = "INSERT INTO iaimportclients WITH AUTO NAME
                        SELECT '".$row['iaicl_synthesis_in_out']."' as iaicl_synthesis_in_out,
                       '".$row['iaicl_row_created_by']."' as iaicl_row_created_by,
                       '".$row['iaicl_row_last_edit_by']."' as iaicl_row_last_edit_by,
                       '".$row['iaicl_row_status']."' as iaicl_row_status,
                       '".$row['iaicl_row_status_last_update_by']."' as iaicl_row_status_last_update_by,
                       '".$row['iaicl_client_code']."' as iaicl_client_code,
                       '".$row['iaicl_agent_code']."' as iaicl_agent_code, /* Direct Busi */
                       '".$row['iaicl_account_type']."' as iaicl_account_type,
                       ".$salutation." as iaicl_salutation,
                       ".$firstName." as iaicl_first_name,
                       '".$row['iaicl_long_description']."' as iaicl_long_description,
                       '".$row['iaicl_identity_card']."' as iaicl_identity_card,
                       '".$row['iaicl_currency_code']."' as iaicl_currency_code,
                       '".$row['iaicl_account_code']."' as iaicl_account_code,
                       '".$row['iaicl_alias_description']."' as iaicl_alias_description
                        FROM DUMMY;COMMIT;";
            //echo $sql."<hr>";
            if ($this->checkIfClientExists($row)){
                //client already exists. Do nothing
                echo "Client:".$row['iaicl_client_code']." Already exists. Skip<br>";
            }
            else {
                $estkCon->query($sql);
                echo "Client:".$row['iaicl_client_code']." Executed ";
                if ($this->checkIfClientExists($row)){
                    echo "Validated - Inserted<br>";
                }
                else {
                    echo "Validated - NOT INSERTED. CHECK FOR ERRORS<br>";
                }

            }
            //echo $sql."\n\n\n\n<br><br>";
            /*
            //loop into the fields
            foreach($row as $name => $value){
                echo $name."->".$value."<br>";
            }
            */
        }


    }

    public function exportSituationsToDB($situations){
        global $estkCon;

        foreach ($situations as $row){
            $sql = "
                INSERT INTO iaimportpolsit WITH AUTO NAME
                SELECT '".$row['iaipst_synthesis_in_out']."' as iaipst_synthesis_in_out,
                       '".$row['iaipst_row_created_by']."' as iaipst_row_created_by,
                       '".$row['iaipst_row_last_edit_by']."' as iaipst_row_last_edit_by,
                       '".$row['iaipst_row_status']."' as iaipst_row_status,
                       '".$row['iaipst_row_status_last_update_by']."' as iaipst_row_status_last_update_by,
                       '".$row['iaipst_inactive_for_endorsement']."' as iaipst_inactive_for_endorsement, /* For Endorsement use if item no longer exists */
                       '".$row['iaipst_policy_import_reference']."' as iaipst_policy_import_reference,
                       '".$row['iaipst_situation_code']."' as iaipst_situation_code,
                       '".$row['iaipst_description']."' as iaipst_description
                FROM DUMMY; COMMIT;
            ";
            if ($this->checkIfSituationExists($row)){
                //client already exists. Do nothing
                echo "Situation:".$row['iaipst_policy_import_reference']." Already exists. Skip<br>";
            }
            else {
                $estkCon->query($sql);
                echo "Situation:".$row['iaipst_policy_import_reference']." Executed ";
                if ($this->checkIfSituationExists($row)){
                    echo "Validated - Inserted<br>";
                }
                else {
                    echo "Validated - NOT INSERTED. CHECK FOR ERRORS<hr>";
                    echo $sql."<hr>";
                }

            }
        }
    }

    public function exportPolicyItemsToDB($policyItems){
        global $estkCon;

        foreach ($policyItems as $row){
            $sql = "
                INSERT INTO iaimportpolitems WITH AUTO NAME
                SELECT '".$row['iaipit_synthesis_in_out']."' as iaipit_synthesis_in_out,
                   '".$row['iaipit_row_created_by']."' as iaipit_row_created_by,
                   '".$row['iaipit_row_last_edit_by']."' as iaipit_row_last_edit_by,
                   '".$row['iaipit_row_status']."' as iaipit_row_status,
                   '".$row['iaipit_row_status_last_update_by']."' as iaipit_row_status_last_update_by,
                   '".$row['iaipit_inactive_for_endorsement']."' as iaipit_inactive_for_endorsement, /* For Endorsement use if item no longer exists */
                   '".$row['iaipit_policy_import_reference']."' as iaipit_policy_import_reference,
                   '".$row['iaipit_situation_code']."' as iaipit_situation_code,
                   NULL as iaipit_item_category_code, /* Item Category Null Or Valid Code! */
                   '".$row['iaipit_item_code']."' as iaipit_item_code,
                   ".$row['iaipit_pit_increment']." as iaipit_pit_increment,
                   ".$row['iaipit_insured_amount']." as iaipit_insured_amount
                FROM DUMMY; COMMIT;
            ";
            if ($this->checkIfPolicyItemExists($row)){
                //client already exists. Do nothing
                echo "Policy Item:".$row['iaipit_item_code']." Already exists. Skip<br>";
            }
            else {
                $estkCon->query($sql);
                echo "Policy Item:".$row['iaipit_item_code']." Executed ";
                if ($this->checkIfPolicyItemExists($row)){
                    echo "Validated - Inserted<br>";
                }
                else {
                    echo "Validated - NOT INSERTED. CHECK FOR ERRORS<hr>\n\n";
                    echo $sql."\n\n";
                    echo "<hr>\n\n";
                }

            }
        }
    }

    public function exportPolicyItemAuxToDB($policyItemAux){
        global $estkCon;

        foreach ($policyItemAux as $row){
            $sql = "
                INSERT INTO iaimportpolitems WITH AUTO NAME
                SELECT '".$row['iaipia_synthesis_in_out']."' as iaipia_synthesis_in_out,
                   '".$row['iaipia_row_created_by']."' as iaipia_row_created_by,
                   '".$row['iaipia_row_last_edit_by']."' as iaipia_row_last_edit_by,
                   '".$row['iaipia_row_status']."' as iaipia_row_status,
                   '".$row['iaipia_row_status_last_update_by']."' as iaipia_row_status_last_update_by,
                   '".$row['iaipia_policy_import_reference']."' as iaipia_policy_import_reference,
                   '".$row['iaipia_situation_code']."' as iaipia_situation_code,
                   NULL as iaipia_item_category_code, /* Item Category Null Or Valid Code! */
                   '".$row['iaipia_item_code']."' as iaipia_item_code,
                   ".$row['iaipia_pit_increment']." as iaipia_pit_increment,
                   '".$row['iaipia_numeric_value01']."' as iaipia_numeric_value01
                FROM DUMMY; COMMIT;
            ";
            if ($this->checkIfPolicyItemAuxExists($row)){
                //policy item aux already exists. Do nothing
                echo "Policy Item Aux:".$row['iaipia_item_code']." Already exists. Skip<br>";
            }
            else {
                $estkCon->query($sql);
                echo "Policy Item Aux:".$row['iaipia_item_code']." Executed ";
                if ($this->checkIfPolicyItemAuxExists($row)){
                    echo "Validated - Inserted<br>";
                }
                else {
                    echo "Validated - NOT INSERTED. CHECK FOR ERRORS<hr>\n\n";
                    echo $sql."\n\n";
                    echo "<hr>\n\n";
                }

            }
        }
    }

    public function exportPolicyItemsPremiumToDB($policyItemsPremium){
        global $estkCon;

        foreach ($policyItemsPremium as $row){
            $sql = "
                INSERT INTO iaimportpolitprem WITH AUTO NAME
                    SELECT '".$row['iaipip_synthesis_in_out']."' as iaipip_synthesis_in_out,
                           '".$row['iaipip_row_created_by']."' as iaipip_row_created_by,
                           '".$row['iaipip_row_last_edit_by']."' as iaipip_row_last_edit_by,
                           '".$row['iaipip_row_status']."' as iaipip_row_status,
                           '".$row['iaipip_row_status_last_update_by']."' as iaipip_row_status_last_update_by,
                           '".$row['iaipip_inactive_for_endorsement']."' as iaipip_inactive_for_endorsement, /* For Endorsement use if item no longer exists */
                           '".$row['iaipip_policy_import_reference']."' as iaipip_policy_import_reference,
                           '".$row['iaipip_situation_code']."' as iaipip_situation_code,
                           '".$row['iaipip_item_category_code']."' as iaipip_item_category_code, /* Item Category Null Or Valid Code! */
                           '".$row['iaipip_item_code']."' as iaipip_item_code,
                           ".$row['iaipip_pit_increment']." as iaipip_pit_increment,
                           '".$row['iaipip_peril_code']."' as iaipip_peril_code,
                           '".$row['iaipip_amount_rate']."' as iaipip_amount_rate,
                           ".$row['iaipip_peril_value']." as iaipip_peril_value,
                           ".$row['iaipip_period_premium']." as iaipip_period_premium,
                           ".$row['iaipip_year_premium']." as iaipip_year_premium,
                           ".$row['iaipip_comm_type']." as iaipip_comm_type,
                           ".$row['iaipip_period_calculate']." as iaipip_period_calculate
                    FROM DUMMY; COMMIT;
            ";
            if ($this->checkIfPolicyItemPremiumExists($row)){
                //Item Premium already exists. Do nothing
                echo "Policy Item Premium:".$row['iaipip_policy_import_reference']." Already exists. Skip<br>";
            }
            else {
                $estkCon->query($sql);
                echo "Policy Item Premium:".$row['iaipip_policy_import_reference']." Executed ";
                if ($this->checkIfPolicyItemPremiumExists($row)){
                    echo "Validated - Inserted<br>";
                }
                else {
                    echo "Validated - NOT INSERTED. CHECK FOR ERRORS<hr>\n\n";
                    echo $sql."\n\n";
                    echo "<hr>\n\n";
                }

            }
        }
    }

    /**
     * @param $client
     * @return bool return true if exists and false if does not exists
     */
    private function checkIfClientExists($client)
    {
        global $estkCon;

        $sql = "SELECT COUNT() as clo_total, list(distinct(iaicl_auto_serial)) as clo_auto_serial
                    FROM iaimportclients
                    WHERE
                    iaicl_client_code = '" . $client['iaicl_client_code'] . "'
                    AND iaicl_identity_card = '" . $client['iaicl_identity_card'] . "'
                    AND iaicl_row_status = 'O'
                    ";
        //echo $sql."<hr>";
        $resultData = $estkCon->query_fetch($sql);
        if ($resultData['clo_total'] > 0) {
            echo "[Found:".$resultData['clo_auto_serial']."]";
            return true;
        } else {
            return false;
        }
    }

        /**
         * @param $policy
         * @return bool return true if exists and false if does not exists
         */
        private function checkIfPolicyExists($policy){
            global $estkCon;

            $sql = "SELECT COUNT() as clo_total
                    FROM iaimportpolicies
                    WHERE
                    iaipol_policy_import_reference = '".$policy['iaipol_policy_import_reference']."'
                    ";
            $resultData = $estkCon->query_fetch($sql);
            if ($resultData['clo_total'] > 0){
                return true;
            }
            else {
                return false;
            }

        }

    /**
     * @param $situation
     * @return bool return true if exists and false if does not exists
     */
    private function checkIfSituationExists($situation){
        global $estkCon;

        $sql = "SELECT COUNT() as clo_total
                    FROM iaimportpolsit
                    WHERE
                    iaipst_policy_import_reference = '".$situation['iaipst_policy_import_reference']."'
                    AND iaipst_situation_code = '".$situation['iaipst_situation_code']."'
                    ";
        $resultData = $estkCon->query_fetch($sql);
        if ($resultData['clo_total'] > 0){
            return true;
        }
        else {
            return false;
        }

    }

    /**
     * @param $policyItem
     * @return bool return true if exists and false if does not exists
     */
    private function checkIfPolicyItemExists($policyItem){
        global $estkCon;

        $sql = "SELECT COUNT() as clo_total
                    FROM iaimportpolitems
                    WHERE
                    iaipit_item_code = '".$policyItem['iaipit_item_code']."'
                    AND iaipit_policy_import_reference = '".$policyItem['iaipit_policy_import_reference']."'
                    ";
        $resultData = $estkCon->query_fetch($sql);
        if ($resultData['clo_total'] > 0){
            return true;
        }
        else {
            return false;
        }

    }
    private function checkIfPolicyItemAuxExists($policyItemAux){
        global $estkCon;

        $sql = "SELECT COUNT() as clo_total
                    FROM iaimportpolitems
                    WHERE
                    iaipia_item_code = '".$policyItemAux['iaipia_item_code']."'
                    AND iaipia_situation_code = '".$policyItemAux['iaipia_situation_code']."'
                    AND iaipia_policy_import_reference = '".$policyItemAux['iaipia_policy_import_reference']."'
                    ";
        $resultData = $estkCon->query_fetch($sql);
        if ($resultData['clo_total'] > 0){
            return true;
        }
        else {
            return false;
        }

    }

    private function checkIfPolicyItemPremiumExists($policyItemPremium){
        global $estkCon;

        $sql = "SELECT COUNT() as clo_total
                    FROM iaimportpolitprem
                    WHERE
                    iaipip_policy_import_reference = '".$policyItemPremium['iaipip_policy_import_reference']."'
                    AND iaipip_item_code = '".$policyItemPremium['iaipip_item_code']."'
                    AND iaipip_pit_increment = '".$policyItemPremium['iaipip_pit_increment']."'
                    ";
        $resultData = $estkCon->query_fetch($sql);
        if ($resultData['clo_total'] > 0){
            return true;
        }
        else {
            return false;
        }
    }


}
