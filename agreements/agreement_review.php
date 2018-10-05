<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/10/2018
 * Time: 12:42 ΜΜ
 */

include("../include/main.php");
include_once("agreements_functions.php");
$db = new Main();
$db->admin_title = "Agreements Review";

if ($_POST['action'] == 'review') {
    $agr = new Agreements($_POST['lid']);

    $newID = $agr->reviewAgreement($db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd'));

    if ($newID > 0) {
        $db->generateAlertSuccess('Review Created');
    } else {
        $db->generateAlertError($agr->errorDescription);
    }
}


if ($_GET["lid"] > 0) {
    $data = $db->query_fetch("
      SELECT 
        *,
        DATE_ADD(agr_expiry_date, INTERVAL 1 DAY)as clo_new_starting_date,
        DATE_ADD(agr_expiry_date, INTERVAL 1 YEAR)as clo_new_expiry_date
        FROM 
        agreements 
        JOIN customers ON cst_customer_ID = agr_customer_ID
        WHERE
        agr_agreement_ID = " . $_GET['lid']
    );

    if ($data['agr_status'] != 'Active') {
        header("Location: agreements.php");
        exit();
    }
} else {
    header("Location: agreements.php");
    exit();
}

$db->enable_jquery_ui();
$db->show_header();
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-primary text-center">
                    <b>Review Agreement</b>
                </div>

                <div class="form-group row">
                    <div class="col-2 font-weight-bold">Agreement</div>
                    <div class="col-4"><?php echo $data["agr_agreement_number"]; ?></div>
                    <div class="col-2 font-weight-bold">Customer</div>
                    <div class="col-4"><?php echo $data["cst_identity_card"] . " " . $data["cst_name"] . " " . $data["cst_surname"]; ?></div>
                </div>
                <div class="form-group row">
                    <div class="col-2 font-weight-bold">Status/P.Status</div>
                    <div class="col-4"><?php echo $data["agr_status"] . "/" . $data["agr_process_status"]; ?></div>
                    <div class="col-2 font-weight-bold">Duration</div>
                    <div class="col-4"><?php echo $db->convert_date_format($data["agr_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy')
                            . " - " . $db->convert_date_format($data["agr_expiry_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                </div>


                <?php
                //add one day on the starting date
                $startingDate = $data['clo_new_starting_date'];
                $expiryDate = $data["clo_new_expiry_date"];

                if ($newID > 0) {
                    ?>


                    <?php
                } else {
                    ?>
                    <div class="form-group row">
                        <div class="col-2 font-weight-bold">Review Dates</div>
                        <div class="col-2">
                            <?php echo $db->convert_date_format($startingDate, 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>
                        </div>

                        <div class="col-2">
                            <input name="fld_expiry_date" type="text" id="fld_expiry_date"
                                   class="form-control"
                                   required
                                <?php echo "disable"; ?>>
                        </div>
                        <div class="col-6">
                            <input type="hidden" id="action" name="action" value="review">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">

                            <input type="submit" name="Submit" id="Submit"
                                   value="Review Agreement"
                                   class="btn btn-success" onclick="return submitForm()">
                        </div>

                    </div>

                    <script>

                        $(function () {
                            $("#fld_expiry_date").datepicker();
                            $("#fld_expiry_date").datepicker("option", "dateFormat", "dd/mm/yy");
                            $("#fld_expiry_date").val('<?php echo $db->convert_date_format($expiryDate, 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');
                        });

                    </script>
                <?php } ?>

                <div class="form-group row">
                    <div class="col-12 text-center">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('agreements.php');">

                        <?php if ($newID > 0) { ?>
                            <input type="button" value="Open Renewal" class="btn btn-success"
                                   onclick="window.location.assign('agreements_modify.php?lid=<?php echo $newID; ?>');">
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function submitForm() {

        //console.log('Submit');
        let frm = document.getElementById('myForm');
        if (frm.checkValidity() === false) {
            //console.log('Invalid Form');
            return false;
        }
        else {
            if (confirm('Are you sure you want to review this agreement?')) {
                document.getElementById('Submit').disabled = true
                return true;
            }
            else {
                return false;
            }
        }
    }
</script>

<?php
$db->show_footer();
?>
