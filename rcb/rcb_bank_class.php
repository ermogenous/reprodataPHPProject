<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2020
 * Time: 2:47 μ.μ.
 */

class rcbConnection
{

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
        //1. make the record in db
        $newData['fld_status'] = 'Create';
        $newSerial = $db->db_tool_insert_row('rcb_payments', $newData, 'fld_', 1, 'rcbp_');


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<TKKPG>
<Request>
<Operation>CreateOrder</Operation>
<Language>EN</Language>
<Order>
<OrderType>Purchase</OrderType>
<Merchant>99000013</Merchant>
<Amount>001</Amount>
<Currency>978</Currency>
<Description>Test1</Description>
<ApproveURL>/testshopPageReturn.jsp</ApproveURL>
<CancelURL>/testshopPageReturn.jsp</CancelURL>
<DeclineURL>/testshopPageReturn.jsp</DeclineURL>
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
        //Do some basic error checking.
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }
        //Close the cURL handle.
        curl_close($curl);
        //Print out the response output.
        echo $result;

        //00 -> successfully
        if ($result->Response->Status == '00') {
            $newData['fld_status'] = 'Success';
        } //30 -> message invalid format (no mandatory fields etc.)
        else if ($result->Response->Status == '30') {
            $newData['fld_status'] = 'InvalidFormat';
        } //10->the Merchant has no access to the CreateOrder operation (or the Merchant is not registered)
        else if ($result->Response->Status == '10') {
            $newData['fld_status'] = 'NoAccess';
        }
        $orderID = $result->Response->Order->OrderID;
        $newData['fld_order_ID'] = $orderID;
        $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $newSerial, $newSerial, 'fld_', 'execute', 'rdbp_');



    }

    public function getResponseDecline($serial)
    {
        global $db;
        $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseDecline('.$serial.')');

        if ($serial > 0) {

            $newData['fld_online_status'] = 'Declined';
            $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $serial, $serial, 'fld_', 'execute', 'rdbp_');
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
            $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $serial, $serial, 'fld_', 'execute', 'rdbp_');
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
            $db->db_tool_update_row('rcb_payments', $newData, 'rcbp_payment_ID = ' . $serial, $serial, 'fld_', 'execute', 'rdbp_');
        } else {
            $db->update_log_file('rcb_payments', 0, 'Class rcb_bank_class->getResponseDecline(emptyID)');
        }
    }

}