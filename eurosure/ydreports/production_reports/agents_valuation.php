<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1,'UTF-8');
include("../../include/sybasecon.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
//include("claims_ratio_report_functions.php");
include("../../tools/export_data.php");


if ($_POST["action"] == "show"){
//create the xml
$xml = new xmltoexcel('agents_valuation.xml' , 'UTF-8');
//add some styles
$xml->add_style('bold',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"7\" ss:Bold=\"1\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
$xml->add_style('centered',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"7\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
$xml->add_style('percentage',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"7\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat ss:Format=\"Percent\"/>
   <Protection/>");
$xml->add_style('normal',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Left\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"7\" />
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
   
   
   
	//get all the agents first
	if ($_POST["first_agent"] != "" && $_POST["last_agent"] != "") {
		$sql_extra = "WHERE ap_agents_code >= '".$_POST["first_agent"]."' AND ap_agents_code <= '".$_POST["last_agent"]."' AND ap_active = 1";
	} 
	else {
		$sql_extra = "";
	}
	$sql = "SELECT * FROM ap_agents ".$sql_extra." ORDER BY ap_agents_code ASC";
	$result = $db->query($sql);
	while ($agent = $db->fetch_assoc($result)) {
		$row = 0;
		
		
		//create the agent worksheet
		$xml->add_spreadsheet($agent["ap_agents_code"]);
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
		
		//create the headers
		$column=0;
		$xml->clumn_width($column,'40');
		$xml->write($row ,$column,'Agent','bold',"String");$column++;

		$xml->clumn_width($column,'80');
		$xml->write($row ,$column,'Agent Name','bold',"String");$column++;

		$xml->clumn_width($column,'20');
		$xml->write($row ,$column,'Year','bold',"String");$column++;

		$xml->clumn_width($column,'23');
		$xml->write($row ,$column,'Class','bold',"String");$column++;

		$xml->clumn_width($column,'40');
		$xml->write($row ,$column,'Premium','bold',"String");$column++;

		$xml->clumn_width($column,'34');
		$xml->write($row ,$column,'Earned','bold',"String");$column++;

		$xml->clumn_width($column,'40');
		$xml->write($row ,$column,'UnEarned','bold',"String");$column++;

		$xml->clumn_width($column,'45');
		$xml->write($row ,$column,'Y.Earned Pr.','bold',"String");$column++;

		$xml->clumn_width($column,'23');
		$xml->write($row ,$column,'Fees','bold',"String");$column++;

		$xml->clumn_width($column,'40');
		$xml->write($row ,$column,'Tot.Prem.','bold',"String");$column++;

		$xml->clumn_width($column,'30');
		$xml->write($row ,$column,'Comm.','bold',"String");$column++;

		$xml->clumn_width($column,'30');
		$xml->write($row ,$column,'Claims','bold',"String");$column++;

		$xml->clumn_width($column,'28');
		$xml->write($row ,$column,'Reins','bold',"String");$column++;

		$xml->clumn_width($column,'23');
		$xml->write($row ,$column,'Rents','bold',"String");$column++;

		//$xml->clumn_width($column,'40');
		//$xml->write($row ,$column,'Ot.Fees','bold',"String");$column++;

		$xml->clumn_width($column,'25');
		$xml->write($row ,$column,'Exps','bold',"String");$column++;

		$xml->clumn_width($column,'40');
		$xml->write($row ,$column,'Gr Profit','bold',"String");$column++;

		$xml->clumn_width($column,'50');
		$xml->write($row ,$column,'Gr N Profit','bold',"String");$column++;

		$xml->clumn_width($column,'40');
		$xml->write($row ,$column,'Actual Gr P/L','bold',"String");$column++;

		$xml->clumn_width($column,'50');
		$xml->write($row ,$column,'Actual N P/L','bold',"String");$column++;

		$row++;
		
		//for each year
		for($i = $_POST["start_year"] ; $i<= $_POST["end_year"];$i++) {
		
			//fix some agents
			if ($agent["ap_agents_code_old"] == '251')
				$extra_agent = " OR ap_agent = '205'";
			else
				$extra_agent = '';
		
			$sql = "SELECT * FROM ap_agents_valuation WHERE (ap_agent = '".$agent["ap_agents_code"]."' OR ap_agent = '".$agent["ap_agents_code_old"]."' ".$extra_agent.") AND ap_year = '".$i."' AND (ap_premium != '' OR ap_commision != '' OR ap_total_claims != '' )  ORDER BY ap_class ASC";
			
			
			$rowres = $db->query($sql);
			
			$starting_row = $row;
			$found_to_show = 0;
			$data ='';
			while ($data = $db->fetch_assoc($rowres)) {
			$found_to_show=1;
				$column=0;
				//use 0 for premium if empty
				if ($data["ap_premium"] == "") {
					$data["ap_premium"] = '0';
					$earned = '0';
				}
				else {
					$earned = ($data["ap_premium"]*0.65);
				}
				//unearned premium
				$class_row[$i][$data["ap_class"]] = $row;
				$previous_earned[$i][$data["ap_class"]] = 1;
				if ($i == $_POST["start_year"]) {
					$yearned = 'RC[-2]';
				}
				else {
					if ($previous_earned[$i-1][$data["ap_class"]] != 1) {
						$yearned = 'RC[-2]';
					}
					else {
						$yearned = "RC[-2]+R[-".($row - $class_row[$i-1][$data["ap_class"]])."]C[-1]";
					}
				}



				$xml->write($row ,$column,$agent["ap_agents_code"],'normal',"String");$column++;
				$xml->write($row ,$column,$agent["ap_name"],'normal',"String");$column++;
				$xml->write($row ,$column,$i,'bold',"Number");$column++;
				$xml->write($row ,$column,$data["ap_class"],'centered',"Number");$column++;
				$xml->write($row ,$column,make_cur($data["ap_premium"],$i),'centered',"Number");$column++;

				$xml->write($row ,$column,make_cur(round($earned,0),$i),'centered',"Number");$column++;
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-2]-RC[-1],0)");$column++;
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(".$yearned.",0)");$column++;

				$xml->write($row ,$column,make_cur($data["ap_fees"],$i),'centered',"Number");$column++;
				$xml->write($row ,$column,make_cur(($data["ap_premium"] + $data["ap_fees"]),$i),'centered',"Number");$column++;
				$xml->write($row ,$column,make_cur($data["ap_commision"],$i),'centered',"Number");$column++;
				$xml->write($row ,$column,make_cur($data["ap_total_claims"],$i),'centered',"Number");$column++;
				
				//reinsurance 
				$reins = $db->query_fetch("SELECT * FROM `settings` WHERE `stg_section` = 'ap_agents_valuation_reins_".$data["ap_class"]."_rate_".$i."'");
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-3]*".$reins["stg_value"].",0)");$column++;

				$xml->write($row ,$column,make_cur($data["ap_rents"],$i),'centered',"Number");$column++;
				//$xml->write($row ,$column,make_cur($data["ap_other_fees"],$i),'centered',"Number");$column++;

				$expen = $db->query_fetch("SELECT * FROM `settings` WHERE `stg_section` = 'ap_agents_valuation_expense_rate_".$i."'");
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-7]*".$expen["stg_value"].",0)");$column++;

				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-11]+RC[-7]-RC[-5]-RC[-4]-RC[-3]-RC[-2]-RC[-1],0)");$column++;
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-12]-RC[-6]-RC[-5]-RC[-4]-RC[-3]-RC[-2],0)");$column++;
				
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-10]+RC[-9]-RC[-7]-RC[-6]-RC[-5]-RC[-4]-RC[-3],0)");$column++;
				$xml->insert_formula($row,$column,'centered','Number',"ROUND(RC[-11]-RC[-8]-RC[-7]-RC[-6]-RC[-5]-RC[-4],0)");$column++;
				
				
				
				$row++;
				
			}//each class
			
			if ($found_to_show == 1) {
				$xml->write($row ,0,'TOTAL','bold',"String");
				$xml->write($row ,1,'For Year '.$i,'bold',"String");
				$xml->insert_formula($row,4,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,5,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,6,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,7,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,8,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,9,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,10,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,11,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,12,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,13,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,14,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,15,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,16,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,17,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
				$xml->insert_formula($row,18,'bold','Number',"SUM(R[-".($row - $starting_row)."]C:R[-1]C)");			
	
				$row++;
				
			}//if found to show
		}//each year
	
	}//while per agent
	
$xml->export_xml();	
export_download_variable($xml->export,"agents_valuation.xml");


}//if show
$db->show_header();
?>
<form action="" method="post">
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="117">First Agent </td>
      <td width="283"><input name="first_agent" type="text" id="first_agent" value="<? if ($_POST["first_agent"] == "") echo "100.2000"; echo $_POST["first_agent"];?>"></td>
    </tr>
    <tr>
      <td>Last Agent </td>
      <td><input name="last_agent" type="text" id="last_agent" value="<? if ($_POST["last_agent"] == "") echo "999.9999"; echo $_POST["last_agent"];?>"></td>
    </tr>
    <tr>
      <td>Start Year </td>
      <td><input name="start_year" type="text" id="start_year" value="<? if ($_POST["start_year"] == "") echo "2003"; echo $_POST["start_year"];?>"></td>
    </tr>
    <tr>
      <td>End Year </td>
      <td><input name="end_year" type="text" id="end_year" value="<? if ($_POST["start_year"] == "") echo "2009"; echo $_POST["end_year"];?>"></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<? 
function get_class_name($class) {
	if ($class == 10) {
		return 'ACCIDENT';
	}
	else if($class == 16) {
		return 'GOODS IN TRANSFER';
	}
	else if($class == 17) {
		return 'FIRE';
	}
	else if($class == 19) {
		return 'MOTOR';
	}
	else if($class == 21) {
		return 'MARINE';
	}
	else if($class == 22) {
		return 'LIABILITY';
	}
	else
		return 'EMPTY';
}
function make_cur($amount,$year) {
	if ($amount == '')
		return '0';
	if (is_null($amount))
		return '0';
	if (!(is_numeric($amount)))
		return '0';
	if ($amount == 0 )
		return '0';
		


	if ($year > 2007){
		return round($amount,0);
	}
	else {
		return round(($amount/0.585274),0);
	}

}
$db->show_footer();
?> 