<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/7/2019
 * Time: 4:26 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policies View Renewals";

//Form Validator
$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>

            <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row">
                        <div class="col-12 alert alert-primary text-center">
                            <strong>Production Report</strong>
                        </div>
                    </div>
                    <div class="row d-none d-md-block" style="height: 35px;"></div>

                    <div class="row">
                        <label for="company" class="col-sm-2">Company</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="company" name="company">
                                <option value="ALL">ALL</option>
                                <?php
                                $sql = "SELECT * FROM 
                                  ina_underwriter_companies
                                  JOIN ina_underwriters ON inaund_underwriter_ID = inaunc_underwriter_ID
                                  JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaunc_insurance_company_ID
                                  WHERE
                                  inaunc_status = 'Active' AND
                                  inaund_underwriter_ID = " . $underwriter['inaund_underwriter_ID'] . "
                                  LIMIT 0,25";
                                $result = $db->query($sql);
                                while ($comp = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $comp['inainc_insurance_company_ID']; ?>"
                                        <?php if ($_POST['company'] == $comp['inainc_insurance_company_ID']) echo 'selected';?>>
                                        <?php echo $comp['inainc_name']; ?>
                                    </option>
                                    <?php
                                }
                                ?>

                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'company',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => 'Must select Company'
                                ]);
                            ?>
                        </div>
                        <div class="col-sm-2">As At Date</div>
                        <div class="col-sm-3">
                            <input type="text" id="asAtDate" name="asAtDate"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'asAtDate',
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['asAtDate'],
                                    'invalidText' => 'Must Supply As At Date'
                                ]);
                            ?>
                        </div>


                    </div>


                    <!-- BUTTONS -->
                    <div class="row d-none d-sm-block" style="height: 15px;"></div>
                    <div class="form-group row">
                        <label for="name" class="col-md-5 col-form-label"></label>
                        <div class="col-md-7">
                            <input name="action" type="hidden" id="action"
                                   value="search">
                            <input type="submit"
                                   value="Search"
                                   class="btn btn-secondary" id="Submit">
                        </div>
                    </div>

                </form>


                <?php
                if ($_POST['action'] == 'search') {
                    ?>
                    <!-- RESULTS --------------------------------------------------------------------------------------------RESULTS-->
                    <div class="row">
                        <div class="col-12 alert alert-primary text-center">
                            <strong>Results</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <form id="searchForm" name="searchForm">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" class="form-control" id="revertAllCheckBoxes"
                                                   onchange="revertAll();">
                                        </th>
                                        <th scope="col">Policy</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Expiry</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    //company filter
                                    $compFilter = '';
                                    if ($_POST['company'] != 'ALL'){
                                        $compFilter = 'AND inapol_insurance_company_ID = '.$_POST['company'];
                                    }

                                    $sql = "
                                    SELECT 
                                    ina_policies.*,
                                    customers.*,
                                    (
                                        SELECT 
                                        
                                        #IF (inapit_type = 'Vehicles', GROUP_CONCAT(inapit_vh_registration), inapit_type)
                                        GROUP_CONCAT(IF (inapit_type = 'Vehicles', inapit_vh_registration, inapit_type))
                                        FROM ina_policy_items WHERE inapit_policy_ID = inapol_policy_ID
                                    )as clo_item_list,
                                    (
                                    SELECT
                                        SUM(inapi_amount - inapi_paid_amount)as clo_balance
                                        FROM
                                        ina_policy_installments
                                        WHERE
                                        inapi_paid_status IN ('UnPaid','Partial')
                                        AND inapi_policy_ID = inapol_policy_ID
                                    )as clo_balance,
                                    (
                                    SELECT SUM(inapol_premium) FROM ina_policies as ppol 
                                    WHERE ppol.inapol_installment_ID = ina_policies.inapol_installment_ID
                                    )as clo_total_period_premium,
                                    
                                    (
                                    SELECT SUM(inapol_commission) FROM ina_policies as ppol 
                                    WHERE ppol.inapol_installment_ID = ina_policies.inapol_installment_ID
                                    )as clo_total_period_commission,
                                    
                                    (
                                    SELECT SUM(inapol_fees) FROM ina_policies as ppol 
                                    WHERE ppol.inapol_installment_ID = ina_policies.inapol_installment_ID
                                    )as clo_total_period_fees,
                                    
                                    (
                                    SELECT SUM(inapol_stamps) FROM ina_policies as ppol 
                                    WHERE ppol.inapol_installment_ID = ina_policies.inapol_installment_ID
                                    )as clo_total_period_stamps
                                    
                                    FROM
                                    ina_policies
                                    JOIN customers ON cst_customer_ID = inapol_customer_ID
                                    JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
                                    WHERE
                                    inapol_status = 'Active'
                                    AND inapol_expiry_date <= '" . $db->convert_date_format($_POST['asAtDate'], 'dd/mm/yyyy', 'yyyy-mm-dd') . "'
                                    AND inapol_replaced_by_ID = 0
                                    ".$compFilter."
                                    AND inapol_underwriter_ID " . Policy::getAgentWhereClauseSql();
                                    $result = $db->query($sql);

                                    while ($policy = $db->fetch_assoc($result)) {

                                        $title =    'Unpaid Balance:         '.$policy['clo_balance'];
                                        $title .= "\nPeriod NET Premium: ".$policy['clo_total_period_premium'];
                                        $title .= "\nPeriod Commission:   ".$policy['clo_total_period_commission'];
                                        $title .= "\nPeriod Fees:                ".$policy['clo_total_period_fees'];
                                        $title .= "\nPeriod Stamps:           ".$policy['clo_total_period_stamps'];
                                        $title .= "\nGross Premium:          ".($policy['clo_total_period_premium'] + $policy['clo_total_period_fees'] + $policy['clo_total_period_stamps']);

                                        ?>
                                        <tr id="policyTR_<?php echo $policy['inapol_policy_ID']; ?>">
                                            <th scope="row">
                                                <input type="checkbox" class="form-control form-check-label"
                                                       id="checkLine_<?php echo $policy['inapol_policy_ID']; ?>">
                                            </th>
                                            <td id="linePolicyNumber_<?php echo $policy['inapol_policy_ID']; ?>"
                                            ><a href="../policy_modify.php?lid=<?php echo $policy['inapol_policy_ID'];?>"
                                                target="_blank"><?php echo $policy['inapol_policy_number']; ?></a></td>
                                            <td><?php echo $policy['cst_name'] . ' ' . $policy['cst_surname']; ?></td>
                                            <td><?php echo $policy['clo_item_list']; ?></td>
                                            <td><?php echo $db->convert_date_format($policy['inapol_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></td>
                                            <td align="center" title="<?php echo $title;?>"><?php echo $policy['clo_balance'] == '' ? 0 : $policy['clo_balance']; ?></td>
                                            <td>
                                                <img src="../../images/icon_spinner_transparent.gif" height="30"
                                                     id="spinner_<?php echo $policy['inapol_policy_ID']; ?>" style="display: none;">
                                            </td>
                                        </tr>
                                        <tr style="display: none" id="trResult_<?php echo $policy['inapol_policy_ID']; ?>">
                                            <td colspan="7" id="tdResult_<?php echo $policy['inapol_policy_ID']; ?>">

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="7">
                                            <input type="button" value="Renew Selected" id="btnReviewSelected"
                                                   class="btn btn-primary" onclick="renewSelected();">
                                            <input type="button" value="Lapse Selected" id="btnLapseSelected"
                                                   class="btn btn-danger">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>


                    <?php


                }//RESULTS
                ?>

                <div class="row">
                    <div class="col-12">
                        <textarea id="console" name="console" class="form-control" disabled rows="6">Console</textarea>
                    </div>
                </div>

            </div>



            <div class="col-1 d-none d-md-block"></div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>