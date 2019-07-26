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

    $_POST['fld_allow_quotations'] = '#1-'.$db->get_check_value($_POST['allow_mff'])."#";
    $_POST['fld_allow_quotations'] .= '#2-'.$db->get_check_value($_POST['allow_mc'])."#";

    $db->db_tool_insert_row('oqt_quotations_underwriters', $_POST, 'fld_', 0, 'oqun_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Quotation underwriter created');
    header("Location: underwriters.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations underwriter';
    $db->start_transaction();

    $_POST['fld_allow_quotations'] = '#1-'.$db->get_check_value($_POST['allow_mff'])."#";
    $_POST['fld_allow_quotations'] .= '#2-'.$db->get_check_value($_POST['allow_mc'])."#";

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
            <div class="col-lg-1 col-md-3 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-6 col-xs-12 col-sm-12">
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
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_status",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidText" => "Select Status",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Medical For Foreigners</b>
                        </div>
                    </div>

                    <div class="row">
                        <label for="allow_mff" class="col-sm-4 col-form-label">
                            Allow Medical For Foreigners
                        </label>
                        <div class="col-sm-1">
                            <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                   id="allow_mff" name="allow_mff"
                                <?php if (strpos($data['oqun_allow_quotations'],'#1-1#') !== false) echo 'checked'; ?>>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_mf_age_restriction" class="col-sm-4 col-form-label">Age limit Inclusive</label>
                        <div class="col-sm-4">
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

                    <div class="row">
                        <label for="allow_mc" class="col-sm-4 col-form-label">
                            Allow Marine Cargo
                        </label>
                        <div class="col-sm-1">
                            <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                   id="allow_mc" name="allow_mc"
                                <?php if (strpos($data['oqun_allow_quotations'],'#2-1#') !== false) echo 'checked'; ?>>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_open_cover_number" class="col-sm-4 col-form-label">Open Cover Number</label>
                        <div class="col-sm-8">
                            <input name="fld_open_cover_number" type="text" id="fld_open_cover_number"
                                   class="form-control"
                                   value="<?php echo $data["oqun_open_cover_number"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_open_cover_number",
                                "fieldDataType" => "text",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <?php

                    //default excesses
                    $defExcGeneralCargo = $data["oqun_excess_general_cargo"] == '' ? 'Deductible €150 each and every loss.' : $data["oqun_excess_general_cargo"];
                    $defExcVehicles = $data["oqun_excess_vehicles"] == '' ? 'Deductible €250 or 5% of the total sum insured whichever is greater each and every loss.' : $data["oqun_excess_vehicles"];
                    $defExcMachinery = $data["oqun_excess_machinery"] == '' ? 'Deductible €150 each and every loss.' : $data["oqun_excess_machinery"];
                    $defExcTempNoMeat = $data["oqun_excess_temp_no_meat"] == '' ? 'Deductible €250 or 5% of the total sum insured whichever is greater each and every loss.' : $data["oqun_excess_temp_no_meat"];
                    $defExcTempMeat = $data["oqun_excess_temp_meat"] == '' ? 'Deductible €250 or 5% of the total sum insured whichever is greater each and every loss.' : $data["oqun_excess_temp_meat"];
                    $defExcSpecialCover = $data["oqun_excess_special_cover"] == '' ? 'Deductible €250 or 1% of the total sum insured whichever is greater each and every loss.' : $data["oqun_excess_special_cover"];
                    $defExcProPacked = $data["oqun_excess_pro_packed"] == '' ? 'Deductible €250 or 5% of the total sum insured whichever is greater each and every loss.' : $data["oqun_excess_pro_packed"];
                    $defExcOwnerPacked = $data["oqun_excess_owner_packed"] == '' ? 'Deductible €250 or 5% of the total sum insured whichever is greater each and every loss.' : $data["oqun_excess_owner_packed"];
                    $defExcOther = $data["oqun_excess_general_cargo"] == '' ? '' : $data["oqun_excess_general_cargo"];

                    ?>

                    <div class="form-group row">
                        <label for="fld_excess_general_cargo" class="col-sm-5 col-form-label">Excess General Cargo & Merchandise</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_general_cargo" type="text" id="fld_excess_general_cargo"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcGeneralCargo; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_general_cargo",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_vehicles" class="col-sm-5 col-form-label">Excess New/Used Vehicles</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_vehicles" type="text" id="fld_excess_vehicles"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcVehicles; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_vehicles",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_machinery" class="col-sm-5 col-form-label">Excess Machinery</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_machinery" type="text" id="fld_excess_machinery"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcMachinery; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_machinery",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_temp_no_meat" class="col-sm-5 col-form-label">Excess Temp.Controlled Cargo other than meat</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_temp_no_meat" type="text" id="fld_excess_temp_no_meat"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcTempNoMeat; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_temp_no_meat",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_temp_meat" class="col-sm-5 col-form-label">Excess Temp.Controlled Cargo meat</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_temp_meat" type="text" id="fld_excess_temp_meat"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcTempMeat; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_temp_meat",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_special_cover" class="col-sm-5 col-form-label">Excess Special Cover Mobile Phones, Electronic Equipment</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_special_cover" type="text" id="fld_excess_special_cover"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcSpecialCover; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_special_cover",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_pro_packed" class="col-sm-5 col-form-label">Excess Personal Effects professionally packed</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_pro_packed" type="text" id="fld_excess_pro_packed"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcProPacked; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_pro_packed",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_owner_packed" class="col-sm-5 col-form-label">Excess Personal Effects owner packed</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_owner_packed" type="text" id="fld_excess_owner_packed"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcOwnerPacked; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_owner_packed",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_excess_other" class="col-sm-5 col-form-label">Excess Other</label>
                        <div class="col-sm-7">
                            <input name="fld_excess_other" type="text" id="fld_excess_other"
                                   class="form-control" maxlength="100"
                                   value="<?php echo $defExcOther; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_excess_other",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Must provide excess",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_show_excess_replace" class="col-sm-5 col-form-label">Allow Excess Replace</label>
                        <div class="col-sm-7">
                            <select name="fld_show_excess_replace" id="fld_show_excess_replace"
                                   class="form-control">
                                <option value="0" <?php if ($data['oqun_show_excess_replace'] == '0')echo 'selected';?>>No</option>
                                <option value="1" <?php if ($data['oqun_show_excess_replace'] == '1')echo 'selected';?>>Yes</option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_show_excess_replace",
                                "fieldDataType" => "select"
                            ]);
                            ?>
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