<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/2/2019
 * Time: 10:04 ΠΜ
 */

include("../include/main.php");
include('questions_list.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS Introvert Extrovert Test List";

if ($_GET['lid'] == '' || is_numeric($_GET['lid']) == false) {
    header("Location: intro_extro_test_list.php");
    exit();
}

$db->show_header();

$data = $db->query_fetch('SELECT * FROM lcs_intro_extro_test WHERE ietst_intro_extro_test_ID = '.$_GET['lid']);
$tstResult = getIntorExtroResults($data);


?>

    <div class="container">

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center">Test Results & Functions</div>
                </div>

                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                        <div class="row">
                            <div class="col-2 alert alert-info">Όνομα</div>
                            <div class="col-4 alert"><?php echo $data['ietst_name']; ?></div>
                            <div class="col-2 alert alert-info">Κατάσταση</div>
                            <div class="col-4 alert"><?php echo $data['ietst_status']; ?></div>

                        </div>
                        <div class="row">
                            <div class="col-3 alert alert-info">Υψηλη Κυριαρχία</div>
                            <div class="col-3 alert"><?php echo $tstResult['HighDominance']." [".$tstResult['HighDominance-per']."%]";?></div>
                            <div class="col-3 alert alert-info">Υψηλή Κοινωνικότητα</div>
                            <div class="col-3 alert"><?php echo $tstResult['HighSocial']." [".$tstResult['HighSocial-per']."%]";?></div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['HighDominance-per'];?>%"
                                         aria-valuenow="<?php echo $tstResult['HighDominance-per'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br>
                            </div>
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['HighSocial-per'];?>%"
                                         aria-valuenow="<?php echo $tstResult['HighSocial-per'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 alert alert-info">Χαμηλή Κυριαρχία</div>
                            <div class="col-3 alert"><?php echo $tstResult['LowDominance']." [".$tstResult['LowDominance-per']."%]";?></div>
                            <div class="col-3 alert alert-info">Χαμηλή Κοινωνικότητα</div>
                            <div class="col-3 alert"><?php echo $tstResult['LowSocial']." [".$tstResult['LowSocial-per']."%]";?></div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['LowDominance-per'];?>%"
                                         aria-valuenow="<?php echo $tstResult['LowDominance-per'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br>
                            </div>
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['LowSocial-per'];?>%"
                                         aria-valuenow="<?php echo $tstResult['LowSocial-per'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-center">
                            <button type="button" value="Back" style="width: 140px;" class="btn btn-primary" onclick="goBack();">
                                Back
                            </button>
                            <?php
                            if ($data['ietst_status'] == 'Outstanding') {
                                ?>
                                <button type="button" value="Activate" style="width: 140px;" class="btn agrActiveColor" onclick="activateTest();">
                                    Activate
                                </button>
                                <?php
                            }
                            if ($data['agr_status'] == 'Pending') {
                                ?>
                                <button type="button" value="Delete" style="width: 140px;" class="btn agrDeletedColor" onclick="deleteAgreement();">
                                    Delete
                                </button>
                                <?php
                            }
                            if ($data['agr_status'] == 'Active') {
                                ?>
                                <button type="button" value="Cancel" style="width: 150px;" class="btn agrCancelledColor" onclick="cancelAgreement();">
                                    Cancellation
                                </button>
                                <?php
                            }
                            ?>
                            <button type="button" value="Modify" style="width: 150px;" class="btn btn-success" onclick="modifyAgreement();">
                                <?php if ($data['ietst_status'] == 'Pending') echo 'Modify'; else echo 'View'; ?>
                            </button>
                        </p>
                    </div>
                </div>


            </div>

            <div class="col-lg-1"></div>
        </div>
    </div>
<script>
    function activateTest() {
        window.location.assign('intro_extro_test_modify.php?lid=<?php echo $_GET['lid'];?>');
    }
    function modifyAgreement() {
        window.location.assign('intro_extro_test_modify.php?lid=<?php echo $_GET['lid'];?>');
    }
    function goBack() {
        window.location.assign('intro_extro_test_list.php');
    }
</script>
<?php
$db->show_footer();
?>