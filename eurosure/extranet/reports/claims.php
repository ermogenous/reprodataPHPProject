<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 22/6/2021
 * Time: 10:09 π.μ.
 */

include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Extranet Reports - Claims";

//$db->show_header();
$db->show_empty_header();
include('../header_layout.php');
$lang = 'ENG';
//$year = date('Y');
//$period = date('m');
//$period = 5;
//echo $year . "/" . $period;

$periodData = $db->query_fetch('SELECT
MAX(rplr_year)as clo_max_year,
MAX(rplr_up_to_period)as clo_max_period
FROM
report_loss_ratio
WHERE
rplr_year = (SELECT MAX(rplr_year) FROM report_loss_ratio)');
$year = $periodData['clo_max_year'];
$period = $periodData['clo_max_period'];
$asAtDate = date("Y-m-t",mktime(0,0,0,$period,1,$year));


$result = $db->query(
    'SELECT
            *
            FROM report_claims 
            WHERE rpclm_agent_code = "' . $db->user_data['usr_agent_code'] . '"
            AND rpclm_year = ' . $year . '
            AND rpclm_up_to_period = ' . $period . '
            ORDER BY
            rpclm_agent_code ASC, rpclm_claim_number ASC, rpclm_transaction_type ASC
            ');

?>
<style>
    .smallFonts {
        font-size: 10px;
    }
</style>
<div class="container-fluid">
    <br>
    <div class="container-fluid">
        <div class="row alert alert-primary">
            <div class="col-12 text-center font-weight-bold">
                <?php echo $db->user_data['usr_name'] . " - " . $db->user_data['usr_agent_code']; ?>
            </div>
        </div>


        <br>
        <div class="row alert alert-secondary text-center font-weight-bold">
            <div class="col">
                Portal Reports Motor Claims For the Period 1 to <?php echo $period." / ".$year;?>
            </div>
        </div>


        <table class="table smallFonts table-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Claim#</th>
                <th scope="col">Policy#</th>
                <th scope="col">Policy Status</th>
                <th scope="col">Claim Status</th>
                <th scope="col">UW Year</th>
                <th scope="col">Loss Year</th>
                <th scope="col">Accident Date</th>
                <th scope="col">Registration</th>
                <th scope="col">Cause</th>
                <th scope="col">Type</th>
                <th scope="col">Reserve B/F</th>
                <th scope="col">Am.Paid</th>
                <th scope="col">Paid YTD</th>
                <th scope="col">Reserve C/F</th>
                <th scope="col">Incurred</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $previousClaim = '';
            $i = 0;
            while ($row = $db->fetch_assoc($result)) {
            $i++;

            //the header line
            if ($row['rpclm_claim_number'] != $previousClaim) {
                //if not the first line then this is the footer of the previous
                if ($i != 1) {
                    ?>
                    <tr>
                        <td colspan="10"></td>
                        <td><strong><?php echo $db->fix_int_to_double($totalReserveCF, 2); ?></strong></td>
                        <td><strong><?php echo $db->fix_int_to_double($totalAmountPaid, 2); ?></strong></td>
                        <td><strong><?php echo $db->fix_int_to_double($totalPaidYtd, 2); ?></strong></td>
                        <td><strong><?php echo $db->fix_int_to_double($totalReserveCf, 2); ?></strong></td>
                        <td><strong><?php echo $db->fix_int_to_double($totalClaimsIncurred, 2); ?></strong></td>
                    </tr>
                    <?php
                    //reset totals
                    $totalReserveCF = 0;
                    $totalAmountPaid = 0;
                    $totalPaidYtd = 0;
                    $totalReserveCf = 0;
                    $totalClaimsIncurred = 0;

                }
                ?>
                <tr>
                    <td colspan="16">
                        <strong>
                            <?php
                            echo $row['rpclm_client_code'] . " - " . $row['rpclm_client_name'];
                            ?>
                        </strong>
                    </td>
                </tr>
                <?php
            }

            //totals
            $totalReserveCF += $row['rpclm_reserve_bf'];
            $totalAmountPaid += $row['rpclm_amount_paid'];
            $totalPaidYtd += $row['rpclm_paid_ytd'];
            $totalReserveCf += $row['rpclm_reserve_cf'];
            $totalClaimsIncurred += $row['rpclm_claims_incurred'];

            ?>
            <tr>
                <th scope="row"><?php echo $row['rpclm_claim_number']; ?></th>
                <td><?php echo $row['rpclm_policy_number']; ?></td>
                <td><?php echo $row['rpclm_policy_status']; ?></td>
                <td><?php echo $row['rpclm_claim_status']; ?></td>
                <td><?php echo $row['rpclm_uw_year']; ?></td>
                <td><?php echo $row['rpclm_loss_year']; ?></td>
                <td><?php echo $db->convertDateToEU($row['rpclm_accident_date']); ?></td>
                <td><?php echo $row['rpclm_registration']; ?></td>
                <td><?php echo $row['rpclm_cause']; ?></td>
                <td><?php echo $row['rpclm_transaction_type']; ?></td>
                <td><?php echo $db->fix_int_to_double($row['rpclm_reserve_bf'], 2); ?></td>
                <td><?php echo $db->fix_int_to_double($row['rpclm_amount_paid'], 2); ?></td>
                <td><?php echo $db->fix_int_to_double($row['rpclm_paid_ytd'], 2); ?></td>
                <td><?php echo $db->fix_int_to_double($row['rpclm_reserve_cf'], 2); ?></td>
                <td><?php echo $db->fix_int_to_double($row['rpclm_claims_incurred'], 2); ?></td>
            </tr>
            </tbody>
            <?php
            $previousClaim = $row['rpclm_claim_number'];
            if ($row['rpclm_claim_number'] != $previousClaim || $i == $db->num_rows($result)) {
                ?>
                <tr>
                    <td colspan="10"></td>
                    <td><strong><?php echo $db->fix_int_to_double($totalReserveCF, 2); ?></strong></td>
                    <td><strong><?php echo $db->fix_int_to_double($totalAmountPaid, 2); ?></strong></td>
                    <td><strong><?php echo $db->fix_int_to_double($totalPaidYtd, 2); ?></strong></td>
                    <td><strong><?php echo $db->fix_int_to_double($totalReserveCf, 2); ?></strong></td>
                    <td><strong><?php echo $db->fix_int_to_double($totalClaimsIncurred, 2); ?></strong></td>
                </tr>
                <?php
                //reset totals
                $totalReserveCF = 0;
                $totalAmountPaid = 0;
                $totalPaidYtd = 0;
                $totalReserveCf = 0;
                $totalClaimsIncurred = 0;
            }

            }
            ?>
        </table>

    </div>
</div>
