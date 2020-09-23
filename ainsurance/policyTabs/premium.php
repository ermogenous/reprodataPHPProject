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

    if ($_POST['fld_special_discount'] > 0) {
        $_POST['fld_special_discount'] = $_POST['fld_special_discount'] * -1;
    }

    if ($_POST['fld_overwrite_ID'] != '') {
        $overwriteSplit = explode('-', $_POST['fld_overwrite_ID']);
        $_POST['fld_overwrite_ID'] = $overwriteSplit[0];
        $_POST['fld_overwrite_agent_ID'] = $overwriteSplit[1];
    }
    $db->db_tool_update_row('ina_policies', $_POST, "`inapol_policy_ID` = " . $_POST["pid"],
        $_POST["pid"], 'fld_', 'execute', 'inapol_');

    $db->commit_transaction();

    header("Location: premium.php?rel=yes&pid=" . $_POST['pid'] . "&type=" . $_POST['type']);
    exit();
}


//$data = $db->query_fetch("SELECT * FROM ina_policies WHERE inapol_policy_ID = " . $_GET['pid']);
$policy = new Policy($_GET['pid']);
$policyUnderwriter = $policy->getPolicyUnderwriterData();

$db->enable_jquery_ui();
$db->show_empty_header();

include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
if ($policy->policyData['inapol_status'] != 'Outstanding') {
    $formValidator->disableForm();
}

include('../../scripts/form_builder_class.php');
FormBuilder::buildPageLoader();

//echo $db->prepare_text_as_html(print_r($data, true));

?>

    <div class="container-fluid main_text_smaller">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?> >
                    <div class="alert alert-dark text-center">
                        <b><?php echo $db->showLangText('Premium', 'Ασφάληστρα'); ?></b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_premium" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy Net Premium', 'Καθαρά Ασφάληστρα'); ?>
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
                            <?php echo $db->showLangText('Policy Commission', 'Προμήθεια') . " " . $policy->companyCommission . "%"; ?>
                            <i class="fas fa-calculator" style="cursor: pointer;" onclick="calculateCommission();"></i>
                            <input type="hidden" value="<?php echo $policy->companyCommission; ?>"
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

                    </div>

                    <div class="form-group row">
                        <label for="fld_fees" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy Fees', 'Δηκαιώματα'); ?>
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
                            <?php echo $db->showLangText('Policy Stamps', 'Χαρτόσημα'); ?>
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

                    </div>
                    <?php if ($policy->policyData['inapol_type_code'] == 'Motor') {
                        ?>
                    <div class="form-group row">
                        <label for="fld_mif" class="col-sm-3 col-form-label">
                            <?php echo $db->showLangText('Policy MIF', 'Τ.Α.Μ.Ο'); ?>
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


                    </div>
                    <?php
                    }
                    else {
                        ?>
                        <input type="hidden" name="fld_mif" id="fld_mif" value="0">
                        <?php
                    }
                    ?>

                    <div class="form-group row">
                        <label for="fld_special_discount" class="col-sm-3 col-form-label">
                            Special Discount
                        </label>
                        <div class="col-sm-3">
                            <?php
                            if ($policy->policyData["inapol_special_discount"] == '') {
                                $policy->policyData["inapol_special_discount"] = 0;
                            }
                            ?>
                            <input type="text" id="fld_special_discount" name="fld_special_discount"
                                   class="form-control alert-danger"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_special_discount"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_special_discount',
                                    'fieldDataType' => 'number',
                                    'required' => false,
                                    'invalidText' => 'Test'
                                ]);
                            ?>
                        </div>


                        <?php
                        if ($policy->policyData['inapol_agent_level1_ID'] > 0) {
                            $subLevel1 = $db->query_fetch('SELECT * FROM ina_underwriters JOIN users ON usr_users_ID = inaund_user_ID WHERE inaund_underwriter_ID = ' . $policy->policyData['inapol_agent_level1_ID']);
                            ?>
                            <label for="fld_agent_level1_commission" class="col-sm-3 text-right col-form-label">
                                Sub Level 1
                                Comm.: <?php echo $subLevel1['usr_name'] . " <b>" . $policy->policyData['inapol_agent_level1_percent'] . "%"; ?></b>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" id="fld_agent_level1_commission" name="fld_agent_level1_commission"
                                       class="form-control"
                                       required onchange="updateGrossPremium();"
                                       value="<?php echo $policy->policyData["inapol_agent_level1_commission"]; ?>">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_agent_level1_commission',
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidText' => 'Sub Agent Level 1 Commission is Required'
                                    ]);
                                ?>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-5">
                            Applies to Gross & Sub agents but not on company commission
                        </div>
                        <?php
                        if ($policy->policyData['inapol_agent_level2_ID'] > 0) {
                            $subLevel2 = $db->query_fetch('SELECT * FROM ina_underwriters JOIN users ON usr_users_ID = inaund_user_ID WHERE inaund_underwriter_ID = ' . $policy->policyData['inapol_agent_level2_ID'])
                            ?>
                            <label for="fld_agent_level2_commission" class="col-sm-4 text-right col-form-label">
                                Sub Level 2
                                Commission: <?php echo $subLevel2['usr_name'] . " <b>" . $policy->policyData['inapol_agent_level2_percent'] . "%"; ?></b>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" id="fld_agent_level2_commission" name="fld_agent_level2_commission"
                                       class="form-control"
                                       required onchange="updateGrossPremium();"
                                       value="<?php echo $policy->policyData["inapol_agent_level2_commission"]; ?>">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_agent_level2_commission',
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidText' => 'SubSub Agent Commission is Required'
                                    ]);
                                ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php
                    if ($policy->policyData['inapol_agent_level3_ID'] > 0) {
                        $subLevel3 = $db->query_fetch('SELECT * FROM ina_underwriters JOIN users ON usr_users_ID = inaund_user_ID WHERE inaund_underwriter_ID = ' . $policy->policyData['inapol_agent_level3_ID'])
                        ?>
                        <div class="form-group row">
                            <label for="fld_agent_level3_commission" class="col-sm-9 text-right col-form-label">
                                Sub Level 3
                                Commission: <?php echo $subLevel3['usr_name'] . " <b>" . $policy->policyData['inapol_agent_level3_percent'] . "%"; ?></b>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" id="fld_agent_level3_commission" name="fld_agent_level3_commission"
                                       class="form-control"
                                       required onchange="updateGrossPremium();"
                                       value="<?php echo $policy->policyData["inapol_agent_level3_commission"]; ?>">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_agent_level3_commission',
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidText' => 'SubSub Agent Commission is Required'
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php }

                    $overwriteListDetails = $policy->getAllOverwrites();
                    if (count($overwriteListDetails) > 0) {
                        ?>
                        <div class="form-group row">
                            <?php

                            $overwriteList = $policy->prepareOverwritesFromDropDown($overwriteListDetails);
                            //add extra option NO
                            $overwriteList['0-0'] = 'No Overwrite';

                            $formB = new FormBuilder();
                            $formB->setFieldName('fld_overwrite_ID')
                                ->setFieldDescription('Overwrite Agent')
                                ->setLabelClasses('col-sm-2')
                                ->setFieldType('select')
                                ->setInputValue($policy->policyData['inapol_overwrite_ID'] . "-" . $policy->policyData['inapol_overwrite_agent_ID'])
                                ->setInputSelectArrayOptions($overwriteList)
                                ->setFieldOnChange('changeOfOverwrite();')
                                ->buildLabel();
                            ?>
                            <div class="col-4">
                                <?php
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'select',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                            <?php
                            $formB = new FormBuilder();
                            $formB->setFieldName('fld_overwrite_commission')
                                ->setFieldDescription('Amount')
                                ->setLabelClasses('col-sm-1')
                                ->setFieldType('input')
                                ->setFieldInputType('text')
                                ->setInputValue($policy->policyData['inapol_overwrite_commission'])
                                ->setFieldOnKeyUp('calculateOverwritePercent();')
                                ->buildLabel();
                            ?>
                            <div class="col-2">
                                <?php
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                            <?php
                            $formB = new FormBuilder();
                            $formB->setFieldName('fld_overwrite_percent')
                                ->setFieldDescription('Percent')
                                ->setLabelClasses('col-sm-1')
                                ->setFieldType('input')
                                ->setFieldInputType('text')
                                ->setInputValue($policy->policyData['inapol_overwrite_percent'])
                                ->setFieldOnKeyUp('calculateOverwrite();')
                                ->buildLabel();
                            ?>
                            <div class="col-2">
                                <?php
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <script>
                        let overwriteList = [];
                        overwriteList['0-0'] = 0;
                        <?php
                        //build the array for javascript overwrites
                        foreach ($overwriteListDetails as $over) {
                            echo "overwriteList['" . $over['overwriteID'] . "-" . $over['ID'] . "'] = " . $over['percent'] . ";" . PHP_EOL;
                        }
                        ?>
                        function changeOfOverwrite() {
                            let selected = $('#fld_overwrite_ID').val();
                            //set the percentage
                            $('#fld_overwrite_percent').val(overwriteList[selected]);
                            calculateOverwrite();
                        }

                        function calculateOverwrite() {
                            let premium = $('#fld_premium').val() * 1;
                            let specialDiscount = $('#fld_special_discount').val() * 1;
                            let commissionPercent = $('#fld_overwrite_percent').val() * 1;
                            let netPremium = premium + specialDiscount;
                            let commissionAmount = netPremium * (commissionPercent / 100);
                            commissionAmount = commissionAmount.toFixed(2);
                            $('#fld_overwrite_commission').val(commissionAmount);
                        }

                        function calculateOverwritePercent() {
                            let premium = $('#fld_premium').val() * 1;
                            let specialDiscount = $('#fld_special_discount').val() * 1;
                            let overwriteAmount = $('#fld_overwrite_commission').val() * 1;
                            let netPremium = premium + specialDiscount;
                            let commissionPercent = (overwriteAmount / netPremium) * 100;
                            commissionPercent = commissionPercent.toFixed(4);
                            $('#fld_overwrite_percent').val(commissionPercent);
                        }
                    </script>

                    <div class="form-group row">
                        <div class="col-sm-5 col-form-label"></div>

                        <label class="col-sm-4 col-form-label alert alert-success">
                            <?php echo $db->showLangText('Policy Gross Premium', 'Συνολικά Ασφάληστρα'); ?>
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
                                        <?php echo $db->showLangText('Must insert ', 'Πρέπει να εισαχθεί '); ?><?php echo $policy->getTypeFullName(); ?></div>
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
                            <textarea disabled style="width: 100%" rows="10"><?php
                                //if ($policy->policyData['inapol_status'] == 'Outstanding') {
                                if (1 == 1) {
                                    if ($policy->policyData['inainc_enable_commission_release'] == 1) {
                                        echo "Commission Release is Active for this Company. Transactions will be generated only on payments." . PHP_EOL;
                                        echo "List of possible accounts transactions below." . PHP_EOL;
                                    }
                                    $transactionData = $policy->getAccountTransactionsList();
                                    foreach ($transactionData as $num => $trans) {
                                        if ($policy->error == true) {
                                            echo $policy->errorDescription;
                                        } else {
                                            echo $num . " " . $trans['type'] . " - " . $trans['code'] . "-" . $trans['name'] . " " . $trans['amount'] . "\n";
                                        }
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
            let mif = $('#fld_mif').val() * 1;
            let stamps = $('#fld_stamps').val() * 1;
            checkSpecialDiscountIfNegative();
            let specialDiscount = $('#fld_special_discount').val() * 1;

            grossPremium = premium + fees + stamps + mif + specialDiscount;

            $('#grossPremium').html(
                grossPremium.toFixed(2)
            );
        }

        function calculateCommission(ignoreConfirm = false) {
            //console.log('Calculating Commission');
            if (ignoreConfirm == false) {
                if (confirm('This will reset commissions. Are you sure?')) {
                    //do nothing allow to proceed
                } else {
                    return false;//stop the procedure
                }
            }
            let premium = $('#fld_premium').val() * 1;
            let fees = $('#fld_fees').val() * 1;
            checkSpecialDiscountIfNegative();
            let specialDiscount = $('#fld_special_discount').val() * 1;
            let commPercent = $('#commissionPercent').val() * 1;
            let commCalculation = '<?php echo $policy->commissionCalculation;?>';
            let commission = 0;

            if (commCalculation == 'commNetPrem') {
                commission = (premium * commPercent) / 100;
            } else if (commCalculation == 'commNetPremFees') {
                commission = ((premium + fees) * commPercent) / 100;
            } else {
                commission = (premium * commPercent) / 100;
            }
            commission = commission.toFixed(2);
            $('#fld_commission').val(commission);

            premium = premium + specialDiscount;

            let subAgentLevel1 = '<?php echo $policy->policyData['inapol_agent_level1_ID'];?>';
            //sub agent commission
            let subLevel1Commission = 0;
            if (subAgentLevel1 > 0) {
                //console.log('Sub Level 1 Agent exists - <?php echo $policy->policyData['inapol_agent_level1_percent'];?>%');
                let subLevel1Percent = '<?php echo $policy->policyData['inapol_agent_level1_percent'];?>';
                subLevel1Percent = subLevel1Percent * 1;

                subLevel1Commission = (premium * subLevel1Percent) / 100;
                subLevel1Commission = subLevel1Commission.toFixed(2);
                $('#fld_agent_level1_commission').val(subLevel1Commission);
            }

            let subAgentLevel2 = '<?php echo $policy->policyData['inapol_agent_level2_ID'];?>';
            if (subAgentLevel2 > 0) {
                //console.log('Sub Level 2 Agent exists - <?php echo $policy->policyData['inapol_agent_level2_percent'];?>%');

                let level1Percent = '<?php echo $policy->policyData['inapol_agent_level1_percent'];?>';
                let level2Percent = '<?php echo $policy->policyData['inapol_agent_level2_percent'];?>';
                level1Percent = level1Percent * 1;
                level2Percent = level2Percent * 1;
                let level2Commission = 0;

                level2Commission = (premium * level2Percent) / 100;
                level2Commission = level2Commission.toFixed(2);
                $('#fld_agent_level2_commission').val(level2Commission);
                //substract the subsubagent commission from the subagent
                let level1Comm = (subLevel1Commission - level2Commission) * 1;
                level1Comm = level1Comm.toFixed(2);
                $('#fld_agent_level1_commission').val(level1Comm);
            }

            let subAgentLevel3 = '<?php echo $policy->policyData['inapol_agent_level3_ID'];?>';
            if (subAgentLevel3 > 0) {
                //console.log('Sub Level 3 Agent exists - <?php echo $policy->policyData['inapol_agent_level3_percent'];?>%');

                let level2Percent = '<?php echo $policy->policyData['inapol_agent_level2_percent'];?>';
                let level3Percent = '<?php echo $policy->policyData['inapol_agent_level3_percent'];?>';
                level2Percent = level2Percent * 1;
                level3Percent = level3Percent * 1;
                let level3Commission = 0;
                let level2Commission = $('#fld_agent_level2_commission').val() * 1;
                level3Commission = (premium * level3Percent) / 100;
                level3Commission = level3Commission.toFixed(2);
                $('#fld_agent_level3_commission').val(level3Commission);
                //substract the subsubagent commission from the subagent
                let level2Comm = (level2Commission - level3Commission) * 1;
                level2Comm = level2Comm.toFixed(2);
                $('#fld_agent_level2_commission').val(level2Comm);
            }
            calculateOverwrite();

        }

        function calculateMIF(){
            let netPremium = $('#fld_premium').val() * 1;
            let newMIF = (netPremium * 0.05).toFixed(2);

            if ($('#fld_mif').val() == ''){
                $('#fld_mif').val(newMIF);
            }
        }

        $(document).ready(function () {
            updateGrossPremium();
            calculateMIF();

            <?php if ($_GET['rel'] == 'yes') { ?>
            //every time this page loads reload the premium tab
            parent.window.frames['installmentsTab'].location.reload();
            <?php } ?>
            $('#premTab', window.parent.document).height('850px');
            //check if commission field is empty or zero then calculate
            if ($('#fld_commission').val() == '') {
                calculateCommission(true);
            }
            if ($('#fld_overwrite_commission').val() == '' || $('#fld_overwrite_percent').val() == '' || $('#fld_overwrite_commission').val() == 0) {
                changeOfOverwrite();
            }
        });

        function checkSpecialDiscountIfNegative() {
            let specialDiscount = $('#fld_special_discount').val() * 1;
            if (specialDiscount > 0) {
                specialDiscount = specialDiscount * -1;
                $('#fld_special_discount').val(specialDiscount)
            }
        }


    </script>

<?php
$formValidator->output();
$db->show_empty_footer();
?>