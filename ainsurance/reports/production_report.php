<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/7/2019
 * Time: 4:26 ΜΜ
 */

include("../../include/main.php");
include("../policy_class.php");
include('../../scripts/form_validator_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policies View Renewals";

//Form Validator
$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');

//find underwriter
$underwriter = Policy::getUnderwriterData();

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
                        <label for="company" class="col-sm-3">Company</label>
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
                                        <?php if ($_POST['company'] == $comp['inainc_insurance_company_ID']) echo 'selected'; ?>>
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
                    </div>
                    <div class="row">
                        <label for="financialDateFrom" class="col-sm-3">Financial Date From:</label>
                        <div class="col-sm-2">
                            <input type="text" id="financialDateFrom" name="financialDateFrom"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'financialDateFrom',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['financialDateFrom'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>

                        <label for="financialDateTo" class="col-sm-1 text-right">To:</label>
                        <div class="col-sm-2">
                            <input type="text" id="financialDateTo" name="financialDateTo"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'financialDateTo',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['financialDateTo'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>

                    </div>

                    <div class="row">
                        <label for="startingDateFrom" class="col-form-label col-sm-3">Starting Date From:</label>
                        <div class="col-sm-2">
                            <input type="text" id="startingDateFrom" name="startingDateFrom"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'startingDateFrom',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['startingDateFrom'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>
                        <label for="startingDateTo" class="col-sm-1 text-right">To:</label>
                        <div class="col-sm-2">
                            <input type="text" id="startingDateTo" name="startingDateTo"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'startingDateTo',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['startingDateTo'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="groupBy1" class="col-sm-3">Group By</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="groupBy1" name="groupBy1" onchange="checkGroupBy()">
                                <option value="NONE" <?php if ($_POST['groupBy1'] == 'NONE') echo 'selected'; ?>>NONE
                                </option>
                                <option value="Company" <?php if ($_POST['groupBy1'] == 'Company') echo 'selected'; ?>>
                                    Company
                                </option>
                                <option value="Customer" <?php if ($_POST['groupBy1'] == 'Customer') echo 'selected'; ?>>
                                    Customer
                                </option>
                                <option value="Policy" <?php if ($_POST['groupBy1'] == 'Policy') echo 'selected'; ?>>
                                    Policy
                                </option>
                                <option value="Type" <?php if ($_POST['groupBy1'] == 'Type') echo 'selected'; ?>>
                                    Type
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="groupBy2" name="groupBy2" onchange="checkGroupBy()">
                                <option value="NONE" <?php if ($_POST['groupBy2'] == 'NONE') echo 'selected'; ?>>NONE
                                </option>
                                <option value="Company" <?php if ($_POST['groupBy2'] == 'Company') echo 'selected'; ?>>
                                    Company
                                </option>
                                <option value="Customer" <?php if ($_POST['groupBy2'] == 'Customer') echo 'selected'; ?>>
                                    Customer
                                </option>
                                <option value="Policy" <?php if ($_POST['groupBy2'] == 'Policy') echo 'selected'; ?>>
                                    Policy
                                </option>
                                <option value="Type" <?php if ($_POST['groupBy2'] == 'Type') echo 'selected'; ?>>
                                    Type
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="groupBy3" name="groupBy3" onchange="checkGroupBy()">
                                <option value="NONE" <?php if ($_POST['groupBy3'] == 'NONE') echo 'selected'; ?>>NONE
                                </option>
                                <option value="Company" <?php if ($_POST['groupBy3'] == 'Company') echo 'selected'; ?>>
                                    Company
                                </option>
                                <option value="Customer" <?php if ($_POST['groupBy3'] == 'Customer') echo 'selected'; ?>>
                                    Customer
                                </option>
                                <option value="Policy" <?php if ($_POST['groupBy3'] == 'Policy') echo 'selected'; ?>>
                                    Policy
                                </option>
                                <option value="Type" <?php if ($_POST['groupBy3'] == 'Type') echo 'selected'; ?>>
                                    Type
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="groupBy4" name="groupBy4" onchange="checkGroupBy()">
                                <option value="NONE" <?php if ($_POST['groupBy4'] == 'NONE') echo 'selected'; ?>>NONE
                                </option>
                                <option value="Company" <?php if ($_POST['groupBy4'] == 'Company') echo 'selected'; ?>>
                                    Company
                                </option>
                                <option value="Customer" <?php if ($_POST['groupBy4'] == 'Customer') echo 'selected'; ?>>
                                    Customer
                                </option>
                                <option value="Policy" <?php if ($_POST['groupBy4'] == 'Policy') echo 'selected'; ?>>
                                    Policy
                                </option>
                                <option value="Type" <?php if ($_POST['groupBy4'] == 'Type') echo 'selected'; ?>>
                                    Type
                                </option>
                            </select>
                        </div>
                    </div>

                    <script>
                        function checkGroupBy() {
                            $('#groupBy2').attr('disabled', true);
                            $('#groupBy3').attr('disabled', true);
                            $('#groupBy4').attr('disabled', true);
                            if ($('#groupBy1').val() != 'NONE') {
                                $('#groupBy2').attr('disabled', false);
                            }
                            if ($('#groupBy2').val() != 'NONE') {
                                $('#groupBy3').attr('disabled', false);
                            }
                            if ($('#groupBy3').val() != 'NONE') {
                                $('#groupBy4').attr('disabled', false);
                            }
                            //reset the fields
                            if ($('#groupBy1').val() == 'NONE') {
                                $('#groupBy2').val('NONE');
                                $('#groupBy3').val('NONE');
                                $('#groupBy4').val('NONE');
                            }
                            if ($('#groupBy2').val() == 'NONE') {
                                $('#groupBy3').val('NONE');
                                $('#groupBy4').val('NONE');
                            }
                            if ($('#groupBy3').val() == 'NONE') {
                                $('#groupBy4').val('NONE');
                            }
                        }

                        $(document).ready(function () {
                            checkGroupBy();
                        });
                    </script>


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
                                    <?php

                                    //company filter
                                    $compFilter = '';
                                    if ($_POST['company'] != 'ALL') {
                                        $compFilter = 'AND inapol_insurance_company_ID = ' . $_POST['company'];
                                    }

                                    //financial date filter
                                    $finDateFilter = '';
                                    if ($_POST['financialDateFrom'] != '') {
                                        $finDateFilter = 'AND inapol_financial_date BETWEEN "' .
                                            $db->convertDateToUS($_POST['financialDateFrom']) . '" AND "' .
                                            $db->convertDateToUS($_POST['financialDateTo']) . '"';
                                    }
                                    //starting date filter
                                    $startingDateFilter = '';
                                    if ($_POST['startingDateFrom'] != '') {
                                        $startingDateFilter = 'AND inapol_starting_date BETWEEN "' .
                                            $db->convertDateToUS($_POST['startingDateFrom']) . '" AND "' .
                                            $db->convertDateToUS($_POST['startingDateTo']) . '"';
                                    }

                                    //group by
                                    $groupBy = '';
                                    for($i=1; $i<=4; $i++) {
                                        if ($_POST['groupBy'.$i] != 'NONE') {

                                            if ($_POST['groupBy'.$i] == 'Company'){
                                                $groupBy .= ',inainc_name';
                                                $colField[$i] = 'inainc_name';
                                                $colName[$i] = 'Company';
                                            }
                                            else if ($_POST['groupBy'.$i] == 'Customer'){
                                                $groupBy .= ',cst_name,cst_surname';
                                                $colField[$i] = 'cst_name';
                                                $colName[$i] = 'Customer';
                                            }
                                            else if ($_POST['groupBy'.$i] == 'Policy'){
                                                $groupBy .= ',inapol_policy_number';
                                                $colField[$i] = 'inapol_policy_number';
                                                $colName[$i] = 'Policy';
                                            }
                                            else if ($_POST['groupBy'.$i] == 'Type'){
                                                $groupBy .= ',inapol_type_code';
                                                $colField[$i] = 'inapol_type_code';
                                                $colName[$i] = 'Type';
                                            }
                                        }
                                    }
                                    ?>
                                    <thead>
                                    <tr>
                                        <th scope="col"><?php echo $colName[1];?></th>
                                        <th scope="col"><?php echo $colName[2];?></th>
                                        <th scope="col"><?php echo $colName[3];?></th>
                                        <th scope="col"><?php echo $colName[4];?></th>
                                        <th scope="col">Net Premium</th>
                                        <th scope="col">Fees</th>
                                        <th scope="col">Stamps</th>
                                        <th scope="col">Commission</th>
                                        <th scope="col">Gross Premium</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    $sql = "
                                    SELECT 
                                    1 as clo_group_by,
                                    SUM(inapol_premium) as clo_total_premium,
                                    SUM(inapol_fees) as clo_total_fees,
                                    SUM(inapol_stamps) as clo_total_stamps,
                                    SUM(inapol_commission) as clo_total_commission,
                                    SUM(inapol_premium + inapol_fees + inapol_stamps)as clo_gross_premium
                                    " . $groupBy . "
                                    FROM
                                    ina_policies
                                    JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
                                    JOIN customers ON cst_customer_ID = inapol_customer_ID
                                    WHERE
                                    inapol_status IN ('Active','Archived')
                                    ".$compFilter."
                                    ".$finDateFilter."
                                    ".$startingDateFilter."
                                    AND inapol_underwriter_ID " . Policy::getAgentWhereClauseSql() . "
                                    GROUP BY 
                                    clo_group_by
                                    " . $groupBy . "
                                    ORDER BY
                                    clo_group_by
                                    ".$groupBy."
                                    ";
                                    $result = $db->query($sql);

                                    //echo $db->prepare_text_as_html($sql);

                                    while ($row = $db->fetch_assoc($result)) {
                                        for($i=1;$i<=4;$i++) {
                                            if ($colField[$i] == 'cst_name') {
                                                $col[$i] = $row['cst_name'] . ' ' . $row['cst_surname'];
                                            } else {
                                                $col[$i] = $row[$colField[$i]];
                                            }
                                        }
                                        $totalNetPremium += $row['clo_total_premium'];
                                        $totalFees += $row['clo_total_fees'];
                                        $totalStamps += $row['clo_total_stamps'];
                                        $totalCommission += $row['clo_total_commission'];
                                        $totalGross += $row['clo_gross_premium'];

                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $col[1]; ?></th>
                                            <td scope="row"><?php echo $col[2]; ?></td>
                                            <td scope="row"><?php echo $col[3]; ?></td>
                                            <td scope="row"><?php echo $col[4]; ?></td>

                                            <td><?php echo $row['clo_total_premium']; ?></td>
                                            <td><?php echo $row['clo_total_fees']; ?></td>
                                            <td><?php echo $row['clo_total_stamps']; ?></td>
                                            <td><?php echo $row['clo_total_commission']; ?></td>
                                            <td><?php echo $row['clo_gross_premium']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong><?php echo $totalNetPremium;?></strong></td>
                                        <td><strong><?php echo $totalFees;?></strong></td>
                                        <td><strong><?php echo $totalStamps;?></strong></td>
                                        <td><strong><?php echo $totalCommission;?></strong></td>
                                        <td><strong><?php echo $totalGross;?></strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>


                    <?php


                }//RESULTS
                ?>

            </div>

        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>