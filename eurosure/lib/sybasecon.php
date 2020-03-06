<?php
//include ("encoding_convert.php");
//$string_to_UTF8 = new utf8();

class SybaseCon {

var $connection;
var $connection_success = 'no';
var $num_rows = 0;
var $allow_query_select = 1;
var $allow_query_update = 1;
var $allow_query_delete = 1;
var $allow_query_insert = 1;
var $query_convert = 0;
var $username = 'php';
var $password = 'sql';


public function __construct($database = 'EUROTEST',$con_encoding = 'utf-8') {
	global $db;
//SET TEMPORARY OPTION date_order = 'DMY'; 
	if ($database == 'EUROSURE') {
		$db_to_connect = 'EUROSURE';
	}
	else if ($database == 'EUROTEST') {
		$db_to_connect = 'EUROTEST';
		$db->admin_footer_message = '<span style="color:#F00"><b>Sybase connection on EUROTEST established</b></span>';
	}
	else if ($database == 'SYSYSTEM') {
		$db_to_connect = 'SYSYSTEM';
	}

	/*
	if ($this->connection = odbc_connect($odbc,$this->username,$this->password))
		$this->connection_success = 'yes';
	else
		$this->connection_success = 'no';
	*/
	
	$this->connection = sasql_connect("host=126.0.0.4:2638;uid=dba;pwd=DBA$2325;charset=".$con_encoding.";DBN=".$db_to_connect);

	if ($this->connection) {
		$this->connection_success = 'yes';
		echo "YES";exit();


		$this->query("UPDATE ZZ_Login_Log
SET OS_User_Name = OS_User_Name || '-".$db->user_data["usr_username"]."-URI:".$_SERVER["REQUEST_URI"]."'
WHERE auto_serial = (SELECT FIRST a.auto_serial
					FROM ZZ_Login_Log a
					WHERE a.conn_id = (SELECT Connection_Property('number'))
					AND DATE(a.Login_Time) = Today()
					ORDER BY a.Auto_Serial DESC)");
	} else {
		$this->connection_success = 'no';
	}
}

public function query($sql,$convert=0) {
global $db;
//find what kind of query is
$type = substr($sql,0,strpos($sql,' '));
//now in each case check if each command is allowed
if ($type == 'SELECT' && $this->allow_query_select != 1) {
	return false;
}
if ($type == 'UPDATE' && $this->allow_query_update != 1) {
	return false;
}
if ($type == 'DELETE' && $this->allow_query_delete != 1) {
	return false;
}
if ($type == 'INSERT' && $this->allow_query_insert != 1) {
	echo "<hr>Insert Query Disabled <br>----------------------------<br>".$sql."<hr>";
}
	/*
	if ($convert == 1){
		global $string_to_UTF8;
		$sql = $string_to_UTF8->convert($sql,'UTF-8','WINDOWS-1253');
	}
	*/

	//if ($result = odbc_exec($this->connection,$sql)) {
	if ($result = sasql_query($this->connection,$sql)) {
		//$result2 = odbc_exec($this->connection,$sql);
		//odbc_fetch_row($result2);
		$this->num_rows = @sasql_num_rows($result);
		return $result;
	}
	else {
		echo $db->error(sasql_error($this->connection)."<br>".$db->prepare_text_as_html($sql));
	}

}

public function fetch_assoc($rs,$convert=1){
global $string_to_UTF8;

if ($this->query_convert == 1) {
	$convert = 1;	
}

	if ($line = sasql_fetch_assoc($rs)){

		foreach($line as $name => $value) {
			if ($convert != 0) {
				
				//no need to convert. the convertion now is done on the connection string
				//$line[$name] = $string_to_UTF8->convert($line[$name],'ASCII','UTF-8');
				//$line[$name] = $string_to_UTF8->convert($line[$name],'WINDOWS-1253','UTF-8');
			}
		}
		
	return $line;
	}
	else{
		return false;
	}
}//function fetch_assoc

public function query_fetch($sql,$convert=0) {

	$result = $this->query($sql);
	return $this->fetch_assoc($result,$convert);

}

public function num_rows() {
	return $this->num_rows;
}

public function fix_date($date) {
	$res = explode("/",$date);
	return $res[2]."-".$res[1]."-".$res[0];
}//fix date

//retrieves a specified account balance. provide the as at date with a format dd/mm/yyyy
public function get_account_balance($account,$as_at_date) {
	global $db;

	$sql = "
			SELECT
				COALESCE(SUM(dyn_table.clo_account_balance),0)as clo_total_balance
				FROM
				(
				SELECT
				'".$db->convert_date_format($as_at_date,'dd/mm/yyyy','yyyy-mm-dd')."' as clo_as_at_date,
				'Y' as clo_include_outstanding,
				ccac_acct_code,
				acbl_year_bfrw,
				/* FROM LINES */
				SUM(IF acthe_docu_stat = '1' THEN actln_main_amnt * actln_drmv_crmv ELSE 0 ENDIF) as clo_posted_balance_from_lines,
				SUM(IF acthe_docu_stat = '2' THEN actln_main_amnt * actln_drmv_crmv ELSE 0 ENDIF) as clo_outstanding_balance_from_lines,
				COALESCE((acbl_year_bfrw + clo_posted_balance_from_lines + IF clo_include_outstanding = 'Y' THEN clo_outstanding_balance_from_lines ELSE 0 ENDIF),acbl_year_bfrw) as clo_account_balance
				FROM ccmaccts
				JOIN acmblnce ON acbl_acct_serl = ccac_acct_serl AND acbl_fncl_year = YEAR(clo_as_at_date) AND acmblnce.acbl_crcy_code = 'EUR'
				JOIN acmtline ON actln_acct_serl = ccac_acct_serl
				LEFT OUTER JOIN acmthead ON acthe_auto_serl = actln_auto_serl AND acthe_docu_year = YEAR(clo_as_at_date) AND acthe_docu_stat IN ('1', '2') AND acthe_docu_date <= clo_as_at_date
				WHERE
				(ccac_acct_code LIKE '".$account."')
				GROUP BY ccac_acct_code, acbl_year_bfrw
				)as dyn_table
				WHERE
				1=1 ";

	$result = $this->query_fetch($sql);
	return $result["clo_total_balance"];	
	
}


}

//$sybase = odbc_connect("YDROTESTDB","php","sql");
//=======================================================================================================================================





class insurance_queries {

public function agent_production_per_product_periods_old($year,$month_from,$month_to,$agent,$product,$product_way = 'LIKE') {

	$sql = "SELECT  
(".$year.") as clo_year,           
(".$month_from.") as clo_period_from,
(".$month_to.") as clo_period_to,
(-1 * sum (IF clo_year = inped_year AND clo_period_to = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_to_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,           
inag_agent_code As clo_sort1,           
inity_major_category As clo_sort2,           
inag_long_description As clo_desc1,           
(Select incd_long_description From inpcodes where incd_record_type = '01' And incd_record_code = inity_major_category ) As clo_desc2

FROM ininsurancetypes  
LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code 
LEFT OUTER JOIN inminorcodes  ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,           
inpolicyendorsement ,           
inagents ,           
ingeneralagents ,           
inpparam    

WHERE ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs ) 
and          ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ( inpolicyendorsement.inped_status = '1' ) 
and          ( inpparam.inpr_module_code = 'IN' ) ) 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND clo_sort1 = '".$agent."' 
AND clo_sort2 ".$product_way." '".$product."' 

GROUP BY inpparam.inpr_module_code, clo_sort1, clo_desc1, clo_sort2, clo_desc2 
ORDER BY  clo_sort1 ASC , clo_sort2 ASC";
return $sql;
}

public function claims_details_per_claim() {
	return "SELECT  
inclaims.inclm_claim_number ,           
inpolicies.inpol_policy_number ,           
inagents.inag_agent_code ,           
inclients.incl_long_description ,           
inclients.incl_first_name ,           
initems.initm_item_code ,           
inclaims.inclm_process_status ,           
inclaims.inclm_date_of_event ,           
inclaims.inclm_status ,           
inclaims.inclm_open_date ,           
inagents.inag_agent_serial ,           
inclaims.inclm_claim_serial ,           
DATE('2009/06/30') as clo_as_at_date,           
space(060) as clo_sort1,           
space(060) as clo_sort2,           
space(060) as clo_sort3,           
space(180) as clo_desc1,           
space(180) as clo_desc2,           
space(180) as clo_desc3,           
IF clo_process_status IN ('C', 'W') THEN inclm_closed_period ELSE 0 ENDIF  AS clo_closed_period,           
IF clo_process_status IN ('C', 'W') THEN inclm_closed_year ELSE 0 ENDIF  AS clo_closed_year,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6') ,0) as clo_amount_paid,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_recoveries_recieved,           
COALESCE((Select sum(inirq_value * inirq_debit_credit) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'), 0) as clo_payments_recovery_exp,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6'),0) as clo_estimated_reserve,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_estimated_recoveries,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'),0) as clo_estimated_rec_expence_reserve,     
      
CASE inclm_process_status WHEN 'C' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 THEN 'O' ELSE IF clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE 'C' ENDIF ENDIF WHEN 'R' THEN IF clo_estimated_reserve - clo_amount_paid - (clo_estimated_rec_expence_reserve - clo_payments_recovery_exp) <> 0 THEN 'O' ELSE 'R' ENDIF WHEN 'W' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 OR clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'O' ELSE 'W' ENDIF WHEN 'O' THEN IF clo_estimated_reserve = 0 AND clo_estimated_recoveries = 0 THEN 'P' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved = 0 THEN 'C' ELSE 'O' ENDIF ENDIF ENDIF ELSE inclm_process_status END as clo_process_status 

FROM inclaims  
LEFT OUTER JOIN initems  ON inclaims.inclm_item_serial = initems.initm_item_serial ,           
inclients ,           
inpolicies ,           
inagents ,           
ingeneralagents ,           
ininsurancetypes    

WHERE ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( inclaims.inclm_policy_serial = inpolicies.inpol_policy_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( ( inclaims.inclm_open_date <= clo_as_at_date ) 
and          ( inclaims.inclm_process_status <> 'I') 
and          ( inclaims.inclm_status <> 'D') )  
AND  1=1  
AND inclm_status in ('O','A','D') 
AND clo_process_status in ('P','O','W','R','C') 

AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('2009/01/01') * 100) + MONTH('2009/01/01') OR clo_closed_year = 0) ORDER BY 28         ASC  ,inclm_claim_number ASC";

}

public function claims_oustanding_payments($asatdate,$from_period,$agent,$product,$product_way = 'LIKE',$extra_sql = '' ){
	return "SELECT  
inagents.inag_agent_code ,             
inagents.inag_agent_serial ,           
         
DATE('".$asatdate."') as clo_as_at_date,                 
IF clo_process_status IN ('C', 'W') THEN inclm_closed_period ELSE 0 ENDIF  AS clo_closed_period,           
IF clo_process_status IN ('C', 'W') THEN inclm_closed_year ELSE 0 ENDIF  AS clo_closed_year,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6') ,0) as clo_amount_paid,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_recoveries_recieved,           
COALESCE((Select sum(inirq_value * inirq_debit_credit) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'), 0) as clo_payments_recovery_exp,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6'),0) as clo_estimated_reserve,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_estimated_recoveries,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'),0) as clo_estimated_rec_expence_reserve,           
CASE inclm_process_status WHEN 'C' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 THEN 'O' ELSE IF clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE 'C' ENDIF ENDIF WHEN 'R' THEN IF clo_estimated_reserve - clo_amount_paid - (clo_estimated_rec_expence_reserve - clo_payments_recovery_exp) <> 0 THEN 'O' ELSE 'R' ENDIF WHEN 'W' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 OR clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'O' ELSE 'W' ENDIF WHEN 'O' THEN IF clo_estimated_reserve = 0 AND clo_estimated_recoveries = 0 THEN 'P' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved = 0 THEN 'C' ELSE 'O' ENDIF ENDIF ENDIF ELSE inclm_process_status END as clo_process_status 

FROM inclaims  
LEFT OUTER JOIN initems  ON inclaims.inclm_item_serial = initems.initm_item_serial ,           
inclients ,           
inpolicies ,           
inagents ,           
ingeneralagents ,           
ininsurancetypes    

WHERE ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( inclaims.inclm_policy_serial = inpolicies.inpol_policy_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( ( inclaims.inclm_open_date <= clo_as_at_date ) 
and          ( inclaims.inclm_process_status <> 'I') 
and          ( inclaims.inclm_status <> 'D') )  
AND  1=1  
AND inclm_status in ('O','A') 
AND clo_process_status in ('P','O','W','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".substr($asatdate,0,4)."/".$from_period."/01') * 100) + MONTH('".substr($asatdate,0,4)."/".$from_period."/01') OR clo_closed_year = 0) 
AND inagents.inag_agent_code = '".$agent."'
AND inity_major_category ".$product_way." '".$product."'
".$extra_sql."
ORDER BY inagents.inag_agent_code ASC";
}


public function claims_oustanding_payments_updated($asatdate,$from_period,$year,$agent,$product,$product_way = 'LIKE',$extra_sql = '' , $extra_select = ''){
	return "SELECT  
inagents.inag_agent_code ,             
inagents.inag_agent_serial ,           
         
DATE('".$asatdate."') as clo_as_at_date,                 
IF clo_process_status IN ('C', 'W') THEN inclm_closed_period ELSE 0 ENDIF  AS clo_closed_period,           
IF clo_process_status IN ('C', 'W') THEN inclm_closed_year ELSE 0 ENDIF  AS clo_closed_year,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6') ,0) as clo_amount_paid,           
COALESCE((Select sum(inirq_debit_credit * inirq_value) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_recoveries_recieved,           
COALESCE((Select sum(inirq_value * inirq_debit_credit) from inclaimrecpayrequests, inpcodes where inirq_claim_serial = inclaims.inclm_claim_serial AND inirq_proposed_pay_date <= clo_as_at_date AND inirq_status = '1' AND inirq_against_reserve = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'), 0) as clo_payments_recovery_exp,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6'),0) as clo_estimated_reserve,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C5'),0) as clo_estimated_recoveries,           
COALESCE((Select sum(inclr_debit_credit * inclr_value) From inclaimreserves, inpcodes Where inclr_claim_serial = inclaims.inclm_claim_serial AND inclr_date <= clo_as_at_date AND inclr_status = '1' AND inclr_code_serial = incd_pcode_serial AND incd_reserve_type = 'C6' AND incd_reset_on_recovery = 'N'),0) as clo_estimated_rec_expence_reserve,           
CASE inclm_process_status WHEN 'C' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 THEN 'O' ELSE IF clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE 'C' ENDIF ENDIF WHEN 'R' THEN IF clo_estimated_reserve - clo_amount_paid - (clo_estimated_rec_expence_reserve - clo_payments_recovery_exp) <> 0 THEN 'O' ELSE 'R' ENDIF WHEN 'W' THEN IF clo_estimated_reserve - clo_amount_paid <> 0 OR clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'O' ELSE 'W' ENDIF WHEN 'O' THEN IF clo_estimated_reserve = 0 AND clo_estimated_recoveries = 0 THEN 'P' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved <> 0 THEN 'R' ELSE IF clo_estimated_reserve - clo_amount_paid = 0 AND clo_estimated_recoveries - clo_recoveries_recieved = 0 THEN 'C' ELSE 'O' ENDIF ENDIF ENDIF ELSE inclm_process_status END as clo_process_status,
(SELECT indr_birth_date FROM indrivers WHERE indr_driver_serial = inclm_driver_serial)as clo_driver_birth_date,
(SELECT indr_permit_date FROM indrivers WHERE indr_driver_serial = inclm_driver_serial)as clo_driver_licence_date,
COALESCE(fn_evaluate_age(clo_driver_birth_date,inclm_date_of_event),0)as clo_driver_age,
COALESCE(fn_evaluate_age(clo_driver_licence_date,inclm_date_of_event),0)as clo_driver_licence_years,
inclm_claim_serial
".$extra_select."

FROM inclaims  
LEFT OUTER JOIN initems  ON inclaims.inclm_item_serial = initems.initm_item_serial ,           
inclients ,           
inpolicies ,           
inagents ,           
ingeneralagents ,           
ininsurancetypes    

WHERE ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( inclaims.inclm_policy_serial = inpolicies.inpol_policy_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( ( inclaims.inclm_open_date <= clo_as_at_date ) 
and          ( inclaims.inclm_process_status <> 'I') 
and          ( inclaims.inclm_status <> 'D') )  
AND  1=1  
AND inclm_status in ('O','A') 
AND clo_process_status in ('P','O','W','R','C') 
AND (((clo_closed_year * 100) + clo_closed_period) >= (YEAR('".$year."/".$from_period."/01') * 100) + MONTH('".$year."/".$from_period."/01') OR clo_closed_year = 0) 
AND inagents.inag_agent_code LIKE '".$agent."'
AND LEFT(inclm_claim_number , '2') ".$product_way." '".$product."'
".$extra_sql."
ORDER BY inagents.inag_agent_code ASC";

}

public function agent_production_per_product_periods($year,$month_from,$month_to,$agent,$klados,$klados_way = 'LIKE',$product = '%%',$extra_sql = '') {

	$sql = "SELECT  
('".$year."') as clo_year,           
('".$month_from."') as clo_period_from,
('".$month_to."') as clo_period_to,
(-1 * sum (IF clo_year = inped_year AND clo_period_to = inped_period THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_period_to_premium,
(-1 * sum(IF clo_year = inped_year AND inped_period <= clo_period_to AND inped_period >= clo_period_from THEN inpolicyendorsement.inped_premium_debit_credit * inpolicyendorsement.inped_premium ELSE 0 ENDIF)) As clo_ytd_premium,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_mif)) As clo_period_mif,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_fees)) AS clo_period_fees,
(-1 * sum(inpolicyendorsement.inped_premium_debit_credit * inped_stamps)) AS clo_period_stamps,
SUM((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5','C6','C7','C8','C9') AND intrd_owner = 'O'))as clo_commission,
inag_agent_code As clo_sort1,           
inity_major_category As clo_sort2,  
inity_insurance_type AS clo_sort3,
inpol_policy_number,
inpol_period_starting_date,
inpol_process_status,
inpol_status,

         
inag_long_description As clo_desc1,           
(Select incd_long_description From inpcodes where incd_record_type = '01' And incd_record_code = inity_major_category ) As clo_desc2

FROM ininsurancetypes  
LEFT OUTER JOIN inmajorcodes  ON ininsurancetypes.inity_major_category = inmajorcodes.incd_record_code
LEFT OUTER JOIN inminorcodes  ON ininsurancetypes.inity_minor_category = inminorcodes.incd_record_code ,           
inpolicies ,           
inpolicyendorsement ,           
inagents ,           
ingeneralagents ,           
inpparam    

WHERE ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs ) 
and          ( inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial ) 
and          ( ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( ( inpolicyendorsement.inped_status = '1' ) 
and          ( inpparam.inpr_module_code = 'IN' ) ) 
AND  1=1  
AND (inped_year*100+inped_period) >= (clo_year*100+clo_period_from) 
AND (inped_year*100+inped_period) <= (clo_year*100+clo_period_to) 
AND clo_sort1 LIKE '".$agent."' 
AND clo_sort2 ".$klados_way." '".$klados."'
AND clo_sort3 LIKE '".$product."'
".$extra_sql."

GROUP BY inpparam.inpr_module_code, clo_sort1, clo_desc1, clo_sort2, clo_desc2 ,clo_sort3,inpol_policy_number,inpol_period_starting_date,inpol_process_status,inpol_status
ORDER BY  clo_sort1 ASC , clo_sort2 ASC , clo_sort3 ASC";
return $sql;

}//function agent_production_per_product_periods


public function agent_production_per_product_periods_process_status($year,$month_from,$month_to,$agent,$klados,$klados_way = 'LIKE',$product = '%%') {

$sql = "  
SELECT  inpolicies.inpol_policy_number ,
inclients.incl_first_name ,
inclients.incl_long_description ,
inagents.inag_agent_code ,
inagents.inag_long_description ,
inpolicies.inpol_policy_serial ,
inag_agent_code as clo_sort1,
space(060) as clo_sort2,
space(060) as clo_sort3,
ingeneralagents.inga_agent_code ,
ingeneralagents.inga_long_description ,
inag_short_description as clo_desc1,
space(180) as clo_desc2,
space(180) as clo_desc3,
inped_process_status,

-1 * (inped_fees * inped_premium_debit_credit) as clo_fees,
-1 * (inped_stamps * inped_premium_debit_credit) as clo_stamps,
-1 * (inped_x_premium * inped_premium_debit_credit) as clo_x_premium,
-1 * (inped_premium * inped_premium_debit_credit) as clo_premium,
-1 * (inped_mif * inped_premium_debit_credit) as clo_mif,

COALESCE((SELECT LIST(DISTINCT intrh_document_number) FROM intransactiondetails, intransactionheaders WHERE intrd_policy_serial = inpol_policy_serial AND intrd_endorsement_serial = IF inped_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF inped_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF AND intrd_trh_auto_serial = intrh_auto_serial AND intrd_related_type IN ('A', 'C')), '') As clo_document_number,
SPACE(1) as CLO_PR,



SPACE(2) as CLO_MF,


IF inped_process_status = 'E' THEN (SELECT oldpol.inpol_process_status FROM inpolicies oldpol WHERE oldpol.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial) ELSE '' ENDIF as clo_replacing_policy_pstatus,

SPACE(3) as CLO_COMMISSIONS,
COALESCE((SELECT SUM(intrd_value * intrd_debit_credit)  * -1 FROM intransactiondetails WHERE intrd_policy_serial = inpol_policy_serial AND (intrd_endorsement_serial = IF inped_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE IF inped_process_status <> 'L' THEN inpol_last_endorsement_serial ELSE 0 ENDIF ENDIF) AND COALESCE(intrd_claim_serial, 0) = 0 AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_status <> '9' /*Excl.Deleted*/ AND intrd_related_type = IF inga_branch_agent = 'B' THEN 'A' ELSE 'G' ENDIF), 0) as clo_commission_charge,
IF inped_process_status = 'E' THEN COALESCE((SELECT SUM(intrd_value * intrd_debit_credit) FROM intransactiondetails, inpolicies a WHERE a.inpol_policy_serial = inpolicies.inpol_replacing_policy_serial AND intrd_policy_serial = a.inpol_policy_serial AND intrd_endorsement_serial = a.inpol_last_cancellation_endorsement_serial AND COALESCE(intrd_claim_serial, 0) = 0 AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_status <> '9' /*Excl.Deleted*/ AND intrd_related_type = IF inga_branch_agent = 'B' THEN 'A' ELSE 'G' ENDIF), 0) ELSE 0 ENDIF as clo_commission_reduction,
clo_commission_charge - clo_commission_reduction as clo_commission_net,
COALESCE((SELECT FIRST intrd_related_serial FROM intransactiondetails WHERE intrd_policy_serial = inpol_policy_serial AND (intrd_endorsement_serial = IF inped_process_status = 'C' THEN inpol_last_cancellation_endorsement_serial ELSE inpol_last_endorsement_serial ENDIF) AND COALESCE(intrd_claim_serial, 0) = 0 AND intrd_status <> '9' /*Excl.Deleted*/ AND intrd_transaction_type IN ('C0', 'C1','C2','C3','C4','C5','CF') AND intrd_related_type = 'A'), 0) as clo_commission_agent,
IF clo_commission_agent <> inpol_agent_serial THEN (SELECT a.inag_agent_code FROM inagents a WHERE a.inag_agent_serial = clo_commission_agent) ELSE '' ENDIF as clo_commission_agent_code,
inity_major_category,
inity_insurance_type


FROM 
inpolicies  LEFT OUTER JOIN intemplates  ON inpolicies.inpol_template_serial = intemplates.intmpl_template_serial ,
inclients ,
inagents ,
inpolicyendorsement ,
ininsurancetypes ,
ingeneralagents    

WHERE ( inpolicies.inpol_client_serial = inclients.incl_client_serial ) 
and          ( ininsurancetypes.inity_insurance_type_serial = inpolicies.inpol_insurance_type_serial ) 
and          ( inpolicies.inpol_general_agent_serial = ingeneralagents.inga_agent_serial ) 
and          ( inpolicies.inpol_agent_serial = inagents.inag_agent_serial ) 
and          ( inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs ) 

AND  1=1  
AND inpol_status IN ('A','N') 
AND (inped_year*100+inped_period)>=(".$year."*100+".$month_from.") 
AND (inped_year*100+inped_period)<=(".$year."*100+".$month_to.") 
AND clo_sort1 = '".$agent."' 
AND inity_major_category ".$klados_way." '".$klados."'
AND inity_insurance_type LIKE '".$product."'

ORDER BY  
clo_sort1 ASC ,
inpol_policy_number ASC ";
return $sql;

//AND LEFT(clo_process_status, 1) IN ('".$status."') 

}//function agent_production_per_product_periods_process_status


function agent_production_per_product_periods_per_loading($year,$month_from,$month_to,$agent,$klados,$klados_way = 'LIKE',$product = '%%',$extra_sql = '') {

$sql = "
SELECT
inpol_policy_serial
,inldg_loading_serial
,inpol_policy_period as clo_policy_period,inpol_policy_year as clo_policy_year
,inity_insurance_type
,inldg_loading_code
,inldg_long_description
,-1 * SUM((if inped_premium_debit_credit = -1 then inplg_period_premium else inplg_return_premium endif)* inped_premium_debit_credit)as clo_total_premium
,incd_ldg_rsrv_under_reinsurance
,inldg_commission_assigned
FROM
inpolicies
JOIN inpolicyloadings ON inplg_policy_serial = inpol_policy_serial
JOIN inloadings ON inldg_loading_serial = inplg_loading_serial
JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial
JOIN inpolicyendorsement ON inped_policy_serial = inpol_policy_serial
LEFT OUTER JOIN inpcodes ON inldg_claim_reserve_group = incd_pcode_serial
JOIN inagents ON inag_agent_serial = inpol_agent_serial

WHERE
1=1
AND inped_year = '".$year."'
AND inped_period BETWEEN '".$month_from."' AND '".$month_to."'
AND inity_insurance_type ".$klados_way." '".$klados."'
AND inag_agent_code = '".$agent."'
AND inity_insurance_type LIKE '".$product."'
".$extra_sql."

AND inped_status = 1
GROUP BY inpol_policy_serial,clo_policy_year,clo_policy_period,inldg_loading_serial
,inldg_loading_code,inldg_long_description,inity_insurance_type,incd_ldg_rsrv_under_reinsurance,inldg_commission_assigned

ORDER BY inity_insurance_type,inpol_policy_serial,inldg_loading_serial";

return $sql;
}


}

?>