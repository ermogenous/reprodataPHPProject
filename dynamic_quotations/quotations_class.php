<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/4/2019
 * Time: 7:30 ΜΜ
 */

class dynamicQuotation {
    
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
        $this->quotationData = $db->query_fetch('
          SELECT * FROM 
          oqt_quotations
          JOIN oqt_quotations_types ON oqq_quotations_type_ID = oqqt_quotations_types_ID 
          WHERE oqq_quotations_ID = '.$this->quotationID);

        //include function for this quotation type
        include_once($this->quotationData['oqqt_functions_file']);
        
    }
    
    public function quotationData(){
        return $this->quotationData;
    }
    
    public function quotationID(){
        return $this->quotationID;
    }
    
    private function getUnderwriterData(){
        global $db;
        $this->underwriterData = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = '.$db->user_data['usr_users_ID']);
    }

    public function getQuotationType(){
        $label = $this->quotationData['oqqt_quotation_or_cover_note'];
        if ($label == 'CN'){
            $label = 'Cover Note';
        }
        else {
            $label = 'Quotation';
        }
        return $label;
    }

    public function checkForActivation(){
        global $db;

        //1. check if Outstanding
        if ($this->quotationData['oqq_status'] != 'Outstanding'){
            $this->error = true;
            $this->errorDescription = $this->getQuotationType().' Must be Outstanding';
        }

        $customResult = [];
        if (function_exists('activate_custom_validation')){

            $customResult = activate_custom_validation($this->quotationData);
            $this->error = $customResult['error'];
            $this->errorDescription = $customResult['errorDescription'];

            if ($this->error == true){
                $this->errorDescription .= '<b>Must fix errors before activating.</b>';
            }

        }

        //check if needs approval
        $this->checkForApproval();

        //$this->error = true;
        //$this->errorDescription .= ' test';

        if ($this->error == true){
            return false;
        }
        else {
            return true;
        }
    }

    public function activate(){
        global $db;
        if ($this->checkForActivation() == true){
            $newData['status'] = 'Active';
            $newData['effective_date'] = date('Y-m-d G:i:s');
            $db->db_tool_update_row('oqt_quotations', $newData,
                'oqq_quotations_ID = '.$this->quotationID, $this->quotationID,'','execute','oqq_');

            return true;
        }
        else {
            return false;
        }
    }

    public function delete(){
        global $db;
        if ($this->quotationData['oqq_status'] == 'Outstanding'){
            $newData['status'] = 'Deleted';
            $db->db_tool_update_row('oqt_quotations', $newData,
                'oqq_quotations_ID = '.$this->quotationID, $this->quotationID,'','execute','oqq_');
            return true;
        }
        else {
            $this->errorDescription = $this->getQuotationType().' must be Outstanding to delete.';
            $this->error = true;
            return false;
        }
    }

    public function checkForApproval(){
        global $db;
        $needApproval = false;
        //first check if the quotation is outstanding
        if ($this->quotationData['oqq_status'] == 'Outstanding'){

            if (function_exists('customCheckForApproval')){
                $result = customCheckForApproval($this->quotationData);
                $this->error = $result['error'];
                $this->errorDescription = $result['errorDescription'];
                if ($result['error'] == true){
                    $needApproval = true;
                    $this->errorType = 'warning';
                }
            }

            //if approval is found then change the status of the policy to Pending.
            if ($needApproval == true){
                $newData['status'] = 'Pending';
                $db->db_tool_update_row('oqt_quotations', $newData,
                    'oqq_quotations_ID = '.$this->quotationID, $this->quotationID,'','execute','oqq_');

                //insert record in the approvals table
                $this->createApprovalRecord($this->errorDescription);
            }

        }
        else {
            $this->error = true;
            $this->errorDescription = 'Must be outstanding to verify for approval.';
        }

        if ($this->error == true){
            return false;
        }
        else {
            return true;
        }
    }

    private function createApprovalRecord($description){
        global $db;
        //first check if any other pending lines exists and set them to delete
        $result = $db->query("SELECT * FROM oqt_quotation_approvals WHERE oqqp_quotation_ID = ".$this->quotationID." AND oqqp_status = 'Pending'");
        while ($row = $db->fetch_assoc($result)){
            $newData['status'] = 'Delete';
            $db->db_tool_update_row('oqt_quotation_approvals',
                $newData,
                "oqqp_quotation_permission_ID = ".$row['oqqp_quotation_permission_ID'],
                $row['oqqp_quotation_permission_ID'],
                '',
                'execute',
                'oqqp_');
        }

        $appData['quotation_ID'] = $this->quotationID;
        $appData['status'] = 'Pending';
        $appData['description'] = $description;
        $db->db_tool_insert_row('oqt_quotation_approvals', $appData, '', 0,'oqqp_');

    }

}