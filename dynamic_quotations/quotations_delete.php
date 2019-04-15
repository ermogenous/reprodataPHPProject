<?php
include("../include/main.php");
$db = new Main();

/*
if ($_GET["quotation"] != "") {
	$q_data = $db->query_fetch("SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ".$_GET["quotation"]);
	
	if ($q_data["oqq_quotations_ID"] != "") {
	
		$sql = "DELETE FROM oqt_quotations WHERE oqq_quotations_type_ID = ".$_GET["quotation_type"]." AND oqq_quotations_ID = ".$q_data["oqq_quotations_ID"]." AND oqq_users_ID = ".$db->user_data["usr_users_ID"]." LIMIT 1";
		$db->query($sql);
		//echo $sql."<hr>";
		//delete the quotation items first
		$sql = "DELETE FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$q_data["oqq_quotations_ID"];
		$db->query($sql);
		//echo $sql;
		header("Location: quotations.php?error=Quotation has been deleted");
		exit();
	}//if quotation exists.
}
*/

if ($_GET["quotation"] != "") {
    include('quotations_class.php');
    $quote = new dynamicQuotation($_GET['quotation']);
	if ($quote->delete() == true){
		$db->generateSessionAlertSuccess($quote->getQuotationType().' deleted successfully.');
	}
	else {
		$db->generateSessionAlertError($quote->errorDescription);
	}
}
header("Location: quotations.php");
exit();

$db->show_footer();
?>
