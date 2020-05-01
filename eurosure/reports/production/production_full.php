<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 29/04/2020
 * Time: 11:08
 */

include("../../../include/main.php");
include("../../lib/production_class.php");
include("../../../scripts/form_validator_class.php");
include("../../../scripts/form_builder_class.php");
include("../../lib/odbccon.php");
include("../../lib/export_data.php");
$db = new Main(1);
$db->admin_title = "Eurosure Production Full Report";

$sybase = new ODBCCON();


if ($_POST['action'] == 'show'){
    $report = new synthesis_production();
    if ($_POST['reportType'] == 'AsAtDate'){
        $report->as_at_date = $db->convertDateToUS($_POST['asAtDate']);
    }

    if ($_POST['insuranceTypeFrom'] != ''){
        $report->add_insurance_types();
        $report->insert_where("AND inity_insurance_type = '".$_POST['insuranceTypeFrom'].'"');
    }

    //set the fields
    $report->insert_select('inity_insurance_type');
    $report->insert_select('inpol_policy_number');
    $report->add_phase_premium();


    $report->generate_sql();

    echo $db->prepare_text_as_html($report->sql);
    $sql = $report->sql;
}



$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$data['insuranceTypeFrom'] = '';

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

    <div class="container">
        <form name="myForm" id="myForm" method="post" action="" onsubmit=""
            <?php $formValidator->echoFormParameters(); ?>>

            <div class="row">
                <div class="col-12 alert alert-primary text-center">
                    <b>Production Report</b>
                </div>
            </div>

            <div class="form-group row">
                <?php
                $formB = new FormBuilder();
                $formB->setFieldName('reportType')
                    ->setFieldDescription('Report Type')
                    ->setFieldType('select')
                    ->setInputSelectArrayOptions([
                        'Period' => 'Period',
                        'AsAtDate' => 'As as Date'
                    ])
                    ->setInputValue($_POST['reportType'])
                    ->setLabelClasses('col-2')
                    ->buildLabel();
                ?>
                <div class="col-3">
                    <?php
                    $formB->buildInput();
                    $formValidator->addField(
                        [
                            'fieldName' => $formB->fieldName,
                            'fieldDataType' => 'select',
                            'required' => true,
                            'invalidTextAutoGenerate' => true
                        ]);
                    ?>
                </div>
                <?php
                $formB->setFieldName('asAtDate')
                    ->setFieldDescription('AsAtDate')
                    ->setFieldType('input')
                    ->setInputValue($_POST['asAtDate'])
                    ->buildLabel();
                ?>
                <div class="col-3">
                    <?php
                    $formB->buildInput();
                    $formValidator->addField(
                        [
                            'fieldName' => $formB->fieldName,
                            'fieldDataType' => 'date',
                            'required' => true,
                            'invalidTextAutoGenerate' => true,
                            'enableDatePicker' => true,
                            'datePickerValue' => $_POST['asAtDate']
                        ]);
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <?php
                $sql = 'SELECT * FROM ininsurancetypes ORDER BY inity_insurance_type ASC';
                $res = $sybase->query($sql);
                while ($row = $sybase->fetch_assoc($res)){
                    $insuranceTypeList[$row['inity_insurance_type']] = $row['inity_insurance_type']." - ".$row['inity_long_description'];
                }
                $formB->setFieldName('insuranceTypeFrom')
                    ->setFieldDescription('Insurance Type From')
                    ->setFieldType('select')
                    ->setInputValue($_POST['insuranceTypeFrom'])
                    ->setInputSelectArrayOptions($insuranceTypeList)
                    ->setInputSelectAddEmptyOption(true)
                    ->setLabelClasses('col-2')
                    ->buildLabel();
                ?>
                <div class="col-3">
                    <?php
                    $formB->buildInput();

                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="name" class="col-5 d-none d-sm-block col-form-label"></label>
                <div class="col-sm-7">
                    <input name="action" type="hidden" id="action" value="show">
                    <input type="submit" name="Submit" id="Submit" value="Execute"
                           class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>

<?php

if ($_POST['action'] == 'show'){
    echo export_data_html_table($report->sql,'sybase',"align=\"center\" border=\"1\"");
}

$formValidator->output();
$db->show_footer();
?>