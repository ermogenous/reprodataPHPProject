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
$db->admin_title = "AInsurance Overwrites Agents";

$db->show_empty_header();

$list = new TableList();
$list->setTable('ina_overwrite_agents', 'InsuranceOverwriteAgents')
    ->setSqlFrom('JOIN ina_underwriters ON inaund_underwriter_ID = inaova_underwriter_ID')
    ->setSqlFrom('JOIN users ON usr_users_ID = inaund_user_ID')
    ->setSqlSelect('inaova_overwrite_agent_ID', 'ID')
    ->setSqlSelect('usr_name', 'Name')
    ->setSqlSelect('inaova_status', 'Status')
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('inaova_overwrite_agent_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Insurance Overwrite Agents')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Overwrite agent?')
    ->setMainFieldID('ID')
    ->setModifyLink('overwrite_agent_modify.php?oid='.$_GET['oid'].'&lid=')
    ->setDeleteLink('overwrite_agent_delete.php?oid='.$_GET['oid'].'&lid=')
    ->setCreateNewLink('overwrite_agent_modify.php?oid='.$_GET['oid'])
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_empty_footer();