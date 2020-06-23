<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../functions/production.php");
$sybase = new Sybase();



if ($_POST["year"] == "")
	$_POST["year"] = date("Y");
if ($_POST["period_start"] == "")
	$_POST["period_start"] = date("m");
if ($_POST["period_end"] == "")
	$_POST["period_end"] = date("m");


if ($_POST["action"] == 'submit') {
	
$sort_1 = ", ' ' ";
$sort_2 = ", ' ' ";
$sort_3 = ", ' ' ";

for ($i=1;$i<=3;$i++) {
	$sort = 'sort_'.$i;
	$where_sort = 'where_sort_'.$i;
	if ($_POST["sort_".$i] != "NONE") {
		$$sort = ",".$_POST["sort_".$i];
	
		if ($_POST["sort_".$i] === "") {}
		else {
			$$where_sort = "AND clo_sort_".$i." >= '".$_POST["sort_from_".$i]."' ";
		}
		if ($_POST["sort_".$i] == "") {}
		else {
			$$where_sort .= "AND clo_sort_".$i." <= '".$_POST["sort_to_".$i]."'";
		}
	
	}

}


$sql = "SELECT 
(".$_POST["year"].") as clo_year,           
(".$_POST["period_end"].") as clo_period

".$sort_1." as clo_sort_1
".$sort_2." as clo_sort_2
".$sort_3." as clo_sort_3

,inpparam.inpr_module_code ,
(-1 * sum (IF clo_year = inped_year AND clo_period = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(IF clo_year -1 = inped_year AND clo_period = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_last_period_premium,
(-1 * sum(IF clo_year -1 = inped_year AND inped_period  <= clo_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_last_ytd_premium


FROM ininsurancetypes  LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code
LEFT OUTER JOIN inminorcodes  ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,           
inpolicyendorsement ,           
inagents ,           
ingeneralagents ,           
inpparam    

WHERE ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial ) 
AND          ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
AND          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
AND          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
AND          ( ( inpolicyendorsement.inped_status = '1' ) 
AND          ( inpparam.inpr_module_code = 'IN' ) ) 

AND (((inped_year*100+inped_period) >= (".$_POST["year"]."*100+".$_POST["period_start"].") 
AND (inped_year*100+inped_period) <= (".$_POST["year"]."*100+".$_POST["period_end"].")
AND (inped_year = ".$_POST["year"].")) OR ((inped_year*100+inped_period) >= (".($_POST["year"]-1)."*100+".$_POST["period_start"].") 
AND (inped_year*100+inped_period) <= (".($_POST["year"]-1)."*100+".$_POST["period_end"].") 
AND (inped_year = ".($_POST["year"]-1)."))) 

".$where_sort_1."
".$where_sort_2."
".$where_sort_3."

GROUP BY 
inpparam.inpr_module_code
,clo_sort_1
,clo_sort_2
,clo_sort_3

ORDER BY  
inpparam.inpr_module_code
,clo_sort_1
,clo_sort_2
,clo_sort_3

";
echo $sql."<hr>";
$output = sql_clo_sort('sybase',$sql,'clo_sort_1','clo_sort_2','clo_sort_3');
//$result = $sybase->query($sql);

}

$db->show_header();
?>
<form name="form1" method="post" action="">
  <table width="540" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">Period Production Report </td>
    </tr>
    <tr>
      <td width="163">Year</td>
      <td width="377"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
    </tr>
    <tr>
      <td>Period</td>
      <td><input name="period_start" type="text" id="period_start" size="5" maxlength="2" value="<? echo $_POST["period_start"];?>">
        UpTo
        <input name="period_end" type="text" id="period_end" size="5" maxlength="2" value="<? echo $_POST["period_end"];?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><strong>Sort By</strong></td>
    </tr>
    <tr>
      <td>1: 
        <select name="sort_1" id="sort_1">
          <option value="NONE" <? if ($_POST["sort_1"] == 'NONE') echo "selected=\"selected\"";?>>NONE</option>
        <option value="inag_agent_code" <? if ($_POST["sort_1"] == 'inag_agent_code') echo "selected=\"selected\"";?>>Agents Code</option>
        <option value="inity_insurance_type" <? if ($_POST["sort_1"] == 'inity_insurance_type') echo "selected=\"selected\"";?>>Insurance Type</option>
        <option value="inity_major_category" <? if ($_POST["sort_1"] == 'inity_major_category') echo "selected=\"selected\"";?>>Major</option>
      </select></td>
      <td><input type="text" name="sort_from_1" id="sort_from_1" value="<? echo $_POST["sort_from_1"];?>" />
      <input type="text" name="sort_to_1" id="sort_to_1" value="<? echo $_POST["sort_to_1"];?>" /></td>
    </tr>
    <tr>
      <td>2: 
        <select name="sort_2" id="sort_2">
          <option value="NONE" <? if ($_POST["sort_2"] == 'NONE') echo "selected=\"selected\"";?>>NONE</option>
          <option value="inag_agent_code" <? if ($_POST["sort_2"] == 'inag_agent_code') echo "selected=\"selected\"";?>>Agents Code</option>
          <option value="inity_insurance_type" <? if ($_POST["sort_2"] == 'inity_insurance_type') echo "selected=\"selected\"";?>>Insurance Type</option>
          <option value="inity_major_category" <? if ($_POST["sort_2"] == 'inity_major_category') echo "selected=\"selected\"";?>>Major</option>
        </select></td>
      <td><input type="text" name="sort_from_2" id="sort_from_2" value="<? echo $_POST["sort_from_2"];?>" />
      <input type="text" name="sort_to_2" id="sort_to_2" value="<? echo $_POST["sort_to_2"];?>" /></td>
    </tr>
    <tr>
      <td>3: 
        <select name="sort_3" id="sort_3">
          <option value="NONE" <? if ($_POST["sort_3"] == 'NONE') echo "selected=\"selected\"";?>>NONE</option>
          <option value="inag_agent_code" <? if ($_POST["sort_3"] == 'inag_agent_code') echo "selected=\"selected\"";?>>Agents Code</option>
          <option value="inity_insurance_type" <? if ($_POST["sort_3"] == 'inity_insurance_type') echo "selected=\"selected\"";?>>Insurance Type</option>
          <option value="inity_major_category" <? if ($_POST["sort_3"] == 'inity_major_category') echo "selected=\"selected\"";?>>Major</option>
        </select></td>
      <td><input type="text" name="sort_from_3" id="sort_from_3" value="<? echo $_POST["sort_from_3"];?>" />
      <input type="text" name="sort_to_3" id="sort_to_3" value="<? echo $_POST["sort_to_3"];?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<?
//=============================================================================================================

if ($_POST["action"] == "submit") {


while ($row = $sybase->fetch_assoc($result)) {

	//get the data into the array
	$data[$row["inag_agent_code"]]["old_code"] = $row["inag_numeric_key1"];
	$data[$row["inag_agent_code"]]["premium_synthesis"] = $row["clo_period_premium"];

}//while results	
?>
<br><br>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="125"><strong>Agent Code</strong></td>
    <td width="125"><strong>Old Code</strong></td>
    <td width="100" align="center"><strong>Cymenu</strong></td>
    <td width="100" align="center"><strong>Synthesis</strong></td>
    <td width="100" align="center"><strong>Total</strong></td>
  </tr>
<?
$sql = "SELECT * FROM inagents WHERE inag_agent_type = 'A' ORDER BY inag_agent_code ASC";
$res = $sybase->query($sql);
while ($ag = $sybase->fetch_assoc($res)) {

	$sql = "SELECT SUM(`aaf_premium`)as total FROM `ap_asci_full` WHERE `aaf_agent` = ".$ag["inag_numeric_key1"]." AND `aaf_month` >= ".$_POST["period_start"]." AND `aaf_month` <= ".$_POST["period_end"]." AND `aaf_year` = ".$_POST["year"];
	$cymenu = $db->query_fetch($sql);
	$data[$ag["inag_agent_code"]]["premium_cymenu"] = round($cymenu["total"],2);

$tot_cymenu += $data[$ag["inag_agent_code"]]["premium_cymenu"];
$tot_synthesis += $data[$ag["inag_agent_code"]]["premium_synthesis"];

?>
  <tr>
    <td><? echo $ag["inag_agent_code"];?></td>
    <td><? echo $ag["inag_numeric_key1"];?></td>
	<td align="center"><? echo $data[$ag["inag_agent_code"]]["premium_cymenu"]; ?></td>
    <td align="center"><? echo $data[$ag["inag_agent_code"]]["premium_synthesis"]; ?></td>
    <td align="center"><? echo $data[$ag["inag_agent_code"]]["premium_cymenu"] + $data[$ag["inag_agent_code"]]["premium_synthesis"];; ?></td>
  </tr>
<? } ?>
  <tr>
    <td colspan="2"><strong>Totals For Year:<? echo $_POST["year"];?> Period:<? echo $_POST["period_start"]."/".$_POST["period_end"];?></strong></td>
    <td align="center"><strong><? echo $tot_cymenu;?></strong></td>
    <td align="center"><strong><? echo $tot_synthesis;?></strong></td>
    <td align="center"><strong><? echo $tot_cymenu + $tot_synthesis;?></strong></td>
  </tr>
</table>


<?
}//if action= submit



$db->show_footer();
?>
