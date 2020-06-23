<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../functions/production.php");
$sybase = new Sybase();


if ($_POST["action"] == 'submit') {
	
include("../functions/production_class.php");
$prod = new synthesis_production();
$prod->from_period = $_POST["period_from"];
$prod->to_period = $_POST["period_to"];
$prod->from_year = $_POST["year_from"];
$prod->to_year = $_POST["year_to"];

$prod->policy_sql();
$prod->add_insurance_types();
$prod->add_policies_counts();
//majors
if ($_POST["major_from"] != "" && $_POST["major_to"] != "") {

	$prod->insert_where("AND inity_major_category BETWEEN ".$_POST["major_from"]." AND ".$_POST["major_to"]);
	$prod->insert_select_group("inity_major_category");
	
}

//insurance types
if ($_POST["insurance_type_from"] != "" && $_POST["insurance_type_to"] != "") {

	$prod->insert_where("AND inity_insurance_type BETWEEN '".$_POST["insurance_type_from"]."' AND '".$_POST["insurance_type_to"]."'");
	$prod->insert_select_group("inity_insurance_type");
	
}

//exclude insurance types
if ($_POST["exclude_insurance_type"] != "") {

	$prod->insert_where("AND inity_insurance_type <> '".$_POST["exclude_insurance_type"]."'");
	
}

//policy cover
if ($_POST["policy_cover"] != "ALL") {

	if ($_POST["policy_cover"] == 'BC') {
		$prod->insert_where("AND inpol_cover IN ('B','C')");
		$prod->insert_select_group("inpol_cover");	
	}
	else if ($_POST["policy_cover"] == 'GROUP') {
		$prod->insert_select_group("inpol_cover");	
	}
	else {
		$prod->insert_where("AND inpol_cover = '".$_POST["policy_cover"]."'");
		$prod->insert_select_group("inpol_cover");	
	}
	
	$prod->insert_sort('inpol_cover','ASC');
}

if ($_POST["group_1"] == "client_nationality" || $_POST["group_2"] == "client_nationality") {
	
		$prod->add_clients();
		$prod->insert_from("JOIN inpcodes as clientnationality ON incd_pcode_serial = incl_nationality",1);
		
		$prod->insert_select_group("incd_long_description","clo_client_nationality");
		
		$prod->insert_sort("clo_client_nationality","ASC");
	
}//client nationality

$prod->generate_sql();

$sql = $prod->return_sql();

include("../../tools/export_data.php");
$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");

}

$db->show_header();
?>
<form name="form1" method="post" action="">
  <table width="540" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" colspan="2" align="center">Period Production Report</td>
    </tr>
    <tr>
      <td width="173" height="25">Year</td>
      <td width="361" height="25"><input name="year_from" type="text" id="year_from" value="<? echo $_POST["year_from"];?>" size="8">
      UpTo 
      <input name="year_to" type="text" id="year_to" value="<? echo $_POST["year_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="25">Period</td>
      <td height="25"><input name="period_from" type="text" id="period_from" size="5" maxlength="2" value="<? echo $_POST["period_from"];?>">
        UpTo
        <input name="period_to" type="text" id="period_to" size="5" maxlength="2" value="<? echo $_POST["period_to"];?>"></td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center"><strong>Extra</strong></td>
    </tr>
    <tr>
      <td height="25">Major</td>
      <td height="25"><input name="major_from" type="text" id="major_from" value="<? echo $_POST["major_from"];?>" size="8" />
        To
      <input name="major_to" type="text" id="major_to" value="<? echo $_POST["major_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="25">Insurance Types</td>
      <td height="25"><input name="insurance_type_from" type="text" id="insurance_type_from" value="<? echo $_POST["insurance_type_from"];?>" size="8" />
      To
      <input name="insurance_type_to" type="text" id="insurance_type_to" value="<? echo $_POST["insurance_type_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="25">Exlude Insurance Type</td>
      <td height="25"><input name="exclude_insurance_type" type="text" id="exclude_insurance_type" value="<? echo $_POST["exclude_insurance_type"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="25">Policy Cover (Motor Only)</td>
      <td height="25"><select name="policy_cover" id="policy_cover">
        <option value="ALL" <? if ($_POST["policy_cover"] == 'ALL') echo "selected=\"selected\"";?>>ALL - NON MOTOR</option>
        <option value="A" <? if ($_POST["policy_cover"] == 'A') echo "selected=\"selected\"";?>>Third Party</option>
        <option value="B" <? if ($_POST["policy_cover"] == 'B') echo "selected=\"selected\"";?>>Fire&amp;Theft</option>
        <option value="C" <? if ($_POST["policy_cover"] == 'C') echo "selected=\"selected\"";?>>Comprehensive</option>
        <option value="BC" <? if ($_POST["policy_cover"] == 'BC') echo "selected=\"selected\"";?>>F&amp;T + Comprehensive</option>
        <option value="GROUP" <? if ($_POST["policy_cover"] == 'GROUP') echo "selected=\"selected\"";?>>Show Grouped</option>
      </select></td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center"><strong>GROUPING</strong></td>
    </tr>
    <tr>
      <td height="25">GROUP 1</td>
      <td height="25"><select name="group_1" id="group_1">
        <option value="">NONE</option>
        <option value="client_nationality" <? if ($_POST["group_1"] == 'client_nationality') echo "selected=\"selected\"";?>>Client Nationality</option>
      </select></td>
    </tr>
    <tr>
      <td height="25">GROUP 2</td>
      <td height="25"><select name="group_2" id="group_2">
        <option value="">NONE</option>
        <option value="client_nationality" <? if ($_POST["group_2"] == 'client_nationality') echo "selected=\"selected\"";?>>Client Nationality</option>
      </select></td>
    </tr>
    <tr>
      <td height="25"><input name="action" type="hidden" id="action" value="submit">
      &nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="Submit"></td>
    </tr>
    <tr>
      <td height="25" colspan="2">Using production class.</td>
    </tr>
  </table>
</form>
<?
//=============================================================================================================

if ($_POST["action"] == "submit") {
?>
<div id="print_view_section_html">
<? echo $table_data;?>
</div>
<?
}//if action= submit
$db->show_footer();
?>
