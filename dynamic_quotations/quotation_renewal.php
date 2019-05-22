<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20-May-19
 * Time: 10:57 AM
 */

include("../include/main.php");
include("../include/tables.php");
include("quotations_class.php");
$db = new Main();


if ($_GET["lid"] > 0) {
    $quote = new dynamicQuotation($_GET['lid']);
} else {
    header("Location: quotations.php");
    exit();
}
$db->enable_jquery_ui();
include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();

$db->show_header();
?>
    <form name="myForm" id="myForm" method="post" action=""
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">

                    <div class="row">
                        <div class="col-12 text-center alert alert-success">
                            <strong>
                                Renew <?php echo $quote->getQuotationType() . " " . $quote->quotationData()['oqq_number']; ?>
                            </strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5 text-right"><strong>Name</strong></div>
                        <div class="col-7"><?php echo $quote->quotationData()["oqq_insureds_name"]; ?></div>
                    </div>
                    <?php
                    if ($quote->quotationData()['oqqt_enable_premium'] == 1) {
                        ?>
                        <div class="row">
                            <div class="col-5 text-right"><strong>Total Price </strong></div>
                            <div class="col-7">€<?php echo $data["clo_total_price"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-5 text-right"><strong>Status</strong></div>
                        <div class="col-7"><?php echo $quote->quotationData()['oqq_status']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-5 text-right"><strong>Period</strong></div>
                        <div class="col-7">
                            <?php
                            echo $db->convert_date_format($quote->quotationData()['oqq_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 0)
                                . " - "
                                . $db->convert_date_format($quote->quotationData()['oqq_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 0);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr style="color: grey;">
                        </div>
                    </div>
                    <?php
                    $expiryDate = $quote->quotationData()['oqq_expiry_date'];
                    $expiryDate = explode('-', $expiryDate);
                    $newStartingDate = date('d/m/Y', mktime(0, 0, 0, $expiryDate[1], ($expiryDate[2] + 1), $expiryDate[0]));
                    ?>
                    <div class="row">
                        <div class="col-5 text-right"><strong>New starting Date</strong></div>
                        <div class="col-7">&nbsp;<?php echo $newStartingDate; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-right"><strong>New Expiry Date</strong></div>
                        <div class="col-2">
                            <input name="new_expiry_date" type="text" id="new_expiry_date"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_name"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'new_expiry_date',
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'enableDatePicker' => true,
                                    'invalidText' => 'Enter expiry date'
                                ]);
                            ?>
                        </div>
                        <div class="col-5"></div>
                    </div>

                    <div class="row">
                        <div class="col-5"></div>
                        <div class="col-7">
                            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(3)">3M</button>&nbsp;
                            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(6)">6M</button>&nbsp;
                            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(9)">9M</button>&nbsp;
                            <button type="button" class="btn" style="width: 55px;" onclick="setExpiryDate(12)">12M</button>
                        </div>
                    </div>

                    <div class="row" style="height: 25px;"></div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">

                            <input name="action" type="hidden" id="action" value="renew"/>

                            <!--
                            <input type="button" name="Submit" value="Save Quotation" class="btn btn-secondary"
                                   onclick=" if (check_quotation_form()) {document.myForm.submit();}"/>
                            -->
                            <div class="btn btn-secondary" onclick="window.location.assign('quotations.php')">Back</div>
                            <input type="submit" value="Renew <?php echo $quote->getQuotationType();?>"
                                   class="btn btn-secondary">
                        </div>
                    </div>

                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </form>

<?php
$formValidator->output();
$db->show_footer();
?>