<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/11/2019
 * Time: 10:00 ΠΜ
 */

ini_set('display_errors', '1');
ini_set('html_errors', '1');
ini_set('error_reporting', 'E_ALL');

include("../include/main.php");
include('../scripts/form_validator_class.php');
include('../scripts/form_builder_class.php');
include('synthesis_class.php');


$db = new Main();
$db->admin_title = "Synthesis Web Service Modify Account";


if ($_POST['action'] == 'update') {
    $syn = new Synthesis();
    $data['account_code'] = $_POST['lid'];
    $data['long_description'] = $_POST['fld_ccac_long_desc'];
    $data['addr_lin1'] = $_POST['fld_ccad_addr_lin1'];
    $data['addr_lin2'] = $_POST['fld_ccad_addr_lin2'];
    $data['addr_lin3'] = $_POST['fld_ccad_addr_lin3'];
    $data['addr_lin4'] = $_POST['fld_ccad_addr_lin4'];
    $data['crdt_lmit'] = $_POST['fld_ccad_crdt_lmit'];
    $data['crdt_days'] = $_POST['fld_ccad_crdt_days'];
    $result = $syn->updateAccountDetails($data);
    $resultID = $result->rs_auto_serial;

    $status = $syn->checkImportStatus($resultID);
    $db->generateAlertSuccess('Update status for ' . $resultID . ' is: ' . $status->rs_record_status);
}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

if ($_GET['lid'] != '') {
    $syn = new Synthesis();
    $data = $syn->getAccountDetails($_GET['lid']);
}

$db->enable_jquery_ui();
$db->show_header();

FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-4 col-md-4 col-lg-3');
$formB->setFieldDivClass('col-sm-5 col-md-5 col-lg-5');
$fontSize = '';

?>

    <div class="container-fluid" style="<?php echo $fontSize; ?>">
        <div class="row">
            <div class=".d-sm-none .d-md-block col-md-1"></div>
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><strong>Modify Account</strong></div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccac_acct_code')
                            ->setFieldDescription('Account Code')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccac_acct_code)
                            ->setFieldStyle($fontSize)
                            ->setDisableField();

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccac_long_desc')
                            ->setFieldDescription('Account Long Description')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccac_long_desc)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccad_addr_lin1')
                            ->setFieldDescription('Address Line 1')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccad_addr_lin1)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccad_addr_lin2')
                            ->setFieldDescription('Address Line 2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccad_addr_lin2)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccad_addr_lin3')
                            ->setFieldDescription('Address Line 3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccad_addr_lin3)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccad_addr_lin4')
                            ->setFieldDescription('Address Line 4')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccad_addr_lin4)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccad_crdt_lmit')
                            ->setFieldDescription('Credit Limit')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccad_crdt_lmit)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="row form-group">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_ccad_crdt_days')
                            ->setFieldDescription('Credit Days')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data->ccad_crdt_days)
                            ->setFieldStyle($fontSize);

                        $formB->buildLabel();
                        ?>
                        <div class="<?php echo $formB->getFieldDivClass();?>">
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

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-md-block col-form-label"></label>
                        <div class="col-md-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('web_service_test.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Account"
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