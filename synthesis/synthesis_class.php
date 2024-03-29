<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 18/10/2019
 * Time: 4:32 ΜΜ
 */

class Synthesis
{

    private $url = '';
    private $password = '';
    private $username = '';
    private $companyID = 0;
    private $companyName = '';

    public $error = false;
    public $errorDescription = '';
    private $loginStatus = false;
    private $loginCompanyName;
    private $dbUsername;
    private $dbPassword;
    private $currentToken;
    private $currentTokenLife;

    function __construct($autologin = true)
    {
        global $main;

        if ($autologin == true){
            if ($_SESSION[$main['environment']."_logged_in"] == 1){
                $this->loginWebUser();
            }
            else {
                //empty the sessions and redirect to the login page
                unset($_SESSION[$main['environment']."_logged_in"]);
                unset($_SESSION[$main['environment']."_usernm"]);
                unset($_SESSION[$main['environment']."_userpswd"]);
                unset($_SESSION[$main['environment']."_description"]);
                unset($_SESSION[$main['environment']."_menu"]);
                unset($_SESSION[$main['environment']."_status"]);

                header("Location:" . $main["site_url"] . "/synthesis/syn_login.php");
                exit();
            }
        }
    }

    public function getToken()
    {

        //check if the variables are set
        if ($this->url == '') {
            $this->error = true;
            $this->errorDescription = 'Token: Url is not specified';
        }
        if ($this->url == '') {
            $this->error = true;
            $this->errorDescription = 'Token: Username is not specified';
        }
        if ($this->url == '') {
            $this->error = true;
            $this->errorDescription = 'Token: Password is not specified';
        }
        if ($this->url == '') {
            $this->error = true;
            $this->errorDescription = 'Token: Company Name is not specified';
        }
        if ($this->error) {
            return false;
        }

        $url = $this->url . "/ws_token?arg_username=" . $this->username . "&arg_password=" . $this->password;
        //echo $url;exit();
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));

        if ($response == false || $response == '') {
            $this->errorDescription = 'Cannot reach the database.';
            $this->error = true;
            return false;
        }
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

    public function loginWebUser($username='', $password=''){
        global $db,$main;

        //if parameters are not empty then set the session
        if ($username != '' && $password != ''){
            $_SESSION[$main['environment']."_usernm"] = $username;
            $_SESSION[$main['environment']."_userpswd"] = $password;
        }

        //if admin user - check in db to see if this user exists
        $sql = "SELECT * FROM `users` WHERE 1=1 
                        AND `usr_password` = '".addslashes($_SESSION[$main['environment']."_userpswd"])."' 
                        AND `usr_username` = '".addslashes($_SESSION[$main['environment']."_usernm"])."'";
        $result = $db->query($sql);
        if ($db->num_rows($result) > 0) {
            $row = $db->fetch_assoc($result);

            //check if local user is active
            if ($row['usr_active'] == 1) {
                $_SESSION[$main['environment']."_logged_in"] = true;
                $_SESSION[$main['environment']."_user_ID"] = $row['usr_users_ID'];
                $_SESSION[$main['environment']."_status"] = 'N';
                $_SESSION[$main['environment']."_menu"] = 'Admin,';
                $_SESSION[$main["environment"] . "_admin_username"] = $_SESSION[$main['environment']."_usernm"];
                $_SESSION[$main["environment"] . "_admin_password"] = $_SESSION[$main['environment']."_userpswd"];
                $db->check_login();
                $_SESSION[$main['environment']."_description"] = $db->user_data['usr_name'];

                //check if the session is the same
                $sessionID = session_id();
                if ($sessionID == $db->user_data['usr_session_ID']){
                    //same session. login success
                }
                //session is not the same.
                else {

                    //check if the session is expired or session empty
                    $dateSession = strtotime($db->user_data['usr_last_login']);
                    $dateNow = strtotime(date("Y-m-d G:i:s"));
                    $secondsLapsed = $dateNow - $dateSession;
                    if ($secondsLapsed > 600 || $db->user_data['usr_session_ID'] == '' || $db->user_data['usr_session_ID'] == null){
                        //should allow login with new session
                        $newData['fld_session_id'] = $sessionID;
                        //update last login
                        $newData['fld_last_login'] = date("Y-m-d G:i:s");
                        $db->db_tool_update_row('users',$newData,
                            'usr_users_ID = '.$row['usr_users_ID'],$row['usr_users_ID'],'fld_','execute','usr_');
                        return true;
                    }

                    //not allowed to login
                    $this->error = true;
                    $this->errorDescription = 'You are already connected on another session. Logout first from that one.';
                    return false;
                }


                return true;
            }
            else {
                //user inactive/suspended
                $this->error = true;
                $this->errorDescription = 'Your account is suspended. Please contact the administrator.';
                return false;
            }
        }//if correct

        //if no user is found in the db then proceed to login to companies users
        /*if ($_SESSION[$main['environment']."_usernm"] == 'adminmike' && $_SESSION[$main['environment']."_userpswd"] == 'adminmike'){
            $_SESSION[$main['environment']."_logged_in"] = true;
            $_SESSION[$main['environment']."_description"] = 'Admin';
            $_SESSION[$main['environment']."_status"] = 'N';
            $_SESSION[$main['environment']."_menu"] = 'Admin,';
            //login in the system
            $_SESSION[$main["environment"] . "_admin_password"] = 'mike';
            $_SESSION[$main["environment"] . "_admin_username"] = 'mike';
            $db->check_login();
            return true;
        }*/

        //print_r($_SESSION);

        //first check if this username/email exists and which company is it to set the company parameters
        $webUser = $db->query_fetch('
            SELECT * FROM sy_web_users
            JOIN sy_companies ON sywu_company_ID = syco_company_ID 
            WHERE sywu_user_code = "'.$_SESSION[$main['environment']."_usernm"].'"');

        //check if there is a result. If not then the username does not exists
        if ($webUser['sywu_web_user_ID'] == 0 || $webUser['sywu_web_user_ID'] == ''){
            //the user name/email does not exists
            $this->error = true;
            $this->errorDescription = 'Username/code does not exists';
            return false;
        }


        //set the class parameters for the admin to validate the user
        $this->setCompanyID($webUser['syco_company_ID']);
        $this->setCompanyName($webUser['syco_name']);
        $this->setUrl($webUser['syco_database_ip']);
        $this->setUsername($webUser['syco_admin_user_name']);
        $this->setPassword($webUser['syco_admin_password']);

        //validate the user
        $synUserData = $this->getWebUser($_SESSION[$main['environment']."_usernm"]);
        if ($this->error){
            return false;
        }

        //check if the token generated error or the return user is not the same
        if ($this->error == true || $synUserData[0]->ccwu_web_user != $_SESSION[$main['environment']."_usernm"]){
            $this->errorDescription = 'Wrong Username and/or Password';
            //empty the session vars
            unset($_SESSION[$main['environment']."_logged_in"]);
            unset($_SESSION[$main['environment']."_web_user"]);
            unset($_SESSION[$main['environment']."_usernm"]);
            unset($_SESSION[$main['environment']."_userpswd"]);
            unset($_SESSION[$main['environment']."_description"]);
            unset($_SESSION[$main['environment']."_menu"]);
            unset($_SESSION[$main['environment']."_status"]);
            $this->error = true;
            return false;
        }

        //so far the user is valid but might be inactive or suspended
        if ($synUserData[0]->ccwu_web_user_status == 'I'){
            $this->errorDescription = 'Your account is inactive. Contact the system administrator';
            //empty the session vars
            unset($_SESSION[$main['environment']."_logged_in"]);
            unset($_SESSION[$main['environment']."_web_user"]);
            unset($_SESSION[$main['environment']."_usernm"]);
            unset($_SESSION[$main['environment']."_userpswd"]);
            unset($_SESSION[$main['environment']."_description"]);
            unset($_SESSION[$main['environment']."_menu"]);
            unset($_SESSION[$main['environment']."_status"]);
            $this->error = true;
            return false;
        }
        if ($synUserData[0]->ccwu_web_user_status == 'S'){
            $this->errorDescription = 'Your account is suspended. Contact the system administrator';
            //empty the session vars
            unset($_SESSION[$main['environment']."_logged_in"]);
            unset($_SESSION[$main['environment']."_web_user"]);
            unset($_SESSION[$main['environment']."_usernm"]);
            unset($_SESSION[$main['environment']."_userpswd"]);
            unset($_SESSION[$main['environment']."_description"]);
            unset($_SESSION[$main['environment']."_menu"]);
            unset($_SESSION[$main['environment']."_status"]);
            $this->error = true;
            return false;
        }

        //up to here the user is valid
        //proceed to update the session with the user data
        $_SESSION[$main['environment']."_logged_in"] = true;
        $_SESSION[$main['environment']."_web_user"] = $webUser['sywu_web_user_ID'];
        $_SESSION[$main['environment']."_description"] = $synUserData[0]->ccwu_web_user_description;
        $_SESSION[$main['environment']."_status"] = $synUserData[0]->ccwu_web_user_status;
        $_SESSION[$main['environment']."_menu"] = $synUserData[0]->ccwu_user_menus;

        //also add the user data in db ??????????
        $userData['username'] = $_SESSION[$main['environment']."_usernm"];
        $userData['description'] = $synUserData[0]->ccwu_web_user_description;
        $userData['status'] = $synUserData[0]->ccwu_web_user_status;
        $userData['menu'] = $synUserData[0]->ccwu_user_menus;

        //update the object settings to work with the logged in user
        $this->setUsername($_SESSION[$main['environment']."_usernm"]);
        $this->setPassword($_SESSION[$main['environment']."_userpswd"]);


        //check if the session is the same
        $sessionID = session_id();
        if ($sessionID == $webUser['sywu_session_id']){
            //same session. login success
        }
        //session is not the same.
        else {

            //check if the session is expired or session empty
            if ($webUser['sywu_last_login'] == ''){
                $webUser['sywu_last_login'] = '0000-00-00';
            }
            $dateSession = strtotime($webUser['sywu_last_login']);
            $dateNow = strtotime(date("Y-m-d G:i:s"));
            $secondsLapsed = $dateNow - $dateSession;
            if ($secondsLapsed > 600 || $webUser['sywu_session_id'] == '' || $webUser['sywu_session_id'] == null){
                //should allow login with new session
                $newData['fld_session_id'] = $sessionID;
                //update last login
                $newData['fld_last_login'] = date("Y-m-d G:i:s");
                $db->db_tool_update_row('sy_web_users',$newData,
                    'sywu_web_user_ID = '.$webUser['sywu_web_user_ID'],$webUser['sywu_web_user_ID'],
                    'fld_','execute','sywu_');
                return true;
            }

            //not allowed to login
            $this->error = true;
            $this->errorDescription = 'You are already connected on another session. Logout first from that one.';
            return false;
        }


        return true;
    }

    //get details of a specific user
    public function getWebUser($webUser)
    {
        global $db;
        $this->getToken();
        if ($this->error){
            return false;
        }
        $url = $this->url . '/ws_webusers?arg_username='.$this->username.'&arg_token=' . $this->currentToken
                .'&arg_web_user='.$webUser;
        //echo $url."<br>";
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        @$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($response == false) {
            $this->errorDescription = 'Cannot reach the database.';
            $this->error = true;
            return false;
        }
        $data = json_decode($response);
        return $data;

    }

    //update the company connection web users. The company is defined in the private url/username/password vars
    public function updateCompanyWebUsers()
    {
        global $db;

        //init
        $return['result'] = false;
        $return['info'] = 'Updating Companies' . $this->companyName . ' Web Users\n';

        $tokenRes = $this->getToken();

        if ($tokenRes) {
            $return['info'] = 'Token received success: ' . $this->currentToken . "\n";
        } else {
            $return['info'] = 'Token received error: ' . $this->errorDescription . "\n";
        }
        if ($this->error) {
            $db->update_log_file('Synthesis_Class', 0,
                'UpdateCompanyWebUsers' . $this->companyName . '[ERROR]', '', '', $return['info']);
        }

        $url = $this->url . '/ws_webusers?arg_username=Admin&arg_token=' . $this->currentToken;
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        @$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($response == false) {
            $this->errorDescription = 'Cannot reach the database.';
            $this->error = true;
            return false;
        }
        $data = json_decode($response);
        if ($data[0]->status != 'error') {
            foreach ($data as $name => $value) {

                //echo $value->ccwu_web_user."<br>";
                //1. Insert OR Update the sy_web_users
                if ($value->ccwu_web_user_status == 'N') {
                    $userStatus = 'Active';
                } else if ($value->ccwu_web_user_status == 'I'){
                    $userStatus = 'InActive';
                }
                else if ($value->ccwu_web_user_status == 'M'){
                    $userStatus = 'Monitored';
                }
                else if ($value->ccwu_web_user_status == 'S'){
                    $userStatus = 'Suspended';
                }
                $newData['fld_company_ID'] = $this->companyID;
                $newData['fld_user_code'] = $value->ccwu_web_user;
                $newData['fld_description'] = $value->ccwu_web_user_description;
                $newData['fld_status'] = $userStatus;
                $newData['fld_menu'] = $value->ccwu_user_menus;
                $newData['fld_type'] = 'Auto';
                $db->db_tool_insert_update_row('sy_web_users', $newData, "sywu_user_code = '" . $value->ccwu_web_user . "'",
                    'sywu_web_user_ID', 'fld_', 'sywu_');
                //for log
                $return['info'] .= 'Update/Insert Synthesis Web User: ' . $value->ccwu_web_user . "\n";
            }//for each web user
            $db->update_log_file('Synthesis_Class', 0,
                'UpdateCompany' . $this->companyName . 'WebUsers[SUCCESS]', '', '', $return['info']);
            return true;
        } else {
            $this->error = true;
            $this->errorDescription = $data[0]->message;
            $return['info'] .= $data[0]->message;
            $db->update_log_file('Synthesis_Class', 0,
                'UpdateCompany' . $this->companyName . 'WebUsers[ERROR]', '', '', $return['info']);
            return false;
        }

    }//getWebUsers()

    public function getAccountList($whereClause = '', $orderClause = '')
    {
        global $db;
        $this->getToken();
        if ($this->error == true) {
            return false;
        }

        if ($whereClause == '' && $orderClause == '') {
            $url = $this->url . "/ws_accountlist?arg_username=" . $this->username . "&arg_token=" . $this->currentToken;
        } else {
            $whereSql = '';
            $orderSql = '';
            if ($whereClause != '') {
                $whereSql = "&arg_where=" . urlencode($whereClause);
                //$whereSql = "&arg_where=Left(clo_account_code,6)='002101' Or (COALESCE(NULLIF(clo_address_email,''),'synthesis') not like('%synthesis%') AND CHARINDEX('@',clo_address_email) <> 0)&arg_sort=clo_account_code,clo_address_description desc";
            }
            if ($orderClause != '') {
                $orderSql = "&arg_sort=" . urlencode($orderClause);
            }
            $url = $this->url . "/ws_accountlist?arg_username=" . $this->username . "&arg_token=" . $this->currentToken . $whereSql . $orderSql;

        }
        //echo $url;

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        @$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($response == false) {
            $this->error = true;
            $this->errorDescription = 'Cannot reach the database.';
            return false;
        }
        $data = json_decode($response);
        $data['totalRows'] = count($data);
        if ($data[0]->status == 'error') {
            //echo "An error has been found.";
            if ($db->user_data['usr_user_rights'] == 0) {
                echo "<br><br>" . $url;
                echo "<br><br>" . $data[0]->message;
            }
        }
        //echo $data[0]->status;
        //print_r($data);
        return $data;
    }

    public function getAccountDetails($accountCode)
    {
        $this->getToken();
        $url = $this->url . "/ws_accountdetail?arg_username=" . $this->username . "&arg_token=" . $this->currentToken . "&arg_account=" . $accountCode;
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        return $data[0];
    }

    public function updateAccountDetails($newData)
    {
        global $db;
        $this->getToken();
        $url = $this->url . "/ws_accountimport?arg_username=" . $this->username . "&arg_token=" . $this->currentToken;

        if ($newData['account_code'] != '') {
            $url .= "&arg_account_code=" . urlencode($newData['account_code']);
        }
        if ($newData['long_description'] != '') {
            $url .= "&arg_long_description=" . urlencode($newData['long_description']);
        }
        if ($newData['addr_lin1'] != '') {
            $url .= "&arg_addr_lin1=" . urlencode($newData['addr_lin1']);
        }
        if ($newData['addr_lin2'] != '') {
            $url .= "&arg_addr_lin2=" . urlencode($newData['addr_lin2']);
        }
        if ($newData['addr_lin3'] != '') {
            $url .= "&arg_addr_lin3=" . urlencode($newData['addr_lin3']);
        }
        if ($newData['addr_lin4'] != '') {
            $url .= "&arg_addr_lin4=" . urlencode($newData['addr_lin4']);
        }
        if ($newData['crdt_lmit'] != '') {
            $url .= "&arg_crdt_lmit=" . urlencode($newData['crdt_lmit']);
        }
        if ($newData['crdt_days'] != '') {
            $url .= "&arg_crdt_days=" . urlencode($newData['crdt_days']);
        }
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);

        //create a record in sy_import_status
        //first delete any existing
        $deleteSql = "Delete FROM sy_import_status WHERE syist_record_type = 'Account' AND syist_record_ID = '" . $newData['account_code'] . "'";
        $db->query($deleteSql);
        $insertData['fld_record_ID'] = $newData['account_code'];
        $insertData['fld_import_ID'] = $data[0]->rs_auto_serial;
        $insertData['fld_record_type'] = 'Account';
        $db->db_tool_insert_row('sy_import_status', $insertData, 'fld_', 0, 'syist_');

        return $data[0];

    }

    //INVENTORY FUNCTIONS
    public function getInventoryList($whereClause = '', $orderClause = '')
    {
        global $db;
        $this->getToken();
        if ($this->error == true) {
            return false;
        }

        if ($whereClause == '' && $orderClause == '') {
            $url = $this->url . "/ws_itemlist?arg_username=" . $this->username . "&arg_token=" . $this->currentToken;
        } else {
            $whereSql = '';
            $orderSql = '';
            if ($whereClause != '') {
                $whereSql = "&arg_where=" . urlencode($whereClause);
            }
            if ($orderClause != '') {
                $orderSql = "&arg_sort=" . urlencode($orderClause);
            }
            $url = $this->url . "/ws_itemlist?arg_username=" . $this->username . "&arg_token=" . $this->currentToken . $whereSql . $orderSql;

        }
        //echo $url;

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        @$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($response == false) {
            $this->error = true;
            $this->errorDescription = 'Cannot reach the database.';
            return false;
        }

        //print_r($response);

        $data = json_decode($response);
        $data['totalRows'] = count($data);
        if ($data[0]->status == 'error') {
            $this->error = true;
            $this->errorDescription = $data[0]->message;
            return false;
        }
        //echo $data[0]->status;
        //print_r($data);
        return $data;
    }

    public function getProductDetail($productCode)
    {
        global $db;
        $this->getToken();
        if ($this->error == true) {
            return false;
        }

        $url = $this->url . "/ws_itemdetail?arg_username=" . $this->username . "&arg_token=" . $this->currentToken . "&arg_item=" . $productCode;

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        @$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($response == false) {
            $this->error = true;
            $this->errorDescription = 'Cannot reach the database.';
            return false;
        }

        //print_r($response);

        $data = json_decode($response);
        $data['totalRows'] = count($data);
        if ($data[0]->status == 'error') {
            $this->errorDescription = $data[0]->message;
            $this->error = true;
            return false;
        }
        //echo $data[0]->status;
        //print_r($data);
        return $data;
    }

    public function checkImportStatus($recordType, $recordID)
    {
        global $db;

        $sql = "SELECT * FROM sy_import_status WHERE syist_record_type = '" . $recordType . "' AND syist_record_ID = '" . $recordID . "'";
        $result = $db->query_fetch($sql);

        return $this->checkSynthesisImportStatus($result['syist_import_ID']);
    }

    private function checkSynthesisImportStatus($id)
    {
        $this->getToken();
        $url = $this->url . "/ws_checkacimport?arg_username=" . $this->username . "&arg_token=" . $this->currentToken . "&arg_auto_serial=" . $id;
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        return $data[0];
    }

    public function getAccountTransactionList($accountCode, $fromDate = '', $toDate = '')
    {
        $this->getToken();
        if ($this->error == true){
            return false;
        }
        $url = $this->url . "/ws_accounttransactions?arg_username=" . $this->username . "&arg_token=" . $this->currentToken . "&arg_account_code=" . $accountCode;
        if ($fromDate != '') {
            $url .= '&arg_from_date=' . $fromDate;
        }
        if ($toDate != '') {
            $url .= '&arg_upto_date=' . $toDate;
        }
        //echo $url;
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        //echo "<br><br>";
        //print_r($data);
        if ($data[0]->status == 'error') {
            //echo "An error has been found.";
            $this->error = true;
            $this->errorDescription = $data[0]->message;
            return false;
        }
        return $data;
    }

    public function logout()
    {
        /*
        $url = 'http://93.109.209.131:80/sysystem/ws_logout?arg_username=' . self::$username;
        $xml = simplexml_load_file($url);
        return true;
        */
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setCompanyName(string $name)
    {
        $this->companyName = $name;
        return $this;
    }

    /**
     * @param string $ID
     * @return $this
     */
    public function setCompanyID(string $ID)
    {
        $this->companyID = $ID;
        return $this;
    }
}
