<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 04/06/2020
 * Time: 12:32
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include("soeasy_class.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Soeasy Agent Functions - Validate Policies";

$db->show_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">


                <div class="row form-group">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Validate Policies</b>
                    </div>
                </div>

                <?php
                if ($_POST['action'] == '') {
                    ?>
                    <form action="" method="post">
                        <div class="row form-group">
                            <div class="col-4">
                                Select Export Batch
                            </div>
                            <div class="col-8">
                                <select class="form-control" id="batchID" name="batchID">
                                    <?php
                                    $sql = 'SELECT
                            essesid_export_batch
                            FROM
                            es_soeasy_import_data
                            GROUP BY
                            essesid_export_batch
                            ORDER BY essesid_export_batch DESC';
                                    $result = $db->query($sql);
                                    while ($row = $db->fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['essesid_export_batch']; ?>"><?php echo $row['essesid_export_batch']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 text-center">

                                <input type="hidden" value="verify" id="action" name="action">
                                <input type="submit" class="form-control btn btn-primary"
                                       value="Verify Batch" style="width: 300px;">

                            </div>
                        </div>
                    </form>

                    <?php
                }
                if ($_POST['action'] == 'verify') {
                    $syn = new ODBCCON();
                    $soeasy = new soeasyClass();
                    $soeasy->validatePolicies($_POST['batchID']);

                }
                ?>

            </div>
            <div class="col-1"></div>
        </div>


    </div>

<?php
$db->show_footer();
?>