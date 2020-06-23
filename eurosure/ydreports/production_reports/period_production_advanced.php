<?
//ini_set("memory_limit","128M");
//ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
$sybase = new Sybase();


//=============================================================================================================

if ($_POST["action"] == "submit") {
$queries = new insurance_queries();

	//loop through the years.
	for ($year = $_POST["year_from"]; $year <= $_POST["year_to"]; $year++) {
	
		//loop through the agents
		if ($_POST["agent_from"] != "") 
			$agent_sql = "AND inag_agent_code >= '".$_POST["agent_from"]."' AND inag_agent_code <= '".$_POST["agent_to"]."'";
		$sqlagents = "SELECT * FROM inagents WHERE inag_agent_type = 'A' ".$agent_sql." ORDER BY inag_agent_code ASC";

		$res_agents = $sybase->query($sqlagents);
		$p =0;
		while ($agent = $sybase->fetch_assoc($res_agents,1)) {
			
			//SYNTHESIS
			if ($year >= 2009) {
			
				$extra_sql = '';
				if ($_POST["klado_from"] != "") {
					$extra_sql = "AND inity_major_category >= '".$_POST["klado_from"]."' AND inity_major_category <= '".$_POST["klado_to"]."'";
				}
				if ($_POST["klado_exclude"] != "") {
					$extra_sql .= "AND inity_major_category NOT LIKE '".$_POST["klado_exclude"]."'";
				}
				
				$sql = $queries->agent_production_per_product_periods($year,$_POST["month_from"],$_POST["month_to"],$agent["inag_agent_code"],'%%','LIKE','%%',$extra_sql);

				$result = $sybase->query($sql);
				
				while ($row = $sybase->fetch_assoc($result)) {

					if ($_POST["column_per_year"] == 1) {
					
						//$data[$agent["inag_agent_code"]]["all_years"]["Year"] = 'All Years';
						$data[$agent["inag_agent_code"]]["all_years"]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
						$data[$agent["inag_agent_code"]]["all_years"]["Agent_Code"] = $agent["inag_agent_code"];
						$data[$agent["inag_agent_code"]]["all_years"]["Old_Code"] = $agent["inag_numeric_key1"];
						$data[$agent["inag_agent_code"]]["all_years"]["Agent_Name"] = $agent["inag_long_description"];
						//$data[$agent["inag_agent_code"]]["all_years"]["Total_Premium"] += $row["clo_ytd_premium"];
						$data[$agent["inag_agent_code"]]["all_years"][$year] += $row["clo_ytd_premium"];
						$old_agents[$agent["inag_numeric_key1"]] = 1;
						

					
					}//if column per year = 1
					else {
						if ($_POST["all_years"] == 1) {
							$data[$agent["inag_agent_code"]]["all_years"]["Year"] = 'All Years';
							$data[$agent["inag_agent_code"]]["all_years"]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
							$data[$agent["inag_agent_code"]]["all_years"]["Agent_Code"] = $agent["inag_agent_code"];
							$data[$agent["inag_agent_code"]]["all_years"]["Old_Code"] = $agent["inag_numeric_key1"];
							$data[$agent["inag_agent_code"]]["all_years"]["Agent_Name"] = $agent["inag_long_description"];
							$data[$agent["inag_agent_code"]]["all_years"]["Total_Premium"] += $row["clo_ytd_premium"];
							$data[$agent["inag_agent_code"]]["all_years"][$row["clo_sort2"]] += $row["clo_ytd_premium"];
							$old_agents[$agent["inag_numeric_key1"]] = 1;
						}
						
						$data[$agent["inag_agent_code"]][$year]["Year"] = $year;
						$data[$agent["inag_agent_code"]][$year]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
						$data[$agent["inag_agent_code"]][$year]["Agent_Code"] = $agent["inag_agent_code"];
						$data[$agent["inag_agent_code"]][$year]["Old_Code"] = $agent["inag_numeric_key1"];
						$data[$agent["inag_agent_code"]][$year]["Agent_Name"] = $agent["inag_long_description"];
						$data[$agent["inag_agent_code"]][$year]["Total_Premium"] += $row["clo_ytd_premium"];
						$data[$agent["inag_agent_code"]][$year][$row["clo_sort2"]] += $row["clo_ytd_premium"];
						$old_agents[$agent["inag_numeric_key1"]] = 1;
					}//if column per year = 0

				}//while results
			}//if year >= 2009 ->synthesis production	
	

				//MANUAL FIX OF SOME AGENTS THAT APPEAR TWICE AND DESTROY THE TOTALS
				if ($agent["inag_agent_code"] == '100.2200' || $agent["inag_agent_code"] == '201.2201' || $agent["inag_agent_code"] == '201.2214') {
					$remove_agent_2009 = 1;
					$out_agents .= $agent["inag_agent_code"]."<hr>";
				}
				else {
					$remove_agent_2009 = 0;
				}

				if ($year <= 2010 && $remove_agent_2009 == 0) {
	
					//if agents exists in new system
					if ($agent["inag_numeric_key1"] != 0) {
			
						$sql = "SELECT SUM(aaf_premium)as prem, aaf_klados FROM `ap_asci_full` 
							WHERE aaf_year = '".$year."'
							AND aaf_month >= '".$_POST["month_from"]."'
							AND aaf_month <= '".$_POST["month_to"]."'
							AND aaf_agent = '".$agent["inag_numeric_key1"]."'
							GROUP BY aaf_agent,aaf_klados
							ORDER BY aaf_klados";

						$res = $db->query($sql);
						while ($row = $db->fetch_assoc($res)) {
							
							if ($_POST["column_per_year"] == 1) {
					
								//$data[$agent["inag_agent_code"]]["all_years"]["Year"] = 'All Years';
								$data[$agent["inag_agent_code"]]["all_years"]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
								$data[$agent["inag_agent_code"]]["all_years"]["Agent_Code"] = $agent["inag_agent_code"];
								$data[$agent["inag_agent_code"]]["all_years"]["Old_Code"] = $agent["inag_numeric_key1"];
								$data[$agent["inag_agent_code"]]["all_years"]["Agent_Name"] = $agent["inag_long_description"];
								//$data[$agent["inag_agent_code"]]["all_years"]["Total_Premium"] += $row["clo_ytd_premium"];
								$data[$agent["inag_agent_code"]]["all_years"][$year] += $row["prem"];
								$old_agents[$agent["inag_numeric_key1"]] = 1;
							
							}//if column per year = 1
							else {	

								if ($_POST["all_years"] == 1) {
									$data[$agent["inag_agent_code"]]["all_years"]["Year"] = 'All Years';
									$data[$agent["inag_agent_code"]]["all_years"]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
									$data[$agent["inag_agent_code"]]["all_years"]["Agent_Code"] = $agent["inag_agent_code"];
									$data[$agent["inag_agent_code"]]["all_years"]["Old_Code"] = $agent["inag_numeric_key1"];
									$data[$agent["inag_agent_code"]]["all_years"]["Agent_Name"] = $agent["inag_long_description"];
									$data[$agent["inag_agent_code"]]["all_years"]["Total_Premium"] += $row["prem"];
									$data[$agent["inag_agent_code"]]["all_years"][$row["aaf_klados"]] += $row["prem"];
									$old_agents[$agent["inag_numeric_key1"]] = 1;
								}
								
								$data[$agent["inag_agent_code"]][$year]["Year"] = $year;
								$data[$agent["inag_agent_code"]][$year]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
								$data[$agent["inag_agent_code"]][$year]["Agent_Code"] = $agent["inag_agent_code"];
								$data[$agent["inag_agent_code"]][$year]["Old_Code"] = $agent["inag_numeric_key1"];
								$data[$agent["inag_agent_code"]][$year]["Agent_Name"] = $agent["inag_long_description"];
								$data[$agent["inag_agent_code"]][$year]["Total_Premium"] += $row["prem"];
								$data[$agent["inag_agent_code"]][$year][$row["aaf_klados"]] += $row["prem"];
								$old_agents[$agent["inag_numeric_key1"]] = 1;
								
								
							}//if column per year = 0
							
						}//while agent production lines
			
					}//if agent exists in sysnthesis
		
				}//cymenu 

				
			

			//prepare the data for output.

		$p++;
		}//while loop agent

	
	}//loop years
	
	
	for ($year = $_POST["year_from"]; $year <= $_POST["year_to"]; $year++) {
	
		//fix productions < 2010 for some agents that do not exists in synthesis and the above skips them.
		//get the production from all the database and loop in to find agents that where not included
		if ($_POST["agent_from"] != "") {
			$extra_sql = "AND aaf_agent <= ".substr($_POST["agent_from"],5)." AND aaf_agent >= ".substr($_POST["agent_to"],5)."";
		}

		$sql = "SELECT aaf_agent,SUM(aaf_premium)as prem, aaf_klados 
				FROM `ap_asci_full` 
				WHERE aaf_year = '".$year."'
				AND aaf_month >= '".$_POST["month_from"]."'
				AND aaf_month <= '".$_POST["month_to"]."'
				".$extra_sql."
				GROUP BY aaf_agent,aaf_klados
				ORDER BY aaf_klados";
		$res = $db->query($sql);
		while ($row = $db->fetch_assoc($res)) {
			if ($old_agents[$row["aaf_agent"]] != 1) {
			
				if ($_POST["column_per_year"] == 1) {
					
					$data[$row["aaf_agent"]]["all_years"]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
					$data[$row["aaf_agent"]]["all_years"]["Old_Code"] = $row["aaf_agent"];
					$data[$row["aaf_agent"]]["all_years"][$year] += $row["prem"];
							
				}//if column per year = 1
				else {	

					if ($_POST["all_years"] == 1) {
						$data[$row["aaf_agent"]]["all_years"]["Year"] = $year;
						$data[$row["aaf_agent"]]["all_years"]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
						//$data[$row["aaf_agent"]]["all_years"]["Agent_Code"] = $agent["inag_agent_code"];
						$data[$row["aaf_agent"]]["all_years"]["Old_Code"] = $row["aaf_agent"];
						$data[$row["aaf_agent"]]["all_years"]["Total_Premium"] += $row["prem"];
						$data[$row["aaf_agent"]]["all_years"][$row["aaf_klados"]] += $row["prem"];			
					}
					$data[$row["aaf_agent"]][$year]["Year"] = $year;
					$data[$row["aaf_agent"]][$year]["Months"] = $_POST["month_from"]."-".$_POST["month_to"];
					//$data[$row["aaf_agent"]][$year]["Agent_Code"] = $agent["inag_agent_code"];
					$data[$row["aaf_agent"]][$year]["Old_Code"] = $row["aaf_agent"];
					$data[$row["aaf_agent"]][$year]["Total_Premium"] += $row["prem"];
					$data[$row["aaf_agent"]][$year][$row["aaf_klados"]] += $row["prem"];
				
				}
			}
		}


	
	}//all years second for agents fix

	
	
	
	
//print_r($data);

$i=0;

	if ($_POST["output_type"] == "delimited") {
		foreach ($data as $agent => $agent_value) {
				
			foreach($agent_value as $year => $year_value) {
				
				foreach($year_value as $name => $value) {
					$array[$i][$name] = $value;
					$fields[$name] = $name;
					
				}
			$i++;
				
			}
	
		}//for each group by
	
	export_data_delimited($array,$fields,'#','none','download','
','data');
	}
//XML
	else if ($_POST["output_type"] == "xml") {
		include("../../include/libraries/ExcelWriterXML/ExcelWriterXML.php");
		$xml = new ExcelWriterXML('Period Production Advanced.xml');
		$xml->docTitle('Period Production Advanced');
		$xml->showErrorSheet(true);
		$format1 = $xml->addStyle('center');
		$format1->alignHorizontal('Center');

		$format2 = $xml->addStyle('center-bold');
		$format2->alignHorizontal('Center');
		$format2->fontBold();
		
		$sheet1 = $xml->addSheet('Production',$format2);
		$sheet1->writeString(1,1,'Agent Code');
		$sheet1->columnWidth(1,'60');
		
		$sheet1->writeString(1,2,'Agent Name',$format2);
		$sheet1->columnWidth(2,'150');
		
		$sheet1->writeString(1,3,'Year',$format2);
		$sheet1->columnWidth(3,'40');

		$sheet1->writeNumber(1,4,10,$format2);
		$sheet1->writeNumber(1,5,11,$format2);
		$sheet1->writeNumber(1,6,16,$format2);
		$sheet1->writeNumber(1,7,17,$format2);
		$sheet1->writeNumber(1,8,19,$format2);
		$sheet1->writeNumber(1,9,21,$format2);
		$sheet1->writeNumber(1,10,22,$format2);
		$sheet1->writeString(1,11,'Total',$format2);
		
		//$sheet1->writeString(1,2,'Year');
			$row = 1;
			$agent_count = 0;
			$year_count = 0;
			foreach ($data as $agent => $agent_value) {
			$agent_count++;
				foreach($agent_value as $year => $year_value) {
					$year_count++;
					//foreach($year_value as $name => $value) {
					$row++;
					
					$sheet1->writeString($row,1,$year_value["Agent_Code"]);
					$sheet1->writeString($row,2,$year_value["Agent_Name"]);
					$sheet1->writeNumberString($row,3,$year_value["Year"]);
					$sheet1->writeNumberString($row,4,$year_value["10"],$format1);
					$sheet1->writeNumberString($row,5,$year_value["11"],$format1);
					$sheet1->writeNumberString($row,6,$year_value["16"],$format1);
					$sheet1->writeNumberString($row,7,$year_value["17"],$format1);
					$sheet1->writeNumberString($row,8,$year_value["19"],$format1);
					$sheet1->writeNumberString($row,9,$year_value["21"],$format1);
					$sheet1->writeNumberString($row,10,$year_value["22"],$format1);
					$sheet1->writeNumberString($row,11,$year_value["Total_Premium"],$format2);
					
					//echo $agent_count." -> ".$year_count." => ".$value."<br>";
						
					//}
				}
		
			}//for each group by
			//print_r($data);

		
		$xml->sendHeaders();
		$xml->writeData();
		$db->main_exit();
		exit();
	}
}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="453" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Period Production Report </td>
    </tr>
    <tr>
      <td width="154" height="28">Year</td>
      <td width="299">From
        <input name="year_from" type="text" id="year_from" value="<? echo $_POST["year_from"];?>" size="6">
        To
        <input name="year_to" type="text" id="year_to" value="<? echo $_POST["year_to"];?>" size="6" /></td>
    </tr>
    <tr>
      <td height="28">Month</td>
      <td>From
        <input name="month_from" type="text" id="month_from" value="<? echo $_POST["month_from"];?>" size="6" />
To
<input name="month_to" type="text" id="month_to" value="<? echo $_POST["month_to"];?>" size="6" /></td>
    </tr>
    <tr>
      <td height="28">Agents</td>
      <td>From
        <input name="agent_from" type="text" id="agent_from" value="<? echo $_POST["agent_from"];?>" size="8" />
To
<input name="agent_to" type="text" id="agent_to" value="<? echo $_POST["agent_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category(Klado)  </td>
      <td>From
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["insurance_type_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["insurance_type_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["insurance_type_exclude"];?>"/>
      (exclude) ex 17% </td>
    </tr>
    <tr>
      <td height="28">Inlcude All Years Line? </td>
      <td><input name="all_years" type="checkbox" id="all_years" value="1" <? if ($_POST["all_years"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    
    
    
    <tr>
      <td height="28">One Column Per Year </td>
      <td><input name="column_per_year" type="checkbox" id="column_per_year" value="1" <? if ($_POST["column_per_year"] == 1) echo "checked=\"checked\"";?>  />
      This will disable production per category. </td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td><select name="output_type" id="output_type">
        <option value="delimited">Delimited</option>
        <option value="xml" <? if ($_POST["output_type"] == "xml") echo "selected=\"selected\"";?>>Export XML</option>
      </select></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<?
$db->show_footer();
?>