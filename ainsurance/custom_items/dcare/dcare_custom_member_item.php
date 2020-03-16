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
            ->setFieldName('fld_char_1')
            ->setFieldDescription('Insured Type')
            ->setFieldType('select')
            ->setInputValue($data['inapit_char_1'])
            ->setInputSelectArrayOptions([
                'Individual' => 'Individual',
                'Group' => 'Group'
            ])
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

        <?php
        $formB->initSettings()
            ->setFieldName('fld_char_2')
            ->setFieldDescription('Coverage Type')
            ->setFieldType('select')
            ->setInputValue($data['inapit_char_2'])
            ->setInputSelectArrayOptions([
                'Medical Cover on Full Application' => 'Medical Cover on Full Application',
                'Medical Cover on Partial Application' => 'Medical Cover on Partial Application',
                'Medical Cover on Continuing Personal Medical Exclusions' => 'Medical Cover on Continuing Personal Medical Exclusions',
                'On Medical History Disregarded' => 'On Medical History Disregarded',
            ])
            ->setInputSelectAddEmptyOption(true)
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

    <div class="form-group row">
        <?php
        $formB->initSettings()
            ->setFieldName('fld_char_3')
            ->setFieldDescription(' Area of cover')
            ->setFieldType('select')
            ->setInputValue($data['inapit_char_3'])
            ->setInputSelectArrayOptions([
                'Worldwide' => 'Worldwide',
                'Worldwide excluding USA and others' => 'Worldwide excluding USA and others'
            ])
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
            ->setFieldType('select')
            ->setInputValue($data['inapit_excess'])
            ->setInputSelectArrayOptions([
                '0' => '0',
                '150' => '150',
                '350' => '350',
                '650' => '650',
                '1700' => '1700',
                '3500' => '3500',
                '6500' => '6500'
            ])
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
    $return['windowHeight'] = 450;

    return $return;
}
?>