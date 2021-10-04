<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 5/8/2021
 * Time: 2:00 μ.μ.
 */

include("../include/main.php");
include("../eurosure/lib/odbccon.php");
include('../scripts/form_validator_class.php');
include('../scripts/form_builder_class.php');

$db = new Main();

$sybase = new ODBCCON();

if ($_POST['action'] == 'insert'){

    $_POST['fld_status'] = 'Pending';
    $newID = $db->db_tool_insert_row('sms',$_POST,'fld_',1,'sms_');
    $db->generateSessionAlertSuccess('SMS Inserted Successfully');
    //header("Location: sms_modify.php?lid=".$newID );
    header("Location: sms.php" );
    exit();

}
else if ($_POST['action'] == 'update'){

    $db->db_tool_update_row('sms',$_POST,'sms_sms_ID = '.$_POST['lid'],$_POST['lid'],'fld_','execute','sms_');
    //header("Location: sms_modify.php?lid=".$_POST['lid'] );
    $db->generateSessionAlertSuccess('SMS Updated Successfully');
    header("Location: sms.php" );
    exit();
}

$data = [];
if ($_GET['lid'] != ''){
    $data = $db->query_fetch('SELECT * FROM sms WHERE sms_sms_ID = '.$_GET['lid']);
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

<form name="myForm" id="myForm" method="post" action="" onsubmit=""
    <?php $formValidator->echoFormParameters(); ?>>
    <div class="container">
        <div class="row">
            <div class="col alert alert-primary text-center font-weight-bold">
                SMS Modify/Insert
            </div>
        </div>

        <?php if ($_GET['lid'] != '') { ?>
        <div class="row form-group">
            <div class="col-sm-4">Status</div>
            <div class="col-sm-8">
                <span id="smsStatus"><?php echo $data['sms_status'];?></span>
                <?php
                if ($data['sms_status'] == 'Error') {
                    ?>
                    <span id="resetToPending"><a
                                href="#" onclick="resetToPending()">Reset To Pending</a></span>
                    <?php
                }
                ?>
                <input type="hidden" id="fld_status" name="fld_status" value="Pending" disabled>
            </div>
        </div>
            <script>
                function resetToPending(){
                    $('#smsStatus').html('Pending');
                    $('#resetToPending').html('');
                    $('#fld_status').prop('disabled',false);
                }
            </script>
        <?php } ?>

        <div class="row form-group">
            <?php

            if ($_GET['lid'] == ''){
                $data['sms_source_module'] = 'INTRANET';
            }

            $formB = new FormBuilder();
            $formB->setFieldName('fld_source_module')
                ->setFieldDescription('Source Module')
                ->setLabelClasses('col-sm-4')
                ->setFieldType('input')
                ->setInputValue($data['sms_source_module'])
                ->buildLabel();
            ?>
            <div class="col-8">
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
            $formB = new FormBuilder();
            $formB->setFieldName('fld_from')
                ->setFieldDescription('Sender')
                ->setLabelClasses('col-sm-4')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue($data['sms_from'])
                ->buildLabel();
            ?>
            <div class="col-8">
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
            $formB = new FormBuilder();
            $formB->setFieldName('fld_to_num')
                ->setFieldDescription('Recipient Number (To) 8 Digits Only')
                ->setLabelClasses('col-sm-4')
                ->setFieldType('input')
                ->setFieldInputType('number')
                ->setInputValue($data['sms_to_num'])
                ->buildLabel();
            ?>
            <div class="col-8">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => " || $('#fld_to_num').val().length != 8"
                    ]);
                ?>
            </div>
        </div>


        <div class="row form-group">
            <?php
            $formB = new FormBuilder();
            $formB->setFieldName('fld_message')
                ->setFieldDescription('Message')
                ->setLabelClasses('col-sm-4')
                ->setFieldType('textarea')
                ->setFieldInputType('text')
                ->setInputValue($data['sms_message'])
                ->buildLabel();
            ?>
            <div class="col-8">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'textarea',
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-4">Status Description</div>
            <div class="col-8"><?php echo $data['sms_status_description'];?></div>
        </div>

        <div class="row form-group">
            <div class="col text-center">
                <input type="hidden" id="lid" name="lid" value="<?php echo $_GET['lid'];?>">
                <input type="hidden" id="action" name="action" value="<?php if ($_GET['lid'] == '') echo 'insert'; else echo 'update';?>">
                <input type="button" class="btn btn-secondary" value="Back" onclick="window.location.assign('sms.php');">
                <input type="submit" value="Submit" class="btn btn-primary">
            </div>
        </div>

    </div>
</form>


<?php
$formValidator->output();
$db->show_footer();
?>
