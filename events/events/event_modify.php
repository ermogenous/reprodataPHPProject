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
$db->admin_title = "Event Events Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Event Events Insert';

    $_POST['fld_starting_date_time'] = $db->convertDateToUS($_POST['fld_starting_date_time'],1,1);
    $_POST['fld_end_date_time'] = $db->convertDateToUS($_POST['fld_end_date_time'],1,1);

    $db->db_tool_insert_row('ev_events', $_POST, 'fld_', 0, 'evevt_');
    header("Location: events.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Event Events Update';

    $_POST['fld_starting_date_time'] = $db->convertDateToUS($_POST['fld_starting_date_time'],1,1);
    $_POST['fld_end_date_time'] = $db->convertDateToUS($_POST['fld_end_date_time'],1,1);

    $db->db_tool_update_row('ev_events', $_POST, "`evevt_event_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'evevt_');
    header("Location: events.php");
    exit();

}

$db->enable_jquery_ui();
$db->enable_jquery_ui_dateTimePicker();
$db->show_header();


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-2');

if ($_GET['lid'] != ''){
    $data = $db->query_fetch('SELECT * FROM ev_events WHERE evevt_event_ID = '.$_GET['lid']);
}
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-success text-center"><strong><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Event</strong></div>
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

                        <?php
                        //remove seconds
                        $dateTime = $db->convertDateToEU($data['evevt_starting_date_time'],1,1);
                        $dateTime = substr($dateTime,0,strlen($dateTime) -3);
                        $formB->initSettings()
                            ->setFieldName('fld_starting_date_time')
                            ->setFieldDescription('Start Date/Time')
                            ->setFieldType('input')
                            ->setFieldInputType('dateTime')
                            ->setInputValue($dateTime)
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'dateTime',
                                    'enableDatePicker' => true,
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
                            ->setFieldDescription('Room')
                            ->setFieldType('select')
                            ->setInputValue($data['evevt_room_ID'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
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

                        <?php
                        //remove seconds
                        $dateTime = $db->convertDateToEU($data['evevt_end_date_time'],1,1);
                        $dateTime = substr($dateTime,0,strlen($dateTime) -3);
                        $formB->initSettings()
                            ->setFieldName('fld_end_date_time')
                            ->setFieldDescription('End Date/Time')
                            ->setFieldType('input')
                            ->setFieldInputType('dateTime')
                            ->setInputValue($dateTime)
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'dateTime',
                                    'enableDatePicker' => true,
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
                        <div class="col-sm-4">
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
                        $formB->initSettings()
                            ->setFieldName('fld_description')
                            ->setFieldDescription('Description')
                            ->setFieldType('textarea')
                            ->setInputValue($data['evevt_description'])
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
                                   onclick="window.location.assign('events.php')">
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