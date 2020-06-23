<?

class installments_info {

	var $policy_serial;

	var $sql_select;
	var $sql_from;
	var $sql_where;
	var $sql_sort;
	var $sql_group;
	var $sql_having = "";
	var $sql;
	var $outer_select = 0;
	var $outer_select_select;
	var $outer_select_from;
	var $outer_select_where;
	var $outer_select_sort = "";
	var $outer_select_group;
	var $outer_select_having = "";

function installments_info($policy_serial) {
	
	$this->policy_serial = $policy_serial;
	
	$this->sql_select = "
		acmthead.acthe_docu_code ,
		acmthead.acthe_docu_nmbr ,
		acmthead.acthe_docu_date ,
		acmthead.acthe_docu_stat ,
		acminstallments.acinst_due_date ,
		acminstallments.acinst_amount ,
		acmthead.acthe_disputed_flag ,
		acmthead.acthe_orgn_modl ,
		ccexan_record_serial ,
		inpol_period_starting_date
	";

	$this->sql_from = "
		inpolicies
		JOIN inpolicyinstallment ON inpinst_policy_serial = inpol_policy_serial
		JOIN ccpextanalysis ON inpinst_installment_code = ccexan_analysis_code
		JOIN acminstallments ON acinst_installment_analysis_serial = ccexan_record_serial
		JOIN acmthead ON acinst_trans_auto_serial = acmthead.acthe_auto_serl
	";
	
	$this->sql_where = "
		acmthead.acthe_docu_stat in ('1','2')
		and ccpextanalysis.ccexan_analysis_type in ( 'IN' )
		AND inpol_policy_serial = ".$this->policy_serial."
	";
	
	$this->sql_sort = "
		acinst_due_date ASC,
		acinst_auto_serial ASC
	";
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

function generate_sql() {

	$this->sql = "SELECT \n".$this->sql_select."\n";
	
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
		$this->sql .= "\n\nSELECT\n".$this->outer_select_select."\n";
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
}//generate_sql

function return_sql() {
	
	return $this->sql."\n\n\n\n\n";	
	
}//return sql


}
?>