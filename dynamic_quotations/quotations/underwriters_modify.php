<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/4/2019
 * Time: 1:01 ΜΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "Quotations Underwriters Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Insert new quotations underwriter';
    $db->start_transaction();

    //$_POST['fld_added_field_extra_details'] = $db->get_check_value($_POST['fld_added_field_extra_details']);

    $db->db_tool_insert_row('oqt_quotations_underwriters', $_POST, 'fld_', 0, 'oqun_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Quotation underwriter created');
    header("Location: underwriters.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations underwriter';
    $db->start_transaction();

    //in case of change user
    //check if this user has quotations. if yes do not allow change
    //get current data
    $currentData = $db->query_fetch("SELECT * FROM oqt_quotations_underwriters WHERE oqun_quotations_underwriter_ID = ".$_POST["lid"]);
    $error_found = false;
    if ($currentData['oqun_user_ID'] != $_POST['fld_user_ID']){
        $quotationCheckData = $db->query_fetch('SELECT COUNT(*) as clo_total FROM oqt_quotations WHERE oqq_users_ID = '.$currentData['oqun_user_ID']);

        if ($quotationCheckData['clo_total'] > 0){
            $db->generateAlertError('This user has quotations. Cannot change the user');
            $error_found = true;
        }

    }

    if ($error_found == false) {
        $db->db_tool_update_row('oqt_quotations_underwriters', $_POST, "`oqun_quotations_underwriter_ID` = " . $_POST["lid"], $_POST["lid"],
            'fld_', 'execute', 'oqun_');
        $db->commit_transaction();
        $db->generateSessionAlertSuccess('Quotation underwriter updated');
        header("Location: underwriters.php");
        exit();
    }

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("SELECT * FROM `oqt_quotations_underwriters` WHERE `oqun_quotations_underwriter_ID` = " . $_GET["lid"]);
}

$db->show_header();


include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                                &nbsp;Quotation Underwriter</b>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="fld_user_ID" class="col-sm-4 col-form-label">User</label>
                        <div class="col-sm-5">
                            <select name="fld_user_ID" id="fld_user_ID"
                                    class="form-control"
                                    required>
                                <option value="">Please select User</option>
                                <?php
                                $sql = '
                                    SELECT
                                    *
                                    FROM
                                    users
                                    LEFT OUTER JOIN oqt_quotations_underwriters as und_check ON users.usr_users_ID = und_check.oqun_user_ID
                                    WHERE
                                    oqun_user_ID is NULL ';
                                if ($data['oqun_user_ID'] > 0){
                                    $sql .= 'OR usr_users_ID = '.$data['oqun_user_ID'];
                                }
                                $result = $db->query($sql);
                                while ($user = $db->fetch_assoc($result)) {
                                    ?>
                                    <option
                                            value="<?php echo $user['usr_users_ID'];?>"
                                        <?php if ($data["oqun_user_ID"] == $user['usr_users_ID']) echo "selected=\"selected\""; ?>>
                                        <?php echo $user['usr_name'];?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_user_ID",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidText" => "Select user",
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <select name="fld_status" id="fld_status"
                                    class="form-control"
                                    required>
                                <option value="Active" <?php if ($data["oqun_status"] == 'Active') echo "selected=\"selected\""; ?>>
                                    Active
                                </option>
                                <option value="Inactive" <?php if ($data["oqun_status"] == 'Inactive') echo "selected=\"selected\""; ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Medical For Foreigners</b>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_mf_age_restriction" class="col-sm-4 col-form-label">Age limit Inclusive</label>
                        <div class="col-sm-8">
                            <input name="fld_mf_age_restriction" type="text" id="fld_mf_age_restriction"
                                   class="form-control"
                                   value="<?php echo $data["oqun_mf_age_restriction"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_mf_age_restriction",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidText" => "Must provide a valid age limit",
                            ]);
                            ?>
                        </div>
                    </div>


                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Marine Cargo</b>
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
                                   onclick="window.location.assign('underwriters.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Underwriter"
                                   class="btn btn-secondary">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php
$formValidator->output();
$db->show_footer();
?>