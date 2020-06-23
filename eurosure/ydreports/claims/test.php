<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1,'UTF-8');
include("../../include/sybasecon.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("claims_ratio_report_functions.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$inqueries = new insurance_queries();

$db->show_header();

//productions for 2210
$sql = $sybase->query("SELECT  
('2009') as clo_year,           
('1') as clo_period_from,
('12') as clo_period_to,
(-1 * sum (IF clo_year = inped_year AND clo_period_to = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_to_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5') AND intrd_owner = 'O'))as clo_commission,
inag_agent_code As clo_sort1,           
inity_major_category As clo_sort2,  
inity_insurance_type AS clo_sort3,
inpol_policy_number,
inpol_period_starting_date,

         
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
and          ( ( inpolicyendorsement.inped_status = '1' ) 
and          ( inpparam.inpr_module_code = 'IN' ) ) 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND clo_sort1 LIKE '%%' 
AND clo_sort2 LIKE '%%'
AND clo_sort3 LIKE '2210'

GROUP BY inpparam.inpr_module_code, clo_sort1, clo_desc1, clo_sort2, clo_desc2 ,clo_sort3,inpol_policy_number,inpol_period_starting_date
ORDER BY  clo_period_stamps DESC , inpol_policy_number ASC , clo_sort3 ASC");

	while ($row = $sybase->fetch_assoc($sql)) {

		//echo $row["clo_stamps"];
		$fees += $row["clo_period_fees"];
		$premium += $row["clo_ytd_premium"];
		$stamps += $row["clo_period_stamps"];
		$mif += $row["clo_period_mif"];
		$com += $row["clo_commission"];
		$total_rows++;
	}

echo "<strong>2210 EL TOTAL PREMIUMS</strong><br>
Fees ->".$fees."<br>
 PREMIUM ->".$premium."<br>
  Stamps-> ".$stamps."<br>
  MIF ->".$mif."<br>
  Commission ->".$com."<br>
  TOTAL ->".$total_rows;

echo "<hr><hr>";



//productions for 2210 oikodomikes ergasies
////===========================================================================================================================================================================
$sql = $sybase->query("SELECT  
('2009') as clo_year,           
('1') as clo_period_from,
('12') as clo_period_to,
(-1 * sum (IF clo_year = inped_year AND clo_period_to = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_to_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5') AND intrd_owner = 'O'))as clo_commission,
inag_agent_code As clo_sort1,           
inity_major_category As clo_sort2,  
inity_insurance_type AS clo_sort3,
inpol_policy_number,
inpol_period_starting_date,

         
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
and          ( ( inpolicyendorsement.inped_status = '1' ) 
and          ( inpparam.inpr_module_code = 'IN' ) ) 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND clo_sort1 LIKE '%%' 
AND clo_sort2 LIKE '%%'
AND clo_sort3 LIKE '2210'
AND inpol_policy_occupation IN (689,682,442,513,704,5881,3869,514,407,686,544,5707)

GROUP BY inpparam.inpr_module_code, clo_sort1, clo_desc1, clo_sort2, clo_desc2 ,clo_sort3,inpol_policy_number,inpol_period_starting_date
ORDER BY  clo_period_stamps DESC , inpol_policy_number ASC , clo_sort3 ASC");

	while ($row = $sybase->fetch_assoc($sql)) {

		//echo $row["clo_stamps"];
		$ofees += $row["clo_period_fees"];
		$opremium += $row["clo_ytd_premium"];
		$ostamps += $row["clo_period_stamps"];
		$omif += $row["clo_period_mif"];
		$ocom += $row["clo_commission"];
		$ototal_rows++;
	}

echo "<strong>2210 EL OIKODOMIKES ERGASIES</strong><br>
Fees ->".$ofees."<br>
 PREMIUM ->".$opremium."<br>
  Stamps-> ".$ostamps."<br>
  MIF ->".$omif."<br>
  Commission ->".$ocom."<br>
  TOTAL ->".$ototal_rows;

echo "<hr><hr>";


//productions for 2210 AHK
////===========================================================================================================================================================================
$sql = $sybase->query("SELECT  
('2009') as clo_year,           
('1') as clo_period_from,
('12') as clo_period_to,
(-1 * sum (IF clo_year = inped_year AND clo_period_to = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_to_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5') AND intrd_owner = 'O'))as clo_commission,
inag_agent_code As clo_sort1,           
inity_major_category As clo_sort2,  
inity_insurance_type AS clo_sort3,
inpol_policy_number,
inpol_period_starting_date,

         
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
and          ( ( inpolicyendorsement.inped_status = '1' ) 
and          ( inpparam.inpr_module_code = 'IN' ) ) 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND clo_sort1 LIKE '%%' 
AND clo_sort2 LIKE '%%'
AND clo_sort3 LIKE '2210'


GROUP BY inpparam.inpr_module_code, clo_sort1, clo_desc1, clo_sort2, clo_desc2 ,clo_sort3,inpol_policy_number,inpol_period_starting_date
ORDER BY  clo_period_stamps DESC , inpol_policy_number ASC , clo_sort3 ASC");

	while ($row = $sybase->fetch_assoc($sql)) {

		//echo $row["clo_stamps"];
		$ofees += $row["clo_period_fees"];
		$opremium += $row["clo_ytd_premium"];
		$ostamps += $row["clo_period_stamps"];
		$omif += $row["clo_period_mif"];
		$ocom += $row["clo_commission"];
		$ototal_rows++;
	}

echo "<strong>2210 EL OIKODOMIKES ERGASIES</strong><br>
Fees ->".$ofees."<br>
 PREMIUM ->".$opremium."<br>
  Stamps-> ".$ostamps."<br>
  MIF ->".$omif."<br>
  Commission ->".$ocom."<br>
  TOTAL ->".$ototal_rows;

echo "<hr><hr>";


//claims for MOTOR
//===========================================================================================================================================================================
$sql = $sybase->query("SELECT  
inagents.inag_agent_code ,             
inagents.inag_agent_serial ,           
         
DATE('2009-12-31') as clo_as_at_date,                 
IF clo_process_status IN ('C', 'W') THEN inclm_closed_period ELSE 0 ENDIF  AS clo_closed_period,           
IF clo_process_status IN ('C', 'W') THEN inclm_closed_year ELSE 0 ENDIF  AS clo_closed_year,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6') ,0) as clo_amount_paid,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_recoveries_recieved,           
COALESCE((Select sum(inirq_value * inirq_debit_credit) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'), 0) as clo_payments_recovery_exp,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6'),0) as clo_estimated_reserve,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_estimated_recoveries,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'),0) as clo_estimated_rec_expence_reserve,           
CASE inclm_process_status WHEN 'C' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 THEN 'O' ELSE IF clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE 'C' ENDIF ENDIF WHEN 'R' THEN IF clo_estimated_reserve - clo_amount_paid - (clo_estimated_rec_expence_reserve - clo_payments_recovery_exp) <> 0 THEN 'O' ELSE 'R' ENDIF WHEN 'W' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 OR clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'O' ELSE 'W' ENDIF WHEN 'O' THEN IF clo_estimated_reserve = 0 AND clo_estimated_recoveries = 0 THEN 'P' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved = 0 THEN 'C' ELSE 'O' ENDIF ENDIF ENDIF ELSE inclm_process_status END as clo_process_status,
inpolicies.inpol_cover as clo_policy_cover,


COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes LEFT OUTER JOIN inloadingstatcodes ON inlsc_pcode_serial = incd_ldg_reserve_group where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND inlsc_record_code = '19-230') ,0) as clo_windscreen_paid,
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes LEFT OUTER JOIN inloadingstatcodes ON inlsc_pcode_serial = incd_ldg_reserve_group Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND inlsc_record_code = '19-230'),0) as clo_windscreen_reserve,

COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reserve_payment_type = 'OD') ,0) as clo_OD_paid,
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reserve_payment_type = 'PD') ,0) as clo_PD_paid,
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reserve_payment_type = 'BI') ,0) as clo_BI_paid,

COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reserve_payment_type = 'OD'),0) as clo_OD_reserve,
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reserve_payment_type = 'PD'),0) as clo_PD_reserve,
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reserve_payment_type = 'BI'),0) as clo_BI_reserve
FROM inclaims  
LEFT OUTER JOIN initems  ON inclaims.inclm_item_serial = initems.initm_item_serial ,           
inclients ,           
inpolicies ,           
inagents ,           
ingeneralagents ,           
ininsurancetypes    

WHERE ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( inclaims.inclm_policy_serial = inpolicies.inpol_policy_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( ( inclaims.inclm_open_date <= clo_as_at_date ) 
and          ( inclaims.inclm_process_status <> 'I') 
and          ( inclaims.inclm_status <> 'D') )  
AND  1=1  
AND inclm_status in ('O','A','D') 
AND clo_process_status in ('P','O','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('2009/01/01') * 100) + MONTH('2009/01/01') OR clo_closed_year = 0) 
AND inclm_open_date BETWEEN '2009-01-01' AND '2009-12-31'
AND inagents.inag_agent_code LIKE '%%'
AND LEFT(inclm_claim_number , '2') LIKE '19%'
ORDER BY inagents.inag_agent_code ASC");

	while ($row = $sybase->fetch_assoc($sql)) {

		//echo $row["clo_stamps"];
		$payments += $row["clo_amount_paid"];
		$ekremis += $row["clo_estimated_reserve"] - $row["clo_amount_paid"];
		$windscreen += $row["clo_windscreen_paid"];
		$wind_reserve += $row["clo_windscreen_reserve"] - $row["clo_windscreen_paid"];
		$od_paid += $row["clo_OD_paid"];
		$pd_paid += $row["clo_PD_paid"];
		$bi_paid += $row["clo_BI_paid"];
		$od_reserve += $row["clo_OD_reserve"] - $row["clo_OD_paid"];
		$pd_reserve += $row["clo_PD_reserve"] - $row["clo_PD_paid"];
		$bi_reserve += $row["clo_BI_reserve"] - $row["clo_BI_paid"];
		$total_rows++;
		if ($row["clo_policy_cover"] == 'A') {
			$from_tp_paid += $row["clo_amount_paid"];
			$from_tp_reserve += $row["clo_estimated_reserve"] - $row["clo_amount_paid"];
		}//if policy cover is T/P
		if ($row["clo_policy_cover"] == 'B') {
			$from_ft_paid += $row["clo_amount_paid"];
			$from_ft_reserve += $row["clo_estimated_reserve"] - $row["clo_amount_paid"];
		}//if policy cover is T/P
		if ($row["clo_policy_cover"] == 'C') {
			$from_full_paid += $row["clo_amount_paid"];
			$from_full_reserve += $row["clo_estimated_reserve"] - $row["clo_amount_paid"];
		}//if policy cover is T/P
	}

echo "<strong>CLAIMS FOR MOTOR</strong><br>
 PAYMENTS ->".$payments."<br>
 EKREMIS ->".$ekremis."<br><br>
 Windscreen Paid->".$windscreen."<br>
 Windscreen Reserve->".$wind_reserve."<br><br>
 OD PAID ->".$od_paid."<br>
 OD Reserve ->".$od_reserve."<br>
 PD Paid ->".$pd_paid."<br>
 PD Reserve ->".$pd_reserve."<br>
 BI PAID ->".$bi_paid."<br>
 BI Reserve ->".$bi_reserve."<br><br>
 FROM T/P Policy Paid ->".$from_tp_paid."<br>
 FROM T/P Policy Reserve ->".$from_tp_reserve."<br>
 FROM F/T Policy Paid ->".$from_ft_paid."<br>
 FROM F/T Policy Reserve ->".$from_ft_reserve."<br>
 FROM Full Policy Paid ->".$from_full_paid."<br>
 FROM FULL Policy Reserve ->".$from_full_reserve."<br>";
echo "<hr><hr>";


?>

<?
$db->show_footer();
?>