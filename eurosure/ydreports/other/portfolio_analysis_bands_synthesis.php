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

if ($_POST["group_months"] != 1) {

	$group_select = ",inpol_policy_period as clo_policy_period,inpol_policy_year as clo_policy_year";
	$group_group = "clo_policy_year,clo_policy_period,";
	
}
else {
	$group_select = ",'".$_POST["from"]."-".$_POST["to"]."' as clo_policy_period , '".$_POST["year"]."' as clo_policy_year";

}

$sql = "
SELECT
inldg_loading_serial
".$group_select."
,inity_insurance_type
,inldg_loading_code
,inldg_long_description
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
,incd_ldg_rsrv_under_reinsurance
FROM
inpolicies
JOIN inpolicyloadings ON inplg_policy_serial = inpol_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial
LEFT OUTER JOIN inpcodes ON inldg_claim_reserve_group = incd_pcode_serial

WHERE
1=1
AND inped_year = '".$_POST["year"]."'
AND inped_period BETWEEN '".$_POST["from"]."' AND '".$_POST["to"]."'

".$product."
".$remove_product."
".$loadings."

AND inped_status = 1
GROUP BY ".$group_group."inldg_loading_serial,inldg_loading_code,inldg_long_description,inity_insurance_type,incd_ldg_rsrv_under_reinsurance

ORDER BY inity_insurance_type,".$group_group."inldg_loading_serial


";
$result = $sybase->query($sql);


}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands </strong></td>
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
        <option value="8" <? if ($_POST["from"] == "9") echo "selected=\"selected\"";?>>September</option>
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
<table width="876" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="41" align="center"><strong>Year</strong></td>
    <td width="48" align="center"><strong>Period</strong></td>
    <td width="112" align="center"><strong>Insurance Type </strong></td>
    <td width="49" align="center"><strong>Serial</strong></td>
    <td width="80" align="center"><strong>Code</strong></td>
    <td width="71" align="center"><strong>R/I </strong></td>
    <td width="377" align="left"><strong>Description</strong></td>
    <td width="80" align="center"><strong>Premium</strong></td>
  </tr>
<?  
while ($row = $sybase->fetch_assoc($result)) {

$total_premium += $row["clo_total_premium"];
?>
  
  <tr>
    <td align="center"><? echo $row["clo_policy_year"];?></td>
    <td align="center"><? echo $row["clo_policy_period"];?></td>
    <td align="center"><? echo $row["inity_insurance_type"];?></td>
    <td align="center"><? echo $row["inldg_loading_serial"];?></td>
    <td align="center"><? echo $row["inldg_loading_code"];?></td>
    <td align="center"><? echo $row["incd_ldg_rsrv_under_reinsurance"];?></td>
    <td align="left"><? echo $row["inldg_long_description"];?></td>
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
    <td><strong>TOTAL</strong></td>
    <td align="center"><strong><? echo $total_premium;?></strong></td>
  </tr>
</table>
<? } ?>
<?
$db->show_footer();
?>
