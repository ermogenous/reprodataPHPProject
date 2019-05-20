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
            <div class="col-md-2">left</div>
            <div class="container">


                <div class="row">
                    <div class="alert alert-success text-center">
                        Renew <?php echo $quote->getQuotationType() . " " . $quote->quotationData()['oqq_number']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="">sfgsdfg</div>
                </div>
            </div>
            <div class="col-md-2">right</div>
        </div>
    </div>
<?php
$db->show_footer();
?>