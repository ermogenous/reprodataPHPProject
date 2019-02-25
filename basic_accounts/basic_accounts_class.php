<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/2/2019
 * Time: 10:14 ΠΜ
 */

Class BasicAccounts {

    private $accountData;
    private $customerData;

    private $error = false;
    private $errorDescription;

    private $mode; //account when account is specified/ Open when no account is specified

    function __construct($accountID = 0)
    {
        global $db;
        if ($accountID != 0){
            $this->mode = 'account';
            $this->accountData = $db->query_fetch('SELECT * FROM bc_basic_accouts WHERE bcacc_basic_accounts_ID = '.$accountID);
            $this->customerData = $db->query_fetch('SELECT * FROM customers WHERE cst_customer_ID = '.$this->accountData['bcacc_customer_ID']);
        }
        else {
            $this->mode = 'open';
        }

    }

    function getMode(){
        return $this->mode;
    }

    function getAcountData(){
        return $this->accountData;
    }

    function getCustomerData(){
        return $this->customerData;
    }

    function getError(){
        return $this->error;
    }

    function getErrorDescription(){
        return $this->errorDescription;
    }

    //TRANSACTIONS
    public function insertTransaction($drAccount, $amount, $crAccount){

    }




    function createAccountForAllCustomers(){
        global $db;

        //first find customers that do not have basic account
        $sql = 'SELECT * FROM customers
                LEFT OUTER JOIN bc_basic_accounts ON bcacc_basic_account_ID = cst_basic_account_ID
                WHERE
                bcacc_basic_account_ID is null ';
        $result = $db->query($sql);
        $totalNew = 0;
        while ($cust = $db->fetch_assoc($result)){
            if ($cust['bcacc_basic_account_ID'] > 0){
                //account already exists. do nothing
            }
            else {
                $totalNew++;
                $data['type'] = 'Customer';
                $data['balance'] = 0;
                $data['name'] = $cust['cst_name']." ".$cust['cst_surname'];
                $data['description'] = $cust['cst_name']." ".$cust['cst_surname'];
                $data['work_tel'] = $cust['cst_work_tel_1'];
                $data['mobile'] = $cust['cst_mobile_1'];
                $data['email'] = $cust['cst_email'];
                $newId = $db->db_tool_insert_row('bc_basic_accounts', $data, '', 1, 'bcacc_');

                //update the customer with the new id
                $custData['basic_account_ID'] = $newId;
                $db->db_tool_update_row('customers', $custData, 'cst_customer_ID = '.$cust['cst_customer_ID'], $cust['cst_customer_ID'], ''
                ,'execute', 'cst_');
            }
        }

        return $totalNew;

    }

    function updateAccountDetailsFromCustomer($customerID = 0, $accountID = 0){
        global $db;
        if ($customerID == 0 && $accountID == 0){
            $this->error = true;
            $this->errorDescription = 'Must provide customer ID or account ID. Both are empty';
            return false;
        }
        $where = '';
        if ($customerID == 0){
            $where = 'bcacc_basic_account_ID = '.$accountID;
        }
        else {
            $where = 'cst_customer_ID = '.$customerID;
        }

        $sql = 'SELECT * FROM customers 
                JOIN bc_basic_accounts ON bcacc_basic_account_ID = cst_basic_account_ID
                WHERE '.$where;
        $data = $db->query_fetch($sql);

        $newData['name'] = $data['cst_name'];
        $newData['description'] = $data['cst_name']." ".$data['cst_surname'];
        $newData['work_tel'] = $data['cst_work_tel_1'];
        $newData['mobile'] = $data['cst_mobile_1'];
        $newData['email'] = $data['cst_email'];
        $db->db_tool_update_row('bc_basic_accounts', $newData, 'bcacc_basic_account_ID = '.$data['bcacc_basic_account_ID'],
            $data['bcacc_basic_account_ID'], '','execute', 'bcacc_');
        return true;
    }

    function createAccountForAllAgents(){
        global $db;

        //first find customers that do not have basic account
        $sql = 'SELECT * FROM agents
                LEFT OUTER JOIN bc_basic_accounts ON bcacc_basic_account_ID = agnt_basic_account_ID
                LEFT OUTER JOIN users ON usr_users_ID = agnt_user_ID
                WHERE
                bcacc_basic_account_ID is null ';
        $result = $db->query($sql);
        $totalNew = 0;
        while ($agent = $db->fetch_assoc($result)){
            if ($agent['bcacc_basic_account_ID'] > 0){
                //account already exists. do nothing
            }
            else {
                $totalNew++;
                $data['type'] = 'Agent';
                $data['balance'] = 0;
                $data['name'] = $agent['agnt_name']." Comm.";
                $data['description'] = $agent['agnt_name']." ".$agent['agnt_code']." Commission A/C";
                $data['work_tel'] = $agent['usr_tel'];
                //$data['mobile'] = $agent['cst_mobile_1'];
                $data['email'] = $agent['usr_email'];
                $newId = $db->db_tool_insert_row('bc_basic_accounts', $data, '', 1, 'bcacc_');

                //update the customer with the new id
                $agentData['basic_account_ID'] = $newId;
                $db->db_tool_update_row('agents', $agentData, 'agnt_agent_ID = '.$agent['agnt_agent_ID'], $agent['agnt_agent_ID'], ''
                    ,'execute', 'agnt_');
            }
        }

        return $totalNew;
        
    }

    function createReleaseAccountForAllAgents(){
        global $db;

        //first find customers that do not have basic account
        $sql = 'SELECT * FROM agents
                LEFT OUTER JOIN bc_basic_accounts ON bcacc_basic_account_ID = agnt_commission_release_basic_account_ID
                LEFT OUTER JOIN users ON usr_users_ID = agnt_user_ID
                WHERE
                agnt_enable_commission_release = 1
                AND bcacc_basic_account_ID is null ';
        $result = $db->query($sql);
        $totalNew = 0;
        while ($agent = $db->fetch_assoc($result)){
            if ($agent['bcacc_basic_account_ID'] > 0){
                //account already exists. do nothing
            }
            else {
                $totalNew++;
                $data['type'] = 'Agent';
                $data['balance'] = 0;
                $data['name'] = $agent['agnt_name']." Comm. Release";
                $data['description'] = $agent['agnt_name']." ".$agent['agnt_code']." Commission Release A/C";
                $data['work_tel'] = $agent['usr_tel'];
                //$data['mobile'] = $agent['cst_mobile_1'];
                $data['email'] = $agent['usr_email'];
                $newId = $db->db_tool_insert_row('bc_basic_accounts', $data, '', 1, 'bcacc_');

                //update the customer with the new id
                $agentData['commission_release_basic_account_ID'] = $newId;
                $db->db_tool_update_row('agents', $agentData, 'agnt_agent_ID = '.$agent['agnt_agent_ID'], $agent['agnt_agent_ID'], ''
                    ,'execute', 'agnt_');
            }
        }

        return $totalNew;
    }

    function updateAccountDetailsFromAgent($agentID = 0, $accountID = 0){
        global $db;
        if ($agentID == 0 && $accountID == 0){
            $this->error = true;
            $this->errorDescription = 'Must provide agent ID or account ID. Both are empty';
            return false;
        }
        if ($agentID == 0){
            $where = 'bcacc_basic_account_ID = '.$accountID;
        }
        else {
            $where = 'agnt_agent_ID = '.$agentID;
        }

        $sql = 'SELECT * FROM agents 
                LEFT OUTER JOIN bc_basic_accounts ON bcacc_basic_account_ID = agnt_basic_account_ID
                LEFT OUTER JOIN users ON usr_users_ID = agnt_user_ID
                WHERE '.$where;
        $data = $db->query_fetch($sql);

        $newData['name'] = $data['agnt_name']." Comm.";
        $newData['description'] = $data['agnt_name']." ".$data['agnt_code']." Commission A/C";
        $newData['work_tel'] = $data['usr_tel'];
        //$newData['mobile'] = $data['cst_mobile_1'];
        $newData['email'] = $data['usr_email'];
        $db->db_tool_update_row('bc_basic_accounts', $newData, 'bcacc_basic_account_ID = '.$data['bcacc_basic_account_ID'],
            $data['bcacc_basic_account_ID'], '','execute', 'bcacc_');
        return true;
    }

    function updateReleaseAccountDetailsFromAgent($agentID = 0, $accountID = 0){
        global $db;
        if ($agentID == 0 && $accountID == 0){
            $this->error = true;
            $this->errorDescription = 'Must provide agent ID or account ID. Both are empty';
            return false;
        }
        if ($agentID == 0){
            $where = 'bcacc_basic_account_ID = '.$accountID;
        }
        else {
            $where = 'agnt_agent_ID = '.$agentID;
        }

        $sql = 'SELECT * FROM agents
                LEFT OUTER JOIN bc_basic_accounts ON bcacc_basic_account_ID = agnt_commission_release_basic_account_ID
                LEFT OUTER JOIN users ON usr_users_ID = agnt_user_ID
                WHERE
                '.$where;
        $data = $db->query_fetch($sql);

        if ($data['agnt_enable_commission_release'] == 1){
            $newData['name'] = $data['agnt_name']." Comm. Release";
            $newData['description'] = $data['agnt_name']." ".$data['agnt_code']." Commission Release A/C";
            $newData['work_tel'] = $data['usr_tel'];
            //$newData['mobile'] = $data['cst_mobile_1'];
            $newData['email'] = $data['usr_email'];
            $db->db_tool_update_row('bc_basic_accounts', $newData, 'bcacc_basic_account_ID = '.$data['agnt_commission_release_basic_account_ID'],
                $data['bcacc_basic_account_ID'], '','execute', 'bcacc_');
            return true;
        }
        else {

        }


    }



}