<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 03/4/2020
 * Time: 12:47 PM
 */

include("../../include/main.php");
//include("../../include/tables.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Overwrites";

$db->show_header();


$list = new TableList();
$list->setTable('ina_overwrites', 'InsuranceOverwrites')
    ->setSqlFrom('JOIN ina_underwriters ON inaund_underwriter_ID = inaovr_underwriter_ID')
    ->setSqlFrom('JOIN users ON usr_users_ID = inaund_user_ID')
    ->setSqlSelect('inaovr_overwrite_ID', 'ID')
    ->setSqlSelect('usr_name', 'Name')
    ->setSqlSelect('inaovr_status', 'Status')
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('inaovr_overwrite_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Insurance Overwrites')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Overwrite?')
    ->setMainFieldID('ID')
    ->setModifyLink('overwrite_modify.php?lid=')
    ->setDeleteLink('overwrite_delete.php?lid=')
    ->setCreateNewLink('overwrite_modify.php')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_footer();
