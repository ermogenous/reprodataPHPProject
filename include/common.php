<?php


$main["start_script_time"] = microtime(true);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $main["conf_title"] = 'Reprodata';
    $main["admin_title"] = "Reprodata Development";

    //Global variables
    $main["site_host"] = 'localhost';
    $main["site_url"] = "http://localhost/reprodata"; //Not include last slash
    $main["local_url"] = "C:/xampp/htdocs/reprodata"; //Not include last slash
    $main["remote_folder"] = "/reprodata";
    $main["remote_folder_total"] = 1;


    $main["db_username"] = "mike_db_user";
    $main["db_password"] = "ermogenous";
    $main["db_host"] = "localhost";
    $main["db_database"] = "reprodata";

    $main["admin_email"] = 'micacca@gmail.com';
    //phpmyadmin -> https://mysqladmin3.secureserver.net/m50/179
    //no-reply email
    $main["no-reply-email"] = 'no-reply@akdemetriou.com';
    $main["no-reply-email-name"] = $main["admin_title"].' - No-Reply';

    $main["test_dadabase"] = 'yes';
    $main["environment"] = 'reprodata';

    $main["login_page_filename"] = 'login.php';

} else {

	//TIME ZONE
    $main["time_zone"] = 'Europe/Athens';
    date_default_timezone_set($main["time_zone"]);

    $main["conf_title"] = 'Reprodata';

    $main["admin_title"] = "Reprodata";

    //Global variables
    $main["site_host"] = 'https://reprodata.com';
    $main["site_url"] = "https://reprodata.com/program"; //Not include last slash
    $main["local_url"] = "/var/sites/a/reprodata.com/public_html/program"; //Not include last slash
    $main["remote_folder"] = "";
    $main["remote_folder_total"] = 1;


    $main["db_username"] = "akdemetr_program";
    $main["db_password"] = "g{bMu6U\,Z2vSPx%";
    $main["db_host"] = "10.169.0.169";
    $main["db_database"] = "reprodata";

    $main["admin_email"] = 'ermogenousm@gmail.com';
    //no-reply email
    $main["no-reply-email"] = 'no-reply@akdemetriou.com';
    $main["no-reply-email-name"] = $main["admin_title"].' - No-Reply';


    $main["environment"] = 'extranet';
    $main["login_page_filename"] = 'login.php';
    //security
    //IPS to block, always end with ,
    $main["block_countries_from_ip"] = "TR,RS,";//Turkey,Servia
    $main["block_countries_redirect_page"] = "https://akdemetriou.com/program/ip_blocked.php";

    ini_set('error_reporting', 'E_ALL & ~E_NOTICE & ~E_WARNING');

    /*
    if ($main["do_not_apply_https"] != 'yes') {
        if($_SERVER["HTTPS"] != "on" && $_SESSION["disable_ssl_temporary"] != 'YES') {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$main["site_url"]);
            exit();
        }
    }
    */
    //phpmyadmin -> https://phpmyadmin.gridhost.co.uk/
}

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    //ini_set('error_reporting','E_ALL & ~E_NOTICE & ~E_WARNING');
}
else {
    //header("Location: ".$main["site_host"]."/under_construction.php");
    //exit();
    //ini_set('error_reporting','E_ALL & ~E_NOTICE & ~E_WARNING');
}
//INI SPECIFICATIONS
//ini_set('display_errors', '1');
//ini_set('html_errors', '1');
//if ($temp_var["show_all_errors"] != 1) {
//    ini_set('error_reporting','E_ALL & ~E_NOTICE & ~E_WARNING');
//}