<?php
include('mff_insured_amounts_function.php');
//shows the tables for each section (item)
//the name of the field is OQIT_ITEMS_ID"_"FIELD_NAME
function mff_insured_details_1()
{
    global $db, $items_data, $qitem_data;
    ?>

    <div class="form-group row">
        <label for="1_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Όνομα Ασφαλιζόμενου", "Insured Name"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_1" type="text" id="1_oqqit_rate_1"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_1"]; ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Τόπος Συνήθους Εργασίας", "Place of Usual Business"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_2" type="text" id="1_oqqit_rate_2"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_2"]; ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_3" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Επάγγελμα", "Occupation"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_3" type="text" id="1_oqqit_rate_3"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_3"]; ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_4" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Αριθμός Διαβατηρίου", "Passport Number"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_4" type="text" id="1_oqqit_rate_4"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_4"]; ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_5" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Χώρα", "Country"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_5" type="text" id="1_oqqit_rate_5"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_5"]; ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_date_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Ημερομηνία Γέννησης", "Date of Birth"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_date_1" type="text" id="1_oqqit_date_1"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_date_1"]; ?>"
                   required>
        </div>
    </div>
    <script>
        $(function () {
            $("#1_oqqit_date_1").datepicker();
            $("#1_oqqit_date_1").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#1_oqqit_date_1").val('<?php echo $db->convert_date_format($qitem_data["oqqit_date_1"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

        });

    </script>

    <div class="form-group row">
        <label for="1_oqqit_rate_6" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Γένος", "Gender"); ?>
        </label>
        <div class="col-sm-8">
            <select name="1_oqqit_rate_6" id="1_oqqit_rate_6"
                    class="form-control"
                    required>
                <option value="Male" <?php if ($qitem_data['oqqit_rate_6'] == 'Male') echo 'selected'; ?>>
                    <?php show_quotation_text("Άρρεν", "Male"); ?>
                </option>
                <option value="Female" <?php if ($qitem_data['oqqit_rate_6'] == 'Female') echo 'selected'; ?>>
                    <?php show_quotation_text("Θήλυ", "Female"); ?>
                </option>
            </select>
        </div>
    </div>

    <?php
}//section 2

function mff_insurance_period_2()
{
    global $db, $items_data, $qitem_data;
    ?>
    <div class="form-group row">
        <label for="2_oqqit_date_1" class="col-sm-2 col-form-label">
            <?php show_quotation_text("Από", "From"); ?>
        </label>
        <div class="col-sm-4">
            <input name="2_oqqit_date_1" type="text" id="2_oqqit_date_1"
                   class="form-control"
                   required>
        </div>
        <label for="2_oqqit_date_2" class="col-sm-2 col-form-label">
            <?php show_quotation_text("Μέχρι", "To"); ?>
        </label>
        <div class="col-sm-4">
            <input name="2_oqqit_date_2" type="text" id="2_oqqit_date_2"
                   class="form-control"
                   required>
        </div>
    </div>
    <script>
        $(function () {
            $("#2_oqqit_date_1").datepicker();
            $("#2_oqqit_date_1").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#2_oqqit_date_1").val('<?php echo $db->convert_date_format($qitem_data["oqqit_date_1"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

        });

        $(function () {
            $("#2_oqqit_date_2").datepicker();
            $("#2_oqqit_date_2").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#2_oqqit_date_2").val('<?php echo $db->convert_date_format($qitem_data["oqqit_date_2"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

        });
    </script>

    <div class="row">
        <div class="col-12 alert alert-success text-center">
            <b><?php show_quotation_text("Πίνακας Παροχών", "Schedule of Benefits"); ?></b>
        </div>
    </div>

    <div class="row main_text_smaller">
        <div class="col-6"></div>
        <div class="col-2 text-center">
            <?php show_quotation_text("Σχέδιο Α", "Plan A"); ?>
        </div>
        <div class="col-2 text-center">
            <?php show_quotation_text("Σχέδιο Β", "Plan B"); ?>
        </div>
        <div class="col-2 text-center">
            <?php show_quotation_text("Σχέδιο Γ", "Plan C"); ?>
        </div>
    </div>

    <div class="row main_text_smaller">
        <div class="col-9"><b>
            <?php show_quotation_text(
                    "Ανώτατο Ποσό Κατά Ασθένεια ή Ατύχημα Εντός Νοσοκομείου",
                    "Maximum Limit Per Accident Or Illness In Respect of In-Hospital Treatment"); ?>
            </b>
        </div>
        <div class="col-1 text-center">

        </div>
        <div class="col-1 text-center">

        </div>
        <div class="col-1 text-center">

        </div>
    </div>

    <?php
}

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

?>