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

if ($_GET["quotation"] != "") {
    $q_data = $db->query_fetch("SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = " . $_GET["quotation"]);
}

//first check if the user is allowed to view this quotation
if ($_GET["quotation"] != "") {
    if ($db->user_data["usr_users_ID"] != $q_data["oqq_users_ID"] && $db->user_data["usr_user_rights"] != 0) {

        header("Location: quotations.php");
        exit();

    }
}//if not new quotation

//language defined here
if ($_POST["change_language"] != 1) {
    if ($_GET["quotation"] != "") {
        $_SESSION["oq_quotations_language"] = $q_data["oqq_language"];
    } else if ($_POST["action"] != "save") {
        $_SESSION["oq_quotations_language"] = 'gr';
    }
} else {
    $_SESSION["oq_quotations_language"] = $_POST["quotation_language"];
}

if ($_POST["action"] == "save") {
    $_GET["quotation_type"] = $_POST["quotation_type"];
    $_GET["quotation"] = $_POST["quotation"];
}

//echo "L->".$_SESSION["oq_quotations_language"];

//get the quotation details
$quotation_type_data = $db->query_fetch("SELECT * FROM oqt_quotations_types WHERE oqqt_quotations_types_ID = " . $_GET["quotation_type"]);

//if quotation type is inactive exit
if ($quotation_type_data["oqqt_status"] == 'I') {
    header("Location: quotations.php");
    exit();
}

//include the quotation file functions
include($quotation_type_data["oqqt_functions_file"]);
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


        //no need to redirect if is language change.
        if ($_POST["change_language"] != "1") {
            if ($_POST["save_and_print"] == 1) {
                header("Location: " . $quotation_type_data["oqqt_print_layout"] . "?quotation=" . $quotation_id);
            } else {
                header("Location: quotations_show.php?price_id=" . $quotation_id);
            }
            exit();
        }

    }//if change language and not new quotation
}//save quotation

//add a function onload
$db->admin_on_load .= 'js_function_on_load();';
$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
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
        <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
        <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="return check_quotation_form();">

                <div class="alert alert-success text-center">
                    <b><?php echo $quotation_type_data["oqqt_quotation_label_" . $_SESSION["oq_quotations_language"]]; ?></b>
                </div>
                <div class="container">
                    <div class="form-group row">
                        <div class="col-sm-9 text-center">
                            <b><?php show_quotation_text("Βασικές Πληροφορίες Συμβαλλομένου", "Policyholder Basic Information"); ?></b>
                        </div>
                        <div class="col-sm-3">
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
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="insureds_name" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Ονομα Συμβαλλόμενου", "Policyholder Name"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_name" type="text" id="insureds_name"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_name"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="insureds_id" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Ταυτότητα", "Identity Card"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_id" type="text" id="insureds_id"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_id"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="insureds_tel" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Τηλέφωνο", "Telephone"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_tel" type="text" id="insureds_tel"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_tel"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="insureds_address" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Διεύθυνση", "Address"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_address" type="text" id="insureds_address"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_address"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="insureds_postal_code" class="col-sm-4 col-form-label">
                            <?php show_quotation_text("Ταχ.Κωδ.", "Postal Code"); ?>
                        </label>
                        <div class="col-sm-8">
                            <input name="insureds_postal_code" type="text" id="insureds_postal_code"
                                   class="form-control"
                                   value="<?php echo $q_data["oqq_insureds_postal_code"]; ?>"
                                   required>
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

                    <div class="alert alert-success">
                        <div class="row">
                            <div class="col-4">
                                +/-
                                <input name="plusminus_hidden_<?php echo $items_data["oqit_items_ID"]; ?>" type="hidden"
                                       id="plusminus_hidden_<?php echo $items_data["oqit_items_ID"]; ?>"
                                       value="<?php echo $hidden_value; ?>"/>
                            </div>
                            <div class="col-8">
                                <b>
                                    <?php echo show_quotation_text($items_data["oqit_label_gr"], $items_data["oqit_label_en"]); ?>
                                </b>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid"
                         id="section1_div<?php echo $items_data["oqit_items_ID"]; ?>">
                        <?php
                        //execute the item function
                        $item_function = $items_data["oqit_function"];
                        $item_function();
                        ?>
                    </div>

                <?php } ?>

                <div class="form-group row">
                    <label for="fld_quotation_label_gr" class="col-sm-4 col-form-label">
                        Extra Details
                    </label>
                    <div class="col-sm-8">
                            <textarea name="situations_extra_details" id="situations_extra_details"
                                      class="form-control">
                                <?php echo $q_data["oqq_extra_details"]; ?>
                            </textarea>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="quotation" type="hidden" id="quotation"
                               value="<?php echo $_GET["quotation"]; ?>"/>
                        <input name="quotation_type" type="hidden" id="quotation_type"
                               value="<?php echo $_GET["quotation_type"]; ?>"/>
                        <input name="action" type="hidden" id="action" value="save"/>

                        <input type="button" name="Submit" value="Save Quotation" class="btn btn-secondary"
                               onclick="document.getElementById('save_and_print').value = 0; if (check_quotation_form()) {document.myForm.submit();}"/>
                        <input name="save_and_print" id="save_and_print" type="hidden" value="0"/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
include($quotation_type_data["oqqt_js_file"]);
$db->show_footer();
?>
