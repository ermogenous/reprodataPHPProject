<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/12/2019
 * Time: 10:40 π.μ.
 */

function insuranceCustomItem(){
    global $db,$formValidator,$data,$formB,$policy;
    ?>

    <div class="form-group row">
        <?php
        $formB->initSettings()
            ->setFieldName('fld_mb_full_name')
            ->setFieldDescription('Full Name')
            ->setFieldType('input')
            ->setInputValue($data['inapit_mb_full_name'])
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
        $formB->initSettings()
            ->setFieldName('fld_mb_birth_date')
            ->setFieldDescription('Birthdate')
            ->setFieldType('input')
            ->setFieldInputType('date')
            ->setInputValue($db->convertDateToEU($data['inapit_mb_birth_date']))
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $formB->buildInput();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'date',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>

        </div>
    </div>

    <div class="form-group row">
        <?php
        $formB->initSettings()
            ->setFieldName('fld_mb_nationality_ID')
            ->setFieldDescription('Nationality')
            ->setFieldType('select')
            ->setInputValue($data['inapit_mb_nationality_ID'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $inputSelectQuery = $db->query('SELECT cde_value as name, cde_code_ID as value FROM codes WHERE cde_type = "Countries" ORDER BY cde_value');
            $formB->setInputSelectQuery($inputSelectQuery)
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
        $formB->initSettings()
            ->setFieldName('fld_package_ID')
            ->setFieldDescription('Package')
            ->setFieldType('select')
            ->setInputValue($data['inapit_package_ID'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
            <?php
            $sql = "SELECT inaincpk_insurance_company_package_ID as value, inaincpk_name as name FROM ina_insurance_company_packages WHERE
                              inaincpk_insurance_company_ID = " . $policy->policyData['inapol_insurance_company_ID'] . " 
                              AND inaincpk_type = '" . $policy->policyData['inapol_type_code'] . "' 
                              AND inaincpk_status = 'Active'";
            $inputSelectQuery = $db->query($sql);;
            $formB->setInputSelectQuery($inputSelectQuery)
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
            ->setFieldName('fld_premium')
            ->setFieldDescription('Member Premium')
            ->setFieldType('input')
            ->setFieldInputType('number')
            ->setInputValue($data['inapit_premium'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
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
        $formB->initSettings()
            ->setFieldName('fld_excess')
            ->setFieldDescription('Excess')
            ->setFieldType('input')
            ->setFieldInputType('number')
            ->setInputValue($data['inapit_excess'])
            ->buildLabel();
        ?>
        <div class="col-sm-3">
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

<?php
}
?>