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
inpolicies.inpol_policy_number ,           
inagents.inag_agent_code ,           
inpolicies.inpol_policy_serial ,           
inity_insurance_type as clo_sort1,          
IF inped_endorsement_serial = inpol_last_cancellation_endorsement_serial THEN IF inpol_status = 'A' AND inpol_replaced_by_policy_serial = 0 AND inpol_cancellation_date IS NOT NULL THEN 'C' ELSE 'L' ENDIF ELSE inpol_process_status ENDIF as clo_process_status,
((inped_fees * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_fees * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_fees,           
((inped_stamps * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_stamps * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_stamps,           
((inped_x_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_x_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_x_premium,           
COALESCE((SELECT LIST(DISTINCT intrh_document_number) FROM intransactiondetails, intransactionheaders WHERE intrd_policy_serial = inpol_policy_serial AND intrd_endorsement_serial = IF clo_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF clo_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF AND intrd_trh_auto_serial = intrh_auto_serial AND intrd_related_type IN ('A', 'C')), '') As clo_document_number,           
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial JOIN ininsurancetypes ity ON ity.inity_insurance_type_serial = oldpol.inpol_insurance_type_serial WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND ity.inity_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND ity.inity_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_endorsement,
((inped_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN IF inpol_status IN ('C','O') THEN clo_refund_outstanding_endorsement ELSE COALESCE((SELECT ((a.inped_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ENDIF ELSE 0 ENDIF as clo_premium,

IF clo_process_status = 'E' THEN (SELECT oldpol.inpol_process_status FROM inpolicies oldpol WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial) ELSE '' ENDIF as clo_replacing_policy_pstatus,
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial JOIN ininsurancetypes ity ON ity.inity_insurance_type_serial = oldpol.inpol_insurance_type_serial WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND inldg_mif_applied <> 'N' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND ity.inity_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND ity.inity_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_mif_pr_endorsement,

(SELECT MAX(IF initm_item_flag = '1' /* COVER FOR DEATH */ THEN inpit_insured_amount ELSE 0 ENDIF) FROM inpolicyitems JOIN initems ON inpit_item_serial = initm_item_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_insured_amount



into #temp
FROM
intemplates 
RIGHT OUTER JOIN inpolicies ON intemplates.intmpl_template_serial = inpolicies.inpol_template_serial ,           
inclients ,           
inagents ,           
inpolicyendorsement ,           
ininsurancetypes ,           
ingeneralagents    

WHERE 
( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial ) 
and          ((inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_endorsement_serial) 
or           (inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_cancellation_endorsement_serial 
and          (   inpolicies.inpol_replaced_by_policy_serial = 0)) /* CANCELLATION OR LAPSED */ )    

AND  1=1  
AND LEFT(clo_process_status, 1) IN ('N','R','E','D','C','L') 
AND inpol_status IN ('A','N') 
AND clo_process_status <> 'L'
AND (inped_year*100+inped_period)>=(".$_POST["year"]."*100+".$_POST["from"].") 
AND (inped_year*100+inped_period)<=(".$_POST["year"]."*100+".$_POST["to"].") 
AND clo_sort1 = '1001' 


SELECT 

COUNT() as total_risks
,SUM(clo_premium)as total_premium
,inpol_policy_number
,MAX(clo_insured_amount)as insured_amount
FROM #temp

GROUP BY inpol_policy_number

ORDER BY insured_amount ASC
";
$result = $sybase->query($sql);
//echo $sql;
while ($row = $sybase->fetch_assoc($result)) {

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
	$data[$band]["total_premium"] += $row["total_premium"];
	$data[$band]["total_risks"] += $row["total_risks"];
	
	//get the totals
	$data["totals"]["policies"] ++;
	$data["totals"]["total_sum_insured"] += $row["insured_amount"];
	$data["totals"]["total_premium"] += $row["total_premium"];
	$data["totals"]["total_risks"] += $row["total_risks"];
	

}//all rows;

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands For Personal Accident 1001 </strong></td>
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
    <td height="51" colspan="6" align="center"><strong>PERSONAL ACCIDENT  RISK PROFILE <br />
      SUM INSURED PER BAND FOR PERIOD <? echo $_POST["from"]."/".$_POST["year"]." - ".$_POST["to"]."/".$_POST["year"];?></strong></td>
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
    <td align="center"><? echo show_zero_if_empty($data[50000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[50000]["total_premium"] , $data[50000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[50000]["total_premium"] , $data[50000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>50.001 - 100.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[100000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[100000]["total_premium"],$data[100000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[100000]["total_premium"],$data[100000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>100.001 - 150.000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[150000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[150000]["total_premium"],$data[150000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[150000]["total_premium"],$data[150000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>150.001 - 200.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[200000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[200000]["total_premium"],$data[200000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[200000]["total_premium"],$data[200000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>200.001 - 250.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[250000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[250000]["total_premium"],$data[250000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[250000]["total_premium"],$data[250000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>250.001 - 300.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[300000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[300000]["total_premium"],$data[300000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[300000]["total_premium"],$data[300000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>300.001 - 350.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[350000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[350000]["total_premium"],$data[350000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[350000]["total_premium"],$data[350000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>350.001 - 400.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[400000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[400000]["total_premium"],$data[400000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[400000]["total_premium"],$data[400000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>400.001 - 450.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[450000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[450000]["total_premium"],$data[450000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[450000]["total_premium"],$data[450000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>450.001 - 500.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[500000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[500000]["total_premium"],$data[500000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[500000]["total_premium"],$data[500000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>500.001 - 750.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[750000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[750000]["total_premium"],$data[750000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[750000]["total_premium"],$data[750000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>750.001 - 1.000.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1000000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1000000]["total_premium"],$data[1000000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1000000]["total_premium"],$data[1000000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>1.000.001 - 1.500.000 </strong></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data[1500000]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1500000]["total_premium"],$data[1500000]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data[1500000]["total_premium"],$data[1500000]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center"><strong>1.500.001 - 1.750.000</strong></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_premium"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["policies"]);?></td>
    <td align="center"><? echo show_zero_if_empty($data["over"]["total_risks"]);?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data["over"]["total_premium"],$data["over"]["policies"]),0));?></td>
    <td align="center"><? echo show_zero_if_empty(round(devide_2_numbers($data["over"]["total_premium"],$data["over"]["total_risks"]),0));?></td>
    </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_premium"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["policies"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty($data["totals"]["total_risks"]);?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty(round(devide_2_numbers($data["totals"]["total_premium"],$data["totals"]["policies"]),0));?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><? echo show_zero_if_empty(round(devide_2_numbers($data["totals"]["total_premium"],$data["totals"]["total_risks"]),0));?></strong></td>
    </tr>
</table>
</div>
<? } ?>
<?
$db->show_footer();
?>
