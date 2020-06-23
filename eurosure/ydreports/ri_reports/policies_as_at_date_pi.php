<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();

//=============================================================================================================

if ($_POST["action"] == "submit") {


$sql = "
SELECT  
1 as clo_policy_count,
ininsurancetypes.inity_insurance_type ,           
ininsurancetypes.inity_long_description ,           
COALESCE(inpvsdt_as_at_date, Date(Now())) as clo_as_at_date,           
YEAR(clo_as_at_date) * 100 + MONTH(clo_as_at_date) As clo_as_at_period,           
inpolicies.inpol_policy_number ,           
inpolicies.inpol_policy_serial ,           
inpolicies_asat_date.inpvsdt_active_phase_pr ,           
-1 * COALESCE((SELECT SUM(b.inped_premium * b.inped_premium_debit_credit) FROM inpolicies a JOIN inpolicyendorsement b ON a.inpol_policy_serial = b.inped_policy_serial WHERE a.inpol_policy_number = inpolicies.inpol_policy_number AND a.inpol_period_starting_date = inpolicies.inpol_period_starting_date AND a.inpol_policy_serial < inpolicies.inpol_policy_serial AND b.inped_status = '1'), 0) as clo_earned_in_previous_phases,
COUNT() as clo_items_count,           
SUM(inpia_height) as clo_insured_amount,

(SELECT -1 * SUM(inped_premium_debit_credit * (IF inldg_loading_type <> 'X' AND inlsc_ldg_rsrv_under_reinsurance <> 'Y' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as inpae_treaty_reinsured_premium FROM inpolicyloadings as plg JOIN inloadings as ldg ON inldg_loading_serial = inplg_loading_serial LEFT OUTER JOIN inloadingstatcodes as lsc on inldg_claim_reserve_group = inlsc_pcode_serial LEFT OUTER JOIN inpolicyendorsement as ped on inplg_policy_serial = inped_policy_serial WHERE inplg_policy_serial = inpolicies.inpol_policy_serial)as clo_treaty_not_reinsured_premium,

(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = inpolicies.inpol_policy_serial)as clo_situation_count,
inagents.inag_agent_code,
(SELECT incd_long_description FROM inpcodes WHERE incd_pcode_serial = inpol_policy_occupation)as clo_occupation

into #temp

FROM ininsurancetypes 
LEFT OUTER JOIN inmajorcodes ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code 
LEFT OUTER JOIN inminorcodes ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,          
inagents ,          
ingeneralagents ,           
inpolicies_asat_date ,           
inpolicyitems ,
inpolicyitemaux   

WHERE 
( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial ) 
and ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and ( inpolicies_asat_date.inpvsdt_policy_serial = inpolicies.inpol_policy_serial ) 
and ( inpolicyitems.inpit_policy_serial = inpolicies.inpol_policy_serial ) 
and inpit_pit_auto_serial = inpia_pit_auto_serial
and (inpvsdt_status = 'N' and (inpvsdt_year * 100 + inpvsdt_period <= clo_as_at_period) ) 
AND inity_insurance_type IN ('2221','2220')

GROUP BY inpolicies_asat_date.inpvsdt_as_at_date ,
ininsurancetypes.inity_insurance_type ,
ininsurancetypes.inity_long_description ,
ininsurancetypes.inity_insurance_type_serial ,
inpolicies.inpol_policy_serial ,           
inpolicies.inpol_policy_number ,           
inpolicies.inpol_period_starting_date ,           
inpolicies_asat_date.inpvsdt_active_phase_pr,
inagents.inag_agent_code,
clo_occupation

ORDER BY inpolicies.inpol_policy_number ASC

	SELECT
	inpol_policy_number ,
	COUNT() as total_policies,
	SUM(inpvsdt_active_phase_pr)as total_active_phase_premium,
	SUM(clo_earned_in_previous_phases)as total_previous_phases_premium,
	SUM(inpvsdt_active_phase_pr + clo_earned_in_previous_phases)as total_premium,
	SUM(clo_items_count)as total_items,
	SUM(clo_situation_count) as total_situations,
	SUM(clo_treaty_not_reinsured_premium)as total_not_reinsured_premium,
	SUM(clo_insured_amount)as total_insured_amount,
	MAX(DISTINCT(clo_occupation)) as policy_occupation
	FROM #temp
	GROUP BY inpol_policy_number 
	ORDER BY inpol_policy_number ASC";
//echo $sql;
//export_data_delimited($sql,'sybase','#','none','download','
//');

$sybase->query("INSERT INTO ccuserparameters (ccusp_user_date,ccusp_user_identity)VALUES('".$_POST["as_at_date"]."' ,'ERMOGEN')");


if ($_POST["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"none",'download');
}
else if ($_POST["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
}


}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="534" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Policies Index As At Date For Proffessional Indemnity </td>
    </tr>
    <tr>
      <td width="154" height="28">As At Date </td>
      <td width="380"><input name="as_at_date" type="text" id="as_at_date" value="<? echo $_POST["as_at_date"];?>"></td>
    </tr>
    

    <tr>
      <td height="28">Export File</td>
      <td><input name="export_file" type="radio" value="no" <? if ($_POST["export_file"] == "no") echo "checked=\"checked\"";?> />
No
  <input name="export_file" type="radio" value="delimited" <? if ($_POST["export_file"] == "delimited") echo "checked=\"checked\"";?> />
Delimited (#)
<input name="export_file" type="radio" value="xml" <? if ($_POST["export_file"] == "xml") echo "checked=\"checked\"";?> />
XML (NOT WORKING YET) </td>
    </tr>
    <tr>
      <td height="28">Group Results </td>
      <td><select name="group_1" id="group_1">
        <option value="0" <? if ($_POST["group_1"] == "0") echo "selected=\"selected\"";?>>No Group</option>
        <option value="inity_insurance_type" <? if ($_POST["group_1"] == "inity_insurance_type") echo "selected=\"selected\"";?>>Insurance Type</option>
        <option value="inag_agent_code" <? if ($_POST["group_1"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent Code</option>
      </select>
       #2 
       <select name="group_2" id="group_2">
        <option value="0" <? if ($_POST["group_2"] == "0") echo "selected=\"selected\"";?>>No Group</option>
        <option value="inity_insurance_type" <? if ($_POST["group_2"] == "inity_insurance_type") echo "selected=\"selected\"";?>>Insurance Type</option>
        <option value="inag_agent_code" <? if ($_POST["group_2"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent Code</option>
       </select>      </td>
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
echo $table_data;
?>
</div>
<?
$db->show_footer();
?>