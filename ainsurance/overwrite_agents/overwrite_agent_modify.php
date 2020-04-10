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
$db->admin_title = "Ainsurance Overwrites";

if ($_POST['action'] == 'insert') {
    $db->check_restriction_area('insert');
    $db->working_section = 'Ainsurance Overwrite agent Inserting';

    $db->start_transaction();

    //set the overwrite ID
    $_POST['fld_overwrite_ID'] = $_POST['oid'];

    $db->db_tool_insert_row('ina_overwrite_agents', $_POST, 'fld_', 0, 'inaova_');

    $db->commit_transaction();
    header("Location: overwrite_agents.php?oid=".$_POST['oid']);
    exit();

} else if ($_POST['action'] == 'update') {
    $db->check_restriction_area('update');
    $db->working_section = 'Ainsurance Overwrite agent Update';

    $db->start_transaction();

    unset($_POST['fld_underwriter_ID']);

    $db->db_tool_update_row('ina_overwrite_agents',$_POST, 'inaova_overwrite_agent_ID = '.$_GET['lid'],
        $_GET['lid'], 'fld_', 'execute', 'inaova_');

    $db->commit_transaction();
    header("Location: overwrite_agents.php?oid=".$_POST['oid']);
    exit();
}

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM ina_overwrite_agents WHERE inaova_overwrite_agent_ID = ' . $_GET['lid']);
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();
FormBuilder::buildPageLoader();

?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Overwrite Agent Commissions</b></div>
                    </div>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder([
                            "fieldName" => "fld_underwriter_ID",
                            "fieldDescription" => "Agent/Underwriter",
                            "labelClasses" => "col-sm-3",
                            "fieldType" => "select",
                            "inputValue" => $data['inaova_underwriter_ID'],
                            "inputSelectAddEmptyOption" => true
                        ]);
                        $formB->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->setInputSelectQuery($db->query('SELECT inaund_underwriter_ID as value, usr_name as name
                            FROM ina_underwriters JOIN users ON usr_users_ID = inaund_user_ID WHERE inaund_status = "Active"'))
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
                        $formB = new FormBuilder([
                            "fieldName" => "fld_status",
                            "fieldDescription" => "Status",
                            "labelClasses" => "col-sm-3",
                            "fieldType" => "select",
                            "inputValue" => $data['inaova_status'],
                            "inputSelectAddEmptyOption" => false
                        ]);
                        $formB->buildLabel();
                        ?>
                        <div class="col-3">
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
                        $formB->setFieldName('fld_comm_motor_new')
                            ->setFieldDescription('Motor New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_motor_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_motor_renewal')
                            ->setFieldDescription('Motor Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_motor_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_fire_new')
                            ->setFieldDescription('Fire New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_fire_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_fire_renewal')
                            ->setFieldDescription('Fire Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_fire_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_pa_new')
                            ->setFieldDescription('PA New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_pa_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_pa_renewal')
                            ->setFieldDescription('PA Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_pa_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_el_new')
                            ->setFieldDescription('EL New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_el_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_el_renewal')
                            ->setFieldDescription('EL Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_el_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_pi_new')
                            ->setFieldDescription('PI New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_pi_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_pi_renewal')
                            ->setFieldDescription('PI Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_pi_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_pl_new')
                            ->setFieldDescription('PL New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_pl_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_pl_renewal')
                            ->setFieldDescription('PL Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_pl_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_medical_new')
                            ->setFieldDescription('Medical New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_medical_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_medical_renewal')
                            ->setFieldDescription('Medical Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_medical_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_travel_new')
                            ->setFieldDescription('Travel New Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_travel_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_comm_travel_renewal')
                            ->setFieldDescription('Travel Renewal Policy Commission %')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaova_comm_travel_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'number',
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
                            <input name="oid" type="hidden" id="oid" value="<?php echo $_GET["oid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('overwrite_agents.php?oid=<?php echo $_GET['oid'];?>')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Overwrite Agent"
                                   class="btn btn-primary">
                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_empty_footer();
?>