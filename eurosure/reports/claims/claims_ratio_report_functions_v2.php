<?
function get_data_for_area($area,$cymenu,$section,$month,$year,$as_at_date,$agents_from,$agents_to) {
global $db,$sybase,$out,$inqueries;
//all sections
$all_sections = explode(",",$section);
foreach ($all_sections as $section) {
		//get agents
		if ($agents_to != "") {
			$agents_sql = "AND inag_group_code BETWEEN '".$agents_from."' AND '".$agents_to."'";
		}
		else {
			$agents_sql = '';
		}
		
		$ag = $sybase->query("SELECT * FROM inagents WHERE inag_agent_type = 'A' AND LEFT(RIGHT(inag_group_code,4),1) LIKE '".$area."' ".$agents_sql." ORDER BY inag_agent_code ASC");

		while ($agent = $sybase->fetch_assoc($ag,1)) {
		
			$data[$agent["inag_group_code"]][$section]["code"] = $agent["inag_group_code"];
			$data[$agent["inag_group_code"]][$section]["code_old"] = $agent["inag_numeric_key1"];
			$data[$agent["inag_group_code"]][$section]["name"] = $agent["inag_long_description"];
			$data[$agent["inag_group_code"]][$section]["section"] = $section;
			
			//production for cymenu------------------------------------------------------------------------------------------------CYMENU
			if ($section == 'ALL') {
				$section_sql = "";
			}
			else if ($section == 'NON') {
				$section_sql = "AND ap_klados != '19'";
			}
			else {
				$section_sql = "AND ap_klados = '".$section."'";
			}
			$sql = "SELECT SUM(ap_premium)as clo_total_premium,SUM(ap_commission)as clo_total_commission, SUM(ap_plithos)as clo_total_policies,SUM(ap_mif)as clo_mif,SUM(ap_stamps) as clo_stamps,SUM(ap_fees)as clo_fees FROM ap_prod_comm WHERE ap_agent = '".$agent["ap_agents_code_old"]."' ".$section_sql." AND ap_year = '".$year."' AND ap_month_from BETWEEN 1 AND '".$month."'";

			$premium_res = $db->query($sql);
			$premium = $db->fetch_assoc($premium_res);
			$data[$agent["inag_group_code"]][$section]["premium"] += $premium["clo_total_premium"];
			$data[$agent["inag_group_code"]][$section]["fees"] += $premium["clo_fees"];
			$data[$agent["inag_group_code"]][$section]["commission"] += $premium["clo_total_commission"];
			$data[$agent["inag_group_code"]][$section]["stamps"] += $premium["clo_stamps"];
			$data[$agent["inag_group_code"]][$section]["mif"] += $premium["clo_mif"];
			
			//production for synthesis ------------------------------------------------------------------------------------------------SYNTHESIS
			if ($section == 'ALL') {
				$section_sql = "%%";
				$section_way = 'LIKE';
			}
			else if ($section == 'NON') {
				$section_sql = '19';
				$section_way = '<>';
			}
			else {
				$section_sql = $section;
				$section_way = 'LIKE';
			}
			$prod_syn_sql = $inqueries->agent_production_per_product_periods($year,1,$month,$agent["inag_agent_code"],$section_sql,$section_way);
			$ssql = $sybase->query($prod_syn_sql,1);
			
			while ($spremium = $sybase->fetch_assoc($ssql)) {
				
				$data[$agent["inag_group_code"]][$section]["premium"] += $spremium["clo_ytd_premium"];
				$data[$agent["inag_group_code"]][$section]["fees"] += $spremium["clo_period_fees"];
				$data[$agent["inag_group_code"]][$section]["commission"] += $spremium["clo_commission"];
				$data[$agent["inag_group_code"]][$section]["stamps"] += $spremium["clo_period_stamps"];
				$data[$agent["inag_group_code"]][$section]["mif"] += $spremium["clo_period_mif"];
			
			}

			//claims for cymenu
			if ($section == 'ALL') {
				$section_sql = "";
			}
			else if ($section == 'NON') {
				$section_sql = "AND acl_klados != '19'";
			}
			else {
				$section_sql = "AND acl_klados = '".$section."'";
			}
			$sql = "SELECT SUM(acl_ekremis)as ekremis , SUM(acl_pliromes)as pliromes, COUNT(acl_claims_ID)as claims FROM ap_claims WHERE acl_agent_ID = '".$agent["inag_numeric_key1"]."' ".$section_sql." AND acl_year = '".$year."' AND acl_month = '".$month."'";
			$claim = $db->query_fetch($sql);
			$data[$agent["inag_group_code"]][$section]["ekremis"] += $claim["ekremis"];
			$data[$agent["inag_group_code"]][$section]["pliromes"] += $claim["pliromes"];
			$data[$agent["inag_group_code"]][$section]["claims"] += $claim["claims"];
		
		
		
			//claims for synthesis===============================================================================================================
			if ($section == 'ALL'){
				$section_sql = "%%";
				$section_way = 'LIKE';
			}
			else if ($section == 'NON'){
				$section_sql = "19";
				$section_way = '<>';
			}
			else{
				$section_sql = $section;
				$section_way = 'LIKE';
			}
			
			$extra_sql = "AND inclm_open_date >= '".$year."-01-01' AND inclm_open_date <= '".$as_at_date."' ";
			//$extra_sql .= "AND clo_process_status in ('O','R','C')";
			$querysql = $inqueries->claims_oustanding_payments($as_at_date,1,$agent["inag_agent_code"],$section_sql,$section_way,$extra_sql);
			$ssql = $sybase->query($querysql);
			


			while ($sclaim = $sybase->fetch_assoc($ssql)) {
				
				$data[$agent["inag_group_code"]][$section]["claims"]++;
				$data[$agent["inag_group_code"]][$section]["pliromes"] += $sclaim["clo_amount_paid"];
				$data[$agent["inag_group_code"]][$section]["ekremis"] += $sclaim["clo_estimated_reserve"] - $sclaim["clo_amount_paid"];

			}
		
		}//while per agent from ap_agents
		
	}//foreach section
return $data;
}//function get_data_for_area


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
    <Layout x:Orientation=\"Landscape\"/>
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
     <ActiveRow>14</ActiveRow>
     <ActiveCol>18</ActiveCol>
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
	$xml->clumn_width(10,40 - $column_size);
	
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
			//fix some numbers
			$value["premium"] = fix_numbers_to_zero($value["premium"]);
			$value["pliromes"] = fix_numbers_to_zero($value["pliromes"]);
			$value["ekremis"] = fix_numbers_to_zero($value["ekremis"]);
			
			
			$xml->write($row,0,$value["code"],'normal','String');	
			$xml->write($row,1,$value["name"],'normal','String');	
			$xml->write($row,2,$value["section"],'centered','String');	
			$xml->write($row,3,$value["premium"],'centered','Number');	
			$xml->write($row,4,$value["pliromes"],'centered','Number');	
			$xml->write($row,5,$value["ekremis"],'centered','Number');	
			$xml->write($row,6,$value["claims"],'centered','Number');
			$xml->write($row,7,fix_numbers_to_zero($value["pliromes"] + $value["ekremis"]),'centered','Number');
			if ($value['claims'] > 0) {
				$xml->insert_formula($row,8,'centered','Number','ROUND(RC[-1]/RC[-2],0)');
				$xml->insert_formula($row,9,'centered','Number','ROUND(RC[-6]/RC[-3],0)');
				$xml->insert_formula($row,10,'percentage','Number','ROUND(RC[-3]/RC[-7],2)');		
			}//if claims > 0
			else {
				$xml->write($row,8,'','centered','String');
				$xml->insert_formula($row,9,'centered','Number','ROUND(RC[-6],0)');
				$xml->write($row,10,0,'normal','Number');	
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
				$reinsurance_value = $value["premium"]*$rates[$value["section"]];
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
				
				if ($value["section"] == 'ALL') {
					
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
					$prem_per[$value["section"]]["premium"] = $value["premium"];
					$prem_per[$value["section"]]["row"] = $row;
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
?>