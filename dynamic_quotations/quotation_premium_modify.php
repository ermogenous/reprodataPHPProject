<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/9/2019
 * Time: 10:57 ΠΜ
 */


include("../include/main.php");
include("quotations_class.php");
include('../scripts/form_validator_class.php');
$db = new Main();
$db->admin_title = "Dynamic Quotations - Quotation Premium Modify";

if ($db->user_data['usr_user_rights'] > 2 || $_GET['lid'] == '') {
    header("Location: quotations.php");
    exit();
}

if ($_POST['action'] == 'update') {

    $db->check_restriction_area('update');

    $db->db_tool_update_row('oqt_quotations', $_POST, "`oqq_quotations_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'oqq_');
    header("Location: quotations_show.php?lid=" . $_POST['lid']);
    exit();

}


$quotation = new dynamicQuotation($_GET['lid']);

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');

$db->show_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-sm-12 alert alert-primary text-center">
                            <strong>Modify Premium</strong>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="fld_premium" class="col-sm-3">Total Premium</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control text-center"
                                   id="fld_premium" name="fld_premium" onkeyup="updateTotalPremium();"
                                   value="<?php echo $quotation->quotationData()['oqq_premium']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_premium',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="fld_fees" class="col-sm-3">Fees</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control text-center"
                                   id="fld_fees" name="fld_fees" onkeyup="updateTotalPremium();"
                                   value="<?php echo $quotation->quotationData()['oqq_fees']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_fees',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                        <label for="fld_calculation_type" class="col-sm-3">Calculation Type: <?php echo $quotation->quotationData()['oqq_calculation_type'];?></label>
                        <?php
                            if ($quotation->quotationData()['oqq_calculation_type'] != 'Manual'){
                                $calcType = 'Manual';
                            }

                        ?>
                        <div class="col-sm-3">
                            <select name="fld_calculation_type" id="fld_calculation_type"
                                    class="form-control">
                                <option value="Manual" <?php if ($calcType == 'Manual') echo 'selected';?>>Manual</option>
                                <option value="Auto" <?php if ($calcType == 'Auto') echo 'selected';?>>Auto</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="fld_stamps" class="col-sm-3">Stamps</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control text-center"
                                   id="fld_stamps" name="fld_stamps" onkeyup="updateTotalPremium();"
                                   value="<?php echo $quotation->quotationData()['oqq_stamps']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_stamps',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <div class="col-2">Total Premium</div>
                        <div class="col-3" id="totalPremium"></div>
                    </div>
                    <script>

                        function updateTotalPremium() {
                            let premium = $('#fld_premium').val() * 1;
                            let fees = $('#fld_fees').val() * 1;
                            let stamps = $('#fld_stamps').val() * 1;
                            let total = premium + fees + stamps;
                            $('#totalPremium').html('€' + total);
                        }

                        $(document).ready(function () {
                            updateTotalPremium();
                        });

                    </script>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action" value="update">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('quotations_show.php?lid=<?php echo $_GET['lid']; ?>')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Update Premium" class="btn btn-primary">
                        </div>
                    </div>


                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>


<?php
$formValidator->output();
$db->show_footer();
?>