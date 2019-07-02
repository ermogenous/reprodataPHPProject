<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/2/2019
 * Time: 7:00 ΜΜ
 */

include("../../include/main.php");
include("../policy_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Installment Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->start_transaction();

    $db->working_section = 'AInsurance Policy Installment Insert';

    $_POST['fld_policy_ID'] = $_GET['pid'];
    $_POST['fld_document_date'] = $db->convert_date_format($_POST['fld_document_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_paid_status'] = 'UnPaid';
    $_POST['fld_paid_amount'] = 0;
    $_POST['fld_insert_date'] = $db->convert_date_format($_POST['fld_insert_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_installment_type'] = 'Custom';

    $db->db_tool_insert_row('ina_policy_installments', $_POST, 'fld_', 0, 'inapi_');

    $db->commit_transaction();

    if ($_POST['sub-action'] == 'exit') {
        header("Location: installments.php?rel=yes&pid=" . $_POST['pid'] . "&type=" . $_POST['type']);
        exit();
    } else {
        $_GET['lid'] = $_POST['lid'];
        $_GET['pid'] = $_POST['pid'];
        $_GET['type'] = $_POST['type'];
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Policy Installment Modify';
    $db->start_transaction();

    $_POST['fld_document_date'] = $db->convert_date_format($_POST['fld_document_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $db->db_tool_update_row('ina_policy_installments', $_POST, "`inapi_policy_installments_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inapi_');


    $db->commit_transaction();

    if ($_POST['sub-action'] == 'exit') {
        header("Location: installments.php?rel=yes&pid=" . $_POST['pid'] . "&type=" . $_POST['type']);
        exit();
    } else {
        $_GET['lid'] = $_POST['lid'];
        $_GET['pid'] = $_POST['pid'];
        $_GET['type'] = $_POST['type'];
    }


}


if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance policy Get data';
    $sql = "SELECT * FROM `ina_policy_installments` 
            WHERE `inapi_policy_installments_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

} else {
    $data['inapi_insert_date'] = date('Y-m-d');
}


//get the policy data
$policy = new Policy($_GET['pid']);

//when endorsement is not allowed to create new installments
if ($policy->policyData['inapol_process_status'] == 'Endorsement'){
    header("Location: installments.php?pid=" . $_GET['pid'] . "&type=" . $_GET['type']);
    exit();
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();

echo "Lid:".$_GET['lid']."<br>Pid".$_GET['pid'];

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Installment</b>
                    </div>


                    <div class="form-group row">
                        <label for="fld_amount" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_amount" name="fld_amount"
                                   class="form-control"
                                   value="<?php echo $data["inapi_amount"]; ?>">
                        </div>

                        <label for="fld_document_date" class="col-sm-3 col-form-label">Document Date</label>
                        <div class="col-sm-3">
                            <input name="fld_document_date" type="text" id="fld_document_date"
                                   class="form-control"
                                   value=""
                                   required>
                            <script>
                                $(function () {
                                    $("#fld_document_date").datepicker();
                                    $("#fld_document_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                    $("#fld_document_date").val('<?php echo $db->convert_date_format($data["inapi_document_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="insert_date" class="col-sm-3 col-form-label">Insert Date</label>
                        <div class="col-sm-3">
                            <input name="insert_date" type="text" id="insert_date"
                                   class="form-control"
                                   value="<?php echo $db->convert_date_format($data["inapi_insert_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>"
                                   required disabled>
                            <input type="hidden" name="fld_insert_date" id="fld_insert_date"
                                   value="<?php echo $db->convert_date_format($data["inapi_insert_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>">
                        </div>

                        <label for="fld_commission_amount" class="col-sm-3 col-form-label">Commission</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_commission_amount" id="fld_commission_amount"
                                   class="form-control"
                                   value="<?php echo $data["inapi_commission_amount"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_last_payment_date" class="col-sm-3 col-form-label">Last Payment Date</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_last_payment_date" name="fld_last_payment_date"
                                   class="form-control"
                                   value="<?php echo $data["inapi_last_payment_date"]; ?>"
                                   disabled>
                        </div>

                        <div class="col-sm-6">
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
                            <input name="type" type="hidden" id="type" value="<?php echo $_GET["type"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary" name="BtnBack" id="BtnBack"
                                   onclick="window.location.assign('installments.php?pid=<?php echo $_GET['pid'] . "&type=" . $_GET['type']; ?>')">
                            <input type="button" name="Save" id="Save"
                                   value="Save <?php echo $label; ?>"
                                   class="btn btn-secondary" onclick="submitForm('save')">
                            <input type="button" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update";
                                   echo $label; ?>"
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
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                $('#sub-action').val(action);
                document.getElementById('Submit').disabled = true
                document.getElementById('Save').disabled = true
                document.getElementById('BtnBack').disabled = true
                $('#myForm').submit();
            }
        }

    </script>
<?php
$db->show_empty_footer();
?>