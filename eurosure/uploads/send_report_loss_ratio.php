<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 28/5/2021
 * Time: 12:06 μ.μ.
 */


/*
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../lib/odbccon.php');

$db = new Main(0);
$db->admin_title = "Eurosure - Uploads - Loss Ratio";


$sybase = new ODBCCON();
*/



$log = '';

$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('upload gross written premium',0,$log,'test');
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

echo "<hr>Check if ".$period."/".$year." already exists on extranet -> <br>";
$extranetCheck = $extranet->query('
    SELECT COUNT(*)as clo_total FROM report_loss_ratio WHERE rplr_year = '.$year.' AND rplr_up_to_period = '.$period.'
');
$extranetCheck = mysqli_fetch_assoc($extranetCheck);
if ($extranetCheck['clo_total'] > 0){
    echo "Period already exists on extranet.";
}
else {
    echo "Period does not exists. Proceeding to update.<br>";
    echo "<hr>Send data for report loss ratio -> ";
    echo $year."/".$period." <br>AsAt:".$asAtDate;
    updateOnlineLossRatio($year,$period,$asAtDate);
}

function updateOnlineLossRatio($year,$uptoPeriod,$asAtDate)
{
    global $sybase, $extranet;
    $sql = "
    
    SELECT 
    LEFT(actln_anls_cod3,1) as clo_lob,
    SUBSTR(actln_anls_cod3, 2,3) as clo_class,
    actln_anls_cod1,
    actln_anls_cod3,
    actln_refe_nmbr,
    '".$year."' as xclo_upto_year,
    '1' as xclo_from_period,
    '".$uptoPeriod."' as xclo_upto_period,
    '".$asAtDate."' as xclo_as_at_date,
    'A' as xclo_lob,
    'F' as xclo_lob_to,
    'AG000' as xclo_account_from,
    'AG999' as xclo_account_to,
    'AG000' as xclo_acgroup1,
    'AG999' as xclo_acgroup1_to,
    (actln_anls_cod1+SUBSTR(actln_anls_cod3, 2,3)+actln_refe_nmbr) as clo_claimno,
    '".$year."' as xclo_anal_1_from,
    '".$year."' as xclo_anal_1_to,
    ccac_acct_stat,
    ccad_anls_cod1,
    ccac_anls_cod1,
    
    COALESCE( IF LEFT(ccac_anls_cod1,2) IN ('AE','AG') THEN  ccde_anal_code/*ccac_anls_cod1*/  ELSE IF LEFT(ccac_anls_cod1,3)='COR' THEN 'SA000' ELSE IF LEFT(ccac_anls_cod1,7) IN ('DIR-NIC','DIR-OTH','DIR-LIM') THEN 'D0000' ELSE IF LEFT(ccac_anls_cod1,7)='DIR-LMM' THEN 'DA000' ELSE IF LEFT(ccac_anls_cod1,8)='SHAREHOL' THEN 'SH000' ELSE IF LEFT(ccac_anls_cod1,2)='RF' THEN 'RF000' ELSE 'ZZ999'+actln_anls_cod4 ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF,'ZZZZ') as clo_group_code,   
    COALESCE(  IF LEFT(ccac_anls_cod1,2) IN ('AE','AG') THEN  ccde_long_desc/*ccad_shrt_desc*/  ELSE IF LEFT(ccac_anls_cod1,3)='COR' THEN 'CORPORATE' ELSE IF LEFT(ccac_anls_cod1,7) IN ('DIR-NIC','DIR-OTH','DIR-LIM') THEN 'DIRECT' ELSE IF LEFT(ccac_anls_cod1,7)='DIR-LMM' THEN 'DIRECT LIMASSOL' ELSE IF LEFT(ccac_anls_cod1,8)='SHAREHOL' THEN 'SHAREHOLDERS' ELSE IF LEFT(ccac_anls_cod1,2)='RF' THEN 'FOREIGN R/I' ELSE 'UNKNOWN' ENDIF ENDIF ENDIF ENDIF ENDIF ENDIF,'INACTIVE/TERMINATED AGENTS') as clo_name,   
    
    
    /*IF LEFT(ccac_acct_code, 4) IN ('1611','1615') THEN ccmaccts.ccac_anls_cod1 ELSE ccmaccts.ccac_alte_acct ENDIF as clo_group_code,*/
    /*IF LEFT(ccac_acct_code, 4) IN ('1611','1615') THEN ccde_anal_code ELSE ccac_anls_cod1 ENDIF as clo_group_code,*/
    
    SUM(IF actln_acct_code = '411001' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_gwp,
    SUM(IF actln_acct_code = '411002' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND LEFT(actln_anls_cod8,2) = 'LC') THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_gwp_localri,
    
    COUNT(DISTINCT IF actln_acct_code = '411001' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND actln_anls_cod2 = 'NEWOG') THEN actln_refe_nmbr ELSE NULL ENDIF ) as clo_count_new,
    COUNT(DISTINCT IF actln_acct_code = '411001' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND actln_anls_cod2 = 'RNLOG') THEN actln_refe_nmbr ELSE NULL ENDIF ) as clo_count_ren,
    COUNT(DISTINCT IF actln_acct_code = '411001' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND actln_anls_cod2 IN ('CANOG','CNLOG')) THEN actln_refe_nmbr ELSE NULL ENDIF ) as clo_count_can,
    (clo_count_new+clo_count_ren-clo_count_can) as clo_pcount,
    
    COUNT(DISTINCT IF actln_acct_code in ('211001','511001') AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN clo_claimno ELSE NULL ENDIF ) as clo_count_claim,
    
      
    SUM(IF actln_acct_code = '213099' AND (actln_docu_year>=2005 AND actln_docu_year<=xclo_upto_year-1 AND actln_anls_cod3<>'A') THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_uep_bf,
    SUM(IF actln_acct_code = '213099' AND (actln_docu_year>=2005 AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND actln_anls_cod3<>'A')  THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_uep_cf,
    (clo_gwp+clo_uep_bf-clo_uep_cf) as clo_gep,
    
    SUM(IF actln_acct_code = '211001' AND (actln_docu_year <= xclo_upto_year-1 and actln_docu_perd <= '12') THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_bf,
    SUM(IF actln_acct_code = '211002' AND (actln_docu_year <= xclo_upto_year-1 and actln_docu_perd <= '12' and LEFT(actln_anls_cod8,2) = 'LC') THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_localri_bf,
    
    SUM(IF actln_acct_code = '211001' AND (actln_docu_year*100+actln_docu_perd>=200909 AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_cf,
    SUM(IF actln_acct_code = '211002' AND (actln_docu_year*100+actln_docu_perd>=200909 AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND LEFT(actln_anls_cod8,2) = 'LC') THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_localri_cf,
    
    SUM(IF actln_acct_code = '511001' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid,
    SUM(IF actln_acct_code = '511002' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period AND LEFT(actln_anls_cod8,2) = 'LC') THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_localri,
    (clo_paid+clo_os_cf) as clo_gic,
    (clo_paid+clo_os_cf-clo_os_bf) as clo_gic2,
    (clo_gwp+clo_fees) as clo_gwpfees,
    
    
    SUM(IF actln_acct_code = '451001' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_fees,
    SUM(IF actln_acct_code = '251007' AND (actln_docu_year*100+actln_docu_perd>=xclo_upto_year*100+xclo_from_period AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_stamps,
    SUM(IF actln_acct_code = '251002' AND (actln_docu_year*100+actln_docu_perd>=xclo_upto_year*100+xclo_from_period AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_mif,
    SUM(IF actln_acct_code = '531002' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_commission,
    SUM(IF actln_acct_code = '531012' AND (actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_comm_fees,
    (clo_commission+clo_comm_fees) as clo_total_comm,
    
    (clo_gwp*15/100) as clo_admin_exp_p,   
    (clo_gwp*12.5/100) as clo_ri_exp_p,
    (clo_admin_exp_p+clo_ri_exp_p) as clo_othexpenses,
    
    (clo_gep-clo_gic) as clo_net_1,
    ((clo_gep+clo_fees)-(clo_gic+clo_total_comm)) as clo_net_2,
    
    (clo_gic / (clo_gwp)) as clo_lossratio_gwp,
    (clo_gic / (clo_gep)) as clo_lossratio_gep,
    
    (clo_gic / (clo_gwp+clo_fees)) as clo_lossratio_gwpfees,
    (clo_gic / (clo_gep+clo_fees)) as clo_lossratio_gepfees,
    ((clo_gic+clo_othexpenses) / (clo_gep+clo_fees)) as clo_lossratio_3
    
    into #temp
    FROM acmtline 
    LEFT OUTER JOIN ccmaccts ON ccac_alte_acct = actln_anls_cod4 AND ccac_alte_acct <> '' /* Avoid multiplying the rows*/
    /*                                               AND ccac_acct_stat='1' */
    LEFT OUTER JOIN ccmaddrs ON ccac_addr_type = ccad_addr_type AND ccac_addr_code = ccad_addr_code
                             /* AND ccad_addr_type = '1' /*Debtors*/ */
    /*LEFT OUTER JOIN ccpdecod ON clo_group_code = ccde_reco_code AND ccde_reco_type = '11' AND ccpdecod.ccde_status_flag='1'*/
    LEFT OUTER JOIN ccpdecod ON ccde_reco_type = '11' AND ccde_reco_code = ccac_anls_cod1  /*AND ccde_status_flag='1'*/
    
    
    WHERE actln_acct_code IN ('411001','211001','211002','511001','511002','213099','451001','531002','531012','251007','251002','231010')
    AND LEFT(actln_anls_cod3,1) >= xclo_lob AND LEFT(actln_anls_cod3,1) <= xclo_lob_to
    AND actln_docu_stat <> '9'
    AND actln_docu_type = '1'
    AND LEN(clo_class) = 3
    AND ((actln_anls_cod1 >= xclo_anal_1_from AND actln_anls_cod1 <= xclo_anal_1_to) OR TRIM(xclo_anal_1_from) = '')
    AND ((COALESCE(clo_group_code, '') >= xclo_account_from AND COALESCE(clo_group_code, '') <= xclo_account_to) OR (TRIM(xclo_account_from) = ''))
    
    /*AND clo_group_code = actln_anls_cod4*/
    /*AND LEFT(clo_group_code,2) IN ('AE','AG','AS')*/
    
    AND (COALESCE(ccac_acct_stat, '1')='1')  /*to show lines with invalid actln_anls_cod4 shown under NONE*/
    
    GROUP BY  clo_group_code,clo_name,LEFT(actln_anls_cod3,1),actln_anls_cod1,actln_anls_cod3,actln_refe_nmbr,xclo_lob,xclo_lob_to, xclo_as_at_date, xclo_upto_year,xclo_upto_period,xclo_from_period,ccac_acct_stat,ccad_anls_cod1,ccac_anls_cod1
    ORDER BY  clo_group_code,clo_name,LEFT(actln_anls_cod3,1),actln_anls_cod1,actln_anls_cod3,actln_refe_nmbr,xclo_lob,xclo_lob_to, xclo_as_at_date, xclo_upto_year,xclo_upto_period,xclo_from_period,ccac_acct_stat,ccad_anls_cod1,ccac_anls_cod1 
    ;
        
    SELECT
    clo_group_code as clo_agent_code,
    clo_name,
    actln_anls_cod1 as clo_year,
    case clo_lob
    WHEN 'A' THEN 'MOTOR'
    WHEN 'B' THEN 'Liability'
    WHEN 'C' THEN 'Fire & Other Perils'
    WHEN 'D' THEN 'Engineering'
    WHEN 'E' THEN 'Miscallaneous'
    WHEN 'F' THEN 'Marine'
    ELSE clo_lob
    end as clo_lob,
    sum( clo_pcount) as clo_num_of_policies,
    sum( clo_count_new) as clo_num_of_new,
    sum( clo_count_ren)as clo_num_of_renewals,
    sum( clo_count_can)as clo_num_of_cancellations,
    sum( clo_gwp) as clo_gross_written_premium,
    sum(clo_fees) as clo_fees,
    sum(clo_gwpfees)as clo_gwp_fees,
    sum( clo_count_claim)as clo_claims_count,
    ( clo_claims_count / clo_num_of_policies )*100 as clo_claims_frequency_has_problem,
    sum( clo_paid)as clo_claims_paid,
    sum( clo_os_cf)as clo_claims_os_cf,
    sum(clo_gic)as clo_claims_incurred,
    sum(clo_total_comm)as clo_commission,
    round(sum(clo_othexpenses),2)as clo_expenses,
    round(((clo_claims_incurred / clo_gross_written_premium)*100),2) as clo_lratio_gic_gwp,
    round((((clo_claims_incurred+clo_commission)/(clo_gross_written_premium+clo_gwp_fees))*100),2)as clo_lratio_fees_comm,
    round((((clo_claims_incurred+clo_commission+clo_expenses)/(clo_gross_written_premium+clo_gwp_fees))*100),2)as clo_lratio_fees_comm_exp
    FROM
    #temp
    WHERE
    1=1
    //AND clo_group_code = 'AG103'
    
    GROUP BY
    clo_group_code,
    clo_name,
    actln_anls_cod1,
    clo_lob
    ORDER BY clo_group_code,clo_lob ASC
    ";

    //clear any records of the same period/year
    $sqlDelete = '
    DELETE FROM report_loss_ratio
    WHERE
    rplr_year = '.$year.'
    AND rplr_up_to_period = '.$uptoPeriod.';';
    $extranet->query($sqlDelete);


    $result = $sybase->query($sql);
    while ($row = $sybase->fetch_assoc($result)){
        $sql = '
        INSERT INTO report_loss_ratio SET
        rplr_agent_code = "'.$row['clo_agent_code'].'",
        rplr_agent_description = "'.$row['clo_name'].'",
        rplr_year = '.$year.',
        rplr_up_to_period = '.$uptoPeriod.',
        rplr_lob = "'.$row['clo_lob'].'",
        rplr_num_of_policies = '.$row['clo_num_of_policies'].',
        rplr_num_of_new = '.$row['clo_num_of_new'].',
        rplr_num_of_renewals = '.$row['clo_num_of_renewals'].',
        rplr_num_of_cancellations = '.$row['clo_num_of_cancellations'].',
        rplr_gross_written_premium = '.$row['clo_gross_written_premium'].',
        rplr_fees = '.$row['clo_fees'].',
        rplr_gwp_fees = '.$row['clo_gwp_fees'].',
        rplr_claims_count = '.$row['clo_claims_count'].',
        rplr_claims_paid = '.$row['clo_claims_paid'].',
        rplr_claims_os_cf = '.$row['clo_claims_os_cf'].',
        rplr_claims_incurred = '.$row['clo_claims_incurred'].',
        rplr_commission = '.$row['clo_commission'].',
        rplr_expenses = '.$row['clo_expenses'].',
        rplr_created_date_time = "'.date('Y-m-d G:i:s').'",
        rplr_created_by = -1
        ;
        ';
        $extranet->query($sql) or die ($extranet->error."<br><hr>".$sql);
    }
}
