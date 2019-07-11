<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/6/2019
 * Time: 12:32 ΜΜ
 */

include("../include/main.php");
include('policy_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Cancellation";

$cancellationID = 0;

if ($_POST['action'] == 'cancel') {

    $db->start_transaction();

    $db->working_section = 'Policy Cancellation';
    $policy = new Policy($_POST['pid']);
    $policy->cancelPolicy($_POST['fld_cancellation_date'],$_POST['fld_premium'],$_POST['fld_fees'],$_POST['fld_commission']);

    if ($policy->error == true) {
        $db->rollback_transaction();
        $db->generateAlertError($policy->errorDescription);
        $_POST['action'] = 'error';
    } else {
        $db->commit_transaction();
        $db->generateAlertSuccess('Policy Cancelled Successfully');
        $cancellationID = $policy->newCancellationID;
    }

    $_GET['pid'] = $_POST['pid'];
}


if ($_GET['pid'] > 0) {
    $policy = new Policy($_GET['pid']);
} else {
    header("Location: policies.php");
    exit();
}
$db->enable_jquery_ui();
$db->show_header();

include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
$formValidator->addCustomCode('
    if (FormErrorFound === false) {
        if (confirm("Are you sure you want to cancel this policy?")){
            //proceed
        }
        else {
            FormErrorFound = true;
        }
    }
');
?>

<div class="container">
    <form name="myForm" id="myForm" method="post"
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <div class="container-fluid">
                    <div class="row alert alert-success text-center">
                        <div class="col-12">Cancel
                            Policy <?php echo $policy->policyData['inapol_policy_number']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4">Company</div>
                        <div class="col-8"><?php echo $policy->policyData['inainc_name']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-4">Customer</div>
                        <div class="col-8"><?php echo $policy->policyData['cst_name'] . " " . $policy->policyData['cst_surname']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-4">Status</div>
                        <div class="col-8"><?php echo $policy->policyData['inapol_status']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-4">Process Status</div>
                        <div class="col-8"><?php echo $policy->policyData['inapol_process_status']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-4">Period Starting Date</div>
                        <div class="col-8"><?php echo $db->convert_date_format($policy->policyData['inapol_period_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-4">Starting Date</div>
                        <div class="col-8"><?php echo $db->convert_date_format($policy->policyData['inapol_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-4">Expiry Date</div>
                        <div class="col-8"><?php echo $db->convert_date_format($policy->policyData['inapol_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                    </div>

                    <?php if ($cancellationID > 0) {?>
                        <div class="row">
                            <div class="col-4">View</div>
                            <div class="col-4">
                                <button type="button" class="btn btn-success" onclick="viewPolicy(<?php echo $cancellationID;?>);">Go To Cancellation</button>
                            </div>
                        </div>
                        <script>
                            function viewPolicy(id){
                                window.location.assign("policy_modify.php?lid=" + id);
                            }
                        </script>
                    <?php
                    }
                    else {
                        //get the premiums limits
                        $limits = $policy->getPeriodTotalPremiums();
                    ?>
                        <div class="row">
                            <div class="col-4">Cancellation Date</div>
                            <div class="col-8">
                                <input type="text" id="fld_cancellation_date" name="fld_cancellation_date"
                                       class="form-control"
                                       value="">
                                <?php
                                $minDate = explode('-',$policy->policyData['inapol_starting_date']);
                                $minDate = $minDate[2]."/".$minDate[1]."/".$minDate[0];
                                $maxDate = explode('-',$policy->policyData['inapol_expiry_date']);
                                $maxDate = $maxDate[2]."/".$maxDate[1]."/".$maxDate[0];
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_cancellation_date',
                                        'fieldDataType' => 'date',
                                        'required' => true,
                                        'invalidText' => 'Enter Valid Date Between '.$minDate." and ".$maxDate,
                                        'enableDatePicker' => true,
                                        'dateMinDate' => $minDate,
                                        'dateMaxDate' => $maxDate
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">- Premium (<?php echo $limits['premium'] * -1;?>)</div>
                            <div class="col-8">
                                <input type="text" id="fld_premium" name="fld_premium"
                                       class="form-control"
                                       value="">
                                <?php
                                $minValue = 0;
                                $maxValue = 0;
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_premium',
                                        'fieldDataType' => 'number',
                                        'minNumber' => ($limits['premium'] * -1),
                                        'maxNumber' => 0,
                                        'required' => true,
                                        'invalidText' => 'Enter Valid Premium Between 0 and '.($limits['premium'] * -1)
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">- Fees (<?php echo $limits['fees'] * -1;?>)</div>
                            <div class="col-8">
                                <input type="text" id="fld_fees" name="fld_fees"
                                       class="form-control"
                                       value="">
                                <?php
                                $minValue = 0;
                                $maxValue = 0;
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_fees',
                                        'fieldDataType' => 'number',
                                        'minNumber' => ($limits['fees'] * -1),
                                        'maxNumber' => 0,
                                        'required' => true,
                                        'invalidText' => 'Enter Valid Fees Between 0 and '.($limits['fees'] * -1)
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">- Commission (<?php echo $limits['commission'] * -1;?>)</div>
                            <div class="col-8">
                                <input type="text" id="fld_commission" name="fld_commission"
                                       class="form-control"
                                       value="">
                                <?php
                                $minValue = 0;
                                $maxValue = 0;
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_commission',
                                        'fieldDataType' => 'number',
                                        'minNumber' => ($limits['commission'] * -1),
                                        'maxNumber' => 0,
                                        'required' => true,
                                        'invalidText' => 'Enter Valid Commission Between 0 and '.($limits['commission'] * -1)
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row" style="height: 10px;">

                    </div>

                    <div class="row">
                        <div class="col-4">
                            <?php if ($_POST['action'] != 'cancel') { ?>
                                Proceed to Cancel?
                            <?php } ?>
                        </div>
                        <div class="col-5">
                            <form method="post">
                                <input type="button" value="Back" class="btn btn-secondary"
                                       onclick="window.location.assign('policies.php')">
                                <?php if ($_POST['action'] != 'cancel') { ?>
                                    <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid']; ?>">
                                    <input type="hidden" id="action" name="action" value="cancel">
                                    <input class="btn btn-primary" type="submit"
                                           value="Cancel Policy">
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-2"></div>
        </div>
    </form>
</div>

<?php
$formValidator->output();
$db->show_footer();
?>
