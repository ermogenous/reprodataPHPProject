<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/7/2019
 * Time: 2:06 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
$db = new Main();
$db->admin_title = "Accounts";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');


    $db->db_tool_insert_row('ac_accounts', $_POST, 'fld_', 0, 'acacc_');
    header("Location: accounts.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');


    $db->db_tool_update_row('ac_accounts', $_POST, "`acacc_account_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'acacc_');
    header("Location: accounts.php");
    exit();

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_accounts` WHERE `acacc_account_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
    $balance = $data["acacc_balance"];

} else {
    $balance = 0;
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');

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
                                <option value="Active" <?php if ($data['accat_type'] == 'Active') echo 'selected';?>>Active</option>
                                <option value="InActive" <?php if ($data['accat_type'] == 'InActive') echo 'selected';?>>InActive</option>
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
                        <label for="fld_code" class="col-sm-3 col-form-label">Code</label>
                        <div class="col-sm-5">
                            <input name="fld_code" type="text" id="fld_code"
                                   value="<?php echo $data["accat_code"]; ?>"
                                   class="form-control" onchange="validateCode();"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_code',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'requiredAddedCustomCode' => '&& $("#codeValidation").val() != "ok"'
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
                            Rx.Observable.fromPromise($.get("categories_api.php?section=validateCategoryCode&value=" + code))
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
            <div class="col-1 d-none d-sm-block"></div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>