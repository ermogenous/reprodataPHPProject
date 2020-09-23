<?php
include("../../include/main.php");
$db = new Main();


if ($_GET["lid"] != "") {

    //first check if there is no transactions for this account
    $checl1Data = $db->query_fetch('SELECT COUNT(*)as clo_total FROM ac_transaction_lines WHERE actrl_account_ID = '.$_GET['lid']);
    if ($checl1Data['clo_total'] > 0){
        $db->generateSessionAlertError('Account has transactions. Cannot delete (deactivate)');
        header ("Location: accounts.php");
        exit();
    }

	$db->db_tool_delete_row('ac_accounts',$_GET["lid"],"`acacc_account_ID` = ".$_GET["lid"]);
	
	header("Location: accounts.php?info=Account Deleted Succesfully");
	exit();

}
else {
	header ("Location: accounts.php");
	exit();
}

?>