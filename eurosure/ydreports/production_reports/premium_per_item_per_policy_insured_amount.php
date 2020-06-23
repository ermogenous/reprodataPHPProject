<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 800);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
$sybase = new Sybase();

//=============================================================================================================

if ($_POST["action"] == "submit") {
$queries = new insurance_queries();

//agent group and where
if ($_POST["agent_from"] == "") {
	$where_agent = '';
}
else {
	$where_agent = "AND inag_agent_code BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."'";
}

//klados where 
if ($_POST["klado_from"] != "" && $_POST["klado_to"] != "") {
	$where_klado = "AND inity_major_category BETWEEN '".$_POST["klado_from"]."' AND '".$_POST["klado_to"]."'";
}
else {
	$where_klado = "";
}

//klados where exclude
if ($_POST["klado_exclude"] != "") {
	$where_klado_exclude = "AND inity_major_category NOT LIKE '".$_POST["klado_exclude"]."'";
}
else {
	$where_klado_exclude = "";
}

//insurance type where
if ($_POST["insurance_type"] != "") {
	$where_insurance_type = "AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'";
}
else {
	$where_insurance_type = "";
}

//insurance type exclude where
if ($_POST["insurance_type_exclude"] != "") {
	$where_insurance_type_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'";
}
else {
	$where_insurance_type_exclude = "";
}

//group by policy insured amount
if ($_POST["group_policy_ia"] == 1) {
	$group_policy_ia = ',inpol_insured_amount';
	$select_policy_ia = ',inpol_insured_amount as clo_policy_insured_amount';
	$order_policy_ia = ',clo_policy_insured_amount ASC';
}
else {
	$group_policy_ia = '';
	$select_policy_ia = '';
	$order_policy_ia = '';
}

$sql ="
SELECT 
(".$_POST["year"].") as clo_year
,(".$_POST["month_from"].") as clo_period_from
,(".$_POST["month_to"].") as clo_period_to
,initm_item_code
,initm_long_description
".$select_policy_ia."
,-1 * SUM(inped_premium_debit_credit * (IF inldg_loading_type <> 'X' THEN IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF ELSE 0.0 ENDIF)) as clo_premium
,COUNT(DISTINCT(inpol_policy_number)) as clo_items_count
,LIST(DISTINCT(inpol_policy_number))as clo_policy_numbers
,LIST(DISTINCT(inpol_policy_serial))as clo_policy_serials
FROM inpolicyendorsement
JOIN inpolicies ON inpol_policy_serial = inped_financial_policy_abs
JOIN inagents ON inpol_agent_serial = inag_agent_serial
JOIN inpolicyitems ON inped_policy_serial = inpit_policy_serial
JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial
JOIN initems ON initm_item_serial = inpit_item_serial
LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial /* COALESCE used for completeness */
JOIN inpolicyloadings ON inpit_pit_auto_serial = inplg_pit_auto_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial

WHERE 
inped_status = '1' /* Posted */
AND inped_premium_debit_credit <> 0 
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 

".$where_agent."
".$where_klado."
".$where_klado_exclude."
".$where_insurance_type."
".$where_insurance_type_exclude."

GROUP BY
initm_item_code
,initm_long_description
".$group_policy_ia."

ORDER BY 
initm_item_code ASC
".$order_policy_ia."
";
echo $sql;exit();
$result = $sybase->query($sql);
$i=0;
while ($row = $sybase->fetch_assoc($result)) {

	$data[$i] = $row;
	//get the number of employees of each item. Only from the item of the last policy phase found in the period range.
	
	//fix the policy numbers
	$pol_numbers = explode(",",$row["clo_policy_numbers"]);
	$pol_nums_fixed = "";
	$p = 0;
	foreach($pol_numbers as $pol_num) {
		if ($p != 0)
			$pol_nums_fixed .= ",";
		$pol_nums_fixed .= "'".$pol_num."'";
		$p++;
	}
	
	$sql ="
SELECT
SUM(clo_total_emp)as clo_total_employees
FROM
(
SELECT
(SELECT inpia_no_of_employees 
FROM inpolicyitems 
JOIN inpolicyitemaux ON inpit_pit_auto_serial = inpia_pit_auto_serial
JOIN initems ON initm_item_serial = inpit_item_serial
WHERE
initm_item_code = '".$row["initm_item_code"]."'
AND inpit_policy_serial = MAX(inpol_policy_serial)
)as clo_total_emp
,(".$_POST["year"].") as clo_year
,(".$_POST["month_from"].") as clo_period_from
,(".$_POST["month_to"].") as clo_period_to
FROM inpolicies 
JOIN inpolicyendorsement ON inpol_policy_serial = inped_financial_policy_abs
WHERE 
inped_status = '1'
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND inpol_policy_serial IN (".$row["clo_policy_serials"].")
AND inpol_policy_number IN (".$pol_nums_fixed.")
GROUP BY inpol_policy_number
)as temp_table	
";
$total_employees = $sybase->query_fetch($sql);
$data[$i]["clo_total_employees"] = $total_employees["clo_total_employees"];

$i++;
}

foreach($data[0] as $field => $value){

	$fields[] = $field;


}

export_data_delimited($data,$fields,'#','none','download','
','data');
//$output_table = export_data_html_table($sql,'sybase');


}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="649" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Premium Per Item Report </td>
    </tr>
    <tr>
      <td width="226" height="28">Year</td>
      <td width="423"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>" size="6"></td>
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
        <input name="klado_from" type="text" id="klado_from" value="<? echo $_POST["klado_from"];?>" size="8" />
To
<input name="klado_to" type="text" id="klado_to" value="<? echo $_POST["klado_to"];?>" size="8" /></td>
    </tr>
    <tr>
      <td height="28">Major Category Exclude </td>
      <td><input name="klado_exclude" type="text" id="klado_exclude" value="<? echo $_POST["klado_exclude"];?>"/>
      (exclude) ex 17% </td>
    </tr>
    <tr>
      <td height="28">Insurance Type </td>
      <td><input name="insurance_type" type="text" id="insurance_type" value="<? echo $_POST["insurance_type"];?>" /> 
      ex 222% Insert % to group by </td>
    </tr>
    <tr>
      <td height="28">Insurance Type Exclude </td>
      <td><input name="insurance_type_exclude" type="text" id="insurance_type_exclude" value="<? echo $_POST["insurance_type_exclude"];?>" /> 
      ex 190% or 19% </td>
    </tr>
    <tr>
      <td height="28">Occupation Codes </td>
      <td><input name="policy_occupation_code" type="text" id="policy_occupation_code" size="20" value="<? echo $_POST["policy_occupation_code"];?>" />
      Separate By , NOT WORKING YET </td>
    </tr>
    
    <tr>
      <td height="28">Group By Policy Insured Amount? </td>
      <td><input name="group_policy_ia" type="checkbox" id="group_policy_ia" value="1" <? if ($_POST["group_policy_ia"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br />
<br />
<?
echo $output_table;

$db->show_footer();
?>