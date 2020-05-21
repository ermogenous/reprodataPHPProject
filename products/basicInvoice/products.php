<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 20/05/2020
 * Time: 15:18
 */

include("../../include/main.php");
include("../../tools/table_list.php");

$db = new Main(1);
$db->admin_title = "Basic Invoice Products List";


$db->show_header();


$list = new TableList();
$list->setTable('products', 'basicInvoiceProducts')
    ->setSqlSelect('prd_product_ID', 'ID')
    ->setSqlSelect('prd_name', 'Name')
    ->setSqlSelect('prd_price', 'Price')
    ->setSqlSelect('prd_active', 'Status',['functionName' => 'getActiveName'])
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('prd_product_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Products')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this Product?')
    ->setMainFieldID('ID')
    ->setModifyLink('product_modify.php?lid=')
    ->setDeleteLink('product_delete.php?lid=')
    ->setCreateNewLink('product_modify.php')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_footer();

function getActiveName($data){
    if ($data == 1){
        return "Active";
    }
    else {
        return "InActive";
    }
}