<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/6/2019
 * Time: 3:43 ΜΜ
 */

include("../../include/main.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Apply Unallocated Payments";

if ($_POST['action'] == 'applyAllocation'){
    //get the data
    $data = $db->query_fetch('
        SELECT * FROM
        ina_policy_payments
        JOIN ina_policies ON inapol_policy_ID = inapp_policy_ID
        JOIN customers ON cst_customer_ID = inapp_customer_ID
        WHERE
        inapp_policy_payment_ID = ' . $_POST['lid']);

    if ($data['inapp_amount'] > $_POST['amountToApply']){
        echo "Partial";
    }
    else {
        echo "Full";
    }

}

if ($_GET['lid'] > 0) {

    $data = $db->query_fetch('
        SELECT * FROM
        ina_policy_payments
        JOIN ina_policies ON inapol_policy_ID = inapp_policy_ID
        JOIN customers ON cst_customer_ID = inapp_customer_ID
        WHERE
        inapp_policy_payment_ID = ' . $_GET['lid']);

} else {
    header("Location: unallocated.php");
    exit();
}

$db->show_header();

include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
?>
    <form method="post" id="myForm" name="myForm" action=""
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="container">

            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Apply UnAllocated Payment Record To Other
                                Policy</b></div>
                    </div>

                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                            <div class="row">
                                <div class="col-2 alert alert-info">Policy Number</div>
                                <div class="col-4 alert"><?php echo $data['inapol_policy_number']; ?></div>
                                <div class="col-2 alert alert-info">Status</div>
                                <div class="col-4 alert"><?php echo $data['inapol_status']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-2 alert alert-info">Customer</div>
                                <div class="col-4 alert"><?php echo $data['cst_name'] . " " . $data['cst_surname']; ?></div>
                                <div class="col-2 alert alert-info">ID</div>
                                <div class="col-4 alert"><?php echo $data['cst_identity_card']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-2 alert alert-info">Amount</div>
                                <div class="col-4 alert"><?php echo $data['inapp_amount']; ?></div>
                            </div>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                            <div class="row">
                                <div class="col-3 alert alert-info">Apply Payment To Policy</div>
                                <div class="col-9 alert">
                                    <select id="toPolicyID" name="toPolicyID" class="form-control"
                                            onchange="verifyPolicySelection()">
                                        <option value="">Select Policy</option>
                                        <?php
                                        //find all policies that have unpaid or partial
                                        $sql = '
                                    SELECT
                                    inapol_policy_ID
                                    ,inapol_policy_number
                                    ,inapol_installment_ID
                                    ,inapol_process_status
                                    ,SUM(inapi_amount - inapi_paid_amount)as clo_total_unpaid
                                    FROM
                                    ina_policy_installments
                                    JOIN ina_policies ON inapol_policy_ID = inapi_policy_ID
                                    JOIN customers ON inapol_customer_ID = cst_customer_ID
                                    WHERE
                                    inapol_customer_ID = ' . $data['cst_customer_ID'] . '
                                    AND inapol_process_status IN ("New","Renewal")
                                    AND inapi_paid_status IN ("UnPaid","Partial")
                                    GROUP BY
                                    inapol_policy_ID,
                                    inapol_policy_number,
                                    inapol_process_status,
                                    inapol_installment_ID';
                                        $result = $db->query($sql);
                                        echo $sql;
                                        while ($row = $db->fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['inapol_policy_ID']; ?>">
                                                <?php echo $row['inapol_policy_number'] . " - " . $row['inapol_process_status'] . " - Unpaid Amount: €" . $row['clo_total_unpaid']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "toPolicyID",
                                        "fieldDataType" => "select",
                                        "required" => true,
                                        "invalidText" => "Must select policy",
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 alert alert-info">Amount to apply</div>
                                <div class="col-3">
                                    <input type="number" class="form-control"
                                           id="amountToApply" name="amountToApply"
                                           value="<?php echo $data['inapp_amount']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "amountToApply",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Must provide amount",
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="row" style="display: none" id="errorPartialText">
                                <div class="col-12 text-center alert alert-warning">
                                    Amount to be applied is partial. This will leave a remaining amount which you can
                                    apply on another policy.
                                </div>
                            </div>
                            </p>
                        </div>
                    </div>


                    <script>
                        function verifyPolicySelection() {
                            var unallocatedAmount = <?php echo $data['inapp_amount'];?>;
                            //get amount from the selection
                            var selectedText = $("#toPolicyID option:selected").text();
                            var appliedAmount = $("#amountToApply").val();
                            var split = selectedText.split("€");
                            var selectedAmount = split[1] * 1;
                            if (selectedAmount < unallocatedAmount) {

                                var newAmount = selectedAmount;
                                $('#amountToApply').val(
                                    newAmount
                                );
                                alert('Cannot apply amount more than the unpaid amount. Autofix');
                            }

                            //check if all the amount is placed
                            if (appliedAmount < unallocatedAmount) {
                                if (unallocatedAmount > selectedAmount) {
                                    $("#amountToApply").val(selectedAmount);
                                }
                                else {
                                    $("#amountToApply").val(unallocatedAmount);
                                }
                            }
                            checkIfPartial();
                        }

                        function checkIfPartial() {
                            var unallocatedAmount = <?php echo $data['inapp_amount'];?>;
                            var appliedAmount = $("#amountToApply").val();

                            if (appliedAmount < unallocatedAmount) {
                                $('#errorPartialText').show();
                            }
                            else {
                                $('#errorPartialText').hide();
                            }

                        }
                    </script>


                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <p class="card-text text-center">
                                <button type="button" value="Back" style="width: 140px;" class="btn btn-secondary"
                                        onclick="goBack();">
                                    Back
                                </button>
                                <input type="hidden" id="action" name="action" value="applyAllocation">
                                <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                                <input type="submit" name="Submit" id="Submit"
                                       value="Apply Allocation"
                                       class="btn btn-primary">

                            </p>
                        </div>
                    </div>


                </div>

                <div class="col-lg-1"></div>
            </div>
        </div>
    </form>
    <script>
        function goBack() {
            window.location.assign('unallocated.php');
        }
    </script>
<?php
$formValidator->output();
$db->show_footer();
?>