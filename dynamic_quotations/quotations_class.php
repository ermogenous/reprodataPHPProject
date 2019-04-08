<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/4/2019
 * Time: 7:30 ΜΜ
 */

class dynamicQuotations {
    
    private $quotationData = [];
    private $quotationID;
    private $underwriterData = [];
    private $quotationTypeData = [];

    public $error = false;
    public $errorDescription = '';
    
    function __construct($quotationID)
    {
        global $db;
        $this->quotationID = $quotationID;
        $this->quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = '.$this->quotationID);
        
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

    private function getQuotationTypeData(){
        global $db;
        $this->quotationTypeData = $db->query_fetch('SELECT * FROM oqt_quotations_types WHERE oqqt_quotations_types_ID = '.$this->quotationData['oqq_quotations_type_ID']);
    }
    
    public function checkForActivation(){

        $this->getQuotationTypeData();
        $label = $this->quotationTypeData['oqqt_quotation_or_cover_note'];
        if ($label == 'CN'){
            $label = 'Cover Note';
        }
        else {
            $label = 'Quotation';
        }

        //1. check if Outstanding
        if ($this->quotationData['oqq_status'] != 'Outstanding'){
            $this->error = true;
            $this->errorDescription = $label.' Must be Outstanding';
        }



        if ($this->error == true){
            return false;
        }
        else {
            return true;
        }
    }

}