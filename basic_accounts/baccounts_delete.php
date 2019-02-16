<?php
include("../include/main.php");
$db = new Main();


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `bc_basic_accounts` WHERE `bcacc_basic_account_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
    if ($data['bcacc_type'] == 'Customer') {
        //check if customer is linked with this customer
        $cust = $db->query_fetch('SELECT * FROM customers WHERE cst_basic_account_ID = ' . $data['bcacc_basic_account_ID']);
        if ($cust['cst_customer_ID'] > 0) {
            //customer exists. Cannot Delete
            $db->generateSessionDismissError('Basic Account is linked with a customer. Cannot delete');
            header("Location: baccounts.php");
            exit();

        }
    }

	$db->db_tool_delete_row('bc_basic_accounts',$_GET["lid"],"`bcacc_basic_account_ID` = ".$_GET["lid"]);
	
	header("Location: baccounts.php");
	exit();

}
else {
	header ("Location: accounts.php");
	exit();
}

?>