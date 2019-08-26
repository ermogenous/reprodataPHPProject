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

    /**
     * @param $headerData -> [documentID,accountID,comments,fromModule,fromIDDescription,fromID]
     * @param $linesData -> 2D Array [num][accountID,type,amount,reference]
     * @return mixed
     * List of transactions.
     * accountID
     * type -> Dr or Cr
     * amount -> decimal value
     * reference -> text
     * example
     * [1][accountID]
     * [1][Dr]
     * [1][10]
     * [2][accountID]
     * [2][Cr]
     * [2][10]
     */


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