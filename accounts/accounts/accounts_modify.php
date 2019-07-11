<?php
include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('accounts_class.php');
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

$db->show_header();
?>

<div class="container">
    <div class="row">
        <div class="col-1 d-none d-sm-block"></div>
        <div class="col-12 col-sm-10">

            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>


                <div class="alert alert-primary text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>&nbsp;Account</b>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                           role="tab"
                           aria-controls="pills-general" aria-selected="true">General Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-other-tab" data-toggle="pill" href="#pills-other"
                           role="tab"
                           aria-controls="pills-other" aria-selected="true">Other</a>
                    </li>

                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                         aria-labelledby="pills-general-tab">
                        <!-- GENERAL --------------------------------------------------------------------------------------------------------------------------------------------GENERAL TAB-->

                        <div class="form-group row">
                            <label for="fld_control" class="col-sm-2 col-form-label">Control Account</label>
                            <div class="col-sm-4">
                                <select name="fld_control" id="fld_control"
                                        class="form-control">
                                    <option value="0" <?php if ($data['acacc_control'] == '0') echo 'selected'; ?>>
                                        Account
                                    </option>
                                    <option value="1" <?php if ($data['acacc_control'] == '1') echo 'selected'; ?>>
                                        Control
                                    </option>
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

                            <label for="fld_active" class="col-sm-2 col-form-label">Active</label>
                            <div class="col-sm-4">
                                <select name="fld_active" id="fld_active"
                                        class="form-control">
                                    <option value="Active" <?php if ($data['acacc_active'] == 'Active') echo 'selected'; ?>>
                                        Active
                                    </option>
                                    <option value="InActive" <?php if ($data['acacc_active'] == 'InActive') echo 'selected'; ?>>
                                        InActive
                                    </option>
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
                            <label for="fld_parent_ID" class="col-sm-2 col-form-label">Parent</label>
                            <div class="col-sm-4">
                                <select name="fld_parent_ID" id="fld_parent_ID"
                                        class="form-control">
                                    <option value="0">Root</option>
                                    <?php
                                        $controlAccountsList = AdvAccounts::getControlAccountList();
                                        foreach($controlAccountsList as $account){
                                    ?>
                                    <option value="<?php echo $account['acacc_account_ID'];?>" <?php if ($data['acacc_parent_ID'] == '1') echo 'selected'; ?>>
                                        <?php echo $account['acacc_code']." - ".$account['acacc_name'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_parent_ID',
                                        'fieldDataType' => 'select',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_code" class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-4">
                                <input name="fld_code" type="text" id="fld_code"
                                       value="<?php echo $data["acacc_code"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_code',
                                        'fieldDataType' => 'text',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>

                            <label for="fld_name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-4">
                                <input name="fld_name" type="text" id="fld_name"
                                       value="<?php echo $data["acacc_name"]; ?>"
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
                            <label for="fld_type" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-4">
                                <select name="fld_type" id="fld_type"
                                        class="form-control">
                                    <option value=""></option>
                                    <option value="Fixed Assets" <?php if ($data['acacc_type'] == 'Fixed Assets') echo 'selected'; ?>>
                                        Fixed Assets
                                    </option>
                                    <option value="Investments" <?php if ($data['acacc_type'] == 'Investments') echo 'selected'; ?>>
                                        Investments
                                    </option>
                                    <option value="Current Assets" <?php if ($data['acacc_type'] == 'Current Assets') echo 'selected'; ?>>
                                        Current Assets
                                    </option>
                                    <option value="Current Liabilities" <?php if ($data['acacc_type'] == 'Current Liabilities') echo 'selected'; ?>>
                                        Current Liabilities
                                    </option>
                                    <option value="Long Term Liabilities" <?php if ($data['acacc_type'] == 'Long Term Liabilities') echo 'selected'; ?>>
                                        Long Term Liabilities
                                    </option>
                                    <option value="Capital & Reserves" <?php if ($data['acacc_type'] == 'Capital & Reserves') echo 'selected'; ?>>
                                        Capital & Reserves
                                    </option>
                                    <option value="Profit & Loss" <?php if ($data['acacc_type'] == 'Profit & Loss') echo 'selected'; ?>>
                                        Profit & Loss
                                    </option>
                                    <option value="Expenses" <?php if ($data['acacc_type'] == 'Expenses') echo 'selected'; ?>>
                                        Expenses
                                    </option>
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

                            <label for="fld_debit_credit" class="col-sm-2 col-form-label">Debit/Credit</label>
                            <div class="col-sm-4">
                                <select name="fld_debit_credit" id="fld_debit_credit"
                                        class="form-control">
                                    <option value="1" <?php if ($data['acacc_debit_credit'] == '1') echo 'selected'; ?>>
                                        Debit +
                                    </option>
                                    <option value="-1" <?php if ($data['acacc_debit_credit'] == '-1') echo 'selected'; ?>>
                                        Credit -
                                    </option>
                                </select>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_debit_credit',
                                        'fieldDataType' => 'select',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane fade show" id="pills-other" role="tabpanel"
                         aria-labelledby="pills-other-tab">
                        <!-- OTHER ------------------------------------------------------------------------------------------------------------------------------------------------OTHER TAB-->

                        <div class="form-group row">
                            <label for="fld_description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-4">
                                <input name="fld_description" type="text" id="fld_description"
                                       value="<?php echo $data["acacc_description"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_description',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>

                            <label for="fld_mobile" class="col-sm-2 col-form-label">Mobile</label>
                            <div class="col-sm-4">
                                <input name="fld_mobile" type="text" id="fld_mobile"
                                       value="<?php echo $data["acacc_mobile"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_mobile',
                                        'fieldDataType' => 'number',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_work_tel" class="col-sm-2 col-form-label">Work Tel</label>
                            <div class="col-sm-4">
                                <input name="fld_work_tel" type="text" id="fld_work_tel"
                                       value="<?php echo $data["acacc_work_tel"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_work_tel',
                                        'fieldDataType' => 'number',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>

                            <label for="fld_fax" class="col-sm-2 col-form-label">Fax</label>
                            <div class="col-sm-4">
                                <input name="fld_fax" type="text" id="fld_fax"
                                       value="<?php echo $data["acacc_fax"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_fax',
                                        'fieldDataType' => 'number',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input name="fld_email" type="text" id="fld_email"
                                       value="<?php echo $data["acacc_email"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_email',
                                        'fieldDataType' => 'email',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>

                            <label for="fld_website" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-4">
                                <input name="fld_website" type="text" id="fld_website"
                                       value="<?php echo $data["acacc_website"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_website',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>


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
