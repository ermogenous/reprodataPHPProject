<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 2/11/2021
 * Time: 5:56 μ.μ.
 */

ini_set('max_execution_time', 3600);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');
include('../../eurosure/lib/odbccon.php');

$db = new Main(1);
//This report inputs the overdue balances into the sms gateway
$db->admin_title = "Eurosure - SMS - Input Reports - Account Balances Overdue";

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

if ($_POST['action'] == 'show') {


}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

if ($_POST['fld_as_at_date'] == '') {
    $_POST['fld_as_at_date'] = date('d/m/Y');
}
if ($_POST['fld_up_to_year'] == '') {
    $_POST['fld_up_to_year'] = date('Y');
}
if ($_POST['fld_up_to_period'] == '') {
    $_POST['fld_up_to_period'] = date('m');
}
if ($_POST['fld_remove_due_days'] == '') {
    $_POST['fld_remove_due_days'] = 90;
}
?>

<div class="container">
    <div class="row">
        <div class="col-1 d-none d-md-block"></div>
        <div class="col-12 col-md-10">

            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>Reports - SMS - Input Reports - Account
                            Overdue Balances</b></div>
                </div>

                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_as_at_date')
                        ->setFieldDescription('As At Date')
                        ->setLabelClasses('col-sm-3')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($_POST['fld_as_at_date'])
                        ->buildLabel();
                    ?>
                    <div class="col-9">
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

                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_up_to_year')
                        ->setFieldDescription('Up To Year')
                        ->setLabelClasses('col-sm-3')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_up_to_year'])
                        ->buildLabel();
                    ?>
                    <div class="col-9">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>


                </div>

                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_up_to_period')
                        ->setFieldDescription('Up To Period')
                        ->setLabelClasses('col-sm-3')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_up_to_period'])
                        ->buildLabel();
                    ?>
                    <div class="col-9">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>


                </div>

                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_remove_due_days')
                        ->setFieldDescription('Remove Entries Less Than X due days')
                        ->setLabelTitle('All due days entries that are less the number specified will not be shown')
                        ->setLabelClasses('col-sm-4')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_remove_due_days'])
                        ->buildLabel();
                    ?>
                    <div class="col-8">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>


                </div>


                <div class="form-group row">
                    <label for="name" class="col-3 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-9">
                        <input name="action" type="hidden" id="action" value="check">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('../sms.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="Submit Form"
                               class="btn btn-primary">
                    </div>
                </div>

            </form>

        </div>
        <div class="col-1 d-none d-md-block"></div>
    </div>
</div>

<!-- CHECK WORKSHEETS IF ALREADY EXISTS -->
<?php
if ($_POST['action'] == 'show') {
    $sql = "
    SELECT
    COUNT(*)as clo_total_found
    FROM
    es_worksheets
    WHERE
    esws_type = 'SMS_Account_Balances'
    AND esws_year = " . $_POST['fld_up_to_year'] . "
    AND esws_period = " . $_POST['fld_up_to_period'] . "
    AND esws_as_at_date = " . $_POST['fld_as_at_date'] . "
    ";
    $resultData = $db->query_fetch($sql);

    ?>
    <div class="container">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>

                            <?php
                            if ($resultData['clo_total_found'] > 0) {
                                echo "Found Existing Worksheet Data for this period";
                            } else {
                                //check if found any other worksheet for the same period year
                                $sql = "
                                    SELECT
                                    COUNT(*)as clo_total_found
                                    FROM
                                    es_worksheets
                                    WHERE
                                    esws_type = 'SMS_Account_Balances'
                                    AND esws_year = " . $_POST['fld_up_to_year'] . "
                                    AND esws_period = " . $_POST['fld_up_to_period'];
                                $resultSamePeriod = $db->query($sql);
                                while ($smPeriod = $db->fetch_assoc($resultSamePeriod)){

                                    echo "Found other blah blah";

                                }

                            }

                            function checkIfWorksheetExists(){

                            }


                            ?>
                        </b></div>
                </div>
            </div>
            <div class="col-1 d-none d-md-block"></div>
        </div>
    </div>

    <?php
}//action = show

?>


<!-- SHOW & INSERT RECORDS TO WORKSHEET -->
<?php
if ($_POST['action'] == 'show') {
    ?>

    <style>
        .smallText {
            font-size: 10px;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">
                <form name="myListForm" id="myListForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Results Found</b></div>
                    </div>


                    <table class="table" data-class="smallText">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="smallText">#</th>
                            <th scope="col" class="smallText">Agent</th>
                            <th scope="col" class="smallText">Account Name</th>
                            <th scope="col" class="smallText">Account</th>
                            <th scope="col" class="smallText text-center">Original Amount</th>
                            <th scope="col" class="smallText text-center">O/S Amount</th>
                            <th scope="col" class="smallText text-center">Due Date</th>
                            <th scope="col" class="smallText text-center">Due Days</th>
                            <th scope="col" class="smallText text-center">
                                <input type="checkbox" value="1" id="checkAll" name="checkAll" onchange="changeAll()">
                            </th>
                            <script>
                                function changeAll() {
                                    console.log('check all ');
                                    //$(this).closest('myListForm').find(':checkbox').attr('checked',true);
                                    $('input[type=checkbox]').each(function () {
                                        //console.log(this.id);
                                        let checkBoxName = this.id;
                                        if (checkBoxName.substr(0, 5) == 'line_') {
                                            if ($('#checkAll').prop('checked')) {
                                                $(this).prop('checked', true);
                                            } else {
                                                $(this).prop('checked', false);
                                            }
                                        }
                                    });
                                }
                            </script>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $sybase = new ODBCCON();

                        $sql = getSql();
                        $result = $sybase->query($sql);
                        $i = 0;
                        while ($row = $sybase->fetch_assoc($result)) {
                            $i++;
                            ?>

                            <tr>
                                <th scope="row" class="smallText"><?php echo $i; ?></th>
                                <td class="smallText"><?php echo $row['clo_agent_code']; ?></td>
                                <td class="smallText"><?php echo $row['ccad_long_desc']; ?></td>
                                <td class="smallText"><?php echo $row['ccad_addr_code']; ?></td>
                                <td class="smallText text-center"><?php echo $db->fix_int_to_double($row['clo_total_original_amount'], 2); ?></td>
                                <td class="smallText text-center"><?php echo $db->fix_int_to_double($row['clo_total_os_amount'], 2); ?></td>
                                <td class="smallText text-center"><?php echo $db->convertDateToEU($row['clo_min_due_date']); ?></td>
                                <td class="smallText text-center"><?php echo round($row['clo_max_due_days'], 0); ?></td>
                                <td class="smallText text-center">
                                    <input type="checkbox" value="1" id="line_<?php echo $i; ?>" checked>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                        </tbody>
                    </table>


                </form>
            </div>
            <div class="col-1 d-none d-md-block"></div>
        </div>
    </div>
    <?php
}
?>

<?php
$formValidator->output();
$db->show_footer();


function getSql()
{
    global $db;
//Synthesis Report ACRP23/101

    $sql = "
    
  SELECT 
acunl_dues_date as clo_due_date,
acunl_docu_nmbr as clo_document_number,
acunl_acct_amnt as clo_original_amount,
acunl_talc_acct - acunl_otst_acct as clo_os_amount,
( Select ccde_long_desc From ccpdecod  Where ccde_reco_type = '23' and ccde_reco_code = ccad_anls_cod3 ) as clo_agent_description,
ccad_anls_cod3 as clo_agent_code,

ccad_addr_code,   
ccad_long_desc,   
ccad_scnd_desc,
acunl_acct_serl,   
acunl_docu_year,   
acunl_docu_perd,   
acunl_docu_date,   
acunl_docu_nmbr,   
acunl_hdoc_nmbr,   
acunl_hdoc_date,   
acunl_line_comm,   
acunl_talc_acct,   
acunl_talc_main,   
acunl_dues_date,   
acunl_hdoc_serl,   
acunl_otst_acct,   
acunl_otst_main,   
acunl_docu_cate,   
acunl_docu_code,   
ccad_addr_type,   
acunl_acct_amnt,   
acunl_main_amnt,   
acunl_drmv_crmv,   
ccad_tele_num1,   
ccad_tele_num2,   
ccad_tfax_num2,   
ccad_anls_typ1,   
ccad_anls_cod1,   
ccad_anls_typ2,   
ccad_anls_cod2,   
ccad_anls_typ3,   
ccad_anls_cod3,   
ccad_itax_idty,
ccad_crdt_days,
cccu_crcy_rate,   
space(180) as clo_desc1,   
space(180) as clo_desc2,   
space(180) as clo_desc3,   
space(060) as clo_sort1,   
space(060) as clo_sort2,   
space(060) as clo_sort3,  
acunl_auto_serl,   
acunl_line_nmbr,    
ccad_elec_mail, 
actln_anls_cod2, 
actln_line_comm, 
actln_refe_date, 
acthe_orgn_modl,
         COALESCE((SELECT LIST (CONVERT(CHAR(10), indpl_print_date, 103)||' - '||indpl_document_type,' ' ORDER BY  indpl_print_date,indpl_document_type) 
                    FROM  indocumprnlog 
                    JOIN  inpolicies pol ON pol.inpol_policy_serial = indpl_primary_serial 
                    WHERE indpl_document_type IN ('CNL', 'CNLD','CNT')
                  /*AND   indpl_primary_serial =  clo_policy_serial*/  
                    AND   pol.inpol_policy_number = inpolicies.inpol_policy_number 
                    AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                    AND   pol.inpol_status IN ('N','A')),'') 
          /* COALESCE((SELECT LIST (CONVERT(CHAR(10), indpl_print_date, 103)||' - '||indpl_document_type,' ' ORDER BY  indpl_print_date,indpl_document_type) FROM   indocumprnlog WHERE  indpl_document_type IN ('CNL', 'CNLD','CNT') 
                      AND    indpl_primary_serial =  clo_policy_serial ),'') */ 
          as clo_prev_letters_all, 
       /*COALESCE((SELECT LIST (CONVERT(CHAR(10), indpl_print_date, 103)||' - '||indpl_document_type,' ' ORDER BY  indpl_print_date,indpl_document_type)  
                    FROM  indocumprnlog  
                    JOIN  inpolicies pol ON pol.inpol_policy_serial = indpl_primary_serial 
                    WHERE indpl_document_type IN ('CNL', 'CNLD', 'CNT') 
                    AND   (((indpl_document_type = 'CNL') AND   
                            (SELECT COUNT() FROM indocumprnlog a  
                             WHERE a.indpl_primary_serial = pol.inpol_policy_serial AND a.indpl_document_type = indocumprnlog.indpl_document_type  
                            AND a.indpl_print_date < indocumprnlog.indpl_print_date) = 0 
                           ) 
                           OR   
                           ((indpl_document_type = 'CNLD') AND          
                            (SELECT COUNT() FROM indocumprnlog a  
                             WHERE a.indpl_primary_serial = pol.inpol_policy_serial  
                             AND a.indpl_document_type = 'CNL') = 0 
                           ) 
                           OR   
                           (indpl_document_type NOT IN ('CNL', 'CNLD')) 
                          ) 
                  /*AND    indpl_primary_serial =  clo_policy_serial*/ 
                    AND   pol.inpol_policy_number = inpolicies.inpol_policy_number 
                    AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                    AND   pol.inpol_status IN ('N','A')),'') */ 
         (SELECT LIST (indpl_document_type || ' on ' || CONVERT(CHAR(10), indpl_print_date, 103), ' ' ORDER BY indpl_document_type, indpl_print_date) 
          FROM ((SELECT FIRST /* CANCELLATION DOCUMENT */  
                 indpl_document_type, 

                 CASE 
                    WHEN LENGTH(indpl_document_type) = 3 THEN 1 /* FORMAL */ 
                    WHEN RIGHT(indpl_document_type, 1) = 'D' THEN 2 /* DRAFT */ 
                    WHEN RIGHT(indpl_document_type, 1) = 'D' THEN 3 /* WITHDRAWN */ 
                    ELSE 9 END as clo_sort_id, 
                  indpl_print_date 
                 FROM   indocumprnlog 
                  JOIN  inpolicies pol ON pol.inpol_policy_serial = indpl_primary_serial 
                 WHERE  indpl_document_type IN ('CNL', 'CNLD', 'CNLW') 
                /*AND   indpl_primary_serial =  clo_policy_serial*/ 
                  AND   pol.inpol_policy_number = inpolicies.inpol_policy_number 
                  AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                  AND   pol.inpol_status IN ('N','A') 
                 ORDER BY clo_sort_id, indpl_print_date) 
                UNION 
                (SELECT FIRST /* CANCELLATION NOTICE LETTER */ 
                 indpl_document_type, 
                 CASE 
                    WHEN LENGTH(indpl_document_type) = 3 THEN 1 /* FORMAL */ 
                    WHEN RIGHT(indpl_document_type, 1) = 'D' THEN 2 /* DRAFT */ 
                    WHEN RIGHT(indpl_document_type, 1) = 'D' THEN 3 /* WITHDRAWN */ 
                    ELSE 9 END as clo_sort_id, 
                 indpl_print_date 
                FROM   indocumprnlog 
                 JOIN  inpolicies pol ON pol.inpol_policy_serial = indpl_primary_serial 
                WHERE  indpl_document_type IN ('CNT', 'CNTD', 'CNTW') 
               /*AND   indpl_primary_serial =  clo_policy_serial*/  
                 AND   pol.inpol_policy_number = inpolicies.inpol_policy_number 
                 AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                 AND   pol.inpol_status IN ('N','A') 
                ORDER BY clo_sort_id, indpl_print_date) 
               ) AS DT_PRN_LOG 
         ) as clo_prev_letters, 


         COALESCE((SELECT LIST (indpl_document_type,' ' ORDER BY  indpl_document_type) 
                    FROM  indocumprnlog 
                    JOIN  inpolicies pol ON pol.inpol_policy_serial = indpl_primary_serial 
                    WHERE indpl_document_type IN ('CNL', 'CNLD','CNT') 
                  /*AND   indpl_primary_serial =  clo_policy_serial*/ 
                    AND   pol.inpol_policy_number = inpolicies.inpol_policy_number 
                    AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                    AND   pol.inpol_status IN ('N','A')),'') as clo_cnl, 


         COALESCE((IF acthe_orgn_auto <> 0 AND acthe_orgn_modl = 'in' THEN 
                      (SELECT FIRST inped_financial_policy_abs 
                         FROM intransactiondetails 
                         JOIN inpolicyendorsement ON inped_policy_serial = intrd_policy_serial AND inped_endorsement_serial = intrd_endorsement_serial 
                        WHERE intrd_trh_auto_serial = acthe_orgn_auto ORDER BY intrd_auto_serial) 
                   ELSE 0 ENDIF), 0) As clo_policy_serial, 


         (if acthe_orgn_modl <> 'in' Then acunl_refe_nmbr Else COALESCE(inpol_policy_number, '') EndIf) as inpol_policy_number, 



         (if acthe_orgn_modl <> 'in' Then '' 
          Else IF COALESCE(inity_insurance_form, '') = 'M' Then 
                   COALESCE((Select LIST(DISTINCT initm_item_code) From inpolicyitems JOIN initems ON initm_item_serial = inpit_item_serial 
                                                         Where inpit_policy_serial = clo_policy_serial), '') 
          Else CASE 
                   WHEN COALESCE(inity_insurance_type, '') IN ('FMD') THEN 'MEDICAL' 
                   WHEN COALESCE(inity_insurance_type, '') IN ('CAR','EAR','CPE') THEN 'ENGINEERING' 
                   WHEN COALESCE(inity_insurance_type, '') IN ('CHC','HSR','FIR','HGI','CLI') THEN 'PROPERTY' 
                   WHEN COALESCE(inity_insurance_type, '') IN ('GPA') THEN 'GPA' 
                   WHEN COALESCE(inity_insurance_type, '') IN ('GLI') THEN 'GLASS' 
                   WHEN COALESCE(inity_insurance_type, '') IN ('MAR','MHI') THEN 'MARINE' 
                   WHEN COALESCE(inity_insurance_type, '') IN ('PLI') THEN 'PUBLIC LIABILITY'  
                   WHEN COALESCE(inity_insurance_type, '') IN ('ELP') THEN 'EMPLOYERS LIABILITY'  
                   ELSE 'OTHER' END 
          Endif EndIf) as inpol_item_codes, 


         (if acthe_orgn_modl <> 'in' Then ((Trim(ccad_long_desc) + ' ' +  Trim(ccad_scnd_desc))) 
          Else COALESCE((Select (( Trim(incl_long_description + ' ' + Trim(incl_first_name))))  
                                      From inclients 
                                      WHERE incl_client_serial = inpolicies.inpol_client_serial), '') EndIf) as inpol_name_of_insured, 


         IF acthe_orgn_modl <> 'in' Then 9 ELSE 
         (SELECT MAX(IF pol.inpol_status = 'N' THEN pol.inpol_policy_serial ELSE 0 ENDIF) 
          FROM inpolicies pol 
          WHERE  pol.inpol_policy_number = inpolicies.inpol_policy_number 
          AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
          AND   pol.inpol_status <> 'D' AND pol.inpol_process_status <> 'D' /* Exclude Deleted and Delcarations */ ) 
         EndIf as clo_policy_active_phase_serial, 


         IF acthe_orgn_modl <> 'in' Then 9 ELSE 
         (SELECT CASE 
                         WHEN COUNT(IF pol.inpol_status = 'N' THEN 1 ENDIF) > 0 AND COUNT(IF pol.inpol_status IN ('O','C') THEN 1 ENDIF) = 0 THEN 
                                    IF COALESCE((SELECT nxt_pol.inpol_process_status 
                                                           FROM inpolicies nxt_pol 
                                                           WHERE nxt_pol.inpol_replacing_policy_serial = clo_policy_active_phase_serial), '')  = 'R' THEN 2 /*'ACTIVE - UNDER RENEWAL'*/ 
                                    ELSE 1 /*'ACTIVE'*/ ENDIF 
                         WHEN COUNT(IF pol.inpol_status = 'N' THEN 1 ENDIF) > 0 AND COUNT(IF pol.inpol_status IN ('O','C') THEN 1 ENDIF) > 0 THEN 
                                    IF (SELECT nxt_pol.inpol_process_status 
                                         FROM inpolicies nxt_pol  
                                         WHERE nxt_pol.inpol_replacing_policy_serial = clo_policy_active_phase_serial)  = 'C' THEN 3 /*'ACTIVE - PENDING CANCELLATION'*/ 
                                    ELSE 4 /*'ACTIVE - PENDING ENDORSEMENT'*/ ENDIF 
                         WHEN COUNT(IF pol.inpol_status = 'N' THEN 1 ENDIF) = 0 THEN 
                                    CASE 
                                    WHEN COUNT(IF pol.inpol_replaced_by_policy_serial = 0 THEN 1 ENDIF) = 0 THEN 5 /*'ALREADY RENEWED'*/ 
                                    WHEN COUNT(IF COALESCE(rvrs_ped.inped_process_status, '') = 'C' THEN 1 ENDIF) > 0 THEN 6 /*'ALREADY CANCELLED'*/ 
                                    ELSE 7 /*'LAPSED'*/ 
                                    END 
                         ELSE 0 /*'UNKNOWN'*/ END
          FROM inpolicies pol 
          LEFT OUTER JOIN inpolicyendorsement rvrs_ped ON rvrs_ped.inped_policy_serial = pol.inpol_policy_serial AND rvrs_ped.inped_endorsement_serial = pol.inpol_last_cancellation_endorsement_serial 
                 WHERE  pol.inpol_policy_number = inpolicies.inpol_policy_number 
                  AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                  AND   pol.inpol_status <> 'D' AND pol.inpol_process_status <> 'D' /* Exclude Deleted and Delcarations */) 
         EndIf as clo_policy_current_state, 


         IF clo_policy_current_state IN (3, 6) Then /* Pending Cancellation / Already Cancelled */ 
             (SELECT pol.inpol_cancellation_date 
              FROM inpolicies pol 
              LEFT OUTER JOIN inpolicyendorsement rvrs_ped ON rvrs_ped.inped_policy_serial = pol.inpol_policy_serial AND rvrs_ped.inped_endorsement_serial = pol.inpol_last_cancellation_endorsement_serial 
                 WHERE  pol.inpol_policy_number = inpolicies.inpol_policy_number 
                  AND   pol.inpol_period_starting_date = inpolicies.inpol_period_starting_date 
                  AND   rvrs_ped.inped_process_status ='C') 
         EndIf as clo_cancellation_date, 
         COALESCE((Select Sum(a.acunl_talc_acct - a.acunl_otst_acct) From acmunall a, acpdocum b Where acmunall.acunl_acct_serl = a.acunl_acct_serl And a.acunl_docu_cate = b.acdc_docu_cate And a.acunl_docu_code = b.acdc_docu_code And b.acdc_docu_type = '6'), 0) as ccad_account_unallocated_receipts,
												  
																												  
         COALESCE((Select Sum(a.acunl_talc_acct - a.acunl_otst_acct) 
            From acmunall a, acpdocum b, acmthead c 
            Where acmunall.acunl_acct_serl = a.acunl_acct_serl 
            And a.acunl_docu_cate = b.acdc_docu_cate 
            And a.acunl_docu_code = b.acdc_docu_code 
            And c.acthe_auto_serl = a.acunl_auto_serl 
            And b.acdc_docu_type <> '6' 
            And Not (a.acunl_docu_year*100+a.acunl_docu_perd <= xclo_upto_year*100+xclo_upto_period 
                And a.acunl_dues_date <= xclo_as_at_date) ), 0) 
            as ccad_account_unallocated_other,

'" . $db->convertDateToUS($_POST['fld_as_at_date']) . "' as xclo_as_at_date,
'" . $_POST['fld_up_to_year'] . "' as xclo_upto_year,
'" . $_POST['fld_up_to_period'] . "' as xclo_upto_period,
'Y' as xclo_os_documents,
'N' as xclo_extended_ageing,
'N' as xclo_summary_lines, 

         (select FIRST a.ccwst_auto_serial from ccworksheets a /* GET THE SERIAL OF THE LAST WS FOUND FOR THIS DOCUMENT NUMBER, PREVIOUSLY INSERTED BY THIS REPORT */
          where a.ccwst_status <> 'D' and a.ccwst_menu_option = 'ACRP23' and a.ccwst_dwo = 'rep_ad_list_outstanding_dr_cr' and a.ccwst_document_number = acmunall.acunl_hdoc_nmbr and  a.ccwst_sort1_code = clo_sort1
         order by a.ccwst_auto_serial desc) as clo_last_ws, 

ccwst_send_letter_type, 
ccwst_user_comment,   
ccwst_action_date ,
ccad_acct_serl

into #temp
						  
   FROM acmunall

         JOIN acmthead ON acmunall.acunl_auto_serl = acmthead.acthe_auto_serl 
                                   AND ( acmthead.acthe_orgn_modl = 'in' or (acmthead.acthe_orgn_modl IN ('ac','tx') and LEFT(acmthead.acthe_docu_code, 2) IN ('DN','CR','ZZ','CJ','GE','TR','IP') ) )
         JOIN ccpcrncy ON acmunall.acunl_acct_crcy = ccpcrncy.cccu_crcy_code
         JOIN ccmaddrs ON ccmaddrs.ccad_acct_serl = acmunall.acunl_acct_serl 
         JOIN acmtline ON acmunall.acunl_auto_serl = acmtline.actln_auto_serl 
                                 AND acmunall.acunl_line_nmbr = acmtline.actln_line_nmbr 
         LEFT OUTER JOIN ccworksheets ON ccworksheets.ccwst_auto_serial  =  clo_last_ws 
         LEFT OUTER JOIN inpolicies ON inpol_policy_serial = clo_policy_serial
         LEFT OUTER JOIN ininsurancetypes ON inity_insurance_type_serial = inpol_insurance_type_serial



   WHERE ( xclo_os_documents = 'Y' ) and
         ( xclo_summary_lines <> 'Y' ) 
and ( acunl_dues_date <= xclo_as_at_date)  /*Here if you want the ones that will have due after a week then add here 7 days*/
																			  
AND ccad_addr_type = '1'  
And ccad_addr_code >= '1615AG100' 
And ccad_addr_code <= '1615AG999' 
And ccad_prnt_stmt = '1' 
And ccad_acct_stat in ('1','2','3','4') 
AND ((acunl_talc_acct  - acunl_otst_acct) <> 0) 
AND ((acunl_docu_stat IN ('1','2') 
AND acunl_docu_year*100+acunl_docu_perd <=" . $_POST['fld_up_to_year'] . "*100+" . $_POST['fld_up_to_period'] . ")) 
//AND ccad_addr_code = '1615AG100DK0001'
AND ccad_addr_code IN ('1615AG100DK0001','1615AG102DZ0055','1615AG102DZ0438','1615AG109DY0013','1615AG103DM0528','1615AG108DE0627','1615AG107DD0197')
//AND ccad_addr_code IN ('1615AG100DK0001','1615AG102DZ0055','1615AG102DZ0438')

ORDER BY  ccad_anls_cod3 ASC ,ccad_long_desc,ccad_addr_code,ccad_addr_code ASC, ccad_addr_code ASC, ccad_addr_type ASC, 
										 
inpol_policy_number ASC,  acunl_acct_crcy ASC, acunl_docu_stat ASC, acunl_docu_year ASC, 
acunl_docu_perd ASC, 
//(IF acunl_auto_serl <= -300000 AND acunl_auto_serl > -400000 THEN DATEADD( year, 100, acunl_docu_date) ELSE acunl_docu_date ENDIF) ASC, 
acunl_auto_serl ASC, acunl_line_nmbr ASC
;
";
    $having = '';
    $where = '';
    if ($_POST['fld_remove_due_days'] > 0) {
        $where = "AND fn_datediff('day',acunl_dues_date,NOW()) >= " . $_POST['fld_remove_due_days'];
    }

    $sql .= "
select
//select * from #temp
//clo_document_number,
SUM(acunl_acct_amnt) as clo_total_original_amount,
SUM(clo_os_amount)as clo_total_os_amount,
MIN(acunl_dues_date) as clo_min_due_date,
fn_datediff('day',MIN(acunl_dues_date),NOW())as clo_max_due_days,
clo_agent_code,
clo_agent_description,
ccad_addr_code,
ccad_long_desc,
acunl_acct_serl
//acunl_docu_year,
//acunl_docu_perd,
//acunl_docu_date
from
#temp
WHERE
1=1
AND clo_os_amount > 0
" . $where . "
GROUP BY

clo_agent_code,
clo_agent_description,
ccad_addr_code,
ccad_long_desc,
acunl_acct_serl
;
    ";

//echo $sql;exit();

    return $sql;
}

function insertIntoWorksheet($row)
{
    global $db;
    /***
     * Agent code -> esws_text_01
     * Agent Description -> esws_text_02
     * Address/Account Code -> esws_text_03
     * Client/Account Name long description -> esws_text_04
     * Account Serial -> esws_int_01
     * clo_max_due_days -> esws_int_02
     * clo_total_original_amount -> esws_double_01
     * clo_total_os_amount -> esws_double_02
     * clo_min_due_date -> esws_datetime_01
     */

//standard info
    $newData['fld_type'] = 'SMS_Account_Balances';
    $newData['fld_status'] = 'Outstanding';
    $newData['fld_year'] = $_POST['fld_up_to_year'];
    $newData['fld_period'] = $_POST['fld_up_to_period'];
    $newData['fld_as_at_date'] = $_POST['fld_as_at_date'];

    $newData['fld_text_01'] = $row['clo_agent_code'];
    $newData['fld_text_02'] = $row['clo_agent_description'];
    $newData['fld_text_03'] = $row['ccad_addr_code'];
    $newData['fld_text_04'] = $row['ccad_long_desc'];
    $newData['fld_int_01'] = $row['acunl_acct_serl'];
    $newData['fld_double_01'] = $row['clo_total_original_amount'];
    $newData['fld_double_02'] = $row['clo_total_os_amount'];
    $newData['fld_datetime_01'] = $row['clo_min_due_date'];
    $newData['fld_int_02'] = $row['clo_max_due_days'];

    $db->db_tool_insert_row('es_worksheets', $newData, 'fld_', 0, 'esws_', 'execute');

}

?>
