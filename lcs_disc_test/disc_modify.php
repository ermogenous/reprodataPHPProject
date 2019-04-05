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

}
$db->admin_title = "LCS Disc Test Modify";


if ($_POST["action"] == "insert") {
    if ($db->adminLogin == true) {
        $db->check_restriction_area('insert');
    }
    $db->working_section = 'LCS Disc Test Insert';

    $_POST['fld_status'] = 'Outstanding';

    $db->db_tool_insert_row('lcs_disc_test', $_POST, 'fld_', 0, 'lcsdc_');
    header("Location: disc_list.php");
    exit();

} else if ($_POST["action"] == "update") {

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
                    <div class="alert headerBar text-center">
                        <b>DiSC Test</b>
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
                                <label for="fld_tel" class="col-sm-3 col-form-label text-right">Τηλέφωνο</label>
                                <div class="col-sm-6">
                                    <input name="fld_tel" type="text" id="fld_tel"
                                           class="form-control"
                                           value="<?php echo $data["lcsdc_tel"]; ?>"
                                        <?php echo makeDisable(); ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fld_email" class="col-sm-3 col-form-label text-right">Email</label>
                                <div class="col-sm-6">
                                    <input name="fld_email" type="text" id="fld_email"
                                           class="form-control"
                                           value="<?php echo $data["lcsdc_email"]; ?>"
                                        <?php echo ifRequired(); ?>
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