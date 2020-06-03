<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 02/06/2020
 * Time: 10:55
 */

//ini_set('max_execution_time', 1800);
//ini_set('memory_limit','1024M');

include("../../../include/main.php");
include("../../lib/odbccon.php");
include("soeasy_class.php");

$db = new Main(1);
$db->admin_title = "Eurosure Soeasy Agent - Lapse Policies";


$db->show_header();

?>

    <div class="container">
        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <b>Lapse policies from the import table</b>
            </div>
        </div>

        <?php
        if ($_POST['action'] == '') {
            $sql = "SELECT
    COUNT(*)as clo_total
    FROM
    es_soeasy_import_data
    WHERE
    essesid_lapse = 'LAPSE'";
            $result = $db->query_fetch($sql);
            if ($result['clo_total'] > 0) {
                ?>
                <div class="row form-group">
                    <div class="col-12 text-center">
                        <b>
                            <?php echo $result['clo_total']; ?>
                            Import Policies need to be lapsed for their import to proceed
                        </b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-12 text-center">
                        <form action="" method="post">
                            <input type="hidden" value="lapse" id="action" name="action">
                            <input type="submit" class="form-control btn btn-primary"
                                   value="Lapse <?php echo $result['clo_total']; ?> Records" style="width: 300px;">
                        </form>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-12 text-center">
                        <form action="" method="post">
                            <input type="hidden" value="show" id="action" name="action">
                            <input type="submit" class="form-control btn btn-secondary"
                                   value="Show <?php echo $result['clo_total']; ?> Records" style="width: 300px;">
                        </form>
                    </div>
                </div>
                <?php
            }
        }

        if ($_POST['action'] == 'show'){
            $sql = "SELECT
            *
            FROM
            es_soeasy_import_data
            WHERE
            essesid_lapse = 'LAPSE'";
            $result = $db->query($sql);
            $i=0;
            while ($row = $db->fetch_assoc($result)){
                $i++;
                ?>
                <div class="row form-group">
                    <div class="col-12">
                        <?php
                        echo $i." - ".$row['Policy_Number']." Start Date: ".$row['Policy_Start_Date']." Expiry: ".$row['Policy_Expiry_Date'];
                        echo " ID: ".$row['Client_ID_Company_Registration']." ".$row['Client_First_Name'];
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row form-group">
                <div class="col-12 text-center">
                    <form action="" method="post">
                        <input type="hidden" value="lapse" id="action" name="action">
                        <input type="submit" class="form-control btn btn-primary"
                               value="Lapse <?php echo $i; ?> Records" style="width: 300px;">
                    </form>
                </div>
            </div>
            <?php
        }

        if ($_POST['action'] == 'lapse'){
            $syn = new ODBCCON('EUROTEST');
            $sySyn = new ODBCCON('SySystem');
            $soeasy = new soeasyClass();
            $soeasy->lapseAllPolicies();
        }
        ?>
    </div>

<?php
$db->show_footer();
?>