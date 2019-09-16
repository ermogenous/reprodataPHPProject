<?php
include("../include/main.php");

$db = new Main();
$db->include_js_file("../include/jscripts.js");
$db->include_css_file("main_quotation_css.css");
$db->include_js_file("jscripts.js");

//$db->include_css_file("../scripts/bootstrap-3.3.7-dist/css/bootstrap.min.css");
//$db->include_css_file("../scripts/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css");
//$db->include_js_file("../scripts/bootstrap-3.3.7-dist/js/bootstrap.min.js");
include("quotations_functions.php");
include('quotations_class.php');
$underwriter = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = ' . $db->user_data['usr_users_ID']);
if (strpos($underwriter['oqun_allow_quotations'], '#' . $_GET["quotation_type"] . '-1#') === false) {
    header('Location: quotations.php');
    exit();
}

if ($_GET["quotation"] != "") {
    $q_data = $db->query_fetch("SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = " . $_GET["quotation"]);
    $quote = new dynamicQuotation($_GET['quotation']);
    $quotation_type_data = $quote->quotationData();
    $quotationUnderwriter = $db->query_fetch(
            'SELECT * FROM 
                  oqt_quotations_underwriters 
                  WHERE oqun_user_ID = ' . $q_data['oqq_users_ID']
    );
    //check if this quotation exists
    if ($quote->quotationData()['oqq_quotations_ID'] == '') {
        header("Location: quotations.php");
        exit();
    }

} else {
    //get the quotation type details
    $quotation_type_data = $db->query_fetch("SELECT * FROM oqt_quotations_types WHERE oqqt_quotations_types_ID = " . $_GET["quotation_type"]);
    $quote = new dynamicQuotation($_GET['quotation']);
    $quotationUnderwriter = $underwriter;
}

//first check if the user is allowed to view this quotation
if ($_GET["quotation"] != "") {
    if ($db->user_data["usr_users_ID"] != $q_data["oqq_users_ID"] && $db->user_data["usr_user_rights"] >= 3) {
        header("Location: quotations.php");
        exit();
    }
}//if not new quotation


//language defined here
if ($_POST["change_language"] != 1) {
    if ($_GET["quotation"] != "") {
        $_SESSION["oq_quotations_language"] = $q_data["oqq_language"];
    } else if ($_POST["action"] != "save") {
        //default language
        if ($quotation_type_data['oqqt_language'] == 'English') {
            $_SESSION["oq_quotations_language"] = 'en';
        } else if ($quotation_type_data['oqqt_language'] == 'Greek') {
            $_SESSION["oq_quotations_language"] = 'gr';
        } else if ($quotation_type_data['oqqt_language'] == 'BothGr') {
            $_SESSION["oq_quotations_language"] = 'gr';
        } else if ($quotation_type_data['oqqt_language'] == 'BothEn') {
            $_SESSION["oq_quotations_language"] = 'en';
        }

    }
} else {
    $_SESSION["oq_quotations_language"] = $_POST["quotation_language"];
}

if ($_POST["action"] == "save") {
    $_GET["quotation_type"] = $_POST["quotation_type"];
    $_GET["quotation"] = $_POST["quotation"];
}

//echo "L->".$_SESSION["oq_quotations_language"];


//if quotation type is inactive exit
if ($quotation_type_data["oqqt_status"] == 'I') {
    header("Location: quotations.php");
    exit();
}
//include the quotation file functions
include_once($quotation_type_data["oqqt_functions_file"]);

//link to js file from type
//$db->include_js_file($quotation_type_data["oqqt_js_file"]);

//get the items for the specified quotation.
//needed for both insert and show.
$items_sql = "SELECT * FROM `oqt_items` WHERE 
              `oqit_quotations_types_ID` = " . $_GET["quotation_type"] . " 
              ORDER BY oqit_sort";

//update the quotation if not change language and is new quotation.


if ($_POST["action"] == "save") {


    //check if change language and new quotation
    if ($_POST["change_language"] == '1' && $_GET["quotation"] == "") {
        //do nothing
    } else {
        if ($quote->quotationData()['oqit_status'] == 'Outstanding' || $db->user_data['usr_user_rights'] <= 1 || $_POST['lid'] == '') {
            $db->start_transaction();
            $quotation_id = insert_quotation_data_to_db($_POST["quotation"], $_POST["quotation_type"]);


            $items_res = $db->query($items_sql);
            while ($item = $db->fetch_assoc($items_res)) {

                $quot_ID = insert_item_data_to_db($quotation_type_data, $quotation_id, $item["oqit_items_ID"]);

            }//all items

            //update the quotations price
            //ge thte result in an array 'premium' 'fees' 'stamps'
            $premium_result = quotation_price_calculation($quotation_id);
            $sql = "UPDATE oqt_quotations SET 
		oqq_fees = " . $premium_result["fees"] . " , 
		oqq_stamps = " . $premium_result["stamps"] . " , 
		oqq_premium = " . $premium_result["premium"] . ",
		oqq_custom_premium1 = '" . $premium_result["custom_premium1"] . "',
		oqq_custom_premium2 = '" . $premium_result["custom_premium2"] . "',
		oqq_detail_price_array = '" . $premium_result["detailed_result"] . "' WHERE oqq_quotations_ID = " . $quotation_id;
            $db->query($sql);

            //check for approval
            $quote = new dynamicQuotation($quotation_id);
            if ($quote->checkForApproval() == false) {
                if ($quote->errorType == 'warning') {
                    $db->generateSessionAlertWarning($quote->errorDescription);
                } else {
                    $db->generateSessionAlertError($quote->errorDescription);
                }
            }

            $db->commit_transaction();

            //no need to redirect if is language change.
            if ($_POST["change_language"] != "1") {
                if ($_POST["save_and_print"] == 1) {
                    header("Location: " . $quotation_type_data["oqqt_print_layout"] . "?quotation=" . $quotation_id);
                } else {
                    header("Location: quotations_show.php?lid=" . $quotation_id);
                }
                exit();
            }
        }//if outstanding
        //not allowed to update
        else {
            $db->generateAlertError('Not Outstanding. Not allowed to Modify.');
        }

    }//if change language and not new quotation
}//save quotation

//retrieve users underwriter data
$underwriterData = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters 
                                        WHERE oqun_user_ID = ' . $db->user_data['usr_users_ID'] . " AND oqun_status = 'Active'");
if ($underwriterData['oqun_user_ID'] > 0) {
    //underwriter is found.
    //all ok
} else {
    //no underwriter. exit the page
    $db->generateSessionAlertError('No underwriter found for this user.');
    header('Location: quotations.php');
    exit();
}

//add a function onload
$db->admin_on_load .= 'js_function_on_load();';
$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->include_js_file('../scripts/ui_scripts.js');
$db->show_header();

include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
//$formValidator->showErrorList();
$allowEdit = true;
$allowEditAdvanced = false;
if ($quote->quotationData()['oqq_status'] != 'Outstanding' && $_GET['quotation'] > 0) {

    if ($db->user_data['usr_user_rights'] >= 3) {
        $allowEdit = false;
        $formValidator->disableForm();
    } //allow in case administrator/advanced user
    else {
        $allowEditAdvanced = true;
    }
}
$formValidator->addCustomCode("
    if ($('#warningDivSection').html() != '' && FormErrorFound == false){
        if (confirm('Warnings Found. Are you sure you want to continue?')){
            
        }
        else {
            FormErrorFound = true;  
        }
    }
    
    if ($('#alertDivSection').html() != '' && FormErrorFound == false){
        alert('Error Found. Cannot Proceed');
        FormErrorFound = true;  
    }
    
");
$formValidator->showErrorList();

?>
<script language="JavaScript" type="text/javascript">

    function check_quotation_form() {
        var result;

        //this function must exists in the js folder of the quotation type.
        result = custom_js_functions_return();

        //check if result is empty
        if (result == '')
            return true;
        else {
            alert(result);
            return false;
        }
    }

</script>
<div class="container">
    <div class="row">
        <div class="d-none col-md-1"></div>
        <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10">
            <form name="myForm" id="myForm" method="post" action=""
                <?php $formValidator->echoFormParameters(); ?>>

                <?php if ($allowEdit == false) { ?>
                    <div class="alert alert-warning">
                        <?php echo $quote->getQuotationType() . " is " . $quote->quotationData()['oqq_status'] . " Cannot modify"; ?>
                    </div>
                <?php } ?>
                <?php if ($allowEditAdvanced == true) { ?>
                    <div class="alert alert-success">
                        <?php echo "Advanced User. Allowed to Modify."; ?>
                    </div>
                <?php } ?>
                <div class="alert alert-success text-center">
                    <b><?php echo $quotation_type_data["oqqt_quotation_label_" . $_SESSION["oq_quotations_language"]]; ?></b>
                </div>
                <div class="container">
                    <div class="form-group row">
                        <div class="col-sm-9 text-center">
                            <b><?php show_quotation_text("Βασικές Πληροφορίες Συμβαλλομένου", "Policyholder Basic Information"); ?></b>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            if (substr($quotation_type_data['oqqt_language'], 0, 4) == 'Both') {
                                ?>
                                <input name="change_language" id="change_language" type="hidden" value="0"/>
                                <select name="quotation_language" id="quotation_language"
                                        onchange="document.getElementById('change_language').value = 1; document.myForm.submit();"
                                        class="form-control"
                                        required>
                                    <option value="gr" <?php if ($_SESSION["oq_quotations_language"] == 'gr') echo "selected=\"selected\""; ?>>
                                        Ελληνικά
                                    </option>
                                    <option value="en" <?php if ($_SESSION["oq_quotations_language"] == 'en') echo "selected=\"selected\""; ?>>
                                        English
                                    </option>
                                </select>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="insureds_name" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Ονομα Συμβαλλόμενου", "Policyholder Name"); ?>
                        </label>
                        <div class="col-sm-<?php if ($quotation_type_data['oqqt_enable_search_autofill'] == 1) echo "4"; else echo "8"; ?>">
                            <input name="insureds_name" type="text" id="insureds_name"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_name"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'insureds_name',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => show_quotation_text("Συμπληρώστε το Όνομα Συμβαλλόμενου.", "Must Enter Policyholder Name", 'Return')
                                ]);
                            ?>

                        </div>

                        <?php if ($quotation_type_data['oqqt_enable_search_autofill'] == 1) { ?>
                            <div class="col-sm-4 form-inline">
                                &nbsp;&nbsp;<i class="fas fa-search"></i>&nbsp;

                                <input name="search_name" type="text" id="search_name"
                                       class="form-control"
                                       value="">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'search_name',
                                        'fieldDataType' => 'text'
                                    ]);
                                ?>
                                &nbsp;
                                <i class="fas fa-spinner" id="client_search_autofill_loading"
                                   style="display: none;"></i>
                                <i class="fas fa-check" id="client_search_autofill_found" style="display: none;"></i>
                                <i class="fas fa-times" id="client_search_autofill_not_found"
                                   style="display: none;"></i>
                            </div>
                            <script>
                                $('#search_name').focusout(
                                    function () {
                                        $('#client_search_autofill_found').hide();
                                        $('#client_search_autofill_not_found').hide();
                                        $('#client_search_autofill_loading').hide();
                                    }
                                );
                                $('#search_name').autocomplete({
                                    source: 'quotations_api.php?section=quotations_search_autofill',
                                    delay: 500,
                                    minLength: 2,
                                    messages: {
                                        noResults: function () {
                                            $('#client_search_autofill_not_found').show();
                                        },
                                        results: function () {
                                            $('#client_search_autofill_found').show();
                                        }
                                    },
                                    focus: function (event, ui) {
                                        $('#customerSelect').val(ui.item.label);
                                        //console.log('Focus event');
                                        return false;
                                    },
                                    search: function (event, ui) {
                                        $('#client_search_autofill_loading').show();
                                        $('#client_search_autofill_found').hide();
                                        $('#client_search_autofill_not_found').hide();
                                        //console.log('Search event');
                                    },
                                    response: function (event, ui) {
                                        $('#client_search_autofill_loading').hide();
                                    },
                                    select: function (event, ui) {

                                        $('#insureds_name').val(ui.item.clo_name);
                                        $('#insureds_id').val(ui.item.clo_id);
                                        $('#insureds_tel').val(ui.item.clo_tel);
                                        $('#insureds_mobile').val(ui.item.clo_mobile);
                                        $('#insureds_email').val(ui.item.clo_email);
                                        $('#insureds_contact_person').val(ui.item.clo_contact_person);
                                        $('#insureds_address').val(ui.item.clo_address);
                                        $('#insureds_postal_code').val(ui.item.clo_postal_code);

                                        $('#client_search_autofill_found').hide();
                                        $('#client_search_autofill_not_found').hide();
                                        $('#search_name').val('');
                                        return false;
                                    }
                                });
                            </script>

                        <?php } ?>
                    </div>

                    <div class="form-group row">
                        <label for="insureds_id" class="col-sm-4 col-form-label">
                            <?php
                            $idText = $quotation_type_data['oqqt_identity_replace_text'];
                            if ($idText == '') {
                                $idGreek = 'Ταυτότητα';
                                $idEnglish = 'Identity Card';
                            } else {
                                $idText = explode('||', $idText);
                                $idGreek = $idText[1];
                                $idEnglish = $idText[0];
                            }
                            show_quotation_text($idGreek, $idEnglish);
                            ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_id" type="text" id="insureds_id"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_id"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'insureds_id',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => show_quotation_text("Συμπληρώστε Ταυτότητα.", "Must Enter Identity Card", 'Return')
                                ]);
                            ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="insureds_tel" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Τηλέφωνο", "Telephone"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_tel" type="text" id="insureds_tel"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_tel"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'insureds_tel',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => show_quotation_text("Συμπληρώστε Τηλέφωνο.", "Must Enter Telephone", 'Return')
                                ]);
                            ?>
                        </div>
                    </div>

                    <?php if ($quotation_type_data['oqqt_added_field_nationality'] == 1) { ?>
                        <div class="form-group row">
                            <label for="nationality_ID" class="col-sm-4 col-form-label">
                                <?php show_quotation_text("Ιθαγένεια", "Nationality"); ?>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="nationality_ID" name="nationality_ID">
                                    <option value=""></option>
                                    <?php
                                    $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                                    $result = $db->query($sql);
                                    while ($count = $db->fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $count['cde_code_ID']; ?>"
                                            <?php if ($q_data['oqq_nationality_ID'] == $count['cde_code_ID']) echo "selected"; ?>
                                        ><?php echo $count['cde_value']; ?></option>
                                    <?php } ?>
                                </select>
                                <?php
                                $nationalityRequired = false;
                                if ($quotation_type_data['oqqt_added_field_nationality_required'] == 1) {
                                    $nationalityRequired = true;
                                }

                                $formValidator->addField(
                                    [
                                        'fieldName' => 'nationality_ID',
                                        'fieldDataType' => 'select',
                                        'required' => $nationalityRequired,
                                        'invalidText' => show_quotation_text("Επιλέξατε Ιθαγένεια", "Must select nationality", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($quotation_type_data['oqqt_added_field_dob'] == 1) { ?>
                        <div class="form-group row">
                            <label for="birthdate" class="col-sm-4 col-form-label">
                                <?php show_quotation_text("Ημ. Γέννησης", "Date of Birth"); ?>
                            </label>
                            <div class="col-sm-8">
                                <input name="birthdate" type="text" id="birthdate"
                                       class="form-control"
                                       value="">
                                <?php
                                $dobRequired = false;
                                if ($quotation_type_data['oqqt_added_field_dob_required'] == 1) {
                                    $dobRequired = true;
                                }

                                $formValidator->addField(
                                    [
                                        'fieldName' => 'birthdate',
                                        'fieldDataType' => 'date',
                                        'required' => $dobRequired,
                                        'enableDatePicker' => true,
                                        'datePickerValue' => $db->convertDateToEU($q_data["oqq_birthdate"]),
                                        'invalidText' => show_quotation_text("Συμπληρώστε Ημ. Γέννησης.", "Must Enter Date of Birth", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($quotation_type_data['oqqt_added_field_mobile'] == 1) { ?>
                        <div class="form-group row">
                            <label for="insureds_mobile" class="col-sm-4 col-form-label">
                                <?php show_quotation_text("Κινητό Τηλ.", "Mobile"); ?>
                            </label>
                            <div class="col-sm-8">
                                <input name="insureds_mobile" type="text" id="insureds_mobile"
                                       class="form-control"
                                       value="<?php echo $q_data["oqq_insureds_mobile"]; ?>">
                                <?php
                                $mobileRequired = false;
                                if ($quotation_type_data['oqqt_added_field_mobile_required'] == 1) {
                                    $mobileRequired = true;
                                }

                                $formValidator->addField(
                                    [
                                        'fieldName' => 'insureds_mobile',
                                        'fieldDataType' => 'text',
                                        'required' => $mobileRequired,
                                        'invalidText' => show_quotation_text("Συμπληρώστε Κινητό Τηλ.", "Must Enter Mobile", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($quotation_type_data['oqqt_added_field_email'] == 1) { ?>
                        <div class="form-group row">
                            <label for="insureds_email" class="col-sm-4 col-form-label">
                                <?php show_quotation_text("Email", "Email"); ?>
                            </label>
                            <div class="col-sm-8">
                                <input name="insureds_email" type="text" id="insureds_email"
                                       class="form-control"
                                       value="<?php echo $q_data["oqq_insureds_email"]; ?>">
                                <?php
                                $emailRequired = false;
                                if ($quotation_type_data['oqqt_added_field_email_required'] == 1) {
                                    $emailRequired = true;
                                }
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'insureds_email',
                                        'fieldDataType' => 'text',
                                        'required' => $emailRequired,
                                        'invalidText' => show_quotation_text("Συμπληρώστε Email.", "Must Enter Email", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php }
                    if ($quotation_type_data['oqqt_added_field_contact_person'] == 1) { ?>
                        <div class="form-group row">
                            <label for="insureds_contact_person" class="col-sm-4 col-form-label">
                                <?php show_quotation_text("Όνομα Επικοινωνίας", "Contact Person"); ?>
                            </label>
                            <div class="col-sm-8">
                                <input name="insureds_contact_person" type="text" id="insureds_contact_person"
                                       class="form-control"
                                       value="<?php echo $q_data["oqq_insureds_contact_person"]; ?>">
                                <?php
                                $contactRequired = false;
                                if ($quotation_type_data['oqqt_added_field_contact_person_required'] == 1) {
                                    $contactRequired = true;
                                }
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'insureds_contact_person',
                                        'fieldDataType' => 'text',
                                        'required' => $contactRequired,
                                        'invalidText' => show_quotation_text("Συμπληρώστε Όνομα Επικοινωνίας.", "Must Enter Contact Person", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group row">
                        <label for="insureds_address" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Διεύθυνση", "Address"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_address" type="text" id="insureds_address"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_address"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'insureds_address',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => show_quotation_text("Συμπληρώστε Διεύθυνση.", "Must Enter Address", 'Return')
                                ]);
                            ?>
                            <div class="invalid-feedback" id="insureds_address_invalid_tooltip">afdsf</div>
                        </div>
                    </div>

                    <?php
                    if ($quotation_type_data['oqqt_added_field_city'] == 1) { ?>
                        <div class="form-group row">
                            <label for="insureds_city" class="col-sm-4 col-form-label">
                                <?php show_quotation_text("Πόλη", "City"); ?>
                            </label>
                            <div class="col-sm-8">

                                <select name="insureds_city" id="insureds_city"
                                        class="form-control">
                                    <option value=""></option>
                                    <option value="Λεμεσός" <?php if ($q_data['oqq_insureds_city'] == 'Λεμεσός' || $q_data['oqq_insureds_city'] == 'Limassol') echo "selected"; ?>><?php show_quotation_text("Λεμεσός", "Limassol"); ?></option>
                                    <option value="Λευκωσία" <?php if ($q_data['oqq_insureds_city'] == 'Λευκωσία' || $q_data['oqq_insureds_city'] == 'Nicosia') echo "selected"; ?>><?php show_quotation_text("Λευκωσία", "Nicosia"); ?></option>
                                    <option value="Λάρνακα" <?php if ($q_data['oqq_insureds_city'] == 'Λάρνακα' || $q_data['oqq_insureds_city'] == 'Larnaka') echo "selected"; ?>><?php show_quotation_text("Λάρνακα", "Larnaka"); ?></option>
                                    <option value="Πάφος" <?php if ($q_data['oqq_insureds_city'] == 'Πάφος' || $q_data['oqq_insureds_city'] == 'Paphos') echo "selected"; ?>><?php show_quotation_text("Πάφος", "Paphos"); ?></option>
                                    <option value="Αμμόχωστος" <?php if ($q_data['oqq_insureds_city'] == 'Αμμόχωστος' || $q_data['oqq_insureds_city'] == 'Famagusta') echo "selected"; ?>><?php show_quotation_text("Αμμόχωστος", "Famagusta"); ?></option>
                                    <option value="Κερύνεια" <?php if ($q_data['oqq_insureds_city'] == 'Κερύνεια' || $q_data['oqq_insureds_city'] == 'Kyrenia') echo "selected"; ?>><?php show_quotation_text("Κερύνεια", "Kyrenia"); ?></option>
                                </select>
                                <?php
                                $cityRequired = false;
                                if ($quotation_type_data['oqqt_added_field_city_required'] == 1) {
                                    $cityRequired = true;
                                }
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'insureds_city',
                                        'fieldDataType' => 'select',
                                        'required' => $cityRequired,
                                        'invalidText' => show_quotation_text("Επιλέξατε Πόλη.", "Must Select City", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group row">
                        <label for="insureds_postal_code" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Ταχ.Κωδ.", "Postal Code"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_postal_code" type="text" id="insureds_postal_code"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_postal_code"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'insureds_postal_code',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => show_quotation_text("Συμπληρώστε Ταχ.Κωδ..", "Must Enter Postal Code", 'Return')
                                ]);
                            ?>
                        </div>
                    </div>

                </div>

                <?php

                //dynamic data

                $items_res = $db->query($items_sql);

                while ($items_data = $db->fetch_assoc($items_res)) {

                    //load the quotation item data
                    if ($_GET["quotation"] != "") {
                        $qitem_data = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $_GET["quotation"] . " AND oqqit_items_ID = " . $items_data["oqit_items_ID"]);
                    }

                    //check to see if start expanded.
                    //first check if its modify action and there is a value in insured_amount_1 for this quotation_item

                    if ($qitem_data["oqqit_insured_amount_1"] != "") {
                        $start_expanded_image = 'minus';
                        $start_expanded_div = 'block';
                        $hidden_value = 1;
                    } else if ($items_data["oqit_start_expanded"] == 1) {
                        $start_expanded_image = 'minus';
                        $start_expanded_div = 'block';
                        $hidden_value = 1;
                    } else {
                        $start_expanded_image = 'plus';
                        $start_expanded_div = 'none';
                        $hidden_value = 0;
                    }
                    ?>

                    <?php if ($items_data['oqit_hide_name_bar'] != 1) { ?>
                        <div class="alert alert-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <?php
                                    if ($items_data['oqit_disable_expansion'] == 0) {
                                        ?>
                                        +/-
                                    <?php } ?>
                                    <input name="plusminus_hidden_<?php echo $items_data["oqit_items_ID"]; ?>"
                                           type="hidden"
                                           id="plusminus_hidden_<?php echo $items_data["oqit_items_ID"]; ?>"
                                           value="<?php echo $hidden_value; ?>"/>
                                    <b>
                                        <?php echo show_quotation_text($items_data["oqit_label_gr"], $items_data["oqit_label_en"]); ?>
                                    </b>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="container-fluid"
                         id="section1_div<?php echo $items_data["oqit_items_ID"]; ?>">
                        <?php
                        //execute the item function
                        $item_function = $items_data["oqit_function"];
                        $item_function();
                        ?>
                    </div>

                <?php }
                if ($quotation_type_data['oqqt_added_field_extra_details'] == 1) {
                    $extraDetailsRequired = false;
                    if ($quotation_type_data['oqqt_added_field_extra_details_required'] == 1) {
                        $extraDetailsRequired = true;
                    }
                    ?>

                    <div class="container">
                        <div class="form-group row">
                            <label for="fld_quotation_label_gr" class="col-sm-4 col-form-label">
                                <?php echo show_quotation_text('Επιπρόσθετες Πληροφορίες', 'Extra Details'); ?>
                            </label>
                            <div class="col-sm-8">
                            <textarea name="situations_extra_details" id="situations_extra_details"
                                      class="form-control"><?php echo $q_data["oqq_extra_details"]; ?></textarea>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'situations_extra_details',
                                        'fieldDataType' => 'text',
                                        'required' => $extraDetailsRequired,
                                        'invalidText' => show_quotation_text("Συμπληρώστε Επιπρόσθετες Πληροφορίες", "Must Enter Extra Details", 'Return')
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- BUTTONS -->
                <div class="form-group row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <input name="quotation" type="hidden" id="quotation"
                               value="<?php echo $_GET["quotation"]; ?>"/>
                        <input name="quotation_type" type="hidden" id="quotation_type"
                               value="<?php echo $_GET["quotation_type"]; ?>"/>
                        <input name="action" type="hidden" id="action" value="save"/>

                        <!--
                        <input type="button" name="Submit" value="Save Quotation" class="btn btn-secondary"
                               onclick=" if (check_quotation_form()) {document.myForm.submit();}"/>
                        -->
                        <div class="btn btn-secondary" onclick="window.location.assign('quotations.php')">Back</div>
                        <input name="save_and_print" id="save_and_print" type="hidden" value="0"/>
                        <?php if ($allowEdit == true) { ?>
                            <input type="submit" value="Save Quotation"
                                   class="btn btn-secondary"
                                   onclick="document.getElementById('save_and_print').value = 0;">
                        <?php } ?>
                        <input name="save_and_print" id="save_and_print" type="hidden" value="0"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 alert alert-warning text-center" id="warningDivSection"
                         style="display: none"></div>
                    <div class="col-12 alert alert-danger text-center" id="alertDivSection"
                         style="display: none"></div>
                </div>

            </form>
        </div>
        <div class="d-none col-md-1"></div>


    </div>
</div>

<script>
    var allWarning = Object;
    var allAlert = Object;

    function addNewWarning(warning, warningID) {

        allWarning[warningID] = warning;
        showWarning();
    }

    function addNewAlert(alert, alertID) {

        allAlert[alertID] = alert;
        showAlert();
    }

    function removeWarning(warningID) {
        if (allWarning[warningID] != '') {
            allWarning[warningID] = '';
        }
        showWarning();
    }

    function removeAlert(alertID) {
        if (allAlert[alertID] != '') {
            allAlert[alertID] = '';
        }
        showAlert();
    }

    function showWarning() {
        let allHtml = 'Warning! - ';
        let i = 0;
        $.each(allWarning, function (key, value) {
            if (value != '') {
                i++;
                if (i > 1) {
                    allHtml += '<br>';
                }
                allHtml += value;
            }
        });
        if (i > 0) {
            $('#warningDivSection').show();
            $('#warningDivSection').html(allHtml);
        }
        else {
            $('#warningDivSection').hide();
            $('#warningDivSection').html('');
        }
    }

    function showAlert() {
        let allHtml = 'Alert! - ';
        let i = 0;
        $.each(allAlert, function (key, value) {
            if (value != '') {
                i++;
                if (i > 1) {
                    allHtml += '<br>';
                }
                allHtml += value;
            }
        });
        if (i > 0) {
            $('#alertDivSection').show();
            $('#alertDivSection').html(allHtml);
        }
        else {
            $('#alertDivSection').hide();
            $('#alertDivSection').html('');
        }
    }

    //check if a function named Approval[fieldID] exists. If does then executes the function and gets the result
    //if in the result[result] is equal to 0 then issue warning.
    $("#myForm :input").change(function () {
        updateWarnings($(this)[0]['id']);
        updateAlerts($(this)[0]['id']);
    });

    function updateWarnings(fieldID) {

        var result = [];
        var functionString = 'if (typeof Approval' + fieldID + ' === "function") {result = Approval' + fieldID + '();}';
        eval(functionString);
        if (result['result'] == 1) {
            addNewWarning(result['info'], fieldID);
        }
        else {
            removeWarning(fieldID);
        }
    }

    //checks if function Reject[fieldID] exists and executes and gets the result
    //if in the result[result] is equal to 0 then issue alert.
    function updateAlerts(fieldID) {

        var result = [];
        var functionString = 'if (typeof Reject' + fieldID + ' === "function") {result = Reject' + fieldID + '();}';
        eval(functionString);
        if (result['result'] == 1) {
            addNewAlert(result['info'], fieldID);
        }
        else {
            removeAlert(fieldID);
        }
    }


</script>

<?php
$formValidator->output();

include($quotation_type_data["oqqt_js_file"]);
$db->show_footer();
?>
