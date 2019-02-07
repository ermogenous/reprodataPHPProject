<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/2/2019
 * Time: 3:37 ΜΜ
 */

include("../include/main.php");
include('questions_list.php');
$db = new Main();
$db->admin_title = "LCS Introvert Extrovert Test Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'LCS Introvert Extrovert Test Insert';

    $_POST['fld_status'] = 'Outstanding';

    $db->db_tool_insert_row('lcs_intro_extro_test', $_POST, 'fld_', 0, 'ietst_');
    header("Location: intro_extro_test_list.php");
    exit();

    print_r($_POST);

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'LCS Introvert Extrovert Test Modify';

    $db->db_tool_update_row('lcs_intro_extro_test', $_POST, "`ietst_intro_extro_test_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'ietst_');
    header("Location: intro_extro_test_list.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'LCS Introvert Extrovert Test Get data';
    $sql = "SELECT * FROM `lcs_intro_extro_test` WHERE `ietst_intro_extro_test_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {

}


$db->show_header();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;LCS Introvert Extrovert Test</b>
                    </div>

                    <div class="container">
                        <div class="form-group row">
                            <label for="fld_name" class="col-sm-3 col-form-label text-right">Όνομα</label>
                            <div class="col-sm-6">
                                <input name="fld_name" type="text" id="fld_name"
                                       class="form-control"
                                       value="<?php echo $data["ietst_name"]; ?>"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fld_tel" class="col-sm-3 col-form-label text-right">Τηλέφωνο</label>
                            <div class="col-sm-6">
                                <input name="fld_tel" type="text" id="fld_tel"
                                       class="form-control"
                                       value="<?php echo $data["ietst_tel"]; ?>"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fld_email" class="col-sm-3 col-form-label text-right">Email</label>
                            <div class="col-sm-6">
                                <input name="fld_email" type="text" id="fld_email"
                                       class="form-control"
                                       value="<?php echo $data["ietst_email"]; ?>"
                                       required>
                            </div>
                        </div>
                    </div>

                    <?php

                    foreach ($list as $num => $item){
                        if ($num < 36) {
                    ?>
                    <!-- QUESTION 1 -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ερώτηση <?php echo $num;?></h5>
                            <div class="card-text">
                                <div class="row custom-control custom-radio">
                                    <input type="radio"
                                           id="fld_question_<?php echo $num;?>a"
                                           name="fld_question_<?php echo $num;?>"
                                           class="custom-control-input"
                                           value="A" required
                                           <?php if ($data['ietst_question_'.$num] == 'A') echo 'checked="checked"';?>>
                                    <label for="fld_question_<?php echo $num;?>a"
                                           class="custom-control-label">
                                        <?php echo $item['A'];?>
                                    </label>
                                </div>
                                <div class="row custom-control custom-radio">
                                    <input type="radio"
                                           id="fld_question_<?php echo $num;?>b"
                                           name="fld_question_<?php echo $num;?>"
                                           class="custom-control-input"
                                           value="B" required
                                        <?php if ($data['ietst_question_'.$num] == 'B') echo 'checked="checked"';?>>
                                    <label for="fld_question_<?php echo $num;?>b"
                                           class="custom-control-label">
                                        <?php echo $item['B'];?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                            <div class="row">
                                <div class="col-12" style="height: 10px;"></div>
                            </div>
                    <?php }} ?>


                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Πίσω" class="btn btn-secondary"
                                   onclick="window.location.assign('manufacturers.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Καταχώρησε"; else echo "Αλλαγή στης"; ?> Επιλογές"
                                   class="btn btn-secondary" onclick="submitForm()">
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
                document.getElementById('Submit').disabled = true
            }
        }
    </script>
<?php
$db->show_footer();
?>