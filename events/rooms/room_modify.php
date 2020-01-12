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
$db->admin_title = "Event Rooms Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Event Rooms Insert';


    $db->db_tool_insert_row('ev_rooms', $_POST, 'fld_', 0, 'evrom_');
    header("Location: rooms.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Event Rooms Update';


    $db->db_tool_update_row('ev_rooms', $_POST, "`evrom_room_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'evrom_');
    header("Location: rooms.php");
    exit();

}

$db->enable_jquery_ui();
$db->include_js_file('../../scripts/jquery_color_picker/colorpicker/jquery.colorpicker.js');
$db->include_css_file('../../scripts/jquery_color_picker/colorpicker/jquery.colorpicker.css');
$db->show_header();


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-3');

if ($_GET['lid'] != ''){
    $data = $db->query_fetch('SELECT * FROM ev_rooms WHERE evrom_room_ID = '.$_GET['lid']);
}
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-success text-center"><strong><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Room</strong></div>
                    </div>

                    <div class="row">
                        <?php
                        $formB->setFieldName('fld_branch_ID')
                            ->setFieldDescription('Branch')
                            ->setFieldType('select')
                            ->setInputValue($data['evrom_branch_ID'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $locResult = $db->query('
                              SELECT 
                                evbrh_name as name,
                                evbrh_branch_ID as value
                                FROM ev_branches');
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
                            ->setInputValue($data['evrom_name'])
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

                    <div class="row">
                        <?php
                        $formB->setFieldName('fld_description')
                            ->setFieldDescription('Description')
                            ->setFieldType('textarea')
                            ->setInputValue($data['evrom_description'])
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

                    <div class="row">
                        <?php
                        $formB->setFieldName('fld_color')
                            ->setFieldDescription('Room Color')
                            ->setFieldType('input')
                            ->setInputValue($data['evrom_color'])
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

                    <script>
                        $(function() {
                            $('#fld_color').colorpicker({
                                showOn:         'both',
                                showNoneButton: true,
                                showCloseButton: true,
                                showCancelButton: true,
                                colorFormat: ['#HEX'],
                                position: {
                                    my: 'center',
                                    at: 'center',
                                    of: window
                                },
                                modal: true
                            });
                        });
                    </script>

                    <div class="col-12" style="height: 25px;"></div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('rooms.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Room"
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