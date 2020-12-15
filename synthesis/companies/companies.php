<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 03/4/2020
 * Time: 10:47
 */

include("../../include/main.php");
//include("../../include/tables.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Synthesis - Companies";

$db->show_header();

$list = new TableList();
$list->setTable('sy_companies', 'ID')
    ->setSqlSelect('syco_company_ID', 'ID')
    ->setSqlSelect('syco_code', 'Code')
    ->setSqlSelect('syco_name', 'Name')
    ->setSqlSelect('syco_database_ip', 'IP')
    ->setSqlSelect('syco_status', 'Status')
    ->setSqlOrder('ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Synthesis - Companies')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Company?')
    ->setMainFieldID('ID')
    ->setModifyLink('company_modify.php?lid=')
    ->setDeleteLink('company_delete.php?lid=')
    ->setCreateNewLink('company_modify.php?')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_footer();
