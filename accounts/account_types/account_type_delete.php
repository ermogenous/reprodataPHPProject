<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/10/2019
 * Time: 3:40 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
$db = new Main();
$db->admin_title = "Accounts Type Delete";


$db->check_restriction_area('delete');

if ($_GET['lid'] != '') {

    $data = $db->query_fetch('SELECT * FROM ac_account_types WHERE actpe_account_type_ID = ' . $_GET['lid']);
    if ($data['actpe_account_type_ID'] == '' || $data['actpe_account_type_ID'] == 0) {
        $db->generateSessionAlertError('Account type does not exists');
        header('Location: account_types.php');
        exit();
    }
    //check if the type/sub type is not used anywhere
    if ($data['actpe_type'] == 'Type') {
        $sql = 'SELECT COUNT(*) as clo_total FROM ac_accounts WHERE acacc_account_type_ID = ' . $data['actpe_account_type_ID'];
        $result = $db->query_fetch($sql);
        if ($result['clo_total'] > 0) {
            $db->generateSessionAlertError('Account type is used by one or more accounts');
            header('Location: account_types.php');
            exit();
        }
    } else {
        $sql = 'SELECT COUNT(*) as clo_total FROM ac_accounts WHERE acacc_account_sub_type_ID = ' . $data['actpe_account_type_ID'];
        $result = $db->query_fetch($sql);
        if ($result['clo_total'] > 0) {
            $db->generateSessionAlertError('Account sub type is used by one or more accounts');
            header('Location: account_types.php');
            exit();
        }
    }

    //all should be ok to proceed with deleting
    $db->db_tool_delete_row('ac_account_types', $data['actpe_account_type_ID'], 'actpe_account_type_ID = ' . $data['actpe_account_type_ID']);
    $db->generateSessionAlertSuccess('Account type is deleted successfully');
    header('Location: account_types.php');
    exit();
}

header("Location: account_types.php");
exit();
