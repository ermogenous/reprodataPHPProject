<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 19/05/2020
 * Time: 10:18
 */

ini_set('max_execution_time', 1800);
ini_set('memory_limit','1024M');

include("../../../include/main.php");
include("soeasy_functions.php");
include("../../lib/odbccon.php");
include("soeasy_class.php");

$db = new Main(1);
$db->admin_title = "";

$sql = 'SELECT COUNT(*)as clo_total_found FROM es_soeasy_import_data
            WHERE essesid_status = "IMPORT" ';
$totalImport = $db->query_fetch($sql);

$db->show_header();
?>

    <div class="container-fluid">
        <?php
        if ($_POST['action'] == 'validate') {
            $syn = new ODBCCON();
            ?>
            <div class="row">
                <div class="col-12 alert alert-info text-center">
                    <b>Validating Records</b>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                    $soeasy = new soeasyClass();
                    $soeasy->validateAllRecords();
                    ?>
                </div>
            </div>
            <div class="row" style="height: 25px;"></div>
            <?php
        }

        if ($totalImport['clo_total_found'] > 0) {
            ?>
            <div class="row">
                <div class="col-12 alert alert-success text-center">
                    <b><?php echo $totalImport['clo_total_found']; ?> Records found that need validation</b>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <form action="" method="post">
                        <input type="hidden" value="validate" id="action" name="action">
                        <input type="submit" class="form-control btn btn-primary" value="Validate all records" style="width: 300px;">
                    </form>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-12 alert alert-warning text-center">
                    <b>No records found that need validation</b>
                </div>
            </div>

            <?php
        }
        ?>
    </div>
<a href="export_file.php">Export File</a>

<?php
$db->show_footer();
?>