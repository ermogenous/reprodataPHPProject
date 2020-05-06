<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 05/05/2020
 * Time: 11:11
 */

ini_set('max_execution_time', 1800);
ini_set('memory_limit','4096M');

include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
include('../../lib/odbccon.php');
include('../../../tools/MEBuildExcel.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Reports - Actuary - Policy Transactions";

if ($_POST['action'] == 'execute'){
    $sybase = new ODBCCON();

    if ($_POST['fld_report_type'] == 'Motor') {
        makeReportMotor($_POST['fld_as_at_date'], true);
    }
    else {
        makeReportOther($_POST['fld_as_at_date'],$_POST['fld_report_type'], true);
    }

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
                <form name="myForm" id="myForm" method="post" action="" onsubmit="" target="_blank"
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Reports - Actuary - Policy Transactions</b></div>
                    </div>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_report_type')
                            ->setFieldDescription('Report Type')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('select')
                            ->setInputSelectArrayOptions([
                                'Motor' => 'Motor',
                                'FIRE' => 'Fire',
                                'PERSONAL' => 'Miscellaneous/Personal',
                                'LIABILITY' => 'Liability',
                            ])
                            ->setInputValue($_POST['fld_report_type'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
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


function makeReportMotor($asAtDate, $excelFile = true){
    global $sybase,$db;

    $asAtSplit = explode("/",$asAtDate);

    $sql = "
    BEGIN
	Declare ld_asat_date Date;

	Set ld_asat_date = '".$asAtSplit[2]."/".$asAtSplit[1]."/".$asAtSplit[0]."';
	
	IF (SELECT COUNT() FROM ccuserparameters) = 0 THEN
		INSERT INTO ccuserparameters (ccusp_user_date) VALUES (ld_asat_date);
	ELSE 
		UPDATE ccuserparameters
		SET ccusp_user_date = ld_asat_date;
	ENDIF;

/*
	SELECT inped_year, 
			SUM(clo_gwp) as clo_yr_pr, 
			SUM(IF clo_cover_code = 'TP' THEN clo_gwp ELSE 0 ENDIF) as clo_yr_pr_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_gwp ELSE 0 ENDIF) as clo_yr_pr_od,
			SUM(clo_commission_pr_amnt) as clo_yr_commission_pr,
			SUM(IF clo_cover_code = 'TP' THEN clo_commission_pr_amnt ELSE 0 ENDIF) as clo_yr_commission_pr_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_commission_pr_amnt ELSE 0 ENDIF) as clo_yr_commission_pr_od,
			SUM(clo_commission_fee_amnt) as clo_yr_commission_fee,
			SUM(IF clo_cover_code = 'TP' THEN clo_commission_fee_amnt ELSE 0 ENDIF) as clo_yr_commission_fee_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_commission_fee_amnt ELSE 0 ENDIF) as clo_yr_commission_fee_od,
			SUM(clo_mif_amnt) as clo_yr_mif,
			SUM(IF clo_cover_code = 'TP' THEN clo_mif_amnt ELSE 0 ENDIF) as clo_yr_mif_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_mif_amnt ELSE 0 ENDIF) as clo_yr_mif_od,
			SUM(clo_fees) as clo_yr_fees,
			SUM(clo_ri_premium) as clo_yr_ri_premium,
			SUM(IF clo_cover_code = 'TP' THEN clo_ri_premium ELSE 0 ENDIF) as clo_yr_ri_premium_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_ri_premium ELSE 0 ENDIF) as clo_yr_ri_premium_od,
			SUM(clo_ri_mif) as clo_yr_ri_mif,
			SUM(IF clo_cover_code = 'TP' THEN clo_ri_mif ELSE 0 ENDIF) as clo_yr_ri_mif_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_ri_mif ELSE 0 ENDIF) as clo_yr_ri_mif_od,
			SUM(clo_ri_commission) as clo_yr_ri_commission,
			SUM(IF clo_cover_code = 'TP' THEN clo_ri_commission ELSE 0 ENDIF) as clo_yr_ri_commission_tp,
			SUM(IF clo_cover_code = 'OD' THEN clo_ri_commission ELSE 0 ENDIF) as clo_yr_ri_commission_od,
			SUM(IF clo_policy_in_force = 'YES' THEN clo_gwp ELSE 0 ENDIF) as clo_yr_pr_in_force, 
			SUM(IF clo_policy_in_force = 'YES' AND clo_cover_code = 'TP' THEN clo_gwp ELSE 0 ENDIF) as clo_yr_pr_tp_in_force,
			SUM(IF clo_policy_in_force = 'YES' AND clo_cover_code = 'OD' THEN clo_gwp ELSE 0 ENDIF) as clo_yr_pr_od_in_force
	FROM (*/
	SELECT clo_policy_link, inpol_policy_number, clo_doc_ref,
			clo_cancelled, clo_policy_in_force, inped_year, inped_period,
			clo_transaction_type, clo_tran_num, clo_policy_start, clo_policy_expiry, 
			clo_tran_start, clo_tran_expiry, clo_on_effect, clo_off_effect,
			clo_days1, clo_days2, clo_days3, 
			clo_expiry_days, clo_cover_code, 
			SUM(clo_premium) as clo_gwp, 
			SUM(clo_mif) as clo_mif_amnt,
			SUM(clo_comm_premium) as clo_commission_pr_amnt,
			SUM(clo_comm_fee) as clo_commission_fee_amnt,
			intrh_document_date, inpol_commission_percentage,
			clo_acnt_code, clo_uw_year,
			IF clo_ri_percentage > 0 THEN 'YES' ELSE 'NO' ENDIF as clo_ri,
			SUM(clo_ped_fees) as clo_fees,
			SUM(clo_pri_premium) as clo_ri_premium,
			SUM(clo_pri_mif) as clo_ri_mif,
			SUM(clo_pri_commission) as clo_ri_commission			
		  -- ALL POLICIES TP COVER --
	FROM (SELECT STRING(inpol_policy_number,'/',clo_doc_ref) as clo_policy_link, 
				inpol_policy_number,
				COALESCE(intrh_document_number, '?')as clo_doc_ref,
				'' as clo_cancelled,
				IF inpva_policy_serial IS NULL THEN 'NO' ELSE 'YES' ENDIF as clo_transaction_in_force,
				IF (SELECT COUNT() FROM inpoliciesactive pva 
					WHERE pva.inpva_policy_number = inpolicies.inpol_policy_number
					AND pva.inpva_period_starting_date = inpolicies.inpol_period_starting_date) > 0 THEN 'YES' ELSE 'NO' 
				ENDIF as clo_policy_in_force,
				inped_year, inped_period,
				CASE 
				WHEN inped_process_status = 'C' THEN 'CANOG'
				WHEN inped_process_status in( 'E','D' ) THEN /* SS 02/06/2016 Also for Decl.Adj. */
					IF -1*(SELECT SUM(a.inped_premium_debit_credit*a.inped_premium) FROM inpolicyendorsement as a
								WHERE a.inped_financial_policy_abs = inpolicyendorsement.inped_financial_policy_abs
								AND a.inped_process_status = inpolicyendorsement.inped_process_status) >= 0 THEN 'ADDOG' ELSE 'RETOG' ENDIF
				WHEN inped_process_status = 'N' then 'NEWOG'
				WHEN inped_process_status = 'R' then 'RNLOG'
				ELSE '' END as clo_transaction_type,
				'' as clo_tran_num,
				inpol_period_starting_date as clo_policy_start,
				inpol_expiry_date as clo_policy_expiry,
				CASE 
				WHEN inped_process_status = 'C' AND inpol_full_cancellation = 'Y' THEN inpol_period_starting_date
				ELSE inpol_starting_date 
				END as clo_tran_start,
				CASE 
				WHEN inped_process_status = 'C' AND inpol_full_cancellation = 'Y' THEN inpol_expiry_date
				WHEN inped_process_status = 'C' THEN DATEADD( DAY, -1, inpol_cancellation_date) 
				ELSE inpol_expiry_date 
				END as clo_tran_expiry,
				'' as clo_on_effect,
				'' as clo_off_effect,
				DATEDIFF(day, inpol_period_starting_date, inpol_expiry_date) +1 as clo_days1,
				DATEDIFF(day, inpol_starting_date, inpol_expiry_date)+ 1 as clo_days2,
				clo_days1 - clo_days2 as clo_days3,
				IF inpol_expiry_date > ld_asat_date THEN DATEDIFF(Day, ld_asat_date, inpol_expiry_date) ELSE 0 ENDIF as clo_expiry_days,
				'TP' as clo_cover_code,
				(-1 * inped_premium_debit_credit * inped_premium_tp) as clo_premium,
				(ROUND(clo_premium * 0.05, 2)) as clo_mif,
				IF COALESCE(inped_issue_date,TODAY()) <= COALESCE(inity_initiate_issuing,'1900/01/01') THEN
					ROUND(clo_premium * inpol_commission_percentage / 100.0, 2) /* CONVERTED DATA - NO TRANSACTIONS */ 
				ELSE
					COALESCE((SELECT SUM(intrd_value*intrd_debit_credit)
						FROM intransactiondetails
						WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial
						AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial
						AND COALESCE(intrd_claim_serial,0) = 0
						AND intrd_transaction_type in( 'C0','C1','C2','C3','C4','C5','C6','C7','C8','C9','CA' ) 
						AND intrd_owner = 'O'
						AND intrd_status <> '9'),0)
				ENDIF as clo_comm_premium,
				IF (inped_process_status <> 'C') OR
					(inped_process_status = 'C' AND 
					 ((inpol_full_cancellation = 'Y' AND inped_year  >= 2018) OR 
					  (inpol_cancellation_date = inpol_period_starting_date AND inped_year < 2018)
					 )
					) THEN inpol_commission_percentage_fees ELSE 0 ENDIF as clo_commission_percentage_fees,
				IF COALESCE(inped_issue_date,TODAY()) <= COALESCE(inity_initiate_issuing,'1900/01/01') THEN
					ROUND(clo_ped_fees * clo_commission_percentage_fees / 100.0, 2) 
				ELSE 
					COALESCE((SELECT SUM(intrd_value*intrd_debit_credit)
						FROM intransactiondetails
						WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial
						AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial
						AND COALESCE(intrd_claim_serial,0) = 0
						AND intrd_transaction_type IN ('CF') 
						AND intrd_owner = 'O'
						AND intrd_status <> '9'),0)
				ENDIF as clo_comm_fee,
				intrh_document_date,
				inpol_commission_percentage,
				IF inag_agent_code in( 'AE001','AE002','AE003' ) then SUBSTR(REPLACE(incl_account_code, inag_agent_code, ''), 5) 
				ELSE inag_agent_code ENDIF as clo_acnt_code,
				YEAR(inpol_period_starting_date) as clo_uw_year,
				(IF CASE WHEN inpol_cover = 'A' THEN 'TP' ELSE 'OD' END = clo_cover_code THEN -1 * inped_premium_debit_credit * inped_fees ELSE 0 ENDIF) as clo_ped_fees,
				COALESCE((SELECT SUM(inpri_reinsurance_percentage) FROM inpolicyreinsurance 
							 WHERE inpri_policy_serial = inpol_policy_serial					-- inped_policy_serial
							 AND inpri_endorsement_serial = inpol_last_endorsement_serial	-- inped_endorsement_serial
							), 0) as clo_ri_percentage,
				(inped_reinsurance_debit_credit * ROUND(inped_premium_tp * clo_ri_percentage / 100.0, 2)) as clo_pri_premium,
				ROUND(clo_pri_premium * 0.05, 2) as clo_pri_mif,
				(clo_pri_premium * 
				 ROUND(COALESCE((SELECT SUM(inpri_commission_percentage) FROM inpolicyreinsurance 
										WHERE inpri_policy_serial = inpol_policy_serial 
										AND inpri_endorsement_serial = inpol_last_endorsement_serial), 0) / 100, 2)
				) as clo_pri_commission,
			
				COALESCE((SELECT DISTINCT intrd_trh_auto_serial
								FROM intransactiondetails 
								WHERE intrd_policy_serial = inped_policy_serial
								AND intrd_endorsement_serial = inped_endorsement_serial
								AND intrd_claim_serial = 0
								AND intrd_related_type = 'C'
								AND intrd_status IN ('1','2')),
							(SELECT DISTINCT intrd_trh_auto_serial
								FROM intransactiondetails 
								WHERE intrd_policy_serial = inped_policy_serial
								AND intrd_endorsement_serial = inped_endorsement_serial
								AND intrd_claim_serial = 0
								AND intrd_related_type = 'A'
								AND intrd_status IN ('1','2'))) as clo_trh_auto,
				inped_financial_policy_abs
			FROM inpolicyendorsement
				JOIN inpolicies 
					ON inpol_policy_serial = inped_financial_policy_abs
				JOIN inclients 
					ON incl_client_serial = inpol_client_serial
				JOIN inagents
					ON inag_agent_serial = inpol_agent_serial
				JOIN ininsurancetypes 
					ON inity_insurance_type_serial = inpol_insurance_type_serial
				LEFT OUTER JOIN intransactionheaders 
					ON intrh_auto_serial = clo_trh_auto
				LEFT OUTER JOIN inpoliciesactive ON inpva_policy_serial = inpol_policy_serial
			WHERE inity_insurance_form = 'M'
				AND inped_status = '1'
				AND inped_process_status <> 'L'
				AND inped_year >= YEAR(ld_asat_date) -1
				AND inped_year * 100 + inped_period <= YEAR(ld_asat_date) * 100 + MONTH(ld_asat_date)
		) AS DT_PED
		GROUP BY clo_policy_link, inpol_policy_number, clo_doc_ref,
			clo_cancelled, clo_policy_in_force, inped_year, inped_period,
			clo_transaction_type, clo_tran_num, clo_policy_start, clo_policy_expiry, 
			clo_tran_start, clo_tran_expiry, clo_on_effect, clo_off_effect,
			clo_days1, clo_days2, clo_days3, 
			clo_expiry_days, clo_cover_code, intrh_document_date, inpol_commission_percentage,
			clo_acnt_code, clo_uw_year,
			clo_ri
			
	UNION ALL -- POLICIES F&T or COMPREHENSIVE --
	
	SELECT clo_policy_link, inpol_policy_number, clo_doc_ref,
			clo_cancelled, clo_policy_in_force, inped_year, inped_period,
			clo_transaction_type, clo_tran_num, clo_policy_start, clo_policy_expiry, 
			clo_tran_start, clo_tran_expiry, clo_on_effect, clo_off_effect,
			clo_days1, clo_days2, clo_days3, 
			clo_expiry_days, clo_cover_code, 
			SUM(clo_premium) as clo_gwp, 
			SUM(clo_mif) as clo_mif_amnt,
			SUM(clo_comm_premium) as clo_commission_pr_amnt,
			SUM(clo_comm_fee) as clo_commission_fee_amnt,
			intrh_document_date, inpol_commission_percentage,
			clo_acnt_code, clo_uw_year,
			IF clo_ri_percentage > 0 THEN 'YES' ELSE 'NO' ENDIF as clo_ri,
			SUM(clo_ped_fees) as clo_fees,
			SUM(clo_pri_premium) as clo_ri_premium,
			SUM(clo_pri_mif) as clo_ri_mif,
			SUM(clo_pri_commission) as clo_ri_commission			
	FROM (SELECT STRING(inpol_policy_number,'/',clo_doc_ref) as clo_policy_link, 
				inpol_policy_number,
				COALESCE(intrh_document_number, '?')as clo_doc_ref,
				'' as clo_cancelled,
				IF inpva_policy_serial IS NULL THEN 'NO' ELSE 'YES' ENDIF as clo_transaction_in_force,
				IF (SELECT COUNT() FROM inpoliciesactive pva 
					WHERE pva.inpva_policy_number = inpolicies.inpol_policy_number
					AND pva.inpva_period_starting_date = inpolicies.inpol_period_starting_date) > 0 THEN 'YES' ELSE 'NO' 
				ENDIF as clo_policy_in_force,
				inped_year, inped_period,
				CASE 
				WHEN inped_process_status = 'C' THEN 'CANOG'
				WHEN inped_process_status in( 'E','D' ) THEN /* SS 02/06/2016 Also for Decl.Adj. */
					IF -1*(SELECT SUM(a.inped_premium_debit_credit*a.inped_premium) FROM inpolicyendorsement as a
								WHERE a.inped_financial_policy_abs = inpolicyendorsement.inped_financial_policy_abs
								AND a.inped_process_status = inpolicyendorsement.inped_process_status) >= 0 THEN 'ADDOG' ELSE 'RETOG' ENDIF
				WHEN inped_process_status = 'N' then 'NEWOG'
				WHEN inped_process_status = 'R' then 'RNLOG'
				ELSE '' END as clo_transaction_type,
				'' as clo_tran_num,
				inpol_period_starting_date as clo_policy_start,
				inpol_expiry_date as clo_policy_expiry,
				CASE 
				WHEN inped_process_status = 'C' AND inpol_full_cancellation = 'Y' THEN inpol_period_starting_date
				ELSE inpol_starting_date 
				END as clo_tran_start,
				CASE 
				WHEN inped_process_status = 'C' AND inpol_full_cancellation = 'Y' THEN inpol_expiry_date
				WHEN inped_process_status = 'C' THEN DATEADD( DAY, -1, inpol_cancellation_date) 
				ELSE inpol_expiry_date 
				END as clo_tran_expiry,
				'' as clo_on_effect,
				'' as clo_off_effect,
				DATEDIFF(day, inpol_period_starting_date, inpol_expiry_date) +1 as clo_days1,
				DATEDIFF(day, inpol_starting_date, inpol_expiry_date)+ 1 as clo_days2,
				clo_days1 - clo_days2 as clo_days3,
				IF inpol_expiry_date > ld_asat_date THEN DATEDIFF(Day, ld_asat_date, inpol_expiry_date) ELSE 0 ENDIF as clo_expiry_days,
				'OD' as clo_cover_code,
				(-1 * inped_premium_debit_credit * inped_premium_od) as clo_premium,
				(ROUND(clo_premium * 0.05, 2)) as clo_mif,
				IF COALESCE(inped_issue_date,TODAY()) <= COALESCE(inity_initiate_issuing,'1900/01/01') THEN
					ROUND(clo_premium * inpol_commission_percentage / 100.0, 2) /* CONVERTED DATA - NO TRANSACTIONS */ 
				ELSE
					COALESCE((SELECT SUM(intrd_value*intrd_debit_credit)
						FROM intransactiondetails
						WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial
						AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial
						AND COALESCE(intrd_claim_serial,0) = 0
						AND intrd_transaction_type IN ('C0','C1','C2','C3','C4','C5','C6','C7','C8','C9','CA') 
						AND intrd_owner = 'O'
						AND intrd_status <> '9'),0)
				ENDIF as clo_comm_premium,
				IF (inped_process_status <> 'C') OR
					(inped_process_status = 'C' AND 
					 ((inpol_full_cancellation = 'Y' AND inped_year  >= 2018) OR 
					  (inpol_cancellation_date = inpol_period_starting_date AND inped_year < 2018)
					 )
					) THEN inpol_commission_percentage_fees ELSE 0 ENDIF as clo_commission_percentage_fees,
				IF COALESCE(inped_issue_date,TODAY()) <= COALESCE(inity_initiate_issuing,'1900/01/01') THEN
					ROUND(clo_ped_fees * clo_commission_percentage_fees / 100.0, 2) 
				ELSE 
					COALESCE((SELECT SUM(intrd_value*intrd_debit_credit)
						FROM intransactiondetails
						WHERE intrd_policy_serial = inpolicyendorsement.inped_policy_serial
						AND intrd_endorsement_serial = inpolicyendorsement.inped_endorsement_serial
						AND COALESCE(intrd_claim_serial,0) = 0
						AND intrd_transaction_type IN ('CF') 
						AND intrd_owner = 'O'
						AND intrd_status <> '9'),0)
				ENDIF as clo_comm_fee,
				intrh_document_date,
				inpol_commission_percentage,
				IF inag_agent_code in( 'AE001','AE002','AE003' ) then SUBSTR(REPLACE(incl_account_code, inag_agent_code, ''), 5) 
				ELSE inag_agent_code ENDIF as clo_acnt_code,
				YEAR(inpol_period_starting_date) as clo_uw_year,
				(IF CASE WHEN inpol_cover = 'A' THEN 'TP' ELSE 'OD' END = clo_cover_code THEN -1 * inped_premium_debit_credit * inped_fees ELSE 0 ENDIF) as clo_ped_fees,
				COALESCE((SELECT SUM(inpri_reinsurance_percentage) FROM inpolicyreinsurance 
							 WHERE inpri_policy_serial = inpol_policy_serial					-- inped_policy_serial
							 AND inpri_endorsement_serial = inpol_last_endorsement_serial	-- inped_endorsement_serial
							), 0) as clo_ri_percentage,
				(inped_reinsurance_debit_credit * ROUND(inped_premium_od * clo_ri_percentage / 100.0, 2)) as clo_pri_premium,
				ROUND(clo_pri_premium * 0.05, 2) as clo_pri_mif,
				(clo_pri_premium * 
				 ROUND(COALESCE((SELECT SUM(inpri_commission_percentage) FROM inpolicyreinsurance 
										WHERE inpri_policy_serial = inpol_policy_serial 
										AND inpri_endorsement_serial = inpol_last_endorsement_serial), 0) / 100, 2)
				) as clo_pri_commission,
			
				COALESCE((SELECT DISTINCT intrd_trh_auto_serial
								FROM intransactiondetails 
								WHERE intrd_policy_serial = inped_policy_serial
								AND intrd_endorsement_serial = inped_endorsement_serial
								AND intrd_claim_serial = 0
								AND intrd_related_type = 'C'
								AND intrd_status IN ('1','2')),
							(SELECT DISTINCT intrd_trh_auto_serial
								FROM intransactiondetails 
								WHERE intrd_policy_serial = inped_policy_serial
								AND intrd_endorsement_serial = inped_endorsement_serial
								AND intrd_claim_serial = 0
								AND intrd_related_type = 'A'
								AND intrd_status IN ('1','2'))) as clo_trh_auto,
				inped_financial_policy_abs
			FROM inpolicyendorsement
				JOIN inpolicies 
					ON inpol_policy_serial = inped_financial_policy_abs
				JOIN inclients 
					ON incl_client_serial = inpol_client_serial
				JOIN inagents
					ON inag_agent_serial = inpol_agent_serial
				JOIN ininsurancetypes 
					ON inity_insurance_type_serial = inpol_insurance_type_serial
				LEFT OUTER JOIN intransactionheaders 
					ON intrh_auto_serial = clo_trh_auto
				LEFT OUTER JOIN inpoliciesactive ON inpva_policy_serial = inpol_policy_serial
			WHERE inity_insurance_form = 'M'
				AND inpol_cover > 'A' /* COVER F&T or COMP */
				AND inped_status = '1'
				AND inped_process_status <> 'L'
				AND inped_year >= YEAR(ld_asat_date) -1
				AND inped_year * 100 + inped_period <= YEAR(ld_asat_date) * 100 + MONTH(ld_asat_date)
		) AS DT_PED
		GROUP BY clo_policy_link, inpol_policy_number, clo_doc_ref,
			clo_cancelled, clo_policy_in_force, inped_year, inped_period,
			clo_transaction_type, clo_tran_num, clo_policy_start, clo_policy_expiry, 
			clo_tran_start, clo_tran_expiry, clo_on_effect, clo_off_effect,
			clo_days1, clo_days2, clo_days3, 
			clo_expiry_days, clo_cover_code, intrh_document_date, inpol_commission_percentage,
			clo_acnt_code, clo_uw_year,
			clo_ri
		ORDER BY clo_ri desc, clo_policy_start, clo_tran_start, clo_transaction_type --CASE WHEN clo_transaction_type IN ('RNLOG', 'NEWOG') THEN 1 WHEN clo_transaction_type IN ('ADDOG', 'RETOG') THEN 2 ELSE 3 END
	/*) AS DT1 GROUP BY inped_year ORDER BY inped_year desc*/
	
END;   
    ";

    $result = $sybase->query($sql);

    if($excelFile) {
        $spreadSheet = new MEBuildExcel();
        $i = 0;
        while ($row = $sybase->fetch_assoc($result)) {
            $i++;
            if ($i == 1) {
                $spreadSheet->buildTopRowFromFieldNames($row);
            }
            $spreadSheet->addRowFromArray($row);
            //print_r($row);
        }

        $spreadSheet->outputAsDownload('POLICY TRANSACTIONS MOTOR ' . $asAtSplit[0] . " " . $asAtSplit[1] . " " . $asAtSplit[2]);
    }
    else {
        $i=0;
        $data = '';
        $line = '';
        while ($row = $sybase->fetch_assoc($result)) {
            $i++;
            if ($i == 1) {
                $line = '';
                foreach($row as $name => $value){
                    $line .= $name.",";
                }
                $line = $db->remove_last_char($line);
                $data = $line.PHP_EOL;
            }
            $line = '';
            foreach($row as $name => $value){
                $line .= $value.",";
            }
            $line = $db->remove_last_char($line);
            $data .= $line.PHP_EOL;
        }
        $db->export_file_for_download($data,'POLICY TRANSACTIONS MOTOR ' . $asAtSplit[0] . " " . $asAtSplit[1] . " " . $asAtSplit[2].".txt");
    }
}

function makeReportOther($asAtDate, $type, $excelFile = true){
    global $sybase,$db;
    $asAtSplit = explode("/",$asAtDate);

    if ($type == 'PERSONAL'){
        $subForm = 'P';
    }
    else if ($type == 'FIRE'){
        $subForm = 'O';
    }
    else if ($type == 'LIABILITY'){
        $subForm = 'L';
    }
    else {
        $subForm = 'ERROR';
    }


    $sql = "
    BEGIN
	Declare ld_asat_date Date;
	
	Set ld_asat_date = '".$asAtSplit[2]."/".$asAtSplit[1]."/".$asAtSplit[0]."';
	
	IF (SELECT COUNT() FROM ccuserparameters) = 0 THEN
		INSERT INTO ccuserparameters (ccusp_user_date) VALUES (ld_asat_date);
	ELSE 
		UPDATE ccuserparameters
		SET ccusp_user_date = ld_asat_date;
	ENDIF;
	

	-- Use a Local Temporary Table to Define the Commission Types Applicable per Product/Cover
	SELECT *
	into local temporary table PRODUCT_COMMISSION_TYPES
	from(	   SELECT  'FMD' as pct_product, 'FMD' as pct_cover, 'C0' pct_comm_trn_type/* FMD:	Medical */
		 UNION SELECT  'FMD' as pct_product, 'ELP' as pct_cover, 'C2' pct_comm_trn_type/* 		EL */
		 UNION SELECT  'HSR' as pct_product, 'HSR' as pct_cover, 'C0' pct_comm_trn_type/* HSR:	Fire & Other Perils*/
		 UNION SELECT  'HSR' as pct_product, 'HSR' as pct_cover, 'C1' pct_comm_trn_type/*		EQ */
		 UNION SELECT  'HSR' as pct_product, 'ELP' as pct_cover, 'C2' pct_comm_trn_type/*		EL */
		 UNION SELECT  'HSR' as pct_product, 'PLI' as pct_cover, 'C3' pct_comm_trn_type/*		PL */
	) as PRODUCT_COMMISSION_TYPES;
	
	
	
	SELECT  clo_policy_link, inpol_policy_number, clo_doc_ref,
			clo_cancelled, clo_policy_in_force, inpae_year, inpae_period,
			clo_transaction_type, clo_tran_num, clo_policy_start, clo_policy_expiry, 
			clo_tran_start, clo_tran_expiry, clo_on_effect, clo_off_effect,
			clo_days1, clo_days2, clo_days3, 
			clo_expiry_days, clo_cover_code, 
			SUM(COALESCE(clo_premium,0)) as clo_gwp, 
			SUM(COALESCE(clo_mif,0)) as clo_mif_amnt,
			SUM(COALESCE(clo_comm_premium,0)) as clo_commission_pr_amnt,
			SUM(COALESCE(clo_comm_fee,0)) as clo_commission_fee_amnt,
			intrh_document_date, inpol_commission_percentage,
			clo_acnt_code, clo_uw_year,
			IF clo_ri_percentage > 0 THEN 'YES' ELSE 'NO' ENDIF as clo_ri,
			SUM(COALESCE(clo_ped_fees,0)) as clo_fees,
			SUM(COALESCE(clo_pri_premium,0)) as clo_ri_premium,
			SUM(COALESCE(clo_pri_mif,0)) as clo_ri_mif,
			SUM(COALESCE(clo_pri_commission,0)) as clo_ri_commission
	FROM (SELECT STRING(inpol_policy_number,'/',clo_doc_ref) as clo_policy_link, 
				inpol_policy_number,
				COALESCE(intrh_document_number, '?')as clo_doc_ref,
				'' as clo_cancelled,
				IF inpva_policy_serial IS NULL THEN 'NO' ELSE 'YES' ENDIF as clo_transaction_in_force,
				IF (SELECT COUNT() FROM inpoliciesactive pva 
					WHERE pva.inpva_policy_number = inpolicies.inpol_policy_number
					AND pva.inpva_period_starting_date = inpolicies.inpol_period_starting_date) > 0 THEN 'YES' ELSE 'NO' 
				ENDIF as clo_policy_in_force,
				inpae_year, inpae_period,
				CASE 
				WHEN inpae_process_status = 'C' THEN 'CANOG'
				WHEN inpae_process_status in( 'E','D' ) THEN /* SS 02/06/2016 Also for Decl.Adj. */
					/* S.O.S. Using the ALT. PED. view here, may result ot ADDOG for FMD MEDICAL and \"RETOD\" for FMD EL Cover (i.e. Endorsed to remove EL) */
					IF -1*(SELECT SUM(a.inpae_premium_debit_credit*a.inpae_premium) FROM inpolicyaltendorsement as a
								WHERE a.inpae_financial_policy_abs = inpolicyaltendorsement.inpae_financial_policy_abs
								AND a.inpae_process_status = inpolicyaltendorsement.inpae_process_status) >= 0 THEN 'ADDOG' ELSE 'RETOG' ENDIF
				WHEN inpae_process_status = 'N' then 'NEWOG'
				WHEN inpae_process_status = 'R' then 'RNLOG'
				ELSE '' END as clo_transaction_type,
				'' as clo_tran_num,
				inpol_period_starting_date as clo_policy_start,
				inpol_expiry_date as clo_policy_expiry,
				CASE 
				WHEN inpae_process_status = 'C' AND inpol_full_cancellation = 'Y' THEN inpol_period_starting_date
				ELSE inpol_starting_date 
				END as clo_tran_start,
				CASE 
				WHEN inpae_process_status = 'C' AND inpol_full_cancellation = 'Y' THEN inpol_expiry_date
				WHEN inpae_process_status = 'C' THEN DATEADD( DAY, -1, inpol_cancellation_date) 
				ELSE inpol_expiry_date 
				END as clo_tran_expiry,
				'' as clo_on_effect,
				'' as clo_off_effect,
				DATEDIFF(day, inpol_period_starting_date, inpol_expiry_date) +1 as clo_days1,
				DATEDIFF(day, inpol_starting_date, inpol_expiry_date)+ 1 as clo_days2,
				clo_days1 - clo_days2 as clo_days3,
				IF inpol_expiry_date > ld_asat_date THEN DATEDIFF(Day, ld_asat_date, inpol_expiry_date) ELSE 0 ENDIF as clo_expiry_days,
				COVER_ITY.inity_insurance_type as clo_cover_code,
				(-1 * inpae_premium_debit_credit * inpae_premium) as clo_premium,
 				(ROUND(clo_premium * 0.00, 2)) as clo_mif, /* Non-Motor 0 MIF */
				/* Premiums Commission from Transactions Table */
				(SELECT SUM(COALESCE(intrd_value * intrd_debit_credit,0))
					 FROM intransactiondetails
					 WHERE	intrd_policy_serial = inpolicyaltendorsement.inpae_policy_serial
						AND intrd_endorsement_serial = inpolicyaltendorsement.inpae_endorsement_serial
						AND COALESCE(intrd_claim_serial,0) = 0
						AND intrd_transaction_type IN ((SELECT pct_comm_trn_type 
														 FROM PRODUCT_COMMISSION_TYPES /* COMMISSION TYPE PER PRODUCT/COVER DEFINE ABOVE */
														 WHERE pct_product = PRODUCT_ITY.inity_insurance_type
														 AND   pct_cover = COVER_ITY.inity_insurance_type))
						AND intrd_owner = 'O'
						AND intrd_related_type IN ('A', 'C')
						AND intrd_related_serial IN (inpol_client_serial, inpol_agent_serial) /* REMEMBER, AG488 operates as external agent */
						AND intrd_status IN ('1','2')) as clo_comm_premium,
					 
				/* Fees Commission from Transactions Table */
				(SELECT SUM(COALESCE(intrd_value * intrd_debit_credit,0))
					 FROM intransactiondetails
					 WHERE	intrd_policy_serial = inpolicyaltendorsement.inpae_policy_serial
						AND intrd_endorsement_serial = inpolicyaltendorsement.inpae_endorsement_serial
						AND COALESCE(intrd_claim_serial,0) = 0
						AND intrd_transaction_type = 'CF'
						AND intrd_owner = 'O'
						AND intrd_related_type IN ('A', 'C')
						AND intrd_related_serial IN (inpol_client_serial, inpol_agent_serial) /* REMEMBER, AG488 operates as external agent */
						AND intrd_status IN ('1','2')) as clo_comm_fee,
				intrh_document_date,
				inpol_commission_percentage, /* THIS IS NOT CORRECT - MULTIPLE COMMISSION TYPE / DIFFERENT %s ON NON-MOTOR */
				IF inag_agent_code IN ('AE001','AE002','AE003') then SUBSTR(REPLACE(incl_account_code, inag_agent_code, ''), 5) 
				ELSE inag_agent_code ENDIF as clo_acnt_code,
				YEAR(inpol_period_starting_date) as clo_uw_year,
				(IF 'FMD' = clo_cover_code THEN -1 * inpae_premium_debit_credit * inpae_fees ELSE 0 ENDIF) as clo_ped_fees,
				COALESCE((SELECT SUM(inpri_reinsurance_percentage) FROM inpolicyreinsurance 
							 WHERE inpri_policy_serial = inpolicyaltendorsement.inpae_policy_serial
							 AND inpri_endorsement_serial = inpolicyaltendorsement.inpae_endorsement_serial
							 AND inpri_reinsurance_treaty_serial = inpolicyaltendorsement.inpae_line_treaty
							), 0) as clo_ri_percentage,
				ROUND((-1 * inpae_premium_debit_credit * inpae_premium) * clo_ri_percentage / 100.0, 2) as clo_pri_premium,
				0 as clo_pri_mif,
				(clo_pri_premium * 
				 ROUND(COALESCE((SELECT SUM(inpri_commission_percentage) FROM inpolicyreinsurance 
										WHERE inpri_policy_serial = inpolicyaltendorsement.inpae_policy_serial
										AND inpri_endorsement_serial = inpolicyaltendorsement.inpae_endorsement_serial
										AND inpri_reinsurance_treaty_serial = inpolicyaltendorsement.inpae_line_treaty), 0) / 100, 2)
				) as clo_pri_commission,
				COALESCE((SELECT DISTINCT intrd_trh_auto_serial
								FROM intransactiondetails 
								WHERE intrd_policy_serial = inpae_policy_serial
								AND intrd_endorsement_serial = inpae_endorsement_serial
								AND COALESCE(intrd_claim_serial,0) = 0
								AND intrd_related_type = 'C'
								AND intrd_related_serial = incl_client_serial
								AND intrd_status IN ('1','2')),
							(SELECT DISTINCT intrd_trh_auto_serial
								FROM intransactiondetails 
								WHERE intrd_policy_serial = inpae_policy_serial
								AND intrd_endorsement_serial = inpae_endorsement_serial
								AND COALESCE(intrd_claim_serial,0) = 0
								AND intrd_related_type = 'A'
								AND intrd_related_serial = inag_agent_serial
								AND intrd_status IN ('1','2'))) as clo_trh_auto,
				inpae_financial_policy_abs
			FROM inpolicyaltendorsement /* Breakdown a Policy to Different Alternative Insurance Types according to the Treaties it is ceded to */
				JOIN ininsurancetypes COVER_ITY
					ON COVER_ITY.inity_insurance_type_serial = inpae_insurance_type_serial
				JOIN inpolicies 
					ON inpol_policy_serial = inpae_financial_policy_abs
				JOIN ininsurancetypes PRODUCT_ITY
					ON PRODUCT_ITY.inity_insurance_type_serial = inpol_insurance_type_serial
				JOIN inclients 
					ON incl_client_serial = inpol_client_serial
				JOIN inagents
					ON inag_agent_serial = inpol_agent_serial
				LEFT OUTER JOIN intransactionheaders 
					ON intrh_auto_serial = clo_trh_auto
				LEFT OUTER JOIN inpoliciesactive ON inpva_policy_serial = inpol_policy_serial
			WHERE PRODUCT_ITY.inity_insurance_form = '".$subForm."'
			--	AND inpol_policy_number = 'FMD000900'
				AND inpol_cover = 'N'
				AND inpae_status = '1'
				AND inpae_process_status <> 'L'
				AND inpae_year >= YEAR(ld_asat_date) -1
				AND inpae_year * 100 + inpae_period <= YEAR(ld_asat_date) * 100 + MONTH(ld_asat_date)
		) AS DT_PED
		GROUP BY clo_policy_link, inpol_policy_number, clo_doc_ref,
			clo_cancelled, clo_policy_in_force, inpae_year, inpae_period,
			clo_transaction_type, clo_tran_num, clo_policy_start, clo_policy_expiry, 
			clo_tran_start, clo_tran_expiry, clo_on_effect, clo_off_effect,
			clo_days1, clo_days2, clo_days3, 
			clo_expiry_days, clo_cover_code, intrh_document_date, inpol_commission_percentage,
			clo_acnt_code, clo_uw_year,
			clo_ri
	   ORDER BY inpol_policy_number,intrh_document_date, clo_policy_link, clo_doc_ref, 
				clo_cover_code, inpae_year, inpae_period,clo_transaction_type;
	
END;
    
    ";
    $result = $sybase->query($sql);

    if($excelFile) {
        $spreadSheet = new MEBuildExcel();
        $i = 0;
        while ($row = $sybase->fetch_assoc($result)) {
            $i++;
            if ($i == 1) {
                $spreadSheet->buildTopRowFromFieldNames($row);
            }
            $spreadSheet->addRowFromArray($row);
            //print_r($row);
        }

        $spreadSheet->outputAsDownload('POLICY TRANSACTIONS '.$_POST['fld_report_type'].' ' . $asAtSplit[0] . " " . $asAtSplit[1] . " " . $asAtSplit[2]);
    }
    else {
        $i=0;
        $data = '';
        $line = '';
        while ($row = $sybase->fetch_assoc($result)) {
            $i++;
            if ($i == 1) {
                $line = '';
                foreach($row as $name => $value){
                    $line .= $name.",";
                }
                $line = $db->remove_last_char($line);
                $data = $line.PHP_EOL;
            }
            $line = '';
            foreach($row as $name => $value){
                $line .= $value.",";
            }
            $line = $db->remove_last_char($line);
            $data .= $line.PHP_EOL;
        }
        $db->export_file_for_download($data,'POLICY TRANSACTIONS '.$type.' ' . $asAtSplit[0] . " " . $asAtSplit[1] . " " . $asAtSplit[2].".txt");
    }
}
?>