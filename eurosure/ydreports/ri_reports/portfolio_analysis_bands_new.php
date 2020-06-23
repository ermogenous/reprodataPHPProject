<?
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();

function devide_2_numbers($num1,$num2) {

	if ($num2 == 0) {
		return 0;
	}
	else {
		return $num1 / $num2;
	}
	
}
function show_zero_if_empty($value,$decimals=0) {
global $db;
	if ($value == "" || $value == 0) {
		echo '0';	
	}
	else {
		echo $db->fix_int_to_double($value,$decimals);	
	}
}
//get the functions file from the Executive Reports - Profitability reports.
include("../functions/production.php");

if ($_POST["action"] == "show") {

$insurance_types["1001"] = 23;
$insurance_types["2201"] = 21;







//loop into the results
while ($row = $sybase->fetch_assoc($result)) {

	$premium = $row["clo_premium_all_periods"];
	if ($_POST["insurance_type"] == '1001') {
		$insured_amount = $row["clo_pa_insured_amount"];
	}
	else if ($_POST["insurance_type"] == '2201') {
		$insured_amount = $row["clo_pl_insured_amount"];
	}
	

	if ($insured_amount <= 50000) {
		$band = '50000';		
	}//0-4000
	else if ($insured_amount <= 100000) {
		$band = '100000';		
	}//
	else if ($insured_amount <= 150000) {
		$band = '150000';		
	}//
	else if ($insured_amount <= 200000) {
		$band = '200000';		
	}//
	else if ($insured_amount <= 250000) {
		$band = '250000';		
	}//
	else if ($insured_amount <= 300000) {
		$band = '300000';		
	}//
	else if ($insured_amount <= 350000) {
		$band = '350000';		
	}//
	else if ($insured_amount <= 400000) {
		$band = '400000';		
	}//
	else if ($insured_amount <= 450000) {
		$band = '450000';		
	}//
	else if ($insured_amount <= 500000) {
		$band = '500000';		
	}//
	else if ($insured_amount <= 750000) {
		$band = '750000';		
	}//
	else if ($insured_amount <= 1000000) {
		$band = '1000000';		
	}//
	else if ($insured_amount <= 1500000) {
		$band = '1500000';		
	}//
	else {
		$band = 'over';
	}
	//echo $band."<br>";
	$data[$band]["policies"] ++;
	$data[$band]["total_sum_insured"] += $insured_amount;
	$data[$band]["total_premium"] += $premium;
	$data[$band]["total_situations"] += $row["clo_total_situations"];
	
	//get the totals
	$data["totals"]["policies"] ++;
	$data["totals"]["total_sum_insured"] += $insured_amount;
	$data["totals"]["total_premium"] += $premium;
	$data["totals"]["total_situations"] += $row["clo_total_situations"];
	
	if ($_POST["show_policies"] == 1) {
		echo $row["inpol_policy_number"]." - ".$insured_amount." - ".$premium."<br>";	
	}

}//all rows;

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands As At Date</strong></td>
    </tr>
    <tr>
      <td>Insurance Type</td>
      <td><select name="insurance_type" id="insurance_type">
        <option value="1001" <? if ($_POST["insurance_type"] == "1001") echo "selected=\"selected\"";?>>Personal Accident</option>
        <option value="2201" <? if ($_POST["insurance_type"] == "2201") echo "selected=\"selected\"";?>>Public Liability</option>
      </select></td>
    </tr>
    <tr>
      <td width="165">As At Date</td>
      <td width="484"><input type="text" name="as_at_date" id="as_at_date" value="<? echo $_POST["as_at_date"];?>" />
        YYYY-MM-DD</td>
    </tr>
    <tr>
      <td valign="top">Up To Period</td>
      <td><p>
        <select name="up_to_period" id="up_to_period">
          <option value="1" <? if ($_POST["up_to_period"] == "1") echo "selected=\"selected\"";?>>01 - January</option>
          <option value="2" <? if ($_POST["up_to_period"] == "2") echo "selected=\"selected\"";?>>02 - February</option>
          <option value="3" <? if ($_POST["up_to_period"] == "3") echo "selected=\"selected\"";?>>03 - March</option>
          <option value="4" <? if ($_POST["up_to_period"] == "4") echo "selected=\"selected\"";?>>04 - April</option>
          <option value="5" <? if ($_POST["up_to_period"] == "5") echo "selected=\"selected\"";?>>05 - May</option>
          <option value="6" <? if ($_POST["up_to_period"] == "6") echo "selected=\"selected\"";?>>06 - June</option>
          <option value="7" <? if ($_POST["up_to_period"] == "7") echo "selected=\"selected\"";?>>07 - July</option>
          <option value="8" <? if ($_POST["up_to_period"] == "8") echo "selected=\"selected\"";?>>08 - August</option>
          <option value="9" <? if ($_POST["up_to_period"] == "9") echo "selected=\"selected\"";?>>09 - September</option>
          <option value="10" <? if ($_POST["up_to_period"] == "10") echo "selected=\"selected\"";?>>10 - October</option>
          <option value="11" <? if ($_POST["up_to_period"] == "11") echo "selected=\"selected\"";?>>11 - November</option>
          <option value="12" <? if ($_POST["up_to_period"] == "12") echo "selected=\"selected\"";?>>12 - December</option>
        </select>        
        Year
        <input name="up_to_year" type="text" id="up_to_year" value="<? echo $_POST["up_to_year"];?>">
      </p>
      <p>Will calculate up to this financial period changes. If an endorement affects this as at period but is posted after this period will not be included. The correct is to use the same period as the period from the as at date.</p></td>
    </tr>
    <tr>
      <td>Product Correlation</td>
      <td><select name="product" id="product">
        <option value="inity" <? if ($_POST["product"] == "inity") echo "selected=\"selected\"";?>>Insurance Type</option>
        <option value="alt" <? if ($_POST["product"] == "alt") echo "selected=\"selected\"";?>>Alternative Insurance Type</option>
      </select></td>
    </tr>
    <tr>
      <td height="45">Hide Insured Amounts of 200.000 and under</td>
      <td><input name="hide_200000" type="checkbox" id="hide_200000" value="1" <? if ($_POST["hide_200000"] == 1) echo "checked=\"checked\"";?> /> 
        NOTE: hides only the alternative policies</td>
    </tr>
    <tr>
      <td>Only PA policies</td>
      <td>All Except Mini Ins.
      <? if ($_POST["only_pa"] == "") $_POST["only_pa"] = "exclude_mini"; ?>
      <input type="radio" name="only_pa" id="test3" value="exclude_mini" <? if ($_POST["only_pa"] == "exclude_mini") echo "checked=\"checked\"";?> />
      Group
      <input type="radio" name="only_pa" id="test" value="GROUP" <? if ($_POST["only_pa"] == "GROUP") echo "checked=\"checked\"";?> />
      Only Mini Ins.
      <input type="radio" name="only_pa" id="test2" value="MINI" <? if ($_POST["only_pa"] == "MINI") echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show">
      Show Policies
      <input name="show_policies" type="checkbox" id="show_policies" value="1" <? if ($_POST["show_policies"] == 1) echo "checked=\"checked\"";?>/></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NOTE <br />
        2201 -&gt; 1702,1703 are excluded since all is retained.</td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {
	
	if ($_POST["insurance_type"] == '1001') {
		$label = 'PERSONAL ACCIDENT';	
	}
	else if ($_POST["insurance_type"] == '2201') {
		$label = 'PUBLIC LIABILITY';	
	}
	
?>
<br><br>
<div id="print_view_section_html" align="center">
<table width="804" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="51" colspan="6" align="center"><strong><? echo $label;?> RISK PROFILE <br />
      SUM INSURED PER BAND FOR AS AT DATE <? echo $_POST["as_at_date"];?></strong></td>
    </tr>
  <tr>
    <td width="155" align="center" bgcolor="#CCCCCC"><strong>BAND</strong></td>
    <td width="124" align="center" bgcolor="#CCCCCC"><strong>POLICY COUNT </strong></td>
    <td width="123" align="center" bgcolor="#CCCCCC"><strong>RISK COUNT PER POLICY </strong></td>
    <td width="129" align="center" bgcolor="#CCCCCC"><strong>AVERAGE RISKS PER POLICY </strong></td>
    <td width="142" align="center" bgcolor="#CCCCCC"><strong>TOTAL INSURED AMOUNT</strong></td>
    <td width="117" align="center" bgcolor="#CCCCCC"><strong>PREMIUM</strong></td>
    </tr>
  <tr>
    <td align="center"><strong>1-50,000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[50000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[50000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[50000]["total_situations"] , $data[50000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["50000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["50000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>50.001 - 100.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[100000]["total_situations"],$data[100000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["100000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["100000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>100.001 - 150.000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[150000]["total_situations"],$data[150000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["150000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["150000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>150.001 - 200.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[200000]["total_situations"],$data[200000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["200000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["200000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>200.001 - 250.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[250000]["total_situations"],$data[250000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["250000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["250000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>250.001 - 300.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[300000]["total_situations"],$data[300000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["300000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["300000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>300.001 - 350.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[350000]["total_situations"],$data[350000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["350000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["350000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>350.001 - 400.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[400000]["total_situations"],$data[400000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["400000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["400000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>400.001 - 450.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[450000]["total_situations"],$data[450000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["450000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["450000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>450.001 - 500.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[500000]["total_situations"],$data[500000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["500000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["500000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>500.001 - 750.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[750000]["total_situations"],$data[750000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["750000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["750000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>750.001 - 1.000.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1000000]["total_situations"],$data[1000000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["1000000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["1000000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>1.000.001 - 1.500.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1500000]["total_situations"],$data[1500000]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["1500000"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["1500000"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center"><strong>1.500.001 AND OVER</strong></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_situations"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data["over"]["total_situations"],$data["over"]["policies"]),2),2);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_premium"]);?></td>
    </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["policies"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_situations"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty(round(devide_2_numbers($data["totals"]["total_situations"],$data["totals"]["policies"]),2),2);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_sum_insured"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_premium"]);?></strong></td>
    </tr>
</table>
Note*: In the insured amount bands the total accumulated POLICY insured amount is calcualated and NOT per RIST(MEMBER)
</div>
<? } ?>
<?
$db->show_footer();
?>
