<?php
include("../include/main.php");
$db = new Main();


if ($_GET["lid"] != "") {


	$db->db_tool_delete_row('customers',$_GET["lid"],"`cst_customer_ID` = ".$_GET["lid"]);
	$db->generateSessionDismissSuccess('Customer Deleted.');
	header("Location: customers.php");
	exit();

}
else {
	header ("Location: customers.php");
	exit();
}

?>