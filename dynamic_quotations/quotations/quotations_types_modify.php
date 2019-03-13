<?php
include("../../include/main.php");
$db = new Main();
$db->admin_title = "Quotations Type Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Insert new quotations type';
    $db->start_transaction();

    $db->db_tool_insert_row('oqt_quotations_types', $_POST, 'fld_',0,'oqqt_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Quotation created');
    header("Location: quotations_types.php?info=New Quotation created");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations type';
    $db->start_transaction();

    $db->db_tool_update_row('oqt_quotations_types', $_POST, "`oqqt_quotations_types_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_','execute','oqqt_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('Quotation updated');
    header("Location: quotations_types.php");
    exit();

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("SELECT * FROM `oqt_quotations_types` WHERE `oqqt_quotations_types_ID` = " . $_GET["lid"]);
}

$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Quotation Type</b>
                    </div>


                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-5">
                            <input name="fld_name" type="text" id="fld_name"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_name"]; ?>"
                                   required>
                        </div>
                        <div class="col-sm-3">
                            <select name="fld_status" id="fld_status"
                                    class="form-control"
                                    required>
                                <option value="A" <?php if ($data["oqqt_status"] == 'A') echo "selected=\"selected\""; ?>>
                                    Active
                                </option>
                                <option value="I" <?php if ($data["oqqt_status"] == 'I') echo "selected=\"selected\""; ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_quotation_label_gr" class="col-sm-4 col-form-label">Quotation Label
                            GR</label>
                        <div class="col-sm-8">
                            <textarea name="fld_quotation_label_gr" id="fld_quotation_label_gr"
                                      class="form-control"><?php echo $data["oqqt_quotation_label_gr"]; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_quotation_label_en" class="col-sm-4 col-form-label">Quotation Label
                            EN</label>
                        <div class="col-sm-8">
                            <textarea name="fld_quotation_label_en" id="fld_quotation_label_en"
                                      class="form-control"><?php echo $data["oqqt_quotation_label_en"]; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_type" class="col-sm-4 col-form-label">Insurance Type</label>
                        <div class="col-sm-8">
                            <select name="fld_type" id="fld_type"
                                    class="form-control"
                                    required>
                                <option value="Motor" <?php if ($data["oqqt_type"] == 'Motor') echo "selected=\"selected\""; ?>>
                                    Motor
                                </option>
                                <option value="Medical" <?php if ($data["oqqt_type"] == 'Medical') echo "selected=\"selected\""; ?>>
                                    Medical
                                </option>
                                <option value="MarineCargo" <?php if ($data["oqqt_type"] == 'MarineCargo') echo "selected=\"selected\""; ?>>
                                    MarineCargo
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_class" class="col-sm-4 col-form-label">Class</label>
                        <div class="col-sm-8">
                            <select name="fld_class" id="fld_class"
                                    class="form-control"
                                    required>
                                <option value="Motor" <?php if ($data["oqqt_class"] == 'Motor') echo "selected=\"selected\""; ?>>
                                    Motor
                                </option>
                                <option value="NonMotor" <?php if ($data["oqqt_class"] == 'NonMotor') echo "selected=\"selected\""; ?>>
                                    NonMotor
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_functions_file" class="col-sm-4 col-form-label">Functions File URL</label>
                        <div class="col-sm-8">
                            <input name="fld_functions_file" type="text" id="fld_functions_file"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_functions_file"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_print_layout" class="col-sm-4 col-form-label">Print Layout File</label>
                        <div class="col-sm-8">
                            <input name="fld_print_layout" type="text" id="fld_print_layout"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_print_layout"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_js_file" class="col-sm-4 col-form-label">Java Script File</label>
                        <div class="col-sm-8">
                            <input name="fld_js_file" type="text" id="fld_js_file"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_js_file"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_fees" class="col-sm-4 col-form-label">Fees</label>
                        <div class="col-sm-8">
                            <input name="fld_fees" type="text" id="fld_fees"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_fees"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_stamps" class="col-sm-4 col-form-label">Stamps</label>
                        <div class="col-sm-8">
                            <input name="fld_stamps" type="text" id="fld_stamps"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_stamps"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_premium_rounding" class="col-sm-4 col-form-label">Premium Rounding</label>
                        <div class="col-sm-8">
                            <select name="fld_premium_rounding" id="fld_premium_rounding"
                                    class="form-control"
                                    required>
                                <option value=""></option>
                                <option value="NoRounding" <?php if ($data["oqqt_premium_rounding"] == 'NoRounding') echo "selected=\"selected\""; ?>>
                                    No Rounding
                                </option>
                                <option value="RoundUpFees" <?php if ($data["oqqt_premium_rounding"] == 'RoundUpFees') echo "selected=\"selected\""; ?>>
                                    To Fees Round UP
                                </option>
                                <option value="RoundDownFees" <?php if ($data["oqqt_premium_rounding"] == 'RoundDownFees') echo "selected=\"selected\""; ?>>
                                    To Fees Round Down
                                </option>
                                <option value="CustomFees" <?php if ($data["oqqt_premium_rounding"] == 'CustomFees') echo "selected=\"selected\""; ?>>
                                    Custom Fees (will use get_custom_fees_amount())
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_minimum_premium" class="col-sm-4 col-form-label">Minimum Premium</label>
                        <div class="col-sm-8">
                            <input name="fld_minimum_premium" type="text" id="fld_minimum_premium"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_minimum_premium"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_allowed_user_groups" class="col-sm-4 col-form-label">Allowed User
                            Groups</label>
                        <div class="col-sm-8">
                            <input name="fld_allowed_user_groups" type="text" id="fld_allowed_user_groups"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_allowed_user_groups"]; ?>">
                            If empty all allowed (separate with comma, always end with comma)
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
                                   onclick="window.location.assign('quotations_types.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Quotation Type"
                                   class="btn btn-secondary"
                                   onclick="submitForm()">
                        </div>
                    </div>

                </form>
            </div>
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