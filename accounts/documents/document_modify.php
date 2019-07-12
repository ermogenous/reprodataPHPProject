<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/7/2019
 * Time: 2:21 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
$db = new Main();
$db->admin_title = "Accounts Document Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Accounts Document Inserting';

    $db->db_tool_insert_row('ac_documents', $_POST, 'fld_', 0, 'acdoc_');
    header("Location: documents.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Accounts Document Modifying';

    $db->db_tool_update_row('ac_documents', $_POST, "`acdoc_document_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'acdoc_');
    header("Location: documents.php");
    exit();

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_documents` WHERE `acdoc_document_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-1 d-none d-sm-block"></div>
            <div class="col-12 col-sm-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="form-group row">
                        <label for="fld_active" class="col-sm-3 col-form-label">Active</label>
                        <div class="col-sm-6">
                            <select id="fld_active" name="fld_active" class="form-control">
                                <option value="Active" <?php if ($data['acdoc_type'] == 'Active') echo 'selected';?>>Active</option>
                                <option value="InActive" <?php if ($data['acdoc_type'] == 'InActive') echo 'selected';?>>InActive</option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_active',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_code" class="col-sm-3 col-form-label">Unique Code</label>
                        <div class="col-sm-5">
                            <input name="fld_code" type="text" id="fld_code"
                                   value="<?php echo $data["acdoc_code"]; ?>"
                                   class="form-control" onchange="validateCode();"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_code',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'requiredAddedCustomCode' => '|| $("#codeValidation").val() != "ok"'
                                ]);
                            ?>
                        </div>
                        <div class="col-sm-4">
                            <img src="../../images/icon_spinner_transparent.gif" height="35px" style="display: none" id="code_spinner">
                            <img src="../../images/icon_correct_green.gif" height="35px" style="display: none" id="code_correct">
                            <img src="../../images/icon_error_x_red.gif" height="35px" style="display: none" id="code_error">
                            <input type="hidden" id="codeValidation" name="codeValidation" value="ok">
                        </div>
                    </div>

                    <script>
                        function validateCode(){

                            //start spinner
                            $('#code_spinner').show();
                            $('#code_correct').hide();
                            $('#code_error').hide();

                            let code = $('#fld_code').val();
                            Rx.Observable.fromPromise($.get("documents_api.php?section=validateDocCode&value=" + code))
                                .subscribe((response) => {
                                        data = response;
                                    },
                                    () => {
                                        //error
                                        $('#code_spinner').hide();
                                        $('#code_error').show();
                                        $('#codeValidation').val('error');
                                    }
                                    ,
                                    () => {
                                        //compete
                                        $('#code_spinner').hide();
                                        if (data['clo_total'] > 0 || code == ''){
                                            $('#code_error').show();
                                            $('#codeValidation').val('error');
                                        }
                                        else {
                                            $('#code_correct').show();
                                            $('#codeValidation').val('ok');
                                        }
                                    }
                                )
                            ;

                        }
                    </script>

                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-6">
                            <input name="fld_name" type="text" id="fld_name"
                                   value="<?php echo $data["acdoc_name"]; ?>"
                                   class="form-control"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_name',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_number_prefix" class="col-sm-3 col-form-label">Doc Number Prefix</label>
                        <div class="col-sm-6">
                            <input name="fld_number_prefix" type="text" id="fld_number_prefix"
                                   value="<?php echo $data["acdoc_number_prefix"]; ?>"
                                   class="form-control"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_number_prefix',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_number_leading_zeros" class="col-sm-3 col-form-label">Doc Number Leading Zeros</label>
                        <div class="col-sm-6">
                            <input name="fld_number_leading_zeros" type="text" id="fld_number_leading_zeros"
                                   value="<?php echo $data["acdoc_number_leading_zeros"]; ?>"
                                   class="form-control"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_number_leading_zeros',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_number_last_used" class="col-sm-3 col-form-label">Doc Number Last Used</label>
                        <div class="col-sm-6">
                            <input name="fld_number_last_used" type="text" id="fld_number_last_used"
                                   value="<?php echo $data["acdoc_number_last_used"]; ?>"
                                   class="form-control"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_number_last_used',
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('documents.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Account"
                                   class="btn btn-primary">
                        </div>
                    </div>


                </form>


            </div>
            <div class="col-1 d-none d-sm-block"></div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>