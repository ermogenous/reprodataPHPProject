<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/1/2019
 * Time: 11:10 ΠΜ
 */

include("../include/main.php");
include("policy_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $_POST['fld_for_user_group_ID'] = $db->user_data['usr_users_group_ID'];
    $_POST['fld_period_starting_date'] = $db->convert_date_format($_POST['fld_period_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_status'] = 'Outstanding';

    $db->working_section = 'AInsurance Policy Insert';
    $newID = $db->db_tool_insert_row('ina_policies', $_POST, 'fld_', 1, 'inapol_');
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
    if ($policy->checkInsuranceTypeChange($_POST['fld_type_code_ID']) == false) {

        //remove the type change and generate error
        unset($_POST['fld_type_code_ID']);
        $db->generateAlertError('Clear all the items first before you can change the Policy Type');

    }

    $_POST['fld_period_starting_date'] = $db->convert_date_format($_POST['fld_period_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $db->db_tool_update_row('ina_policies', $_POST, "`inapol_policy_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inapol_');

    if ($_POST['sub-action'] == 'exit') {
        header("Location: policies.php");
        exit();
    }


}


if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance policy Get data';
    $sql = "SELECT * FROM `ina_policies` 
            LEFT OUTER JOIN customers ON cst_customer_ID = inapol_customer_ID
            WHERE `inapol_policy_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {

}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Policy</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_agent_ID" class="col-sm-2 col-form-label">Agent</label>
                        <div class="col-sm-4">
                            <select name="fld_agent_ID" id="fld_agent_ID"
                                    class="form-control"
                                    required
                                    onchange="loadInsuranceCompanies();">
                                <option value=""></option>
                                <?php
                                $sql = "SELECT * FROM agents
                                        JOIN users ON usr_users_ID = agnt_user_ID
                                        JOIN users_groups ON usr_users_groups_ID = usg_users_groups_ID
                                        WHERE usg_users_groups_ID = ".$db->user_data['usr_users_groups_ID']." AND agnt_status = 'Active' ORDER BY agnt_name ASC";
                                $result = $db->query($sql);
                                while ($agent = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $agent['agnt_agent_ID']; ?>"
                                        <?php if ($data['inapol_agent_ID'] == $agent['agnt_agent_ID']) echo 'selected'; ?>
                                    ><?php echo $agent['agnt_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="fld_insurance_company_ID" class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-4">
                            <select name="fld_insurance_company_ID" id="fld_insurance_company_ID"
                                    class="form-control"
                                    required
                                    onchange="loadPolicyTypes();">

                            </select>
                            <script>

                                function loadInsuranceCompanies(){

                                    let agentSelected = $('#fld_agent_ID').val();

                                    if (agentSelected > 0){
                                        Rx.Observable.fromPromise($.get("../agents/agents_api.php?section=agent_commission_types_insurance_companies&agent=" + agentSelected))
                                            .subscribe((response) =>
                                                {
                                                    data = response;
                                                },
                                                () => { }
                                                ,
                                                () => {
                                                    clearDropDown('fld_insurance_company_ID');
                                                    loadDropDown('fld_insurance_company_ID',data);
                                                }
                                            );
                                    }
                                }

                            </script>
                        </div>

                        <label for="fld_type_code_ID" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                            <select name="fld_type_code_ID" id="fld_type_code_ID"
                                    class="form-control"
                                    onchange="insuranceTypeChange()"
                                    required>
                            </select>
                        </div>
                        <script>
                            function loadPolicyTypes(){

                                let agentSelected = $('#fld_agent_ID').val();
                                let insuranceCompanySelected = $('#fld_insurance_company_ID').val();

                                if (agentSelected > 0 && insuranceCompanySelected > 0){
                                    Rx.Observable.fromPromise($.get("../agents/agents_api.php?section=agent_commission_types_policy_types&agent="
                                        + agentSelected + '&inscompany=' + insuranceCompanySelected))
                                        .subscribe((response) =>
                                            {
                                                data = response;
                                                console.log(data);
                                            },
                                            () => { }
                                            ,
                                            () => {
                                                clearDropDown('fld_type_code_ID');
                                                loadDropDown('fld_type_code_ID',data);
                                            }
                                        );
                                }
                            }
                        </script>

                    </div>

                    <div class="form-group row">
                        <label for="customerSelect" class="col-sm-2 col-form-label">Customer</label>
                        <div class="col-sm-4">
                            <input name="customerSelect" type="text" id="customerSelect"
                                   class="form-control"
                                   value="<?php echo $data["cst_name"] . " " . $data['cst_surname']; ?>"
                                   required>
                            <input name="fld_customer_ID" id="fld_customer_ID" type="hidden"
                                   value="<?php echo $data['cst_customer_ID']; ?>">
                            <script>
                                $('#customerSelect').autocomplete({
                                    source: '../customers/customers_api.php?section=customers',
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

                        <label for="fld_policy_number" class="col-sm-3 col-form-label">Policy Number</label>
                        <div class="col-sm-3">
                            <input name="fld_policy_number" type="text" id="fld_policy_number"
                                   class="form-control"
                                   value="<?php echo $data["inapol_policy_number"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 text-center">
                            <b>#</b><span id="cus_number"><?php echo $data['cst_customer_ID']; ?></span>
                            <b>ID:</b> <span id="cus_id"><?php echo $data['cst_identity_card']; ?></span>
                            <b>Tel:</b> <span id="cus_work_tel"><?php echo $data['cst_work_tel_1']; ?></span>
                            <b>Mobile:</b> <span id="cus_mobile"><?php echo $data['cst_mobile_1']; ?></span>
                        </div>

                        <label for="fld_period_starting_date" class="col-sm-3 col-form-label">
                            Period Starting Date</label>
                        <div class="col-sm-3">
                            <input name="fld_period_starting_date" type="text" id="fld_period_starting_date"
                                   class="form-control"
                                   value=""
                                   required>
                            <script>
                                $(function () {
                                    $("#fld_period_starting_date").datepicker();
                                    $("#fld_period_starting_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                    $("#fld_period_starting_date").val('<?php echo $db->convert_date_format($data["inapol_period_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-2">
                            <?php echo $data['inapol_status']; ?>

                        </div>
                        <div class="col-sm-2">
                            <?php if ($data['inapol_status'] == 'Outstanding') { ?>
                                <button id="changeStatus" name="changeStatus" class="form-control alert-success"
                                        type="button"
                                        onclick="window.location.assign('policy_change_status.php?lid=<?php echo $data['inapol_policy_ID']; ?>')">
                                    Activate
                                </button>
                            <?php } ?>
                        </div>

                        <label for="fld_starting_date" class="col-sm-3 col-form-label">Starting Date</label>
                        <div class="col-sm-3">
                            <input name="fld_starting_date" type="text" id="fld_starting_date"
                                   class="form-control"
                                   value=""
                                   required>
                            <script>
                                $(function () {
                                    $("#fld_starting_date").datepicker();
                                    $("#fld_starting_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                    $("#fld_starting_date").val('<?php echo $db->convert_date_format($data["inapol_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">

                        </div>

                        <label class="col-sm-3 col-form-label">
                            Expiry Date <br>
                            <span class="main_text_smaller">
                                <span style="cursor: pointer" onclick="fillExpiryDate('year',1);">1Y</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',6);">6M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',4);">4M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',3);">3M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',2);">2M</span>&nbsp
                                <span style="cursor: pointer" onclick="fillExpiryDate('month',1);">1M</span>&nbsp
                            </span>
                        </label>
                        <div class="col-sm-3">
                            <input name="fld_expiry_date" type="text" id="fld_expiry_date"
                                   class="form-control"
                                   value=""
                                   required>
                            <script>
                                $(function () {
                                    $("#fld_expiry_date").datepicker();
                                    $("#fld_expiry_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                    $("#fld_expiry_date").val('<?php echo $db->convert_date_format($data["inapol_expiry_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                                });
                            </script>
                        </div>
                    </div>


                    <!-- TABS -->
                    <?php
                    if ($_GET['lid'] > 0) {

                        $policyTypesResult = $db->query('SELECT * FROM ina_policy_types WHERE inapot_status = "Active"');
                        while ($polType = $db->fetch_assoc($policyTypesResult)){
                            $policyTypes[$polType['inapot_policy_type_ID']] = $polType['inapot_input_data_type'];
                        }

                        ?>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items" role="tab"
                                   aria-controls="items" aria-selected="true">
                                    <?php echo $policyTypes[$data['inapol_type_code_ID']]; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="premium-tab" data-toggle="tab" href="#premium" role="tab"
                                   aria-controls="premium" aria-selected="false">Premium</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="installments-tab" data-toggle="tab" href="#installments" role="tab"
                                   aria-controls="installments" aria-selected="false">Installments</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="items" role="tabpanel"
                                 aria-labelledby="items-tab">
                                <iframe src="policyTabs/policy_items.php?pid=<?php echo $_GET["lid"] . "&type=" . $policyTypes[$data['inapol_type_code_ID']]; ?>"
                                        frameborder="0" id="policyItemsTab" name="policyItemsTab"
                                        scrolling="0" width="100%" height="500"></iframe>
                            </div>

                            <div class="tab-pane fade" id="premium" role="tabpanel" aria-labelledby="premium-tab">
                                <iframe src="policyTabs/premium.php?pid=<?php echo $_GET["lid"] . "&type=" . $policyTypes[$data['inapol_type_code_ID']]; ?>"
                                        frameborder="0" id="premiumTab" name="premiumTab"
                                        scrolling="0" width="100%" height="350"></iframe>
                            </div>

                            <div class="tab-pane fade" id="installments" role="tabpanel" aria-labelledby="installments-tab">
                                <iframe src="policyTabs/installments.php?pid=<?php echo $_GET["lid"] . "&type=" . $policyTypes[$data['inapol_type_code_ID']]; ?>"
                                        frameborder="0" id="installmentsTab" name="installmentsTab"
                                        scrolling="0" width="100%" height="600"></iframe>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-12 text-center alert alert-info">
                                <b>Create the policy to be able to proceed.</b>
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
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('policies.php')">
                            <input type="button" name="Save" id="Save"
                                   value="Save Policy"
                                   class="btn btn-secondary" onclick="submitForm('save')">
                            <input type="button" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Policy"
                                   class="btn btn-secondary" onclick="submitForm('exit')">
                            <input type="hidden" name="sub-action" id="sub-action" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
        </div>
    </div>
    <script>


        function submitForm(action) {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                $('#sub-action').val(action);
                document.getElementById('Submit').disabled = true
                document.getElementById('Save').disabled = true
                $('#myForm').submit();
            }
        }

        function insuranceTypeChange() {
            <?php
            //check if only modify. when insert do nothing
            if ($_GET['lid'] > 0) {?>
            if (confirm('This will refresh the page. Are you sure?')) {
                submitForm('save');
            }
            else {
                $('#fld_type_code_ID').val('<?php echo $data['inapol_type_code_ID'];?>');
            }
            <?php } ?>
        }

        function fillExpiryDate(lengthType, lengthAmount) {
            //get period starting date
            let psDateSplit = $('#fld_period_starting_date').val().split('/');
            let newDate = new Date();
            newDate.setFullYear(psDateSplit[2]);
            newDate.setMonth((psDateSplit[1] *1) -1);
            newDate.setDate(psDateSplit[0]);

            if (lengthType == 'year'){
                newDate.setFullYear(newDate.getFullYear() + lengthAmount);
                newDate.setDate(newDate.getDate() - 1);
            }
            else if (lengthType == 'month'){
                newDate.setMonth(newDate.getMonth() + lengthAmount);
                newDate.setDate(newDate.getDate() - 1);
            }

            let day = newDate.getDate();
            let month = newDate.getMonth() + 1;
            let year = newDate.getFullYear();

            if (day < 10){
                day = '0' + day;
            }
            if (month < 10){
                month = '0' + month;
            }

            let result = day + '/' + month + '/' + year;

            $('#fld_expiry_date').val(result);
        }

        function clearDropDown(dropDownName){
            $('#' + dropDownName).empty();
        }

        function loadDropDown(dropDownName, data){
            $('#' + dropDownName).append(
                '<option value=""></option>'
            );
            $(data).each(function (index, value) {

                    console.log(value['value'] + ' -> '+ value['label']);

                    $('#' + dropDownName).append(
                        '<option value="' + value['value'] + '">' + value['label'] + '</option>'
                    );
                }
            );
        }
    </script>
<?php
$db->show_footer();
?>