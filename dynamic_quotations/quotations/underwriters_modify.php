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

    $_POST['fld_allow_quotations'] = '#1-' . $db->get_check_value($_POST['allow_mff']) . "#";
    $_POST['fld_allow_quotations'] .= '#2-' . $db->get_check_value($_POST['allow_mc']) . "#";
    $_POST['fld_allow_quotations'] .= '#3-' . $db->get_check_value($_POST['allow_tr']) . "#";
    $_POST['fld_allow_quotations'] .= '#4-' . $db->get_check_value($_POST['allow_hc']) . "#";


    $db->db_tool_insert_row('oqt_quotations_underwriters', $_POST, 'fld_', 0, 'oqun_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Quotation underwriter created');
    header("Location: underwriters.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations underwriter';
    $db->start_transaction();

    $_POST['fld_allow_quotations'] = '#1-' . $db->get_check_value($_POST['allow_mff']) . "#";
    $_POST['fld_allow_quotations'] .= '#2-' . $db->get_check_value($_POST['allow_mc']) . "#";
    $_POST['fld_allow_quotations'] .= '#3-' . $db->get_check_value($_POST['allow_tr']) . "#";
    $_POST['fld_allow_quotations'] .= '#4-' . $db->get_check_value($_POST['allow_hc']) . "#";

    $_POST['fld_tr_package_selection'] = '';
    if ($_POST['packageBasic'] == 1) {
        $_POST['fld_tr_package_selection'] = '#basic#';
    }
    if ($_POST['packageStandard'] == 1) {
        $_POST['fld_tr_package_selection'] .= '#standard#';
    }
    if ($_POST['packageLuxury'] == 1) {
        $_POST['fld_tr_package_selection'] .= '#luxury#';
    }
    if ($_POST['packageSpecial'] == 1) {
        $_POST['fld_tr_package_selection'] .= '#special#';
    }
    if ($_POST['packageSchengen'] == 1) {
        $_POST['fld_tr_package_selection'] .= '#schengen#';
    }
    if ($_POST['packageLimited'] == 1) {
        $_POST['fld_tr_package_selection'] .= '#limited#';
    }

    //in case of change user
    //check if this user has quotations. if yes do not allow change
    //get current data
    $currentData = $db->query_fetch("SELECT * FROM oqt_quotations_underwriters WHERE oqun_quotations_underwriter_ID = " . $_POST["lid"]);
    $error_found = false;
    if ($currentData['oqun_user_ID'] != $_POST['fld_user_ID']) {
        $quotationCheckData = $db->query_fetch('SELECT COUNT(*) as clo_total FROM oqt_quotations WHERE oqq_users_ID = ' . $currentData['oqun_user_ID']);

        if ($quotationCheckData['clo_total'] > 0) {
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

    <div class="container-fluid">
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
                                    class="form-control">
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
                                if ($data['oqun_user_ID'] > 0) {
                                    $sql .= 'OR usr_users_ID = ' . $data['oqun_user_ID'];
                                }
                                $result = $db->query($sql);
                                while ($user = $db->fetch_assoc($result)) {
                                    ?>
                                    <option
                                            value="<?php echo $user['usr_users_ID']; ?>"
                                        <?php if ($data["oqun_user_ID"] == $user['usr_users_ID']) echo "selected=\"selected\""; ?>>
                                        <?php echo $user['usr_name']; ?>
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
                                    class="form-control">
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

                    <div class="row form-group">
                        <label for="fld_view_group_ID" class="col-sm-4 col-form-label">
                            Can also view everything under this group
                        </label>
                        <div class="col-sm-3">
                            <select name="fld_view_group_ID" id="fld_view_group_ID"
                                    class="form-control">
                                <option value="0" <?php if ($data["oqun_view_group_ID"] == '0' || $data["oqun_view_group_ID"] == '') echo "selected=\"selected\""; ?>>
                                    None
                                </option>
                                <?php
                                $sql = "SELECT * FROM users_groups WHERE usg_active = 1 AND usg_users_groups_ID > 2 ORDER BY usg_group_name ASC";
                                $result = $db->query($sql);
                                while ($group = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $group['usg_users_groups_ID'];?>" <?php if ($data["oqun_view_group_ID"] == $group['usg_users_groups_ID']) echo "selected=\"selected\""; ?>>
                                        <?php echo $group['usg_group_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_view_group_ID",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            This underwriter will be able to see quotations of users under this group
                        </div>
                    </div>


                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="pills-medical-tab" data-toggle="pill" href="#pills-medical"
                               role="tab"
                               aria-controls="pills-medical" aria-selected="true">Medical For Foreigners</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-marine-tab" data-toggle="pill" href="#pills-marine"
                               role="tab"
                               aria-controls="pills-marine" aria-selected="true">Marine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-travel-tab" data-toggle="pill" href="#pills-travel"
                               role="tab"
                               aria-controls="pills-travel" aria-selected="true">Travel</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-household-tab" data-toggle="pill" href="#pills-household"
                               role="tab"
                               aria-controls="pills-household" aria-selected="true">Household</a>
                        </li>

                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-medical" role="tabpanel"
                             aria-labelledby="pills-medical-tab">
                            <!-- MEDICAL FOR FOREIGNERS -->

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
                                        <?php if (strpos($data['oqun_allow_quotations'], '#1-1#') !== false) echo 'checked'; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_mf_age_restriction" class="col-sm-4 col-form-label">Age limit
                                    Inclusive</label>
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
                        </div>

                        <div class="tab-pane fade show" id="pills-marine" role="tabpanel"
                             aria-labelledby="pills-marine-tab">
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
                                        <?php if (strpos($data['oqun_allow_quotations'], '#2-1#') !== false) echo 'checked'; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_open_cover_number" class="col-sm-4 col-form-label">Open Cover
                                    Number</label>
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
                                <label for="fld_excess_general_cargo" class="col-sm-5 col-form-label">Excess General
                                    Cargo &
                                    Merchandise</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_general_cargo_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_general_cargo_rate" type="text"
                                           id="fld_excess_general_cargo_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_general_cargo_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_general_cargo_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_vehicles" class="col-sm-5 col-form-label">Excess New/Used
                                    Vehicles</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_vehicles_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_vehicles_rate" type="text"
                                           id="fld_excess_vehicles_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_vehicles_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_vehicles_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_machinery" class="col-sm-5 col-form-label">Excess
                                    Machinery</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_machinery_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_machinery_rate" type="text"
                                           id="fld_excess_machinery_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_machinery_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_machinery_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_temp_no_meat" class="col-sm-5 col-form-label">Excess
                                    Temp.Controlled
                                    Cargo other than meat</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_temp_no_meat_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_temp_no_meat_rate" type="text"
                                           id="fld_excess_temp_no_meat_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_temp_no_meat_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_temp_no_meat_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_temp_meat" class="col-sm-5 col-form-label">Excess Temp.Controlled
                                    Cargo
                                    meat</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_temp_meat_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_temp_meat_rate" type="text"
                                           id="fld_excess_temp_meat_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_temp_meat_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_temp_meat_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_special_cover" class="col-sm-5 col-form-label">Excess Special
                                    Cover
                                    Mobile Phones, Electronic Equipment</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_special_cover_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_special_cover_rate" type="text"
                                           id="fld_excess_special_cover_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_special_cover_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_special_cover_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_pro_packed" class="col-sm-5 col-form-label">Excess Personal
                                    Effects
                                    professionally packed</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_pro_packed_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_pro_packed_rate" type="text"
                                           id="fld_excess_pro_packed_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_pro_packed_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_pro_packed_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_owner_packed" class="col-sm-5 col-form-label">Excess Personal
                                    Effects
                                    owner packed</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_owner_packed_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_owner_packed_rate" type="text"
                                           id="fld_excess_owner_packed_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_owner_packed_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_general_cargo_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_excess_other" class="col-sm-5 col-form-label">Excess Other</label>
                                <div class="col-sm-5">
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

                                <label for="fld_excess_other_rate" class="col-xl-1">Rate</label>
                                <div class="col-xl-1">
                                    <input name="fld_excess_other_rate" type="text"
                                           id="fld_excess_other_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_excess_other_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_excess_general_cargo_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="fld_icc_c_rate" class="col-xl-5">ICC C Rate</label>
                                <div class="col-xl-2">
                                    <input name="fld_icc_c_rate" type="text"
                                           id="fld_icc_c_rate"
                                           class="form-control"
                                           value="<?php echo $data['oqun_icc_c_rate']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_icc_c_rate",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidText" => "Provide rate",
                                    ]);
                                    ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="fld_show_excess_replace" class="col-sm-5 col-form-label">Allow Excess
                                    Replace</label>
                                <div class="col-sm-2">
                                    <select name="fld_show_excess_replace" id="fld_show_excess_replace"
                                            class="form-control">
                                        <option value="0" <?php if ($data['oqun_show_excess_replace'] == '0') echo 'selected'; ?>>
                                            No
                                        </option>
                                        <option value="1" <?php if ($data['oqun_show_excess_replace'] == '1') echo 'selected'; ?>>
                                            Yes
                                        </option>
                                    </select>
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_show_excess_replace",
                                        "fieldDataType" => "select"
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="pills-travel" role="tabpanel"
                             aria-labelledby="pills-travel-tab">
                            <div class="row alert alert-success text-center">
                                <div class="col-12">
                                    <b>Travel</b>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="allow_tr" class="col-sm-4 col-form-label">
                                    Allow Travel
                                </label>
                                <div class="col-sm-1">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="allow_tr" name="allow_tr"
                                        <?php if (strpos($data['oqun_allow_quotations'], '#3-1#') !== false) echo 'checked'; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_tr_open_cover_number" class="col-sm-4 col-form-label">Open Cover
                                    Number</label>
                                <div class="col-sm-8">
                                    <input name="fld_tr_open_cover_number" type="text" id="fld_tr_open_cover_number"
                                           class="form-control"
                                           value="<?php echo $data["oqun_tr_open_cover_number"]; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_open_cover_number",
                                        "fieldDataType" => "text",
                                        "required" => false,
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_show_prem" class="col-sm-4 col-form-label">
                                    Show/Hide Premium on Schedule
                                </label>
                                <div class="col-sm-2">
                                    <select name="fld_tr_show_prem" id="fld_tr_show_prem"
                                            class="form-control">
                                        <option value=""></option>
                                        <option value="0" <?php if ($data['oqun_tr_show_prem'] == '0') echo 'selected'; ?>>
                                            Hide
                                        </option>
                                        <option value="1" <?php if ($data['oqun_tr_show_prem'] == '1') echo 'selected'; ?>>
                                            Show
                                        </option>
                                    </select>
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_show_prem",
                                        "fieldDataType" => "select",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="" class="col-sm-4">Allow Packages</label>
                                <div class="col-sm-8">

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                               id="packageBasic" name="packageBasic"
                                            <?php if (strpos($data['oqun_tr_package_selection'], '#basic#') !== false) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="packageBasic">Basic</label>
                                    </div>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                               id="packageStandard" name="packageStandard"
                                            <?php if (strpos($data['oqun_tr_package_selection'], '#standard#') !== false) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="packageStandard">Standard</label>
                                    </div>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                               id="packageLuxury" name="packageLuxury"
                                            <?php if (strpos($data['oqun_tr_package_selection'], '#luxury#') !== false) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="packageLuxury">Luxury</label>
                                    </div>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                               id="packageSpecial" name="packageSpecial"
                                            <?php if (strpos($data['oqun_tr_package_selection'], '#special#') !== false) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="packageSpecial">Special</label>
                                    </div>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                               id="packageSchengen" name="packageSchengen"
                                            <?php if (strpos($data['oqun_tr_package_selection'], '#schengen#') !== false) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="packageSchengen">Schengen</label>
                                    </div>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                               id="packageLimited" name="packageLimited"
                                            <?php if (strpos($data['oqun_tr_package_selection'], '#limited#') !== false) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="packageLimited">Russian Visa</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_basic_premium" class="col-sm-3 col-form-label">
                                    Basic Package Per Day/Person Pr.
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_basic_premium" type="text"
                                           id="fld_tr_basic_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_basic_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_basic_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                                <label for="fld_tr_basic_min_premium" class="col-sm-3 col-form-label">
                                    Basic Minimum Policy Premium
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_basic_min_premium" type="text"
                                           id="fld_tr_basic_min_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_basic_min_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_basic_min_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_basic_fees" class="col-sm-1 col-form-label text-right">
                                    Fees
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_basic_fees" type="text"
                                           id="fld_tr_basic_fees"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_basic_fees']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_basic_fees",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_basic_stamps" class="col-sm-1 col-form-label text-right">
                                    Stamps
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_basic_stamps" type="text"
                                           id="fld_tr_basic_stamps"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_basic_stamps']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_basic_stamps",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_standard_premium" class="col-sm-3 col-form-label">
                                    Standard Package Per Day/Person Pr.
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_standard_premium" type="text"
                                           id="fld_tr_standard_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_standard_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_standard_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageStandard').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                                <label for="fld_tr_standard_min_premium" class="col-sm-3 col-form-label">
                                    Standard Minimum Policy Premium
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_standard_min_premium" type="text"
                                           id="fld_tr_standard_min_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_standard_min_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_standard_min_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageStandard').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_standard_fees" class="col-sm-1 col-form-label text-right">
                                    Fees
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_standard_fees" type="text"
                                           id="fld_tr_standard_fees"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_standard_fees']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_standard_fees",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_standard_stamps" class="col-sm-1 col-form-label text-right">
                                    Stamps
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_standard_stamps" type="text"
                                           id="fld_tr_standard_stamps"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_standard_stamps']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_standard_stamps",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_luxury_premium" class="col-sm-3 col-form-label">
                                    Luxury Package Per Day/Person Pr.
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_luxury_premium" type="text"
                                           id="fld_tr_luxury_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_luxury_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_luxury_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageLuxury').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_luxury_min_premium" class="col-sm-3 col-form-label">
                                    Luxury Minimum Policy Premium
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_luxury_min_premium" type="text"
                                           id="fld_tr_luxury_min_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_luxury_min_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_luxury_min_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageLuxury').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_luxury_fees" class="col-sm-1 col-form-label text-right">
                                    Fees
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_luxury_fees" type="text"
                                           id="fld_tr_luxury_fees"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_luxury_fees']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_luxury_fees",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageLuxury').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_luxury_stamps" class="col-sm-1 col-form-label text-right">
                                    Stamps
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_luxury_stamps" type="text"
                                           id="fld_tr_luxury_stamps"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_luxury_stamps']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_luxury_stamps",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageLuxury').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_special_premium" class="col-sm-3 col-form-label">
                                    Special Package Per Day/Person Pr.
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_special_premium" type="text"
                                           id="fld_tr_special_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_special_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_special_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageSpecial').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_special_min_premium" class="col-sm-3 col-form-label">
                                    Special Minimum Policy Premium
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_special_min_premium" type="text"
                                           id="fld_tr_special_min_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_special_min_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_special_min_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageSpecial').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_special_fees" class="col-sm-1 col-form-label text-right">
                                    Fees
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_special_fees" type="text"
                                           id="fld_tr_special_fees"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_special_fees']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_special_fees",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageSpecial').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_special_stamps" class="col-sm-1 col-form-label text-right">
                                    Stamps
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_special_stamps" type="text"
                                           id="fld_tr_special_stamps"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_special_stamps']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_special_stamps",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageSpecial').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_schengen_premium" class="col-sm-3 col-form-label">
                                    Schengen Package Per Day/Person Pr.
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_schengen_premium" type="text"
                                           id="fld_tr_schengen_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_schengen_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_schengen_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageSchengen').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_schengen_min_premium" class="col-sm-3 col-form-label">
                                    Shengen Minimum Policy Premium
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_schengen_min_premium" type="text"
                                           id="fld_tr_schengen_min_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_schengen_min_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_schengen_min_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageSchengen').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_schengen_fees" class="col-sm-1 col-form-label text-right">
                                    Fees
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_schengen_fees" type="text"
                                           id="fld_tr_schengen_fees"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_schengen_fees']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_schengen_fees",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_schengen_stamps" class="col-sm-1 col-form-label text-right">
                                    Stamps
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_schengen_stamps" type="text"
                                           id="fld_tr_schengen_stamps"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_schengen_stamps']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_schengen_stamps",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="fld_tr_limited_premium" class="col-sm-3 col-form-label">
                                    Russian Visa Package Per Day/Person Pr.
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_limited_premium" type="text"
                                           id="fld_tr_limited_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_limited_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_limited_premium",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageLimited').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_limited_min_premium" class="col-sm-3 col-form-label">
                                    Russian V. Minimum <strong>Member</strong> Premium
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_limited_min_premium" type="text"
                                           id="fld_tr_limited_min_premium"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_limited_min_premium']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_limited_min_premium",
                                        "fieldDataType" => "text",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageLimited').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_limited_fees" class="col-sm-1 col-form-label text-right">
                                    Fees
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_limited_fees" type="text"
                                           id="fld_tr_limited_fees"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_limited_fees']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_limited_fees",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                                <label for="fld_tr_limited_stamps" class="col-sm-1 col-form-label text-right">
                                    Stamps
                                </label>
                                <div class="col-sm-1">
                                    <input name="fld_tr_limited_stamps" type="text"
                                           id="fld_tr_limited_stamps"
                                           class="form-control text-center"
                                           value="<?php echo $data['oqun_tr_limited_stamps']; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_tr_limited_stamps",
                                        "fieldDataType" => "number",
                                        "required" => true,
                                        "invalidTextAutoGenerate" => true,
                                        "requiredAddedCustomCode" => "&& $('#allow_tr').is(':checked') && $('#packageBasic').is(':checked')"
                                    ]);
                                    ?>
                                </div>

                            </div>


                            <!-- TRAVEL END TAB -->
                        </div>

                        <div class="tab-pane fade show" id="pills-household" role="tabpanel"
                             aria-labelledby="pills-household-tab">
                            <!-- HOUSEHOLD -->

                            <div class="row alert alert-success text-center">
                                <div class="col-12">
                                    <b>Household</b>
                                </div>
                            </div>

                            <div class="row">
                                <label for="allow_hc" class="col-sm-4 col-form-label">
                                    Allow Household
                                </label>
                                <div class="col-sm-1">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="allow_hc" name="allow_hc"
                                        <?php if (strpos($data['oqun_allow_quotations'], '#4-1#') !== false) echo 'checked'; ?>>
                                </div>
                            </div>

                        </div>

                        <!-- CONTENTS TAB END-->
                    </div>

                    <div class="row" style="height: 25px"></div>

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