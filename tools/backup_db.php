<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/7/2019
 * Time: 2:12 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");
include("../send_auto_emails/send_auto_emails_class.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Backup DB";

$db->show_header();


$dbFileName = $db->backup_tables($main['db_host'], $main['db_username'], $main['db_password'], $main['db_database']);

if (is_file($dbFileName)){
    echo "File is Created Successfully!<br>";
    $zip = new ZipArchive();
    //get the file name without the extension
    $fileName = explode('.',$dbFileName);
    if ($zip->open('../send_auto_emails/attachment_files/'.$fileName[0].'.zip', ZipArchive::CREATE) !== TRUE){
        echo "Error Creating the zip File<br>";
        $db->show_footer();
        exit();
    }
    else {
        echo "Zip file created.<br>";
    }
    $zip->addFile($dbFileName);
    $zip->close();


    //now delete the sql file
    unlink($dbFileName)or die('Error deleting the SQL file.');

    //send it to email
    $dataArray = [
        'user_ID' => $db->user_data['usr_users_ID'],
        'email_to' => 'micacca@gmail.com',
        'email_to_name' => 'Michael Ermogenous',
        'email_from' => 'ermogenousm@gmail.com||AgentsCy DB Backup',
        'email_subject' => 'DB Backup',
        'email_reply_to' => 'ermogenousm@gmail.com||Michael Ermogenous',
        'attachment_files' => $fileName[0].'.zip',
        'type' => 'dbBackup',
        'email_body' => 'Database backup for '.date('m/d/Y G:i:s')
    ];

    $email = new createNewAutoEmail();
    $emailID = $email->addData($dataArray);
    $sendMail = new send_auto_emails($emailID);
    $sendMail->send_email();
    if ($sendMail->count_errors > 0){
        echo "There was an error sending the email. Check autoEmails.<br>";
    }
    else {
        echo "Emails was send successfully.<br>";
    }

}
else {
    echo "Cannot find the file.<br>";
}

echo $fileName[0].".zip";
?>




<?php
$db->show_footer();
?>