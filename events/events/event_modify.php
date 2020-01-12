<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/11/2019
 * Time: 10:06 ΜΜ
 */
//error_reporting(-1);
include("../../include/main.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");
include('../../tools/autoFilesClass.php');


$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Events Modify";

if ($_POST["action"] == "insert") {
    $db->start_transaction();
    $db->check_restriction_area('insert');
    $db->working_section = 'Event Events Insert';

    $newID = $db->db_tool_insert_row('ev_events', $_POST, 'fld_', 1, 'evevt_');
    $db->commit_transaction();
    if ($_POST['subAction'] == 'exit') {
        header("Location: events.php");
        exit();
    } else {
        header("Location: event_modify.php?lid=" . $newID);
        exit();
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Event Events Update';

    $db->db_tool_update_row('ev_events', $_POST, "`evevt_event_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'evevt_');
    if ($_POST['subAction'] == 'exit') {
        header("Location: events.php");
        exit();
    } else {
        header("Location: event_modify.php?lid=" . $_POST['lid']);
        exit();
    }


}

$db->enable_jquery_ui();
$db->enable_jquery_ui_dateTimePicker();
$db->show_header();


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-4');

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM ev_events WHERE evevt_event_ID = ' . $_GET['lid']);
}
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-success text-center">
                            <strong><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Event</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">

                            <div class="row">
                                <?php
                                //remove seconds
                                $formB->initSettings()
                                    ->setFieldName('fld_active')
                                    ->setFieldDescription('Active')
                                    ->setFieldType('select')
                                    ->setInputSelectArrayOptions([
                                        'Active' => 'Active',
                                        'InActive' => 'InActive'
                                    ])
                                    ->setInputValue($data['evevt_active'])
                                    ->buildLabel();
                                ?>
                                <div class="col-sm-8">
                                    <?php
                                    $formB->buildInput();
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
                                $formB->initSettings()
                                    ->setFieldName('fld_branch_ID')
                                    ->setFieldDescription('Branch')
                                    ->setFieldType('select')
                                    ->setInputValue($data['evevt_branch_ID'])
                                    ->buildLabel();
                                ?>
                                <div class="col-sm-8">
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
                                $formB->initSettings()
                                    ->setFieldName('fld_room_ID')
                                    ->setFieldDescription('Room')
                                    ->setFieldType('select')
                                    ->setInputValue($data['evevt_room_ID'])
                                    ->buildLabel();
                                ?>
                                <div class="col-sm-8">
                                    <?php
                                    $locResult = $db->query('
                              SELECT 
                                evrom_name as name,
                                evrom_room_ID as value
                                FROM ev_rooms');
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
                                $formB->initSettings()
                                    ->setFieldName('fld_host_ID')
                                    ->setFieldDescription('Host')
                                    ->setFieldType('select')
                                    ->setInputValue($data['evevt_host_ID'])
                                    ->buildLabel();
                                ?>
                                <div class="col-sm-8">
                                    <?php
                                    $locResult = $db->query('
                              SELECT 
                                evhst_name as name,
                                evhst_host_ID as value
                                FROM ev_hosts');
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
                                $formB->initSettings()
                                    ->setFieldName('fld_title')
                                    ->setFieldDescription('Title')
                                    ->setFieldType('input')
                                    ->setInputValue($data['evevt_title'])
                                    ->buildLabel();
                                ?>
                                <div class="col-sm-8">
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
                                $formB->initSettings()
                                    ->setFieldName('fld_description')
                                    ->setFieldDescription('Description')
                                    ->setFieldType('textarea')
                                    ->setInputValue($data['evevt_description'])
                                    ->buildLabel();
                                ?>
                                <div class="col-sm-8">
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
                                <div class="col-sm-12 text-center">
                                    <input name="action" type="hidden" id="action"
                                           value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                                    <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                                    <input name="subAction" type="hidden" id="subAction" value="exit">
                                    <input type="button" value="Back" class="btn btn-secondary"
                                           onclick="window.location.assign('events.php')">
                                    <input type="submit" name="Submit" id="Submit"
                                           value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Event & Exit"
                                           class="btn btn-primary">
                                    <input type="submit" name="Submit" id="Submit"
                                           value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Event"
                                           class="btn btn-primary" onclick="$('#subAction').val('save');">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <iframe frameborder="0" src="event_schedules.php?layout=blank&lid=<?php echo $_GET['lid'];?>" width="100%" height="400"></iframe>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <?php if ($_GET['lid'] > 0) { ?>
                                <iframe width="100%" height="600" frameborder="0"
                                        src="event_images.php?lid=<?php echo $_GET['lid']; ?>"></iframe>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-12 alert alert-warning">Create the event to add images</div>
                                </div>
                            <?php } ?>

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