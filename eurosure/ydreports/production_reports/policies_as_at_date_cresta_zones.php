<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');

//=============================================================================================================

if ($_POST["action"] == "submit") {

	$klado_exclude = "";
	if ($_POST["klado_exclude"] != "") {
		$klado_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["klado_exclude"]."'";
	}

	$klado = "";
	if ($_POST["klado_from"] != "") {
		$klado = "AND inity_insurance_type >= '".$_POST["klado_from"]."'
AND inity_insurance_type <= '".$_POST["klado_to"]."'
	";
	}//klado
	
	$policy_number = "";
	if ($_POST["policy_number"] != "") {
		$policy_number = " AND inpol_policy_number = '".$_POST["policy_number"]."'";	
	}
	

$sql = "
SELECT  
inpst_postal_code,
inpst_situation_serial,
inpst_district,
inpst_situation_code,
inpit_item_serial,
(
//1701
IF LEFT(inpol_policy_number,4) = '1701' THEN inpit_insured_amount
//1702
ELSE IF LEFT(inpol_policy_number,4) = '1702' THEN 
    (IF initm_item_serial IN (8867) THEN inpit_insured_amount - 1000 ELSE IF initm_item_serial = 35375 THEN inpit_insured_amount ELSE IF initm_item_flag IN ('B', 'N') THEN inpit_insured_amount ELSE 0 ENDIF ENDIF ENDIF)
//1703
ELSE IF LEFT(inpol_policy_number,4) = '1703' THEN 
    (IF initm_item_serial IN (41563) THEN inpit_insured_amount - 1000 ELSE IF initm_item_serial = 41631 THEN inpit_insured_amount ELSE IF initm_item_flag IN ('B', 'N') THEN inpit_insured_amount ELSE 0 ENDIF ENDIF ENDIF)
//1711
ELSE IF LEFT(inpol_policy_number,4) = '1711' THEN 
    (IF LEFT(initm_item_code,17) = '17SC-C6-SHRT-CIRC' THEN 0 ELSE inpit_insured_amount ENDIF)
//1712
ELSE IF LEFT(inpol_policy_number,4) = '1712' THEN 
    (IF initm_item_flag IN ('B','N','E','5','6','7','8') AND initm_item_serial <> 35459 THEN inpit_insured_amount ELSE 0 ENDIF)
//1713
ELSE IF LEFT(inpol_policy_number,4) = '1713' THEN 
    (IF initm_item_flag IN ('B','N','E','6','7') THEN inpit_insured_amount ELSE 0 ENDIF)
//1720
ELSE IF LEFT(inpol_policy_number,4) = '1720' THEN 
    (IF initm_item_flag IN ('1') THEN inpit_insured_amount ELSE 0 ENDIF)
//1730
ELSE IF LEFT(inpol_policy_number,4) = '1730' THEN
    (IF initm_item_flag IN ('B') THEN inpit_insured_amount ELSE 0 ENDIF)

ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
)as clo_insured_amount
,inpol_policy_number
,incd_pcode_serial as clo_risk_type
,incd_long_description as clo_risk_type_serial
,inag_group_code

INTO #cresta_temp_table

FROM inpolicysituations
JOIN inpolicies ON inpol_policy_serial = inpst_policy_serial
JOIN inagents ON inpol_agent_serial = inag_agent_serial
LEFT OUTER JOIN inpolicyendorsement ON inpol_last_endorsement_serial = inped_endorsement_serial
LEFT OUTER JOIN inpolicyitems ON inpit_situation_serial = inpst_situation_serial
LEFT OUTER JOIN initems ON inpit_item_serial = initm_item_serial
LEFT OUTER JOIN inpolicyanalysis ON inpol_policy_serial = inpan_policy_serial
LEFT OUTER JOIN inpcodes ON inpan_analysis_serial = incd_pcode_serial


WHERE 
(inpol_process_status IN ('N','R','E','D')) 
AND inpol_status IN ('A','N') 
AND (inped_year*100+inped_period)<=(".$_POST["up_to_year"]."*100+".$_POST["up_to_period"].") 
AND '".$_POST["as_at_date"]."' BETWEEN inpol_starting_date AND COALESCE(IF (SELECT a.inped_year * 100 + a.inped_period FROM inpolicyendorsement a WHERE a.inped_endorsement_serial = inpol_last_cancellation_endorsement_serial) <= YEAR('".$_POST["as_at_date"]."') * 100 + MONTH('".$_POST["as_at_date"]."') THEN inpol_cancellation_date ELSE NULL ENDIF, inpol_expiry_date) 
AND LEFT(inpol_policy_number,4) >= '".$_POST["klado_from"]."' 
AND LEFT(inpol_policy_number,4) <= '".$_POST["klado_to"]."' 
".$policy_number."

ORDER BY inpol_policy_number


SELECT 
inag_group_code,
inpst_postal_code,
LEFT(inpst_postal_code,1) as inpst_cresta_zone,
inpst_situation_serial,
inpst_district,
inpst_situation_code,
inpol_policy_number,
SUM(clo_insured_amount)as clo_total_insured_amount,
clo_risk_type,
clo_risk_type_serial

FROM #cresta_temp_table
GROUP BY inag_group_code,inpst_situation_serial,inpst_situation_code,inpst_district,inpst_postal_code,inpol_policy_number,clo_risk_type,clo_risk_type_serial
ORDER BY inpst_situation_code ASC
";
//echo $sql."<hr>";
//export_data_delimited($sql,'sybase','#','none','download','
//');

if ($_POST["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"none",'download');
}
else if ($_POST["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
}
else if ($_POST["export_file"] == "totals") {

	$result = $sybase->query($sql);
	while ($row = $sybase->fetch_assoc($result)) {
		
		//get the insured amount for each situation
		$data[$row["inpst_cresta_zone"]]["sum_insured"] += $row["clo_total_insured_amount"];
		$data[$row["inpst_cresta_zone"]]["total_risks"] ++;
		$total += $row["clo_total_insured_amount"];
		
		//if ($row["inpst_cresta_zone"] > 9 || $row["inpst_cresta_zone"] < 1) {
		//	print_r($row);echo "<br><br><br>";	
		//}

		$risktype[$row["clo_risk_type_serial"]]["total_risks"]++;
		$risktype[$row["clo_risk_type_serial"]]["sum_insured"] += $row["clo_total_insured_amount"];
		$risktype[$row["clo_risk_type_serial"]]["risk_type_name"] = $row["clo_risk_type"];
		
		
		//get the premiums.
		$premiums = $sybase->query_fetch("SELECT 

-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium,
-1 * SUM(if incd_pcode_serial = 4279 THEN (if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif) ELSE 0 ENDIF * inped_premium_debit_credit)as clo_eq_premium,
-1 * SUM(if incd_ldg_rsrv_under_reinsurance <> 'Y' THEN (if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif) ELSE 0 ENDIF * inped_premium_debit_credit)as clo_retension_premium,
-1 * SUM(if incd_ldg_rsrv_under_reinsurance = 'Y' AND incd_pcode_serial <> 4279 THEN (if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif) ELSE 0 ENDIF * inped_premium_debit_credit)as clo_fire_premium

FROM inpolicyloadings 
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN inpolicyitems ON inplg_pit_auto_serial = inpit_pit_auto_serial
JOIN inpolicies ON inpol_policy_serial = inpit_policy_serial
JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial
LEFT OUTER JOIN inpcodes ON inldg_claim_reserve_group = incd_pcode_serial

WHERE 
inped_status = 1
AND inpit_situation_serial = ".$row["inpst_situation_serial"]);
		
			
		//arrange in pands
		if ($row["clo_total_insured_amount"] < 100001) {
			$band = "Band1";
		}
		else if ($row["clo_total_insured_amount"] < 200001) {
			$band = "Band2";
		}
		else if ($row["clo_total_insured_amount"] < 300001) {
			$band = "Band3";
		}
		else if ($row["clo_total_insured_amount"] < 400001) {
			$band = "Band4";
		}
		else if ($row["clo_total_insured_amount"] < 500001) {
			$band = "Band5";
		}
		else if ($row["clo_total_insured_amount"] < 750001) {
			$band = "Band6";
		}
		else if ($row["clo_total_insured_amount"] < 1000001) {
			$band = "Band7";
		}
		else if ($row["clo_total_insured_amount"] < 1250001) {
			$band = "Band8";
		}
		else if ($row["clo_total_insured_amount"] < 1500001) {
			$band = "Band9";
		}
		else if ($row["clo_total_insured_amount"] < 2000001) {
			$band = "Band10";
		}
		else if ($row["clo_total_insured_amount"] > 2000000) {
			$band = "Band11";
		}
		$risktype[$row["clo_risk_type_serial"]][$band."TOTAL IN.AMOUNT"] += $row["clo_total_insured_amount"];
		$risktype[$row["clo_risk_type_serial"]][$band."Total"] ++;
		$risktype[$row["clo_risk_type_serial"]][$band."-EQ-PREMIUM"] +=  $premiums["clo_eq_premium"];
		$risktype[$row["clo_risk_type_serial"]][$band."-FIRE-PREMIUM"] +=  $premiums["clo_fire_premium"];
		$risktype[$row["clo_risk_type_serial"]][$band."-RETAINED-PREMIUM"] +=  $premiums["clo_retension_premium"];
		$risktype[$row["clo_risk_type_serial"]][$band."-TOTAL-PREMIUM"] +=  $premiums["clo_total_premium"];
		//total
		$risktype["ALL"][$band."TOTAL IN.AMOUNT"] += $row["clo_total_insured_amount"];
		$risktype["ALL"][$band."Total"] ++;
		$risktype["ALL"][$band."-EQ-PREMIUM"] +=  $premiums["clo_eq_premium"];
		$risktype["ALL"][$band."-FIRE-PREMIUM"] +=  $premiums["clo_fire_premium"];
		$risktype["ALL"][$band."-RETAINED-PREMIUM"] +=  $premiums["clo_retension_premium"];
		$risktype["ALL"][$band."-TOTAL-PREMIUM"] +=  $premiums["clo_total_premium"];
		
		if ($premiums["clo_eq_premium"] > 0) {
			
			@$eqround = round((($premiums["clo_eq_premium"]/$row["clo_total_insured_amount"])*1000),1);
		
		}
		if ($eqround != 0.6 ){
			$prob[$row["inpol_policy_number"]] = "Round=".$eqround." -> I.A=".$row["clo_total_insured_amount"]." -> EQ=".$premiums["clo_eq_premium"]." -> Fire=".$premiums["clo_fire_premium"];
		}


	}//while all records.

}//show totals.
//print_r($risktype);
}//if action= submit

//print_r($prob);

$db->show_header();


?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});

});

</script>

<form name="form1" method="post" action="">
  <table width="534" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Policies As At Date Cresta Zones </td>
    </tr>
    
    <tr>
      <td width="154" height="28">As At Date </td>
      <td width="380"><input name="as_at_date" type="text" id="as_at_date" value="<? echo $_POST["as_at_date"];?>"></td>
    </tr>
    
    <tr>
      <td height="28">Up To year </td>
      <td>Year
        <input name="up_to_year" type="text" id="up_to_year" size="5" value="<? echo $_POST["up_to_year"];?>" /> 
      Period 
      <input name="up_to_period" type="text" id="up_to_period" size="5" value="<? echo $_POST["up_to_period"];?>"/>
      All the policies posted up to this period defined.</td>
    </tr>
    <tr>
      <td height="28">Insurance Type  </td>
      <td>From
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["klado_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["insurance_type_exclude"];?>"/>
      (exclude) ex 17% </td>
    </tr>
    
    <tr>
      <td height="28">Policy Number</td>
      <td><input type="text" name="policy_number" id="policy_number" value="<? echo $_POST["policy_number"];?>" /></td>
    </tr>
    <tr>
      <td height="28">Export File</td>
      <td><input name="export_file" type="radio" value="no" <? if ($_POST["export_file"] == "no") echo "checked=\"checked\"";?> />
No
  <input name="export_file" type="radio" value="delimited" <? if ($_POST["export_file"] == "delimited") echo "checked=\"checked\"";?> />
Delimited (#)
<input name="export_file" type="radio" value="totals" <? if ($_POST["export_file"] == "totals") echo "checked=\"checked\"";?> />
Show Totals  </td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br />
<br />
<div id="print_view_section_html">
<?
if ($_POST["export_file"] == "totals") {
	//fix the zones
	//print_r($data);
	foreach($data as $zone_values => $zone) {
		switch ($zone_values) {
			case 1: 
				$output["Nicosia"]["total_policies"] += $zone["total_risks"];
				$output["Nicosia"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 2: 
				$output["Nicosia"]["total_policies"] += $zone["total_risks"];
				$output["Nicosia"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 3: 
				$output["Limasol"]["total_policies"] += $zone["total_risks"];
				$output["Limasol"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 4: 
				$output["Limasol"]["total_policies"] += $zone["total_risks"];
				$output["Limasol"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 5: 
				$output["Famagusta"]["total_policies"] += $zone["total_risks"];
				$output["Famagusta"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 6: 
				$output["Larnaka"]["total_policies"] += $zone["total_risks"];
				$output["Larnaka"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 7: 
				$output["Larnaka"]["total_policies"] += $zone["total_risks"];
				$output["Larnaka"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 8: 
				$output["Pafos"]["total_policies"] += $zone["total_risks"];
				$output["Pafos"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			case 9: 
				$output["Kerynia"]["total_policies"] += $zone["total_risks"];
				$output["Kerynia"]["total_sum_insured"] += $zone["sum_insured"];
				break;
			default:
				$output["Other"]["total_policies"] += $zone["total_risks"];
				$output["Other"]["total_sum_insured"] += $zone["sum_insured"];
				break;
				
		}//switch
	}

?>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="137">Zone</td>
    <td width="234">Policies</td>
    <td width="179">Insured Amount </td>
  </tr>
	<?
	foreach($output as $tzone_values => $tzone) {
		$total_policies += $tzone["total_policies"];
		$total_insured_amount += $tzone["total_sum_insured"];
	?>
	  <tr>
		<td><? echo $tzone_values;?></td>
		<td><? echo $tzone["total_policies"];?></td>
		<td><? echo $tzone["total_sum_insured"];?></td>
	  </tr>

	<? 
	
	}//for each zone
?>
	  <tr>
		<td><strong>TOTAL</strong></td>
		<td><? echo $total_policies;?></td>
		<td><? echo $total_insured_amount;?></td>
	  </tr>
</table>
<br />
<br />
<br />

<?
function rename_band($band) {

	switch ($band) {
		case '1': $return = '0-100.000';break;
		case '2': $return = '100.001-200.000';break;
		case '3': $return = '200.001-300.000';break;
		case '4': $return = '300.001-400.000';break;
		case 5: $return = '400.001-500.000';break;
		case 6: $return = '500.001-750.000';break;
		case 7: $return = '750.001-1.000.000';break;
		case 8: $return = '1.000.001-1.250.000';break;
		case 9: $return = '1.250.001-1.500.000';break;
		case 10: $return = '1.500.001-2.000.000';break;
		case 11: $return = 'Over 2.000.000';break;
	
	}//switch
return $return;
}
foreach($risktype as $risktypevalue => $risktype_data) {

?>
<table width="917" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="143"><strong>
      <? if ($risktypevalue == "") echo "PRIVATE"; else echo $risktypevalue; ?>
    </strong></td>
    <td width="130" align="center"><strong>EQ Premium </strong></td>
    <td width="130" align="center"><strong>Fire Premium </strong></td>
    <td width="130" align="center"><strong>Retained Premium </strong></td>
    <td width="118" align="center"><strong>Total Risks </strong></td>
    <td width="125" align="center"><strong>Insured Amount </strong></td>
    <td width="125" align="center"><strong>TOTAL Premium </strong></td>
  </tr>
<?
for($i=1;$i<12;$i++) {
?>
  <tr>
    <td><strong><? echo rename_band($i);?></strong></td>
    <td align="center"><? echo $risktype_data["Band".$i."-EQ-PREMIUM"];?></td>
    <td align="center"><? echo $risktype_data["Band".$i."-FIRE-PREMIUM"];?></td>
    <td align="center"><? echo $risktype_data["Band".$i."-RETAINED-PREMIUM"];?></td>
    <td align="center"><? echo $risktype_data["Band".$i."Total"];?></td>
    <td align="center"><? echo $risktype_data["Band".$i."TOTAL IN.AMOUNT"];?></td>
    <td align="center"><? echo $risktype_data["Band".$i."-TOTAL-PREMIUM"];?></td>
  </tr>
<? 
}
?>
</table>
<br />
<?
}//risktype

//print_r($risktype);
}
else {
echo $table_data;
}
?>
</div>
<?
$db->show_footer();
?>