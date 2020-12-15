<?php

ini_set('memory_limit','2048M');
ini_set('max_execution_time', 120);

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
    $dateFields = explode('/',$_POST['fld_as_at_date']);
    $sql = "
INSERT INTO ccuserparameters (ccusp_auto_serial, ccusp_user_date) 
	ON EXISTING UPDATE
	(SELECT (SELECT a. ccusp_auto_serial FROM ccuserparameters as a) as clo_auto_serial, '".$dateFields[2]."-".$dateFields[1]."-".$dateFields[0]."' as clo_user_date FROM DUMMY);

SELECT ininsurancetypes.inity_insurance_type ,
ininsurancetypes.inity_long_description ,
inpolicies.inpol_policy_number ,

COALESCE(inpvsdt_as_at_date, Date(Now())) as clo_as_at_date,
YEAR(clo_as_at_date) * 100 + MONTH(clo_as_at_date) As clo_as_at_period,
SUM(inpolicies_asat_date.inpvsdt_posted_in_the_year_pr) as clo_written_premium_in_the_year,
SUM(IF inpolicies_asat_date.inpvsdt_status = 'N' THEN inpvsdt_posted_in_prev_years_pr + IF inpvsdt_year < YEAR(clo_as_at_date) THEN inpvsdt_active_phase_pr ELSE 0.0 ENDIF ELSE 0 ENDIF) as clo_written_premium_in_prev_year,
SUM(IF clo_as_at_date < inpolicies_asat_date.inpvsdt_cancellation_expiry_date THEN COALESCE((inpolicies_asat_date.inpvsdt_active_phase_pr) * (CAST(DATEDIFF(Day, clo_as_at_date, inpvsdt_cancellation_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpvsdt_starting_date, inpvsdt_cancellation_expiry_date)+1 as DEC)), 0) ELSE 0.0 ENDIF) as clo_gross_unearned_premium,
SUM(inpvsdt_quota + inpvsdt_1st_surplus + inpvsdt_2nd_surplus + inpvsdt_fac_local + inpvsdt_fac_foreign + IF inpvsdt_status = 'N' THEN -1 * COALESCE((Select SUM(inped_reinsurance_debit_credit * (inped_quota + inped_1st_surplus + inped_2nd_surplus + inped_fac_local + inped_fac_foreign)) from inpolicies as p join inpolicyendorsement as e on p.inpol_policy_serial = e.inped_financial_policy_abs where p.inpol_policy_number = inpolicies_asat_date.inpvsdt_policy_number
and e.inped_financial_policy_abs <> inpolicies_asat_date.inpvsdt_policy_serial
and e.inped_status = '1' AND p.inpol_period_starting_date = inpolicies_asat_date.inpvsdt_period_starting_date AND e.inped_year < YEAR(clo_as_at_date)),0) ELSE 0 ENDIF) as clo_reinsurance_premium_tot,
clo_written_premium_in_the_year + clo_written_premium_in_prev_year - clo_reinsurance_premium_tot As clo_net_written_premium,
SUM(IF clo_as_at_date < inpvsdt_cancellation_expiry_date AND inpvsdt_status = 'N' THEN (inpvsdt_active_phase_pr - (inpvsdt_active_phase_quota + inpvsdt_active_phase_1st_surplus + inpvsdt_active_phase_2nd_surplus + inpvsdt_active_phase_fac_local + inpvsdt_active_phase_fac_foreign)) * (CAST(DATEDIFF(Day, clo_as_at_date, inpvsdt_cancellation_expiry_date) as DEC) / CAST(DATEDIFF(Day, inpvsdt_starting_date, inpvsdt_cancellation_expiry_date)+1 as DEC)) ELSE 0.0 ENDIF) as clo_net_unearned_premium,
'OLD' as clo_old,
SUM(inpvsdt_posted_in_prev_years_pr + IF inpvsdt_status = 'N' AND inpvsdt_year < YEAR(clo_as_at_date) THEN inpvsdt_active_phase_pr ELSE 0.0 ENDIF) as clo_written_premium_in_prev_year_old,
SUM(inpvsdt_quota + inpvsdt_1st_surplus + inpvsdt_2nd_surplus + inpvsdt_fac_local + inpvsdt_fac_foreign) As clo_reinsurance_premium_tot_old,
MAX(inpolicies_asat_date.inpvsdt_policy_serial) as inpvsdt_policy_serial,
LIST(DISTINCT inpolicies_asat_date.inpvsdt_period_starting_date) as inpvsdt_period_starting_date,
LIST(inpolicies_asat_date.inpvsdt_status) as clo_status,
LIST(inpolicies_asat_date.inpvsdt_year) as clo_year,
LIST(inpolicies_asat_date.inpvsdt_process_status) as clo_list_process_status,
IF SUM(IF inpolicies_asat_date.inpvsdt_status = 'N' THEN 1 ELSE 0 ENDIF) > 0 THEN 'ACTIVE' ELSE 'INACTIVE' ENDIF as clo_last_status

INTO #TMPTABLE

FROM
ininsurancetypes
LEFT OUTER JOIN inmajorcodes ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code
LEFT OUTER JOIN inminorcodes ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code,
inpolicies ,
inagents ,
ingeneralagents ,
inpolicies_asat_date
WHERE
( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial )
and ( inagents.inag_agent_serial = inpolicies.inpol_agent_serial )
and ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial )
and ( inpolicies_asat_date.inpvsdt_policy_serial = inpolicies.inpol_policy_serial )
and ((inpvsdt_status = 'N'
and ( inpvsdt_year * 100 + inpvsdt_period <= clo_as_at_period) ) or
(inpvsdt_status = 'A' And ( inpvsdt_year * 100 +inpvsdt_period <= clo_as_at_period ) And ( inpvsdt_year = YEAR(clo_as_at_date))) ) AND 1=1
GROUP BY
inpolicies_asat_date.inpvsdt_as_at_date ,
ininsurancetypes.inity_insurance_type ,
ininsurancetypes.inity_long_description ,
ininsurancetypes.inity_insurance_type_serial ,
inpolicies.inpol_policy_number
HAVING
1=1
ORDER BY
ininsurancetypes.inity_insurance_type ASC,
inpolicies.inpol_policy_number ASC ; 

";

    if ($_POST['fld_report_type'] == 'ELP') {
        $sql .= "
        
        SELECT 
        //clo_as_at_date,
        inpolicies.inpol_policy_serial,
        inpolicies.inpol_policy_number,
        (SELECT MAX(inpia_insured_amount_alt3) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_single_employee_limit,
        (SELECT MAX(inpia_insured_amount_alt1) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_per_event_limit,
        (SELECT MAX(inpia_insured_amount_alt2) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_aggregate_limit,
        (SELECT SUM(inpia_no_of_employees) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_total_employees,
        (SELECT LIST(DISTINCT(inpst_source)) FROM inpolicysituations WHERE inpst_policy_serial = inpolicies.inpol_policy_serial)as clo_type_of_risk,
        clo_written_premium_in_the_year as clo_premium,
        clo_last_status 
        
        FROM
        #TMPTABLE
        JOIN inpolicies ON inpolicies.inpol_policy_serial = inpvsdt_policy_serial
        JOIN ininsurancetypes ON ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial
        
        WHERE
        ininsurancetypes.inity_insurance_type = 'ELP'
        
        UNION
        
        SELECT 
        //clo_as_at_date,
        inpolicies.inpol_policy_serial,
        inpolicies.inpol_policy_number,
        MAX(inpia_insured_amount_alt3) as clo_single_employee_limit,
        MAX(inpia_insured_amount_alt1) as clo_per_event_limit,
        MAX(inpia_insured_amount_alt2) as clo_aggregate_limit,
        SUM(inpia_no_of_employees)as clo_total_employees,
        '6' as clo_type_of_risk,
        (SELECT SUM(inplg_period_premium) FROM inpolicyloadings JOIN inpolicyitems ON inplg_pit_auto_serial = inpit_pit_auto_serial
            JOIN initems ON inpit_item_serial = initm_item_serial WHERE inplg_policy_serial = inpolicies.inpol_policy_serial AND initm_item_flag = '1') as clo_premium,
        clo_last_status
        FROM
        #TMPTABLE
        JOIN inpolicies ON inpolicies.inpol_policy_serial = inpvsdt_policy_serial
        JOIN ininsurancetypes ON ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial
        
        JOIN inpolicyitems ON inpit_policy_serial = inpolicies.inpol_policy_serial
        JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial
        JOIN inreinsurancetreaties ON inrit_reinsurance_treaty_serial = inpit_reinsurance_treaty
        
        WHERE
        ininsurancetypes.inity_insurance_type = 'FMD'
        AND inrit_alternative_insurance_type = 1
        GROUP BY
        clo_as_at_date,
        inpolicies.inpol_policy_serial,
        inpolicies.inpol_policy_number,
        inpit_pit_auto_serial,
        clo_written_premium_in_the_year,
        clo_last_status
        ";
    }
    else if ($_POST['fld_report_type'] == 'HSR') {

        $sql .= "
        
        SELECT
        clo_as_at_date,
        inpolicies.inpol_policy_serial,
        inpolicies.inpol_policy_number,
        inity_insurance_type,
        inpol_starting_date,
        inpol_expiry_date,
        inpol_insured_amount,
        inpst_district,
        
        (IF CHARINDEX(String(',','CPF0001' /* EARTHQUAKE OR VOLCANIC ERUPTION */,','),clo_loading_stat_codes) <> 0  Or CHARINDEX(String(',','CPF0002',','),clo_loading_stat_codes) <> 0 Or CHARINDEX(String(',','CPF0003',','),clo_loading_stat_codes) <> 0 THEN 'Y' ELSE 'N' ENDIF) as clo_quake_cover,
        (SELECT MAX(inpia_excess_rate_7) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial)as clo_quake_excess,
        (SELECT SUM(COALESCE(inpia_numeric_value_17,0) + COALESCE(inpia_numeric_value_5,0) + COALESCE(inpia_numeric_value_18,0) + COALESCE(inpia_numeric_value_3,0) + COALESCE(inpia_numeric_value_16,0)) FROM inpolicyitems JOIN initems ON initm_item_serial = inpit_item_serial JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial AND initm_item_flag = 'B')as clo_building_ia,
        (SELECT SUM(COALESCE(inpia_numeric_value_17,0) + COALESCE(inpia_numeric_value_19,0) + COALESCE(inpia_numeric_value_20,0) + COALESCE(inpia_insured_amount_alt1,0) + COALESCE(inpia_insured_amount_alt2,0) + COALESCE(inpia_insured_amount_alt4,0) + COALESCE(inpia_insured_amount_alt5,0)) FROM inpolicyitems JOIN initems ON initm_item_serial = inpit_item_serial JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpol_policy_serial AND initm_item_flag = 'N')as clo_contents_ia,
        
        clo_written_premium_in_the_year,
        clo_last_status,
        
        STRING(',',(SELECT LIST(DISTINCT inlsc_record_code,',' ORDER BY inlsc_record_code) FROM inpolicyloadings a JOIN inloadings b ON b.inldg_loading_serial = a.inplg_loading_serial JOIN inloadingstatcodes c ON b.inldg_claim_reserve_group = c.inlsc_pcode_serial WHERE a.inplg_policy_serial = inpolicies.inpol_policy_serial /*AND a.inplg_pit_auto_serial = inpolicyitems.inpit_pit_auto_serial*/ AND (c.inlsc_record_type = 'LT' OR c.inlsc_record_code = 'CCX050') ),',') as clo_loading_stat_codes
        FROM
        #TMPTABLE
        JOIN inpolicies ON inpolicies.inpol_policy_serial = inpvsdt_policy_serial
        JOIN inpolicysituations ON inpolicies.inpol_policy_serial = inpolicysituations.inpst_policy_serial
        JOIN inpolicyitems ON inpit_situation_serial = inpst_situation_serial 
        WHERE
        1=1
        AND inity_insurance_type = 'HSR'
        
        GROUP BY
        clo_as_at_date,
        inpolicies.inpol_policy_serial,
        inpolicies.inpol_policy_number,
        inity_insurance_type,
        inpol_starting_date,
        inpol_expiry_date,
        inpol_insured_amount,
        inpst_district,
        clo_quake_cover,
        clo_quake_excess ,      
        clo_building_ia,
        clo_contents_ia,
        clo_written_premium_in_the_year,
        clo_last_status,
        clo_loading_stat_codes
        ";

    }
    else if ($_POST['fld_report_type'] == 'GPA') {

        $sql .= "
            SELECT
            clo_as_at_date,
            inpolicies.inpol_policy_serial,
            inpolicies.inpol_policy_number,
            (SELECT MAX(inpia_numeric_value_8) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_single_employee_limit,
            (SELECT MAX(inpia_numeric_value_7) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_per_event_limit,
            (SELECT MAX(inpia_numeric_value_9) FROM inpolicyitems JOIN inpolicyitemaux ON inpia_pit_auto_serial = inpit_pit_auto_serial WHERE inpit_policy_serial = inpolicies.inpol_policy_serial)as clo_aggregate_limit,
            (SELECT SUM(inpst_integer_value1) FROM inpolicysituations WHERE inpst_policy_serial = inpolicies.inpol_policy_serial)as clo_no_of_employees,
            clo_written_premium_in_the_year as clo_premium_gwp,
            clo_last_status as clo_status
            
            FROM
            #TMPTABLE
            JOIN inpolicies ON inpolicies.inpol_policy_serial = inpvsdt_policy_serial
            WHERE
            1=1
            AND inity_insurance_type = 'GPA'
        ";

    }
    else if ($_POST['fld_report_type'] == 'FMD') {

        $sql .= "
            SELECT
            clo_as_at_date,
            inpolicies.inpol_policy_serial,
            inpolicies.inpol_policy_number,
            clo_last_status as clo_status
            
            FROM
            #TMPTABLE
            JOIN inpolicies ON inpolicies.inpol_policy_serial = inpvsdt_policy_serial
            WHERE
            1=1
            AND inity_insurance_type = 'FMD'
        ";

    }
    else if ($_POST['fld_report_type'] == 'PLI'){
        $sql .= "
        
        SELECT
        altIns.inity_insurance_type as alt_insurance_type,
        inpol_policy_number,
        LIST(DISTINCT(clo_last_status))as clo_last_statuss
        FROM
        #TMPTABLE
        JOIN inpolicyitems ON inpit_policy_serial = inpvsdt_policy_serial
        JOIN inreinsurancetreaties ON inpit_reinsurance_treaty = inrit_reinsurance_treaty_serial
        JOIN ininsurancetypes as altIns ON altIns.inity_insurance_type_serial = inrit_alternative_insurance_type
        WHERE
        altIns.inity_insurance_type = 'PLI'
        GROUP BY
        alt_insurance_type,
        inpol_policy_number
        //,clo_last_status
        ORDER BY inpol_policy_number ASC
        
        ";
    }


    //echo $sql; //exit();
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

    //echo $output;
    $db->export_file_for_download($output,$_POST['fld_report_type'].'_as_at_'.$dateFields[0]."-".$dateFields[1]."-".$dateFields[2].".txt");
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
                        <div class="col-12 alert alert-primary text-center"><b>Reports - Production - Quarter Export</b></div>
                    </div>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_report_type')
                            ->setFieldDescription('Report Type')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('select')
                            ->setInputValue($_POST['fld_report_type'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->setInputSelectAddEmptyOption(true);
                            $formB->setInputSelectArrayOptions([
                                'ELP' => 'ELP',
                                'HSR' => 'HSR',
                                'GPA' => 'GPA',
                                'FMD' => 'FMD',
                                'PLI' => 'PLI'
                            ]);

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
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_as_at_date')
                            ->setFieldDescription('As At Date')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($_POST['fld_as_at_date'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['fld_as_at_date'],
                                    'required' => true,
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