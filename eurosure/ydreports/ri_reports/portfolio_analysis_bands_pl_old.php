<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();

function show_zero_if_empty($num) {
	if ($num == '') {
		return 0;
	}
	else {
		return $num;
	}
}

function devide_2_numbers($num1,$num2) {

	if ($num2 == 0) {
		return 0;
	}
	else {
		return $num1 / $num2;
	}
	
}

if ($_POST["action"] == "show") {


$sql = "
SELECT
inpol_policy_number
,inpol_policy_serial
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
,-1 * SUM((if incd_ldg_rsrv_under_reinsurance = 'N' THEN (if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif) else 0 ENDIF)* inped_premium_debit_credit)as clo_not_ri_total_premium
,(SELECT MAX(inpit_insured_amount) FROM inpolicyitems WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_insured_amount
,(SELECT COUNT() FROM inpolicysituations WHERE inpst_policy_serial = inpolicies.inpol_policy_serial)as clo_situation_count

into #temp
FROM

inpolicies
JOIN inpolicyloadings ON inplg_policy_serial = inpol_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial
LEFT OUTER JOIN inpcodes ON inldg_claim_reserve_group = incd_pcode_serial

WHERE
1=1
AND (((inped_year*100+inped_period) >= (".$_POST["from_year"]."*100+".$_POST["from"].") 
AND (inped_year*100+inped_period) <= (".$_POST["to_year"]."*100+".$_POST["to"]."))) 

AND inity_insurance_type = '2201'
AND inped_status = 1

GROUP BY inpol_policy_serial,inpol_policy_number
ORDER BY clo_insured_amount ASC



SELECT
inpol_policy_number
,SUM(clo_total_premium) as total_premium
,SUM(clo_not_ri_total_premium) as total_not_ri_premium
,MAX(clo_insured_amount)as insured_amount
,MAX(clo_situation_count)as total_situations
FROM #temp
GROUP BY inpol_policy_number
ORDER BY inpol_policy_number ASC
";
$result = $sybase->query($sql);
//echo $sql;
while ($row = $sybase->fetch_assoc($result)) {

	$ri_premium = $row["total_premium"] - $row["total_not_ri_premium"];
	

	if ($row["insured_amount"] <= 50000) {
		$band = '50000';		
	}//0-4000
	else if ($row["insured_amount"] <= 100000) {
		$band = '100000';		
	}//
	else if ($row["insured_amount"] <= 150000) {
		$band = '150000';		
	}//
	else if ($row["insured_amount"] <= 200000) {
		$band = '200000';		
	}//
	else if ($row["insured_amount"] <= 250000) {
		$band = '250000';		
	}//
	else if ($row["insured_amount"] <= 300000) {
		$band = '300000';		
	}//
	else if ($row["insured_amount"] <= 350000) {
		$band = '350000';		
	}//
	else if ($row["insured_amount"] <= 400000) {
		$band = '400000';		
	}//
	else if ($row["insured_amount"] <= 450000) {
		$band = '450000';		
	}//
	else if ($row["insured_amount"] <= 500000) {
		$band = '500000';		
	}//
	else if ($row["insured_amount"] <= 750000) {
		$band = '750000';		
	}//
	else if ($row["insured_amount"] <= 1000000) {
		$band = '1000000';		
	}//
	else if ($row["insured_amount"] <= 1500000) {
		$band = '1500000';		
	}//
	else {
		$band = 'over';
	}
	$data[$band]["policies"] ++;
	$data[$band]["total_sum_insured"] += $row["insured_amount"];
	$data[$band]["total_premium"] += $ri_premium;
	$data[$band]["total_situations"] += $row["total_situations"];
	
	//get the totals
	$data["totals"]["policies"] ++;
	$data["totals"]["total_sum_insured"] += $row["insured_amount"];
	$data["totals"]["total_premium"] += $ri_premium;
	$data["totals"]["total_situations"] += $row["total_situations"];
	

}//all rows;

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands For Public Liability </strong></td>
    </tr>
    <tr>
      <td>Period From</td>
      <td><select name="from" id="from">
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
      </select>        <input name="from_year" type="text" id="from_year" value="<? echo $_POST["from_year"];?>"></td>
    </tr>
    <tr>
      <td width="122">Period To</td>
      <td width="527"><select name="to" id="to">
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
        <input name="to_year" type="text" id="to_year" value="<? echo $_POST["to_year"];?>" />
      Operation Dates (date of the reserves) </td>
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
<table width="804" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="51" colspan="6" align="center"><strong>PUBLIC LIABILITY RISK PROFILE <br />
      SUM INSURED PER BAND FOR PERIOD <? echo $_POST["from"]."/".$_POST["from_year"]." - ".$_POST["to"]."/".$_POST["to_year"];?></strong></td>
    </tr>
  <tr>
    <td width="180" align="center" bgcolor="#CCCCCC"><strong>BAND</strong></td>
    <td width="125" align="center" bgcolor="#CCCCCC"><strong>PREMIUM</strong></td>
    <td width="100" align="center" bgcolor="#CCCCCC"><strong>POLICY COUNT </strong></td>
    <td width="135" align="center" bgcolor="#CCCCCC"><strong>RISK COUNT PER POLICY </strong></td>
    <td width="125" align="center" bgcolor="#CCCCCC"><strong>AVERAGE PER POLICY </strong></td>
    <td width="125" align="center" bgcolor="#CCCCCC"><strong>AVERAGE PER RISK </strong></td>
    </tr>
  <tr>
    <td align="center"><strong>1-50,000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[50000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[50000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[50000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[50000]["total_premium"] , $data[50000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[50000]["total_premium"] , $data[50000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>50.001 - 100.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[100000]["total_premium"],$data[100000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[100000]["total_premium"],$data[100000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>100.001 - 150.000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[150000]["total_premium"],$data[150000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[150000]["total_premium"],$data[150000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>150.001 - 200.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[200000]["total_premium"],$data[200000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[200000]["total_premium"],$data[200000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>200.001 - 250.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[250000]["total_premium"],$data[250000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[250000]["total_premium"],$data[250000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>250.001 - 300.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[300000]["total_premium"],$data[300000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[300000]["total_premium"],$data[300000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>300.001 - 350.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[350000]["total_premium"],$data[350000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[350000]["total_premium"],$data[350000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>350.001 - 400.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[400000]["total_premium"],$data[400000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[400000]["total_premium"],$data[400000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>400.001 - 450.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[450000]["total_premium"],$data[450000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[450000]["total_premium"],$data[450000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>450.001 - 500.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[500000]["total_premium"],$data[500000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[500000]["total_premium"],$data[500000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>500.001 - 750.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[750000]["total_premium"],$data[750000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[750000]["total_premium"],$data[750000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>750.001 - 1.000.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1000000]["total_premium"],$data[1000000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1000000]["total_premium"],$data[1000000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>1.000.001 - 1.500.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1500000]["total_premium"],$data[1500000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1500000]["total_premium"],$data[1500000]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>1.500.001 - 1.750.000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data["over"]["total_premium"],$data["over"]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data["over"]["total_premium"],$data["over"]["total_situations"]),0));?></td>
    </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_premium"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["policies"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_situations"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty(round(devide_2_numbers($data["totals"]["total_premium"],$data["totals"]["policies"]),0));?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty(round(devide_2_numbers($data["totals"]["total_premium"],$data["totals"]["total_situations"]),0));?></strong></td>
    </tr>
</table>
</div>
<? } ?>
<?
$db->show_footer();
?>
