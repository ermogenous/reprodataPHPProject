<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 18/06/2020
 * Time: 12:00
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Reports - Agents- Agents commissions list";

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

$syn = new ODBCCON();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-sm-12 col-md-10">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Report - Transaction List</b>
                    </div>
                </div>
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row form-group">
                        <?php

                        $sql = "SELECT * FROM inagents
                            WHERE
                            inag_agent_type = 'A'
                            //AND inag_status_flag = 'N'";
                        $result = $syn->query($sql);
                        $allAgents = [];
                        while ($agent = $syn->fetch_assoc($result)) {
                            $allAgents[$agent['inag_agent_code']] = $agent['inag_agent_code'] . " - " . $agent['inag_long_description'];
                        }

                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_agent_from')
                            ->setFieldDescription('Select Agent From')
                            ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                            ->setFieldType('select')
                            ->setInputValue($_POST['sch_agent_from'])
                            ->setInputSelectArrayOptions($allAgents)
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-xs-12 col-sm-3">
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
                        $formB->setFieldName('sch_agent_to')
                            ->setFieldDescription('Select Agent To')
                            ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                            ->setFieldType('select')
                            ->setInputValue($_POST['sch_agent_to'])
                            ->setInputSelectArrayOptions($allAgents)
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-xs-12 col-sm-3">
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
                    </div>

                    <div class="row form-group">
                        <?php

                        $currentYear = date("Y");
                        for ($i=$currentYear-5; $i<=$currentYear; $i++){
                            $allYears[$i] = $i;
                        }

                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_year')
                            ->setFieldDescription('Select Year')
                            ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                            ->setFieldType('select')
                            ->setInputValue($_POST['sch_year'])
                            ->setInputSelectArrayOptions($allYears)
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-xs-12 col-sm-3">
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

                    </div>


                    <div class="row" style="height: 25px;"></div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="hidden" id="action" name="action" value="show">
                            <input type="submit" value="Show Report" class="form-control btn btn-primary"
                                   style="width: 180px;">
                        </div>
                    </div>
            </div>
            </form>
        </div>
        <div class="col-1 d-none d-md-block"></div>
    </div>
<?php
if ($_POST['action'] == 'show') {
    $sql = "
    SELECT inagentsinsurancetypes.inait_agent_serial ,
            inag_agent_code,
            inag_long_description,
            inity_long_description,
            inagentsinsurancetypes.inait_insurance_year ,
            inagentsinsurancetypes.inait_last_user ,
            inagentsinsurancetypes.inait_last_update ,
            inagentsinsurancetypes.inait_status_flag ,
            inagentsinsurancetypes.inait_status_update ,
            inagentsinsurancetypes.inait_cover_accepted ,
            inagentsinsurancetypes.inait_commission_percentage ,
            inagentsinsurancetypes.inait_policy_number ,
            inagentsinsurancetypes.inait_claim_number ,
            inagentsinsurancetypes.inait_target ,
            inagentsinsurancetypes.inait_profit_commission ,
            inagentsinsurancetypes.inait_status_reason ,
            inagentsinsurancetypes.inait_quotation_number ,
            inagentsinsurancetypes.inait_commission_expense_account ,
            inagentsinsurancetypes.inait_commission_percentage1 ,
            inagentsinsurancetypes.inait_insurance_type_serial ,
            inagentsinsurancetypes.inait_ga_income_account ,
            inagentsinsurancetypes.inait_ga_mif_account ,
            inagentsinsurancetypes.inait_ga_stamps_account ,
            inagentsinsurancetypes.inait_ga_fees_account ,
            inagents.inag_agent_type ,
            inagentsinsurancetypes.inait_payment_rsrv_limit ,
            inagentsinsurancetypes.inait_payment_rsrv_reestimation_limit ,
            inagentsinsurancetypes.inait_payment_rsrv_warning_percentage ,
            inagentsinsurancetypes.inait_payment_limit ,
            inagentsinsurancetypes.inait_claims_approval_users ,
            inagentsinsurancetypes.inait_last_cover_note_no ,
            ingeneralagents.inga_branch_agent ,
            inagents.inag_branch_agent ,
            inagentsinsurancetypes.inait_auto_serial ,
            ininsurancetypes.inity_insurance_type ,
            CAST(inait_agent_serial AS CHAR) + '/' + CAST(inait_insurance_year AS CHAR) as clo_log_description_field,
            ininsurancetypes.inity_commission_on_fees ,
            inagentsinsurancetypes.inait_commission_percentage2 ,
            inagentsinsurancetypes.inait_commission_percentage3 ,
            inagentsinsurancetypes.inait_commission_percentage4 ,
            inagentsinsurancetypes.inait_commission_percentage_fee_new ,
            inagentsinsurancetypes.inait_commission_percentage5 ,
            inagentsinsurancetypes.inait_print_on_post_new ,
            inagentsinsurancetypes.inait_print_on_post_endorsement ,
            inagentsinsurancetypes.inait_print_on_post_cancelation ,
            COALESCE(inisf_commission_label_alt1, '') As inisf_commission_label_alt1,
            COALESCE(inisf_commission_label_alt2, '') As inisf_commission_label_alt2,
            COALESCE(inisf_commission_label_alt3, '') As inisf_commission_label_alt3,
            COALESCE(inisf_commission_label_alt4, '') As inisf_commission_label_alt4,
            COALESCE(inisf_commission_label_alt5, '') As inisf_commission_label_alt5,
            COALESCE(inisf_commission_label_alt6, '') As inisf_commission_label_alt6,
            COALESCE(inisf_commission_label_alt7, '') As inisf_commission_label_alt7,
            COALESCE(inisf_commission_label_alt8, '') As inisf_commission_label_alt8,
            COALESCE(inisf_commission_label_alt9, '') As inisf_commission_label_alt9,
            COALESCE(inisf_commission_label_alt10, '') As inisf_commission_label_alt10,
            COALESCE(inisf_commission_label_def, 'Default') As inisf_commission_label_def,
            inagentsinsurancetypes.inait_commission_percentage6 ,
            inagentsinsurancetypes.inait_commission_percentage7 ,
            inagentsinsurancetypes.inait_commission_percentage8 ,
            inagentsinsurancetypes.inait_commission_percentage9 ,
            inagentsinsurancetypes.inait_commission_percentage10 ,
            inagentsinsurancetypes.inait_commission_percentage_fee_renew ,
            inagentsinsurancetypes.inait_commission_percentage_fee_endorse ,
            inagentsinsurancetypes.inait_commission_percentage_fee_cancel ,
            inagentsinsurancetypes.inait_commission_due_account ,
            inagentsinsurancetypes.inait_commission_sales_person_serial ,
            ininsurancetypes.inity_commission_payable_iuse ,
            inagents.inag_account_code ,
            (SELECT ccusp_user_identity
            FROM
            ccuserparameters) as ccusp_user_identity,
            ccpdecod.ccde_reco_code ,
            inagentsinsurancetypes.inait_user_defined_doc1_print_on_post ,
            inagentsinsurancetypes.inait_user_defined_doc2_print_on_post ,
            inagentsinsurancetypes.inait_user_defined_doc3_print_on_post ,
            inagents.inag_internal_external_agent ,
            inagentsinsurancetypes.inait_ga_tax_extra_account ,
            inagentsinsurancetypes.inait_policy_approval_users ,
            inagentsinsurancetypes.inait_commission_fees_account ,
            ingeneralagents.inga_issuing_office_collecting ,
            inagentsinsurancetypes.inait_commission_fees_maximum_amount ,
            inagents.inag_issuing_office_collecting
            FROM
            ingeneralagents
            RIGHT OUTER JOIN inagents ON ingeneralagents.inga_agent_serial = inagents.inag_general_agent_serial, ininsurancetypes
            LEFT OUTER JOIN ininsurancesubform ON ininsurancetypes.inity_insurance_sub_form = ininsurancesubform.inisf_record_code, inagentsinsurancetypes
            LEFT OUTER JOIN ccpdecod ON inagentsinsurancetypes.inait_commission_sales_person_serial = ccpdecod.ccde_reco_serl
            WHERE
            ( inagentsinsurancetypes.inait_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial )
            and ( inagentsinsurancetypes.inait_agent_serial = inagents.inag_agent_serial )
            and ( 
                (inagents.inag_agent_code BETWEEN '" . $_POST['sch_agent_from'] . "' AND '" . $_POST['sch_agent_to'] . "') 
                And ( inagentsinsurancetypes.inait_insurance_year = ".$_POST['sch_year']." )
            ) 
            
            ORDER BY
            inag_agent_code,inity_insurance_type ASC
    ";
    $result = $syn->query($sql);
    //echo $sql;
    ?>
    <div class="row" style="height: 25px;"></div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table">


                <?php
                $previousRow = [];
                while ($row = $syn->fetch_assoc($result)) {

                    if ($row['inag_agent_code'] != $previousRow['inag_agent_code']) {
                        //show the header only on agent change
                        ?>
                        <tr class="alert alert-success">
                            <td colspan="12"
                                align="center">
                                <b><u><?php echo $row['inag_agent_code'] . " - " . $row['inag_long_description']; ?></u></b>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="12"
                            class="alert alert-info">
                            <b><u><?php echo $row['inait_insurance_year'] . " " . $row['inity_insurance_type'] . " - " . $row['inity_long_description']; ?></u></b>
                        </td>
                    </tr>
                    <tr>
                        <td>Cover: <?php echo $db->fix_int_to_double($row['inait_cover_accepted']); ?></td>
                        <td><?php echo $row['inisf_commission_label_def'] . " " . $row['inait_commission_percentage'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt1'] . " " . $row['inait_commission_percentage1'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt2'] . " " . $row['inait_commission_percentage2'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt3'] . " " . $row['inait_commission_percentage3'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt4'] . " " . $row['inait_commission_percentage4'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt5'] . " " . $row['inait_commission_percentage5'] . "%"; ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $row['inisf_commission_label_alt6'] . " " . $row['inait_commission_percentage6'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt7'] . " " . $row['inait_commission_percentage7'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt8'] . " " . $row['inait_commission_percentage8'] . "%"; ?></td>
                        <td><?php echo $row['inisf_commission_label_alt9'] . " " . $row['inait_commission_percentage9'] . "%"; ?></td>
                        <td colspan="3"><?php echo $row['inisf_commission_label_alt10'] . " " . $row['inait_commission_percentage10'] . "%"; ?></td>
                    </tr>

                    <tr>
                        <td>Paid A/C: <?php echo $row['inait_commission_expense_account']; ?></td>
                        <td>Due A/C: <?php echo $row['inait_commission_due_account']; ?></td>
                        <td>A/C Sales Person: <?php echo $row['ccde_reco_code']; ?></td>
                        <td colspan="4">Fee A/C: <?php echo $row['inait_commission_fees_account']; ?></td>
                    </tr>
                    <tr>
                        <td>Comm Fee New:<?php echo $row['inait_commission_percentage_fee_new'] . "%"; ?></td>
                        <td>Comm Fee Renew:<?php echo $row['inait_commission_percentage_fee_renew'] . "%"; ?></td>
                        <td>Comm Fee Endorse:<?php echo $row['inait_commission_percentage_fee_endorse'] . "%"; ?></td>
                        <td>Comm Fee Cancel:<?php echo $row['inait_commission_percentage_fee_cancel'] . "%"; ?></td>
                        <td>Comm Fee Max:<?php echo $row['inait_commission_fees_maximum_amount']; ?></td>
                    </tr>

                    <?php
                    $previousRow = $row;
                }
                ?>
            </table>
        </div>
    </div>
    <?php

}
?>

<?php
$formValidator->output();
$db->show_footer();
?>
