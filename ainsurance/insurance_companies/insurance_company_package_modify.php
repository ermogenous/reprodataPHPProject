<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/7/2019
 * Time: 11:33 ΠΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "AInsurance Company Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'AInsurance Company Package Insert';
    $db->db_tool_insert_row('ina_insurance_company_packages', $_POST, 'fld_',0, 'inaincpk_');
    header("Location: insurance_company_packages.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Company Package Modify';

    $db->db_tool_update_row('ina_insurance_company_packages', $_POST, "`inaincpk_insurance_company_package_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inaincpk_');
    header("Location: insurance_company_packages.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance Company Package Get data';
    $sql = "SELECT * FROM `ina_insurance_company_packages` WHERE `inaincpk_insurance_company_package_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}
else {
    $data['inaincpk_status'] = 'Active';
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
                            &nbsp;Insurance Company Package</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select name="fld_status" id="fld_status"
                                    class="form-control">
                                <option value="Active" <?php if ($data['inaincpk_status'] == 'Active') echo 'selected';?>>Active</option>
                                <option value="InActive" <?php if ($data['inaincpk_status'] == 'InActive') echo 'selected';?>>In-active</option>
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

                    <div class="row">
                        <label for="fld_insurance_company_ID"
                               class="col-sm-4">Company</label>
                        <div class="col-sm-8" style="height: 45px;">
                            <select name="fld_insurance_company_ID" id="fld_insurance_company_ID"
                                    class="form-control" <?php if ($_GET['lid'] > 0) echo "disabled";?>>
                                <option value=""></option>
                                <?php
                                $sql = "SELECT * FROM ina_insurance_companies WHERE inainc_status = 'Active' ORDER BY inainc_name ASC";
                                $result = $db->query($sql);
                                while ($comp = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $comp['inainc_insurance_company_ID'];?>"
                                        <?php if ($data['inaincpk_insurance_company_ID'] == $comp['inainc_insurance_company_ID'])
                                            echo "selected=\"selected\""; ?>>
                                        <?php echo $comp['inainc_name'];?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_insurance_company_ID",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="fld_type"
                               class="col-sm-4">Type</label>
                        <div class="col-sm-8" style="height: 45px;">
                            <select name="fld_type" id="fld_type"
                                    class="form-control">
                                <option value=""></option>
                                <option value="Motor" <?php if ($data['inaincpk_type'] == 'Motor') echo "selected=\"selected\""; ?>>
                                    Motor
                                </option>
                                <option value="Fire" <?php if ($data['inaincpk_type'] == 'Fire') echo "selected=\"selected\""; ?>>
                                    Fire
                                </option>
                                <option value="PA" <?php if ($data['inaincpk_type'] == 'PA') echo "selected=\"selected\""; ?>>
                                    PA
                                </option>
                                <option value="EL" <?php if ($data['inaincpk_type'] == 'EL') echo "selected=\"selected\""; ?>>
                                    EL
                                </option>
                                <option value="PI" <?php if ($data['inaincpk_type'] == 'PI') echo "selected=\"selected\""; ?>>
                                    PI
                                </option>
                                <option value="PL" <?php if ($data['inaincpk_type'] == 'PL') echo "selected=\"selected\""; ?>>
                                    PL
                                </option>
                                <option value="Medical" <?php if ($data['inaincpk_type'] == 'Medical') echo "selected=\"selected\""; ?>>
                                    Medical
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_type",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                        <div class="col-sm-8">
                            <input name="fld_code" type="text" id="fld_code"
                                   class="form-control"
                                   value="<?php echo $data["inaincpk_code"]; ?>">
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
                                   value="<?php echo $data["inaincpk_name"]; ?>">
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
                                   value="<?php echo $data["inaincpk_description"]; ?>">
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
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('insurance_company_packages.php')" >
                            <input type="submit" name="Submit" id="Submit" value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Package"
                                   class="btn btn-secondary">
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        </div>
    </div>
<?php
$formValidator->output();
$db->show_footer();
?>