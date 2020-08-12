<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/11/2019
 * Time: 1:18 ΜΜ
 */

include("../include/main.php");
include("../tools/table_list.php");


$db = new Main();
$db->admin_title = "Customers Policies";

$db->show_empty_header();

if ($_GET['cid'] == '') {
    header("Location: ../home.php");
    exit();
}

$list = new TableList();
$list->setTable('ina_policies', 'CustomerPolicies')
    ->setSqlFrom('JOIN customers ON cst_customer_ID = inapol_customer_ID')
    ->setSqlSelect('inapol_policy_ID', 'ID')
    ->setSqlSelect('inapol_policy_number', 'Policy Number')
    ->setSqlSelect('inapol_starting_date', 'Starting')
    ->setSqlSelect('inapol_expiry_date', 'Expiry')
    ->setSqlSelect('inapol_process_status', 'Pr.Status')
    ->setSqlSelect('inapol_status', 'Status')
    ->setSqlSelect('(inapol_premium + inapol_fees + inapol_stamps)', 'Premium')
    ->setSqlSelect('(
        SELECT SUM(inapi_paid_amount) FROM ina_policy_installments WHERE inapi_policy_ID = inapol_installment_ID
        )', 'Paid')
    ->setSqlSelect('(
        SELECT SUM(inapi_amount - inapi_paid_amount) FROM ina_policy_installments WHERE inapi_policy_ID = inapol_installment_ID
        )', 'Unpaid')
    ->setSqlSelect('(
        SELECT SUM(inapp_amount) FROM ina_policy_payments WHERE inapp_policy_ID = inapol_installment_ID AND inapp_status = "Prepayment"
        )', 'Prepaid')
    ->setSqlWhere('inapol_customer_ID = ' . $_GET['cid'])
    ->setSqlOrder('inapol_policy_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Customer Policies')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    //->setDisableIconColumn()
    ->setDisableDeleteICon()
    ->setDisableClickRowLink()
    ->setMainFieldID('ID')
    ->setModifyLink('../ainsurance/policy_modify.php?lid=', '_blank')
    ->tableFullBuilder();

