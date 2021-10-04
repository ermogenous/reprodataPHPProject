<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 5/8/2021
 * Time: 12:49 μ.μ.
 */


/*

$url = "https://api.bulksmsonline.com:9090/smsapi?username=MichEr233&password=Kmariou24&type=t&to=0035799435556&source=ErmoTest&message=SomeTest";

$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
// grab URL and pass it to the browser
$result = curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);
*/

class ME_SMS
{
    public $error = false;
    public $errorDescription = '';
    private $smsData;
    private $API_KEY = '7fXUdeTCoZkz9Mw1LUitNQbJhaFSfdQk';

    function __construct()
    {
    }

    private function loadSmsData($smsID){
        global $db;
        $this->smsData = $db->query_fetch('SELECT * FROM sms WHERE sms_sms_ID = '.$smsID);
    }

    public function sendSMS($smsID)
    {
        global $db;
        if ($smsID == ''){
            $this->error = true;
            $this->errorDescription = 'SendSMS: No sms ID is defined.';
            return false;
        }
        $this->loadSmsData($smsID);
        $result = $this->executeSMS();
        if ($result['status']){
            //success
            $newData['fld_status'] = 'Send';
            $newData['fld_status_description'] = $result['result_message'];
            $newData['fld_sender_id'] = $result['message_id'];
            $db->db_tool_update_row('sms',$newData,'sms_sms_ID = '.$smsID,$smsID,'fld_','execute','sms_');
            return true;
        }
        else {
            $newData['fld_status'] = 'Error';
            $newData['fld_status_description'] = $result['result_message'];
            $db->db_tool_update_row('sms',$newData,'sms_sms_ID = '.$smsID,$smsID,'fld_','execute','sms_');
            $this->error = true;
            $this->errorDescription = "Send SMS for ID:".$this->smsData['sms_sms_ID']." - ".$result['result_message'];
            return false;
        }
    }

    private function executeSMS(){
        //sending the sms
        $number = $this->prepareNumber($this->smsData['sms_to_num']);
        echo "Send to number:".$number."<br>";
        echo "Subject:".$this->smsData['sms_subject']."<br>";
        echo "Message:".$this->smsData['sms_message']."<br>";
        echo "From:".$this->smsData['sms_from']."<br>";


        $curl = curl_init();

        $headers = ["Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer ".$this->API_KEY];

        $params = [
                'to' => $number,
                "bypass_optout" => true,
                'message' => $this->smsData['sms_message'],//"This is test \n   This is a new line",
                //'callback_url' => "https://example.com/callback/handler",
                'sender_id' => $this->smsData['sms_from']
                ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sms.to/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        //print_r($response);
        //exit();
        //echo "<BR><br>";
        if ($response->success){
            $result['status'] = true;
            $result['message_id'] = $response->message_id;
            $result['result_message'] = $response->message;
        }
        else {
            $result['status'] = false;
            $result['result_message'] = $response->message;
        }
        /*
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sms.to/sms/send?api_key={7fXUdeTCoZkz9Mw1LUitNQbJhaFSfdQk}&bypass_optout=true&to=".$number."&message=This is test and %0A this is a new line&sender_id=smsto",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);
        echo $response;
        */
        /*
        $ch = curl_init();
        // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
        // in most cases, you should set it to true
        $url = "https://api.sms.to/sms/send?api_key=7fXUdeTCoZkz9Mw1LUitNQbJhaFSfdQk";
        $url .= "&bypass_optout=true";
        $url .= "&to=".$number;
        $url .= "&message=".$this->smsData['sms_message'];//This is test and %0A this is a new line
        $url .= "&sender_id=".$this->smsData['sms_from'];

        echo "URL:".$url."<br>";
        $url = "https://api.sms.to/sms/send?api_key=7fXUdeTCoZkz9Mw1LUitNQbJhaFSfdQk&bypass_optout=true&to=".$number."&message=This is test and %0A this is a new line&sender_id=smsto";
        echo "URL:".$url."<br>";

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_ENCODING,'');
        curl_setopt($ch,CURLOPT_MAXREDIRS,10);
        curl_setopt($ch,CURLOPT_TIMEOUT,0);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURL_HTTP_VERSION_1_1');
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $response2 = json_decode($response);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            echo "Error:".$error_msg."<br>";
        }



        echo "RESPONSE:".$response;
        curl_close($ch);
        print_r($response);
*/

        return $result;
    }

    private function prepareNumber($number){
        if (substr($number,0,1) == '+'){
            //assuming its correct
            return $number;
        }
        else {
            return '+357'.$number;
        }
    }

    public function verifySms($smsID){
        global $db;
        $this->loadSmsData($smsID);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sms.to/message/".$this->smsData['sms_sender_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Bearer ".$this->API_KEY
            ),
        ));

        $response = curl_exec($curl);
        $htmlResponse = $response;
        curl_close($curl);
        $response = json_decode($response);
        //print_r($response);
        //exit();

        if ($response->status == 'DELIVERED'){
            $newData['fld_status'] = 'Delivered';
            $newData['fld_sent_at'] = $response->sent_at;
            $newData['fld_verified_description'] = $htmlResponse;
            $db->db_tool_update_row('sms',$newData,'sms_sms_ID = '.$smsID,$smsID,'fld_','execute','sms_');
            return true;
        }
        else {
            $newData['fld_verified_description'] = $htmlResponse;
            $db->db_tool_update_row('sms',$newData,'sms_sms_ID = '.$smsID,$smsID,'fld_','execute','sms_');
            $this->error = true;
            $this->errorDescription = 'Failed to verified';
            return false;
        }

    }

}



