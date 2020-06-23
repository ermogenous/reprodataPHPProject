<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../functions/production.php");

include("../functions/production_class.php");
include("../../tools/export_data.php");
$sybase = new Sybase();

//validate form for errors.
if ($_POST["action"] == 'submit') {
$error = -1;
	if ($_POST["per_policy"] != 'per_loading_premium') {
		if ($_POST["filter_by"] == 'peril.incd_record_code' || $_POST["filter_by"] == 'inldg_loading_code') {
			$error = 'To be able to filter with peril or loading code must break down per loading/peril';
		}
	}
	
}


if ($_POST["action"] == 'submit' && $error == -1) {
		
	$disable_auto_group = 0;
	$prod = new synthesis_production();
	//insert the years/periods
	$prod->from_year = $_POST["year_from"];
	$prod->to_year = $_POST["year_to"];
	$prod->from_period = $_POST["period_from"];
	$prod->to_period = $_POST["period_to"];

	//get the production sql (not as at)
	$prod->policy_sql();
	
	$prod->add_agents();
	$prod->add_general_agents();
	$prod->add_clients();
	$prod->add_insurance_types();
	$prod->add_majors();
	
	//outer sql
	$prod->enable_outer_select();
	
	$show_premiums = 1;
	//status
	$status = "";
	$_POST["quotation"] == 1 ? $status .= "'Q'," : '';
	$_POST["outstanding"] == 1 ? $status .= "'O'," : '';
	$_POST["confirmed"] == 1 ? $status .= "'C'," : '';
	$_POST["normal"] == 1 ? $status .= "'N'," : '';
	$_POST["archived"] == 1 ? $status .= "'A'," : '';
	$_POST["deleted"] == 1 ? $status .= "'D'," : '';
	$prod->clo_status = $db->remove_last_char($status);
	
	//process status
	$process_status = "";
	$_POST["new"] == 1 ? $process_status .= "'N',": '';
	$_POST["renewal"] == 1 ? $process_status .= "'R',": '';
	$_POST["endorsement"] == 1 ? $process_status .= "'E',": '';
	$_POST["declaration"] == 1 ? $process_status .= "'D',": '';
	$_POST["cancellation"] == 1 ? $process_status .= "'C',": '';
	$_POST["lapsed"] == 1 ? $process_status .= "'L',": '';
	$prod->clo_process_status = $db->remove_last_char($process_status);
	
	
	//SORTS
	for ($i=1; $i<=3; $i++) {
		$disable_auto_group = 0;
		if ($_POST["sort_".$i] != 'NONE') {
	
			$fields = explode("|",$_POST["sort_".$i]);
			//specific sort`s		
			if ($fields[0] == 'clo_drivers_num_found') {
				$prod->add_policy_drivers_learners_num();
				$prod->insert_group('inpol_policy_serial');
			}
			else if ($fields[0] == 'clo_per_situation_age') {
				$prod->add_per_situation_premium_from_loadings();
				$prod->insert_select("floor(fn_datediff('year',inpst_birthdate,inpol_starting_date))","clo_per_situation_age");
				$prod->insert_select_group("inpst_situation_code");
				$prod->insert_group("inpst_birthdate");
				$prod->insert_group("inpol_starting_date");
				
				
				if ($_POST["per_policy"] == "NO") {
					$prod->insert_outer_select("COUNT(DISTINCT(inpst_situation_code))","Total_Unique_Situation_Codes");
					
					$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number))","Total_Unique_Policies");
				}
				else {
					$prod->insert_outer_select("inpol_policy_number","Policy_Number");
					$prod->insert_outer_select_group("inped_process_status","Process_Status");
					$prod->insert_outer_select("SUM(clo_loading_premium)","Loadings_Premium");
				}
				
				$prod->insert_outer_sort("clo_per_situation_age","ASC");
				
				
				$show_premiums = 0;
			}
			else if ($fields[0] == 'inped_process_status') {

				//Do Nothing
				
			}
			else if ($fields[0] == 'clo_motor_non_motor') {

				$prod->insert_select_group("IF inity_major_category = '19' THEN 'Motor' ELSE 'Non-Motor' ENDIF","clo_motor_non_motor");
				
			}
			else if ($fields[0] == 'clo_package_code') {
				$prod->insert_select('(SELECT LIST(DISTINCT(inpst_package_code)) FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)','clo_package_code');
				//$prod->insert_outer_select('clo_item_code','Item_Code');
				$prod->insert_outer_sort('Package_Code','ASC');
			}
			else if ($fields[0] == 'clo_template_code') {
				$prod->add_templates();
				$prod->insert_select_group("intmpl_template_code","clo_template_code");
			}
			else if ($fields[0] == 'clo_total_items') {
				$prod->insert_select('inpol_policy_serial');
				$prod->insert_select('(SELECT COUNT() FROM inpolicyitems WHERE inpit_policy_serial = inpol_policy_serial)','clo_total_items');
				$prod->insert_outer_select("SUM(clo_total_items)",'Total_Items');
				$disable_auto_group = 1;
			}
			else if ($fields[0] == 'clo_total_situations') {
				$prod->insert_select('(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)','clo_total_situations');
				$prod->insert_outer_select("SUM(clo_total_situations)",'Total_Situations');
				$disable_auto_group = 1;
			}
			else if ($fields[0] == 'inag_agent_code'){
				$prod->insert_select_group('inag_agent_code');
				$prod->insert_select_group('inag_long_description');
				$prod->insert_outer_select_group($fields[0],$fields[1]);
				$prod->insert_outer_sort($fields[1],'ASC');
				$prod->insert_outer_select_group('inag_long_description','Agent_Name');
				$prod->insert_outer_sort('Agent_Name','ASC');
				$disable_auto_group = 1;
			}
			else if ($fields[0] == 'inag_group_code') {
				$disable_auto_group = 1;
				$prod->insert_select_group($fields[0]);
				$prod->insert_outer_select_group($fields[0],$fields[1]);
				$prod->insert_outer_sort($fields[1],'ASC');
				$prod->insert_select_group('inag_long_description');
				$prod->insert_outer_select('MAX(inag_long_description)','Agent_Name');
			}
			else if ($fields[0] == 'cancel_endorse_breakdown') {
				$prod->insert_select('inpol_policy_serial');
				$prod->add_cancel_endorsement_process_status();
				$prod->insert_outer_select_group("clo_cancel_end_process_status","Canc_End_Process_status");
				$prod->insert_outer_sort($fields[1],'ASC');	
				$disable_auto_group = 1;
			}
			else {
				$prod->insert_select_group($fields[0]);
			}
			
			if ($_POST["sort_".$i."_from"] != "" && $_POST["sort_".$i."_to"] != "") {
				$not = '';
				if ($_POST["sort_".$i."_not"] == 1) {
					$not = ' NOT ';
				}
				$prod->insert_where("AND ".$fields[0].$not." BETWEEN '".$_POST["sort_".$i."_from"]."' AND '".$_POST["sort_".$i."_to"]."'");	
			}
			
			
			//outer
			if ($disable_auto_group == 0) {
				if ($_POST["sort_".$i."_not_group"] != 1) {
					$prod->insert_outer_select_group($fields[0],$fields[1]);
					$prod->insert_outer_sort($fields[1],'ASC');
				}
			}
			
		}
			
	}

	if ($_POST["exclude_cancel_out_of_period"] == 1) {
		$prod->insert_where("
		and (
		IF inped_process_status = 'C' THEN 
			IF (SELECT inpol_policy_year * 100 + inpol_policy_period FROM inpolicies as pol WHERE pol.inpol_policy_serial = fn_get_period_first_policy_serial(inpolicies.inpol_policy_serial)) 
				BETWEEN ".($_POST["year_from"] * 100 + $_POST["period_from"])." AND ".($_POST["year_to"] * 100 + $_POST["period_to"])." THEN 1 
			ELSE 0 
			ENDIF
		ELSE 1 
		ENDIF) = 1");
		
	}
	if ($_POST["exclude_endorsements_out_of_period"] == 1) {
		$prod->insert_where("
		and (
		IF inped_process_status = 'E' THEN 
			IF (SELECT inpol_policy_year * 100 + inpol_policy_period FROM inpolicies as pol WHERE pol.inpol_policy_serial = fn_get_period_first_policy_serial(inpolicies.inpol_policy_serial)) 
				BETWEEN ".($_POST["year_from"] * 100 + $_POST["period_from"])." AND ".($_POST["year_to"] * 100 + $_POST["period_to"])." THEN 1 
			ELSE 0 
			ENDIF
		ELSE 1 
		ENDIF) = 1");
	}
	
	$prod->insert_select_group('inpol_policy_number');
	$prod->insert_select_group('inpol_policy_serial');

//per policy number
	if ($_POST["per_policy"] == 'policy_number') {
		$prod->insert_outer_select_group('inpol_policy_number','Policy_Number');
		$prod->insert_outer_sort('Policy_Number');
	}
//per policy phase
	else if ($_POST["per_policy"] == 'policy_serial') {
		$prod->insert_outer_select_group('inpol_policy_serial','Policy_Serial');
		$prod->insert_outer_select_group('inpol_policy_number','Policy_Number');
		$prod->insert_outer_sort('Policy_Number,Policy_Serial');
	}
	else if ($_POST["per_policy"] == 'per_loading_premium') {
		$show_premiums = 0;
		$prod->add_per_item_premium_from_loadings();
		//get the peril
		$prod->insert_from('JOIN inpcodes as peril ON inldg_claim_reserve_group = peril.incd_pcode_serial',1);
		$prod->insert_select_group('peril.incd_long_description','clo_peril_description');
		$prod->insert_select_group("inity_major_category");
		//$prod->insert_select("inpol_policy_number");
		
		$prod->insert_outer_select_group('clo_peril_description','Peril');
		$prod->insert_outer_select('SUM(clo_loading_premium)','Loading_Premium');		
		$prod->insert_outer_select('SUM(clo_commission_total)','Commission');
		$prod->insert_outer_select('COUNT(DISTINCT(inpol_policy_number))','Total_Unique_Policies');
	}

	if ($_POST["count_unique_vehicles"] == 1) {
		$prod->add_policy_items();
		$prod->add_items();
		$prod->insert_select_group('initm_item_code');
		if ($_POST["remove_cancellations"] == 1) {
			$prod->insert_outer_select("COUNT(DISTINCT(IF inped_process_status = 'C' THEN null ELSE inpol_policy_number + initm_item_code ENDIF))","Total_Vehicles");
			$prod->insert_outer_select("COUNT(DISTINCT(IF inped_process_status = 'C' THEN null ELSE inpol_policy_serial ENDIF))",'Num_Of_Policies_Phases');
			$prod->insert_outer_select("COUNT(DISTINCT(IF inped_process_status = 'C' THEN null ELSE inpol_policy_number ENDIF))","Num_Of_Policy_Numbers");
		}
		else {
			$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number + initm_item_code))","Total_Vehicles");
			$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_serial))",'Num_Of_Policies_Phases');
			$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number))","Num_Of_Policy_Numbers");
		}
		$show_premiums = 0;
	}
	
	if ($_POST["lapse_period_premium"] == 1) {
		
		$prod->insert_select("fn_return_period_premium(inpol_policy_serial,'UPTOCURRENT','NET')",'clo_lapsed_period_premium');
		$prod->insert_outer_select('SUM(clo_lapsed_period_premium)','Full_Period_Premium');
		
	}//lapse_period_premium
	
	if ($_POST["medical_policy_type"] == 1) {
		$prod->insert_select_group("COALESCE((SELECT IF inity_insurance_type = '1101' THEN inpst_packing_description ELSE 'OTHER' ENDIF as clo_type FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial GROUP BY clo_type),'OTHER')",'clo_medical_policy_type');
		$prod->insert_outer_select_group('clo_medical_policy_type','Med_Policy_Type');
	}
	
	//insert premium totals
	if ($show_premiums == 1) {
		if ($_POST["remove_cancellations"] == 1) {
			$prod->insert_outer_select("COUNT(DISTINCT(IF inped_process_status = 'C' THEN null ELSE inpol_policy_serial ENDIF))",'Num_Of_Policies_Phases');
			$prod->insert_outer_select("COUNT(DISTINCT(IF inped_process_status = 'C' THEN null ELSE inpol_policy_number ENDIF))","Num_Of_Policy_Numbers");
		}else {
			$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_serial))",'Num_Of_Policies_Phases');
			$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number))","Num_Of_Policy_Numbers");
		}
		$prod->insert_outer_select("SUM(clo_premium)",'Net Premium');
		$prod->insert_outer_select("SUM(clo_period_mif)",'MIF');
		$prod->insert_outer_select("SUM(clo_period_fees)",'Fees');
		$prod->insert_outer_select("SUM(clo_period_stamps)",'Stamps');
		$prod->insert_outer_select("SUM(clo_commission)",'Commission');
		$prod->insert_outer_select("SUM(clo_premium + clo_period_mif + clo_period_fees + clo_period_stamps)",'Gross Premium');
	}
	
	//add filter
	if ($_POST["filter_by"] != 'NONE') {
	
		if ($_POST["filter_type"] == 'IN' || $_POST["filter_type"] == 'NOT IN') {
			$parts = explode("\n",$_POST["filter_value"]);
			$value_filter = "(";
			foreach($parts as $value) {
				
				$value = preg_replace( "/\r|\n/", "", $value );
				
				if ($value != "") {
					$value_filter .= "'".$value."',";
				}
			}
			$value_filter = $db->remove_last_char($value_filter).")";
		}
		else {
			$value_filter = "'".$_POST["filter_value"]."'";
		}
		
		//fixes based on the filter.
		if ($_POST["filter_by"] == "clo_cancel_end_process_status"){
			$prod->add_cancel_endorsement_process_status();
			$prod->insert_outer_where("AND ".$_POST["filter_by"]." ".$_POST["filter_type"]." ".stripslashes($value_filter));
		}
		else {
			$prod->insert_where("AND ".$_POST["filter_by"]." ".$_POST["filter_type"]." ".stripslashes($value_filter));
		}
		
		
	}
	
	//enable if fac exists
	if ($_POST["show_fac_exists"] == 1) {
		$prod->add_find_fac_in_policy();
		$prod->insert_group("inpol_last_endorsement_serial");
		
		//insert for the outer
		$prod->insert_outer_select("SUM(clo_fac_found)","FAC_FOUND");
		
		if ($_POST["show_fac_filter"] == 'fac'){
			$prod->insert_outer_where("AND clo_fac_found = 1");
		}
		else if ($_POST["show_fac_filter"] == 'no_fac'){
			$prod->insert_outer_where("AND clo_fac_found = 0");
		}
		
	}//enable if fac exists

//add extra fields
	if ($_POST["new_column_fire_type"] == 1) {
		$prod->insert_from('LEFT OUTER JOIN inpolicyanalysis ON inpol_policy_serial = inpan_policy_serial',1);
		$prod->insert_from('LEFT OUTER JOIN inpcodes as instat ON inpan_analysis_serial = instat.incd_pcode_serial',1);
		
		//add the column
		$prod->insert_select_group("IF instat.incd_long_description is null AND inity_major_category = '17' THEN 'Private' ELSE instat.incd_long_description ENDIF",'clo_risk_type_description');
		$prod->insert_outer_select_group('clo_risk_type_description','Risk_Type');
	}

$prod->generate_sql();
$sql = $prod->return_sql();

	if ($_POST["show_sql"] == 1) {
		echo $db->prepare_text_as_html($sql);
	}
	
//$db->admin_echo($sql);
}//form submit
else {
	//defaults
	//status
	$_POST["quotation"] = 0;	
	$_POST["outstanding"] = 0;	
	$_POST["confirmed"] = 0;	
	$_POST["normal"] = 1;	
	$_POST["archived"] = 1;	
	
	//process status
	$_POST["new"] = 1;
	$_POST["renewal"] = 1;
	$_POST["endorsement"] = 1;
	$_POST["declaration"] = 1;
	$_POST["cancellation"] = 1;
	$_POST["lapsed"] = 1;
}

$db->show_header();
?>
<div id="print_view_section_html">
<p style="color:#F00; font-size:22px;" align="center">
<? 
if ($error != -1) {
	echo $error;
}
?>
&nbsp;</p>
<form name="form1" method="post" action="">
  <table width="920" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr>
      <td colspan="3" align="center">Period Production Report </td>
    </tr>
    <tr>
      <td width="233">Year</td>
      <td width="556"><input name="year_from" type="text" id="year_from" value="<? echo $_POST["year_from"];?>" size="6" tabindex="1" />
        UpTo
          <input name="year_to" type="text" id="year_to" value="<? echo $_POST["year_to"];?>" size="6" tabindex="2" /></td>
      <td width="131" rowspan="18" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><strong>Process Status</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>New</td>
          <td><input name="new" type="checkbox" id="new" value="1" <? if ($_POST["new"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Renewal</td>
          <td><input name="renewal" type="checkbox" id="renewal" value="1" <? if ($_POST["renewal"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Endorsement</td>
          <td><input name="endorsement" type="checkbox" id="endorsement" value="1" <? if ($_POST["endorsement"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Declaration Adj.</td>
          <td><input name="declaration" type="checkbox" id="declaration" value="1" <? if ($_POST["declaration"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Cancellation</td>
          <td><input name="cancellation" type="checkbox" id="cancellation" value="1" <? if ($_POST["cancellation"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Lapsed</td>
          <td><input name="lapsed" type="checkbox" id="lapsed" value="1" <? if ($_POST["lapsed"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="83%"><strong>Status</strong></td>
          <td width="17%">&nbsp;</td>
        </tr>
        <tr>
          <td>Quotation</td>
          <td><input name="quotation" type="checkbox" id="quotation" value="1" <? if ($_POST["quotation"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Outstanding</td>
          <td><input name="outstanding" type="checkbox" id="outstanding" value="1" <? if ($_POST["outstanding"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Confirmed</td>
          <td><input name="confirmed" type="checkbox" id="confirmed" value="1" <? if ($_POST["confirmed"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Normal</td>
          <td><input name="normal" type="checkbox" id="normal" value="1" <? if ($_POST["normal"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Archived</td>
          <td><input name="archived" type="checkbox" id="archived" value="1" <? if ($_POST["archived"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Deleted</td>
          <td><input name="deleted" type="checkbox" id="deleted" value="1" <? if ($_POST["deleted"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>Period</td>
      <td><input name="period_from" type="text" id="period_from" size="6" maxlength="2" value="<? echo $_POST["period_from"];?>" tabindex="3">
        UpTo
      <input name="period_to" type="text" id="period_to" size="6" maxlength="2" value="<? echo $_POST["period_to"];?>" tabindex="4"></td>
    </tr>
    <tr>
      <td align="center"><strong>Sort By</strong></td>
      <td align="center">&nbsp;</td>
    </tr>
<?
$sorts[0]["value"] = "NONE";
$sorts[0]["label"] = "NONE";

$sorts[1]["value"] = "inag_agent_code|Agent_Code";
$sorts[1]["label"] = "Agents Code";

$sorts[2]["value"] = "inity_insurance_type|Insurance_Type";
$sorts[2]["label"] = "Insurance Type";

$sorts[3]["value"] = "inity_major_category|Major";
$sorts[3]["label"] = "Major";

$sorts[4]["value"] = "clo_drivers_num_found|Learner_Driver_Num";
$sorts[4]["label"] = "Learner Driver On Policy Num (Not Client)";

$sorts[5]["value"] = "clo_per_situation_age|Situation_Age";
$sorts[5]["label"] = "Situation Age";

$sorts[6]["value"] = "inpol_cover|Policy_Cover";
$sorts[6]["label"] = "Policy Cover";

$sorts[7]["value"] = "inag_group_code|Agent_Group_Code";
$sorts[7]["label"] = "Agent Group Code";

$sorts[8]["value"] = "inped_process_status|Process_Status";
$sorts[8]["label"] = "Process Status";

$sorts[9]["value"] = "clo_motor_non_motor|MotorNonMotor";
$sorts[9]["label"] = "Motor/Non Motor";

$sorts[10]["value"] = "inga_agent_code|GeneralAgentCode";
$sorts[10]["label"] = "General Agent Code";

$sorts[11]["value"] = "clo_package_code|Package_Code";
$sorts[11]["label"] = "Package Code List";

$sorts[12]["value"] = "clo_total_items|Total_Items";
$sorts[12]["label"] = "Total Items";

$sorts[13]["value"] = "clo_total_situations|Total_Situations";
$sorts[13]["label"] = "Total Situations";

$sorts[14]["value"] = "cancel_endorse_breakdown|Canc_End_Process_status";
$sorts[14]["label"] = "Cancellation/Endorsement Process Status";

$sorts[15]["value"] = "inpol_policy_number|Policy_Number";
$sorts[15]["label"] = "Policy Number";

$sorts[16]["value"] = "clo_template_code|Template_Code";
$sorts[16]["label"] = "Template Code";



function show_sorts($num) {
global $sorts;
	foreach($sorts as $value) {
		echo "<option value=\"".$value["value"]."\" ";
		if ($_POST["sort_".$num] == $value["value"]) {
			echo "selected=\"selected\"";	
		}
		echo ">".$value["label"]."</option>\n";
	}
}
?>
    <tr>
      <td>1: 
        <select name="sort_1" id="sort_1" style="width:200px">
			<? show_sorts(1); ;?>
      </select></td>
      <td>From
        <input name="sort_1_from" type="text" id="sort_1_from" value="<? echo $_POST["sort_1_from"];?>" size="12" />
        To
      <input name="sort_1_to" type="text" id="sort_1_to" value="<? echo $_POST["sort_1_to"];?>" size="12" /> 
      NOT
      <input name="sort_1_not" type="checkbox" id="sort_1_not" value="1" <? if ($_POST["sort_1_not"] == 1) echo "checked=\"checked\"";?>/>
      NO GROUP
      <input name="sort_1_not_group" type="checkbox" id="sort_1_not_group" value="1" <? if ($_POST["sort_1_not_group"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>2: 
        <select name="sort_2" id="sort_2" style="width:200px">
			<? show_sorts(2); ;?>
        </select></td>
      <td>From
        <input name="sort_2_from" type="text" id="sort_2_from" value="<? echo $_POST["sort_2_from"];?>" size="12" />
        To
      <input name="sort_2_to" type="text" id="sort_2_to" value="<? echo $_POST["sort_2_to"];?>" size="12" />
      NOT
      <input name="sort_2_not" type="checkbox" id="sort_2_not" value="1" <? if ($_POST["sort_2_not"] == 1) echo "checked=\"checked\"";?>/>
      NO GROUP
      <input name="sort_2_not_group" type="checkbox" id="sort_2_not_group" value="1" <? if ($_POST["sort_2_not_group"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>3: 
        <select name="sort_3" id="sort_3" style="width:200px">
			<? show_sorts(3); ;?>
        </select></td>
      <td>From
        <input name="sort_3_from" type="text" id="sort_3_from" value="<? echo $_POST["sort_3_from"];?>" size="12" />
        To
      <input name="sort_3_to" type="text" id="sort_3_to" value="<? echo $_POST["sort_3_to"];?>" size="12" />
      NOT
      <input name="sort_3_not" type="checkbox" id="sort_3_not" value="1" <? if ($_POST["sort_3_not"] == 1) echo "checked=\"checked\"";?>/>
      NO GROUP
      <input name="sort_3_not_group" type="checkbox" id="sort_3_not_group" value="1" <? if ($_POST["sort_3_not_group"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Filter By 
        <select name="filter_by" id="filter_by" style="width:250px">
          <option value="NONE"  <? if ($_POST["filter_by"] == 'NONE') echo 'selected=\"selected\"';?>>NONE</option>
          <option value="inity_insurance_type"  <? if ($_POST["filter_by"] == 'inity_insurance_type') echo 'selected=\"selected\"';?>>Insurance Type</option>
          <option value="inag_agent_code"  <? if ($_POST["filter_by"] == 'inag_agent_code') echo 'selected=\"selected\"';?>>Agent Code</option>
          <option value="inag_group_code"  <? if ($_POST["filter_by"] == 'inag_group_code') echo 'selected=\"selected\"';?>>Agent Group Code</option>
          <option value="inity_major_category"  <? if ($_POST["filter_by"] == 'inity_major_category') echo 'selected=\"selected\"';?>>Major Category</option>
          <option value="inldg_loading_code"  <? if ($_POST["filter_by"] == 'inldg_loading_code') echo 'selected=\"selected\"';?>>Loading Code</option>
          <option value="peril.incd_record_code"  <? if ($_POST["filter_by"] == 'peril.incd_record_code') echo 'selected=\"selected\"';?>>Peril Code</option>
          <option value="clo_cancel_end_process_status"  <? if ($_POST["filter_by"] == 'clo_cancel_end_process_status') echo 'selected=\"selected\"';?>>Cancellation/Endorsement Process status</option>
        </select></td>
      <td valign="middle"><select name="filter_type" id="filter_type">
        <option value="IN" <? if ($_POST["filter_type"] == 'IN') echo 'selected=\"selected\"';?>>IN</option>
        <option value="NOT IN" <? if ($_POST["filter_type"] == 'NOT IN') echo 'selected=\"selected\"';?>>NOT IN</option>
        <option value="LIKE" <? if ($_POST["filter_type"] == 'LIKE') echo 'selected=\"selected\"';?>>LIKE</option>
        <option value="NOT LIKE" <? if ($_POST["filter_type"] == 'NOT LIKE') echo 'selected=\"selected\"';?>>NOT LIKE</option>
        <option value="=" <? if ($_POST["filter_type"] == '=') echo 'selected=\"selected\"';?>>=</option>
        <option value="&lt;&gt;" <? if ($_POST["filter_type"] == '&lt;&gt;') echo 'selected=\"selected\"';?>>&lt;&gt;</option>
        <option value="&gt;" <? if ($_POST["filter_type"] == '&gt;') echo 'selected=\"selected\"';?>>&gt;</option>
        <option value="&lt;" <? if ($_POST["filter_type"] == '&lt;') echo 'selected=\"selected\"';?>>&lt;</option>
        <option value="&gt;=" <? if ($_POST["filter_type"] == '&gt;=') echo 'selected=\"selected\"';?>>&gt;=</option>
        <option value="&lt;=" <? if ($_POST["filter_type"] == '&lt;=') echo 'selected=\"selected\"';?>>&lt;=</option>
      </select>
        <textarea name="filter_value" id="filter_value" cols="50" rows="2"><? echo stripslashes($_POST["filter_value"]);?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Per Policy</td>
      <td><select name="per_policy" id="per_policy">
        <option value="NO" <? if ($_POST["per_policy"] == 'NO') echo "selected=\"selected\"";?>>NO</option>
        <option value="policy_number" <? if ($_POST["per_policy"] == 'policy_number') echo "selected=\"selected\"";?>>Per Policy Number</option>
        <option value="policy_serial" <? if ($_POST["per_policy"] == 'policy_serial') echo "selected=\"selected\"";?>>Per Policy Phase(Serial)</option>
        <option value="per_loading_premium" <? if ($_POST["per_policy"] == 'per_loading_premium') echo "selected=\"selected\"";?>>Break Down per loading Peril Premium</option>
      </select></td>
    </tr>
    <tr>
      <td>Extra Fields</td>
      <td>Count Unique Vehicles*
        <input name="count_unique_vehicles" type="checkbox" id="count_unique_vehicles" value="1" <? if ($_POST["count_unique_vehicles"] == 1) echo "checked=\"checked\"";?> />
Count Situations
<input type="checkbox" name="count_situations" id="count_situations" <? if ($_POST["count_situations"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Remove Cancellations From Policy/Vehicle Totals 
        <input name="remove_cancellations" type="checkbox" id="remove_cancellations" value="1" <? if ($_POST["remove_cancellations"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>Show If FAC Exists 
        <input name="show_fac_exists" type="checkbox" id="show_fac_exists" value="1" <? if ($_POST["show_fac_exists"] == 1) echo "checked=\"checked\"";?>/>
        <select name="show_fac_filter" id="show_fac_filter" style="width:70px">
          <option value="all" <? if ($_POST["show_fac_filter"] == 'all') echo "selected=\"selected\"";?>>All</option>
          <option value="fac" <? if ($_POST["show_fac_filter"] == 'fac') echo "selected=\"selected\"";?>>Only FAC</option>
          <option value="no_fac" <? if ($_POST["show_fac_filter"] == 'no_fac') echo "selected=\"selected\"";?>>No FAC</option>
        </select></td>
      <td>Extra Column Full Period Premium upto Current Phase
        
        [Full_Period_Premium]
        <input name="lapse_period_premium" type="checkbox" id="lapse_period_premium" value="1" <? if ($_POST["lapse_period_premium"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Include Medical Policy Type (Individual/Group)
        <input name="medical_policy_type" type="checkbox" id="medical_policy_type" value="1" <? if ($_POST["medical_policy_type"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Exclude Cancellations that their New/Renewal is out of the period.
        <input name="exclude_cancel_out_of_period" type="checkbox" id="exclude_cancel_out_of_period" value="1" <? if ($_POST["exclude_cancel_out_of_period"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Exclude Endorsements that their New/Renewal is out of the period.
        <input name="exclude_endorsements_out_of_period" type="checkbox" id="exclude_endorsements_out_of_period" value="1" <? if ($_POST["exclude_endorsements_out_of_period"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Add Fire Private/Commercial etc buildings column 
        <input name="new_column_fire_type" type="checkbox" id="new_column_fire_type" value="1" <? if ($_POST["new_column_fire_type"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="81%"><p>* Calculates the unique vehicle registration found per policy number and not across the report. </p>
              <p>Note: This report does not get live data. Its data is refreshed every night.</p></td>
            <td width="19%" align="right"><? if ($db->user_data["usr_user_rights"] == 0) { ?>Show Sql
              <input name="show_sql" type="checkbox" id="show_sql" value="1" <? if ($_POST["show_sql"] == 1) echo "checked=\"checked\"";?> /><? } ?></td>
          </tr>
        </table></td>
      </tr>
  </table>
</form>

<br />

<?
if ($_POST["action"] == "submit" && $error == -1) {

	echo export_data_html_table($sql,'sybase',"align=\"center\" border=\"1\"");
}
?>
</div>
<?
$db->show_footer();
?>
