<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 29/7/2019
 * Time: 10:23 ΠΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "Insurance Underwriters Modify";

if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Update Insurance underwriter Company';
    $db->start_transaction();

    $db->db_tool_update_row('ina_underwriter_companies', $_POST, "`inaunc_underwriter_company_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'inaunc_');

    $db->commit_transaction();
    header("Location: underwriter_companies.php?lid=" . $_POST['uid']);
    exit();

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("
      SELECT * FROM `ina_underwriter_companies` 
      JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaunc_insurance_company_ID
      JOIN ina_underwriters ON inaund_underwriter_ID = inaunc_underwriter_ID
      JOIN users ON usr_users_ID = inaund_user_ID
      WHERE inaunc_underwriter_company_ID = " . $_GET["lid"]
    );

    //if advanced accounts and underwriter is sub agent get the commissions from the insurance companies
    //to check that the commissions defined below is not more than the top commissions
    $advancedAccounts = $db->get_setting('ac_advanced_accounts_enable');
    if ($advancedAccounts == 1) {

        //if subagent and office top
        if ($data['inaund_subagent_ID'] == -1) {
            $compCommData = $db->query_fetch('
            SELECT * FROM ina_insurance_companies WHERE inainc_insurance_company_ID = ' . $data['inaunc_insurance_company_ID']
            );
            $prevAgentCommNew['motor'] = $compCommData['inainc_commission_motor_new'];
            $prevAgentCommNew['fire'] = $compCommData['inainc_commission_fire_new'];
            $prevAgentCommNew['pa'] = $compCommData['inainc_commission_pa_new'];
            $prevAgentCommNew['el'] = $compCommData['inainc_commission_el_new'];
            $prevAgentCommNew['pi'] = $compCommData['inainc_commission_pi_new'];
            $prevAgentCommNew['pl'] = $compCommData['inainc_commission_pl_new'];
            $prevAgentCommNew['medical'] = $compCommData['inainc_commission_medical_new'];
            $prevAgentCommNew['travel'] = $compCommData['inainc_commission_travel_new'];

            $prevAgentCommRenewal['motor'] = $compCommData['inainc_commission_motor_renewal'];
            $prevAgentCommRenewal['fire'] = $compCommData['inainc_commission_fire_renewal'];
            $prevAgentCommRenewal['pa'] = $compCommData['inainc_commission_pa_renewal'];
            $prevAgentCommRenewal['el'] = $compCommData['inainc_commission_el_renewal'];
            $prevAgentCommRenewal['pi'] = $compCommData['inainc_commission_pi_renewal'];
            $prevAgentCommRenewal['pl'] = $compCommData['inainc_commission_pl_renewal'];
            $prevAgentCommRenewal['medical'] = $compCommData['inainc_commission_medical_renewal'];
            $prevAgentCommRenewal['travel'] = $compCommData['inainc_commission_travel_renewal'];
        } //this underwriter is subagent of another subagent
        else if ($data['inaund_subagent_ID'] > 0) {
            $parentUnderwriter = $db->query_fetch('SELECT * FROM ina_underwriter_companies 
            WHERE inaunc_underwriter_ID = ' . $data['inaund_subagent_ID'] . " 
            AND inaunc_insurance_company_ID = " . $data['inaunc_insurance_company_ID']);
            $prevAgentCommNew['motor'] = $parentUnderwriter['inaunc_commission_motor_new'];
            $prevAgentCommNew['fire'] = $parentUnderwriter['inaunc_commission_fire_new'];
            $prevAgentCommNew['pa'] = $parentUnderwriter['inaunc_commission_pa_new'];
            $prevAgentCommNew['el'] = $parentUnderwriter['inaunc_commission_el_new'];
            $prevAgentCommNew['pi'] = $parentUnderwriter['inaunc_commission_pi_new'];
            $prevAgentCommNew['pl'] = $parentUnderwriter['inaunc_commission_pl_new'];
            $prevAgentCommNew['medical'] = $parentUnderwriter['inaunc_commission_medical_new'];
            $prevAgentCommNew['travel'] = $parentUnderwriter['inaunc_commission_travel_new'];

            $prevAgentCommRenewal['motor'] = $parentUnderwriter['inaunc_commission_motor_renewal'];
            $prevAgentCommRenewal['fire'] = $parentUnderwriter['inaunc_commission_fire_renewal'];
            $prevAgentCommRenewal['pa'] = $parentUnderwriter['inaunc_commission_pa_renewal'];
            $prevAgentCommRenewal['el'] = $parentUnderwriter['inaunc_commission_el_renewal'];
            $prevAgentCommRenewal['pi'] = $parentUnderwriter['inaunc_commission_pi_renewal'];
            $prevAgentCommRenewal['pl'] = $parentUnderwriter['inaunc_commission_pl_renewal'];
            $prevAgentCommRenewal['medical'] = $parentUnderwriter['inaunc_commission_medical_renewal'];
            $prevAgentCommRenewal['travel'] = $parentUnderwriter['inaunc_commission_travel_renewal'];
        }

    }

}

$db->show_header();


include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();

include('../../scripts/form_builder_class.php');
FormBuilder::buildPageLoader();
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                                Underwriter Company</b>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-4">Underwriter</div>
                        <div class="col-sm-6 text-left">
                            <?php echo $data['usr_name']; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">Company</div>
                        <div class="col-sm-6">
                            <?php echo $data['inainc_name']; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_calculation')
                            ->setFieldDescription('Commission Calculation')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('select')
                            ->setInputValue($data['inaunc_commission_calculation'])
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->setInputSelectArrayOptions([
                                    'commNetPrem' => 'Commission On Net Premium',
                                'commNetPremFees' => 'Commission On Net Premium + Fees'
                            ])
                                ->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>

                    </div>

                    <div class="form-group row">

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_motor_new')
                            ->setFieldDescription('Commission Motor New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_motor_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>

                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_motor"
                                       id="comp_commission_motor"
                                       value="<?php echo $prevAgentCommNew['motor']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_motor",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Motor commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_motor_new").val()*1) > $("#comp_commission_motor").val()'
                                ]);
                            }
                            ?>
                        </div>
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_motor_renewal')
                            ->setFieldDescription('Comm. Motor Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_motor_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_motor_renewal"
                                       id="comp_commission_motor_renewal"
                                       value="<?php echo $prevAgentCommRenewal['motor']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_motor_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Motor commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_motor_renewal").val()*1) > $("#comp_commission_motor_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>


                    <div class="form-group row">

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_fire_new')
                            ->setFieldDescription('Commission Fire New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_fire_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_fire"
                                       id="comp_commission_fire"
                                       value="<?php echo $prevAgentCommNew['fire']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_fire",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Fire commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_fire_new").val()*1) > $("#comp_commission_fire").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_fire_renewal')
                            ->setFieldDescription('Comm. Fire Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_fire_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_fire_renewal"
                                       id="comp_commission_fire_renewal"
                                       value="<?php echo $prevAgentCommRenewal['fire']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_fire_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Fire commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_fire_renewal").val()*1) > $("#comp_commission_fire_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_pa_new')
                            ->setFieldDescription('Commission PA New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_pa_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>

                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_pa"
                                       id="comp_commission_pa"
                                       value="<?php echo $prevAgentCommNew['pa']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pa",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PA commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pa_new").val()*1) > $("#comp_commission_pa").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_pa_renewal')
                            ->setFieldDescription('Comm. PA Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_pa_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_pa_renewal"
                                       id="comp_commission_pa_renewal"
                                       value="<?php echo $prevAgentCommRenewal['pa']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pa_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PA commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pa_renewal").val()*1) > $("#comp_commission_pa_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_el_new')
                            ->setFieldDescription('Commission EL New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_el_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>

                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_el"
                                       id="comp_commission_el"
                                       value="<?php echo $prevAgentCommNew['el']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_el",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'EL commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_el_new").val()*1) > $("#comp_commission_el").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_el_renewal')
                            ->setFieldDescription('Comm. EL Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_el_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_el_renewal"
                                       id="comp_commission_el_renewal"
                                       value="<?php echo $prevAgentCommRenewal['el']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_el_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'EL commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_el_renewal").val()*1) > $("#comp_commission_el_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_pi_new')
                            ->setFieldDescription('Commission PI New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_pi_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_pi"
                                       id="comp_commission_pi"
                                       value="<?php echo $prevAgentCommNew['pi']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pi",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PI commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pi_new").val()*1) > $("#comp_commission_pi").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_pi_renewal')
                            ->setFieldDescription('Comm. PI Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_pi_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_pi_renewal"
                                       id="comp_commission_pi_renewal"
                                       value="<?php echo $prevAgentCommRenewal['pi']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pi_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PI commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pi_renewal").val()*1) > $("#comp_commission_pi_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_pl_new')
                            ->setFieldDescription('Commission PL New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_pl_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_pl"
                                       id="comp_commission_pl"
                                       value="<?php echo $prevAgentCommNew['pl']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pl",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PL commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pl_new").val()*1) > $("#comp_commission_pl").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_pl_renewal')
                            ->setFieldDescription('Comm. PL Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_pl_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_pl_renewal"
                                       id="comp_commission_pl_renewal"
                                       value="<?php echo $prevAgentCommRenewal['pl']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pl_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PL commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pl_renewal").val()*1) > $("#comp_commission_pl_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_medical_new')
                            ->setFieldDescription('Commission Medical New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_medical_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_medical"
                                       id="comp_commission_medical"
                                       value="<?php echo $prevAgentCommNew['medical']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_medical",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Medical commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_medical_new").val()*1) > $("#comp_commission_medical").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_medical_renewal')
                            ->setFieldDescription('Comm. Medical Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_medical_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_medical_renewal"
                                       id="comp_commission_medical_renewal"
                                       value="<?php echo $prevAgentCommRenewal['medical']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pl_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Medical commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_medical_renewal").val()*1) > $("#comp_commission_medical_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_travel_new')
                            ->setFieldDescription('Commission Travel New')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_travel_new'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_travel"
                                       id="comp_commission_travel"
                                       value="<?php echo $prevAgentCommNew['travel']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_travel",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Travel commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_travel_new").val()*1) > $("#comp_commission_travel").val()'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_commission_travel_renewal')
                            ->setFieldDescription('Comm. Travel Renewal')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($data['inaunc_commission_travel_renewal'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField([
                                "fieldName" => $formB->fieldName,
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1) { ?>
                                <input type="text" class="form-control" name="comp_commission_travel_renewal"
                                       id="comp_commission_travel_renewal"
                                       value="<?php echo $prevAgentCommRenewal['travel']; ?>" disabled>
                                <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_travel_renewal",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Travel commission Renewal cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_travel_renewal").val()*1) > $("#comp_commission_travel_renewal").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>


                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="update">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="uid" type="hidden" id="uid"
                                   value="<?php echo $data['inaunc_underwriter_ID']; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('underwriter_companies.php?lid=<?php echo $data['inaunc_underwriter_ID']; ?>')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Update Underwriter Company"
                                   class="btn btn-secondary">
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