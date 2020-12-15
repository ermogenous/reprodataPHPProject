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
$db->admin_title = "Synthesis - Web Users";

$db->show_header();

$list = new TableList();
$list->setTable('sy_web_users', 'ID')
    ->setSqlFrom('JOIN sy_companies ON syco_company_ID = sywu_company_ID')
    ->setSqlSelect('sywu_web_user_ID', 'ID')
    ->setSqlSelect('sywu_name', 'Name')
    ->setSqlSelect('syco_name', 'Company')
    ->setSqlSelect('sywu_status', 'Status')
    ->setSqlOrder('ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Synthesis - Web Users')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Web User?')
    ->setMainFieldID('ID')
    ->setModifyLink('web_user_modify.php?lid=')
    ->setDeleteLink('web_user_delete.php?lid=')
    ->setCreateNewLink('web_user_modify.php?')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_footer();
