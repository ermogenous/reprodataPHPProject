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
      <td width="147" height="28">Policy Status</td>
      <td width="629"><select name="policy_status" id="policy_status">
        <option value="active" <? if ($_POST["policy_status"] == 'active') echo "selected";?>>Only clients with active policies</option>
        <option value="inactive" <? if ($_POST["policy_status"] == 'inactive') echo "selected";?>>Only clients with NOT Active policies</option>
        <option value="all" <? if ($_POST["policy_status"] == 'all') echo "selected";?>>All clients active policies or not active</option>
      </select></td>
    </tr>
    <tr>
      <td height="28">Agent Group Code</td>
      <td><input type="text" name="group_code" id="group_code" value="<? echo $_POST["group_code"];?>" /></td>
    </tr>
    <tr>
      <td height="28">Order By</td>
      <td><select name="order_by" id="order_by">
        <option value="inclients.incl_account_code">Client Account Code</option>
      </select></td>
    </tr>
    <tr>
      <td height="28">Filter By Postal Code</td>
      <td><input name="postal_code_from" type="text" id="postal_code_from" value="<? echo $_POST["postal_code_from"];?>" size="7" />
      <input name="postal_code_to" type="text" id="postal_code_to" value="<? echo $_POST["postal_code_to"];?>" size="7" />
      <select name="postal_code_type" id="postal_code_type">
        <option value="primary_client.incl_postal_code" <? if ($_POST["postal_code_type"] == "primary_client.incl_postal_code") echo "selected=\"selected\"";?>>Primary Client</option>
        <option value="inclients.incl_postal_code" <? if ($_POST["postal_code_type"] == "inclients.incl_postal_code") echo "selected=\"selected\"";?>>Policy Client</option>
      </select></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {

	$sql = "SELECT
	(SELECT MAX(initm_item_code) FROM inpolicyitems JOIN initems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial) as clo_registration,
    primary_client.incl_salutation as clo_client_salutation,
    primary_client.incl_account_code as clo_client_account_code,
    primary_client.incl_first_name as clo_client_first_name,
    primary_client.incl_long_description as clo_client_long_description,
    primary_client.incl_identity_card as clo_client_identity_card,
	primary_client.incl_postal_code as clo_client_postal_code,
	primary_client.incl_mobile as clo_client_mobile,
	primary_client.incl_address_line1 as clo_client_address_line1,
	primary_client.incl_street_no as clo_client_street_no,
	primary_client.incl_address_line2 as cli_client_address_line2,
	primary_client.incl_city as clo_client_city,
	primary_client.incl_district as clo_client_district,
	
	inpolicies.*,
	inclients.*,
	inagents.*,
	ininsurancetypes.*
	FROM
	inpolicies
	JOIN inclients ON inclients.incl_client_serial = inpol_client_serial
	JOIN inagents ON inag_agent_serial = inpol_agent_serial
	JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
	JOIN inclients as primary_client ON primary_client.incl_account_code = inclients.incl_account_code AND primary_client.incl_update_ac_static = 'Y'
	WHERE
	inpol_status = 'N'
	AND inag_group_code LIKE '%".$_POST["group_code"]."%'";
	
	if ($_POST["postal_code_from"] != "" && $_POST["postal_code_to"] != "") {
		$sql .= "AND ".$_POST["postal_code_type"]." BETWEEN '".$_POST["postal_code_from"]."' AND '".$_POST["postal_code_to"]."'";
	}
	
	$sql .= "
	ORDER BY
	".$_POST["order_by"]." ASC";
	$result = $sybase->query($sql);
?>
<div id="print_view_section_html">
<table width="1130" border="1" cellspacing="0" cellpadding="0">
<?
	$show_header = 0;
	while ($row = $sybase->fetch_assoc($result)) {
		
		if ($show_header == 0 || $previous_data["clo_client_account_code"] != $row["clo_client_account_code"]) {
?>
	<tr>
    	<td colspan="8">&nbsp;&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><strong><? echo $row["clo_client_salutation"]." ".$row["clo_client_first_name"]." ".$row["clo_client_long_description"];?>&nbsp;&nbsp;ID:<? echo $row["clo_client_identity_card"];?>&nbsp;A/C:<? echo $row["clo_client_account_code"];?></strong></td>
    <td align="center"><strong>Mobile</strong></td>
    <td align="center"><strong>Period Starting Date</strong></td>
    <td align="center"><strong>Expiry Date</strong></td>
    <td align="center"><strong>Registration</strong></td>
    <td align="center"><strong>Postal Code</strong></td>
    <td align="center"><strong>Community</strong></td>
  </tr>
<? 
		}
		
?>
  <tr>
    <td width="80"><? echo $row["inpol_policy_number"];?>&nbsp;&nbsp;</td>
    <td width="355"><? echo $row["incl_salutation"]." ".$row["incl_first_name"]." ".$row["incl_long_description"];?></td>
    <td width="101" align="center"><? echo $row["clo_client_mobile"];?></td>
    <td width="177" align="center"><? echo $db->convert_date_format($row["inpol_period_starting_date"],"yyyy-mm-dd","dd/mm/yyyy");?></td>
    <td width="109" align="center"><? echo $db->convert_date_format($row["inpol_expiry_date"],"yyyy-mm-dd","dd/mm/yyyy");?></td>
    <td width="104" align="center"><? if ($row["inity_major_category"] == "19") echo $row["clo_registration"];?></td>
    <td width="97" align="center"><? echo $row["incl_postal_code"];?></td>
    <td width="89" align="center"><? echo $row["incl_city"];?></td>
  </tr>
  <tr>
    <td colspan="6"><? echo $row['clo_client_address_line1'].' '.$row['clo_client_street_no'].' '.$row['cli_client_address_line2'].' '.$row['clo_client_city'].' '.$row['clo_client_district'] ;?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
<?
		$show_header ++;
		$previous_data = $row;
	}
?>
</table>
</div>

<?

}//if action == show

$db->show_footer();
?>