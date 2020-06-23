<?
ini_set("memory_limit","128M");
set_time_limit(60);
include("../../include/main.php");
$db = new Main(1,'UTF-8');
include("../../include/sybasecon.php");

include("../functions/claims.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');


if ($_POST["action"] == "show") {
	
	$_POST["from_date"] = $db->convert_date_format($_POST["from_date"],'dd/mm/yyyy','yyyy-mm-dd');
	$_POST["as_at_date"] = $db->convert_date_format($_POST["as_at_date"],'dd/mm/yyyy','yyyy-mm-dd');
	$_POST["open_date_from"] = $db->convert_date_format($_POST["open_date_from"],'dd/mm/yyyy','yyyy-mm-dd');
	$_POST["open_date_to"] = $db->convert_date_format($_POST["open_date_to"],'dd/mm/yyyy','yyyy-mm-dd');
	
	$claims = new synthesis_claims($_POST["from_date"],$_POST["as_at_date"]);

	//statuses
	$claims->clo_process_status = '';
	$claims->clm_status = '';
	if ($_POST["preliminary"] == 1) {
		$claims->clo_process_status .= "'P',";
	}
	if ($_POST["outstanding"] == 1) {
		$claims->clo_process_status .= "'O',";
	}
	if ($_POST["withdrawn"] == 1) {
		$claims->clo_process_status .= "'W',";
	}
	if ($_POST["recovery"] == 1) {
		$claims->clo_process_status .= "'R',";
	}
	if ($_POST["closed"] == 1) {
		$claims->clo_process_status .= "'C',";
	}
	if ($_POST["initial"] == 1) {
		$claims->clo_process_status .= "'I',";
	}
	if ($_POST["open"] == 1) {
		$claims->clm_status .= "'O',";
	}
	if ($_POST["archived"] == 1) {
		$claims->clm_status .= "'A',";
	}
	if ($_POST["deleted"] == 1) {
		$claims->clm_status .= "'D',";
	}
	$claims->clo_process_status = $db->remove_last_char($claims->clo_process_status);
	$claims->clm_status = $db->remove_last_char($claims->clm_status);
	
	
	$claims->add_policies();
	
	$claims->add_insurance_types();
	$claims->insert_select_group('inity_insurance_type','Insurance_Type');
	$claims->insert_select_group('inity_major_category','Major_Category');
	
	$claims->add_agents();
	$claims->insert_select_group('inag_agent_code','Agent_Code');
	$claims->insert_select_group('inag_group_code','Agent_Group_Code');
	
	$claims->add_driver();
	$claims->insert_driver_details();
	
	$claims->add_clients();
	$claims->insert_select_group('incl_postal_code','Client_Postal_Code');
	$claims->insert_select_group('LEFT(incl_postal_code,2)','Client_Postal_Code_2d');
	
	$claims->insert_select_group('LEFT(incl_postal_code,1)','Client_Postal_Code_1d');
	
	
	
	$claims->enable_outer_select();

	//insert the number of claims
	$claims->insert_outer_select('COUNT()','Total_Claims');
	
	//form parameters
	//sort 1
	
	for ($i=1; $i<=3; $i++) {
		
		if ($_POST["sort".$i] != 'none') {
			
			if ($_POST["sort_".$i."_not_group"] != 1) {
				$claims->insert_outer_select_group($_POST["sort".$i]);
				$claims->insert_outer_sort($_POST["sort".$i],'ASC');
			}
			
			if ($_POST["sort".$i."_from"] != ""  && $_POST["sort".$i."_to"] != ""){
				
				$not = '';
				if ($_POST["sort_".$i."_not"] == 1) {
					$not = ' NOT ';
				}
				$claims->insert_where("AND ".$_POST["sort".$i].$not." BETWEEN '".$_POST["sort".$i."_from"]."' AND '".$_POST["sort".$i."_to"]."'");
			}
			
			if ($_POST["sort".$i] == "Client_Postal_Code") {
				$claims->insert_outer_select('(SELECT LIST(DISTINCT(ccpc_community_munic_gr)) FROM ccpostcodes WHERE ccpc_postal_code = Client_Postal_Code)','Client_Postal_Name');
				$claims->insert_outer_group('Client_Postal_Name');
			}
			
			if ($_POST["sort".$i] == "Policy_Cover") {
				$claims->insert_select_group('inpol_cover','Policy_Cover');
				$claims->insert_outer_select_group('Policy_Cover');
			}

			if ($_POST["sort".$i] == "Policy_Process_Status") {
				$claims->insert_select_group('inpol_process_status','Policy_Process_Status');
				$claims->insert_outer_select_group('Policy_Process_Status');
			}
			
			if ($_POST["sort".$i] == "Policy_New_Renewal") {
				
				$claims->insert_select("(SELECT pol.inpol_process_status FROM inpolicies as pol WHERE pol.inpol_policy_number = inpolicies.inpol_policy_number AND pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date AND pol.inpol_process_status IN ('N','R') AND pol.inpol_status <> 'D')","Policy_New_Renewal");
				$claims->insert_outer_select_group('Policy_New_Renewal');
				$claims->insert_group('inpol_policy_number');
				$claims->insert_group('inpol_period_starting_date');

			}
			
			if ($_POST["sort".$i] == "Situation_Age") {
				$claims->add_policy_situation();
				$claims->insert_select("floor(fn_datediff('year',inpst_birthdate,inclm_open_date))",'Situation_Age');
				$claims->insert_group('inpst_birthdate');
				$claims->insert_outer_select_group('Situation_Age');
			}
			if ($_POST["sort".$i] == "Peril_Code") {
				$claims->add_peril_group();
				$claims->insert_select_group('peril.incd_record_code','Peril_Code');
				$claims->insert_outer_select_group('Peril_Code');
			}

			
			
		}
	}
	//show per claim
	if ($_POST["show_per_claim"] == 1) {
		$claims->insert_select_group('inclm_claim_number','Claim_Number');
		$claims->insert_select_group('inclm_claim_serial','Claim_Serial');
		$claims->insert_select_group('inpol_policy_number','Policy_Number');
		$claims->insert_outer_select_group('Claim_Number');
		$claims->insert_outer_select_group('Claim_Serial');
		$claims->insert_outer_select_group('Policy_Number');
	}

	//show per policy
	if ($_POST["show_per_policy"] == 1) {
		$claims->insert_select_group('inpol_policy_number','Policy_Number');
		$claims->insert_select_group('inpol_policy_serial','Policy_Serial');
		$claims->insert_outer_select_group('Policy_Number');
		$claims->insert_outer_select_group('Policy_Serial');
	}
	
	if ($_POST["show_per_peril"] == 1) {
		$claims->add_peril_group();
		$claims->insert_select_group('peril.incd_long_description','clo_peril_description');
		$claims->insert_select_group('peril.incd_record_code','clo_peril_code');
		
		$claims->insert_outer_select_group('clo_peril_description','Peril');
		$claims->insert_outer_select_group('clo_peril_code','Peril_Code');
		
		$claims->insert_outer_sort('Peril_Code','ASC');
		
	}
	
	//show claim dates
	if ($_POST["show_claim_dates"] == 1) {
		
		$claims->insert_select_group("inclm_date_of_event","Date_of_Event");
		$claims->insert_select_group("inclm_claim_date","Claim_Date");
		
		$claims->insert_outer_select_group('Date_of_Event','Date_of_Event');
		$claims->insert_outer_select_group('inclm_claim_date','Claim_Date');
		
	}
	
	//claim open date
	if ($_POST["open_date_from"] != "" && $_POST["open_date_to"] != "") {
		$claims->insert_open_date($_POST["open_date_from"],$_POST["open_date_to"]);
	}
	
	if ($_POST["new_column_fire_type"] == 1) {
		$claims->insert_from('LEFT OUTER JOIN inpolicyanalysis ON inpol_policy_serial = inpan_policy_serial',1);
		$claims->insert_from('LEFT OUTER JOIN inpcodes as instat ON inpan_analysis_serial = instat.incd_pcode_serial',1);
		
		$claims->insert_select_group("IF instat.incd_long_description is null AND inity_major_category = '17' THEN 'Private' ELSE instat.incd_long_description ENDIF",'clo_risk_type_description');
		$claims->insert_outer_select_group("clo_risk_type_description",'Risk_Type');
	}
	
	if ($_POST["medical_groups"] == 1) {
		$claims->insert_select("COALESCE((SELECT IF inity_insurance_type IN ('1101','1102') THEN inpst_packing_description ELSE 'OTHER' ENDIF as clo_type FROM inpolicysituations WHERE inpst_situation_serial = inclm_situation_serial GROUP BY clo_type),'OTHER')",'clo_medical_policy_type');
		$claims->insert_group('clo_medical_policy_type');
		
		$claims->insert_outer_select_group('clo_medical_policy_type','Medical_Type');

	}
	
	$claims->insert_outer_res_pay_totals();
	$claims->generate_sql();
	$sql = $claims->return_sql();
	$sybase->query("INSERT INTO ccuserparameters (ccusp_user_date,ccusp_user_identity)VALUES('".$_POST["as_at_date"]."' ,'ERMOGEN')");

	if ($_POST["show_sql"] == 1) {
		$db->admin_echo($db->prepare_text_as_html($sql));
	}
	
}
else {

	$_POST["preliminary"] = 1;
	$_POST["outstanding"] = 1;
	$_POST["withdrawn"] = 1;
	$_POST["recovery"] = 1;
	$_POST["closed"] = 1;
	$_POST["initial"] = 0;
	$_POST["open"] = 1;
	$_POST["archived"] = 1;
	$_POST["deleted"] = 1;
	
	$_POST["from_date"] = date("Y").'-01-01';
	$_POST["as_at_date"] = date("Y").'-01-31';
		
}



$db->show_header();

?>
<script>

$(document).ready(function() {

$("#from_date").datepicker({dateFormat: 'dd/mm/yy'});
$("#as_at_date").datepicker({dateFormat: 'dd/mm/yy'});
$("#open_date_from").datepicker({dateFormat: 'dd/mm/yy'});
$("#open_date_to").datepicker({dateFormat: 'dd/mm/yy'});
});

</script>
<div id="print_view_section_html">
<form name="form1" method="post" action="" onsubmit="document.getElementById('button').disabled = true;">
  <table width="768" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr>
      <td colspan="6" align="center"><strong>Claims Report</strong></td>
    </tr>
    <tr>
      <td width="220">From Date</td>
      <td colspan="3"><input type="text" name="from_date" id="from_date" value="<? echo $db->convert_date_format($_POST["from_date"],'yyyy-mm-dd','dd/mm/yyyy');?>"></td>
      <td colspan="2" align="center"><p><strong>Process Status</strong></p></td>
    </tr>
    <tr>
      <td>As At Date</td>
      <td colspan="3"><input type="text" name="as_at_date" id="as_at_date" value="<? echo $db->convert_date_format($_POST["as_at_date"],'yyyy-mm-dd','dd/mm/yyyy');?>"></td>
      <td width="85"><label for="preliminary">Preliminary</label></td>
      <td width="54" align="center"><input name="preliminary" type="checkbox" id="preliminary" value="1" <? if ($_POST["preliminary"] == 1) echo "checked";?>></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td><label for="outstanding">Outstanding</label></td>
      <td align="center"><input name="outstanding" type="checkbox" id="outstanding" value="1" <? if ($_POST["outstanding"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td>Claim Open Date</td>
      <td colspan="3"><input name="open_date_from" type="text" id="open_date_from" value="<? echo $db->convert_date_format($_POST["open_date_from"],'yyyy-mm-dd','dd/mm/yyyy');?>" size="10" />
        To
      <input name="open_date_to" type="text" id="open_date_to" value="<? echo $db->convert_date_format($_POST["open_date_to"],'yyyy-mm-dd','dd/mm/yyyy');?>" size="10" /></td>
      <td><label for="withdrawn">Withdrawn</label></td>
      <td align="center"><input name="withdrawn" type="checkbox" id="withdrawn" value="1" <? if ($_POST["withdrawn"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td><label for="recovery">Recovery</label></td>
      <td align="center"><input name="recovery" type="checkbox" id="recovery" value="1" <? if ($_POST["recovery"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Sort By</strong></td>
      <td><label for="closed">Closed</label></td>
      <td align="center"><input name="closed" type="checkbox" id="closed" value="1" <? if ($_POST["closed"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td><select name="sort1" id="sort1" style="width:175px">
        <option value="none" <? if ($_POST["sort1"] == "none") echo "selected";?>>None</option>
        <option value="Major_Category" <? if ($_POST["sort1"] == "Major_Category") echo "selected";?>>Major Category</option>
        <option value="Insurance_Type" <? if ($_POST["sort1"] == "Insurance_Type") echo "selected";?>>Insurance Type</option>
        <option value="Agent_Code" <? if ($_POST["sort1"] == "Agent_Code") echo "selected";?>>Agent Code</option>
        <option value="Agent_Group_Code" <? if ($_POST["sort1"] == "Agent_Group_Code") echo "selected";?>>Agent Group Code</option>
        <option value="clo_driver_age" <? if ($_POST["sort1"] == "clo_driver_age") echo "selected";?>>Driver Age</option>
        <option value="clo_driver_license_age" <? if ($_POST["sort1"] == "clo_driver_license_age") echo "selected";?>>License Age</option>
        <option value="clo_driver_is_learner" <? if ($_POST["sort1"] == "clo_driver_is_learner") echo "selected";?>>Driver Is Learner (1 Or 0)</option>
        <option value="Client_Postal_Code" <? if ($_POST["sort1"] == "Client_Postal_Code") echo "selected";?>>Client Postal Code</option>
        <option value="Client_Postal_Code_2d" <? if ($_POST["sort1"] == "Client_Postal_Code_2d") echo "selected";?>>Client Postal Code First 2 Digits</option>
        <option value="Client_Postal_Code_1d" <? if ($_POST["sort1"] == "Client_Postal_Code_1d") echo "selected";?>>Client Postal Code First 1 Digit</option>
        <option value="Policy_Cover" <? if ($_POST["sort1"] == "Policy_Cover") echo "selected";?>>Policy Cover</option>
        <option value="Policy_Process_Status" <? if ($_POST["sort1"] == "Policy_Process_Status") echo "selected";?>>Policy Process Status</option>
        <option value="Policy_New_Renewal" <? if ($_POST["sort1"] == "Policy_New_Renewal") echo "selected";?>>Policy New Renewal</option>
        <option value="Situation_Age" <? if ($_POST["sort1"] == "Situation_Age") echo "selected";?>>Situation Age</option>
        <option value="Peril_Code" <? if ($_POST["sort1"] == "Peril_Code") echo "selected";?>>Peril Code</option>
        
      </select></td>
      <td colspan="3"><input name="sort1_from" type="text" id="sort1_from" value="<? echo $_POST["sort1_from"];?>" size="10">
        To
      <input name="sort1_to" type="text" id="sort1_to" value="<? echo $_POST["sort1_to"];?>" size="10">
      NOT
        <input name="sort_1_not" type="checkbox" id="sort_1_not" value="1" <? if ($_POST["sort_1_not"] == 1) echo "checked=\"checked\"";?>/>
NO GROUP
<input name="sort_1_not_group" type="checkbox" id="sort_1_not_group" value="1" <? if ($_POST["sort_1_not_group"] == 1) echo "checked=\"checked\"";?>/></td>
      <td><label for="initial">Initial</label></td>
      <td align="center"><input name="initial" type="checkbox" id="initial" value="1" <? if ($_POST["initial"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td><select name="sort2" id="sort2" style="width:175px">
        <option value="none" <? if ($_POST["sort2"] == "none") echo "selected";?>>None</option>
        <option value="Major_Category" <? if ($_POST["sort2"] == "Major_Category") echo "selected";?>>Major Category</option>
        <option value="Insurance_Type" <? if ($_POST["sort2"] == "Insurance_Type") echo "selected";?>>Insurance Type</option>
        <option value="Agent_Code" <? if ($_POST["sort2"] == "Agent_Code") echo "selected";?>>Agent Code</option>
        <option value="Agent_Group_Code" <? if ($_POST["sort2"] == "Agent_Group_Code") echo "selected";?>>Agent Group Code</option>
        <option value="clo_driver_age" <? if ($_POST["sort2"] == "clo_driver_age") echo "selected";?>>Driver Age</option>
        <option value="clo_driver_license_age" <? if ($_POST["sort2"] == "clo_driver_license_age") echo "selected";?>>License Age</option>
        <option value="clo_driver_is_learner" <? if ($_POST["sort2"] == "clo_driver_is_learner") echo "selected";?>>Driver Is Learner (1 Or 0)</option>
        <option value="Client_Postal_Code" <? if ($_POST["sort2"] == "Client_Postal_Code") echo "selected";?>>Client Postal Code</option>
        <option value="Client_Postal_Code_2d" <? if ($_POST["sort2"] == "Client_Postal_Code_2d") echo "selected";?>>Client Postal Code First 2 Digits</option>
        <option value="Client_Postal_Code_1d" <? if ($_POST["sort2"] == "Client_Postal_Code_1d") echo "selected";?>>Client Postal Code First 1 Digit</option>
        <option value="Policy_Cover" <? if ($_POST["sort2"] == "Policy_Cover") echo "selected";?>>Policy Cover</option>
        <option value="Policy_Process_Status" <? if ($_POST["sort2"] == "Policy_Process_Status") echo "selected";?>>Policy Process Status</option>
        <option value="Policy_New_Renewal" <? if ($_POST["sort2"] == "Policy_New_Renewal") echo "selected";?>>Policy New Renewal</option>
        <option value="Situation_Age" <? if ($_POST["sort2"] == "Situation_Age") echo "selected";?>>Situation Age</option>
        <option value="Peril_Code" <? if ($_POST["sort2"] == "Peril_Code") echo "selected";?>>Peril Code</option>
      </select></td>
      <td colspan="3"><input name="sort2_from" type="text" id="sort2_from" value="<? echo $_POST["sort2_from"];?>" size="10">
        To
          <input name="sort2_to" type="text" id="sort2_to" value="<? echo $_POST["sort2_to"];?>" size="10">
          NOT
          <input name="sort_2_not" type="checkbox" id="sort_2_not" value="1" <? if ($_POST["sort_2_not"] == 1) echo "checked=\"checked\"";?>/>
NO GROUP
<input name="sort_2_not_group" type="checkbox" id="sort_2_not_group" value="1" <? if ($_POST["sort_2_not_group"] == 1) echo "checked=\"checked\"";?>/></td>
      <td colspan="2"><strong>Claim Status</strong></td>
    </tr>
    <tr>
      <td><select name="sort3" id="sort3" style="width:175px">
        <option value="none" <? if ($_POST["sort3"] == "none") echo "selected";?>>None</option>
        <option value="Major_Category" <? if ($_POST["sort3"] == "Major_Category") echo "selected";?>>Major Category</option>
        <option value="Insurance_Type" <? if ($_POST["sort3"] == "Insurance_Type") echo "selected";?>>Insurance Type</option>
        <option value="Agent_Code" <? if ($_POST["sort3"] == "Agent_Code") echo "selected";?>>Agent Code</option>
        <option value="Agent_Group_Code" <? if ($_POST["sort3"] == "Agent_Group_Code") echo "selected";?>>Agent Group Code</option>
        <option value="clo_driver_age" <? if ($_POST["sort3"] == "clo_driver_age") echo "selected";?>>Driver Age</option>
        <option value="clo_driver_license_age" <? if ($_POST["sort3"] == "clo_driver_license_age") echo "selected";?>>License Age</option>
        <option value="clo_driver_is_learner" <? if ($_POST["sort3"] == "clo_driver_is_learner") echo "selected";?>>Driver Is Learner (1 Or 0)</option>
        <option value="Client_Postal_Code" <? if ($_POST["sort3"] == "Client_Postal_Code") echo "selected";?>>Client Postal Code</option>
        <option value="Client_Postal_Code_2d" <? if ($_POST["sort3"] == "Client_Postal_Code_2d") echo "selected";?>>Client Postal Code First 2 Digits</option>
        <option value="Client_Postal_Code_1d" <? if ($_POST["sort3"] == "Client_Postal_Code_1d") echo "selected";?>>Client Postal Code First 1 Digit</option>
        <option value="Policy_Cover" <? if ($_POST["sort3"] == "Policy_Cover") echo "selected";?>>Policy Cover</option>
        <option value="Policy_Process_Status" <? if ($_POST["sort3"] == "Policy_Process_Status") echo "selected";?>>Policy Process Status</option>
        <option value="Policy_New_Renewal" <? if ($_POST["sort3"] == "Policy_New_Renewal") echo "selected";?>>Policy New Renewal</option>
        <option value="Situation_Age" <? if ($_POST["sort3"] == "Situation_Age") echo "selected";?>>Situation Age</option>
        <option value="Peril_Code" <? if ($_POST["sort3"] == "Peril_Code") echo "selected";?>>Peril Code</option>
      </select></td>
      <td colspan="3"><input name="sort3_from" type="text" id="sort3_from" value="<? echo $_POST["sort3_from"];?>" size="10" />
To
  <input name="sort3_to" type="text" id="sort3_to" value="<? echo $_POST["sort3_to"];?>" size="10" />
NOT
<input name="sort_3_not" type="checkbox" id="sort_3_not" value="1" <? if ($_POST["sort_3_not"] == 1) echo "checked=\"checked\"";?>/>
NO GROUP
<input name="sort_3_not_group" type="checkbox" id="sort_3_not_group" value="1" <? if ($_POST["sort_3_not_group"] == 1) echo "checked=\"checked\"";?>/></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td><label for="open">Open</label></td>
      <td align="center"><input name="open" type="checkbox" id="open" value="1" <? if ($_POST["open"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td>Show Per Claim</td>
      <td><input name="show_per_claim" type="checkbox" id="show_per_claim" value="1" <? if ($_POST["show_per_claim"] == 1) echo "checked";?> /></td>
      <td width="185">Show Claim dates Columns</td>
      <td width="160"><input name="show_claim_dates" type="checkbox" id="show_claim_dates" value="1" <? if ($_POST["show_claim_dates"] == 1) echo "checked";?> /></td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>Show Per Policy</td>
      <td colspan="3"><input name="show_per_policy" type="checkbox" id="show_per_policy" value="1" <? if ($_POST["show_per_policy"] == 1) echo "checked";?>></td>
      <td><label for="archived">Archived</label></td>
      <td align="center"><input name="archived" type="checkbox" id="archived" value="1" <? if ($_POST["archived"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td>Show Per Peril Code</td>
      <td width="64"><input name="show_per_peril" type="checkbox" id="show_per_peril" value="1" <? if ($_POST["show_per_peril"] == 1) echo "checked";?> /></td>
      <td colspan="2">&nbsp;</td>
      <td>Deleted</td>
      <td align="center"><input name="deleted" type="checkbox" id="deleted" value="1" <? if ($_POST["deleted"] == 1) echo "checked";?> /></td>
    </tr>
    <tr>
      <td colspan="4">Include Medical Policy Type (Individual/Group)
        <input name="medical_groups" type="checkbox" id="medical_groups" value="1" <? if ($_POST["medical_groups"] == 1) echo "checked=\"checked\"";?>/></td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Add Fire Private/Commercial etc buildings column
      <input name="new_column_fire_type" type="checkbox" id="new_column_fire_type" value="1" <? if ($_POST["new_column_fire_type"] == 1) echo "checked=\"checked\"";?>/></td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td colspan="3"><input type="submit" name="button" id="button" value="Submit"></td>
      <td colspan="2" align="right"><? if ($db->user_data["usr_user_rights"] == 0) { ?>Show Sql
      <input name="show_sql" type="checkbox" id="show_sql" value="1" <? if ($_POST["show_sql"] == 1) echo "checked";?> /> <? } ?></td>
    </tr>
  </table>
</form>
<?
if ($_POST["action"] == "show") {
	echo export_data_html_table($sql,'sybase');
}
?>
</div>
<?
$db->show_footer();
?>
