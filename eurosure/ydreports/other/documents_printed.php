<?
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
	
	//Documents Type
	$_POST["certificate_d"] == 1 ? $doctype .= "'CD'," : '';
	$_POST["schedule_d"] == 1 ? $doctype .= "'SCH'," : '';
	$_POST["cancellation_d"] == 1 ? $doctype .= "'CNL'," : '';
	$_POST["endorsement_d"] == 1 ? $doctype .= "'END'," : '';
	$_POST["covernote_d"] == 1 ? $doctype .= "'CVN'," : '';
	$_POST["quotation_d"] == 1 ? $doctype .= "'QUOT'," : '';
	$doctype = $db->remove_last_char($doctype);
	
	
	//SORTS
	for ($i=1; $i<=3; $i++) {
		if ($_POST["sort_".$i] != 'NONE') {
	
			$fields = explode("|",$_POST["sort_".$i]);
			//specific sort`s		
			if ($fields[0] == 'clo_process_status') {

				//Do Nothing
				
			}
			else if ($fields[0] == 'clo_motor_non_motor') {

				$prod->insert_select_group("IF inity_major_category = '19' THEN 'Motor' ELSE 'Non-Motor' ENDIF","clo_motor_non_motor");
				
			}
			
			else {
				if ($fields[2] != 1) {
					$prod->insert_select($fields[0]);
				}
				$prod->insert_group($fields[0]);
			}
			
			if ($_POST["sort_".$i."_from"] != "" && $_POST["sort_".$i."_to"] != "") {
				$prod->insert_where("AND ".$fields[0]." BETWEEN '".$_POST["sort_".$i."_from"]."' AND '".$_POST["sort_".$i."_to"]."'");	
			}		
			//outer
			if ($fields[3] != 1) {
				$prod->insert_outer_select_group($fields[0],$fields[1]);
				
			}
			else {
				$prod->insert_outer_group($fields[1]);
			}
			
			$prod->insert_outer_sort($fields[1],'ASC');
			
		}
			
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
	else {
		$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_serial))",'Num_Of_Policies_Phases');
		$prod->insert_outer_select("COUNT(DISTINCT(inpol_policy_number))","Num_Of_Policy_Numbers");
	}


	if ($_POST["schedule_d"] == 1) {
		$prod->insert_select("(SELECT COALESCE(SUM(indpl_print_copies),0) FROM indocumprnlog WHERE indpl_document_type = 'SCH' AND indpl_primary_serial = inpol_policy_serial AND indpl_withdrawn_on is null)" , 'clo_print_schedules');
		$prod->insert_outer_select("SUM(clo_print_schedules)","Print_ORG_Schedules");
	}

	if ($_POST["covernote_d"] == 1) {
		$prod->insert_select("(SELECT COALESCE(SUM(indpl_print_copies),0) FROM indocumprnlog WHERE indpl_document_type = 'CVN' AND indpl_primary_serial = inpol_policy_serial AND indpl_withdrawn_on is null)" , 'clo_print_schedules');
		$prod->insert_outer_select("SUM(clo_print_schedules)","Print_ORG_Schedules");
	}
	if ($_POST["certificate_d"] == 1) {
		$prod->insert_select("(SELECT COALESCE(SUM(indpl_print_copies),0) FROM indocumprnlog WHERE indpl_document_type = 'CRT' AND indpl_primary_serial = inpol_policy_serial AND indpl_withdrawn_on is null)" , 'clo_print_schedules');
		$prod->insert_outer_select("SUM(clo_print_schedules)","Print_ORG_Schedules");
	}
		if ($_POST["endorsement_d"] == 1) {
		$prod->insert_select("(SELECT COALESCE(SUM(indpl_print_copies),0) FROM indocumprnlog WHERE indpl_document_type = 'END' AND indpl_primary_serial = inpol_policy_serial AND indpl_withdrawn_on is null)" , 'clo_print_schedules');
		$prod->insert_outer_select("SUM(clo_print_schedules)","Print_ORG_Schedules");
	}
	
			if ($_POST["quotation_d"] == 1) {
		$prod->insert_select("(SELECT COALESCE(SUM(indpl_print_copies),0) FROM indocumprnlog WHERE indpl_document_type = 'QUOT' AND indpl_primary_serial = inpol_policy_serial AND indpl_withdrawn_on is null)" , 'clo_print_schedules');
		$prod->insert_outer_select("SUM(clo_print_schedules)","Print_ORG_Schedules");
	}
	
				if ($_POST["cancelation_d"] == 1) {
		$prod->insert_select("(SELECT COALESCE(SUM(indpl_print_copies),0) FROM indocumprnlog WHERE indpl_document_type = 'CNL' AND indpl_primary_serial = inpol_policy_serial AND indpl_withdrawn_on is null)" , 'clo_print_schedules');
		$prod->insert_outer_select("SUM(clo_print_schedules)","Print_ORG_Schedules");
	}
	


$prod->generate_sql();
$sql = $prod->return_sql();
echo $sql;
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
	
	//Document Types
	$_POST["schedule_d"] = 1;
	$_POST["endorsement_d"] = 1;
}

$db->show_header();
?>
<div id="print_view_section_html">
<form name="form1" method="post" action="">
  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr>
      <td colspan="3" align="center">Period Production Report </td>
    </tr>
    <tr>
      <td width="252">Year</td>
      <td width="423"><input name="year_from" type="text" id="year_from" value="<? echo $_POST["year_from"];?>" size="6" tabindex="1" />
        UpTo
          <input name="year_to" type="text" id="year_to" value="<? echo $_POST["year_to"];?>" size="6" tabindex="2" /></td>
      <td width="175" rowspan="11" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><strong>Select Document Type</strong></td>
          </tr>
        <tr>
          <td>Certificate</td>
          <td><input name="certificate_d" type="checkbox" id="certificate_d" value="1" <? if ($_POST["certificate_d"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Cancellation</td>
          <td><input name="cancellation_d" type="checkbox" id="cancellation_d" value="1" <? if ($_POST["cancellation_d"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Schedule</td>
          <td><input name="schedule_d" type="checkbox" id="schedule_d" value="1" <? if ($_POST["schedule_d"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Endorsement</td>
          <td><input name="endorsement_d" type="checkbox" id="endorsement_d" value="1" <? if ($_POST["endorsement_d"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Covernote</td>
          <td><input name="covernote_d" type="checkbox" id="covernote_d" value="1" <? if ($_POST["covernote_d"] == 1) echo "checked=\"checked\"";?> /></td>
        </tr>
        <tr>
          <td>Quotation</td>
          <td><input name="quotation_d" type="checkbox" id="quotation_d" value="1" <? if ($_POST["quotation_d"] == 1) echo "checked=\"checked\"";?> /></td>
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

//value = inner_SQL name | outer_sql_name | exclude from inner select | exclude from outer select
//label = the label show on the drop down menu.
$sorts[0]["value"] = "NONE";
$sorts[0]["label"] = "NONE";

$sorts[1]["value"] = "inag_agent_code|Agent_Code";
$sorts[1]["label"] = "Agents Code";

$sorts[2]["value"] = "inity_insurance_type|Insurance_Type";
$sorts[2]["label"] = "Insurance Type";

$sorts[3]["value"] = "inity_major_category|Major";
$sorts[3]["label"] = "Major";

$sorts[4]["value"] = "inpol_cover|Policy_Cover";
$sorts[4]["label"] = "Policy Cover";

$sorts[5]["value"] = "inag_group_code|Agent_Group_Code";
$sorts[5]["label"] = "Agent Group Code";

$sorts[6]["value"] = "clo_process_status|Process_Status";
$sorts[6]["label"] = "Process Status";

$sorts[7]["value"] = "clo_motor_non_motor|MotorNonMotor";
$sorts[7]["label"] = "Motor/Non Motor";

$sorts[8]["value"] = "inga_agent_code|GeneralAgentCode";
$sorts[8]["label"] = "General Agent Code";

$sorts[9]["value"] = "clo_print_schedules|Print_ORG_Schedules|1|1";
$sorts[9]["label"] = "Total Schedules";


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
        <input name="sort_2_from" type="text" id="sort_2_from" value="<? echo $_POST["sort_2_from"];?>" size="12" />
        To
      <input name="sort_2_to" type="text" id="sort_2_to" value="<? echo $_POST["sort_2_to"];?>" size="12" /></td>
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
      <td>Per Policy</td>
      <td><select name="per_policy" id="per_policy">
        <option value="NO" <? if ($_POST["per_policy"] == 'NO') echo "selected=\"selected\"";?>>NO</option>
        <option value="policy_number" <? if ($_POST["per_policy"] == 'policy_number') echo "selected=\"selected\"";?>>Per Policy Number</option>
        <option value="policy_serial" <? if ($_POST["per_policy"] == 'policy_serial') echo "selected=\"selected\"";?>>Per Policy Phase(Serial)</option>
      </select></td>
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
      <td><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
    </table>
</form>

<br />

<?
if ($_POST["action"] == "submit") {

	echo export_data_html_table($sql,'sybase',"align=\"center\" border=\"1\"");
}
?>
</div>
<?
$db->show_footer();
?>
