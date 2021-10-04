<?php
include("../../include/main.php");
$db = new Main();
$db->admin_title = "Quotations Type Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Insert new quotations type';
    $db->start_transaction();

    $_POST['fld_enable_renewal'] = $db->get_check_value($_POST['fld_enable_renewal']);
    $_POST['fld_renewal_issue_new_number'] = $db->get_check_value($_POST['fld_renewal_issue_new_number']);

    $_POST['fld_added_field_person_company'] = $db->get_check_value($_POST['fld_added_field_person_company']);

    $_POST['fld_added_field_identity'] = $db->get_check_value($_POST['fld_added_field_identity']);
    $_POST['fld_added_field_identity_required'] = $db->get_check_value($_POST['fld_added_field_identity_required']);

    $_POST['fld_added_field_telephone'] = $db->get_check_value($_POST['fld_added_field_telephone']);
    $_POST['fld_added_field_telephone_required'] = $db->get_check_value($_POST['fld_added_field_telephone_required']);

    $_POST['fld_added_field_email'] = $db->get_check_value($_POST['fld_added_field_email']);
    $_POST['fld_added_field_contact_person'] = $db->get_check_value($_POST['fld_added_field_contact_person']);
    $_POST['fld_added_field_extra_details'] = $db->get_check_value($_POST['fld_added_field_extra_details']);
    $_POST['fld_added_field_mobile'] = $db->get_check_value($_POST['fld_added_field_mobile']);
    $_POST['fld_added_field_city'] = $db->get_check_value($_POST['fld_added_field_city']);
    $_POST['fld_added_field_email_required'] = $db->get_check_value($_POST['fld_added_field_email_required']);
    $_POST['fld_added_field_contact_person_required'] = $db->get_check_value($_POST['fld_added_field_contact_person_required']);
    $_POST['fld_added_field_extra_details_required'] = $db->get_check_value($_POST['fld_added_field_extra_details_required']);
    $_POST['fld_added_field_mobile_required'] = $db->get_check_value($_POST['fld_added_field_mobile_required']);
    $_POST['fld_added_field_city_required'] = $db->get_check_value($_POST['fld_added_field_city_required']);

    for ($i = 1; $i <= 5; $i++) {
        $_POST['fld_extra_field_'.$i.'_required'] = $db->get_check_value($_POST['fld_extra_field_'.$i.'_required']);
    }

    $_POST['fld_allow_print_outstanding'] = $db->get_check_value($_POST['fld_allow_print_outstanding']);
    $_POST['fld_adv_edit_resent_emails'] = $db->get_check_value($_POST['fld_adv_edit_resent_emails']);


    $db->db_tool_insert_row('oqt_quotations_types', $_POST, 'fld_', 0, 'oqqt_');
    $db->commit_transaction();
    $db->generateSessionAlertSuccess('New Quotation created');
    header("Location: quotations_types.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations type';
    $db->start_transaction();


    $_POST['fld_enable_renewal'] = $db->get_check_value($_POST['fld_enable_renewal']);
    $_POST['fld_renewal_issue_new_number'] = $db->get_check_value($_POST['fld_renewal_issue_new_number']);

    $_POST['fld_added_field_person_company'] = $db->get_check_value($_POST['fld_added_field_person_company']);

    $_POST['fld_added_field_identity'] = $db->get_check_value($_POST['fld_added_field_identity']);
    $_POST['fld_added_field_identity_required'] = $db->get_check_value($_POST['fld_added_field_identity_required']);

    $_POST['fld_added_field_telephone'] = $db->get_check_value($_POST['fld_added_field_telephone']);
    $_POST['fld_added_field_telephone_required'] = $db->get_check_value($_POST['fld_added_field_telephone_required']);

    $_POST['fld_added_field_email'] = $db->get_check_value($_POST['fld_added_field_email']);
    $_POST['fld_added_field_contact_person'] = $db->get_check_value($_POST['fld_added_field_contact_person']);
    $_POST['fld_added_field_extra_details'] = $db->get_check_value($_POST['fld_added_field_extra_details']);
    $_POST['fld_added_field_mobile'] = $db->get_check_value($_POST['fld_added_field_mobile']);
    $_POST['fld_added_field_city'] = $db->get_check_value($_POST['fld_added_field_city']);
    $_POST['fld_added_field_email_required'] = $db->get_check_value($_POST['fld_added_field_email_required']);
    $_POST['fld_added_field_contact_person_required'] = $db->get_check_value($_POST['fld_added_field_contact_person_required']);
    $_POST['fld_added_field_extra_details_required'] = $db->get_check_value($_POST['fld_added_field_extra_details_required']);
    $_POST['fld_added_field_mobile_required'] = $db->get_check_value($_POST['fld_added_field_mobile_required']);
    $_POST['fld_added_field_city_required'] = $db->get_check_value($_POST['fld_added_field_city_required']);

    for ($i = 1; $i <= 5; $i++) {
        $_POST['fld_extra_field_'.$i.'_required'] = $db->get_check_value($_POST['fld_extra_field_'.$i.'_required']);
    }

    $_POST['fld_allow_print_outstanding'] = $db->get_check_value($_POST['fld_allow_print_outstanding']);
    $_POST['fld_adv_edit_resent_emails'] = $db->get_check_value($_POST['fld_adv_edit_resent_emails']);

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
include('../../scripts/form_builder_class.php');
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-3');
FormBuilder::buildPageLoader();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Quotation Type <?php echo $data['oqqt_name']; ?></b>
                    </div>


                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="tab"
                               href="#general" role="tab" aria-controls="general" aria-selected="true">
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="onActive-tab" data-toggle="tab"
                               href="#onActive" role="tab" aria-controls="onActive" aria-selected="false">
                                On Active
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="onApproval-tab" data-toggle="tab" href="#onApproval"
                               role="tab" aria-controls="onApproval" aria-selected="false">
                                On Approval
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="extraFields-tab" data-toggle="tab" href="#extraFields"
                               role="tab" aria-controls="extraFields" aria-selected="false">
                                Extra Fields
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!--GENERAL TAB DATA-->
                        <div class="tab-pane fade show active" id="general" role="tabpanel"
                             aria-labelledby="general-tab">


                            <!--GENERAL TAB DATA-->

                            <div class="row" style="height: 25px;"></div>

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
                                <label for="fld_quotation_or_cover_note" class="col-sm-4 col-form-label">
                                    Quotation/Cover Note
                                </label>
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
                                <label for="fld_functions_file" class="col-sm-4 col-form-label">Functions File
                                    URL</label>
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
                                <label for="fld_print_layout2_name" class="col-sm-4 col-form-label">Print Layout 2 Name</label>
                                <div class="col-sm-8">
                                    <input name="fld_print_layout2_name" type="text" id="fld_print_layout2_name"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_print_layout2_name"]; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_print_layout2_name",
                                        "fieldDataType" => "text",
                                        "required" => false,
                                        "invalidText" => "Fill Print Layout 2 File",
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_print_layout2" class="col-sm-4 col-form-label">Print Layout 2 File</label>
                                <div class="col-sm-8">
                                    <input name="fld_print_layout2" type="text" id="fld_print_layout2"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_print_layout2"]; ?>">
                                    <?php
                                    $formValidator->addField([
                                        "fieldName" => "fld_print_layout2",
                                        "fieldDataType" => "text",
                                        "required" => false,
                                        "invalidText" => "Fill Print Layout 2 File",
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
                                <label for="fld_premium_rounding" class="col-sm-4 col-form-label">Premium
                                    Rounding</label>
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
                                            class="form-control">
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
                                <label for="fld_allow_print_outstanding" class="col-sm-4 col-form-label">Allow Print on
                                    Outstanding</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_allow_print_outstanding" name="fld_allow_print_outstanding"
                                        <?php if ($data['oqqt_allow_print_outstanding'] == 1) echo "checked"; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_enable_search_autofill" class="col-sm-4 col-form-label">Enable Search
                                    Autofill Client</label>
                                <div class="col-sm-8">
                                    <select name="fld_enable_search_autofill" id="fld_enable_search_autofill"
                                            class="form-control">
                                        <option value="1" <?php if ($data["oqqt_enable_search_autofill"] == '1') echo "selected=\"selected\""; ?>>
                                            Enable
                                        </option>
                                        <option value="0" <?php if ($data["oqqt_enable_search_autofill"] == '0') echo "selected=\"selected\""; ?>>
                                            Disable
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_quotation_number_prefix" class="col-sm-4 col-form-label">Number
                                    Prefix</label>
                                <div class="col-sm-8">
                                    <input name="fld_quotation_number_prefix" type="text"
                                           id="fld_quotation_number_prefix"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_quotation_number_prefix"]; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_quotation_number_leading_zeros" class="col-sm-4 col-form-label">Number
                                    Leading Zeros</label>
                                <div class="col-sm-8">
                                    <input name="fld_quotation_number_leading_zeros" type="text"
                                           id="fld_quotation_number_leading_zeros"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_quotation_number_leading_zeros"]; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_quotation_number_last_used" class="col-sm-4 col-form-label">Number Last
                                    Used</label>
                                <div class="col-sm-8">
                                    <input name="fld_quotation_number_last_used" type="text"
                                           id="fld_quotation_number_last_used"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_quotation_number_last_used"]; ?>">
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


                        </div>

                        <!--ON ACTIVE TAB DATA-->
                        <div class="tab-pane fade" id="onActive" role="tabpanel" aria-labelledby="onActive-tab">


                            <!--ON ACTIVE TAB DATA-->

                            <div class="form-group row">
                                <label for="fld_enable_renewal" class="col-sm-4 col-form-label">Enable Renewal</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_enable_renewal" name="fld_enable_renewal"
                                        <?php if ($data['oqqt_enable_renewal'] == 1) echo "checked"; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_renewal_issue_new_number" class="col-sm-4 col-form-label">On Renewal
                                    Issue New Number?</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_renewal_issue_new_number" name="fld_renewal_issue_new_number"
                                        <?php if ($data['oqqt_renewal_issue_new_number'] == 1) echo "checked"; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_adv_edit_resent_emails" class="col-sm-4 col-form-label">On Advanced Edit
                                    Resent Emails?</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_adv_edit_resent_emails" name="fld_adv_edit_resent_emails"
                                        <?php if ($data['oqqt_adv_edit_resent_emails'] == 1) echo "checked"; ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_enable_copy" class="col-sm-4 col-form-label">Enable Copy</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_enable_copy" name="fld_enable_copy"
                                        <?php if ($data['oqqt_enable_copy'] == 1) echo "checked"; ?>>
                                </div>
                            </div>

                            <div class="row" style="height: 25px;"></div>
                            <div class="form-group row">
                                <label for="fld_active_send_mail" class="col-sm-4 col-form-label">
                                    On active send email
                                    <br><b>ReplaceCodes</b>
                                    <br>Email||Name Break
                                    <br>[QTID] - Quotation ID
                                    <br>[QTNUMBER] - Quotation Number
                                    <br>[QTLINK] Link for the quotation
                                    <br>[USERSNAME] Name of the creator
                                    <br>[PDFLINK] Link for PDF
                                    <br>[IDENTIFIER] Link for PDF
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
                                    <textarea name="fld_active_send_mail_body" id="fld_active_send_mail_body" rows="8"
                                              class="form-control"><?php echo $data["oqqt_active_send_mail_body"]; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_attach_print_filename" class="col-sm-4 col-form-label">Attach Print PDF
                                    to email/Filename</label>
                                <div class="col-sm-8">
                                    <input name="fld_attach_print_filename" type="text" id="fld_attach_print_filename"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_attach_print_filename"]; ?>">
                                    If filename is inserted then the PDF will be attached to the email. ReplaceCodes
                                    Apply
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_enable_cancellation" class="col-sm-4 col-form-label">Enable
                                    Cencellation</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" value="1" class="form-control" style="margin-top: 12px;"
                                           id="fld_enable_cancellation" name="fld_enable_cancellation"
                                        <?php if ($data['oqqt_enable_cancellation'] == 1) echo "checked"; ?>>
                                </div>
                            </div>


                        </div>

                        <!--ON APPROVAL TAB DATA-->
                        <div class="tab-pane fade" id="onApproval" role="tabpanel" aria-labelledby="onApproval-tab">
                            <!--ON APPROVAL TAB DATA-->

                            <div class="row" style="height: 25px;"></div>
                            <div class="form-group row">
                                <label for="fld_active_send_mail" class="col-sm-4 col-form-label">
                                    On Approval send email
                                    <br><b>ReplaceCodes</b>
                                    <br>Email||Name Break
                                    <br>[QTID] - Quotation ID
                                    <br>[QTNUMBER] - Quotation Number
                                    <br>[QTLINK] Link for the quotation
                                    <br>[USERSNAME] Name of the creator
                                    <br>[PDFLINK] Link for PDF
                                    <br>[IDENTIFIER] Link for PDF
                                </label>
                                <div class="col-sm-8">
                            <textarea name="fld_approval_send_mail" id="fld_approval_send_mail"
                                      class="form-control"><?php echo $data["oqqt_approval_send_mail"]; ?></textarea>

                                    <div class="row">
                                        <label for="fld_approval_send_mail_cc" class="col-sm-3 col-form-label">
                                            CC Mail/s:<br>Email||Name \n
                                        </label>
                                        <div class="col-9">
                                    <textarea name="fld_approval_send_mail_cc" id="fld_approval_send_mail_cc"
                                              class="form-control"><?php echo $data["oqqt_approval_send_mail_cc"]; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_approval_send_mail_bcc" class="col-sm-3 col-form-label">
                                            BCC Mail/s:<br>Email||Name \n
                                        </label>
                                        <div class="col-9">
                                    <textarea name="fld_approval_send_mail_bcc" id="fld_approval_send_mail_bcc"
                                              class="form-control"><?php echo $data["oqqt_approval_send_mail_bcc"]; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_approval_send_mail_from" class="col-sm-3 col-form-label">
                                            Subject:
                                        </label>
                                        <div class="col-9">
                                    <textarea name="fld_approval_send_mail_subject" id="fld_approval_send_mail_subject"
                                              class="form-control"><?php echo $data["oqqt_approval_send_mail_subject"]; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_approval_send_mail_from" class="col-sm-3 col-form-label">
                                            Body: HTML
                                        </label>
                                        <div class="col-9">
                                    <textarea name="fld_approval_send_mail_body" id="fld_approval_send_mail_body" rows="8"
                                              class="form-control"><?php echo $data["oqqt_approval_send_mail_body"]; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_approval_attach_print_filename" class="col-sm-4 col-form-label">Attach
                                    Print PDF to email/Filename</label>
                                <div class="col-sm-8">
                                    <input name="fld_approval_attach_print_filename" type="text"
                                           id="fld_approval_attach_print_filename"
                                           class="form-control"
                                           value="<?php echo $data["oqqt_approval_attach_print_filename"]; ?>">
                                    If filename is inserted then the PDF will be attached to the email. ReplaceCodes
                                    Apply
                                </div>
                            </div>
                        </div>

                        <!--EXTRA FIELDS TAB DATA-->
                        <div class="tab-pane fade" id="extraFields" role="tabpanel" aria-labelledby="extraFields-tab">
                            <!--EXTRA FIELDS TAB DATA-->

                            <div class="row" style="height: 25px;"></div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-form-label">
                                    Added fields
                                </div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <label for="fld_added_field_person_company" class="col-sm-3 col-form-label">
                                            Person/Company:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_person_company"
                                                   name="fld_added_field_person_company"
                                                <?php if ($data['oqqt_added_field_person_company'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_identity" class="col-sm-3 col-form-label">
                                            Identity:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_identity" name="fld_added_field_identity"
                                                <?php if ($data['oqqt_added_field_identity'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_identity_required" class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_identity_required"
                                                   name="fld_added_field_identity_required"
                                                <?php if ($data['oqqt_added_field_identity_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="fld_added_field_email" class="col-sm-3 col-form-label">
                                            Email:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_email" name="fld_added_field_email"
                                                <?php if ($data['oqqt_added_field_email'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_email_required" class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_email_required"
                                                   name="fld_added_field_email_required"
                                                <?php if ($data['oqqt_added_field_email_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <label for="fld_added_field_contact_person" class="col-sm-3 col-form-label">
                                            Contact Person:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_contact_person"
                                                   name="fld_added_field_contact_person"
                                                <?php if ($data['oqqt_added_field_contact_person'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_contact_person_required"
                                               class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_contact_person_required"
                                                   name="fld_added_field_contact_person_required"
                                                <?php if ($data['oqqt_added_field_contact_person_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_extra_details" class="col-sm-3 col-form-label">
                                            Extra Details:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_extra_details"
                                                   name="fld_added_field_extra_details"
                                                <?php if ($data['oqqt_added_field_extra_details'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_extra_details_required"
                                               class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_extra_details_required"
                                                   name="fld_added_field_extra_details_required"
                                                <?php if ($data['oqqt_added_field_extra_details_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_telephone" class="col-sm-3 col-form-label">
                                            Telephone:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_telephone" name="fld_added_field_telephone"
                                                <?php if ($data['oqqt_added_field_telephone'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_telephone_required" class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_telephone_required"
                                                   name="fld_added_field_telephone_required"
                                                <?php if ($data['oqqt_added_field_telephone_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_mobile" class="col-sm-3 col-form-label">
                                            Mobile:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_mobile" name="fld_added_field_mobile"
                                                <?php if ($data['oqqt_added_field_mobile'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_mobile_required" class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_mobile_required"
                                                   name="fld_added_field_mobile_required"
                                                <?php if ($data['oqqt_added_field_mobile_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_city" class="col-sm-3 col-form-label">
                                            City:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_city" name="fld_added_field_city"
                                                <?php if ($data['oqqt_added_field_city'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_city_required" class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_city_required"
                                                   name="fld_added_field_city_required"
                                                <?php if ($data['oqqt_added_field_city_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_nationality" class="col-sm-3 col-form-label">
                                            Nationality List:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_nationality" name="fld_added_field_nationality"
                                                <?php if ($data['oqqt_added_field_nationality'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_nationality_required"
                                               class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_nationality_required"
                                                   name="fld_added_field_nationality_required"
                                                <?php if ($data['oqqt_added_field_nationality_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="fld_added_field_dob" class="col-sm-3 col-form-label">
                                            Date Of Birth:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_dob" name="fld_added_field_dob"
                                                <?php if ($data['oqqt_added_field_dob'] == 1) echo 'checked'; ?>>
                                        </div>
                                        <label for="fld_added_field_dob_required" class="col-sm-2 col-form-label">
                                            Required:
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" value="1" class="form-control"
                                                   style="margin-top: 3px;"
                                                   id="fld_added_field_dob_required" name="fld_added_field_dob_required"
                                                <?php if ($data['oqqt_added_field_dob_required'] == 1) echo 'checked'; ?>>
                                        </div>
                                    </div>

                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        ?>
                                        <div class="row">
                                            <?php
                                            $formB->setFieldName('fld_extra_field_'.$i.'_title')
                                                ->setFieldDescription('ExtraField '.$i.'')
                                                ->setLabelTitle('Leave empty to disable. English text || Greek Text')
                                                ->setFieldType('input')
                                                ->setInputValue($data['oqqt_extra_field_'.$i.'_title'])
                                                ->buildLabel();
                                            ?>
                                            <div class="col-sm-4">
                                                <?php
                                                $formB->buildInput();
                                                $formValidator->addField(
                                                    [
                                                        'fieldName' => $formB->fieldName,
                                                        'fieldDataType' => 'text',
                                                        'required' => false,
                                                        'invalidTextAutoGenerate' => true
                                                    ]);
                                                ?>
                                            </div>
                                            <label for="fld_extra_field_<?php echo $i;?>_required" class="col-sm-2 col-form-label">
                                                Required:
                                            </label>
                                            <div class="col-sm-1">
                                                <input type="checkbox" value="1" class="form-control"
                                                       style="margin-top: 3px;"
                                                       id="fld_extra_field_<?php echo $i;?>_required" name="fld_extra_field_<?php echo $i;?>_required"
                                                    <?php if ($data['oqqt_extra_field_'.$i.'_required'] == 1) echo 'checked'; ?>>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>


                                </div>

                            </div>

                            <div class="row">
                                <label for="fld_identity_replace_text" class="col-sm-4 col-form-label">
                                    Replace Identity Text with:
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control"
                                           id="fld_identity_replace_text" name="fld_identity_replace_text"
                                           value="<?php echo $data['oqqt_identity_replace_text']; ?>">
                                </div>
                                <div class="col-sm-2">
                                    ENG||GRE
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_policyholder_replace_text" class="col-sm-4 col-form-label">
                                    Replace PolicyHolder Name Text with:
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control"
                                           id="fld_policyholder_replace_text" name="fld_policyholder_replace_text"
                                           value="<?php echo $data['oqqt_policyholder_replace_text']; ?>">
                                </div>
                                <div class="col-sm-2">
                                    ENG||GRE
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="" class="col-sm-4 col-form-label">
                                    Info Page Extra Button HTML
                                </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="fld_info_page_extra_button"
                                              name="fld_info_page_extra_button"><?php echo $data['oqqt_info_page_extra_button'];?></textarea>
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
