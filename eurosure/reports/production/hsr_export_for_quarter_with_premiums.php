<?php
include("../../../include/main.php");
$db = new Main();
include("../../lib/odbccon.php");
include("../../lib/production.php");

include("../../lib/production_class.php");
include("../../lib/export_data.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
$sybase = new ODBCCON();


if ($_POST['action'] == 'execute'){


    //extraFields
    $extraSelect = '';
    $extraGroup = '';
    if ($_POST['fld_add_agent_field'] == 1){
        $extraSelect = ',inag_agent_code';
        $extraGroup = ',inag_agent_code';
    }
    if ($_POST['fld_add_hsr_items'] == 1){
        $extraSelect .= PHP_EOL.",SUM(IF initm_item_flag = 'B' then fn_get_policyitem_premium(inpit_pit_auto_serial,'upToCurrent') else 0 endif) as clo_building_premium";
        $extraSelect .= PHP_EOL.",SUM(IF initm_item_flag = 'N' then fn_get_policyitem_premium(inpit_pit_auto_serial,'upToCurrent') else 0 endif) as clo_contents_premium";
        $extraSelect .= PHP_EOL.",SUM(IF initm_item_flag = '4' then fn_get_policyitem_premium(inpit_pit_auto_serial,'upToCurrent') else 0 endif) as clo_pl_premium";
        $extraSelect .= PHP_EOL.",SUM(IF initm_item_flag = '5' then fn_get_policyitem_premium(inpit_pit_auto_serial,'upToCurrent') else 0 endif) as clo_death_of_the_insured_premium";
    }

    $sql = "
    SELECT 
inpol_policy_number ,
(incl_first_name + ' ' + incl_long_description) as clo_client_name,
inity_insurance_type,
inpol_starting_date,
inpol_expiry_date,
inpol_insured_amount,
inpst_district,
(IF CHARINDEX(String(',','CPF0001' /* EARTHQUAKE OR VOLCANIC ERUPTION */,','),clo_loading_stat_codes) <> 0  Or CHARINDEX(String(',','CPF0002',','),clo_loading_stat_codes) <> 0 Or CHARINDEX(String(',','CPF0003',','),clo_loading_stat_codes) <> 0 THEN 'Y' ELSE 'N' ENDIF) as clo_quake_cover,
(SELECT MAX(inpia_excess_rate_7) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_quake_excess,
inped_premium,
inped_phase_status,
inped_process_status,
(SELECT SUM(inpit_insured_amount) FROM inpolicyitems JOIN initems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial AND initm_item_flag = 'B')as clo_building_ia,
(SELECT SUM(inpit_insured_amount) FROM inpolicyitems JOIN initems ON initm_item_serial = inpit_item_serial WHERE inpit_policy_serial = inpol_policy_serial AND initm_item_flag = 'N')as clo_contents_ia,
STRING(',',(SELECT LIST(DISTINCT inlsc_record_code,',' ORDER BY inlsc_record_code) FROM inpolicyloadings a JOIN inloadings b ON b.inldg_loading_serial = a.inplg_loading_serial JOIN inloadingstatcodes c ON b.inldg_claim_reserve_group = c.inlsc_pcode_serial WHERE a.inplg_policy_serial = inpolicies.inpol_policy_serial /*AND a.inplg_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial*/ AND (c.inlsc_record_type = 'LT' OR c.inlsc_record_code = 'CCX050') ),',') as clo_loading_stat_codes
".$extraSelect."
FROM
inpolicies
LEFT OUTER JOIN inpolicyendorsement ON inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial AND inpolicies.inpol_last_endorsement_serial = inpolicyendorsement.inped_endorsement_serial, 
inpolicyitems
LEFT OUTER JOIN inpolicysituations ON inpolicyitems.inpit_situation_serial = inpolicysituations.inpst_situation_serial
LEFT OUTER JOIN inreinsurancetreaties ON inpolicyitems.inpit_reinsurance_treaty = inreinsurancetreaties.inrit_reinsurance_treaty_serial

,inagents ,
ingeneralagents ,
inclients ,
ininsurancetypes ,
initems
WHERE
( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial )
and ( inpolicies.inpol_client_serial = inclients.incl_client_serial )
and ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial )
and ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial )
and ( inpolicyitems.inpit_policy_serial = inpolicies.inpol_policy_serial )
and ( initems.initm_item_serial = inpolicyitems.inpit_item_serial ) 
AND 1=1 
AND COALESCE(inped_process_status, inpol_process_status) IN ('N','R','E','D') 
AND COALESCE(inped_phase_status, inpol_status) IN ('A','N') 
AND COALESCE(inped_status, CASE inpol_status WHEN 'Q' THEN '2' WHEN 'D' THEN '3' END, '?') IN ('1') 
AND inity_insurance_form IN ('M','O','L','R','P','E','T') 

AND inped_year >= ".$_POST['fld_year_from']."
AND inped_year <= ".$_POST['fld_year_to']."
AND inped_period >= ".$_POST['fld_period_from']."
AND inped_period >= ".$_POST['fld_period_to']."

/*
AND '".$dateFields[2]."/".$dateFields[1]."/".$dateFields[0]."' BETWEEN inpol_starting_date AND 
COALESCE(IF (SELECT a.inped_year * 100 + a.inped_period FROM inpolicyendorsement a 
    WHERE a.inped_endorsement_serial = inpol_last_cancellation_endorsement_serial) 
    <= YEAR('".$dateFields[2]."/".$dateFields[1]."/".$dateFields[0]."') * 100 + MONTH('".$dateFields[2]."/".$dateFields[1]."/".$dateFields[0]."') THEN inpol_cancellation_date ELSE NULL ENDIF, inpol_expiry_date)
*/     
AND inity_insurance_type IN ('HSR','FPR')

GROUP BY
inpol_policy_number ,
inpol_policy_serial,
inity_insurance_type,
inpol_starting_date,
inpol_expiry_date,
inpol_insured_amount,
inpst_district,
inped_premium,
inped_phase_status,
inped_process_status,
incl_first_name,
incl_long_description
".$extraGroup."

ORDER BY
inpol_policy_number ASC 
    ";
    //echo $sql; exit();
    $result = $sybase->query($sql);
    $line = 0;
    while ($row = $sybase->fetch_assoc($result)){
        $line++;
        if ($line == 1){
            foreach($row as $name => $value){
                if ($name != 'clo_loading_stat_codes') {
                    $output .= "'".$name . "',";
                }
            }
            $output = $db->remove_last_char($output);
            $output .= PHP_EOL;
        }
        foreach($row as $name => $value){
            if ($name != 'clo_loading_stat_codes') {
                $output .= "'".$value . "',";
            }
        }
        $output .= PHP_EOL;
    }
    $db->export_file_for_download($output,'hsr_as_at_'.$_POST['fld_period_from']."-".$_POST['fld_year_from']
        ."_to_".$_POST['fld_period_to']."-".$_POST['fld_year_to'].".txt");
    exit();
}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Reports - Production - Quarter Export - HSR Export Policies</b></div>
                    </div>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_year_from')
                            ->setFieldDescription('Year From')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($_POST['fld_year_from'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
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
                        $formB->setFieldName('fld_period_from')
                            ->setFieldDescription('Period From')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($_POST['fld_period_from'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
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
                        $formB->setFieldName('fld_year_to')
                            ->setFieldDescription('Year To')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($_POST['fld_year_to'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
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
                        $formB->setFieldName('fld_period_to')
                            ->setFieldDescription('Period To')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($_POST['fld_period_to'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
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
                        $formB->setFieldName('fld_add_agent_field')
                            ->setFieldDescription('Add Agent Code Field')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('checkbox')
                            ->setInputCheckBoxValue(1)
                            ->setInputValue($_POST['fld_add_agent_field'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'required' => false,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_add_hsr_items')
                            ->setFieldDescription('Add Fields for items breakdown(HSR)')
                            ->setLabelClasses('col-sm-3')
                            ->setFieldType('checkbox')
                            ->setInputCheckBoxValue(1)
                            ->setInputValue($_POST['fld_add_hsr_items'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'required' => false,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action" value="execute">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('index.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Submit Form"
                                   class="btn btn-primary">
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
