<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class send_auto_emails
{

    public $auto_email_serial = 0;
    private $initial_query_result;
    private $data;
    private $end_of_line;
    public $messages;//stores messages of the whole process for debugging
    private $error_messages;
    private $current_serial;
    private $add_extra_mail_headers;
    private $send_all_init = 0;
    public $count_errors = 0;

    public function __construct($use_auto_email_serial = 0)
    {
        global $db;

        $this->messages['error'] = 0;
        $this->messages['error_message'] = 'None';
        if ($use_auto_email_serial == 0) {
            $this->messages[] = 'Start: Get information for all pending emails';
            $sql = "SELECT * FROM send_auto_emails WHERE sae_active = 'A' AND sae_send_result = 0 ORDER BY sae_created_date_time ASC";
        } else {
            $this->messages[] = 'Start: Get information for a specific email';
            $sql = "SELECT * FROM send_auto_emails WHERE sae_active = 'A' AND sae_send_auto_emails_serial = " . $use_auto_email_serial . " ORDER BY sae_created_date_time ASC";
        }
        $this->end_of_line = 0;
        $this->initial_query_result = $db->query($sql);
        $this->get_next_record_data();

    }

    public function get_next_record_data()
    {
        global $db;
        if ($this->end_of_line != 1) {
            $this->data = $db->fetch_assoc($this->initial_query_result);
            //check if end of line
            if ($this->data["sae_send_auto_emails_serial"] > 0) {
                $this->current_serial = $this->data["sae_send_auto_emails_serial"];
                $this->messages[] = "Retrieve data for the record: " . $this->current_serial;
            } else {
                $this->messages[] = "No more records. Reached end of line";
                $this->end_of_line = 1;
            }
        } else {
            $this->messages[] = "No more records. Reached end of line";
        }
    }

    public function execute_all_emails()
    {
        if ($this->end_of_line != 1) {
            if ($this->send_all_init == 0) {
                $this->messages[] = "Executing all emails function initiated";
            }
            $this->send_all_init = 1;
            $this->send_email();
            $this->get_next_record_data();
            $this->execute_all_emails();
        }
    }

    public function send_email()
    {

        global $db, $main;
        if ($this->data["sae_send_result"] != 0) {
            $this->messages[] = 'This email has already been sent. SKIP';
            $this->messages["error"] = 1;
            $this->messages["error_message"] = 'This email has already been sent. SKIP';
            return;
        }
        if (!$this->data["sae_send_auto_emails_serial"] > 0) {
            $this->messages[] = 'No data found';
            $this->messages["error"] = 1;
            $this->messages["error_message"] = 'No data found';

            return;
        }

        //require_once $main["local_url"].'/include/libraries/phpMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer(true);
        //fix emails
        $this->fix_email_lists();


        $this->messages[] = "Sending email of serial: " . $this->data["sae_send_auto_emails_serial"];

        //$mail->SMTPDebug = 3;//true echos all steps           // Enable verbose debug output
        $mail->CharSet = $main['smtp_charSet'];

        if ($main['smtp_use_smtp'] == true) {
            $mail->isSMTP();                                        // Set mailer to use SMTP
            $mail->Host = $main['smtp_host'];       // Specify main and backup SMTP servers
            $this->messages[] = 'Added Host: '.$main['smtp_host'];

            $mail->SMTPAuth = $main['smtp_enable_authentication'];                                // Enable SMTP authentication
            $mail->Username = $main['smtp_username'];                 // SMTP username
            $mail->Password = $main['smtp_password'];                           // SMTP password
            $mail->SMTPSecure = $main['smtp_secure'];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $main['smtp_port'];
        }
        else {

        }



        $mail->isHTML(true);
        $split = explode('||',$this->data["sae_email_from"]);
        $mail->setFrom($split[0], $split[1]);
        $this->messages[] = 'Added From Address:'.$split[0]." ".$split[1];
        //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient

        //loop into all the recipients to add them one by one with \n as separator
        $to = explode(PHP_EOL, $this->data["sae_email_to"]);
        //to name removed. the to name is found in the to with space separator
        //$to_name = explode(",", $this->data["sae_email_to_name"]);
        foreach ($to as $name => $value) {
            //break the email and name
            unset($split);
            $split = explode('||', $value);

            //check if it valid email
            if (filter_var($split[0], FILTER_VALIDATE_EMAIL)){
                if ($mail->addAddress($split[0], $split[1])) {
                    $this->messages[] = "Mail - " . $split[0]." ".$split[1] . " added succesfully";
                } else {
                    $this->messages[] = "Error adding Mail - " . $split[0]." ".$split[1];
                    $this->error_messages .= "\nError adding Mail - " . $split[0]." ".$split[1];
                }
            }else {
                $this->messages[] = "Error adding Mail (InValid Email) - " . $split[0]." ".$split[1];
                $this->error_messages .= "\nError adding Mail (InValid Email) - " . $split[0]." ".$split[1];
            }

        }

        //insert the reply to
        $split = explode('||',$this->data["sae_email_reply_to"]);
        if ($mail->addReplyTo($split[0], $split[1])) {
            $this->messages[] = "Reply to Mail - " . $split[0]." ".$split[1] . " added succesfully";
        } else {
            $this->messages[] = "Error adding Reply to Mail - " . $split[0]." ".$split[1];
            $this->error_messages .= "\nError adding  Reply to Mail - " . $split[0]." ".$split[1];
        }

        //loop into all the cc to add them one by one
        if ($this->data["sae_email_cc"] != '') {
            $cc = explode(PHP_EOL, $this->data["sae_email_cc"]);
            foreach ($cc as $value) {
                $split = explode('||', $value);
                if ($mail->addCC($split[0], $split[1])) {
                    $this->messages[] = "CC Mail - " . $split[0] . " " . $split[1] . " added succesfully";
                } else {
                    $this->messages[] = "Error adding CC Mail - " . $split[0] . " " . $split[1];
                    $this->error_messages .= "\nError adding CC Mail - " . $split[0] . " " . $split[1];
                }
            }
        }
        //loop into all the bcc to add them one by one
        if ($this->data["sae_email_bcc"] != '') {
            $bcc = explode(PHP_EOL, $this->data["sae_email_bcc"]);
            foreach ($bcc as $value) {
                $split = explode('||', $value);
                if ($mail->addBCC($split[0], $split[1])) {
                    $this->messages[] = "BCC Mail - " . $split[0] . " " . $split[1] . " added succesfully";
                } else {
                    $this->messages[] = "Error adding BCC Mail - " . $split[0] . " " . $split[1];
                    $this->error_messages .= "\nError BCC adding Mail - " . $split[0] . " " . $split[1];
                }
            }
        }
        if ($this->data['sae_attachment_files'] != '') {

            $attachFile = explode(PHP_EOL, $this->data['sae_attachment_files']);
            foreach ($attachFile as $value) {
                $split = explode('||', $value);
                //$file = $main['local_url'].'/send_auto_emailss/attachment_files/'.$split[0];
                $file = '../send_auto_emails/attachment_files/'.$split[0];
                if (is_file($file)){
                    if ($mail->addAttachment($file,$split[1])) {
                        $this->messages[] = "Adding Attachment File - " . $split[0] . " " . $split[1] . " added succesfully";
                    } else {
                        $this->messages[] = "Error adding Attachment File - " . $split[0] . " " . $split[1];
                        $this->error_messages .= "\nError Attachment File - " . $split[0] . " " . $split[1];
                    }
                }
                else {
                    $this->messages[] = "Error adding Attachment File Cannot find file - " . $split[0] . " " . $split[1];
                    $this->error_messages .= "\nError Attachment File Cannot find file - " . $split[0] . " " . $split[1];
                }

            }
            //$mail->addAttachment($main["local_url"] . '/' . $this->data['sae_attachment_file']);         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        }

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $this->data["sae_email_subject"];

        $mail->msgHTML($this->data["sae_email_body"]);
        //$mail->Body    = $this->data["sae_email_body"];
        //$mail->Body    = mb_convert_encoding($this->data["sae_email_body"], "ISO-8859-1", mb_detect_encoding($this->data["sae_email_body"], "UTF-8, ISO-8859-1, ISO-8859-15", true));

        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        try {
            $mail->send();
            $this->update_email_result(1, 'Message has been sent ' . $mail->ErrorInfo);
            $this->messages[] = "Email Send success";
        }
        catch (Exception $e) {
            $this->messages[] = "Error sending email: Error message: " . $mail->ErrorInfo;
            $this->update_email_result(-1, 'Message could not be sent. ' . $mail->ErrorInfo);
            $this->count_errors++;
        }

        /*
        if (!$mail->send()) {
            $this->messages[] = "Error sending email: Error message: " . $mail->ErrorInfo;
            $this->update_email_result(-1, 'Message could not be sent. ' . $mail->ErrorInfo);
            $this->count_errors++;
        } else {
            $this->update_email_result(1, 'Message has been sent ' . $mail->ErrorInfo);
            $this->messages[] = "Email Send success";
        }
        */
    }

    public function update_email_result($result, $result_description)
    {
        global $db;
        $sql = "UPDATE send_auto_emails SET
		sae_send_result = " . $result . ",
		sae_send_result_description = '" . addslashes($result_description) . " " . addslashes($this->error_messages) . "',
		sae_send_datetime = '" . date("Y-m-d G:i:s") . "'
		WHERE 
		sae_send_auto_emails_serial = " . $this->data["sae_send_auto_emails_serial"];
        $db->query($sql);
    }

    public function fix_email_lists()
    {
        //fixes the email_to, email_from, reply_to, cc, bcc and updates also the database.
        //replace the ; to ,
        $this->data["sae_email_to"] = str_replace(";", ",", $this->data["sae_email_to"]);
        $this->data["sae_email_from"] = str_replace(";", ",", $this->data["sae_email_from"]);
        $this->data["sae_email_reply_to"] = str_replace(";", ",", $this->data["sae_email_reply_to"]);
        $this->data["sae_email_cc"] = str_replace(";", ",", $this->data["sae_email_cc"]);
        $this->data["sae_email_bcc"] = str_replace(";", ",", $this->data["sae_email_bcc"]);

        //remove any spaces found
        /*
        $this->data["sae_email_to"] = str_replace(" ", "", $this->data["sae_email_to"]);
        $this->data["sae_email_from"] = str_replace(" ", "", $this->data["sae_email_from"]);
        $this->data["sae_email_reply_to"] = str_replace(" ", "", $this->data["sae_email_reply_to"]);
        $this->data["sae_email_cc"] = str_replace(" ", "", $this->data["sae_email_cc"]);
        $this->data["sae_email_bcc"] = str_replace(" ", "", $this->data["sae_email_bcc"]);
        */

    }

}

class createNewAutoEmail
{

    public $error = false;
    public $errorDescription = '';

    function __construct()
    {

    }

    public function addData($dataArray)
    {
        global $db, $main;

        $newData['user_ID'] = $dataArray['user_ID'];
        $newData['email_to'] = $dataArray['email_to'];
        $newData['email_to_name'] = $dataArray['email_to_name'];
        $newData['email_from'] = $main['smtp_email_from'] . "||" . $main['smtp_email_from_name'];
        $newData['email_subject'] = $dataArray['email_subject'];
        $newData['email_reply_to'] = $main['smtp_email_reply'] . "||" . $main['smtp_email_reply_name'];
        $newData['email_cc'] = $dataArray['email_cc'];
        $newData['email_bcc'] = $dataArray['email_bcc'];
        $newData['email_body'] = $dataArray['email_body'];
        $newData['attachment_files'] = $dataArray['attachment_files'];

        $newData['type'] = $dataArray['type'];

        $newData['active'] = 'A';
        $newData['send_result'] = 0;
        $newData['primary_serial'] = $dataArray['primary_serial'];
        $newData['primary_label'] = $dataArray['primary_label'];
        $newData['secondary_serial'] = $dataArray['secondary_serial'];
        $newData['secondary_label'] = $dataArray['secondary_label'];

        if ($newData['email_to'] == '') {
            $this->error = true;
            $this->errorDescription = 'Must provide To:';
        }

        if ($newData['email_from'] == '') {
            $this->error = true;
            $this->errorDescription = 'Must provide From:';
        }

        $newID = 0;
        if ($this->error == false) {
            //fixes
            if ($newData['sae_primary_serial'] == ''){
                unset($newData['primary_serial']);
            }
            if ($newData['sae_secondary_serial'] == ''){
                unset($newData['secondary_serial']);
            }
            $newID = $db->db_tool_insert_row('send_auto_emails', $newData, '', 1, 'sae_');
        }

        if ($this->error = true) {
            return 0;
        } else {
            return $newID;
        }
    }

    /**
     * @param $emailAndName many emails format: email@email.com||Name break email2@email.com||name
     * @return $this
     */
    public function setEmailTo($emailAndName){



        return $this;
    }

}

?>