<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 02/06/2020
 * Time: 15:11
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include("soeasy_class.php");

$db = new Main(1);
$db->admin_title = "EUROSURE SoEasy Agent - Validate Lapsed policies";


$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <b>Validate Lapsed Policies</b>
            </div>
        </div>

        <?php

        if ($_POST['action'] == '') {

            $sql = "SELECT COUNT(*)as clo_total_found FROM es_soeasy_import_data 
                WHERE essesid_status = 'VALIDATED' 
                AND essesid_validation_status = 'LAPSE'
                AND essesid_lapse = 'LAPSE_SEND'";
            $data = $db->query_fetch($sql);
            ?>
            <div class="row form-group">
                <div class="col-12 text-center">
                    <b><?php echo $data['clo_total_found']; ?> Policies Found to validate</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-12 text-center">
                    <form action="" method="post">
                        <input type="hidden" value="validate_lapse" id="action" name="action">
                        <input type="submit" class="form-control btn btn-primary"
                               value="Validate all <?php echo $data['clo_total_found']; ?> policies"
                               style="width: 300px;">
                    </form>
                </div>
            </div>
            <?php
        }//if post-action empty

        if ($_POST['action'] == 'validate_lapse') {
            $sySyn = new ODBCCON('SySystem');
            $syn = new ODBCCON('EUROTEST');
            $soeasy = new soeasyClass();
            $db->start_transaction();
            $soeasy->validateLapsed();
            $db->commit_transaction();
        }
        ?>

    </div>

<?php
$db->show_footer();
?>