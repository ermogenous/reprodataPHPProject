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
          SELECT 
          * 
          ,DATE_ADD(agr_expiry_date, INTERVAL 1 Day)as clo_review_starting_date
          FROM 
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
                    //print_r($this->itemsStock);
                    if ($this->itemsStock[$i]['totalFound'] > $this->itemsStock[$i]['currentStock']){
                        $this->errorCode = 'LockNotEnoughStock';
                        $this->errorDescription = 'Cannot lock because not enough stock exists.';
                        return false;
                    }

                    //check if the unique serial is defined
                    $uqsData = $db->query_fetch("SELECT * FROM unique_serials 
                    WHERE `uqs_agreement_number` = '" . $this->agreementData['agr_agreement_number'] . "' 
                    AND `uqs_line_number` = " . $this->itemsData[$i]['agri_line_number']);
                    if ($uqsData['uqs_unique_serial_ID'] == ''){
                        $this->errorCode = 'LockLine'.$i.'UniqueSerialNotDefined';
                        $this->errorDescription = 'Cannot lock because unique serial is not defined for line '.$this->itemsData[$i]['agri_line_number'].'.';
                        return false;
                    }
                }



                $data['status'] = 'Locked';
                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');

                //update the stock
                for($i=0; $i < $this->totalItems; $i++){
                    //print_r($this->itemsData);
                    $stock = new Stock($this->itemsData[$i]['agri_product_ID']);
                    $stock->disableCommit = true;
                    //if new policy always add/remove stock
                    if($this->agreementData['agr_process_status'] == 'New'){
                        $stock->addRemoveStock(-1, 'Agreement Lock '.$this->agreementData['agr_agreement_number']);
                    }
                    else {
                        //check in the agri_add_remove_stock
                        if ($this->itemsData[$i]['agri_add_remove_stock'] != 0){
                            $stock->addRemoveStock($this->itemsData[$i]['agri_add_remove_stock'],
                                'Agreement Lock '.$this->agreementData['agr_agreement_number']);
                        }
                    }
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
                if($this->agreementData['agr_process_status'] == 'New'){
                    $stock->addRemoveStock(1, 'Agreement UnLock '.$this->agreementData['agr_agreement_number']);
                }
                else {
                    if ($this->itemsData[$i]['agri_add_remove_stock'] != 0){
                        $stock->addRemoveStock($this->itemsData[$i]['agri_add_remove_stock'] * -1,
                            'Agreement UnLock '.$this->agreementData['agr_agreement_number']);
                    }
                }
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

                //if agr_replacing_agreement_ID then we need to change the status of the previous
                if ($this->agreementData['agr_replacing_agreement_ID'] > 0) {
                    $prevData['status'] = 'Archived';
                    $db->db_tool_update_row('agreements', $prevData,
                        'agr_agreement_ID = '.$this->agreementData['agr_replacing_agreement_ID'],
                        $this->agreementData['agr_replacing_agreement_ID'], '',
                        'execute','agr_');
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

            //if is replacing another policy needs to fix it
            if ($this->agreementData['agr_replacing_agreement_ID'] > 0){
                $fData['replaced_by_agreement_ID'] = 0;
                $db->db_tool_update_row('agreements', $fData,
                    'agr_agreement_ID = '.$this->agreementData['agr_replacing_agreement_ID'],
                    $this->agreementData['agr_replacing_agreement_ID'],
                    '',
                    'execute','agr_');
            }

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

    private function makeAgreementCopy($processStatus, $startingDate, $expiryDate){
        global $db;
        $db->working_section = 'Agreements Functions makeAgreementCopy';
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
        $db->db_tool_update_row('agreements', $oldData, 'agr_agreement_ID = '.$this->agreementID,
            $this->agreementID,'', 'execute', 'agr_');

        //insert lines
        //loop into them
        for ($i=0; $i < $this->totalItems; $i++){

            $lineNewData["agreement_ID"] = $this->copyAgreementID;
            $lineNewData["product_ID"] = $this->itemsData[$i]["agri_product_ID"];
            $lineNewData["line_number"] = $this->itemsData[$i]["agri_line_number"];
            $lineNewData["agreement_type"] = $this->itemsData[$i]["agri_agreement_type"];
            $lineNewData["per_copy_black_cost"] = $this->itemsData[$i]["agri_per_copy_black_cost"];
            $lineNewData["per_copy_color_cost"] = $this->itemsData[$i]["agri_per_copy_color_cost"];
            $lineNewData["rent_cost"] = $this->itemsData[$i]["agri_rent_cost"];
            $lineNewData["status"] = 'Active';
            $lineNewData["process_status"] = $processStatus;

            //do not insert if the line is deleted
            if ($this->itemsData[$i]['agri_status'] == 'Active'){
                $db->db_tool_insert_row('agreement_items', $lineNewData,'',1
                    ,'agri_');
            }



        }

        if ($this->disableCommit == false){
            $db->commit_transaction();
        }
        return $this->copyAgreementID;

    }

    public function switchFromCopy(){

    }

    public function reviewAgreement($expiryDate){
        global $db;
        if ($this->agreementData['agr_status'] != 'Active'){
            $this->errorCode = "ReviewNotActive";
            $this->errorDescription = "Only active agreements can be reviewed";
            return 0;
        }
        if ($this->agreementData['agr_replaced_by_agreement_ID'] > 0){
            $this->errorCode = "ReviewAlreadyReplaced";
            $this->errorDescription = "This agreement seems to be already replaced. Cannot review";
            return 0;
        }
        //check if expiry date is after starting date
        $startingDate = $db->convertDateToNumber($this->agreementData["clo_review_starting_date"], 'yyyy-mm-dd');
        $expiryDate = $db->convertDateToNumber($expiryDate, 'yyyy-mm-dd');

        if ($expiryDate <= $startingDate){
            $this->errorCode = "ReviewExpiryBeforeStarting";
            $this->errorDescription = "Expiry Date is before starting date";
            return 0;
        }

        return $this->makeAgreementCopy('Renewal', $this->agreementData['clo_review_starting_date'],$expiryDate);
    }

    public function endorseAgreement($startingDate){
        global $db;
        if ($this->agreementData['agr_status'] != 'Active'){
            $this->errorCode = "EndorseNotActive";
            $this->errorDescription = "Only active agreements can be endorsed";
            return 0;
        }
        if ($this->agreementData['agr_replaced_by_agreement_ID'] > 0){
            $this->errorCode = "EndorseAlreadyReplaced";
            $this->errorDescription = "This agreement seems to be already replaced. Cannot endorse";
            return 0;
        }
        //check if expiry date is after starting date
        $startingDateNum = $db->convertDateToNumber($startingDate, 'yyyy-mm-dd');
        $expiryDateNum = $db->convertDateToNumber($this->agreementData['agr_expiry_date'], 'yyyy-mm-dd');
        $currentStartingDateNum = $db->convertDateToNumber($this->agreementData['agr_starting_date'], 'yyyy-mm-dd');

        if ($startingDateNum < $currentStartingDateNum){
            $this->errorCode = "EndorseBeforeStartingDate";
            $this->errorDescription = "Endorsement date cannot be before agreements starting date";
            return 0;
        }
        if ($startingDateNum > $expiryDateNum){
            $this->errorCode = "EndorseAfterExpiryDate";
            $this->errorDescription = "Endorsement date cannot be after agreements expiry date";
            return 0;
        }


        return $this->makeAgreementCopy('Endorsement', $startingDate, $this->agreementData['agr_expiry_date']);
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