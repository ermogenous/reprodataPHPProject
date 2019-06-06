<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/3/2019
 * Time: 1:52 ΜΜ
 */

include("../../include/main.php");
include("installments_class.php");
include('../policy_class.php');
$db = new Main();
$db->admin_title = "AInsurance Policy Payment Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->start_transaction();

    $db->working_section = 'AInsurance Policy Payment Insert';

    $_POST['fld_status'] = 'Outstanding';
    $_POST['fld_policy_ID'] = $_POST['pid'];
    $_POST['fld_payment_date'] = $db->convert_date_format($_POST['fld_payment_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $newId = $db->db_tool_insert_row('ina_policy_payments', $_POST, 'fld_', 1, 'inapp_');

    $db->commit_transaction();

    if ($_POST['sub-action'] == 'exit') {
        header("Location: payments.php?pid=" . $_POST['pid']);
        exit();
    } else {
        $_GET['lid'] = $newId;
        $_GET['pid'] = $_POST['pid'];
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Policy Payment Modify';
    $db->start_transaction();

    $_POST['fld_payment_date'] = $db->convert_date_format($_POST['fld_payment_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $db->db_tool_update_row('ina_policy_payments', $_POST, "`inapp_policy_payment_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inapp_');


    $db->commit_transaction();

    if ($_POST['sub-action'] == 'exit') {
        header("Location: payments.php?pid=" . $_POST['pid']);
        exit();
    } else {
        $_GET['lid'] = $_POST['lid'];
        $_GET['pid'] = $_POST['pid'];
    }


}

if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance policy payment Get data';
    $sql = "SELECT * FROM `ina_policy_payments` 
            WHERE `inapp_policy_payment_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);


} else {
    $data['inapp_payment_date'] = date('Y-m-d');
}
$policy = new Policy($_GET['pid']);
print_r($policy);
$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();

include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
if ($data['inapp_status'] != 'Outstanding' && $data['inapp_status'] != '') {
    $formValidator->disableForm(
        array('buttons')
    );
}

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12" style="height: 25px;">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post"
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Payment</b>
                    </div>


                    <div class="form-group row">
                        <label for="fld_payment_date" class="col-sm-3 col-form-label">Payment Date</label>
                        <div class="col-sm-3">
                            <input name="fld_payment_date" type="text" id="fld_payment_date"
                                   class="form-control"
                                   value="<?php echo $data['inapp_payment_date']; ?>">
                            <script>
                                $(function () {
                                    $("#fld_payment_date").datepicker();
                                    $("#fld_payment_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                    $("#fld_payment_date").val('<?php echo $db->convert_date_format($data["inapp_payment_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                                });
                            </script>
                        </div>

                        <label for="fld_amount" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_amount" name="fld_amount"
                                   class="form-control"
                                   value="<?php echo $data['inapp_amount']; ?>">
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="pid" type="hidden" id="pid" value="<?php echo $_GET["pid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary" name="BtnBack" id="BtnBack"
                                   onclick="window.location.assign('payments.php?pid=<?php echo $_GET['pid']; ?>')">
                            <input type="submit" name="Save" id="Save"
                                   value="Save"
                                   class="btn btn-secondary" onclick="submitForm('save')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Payment"
                                   class="btn btn-secondary" onclick="submitForm('exit')">
                            <input type="hidden" name="sub-action" id="sub-action" value="">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        function submitForm(action) {
            $('#sub-action').val(action);
        }
        $('#paymentsTab', window.parent.document).height(400 + 'px');
    </script>
<?php
$formValidator->output();
$db->show_empty_footer();
?>