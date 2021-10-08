<?php

class synthesis_claims {
	
	var $sql_select;
	var $sql_from;
	var $sql_where;
	var $sql_sort;
	var $sql_group;
	var $sql_having;
	var $sql;
	var $outer_select = 0;
	var $outer_select_select;
	var $outer_select_select_after;
	var $outer_select_from;
	var $outer_select_where;
	var $outer_select_sort;
	var $outer_select_group;
	var $outer_select_having;
	var $from_date;
	var $as_at_date;
	var $using_alternative = 0;
	
	var $clo_process_status = "'P','O','W','R','C'";
	var $clm_status = "'O','A','D'";
	
	//tables added
	var $added_tables = array();
	var $added_fields = array();

	
function __construct($from_date,$as_at_date) {
	//as at date -> full date
	//from_date -> full date
	$this->from_date = $from_date;
	$this->as_at_date = $as_at_date;
	
	$this->sql_select = "
inclaims.inclm_claim_serial ,
inclaims.inclm_claim_number ,
DATE('".$from_date."') as clo_from_date,
DATE('".$as_at_date."') as clo_as_at_date,
(SELECT inpr_financial_period FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_period,
(SELECT inpr_financial_year FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_year,
inclaims.inclm_process_status,
inclaims.inclm_open_date,
IF clo_process_status IN ('C', 'W') THEN YEAR(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_year,
IF clo_process_status IN ('C', 'W') THEN MONTH(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_period,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve_as_at_date,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries_as_at_date,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_paid_as_at_date,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_as_at_date,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_reserve_pay_recovery_exp,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_reserves,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_est_recoveries,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_payments,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_recoveries,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'I' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_initial_res_for_payments,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'R' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_reest_res_for_payments,
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_est_recoveries_period,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_payments,
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_recoveries,
CASE WHEN inclm_process_status = 'I' THEN 'I' WHEN clo_estimated_reserve_as_at_date = 0 THEN IF COUNT(IF incvsdt_line_sub_type <> '' THEN 1 ELSE NULL ENDIF) = 0 THEN 'P' ELSE 'W' ENDIF 
    WHEN clo_estimated_reserve_as_at_date - clo_paid_as_at_date = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date = 0 THEN 'C'
    WHEN (clo_estimated_reserve_as_at_date - clo_reserve_pay_recovery_exp) - (clo_paid_as_at_date - clo_payments_recovery_exp) = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'R' ELSE 'O' END 
    as clo_process_status";
	
	$this->sql_from = "inclaims
JOIN inclaims_asat_date ON inclm_claim_serial = incvsdt_claim_serial";

	$this->sql_where = "//inclm_process_status <> 'I' /* Exclude Initial */ 
//And inclm_status <> 'D' /* Exclude Deleted */ 

inclm_open_date <= clo_as_at_date
And incvsdt_operation_date <= clo_as_at_date";

	$this->sql_group = "inclm_claim_serial ,
inclm_claim_number ,
inclm_process_status ,
inclm_open_date   , 
inclm_claim_number ";

	$this->sql_having = "AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$from_date."') * 100) + MONTH('".$from_date."') OR clo_closed_year = 0)";

	$this->sql_sort = "clo_as_at_date ASC";
	
}//init function 

function convert_to_alternative() {
	$this->sql_select = "
inclm_claim_serial ,           
inclm_claim_number ,           
DATE('".$this->from_date."') as clo_from_date,
DATE('".$this->as_at_date."') as clo_as_at_date,
(SELECT inpr_financial_period FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_period,           
(SELECT inpr_financial_year FROM inpparam WHERE UPPER(inpr_module_code) = 'IN') as clo_financial_year,           
inclm_process_status ,           
inclm_open_date ,           
CASE inclm_process_status WHEN 'C' THEN IF clo_estimated_reserve_as_at_date - clo_paid_as_at_date <> 0 THEN 'O' ELSE IF clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'R' ELSE 'C' ENDIF ENDIF WHEN 'R' THEN IF clo_estimated_reserve_as_at_date - clo_paid_as_at_date - (clo_reserve_pay_recovery_exp - clo_payments_recovery_exp) <> 0 THEN 'O' ELSE 'R' ENDIF WHEN 'W' THEN IF clo_estimated_reserve_as_at_date - clo_paid_as_at_date <> 0 OR clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'O' ELSE 'W' ENDIF WHEN 'O' THEN IF clo_estimated_reserve_as_at_date = 0 AND clo_estimated_recoveries_as_at_date = 0 THEN 'P' ELSE IF clo_estimated_reserve_as_at_date - clo_paid_as_at_date = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date <> 0 THEN 'R' ELSE IF clo_estimated_reserve_as_at_date - clo_paid_as_at_date = 0 AND clo_estimated_recoveries_as_at_date - clo_recoveries_as_at_date = 0 THEN 'C' ELSE 'O' ENDIF ENDIF ENDIF END as clo_process_status,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_paid_as_at_date,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_recoveries_as_at_date,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_payments,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_recoveries,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_payments,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_period_recoveries,           
SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_payments_recovery_exp,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_reserves,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND incvsdt_operation_date < clo_from_date THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_bf_est_recoveries,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'I' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_initial_res_for_payments,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_initial_re_estimation = 'R' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_reest_res_for_payments,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_reserve_as_at_date,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_recoveries_as_at_date,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incvsdt_reset_on_recovery = 'N' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_reserve_pay_recovery_exp,           
SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C5' AND (incvsdt_operation_date BETWEEN clo_from_date AND clo_as_at_date) THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF)  as clo_est_recoveries_period,           
IF clo_process_status IN ('C', 'W') THEN YEAR(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_year,           IF clo_process_status IN ('C', 'W') THEN MONTH(MAX(incvsdt_operation_date)) ELSE 0 ENDIF AS clo_closed_period   
	";
	$this->sql_from = "
	inclaims
	JOIN inclaims_asat_date ON inclm_claim_serial = incvsdt_claim_serial
	JOIN inreinsurancetreaties ON incvsdt_policy_treaty = inrit_reinsurance_treaty_serial
	JOIN ininsurancetypes ON inrit_alternative_insurance_type = inity_insurance_type_serial
	";
	$this->sql_where = "
	inclm_process_status <> 'I' /* Exclude Initial */ 
	And inclm_status <> 'D' /* Exclude Deleted */
	and inclm_open_date <= clo_as_at_date
	and incvsdt_operation_date <= clo_as_at_date
	";
	$this->sql_group = "inclm_claim_serial ,
	inclm_claim_serial ,
	inclm_claim_number ,
	inclm_process_status ,
	inclm_open_date ,
	inclm_claim_number ";
	
	$this->sql_having = "AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$this->from_date."') * 100) + MONTH('".$this->from_date."') OR clo_closed_year = 0)";

	$this->sql_sort = "clo_as_at_date ASC";
	$this->using_alternative = 1;
}

function auto_arrange_process_status($preliminary,$outstanding,$withdrawn,$recovery,$closed,$what_to_check){
	$clo_process_status = "'P','O','W','R','C'";
	$ps = '';
	if ($preliminary == $what_to_check)
		$ps .= ",'P'";
	if ($outstanding == $what_to_check)
		$ps .= ",'O'";
	if ($withdrawn == $what_to_check)
		$ps .= ",'W'";
	if ($recovery == $what_to_check)
		$ps .= ",'R'";
	if ($closed == $what_to_check)
		$ps .= ",'C'";
	
	//if its empty then leave the default
	if ($ps != '') {
		//remove the first char
		$this->clo_process_status = substr($ps,1);
	}	
}

function insert_select($select,$as_name='') {

	$this->sql_select .= "\n, ".$select;
	if ($as_name != "") {
		$this->sql_select .= " as ".$as_name;	
	}
	
}

function insert_from($from,$is_join = 0) {

	$this->sql_from .= "\n";
	if ($is_join == 0) {
		$this->sql_from .= ",";
	}
	$this->sql_from .= $from;
	
}

function insert_where($where) {
	
	$this->sql_where .= "\n".$where;	

}

function insert_group($group) {
	
	$this->sql_group .= "\n,".$group;	
	
}

function insert_having($having) {
	
	$this->sql_having .= "\n".$having;
	
}

function insert_sort($sort,$sort_type='ASC'){
	
	$this->sql_sort .= "\n,".$sort." ".$sort_type;
	
}

function insert_select_group($select,$as_name='') {
	
	$this->insert_select($select,$as_name);
	$this->insert_group($select);
		
}

function insert_open_date($date_from,$date_to) {

	$this->insert_where("AND inclm_open_date >='".$date_from."'");
	$this->insert_where("AND inclm_open_date <='".$date_to."'");
	
}

function insert_date_of_event($date_from,$date_to){
	
	$this->insert_where("AND inclm_date_of_event >='".$date_from."'");
	$this->insert_where("AND inclm_date_of_event <='".$date_to."'");
	
}

function add_policies() {
	if ($this->added_tables["inpolicies"] != 1) {
		$this->added_tables["inpolicies"] = 1;
		$this->insert_from("JOIN inpolicies ON inpol_policy_serial = inclm_policy_serial",1);	
	}

}

function add_clients() {
	if ($this->added_tables["inclients"] != 1) {
		$this->added_tables["inclients"] = 1;
		$this->insert_from("JOIN inclients ON inpol_client_serial = incl_client_serial",1);	
	}

}

function add_driver() {
	if ($this->added_tables["indrivers"] != 1) {
		$this->added_tables["indrivers"] = 1;
		$this->insert_from("LEFT OUTER JOIN indrivers ON indr_driver_serial = inclm_driver_serial",1);
	}
	
}

function add_insurance_types() {

	if ($this->using_alternative == 1) {
		if ($this->added_tables["ininsurancetypes"] != 1) {
			$this->added_tables["ininsurancetypes"] = 1;
			$this->insert_from("JOIN ininsurancetypes ON inrit_alternative_insurance_type = inity_insurance_type_serial",1);	
		}
	}
	else {
		if ($this->added_tables["ininsurancetypes"] != 1) {
			$this->added_tables["ininsurancetypes"] = 1;
			$this->insert_from("JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial",1);
		}
	}

}

function add_agents() {
	if ($this->added_tables["inagents"] != 1) {
		$this->added_tables["inagents"] = 1;
		$this->insert_from("JOIN inagents ON inag_agent_serial = inpol_agent_serial",1);
	}

}

function add_claims_aux() {
	if ($this->added_tables["inclaimaux"] != 1) {
		$this->added_tables["inclaimaux"] = 1;
		$this->insert_from("LEFT OUTER JOIN inclaimaux on inclm_claim_serial = inclax_claim_serial",1);
	}
}

function add_peril_group() {
	if ($this->added_tables["codes_peril"] != 1) {
		$this->added_tables["codes_peril"] = 1;
		$this->insert_from('JOIN inclaimcodes as codes_peril ON codes_peril.inclcd_pcode_serial = incvsdt_reserve_serial',1);
	}
	//$this->insert_from('JOIN inloadingperilcodes ON inllt_pcode_serial = inclcd_ldg_reserve_group',1);
	if ($this->added_tables["peril"] != 1) {
		$this->added_tables["peril"] = 1;
		$this->insert_from('JOIN inpcodes as peril ON peril.incd_pcode_serial = inclcd_ldg_reserve_group',1);
	}
}

function add_policy_situation() {
	if ($this->added_tables["inpolicysituations"] != 1) {
		$this->added_tables["inpolicysituations"] = 1;
		$this->insert_from("JOIN inpolicysituations ON inpst_situation_serial = inclm_situation_serial",1);	
	}
}

function insert_driver_details() {
	
	$this->insert_select_group('indr_birth_date','clo_driver_birth_date');
	$this->insert_select_group('indr_permit_date','clo_driver_license_date');
	$this->insert_select('COALESCE(fn_evaluate_age(indr_birth_date,inclm_date_of_event),0)','clo_driver_age');
	$this->insert_select('COALESCE(fn_evaluate_age(indr_permit_date,inclm_date_of_event),0)','clo_driver_license_age');
	$this->insert_group('inclm_date_of_event');
	$this->insert_select('if indr_learner_license_date is not null and indr_permit_date is null then 1 else 0 endif','clo_driver_is_learner');
	$this->insert_group('indr_learner_license_date');

}
//OUTER SELECT===========================================================================================================================================
function enable_outer_select() {

	$this->outer_select = 1;
	$this->outer_select_select = "";
	$this->outer_select_from = "FROM \n#ctemp";
	$this->outer_select_where = "WHERE \n1=1";
	$this->outer_select_group = "";
	$this->outer_select_having = "";
	$this->outer_select_sort = "";
	
}

function insert_outer_select($select,$as_name='') {

	if ($this->outer_select_select != "") {
		$this->outer_select_select .= "\n, ".$select;
	}
	else {
		$this->outer_select_select .= $select;
	}
	if ($as_name != '') {
		$this->outer_select_select .= " as ".$as_name;
	}
	
}

function insert_outer_select_after($select) {
	$this->outer_select_select_after = $select;
}

function insert_outer_from($from,$is_join = 0) {

	$this->outer_select_from .= "\n";
	if ($is_join == 0) {
		$this->outer_select_from .= ",";
	}
	$this->outer_select_from .= $from;
	
}

function insert_outer_where($where) {
	
	$this->outer_select_where .= "\n".$where;	

}

function insert_outer_group($group) {
	
	
	if ($this->outer_select_group != "") {
		$this->outer_select_group .= "\n,";
	}
	else {
		$this->outer_select_group .= "\n";
	}
	$this->outer_select_group .= $group;	
	
}

function insert_outer_having($having) {
	
	$this->outer_select_having .= "\n".$having;
	
}

function insert_outer_sort($sort,$sort_type='ASC'){
	
	if ($this->outer_select_sort == "") {
		$this->outer_select_sort .= "\n";
	}
	else {
		$this->outer_select_sort .= "\n,";
	}
	
	$this->outer_select_sort .= $sort." ".$sort_type;
	
}

function insert_outer_select_group($select,$as_name='') {
	
	$this->insert_outer_select($select,$as_name);
	$this->insert_outer_group($select);
		
}

function insert_outer_res_pay_totals() {
	
	$this->insert_outer_select("SUM(clo_period_payments)as clo_total_period_payments");
	$this->insert_outer_select("SUM(clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)as clo_total_os_reserve");
	$this->insert_outer_select("SUM(clo_period_recoveries)as clo_total_period_recoveries");
	$this->insert_outer_select("SUM(clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date)as clo_total_os_recoveries");
	//totals
	$this->insert_outer_select("SUM((clo_period_payments) + (clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date) - (clo_period_recoveries) - (clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date)) as clo_total_claim_cost");
	
	$this->insert_outer_select("SUM((clo_period_payments) + (clo_bf_reserves + clo_initial_res_for_payments + clo_reest_res_for_payments - clo_paid_as_at_date)) as clo_total_reserves");
	$this->insert_outer_select("SUM((clo_period_recoveries) + (clo_bf_est_recoveries + clo_est_recoveries_period - clo_recoveries_as_at_date)) as clo_total_recoveries");
	$this->insert_outer_select("COUNT(DISTINCT(inclm_claim_serial)) as clo_total_claims");
		
}


//FINALISE================================================================================================================================================
function generate_sql() {

	$this->insert_having("AND clo_process_status in (".$this->clo_process_status.")");
	$this->insert_where("AND inclm_status in (".$this->clm_status.")");

	$this->sql = "SELECT \n".$this->sql_select."\n";
	
	//outer select
	if ($this->outer_select == 1) {
		$this->sql .= "into #ctemp";	
	}
	
	$this->sql .= "\nFROM \n".$this->sql_from."\n";
	
	$this->sql .= "\nWHERE \n".$this->sql_where."\n";

	$this->sql .= "\nGROUP BY \n".$this->sql_group."\n";

	$this->sql .= "\nHAVING \n1=1\n".$this->sql_having."\n";
	
	$this->sql .= "\nORDER BY \n".$this->sql_sort;

	//outer select
	if ($this->outer_select == 1) {
		$this->sql .= ";\n\nSELECT\n".$this->outer_select_select."\n";
		$this->sql .= "\n".$this->outer_select_select_after."\n";
		$this->sql .= "".$this->outer_select_from."\n";
		$this->sql .= "".$this->outer_select_where."\n";
		if ($this->outer_select_group != "") {
			$this->sql .= "GROUP BY".$this->outer_select_group."\n";
		}
		if ($this->outer_select_having != "") {
			$this->sql .= "HAVING\n".$this->outer_select_having."\n";
		}
		if ($this->outer_select_sort != ""){
			$this->sql .= "ORDER BY ".$this->outer_select_sort."\n";
		}
		
	}
}//generate_sql

function return_sql() {
	
	return $this->sql."\n\n\n\n\n";	
	
}//return sql
	
	
}


?>
