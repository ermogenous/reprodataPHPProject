<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/11/2019
 * Time: 10:06 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Locations";


$db->show_header();

//$table = new draw_table('ac_transactions', 'actrn_transaction_ID', 'ASC');

//$table->generate_data();

$list = new TableList();
$list->setTable('ev_events','EventEvents')
    ->setSqlSelect('evevt_event_ID','ID')
    ->setSqlSelect('evevt_title','Title')
    ->setSqlSelect('evrom_name','Room')
    ->setSqlSelect('evhst_name','Host')
    ->setSqlFrom('JOIN ev_branches ON evevt_branch_ID = evbrh_branch_ID')
    ->setSqlFrom('JOIN ev_rooms ON evevt_room_ID = evrom_room_ID')
    ->setSqlFrom('JOIN ev_hosts ON evevt_host_ID = evhst_host_ID')
    ->setSqlOrder('evevt_event_ID', 'DESC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Event - Events')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->addTableColumn('View Schedule', 'scheduleIcon',['thAlign' => 'center','tdAlign' => 'center'])
    ->setDeleteConfirmText('Are you sure you want to delete this Event?')
    ->setMainFieldID('ID')
    ->setModifyLink('event_modify.php?lid=')
    ->setDeleteLink('event_delete.php?lid=')
    ->setCreateNewLink('event_modify.php')
    ->tableFullBuilder();

function convertDateToEu($data){
    global $db;
    return $db->convertDateToEU($data,1,1);
}

function scheduleIcon($data){
    return '
        <a href="event_schedules.php?lid='.$data['ID'].'">
            <i class="far fa-calendar-alt"></i>
        </a>
    ';
}

$db->show_footer();

?>