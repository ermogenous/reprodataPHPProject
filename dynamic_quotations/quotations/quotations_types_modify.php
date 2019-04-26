<?php
include("../../include/main.php");
$db = new Main();
$db->admin_title = "Quotations Type Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Insert new quotations type';
    $db->start_transaction();

    $_POST['fld_added_field_email'] = $db->get_check_value($_POST['fld_added_field_email']);
    $_POST['fld_added_field_contact_person'] = $db->get_check_value($_POST['fld_added_field_contact_person']);
    $_POST['fld_added_field_extra_details'] = $db->get_check_value($_POST['fld_added_field_extra_details']);

    $db->db_tool_insert_row('oqt_quotations_types', $_POST, 'fld_', 0, 'oqqt_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Quotation created');
    header("Location: quotations_types.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations type';
    $db->start_transaction();

    $_POST['fld_added_field_email'] = $db->get_check_value($_POST['fld_added_field_email']);
    $_POST['fld_added_field_contact_person'] = $db->get_check_value($_POST['fld_added_field_contact_person']);
    $_POST['fld_added_field_extra_details'] = $db->get_check_value($_POST['fld_added_field_extra_details']);

    $db->db_tool_update_row('oqt_quotations_types', $_POST, "`oqqt_quotations_types_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'oqqt_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('Quotation updated');
    header("Location: quotations_types.php");
    exit();

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("SELECT * FROM `oqt_quotations_types` WHERE `oqqt_quotations_types_ID` = " . $_GET["lid"]);
}

$db->show_header();


include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Quotation Type</b>
                    </div>


                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-5">
                            <input name="fld_name" type="text" id="fld_name"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_name"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_name",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Fill Name",
                            ]);
                            ?>
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
                        <label for="fld_quotation_or_cover_note" class="col-sm-4 col-form-label">Quotation/Cover
                            Note</label>
                        <div class="col-sm-8">
                            <select name="fld_quotation_or_cover_note" id="fld_quotation_or_cover_note"
                                    class="form-control"
                                    required>
                                <option value="QT" <?php if ($data["oqqt_quotation_or_cover_note"] == 'QT') echo "selected=\"selected\""; ?>>
                                    Quotation
                                </option>
                                <option value="CN" <?php if ($data["oqqt_quotation_or_cover_note"] == 'CN') echo "selected=\"selected\""; ?>>
                                    Cover Note
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
                        <label for="fld_language" class="col-sm-4 col-form-label">Language</label>
                        <div class="col-sm-8">
                            <select name="fld_language" id="fld_language"
                                    class="form-control"
                                    required>
                                <option value="BothGr" <?php if ($data["oqqt_language"] == 'BothGr') echo "selected=\"selected\""; ?>>
                                    Both Default Greek
                                </option>
                                <option value="BothEn" <?php if ($data["oqqt_language"] == 'BothEn') echo "selected=\"selected\""; ?>>
                                    Both Default English
                                </option>
                                <option value="English" <?php if ($data["oqqt_language"] == 'English') echo "selected=\"selected\""; ?>>
                                    English
                                </option>
                                <option value="Greek" <?php if ($data["oqqt_language"] == 'Greek') echo "selected=\"selected\""; ?>>
                                    Greek
                                </option>
                            </select>
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
                                   value="<?php echo $data["oqqt_functions_file"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_functions_file",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Fill Functions File URL",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_print_layout" class="col-sm-4 col-form-label">Print Layout File</label>
                        <div class="col-sm-8">
                            <input name="fld_print_layout" type="text" id="fld_print_layout"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_print_layout"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_print_layout",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Fill Print Layout File",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_js_file" class="col-sm-4 col-form-label">Java Script File</label>
                        <div class="col-sm-8">
                            <input name="fld_js_file" type="text" id="fld_js_file"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_js_file"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_js_file",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Fill Java Script File",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_fees" class="col-sm-4 col-form-label">Fees</label>
                        <div class="col-sm-8">
                            <input name="fld_fees" type="text" id="fld_fees"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_fees"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_fees",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Fill Fees Or 0",
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_stamps" class="col-sm-4 col-form-label">Stamps</label>
                        <div class="col-sm-8">
                            <input name="fld_stamps" type="text" id="fld_stamps"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_stamps"]; ?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_stamps",
                                "fieldDataType" => "text",
                                "required" => true,
                                "invalidText" => "Fill Stamps Or 0",
                            ]);
                            ?>
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
                        <label for="fld_enable_premium" class="col-sm-4 col-form-label">Enable Premium</label>
                        <div class="col-sm-8">
                            <select name="fld_enable_premium" id="fld_enable_premium"
                                    class="form-control"
                                    required>
                                <option value="1" <?php if ($data["oqqt_enable_premium"] == '1') echo "selected=\"selected\""; ?>>
                                    Enable
                                </option>
                                <option value="0" <?php if ($data["oqqt_enable_premium"] == '0') echo "selected=\"selected\""; ?>>
                                    Disable
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_minimum_premium" class="col-sm-4 col-form-label">Minimum Premium</label>
                        <div class="col-sm-8">
                            <input name="fld_minimum_premium" type="text" id="fld_minimum_premium"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_minimum_premium"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_quotation_number_prefix" class="col-sm-4 col-form-label">Number Prefix</label>
                        <div class="col-sm-8">
                            <input name="fld_quotation_number_prefix" type="text" id="fld_quotation_number_prefix"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_quotation_number_prefix"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_quotation_number_leading_zeros" class="col-sm-4 col-form-label">Number Leading Zeros</label>
                        <div class="col-sm-8">
                            <input name="fld_quotation_number_leading_zeros" type="text" id="fld_quotation_number_leading_zeros"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_quotation_number_leading_zeros"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_quotation_number_last_used" class="col-sm-4 col-form-label">Number Last Used</label>
                        <div class="col-sm-8">
                            <input name="fld_quotation_number_last_used" type="text" id="fld_quotation_number_last_used"
                                   class="form-control"
                                   value="<?php echo $data["oqqt_quotation_number_last_used"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_active_send_mail" class="col-sm-4 col-form-label">
                            On active send email
                            <br>Email||Name Break
                            <br>[QTID] - Quotation ID
                            <br>[QTNUMBER] - Quotation Number
                            <br>[QTLINK] Link for the quotation
                            <br>[USERSNAME] Name of the creator
                            <br>[PDFLINK] Link for PDF
                        </label>
                        <div class="col-sm-8">
                            <textarea name="fld_active_send_mail" id="fld_active_send_mail"
                                      class="form-control"><?php echo $data["oqqt_active_send_mail"]; ?></textarea>

                            <div class="row">
                                <label for="fld_active_send_mail_cc" class="col-sm-3 col-form-label">
                                    CC Mail/s:<br>Email||Name \n
                                </label>
                                <div class="col-9">
                                    <textarea name="fld_active_send_mail_cc" id="fld_active_send_mail_cc"
                                              class="form-control"><?php echo $data["oqqt_active_send_mail_cc"]; ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_active_send_mail_bcc" class="col-sm-3 col-form-label">
                                    BCC Mail/s:<br>Email||Name \n
                                </label>
                                <div class="col-9">
                                    <textarea name="fld_active_send_mail_bcc" id="fld_active_send_mail_bcc"
                                              class="form-control"><?php echo $data["oqqt_active_send_mail_bcc"]; ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_active_send_mail_from" class="col-sm-3 col-form-label">
                                    Subject:
                                </label>
                                <div class="col-9">
                                    <textarea name="fld_active_send_mail_subject" id="fld_active_send_mail_subject"
                                              class="form-control"><?php echo $data["oqqt_active_send_mail_subject"]; ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_active_send_mail_from" class="col-sm-3 col-form-label">
                                    Body: HTML
                                </label>
                                <div class="col-9">
                                    <textarea name="fld_active_send_mail_body" id="fld_active_send_mail_body"
                                              class="form-control"><?php echo $data["oqqt_active_send_mail_body"]; ?></textarea>
                                </div>
                            </div>
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

                    <div class="form-group row">
                        <div class="col-sm-4 col-form-label">
                            Added fields
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <label for="fld_added_field_email" class="col-sm-5 col-form-label">
                                    Email:
                                </label>
                                <div class="col-sm-1">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_added_field_email" name="fld_added_field_email"
                                        <?php if ($data['oqqt_added_field_email'] == 1) echo 'checked'; ?>>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_added_field_contact_person" class="col-sm-5 col-form-label">
                                    Contact Person:
                                </label>
                                <div class="col-sm-1">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_added_field_contact_person" name="fld_added_field_contact_person"
                                        <?php if ($data['oqqt_added_field_contact_person'] == 1) echo 'checked'; ?>>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_added_field_extra_details" class="col-sm-5 col-form-label">
                                    Extra Details:
                                </label>
                                <div class="col-sm-1">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_added_field_extra_details" name="fld_added_field_extra_details"
                                        <?php if ($data['oqqt_added_field_extra_details'] == 1) echo 'checked'; ?>>
                                </div>
                            </div>
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