<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();

$start_year = 2006;
$end_year = date("Y");


$month_names[1] = "January";
$month_names[2] = "February";
$month_names[3] = "March";
$month_names[4] = "April";
$month_names[5] = "May";
$month_names[6] = "June";
$month_names[7] = "July";
$month_names[8] = "August";
$month_names[9] = "September";
$month_names[10] = "October";
$month_names[11] = "Noveber";
$month_names[12] = "December";

//initialize years
if ($_GET["year1"] == "") {
	$_GET["year1"] = date("Y");
}
if ($_GET["year2"] == "") {
	$_GET["year2"] = date("Y") -1; 
}
//get data
if ($_GET["action"] == "show") {

	

}//show data



if ($_GET["layout_action"] != "printer") {
?>
<style type="text/css">
<!--
.main_text {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
	text-decoration: none;
}
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form name="form1" method="GET" action="">
      Agent:
      <select name="agent" id="agent">
        <?
$sql = "SELECT * FROM inagents WHERE inag_agent_type = 'A' ORDER BY inag_agent_code ASC";
$res = $sybase->query($sql);
while ($row = $sybase->fetch_assoc($res)) {

	$all_agents[$row["inag_agent_code"]] = $row["inag_long_description"];
?>
        <option value="<? echo $row["inag_agent_serial"];?>" <? if ($_GET["agent"] == $row["inag_agent_serial"]) echo "selected=\"selected\"";?>><? echo $row["inag_agent_code"]." - ".$row["inag_long_description"];?></option>
        <? }//while agents ?>
      </select>
&nbsp;&nbsp;Year 1
<select name="year1" id="year1">
<? for ($i = $start_year; $i<= $end_year; $i++) { ?>
  <option value="<? echo $i;?>" <? if ($i == $_GET["year1"]) echo "selected=\"selected\"";?>><? echo $i;?></option>
<? } ?>
</select>
&nbsp;&nbsp;&nbsp;Year 2
<select name="year2" id="year2">
  <option value="0" <? if ($i == $_GET["year2"]) echo "selected=\"selected\"";?>>None</option>
<? for ($i = $start_year; $i<= $end_year; $i++) { ?>
  <option value="<? echo $i;?>" <? if ($i == $_GET["year2"]) echo "selected=\"selected\"";?>><? echo $i;?></option>
<? } ?>
</select>
&nbsp;&nbsp;&nbsp;Year 3
<select name="year3" id="year3">
  <option value="0">None</option>
<? for ($i = $start_year; $i<= $end_year; $i++) { ?>
  <option value="<? echo $i;?>" <? if ($i == $_GET["year3"]) echo "selected=\"selected\"";?>><? echo $i;?></option>
<? } ?>
</select>
&nbsp;<br />
Months:
<select name="month1" id="month1">
  <option value="1" <?php if (!(strcmp(1, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>January</option>
  <option value="2" <?php if (!(strcmp(2, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>February</option>
  <option value="3" <?php if (!(strcmp(3, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>March</option>
  <option value="4" <?php if (!(strcmp(4, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>April</option>
  <option value="5" <?php if (!(strcmp(5, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>May</option>
  <option value="6" <?php if (!(strcmp(6, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>June</option>
  <option value="7" <?php if (!(strcmp(7, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>July</option>
  <option value="8" <?php if (!(strcmp(8, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>August</option>
  <option value="9" <?php if (!(strcmp(9, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>September</option>
  <option value="10" <?php if (!(strcmp(10, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>October</option>
  <option value="11" <?php if (!(strcmp(11, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>Noveber</option>
  <option value="12" <?php if (!(strcmp(12, $_GET["month1"]))) {echo "selected=\"selected\"";} ?>>December</option>
</select> 
-
<select name="month2" id="month2">
  <option value="1" <?php if (!(strcmp(1, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>January</option>
  <option value="2" <?php if (!(strcmp(2, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>February</option>
  <option value="3" <?php if (!(strcmp(3, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>March</option>
  <option value="4" <?php if (!(strcmp(4, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>April</option>
  <option value="5" <?php if (!(strcmp(5, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>May</option>
  <option value="6" <?php if (!(strcmp(6, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>June</option>
  <option value="7" <?php if (!(strcmp(7, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>July</option>
  <option value="8" <?php if (!(strcmp(8, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>August</option>
  <option value="9" <?php if (!(strcmp(9, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>September</option>
  <option value="10" <?php if (!(strcmp(10, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>October</option>
  <option value="11" <?php if (!(strcmp(11, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>Noveber</option>
  <option value="12" <?php if (!(strcmp(12, $_GET["month2"]))) {echo "selected=\"selected\"";} ?>>December</option>
</select> 
&nbsp; Group Months
<input name="group" type="checkbox" id="group" value="1" <? if ($_GET["group"] == 1) echo "checked=\"checked\"";?> />
<input type="submit" name="Submit" value="Show">
<input name="action" type="hidden" id="action" value="show">

            </form>    </td>
  </tr>
  <tr>
    <td align="center"><hr></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<? } ?>




<?

function show_report() {
global $db,$month_names,$sybase;

if ($_GET["agent"] != "") {
$i=0;
for ($mon = $_GET["month1"] ; $mon <= $_GET["month2"]; $mon++) {
$i++;
//information section
if ($_GET["action"] == "show") {

//fix as at date
if ($_GET["month2"] == 1 || $_GET["month2"] == 3 || $_GET["month2"] == 5 || $_GET["month2"] == 7 || $_GET["month2"] == 8 || $_GET["month2"] == 10 || $_GET["month2"] == 12) {
	$asat1 = "31/".$_GET["month2"]."/".$_GET["year1"];
	$asat2 = "31/".$_GET["month2"]."/".$_GET["year2"];
	$asat3 = "31/".$_GET["month2"]."/".$_GET["year3"];
}
else if ($_GET["month2"] == 2 ) {
	$asat1 = "28/".$_GET["month2"]."/".$_GET["year1"];
	$asat2 = "28/".$_GET["month2"]."/".$_GET["year2"];
	$asat3 = "28/".$_GET["month2"]."/".$_GET["year3"];

	if (date("L",mktime(0,0,1,1,1,$_GET["year1"]))) {
		$asat1 = "29/".$_GET["month2"]."/".$_GET["year1"];
	}
	if (date("L",mktime(0,0,1,1,1,$_GET["year2"]))) {
		$asat2 = "29/".$_GET["month2"]."/".$_GET["year2"];
	}
	if (date("L",mktime(0,0,1,1,1,$_GET["year3"]))) {
		$asat3 = "29/".$_GET["month2"]."/".$_GET["year3"];
	}
	
}
else {
	$asat1 = "30/".$_GET["month2"]."/".$_GET["year1"];
	$asat2 = "30/".$_GET["month2"]."/".$_GET["year2"];
	$asat3 = "30/".$_GET["month2"]."/".$_GET["year3"];

}

//get the agent details
$sb_result = $sybase->query("SELECT * FROM inagents WHERE inag_agent_serial = ".$_GET["agent"]);
$agent = $sybase->fetch_assoc($sb_result);


	$sql = "SELECT * FROM `ap_comission` WHERE (`agent_code` = '".$agent["inag_agent_code"]."' OR `agent_code` = '".$agent["inag_numeric_key1"]."') AND `month` = ".$mon." AND (`year` = ".$_GET["year1"]." OR `year` = ".$_GET["year2"]." OR `year` = ".$_GET["year3"].")";
	$result = $db->query($sql);
	while ($row = $db->fetch_assoc($result)) {
		
		//when group months
		if ($_GET["group"] == 1) {
			$month = 'all';
			$data[$row["klados"]][$row["year"]][$month]["production"] += round($row["production"],0);
			if (substr($row["agent_code"],4,1) == '.'){
				$data[$row["klados"]][$row["year"]][$month]["comission"] += (round($row["comission"],0)) * -1;
			}
			else {
				$data[$row["klados"]][$row["year"]][$month]["comission"] += round($row["comission"],0);
			}
	
		}//when group
		else {
 			
			
			$month = $mon;
			$data[$row["klados"]][$row["year"]][$month]["production"] += round($row["production"],0);
			if (substr($row["agent_code"],3,1) == '.'){
				$data[$row["klados"]][$row["year"]][$month]["comission"] += (round($row["comission"],0)) * -1;
			}
			else {
				$data[$row["klados"]][$row["year"]][$month]["comission"] += round($row["comission"],0);
			}
		
		}//WHEN not GROUP

	}//WHILE production and comission
	
	$sql2 = "SELECT SUM(ekremis) AS `ekremis` , SUM(pliromes) AS `pliromes` , agent_ID , klados, month,year FROM `ap_claims` WHERE (`agent_ID` = '".$agent["inag_numeric_key1"]."' OR `agent_ID` = '".$agent["inag_agent_code"]."') AND `month` = ".$mon." AND (`year` = ".$_GET["year1"]." OR `year` = ".$_GET["year2"]." OR `year` = ".$_GET["year3"].") GROUP BY klados,year,month";
//echo $sql2."<HR>";
	$result2 = $db->query($sql2);
	while ($claim = $db->fetch_assoc($result2)) {

		$data[$claim["klados"]][$claim["year"]][$month]["pliromes"] = round($claim["pliromes"],0);
		$data[$claim["klados"]][$claim["year"]][$month]["ekremis"] = round($claim["ekremis"],0); 

	}

//SYNTHESIS DATA ====== SYNTHESIS DATA ====== SYNTHESIS DATA ====== SYNTHESIS DATA ====== SYNTHESIS DATA ====== SYNTHESIS DATA ====== SYNTHESIS DATA ====== 
//INRP09/06
$sqlpart = "SELECT  
LEFT(inpol_policy_number,4)as clo_product,
LEFT(inpol_policy_number,2)as clo_general_product,
inagents.inag_agent_code ,           
inagents.inag_long_description ,           
ingeneralagents.inga_agent_code ,           
ingeneralagents.inga_long_description ,           
         
IF inped_endorsement_serial = inpol_last_cancellation_endorsement_serial THEN IF inpol_status = 'A' AND inpol_replaced_by_policy_serial = 0 AND inpol_cancellation_date IS NOT NULL THEN 'C' ELSE 'L' ENDIF ELSE inpol_process_status ENDIF as clo_process_status,           
COALESCE((SELECT SUM(intrd_value * intrd_debit_credit)  * -1 FROM intransactiondetails WHERE intrd_policy_serial = inpol_policy_serial AND (intrd_endorsement_serial = IF clo_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF clo_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF) AND intrd_claim_serial = 0 AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_related_type = IF inga_branch_agent = 'B' THEN 'A' ELSE 'G' ENDIF), 0) As clo_commission_charge,           
IF clo_process_status = 'E' THEN COALESCE((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails, inpolicies a WHERE a.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND intrd_policy_serial = a.inpol_policy_serial AND intrd_endorsement_serial = a.inpol_last_cancellation_endorsement_serial AND intrd_claim_serial = 0 AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_related_type = IF inga_branch_agent = 'B' THEN 'A' ELSE 'G' ENDIF), 0) ELSE 0 ENDIF As clo_commission_reduction,           
clo_commission_charge - clo_commission_reduction As clo_commission_net,           
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpparam, inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial WHERE UPPER(inpr_module_code) = 'IN' AND oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND inpr_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND inpr_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_endorsement,
((inped_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN IF inpol_status IN ('C','O') THEN clo_refund_outstanding_endorsement ELSE COALESCE((SELECT ((a.inped_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ENDIF ELSE 0 ENDIF as clo_premium

FROM  inpolicies  LEFT OUTER JOIN intemplates  ON inpolicies.inpol_template_serial = intemplates.intmpl_template_serial ,           
inclients ,           
inagents ,           
inpolicyendorsement ,          
ininsurancetypes ,           
ingeneralagents    
WHERE ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial ) 
and          ((inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_endorsement_serial) or           (inpolicyendorsement.inped_endorsement_serial = inpolicies.inpol_last_cancellation_endorsement_serial 
and          (   inpolicies.inpol_replaced_by_policy_serial = 0)) /* CANCELLATION OR LAPSED */ )    
AND LEFT(clo_process_status, 1) IN ('N','R','E','D','C','L') 
AND inpol_status IN ('A','N')
";

for ($i=1;$i<4;$i++) {

	$sql = $sqlpart . "AND (inped_year*100+inped_period)>=(".$_GET["year".$i]."*100+".$mon.") 
AND (inped_year*100+inped_period)<=(".$_GET["year".$i]."*100+".$mon.") 
AND inag_agent_code = '".$agent["inag_agent_code"]."'";

	if ($_GET["year".$i] > 2000) {
		
		$sbres = $sybase->query($sql);
		
		while ($sbrow = $sybase->fetch_assoc($sbres)) {
			
			//$data[$sbrow["clo_general_product"]][$_GET["year".$i]][$month]["production"] += $sbrow["clo_premium"];
			$data[$sbrow["clo_general_product"]][$_GET["year".$i]][$month]["comission"] += $sbrow["clo_commission_net"];
			$tot += $sbrow["clo_premium"];
			
		}//while
		//echo $sql."<hr>";
		echo $tot."<hr>";
		$tot = 0;

	}//if year > 2000

}//for $i=1  to 3


echo $mon;	
//print_r($data);
	//totals production and comission
	$data["all"][$_GET["year1"]][$month]["production"] += $data[10][$_GET["year1"]][$month]["production"] + $data[16][$_GET["year1"]][$month]["production"] + $data[17][$_GET["year1"]][$month]["production"] + $data[19][$_GET["year1"]][$month]["production"] + $data[21][$_GET["year1"]][$month]["production"] + $data[22][$_GET["year1"]][$month]["production"] ;

	$data["all"][$_GET["year1"]][$month]["comission"] += $data[10][$_GET["year1"]][$month]["comission"] + $data[16][$_GET["year1"]][$month]["comission"] + $data[17][$_GET["year1"]][$month]["comission"] + $data[19][$_GET["year1"]][$month]["comission"] + $data[21][$_GET["year1"]][$month]["comission"] + $data[22][$_GET["year1"]][$month]["comission"];
	
	$data["all"][$_GET["year2"]][$month]["production"] += $data[10][$_GET["year2"]][$month]["production"] + $data[16][$_GET["year2"]][$month]["production"] + $data[17][$_GET["year2"]][$month]["production"] + $data[19][$_GET["year2"]][$month]["production"] + $data[21][$_GET["year2"]][$month]["production"] + $data[22][$_GET["year2"]][$month]["production"] ;

	$data["all"][$_GET["year2"]][$month]["comission"] += $data[10][$_GET["year2"]][$month]["comission"] + $data[16][$_GET["year2"]][$month]["comission"] + $data[17][$_GET["year2"]][$month]["comission"] + $data[19][$_GET["year2"]][$month]["comission"] + $data[21][$_GET["year2"]][$month]["comission"] + $data[22][$_GET["year2"]][$month]["comission"];
	
	$data["all"][$_GET["year3"]][$month]["production"] += $data[10][$_GET["year3"]][$month]["production"] + $data[16][$_GET["year3"]][$month]["production"] + $data[17][$_GET["year3"]][$month]["production"] + $data[19][$_GET["year3"]][$month]["production"] + $data[21][$_GET["year3"]][$month]["production"] + $data[22][$_GET["year3"]][$month]["production"] ;

	$data["all"][$_GET["year3"]][$month]["comission"] += $data[10][$_GET["year3"]][$month]["comission"] + $data[16][$_GET["year3"]][$month]["comission"] + $data[17][$_GET["year3"]][$month]["comission"] + $data[19][$_GET["year3"]][$month]["comission"] + $data[21][$_GET["year3"]][$month]["comission"] + $data[22][$_GET["year3"]][$month]["comission"];
	
	//totals claims
	$data["all"][$_GET["year1"]][$month]["pliromes"] += $data[10][$_GET["year1"]][$month]["pliromes"] + $data[16][$_GET["year1"]][$month]["pliromes"] + $data[17][$_GET["year1"]][$month]["pliromes"] + $data[19][$_GET["year1"]][$month]["pliromes"] + $data[21][$_GET["year1"]][$month]["pliromes"] + $data[22][$_GET["year1"]][$month]["pliromes"] ;

	$data["all"][$_GET["year1"]][$month]["ekremis"] += $data[10][$_GET["year1"]][$month]["ekremis"] + $data[16][$_GET["year1"]][$month]["ekremis"] + $data[17][$_GET["year1"]][$month]["ekremis"] + $data[19][$_GET["year1"]][$month]["ekremis"] + $data[21][$_GET["year1"]][$month]["ekremis"] + $data[22][$_GET["year1"]][$month]["ekremis"] ;

	$data["all"][$_GET["year2"]][$month]["pliromes"] += $data[10][$_GET["year2"]][$month]["pliromes"] + $data[16][$_GET["year2"]][$month]["pliromes"] + $data[17][$_GET["year2"]][$month]["pliromes"] + $data[19][$_GET["year2"]][$month]["pliromes"] + $data[21][$_GET["year2"]][$month]["pliromes"] + $data[22][$_GET["year2"]][$month]["pliromes"] ;

	$data["all"][$_GET["year2"]][$month]["ekremis"] += $data[10][$_GET["year2"]][$month]["ekremis"] + $data[16][$_GET["year2"]][$month]["ekremis"] + $data[17][$_GET["year2"]][$month]["ekremis"] + $data[19][$_GET["year2"]][$month]["ekremis"] + $data[21][$_GET["year2"]][$month]["ekremis"] + $data[22][$_GET["year2"]][$month]["ekremis"] ;

	$data["all"][$_GET["year3"]][$month]["pliromes"] += $data[10][$_GET["year3"]][$month]["pliromes"] + $data[16][$_GET["year3"]][$month]["pliromes"] + $data[17][$_GET["year3"]][$month]["pliromes"] + $data[19][$_GET["year3"]][$month]["pliromes"] + $data[21][$_GET["year3"]][$month]["pliromes"] + $data[22][$_GET["year3"]][$month]["pliromes"] ;

	$data["all"][$_GET["year3"]][$month]["ekremis"] += $data[10][$_GET["year3"]][$month]["ekremis"] + $data[16][$_GET["year3"]][$month]["ekremis"] + $data[17][$_GET["year3"]][$month]["ekremis"] + $data[19][$_GET["year3"]][$month]["ekremis"] + $data[21][$_GET["year3"]][$month]["ekremis"] + $data[22][$_GET["year3"]][$month]["ekremis"] ;
	
	
	
//print_r($data);




}//action->show 10

//agent data
$agent = $sybase->query_fetch("SELECT * FROM inagents WHERE inag_agent_serial = ".$_GET["agent"]);


$not = 0;
if ($_GET["group"] == 1) {
	$not = 1;
	if ($mon == $_GET["month2"]) {
		$not = 2;
	}
}

if ($not == 0 || $not == 2) {
//if group do not show all the months but only the last one
?>
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20">&nbsp;</td>
    <td align="right"><table width="698" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="main_text" style="border:solid #0000FF 1px">
      <tr>
        <td height="30" colspan="11" align="center"><strong>Agent : <? echo $agent["inag_agent_code"]." - ".$agent["inag_long_description"];?> For
          <? if ($_GET["group"] == 1){ echo $month_names[$_GET["month1"]]." TO ".$month_names[$mon]; } else {echo $month_names[$mon];}?>
        </strong></td>
      </tr>
      <tr>
        <td width="106" height="17">&nbsp;</td>
        <td width="1" rowspan="20" align="center" bgcolor="#000000"><img src="../../images/spacer.gif" width="1" height="1" /></td>
        <td colspan="3" align="center" bgcolor="#FFFFBB"><strong>Year <? echo $_GET["year1"];?> </strong></td>
        <td colspan="3" align="center" bgcolor="#BFFFBF"><strong>Year <? echo $_GET["year2"];?> </strong></td>
        <td colspan="3" align="center" bgcolor="#BBC9FF"><p><strong>Year <? echo $_GET["year3"];?> </strong></p></td>
      </tr>
      <tr>
        <td height="17">&nbsp;</td>
        <td align="center" bgcolor="#FFFFCC"><strong>Premium</strong></td>
        <td width="63" align="center" bgcolor="#FFFFB0"><strong>Εκκρ.</strong></td>
        <td width="63" align="center" bgcolor="#FFFF93"><strong>Πλήρ.</strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong>Premium</strong></td>
        <td width="63" align="center" bgcolor="#A8FFA8"><strong>Εκκρ.</strong></td>
        <td width="63" align="center" bgcolor="#95FF95"><strong>Πλήρ.</strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong>Premium</strong></td>
        <td width="63" align="center" bgcolor="#9F9FFF"><strong>Εκκρ.</strong></td>
        <td width="63" align="center" bgcolor="#8A8AFF"><strong>Πλήρ.</strong></td>
      </tr>
      <tr>
        <td height="17"><strong>10 Accident </strong></td>
        <td width="63" align="center" bgcolor="#FFFFCC"><strong><? echo $data[10][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td width="63" align="center" bgcolor="#CEFFCE"><strong><? echo $data[10][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td width="63" align="center" bgcolor="#C1C1FF"><strong><? echo $data[10][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Comission</td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[10][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[10][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[10][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Claims Incurred </td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[10][$_GET["year1"]][$month]["ekremis"] + $data[10][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[10][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[10][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[10][$_GET["year2"]][$month]["ekremis"] + $data[10][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[10][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[10][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[10][$_GET["year3"]][$month]["ekremis"] + $data[10][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[10][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[10][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
      <tr>
        <td height="17"><strong>16 Marine </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[16][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[16][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[16][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Comission</td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[16][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[16][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[16][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Claims Incurred </td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[16][$_GET["year1"]][$month]["ekremis"] + $data[16][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[16][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[16][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[16][$_GET["year2"]][$month]["ekremis"] + $data[16][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[16][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[16][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[16][$_GET["year3"]][$month]["ekremis"] + $data[16][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[16][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[16][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
      <tr>
        <td height="17"><strong>17 Fire </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[17][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[17][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[17][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Comission</td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[17][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[17][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[17][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Claims Incurred </td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[17][$_GET["year1"]][$month]["ekremis"] + $data[17][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[17][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[17][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[17][$_GET["year2"]][$month]["ekremis"] + $data[17][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[17][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[17][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[17][$_GET["year3"]][$month]["ekremis"] + $data[17][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[17][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[17][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
      <tr>
        <td height="17"><strong>19 Motor </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[19][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[19][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[19][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Comission</td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[19][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[19][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[19][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Claims Incurred </td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[19][$_GET["year1"]][$month]["ekremis"] + $data[19][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[19][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[19][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[19][$_GET["year2"]][$month]["ekremis"] + $data[19][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[19][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[19][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[19][$_GET["year3"]][$month]["ekremis"] + $data[19][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[19][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[19][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
      <tr>
        <td height="17"><strong>21 Yacht </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[21][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[21][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[21][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Comission</td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[21][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[21][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[21][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Claims Incurred </td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[21][$_GET["year1"]][$month]["ekremis"] + $data[21][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[21][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[21][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[21][$_GET["year2"]][$month]["ekremis"] + $data[21][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[21][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[21][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[21][$_GET["year3"]][$month]["ekremis"] + $data[21][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[21][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[21][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
      <tr>
        <td height="17"><strong>22 Liability </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[22][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[22][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp; </td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[22][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Comission</td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[22][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[22][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[22][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left">&nbsp;&nbsp;Claims Incurred </td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data[22][$_GET["year1"]][$month]["ekremis"] + $data[22][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[22][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[22][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data[22][$_GET["year2"]][$month]["ekremis"] + $data[22][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[22][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[22][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data[22][$_GET["year3"]][$month]["ekremis"] + $data[22][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data[22][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data[22][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
      <tr>
        <td height="2" colspan="11" align="left" bgcolor="#000000"><img src="../../images/spacer.gif" width="1" height="1" /></td>
      </tr>
      <tr>
        <td height="17" align="left"><strong>Total Premium </strong></td>
        <td width="1" rowspan="3" align="center" bgcolor="#000000"><img src="../../images/spacer.gif" width="1" height="1" /></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data["all"][$_GET["year1"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data["all"][$_GET["year2"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data["all"][$_GET["year3"]][$month]["production"];?></strong></td>
        <td colspan="2" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="17" align="left"><strong>Total Comission </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data["all"][$_GET["year1"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data["all"][$_GET["year2"]][$month]["comission"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data["all"][$_GET["year3"]][$month]["comission"];?></strong></td>
      </tr>
      <tr>
        <td height="17" align="left"><strong>Claims Incured </strong></td>
        <td align="center" bgcolor="#FFFFCC"><strong><? echo $data["all"][$_GET["year1"]][$month]["ekremis"] + $data["all"][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data["all"][$_GET["year1"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data["all"][$_GET["year1"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#CEFFCE"><strong><? echo $data["all"][$_GET["year2"]][$month]["ekremis"] + $data["all"][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data["all"][$_GET["year2"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data["all"][$_GET["year2"]][$month]["pliromes"];?></strong></td>
        <td align="center" bgcolor="#C1C1FF"><strong><? echo $data["all"][$_GET["year3"]][$month]["ekremis"] + $data["all"][$_GET["year3"]][$month]["pliromes"];?></strong></td>
        <td align="center"><strong><? echo $data["all"][$_GET["year3"]][$month]["ekremis"];?></strong></td>
        <td align="center"><strong><? echo $data["all"][$_GET["year3"]][$month]["pliromes"];?></strong></td>
      </tr>
    </table></td>
  </tr>
</table>
<style type="text/css">
HR {
page-break-after: always;
}
</style>
<br />

<?
}//if group

if ($i%2 ==0 && $_GET["group"] != 1) { 
	echo "<HR color=\"#FFFFFF\" width=\"1\" align=\"center\" noshade=\"noshade\">";
	}//if $i%2
}//months
}//if form is submited
}//function
show_report();
if ($_GET["group"] != 1 && $_GET["month1"] != $_GET["month2"]) {
	$_GET["group"] = 1;
	unset($data);
	//show_report();

}
$db->show_footer();
?>