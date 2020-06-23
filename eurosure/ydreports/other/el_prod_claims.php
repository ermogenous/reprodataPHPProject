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
	$where_agent = '';
}
else {
	$where_agent = "AND inag_agent_code BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."'";
}


$production_sql ="
SELECT 
(".$_POST["year"].") as clo_year
,(".$_POST["month_from"].") as clo_period_from
,(".$_POST["month_to"].") as clo_period_to
,initm_item_code
,initm_long_description
,-1 * SUM(inped_premium_debit_credit * (IF inldg_loading_type <> 'X' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as clo_premium
,inpol_policy_number
,inpol_policy_serial

/*FIND LIMITS*/
,CASE 
WHEN inity_insurance_type = '2210' THEN
    (SELECT MAX(convert(int,inach_remark)) FROM inattachments JOIN inpolicybatchattachments ON inach_attachment_serial = inbtat_attachment_serial           
    WHERE inbtat_policy_serial = inpolicies.inpol_policy_serial AND inach_category_serial = 22 AND LEFT(inach_attachment_code,11) = '22EL-BASICA')
WHEN inity_insurance_type = '1702' THEN inpia_other_benefits
WHEN inity_insurance_type = '1703' THEN inpia_other_benefits
WHEN inity_insurance_type = '1712' THEN COALESCE((
            SELECT DISTINCT(IF limitloadings.inplg_loading_serial IN (1345,1346) THEN 170000 
            ELSE IF limitloadings.inplg_loading_serial IN (1347,1348) THEN 340000 
            ELSE IF limitloadings.inplg_loading_serial IN (1369,1370) THEN 250000 
            ELSE IF limitloadings.inplg_loading_serial IN (1422,1423) THEN 500000 
            ENDIF ENDIF ENDIF ENDIF) 
            FROM inpolicyloadings as limitloadings
            WHERE limitloadings.inplg_policy_serial = 52045 
            AND limitloadings.inplg_loading_serial IN (1345,1346,1347,1348,1369,1370,1422,1423) 
),inpia_other_benefits)
WHEN inity_insurance_type = '1713' THEN inpia_height
WHEN inity_insurance_type = '1020' THEN inpia_insured_amount_alt1
end as clo_per_employee_limit

,CASE 
WHEN inity_insurance_type = '1020' THEN 1
ELSE inpia_no_of_employees
end as clo_total_employees
,inag_agent_code
,inag_long_description

,( /*this will find how many new/renewals in the period starting date. This will show if 0 then is an endorsement from a policy before the period*/
    SELECT
    SUM(IF newren.inpol_process_status IN ('N','R') THEN 1 ELSE 0 ENDIF)
    FROM
    inpolicyendorsement as newrenped JOIN inpolicies as newren ON newren.inpol_policy_serial = newrenped.inped_financial_policy_abs
    WHERE newrenped.inped_status = '1' /* Posted */
    AND newrenped.inped_premium_debit_credit <> 0 
    AND (newrenped.inped_year*100+newrenped.inped_period) >= (clo_year*100+clo_period_from) 
    AND (newrenped.inped_year*100+newrenped.inped_period) <= (clo_year*100+clo_period_to) 
    AND newren.inpol_policy_number = inpolicies.inpol_policy_number
    AND newren.inpol_period_starting_date = inpolicies.inpol_period_starting_date
)as clo_total_new_renewal
into #temp

FROM inpolicyendorsement
JOIN inpolicies ON inpol_policy_serial = inped_financial_policy_abs
JOIN inagents ON inpol_agent_serial = inag_agent_serial
JOIN inpolicyitems ON inped_policy_serial = inpit_policy_serial
JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial
JOIN initems ON initm_item_serial = inpit_item_serial
LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial /* COALESCE used for completeness */
JOIN inpolicyloadings ON inpit_pit_auto_serial = inplg_pit_auto_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
LEFT OUTER JOIN inreinsurancetreaties ON initm_reinsurance_treaty = inrit_reinsurance_treaty_serial

WHERE 
inped_status = '1' /* Posted */
AND inped_premium_debit_credit <> 0 
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND (inrit_alternative_insurance_type = 22 /*Filters ALL items Under EL*/ OR inity_insurance_type = '2210'/*EL ITEMS DO NOT HAVE R/I*/ )
AND inpol_period_starting_date >= '".$_POST["year"]."-".$_POST["month_from"]."-01' /*This filters all the endorsements done by policies out of this period*/
AND inpol_status IN ('A','N')
".$where_agent."

GROUP BY
inpit_pit_auto_serial
,initm_item_code
,initm_long_description
,inpia_other_benefits
,inity_insurance_type
,inpol_policy_serial
,inpol_policy_number
,inpia_height
,inpia_insured_amount_alt1
,inpia_no_of_employees
,inag_agent_code
,inag_long_description
,inpol_period_starting_date

HAVING clo_total_new_renewal = 1


SELECT
initm_long_description as clo_item_description
,LIST(DISTINCT(initm_item_code))as clo_items
,clo_per_employee_limit as clo_limit
,SUM(clo_premium)as clo_total_premium
,COUNT(DISTINCT(inpol_policy_number))as clo_distinct_policies
,SUM(clo_total_employees)as clo_total_employees
FROM #temp
GROUP BY 
initm_long_description
,clo_per_employee_limit
ORDER BY initm_long_description ASC
";
//echo $production_sql;
//$result = $sybase->query($sql);


//=CLAIMS======================CLAIMS============================CLAIMS==================================CLAIMS
$claims_sql = 
"
SELECT  
inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,           
DATE('2010-1-01') as clo_from_date,           
DATE('2011-04-30') as clo_as_at_date,           
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



,inag_agent_code
,inag_long_description
,incd_long_description
,incd_alternative_description
INTO #temp
FROM 
inclaims
JOIN inpolicies ON inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial
JOIN inclients ON inclients.incl_client_serial = inpolicies.inpol_client_serial
JOIN ininsurancetypes ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN inagents ON inagents.inag_agent_serial = inpolicies.inpol_agent_serial
JOIN ingeneralagents ON inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial
JOIN inclaims_asat_date ON inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial
JOIN inreinsurancetreaties ON incvsdt_policy_treaty = inrit_reinsurance_treaty_serial
LEFT OUTER JOIN inpcodes ON incd_pcode_serial = incl_occupation_serial

WHERE 
((inclaims.inclm_process_status <> 'I' /* Exclude Initial */) 
And (inclaims.inclm_status <> 'D' /* Exclude Deleted */) 
and (inclaims.inclm_open_date <= clo_as_at_date)) 
And ( inclaims_asat_date.incvsdt_operation_date <= clo_as_at_date )  
AND  1=1  
AND inclm_status in ('O','A','D') 
AND inclm_open_date >='2010-01-01' 
AND inclm_open_date <='2010-12-31'
AND inrit_alternative_insurance_type = 22

 

GROUP BY inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,           
inclaims.inclm_process_status ,           
inclaims.inclm_open_date   
,inclm_claim_number 
,inag_agent_code
,inag_long_description
,incd_long_description
,incd_alternative_description

HAVING  1=1  
AND clo_process_status in ('O','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (2010 * 100) + 1 OR clo_closed_year = 0) 

ORDER BY inclm_claim_number ASC
//===============================================================================================================
SELECT 
incd_alternative_description
,COUNT(DISTINCT(inclm_claim_number))as clo_total_claims
,SUM(clo_period_payments)as clo_period_payments
,SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as clo_os_reserve
,SUM(clo_period_recoveries) as clo_period_recoveries
,SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) as clo_os_reserve_recoveries


FROM
#temp
GROUP BY incd_alternative_description 
ORDER BY clo_total_claims ASC
";



}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="649" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">EL Premium / Claim </td>
    </tr>
    <tr>
      <td width="226" height="28">Year</td>
      <td width="423"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>" size="6"></td>
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
      <td height="28">Group By Policy Insured Amount? </td>
      <td><input name="group_policy_ia" type="checkbox" id="group_policy_ia" value="1" <? if ($_POST["group_policy_ia"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br />
<br />
<?
echo $output_table;

$db->show_footer();
?>