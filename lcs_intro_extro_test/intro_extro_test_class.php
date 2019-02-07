<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/2/2019
 * Time: 9:25 ΠΜ
 */

Class introExtroTest{

    public $data;
    public $testID;
    public $error = false;
    public $errorDescription;

    function __construct($id)
    {
        global $db;
        $this->testID = $id;
        if ($this->testID > 0 && is_numeric($this->testID) == true){
            $this->data = $db->query_fetch('SELECT * FROM lcs_intro_extro_test WHERE ietst_intro_extro_test_ID = '.$id);
        }
        else {
            $this->error = true;
            $this->errorDescription[] = 'Must provide valid ID';
            return false;
        }

    }

    function verifyCompletion(){

        if ($this->data['ietst_name'] == ''){
            $this->error = true;
            $this->errorDescription[] = 'Το Όνομα δεν είναι συμπληρωμένο';
        }
        if ($this->data['ietst_tel'] == ''){
            $this->error = true;
            $this->errorDescription[] = 'Το Τηλέφωνο δεν είναι συμπληρωμένο';
        }
        if ($this->data['ietst_email'] == ''){
            $this->error = true;
            $this->errorDescription[] = 'Το Email δεν είναι συμπληρωμένο';
        }

        for ($i=1 ; $i <= 28; $i++){
            if ($this->data['ietst_question_'.$i] != 'A' || $this->data['ietst_question_'.$i] != 'B'){
                $this->error = true;
                $this->errorDescription[] = 'Ερώτηση '.$i.' δεν είναι συμπληρωμένη';
            }
        }
        return $this->error;
    }

    function statusToLink(){
        global $db;
        if ($this->verifyCompletion()){
            if ($this->data['ietst_status'] == 'Outstanding'){
                $newData['status'] = 'Link';
                $db->db_tool_update_row('lcs_intro_extro_test', $newData, "`ietst_intro_extro_test_ID` = " . $this->testID,
                    $this->testID, '', 'execute', 'ietst_');
                return true;
            }
            else {
                $this->error = true;
                $this->errorDescription = 'Status must be Outstanding for change to Link';
                return false;
            }
        }
        else {
            return false;
        }
    }

    function statusToCompleted(){
        global $db;
        if ($this->verifyCompletion()){
            if ($this->data['ietst_status'] == 'Outstanding' || $this->data['ietst_status'] == 'Link'){
                $newData['status'] = 'Completed';
                $db->db_tool_update_row('lcs_intro_extro_test', $newData, "`ietst_intro_extro_test_ID` = " . $this->testID,
                    $this->testID, '', 'execute', 'ietst_');
                return true;
            }
            else {
                $this->error = true;
                $this->errorDescription = 'Status must be Outstanding for change to Completed';
                return false;
            }
        }
        else {
            return false;
        }
    }

    function statusToPaid(){
        global $db;
        if ($this->verifyCompletion()){
            if ($this->data['ietst_status'] == 'Completed'){
                $newData['status'] = 'Paid';
                $db->db_tool_update_row('lcs_intro_extro_test', $newData, "`ietst_intro_extro_test_ID` = " . $this->testID,
                    $this->testID, '', 'execute', 'ietst_');
                return true;
            }
            else {
                $this->error = true;
                $this->errorDescription = 'Status must be Completed for change to Paid';
                return false;
            }
        }
        else {
            return false;
        }
    }


}