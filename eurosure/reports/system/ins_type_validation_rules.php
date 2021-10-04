<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 7/9/2021
 * Time: 10:51 π.μ.
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Synthesis Reports - System - InsTypes Reports";

if ($_GET['lid'] == '') {
    header("Location: ins_type_reports.php");
    exit();
}
$sybase = new ODBCCON();
$sql = 'SELECT * FROM ininsurancetypes WHERE inity_insurance_type_serial = ' . $_GET['lid'];
$insTypeData = $sybase->query_fetch($sql);


$db->show_header();

?>

<div class="container">
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center">
            Validation Rules
            For <?php echo $insTypeData['inity_insurance_type'] . " " . $insTypeData['inity_long_description']; ?>
        </div>
    </div>
    <div class="row form-group">
        <label class="col-form-label col-2">Show SQL</label>
        <div class="col-2">
            <?php
            if ($_GET['showSql'] == ''){
                $_GET['showSql'] = 'yes';
            }
            ?>
            <select id="showSql" name="showSql" class="form-control" onchange="changeUrl()">
                <option value="yes" <?php if ($_GET['showSql'] == 'yes') echo 'selected';?>>Yes</option>
                <option value="no" <?php if ($_GET['showSql'] == 'no') echo 'selected';?>>No</option>
            </select>
            <script>
                function changeUrl(){
                    let lid = <?php echo $_GET['lid'];?>;
                    let option = $('#showSql').val();
                    console.log(option);
                    window.location.assign('ins_type_validation_rules.php?lid=' + lid + '&showSql=' + option);
                }
            </script>
        </div>
    </div>
    <?php
    $sql = "SELECT * FROM ininsurancetypevalidationrules WHERE initvr_insurance_type_serial = " . $_GET['lid'] . " ORDER BY initvr_auto_serial ASC";
    $result = $sybase->query($sql);
    while ($row = $sybase->fetch_assoc($result)) {


        ?>
        <div class="row">
            <div class="col-1"><?php echo $row['initvr_auto_serial']; ?></div>
            <div class="col-1">Status:<?php echo $row['initvr_status_flag']; ?></div>
            <div class="col-4"><b><?php echo $row['initvr_rule_description']; ?></b></div>
        </div>
        <div class="row">
            <div class="col">
                Error Message: <b><?php echo $row['initvr_error_message'];?></b>
            </div>
        </div>
        <?php
        if ($_GET['showSql'] == 'yes'){
        ?>

        <div class="row">
            <div class="col alert alert-secondary">
                <?php echo $db->prepare_text_as_html($row['initvr_rule_sql']);?>
            </div>
        </div>
            <?php
        }
            ?>
            <div class="row">
            <div class="col"><hr></div>
        </div>

        <?php
    }//while
    ?>
</div>
<?php
$db->show_footer();
?>
