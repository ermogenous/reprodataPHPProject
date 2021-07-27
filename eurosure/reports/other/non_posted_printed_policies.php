<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 6/7/2021
 * Time: 2:01 μ.μ.
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main();

$sybase = new ODBCCON('SySystem');

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="row">
                <div class="col-12 alert alert-primary text-center">
                    <b>Non Posted Printed Policies In Period</b>
                </div>
            </div>

            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row form-group">
                    <?php
                    $searchTypeOptions = [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12'
                    ];

                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_period')
                        ->setFieldDescription('Period')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputValue($_POST['sch_period'])
                        ->setInputSelectArrayOptions($searchTypeOptions)
                        ->setInputSelectAddEmptyOption(true)
                        ->buildLabel();
                    ?>
                    <div class="col-3">
                        <?php
                        $formB->buildInput();
                        ?>
                    </div>

                    <?php
                    $searchTypeOptions = [
                        'Motor' => 'Motor',
                        'Non Motor' => 'Non Motor',
                        'ALL' => 'ALL'
                    ];

                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_section')
                        ->setFieldDescription('Products')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputValue($_POST['sch_section'])
                        ->setInputSelectArrayOptions($searchTypeOptions)
                        ->setInputSelectAddEmptyOption(true)
                        ->buildLabel();
                    ?>
                    <div class="col-2">
                        <?php
                        $formB->buildInput();
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 text-center">
                        <input type="hidden" id="action" name="action" value="search">
                        <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" style="width: 200px;">
                    </div>
                </div>

            </form>

            <?php
            if ($_POST['action'] == 'search'){
                ?>
                    <div class="row">
                        <div class="col">
                            sfklhas
                        </div>
                    </div>
                <?php
            }

            ?>

        </div>
        <div class="col-1"></div>
    </div>
</div>


<?php
$formValidator->output();
$db->show_footer();
?>
