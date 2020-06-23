<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1,'windows-1253');
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
		$agent = "AND inag_agent_code = '".$_POST["agent"]."'";
	}
	
	if ($_POST["product"] != "") {
		$product = "AND inity_insurance_type LIKE '".$_POST["product"]."'";
	}
	else {
		$product = "";
	}
	
	if ($_POST["product_exclude"] != "") {
		$product_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["product_exclude"]."'";
	}
	else {
		$product_exclude = "";
	}

$group_agent = "";
$group_agent_select = "#temp.clo_client_nationality";
if ($_POST["group_agent"] == 1) {
	$group_agent_select = "inag_agent_code ,inag_long_description ,clo_cyp_or_noncyp";
	$group_agent = " ,inag_agent_code ,inag_long_description";
}


	$sql = "
SELECT  
inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,           
DATE('".$_POST["year"]."-".$_POST["period_from"]."-01') as clo_from_date,           
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
IF (inity_major_category = '19') THEN driver_nationality.incd_long_description ELSE nationality.incd_long_description ENDIF as clo_client_nationality,
nationality.incd_long_description as clo_policy_client_nationality,
incl_account_type as clo_policy_client_account_type
,inag_agent_code
,inag_long_description
,CASE
WHEN clo_client_nationality = 'Cypriot' THEN 'Cypriot' 
WHEN clo_client_nationality IS NULL THEN NULL
ELSE 'Non Cypriot'
END as clo_cyp_or_noncyp
INTO #temp
FROM 
inclaims
JOIN inpolicies ON inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial
JOIN inclients ON inclients.incl_client_serial = inpolicies.inpol_client_serial
JOIN ininsurancetypes ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN inagents ON inagents.inag_agent_serial = inpolicies.inpol_agent_serial
JOIN ingeneralagents ON inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial
JOIN inclaims_asat_date ON inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial
LEFT OUTER JOIN inpcodes AS nationality ON incl_nationality = nationality.incd_pcode_serial
LEFT OUTER JOIN indrivers ON inclm_driver_serial = indr_driver_serial
LEFT OUTER JOIN inpcodes AS driver_nationality ON indr_nationality = driver_nationality.incd_pcode_serial

WHERE 
((inclaims.inclm_process_status <> 'I' /* Exclude Initial */) 
And (inclaims.inclm_status <> 'D' /* Exclude Deleted */) 
and (inclaims.inclm_open_date <= clo_as_at_date)) 
And ( inclaims_asat_date.incvsdt_operation_date <= clo_as_at_date )  
AND  1=1  
AND inclm_status in ('O','A','D') 
AND inclm_open_date >='".$_POST["open_date_from"]."' 
AND inclm_open_date <='".$_POST["open_date_to"]."'
".$product."
".$product_exclude." 
".$agent."

GROUP BY inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,           
inclaims.inclm_process_status ,           
inclaims.inclm_open_date   
,inclm_claim_number 
,clo_client_nationality
,clo_policy_client_nationality
,clo_policy_client_account_type
,inag_agent_code
,inag_long_description

HAVING  1=1  
AND clo_process_status in ('O','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (".$_POST["year"]." * 100) + ".$_POST["period_from"]." OR clo_closed_year = 0) 

ORDER BY inclm_claim_number ASC

SELECT 
".$group_agent_select." as clo_client_nationality
,COUNT()as clo_total_claims
,SUM(clo_period_payments)as clo_period_payments
,SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as clo_os_reserve
,SUM(clo_period_recoveries) as clo_period_recoveries
,SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) as clo_os_reserve_recoveries
,SUM(IF clo_policy_client_nationality = 'Cypriot' AND clo_client_nationality <> 'Cypriot' THEN 1 ELSE 0 ENDIF) as clo_cyp_policy_noncyp_claim
,SUM(IF clo_policy_client_nationality = 'Cypriot' AND clo_client_nationality <> 'Cypriot' THEN 
    #temp.clo_period_payments 
    + (#temp.clo_bf_reserves + #temp.clo_initial_res_for_payments + #temp.clo_reest_res_for_payments - #temp.clo_paid_as_at_date)
    - #temp.clo_period_recoveries
    - (#temp.clo_bf_est_recoveries + #temp.clo_est_recoveries_period - #temp.clo_recoveries_as_at_date)
ELSE 0 ENDIF) as cloam_cyp_policy_noncyp_claim

,SUM(IF clo_policy_client_account_type = 'C' THEN 1 ELSE 0 ENDIF)as clo_total_claims_companies
,SUM(IF clo_policy_client_account_type = 'C' THEN 
    #temp.clo_period_payments 
    + (#temp.clo_bf_reserves + #temp.clo_initial_res_for_payments + #temp.clo_reest_res_for_payments - #temp.clo_paid_as_at_date)
    - #temp.clo_period_recoveries
    - (#temp.clo_bf_est_recoveries + #temp.clo_est_recoveries_period - #temp.clo_recoveries_as_at_date)
ELSE 0 ENDIF)as cloam_total_claims_companies

,SUM(IF clo_client_nationality <> 'Cypriot' AND clo_policy_client_account_type = 'C' THEN 1 ELSE 0 ENDIF)as clo_company_noncyp_claim
,SUM(IF clo_client_nationality <> 'Cypriot' AND clo_policy_client_account_type = 'C' THEN 
    #temp.clo_period_payments 
    + (#temp.clo_bf_reserves + #temp.clo_initial_res_for_payments + #temp.clo_reest_res_for_payments - #temp.clo_paid_as_at_date)
    - #temp.clo_period_recoveries
    - (#temp.clo_bf_est_recoveries + #temp.clo_est_recoveries_period - #temp.clo_recoveries_as_at_date)
ELSE 0 ENDIF)as cloam_company_noncyp_claim


FROM
#temp
GROUP BY clo_client_nationality ".$group_agent."
ORDER BY ".$_POST["order_by"]." ".$_POST["order_type"];

//echo $sql;
$result = $sybase->query($sql);


}//if action show



$db->show_header();
?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_to").datepicker({dateFormat: 'yy-mm-dd'});


});

</script>
<form action="" method="post"><table width="577" border="1" align="center">
  <tr>
    <td colspan="2" align="center">Claims Per Nationality </td>
    </tr>
  
  <tr>
    <td width="132">From Year</td>
    <td width="429"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
  </tr>
  <tr>
    <td>From Period </td>
    <td><input name="period_from" type="text" id="period_from" value="<? echo $_POST["period_from"];?>"></td>
  </tr>
  <tr>
    <td>As At Date </td>
    <td>      <input name="as_at_date" type="text" id="as_at_date" value="<? if ($_POST["as_at_date"] == "") echo "2011-03-31"; else echo $_POST["as_at_date"];?>">
    YYYY-MM-DD 2009-12-31   </td>
  </tr>
  <tr>
    <td>Open Date </td>
    <td>From
      <input name="open_date_from" type="text" id="open_date_from" size="8" value="<? echo $_POST["open_date_from"];?>">
      To 
      <input name="open_date_to" type="text" id="open_date_to" size="8" value="<? echo $_POST["open_date_to"];?>">
      YYYY-MM-DD</td>
  </tr>
  <tr>
    <td>Agent</td>
    <td><input name="agent" type="text" id="agent" size="9" value="<? echo $_POST["agent"];?>" />
      New Codes Only </td>
  </tr>
  <tr>
    <td>Product</td>
    <td><input name="product" type="text" id="product" value="<? echo $_POST["product"];?>">
ex. 19% or 1712 etc </td>
  </tr>
  <tr>
    <td>Exclude Product </td>
    <td><input name="product_exclude" type="text" id="product_exclude" value="<? echo $_POST["product_exclude"];?>">
ex. 19% or 1712 etc </td>
  </tr>
  
  
  <tr>
    <td>Sort</td>
    <td><select name="order_by" id="order_by">
      <option value="clo_total_claims" <? if ($_POST["order_by"] == "clo_total_claims") echo "selected=\"selected\"";?>>Claims Count</option>
      <option value="clo_client_nationality" <? if ($_POST["order_by"] == "clo_client_nationality") echo "selected=\"selected\"";?>>Nationality</option>
      <option value="clo_period_payments" <? if ($_POST["order_by"] == "clo_period_payments") echo "selected=\"selected\"";?>>Period Payments</option>
      <option value="clo_os_reserve" <? if ($_POST["order_by"] == "clo_os_reserve") echo "selected=\"selected\"";?>>O/S Reserve</option>
      <option value="clo_period_recoveries" <? if ($_POST["order_by"] == "clo_period_recoveries") echo "selected=\"selected\"";?>>Period Recoveries</option>
      <option value="clo_os_reserve_recoveries" <? if ($_POST["order_by"] == "clo_os_reserve_recoveries") echo "selected=\"selected\"";?>>O/S Recoveries</option>
	  <option value="inag_agent_code" <? if ($_POST["order_by"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent Code</option>
    </select>
      <select name="order_type" id="order_type">
        <option value="ASC" <? if ($_POST["order_type"] == "ASC") echo "selected=\"selected\"";?>>Ascending</option>
        <option value="DESC" <? if ($_POST["order_type"] == "DESC") echo "selected=\"selected\"";?>>Descending</option>
      </select>      </td>
  </tr>
  
  <tr>
    <td>Show Extra Info </td>
    <td><input name="extra_info" type="checkbox" id="extra_info" value="1" <? if ($_POST["extra_info"] == 1 ) echo "checked=\"checked\"";?> /></td>
  </tr>
  <tr>
    <td>Group Agents </td>
    <td><input name="group_agent" type="checkbox" id="group_agent" value="1" <? if ($_POST["group_agent"] == 1 ) echo "checked=\"checked\"";?> /></td>
  </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="submit" name="Submit" value="Submit"></td>
  </tr>
</table>
</form>

<? 
if ($_POST["action"] == "show" ) {
	$extra_field = 0;
	if ($_POST["group_agent"] == 1) {
		$extra_field = 1;
	}

?>
<br /><br />
<div id="print_view_section_html">
<table width="<? if ($_POST["group_agent"] == 1) echo 750; else echo 680;?>" border="1" cellspacing="0" cellpadding="0" align="center" class="main_text">
  <tr>
    <td colspan="<? echo 7 + $extra_field;?>" align="center"><strong>Claims Per Nationality For the period: <? echo $_POST["period_from"]."/".$_POST["year"]." Up to AS AT DATE: ".$_POST["as_at_date"];?></strong><br />
And Claim open date: From <? echo $_POST["open_date_from"]." TO: ".$_POST["open_date_to"];?> <br />For: Agent [<? echo $_POST["agent"];?>], Product [<? echo $_POST["product"];?>], Exclude Product[<? echo $_POST["product_exclude"];?>]</td>
  </tr>
  <tr>
<?
$i=0;
while($row = $sybase->fetch_assoc($result)) {

	if ($i == 0 || ($i%66 == 0)) {
	$nationality_width = 190;
	if ($_POST["group_agent"] == 1) {
	$nationality_width = 80;
	?>
		<td width="340"><strong>Agent</strong></td>
	<? } ?>
		<td width="<? echo $nationality_width;?>"><strong>Nationality</strong></td>
		<td width="80" align="center"><strong>Claims Count</strong></td>
		<td width="80" align="center"><strong>Period Payments</strong></td>
		<td width="80" align="center"><strong>O/S Reserve</strong></td>
		<td width="80" align="center"><strong>Period Recoveries</strong></td>
		<td width="80" align="center"><strong>O/S Recoveries</strong></td>
		<td width="80" align="center"><strong>Total Cost</strong></td>
	  </tr>
<?
	}//header if
$i++;
$total_claims += $row["clo_total_claims"];
$total_period_payments += $row["clo_period_payments"];
$total_os_reserve += $row["clo_os_reserve"];
$total_period_recoveries += $row["clo_period_recoveries"];
$total_os_reserve_recoveries += $row["clo_os_reserve_recoveries"];
$total_cyp_policy_noncyp_claim += $row["clo_cyp_policy_noncyp_claim"];
$total_am_cyp_policy_noncyp_claim += $row["cloam_cyp_policy_noncyp_claim"];

$total_claims_by_policy_companies += $row["clo_total_claims_companies"];
$total_am_claims_by_policy_companies += $row["cloam_total_claims_companies"];

$total_company_noncyp_claim += $row["clo_company_noncyp_claim"];
$total_am_company_noncyp_claim += $row["cloam_company_noncyp_claim"];


if ($row["clo_client_nationality"] != 'Cypriot' && $row["clo_client_nationality"] != '') {
	$non_total_claims += $row["clo_total_claims"];
	$non_total_period_payments += $row["clo_period_payments"];
	$non_total_os_reserve += $row["clo_os_reserve"];
	$non_total_period_recoveries += $row["clo_period_recoveries"];
	$non_total_os_reserve_recoveries += $row["clo_os_reserve_recoveries"];
	$non_total_cost += $row["clo_period_payments"] + $row["clo_os_reserve"] - $row["clo_period_recoveries"] - $row["clo_os_reserve_recoveries"];
}

?>
  <tr>
	<?
	if ($_POST["group_agent"] == 1) {
	?>
    <td><? echo substr($row["inag_agent_code"]." - ".$row["inag_long_description"],0,24);?></td>
	<? } ?>
    <td><? echo $row["clo_client_nationality"];?></td>
    <td align="center"><? echo $row["clo_total_claims"];?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_period_payments"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_os_reserve"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_period_recoveries"]);?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_os_reserve_recoveries"]);?></td>
    <td align="center"><? $total_line_cost = $row["clo_period_payments"] + $row["clo_os_reserve"] - $row["clo_period_recoveries"] - $row["clo_os_reserve_recoveries"]; echo $db->fix_int_to_double($total_line_cost);?></td>
  </tr>
<? 
$total_cost += $total_line_cost;
}//while all claims
?>
  <tr>
    <td><strong>TOTALS</strong></td>
	<?
	if ($_POST["group_agent"] == 1) {
	?>
    <td>&nbsp;</td>
	<? } ?>
    <td align="center"><strong><? echo $total_claims;?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_period_payments);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_os_reserve);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_period_recoveries);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_os_reserve_recoveries);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_cost);?></strong></td>
  </tr>
  <tr>
    <td colspan="<? echo 7 + $extra_field;?>"><hr /></td>
    </tr>
  <tr>
    <td><strong>Total Non Cypriots </strong></td>
	<?
	if ($_POST["group_agent"] == 1) {
	?>
    <td>&nbsp;</td>
	<? } ?>
    <td align="center"><strong><? echo $non_total_claims;?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($non_total_period_payments);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($non_total_os_reserve);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($non_total_period_recoveries);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($non_total_os_reserve_recoveries);?></strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($non_total_cost);?></strong></td>
  </tr>
</table>
<? if ($_POST["extra_info"] == 1) { ?>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0" class="main_text">
  <tr>
    <td align="center"><strong>Extra Information </strong></td>
    <td align="center"><strong>Cases</strong></td>
    <td align="center"><strong>Total Cost </strong></td>
  </tr>
  <tr>
    <td width="377">Cypriots On Policy But Non Cypriot On Claim</td>
    <td width="74" align="center"><? echo $total_cyp_policy_noncyp_claim;?></td>
    <td width="91" align="center"><? echo $db->fix_int_to_double($total_am_cyp_policy_noncyp_claim);?></td>
  </tr>
  <tr>
    <td>NonCyp Claim By  Company Policies </td>
    <td align="center"><? echo $total_company_noncyp_claim;?></td>
    <td align="center"><? echo $db->fix_int_to_double($total_am_company_noncyp_claim);?></td>
  </tr>
  <tr>
    <td>Claims Made By Companies (on policy)</td>
    <td align="center"><? echo $total_claims_by_policy_companies;?></td>
    <td align="center"><? echo $db->fix_int_to_double($total_am_claims_by_policy_companies);?></td>
  </tr>
</table>
<? } ?>

</div>

<?
}//if action show and show only totals
$db->show_footer();
?>