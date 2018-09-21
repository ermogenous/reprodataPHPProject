<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/9/2018
 * Time: 10:42 ΠΜ
 */


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