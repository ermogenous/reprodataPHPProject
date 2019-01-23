<?php
include("../../include/main.php");
$db = new Main();


if ($_GET["lid"] != "") {


	$db->db_tool_delete_row('ac_accounts',$_GET["lid"],"`acacc_account_ID` = ".$_GET["lid"]);
	
	header("Location: accounts.php?info=Account Deleted Succesfully");
	exit();

}
else {
	header ("Location: accounts.php");
	exit();
}

?>