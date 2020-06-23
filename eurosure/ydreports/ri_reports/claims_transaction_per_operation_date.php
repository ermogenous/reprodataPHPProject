<?
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
$sybase = new Sybase();

$db->show_header();


if ($_POST["action"] == "show") {

$sql = "SELECT 
/*
SUM(clo_period_payments) as clo_period_payments_total,
    SUM(clo_payment_estimation_in_period) as clo_payment_estimation_in_period_total,
    SUM(clo_period_recoveries)as clo_period_recoveries_total,
    SUM(clo_recovery_estimation_in_period)as clo_estimation_for_recovery_total,
SUM(clo_payment_estimation_upto_date - clo_payments_upto_date) as clo_outstanding
*/
/*
SUM(clo_period_payments),
SUM(clo_payment_estimation_in_period),
SUM(clo_period_recoveries),
SUM(clo_recovery_estimation_in_period)
*/

inclm_claim_serial,
inclm_claim_number,
inpol_policy_number,
inity_major_category,
clo_account,
incd_reserve_payment_type as clo_cover,
inclm_date_of_event,
inclm_claim_date,
incvsdt_operation_date as clo_pay_reserve_date,
clo_period_payments as clo_payment,
clo_payment_estimation_in_period as clo_reserve,
clo_period_recoveries as clo_recoveries,
clo_recovery_estimation_in_period as clo_recovery_estimation

FROM (SELECT 
        DATE('".$db->convert_date_format($_POST["from_date"],'dd/mm/yyyy','yyyy-mm-dd')."') as clo_from_date,
        DATE('".$db->convert_date_format($_POST["to_date"],'dd/mm/yyyy','yyyy-mm-dd')."') as clo_as_at_date,
        inclm_claim_number,
        inclm_claim_serial,
        incvsdt_operation_date,
        inpol_policy_number,
        inity_major_category,
        RIGHT(LEFT(peril.incd_last_document_number,6),2)as clo_account,
        peril.incd_reserve_payment_type,
        inclm_date_of_event,
        inclm_claim_date,
        /* wORKING FOR EVALUATION OF oUTATNDING RESERVE AS A TOTAL */
        SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date <= clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_payments_upto_date,    
        SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date <= clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_payment_estimation_upto_date,           
        /* iN THE pERIOD */
        SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_payments,           
        SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_recoveries,           
        SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_payment_estimation_in_period,           
        SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_recovery_estimation_in_period,           
        
        'END' as clo_end
        
        FROM inclaims
            JOIN inpolicies ON inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial
            JOIN inclients ON inclients.incl_client_serial = inpolicies.inpol_client_serial
            JOIN ininsurancetypes ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
            JOIN inagents ON inagents.inag_agent_serial = inpolicies.inpol_agent_serial
            JOIN ingeneralagents ON inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial
            JOIN inclaims_asat_date ON inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial
            LEFT OUTER JOIN inpcodes AS peril ON incvsdt_reserve_serial = peril.incd_pcode_serial
        GROUP BY 
        inclm_claim_number,
        inclm_claim_serial,
        incvsdt_operation_date,
        inpol_policy_number,
        inity_major_category,
        peril.incd_last_document_number,
        peril.incd_reserve_payment_type,
        inclm_date_of_event,
        inclm_claim_date
        ORDER BY inclm_claim_number, incvsdt_operation_date) AS DYN_1

WHERE
1=1
AND 
incvsdt_operation_date BETWEEN '".$db->convert_date_format($_POST["from_date"],'dd/mm/yyyy','yyyy-mm-dd')."' AND '".$db->convert_date_format($_POST["to_date"],'dd/mm/yyyy','yyyy-mm-dd')."'

order by
clo_pay_reserve_date ASC, 
inclm_claim_number";

$table = export_data_html_table($sql,'sybase',"border='1' align='center'");

}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Portfolio Analysis Bands For Personal Accident 1001 </strong></td>
    </tr>
    <tr>
      <td width="148">Claim Operation Date</td>
      <td width="501">Between 
        <input name="from_date" type="text" id="from_date" value="<? echo $_POST["from_date"];?>">
        AND 
        <input name="to_date" type="text" id="to_date" value="<? echo $_POST["to_date"];?>" /> 
        dd/mm/yyyy</td>
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

<? echo $table;?>

</div>
<? } ?>
<?
$db->show_footer();
?>
