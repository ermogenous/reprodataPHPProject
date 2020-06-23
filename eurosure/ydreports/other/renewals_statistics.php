<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 300);
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../include/sybase_sqls.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$db->enable_jquery();
$db->enable_jquery_ui('smoothness');


if ($_POST["action"] == "show") {

	if ($_POST["cover"] == "ALL") {
		$cover = '';
	}
	else {
		$cover = 'AND POLICY_UNDER_STUDY.inpol_cover '.stripslashes($_POST["cover"]);
	}

if ($_POST["range_from"] > 0 && $_POST["range_to"] > 0) {

	$insured_amount_range = "AND POLICY_UNDER_STUDY.inpol_insured_amount BETWEEN ".$_POST["range_from"]." AND ".$_POST["range_to"];

}
else {
	$insured_amount_range = "";
}

if ($_POST["insurance_type"] != "") {
	$major_category = "AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'";
}
else {
	$major_category = "";
}


if ($_POST["insurance_type_exclude"] != "") {
	$major_category_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'";
}
else {
	$major_category_exclude = "";
}

if ($_POST["show"] == 'action' ) {
	$into_sql = "into #temp";	
	$new_sql = "
		SELECT
		inag_agent_code as Agent_Code,
		agent_name as Agent_Name,
		OBSERVATION_STATUS as Action,
		SUM(expl_premium)as Cur_Premium,
		SUM(expl_premium_declaration) as Curr_Declaration,
		SUM(renew_premium)as Ren_Premium
		FROM
		#temp
		GROUP BY
		OBSERVATION_STATUS,
		inag_agent_code,
		agent_name
		ORDER BY
		inag_agent_code,
		OBSERVATION_STATUS";
}
else if ($_POST["show"] == 'insurance_type') {
	$into_sql = "into #temp";	
	$new_sql = "
		SELECT
		inity_insurance_type as Insurance_Type,
		OBSERVATION_STATUS as Action,
		SUM(expl_premium)as Cur_Premium,
		SUM(expl_premium_declaration) as Curr_Declaration,
		SUM(renew_premium)as Ren_Premium
		FROM
		#temp
		GROUP BY
		OBSERVATION_STATUS,
		Insurance_Type
		ORDER BY
		Insurance_Type,
		OBSERVATION_STATUS";
}
$sql = "
SELECT 
EXPIRATION_LIST.*,
       IF COALESCE(POLICY_UNDER_STUDY.inpol_replaced_by_policy_serial, 0) <> 0 THEN POLICY_UNDER_STUDY.inpol_replaced_by_policy_serial 
       ELSE COALESCE((SELECT a.inpol_policy_serial FROM inpolicies a
            WHERE a.inpol_policy_number = POLICY_UNDER_STUDY.inpol_policy_number
            AND a.inpol_status IN ('O','C') AND a.inpol_process_status <> 'D'), 0) ENDIF as CLO_FOLLOWING_POLICY_PHASE,
       CASE
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND clo_following_policy_phase = 0 AND POLICY_UNDER_STUDY.inpol_cancellation_date IS NOT NULL THEN 'CANCELLED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND clo_following_policy_phase = 0 AND POLICY_UNDER_STUDY.inpol_cancellation_date IS NULL THEN 'LAPSED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND FOLLOWING_PHASE.inpol_process_status = 'E' THEN 'ENDORSED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'A' AND FOLLOWING_PHASE.inpol_process_status = 'R' THEN 'RENEWED'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'N' AND FOLLOWING_PHASE.inpol_process_status = 'E' THEN 'UNDER_ENDORSEMENT'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'N' AND FOLLOWING_PHASE.inpol_process_status = 'R' THEN 'UNDER_RENEWAL'
       WHEN POLICY_UNDER_STUDY.inpol_status = 'N' AND FOLLOWING_PHASE.inpol_process_status = 'C' THEN 'UNDER_CANCELLATION'
       ELSE IF POLICY_UNDER_STUDY.inpol_status = 'A' THEN 'ARCHIVED UNKNOWN' ELSE 'NORMAL/ACTIVE' ENDIF END as OBSERVATION_STATUS,
POLICY_UNDER_STUDY.inpol_renewal,
inity_insurance_type,
POLICY_UNDER_STUDY.inpol_period_starting_date,
FOLLOWING_PHASE.inpol_period_starting_date as fp_period_starting_date,
POLICY_UNDER_STUDY.inpol_status,
POLICY_UNDER_STUDY.inpol_process_status,
POLICY_UNDER_STUDY.inpol_created_by,
POLICY_UNDER_STUDY.inpol_cover as current_policy_cover,
COALESCE((SELECT next.inpol_cover FROM inpolicies as next WHERE next.inpol_policy_serial = CLO_FOLLOWING_POLICY_PHASE),'')as next_policy_cover,
IF next_policy_cover <> current_policy_cover AND next_policy_cover <> '' THEN 1 ELSE 0 ENDIF as cover_changed,
inag_agent_code,
LEFT(inag_long_description,18)as agent_name,
fn_return_period_premium(expl_last_policy_phase,'YearPeriod:".substr($_POST["date_to"],0,7)."','NET-NO-CANCEL')as expl_premium,
fn_return_period_premium(expl_last_policy_phase,'YearPeriod:".substr($_POST["date_to"],0,7)."','NET-DECLARATION')as expl_premium_declaration,
COALESCE(fn_return_period_premium(CLO_FOLLOWING_POLICY_PHASE,'YearPeriod:".substr($_POST["date_to"],0,7)."','NET-NO-CANCEL'),0)as renew_premium
".$into_sql."
FROM (SELECT MAX(inpol_policy_serial) as expl_last_policy_phase,
            inpol_period_starting_date as expl_period_starting_date,
            inpol_policy_number as expl_policy_number, 
            (SELECT a.inpol_expiry_date FROM inpolicies a WHERE a.inpol_policy_serial = expl_last_policy_phase) as expl_expiry_date,
            //in the case where you want to exclude policies posted after the defined date AND expl_posted_on <= '2013-05-31'
            //(SELECT b.inped_status_changed_on FROM inpolicies a JOIN inpolicyendorsement b ON b.inped_policy_serial = a.inpol_policy_serial AND b.inped_endorsement_serial = a.inpol_last_endorsement_serial WHERE a.inpol_policy_serial = expl_last_policy_phase) as expl_posted_on
            //in the case where you want to exclude policies posted financially after the defined date.
            (SELECT (inped_year * 100 + inped_period) FROM inpolicies a JOIN inpolicyendorsement b ON b.inped_policy_serial = a.inpol_policy_serial AND b.inped_endorsement_serial = a.inpol_last_endorsement_serial WHERE a.inpol_policy_serial = expl_last_policy_phase) as expl_financial_posted_period
      FROM  inpolicies 
      WHERE inpol_status IN ('N', 'A') /* Normal & Archived */
      AND   inpol_process_status <> 'D' /* Exclude Declaration Adjustments */
      GROUP BY expl_policy_number, expl_period_starting_date) AS EXPIRATION_LIST
JOIN inpolicies AS POLICY_UNDER_STUDY ON POLICY_UNDER_STUDY.inpol_policy_serial = EXPIRATION_LIST.expl_last_policy_phase
LEFT OUTER JOIN inpolicies AS FOLLOWING_PHASE ON FOLLOWING_PHASE.inpol_policy_serial = CLO_FOLLOWING_POLICY_PHASE
LEFT OUTER JOIN ininsurancetypes ON POLICY_UNDER_STUDY.inpol_insurance_type_serial = inity_insurance_type_serial
LEFT OUTER JOIN inagents ON POLICY_UNDER_STUDY.inpol_agent_serial = inag_agent_serial
WHERE 
EXPIRATION_LIST.expl_expiry_date BETWEEN '".$_POST["date_from"]."' AND '".$_POST["date_to"]."'
AND expl_financial_posted_period <= (".$_POST["financial_year"]." * 100 + ".$_POST["financial_period"].")
AND POLICY_UNDER_STUDY.inpol_created_by <> 'IMP_ARCHIVE'

".$major_category."
".$major_category_exclude."
".$insured_amount_range."
".$cover."



ORDER BY inag_agent_code,expl_policy_number, expl_expiry_date, expl_last_policy_phase 
".$new_sql;
if ($_POST["show"] == "totals" || $_POST["show"] == "policy") {
	$result = $sybase->query($sql);
}
//echo $sql;

if ($_POST["show"] == "totals") {

	while ($row = $sybase->fetch_assoc($result)) {
	
		$data[$row["inag_agent_code"]]["total_to_be_renewed"] ++;
		$data[$row["inag_agent_code"]][$row["OBSERVATION_STATUS"]] ++;
		$data[$row["inag_agent_code"]]["cover_changed"] += $row["cover_changed"];
		$data[$row["inag_agent_code"]]["name"] = $row["agent_name"];
		
		$data["all"]["total_to_be_renewed"] ++;
		$data["all"][$row["OBSERVATION_STATUS"]] ++;
		$data["all"]["cover_changed"] += $row["cover_changed"];
		
	
	}

}//if show = totals

}//if show.





$db->show_header();
?>
<script>
$(document).ready(function() {

$("#date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#date_to").datepicker({dateFormat: 'yy-mm-dd'});

});
</script>
<form name="form1" method="post" action="">
  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Renewals Statistics. Only Motor Comprehensive </td>
    </tr>
    <tr>
      <td width="167">Expire Date From </td>
      <td width="383"><input name="date_from" type="text" id="date_from" value="<? echo $_POST["date_from"];?>"></td>
    </tr>
    <tr>
      <td>Expire Date To </td>
      <td><input name="date_to" type="text" id="date_to" value="<? echo $_POST["date_to"];?>"></td>
    </tr>
    <tr>
      <td>Up To Financial Period</td>
      <td>Year: 
        <input name="financial_year" type="text" id="financial_year" size="5" value="<? echo $_POST["financial_year"];?>" />
      Period:
      <input name="financial_period" type="text" id="financial_period" size="5" value="<? echo $_POST["financial_period"];?>" /></td>
    </tr>
    <tr>
      <td>Insured Amount Range </td>
      <td><input name="range_from" type="text" id="range_from" size="5" value="<? echo $_POST["range_from"];?>">
      <input name="range_to" type="text" id="range_to" size="5" value="<? echo $_POST["range_to"];?>"></td>
    </tr>
    <tr>
      <td>Insurance Type </td>
      <td><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_POST["insurance_type"];?>" />
      Motor Use 19%</td>
    </tr>
    <tr>
      <td>Insurance Type Exclude </td>
      <td><input name="insurance_type_exclude" type="text" id="insurance_type_exclude" value="<? echo $_POST["insurance_type_exclude"];?>" />
      Non Motor use 19%</td>
    </tr>
    <tr>
      <td>Policy Cover </td>
<?
if ($_POST["cover"] == "") $_POST["cover"] = 'ALL';
?>
      <td><select name="cover" id="cover">
        <option value="= 'A'" <? if (stripslashes($_POST["cover"]) == "= 'A'") echo "selected=\"selected\"";?>>Third Party</option>
        <option value="= 'B'" <? if (stripslashes($_POST["cover"]) == "= 'B'") echo "selected=\"selected\"";?>>Fire &amp; Theft</option>
        <option value="= 'C'" <? if (stripslashes($_POST["cover"]) == "= 'C'") echo "selected=\"selected\"";?>>Comprehensive</option>
        <option value="<> 'A'" <? if (stripslashes($_POST["cover"]) == "<> 'A'") echo "selected=\"selected\"";?>>Comprehensive + Fire & Theft</option>
        <option value="ALL" <? if (stripslashes($_POST["cover"]) == "ALL") echo "selected=\"selected\"";?>>ALL</option>
                  </select></td>
    </tr>
    <tr>
      <td>Show</td>
      <td><select name="show" id="show">
        <option value="totals" <? if (stripslashes($_POST["show"]) == "totals") echo "selected=\"selected\"";?>>Totals</option>
        <option value="policy" <? if (stripslashes($_POST["show"]) == "policy") echo "selected=\"selected\"";?>>Per Policy</option>
        <option value="action" <? if (stripslashes($_POST["show"]) == "action") echo "selected=\"selected\"";?>>Per Action</option>
        <option value="insurance_type" <? if (stripslashes($_POST["show"]) == "insurance_type") echo "selected=\"selected\"";?>>Per Insurance Type</option>
      </select></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br>

<?
function check_if_empty($value) {

	if ($value == "")
		return '-';
	else
		return $value;

}

if ($_POST["action"] == "show") {
?>
<div id="print_view_section_html">
<?	
	if ($_POST["show"] == "totals") {
?>

<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr class="row_table_head">
    <td width="80"><strong>Agent Code</strong></td>
    <td width="200"><strong>Agent</strong></td>
    <td width="80" align="center"><strong>Total For Renewal </strong></td>
    <td width="80" align="center"><strong>Renewed</strong></td>
    <td width="80" align="center"><strong>Cancelled</strong></td>
    <td width="80" align="center"><strong>Lapsed</strong></td>
    <td width="80" align="center"><strong>Cover Changed </strong></td>
    <td width="80" align="center"><strong>Under Endorse. </strong></td>
    <td width="80" align="center"><strong>Under Cancell.</strong></td>
    <td width="80" align="center"><strong>Under Renewal </strong></td>
    <td width="80" align="center"><strong>Endorsed</strong></td>
  </tr>
<?
foreach($data as $name => $value) {
	if ($name != 'all') {

?>
  <tr>
    <td>'<? echo $name;?>'</td>
    <td><? echo $value["name"];?></td>
    <td align="center"><? echo check_if_empty($value["total_to_be_renewed"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["RENEWED"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["CANCELLED"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["LAPSED"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["cover_changed"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["UNDER_ENDORSEMENT"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["UNDER_CANCELLATION"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["UNDER_RENEWAL"]);?>&nbsp;</td>
    <td align="center"><? echo check_if_empty($value["ENDORSED"]);?>&nbsp;</td>
  </tr>
<? 
	}//if name != all
} //foreach
?>
  <tr>
    <td><strong>Total</strong></td>
    <td>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["total_to_be_renewed"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["RENEWED"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["CANCELLED"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["LAPSED"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["cover_changed"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["UNDER_ENDORSEMENT"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["UNDER_CANCELLATION"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["UNDER_RENEWAL"]);?></strong>&nbsp;</td>
    <td align="center"><strong><? echo check_if_empty($data["all"]["ENDORSED"]);?></strong>&nbsp;</td>
  </tr>
</table>


<?
	}//if to show totals
else if ($_POST["show"] == "policy"){
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="row_table_border" align="center">
  <tr class="row_table_head">
    <td>Agent</td>
    <td align="center">Insurance Type</td>
    <td align="center">Policy Number</td>
    <td align="center">Action</td>
    <td align="center">Status</td>
    <td align="center">Created By</td>
    <td align="center">Cur. Ph.SRL</td>
    <td align="center">Ren. Ph.SRL</td>
    <td align="right">Cur. Prem.</td>
    <td align="right">Cur. Declaration</td>
    <td align="right">Ren. Prem.</td>
    <td align="right">&nbsp;</td>
  </tr>
<?
while ($row = $sybase->fetch_assoc($result)) {

	//get the premium for the current phase
	$extra_sql = "AND inpol_policy_number = '".$row["expl_policy_number"]."' AND inpol_period_starting_date = '".$row["inpol_period_starting_date"]."'";
	$sql = get_policy_premium_commissions('',$extra_sql);
	$prem_res = $sybase->query($sql);
	$current_premium = 0;
	$current_declaration = 0;
	//check if the policy is cancelled then show the actual premium for the current and the return preimum on the next 
	while ($curpre_row = $sybase->fetch_assoc($prem_res)) {

		if ($row["OBSERVATION_STATUS"] == 'CANCELLED') {
			if ($curpre_row["clo_process_status"] != 'C') {
				$current_premium += $curpre_row["clo_premium"] ;
			}
		}
		else if($curpre_row["clo_process_status"] == 'D') {
			$current_declaration += $curpre_row["clo_premium"];	
		}else {
			$current_premium += $curpre_row["clo_premium"] ;
		}
	}

	//get the premium for the next phase
	$extra_sql = "AND inpol_policy_number = '".$row["expl_policy_number"]."' AND inpol_period_starting_date = '".$row["fp_period_starting_date"]."'";
	$sql = get_policy_premium_commissions('',$extra_sql);
	if ($row["fp_period_starting_date"] != '') {
		$prem_res = $sybase->query($sql);
	}
	$next_premium = 0;
	while ($nextpre_row = $sybase->fetch_assoc($prem_res)) {
		if ($row["OBSERVATION_STATUS"] == 'CANCELLED') {
			if ($nextpre_row["clo_process_status"] == 'C') {
				$next_premium += $nextpre_row["clo_premium"] ;
			}
		}
		else if ($row["OBSERVATION_STATUS"] == 'LAPSED') {
			$next_premium = 0;
		}
		else {
			$next_premium += $nextpre_row["clo_premium"] ;
		}
	
	}

?>
  <tr>
    <td>'<? echo $row["inag_agent_code"];?>'</td>
    <td align="center"><? echo $row["inity_insurance_type"];?></td>
    <td align="center"><? echo $row["expl_policy_number"];?></td>
    <td align="center"><? echo $row["OBSERVATION_STATUS"];?></td>
    <td align="center"><? echo $row["inpol_status"]."-".$row["inpol_process_status"];?></td>
    <td align="center"><? echo $row["inpol_created_by"];?></td>
    <td align="center"><? echo $row["expl_last_policy_phase"];?></td>
    <td align="center"><? echo $row["CLO_FOLLOWING_POLICY_PHASE"];?></td>
    <td align="right">&#8364;<? echo $current_premium;?></td>
    <td align="right">&#8364;<? echo $current_declaration;?></td>
    <td align="right">&#8364;<? echo $next_premium;?></td>
    <td align="right">&nbsp;</td>
  </tr>
<? } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?
}//if to show per policy.
else if ($_POST["show"] == "action" || $_POST["show"] == "insurance_type"){
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
	echo $table_data;
	
}

}//if show table

$db->show_footer();
?>
