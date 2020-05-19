<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 20/04/2020
 * Time: 13:07
 */

class MECreditCards
{

    //statics
    private $remoteUrlCreateNewCard =  'http://localhost/insurance/rcb/credit_card_functions.php';
    private $remoteUrlConnectionTest = 'http://localhost/insurance/rcb/credit_card_functions.php';
    private $remoteUrlUsername = 'VFVrKzd5STNYRHZ6bXpTT0tieW5Ydz09Ojpl8sKxALeRVF6SiG-6QH42'; //encrypted using the key already
    private $remoteUrlPassword = 'VFVrKzd5STNYRHZ6bXpTT0tieW5Ydz09Ojpl8sKxALeRVF6SiG-6QH42'; //encrypted using the key already



    private $creditCardData;
    private $creditCardID;
    private $creditCardExists = false;
    private $externalPaymentURL = 'http://localhost/insurance/rcb/';

    private $policyID = 0; //if defined on credit card creation it also updates the inapol_policy
    private $customerID = 0; //if defined on credit card creation it also updates the cst_customer record

    public $error = false;
    public $errorDescription = '';

    function __construct($creditCardID = null)
    {
        global $db;
        if ($creditCardID > 0) {
            $sql = 'SELECT * FROM ina_credit_cards WHERE inacrc_credit_card_ID = ' . $creditCardID;
            $result = $db->query($sql);
            $this->creditCardData = $db->fetch_assoc($result);
            $this->creditCardID = $result['inacrc_credit_card_ID'];

            if ($this->creditCardID > 0) {
                $this->creditCardExists = true;
            }
        }

    }

    public function getCardInfoFromPolicy($policyID)
    {
        global $db;
        $sql = 'SELECT * FROM ina_policies WHERE inapol_policy_ID = ' . $policyID;
        $result = $db->query_fetch($sql);
        $this->__construct($result['inapol_credit_card_ID']);
    }

    public function makeNewCreditCardEntry($creditCardNumber, $remoteID, $policyID=0, $customerID=0)
    {
        global $db;

        if ($creditCardNumber == ''){
            $this->error = true;
            $this->errorDescription = 'Credit card number cannot be empty';
            return false;
        }

        if ($remoteID == ''){
            $this->error = true;
            $this->errorDescription = 'Credit card remote ID cannot be empty';
            return false;
        }

        //insert card in ina_credit_cards
        $newData['credit_card'] = substr($creditCardNumber,0,4)."********".substr($creditCardNumber,12);
        $newData['status'] = 'Active';
        $newData['credit_card_remote_ID'] = $remoteID;
        //$newData['remote_string'] = $json_response;

        $newID = $db->db_tool_insert_row('ina_credit_cards', $newData, '', 1, 'inacrc_');
        //update policy with the new id
        if ($policyID != 0){
            $policyNewData['credit_card_ID'] = $newID;
            $db->db_tool_update_row('ina_policies',$policyNewData,'inapol_policy_ID = '.$this->policyID,
                $this->policyID,'','execute','inapol_');
        }

        //update customer with new id
        if ($customerID != 0){
            $customerNewData['credit_card_ID'] = $newID;
            $db->db_tool_update_row('customers',$customerNewData,'cst_customer_ID = '.$this->customerID,
                $this->customerID,'','execute','cst_');
        }


        return $newID;
    }

    //PUBLIC FUNCTIONS
    public function creditCardExists()
    {
        return $this->creditCardExists;
    }

    public function getData()
    {
        return $this->creditCardData;
    }

    public function getCreditCardID()
    {
        return $this->creditCardID;
    }

    /**
     * @param int $policyID
     * @return $this
     */
    public function setPolicyID($policyID)
    {
        $this->policyID = $policyID;
        return $this;
    }

    /**
     * @param int $customerID
     * @return $this
     */
    public function setCustomerID($customerID)
    {
        $this->customerID = $customerID;
        return $this;
    }

}