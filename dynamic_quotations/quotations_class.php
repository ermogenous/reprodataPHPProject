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
                $this->errorDescription .= '<b>Must fix errors before activating.</b>';
            }

        }

        //check if needs approval
        $this->checkForApproval();

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
            $newData['number'] = $this->issueNumber();

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

    private function sendEmail()
    {
        global $db,$main;
        include_once('../send_auto_emails/send_auto_emails_class.php');
        if ($this->quotationData['oqqt_active_send_mail'] != '') {

            $autoEmail = new createNewAutoEmail();
            $dataArray['email_to'] = $this->quotationData['oqqt_active_send_mail'];

            $dataArray['email_subject'] = $this->quotationData['oqqt_active_send_mail_subject'];
            $dataArray['email_cc'] = $this->quotationData['oqqt_active_send_mail_cc'];
            $dataArray['email_bcc'] = $this->quotationData['oqqt_active_send_mail_bcc'];
            $dataArray['email_body'] = $this->quotationData['oqqt_active_send_mail_body'];
            $dataArray['type'] = $this->getQuotationType();
            $dataArray['primary_serial'] = $this->quotationID;
            $dataArray['primary_label'] = $this->getQuotationType() . " SERIAL";
            $dataArray['secondary_serial'] = '';
            $dataArray['secondary_label'] = '';
            $dataArray['user_ID'] = $this->quotationData['oqq_users_ID'];
            //file attachment
            if ($this->quotationData['oqqt_attach_print_filename'] != ''){
                $dataArray['attachment_string_name'] = $this->quotationData['oqqt_attach_print_filename'];

                //get the pdf data
                include($this->quotationData['oqqt_print_layout']);
                require_once '../vendor/autoload.php';
                $html = getQuotationHTML($this->quotationID);
                $mpdf = new \Mpdf\Mpdf([
                    'default_font' => 'dejavusans'
                ]);
                $mpdf->WriteHTML($html);
                $dataArray['attachment_string'] = $mpdf->Output('filename.pdf', \Mpdf\Output\Destination::STRING_RETURN);
                //echo "DATA STRING<br>\n\n\n\n\n".$dataArray['attachment_string'];exit();
            }

            //fix the subject/body with the ReplaceCodes
            //[QTID]
            $dataArray['email_subject'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['email_body']);
            $dataArray['attachment_string_name'] = str_replace('[QTID]', $this->quotationData['oqq_quotations_ID'], $dataArray['attachment_string_name']);


            //[QTNUMBER]
            $dataArray['email_subject'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['email_body']);
            $dataArray['attachment_string_name'] = str_replace('[QTNUMBER]', $this->quotationData['oqq_number'], $dataArray['attachment_string_name']);

            //[QTLINK]
            $link = $main["site_url"]."/dynamic_quotations/quotations_modify.php?quotation_type=".$this->quotationData['oqq_quotations_type_ID']."&quotation=".$this->quotationData['oqq_quotations_ID'];
            $dataArray['email_subject'] = str_replace('[QTLINK]', $link, $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[QTLINK]', $link, $dataArray['email_body']);

            //[USERNAME]
            $dataArray['email_subject'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['email_body']);
            $dataArray['attachment_string_name'] = str_replace('[USERSNAME]', $this->quotationData['usr_name'], $dataArray['attachment_string_name']);

            //[PDFLINK]
            $link = $main["site_url"]."/dynamic_quotations/quotation_print.php?quotation=".$this->quotationData['oqq_quotations_ID']."&pdf=1";
            $dataArray['email_subject'] = str_replace('[PDFLINK]', $link, $dataArray['email_subject']);
            $dataArray['email_body'] = str_replace('[PDFLINK]', $link, $dataArray['email_body']);

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
                "oqqp_quotation_permission_ID = " . $row['oqqp_quotation_permission_ID'],
                $row['oqqp_quotation_permission_ID'],
                '',
                'execute',
                'oqqp_');
        }

        $appData['quotation_ID'] = $this->quotationID;
        $appData['status'] = 'Pending';
        $appData['description'] = $description;
        $db->db_tool_insert_row('oqt_quotation_approvals', $appData, '', 0, 'oqqp_');

    }

}