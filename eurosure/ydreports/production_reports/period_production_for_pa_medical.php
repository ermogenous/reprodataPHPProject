<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();



if ($_POST["year"] == "")
	$_POST["year"] = date("Y");
if ($_POST["period_start"] == "")
	$_POST["period_start"] = date("m");
if ($_POST["period_end"] == "")
	$_POST["period_end"] = date("m");


if ($_POST["action"] == 'submit') {
	
$sql = "SELECT 
(".$_POST["year"].") as clo_year
,(".$_POST["period_end"].") as clo_period

,inpol_policy_number
,inag_agent_code
,(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium

//find the PA Package 
,IF inity_insurance_type = '1001' THEN (SELECT MAX(inpst_package_code) FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial) 
ELSE (SELECT IF MAX(inpst_packing_description) = 'I' THEN 'Individual' ELSE IF MAX(inpst_packing_description) = 'G' THEN 'GROUP' ELSE MAX(inpst_packing_description) ENDIF ENDIF FROM inpolicysituations WHERE inpst_policy_serial = inpol_policy_serial) 
ENDIF as clo_package
INTO #temp
FROM ininsurancetypes
JOIN inpolicies ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN inpolicyendorsement ON inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial
JOIN inagents ON inpolicies.inpol_agent_serial = inagents.inag_agent_serial

WHERE 
inpolicyendorsement.inped_status = '1'

AND inped_year*100+inped_period >= (".$_POST["year"]."*100+".$_POST["period_start"].") 
AND inped_year*100+inped_period <= (".$_POST["year"]."*100+".$_POST["period_end"].")
AND inped_year = ".$_POST["year"]." 
AND inity_insurance_type = '".$_POST["insurance_type"]."'

GROUP BY
inag_agent_code
,inpol_policy_number
,inpol_policy_serial
,inity_insurance_type

ORDER BY  
inag_agent_code ASC
,clo_package
,inpol_policy_number ASC

SELECT
inag_agent_code as Agent
,inpol_policy_number as Policy_Number
,SUM(clo_ytd_premium) as Premium
,clo_package as Package

FROM 
#temp
GROUP BY 
Agent
,Policy_Number
,Package

ORDER BY 
Agent
,Package
,Policy_Number
";
//echo $sql."<hr>";

//$result = $sybase->query($sql);

}

$db->show_header();
?>
<form name="form1" method="post" action="">
  <table width="540" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">Period Production Report For PA &amp; Medical With Package</td>
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
      <td>Insurance Type</td>
      <td><select name="insurance_type" id="insurance_type">
        <option value="1001" <? if ($_POST["insurance_type"] == '1001') echo "selected=\"selected\"";?>>1001</option>
        <option value="1101" <? if ($_POST["insurance_type"] == '1101') echo "selected=\"selected\"";?>>1101</option>
      </select></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?

if ($_POST["action"] == "submit") {
?>
<div id="print_view_section_html" align="center">
<?
	echo export_data_html_table($sql,'sybase');
?>
</div>
<?		
}

//=============================================================================================================
$db->show_footer();
?>
