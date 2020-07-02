<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 24/06/2020
 * Time: 11:15
 */

include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Accounts - Reports - General Journal";


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


                <div class="row form-group">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Accounts - General Journal</b>
                    </div>
                </div>
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row form-group">
                        <?php
                        $sql = 'SELECT 
                            acacc_account_ID as value,
                            CONCAT(acacc_code," ",acacc_name) as name
                            FROM ac_accounts WHERE acacc_active = "Active" ORDER BY acacc_code ASC';
                        $result = $db->query($sql);

                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_account')
                            ->setFieldDescription('Account')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('select')
                            ->setInputValue($_POST['sch_account'])
                            ->setInputSelectQuery($result)
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-4">
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
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('sch_date_from')
                            ->setFieldDescription('Date From')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('date')
                            ->setInputValue($_POST['sch_date_from'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                        <?php
                        $formB->initSettings()
                            ->setFieldName('sch_date_to')
                            ->setFieldDescription('Date To')
                            ->setLabelClasses('col-sm-1')
                            ->setFieldType('input')
                            ->setFieldInputType('date')
                            ->setInputValue($_POST['sch_date_to'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="show">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Show Report"
                                   class="btn btn-primary">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-1"></div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>