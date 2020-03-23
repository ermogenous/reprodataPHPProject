<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/10/2019
 * Time: 10:34 ΠΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');
include('entities_class.php');

$db = new Main();
$db->admin_title = "Accounts Entity Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Accounts Entity Inserting';

    $_POST['fld_birthdate'] = $db->convertDateToUS($_POST['fld_birthdate']);
    if ($_POST['fld_birthdate'] == ''){
        $_POST['fld_birthdate'] = '0000-00-00';
    }

    $db->db_tool_insert_row('ac_entities', $_POST, 'fld_', 0, 'acet_');
    header("Location: entities.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Accounts Entity Modifying';

    $_POST['fld_birthdate'] = $db->convertDateToUS($_POST['fld_birthdate']);

    $db->db_tool_update_row('ac_entities', $_POST, "`acet_entity_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'acet_');
    header("Location: entities.php");
    exit();

}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_entities` WHERE `acet_entity_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

    //check if entity is connected to a customer. If yes then lock the form
    $customer = $db->query_fetch('SELECT * FROM customers WHERE cst_entity_ID = ' . $_GET['lid']);
    if ($customer['cst_customer_ID'] > 0) {
        $formValidator->disableForm(['buttons']);
        $customerLock = true;
    }
    //check if entity is connected to an insurance company. If yes then lock the form
    if ($db->get_setting('ina_enable_agent_insurance') == 1) {
        $insComp = $db->query_fetch('SELECT * FROM ina_insurance_companies WHERE inainc_entity_ID = ' . $_GET['lid']);
        if ($insComp['inainc_insurance_company_ID'] > 0) {
            $formValidator->disableForm(['buttons']);
        }
        $insCompLock = true;
    }
}


?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center">
                            <strong><?php if ($_GET['lid'] == '') echo 'Create New'; else echo 'Modify'; ?>
                                Entity</strong>
                        </div>
                    </div>

                    <?php
                    if ($customer['cst_customer_ID'] > 0) {
                        ?>
                        <div class="row">
                            <div class="col-12 alert alert-warning text-center">
                                <strong>This entity is connected to a customer. To edit the fields you must edit the
                                    customer</strong>
                                <a href="../../customers/customers_modify.php?lid=<?php echo $customer['cst_customer_ID']; ?>">Edit
                                    Customer</a>
                            </div>
                        </div>
                        <?php
                    }
                    if ($insComp['inainc_insurance_company_ID'] > 0) {
                        ?>
                        <div class="row">
                            <div class="col-12 alert alert-warning text-center">
                                <strong>This entity is connected to an insurance company. To edit the fields you must
                                    edit the
                                    insurance company</strong><br>
                                <a href="../../ainsurance/codes/insurance_company_modify.php?lid=<?php echo $insComp['inainc_insurance_company_ID']; ?>">Edit
                                    Insurance Company</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                               role="tab"
                               aria-controls="pills-general" aria-selected="true">General Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-accounts-tab" data-toggle="pill" href="#pills-accounts"
                               role="tab"
                               aria-controls="pills-accounts" aria-selected="true">Accounts</a>
                        </li>


                    </ul>


                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                             aria-labelledby="pills-general-tab">
                            <!-- GENERAL TAB --------------------------------------------------------------------------------------------------------GENERAL TAB -->

                            <div class="form-group row">
                                <label for="fld_active" class="col-md-2 col-form-label">Active</label>
                                <div class="col-md-3">
                                    <select id="fld_active" name="fld_active" class="form-control">
                                        <option value="Active" <?php if ($data['acet_type'] == 'Active') echo 'selected'; ?>>
                                            Active
                                        </option>
                                        <option value="InActive" <?php if ($data['acet_type'] == 'InActive') echo 'selected'; ?>>
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
                                <label for="fld_name" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-4">
                                    <input name="fld_name" type="text" id="fld_name"
                                           value="<?php echo $data["acet_name"]; ?>"
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

                                <label for="fld_description" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-4">
                                    <input name="fld_description" type="text" id="fld_description"
                                           value="<?php echo $data["acet_description"]; ?>"
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
                            </div>

                            <div class="form-group row">
                                <label for="fld_mobile" class="col-md-2 col-form-label">Mobile</label>
                                <div class="col-md-4">
                                    <input name="fld_mobile" type="text" id="fld_mobile"
                                           value="<?php echo $data["acet_mobile"]; ?>"
                                           class="form-control"/>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_mobile',
                                            'fieldDataType' => 'text',
                                            'required' => false,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                                <label for="fld_work_tel" class="col-md-2 col-form-label">Work Tel</label>
                                <div class="col-md-4">
                                    <input name="fld_work_tel" type="text" id="fld_work_tel"
                                           value="<?php echo $data["acet_work_tel"]; ?>"
                                           class="form-control"/>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_work_tel',
                                            'fieldDataType' => 'text',
                                            'required' => false,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_fax" class="col-md-2 col-form-label">Fax</label>
                                <div class="col-md-4">
                                    <input name="fld_fax" type="text" id="fld_fax"
                                           value="<?php echo $data["acet_fax"]; ?>"
                                           class="form-control"/>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_fax',
                                            'fieldDataType' => 'text',
                                            'required' => false,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                                <label for="fld_email" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-4">
                                    <input name="fld_email" type="text" id="fld_email"
                                           value="<?php echo $data["acet_email"]; ?>"
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
                            </div>

                            <div class="form-group row">
                                <label for="fld_website" class="col-md-2 col-form-label">Website</label>
                                <div class="col-md-4">
                                    <input name="fld_website" type="text" id="fld_website"
                                           value="<?php echo $data["acet_website"]; ?>"
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

                                <label for="fld_birthdate" class="col-md-2 col-form-label">Birthdate</label>
                                <div class="col-md-4">
                                    <input name="fld_birthdate" type="text" id="fld_birthdate"
                                           value="<?php echo $data["acet_birthdate"]; ?>"
                                           class="form-control"/>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_birthdate',
                                            'fieldDataType' => 'date',
                                            'enableDatePicker' => true,
                                            'datePickerValue' => $db->convertDateToEU($data["acet_birthdate"]),
                                            'required' => false,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fld_comments" class="col-md-2 col-form-label">Comments</label>
                                <div class="col-md-4">
                                    <textarea name="fld_comments" type="text" id="fld_comments"
                                              class="form-control"><?php echo $data["acet_comments"]; ?></textarea>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_comments',
                                            'fieldDataType' => 'text',
                                            'required' => false,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade show" id="pills-accounts" role="tabpanel"
                             aria-labelledby="pills-accounts-tab">
                            <!-- ACCOUNTS TAB --------------------------------------------------------------------------------------------------------ACCOUNTS TAB -->

                            <iframe id="entityModifyAccountsFrame" name="entityModifyAccountsFrame" frameborder="0"
                                    src="entity_accounts_iframe.php?lid=<?php echo $_GET['lid']; ?>"
                                    width="100%" height="500"></iframe>


                        </div>


                    </div>

                    <br>


                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-md-block col-form-label"></label>
                        <div class="col-md-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('entities.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Entity"
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