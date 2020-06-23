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
		//$loadings_filter = "AND inloadings.inldg_loading_serial IN (".$_POST["loadings"].")";
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

COALESCE(inlsc_record_code, 'UNKNOWN PERIL') as clo_peril_code, 
COALESCE(inlsc_long_description, '') as clo_peril_description,
COALESCE(inlsc_ldg_rsrv_under_reinsurance, 'Y') as clo_peril_under_treaty_reinsurance,
COALESCE(inlsc_ldg_rsrv_under_fac_foreign, 'Y') as clo_peril_under_FAC_reinsurance,
-1 * (inped_premium_debit_credit * (IF inldg_loading_type <> 'X' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as clo_written_premium,
//COUNT() as clo_count,
loadingperil.incd_ldg_rsrv_under_reinsurance
,inity_insurance_type

into #temp

FROM inpolicyendorsement
JOIN inpolicies ON inpol_policy_serial = inped_financial_policy_abs
JOIN inpolicyitems ON inped_policy_serial = inpit_policy_serial
LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial /* COALESCE used for completeness */
JOIN inpolicyloadings ON inpit_pit_auto_serial = inplg_pit_auto_serial
JOIN inloadings ON inplg_loading_serial = inldg_loading_serial 
LEFT OUTER JOIN inloadingstatcodes ON inldg_claim_reserve_group = inlsc_pcode_serial
JOIN inpcodes AS loadingperil ON incd_pcode_serial = inldg_claim_reserve_group

WHERE inped_year = ".$_POST["year"]." 
AND inped_period BETWEEN ".$_POST["from_month"]." and ".$_POST["to_month"]."
AND inped_status = '1' /* Posted */
AND inity_insurance_type = '2101'

ORDER BY 
inity_insurance_type

SELECT
SUM(clo_written_premium)as total_premium
,inity_insurance_type
FROM 
#temp
GROUP BY inity_insurance_type
ORDER BY inity_insurance_type

";
echo $sql."<hr>";
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
    <td colspan="2" align="center"><strong>Report By Liabilit/Thirt Party For Marine Hull 2101 </strong></td>
    </tr>
  
  <tr>
    <td width="122">Year</td>
    <td width="413"><input name="year" type="text" id="year" size="6" value="<? echo $_POST["year"];?>" /></td>
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
    <td colspan="2" align="center"><input name="action" type="hidden" id="action" value="show" />
      <input type="submit" name="Submit" value="Submit" /></td>
    </tr>
</table>
</form>
<?
echo $table_data;
$db->show_footer();
?>