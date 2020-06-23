<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 300);
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
$sybase = new Sybase();
include("../../tools/export_data.php");


if ($_GET["action"] == "show") {

	if ($_GET["insurance_type"] != "") {
		$insurance_type_filter = " AND InsType LIKE '".$_GET["insurance_type"]."'";
	}
	if ($_GET["not_insurance_type"] != "") {
		$insurance_type_not_filter = " AND InsType NOT LIKE '".$_GET["not_insurance_type"]."'";
	}
	if ($_GET["reinsurance"] == 1) {
		$reinsurance_filter = " AND Under_Reinsurance = 'Y'";
	}
	if ($_GET["fac"] == 1) {
		$reinsurance_filter = " AND Fac_Foreign = 'Y'";
	}
	if ($_GET["codes_from"] != "" && $_GET["codes_to"] != "") {
		$codes_filter = " AND inldg_loading_code BETWEEN '".$_GET["codes_from"]."' AND '".$_GET["codes_to"]."'";
	}

$sql = "
SELECT 
inldg_loading_code as Code
,inldg_long_description as Description
,inldg_loading_value as Value
,inldg_amount_percentage as AmPerc
,inity_insurance_type as InsType
,rsv.incd_ldg_rsrv_under_reinsurance as UnderRen
,rsv.incd_car_model_sport as FacForeign
,inldg_acceptance_level as AccLevel
,inldg_alter_value_level as AltLevel

FROM inloadings
JOIN ininsurancetypes ON inldg_insurance_sub_form = inity_insurance_sub_form
JOIN inpcodes as rsv ON rsv.incd_pcode_serial = inldg_claim_reserve_group
WHERE 
1=1
AND inldg_status_flag <> 'I'
".$insurance_type_filter."
".$insurance_type_not_filter."
".$reinsurance_filter."
".$reinsurance_filter."
".$codes_filter."

ORDER BY ".$_GET["order_by"]." ".$_GET["order_by_type"];

if ($_GET["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"'",'download');
}
else if ($_GET["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
}


}//if show


$db->show_header();

if ($_GET["layout_action"] != "printer") {
?>
<form name="form1" method="GET" action="">
  <table width="554" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">Loadings List </td>
    </tr>
    <tr>
      <td width="167">Insurance Type </td>
      <td width="381"><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_GET["insurance_type"];?>"></td>
    </tr>
    <tr>
      <td>Insurance Type (remove) </td>
      <td><input name="not_insurance_type" type="text" id="not_insurance_type" value="<? echo $_GET["not_insurance_type"];?>"></td>
    </tr>
    
    <tr>
      <td>Loading Codes</td>
      <td>From
        <input type="text" name="codes_from" id="codes_from" value="<? echo $_GET["codes_from"];?>" />
To
<input type="text" name="codes_to" id="codes_to" value="<? echo $_GET["codes_to"];?>" /></td>
    </tr>
    <tr>
      <td>Under Reinsurance </td>
      <td><input name="reinsurance" type="checkbox" id="reinsurance" value="1" <? if ($_GET["reinsurance"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td>Under FAC Foreign </td>
      <td><input name="fac" type="checkbox" id="fac" value="1" <? if ($_GET["fac"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td>Order By </td>
      <td><select name="order_by" id="order_by">
        <option value="Code" <? if ($_GET["order_by"] == "Code") echo "selected=\"selected\"";?>>Loading Code</option>
        <option value="Description" <? if ($_GET["order_by"] == "Description") echo "selected=\"selected\"";?>>Description</option>
        <option value="Value" <? if ($_GET["order_by"] == "Value") echo "selected=\"selected\"";?>>Value</option>
        <option value="AmPerc" <? if ($_GET["order_by"] == "AmPerc") echo "selected=\"selected\"";?>>Amount/Percentage</option>
        <option value="InsType" <? if ($_GET["order_by"] == "InsType") echo "selected=\"selected\"";?>>Insurance Type</option>
        <option value="UnderRen" <? if ($_GET["order_by"] == "UnderRen") echo "selected=\"selected\"";?>>Under Reinsurance</option>
        <option value="FacForeign" <? if ($_GET["order_by"] == "FacForeign") echo "selected=\"selected\"";?>>FAC Foreign</option>
      </select>
        <select name="order_by_type" id="order_by_type">
          <option value="ASC" <? if ($_GET["order_by_type"] == "ASC") echo "selected=\"selected\"";?>>Ascending</option>
          <option value="DESC" <? if ($_GET["order_by_type"] == "DESC") echo "selected=\"selected\"";?>>Descending</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Export File </td>
      <td><input name="export_file" type="radio" value="no" <? if ($_GET["export_file"] == "no") echo "checked=\"checked\"";?> />
No
  <input name="export_file" type="radio" value="delimited" <? if ($_GET["export_file"] == "delimited") echo "checked=\"checked\"";?> />
Delimited (#)
<input name="export_file" type="radio" value="xml" <? if ($_GET["export_file"] == "xml") echo "checked=\"checked\"";?> />
XML (NOT WORKING YET)</td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Show"></td>
    </tr>
  </table>
</form><br />
<br />

<?
}
?>
<div id="print_view_section_html">
<?
echo $table_data;
?>
</div>
<?

$db->show_footer();
?>