<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 4:10 ΜΜ
 */

class Tickets {
    public $ticketID;
    public $ticketData;
    public $currentStatus;

    public $errorFound = false;
    public $errorDescription;

    function __construct($ticketID)
    {
        global $db;
        $this->ticketID = $ticketID;
        $sql = "SELECT * FROM tickets WHERE tck_ticket_ID = ".$ticketID;
        $this->ticketData = $db->query_fetch($sql);
        $this->currentStatus = $this->ticketData['tck_status'];
    }

    function makePending(){
        global $db;
        if ($this->currentStatus != 'Outstanding'){
            $this->errorFound = true;
            $this->errorDescription[] = 'Ticket must be outstanding to set as pending';
            return false;
        }
        //check if enough stock exists
        else if ($this->checkStock() == false){
            return false;
        }
        else {
            $newData['status'] = 'Pending';
            $db->db_tool_update_row('tickets',$newData,'tck_ticket_ID = '.$this->ticketID,
                $this->ticketID, '' , 'execute', 'tck_');
            return true;
        }
    }
    //check the stock on all the products related
    function checkStock(){
        global $db;
        $sql = "SELECT * FROM 
        ticket_products 
        LEFT OUTER JOIN products ON prd_product_ID = tkp_product_ID
        WHERE tkp_ticket_ID = ".$this->ticketID;
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)){

            if ($row['tkp_product_ID'] < 0 || $row['tkp_product_ID'] == ''){
                $this->errorFound = true;
                $this->errorDescription[] = 'No product selected.';
            }

            if ($row['prd_current_stock'] < $this->ticketData['tkp_amount']){
                $this->errorFound = true;
                $this->errorDescription[] = 'Not enough stock for product ['.$row['prd_product_ID'].'] '.$row['prd_description'];
            }
        }
        if ($this->errorFound == true){
            return false;
        }
        else {
            return true;
        }
    }
}


function issueTicketNumber(){

    global $db;

    //get the current number
    $lastUsed = $db->get_setting('tck_ticket_number_last_used');
    $leadingZeros = $db->get_setting('tck_ticket_number_leading_zeros');
    $prefix = $db->get_setting('tck_ticket_number_prefix');

    //increment the number
    $lastUsed++;

    //get the full number
    $newNumber = $db->buildNumber($prefix, $leadingZeros, $lastUsed);

    //update the settings
    //$db->start_transaction();
    $db->update_setting('tck_ticket_number_last_used', $lastUsed);
    //$db->commit_transaction();
    return $newNumber;

}