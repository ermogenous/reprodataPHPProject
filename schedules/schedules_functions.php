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

function generateMyscheduleDataScript($userID, $startDate){
    global $db;
    //echo "Here";
    //get the data from db
    $sql = "SELECT * FROM 
            schedules 
            JOIN schedule_ticket ON sch_schedule_ID = scht_schedule_ID
            JOIN tickets ON tck_ticket_ID = scht_ticket_ID
            JOIN customers ON cst_customer_ID = tck_customer_ID
            WHERE sch_user_ID = ".$userID." AND sch_schedule_date >= '".$startDate."' ORDER BY sch_schedule_date ASC";
    $result = $db->query($sql);
    while($row = $db->fetch_assoc($result)){
        $data .= "
        {
            id:".$row['sch_schedule_ID'].",
            title: '".$row['sch_schedule_number']." - ".$row['cst_name']." ".$row['cst_surname']."',
            start: '".$row['sch_schedule_date']." ".$row['scht_time']."',
            url: 'schedule_modify.php?lid=".$row['sch_schedule_ID']."'
        },\n";
    }
    $data = $db->remove_last_char($data);
    $data = $db->remove_last_char($data);
    return $data;

}