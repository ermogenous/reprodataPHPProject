<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 28/6/2021
 * Time: 10:37 π.μ.
 */

include("../../include/main.php");
include("../lib/odbccon.php");
include("export_class.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Export - Turnkey";

$sybase = new ODBCCON();


$export = new synExport();

/**
 * Specifics:
 * Always Start with a 3 char prefix and always different so every field will not overwrite another. use 01- or 001
 * column name
 * [VAL]123 This will always return 123
 * [.] this will return more than one columns/values. For example inpol_policy_number[.][VAL]num[.]inpol_policy_serial
 */

$export->defineClients([
    '01-[VAL]I' => 'iaicl_synthesis_in_out',
    '02-[VAL]IMPORT' => 'iaicl_row_created_by',
    '03-[VAL]IMPORT' => 'iaicl_row_last_edit_by',
    '04-[VAL]O' => 'iaicl_row_status',
    '05-[VAL]IMPORT' => 'iaicl_row_status_last_update_by',
    '06-[VAL]EUROSURE[.]incl_client_code' => 'iaicl_client_code',
    '07-[VAL]1-001' => 'iaicl_agent_code',
    '08-incl_account_type' => 'iaicl_account_type',
    '09-incl_salutation' => 'iaicl_salutation',
    '10-incl_first_name' => 'iaicl_first_name',
    '11-incl_long_description' => 'iaicl_long_description',
    '12-incl_identity_card' => 'iaicl_identity_card',
    '13-[VAL]EUR' => 'iaicl_currency_code',
    '14-[VAL]ACEUROSURE[.]incl_client_code' => 'iaicl_account_code'
]);

$export->definePolicies([
        '01-[VAL]I' => 'iaipol_synthesis_in_out',
        '02-[VAL]IMPORT' => 'iaipol_row_created_by',
        '03-[VAL]IMPORT' => 'iaipol_row_last_edit_by',
        '04-[VAL]O' => 'iaipol_row_status',
        '05-[VAL]IMPORT' => 'iaipol_row_status_last_update_by',
        '06-[VAL]REF[.]inpol_policy_number' => 'iaipol_policy_import_reference',
        '07-inpol_policy_number' => 'iaipol_policy_number',
        '08-[VAL]281005' => 'iaipol_inscomp_code',
        '09-[VAL]1-001' => 'iaipol_agent_code',
        '10-[VAL]EUROSURE[.]incl_client_code' => 'iaipol_client_code',
        '11-inpol_insurance_type_serial' => 'iaipol_product_code',
        '12-[VAL]O' => 'iaipol_status_flag',
        '13-inpol_process_status' => 'iaipol_process_status',
        '14-[VAL]EUR' => 'iaipol_currency_code',
        '15-[VAL]1' => 'iaipol_currency_rate',
        '16-[VAL]EUR' => 'iaipol_origin_currency_code',
        '17-[VAL]1' => 'iaipol_origin_currency_rate',
        '18-[VAL]CYP' => 'iaipol_alpha_key1',
        '19-inpol_period_starting_date' => 'iaipol_period_starting_date',
        '20-inpol_starting_date' => 'iaipol_phase_starting_date',
        '21-inpol_policy_period' => 'iaipol_policy_period',
        '22-inpol_policy_year' => 'iaipol_policy_year',
        '23-inpol_expiry_date' => 'iaipol_expiry_date',
        '24-inpol_policy_serial' => 'iaipol_premium',
        '25-inpol_policy_serial' => 'iaipol_fees',
        '26-inpol_policy_serial' => 'iaipol_client_value',
        '27-inpol_policy_serial' => 'iaipol_comm_perc_ins_comp01',
        '28-inpol_policy_serial' => 'iaipol_comm_value_ins_comp01',
        '29-inpol_policy_serial' => 'iaipol_agency_fee',
        '30-inpol_policy_serial' => 'iaipol_ins_comp_value',
        '31-inpol_policy_serial' => 'iaipol_agency_collect',
        '32-inpol_policy_serial' => 'iaipol_embedded_commission',
        '33-inpol_policy_serial' => 'iaipol_ins_comp_embedded_commission',
        '34-inpol_policy_serial' => 'iaipol_reins_embedded_commission',
        '35-inpol_policy_serial' => 'iaipol_process_retention',
        '36-inpol_policy_serial' => 'iaipol_original_module',
        '37-inpol_policy_serial' => 'iaipol_original_table',
        '38-inpol_policy_serial' => 'iaipol_original_auto_serial',
        '39-inpol_policy_serial' => 'iaipol_dummy_retention_reinsurer',
    ]);

$export->defineSituations([
        'inpol_policy_serial' => 'iaipst_policy_import_reference',
        'inpst_situation_code' => 'iaipst_situation_code'
    ]);

$export->definePolicyItems([
    'inpol_policy_serial' => 'iaipit_policy_import_reference',
    'inpst_situation_code' => 'iaipit_situation_code',
    'initm_item_code' => 'iaipit_item_code'
]);

$sql = "
    SELECT 
           inpol_policy_serial 
    FROM 
         inpolicies
         JOIN inagents ON inag_agent_serial = inpol_agent_serial
    WHERE
         inag_agent_code = 'AG493'
         AND inpol_status = 'N' AND inpol_process_status = 'E'";
if (!$export->setPolicySerialsBySql($sql)){
    echo $export->errorDescription;
}

if (!$export->generateExport()){
    echo $export->errorDescription;
}

if ($export->error == false){
    $file = $export->exportTable('clients','file');
    if ($file == false){
        echo $export->errorDescription;
    }
    else {
        //$db->export_file_for_download($file,'clients.txt');
        //print_r($file);
        echo $file;
    }
    echo "<hr>";
    $file = $export->exportTable('policies','file');
    if ($file == false){
        echo $export->errorDescription;
    }
    else {
        //$db->export_file_for_download($file,'clients.txt');
        //print_r($file);
        echo $file;
    }
}
