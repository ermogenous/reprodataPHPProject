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

if ($_POST['action'] == 'update'){
    $db->working_section = 'AInsurance Policy Premium Update';
    $db->start_transaction();

    $db->db_tool_update_row('ina_policies', $_POST, "`inapol_policy_ID` = " . $_POST["pid"],
        $_POST["pid"], 'fld_', 'execute', 'inapol_');

    $db->commit_transaction();

    header("Location: premium.php?pid=".$_POST['pid']."&type=".$_POST['type']);
    exit();
}


//$data = $db->query_fetch("SELECT * FROM ina_policies WHERE inapol_policy_ID = " . $_GET['pid']);
$policy = new Policy($_GET['pid']);

$db->show_empty_header();

//echo $db->prepare_text_as_html(print_r($data, true));
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b>Premium</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_premium" class="col-sm-3 col-form-label">Policy Net Premium</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_premium" name="fld_premium"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_premium"]; ?>">
                        </div>

                        <label for="fld_commission" class="col-sm-3 col-form-label">Policy Commission</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_commission" id="fld_commission"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_commission"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_fees" class="col-sm-3 col-form-label">Policy Fees</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_fees" id="fld_fees"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_fees"]; ?>">
                        </div>

                        <label for="fld_mif" class="col-sm-3 col-form-label">Policy MIF</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_mif" name="fld_mif"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_mif"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_stamps" class="col-sm-3 col-form-label">Policy Stamps</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_stamps" id="fld_stamps"
                                   class="form-control"
                                   required onchange="updateGrossPremium();"
                                   value="<?php echo $policy->policyData["inapol_stamps"]; ?>">
                        </div>


                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 col-form-label"></div>

                        <label for="fld_mif" class="col-sm-3 col-form-label alert alert-success">Policy Gross Premium</label>
                        <div class="col-sm-3 text-center alert alert-success" id="grossPremium"></div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-5 col-form-label"></label>
                        <div class="col-sm-7">
                            <?php if ($policy->getTotalItems() > 0) {?>

                                <input type="button" name="Save" id="Save"
                                       value="Save Premium"
                                       class="btn btn-secondary" onclick="submitForm()">
                            <?php } else { ?>
                                <div class="col-5 alert alert-danger">Must insert <?php echo $policy->getTypeFullName();?></div>
                            <?php } ?>
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
        function submitForm(action) {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                document.getElementById('Save').disabled = true
                $('#myForm').submit();
            }
        }

        function updateGrossPremium(){

            let grossPremium = 0;
            let premium = $('#fld_premium').val() * 1;
            let commission = $('#fld_commission').val() * 1;
            let fees = $('#fld_fees').val() * 1;
            let mif = $('#fld_mif').val() * 1;
            let stamps = $('#fld_stamps').val() * 1;

            grossPremium = premium + fees + mif + stamps;

            $('#grossPremium').html(
                grossPremium.toFixed(2)
            );
        }
        $( document ).ready(function() {
            updateGrossPremium();
        });

    </script>

<?php
$db->show_empty_footer();
?>