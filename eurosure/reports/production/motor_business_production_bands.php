<?php

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

ini_set('memory_limit','2048M');
ini_set('max_execution_time', 120);

include("../../../include/main.php");
$db = new Main();
include("../../lib/odbccon.php");
include("../../lib/production.php");

include("../../lib/production_class.php");
include("../../lib/export_data.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
$sybase = new ODBCCON();

if ($_POST['action'] == 'execute'){

    $sql = "
        
          SELECT 
  (CASE 
      WHEN dt_vehicle_insured_amount = 0 then '000.000' 
      WHEN dt_vehicle_insured_amount <= 1000 THEN '000.001 - 001.000'
      WHEN dt_vehicle_insured_amount <= 2000 THEN '001.001 - 002.000'
      WHEN dt_vehicle_insured_amount <= 3000 THEN '002.001 - 003.000'
      WHEN dt_vehicle_insured_amount <= 4000 THEN '003.001 - 004.000'
      WHEN dt_vehicle_insured_amount <= 5000 THEN '004.001 - 005.000'
      WHEN dt_vehicle_insured_amount <= 6000 THEN '005.001 - 006.000'
      WHEN dt_vehicle_insured_amount <= 7000 THEN '006.001 - 007.000'
      WHEN dt_vehicle_insured_amount <= 8000 THEN '007.001 - 008.000'
      WHEN dt_vehicle_insured_amount <= 9000 THEN '008.001 - 009.000'
      WHEN dt_vehicle_insured_amount <= 10000 THEN '009.001 - 010.000'
      WHEN dt_vehicle_insured_amount <= 15000 THEN '010.001 - 015.000'
      WHEN dt_vehicle_insured_amount <= 20000 THEN '015.001 - 020.000'
      WHEN dt_vehicle_insured_amount <= 25000 THEN '020.001 - 025.000'
      WHEN dt_vehicle_insured_amount <= 30000 THEN '025.001 - 030.000'
      WHEN dt_vehicle_insured_amount <= 35000 THEN '030.001 - 035.000'
      WHEN dt_vehicle_insured_amount <= 40000 THEN '035.001 - 040.000'
      WHEN dt_vehicle_insured_amount <= 45000 THEN '040.001 - 045.000'
      WHEN dt_vehicle_insured_amount <= 50000 THEN '045.001 - 050.000'
      WHEN dt_vehicle_insured_amount <= 55000 THEN '050.001 - 055.000'
      WHEN dt_vehicle_insured_amount <= 60000 THEN '055.001 - 060.000'
      WHEN dt_vehicle_insured_amount <= 65000 THEN '060.001 - 065.000'
      WHEN dt_vehicle_insured_amount <= 70000 THEN '065.001 - 070.000'
      WHEN dt_vehicle_insured_amount <= 75000 THEN '070.001 - 075.000'
      WHEN dt_vehicle_insured_amount <= 80000 THEN '075.001 - 080.000'
      WHEN dt_vehicle_insured_amount <= 85000 THEN '080.001 - 085.000'
      WHEN dt_vehicle_insured_amount <= 90000 THEN '085.001 - 090.000'
      WHEN dt_vehicle_insured_amount <= 95000 THEN '090.001 - 095.000'
      WHEN dt_vehicle_insured_amount <= 100000 THEN '095.001 - 100.000'
      WHEN dt_vehicle_insured_amount <= 125000 THEN '100.001 - 125.000'
      WHEN dt_vehicle_insured_amount <= 150000 THEN '125.001 - 150.000'
      WHEN dt_vehicle_insured_amount <= 200000 THEN '150.001 - 200.000'
      WHEN dt_vehicle_insured_amount <= 3000000 THEN '200.001 - 300.000'
      WHEN dt_vehicle_insured_amount <= 4000000 THEN '300.001 - 400.000'
      ELSE 'Over 400.000' END) as clo_band,
    
  'PREMIUMS' as PREMIUMS,           
  SUM(dt_x_premium) As clo_x_premium,                 
  SUM(dt_period_premium) As clo_period_premium,         
  SUM(dt_period_premium_tp) As clo_period_premium_tp, 
  SUM(dt_period_premium_od) As clo_period_premium_od,   
  SUM(dt_period_treaty_reinsurable_premium) clo_period_treaty_reinsurable_premium, 

  COUNT(DISTINCT(IF dt_record_type = 'P' AND inped_process_status <> 'C' THEN inpol_policy_number ELSE NULL ENDIF))as clo_no_of_policies,
  COUNT(DISTINCT(IF dt_record_type = 'P' AND inped_process_status NOT IN ('C') THEN  dt_registration_number ELSE NULL ENDIF)) as clo_no_vehicles_,

  SUM(CASE WHEN dt_record_type = 'C' THEN 1 ELSE 0 END) as clo_no_of_claims, 
  'CLAIMS' as CLAIMS,           
  SUM(dt_amount_paid_in_prd) as clo_amount_paid_in_prd, 
  SUM(dt_os_reserve_cf) as clo_os_reserve_cf, 
  SUM(dt_incurred_in_prd) as clo_incurred_in_prd,

  SUM(dt_amount_paid_in_prd_od) as clo_amount_paid_in_prd_od, 
  SUM(dt_os_reserve_cf_od) as clo_os_reserve_cf_od, 
  SUM(dt_incurred_in_prd_od) as clo_incurred_in_prd_od,

  SUM(dt_amount_paid_in_prd_tp) as clo_amount_paid_in_prd_tp, 
  SUM(dt_os_reserve_cf_tp) as clo_os_reserve_cf_tp, 
  SUM(dt_incurred_in_prd_tp) as clo_incurred_in_prd_tp
 FROM inpolicies 
 JOIN (
   (Select 'P' as dt_record_type, 
    inpol_policy_serial as dt_policy_serial, 
    initm_item_code as dt_registration_number, 
    MAX(IF inped_premium_debit_credit = -1 OR inped_process_status = 'C' OR 
                (SELECT COUNT() FROM inpolicyitems pit 
                 WHERE pit.inpit_policy_serial = inped_financial_policy_abs 
                 AND pit.inpit_item_serial = inpolicyitems.inpit_item_serial) = 0 THEN inpit_insured_amount ELSE 0 ENDIF) as dt_vehicle_insured_amount,  
    0 as dt_claim_serial, 
    inped_year, inped_period, 
    inped_process_status,'".$_POST['fld_from_year']."' as xclo_from_year,'".$_POST['fld_from_period']."' as xclo_from_period,
    '".$_POST['fld_to_year']."' as xclo_upto_year,'".$_POST['fld_to_period']."' as xclo_upto_period, 
    SUM(IF inldg_loading_type = 'X' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE -1 * inplg_return_premium ENDIF ELSE 0 ENDIF) As dt_x_premium,           
    SUM(IF inldg_loading_type = 'X' THEN 0 ELSE IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE -1 * inplg_return_premium ENDIF ENDIF) As dt_period_premium,      
    SUM(IF inldg_loading_type = 'A' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE -1 * inplg_return_premium ENDIF ELSE 0 ENDIF) As dt_period_premium_tp, 
    SUM(IF inldg_loading_type IN ('A', 'X') THEN 0 ELSE IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE -1 * inplg_return_premium ENDIF ENDIF) As dt_period_premium_od,      
    SUM(IF inldg_loading_type = 'X' OR COALESCE(inlsc_ldg_rsrv_under_reinsurance,'Y') <> 'Y' THEN 0 
             ELSE IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE -1 * inplg_return_premium ENDIF ENDIF) As dt_period_treaty_reinsurable_premium, 
    DATE(DATEADD(DAY, -1, DATEADD(MONTH,1, DATE(STRING(xclo_upto_year,'/',xclo_upto_period,'/01'))))) as clo_as_at_date, 
    DATE(STRING(xclo_from_year,'/',xclo_from_period,'/01')) as clo_from_date, 
    0 as clo_amount_paid, 
    0 as clo_recoveries_recieved, 
    0 as clo_payments_recovery_exp, 
    0 as clo_estimated_reserve, 
    0 as clo_estimated_recoveries, 
    0 as clo_estimated_rec_expence_reserve, 
    0 as clo_amount_paid_od, 
    0 as clo_recoveries_recieved_od, 
    0 as clo_payments_recovery_exp_od, 
    0 as clo_estimated_reserve_od, 
    0 as clo_estimated_recoveries_od, 
    0 as clo_estimated_rec_expence_reserve_od, 
    0 as clo_amount_paid_tp, 
    0 as clo_recoveries_recieved_tp, 
    0 as clo_payments_recovery_exp_tp, 
    0 as clo_estimated_reserve_tp, 
    0 as clo_estimated_recoveries_tp, 
    0 as clo_estimated_rec_expence_reserve_tp, 
    '' as dt_process_status, 
    0 as clo_closed_year, 
    0 as clo_closed_period, 
    0 as dt_bf_reserves, 
    0 as dt_amount_paid_in_prd, 
    0 as dt_os_reserve_cf, 
    0 as dt_bf_reserves_od, 
    0 as dt_amount_paid_in_prd_od, 
    0 as dt_os_reserve_cf_od, 
    0 as dt_bf_reserves_tp, 
    0 as dt_amount_paid_in_prd_tp, 
    0 as dt_os_reserve_cf_tp, 
    0 as dt_incurred_in_prd,
    0 as dt_incurred_in_prd_od,
    0 as dt_incurred_in_prd_tp
  From inpolicies 
  JOIN inpolicyendorsement ON inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs 
  JOIN inpolicyitems  ON inpolicyitems .inpit_policy_serial =  inpolicyendorsement.inped_policy_serial 
  JOIN initems ON initems.initm_item_serial= inpolicyitems.inpit_item_serial
  JOIN inpolicyloadings ON inpolicyitems .inpit_pit_auto_serial = inpolicyloadings.inplg_pit_auto_serial 
  JOIN inloadings ON inplg_loading_serial = inldg_loading_serial 
  LEFT OUTER JOIN inloadingstatcodes ON inldg_claim_reserve_group = inlsc_pcode_serial 
  Where inped_status = '1' AND inped_process_status <> 'L' 
  AND (inped_year*100+inped_period) >= (xclo_from_year*100+xclo_from_period) 
  AND (inped_year*100+inped_period) <= (xclo_upto_year*100+xclo_upto_period) 
  Group By inpol_policy_serial, dt_registration_number, inped_year, inped_period, inped_process_status) 

  UNION ALL 

  (Select 'C' as dt_record_type, 
    inclm_policy_serial as dt_policy_serial, 
    initm_item_code as dt_registration_number, 
    inpit_insured_amount as dt_vehicle_insured_amount, 
    inclm_claim_serial as dt_claim_serial, 
    xclo_from_year as inped_year, xclo_upto_period as inped_period, 
    '' as inped_process_status,'".$_POST['fld_from_year']."' as xclo_from_year,'".$_POST['fld_from_period']."' as xclo_from_period,
    '".$_POST['fld_to_year']."' as xclo_upto_year,'".$_POST['fld_to_period']."' as xclo_upto_period, 
    0 as dt_x_premium,           
    0 as dt_period_premium,   
    0 as dt_period_premium_tp,   
    0 as dt_period_premium_od,   
    0 as dt_period_treaty_reinsurable_premium, 
    DATE(DATEADD(DAY, -1, DATEADD(MONTH,1, DATE(STRING(xclo_upto_year,'/',xclo_upto_period,'/01'))))) as clo_as_at_date, 
    DATE(STRING(xclo_from_year,'/',xclo_from_period,'/01')) as clo_from_date,  
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_amount_paid,   
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_recieved,   
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6'  AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_rec_expence_reserve,   

    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type = 'OD' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_amount_paid_od,   
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_reserve_sub_type = 'OD' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_recieved_od,   
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type = 'OD' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp_od,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type = 'OD' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve_od,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_reserve_sub_type = 'OD' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries_od,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type = 'OD' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_rec_expence_reserve_od,   

    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type IN ('PD','BI') THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_amount_paid_tp,   
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_reserve_sub_type IN ('PD','BI') THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_recieved_tp,   
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type IN ('PD','BI') AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp_tp,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type IN ('PD','BI') THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve_tp,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_reserve_sub_type IN ('PD','BI') THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries_tp,   
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reserve_sub_type IN ('PD','BI') AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_rec_expence_reserve_tp,   
  
  CASE 
        WHEN inclm_process_status = 'I' THEN 'I' 
        WHEN clo_estimated_reserve = 0 THEN IF COUNT(IF incvsdt_line_sub_type <> '' THEN 1 ELSE NULL ENDIF) = 0 THEN 'P' ELSE 'W' ENDIF 
        WHEN clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved = 0 THEN 'C' 
        WHEN (clo_estimated_reserve - clo_estimated_rec_expence_reserve) - (clo_amount_paid - clo_payments_recovery_exp) = 0 AND clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' 
        ELSE 'O' END as dt_process_status,           
    IF dt_process_status IN ('C', 'W') THEN YEAR(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_year,           
    IF dt_process_status IN ('C', 'W') THEN MONTH(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_period,    
       
    SUM(IF incvsdt_line_type = 'E' AND incvsdt_operation_date < clo_from_date THEN IF incvsdt_line_sub_type = 'C6'  THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) - 
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_operation_date < clo_from_date THEN IF incvsdt_line_sub_type = 'C6'  THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as dt_bf_reserves, 
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_operation_date >= clo_from_date THEN IF incvsdt_line_sub_type = 'C6'  THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as dt_amount_paid_in_prd,   
    (clo_estimated_reserve - clo_estimated_recoveries) - (clo_amount_paid - clo_recoveries_recieved) as dt_os_reserve_cf, 

    SUM(IF incvsdt_line_type = 'E' AND incvsdt_reserve_sub_type IN ('OD') AND incvsdt_operation_date < clo_from_date THEN IF incvsdt_line_sub_type = 'C6' THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) - 
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_reserve_sub_type IN ('OD') AND incvsdt_operation_date < clo_from_date THEN IF incvsdt_line_sub_type = 'C6' THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as dt_bf_reserves_od, 
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_reserve_sub_type IN ('OD') AND incvsdt_operation_date >= clo_from_date THEN IF incvsdt_line_sub_type = 'C6' THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as dt_amount_paid_in_prd_od,   
    (clo_estimated_reserve_od - clo_estimated_recoveries_od) - (clo_amount_paid_od - clo_recoveries_recieved_od) as dt_os_reserve_cf_od, 

    SUM(IF incvsdt_line_type = 'E' AND incvsdt_reserve_sub_type IN ('PD','BI') AND incvsdt_operation_date < clo_from_date THEN IF incvsdt_line_sub_type = 'C6' THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) - 
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_reserve_sub_type IN ('PD','BI') AND incvsdt_operation_date < clo_from_date THEN IF incvsdt_line_sub_type = 'C6' THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as dt_bf_reserves_tp, 
    SUM(IF incvsdt_line_type = 'S' AND incvsdt_reserve_sub_type IN ('PD','BI') AND incvsdt_operation_date >= clo_from_date THEN IF incvsdt_line_sub_type = 'C6' THEN 1 ELSE -1 ENDIF * incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as dt_amount_paid_in_prd_tp,   
    (clo_estimated_reserve_tp - clo_estimated_recoveries_tp) - (clo_amount_paid_tp - clo_recoveries_recieved_tp) as dt_os_reserve_cf_tp, 

    dt_amount_paid_in_prd + dt_os_reserve_cf - dt_bf_reserves as dt_incurred_in_prd,
    dt_amount_paid_in_prd_od + dt_os_reserve_cf_od - dt_bf_reserves_od as dt_incurred_in_prd_od ,
    dt_amount_paid_in_prd_tp + dt_os_reserve_cf_tp - dt_bf_reserves_tp as dt_incurred_in_prd_tp
  From  inclaims_asat_date 
  JOIN inclaims ON  inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial 
  LEFT OUTER JOIN inpolicyitems  ON inpolicyitems .inpit_pit_auto_serial =  inclaims.inclm_pit_auto_serial 
  LEFT OUTER JOIN initems ON initems.initm_item_serial= inpolicyitems.inpit_item_serial
  Where  incvsdt_operation_date <= clo_as_at_date 
  Group By dt_policy_serial, dt_claim_serial, inclm_process_status, dt_registration_number, dt_vehicle_insured_amount 
  Having dt_process_status in ('O','R','C') 
  AND (((clo_closed_year * 100) + clo_closed_period >= (xclo_from_year * 100) + xclo_from_period) OR (clo_closed_year = 0))) 
  ) AS DT_PREPROCES ON inpolicies.inpol_policy_serial = DT_PREPROCES.dt_policy_serial 
  JOIN ininsurancetypes ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial 
  LEFT OUTER JOIN inmajorcodes ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code  
  LEFT OUTER JOIN inminorcodes ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code           
  JOIN inagents ON inpolicies.inpol_agent_serial = inagents.inag_agent_serial 
  JOIN ingeneralagents ON ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial 
  WHERE inity_major_category = 'MOTOR' 
  /*AND inpol_policy_number = 'MVA020884' */ 
  AND  1=1  AND (((inped_year*100+inped_period) >= (".$_POST['fld_from_year']."*100+".$_POST['fld_from_period'].") 
  AND (inped_year*100+inped_period) <= (".$_POST['fld_to_year']."*100+".$_POST['fld_to_period']."))) GROUP BY clo_band
  HAVING  1=1  
  AND  1=1  ORDER BY clo_band
  ";

    if ($_POST['fld_export_type'] == 'Delimited') {
        export_data_delimited($sql, 'sybase', '#', "'", 'download');
        exit();
    }
    else if ($_POST['fld_export_type'] == 'Excel'){

        $spreadsheet = new Spreadsheet();
// Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Eurosure')
            ->setLastModifiedBy('Eurosure')
            ->setTitle('Eurosure - Motor Business Production Bands')
            ->setSubject('Eurosure - Motor Business Production Bands')
            ->setDescription('Eurosure - Motor Business Production Bands - Intranet/Reports/Production/Motor Business Production Bands')
            ->setKeywords('Eurosure - Motor Business Production Bands')
            ->setCategory('Eurosure - Motor Business Production Bands');

        // add first line header data
        $str = 'A';
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue($str . '1', 'Band')
            ->setCellValue(++$str . '1', 'No Of Policies')
            ->setCellValue(++$str . '1', 'No Of Vehicles')
            ->setCellValue(++$str . '1', 'Gross Written Premium')
            ->setCellValue(++$str . '1', 'GWP TP')
            ->setCellValue(++$str . '1', 'GWP OD')
            ->setCellValue(++$str . '1', '   ')
            ->setCellValue(++$str . '1', 'No Of Claims')
            ->setCellValue(++$str . '1', 'Claims Paid Total')
            ->setCellValue(++$str . '1', 'Claims Paid TP')
            ->setCellValue(++$str . '1', 'Claims Paid OD')
            ->setCellValue(++$str . '1', 'Claim Reserve CF Total')
            ->setCellValue(++$str . '1', 'Claim Reserve CF TP')
            ->setCellValue(++$str . '1', 'Claim Reserve CF OD');
        //make all align of the row LEFT
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //make all row Bold
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . '1')->getFont()->setBold(true);

        $line = 1;
        $result = $sybase->query($sql);
        while ($row = $sybase->fetch_assoc($result)) {
            $str = 'A';
            $line++;
            $spreadsheet->getActiveSheet()
                ->setCellValue($str . $line, $row['clo_band'])
                ->setCellValue(++$str . $line, $row['clo_no_of_policies'])
                ->setCellValue(++$str . $line, $row['clo_no_vehicles_'])
                ->setCellValue(++$str . $line, $row['clo_period_premium'])
                ->setCellValue(++$str . $line, $row['clo_period_premium_tp'])
                ->setCellValue(++$str . $line, $row['clo_period_premium_od'])
                ->setCellValue(++$str . $line, '   ')
                ->setCellValue(++$str . $line, $row['clo_no_of_claims'])
                ->setCellValue(++$str . $line, $row['clo_amount_paid_in_prd'])
                ->setCellValue(++$str . $line, $row['clo_amount_paid_in_prd_tp'])
                ->setCellValue(++$str . $line, $row['clo_amount_paid_in_prd_od'])
                ->setCellValue(++$str . $line, $row['clo_os_reserve_cf'])
                ->setCellValue(++$str . $line, $row['clo_os_reserve_cf_tp'])
                ->setCellValue(++$str . $line, $row['clo_os_reserve_cf_od']);

            $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . $line)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        }

        $str = 'A';
        $stop = false;
        while ($stop == false) {
            //set columns to autosize the width
            $spreadsheet->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);

            ++$str;
            if ($str == 'Z') {
                $stop = true;
            }
        }
        $filename = $_POST['fld_from_period']." ".$_POST['fld_from_year']."-".$_POST['fld_to_period']." ".$_POST['fld_to_year'];
        $spreadsheet->getActiveSheet()
            ->setTitle('Motor Bands '.$filename);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xls');
        //$writer->save('output.xls');
        //$file = file_get_contents('output.xls');



        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="motor_bands_'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');

    }

}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1 d-none d-md-block"></div>
        <div class="col-12 col-md-10">
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>Reports - Production - Motor Business Production Bands</b></div>
                </div>
                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_from_period')
                        ->setFieldDescription('From Period')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_from_period'])
                        ->buildLabel();
                    ?>
                    <div class="col-2">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'integer',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_from_year')
                        ->setFieldDescription('From Year')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_from_year'])
                        ->buildLabel();
                    ?>
                    <div class="col-2">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'integer',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_to_period')
                        ->setFieldDescription('To Period')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_to_period'])
                        ->buildLabel();
                    ?>
                    <div class="col-2">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'integer',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_to_year')
                        ->setFieldDescription('To Year')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_to_year'])
                        ->buildLabel();
                    ?>
                    <div class="col-2">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'integer',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_export_type')
                        ->setFieldDescription('Export Type')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputSelectAddEmptyOption(true)
                        ->setInputSelectArrayOptions([
                                'Delimited'=>'Delimited - Problem with thousand separator',
                                'Excel'=>'Excel'
                        ])
                        ->buildLabel();
                    ?>
                    <div class="col-2">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                </div>

                <div class="form-group row">
                    <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action" value="execute">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('index.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="Submit Form"
                               class="btn btn-primary">
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>

<?php
$formValidator->output();
$db->show_footer();
?>
