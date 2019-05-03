<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/5/2019
 * Time: 1:32 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test Batch Link";

if ($_GET['lid'] > 0){
    $data = $db->query_fetch('SELECT * FROM lcs_disc_batch WHERE lcsdb_disc_batch_ID = '.$_GET['lid']);
    $link = $main['site_url']."/lcs_disc_test/disc_modify.php?bt=".$data['lcsdb_link_name'];
}
else {
    header("Location: batches.php");
    exit();
}

$db->show_header();
?>

<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="row">
                <div class="col-12 alert alert-danger text-center">
                    Link For Batch: <?php echo $data['lcsdb_batch_name'];?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    LINK:<br> <?php echo $link;?>
                </div>
            </div>
            <div class="row" style="height: 35px;">

            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" onclick="window.location.assign('batches.php');" class="btn btn-secondary">Back</button>
                </div>
            </div>
        </div>


        <div class="col-2"></div>
    </div>
</div>

<?php
$db->show_footer();
?>
