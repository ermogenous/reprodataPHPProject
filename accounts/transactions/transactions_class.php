<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/6/2018
 * Time: 10:58 ΠΜ
 */


class AccountsTransaction
{
    private $transactionData = array();
    private $transactionID = 0;
    public $error = false;
    public $errorDescription = '';
    public $documentData;

    //old variables

    private $LineData = array();
    private $DataLoaded = false;
    private $FormData = array();
    private $ReverseTransactionData = array();

    public function __construct($transactionID = 0)
    {
        global $db;
        if ($transactionID > 0){
            $this->transactionID = $transactionID;
            $this->transactionData = $db->query_fetch('
                SELECT * FROM ac_transactions
                LEFT OUTER JOIN ac_documents ON actrn_document_ID = acdoc_document_ID
                LEFT OUTER JOIN ac_accounts ON actrn_account_ID = acacc_account_ID
                WHERE
                actrn_transaction_ID = '.$transactionID.'
                
            ');
        }

    }

    public function lockTransaction(){
        global $db;
        if ($this->transactionID == 0){
            $this->error = true;
            $this->errorDescription = 'Supply transaction id to lock';
            return false;
        }
        if ($this->transactionData['actrn_status'] != 'Outstanding'){
            $this->error = true;
            $this->errorDescription = 'Transaction must be Outstanding to lock';
            return false;
        }

        //check if there is a line with no dr and cr
        $zeroCheck = $db->query_fetch('
            SELECT
            COUNT(*)as clo_total
            FROM
            ac_transaction_lines
            WHERE
            actrl_transaction_ID = '.$this->transactionID.'
            AND actrl_value = 0
        ');
        if ($zeroCheck['clo_total'] > 0){
            $this->error = true;
            $this->errorDescription = 'Transaction with no dr or cr amount found. Please fix.';
            return false;
        }

        //validate that the balance of the lines are 0
        $balanceCheck = $db->query_fetch('
            SELECT
            SUM(
            actrl_dr_cr * actrl_value
            )as clo_total
            FROM
            ac_transaction_lines
            WHERE
            actrl_transaction_ID = '.$this->transactionID);
        if ($balanceCheck['clo_total'] != 0){
            $this->error = true;
            $this->errorDescription = 'Transaction lines do not balance. Total Dr must be equal to Total Cr.';
            return false;
        }

        //ALL OK PROCEED TO LOCK
        $newData['status'] = 'Locked';
        $db->db_tool_update_row('ac_transactions', $newData,
            'actrn_transaction_ID = '.$this->transactionID,
            $this->transactionID,
            '',
            'execute',
            'actrn_');

        return true;
    }

    public function activateTransaction(){
        global $db;

        if ($this->transactionData['actrn_status'] != 'Locked'){
            $this->error = true;
            $this->errorDescription = 'Transaction must be locked to activate it';
            return false;
        }

        //ALL OK PROCEED TO LOCK
        $newData['status'] = 'Active';
        $newData['activated_on'] = date('Y-m-d G:i:s');
        $db->db_tool_update_row('ac_transactions', $newData,
            'actrn_transaction_ID = '.$this->transactionID,
            $this->transactionID,
            '',
            'execute',
            'actrn_');

        return true;

    }

    public function unlockTransaction(){
        global $db;
        if ($this->transactionData['actrn_status'] != 'Locked'){
            $this->error = true;
            $this->errorDescription = 'Transaction must be locked to unlock';
            return false;
        }

        //ALL OK PROCEED TO LOCK
        $newData['status'] = 'Outstanding';
        $db->db_tool_update_row('ac_transactions', $newData,
            'actrn_transaction_ID = '.$this->transactionID,
            $this->transactionID,
            '',
            'execute',
            'actrn_');


        return true;
    }

    public function deleteTransaction(){
        global $db;
        if ($this->transactionData['actrn_status'] != 'Outstanding'){
            $this->error = true;
            $this->errorDescription = 'Transaction must be Outstanding to Delete';
            return false;
        }

        //first delete the lines
        $sql = 'SELECT * FROM ac_transaction_lines WHERE actrl_transaction_ID = '.$this->transactionID;
        $result = $db->query($sql);
        while ($line = $db->fetch_assoc($result)){

            $db->db_tool_delete_row('ac_transaction_lines',
                $line['actrl_transaction_line_ID'],
                'actrl_transaction_line_ID = '.$line['actrl_transaction_line_ID']);

        }

        //delete the transaction
        $db->db_tool_delete_row('ac_transactions', $this->transactionID,
            'actrn_transaction_ID = '.$this->transactionID);

        return true;
    }

    public function makeNewTransaction($headerData,$linesData){
        global $db;

        $error['error'] = false;
        $error['description'] = '';

        //Validate the data
        if ($headerData['documentID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Must supply document ID';
            return false;
        }
        if ($headerData['accountID'] == ''){
            $this->error = true;
            $this->errorDescription = 'Must supply account ID';
            return false;
        }

        //Validate that all Dr/Cr leave a 0 balance
        $dr = 0;
        $cr = 0;

        foreach ($linesData as $value){

            if ($value['type'] == 'Dr'){
                $dr += $value['amount'];
            }
            else if ($value['type'] == 'Cr'){
                $cr += $value['amount'];
            }
            else {
                $this->error = true;
                $this->errorDescription = 'No value Dr/Cr is found';
            }
        }
        if ($dr != $cr){
            $this->error = true;
            $this->errorDescription = 'Dr/Cr do not balance.';
            return false;
        }

        //proceed to create the records
        //1. create the header record in ac_transactions
        $newData['document_ID'] = $headerData['documentID'];
        $newData['account_ID'] = $headerData['accountID'];
        $newData['comments'] = $headerData['comments'];
        $newData['status'] = 'Outstanding';
        $newData['transaction_date'] = date('Y-m-d');
        $newData['reference_date'] = date('Y-m-d');
        $newData['period'] = date('m');
        $newData['year'] = date('Y');
        $newData['from_module'] = $headerData['fromModule'];
        $newData['from_ID_description'] = $headerData['fromIDDescription'];
        $newData['from_ID'] = $headerData['fromID'];

        //generate the number
        $this->loadDocumentData($headerData['documentID']);
        $newNumber = $db->buildNumber(
            $this->documentData['acdoc_number_prefix'],
            $this->documentData['acdoc_number_leading_zeros'],
            $this->documentData['acdoc_number_last_used']);
        //update the document
        $docNewData['number_last_used'] = $this->documentData['acdoc_number_last_used']++;
        $db->db_tool_update_row('ac_documents', $docNewData,
            'acdoc_document_ID = '.$headerData['documentID'],
            $headerData['documentID'],
            '',
            'execute',
            'acdoc_');
        $newData['transaction_number'] = $newNumber;

        //insert the record
        $newHeaderID = $db->db_tool_insert_row('ac_transactions', $newData,'',1,
            'actrn_','execute');

        $lineNumber = 0;
        $drCr = 0;
        foreach ($linesData as $value){
            $lineNumber++;
            if ($value['type'] == 'Dr'){
                $drCr = 1;
            }
            else {
                $drCr = -1;
            }
            $lineData['transaction_ID'] = $newHeaderID;
            $lineData['account_ID'] = $value['accountID'];
            $lineData['line_number'] = $lineNumber;
            $lineData['dr_cr'] = $drCr;
            $lineData['value'] = $value['amount'];
            $lineData['reference'] = $value['reference'];

            $db->db_tool_insert_row('ac_transaction_lines', $lineData,'',0,
                'actrl_','execute');

        }
        return true;

    }

    public function insertAccountsTransaction($postData){
        global $db;

        //first validate the transaction data
        if ($postData['fld_document_ID'] == '' || $postData['fld_document_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Must provide Document Code';
            return false;
        }

        if ($postData['fld_transaction_date'] == ''){
            $this->error = true;
            $this->errorDescription = 'Must provide Document Date';
            return false;
        }

        if ($postData['fld_reference_date'] == ''){
            $this->error = true;
            $this->errorDescription = 'Must provide Reference Date';
            return false;
        }

        //insert the transaction header
        $dataArray['document_ID'] = $postData['fld_document_ID'];
        $dataArray['transaction_date'] = $db->convert_date_format($postData['fld_transaction_date'],'dd/mm/yyyy','yyyy-mm-dd');
        $dataArray['reference_date'] = $db->convert_date_format($postData['fld_reference_date'],'dd/mm/yyyy','yyyy-mm-dd');
        $dataArray['account_ID'] = $postData['fld_account_ID'];
        $dataArray['status'] = 'Outstanding';
        $dataArray['period'] = $db->dbSettings['ac_open_period']['value'];
        $dataArray['year'] = $db->dbSettings['ac_open_year']['value'];
        $dataArray['comments'] = '';
        //generate the number
        $this->loadDocumentData($postData['fld_document_ID']);
        $newNumber = $db->buildNumber(
            $this->documentData['acdoc_number_prefix'],
            $this->documentData['acdoc_number_leading_zeros'],
            $this->documentData['acdoc_number_last_used']);
        //update the document
        $docNewData['number_last_used'] = $this->documentData['acdoc_number_last_used']++;
        $db->db_tool_update_row('ac_documents', $docNewData,
            'acdoc_document_ID = '.$postData['fld_document_ID'],
            $postData['fld_document_ID'],
            '',
            'execute',
            'acdoc_');
        $dataArray['transaction_number'] = $newNumber;

        $transactionNewID = $db->db_tool_insert_row('ac_transactions', $dataArray,'',1,'actrn_');

        //insert the lines
        //get the total account lines in the form. if not set then use 15
        if ($postData['totalAccountLines'] == ''){
            $totalAccountLines = 15;
        }
        else {
            $totalAccountLines = $postData['totalAccountLines'];
        }

        $lineNum = 0;
        for($line = 1; $line <= $totalAccountLines; $line++){
            if ($postData['activeLine_'.$line] == 1){
                $lineNum++;
                //prepare the data
                if ($postData['accLine_debit_'.$line] > 0){
                    $value = $postData['accLine_debit_'.$line];
                    $debitCredit = 1;
                }
                else {
                    $value = $postData['accLine_credit_'.$line];
                    $debitCredit = -1;
                }

                //init the data
                $lineData = [];
                $lineData['transaction_ID'] =   $transactionNewID;
                $lineData['account_ID'] =       $postData['accLine_account_ID_'.$line];
                $lineData['dr_cr'] =            $debitCredit;
                $lineData['value'] =            $value;
                $lineData['line_number'] =      $lineNum;
                $lineData['reference'] =        $postData['accLine_reference_'.$line];
                //insert the line
                $db->db_tool_insert_row('ac_transaction_lines', $lineData,'',0,'actrl_');
            }//if line is active. if not ignore the line
        }
        return true;
    }

    public function updateAccountsTransaction($postData){
        global $db;
        //first validate the transaction data
        if ($postData['fld_document_ID'] == '' || $postData['fld_document_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Must provide Document Code';
            return false;
        }

        if ($postData['fld_transaction_date'] == ''){
            $this->error = true;
            $this->errorDescription = 'Must provide Document Date';
            return false;
        }

        if ($postData['fld_reference_date'] == ''){
            $this->error = true;
            $this->errorDescription = 'Must provide Reference Date';
            return false;
        }

        //update the transaction header
        $dataArray['document_ID'] = $postData['fld_document_ID'];
        $dataArray['transaction_date'] = $db->convert_date_format($postData['fld_transaction_date'],'dd/mm/yyyy','yyyy-mm-dd');
        $dataArray['reference_date'] = $db->convert_date_format($postData['fld_reference_date'],'dd/mm/yyyy','yyyy-mm-dd');
        $dataArray['account_ID'] = $postData['fld_account_ID'];
        $dataArray['period'] = $db->dbSettings['ac_open_period']['value'];
        $dataArray['year'] = $db->dbSettings['ac_open_year']['value'];
        $dataArray['comments'] = '';
        //update the record
        $db->db_tool_update_row('ac_transactions', $dataArray,
            'actrn_transaction_ID = '.$postData['lid'],
            $postData['lid'],
            '',
            'execute',
            'actrn_');

        //update the lines
        //get the total account lines in the form. if not set then use 15
        if ($postData['totalAccountLines'] == ''){
            $totalAccountLines = 15;
        }
        else {
            $totalAccountLines = $postData['totalAccountLines'];
        }

        $lineNum = 0;
        for($line = 1; $line <= $totalAccountLines; $line++) {
            if ($postData['activeLine_' . $line] == 1) {
                $lineNum++;
                //prepare the data
                if ($postData['accLine_debit_'.$line] > 0){
                    $value = $postData['accLine_debit_'.$line];
                    $debitCredit = 1;
                }
                else {
                    $value = $postData['accLine_credit_'.$line];
                    $debitCredit = -1;
                }

                //init the data
                $lineData = [];
                $lineData['account_ID'] =       $postData['accLine_account_ID_'.$line];
                $lineData['dr_cr'] =            $debitCredit;
                $lineData['value'] =            $value;
                $lineData['reference'] =        $postData['accLine_reference_'.$line];
                //insert/update the line
                //check if line exists
                $sql = 'SELECT * FROM ac_transaction_lines 
                  WHERE actrl_transaction_ID = '.$postData['lid'].' AND actrl_line_number = '.$lineNum;
                $check = $db->query_fetch($sql);
                //echo $sql;exit();
                if ($check['actrl_transaction_line_ID'] > 0){
                    //modify

                    $db->db_tool_update_row('ac_transaction_lines',
                        $lineData,
                        'actrl_transaction_line_ID = '.$check['actrl_transaction_line_ID'],
                        $check['actrl_transaction_line_ID'],
                        '',
                        'execute',
                        'actrl_');

                }
                else {
                    //insert
                    $lineData['transaction_ID'] = $postData['lid'];
                    $lineData['line_number'] = $lineNum;

                    $db->db_tool_insert_row('ac_transaction_lines',
                        $lineData,
                        '',
                        0,
                        'actrl_');

                }

            }

        }//for loop

        //now loop after the last linenum and delete any other records left
        $lineNum++;
        for ($i=$lineNum; $i <= $totalAccountLines; $i++){
            $sql = 'SELECT * FROM ac_transaction_lines 
                  WHERE actrl_transaction_ID = '.$postData['lid'].' AND actrl_line_number = '.$i;
            $check = $db->query_fetch($sql);

            //check if a line exists. if yes then delete the line
            if ($check['actrl_transaction_line_ID'] > 0){

                $db->db_tool_delete_row('ac_transaction_lines',
                    $check['actrl_transaction_line_ID'],
                    'actrl_transaction_line_ID = '.$check['actrl_transaction_line_ID']);

            }
        }//for loop

        return true;

    }

    private function loadDocumentData($documentID){
        global $db;
        $sql = 'SELECT * FROM ac_documents WHERE acdoc_document_ID = '.$documentID;
        $this->documentData = $db->query_fetch($sql);
    }

    //OLD FUNCTION FOR REPRODATA - NEEDS CHECKING

    public function loadTransactionDataFromForm($data)
    {
        $this->FormData = $data;

        if (count($data) > 0) {
            //remove the fld_ from the field names. Get only fields with fld_ prefix
            foreach($data as $name => $value) {
                if (substr($name,0,4) == 'fld_'){
                    $newName = substr($name,4);
                    $this->TransactionData[$newName] = $value;
                }
            }
            $this->DataLoaded = true;
            $this->getTransactionType();
            return true;
        } else {
            return false;
        }

    }

    public function insertTransaction()
    {
        global $db;

        $this->TransactionData["status"] = 'O';
        $transactionNewSerial = $db->db_tool_insert_row('ac_transactions', $this->TransactionData, '', 1, 'actrn_');

        for ($i=0; $i<=100; $i++){
            //check one by one if line exists
            if ($this->FormData['lnd_show_line_'.$i] == 1) {
                $lineData['transaction_ID'] = $transactionNewSerial;
                $lineData['product_ID'] = $this->FormData['lnd_product_line_'.$i];
                $lineData['quantity'] = $this->FormData['lnd_quantity_line_'.$i];
                $lineData['value'] = $this->FormData['lnd_total_line_'.$i];
                //fill automatically by fillLineData
                $lineData['dr_cr'] = 0;
                $lineData['cost_value'] = 0;
                $lineData['tax_value'] = 0;


                //reverse line
                $this->ReverseTransactionData['value'] += $this->FormData['lnd_total_line_'.$i];

                $this->LineData = $lineData;
                $this->fillLineData();

                $db->db_tool_insert_row('ac_transaction_lines', $this->LineData,'',0,'actrl_');
                print_r($this->LineData);
                exit();
            }

        }

    }

    public function fillLineData(){



    }

    private function generateReverse(){

        //$this->ReverseTransactionData['']

    }

    private function getTransactionType(){
        if ($this->TransactionData['type'] == 'Purchase'){
            $this->TransactionData['dr_cr'] = -1;
        }
        else if ($this->TransactionData['type'] == 'Sale'){
            $this->TransactionData['dr_cr'] = 1;
        }
    }

    public function verifyTransactionData()
    {
        if ($this->DataLoaded === true) {

            print_r($this->TransactionData);

        } else {
            return 'empty';
        }


    }

}