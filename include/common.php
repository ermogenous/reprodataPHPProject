<?php


$main["start_script_time"] = microtime(true);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $main["conf_title"] = 'Sythesis';
    $main["admin_title"] = "Synthesis";

    //Global variables
    $main["site_host"] = 'localhost';
    $main["site_url"] = "http://localhost/insurance"; //Not include last slash
    $main["local_url"] = "C:/xampp/htdocs/insurance"; //Not include last slash
    $main["remote_folder"] = "/insurance";
    $main["remote_folder_total"] = 1;


    $main["db_username"] = "mike_db_user";
    $main["db_password"] = "ermogenous";
    $main["db_host"] = "localhost";
    $main["db_database"] = "insurance";


    //phpmyadmin -> https://mysqladmin3.secureserver.net/m50/179
    //no-reply email
    $main["no-reply-email"] = 'no-reply@akdemetriou.com';
    $main["no-reply-email-name"] = $main["admin_title"].' - No-Reply';

    //EMAIL SETTINGS
    $main["admin_email"] = 'micacca@gmail.com';
    $main["admin_email_name"] = 'Ermogenous Michael';
    //smtp email settings
    $main['smtp_use_smtp'] = false;
    $main['smtp_email_from'] = 'agentscyprus@gmail.com';
    $main['smtp_email_from_name'] = 'Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus';
    $main['smtp_email_reply'] = 'agentscyprus@gmail.com';
    $main['smtp_email_reply_name'] = 'Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol - Cyprus';
    $main['smtp_host'] = 'smtp.gmail.com';
    $main['smtp_username'] = 'agentscyprus@gmail.com';
    $main['smtp_password'] = 'npebysgpszsmqizt';
    $main['smtp_secure'] = 'tls'; // Enable TLS encryption, `ssl` also accepted, Can use 'tls' or 'ssl'
    $main['smtp_port'] = '587';
    $main['smtp_charSet'] = 'UTF-8';
    $main['smtp_enable_authentication'] = true; //Enable SMTP authentication

    $main["test_dadabase"] = 'yes';
    $main["environment"] = 'synthesis';

    $main["login_page_filename"] = 'login.php';

    $main["timeZone"] = 'Europe/Athens';


} else {

	//TIME ZONE
    $main["timeZone"] = 'Europe/Athens';
    //date_default_timezone_set($main["time_zone"]);

    $main["conf_title"] = 'Synthesis';

    $main["admin_title"] = "Synthesis";

    //Global variables
    $main["site_host"] = 'http://rds.agentscy.com';
    $main["site_url"] = "http://rds.agentscy.com"; //Not include last slash
    $main["local_url"] = "/home/dc2vz8797vk4/public_html/reprodata"; //Not include last slash
    $main["remote_folder"] = "";
    $main["remote_folder_total"] = 0;


    $main["db_username"] = "rpdatadbuser";
    $main["db_password"] = "KS^bn@Pcgc1y";
    $main["db_host"] = "localhost";
    $main["db_database"] = "reprodata";

    $main["admin_email"] = 'ermogenousm@gmail.com';
    //no-reply email
    $main["no-reply-email"] = 'no-reply@gmail.com';
    $main["no-reply-email-name"] = $main["admin_title"].' - No-Reply';

    //smtp email settings
    $main['smtp_host'] = 'smtp.gmail.com';
    $main['smtp_username'] = 'agentscyprus@gmail.com';
    $main['smtp_password'] = 'npebysgpszsmqizt';
    $main['smtp_secure'] = 'tls'; // Enable TLS encryption, `ssl` also accepted, Can use 'tls' or 'ssl'
    $main['smtp_port'] = '587';

    $main["environment"] = 'extranet';
    $main["login_page_filename"] = 'login.php';
    //security
    //IPS to block, always end with ,
    $main["block_countries_from_ip"] = "TR,RS,";//Turkey,Servia
    $main["block_countries_redirect_page"] = "http://rds.agentscy.com/ip_blocked.php";


    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL & ~E_NOTICE);
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
    ini_set('error_reporting',E_ALL & ~E_NOTICE & ~E_WARNING);
    //ini_set('error_reporting',E_ALL);
    ini_set('display_errors', '1');
    ini_set('html_errors', '1');
    ini_set('log_errors', 1);
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
