<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/6/2019
 * Time: 11:10 ΜΜ
 */

include("../include/main.php");
include('quotations_class.php');
include("../scripts/form_validator_class.php");
include("../scripts/form_builder_class.php");
$db = new Main();
$db->admin_title = "Quotation Cancellation";
$error = false;
if ($_POST['action'] == 'cancel') {
    $quotation = new dynamicQuotation($_POST['lid']);

    if ($_POST['fld_cancelDate'] == '') {
        $db->generateAlertError('Must supply cancellation date');
        $error = true;
    }

    if ($quotation->quotationData()['oqq_starting_date'] == '' || $quotation->quotationData()['oqq_starting_date'] == '0000-00-00 00:00:00') {
        $db->generateAlertError('Missing Effective Date');
        $error = true;
    }
    $startDateParts = explode('-', explode(' ', $quotation->quotationData()['oqq_starting_date'])[0]);
    $startDate = ($startDateParts[0] * 10000) + ($startDateParts[1] * 100) + $startDateParts[2];
    $cancelDatePart = explode('/', $_POST['fld_cancelDate']);
    $cancelDate = ($cancelDatePart[2] * 10000) + ($cancelDatePart[1] * 100) + $cancelDatePart[0];
    if ($cancelDate < $startDate){
        $db->generateAlertError('Cancellation date cannot be prior to starting date');
        $error = true;
    }
    if ($quotation->quotationData()['oqq_expiry_date'] == '' || $quotation->quotationData()['oqq_expiry_date'] == '0000-00-00 00:00:00'){
        //expiry is empty no need to verify anything here
    }
    else {
        $expiryDateParts = explode('-', explode(' ', $quotation->quotationData()['oqq_expiry_date'])[0]);
        $expiryDate = ($expiryDateParts[0] * 10000) + ($expiryDateParts[1] * 100) + $expiryDateParts[2];
        if ($cancelDate > $expiryDate) {
            $db->generateAlertError('Cancellation date cannot be after expiry date');
            $error = true;
        }
    }

    if ($error == false) {
        $quotation->cancelQuotation($db->convertDateToUS($_POST['fld_cancelDate']));
        if ($quotation->error == true) {
            $db->generateAlertError($quotation->errorDescription);
        } else {
            $db->generateAlertSuccess($quotation->getQuotationType() . " cancelled successfully.");
        }
    }
}


if ($_GET['lid'] > 0) {
    $quotation = new dynamicQuotation($_GET['lid']);

    if ($quotation->quotationData()['oqqt_enable_cancellation'] != 1) {
        header("Location: quotations.php");
        exit();
    }

} else {
    header("Location: quotations.php");
    exit();
}
$db->enable_jquery_ui();
$db->show_header();

$formValidator = new customFormValidator();
$formB = new FormBuilder();
$formB->setLabelClasses('col-4');
FormBuilder::buildPageLoader();
?>

<div class="container">
    <form name="myForm" id="myForm" method="post" action=""
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 alert alert-success text-center">
                            <b>Cancel <?php echo $quotation->getQuotationType() . " " . $quotation->quotationData()['oqq_number']; ?></b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Number</div>
                        <div class="col-8"><?php echo $quotation->quotationData()['oqq_number']; ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">Agent</div>
                        <div class="col-8"><?php echo $quotation->quotationData()['usr_name']; ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">Type</div>
                        <div class="col-8"><?php echo $quotation->quotationData()['oqqt_name']; ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">Starting Date</div>
                        <div class="col-8"><?php echo $db->convertDateToEU($quotation->quotationData()['oqq_starting_date'], 1, 0); ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">Effective Date</div>
                        <div class="col-8"><?php echo $db->convertDateToEU($quotation->quotationData()['oqq_effective_date'], 1, 1); ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">Expiry Date</div>
                        <div class="col-8"><?php echo $db->convertDateToEU($quotation->quotationData()['oqq_expiry_date'], 1, 0); ?></div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB->setFieldName('fld_cancelDate')
                            ->setFieldDescription('Cancellation Date')
                            ->setFieldType('input')
                            ->setInputValue('')
                            ->buildLabel();
                        ?>
                        <div class="col-sm-8">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['fld_cancelDate']
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">Cancellation Effective Date</div>
                        <div class="col-8"><?php echo date("d/m/Y G:i:s"); ?></div>
                    </div>

                    <div class="row" style="height: 20px;"></div>

                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-8">

                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('quotations.php')">
                            <?php if ($_POST['action'] != 'cancel' || $error == true) { ?>
                                <input type="hidden" id="lid" name="lid" value="<?php echo $_GET['lid']; ?>">
                                <input type="hidden" id="action" name="action" value="cancel">
                                <input type="submit" value="Cancel <?php echo $quotation->getQuotationType(); ?>"
                                       class="btn btn-primary"
                                       onclick="return confirm('Are you sure you want to cancel?');">
                            <?php } ?>

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
