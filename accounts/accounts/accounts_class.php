<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/7/2019
 * Time: 3:08 ΜΜ
 */

class AdvAccounts {

    private $accountID;
    private $accountData;

    //Error
    private $error;
    private $errorDescription;

    public function __construct($accountID)
    {
        global $db;

        $this->accountID = $accountID;
        $this->accountData = $db->query_fetch('SELECT * FROM ac_accounts WHERE acacc_account_ID = '.$this->accountID);

    }

    //STATIC FUNCTIONS

    /**
     * @return array - List of all the control accounts in order. Returns db row in array
     */
    public static function getControlAccountList(){
        global $db;

        $sql = "SELECT * FROM ac_accounts WHERE acacc_control = 1 ORDER BY acacc_code";
        $result = $db->query($sql);
        $rows = [];
        while ($acc = $db->fetch_assoc($result)){
            $rows[$acc['acacc_account_ID']] = $acc;
        }

        return $rows;

    }

    //GET FUNCTIONS
    public function getAccountID(){
        return $this->accountID;
    }
    public function getAccountData(){
        return $this->accountData;
    }
    public function getError(){
        return $this->error;
    }
    public function getErrorDescription(){
        return $this->errorDescription;
    }
}