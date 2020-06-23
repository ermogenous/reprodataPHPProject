<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1,'UTF-8');
include("../../include/sybasecon.php");
include("../../include/sybase_sqls.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("claims_ratio_report_functions.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$inqueries = new insurance_queries();

$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');

if ($_POST["action"] == "show") {

	$asatdate = $_POST["as_at_date"];
	$from_period = $_POST["month_from"];
	$to_period = $_POST["month_to"];
	
	if ($_POST["agent"] == "") {
		$agent = '%%';
	}
	else {
		$agent = $_POST["agent"];
	}
	
	$year = $_POST["year"];
	
	if ($_POST["section"] != 'ALL') {
		$section_sql = $_POST["section"];
	}
	else {
		$section_sql = '%%';
	}
	

	if ($_POST["drivers_age_from"] != "" && $_POST["drivers_age_to"] != "") {
	
		$extra_sql .= "AND clo_driver_age BETWEEN ".$_POST["drivers_age_from"]." AND ".$_POST["drivers_age_to"];
	
	}//drivers age
	if ($_POST["drivers_experience_from"] != "" && $_POST["drivers_experience_to"] != "") {
	
		$extra_sql .= "AND clo_driver_licence_years BETWEEN ".$_POST["drivers_experience_from"]." AND ".$_POST["drivers_experience_to"];
	
	}//drivers experience
	
	$extra_sql .= "AND inclm_open_date >= '".$_POST["open_date_from"]."' AND inclm_open_date <= '".$_POST["open_date_to"]."' ";
	$extra_sql .= "AND clo_process_status in ('O','R','C') ";
	$sql = $inqueries->claims_oustanding_payments_updated($asatdate,$from_period,$year,$agent,$section_sql,'LIKE',$extra_sql);
	//echo $sql;
	if ($_POST["only_totals"] != 1) {
		export_data_delimited($sql,'sybase',"@","'",'download');
	}
	else {
		
		$result = $sybase->query($sql);
		while($row = $sybase->fetch_assoc($result)) {
		
			$age[$row["clo_driver_age"]]["count"]++;
			$age[$row["clo_driver_age"]]["payments"] += $row["clo_amount_paid"] - $row["clo_recoveries_recieved"];
			$age[$row["clo_driver_age"]]["reserves"] += $row["clo_estimated_reserve"] - $row["clo_amount_paid"];

			$experience[$row["clo_driver_licence_years"]]["count"]++;
			$experience[$row["clo_driver_licence_years"]]["payments"] += $row["clo_amount_paid"] - $row["clo_recoveries_recieved"];
			$experience[$row["clo_driver_licence_years"]]["reserves"] += $row["clo_estimated_reserve"] - $row["clo_amount_paid"];		
		
		}//while all claims
		
		//get the total number of policies per age.
		$sql = policies_based_on_drivers_ages($_POST["open_date_from"],$_POST["open_date_to"],$_POST["year"]);

		$result = $sybase->query($sql);
		while ($all_ages = $sybase->fetch_assoc($result)) {
			
			$ages_parts = explode(",",$all_ages["all_ages"]);
			if (is_array($ages_parts)) {
				foreach($ages_parts as $value) {
					$age[$value]["policies"]++;
				}//per age
			}
			
		}//while all ages
		
		//get the total number of policies per experience.
		$sql = policies_based_on_drivers_experience($_POST["open_date_from"],$_POST["open_date_to"],$_POST["year"]);

		$result = $sybase->query($sql);
		while ($all_exp = $sybase->fetch_assoc($result)) {
			
			$exp_parts = explode(",",$all_exp["all_exp"]);
			if (is_array($exp_parts)) {
				foreach($exp_parts as $value) {
					if ($value == -1)
						$value = 0;
					$experience[$value]["policies"]++;
				}//per age
			}
			
		}//while all ages

		
	}//else
	

//export_download_variable($xml->export,$_POST["year"]."-".$_POST["month"]."-".$_POST["section"].".xml");

}//if action show



$db->show_header();
?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_from").datepicker({dateFormat: 'yy-mm-dd'});
$("#open_date_to").datepicker({dateFormat: 'yy-mm-dd'});


});

</script>

<form action="" method="post"><table width="577" border="1" align="center">
  <tr>
    <td colspan="2" align="center">Claims Per Section Report </td>
    </tr>
  <tr>
    <td width="132">Section</td>
    <td width="429"><select name="section" id="section">
      <option value="ALL" <? if ($_POST["section"] == 'ALL') echo "selected=\"selected\"";?>>ALL</option>
      <option value="10" <? if ($_POST["section"] == '10') echo "selected=\"selected\"";?>>10 P.A</option>
      <option value="16" <? if ($_POST["section"] == '16') echo "selected=\"selected\"";?>>16 Goods In Transit</option>
      <option value="17" <? if ($_POST["section"] == '17') echo "selected=\"selected\"";?>>17 Fire</option>
      <option value="19" <? if ($_POST["section"] == '19') echo "selected=\"selected\"";?>>19 Motor</option>
      <option value="21" <? if ($_POST["section"] == '21') echo "selected=\"selected\"";?>>21 Marine</option>
      <option value="22" <? if ($_POST["section"] == '22') echo "selected=\"selected\"";?>>22 P.L</option>
    </select>    </td>
  </tr>
  <tr>
    <td>From Year</td>
    <td><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
  </tr>
  <tr>
    <td>From Month</td>
    <td><input name="month_from" type="text" id="month_from" value="<? echo $_POST["month_from"];?>">
      To
      <input name="month_to" type="text" id="month_to" value="<? echo $_POST["month_to"];?>"></td>
  </tr>
  <tr>
    <td>As At Date </td>
    <td>      <input name="as_at_date" type="text" id="as_at_date" value="<? if ($_POST["as_at_date"] == "") echo "2010-03-31"; else echo $_POST["as_at_date"];?>">
    YYYY-MM-DD 2009-12-31   </td>
  </tr>
  <tr>
    <td>Open Date </td>
    <td>From
      <input name="open_date_from" type="text" id="open_date_from" size="8" value="<? echo $_POST["open_date_from"];?>">
      To 
      <input name="open_date_to" type="text" id="open_date_to" size="8" value="<? echo $_POST["open_date_to"];?>"></td>
  </tr>
  <tr>
    <td>Agent</td>
    <td><input name="agent" type="text" id="agent" size="9" value="<? echo $_POST["agent"];?>" />
      New Codes Only </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>EXTRAS</strong></td>
    </tr>
  <tr>
    <td>Drivers Age </td>
    <td>From
      <input name="drivers_age_from" type="text" id="drivers_age_from" size="5" maxlength="2" value="<? echo $_POST["drivers_age_from"];?>">
      To
      <input name="drivers_age_to" type="text" id="drivers_age_to" size="5" maxlength="2" value="<? echo $_POST["drivers_age_to"];?>"></td>
  </tr>
  <tr>
    <td>Drivers Experience </td>
    <td>From
      <input name="drivers_experience_from" type="text" id="drivers_experience_from" size="5" maxlength="2" value="<? echo $_POST["drivers_experience_from"];?>">
To
<input name="drivers_experience_to" type="text" id="drivers_experience_to" size="5" maxlength="2" value="<? echo $_POST["drivers_experience_to"];?>"></td>
  </tr>
  <tr>
    <td>Show Only Totals </td>
    <td><input name="only_totals" type="checkbox" id="only_totals" value="1" <? if ($_POST["only_totals"] == 1) echo "checked=\"checked\"";?>></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="submit" name="Submit" value="Submit"></td>
  </tr>
</table>
</form>

<? 
if ($_POST["action"] == "show" && $_POST["only_totals"] == 1) {
?>
<br /><br />
<div id="print_view_section_html">
<table width="664" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="5" align="center">Drivers Age </td>
  </tr>
  <tr>
    <td width="73">Age</td>
    <td width="123">Claims Count</td>
    <td width="152">Policies Count </td>
    <td width="152">Payments</td>
    <td width="152">Reserves</td>
  </tr>
<?
foreach($age as $value => $data) {
?>
  <tr>
    <td><? echo $value;?></td>
    <td><? echo $data["count"];?></td>
    <td><? echo $data["policies"];?></td>
    <td><? echo $data["payments"];?></td>
    <td><? echo $data["reserves"];?></td>
  </tr>
<? } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br /><br />
<table width="664" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="5" align="center">Experince</td>
  </tr>
  <tr>
    <td width="119">Experience</td>
    <td width="104">Claims Count</td>
    <td width="185">Policies Count</td>
    <td width="124">Payments</td>
    <td width="120">Reserves</td>
  </tr>
<?
foreach($experience as $value => $data) {
?>
  <tr>
    <td><? echo $value;?></td>
    <td><? echo $data["count"];?></td>
    <td><? echo $data["policies"];?></td>
    <td><? echo $data["payments"];?></td>
    <td><? echo $data["reserves"];?></td>
  </tr>
<? } ?>
</table>

</div>
<?
}//if action show and show only totals
$db->show_footer();
?>