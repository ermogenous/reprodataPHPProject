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

    function __construct()
    {
    }

    public function sendSMS($smsID)
    {
        global $db;
        if ($smsID == ''){
            $this->error = true;
            $this->errorDescription = 'SendSMS: No sms ID is defined.';
            return false;
        }
        $this->smsData = $db->query_fetch('SELECT * FROM sms WHERE sms_sms_ID = '.$smsID);
        $result = $this->executeSMS();
        if ($result){
            //success
            $newData['fld_status'] = 'Delivered';
            $db->db_tool_update_row('sms',$newData,'sms_sms_ID = '.$smsID,$smsID,'fld_','execute','sms_');
        }
        else {
            $newData['fld_status'] = 'Error';
            $newData['fld_status_description'] = 'Error';
            $db->db_tool_update_row('sms',$newData,'sms_sms_ID = '.$smsID,$smsID,'fld_','execute','sms_');
        }
    }

    private function executeSMS(){
        //sending the sms
        return true;
    }

}



