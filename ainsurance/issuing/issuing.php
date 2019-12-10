<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/12/2019
 * Time: 9:34 π.μ.
 */

include("../../include/main.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Issuing";

$db->show_header();

//$table = new draw_table('ac_transactions', 'actrn_transaction_ID', 'ASC');

//$table->generate_data();

$list = new TableList();
$list->setTable('ina_issuing','AInsuranceIssuing')
    ->setSqlSelect('inaiss_issue_ID','ID')
    ->setSqlSelect('inaiss_name','Name')
    ->setSqlOrder('inaiss_issue_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('AInsurance Issuing')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this issuing?')
    ->setMainFieldID('ID')
    ->setModifyLink('issue_modify.php?lid=')
    ->setDeleteLink('issue_delete.php?lid=')
    ->setCreateNewLink('issue_modify.php')
    ->tableFullBuilder();

$db->show_footer();

?>