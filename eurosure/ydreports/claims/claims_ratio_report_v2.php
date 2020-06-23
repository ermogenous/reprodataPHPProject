<?
ini_set("memory_limit","128M");
set_time_limit(1200);
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("../../tools/export_data.php");
include("../functions/production_class.php");
include("../functions/claims.php");
$sybase = new Sybase();


$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');


if ($_POST["action"] == "show") {
	
//Production
	$as_at_date_parts = explode('/',$_POST["as_at_date"]);
	$prod = new synthesis_production();
	$prod->from_year = $_POST["year_from"];
	$prod->from_period = $_POST["period_from"];
	$prod->to_year = $as_at_date_parts[2];
	$prod->to_period = $as_at_date_parts[1];
	$prod->policy_sql();
	$prod->add_insurance_types();
	$prod->add_agents();
	$prod->add_majors();
	$prod->insert_select_group('inag_group_code');
	$prod->insert_select_group('inag_agent_code');
	$prod->insert_select_group('inity_major_category');

	//outer select
	$prod->enable_outer_select();
	if ($_POST["agents_code_by"] == 'agent_group_code') {
		$prod->insert_outer_select_group('inag_group_code','agent');
	}
	else {
		$prod->insert_outer_select_group('inag_agent_code','agent');
	}
	$prod->insert_outer_select_group('inity_major_category','major');
	$prod->insert_outer_select('SUM(clo_premium)','premium');
	$prod->insert_outer_select('SUM(clo_period_mif)','mif');
	$prod->insert_outer_select('SUM(clo_period_fees)','fees');
	$prod->insert_outer_select('SUM(clo_period_stamps)','stamps');
	$prod->insert_outer_select('SUM(clo_commission)','commission');
	
	$prod->insert_outer_sort('1','ASC');
	
	//insert 2nd temp table
	$prod->insert_outer_select_after('into #production');
	
	
//CLAIMS
	$claims = new synthesis_claims($_POST["year_from"]."-".$_POST["period_from"]."-01",$as_at_date_parts[2]."-".$as_at_date_parts[1]."-".$as_at_date_parts[0]);
	if ($_POST["open_date"] != 1) {
		$claims->insert_open_date($_POST["year_from"]."-".$_POST["period_from"]."-01",$as_at_date_parts[2]."-".$as_at_date_parts[1]."-".$as_at_date_parts[0]);
	}
	//arrange the process status
	$claims->auto_arrange_process_status($_POST["preliminary"],$_POST["outstanding"],$_POST["withdrawn"],$_POST["recovery"],$_POST["closed"],1);

	//add the necessary tables
	$claims->add_policies();
	$claims->add_insurance_types();
	$claims->add_agents();
	$claims->insert_select_group('inag_group_code');
	$claims->insert_select_group('inag_agent_code');
	$claims->insert_select_group('inity_major_category');
	//outer
	$claims->enable_outer_select();
	if ($_POST["agents_code_by"] == 'agent_group_code') {
		$claims->insert_outer_select_group('inag_group_code','agent');
	}
	else {
		$claims->insert_outer_select_group('inag_agent_code','agent');
	}
	$claims->insert_outer_select_group('inity_major_category','major');
	$claims->insert_outer_res_pay_totals();
	$claims->insert_outer_sort('1','ASC');
	
	//insert 2nd temp
	$claims->insert_outer_select_after('into #claims');

//agents temp table
	$agents_sql = "SELECT
	inag_group_code,
	(SELECT a1.inag_long_description FROM inagents a1 WHERE a1.inag_agent_code = inagents.inag_group_code)as agent_name,
    (SELECT a2.inag_alpha_key1 FROM inagents a2 WHERE a2.inag_agent_code = inagents.inag_group_code)as agent_location,
	(SELECT a3.inag_alpha_key3 FROM inagents a3 WHERE a3.inag_agent_code = inagents.inag_group_code)as agent_is_staff,
	incd_record_code,
	(SELECT inga_long_description FROM ingeneralagents WHERE inga_agent_serial = (SELECT aggg.inag_agent_serial FROM inagents aggg WHERE aggg.inag_agent_code = inagents.inag_group_code))as clo_general_agent_description,
    (SELECT a4.inag_general_agent_serial FROM inagents a4 WHERE a4.inag_agent_code = inagents.inag_group_code)as clo_general_agent_serial
	into #agents
	FROM
	inagents
	JOIN inpcodes ON incd_record_type IN ('01','96')
	WHERE inag_agent_type = 'A'
	GROUP BY inag_group_code,incd_record_code
	ORDER BY inag_group_code;";


//filtering
	//insurance type
	if ($_POST["insurance_type_from"] != '' && $_POST["insurance_type_to"] != "") {
		$prod->insert_where("AND inity_insurance_type BETWEEN '".$_POST["insurance_type_from"]."' AND '".$_POST["insurance_type_to"]."'");
		$claims->insert_where("AND inity_insurance_type BETWEEN '".$_POST["insurance_type_from"]."' AND '".$_POST["insurance_type_to"]."'");
	}
	
	//agents
	if ($_POST["agents_from"] != "" && $_POST["agents_to"] != "") {
		if ($_POST["agents_code_by"] == 'agent_group_code') {
			$prod->insert_where("AND inag_group_code BETWEEN '".$_POST["agents_from"]."' AND '".$_POST["agents_to"]."'");
			$claims->insert_where("AND inag_group_code BETWEEN '".$_POST["agents_from"]."' AND '".$_POST["agents_to"]."'");
		}
		else {
			$prod->insert_where("AND inag_agent_code BETWEEN '".$_POST["agents_from"]."' AND '".$_POST["agents_to"]."'");
			$claims->insert_where("AND inag_agent_code BETWEEN '".$_POST["agents_from"]."' AND '".$_POST["agents_to"]."'");
		}
	}
	if ($_POST["major_from"] != "" && $_POST["major_to"] != "") {
		$prod->insert_where("AND inity_major_category BETWEEN '".$_POST["major_from"]."' AND '".$_POST["major_to"]."'");
		$claims->insert_where("AND inity_major_category BETWEEN '".$_POST["major_from"]."' AND '".$_POST["major_to"]."'");
	}

	//filter by
	if ($_POST["filter_by"] != 'none' && $_POST["filter_by"] != "") {
		$pieces = explode("\n",$_POST["filter_by_text"]);
		foreach($pieces as $pvalue) {
			$pvalue = addslashes(preg_replace('/^\s+|\n|\r|\s+$/m', '', $pvalue));
			if ($pvalue != '') {
				$filter_by_text .= "'".$pvalue."',";
			}
		}
		$filter_by_text = "(".$db->remove_last_char($filter_by_text).")";
		$prod->insert_where("AND ".$_POST["filter_by"]." ".addslashes($_POST["filter_by_type"])." ".$filter_by_text);
		
		$claims->insert_where("AND ".$_POST["filter_by"]." ".addslashes($_POST["filter_by_type"])." ".$filter_by_text);

	}

	$prod->generate_sql();
	$claims->generate_sql();
	
	$final_sql = $prod->sql.";
	".$claims->sql.";
	".$agents_sql."

SELECT
CASE major
WHEN 'MOT' THEN 30
WHEN 'NON' THEN 31
WHEN 'ALL' THEN 32
ELSE major
END CASE as clo_major_sort,

ag.inag_group_code as agent,
ag.agent_name as agent_name,
ag.agent_location as agent_location,
ag.agent_is_staff as agent_is_staff,
ag.clo_general_agent_description as general_agent_name,
ag.clo_general_agent_serial as general_agent_serial,
incd_record_code as major,
//production
CASE major
WHEN 'ALL' THEN (SELECT SUM(pprp.premium) FROM #production as pprp WHERE pprp.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(pprp.premium) FROM #production as pprp WHERE pprp.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(pprp.premium) FROM #production as pprp WHERE pprp.agent = ag.inag_group_code AND major <> '19')
ELSE pr.premium end case as premium,
CASE major
WHEN 'ALL' THEN (SELECT SUM(pprm.mif) FROM #production as pprm WHERE pprm.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(pprm.mif) FROM #production as pprm WHERE pprm.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(pprm.mif) FROM #production as pprm WHERE pprm.agent = ag.inag_group_code AND major <> '19')
ELSE pr.mif end case as mif,
CASE major
WHEN 'ALL' THEN (SELECT SUM(pprf.fees) FROM #production as pprf WHERE pprf.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(pprf.fees) FROM #production as pprf WHERE pprf.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(pprf.fees) FROM #production as pprf WHERE pprf.agent = ag.inag_group_code AND major <> '19')
ELSE pr.fees end case as fees,
CASE major
WHEN 'ALL' THEN (SELECT SUM(pprs.stamps) FROM #production as pprs WHERE pprs.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(pprs.stamps) FROM #production as pprs WHERE pprs.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(pprs.stamps) FROM #production as pprs WHERE pprs.agent = ag.inag_group_code AND major <> '19')
ELSE pr.stamps end case as stamps,
CASE major
WHEN 'ALL' THEN (SELECT SUM(pprc.commission) FROM #production as pprc WHERE pprc.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(pprc.commission) FROM #production as pprc WHERE pprc.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(pprc.commission) FROM #production as pprc WHERE pprc.agent = ag.inag_group_code AND major <> '19')
ELSE pr.commission end case as commission,
//claims
CASE major
WHEN 'ALL' THEN (SELECT SUM(ccp.clo_total_period_payments) FROM #claims as ccp WHERE ccp.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(ccp.clo_total_period_payments) FROM #claims as ccp WHERE ccp.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(ccp.clo_total_period_payments) FROM #claims as ccp WHERE ccp.agent = ag.inag_group_code AND major <> '19')
ELSE cl.clo_total_period_payments end case as payments,
CASE major
WHEN 'ALL' THEN (SELECT SUM(ccr.clo_total_os_reserve) FROM #claims as ccr WHERE ccr.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(ccr.clo_total_os_reserve) FROM #claims as ccr WHERE ccr.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(ccr.clo_total_os_reserve) FROM #claims as ccr WHERE ccr.agent = ag.inag_group_code AND major <> '19')
ELSE cl.clo_total_os_reserve end case as os_reserve,
CASE major
WHEN 'ALL' THEN (SELECT SUM(ccc.clo_total_claims) FROM #claims as ccc WHERE ccc.agent = ag.inag_group_code)
WHEN 'MOT' THEN (SELECT SUM(ccc.clo_total_claims) FROM #claims as ccc WHERE ccc.agent = ag.inag_group_code AND major = '19')
WHEN 'NON' THEN (SELECT SUM(ccc.clo_total_claims) FROM #claims as ccc WHERE ccc.agent = ag.inag_group_code AND major <> '19')
ELSE cl.clo_total_claims end case as total_claims
FROM
#agents as ag
LEFT OUTER JOIN #production as pr ON pr.agent = ag.inag_group_code AND incd_record_code = pr.major
LEFT OUTER JOIN #claims as cl ON cl.agent = ag.inag_group_code AND incd_record_code = cl.major
WHERE 
1=1
AND (pr.agent + cl.agent is not null OR incd_record_code IN ('ALL','MOT','NON'))
order by ag.inag_group_code,clo_major_sort;
";
//echo $final_sql;exit();
//$table = export_data_html_table($prod->sql,'sybase');
//$table .= "<br><br><hr><br><br>";
//$table .= export_data_html_table($claims->sql,'sybase');

if ($_POST["show_only"] != '1') {
	//build XML----------------------------------------------------------------------------------------------------------------------------------
	$xml = new xmltoexcel('test.xml','UTF-8');
	//add some styles
	$xml->add_style('centered',"<Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>");	
	$xml->add_style('headers',"<Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
	   <Font ss:FontName=\"Calibri\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"11\"
		ss:Color=\"#000000\" ss:Bold=\"1\"/>");	
	$xml->add_style('percentage',"<Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
	   <NumberFormat ss:Format=\"Percent\"/>");
	$xml->add_style('normal',"<Alignment ss:Horizontal=\"Left\" ss:Vertical=\"Bottom\"/>
	   <Font ss:FontName=\"Calibri\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"9\"
		ss:Color=\"#000000\"/>");	
	   //decide what to use in the data array.
	   if (@substr($_POST["break"],'SPR') !== false) {
			//enable separated
			$separated = 1;   
	   }
	   if (@substr($_POST["break"],'GRP') !== false) {
			//enable separated
			$grouped = 1;   
	   }
	   
	   
	   
	   //loop into the production data to build the array
		$result = $sybase->query($final_sql);
		while ($row = $sybase->fetch_assoc($result)) {
			//find this line in which break belongs to
			if ($row["major"] == 'ALL') {
				$break = 'ALL';	
			}
			else if ($row["major"] == 'MOT') {
				$break = 'MOT';	
			}
			else if ($row["major"] == 'NON') {
				$break = 'NON';	
			}
			else {
				$break = 'SPR';	
			}
			
			//decide the worksheet
			if ($_POST["district"] == 'district') {
				if ($row["agent_is_staff"] == 'YES') {
					$worksheet_name = 'Staff';
					$sheet_names['Staff'] = 'Staff';
				}
				else if ($row["agent_is_staff"] == 'REMOVE') {
					$worksheet_name = 'Remove';
					$sheet_names['Remove'] = 'Remove';
				}
				else {
					$worksheet_name = fix_districts($row["agent_location"]);
					$sheet_names[fix_districts($row["agent_location"])] = fix_districts($row["agent_location"]);
				}
			}
			else if ($_POST["district"] == 'branch') {
				$worksheet_name = $row["general_agent_serial"];
				$sheet_names[$row["general_agent_serial"]] = $row["general_agent_name"];
			}
			
			//remove lines that are all zero
			if ($row["premium"] != 0 || $row["payments"] != 0 || $row["os_reserve"] != 0 || $row["total_claims"] != 0) {
				
				//allow only lines based on the break data
				if (strpos($_POST["break"],$break) !== false) {

					$data[$row["agent"]][$row["major"]]["premium"] += $row["premium"];
					$data[$row["agent"]][$row["major"]]["fees"] += $row["fees"];
					$data[$row["agent"]][$row["major"]]["commission"] += $row["commission"];
					$data[$row["agent"]][$row["major"]]["stamps"] += $row["stamps"];
					$data[$row["agent"]][$row["major"]]["mif"] += $row["mif"];
					$data[$row["agent"]][$row["major"]]["code"] = $row["agent"];
					$data[$row["agent"]][$row["major"]]["name"] = $row["agent_name"];
					$data[$row["agent"]][$row["major"]]["major"] = $row["major"];
					
					$data[$row["agent"]][$row["major"]]["pliromes"] += $row["payments"];
					$data[$row["agent"]][$row["major"]]["ekremis"] += $row["os_reserve"];
					$data[$row["agent"]][$row["major"]]["claims"] += $row["total_claims"];
					
					//other worksheets
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["premium"] += $row["premium"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["fees"] += $row["fees"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["commission"] += $row["commission"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["stamps"] += $row["stamps"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["mif"] += $row["mif"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["code"] = $row["agent"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["name"] = $row["agent_name"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["major"] = $row["major"];
					
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["pliromes"] += $row["payments"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["ekremis"] += $row["os_reserve"];
					$sheet[$worksheet_name][$row["agent"]][$row["major"]]["claims"] += $row["total_claims"];
					
				}
				
			}//remove zero data
		}
		ksort($sheet);
		foreach($sheet as $name => $worksheet) {
			load_data_to_xml($worksheet,$sheet_names[$name]);
		}
		load_data_to_xml($data,'ALL');

	//finalize the xml
	$xml->export_xml();
	//send the file for download
	export_download_variable($xml->export,$_POST["year_from"]."-".$_POST["period_from"]."-".$_POST["break"].".xml");
}
else {
	//echo $final_sql;exit();
	$table = export_data_html_table($final_sql,'sybase');
	

}

}//if action show



$db->show_header();
?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'dd/mm/yy'});

});
//$("#claims_ratio_form").validate();
</script>

<form action="" method="post" id="claims_ratio_form"><table width="670" border="1" align="center">
  <tr>
    <td colspan="3" align="center"><strong>Claims Ratio Report V2</strong></td>
    </tr>
  <tr>
    <td width="144"><label for="break"><strong>How to break data</strong></label></td>
    <td width="378"><select name="break" id="break">
	  <option value="SPR" <? if ($_POST["break"] == 'ALL') echo "selected=\"selected\"";?>>All Separated</option>
      <option value="ALL" <? if ($_POST["break"] == 'ALL') echo "selected=\"selected\"";?>>Only Total</option>
      <option value="SPR/ALL" <? if ($_POST["break"] == 'SPR/GRP') echo "selected=\"selected\"";?>>ALL Separated/Total</option>
      <option value="NON" <? if ($_POST["break"] == 'NON') echo "selected=\"selected\"";?>>Non Motor</option>
      <option value="MOT,NON" <? if ($_POST["break"] == 'MOT,NON') echo "selected=\"selected\"";?>>Motor/Non Motor</option>
      <option value="MOT,NON,ALL" <? if ($_POST["break"] == 'MOT,NON,GRP') echo "selected=\"selected\"";?>>Motor/Non Motor/Total</option>
      <option value="MOT,NON,ALL,SPR" <? if ($_POST["break"] == 'MOT,NON,GRP') echo "selected=\"selected\"";?>>All Separated/Motor/Non Motor/Total</option>
    </select></td>
    <td width="126" rowspan="24" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center"><strong>Process Status</strong></td>
        </tr>
<?
if ($_POST["action"] != 'show'){
	$_POST["preliminary"] = 1;
	$_POST["outstanding"] = 1;
	$_POST["withdrawn"] = 0;
	$_POST["recovery"] = 1;
	$_POST["closed"] = 1;
}
?>
      <tr>
        <td width="83%"><label for="preliminary"><strong>Preliminary</strong></label></td>
        <td width="17%"><input name="preliminary" type="checkbox" id="preliminary" value="1" <? if ($_POST["preliminary"] == 1) echo "checked=\"checked\"";?> /></td>
      </tr>
      <tr>
        <td><label for="outstanding"><strong>Outstanding</strong></label></td>
        <td><input name="outstanding" type="checkbox" id="outstanding" value="1" <? if ($_POST["outstanding"] == 1) echo "checked=\"checked\"";?> /></td>
      </tr>
      <tr>
        <td><label for="withdrawn"><strong>Withdrawn</strong></label></td>
        <td><input name="withdrawn" type="checkbox" id="withdrawn" value="1" <? if ($_POST["withdrawn"] == 1) echo "checked=\"checked\"";?> /></td>
      </tr>
      <tr>
        <td><label for="recovery"><strong>Recovery</strong></label></td>
        <td><input name="recovery" type="checkbox" id="recovery" value="1" <? if ($_POST["recovery"] == 1) echo "checked=\"checked\"";?> /></td>
      </tr>
      <tr>
        <td><label for="closed"><strong>Closed</strong></label></td>
        <td><input name="closed" type="checkbox" id="closed" value="1" <? if ($_POST["closed"] == 1) echo "checked=\"checked\"";?> /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><strong>District</strong></td>
    <td><select name="district" id="district">
      <option value="district" <? if ($_POST["district"] == 'district') echo "selected=\"selected\"";?>>Per District</option>
      <option value="branch" <? if ($_POST["district"] == 'branch') echo "selected=\"selected\"";?>>Per Branch</option>
    </select></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><strong>Filtering</strong></td>
    </tr>
  <tr>
    <td><strong>Major</strong></td>
    <td>From
      <input name="major_from" type="text" id="major_from" value="<? echo $_POST["major_from"];?>" />
      To
      <input name="major_to" type="text" id="major_to" value="<? echo $_POST["major_to"];?>" /></td>
    </tr>
  <tr>
    <td><strong>Insurance Type</strong></td>
    <td>From 
      <input name="insurance_type_from" type="text" id="insurance_type_from" value="<? echo $_POST["insurance_type_from"];?>" />
      To 
      <input name="insurance_type_to" type="text" id="insurance_type_to" value="<? echo $_POST["insurance_type_to"];?>" /></td>
    </tr>
  <tr>
    <td><strong>Filter By</strong></td>
    <td><select name="filter_by" id="filter_by">
      <option value="none" <? if ($_POST["filter_by"] == 'none') echo "selected=\"selected\"";?>>none</option>
      <option value="inity_insurance_type" <? if ($_POST["filter_by"] == 'inity_insurance_type') echo "selected=\"selected\"";?>>Insurance Type</option>
      <option value="inity_major_category" <? if ($_POST["filter_by"] == 'inity_major_category') echo "selected=\"selected\"";?>>Major</option>
    </select>
      <select name="filter_by_type" id="filter_by_type">
        <option value="IN" <? if ($_POST["filter_by_type"] == 'IN') echo "selected=\"selected\"";?>>IN</option>
        <option value="NOT IN" <? if ($_POST["filter_by_type"] == 'NOT IN') echo "selected=\"selected\"";?>>NOT IN</option>
      </select>
      <br />
      <textarea name="filter_by_text" id="filter_by_text" cols="45" rows="5"><? echo $_POST["filter_by_text"];?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>Production/Claims Period Range</strong></td>
    </tr>
  <tr>
  <?
  if ($_POST["year_from"] == "") {
	$_POST["year_from"] = date("Y");   
  }
  if ($_POST["period_from"] == "") {
	$_POST["period_from"] = 1;  
  }
  ?>
    <td><strong>From</strong></td>
    <td><label for="year_from">Year</label>
      <input name="year_from" type="number" id="year_from" value="<? echo $_POST["year_from"];?>" size="6" required style="width:50px">
      <label for="period_from">Period</label>
      <input name="period_from" type="number" id="period_from" value="<? echo $_POST["period_from"];?>" size="6" required style="width:50px"></td>
    </tr>
  <tr>
    <td><label for="as_at_date"><strong>As At Date</strong></label></td>
    <td><input name="as_at_date" type="text" id="as_at_date" value="<? echo $_POST["as_at_date"];?>" size="12" required />
      <br />
      UpTo production period and as at date for claims</td>
    </tr>
  <tr>
    <td><strong>Disable Open Date</strong></td>
    <td><input name="open_date" type="checkbox" id="open_date" value="1" <? if($_POST["open_date"] == '1') echo "checked=\"checked\"";?> /></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><strong>Other Options</strong></td>
    </tr>
  <tr>
    <td><strong>Agents Range </strong></td>
    <td>From:
      <input name="agents_from" type="text" id="agents_from" size="9" value="<? echo $_POST["agents_from"];?>" />
      To:
      <input name="agents_to" type="text" id="agents_to" size="9" value="<? echo $_POST["agents_to"];?>" /></td>
    </tr>
  <tr>
    <td align="left"><strong>Agents Code By</strong></td>
    <td align="left"><select name="agents_code_by" id="agents_code_by">
      <option value="agent_group_code" <? if ($_POST["agents_code_by"] == 'agent_group_code') echo "selected=\"selected\"";?>>Agent Group Code</option>
    </select></td>
    </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>EXTRAS not working</strong></td>
    </tr>
  <tr>
    <td>Fees</td>
    <td><input name="fees" type="checkbox" id="fees" value="1" <? if ($_POST["fees"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
  <tr>
    <td>Commissions</td>
    <td><input name="commission" type="checkbox" id="commission" value="1" <? if ($_POST["commission"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
  <tr>
    <td>Stamps</td>
    <td><input name="stamps" type="checkbox" id="stamps" value="1" <? if ($_POST["stamps"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
  <tr>
    <td>MIF</td>
    <td><input name="mif" type="checkbox" id="mif" value="1" <? if ($_POST["mif"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
  <tr>
    <td>Reinsurance</td>
    <td><input name="reinsurance" type="checkbox" id="reinsurance" value="1" <? if ($_POST["reinsurance"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
  <tr>
    <td>Expenses</td>
    <td><input name="expenses" type="checkbox" id="expenses" value="1" <? if ($_POST["expenses"] == 1) echo "checked=\"checked\"";?>/></td>
    </tr>
  <tr>
    <td>Exp/Profit</td>
    <td><input name="profit" type="checkbox" id="profit" value="1" <? if ($_POST["profit"] == 1) echo "checked=\"checked\"";?>/>
      Includes Earned Unearned </td>
    </tr>
  <tr>
    <td>Product Prem % </td>
    <td><input name="premium_percentage" type="checkbox" id="premium_percentage" value="1" <? if ($_POST["premium_percentage"] == 1) echo "checked=\"checked\"";?>/>
      % of class based on the total premium</td>
    </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="show">
    Show Only
      <input name="show_only" type="checkbox" id="show_only" value="1" <? if ($_POST["show_only"] == 1) echo "checked=\"checked\"";?> />
      <label for="show_only"></label></td>
    <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
</table>
</form>
<?
echo $table;
$db->show_footer();


function load_data_to_xml($data,$worksheet_name) {
global $sybase,$xml,$db;


//get rates reinsurance / expenses
$rates["expenses"] = $db->get_setting("ap_agents_valuation_expense_rate_".$_POST["year"]);
$rates["10"] = $db->get_setting("ap_agents_valuation_reins_10_rate_".$_POST["year"]);
$rates["11"] = $db->get_setting("ap_agents_valuation_reins_11_rate_".$_POST["year"]);
$rates["16"] = $db->get_setting("ap_agents_valuation_reins_16_rate_".$_POST["year"]);
$rates["17"] = $db->get_setting("ap_agents_valuation_reins_17_rate_".$_POST["year"]);
$rates["19"] = $db->get_setting("ap_agents_valuation_reins_19_rate_".$_POST["year"]);
$rates["21"] = $db->get_setting("ap_agents_valuation_reins_21_rate_".$_POST["year"]);
$rates["22"] = $db->get_setting("ap_agents_valuation_reins_22_rate_".$_POST["year"]);

//if data exists to use
if (is_array($data)) {
	$xml->add_spreadsheet($worksheet_name);
	$xml->insert_sheet_options("<PageSetup>
    <Layout x:Orientation=\"Portrait\"/>
    <Header x:Margin=\"0\"/>
    <Footer x:Margin=\"0\"/>
    <PageMargins x:Bottom=\"0\" x:Left=\"0.55118110236220474\" x:Right=\"0\"
     x:Top=\"0.78740157480314965\"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>");

if ($_POST["reinsurance"] == 1 || $_POST["expenses"] == 1 || $_POST["profit"] == 1) {
	$column_size = 5;
	$column_size_name = 30;
}
else {
	$column_size = 0;
}


	//set the column widths
	$xml->clumn_width(0,40 - $column_size);
	$xml->clumn_width(1,80 - $column_size_name);
	$xml->clumn_width(2,30 - $column_size);
	$xml->clumn_width(3,35 - $column_size);
	$xml->clumn_width(4,35 - $column_size);
	$xml->clumn_width(5,35 - $column_size);
	$xml->clumn_width(6,32 - $column_size);
	$xml->clumn_width(7,40 - $column_size);
	$xml->clumn_width(8,35 - $column_size);
	$xml->clumn_width(9,40 - $column_size);
	$xml->clumn_width(10,50 - $column_size);
	
$col = 11;
if ($_POST["fees"] == 1) {
	$xml->clumn_width($col,30 - $column_size);
	$col ++;
	}
if ($_POST["stamps"] == 1) {
	$xml->clumn_width($col,25 - $column_size);
	$col ++;
	}
if ($_POST["mif"] == 1) {
	$xml->clumn_width($col,30 - $column_size);
	$col ++;
	}
if ($_POST["commission"] == 1) {
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	}
if ($_POST["reinsurance"] == 1) {
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	}
if ($_POST["expenses"] == 1) {
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	}
if ($_POST["profit"] == 1) {
	$xml->clumn_width($col,40 - $column_size);
	$col ++;
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
	}
if ($_POST["premium_percentage"] == 1 ){
	$xml->clumn_width($col,35 - $column_size);
	$col ++;
}
	//set the column headers
	$xml->write(0,1,$worksheet_name,'Default','String');
	$xml->write(0,2,$_POST["month"],'Default','String');
	$xml->write(0,3,$_POST["year"],'Default','String');


	$xml->write(1,0,'CODE','headers','String');	
	$xml->write(1,1,'NAME','headers','String');	
	$xml->write(1,2,'Cl.','headers','String');	
	$xml->write(1,3,'Prem.','headers','String');	
	$xml->write(1,4,'PAYM.','headers','String');	
	$xml->write(1,5,'OUTST','headers','String');	
	$xml->write(1,6,'Cases','headers','String');	
	$xml->write(1,7,'TOT.CL.','headers','String');	
	$xml->write(1,8,'AV. PER CLAIM','headers','String');	
	$xml->write(1,9,'PREM. PER CLAIM','headers','String');	
	$xml->write(1,10,'LOSS %','headers','String');	

$col = 11;
if ($_POST["fees"] == 1) {
	$xml->write(1,$col,'FEES','headers','String');	
	$col++;
}
if ($_POST["stamps"] == 1) {
	$xml->write(1,$col,'STAMPS','headers','String');	
	$col++;
}
if ($_POST["mif"] == 1) {
	$xml->write(1,$col,'MIF','headers','String');	
	$col++;
}
if ($_POST["commission"] == 1) {
	$xml->write(1,$col,'COM.','headers','String');	
	$col++;
}
if ($_POST["reinsurance"] == 1) {
	$xml->write(1,$col,'REIN.','headers','String');	
	$col++;
}
if ($_POST["expenses"] == 1) {
	$xml->write(1,$col,'EXP.','headers','String');	
	$col++;
}
if ($_POST["profit"] == 1) {
	$xml->write(1,$col,'EARNED','headers','String');	
	$col++;
	$xml->write(1,$col,'UNEARNED','headers','String');	
	$col++;
	$xml->write(1,$col,'Gr PROFIT','headers','String');	
	$col++;
	$xml->write(1,$col,'Gr N PROFIT','headers','String');	
	$col++;
	$xml->write(1,$col,'Actual Gr P/L','headers','String');	
	$col++;
	$xml->write(1,$col,'Actual N P/L','headers','String');	
	$col++;
}

if ($_POST["premium_percentage"] == 1 ){
	$xml->write(1,$col,'% On Prem','headers','String');	
	$col++;
}

	$row = 2;

	foreach($data as $agent) {

		//foreach section
		foreach ($agent as $value) {
			//echo $value["code"]."-".$value["major"]."<br>";
			//fix some numbers
			$value["premium"] = fix_numbers_to_zero($value["premium"]);
			$value["pliromes"] = fix_numbers_to_zero($value["pliromes"]);
			$value["ekremis"] = fix_numbers_to_zero($value["ekremis"]);
			
			
			$xml->write($row,0,$value["code"],'normal','String');	
			$xml->write($row,1,$value["name"],'normal','String');	
			$xml->write($row,2,$value["major"],'centered','String');	
			$xml->write($row,3,$value["premium"],'centered','Number');	
			$xml->write($row,4,$value["pliromes"],'centered','Number');	
			$xml->write($row,5,$value["ekremis"],'centered','Number');	
			$xml->write($row,6,$value["claims"],'centered','Number');
			$xml->write($row,7,fix_numbers_to_zero($value["pliromes"] + $value["ekremis"]),'centered','Number');
			if ($value['claims'] > 0) {
				$xml->insert_formula($row,8,'centered','Number','ROUND(RC[-1]/RC[-2],0)');
				$xml->insert_formula($row,9,'centered','Number','ROUND(RC[-6]/RC[-3],0)');
				$xml->insert_formula($row,10,'percentage','Number','RC[-3]/RC[-7]');		
			}//if claims > 0
			else {
				$xml->write($row,8,'','centered','String');
				//$xml->insert_formula($row,9,'centered','Number','ROUND(RC[-6],0)');
				$xml->write($row,9,'0','centered','Number');	
				$xml->write($row,10,'0','percentage','Number');	
			}//else claims > 0

//extras
			$col= 11;
			if ($_POST["fees"] == 1) {
				$xml->write($row,$col,fix_numbers_to_zero($value["fees"]),'centered','Number');	
				$col++;
			}
			if ($_POST["stamps"] == 1) {
				$xml->write($row,$col,fix_numbers_to_zero($value["stamps"]),'centered','Number');	
				$col++;
			}
			if ($_POST["mif"] == 1) {
				$xml->write($row,$col,fix_numbers_to_zero($value["mif"]),'centered','Number');	
				$col++;
			}
			if ($_POST["commission"] == 1) {
				$xml->write($row,$col,fix_numbers_to_zero($value["commission"]),'centered','Number');	
				$col++;
			}


			if ($_POST["reinsurance"] == 1) {
				$reinsurance_value = $value["premium"]*$rates[$value["major"]];
				$xml->write($row,$col,fix_numbers_to_zero($reinsurance_value),'centered','Number');
				$col++;
			}
			if ($_POST["expenses"] == 1) {
				
				$expenses_value = ($value["premium"])*$rates["expenses"];
				$xml->write($row,$col,fix_numbers_to_zero($expenses_value),'centered','Number');
				$col++;
			}
			if ($_POST["profit"] == 1) {
				//earned
				$xml->write($row,$col,fix_numbers_to_zero($value["premium"]*0.65),'centered','Number');
				$col++;
				//unearned
				$xml->write($row,$col,fix_numbers_to_zero($value["premium"]*0.35),'centered','Number');
				$col++;
				//Gr PROFIT
				$xml->write($row,$col,fix_numbers_to_zero(($value["premium"] + $value["fees"] - $value["commission"] - $value["claims"]- $reinsurance_value - $expenses_value)),'centered','Number');
				$col++;
				//Gr N PROFIT
				$xml->write($row,$col,fix_numbers_to_zero(($value["premium"] - $value["commission"] - $value["claims"]- $reinsurance_value - $expenses_value)),'centered','Number');
				$col++;
				//Actual Gr P/L
				$xml->write($row,$col,fix_numbers_to_zero((($value["premium"] * 0.65 ) + $value["fees"] - $value["commission"] - $value["claims"]- $reinsurance_value - $expenses_value)),'centered','Number');
				$col++;
				//Actual N P/L
				$xml->write($row,$col,fix_numbers_to_zero((($value["premium"] * 0.65 ) - $value["commission"] - $value["claims"]- $reinsurance_value - $expenses_value)),'centered','Number');
				$col++;
			}			
			
			if ($_POST["premium_percentage"] == 1) {
				
				if ($value["major"] == 'ALL') {
					
					//print_r($prem_per);
					foreach ($prem_per as $pp_section => $pper_line) {
					
						if ($value["premium"] != 0)
							$pp_result = $pper_line["premium"] / $value["premium"];
						else 
							$pp_result = 0;
							
						if ($pp_section == '19')
							$color = 'green_bold';
						else
							$color = 'red_bold';
							
						$xml->write($pper_line["row"],$col,$pp_result,$color,'Number');
					
					}					
					$xml->write($row,$col,'','centered','String');
										
					$value = "";
				}//if all section
				//collect the data
				else {
					$prem_per[$value["major"]]["premium"] = $value["premium"];
					$prem_per[$value["major"]]["row"] = $row;
				}//else other sections
			
			$col++;
			}//if premium percentage

		$row++;
		}//foreach section
	}//foreach agent
}//if data is array

}//function load_data_to_xml

function fix_numbers_to_zero($amount) {
$amount = round($amount,0);
	if ($amount == '')
		return '0';
	if (is_null($amount))
		return '0';
	if (!(is_numeric($amount)))
		return '0';
	if ($amount == 0 )
		return '0';

return $amount;

}

function fix_districts($district){
	if ($district == 'L/CA')
		return "Larnaka";
	else if ($district == 'NIC')
		return "Lefkosia";
	else if ($district == 'FAMAG')
		return "Ammochostos";
	else if ($district == 'LSOL')
		return "Lemessos";
	else if ($district == 'PAFOS')
		return "Paphos";
	else 
		return $district;	
}
?>