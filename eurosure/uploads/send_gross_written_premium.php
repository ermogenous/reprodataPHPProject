<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 13/5/2021
 * Time: 5:34 μ.μ.
 */


/*
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../lib/odbccon.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Uploads - Gross Written Premium";


$sybase = new ODBCCON();
*/
$db->update_log_file_custom('Starting process','Upload Extranet gross written premium');
//connect to extranet
$log = '';
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('upload gross written premium',0,$log,'test');
    exit();
}

$year = date("Y");
$period = date("m");
$asAtDate = date("Y-m-d");
echo $year."/".$period."/".$asAtDate;
$result = updateOnline($year,$period,$asAtDate);
//also update the previous period
$period = $period-1;
if ($period == 0){
    $year = $year -1;
    $period = 12;
}
$asAtDate = date("Y-m-d");
echo "<br>".$year."/".$period."/".$asAtDate;//exit();
$result = updateOnline($year,$period,$asAtDate);






function updateOnline($year,$period,$asAtDate){
    global $sybase,$extranet;
    $sql = "

  SELECT 

		ccmaddrs.ccad_addr_type,   
         ccmaddrs.ccad_addr_code,   
         ccmaddrs.ccad_long_desc,   
         ccmaddrs.ccad_acct_crcy,   
         ccmaddrs.ccad_anls_cod1,   
         ccmaddrs.ccad_anls_cod2,   
         ccmaddrs.ccad_anls_cod3,   
         ccmaddrs.ccad_cntc_name,   
         ccmaddrs.ccad_acct_serl,  
         ccmaddrs.ccad_addr_serl,
         ccmaddrs.ccad_acct_stat,   
         ccmaddrs.ccad_shrt_desc,   
         ccmaddrs.ccad_anls_cod4,   
    
         ccmaccts.ccac_alte_acct,   
         ccmaccts.ccac_acct_stat,   
         ccmaccts.ccac_anls_cod1,   
         ccmaccts.ccac_anls_cod2,   
         ccmaccts.ccac_acct_code,   

         ccpcrncy.cccu_crcy_rate,   
         ccpdecod.ccde_status_flag,
         
         space(500) as clo_comp_logo,   
         space(180) as clo_desc1,   
         space(180) as clo_desc2,   
         space(180) as clo_desc3,   
         space(060) as clo_sort1,   
         space(060) as clo_sort2,   
         space(060) as clo_sort3,   
         
         0.010*0 as clo_account_currency_balance1,   
         0.011*0 as clo_main_currency_balance1,  

1*COALESCE ((SELECT (acbl_year_bfrw + (acbl_drmv_prd01 - acbl_crmv_prd01) + (acbl_drmv_prd02 - acbl_crmv_prd02) + (acbl_drmv_prd03 - acbl_crmv_prd03) + (acbl_drmv_prd04 - acbl_crmv_prd04) + (acbl_drmv_prd05 - acbl_crmv_prd05) + (acbl_drmv_prd06 - acbl_crmv_prd06) + (acbl_drmv_prd07 - acbl_crmv_prd07) + (acbl_drmv_prd08 - acbl_crmv_prd08)) FROM acmblnce  
WHERE acbl_acct_serl = ccad_acct_serl AND acbl_fncl_year =2012 AND ccad_acct_crcy = acbl_crcy_code),0)+1*(COALESCE((SELECT  SUM(actln_drmv_crmv*actln_acct_amnt) FROM acmtline WHERE actln_acct_serl=ccad_acct_serl AND actln_docu_type='1'  AND actln_docu_stat='2' AND (actln_docu_year*100 + actln_docu_perd <=2012*100 +8)), 0)) as clo_account_currency_balance,

1*COALESCE ((SELECT (acbl_year_bfrw + (acbl_drmv_prd01 - acbl_crmv_prd01) + (acbl_drmv_prd02 - acbl_crmv_prd02) + (acbl_drmv_prd03 - acbl_crmv_prd03) + (acbl_drmv_prd04 - acbl_crmv_prd04) + (acbl_drmv_prd05 - acbl_crmv_prd05) + (acbl_drmv_prd06 - acbl_crmv_prd06) + (acbl_drmv_prd07 - acbl_crmv_prd07) + (acbl_drmv_prd08 - acbl_crmv_prd08)) FROM acmblnce  
WHERE acbl_acct_serl = ccad_acct_serl AND acbl_fncl_year =2012 AND acbl_crcy_code ='EUR'),0)+1*(COALESCE((SELECT  SUM(actln_drmv_crmv*actln_main_amnt) FROM acmtline WHERE actln_acct_serl=ccad_acct_serl AND actln_docu_type='1'  AND actln_docu_stat='2'  AND (actln_docu_year*100 + actln_docu_perd <=2012*100 +8)), 0)) as clo_main_currency_balance,
'' as xclo_acgroup2,
'' as xclo_acgroup2_to,
'' as xclo_account_from,
'' as xclo_account_to,
'".$year."' as xclo_upto_year,
'".$period."' as xclo_from_period,
'".$period."' as xclo_upto_period,
'?' as xclo_from_date,
'?' as xclo_upto_date,
'Y' as xclo_os_documents,
'N' as xclo_summary_lines,
'".$asAtDate."' as xclo_as_at_date,   
         (xclo_upto_year-1) as clo_prev_year,   
         (xclo_upto_year*100+xclo_upto_period) as clo_curr_prd,   
         ((xclo_upto_year-1)*100+xclo_upto_period) as clo_prev_prd,   
         (xclo_upto_year-2) as clo_prev_prd_bf,   
         (day(xclo_as_at_date)) as clo_day,   
         (month(xclo_as_at_date)) as clo_month,

         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y'))),0) as clo_premium_written,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y'))),0) as clo_premium_written_p,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-2 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y'))),0) as clo_premium_written_p2,   
         (clo_premium_written-clo_premium_written_p) as clo_premium_written_diff,
        

         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y'))),0) as clo_premium_written_pb,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-2 AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y'))),0) as clo_premium_written_pb2,   
        (/*clo_premium_written+*/clo_premium_written_pb+clo_premium_written_pb2) as clo_premium_written_bal,

         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_nmt,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_nmt_p,   
         (clo_premium_written_nmt-clo_premium_written_nmt_p) as clo_premium_written_nmt_diff,
       
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'A' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_motor,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'A' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_motor_p, 
         (clo_premium_written_motor-clo_premium_written_motor_p) as clo_premium_written_motor_diff,

         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'B' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_liab,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'B' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_liab_p,   
         (clo_premium_written_liab-clo_premium_written_liab_p) as clo_premium_written_liab_diff,       

         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'C' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_fire,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'C' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_fire_p,  
         (clo_premium_written_fire-clo_premium_written_fire_p) as clo_premium_written_fire_diff, 
       
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'D' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_eng,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'D' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_eng_p,  
         (clo_premium_written_eng-clo_premium_written_eng_p) as clo_premium_written_eng_diff, 
       
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'E' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_misc,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'E' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_misc_p,  
         (clo_premium_written_misc-clo_premium_written_misc_p) as clo_premium_written_misc_diff, 
       
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'F' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_marine,   
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_typ3 = 'L3' AND LEFT(actln_anls_cod3,1) = 'F' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd >=xclo_from_period AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_marine_p,  
         (clo_premium_written_marine-clo_premium_written_marine_p) as clo_premium_written_marine_diff, 

         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-1 AND actln_docu_perd <= 12 AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_nmt_bf,  
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_anls_typ4 = 'L4' AND actln_anls_cod4 = ccac_alte_acct AND actln_docu_year = xclo_upto_year-2 AND actln_docu_perd <= 12 AND actln_acct_code = '411001' AND actln_docu_type = '1' AND (actln_docu_stat = '1' OR (actln_docu_stat = '2' AND xclo_os_documents = 'Y')) AND actln_docu_code NOT IN ('IP','DNAZ','CRAZ')),0) as clo_premium_written_nmt_bf_p,   
       
       
         /*IF LEFT(ccac_anls_cod1,2) IN ('AE','AG') THEN  ccad_anls_cod3  ELSE IF LEFT(ccac_anls_cod1,3)='COR' THEN 'SA000' ELSE IF LEFT(ccac_anls_cod1,7) IN ('DIR-NIC','DIR-OTH') THEN 'D0000' ELSE IF LEFT(ccac_anls_cod1,7)='DIR-LIM' THEN 'DA000' ELSE IF LEFT(ccac_anls_cod1,8)='SHAREHOL' THEN 'SH000' ELSE IF LEFT(ccac_anls_cod1,2)='RF' THEN 'RF000' ELSE 'ZZ999' ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF as clo_group1,   
         IF LEFT(ccac_anls_cod1,2) IN ('AE','AG') THEN  ccde_long_desc/*ccad_shrt_desc*/  ELSE IF LEFT(ccac_anls_cod1,3)='COR' THEN 'TOTAL CORPORATE' ELSE IF LEFT(ccac_anls_cod1,7) IN ('DIR-NIC','DIR-OTH') THEN 'TOTAL DIRECT NICOSIA' ELSE IF LEFT(ccac_anls_cod1,7)='DIR-LIM' THEN 'TOTAL DIRECT LIMASSOL' ELSE IF LEFT(ccac_anls_cod1,8)='SHAREHOL' THEN 'TOTAL SHAREHOLDERS' ELSE IF LEFT(ccac_anls_cod1,2)='RF' THEN 'TOTAL FOREIGN R/I' ELSE 'TOTAL UNKNOWN' ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF as clo_group_desc,   */

        COALESCE( IF LEFT(ccac_anls_cod1,2) IN ('AE','AG') THEN  ccde_anal_code/*ccac_anls_cod1*/  ELSE IF LEFT(ccac_anls_cod1,3)='COR' THEN 'SA000' ELSE IF LEFT(ccac_anls_cod1,7) IN ('DIR-NIC','DIR-OTH','DIR-LIM') THEN 'D0000' ELSE IF LEFT(ccac_anls_cod1,7)='DIR-LMM' THEN 'DA000' ELSE IF LEFT(ccac_anls_cod1,8)='SHAREHOL' THEN 'SH000' ELSE IF LEFT(ccac_anls_cod1,2)='RF' THEN 'RF000' ELSE 'ZZ999' ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF,'????') as clo_group1,   
        COALESCE(  IF LEFT(ccac_anls_cod1,2) IN ('AE','AG') THEN  ccde_long_desc/*ccad_shrt_desc*/  ELSE IF LEFT(ccac_anls_cod1,3)='COR' THEN 'CORPORATE' ELSE IF LEFT(ccac_anls_cod1,7) IN ('DIR-NIC','DIR-OTH','DIR-LIM') THEN 'DIRECT' ELSE IF LEFT(ccac_anls_cod1,7)='DIR-LMM' THEN 'DIRECT LIMASSOL' ELSE IF LEFT(ccac_anls_cod1,8)='SHAREHOL' THEN 'SHAREHOLDERS' ELSE IF LEFT(ccac_anls_cod1,2)='RF' THEN 'FOREIGN R/I' ELSE 'UNKNOWN' ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF,'????') as clo_group_desc,   
        
          
         COALESCE((SELECT SUM(actln_drmv_crmv * actln_acct_amnt*-1) FROM acmtline WHERE actln_docu_year = xclo_upto_year AND actln_docu_perd <= xclo_upto_period AND actln_acct_code = '411001' AND actln_docu_type = '1' AND actln_docu_stat in ( '1','2')),0) as clo_premium_written_chk,
 
   
  /* FROM ccmaddrs LEFT OUTER JOIN ccpcrncy ON ccmaddrs.ccad_acct_crcy = ccpcrncy.cccu_crcy_code
                                  LEFT OUTER JOIN ccpdecod ON ccpdecod.ccde_reco_type = '23' AND ccpdecod.ccde_reco_code = ccmaddrs.ccad_anls_cod3  
                                  JOIN ccmaccts  ON ccmaddrs.ccad_acct_serl = ccmaccts.ccac_acct_serl 


   WHERE ( ccmaddrs.ccad_acct_serl = ccmaccts.ccac_acct_serl ) and  
                 ( ( ccmaccts.ccac_acct_code like '1611%' ) OR  
                   ( ccmaccts.ccac_acct_code like '1612%' ) OR 
                   ( ccmaccts.ccac_acct_code like '1613%' ) OR
                   ( ccmaccts.ccac_acct_code like '1615%' ) OR
                   ( ccmaccts.ccac_acct_code like '2320RFC%' ) ) and
                /* (clo_premium_written_bal<>0) AND*/

                 (ccad_anls_cod4 = xclo_acgroup2  OR TRIM(xclo_acgroup2) = '')*/

  COALESCE((
    SELECT 
    inag_status_flag
    FROM inagents 
    WHERE 
    //IF char_length(inag_report_group5) > 3 THEN inag_report_group5 ELSE inag_agent_code ENDIF 
    inag_agent_code = 
    CASE clo_group1
    WHEN 'AG464' THEN 'AE364' //Found a line which instead to have agent code AE364 has AG464
    ELSE clo_group1
    END
  ),'O')
  as clo_agent_active_inactive,'1' as xclo_agent_status_n,'0' as xclo_agent_status_i,'1' as xclo_agent_status_m,'1' as xclo_agent_status_o 

into #temp

   FROM ccmaccts 
   LEFT OUTER JOIN ccpcrncy 
            ON ccmaccts.ccac_acct_crcy = ccpcrncy.cccu_crcy_code
   LEFT OUTER JOIN ccmaddrs 
            ON ccmaddrs.ccad_acct_serl = ccmaccts.ccac_acct_serl
   LEFT OUTER JOIN ccpdecod 
            ON ccpdecod.ccde_reco_type = '11' AND ccpdecod.ccde_reco_code = ccmaccts.ccac_anls_cod1  AND ccpdecod.ccde_status_flag='1'

   WHERE ( 1=1 ) and  
         (clo_group1 <> '????' Or (clo_group1 = '????' AND ccpdecod.ccde_status_flag='1' )) And 
         ( ( ccmaccts.ccac_acct_code like '1611%' ) OR  
         ( ccmaccts.ccac_acct_code like '1612%' ) OR  
         ( ccmaccts.ccac_acct_code like '1613%' ) OR  
         ( ccmaccts.ccac_acct_code like '1615%' ) OR  
         ( ccmaccts.ccac_acct_code like '2320RFC%' ) ) 
         /*AND (clo_premium_bal <> 0)*/
         /*(ccad_anls_cod4 = xclo_acgroup2  OR TRIM(xclo_acgroup2) = '')*/
and clo_group_desc <> 'AGENTS' 
and 
    (
      (clo_agent_active_inactive <> 'N' OR xclo_agent_status_n = 1) and
      (clo_agent_active_inactive <> 'M' OR xclo_agent_status_m = 1)and
      (clo_agent_active_inactive <> 'I'   OR xclo_agent_status_i = 1) and
      ( clo_agent_active_inactive <> 'T' OR xclo_agent_status_i = 1) and 
      ( clo_agent_active_inactive <> 'O' OR xclo_agent_status_o = 1)
    )
;

SELECT 
clo_group1,
clo_group_desc,
xclo_upto_year as clo_current_year,
clo_prev_year as clo_previous_year,
sum(clo_premium_written) as clo_total_gwp_current,
sum(clo_premium_written_p)as clo_total_gwp_previous,
sum(clo_premium_written_motor)as clo_gwp_motor_current,
sum(clo_premium_written_motor_p)as clo_gwp_motor_previous,
sum(clo_premium_written_liab)as clo_gwp_liability_current,
sum(clo_premium_written_liab_p)as clo_gwp_liability_previous,
sum(clo_premium_written_fire)as clo_gwp_property_current,
sum(clo_premium_written_fire_p)as clo_gwp_property_previous,
sum(clo_premium_written_eng)as clo_gwp_engineering_current,
sum(clo_premium_written_eng_p)as clo_gwp_engineering_previous,
sum(clo_premium_written_misc)as clo_gwp_misc_current,
sum(clo_premium_written_misc_p)as clo_gwp_misc_previous,
sum(clo_premium_written_marine)as clo_gwp_marine_current,
sum(clo_premium_written_marine_p)as clo_gwp_marine_previous
FROM 
#temp
GROUP BY
clo_group1,
clo_group_desc,
clo_current_year,
clo_previous_year
";
    $result = $sybase->query($sql);
    //clear any records of the same period/year
    $sqlDelete = '
    DELETE FROM report_gross_written_premium
    WHERE
    rpgwp_year = '.$year.'
    AND rpgwp_period = '.$period.';
    ';
    $extranet->query($sqlDelete);


    while ($row = $sybase->fetch_assoc($result)){

        $sql = '
        INSERT INTO report_gross_written_premium SET
        rpgwp_agent_code = "'.$row['clo_group1'].'",
        rpgwp_agent_description = "'.mb_convert_encoding($row['clo_group_desc'],"ISO-8859-1", "UTF-8").'",
        rpgwp_year = '.$year.',
        rpgwp_period = '.$period.',
        rpgwp_gwp_current = '.$row['clo_total_gwp_current'].',
        rpgwp_gwp_previous = '.$row['clo_total_gwp_previous'].',
        rpgwp_gwp_motor_current = '.$row['clo_gwp_motor_current'].',
        rpgwp_gwp_motor_previous = '.$row['clo_gwp_motor_previous'].',
        rpgwp_gwp_liability_current = '.$row['clo_gwp_liability_current'].',
        rpgwp_gwp_liability_previous = '.$row['clo_gwp_liability_previous'].',
        rpgwp_gwp_property_current = '.$row['clo_gwp_property_current'].',
        rpgwp_gwp_property_previous = '.$row['clo_gwp_property_previous'].',
        rpgwp_gwp_engineering_current = '.$row['clo_gwp_engineering_current'].',
        rpgwp_gwp_engineering_previous = '.$row['clo_gwp_engineering_previous'].',
        rpgwp_gwp_misc_current = '.$row['clo_gwp_misc_current'].',
        rpgwp_gwp_misc_previous = '.$row['clo_gwp_misc_previous'].',
        rpgwp_gwp_marine_current = '.$row['clo_gwp_marine_current'].',
        rpgwp_gwp_marine_previous = '.$row['clo_gwp_marine_previous'].',
        rpgwp_created_date_time = "'.date('Y-m-d G:i:s').'",
        rpgwp_created_by = -1
        ;
    ';
        $extranet->query($sql) or die ($extranet->error());


    }
    return true;
}
