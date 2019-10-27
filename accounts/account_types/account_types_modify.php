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
$db->admin_title = "Accounts Type Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');


    $db->db_tool_insert_row('ac_account_types', $_POST, 'fld_', 0, 'actpe_');
    header("Location: account_types.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');


    $db->db_tool_update_row('ac_account_types', $_POST, "`actpe_account_type_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'actpe_');
    header("Location: account_types.php");
    exit();

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_account_types` WHERE `actpe_account_type_ID` = " . $_GET["lid"];
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
            <div class="col-1 d-none d-sm-block"></div>
            <div class="col-12 col-sm-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="form-group row">
                        <label for="fld_active" class="col-sm-3 col-form-label">Active</label>
                        <div class="col-sm-6">
                            <select id="fld_active" name="fld_active" class="form-control">
                                <option value="Active" <?php if ($data['actpe_type'] == 'Active') echo 'selected';?>>Active</option>
                                <option value="InActive" <?php if ($data['actpe_type'] == 'InActive') echo 'selected';?>>InActive</option>
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
                            <select id="fld_type" name="fld_type" onchange="changeType();"
                                    class="form-control">
                                <option value="Type" <?php if ($data['actpe_type'] == 'Type') echo 'selected';?>>Type</option>
                                <option value="SubType" <?php if ($data['actpe_type'] == 'SubType') echo 'selected';?>>SubType</option>
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

                    <script>
                        function changeType(){
                            let type = $('#fld_type').val();
                            if (type == 'Type'){
                                $('#ownerDiv').hide();
                                $('#fld_owner_ID').attr('disabled',true);
                            }
                            else {
                                $('#ownerDiv').show();
                                $('#fld_owner_ID').attr('disabled',false);
                            }
                        }
                    </script>

                    <div class="form-group row" id="ownerDiv">
                        <label for="fld_owner_ID" class="col-sm-3 col-form-label">Owner</label>
                        <div class="col-sm-6">
                            <select id="fld_owner_ID" name="fld_owner_ID" class="form-control" onchange="autoCategory();">
                                <?php
                                    $sql = "SELECT * FROM ac_account_types WHERE actpe_type = 'Type' ORDER BY actpe_code ASC";
                                    $result = $db->query($sql);
                                    while($row = $db->fetch_assoc($result)){
                                        $jsCodeTypeCategory .= 'typeCategoryList['.$row['actpe_account_type_ID'].'] = "'.$row['actpe_category'].'";
                                        ';
                                ?>
                                <option value="<?php echo $row['actpe_account_type_ID'];?>" <?php if ($data['actpe_owner_ID'] == $row['actpe_account_type_ID']) echo 'selected';?>>
                                    <?php echo $row['actpe_code']." - ".$row['actpe_name'];?>
                                </option>
                                <?php } ?>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_owner_ID',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>
                    <script>
                        let typeCategoryList = Array;
                        <?php echo $jsCodeTypeCategory; ?>

                        function autoCategory(){
                            let type = $('#fld_type').val();
                            if (type == 'SubType'){
                                let owner = $('#fld_owner_ID').val();
                                $('#fld_category').val(typeCategoryList[owner]);
                            }
                        }
                    </script>

                    <div class="form-group row">
                        <label for="fld_category" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-6">
                            <select id="fld_category" name="fld_category" onchange="autoCategory();"
                                    class="form-control">
                                <option value=""></option>
                                <option value="FixedAsset" <?php if ($data['actpe_category'] == 'FixedAsset') echo 'selected';?>>Fixed Asset</option>
                                <option value="CurrentAsset" <?php if ($data['actpe_category'] == 'CurrentAsset') echo 'selected';?>>Current Asset</option>
                                <option value="CurrentLiability" <?php if ($data['actpe_category'] == 'CurrentLiability') echo 'selected';?>>Current Liability</option>
                                <option value="LongTermLiability" <?php if ($data['actpe_category'] == 'LongTermLiability') echo 'selected';?>>Long Term Liability</option>
                                <option value="CapitalReserve" <?php if ($data['actpe_category'] == 'CapitalReserve') echo 'selected';?>>Capital & Reserve</option>
                                <option value="Revenue" <?php if ($data['actpe_category'] == 'Revenue') echo 'selected';?>>Revenue</option>
                                <option value="Expense" <?php if ($data['actpe_category'] == 'Expense') echo 'selected';?>>Expense</option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_category',
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
                                   value="<?php echo $data["actpe_code"]; ?>"
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
                            let exclude = '<?php echo $_GET['lid'];?>';
                            Rx.Observable.fromPromise($.get("account_types_api.php?section=validateAccountTypeCode&value=" + code + "&exclude=" + exclude))
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
                                   value="<?php echo $data["actpe_name"]; ?>"
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
                                   onclick="window.location.assign('account_types.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Type"
                                   class="btn btn-primary">
                        </div>
                    </div>


                </form>


            </div>
            <div class="col-1 d-none d-sm-block"></div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        changeType();
    });
</script>
<?php
$formValidator->output();
$db->show_footer();
?>