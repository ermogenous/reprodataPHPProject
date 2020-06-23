<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();
include("../../tools/export_data.php");

$db->include_js_file("../../include/jscripts.js");


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
	if ($_POST["insured_amount_from"] != "" && $_POST["insured_amount_to"] != "")
		$insured_amount = " AND Insured_Amount BETWEEN ".$_POST["insured_amount_from"]." AND ".$_POST["insured_amount_to"];

	if ($_POST["total_policies_from"] != "" && $_POST["total_policies_to"] != "") 
		$total_policies = " AND Total_policies BETWEEN ".$_POST["total_policies_from"]." AND ".$_POST["total_policies_to"];		
	

	if ($_POST["occupation"] != "" || $_POST["occupation_serials"] != "") {

		if ($_POST["occupation_serials"] != "")
			$occupation_sql = " AND incl_occupation_serial IN (".$_POST["occupation_serials"].")";
		else
			$occupation_sql = " AND incl_occupation_serial = ".$_POST["occupation"];
			
	
	}
		



	$sql = "
SELECT 
COUNT(inpol_policy_number) as Total_Policies,
incl_client_serial as Client_Serial,

(SELECT ic.incl_identity_card FROM inclients as ic WHERE ic.incl_client_serial = inclients.incl_client_serial) as Client_ID,
(SELECT ic2.incl_long_description FROM inclients as ic2 WHERE ic2.incl_client_serial = inclients.incl_client_serial) as Client_Name,
(SELECT ic3.incl_postal_code + ' ' + ic3.incl_address_line1 + ' ' + ic3.incl_street_no + ' ' + ic3.incl_address_line2 FROM inclients as ic3 WHERE ic3.incl_client_serial = inclients.incl_client_serial) as Client_Address,
(SELECT ic4.incl_city FROM inclients as ic4 WHERE ic4.incl_client_serial = inclients.incl_client_serial) as Client_City,
(SELECT ic5.incl_district FROM inclients as ic5 WHERE ic5.incl_client_serial = inclients.incl_client_serial) as Client_District,
(SELECT ic6.incl_home_telephone FROM inclients as ic6 WHERE ic6.incl_client_serial = inclients.incl_client_serial) as Client_Home_Telephone,
(SELECT ic7.incl_work_telephone FROM inclients as ic7 WHERE ic7.incl_client_serial = inclients.incl_client_serial) as Client_Work_Telephone,
(SELECT ic8.incl_mobile FROM inclients as ic8 WHERE ic8.incl_client_serial = inclients.incl_client_serial) as Client_Mobile,
(SELECT ic9.incl_email FROM inclients as ic9 WHERE ic9.incl_client_serial = inclients.incl_client_serial) as Client_Email,
(SELECT inag_agent_code FROM inagents WHERE inag_agent_serial = inpol_agent_serial)Agent_Code,
(SELECT ig.inag_long_description FROM inagents as ig WHERE ig.inag_agent_serial = inpol_agent_serial)Agent_Name,
SUM(inpol_insured_amount)as Insured_Amount,
(SELECT incd_long_description FROM inpcodes JOIN inclients as inclco ON inclco.incl_occupation_serial = incd_pcode_serial WHERE inclco.incl_client_serial = inclients.incl_client_serial) as Client_Occupation

INTO #TEMP

FROM inclients
LEFT OUTER JOIN inpolicies ON inpol_client_serial = incl_client_serial
LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial

WHERE 
inpol_status = 'N'
".$period."
".$insurance_type."
".$insurance_type_alt."
".$occupation_sql."
GROUP BY incl_client_serial , inpol_agent_serial

SELECT * FROM #TEMP 
WHERE 1=1 
".$insured_amount."
".$total_policies."
ORDER BY ".$_POST["sort_by"]." ".$_POST["sort_by_type"];

//echo "<hr>".$sql."<hr>";

if ($_POST["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"'",'download');
}
else if ($_POST["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
}
else if ($_POST["export_file"] == "xml") {
	$table_data = "XML NOT WORKING YET";
}



}//if action == show

$db->show_header();
?>
<script language="JavaScript" type="text/javascript">
function submit_form(){

if(document.form1.export_file[0].checked)
	document.form1.target = '_self';
else 
	document.form1.target = '_blank';

}
</script>

<form name="form1" method="POST" action=""  onsubmit="submit_form();">
  <table width="697" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Sum Insured Amounts for Clients </strong></td>
    </tr>
    
    <tr>
      <td width="147" height="28"><strong>Policy Starting Date </strong></td>
      <td width="548">
      From
      <input name="period_from" type="text" id="period_from" onkeyup="res(this,date);" value="<? echo $_POST["period_from"];?>" />
      To
        
        <input name="period_to" type="text" id="period_to" onkeyup="res(this,date);" value="<? echo $_POST["period_to"];?>" /></td>
    </tr>
    <tr>
      <td height="28"><strong>Insurance Type </strong></td>
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
      </select></td>
    </tr>
    <tr>
      <td height="28"><strong>Insurance Type 2 </strong></td>
      <td><input name="insurance_type_alt" type="text" id="insurance_type_alt" value="<? echo $_POST["insurance_type_alt"];?>" /> <input name="insurance_type_alt_not" type="checkbox" id="insurance_type_alt_not" value="1" <? if ($_POST["insurance_type_alt_not"] == 1) echo "checked=\"checked\"";?> />
      NOT (Can use % as wild card) </td>
    </tr>
    <tr>
      <td height="28"><strong>Insured Amount </strong></td>
      <td>From
        <input name="insured_amount_from" type="text" id="insured_amount_from" value="<? echo $_POST["insured_amount_from"];?>" />
        To
        <input name="insured_amount_to" type="text" id="insured_amount_to" value="<? echo $_POST["insured_amount_to"];?>" /></td>
    </tr>
    <tr>
      <td height="28"><strong>Total Policies</strong> </td>
      <td>From
        <input name="total_policies_from" type="text" id="total_policies_from" value="<? echo $_POST["total_policies_from"];?>" />
        To
        <input name="total_policies_to" type="text" id="total_policies_to" value="<? echo $_POST["total_policies_to"];?>" /></td>
    </tr>
    <tr>
      <td height="52"><strong>Client Occupation </strong></td>
      <td>
	  <select name="occupation" id="occupation">
	  		<option value="">NONE</option>
<?
$ocsql = "SELECT * FROM inoccupationcodes WHERE inoc_status_flag = 'N' ORDER BY inoc_account_type ASC, inoc_long_description ASC";
$ocresult = $sybase->query($ocsql);
while ($ocrow = $sybase->fetch_assoc($ocresult)) {
?>
      	<option value="<? echo $ocrow["inoc_pcode_serial"];?>" <? if ($ocrow["inoc_pcode_serial"] == $_POST["occupation"]) echo "selected=\"selected\"";?>><? echo $ocrow["inoc_long_description"]."(".$ocrow["inoc_pcode_serial"].") ".$ocrow["inoc_account_type"];?></option>
<? } ?>
	  </select>
	  <br />
	  OR By Serial ex. 1234,4321,444,11 etc
      <input name="occupation_serials" type="text" id="occupation_serials" value="<? echo $_POST["occupation_serials"];?>" /></td>
    </tr>
    <tr>
      <td height="28"><strong>Sort By </strong></td>
      <td><select name="sort_by" id="sort_by">
        <option value="Insured_Amount" <? if ($_POST["sort_by"] == "Insured_Amount") echo "selected=\"selected\"";?>>Insured Amount</option>
        <option value="Total_Policies" <? if ($_POST["sort_by"] == "Total_Policies") echo "selected=\"selected\"";?>>Total Policies</option>
        <option value="Client_Name" <? if ($_POST["sort_by"] == "Client_Name") echo "selected=\"selected\"";?>>Client Name</option>
        <option value="Agent_Name" <? if ($_POST["sort_by"] == "Agent_Name") echo "selected=\"selected\"";?>>Agent Name</option>
      </select>
        <select name="sort_by_type" id="sort_by_type">
          <option value="ASC" <? if ($_POST["sort_by_type"] == "ASC") echo "selected=\"selected\"";?>>Ascending</option>
          <option value="DESC" <? if ($_POST["sort_by_type"] == "DESC") echo "selected=\"selected\"";?>>Descending</option>
        </select>      </td>
    </tr>
    <tr>
      <td height="28"><strong>Export File </strong></td>
<?
if ($_POST["export_file"] == "")
	$_POST["export_file"] = "no";
?>
      <td><input name="export_file" type="radio" value="no" <? if ($_POST["export_file"] == "no") echo "checked=\"checked\"";?> />
      No
      <input name="export_file" type="radio" value="delimited" <? if ($_POST["export_file"] == "delimited") echo "checked=\"checked\"";?> />
      Delimited (#) 
      <input name="export_file" type="radio" value="xml" <? if ($_POST["export_file"] == "xml") echo "checked=\"checked\"";?> />
      XML (NOT WORKING YET) </td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
echo $table_data;
$db->show_footer();
?>