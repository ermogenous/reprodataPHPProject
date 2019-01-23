<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/6/2018
 * Time: 10:58 ΠΜ
 */


class Transaction
{

    private $TransactionData = array();
    private $LineData = array();
    private $DataLoaded = false;
    private $FormData = array();
    private $ReverseTransactionData = array();

    public function __construct()
    {

    }

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