<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 24/6/2021
 * Time: 8:35 π.μ.
 */


include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Extranet Reports - Claims";

//$db->show_header();
$db->show_empty_header();
include('../header_layout.php');
?>

<div class="container">
    <br>
    <div class="row">
        <div class="col text-center font-weight-bold">
            <?php echo $db->user_data['usr_name'] . " - " . $db->user_data['usr_agent_code']; ?>
        </div>
    </div>
    <br>
    <div class="row text-center font-weight-bold">
        <div class="col alert alert-primary">
            INSURANCE REPORTS
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-6">
            <div class="list-group">
                <a href="loss_ratios.php" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Production By Line of Business</h5>
                        <small>Updated Monthly</small>
                    </div>
                    <p class="mb-1">Production Report with breakdown line of business.</p>
                    <!--<small>...</small>-->
                </a>
            </div>
        </div>
        <div class="col-6">
            <div class="list-group">
                <a href="claims.php" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Motor Claims Report</h5>
                        <small>Updated Monthly</small>
                    </div>
                    <p class="mb-1">&nbsp;</p>
                </a>
            </div>
        </div>
    </div>

</div>

<?php
$db->show_empty_footer();
?>
