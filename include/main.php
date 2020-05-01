<?php
/////////////////////////////////////////////////////////////////////
//MAIN CLASS V2.202
//LAST UPDATE 10/07/2019
//- Added START TRANSACTION Functionality
//- added coalesce_null function
//- added update_log_file_custom (inserts empty log with the sql in the description
//- added tiny mce and fixed jquery enables
//- updated insert/update tool to allow fields prefix
//- Added make_fixed_width function
//- Added functionality to db_backup to exclude specified tables
//- Added the ignore_default_settings tha can bypass the main settings.
//- 6/10/2014 Added function prepare_text_as_html($text)
//- 27/8/2015 Added process_lock_validate
//- 21/10/2015 Change from Mysql functions to Mysqli - Class can receive custom $main settings without being affected
//- 29/9/2016 username/password session has been added the $main["environment"]
//- 09/8/2018 add insert/update automatically fields insert_date_time, last_update_date_time and by
//- 04/01/2019 db_tool_delete_row check if the record exists before deleting
//- 09/04/2019 setDebugMode. When true prints all queries executed
//- 10/7/2019 Fixed function error. was giving sql error to all users.
//usefull information
//
//mysqli_query("SET NAMES 'utf8'");
//ini_set("memory_limit","128M");
//ini_set('max_execution_time', 300);
/////////////////////////////////////////////////////////////////////
include("common.php");
require_once($main["local_url"] . '/vendor/autoload.php');


class Main
{

//layout
    var $admin_layout_url;
    var $admin_default_layout;
    var $admin_title;
    var $admin_more_head;
    var $admin_footer_message;
    var $admin_header_message;
    var $admin_layout_printer;
    var $adminLogin = false;

    var $user_data;
    var $originalUserData;
    var $imitationMode = false;
    var $admin_on_load;
    var $system_on_test = 'no'; //yes
    var $db_all_queries;
    var $all_query_results;
    var $db_total_queries;
    var $current_file_name;
    var $db_handle;
    var $started_transaction = 0;
    var $issued_rollback = 0;

    //template
    var $dismissWarning;
    var $dismissError;
    var $dismissSuccess;
    var $dismissInfo;
    var $alertWarning;
    var $alertError;
    var $alertSuccess;
    var $alertInfo;

//query variables
    var $allow_query_select = 1;
    var $allow_query_update = 1;
    var $allow_query_delete = 1;
    var $allow_query_insert = 1;

//settings array
    var $settings;
    private $debugMode = false; //when true prints all queries and executes them also.

//errors
    var $working_section;

//dbSettings
    public $dbSettings;

//encryption
    public $encryptionKey;

    //scripts
    public $enabled_jquery_ui;

//login 1 -> normal permissions.
//login 0 does not login but all else works.
//login -1 ignores the settings. this is to use superclass with a database that does not have the settings table.
    public function __construct($login = 1, $enc = 'UTF-8', $ignore_default_settings = 'no', $use_this_main = 'no')
    {
        global $main;

        $this->encryptionKey = base64_encode('lcsEncryption123321');

        if ($use_this_main != 'no') {
            $this->settings = $use_this_main;
        } else {
            $this->settings = $main;
        }

        //set timezone
        date_default_timezone_set($main["timeZone"]);

        $this->db_total_queries = 0;
        $this->encoding = $enc;
        if ($this->settings["disable_headers"] != 'yes') {
            header('Content-Type: text/html; charset=' . $enc);
            session_start();
        }

        //check if to use $main or $bypass
        if ($ignore_default_settings == 'yes') {
            global $bypass;
            $this->settings = $bypass;
        }

        //connect to database
        //$this->db_handle = mysqli_connect($main["db_host"],$main["db_username"],$main["db_password"]) or die ("Error connecting to Database");
        //mysqli_select_db($this->db_handle,$main["db_database"])or die("Error connecting to Database");
        $this->db_handle = mysqli_connect($this->settings["db_host"], $this->settings["db_username"], $this->settings["db_password"]);
        if ($this->db_handle->errno) {
            echo "Error Connecting to Database";
            exit();
        }

        $this->db_handle->select_db($this->settings["db_database"]);

        $this->db_handle->query("SET NAMES 'utf8'");
        //mysql_query("SET time_zone = '".$this->settings["time_zone"]."'",$this->db_handle);
        if ($login != -1) {
            $this->admin_default_layout = $this->get_setting('admin_default_layout');
            $this->admin_layout_url = $this->settings["site_url"] . "/layout/" . $this->admin_default_layout . "/";
        }
        $this->date_info["full"] = date("d/m/Y H:i:s", mktime(date("H") + 10, date("i"), date("s"), date("m"), date("d"), date("Y")));
        $this->date_info["year"] = substr($this->date_info["full"], 6, 4);
        $this->date_info["month"] = substr($this->date_info["full"], 3, 2);
        $this->date_info["day"] = substr($this->date_info["full"], 0, 2);
        $this->date_info["hour"] = substr($this->date_info["full"], 11, 2);
        $this->date_info["minute"] = substr($this->date_info["full"], 14, 2);
        $this->date_info["second"] = substr($this->date_info["full"], 17, 2);
        $this->date_info["full2"] = $this->date_info["year"] . "-" . $this->date_info["month"] . "-" . $this->date_info["day"] . " " . $this->date_info["hour"] . ":" . $this->date_info["minute"] . ":" . $this->date_info["second"];
        $this->getAllStartUpSettings();
        $this->check_ip_location();
        $this->generateSessionDismiss();
        $this->generateSessionAlert();


        if ($login == 1) {

            $this->check_login();

            //check for language switch
            if ($_GET['switchLang'] == 'eng' || $_GET['switchLang'] == 'gre') {
                $newData['default_lang'] = $_GET['switchLang'];
                $this->db_tool_update_row('users', $newData, 'usr_users_ID = ' . $this->user_data['usr_users_ID'], $this->user_data['usr_users_ID'],
                    '', 'execute', 'usr_');
                header("Location: " . $main['site_url'] . "/home.php");
                exit();
            }

        }
        $this->admin_title = $this->settings["admin_title"];


    }//Constructor MAIN

    public function set_title($title)
    {

        $this->admin_title .= $title;

    }

    public function check_persistent_logins()
    {
        if ($_SESSION["failed_login_attempt"] > 4) {
            if ((time() - $_SESSION["failed_login_attempt_last_time"]) < 300) {
                return 1;//block
            } else {
                $_SESSION["failed_login_attempt"] = 0;
                return 0;//allow
            }
        }//check if more than 5
    }

    public function check_ip_location()
    {
        global $main;
        $ip = $_SERVER['REMOTE_ADDR'];
        //$ip = "5.206.232.50";
        $row_serial = "";
        //retrieve ip from db if already exists.
        $sql = "SELECT *,timestampdiff(DAY, ipl_last_check, now())as clo_days_diff FROM ip_locations WHERE ipl_ip = '" . $ip . "'";
        $data = $this->query_fetch($sql);
        $country = $data["ipl_country"];
        //if already exists check when was last checked.
        //if more than 15 days then send for update check again.
        if ($data["ipl_ip_location_serial"] > 0) {
            if ($data["clo_days_diff"] >= 15) {
                $retrive_data = 1;
                $row_serial = $data["ipl_ip_location_serial"];
            } else {
                $retrive_data = 0;
                $row_serial = $data["ipl_ip_location_serial"];
            }
        } else {
            $retrive_data = 1;
        }
        //if ($ip == '81.4.137.26') {
        //echo "https://ipinfo.io/{$ip}/json";
        //$details = json_decode(file_get_contents("https://ipinfo.io/{$ip}/json"));
        //echo $details;
        //exit();
        //}
        if ($retrive_data == 1) {
            @$details = json_decode(file_get_contents("https://ipinfo.io/{$ip}/json"));
            //if ($ip == '81.4.137.26') {echo $details;}
            $field_data["fld_ipl_ip"] = $ip;
            $field_data["fld_ipl_hostname"] = $details->hostname;
            $field_data["fld_ipl_city"] = $details->city;
            $field_data["fld_ipl_region"] = $details->region;
            $field_data["fld_ipl_country"] = $details->country;
            $field_data["fld_ipl_location"] = $details->loc;
            $field_data["fld_ipl_provider"] = $details->org;
            $field_data["fld_ipl_last_check"] = date("Y-m-d G:i:s");
            $country = $details->country;

            if ($row_serial == "") {
                $this->db_tool_insert_row("ip_locations", $field_data, "fld_");
            } else {
                $this->db_tool_update_row("ip_locations", $field_data, "ipl_ip_location_serial = " . $row_serial, $row_serial, "fld_");
            }
        }

        //check if the country is in the blocked list from common variables
        $country .= ",";
        if (strpos($main["block_countries_from_ip"], $country) !== false && $country != 0) {
            //echo "Blocked<br>";
            //echo $main["block_countries_from_ip"]."<br>".$country;
            header("Location:" . $main["block_countries_redirect_page"]);
            exit();
        }
    }

    public function setDebugMode()
    {
        $this->debugMode = true;
    }

    public function check_login()
    {
        global $main;

        if ($_SESSION[$main["environment"] . "_admin_username"] == "" || $this->check_persistent_logins() == 1) {
            //Keep the requested url
            $_SESSION["prev_url"] = $_SERVER["SCRIPT_URI"] . "?" . $_SERVER["QUERY_STRING"];
            header("Location: " . $this->settings["site_url"] . "/" . $main["login_page_filename"] . "?error=Enter Username/Password!&action=logout");
            exit();
        } else {
            $sql = "SELECT * FROM `users` 
		JOIN `users_groups`  ON `usg_users_groups_ID` = `usr_users_groups_ID` 
		WHERE `usr_active` = 1 AND `usr_user_rights` != 9 
		AND `usr_password` = '" . addslashes($_SESSION[$main["environment"] . "_admin_password"]) . "' 
		AND `usr_username` = '" . addslashes($_SESSION[$main["environment"] . "_admin_username"]) . "'";
            $result = $this->query($sql);

            //Keep the requested url
            $_SESSION["prev_url"] = $_SERVER["SCRIPT_URI"] . "?" . $_SERVER["QUERY_STRING"];

            //check if no users has been returned
            if ($this->num_rows($result) < 1) {
                //check login attempts.
                $_SESSION["failed_login_attempt"]++;
                $_SESSION["failed_login_attempt_last_time"] = date("d-m-Y G:i:s");

                header("Location:" . $this->settings["site_url"] . "/login.php?error=User not found.Please login.&action=logout");
                exit();
            }
            //check if the user has the appropriate persmission.

            //get the data of the user
            $this->user_data = $this->fetch_assoc($result);

            //if imitate user keep the admin login into the originalUserData
            if ($this->dbSettings['admin_imitate_user']['value'] != 'No' && $this->user_data['usr_user_rights'] == 0) {
                $this->imitationMode = true;
                $this->originalUserData = $this->user_data;
                $this->user_data = $this->query_fetch('SELECT * FROM users WHERE usr_users_ID = ' . $this->dbSettings['admin_imitate_user']['value']);
            }

            //verify the users ip
            if ($this->get_setting("admin_check_users_ip") == 1) {

                //if the restrict ip of the user is empty then use the restrict ip of the group
                if ($this->user_data["usr_restrict_ip"] == "") {
                    $restrict_ip_data = $this->user_data["usg_restrict_ip"];
                } else {
                    $restrict_ip_data = $this->user_data["usr_restrict_ip"];
                }
                //get all ip`s
                $allips = explode(",", $restrict_ip_data);
                //initialize
                $ip_all_allowed = 0;
                $ip_allowed = 0;
                $ip_block = 0;
                foreach ($allips as $value) {

                    if ($value == '%') {
                        $ip_all_allowed = 1;
                    }
                    if ($value == $_SERVER['REMOTE_ADDR']) {
                        $ip_allowed = 1;
                    }
                    if ($value == "!" . $_SERVER['REMOTE_ADDR'] || $value == '!%') {
                        $ip_block = 1;
                    }
                    //check for ?? if range exists
                    $ippos = strpos($value, '?');
                    if ($ippos !== false) {

                        //check if ! exists at begining
                        if (substr($value, 0, 1) == '!') {
                            $value = substr($value, 1);
                            $ip_section = 'block';
                        }//if ! exists
                        else {
                            $ip_section = 'allow';
                        }

                        $ip_length = strlen($_SERVER['REMOTE_ADDR']);
                        $ip_error = 0;
                        for ($i = 0; $i < $ip_length; $i++) {

                            if (substr($value, $i, 1) == '?') {

                            }//if ?
                            else if (substr($value, $i, 1) == substr($_SERVER['REMOTE_ADDR'], $i, 1)) {

                            }//if match
                            else {
                                $ip_error++;
                            }//if error

                        }//for all chars in ip

                        //result outcome
                        //if to allow the ip and the ip match the allow
                        if ($ip_section == 'allow' && $ip_error == 0) {
                            //allow
                            $ip_allowed = 1;
                        }//if allow
                        //if to block the ip and ip match then block
                        if ($ip_section == 'block' && $ip_error == 0) {
                            $ip_block = 1;
                        }//if block

                    }//if check range IP with ??? wildcards

                }//for each all ips in users account


                if ($ip_block == 1) {
                    //check login attempts.
                    $_SESSION["failed_login_attempt"]++;
                    $_SESSION["failed_login_attempt_last_time"] = date("d-m-Y G:i:s");
                    header("Location: " . $this->settings["site_url"] . "/login.php?error=IP Blocked&action=logout");
                    exit();
                }

                if ($ip_allowed == 1 || $ip_all_allowed == 1) {
                    //do nothing and allow the user to proceed
                } else {
                    //check login attempts.
                    $_SESSION["failed_login_attempt"]++;
                    $_SESSION["failed_login_attempt_last_time"] = date("d-m-Y G:i:s");
                    header("Location: " . $this->settings["site_url"] . "/login.php?error=IP not found&action=logout");
                    exit();
                }
                //echo $_SERVER['REMOTE_ADDR'];
            }//if to check the users ip


            //first check for the menu if able to view the file.
            //get the menu details
            $sql = "SELECT  IF( us.usr_user_rights =0 OR COUNT(per.prm_permissions_ID) = 0,1, pel.prl_view) as view
					FROM `permissions` as per
					LEFT OUTER JOIN `permissions_lines` as `pel` ON pel.prl_permissions_ID = per.prm_permissions_ID
					LEFT OUTER JOIN `users_groups` as usg ON usg.usg_users_groups_ID = pel.prl_users_groups_ID
					LEFT OUTER JOIN `users` as us ON us.usr_users_groups_ID = usg.usg_users_groups_ID
					WHERE 
					`prm_filename` = '" . substr($_SERVER['PHP_SELF'], strlen($this->settings["remote_folder"]) + 1) . "' 
					AND `prm_type` = 'menu' 
					AND us.usr_users_ID = " . $this->user_data["usr_users_ID"];
            $menu_result = $this->query_fetch($sql);
            //get the file details.
            $sql = "SELECT  IF( us.usr_user_rights =0 OR COUNT(per.prm_permissions_ID) = 0,1, pel.prl_view) as view
					FROM `permissions` as per
					LEFT OUTER JOIN `permissions_lines` as `pel` ON pel.prl_permissions_ID = per.prm_permissions_ID
					LEFT OUTER JOIN `users_groups` as usg ON usg.usg_users_groups_ID = pel.prl_users_groups_ID
					LEFT OUTER JOIN `users` as us ON us.usr_users_groups_ID = usg.usg_users_groups_ID
					WHERE 
					`prm_filename` = '" . substr($_SERVER['PHP_SELF'], strlen($this->settings["remote_folder"]) + 1) . "' 
					AND `prm_type` = 'file' 
					AND us.usr_users_ID = " . $this->user_data["usr_users_ID"];

            $file_result = $this->query_fetch($sql);

            //get the folder details.
            //get the currenct folder
            $folder = substr($_SERVER['PHP_SELF'], strlen($this->settings["remote_folder"]) + 1);
//echo $folder." - ".$this->settings['remote_folder']."<br>";

            $pos = strripos($folder, '/');
            //$folder = substr($folder, 0, $pos + 1);
            $folder = substr($folder, 0, $pos);
//echo $folder."<br>";
            $sql = "SELECT  IF( us.usr_user_rights =0 OR COUNT(per.prm_permissions_ID) = 0,1, pel.prl_view) as view
					FROM `permissions` as per
					LEFT OUTER JOIN `permissions_lines` as `pel` ON pel.prl_permissions_ID = per.prm_permissions_ID
					LEFT OUTER JOIN `users_groups` as usg ON usg.usg_users_groups_ID = pel.prl_users_groups_ID
					LEFT OUTER JOIN `users` as us ON us.usr_users_groups_ID = usg.usg_users_groups_ID
					WHERE 
					`prm_filename` = '" . $folder . "' 
					AND `prm_type` = 'folder' 
					AND us.usr_users_ID = " . $this->user_data["usr_users_ID"];
            $folder_result = $this->query_fetch($sql);

//echo $sql;

            if ($menu_result["view"] == 0) {
                header("Location: " . $this->settings["site_url"] . "/home.php");
                exit();
            }//if from menu is allowed do nothing

            if ($file_result["view"] == 0) {
                header("Location: " . $this->settings["site_url"] . "/home.php");
                exit();
            }//if from file is allowed do nothing

            if ($folder_result["view"] == 0) {
                header("Location: " . $this->settings["site_url"] . "/home.php");
                exit();
            }//if from folder is allowed do nothing


        }//else
        $this->adminLogin = true;
    }

    private function getAllStartUpSettings()
    {
        $result = $this->query('SELECT * FROM settings WHERE stg_fetch_on_startup = 1');
        while ($row = $this->fetch_assoc($result)) {
            $this->dbSettings[$row['stg_section']]['value'] = $row['stg_value'];
            $this->dbSettings[$row['stg_section']]['date'] = $row['stg_value_date'];
            $this->dbSettings[$row['stg_section']]['fetch_on_startup'] = $row['stg_fetch_on_startup'];
        }
    }

//area can be view , update , insert , delete , extra_1 , extra_2 , extra_3 , extra_4 , extra_5
//if return result = 0 locks the file. If 1 then returns ONLY the result
    public function check_restriction_area($area, $return_result = 0)
    {
        global $main;
//it checks if the user is allowed in a specific area
//if not allowed then stop the script
        $sql = "SELECT  IF( us.usr_user_rights =0 OR COUNT(per.prm_permissions_ID) = 0,1, pel.prl_" . $area . ") as result
					FROM `permissions` as per
					LEFT OUTER JOIN `permissions_lines` as `pel` ON pel.prl_permissions_ID = per.prm_permissions_ID
					LEFT OUTER JOIN `users_groups` as usg ON usg.usg_users_groups_ID = pel.prl_users_groups_ID
					LEFT OUTER JOIN `users` as us ON us.usr_users_groups_ID = usg.usg_users_groups_ID
					WHERE 
					`prm_filename` = '" . substr($_SERVER['PHP_SELF'], strlen($this->settings["remote_folder"]) + 1) . "' 
					AND `prm_type` = 'file' 
					AND us.usr_users_ID = " . $this->user_data["usr_users_ID"];
//echo $sql."<br><br>\n\n";

        $resultFile = $this->query_fetch($sql);


        $folder = substr($_SERVER['PHP_SELF'], strlen($this->settings["remote_folder"]) + 1);
        $pos = strripos($folder, '/');
        $folder = substr($folder, 0, $pos);
        $sqlFolder = "SELECT  IF( us.usr_user_rights =0 OR COUNT(per.prm_permissions_ID) = 0,1,  pel.prl_" . $area . ") as result
					FROM `permissions` as per
					LEFT OUTER JOIN `permissions_lines` as `pel` ON pel.prl_permissions_ID = per.prm_permissions_ID
					LEFT OUTER JOIN `users_groups` as usg ON usg.usg_users_groups_ID = pel.prl_users_groups_ID
					LEFT OUTER JOIN `users` as us ON us.usr_users_groups_ID = usg.usg_users_groups_ID
					WHERE 
					`prm_filename` = '" . $folder . "' 
					AND `prm_type` = 'folder' 
					AND us.usr_users_ID = " . $this->user_data["usr_users_ID"];
//echo $sqlFolder."<br><br>\n\n";

        $resultFolder = $this->query_fetch($sqlFolder);

        //first check the file
        if ($return_result == 1) {
            return $resultFile["result"];
        }

        if ($resultFile["result"] != 1) {
            $this->generateSessionAlert('PERMISSION DENIED (F)');
            header("Location: " . $this->settings["site_url"] . "/home.php");
            exit();
            //$this->error("PERMISSION DENIED");
        }

        //check the folder
        if ($return_result == 1) {
            return $resultFolder["result"];
        }

        if ($resultFolder["result"] != 1) {
            $this->generateSessionDismissError('PERMISSION DENIED (D)');
            header("Location: " . $this->settings["site_url"] . "/home.php");
            exit();
            //$this->error("PERMISSION DENIED");
        }

    }//public function check_restriction_area

    public function check_file_permissions($file)
    {
        $sql = "SELECT  IF( us.usr_user_rights =0 OR COUNT(per.prm_permissions_ID) = 0,1, pel.prl_view) as result
					FROM `permissions` as per
					LEFT OUTER JOIN `permissions_lines` as `pel` ON pel.prl_permissions_ID = per.prm_permissions_ID
					LEFT OUTER JOIN `users_groups` as usg ON usg.usg_users_groups_ID = pel.prl_users_groups_ID
					LEFT OUTER JOIN `users` as us ON us.usr_users_groups_ID = usg.usg_users_groups_ID
					WHERE 
					`prm_filename` = '" . $file . "' 
					AND `prm_type` = 'file' 
					AND us.usr_users_ID = " . $this->user_data["usr_users_ID"];
        $result = $this->query_fetch($sql);
        if ($result["result"] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_fix_permissions_lines()
    {
        //first get all the permissions.

        //loop in all the groups to check if every permission exists for each group.

    }

    public function query($sql, $info = 'No information defined for this query')
    {
        $more_info = '';

//CHECK IF SPECIFIC QUERIES ARE DISABLED
//find what kind of query is
        $type = substr($sql, 0, strpos($sql, ' '));
//now in each case check if each command is allowed
        if ($type == '<strong>SELECT' && $this->allow_query_select != 1) {
            echo "\n\nSELECT Query Disabled \n<br>----------------------------</strong>\n<br>" . $sql . "\n<hr>";
            return false;
        }
        if ($type == '<strong>UPDATE' && $this->allow_query_update != 1) {
            echo "\n\nUPDATE Query Disabled \n<br>----------------------------</strong>\n<br>" . $sql . "\n<hr>";
            return false;
        }
        if ($type == '<strong>DELETE' && $this->allow_query_delete != 1) {
            echo "\n\nDELETE Query Disabled \n<br>----------------------------</strong>\n<br>" . $sql . "\n<hr>";
            return false;
        }
        if ($type == '<strong>INSERT' && $this->allow_query_insert != 1) {
            echo "\n\nInsert Query Disabled \n<br>----------------------------</strong>\n<br>" . $sql . "\n<hr>";
            return false;
        }

        if ($this->system_on_test == 'yes') {
            //check if the query is a select query
            if (substr($sql, 0, 6) == 'SELECT') {
                $result = mysqli_query($this->db_handle, $sql) or die($this->error($sql . "<hr>" . $this->db_handle->error));
                $more_info = '<strong>#Executed[SQL]</strong>';
                $this->all_query_results[$this->db_total_queries]["result"] = $result;
                $this->all_query_results[$this->db_total_queries]["info"] = $info;
                $this->db_total_queries++;
            } else {
                $more_info = '<strong>#Suspended</strong>';
            }
            echo "<strong>INFO:</strong> " . $info . "<br>" . $sql . '&nbsp;&nbsp;' . $more_info . "<HR>";
            $this->db_all_queries .= $sql . '&nbsp;&nbsp;' . $more_info . "<HR>";
        } else {
            $result = mysqli_query($this->db_handle, $sql)
            or die(
            $this->error($sql . "<hr>" . $this->db_handle->error)
            );
            if ($this->db_handle->errno != 0) {
                $this->error($sql . "<hr>" . $this->db_handle->error);

            }

            if (substr($sql, 0, 6) == 'SELECT') {
                $this->all_query_results[$this->db_total_queries]["result"] = $result;
                $this->all_query_results[$this->db_total_queries]["info"] = $info;
                $this->db_total_queries++;
            }

            //if debug mode echo the sql
            if ($this->debugMode == true) {
                echo $sql . "\n<br>";
            }

        }
        return $result;

    }

    public function start_transaction()
    {
        $this->started_transaction = 1;
        $this->query("START TRANSACTION;");
    }

    public function commit_transaction()
    {
        $this->query("COMMIT;");
    }

    public function rollback_transaction()
    {
        $this->query("ROLLBACK;");
    }

    public function throwException($exception)
    {
        //first rollback
        $this->rollback_transaction();
        //add error in db
        $this->update_log_file('error', 0, $this->admin_title, '', '', $exception);
    }

    public function update_table_data($table, $prefix, $action, $update_sql = '')
    {

        if ($action == 'insert') {
            $sql = "INSERT INTO `" . $table . "` SET ";
        } else if ($action == 'update') {
            $sql = "UPDATE `" . $table . "` SET ";
            $sql3 = " WHERE " . $update_sql;
        }

        $i = 0;
        foreach ($_POST as $name => $value) {

            //first check if to catch the var

            if (substr($name, 0, strlen($prefix)) == $prefix) {

                $field = substr($name, strlen($prefix));
                if ($i > 0)
                    $sql2 .= ", ";

                $sql2 .= "`" . $field . "` = '" . addslashes($value) . "'";

                $i++;
            }//if field is valid

        }//foreach post values

        $this->query($sql . $sql2 . $sql3);

    }//function update table_data

    public function fetch_assoc($result)
    {


        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        } else {
            //echo "Found problemss. ";
            return null;
        }

    }

    public function fetch_array($result)
    {


        if ($row = mysqli_fetch_array($result)) {
            return $row;
        } else {
            //echo "Found problemss. ";
            return null;
        }

    }

    public function query_fetch($sql, $info = 'No information defined for this query')
    {
        $row = mysqli_fetch_assoc($this->query($sql, $info));
        return $row;
    }

    public function num_rows($result)
    {


        if ($row = mysqli_num_rows($result))
            return $row;

    }

    public function getNextID($table)
    {
        $sql = 'SELECT Auto_increment FROM information_schema.tables WHERE table_name="' . $table . '"';
        $result = $this->query_fetch($sql);
        $return = $result['Auto_increment'];
        return $return;
    }

    public function insert_id()
    {
        return mysqli_insert_id($this->db_handle);
    }

    public function error($string)
    {
        //if transaction is started then need to rollback
        if ($this->started_transaction == 1) {
            $this->rollback_transaction();
            $this->issued_rollback = 1;
        }

        $this->update_log_file('Error', 0, $this->admin_title . ' Section:' . $this->working_section,
            'User[ID]:' . $this->user_data['usr_name'] . '[' . $this->user_data['usr_users_ID'] . ']',
            '$_GET->' . print_r($_GET, true) . '\n$_POST->' . print_r($_POST, true), $string);


        if ($this->user_data["usr_user_rights"] == 0) {
            //$this->show_header();
            echo $string . " ERROR <br><a href=\"#\" onclick=\"history.go(-1);\">Back</a>";
            //$this->show_footer();
            $this->main_exit();
            exit();
        } else {
            $this->show_header();
            echo "Error has been found. Please contact the system administrator. <br><a href=\"#\" onclick=\"history.go(-1);\">Back</a>";
            $this->show_footer();
            exit();
        }
        exit();

    }

    public function free_result($result)
    {

        mysqli_free_result($result);

    }

    public function get_setting($section, $field = 'value')
    {

        $sql = "SELECT * FROM `settings` WHERE `stg_section` = '" . $section . "'";
        $result = $this->query($sql);
        $row = $this->fetch_assoc($result);
        if ($field == 'value') {
            return $row["stg_value"];
        } else if ($field == 'value_date') {
            return $row["stg_value_date"];
        } else if ($field == 'startup') {
            return $row["stg_fetch_on_startup"];
        }
    }

    public function update_setting($section, $newValue = '', $startup = 0)
    {
        $newData['value'] = $newValue;
        $newData['section'] = $section;
        $newData['fetch_on_startup'] = $this->get_check_value($startup);
        $this->db_tool_update_row('settings', $newData, "stg_section = '" . $section . "'", ''
            , '', 'execute', 'stg_');
        //$this->db_tool_insert_update_row('settings', $newData, "stg_section = '" . $section . "'", '', '', 'stg_');
    }

    function process_lock_validate($name, $description)
    {
        $status = $this->process_lock('check', $name);
        if ($status['check'] == 'not_found') {
            //create it
            $this->process_lock('create', $name, $description);
            return true;
        } else {

            return false;

        }
    }

//type -> create , end , check
    function process_lock($type, $name = '', $description = '')
    {

        if ($this->user_data["usr_users_ID"] < 1) {
            $userid = 0;
        } else {
            $userid = $this->user_data["usr_users_ID"];
        }

        //first check if record already exists. needed for all the types
        $sql = "SELECT * FROM process_lock 
	WHERE pl_name = '" . $name . "' 
	AND pl_user_serial = " . $userid . "
	AND pl_active = 1";
        $result = $this->query($sql, 'Get if exists process lock');
        $data = $this->fetch_assoc($result);

        if ($type == 'create') {
            if ($this->num_rows($result) > 0) {
                $ret['error'] = 11;
                $ret['info'] = 'Record already exists.[insert]';
            } else {
                $sql = "INSERT INTO process_lock SET 
			pl_description = '" . $description . "',
			pl_name = '" . $name . "',
			pl_user_serial = " . $userid . ",
			pl_active = 1,
			pl_start_timestamp = '" . date("Y-m-d G:i:s") . "'";
                $this->query($sql);
                $ret['error'] = 0;
                $ret['info'] = 'Entry created. [insert]';
            }
        } else if ($type == 'end') {
            if ($this->num_rows($result) < 1) {
                $ret['error'] = 21;
                $ret['info'] = 'Cannot find record.[end]';
            } else {
                $sql = "UPDATE process_lock SET
			pl_active = 0,
			pl_end_timestamp = '" . date("Y-m-d G:i:s") . "'
			WHERE
			pl_name = '" . $name . "'
			AND pl_active = 1
			AND pl_user_serial = " . $userid;
                $this->query($sql);
                $ret['error'] = 0;
                $ret['info'] = 'Record End.[end]';
            }
        } else if ($type == 'check') {
            if ($this->num_rows($result) < 1) {
                $ret['error'] = 0;
                $ret['info'] = 'Record not found.[check]';
                $ret['check'] = 'not_found';
            } else if ($this->num_rows($result) == 1) {
                $ret['error'] = 0;
                $ret['info'] = 'Record exists.[check]';
                $ret['check'] = 'found';
            } else {
                $ret['error'] = 0;
                $ret['info'] = 'Multiple records found.[check]';
                $ret['check'] = 'many_found';
            }
        } else if ($type == 'clear') {
            $sql = "UPDATE process_lock SET
			pl_active = 0,
			pl_end_timestamp = '" . date("Y-m-d G:i:s") . "'
			WHERE
			pl_active = 1
			AND pl_user_serial = " . $userid;
            $this->query($sql, 'Clear process lock entries');
            $ret['error'] = 0;
            $ret['info'] = 'Cleared.[clear]';
        }

        return $ret;

    }//process_lock

    function get_setting_drop_down($setting_section, $field_name, $selected)
    {

        $return = "<select name=\"" . $field_name . "\" id=\"" . $field_name . "\">
<option value=\"\">NONE</option>";
        $sql = "SELECT * FROM settings WHERE stg_section = '" . $setting_section . "' ORDER BY stg_value ASC";
        $result = $this->query($sql);
        while ($row = $this->fetch_assoc($result)) {

            $return .= "<option value=\"" . $row["stg_settings_serial"] . "\"";
            if ($selected == $row["stg_settings_serial"]) {
                $return .= " selected=\"selected\"";
            }
            $return .= ">" . $row["stg_value"] . "</option>\n";

        }
        $return .= "</select>";
        return $return;
    }

    public function include_js_file($file_location)
    {
        $this->admin_more_head .= "<script language=\"JavaScript\" type=\"text/javascript\" src=\"" . $file_location . "\"></script>\n";
    }

    public function include_css_file($file_location, $extraHtml = '')
    {
        $this->admin_more_head .= "<link href=\"" . $file_location . "\" rel=\"stylesheet\" type=\"text/css\" " . $extraHtml . "/>\n";
    }

    public function enable_jquery()
    {

        //$this->include_js_file($this->settings["site_url"] . "/node_modules/jquery-slim/dist/jquery.slim.js");
        $this->enabled_jquery = 'yes';
    }

    public function enable_jquery_ui($css = '')
    {

        if ($this->enabled_jquery != 'yes') {
            $this->enable_jquery();
        }

        $this->include_js_file($this->settings["site_url"] . "/scripts/jquery-ui-1.12.1/jquery-ui.js");
        $this->enabled_jquery_ui = 'yes';

        $this->include_css_file($this->settings["site_url"] . "/scripts/jquery-ui-1.12.1/jquery-ui.theme.css");

    }

    public function enable_jquery_ui_dateTimePicker()
    {
        if ($this->enabled_jquery_ui != 'yes') {
            $this->enable_jquery_ui();
        }
        $this->include_js_file($this->settings["site_url"] . "/scripts/jquery-ui-timepicker-addon.min.js");
        $this->include_css_file($this->settings["site_url"] . "/scripts/jquery-ui-timepicker-addon.css");
    }

    public function enable_jquery_tools()
    {

        $this->include_js_file($this->settings["site_url"] . "/scripts/jquery/jquery.tools.min.js");
    }

    public function enable_jquery_bubble()
    {

        $this->include_js_file($this->settings["site_url"] . "/scripts/jquery_bubble_popup/scripts/jquery-bubble-popup-v3.min.js");
        $this->include_css_file($this->settings["site_url"] . "/scripts/jquery_bubble_popup/css/jquery-bubble-popup-v3.css");

    }

    public function enable_jquery_time_picker()
    {
        if ($this->enabled_jquery != 'yes') {
            $this->enable_jquery();
        }
        $this->include_js_file($this->settings["site_url"] . "/scripts/jquery/jquery.timePicker.js");
    }

    public function enable_tiny_wysiwyg()
    {

        if ($this->enabled_jquery != 'yes') {
            $this->enable_jquery();
        }
        $this->include_js_file($this->settings["site_url"] . "/scripts/tiny_mce_wysiwyg/tinymce.min.js");
    }

    public function enable_rxjs_lite()
    {

        if ($this->enabled_rxjs_lite != 'yes') {
            if ($this->enabled_jquery != 'yes') {
                //$this->enable_jquery();
            }
            $this->include_js_file($this->settings["site_url"] . "/node_modules/rx-lite/rx.lite.js");
            $this->enabled_rxjs_lite = 'yes';
        }

    }

    public function show_header()
    {
        global $main, $db;
        //include($this->settings["local_url"]."/layout/".$this->get_setting("admin_default_layout")."/template.php");
        include($this->settings["local_url"] . "/layout/" . $this->get_setting("admin_default_layout") . "/template.php");
        template_header();
    }

    public function show_empty_header()
    {
        $this->admin_layout_printer = 'yes';
        $this->show_header();
    }

    public function show_footer()
    {
        global $main, $db;
        //include($this->settings["local_url"]."/layout/".$this->get_setting("admin_default_layout")."/footer.php");
        template_footer();
    }

    public function show_empty_footer()
    {
        $this->admin_layout_printer = 'yes';
        $this->show_footer();
    }

    public function generateDismissWarning($message)
    {
        $this->dismissWarning = $message;
    }

    public function generateDismissError($message)
    {
        $this->dismissError = $message;
    }

    public function generateDismissSuccess($message)
    {
        $this->dismissSuccess = $message;
    }

    public function generateDismissInfo($message)
    {
        $this->dismissInfo = $message;
    }

    public function generateAlertWarning($message)
    {
        $this->alertWarning = $message;
    }

    public function generateAlertError($message)
    {
        $this->alertError = $message;
    }

    public function generateAlertSuccess($message)
    {
        $this->alertSuccess = $message;
    }

    public function generateAlertInfo($message)
    {
        $this->alertInfo = $message;
    }

    public function generateSessionDismissWarning($message)
    {
        $_SESSION['SessionDismissWarning'] = $message;
    }

    public function generateSessionDismissError($message)
    {
        $_SESSION['SessionDismissError'] = $message;
    }

    public function generateSessionDismissSuccess($message)
    {
        $_SESSION['SessionDismissSuccess'] = $message;
    }

    public function generateSessionDismissInfo($message)
    {
        $_SESSION['SessionDismissInfo'] = $message;
    }

    public function generateSessionAlertWarning($message)
    {
        $_SESSION['SessionAlertWarning'] = $message;
    }

    public function generateSessionAlertError($message)
    {
        $_SESSION['SessionAlertError'] = $message;
    }

    public function generateSessionAlertSuccess($message)
    {
        $_SESSION['SessionAlertSuccess'] = $message;
    }

    public function generateSessionAlertInfo($message)
    {
        $_SESSION['SessionAlertInfo'] = $message;
    }

    private function generateSessionDismiss()
    {

        if ($_SESSION['SessionDismissWarning'] != '') {
            $this->generateDismissWarning($_SESSION['SessionDismissWarning']);
            $_SESSION['SessionDismissWarning'] = '';
            unset($_SESSION['SessionDismissWarning']);
        } else if ($_SESSION['SessionDismissError'] != '') {
            $this->generateDismissError($_SESSION['SessionDismissError']);
            $_SESSION['SessionDismissError'] = '';
            unset($_SESSION['SessionDismissError']);
        } else if ($_SESSION['SessionDismissSuccess'] != '') {
            $this->generateDismissSuccess($_SESSION['SessionDismissSuccess']);
            $_SESSION['SessionDismissSuccess'] = '';
            unset($_SESSION['SessionDismissSuccess']);
        } else if ($_SESSION['SessionDismissInfo'] != '') {
            $this->generateDismissInfo($_SESSION['SessionDismissInfo']);
            $_SESSION['SessionDismissInfo'] = '';
            unset($_SESSION['SessionDismissInfo']);
        }
    }

    private function generateSessionAlert()
    {

        if ($_SESSION['SessionAlertWarning'] != '') {
            $this->generateAlertWarning($_SESSION['SessionAlertWarning']);
            $_SESSION['SessionAlertWarning'] = '';
            unset($_SESSION['SessionAlertWarning']);
        } else if ($_SESSION['SessionAlertError'] != '') {
            $this->generateAlertError($_SESSION['SessionAlertError']);
            $_SESSION['SessionAlertError'] = '';
            unset($_SESSION['SessionAlertError']);
        } else if ($_SESSION['SessionAlertSuccess'] != '') {
            $this->generateAlertSuccess($_SESSION['SessionAlertSuccess']);
            $_SESSION['SessionAlertSuccess'] = '';
            unset($_SESSION['SessionAlertSuccess']);
        } else if ($_SESSION['SessionAlertInfo'] != '') {
            $this->generateAlertInfo($_SESSION['SessionAlertInfo']);
            $_SESSION['SessionAlertInfo'] = '';
            unset($_SESSION['SessionAlertInfo']);
        }
    }

    public function fix_num($digit, $type = 'remove')
    {

        if ($type == 'remove') {
            $num = strlen($digit);

            for ($i = 0; $i <= $num; $i++) {

                $one = substr($digit, $i, 1);

                if ($one == ",") {

                } else if ($one == ".") {
                    $found = "1";
                } else {
                    if ($found != 1) {
                        $out .= $one;
                    }
                }

            }

            return $out;
        }//remove
        else {

            return number_format($digit, 2, ".", ",");

        }

    }

    function date_difference($d1, $d2)
    {
        $d1 = (is_string($d1) ? strtotime($d1) : $d1);
        $d2 = (is_string($d2) ? strtotime($d2) : $d2);
        $diff_secs = abs($d1 - $d2);
        $base_year = min(date("Y", $d1), date("Y", $d2));
        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
        return array(
            "years" => date("Y", $diff) - $base_year,
            "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
            "months" => date("n", $diff) - 1,
            "days_total" => floor($diff_secs / (3600 * 24)),
            "days" => date("j", $diff) - 1,
            "hours_total" => floor($diff_secs / 3600),
            "hours" => date("G", $diff),
            "minutes_total" => floor($diff_secs / 60),
            "minutes" => (int)date("i", $diff),
            "seconds_total" => $diff_secs,
            "seconds" => (int)date("s", $diff)
        );
    }//date_difference

    function get_check_value($check)
    {
        if ($check == 1)
            return 1;
        else
            return 0;
    }//get_check_value

    function get_check_value_specified($check, $yes, $no, $yes_label = '', $no_label = '')
    {
        if ($check == $yes)
            if ($yes_label == '') {
                return $yes;
            } else {
                return $yes_label;
            }
        else
            if ($no_label == '') {
                return $no;
            } else {
                return $no_label;
            }

    }//get_check_value


    function sendMailTo($from, $from_subject, $to, $subject, $message, $cc = "", $bcc = "")
    {

// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        $all = explode(",", $to);
// Additional headers
        if (count($all) > 1) {
            $headers .= "'To: ";
            for ($i = 0; $i < count($all); $i++) {
                if ($i != 0)
                    $headers .= ",";
                $headers .= "<" . $all[$i] . ">";
            }
            $headers .= "\r\n";
        } else {
            $headers .= 'To: <' . $to . '>' . "\r\n";
        }

        $headers .= 'From: ' . $from_subject . ' <' . $from . '>' . "\r\n";

        if ($cc != "")
            $headers .= 'Cc: ' . $cc . "\r\n";
        if ($bcc != "")
            $headers .= 'Bcc: ' . $bcc . "\r\n";

        // Mail it
        return mail($to, $subject, $message, $headers);
    }//sendMailTo

    public function main_exit()
    {

        //check if transaction is started and no rollback is issued.
        if ($this->issued_rollback == 0 && $this->started_transaction == 1) {
            $this->commit_transaction();
        }

        //clear all process locks that are created
        if ($this->user_data['usr_users_ID'] > 0) {
            $this->process_lock('clear');
        }

        //free all the quries executed by the super class
        for ($i = 0; $i < $this->db_total_queries; $i++) {
            //$this->admin_echo($this->all_query_results[$i]["result"]);
            mysqli_free_result($this->all_query_results[$i]["result"]);
        }
        if ($this->system_on_test == 'yes') {
            echo "<BR><BR>##QUERIES LIST##<BR><HR>";
            echo $this->db_all_queries;
            echo "<BR><BR><HR>##END OF QUERIES LIST##<BR><HR>";
        }
    }

//debug functions. This are functions to be executed only for testing. When $this->system_on_test == 'yes'
    public function deb_echo($var)
    {
        if ($this->system_on_test == 'yes')
            echo $var;
    }

    public function fix_int_to_double($num, $decimals = 2, $comma_separated = 1)
    {
        //return sprintf("%01.".$decimals."f", $num);
        if ($comma_separated == 1) {
            $num = number_format($num, $decimals, '.', ',');
        } else {
            $num = number_format($num, $decimals, '.', '');
        }
        return $num;
    }
//DATABASE TOOLS//===================//DATABASE TOOLS//===================//DATABASE TOOLS//===================//DATABASE TOOLS//===================//DATABASE TOOLS//===================//DATABASE TOOLS//===================
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function db_tool_insert_row($table, $data_array, $data_prefix = 'fld_', $return_serial = 0, $fields_prefix = '', $return_or_execute = 'execute')
    {
        $log_new_values = '';
//start the SQL
        $sql = "INSERT INTO `" . $table . "` SET \n";
        //LOOP in all the array
        $i = 0;
        foreach ($data_array as $name => $value) {

            //first check if the name of the field matches with the prefix
            if (substr($name, 0, strlen($data_prefix)) == $data_prefix) {
                $i++;
                if ($i != 1)
                    $sql .= " , ";
                $fixed_name = substr($name, strlen($data_prefix));

                if ($fields_prefix != '') {
                    $fixed_name = $fields_prefix . $fixed_name;
                }

                $sql .= "`" . $fixed_name . "` = '" . addslashes($value) . "' \n";
                $log_new_values .= $fixed_name . " = " . addslashes($value) . " 
";


            }//if the name of the field matches with the prefix

        }

        //if no one is logged in then use 0
        if ($this->user_data['usr_users_ID'] == '') {
            $this->user_data['usr_users_ID'] = 0;
        }

        //insert dates fields auto
        //check if the fields exists in the db
        $sqlColumns = 'SHOW COLUMNS FROM ' . $table;
        $columnsResult = $this->query($sqlColumns);
        while ($column = $this->fetch_assoc($columnsResult)) {
            if ($column['Field'] == $fields_prefix . 'created_date_time') {
                $sql .= " , `" . $fields_prefix . 'created_date_time' . '`' . " = '" . date('Y-m-d G:i:s') . "' \n";
                $log_new_values .= "`" . $fields_prefix . 'created_date_time' . '`' . " = '" . date('Y-m-d G:i:s') . "'\n";
            }
            if ($column['Field'] == $fields_prefix . 'created_by') {
                $sql .= " , `" . $fields_prefix . 'created_by' . '`' . " = '" . $this->user_data['usr_users_ID'] . "' \n";
                $log_new_values .= "`" . $fields_prefix . 'created_by' . '`' . " = '" . $this->user_data['usr_users_ID'] . "'\n";
            }
        }
        if ($return_or_execute == 'execute') {
            $this->query($sql);
            $new_serial = $this->insert_id();
            //here update the log file.
            $this->update_log_file($table, $new_serial, 'INSERT RECORD', $log_new_values, '', $sql);

            if ($return_serial == 1) {
                return $new_serial;
            }
        } else {
            return $sql;
        }


    }//function db_tool_insert_row


    /**
     * @param $table
     * @param $data_array
     * @param $where_clause
     * @param $row_serial
     * @param string $data_prefix
     * @param string $return_or_execute
     * @param string $fields_prefix
     * @return string
     */
    function db_tool_update_row($table, $data_array, $where_clause, $row_serial, $data_prefix = 'fld_', $return_or_execute = 'execute', $fields_prefix = '')
    {
        //echo "UPDATING<br>\n";
        $log_new_values = '';
        $log_old_values = '';
//get the previous values
        $previous = $this->query_fetch("SELECT * FROM `" . $table . "` WHERE " . $where_clause);

//start the SQL
        $sql = "UPDATE `" . $table . "` SET \n";
        $log_entry = 'UPDATE Row At Table `' . $table . "`\n";
        $found_change = 0;

        //LOOP in all the array
        foreach ($data_array as $name => $value) {

            //first check if the name of the field matches with the prefix
            if (substr($name, 0, strlen($data_prefix)) == $data_prefix) {

                $fixed_name = substr($name, strlen($data_prefix));
                if ($fields_prefix != '') {
                    $fixed_name = $fields_prefix . $fixed_name;
                }
                //echo $name." -> ".$value." -> ".$previous[$fixed_name]." [".$fixed_name."]<br>";
                //check if any change from the previous value;
                if ($value !== $previous[$fixed_name]) {

                    if ($found_change != 0)
                        $sql .= ', ';

                    $sql .= "`" . $fixed_name . "` = '" . addslashes($value) . "' \n";
                    $found_change = 1;

                    //log file
                    $log_new_values .= $fixed_name . " = '" . addslashes($value) . "'
";
                    $log_old_values .= $fixed_name . " = '" . $previous[$fixed_name] . "'
";
                }


            }//if the name of the field matches with the prefix

        }

        //insert dates fields auto
        //check if the fields exists in the db

        //if no one is logged in then use 0
        if ($this->user_data['usr_users_ID'] == '') {
            $this->user_data['usr_users_ID'] = 0;
        }

        if ($found_change == 1) {
            foreach ($previous as $name => $value) {

                //echo $name . "-" . $value . "<br>";

                if ($name == $fields_prefix . 'created_date_time') {
                    $sql .= " , `" . $fields_prefix . 'last_update_date_time' . '`' . " = '" . date('Y-m-d G:i:s') . "' \n";
                    $log_new_values .= "`" . $fields_prefix . 'last_update_date_time' . '`' . " = '" . date('Y-m-d G:i:s') . "'\n";
                    $log_old_values .= "`" . $fields_prefix . 'last_update_date_time' . '`' . " = '" . $previous[$fields_prefix . 'last_update_date_time'] . "'\n";
                }
                if ($name == $fields_prefix . 'created_by') {
                    $sql .= " , `" . $fields_prefix . 'last_update_by' . '`' . " = '" . $this->user_data['usr_users_ID'] . "' \n";
                    $log_new_values .= "`" . $fields_prefix . 'last_update_by' . '`' . " = '" . $this->user_data['usr_users_ID'] . "'\n";
                    $log_old_values .= "`" . $fields_prefix . 'last_update_by' . '`' . " = '" . $previous[$fields_prefix . 'last_update_by'] . "'\n";
                }
            }
        }

        //if nothing found to change
        if ($found_change == 0) {
            //do nonthing
        }//if no changes found
        else {

            $sql .= "WHERE " . $where_clause;
            if ($return_or_execute == 'execute') {
                //echo $sql;
                //echo "executing sql<br>\n";
                $this->query($sql);

                //update the log file.
                $this->update_log_file($table, $row_serial, 'UPDATE RECORD', $log_new_values, $log_old_values, $sql);
            } else if ($return_or_execute == 'only_return') {
                return $sql;
            } else {
                $this->update_log_file($table, $row_serial, 'UPDATE RECORD - NOT EXECUTED', $log_new_values, $log_old_values, $sql);
                return $sql;
            }

        }//if changes found


    }//function db_tool_update_row

//decides whether to insert or update a record.
    function db_tool_insert_update_row($table, $data_array, $where_clause, $serial_field, $data_prefix = 'fld_', $fields_prefix)
    {

//get the previous values
        $previous = $this->query_fetch("SELECT " . $serial_field . " as clo_field_serial FROM `" . $table . "` WHERE " . $where_clause);

        if ($previous["clo_field_serial"] > 0) {
            $this->db_tool_update_row($table, $data_array, $where_clause, $previous["clo_field_serial"], $data_prefix, 'execute', $fields_prefix);
            $return = 'UPDATE';
        } else {
            $this->db_tool_insert_row($table, $data_array, $data_prefix, 0, $fields_prefix);
            $return = 'INSERT';
        }
        return $return;
    }

    function db_tool_delete_row($table, $row_serial, $where_clause)
    {

        //get the previous values
        $previous = $this->query_fetch("SELECT * FROM `" . $table . "` WHERE " . $where_clause);
        $log_old_values = '';

        //continue only if the row exists
        if (isset($previous)) {
            foreach ($previous as $data_names => $data_values) {

                $log_old_values .= $data_names . " = " . $data_values . "
		";

            }
            $sql = "DELETE FROM `" . $table . "` WHERE " . $where_clause . " LIMIT 1";
            //echo $sql;
            $this->query($sql);

            //update the log file
            $this->update_log_file($table, $row_serial, 'DELETE RECORD', '', $log_old_values);
        }
    }

    function update_log_file($table_name, $row_serial, $action, $new_values = '', $old_values = '', $description = '')
    {

        $sql = "INSERT INTO `log_file`
	    SET 
		`lgf_user_ID` = '" . $this->user_data["usr_users_ID"] . "' ,
		`lgf_ip` = '" . $_SERVER['REMOTE_ADDR'] . "',
		`lgf_date_time` = '" . date('Y-m-d H:i:s') . "' ,
		`lgf_table_name` = '" . addslashes($table_name) . "' ,
		`lgf_row_serial` = '" . addslashes($row_serial) . "' ,
		`lgf_action` = '" . addslashes($action) . "' ,
		`lgf_new_values` = \"" . addslashes($new_values) . "\" ,
		`lgf_old_values` = \"" . addslashes($old_values) . "\" ,
		`lgf_description` = \"" . addslashes($description) . "\" ";

        $this->query($sql);
        $sql = '';
        unset($sql);

    }//

    function update_log_file_custom($sql, $action = 'CUSTOM')
    {
        $this->update_log_file('CUSTOM', 0, $action, 'CUSTOM', 'CUSTOM', $sql);
    }//update_log_file_custom

    function convertDateToEU($date, $date_time = 0, $return_time = 0)
    {
        return $this->convert_date_format($date, 'yyyy-mm-dd', 'dd/mm/yyyy', $date_time, $return_time);
    }

    function convertDateToUS($date, $date_time = 0, $return_time = 0)
    {
        return $this->convert_date_format($date, 'dd/mm/yyyy', 'yyyy-mm-dd', $date_time, $return_time);
    }

    function convert_date_format($date, $from_format = 'yyyy-mm-dd', $to_format = 'dd/mm/yyyy', $date_time = 0, $return_time = 0)
    {

        if ($date_time == 1) {
            $split = explode(" ", $date);
            $date = $split[0];
        }

//check if date is empty retrun empty
        if ($date == "") {
            return "";
        }

//input
        if ($from_format == 'yyyy-mm-dd') {
            $fields = explode("-", $date);
            $day = $fields[2];
            $month = $fields[1];
            $year = $fields[0];
        } else if ($from_format == 'yyyy/mm/dd') {
            $fields = explode("/", $date);
            $day = $fields[2];
            $month = $fields[1];
            $year = $fields[0];
        } else if ($from_format == 'dd-mm-yyyy') {
            $fields = explode("/", $date);
            $day = $fields[0];
            $month = $fields[1];
            $year = $fields[2];
        } else if ($from_format == 'dd/mm/yyyy') {
            $fields = explode("/", $date);
            $day = $fields[0];
            $month = $fields[1];
            $year = $fields[2];
        }

        //check if values are empty
        if ($day < 1 || $month < 1 || $year < 1) {
            return '';
        }

//output
        if ($to_format == 'dd-mm-yyyy') {
            $return = $day . "-" . $month . "-" . $year;
        } else if ($to_format == 'dd/mm/yyyy') {
            $return = $day . "/" . $month . "/" . $year;
        } else if ($to_format == 'yyyy-mm-dd') {
            $return = $year . "-" . $month . "-" . $day;
        } else if ($to_format == 'yyyy/mm/dd') {
            $return = $year . "/" . $month . "/" . $day;
        } else {
            $return = $date;
        }

        if ($date_time == 1) {
            $return = $return;
            if ($return_time == 1) {
                $return .= " " . $split[1];
            }
        }

        return $return;
    }

    function convertDateToNumber($date, $format)
    {

        $fixedDate = $this->convert_date_format($date, $format, 'dd/mm/yyyy');
        $parts = explode('/', $fixedDate);

        $return = $parts[2];
        if ($parts[1] < 10) {
            $return .= "0" . $parts[1] * 1;
        } else {
            $return .= $parts[1];
        }
        $return .= $parts[0];
        return $return;
    }

//echos only if admin
    function admin_echo($echo)
    {

        if ($this->user_data["usr_users_groups_ID"] == 1) {
            echo $this->user_data["usr_users_group_ID"] . $echo;
        }

    }//admin echo.

    function fix_comma_separated($text)
    {

        $parts = explode(',', $text);

        foreach ($parts as $value) {
            $output .= "'" . $value . "',";
        }

        //cut the last comma
        $output = substr($output, 0, (strlen($output) - 1));

        return $output;

    }

    function get_last_day_of_month($month, $year)
    {

        return date('d', strtotime('-1 second', strtotime('+1 month', strtotime($month . '/01/' . $year . '00:00:00'))));

    }

    function remove_last_char($text)
    {
        return substr($text, 0, (strlen($text) - 1));
    }

    /**
     * @param $date
     * @param string $format
     * @return string
     */
    function verify_date($date, $format = 'd/m/Y')
    {
        $dt = new DateTime($date);
        return $dt->format($format);

        //$d = DateTime::createFromFormat($format, $date);
        //return $d && $d->format($format) == $date;

    }

    function total_days_between_2_dates($date1, $date2)
    {

        $from = strtotime($date1);
        $to = strtotime($date2);
        $datediff = $to - $from;
        return floor($datediff / (60 * 60 * 24));

    }

    //returns 1 if date1 > date2, returns 0 if date1 < date2, returns 0 if date1 = date2
    //works with date format dd/mm/yyyy but also converts with 3rd parameter from yyyy-mm-dd 
    function compare2dates($date1, $date2, $format = 'dd/mm/yyyy')
    {

        if ($format == 'yyyy-mm-dd') {
            $date1 = $this->convert_date_format($date1, 'yyyy-mm-dd', 'dd/mm/yyyy');
            $date2 = $this->convert_date_format($date2, 'yyyy-mm-dd', 'dd/mm/yyyy');
        }

        $date1Parts = explode('/', $date1);
        $date2Parts = explode('/', $date2);

        $dt1 = ($date1Parts[2] * 10000) + ($date1Parts[1] * 100) + $date1Parts[0];
        $dt2 = ($date2Parts[2] * 10000) + ($date2Parts[1] * 100) + $date2Parts[0];

        $return = 2;
        if ($dt1 > $dt2) {
            $return = 1;
        } else if ($dt1 < $dt2) {
            $return = -1;
        } else if ($dt1 == $dt2) {
            $return = 0;
        }
        return $return;

    }

    function backup_tables($host, $user, $pass, $dbName, $tables_to_use = '*')
    {

        $link = mysqli_connect($host, $user, $pass);
        if ($link->errno) {
            echo "Error Connecting to Database";
            exit();
        }
        mysqli_select_db($link, $dbName);

        //get all of the tables
        if ($tables_to_use == '*') {
            $tables = array();
            $result = $this->db_handle->query('SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            //if starts with - then use all tables except the ones with - in front of the table name
            //must always tables_to_use end with a comma,
            $tables = array();
            if (substr($tables_to_use, 0, 1) == '-') {
                $result = $this->db_handle->query(" SHOW FULL TABLES WHERE table_type <> 'View'");
                while ($row = mysqli_fetch_row($result)) {
                    if (strpos($tables_to_use, '-' . $row[0] . ",") === false) {
                        $tables[] = $row[0];
                    }
                }

            } else {
                $tables = is_array($tables) ? $tables : explode(',', $tables);
            }
        }
        $return = '';
        //cycle through
        foreach ($tables as $table) {
            $result = $this->db_handle->query('SELECT * FROM ' . $table);
            $num_fields = mysqli_num_fields($result);

            $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysqli_fetch_row($this->db_handle->query('SHOW CREATE TABLE ' . $table));
            $return .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }

        //save file
        //$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
        $filename = 'db-backup-' . time() . '.sql';
        $handle = fopen($filename, 'w+');
        fwrite($handle, $return);
        fclose($handle);
        return $filename;
    }

    function export_file_for_download($data, $filename)
    {
        global $db;
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Content-Transfer-Encoding: binary");
        echo $data;
    }

    function coalesce_null($value, $return_value)
    {
        if ($value == '' || $value == NULL) {
            return $return_value;
        } else {
            return $value;
        }
    }

//pass an array and will return the name based on the value.
//array -> 'value','label'
    function show_from_array_list($value, $list)
    {
        foreach ($list as $data) {

            if ($value == $data["value"]) {
                return $data["label"];
            }

        }
    }

    function make_fix_width($text, $chars, $type, $align = 'right')
    {
//echo "<br><hr>".$type."-".$chars."-".$text."->->";
        if ($type == 'char') {
            $spacer = ' ';
        } else if ($type == 'num') {
            $spacer = '0';
        }

        $str_length = mb_strlen($text, 'UTF-8');

        $result = $text;

        for ($i = $str_length; $i < $chars; $i++) {
            //echo "[".$i."]";
            if ($align == 'right') {
                $result .= $spacer;
            } else {
                $result = $spacer . $result;
            }
        }


        return $result;
    }

    function return_date_part($date, $date_format)
    {

        if ($date_format == 'yyyy-mm-dd') {
            $parts = explode("-", $date);
            $ret["day"] = $parts[2];
            $ret["month"] = $parts[1];
            $ret["year"] = $parts[0];
        } else if ($date_format == 'dd/mm/yyyy') {
            $parts = explode("/", $date);
            $ret["day"] = $parts[0];
            $ret["month"] = $parts[1];
            $ret["year"] = $parts[2];
        }
        return $ret;
    }

    function prepare_text_as_html($text)
    {
        $return = str_replace(PHP_EOL, "<br>", $text);

        $return = str_replace("\n", "<br>", $return);
        $return = str_replace("\r", "<br>", $return);
        return $return;
    }

    function load_array_from_delimited($data, $line_delimited, $field_delimited, $first_line_headers = 1)
    {

        $lines = explode($line_delimited, $data);
        $i = 0;
        foreach ($lines as $name => $values) {

            if ($values != "") {

                $fields = explode($field_delimited, $values);

                if ($i == 0) {
                    foreach ($fields as $field_name => $field_value) {

                        $names[$field_name] = $field_value;

                    }
                } else {
                    foreach ($fields as $field_name => $field_value) {

                        $out[$i][$names[$field_name]] = $field_value;

                    }
                }
            }
            $i++;
        }//foreach per line

        return $out;
    }

    function get_script_time()
    {
        global $main;

        $time_elapsed_secs = microtime(true) - $main["start_script_time"];
        $time_elapsed_secs = round($time_elapsed_secs, 6);
        return $time_elapsed_secs;
    }

    //api methods
    //headers
    public function apiGetReadHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    }

    public function apiGetPostHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    /**
     * @param $prefix
     * @param $totalLeadingZeros
     * @param $number
     * @return string
     */

    public function buildNumber($prefix, $totalLeadingZeros, $number)
    {
        $out = $prefix;
        if ($totalLeadingZeros > 0 && $totalLeadingZeros <= 100) {
            $numLength = strlen($number);
            for ($i = 1; $i <= $totalLeadingZeros; $i++) {
                if ($i > $numLength) {
                    $out .= "0";
                }
            }
            $out .= $number;
        }
        return $out;
    }

    public function CustomersWhere()
    {

        if ($this->user_data['usr_user_rights'] == 0) {
            if ($this->dbSettings['cst_admin_customers']['value'] == 'viewAll') {
                return '';
            } else {
                return 'cst_for_user_group_ID = ' . $this->user_data['usr_users_ID'];
            }

        } else {
            return 'cst_for_user_group_ID = ' . $this->user_data['usr_users_groups_ID'];
        }

    }

    public function encrypt($text,$encryption_key='')
    {
        // Remove the base64 encoding from our key
        if ($encryption_key == ''){
            $encryption_key = base64_decode($this->encryptionKey);
        }
        else {
            $encryption_key = base64_decode($encryption_key);
        }

        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($text, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        $data = base64_encode($encrypted . '::' . $iv);
        //fix for url
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        //$data = urlencode($data);
        return $data;
    }

    public function decrypt($text,$encryption_key = '')
    {
        //fix $text
        $text = str_replace(['-', '_'], ['+', '/'], $text);
        //$text = urldecode($text);
        // Remove the base64 encoding from our key
        if ($encryption_key == '') {
            $encryption_key = base64_decode($this->encryptionKey);
        }
        else {
            $encryption_key = base64_decode($encryption_key);
        }
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($text), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    public function encodeGetValues($string)
    {
        //convert them to hex
        return dechex($string);
    }

    public function decodeGetValues($string)
    {
        return hexdec($string);
    }

    /** precission floor. Can floor with 2 decimals
     * @param $val
     * @param $precision
     * @return float|int
     */
    public function floorp($val, $precision)
    {
        $mult = pow(10, $precision); // Can be cached in lookup table
        return floor($val * $mult) / $mult;
    }

    public function dateDiff($a, $b, $format = 'dd/mm/yyyy')
    {
        if ($format == 'yyyy-mm-dd') {
            $a = $this->convert_date_format($a, 'yyyy-mm-dd', 'dd/mm/yyyy');
            $b = $this->convert_date_format($b, 'yyyy-mm-dd', 'dd/mm/yyyy');
        }
        $aParts = explode('/', $a);
        $bParts = explode('/', $b);
        $dateA = new DateTime('@' . mktime(0, 0, 0, $aParts[1], $aParts[0], $aParts[2]));
        $dateB = new DateTime('@' . mktime(0, 0, 0, $bParts[1], $bParts[0], $bParts[2]));
        $diff = $dateB->diff($dateA);
        return $diff;
    }

    //provide date and months and will generate the next expiry date. Can be used for policies
    public function getNewExpiryDate($curDate, $months, $format = 'dd/mm/yyyy')
    {
        //echo $curDate."\n\n";
        if ($format == 'yyyy-mm-dd') {
            $curDate = $this->convert_date_format($curDate, 'yyyy-mm-dd', 'dd/mm/yyyy');
        }
        $newMonth = 0;
        $newDay = 0;
        $newYear = 0;
        $curDay = 0;
        $curMonth = 0;
        $curYear = 0;
        if ($curDate != '') {

            //split the current date;
            $split = explode('/', $curDate);
            $curDay = $split[0];
            $curMonth = $split[1];
            $curYear = $split[2];

            //first add the months
            $newMonth = ($curMonth * 1) + $months;
            //update the rest of the fields
            $newDay = ($curDay * 1) - 1;
            $newYear = $curYear;


            //check the month if need to change year
            if ($newMonth > 12) {
                //first update the year
                $newYear++;
                $newMonth = $newMonth - 12;
            }


            $isLeap = (($newYear % 4 == 0) && ($newYear % 100 != 0)) || ($newYear % 400 == 0);

            //check the day. if 0 then need to go back one day and one month
            if ($newDay == 0) {
                //first fix the month
                $newMonth--;
                //check if the month now is 0
                if ($newMonth == 0) {
                    $newMonth = 12;
                    $newYear--;
                }
                //now set the day to 31
                $newDay = 31;
            }

            //validate days 31, 30, 29
            if ($newDay >= 28 && $newDay <= 31) {

                //now check the day compared to month
                if ($newMonth == 1 || $newMonth == 3 || $newMonth == 5 || $newMonth == 7 || $newMonth == 8 || $newMonth == 10 || $newMonth == 12) {
                    //do nothing is already 29 or 30 or 31;
                } else if ($newMonth == 2) {
                    //find leap year
                    if ($isLeap == true) {
                        if ($newDay > 29) {
                            $newDay = 29;
                        }
                    } else {
                        if ($newDay > 28) {
                            $newDay = 28;
                        }
                    }
                } else {
                    if ($newDay > 30) {
                        $newDay = 30;
                    }
                }
            }

        }
        $return['full'] = $newDay . '/' . $newMonth . '/' . $newYear;
        $return['day'] = $newDay;
        $return['month'] = $newMonth;
        $return['year'] = $newYear;
        return $return;
    }

    public function showLangText($eng, $gre)
    {
        if ($this->user_data['usr_default_lang'] == 'gre') {
            return $gre;
        } else {
            return $eng;
        }
    }

}//main class


?>