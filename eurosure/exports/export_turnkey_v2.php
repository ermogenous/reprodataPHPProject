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
	    'EUROSURE' || incl_client_code as iaicl_client_code,
	    '1-001' as iaicl_agent_code, /* Direct Busi */
	    incl_account_type as iaicl_account_type,
	    incl_salutation as iaicl_salutation,
	    incl_first_name as iaicl_first_name,
	    incl_long_description as iaicl_long_description,
	    incl_identity_card as iaicl_identity_card,
	    'EUR' as iaicl_currency_code,
	    'ACEURSURE-' || incl_client_code as iaicl_account_code,
        
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
	   'EUROSURE' || incl_client_code as iaipol_client_code,
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
	   'EUROSURE DUMMY' as iaipol_dummy_retention_reinsurer
    
    FROM 
        inpolicies
        JOIN inagents ON inag_agent_serial = inpol_agent_serial
        JOIN inclients ON incl_client_serial = inpol_client_serial
        JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
    WHERE
         inag_agent_code = 'AG493'
         AND inpol_status = 'N' AND inpol_process_status = 'E'";
$result = $sybase->query($sql);
$clients = [];
$policies = [];
$i=0;
while ($policy = $sybase->fetch_assoc($result)){

    foreach($policy as $name => $value){
        //get the clients
        if (substr($name,0,6) == 'iaicl_'){
            $clients[$i][$name] = $value;
        }
        if (substr($name,0,7) == 'iaipol_'){
            $policies[$i][$name] = $value;
        }
    }
    $i++;
}

print_r($policies);
