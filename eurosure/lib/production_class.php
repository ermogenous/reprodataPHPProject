<?php

class synthesis_production {
	
	var $is_production = 0;
	var $is_as_at = 0;
	
	var $sql_begining;
	var $sql_select;
	var $sql_from;
	var $sql_where;
	var $sql_sort;
	var $sql_group;
	var $sql_having = "";
	var $sql;
	var $outer_select = 0;
	var $outer_select_select;
	var $outer_select_select_after;
	var $outer_select_from;
	var $outer_select_where;
	var $outer_select_sort = "";
	var $outer_select_group;
	var $outer_select_having = "";
	var $sql_at_the_end;
	
	//the below must be set if as_at_sql
	var $as_at_date = '';
	var $up_to_period = '';
	var $up_to_year = '';
	
	//the below must be set if policy period sql
	var $from_period = '';
	var $to_period = '';
	var $from_year = '';
	var $to_year = '';
	
	//default statuses
	var $clo_process_status = "'N','R','E','D','C','L'";
	var $clo_status = "'A','N'";
	
	//tables added
	var $added_tables = array();
	var $added_fields = array();
	
	//warnings 
	var $show_warnings = 0;
	
	public function __construct() {
	
	$this->sql_select = "
1 as remove_clo_default_sort
";
	$this->sql_from = "
inpolicies 
JOIN inpolicyendorsement ON inped_financial_policy_abs = inpol_policy_serial
";
	$this->added_tables["inpolicyendorsement"] = 1;
	$this->added_tables["inpolicies"] = 1;
	$this->sql_where = "1=1
	AND COALESCE(inped_status, CASE inpol_status WHEN 'Q' THEN '2' WHEN 'D' THEN '3' END, '?') IN ('1','2')
	";

	$this->sql_sort = "
remove_clo_default_sort ASC";	
	
	}//synthesis_production
	
	//needs to define: as_at_date, up_to_period, up_to_year
	public function as_at_sql () {
		//use the view inpoliciesactive
		
		$this->is_as_at = 1;
		$this->sql_begining = "INSERT INTO ccuserparameters (ccusp_auto_serial,ccusp_user_date,ccusp_user_identity)ON EXISTING UPDATE VALUES(1,'".$this->as_at_date."' ,'INTRANET'); \n\n";

		$this->sql_select .= ",inpva_process_status";
		$this->sql_select .= ",inpva_status";
		$this->sql_from = 'inpoliciesactive
JOIN inpolicies ON inpol_policy_serial = inpva_policy_serial
JOIN inpolicyendorsement ON inped_financial_policy_abs = inpol_policy_serial';
		//$this->sql_group = "inpva_process_status,inpva_status";
		
				
	}//as_at_sql
	
	
public function policy_sql ($add_prem = 1) {

	$this->is_production = 1;
	
	if ($add_prem == 1) {
		$this->sql_select .= "\n
	,(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_premium)) As clo_premium
	,(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif
	,(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees
	,(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps
	,SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5','C6','C7','C8','C9','CF') AND intrd_owner = 'O'))as clo_commission
	,inped_process_status
	";
	}
	
	$this->sql_where .= "
AND (inped_year*100+inped_period) >= (".$this->from_year."*100+".$this->from_period.") 
AND (inped_year*100+inped_period) <= (".$this->to_year."*100+".$this->to_period.") 
";
	$this->sql_group = "inped_process_status";
}

function insert_select($select,$as_name='') {
	//check if the field already exists.
	//echo $select."<hr>";
	if ($this->added_fields[$select] != 1) {
		$this->sql_select .= "\n, ".$select;
		if ($as_name != "") {
			$this->sql_select .= " as ".$as_name;	
		}

	}
	else {
		
		if ($this->show_warnings == 1) {
			echo $select."<br>".$this->sql_select."<br><br>";
			echo "Field ".$select."[".$as_name."] already Exists<br><br>";
			print_r($this->added_fields);
			echo "<hr>";
		}
	}

/*	$pos = strpos($this->sql_select,", ".$select);
	if ($pos === false) {

	}
	else {
	
	}
*/
	$this->added_fields[$select] = 1;
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

	//check if the field already exists.
	$pos = strpos($this->sql_group,$group);
	if ($pos === false) {
		if ($this->sql_group == '') {
			$this->sql_group .= $group;
		}
		else {
			$this->sql_group .= "\n,".$group;
			
		}
	}
	
}

function insert_having($having) {
	
	$this->sql_having .= "\n".$having;
	
}

function insert_sort($sort,$sort_type='ASC'){
	
	//check if the field already exists.
	$pos = strpos($this->sql_sort,$sort);
	if ($pos === false) {
		$this->sql_sort .= "\n,".$sort." ".$sort_type;
	}
	
}

//adds a select and a group together.
function insert_select_group($select,$as_name='') {
	
	$this->insert_select($select,$as_name);
	if ($as_name == '') {
		$this->insert_group($select);
	}
	else {
		$this->insert_group($as_name);	
	}
	
		
}

function add_clients() {

	if ($this->added_tables["inclients"] != 1) {
		$this->added_tables["inclients"] = 1;
		$this->insert_from("JOIN inclients ON inpol_client_serial = incl_client_serial",1);	
	}
}

function add_archive_clients() {
	if ($this->added_tables["inpolicydocumentclients"] != 1) {
		$this->added_tables["inpolicydocumentclients"] = 1;
		$this->insert_from("join inpolicydocumentclients ON inpdcl_policy_serial = inpol_policy_serial AND inpdcl_client_serial = inpol_client_serial",1);	
	}
}

function add_insurance_types() {

	if ($this->added_tables["ininsurancetypes"] != 1) {
		$this->added_tables["ininsurancetypes"] = 1;
		$this->insert_from("JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial",1);	
	}

}

function add_agents() {
	if ($this->added_tables["inagents"] != 1) {

		$this->added_tables["inagents"] = 1;
		$this->insert_from("JOIN inagents ON inag_agent_serial = inpol_agent_serial",1);	
	}
}

function add_general_agents() {
	if ($this->added_tables["ingeneralagents"] != 1) {

		$this->added_tables["ingeneralagents"] = 1;
		$this->insert_from("JOIN ingeneralagents ON inga_agent_serial = inag_general_agent_serial",1);	
	}
}

function add_situations() {
	if ($this->added_tables["inpolicysituations"] != 1) {
		$this->added_tables["inpolicysituations"] = 1;
		$this->insert_from("JOIN inpolicysituations ON inpst_policy_serial = inpol_policy_serial",1);
	}
}

function add_situation_items() {
	if ($this->added_tables["inpolicysituations"] != 1) {
		$this->add_situations();	
	}
	if ($this->added_tables["inpolicyitems"] != 1) {
		$this->added_tables["inpolicyitems"] = 1;
		$this->insert_from("JOIN inpolicyitems ON inpst_situation_serial = inpit_situation_serial",1);
	}
}

function add_policy_items() {
	if ($this->added_tables["inpolicyitems"] != 1) {
		$this->added_tables["inpolicyitems"] = 1;
		$this->insert_from("JOIN inpolicyitems ON inpol_policy_serial = inpit_policy_serial",1);
	}
}

function add_items() {
	if ($this->added_tables["initems"] != 1) {
		if ($this->added_tables["inpolicyitems"] == 1) {
			$this->added_tables["initems"] = 1;
			$this->insert_from("JOIN initems ON initm_item_serial = inpit_item_serial",1);
		}
	}
}

function add_templates() {
	if ($this->added_tables["intemplates"] != 1) {
		$this->added_tables["intemplates"] = 1;
		$this->insert_from("LEFT OUTER JOIN intemplates ON intmpl_template_serial = inpol_template_serial",1);
	}
}

function add_phase_premium($type_of_premium = 'GROSS') {

	$this->insert_select("fn_return_period_premium(inpol_policy_serial,'ONLYCURRENT','".$type_of_premium."'");
		
}

function add_majors(){

	if ($this->added_tables["inmajorcodes"] != 1) {
		if ($this->added_tables["ininsurancetypes"] != 1) {
			$this->add_insurance_types();
		}
	
		$this->added_tables["inmajorcodes"] = 1;
		$this->insert_from("LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code",1);
	}
}

function add_policies_counts() {

	$this->insert_select("COUNT(DISTINCT(inpol_policy_number))",'clo_total_distinct_policies');
	$this->insert_select("COUNT(DISTINCT(inpol_policy_serial))",'clo_total_distinct_phases');

	
}

function add_policy_drivers_learners_num() {
	$this->insert_select("COALESCE((SELECT SUM(if indr_learner_license_date is not null and indr_permit_date is null then 1 else 0 endif) FROM inpolicydrivers JOIN indrivers ON indr_driver_serial = inpdr_driver_serial WHERE inpdr_policy_serial = inpol_policy_serial),0)","clo_drivers_num_found");	
}

function add_policy_drivers() {

	if ($this->added_tables["inpolicydrivers"] != 1) {
		$this->added_tables["inpolicydrivers"] = 1;
		$this->insert_from("LEFT OUTER JOIN inpolicydrivers  ON inpol_policy_serial = inpdr_policy_serial",1);
	}
}

function add_drivers() {

	if ($this->added_tables["indrivers"] != 1) {
		if ($this->added_tables["inpolicydrivers"] != 1) {
			$this->add_policy_drivers();
		}

		$this->added_tables["indrivers"] = 1;
		$this->insert_from("LEFT OUTER JOIN indrivers ON inpdr_driver_serial = indr_driver_serial",1);
	}
}

function add_commission_types() {
	if ($this->add_per_item_premium_from_loadings == 1) {
		
		$this->add_insurance_types();
		if ($this->added_tables["inpcodes as isf"] != 1) {
			$this->added_tables["inpcodes as isf"] = 1;
			$this->insert_from("JOIN inpcodes as isf ON isf.incd_record_type = 'SF' AND isf.incd_record_code = inity_insurance_sub_form",1);
		}
		$this->insert_select("CASE
	WHEN inldg_commission_assigned = '' THEN isf.incd_scale_1_cc
	WHEN inldg_commission_assigned = '1' THEN isf.incd_scale_2_cc
	WHEN inldg_commission_assigned = '2' THEN isf.incd_scale_3_cc
	WHEN inldg_commission_assigned = '3' THEN isf.incd_scale_4_cc
	WHEN inldg_commission_assigned = '4' THEN isf.incd_scale_5_cc
	WHEN inldg_commission_assigned = '5' THEN isf.incd_scale_6_cc
	WHEN inldg_commission_assigned = '6' THEN isf.incd_scale_7_cc
	WHEN inldg_commission_assigned = '7' THEN isf.incd_scale_8_cc
	WHEN inldg_commission_assigned = '8' THEN isf.incd_last_document_number
	WHEN inldg_commission_assigned = '9' THEN isf.incd_layout_name
	END","clo_commission_assigned");
		$this->insert_group('isf.incd_layout_name');
		$this->insert_group('isf.incd_scale_1_cc');
		$this->insert_group('isf.incd_scale_2_cc');
		$this->insert_group('isf.incd_scale_3_cc');
		$this->insert_group('isf.incd_scale_4_cc');
		$this->insert_group('isf.incd_scale_5_cc');
		$this->insert_group('isf.incd_scale_6_cc');
		$this->insert_group('isf.incd_scale_7_cc');
		$this->insert_group('isf.incd_scale_8_cc');
		$this->insert_group('isf.incd_last_document_number');
	}
	else {
		echo "Cannot add commission types. Must be item premium from loadings";
	}
}

public function add_per_item_premium_from_loadings() {
	
	//the correct sql to do this is
	/*
	SELECT
	SUM(-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit))as clo_premium
	FROM
	inpolicyendorsement
	JOIN inpolicyloadings ON inplg_policy_serial = inped_policy_serial
	JOIN inpolicyitems ON inplg_pit_auto_serial = inpit_pit_auto_serial
	JOIN inpolicies ON inpol_policy_serial = inped_financial_policy_abs
	
	WHERE
	inped_year = 2014
	AND inped_status = 1
	*/
	
	
//if this function is used remember to ignore the premiums because are now duplicated due to the loadings.
	if ($this->add_per_item_premium_from_loadings != 1) {
		$this->add_per_item_premium_from_loadings = 1;

		//need to join inpolicyendorsement with abs (NOTE THIS WILL BRING 2 records in case of endorsement. thus double items and double loadings.
		//to count items and loadings need to use distinct
		if ($this->added_tables["inpolicyendorsement"] != 1) {
			$this->added_tables["inpolicyendorsement"] = 1;
			$this->insert_from("JOIN inpolicyendorsement ON inpol_policy_serial = inped_financial_policy_abs",1);
		}
		if ($this->added_tables["inpolicyitems"] != 1) {
			$this->added_tables["inpolicyitems"] = 1; 
			$this->insert_from("JOIN inpolicyitems ON inpit_policy_serial = inped_policy_serial",1);
		}
		if ($this->added_tables["inpolicyloadings"] != 1) {
			$this->added_tables["inpolicyloadings"] == 1;
			$this->insert_from("JOIN inpolicyloadings ON inplg_pit_auto_serial = inpit_pit_auto_serial",1);
		}
		if ($this->added_tables["inloadings"] != 1) {
			$this->added_tables["inloadings"] = 1;
			$this->insert_from("JOIN inloadings ON inldg_loading_serial = inplg_loading_serial",1);
		}
		
		//first need to remove the premium calculations 
		//$this->sql_select = '1 remove_clo_default_sort';
		
		$this->insert_select("SUM(-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit))","clo_loading_premium");
		$this->insert_select ("CASE
WHEN inldg_commission_assigned = '' THEN (inpol_commission_percentage / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 1 THEN (inpol_commission_percentage1 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 2 THEN (inpol_commission_percentage2 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 3 THEN (inpol_commission_percentage3 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 4 THEN (inpol_commission_percentage4 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 5 THEN (inpol_commission_percentage5 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 6 THEN (inpol_commission_percentage6 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 7 THEN (inpol_commission_percentage7 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 8 THEN (inpol_commission_percentage8 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 9 THEN (inpol_commission_percentage9 / 100) * clo_loading_premium
WHEN inldg_commission_assigned = 10 THEN (inpol_commission_percentage10 / 100) * clo_loading_premium
end","clo_commission_total");
		
		$this->insert_group("inpol_commission_percentage");
		$this->insert_group("inpol_commission_percentage1");
		$this->insert_group("inpol_commission_percentage2");
		$this->insert_group("inpol_commission_percentage3");
		$this->insert_group("inpol_commission_percentage4");
		$this->insert_group("inpol_commission_percentage5");
		$this->insert_group("inpol_commission_percentage6");
		$this->insert_group("inpol_commission_percentage7");
		$this->insert_group("inpol_commission_percentage8");
		$this->insert_group("inpol_commission_percentage9");
		$this->insert_group("inpol_commission_percentage10");
		$this->insert_group("inldg_commission_assigned");
		
	}
	
}

public function add_per_item_premium_without_loadings() {
	$this->insert_select("fn_return_period_loadings_premium(inpol_policy_serial,'ONLYCURRENT','AND inpit_pit_auto_serial = ' + convert(char(10),inpit_pit_auto_serial))","clo_item_premium");
}

public function add_per_situation_premium_from_loadings() {

	if ($this->add_per_situation_premium_from_loadings != 1) {
		$this->add_per_situation_premium_from_loadings = 1;
		
		//$this->add_situations();
		$this->insert_from("JOIN inpolicysituations ON inpst_policy_serial = inped_policy_serial",1);
		$this->insert_from("JOIN inpolicyitems ON inpst_situation_serial = inpit_situation_serial",1);
		$this->insert_from("JOIN inpolicyloadings ON inplg_pit_auto_serial = inpit_pit_auto_serial",1);
		$this->insert_from("JOIN inloadings ON inldg_loading_serial = inplg_loading_serial",1);
		
		$this->sql_select .= "\n
		,SUM(-1 * ((IF inped_premium_debit_credit = -1 THEN inplg_period_premium ELSE inplg_return_premium ENDIF) * inped_premium_debit_credit)) as clo_loading_premium";
	}
	
}

public function add_find_fac_in_policy(){

	if ($this->added_tables["inpolicies"] == 1) {
		$this->insert_select("(
		SELECT IF COUNT() > 0 THEN 1 ELSE 0 ENDIF 
		FROM
		inpolicyreinsurance
		WHERE
		inpri_policy_serial = inpol_policy_serial AND inpri_endorsement_serial = inpol_last_endorsement_serial AND inpri_reinsurance_type IN ('5-FLC', '6-FFR')
	)",'clo_fac_found');
	}

}

public function add_cancel_endorsement_process_status() {
	
	$this->insert_select("IF inped_process_status IN ('C','E') THEN inped_process_status + (SELECT inpol_process_status FROM inpolicies as cps WHERE cps.inpol_policy_serial = fn_get_period_first_policy_serial(inpolicies.inpol_policy_serial)) ELSE inped_process_status ENDIF","clo_cancel_end_process_status");
	
}

//OUTER SELECT===========================================================================================================================================
function enable_outer_select() {

	$this->outer_select = 1;
	$this->outer_select_select = "";
	$this->outer_select_from = "FROM \n#temp";
	$this->outer_select_where = "WHERE \n1=1";
	$this->outer_select_group = "";
	$this->outer_select_having = "";
	$this->outer_select_sort = "";
	
}

function insert_outer_select($select,$as_name='') {

	//check if the field already exists.
	$pos = strpos($this->outer_select_select,$select);
	if ($pos === false) {

		if ($this->outer_select_select != "") {
			$this->outer_select_select .= "\n, ".$select;
		}
		else {
			$this->outer_select_select .= $select;
		}
		if ($as_name != '') {
			$this->outer_select_select .= " as '".$as_name."'";
		}
	}
}

function insert_outer_select_after($select) {
	$this->outer_select_select_after .= $select;
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
	
	//check if the field already exists.
	$pos = strpos($this->outer_select_group,$group);
	if ($pos === false) {

		if ($this->outer_select_group != "") {
			$this->outer_select_group .= "\n,";
		}
		else {
			$this->outer_select_group .= "\n";
		}
		$this->outer_select_group .= $group;	
	}
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


//FINALISE================================================================================================================================================
function generate_sql() {

	if ($this->is_as_at == 1) {
		$this->insert_where("AND inpva_process_status in (".$this->clo_process_status.")");
		$this->insert_where("AND inpva_status in (".$this->clo_status.")");
	}else {
		$this->insert_where("AND COALESCE(inped_process_status, inpol_process_status) in (".$this->clo_process_status.")");
		$this->insert_where("AND COALESCE(inped_phase_status, inpol_status) in (".$this->clo_status.")");
	}

	$this->sql = $this->sql_begining."SELECT ".$this->sql_select."\n";
	
	//outer select
	if ($this->outer_select == 1) {
		$this->sql .= "into #temp";	
	}
	
	$this->sql .= "\nFROM \n".$this->sql_from."\n";
	
	$this->sql .= "\nWHERE \n".$this->sql_where."\n";
	
	if ($this->sql_group != "") {
		$this->sql .= "\nGROUP BY \n".$this->sql_group."\n";
	}
	
	if ($this->sql_having != "" ) {
		$this->sql .= "\nHAVING \n1=1\n".$this->sql_having."\n";
	}
	
	if ($this->sql_sort != "") {
		$this->sql .= "\nORDER BY \n".$this->sql_sort;
	}

	//outer select
	if ($this->outer_select == 1) {
		if ($this->outer_select_select == "") {
			$this->outer_select_select = '*';
		}
		
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
		if ($this->outer_select_sort != "") {
			$this->sql .= "ORDER BY ".$this->outer_select_sort."\n";
		}
		
	}
	
	//extra sql at the end if exists
	if ($this->sql_at_the_end != "") {
		$this->sql .= "\n".$this->sql_at_the_end;	
	}
}//generate_sql

function return_sql() {
	
	return $this->sql."\n\n\n\n\n";	
	
}//return sql

	
}//synhesis_production class


?>