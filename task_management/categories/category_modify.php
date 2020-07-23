<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 16/07/2020
 * Time: 14:43
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Task Management - Category Modify";

if ($_POST['action'] == 'insert') {
    $db->check_restriction_area('insert');
    $db->working_section = 'Task Management - Category Inserting';

    $db->start_transaction();

    $db->db_tool_insert_row('tsm_categories', $_POST, 'fld_', 0, 'tsmct_');

    $db->commit_transaction();
    header("Location: categories.php");
    exit();

} else if ($_POST['action'] == 'update') {
    $db->check_restriction_area('update');
    $db->working_section = 'Task Management - Category Updating';

    $db->start_transaction();

    $db->db_tool_update_row('tsm_categories', $_POST, 'tsmct_category_ID = ' . $_POST["lid"], $_POST['lid']
        , 'fld_', 'execute', 'tsmct_');
    $db->commit_transaction();
    header("Location: categories.php");
    exit();
}

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM tsm_categories WHERE tsmct_category_ID = ' . $_GET['lid']);
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
            <div class="col-2 d-none d-md-block"></div>
            <div class="col-12 col-md-8">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Task Management - Category Modify</b></div>
                    </div>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_status')
                            ->setFieldDescription('Status')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('select')
                            ->setInputValue($data['tsmct_status'])
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-9">
                            <?php
                            $formB->setInputSelectArrayOptions([
                                'Active' => 'Active',
                                'InActive' => 'InActive'
                            ])
                                ->buildInput();
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_type')
                            ->setFieldDescription('Type')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('select')
                            ->setInputValue($data['tsmct_type'])
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-9">
                            <?php
                            $formB->setInputSelectArrayOptions([
                                'Project' => 'Project',
                                'Category' => 'Category'
                            ])
                                ->buildInput();
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_owner_ID')
                            ->setFieldDescription('Owner Category')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('select')
                            ->setInputValue($data['tsmct_owner_ID'])
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-9">
                            <?php
                            $sql = 'SELECT * FROM tsm_categories WHERE tsmct_status = "Active" ORDER BY tsmct_code';
                            $result = $db->query($sql);
                            $inputOptions[0] = 'Project';
                            while ($row = $db->fetch_assoc($result)){
                                $inputOptions[$row['tsmct_category_ID']] = $row['tsmct_code']." - ".$row['tsmct_name'];
                            }
                            $formB->setInputSelectArrayOptions($inputOptions)
                                ->buildInput();
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_code')
                            ->setFieldDescription('Code')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setInputValue($data['tsmct_code'])
                            ->buildLabel();
                        ?>
                        <div class="col-9">
                            <?php
                                $formB->buildInput();
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_name')
                            ->setFieldDescription('Name/Description')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setInputValue($data['tsmct_name'])
                            ->buildLabel();
                        ?>
                        <div class="col-9">
                            <?php
                            $formB->buildInput();
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
                                   onclick="window.location.assign('categories.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Category"
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