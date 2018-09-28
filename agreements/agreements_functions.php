<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/9/2018
 * Time: 10:42 ΠΜ
 */

class Agreements {

    public $agreementID;
    public $agreementData;
    public $status;
    public $totalItems;
    public $itemsData;

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
        $sql = "SELECT * FROM agreement_items WHERE agri_agreement_ID = ".$agreementID." ORDER BY agri_line_number ASC";
        $result = $db->query($sql);
        $this->totalItems = 0;
        while ($row = $db->fetch_assoc($result)) {
            $this->totalItems++;
            $this->itemsData[] = $row;
        }

    }

    public function lockAgreement(){
        global $db;
        $db->start_transaction();
        if ($this->status == 'Pending'){
            //check if has any items
            if ($this->totalItems > 0){
                $data['status'] = 'Locked';
                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');
                $db->commit_transaction();
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
        $db->start_transaction();
        if ($this->status == 'Locked'){
            //check if has any items
                $data['status'] = 'Pending';
                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');
                $db->commit_transaction();
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
        $db->start_transaction();
        if ($this->status == 'Locked'){
            if ($this->totalItems > 0){
                $data['status'] = 'Active';
                $data['activated_period'] = $db->get_setting('stk_active_month');
                $data['activated_year'] = $db->get_setting('stk_active_year');
                $data['activated_by'] = $db->user_data['usr_users_ID'];

                $db->db_tool_update_row('agreements', $data,
                    'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                    'execute','agr_');
                $db->commit_transaction();
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
        $db->start_transaction();
        if ($this->status == 'Pending'){
            $data['status'] = 'Deleted';

            $db->db_tool_update_row('agreements', $data,
                'agr_agreement_ID = '.$this->agreementID, $this->agreementID, '',
                'execute','agr_');
            $db->commit_transaction();
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