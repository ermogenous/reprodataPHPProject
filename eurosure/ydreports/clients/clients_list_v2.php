<?
ini_set("memory_limit","256M");
ini_set('max_execution_time', 1600);
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
$sybase = new Sybase();
include ("../functions/production_class.php");

$db->show_header();
//init
if ($_POST["as_at_date"] == "") {
	$as_at = date("Y-m-d");	
}
else {
	$as_at = $_POST["as_at_date"];	
}
?>
<form name="form1" method="POST" action="" >
  <table width="778" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Clients List</strong></td>
    </tr>
    <tr>
      <td height="28">Policy Status</td>
      <td><select name="policy_status" id="policy_status">
        <option value="normal" <? if ($_POST["policy_status"] == 'normal') echo "selected";?>>Only clients with Normal policies</option>
        <option value="active" <? if ($_POST["policy_status"] == 'active') echo "selected";?>>Only clients with Active (Normal,Archive) policies</option>
        <option value="all" <? if ($_POST["policy_status"] == 'all') echo "selected";?>>Ignore Policy Status</option>
      </select></td>
    </tr>
    <tr>
      <td height="28">Agent Group Code</td>
      <td>From 
        <input name="group_code_from" type="text" id="group_code_from" size="8" value="<? echo $_POST["group_code_from"];?>"> 
        To 
        <input name="group_code_to" type="text" id="group_code_to" size="8" value="<? echo $_POST["group_code_to"];?>"></td>
    </tr>
    <tr>
      <td height="28">Filter</td>
      <td><select name="filter" id="filter">
        <option value="no_email" <? if ($_POST["filter"] == 'no_email') echo "selected";?>>Only clients with no emails</option>
        <option value="only_email" <? if ($_POST["filter"] == 'only_email') echo "selected";?>>Only clients with emails</option>
        <option value="only_mobile" <? if ($_POST["filter"] == 'only_mobile') echo "selected";?>>Only clients with mobile</option>
        <option value="no_mobile" <? if ($_POST["filter"] == 'no_mobile') echo "selected";?>>Only clients with no mobile</option>
        <option value="all" <? if ($_POST["filter"] == 'all') echo "selected";?>>Show all</option>
        
      </select></td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="147" height="28"><input name="action" type="hidden" id="action" value="show"></td>
      <td width="629"><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {

	if ($_POST["policy_status"] == "normal") {
		$pstatus = "AND inpol_status = 'N'";
	}
	else if ($_POST["policy_status"] == "active") {
		$pstatus = "AND inpol_status IN ('N','A')";
	}
	else if ($_POST["policy_status"] == "all") {
		$pstatus = "";
	}
	
	if ($_POST["filter"] == "no_email") {
		$filterSql = "AND incl_email = ''";
	}
	else if ($_POST["filter"] == "only_email") {
		$filterSql = "AND incl_email <> ''";
	}
	else if ($_POST["filter"] == "only_mobile") {
		$filterSql = "		AND if isnumeric(incl_mobile) = 0 THEN 0 ELSE 
		if LEFT(incl_mobile,2) IN ('99','96','97','95','94') THEN 1 ELSE 0 ENDIF
		ENDIF = 1";
	}
	else if ($_POST["filter"] == "no_mobile") {
		$filterSql = "		AND if isnumeric(incl_mobile) = 0 THEN 0 ELSE 
		if LEFT(incl_mobile,2) IN ('99','96','97','95','94') THEN 1 ELSE 0 ENDIF
		ENDIF = 0";
	}
	else if ($_POST["filter"] == "all") {
		$filterSql = "";
	}

	if ($_POST["group_code_from"] != "" && $_POST["group_code_to"] != "") {
		$agent_filter = "AND inag_group_code BETWEEN '".$_POST["group_code_from"]."' AND '".$_POST["group_code_to"]."'";
	}

	$sql = "SELECT
		inag_group_code,
		inag_long_description,
		incl_salutation as clo_client_salutation,
		incl_account_code as clo_client_account_code,
		incl_first_name as clo_client_first_name,
		incl_long_description as clo_client_long_description,
		incl_identity_card as clo_client_identity_card,
		incl_postal_code as clo_client_postal_code,
		incl_mobile as clo_client_mobile,
		incl_address_line1 as clo_client_address_line1,
		incl_street_no as clo_client_street_no,
		incl_address_line2 as cli_client_address_line2,
		incl_city as clo_client_city,
		incl_district as clo_client_district,
		incl_email as clo_client_email
		FROM
		inclients
		JOIN inpolicies ON inpol_client_serial = incl_client_serial
		JOIN inagents ON inag_agent_serial = inpol_agent_serial
		JOIN ininsurancetypes ON inpol_insurance_type_serial = inity_insurance_type_serial
		WHERE
		inpol_status = 'N'
		".$agent_filter."
		".$pstatus."
		".$filterSql."
		GROUP BY
		inag_group_code,
		inag_long_description,
		clo_client_salutation,
		clo_client_account_code,
		clo_client_first_name,
		clo_client_long_description,
		clo_client_identity_card,
		clo_client_postal_code,
		clo_client_mobile,
		clo_client_address_line1,
		clo_client_street_no,
		cli_client_address_line2,
		clo_client_city,
		clo_client_district,
		clo_client_email
		
		ORDER BY
		inag_group_code ASC";
		//echo $sql;
	$result = $sybase->query($sql);
?>
<div id="print_view_section_html">
<?
$i = 0;
while ($row = $sybase->fetch_assoc($result)) {
	$i++;
	$agent = $row["inag_group_code"];
	//when agent changes show the headers
	if ($agent != $previous_agent) {
		$agentNum = 0;
		if ($i > 1) {
			echo '</table>
<br><br>
<hr style="page-break-after:always; height:1px; color:#FFF" width="1px" />';
		}
?>

<table width="1000" border="1" cellspacing="0" cellpadding="0">
	<tr>
	  <td colspan="5" align="center"><strong>Clients email address</strong></td>
    </tr>
    <tr>
	  <td colspan="5" height="30" style="background-color:#CCC"><strong>Agent:<? echo $agent." - ".$row["inag_long_description"];?></strong></td>
    </tr>
	<tr>
    	<td width="10"><strong>#</strong></td>
		<td width="50"><strong>ID</strong></td>
        <td width="350"><strong>Name</strong></td>
        <td width="170" align="center"><strong>Tel</strong></td>
        <td><strong>Email</strong></td>
	</tr>
<? 
	}
	$agentNum++;
?>
	<tr>
    	<td><? echo $agentNum;?></td>
		<td><? echo $row["clo_client_identity_card"];?></td>
        <td><? echo $row["clo_client_salutation"]." ".$row["clo_client_first_name"]." ".$row["clo_client_long_description"];?></td>
        <td align="center"><? echo $row["clo_client_mobile"];?></td>
        <td height="40"><? echo $row["clo_client_email"];?></td>
	</tr>
<?
	$previous_agent = $row["inag_group_code"];
}
?>
</table>
</div>

<?

}//if action == show

$db->show_footer();
?>