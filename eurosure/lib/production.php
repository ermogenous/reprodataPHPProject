<?php
function production_as_at_date($as_at_date,$up_to_period,$up_to_year,$extra_select='',$extra_from='',$extra_where='',$extra_group='',$extra_sort='',$extra_at_the_end=''){
	
	
$sql = "
SELECT
1 as clo_default_sort,
inagents.inag_agent_code ,           
ininsurancetypes.inity_insurance_type ,           
inpolicies.inpol_policy_number ,           
inpolicies.inpol_process_status ,           
inpolicies.inpol_status ,
inpol_period_starting_date,
inpolicies.inpol_insured_amount ,           
inpolicyendorsement.inped_premium ,           
inpolicyendorsement.inped_period ,           
inpolicyendorsement.inped_year ,           
inpolicysituations.inpst_situation_code ,           
inreinsurancetreaties.inrit_reinsurance_treaty ,           
inreinsurancetreaties.inrit_risk_category ,           
inpolicyitems.inpit_insured_amount ,           
inity_major_category,
( Select incd_long_description From inpcodes where incd_record_type = '01' And incd_record_code = inity_major_category ) As clo_major_description,
inity_long_description,
COALESCE((SELECT LIST(DISTINCT inach_attachment_code) FROM inpolicyattachments, inattachments WHERE inpat_attachment_serial = inach_attachment_serial AND inpat_policy_serial = inpolicies.inpol_policy_serial), '') as clo_attachments,
inpolicies.inpol_policy_serial ,
initems.initm_item_flag ,
inpolicysituations.inpst_postal_code
".$extra_select."

FROM 
inpolicies 
LEFT OUTER JOIN inpolicyendorsement ON inpolicies.inpol_last_endorsement_serial = inpolicyendorsement.inped_endorsement_serial, 
inpolicysituations 
RIGHT OUTER JOIN inpolicyitems ON inpolicysituations.inpst_situation_serial = inpolicyitems.inpit_situation_serial 
LEFT OUTER JOIN inpolicyitemaux ON inpit_pit_auto_serial = inpia_pit_auto_serial
LEFT OUTER JOIN inreinsurancetreaties ON inpolicyitems.inpit_reinsurance_treaty = inreinsurancetreaties.inrit_reinsurance_treaty_serial,           
inagents ,           
ingeneralagents ,           
inclients ,           
ininsurancetypes ,           
initems    
".$extra_from."

WHERE 
( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and          ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( inpolicyitems.inpit_policy_serial = inpolicies.inpol_policy_serial ) 
and          ( initems.initm_item_serial = inpolicyitems.inpit_item_serial )    

AND  1=1  
AND (inpol_process_status IN ('N','R','E','D')) 
AND inpol_status IN ('A','N') 
AND (inped_year*100+inped_period)<=(".$up_to_year."*100+".$up_to_period.") 
AND '".$as_at_date."' BETWEEN inpol_starting_date AND COALESCE(IF (SELECT a.inped_year * 100 + a.inped_period FROM inpolicyendorsement a WHERE a.inped_endorsement_serial = inpol_last_cancellation_endorsement_serial) <= YEAR('".$as_at_date."') * 100 + MONTH('".$as_at_date."') THEN inpol_cancellation_date ELSE NULL ENDIF, inpol_expiry_date) 

".$extra_where."

ORDER BY  
clo_default_sort ASC

".$extra_sort."

".$extra_group."

".$extra_at_the_end."

";
	
	
return $sql;
}//function production_as_at_date

function get_policy_phase_production($policy_number,$period_starting_date,$extra_where) {

$sql = "select
-1 * SUM(inpolicyendorsement.inped_premium_debit_credit * (IF inloadings.inldg_loading_type <> 'X' THEN IF inpolicyendorsement.inped_premium_debit_credit = -1 THEN inpolicyloadings.inplg_period_premium ELSE inpolicyloadings.inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as clo_premium
FROM inpolicyendorsement
JOIN inpolicies ON inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs
JOIN inpolicyitems ON inpolicyendorsement.inped_policy_serial = inpolicyitems.inpit_policy_serial
LEFT OUTER JOIN inpolicyitemaux ON inpolicyitemaux.inpia_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial
JOIN initems ON initems.initm_item_serial = inpolicyitems.inpit_item_serial
JOIN inpolicyloadings ON inpolicyitems.inpit_pit_auto_serial = inpolicyloadings.inplg_pit_auto_serial
JOIN inloadings ON inloadings.inldg_loading_serial = inpolicyloadings.inplg_loading_serial
LEFT OUTER JOIN inreinsurancetreaties ON inpolicyitems.inpit_reinsurance_treaty = inreinsurancetreaties.inrit_reinsurance_treaty_serial

where
".$extra_where."
AND inpolicies.inpol_policy_number = ".$policy_number."
AND inpolicies.inpol_period_starting_date = ".$period_starting_date."
";

return $sql;
}

function sql_clo_sort($database,$sql,$clo_sort_1,$clo_sort_2,$clo_sort_3) {
global $$database;
//echo $sql."<hr>";	
	$out = "<div>";
	$result = $$database->query($sql);
	while ($row = $$database->fetch_assoc($result)) {
		
		foreach ($row as $field_name => $value) {
			if (substr($field_name,0,5) == 'show_' || $field_name == $clo_sort_1 || $field_name == $clo_sort_2 || $field_name == $clo_sort_3) {
				echo $field_name." - ".$value."<br>";	
			}
		}
		
	}
	$out .="</div>";
	
	echo "<hr>";
}

function medical_earned_per_period_sql ($period,$year) {
	
$sql = "SELECT
".$year." as PROCESS_YEAR,
".$period." as PROCESS_PERIOD,
inpol_policy_number,
inpol_policy_serial,
IF inped_financial_policy < 0 THEN 'C' ELSE inpol_process_status ENDIF as clo_process_status,
inped_financial_policy_abs,
inped_financial_policy,
(SELECT incl_first_name + ' ' + incl_long_description FROM inclients WHERE incl_client_serial = inpol_client_serial)as clo_owner_name,
(SELECT MAX(inpst_package_code) FROM inpolicysituations WHERE inpst_policy_serial = inped_financial_policy_abs)as clo_package_code,
(SELECT MAX(inpinst_installment_type) FROM inpolicyinstallment WHERE inpinst_policy_serial = inped_financial_policy_abs)as clo_installment_type,
(SELECT MAX(inpia_insured_amount_alt5) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inped_financial_policy_abs)as clo_excess,
COALESCE((SELECT incd_long_description FROM inclients join inpcodes ON incl_nationality = incd_pcode_serial WHERE incl_client_serial = inpol_client_serial),'Cypriot')as clo_owner_country,
LIST(inped_policy_serial) as clo_policies, LIST(inped_endorsement_serial) as clo_endrs, 
inpol_last_endorsement_serial,

//-1 * SUM(inped_premium_debit_credit * inped_premium) as ADD_REF_PREMIUM, 
fn_return_period_loadings_premium(inpol_policy_serial,'ONLYCURRENT','AND incd_ldg_rsrv_under_reinsurance = ''Y'' AND (inped_process_status <> ''C'') AND (inped_year * 100 + inped_period) <= '+ string(PROCESS_YEAR * 100 + PROCESS_PERIOD)) as ADD_REF_PREMIUM,

inpol_period_starting_date as PERIOD_START, 
inpol_starting_date AS PHASE_START,
COALESCE(DATEADD(DAY, -1, clo_cancellation_date), inpol_expiry_date) as PHASE_END,

//DATEDIFF(Day, inpol_starting_date, PHASE_END)+1 as PHASE_DAYS,
DATEDIFF(Day, inpol_starting_date, inpol_expiry_date)+1 as PHASE_DAYS,

DATEDIFF(Day, inpol_starting_date, IF PHASE_END > clo_period_end THEN clo_period_end ELSE PHASE_END ENDIF)+1 as EARNED_DAYS,
IF inped_year = PROCESS_YEAR AND inped_period = PROCESS_PERIOD THEN EARNED_DAYS
ELSE IF PHASE_END < clo_period_start THEN 
	//if policy is already expired when cancelled.
	IF inpol_expiry_date < clo_period_start THEN DATEDIFF(DAY, inpol_expiry_date, PHASE_END) 
	//not expired when cancelled.
	ELSE DATEDIFF(DAY, clo_period_start, PHASE_END)+1 ENDIF/* NEGATIVE */
	
ELSE IF PHASE_START > clo_period_start AND PHASE_END < clo_period_end THEN DATEDIFF(DAY, PHASE_START, PHASE_END)+1 /* PHASE SHORTER THAN THE PERIOD */
ELSE IF PHASE_START > clo_period_start THEN DATEDIFF(DAY, PHASE_START, clo_period_end)+1 
ELSE IF PHASE_END < clo_period_end THEN DATEDIFF(DAY, clo_period_start, PHASE_END)+1 
ELSE DATEDIFF(DAY, clo_period_start, clo_period_end)+1 ENDIF ENDIF ENDIF ENDIF ENDIF AS PERIOD_WORKING_DAYS,
inped_year, 
inped_period,

DATE(STRING(PROCESS_YEAR, '/', PROCESS_PERIOD, '/01')) as clo_period_start,
DATE(DATEADD(DAY, -1, DATE(STRING( IF PROCESS_PERIOD = 12 THEN PROCESS_YEAR +1 ELSE PROCESS_YEAR ENDIF, '/', IF PROCESS_PERIOD = 12 THEN 1 ELSE PROCESS_PERIOD+1 ENDIF, '/01')))) as clo_period_end,
//(ADD_REF_PREMIUM + COALESCE(clo_cancellation_refund_premium,0)) * PERIOD_WORKING_DAYS / PHASE_DAYS as clo_cost,
ADD_REF_PREMIUM * PERIOD_WORKING_DAYS / PHASE_DAYS as clo_cost,

clo_cancellation_date, clo_cancellation_period, clo_cancellation_year, 
IF clo_cancelled_policy_serial = inpol_policy_serial THEN 'cancel_row' ELSE '' ENDIF as clo_cancel_row,
clo_cancellation_refund_premium,
(ADD_REF_PREMIUM + COALESCE(clo_cancellation_refund_premium,0)) as clo_cost_total
into #temp
FROM inpolicyendorsement 
JOIN inpolicies ON inpol_policy_serial = inped_financial_policy_abs
LEFT OUTER JOIN (SELECT inpol_policy_serial as clo_cancelled_policy_serial,inpol_cancellation_date as clo_cancellation_date,
                               inped_year as clo_cancellation_year,
                               inped_period as clo_cancellation_period,
							   /*-1 *(inped_premium * inped_premium_debit_credit) */
								fn_return_period_loadings_premium(inpol_policy_serial,'ONLYCURRENT','AND incd_ldg_rsrv_under_reinsurance = ''Y'' AND (inped_process_status = ''C'') AND (inped_year * 100 + inped_period) <= '+ string(".$year." * 100 + ".$period."),'refund')as clo_cancellation_refund_premium,
                              inpol_policy_number as clo_policy_number, inpol_period_starting_date as clo_period_starting_date
                       FROM inpolicies JOIN inpolicyendorsement ON inpol_policy_serial = inped_financial_policy_abs
					   				   JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
                       WHERE inped_financial_policy < 0 AND inped_premium_debit_credit <> 0
					   AND inity_insurance_type = '1101') AS CANCELLATION_VIEW
        ON CANCELLATION_VIEW.clo_policy_number = inpolicies.inpol_policy_number 
AND CANCELLATION_VIEW.clo_period_starting_date = inpolicies.inpol_period_starting_date
        AND CANCELLATION_VIEW.clo_cancellation_year * 100 + CANCELLATION_VIEW.clo_cancellation_period <= PROCESS_YEAR * 100 + PROCESS_PERIOD
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial

WHERE inped_premium_debit_credit <> 0
AND inped_status = '1'
AND clo_process_status NOT IN ('D','C')
AND inped_year * 100 + inped_period <= PROCESS_YEAR * 100 + PROCESS_PERIOD


//AND COALESCE(IF clo_cancellation_year * 100 + clo_cancellation_period < PROCESS_YEAR * 100 + PROCESS_PERIOD THEN clo_cancellation_date ELSE NULL ENDIF, inpol_expiry_date) >= clo_period_start

//remove the cancellations that are already returned in previous periods.
AND (COALESCE(IF clo_cancellation_year * 100 + clo_cancellation_period < PROCESS_YEAR * 100 + PROCESS_PERIOD THEN clo_cancellation_date ELSE NULL ENDIF, inpol_expiry_date) >= clo_period_start 
    OR (clo_cancellation_year * 100 + clo_cancellation_period = PROCESS_YEAR * 100 + PROCESS_PERIOD AND YEAR(inpol_expiry_date) * 100 + MONTH(inpol_expiry_date) < PROCESS_YEAR * 100 + PROCESS_PERIOD))

AND inity_insurance_type = '1101'

GROUP BY inpol_policy_number, inpol_policy_serial, clo_process_status, inped_financial_policy_abs, inped_financial_policy,inpol_last_endorsement_serial,
inpol_period_starting_date, inpol_starting_date, inped_year, inped_period, inpol_expiry_date,
clo_cancelled_policy_serial, clo_cancellation_date, clo_cancellation_period, clo_cancellation_year, clo_cancellation_refund_premium, inpol_client_serial

ORDER BY inpol_policy_number, inped_financial_policy_abs, inped_financial_policy desc


SELECT
//get the process_status
inpol_policy_number
,inpol_policy_serial
,clo_owner_name
,clo_package_code
,clo_installment_type
,clo_excess
,clo_owner_country
,inpol_last_endorsement_serial
,inped_financial_policy_abs
,inped_financial_policy
,PERIOD_START
,PHASE_END
//get the process_status of the policy. if the row has cancellation period and year and also the clo_cancel_row = cancel_row that means this record has cancellation data on it.
,IF clo_cancellation_period IS NOT NULL AND clo_cancellation_year IS NOT NULL AND clo_cancel_row = 'cancel_row' THEN 'C' ELSE clo_process_status ENDIF as clo_process_status
//if the clo_cancel_row = cancel_row and cancellation year/period equals to working period OR period/year is equal to Working period/year then this row has been posted in the working period
,IF (inped_year = PROCESS_YEAR AND inped_period = PROCESS_PERIOD) OR (clo_cancellation_period = PROCESS_PERIOD AND clo_cancellation_year = PROCESS_YEAR AND clo_cancel_row = 'cancel_row') THEN 1 ELSE 0 ENDIF as clo_affects_working_period
//find the earned premium
//SPECIAL CASE: if the policy is cancelled on the same period with the written period then we use the written premium less the refund.
,IF clo_process_status = 'C' AND inped_year = clo_cancellation_year AND inped_period = clo_cancellation_period THEN ADD_REF_PREMIUM + clo_cancellation_refund_premium ELSE round(clo_cost,2) ENDIF as clo_earned_premium
//get the year premium. This is used by underwriting to validate the correction of the report.
,IF clo_process_status = 'C' THEN 
    //IF clo_cost = 0 THEN 0 ELSE 
        //if the policy and cancellation in the same period
        IF inped_year = clo_cancellation_year AND inped_period = clo_cancellation_period THEN ADD_REF_PREMIUM + clo_cancellation_refund_premium
        ELSE clo_cancellation_refund_premium ENDIF

    //ENDIF
 ELSE ADD_REF_PREMIUM
    
ENDIF as clo_year_premium


FROM
#temp

ORDER BY clo_affects_working_period DESC, inpol_policy_number ASC";
return $sql;
}

function premium_per_commissions($year_from,$year_to,$period_from,$period_to,$extra_from='',$extra_where='',$extra_group='',$extra_order='',$extra_having='',$extra_end=0) {
	if ($extra_order != "") {
		$extra_oder = "ORDER BY ".$extra_order;	
	}
	
if ($extra_end == 1) {
	$extra_end = "SELECT
CASE
WHEN inity_insurance_type LIKE '19%' THEN '19-MOTOR'
WHEN clo_ac_code = 'PA(10)' AND inity_insurance_type NOT LIKE '19%' THEN '10-PA'
WHEN clo_ac_code IN ('GIT(16)','Cargo(16)') THEN '16-GIT'
WHEN clo_ac_code IN ('Fire(17)','OtherPerils(18)','Theft(18)','C.A.R.(17)','JB(17)','Oth.Perils(18)','Other Perils(18)') THEN '17-Fire'
WHEN clo_ac_code IN ('EL(22)','Liability(22)','PL(22)') THEN '22-Liability'

WHEN clo_ac_code IN ('Earthquake(18)','E.Q.(18)','EQ(18)') THEN '18-EarthQuake'
WHEN clo_ac_code = 'MEDMAL-I(22)' THEN '22-Medmal'
WHEN clo_ac_code = 'PI(22)' THEN '22-PI'
WHEN clo_ac_code IN ('Hull(21)','TPL(21)') THEN '21-Hull'
WHEN clo_ac_code = 'MedEx (11)' THEN '11-MedEx'

ELSE clo_ac_code
end
as clo_account_code
,SUM(#temp.clo_total_premium)as clo_total_premium
,SUM(clo_commission_total)as clo_total_commission
FROM
#temp
GROUP BY 
clo_account_code
ORDER BY 
clo_account_code";	
}
else {
	$extra_end = '';	
}
	
$sql = "SELECT
inldg_loading_serial
,inity_insurance_type
,inldg_loading_code
,inldg_long_description
,incl_alpha_key1
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
,claim_reserve.incd_ldg_rsrv_under_reinsurance
,CASE
WHEN inldg_commission_assigned = '' THEN subform.incd_scale_1_cc
WHEN inldg_commission_assigned = 1 THEN subform.incd_scale_2_cc
WHEN inldg_commission_assigned = 2 THEN subform.incd_scale_3_cc
WHEN inldg_commission_assigned = 3 THEN subform.incd_scale_4_cc
WHEN inldg_commission_assigned = 4 THEN subform.incd_scale_5_cc
WHEN inldg_commission_assigned = 5 THEN subform.incd_scale_6_cc
WHEN inldg_commission_assigned = 6 THEN subform.incd_scale_7_cc
WHEN inldg_commission_assigned = 7 THEN subform.incd_scale_8_cc
WHEN inldg_commission_assigned = 8 THEN subform.incd_last_document_number
WHEN inldg_commission_assigned = 9 THEN subform.incd_layout_name
WHEN inldg_commission_assigned = 10 THEN subform.incd_alternative_description
end
AS clo_ac_code

,CASE
WHEN inldg_commission_assigned = '' THEN (inpol_commission_percentage / 100) * clo_total_premium
WHEN inldg_commission_assigned = 1 THEN (inpol_commission_percentage1 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 2 THEN (inpol_commission_percentage2 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 3 THEN (inpol_commission_percentage3 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 4 THEN (inpol_commission_percentage4 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 5 THEN (inpol_commission_percentage5 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 6 THEN (inpol_commission_percentage6 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 7 THEN (inpol_commission_percentage7 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 8 THEN (inpol_commission_percentage8 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 9 THEN (inpol_commission_percentage9 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 10 THEN (inpol_commission_percentage10 / 100) * clo_total_premium
end
AS clo_commission_total

,inag_agent_code
,inag_long_description

".$extra_from."
FROM
inpolicyendorsement 
JOIN inpolicies ON inped_financial_policy_abs = inpol_policy_serial
JOIN inclients ON incl_client_serial = inpol_client_serial
JOIN inagents ON inpol_agent_serial = inag_agent_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpcodes as subform ON inity_insurance_sub_form = subform.incd_record_code AND subform.incd_record_type = 'SF'

JOIN inpolicyloadings ON inplg_policy_serial = inped_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
LEFT OUTER JOIN inpcodes as claim_reserve ON inldg_claim_reserve_group = claim_reserve.incd_pcode_serial

WHERE
1=1
AND inped_year BETWEEN ".$year_from." AND ".$year_to."
AND inped_period BETWEEN ".$period_from." AND ".$period_to."
AND inped_status = 1

".$extra_where."


GROUP BY 
inldg_loading_serial
,inldg_loading_code
,inldg_long_description
,inity_insurance_type
,claim_reserve.incd_ldg_rsrv_under_reinsurance
,clo_ac_code
,inag_agent_code
,inag_long_description
,inldg_commission_assigned
,inpol_commission_percentage
,inpol_commission_percentage1
,inpol_commission_percentage2
,inpol_commission_percentage3
,inpol_commission_percentage4
,inpol_commission_percentage5
,inpol_commission_percentage6
,inpol_commission_percentage7
,inpol_commission_percentage8
,inpol_commission_percentage9
,inpol_commission_percentage10
,incl_alpha_key1
".$extra_group."

HAVING
1=1
".$extra_having." 

".$extra_order."

".$extra_end;

return $sql;	
}

function unearned_premiums_per_commission_code($as_at_date,$extra_from='',$extra_where='',$extra_group='',$extra_order='',$extra_having='',$extra_end='') {
		if ($extra_order != "") {
		$extra_oder = "ORDER BY ".$extra_order;	
	}

$sql = "
SELECT 
'".$as_at_date."' as clo_as_at_date,   
YEAR(clo_as_at_date) * 100 + MONTH(clo_as_at_date) As clo_as_at_period,   
SUM(inplg_period_premium) as clo_phase_gross_premium,   
//REPLACE(inldg_income_account, 'REP:', '') as clo_ac_code,   
inity_insurance_type,
inag_agent_code,

CASE
WHEN inldg_commission_assigned = '' THEN subform.incd_scale_1_cc
WHEN inldg_commission_assigned = 1 THEN subform.incd_scale_2_cc
WHEN inldg_commission_assigned = 2 THEN subform.incd_scale_3_cc
WHEN inldg_commission_assigned = 3 THEN subform.incd_scale_4_cc
WHEN inldg_commission_assigned = 4 THEN subform.incd_scale_5_cc
WHEN inldg_commission_assigned = 5 THEN subform.incd_scale_6_cc
WHEN inldg_commission_assigned = 6 THEN subform.incd_scale_7_cc
WHEN inldg_commission_assigned = 7 THEN subform.incd_scale_8_cc
WHEN inldg_commission_assigned = 8 THEN subform.incd_last_document_number
WHEN inldg_commission_assigned = 9 THEN subform.incd_layout_name
WHEN inldg_commission_assigned = 10 THEN subform.incd_alternative_description
end
AS clo_ac_code,

SUM(IF clo_as_at_date < inpva_expiry_date THEN COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, clo_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_gross_unearned_premium


".$extra_from."

FROM ininsurancetypes 
LEFT OUTER JOIN inmajorcodes ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code 
LEFT OUTER JOIN inminorcodes ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code,   
         inpolicies,   
         inagents,   
         ingeneralagents,   
         inpoliciesactive,   
         inpparam,   
         inpolicyloadings,   
         inloadings,   
         inpcodes as peril,   
         inpolicyitems,   
         initems,
		 ininsurancetypes, 
		 inpcodes as subform
   WHERE ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) and  
         ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial ) and  
         ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) and  
         ( inpoliciesactive.inpva_policy_serial = inpolicies.inpol_policy_serial ) and  
         ( inpolicyloadings.inplg_policy_serial = inpolicies.inpol_policy_serial ) and  
         ( inloadings.inldg_loading_serial = inpolicyloadings.inplg_loading_serial ) and  
         ( peril.incd_pcode_serial = inloadings.inldg_claim_reserve_group ) and  
         ( inpolicyloadings.inplg_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial ) and  
         ( initems.initm_item_serial = inpolicyitems.inpit_item_serial ) and  
		 inpol_insurance_type_serial = inity_insurance_type_serial and 
		 inity_insurance_sub_form = subform.incd_record_code AND subform.incd_record_type = 'SF' AND 
		 
         (inpva_status = 'N' AND  
           inpva_year * 100 + inpva_period <= clo_as_at_period) AND  
         UPPER(inpparam.inpr_module_code) = 'IN' AND  
         (((inldg_loading_type <> 'X') /* Not X-Premium */ AND  
          ((inldg_loading_type = inpol_cover) OR  
           (inpol_cover = 'B' AND  
            inpr_act_in_fire_theft = 'N') OR  
           (inpol_cover = 'C' AND  
            inpr_act_in_comprehensive = 'N'))))   

".$extra_where."

GROUP BY 
inpoliciesactive.inpva_as_at_date   
,inloadings.inldg_income_account
,inpit_reinsurance_treaty
,peril.incd_ldg_rsrv_under_reinsurance
,inity_insurance_type
,inag_agent_code
,inpol_policy_serial
,subform.incd_alternative_description
,subform.incd_layout_name
,inldg_commission_assigned
,subform.incd_last_document_number
,subform.incd_scale_1_cc
,subform.incd_scale_2_cc
,subform.incd_scale_3_cc
,subform.incd_scale_4_cc
,subform.incd_scale_5_cc
,subform.incd_scale_6_cc
,subform.incd_scale_7_cc
,subform.incd_scale_8_cc
".$extra_group."
HAVING 
1=1
".$extra_having."
".$extra_order."
".$extra_end."
";
return $sql;
}

function expiration_list($from_date,$to_date,$financial_year,$financial_period,$extra_select='',$extra_from='',$extra_where='',$extra_group='',$extra_order='',$extra_having='',$extra_end='') {
	
$sql = "
SELECT 
EXPIRATION_LIST.*,
       IF COALESCE(POLICY_UNDER_STUDY.inpol_replaced_by_policy_serial, 0) <> 0 THEN POLICY_UNDER_STUDY.inpol_replaced_by_policy_serial 
       ELSE COALESCE((SELECT a.inpol_policy_serial FROM inpolicies a
            WHERE a.inpol_policy_number = POLICY_UNDER_STUDY.inpol_policy_number
            AND a.inpol_status IN ('O','C') AND a.inpol_process_status <> 'D'), 0) ENDIF as CLO_FOLLOWING_POLICY_PHASE,
       CASE
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND clo_following_policy_phase = 0 AND POLICY_UNDER_STUDY.inpol_cancellation_date IS NOT NULL THEN 'CANCELLED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND clo_following_policy_phase = 0 AND POLICY_UNDER_STUDY.inpol_cancellation_date IS NULL THEN 'LAPSED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND FOLLOWING_PHASE.inpol_process_status = 'E' THEN 'ENDORSED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND FOLLOWING_PHASE.inpol_process_status = 'R' THEN 'RENEWED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'N' AND FOLLOWING_PHASE.inpol_process_status = 'E' THEN 'UNDER_ENDORSEMENT'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'N' AND FOLLOWING_PHASE.inpol_process_status = 'R' THEN 'UNDER_RENEWAL'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'N' AND FOLLOWING_PHASE.inpol_process_status = 'C' THEN 'UNDER_CANCELLATION'
       ELSE IF POLICY_UNDER_STUDY.inpol_status = 'A' THEN 'ARCHIVED UNKNOWN' ELSE 'NORMAL/ACTIVE' ENDIF END as OBSERVATION_STATUS,
POLICY_UNDER_STUDY.inpol_renewal,
inity_insurance_type,
POLICY_UNDER_STUDY.inpol_period_starting_date,
FOLLOWING_PHASE.inpol_period_starting_date as fp_period_starting_date,
POLICY_UNDER_STUDY.inpol_status,
POLICY_UNDER_STUDY.inpol_process_status,
POLICY_UNDER_STUDY.inpol_created_by,
POLICY_UNDER_STUDY.inpol_cover as current_policy_cover,
COALESCE((SELECT next.inpol_cover FROM inpolicies as next WHERE next.inpol_policy_serial = CLO_FOLLOWING_POLICY_PHASE),'')as next_policy_cover,
IF next_policy_cover <> current_policy_cover AND next_policy_cover <> '' THEN 1 ELSE 0 ENDIF as cover_changed,
inag_agent_code,
LEFT(inag_long_description,18)as agent_name
".$extra_select."

FROM (SELECT MAX(inpol_policy_serial) as expl_last_policy_phase,
            inpol_period_starting_date as expl_period_starting_date,
            inpol_policy_number as expl_policy_number, 
            (SELECT a.inpol_expiry_date FROM inpolicies a WHERE a.inpol_policy_serial = expl_last_policy_phase) as expl_expiry_date,
            //in the case where you want to exclude policies posted after the defined date AND expl_posted_on <= '2013-05-31'
            //(SELECT b.inped_status_changed_on FROM inpolicies a JOIN inpolicyendorsement b ON b.inped_policy_serial = a.inpol_policy_serial AND b.inped_endorsement_serial = a.inpol_last_endorsement_serial WHERE a.inpol_policy_serial = expl_last_policy_phase) as expl_posted_on
            //in the case where you want to exclude policies posted financially after the defined date.
            (SELECT (inped_year * 100 + inped_period) FROM inpolicies a JOIN inpolicyendorsement b ON b.inped_policy_serial = a.inpol_policy_serial AND b.inped_endorsement_serial = a.inpol_last_endorsement_serial WHERE a.inpol_policy_serial = expl_last_policy_phase) as expl_financial_posted_period
      FROM  inpolicies 
      WHERE inpol_status IN ('N', 'A') /* Normal & Archived */
      AND   inpol_process_status <> 'D' /* Exclude Declaration Adjustments */
      GROUP BY expl_policy_number, expl_period_starting_date) AS EXPIRATION_LIST
JOIN inpolicies AS POLICY_UNDER_STUDY ON POLICY_UNDER_STUDY.inpol_policy_serial = EXPIRATION_LIST.expl_last_policy_phase
LEFT OUTER JOIN inpolicies AS FOLLOWING_PHASE ON FOLLOWING_PHASE.inpol_policy_serial = CLO_FOLLOWING_POLICY_PHASE
LEFT OUTER JOIN ininsurancetypes ON POLICY_UNDER_STUDY.inpol_insurance_type_serial = inity_insurance_type_serial
LEFT OUTER JOIN inagents ON POLICY_UNDER_STUDY.inpol_agent_serial = inag_agent_serial
".$extra_from."
WHERE 
EXPIRATION_LIST.expl_expiry_date BETWEEN '".$from_date."' AND '".$to_date."'
AND expl_financial_posted_period <= (".$financial_year." * 100 + ".$financial_period.")
AND POLICY_UNDER_STUDY.inpol_created_by <> 'IMP_ARCHIVE'
".$extra_where."

".$extra_group."

".$extra_having."
ORDER BY inag_agent_code,expl_policy_number, expl_expiry_date, expl_last_policy_phase 
".$extra_order."

".$extra_end;

return $sql;	
}
?>