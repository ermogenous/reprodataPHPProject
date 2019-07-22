<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/7/2019
 * Time: 4:40 ΜΜ
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
                        <label for="statementFor" class="col-sm-3">Statement For:</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="statementFor" name="statementFor">
                                <option value="Customer"
                                    <?php if ($_POST['statementFor'] == 'Customer') echo 'selected'; ?>>Customer
                                </option>
                                <option value="Policy"
                                    <?php if ($_POST['statementFor'] == 'Policy') echo 'selected'; ?>>Policy
                                </option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'statementFor',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => 'Must select Company'
                                ]);
                            ?>
                        </div>

                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   name="searchText" id="searchText" value="<?php echo $_POST['searchText']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'searchText',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => 'Must supply search text'
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <label for="documentDateFrom" class="col-sm-3">Document Date From:</label>
                        <div class="col-sm-2">
                            <input type="text" id="documentDateFrom" name="documentDateFrom"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'documentDateFrom',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['documentDateFrom'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>

                        <label for="documentDateTo" class="col-sm-1 text-right">To:</label>
                        <div class="col-sm-2">
                            <input type="text" id="documentDateTo" name="documentDateTo"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'documentDateTo',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['documentDateTo'],
                                    'invalidText' => ''
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
                            <strong>Statement</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <form id="searchForm" name="searchForm">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Policy</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount+/-</th>
                                        <th scope="col">Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $whereFilter = '';
                                    $havingFilter = '';
                                    $whereFilterSQL1= '';
                                    $whereFilterSQL2 = '';
                                    if ($_POST['statementFor'] == 'Policy') {
                                        $whereFilter .= ' AND inapol_policy_number LIKE "%' . $_POST['searchText'] . '%"';
                                    } else if ($_POST['statementFor'] == 'Customer') {
                                        $havingFilter .= ' AND (
                                            GROUP_CONCAT(cst_name," ",cst_surname) LIKE "%' . $_POST['searchText'] . '%" 
                                            OR cst_identity_card LIKE "%' . $_POST['searchText'] . '%" 
                                            OR cst_work_tel_1 LIKE "%' . $_POST['searchText'] . '%" 
                                            OR cst_work_tel_2 LIKE "%' . $_POST['searchText'] . '%" 
                                            OR cst_fax LIKE "%' . $_POST['searchText'] . '%" 
                                            OR cst_mobile_1 LIKE "%' . $_POST['searchText'] . '%" 
                                            OR cst_mobile_2 LIKE "%' . $_POST['searchText'] . '%" 
                                         )';
                                    }

                                    //document date filter
                                    if ($_POST['documentDateFrom'] != ''){
                                        $whereFilterSQL1 .= 'AND inapi_document_date BETWEEN "'
                                            .$db->convertDateToUS($_POST['documentDateFrom']).'" AND "'.
                                            $db->convertDateToUS($_POST['documentDateTo']).'"';
                                        $whereFilterSQL2 .= 'AND inapp_payment_date BETWEEN "'
                                            .$db->convertDateToUS($_POST['documentDateFrom']).'" AND "'.
                                            $db->convertDateToUS($_POST['documentDateTo']).'"';
                                    }

                                    //make the installments brought forward row
                                    $sql = "
                                    
                                    SELECT
                                        SUM(inapi_amount) as clo_amount
                                        FROM
                                        ina_policies
                                        JOIN customers ON cst_customer_ID = inapol_customer_ID
                                        JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
                                        JOIN ina_policy_installments ON inapi_policy_ID = inapol_policy_ID
                                        WHERE
                                        inapol_underwriter_ID " . Policy::getAgentWhereClauseSql() . "
                                        " . $whereFilter . "
                                        AND inapi_document_date < '".$db->convertDateToUS($_POST['documentDateFrom'])."'
                                        AND inapi_paid_status IN ('Paid','Partial','UnPaid')
                                        AND inapol_status IN ('Active','Archived')
                                        GROUP BY
                                        cst_name,
                                        cst_surname,
                                        cst_identity_card,
                                        cst_work_tel_1,
                                        cst_work_tel_2,
                                        cst_fax,
                                        cst_mobile_1,
                                        cst_mobile_2
                                        
                                        HAVING
                                        1=1
                                        ".$havingFilter."

                                    ";
                                    $installmentsBroughtForward = $db->query_fetch($sql);

                                    //make the payments brought forward row
                                    $sql = "
                                    
                                    SELECT
                                        SUM(inapp_amount) as clo_amount
                                        FROM
                                        ina_policies
                                        JOIN customers ON cst_customer_ID = inapol_customer_ID
                                        JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
                                        JOIN ina_policy_payments ON inapp_policy_ID = inapol_policy_ID
                                        WHERE
                                        inapol_underwriter_ID " . Policy::getAgentWhereClauseSql() . "
                                        " . $whereFilter . "
                                        AND inapp_payment_date < '".$db->convertDateToUS($_POST['documentDateFrom'])."'
                                        AND inapp_status = 'Applied'
                                        AND inapol_status IN ('Active','Archived')
                                        GROUP BY
                                        cst_name,
                                        cst_surname,
                                        cst_identity_card,
                                        cst_work_tel_1,
                                        cst_work_tel_2,
                                        cst_fax,
                                        cst_mobile_1,
                                        cst_mobile_2
                                        
                                        HAVING
                                        1=1
                                        ".$havingFilter."

                                    ";
                                    $paymentsBroughtForward = $db->query_fetch($sql);

                                    //echo $sql."<br><br>\n\n";

                                    $sql = "
                                        CREATE TEMPORARY TABLE allData as
                                        SELECT
                                        inapol_policy_number,
                                        inapol_type_code,
                                        inapol_starting_date,
                                        inapol_financial_date,
                                        inapol_status,
                                        inapol_process_status,
                                        cst_name,
                                        cst_surname,
                                        cst_identity_card,
                                        cst_work_tel_1,
                                        cst_work_tel_2,
                                        cst_fax,
                                        cst_mobile_1,
                                        cst_mobile_2,
                                        inainc_code,
                                        inainc_name,
                                        'Installment' as clo_type,
                                        inapi_amount as clo_amount,
                                        inapi_document_date as clo_transaction_date
                                        FROM
                                        ina_policies
                                        JOIN customers ON cst_customer_ID = inapol_customer_ID
                                        JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
                                        JOIN ina_policy_installments ON inapi_policy_ID = inapol_policy_ID
                                        WHERE
                                        inapol_underwriter_ID " . Policy::getAgentWhereClauseSql() . "
                                        AND inapol_status IN ('Active','Archived')
                                        " . $whereFilter . "
                                        " . $whereFilterSQL1 . "
                                        
                                        GROUP BY
                                        inapol_policy_number,
                                        inapol_type_code,
                                        inapol_starting_date,
                                        inapol_financial_date,
                                        inapol_status,
                                        inapol_process_status,
                                        cst_name,
                                        cst_surname,
                                        cst_identity_card,
                                        cst_work_tel_1,
                                        cst_work_tel_2,
                                        cst_fax,
                                        cst_mobile_1,
                                        cst_mobile_2,
                                        inainc_code,
                                        inainc_name,
                                        clo_type,
                                        clo_amount,
                                        clo_transaction_date
                                        
                                        HAVING
                                        1=1
                                        ".$havingFilter."
                                        ";
                                    $db->query($sql);
                                    //echo $sql . "\n";
                                    $sql = "
                                        
                                        INSERT INTO allData 
                                        SELECT
                                        inapol_policy_number,
                                        inapol_type_code,
                                        inapol_starting_date,
                                        inapol_financial_date,
                                        inapol_status,
                                        inapol_process_status,
                                        cst_name,
                                        cst_surname,
                                        cst_identity_card,
                                        cst_work_tel_1,
                                        cst_work_tel_2,
                                        cst_fax,
                                        cst_mobile_1,
                                        cst_mobile_2,
                                        inainc_code,
                                        inainc_name
                                        ,'Payment' as clo_type
                                        ,(inapp_amount * -1) as clo_amount
                                        ,inapp_payment_date as clo_transaction_date
                                        FROM
                                        ina_policies
                                        JOIN customers ON cst_customer_ID = inapol_customer_ID
                                        JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID
                                        JOIN ina_policy_payments ON inapp_policy_ID = inapol_policy_ID
                                        WHERE
                                        inapol_underwriter_ID " . Policy::getAgentWhereClauseSql() . "
                                        AND inapol_status IN ('Active','Archived')
                                        AND inapp_status = 'Applied'
                                        " . $whereFilter . "
                                        " . $whereFilterSQL2 . "
                                        GROUP BY
                                        inapol_policy_number,
                                        inapol_type_code,
                                        inapol_starting_date,
                                        inapol_financial_date,
                                        inapol_status,
                                        inapol_process_status,
                                        cst_name,
                                        cst_surname,
                                        cst_identity_card,
                                        cst_work_tel_1,
                                        cst_work_tel_2,
                                        cst_fax,
                                        cst_mobile_1,
                                        cst_mobile_2,
                                        inainc_code,
                                        inainc_name,
                                        clo_type,
                                        clo_amount,
                                        clo_transaction_date
                                        
                                        HAVING
                                        1=1
                                        ".$havingFilter."
                                        ";
                                    $db->query($sql);
                                    //echo $sql . "\n";

                                    $sql = "
                                      SELECT * 
                                      FROM allData
                                      ORDER BY clo_transaction_date ASC";
                                    $result = $db->query($sql);
                                    //echo $sql . "\n";

                                    $sql = "DROP TEMPORARY TABLE allData";
                                    $db->query($sql);
                                    //echo $sql."\n";

                                    //$result = $db->query($sql);

                                    //show the balance brought forward row
                                    $balanceBroughtForward = $installmentsBroughtForward['clo_amount'] - $paymentsBroughtForward['clo_amount'];
                                    if ($balanceBroughtForward == ""){
                                        $balanceBroughtForward = 0;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" align="right">Balance Brought Forward</td>
                                        <td></td>
                                        <td><?php echo $balanceBroughtForward;?></td>
                                    </tr>
                                    <?php

                                    //echo $db->prepare_text_as_html($sql);
                                    $totalRecords = 0;
                                    $balance = $balanceBroughtForward['clo_amount'];
                                    while ($row = $db->fetch_assoc($result)) {
                                        $totalRecords++;

                                        $balance+= $row['clo_amount'];

                                        ?>
                                        <tr>
                                            <td><?php echo $db->convertDateToEU($row['clo_transaction_date']); ?></td>
                                            <td><?php echo $row['cst_name']." ".$row['cst_surname']; ?></td>
                                            <td><?php echo $row['inapol_policy_number']; ?></td>
                                            <td><?php echo $row['clo_type']; ?></td>
                                            <td><?php echo $row['clo_amount']; ?></td>
                                            <td><?php echo $balance; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="5" align="left">Total Records:<?php echo $totalRecords;?></td>
                                        <td><strong><?php echo $balance; ?></strong></td>
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