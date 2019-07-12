<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/7/2019
 * Time: 2:52 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
$db = new Main();
$db->admin_title = "Accounts";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Accounts Issue Transaction Inserting';


} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Accounts Issue Transaction Modifying';

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_transactions` WHERE `actm_transaction_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
//$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row alert alert-primary text-center">
                        <div class="col-12">
                            <strong>Issue Transaction</strong>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="documentCode" class="col-sm-2 col-form-label">Document</label>
                        <div class="col-sm-3">
                            <input name="documentCode" type="text" id="documentCode"
                                   value="<?php echo $data["accat_code"]; ?>"
                                   class="form-control" onchange="documentAutoSelect();"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'documentCode',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'requiredAddedCustomCode' => '|| $("#fld_document_ID").val() == ""',
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                            <input type="hidden" id="fld_document_ID" name="fld_document_ID" value="">
                        </div>
                        <div class="col-sm-1">
                            <img src="../../images/icon_spinner_transparent.gif" height="35px" style="display: none" id="doc_spinner">
                            <img src="../../images/icon_correct_green.gif" height="35px" style="display: none" id="doc_correct">
                            <img src="../../images/icon_error_x_red.gif" height="35px" style="display: none" id="doc_error">
                        </div>
                        <div class="col-sm-6 col-form-label" id="documentSelectedValue"></div>

                        <script>
                            //autocomplete
                            $('#documentCode').autocomplete({
                                source: '../documents/documents_api.php?section=searchDocuments',
                                delay: 1000,
                                minLength: 1,
                                messages: {
                                    noResults: '',
                                    results: function () {
                                        //console.log('customer auto');
                                    }
                                },
                                search: function( event, ui ) {

                                },
                                focus: function (event, ui) {
                                    $('#documentCode').val(ui.item.document_code);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $('#documentCode').val(ui.item.document_code);
                                    $('#fld_document_ID').val(ui.item.value);
                                    $('#documentSelectedValue').html(ui.item.label + ' - Last Number: ' + ui.item.clo_last_number_used);

                                    $('#doc_spinner').hide();

                                    return false;
                                }
                            });

                            function documentAutoSelect(){
                                $('#doc_correct').hide();
                                $('#doc_error').hide();
                                $('#doc_spinner').show();

                                let inputCode = $('#documentCode').val();
                                Rx.Observable.fromPromise($.get("../documents/documents_api.php?section=getFirstDocumentByCode&term=" + inputCode))
                                    .subscribe((response) => {
                                            data = response;
                                            //console.log(data);
                                        },
                                        () => {

                                        }
                                        ,
                                        () => {
                                            $('#doc_spinner').hide();
                                            if (data != null){
                                                $('#documentCode').val(data[0]['document_code']);
                                                $('#fld_document_ID').val(data[0]['value']);
                                                $('#documentSelectedValue').html(data[0]['label'] + ' - Last Number: ' + data[0]['clo_last_number_used']);
                                                $('#doc_correct').show();
                                            }else {
                                                $('#doc_error').show();

                                                //$('#documentCode').val(data[0]['document_code']);
                                                $('#documentSelectedValue').html('');
                                                $('#fld_document_ID').val('');
                                            }

                                        }
                                    )
                                ;
                            }
                        </script>



                    </div>

                    <div class="form-group row">
                        <label for="fld_type" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-6">
                            <select id="fld_type" name="fld_type" class="form-control">
                                <option value="Category" <?php if ($data['accat_type'] == 'Category') echo 'selected';?>>Category</option>
                                <option value="SubCategory" <?php if ($data['accat_type'] == 'SubCategory') echo 'selected';?>>SubCategory</option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_type',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-6">
                            <input name="fld_name" type="text" id="fld_name"
                                   value="<?php echo $data["accat_name"]; ?>"
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
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('accounts.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Account"
                                   class="btn btn-primary">
                        </div>
                    </div>


                </form>


            </div>
            <div class="col-1 d-none d-md-block"></div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>