<?php
include("../include/main.php");
include('../ainsurance/customers/insurance_balance_class.php');
include('../scripts/form_validator_class.php');
include('customer_class.php');
$db = new Main();
$db->admin_title = "Customers Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->start_transaction();

    $_POST['fld_for_user_group_ID'] = $db->user_data['usr_users_groups_ID'];
    $_POST['fld_user_ID'] = $db->user_data['usr_users_ID'];
    $_POST['fld_birthdate'] = $db->convertDateToUS($_POST['fld_birthdate']);
    if ($_POST['fld_birthdate'] == '') {
        $_POST['fld_birthdate'] = '0000-00-00';
    }

    $customerNewID = $db->db_tool_insert_row('customers', $_POST, 'fld_', 1, 'cst_');


    if ($db->dbSettings['ina_enable_agent_insurance']['value'] == 1 && $db->dbSettings['accounts']['value'] == 'advanced') {
        $insuranceSettings = $db->query_fetch('SELECT * FROM ina_settings');
        if ($insuranceSettings['inaset_auto_create_entity_from_client'] == 1) {
            $customer = new Customers($customerNewID);
            $customer->createACEntity();
        }
    }

    //check for basic accounts to create the customer account
    /*if ($db->dbSettings['accounts']['value'] == 'basic') {
        include('../basic_accounts/basic_accounts_class.php');
        $bacc = new BasicAccounts();
        $bacc->createAccountForAllCustomers();
    }
    */

    $db->commit_transaction();

    header("Location: customers.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $db->start_transaction();

    $_POST['fld_birthdate'] = $db->convertDateToUS($_POST['fld_birthdate']);
    if ($_POST['fld_birthdate'] == '') {
        $_POST['fld_birthdate'] = '0000-00-00';
    }

    $db->db_tool_update_row('customers', $_POST, "`cst_customer_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'cst_');

    $customer = new Customers($_POST['lid']);
    $customer->updateCustomer();
    /*if ($db->dbSettings['accounts']['value'] == 'basic') {
        include('../basic_accounts/basic_accounts_class.php');
        $bacc = new BasicAccounts();
        $bacc->updateAccountDetailsFromCustomer($_POST['lid']);
    }
    */

    $db->commit_transaction();
    header("Location: customers.php");
    exit();


}

if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `customers` WHERE `cst_customer_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

}
$balance = new aInsuranceBalance($_GET['lid']);


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->show_header();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-1 col-md-2 hidden-xs hidden-sm"></div>
        <div class="col-lg-10 col-md-8 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Customer</b>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                           role="tab"
                           aria-controls="pills-general" aria-selected="true">General</a>
                    </li>
                    <?php if ($db->get_setting('prd_enable_products') == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-products-tab" data-toggle="pill" href="#pills-products"
                               role="tab"
                               aria-controls="pills-products" aria-selected="true">Products</a>
                        </li>
                    <?php } ?>

                    <?php if ($_GET['lid'] > 0) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-groups-tab" data-toggle="pill" href="#pills-groups"
                               role="tab"
                               aria-controls="pills-groups" aria-selected="true">Groups</a>
                        </li>

                        <?php
                        if ($db->dbSettings['ina_enable_agent_insurance']['value'] == 1) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-policies-tab" data-toggle="pill" href="#pills-policies"
                                   role="tab"
                                   aria-controls="pills-policies" aria-selected="true">Policies</a>
                            </li>
                        <?php } ?>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-unpaid-tab" data-toggle="pill" href="#pills-unpaid"
                               role="tab"
                               aria-controls="pills-unpaid" aria-selected="true">Unpaid Installments</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-entity-tab" data-toggle="pill" href="#pills-entity"
                               role="tab"
                               aria-controls="pills-entity" aria-selected="true">Entity/Accounts</a>
                        </li>
                    <?php } ?>


                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                         aria-labelledby="pills-general-tab">
                        <!-- GENERAL -->
                        <div class="row">
                            <div class="col-3" style="height: 40px;">Balance</div>
                            <div class="col-9">
                                <?php echo $balance->getBalance(); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fld_business_type_code_ID" class="col-sm-3 col-form-label">Business Type</label>
                            <div class="col-sm-9">
                                <select name="fld_business_type_code_ID" id="fld_business_type_code_ID"
                                        class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'BusinessType' ORDER BY cde_value ASC");
                                    while ($bt = $db->fetch_assoc($btResult)) {

                                        ?>
                                        <option value="<?php echo $bt['cde_code_ID']; ?>"
                                            <?php if ($bt['cde_code_ID'] == $data['cst_business_type_code_ID']) echo 'selected'; ?>>
                                            <?php echo $bt['cde_value']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_business_type_code_ID',
                                        'fieldDataType' => 'select',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_identity_card" class="col-sm-3 col-form-label">I.D.</label>
                            <div class="col-sm-9">
                                <input name="fld_identity_card" type="text" id="fld_identity_card"
                                       class="form-control"
                                       value="<?php echo $data["cst_identity_card"]; ?>">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_identity_card',
                                        'fieldDataType' => 'text',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input name="fld_name" type="text" id="fld_name"
                                       class="form-control"
                                       value="<?php echo $data["cst_name"]; ?>">
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
                            <label for="fld_surname" class="col-sm-3 col-form-label">Surname</label>
                            <div class="col-sm-9">
                                <input name="fld_surname" type="text" id="fld_surname"
                                       class="form-control"
                                       value="<?php echo $data["cst_surname"]; ?>">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_surname',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_address_line_1" class="col-sm-3 col-form-label">Address Line 1</label>
                            <div class="col-sm-9">
                                <input name="fld_address_line_1" type="text" id="fld_address_line_1"
                                       value="<?php echo $data["cst_address_line_1"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_address_line_1',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_address_line_1" class="col-sm-3 col-form-label">Address Line 2</label>
                            <div class="col-sm-9">
                                <input name="fld_address_line_2" type="text" id="fld_address_line_2"
                                       value="<?php echo $data["cst_address_line_2"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_address_line_2',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_city_code_ID" class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                                <select name="fld_city_code_ID" id="fld_city_code_ID"
                                        class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'Cities' ORDER BY cde_value ASC");
                                    while ($bt = $db->fetch_assoc($btResult)) {

                                        ?>
                                        <option value="<?php echo $bt['cde_code_ID']; ?>"
                                            <?php if ($bt['cde_code_ID'] == $data['cst_city_code_ID']) echo 'selected'; ?>>
                                            <?php echo $bt['cde_value']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_city_code_ID',
                                        'fieldDataType' => 'select',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_contact_person" class="col-sm-3 col-form-label">Contact Person</label>
                            <div class="col-sm-9">
                                <input name="fld_contact_person" type="text" id="fld_contact_person"
                                       value="<?php echo $data["cst_contact_person"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_contact_person',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_contact_person_title_code_ID"
                                   class="col-sm-3 col-form-label">C.P.Title</label>
                            <div class="col-sm-9">
                                <select name="fld_contact_person_title_code_ID" id="fld_contact_person_title_code_ID"
                                        class="form-control">
                                    <option value=""
                                        <?php if ('' == $data['cst_contact_person_title_code_ID']) echo 'selected'; ?>>
                                        -----
                                    </option>
                                    <?php
                                    $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'ContactPersonTitle' ORDER BY cde_value ASC");
                                    while ($bt = $db->fetch_assoc($btResult)) {

                                        ?>
                                        <option value="<?php echo $bt['cde_code_ID']; ?>"
                                            <?php if ($bt['cde_code_ID'] == $data['cst_contact_person_title_code_ID']) echo 'selected'; ?>>
                                            <?php echo $bt['cde_value']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_contact_person_title_code_ID',
                                        'fieldDataType' => 'select',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_birthdate" class="col-sm-3 col-form-label">Birthdate</label>
                            <div class="col-sm-9">
                                <input name="fld_birthdate" type="text" id="fld_birthdate"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_birthdate',
                                        'fieldDataType' => 'date',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true,
                                        'enableDatePicker' => true,
                                        'datePickerValue' => $db->convertDateToEU($data['cst_birthdate'])
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_work_tel_1" class="col-sm-3 col-form-label">Work Tel 1</label>
                            <div class="col-sm-9">
                                <input name="fld_work_tel_1" type="text" id="fld_work_tel_1"
                                       value="<?php echo $data["cst_work_tel_1"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_work_tel_1',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_work_tel_2" class="col-sm-3 col-form-label">Work Tel 2</label>
                            <div class="col-sm-9">
                                <input name="fld_work_tel_2" type="text" id="fld_work_tel_2"
                                       value="<?php echo $data["cst_work_tel_2"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_work_tel_2',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_fax" class="col-sm-3 col-form-label">Fax</label>
                            <div class="col-sm-9">
                                <input name="fld_fax" type="text" id="fld_fax"
                                       value="<?php echo $data["cst_fax"]; ?>"
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
                        </div>

                        <div class="form-group row">
                            <label for="fld_mobile_1" class="col-sm-3 col-form-label">Mobile 1</label>
                            <div class="col-sm-9">
                                <input name="fld_mobile_1" type="text" id="fld_mobile_1"
                                       value="<?php echo $data["cst_mobile_1"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_mobile_1',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_mobile_2" class="col-sm-3 col-form-label">Mobile 2</label>
                            <div class="col-sm-9">
                                <input name="fld_mobile_2" type="text" id="fld_mobile_2"
                                       value="<?php echo $data["cst_mobile_2"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_mobile_2',
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input name="fld_email" type="text" id="fld_email"
                                       value="<?php echo $data["cst_email"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_email',
                                        'fieldDataType' => 'email',
                                        'required' => false,
                                        'validateEmail' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_email_newsletter" class="col-sm-3 col-form-label">Email NewsLetter</label>
                            <div class="col-sm-9">
                                <input name="fld_email_newsletter" type="text" id="fld_email_newsletter"
                                       value="<?php echo $data["cst_email_newsletter"]; ?>"
                                       class="form-control"/>
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'fld_email_newsletter',
                                        'fieldDataType' => 'email',
                                        'required' => false,
                                        'validateEmail' => true,
                                        'invalidTextAutoGenerate' => true
                                    ]);
                                ?>
                            </div>
                        </div>

                        <?php $formValidator->generateErrorDescriptionDiv(); ?>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <input name="action" type="hidden" id="action"
                                       value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                                <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                                <input type="button" value="Back" class="btn btn-secondary"
                                       onclick="window.location.assign('customers.php')">
                                <input type="submit" name="Submit" id="Submit"
                                       value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Customer"
                                       class="btn btn-secondary">
                            </div>
                        </div>

                    </div>


                    <?php if ($_GET['lid'] > 0 && $db->get_setting('prd_enable_products') == 1) { ?>
                        <!-- PRODUCTS -->
                        <div class="tab-pane fade show" id="pills-products" role="tabpanel"
                             aria-labelledby="pills-products-tab">

                            <iframe src="customers_products.php?cid=<?php echo $_GET["lid"]; ?>"
                                    frameborder="0"
                                    scrolling="0" width="100%" height="400"></iframe>

                        </div>
                    <?php } ?>





                    <?php if ($_GET['lid'] > 0) { ?>
                        <!-- Customer Groups ------------------------------------------------------------------------------------>
                        <div class="tab-pane fade show" id="pills-groups" role="tabpanel"
                             aria-labelledby="pills-groups-tab">

                            <iframe src="customers_groups_list.php?cid=<?php echo $_GET["lid"]; ?>"
                                    frameborder="0"
                                    scrolling="0" width="100%" height="400"></iframe>

                        </div>

                        <?php
                        if ($db->dbSettings['ina_enable_agent_insurance']['value'] == 1) {
                            ?>
                            <!-- Customer Policies ------------------------------------------------------------------------------------>
                            <div class="tab-pane fade show" id="pills-policies" role="tabpanel"
                                 aria-labelledby="pills-policies-tab">

                                <iframe src="customers_policies.php?cid=<?php echo $_GET["lid"]; ?>"
                                        frameborder="0"
                                        scrolling="0" width="100%" height="400"></iframe>

                            </div>
                        <?php } ?>


                        <!-- Customer Unpaid Installments ------------------------------------------------------------------------->
                        <div class="tab-pane fade show" id="pills-unpaid" role="tabpanel"
                             aria-labelledby="pills-unpaid-tab">

                            <iframe src="../ainsurance/customers/customer_unpaid.php?cid=<?php echo $_GET["lid"]; ?>"
                                    frameborder="0" id="frmCustomerUnpaidTab"
                                    scrolling="0" width="100%" height="400"></iframe>

                        </div>
                    <?php } ?>

                    <!-- Entity/Accounts -->
                    <div class="tab-pane fade show" id="pills-entity" role="tabpanel"
                         aria-labelledby="pills-entity-tab">

                        <iframe src="customer_entity_tab.php?lid=<?php echo $_GET["lid"]; ?>"
                                frameborder="0" id="frmCustomerEntityTab"
                                scrolling="0" width="100%" height="600"></iframe>

                    </div>

                </div>


            </form>
        </div>
    </div>
</div>

<?php
$formValidator->output();
$db->show_footer();
?>
