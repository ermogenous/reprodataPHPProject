<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/11/2019
 * Time: 4:07 ΜΜ
 */

include("../../include/main.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");
include('../../tools/autoFilesClass.php');


$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Event Schedule Modify";

if ($_GET['lid'] == '') {
    header("Location: ../home.php");
    exit();
}

if ($_POST["action"] == "insert") {
    $db->start_transaction();
    $db->check_restriction_area('insert');
    $db->working_section = 'Event Event Schedule Modify';

    $_POST['fld_start_date_time'] = $db->convertDateToUS($_POST['fld_start_date_time'], 1, 1);
    $_POST['fld_end_date_time'] = $db->convertDateToUS($_POST['fld_end_date_time'], 1, 1);
    $_POST['fld_event_ID'] = $_POST['lid'];

    $newID = $db->db_tool_insert_row('ev_event_schedules', $_POST, 'fld_', 1, 'evsch_');
    $db->commit_transaction();
    if ($_POST['subAction'] == 'exit') {
        header("Location: event_schedules.php?layout=".$_GET['layout']."&lid=" . $_POST['lid']);
        exit();
    } else {
        header("Location: event_schedule_modify.php?layout=".$_GET['layout']."&lid=" . $_POST['lid'] . "&eid=" . $newID);
        exit();
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Event Event Schedule Modify';

    $_POST['fld_start_date_time'] = $db->convertDateToUS($_POST['fld_start_date_time'], 1, 1);
    $_POST['fld_end_date_time'] = $db->convertDateToUS($_POST['fld_end_date_time'], 1, 1);

    $db->db_tool_update_row('ev_event_schedules', $_POST, "`evsch_event_schedule_ID` = " . $_POST["eid"],
        $_POST["eid"], 'fld_', 'execute', 'evsch_');
    if ($_POST['subAction'] == 'exit') {
        header("Location: event_schedules.php?layout=".$_GET['layout']."&lid=" . $_POST['lid']);
        exit();
    } else {
        header("Location: event_schedule_modify.php?layout=".$_GET['layout']."&lid=" . $_POST['lid'] . "&eid=" . $_POST['eid']);
        exit();
    }


}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-1');

if ($_GET['eid'] != '') {
    $data = $db->query_fetch('
            SELECT * FROM ev_event_schedules 
            JOIN ev_events ON evevt_event_ID = evsch_event_ID
            WHERE evsch_event_schedule_ID = ' . $_GET['eid']);
}
$eventData = $db->query_fetch('SELECT * FROM ev_events WHERE evevt_event_ID = ' . $_GET['lid']);

$db->enable_jquery_ui();
$db->enable_jquery_ui_dateTimePicker();
if ($_GET['layout'] == 'blank') {
    $db->show_empty_header();
} else {
    $db->show_header();
}
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-success text-center">
                            <strong><?php if ($_GET["eid"] == "") echo "Insert"; else echo "Update"; ?> Event
                                For <?php echo $eventData['evevt_title']; ?></strong>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        //remove seconds
                        $formB->initSettings()
                            ->setFieldName('fld_status')
                            ->setFieldDescription('Status')
                            ->setFieldType('select')
                            ->setInputSelectArrayOptions([
                                'Active' => 'Active',
                                'InActive' => 'InActive'
                            ])
                            ->setInputValue($data['evevt_status'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-3">
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
                        $startDateTime = $db->convertDateToEU($data['evsch_start_date_time'],1,1);
                        $startDateTime = substr($startDateTime,0,strlen($startDateTime)-3);
                        $formB->initSettings()
                            ->setFieldName('fld_start_date_time')
                            ->setFieldDescription('Start')
                            ->setFieldType('input')
                            ->setFieldInputType('dateTime')
                            ->setInputValue($startDateTime)
                            ->buildLabel();
                        ?>
                        <div class="col-sm-3">
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
                        $endDateTime = $db->convertDateToEU($data['evsch_end_date_time'],1,1);
                        $endDateTime = substr($endDateTime,0,strlen($endDateTime)-3);
                        $formB->initSettings()
                            ->setFieldName('fld_end_date_time')
                            ->setFieldDescription('End')
                            ->setFieldType('input')
                            ->setFieldInputType('dateTime')
                            ->setInputValue($endDateTime)
                            ->buildLabel();
                        ?>
                        <div class="col-sm-3">
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
                                   value="<?php if ($_GET["eid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="eid" type="hidden" id="eid" value="<?php echo $_GET["eid"]; ?>">
                            <input name="subAction" type="hidden" id="subAction" value="exit">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('event_schedules.php?layout=<?php echo $_GET['layout'];?>&lid=<?php echo $_GET['lid'];?>')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["eid"] == "") echo "Insert"; else echo "Update"; ?> Event Schedule & Exit"
                                   class="btn btn-primary">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["eid"] == "") echo "Insert"; else echo "Update"; ?> Event Schedule"
                                   class="btn btn-primary" onclick="$('#subAction').val('save');">
                        </div>
                    </div>


                </form>

            </div>
            <div class="col-1"></div>
        </div>
    </div>

<?php
$formValidator->output();
if ($_GET['layout'] == 'blank') {
    $db->show_empty_footer();
} else {
    $db->show_footer();
}
?>