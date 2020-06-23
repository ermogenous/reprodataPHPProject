<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../functions/production.php");

include("../functions/production_class.php");
include("../../tools/export_data.php");
$sybase = new Sybase();

if ($_POST["action"] == "submit") {
	
	//STEP 1 get all the premium grouped by policy serial, number
	$prod = new synthesis_production();
	//insert the years/periods
	$prod->from_year = $_POST["year_from"];
	$prod->to_year = $_POST["year_to"];
	$prod->from_period = $_POST["period_from"];
	$prod->to_period = $_POST["period_to"];
	
	//get the production sql (not as at)
	$prod->policy_sql();
	
	$prod->add_insurance_types();
	
	$prod->insert_where("AND inity_insurance_type BETWEEN '".$_POST["insurance_type_from"]."' AND '".$_POST["insurance_type_to"]."'");
	$prod->insert_select_group("inpol_policy_number");
	$prod->insert_select_group("inpol_policy_serial");
	
	//outer sql
	//$prod->enable_outer_select();
	
	//$show_premiums = 1;
	

	$prod->generate_sql();
	$sql = $prod->return_sql();
	
	$result = $sybase->query($sql);
	while ($row = $sybase->fetch_assoc($result)){
		$premium[$row["inpol_policy_serial"]] += $row["clo_premium"];
	}
	
	//STEP 2 get all the drivers and order them by policy number
	$prod = new synthesis_production();
	//insert the years/periods
	$prod->from_year = $_POST["year_from"];
	$prod->to_year = $_POST["year_to"];
	$prod->from_period = $_POST["period_from"];
	$prod->to_period = $_POST["period_to"];
	
	//get the production sql (not as at)
	$prod->policy_sql(0);
	$prod->add_drivers();
	$prod->add_insurance_types();
	$prod->add_templates();
	$prod->add_clients();
	$prod->add_agents();
	
	$prod->insert_from("LEFT OUTER JOIN indrivers as clientDriver ON clientDriver.indr_driver_serial = incl_driver_serial",1);
	
	$prod->insert_select_group("inpol_policy_number","clo_policy_number");
	$prod->insert_select_group("inpol_policy_serial","clo_policy_serial");
	$prod->insert_select_group("intmpl_for_account_type","clo_is_client_driver");
	$prod->insert_select_group("incl_birth_date");
	$prod->insert_select_group("indrivers.indr_birth_date");
	$prod->insert_select_group("indrivers.indr_permit_date");
	$prod->insert_select_group("inag_group_code");
	$prod->insert_select_group("inag_long_description");

	$prod->insert_group("inpolicydrivers.inpdr_starting_date");
	$prod->insert_group("inpol_period_starting_date");
	$prod->insert_group("clientDriver.indr_birth_date");
	$prod->insert_group("clientDriver.indr_permit_date");

	$prod->insert_select("floor(fn_datediff('year',indrivers.indr_birth_date,inpolicydrivers.inpdr_starting_date))","clo_driver_age");
	$prod->insert_select("floor(fn_datediff('year',indrivers.indr_permit_date,inpolicydrivers.inpdr_starting_date))","clo_driver_experience");
	$prod->insert_select("floor(fn_datediff('year',clientDriver.indr_birth_date,inpol_period_starting_date))","clo_client_driver_age");
	$prod->insert_select("floor(fn_datediff('year',clientDriver.indr_permit_date,inpol_period_starting_date))","client_driver_experience");
	
	$prod->insert_where("AND inity_insurance_type BETWEEN '".$_POST["insurance_type_from"]."' AND '".$_POST["insurance_type_to"]."'");
	$prod->insert_where("AND intmpl_for_account_type = 'P'");
	$prod->insert_sort("inpol_policy_number","ASC");
	$prod->insert_sort("inpol_policy_serial","ASC");
	$prod->insert_sort("clo_driver_age","DESC");
	
	//$prod->insert_where("AND inpol_policy_serial = 184268");

	$prod->generate_sql();
	$sql = $prod->return_sql();
	$result = $sybase->query($sql);
	
	//echo $db->prepare_text_as_html($sql);
	//exit();
	
	while ($row = $sybase->fetch_assoc($result)){
		
		//check if this policy serial is the first time it appears
		if ($previous_policy_serial != $row["clo_policy_serial"]) {
			//first add the client data
			$data[$row["clo_client_driver_age"]]["premium"] += $premium[$row["clo_policy_serial"]];
			$data[$row["clo_client_driver_age"]]["people"] += 1;
			
			//now add the driver data
			//$data[$row["clo_driver_age"]]["premium"] += $premium[$row["inpol_policy_serial"]];
			$data[$row["clo_driver_age"]]["people"] += 1;
			
			//echo $row["inpol_policy_number"]."(".$row["inpol_policy_serial"].") - NEW<br>";
			//echo $premium[$row["inpol_policy_serial"]]."!<br>";
			
		}
		else {
			//now add the driver data
			$data[$row["clo_driver_age"]]["people"] += 1;
			//echo $row["inpol_policy_number"]."(".$row["inpol_policy_serial"].") - SAME<br>";
		}
		$previous_policy_serial = $row["clo_policy_serial"];
	}
	
	
#	//get the premium from policies that have at least one driver over >= 70
	$prod->enable_outer_select();
	
	$prod->insert_outer_select("DISTINCT(clo_policy_serial)","clo_policy_serial");
	$prod->insert_outer_select("(SELECT COUNT(DISTINCT(clo_policy_number)) FROM #temp WHERE clo_driver_age >= 70 OR clo_client_driver_age >= 70)","clo_total_over_70");
	$prod->insert_outer_where("AND (clo_driver_age >= 70");
	$prod->insert_outer_where("OR clo_client_driver_age >= 70)");
	
	$prod->generate_sql();
	$sql = $prod->return_sql();
	$result = $sybase->query($sql);
	while ($row = $sybase->fetch_assoc($result)) {
		$over_70_premium += $premium[$row["clo_policy_serial"]];
		$clo_total_over_70 = $row["clo_total_over_70"];
		//echo $premium[$row["clo_policy_serial"]]."<br>";
	}
	
	//find data per agent
	$agent_sql = "SELECT
				(SELECT MIN(inpol_period_starting_date) FROM inpolicies WHERE inpol_policy_number = clo_policy_number)as clo_first_starting_date,
				(SELECT YEAR(MIN(inpol_period_starting_date)) FROM inpolicies WHERE inpol_policy_number = clo_policy_number)as clo_first_starting_year,
				clo_policy_number,
				inag_group_code,
				inag_long_description
				into #temp2
				FROM
				#temp
				WHERE
				clo_driver_age >= 70 
				OR
				clo_client_driver_age >= 70 
				GROUP BY 
				clo_policy_number,
				inag_group_code,
				inag_long_description
				
				ORDER BY
				inag_group_code
				
				
				SELECT
				inag_group_code,
				inag_long_description,
				clo_first_starting_year,
				COUNT() as clo_total_policies
				FROM
				#temp2
				GROUP BY 
				inag_group_code,
				inag_long_description,
				clo_first_starting_year
				ORDER BY clo_first_starting_year ASC,clo_total_policies DESC";
	//echo $db->prepare_text_as_html($sql);
	//exit();
	
}

$db->show_header();
?>
<div id="print_view_section_html">
<form action="" method="post">
<table width="600" border="0" cellspacing="0" cellpadding="0" class="row_table_border" align="center">
  <tr>
    <td colspan="2" align="center"><strong>Production/Policies Per Driver (or client driver)</strong></td>
    </tr>
  <tr class="row_table_border">
    <td width="158">Production From</td>
    <td width="442">Year
      <input name="year_from" type="text" id="year_from" value="<? echo $_POST["year_from"];?>" size="6"  />
      Period
      <input name="period_from" type="text" id="period_from" size="6" maxlength="2" value="<? echo $_POST["period_from"];?>" ></td>
  </tr>
  <tr class="row_table_border">
    <td>Production To</td>
    <td>Year
      <input name="year_to" type="text" id="year_to" value="<? echo $_POST["year_to"];?>" size="6" />
      Period      
      <input name="period_to" type="text" id="period_to" size="6" maxlength="2" value="<? echo $_POST["period_to"];?>" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Insurance Types</td>
    <td>From
      <input name="insurance_type_from" type="text" id="insurance_type_from" value="<? echo $_POST["insurance_type_from"];?>" size="6" />
To
<input name="insurance_type_to" type="text" id="insurance_type_to" value="<? echo $_POST["insurance_type_to"];?>" size="6" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td> The premium is added the age of the client age.</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="submit"></td>
    <td><input type="submit" name="button" id="button" value="Submit"></td>
  </tr>
</table>

</form>
<?
if ($_POST["action"] == "submit") {

	//echo export_data_html_table($sql,'sybase',"align=\"center\" border=\"1\"");
?>
<table width="400" border="0" cellspacing="0" cellpadding="0" class="row_table_border" align="center">
	<tr>
    	<td>Age</td>
        <td>People</td>
        <td>Premium</td>
    </tr>
<?	
	foreach($data as $age_name => $age) {
?>
	<tr>
    	<td><? echo $age_name;?></td>
        <td><? echo $age["people"];?></td>
        <td><? echo $age["premium"];?></td>
	</tr>
<?
	}
?>
</table>
<br />
<div align="center">

Total Premium from policies that have >= 70 age as a driver or client driver: &#8364;<? echo $over_70_premium;?> in total <? echo $clo_total_over_70;?> policies with an average of &#8364;<? echo $db->fix_int_to_double(($over_70_premium/$clo_total_over_70),2); ?> per policy

</div>
<br />
<table width="600" cellspacing="0" cellpadding="0" border="1" align="center">
  <tr>
    <td>Agent Code</td>
    <td>Agent Name</td>
    <td>First Policy Year</td>
    <td>Total Policies</td>
  </tr>
<?
	$result = $sybase->query($agent_sql);
	while ($row = $sybase->fetch_assoc($result)) {
?>
  <tr>
    <td><? echo $row["inag_group_code"];?></td>
    <td><? echo $row["inag_long_description"];?></td>
    <td><? echo $row["clo_first_starting_year"];?></td>
    <td><? echo $row["clo_total_policies"];?></td>
  </tr>
<? } ?>
</table>


<?
	
}
?>
</div>
<?
$db->show_footer();
?>