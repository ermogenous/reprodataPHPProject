<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2020
 * Time: 2:47 μ.μ.
 */

class rcbConnection
{
    private $RCBMerchant = '99000013';

    private $cardNumber;
    private $tokenNumber;
    private $cardExpiry;
    private $cardCCV;
    private $purchaseAmount;

    public $error = false;
    public $errorDescription = '';

    private $paymentID;

    function __construct()
    {
    }

    public function testFunction()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<TKKPG>
   <Response>
      <Operation>CreateOrder</Operation>
      <Status>00</Status>
      <Order>
         <OrderID>86166</OrderID>
         <SessionID>4195BE06C8BC8BBDA9CF1B55FD403E24</SessionID>
         <URL>https://mpi.rcbcy.com/index.jsp</URL>
      </Order>
   </Response>
</TKKPG>';

        $data = simplexml_load_string($xml);
        print_r($data);

        echo "\n\n\n\n";


        echo "STATUS: " . $data->Response->Order->OrderID;

        exit();
    }

    public function createOrder()
    {
        global $db;

        if ($this->purchaseAmount < 1){
            $this->error = true;
            $this->errorDescription = 'Set purchase amount.';
            return false;
        }

        //1. make the record in db
        $newData['fld_status'] = 'Create';
        $newSerial = $db->db_tool_insert_row('rcb_payments', $newData, 'fld_', 1, 'rcbp_');
        $this->paymentID = $newSerial;
        echo 'Payment Serial:'.$newSerial."<br>";


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
<ApproveURL>http://agents.agentscy.com/rcb/respond/response_approve.php?ID='.$newSerial.'</ApproveURL>
<CancelURL>http://agents.agentscy.com/rcb/respond/response_cancel.php?ID='.$newSerial.'</CancelURL>
<DeclineURL>http://agents.agentscy.com/rcb/respond/response_decline.php?ID='.$newSerial.'</DeclineURL>
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

        //Print out the response output.
        echo "Print_r the respone".PHP_EOL."<br><br>";
        print_r($resultXML);
        echo PHP_EOL.PHP_EOL."<br><br>Status -> ".$resultXML->Response->Status;
        //00 -> successfully
        if ($resultXML->Response->Status == '00') {
            $newData['fld_status'] = 'Success';
        } //30 -> message invalid format (no mandatory fields etc.)
        else if ($resultXML->Response->Status == '30') {
            $newData['fld_status'] = 'InvalidFormat';
        } //10->the Merchant has no access to the CreateOrder operation (or the Merchant is not registered)
        else if ($resultXML->Response->Status == '10') {
            $newData['fld_status'] = 'NoAccess';
        }
        $orderID = $resultXML->Response->Order->OrderID;
        $sessionID = $resultXML->Response->Order->SessionID;
        $newData['fld_order_ID'] = $orderID;
        $newData['fld_session_ID'] = $sessionID;
        $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $newSerial, $newSerial, 'fld_', 'execute', 'rcbp_');



    }

    public function sentPurchaseCard($rcbPaymentID = 0){
        global $db;

        if ($rcbPaymentID == 0 || $rcbPaymentID == ''){
            if ($this->paymentID > 0){
                $rcbPaymentID = $this->paymentID;
            }
            else {
                $this->error = true;
                $this->errorDescription = 'Must set payment ID';
            }
        }

        if ($this->cardNumber == ''){
            $this->error = true;
            $this->errorDescription ='Card number cannot be empty';
        }
        if ($this->cardExpiry == ''){
            $this->error = true;
            $this->errorDescription = 'Card expiry cannot be empty';
        }
        if ($this->cardCCV == ''){
            $this->error = true;
            $this->errorDescription = 'Card CCV cannot be empty';
        }

        if ($this->error){
            return false;
        }
        
        $rcbPaymentData = $db->query_fetch('SELECT * FROM rcb_payments WHERE rcbp_payment_ID = '.$rcbPaymentID);

        if ($rcbPaymentData['rcbp_order_ID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Order ID for '.$rcbPaymentID.' is empty';
            return false;
        }

        if ($rcbPaymentData['rcbp_session_ID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Session ID for '.$rcbPaymentID.' is empty';
            return false;
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<TKKPG>
    <Request>
        <Operation>Purchase</Operation>
        <Order>
            <Merchant>'.$this->RCBMerchant.'</Merchant>
            <OrderID>'.$rcbPaymentData['rcbp_order_ID'].'</OrderID>
            <AddParams>
            
            </AddParams>
        </Order>
        <SessionID>'.$rcbPaymentData['rcbp_session_ID'].'</SessionID>
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

        echo "<br><hr>Payment XML<hr>".PHP_EOL.PHP_EOL.$xml.PHP_EOL.PHP_EOL;

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

        echo "<br><hr>Sent Purchase Results:<br><hr>";
        print_r($resultXML);

        echo "\n\n\n<br><br>Order Status:".$resultXML->XMLOut->Message->OrderStatus;
        echo "<hr>";
        print_r($resultXML->XMLOut->Message->OrderStatus);

        $payNewData['fld_payment_status'] = $resultXML->XMLOut->Message->OrderStatus;
        if ($resultXML->XMLOut->Message->OrderStatus == 'APPROVED'){
            $this->errorDescription = 'PAYMENT SUCCESSFULL';
            $payNewData['fld_token'] = $resultXML->XMLOut->Message->Response_g;
        }
        else if ($resultXML->XMLOut->Message->OrderStatus == 'DECLINED'){
            $this->error = true;
            $this->errorDescription = 'Payment Declined';
        }
        $db->db_tool_update_row('rcb_payments', $payNewData, 'rcbp_payment_ID = '.$this->paymentID, $this->paymentID,'fld_','execute','rcbp_');



    }

    public function sentPurchaseToken($rcbPaymentID = 0){
        global $db;

        if ($rcbPaymentID == 0 || $rcbPaymentID == ''){
            if ($this->paymentID > 0){
                $rcbPaymentID = $this->paymentID;
            }
            else {
                $this->error = true;
                $this->errorDescription = 'Must set payment ID';
            }
        }

        if ($this->tokenNumber == ''){
            $this->error = true;
            $this->errorDescription ='Token number cannot be empty';
        }

        if ($this->error){
            return false;
        }

        $rcbPaymentData = $db->query_fetch("SELECT * FROM rcb_payments WHERE rcbp_token = '".$this->tokenNumber."'");

        if ($rcbPaymentData['rcbp_order_ID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Order ID for '.$rcbPaymentID.' is empty';
            return false;
        }

        if ($rcbPaymentData['rcbp_session_ID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Session ID for '.$rcbPaymentID.' is empty';
            return false;
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<TKKPG>
    <Request>
        <Operation>Purchase</Operation>
        <Order>
            <Merchant>'.$this->RCBMerchant.'</Merchant>
            <OrderID>'.$rcbPaymentData['rcbp_order_ID'].'</OrderID>
            <AddParams>
            
            </AddParams>
        </Order>
        <SessionID>'.$rcbPaymentData['rcbp_session_ID'].'</SessionID>
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

        echo "<br><hr>Payment XML<hr>".PHP_EOL.PHP_EOL.$xml.PHP_EOL.PHP_EOL;

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

        echo "<br><hr>Sent Purchase Results:<br><hr>";
        print_r($resultXML);

        echo "\n\n\n<br><br>Order Status:".$resultXML->XMLOut->Message->OrderStatus;
        echo "<hr>";
        print_r($resultXML->XMLOut->Message->OrderStatus);

        $payNewData['fld_payment_status'] = $resultXML->XMLOut->Message->OrderStatus;
        if ($resultXML->XMLOut->Message->OrderStatus == 'APPROVED'){
            $this->errorDescription = 'PAYMENT SUCCESSFULL';
            $payNewData['fld_token'] = $resultXML->XMLOut->Message->Response_g;
        }
        else if ($resultXML->XMLOut->Message->OrderStatus == 'DECLINED'){
            $this->error = true;
            $this->errorDescription = 'Payment Declined';
        }
        $db->db_tool_update_row('rcb_payments', $payNewData, 'rcbp_payment_ID = '.$this->paymentID, $this->paymentID,'fld_','execute','rcbp_');



    }

    public function getResponseDecline($serial)
    {
        global $db;
        $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseDecline('.$serial.')');

        if ($serial > 0) {

            $newData['fld_online_status'] = 'Declined';
            $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $serial, $serial, 'fld_', 'execute', 'rcbp_');
        } else {
            $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseDecline(emptyID)');
        }
    }

    public function getResponseCancel($serial)
    {
        global $db;
        $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseCancel('.$serial.')');
        if ($serial > 0) {
            $newData['fld_online_status'] = 'Cancelled';
            $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $serial, $serial, 'fld_', 'execute', 'rcbp_');
        } else {
            $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseDecline(emptyID)');
        }
    }

    public function getResponseApprove($serial)
    {
        global $db;
        $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseApprove('.$serial.')');
        if ($serial > 0) {
            $newData['fld_online_status'] = 'Approved';
            $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $serial, $serial, 'fld_', 'execute', 'rcbp_');
        } else {
            $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseDecline(emptyID)');
        }
    }

    //getters setters


    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
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
     * @return mixed
     */
    public function getTokenNumber()
    {
        return $this->tokenNumber;
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
     * @return mixed
     */
    public function getCardExpiry()
    {
        return $this->cardExpiry;
    }

    /**
     * @param $cardExpiry example 2001 (01/2020)
     * @return $this
     */
    public function setCardExpiry($cardExpiry)
    {
        $this->cardExpiry = $cardExpiry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardCCV()
    {
        return $this->cardCCV;
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
     * @return mixed
     */
    public function getPaymentID()
    {
        return $this->paymentID;
    }

    /**
     * @param $paymentID
     * @return $this
     */
    public function setPaymentID($paymentID)
    {
        $this->paymentID = $paymentID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurchaseAmount()
    {
        return $this->purchaseAmount;
    }

    /**
     * @param $purchaseAmount 1 euro is 100cents
     * @return $this
     */
    public function setPurchaseAmount($purchaseAmount)
    {
        $this->purchaseAmount = $purchaseAmount;
        return $this;
    }



}