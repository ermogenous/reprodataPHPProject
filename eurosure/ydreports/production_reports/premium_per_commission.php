<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();


if ($_POST["action"] == "show") {

$product = "";
if ($_POST["product"] != "") {

	$product = "AND inity_insurance_type LIKE '".$_POST["product"]."'";

}

$remove_product = "";
if ($_POST["remove_product"] != "") {

	$remove_product = "AND inity_insurance_type NOT LIKE '".$_POST["remove_product"]."'";

}

if ($_POST["loading_codes"] != "") {
$_POST["loading_codes"] = stripslashes($_POST["loading_codes"]);
	$loadings = "AND inldg_loading_code IN (".$_POST["loading_codes"].")";
}

$agents = "";
if ($_POST["agents_from"] != "" && $_POST["agents_to"] != "") {

	$agents = "AND inag_agent_code BETWEEN '".$_POST["agents_from"]."' AND '".$_POST["agents_to"]."'";
	
}

$sql = "
SELECT
inldg_loading_serial
,inity_insurance_type
,inldg_loading_code
,inldg_long_description
,incl_alpha_key1
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
,claim_reserve.incd_ldg_rsrv_under_reinsurance
,CASE
WHEN inldg_commission_assigned = '' THEN subform.incd_scale_1_cc
WHEN inldg_commission_assigned = 1 THEN subform.incd_scale_2_cc
WHEN inldg_commission_assigned = 2 THEN subform.incd_scale_3_cc
WHEN inldg_commission_assigned = 3 THEN subform.incd_scale_4_cc
WHEN inldg_commission_assigned = 4 THEN subform.incd_scale_5_cc
WHEN inldg_commission_assigned = 5 THEN subform.incd_scale_6_cc
WHEN inldg_commission_assigned = 6 THEN subform.incd_scale_7_cc
WHEN inldg_commission_assigned = 7 THEN subform.incd_scale_8_cc
WHEN inldg_commission_assigned = 8 THEN subform.incd_last_document_number
WHEN inldg_commission_assigned = 9 THEN subform.incd_layout_name
WHEN inldg_commission_assigned = 10 THEN subform.incd_alternative_description
end
AS clo_commission_assigned

,CASE
WHEN inldg_commission_assigned = '' THEN (inpol_commission_percentage / 100) * clo_total_premium
WHEN inldg_commission_assigned = 1 THEN (inpol_commission_percentage1 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 2 THEN (inpol_commission_percentage2 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 3 THEN (inpol_commission_percentage3 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 4 THEN (inpol_commission_percentage4 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 5 THEN (inpol_commission_percentage5 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 6 THEN (inpol_commission_percentage6 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 7 THEN (inpol_commission_percentage7 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 8 THEN (inpol_commission_percentage8 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 9 THEN (inpol_commission_percentage9 / 100) * clo_total_premium
WHEN inldg_commission_assigned = 10 THEN (inpol_commission_percentage10 / 100) * clo_total_premium
end
AS clo_commission_total

,inag_agent_code
,inag_long_description

into #temp
FROM
inpolicyendorsement 
JOIN inpolicies ON inped_financial_policy_abs = inpol_policy_serial
JOIN inclients ON incl_client_serial = inpol_client_serial
JOIN inagents ON inpol_agent_serial = inag_agent_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpcodes as subform ON inity_insurance_sub_form = subform.incd_record_code AND subform.incd_record_type = 'SF'

JOIN inpolicyloadings ON inplg_policy_serial = inped_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
LEFT OUTER JOIN inpcodes as claim_reserve ON inldg_claim_reserve_group = claim_reserve.incd_pcode_serial

WHERE
1=1
AND inped_year = '".$_POST["year"]."'
AND inped_period BETWEEN '".$_POST["from"]."' AND '".$_POST["to"]."'

".$product."
".$remove_product."
".$loadings."
".$agents."

AND inped_status = 1
GROUP BY ".$group_group."inldg_loading_serial
,inldg_loading_code
,inldg_long_description
,inity_insurance_type
,claim_reserve.incd_ldg_rsrv_under_reinsurance
,clo_commission_assigned
,inag_agent_code
,inag_long_description
,inldg_commission_assigned
,inpol_commission_percentage
,inpol_commission_percentage1
,inpol_commission_percentage2
,inpol_commission_percentage3
,inpol_commission_percentage4
,inpol_commission_percentage5
,inpol_commission_percentage6
,inpol_commission_percentage7
,inpol_commission_percentage8
,inpol_commission_percentage9
,inpol_commission_percentage10
,incl_alpha_key1

ORDER BY inity_insurance_type,".$group_group."inldg_loading_serial

SELECT
LIST(DISTINCT(inity_insurance_type))
,SUM(#temp.clo_total_premium)as clo_total_premium
,SUM(clo_commission_total)as clo_total_commission
,clo_commission_assigned
,inag_agent_code
,incl_alpha_key1
,inag_long_description
FROM
#temp
GROUP BY 
clo_commission_assigned
,inag_agent_code
,inag_long_description
,clo_commission_assigned
,incl_alpha_key1

ORDER BY inag_agent_code,clo_commission_assigned

";

$result = $sybase->query($sql);
//echo $sql;

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Premium Per Commission </strong></td>
    </tr>
    <tr>
      <td>Year</td>
      <td><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
    </tr>
    <tr>
      <td width="122">Financial Period</td>
      <td width="527"><select name="from" id="from">
        <option value="1" <? if ($_POST["from"] == "1") echo "selected=\"selected\"";?>>January</option>
        <option value="2" <? if ($_POST["from"] == "2") echo "selected=\"selected\"";?>>February</option>
        <option value="3" <? if ($_POST["from"] == "3") echo "selected=\"selected\"";?>>March</option>
        <option value="4" <? if ($_POST["from"] == "4") echo "selected=\"selected\"";?>>April</option>
        <option value="5" <? if ($_POST["from"] == "5") echo "selected=\"selected\"";?>>May</option>
        <option value="6" <? if ($_POST["from"] == "6") echo "selected=\"selected\"";?>>June</option>
        <option value="7" <? if ($_POST["from"] == "7") echo "selected=\"selected\"";?>>July</option>
        <option value="8" <? if ($_POST["from"] == "8") echo "selected=\"selected\"";?>>August</option>
        <option value="9" <? if ($_POST["from"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["from"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["from"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["from"] == "12") echo "selected=\"selected\"";?>>December</option>
      </select>
      /  
      <select name="to" id="to">
        <option value="1" <? if ($_POST["to"] == "1") echo "selected=\"selected\"";?>>January</option>
        <option value="2" <? if ($_POST["to"] == "2") echo "selected=\"selected\"";?>>February</option>
        <option value="3" <? if ($_POST["to"] == "3") echo "selected=\"selected\"";?>>March</option>
        <option value="4" <? if ($_POST["to"] == "4") echo "selected=\"selected\"";?>>April</option>
        <option value="5" <? if ($_POST["to"] == "5") echo "selected=\"selected\"";?>>May</option>
        <option value="6" <? if ($_POST["to"] == "6") echo "selected=\"selected\"";?>>June</option>
        <option value="7" <? if ($_POST["to"] == "7") echo "selected=\"selected\"";?>>July</option>
        <option value="8" <? if ($_POST["to"] == "8") echo "selected=\"selected\"";?>>August</option>
        <option value="9" <? if ($_POST["to"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["to"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["to"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["to"] == "12") echo "selected=\"selected\"";?>>December</option>
        </select> 
      Operation Dates (date of the reserves) </td>
    </tr>
    
    <tr>
      <td>Product</td>
      <td><input name="product" type="text" id="product" value="<? echo $_POST["product"];?>" /> 
      ex  1901 or 1902, Empty for ALL </td>
    </tr>
    <tr>
      <td>Remove Product </td>
      <td><input name="remove_product" type="text" id="remove_product" value="<? echo $_POST["remove_product"];?>" />
        Product here will be removed. ex 19TC </td>
    </tr>
    <tr>
      <td>Loading Code(s) </td>
      <td><input name="loading_codes" type="text" id="loading_codes" value="<? echo $_POST["loading_codes"];?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Loadings Codes separated by comma like:'CODE1','CODE2' (Blank For All) </td>
    </tr>
    <tr>
      <td>Agents</td>
      <td>From 
        <input name="agents_from" type="text" id="agents_from" size="12" value="<? echo $_POST["agents_from"];?>" />
      To
      <input name="agents_to" type="text" id="agents_to" size="12" value="<? echo $_POST["agents_to"];?>" /></td>
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
<table border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="77" align="center"><strong>Agent Code </strong></td>
    <td width="77" align="center"><strong>Sub Agent</strong></td>
    <td width="289" align="left"><strong>Description</strong></td>
    <td width="336" align="left"><strong>Commission</strong></td>
    <td width="113" align="center"><strong>Comm.Total</strong></td>
    <td width="111" align="center"><strong>Premium</strong></td>
  </tr>
<?  
while ($row = $sybase->fetch_assoc($result)) {

$total_premium += $row["clo_total_premium"];
$total_commission += $row["clo_total_commission"];
?>
  
  <tr>
    <td align="center">'<? echo $row["inag_agent_code"];?>'</td>
    <td align="center">'<? echo $row["incl_alpha_key1"];?>'</td>
    <td align="left"><? echo $row["inag_long_description"];?></td>
    <td align="left"><? echo $row["clo_commission_assigned"];?></td>
    <td align="center"><? echo $db->fix_int_to_double($row["clo_total_commission"],2);?></td>
    <td align="center"><? echo $row["clo_total_premium"];?></td>
  </tr>

<?
}//while loop
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>TOTAL</strong></td>
    <td align="center"><strong><? echo $db->fix_int_to_double($total_commission);?></strong></td>
    <td align="center"><strong><? echo $total_premium;?></strong></td>
  </tr>
</table>
</div>
<? } ?>
<?
$db->show_footer();
?>
