<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$inqueries = new insurance_queries();

//=============================================================================================================

function get_premium($year,$month_from,$month_to,$agent,$major = '%%',$insurance_type = '%%') {
if ($major == "") $major = "%%";
if ($insurance_type == "") $insurance_type = "%%";
$sql = "
SELECT  
('".$year."') as clo_year,           
('".$month_from."') as clo_period_from,
('".$month_to."') as clo_period_to,
MIN(IF inpol_process_status IN ('N', 'R') AND inped_endorsement_serial = inpol_last_endorsement_serial THEN 
inpol_policy_serial ELSE NULL ENDIF) as clo_new_renewal_serial_in_the_year, /* If Null => No New Or Renewal has been recorded in the specified period */
COALESCE((SELECT pol.inpol_process_status FROM inpolicies as pol 
      WHERE pol.inpol_policy_serial = clo_new_renewal_serial_in_the_year) /* New Or Renewal Status */
      , IF Count() = 1 THEN IF LIST(inpol_process_status) = 'D' THEN 'D' ELSE 'C' ENDIF /* May Be Declaration Adjustment OR Cancellation */
         ELSE 'E' ENDIF)as clo_calculated_process_status, /* Otherwise Endorsement */
inpol_policy_number,
inpol_period_starting_date,
LIST(DISTINCT inpol_policy_serial)as clo_policy_serials,
(-1 * sum (IF clo_year = inped_year AND clo_period_to = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_to_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5') AND intrd_owner = 'O'))as clo_commission,
inag_agent_code As clo_sort1,           
inity_major_category As clo_sort2,  
inity_insurance_type AS clo_sort3,
inag_long_description As clo_desc1,           
(Select incd_long_description From inpcodes where incd_record_type = '01' And incd_record_code = inity_major_category ) As clo_desc2
FROM ininsurancetypes  
LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code
LEFT OUTER JOIN inminorcodes  ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,           
inpolicyendorsement ,           
inagents ,           
ingeneralagents ,           
inpparam    
WHERE ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs ) 
and          ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ( inpolicyendorsement.inped_status = '1' AND inped_premium_debit_credit <> 0) 
and          ( inpparam.inpr_module_code = 'IN' ) )  
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND clo_sort1 LIKE '".$agent."' 
AND clo_sort2 LIKE '".$major."'
AND clo_sort3 LIKE '".$insurance_type."'
GROUP BY inpparam.inpr_module_code,inpol_policy_number, clo_sort1, clo_desc1, clo_sort2, clo_desc2 ,clo_sort3,inpol_period_starting_date
//HAVING clo_calculated_process_status IN ('N','R')
ORDER BY inpol_policy_number,clo_sort1 ASC , clo_sort2 ASC , clo_sort3 ASC
";
//echo $sql;
return $sql;

}


if ($_POST["action"] == "submit") {
$queries = new insurance_queries();

if ($_POST["agent_from"] != "" && $_POST["agent_to"] != "") {
	$filter_agent = " AND inag_agent_code BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."' ";
}
else{
	$filter_agent = "";
}

$sql = "SELECT * FROM inagents WHERE inag_agent_type = 'A' ".$filter_agent." ORDER BY inag_agent_code ASC";

$result = $sybase->query($sql);

//status labels
$status_label["R"] = "Renewals";
$status_label["N"] = "New";
$status_label["C"] = "Deleted";
$status_label["E"] = "Endorsements";

while ($agent = $sybase->fetch_assoc($result)) {

//get the premiums for the current year. -> $_POST["year"]
	$current_year_sql = get_premium($_POST["year"],$_POST["month_from"],$_POST["month_to"],$agent["inag_agent_code"],$_POST["klado_from"]);
	$agent_result = $sybase->query($current_year_sql);

	//load agent data
	$data[$agent["inag_agent_code"]]["name"] = $agent["inag_long_description"];
	while ($row = $sybase->fetch_assoc($agent_result)) {
	
		//load premiums
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["premium"] += $row["clo_ytd_premium"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]]["total"]["premium"] += $row["clo_ytd_premium"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["fees"] += $row["clo_period_fees"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["stamps"] += $row["clo_period_stamps"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["commission"] += $row["clo_commission"];

		if ($row["clo_calculated_process_status"] == 'N') {
			$data[$agent["inag_agent_code"]]["N_premium_".$_POST["year"]] += $row["clo_ytd_premium"];
		}
		else if ($row["clo_calculated_process_status"] == 'R') {
			$data[$agent["inag_agent_code"]]["R_premium_".$_POST["year"]] += $row["clo_ytd_premium"];		
		}
		else {
			$data[$agent["inag_agent_code"]]["Other_premium_".$_POST["year"]] += $row["clo_ytd_premium"];
		}
		$data[$agent["inag_agent_code"]]["Total_premium_".$_POST["year"]] += $row["clo_ytd_premium"];

		
	}
//get the premiums for the previous year. -> $_POST["year"] -1
	$previous_year_sql = get_premium($_POST["year"] -1,$_POST["month_from"],$_POST["month_to"],$agent["inag_agent_code"],$_POST["klado_from"]);
	$agent_result = $sybase->query($previous_year_sql);

	//load agent data
	$data[$agent["inag_agent_code"]]["name"] = $agent["inag_long_description"];
	while ($row = $sybase->fetch_assoc($agent_result)) {
	
		//load premiums
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["premium"] += $row["clo_ytd_premium"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]]["total"]["premium"] += $row["clo_ytd_premium"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["fees"] += $row["clo_period_fees"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["stamps"] += $row["clo_period_stamps"];
//		$data[$agent["inag_agent_code"]][$_POST["year"]][$row["clo_calculated_process_status"]]["commission"] += $row["clo_commission"];

		if ($row["clo_calculated_process_status"] == 'N') {
			$data[$agent["inag_agent_code"]]["N_premium_".($_POST["year"]-1)] += $row["clo_ytd_premium"];
		}
		else if ($row["clo_calculated_process_status"] == 'R') {
			$data[$agent["inag_agent_code"]]["R_premium_".($_POST["year"]-1)] += $row["clo_ytd_premium"];
		}
		else {
			$data[$agent["inag_agent_code"]]["Other_premium_".($_POST["year"]-1)] += $row["clo_ytd_premium"];
		}
		$data[$agent["inag_agent_code"]]["Total_premium_".($_POST["year"]-1)] += $row["clo_ytd_premium"];

		
	}
	
//get the premium from cymenu
	if ($_POST["year"] -1 <= 2009) {
	
		if ($_POST["klado_from"] == "") {
			$klados = '%%';
		}
		else {
			$klados = $_POST["klado_from"];
		}
		
		$sql = "SELECT SUM(ap_premium)as clo_total_premium,SUM(ap_commission)as clo_total_commission, SUM(ap_plithos)as clo_total_policies,SUM(ap_mif)as clo_mif,SUM(ap_stamps) as clo_stamps,SUM(ap_fees)as clo_fees FROM ap_prod_comm WHERE ap_agent = ".$agent["inag_numeric_key1"]." AND ap_year = '".($_POST["year"] -1)."' AND ap_klados LIKE '".$klados."' AND ap_month_from = ".$_POST["month_from"]." AND ap_month_to = ".$_POST["month_to"]."";
		$cymenu_data = $db->query_fetch($sql);
		$data[$agent["inag_agent_code"]]["Total_premium_".($_POST["year"]-1)] += $cymenu_data["clo_total_premium"];
	}//if year is <= 2009


}//while per agent

//$fields = export_data_prepare_data_from_array($data,'fields');
//$out_data = export_data_prepare_data_from_array($data,'data');

//print_r($out_data);exit();

//export_data_delimited($out_data,$fields,'#','none','download','
//','data');
//print_r($data);

}//if action= submit
$db->show_header();

?>
<style type="text/css">
<!--
.main_text {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	text-decoration: none;
}
-->
</style>


<form name="form1" method="post" action="">
  <table width="453" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center"><strong>Production Reports - New/Renewals Production</strong></td>
    </tr>
    <tr>
      <td width="154" height="28">Year</td>
      <td width="299"><select name="year" id="year">
	  <? for ($i=2010; $i<= date("Y");$i++) { ?>
        <option value="<? echo $i;?>" <? if ($i == $_POST["year"]) echo "selected=\"selected\""; ?>><? echo $i;?></option>
	  <? } ?>
      </select>      </td>
    </tr>
    <tr>
      <td height="28">Month</td>
      <td>From
        <input name="month_from" type="text" id="month_from" value="<? echo $_POST["month_from"];?>" size="6" />
To
<input name="month_to" type="text" id="month_to" value="<? echo $_POST["month_to"];?>" size="6" /></td>
    </tr>
    <tr>
      <td height="28">Agents</td>
      <td>From
        <input name="agent_from" type="text" id="agent_from" value="<? echo $_POST["agent_from"];?>" size="8" />
To
<input name="agent_to" type="text" id="agent_to" value="<? echo $_POST["agent_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category(Klado)  </td>
      <td><input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["insurance_type_from"];?>" size="8" /> 
      ex 19 or 17 etc </td>
    </tr>
    
    
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>


<?
if ($_POST["action"] == "submit") {
?>
<br />
<br />
<div id="print_view_section_html">
<style type="text/css">
<!--
.main_text {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	text-decoration: none;
}
-->
</style>
<table width="715" border="1" cellspacing="0" cellpadding="0" align="center" class="main_text">
  <tr>
    <td colspan="8" align="center"><strong>Production Reports - New/Renewals Production</strong> Year <? echo $_POST["year"];?> Period:<? echo $_POST["month_from"]."-".$_POST["month_to"];?> Agents: <? echo $_POST["agent_from"]."-".$_POST["agent_to"];?> Major: <? echo $_POST["klado_from"];?></td>
    </tr>
<?
$i = 0;
foreach($data as $agent_code => $values) {

if ($i == 0 || ($i%50 == 0)) {
?>

  <tr>
    <td width="65"><strong>Agent Code </strong></td>
    <td width="200"><strong>Agent Name </strong></td>
    <td width="90"><strong><? echo $_POST["year"] -1 ;?> Premium</strong></td>
    <td width="90"><strong><? echo $_POST["year"];?> Renewals</strong></td>
    <td width="90"><strong><? echo $_POST["year"];?> New</strong></td>
    <td width="90"><strong><? echo $_POST["year"];?> Other</strong></td>
    <td width="90"><strong><? echo $_POST["year"];?> Total</strong></td>
    <td width="40"><strong>Diatirisimotita</strong></td>
  </tr>

<? 
} 
$i++;
?>

  <tr>
    <td><? echo "'".$agent_code."'";?></td>
    <td><? echo substr($values["name"],0,25);?></td>
    <td align="center"><? echo $values["Total_premium_".($_POST["year"]-1)];?></td>
    <td align="center"><? echo $values["R_premium_".$_POST["year"]];?></td>
    <td align="center"><? echo $values["N_premium_".$_POST["year"]];?></td>
    <td align="center"><? echo $values["Other_premium_".$_POST["year"]];?></td>
    <td align="center"><? echo $values["Total_premium_".$_POST["year"]];?></td>
    <td align="center"><? if ($values["Total_premium_".($_POST["year"]-1)] != 0) { echo round(100*($values["R_premium_".$_POST["year"]] / $values["Total_premium_".($_POST["year"]-1)]),2)."%"; } ?></td>
  </tr>
<? } ?>
</table>
<div align="center">Endorsements & Cancellations are calculated in the specified period.<br />
Other Premium are endorsements & cancellations that occured in the specified period from New/Renewals that are outside the specified period.</div>
</div>
<? } ?>

<?
$db->show_footer();
?>