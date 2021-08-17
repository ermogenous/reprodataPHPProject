<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 22/6/2021
 * Time: 10:09 π.μ.
 */

/*
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../lib/odbccon.php');

$db = new Main(0);
$db->admin_title = "Eurosure - Uploads - Send Report Claims";


$sybase = new ODBCCON();
*/

$db->update_log_file_custom('Starting process','Upload Extranet Report Claims');


$log = '';

$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('upload report claims',0,$log,'test');
    exit();
}

//find the last closed period in synthesis
$inParam = $sybase->query_fetch('select inpr_financial_year, inpr_financial_period from inpparam');
//if january change to 12 of previous year

if ($inParam['inpr_financial_period'] == 1){
    $year = $inParam['inpr_financial_year'] - 1;
    $period = 12;
}
else {
    $year = $inParam['inpr_financial_year'];
    $period = $inParam['inpr_financial_period'] - 1;
}

$asAtDate = date("Y-m-t",mktime(0,0,0,$period,1,$year));

//$year = date("Y");
//$period = date("m");
//$asAtDate = date("Y-m-d");
//$year = 2021;
//$period = 5;
//$asAtDate = '2021-05-31';

echo "<hr>Check if ".$period."/".$year." already exists on extranet -> <br>";
$extranetCheck = $extranet->query('
    SELECT COUNT(*)as clo_total FROM report_claims WHERE rpclm_year = '.$year.' AND rpclm_up_to_period = '.$period.'
');
$extranetCheck = mysqli_fetch_assoc($extranetCheck);
if ($extranetCheck['clo_total'] > 0){
    echo "Period already exists on extranet.";
}
else {
    echo "Period not found on extranet.<br>";
    echo "<hr>Send Report data for claims -> ";
    echo $period."/".$year." <br>As At:".$asAtDate;
    updateOnlineClaimsReport($year,$period,$asAtDate);
}


function updateOnlineClaimsReport($year,$uptoPeriod,$asAtDate)
{
    global $sybase, $extranet;
    $sql = "SELECT inclm_claim_number,   
         inpol_policy_number,   
         inpol_policy_serial,   
         inag_agent_code,
         inag_long_description,
         incl_long_description,   
         incl_first_name,   
         initm_item_code,   
         inclm_process_status,   
         inclm_date_of_event,   
         inclm_status,   
         inclm_open_date,   
         inag_agent_serial,   
         inclm_claim_serial,   
         DATE('".$asAtDate."') as clo_as_at_date, 
         inity_major_category as clo_sort1,   
         COALESCE((SELECT a.inag_group_code FROM inagents a WHERE a.inag_agent_serial = inpolicies.inpol_agent_serial),'') as clo_sort2,   
         space(060) as clo_sort3,   
         (Select a.incd_long_description From inpcodes a Where a.incd_record_type = '01' And a.incd_record_code = ininsurancetypes.inity_major_category ) as clo_desc1,   
         COALESCE((SELECT a.inag_long_description FROM inagents a WHERE a.inag_agent_serial = inpolicies.inpol_agent_serial),'') as clo_desc2,   
         space(180) as clo_desc3,   
         COALESCE((Select SUM(IF a.incvsdt_line_type = 'S' AND a.incvsdt_line_sub_type = 'C6' THEN a.incvsdt_debit_credit * a.incvsdt_value ELSE 0 ENDIF) 
          From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0) as clo_amount_paid_clm,   
         COALESCE((Select SUM(IF a.incvsdt_line_type = 'S' AND a.incvsdt_line_sub_type = 'C5' THEN a.incvsdt_debit_credit * a.incvsdt_value ELSE 0 ENDIF) 
          From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0) as clo_recoveries_recieved_clm,   
         COALESCE((Select SUM(IF a.incvsdt_line_type = 'S' AND a.incvsdt_line_sub_type = 'C6' AND a.incvsdt_reset_on_recovery = 'N' THEN a.incvsdt_debit_credit * a.incvsdt_value ELSE 0 ENDIF) 
          From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0) as clo_payments_recovery_exp_clm,   
         COALESCE((Select SUM(IF a.incvsdt_line_type = 'E' AND a.incvsdt_line_sub_type = 'C6' THEN a.incvsdt_debit_credit * a.incvsdt_value ELSE 0 ENDIF) 
          From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0) as clo_estimated_reserve_clm,   
         COALESCE((Select SUM(IF a.incvsdt_line_type = 'E' AND a.incvsdt_line_sub_type = 'C5' THEN a.incvsdt_debit_credit * a.incvsdt_value ELSE 0 ENDIF) 
          From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0) as clo_estimated_recoveries_clm,   
         COALESCE((Select SUM(IF a.incvsdt_line_type = 'E' AND a.incvsdt_line_sub_type = 'C6' AND a.incvsdt_reset_on_recovery = 'N' THEN a.incvsdt_debit_credit * a.incvsdt_value ELSE 0 ENDIF) 
          From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0) as clo_estimated_rec_expence_reserve_clm,   
         IF clo_process_status IN ('C', 'W') THEN 
            COALESCE((Select YEAR(MAX(a.incvsdt_operation_date)) 
             From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0)
         ELSE 0 ENDIF  AS clo_closed_year,   
         IF clo_process_status IN ('C', 'W') THEN 
            COALESCE((Select MONTH(MAX(a.incvsdt_operation_date)) 
             From inclaims_asat_date as a Where a.incvsdt_claim_serial = inclaims.inclm_claim_serial), 0)
         ELSE 0 ENDIF  AS clo_closed_period,   
         CASE WHEN inclm_process_status = 'I' THEN 'I' 
              WHEN clo_estimated_reserve_clm = 0 THEN IF COUNT(IF incvsdt_line_sub_type <> '' THEN 1 ELSE NULL ENDIF) = 0 THEN 'P' ELSE 'W' ENDIF 
              WHEN clo_estimated_reserve_clm - clo_amount_paid_clm = 0 AND clo_estimated_recoveries_clm - clo_recoveries_recieved_clm = 0 THEN 'C' 
              WHEN (clo_estimated_reserve_clm - clo_estimated_rec_expence_reserve_clm) - (clo_amount_paid_clm - clo_payments_recovery_exp_clm) = 0 AND clo_estimated_recoveries_clm - clo_recoveries_recieved_clm <> 0 THEN 'R' 
         ELSE 'O' END as clo_process_status,   
         (Select inpr_financial_year From inpparam Where UPPER(inpr_module_code) = 'IN') as clo_financial_year,   
         (Select inpr_financial_period From inpparam Where UPPER(inpr_module_code) = 'IN') as clo_financial_period,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_amount_paid,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_recieved,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_rec_expence_reserve,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_reserves,   
         DATE('".$year."/01/01') as clo_from_date,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_payments,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_recoveries,   
         YEAR(inclm_date_of_event) as clo_yoo,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_payments,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_recoveries,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_est_recoveries,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'I' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_initial_res_for_payments,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'R' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_reest_res_for_payments,   
         SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_est_recoveries_period,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_paid_as_at_date,   
         SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_as_at_date,   
         inclm_claim_date,   
         YEAR(inclm_claim_date) as clo_yor,   
         (incl_long_description + ' ' +  incl_first_name) as clo_insured,   
         incl_client_code,   
         incvsdt_reserve_code,   
         incl_identity_card,   
         (inclm_closed_period+inclm_closed_year) as clo_closed_date,   
         incd_long_description,   
         inclm_comments,   
         inpol_status,   
         inpol_process_status,   
         incd_short_description,   
         (Select COUNT() From inpolicies a Where a.inpol_policy_number = inpolicies.inpol_policy_number AND a.inpol_status='N') as clo_active_status,   
         (Select FIRST COALESCE(b.inped_process_status,'L') 
          From inpolicies a 
          LEFT OUTER JOIN inpolicyendorsement b 
              ON a.inpol_policy_serial = b.inped_policy_serial 
             AND a.inpol_last_cancellation_endorsement_serial = b.inped_endorsement_serial 
             AND b.inped_process_status in ('C','L') 
             AND b.inped_status = '1' 
          Where a.inpol_policy_number = inpolicies.inpol_policy_number AND a.inpol_status='A' 
          ORDER BY a.inpol_starting_date DESC, a.inpol_policy_serial DESC ) as clo_last_status,   
         inpol_period_starting_date,  
         inclaims_asat_date.incvsdt_fac_local_share,  
         inclaims_asat_date.incvsdt_fac_foreign_share,  
         inclaims_asat_date.incvsdt_quota_share + inclaims_asat_date.incvsdt_surplus_share as clo_prop_treaty_share,  
         SUM(ROUND(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0 
                   ELSE 0 ENDIF, 2)) as clo_amount_paid_ri,   
         SUM(ROUND(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0 
                   ELSE 0 ENDIF, 2)) as clo_estimated_reserve_ri,   
         SUM(ROUND(IF (incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6') AND 
                      (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0
                   ELSE 0 ENDIF, 2)) as clo_period_payments_ri,   
         SUM(ROUND(IF (incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5') AND 
                      (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0
                   ELSE 0 ENDIF, 2)) as clo_period_recoveries_ri,   
         SUM(ROUND(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND 
                      incvsdt_operation_date < clo_from_date THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0
                   ELSE 0 ENDIF, 2)) as clo_bf_reserves_ri,   
         SUM(ROUND(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND 
                      incvsdt_operation_date < clo_from_date THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0
                   ELSE 0 ENDIF, 2)) as clo_bf_payments_ri,   
         SUM(ROUND(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND 
                      incvsdt_operation_date < clo_from_date THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0
                   ELSE 0 ENDIF, 2)) as clo_bf_est_recoveries_ri,   
         SUM(ROUND(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND 
                      incvsdt_operation_date < clo_from_date THEN 
                      incvsdt_debit_credit * incvsdt_value * 
                      ((IF incvsdt_ldg_rsrv_under_reinsurance = 'N' THEN 0 ELSE incvsdt_quota_share + incvsdt_surplus_share + 
                       (IF incvsdt_ldg_rsrv_under_fac_foreign = 'N' THEN 0 ELSE incvsdt_fac_foreign_share ENDIF) + 
                        incvsdt_fac_local_share ENDIF)) / 100.0
                   ELSE 0 ENDIF, 2)) as clo_bf_recoveries_ri   
into #temp
    FROM inclaims 
          LEFT OUTER JOIN initems ON inclm_item_serial = initm_item_serial 
          LEFT OUTER JOIN inpcodes ON inclm_alpha_key1_serial = incd_pcode_serial,   
         inclients,   
         inpolicies,   
         inagents,   
         ingeneralagents,   
         ininsurancetypes,   
         inclaims_asat_date  
   WHERE ( inpol_client_serial = incl_client_serial ) and  
         ( inclm_policy_serial = inpol_policy_serial ) and  
         ( inpol_agent_serial = inag_agent_serial ) and  
         ( inga_agent_serial = inpol_general_agent_serial ) and  
         ( inity_insurance_type_serial = inpol_insurance_type_serial ) and  
         ( inclm_claim_serial = incvsdt_claim_serial ) and  
         ( ( inclm_open_date <= clo_as_at_date ) AND  
         ( inclm_process_status <> 'I') AND  
         ( inclm_status <> 'D') ) AND  
         incvsdt_operation_date <= clo_as_at_date AND  
         inity_major_category = 'MOTOR'   
 AND  1=1  
AND inclm_status in ('O','A','D') 
AND clo_sort1 >= 'MOTOR' 
AND clo_sort1 <= 'MOTOR' 
//AND clo_sort2 >= 'AE014' 
//AND clo_sort2 <= 'AE014' 
GROUP BY incl_long_description,   
         incl_first_name,   
         incl_identity_card,   
         inclm_date_of_event,   
         inclm_claim_number,   
         incvsdt_reserve_code,   
         inclm_claim_serial,   
         inpol_policy_number,   
         inag_agent_code,   
         inag_long_description,
         incl_client_code,   
         initm_item_code,   
         inclm_process_status,   
         inclm_status,   
         inclm_claim_date,   
         inclm_open_date,   
         inag_agent_serial,   
         inclm_closed_year,   
         inclm_closed_period,   
         incd_long_description,   
         incd_short_description,   
         inclm_comments,   
         inpol_status,   
         inpol_process_status,   
         inpol_period_starting_date,  
         inpolicies.inpol_policy_serial, 
         inpolicies.inpol_last_endorsement_serial, 
         inclaims_asat_date.incvsdt_policy_treaty, 
         inclaims_asat_date.incvsdt_fac_local_share, 
         inclaims_asat_date.incvsdt_fac_foreign_share, 
         clo_prop_treaty_share 
, clo_sort1, clo_desc1, clo_sort2, clo_desc2,inclm_claim_number 
HAVING  1=1  
AND clo_process_status in ('P','O','R') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$year."/01/01') * 100) + MONTH('".$year."/01/01') OR clo_closed_year = 0) 
ORDER BY clo_sort1 ASC, clo_sort2 ASC,incl_long_description ASC, 
incl_first_name ASC, incl_identity_card ASC, 
initm_item_code ASC, inclm_date_of_event ASC, 
inclm_claim_number ASC, incvsdt_reserve_code ASC,
inclm_claim_number ASC
;

SELECT
inclm_claim_number,
inpol_policy_number,
incl_long_description,   
incl_first_name,
IF clo_active_status =1 THEN 'Active' ELSE if clo_last_status='C' THEN 'Cancelled' ELSE'Lapsed' ENDIF ENDIF as clo_policy_status,
iF charindex('(',incl_client_code) = 0 THEN incl_client_code ELSE LEFT(incl_client_code, charindex('(',incl_client_code)-1) ENDIF as clo_client_code,
inag_agent_code,
inag_long_description,
YEAR(inpol_period_starting_date)as clo_underwriting_year,
clo_yor as clo_loss_year,
inclm_date_of_event,
initm_item_code,
incd_short_description as clo_cause,
incvsdt_reserve_code,
( clo_bf_reserves - clo_bf_payments) - (clo_bf_est_recoveries - clo_bf_recoveries)as clo_reserve_bf,
( clo_period_payments -  clo_period_recoveries)as clo_paid_amount,
clo_amount_paid as clo_paid_ytd,
(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)
    -(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date) as clo_reserve_cf,
clo_paid_amount + clo_reserve_cf - clo_reserve_bf as clo_claims_incurred,
IF inclm_status='A' THEN 'Closed ' + string(clo_closed_year) ELSE IF inclm_status='O' THEN 'Open' ELSE inclm_status ENDIF ENDIF as clo_claim_status

FROM
#temp
WHERE
1=1
// AND inag_agent_code = 'AE014'
ORDER BY
inag_agent_code,inclm_claim_number,inclm_date_of_event
    
    ";
 /*
    $result = $sybase->query($sql);
    while ($row = $sybase->fetch_assoc($result)){
        print_r($row);
        echo "<hr>";
    }
    exit();
*/
    //clear any records of the same period/year
    $sqlDelete = '
    DELETE FROM report_claims
    WHERE
    rpclm_year = '.$year.'
    AND rpclm_up_to_period = '.$uptoPeriod.';';
    $extranet->query($sqlDelete);

    $result = $sybase->query($sql);
    while ($row = $sybase->fetch_assoc($result)){
        $sql = '
        INSERT INTO report_claims SET
        rpclm_agent_code = "'.$row['inag_agent_code'].'",
        rpclm_agent_description = "'.$row['inag_long_description'].'",
        rpclm_year = "'.$year.'",
        rpclm_up_to_period = "'.$uptoPeriod.'",
        rpclm_client_name = "'.$row['incl_first_name'].' '.$row['incl_long_description'].'",
        rpclm_claim_number = "'.$row['inclm_claim_number'].'",
        rpclm_policy_number = "'.$row['inpol_policy_number'].'",
        rpclm_policy_status = "'.$row['clo_policy_status'].'",
        rpclm_client_code = "'.$row['clo_client_code'].'",
        rpclm_uw_year = "'.$row['clo_underwriting_year'].'",
        rpclm_loss_year = "'.$row['clo_loss_year'].'",
        rpclm_accident_date = "'.$row['inclm_date_of_event'].'",
        rpclm_registration = "'.$row['initm_item_code'].'",
        rpclm_cause = "'.$row['clo_cause'].'",
        rpclm_transaction_type = "'.$row['incvsdt_reserve_code'].'",
        rpclm_reserve_bf = "'.$row['clo_reserve_bf'].'",
        rpclm_amount_paid = "'.$row['clo_paid_amount'].'",
        rpclm_paid_ytd = "'.$row['clo_paid_ytd'].'",
        rpclm_reserve_cf = "'.$row['clo_reserve_cf'].'",
        rpclm_claims_incurred = "'.$row['clo_claims_incurred'].'",
        rpclm_claim_status = "'.$row['clo_claim_status'].'",
        rpclm_created_date_time = "'.date('Y-m-d G:i:s').'",
        rpclm_created_by = -1
        ;
        ';
        $extranet->query($sql) or die ($extranet->error."<br><hr>".$sql);
    }
}
