<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 18/10/2019
 * Time: 4:32 ΜΜ
 */

class Synthesis
{

    private static $url = 'https://93.109.209.131/demo120';
    private static $password = '123456';
    private static $username = 'Michalis';

    public $error = false;
    public $errorDescription = '';
    private $loginStatus = false;
    private $loginCompanyName;
    private $dbUsername;
    private $dbPassword;
    private $currentToken;
    private $currentTokenLife;

    function __construct()
    {

    }

    public function getToken()
    {
        $url = self::$url."/ws_token?arg_username=" . self::$username . "&arg_password=" . self::$password;

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);

        if ($data[0]->status != 'error') {
            $this->currentToken = $data[0]->rs_token;
            $this->currentTokenLife = $data[0]->rdt_token_life;
            return true;
        } else {
            $this->error = true;
            $this->errorDescription = $data[0]->message;
            return false;
        }
    }

    public function getAccountList()
    {
        $this->getToken();
        $url = self::$url."/ws_accountlist?arg_username=".self::$username."&arg_token=".$this->currentToken;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        $data['totalRows'] = count($data);

        return $data;
    }

    public function getAccountDetails($accountCode){
        $this->getToken();
        $url = self::$url."/ws_accountdetail?arg_username=".self::$username."&arg_token=".$this->currentToken."&arg_account=".$accountCode;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        return $data[0];
    }

    public function updateAccountDetails($newData){
        $this->getToken();
        $url = self::$url."/ws_accountimport?arg_username=".self::$username."&arg_token=".$this->currentToken;

        if ($newData['account_code'] != ''){
            $url .= "&arg_account_code=".$newData['account_code'];
        }
        if ($newData['long_description'] != ''){
            $url .= "&arg_long_description=".$newData['long_description'];
        }
        if ($newData['addr_lin1'] != ''){
            $url .= "&arg_addr_lin1=".$newData['addr_lin1'];
        }
        if ($newData['addr_lin2'] != ''){
            $url .= "&arg_addr_lin2=".$newData['addr_lin2'];
        }
        if ($newData['addr_lin3'] != ''){
            $url .= "&arg_addr_lin3=".$newData['addr_lin3'];
        }
        if ($newData['addr_lin4'] != ''){
            $url .= "&arg_addr_lin4=".$newData['addr_lin4'];
        }
        if ($newData['crdt_lmit'] != ''){
            $url .= "&arg_crdt_lmit=".$newData['crdt_lmit'];
        }
        if ($newData['crdt_days'] != ''){
            $url .= "&arg_crdt_days=".$newData['crdt_days'];
        }
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        return $data[0];

    }

    public function checkImportStatus($id){
        $this->getToken();
        $url = self::$url."/ws_checkacimport?arg_username=".self::$username."&arg_token=".$this->currentToken."&arg_auto_serial=".$id;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        return $data[0];
    }

    public function logout()
    {
        /*
        $url = 'http://93.109.209.131:80/sysystem/ws_logout?arg_username=' . self::$username;
        $xml = simplexml_load_file($url);
        return true;
        */
    }

}