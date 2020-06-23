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


if ($_POST["action"] == "show") {


$sql = "
SELECT
inpol_policy_number
,inpol_policy_serial
,IF inped_premium_debit_credit = 0 THEN 'L' ELSE IF inped_financial_policy < 0 THEN 'C' ELSE inpol_process_status ENDIF ENDIF as clo_process_status
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_period_premium endif)* inped_premium_debit_credit)as clo_total_premium
,-1 * SUM((if incd_ldg_rsrv_under_reinsurance = 'N' THEN (if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_period_premium endif) else 0 ENDIF)* inped_premium_debit_credit)as clo_not_ri_total_premium
,(SELECT SUM(inpit_insured_amount + COALESCE(inpia_insured_amount_alt1, 0)) AS clo_insured_amount  FROM inpolicyitems LEFT OUTER JOIN inpolicyitemaux ON inpit_pit_auto_serial = inpia_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_insured_amount

,(SELECT MAX(IF inpri_reinsurance_type = '1-RTN' THEN inpri_premium * inpri_reinsurance_debit_credit ELSE 0 ENDIF) FROM inpolicyreinsurance WHERE inpri_policy_serial = inpol_policy_serial) as clo_rtn_premium
,(SELECT MAX(IF inpri_reinsurance_type = '2-QTA' THEN inpri_premium * inpri_reinsurance_debit_credit ELSE 0 ENDIF) FROM inpolicyreinsurance WHERE inpri_policy_serial = inpol_policy_serial) as clo_qta_premium
,(SELECT MAX(IF inpri_reinsurance_type NOT IN ('1-RTN','2-QTA') THEN inpri_premium * inpri_reinsurance_debit_credit ELSE 0 ENDIF) FROM inpolicyreinsurance WHERE inpri_policy_serial = inpol_policy_serial) as clo_fac_premium
,(SELECT MAX(IF inpri_reinsurance_type = '1-RTN' THEN inpri_insured_amount ELSE 0 ENDIF) FROM inpolicyreinsurance WHERE inpri_policy_serial = inpol_policy_serial) as clo_rtn_insured_amount
,(SELECT MAX(IF inpri_reinsurance_type = '2-QTA' THEN inpri_insured_amount ELSE 0 ENDIF) FROM inpolicyreinsurance WHERE inpri_policy_serial = inpol_policy_serial) as clo_qta_insured_amount
,(SELECT MAX(IF inpri_reinsurance_type NOT IN ('1-RTN','2-QTA') THEN inpri_insured_amount ELSE 0 ENDIF) FROM inpolicyreinsurance WHERE inpri_policy_serial = inpol_policy_serial) as clo_fac_insured_amount


into #temp
FROM

inpolicies
JOIN inpolicyloadings ON inplg_policy_serial = inpol_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyendorsement ON inpol_policy_serial = inped_financial_policy_abs
//JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial
LEFT OUTER JOIN inpcodes ON inldg_claim_reserve_group = incd_pcode_serial

WHERE
1=1
AND inped_year = '".$_POST["year"]."'
AND inped_period BETWEEN '".$_POST["from"]."' AND '".$_POST["to"]."'
AND inity_insurance_type = '2101'
AND inped_status = 1
AND clo_process_status NOT IN ('L')

GROUP BY inpol_policy_serial,inpol_policy_number,inpol_process_status,inped_financial_policy,inped_premium_debit_credit
ORDER BY clo_insured_amount ASC



SELECT
inpol_policy_number
,SUM(clo_total_premium) as total_premium
,SUM(clo_not_ri_total_premium) as total_not_ri_premium
,MAX(clo_insured_amount)as insured_amount
,SUM(clo_rtn_premium)as total_rtn_premium
,SUM(clo_qta_premium)as total_qta_premium
,SUM(clo_fac_premium)as total_fac_premium
,MAX(clo_rtn_insured_amount)as total_rtn_insured_amount
,MAX(clo_qta_insured_amount)as total_qta_insured_amount
,MAX(clo_fac_insured_amount)as total_fac_insured_amount
FROM #temp
GROUP BY inpol_policy_number
ORDER BY inpol_policy_number ASC
";
$result = $sybase->query($sql);

while ($row = $sybase->fetch_assoc($result)) {

	$ri_premium = $row["total_premium"] - $row["total_not_ri_premium"];
	

	if ($row["insured_amount"] <= 4000) {
		$band = '4000';		
	}//0-4000
	else if ($row["insured_amount"] <= 10000) {
		$band = '10000';		
	}//
	else if ($row["insured_amount"] <= 20000) {
		$band = '20000';		
	}//
	else if ($row["insured_amount"] <= 40000) {
		$band = '40000';		
	}//
	else if ($row["insured_amount"] <= 60000) {
		$band = '60000';		
	}//
	else if ($row["insured_amount"] <= 80000) {
		$band = '80000';		
	}//
	else if ($row["insured_amount"] <= 100000) {
		$band = '100000';		
	}//
	else if ($row["insured_amount"] <= 120000) {
		$band = '120000';		
	}//
	else if ($row["insured_amount"] <= 140000) {
		$band = '140000';		
	}//
	else if ($row["insured_amount"] <= 160000) {
		$band = '160000';		
	}//
	else if ($row["insured_amount"] <= 180000) {
		$band = '180000';		
	}//
	else if ($row["insured_amount"] <= 200000) {
		$band = '200000';		
	}//
	else if ($row["insured_amount"] <= 300000) {
		$band = '300000';		
	}//
	else {
		$band = 'over';
	}
	$data[$band]["policies"] ++;
	$data[$band]["total_sum_insured"] += $row["insured_amount"];
	$data[$band]["total_premium"] += $ri_premium;
	$data[$band]["retention_sum_insured"] += $row["total_rtn_insured_amount"];
	$data[$band]["retention_premium"] += $row["total_rtn_premium"];
	$data[$band]["treaty_sum_insured"] += $row["total_qta_insured_amount"];
	$data[$band]["treaty_premium"] += $row["total_qta_premium"];
	$data[$band]["fac_sum_insured"] += $row["total_fac_insured_amount"];
	$data[$band]["fac_premium"] += $row["total_fac_premium"];

	//get the totals
	$data["totals"]["policies"] ++;
	$data["totals"]["total_sum_insured"] += $row["insured_amount"];
	$data["totals"]["total_premium"] += $ri_premium;
	$data["totals"]["retention_sum_insured"] += $row["total_rtn_insured_amount"];
	$data["totals"]["retention_premium"] += $row["total_rtn_premium"];
	$data["totals"]["treaty_sum_insured"] += $row["total_qta_insured_amount"];
	$data["totals"]["treaty_premium"] += $row["total_qta_premium"];
	$data["totals"]["fac_sum_insured"] += $row["total_fac_insured_amount"];
	$data["totals"]["fac_premium"] += $row["total_fac_premium"];
	
	

}//all rows;

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands For Marine Hull </strong></td>
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
    <td height="51" colspan="9" align="center"><strong>RISK PROFILE FOR YACHTS &amp; PLEASURE CRAFT<br />
      PERIOD <? echo $_POST["from"]."/".$_POST["year"]." - ".$_POST["to"]."/".$_POST["year"];?></strong></td>
    </tr>
  <tr>
    <td width="87" align="center" bgcolor="#CCCCCC"><strong>Range of Sum Insured in Euro 000 </strong></td>
    <td width="61" align="center" bgcolor="#CCCCCC"><strong>No of Policies </strong></td>
    <td width="82" align="center" bgcolor="#CCCCCC"><strong>Total Sum Insured In Euro </strong></td>
    <td width="71" align="center" bgcolor="#CCCCCC"><strong>Total Premium In Euro </strong></td>
    <td width="90" align="center" bgcolor="#CCCCCC"><strong>Retention Sum Insured in Euro </strong></td>
    <td width="87" align="center" bgcolor="#CCCCCC"><strong>Treaty Sum Insured in Euro </strong></td>
    <td width="82" align="center" bgcolor="#CCCCCC"><strong>Treaty Premium in Euro </strong></td>
    <td width="113" align="center" bgcolor="#CCCCCC"><strong>Faculative Cession Sum Insured in Euro </strong></td>
    <td width="111" align="center" bgcolor="#CCCCCC"><strong>Facultative Cession Premium in Euro </strong></td>
  </tr>
  <tr>
    <td align="center"><strong>0 - 4</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[4000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>4 - 10 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[10000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><p><strong>10 - 20 </strong></p>    </td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[20000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>20 - 40 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[40000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>40 - 60 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[60000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>60 - 80 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[80000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>80 - 100 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>100 - 120 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[120000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>120 - 140 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[140000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>140 - 160 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[160000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>160 - 180 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[180000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>180 - 200</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>200 - 300 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center"><strong>&gt;300</strong></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["retention_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["treaty_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["treaty_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["fac_sum_insured"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["fac_premium"]);?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["policies"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_sum_insured"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_premium"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["retention_sum_insured"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["treaty_sum_insured"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["treaty_premium"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["fac_sum_insured"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["fac_premium"]);?></strong></td>
  </tr>
</table>
</div>
<? } ?>
<?
$db->show_footer();
?>
