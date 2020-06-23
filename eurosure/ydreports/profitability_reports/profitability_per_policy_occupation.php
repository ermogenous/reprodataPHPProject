<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
$sybase = new Sybase();

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


$sql ="
SELECT 
MAX(clo_year) as Year
,MAX(clo_period_from) as Period_From
,MAX(clo_period_to) as Period_To
,clo_policy_occupation as Occupation
,clo_policy_occupation_code as Occupation_Code
,SUM(clo_ytd_premium) as Premium
,SUM(clo_period_mif) as MIF
,SUM(clo_period_fees) as Fees
,SUM(clo_period_stamps) as Stamps
,SUM(clo_commission) as Commission
,clo_sort1 as Agent
,clo_sort2 as Major
,clo_sort3 as Insurance_Type
,SUM(clo_total_items)as Items_Count
,SUM(clo_total_situations)as Situations_Count
,SUM(clo_total_policy_serials)as Policy_Serials_Count
,COUNT(inpol_policy_number)as Policy_Numbers_Count
FROM 
(


SELECT  
(".$_POST["year"].") as clo_year,           
(".$_POST["month_from"].") as clo_period_from,
(".$_POST["month_to"].") as clo_period_to,
COUNT(DISTINCT(inpol_policy_serial))as clo_total_policy_serials,
LIST(DISTINCT(inpol_policy_serial))as all_serials,
MAX(inpol_policy_serial) as clo_last_serial, /* If Null => No New Or Renewal has been recorded in the specified period */
(SELECT COUNT() FROM inpolicyitems WHERE inpit_policy_serial = clo_last_serial)as clo_total_items,
inpol_policy_number,
(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = clo_last_serial)as clo_total_situations,
LIST(DISTINCT inpol_policy_serial)as clo_policy_serials,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5') AND intrd_owner = 'O'))as clo_commission,
".$agent_group." As clo_sort1,
".$group_major." As clo_sort2,
".$group_insurance_type." AS clo_sort3,


(Select incd_long_description From inpcodes where incd_record_type = '01' And incd_record_code = inity_major_category ) As clo_desc2,
(Select incd_alternative_description From inpolicies as ocpol JOIN inpcodes as ocpc ON ocpc.incd_pcode_serial = ocpol.inpol_policy_occupation AND ocpol.inpol_policy_serial = clo_last_serial) As clo_policy_occupation,
(Select incd_record_code From inpolicies as ocpol JOIN inpcodes as ocpc ON ocpc.incd_pcode_serial = ocpol.inpol_policy_occupation AND ocpol.inpol_policy_serial = clo_last_serial) As clo_policy_occupation_code
FROM ininsurancetypes  
LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code
LEFT OUTER JOIN inminorcodes  ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,           
inpolicyendorsement ,           
inagents ,           
ingeneralagents ,           
inpparam    
WHERE inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs 
and          inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial 
and          ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial 
and          inpolicies.inpol_agent_serial = inagents.inag_agent_serial 
and          inpolicyendorsement.inped_status = '1' 
AND          inped_premium_debit_credit <> 0 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
".$where_agent."
".$where_klado."
".$where_klado_exclude."
".$where_insurance_type."
".$where_insurance_type_exclude."
GROUP BY inpol_policy_number, clo_sort1, clo_sort2 ,clo_sort3, clo_desc2

ORDER BY clo_total_situations DESC,inpol_policy_number,clo_sort1 ASC , clo_sort2 ASC , clo_sort3 ASC



)as temp_table

GROUP BY 
Occupation
,Occupation_Code
,Agent
,Major
,Insurance_Type

ORDER BY 
Occupation
,Occupation_Code
,Agent
,Major
,Insurance_Type
";

$result = $sybase->query($sql);
while ($row = $sybase->fetch_assoc($result)) {

	$data[$row["Occupation_Code"]]["occupation_name"] = $row["Occupation"];
	$data[$row["Occupation_Code"]]["premium"] = $row["Premium"];
	$data[$row["Occupation_Code"]]["mif"] = $row["MIF"];
	$data[$row["Occupation_Code"]]["fees"] = $row["Fees"];
	$data[$row["Occupation_Code"]]["stamps"] = $row["Stamps"];
	$data[$row["Occupation_Code"]]["commission"] = $row["Commission"];
	$data[$row["Occupation_Code"]]["agent"] = $row["Agent"];
	$data[$row["Occupation_Code"]]["major"] = $row["Major"];
	$data[$row["Occupation_Code"]]["insurance_type"] = $row["Insurance_Type"];
	$data[$row["Occupation_Code"]]["items_count"] = $row["Items_Count"];
	$data[$row["Occupation_Code"]]["situations_count"] = $row["Situations_Count"];
	$data[$row["Occupation_Code"]]["policy_serials_count"] = $row["Policy_Serials_Count"];
	$data[$row["Occupation_Code"]]["policy_numbers_count"] = $row["Policy_Numbers_Count"];


}//while all policy rows.

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
(Select ocpc.incd_alternative_description FROM inpcodes as ocpc WHERE ocpc.incd_pcode_serial = inpol_policy_occupation) As clo_policy_occupation,
(Select incd_record_code From inpcodes as ocpc WHERE ocpc.incd_pcode_serial = inpol_policy_occupation) As clo_policy_occupation_code

into #temp

FROM 
inclaims ,           
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
inclm_open_date,
inpol_policy_occupation

HAVING  
1=1  
AND clo_process_status in ('O','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$_POST["year"]."-".$_POST["month_from"]."-01') * 100) + MONTH('".$_POST["year"]."-".$_POST["month_from"]."-01') OR clo_closed_year = 0) /*from date*/

ORDER BY  inity_insurance_type ASC,inclm_open_date ASC


SELECT
clo_policy_occupation_code,
clo_policy_occupation,
inity_insurance_type,
SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as clo_os_reserve,
SUM(clo_period_payments)as clo_period_payments,
SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date)as clo_os_recoveries,
SUM(clo_period_recoveries)as clo_period_recoveries,
COUNT(DISTINCT(inclm_claim_number))as clo_total_claims
FROM
#temp
GROUP BY
clo_policy_occupation_code,
clo_policy_occupation,
inity_insurance_type
ORDER BY inity_insurance_type ASC,clo_policy_occupation ASC

";
//echo $sql_claims;
$claim_result = $sybase->query($sql_claims);
while ($row = $sybase->fetch_assoc($claim_result)) {

	$data[$row["clo_policy_occupation_code"]]["claims_os_reserve"] = $row["clo_os_reserve"];
	$data[$row["clo_policy_occupation_code"]]["claims_period_payments"] = $row["clo_period_payments"];
	$data[$row["clo_policy_occupation_code"]]["claims_os_recoveries"] = $row["clo_os_recoveries"];
	$data[$row["clo_policy_occupation_code"]]["claims_period_recoveries"] = $row["clo_period_recoveries"];
	$data[$row["clo_policy_occupation_code"]]["claims_count"] = $row["clo_total_claims"];
	$data[$row["clo_policy_occupation_code"]]["occupation_name"] = $row["clo_policy_occupation"];

	

}
/*
while ($row = $sybase->fetch_assoc($result)) {

	$data[] = $row;

}

foreach($data[0] as $field => $value){

	$fields[] = $field;


}

if ($_POST["output"] == "text") {
export_data_delimited($data,$fields,'#','none','download','
','data');
}
else if ($_POST["output"] == "table") {
	$output_table = export_data_html_table($sql,'sybase');
}
*/
//print_r($data);
}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="603" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Premium Per Policy Occupation Report </td>
    </tr>
    <tr>
      <td width="184" height="28"><strong>Production Year</strong></td>
      <td width="419"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>" size="6"></td>
    </tr>
    <tr>
      <td height="28"><strong>Production/Claims Months</strong></td>
      <td>From
        <input name="month_from" type="text" id="month_from" value="<? echo $_POST["month_from"];?>" size="6" />
To
<input name="month_to" type="text" id="month_to" value="<? echo $_POST["month_to"];?>" size="6" /></td>
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
<div id="print_view_section_html">

<table width="1500" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="23">Profitability Report Per Policy Occupation For Year: <? echo $_POST["year"];?> Months: <? echo $_POST["month_from"]."->".$_POST["month_to"];?> <br />Claims As At Date <? echo $_POST["as_at_date"];?> Claims Open Date <? echo $_POST["open_date_from"]." - ".$_POST["open_date_to"];?><br />Agents [<? echo $_POST["agent_from"]." - ".$_POST["agent_to"];?>] Major [<? echo $_POST["klado_from"]." - ".$_POST["klado_to"];?>] Major Exclude [<? echo $_POST["klado_exclude"];?>] <br />Insurance Type [<? echo $_POST["insurance_type"];?>] Insurance Type Exclude [<? echo $_POST["insurance_type_exclude"];?>]</td>
    </tr>
  <tr>
    <td>Code</td>
    <td align="left">Name</td>
    <td align="center">Premium</td>
    <td align="center">Total Claim</td>
    <td align="center">Total Claim - Recoveries</td>
    <td align="center">Prof.%</td>
    <td align="center">Prof - Recoveries %</td>
    <td align="center">MIF</td>
    <td align="center">Fees</td>
    <td align="center">Stamps</td>
    <td align="center">Commission</td>
    <td align="center">Agent</td>
    <td align="center">Major</td>
    <td align="center">Ins.Type</td>
    <td align="center">Tot.Items</td>
    <td align="center">Tot.Situations</td>
    <td align="center">Tot.Policy Serials</td>
    <td align="center">Tot.Policy Numbers</td>
    <td align="center">Cl.OS Reserve</td>
    <td align="center">Cl.Payments</td>
    <td align="center">Cl.OS Recoveries</td>
    <td align="center">Cl.Recoveries</td>
    <td align="center">Cl.Total</td>
  </tr>
<?
foreach ($data as $name => $value) {

?>  
  <tr>
    <td><? echo $name;?></td>
    <td align="left"><? echo $value["occupation_name"];?></td>
    <td align="center"><? echo $value["premium"];?></td>
    <td align="center"><? echo ($value["claims_os_reserve"] + $value["claims_period_payments"]);?></td>
    <td align="center"><? echo ($value["claims_os_reserve"] + $value["claims_period_payments"] - $value["claims_os_recoveries"] - $value["claims_period_recoveries"]);?></td>

    <td align="center"><? if ($value["premium"] > 0) { echo round(((($value["claims_os_reserve"] + $value["claims_period_payments"])/$value["premium"]) *100),0).'%';}else echo "&nbsp;";?></td>
    <td align="center"><? if ($value["premium"] > 0) { echo round(((($value["claims_os_reserve"] + $value["claims_period_payments"] - $value["claims_os_recoveries"] - $value["claims_period_recoveries"])/ $value["premium"]) *100),0).'%';}else echo "&nbsp;"; ?></td>

    <td align="center"><? echo $value["mif"];?></td>
    <td align="center"><? echo $value["fees"];?></td>
    <td align="center"><? echo $value["stamps"];?></td>
    <td align="center"><? echo $value["commission"];?></td>
    <td align="center"><? echo $value["agent"];?></td>
    <td align="center"><? echo $value["major"];?></td>
    <td align="center"><? echo $value["insurance_type"];?></td>
    <td align="center"><? echo $value["items_count"];?></td>
    <td align="center"><? echo $value["situations_count"];?></td>
    <td align="center"><? echo $value["policy_serials_count"];?></td>
    <td align="center"><? echo $value["policy_numbers_count"];?></td>
    <td align="center"><? echo $value["claims_os_reserve"];?></td>
    <td align="center"><? echo $value["claims_period_payments"];?></td>
    <td align="center"><? echo $value["claims_os_recoveries"];?></td>
    <td align="center"><? echo $value["claims_period_recoveries"];?></td>
    <td align="center"><? echo $value["claims_count"];?></td>
  </tr>
<? 
}//foreach

?>
</table>
</div>
<?
}//if post action = true
$db->show_footer();
?>