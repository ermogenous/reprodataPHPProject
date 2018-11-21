<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 4:10 ΜΜ
 */

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