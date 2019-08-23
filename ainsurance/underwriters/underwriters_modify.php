<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/4/2019
 * Time: 3:12 ΜΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "Insurance Underwriters Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Insert new Insurance underwriter';
    $db->start_transaction();


    $newID = $db->db_tool_insert_row('ina_underwriters', $_POST, 'fld_', 1, 'inaund_');
    //update companies
    //update the companies
    foreach ($_POST as $name => $value) {
        if (substr($name, 0, 7) == 'inc_id_') {
            $newData['underwriter_ID'] = $newID;
            $newData['insurance_company_ID'] = substr($name, 7);
            $newData['status'] = $value;
            $db->db_tool_insert_update_row('ina_underwriter_companies',
                $newData,
                'inaunc_underwriter_ID = ' . $newID . ' AND inaunc_insurance_company_ID = ' . substr($name, 7),
                'inaunc_underwriter_company_ID',
                '',
                'inaunc_');
        }

    }
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Insurance underwriter created');
    header("Location: underwriters.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify Insurance underwriter';
    $db->start_transaction();

    //in case of change user
    //check if this user has quotations. if yes do not allow change
    //get current data
    $currentData = $db->query_fetch("SELECT * FROM ina_underwriters WHERE inaund_underwriter_ID = " . $_POST["lid"]);
    $error_found = false;
    if ($currentData['inaund_user_ID'] != $_POST['fld_user_ID']) {
        $quotationCheckData = $db->query_fetch('SELECT COUNT(*) as clo_total FROM ina_policies WHERE inaund_user_ID = ' . $currentData['inaund_user_ID']);

        if ($quotationCheckData['clo_total'] > 0) {
            $db->generateAlertError('This user has policy. Cannot change the user');
            $error_found = true;
        }

    }

    if ($error_found == false) {
        $db->db_tool_update_row('ina_underwriters', $_POST, "`inaund_underwriter_ID` = " . $_POST["lid"], $_POST["lid"],
            'fld_', 'execute', 'inaund_');
        //update the companies
        foreach ($_POST as $name => $value) {
            if (substr($name, 0, 7) == 'inc_id_') {
                $newData['underwriter_ID'] = $_POST['lid'];
                $newData['insurance_company_ID'] = substr($name, 7);
                $newData['status'] = $value;
                $db->db_tool_insert_update_row('ina_underwriter_companies',
                    $newData,
                    'inaunc_underwriter_ID = ' . $_POST['lid'] . ' AND inaunc_insurance_company_ID = ' . substr($name, 7),
                    'inaunc_underwriter_company_ID',
                    '',
                    'inaunc_');
            }

        }
        $db->commit_transaction();
        $db->generateSessionAlertSuccess('Insurance underwriter updated');
        header("Location: underwriters.php");
        exit();
    }

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("SELECT * FROM `ina_underwriters` JOIN users ON usr_users_ID = inaund_user_ID WHERE `inaund_underwriter_ID` = " . $_GET["lid"]);
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
                                &nbsp;Quotation Underwriter <?php echo $data['usr_name'];?></b>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="fld_user_ID" class="col-sm-3 col-form-label">User</label>
                        <div class="col-sm-6">
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
                                    LEFT OUTER JOIN ina_underwriters as und_check ON users.usr_users_ID = und_check.inaund_user_ID
                                    WHERE
                                    inaund_user_ID is NULL ';
                                if ($data['inaund_user_ID'] > 0) {
                                    $sql .= 'OR usr_users_ID = ' . $data['inaund_user_ID'];
                                }
                                $result = $db->query($sql);
                                while ($user = $db->fetch_assoc($result)) {
                                    ?>
                                    <option
                                            value="<?php echo $user['usr_users_ID']; ?>"
                                        <?php if ($data["inaund_user_ID"] == $user['usr_users_ID']) echo "selected=\"selected\""; ?>>
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
                                    class="form-control"
                                    required>
                                <option value="Active" <?php if ($data["inaund_status"] == 'Active') echo "selected=\"selected\""; ?>>
                                    Active
                                </option>
                                <option value="Inactive" <?php if ($data["inaund_status"] == 'Inactive') echo "selected=\"selected\""; ?>>
                                    Inactive
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_status",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidText" => "Select status",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_vertical_level" class="col-sm-3 col-form-label">Vertical Level</label>
                        <div class="col-3">
                            <select name="fld_vertical_level" id="fld_vertical_level"
                                    class="form-control">
                                <?php for ($i = 0; $i <= 10; $i++) { ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_subagent_ID" class="col-sm-3 col-form-label">Sub Agent</label>
                        <div class="col-3">
                            <select name="fld_subagent_ID" id="fld_subagent_ID"
                                    class="form-control">
                                <option value="0" <?php if ($data["inaund_subagent_ID"] == '0') echo "selected=\"selected\""; ?>>No</option>
                                <option value="-1" <?php if ($data["inaund_subagent_ID"] == '-1') echo "selected=\"selected\""; ?>>Yes - Top</option>
                                <option value="" disabled>------------</option>
                                <?php
                                $sql = 'SELECT * FROM
                                ina_underwriters
                                JOIN users ON usr_users_ID = inaund_user_ID
                                WHERE
                                inaund_user_ID != '.$_GET['lid'].'
                                AND inaund_subagent_ID != 0
                                ORDER BY usr_name ASC';
                                $result = $db->query($sql);
                                while ($row = $db->fetch_assoc($result)){
                                ?>
                                    <option value="<?php echo $row['inaund_underwriter_ID'];?>"
                                        <?php if ($data["inaund_subagent_ID"] == $row['inaund_underwriter_ID']) echo "selected=\"selected\""; ?>>
                                        <?php echo $row['usr_name'];?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            Applies only to advanced accounts.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            If advanced accounts and not sub agent then the commissions percentages for each company are not used.<br>
                            The ones from the insurance company will be used.
                            <br>Yes-Top -> Subagent of the office.
                            <br>Choose another underwriter this means its a subagent of a subagent
                        </div>
                    </div>

                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Insurance Types</b>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_motor"
                               class="col-sm-9">Motor</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_motor" id="fld_use_motor"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_motor'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_motor'] == '0' || $data['inaund_use_motor'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_motor",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_fire"
                               class="col-sm-9">Fire</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_fire" id="fld_use_fire"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_fire'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_fire'] == '0' || $data['inaund_use_fire'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_fire",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_pa"
                               class="col-sm-9">Personal Accident</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_pa" id="fld_use_pa"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_pa'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_pa'] == '0' || $data['inaund_use_pa'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_pa",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_el"
                               class="col-sm-9">Employers Liability</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_el" id="fld_use_el"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_el'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_el'] == '0' || $data['inaund_use_el'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_el",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_pi"
                               class="col-sm-9">Professional Indemnity</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_pi" id="fld_use_pi"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_pi'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_pi'] == '0' || $data['inaund_use_pi'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_pi",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_pl"
                               class="col-sm-9">Public Liability</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_pl" id="fld_use_pl"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_pl'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_pl'] == '0' || $data['inaund_use_pl'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_pl",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_medical"
                               class="col-sm-9">Medical</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_medical" id="fld_use_medical"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_medical'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_medical'] == '0' || $data['inaund_use_medical'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_medical",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_use_travel"
                               class="col-sm-9">Travel</label>
                        <div class="col-sm-3" style="height: 45px;">
                            <select name="fld_use_travel" id="fld_use_travel"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaund_use_travel'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaund_use_travel'] == '0' || $data['inaund_use_travel'] == '') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_use_travel",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Insurance Companies</b>
                        </div>
                    </div>
                    <?php
                    if ($_GET['lid'] > 0) {
                        //make an array of the existing data
                        $sql = "SELECT * FROM ina_underwriter_companies WHERE inaunc_underwriter_ID = " . $_GET['lid'];
                        $result = $db->query($sql);
                        while ($row = $db->fetch_assoc($result)) {
                            $undCompanies[$row['inaunc_insurance_company_ID']] = $row;
                        }
                    }
                    $sql = "SELECT * FROM ina_insurance_companies WHERE inainc_status = 'Active' ORDER BY inainc_name ASC";
                    $result = $db->query($sql);
                    while ($row = $db->fetch_assoc($result)) {
                        if ($undCompanies[$row['inainc_insurance_company_ID']]['inaunc_status'] == '') {
                            $undCompanies[$row['inainc_insurance_company_ID']]['inaunc_status'] = 'Inactive';
                        }
                        ?>
                        <div class="row">
                            <label for="inc_id_<?php echo $row['inainc_insurance_company_ID']; ?>"
                                   class="col-sm-9"><?php echo $row['inainc_name']; ?></label>
                            <div class="col-sm-3" style="height: 45px;">
                                <select name="inc_id_<?php echo $row['inainc_insurance_company_ID']; ?>"
                                        id="inc_id_<?php echo $row['inainc_insurance_company_ID']; ?>"
                                        class="form-control"
                                        required>
                                    <option value="Active" <?php if ($undCompanies[$row['inainc_insurance_company_ID']]['inaunc_status'] == 'Active') echo "selected=\"selected\""; ?>>
                                        Yes
                                    </option>
                                    <option value="Inactive" <?php if ($undCompanies[$row['inainc_insurance_company_ID']]['inaunc_status'] == 'Inactive') echo "selected=\"selected\""; ?>>
                                        No
                                    </option>
                                </select>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "inc_id_" . $row['inainc_insurance_company_ID'],
                                    "fieldDataType" => "select",
                                    "required" => false,
                                ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>
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