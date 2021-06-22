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

$lang = 'ENG';
$year = date('Y');
$period = date('m');
//echo $year . "/" . $period;

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
                Production By Line of Business
            </div>
        </div>
    </div>
    <br>

    <table class="table smallFonts table-sm">
        <thead class="thead-dark">
        <tr>
            <th scope="col" align="center">Year</th>
            <th scope="col" align="center">Num Policies</th>
            <th scope="col" align="center">Num New</th>
            <th scope="col" align="center">Num Renew</th>
            <th scope="col" align="center">Num Cancel</th>
            <th scope="col" align="center">Gross Written Premium</th>
            <th scope="col" align="center">Fees</th>
            <th scope="col" align="center">GWP + Fees</th>
            <th scope="col">Num Claims</th>
            <th scope="col">Claims Freq%</th>
            <th scope="col">Paid</th>
            <th scope="col">Reserves C/F</th>
            <th scope="col">Incurred</th>
            <th scope="col">Commission</th>
            <th scope="col">Expenses</th>
        </tr>
        </thead>
        <tbody>

        <?php
        while ($row = $db->fetch_assoc($result)) {
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
                <td align="center"><?php echo $db->fix_int_to_double($row['rplr_expenses']); ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>


</div><!--Container-->

<?php
$db->show_empty_footer();
?>
