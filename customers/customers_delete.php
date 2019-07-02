<?php
include("../include/main.php");
$db = new Main();


if ($_GET["lid"] != "") {

    //check if the customer is related to:
    //1. Agreements
    //2. Tickets
    //3. Policies
    

    if ($db->get_setting('agr_agreements_enable') == 1) {
        $checkAgr = $db->query_fetch("SELECT COUNT(*) as clo_total FROM agreements WHERE agr_customer_ID = " . $_GET['lid']);
        if ($checkAgr['clo_total'] > 0) {
            $db->generateSessionAlertError('Customer [' . $_GET['lid'] . '] cannot be deleted. Used in agreements');
            header("Location: customers.php");
            exit();
        }
    }

    if ($db->get_setting('tck_tickets_enable') == 1) {
        $checkTck = $db->query_fetch('SELECT COUNT(*) as clo_total FROM tickets WHERE tck_customer_ID = ' . $_GET['lid']);
        if ($checkTck['clo_total'] > 0) {
            $db->generateSessionAlertError('Customer [' . $_GET['lid'] . '] cannot be deleted. Used in tickets');
            header("Location: customers.php");
            exit();
        }
    }




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