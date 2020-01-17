<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/12/2019
 * Time: 10:52 π.μ.
 */

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

function hc_household_item1_adresses()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter, $formB;
    $formB->setLabelClasses('col-sm-4');

    ?>
    <div class="row">
        <div class="col-12 alert alert-secondary text-center font-weight-bold">
            <?php echo show_quotation_text('Ταχυδρομική Διεύθυνση', 'Correspondence Address') ?>
        </div>
    </div>
    <?php
    $allFieldsNames = [
        'Οδός και Αριθμός/Ταχ. Θυρίδα' => 'Street Name and Num./P.O. Box',
        'Όνομα Υποστατικού' => 'Building Name',
        'Αριθμός Διαμερίσματος' => 'Apartment Number',
        'Ταχυδρομικός Κώδικας' => 'Postal Code',
        'Πόλη ή Κοινότητα' => 'City or Community',
        'Τηλέφωνα Επικοινωνίας' => 'Contact Telephone Numbers'
    ];
    $i = 0;
    foreach ($allFieldsNames as $gr => $en) {
        $i++;
        ?>
        <div class="form-group row">
            <?php
            $formB->setFieldName('9_oqqit_rate_' . $i)
                ->setFieldDescription(show_quotation_text($gr, $en, 'return'))
                ->setFieldType('input')
                ->setInputValue($qitem_data['oqqit_rate_' . $i])
                ->buildLabel();
            ?>
            <div class="col-sm-8">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>
        <?php
    }//foreach
    ?>
    <div class="form-group row">
        <?php
        $formB->setFieldName('9_oqqit_rate_7')
            ->setFieldDescription(show_quotation_text('Ηλεκτρονική Διεύθυνση', 'E-mail Address', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_7'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'email',
                    'required' => true,
                    'validateEmail' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 alert alert-secondary text-center font-weight-bold">
            <?php echo show_quotation_text('Διεύθυνση Υποστατικού (αν διαφέρει)', 'Premises Address (if different)') ?>
        </div>
    </div>

    <div class="row form-group">
        <?php
        $formB->setFieldName('sameAddress')
            ->setFieldDescription(show_quotation_text('Χρησιμοποίησε την ίδια διεύθυνση', 'Use Same Address', 'return'))
            ->setFieldType('checkbox')
            ->setInputValue('0')
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <button class="btn btn-secondary" onclick="copyAddress();" type="button">
                <?php echo show_quotation_text('Αντιγραφή Διεύθυνσης', 'Copy Address') ?>
            </button>
        </div>
    </div>
    <?php

    $i = 7;
    foreach ($allFieldsNames as $gr => $en) {
        $i++;
        ?>
        <div class="form-group row">
            <?php
            $formB->setFieldName('9_oqqit_rate_' . $i)
                ->setFieldDescription(show_quotation_text($gr, $en, 'return'))
                ->setFieldType('input')
                ->setInputValue($qitem_data['oqqit_rate_' . $i])
                ->buildLabel();
            ?>
            <div class="col-sm-8">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>
        <?php
    }//foreach

    ?>
    <div class="form-group row">
        <?php
        $formB->setFieldName('9_oqqit_rate_14')
            ->setFieldDescription(show_quotation_text('Ηλεκτρονική Διεύθυνση', 'E-mail Address', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_14'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'email',
                    'required' => true,
                    'validateEmail' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>
    <script>
        function copyAddress() {
            $('#9_oqqit_rate_8').val($('#9_oqqit_rate_1').val());
            $('#9_oqqit_rate_9').val($('#9_oqqit_rate_2').val());
            $('#9_oqqit_rate_10').val($('#9_oqqit_rate_3').val());
            $('#9_oqqit_rate_11').val($('#9_oqqit_rate_4').val());
            $('#9_oqqit_rate_12').val($('#9_oqqit_rate_5').val());
            $('#9_oqqit_rate_13').val($('#9_oqqit_rate_6').val());
            $('#9_oqqit_rate_14').val($('#9_oqqit_rate_7').val());
        }
    </script>
    <?php


}

function hc_household_item2_other()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter, $formB, $quote;
    $formB->setLabelClasses('col-sm-4');

    ?>
    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_1')
            ->setFieldDescription(show_quotation_text('Συμφέρον Προτείνοντα', 'Proposer\'s Interest', 'return'))
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_1'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <?php
            $formB->setRadioLabelDescription(show_quotation_text('Ιδιοκτήτης', 'Owner', 'return'))
                ->setRadioValue('Owner')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Ενοικιαστής', 'Tenant', 'return'))
                ->setRadioValue('Tenant')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Άλλο', 'Other', 'return'))
                ->setRadioValue('Other')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_2')
            ->setFieldDescription(show_quotation_text('Ενυπόθηκος Δανειστής (εάν υπάρχει)', 'Mortgagee (if any)', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_2'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
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
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('starting_date')
            ->setFieldDescription(show_quotation_text('Περίοδος Ασφάλισης', 'Period of Insurance', 'return'))
            ->setFieldType('input')
            ->setInputValue($quote->quotationData()['oqq_starting_date'])
            ->buildLabel();
        ?>
        <div class="col-sm-1 col-form-label">
            <?php show_quotation_text('Από:', 'From:'); ?>
        </div>
        <div class="col-sm-3">
            <?php

            //admins can go backdated
            $minDate = '';
            if ($db->user_data['usr_user_rights'] <= 2) {
                $minDate = '01/01/1900';
            } else {
                $minDate = date('d/m/Y');
            }
            //admins can go further future dates
            $maxDate = '';
            if ($db->user_data['usr_user_rights'] <= 2) {
                $maxDate = '01/01/2100';
            } else {
                $maxDate = date('d/m/Y', mktime(0, 0, 0, date('m'), (date('d') + 60), date('Y')));
            }

            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convertDateToEU($quote->quotationData()['oqq_starting_date'], 1, 0),
                    'invalidTextAutoGenerate' => true,
                    'dateMinDate' => $minDate,
                    'dateMaxDate' => $maxDate
                ]);
            ?>
        </div>

        <div class="col-sm-1 col-form-label">
            <?php show_quotation_text('Μέχρι:', 'To:'); ?>
        </div>
        <div class="col-sm-3">
            <?php

            $formB->initSettings()
                ->setFieldName('expiry_date')
                ->setFieldType('input')
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convertDateToEU($quote->quotationData()['oqq_expiry_date'], 1, 0),
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_3')
            ->setFieldDescription(show_quotation_text('Ασφαλιστικό Σχέδιο', 'Insurance Plan', 'return'))
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_3'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <?php
            $formB->setRadioLabelDescription(show_quotation_text('Βασικό', 'Basic', 'return'))
                ->setRadioValue('Basic')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Κλασσικό', 'Classic', 'return'))
                ->setRadioValue('Classic')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Πολυτελείας', 'Luxury', 'return'))
                ->setRadioValue('Luxury')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_4')
            ->setFieldDescription(show_quotation_text('Τα Υποστατικά είναι', 'Your premises are', 'return'))
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_4'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <?php
            $formB->setRadioLabelDescription(show_quotation_text('Ανεξάρτητα', 'Detached', 'return'))
                ->setRadioValue('Detached')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Ημιανεξάρτητα', 'Semi-detached', 'return'))
                ->setRadioValue('Semi-detached')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Διαμέρισμα', 'Apartment', 'return'))
                ->setRadioValue('Apartment')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_5')
            ->setFieldDescription(show_quotation_text('Χρήση', 'Use', 'return'))
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_5'])
            ->buildLabel();
        ?>
        <div class="col-sm-8">
            <?php
            $formB->setRadioLabelDescription(show_quotation_text('Ιδιωτική Κατοικία', 'Private Home', 'return'))
                ->setRadioValue('Private')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Εξοχικό', 'Holiday House', 'return'))
                ->setRadioValue('Holiday')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Σκοπούς Εκμετάλλευσης', 'Commercial Use', 'return'))
                ->setRadioValue('Commercial')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_6')
            ->setFieldDescription(show_quotation_text('Έτος κατασκευής', 'Year Build', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_6'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'number',
                    'required' => true,
                    'minNumber' => 1900,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        if ($qitem_data['oqqit_rate_7'] == '') {
            $qitem_data['oqqit_rate_7'] = 0;
        }
        $formB->setFieldName('10_oqqit_rate_7')
            ->setFieldDescription(show_quotation_text('Αριθμός Υπογείων', 'Number of Basements', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_7'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setFieldName('10_oqqit_rate_8')
            ->setFieldDescription(show_quotation_text('Συνολικό Εμβαδόν (τ.μ.)', 'Total Area (&#13217;)', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_8'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 alert alert-secondary text-center font-weight-bold">
            Questionnaire
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7"></div>
        <div class="col-sm-5 text-center font-weight-bold" style="height: 30px;">
            <?php
            show_quotation_text('Στοιχεία', 'Details')
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Τα κτήρια είναι κατασκευασμένα από τούβλο ή/και σκυρόδεμα, η δε οροφή από κεραμίδι ή/και σκυρόδεμα; Σε αντίθετη περίπτωση δώστε σχετικά στοιχεία:',
                'The Buildings are constructed of brick and/or concrete and roofed with tiles and/or concrete? If NOT, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('10_oqqit_rate_9')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('10_oqqit_rate_9','10_oqqit_rate_10');")
                ->setInputValue($qitem_data['oqqit_rate_9']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('10_oqqit_rate_10')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_10'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-12" style="height: 5px;"></div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Μήπως το Κτήριο παραμένει ακατοίκητα για περισσότερες από 30 συνεχόμενες ημέρες; Εάν ΝΑΙ, ενημερώστε μας σχετικά:',
                'Do the Building remain unoccupied for more than 30 consecutive days? If YES, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('10_oqqit_rate_11')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('10_oqqit_rate_11','10_oqqit_rate_12');")
                ->setInputValue($qitem_data['oqqit_rate_11']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('10_oqqit_rate_12')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_12'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-12" style="height: 5px;"></div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Μήπως το/τα υπό ασφάλιση υποστατικό/ά  ή οποιαδήποτε άλλα γειτονικά κτήρια έχουν επηρεαστεί από καθίζηση, εξόγκωση του εδάφους ή κατολίσθηση; Εάν ΝΑΙ, ενημερώστε μας σχετικά:',
                'Have the Premises or any other property in the vicinity been affected by subsidence, heave or landslip? If YES, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('10_oqqit_rate_13')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('10_oqqit_rate_13','10_oqqit_rate_14');")
                ->setInputValue($qitem_data['oqqit_rate_13']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('10_oqqit_rate_14')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_14'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>



    <script>
        function showDetails(yesNoField, detailsField) {
            let yesNo = $("input[name='" + yesNoField + "']:checked").val();

            if (yesNo == 'Yes') {
                $("#" + detailsField).prop('disabled', false);
            } else {
                $("#" + detailsField).prop('disabled', true);
            }
        }
    </script>
    <?php
}

function hc_household_item3_questions()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter, $formB, $quote;
    $formB->setLabelClasses('col-sm-4');

    ?>


    <div class="row">
        <div class="col-12" style="height: 5px;"></div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Τα Υποστατικά είναι απαλλαγμένα από εσωτερικά ή εξωτερικά σημάδια σκαλωτών ή διαγώνιων ρωγμών; Ενημερώστε μας σχετικά εάν ΟΧΙ:',
                'Are the Premises free from signs of internal or external stepping or diagonal cracking? If NOT, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('11_oqqit_rate_1')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('11_oqqit_rate_1','11_oqqit_rate_2');")
                ->setInputValue($qitem_data['oqqit_rate_1']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('11_oqqit_rate_2')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_2'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-12" style="height: 5px;"></div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Τα Υποστατικά χρησιμοποιούνται για κάποια επαγγελματική ή βιοτεχνική δραστηριότητα; Εάν ΝΑΙ, ενημερώστε μας σχετικά:',
                'Are the Premises used in connection with any trade or professional activity? If YES, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('11_oqqit_rate_3')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('11_oqqit_rate_3','11_oqqit_rate_4');")
                ->setInputValue($qitem_data['oqqit_rate_3']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('11_oqqit_rate_4')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_4'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-12" style="height: 5px;"></div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Βρίσκονται τα Υποστατικά σε απόσταση 200 μέτρων από λίμνη ή θάλασσα; Εάν ΝΑΙ, ενημερώστε μας σχετικά:',
                'Are the Premises located within 200 meters of any lake or seafront? If YES, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('11_oqqit_rate_5')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('11_oqqit_rate_5','11_oqqit_rate_6');")
                ->setInputValue($qitem_data['oqqit_rate_5']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('11_oqqit_rate_6')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_6'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-12" style="height: 5px;"></div>
    </div>

    <div class="row form-group">
        <div class="col-sm-6">
            <?php
            show_quotation_text('Βρίσκονται τα Υποστατικά σε απομακρυσμένη περιοχή που να απέχει περισσότερο από 100 μέτρα από άλλες κατοικίες ή σε δασώδη περιοχή; Εάν ΝΑΙ, ενημερώστε μας σχετικά:',
                'Are the Premises located in a remote area more than 100 meters from other houses or in a wooded area? If YES, provide details:');
            ?>
        </div>
        <div class="col-sm-1">
            <?php
            $formB->setFieldName('11_oqqit_rate_7')
                ->setFieldType('radio')
                ->setFieldOnChange("showDetails('11_oqqit_rate_7','11_oqqit_rate_8');")
                ->setInputValue($qitem_data['oqqit_rate_7']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
        <div class="col-sm-5">
            <?php
            $formB->initSettings()
                ->setFieldName('11_oqqit_rate_8')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($qitem_data['oqqit_rate_8'])
                ->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'text',
                    'required' => false,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>
    
    <div class="row">
        <div class="col-12 font-weight-bold">
            <?php
            show_quotation_text('Έχετε θεσπίσει και εφαρμόζετε οποιαδήποτε από τα παρακάτω μέτρα ασφάλειας στο/στα Υποστατικό/ά σας;',
            'Are any of the following security measures installed and in use at your Premises?');
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-9">
            <?php
            show_quotation_text('Σύστημα συναγερμού διάρρηξης που να είναι συνδεδεμένο με Εταιρεία Ασφαλείας ή με το κινητό σας τηλέφωνο;',
                'Intruder alarm system which is connected to a Security Company or your mobile phone?');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $formB->setFieldName('11_oqqit_rate_9')
                ->setFieldType('radio')
                ->setRadioInline()
                ->setInputValue($qitem_data['oqqit_rate_9']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-9">
            <?php
            show_quotation_text('Σύστημα πυρανίχνευσης συνδεδεμένο με Εταιρεία Ασφαλείας ή με το κινητό σας τηλέφωνο;',
                'Fire alarm system which is connected to a Security Company or your mobile phone?');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $formB->setFieldName('11_oqqit_rate_10')
                ->setFieldType('radio')
                ->setRadioInline()
                ->setInputValue($qitem_data['oqqit_rate_10']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-9">
            <?php
            show_quotation_text('Εντοιχισμένο ή στερεωμένο με μπουλόνια στο δάπεδο χρηματοκιβώτιο για τη φύλαξη των τιμαλφών σας;',
                'Built-in or bolted safe for keeping your valuables');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $formB->setFieldName('11_oqqit_rate_11')
                ->setFieldType('radio')
                ->setRadioInline()
                ->setInputValue($qitem_data['oqqit_rate_11']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-9">
            <?php
            show_quotation_text('Κλειστό κύκλωμα παρακολούθησης με κάμερες περιμετρικά του Υποστατικού σας;',
                'CCTV system with cameras installed around the perimeter of the premises');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $formB->setFieldName('11_oqqit_rate_12')
                ->setFieldType('radio')
                ->setRadioInline()
                ->setInputValue($qitem_data['oqqit_rate_12']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-9">
            <?php
            show_quotation_text('Εξωτερικές πόρτες με κλειδαριές ασφαλείας 5 μοχλών και σύρτες στις πόρτες αυλής και στα παράθυρα ισογείου;',
                'Exterior doors fitted with security lock 5 levers and latches on the courtyard doors and ground floor windows?');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $formB->setFieldName('11_oqqit_rate_13')
                ->setFieldType('radio')
                ->setRadioInline()
                ->setInputValue($qitem_data['oqqit_rate_13']);

            $formB->setRadioLabelDescription(show_quotation_text('Ναι', 'Yes', 'return'))
                ->setRadioValue('Yes')
                ->buildInput();

            $formB->setRadioLabelDescription(show_quotation_text('Όχι', 'No', 'return'))
                ->setRadioValue('No')
                ->buildInput();

            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'radio',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php

        $formB->setFieldName('11_oqqit_rate_14')
            ->setFieldDescription(show_quotation_text('<b>Ασφαλιζόμενο Ποσό για το Κτήριο</b>', '<b>Building Sum Insured</b>', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_14'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>





    <script>
        $('document').ready(function(){
            //console.log('Document ready');
            showDetails('10_oqqit_rate_9','10_oqqit_rate_10');
            showDetails('10_oqqit_rate_11','10_oqqit_rate_12');
            showDetails('10_oqqit_rate_13','10_oqqit_rate_14');
            showDetails('11_oqqit_rate_1','11_oqqit_rate_2');
            showDetails('11_oqqit_rate_3','11_oqqit_rate_4');
            showDetails('11_oqqit_rate_5','11_oqqit_rate_6');
            showDetails('11_oqqit_rate_7','11_oqqit_rate_8');
        });
    </script>

    <?php

    function hc_household_item4_contents()
    {
        global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter, $formB, $quote;
        $formB->setLabelClasses('col-sm-4');

        ?>

        <div class="row">
            <div class="col-12">
                <i class="fas fa-info-circle" style="cursor: pointer" onclick="showHideContentsInfo();"></i>
            </div>
        </div>
        <script>
            function showHideContentsInfo(){

            }
        </script>

        <div class="row" id="contentsInfoDiv">
            <div class="col-12">
                Το ποσό ασφάλισης υπολογίζεται βάσει του κόστους αντικατάστασης του περιεχομένου (εξαιρουμένων των λευκών ειδών οικιακής χρήσης και του ρουχισμού) σαν να ήταν όλα καινούργια.
                / The amount insured is calculated on a replacement cost of the contents (excluding the household linen and clothing) as if it were new.
                	Περιεχόμενο σημαίνει είδη οικιακής χρήσης και άλλα αντικείμενα, εντός της Κατοικίας / Contents means household goods and other items, within the Home

                	Προσωπικά Αντικείμενα σημαίνει ρουχισμό, αποσκευές, αθλητικό εξοπλισμό και άλλα αντικείμενα. 	Σε αυτά δεν περιλαμβάνονται:
                (ι)	Χρήματα για προσωπικά έξοδα ή Ποδήλατα
                (ιι)	Περιουσία ιδιόκτητη ή για επιχειρηματική ή επαγγελματική χρήση
                Personal Possessions means clothing, baggage, sports equipment and other items. Does not include:
                (i)	Personal money or pedal Cycles
                (ii)	Property owned or used for business or professional purposes
                	Τιμαλφή σημαίνει κοσμήματα, γούνες, 	χρυσά, ασημένια, επίχρυσα και επάργυρα αντικείμενα, φωτογραφίες και πίνακες ζωγραφικής  Valuables means jewellery, furs, gold, silver, gold and silver plated articles, pictures and paintings

            </div>
        </div>

        <div class="form-group row">
            <?php

            $formB->setFieldName('12_oqqit_rate_1')
                ->setFieldDescription(show_quotation_text('Περιεχόμενο εντός της Κατοικίας ', 'Contents within the Home', 'return'))
                ->setFieldType('input')
                ->setInputValue($qitem_data['oqqit_rate_1'])
                ->buildLabel();
            ?>
            <div class="col-sm-3">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'number',
                        'required' => false,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>

        <div class="form-group row">
            <?php

            $formB->setFieldName('12_oqqit_rate_2')
                ->setFieldDescription(show_quotation_text('Προσωπικά Αντικείμενα', 'Personal Possessions', 'return'))
                ->setFieldType('input')
                ->setInputValue($qitem_data['oqqit_rate_2'])
                ->buildLabel();
            ?>
            <div class="col-sm-3">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'number',
                        'required' => false,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>

        <div class="form-group row">
            <?php

            $formB->setFieldName('12_oqqit_rate_3')
                ->setFieldDescription(show_quotation_text('Τιμαλφή', 'Valuables', 'return'))
                ->setFieldType('input')
                ->setInputValue($qitem_data['oqqit_rate_3'])
                ->buildLabel();
            ?>
            <div class="col-sm-3">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'number',
                        'required' => false,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>



        <?php
    }
}
