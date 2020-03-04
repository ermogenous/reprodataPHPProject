<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/4/2019
 * Time: 7:30 ΜΜ
 */

class dynamicQuotation
{

    private $quotationData = [];
    private $quotationID;
    private $underwriterData = [];
    private $quotationTypeData = [];

    public $error = false;
    public $errorType = 'error';
    public $errorDescription = '';

    function __construct($quotationID)
    {
        global $db;
        $this->quotationID = $quotationID;
        if ($this->quotationID > 0) {
            $this->quotationData = $db->query_fetch('
          SELECT * FROM 
          oqt_quotations
          JOIN oqt_quotations_types ON oqq_quotations_type_ID = oqqt_quotations_types_ID
          LEFT OUTER JOIN users ON usr_users_ID = oqq_users_ID
          LEFT OUTER JOIN oqt_quotations_underwriters ON oqun_user_ID = usr_users_ID
          WHERE oqq_quotations_ID = ' . $this->quotationID);

            //include function for this quotation type
            if (is_file($this->quotationData['oqqt_functions_file'])) {
                include_once($this->quotationData['oqqt_functions_file']);
            }
        }
    }

    public function quotationData()
    {
        return $this->quotationData;
    }

    public function quotationID()
    {
        return $this->quotationID;
    }

    private function getUnderwriterData()
    {
        global $db;
        $this->underwriterData = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = ' . $db->user_data['usr_users_ID']);
    }

    public function getQuotationType()
    {
        $label = $this->quotationData['oqqt_quotation_or_cover_note'];
        if ($label == 'CN') {
            $label = 'Cover Note';
        } else {
            $label = 'Quotation';
        }
        return $label;
    }

    public function checkForActivation()
    {
        global $db;

        //1. check if Outstanding or approved
        if ($this->quotationData['oqq_status'] != 'Outstanding' && $this->quotationData['oqq_status'] != 'Approved') {
            $this->error = true;
            $this->errorDescription = $this->getQuotationType() . ' Must be Outstanding/Approved';
        }


        $customResult = [];
        if (function_exists('activate_custom_validation')) {

            $customResult = activate_custom_validation($this->quotationData);
            $this->error = $customResult['error'];
            $this->errorDescription = $customResult['errorDescription'];

            if ($this->error == true) {
                $this->errorDescription .= '<br><b>Must fix errors before activating.</b>';
            }

        }

        //check if needs approval
        $this->checkForApproval();

        //check if this user is allowed to activate. Only the user who created it or admins can activate
        $this->getUnderwriterData();
        if ($db->user_data["usr_users_ID"] != $this->quotationData["oqq_users_ID"] && $db->user_data["usr_user_rights"] >= 3) {
            //if ($this->underwriterData['oqun_view_group_ID'] > 0 && $this->underwriterData['oqun_view_group_ID'] == $this->quotationData['usr_users_groups_ID']){
                //user is allowed
            //}
            //else {
                $this->error = true;
                $this->errorDescription = 'You are not allowed to activate this '.$this->getQuotationType();
            //}
        }

        //$this->error = true;
        //$this->errorDescription .= ' test';

        if ($this->error == true) {
            return false;
        } else {
            return true;
        }
    }

    public function activate()
    {
        global $db;
        if ($this->checkForActivation() == true) {

            $newData['status'] = 'Active';
            $newData['effective_date'] = date('Y-m-d G:i:s');

            //check if renewal and if to issue new number or not
            if ($this->quotationData['oqq_replacing_ID'] > 0){
                if ($this->quotationData['oqqt_renewal_issue_new_number'] == 1){
                    $newData['number'] = $this->issueNumber();
                }
                else {
                    //not issue new number
                }
            }
            //all other except renewals.
            else {
                $newData['number'] = $this->issueNumber();
            }



            //update the data of the current object
            $this->quotationData['oqq_status'] = $newData['status'];
            $this->quotationData['oqq_effective_date'] = $newData['effective_date'];
            $this->quotationData['oqq_number'] = $newData['number'];


             $db->db_tool_update_row('oqt_quotations', $newData,
                'oqq_quotations_ID = '.$this->quotationID, $this->quotationID,'','execute','oqq_');

            $this->sendEmail();

            return true;
        } else {
            return false;
        }
    }

    public function checkForApproval()
    {
        global $db;
        $needApproval = false;
        //first check if the quotation is outstanding
        if ($this->quotationData['oqq_status'] == 'Outstanding') {

            if (function_exists('customCheckForApproval')) {
                $result = customCheckForApproval($this->quotationData);
                $this->error = $result['error'];
                $this->errorDescription = $result['errorDescription'];
                if ($result['error'] == true) {
                    $needApproval = true;
                    $this->errorType = 'warning';
                }
            }

            //if approval is found then change the status of the policy to Pending.
            if ($needApproval == true) {
                $newData['status'] = 'Pending';
                $this->quotationData['oqq_status'] = 'Pending';
                //success sending the approval email
                if ($this->sendApprovalEmail()){

                }
                //failure sending the email.
                else {

                }
                $db->db_tool_update_row('oqt_quotations', $newData,
                    'oqq_quotations_ID = ' . $this->quotationID, $this->quotationID, '', 'execute', 'oqq_');

                //insert record in the approvals table
                $this->createApprovalRecord($this->errorDescription);
            }

        } else {
            //does not need approval
        }

        if ($this->error == true) {
            return false;
        } else {
            return true;
        }
    }

    private function sendApprovalEmail(){
        global $db,$main;
        include_once('../send_auto_emails/send_auto_emails_class.php');

        //check if status = pending
        if ($this->quotationData['oqq_status'] == 'Pending'){

            //check parameters if send mail is enabled
            if ($this->quotationData['oqqt_approval_send_mail'] != '') {

                $autoEmail = new createNewAutoEmail();
                $dataArray['email_to'] = $this->quotationData['oqqt_approval_send_mail'];

                $dataArray['email_subject'] = $this->quotationData['oqqt_approval_send_mail_subject'];
                $dataArray['email_cc'] = $this->quotationData['oqqt_approval_send_mail_cc'];
                $dataArray['email_bcc'] = $this->quotationData['oqqt_approval_send_mail_bcc'];
                $dataArray['email_body'] = $this->quotationData['oqqt_approval_send_mail_body'];
                $dataArray['type'] = $this->getQuotationType();
                $dataArray['primary_serial'] = $this->quotationID;
                $dataArray['primary_label'] = $this->getQuotationType() . " SERIAL";
                $dataArray['secondary_serial'] = '';
                $dataArray['secondary_label'] = '';
                $dataArray['user_ID'] = $this->quotationData['oqq_users_ID'];
                //file attachment filename
                $attachment_file_name = $this->quotationData['oqqt_approval_attach_print_filename'];


                //fix the subject/body with the ReplaceCodes
                //[QTID]
                $dataArray['email_subject'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['email_subject']);
                $dataArray['email_body'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['email_body']);
                $attachment_file_name = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $attachment_file_name);


                //[QTNUMBER]
                $dataArray['email_subject'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['email_subject']);
                $dataArray['email_body'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['email_body']);
                $attachment_file_name = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $attachment_file_name);

                //[QTLINK]
                $link = $main["site_url"]."/dynamic_quotations/quotations_modify.php?quotation_type=".$this->quotationData['oqq_quotations_type_ID']."&quotation=".$this->quotationData['oqq_quotations_ID'];
                $dataArray['email_subject'] = str_replace('[QTLINK]', $link, $dataArray['email_subject']);
                $dataArray['email_body'] = str_replace('[QTLINK]', $link, $dataArray['email_body']);

                //[USERNAME]
                $dataArray['email_subject'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['email_subject']);
                $dataArray['email_body'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['email_body']);
                $attachment_file_name = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $attachment_file_name);

                //[PDFLINK]
                $link = $main["site_url"]."/dynamic_quotations/quotation_print.php?quotation=".$this->quotationData['oqq_quotations_ID']."&pdf=1";
                $dataArray['email_subject'] = str_replace('[PDFLINK]', $link, $dataArray['email_subject']);
                $dataArray['email_body'] = str_replace('[PDFLINK]', $link, $dataArray['email_body']);

                //[IDENTIFIER]
                $dataArray['email_subject'] = str_replace('[IDENTIFIER]', $this->quotationData['oqq_unique_identifier'], $dataArray['email_subject']);
                $dataArray['email_body'] = str_replace('[IDENTIFIER]', $this->quotationData['oqq_unique_identifier'], $dataArray['email_body']);
                $attachment_file_name = str_replace('[IDENTIFIER]', $this->quotationData['oqq_unique_identifier'], $attachment_file_name);

                //file attachment
                if ($this->quotationData['oqqt_approval_attach_print_filename'] != ''){
                    //get the pdf data
                    include($this->quotationData['oqqt_print_layout']);
                    require_once '../vendor/autoload.php';
                    $html = getQuotationHTML($this->quotationID);
                    $mpdf = new \Mpdf\Mpdf([
                        'default_font' => 'dejavusans'
                    ]);

                    $mpdf->WriteHTML($html);
                    $filename = date('YmdGisu').".pdf";
                    $mpdf->Output($main['local_url'].'/send_auto_emails/attachment_files/'.$filename, \Mpdf\Output\Destination::FILE);
                    $dataArray['attachment_files'] = $filename."||".$attachment_file_name;
                }

                //create the record
                $autoEmailID = $autoEmail->addData($dataArray);
                //send the email
                $email = new send_auto_emails($autoEmailID);
                $email->send_email();
                if ($email->count_errors > 0){
                    $this->errorDescription = 'There was an error sending the email. You can manually resend the email in auto emails.';
                    $this->error = true;
                    return false;
                }
                else {
                    return true;
                }
            }
            else {
                return true;
            }

        }
        else {
            $this->errorDescription = 'Not Pending. Cannot send approval email.';
            $this->error = true;
            return false;
        }

    }
    
    private function issueNumber(){
        global $db;
        
        $newNumber = $db->buildNumber($this->quotationData['oqqt_quotation_number_prefix'],
            $this->quotationData['oqqt_quotation_number_leading_zeros'],
            $this->quotationData['oqqt_quotation_number_last_used']+1);
        //update db
        $newData['quotation_number_last_used'] = $this->quotationData['oqqt_quotation_number_last_used']+1;
        $db->db_tool_update_row('oqt_quotations_types',
            $newData,
            'oqqt_quotations_types_ID = '.$this->quotationData['oqqt_quotations_types_ID'],
            $this->quotationData['oqqt_quotations_types_ID'],
            '',
            'execute',
            'oqqt_');
        return $newNumber;
        
    }

    public function delete()
    {
        global $db;
        if ($this->quotationData['oqq_status'] == 'Outstanding') {
            $newData['status'] = 'Deleted';
            $db->db_tool_update_row('oqt_quotations', $newData,
                'oqq_quotations_ID = ' . $this->quotationID, $this->quotationID, '', 'execute', 'oqq_');
            return true;
        } else {
            $this->errorDescription = $this->getQuotationType() . ' must be Outstanding to delete.';
            $this->error = true;
            return false;
        }
    }

    //renews a quotation. Starting date one day after the expiry of the previous. Expiry is by parameter
    public function makeRenewal($newExpiry){
        global $db;

        //echo "Renewing with new expiry ".$newExpiry;

        if ($this->quotationData['oqq_status'] != 'Active'){
            $this->error = true;
            $this->errorDescription = 'Only active can be renewed';
            return false;
        }
        if ($this->quotationData['oqq_replaced_by_ID'] > 0){
            $this->error = true;
            $this->errorDescription = 'Already being renewed';
            return false;
        }

        //get the new starting date. One day after previous expiry
        $expiryDate = $this->quotationData['oqq_expiry_date'];
        $expiryDate = explode(' ',$expiryDate);
        $expiryDate = explode('-', $expiryDate[0]);
        $newStartingDate = date('Y-m-d', mktime(0, 0, 0, $expiryDate[1], ($expiryDate[2] + 1), $expiryDate[0]));
        $newExpiry = explode("/",$newExpiry);
        $newExpiryDate = $newExpiry[2]."-".$newExpiry[1]."-".$newExpiry[0];

        //create the quotation. Only the quotation data
        $newData = [];
        foreach($this->quotationData as $name => $value){
            $prefix = substr($name,0,4);
            if ($prefix == 'oqq_'){
                $newData[substr($name,4)] = $value;
            }
        }
        unset($newData['created_date_time']);
        unset($newData['created_by']);
        unset($newData['last_update_date_time']);
        unset($newData['last_update_by']);
        unset($newData['quotations_ID']);
        if ($this->quotationData['oqqt_renewal_issue_new_number'] == 1){
            $newData['number'] = '';
            //echo "here";
        }

        //exit();

        $newData['detail_price_array'] = '';
        $newData['starting_date'] = $newStartingDate;
        $newData['expiry_date'] = $newExpiryDate;
        $newData['status'] = 'Outstanding';
        $newData['replacing_ID'] = $this->quotationID;

        $newID = $db->db_tool_insert_row('oqt_quotations', $newData,'',1, 'oqq_');

        //update current quotation
        $currentNewData['replaced_by_ID'] = $newID;
        $db->db_tool_update_row('oqt_quotations', $currentNewData, 'oqq_quotations_ID = '.$this->quotationID, $this->quotationID, '', 'execute','oqq_');

        //insert the quotation items
        $sql = 'SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = '.$this->quotationID.' ORDER BY oqqit_quotations_items_ID ASC ';
        $result = $db->query($sql);
        while($row = $db->fetch_assoc($result)){
            $itemNewData = $row;

            //clean data
            unset($itemNewData['oqqit_quotations_items_ID']);
            unset($itemNewData['oqqit_created_date_time']);
            unset($itemNewData['oqqit_created_by']);
            unset($itemNewData['oqqit_last_update_date_time']);
            unset($itemNewData['oqqit_last_update_by']);
            $itemNewData['oqqit_quotations_ID'] = $newID;

            $db->db_tool_insert_row('oqt_quotations_items', $itemNewData,'', 0, '');
        }

        echo "New quotations ID ".$newID;

        return true;

    }

    public function isAdvancedEdit(){
        global $db;
        if ($this->quotationData()['oqq_status'] != 'Outstanding'){
            if ($db->user_data['usr_user_rights'] <= 3) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function sendEmail($replaceSubject='',$replaceBody='',$subjectPrefix='',$subjectSuffix='',$bodyPrefix='',$bodySuffix='',$replaceAttachName='')
    {
        global $db,$main;

        $quotationUnderwriter = $db->query_fetch(
            'SELECT * FROM 
                  oqt_quotations_underwriters 
                  WHERE oqun_user_ID = ' . $this->quotationData()['oqq_users_ID']
        );

        include_once('../send_auto_emails/send_auto_emails_class.php');
        if ($this->quotationData['oqqt_active_send_mail'] != '') {

            $autoEmail = new createNewAutoEmail();
            $dataArray['email_to'] = $this->quotationData['oqqt_active_send_mail'];

            if ($replaceSubject == ''){
                $subject = $subjectPrefix.$this->quotationData['oqqt_active_send_mail_subject'].$subjectSuffix;
            }
            else {
                $subject = $replaceSubject;
            }
            $dataArray['email_subject'] = $subject;
            $dataArray['email_cc'] = $this->quotationData['oqqt_active_send_mail_cc'];
            $dataArray['email_bcc'] = $this->quotationData['oqqt_active_send_mail_bcc'];
            if ($replaceBody == ''){
                $body = $bodyPrefix.$this->quotationData['oqqt_active_send_mail_body'].$bodySuffix;
            }
            else {
                $body = $replaceBody;
            }
            $dataArray['email_body'] = $body;
            $dataArray['type'] = $this->getQuotationType();
            $dataArray['primary_serial'] = $this->quotationID;
            $dataArray['primary_label'] = $this->getQuotationType() . " SERIAL";
            $dataArray['secondary_serial'] = '';
            $dataArray['secondary_label'] = '';
            $dataArray['user_ID'] = $this->quotationData['oqq_users_ID'];
            //file attachment filename
            $attachment_file_name = $this->quotationData['oqqt_attach_print_filename'];
            if ($replaceAttachName != ''){
                $attachment_file_name = $replaceAttachName;
            }

            //fix the subject/body with the ReplaceCodes
            //[QTID]
            $dataArray['email_subject'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['email_body']);
            $attachment_file_name = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $attachment_file_name);


            //[QTNUMBER]
            $dataArray['email_subject'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['email_body']);
            $attachment_file_name = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $attachment_file_name);

            //[QTLINK]
            $link = $main["site_url"]."/dynamic_quotations/quotations_modify.php?quotation_type=".$this->quotationData['oqq_quotations_type_ID']."&quotation=".$this->quotationData['oqq_quotations_ID'];
            $dataArray['email_subject'] = str_replace('[QTLINK]', $link, $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[QTLINK]', $link, $dataArray['email_body']);

            //[USERNAME]
            $dataArray['email_subject'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['email_body']);
            $attachment_file_name = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $attachment_file_name);

            //[PDFLINK]
            $link = $main["site_url"]."/dynamic_quotations/quotation_print.php?quotation=".$this->quotationData['oqq_quotations_ID']."&pdf=1";
            $dataArray['email_subject'] = str_replace('[PDFLINK]', $link, $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[PDFLINK]', $link, $dataArray['email_body']);

            //[IDENTIFIER]
            $dataArray['email_subject'] = str_replace('[IDENTIFIER]', $this->quotationData['oqq_unique_identifier'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[IDENTIFIER]', $this->quotationData['oqq_unique_identifier'], $dataArray['email_body']);
            $attachment_file_name = str_replace('[IDENTIFIER]', $this->quotationData['oqq_unique_identifier'], $attachment_file_name);

            //file attachment
            if ($this->quotationData['oqqt_attach_print_filename'] != ''){
                //get the pdf data
                include($this->quotationData['oqqt_print_layout']);
                require_once '../vendor/autoload.php';
                $html = getQuotationHTML($this->quotationID);
                $mpdf = new \Mpdf\Mpdf([
                    'default_font' => 'dejavusans'
                ]);

                $mpdf->WriteHTML($html);
                $filename = date('YmdGisu').".pdf";
                $mpdf->Output($main['local_url'].'/send_auto_emails/attachment_files/'.$filename, \Mpdf\Output\Destination::FILE);
                $dataArray['attachment_files'] = $filename."||".$attachment_file_name;
            }

            //create the record
            $autoEmailID = $autoEmail->addData($dataArray);
            //send the email
            $email = new send_auto_emails($autoEmailID);
            $email->send_email();
            if ($email->count_errors > 0){
                $this->errorDescription = 'There was an error sending the email. You can manually resend the email in auto emails.';
                $this->error = true;
            }
        }
    }


    private function createApprovalRecord($description)
    {
        global $db;
        //first check if any other pending lines exists and set them to delete
        $result = $db->query("SELECT * FROM oqt_quotation_approvals WHERE oqqp_quotation_ID = " . $this->quotationID . " AND oqqp_status = 'Pending'");
        while ($row = $db->fetch_assoc($result)) {
            $newData['status'] = 'Delete';
            $db->db_tool_update_row('oqt_quotation_approvals',
                $newData,
                "oqqp_quotation_approval_ID = " . $row['oqqp_quotation_approval_ID'],
                $row['oqqp_quotation_approval_ID'],
                '',
                'execute',
                'oqqp_');
        }

        $appData['quotation_ID'] = $this->quotationID;
        $appData['status'] = 'Pending';
        $appData['description'] = $description;

        $db->db_tool_insert_row('oqt_quotation_approvals', $appData, '', 0, 'oqqp_');

    }

    public function cancelQuotation(){
        global $db;

        if ($this->quotationData['oqqt_enable_cancellation'] != 1){
            $this->error = true;
            $this->errorDescription = 'Cannot cancel from this quotation type. Check quotation types settings.';
            return false;
        }

        if ($this->quotationData['oqq_status'] != 'Active'){
            $this->error = true;
            $this->errorDescription = 'Must be active to cancel this '.$this->getQuotationType();
            return false;
        }

        $newData['status'] = 'Cancelled';
        $db->db_tool_update_row('oqt_quotations', $newData, 'oqq_quotations_ID = '.$this->quotationID,
            $this->quotationID,'','execute','oqq_');

        return true;

    }

}