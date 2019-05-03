<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/5/2019
 * Time: 12:01 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');

$db = new Main();
$db->admin_title = "LCS Disc Test Batch Modify";


if ($_POST["action"] == "insert") {
    if ($db->adminLogin == true) {
        $db->check_restriction_area('insert');
    }
    $db->working_section = 'LCS Disc Test Batch Insert';

    $_POST['fld_status'] = 'Outstanding';

    if (checkIfLinkNameIsUnique($_POST['fld_link_name']) == true) {
        $db->db_tool_insert_row('lcs_disc_batch', $_POST, 'fld_', 0, 'lcsdb_');
        header("Location: batches.php");
        exit();
    }
    else {
        $db->generateAlertError('This batch link name already exists.');
        $data['lcsdb_batch_name'] = $_POST['fld_batch_name'];
        $data['lcsdb_max_tests'] = $_POST['fld_max_tests'];
    }

} else if ($_POST["action"] == "update") {

    if ($db->adminLogin == true) {
        $db->check_restriction_area('update');
    }
    $db->working_section = 'LCS Disc Test Batch Modify';

    if (checkIfLinkNameIsUnique($_POST['fld_link_name'],$_POST['lid']) == true) {
        $db->db_tool_update_row('lcs_disc_batch', $_POST, "`lcsdb_disc_batch_ID` = " . $_POST["lid"],
            $_POST["lid"], 'fld_', 'execute', 'lcsdb_');

        header("Location: batches.php");
        exit();
    }
    else {
        $db->generateAlertError('This batch link name already exists.');
        $_GET['lid'] = $_POST['lid'];
    }
}

if ($_GET["lid"] != "") {
    $db->working_section = 'LCS DiSC Test Batch Get data';
    $sql = "SELECT * FROM `lcs_disc_batch` WHERE `lcsdb_disc_batch_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
    $status = $data['lcsdb_status'];

}
else {
    $status = 'Outstanding';
}


$db->show_header();

$formValidator = new customFormValidator();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert headerBar text-center">
                        <b>DiSC Test Batch</b>
                    </div>
                    <div class="container">

                        <div class="form-group row">
                            <label for="fld_status" class="col-sm-3 col-form-label text-right">Status</label>
                            <div class="col-sm-6" style="margin-top: 8px;">
                                <?php echo $status; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_batch_name" class="col-sm-3 col-form-label text-right">Batch Name</label>
                            <div class="col-sm-6">
                                <input name="fld_batch_name" type="text" id="fld_batch_name"
                                       class="form-control"
                                       value="<?php echo $data["lcsdb_batch_name"]; ?>">
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "fld_batch_name",
                                    "fieldDataType" => "text",
                                    "required" => true,
                                    "invalidText" => "Name Required",
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_link_name" class="col-sm-3 col-form-label text-right">Batch Link Name</label>
                            <div class="col-sm-6">
                                <input name="fld_link_name" type="text" id="fld_link_name"
                                       class="form-control"
                                       value="<?php echo $data["lcsdb_link_name"]; ?>">
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "fld_link_name",
                                    "fieldDataType" => "text",
                                    "required" => true,
                                    "invalidText" => "Provide Batch Link Name",
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_max_tests" class="col-sm-3 col-form-label text-right">Max Tests</label>
                            <div class="col-sm-6">
                                <input name="fld_max_tests" type="text" id="fld_max_tests"
                                       class="form-control"
                                       value="<?php echo $data["lcsdb_max_tests"]; ?>">
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "fld_max_tests",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => "Max Tests Required",
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_max_tests" class="col-sm-3 col-form-label text-right">Tests Used</label>
                            <div class="col-sm-6">
                                <?php echo $data["lcsdb_used_tests"]; ?>
                            </div>
                        </div>


                        <!-- BUTTONS -->
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-8">
                                <input name="action" type="hidden" id="action"
                                       value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                                <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                                <input type="button" value="Back" class="btn btn-secondary"
                                       onclick="window.location.assign('batches.php')">
                                <input type="submit" name="Submit" id="Submit"
                                       value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Batch"
                                       class="btn btn-secondary">
                            </div>
                        </div>

                </form>
            </div>
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
        </div>
    </div>
<?php
$formValidator->output();
$db->show_footer();

function checkIfLinkNameIsUnique($linkName, $ignoreID = 0){
    global $db;

    $sql = "SELECT COUNT(*) as clo_total FROM lcs_disc_batch WHERE lcsdb_link_name = '".$linkName."'";
    if ($ignoreID > 0){
        $sql .= " AND lcsdb_disc_batch_ID != ".$ignoreID;
    }
    $check = $db->query_fetch($sql);
    if ($check['clo_total'] > 0){
        return false;
    }
    else {
        return true;
    }

}
?>