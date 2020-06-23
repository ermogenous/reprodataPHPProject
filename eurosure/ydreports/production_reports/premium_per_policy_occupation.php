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
	$agent_group = "''";
	$where_agent = '';
}
else {
	$agent_group = "inag_agent_code";
	$where_agent = "AND clo_sort1 BETWEEN '".$_POST["agent_from"]."' AND '".$_POST["agent_to"]."'";
}

//klados where 
if ($_POST["klado_from"] != "" && $_POST["klado_to"] != "") {
	$where_klado = "AND clo_sort2 BETWEEN '".$_POST["klado_from"]."' AND '".$_POST["klado_to"]."'";
	$group_major = "inity_major_category";
}
else {
	$where_klado = "";
	$group_major = "''";
}

//klados where exclude
if ($_POST["klado_exclude"] != "") {
	$where_klado_exclude = "AND clo_sort2 NOT LIKE '".$_POST["klado_exclude"]."'";
}
else {
	$where_klado_exclude = "";
}

//insurance type where
if ($_POST["insurance_type"] != "") {
	$where_insurance_type = "AND inity_insurance_type LIKE '".$_POST["insurance_type"]."'";
	$group_insurance_type = "inity_insurance_type";
}
else {
	$where_insurance_type = "";
	$group_insurance_type = "''";
}

//insurance type exclude where
if ($_POST["insurance_type_exclude"] != "") {
	$where_insurance_type_exclude = "AND inity_insurance_type NOT LIKE '".$_POST["insurance_type_exclude"]."'";
}
else {
	$where_insurance_type_exclude = "";
}


$sql ="
SELECT 
MAX(clo_year) as Year
,MAX(clo_period_from) as Period_From
,MAX(clo_period_to) as Period_To
,clo_policy_occupation as Occupation
,clo_policy_occupation_code as Occupation_Code
,SUM(clo_ytd_premium) as Premium
,SUM(clo_period_mif) as MIF
,SUM(clo_period_fees) as Fees
,SUM(clo_period_stamps) as Stamps
,SUM(clo_commission) as Commission
,clo_sort1 as Agent
,clo_sort2 as Major
,clo_sort3 as Insurance_Type
,SUM(clo_total_items)as Items_Count
,SUM(clo_total_situations)as Situations_Count
,SUM(clo_total_policy_serials)as Policy_Serials_Count
,COUNT(inpol_policy_number)as Policy_Numbers_Count
FROM 
(


SELECT  
(".$_POST["year"].") as clo_year,           
(".$_POST["month_from"].") as clo_period_from,
(".$_POST["month_to"].") as clo_period_to,
COUNT(DISTINCT(inpol_policy_serial))as clo_total_policy_serials,
LIST(DISTINCT(inpol_policy_serial))as all_serials,
MAX(inpol_policy_serial) as clo_last_serial, /* If Null => No New Or Renewal has been recorded in the specified period */
(SELECT COUNT() FROM inpolicyitems WHERE inpit_policy_serial = clo_last_serial)as clo_total_items,
inpol_policy_number,
(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = clo_last_serial)as clo_total_situations,
LIST(DISTINCT inpol_policy_serial)as clo_policy_serials,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5') AND intrd_owner = 'O'))as clo_commission,
".$agent_group." As clo_sort1,
".$group_major." As clo_sort2,
".$group_insurance_type." AS clo_sort3,


(Select incd_long_description From inpcodes where incd_record_type = '01' And incd_record_code = inity_major_category ) As clo_desc2,
(Select incd_alternative_description From inpolicies as ocpol JOIN inpcodes as ocpc ON ocpc.incd_pcode_serial = ocpol.inpol_policy_occupation AND ocpol.inpol_policy_serial = clo_last_serial) As clo_policy_occupation,
(Select incd_record_code From inpolicies as ocpol JOIN inpcodes as ocpc ON ocpc.incd_pcode_serial = ocpol.inpol_policy_occupation AND ocpol.inpol_policy_serial = clo_last_serial) As clo_policy_occupation_code
FROM ininsurancetypes  
LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code
LEFT OUTER JOIN inminorcodes  ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,           
inpolicyendorsement ,           
inagents ,           
ingeneralagents ,           
inpparam    
WHERE inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs 
and          inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial 
and          ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial 
and          inpolicies.inpol_agent_serial = inagents.inag_agent_serial 
and          inpolicyendorsement.inped_status = '1' 
AND          inped_premium_debit_credit <> 0 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
".$where_agent."
".$where_klado."
".$where_klado_exclude."
".$where_insurance_type."
".$where_insurance_type_exclude."
GROUP BY inpol_policy_number, clo_sort1, clo_sort2 ,clo_sort3, clo_desc2

ORDER BY clo_total_situations DESC,inpol_policy_number,clo_sort1 ASC , clo_sort2 ASC , clo_sort3 ASC



)as temp_table
GROUP BY 
Occupation
,Occupation_Code
,Agent
,Major
,Insurance_Type

ORDER BY 
Occupation
,Occupation_Code
,Agent
,Major
,Insurance_Type
";

$result = $sybase->query($sql);
while ($row = $sybase->fetch_assoc($result)) {

	$data[] = $row;

}

foreach($data[0] as $field => $value){

	$fields[] = $field;


}

if ($_POST["output"] == "text") {
export_data_delimited($data,$fields,'#','none','download','
','data');
}
else if ($_POST["output"] == "table") {
	$output_table = export_data_html_table($sql,'sybase');
}

}//if action= submit
$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="603" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center">Premium Per Policy Occupation Report </td>
    </tr>
    <tr>
      <td width="170" height="28">Year</td>
      <td width="433"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>" size="6"></td>
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
      <td height="28">Output</td>
      <td>Text File
        <input name="output" type="radio" value="text" <? if ($_POST["output"] == "text") echo "checked=\"checked\"";?> /> 
      Show Table 
      <input name="output" type="radio" value="table" <? if ($_POST["output"] == "table") echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<br />
<br />
<div id="print_view_section_html">
<?
echo $output_table;
?>
</div>
<?
$db->show_footer();
?>