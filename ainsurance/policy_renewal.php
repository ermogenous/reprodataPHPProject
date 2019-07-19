<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/6/2019
 * Time: 6:37 ΜΜ
 */

include("../include/main.php");
include('policy_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Renewal";


if ($_POST['action'] == 'review'){

    $db->working_section = 'Policy Review';
    $db->start_transaction();

    $policy = new Policy($_POST['pid']);
    if ($policy->reviewPolicy() == true){
        $db->commit_transaction();
        $db->generateAlertSuccess('Policy Reviewed Successfully');
    }
    else {
        $db->rollback_transaction();
        $db->generateAlertError($policy->errorDescription);
    }

    $_GET['pid'] = $_POST['pid'];
}


if ($_GET['pid'] > 0){
    $policy = new Policy($_GET['pid']);
}
else {
    header("Location: policies.php");
    exit();
}

$db->show_header();
?>

<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">

            <div class="container-fluid">
                <div class="row alert alert-success text-center">
                    <div class="col-12">Review Policy <?php echo $policy->policyData['inapol_policy_number'];?></div>
                </div>
                <div class="row">
                    <div class="col-4">Company</div>
                    <div class="col-8"><?php echo $policy->policyData['inainc_name'];?></div>
                </div>

                <div class="row">
                    <div class="col-4">Customer</div>
                    <div class="col-8"><?php echo $policy->policyData['cst_name']." ".$policy->policyData['cst_surname'];?></div>
                </div>

                <div class="row">
                    <div class="col-4">Status</div>
                    <div class="col-8"><?php echo $policy->policyData['inapol_status'];?></div>
                </div>

                <div class="row">
                    <div class="col-4">Process Status</div>
                    <div class="col-8"><?php echo $policy->policyData['inapol_process_status'];?></div>
                </div>

                <div class="row">
                    <div class="col-4">Period Starting Date</div>
                    <div class="col-8"><?php echo $db->convert_date_format($policy->policyData['inapol_period_starting_date'],'yyyy-mm-dd','dd/mm/yyyy');?></div>
                </div>

                <div class="row">
                    <div class="col-4">Starting Date</div>
                    <div class="col-8"><?php echo $db->convert_date_format($policy->policyData['inapol_starting_date'],'yyyy-mm-dd','dd/mm/yyyy');?></div>
                </div>

                <div class="row">
                    <div class="col-4">Expiry Date</div>
                    <div class="col-8"><?php echo $db->convert_date_format($policy->policyData['inapol_expiry_date'],'yyyy-mm-dd','dd/mm/yyyy');?></div>
                </div>
                <?php
                $dateDiff = $db->dateDiff($policy->policyData['inapol_starting_date'], $policy->policyData['inapol_expiry_date'],'yyyy-mm-dd');
                $months = $dateDiff->m + ($dateDiff->y * 12);
                //if days are more than 26 then its another full month
                if ($dateDiff->d > 26) {
                    $months++;
                }
                $startingDate = $policy->policyData['inapol_expiry_date'];
                $startingDate = explode('-', $startingDate);
                $newStartingDate = date('d/m/Y',mktime(0,0,0,$startingDate[1],$startingDate[2]+1,$startingDate[0]));
                $newExpiryDateParts = $db->getNewExpiryDate($newStartingDate, $months);
                ?>
                <div class="row">
                    <div class="col-4">New Starting Date</div>
                    <div class="col-3 alert-danger"><?php echo $newStartingDate;?></div>
                </div>

                <div class="row">
                    <div class="col-4">New Expiry</div>
                    <div class="col-3 alert-danger"><?php echo $newExpiryDateParts['day']."/".$newExpiryDateParts['month']."/".$newExpiryDateParts['year'];?></div>
                </div>

                <div class="row" style="height: 10px;">

                </div>

                <div class="row">
                    <div class="col-4">Proceed to Review?</div>
                    <div class="col-3">
                        <form method="post">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('policies.php')">
                            <?php if ($_POST['action'] != 'review') { ?>
                            <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid'];?>">
                            <input type="hidden" id="action" name="action" value="review">
                            <input class="btn btn-primary" type="submit"
                                   value="Review"
                                   onclick="return confirm('Are you sure you want to review this policy?');"
                            >
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-2"></div>
    </div>
</div>

<?php
$db->show_footer();
?>
