<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/6/2019
 * Time: 11:10 ΜΜ
 */

include("../include/main.php");
include('quotations_class.php');
$db = new Main();
$db->admin_title = "Quotation Cancellation";

if ($_POST['action'] == 'cancel') {
    $quotation = new dynamicQuotation($_POST['lid']);
    $quotation->cancelQuotation();
    if ($quotation->error == true) {
        $db->generateAlertError($quotation->errorDescription);
    } else {
        $db->generateAlertSuccess($quotation->getQuotationType() . " cancelled successfully.");
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

$db->show_header();
?>

<div class="container">

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 alert alert-success text-center">
                        <b>Cancel <?php echo $quotation->getQuotationType() . " " . $quotation->quotationData()['oqq_number']; ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">Agent</div>
                    <div class="col-8"><?php echo $quotation->quotationData()['usr_name']; ?></div>
                </div>

                <div class="row">
                    <div class="col-4">Type</div>
                    <div class="col-8"><?php echo $quotation->quotationData()['oqqt_name']; ?></div>
                </div>

                <div class="row" style="height: 20px;"></div>

                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <form method="post">

                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('quotations.php')">
                            <?php if ($_POST['action'] != 'cancel') { ?>
                                <input type="hidden" id="lid" name="lid" value="<?php echo $_GET['lid']; ?>">
                                <input type="hidden" id="action" name="action" value="cancel">
                                <input type="submit" value="Cancel <?php echo $quotation->getQuotationType();?>" class="btn btn-primary"
                                       onclick="return confirm('Are you sure you want to cancel?');">
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>

</div>

<?php
$db->show_footer();
?>
