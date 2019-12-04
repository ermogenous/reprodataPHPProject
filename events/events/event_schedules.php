<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/11/2019
 * Time: 12:40 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Locations";

if ($_GET['layout'] == 'blank'){
    $db->show_empty_header();
}else {
    $db->show_header();
}


//$table = new draw_table('ac_transactions', 'actrn_transaction_ID', 'ASC');

//$table->generate_data();

$list = new TableList();
$list->setTable('ev_event_schedules','EventEventSchedules');
if ($_GET['layout'] != 'blank'){
    $list->setSqlSelect('evsch_event_schedule_ID','ID')
        ->setSqlSelect('evevt_title','Event Title');
}

    $list->setSqlSelect('evsch_start_date_time', 'Start Date',['functionName' => 'convertDateToEu'])
    ->setSqlSelect('evsch_end_date_time', 'End Date',['functionName' => 'convertDateToEu'])
    ->setSqlFrom('JOIN ev_events ON evevt_event_ID = evsch_event_ID')
    ->setSqlOrder('evsch_event_schedule_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Event - Events - Schedules')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this schedule?')
    ->setMainFieldID('ID')
    ->setModifyLink('event_schedule_modify.php?lid='.$_GET['lid']."&eid=")
    ->setDeleteLink('event_schedule.php?lid='.$_GET['lid']."&eid=")
    ->setCreateNewLink('event_schedule_modify.php?lid='.$_GET['lid'])
    ->tableFullBuilder();

function convertDateToEu($data){
    global $db;
    return $db->convertDateToEU($data,1,1);
}
if ($_GET['layout'] == 'blank'){
    $db->show_empty_footer();
}else {
    $db->show_footer();
}


?>