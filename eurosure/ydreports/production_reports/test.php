<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();

$db->show_header();


$sql = "

SELECT  
ininsurancetypes.inity_insurance_type ,           
ininsurancetypes.inity_long_description ,           
COALESCE((Select inpr_act_in_fire_theft From inpparam Where UPPER(inpr_module_code) = 'IN'), '') as clo_inpr_act_in_fire_theft,           
COALESCE((Select inpr_act_in_comprehensive From inpparam Where UPPER(inpr_module_code) = 'IN'), '') as clo_inpr_act_in_comprehensive,           
COALESCE(inpvsdt_as_at_date, Date(Now())) as clo_as_at_date,           
YEAR(clo_as_at_date) * 100 + MONTH(clo_as_at_date) As clo_as_at_period,           
inpolicies.inpol_policy_number ,           
inpolicies.inpol_policy_serial ,           
inpolicies_asat_date.inpvsdt_active_phase_pr ,           
-1 * COALESCE((SELECT SUM(b.inped_premium * b.inped_premium_debit_credit) FROM inpolicies a JOIN inpolicyendorsement b ON a.inpol_policy_serial = b.inped_policy_serial WHERE a.inpol_policy_number = inpolicies.inpol_policy_number AND a.inpol_period_starting_date = inpolicies.inpol_period_starting_date AND a.inpol_policy_serial < inpolicies.inpol_policy_serial AND b.inped_status = '1'), 0) as clo_earned_in_previous_phases,           
COUNT() as clo_vehicles_count,           
SUM(inpit_insured_amount) as clo_insured_amount,           
(SELECT -1 * SUM(inped_premium_debit_credit * (IF inldg_loading_type <> 'X' AND inlsc_ldg_rsrv_under_reinsurance <> 'Y' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as inpae_treaty_reinsured_premium FROM inpolicyloadings as plg JOIN inloadings as ldg ON inldg_loading_serial = inplg_loading_serial LEFT OUTER JOIN inloadingstatcodes as lsc on inldg_claim_reserve_group = inlsc_pcode_serial LEFT OUTER JOIN inpolicyendorsement as ped on inplg_policy_serial = inped_policy_serial WHERE inplg_policy_serial = inpolicies.inpol_policy_serial)as clo_treaty_reinsured_premium 
into #temppp
FROM ininsurancetypes 
LEFT OUTER JOIN inmajorcodes ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code 
LEFT OUTER JOIN inminorcodes ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,          
inagents ,          
ingeneralagents ,           
inpolicies_asat_date ,           
inpolicyitems    

WHERE ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and          ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( inpolicies_asat_date.inpvsdt_policy_serial = inpolicies.inpol_policy_serial ) 
and          ( inpolicyitems.inpit_policy_serial = inpolicies.inpol_policy_serial ) 
and          (inpvsdt_status = 'N' and          (  inpvsdt_year * 100 + inpvsdt_period <= clo_as_at_period) ) 
and          ( ininsurancetypes.inity_insurance_form = 'M' )  
AND  1=1  

GROUP BY inpolicies_asat_date.inpvsdt_as_at_date ,
ininsurancetypes.inity_insurance_type ,
ininsurancetypes.inity_long_description ,
ininsurancetypes.inity_insurance_type_serial ,
inpolicies.inpol_policy_serial ,           
inpolicies.inpol_policy_number ,           
inpolicies.inpol_period_starting_date ,           
inpolicies_asat_date.inpvsdt_active_phase_pr  

HAVING  1=1  

ORDER BY inpolicies.inpol_policy_number ASC;


SELECT
COUNT()
FROM #temppp

";
$sybase->query("INSERT INTO ccuserparameters (ccusp_user_date,ccusp_user_identity)VALUES('2010-12-31' ,'ERMOGEN')");
$result = $sybase->query_fetch($sql);
print_r($result);





$db->show_footer();
?>