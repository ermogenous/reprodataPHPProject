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

    public function testRemoteConnection(){

        $data = [
            'username' => $this->remoteUrlPassword,
            'password' => $this->remoteUrlPassword,
            'action' => 'testConnection'
        ];

        $curl = curl_init($this->remoteUrlConnectionTest);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            return false;
        }

        curl_close($curl);

        $response = json_decode($json_response, true);

        if ($response['testConnection'] == 'Yes'){
            return true;
        }
        return false;
    }

    public function getCardInfoFromPolicy($policyID)
    {
        global $db;
        $sql = 'SELECT * FROM ina_policies WHERE inapol_policy_ID = ' . $policyID;
        $result = $db->query_fetch($sql);
        $this->__construct($result['inapol_credit_card_ID']);
    }

    public function makeNewCreditCardEntry($creditCardNumber,$expiryYear, $expiryMonth, $ccv, $policyID=0, $customerID=0)
    {
        global $db;

        //create the card in the remote system
        $data = [
            'username' => $this->remoteUrlPassword,
            'password' => $this->remoteUrlPassword,
            'action' => 'createNewCard',
            'creditCardNumber' => $creditCardNumber,
            'creditCardExpiryYear' => $expiryYear,
            'creditCardExpiryMonth' => $expiryMonth,
            'creditCardCCV' => $ccv
        ];
        $curl = curl_init($this->remoteUrlCreateNewCard);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {

            $this->error = true;
            $this->errorDescription = 'Error curl creating new card on remote';
            return false;
        }

        curl_close($curl);

        $response = json_decode($json_response, true);

        if ($response['error'] == true || $response['newCardRemoteID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Error Found in response - '.$response['errorDescription'];
            return false;
        }

        //insert card in ina_credit_cards
        $newData['credit_card'] = substr($creditCardNumber,0,4)."********".substr($creditCardNumber,12);
        $newData['status'] = 'Active';
        $newData['credit_card_remote_ID'] = $response['newCardRemoteID'];
        $newData['remote_string'] = $json_response;

        $newID = $db->db_tool_insert_row('ina_credit_cards', $newData, '', 1, 'inacrc_');
        //update policy with the new id
        if ($this->policyID != 0){
            $policyNewData['credit_card_ID'] = $newID;
            $db->db_tool_update_row('ina_policies',$policyNewData,'inapol_policy_ID = '.$this->policyID,
                $this->policyID,'','execute','inapol_');
        }

        //update customer with new id
        if ($this->customerID != 0){
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