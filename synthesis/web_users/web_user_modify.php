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
$db->admin_title = "Synthesis - Web Users";

if ($_POST['action'] == 'insert') {
    $db->check_restriction_area('insert');
    $db->working_section = 'Synthesis Web User Inserting';

    $db->start_transaction();

    $db->db_tool_insert_row('sy_web_users', $_POST, 'fld_', 0, 'sywu_');

    $db->commit_transaction();
    header("Location: web_users.php");
    exit();

} else if ($_POST['action'] == 'update') {
    $db->check_restriction_area('update');
    $db->working_section = 'Synthesis Web User Updating';

    $db->start_transaction();

    $db->db_tool_update_row('sy_web_users', $_POST, 'sywu_web_user_ID = ' . $_POST["lid"], $_POST['lid']
        , 'fld_', 'execute', 'sywu_');
    $db->commit_transaction();
    header("Location: web_users.php");
    exit();
}

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM sy_web_users WHERE sywu_web_user_ID = ' . $_GET['lid']);
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
                    <div class="col-12 alert alert-primary text-center"><b>Web User</b></div>
                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_status')
                        ->setFieldDescription('Status')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputValue($data['sywu_status'])
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
                    $formB->setFieldName('fld_company_ID')
                        ->setFieldDescription('Company')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputValue($data['sywu_company_ID'])
                        ->setInputSelectAddEmptyOption(true)
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->setInputSelectQuery($db->query('SELECT syco_company_ID as value, syco_name as name
                            FROM sy_companies'))
                            ->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>
                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_user_code')
                        ->setFieldDescription('User Code/Email')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['sywu_user_code'])
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
                    $formB->setFieldName('fld_name')
                        ->setFieldDescription('Name')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['sywu_name'])
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
                    $formB->setFieldName('fld_menu')
                        ->setFieldDescription('Menu')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['sywu_menu'])
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
                               onclick="window.location.assign('web_users.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Web User"
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
