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
$list->setTable('ev_rooms','EventRooms')
    ->setSqlSelect('evrom_room_ID','ID')
    ->setSqlSelect('evrom_name','Name')
    ->setSqlOrder('evrom_room_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Event Rooms')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Room?')
    ->setMainFieldID('ID')
    ->setModifyLink('room_modify.php?lid=')
    ->setDeleteLink('room_delete.php?lid=')
    ->setCreateNewLink('room_modify.php')
    ->tableFullBuilder();

$db->show_footer();

?>