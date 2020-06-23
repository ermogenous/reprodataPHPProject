<?
ini_set('max_execution_time', 300);
ini_set("memory_limit","128M");
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../include/sybase_sqls.php");
include("../../tools/export_data.php");
include("../functions/production_class.php");
include("../functions/production.php");
$sybase = new Sybase();

if ($_POST["action"] == "show") {



function generate_production_sql($type='current') {
	if ($type == 'current') {
		$from_year = $_POST["from_year"];
		$to_year = $_POST["to_year"];
	}
	else {
		$from_year = $_POST["from_year"] - 1;
		$to_year = $_POST["to_year"] - 1;
	}
	
	//PRODUCITON SQL
	$prod = new synthesis_production();
	
	$prod->from_year = $from_year;
	$prod->from_period = $_POST["from_period"];
	$prod->to_year = $to_year;
	$prod->to_period = $_POST["to_period"];
	$prod->policy_sql();
	$prod->add_insurance_types();
	$prod->add_agents();
	
	//SELECT
	$prod->insert_select_group('\'1\'','clo_fixed_num');
	$prod->insert_select_group('inpol_policy_serial');
	$prod->insert_select_group('inpol_policy_number');
	$prod->insert_select_group('inpol_status');
	$prod->insert_select_group('inity_insurance_type');
	$prod->insert_select_group('inity_long_description');
	$prod->insert_select_group('inag_agent_serial');
	$prod->insert_select_group('inag_agent_code');
	$prod->insert_select_group('inag_long_description');
	$prod->insert_select_group('fn_get_policy_4_6_12_month(inpol_policy_serial)','clo_policy_months');
	$prod->insert_select_group('inpol_period_starting_date');
	
	//filers
	if ($_POST["insurance_type"] != "") {
		$prod->insert_where("AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'");
	}
	if ($_POST["insurance_type_exclude"] != "") {
		$prod->insert_where("AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'");
	}
	if ($_POST["cover"] != 'ALL') {
		$prod->insert_where("AND inpol_cover ".stripslashes($_POST["cover"]));
	}
	if ($_POST["agent_code"] != "") {
		$prod->insert_where("AND inag_agent_code LIKE '".$_POST["agent_code"]."'");	
	}
	
	//create the convertion case
	$prod->insert_select_group("case
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 12 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 12 THEN '12M12M'
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 12 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 6 THEN '12M6M'
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 12 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 4 THEN '12M4M'
	
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 6 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 6 THEN '6M6M'
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 6 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 4 THEN '6M4M'
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 6 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 12 THEN '6M12M'
	
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 4 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 4 THEN '4M4M'
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 4 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 6 THEN '4M6M'
	WHEN fn_get_policy_4_6_12_month(inpol_replacing_policy_serial) = 4 AND fn_get_policy_4_6_12_month(inpol_policy_serial) = 12 THEN '4M12M'
	ELSE 'OTHER'
	end","clo_convertion");
	$prod->insert_group('inpol_replacing_policy_serial');
	$prod->insert_select('fn_get_policy_4_6_12_month(inpol_policy_serial)','clo_current_months');
	
	$prod->sql_select .= "\ninto #prod";
	
	$prod->generate_sql();
	//echo $prod->sql."\n\n\n\n\n";
	//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>PRODUCTION SQL END>>>
	$prod_sql = $prod->sql."
	SELECT 
	SUM(clo_premium)as clo_total_production_premium
	,COUNT()as clo_total_transactions
	,COUNT(DISTINCT(inpol_policy_number))as pol_total_unique
	
	,SUM(clo_premium)as clo_total_premium
	,SUM(IF clo_process_status = 'N' THEN 1 ELSE 0 ENDIF)as pol_total_new
	,SUM(IF clo_process_status = 'N' THEN clo_premium ELSE 0 ENDIF)as pol_total_new_prem

	,SUM(IF clo_process_status = 'N' AND clo_current_months = 12 THEN 1 ELSE 0 ENDIF)as pol_total_new_12m
	,SUM(IF clo_process_status = 'N' AND clo_current_months = 12 THEN clo_premium ELSE 0 ENDIF)as pol_total_new_12m_prem
	
	,SUM(IF clo_process_status = 'N' AND clo_current_months = 6 THEN 1 ELSE 0 ENDIF)as pol_total_new_6m
	,SUM(IF clo_process_status = 'N' AND clo_current_months = 6 THEN clo_premium ELSE 0 ENDIF)as pol_total_new_6m_prem
	
	,SUM(IF clo_process_status = 'N' AND clo_current_months = 4 THEN 1 ELSE 0 ENDIF)as pol_total_new_4m
	,SUM(IF clo_process_status = 'N' AND clo_current_months = 4 THEN clo_premium ELSE 0 ENDIF)as pol_total_new_4m_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' THEN 1 ELSE 0 ENDIF)as pol_total_renewals
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 12 THEN 1 ELSE 0 ENDIF)as pol_total_renewals_12m
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 12 THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_12m_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 6 THEN 1 ELSE 0 ENDIF)as pol_total_renewals_6m
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 6 THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_6m_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 4 THEN 1 ELSE 0 ENDIF)as pol_total_renewals_4m
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 4 THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_4m_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' THEN 1 ELSE 0 ENDIF)as pol_total_renewals_out
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_out_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 12 THEN 1 ELSE 0 ENDIF)as pol_total_renewals_12m_out
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 12 THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_12m_out_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 6 THEN 1 ELSE 0 ENDIF)as pol_total_renewals_6m_out
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 6 THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_6m_out_prem
	
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 4 THEN 1 ELSE 0 ENDIF)as pol_total_renewals_4m_out
	,SUM(IF clo_process_status = 'R' AND inpol_period_starting_date NOT BETWEEN '".$from_year."-".$_POST["from_period"]."-01' AND '".$from_year."-".$_POST["from_period"]."-".date("t", strtotime($to_year."-".($_POST["to_period"])."-01"))."' AND clo_current_months = 4 THEN clo_premium ELSE 0 ENDIF)as pol_total_renewals_4m_out_prem
	
	
	,SUM(IF clo_process_status = 'C' THEN 1 ELSE 0 ENDIF)as pol_total_cancelled
	,SUM(IF clo_process_status = 'C' THEN clo_premium ELSE 0 ENDIF)as pol_total_cancelled_prem
	
	,SUM(IF clo_process_status = 'C' AND clo_current_months = 12 THEN 1 ELSE 0 ENDIF)as pol_total_cancelled_12m
	,SUM(IF clo_process_status = 'C' AND clo_current_months = 12 THEN clo_premium ELSE 0 ENDIF)as pol_total_cancelled_12m_prem
	
	,SUM(IF clo_process_status = 'C' AND clo_current_months = 6 THEN 1 ELSE 0 ENDIF)as pol_total_cancelled_6m
	,SUM(IF clo_process_status = 'C' AND clo_current_months = 6 THEN clo_premium ELSE 0 ENDIF)as pol_total_cancelled_6m_prem
	
	,SUM(IF clo_process_status = 'C' AND clo_current_months = 4 THEN 1 ELSE 0 ENDIF)as pol_total_cancelled_4m
	,SUM(IF clo_process_status = 'C' AND clo_current_months = 4 THEN clo_premium ELSE 0 ENDIF)as pol_total_cancelled_4m_prem
	
	,SUM(IF clo_process_status IN ('E','D') THEN 1 ELSE 0 ENDIF)as pol_total_end_decl
	,SUM(IF clo_process_status IN ('E','D') THEN 1 ELSE 0 ENDIF)as pol_total_end_decl_prem
	
	,SUM(IF clo_process_status IN ('E','D') AND clo_current_months = 12 THEN 1 ELSE 0 ENDIF)as pol_total_end_decl_12m
	,SUM(IF clo_process_status IN ('E','D') AND clo_current_months = 12 THEN clo_premium ELSE 0 ENDIF)as pol_total_end_decl_12m_prem
	
	,SUM(IF clo_process_status IN ('E','D') AND clo_current_months = 6 THEN 1 ELSE 0 ENDIF)as pol_total_end_decl_6m
	,SUM(IF clo_process_status IN ('E','D') AND clo_current_months = 6 THEN clo_premium ELSE 0 ENDIF)as pol_total_end_decl_6m_prem
	
	,SUM(IF clo_process_status IN ('E','D') AND clo_current_months = 4 THEN 1 ELSE 0 ENDIF)as pol_total_end_decl_4m
	,SUM(IF clo_process_status IN ('E','D') AND clo_current_months = 4 THEN clo_premium ELSE 0 ENDIF)as pol_total_end_decl_4m_prem
	
	,SUM(IF clo_process_status = 'L' THEN 1 ELSE 0 ENDIF)as pol_total_lapsed
	,SUM(IF clo_process_status = 'L' THEN 1 ELSE 0 ENDIF)as pol_total_lapsed_prem
	
	,SUM(IF clo_process_status = 'L' AND clo_current_months = 12 THEN 1 ELSE 0 ENDIF)as pol_total_lapsed_12m
	,SUM(IF clo_process_status = 'L' AND clo_current_months = 12 THEN clo_premium ELSE 0 ENDIF)as pol_total_lapsed_12m_prem
	
	,SUM(IF clo_process_status = 'L' AND clo_current_months = 6 THEN 1 ELSE 0 ENDIF)as pol_total_lapsed_6m
	,SUM(IF clo_process_status = 'L' AND clo_current_months = 6 THEN clo_premium ELSE 0 ENDIF)as pol_total_lapsed_6m_prem
	
	,SUM(IF clo_process_status = 'L' AND clo_current_months = 4 THEN 1 ELSE 0 ENDIF)as pol_total_lapsed_4m
	,SUM(IF clo_process_status = 'L' AND clo_current_months = 4 THEN clo_premium ELSE 0 ENDIF)as pol_total_lapsed_4m_prem
	
	,SUM(IF clo_convertion = '12M12M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_12M12M
	,SUM(IF clo_convertion = '12M6M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_12M6M
	,SUM(IF clo_convertion = '12M4M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_12M4M
	,SUM(IF clo_convertion = '6M12M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_6M12M
	,SUM(IF clo_convertion = '6M6M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_6M6M
	,SUM(IF clo_convertion = '6M4M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_6M4M
	,SUM(IF clo_convertion = '4M12M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_4M12M
	,SUM(IF clo_convertion = '4M6M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_4M6M
	,SUM(IF clo_convertion = '4M4M' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_4M4M
	
	,SUM(IF clo_convertion = 'OTHER' AND clo_process_status = 'R' THEN 1 ELSE 0 ENDIF)as pol_convert_OTHER
	
	FROM #prod
	";
	return $prod_sql;
}

function generate_renewals_statistics_sql($type='current') {
	if ($type == 'current') {
		$from_year = $_POST["from_year"];
		$to_year = $_POST["to_year"];
	}
	else {
		$from_year = $_POST["from_year"] - 1;
		$to_year = $_POST["to_year"] - 1;
	}

	//RENEWAL STATISTICS SQL<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	$from_date = date("Y-m-d",mktime(0,0,0,$_POST["from_period"]-1,date("t", strtotime($to_year."-".($_POST["to_period"]-1)."-01")),$from_year));
	$to_date = date("Y-m-d",mktime(0,0,0,$_POST["to_period"],date("t", strtotime($to_year."-".$_POST["to_period"]."-01"))-1,$to_year));
	$extra_select = ",FOLLOWING_PHASE.inpol_policy_serial as clo_following_phase_serial,
	FOLLOWING_PHASE.inpol_policy_period as clo_following_policy_period,
	FOLLOWING_PHASE.inpol_policy_year as clo_following_policy_year,
	fn_get_policy_4_6_12_month(expl_last_policy_phase) as clo_policy_months,
	1 as clo_fixed_num
	into #ren";
	$extra_end = "SELECT
	COUNT()as clo_total_renew
	FROM
	#ren";
	//filers
	if ($_POST["insurance_type"] != "") {
		$extra_where = "AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'\n";
	}
	if ($_POST["insurance_type_exclude"] != "") {
		$extra_where .= "AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'";
	}
	
	
	$renewals_sql = expiration_list($from_date,$to_date,$to_year,$_POST["to_period"],$extra_select,$extra_from,$extra_where,$extra_group,$extra_order,$extra_having,$extra_end);
	return $renewals_sql;
}
//echo $renewals;

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>RENEWAL LIST SQL>>>>>

$prod_sql = generate_production_sql();
//echo $prod_sql;
$ren_sql = generate_renewals_statistics_sql();

//echo $prod_sql;
$prod_data = $sybase->query_fetch($prod_sql);

$ren_data = $sybase->query_fetch($ren_sql);

//get last year numbers
$prod_sql_previous = generate_production_sql('previous_year');
$ren_sql_previous = generate_renewals_statistics_sql('previous_year');

$prod_data_ly = $sybase->query_fetch($prod_sql_previous);

$ren_data_ly = $sybase->query_fetch($ren_sql_previous);


}//if show.





$db->show_header();
?>
<form name="form1" method="post" action="">
  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Production Per Policies Report</td>
    </tr>
    <tr>
      <td width="167">Date From *</td>
      <td width="383">Year
        <input name="from_year" type="text" id="from_year" value="<? echo $_POST["from_year"];?>" size="6">
        Period
        <input name="from_period" type="text" id="from_period" value="<? echo $_POST["from_period"];?>" size="6" /></td>
    </tr>
    <tr>
      <td>Date To *</td>
      <td>Year 
        <input name="to_year" type="text" id="to_year" value="<? echo $_POST["to_year"];?>" size="6"> 
        Period
        <input name="to_period" type="text" id="to_period" value="<? echo $_POST["to_period"];?>" size="6" /></td>
    </tr>
    <tr>
      <td>Insurance Type </td>
      <td><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_POST["insurance_type"];?>" /></td>
    </tr>
    <tr>
      <td>Insurance Type Exclude </td>
      <td><input name="insurance_type_exclude" type="text" id="insurance_type_exclude" value="<? echo $_POST["insurance_type_exclude"];?>" /></td>
    </tr>
    <tr>
      <td>Agent Code</td>
      <td><input name="agent_code" type="text" id="agent_code" value="<? echo $_POST["agent_code"];?>" /></td>
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
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br>

<?
if ($_POST["action"] == "show") {
	
function get_policy_cover($cover_text) {
	if ($cover_text == "= \'A\'") {
		return 'Third Party';
	}
	else if ($cover_text == "= \'B\'") {
		return 'Fire & Theft';
	}
	else if ($cover_text == "= \'C\'") {
		return 'Comprehensive';
	}
	else if ($cover_text == "<> \'A\'") {
		return 'Comp. + F&T';
	}
	else if ($cover_text == "ALL") {
		return 'ALL';
	}
}
?>
<div id="print_view_section_html">
<table width="711" height="1027" border="0" align="center" cellpadding="3" cellspacing="0" class="main_text_small row_table_border">
  <tr>
    <td class="row_table_border"  colspan="7" align="center"><strong>Production Per Policies Report</strong></td>
    </tr>
  <tr>
    <td class="row_table_border"  colspan="4" align="center">Insurance Type [<? echo $_POST["insurance_type"];?>] Ins.Type Exclude[<? echo $_POST["insurance_type_exclude"];?>] Policy Cover[<? echo get_policy_cover($_POST["cover"]);?>] Agent[<? echo $_POST["agent_code"];?>]</td>
    <td class="row_table_border"  colspan="3" align="center"><strong>DATE:&nbsp;<? echo $_POST["from_period"]."/".$_POST["from_year"]." TO ".$_POST["to_period"]."/".$_POST["to_year"];?></strong></td>
    </tr>
  <tr>
    <td class="row_table_border"  colspan="5" align="right"><strong>MONTH TARGET    &#8364;</strong></td>
    <td class="row_table_border"  width="60">&nbsp;</td>
    <td class="row_table_border"  width="64">&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border"  width="184" bgcolor="#CCCCCC"><strong><u>PREMIUM PRODUCTION</u></strong></td>
    <td class="row_table_border"  width="80" align="center" bgcolor="#CCCCCC"><strong>&#8364;</strong></td>
    <td class="row_table_border"  width="144" bgcolor="#CCCCCC">&nbsp;</td>
    <td class="row_table_border"  colspan="2" bgcolor="#CCCCCC">&nbsp;</td>
    <td class="row_table_border"  align="center" bgcolor="#CCCCCC"><strong>&#8364;</strong></td>
    <td class="row_table_border"  bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >LYP</td>
    <td class="row_table_border"  align="center"><? echo $db->fix_int_to_double($prod_data_ly["clo_total_production_premium"],0);?></td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  width="73">&nbsp;</td>
    <td class="row_table_border"  width="64">&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >TO BE RENEWED</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  colspan="2">NEW INCLUDED</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >PRODUCTION POSTED UTD</td>
    <td class="row_table_border"  align="center"><? echo $db->fix_int_to_double($prod_data["clo_total_production_premium"],0);?></td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  colspan="2">CANCEL/ END/ DECL</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  colspan="2">MONTH RENEWALS</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  colspan="2">PREVIOUS MONTH REN</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >O/S RENEWALS</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border"  colspan="7"><u><strong>ESTIMATED GROSS WRITTEN PREMIUM INCOME FOR MONTH</strong></u></td>
  </tr>
  <tr>
    <td class="row_table_border"  colspan="2" align="center"><strong>TC</strong></td>
    <td class="row_table_border"  align="center"><strong>OXS</strong></td>
    <td class="row_table_border"  align="center"><strong>O/S NEW</strong></td>
    <td class="row_table_border"  align="center"><strong>EST REN</strong></td>
    <td class="row_table_border"  colspan="2" align="center" bgcolor="#CCCCCC"><strong>ESTIMATED GWPR</strong></td>
    </tr>
  <tr>
    <td class="row_table_border"  colspan="2" align="center">&nbsp;</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border"  colspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  <tr>
    <td class="row_table_border"  bgcolor="#CCCCCC"><strong><u>POLICIES PRODUCTION</u></strong></td>
    <td class="row_table_border"  bgcolor="#CCCCCC"><strong>NO. OF POL.</strong></td>
    <td class="row_table_border"  bgcolor="#CCCCCC">&nbsp;</td>
    <td class="row_table_border"  bgcolor="#CCCCCC">&nbsp;</td>
    <td class="row_table_border"  bgcolor="#CCCCCC">&nbsp;</td>
    <td class="row_table_border"  bgcolor="#CCCCCC">&nbsp;</td>
    <td class="row_table_border"  bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >EXPIRE IN MONTH</td>
    <td class="row_table_border"  align="center"><? echo $ren_data["clo_total_renew"]." (".$ren_data_ly["clo_total_renew"].")";?></td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >TO BE RENEWED</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border"  colspan="5" bgcolor="#CCCCCC"><strong>POLICIES PRODUCTION ANALYSIS</strong></td>
  </tr>
  <tr>
    <td class="row_table_border" >POLICIES POSTED UTD</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_unique"]." (".$prod_data_ly["pol_total_unique"].")";?></td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  align="center"><strong>TOTAL</strong></td>
    <td class="row_table_border"  align="center"><strong>12M</strong></td>
    <td class="row_table_border"  align="center"><strong>6M</strong></td>
    <td class="row_table_border"  align="center"><strong>4M</strong></td>
  </tr>
  <tr>
    <td class="row_table_border" >TRANSACTIONS POSTED UTD</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["clo_total_transactions"]." (".$prod_data_ly["clo_total_transactions"].")";?></td>
    <td class="row_table_border" ><strong>NEW</strong></td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_new"]." (".$prod_data_ly["pol_total_new"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_new_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_new_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_new_12m"]." (".$prod_data_ly["pol_total_new_12m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_new_12m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_new_12m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_new_6m"]." (".$prod_data_ly["pol_total_new_6m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_new_6m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_new_6m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_new_4m"]." (".$prod_data_ly["pol_total_new_4m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_new_4m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_new_4m_prem"],0).")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" ><strong>RENEWALS</strong></td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals"]." (".$prod_data_ly["pol_total_renewals"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_12m"]." (".$prod_data_ly["pol_total_renewals_12m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_12m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_12m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_6m"]." (".$prod_data_ly["pol_total_renewals_6m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_6m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_6m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_4m"]." (".$prod_data_ly["pol_total_renewals_4m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_4m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_4m_prem"],0).")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" ><strong>PREVIOUS MONTH REN</strong></td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_out"]." (".$prod_data_ly["pol_total_renewals_out"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_out_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_out_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_12m_out"]." (".$prod_data_ly["pol_total_renewals_12m_out"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_12m_out_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_12m_out_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_6m_out"]." (".$prod_data_ly["pol_total_renewals_6m_out"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_6m_out_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_6m_out_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_renewals_4m_out"]." (".$prod_data_ly["pol_total_renewals_4m_out"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_renewals_4m_out_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_renewals_4m_out_prem"],0).")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" ><strong>CANCELLED</strong></td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_cancelled"]." (".$prod_data_ly["pol_total_cancelled"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_cancelled_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_cancelled_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_cancelled_12m"]." (".$prod_data_ly["pol_total_cancelled_12m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_cancelled_12m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_cancelled_12m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_cancelled_6m"]." (".$prod_data_ly["pol_total_cancelled_6m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_cancelled_6m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_cancelled_6m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_cancelled_4m"]." (".$prod_data_ly["pol_total_cancelled_4m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_cancelled_4m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_cancelled_4m_prem"],0).")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" ><strong>END/DECL</strong></td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_end_decl"]." (".$prod_data_ly["pol_total_end_decl"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_end_decl_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_end_decl_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_end_decl_12m"]." (".$prod_data_ly["pol_total_end_decl_12m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_end_decl_12m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_end_decl_12m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_end_decl_6m"]." (".$prod_data_ly["pol_total_end_decl_6m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_end_decl_6m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_end_decl_6m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_end_decl_4m"]." (".$prod_data_ly["pol_total_end_decl_4m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_end_decl_4m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_end_decl_4m_prem"],0).")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" ><strong>MONTH LAPSED</strong></td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_lapsed"]." (".$prod_data_ly["pol_total_lapsed"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_lapsed_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_lapsed_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_lapsed_12m"]." (".$prod_data_ly["pol_total_lapsed_12m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_lapsed_12m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_lapsed_12m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_lapsed_6m"]." (".$prod_data_ly["pol_total_lapsed_6m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_lapsed_6m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_lapsed_6m_prem"],0).")";?></td>
    
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_total_lapsed_4m"]." (".$prod_data_ly["pol_total_lapsed_4m"].")"
	."<br>".$db->fix_int_to_double($prod_data["pol_total_lapsed_4m_prem"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["pol_total_lapsed_4m_prem"],0).")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td align="right" class="row_table_border" ><strong>TOTAL</strong></td>
    <td class="row_table_border"  align="center"><strong><? echo $prod_data["clo_total_transactions"]." (".$prod_data_ly["clo_total_transactions"].")"
	."<br>".$db->fix_int_to_double($prod_data["clo_total_premium"],0)."<br>(".$db->fix_int_to_double($prod_data_ly["clo_total_premium"],0).")";?></strong></td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
    <td class="row_table_border"  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  colspan="5" bgcolor="#CCCCCC"><strong>RENEWAL POLICIES WITH PERIOD CONVERTION</strong></td>
    </tr>
  <tr>
    <td class="row_table_border"  height="28">&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  align="center">12M =&gt; 12M</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_convert_12M12M"]." (".$prod_data_ly["pol_convert_12M12M"].")";?></td>
    <td colspan="2" align="center" class="row_table_border" >12M => 6M</td>
    <td align="center" class="row_table_border" ><? echo $prod_data["pol_convert_12M6M"]." (".$prod_data_ly["pol_convert_12M6M"].")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  align="center">12M => 4M</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_convert_12M4M"]." (".$prod_data_ly["pol_convert_12M4M"].")";?></td>
    <td colspan="2" align="center" class="row_table_border" >6M =&gt; 6M</td>
    <td align="center" class="row_table_border" ><? echo $prod_data["pol_convert_6M6M"]." (".$prod_data_ly["pol_convert_6M6M"].")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  align="center">6M => 12M</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_convert_6M12M"]." (".$prod_data_ly["pol_convert_6M12M"].")";?></td>
    <td colspan="2" align="center" class="row_table_border" >6M => 4M</td>
    <td align="center" class="row_table_border" ><? echo $prod_data["pol_convert_6M4M"]." (".$prod_data_ly["pol_convert_6M4M"].")";?></td>
  </tr>
  <tr>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  align="center">4M =&gt; 4M</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_convert_4M4M"]." (".$prod_data_ly["pol_convert_4M4M"].")";?></td>
    <td colspan="2" align="center" class="row_table_border" >4M => 12M</td>
    <td align="center" class="row_table_border" ><? echo $prod_data["pol_convert_4M12M"]." (".$prod_data_ly["pol_convert_4M12M"].")";?></td>
  </tr>
  <tr>
    <td class="row_table_border"  height="23">( X ) -&gt; Previous Year</td>
    <td class="row_table_border" >&nbsp;</td>
    <td class="row_table_border"  align="center">4M => 6M</td>
    <td class="row_table_border"  align="center"><? echo $prod_data["pol_convert_4M6M"]." (".$prod_data_ly["pol_convert_4M6M"].")";?></td>
    <td colspan="2" align="center" class="row_table_border" >OTHER</td>
    <td align="center" class="row_table_border" ><? echo $prod_data["pol_convert_OTHER"]." (".$prod_data_ly["pol_convert_OTHER"].")";?></td>
  </tr>
</table>
<? 

	//echo export_data_html_table($prod_sql,'sybase');

?>
</div>
<?
}//if show table

$db->show_footer();
?>