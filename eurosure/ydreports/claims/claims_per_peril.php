<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../include/sybase_sqls.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("claims_ratio_report_functions.php");
include("../../tools/export_data.php");

$sybase = new Sybase();
$inqueries = new insurance_queries();

$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');

if ($_POST["action"] == "show") {

	if ($_POST["agent"] == "") {
		$agent = '%%';
	}
	else {
		$agent = $_POST["agent"];
	}
	
	$year = $_POST["year"];
	
	if ($_POST["section"] != 'ALL') {
		$section_sql = $_POST["section"];
	}
	else {
		$section_sql = '%%';
	}
	
	if ($_POST["product"] != "") {
		$product_sql = "AND inity_insurance_type LIKE '".$_POST["product"]."'";	
	}
	
	if ($_POST["remove_product"] != "") {
		$remove_product_sql = "AND inity_insurance_type <> '".$_POST["remove_product"]."'";
	}
	
	$open_date_sql = "";
	if ($_POST["open_date_from"] != "" && $_POST["open_date_to"] != "") {
		$open_date_sql = "AND inclm_open_date >='".$_POST["open_date_from"]."' 
						  AND inclm_open_date <='".$_POST["open_date_to"]."'";
	}
	
	$event_date_sql = "";
	if ($_POST["event_date_from"] != "" && $_POST["event_date_to"] != "") {
		$event_date_sql = "AND inclm_date_of_event  >='".$_POST["event_date_from"]."' 
						  AND inclm_date_of_event  <='".$_POST["event_date_to"]."'";
	}
	
	
	
	$sql = "
SELECT  
inclaims.inclm_claim_serial ,
inclaims.inclm_claim_number ,
peril.incd_long_description as clo_peril_description,
peril.incd_record_code as clo_peril_code,
peril.incd_pcode_serial,
peril.incd_reserve_payment_type,
peril.incd_last_document_number,
inpol_policy_number,
inity_major_category,
inclm_date_of_event,
inclm_claim_date,
incvsdt_operation_date,
RIGHT(LEFT(peril.incd_last_document_number,6),2)as clo_account,
DATE('".$_POST["year"]."-".$_POST["month_from"]."-01') as clo_from_date,
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
CASE WHEN inclm_process_status = 'I' THEN 'I' WHEN clo_estimated_reserve_as_at_date = 0 THEN IF COUNT(IF incvsdt_line_sub_type <> '' THEN 1 ELSE NULL ENDIF) = 0 THEN 'P' ELSE 'W' ENDIF WHEN clo_estimated_reserve_as_at_date - clo_paid_as_at_date = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date = 0 THEN 'C' WHEN (clo_estimated_reserve_as_at_date - clo_reserve_pay_recovery_exp) - (clo_paid_as_at_date - clo_payments_recovery_exp) = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'R' ELSE 'O' END as clo_process_status,
inag_agent_code,
inag_long_description
INTO #temp
FROM 
inclaims
JOIN inpolicies ON inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial
JOIN inclients ON inclients.incl_client_serial = inpolicies.inpol_client_serial
JOIN ininsurancetypes ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN inagents ON inagents.inag_agent_serial = inpolicies.inpol_agent_serial
JOIN ingeneralagents ON inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial
JOIN inclaims_asat_date ON inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial
LEFT OUTER JOIN inpcodes AS peril ON incvsdt_reserve_serial = peril.incd_pcode_serial

WHERE
((inclaims.inclm_process_status <> 'I' /* Exclude Initial */)
And (inclaims.inclm_status <> 'D' /* Exclude Deleted */)
and (inclaims.inclm_open_date <= clo_as_at_date))
And ( inclaims_asat_date.incvsdt_operation_date <= clo_as_at_date )
AND  1=1
AND inclm_status in ('O','A','D')
".$open_date_sql."
".$event_date_sql."
AND inity_major_category LIKE '".$section_sql."'
AND inag_agent_code LIKE '".$agent."'
".$remove_product_sql."
".$product_sql."

GROUP BY 
clo_peril_code,
clo_peril_description,
peril.incd_pcode_serial,
peril.incd_reserve_payment_type,
peril.incd_last_document_number,
inpol_policy_number,
inity_major_category,
inclm_date_of_event,
inclm_claim_date,
incvsdt_operation_date,
inclaims.inclm_claim_serial ,
inclaims.inclm_claim_number ,
inclaims.inclm_process_status ,
inclaims.inclm_open_date   
,inclm_claim_number 
,inag_agent_code
,inag_long_description

HAVING  1=1  
AND clo_process_status in ('O','R','C','W') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (".$_POST["year"]." * 100) + ".$_POST["month_from"]." OR clo_closed_year = 0) 

ORDER BY inclm_claim_number ASC
";

if ($_POST["report_type"] == "peril") {
	$sql .= "
	SELECT 
	clo_peril_code
	,clo_peril_description
	,COUNT(DISTINCT(inclm_claim_number))as clo_total_claims
	,SUM(clo_period_payments)as clo_period_payments
	,SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as clo_os_reserve
	,SUM(clo_period_recoveries) as clo_period_recoveries
	,SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) as clo_os_reserve_recoveries
	
	
	FROM
	#temp
	GROUP BY clo_peril_code,clo_peril_description
	ORDER BY clo_peril_code ASC	
	";
	//echo $sql;
	$result = $sybase->query($sql);
}
else if ($_POST["report_type"] == "claim") {
	
	if ($_POST["payments_reserves"] == 'payments') {
		$select_sql = "
		SUM(clo_period_payments)as 'Payments Amount',
		SUM(clo_period_recoveries) as 'Recovery Amount'";	
		$having_sql = "
		HAVING
		SUM(clo_period_payments) <> 0
	    OR SUM(clo_period_recoveries) <> 0";
		
	}
	else if ($_POST["payments_reserves"] == 'reserves') {
		$select_sql = "
		SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date) as 'Reserve Amount',
		SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) as 'O/S Recovery'";	
		$having_sql = "
		HAVING
		SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date) <> 0
	    OR SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) <> 0";
	}
	else if ($_POST["payments_reserves"] == 'both') {
		$select_sql = "
		SUM(clo_period_payments)as 'Payments Amount',
		SUM(clo_period_recoveries) as 'Recovery Amount',
		SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date) as 'Reserve Amount',
		SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) as 'O/S Recovery'";	
		$having_sql = "";
	}
	
	$sql .= "
	SELECT 
	inclm_claim_number as 'Claim No.',
	inpol_policy_number as 'Policy No.',
	inity_major_category as 'Primary Class',
	clo_account as 'Accounting Class',
	incd_reserve_payment_type as 'Cover',
	inclm_date_of_event as 'Accident Date',
	inclm_claim_date as 'Report Date',
	incvsdt_operation_date as 'Res/Pay Date',
	".$select_sql."
	
	FROM
	#temp

	GROUP BY 
	inclm_claim_number,
	inpol_policy_number,
	inity_major_category,
	clo_account,
	incd_reserve_payment_type,
	inclm_date_of_event,
	inclm_claim_date,
	incvsdt_operation_date
	
	".$having_sql."
	
	ORDER BY 
	inclm_claim_number ASC	

	";
	echo $sql;
	$output_table = export_data_html_table($sql,'sybase');
}

}//if action show



$db->show_header();
?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_to").datepicker({dateFormat: 'yy-mm-dd'});
$("#event_date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#event_date_to").datepicker({dateFormat: 'yy-mm-dd'});

});

</script>

<form action="" method="post"><table width="577" border="1" align="center">
  <tr>
    <td colspan="2" align="center">Claims Per Peril Report </td>
    </tr>
  <tr>
    <td width="132">Major</td>
    <td width="429"><select name="section" id="section">
      <option value="ALL" <? if ($_POST["section"] == 'ALL') echo "selected=\"selected\"";?>>ALL</option>
      <option value="10" <? if ($_POST["section"] == '10') echo "selected=\"selected\"";?>>10 P.A</option>
      <option value="16" <? if ($_POST["section"] == '16') echo "selected=\"selected\"";?>>16 Goods In Transit</option>
      <option value="17" <? if ($_POST["section"] == '17') echo "selected=\"selected\"";?>>17 Fire</option>
      <option value="19" <? if ($_POST["section"] == '19') echo "selected=\"selected\"";?>>19 Motor</option>
      <option value="21" <? if ($_POST["section"] == '21') echo "selected=\"selected\"";?>>21 Marine</option>
      <option value="22" <? if ($_POST["section"] == '22') echo "selected=\"selected\"";?>>22 P.L</option>
    </select>    </td>
  </tr>
  <tr>
    <td>Product</td>
    <td><input name="product" type="text" id="product" value="<? echo $_POST["product"];?>" />
      Example: 1901 OR 19%</td>
  </tr>
  <tr>
    <td>Remove Product </td>
    <td><input name="remove_product" type="text" id="remove_product" value="<? echo $_POST["remove_product"];?>" /> 
    Example: 19TC</td>
  </tr>
  <tr>
    <td>From Year</td>
    <td><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
  </tr>
  <tr>
    <td>From Month</td>
    <td><input name="month_from" type="text" id="month_from" value="<? echo $_POST["month_from"];?>"></td>
  </tr>
  <tr>
    <td>As At Date </td>
    <td>      <input name="as_at_date" type="text" id="as_at_date" value="<? if ($_POST["as_at_date"] == "") echo date("Y-m-d"); else echo $_POST["as_at_date"];?>">
    YYYY-MM-DD 2009-12-31   </td>
  </tr>
  <tr>
    <td>Open Date </td>
    <td>From
      <input name="open_date_from" type="text" id="open_date_from" size="8" value="<? echo $_POST["open_date_from"];?>">
      To 
      <input name="open_date_to" type="text" id="open_date_to" size="8" value="<? echo $_POST["open_date_to"];?>"></td>
  </tr>
  <tr>
    <td>Date Of Event </td>
    <td>From
      <input name="event_date_from" type="text" id="event_date_from" size="8" value="<? echo $_POST["event_date_from"];?>" />
To
<input name="event_date_to" type="text" id="event_date_to" size="8" value="<? echo $_POST["event_date_to"];?>" /></td>
  </tr>
  <tr>
    <td>Agent</td>
    <td><input name="agent" type="text" id="agent" size="9" value="<? echo $_POST["agent"];?>" />
      New Codes Only </td>
  </tr>
  
  
  <tr>
    <td>Payments/Reserves</td>
    <td><select name="payments_reserves" id="payments_reserves">
      <option value="both" <? if ($_POST["payments_reserves"] == 'both') echo "selected=\"selected\"";?>>Both</option>
      <option value="reserves" <? if ($_POST["payments_reserves"] == 'reserves') echo "selected=\"selected\"";?>>Only Reserves</option>
      <option value="payments" <? if ($_POST["payments_reserves"] == 'payments') echo "selected=\"selected\"";?>>Only Payments</option>
    </select></td>
  </tr>
  <tr>
    <td>Report Type</td>
    <td><select name="report_type" id="report_type">
      <option value="peril" <? if ($_POST["report_type"] == 'peril') echo "selected=\"selected\"";?>>Per Peril</option>
      <option value="claim" <? if ($_POST["report_type"] == 'claim') echo "selected=\"selected\"";?>>Per Claim/Reserve/Payment</option>
    </select></td>
  </tr>
  
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="submit" name="Submit" value="Submit"></td>
  </tr>
</table>
</form>

<? 
if ($_POST["action"] == "show") {
?>
<br /><br />
<div id="print_view_section_html">
<?
	if ($_POST["report_type"] == "peril") {
?>
<table width="787" border="1" cellspacing="0" cellpadding="0" align="center" class="main_text">
  <tr>
    <td colspan="8" align="center">Claims Per Peril Code For Major [<? echo $_POST["section"];?>] For Products [<? echo $_POST["product"];?>] For Periods [<? echo $_POST["month_from"]."/".$_POST["year"];?>] As At Date[<? echo $_POST["as_at_date"];?>]<br />Open Date [<? echo $_POST["open_date_from"]."->".$_POST["open_date_to"];?>] For Agents [<? echo $_POST["agent"];?>]</td>
  </tr>
  <tr>
    <td width="76"><strong>Peril Code</strong></td>
    <td width="208"><strong>Peril Description</strong></td>
    <td width="60" align="center"><strong>Claims Count</strong></td>
    <td width="85" align="center"><strong>Period Payments</strong></td>
    <td width="85" align="center"><strong>O/S Reserve</strong></td>
    <td width="85" align="center"><strong>Period Recoveries</strong></td>
    <td width="91" align="center"><strong>O/S Recoveries</strong></td>
    <td width="79" align="center"><strong>Total Cost</strong></td>
  </tr>
<?
	while ($row = $sybase->fetch_assoc($result)) {
?>
  <tr>
    <td><? echo $row["clo_peril_code"];?></td>
    <td><? echo $row["clo_peril_description"];?></td>
    <td align="center"><? echo $row["clo_total_claims"];?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_period_payments"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_os_reserve"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_period_recoveries"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_os_reserve_recoveries"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_period_payments"] + $row["clo_os_reserve"] - $row["clo_period_recoveries"] - $row["clo_os_reserve_recoveries"]);?></td>
  </tr>
<? 
$total_claims += $row["clo_total_claims"];
$total_payments += $row["clo_period_payments"];
$total_reserve += $row["clo_os_reserve"];
$total_recoveries += $row["clo_period_recoveries"];
$total_os_recoveries += $row["clo_os_reserve_recoveries"];
} ?>
  <tr>
    <td colspan="2" align="center" height="20"><strong>Totals</strong></td>
	<td align="center"><strong><? echo $total_claims;?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_payments);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_reserve);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_recoveries);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_os_recoveries);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_payments + $total_reserve - $total_recoveries - $total_os_recoveries);?></strong></td>
  </tr>
</table>

<?
	}//if to report type -> PERILS
	else {

		echo $output_table;

	}
?>
</div>
<?
}//if action show and show only totals

$db->show_footer();
?>