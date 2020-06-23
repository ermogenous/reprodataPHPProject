<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();
include("../../tools/export_data.php");

$db->include_js_file("../../include/jscripts.js");
$db->show_header();


if ($_POST["action"] == "show") {

	if ($_POST["period_from"] != "" && $_POST["period_to"] != '')
		$period = " AND inpol_period_starting_date BETWEEN DATE('".$sybase->fix_date($_POST["period_from"])."') AND DATE('".$sybase->fix_date($_POST["period_to"])."')";
	if ($_POST["insurance_type"] != "none")
		$insurance_type = " AND inity_insurance_type = '".$_POST["insurance_type"]."'";
	if ($_POST["insurance_type_alt"] != "") {
		$insurance_type_alt = " AND inity_insurance_type ";
		if ($_POST["insurance_type_alt_not"] == "1")
			$insurance_type_alt .= "NOT";
		$insurance_type_alt .= " LIKE '".$_POST["insurance_type_alt"]."'";
	}
	if ($_POST["insured_amount_from"] != "" && $_POST["insured_amount_to"] != "") {
		$insured_amount = " WHERE insured_amount BETWEEN ".$_POST["insured_amount_from"]." AND ".$_POST["insured_amount_to"];
	}
		
		



	$sql = "
SELECT 
COUNT(inpol_policy_number) as Total_Policies,
incl_client_serial as Client_Serial,
incl_long_description as Client_Name,
(SELECT inag_long_description FROM inagents WHERE inag_agent_serial = inpol_agent_serial)Agent_Name,
SUM(inpol_insured_amount)as Insured_Amount INTO #TEMP
FROM inclients
LEFT OUTER JOIN inpolicies ON inpol_client_serial = incl_client_serial
LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial


WHERE 
inpol_status = 'N'
".$period."
".$insurance_type."
".$insurance_type_alt."
GROUP BY incl_client_serial , inpol_agent_serial , incl_long_description

SELECT * FROM #TEMP 
".$insured_amount."
ORDER BY insured_amount DESC 
";

print_r( export_data_delimited($sql,'sybase','#',"'"));
//$result = $sybase->query($sql);

}//if action == show

?>

<form name="form1" method="POST" action="">
  <table width="697" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Sum Insured Amounts for Clients </strong></td>
    </tr>
    
    <tr>
      <td width="121" height="25"><strong>Period</strong></td>
      <td width="574">
      From
      <input name="period_from" type="text" id="period_from" onkeyup="res(this,date);" value="<? echo $_POST["period_from"];?>" />
      To
        
        <input name="period_to" type="text" id="period_to" onkeyup="res(this,date);" value="<? echo $_POST["period_to"];?>" /></td>
    </tr>
    <tr>
      <td height="25"><strong>Insurance Type </strong></td>
      <td>From
        <select name="insurance_type" id="insurance_type">
		<option value="none">None</option>
<?
$sql = "SELECT * FROM ininsurancetypes ORDER BY inity_insurance_type ASC";
$result = $sybase->query($sql);
while ($row = $sybase->fetch_assoc($result)) {
?>
		<option value="<? echo $row["inity_insurance_type"];?>" <? if ($_POST["insurance_type"] == $row["inity_insurance_type"]) echo "selected=\"selected\"";?>><? echo $row["inity_insurance_type"]." - ".$row["inity_short_description"];?></option>
<?
}
?>
      </select>
</td>
    </tr>
    <tr>
      <td height="25"><strong>Insurance Type 2 </strong></td>
      <td><input name="insurance_type_alt" type="text" id="insurance_type_alt" value="<? echo $_POST["insurance_type_alt"];?>" /> <input name="insurance_type_alt_not" type="checkbox" id="insurance_type_alt_not" value="1" <? if ($_POST["insurance_type_alt_not"] == 1) echo "checked=\"checked\"";?> />
      NOT (Can use % as wild card) </td>
    </tr>
    <tr>
      <td height="25"><strong>Insured Amount </strong></td>
      <td>From
        <input name="insured_amount_from" type="text" id="insured_amount_from" value="<? echo $_POST["insured_amount_from"];?>" />
        To
        <input name="insured_amount_to" type="text" id="insured_amount_to" value="<? echo $_POST["insured_amount_to"];?>" /></td>
    </tr>
    <tr>
      <td height="25"><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {
?>


<? 
} 

$db->show_footer();
?>
