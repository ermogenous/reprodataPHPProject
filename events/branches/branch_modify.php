<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/11/2019
 * Time: 10:06 ΜΜ
 */

include("../../include/main.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Branch Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Event Branch Insert';


    $db->db_tool_insert_row('ev_branches', $_POST, 'fld_', 0, 'evbrh_');
    header("Location: branches.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Event Branch Update';


    $db->db_tool_update_row('ev_branches', $_POST, "`evbrh_branch_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'evbrh_');
    header("Location: branches.php");
    exit();

}

$db->enable_jquery_ui();
$db->show_header();


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-3');

if ($_GET['lid'] != ''){
    $data = $db->query_fetch('SELECT * FROM ev_branches WHERE evbrh_branch_ID = '.$_GET['lid']);
}
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-success text-center"><strong><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Branch</strong></div>
                    </div>

                    <div class="row">
                        <?php
                        $formB->setFieldName('fld_location_code_ID')
                            ->setFieldDescription('City Location')
                            ->setFieldType('select')
                            ->setInputValue($data['evbrh_location_code_ID'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $locResult = $db->query('
                              SELECT 
                                cde_value as name,
                                cde_code_ID as value
                                FROM codes WHERE cde_type = "Cities"');
                            $formB->setInputSelectQuery($locResult)
                                ->setInputSelectAddEmptyOption(true)
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

                    <div class="row">
                        <?php
                        $formB->setFieldName('fld_name')
                            ->setFieldDescription('Name')
                            ->setFieldType('input')
                            ->setInputValue($data['evbrh_name'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
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

                    <div class="col-12" style="height: 25px;"></div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('branches.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Branch"
                                   class="btn btn-primary">
                        </div>
                    </div>

                </form>

            </div>
            <div class="col-1"></div>
        </div>
    </div>
<?php
$formValidator->output();
$db->show_footer();
?>