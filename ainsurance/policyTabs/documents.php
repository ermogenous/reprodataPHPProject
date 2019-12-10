<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/12/2019
 * Time: 12:05 μ.μ.
 */

include("../../include/main.php");
include('../policy_class.php');
include("../../accounts/accounts/accounts_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items Premium";

$policy = new Policy($_GET['pid']);
//print_r($policy->policyData);
$db->show_empty_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12" style="height: 15px;"></div>
        </div>

        <div class="row">
            <div class="col-12 alert alert-primary text-center font-weight-bold">Policy
                - <?php echo $policy->policyData['inapol_policy_number']; ?> Documents
            </div>
        </div>

        <div class="row">
            <div class="col-12" style="height: 15px;"></div>
        </div>

        <div class="row">
            <div class="col-12">
                <strong>Schedule</strong>
            </div>
        </div>
        <?php
        if ($policy->policyData['inaiss_schedule_issue_file'] == '') {
            ?>
            <div class="row">
                <div class="col-12">
                    Schedule is not available for this kind of policy.
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-12">
                    <a href="document_view_file.php?pid=<?php echo $_GET['lid'];?>" target="_blank">
                        View HTML
                    </a>
                    <br>
                    <a href="" target="_blank">
                        View PDF
                    </a>
                </div>
            </div>

            <?php
        }
        ?>

        <div class="row">
            <div class="col-12" style="height: 25px;"></div>
        </div>


        <div class="row">
            <div class="col-12">
                <strong>Certificate</strong>
            </div>
        </div>
        <?php
        if ($policy->policyData['inaiss_certificate_issue_file'] == '') {
            ?>
            <div class="row">
                <div class="col-12">
                    Certificate is not available for this kind of policy.
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-12">
                    <a href="document_view_file.php?pid=<?php echo $_GET['pid'];?>&type=certificate&action=viewHTML" target="_blank">
                        View HTML
                    </a>
                    <br>
                    <a href="document_view_file.php?pid=<?php echo $_GET['pid'];?>&type=certificate&action=viewPDF" target="_blank">
                        View PDF
                    </a>
                </div>
            </div>

            <?php
        }
        ?>

    </div>

<?php
$db->show_empty_footer();
?>