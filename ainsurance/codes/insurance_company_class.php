<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/11/2019
 * Time: 3:58 ΜΜ
 */

class InsuranceCompany {
    
    private $insuranceCompanyData;
    private $insuranceCompanyID;

    public $error = false;
    public $errorDescription = '';
    public $messageDescription = '';


    
    function __construct($icID)
    {
        global $db;
        $this->insuranceCompanyID = $icID;
        $this->insuranceCompanyData = $db->query_fetch('SELECT * FROM ina_insurance_companies WHERE inainc_insurance_company_ID = '.$this->insuranceCompanyID);
        
    }

    private $insuranceSettings;
    private $gotInsuranceSettings = false;
    private function getInsuranceSettings(){
        global $db;
        if ($this->gotInsuranceSettings == false){
            $this->insuranceSettings = $db->query_fetch('SELECT * FROM ina_settings WHERE inaset_setting_ID = 1');
            $this->gotInsuranceSettings = true;
        }
    }


    public function autoGenerateAccounts(){
        global $db;

        if ($this->insuranceCompanyData['inainc_debtor_account_ID'] != -1){
            $this->error = true;
            $this->errorDescription = 'Cannot auto generate debtor account. Debtor account id is not set to -1';
            return false;
        }
echo "Checking for entity<br>";
        //if entity does not exists then create it first.
        if ($this->insuranceCompanyData['inainc_entity_ID'] == ''){

            //first create the entity
            $entity['fld_active'] = 'Active';
            $entity['fld_name'] = $this->insuranceCompanyData['inainc_name'];
            $entity['fld_description'] = $this->insuranceCompanyData['inainc_name'];
            $entity['fld_mobile'] = '';
            $entity['fld_work_tel'] = '';
            $entity['fld_fax'] = '';
            $entity['fld_email'] = '';
            $entity['fld_website'] = '';

            $entityNewID = $db->db_tool_insert_row('ac_entities', $entity,'fld_', 1, 'acet_');

            $cstNewData['fld_entity_ID'] = $entityNewID;
            $db->db_tool_update_row('ina_insurance_companies', $cstNewData, 'inainc_insurance_company_ID = '.$this->insuranceCompanyID,
                $this->insuranceCompanyID,'fld_','execute','inainc_');
            $this->messageDescription = 'Entity Created.<br>';

            $this->getInsuranceSettings();
            include("../../accounts/entities/entities_class.php");
            $entity = new AccountsEntity($entityNewID);
            //Creating Dr Account
            $debtorResult = $entity->createAccount($this->insuranceSettings['inaset_ins_comp_dr_control_account_ID'],' Commission Receivable', ' Commission Receivable');
            $this->messageDescription = 'Debtor Account Created.<br>';
            $newData['fld_debtor_account_ID'] = $entity->returnLastAccountCreatedID();

            //Creating Cr Account
            $entity->createAccount($this->insuranceSettings['inaset_ins_comp_cr_control_account_ID'],' Commission Received', ' Commission Received');
            $this->messageDescription .= 'Expense Account Created.<br>';
            $newData['fld_revenue_account_ID'] = $entity->returnLastAccountCreatedID();

            //update the insurance company with the new accounts
            $db->db_tool_update_row('ina_insurance_companies', $newData, 'inainc_insurance_company_ID = '.$this->insuranceCompanyID,
                $this->insuranceCompanyID,'fld_','execute','inainc_');

            return true;
        }

    }

}