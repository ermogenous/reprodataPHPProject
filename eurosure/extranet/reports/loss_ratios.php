<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 28/5/2021
 * Time: 12:05 μ.μ.
 */


include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Extranet Reports - Loss Ratio";

//$db->show_header();
$db->show_empty_header();
include('../header_layout.php');
$lang = 'ENG';
//$year = date('Y');
//$period = date('m');
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
            FROM report_loss_ratio 
            WHERE rplr_agent_code = "' . $db->user_data['usr_agent_code'] . '"
            AND rplr_year = ' . $year . '
            AND rplr_up_to_period = ' . $period . '
            ');

?>
<style>
    .smallFonts {
        font-size: 10px;
    }
</style>
<div class="container-fluid">
    <br>

    <div class="container">
        <div class="row alert alert-primary">
            <div class="col-12 text-center font-weight-bold">
                <?php echo $db->user_data['usr_name'] . " - " . $db->user_data['usr_agent_code']; ?>
            </div>
        </div>

        <div class="row alert alert-secondary text-center font-weight-bold">
            <div class="col">
                Production By Line of Business for the period 1 to <?php echo $period." / ".$year;?>
            </div>
        </div>
    </div>
    <br>

    <table class="table smallFonts table-sm">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Year</th>
            <th scope="col" class="text-center">Num Policies</th>
            <th scope="col" class="text-center">Num New</th>
            <th scope="col" class="text-center">Num Renew</th>
            <th scope="col" class="text-center">Num Cancel</th>
            <th scope="col" class="text-center">Gross Written Premium</th>
            <th scope="col" class="text-center">Fees</th>
            <th scope="col" class="text-center">GWP + Fees</th>
            <th scope="col" class="text-center">Num Claims</th>
            <th scope="col" class="text-center">Claims Freq%</th>
            <th scope="col" class="text-center">Paid</th>
            <th scope="col" class="text-center">Reserves C/F</th>
            <th scope="col" class="text-center">Incurred</th>
            <th scope="col" class="text-center">Commission</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $totals = [];
        while ($row = $db->fetch_assoc($result)) {
            $totals['numPolicies'] += $row['rplr_num_of_policies'];
            $totals['numPoliciesNew'] += $row['rplr_num_of_new'];
            $totals['numPoliciesRenew'] += $row['rplr_num_of_renewals'];
            $totals['numPoliciesCancel'] += $row['rplr_num_of_cancellations'];
            $totals['gwp'] += $row['rplr_gross_written_premium'];
            $totals['fees'] += $row['rplr_fees'];
            $totals['gwpfees'] += $row['rplr_gwp_fees'];
            $totals['claimsCount'] += $row['rplr_claims_count'];
            $totals['paid'] += $row['rplr_claims_paid'];
            $totals['oscf'] += $row['rplr_claims_os_cf'];
            $totals['incurred'] += $row['rplr_claims_incurred'];
            $totals['commission'] += $row['rplr_commission'];
            ?>
            <tr>
                <th scope="row" colspan="18" class="font-weight-bold"><u><?php echo $row['rplr_lob']; ?></u></th>
            </tr>

            <tr>
                <th scope="row"><?php echo $row['rplr_year'] . "/1-" . $row['rplr_up_to_period']; ?></th>
                <td align="center"><?php echo $row['rplr_num_of_policies']; ?></td>
                <td align="center"><?php echo $row['rplr_num_of_new']; ?></td>
                <td align="center"><?php echo $row['rplr_num_of_renewals']; ?></td>
                <td align="center"><?php echo $row['rplr_num_of_cancellations']; ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_gross_written_premium']); ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_fees']); ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_gwp_fees']); ?></td>
                <td align="center"><?php echo $row['rplr_claims_count']; ?></td>
                <td align="center"><?php echo round(($row['rplr_claims_count'] / $row['rplr_num_of_policies']) * 100, 2); ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_claims_paid']); ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_claims_os_cf']); ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_claims_incurred']); ?></td>
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_commission']); ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <th scope="row"><strong>Totals</strong></th>
            <td align="center"><strong><?php echo $totals['numPolicies']; ?></strong></td>
            <td align="center"><strong><?php echo $totals['numPoliciesNew']; ?></strong></td>
            <td align="center"><strong><?php echo $totals['numPoliciesRenew']; ?></strong></td>
            <td align="center"><strong><?php echo $totals['numPoliciesCancel']; ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['gwp']); ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['fees']); ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['gwpfees']); ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['claimsCount']); ?></strong></td>
            <td align="center"></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['paid']); ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['oscf']); ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['incurred']); ?></strong></td>
            <td align="center"><strong><?php echo $db->fix_int_to_double($totals['commission']); ?></strong></td>
        </tr>
        </tbody>
    </table>


</div><!--Container-->

<?php
$db->show_empty_footer();
?>
