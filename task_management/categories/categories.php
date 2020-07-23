<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 16/07/2020
 * Time: 14:35
 */

include("../../include/main.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Task Management - Categories Admin";

$db->show_header();


$list = new TableList();
$list->setTable('tsm_categories', 'TaskManagementCategories')
    ->setSqlSelect('tsm_categories.tsmct_category_ID', 'ID')
    ->setSqlSelect('tsm_categories.tsmct_type', 'Type')
    ->setSqlSelect('owner.tsmct_code', 'Owner')
    ->setSqlSelect('tsm_categories.tsmct_code', 'Code')
    ->setSqlSelect('tsm_categories.tsmct_name', 'Name')
    ->setSqlSelect('tsm_categories.tsmct_status', 'Status')
    ->setSqlFrom('LEFT OUTER JOIN tsm_categories as owner ON tsm_categories.tsmct_owner_ID = owner.tsmct_category_ID')
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('tsm_categories.tsmct_type ASC, tsm_categories.tsmct_code', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Task Management - Categories')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Category?')
    ->setMainFieldID('ID')
    ->setModifyLink('category_modify.php?lid=')
    ->setDeleteLink('category_delete.php?lid=')
    ->setCreateNewLink('category_modify.php')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_footer();
