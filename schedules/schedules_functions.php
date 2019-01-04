<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 04-Jan-19
 * Time: 6:33 PM
 */


function issueScheduleNumber(){
    global $db;

    //get the current number
    $lastUsed = $db->get_setting('sch_schedule_number_last_used');
    $leadingZeros = $db->get_setting('sch_schedule_number_leading_zeros');
    $prefix = $db->get_setting('sch_schedule_number_prefix');

    //increment the number
    $lastUsed++;

    //get the full number
    $newNumber = $db->buildNumber($prefix, $leadingZeros, $lastUsed);

    //update the settings
    //$db->start_transaction();
    $db->update_setting('sch_schedule_number_last_used', $lastUsed);
    //$db->commit_transaction();
    return $newNumber;
}