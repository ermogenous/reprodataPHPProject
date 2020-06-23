<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
$sybase = new Sybase();

$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');

//=============================================================================================================

if ($_POST["action"] == "submit") {
$queries = new insurance_queries();

//agent group and where
if ($_POST["agent_from"] == "") {
	$agent_group = "''";
	$where_agent = '';
}
else {
	$agent_group = "inag_agent_code";
	$where_agent = "AND clo_sort1 BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."'";
	$claim_agents = "AND inag_agent_code BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."'";
}

//klados where 
if ($_POST["klado_from"] != "" && $_POST["klado_to"] != "") {
	$where_klado = "AND clo_sort2 BETWEEN '".$_POST["klado_from"]."' AND '".$_POST["klado_to"]."'";
	$group_major = "inity_major_category";
	$claim_major = "AND LEFT(inity_insurance_type,2) BETWEEN '".$_POST["klado_from"]."' AND '".$_POST["klado_to"]."'";
}
else {
	$where_klado = "";
	$group_major = "''";
}

//klados where exclude
if ($_POST["klado_exclude"] != "") {
	$where_klado_exclude = "AND clo_sort2 NOT LIKE '".$_POST["klado_exclude"]."'";
	$claim_major_exclude = "AND LEFT(inity_insurance_type,2) NOT LIKE '".$_POST["klado_exclude"]."'";
}
else {
	$where_klado_exclude = "";
}

//insurance type where
if ($_POST["insurance_type"] != "") {
	$where_insurance_type = "AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'";
	$group_insurance_type = "inity_insurance_type";
}
else {
	$where_insurance_type = "";
	$group_insurance_type = "''";
}

//insurance type exclude where
if ($_POST["insurance_type_exclude"] != "") {
	$where_insurance_type_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'";
}
else {
	$where_insurance_type_exclude = "";
}

//payment codes
$pay_codes = explode(',',$_POST["payment_code"]);
$i=0;
foreach ($pay_codes as $value){
$i++;
	if ($i > 1) {
		$payment_codes .= ",";	
	}
	$payment_codes .= "'".$value."'";
	
}
if ($_POST["payment_code"] != "") {
	$where_payment_codes = "AND clo_payment_code IN (".$payment_codes.")";	
}
else {
	$where_payment_codes = "";
}


//GET CLAIM INFORMATION=======================================GET CLAIM INFORMATION================================GET CLAIM INFORMATION============================GET CLAIM INFORMATION

if ($_POST["open_date_from"] != "" && $_POST["open_date_to"]) {

	$claims_open_date_sql = "AND inclm_open_date >='".$_POST["open_date_from"]."' AND inclm_open_date <='".$_POST["open_date_to"]."'";

}

$sql_claims = "
SELECT  inity_insurance_type ,
inity_short_description ,
inclaims.inclm_claim_serial ,
inclaims.inclm_claim_number ,
DATE('".$_POST["year"]."-".$_POST["month_from"]."-01') as clo_from_date,
DATE('".$_POST["as_at_date"]."') as clo_as_at_date,
(SELECT inpr_financial_period FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_period,           
(SELECT inpr_financial_year FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_year,           
inclaims.inclm_process_status ,           
inclaims.inclm_open_date ,           
IF clo_process_status IN ('C','W') THEN YEAR(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_year,           
IF clo_process_status IN ('C','W') THEN MONTH(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_period,           
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
//SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * (SELECT incri_value FROM inclaimreserveitems where incri_irq_request_serial = incvsdt_line_auto_serial /*AND incri_code_serial = 3961*/) ELSE 0 ENDIF )as clo_payment_code

into #temp

FROM
inclaims
JOIN inpolicies ON inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial
JOIN ininsurancetypes ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN inagents ON inagents.inag_agent_serial = inpolicies.inpol_agent_serial
JOIN inclaims_asat_date ON inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial

WHERE 
inclaims.inclm_process_status <> 'I' /* Exclude Initial */
And inclaims.inclm_status <> 'D' /* Exclude Deleted */
And inclaims.inclm_open_date <= clo_as_at_date
And inclaims_asat_date.incvsdt_operation_date <= clo_as_at_date

AND  1=1  
AND inclm_status in ('O','A','D') 
".$claims_open_date_sql."
".$claim_agents."
".$claim_major."
".$claim_major_exclude."
".$where_insurance_type."
".$where_insurance_type_exclude."


GROUP BY 
inclaims.inclm_claim_serial,
inclaims.inclm_claim_number ,
inclaims.inclm_process_status ,  
inclaims.inclm_open_date   , 
inity_insurance_type, 
inity_short_description,
inclm_open_date

HAVING  
1=1  
AND clo_process_status in ('O','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$_POST["year"]."-".$_POST["month_from"]."-01') * 100) + MONTH('".$_POST["year"]."-".$_POST["month_from"]."-01') OR clo_closed_year = 0) /*from date*/

ORDER BY  inity_insurance_type ASC,inclm_open_date ASC

//--------------------------------------------------------------------------------------------------------------------------------------
SELECT
payment_info.incd_long_description as clo_payment_description
,payment_info.incd_record_code as clo_payment_code
,SUM(IF inclaims_asat_date.incvsdt_line_type = 'S' AND inclaims_asat_date.incvsdt_line_sub_type = 'C6' AND (inclaims_asat_date.incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN inclaims_asat_date.incvsdt_debit_credit * inclaimreserveitems.incri_value ELSE 0 ENDIF)as clo_total_payments
,COUNT(DISTINCT(inclm_claim_serial))as clo_total_count_claims
,COUNT() as clo_total_count_payments

FROM
#temp
JOIN inclaims_asat_date ON inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial
LEFT OUTER JOIN inclaimrecpayrequests ON inirq_request_serial = inclaims_asat_date.incvsdt_line_auto_serial AND incvsdt_line_type = 'S'
LEFT OUTER JOIN inpcodes as related_info ON related_info.incd_pcode_serial = inirq_related_inpcode
LEFT OUTER JOIN inclaimreserveitems ON incri_irq_request_serial = inirq_request_serial
LEFT OUTER JOIN inpcodes as payment_info ON payment_info.incd_pcode_serial = incri_code_serial

WHERE
1=1
".$where_payment_codes."
GROUP BY
clo_payment_description
,clo_payment_code

HAVING clo_total_payments <> 0

ORDER BY 
clo_payment_description ASC
";
//echo $sql_claims;
$result = $sybase->query($sql_claims);
}//if action= submit
$db->show_header();

?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_to").datepicker({dateFormat: 'yy-mm-dd'});


});

</script>
<div id="print_view_section_html">
<form name="form1" method="post" action="">
  <table width="603" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Claims Per Payment Code</td>
    </tr>
    
    <tr>
      <td width="184" height="28"><strong>Claims Period </strong></td>
      <td width="419">From Year
        <input name="year" type="text" id="year" value="<? echo $_POST["year"];?>" size="6" />
        From Period
        <input name="month_from" type="text" id="month_from" value="<? echo $_POST["month_from"];?>" size="6" /></td>
    </tr>
    <tr>
      <td height="28"><strong>Claims As At Date </strong></td>
      <td><input name="as_at_date" type="text" id="as_at_date" size="11" value="<? echo $_POST["as_at_date"];?>"/></td>
    </tr>
    <tr>
      <td height="28">Claims Open Date </td>
      <td><input name="open_date_from" type="text" id="open_date_from" size="11" value="<? echo $_POST["open_date_from"];?>" />
      <input name="open_date_to" type="text" id="open_date_to" size="11" value="<? echo $_POST["open_date_to"];?>" /></td>
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
      <td>From
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["klado_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["klado_exclude"];?>"/>
      (exclude) ex 17% </td>
    </tr>
    <tr>
      <td height="28">Insurance Type </td>
      <td><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_POST["insurance_type"];?>" /> 
      ex 222% Insert % to group by </td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="insurance_type_exclude" type="text" id="insurance_type_exclude" value="<? echo $_POST["insurance_type_exclude"];?>" /> 
      ex 190% or 19% </td>
    </tr>
    
    
    <tr>
      <td height="28">Payment Code </td>
      <td><input name="payment_code" type="text" id="payment_code" size="30" value="<? echo $_POST["payment_code"];?>" />
        can use , for separator</td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
    <tr>
      <td height="28" colspan="2">Bold Fields are required </td>
    </tr>
  </table>
</form>
<br />
<br />
<? 
if ($_POST["action"] == "submit") {
?>


<table width="800" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="99"><strong>Payment Code</strong></td>
    <td width="378"><strong>Description</strong></td>
    <td width="103" align="center"><strong>Amount Total</strong></td>
    <td width="91" align="center"><strong>Total Claims</strong></td>
    <td width="117" align="center"><strong>Total Payments</strong></td>
  </tr>
<?
while($data = $sybase->fetch_assoc($result)) {
	$total_payments += $data["clo_total_payments"];
	$total_count_claims += $data["clo_total_count_claims"];
	$total_count_payments += $data["clo_total_count_payments"];
?>
  <tr>
    <td><? echo $data["clo_payment_code"];?></td>
    <td><? echo $data["clo_payment_description"];?></td>
    <td align="center"><? echo $data["clo_total_payments"];?></td>
    <td align="center"><? echo $data["clo_total_count_claims"];?></td>
    <td align="center"><? echo $data["clo_total_count_payments"];?></td>
  </tr>
<?
}
?>
  <tr>
    <td colspan="2" align="center"><strong>TOTALS</strong></td>
    <td align="center"><strong><? echo $total_payments;?></strong></td>
    <td align="center"><strong><? echo $total_count_claims;?></strong></td>
    <td align="center"><strong><? echo $total_count_payments;?></strong></td>
  </tr>
</table>


</div>
<?
}//if post action = true
$db->show_footer();
?>