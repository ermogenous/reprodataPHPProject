<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 1:13 ΜΜ
 */

include("../../include/main.php");
include('../policy_class.php');
include("../../accounts/accounts/accounts_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items Premium";

if ($_POST['action'] == 'update') {
    $db->working_section = 'AInsurance Policy Premium Update';
    $db->start_transaction();

    $db->db_tool_update_row('ina_policies', $_POST, "`inapol_policy_ID` = " . $_POST["pid"],
        $_POST["pid"], 'fld_', 'execute', 'inapol_');

    $db->commit_transaction();

    header("Location: premium.php?rel=yes&pid=" . $_POST['pid'] . "&type=" . $_POST['type']);
    exit();
}


//$data = $db->query_fetch("SELECT * FROM ina_policies WHERE inapol_policy_ID = " . $_GET['pid']);
$policy = new Policy($_GET['pid']);
$policyUnderwriter = $policy->getPolicyUnderwriterData();

$db->show_empty_header();

include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
if ($policy->policyData['inapol_status'] != 'Outstanding') {
    $formValidator->disableForm();
}

//echo $db->prepare_text_as_html(print_r($data, true));
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?> >
                    <div class="alert alert-dark text-center">
                        <b><?php echo $db->showLangText('Premium','Ασφάληστρα');?></b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_premium" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy Net Premium','Καθαρά Ασφάληστρα');?>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_premium" name="fld_premium"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_premium"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_premium',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidText' => 'Net Premium is Required'
                                ]);
                            ?>
                        </div>

                        <label for="fld_commission" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy Commission','Προμήθεια')." ".$policy->companyCommission."%";?>
                            <i class="fas fa-calculator" style="cursor: pointer;" onclick="calculateCommission();"></i>
                            <input type="hidden" value="<?php echo $policy->companyCommission;?>"
                                   id="commissionPercent" name="commissionPercent">
                        </label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_commission" id="fld_commission"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_commission"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_commission',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidText' => 'Commission is Required'
                                ]);
                            ?>
                        </div>
                        <script>
                            function calculateCommission(){
                                let premium = $('#fld_premium').val() * 1;
                                let fees = $('#fld_fees').val() * 1;
                                let commPercent = $('#commissionPercent').val() * 1;
                                let commCalculation = '<?php echo $policy->commissionCalculation;?>';
                                let commission = 0;

                                if (commCalculation == 'commNetPrem'){
                                    commission = (premium * commPercent) / 100;
                                }
                                else if (commCalculation == 'commNetPremFees'){
                                    commission = ((premium + fees) * commPercent) / 100;
                                }
                                else {
                                    commission = (premium * commPercent) / 100;
                                }
                                commission = commission.toFixed(2);
                                $('#fld_commission').val(commission);

                                //sub agent commission
                                if (-1 == <?php echo $policyUnderwriter['inaund_subagent_ID'];?>){
                                    console.log('Sub Agent exists');

                                    let subCommPercent = '<?php echo $policyUnderwriter['clo_commission_percent'];?>';
                                    subCommPercent = subCommPercent * 1;
                                    let subCommission = 0;

                                    subCommission = (premium * subCommPercent) / 100;
                                    subCommission = subCommission.toFixed(2);
                                    $('#fld_subagent_commission').val(subCommission);

                                }

                            }
                        </script>
                    </div>

                    <div class="form-group row">
                        <label for="fld_fees" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy Fees','Δηκαιώματα');?>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_fees" id="fld_fees"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_fees"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_fees',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidText' => 'Fees is Required'
                                ]);
                            ?>
                        </div>


                        <label for="fld_stamps" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy Stamps','Χαρτόσημα');?>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_stamps" id="fld_stamps"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_stamps"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_stamps',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidText' => 'Stamps is Required'
                                ]);
                            ?>
                        </div>


                        <?php if (1 == 2) { ?>
                            <label for="fld_mif" class="col-sm-3 col-form-label">
                                <?php echo $db->showLangText('Policy MIF','Τ.Α.Μ.Ο');?>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" id="fld_mif" name="fld_mif"
                                       class="form-control"
                                       required onchange="updateGrossPremium();"
                                       value="<?php echo $policy->policyData["inapol_mif"]; ?>">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_mif',
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidText' => 'MIF is Required'
                                    ]);
                                ?>
                            </div>
                        <?php } ?>

                    </div>

                    <?php
                    if ($policyUnderwriter['inaund_subagent_ID'] == -1){
                    ?>
                    <div class="form-group row">
                        <label for="fld_subagent_commission"  class="col-sm-9 text-right col-form-label">
                            Sub Agent Commission: <?php echo $policyUnderwriter['usr_name']." ".$policyUnderwriter['clo_commission_percent']."%";?>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_subagent_commission" name="fld_subagent_commission"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_subagent_commission"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_subagent_commission',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidText' => 'Sub Agent Commission is Required'
                                ]);
                            ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group row">
                        <div class="col-sm-5 col-form-label"></div>

                        <label class="col-sm-4 col-form-label alert alert-success">
                            <?php echo $db->showLangText('Policy Gross Premium','Συνολικά Ασφάληστρα');?>
                        </label>
                        <div class="col-sm-3 text-center alert alert-success" id="grossPremium"></div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-5 col-form-label"></label>
                        <div class="col-sm-7">
                            <?php if ($policy->getTotalItems() > 0 || $policy->policyData['inapol_process_status'] == 'Cancellation') {
                                if ($policy->policyData['inapol_status'] == 'Outstanding') {
                                    ?>

                                    <input type="submit" name="Save" id="Save"
                                           value="Save Premium"
                                           class="btn btn-secondary">


                                    <?php
                                }
                            } else {
                                if ($policy->policyData['inapol_process_status'] != 'Cancellation') {
                                    ?>
                                    <div class="col-5 alert alert-danger">
                                        <?php echo $db->showLangText('Must insert ','Πρέπει να εισαχθεί ');?> <?php echo $policy->getTypeFullName(); ?></div>
                                    <?php
                                }
                            }

                            ?>
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="pid" type="hidden" id="pid" value="<?php echo $_GET["pid"]; ?>">
                            <input name="type" type="hidden" id="type" value="<?php echo $_GET["type"]; ?>">
                            <input name="action" type="hidden" id="action" value="update">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            Accounts Transactions Console
                            <textarea disabled style="width: 100%" rows="5"><?php
                                if ($policy->policyData['inapol_status'] == 'Outstanding') {
                                    $transactionData = $policy->getAccountTransactionsList();
                                    foreach ($transactionData as $num => $trans){
                                        echo $num." ".$trans['type']." - ".$trans['code']."-".$trans['name']." ".$trans['amount']."\n";
                                    }
                                }
                                ?></textarea>
                            <?php

                            ?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        function updateGrossPremium() {

            let grossPremium = 0;
            let premium = $('#fld_premium').val() * 1;
            let commission = $('#fld_commission').val() * 1;
            let fees = $('#fld_fees').val() * 1;
            //let mif = $('#fld_mif').val() * 1;
            let stamps = $('#fld_stamps').val() * 1;

            grossPremium = premium + fees + stamps;

            $('#grossPremium').html(
                grossPremium.toFixed(2)
            );
        }

        $(document).ready(function () {
            updateGrossPremium();

            <?php if ($_GET['rel'] == 'yes') { ?>
            //every time this page loads reload the premium tab
            parent.window.frames['installmentsTab'].location.reload(true);
            <?php } ?>
            $('#premTab', window.parent.document).height('550px');
            //check if commission field is empty or zero then calculate
            if ($('#fld_commission').val() == ''){
                calculateCommission();
            }
        });


    </script>

<?php
$formValidator->output();
$db->show_empty_footer();
?>