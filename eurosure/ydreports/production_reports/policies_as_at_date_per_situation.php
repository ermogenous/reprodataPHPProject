<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();

//=============================================================================================================

if ($_POST["action"] == "submit") {

	$klado_exclude = "";
	if ($_POST["klado_exclude"] != "") {
		$klado_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["klado_exclude"]."'";
	}

	$klado = "";
	if ($_POST["klado_from"] != "") {
		$klado = "AND inity_insurance_type >= '".$_POST["klado_from"]."'
AND inity_insurance_type <= '".$_POST["klado_to"]."'
	";
	}//klado
	
	$agents = "";
	if ($_POST["agent_from"] != "") {
		$agents = "AND inag_agent_code >= '".$_POST["agent_from"]."' 
AND inag_agent_code <= '".$_POST["agent_to"]."'";
	}
	
	//create grouping filtering
	$into_sql = "";
	$grouping_sql = "";

	if ($_POST["group_1"] != '0') {
		$into_sql = "INTO #temp_table";
		$group_1 = $_POST["group_1"].",";
		
		if ($_POST["group_2"] != '0') {
			$group_2 = $_POST["group_2"].",";
			$group_group = "GROUP BY ".$group_1.$_POST["group_2"];
			$group_order = "ORDER BY ".$group_1.$_POST["group_2"];
		}
		else {
			$group_group = "GROUP BY ".$_POST["group_1"];
			$group_order = "ORDER BY ".$_POST["group_1"];
		}
		
		if ($_POST["group_1"] == "totals") {
			$group_1 = "";
			$group_group = "";
			$group_order = "";
		}
		if ($_POST["group_2"] == "totals") {
			$group_2 = "";
			//$group_group = "";
			//$group_order = "";
		}		
		
		$grouping_sql = "
			SELECT
			".$group_1."
			".$group_2."
			COUNT() as total_policies,
			SUM(inpvsdt_active_phase_pr)as total_active_phase_premium,
			SUM(clo_earned_in_previous_phases)as total_previous_phases_premium,
			SUM(inpvsdt_active_phase_pr + clo_earned_in_previous_phases)as total_premium,
			SUM(clo_items_count)as total_items,
			SUM(clo_situation_count) as total_situations,
			SUM(clo_treaty_not_reinsured_premium)as total_not_reinsured_premium,
			SUM(clo_insured_amount)as total_insured_amount
			FROM #temp_table
			".$group_group."
			".$group_order;
		
	}

$sql = "
SELECT  
1 as clo_policy_count,
ininsurancetypes.inity_insurance_type ,
ininsurancetypes.inity_long_description ,
COALESCE(inpvsdt_as_at_date, Date(Now())) as clo_as_at_date,
YEAR(clo_as_at_date) * 100 + MONTH(clo_as_at_date) As clo_as_at_period,
inpol_starting_date,
inpol_period_starting_date,
inpol_expiry_date,
inpolicies.inpol_policy_number ,
inpolicies.inpol_policy_serial ,
inpst_situation_code,
inpst_name,
inpst_surname,
inpolicies_asat_date.inpvsdt_active_phase_pr ,           
-1 * COALESCE((SELECT SUM(b.inped_premium * b.inped_premium_debit_credit) FROM inpolicies a JOIN inpolicyendorsement b ON a.inpol_policy_serial = b.inped_policy_serial WHERE a.inpol_policy_number = inpolicies.inpol_policy_number AND a.inpol_period_starting_date = inpolicies.inpol_period_starting_date AND a.inpol_policy_serial < inpolicies.inpol_policy_serial AND b.inped_status = '1'), 0) as clo_earned_in_previous_phases,
(SELECT -1 * SUM(inped_premium_debit_credit * (IF inldg_loading_type <> 'X' AND inlsc_ldg_rsrv_under_reinsurance <> 'Y' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as inpae_treaty_reinsured_premium FROM inpolicyloadings as plg JOIN inloadings as ldg ON inldg_loading_serial = inplg_loading_serial LEFT OUTER JOIN inloadingstatcodes as lsc on inldg_claim_reserve_group = inlsc_pcode_serial LEFT OUTER JOIN inpolicyendorsement as ped on inplg_policy_serial = inped_policy_serial WHERE inplg_policy_serial = inpolicies.inpol_policy_serial)as clo_treaty_not_reinsured_premium,
(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = inpolicies.inpol_policy_serial)as clo_situation_count,
inagents.inag_agent_code,
(incl_first_name + ' ' + incl_long_description) as clo_client_name,
(select incd_long_description from inpcodes WHERE incd_pcode_serial = incl_nationality)as clo_client_nationality,


(select
-1 * SUM(inpolicyendorsement.inped_premium_debit_credit * (IF ldg.inldg_loading_type <> 'X' THEN IF inpolicyendorsement.inped_premium_debit_credit = -1 THEN plg.inplg_period_premium ELSE plg.inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as clo_premium
FROM inpolicyendorsement
JOIN inpolicies as pol ON pol.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs
JOIN inpolicyitems as pit ON inpolicyendorsement.inped_policy_serial = pit.inpit_policy_serial
LEFT OUTER JOIN inpolicyitemaux as aux ON aux.inpia_pit_auto_serial = pit.inpit_pit_auto_serial
JOIN initems as itm ON itm.initm_item_serial = pit.inpit_item_serial
JOIN inpolicyloadings as plg ON pit.inpit_pit_auto_serial = plg.inplg_pit_auto_serial
JOIN inloadings as ldg ON ldg.inldg_loading_serial = plg.inplg_loading_serial
LEFT OUTER JOIN inreinsurancetreaties ON pit.inpit_reinsurance_treaty = inreinsurancetreaties.inrit_reinsurance_treaty_serial

where
1=1
AND pol.inpol_policy_number = inpolicies.inpol_policy_number
AND pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date
)as clo_premium_all_periods




".$into_sql."

FROM ininsurancetypes 
LEFT OUTER JOIN inmajorcodes ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code 
LEFT OUTER JOIN inminorcodes ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code            
JOIN inpolicies ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN inclients ON incl_client_serial = inpol_client_serial
JOIN inpolicysituations ON inpol_policy_serial = inpst_policy_serial
,inagents ,          
ingeneralagents ,           
inpolicies_asat_date ,           



WHERE 
inagents.inag_agent_serial = inpolicies.inpol_agent_serial
and ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and ( inpolicies_asat_date.inpvsdt_policy_serial = inpolicies.inpol_policy_serial ) 
and (inpvsdt_status = 'N' and (inpvsdt_year * 100 + inpvsdt_period <= clo_as_at_period) ) 


".$agents."
".$klado_exclude."
".$klado."

GROUP BY inpolicies_asat_date.inpvsdt_as_at_date ,
ininsurancetypes.inity_insurance_type ,
ininsurancetypes.inity_long_description ,
ininsurancetypes.inity_insurance_type_serial ,
inpolicies.inpol_policy_serial ,           
inpolicies.inpol_policy_number ,           
inpolicies.inpol_period_starting_date ,           
inpolicies_asat_date.inpvsdt_active_phase_pr,
inagents.inag_agent_code,
incl_long_description,
incl_first_name,
incl_nationality,
inpol_starting_date,
inpol_period_starting_date,
inpol_expiry_date
,inpst_situation_code
,inpst_name
,inpst_surname

ORDER BY inpolicies.inpol_policy_number ASC

".$grouping_sql;
//echo $sql;
//export_data_delimited($sql,'sybase','#','none','download','
//');

$sybase->query("INSERT INTO ccuserparameters (ccusp_user_date,ccusp_user_identity)VALUES('".$db->convert_date_format($_POST["as_at_date"],'dd/mm/yyyy','yyyy-mm-dd')."' ,'INTRANET')");


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
      <td colspan="2" align="center">Policies Index As At Date </td>
    </tr>
    <tr>
      <td width="154" height="28">As At Date </td>
      <td width="380"><input name="as_at_date" type="text" id="as_at_date" value="<? echo $_POST["as_at_date"];?>"> 
      dd/mm/yyyy</td>
    </tr>
    
    <tr>
      <td height="28">Agents</td>
      <td>From
        <input name="agent_from" type="text" id="agent_from" value="<? echo $_POST["agent_from"];?>" size="8" />
To
<input name="agent_to" type="text" id="agent_to" value="<? echo $_POST["agent_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Insurance Type  </td>
      <td>From
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["klado_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["klado_exclude"];?>"/>
      (exclude) ex 17% </td>
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
       </select>
      </td>
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