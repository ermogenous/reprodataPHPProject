<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/2/2019
 * Time: 3:37 ΜΜ
 */

include("../include/main.php");
include('questions_list.php');
include('disc_class.php');

if ($_GET['lg'] == 'tr') {
    $db = new Main();
    $section = 'admin';
} else {
    $db = new Main(0);
    $lidEncrypt = $_GET['lid'];
    $_GET['lid'] = $db->decrypt($_GET['lid']);
    $section = 'public';

    //check if lid is provided
    if ($_GET['lid'] == ''){
        //if not provided then either not allowed or is in batch mode
        if ($_GET['bt'] == ''){
            //no batch was specified then not allowed in here
            header('Location: ../home.php');
            exit();
        }
        else {
            //this is in batch mode.
            //get the batch info
            $batchData = $db->query_fetch("SELECT * FROM lcs_disc_batch WHERE lcsdb_link_name = '".$_GET['bt']."'");
            if ($batchData['lcsdb_disc_batch_ID'] == ''){
                //no batch found. then exit
                header('Location: ../home.php');
                exit();
            }

            //first check if there is a cookie present.
            if ($_COOKIE['LCSDISCBATCH-ID'] > 0){
                //this user has already created a test.
                //retrieve the test to check if not completed.
                $sql = "SELECT * FROM `lcs_disc_test` WHERE `lcsdc_disc_test_ID` = " . $_COOKIE['LCSDISCBATCH-ID'];
                $DiscDataFromCookie = $db->query_fetch($sql);
                if ($DiscDataFromCookie['lcsdc_status'] == 'Outstanding') {
                    //redirect him to continue his test
                    header("Location: disc_modify.php?lid=" . $db->encrypt($_COOKIE['LCSDISCBATCH-ID']) . "&page=" . $_COOKIE['LCSDISCBATCH-PAGE']);
                    exit();
                }
                //the test is completed. redirect to home
                else {
                    header('Location: ../home.php');
                    exit();
                }
            }
            //check if max tests are reached
            if ($batchData['lcsdb_used_tests'] >= $batchData['lcsdb_max_tests']) {
                header('Location: ../home.php');
                exit();
            }
            //proceed
            $batchName = " For ".$batchData['lcsdb_batch_name'];
            $batchID = $batchData['lcsdb_disc_batch_ID'];

        }
    }

}
$db->admin_title = "LCS Disc Test Modify";


if ($_POST["action"] == "insert") {
    if ($db->adminLogin == true) {
        $db->check_restriction_area('insert');
    }
    $db->start_transaction();
    $db->working_section = 'LCS Disc Test Insert';

    $_POST['fld_status'] = 'Outstanding';

    //check for the batch
    if ($_POST['batchID'] > 0){
        $_POST['fld_batch_ID'] = $_POST['batchID'];
        //update the batch
        $batchData = $db->query_fetch("SELECT * FROM lcs_disc_batch WHERE lcsdb_disc_batch_ID = ".$_POST['batchID']);
        $sql = "UPDATE lcs_disc_batch SET lcsdb_used_tests = ".($batchData['lcsdb_used_tests'] +1)." WHERE lcsdb_disc_batch_ID = ".$_POST['batchID'];
        $db->query($sql);
    }

    $newID = $db->db_tool_insert_row('lcs_disc_test', $_POST, 'fld_', 1, 'lcsdc_');

    if ($_POST['batchID'] > 0){
        //create a cookie to limit this user to one test and also if he tries the link again to continue where he left of.
        setcookie('LCSDISCBATCH-ID', $newID, time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('LCSDISCBATCH-PAGE', 2, time() + (86400 * 30), "/"); // 86400 = 1 day
    }
    $db->commit_transaction();

    //go to page 2 of the new batch test
    if ($_POST['batchID'] > 0){
        header("Location: disc_modify.php?lid=" . $db->encrypt($newID) . "&page=2");
        exit();
    }
    else {
        header("Location: disc_list.php");
        exit();
    }

}
else if ($_POST["action"] == "update") {

    if ($db->adminLogin == true) {
        $db->check_restriction_area('update');
    }
    $db->working_section = 'LCS Disc Test Modify';

    $db->db_tool_update_row('lcs_disc_test', $_POST, "`lcsdc_disc_test_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'lcsdc_');

    //check if the test is completed
    $disc = new DiscTest($_POST['lid']);
    if ($disc->verifyCompletion() == true && $section == 'public'){
        $disc->statusToCompleted();
    }
    else {

    }



    if ($section == 'admin') {
        header("Location: disc_list.php");
        exit();
    } else {
        if ($_GET['page'] == '') {
            $page = 1;
        } else {
            $page = ($_GET['page'] * 1);
        }
        $page++;

        //check if is from batch and update the cookie
        if ($_POST['discBatchID'] > 0){
            setcookie('LCSDISCBATCH-PAGE', $page, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
        header("Location: disc_modify.php?lid=" . $db->encrypt($_GET['lid']) . "&page=" . $page);
        exit();

    }


}

if ($_GET["lid"] != "") {
    $db->working_section = 'LCS DiSC Test Get data';
    $sql = "SELECT * FROM `lcs_disc_test` WHERE `lcsdc_disc_test_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

    if ($section == 'public'){

        //check if the test is completed
        if ($data['lcsdc_status'] != 'Outstanding' && $_GET['page'] != 4){
            header("Location: ../login.php");
            exit();
        }

    }


} else {

}


$db->show_header();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <input type="hidden" name="batchID" id="batchID" value="<?php echo $batchID;?>">
                    <input type="hidden" name="discBatchID" id="discBatchID" value="<?php echo $data['lcsdc_batch_ID'];?>">

                    <div class="alert headerBar text-center">
                        <b>DiSC Test<?php echo $batchName;?></b>
                    </div>
                    <?php if ($_GET['page'] == '' || $_GET['page'] == 1) { ?>
                        <div class="container">

                            <div class="form-group row">
                                <label for="fld_name" class="col-sm-3 col-form-label text-right">Όνομα</label>
                                <div class="col-sm-6">
                                    <input name="fld_name" type="text" id="fld_name"
                                           class="form-control"
                                           value="<?php echo $data["lcsdc_name"]; ?>"
                                           required
                                        <?php echo makeDisable(); ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_email" class="col-sm-3 col-form-label text-right">Email</label>
                                <div class="col-sm-6">
                                    <input name="fld_email" type="text" id="fld_email"
                                           class="form-control"
                                           value="<?php echo $data["lcsdc_email"]; ?>"
                                           required
                                        <?php echo ifRequired(); ?>
                                        <?php echo makeDisable(); ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_company_name" class="col-sm-3 col-form-label text-right">Ονομα Εταιρείας</label>
                                <div class="col-sm-6">
                                    <input name="fld_company_name" type="text" id="fld_company_name"
                                           class="form-control"
                                           value="<?php echo $data["lcsdc_company_name"]; ?>"
                                        <?php echo makeDisable(); ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_tel" class="col-sm-3 col-form-label text-right">Τηλέφωνο</label>
                                <div class="col-sm-6">
                                    <input name="fld_tel" type="text" id="fld_tel"
                                           class="form-control"
                                           value="<?php echo $data["lcsdc_tel"]; ?>"
                                        <?php echo makeDisable(); ?>>
                                </div>
                            </div>

                            <?php if ($section == 'admin') { ?>
                            <div class="form-group row">
                                <label for="fld_process_status" class="col-sm-3 col-form-label text-right">Process
                                    Status</label>
                                <div class="col-sm-6">
                                    <select name="fld_process_status" id="fld_process_status"
                                            class="form-control"
                                            required>
                                        <option value="UnPaid" <?php if ($data['lcsdc_process_status'] == 'UnPaid') echo 'selected'; ?>>
                                            UnPaid
                                        </option>
                                        <option value="Paid" <?php if ($data['lcsdc_process_status'] == 'Paid') echo 'selected'; ?>>
                                            Paid
                                        </option>
                                        <option value="Free" <?php if ($data['lcsdc_process_status'] == 'Free') echo 'selected'; ?>>
                                            Free
                                        </option>
                                        <option value="Package" <?php if ($data['lcsdc_process_status'] == 'Free') echo 'selected'; ?>>
                                            Package
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <div class="row">
                            <div class="col-12 text-center" style="height: 45px;">
                                <?php if (($data['lcsdc_status'] == 'Outstanding'
                                        || $data['lcsdc_status'] == 'Link'
                                        || $_GET['lid'] == '')

                                        && ($_GET['page'] == '' || $_GET['page'] != 4)
                                        && $section == 'admin'
                                    ) { ?>
                                    <input type="submit" name="Submit" id="Submit"
                                           value="<?php if ($_GET["lid"] == "") echo "Καταχώρησε"; else echo "Συνέχεια"; ?>"
                                           class="btn btn-secondary" onclick="submitForm()">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <b>OΔΗΓΙΕΣ:</b> Απαντήστε αυθόρμητα, χωρίς πολλή σκέψη. Αυτό το οποίο κάνετε,
                                ΟΧΙ αυτό το οποίο θα θέλατε να κάνετε. Σε κάθε ερώτηση επιλέξετε μια εκ των δυο επίλογων.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="height: 10px;"></div>
                        </div>


                        <?php
                    }
                    foreach ($list as $num => $item) {

                        if ($section == 'admin') {
                            $start = 0;
                            $end = 30;
                        } else if ($_GET['page'] == '' || $_GET['page'] == 1) {
                            $start = 0;
                            $end = 10;
                        } else if ($_GET['page'] == 2) {
                            $start = 11;
                            $end = 20;
                        } else if ($_GET['page'] == 3) {
                            $start = 21;
                            $end = 30;
                        }


                        if ($num >= $start && $num <= $end) {
                            ?>

                            <div class="row">
                                <div class="col-12" style="height: 10px;"></div>
                            </div>

                            <!-- QUESTION 1 -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Ερώτηση <?php echo $num; ?></h5>
                                    <div class="card-text">
                                        <div class="row custom-control custom-radio">
                                            <input type="radio"
                                                   id="fld_question_<?php echo $num; ?>a"
                                                   name="fld_question_<?php echo $num; ?>"
                                                   class="custom-control-input"
                                                   value="A"
                                                <?php echo ifRequired(); ?>
                                                <?php echo makeDisable(); ?>
                                                <?php if ($data['lcsdc_question_' . $num] == 'A') echo 'checked="checked"'; ?>>
                                            <label for="fld_question_<?php echo $num; ?>a"
                                                   class="custom-control-label">
                                                <?php echo $item['A']; ?>
                                            </label>
                                        </div>
                                        <div class="row custom-control custom-radio">
                                            <input type="radio"
                                                   id="fld_question_<?php echo $num; ?>b"
                                                   name="fld_question_<?php echo $num; ?>"
                                                   class="custom-control-input"
                                                   value="B"
                                                <?php echo ifRequired(); ?>
                                                <?php echo makeDisable(); ?>
                                                <?php if ($data['lcsdc_question_' . $num] == 'B') echo 'checked="checked"'; ?>>
                                            <label for="fld_question_<?php echo $num; ?>b"
                                                   class="custom-control-label">
                                                <?php echo $item['B']; ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="height: 10px;"></div>
                            </div>
                        <?php }
                    }
                    if ($_GET['page'] == 4) {
                        ?>


                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    Ευχαριστούμε για τον χρόνο σας.<br>
                                    Παρακαλώ όπως επικοινωνήσετε μαζί μας για τα αποτελέσματα σας.<br><br>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">

                            <?php if ($section == 'admin') { ?>
                                <input type="button" value="Πίσω" class="btn btn-secondary"
                                       onclick="window.location.assign('disc_list.php')">
                            <?php } ?>

                            <?php if (($data['lcsdc_status'] == 'Outstanding' || $data['lcsdc_status'] == 'Link' || $_GET['lid'] == '') && ($_GET['page'] == '' || $_GET['page'] != 4)) { ?>
                                <input type="submit" name="Submit" id="Submit"
                                       value="<?php if ($_GET["lid"] == "") echo "Καταχώρησε"; else echo "Συνέχεια"; ?>"
                                       class="btn btn-secondary" onclick="submitForm()">
                            <?php } ?>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
        </div>
    </div>
    <script>
        function submitForm() {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                document.getElementById('Submit').disabled = true;
                $('#myForm').submit();
            }
        }
    </script>
<?php
function makeDisable()
{
    global $data;
    if ($data['lcsdc_status'] == 'Outstanding' || $data['lcsdc_status'] == 'Link' || $_GET['lid'] == '') {
        return '';
    } else {
        return 'disabled';
    }
}

function ifRequired()
{
    global $db;
    if ($db->user_data['usr_user_rights'] < 5 && $db->user_data['usr_user_rights'] != '') {
        return '';
    } else {
        return 'required';
    }
}

$db->show_footer();
?>