<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/12/2019
 * Time: 10:28 π.μ.
 */

include("../../include/main.php");
include('../../scripts/form_builder_class.php');
include('../../scripts/form_validator_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Issue Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'AInsurance Issue Insert';


    $db->db_tool_insert_row('ina_issuing', $_POST, 'fld_', 0, 'inaiss_');
    header("Location: issuing.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Issue Update';


    $db->db_tool_update_row('ina_issuing', $_POST, "`inaiss_issue_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'inaiss_');
    header("Location: issuing.php");
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

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM ina_issuing WHERE inaiss_issue_ID = ' . $_GET['lid']);
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
                            <strong><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Policy
                                Issuing</strong></div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_name')
                            ->setFieldDescription('Name')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_name'])
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_insurance_company_ID')
                            ->setFieldDescription('Insurance Company')
                            ->setFieldType('select')
                            ->setInputValue($data['inaiss_insurance_company_ID'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $locResult = $db->query('
                              SELECT 
                                inainc_name as name,
                                inainc_insurance_company_ID as value
                                FROM ina_insurance_companies ORDER BY inainc_name ASC');
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_insurance_type')
                            ->setFieldDescription('Insurance Type')
                            ->setFieldType('select')
                            ->setInputValue($data['inaiss_insurance_type'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $formB->setInputSelectArrayOptions([
                                'Motor' => 'Motor',
                                'Fire' => 'Fire',
                                'PA' => 'PA',
                                'EL' => 'EL',
                                'PI' => 'PI',
                                'PL' => 'PL',
                                'Medical' => 'Medical',
                                'Travel' => 'Travel'
                            ])
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_issue_number')
                            ->setFieldDescription('Issue Policy Number')
                            ->setFieldType('select')
                            ->setInputValue($data['inaiss_issue_number'])
                            ->setInputSelectArrayOptions([
                                    '1' => 'Yes',
                                    '0' => 'No'
                            ])
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_number_prefix')
                            ->setFieldDescription('Policy Number Prefix')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_number_prefix'])
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_number_leading_zeros')
                            ->setFieldDescription('Policy Number Leading Zeros')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_number_leading_zeros'])
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_number_last_used')
                            ->setFieldDescription('Policy Number Last Used')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_number_last_used'])
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_certificate_issue_file')
                            ->setFieldDescription('Issue Certificate File')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_certificate_issue_file'])
                            ->setLabelTitle('When specified Certificate issue will be enabled. Put the file under ainsurance/documents folder. Use function ainsuranceSchedule($policyObject) @return html. Leave empty to ignore')
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_schedule_issue_file')
                            ->setFieldDescription('Issue Schedule File')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_schedule_issue_file'])
                            ->setLabelTitle('When specified Schedule issue will be enabled. Put the file under ainsurance/documents folder. Use function ainsuranceSchedule($policyObject) @return html. Leave empty to ignore')
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_item_custom_input_file')
                            ->setFieldDescription('Custom Item File')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_item_custom_input_file'])
                            ->setLabelTitle('This will replace the items form. Under ainsurance/custom_items folder put the custom file and enter here its filename. Leave empty to use defaults')
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
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

                    <div class="form-group row">
                        <?php
                        $formB->initSettings()
                            ->setFieldName('fld_item_custom_view_file')
                            ->setFieldDescription('Custom Item File View')
                            ->setFieldType('input')
                            ->setInputValue($data['inaiss_item_custom_view_file'])
                            ->setLabelTitle('This will replace the items List table. Under ainsurance/custom_items folder put the custom file and enter here its filename. Leave empty to use defaults')
                            ->buildLabel();
                        ?>
                        <div class="col-sm-4">
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


                    <div class="col-12" style="height: 25px;"></div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('issuing.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Policy Issuing"
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