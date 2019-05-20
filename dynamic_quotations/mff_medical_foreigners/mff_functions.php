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
                    'invalidText' => show_quotation_text("Συμπληρώστε το Όνομα Ασφαλιζόμενου.", "Must Enter Insured Name", 'Return')
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
                    'invalidText' => show_quotation_text("Συμπληρώστε το πεδίο Τόπος Συνήθους Εργασίας.", "Must Enter Place of Usual Business", 'Return')
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
                    'invalidText' => show_quotation_text("Συμπληρώστε το Επάγγελμα.", "Must Enter Occupation", 'Return')
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
                    'invalidText' => show_quotation_text("Συμπληρώστε τον Αριθμό Διαβατηρίου.", "Must Enter Passport Number", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_rate_5" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Χώρα", "Country"); ?>
        </label>
        <div class="col-sm-8">


            <select name="1_oqqit_rate_5" id="1_oqqit_rate_5"
                    class="form-control">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                $result = $db->query($sql);
                while ($country = $db->fetch_assoc($result)) {
                    $reffered = '';
                    if ($country['cde_option_value'] == 'Reject') {
                        $reffered = ' - <b>Country Not Allowed</b>';
                    }
                    ?>
                    <option value="<?php echo $country['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_5'] == $country['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $country['cde_value'] . $reffered; ?>
                    </option>
                <?php } ?>
            </select>


            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_rate_5',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε την Χώρα.", "Must Enter Country", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="1_oqqit_date_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Ημερομηνία Γέννησης", "Date of Birth"); ?>
        </label>
        <div class="col-sm-3">
            <input name="1_oqqit_date_1" type="text" id="1_oqqit_date_1"
                   class="form-control" onchange="showInsuredAge();"
                <?php $formValidator->echoDateFieldFormatTag(); ?>
                   value="<?php echo $qitem_data["oqqit_date_1"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '1_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($qitem_data["oqqit_date_1"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                    'invalidText' => show_quotation_text("Συμπληρώστε την Ημερομηνία Γέννησης.", "Must Enter Date of Birth", 'Return')
                ]);
            ?>
        </div>
        <div class="col-sm-1">
            Age:<span id="insured_age"></span>

        </div>
        <div class="col-4">
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
    global $db, $items_data, $q_data, $qitem_data, $formValidator, $allowEditAdvanced;
    ?>

    <div class="form-group row">
        <label for="starting_date" class="col-sm-1 col-form-label">
            <?php show_quotation_text("Από", "From"); ?>
        </label>
        <div class="col-sm-3">
            <input name="starting_date" type="text" id="starting_date"
                   class="form-control text-center" onchange="changeStartingDate()"
                <?php $formValidator->echoDateFieldFormatTag(); ?>
                   value="">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => 'starting_date',
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($q_data["oqq_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy',1,0),
                    'dateMinDate' => ($allowEditAdvanced == true) ? '01/01/2000' : date('d/m/Y'),
                    'dateMaxDate' => date('d/m/Y', mktime(0, 0, 0, date('m'), (date('d') + 45), date('Y'))),
                    'invalidText' => show_quotation_text("Λάθος Ημερομηνία", "Wrong Date", 'Return')
                ]);
            ?>
        </div>
        <label for="expiry_date" class="col-sm-1 col-form-label">
            <?php show_quotation_text("Μέχρι", "To"); ?>
        </label>

        <div class="col-3 custom-control-inline">
            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(3)">3M</button>&nbsp;
            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(6)">6M</button>&nbsp;
            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(9)">9M</button>&nbsp;
            <button type="button" class="btn" style="width: 55px;" onclick="setExpiryDate(12)">12M</button>
        </div>


        <div class="col-sm-3">
            <input name="expiry_date" type="text" id="expiry_date"
                   class="form-control text-center" readonly
                   value="<?php echo $db->convert_date_format($q_data["oqq_expiry_date"], 'yyyy-mm-dd', 'dd/mm/yyyy',1,0); ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => 'expiry_date',
                    'fieldDataType' => 'date',
                    'required' => true,
                    'dateMinDate' => "$('#starting_date').val()",
                    'invalidText' => show_quotation_text("Υποχρεωτικό", "Required", 'Return')
                ]);
            ?>
        </div>
        <script>
            function changeStartingDate() {
                //when the starting date is changed then reset the expiry.
                $('#expiry_date').val('');
            }

            function setExpiryDate(months) {
                let newMonth = 0;
                let newDay = 0;
                let newYear = 0;
                let curDay;
                let curMonth;
                let curYear;
                let curDate = $('#starting_date').val();
                if (curDate != '') {

                    //split the current date;
                    let split = curDate.split('/');
                    curDay = split[0];
                    curMonth = split[1];
                    curYear = split[2];

                    //first add the months
                    newMonth = (curMonth * 1) + months;
                    //update the rest of the fields
                    newDay = (curDay * 1) - 1;
                    newYear = curYear;

                    //check the month if need to change year
                    if (newMonth > 12) {
                        //first update the year
                        newYear++;
                        newMonth = newMonth - 12;
                    }

                    let isLeap = ((newYear % 4 == 0) && (newYear % 100 != 0)) || (newYear % 400 == 0);

                    //check the day. if 0 then need to go back one day and one month
                    if (newDay == 0) {
                        //first fix the month
                        newMonth--;
                        //check if the month now is 0
                        if (newMonth == 0) {
                            newMonth = 12;
                            newYear--;
                        }
                        //now set the day to 31
                        newDay = 31;


                    }

                    //validate days 31, 30, 29
                    if (newDay >= 28 && newDay <= 31) {

                        //now check the day compared to month
                        if (newMonth == 1 || newMonth == 3 || newMonth == 5 || newMonth == 7 || newMonth == 8 || newMonth == 10 || newMonth == 12) {
                            //do nothing is already 29 or 30 or 31;
                        }
                        else if (newMonth == 2) {
                            //find leap year
                            if (isLeap == true) {
                                if (newDay > 29) {
                                    newDay = 29;
                                }
                            }
                            else {
                                if (newDay > 28) {
                                    newDay = 28;
                                }
                            }
                        }
                        else {
                            if (newDay > 30) {
                                newDay = 30;
                            }
                        }
                    }

                    //update the field with the new date
                    $('#expiry_date').val(newDay + '/' + newMonth + '/' + newYear);
                }
            }
        </script>
    </div>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-10 text-danger" style="margin-bottom: 10px;">
            <?php show_quotation_text("
            Όχι προγενέστερη απο Σήμερα. Όχι μεταγενέστερη 45 μέρες απο σήμερα.
            ", "
            Not before today. Not after 45 days from today.
            "); ?>
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
                    <th scope="col" class="text-center"><?php show_quotation_text("Σχέδιο Β", "Plan B"); ?></th>
                    <th scope="col" class="text-center"><?php show_quotation_text("Σχέδιο Γ", "Plan C"); ?></th>
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
                    <th scope="row" colspan="2">
                        <div class="text-right"><b>
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
                            <?php if ($qitem_data['oqqit_insured_amount_1'] == '1') echo 'checked'; ?>>
                    </td>
                    <td class="text-center">
                        <input type="radio"
                               id="2_oqqit_rate_1" name="2_oqqit_insured_amount_1"
                               value="2"
                               class="form-control"
                            <?php if ($qitem_data['oqqit_insured_amount_1'] == '2') echo 'checked'; ?>>
                    </td>
                    <td class="text-center">
                        <input type="radio"
                               id="2_oqqit_rate_1" name="2_oqqit_insured_amount_1"
                               value="3"
                               class="form-control"
                            <?php if ($qitem_data['oqqit_insured_amount_1'] == '3') echo 'checked'; ?>>

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
                                'invalidText' => show_quotation_text("Επιλέξτε Σχέδιο.", "Select Plan", 'Return')
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
                <option value="0" <?php if ($qitem_data['oqqit_insured_amount_2'] == '0') echo 'selected'; ?>>
                    <?php show_quotation_text("Όχι", "No"); ?>
                </option>
                <option value="1" <?php if ($qitem_data['oqqit_insured_amount_2'] == '1') echo 'selected'; ?>>
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
                    'invalidText' => show_quotation_text("Συμπληρώστε Αριθμό Μητρώου Εργοδότη.", "Must Enter Social Security Insurance Number", 'Return')
                ]);
            ?>
        </div>
    </div>

    <script>
        function hideShowSocialSecurityNumDiv() {
            if ($('#2_oqqit_insured_amount_2').val() == '1') {
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

function activate_custom_validation($quotationData)
{

    global $db;
    $result['error'] = false;
    $result['errorDescription'] = '';

    //get item data
    $sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationData['oqq_quotations_ID'] . " AND oqqit_items_ID = 2");

    $startDate = $sect2['oqqit_date_1'];
    $expirydate = $sect2['oqqit_date_2'];
    $startDateSplit = explode('-', $startDate);
    $expirydateSplit = explode('-', $expirydate);
    //convert to number for easier manipulation
    $startDate = ($startDateSplit[0] * 10000) + ($startDateSplit[1] * 100) + $startDateSplit[2];
    $expirydate = ($expirydateSplit[0] * 10000) + ($expirydateSplit[1] * 100) + $expirydateSplit[2];
    $today = (date('Y') * 10000) + (date('m') * 100) + date('d');
    $days45 = date('Y-m-d', mktime(0, 0, 0, date('m'), (date('d') + 45), date('Y')));
    $days45Split = explode('/', $days45);
    $days45 = ($days45[0] * 10000) + ($days45[1] * 100) + $days45[2];
    //1. if startdate is before today
    if ($startDate < $today) {
        $result['error'] = true;
        $result['errorDescription'] = "Starting Date cannot be before today.";
    }
    //2. Expiry cannot be before starting
    if ($expirydate < $startDate) {
        $result['error'] = true;
        $result['errorDescription'] = "Expiry date cannot be before starting date.";
    }
    //3. Starting date not more than 45 days from today
    if ($startDate > $days45) {
        $result['error'] = true;
        $result['errorDescription'] = "Starting Date cannot be more than 45 days from today.";
    }

    return $result;
}

?>