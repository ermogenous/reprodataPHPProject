<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2019
 * Time: 9:56 ΠΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "AInsurance Company Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'AInsurance Company Insert';
    $db->db_tool_insert_row('ina_insurance_companies', $_POST, 'fld_',0, 'inainc_');
    header("Location: insurance_companies.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Company Modify';

    $db->db_tool_update_row('ina_insurance_companies', $_POST, "`inainc_insurance_company_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inainc_');
    header("Location: insurance_companies.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance Company Get data';
    $sql = "SELECT * FROM `ina_insurance_companies` WHERE `inainc_insurance_company_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}
else {
    $data['inainc_active'] = 1;
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
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Insurance Company</b>
                </div>

                <div class="form-group row">
                    <label for="fld_status" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                        <select name="fld_status" id="fld_status"
                                class="form-control">
                            <option value="Active" <?php if ($data['inainc_status'] == 'Active') echo 'selected';?>>Active</option>
                            <option value="InActive" <?php if ($data['inainc_status'] == 'InActive') echo 'selected';?>>In-active</option>
                        </select>
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_code",
                            "fieldDataType" => "select",
                            "required" => true,
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                    <div class="col-sm-8">
                        <input name="fld_code" type="text" id="fld_code"
                               class="form-control"
                               value="<?php echo $data["inainc_code"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_code",
                            "fieldDataType" => "text",
                            "required" => true,
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name" type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["inainc_name"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_name",
                            "fieldDataType" => "text",
                            "required" => true,
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description" type="text" id="fld_description"
                               class="form-control"
                               value="<?php echo $data["inainc_description"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_description",
                            "fieldDataType" => "text",
                            "required" => false,
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_country_code_ID" class="col-sm-4 col-form-label">Country</label>
                    <div class="col-sm-8">
                        <select name="fld_country_code_ID" id="fld_country_code_ID"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <?php
                            $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC");
                            while($bt = $db->fetch_assoc($btResult)){

                                ?>
                                <option value="<?php echo $bt['cde_code_ID'];?>"
                                    <?php if ($bt['cde_code_ID'] == $data['inainc_country_code_ID']) echo 'selected';?>>
                                    <?php echo $bt['cde_value'];?>
                                </option>
                            <?php } ?>
                        </select>
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_country_code_ID",
                            "fieldDataType" => "select",
                            "required" => false,
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row alert alert-primary">
                    <div class="col-12">
                        Policy Types
                    </div>
                </div>

                <div class="row">
                    <label for="fld_use_motor"
                           class="col-sm-9">Motor</label>
                    <div class="col-sm-3" style="height: 45px;">
                        <select name="fld_use_motor" id="fld_use_motor"
                                class="form-control">
                            <option value="1" <?php if ($data['inainc_use_motor'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_motor'] == '0' || $data['inainc_use_motor'] == '') echo "selected=\"selected\""; ?>>
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
                            <option value="1" <?php if ($data['inainc_use_fire'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_fire'] == '0' || $data['inainc_use_fire'] == '') echo "selected=\"selected\""; ?>>
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
                            <option value="1" <?php if ($data['inainc_use_pa'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_pa'] == '0' || $data['inainc_use_pa'] == '') echo "selected=\"selected\""; ?>>
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
                            <option value="1" <?php if ($data['inainc_use_el'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_el'] == '0' || $data['inainc_use_el'] == '') echo "selected=\"selected\""; ?>>
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
                            <option value="1" <?php if ($data['inainc_use_pi'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_pi'] == '0' || $data['inainc_use_pi'] == '') echo "selected=\"selected\""; ?>>
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
                            <option value="1" <?php if ($data['inainc_use_pl'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_pl'] == '0' || $data['inainc_use_pl'] == '') echo "selected=\"selected\""; ?>>
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
                            <option value="1" <?php if ($data['inainc_use_medical'] == '1') echo "selected=\"selected\""; ?>>
                                Yes
                            </option>
                            <option value="0" <?php if ($data['inainc_use_medical'] == '0' || $data['inainc_use_medical'] == '') echo "selected=\"selected\""; ?>>
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

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('insurance_companies.php')" >
                        <input type="submit" name="Submit" id="Submit" value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Insurance Company"
                               class="btn btn-secondary" onclick="submitForm()">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>
<script>
    function submitForm(){
        frm = document.getElementById('myForm');
        if (frm.checkValidity() === false){

        }
        else {
            document.getElementById('Submit').disabled = true
        }
    }
</script>
<?php
$db->show_footer();
?>
