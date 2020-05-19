<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 15/05/2020
 * Time: 13:54
 */

include("../../include/main.php");
include("../synthesis_class.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Synthesis Account Modify";

$syn = new Synthesis();


if ($_POST['action'] == 'update') {
    //$syn = new Synthesis();
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

    $db->generateAlertSuccess('Account changes send. Might need some time for changes to take effect.');
    $_GET['lid'] = $_POST['lid'];
}



if ($_GET['lid'] != '') {
    //$syn = new Synthesis();
    $data = $syn->getAccountDetails($_GET['lid']);
    $accountStatus = $syn->checkImportStatus('account',$_GET['lid'])->rs_record_status;
}

$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-2 col-md-2 col-lg-2');
$formB->setFieldDivClass('col-sm-4 col-md-4 col-lg-4');
$fontSize = '';

$formValidator = new customFormValidator();

if ($accountStatus == 'OUTSTANDING' || $accountStatus == 'PROCESSING'){
    $formValidator->disableForm([
        'buttons'
    ]);
    $db->generateAlertWarning('Pending account change. Cannot make any new changes. Update Status: '.$accountStatus);
}
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

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
                                    'required' => false,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

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
                                    'required' => false,
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
                                   onclick="window.location.assign('accounts.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Account"
                                   class="btn btn-primary">
                            <input type="button" value="View Account Transactions" class="btn btn-secondary"
                                   onclick="window.location.assign('transactions_list.php?lid=<?php echo $_GET['lid'];?>')">
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