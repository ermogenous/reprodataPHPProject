<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/9/2018
 * Time: 10:42 ΠΜ
 */

include ("../stock/stock.class.php");

class Agreements {

    public $agreementID;
    public $copyAgreementID;
    public $agreementData;
    public $copyAgreementData;
    public $status;
    public $totalItems;
    public $itemsData;
    public $itemsStock;
    public $disableCommit = false;

    public $errorCode;
    public $errorDescription;

    function __construct($agreementID)
    {
        global $db;
        $this->agreementID = $agreementID;
        $this->agreementData = $db->query_fetch('
          SELECT * FROM 
          agreements
          JOIN customers ON cst_customer_ID = agr_customer_ID
          WHERE agr_agreement_ID = '.$agreementID);
        $this->status = $this->agreementData['agr_status'];

        //items
        $sql = "SELECT * FROM 
                agreement_items 
                JOIN products ON prd_product_ID = agri_product_ID
                WHERE agri_agreement_ID = ".$agreementID." ORDER BY agri_line_number ASC";
        $result = $db->query($sql);
        $this->totalItems = 0;
        while ($row = $db->fetch_assoc($result)) {
            $this->totalItems++;
            $this->itemsData[] = $row;
            $this->itemsStock[$row["agri_product_ID"]]['currentStock'] = $row['prd_current_stock'];
            $this->itemsStock[$row["agri_product_ID"]]['totalFound']++;
        }

    }

    public function lockAgreement(){
        global $db;
        if ($this->disableCommit == false){
            $db->start_transaction();
        }

        if ($this->status == 'Pending'){
            //check if has any items
            if ($this->totalItems > 0){

                //check if there is enough stock to lock this agreement
                for($i=0; $i < $this->totalItems; $i++){
                    print_r($this->itemsStock);
                    if ($this->itemsStock[$i]['totalFound'] > $this->itemsStock[$i]['currentStock']){
                        $this->errorCode = 'LockNotEnoughStock';
                        $this->errorDescription = 'Cannot lock because not enough stock exists.';
                        return false;
                    }
                }
                exit();

                $data['status'] = 'Locked';
                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');

                //update the stock
                for($i=0; $i < $this->totalItems; $i++){
                    $stock = new Stock($this->itemsData[$i]['agri_product_ID']);
                    $stock->disableCommit = true;
                    $stock->addRemoveStock(-1, 'Agreement Lock '.$this->agreementData['agr_agreement_number']);
                }

                if ($this->disableCommit == false) {
                    $db->commit_transaction();
                }
                return true;
            }else {
                $this->errorCode = 'LockNoItems';
                $this->errorDescription = 'Cannot lock because no items found';
                return false;
            }
        }
        else {
            $this->errorCode = 'LockNotPending';
            $this->errorDescription = 'Cannot lock other than pending agreements';
            return false;
        }
    }

    public function unLockAgreement(){
        global $db;
        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        if ($this->status == 'Locked'){
            //check if has any items
                $data['status'] = 'Pending';
                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');


            //update the stock
            for($i=0; $i < $this->totalItems; $i++){
                $stock = new Stock($this->itemsData[$i]['agri_product_ID']);
                $stock->disableCommit = true;
                $stock->addRemoveStock(1, 'Agreement UnLock '.$this->agreementData['agr_agreement_number']);
            }
            if ($this->disableCommit == false) {
                $db->commit_transaction();
            }
                return true;
        }
        else {
            $this->errorCode = 'UnLockNotLocked';
            $this->errorDescription = 'Cannot un-lock other than locked agreements';
            return false;
        }
    }

    public function activateAgreement(){
        global $db;
        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        if ($this->status == 'Locked'){
            if ($this->totalItems > 0){
                $data['status'] = 'Active';
                $data['activated_period'] = $db->get_setting('stk_active_month');
                $data['activated_year'] = $db->get_setting('stk_active_year');
                $data['activated_by'] = $db->user_data['usr_users_ID'];

                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');
                if ($this->disableCommit == false) {
                    $db->commit_transaction();
                }
                return true;
            }
            else {
                $this->errorCode = 'ActivateNoItems';
                $this->errorDescription = 'Need items to activate an agreement';
            }
        }
        else {
            $this->errorCode = 'ActivateNotLocked';
            $this->errorDescription = 'Only locked agreements can be activated';
            return false;
        }
    }

    public function expireAgreement(){
        if ($this->status == 'Active'){

        }
    }

    public function deleteAgreement(){
        global $db;
        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        if ($this->status == 'Pending'){
            $data['status'] = 'Deleted';

            $db->db_tool_update_row('agreements', $data,
                'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                'execute','agr_');
            if ($this->disableCommit == false) {
                $db->commit_transaction();
            }
            return true;
        }
        else {
            $this->errorCode = 'DeleteNotPending';
            $this->errorDescription = 'Can only delete pending agreements';
            return false;
        }
    }

    public function cancelAgreement(){
        if ($this->status == 'Active'){

        }
    }

    public function makeAgreementCopy($processStatus, $startingDate, $expiryDate){
        global $db;
        //create the new data for the new record
        $newData["customer_ID"] = $this->agreementData["agr_customer_ID"];
        $newData["status"] = "Pending";
        $newData["process_status"] = $processStatus;
        $newData["starting_date"] = $startingDate;
        $newData["expiry_date"] = $expiryDate;
        $newData["agreement_number"] = $this->agreementData["agr_agreement_number"];
        $newData["replacing_agreement_ID"] = $this->agreementData["agr_agreement_ID"];
        $newData["replaced_by_agreement_ID"] = "";

        if ($this->disableCommit == false){
            $db->start_transaction();
        }

        $this->copyAgreementID = $db->db_tool_insert_row('agreements', $newData,'',1
        ,'agr_');

        //update the old policy
        $oldData["replaced_by_agreement_ID"] = $this->copyAgreementID;
        $db->db_tool_update_row('agreement', $oldData, 'agr_agreement_ID = '.$this->agreementID,
            $this->agreementID,'', 'execute', 'agr_');

        //insert lines


        if ($this->disableCommit == false){
            $db->commit_transaction();
        }

    }

    public function switchFromCopy(){

    }

    public function issueRenewal(){

    }

    public function issueEndorsement(){

    }


}


function issueAgreementNumber(){

    global $db;

    //get the current number
    $lastUsed = $db->get_setting('agr_agreement_number_last_used');
    $leadingZeros = $db->get_setting('agr_agreement_number_leading_zeros');
    $prefix = $db->get_setting('agr_agreement_number_prefix');

    //increment the number
    $lastUsed++;

    //get the full number
    $newNumber = $db->buildNumber($prefix, $leadingZeros, $lastUsed);

    //update the settings
    //$db->start_transaction();
    $db->update_setting('agr_agreement_number_last_used', $lastUsed);
    //$db->commit_transaction();
    return $newNumber;

}

function getAgreementColor($status){
    return "agr".$status."Color";
}