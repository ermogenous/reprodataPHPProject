<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();


$db->show_header();
?>
<form action="" method="post">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr class="row_table_head">
    <td colspan="2" align="center"><strong>Unearned Premium Per Account Code</strong></td>
    </tr>
  <tr>
    <td width="138">As At Date</td>
    <td width="462"><input type="text" name="as_at_date" id="as_at_date" value="<? echo $_POST["as_at_date"];?>">
      dd/mm/yyyy</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="go"></td>
    <td><input type="submit" name="button" id="button" value="Submit"></td>
  </tr>
  <tr>
    <td colspan="2"><p>NTP -&gt; Net Total Premium without Fees/Stamps/MIF<br />
      NTP = (NRP) Not reinsured Perils + (RP) Reinsured Perils</p>
      <p><strong>Placement:</strong><br />
        RP = (R) Retained Premium + (C) Ceeded Premium</p>
      <p><strong>The below is not considered in this report</strong><br />
      (C) = (FC) Final Ceeded Premium + (RIC) Reinusrance Commission</p>
      <p>NTP -&gt; GROSS PREMIUM<br />
        C -&gt; RI_SHARE<br />
      NRP + R = NET WRITTEN PREMIUM</p></td>
    </tr>
</table>

</form>

<?
if ($_POST["action"] == 'go' && $_POST["as_at_date"] != "") {
	
	//insert as at date to ccuserparameters
	$sql = "INSERT INTO ccuserparameters (ccusp_auto_serial,ccusp_user_date,ccusp_user_identity)ON EXISTING UPDATE VALUES(1,'".$db->convert_date_format($_POST["as_at_date"],'dd/mm/yyyy','yyyy-mm-dd')."' ,'INTRANET');";
	$sybase->query($sql);
	
	
	$sql = "SELECT 
clo_as_at_period,
inpva_policy_serial,
inpva_policy_number,
clo_unearned_days,
clo_policy_total_days,
REPLACE(inldg_income_account, 'REP:', '') as clo_ac_code,
clo_gross_premium,
clo_gross_unearned_premium,
clo_reinsurable_premium,
clo_unearned_reinsurable_premium,
clo_fac_reinsurable_premium,
clo_unearned_fac_reinsurable_premium,
COALESCE(inpar_retention_percentage,100),
COALESCE(inpar_quota_percentage,0)as clo_quota_percentage,
(clo_reinsurable_premium * clo_quota_percentage / 100 ) as clo_quota_share,
(clo_reinsurable_premium * clo_quota_percentage / 100 ) * clo_unearned_days / clo_policy_total_days as clo_unearned_quota_share,
COALESCE(inpar_1st_surplus_percentage,0)as clo_1st_surplus_percentage,
(clo_reinsurable_premium * clo_1st_surplus_percentage / 100 ) as clo_1st_surplus_share,
(clo_reinsurable_premium * clo_1st_surplus_percentage / 100 ) * clo_unearned_days / clo_policy_total_days as clo_1st_unearned_surplus_share,
COALESCE(inpar_2nd_surplus_percentage,0)as clo_2nd_surplus_percentage,
(clo_reinsurable_premium * clo_2nd_surplus_percentage / 100 ) as clo_2nd_surplus_share,
(clo_reinsurable_premium * clo_2nd_surplus_percentage / 100 ) * clo_unearned_days / clo_policy_total_days as clo_2nd_unearned_surplus_share,
COALESCE(inpar_fac_foreign_percentage,0)as clo_fac_foreign_percentage,
(clo_reinsurable_premium * clo_fac_foreign_percentage / 100 ) as clo_fac_foreign_share,
(clo_reinsurable_premium * clo_fac_foreign_percentage / 100 ) * clo_unearned_days / clo_policy_total_days as clo_fac_unearned_foreign_share,
COALESCE(inpar_fac_local_percentage,0)as clo_fac_local_percentage,
(clo_reinsurable_premium * clo_fac_local_percentage / 100 ) as clo_fac_local_share,
(clo_reinsurable_premium * clo_fac_local_percentage / 100 ) * clo_unearned_days / clo_policy_total_days as clo_fac_unearned_local_share
into #temp
  FROM (SELECT 
                    YEAR(inpva_as_at_date) * 100 + MONTH(inpva_as_at_date) as clo_as_at_period,
                    inpva_policy_serial,inpva_policy_number, inpva_last_endorsement_serial, inpit_reinsurance_treaty, inldg_income_account,
                    SUM(inplg_period_premium) as clo_gross_premium,
                    SUM(IF inpva_as_at_date < inpva_expiry_date THEN COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, inpva_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_gross_unearned_premium,
                    SUM(IF COALESCE(inlsc_ldg_rsrv_under_reinsurance,'Y') = 'Y' THEN inplg_period_premium ELSE 0 ENDIF) as clo_reinsurable_premium,
                    SUM(IF inpva_as_at_date < inpva_expiry_date AND COALESCE(inlsc_ldg_rsrv_under_reinsurance,'Y') = 'Y' THEN COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, inpva_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_unearned_reinsurable_premium,
                    SUM(IF COALESCE(inlsc_ldg_rsrv_under_reinsurance,'Y') = 'Y' AND COALESCE(inlsc_ldg_rsrv_under_fac_foreign, 'Y') = 'Y' THEN inplg_period_premium ELSE 0 ENDIF) as clo_fac_reinsurable_premium,
                    SUM(IF inpva_as_at_date < inpva_expiry_date AND COALESCE(inlsc_ldg_rsrv_under_reinsurance,'Y') = 'Y' AND COALESCE(inlsc_ldg_rsrv_under_fac_foreign, 'Y') = 'Y' THEN COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, inpva_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_unearned_fac_reinsurable_premium
,(DATEDIFF(Day, inpva_as_at_date, inpva_expiry_date))as clo_unearned_days
,(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1) as clo_policy_total_days
                FROM inpoliciesactive
                JOIN inpolicies ON inpva_policy_serial = inpol_policy_serial
                join ininsurancetypes on inpol_insurance_type_serial = inity_insurance_type_serial
                JOIN inpolicyitems ON inpol_policy_serial = inpit_policy_serial
                JOIN inpolicyloadings ON inpit_pit_auto_serial = inplg_pit_auto_serial
                JOIN inloadings  ON ( inloadings.inldg_loading_serial = inpolicyloadings.inplg_loading_serial )
                left outer join inloadingstatcodes on inldg_claim_reserve_group = inlsc_pcode_serial
                //left outer join inpcodes on inldg_claim_reserve_group = incd_pcode_serial
                /*  ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial ) and  
                         ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) and  */
                WHERE   (inpva_status = 'N' AND  
                         inpva_year * 100 + inpva_period <= clo_as_at_period) AND  
                         inldg_loading_type <> 'X' /* Not X-Premium */
                GROUP BY inpoliciesactive.inpva_as_at_date,   
                         inloadings.inldg_income_account,
                        inpva_policy_serial,inpva_policy_number, inpva_last_endorsement_serial, inpit_reinsurance_treaty, inldg_income_account
					,inpva_expiry_date,inpva_starting_date
					) AS DERIVED_T1


  LEFT OUTER JOIN inpolicyaltreinsurance 
                                ON inpva_policy_serial = inpar_policy_serial
                                AND inpva_last_endorsement_serial = inpar_endorsement_serial
                                AND inpit_reinsurance_treaty = inpar_line_treaty
  WHERE 
1=1;

/*
select
clo_ac_code
,SUM(clo_gross_premium)as Gross_Premium
,SUM(clo_gross_unearned_premium)as Gross_Unearned_Pr
,SUM(clo_quota_share + clo_1st_surplus_share + clo_2nd_surplus_share + clo_fac_foreign_share + clo_fac_local_share ) as RI_SHARE
,SUM(clo_unearned_quota_share + clo_1st_unearned_surplus_share + clo_2nd_unearned_surplus_share + clo_fac_unearned_foreign_share + clo_fac_unearned_local_share) as UNEARNED_RI_SHARE
,SUM(clo_gross_premium - clo_quota_share - clo_1st_surplus_share - clo_2nd_surplus_share - clo_fac_foreign_share - clo_fac_local_share)as NET_WRITTEN_PREMIUM
,SUM(clo_gross_unearned_premium - clo_unearned_quota_share - clo_1st_unearned_surplus_share - clo_2nd_unearned_surplus_share - clo_fac_unearned_foreign_share - clo_fac_unearned_local_share) as NET_UNEARNED_WRITTEN_PR
from
#temp
where
1=1
GROUP BY
clo_ac_code;
*/
select
clo_ac_code
,SUM(clo_gross_premium)as Gross_Premium
,SUM(clo_gross_unearned_premium)as Gross_Unearned_Pr
,SUM(clo_quota_share + clo_1st_surplus_share + clo_2nd_surplus_share + clo_fac_foreign_share + clo_fac_local_share ) as RI_SHARE
,SUM(clo_unearned_quota_share + clo_1st_unearned_surplus_share + clo_2nd_unearned_surplus_share + clo_fac_unearned_foreign_share + clo_fac_unearned_local_share) as UNEARNED_RI_SHARE
,SUM(clo_gross_premium - clo_quota_share - clo_1st_surplus_share - clo_2nd_surplus_share - clo_fac_foreign_share - clo_fac_local_share)as NET_WRITTEN_PREMIUM
,SUM(clo_gross_unearned_premium - clo_unearned_quota_share - clo_1st_unearned_surplus_share - clo_2nd_unearned_surplus_share - clo_fac_unearned_foreign_share - clo_fac_unearned_local_share) as NET_UNEARNED_WRITTEN_PR
,SUM(clo_reinsurable_premium)as Reinsurable_Premium
from
#temp
where
1=1
GROUP BY
clo_ac_code;";

$output_table = export_data_html_table($sql,'sybase');
?>
<div id="print_view_section_html">
<?
echo $output_table;
?>
</div>
<?
	
}

$db->show_footer();
?>