<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 11/2/2021
 * Time: 3:40 μ.μ.
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include("../../../tools/table_list.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Functions - Agents Extra Fields";

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();

$syn = new ODBCCON();


$list = new TableList();
$list->defineMainObjectVar('syn');
$list->setTable('inagents', 'SynthesisAgents')
    ->defineMainObjectVar('syn')
    //->setSqlFrom('JOIN users ON usr_users_ID = inaund_user_ID')
    ->setSqlSelect('inag_agent_code', 'Agent Code')
    ->setSqlSelect('inag_long_description', 'Description')
    ->setSqlSelect('inag_status_flag', 'Status')

    ->setSqlWhere("inag_agent_type = 'A'")

    ->setSqlOrder('inag_agent_code', 'ASC')
    ->setPerPage(10)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Synthesis Agents')
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
?>
