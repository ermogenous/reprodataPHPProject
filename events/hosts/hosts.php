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
$list->setTable('ev_hosts','EventHosts')
    ->setSqlSelect('evhst_host_ID','ID')
    ->setSqlSelect('evhst_name','Name')
    ->setSqlOrder('evhst_host_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Event Hosts')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Host?')
    ->setMainFieldID('ID')
    ->setModifyLink('host_modify.php?lid=')
    ->setDeleteLink('host_delete.php?lid=')
    ->setCreateNewLink('host_modify.php')
    ->tableFullBuilder();

$db->show_footer();

?>