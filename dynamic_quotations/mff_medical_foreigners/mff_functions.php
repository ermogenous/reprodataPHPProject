<?php
//shows the tables for each section (item)
//the name of the field is OQIT_ITEMS_ID"_"FIELD_NAME
function mff_insured_details_1()
{
    global $db, $items_data, $qitem_data, $formValidator;
    ?>

    <div class="form-group row">
        <label for="1_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Όνομα Ασφαλιζόμενου", "Insured Name"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_1" type="text" id="1_oqqit_rate_1"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_1"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_rate_1',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε το Όνομα Ασφαλιζόμενου.", "Must Enter Insured Name",'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Τόπος Συνήθους Εργασίας", "Place of Usual Business"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_2" type="text" id="1_oqqit_rate_2"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_2"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_rate_2',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε το πεδίο Τόπος Συνήθους Εργασίας.", "Must Enter Place of Usual Business",'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_3" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Επάγγελμα", "Occupation"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_3" type="text" id="1_oqqit_rate_3"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_3"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_rate_3',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε το Επάγγελμα.", "Must Enter Occupation",'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_4" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Αριθμός Διαβατηρίου", "Passport Number"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_4" type="text" id="1_oqqit_rate_4"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_4"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_rate_4',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε τον Αριθμό Διαβατηρίου.", "Must Enter Passport Number",'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_5" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Χώρα", "Country"); ?>
        </label>
        <div class="col-sm-8">
            <input name="1_oqqit_rate_5" type="text" id="1_oqqit_rate_5"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_5"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_rate_5',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε την Χώρα.", "Must Enter Country",'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_date_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Ημερομηνία Γέννησης", "Date of Birth"); ?>
        </label>
        <div class="col-sm-2">
            <input name="1_oqqit_date_1" type="text" id="1_oqqit_date_1"
                   class="form-control" onchange="showInsuredAge();"
                   <?php $formValidator->echoDateFieldFormatTag();?>
                   value="<?php echo $qitem_data["oqqit_date_1"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($qitem_data["oqqit_date_1"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                    'invalidText' => show_quotation_text("Συμπληρώστε την Ημερομηνία Γέννησης.", "Must Enter Date of Birth",'Return')
                ]);
            ?>
        </div>
        <div class="col-sm-1">
            Age:<span id="insured_age"></span>

        </div>
        <div class="col-5">
            <span id="insuredAgeError" class="alert-danger"></span>
        </div>
        <?php
        //add the custom code for checking age based on the underwriters
        $formValidator->addCustomCode('checkInsuredAge();');
        ?>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_6" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Γένος", "Gender"); ?>
        </label>
        <div class="col-sm-8">
            <select name="1_oqqit_rate_6" id="1_oqqit_rate_6"
                    class="form-control">
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
    global $db, $items_data, $qitem_data, $formValidator;
    ?>
    <div class="form-group row">
        <label for="2_oqqit_date_1" class="col-sm-2 col-form-label">
            <?php show_quotation_text("Από", "From"); ?>
        </label>
        <div class="col-sm-4">
            <input name="2_oqqit_date_1" type="text" id="2_oqqit_date_1"
                   onchange="showInsuredAge();"
                   class="form-control">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '2_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($qitem_data["oqqit_date_1"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                    'invalidText' => show_quotation_text("Συμπληρώστε την Ημερομηνία Από.", "Must Enter Date From",'Return')
                ]);
            ?>
        </div>
        <label for="2_oqqit_date_2" class="col-sm-2 col-form-label">
            <?php show_quotation_text("Μέχρι", "To"); ?>
        </label>
        <div class="col-sm-4">
            <input name="2_oqqit_date_2" type="text" id="2_oqqit_date_2"
                   class="form-control">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '2_oqqit_date_2',
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($qitem_data["oqqit_date_2"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                    'invalidText' => show_quotation_text("Συμπληρώστε την Ημερομηνία Μέχρι.", "Must Enter Date To",'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 alert alert-success text-center">
            <b><?php show_quotation_text("Επιλογή Σχεδίου", "Plan Selection"); ?></b>
        </div>
    </div>

    <div class="row main_text_smaller">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col" class="text-center"><?php show_quotation_text("Σχέδιο Α", "Plan A"); ?></th>
                    <th scope="col"  class="text-center"><?php show_quotation_text("Σχέδιο Β", "Plan B"); ?></th>
                    <th scope="col"  class="text-center"><?php show_quotation_text("Σχέδιο Γ", "Plan C"); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" colspan="2"><?php show_quotation_text(
                            "<b>1. Ανώτατο Ποσό Κατά Ασθένεια ή Ατύχημα Εντός Νοσοκομείου</b>",
                            "<b>1. Maximum Limit Per Accident Or Illness In Respect of In-Hospital Treatment</b>"); ?></th>
                    <td class="text-center">Euro/€</td>
                    <td class="text-center">Euro/€</td>
                    <td class="text-center">Euro/€</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th><?php show_quotation_text(
                            "&bull; &nbsp;&nbsp; Για Ενδονοσοκομειακή Περίθαλψη",
                            "&bull; &nbsp;&nbsp; Per in-hospital treatment"); ?>
                    </th>
                    <td class="text-center">8.600</td>
                    <td class="text-center">8.600</td>
                    <td class="text-center">12.000</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                        <?php show_quotation_text(
                            "&bull; &nbsp;&nbsp; Κατά περίοδο ασφάλισης και κατά άτομο",
                            "&bull; &nbsp;&nbsp; Per period of insurance and per person"); ?>
                    </th>
                    <td class="text-center">13.700</td>
                    <td class="text-center">13.700</td>
                    <td class="text-center">18.000</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                        <?php show_quotation_text(
                            "1α. Ημερησία Νοσηλεία (Δωμάτιο &amp; Τροφή) για κάθε μέρα",
                            "1a. Hospitalization (Room &amp; Board) per day"); ?>
                    </th>
                    <td class="text-center">70</td>
                    <td class="text-center">70</td>
                    <td class="text-center">100</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                        <?php show_quotation_text(
                            "1β. Ημερησία Νοσηλεία (Δωμάτιο &amp; Τροφή) για κάθε μέρα σε μονάδα Εντατικής Παρακολούθησης",
                            "1b. Hospitalization (Room &amp; Board) per day Intensive Care"); ?>
                    </th>
                    <td class="text-center">175</td>
                    <td class="text-center">175</td>
                    <td class="text-center">300</td>
                </tr>
                <tr>
                    <th scope="row" colspan="2"><b>
                        <?php show_quotation_text(
                            "2. Ανώτατο Ποσό Κατά Ασθένεια ή Ατύχημα Εκτός Νοσοκομείου",
                            "2. Maximum Limit Per Accident or Illness Per Out-Hospital Treatment"); ?>
                        </b>
                    </th>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                            <?php show_quotation_text(
                                "Για Εξωνοσοκομειακή Περίθαλψη",
                                "Per Out-hospital treatment"); ?>
                    </th>
                    <td class="text-center">685</td>
                    <td class="text-center">---</td>
                    <td class="text-center">1.000</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                            <?php show_quotation_text(
                                "Κατά περίοδο ασφάλισης και κατά άτομο",
                                "Per period of insurance and per person"); ?>
                    </th>
                    <td class="text-center">1.750</td>
                    <td class="text-center">---</td>
                    <td class="text-center">2.500</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                            <?php show_quotation_text(
                                "2α. Ανώτατο Ποσό Κατά Ιατρική Επίσκεψη",
                                "2a. Maximum Amount Per Doctor`s Visit"); ?>
                    </th>
                    <td class="text-center">20</td>
                    <td class="text-center">---</td>
                    <td class="text-center">50</td>
                </tr>
                <tr>
                    <th scope="row" colspan="2"><b>
                        <?php show_quotation_text(
                            "3. Ωφέλημα Τοκετού (Φυσιολογικός ή με καισαρική τομή)",
                            "3. Maternity Cover (Normal or Caesarean Section)"); ?>
                        </b>
                    </th>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row">&nbsp;&nbsp;&nbsp;
                        <?php show_quotation_text(
                            "Ανώτατο όριο μέχρι:",
                            "Maximum limit up to:"); ?>
                    </th>
                    <td class="text-center">515</td>
                    <td class="text-center">515</td>
                    <td class="text-center">800</td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;&nbsp;&nbsp;</th>
                    <th scope="row" colspan="4">&nbsp;&nbsp;&nbsp;
                        <?php show_quotation_text(
                            "Το ωφέλημα είναι πληρωτέο νοουμένου ότι ο τοκετός γίνεται τουλάχιστον 10 μήνες 
                            μετά την έναρξη του Ασφαλιστηρίου ή την ένταξη του Ασφαλισμένου Προσώπου στο Ασφαλιστήριο",
                            "The benefit is payable only if delivery takes place at least 10 months from 
                            the commencement of cover or inclusion of the Insured Person in the Policy."); ?>
                    </th>
                </tr>
                <tr>
                    <th scope="row" colspan="2"><b>
                            <?php show_quotation_text(
                                "4. Μεταφοράς Σωρού",
                                "4. Transportation of Corpse"); ?>
                        </b>
                    </th>
                    <td class="text-center">3.450</td>
                    <td class="text-center">3.450</td>
                    <td class="text-center">5.000</td>
                </tr>
                <tr>
                    <th scope="row" colspan="2"><div class="text-right"><b>
                            <?php show_quotation_text(
                                "Επιλογή Σχεδίου",
                                "Plan Selection"); ?>
                        </b></div>
                    </th>
                    <td class="text-center">
                        <input type="radio"
                               id="2_oqqit_rate_1" name="2_oqqit_insured_amount_1"
                               value="1"
                               class="form-control"
                        <?php if ($qitem_data['oqqit_insured_amount_1'] == '1') echo 'checked';?>>
                    </td>
                    <td class="text-center">
                        <input type="radio"
                               id="2_oqqit_rate_1" name="2_oqqit_insured_amount_1"
                               value="2"
                               class="form-control"
                            <?php if ($qitem_data['oqqit_insured_amount_1'] == '2') echo 'checked';?>>
                    </td>
                    <td class="text-center">
                        <input type="radio"
                               id="2_oqqit_rate_1" name="2_oqqit_insured_amount_1"
                               value="3"
                               class="form-control"
                            <?php if ($qitem_data['oqqit_insured_amount_1'] == '3') echo 'checked';?>>

                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3" align="center">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => '2_oqqit_insured_amount_1',
                                'fieldDataType' => 'radio',
                                'required' => true,
                                'invalidText' => show_quotation_text("Επιλέξτε Σχέδιο.", "Select Plan",'Return')
                            ]);
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="form-group row">
        <div class="col-10">
            <b><?php show_quotation_text("Κάλυψη Ευθύνης Εργοδότη", "Employer Liability Coverage"); ?></b>
        </div>
        <div class="col-2">
            <select id="2_oqqit_insured_amount_2" name="2_oqqit_insured_amount_2" class="form-control"
                    onchange="hideShowSocialSecurityNumDiv()">
                <option value="0" <?php if ($qitem_data['oqqit_insured_amount_2'] == '0') echo 'selected';?>>
                    <?php show_quotation_text("Όχι", "No"); ?>
                </option>
                <option value="1" <?php if ($qitem_data['oqqit_insured_amount_2'] == '1') echo 'selected';?>>
                    <?php show_quotation_text("Ναι", "Yes"); ?>
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row" id="socialSecurityNumberDiv">
        <label for="2_oqqit_insured_amount_3" class="col-5">
            <?php show_quotation_text("Αριθμό Μητρώου Εργοδότη", "Social Security Insurance Number"); ?>
        </label>
        <div class="col-7">
            <input name="2_oqqit_rate_3" type="text" id="2_oqqit_rate_3"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_3"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '2_oqqit_rate_3',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'requiredAddedCustomCode' => "&& $('#2_oqqit_insured_amount_2').val() == '1'",
                    'invalidText' => show_quotation_text("Συμπληρώστε Αριθμό Μητρώου Εργοδότη.", "Must Enter Social Security Insurance Number",'Return')
                ]);
            ?>
        </div>
    </div>

    <script>
        function hideShowSocialSecurityNumDiv(){
            if ($('#2_oqqit_insured_amount_2').val() == '1'){
                $('#socialSecurityNumberDiv').show();
            }
            else {
                $('#socialSecurityNumberDiv').hide();
            }
        }
        hideShowSocialSecurityNumDiv();
    </script>



    <div class="row">
        <div class="col-12" style="height: 30px;"></div>
    </div>
    <?php
}

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

?>