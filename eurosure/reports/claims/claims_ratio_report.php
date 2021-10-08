<?
ini_set("memory_limit","128M");
set_time_limit(1200);
include("../../include/main.php");
$db = new Main(1,'Windows-1253');
include("../../include/sybasecon.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$inqueries = new insurance_queries();

$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');


if ($_POST["action"] == "show") {

	if ($_POST["agents_code_by"] == "agent_code") {
		include("claims_ratio_report_functions.php");		
	}else {
		include("claims_ratio_report_functions_v2.php");
	}




if ($_POST["reinsurance"] == 1 || $_POST["expenses"] == 1 || $_POST["profit"] == 1) {
	$font_size = 7;
}
else {
	$font_size = 9;
}
	
$xml = new xmltoexcel('test.xml','UTF-8');
//add some styles
$xml->add_style('bold',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"".$font_size."\" ss:Bold=\"1\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
$xml->add_style('centered',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"".$font_size."\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
$xml->add_style('normal',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Left\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"".$font_size."\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
$xml->add_style('percentage',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"".$font_size."\" x:Family=\"Swiss\"/>
   <Interior/>
   <NumberFormat ss:Format=\"Percent\"/>
   <Protection/>");
$xml->add_style('headers',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"".$font_size."\" x:Family=\"Swiss\" ss:Bold=\"1\"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>");	
$xml->add_style('percentage_0',"<Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"".$font_size."\"/>
   <Interior/>
   <NumberFormat ss:Format=\"0%\"/>
   <Protection/>");	
$xml->add_style('percentage_0_bold',"<Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" x:Family=\"Swiss\" ss:Size=\"".$font_size."\" ss:Bold=\"1\"/>
   <Interior/>
   <NumberFormat ss:Format=\"0%\"/>
   <Protection/>");	
$xml->add_style('green_bold',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"".$font_size."\" x:Family=\"Swiss\" ss:Bold=\"1\" ss:Color=\"#00B050\"/>
   <Interior/>
   <NumberFormat ss:Format=\"0%\"/>
   <Protection/>");	
$xml->add_style('red_bold',"<Alignment ss:Vertical=\"Bottom\" ss:Horizontal=\"Center\" ss:WrapText=\"1\"/>
   <Borders/>
   <Font ss:FontName=\"Arial\" x:CharSet=\"161\" ss:Size=\"".$font_size."\" x:Family=\"Swiss\" ss:Bold=\"1\" ss:Color=\"#FF0000\"/>
   <Interior/>
   <NumberFormat ss:Format=\"0%\"/>
   <Protection/>");	

if ($_POST["insurance_type"] != "") {
	$other_sql = " AND inity_insurance_type = '".$_POST["insurance_type"]."'";
}

$result = get_data_for_area('1',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'Central');
$result = get_data_for_area('2',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'Nicosia');
$result = get_data_for_area('3',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'Paralimni');
$result = get_data_for_area('4',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'Larnaka');
$result = get_data_for_area('5',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'Limassol');
$result = get_data_for_area('6',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'Pafos');
$result = get_data_for_area('%',1,$_POST["section"],$_POST["month"],$_POST["year"],$_POST["as_at_date"],$_POST["agents_from"],$_POST["agents_to"],$other_sql);
load_data_to_xml($result,'ALL');


//create the file
$xml->export_xml();
//$file = "export_file.xml";
//$handle = fopen($file,"w");
//fwrite($handle,$xml->export);
//fclose($handle);
//$out = "<a href=\"export_file.xml\">download file</a>";

export_download_variable($xml->export,$_POST["year"]."-".$_POST["month"]."-".$_POST["section"].".xml");
exit();

}//if action show



$db->show_header();
?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});

});

</script>

<form action="" method="post"><table width="577" border="1" align="center">
  <tr>
    <td colspan="2" align="center">Claims Ratio Report </td>
    </tr>
  <tr>
    <td width="132">Section</td>
    <td width="429"><select name="section" id="section">
      <option value="10" <? if ($_POST["section"] == '10') echo "selected=\"selected\"";?>>10 P.A</option>
      <option value="11" <? if ($_POST["section"] == '11') echo "selected=\"selected\"";?>>11 Medical</option>
      <option value="16" <? if ($_POST["section"] == '16') echo "selected=\"selected\"";?>>16 Goods In Transit</option>
      <option value="17" <? if ($_POST["section"] == '17') echo "selected=\"selected\"";?>>17 Fire</option>
      <option value="19" <? if ($_POST["section"] == '19') echo "selected=\"selected\"";?>>19 Motor</option>
      <option value="21" <? if ($_POST["section"] == '21') echo "selected=\"selected\"";?>>21 Marine</option>
      <option value="22" <? if ($_POST["section"] == '22') echo "selected=\"selected\"";?>>22 P.L</option>
      <option value="ALL" <? if ($_POST["section"] == 'ALL') echo "selected=\"selected\"";?>>ALL Grouped</option>
      <option value="10,11,16,17,19,21,22,ALL" <? if ($_POST["section"] == '10,11,16,17,19,21,22,ALL') echo "selected=\"selected\"";?>>ALL Separated/Total</option>
      <option value="NON" <? if ($_POST["section"] == 'NON') echo "selected=\"selected\"";?>>Non Motor</option>
      <option value="19,NON" <? if ($_POST["section"] == '19,NON') echo "selected=\"selected\"";?>>Motor/Non Motor</option>
      <option value="19,NON,ALL" <? if ($_POST["section"] == '19,NON,ALL') echo "selected=\"selected\"";?>>Motor/Non Motor/Total</option>
    </select>    </td>
  </tr>
  <tr>
    <td>Insurance Type</td>
    <td><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_POST["insurance_type"];?>" /></td>
  </tr>
  <tr>
    <td>Year</td>
    <td><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
  </tr>
  <tr>
    <td>Up To Month</td>
    <td><input name="month" type="text" id="month" value="<? echo $_POST["month"];?>">
    Always starts from 01/01/year </td>
  </tr>
  <tr>
    <td>As At Date </td>
    <td>      <input name="as_at_date" type="text" id="as_at_date" value="<? if ($_POST["as_at_date"] == "") echo "2011-12-31"; else echo $_POST["as_at_date"];?>">
    YYYY-MM-DD 2009-12-31 (Claim Open date is 01/01/year up to as at date) </td>
  </tr>
  <tr>
    <td>Agents Range </td>
    <td>From:
      <input name="agents_from" type="text" id="agents_from" size="9" value="<? echo $_POST["agents_from"];?>" />
      To:
      <input name="agents_to" type="text" id="agents_to" size="9" value="<? echo $_POST["agents_to"];?>" /> 
      New Codes Only </td>
  </tr>
  <tr>
    <td align="left">Agents Code By</td>
    <td align="left"><select name="agents_code_by" id="agents_code_by">
      <option value="agent_code" <? if ($_POST["agents_code_by"] == 'agent_code') echo "selected=\"selected\"";?>>Agent Code</option>
      <option value="agent_group_code" <? if ($_POST["agents_code_by"] == 'agent_group_code') echo "selected=\"selected\"";?>>Agent Group Code</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>EXTRAS</strong></td>
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
      % of class based on the total premium (ALL Line must exists) </td>
  </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="submit" name="Submit" value="Submit"></td>
  </tr>
</table>
</form>



<? echo $out;?>


<?
$db->show_footer();
?>