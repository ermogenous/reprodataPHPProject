<?php
$list = new TableList();
$list->setTable('ina_policy_items','inapit_policy_item_ID')
    ->setSqlFrom('LEFT OUTER JOIN ina_insurance_company_packages ON inaincpk_insurance_company_package_ID = inapit_package_ID')
    ->setSqlSelect('inapit_policy_item_ID','ID')
    ->setSqlSelect('inapit_mb_full_name','Name')
    ->setSqlSelect('inapit_mb_birth_date','Birthdate',['functionName' => 'fixDate'])
    ->setSqlSelect('inaincpk_code','Package')
    ->setSqlSelect('inapit_premium','Premium')
    ->setSqlSelect('inapit_excess','Excess')
    ->setSqlWhere('inapit_policy_ID = '.$_GET['pid'])
    ->setSqlOrder('inapit_policy_item_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

$list->setMainColumn('col-lg-12')
    ->setTopTitle('Members')
    ->setTopContainerToFluid()
    //->setLeftColumn('col-lg-1')
    //->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setDeleteConfirmText('Are you sure you want to delete this member?')
    ->setMainFieldID('ID')
    ->setModifyLink('policy_item_modify.php?pid='.$_GET['pid'].'&type='.$_GET['type'].'&lid=')
    ->setDeleteLink('policy_item_delete.php?pid='.$_GET['pid'].'&type='.$_GET['type'].'&lid=')
    ->setCreateNewLink('policy_item_modify.php?pid='.$_GET['pid'].'&type='.$_GET['type'])
    ->tableFullBuilder();

function fixDate($data){
    global $db;
    return $db->convertDateToEU($data);
}