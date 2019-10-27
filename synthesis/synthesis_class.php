<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 18/10/2019
 * Time: 4:32 ΜΜ
 */

class Synthesis
{

    private static $password = 'password';
    private static $username = 'user';


    public $error = false;
    public $errorDescription = '';
    private $loginStatus = false;
    private $loginCompanyName;
    private $dbUsername;
    private $dbPassword;

    function __construct()
    {
        if ($this->login() == true) {
            $this->loginStatus = true;
            return true;
        } else {
            $this->error = true;
            $this->errorDescription = 'Unsuccessful login';
            return false;
        }
    }

    private function login()
    {
        $url = "http://93.109.209.131:80/sysystem/ws_login?arg_username=" . self::$username . "&arg_password=" . self::$password;

        $xml = simplexml_load_file($url);

        if ($xml->row['rs_result'] == 'Y') {
            $this->loginCompanyName = $xml->row['rs_client_company'];
            $this->dbUsername = $xml->row['rs_db_user'];
            $this->dbPassword = $xml->row['rs_db_password'];
            return true;
        } else {

            return false;
        }
    }

    public function getAccountList()
    {
        $url = "http://".$this->dbUsername.":".$this->dbPassword."@93.109.209.131:80/".$this->loginCompanyName."/ws_accountlistjson?arg_user=".self::$username;
        $json = json_decode(file_get_contents($url));

        print_r($json);exit();

        $xml = simplexml_load_file($url);
        $result['rows'] = $xml->row;
        $result['totalRows'] = count($xml->row);
        return $result;
    }

    public function logout()
    {
        $url = 'http://93.109.209.131:80/sysystem/ws_logout?arg_username=' . self::$username;
        $xml = simplexml_load_file($url);
        return true;
    }

}