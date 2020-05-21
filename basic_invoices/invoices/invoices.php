<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 21/05/2020
 * Time: 15:57
 */

include("../../include/main.php");
include("../../tools/table_list.php");

$db = new Main(1);
$db->admin_title = "Basic Invoices - Invoices";


$db->show_header();


$list = new TableList();
$list->setTable('biv_invoices', 'basicInvoicesInvoices')
    ->setSqlSelect('bivinv_invoice_ID', 'ID')
    ->setSqlSelect('bivinv_invoice_number', 'Number')
    ->setSqlSelect('bivinv_issue_date', 'Issue Date')
    ->setSqlSelect('bivinv_status', 'Status')
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('bivinv_invoice_ID', 'DESC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Invoices')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Invoice?')
    ->setMainFieldID('ID')
    ->setModifyLink('invoice_modify.php?lid=')
    ->setDeleteLink('invoice_delete.php?lid=')
    ->setCreateNewLink('invoice_modify.php')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_footer();
