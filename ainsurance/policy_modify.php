<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/1/2019
 * Time: 11:10 ΠΜ
 */

include("../include/main.php");
include("policy_class.php");
include('../scripts/form_validator_class.php');
$db = new Main();
$db->admin_title = "AInsurance Policy Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $_POST['fld_for_user_group_ID'] = $db->user_data['usr_users_groups_ID'];
    $_POST['fld_period_starting_date'] = $db->convert_date_format($_POST['fld_period_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_financial_date'] = $db->convertDateToUS($_POST['fld_financial_date']);
    $_POST['fld_status'] = 'Outstanding';

    //init fields
    $_POST['fld_replacing_ID'] = 0;
    $_POST['fld_replaced_by_ID'] = 0;

    $db->working_section = 'AInsurance Policy Insert';
    $newID = $db->db_tool_insert_row('ina_policies', $_POST, 'fld_', 1, 'inapol_');

    //fix the installment ID
    $newData['installment_ID'] = $newID;
    $db->db_tool_update_row('ina_policies', $newData, 'inapol_policy_ID = '.$newID, $newID,
        '','execute','inapol_');

    //validate policy number
    $policy = new Policy($newID);
    if ($policy->validatePolicyNumber() == false){
        $db->generateSessionAlertError($policy->errorDescription);
        //reset the policy number
        $resetNumData['policy_number'] = '';
        $db->db_tool_update_row('ina_policies', $resetNumData, 'inapol_policy_ID = '.$newID, $newID,
            '','execute','inapol_');
        header("Location: policy_modify.php?lid=" . $newID);
        exit();
    }

    if ($_POST['sub-action'] == 'exit') {
        header("Location: policies.php");
        exit();
    } else {
        header("Location: policy_modify.php?lid=" . $newID);
        exit();
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Policy Modify';

    $policy = new Policy($_POST['lid']);
    if ($policy->checkInsuranceTypeChange($_POST['fld_type_code']) == false) {

        //remove the type change and generate error
        unset($_POST['fld_type_code_ID']);
        $db->generateAlertError('Clear all the items first before you can change the Policy Type');

    }

    $_POST['fld_period_starting_date'] = $db->convert_date_format($_POST['fld_period_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_financial_date'] = $db->convertDateToUS($_POST['fld_financial_date']);

    if ($policy->policyData['inapol_status'] == 'Outstanding') {
        $db->db_tool_update_row('ina_policies', $_POST, "`inapol_policy_ID` = " . $_POST["lid"],
            $_POST["lid"], 'fld_', 'execute', 'inapol_');
    }

    if ($_POST['sub-action'] == 'exit') {
        header("Location: policies.php");
        exit();
    }


}

//Form Validator
$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');

if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance policy Get data';
    $sql = "SELECT * FROM `ina_policies` 
            LEFT OUTER JOIN customers ON cst_customer_ID = inapol_customer_ID
            LEFT OUTER JOIN ina_insurance_companies ON inainc_insurance_company_ID = inapol_insurance_company_ID
            WHERE `inapol_policy_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
    $policy = new Policy($_GET['lid']);
    if ($policy->policyData['inapol_status'] != 'Outstanding') {
        $formValidator->disableForm(array('buttons'));
    }
} else {

}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();

?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-sm-block"></div>
            <div class="col-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo $db->showLangText('Insert Policy','Δημιουργία Συμβολαίου'); else echo $db->showLangText('Update Policy','Αλλαγή Συμβολαίου'); ?></b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_underwriter_ID" class="col-md-2 col-form-label"><?php echo $db->showLangText('Underwriter','Ασφαλιστής');?></label>
                        <div class="col-md-4">
                            <select name="fld_underwriter_ID" id="fld_underwriter_ID"
                                    class="form-control"
                                    onchange="loadInsuranceCompanies();">
                                <option value=""></option>
                                <?php
                                //if user rights <= 2 then show all underwriters. Else show only in same group
                                if ($db->user_data['usr_user_rights'] <= 2){
                                    $groupFilter = '';
                                }
                                else {
                                    $groupFilter = 'AND usg_users_groups_ID = '.$db->user_data['usr_users_groups_ID'];
                                }
                                $sql = "SELECT * FROM ina_underwriters
                                        JOIN users ON usr_users_ID = inaund_user_ID
                                        JOIN users_groups ON usr_users_groups_ID = usg_users_groups_ID
                                        WHERE
                                        1=1 
                                        ".$groupFilter." 
                                        AND inaund_status = 'Active' 
                                        ORDER BY usr_name ASC";
                                echo $sql;
                                $result = $db->query($sql);
                                while ($underwriter = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $underwriter['inaund_underwriter_ID']; ?>"
                                        <?php if ($data['inapol_underwriter_ID'] == $underwriter['inaund_underwriter_ID']) echo 'selected'; ?>
                                    ><?php echo $underwriter['usr_name']; ?></option>
                                <?php } ?>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_underwriter_ID',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => $db->showLangText('Must Select Underwriter', 'Επιλέξατε Ασφαλιστή')
                                ]);
                            ?>
                        </div>

                        <div class="col-6">
                            <?php if ($data['inapol_replacing_ID'] > 0) { ?>
                                <a href="policy_modify.php?lid=<?php echo $data['inapol_replacing_ID']; ?>">
                                    <i class="fas fa-angle-double-left"></i>&nbsp;
                                </a>
                            <?php }
                            if ($data['inapol_replaced_by_ID'] > 0) { ?>
                                <a href="policy_modify.php?lid=<?php echo $data['inapol_replaced_by_ID']; ?>">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_insurance_company_ID" class="col-md-2 col-form-label">
                            <?php echo $db->showLangText('Company','Εταιρεία');?>
                        </label>
                        <div class="col-md-4">
                            <select name="fld_insurance_company_ID" id="fld_insurance_company_ID"
                                    class="form-control" onchange="loadPolicyTypes();">
                                <?php if ($_GET['lid'] > 0) { ?>
                                    <option value="<?php echo $data['inainc_insurance_company_ID']; ?>">
                                        <?php echo $data['inainc_name']; ?>
                                    </option>
                                <?php }//if ?>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_insurance_company_ID',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                            <script>

                                function loadInsuranceCompanies(clear = true) {
                                    let underwriterSelected = $('#fld_underwriter_ID').val();
                                    if (underwriterSelected > 0) {
                                        Rx.Observable.fromPromise($.get("underwriters/underwriters_api.php?section=underwriter_commission_types_insurance_companies&underwriter=" + underwriterSelected))
                                            .subscribe((response) => {
                                                    data = response;
                                                },
                                                () => {
                                                }
                                                ,
                                                () => {
                                                    if (clear == true) {
                                                        clearDropDown('fld_insurance_company_ID');
                                                        loadDropDown('fld_insurance_company_ID', data);
                                                    } else {
                                                        loadDropDown('fld_insurance_company_ID', data);
                                                        loadPolicyTypes(false);
                                                    }

                                                }
                                            )
                                        ;
                                    }
                                }

                            </script>
                        </div>

                        <label for="fld_type_code" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Type','Τύπος');?>
                        </label>
                        <div class="col-md-3">
                            <input type="hidden" id="type_code_db" name="type_code_db" value="<?php echo $data['inapol_type_code']; ?>">
                            <select name="fld_type_code" id="fld_type_code"
                                    class="form-control"
                                    onchange="insuranceTypeChange()">
                                <?php if ($_GET['lid'] > 0) { ?>
                                    <option value="<?php echo $data['inapol_type_code']; ?>">
                                        <?php echo $data['inapol_type_code']; ?>
                                    </option>
                                <?php }//if ?>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_type_code',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => $db->showLangText('Must Select Type', 'Επιλέξατε Τύπο')
                                ]);
                            ?>
                            <div class="invalid-feedback" id="errorDeleteAllItems">
                                <?php echo $db->showLangText('Must delete all items before you can change the type','Πρέπει να διαγράψετε όλα τα στοιχεία για να μπορέσετε να αλλάξετε τον τύπο');?>
                            </div>
                        </div>
                        <script>
                            function loadPolicyTypes(clear = true) {

                                let underwriterSelected = $('#fld_underwriter_ID').val();
                                let insuranceCompanySelected = $('#fld_insurance_company_ID').val();

                                if (underwriterSelected > 0 && insuranceCompanySelected > 0) {
                                    Rx.Observable.fromPromise($.get("underwriters/underwriters_api.php?section=agent_commission_types_policy_types&underwriter="
                                        + underwriterSelected + '&inscompany=' + insuranceCompanySelected))
                                        .subscribe((response) => {
                                                data = response;
                                                //console.log(data);
                                            },
                                            () => {
                                            }
                                            ,
                                            () => {
                                                if (clear == true) {
                                                    clearDropDown('fld_type_code');
                                                }
                                                loadDropDown('fld_type_code', data);
                                                //check if policy type is changed
                                                insuranceTypeChange();
                                            }
                                        )
                                    ;
                                }
                            }
                        </script>

                    </div>

                    <div class="form-group row">
                        <label for="customerSelect" class="col-md-2 col-form-label">
                            <?php echo $db->showLangText('Customer','Πελάτης');?>
                        </label>
                        <div class="col-md-4">
                            <input name="customerSelect" type="text" id="customerSelect"
                                   class="form-control"
                                   value="<?php echo $data["cst_name"] . " " . $data['cst_surname']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'customerSelect',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'requiredAddedCustomCode' => '|| $("#fld_customer_ID").val() == ""',
                                    'invalidText' => $db->showLangText('Must enter Customer', 'Πρέπει να εισάγετε Πελάτη')
                                ]);
                            ?>
                            <input name="fld_customer_ID" id="fld_customer_ID" type="hidden"
                                   value="<?php echo $data['cst_customer_ID']; ?>">
                            <script>

                                $('#customerSelect').autocomplete({
                                    source: 'customers/customers_api.php?section=customers',
                                    delay: 500,
                                    minLength: 2,
                                    messages: {
                                        noResults: '',
                                        results: function () {
                                            //console.log('customer auto');
                                        }
                                    },
                                    focus: function (event, ui) {
                                        $('#customerSelect').val(ui.item.label);
                                        return false;
                                    },
                                    select: function (event, ui) {
                                        $('#customerSelect').val(ui.item.label);
                                        $('#fld_customer_ID').val(ui.item.value);

                                        $('#cus_number').html(ui.item.value);
                                        $('#cus_id').html(ui.item.identity_card);
                                        $('#cus_work_tel').html(ui.item.work_tel);
                                        $('#cus_mobile').html(ui.item.mobile);
                                        return false;
                                    }

                                });
                            </script>
                        </div>

                        <label for="fld_policy_number" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Policy Number','Αρ.Συμβολαίου');?>
                        </label>
                        <div class="col-md-2">
                            <input name="fld_policy_number" type="text" id="fld_policy_number"
                                   class="form-control" onkeyup="$('#policyNumberValidation').val('error');"
                                   value="<?php echo $data["inapol_policy_number"]; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_policy_number',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'requiredAddedCustomCode' => '|| $("#policyNumberValidation").val() != "valid"'
                                ]);
                            ?>
                        </div>
                        <div class="col-md-1">
                            <i class="fas fa-check" id="policyNumberCheck" style="display: none;"></i>
                            <i class="fas fa-times" id="policyNumberError" style="display: none;"></i>
                            <img src="../images/spinner-transparent.gif" height="28px" id="policyNumberSpinner" style="display: none;">
                            <input type="hidden" id="policyNumberValidation" value="valid">
                        </div>
                    </div>

                    <script>
                        //validate policy number with delay of 500 milliseconds
                        function delay(callback, ms) {
                            var timer = 0;
                            return function() {
                                var context = this, args = arguments;
                                clearTimeout(timer);
                                timer = setTimeout(function () {
                                    callback.apply(context, args);
                                }, ms || 0);
                            };
                        }
                        $('#fld_policy_number').keyup(delay(function (e) {
                            //console.log('Time elapsed!', this.value);
                            let policyNumber = this.value;
                            let policyID = '<?php echo $_GET['lid'];?>';

                            $('#policyNumberSpinner').show();
                            $('#policyNumberError').hide();
                            $('#policyNumberCheck').hide();
                            $('#policyNumberValidation').val('valid');

                            Rx.Observable.fromPromise($.get("policy_api.php?section=check_if_policy_number_exists&policyNumber=" + policyNumber + "&policyID=" + policyID))
                                .subscribe((response) => {
                                        data = response;
                                        console.log(data);
                                    },
                                    () => {
                                        $('#policyNumberSpinner').hide();
                                        $('#policyNumberError').show();
                                        $('#policyNumberValidation').val('error');
                                    }
                                    ,
                                    () => {
                                        $('#policyNumberSpinner').hide();
                                        if (data['clo_total_policies'] > 0){
                                            $('#policyNumberError').show();
                                            $('#policyNumberValidation').val('error');
                                        }
                                        else {
                                            $('#policyNumberCheck').show();
                                        }
                                    }
                                )
                            ;




                        }, 500));

                    </script>

                    <div class="form-group row">
                        <div class="col-md-6 text-center">
                            <b>#</b><span id="cus_number"><?php echo $data['cst_customer_ID']; ?></span>
                            <b>ID:</b> <span id="cus_id"><?php echo $data['cst_identity_card']; ?></span>
                            <b><?php echo $db->showLangText('Tel:','Τηλ:');?></b> <span id="cus_work_tel"><?php echo $data['cst_work_tel_1']; ?></span>
                            <b><?php echo $db->showLangText('Mobile:','Κινητό:');?></b> <span id="cus_mobile"><?php echo $data['cst_mobile_1']; ?></span>
                        </div>

                        <label for="fld_period_starting_date" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Period Starting Date','Ημ.Έναρξης Περιόδου');?>
                        </label>
                        <div class="col-md-2">
                            <input name="fld_period_starting_date" type="text" id="fld_period_starting_date"
                                   class="form-control"
                                   value="" onchange="applyDatesAuto();">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_period_starting_date',
                                    'fieldDataType' => 'date',
                                    'datePickerValue' => $db->convert_date_format($data['inapol_period_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                                    'enableDatePicker' => true,
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>
                    <script>
                        function applyDatesAuto(){
                            let periodStDate = $('#fld_period_starting_date').val();
                            if ($('#fld_starting_date').val() == ''){
                                $('#fld_starting_date').val(periodStDate);
                            }
                            if ($('#fld_financial_date').val() == ''){
                                $('#fld_financial_date').val(periodStDate);
                            }
                            if ($('#fld_expiry_date').val() == ''){
                                fillExpiryDate('year',1);
                            }
                        }
                    </script>

                    <div class="form-group row">
                        <label for="fld_name" class="col-md-2 col-form-label">
                            <?php echo $db->showLangText('Status','Κατάσταση');?>
                        </label>
                        <div class="col-md-2">
                            <?php echo $data['inapol_status']; ?>

                        </div>
                        <div class="col-md-2">
                            <?php if ($data['inapol_status'] == 'Outstanding') { ?>
                                <button id="changeStatus" name="changeStatus" class="form-control alert-success"
                                        type="button"
                                        onclick="window.location.assign('policy_change_status.php?lid=<?php echo $data['inapol_policy_ID']; ?>')">
                                    <?php echo $db->showLangText('Activate','Ενεργοποίηση');?>
                                </button>
                            <?php } ?>
                            <?php if ($data['inapol_status'] == 'Active') { ?>
                                <button id="changeStatus" name="changeStatus" class="form-control alert-success"
                                        type="button"
                                        onclick="window.location.assign('policy_change_status.php?lid=<?php echo $data['inapol_policy_ID']; ?>')">
                                    <?php echo $db->showLangText('Endorse/Cancel','Αλλαγή/Ακύρωση');?>
                                </button>
                            <?php } ?>
                        </div>

                        <label for="fld_starting_date" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Starting Date','Ημερομηνία Έναρξης');?>
                        </label>
                        <div class="col-md-2">
                            <input name="fld_starting_date" type="text" id="fld_starting_date"
                                   class="form-control"
                                   value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_starting_date',
                                    'fieldDataType' => 'date',
                                    'datePickerValue' => $db->convert_date_format($data['inapol_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                                    'enableDatePicker' => true,
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_process_status" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Process Status','Κατάσταση Λειτουργίας');?>
                        </label>
                        <div class="col-md-3">
                            <select name="fld_process_status" id="fld_process_status"
                                    class="form-control"
                            <?php if ($data['inapol_replacing_ID'] > 0 || $data['inapol_replaced_by_ID'] > 0) echo "disabled";?>
                            >
                                <option value="New" <?php if ($data['inapol_process_status'] == 'New') echo 'selected'; ?>>
                                    New
                                </option>
                                <option value="Renewal" <?php if ($data['inapol_process_status'] == 'Renewal') echo 'selected'; ?>>
                                    Renewal
                                </option>
                                <?php if ($data['inapol_process_status'] == 'Endorsement') { ?>
                                <option value="Endorsement" <?php if ($data['inapol_process_status'] == 'Endorsement') echo 'selected'; ?>>
                                    Endorsement
                                </option>
                                <?php } ?>
                                <?php if ($data['inapol_process_status'] == 'Cancellation') { ?>
                                    <option value="Cancellation" <?php if ($data['inapol_process_status'] == 'Cancellation') echo 'selected'; ?>>
                                        Cancellation
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <label for="fld_expiry_date" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Expiry Date','Ημερομηνία Λήξης');?> <br>
                            <span class="main_text_smaller">
                                <span style="cursor: pointer" onclick="fillExpiryDate('year',1);">1Y</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',6);">6M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',4);">4M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',3);">3M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',2);">2M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',1);">1M</span>&nbsp
                            </span>
                        </label>
                        <div class="col-md-2">
                            <input name="fld_expiry_date" type="text" id="fld_expiry_date"
                                   class="form-control"
                                   value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_expiry_date',
                                    'fieldDataType' => 'date',
                                    'datePickerValue' => $db->convert_date_format($data['inapol_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                                    'enableDatePicker' => true,
                                    'required' => true,
                                    'invalidText' => $db->showLangText('Must Enter Expiry Date', 'Πρέπει να εισάγετε Ημ.Λήξης')
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6"></div>

                        <label for="fld_financial_date" class="col-md-3 col-form-label">
                            <?php echo $db->showLangText('Financial Date','Ημερομηνία Παραγωγής');?>
                        </label>
                        <div class="col-md-2">
                            <input name="fld_financial_date" type="text" id="fld_financial_date"
                                   class="form-control"
                                   value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_financial_date',
                                    'fieldDataType' => 'date',
                                    'datePickerValue' => $db->convertDateToEU($data['inapol_financial_date']),
                                    'enableDatePicker' => true,
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                    </div>


                    <!-- TABS -->
                    <?php
                    if ($_GET['lid'] > 0) {

                        $policyTypesResult = $db->query('SELECT * FROM ina_policy_types WHERE inapot_status = "Active"');
                        while ($polType = $db->fetch_assoc($policyTypesResult)) {
                            $policyTypes[$polType['inapot_policy_type_ID']] = $polType['inapot_input_data_type'];
                        }

                        ?>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items" role="tab"
                                   aria-controls="items" aria-selected="true">
                                    <?php echo $policy->getTypeFullName(); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="prem-tab" data-toggle="tab" href="#prem" role="tab"
                                   aria-controls="prem" aria-selected="false">
                                    <?php echo $db->showLangText('Premium','Ασφάληστρα');?>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="installments-tab" data-toggle="tab" href="#installments"
                                   role="tab"
                                   aria-controls="installments" aria-selected="false">
                                    <?php echo $db->showLangText('Installments','Δόσεις');?>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab"
                                   aria-controls="payments" aria-selected="false">
                                    <?php echo $db->showLangText('Payments','Πληρωμές');?>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="items" role="tabpanel"
                                 aria-labelledby="items-tab">
                                <iframe src="policyTabs/policy_items.php?pid=<?php echo $_GET["lid"] . "&type=" . $policy->getInputType(); ?>"
                                        frameborder="0" id="policyItemsTab" name="policyItemsTab"
                                        scrolling="0" width="100%" height="500"></iframe>
                            </div>

                            <div class="tab-pane fade" id="prem" role="tabpanel"
                                 aria-labelledby="prem-tab">
                                <iframe src="policyTabs/premium.php?pid=<?php echo $_GET["lid"] . "&type=" . $policy->getInputType(); ?>"
                                        frameborder="0" id="premTab" name="premTab"
                                        scrolling="0" width="100%" height="450"> </iframe>
                            </div>

                            <div class="tab-pane fade" id="installments" role="tabpanel"
                                 aria-labelledby="installments-tab">
                                <iframe src="policyTabs/installments.php?pid=<?php echo $_GET["lid"] . "&type=" . $policy->getInputType(); ?>"
                                        frameborder="0" id="installmentsTab" name="installmentsTab"
                                        scrolling="0" width="100%" height="600"></iframe>
                            </div>

                            <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                                <iframe src="policyTabs/payments.php?pid=<?php echo $_GET["lid"]; ?>"
                                        frameborder="0" id="paymentsTab" name="paymentsTab"
                                        scrolling="0" width="100%" height="600"></iframe>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-12 text-center alert alert-info">
                                <b><?php echo $db->showLangText('Create the policy to be able to proceed.',
                                        'Δημιουργήστε το Συμβόλαιο για να μπορέσετε να προχωρήσετε.');?></b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="height: 20px;">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-12" style="height: 15px;"></div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label"></label>
                        <div class="col-md-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="<?php echo $db->showLangText('Back','Πίσω');?>" class="btn btn-secondary"
                                   onclick="window.location.assign('policies.php')">


                            <input type="submit" value="<?php echo $db->showLangText('Save Policy','Αποθήκευση Συμβόλαιου');?>"
                                   class="btn btn-secondary" id="Save"
                                   onclick="submitForm('save');">
                            <input type="submit"
                                   value="<?php if ($_GET["lid"] == "")
                                       echo $db->showLangText('Insert Policy & Exit','Δημιουργία Συμβόλαιου και Έξοδος');
                                   else
                                       echo $db->showLangText('Save Policy & Exit','Αποθήκευση Συμβόλαιου και Έξοδος');  ?>"
                                   class="btn btn-secondary" id="Submit"
                                   onclick="submitForm('exit');">


                            <input type="hidden" name="sub-action" id="sub-action" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-1 d-none d-sm-block"></div>
        </div>
    </div>
    <script>


        function submitForm(action) {
            $('#sub-action').val(action);
            //document.getElementById('Submit').disabled = true;
            //document.getElementById('Save').disabled = true;
        }

        function insuranceTypeChange() {
            //curent option selected
            let current = $('#fld_type_code').val();
            let saved = $('#type_code_db').val();

            if (saved == '') {
                //when inserting. Nothing to do here
            }
            else {
                //check if the option is changed.
                if (current != saved){

                    let policy = '<?php echo $_GET['lid'];?>';
                    Rx.Observable.fromPromise($.get("policy_api.php?section=policy_num_of_items&policyID=" + policy))
                        .subscribe((response) => {
                                data = response;
                                //console.log(data);
                            },
                            () => {
                                //if error occurs make option back to the saved one.
                                $('#fld_type_code').val(saved);
                            }
                            ,
                            () => {
                            //console.log(data['clo_total_items']);
                                if ((data['clo_total_items']*1) > 0){
                                    $('#errorDeleteAllItems').show();
                                    $('#fld_type_code').val(saved);
                                }
                                else {
                                    $('#errorDeleteAllItems').hide();
                                    //check if the type is not empty
                                    if (current != '') {
                                        //need to refresh the page now.
                                        if (confirm('This will change the policy type. Are you sure you want to continue?')) {
                                            $('#myForm').submit();
                                        }
                                        else {
                                            $('#fld_type_code').val(saved);
                                        }
                                    }

                                }
                            }
                        )
                    ;
                }
                else {
                    //no change is found. do nothing
                    $('#errorDeleteAllItems').hide();
                }
            }



        }

        function fillExpiryDate(lengthType, lengthAmount) {
            //get period starting date
            let psDateSplit = $('#fld_period_starting_date').val().split('/');
            let newDate = new Date();
            newDate.setFullYear(psDateSplit[2]);
            newDate.setMonth((psDateSplit[1] * 1) - 1);
            newDate.setDate(psDateSplit[0]);

            if (lengthType == 'year') {
                newDate.setFullYear(newDate.getFullYear() + lengthAmount);
                newDate.setDate(newDate.getDate() - 1);
            } else if (lengthType == 'month') {
                newDate.setMonth(newDate.getMonth() + lengthAmount);
                newDate.setDate(newDate.getDate() - 1);
            }

            let day = newDate.getDate();
            let month = newDate.getMonth() + 1;
            let year = newDate.getFullYear();

            if (day < 10) {
                day = '0' + day;
            }
            if (month < 10) {
                month = '0' + month;
            }

            let result = day + '/' + month + '/' + year;

            $('#fld_expiry_date').val(result);
        }

        function clearDropDown(dropDownName) {
            $('#' + dropDownName).empty();
        }

        function loadDropDown(dropDownName, data) {
            $('#' + dropDownName).append(
                '<option value=""></option>'
            );
            $(data).each(function (index, value) {

                    //console.log(value['value'] + ' -> ' + value['label']);

                    $('#' + dropDownName).append(
                        '<option value="' + value['value'] + '">' + value['label'] + '</option>'
                    );
                }
            );
        }

        $(document).ready(function () {
            <?php if ($_GET['lid'] > 0){ ?>
            //console.log('loading companies');
            loadInsuranceCompanies(false);

            <?php } ?>
        });
    </script>
<?php
$formValidator->output();
$db->show_footer();
?>