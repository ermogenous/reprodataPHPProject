<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 03/04/2020
 * Time: 16:18
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');

$db = new Main();
$db->admin_title = "Synthesis - Company Modify";

if ($_POST['action'] == 'insert') {
    $db->check_restriction_area('insert');
    $db->working_section = 'Synthesis Company Inserting';

    $db->start_transaction();

    $db->db_tool_insert_row('sy_companies', $_POST, 'fld_', 0, 'syco_');

    $db->commit_transaction();
    header("Location: companies.php");
    exit();

} else if ($_POST['action'] == 'update') {
    $db->check_restriction_area('update');
    $db->working_section = 'Synthesis Company Updating';

    $db->start_transaction();

    $db->db_tool_update_row('sy_companies', $_POST, 'syco_company_ID = ' . $_POST["lid"], $_POST['lid']
        , 'fld_', 'execute', 'syco_');
    $db->commit_transaction();
    header("Location: companies.php");
    exit();
}

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM sy_companies WHERE syco_company_ID = ' . $_GET['lid']);
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1 d-none d-md-block"></div>
        <div class="col-12 col-md-10">
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>Companies</b></div>
                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_status')
                        ->setFieldDescription('Status')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputValue($data['syco_status'])
                        ->setInputSelectAddEmptyOption(true)
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->setInputSelectArrayOptions([
                            'Active' => 'Active',
                            'InActive' => 'InActive'
                        ])
                            ->buildInput();
                        ?>
                    </div>

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_code')
                        ->setFieldDescription('Code')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_code'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    $formB->setFieldName('fld_name')
                        ->setFieldDescription('Name')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_name'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_database_code')
                        ->setFieldDescription('Database Code')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_database_code'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    $formB->setFieldName('fld_database_ip')
                        ->setFieldDescription('Database IP')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_database_ip'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_logo')
                        ->setFieldDescription('Logo (disabled)')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_logo'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_admin_user_name')
                        ->setFieldDescription('Admin UserName')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_admin_user_name'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_admin_password')
                        ->setFieldDescription('Admin Password (encrypted)')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['syco_admin_password'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
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
                    <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('companies.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Company"
                               class="btn btn-primary">
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
