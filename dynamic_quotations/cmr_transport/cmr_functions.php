<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/2/2020
 * Time: 2:37 μ.μ.
 */


function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

function modify_post_values($post)
{
    global $db;

    $post['14_oqqit_rate_13'] = $post['vehicle_1_1'] . "##" . $post['vehicle_1_2'] . "##" . $post['vehicle_1_3'] . "##" . $post['vehicle_1_4'] . "##" . $post['vehicle_1_5'] . "@@";
    $post['14_oqqit_rate_13'] .= $post['vehicle_2_1'] . "##" . $post['vehicle_2_2'] . "##" . $post['vehicle_2_3'] . "##" . $post['vehicle_2_4'] . "##" . $post['vehicle_2_5'];

    $post['14_oqqit_rate_14'] = $post['vehicle_3_1'] . "##" . $post['vehicle_3_2'] . "##" . $post['vehicle_3_3'] . "##" . $post['vehicle_3_4'] . "##" . $post['vehicle_3_5'] . "@@";
    $post['14_oqqit_rate_14'] .= $post['vehicle_4_1'] . "##" . $post['vehicle_4_2'] . "##" . $post['vehicle_4_3'] . "##" . $post['vehicle_4_4'] . "##" . $post['vehicle_4_5'];

    $post['14_oqqit_rate_15'] = $post['geographical_1'] . "##" . $post['geographical_2'] . "##" . $post['geographical_3'] . "##" . $post['geographical_4'] . "@@";
    $post['14_oqqit_rate_15'] .= $db->get_check_value($post['operations_1']) . "##" . $db->get_check_value($post['operations_2']) . "##" . $db->get_check_value($post['operations_3']) . "##" . $db->get_check_value($post['operations_4']) . "@@";
    $post['14_oqqit_rate_15'] .= $post['goods_1'] . "##" . $post['goods_2'] . "##" . $post['goods_3'] . "##" . $post['goods_4'] . "##" . $post['goods_4'] . "##";
    $post['14_oqqit_rate_15'] .= $post['goods_5'] . "##" . $post['goods_6'] . "##" . $post['goods_7'] . "##" . $post['goods_8'] . "##" . $post['goods_9'] . "@@";


    $post['15_oqqit_rate_1'] = $post['claims_1_1'] . "##" . $post['claims_1_2'] . "##" . $post['claims_1_3'] . "##" . $post['claims_1_4'] . "##" . $post['claims_1_5'] . "@@";
    $post['15_oqqit_rate_1'] .= $post['claims_2_1'] . "##" . $post['claims_2_2'] . "##" . $post['claims_2_3'] . "##" . $post['claims_2_4'] . "##" . $post['claims_2_5'];
    $post['15_oqqit_rate_2'] = $post['claims_3_1'] . "##" . $post['claims_3_2'] . "##" . $post['claims_3_3'] . "##" . $post['claims_3_4'] . "##" . $post['claims_3_5'] . "@@";
    $post['15_oqqit_rate_2'] .= $post['claims_4_1'] . "##" . $post['claims_4_2'] . "##" . $post['claims_4_3'] . "##" . $post['claims_4_4'] . "##" . $post['claims_4_5'];

    return $post;
}

function cmr_transport_item_1_main_info()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter, $formB, $quote;
    $formB->setLabelClasses('col-sm-4');

    $allFieldsNames[] = ['gr' => 'Χώρα', 'eng' => 'Country', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Εμπορικό Όνομα (αν διαφορετικό)', 'eng' => 'Trading Name (if different)', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Έτος Ίδρυσης Εταιρείας', 'eng' => 'Year Company Established', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Υπεύθυνος', 'eng' => 'Responsible Person', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Τηλέφωνο', 'eng' => 'Telephone', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Φαξ', 'eng' => 'Fax', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Κινητό', 'eng' => 'Mobile', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Ηλεκτρονική Διεύθυνση', 'eng' => 'E-Mail Address', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Διεύθυνση Ιστοσελίδας', 'eng' => 'Website Address', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Διεύθυνση Αλληλογραφίας', 'eng' => 'Correspondence Address', 'required' => true];
    $allFieldsNames[] = ['gr' => 'Α.Φ.Μ / Δ.Ο.Υ', 'eng' => 'VAT / Tax No.', 'required' => true];

    $i = 0;
    foreach ($allFieldsNames as $values) {
        $i++;
        ?>
        <div class="form-group row">
            <?php
            $formB->setFieldName('14_oqqit_rate_' . $i)
                ->setFieldDescription(show_quotation_text($values['gr'], $values['eng'], 'return'))
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
                        'required' => $values['required'],
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
        $formB->setFieldName('starting_date')
            ->setFieldDescription(show_quotation_text('Έναρξη Συμβολαίου', 'Policy Commencement', 'return'))
            ->setFieldType('input')
            ->setInputValue($quote->quotationData()['oqq_starting_date'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'date',
                    'required' => true,
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convertDateToEU($quote->quotationData()['oqq_starting_date'], 1, 0),
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>

        <?php
        $formB->setLabelClasses('col-sm-2');
        $formB->setFieldName('expiry_date')
            ->setFieldDescription(show_quotation_text('Λήξη', 'Expiry', 'return'))
            ->setFieldType('input')
            ->setInputValue($quote->quotationData()['oqq_expiry_date'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
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
    <?php
    $formB->setLabelClasses('col-sm-4');
    ?>
    <div class="row">
        <div class="col-12 alert alert-secondary text-center font-weight-bold">
            <?php echo show_quotation_text('Στοιχεία Επιχείρησης', 'Business Details') ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->setLabelClasses('col-sm-5');
        $formB->setFieldName('14_oqqit_rate_12')
            ->setFieldDescription(show_quotation_text('Εκτιμώμενος κύκλος εργασιών (12 μήνες)', 'Estimated turnover (12 months) ', 'return'))
            ->setFieldType('input')
            ->setInputValue($qitem_data['oqqit_rate_12'])
            ->buildLabel();
        ?>
        <div class="col-sm-7">
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

    <div class="row">
        <b>
            <?php show_quotation_text('Αριθμός οχημάτων που θα ασφαλιστούνε', 'Number of vehicles to be Insured'); ?>
        </b>
    </div>

    <div class="form-group row">
        <div class="col-3 text-center">
            <?php show_quotation_text('Αριθμός Κυκλοφορίας Οχήματος', 'Vehicle Registration Number'); ?>
        </div>
        <div class="col-3 text-center">
            <?php show_quotation_text('Ελκυστήρας', 'Tractor Unit'); ?>
        </div>
        <div class="col-3 text-center">
            <?php show_quotation_text('Τρέϊλερ', 'Trailer'); ?>
        </div>
        <div class="col-3 text-center">
            <?php show_quotation_text('Τύπος Οχήματος (βλ. κάτω)', 'Vehicle Type (see below)'); ?>
        </div>
    </div>

    <?php
    //Vehicles Data for 1 and 2 exists in these below
    $vehiclesAB = explode('@@', $qitem_data['oqqit_rate_13']);
    $vehiclesCD = explode('@@', $qitem_data['oqqit_rate_14']);

    //break down the fields for each vehicle
    $vehicles[1] = explode('##', $vehiclesAB[0]);
    $vehicles[2] = explode('##', $vehiclesAB[1]);

    $vehicles[3] = explode('##', $vehiclesCD[0]);
    $vehicles[4] = explode('##', $vehiclesCD[1]);

    $vNum = 0;
    foreach ($vehicles as $vehicle) {
        $vNum++;
        ?>
        <div class="form-group row">
            <?php
            for ($i = 1; $i <= 3; $i++) {
                ?>
                <div class="col-3 text-center">
                    <?php
                    $formB->setFieldName('vehicle_' . $vNum . '_' . $i)
                        ->setFieldType('input')
                        ->setInputValue($vehicle[($i - 1)])
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
                <?php
            }
            ?>
            <div class="col-3 text-center">
                <?php
                $formB->setFieldName('vehicle_' . $vNum . '_4')
                    ->setFieldType('select')
                    ->setInputSelectAddEmptyOption(true)
                    ->setInputSelectArrayOptions([
                        'Tarpaulin' => 'Tarpaulin',
                        'Box with cooling unit' => 'Box with cooling unit',
                        'Box without cooling unit' => 'Box without cooling unit',
                        'Tank - Silo' => 'Tank - Silo',
                        'Other Special Type' => 'Other Special Type'
                    ])
                    ->setFieldOnChange('vehiclesTypeOther(' . $vNum . ');')
                    ->setInputValue($vehicle[3])
                    ->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'select',
                        'required' => false,
                        'invalidTextAutoGenerate' => true
                    ]);

                $formB->setFieldName('vehicle_' . $vNum . '_5')
                    ->setFieldType('input')
                    ->setInputValue($vehicle[4])
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
        <?php
    }
    ?>

    <script>
        function vehiclesTypeOther(line) {
            if ($('#vehicle_' + line + '_4').val() == 'Other Special Type') {
                $('#vehicle_' + line + '_5').show();
            } else {
                $('#vehicle_' + line + '_5').hide();
            }
        }

        $(document).ready(function () {
            vehiclesTypeOther(1);
            vehiclesTypeOther(2);
            vehiclesTypeOther(3);
            vehiclesTypeOther(4);
        });
    </script>

    <div class="row">
        <b>
            <?php show_quotation_text('Γεωγραφική Σφαίρα Δραστηριοτήτων', 'Geographical Scope of Operations'); ?>
        </b>
    </div>

    <div class="form-group row">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            %<br>
            <?php show_quotation_text('Το σύνολο πρέπει να είναι 100%', 'The total must be equal to 100%'); ?>
        </div>
    </div>

    <?php
    $questionsAll = explode('@@', $qitem_data['oqqit_rate_15']);
    $geographic = explode('##', $questionsAll[0]);
    $geoList = [
        show_quotation_text('Διεθνείς μεταφορές εντός Ευρώπης', 'International Transports within Europe', 'return'),
        show_quotation_text('Διεθνείς μεταφορές εντός Ευρώπης Ι από και προς χώρες πρώην Σοβιετικής Ένωσης', 'International Transports within Europe / from and to CIS Countries', 'return'),
        show_quotation_text('Εθνικές Μεταφορές (αποκλειστικά εντός Ελλάδας)', 'National Transport (exclusively within Greece)', 'return'),
        show_quotation_text('Χώρες της Εγγύς και Μέσης Ανατολής (πχ. Ισραήλ)', 'Near and Middle east Countries (ex. Israel)', 'return')
    ];

    $i = 0;
    foreach ($geoList as $geo) {
        $i++;
        ?>

        <div class="form-group row">
            <?php
            $formB->setLabelClasses('col-sm-8');
            $formB->setFieldName('geographical_' . $i)
                ->setFieldDescription($geo)
                ->setFieldType('input')
                ->setFieldInputType('number')
                ->setFieldStyle('text-align:center;')
                ->setInputValue($geographic[($i - 1)])
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
        </div>
        <?php
    }
    $formValidator->addCustomCode('
                let totalGeo = ($("#geographical_1").val() * 1) + ($("#geographical_2").val() * 1) + ($("#geographical_3").val() * 1) + ($("#geographical_4").val() * 1);
                if (totalGeo != 100) {
                    $("#geographical_1").addClass("is-invalid");
                    $("#geographical_2").addClass("is-invalid");
                    $("#geographical_3").addClass("is-invalid");
                    $("#geographical_4").addClass("is-invalid");
                    $("#geographical_1").removeClass("is-valid");
                    $("#geographical_2").removeClass("is-valid");
                    $("#geographical_3").removeClass("is-valid");
                    $("#geographical_4").removeClass("is-valid");
                    FormErrorFound = true;
                }
                else {
                    $("#geographical_1").addClass("is-valid");
                    $("#geographical_2").addClass("is-valid");
                    $("#geographical_3").addClass("is-valid");
                    $("#geographical_4").addClass("is-valid");
                    $("#geographical_1").removeClass("is-invalid");
                    $("#geographical_2").removeClass("is-invalid");
                    $("#geographical_3").removeClass("is-invalid");
                    $("#geographical_4").removeClass("is-invalid");
                }
                ');
    ?>

    <div class="row">
        <b>
            <?php show_quotation_text('Περιγραφή Δραστηριοτήτων', 'Description of Operations'); ?>
        </b>
    </div>

    <?php
    $operations = explode('##', $questionsAll[1]);
    $opList = [
        show_quotation_text('Διεξάγετε εvδομεταφορές καμποτάζ;', 'Do you carry out Domestic haulage?', 'return'),
        show_quotation_text('Τα τρέϊλερ ταξιδεύουν ή παραμένουν ασυνόδευτα όταν είναι φορτωμένα με εμπόρευμα;', 'Do loaded trailer(s) travel or remain unaccompanied?', 'return'),
        show_quotation_text('Κάνετε τρακτορεύσεις τρέϊλερ ή κοντέινερ τρίτων;', 'Do you Haul third Party trailers or Containers?', 'return'),
        show_quotation_text('Διεξάγετε μεταφορές ως Διαμεταφορέας (Παραγγελιοδόχος μεταφοράς)', 'Do you transport cargo as a Freight forwarder', 'return')
    ];

    $i = 0;
    foreach ($opList as $op) {
        $i++;
        ?>

        <div class="form-group row">
            <?php
            $formB->setLabelClasses('col-sm-8');
            $formB->setFieldName('operations_' . $i)
                ->setFieldDescription($op)
                ->setFieldType('checkbox')
                ->setFieldStyle('text-align:center;')
                ->setInputCheckBoxValue('1')
                ->setInputValue($operations[($i - 1)])
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
        </div>
        <?php
    }
    ?>

    <div class="row">
        <b>
            <?php show_quotation_text('Μεταφερόμενα Εμπορεύματα ', 'Kind of Good Transported'); ?>
        </b>
    </div>

    <div class="form-group row">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            %<br>
            <?php show_quotation_text('Το σύνολο πρέπει να είναι 100%', 'The total must be equal to 100%'); ?>
        </div>
    </div>

    <?php
    $goods = explode('##', $questionsAll[2]);
    $goodsList = [
        show_quotation_text('Γενικό Εμπόρευμα', 'General Cargo', 'return'),
        show_quotation_text('Θερμοκρασιακά Ελεγχόμενα Φορτία', 'Refrigerated and/or temperature-controlled cargo', 'return'),
        show_quotation_text('Φορτία υψηλής αξίας (Ηλεκτρονικά, DVD, κλπ.)', 'High value cargo (Electronics, DVDs etc.)', 'return'),
        show_quotation_text('Προϊόντα καπνού', 'Tobacco products', 'return'),
        show_quotation_text('Κρασιά και οινοπνευματώδη ποτά', 'Wines and Spirits', 'return'),
        show_quotation_text('Επικίνδυνο φορτία', 'Hazardous cargo', 'return'),
        show_quotation_text('Φαρμακευτικά Προϊόντα', 'Pharmaceuticals', 'return'),
        show_quotation_text('Προσωπικά και Οικιακής Χρήσης αντικείμενα', 'Personal and Household effects', 'return'),
        show_quotation_text('Άλλα ', 'Other', 'return'),
    ];

    $i = 0;
    foreach ($goodsList as $good) {
        $i++;
        ?>

        <div class="form-group row">
            <?php
            $formB->setLabelClasses('col-sm-8');
            $formB->setFieldName('goods_' . $i)
                ->setFieldDescription($good)
                ->setFieldType('input')
                ->setFieldInputType('number')
                ->setFieldStyle('text-align:center;')
                ->setInputValue($goods[($i - 1)])
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
        </div>
        <?php
    }
    $formValidator->addCustomCode('
                let totalGoods = ($("#goods_1").val() * 1) + ($("#goods_2").val() * 1) + ($("#goods_3").val() * 1) + ($("#goods_4").val() * 1) + ($("#goods_5").val() * 1);
                totalGoods = totalGoods + ($("#goods_6").val() * 1) + ($("#goods_7").val() * 1) + ($("#goods_8").val() * 1) + ($("#goods_9").val() * 1);
                if (totalGoods != 100) {
                    $("#goods_1").addClass("is-invalid");
                    $("#goods_2").addClass("is-invalid");
                    $("#goods_3").addClass("is-invalid");
                    $("#goods_4").addClass("is-invalid");
                    $("#goods_5").addClass("is-invalid");
                    $("#goods_6").addClass("is-invalid");
                    $("#goods_7").addClass("is-invalid");
                    $("#goods_8").addClass("is-invalid");
                    $("#goods_9").addClass("is-invalid");
                    $("#goods_1").removeClass("is-valid");
                    $("#goods_2").removeClass("is-valid");
                    $("#goods_3").removeClass("is-valid");
                    $("#goods_4").removeClass("is-valid");
                    $("#goods_5").removeClass("is-valid");
                    $("#goods_6").removeClass("is-valid");
                    $("#goods_7").removeClass("is-valid");
                    $("#goods_8").removeClass("is-valid");
                    $("#goods_9").removeClass("is-valid");
                    FormErrorFound = true;
                }
                else {
                    $("#goods_1").addClass("is-valid");
                    $("#goods_2").addClass("is-valid");
                    $("#goods_3").addClass("is-valid");
                    $("#goods_4").addClass("is-valid");
                    $("#goods_5").addClass("is-valid");
                    $("#goods_6").addClass("is-valid");
                    $("#goods_7").addClass("is-valid");
                    $("#goods_8").addClass("is-valid");
                    $("#goods_9").addClass("is-valid");
                    $("#goods_1").removeClass("is-invalid");
                    $("#goods_2").removeClass("is-invalid");
                    $("#goods_3").removeClass("is-invalid");
                    $("#goods_4").removeClass("is-invalid");
                    $("#goods_5").removeClass("is-invalid");
                    $("#goods_6").removeClass("is-invalid");
                    $("#goods_7").removeClass("is-invalid");
                    $("#goods_8").removeClass("is-invalid");
                    $("#goods_9").removeClass("is-invalid");
                }
                ');

}

function cmr_transport_item_2_other_details()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter, $formB, $quote;
    $formB->setLabelClasses('col-sm-4');

    ?>
    <div class="form-group row">
        <b>
            <?php show_quotation_text('Ιστορικό Απαιτήσεων', 'Claims History'); ?>
        </b>
        <br>
        <?php
        show_quotation_text('
        Εάν είχατε υποστεί οποιαδήποτε απώλεια ή ζημιά ή υφίσταστε οποιαδήποτε ευθύνη κατά τη διάρκεια των τελευταίων 5 
        ετών η οποία έχει ή θα μπορούσε να οδηγήσει σε μια απαίτηση, Παρακαλώ δηλώστε:
        ', '
        Have you sustained any loss or damage or incurred any liability during the last 5 years which has or could 
        have resulted in a claim. Please provide details:
        ');
        ?>
    </div>

    <div class="form-group row">
        <div class="col-2 text-center">
            <?php show_quotation_text('Έτος', 'Year'); ?>
        </div>
        <div class="col-3 text-center">
            <?php show_quotation_text('Ασφαλιστική Εταιρεία', 'Insurer'); ?>
        </div>
        <div class="col-3 text-center">
            <?php show_quotation_text('Νούμερο Συμβολαίου', 'Policy No.'); ?>
        </div>
        <div class="col-2 text-center" style="font-size: 11px;">
            <?php show_quotation_text('Ποσό και νόμισμα που Πληρώθηκε', 'Amount Paid<br> (inc. currency)'); ?>
        </div>
        <div class="col-2 text-center" style="font-size: 11px;">
            <?php show_quotation_text('Ποσό και νόμισμα που Εκκρεμεί', 'Amount Reserved <br> (inc. currency)'); ?>
        </div>
    </div>

    <?php
    $claimsAB = explode('@@', $qitem_data['oqqit_rate_1']);
    $claimsCD = explode('@@', $qitem_data['oqqit_rate_2']);
    $claims[1] = explode('##', $claimsAB[0]);
    $claims[2] = explode('##', $claimsAB[1]);
    $claims[3] = explode('##', $claimsCD[0]);
    $claims[4] = explode('##', $claimsCD[1]);
    for ($i = 1; $i <= 4; $i++) {
        ?>

        <div class="form-group row">
            <div class="col-2 text-center">
                <?php
                $formB->setFieldName('claims_' . $i . '_1')
                    ->setFieldType('input')
                    ->setFieldInputType('number')
                    ->setInputValue($claims[$i][0])
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
            <div class="col-3 text-center">
                <?php
                $formB->setFieldName('claims_' . $i . '_2')
                    ->setFieldType('input')
                    ->setFieldInputType('text')
                    ->setInputValue($claims[$i][1])
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
            <div class="col-3 text-center">
                <?php
                $formB->setFieldName('claims_' . $i . '_3')
                    ->setFieldType('input')
                    ->setFieldInputType('text')
                    ->setInputValue($claims[$i][2])
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
            <div class="col-2 text-center">
                <?php
                $formB->setFieldName('claims_' . $i . '_4')
                    ->setFieldType('input')
                    ->setFieldInputType('number')
                    ->setInputValue($claims[$i][3])
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
            <div class="col-2 text-center">
                <?php
                $formB->setFieldName('claims_' . $i . '_5')
                    ->setFieldType('input')
                    ->setFieldInputType('number')
                    ->setInputValue($claims[$i][4])
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
        <?php
    }
    ?>
    <div class="form-group row">
        <b>
            <?php show_quotation_text('Συμβατικές βάσεις ευθύνης', 'Conventional basis of Liability'); ?>
        </b>
    </div>

    <div class="form-group row">
        <?php
        $formB->setLabelClasses('col-sm-8');
        $formB->setFieldName('15_oqqit_rate_3')
            ->setFieldDescription(show_quotation_text('Ειδικές συμφωνίες με εταιρίες (παρακαλούμε προσδιορίστε)', 'Special agreement with Companies (Please specify)', 'return'))
            ->setFieldType('input')
            ->setFieldInputType('text')
            ->setFieldStyle('text-align:center;')
            ->setInputValue($qitem_data['oqqit_rate_3'])
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
    </div>

    <div class="form-group row">
        <?php
        $formB->setLabelClasses('col-sm-8');
        $formB->setFieldName('15_oqqit_rate_4')
            ->setFieldDescription(show_quotation_text('Άλλοι Γενικοί Όροι Συναλλαγών (παρακαλούμε προσδιορίστε)', 'Other General Term Transaction (Please specify)', 'return'))
            ->setFieldType('input')
            ->setFieldInputType('text')
            ->setFieldStyle('text-align:center;')
            ->setInputValue($qitem_data['oqqit_rate_4'])
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
    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('
            Τα κάτωθι ασφάλιστρα αφορούν εξάμηνο τρόπο πληρωμής <br>Η απαλλαγή ισχύει για κάθε ζημιά-γεγονός, ανά όχημα
            ', '
            The following premiums refer to a six-month payment scheme <br> The deductible applies each and every loss per vehicle. 
            ');
        ?>
    </div>

    <div class="form-group row">
        <b><?php
            show_quotation_text('ΑΣΤΙΚΗ ΕΥΘΥΝΗ ΜΕΤΑΦΟΡΕΑ', 'HAULIERS CMR');
            ?></b>
    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('Για περισσότερα από 5 οχήματα ισχύει 5% έκπτωση. Για περισσότερα από 15 οχήματα ισχύει 10% έκπτωση',
            'For more than 5 vehicles 5% discount. For more than 15 vehicles 10% discount');
        ?>

    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('<b>Επιλογή 1η </b>&nbsp;&nbsp;', '<b>Option 1 &nbsp;&nbsp;</b>');

        $formB->initSettings()
            ->setFieldName('15_oqqit_rate_5')
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_5'])
            ->setRadioValue('1')
            ->setFieldOnChange('showHideExcessOptions();')
            ->buildInput();

        ?>
    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('
        ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR): Ανώτατο όριο ευθύνης €1.500.000 ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
        ΕΝΔΟΜΕΤΑΦΟΡΕΣ Cabotage: Ανώτατο όριο ευθύνης €600.000 ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.
        ', '
        INTERNATIONAL ROAD TRANSPORT (CMR): Maximum liability €1.500.000 per vehicle or other means of transport and storage.<br>
        DOMESTIC TRANSPORT Cabotage: Maximum liability of €600.000 per vehicle or other means of transport and storage.
        ');
        ?>
    </div>

    <div class="container-fluid" id="option1excess">

        <div class="form-group row mb-0">
            <div class="col-6 border ">
                <b><?php show_quotation_text('Απαλλαγή', 'Deductible'); ?></b>
            </div>
            <div class="col-3 text-center border d-inline-block">
                <?php

                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€500')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('1#500')
                    ->buildInput();
                ?>
            </div>
            <div class="col-3 text-center border">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€1.000')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('1#1000')
                    ->buildInput();
                ?>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Μουσαμάς', 'Tarpaulin'); ?></div>
            <div class="col-3 text-center border">
                €450
            </div>
            <div class="col-3 text-center border">
                €370
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Βυτίο - Σιλοφόρο', 'Tank - Silo'); ?></div>
            <div class="col-3 text-center border">
                €540
            </div>
            <div class="col-3 text-center border">
                €460
            </div>
        </div>
        <div class="form-group row">
            <div class="col-6 border"><?php show_quotation_text('Ψυγείο', 'Reefer'); ?></div>
            <div class="col-3 text-center border">
                €630
            </div>
            <div class="col-3 text-center border">
                €550
            </div>
        </div>
    </div>


    <div class="form-group row">
        <?php
        show_quotation_text('<b>Επιλογή 2η </b>&nbsp;&nbsp;', '<b>Option 2 &nbsp;&nbsp;</b>');

        $formB->initSettings()
            ->setFieldName('15_oqqit_rate_5')
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_5'])
            ->setRadioValue('2')
            ->setFieldOnChange('showHideExcessOptions();')
            ->buildInput();

        ?>
    </div>

    <div class="container-fluid" id="option2excess">

        <div class="form-group row mb-0">
            <div class="col-6 border ">
                <b><?php show_quotation_text('Απαλλαγή', 'Deductible'); ?></b>
            </div>
            <div class="col-3 text-center border d-inline-block">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€500')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('2#500')
                    ->buildInput();
                ?>
            </div>
            <div class="col-3 text-center border">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€1.000')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('2#1000')
                    ->buildInput();
                ?>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Μουσαμάς', 'Tarpaulin'); ?></div>
            <div class="col-3 text-center border">
                €350
            </div>
            <div class="col-3 text-center border">
                €300
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Βυτίο - Σιλοφόρο', 'Tank - Silo'); ?></div>
            <div class="col-3 text-center border">
                €440
            </div>
            <div class="col-3 text-center border">
                €380
            </div>
        </div>
        <div class="form-group row">
            <div class="col-6 border"><?php show_quotation_text('Ψυγείο', 'Reefer'); ?></div>
            <div class="col-3 text-center border">
                €530
            </div>
            <div class="col-3 text-center border">
                €460
            </div>
        </div>
    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('
        ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR): Ανώτατο όριο ευθύνης €100.000 ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.
        ', '
        INTERNATIONAL ROAD TRANSPORT (CMR): Maximum liability €100.000 per vehicle or other means of transport and storage.
        ');
        ?>
    </div>


    <div class="form-group row">
        <?php
        show_quotation_text('<b>Επιλογή 3η </b>&nbsp;&nbsp;', '<b>Option 3 &nbsp;&nbsp;</b>');

        $formB->initSettings()
            ->setFieldName('15_oqqit_rate_5')
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_5'])
            ->setRadioValue('3')
            ->setFieldOnChange('showHideExcessOptions();')
            ->buildInput();

        ?>
    </div>

    <div class="container-fluid" id="option3excess">

        <div class="form-group row mb-0">
            <div class="col-6 border ">
                <b><?php show_quotation_text('Απαλλαγή', 'Deductible'); ?></b>
            </div>
            <div class="col-3 text-center border d-inline-block">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€500')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('3#500')
                    ->buildInput();
                ?>
            </div>
            <div class="col-3 text-center border">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€1.000')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('3#1000')
                    ->buildInput();
                ?>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Μουσαμάς', 'Tarpaulin'); ?></div>
            <div class="col-3 text-center border">
                €590
            </div>
            <div class="col-3 text-center border">
                €480
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Βυτίο - Σιλοφόρο', 'Tank - Silo'); ?></div>
            <div class="col-3 text-center border">
                €700
            </div>
            <div class="col-3 text-center border">
                €600
            </div>
        </div>
        <div class="form-group row">
            <div class="col-6 border"><?php show_quotation_text('Ψυγείο', 'Reefer'); ?></div>
            <div class="col-3 text-center border">
                €810
            </div>
            <div class="col-3 text-center border">
                €720
            </div>
        </div>
    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('
        ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR): Ανώτατο όριο ευθύνης €1.500.000 ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
        ΕΝΔΟΜΕΤΑΦΟΡΕΣ Cabotage: Ανώτατο όριο ευθύνης €600.000 ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
        ΕΠΕΚΤΑΣΕΙΣ ΤΗΣ ΑΣΦΑΛΙΣΗΣ ΑΣΤΙΚΗΣ ΕΥΘΥΝΗΣ ΜΕΤΑΦΟΡΕΑ (CMR):<br>
        Ισχύει επικουρική ασφαλιστική κάλυψη εμπορευμάτων για λογαριασμό τρίτων σύμφωνα με τα Institute Cargo Clauses (C).<br>
        Η κάλυψη ενεργοποιείται για αξιώσεις τρίτων, οι οποίοι αποδεδειγμένα δεν έχουν ασφάλιση εμπορευμάτων.<br>
        Η ασφαλιστική κάλυψη ισχύει αποκλειστικά για ζημίες εμπορευμάτων που προκύπτουν από εισβολή μη εξουσιοδοτημένων 
        προσώπων στο όχημα (πχ. λαθρομετανάστες) ή/και από ατυχήματα στην ξηρά για τα οποία δεν φέρει ευθύνη ο ασφαλισμένος.<br>
        Το ανώτατο όριο ευθύνης της ασφαλιστικής εταιρίας είναι μέχρι €50.000 ανά ζημιά-γεγονός.
        ', '
        INTERNATIONAL ROAD TRANSPORT (CMR): Maximum liability €1.500.000 per vehicle or other means of transport and storage.<br>
        DOMESTIC TRANSPORT Cabotage: Maximum liability of €600.000,00 per vehicle or other means of transport and storage.<br>
        INSURANCE EXTENSION FOR ROAD TRANSPORT (CMR)<br>
        Ancillary insurance cover for third parties according to the Institute Cargo Clauses (C). Coverage is triggered 
        for third party claims, for which it is are proven that there is no insurance.<br>
        The insurance cover applies only to damage to goods resulting from the intrusion of unauthorized persons into 
        the vehicle (e.g. stowaways) and / or traffic accidents for which the insured is not liable.<br>
        The maximum liability is €50.000 per loss.
        ');
        ?>
    </div>


    <div class="form-group row">
        <?php
        show_quotation_text('<b>Επιλογή 4η </b>&nbsp;&nbsp;', '<b>Option 4 &nbsp;&nbsp;</b>');

        $formB->initSettings()
            ->setFieldName('15_oqqit_rate_5')
            ->setFieldType('radio')
            ->setInputValue($qitem_data['oqqit_rate_5'])
            ->setRadioValue('4')
            ->setFieldOnChange('showHideExcessOptions();')
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

    <div class="container-fluid" id="option4excess">

        <div class="form-group row mb-0">
            <div class="col-6 border ">
                <b><?php show_quotation_text('Απαλλαγή', 'Deductible'); ?></b>
            </div>
            <div class="col-3 text-center border d-inline-block">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€500')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('4#500')
                    ->buildInput();
                ?>
            </div>
            <div class="col-3 text-center border">
                <?php
                $formB->initSettings()
                    ->setFieldName('15_oqqit_rate_6')
                    ->setRadioLabelDescription('€1.000')
                    ->setFieldType('radio')
                    ->setInputValue($qitem_data['oqqit_rate_6'])
                    ->setRadioValue('4#1000')
                    ->buildInput();

                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'radio',
                        'invalidText' => 'Must Select',
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Μουσαμάς', 'Tarpaulin'); ?></div>
            <div class="col-3 text-center border">
                €480
            </div>
            <div class="col-3 text-center border">
                €390
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-6 border"><?php show_quotation_text('Βυτίο - Σιλοφόρο', 'Tank - Silo'); ?></div>
            <div class="col-3 text-center border">
                €590
            </div>
            <div class="col-3 text-center border">
                €490
            </div>
        </div>
        <div class="form-group row">
            <div class="col-6 border"><?php show_quotation_text('Ψυγείο', 'Reefer'); ?></div>
            <div class="col-3 text-center border">
                €700
            </div>
            <div class="col-3 text-center border">
                €590
            </div>
        </div>
    </div>

    <div class="form-group row">
        <?php
        show_quotation_text('
        ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR): Ανώτατο όριο ευθύνης €100.000 ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
        ΕΠΕΚΤΑΣΕΙΣ ΤΗΣ ΑΣΦΑΛΙΣΗΣ ΑΣΤΙΚΗΣ ΕΥΘΥΝΗΣ ΜΕΤΑΦΟΡΕΑ (CMR):<br>
        Ισχύει επικουρική ασφαλιστική κάλυψη εμπορευμάτων για λογαριασμό τρίτων σύμφωνα με τα Institute Cargo Clauses (C).<br>
        Η κάλυψη ενεργοποιείται για αξιώσεις τρίτων, οι οποίοι αποδεδειγμένα δεν έχουν ασφάλιση εμπορευμάτων.<br>
        Η ασφαλιστική κάλυψη ισχύει αποκλειστικά για ζημίες εμπορευμάτων που προκύπτουν από εισβολή μη εξουσιοδοτημένων 
        προσώπων στο όχημα (πχ. λαθρομετανάστες) ή/και από ατυχήματα στην ξηρά για τα οποία δεν φέρει ευθύνη ο ασφαλισμένος.<br>
        Το ανώτατο όριο ευθύνης της ασφαλιστικής εταιρίας είναι μέχρι €50.000 ανά ζημιά-γεγονός.
        ', '
        INTERNATIONAL ROAD TRANSPORT (CMR): Maximum liability €100.000 per vehicle or other means of transport and storage.<br>
        INSURANCE EXTENSION FOR ROAD TRANSPORT (CMR)<br>
        Ancillary insurance cover for third parties according to the Institute Cargo Clauses (C). Coverage is triggered 
        for third party claims, for which it is are proven that there is no insurance.<br>
        The insurance cover applies only to damage to goods resulting from the intrusion of unauthorized persons 
        into the vehicle (e.g. stowaways) and / or traffic accidents for which the insured is not liable.<br>
        The maximum liability is €50.000 per loss.
        ');
        ?>
    </div>

    <script>
        function showHideExcessOptions(){
            let selectedOption = $('input[name="15_oqqit_rate_5"]:checked').val();
            //disable all
            $("#option1excess :input").attr("disabled", true);
            $("#option2excess :input").attr("disabled", true);
            $("#option3excess :input").attr("disabled", true);
            $("#option4excess :input").attr("disabled", true);
            //hide all
            $('#option1excess').hide();
            $('#option2excess').hide();
            $('#option3excess').hide();
            $('#option4excess').hide();
            //show/enable the selected
            $('#option' + selectedOption + 'excess').show();
            $("#option" + selectedOption + "excess :input").attr("disabled", false);
        }

        $(document).ready(function(){
            showHideExcessOptions();
        });
    </script>


    <?php
}