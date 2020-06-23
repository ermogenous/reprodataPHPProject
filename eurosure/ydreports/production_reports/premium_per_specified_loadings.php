<?
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();


if ($_POST["action"] == "show") {

$product = "";
if ($_POST["product_from"] != "") {

	$product = "AND inity_insurance_type BETWEEN '".$_POST["product_from"]."' AND '".$_POST["product_to"]."'";

}

$remove_product = "";
if ($_POST["remove_product"] != "") {

	$remove_product = "AND inity_insurance_type NOT LIKE '".$_POST["remove_product"]."'";

}

if ($_POST["loading_codes"] != "") {
$_POST["loading_codes"] = stripslashes($_POST["loading_codes"]);
	$loadings = "AND inldg_loading_code IN (".$_POST["loading_codes"].")";
}

if ($_POST["group_months"] != 1) {

	$group_select = ",inped_period as clo_policy_period,inped_year as clo_policy_year";
	$group_group = "clo_policy_year,clo_policy_period,";
	
}
else {
	$group_select = ",'".$_POST["from"]."-".$_POST["to"]."' as clo_policy_period , '".$_POST["year"]."' as clo_policy_year";

}

if ($_POST["income_account"] != "") {
	$income_account = "AND inldg_income_account LIKE '".$_POST["income_account"]."'";
}

$sql = "
SELECT
inldg_loading_serial
".$group_select."
,inity_insurance_type
,inldg_loading_code
,inldg_long_description
,inldg_loading_type
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
,claim_reserve.incd_ldg_rsrv_under_reinsurance
,inldg_income_account
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

FROM
inpolicies
JOIN inpolicyloadings ON inplg_policy_serial = inpol_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial
LEFT OUTER JOIN inpcodes as claim_reserve ON inldg_claim_reserve_group = claim_reserve.incd_pcode_serial
JOIN inpcodes as subform ON inity_insurance_sub_form = subform.incd_record_code AND subform.incd_record_type = 'SF'

WHERE
1=1
AND inped_year = '".$_POST["year"]."'
AND inped_period BETWEEN '".$_POST["from"]."' AND '".$_POST["to"]."'

".$product."
".$remove_product."
".$loadings."
".$income_account."

AND inped_status = 1
GROUP BY ".$group_group."inldg_loading_serial
,inldg_loading_code
,inldg_long_description
,inity_insurance_type
,claim_reserve.incd_ldg_rsrv_under_reinsurance
,clo_commission_assigned
,inldg_loading_type
,inldg_income_account

//ORDER BY inity_insurance_type,".$group_group."inldg_loading_serial
ORDER BY ".$_POST["sort_by"]." ASC

";

$result = $sybase->query($sql);
//echo $sql;

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="779" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Premium Per Specified Loadings </strong></td>
    </tr>
    <tr>
      <td>Year</td>
      <td><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
    </tr>
    <tr>
      <td width="122">Financial Period</td>
      <td width="655"><select name="from" id="from">
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
      <td><input name="product_from" type="text" id="product_from" value="<? echo $_POST["product_from"];?>" size="10" /> 
      To 
        <input name="product_to" type="text" id="product_to" value="<? echo $_POST["product_to"];?>" size="10" />
      ex  1901 or 1902, Empty for ALL </td>
    </tr>
    <tr>
      <td>Remove Product </td>
      <td><input name="remove_product" type="text" id="remove_product" value="<? echo $_POST["remove_product"];?>" />
        Product here will be removed. ex 19TC </td>
    </tr>
    <tr>
      <td>Loading Code(s) </td>
      <td><textarea name="loading_codes" cols="60" rows="4" id="loading_codes"><? echo $_POST["loading_codes"];?></textarea></td>
    </tr>
    <tr>
      <td>Income Account</td>
      <td><input type="text" name="income_account" id="income_account" value="<? echo $_POST["income_account"];?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Loadings Codes separated by comma like:'CODE1','CODE2' (Blank For All) </td>
    </tr>
    <tr>
      <td>Order By</td>
      <td><select name="sort_by" id="sort_by">
        <option value="inity_insurance_type">Insurance Type</option>
        <option value="inldg_loading_serial">Loading Serial</option>
        <option value="inldg_loading_code">Code</option>
        <option value="clo_commission_assigned">Commission</option>
        <option value="inldg_long_description">Description</option>
        <option value="inldg_loading_type">Type</option>
        <option value="clo_total_premium">Premium</option>
      </select></td>
    </tr>
    <tr>
      <td>Group Months </td>
      <td><input name="group_months" type="checkbox" id="group_months" value="1" <? if ($_POST["group_months"] == 1) echo "checked=\"checked\"";?> /></td>
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
<table width="938" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="39" align="center"><strong>Year</strong></td>
    <td width="46" align="center"><strong>Period</strong></td>
    <td width="70" align="center"><strong>Insurance Type </strong></td>
    <td width="58" align="center"><strong>Loading Serial</strong></td>
    <td width="72" align="center"><strong>Code</strong></td>
    <td width="38" align="center"><strong>R/I </strong></td>
    <td width="81" align="left"><strong>Commission</strong></td>
    <td width="81" align="left"><strong>Income A/C</strong></td>
    <td width="347" align="left"><strong>Description</strong></td>
    <td width="81" align="center"><strong>Type</strong></td>
    <td width="84" align="center"><strong>Premium</strong></td>
  </tr>
<?  
while ($row = $sybase->fetch_assoc($result)) {

$total_premium += $row["clo_total_premium"];
//get the totals per loading type.
$total[$row["inldg_loading_type"]] += $row["clo_total_premium"];

?>
  
  <tr>
    <td align="center"><? echo $row["clo_policy_year"];?></td>
    <td align="center"><? echo $row["clo_policy_period"];?></td>
    <td align="center"><? echo $row["inity_insurance_type"];?></td>
    <td align="center"><? echo $row["inldg_loading_serial"];?></td>
    <td align="center"><? echo $row["inldg_loading_code"];?></td>
    <td align="center"><? echo $row["incd_ldg_rsrv_under_reinsurance"];?></td>
    <td align="left"><? echo $row["clo_commission_assigned"];?></td>
    <td align="left"><? echo $row["inldg_income_account"];?></td>
    <td align="left"><? echo $row["inldg_long_description"];?></td>
    <td align="center"><? echo $row["inldg_loading_type"];?></td>
    <td align="center"><? echo $row["clo_total_premium"];?></td>
  </tr>

<?
}//while loop
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>TOTAL</strong></td>
    <td>&nbsp;</td>
    <td align="center"><strong><? echo $total_premium;?></strong></td>
  </tr>
</table>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><strong>Totals</strong></td>
    </tr>
  <tr>
    <td width="275"><strong>Thirt Party Loadings </strong></td>
    <td width="275"><strong><? echo $total["A"];?></strong></td>
  </tr>
  <tr>
    <td><strong>Fire &amp; Theft Loadings </strong></td>
    <td><strong><? echo $total["B"];?></strong></td>
  </tr>
  <tr>
    <td><strong>Comprehensive Loadings </strong></td>
    <td><strong><? echo $total["C"];?></strong></td>
  </tr>
  <tr>
    <td><strong>Total</strong></td>
    <td><strong><? echo $total["A"] + $total["B"] + $total["C"];?></strong></td>
  </tr>
</table>

</div>
<? } ?>
<?
$db->show_footer();
?>
