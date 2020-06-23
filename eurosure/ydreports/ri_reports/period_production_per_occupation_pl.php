<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
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
inity_insurance_type,          
IF inped_endorsement_serial = inpol_last_cancellation_endorsement_serial THEN IF inpol_status = 'A' AND inpol_replaced_by_policy_serial = 0 AND inpol_cancellation_date IS NOT NULL THEN 'C' ELSE 'L' ENDIF ELSE inpol_process_status ENDIF as clo_process_status,
((inped_fees * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_fees * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_fees,           
((inped_stamps * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_stamps * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_stamps,           
((inped_x_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN COALESCE((SELECT ((a.inped_x_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ELSE 0 ENDIF as clo_x_premium,           
COALESCE((SELECT LIST(DISTINCT intrh_document_number) FROM intransactiondetails, intransactionheaders WHERE intrd_policy_serial = inpol_policy_serial AND intrd_endorsement_serial = IF clo_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF clo_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF AND intrd_trh_auto_serial = intrh_auto_serial AND intrd_related_type IN ('A', 'C')), '') As clo_document_number,           
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial JOIN ininsurancetypes ity ON ity.inity_insurance_type_serial = oldpol.inpol_insurance_type_serial WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND ity.inity_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND ity.inity_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_endorsement,
((inped_premium * inped_premium_debit_credit) * -1) + IF clo_process_status = 'E' THEN IF inpol_status IN ('C','O') THEN clo_refund_outstanding_endorsement ELSE COALESCE((SELECT ((a.inped_premium * a.inped_premium_debit_credit) * -1) FROM inpolicyendorsement a, inpolicies b WHERE a.inped_policy_serial = b.inpol_policy_serial AND a.inped_endorsement_serial = b.inpol_last_cancellation_endorsement_serial AND b.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial), 0) ENDIF ELSE 0 ENDIF as clo_premium,

IF clo_process_status = 'E' THEN (SELECT oldpol.inpol_process_status FROM inpolicies oldpol WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial) ELSE '' ENDIF as clo_replacing_policy_pstatus,
-1 * IF clo_process_status = 'E'  AND inpol_status IN ('O', 'C') THEN COALESCE((SELECT SUM(inplg_return_premium) FROM inpolicies oldpol JOIN inpolicyloadings ON oldpol.inpol_policy_serial = inplg_policy_serial JOIN inloadings ON inplg_loading_serial = inldg_loading_serial JOIN ininsurancetypes ity ON ity.inity_insurance_type_serial = oldpol.inpol_insurance_type_serial WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND inldg_loading_type <> 'X' AND inldg_mif_applied <> 'N' AND ((inldg_loading_type = oldpol.inpol_cover) OR (oldpol.inpol_cover = 'B' AND ity.inity_act_in_fire_theft = 'N') OR (oldpol.inpol_cover = 'C' AND ity.inity_act_in_comprehensive = 'N'))), 0) ELSE 0 ENDIF as clo_refund_outstanding_mif_pr_endorsement,

(SELECT SUM(inpia_height/*aoc*/)FROM inpolicyitems JOIN inpolicyitemaux ON inpit_pit_auto_serial = inpia_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_insured_amount,
(SELECT COUNT()  FROM inpolicyitems WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_total_items,
(SELECT incd_long_description FROM inpcodes WHERE incd_pcode_serial = inpolicies.inpol_policy_occupation)as clo_occupation


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
AND inity_insurance_type IN ('2220' ,'2221')


SELECT 

COUNT() as policy_phases_found
,SUM(clo_premium) as total_premium
,inpol_policy_number as Policy_Number
,MAX(clo_insured_amount)as MAX_insured_amount
,MAX(clo_total_items) as total_items
,MAX(clo_occupation) as policy_occupation
FROM #temp
GROUP BY inpol_policy_number

ORDER BY policy_occupation ASC
";
//$result = $sybase->query($sql);
//echo $sql;

$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");



}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands For PI 2220 &amp; 2221 </strong></td>
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
<?
echo $table_data;
?>
</div>
<? 
} 

$db->show_footer();
?>
