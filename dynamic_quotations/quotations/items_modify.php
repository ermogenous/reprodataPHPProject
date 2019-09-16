<?php
include("../../include/main.php");
$db = new Main(1, 'UTF-8');
$db->admin_title = "Quotations Type Item Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Insert new quotations type item';
    $db->start_transaction();

    $db->db_tool_insert_row('oqt_items', $_POST, 'fld_',0,'oqit_','execute');

    $db->commit_transaction();

    header("Location: items.php?info=New Item created");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Modify quotations type item';
    $db->start_transaction();

    $db->db_tool_update_row('oqt_items', $_POST, "`oqit_items_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'oqit_');

    $db->commit_transaction();

    header("Location: items.php?info=Item updated");
    exit();

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("SELECT * FROM `oqt_items` WHERE `oqit_items_ID` = " . $_GET["lid"]);
}

$db->show_header();


include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 hidden-xs hidden-sm"></div>
            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Quotation Type</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_quotations_types_ID" class="col-sm-3 col-form-label">Quotation</label>
                        <div class="col-sm-6">
                            <select name="fld_quotations_types_ID" id="fld_quotations_types_ID"
                                    class="form-control"
                                    required>
                                <option value="">Select</option>
                                <?php
                                $quot_res = $db->query("SELECT * FROM oqt_quotations_types");
                                while ($quot = $db->fetch_assoc($quot_res)) {
                                    ?>
                                    <option value="<?php echo $quot["oqqt_quotations_types_ID"]; ?>" <?php if ($quot["oqqt_quotations_types_ID"] == $data["oqit_quotations_types_ID"]) echo "selected=\"selected\""; ?>><?php echo $quot["oqqt_name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label for="fld_sort" class="col-sm-1 col-form-label">Sort</label>
                        <div class="col-sm-2">
                            <input name="fld_sort" type="text" id="fld_sort"
                                   class="form-control"
                                   value="<?php echo $data["oqit_sort"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input name="fld_name" type="text" id="fld_name"
                                   class="form-control"
                                   value="<?php echo $data["oqit_name"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_label_gr" class="col-sm-4 col-form-label">Quotation Label
                            GR</label>
                        <div class="col-sm-8">
                            <textarea name="fld_label_gr" id="fld_label_gr"
                                      class="form-control"><?php echo $data["oqit_label_gr"]; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_label_en" class="col-sm-4 col-form-label">Quotation Label
                            EN</label>
                        <div class="col-sm-8">
                            <textarea name="fld_label_en" id="fld_label_en"
                                      class="form-control"><?php echo $data["oqit_label_en"]; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_function" class="col-sm-4 col-form-label">Function to execute</label>
                        <div class="col-sm-8">
                            <input name="fld_function" type="text" id="fld_function"
                                   class="form-control"
                                   value="<?php echo $data["oqit_function"]; ?>"
                                   >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_start_expanded" class="col-sm-4 col-form-label">Start Expanded</label>
                        <div class="col-sm-4">
                            <select name="fld_start_expanded" id="fld_start_expanded"
                                    class="form-control"
                                    required>
                                <option value="0" <?php if ($data["oqit_start_expanded"] == '0') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                                <option value="1" <?php if ($data["oqit_start_expanded"] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_disable_expansion" class="col-sm-4 col-form-label">Disable
                            Expansion</label>
                        <div class="col-sm-4">
                            <select name="fld_disable_expansion" id="fld_disable_expansion"
                                    class="form-control"
                                    required>
                                <option value="0" <?php if ($data["oqit_disable_expansion"] == '0') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                                <option value="1" <?php if ($data["oqit_disable_expansion"] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_hide_name_bar" class="col-sm-4 col-form-label">Hide Name Banner</label>
                        <div class="col-sm-4">
                            <select name="fld_hide_name_bar" id="fld_hide_name_bar"
                                    class="form-control"
                                    required>
                                <option value="0" <?php if ($data["oqit_hide_name_bar"] == '0') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                                <option value="1" <?php if ($data["oqit_hide_name_bar"] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center"><b>Fields</b></div>
                    </div>
                    <?php for ($i = 1; $i <= 15; $i++) { ?>
                        <div class="form-group row">
                            <label for="fld_insured_amount_<?php echo $i; ?>" class="col-sm-4 col-form-label">Insured
                                amount <?php echo $i; ?></label>
                            <div class="col-sm-8">
                                <input name="fld_insured_amount_<?php echo $i; ?>" type="text"
                                       id="fld_insured_amount_<?php echo $i; ?>"
                                       class="form-control"
                                       value="<?php echo $data["oqit_insured_amount_" . $i]; ?>">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group row">
                        <label for="fld_date_1" class="col-sm-4 col-form-label">
                            Date Field Label 1
                        </label>
                        <div class="col-sm-8">
                            <input name="fld_date_1" type="text"
                                   id="fld_date_1"
                                   class="form-control"
                                   value="<?php echo $data["oqit_date_1"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_date_2" class="col-sm-4 col-form-label">
                            Date Field Label 2
                        </label>
                        <div class="col-sm-8">
                            <input name="fld_date_2" type="text"
                                   id="fld_date_2"
                                   class="form-control"
                                   value="<?php echo $data["oqit_date_2"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_date_3" class="col-sm-4 col-form-label">
                            Date Field Label 3
                        </label>
                        <div class="col-sm-8">
                            <input name="fld_date_3" type="text"
                                   id="fld_date_3"
                                   class="form-control"
                                   value="<?php echo $data["oqit_date_3"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_date_4" class="col-sm-4 col-form-label">
                            Date Field Label 4
                        </label>
                        <div class="col-sm-8">
                            <input name="fld_date_4" type="text"
                                   id="fld_date_4"
                                   class="form-control"
                                   value="<?php echo $data["oqit_date_4"]; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                                Rates -&gt; For amount use A10 (+10) For * Use *0.15
                                (15%) <br/>
                                To get the value from the form use GET_FROM_FORM
                            </div>
                    </div>

                    <?php for ($i = 1; $i <= 15; $i++) { ?>
                        <div class="form-group row">
                            <label for="fld_rate_<?php echo $i; ?>" class="col-sm-4 col-form-label">Rate <?php echo $i; ?></label>
                            <div class="col-sm-8">
                                <input name="fld_rate_<?php echo $i; ?>" type="text"
                                       id="fld_rate_<?php echo $i; ?>"
                                       class="form-control"
                                       value="<?php echo $data["oqit_rate_" . $i]; ?>">
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
                                   onclick="window.location.assign('items.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Quotation Type Item"
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