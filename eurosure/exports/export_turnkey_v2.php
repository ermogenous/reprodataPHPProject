<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 27/7/2021
 * Time: 3:57 μ.μ.
 */

include("../../include/main.php");
include("../lib/odbccon.php");
include("export_class.php");
include("export_turnkey_class.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Export - Turnkey V2";

$sybase = new ODBCCON();

//get all the policies to export

$sql = "
    SELECT 
        //CLIENTS
        'I' as iaicl_synthesis_in_out,
        'IMPORT' as iaicl_row_created_by,
	    'IMPORT' as iaicl_row_last_edit_by,
	    'O' as iaicl_row_status,
	    'IMPORT' as iaicl_row_status_last_update_by,
	    'ES' || incl_client_code as iaicl_client_code,
	    '1-001' as iaicl_agent_code, /* Direct Busi */
	    incl_account_type as iaicl_account_type,
	    incl_salutation as iaicl_salutation,
	    incl_first_name as iaicl_first_name,
	    incl_long_description as iaicl_long_description,
	    incl_identity_card as iaicl_identity_card,
        incl_short_description as iaicl_alias_description,
	    'EUR' as iaicl_currency_code,
	    'ACES-' || incl_client_code as iaicl_account_code,
        
        //POLICIES   
        'I' as iaipol_synthesis_in_out,
       'IMPORT' as iaipol_row_created_by,
	   'IMPORT' as iaipol_row_last_edit_by,
	   'O' as iaipol_row_status,
	   'IMPORT' as iaipol_row_status_last_update_by,
	   'REF-' || inpol_policy_serial as iaipol_policy_import_reference,
	   inpol_policy_number as iaipol_policy_number,
	   '281005' as iaipol_inscomp_code, /* Eurosure */ 
	   '1-001' as iaipol_agent_code,
	   'ES' || incl_client_code as iaipol_client_code,
	   inity_insurance_type as iaipol_product_code,
	   'O' as iaipol_status_flag, /* Allways outstanding!*/
	   inpol_process_status as iaipol_process_status,
	   'EUR' as iaipol_currency_code,
	   1 as iaipol_currency_rate,
	   'EUR' as iaipol_origin_currency_code,
	   1 as iaipol_origin_currency_rate,
	   'CYP' as iaipol_alpha_key1, /* Required optino from DesignMode!*/
	   inpol_period_starting_date as iaipol_period_starting_date,
	   inpol_starting_date as iaipol_phase_starting_date,
	   inpol_policy_period as iaipol_policy_period,
	   inpol_policy_year as iaipol_policy_year,
	   inpol_expiry_date as iaipol_expiry_date,
	   fn_get_policy_premium_custom(inpol_policy_serial,'phase','premium') as iaipol_premium,
	   fn_get_policy_premium_custom(inpol_policy_serial,'phase','fees') as iaipol_fees,
       fn_get_policy_premium_custom(inpol_policy_serial,'phase','stamps') as iaipol_stamps,
       fn_get_policy_premium_custom(inpol_policy_serial,'phase','mif') as iaipol_mif,
	   2325 as iaipol_client_value,
	   5 as iaipol_comm_perc_ins_comp01,
	   115 as iaipol_comm_value_ins_comp01,
	   10 as iaipol_agency_fee,
	   2200 as iaipol_ins_comp_value,
	   'N' as iaipol_agency_collect,
	   'N' as iaipol_embedded_commission,
	   'Y' as iaipol_ins_comp_embedded_commission,
	   'N' as iaipol_reins_embedded_commission,
	   'N' as iaipol_process_retention,
	   'in' as iaipol_original_module, /* Important */
	   'inpolicies' as iaipol_original_table, /* Important */
	   '777' as iaipol_original_auto_serial, /* Important */
	   'EUROSURE DUMMY' as iaipol_dummy_retention_reinsurer,
        inity_insurance_type as pclo_insurance_type,
        inity_insurance_form as pclo_insurance_form,
        //for endorsements Refund
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementRefund','premium') as pclo_end_refund_premium,
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementRefund','fees') as pclo_end_refund_fees,
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementRefund','stamps') as pclo_end_refund_stamps,
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementRefund','mif') as pclo_end_refund_mif,
        //for endorsements charge
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementCharge','premium') as pclo_end_charge_premium,
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementCharge','fees') as pclo_end_charge_fees,
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementCharge','stamps') as pclo_end_charge_stamps,
        fn_get_policy_premium_custom(inpol_policy_serial,'endorsementCharge','mif') as pclo_end_charge_mif
        
    FROM 
        inpolicies
        JOIN inagents ON inag_agent_serial = inpol_agent_serial
        JOIN inclients ON incl_client_serial = inpol_client_serial
        JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
    WHERE
         inag_agent_code = 'AG493' AND inpol_policy_serial > 564835
         AND inpol_status = 'N' AND inpol_process_status = 'E'";
$result = $sybase->query($sql);
$clients = [];
$policies = [];
$i=0;
while ($policy = $sybase->fetch_assoc($result)){

    foreach($policy as $name => $value){
        //get the clients
        if (substr($name,0,6) == 'iaicl_' || substr($name,0,6) == 'inity_'){
            $clients[$i][$name] = $value;
        }
        if (substr($name,0,7) == 'iaipol_' || substr($name,0,5) == 'pclo_'){
            $policies[$i][$name] = $value;
        }
    }
    $i++;
}

//=====  retrieve situations  ================================retrieve situations=======================================  retrieve situations
$sql = "SELECT
        'I' as iaipst_synthesis_in_out,
        'IMPORT' as iaipst_row_created_by,
	    'IMPORT' as iaipst_row_last_edit_by,
	    'O' as iaipst_row_status,
	    'IMPORT' as iaipst_row_status_last_update_by,
	    'N' as iaipst_inactive_for_endorsement, /* For Endorsement use if item no longer exists */
	    'REF-' || inpol_policy_serial as iaipst_policy_import_reference,
	    inpst_situation_code as iaipst_situation_code,
	    'Situation ' || inpst_situation_code || ' for Policy ' || inpol_policy_number as iaipst_description
        FROM
        inpolicies
        JOIN inpolicysituations ON inpst_policy_serial = inpol_policy_serial
        JOIN inagents ON inag_agent_serial = inpol_agent_serial
        JOIN inclients ON incl_client_serial = inpol_client_serial
        WHERE
         inag_agent_code = 'AG493' AND inpol_policy_serial > 564835
         AND inpol_status = 'N' AND inpol_process_status = 'E'
";
$sitResult = $sybase->query($sql);
$situations = [];
$i=0;
while ($situation = $sybase->fetch_assoc($sitResult)){

    foreach($situation as $name => $value){
        $situations[$i][$name] = $value;
    }
    $i++;
}

//== RETRIEVE ITEMS ===============================RETRIEVE ITEMS=======================================================  RETRIEVE ITEMS
$sql = "
        SELECT
        'I' as iaipit_synthesis_in_out,
        'IMPORT' as iaipit_row_created_by,
	    'IMPORT' as iaipit_row_last_edit_by,
	    'O' as iaipit_row_status,
	    'IMPORT' as iaipit_row_status_last_update_by,
	    'N' as iaipit_inactive_for_endorsement, /* For Endorsement use if item no longer exists */
	    'REF-' || inpol_policy_serial as iaipit_policy_import_reference,
	    inpst_situation_code as iaipit_situation_code,
	    NULL as iaipit_item_category_code, /* Item Category Null Or Valid Code! */
	    initm_item_code as iaipit_item_code,
	    inpit_pit_increment as iaipit_pit_increment,
	    inpit_insured_amount as iaipit_insured_amount
        FROM
        inpolicies
        JOIN inpolicyitems ON inpit_policy_serial = inpol_policy_serial
        JOIN initems ON initm_item_serial = inpit_item_serial
        LEFT OUTER JOIN inpolicysituations ON inpit_situation_serial = inpst_situation_serial
        JOIN inagents ON inag_agent_serial = inpol_agent_serial
        JOIN inclients ON incl_client_serial = inpol_client_serial
        WHERE
         inag_agent_code = 'AG493' AND inpol_policy_serial > 564835
         AND inpol_status = 'N' AND inpol_process_status = 'E'
";
$pitResult = $sybase->query($sql);
$policyItems = [];
$i=0;
while ($pit = $sybase->fetch_assoc($pitResult)){

    foreach($pit as $name => $value){
        $policyItems[$i][$name] = $value;
    }
    $i++;
}


//== RETRIEVE ITEMS PREMIUM ===============================RETRIEVE ITEMS PREMIUM=====================================  RETRIEVE ITEMS PREMIUM
$sql = "
        SELECT
'I' as iaipip_synthesis_in_out,
        'IMPORT' as iaipip_row_created_by,
 	    'IMPORT' as iaipip_row_last_edit_by,
   	    'O' as iaipip_row_status,
	    'IMPORT' as iaipip_row_status_last_update_by,
	    'N' as iaipip_inactive_for_endorsement, /* For Endorsement use if item no longer exists */
	    'REF-' || inpol_policy_serial as iaipip_policy_import_reference,
	    inpst_situation_code as iaipip_situation_code,
	    NULL as iaipip_item_category_code, /* Item Category Null Or Valid Code! */
initm_item_code as iaipip_item_code,
inpit_pit_increment as iaipip_pit_increment,
'2019 FIRE RI PREM ' as iaipip_peril_code,
'A' as iaipip_amount_rate,
	   500 as iaipip_peril_value,
fn_get_policy_premium_custom(inpol_policy_serial,'phase','premium')as iaipip_period_premium,
iaipip_period_premium as iaipip_year_premium,
1 as iaipip_comm_type,
iaipip_period_premium as iaipip_period_calculate
FROM
inpolicies
JOIN inpolicyitems ON inpit_policy_serial = inpol_policy_serial
JOIN initems ON initm_item_serial = inpit_item_serial
LEFT OUTER JOIN inpolicysituations ON inpit_situation_serial = inpst_situation_serial
JOIN inagents ON inag_agent_serial = inpol_agent_serial
JOIN inclients ON incl_client_serial = inpol_client_serial
WHERE
inag_agent_code = 'AG493' 
AND inpol_policy_serial > 564835
AND inpol_status = 'N' 
AND inpol_process_status = 'E'
";
$pitpResult = $sybase->query($sql);
$policyItemPrem = [];
$i=0;
while ($pitp = $sybase->fetch_assoc($pitpResult)){

    foreach($pitp as $name => $value){
        $policyItemPrem[$i][$name] = $value;
    }
    $i++;
}


$estkCon = new ODBCCON('ES_TK','UTF-8','dba','estk2021');
$turnkey = new exportTurnkey();
//$turnkey->exportClientsToDB($clients);
$turnkey->exportPoliciesToDB($policies);
//$turnkey->exportSituationsToDB($situations);
//$turnkey->exportPolicyItemsToDB($policyItems);
//$turnkey->exportPolicyItemsPremiumToDB($policyItemPrem);

/*
$estk = new ODBCCON('ES_TK','UTF-8','dba','estk2021');
$sql = 'SELECT * FROM iapcodes';
$result = $estk->query($sql);
print_r($estk->fetch_assoc($result));

print_r($clients);
echo "\n\n\n\n\n";
print_r($policies);
*/

