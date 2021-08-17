<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 5/8/2021
 * Time: 1:45 μ.μ.
 */

include("../include/main.php");
include("../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "SMS";

$db->show_header();

//$table = new draw_table('ac_transactions', 'actrn_transaction_ID', 'ASC');

//$table->generate_data();

$list = new TableList();
$list->setTable('sms','sms')
    ->setSqlSelect('sms_sms_ID','ID')
    ->setSqlSelect('sms_source_module','Source')
    ->setSqlSelect('sms_status','Status')
    ->setSqlSelect('sms_to_num','To')
    ->setSqlSelect('sms_subject','Subject')
    ->setSqlOrder('sms_sms_ID', 'DESC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('SMS')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setFunctionIconArea('makeIconFn')
    ->setDeleteConfirmText('Are you sure you want to delete this sms?')
    ->setMainFieldID('ID')
    ->setModifyLink('sms_modify.php?lid=')
    ->setDeleteLink('sms_delete.php?lid=')
    ->setCreateNewLink('sms_modify.php')
    ->tableFullBuilder();

$db->show_footer();


function makeIconFn($row){
    if ($row['Status'] == 'Pending'){
        $html = '<a href="sms_send.php?lid='.$row['ID'].'"><i class="fas fa-share"></i></a>';
    }
    else {
        $html = '';
    }
    return $html;
}
?>
