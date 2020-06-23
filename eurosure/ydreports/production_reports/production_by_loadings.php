<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 300);
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();
include("../../tools/export_data.php");


if ($_POST["action"] == "show") {

	if ($_POST["loadings"] != "") {
		$loadings_filter = "AND inloadings.inldg_loading_serial IN (".$_POST["loadings"].")";
	}
	
	if ($_POST["perils"] != "") {
		$perils_filter = "AND clo_peril_code IN (".stripslashes($_POST["perils"]).")";
	}
	if ($_POST["insurance_type"] != "") {
		$insurance_type_filter = "AND inity_insurance_type LIKE '".stripslashes($_POST["insurance_type"])."'";
	}

	if ($_POST["group_by"] != 'no'){
		$temp_table = "INTO #temp";
		$new_sql = "";

	}


$sql = "
SELECT 

inity_insurance_type + IF inrit_alternative_insurance_type <> inrit_insurance_type_serial THEN
'('+ (SELECT a.inity_insurance_type FROM ininsurancetypes a WHERE a.inity_insurance_type_serial = inpol_insurance_type_serial)+')'
ELSE '' ENDIF as clo_insurance_type,
inity_long_description || IF inrit_alternative_insurance_type <> inrit_insurance_type_serial THEN
'(On '|| (SELECT a.inity_insurance_type FROM ininsurancetypes a WHERE a.inity_insurance_type_serial = inpol_insurance_type_serial)||')'
ELSE '' ENDIF as clo_insurance_type_description,
inrit_record_type, inrit_reinsurance_treaty, inrit_long_description,
COALESCE(inlsc_record_code, 'UNKNOWN PERIL') as clo_peril_code, COALESCE(inlsc_long_description, '') as clo_peril_description,
COALESCE(inlsc_ldg_rsrv_under_reinsurance, 'Y') as clo_peril_under_treaty_reinsurance,
COALESCE(inlsc_ldg_rsrv_under_fac_foreign, 'Y') as clo_peril_under_FAC_reinsurance,
-1 * SUM(inped_premium_debit_credit * (IF inldg_loading_type <> 'X' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as clo_written_premium,
COUNT() as clo_count,
loadingperil.incd_ldg_rsrv_under_reinsurance

FROM inpolicyendorsement
JOIN inpolicies ON inpol_policy_serial = inped_financial_policy_abs
JOIN inpolicyitems ON inped_policy_serial = inpit_policy_serial
LEFT OUTER JOIN inreinsurancetreaties ON inrit_reinsurance_treaty_serial = inpit_reinsurance_treaty
LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = COALESCE(inrit_alternative_insurance_type, inpol_insurance_type_serial) /* COALESCE used for completeness */
JOIN inpolicyloadings ON inpit_pit_auto_serial = inplg_pit_auto_serial
JOIN inloadings ON inplg_loading_serial = inldg_loading_serial 
LEFT OUTER JOIN inloadingstatcodes ON inldg_claim_reserve_group = inlsc_pcode_serial
JOIN inpcodes AS loadingperil ON incd_pcode_serial = inldg_claim_reserve_group

WHERE inped_year = ".$_POST["year"]." AND inped_period BETWEEN ".$_POST["from_month"]." and ".$_POST["to_month"]."
AND inped_status = '1' /* Posted */
".$loadings_filter."
".$perils_filter."
".$insurance_type_filter."

GROUP BY 

clo_insurance_type, 
clo_insurance_type_description, 
inrit_record_type, 
inrit_reinsurance_treaty, 
inrit_long_description,
inlsc_record_code,


inlsc_long_description, 
inlsc_ldg_rsrv_under_reinsurance, 
inlsc_ldg_rsrv_under_fac_foreign,
loadingperil.incd_ldg_rsrv_under_reinsurance

ORDER BY 


clo_insurance_type, 
inrit_record_type, 
inrit_reinsurance_treaty,
inlsc_record_code

";
//echo $sql."<hr>";
//exit();
//$result = $sybase->query($sql);
if ($_POST["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"'",'download');
}
else if ($_POST["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
}

}//if action show

$db->show_header();
?>

<form action="" method="post"><table width="535" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><strong>Report By Loadings/Perils </strong></td>
    </tr>
  <tr>
    <td>NOTES:</td>
    <td>This report is using the alternative way to join the insurance types.</td>
  </tr>
  <tr>
    <td width="122">Loading(s) Serial </td>
    <td width="413"><input name="loadings" type="text" id="loadings" value="<? echo stripslashes($_POST["loadings"]);?>" />
      Use 10,12,16 etc </td>
  </tr>
  <tr>
    <td>Peril Groups </td>
    <td><input name="perils" type="text" id="perils" value="<? echo stripslashes($_POST["perils"]);?>" /> 
      Use '19-230','19-250' etc </td>
  </tr>
  <tr>
    <td>Year</td>
    <td><input name="year" type="text" id="year" size="6" value="<? echo $_POST["year"];?>" /></td>
  </tr>
  <tr>
    <td>From Period </td>
    <td>Month
      <input name="from_month" type="text" id="from_month" size="6" value="<? echo $_POST["from_month"];?>" />
      Year
       
      Financial Periods </td>
  </tr>
  <tr>
    <td>To Period </td>
    <td>Month
      <input name="to_month" type="text" id="to_month" size="6" value="<? echo $_POST["to_month"];?>" />
Year

Financial Periods </td>
  </tr>
  <tr>
    <td>Insurance Type </td>
    <td><input name="insurance_type" type="text" id="insurance_type" size="30" value="<? echo ($_POST["insurance_type"]);?>" /></td>
  </tr>
  
  <tr>
    <td>Group By </td>
    <td><select name="group_by" id="group_by">
      <option value="no" <? if ($_POST["group_by"] == "no") echo "selected=\"selected\"";?>>No Grouping Show All Records</option>	
      <option value="loading" <? if ($_POST["group_by"] == "loading") echo "selected=\"selected\"";?>>Loading</option>
      <option value="peril" <? if ($_POST["group_by"] == "peril") echo "selected=\"selected\"";?>>Peril</option>
    </select>    </td>
  </tr>
  <tr>
    <td>Export File </td>
    <td><input name="export_file" type="radio" value="no" <? if ($_POST["export_file"] == "no") echo "checked=\"checked\"";?> />
No
  <input name="export_file" type="radio" value="delimited" <? if ($_POST["export_file"] == "delimited") echo "checked=\"checked\"";?> />
Delimited (#)
<input name="export_file" type="radio" value="xml" <? if ($_POST["export_file"] == "xml") echo "checked=\"checked\"";?> />
XML (NOT WORKING YET) </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input name="action" type="hidden" id="action" value="show" />
      <input type="submit" name="Submit" value="Submit" /></td>
    </tr>
</table>
</form>
<div id="print_view_section_html">
<?
echo $table_data;
?>
</div>
<?
$db->show_footer();
?>