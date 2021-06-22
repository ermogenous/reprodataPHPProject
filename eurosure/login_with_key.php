<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 8/4/2021
 * Time: 4:59 μ.μ.
 */

ini_set('session.cookie_samesite', 'None');
session_set_cookie_params(['samesite' => 'None']);

include("../include/main.php");
$db = new Main(0);

$key = $_GET['key'];
if (strlen($key) < 10) {
    header("Location: " . $main['site_url']);
    exit();
}
//echo $key."<br>\n\n";
$decrypted = $db->decrypt($key);
$split = explode("[sp]", $decrypted);
$username = $split[0];
$password = $split[1];

//login the user

if ($db->check_persistent_logins() == 0) {

    $sql = "SELECT * FROM `users` WHERE 1=1 AND `usr_password` = '" . addslashes($password) . "' 
    AND `usr_username` = '" . addslashes($username) . "'";
    $result = $db->query($sql);
    if ($db->num_rows($result) > 0) {
        $row = $db->fetch_assoc($result);

        //check if active
        if ($row['usr_active'] == 1) {

            $_SESSION[$main["environment"] . "_admin_username"] = $username;
            $_SESSION[$main["environment"] . "_admin_password"] = $password;


            //$loc = $main['site_url']."/home.php?";
            //find the location
            if ($_GET['section'] == 'live') {
                $loc = $main['site_url'] . "/eurosure/extranet/live/live_production_statistics.php";
            }
            else if ($_GET['section'] == 'reports'){
                $loc = $main['site_url'] . "/eurosure/extranet/reports/loss_ratios.php";
            }
            else {
                $loc = $main['site_url'];
            }

            //echo $loc;exit();
            header("Location: " . $loc);
            exit();

        } else {
            //user inactive/suspended
            $error = 'You account is suspended. Please contact the administrator.';
        }
    }//if correct
    else {
        $_SESSION["failed_login_attempt"]++;
        $_SESSION["failed_login_attempt_last_time"] = time();
        $error = "Invalid username and/or password. Try again.";
    }

} else {
    $error = "To many attempts. Please try again later";
}

echo $error;
