<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/2/2020
 * Time: 6:34 μ.μ.
 */

class RCB_Payment {

    private $RCBMerchant = '99000013';

    private $cardNumber = '';
    private $tokenNumber = '';
    private $cardExpiry = '';
    private $cardCCV = '';
    private $purchaseAmount = 0;
    private $description = '';
    private $foreignIdentifier = '';

    private $sessionID = '';
    private $orderIDFromOrder = '';

    public $error = false;
    public $errorDescription = '';

    public $tokenListID = 0;
    public $transactionID = 0;

    private $orderStatus = '';
    private $paymentStatus = '';



    function __construct()
    {
    }

    public function makePayment(){
        global $db;
        //check first if purchase amount is provided
        if ($this->purchaseAmount == 0){
            $this->error = true;
            $this->errorDescription = 'Must provide purchase amount';
            return false;
        }


        if ($this->tokenNumber != ''){
            //if token then record in tokens should exists
            $sql = "SELECT * FROM rcb_token_list WHERE rcbtl_token = '".$this->tokenNumber."'";
            $data = $db->query_fetch($sql);
            $this->tokenListID = $data['rcbtl_token_list_ID'];

            //check if a record is found
            if ($this->tokenListID == 0 || $this->tokenListID == ''){
                $this->error = true;
                $this->errorDescription = 'No token list entry is found in db with this token';
                return false;
            }
            return $this->makePaymentToken();
        }

        else if ($this->cardNumber != ''){
            if ($this->cardExpiry == ''){
                $this->error = true;
                $this->errorDescription = 'Must provide card expiration date';
            }
            if ($this->cardCCV == ''){
                //$this->error = true;
                //$this->errorDescription = 'Must provide card CCV2';
            }

            //create an entry in token list to use the primary id later on
            $newData['fld_card_number'] = substr($this->cardNumber,0,3).'**********'.substr($this->cardNumber,13);
            $this->tokenListID = $db->db_tool_insert_row('rcb_token_list', $newData,'fld_',1,'rcbtl_');
            if ($this->tokenListID == 0 || $this->tokenListID == ''){
                $this->error = true;
                $this->errorDescription = 'Something went wrong creating token list entry';
            }

            if ($this->error == true){
                return false;
            }


            //all ok proceed to make purchase with card number
            return $this->makePaymentCardNumber();
        }
        $this->error = true;
        $this->errorDescription = 'Must specify either card number and details or token';
        return false;
    }

    private function getSession(){
        global $db;

        if ($this->purchaseAmount == 0){
            $this->error = true;
            $this->errorDescription = 'Must supply purchase amount';
            return false;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <TKKPG>
                <Request>
                <Operation>CreateOrder</Operation>
                <Language>EN</Language>
                <Order>
                <OrderType>Purchase</OrderType>
                <Merchant>'.$this->RCBMerchant.'</Merchant>
                <Amount>'.$this->purchaseAmount.'</Amount>
                <Currency>978</Currency>
                <Description>Test1</Description>
                <ApproveURL>http://agents.agentscy.com/rcb/respond/response_approve.php?ID='.$this->tokenListID.'</ApproveURL>
                <CancelURL>http://agents.agentscy.com/rcb/respond/response_cancel.php?ID='.$this->tokenListID.'</CancelURL>
                <DeclineURL>http://agents.agentscy.com/rcb/respond/response_decline.php?ID='.$this->tokenListID.'</DeclineURL>
                <AddParams>
                <FA-DATA>Email=user@yandex.ru; Phone=22211444;ShippingCountry=156; ShippingCity=X City;DeliveryPeriod=32;MerchantOrderID=E643C1426056;</FA-DATA>
                </AddParams>
                </Order>
                </Request>
                </TKKPG>';

        //The URL that you want to send your XML to.
        $url = 'https://mpi.rcbcy.com:9774/Exec';
        //Initiate cURL
        $curl = curl_init($url);
        //Set the Content-Type to text/xml.
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        //Set CURLOPT_POST to true to send a POST request.
        curl_setopt($curl, CURLOPT_POST, true);
        //Attach the XML string to the body of our request.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        //Tell cURL that we want the response to be returned as
        //a string instead of being dumped to the output.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //Execute the POST request and send our XML.
        $result = curl_exec($curl);
        $resultXML = simplexml_load_string($result);
        //Do some basic error checking.
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }
        //Close the cURL handle.
        curl_close($curl);

        $this->sessionID = $resultXML->Response->Order->SessionID;
        $this->orderStatus = $resultXML->Response->Status;
        $this->orderIDFromOrder = $resultXML->Response->Order->OrderID;

        //00 -> successfully
        if ($resultXML->Response->Status == '00') {
            $newData['fld_order_status'] = 'Success';
        } //30 -> message invalid format (no mandatory fields etc.)
        else if ($resultXML->Response->Status == '30') {
            $newData['fld_order_status'] = 'InvalidFormat';
        } //10->the Merchant has no access to the CreateOrder operation (or the Merchant is not registered)
        else if ($resultXML->Response->Status == '10') {
            $newData['fld_order_status'] = 'NoAccess';
        }
        else {
            $newData['fld_order_status'] = 'ErrorOther';
        }

        $newData['fld_token_list_ID'] = $this->tokenListID;
        $newData['fld_transaction_date_time'] = date('Y-m-d G:i:s');
        $newData['fld_description'] = $this->description;
        $newData['fld_foreign_identifier'] = $this->foreignIdentifier;
        $newData['fld_session'] = $this->sessionID;
        $newData['fld_amount'] = $this->purchaseAmount;
        $this->transactionID = $db->db_tool_insert_row('rcb_transactions', $newData,'fld_',1,'rcbtr_');

        if ($this->orderStatus != '00'){
            $this->error = true;
            $this->errorDescription = 'Order status was not successful.';
            return false;
        }

        return true;


    }

    private function makePaymentCardNumber(){
        global $db;

        //first get the session by making the order
        $this->getSession();
        if ($this->error == true){
            return false;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<TKKPG>
    <Request>
        <Operation>Purchase</Operation>
        <Order>
            <Merchant>'.$this->RCBMerchant.'</Merchant>
            <OrderID>'.$this->orderIDFromOrder.'</OrderID>
            <AddParams>
            
            </AddParams>
        </Order>
        <SessionID>'.$this->sessionID.'</SessionID>
        <Amount>'.$this->purchaseAmount.'</Amount>
        <Currency>978</Currency>
        <PAN>'.$this->cardNumber.'</PAN>
        <ExpDate>'.$this->cardExpiry.'</ExpDate>
        <DraftCaptureFlag></DraftCaptureFlag>
        <CVV2></CVV2>
        <!-- TWEC indicator code -->
        <eci>08</eci>
        <IP></IP>
    </Request>
</TKKPG> ';

        //The URL that you want to send your XML to.
        $url = 'https://mpi.rcbcy.com:9774/Exec';
        //Initiate cURL
        $curl = curl_init($url);
        //Set the Content-Type to text/xml.
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        //Set CURLOPT_POST to true to send a POST request.
        curl_setopt($curl, CURLOPT_POST, true);
        //Attach the XML string to the body of our request.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        //Tell cURL that we want the response to be returned as
        //a string instead of being dumped to the output.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //Execute the POST request and send our XML.
        $result = curl_exec($curl);
        $resultXML = simplexml_load_string($result);
        //Do some basic error checking.
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }
        //Close the cURL handle.
        curl_close($curl);

        //print_r($resultXML);
        //echo PHP_EOL.PHP_EOL;

        $this->paymentStatus = $resultXML->XMLOut->Message->OrderStatus;
        $updateData['fld_payment_status'] = $this->paymentStatus;
        if ($updateData['fld_payment_status'] == ''){
            $updateData['fld_payment_status'] = $resultXML->Response->Status;
            if ($updateData['fld_payment_status'] == ''){
                $updateData['fld_payment_status'] = 'ERROR';
            }
        }
        $db->db_tool_update_row('rcb_transactions', $updateData, 'rcbtr_transaction_ID = '.$this->transactionID, $this->transactionID,'fld_','execute','rcbtr_');

        $tokenSplit = explode('=',$resultXML->XMLOut->Message->Response_g);
        $tokenNewData['fld_token'] = $tokenSplit[0];
        $tokenNewData['fld_expiration'] = $tokenSplit[1];
        $db->db_tool_update_row('rcb_token_list', $tokenNewData, 'rcbtl_token_list_ID = '.$this->tokenListID, $this->tokenListID,'fld_','execute','rcbtl_');
echo "Updating token list with ID ".$this->tokenListID." with token: ".$tokenNewData['fld_token'];
        if ($this->paymentStatus == 'APPROVED'){
            return true;
        }
        else {

            $this->error = true;
            $this->errorDescription = 'Purchase was '.$this->paymentStatus;
            return false;
        }


    }

    private function makePaymentToken(){
        global $db;

        //first get the session by making the order
        $this->getSession();
        if ($this->error == true){
            return false;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <TKKPG>
                <Request>
                <Operation>Purchase</Operation>
                <Order>
                <Merchant>'.$this->RCBMerchant.'</Merchant>
                <OrderID>'.$this->orderIDFromOrder.'</OrderID>
                <AddParams>
                <FA-DATA>Email=user@yandex.ru; Phone=22211444;ShippingCountry=156; ShippingCity=X City;DeliveryPeriod=32;MerchantOrderID=E643C1426056;</FA-DATA>
                </AddParams>
                </Order>
                <SessionID>'.$this->sessionID.'</SessionID>
                <Amount>'.$this->purchaseAmount.'</Amount>
                <Currency>978</Currency>
                <CardUID>'.$this->tokenNumber.'</CardUID>
                <CVV2></CVV2>
                <!-- TWEC indicator code -->
                <eci>08</eci>
                <IP></IP>
                </Request>
                </TKKPG>';

        //The URL that you want to send your XML to.
        $url = 'https://mpi.rcbcy.com:9774/Exec';
        //Initiate cURL
        $curl = curl_init($url);
        //Set the Content-Type to text/xml.
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        //Set CURLOPT_POST to true to send a POST request.
        curl_setopt($curl, CURLOPT_POST, true);
        //Attach the XML string to the body of our request.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        //Tell cURL that we want the response to be returned as
        //a string instead of being dumped to the output.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //Execute the POST request and send our XML.
        $result = curl_exec($curl);
        $resultXML = simplexml_load_string($result);
        //Do some basic error checking.
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }
        //Close the cURL handle.
        curl_close($curl);

        print_r($resultXML);
        $this->paymentStatus = $resultXML->XMLOut->Message->OrderStatus;

        $updateData['fld_payment_status'] = $this->paymentStatus;
        if ($updateData['fld_payment_status'] == ''){
            $updateData['fld_payment_status'] = $resultXML->Response->Status;
            if ($updateData['fld_payment_status'] == ''){
                $updateData['fld_payment_status'] = 'ERROR';
            }
        }
        $db->db_tool_update_row('rcb_transactions', $updateData, 'rcbtr_transaction_ID = '.$this->transactionID, $this->transactionID,'fld_','execute','rcbtr_');

        //$tokenNewData['fld_token'] = $resultXML->XMLOut->Message->Response_g;
        //$db->db_tool_update_row('rcb_token_list', $tokenNewData, 'rcbtl_token_list_ID = '.$this->tokenListID, $this->tokenListID,'fld_','execute','rcbtl_');
        //echo "Updating token list with ID ".$this->tokenListID." with token: ".$tokenNewData['fld_token'];
        if ($this->paymentStatus == 'APPROVED'){
            return true;
        }
        else {

            $this->error = true;
            $this->errorDescription = 'Purchase was '.$this->paymentStatus;
            return false;
        }


    }

    /**
     * @param $cardNumber
     * @return $this
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @param $tokenNumber
     * @return $this
     */
    public function setTokenNumber($tokenNumber)
    {
        $this->tokenNumber = $tokenNumber;
        return $this;
    }

    /**
     * @param $cardExpiry
     * @return $this
     */
    public function setCardExpiry($cardExpiry)
    {
        $this->cardExpiry = $cardExpiry;
        return $this;
    }

    /**
     * @param $cardCCV
     * @return $this
     */
    public function setCardCCV($cardCCV)
    {
        $this->cardCCV = $cardCCV;
        return $this;
    }

    /**
     * @param $purchaseAmount
     * @return $this
     */
    public function setPurchaseAmount($purchaseAmount)
    {
        $this->purchaseAmount = $purchaseAmount;
        return $this;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param $foreignIdentifier
     * @return $this
     */
    public function setForeignIdentifier($foreignIdentifier)
    {
        $this->foreignIdentifier = $foreignIdentifier;
        return $this;
    }



}