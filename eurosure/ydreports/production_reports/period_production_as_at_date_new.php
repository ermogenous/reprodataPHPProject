<?
ini_set('max_execution_time', 600);
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../functions/production.php");

include("../functions/production_class.php");
include("../../tools/export_data.php");
$sybase = new Sybase();


if ($_POST["action"] == 'submit') {
	
	$prod = new synthesis_production();
	//insert the years/periods
	$prod->as_at_date = $db->convert_date_format($_POST["as_at_date"],"dd/mm/yyyy","yyyy-mm-dd");
	$prod->up_to_period = $_POST["up_to_period"];
	$prod->up_to_year = $_POST["up_to_year"];

	$prod->as_at_sql();
	
	$prod->add_agents();
	$prod->add_clients();
	$prod->add_insurance_types();
	$prod->add_majors();
	
	if ($_POST["per_policy"] == 'item_code') {
		//add item premium
		//$prod->add_per_item_premium_from_loadings();
		$prod->add_per_item_premium_without_loadings();
		
	}

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
	$prod->insert_group('inpva_process_status');
	$prod->insert_group('inpva_status');
	
	
	//SORTS
	for ($i=1; $i<=3; $i++) {
		if ($_POST["sort_".$i] != 'NONE') {
	
			$fields = explode("|",$_POST["sort_".$i]);
			//specific sort`s
			//insert the field to the sql
			//echo "<hr>".$fields[0]."<hr>";
			//$prod->insert_select($fields[0]);

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
				

				$prod->insert_outer_select("COUNT(DISTINCT(inpst_situation_code))","Total_Unique_Situation_Codes");
				$prod->insert_outer_select("SUM(clo_item_premium)","Item_Premium");
				$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number))","Total_Unique_Policies");
				
				$prod->insert_outer_sort("clo_per_situation_age","ASC");
				
				
				$show_premiums = 0;
			}
			else {
				$prod->insert_select_group($fields[0]);
			}
			
			if ($_POST["sort_".$i."_from"] != "" && $_POST["sort_".$i."_to"] != "") {
				$prod->insert_where("AND ".$fields[0]." BETWEEN '".$_POST["sort_".$i."_from"]."' AND '".$_POST["sort_".$i."_to"]."'");	
			}		
			//outer
			$prod->insert_outer_select_group($fields[0],$fields[1]);
			$prod->insert_outer_sort($fields[1],'ASC');
			
			//extra columns
			if ($fields[0] == 'inag_agent_code' || $fields[0] == 'inag_group_code') {
				$prod->insert_select_group('inag_long_description');
				$prod->insert_outer_select('MAX(inag_long_description)','Agent_Name');
			}
			
		}//if sort not empty
			
	}//loop in all sort by

	$prod->insert_select_group('inpol_policy_number');
	$prod->insert_select_group('inpol_policy_serial');
	$prod->insert_select("fn_return_period_premium(inpol_policy_serial,'ONLYCURRENTPERIOD','NET')",'clo_net_period_premium');
	$prod->insert_select("fn_return_policy_insured_amount(inpol_policy_serial)",'clo_insured_amount');

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
	else if ($_POST["per_policy"] == 'item_code') {

		$prod->insert_outer_select_group('inpol_policy_number','Policy_Number');
		$prod->insert_outer_sort('Policy_Number');

		$prod->add_policy_items();
		$prod->add_items();
		$prod->insert_select_group("initm_item_code");
		$prod->insert_outer_select_group('initm_item_code','Item_Code');
		$prod->insert_select_group('inpit_pit_auto_serial');
		$prod->insert_outer_group('inpit_pit_auto_serial');
		$prod->insert_outer_sort('Item_Code');
		//disable premiums
		$show_premiums = 0;
		$prod->insert_outer_select("SUM(clo_item_premium)","Item_Premium");
		$prod->insert_select("fn_return_policy_insured_amount(inpol_policy_serial,default,default,default,default,inpit_pit_auto_serial)",'clo_pit_insured_amount');
		$prod->insert_outer_select("SUM(clo_pit_insured_amount)","Item_Insured_Amount");
		
		//add the item insured amount
		//cannot use insured amount because it will generate double entries due to policy endorsement.
		//to fix this need to use if to find the actual record
		//$prod->insert_select_group("inpit_insured_amount");
		//$prod->insert_outer_select_group("inpit_insured_amount","Item_Insured_Amount");
	}
	
	//insert premium totals
	if ($show_premiums == 1) {
		$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number))","Num_Of_Policy_Numbers");
		$prod->insert_outer_select("COUNT(inpol_policy_serial)","Num_Of_Policy_Serials");
		$prod->insert_outer_select("SUM(clo_net_period_premium)","Net_Period_Premium");
		
		//situation/item totals
		$prod->insert_select("(SELECT COUNT() FROM inpolicyitems WHERE inpit_policy_serial = inpol_policy_serial)","clo_total_items");
		$prod->insert_select("(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)","clo_total_situations");
		$prod->insert_outer_select("SUM(clo_total_items)","Total_Items");
		$prod->insert_outer_select("SUM(clo_total_situations)","Total_Situations");
		$prod->insert_outer_select("SUM(clo_insured_amount)","Insured_Amount");
	}
	
	//client unique ids
	if ($_POST["client_unique_ids"] == 1) {
		$prod->insert_select_group('incl_identity_card');
		$prod->insert_outer_select('COUNT(DISTINCT(incl_identity_card))','Count_Unique_Client_IDs');
	}

	//specific policy number
	if ($_POST["policy_number"] != "") {
		$prod->insert_where("AND inpol_policy_number ='".$_POST["policy_number"]."'");
	}
	
	if ($_POST["policy_insured_amount"] == 1) {
		$prod->insert_select_group('inpol_insured_amount','clo_policy_insured_amount');
		$prod->insert_outer_select('SUM(clo_policy_insured_amount)','Policy_Insured_Amount');
	}
	


$prod->generate_sql();
$sql = $prod->return_sql();

//echo str_replace('\n','<br>',$sql);exit();

	if ($_POST["admin_show_sql"] == 1) {
		$db->admin_echo($db->prepare_text_as_html($sql));
	}

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
	$_POST["cancellation"] = 0;
	$_POST["lapsed"] = 0;
}

$db->show_header();
?>
<form name="form1" method="post" action="">
  <table width="743" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr>
      <td colspan="3" align="center"><strong>Policies/Production As At Date Report</strong></td>
    </tr>
    <tr>
      <td width="244">As At Date</td>
      <td width="347"><input name="as_at_date" type="text" id="as_at_date" value="<? echo $_POST["as_at_date"];?>" size="10" tabindex="1" />
        dd/mm/yyyy</td>
      <td width="152" rowspan="12" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
          <td width="81%"><strong>Status</strong></td>
          <td width="19%">&nbsp;</td>
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
      <td>Up To Period</td>
      <td>Period
        <input name="up_to_period" type="text" id="up_to_period" size="6" maxlength="2" value="<? echo $_POST["up_to_period"];?>" tabindex="3">
      Year        <input name="up_to_year" type="text" id="up_to_year" size="8" maxlength="4" value="<? echo $_POST["up_to_year"];?>" tabindex="4"></td>
    </tr>
    <tr>
      <td align="center"><strong>Sort By</strong></td>
      <td align="center">&nbsp;</td>
    </tr>
<?
$i=0;

$sorts[$i]["value"] = "NONE";
$sorts[$i]["label"] = "NONE";
$i++;

$sorts[$i]["value"] = "inag_agent_code|Agent_Code";
$sorts[$i]["label"] = "Agents Code";
$i++;

$sorts[$i]["value"] = "inag_group_code|Agent_Group_Code";
$sorts[$i]["label"] = "Agents Group Code";
$i++;

$sorts[$i]["value"] = "inity_insurance_type|Insurance_Type";
$sorts[$i]["label"] = "Insurance Type";
$i++;

$sorts[$i]["value"] = "inity_major_category|Major";
$sorts[$i]["label"] = "Major";
$i++;

$sorts[$i]["value"] = "clo_drivers_num_found|Learner_Driver_Num";
$sorts[$i]["label"] = "Learner Driver On Policy Num (Not Client)";
$i++;

$sorts[$i]["value"] = "clo_per_situation_age|Situation_Age";
$sorts[$i]["label"] = "Situation Age";
$i++;


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
      <input name="sort_1_to" type="text" id="sort_1_to" value="<? echo $_POST["sort_1_to"];?>" size="12" /></td>
    </tr>
    <tr>
      <td>2: 
        <select name="sort_2" id="sort_2" style="width:200px">
			<? show_sorts(2); ;?>
        </select></td>
      <td>From
        <input name="sort_2_from" type="text" id="sort_2_from" value="<? echo $_POST["sort_from_2"];?>" size="12" />
        To
      <input name="sort_2_to" type="text" id="sort_2_to" value="<? echo $_POST["sort_to_2"];?>" size="12" /></td>
    </tr>
    <tr>
      <td>3: 
        <select name="sort_3" id="sort_3" style="width:200px">
			<? show_sorts(3); ;?>
        </select></td>
      <td>From
        <input name="sort_3_from" type="text" id="sort_3_from" value="<? echo $_POST["sort_3_from"];?>" size="12" />
        To
      <input name="sort_3_to" type="text" id="sort_3_to" value="<? echo $_POST["sort_3_to"];?>" size="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Per Policy/Situation</td>
      <td><select name="per_policy" id="per_policy">
        <option value="NO" <? if ($_POST["per_policy"] == 'NO') echo "selected=\"selected\"";?>>NO</option>
        <option value="policy_number" <? if ($_POST["per_policy"] == 'policy_number') echo "selected=\"selected\"";?>>Per Policy Number</option>
        <option value="policy_serial" <? if ($_POST["per_policy"] == 'policy_serial') echo "selected=\"selected\"";?>>Per Policy Phase(Serial)</option>        
        <option value="item_code" <? if ($_POST["per_policy"] == 'item_code') echo "selected=\"selected\"";?>>Per Item Code</option>
      </select></td>
    </tr>
    <tr>
      <td>Specific Policy Number</td>
      <td><input type="text" name="policy_number" id="policy_number" value="<? echo $_POST["policy_number"];?>"/></td>
    </tr>
    <tr>
      <td>Count Unique Client ID`s</td>
      <td><input name="client_unique_ids" type="checkbox" id="client_unique_ids" value="1" <? if ($_POST["client_unique_ids"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td>Policy Insured Amount</td>
      <td><input name="policy_insured_amount" type="checkbox" id="policy_insured_amount" value="1" <? if ($_POST["policy_insured_amount"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="submit">
      <? if ($db->user_data["usr_user_rights"] == 0) { ?>Show Sql
        <input name="admin_show_sql" type="checkbox" id="admin_show_sql" value="1" <? if ($_POST["admin_show_sql"] == 1) echo "checked=\"checked\"";?> /><? } ?></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<div id="print_view_section_html"><br />

<?
if ($_POST["action"] == "submit") {

	echo export_data_html_table($sql,'sybase',"align=\"center\" border=\"1\"");
}
?>
</div>
<?
$db->show_footer();
?>
