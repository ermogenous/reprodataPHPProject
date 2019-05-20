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

$db->show_header();
?>

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
                            echo $db->convert_date_format($quote->quotationData()['oqq_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy',1,0)
                            ." - "
                            .$db->convert_date_format($quote->quotationData()['oqq_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy',1,0);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <hr style="color: grey;">
                    </div>
                </div>
                <?php

                ?>
                <div class="row">
                    <div class="col-5 text-right"><strong>New starting Date</strong></div>
                    <div class="col-7"><?php echo $quote->quotationData()['oqq_status']; ?></div>
                </div>


            </div>
            <div class="col-2"></div>
        </div>
    </div>


<?php
$db->show_footer();
?>