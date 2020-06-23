<?
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../functions/production_class.php");
$sybase = new Sybase();

$db->show_header();

if ($_POST["action"] == "show") {

$prod = new synthesis_production();
$prod->from_year = $_POST["from_year"];
$prod->to_year = $_POST["to_year"];
$prod->from_period = $_POST["from_period"];
$prod->to_period = $_POST["to_period"];


$prod->policy_sql();

$prod->add_insurance_types();
$prod->add_items();
$prod->add_archive_clients();

//$prod->insert_from("JOIN inpolicyloadings ON inplg_policy_serial = DBA.inpolicies.inpol_policy_serial",1);

$prod->insert_where("AND inity_insurance_type = '2101'");

$prod->clo_process_status = "'N','R','E','C'";

//break it down per policy
$prod->insert_select_group("inpol_policy_number");
$prod->insert_select_group("inpol_policy_serial");

$prod->insert_select("(SELECT SUM(inpit_insured_amount) FROM inpolicyitems LEFT OUTER JOIN inpolicyitemaux ON inpit_pit_auto_serial = inpia_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)","clo_insured_amount_hull");
$prod->insert_select("(SELECT SUM(COALESCE(inpia_insured_amount_alt1, 0)) FROM inpolicyitems LEFT OUTER JOIN inpolicyitemaux ON inpit_pit_auto_serial = inpia_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)","clo_insured_amount_tpl");
$prod->insert_select("(SELECT MAX(inpst_city) FROM inpolicysituations WHERE inpst_policy_serial = inpolicies.inpol_policy_serial)","clo_marina");

$prod->insert_select_group("inpol_starting_date");
$prod->insert_select_group("inpol_expiry_date");

$prod->insert_select_group("inpdcl_first_name + ' ' + inpdcl_long_description","clo_client_name");


//only one situation must exists on each policy
$prod->insert_select("(SELECT inpst_name FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)","clo_vessel_name");
$prod->insert_select("(SELECT inpst_creditor FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)","clo_kind_of_vessel");
$prod->insert_select("(SELECT IF inpst_destination = 'P' THEN 'PLEASURE' ELSE IF inpst_destination = 'C' THEN 'Commercial' ENDIF ENDIF FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)","clo_use_of_vessel");
$prod->insert_select("(SELECT inpst_postal_code FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)","clo_construction");
$prod->insert_select("(SELECT YEAR(inpst_birthdate) FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial)","clo_construction_year");

//excesses
$prod->insert_select("(SELECT inpia_excess FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial)","clo_hull_excess");
$prod->insert_select("(SELECT inpia_width FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial)","clo_tpl_excess");
$prod->insert_select("(SELECT inpia_max_item_value_covered FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial)","clo_machinery_excess");


//premium
$prod->insert_select("(SELECT fn_return_period_loadings_premium(inpol_policy_serial,'ONLYCURRENT',' AND inplg_loading_serial IN (1353,1431) ','premium') FROM dummy)","clo_premium_hull_machinery");
//$prod->insert_select("SUM(IF inplg_loading_serial IN (1353,1431) THEN (-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit)) ELSE 0 ENDIF)","clo_premium_hull_machinery");
//$prod->insert_select("SUM(IF inplg_loading_serial IN (1354) THEN (-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit)) ELSE 0 ENDIF)","clo_premium_tpl");
$prod->insert_select("(SELECT fn_return_period_loadings_premium(inpol_policy_serial,'ONLYCURRENT',' AND inplg_loading_serial = 1354 ','premium') FROM dummy)","clo_premium_tpl");



//create second sql to fix columns
$prod->enable_outer_select();
$prod->insert_outer_select("inpol_policy_number","Policy Number");
$prod->insert_outer_select("DATEFORMAT(inpol_starting_date,'dd/mm/yyyy')","Inception Date");
$prod->insert_outer_select("DATEFORMAT(inpol_expiry_date,'dd/mm/yyyy')","Expiry Date");
$prod->insert_outer_select("clo_client_name","Insured");
$prod->insert_outer_select("clo_vessel_name","Name Of Vessel/Craft");
$prod->insert_outer_select("clo_kind_of_vessel","Kind of Vessel/Craft");
$prod->insert_outer_select("clo_use_of_vessel","Use of Vessel/Craft");
$prod->insert_outer_select("clo_marina","Name of Marina");
$prod->insert_outer_select("clo_construction","Construction");
$prod->insert_outer_select("clo_construction_year","Year of Construction");
$prod->insert_outer_select("clo_insured_amount_hull","Insured Amm.Hull/Machinery");
$prod->insert_outer_select("clo_insured_amount_tpl","Insured Amm.TPL");
$prod->insert_outer_select("clo_premium_hull_machinery","Premium Hull/Machinery");
$prod->insert_outer_select("clo_premium_tpl","Premium TPL");
$prod->insert_outer_select("clo_hull_excess","Hull Excess");
$prod->insert_outer_select("clo_tpl_excess","TPL Excess");
$prod->insert_outer_select("clo_machinery_excess","Machinery Excess");

$prod->generate_sql();
//$db->admin_echo($db->prepare_text_as_html($prod->sql));
$sql = $prod->sql;
//echo $sql;
$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");


}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong> Marine Per Marina for Hull 2101 </strong></td>
    </tr>
    <tr>
      <td>Year</td>
      <td>From
        <input name="from_year" type="text" id="from_year" value="<? echo $_POST["from_year"];?>" size="6">
        To
        <input name="to_year" type="text" id="to_year" value="<? echo $_POST["to_year"];?>" size="6" /></td>
    </tr>
    <tr>
      <td width="122">Financial Period</td>
      <td width="527"><select name="from_period" id="from_period">
        <option value="1" <? if ($_POST["from_period"] == "1") echo "selected=\"selected\"";?>>January</option>
        <option value="2" <? if ($_POST["from_period"] == "2") echo "selected=\"selected\"";?>>February</option>
        <option value="3" <? if ($_POST["from_period"] == "3") echo "selected=\"selected\"";?>>March</option>
        <option value="4" <? if ($_POST["from_period"] == "4") echo "selected=\"selected\"";?>>April</option>
        <option value="5" <? if ($_POST["from_period"] == "5") echo "selected=\"selected\"";?>>May</option>
        <option value="6" <? if ($_POST["from_period"] == "6") echo "selected=\"selected\"";?>>June</option>
        <option value="7" <? if ($_POST["from_period"] == "7") echo "selected=\"selected\"";?>>July</option>
        <option value="8" <? if ($_POST["from_period"] == "8") echo "selected=\"selected\"";?>>August</option>
        <option value="8" <? if ($_POST["from_period"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["from_period"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["from_period"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["from_period"] == "12") echo "selected=\"selected\"";?>>December</option>
      </select>
      /  
      <select name="to_period" id="to_period">
        <option value="1" <? if ($_POST["to_period"] == "1") echo "selected=\"selected\"";?>>January</option>
        <option value="2" <? if ($_POST["to_period"] == "2") echo "selected=\"selected\"";?>>February</option>
        <option value="3" <? if ($_POST["to_period"] == "3") echo "selected=\"selected\"";?>>March</option>
to_period        <option value="5" <? if ($_POST["to"] == "5") echo "selected=\"selected\"";?>>May</option>
        <option value="6" <? if ($_POST["to_period"] == "6") echo "selected=\"selected\"";?>>June</option>
        <option value="7" <? if ($_POST["to_period"] == "7") echo "selected=\"selected\"";?>>July</option>
        <option value="8" <? if ($_POST["to_period"] == "8") echo "selected=\"selected\"";?>>August</option>
        <option value="9" <? if ($_POST["to_period"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["to_period"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["to_period"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["to_period"] == "12") echo "selected=\"selected\"";?>>December</option>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><select name="show_type" id="show_type">
        <option value="policies" <? if ($_POST["show_type"] == "policies") echo "selected=\"selected\"";?>>Show Policies</option>
        <option value="table" <? if ($_POST["show_type"] == "table") echo "selected=\"selected\"";?>>Show Table</option>
      </select>
      </td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {
?>
<br><br>
<div id="print_view_section_html">
<?
echo $table_data;
?>
</div>
<? 
} 

$db->show_footer();
?>