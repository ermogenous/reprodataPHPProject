<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
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
	
	$cover = "";
	if ($_POST["cover"] != "ALL") {
		$cover = "AND inpol_cover = '".$_POST["cover"]."'";	
	}
	

$sql = "
SELECT  
inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,   
inpol_policy_serial,
inpol_policy_number,
inity_insurance_type,
(SELECT 
//1701
IF inity_insurance_type = '1701' THEN SUM(inpit_insured_amount)
//1702
ELSE IF inity_insurance_type = '1702' THEN 
    SUM(IF initm_item_serial IN (8867) THEN inpit_insured_amount - 1000 ELSE IF initm_item_serial = 35375 THEN inpit_insured_amount ELSE IF initm_item_flag IN ('B', 'N') THEN inpit_insured_amount ELSE 0 ENDIF ENDIF ENDIF)
//1703
ELSE IF inity_insurance_type = '1703' THEN 
    SUM(IF initm_item_serial IN (41563) THEN inpit_insured_amount - 1000 ELSE IF initm_item_serial = 41631 THEN inpit_insured_amount ELSE IF initm_item_flag IN ('B', 'N') THEN inpit_insured_amount ELSE 0 ENDIF ENDIF ENDIF)
//1711
ELSE IF inity_insurance_type = '1711' THEN 
    SUM(IF LEFT(initm_item_code,17) = '17SC-C6-SHRT-CIRC' THEN 0 ELSE inpit_insured_amount ENDIF)
//1712
ELSE IF inity_insurance_type = '1712' THEN 
    SUM(IF initm_item_flag IN ('B','N','E','5','6','7','8') AND initm_item_serial <> 35459 THEN inpit_insured_amount ELSE 0 ENDIF)
//1720
ELSE IF inity_insurance_type = '1720' THEN 
    SUM(IF initm_item_flag IN ('1') THEN inpit_insured_amount ELSE 0 ENDIF)
//1730
ELSE IF inity_insurance_type = '1730' THEN 
    SUM(IF initm_item_flag IN ('B') THEN inpit_insured_amount ELSE 0 ENDIF)

//1799
ELSE IF inity_insurance_type = '1799' THEN 
    SUM(inpit_insured_amount)

//other (Motor)
ELSE SUM(inpit_insured_amount)

ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
ENDIF
ENDIF


FROM
inpolicyitems
JOIN initems ON initm_item_serial = inpit_item_serial


WHERE inpit_policy_serial = inpolicies.inpol_policy_serial

)as clo_total_insured_amount,
        
DATE('".$_POST["from_year"]."/".$_POST["from_period"]."/01') as clo_from_date,           
DATE('".$_POST["as_at_date"]."') as clo_as_at_date,           
(SELECT inpr_financial_period FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_period,           
(SELECT inpr_financial_year FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_year,           
inclaims.inclm_process_status ,           
inclaims.inclm_open_date ,           
IF clo_process_status IN ('C', 'W') THEN YEAR(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_year,           
IF clo_process_status IN ('C', 'W') THEN MONTH(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_period,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve_as_at_date,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries_as_at_date,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_paid_as_at_date,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_as_at_date,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_reserve_pay_recovery_exp,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp,          
 SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_reserves,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_est_recoveries,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_payments,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_recoveries,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'I' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_initial_res_for_payments,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'R' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_reest_res_for_payments,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_est_recoveries_period,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_payments,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_recoveries,           
CASE WHEN inclm_process_status = 'I' THEN 'I' WHEN clo_estimated_reserve_as_at_date = 0 THEN IF COUNT(IF incvsdt_line_sub_type <> '' THEN 1 ELSE NULL ENDIF) = 0 THEN 'P' ELSE 'W' ENDIF WHEN clo_estimated_reserve_as_at_date - clo_paid_as_at_date = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date = 0 THEN 'C' WHEN (clo_estimated_reserve_as_at_date - clo_reserve_pay_recovery_exp) - (clo_paid_as_at_date - clo_payments_recovery_exp) = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'R' ELSE 'O' END as clo_process_status    

FROM inclaims ,           
inpolicies ,           
inclients ,           
ininsurancetypes ,           
inagents ,           
ingeneralagents ,           
inclaims_asat_date     

WHERE 
( inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial ) 
and          ( inclients.incl_client_serial = inpolicies.inpol_client_serial ) 
and          ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and          ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial ) 
and          ( inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial ) 
and          ( inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial ) 
and          ((inclaims.inclm_process_status <> 'I' /* Exclude Initial */) 
And          (inclaims.inclm_status <> 'D' /* Exclude Deleted */) 
and          (inclaims.inclm_open_date <= clo_as_at_date)) 
And          ( inclaims_asat_date.incvsdt_operation_date <= clo_as_at_date )  
AND  1=1  
AND inclm_status in ('O','A','D') 
AND inclm_open_date >='".$_POST["open_date_from"]."' 
AND inclm_open_date <='".$_POST["open_date_to"]."' 
".$klado_exclude."
".$klado."
".$cover."

GROUP BY inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,           
inclaims.inclm_process_status ,           
inclaims.inclm_open_date   ,
inclm_open_date ,
inpol_policy_serial,
inpol_policy_number,
inity_insurance_type

HAVING  1=1  
AND clo_process_status in ('P','O','W','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$_POST["from_year"]."/".$_POST["from_period"]."/01') * 100) + MONTH('".$_POST["from_year"]."/".$_POST["from_period"]."/01') OR clo_closed_year = 0) 

ORDER BY inity_insurance_type,inpol_policy_number,inclm_open_date ASC

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
	$row["clo_risk_type_serial"] = 'TOTALS';
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
		//total
		$risktype["ALL"][$band."TOTAL IN.AMOUNT"] += $row["clo_total_insured_amount"];
		$risktype["ALL"][$band."Total"] ++;
		$risktype["ALL"][$band."TOTAL-PAYMENTS"] +=  $row["clo_period_payments"];
		$os_reserve = $row["clo_bf_reserves"] + $row["clo_initial_res_for_payments"] + $row["clo_reest_res_for_payments"] - $row["clo_paid_as_at_date"];
		
		$risktype["ALL"][$band."TOTAL-OS-RESERVE"] += $os_reserve ;
		$risktype["ALL"][$band."TOTAL-RECOVERIES"] +=  $row["clo_period_recoveries"];
		$os_recoveries = $row["clo_bf_est_recoveries"] + $row["clo_est_recoveries_period"] - $row["clo_recoveries_as_at_date"];
		$risktype["ALL"][$band."TOTAL-OS-RECOVERIES"] +=  $os_recoveries;
		$risktype["ALL"][$band."TOTAL-COST"] +=  $row["clo_period_payments"] + $os_reserve - $row["clo_period_recoveries"] - $os_recoveries;
		$risktype["TOTAL-CLAIMS"]++;
		$risktype["TOTAL-COST"] += $row["clo_period_payments"] + $os_reserve - $row["clo_period_recoveries"] - $os_recoveries;
			
		if ($premiums["clo_eq_premium"] > 0) {
			
			@$eqround = round((($premiums["clo_eq_premium"]/$row["clo_total_insured_amount"])*1000),1);
		
		}
		if ($eqround != 0.6 ){
			$prob[$row["inpol_policy_number"]] = "Round=".$eqround." -> I.A=".$row["clo_total_insured_amount"]." -> EQ=".$premiums["clo_eq_premium"]." -> Fire=".$premiums["clo_fire_premium"];
		}

	}//while all rows
	

}//show totals.
//print_r($risktype);
}//if action= submit

//print_r($prob);

$db->show_header();

?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_to").datepicker({dateFormat: 'yy-mm-dd'});


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
      <td height="28">From Period/Year </td>
      <td>Year
        <input name="from_year" type="text" id="from_year" size="5" value="<? echo $_POST["from_year"];?>" />
        Period
      <input name="from_period" type="text" id="from_period" size="5" value="<? echo $_POST["from_period"];?>" /></td>
    </tr>
    <tr>
      <td height="28">Claim Open Date </td>
      <td>From
        <input name="open_date_from" type="text" id="open_date_from" size="10" value="<? echo $_POST["open_date_from"];?>" /> 
        To 
      <input name="open_date_to" type="text" id="open_date_to" size="10" value="<? echo $_POST["open_date_to"];?>"/></td>
    </tr>
    <tr>
      <td height="28">Insurance Type  </td>
      <td>From
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["klado_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" />
Cover 
<select name="cover" id="cover">
  <option value="ALL" <? if ($_POST["cover"] == "ALL") echo "selected=\"selected\"";?>>ALL</option>
  <option value="A" <? if ($_POST["cover"] == "A") echo "selected=\"selected\"";?>>Third Party</option>
  <option value="B" <? if ($_POST["cover"] == "B") echo "selected=\"selected\"";?>>Fire &amp; Theft</option>
  <option value="C" <? if ($_POST["cover"] == "C") echo "selected=\"selected\"";?>>Comprehensive</option>
</select></td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["insurance_type_exclude"];?>"/>
      (exclude) ex 17% </td>
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

?>
<table width="1176" border="1" cellspacing="0" cellpadding="0" align="center" class="row_table_border">
  <tr class="row_table_head">
    <td colspan="9" align="center"><strong>As At Claims. Bands based on Policy insured amount.<br /> 
      As At Date:<? echo $_POST["as_at_date"];?> From Period:<? echo $_POST["from_period"]."/".$_POST["from_year"];?> Open Date: <? echo $_POST["open_date_from"]." To: ".$_POST["open_date_to"];?> Insurance Types: <? echo $_POST["klado_from"]." To: ".$_POST["klado_to"];?> Exclude Insurance Type: <? echo $_POST["klado_exclude"];?></strong></td>
    </tr>
  <tr>
    <td width="143"><strong>TOTALS</strong></td>
    <td width="130" align="center"><strong>Total Cost</strong></td>
    <td width="130" align="center"><strong>Cost % </strong></td>
    <td width="130" align="center"><strong>Payments In Period</strong></td>
    <td width="130" align="center"><strong>O/S Reserve</strong></td>
    <td width="118" align="center"><strong>Recoveries</strong></td>
    <td width="125" align="center"><strong>O/S Recoveries</strong></td>
    <td width="125" align="center"><strong>Claims %</strong> </td>
    <td width="125" align="center"><strong>Total Claims</strong></td>
  </tr>
<?
for($i=1;$i<12;$i++) {
$total_payments += $risktype["ALL"]["Band".$i."TOTAL-PAYMENTS"];
$total_os_reserve += $risktype["ALL"]["Band".$i."TOTAL-OS-RESERVE"];
$total_recoveries += $risktype["ALL"]["Band".$i."TOTAL-RECOVERIES"];
$total_os_recoveries += $risktype["ALL"]["Band".$i."TOTAL-OS-RECOVERIES"];
?>
  <tr>
    <td><strong><? echo rename_band($i);?></strong></td>
    <td align="center"><? echo $risktype["ALL"]["Band".$i."TOTAL-COST"];?>&nbsp;</td>
    <td align="center"><? echo round((($risktype["ALL"]["Band".$i."TOTAL-COST"] / $risktype["TOTAL-COST"])*100),2);?></td>
    <td align="center"><? echo $risktype["ALL"]["Band".$i."TOTAL-PAYMENTS"];?>&nbsp;</td>
    <td align="center"><? echo $risktype["ALL"]["Band".$i."TOTAL-OS-RESERVE"];?>&nbsp;</td>
    <td align="center"><? echo $risktype["ALL"]["Band".$i."TOTAL-RECOVERIES"];?>&nbsp;</td>
    <td align="center"><? echo $risktype["ALL"]["Band".$i."TOTAL-OS-RECOVERIES"];?>&nbsp;</td>
    <td align="center"><? echo round((($risktype["ALL"]["Band".$i."Total"] / $risktype["TOTAL-CLAIMS"])*100),2);?></td>
    <td align="center"><? echo $risktype["ALL"]["Band".$i."Total"];?>&nbsp;</td>
  </tr>
<? 
}
?>
  <tr>
    <td><strong>TOTAL</strong></td>
    <td align="center"><strong><? echo $risktype["TOTAL-COST"];?></strong></td>
    <td align="center">100%</td>
    <td align="center"><? echo $total_payments;?></td>
    <td align="center"><? echo $total_os_reserve;?></td>
    <td align="center"><? echo $total_recoveries;?></td>
    <td align="center"><? echo $total_os_recoveries;?></td>
    <td align="center">100%</td>
    <td align="center"><? echo $risktype["TOTAL-CLAIMS"];?></td>
  </tr>
</table>
<br />
<?

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