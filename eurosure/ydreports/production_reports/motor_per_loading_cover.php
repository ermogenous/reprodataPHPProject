<?
include("../../include/main.php");
$db = new Main();
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

$sql = "
SELECT
inpol_policy_serial
,inpol_policy_number
,inpol_cover
,inpol_policy_period
,inpol_policy_year
,SUM(IF inldg_loading_type = 'A' THEN (-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit)) ELSE 0 ENDIF) as clo_third_party_premium
,SUM(IF inldg_loading_type = 'B' THEN (-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit)) ELSE 0 ENDIF) as clo_fire_theft_premium
,SUM(IF inldg_loading_type = 'C' THEN (-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit)) ELSE 0 ENDIF) as clo_comprehensive_premium
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
FROM
inpolicies
JOIN inpolicyloadings ON inplg_policy_serial = inpol_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial

WHERE
1=1
AND inped_year = '".$_POST["year"]."'
AND inped_period BETWEEN '".$_POST["from"]."' AND '".$_POST["to"]."'
".$product."
".$remove_product."
AND inped_status = 1
AND inity_insurance_form = 'M'
GROUP BY inpol_policy_serial,inpol_policy_number,inpol_cover,inpol_policy_period,inpol_policy_year,inity_insurance_type

ORDER BY inpol_policy_number
";
$result = $sybase->query($sql);

$total_policies = 0;
while ($row = $sybase->fetch_assoc($result)) {
$total_policies++;

	$tp_premium += $row["clo_third_party_premium"];
	$ft_premium += $row["clo_fire_theft_premium"];
	$cs_premium += $row["clo_comprehensive_premium"];
	$total_premium += $row["clo_total_premium"];
	
	
}//while loop
}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Premium Based on the Loading Cover  </strong></td>
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
        <option value="8" <? if ($_POST["to"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["to"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["to"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["to"] == "12") echo "selected=\"selected\"";?>>December</option>
        </select> 
      Operation Dates (date of the reserves) </td>
    </tr>
    
    <tr>
      <td>Product</td>
      <td><input name="product" type="text" id="product" value="<? echo $_POST["product"];?>" /> 
      ex  1901 or 1902, Empty for all the motor </td>
    </tr>
    <tr>
      <td>Remove Product </td>
      <td><input name="remove_product" type="text" id="remove_product" value="<? echo $_POST["remove_product"];?>" />
        Product here will be removed. ex 19TC </td>
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
<table width="674" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
  <tr>
    <td width="232"><strong>Total Policy Phases <? echo $total_policies;?></strong> </td>
    <td width="110" align="center"><strong>Thirt Party </strong></td>
    <td width="110" align="center"><strong>Fire &amp; Theft </strong></td>
    <td width="110" align="center"><strong>Comprehensive</strong></td>
    <td width="110" align="center"><strong>TOTALS</strong></td>
  </tr>
  <tr>
    <td><strong>Premium</strong></td>
    <td align="center"><? echo sprintf("%01.2f",$tp_premium);?></td>
    <td align="center"><? echo sprintf("%01.2f",$ft_premium);?></td>
    <td align="center"><? echo sprintf("%01.2f",$cs_premium);?></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$total_premium);?></strong></td>
  </tr>
  
<?
$total = $res_total + $out_total;
?>
  <tr>
    <td><strong>%</strong></td>
    <td align="center"><? echo sprintf("%01.2f",(($tp_premium / $total_premium)*100));?>%</td>
    <td align="center"><? echo sprintf("%01.2f",(($ft_premium / $total_premium)*100));?>%</td>
    <td align="center"><? echo sprintf("%01.2f",(($cs_premium / $total_premium)*100));?>%</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</div>
<? } ?>

<?
$db->show_footer();
?>