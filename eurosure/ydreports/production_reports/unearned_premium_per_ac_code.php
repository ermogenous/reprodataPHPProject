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

if ($_POST["agent_from"] != "" && $_POST["agent_to"] != "") {

	$agents = "AND inag_agent_code BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."'";

}//agents

if ($_POST["klado_from"] != "" && $_POST["klado_to"] != "" ) {

	$klado = "AND inmajorcodes.incd_record_type BETWEEN '".$_POST["klado_from"]."' AND '".$_POST["klado_to"]."'";

}//klados

if ($_POST["klado_exclude"] != "") {

	$klado_exclude = "AND inmajorcodes.incd_record_type <> '".$_POST["klado_exclude"]."'";

}//klado exlude

if ($_POST["insurance_type"] != "") {

	$insurance_type = "AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'";

}//insurance type

if ($_POST["insurance_type_exclude"] != "") {

	$insurance_type_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'";

}//insurance type exclude

if ($_POST["policies_from"] != "" && $_POST["policies_to"] != "") {

	$policies = "AND inpol_policy_number BETWEEN '".$_POST["policies_from"]."' AND '".$_POST["policies_to"]."'";

}

$sql = "

SELECT 
'".$_POST["as_at_date"]."' as clo_as_at_date,   
YEAR(clo_as_at_date) * 100 + MONTH(clo_as_at_date) As clo_as_at_period,   
SUM(inplg_period_premium) as clo_phase_gross_premium,   
REPLACE(inldg_income_account, 'REP:', '') as clo_ac_code,   
inity_insurance_type,

SUM(IF clo_as_at_date < inpva_expiry_date THEN COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, clo_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_gross_unearned_premium


//,COALESCE((IF peril.incd_ldg_rsrv_under_reinsurance = 'Y' THEN ((SELECT LIST(inpit_pit_auto_serial) FROM inreinsurancetreaties JOIN inpolicyreinsurance ON inpri_reinsurance_treaty_serial = inrit_reinsurance_treaty_serial WHERE inpri_reinsurance_treaty_serial = inpit_reinsurance_treaty AND inpri_policy_serial = inpol_policy_serial AND inpri_reinsurance_type IN ('2-QTA','5-FLC','6-FFR')))/100 ELSE 0 ENDIF),0) as clo_quota_percentage

,COALESCE((IF peril.incd_ldg_rsrv_under_reinsurance = 'Y' THEN ((SELECT DISTINCT(inpri_reinsurance_percentage) FROM inreinsurancetreaties JOIN inpolicyreinsurance ON inpri_reinsurance_treaty_serial = inrit_reinsurance_treaty_serial WHERE inpri_reinsurance_treaty_serial = inpit_reinsurance_treaty AND inpri_policy_serial = inpol_policy_serial AND inpri_reinsurance_type IN ('2-QTA','5-FLC','6-FFR')))/100 ELSE 0 ENDIF),0) as clo_quota_percentage
,SUM(IF clo_as_at_date < inpva_expiry_date THEN clo_quota_percentage * COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, clo_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_unearned_quota

,COALESCE((IF peril.incd_ldg_rsrv_under_reinsurance = 'Y' THEN ((SELECT DISTINCT(inpri_reinsurance_percentage) FROM inreinsurancetreaties JOIN inpolicyreinsurance ON inpri_reinsurance_treaty_serial = inrit_reinsurance_treaty_serial WHERE inpri_reinsurance_treaty_serial = inpit_reinsurance_treaty AND inpri_policy_serial = inpol_policy_serial AND inpri_reinsurance_type IN ('1-RTN')))/100 ELSE 0 ENDIF),0) as clo_quota_rtn_percentage

,SUM(IF clo_as_at_date < inpva_expiry_date THEN clo_quota_rtn_percentage * COALESCE((inplg_period_premium) * (CAST(DATEDIFF(Day, clo_as_at_date, inpva_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpva_starting_date, inpva_expiry_date) +1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_unearned_quota_rtn

into #temp

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
         initems  
   WHERE ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) and  
         ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial ) and  
         ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) and  
         ( inpoliciesactive.inpva_policy_serial = inpolicies.inpol_policy_serial ) and  
         ( inpolicyloadings.inplg_policy_serial = inpolicies.inpol_policy_serial ) and  
         ( inloadings.inldg_loading_serial = inpolicyloadings.inplg_loading_serial ) and  
         ( peril.incd_pcode_serial = inloadings.inldg_claim_reserve_group ) and  
         ( inpolicyloadings.inplg_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial ) and  
         ( initems.initm_item_serial = inpolicyitems.inpit_item_serial ) and  
         (inpva_status = 'N' AND  
           inpva_year * 100 + inpva_period <= clo_as_at_period) AND  
         UPPER(inpparam.inpr_module_code) = 'IN' AND  
         (((inldg_loading_type <> 'X') /* Not X-Premium */ AND  
          ((inldg_loading_type = inpol_cover) OR  
           (inpol_cover = 'B' AND  
            inpr_act_in_fire_theft = 'N') OR  
           (inpol_cover = 'C' AND  
            inpr_act_in_comprehensive = 'N'))))   

".$agents."
".$klado."
".$klado_exclude."
".$insurance_type."
".$insurance_type_exclude."
".$policies."

GROUP BY 
inpoliciesactive.inpva_as_at_date   
,inloadings.inldg_income_account
,inpit_reinsurance_treaty
,peril.incd_ldg_rsrv_under_reinsurance
,inity_insurance_type
,inpol_policy_serial
//order by inpol_policy_number,clo_ac_code ASC


SELECT
inity_insurance_type
,clo_ac_code
,SUM(clo_phase_gross_premium)as Phase_Gross_Premium
,SUM(clo_gross_unearned_premium)as Gross_Unearned_Premium
,SUM(clo_unearned_quota)as Unearned_Quota_and_FAC
,SUM(clo_unearned_quota_rtn)as Unearned_Quota_Retention
FROM
#temp
GROUP BY
inity_insurance_type,
clo_ac_code
ORDER BY inity_insurance_type,clo_ac_code


";
//echo $sql;
$sybase->query("INSERT INTO ccuserparameters (ccusp_user_date,ccusp_user_identity)VALUES('".$_POST["as_at_date"]."' ,'ERMOGEN')");

//export_data_delimited($data,$fields,'#','none','download','
//','data');
$output_table = export_data_html_table($sql,'sybase');


}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="649" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Premium Per Item Report </td>
    </tr>
    <tr>
      <td width="226" height="28">As At Date </td>
      <td width="423"><input name="as_at_date" type="text" id="as_at_date" size="12" value="<? echo $_POST["as_at_date"];?>"></td>
    </tr>
    
    <tr>
      <td height="28">Agents</td>
      <td>From
        <input name="agent_from" type="text" id="agent_from" value="<? echo $_POST["agent_from"];?>" size="8" />
To
<input name="agent_to" type="text" id="agent_to" value="<? echo $_POST["agent_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category(Klado)  </td>
      <td>From
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["klado_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["klado_exclude"];?>"/>
      (exclude) ex 17% </td>
    </tr>
    <tr>
      <td height="28">Insurance Type </td>
      <td><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_POST["insurance_type"];?>" /> 
      ex 222% Insert % to group by </td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="insurance_type_exclude" type="text" id="insurance_type_exclude" value="<? echo $_POST["insurance_type_exclude"];?>" /> 
      ex 190% or 19% </td>
    </tr>
    
    <tr>
      <td height="28">Policies Range </td>
      <td> From:
        <input name="policies_from" type="text" id="policies_from" size="11" value="<? echo $_POST["policies_from"];?>" />
      To:
      <input name="policies_to" type="text" id="policies_to" size="11" value="<? echo $_POST["policies_to"];?>" /></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br />
<br />
<div id="print_view_section_html">
<?
echo $output_table;
?>
</div>
<?
$db->show_footer();
?>