<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 11/06/2020
 * Time: 13:58
 */

include("../../../../include/main.php");
include("../../../lib/odbccon.php");

$db = new Main(1);
$db->admin_title = "Eurosure Function soeasy reports - error report";

$db->show_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">


                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Soeasy Error Report</b>
                    </div>
                </div>

                <?php
                if ($_POST['action'] == '') {
                    ?>
                    <form action="" method="post">
                        <div class="row form-group">
                            <div class="col-4">
                                Select Import Batch
                            </div>
                            <div class="col-8">
                                <select class="form-control" id="importBatch" name="importBatch">
                                    <?php
                                    $sql = 'SELECT
                            essesid_import_batch,
                            COUNT(*)as clo_total_records,
                            MAX(essesid_last_update_date_time)as clo_last_date
                            FROM
                            es_soeasy_import_data
                            GROUP BY
                            essesid_import_batch
                            ORDER BY essesid_import_batch DESC';
                                    $result = $db->query($sql);
                                    while ($row = $db->fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['essesid_import_batch']; ?>">
                                            <?php echo $row['essesid_import_batch']." - Total Records ".$row['clo_total_records']." Last update: ".$row['clo_last_date']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Show only?</div>
                            <div class="col-8">
                                <select class="form-control" id="showOnly" name="showOnly">
                                    <option value="all">ALL</option>
                                    <option value="val_not_ok">Only record validation status Not OK</option>
                                    <option value="val_ok">Only record validation status OK</option>
                                    <option value="pol_not_ok">Only policy validation status Not Ok</option>
                                    <option value="pol_ok">Only policy validation status OK</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 text-center">

                                <input type="hidden" value="show" id="action" name="action">
                                <input type="submit" class="form-control btn btn-primary"
                                       value="Show Error Report for Batch" style="width: 300px;">

                            </div>
                        </div>
                    </form>

                    <?php
                }
                if ($_POST['action'] == 'show'){
                    $syn = new ODBCCON();

                    if ($_POST['showOnly'] == 'all') {
                        $where = '';
                    }
                    else if ($_POST['showOnly'] == 'val_not_ok') {
                        $where = ' AND essesid_validation_status != "OK"';
                    }
                    else if ($_POST['showOnly'] == 'val_ok') {
                        $where = ' AND essesid_validation_status = "OK"';
                    }
                    else if ($_POST['showOnly'] == 'pol_not_ok') {
                        $where = '';
                    }
                    else if ($_POST['showOnly'] == 'pol_ok') {
                        $where = '';
                    }

                    $totalRecords = 0;


                    $sql = 'SELECT * FROM es_soeasy_import_data 
                        WHERE essesid_import_batch = '.$_POST['importBatch']." 
                        ".$where."
                        ORDER BY essesid_soeasy_import_data_ID ASC";
                    $result = $db->query($sql);
                    while ($row = $db->fetch_assoc($result)) {
                        $totalRecords++;

                        //check to find the policy in synthesis
                        $synSql = "SELECT * FROM BrokerInsuranceImport 
                                    WHERE 
                                    bii_policy_number = '".$row['Policy_Number']."'";
                        $synData = $syn->query_fetch($synSql);
                        if ($synData['inipol_auto_serial'] > 0 && $synData['inipol_auto_serial'] != ''){

                        }
                        else {

                        }

                        ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $row['Policy_Number'];?>
                                </div>
                            </div>
                        <?php
                    }
                    ?>
                    <div class="row form-group">
                        <div class="col-2 alert alert-warning text-center">
                            Total Records: <?php echo $totalRecords;?>
                        </div>
                    </div>
                    <?php
                }//if show report
                ?>


            </div>
            <div class="col-1"></div>
        </div>
    </div>


<?php
$db->show_footer();
?>