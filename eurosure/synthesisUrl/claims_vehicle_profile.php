<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 5/7/2021
 * Time: 5:04 μ.μ.
 */

include("../../include/main.php");
include("../lib/odbccon.php");
include('../../scripts/form_builder_class.php');
$db = new Main();

$sybase = new ODBCCON();

$db->show_empty_header();
FormBuilder::buildPageLoader();

$claimsSerial = $_GET['claimID'];
$vehicle = $_GET['vehicle'];

$sybase->query("INSERT INTO ccuserparameters (ccusp_auto_serial,ccusp_user_date,ccusp_user_identity)
    ON EXISTING UPDATE VALUES(1,'" . date('Y-m-d') . "' ,'INTRANET'); ");

$sql = "
SELECT 
incvsdt_as_at_date,
inclm_date_of_event,
initm_item_code as clo_sort1,
space(060) as clo_sort2,
space(060) as clo_sort3,
TRIM(incl_long_description +' '+ incl_first_name) as clo_desc1,
space(180) as clo_desc2,
space(180) as clo_desc3,
inclaims.inclm_claim_serial ,
inclaims.inclm_claim_number ,
DATE('2000/01/01') as clo_from_date,
DATE('" . date("Y/m/d") . "') as clo_as_at_date,
(SELECT inpr_financial_period
FROM
inpparam
WHERE
UPPER(inpr_module_code) = 'IN') as clo_financial_period,
(SELECT inpr_financial_year
FROM
inpparam
WHERE
UPPER(inpr_module_code) = 'IN') as clo_financial_year,
inclaims.inclm_process_status ,
space(1) as AS_AT_DATE,
space(1) as BF,
space(1) as IN_PERIOD,
inclaims.inclm_open_date ,
IF clo_process_status IN ('C', 'W') THEN YEAR(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_year,
IF clo_process_status IN ('C', 'W') THEN MONTH(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_period,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve_as_at_date,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries_as_at_date,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_paid_as_at_date,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_as_at_date,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_reserve_pay_recovery_exp,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_reserves,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_est_recoveries,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_payments,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_recoveries,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'I' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_initial_res_for_payments,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'R' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_reest_res_for_payments,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_est_recoveries_period,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_period_payments,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_period_recoveries,
CASE WHEN inclm_process_status = 'I' THEN 'I' WHEN clo_estimated_reserve_as_at_date = 0 THEN IF COUNT(IF incvsdt_line_sub_type <> '' THEN 1 ELSE NULL ENDIF) = 0 THEN 'P' ELSE 'W' ENDIF WHEN clo_estimated_reserve_as_at_date - clo_paid_as_at_date = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date = 0 THEN 'C' WHEN (clo_estimated_reserve_as_at_date - clo_reserve_pay_recovery_exp) - (clo_paid_as_at_date - clo_payments_recovery_exp) = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'R' ELSE 'O' END as clo_process_status
FROM
inclaims 
JOIN initems ON initm_item_serial = inclm_item_serial,
inpolicies ,
inclients ,
ininsurancetypes ,
inagents ,
ingeneralagents ,
inclaims_asat_date
WHERE
( inpolicies.inpol_policy_serial = inclaims.inclm_policy_serial )
and ( inclients.incl_client_serial = inpolicies.inpol_client_serial )
and ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial )
and ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial )
and ( inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial )
and ( inclaims.inclm_claim_serial = inclaims_asat_date.incvsdt_claim_serial )
and ((inclaims.inclm_process_status <> 'I' /* Exclude Initial */) And (inclaims.inclm_status <> 'D' /* Exclude Deleted */)
and (inclaims.inclm_open_date <= clo_as_at_date)) And ( inclaims_asat_date.incvsdt_operation_date <= clo_as_at_date ) 
AND 1=1 
AND inclm_status in ('O','A','D') 
AND clo_sort1 >= '" . $vehicle . "' AND clo_sort1 <= '" . $vehicle . "'
AND inclm_claim_serial <> ".$claimsSerial."
GROUP BY
incvsdt_as_at_date,
inclaims.inclm_claim_serial ,
inclaims.inclm_claim_number ,
inclaims.inclm_process_status ,
inclaims.inclm_open_date , 
clo_sort1, 
clo_desc1,
inclm_claim_number,
inclm_date_of_event
HAVING
1=1 AND clo_process_status in ('P','O','W','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('2000/01/01') * 100) + MONTH('2000/01/01') OR clo_closed_year = 0)
ORDER BY
clo_sort1 ASC,inclm_claim_number ASC 
    ";
//echo $sql;
?>
<div class="container-fluid">
    <?php
    $result = $sybase->query($sql);
    echo "<strong>Total Other Claims Found With Vehicle Registration (".$vehicle."): " . $sybase->num_rows($result)."</strong>";
    ?>
    <div class="row">
        <div class="col">
            <table class="table">
                <tr>
                    <td>Claim Number</td>
                    <td>Date of Event</td>
                    <td align="center">Payments</td>
                    <td align="center">Reserve</td>
                    <td align="center">Recoveries</td>
                    <td align="center">O/S Recoveries</td>
                </tr>
                <?php
                $totals = [];
                while ($row = $sybase->fetch_assoc($result)) {
                    //print_r($row);
                    $reserve = $row['clo_bf_reserves'] + $row['clo_initial_res_for_payments'] + $row['clo_reest_res_for_payments'] - $row['clo_paid_as_at_date'];
                    $osRecovery = $row['clo_bf_est_recoveries'] + $row['clo_est_recoveries_period'] - $row['clo_recoveries_as_at_date'];

                    $totals['payments'] += $row['clo_period_payments'];
                    $totals['reserve'] += $reserve;
                    $totals['recoveries'] += $row['clo_period_recoveries'];
                    $totals['osRecoveries'] += $osRecovery;
                    ?>

                    <tr>
                        <td><a href="claims.php?claimID=<?php echo $row['inclm_claim_serial'];?>" target="_blank"
                            ><?php echo $row['inclm_claim_number']; ?></a>
                        </td>
                        <td><?php echo $db->convertDateToEU($row['inclm_date_of_event']); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($row['clo_period_payments'], 2); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($reserve, 2); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($row['clo_period_recoveries'], 2); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($osRecovery, 2); ?></td>
                    </tr>
                    <?php

                }
                ?>
                <tr>
                    <td colspan="2" align="right"><strong>Totals</strong></td>
                    <td align="center"><strong><?php echo $db->fix_int_to_double($totals['payments'], 2); ?></strong></td>
                    <td align="center"><strong><?php echo $db->fix_int_to_double($totals['reserve'], 2); ?></strong></td>
                    <td align="center"><strong><?php echo $db->fix_int_to_double($totals['recoveries'], 2); ?></strong></td>
                    <td align="center"><strong><?php echo $db->fix_int_to_double($totals['osRecoveries'], 2); ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
$db->show_empty_footer();
?>
