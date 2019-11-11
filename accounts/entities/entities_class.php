<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/10/2019
 * Time: 10:06 ΠΜ
 */

class AccountsEntity {
    
    private $entityData;
    private $entityID;
    private $accountsSettings;
    private $gotAccountsSettings = false;
    public $error = false;
    public $errorDescription = '';
    private $findAccountsRelated;
    public $otherAccountsRelated = [];
    private $newAccountID;

    function __construct( $entityID )
    {
        global $db;
        $this->entityData = $db->query_fetch('SELECT * FROM ac_entities WHERE acet_entity_ID = '.$entityID);
        $this->entityID = $this->entityData['acet_entity_ID'];
    }

    private function findAccountsRelated(){
        global $db;
        $this->findAccountsRelated['debtor'] = false;
        $this->findAccountsRelated['creditor'] = false;
        $this->getAccountsSettings();
        $sql = 'SELECT * FROM ac_accounts WHERE acacc_entity_ID = '.$this->entityID;
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)){
            if ($row['acacc_parent_ID'] == $this->accountsSettings['acstg_auto_ac_debtors_control_ID']){
                $this->findAccountsRelated['debtor'] = true;
                $this->findAccountsRelated['debtorData'] = $row;
            }
            else if ($row['acacc_parent_ID'] == $this->accountsSettings['acstg_auto_ac_creditors_control_ID']){
                $this->findAccountsRelated['creditor'] = true;
                $this->findAccountsRelated['creditorData'] = $row;
            }
            else {
                $this->otherAccountsRelated[] = $row;
            }
        }
        $this->findAccountsRelated['found'] = true;
    }

    public function debtorAccountExists(){
        if ($this->findAccountsRelated['found'] != true){
            $this->findAccountsRelated();
        }
        return $this->findAccountsRelated['debtor'];
    }

    public function creditorAccountExists(){
        if ($this->findAccountsRelated['found'] != true){
            $this->findAccountsRelated();
        }
        return $this->findAccountsRelated['creditor'];
    }

    public function getDebtorAccountData(){
        if ($this->findAccountsRelated['found'] != true){
            $this->findAccountsRelated();
        }
        return $this->findAccountsRelated['debtorData'];
    }

    public function getCreditorAccountData(){
        if ($this->findAccountsRelated['found'] != true){
            $this->findAccountsRelated();
        }
        return $this->findAccountsRelated['creditorData'];
    }

    public function getEntityData(){
        return $this->entityData;
    }
    
    private function getAccountsSettings(){
        global $db;
        if ($this->gotAccountsSettings == false) {
            $this->accountsSettings = $db->query_fetch('SELECT * FROM ac_settings WHERE acstg_setting_ID = 1');
            $this->gotAccountsSettings = true;
        }
    }
    
    public function createDebtorsAccount(){
        global $db;
        
        //find the control account under the settings for debtors
        $this->getAccountsSettings();

        //check if debtors account already exists
        if ($this->debtorAccountExists() == true){
            $this->error = true;
            $this->errorDescription = 'Debtor account already exists. Cannot recreate it';
            return false;
        }

        //get data of control account
        if ($this->accountsSettings['acstg_auto_ac_debtors_control_ID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Cannot create debtor account. Control accout in settings is not defined';
            return false;
        }
        $controlAcData = $db->query_fetch('SELECT * FROM ac_accounts WHERE acacc_account_ID = '.$this->accountsSettings['acstg_auto_ac_debtors_control_ID']);

        //generate the code
        $maxAcCode = $db->query_fetch('SELECT MAX(acacc_code)as clo_max_code FROM ac_accounts WHERE acacc_parent_ID = '.$controlAcData['acacc_account_ID']);
        if ($maxAcCode['clo_max_code'] == ''){
            $maxAcCode['clo_max_code'] = 0;
        }
        //get the last x (from settings) of the last max code
        $newCode = substr($maxAcCode['clo_max_code'],strlen($maxAcCode['clo_max_code']) - $this->accountsSettings['acstg_auto_account_suffix_num']);
        //remove the leading zeros
        $newCode = $newCode * 1 + 1;
        $newCode = $db->buildNumber('',$this->accountsSettings['acstg_auto_account_suffix_num'] , $newCode);
        $newCode = $controlAcData['acacc_code'] . $newCode;

        //set the data for insert
        $newData['active'] = 'Active';
        $newData['entity_ID'] = $this->entityID;
        $newData['control'] = 0;
        $newData['parent_ID'] = $controlAcData['acacc_account_ID'];
        $newData['account_type_ID'] = $controlAcData['acacc_account_type_ID'];
        $newData['account_sub_type_ID'] = $controlAcData['acacc_account_sub_type_ID'];
        $newData['debit_credit'] = 1;
        $newData['code'] = $newCode;
        $newData['name'] = $this->entityData['acet_name'];
        $newData['balance'] = 0;
        $newData['description'] = $this->entityData['acet_description'];
        $newData['mobile'] = $this->entityData['acet_mobile'];
        $newData['work_tel'] = $this->entityData['acet_work_tel'];
        $newData['fax'] = $this->entityData['acet_fax'];
        $newData['email'] = $this->entityData['acet_email'];
        $newData['website'] = $this->entityData['acet_website'];

        $db->db_tool_insert_row('ac_accounts', $newData,'',0,'acacc_');

        return true;

    }

    public function createCreditorsAccount(){
        global $db;

        //find the control account under the settings for debtors
        $this->getAccountsSettings();

        //check if debtors account already exists
        if ($this->creditorAccountExists() == true){
            $this->error = true;
            $this->errorDescription = 'Creditor account already exists. Cannot recreate it';
            return false;
        }

        //get data of control account
        if ($this->accountsSettings['acstg_auto_ac_creditors_control_ID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Cannot create creditor account. Control accout in settings is not defined';
            return false;
        }
        $controlAcData = $db->query_fetch('SELECT * FROM ac_accounts WHERE acacc_account_ID = '.$this->accountsSettings['acstg_auto_ac_creditors_control_ID']);

        //generate the code
        $maxAcCode = $db->query_fetch('SELECT MAX(acacc_code)as clo_max_code FROM ac_accounts WHERE acacc_parent_ID = '.$controlAcData['acacc_account_ID']);
        if ($maxAcCode['clo_max_code'] == ''){
            $maxAcCode['clo_max_code'] = 0;
        }
        //get the last x (from settings) of the last max code
        $newCode = substr($maxAcCode['clo_max_code'],strlen($maxAcCode['clo_max_code']) - $this->accountsSettings['acstg_auto_account_suffix_num']);
        //remove the leading zeros
        $newCode = $newCode * 1 + 1;
        $newCode = $db->buildNumber('',$this->accountsSettings['acstg_auto_account_suffix_num'] , $newCode);
        $newCode = $controlAcData['acacc_code'] . $newCode;

        //set the data for insert
        $newData['active'] = 'Active';
        $newData['entity_ID'] = $this->entityID;
        $newData['control'] = 0;
        $newData['parent_ID'] = $controlAcData['acacc_account_ID'];
        $newData['account_type_ID'] = $controlAcData['acacc_account_type_ID'];
        $newData['account_sub_type_ID'] = $controlAcData['acacc_account_sub_type_ID'];
        $newData['debit_credit'] = 1;
        $newData['code'] = $newCode;
        $newData['name'] = $this->entityData['acet_name'];
        $newData['balance'] = 0;
        $newData['description'] = $this->entityData['acet_description'];
        $newData['mobile'] = $this->entityData['acet_mobile'];
        $newData['work_tel'] = $this->entityData['acet_work_tel'];
        $newData['fax'] = $this->entityData['acet_fax'];
        $newData['email'] = $this->entityData['acet_email'];
        $newData['website'] = $this->entityData['acet_website'];

        $db->db_tool_insert_row('ac_accounts', $newData,'',0,'acacc_');

        return true;

    }

    public function createAccount($controlAccountID,$nameSuffix = '',$descriptionSuffix = ''){
        global $db;

        $this->getAccountsSettings();

        //get data of control account
        if ($controlAccountID == ''){
            $this->error = true;
            $this->errorDescription = 'Cannot create account. Control account is not defined';
            return false;
        }
        $controlAcData = $db->query_fetch('SELECT * FROM ac_accounts WHERE acacc_account_ID = '.$controlAccountID);

        //generate the code
        $maxAcCode = $db->query_fetch('SELECT MAX(acacc_code)as clo_max_code FROM ac_accounts WHERE acacc_parent_ID = '.$controlAcData['acacc_account_ID']);
        if ($maxAcCode['clo_max_code'] == ''){
            $maxAcCode['clo_max_code'] = 0;
        }
        //get the last x (from settings) of the last max code
        $newCode = substr($maxAcCode['clo_max_code'],strlen($maxAcCode['clo_max_code']) - $this->accountsSettings['acstg_auto_account_suffix_num']);
        //remove the leading zeros
        $newCode = $newCode * 1 + 1;
        $newCode = $db->buildNumber('',$this->accountsSettings['acstg_auto_account_suffix_num'] , $newCode);
        $newCode = $controlAcData['acacc_code'] . $newCode;

        //set the data for insert
        $newData['active'] = 'Active';
        $newData['entity_ID'] = $this->entityID;
        $newData['control'] = 0;
        $newData['parent_ID'] = $controlAcData['acacc_account_ID'];
        $newData['account_type_ID'] = $controlAcData['acacc_account_type_ID'];
        $newData['account_sub_type_ID'] = $controlAcData['acacc_account_sub_type_ID'];
        $newData['debit_credit'] = 1;
        $newData['code'] = $newCode;
        $newData['name'] = $this->entityData['acet_name'].$nameSuffix;
        $newData['balance'] = 0;
        $newData['description'] = $this->entityData['acet_description'].$descriptionSuffix;
        $newData['mobile'] = $this->entityData['acet_mobile'];
        $newData['work_tel'] = $this->entityData['acet_work_tel'];
        $newData['fax'] = $this->entityData['acet_fax'];
        $newData['email'] = $this->entityData['acet_email'];
        $newData['website'] = $this->entityData['acet_website'];
        print_r($newData);

        $this->newAccountID = $db->db_tool_insert_row('ac_accounts', $newData,'',1,'acacc_');

        return true;
    }

    public function returnLastAccountCreatedID(){
        return $this->newAccountID;
    }
    
    
}