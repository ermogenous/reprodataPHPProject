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
$list->setTable('ev_branches','EventBranches')
    ->setSqlSelect('evbrh_branch_ID','ID')
    ->setSqlSelect('evbrh_name','Name')
    ->setSqlOrder('evbrh_branch_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Event Branches')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Branch?')
    ->setMainFieldID('ID')
    ->setModifyLink('branch_modify.php?lid=')
    ->setDeleteLink('branch_delete.php?lid=')
    ->setCreateNewLink('branch_modify.php')
    ->tableFullBuilder();

$db->show_footer();

?>