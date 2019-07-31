<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 1:13 ΜΜ
 */

include("../../include/main.php");
include('../policy_class.php');

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

                    <div class="form-group row">


                    </div>

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
        });


    </script>

<?php
$formValidator->output();
$db->show_empty_footer();
?>