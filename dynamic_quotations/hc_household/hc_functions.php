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
            <?php echo show_quotation_text('Διεύθυνση Υποστατικού (αν διαφέρει)', 'Premises Address (if different') ?>
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
            <?php
            $formB->setInputCheckBoxValue(1)
                ->setFieldOnChange('copyAdress();')
                ->buildInput();
            ?>
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
        function copyAdress(){
            if ($('#sameAddress').prop("checked") == true){
                $('#9_oqqit_rate_8').val( $('#9_oqqit_rate_1').val() );
                $('#9_oqqit_rate_9').val( $('#9_oqqit_rate_2').val() );
                $('#9_oqqit_rate_10').val( $('#9_oqqit_rate_3').val() );
                $('#9_oqqit_rate_11').val( $('#9_oqqit_rate_4').val() );
                $('#9_oqqit_rate_12').val( $('#9_oqqit_rate_5').val() );
                $('#9_oqqit_rate_13').val( $('#9_oqqit_rate_6').val() );
                $('#9_oqqit_rate_14').val( $('#9_oqqit_rate_7').val() );
            }

        }
    </script>
    <?php


}