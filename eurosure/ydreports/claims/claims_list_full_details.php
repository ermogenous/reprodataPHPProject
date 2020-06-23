<?
ini_set("memory_limit","256M");
ini_set('max_execution_time', 60000);

include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../../tools/various_tools.php");
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
	
	if ($_POST["policy_cover"] == 'D') {
		$policy_cover = "AND inpol_cover IN ('B','C')";
	}
	else if ($_POST["policy_cover"] == 'ALL') {
		$policy_cover = "";
	}
	else {
		$policy_cover = "AND inpol_cover IN ('".$_POST["policy_cover"]."')";
	}

	if ($_POST["withdrawn"] == 1) {
		$withdrawn = "'W',";
	}
	else {
		$withdrawn = "";
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

//vehicles information.
(SELECT LIST(DISTINCT(incd_long_description)) FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial JOIN inpcodes ON incd_pcode_serial = initm_make_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_make,
(SELECT incd_long_description FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial JOIN inpcodes ON incd_pcode_serial = initm_model_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_model,
(SELECT initm_body_type FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_body_type,
(SELECT initm_cubic_capacity FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_cubic_capacity,
datepart(YEAR,inclm_date_of_event) - (SELECT initm_year_of_manufacture FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_year_of_manufacture_on_event,
(SELECT initm_convertible FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_convertible,
(SELECT initm_modified FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_pit_auto_serial = inclm_pit_auto_serial)as clo_vehicle_sport,

//drivers information
(SELECT incd_alternative_description FROM indrivers JOIN inpcodes ON incd_pcode_serial = indr_occupation_serial WHERE indr_driver_serial = inclm_driver_serial)as clo_driver_occupation,
fn_evaluate_age((SELECT indr_birth_date FROM indrivers WHERE indr_driver_serial = inclm_driver_serial),inclm_date_of_event)as clo_driver_age_on_event_date,
(fn_evaluate_age((SELECT DISTINCT(COALESCE(indr_permit_date,indr_learner_license_date)) FROM indrivers WHERE indr_driver_serial = inclm_driver_serial),inclm_date_of_event))as clo_driver_experience_on_event_date,

//policy_details
inpol_cover,


(SELECT pol.inpol_process_status FROM inpolicies as pol WHERE pol.inpol_policy_number = inpolicies.inpol_policy_number AND pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date AND pol.inpol_process_status IN ('N','R') AND pol.inpol_status IN ('A','N'))as clo_new_renewal_status,

inclm_date_of_event,
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
into #temp
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
".$policy_cover."

GROUP BY inclaims.inclm_claim_serial ,           
inclaims.inclm_claim_number ,           
inclaims.inclm_process_status ,           
inclaims.inclm_open_date   ,
inclm_open_date ,
inpol_policy_serial,
inpol_policy_number,
inity_insurance_type,
inclm_date_of_event,
inclm_driver_serial,
inclm_pit_auto_serial,
inpol_cover,
inpol_period_starting_date

HAVING  1=1  
AND clo_process_status in ('O',".$withdrawn."'R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$_POST["from_year"]."/".$_POST["from_period"]."/01') * 100) + MONTH('".$_POST["from_year"]."/".$_POST["from_period"]."/01') OR clo_closed_year = 0) 

ORDER BY 
clo_driver_experience_on_event_date,
inity_insurance_type , 
inpol_policy_number,
inclm_open_date ASC

SELECT
inclm_claim_serial as 'Claim Serial',
inclm_claim_number as 'Claim Num',
inpol_policy_serial as 'Policy Serial',
inpol_policy_number as 'Policy Num',
clo_total_insured_amount as 'Insured Amount',
clo_vehicle_make as 'Veh.Make',
clo_vehicle_model as 'Veh.Model',
clo_vehicle_body_type as 'Veh.Body Type',
clo_vehicle_cubic_capacity as 'Veh. CC',
clo_vehicle_year_of_manufacture_on_event as 'Veh. Age',
clo_vehicle_convertible as 'Veh.Convertible',
clo_vehicle_sport as 'Veh.Sport',
clo_driver_occupation as 'Driver Occupation',
clo_driver_age_on_event_date as 'Driver Age',
clo_driver_experience_on_event_date as 'Driver Experience',
inpol_cover as 'Pol.Cover',
inclm_date_of_event as 'Date of Event',
inclm_process_status as 'Actual Status',
clo_process_status as 'Calc. Status',
clo_period_payments as Payments,
(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as 'O/S Reserve',
clo_period_recoveries as 'Period Recoveries',
(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date)as 'O/S Recovery',
clo_period_payments + (clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as 'Total Reserves',
clo_period_recoveries + (clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date)as 'Total Recoveries',
clo_new_renewal_status as 'Pol_New_Renewal_PStatus'
FROM
#temp
ORDER BY inclm_claim_serial ASC


";
//echo $sql."\n\n\n\n<hr>"; exit();
//==================================POLICIES======================================POLICIES==============================================POLICIES===========================POLICIES
$sql_policies = "
SELECT  inpolicies.inpol_policy_number ,           
inagents.inag_agent_code ,           
inpolicies.inpol_policy_serial ,           
inity_insurance_type ,           

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
ELSE SUM(inpit_insured_amount)
ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF 
FROM inpolicyitems
JOIN initems ON initm_item_serial = inpit_item_serial
WHERE inpit_policy_serial = inpolicies.inpol_policy_serial
)as clo_total_insured_amount,

(SELECT TOP 1 incd_long_description FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial JOIN inpcodes ON incd_pcode_serial = initm_make_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_make,
(SELECT TOP 1 incd_long_description FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial JOIN inpcodes ON incd_pcode_serial = initm_model_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_model,
(SELECT TOP 1 initm_body_type FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_body_type,
(SELECT TOP 1 initm_cubic_capacity FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_cubic_capacity,
datepart(YEAR,inpol_period_starting_date) - (SELECT TOP 1 initm_year_of_manufacture FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_age,
(SELECT TOP 1 initm_convertible FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_convertible,
(SELECT TOP 1 initm_modified FROM initems JOIN inpolicyitems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_vehicle_sport,
inpol_cover,

IF inped_endorsement_serial = inpol_last_cancellation_endorsement_serial THEN IF inpol_status = 'A' AND inpol_replaced_by_policy_serial = 0 AND inpol_cancellation_date IS NOT NULL THEN 'C' ELSE 'L' ENDIF ELSE inpol_process_status ENDIF as clo_process_status,           
((inped_fees * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_fees * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_fees,           
((inped_stamps * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_stamps * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_stamps,           
((inped_x_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_x_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_x_premium,           
COALESCE((SELECT LIST(DISTINCT intrh_document_number) FROM intransactiondetails, intransactionheaders WHERE intrd_policy_serial = inpol_policy_serial AND intrd_endorsement_serial = IF clo_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF clo_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF AND intrd_trh_auto_serial = intrh_auto_serial AND intrd_related_type IN ('A', 'C')), '') As clo_document_number,           
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial JOIN ininsurancetypes ity ON ity.inity_insurance_type_serial = oldpol.inpol_insurance_type_serial WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND ity.inity_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND ity.inity_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_endorsement,           
((inped_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN IF inpol_status IN ('C','O') THEN clo_refund_outstanding_endorsement ELSE COALESCE((SELECT ((a.inped_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ENDIF ELSE 0 ENDIF as clo_premium,           
((inped_mif * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN IF inpol_status IN ('C','O') THEN ROUND(clo_refund_outstanding_mif_pr_endorsement * CASE clo_replacing_policy_pstatus WHEN 'N' THEN inity_mif_new WHEN 'R' THEN inity_mif_renewal ELSE inity_mif_endorsment END / 100, 2) ELSE COALESCE((SELECT ((a.inped_mif * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ENDIF ELSE 0 ENDIF as clo_mif,           
IF clo_process_status = 'E' THEN (SELECT oldpol.inpol_process_status FROM inpolicies oldpol WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial) ELSE '' ENDIF as clo_replacing_policy_pstatus,           
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial JOIN ininsurancetypes ity ON ity.inity_insurance_type_serial = oldpol.inpol_insurance_type_serial WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND inldg_mif_applied <> 'N' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND ity.inity_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND ity.inity_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_mif_pr_endorsement,           
COALESCE((SELECT SUM(intrd_value * intrd_debit_credit)  * -1 FROM intransactiondetails WHERE intrd_policy_serial = inpol_policy_serial AND (intrd_endorsement_serial = IF clo_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF clo_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF) AND COALESCE(intrd_claim_serial, 0) = 0 AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_status <> '9' /*Excl.Deleted*/ AND intrd_related_type = IF inga_branch_agent = 'B' THEN 'A' ELSE 'G' ENDIF), 0) as clo_commission_charge,           
IF clo_process_status = 'E' THEN COALESCE((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails, inpolicies a WHERE a.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND intrd_policy_serial = a.inpol_policy_serial AND intrd_endorsement_serial = a.inpol_last_cancellation_endorsement_serial AND COALESCE(intrd_claim_serial, 0) = 0 AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_status <> '9' /*Excl.Deleted*/ AND intrd_related_type = IF inga_branch_agent = 'B' THEN 'A' ELSE 'G' ENDIF), 0) ELSE 0 ENDIF as clo_commission_reduction,           
clo_commission_charge - clo_commission_reduction as clo_commission_net,           
COALESCE((SELECT FIRST intrd_related_serial FROM intransactiondetails WHERE intrd_policy_serial = inpol_policy_serial AND (intrd_endorsement_serial = IF clo_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE inpol_last_endorsement_serial ENDIF) AND COALESCE(intrd_claim_serial, 0) = 0 AND intrd_status <> '9' /*Excl.Deleted*/ AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_related_type = 'A'), 0) as clo_commission_agent,           
IF clo_commission_agent <> inpol_agent_serial THEN (SELECT a.inag_agent_code FROM inagents a WHERE a.inag_agent_serial = clo_commission_agent) ELSE '' ENDIF as clo_commission_agent_code,           
(SELECT incd_long_description FROM inpcodes WHERE incd_pcode_serial = inpol_policy_occupation)as clo_occupation       

into #temp
FROM 
intemplates 
RIGHT OUTER JOIN inpolicies ON intemplates.intmpl_template_serial = inpolicies.inpol_template_serial,           
inclients ,           
inagents ,           
inpolicyendorsement ,           
ininsurancetypes ,           
ingeneralagents
WHERE 
( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and ( inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial ) 
and ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial ) 
and ((inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_endorsement_serial) 
    or (inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_cancellation_endorsement_serial 
and (   inpolicies.inpol_replaced_by_policy_serial = 0)) /* CANCELLATION OR LAPSED */ )    

AND  1=1  
AND LEFT(clo_process_status, 1) IN ('N','R','E','D','C','L') 
AND inpol_status IN ('A','N') 
AND (inped_year*100+inped_period)>=(".$_POST["from_year"]."*100+".$_POST["from_period"].") 
AND (inped_year*100+inped_period)<=(".$_POST["to_year"]."*100+".$_POST["to_period"].") 
".$klado_exclude."
".$klado."
".$policy_cover."

ORDER BY  
inity_insurance_type ASC ,
inpol_policy_number ASC 


SELECT
inity_insurance_type,
inpol_policy_number,
clo_total_insured_amount,
clo_vehicle_make,
clo_vehicle_model,
clo_vehicle_body_type,
clo_vehicle_cubic_capacity,
MAX(clo_vehicle_age)as clo_vehicle_age,
clo_vehicle_convertible,
clo_vehicle_sport,
inpol_cover,
SUM(clo_fees)as total_fees,
SUM(clo_stamps) as total_stamps,
SUM(clo_premium) as total_premium

FROM
#temp

GROUP BY 
inity_insurance_type,
inpol_policy_number,
clo_total_insured_amount,
clo_vehicle_make,
clo_vehicle_model,
clo_vehicle_body_type,
clo_vehicle_cubic_capacity,
clo_vehicle_convertible,
clo_vehicle_sport,
inpol_cover
ORDER BY inpol_policy_number ASC
";
//echo $sql_policies."<hr>";

$sql_drivers = "

SELECT
inpol_policy_number ,
inpol_policy_serial ,           
inity_insurance_type ,           
incth_certificate_code,
incth_for_account_type,
inpol_cover,
IF inped_endorsement_serial = inpol_last_cancellation_endorsement_serial THEN IF inpol_status = 'A' AND inpol_replaced_by_policy_serial = 0 AND inpol_cancellation_date IS NOT NULL THEN 'C' ELSE 'L' ENDIF ELSE inpol_process_status ENDIF as clo_process_status
,indr_birth_date
,indr_permit_date
,indr_short_description
,indr_driver_serial
,inpol_period_starting_date
into #temp
FROM 
intemplates 
RIGHT OUTER JOIN inpolicies ON intemplates.intmpl_template_serial = inpolicies.inpol_template_serial,
inclients,
inagents ,           
inpolicyendorsement ,           
ininsurancetypes ,           
incertificatetemplatehead ,
inpolicydrivers,
indrivers
WHERE 
1=1
and ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial ) 
and inpol_certificate_template_serial = incth_certificate_serial
and ((inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_endorsement_serial) 
    or (inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_cancellation_endorsement_serial 
and (   inpolicies.inpol_replaced_by_policy_serial = 0)) /* CANCELLATION OR LAPSED */ )    
AND inpdr_policy_serial = inpol_policy_serial 
AND (indr_driver_serial = inpdr_driver_serial OR (incl_driver_serial = indr_driver_serial AND incth_for_account_type = 'P'))
AND  1=1  
AND LEFT(clo_process_status, 1) IN ('N','R','E','D','C','L') 
AND inpol_status IN ('A','N') 
AND (inped_year*100+inped_period)>=(".$_POST["from_year"]."*100+".$_POST["from_period"].") 
AND (inped_year*100+inped_period)<=(".$_POST["to_year"]."*100+".$_POST["to_period"].") 
".$klado_exclude."
".$klado."
".$policy_cover."

SELECT
inpol_policy_number,
incth_for_account_type,
inpol_cover,
inpol_period_starting_date,
fn_evaluate_age(indr_birth_date,inpol_period_starting_date)as clo_driver_age,
fn_evaluate_age(indr_permit_date,inpol_period_starting_date)as clo_driver_experience
FROM
#temp
GROUP BY 
inpol_policy_number,
incth_for_account_type,
inpol_cover,
inpol_period_starting_date,
clo_driver_age,
clo_driver_experience
ORDER BY inpol_policy_number ASC";


if ($_POST["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"none",'download');
}
else if ($_POST["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
	$table_data .= "<hr>".export_data_html_table($sql_policies,'sybase',"border='1' align='center'");
	$table_data .= "<hr>".export_data_html_table($sql_drivers,'sybase',"border='1' align='center'");
}
else if ($_POST["export_file"] == "totals") {

	if ($_POST["what_to_show"] == "ALL") {

		$result = $sybase->query($sql);
		while ($row = $sybase->fetch_assoc($result)) {
			$grand_total_cost += $row["Total Reserves"];
			$grand_total_count++;
			//get the claim bands.
			$claim_band = get_bands(0,1000,$row["Total Reserves"]);
			$data["Claim Bands"][$claim_band]["Cost"] += $row["Total Reserves"];
			$data["Claim Bands"][$claim_band]["Count"] += 1;
			ksort($data["Claim Bands"]);
	
			//get the insured amound bands
			$claim_band = get_bands(8000,2000,$row["Insured Amount"]);
			$data["Insured Amount Bands"][$claim_band]["Count"] += 1;
			$data["Insured Amount Bands"][$claim_band]["Cost"] += $row["Total Reserves"];
			ksort($data["Insured Amount Bands"]);
			
			//get per Driver Age
			$data["Per Driver Age"][$row["Driver Age"]]["Count"] += 1;
			$data["Per Driver Age"][$row["Driver Age"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Driver Age"]);
			
			
			
			//get per driver age and policy process status
			$data["Per Driver Age New/Renewal"][$row["Driver Age"].'-'.$row["Pol_New_Renewal_PStatus"]]["Count"] += 1;
			$data["Per Driver Age New/Renewal"][$row["Driver Age"].'-'.$row["Pol_New_Renewal_PStatus"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Driver Age New/Renewal"]);



			//get per Driver Experience
			$data["Per Driver Experience"][$row["Driver Experience"]]["Count"] += 1;
			$data["Per Driver Experience"][$row["Driver Experience"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Driver Experience"]);
	
			//get per High Performance
			$data["Per Vehicle Sport"][$row["Veh.Sport"]]["Count"] += 1;
			$data["Per Vehicle Sport"][$row["Veh.Sport"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Vehicle Sport"]);
			
			//get per Vehicle Age
			$data["Per Vehicle Age"][$row["Veh. Age"]]["Count"] += 1;
			$data["Per Vehicle Age"][$row["Veh. Age"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Vehicle Age"]);
	
			//get per Body Type
			$data["Per Veh.Body Type"][$row["Veh.Body Type"]]["Count"] += 1;
			$data["Per Veh.Body Type"][$row["Veh.Body Type"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Veh.Body Type"]);
	
			//get per Vehicle CC
			$claim_band = get_bands(1000,200,$row["Veh. CC"]);
			$data["Per Vehicle CC"][$claim_band]["Count"] += 1;
			$data["Per Vehicle CC"][$claim_band]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Vehicle CC"]);
	
			//get per make
			$data["Per Make"][$row["Veh.Make"]]["Count"] += 1;
			$data["Per Make"][$row["Veh.Make"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Make"]);
			
			//get per model
			$data["Per Model"][$row["Veh.Make"]." - ".$row["Veh.Model"]]["Count"] += 1;
			$data["Per Model"][$row["Veh.Make"]." - ".$row["Veh.Model"]]["Cost"] += $row["Total Reserves"];
			ksort($data["Per Model"]);
		
		
		}//while all rows
	
		//add the policy details
		$pol_result = $sybase->query($sql_policies);
		while ($row = $sybase->fetch_assoc($pol_result)) {
			$pol_grand_total_premium += $row["total_premium"];
			$pol_grand_total_count++;
			
			//get the insured amound bands
			//if ($row["clo_total_insured_amount"] > 10000) {
			//	$insured_amount_band = get_bands(10000,5000,$row["clo_total_insured_amount"]);
			//}
			//else {
			//	$insured_amount_band = get_bands(6000,1000,$row["clo_total_insured_amount"]);	
			//}
			
			
			$insured_amount_band = get_bands(8000,2000,$row["clo_total_insured_amount"]);	
			$data["Insured Amount Bands"][$insured_amount_band]["PolCount"] += 1;
			$data["Insured Amount Bands"][$insured_amount_band]["Premium"] += $row["total_premium"];
			ksort($data["Insured Amount Bands"]);
	
			//get per High Performance
			$data["Per Vehicle Sport"][$row["clo_vehicle_sport"]]["PolCount"] += 1;
			$data["Per Vehicle Sport"][$row["clo_vehicle_sport"]]["Premium"] += $row["total_premium"];
			ksort($data["Per Vehicle Sport"]);
			
			//get per Vehicle Age
			$data["Per Vehicle Age"][$row["clo_vehicle_age"]]["PolCount"] += 1;
			$data["Per Vehicle Age"][$row["clo_vehicle_age"]]["Premium"] += $row["total_premium"];
			ksort($data["Per Vehicle Age"]);
	
			//get per Body Type
			$data["Per Veh.Body Type"][$row["clo_vehicle_body_type"]]["PolCount"] += 1;
			$data["Per Veh.Body Type"][$row["clo_vehicle_body_type"]]["Premium"] += $row["total_premium"];
			ksort($data["Per Veh.Body Type"]);
	
			//get per Vehicle CC
			$claim_band = get_bands(1000,200,$row["clo_vehicle_cubic_capacity"]);
			$data["Per Vehicle CC"][$claim_band]["PolCount"] += 1;
			$data["Per Vehicle CC"][$claim_band]["Premium"] += $row["total_premium"];
			ksort($data["Per Vehicle CC"]);
	
			//get per make
			$data["Per Make"][$row["clo_vehicle_make"]]["PolCount"] += 1;
			$data["Per Make"][$row["clo_vehicle_make"]]["Premium"] += $row["total_premium"];
			ksort($data["Per Make"]);
			
			//get per model
			$data["Per Model"][$row["clo_vehicle_make"]." - ".$row["clo_vehicle_model"]]["PolCount"] += 1;
			$data["Per Model"][$row["clo_vehicle_make"]." - ".$row["clo_vehicle_model"]]["Premium"] += $row["total_premium"];
			ksort($data["Per Model"]);
		
		}//while all rows POLICIES
	}
	else if ($_POST["what_to_show"] == "DRIVERS") {
		//get the driver details
		$dr_result = $sybase->query($sql_drivers);
		while ($row = $sybase->fetch_assoc($dr_result)) {
			$dr_grand_total_count++;
			
			//get per Driver Age
			$data["Per Driver Age"][$row["clo_driver_age"]]["PolCount"] += 1;
			ksort($data["Per Driver Age"]);
	
			//get per Driver Experience
			$data["Per Driver Experience"][$row["clo_driver_experience"]]["PolCount"] += 1;
			ksort($data["Per Driver Experience"]);
			
		}//while all rows DRIVERS
	}

//print_r($data);

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
  <table width="564" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Claims List Full Details </td>
    </tr>
    
    <tr>
      <td width="154" height="28">As At Date </td>
      <td width="410"><input name="as_at_date" type="text" id="as_at_date" value="<? echo $_POST["as_at_date"];?>"> 
      YYYY-MM-DD</td>
    </tr>
    
    <tr>
      <td height="28">Period/Year From</td>
      <td>Year From
        <input name="from_year" type="text" id="from_year" size="5" value="<? echo $_POST["from_year"];?>" />
        Period From
        <input name="from_period" type="text" id="from_period" size="3" value="<? echo $_POST["from_period"];?>" /></td>
    </tr>
    <tr>
      <td height="28">Period/Year To</td>
      <td>Year To
        <input name="to_year" type="text" id="to_year" size="5" value="<? echo $_POST["to_year"];?>" />
        Period To
      <input name="to_period" type="text" id="to_period" size="3" value="<? echo $_POST["to_period"];?>" /></td>
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
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["insurance_type_exclude"];?>"/>
      (exclude) ex 17% </td>
    </tr>
    
    <tr>
      <td height="28">Policy Cover </td>
      <td><select name="policy_cover" id="policy_cover">
	    <option value="ALL" <? if ($_POST["policy_cover"] == 'ALL') echo "selected=\"selected\"";?>>ALL</option>
        <option value="A" <? if ($_POST["policy_cover"] == 'A') echo "selected=\"selected\"";?>>Thirt Party</option>
        <option value="B" <? if ($_POST["policy_cover"] == 'B') echo "selected=\"selected\"";?>>Fire &amp; Theft</option>
        <option value="C" <? if ($_POST["policy_cover"] == 'C') echo "selected=\"selected\"";?>>Comprehensive</option>
        <option value="D" <? if ($_POST["policy_cover"] == 'D') echo "selected=\"selected\"";?>>Fire &amp; Theft + Comprehensive</option>
      </select>      </td>
    </tr>
    <tr>
      <td height="28">Include Withdrawn </td>
      <td><input name="withdrawn" type="checkbox" id="withdrawn" value="1" <? if ($_POST["withdrawn"] == 1) echo "checked=\"checked\"";?> /></td>
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
      <td height="28">What to show</td>
      <td><select name="what_to_show" id="what_to_show">
        <option value="ALL"<? if ($_POST["what_to_show"] == 'ALL') echo "selected=\"selected\"";?>>All</option>
        <option value="DRIVERS"<? if ($_POST["what_to_show"] == 'DRIVERS') echo "selected=\"selected\"";?>>Only Drivers</option>
      </select></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
    <tr>
      <td height="28" colspan="2">Cost -&gt; Reserves + Payments (Recoveries are not included) </td>
    </tr>
  </table>
</form>
<br />
<br />
<div id="print_view_section_html">
<style type="text/css">
HR {
page-break-after: always;
}

.main_text {
font:Arial, Helvetica, sans-serif;
font-size:10px;
}
</style>
<?
if ($_POST["export_file"] == "totals") {

	$policy_covers["A"] = 'Thirt Party';
	$policy_covers["B"] = 'Fire & Theft';
	$policy_covers["C"] = 'Comprehensive';
	$policy_covers["D"] = 'F&T + Comprehensive';
	$policy_covers["ALL"] = 'All Claims';

	echo "<div align=\"center\">Claims Analysis For ".$_POST["from_period"]."/".$_POST["from_year"]." As At Date ".$_POST["as_at_date"]."<br>";
	echo "Claim Open Date [".$_POST["open_date_from"]." - ".$_POST["open_date_to"]."] For Insurance Types [".$_POST["klado_from"]." - ".$_POST["klado_to"]."] <br>Excluding [".$_POST["klado_exclude"]."] For Policy Cover ".$policy_covers[$_POST["policy_cover"]]."</div>";

//which fields to show
$fields["Claim Bands"]["show_prof"] = 'NO';
$fields["Per Driver Age"]["show_prof"] = 'NO';
$fields["Per Driver Age New/Renewal"]["show_prof"] = 'NO';
$fields["Per Driver Experience"]["show_prof"] = 'NO';


foreach ($data as $name => $section) {

?>
<table width="760" border="1" cellspacing="0" cellpadding="0" align="center" class="main_text">
  <tr>
    <td width="204"><strong><? echo $name;?></strong></td>
    <td width="90" align="center"><strong>Total Cost </strong></td>
    <td width="90" align="center"><strong>Claim Count </strong></td>
    <td width="90" align="center"><strong>Cost % </strong></td>
    <td width="90" align="center"><strong>Count % </strong></td>
    <td width="90" align="center"><strong>Policies</strong></td>
    <td width="90" align="center"><strong>Prem</strong></td>
    <td width="90" align="center"><strong>Prem%</strong></td>
    <td width="90" align="center"><strong>P.Cnt%</strong></td>
    <td width="90" align="center"><strong>Prof.</strong></td>
    <td width="90" align="center"><strong>Claims/ Policies</strong></td>
    <td width="90" align="center"><strong>Cost/ Prem</strong></td>
  </tr>
<? 
$total_cost = 0;
$total_count = 0;
$total_premium = 0;
$total_policies = 0;
	foreach($section as $sec_name => $sec_value) {
			
		$total_cost += $sec_value["Cost"];
		$total_count += $sec_value["Count"];
		$total_premium += $sec_value["Premium"];
		$total_policies += $sec_value["PolCount"];
		
?>
  <tr>
    <td><? echo $sec_name;?></td>
    <td align="center"><? echo $sec_value["Cost"];?></td>
    <td align="center"><? echo $sec_value["Count"];?></td>
    <td align="center"><? if ($total_cost > 0 ) echo $db->fix_int_to_double(($sec_value["Cost"] / $grand_total_cost)*100,2); else echo 0;?>%</td>
    <td align="center"><? if ($total_count > 0) echo $db->fix_int_to_double(($sec_value["Count"] / $grand_total_count)*100,2); else echo 0;?>%</td>
    <td align="center"><? echo $sec_value["PolCount"];?></td>
    <td align="center"><? echo $sec_value["Premium"];?></td>
    <td align="center"><? if ($total_premium > 0) echo $db->fix_int_to_double(($sec_value["Premium"] / $pol_grand_total_premium)*100,2); else echo 0;?>%</td>
    <td align="center"><? if ($total_policies > 0) echo $db->fix_int_to_double(($sec_value["PolCount"] / $pol_grand_total_count)*100,2); else echo 0;?>%</td>
    <td align="center"><? if ($fields[$name]["show_prof"] <> 'NO') { echo $sec_value["Premium"] - $sec_value["Cost"];} else echo "&nbsp;";?></td>
    <td align="center"><? if ($sec_value["PolCount"] > 0) echo $db->fix_int_to_double(($sec_value["Count"] / $sec_value["PolCount"])*100,2); else echo 0;?>%</td>
    <td align="center"><? if ($sec_value["Premium"] > 0) echo $db->fix_int_to_double(($sec_value["Cost"] / $sec_value["Premium"])*100,2); else echo 0;?>%</td>
  </tr>
<? } //for each section ?>

  <tr>
    <td align="right"><strong>Total</strong></td>
    <td align="center"><? echo $total_cost;?></td>
    <td align="center"><? echo $total_count;?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>    
    <td align="center"><? echo $total_policies;?></td>
    <td align="center"><? echo $total_premium;?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><? if ($fields[$name]["show_prof"] <> 'NO') { echo $total_premium - $total_cost;} else echo "&nbsp;";?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>    
  </tr>
</table>
<HR color="#FFFFFF" width="1" align="center" noshade="noshade">
<? 
}//foreach
?>



<?
}
else {
echo $table_data;
}
?>
</div>
<?
$db->show_footer();
?>