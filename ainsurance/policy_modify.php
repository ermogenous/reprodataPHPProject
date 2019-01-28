<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/1/2019
 * Time: 11:10 ΠΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $_POST['fld_for_user_group_ID'] = $db->user_data['usr_users_group_ID'];
    $_POST['fld_period_starting_date'] = $db->convert_date_format($_POST['fld_period_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $db->working_section = 'AInsurance Policy Insert';
    $db->db_tool_insert_row('ina_policies', $_POST, 'fld_',0, 'inapol_');
    header("Location: policies.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Policy Modify';

    $_POST['fld_period_starting_date'] = $db->convert_date_format($_POST['fld_period_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

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
}
else {

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
                    <label for="fld_insurance_company_ID" class="col-sm-2 col-form-label">Company</label>
                    <div class="col-sm-4">
                        <select name="fld_insurance_company_ID" id="fld_insurance_company_ID"
                                class="form-control"
                                required>
                            <?php
                            $sql = "SELECT * FROM ina_insurance_companies WHERE inainc_active = 1 ORDER BY inainc_code ASC";
                            $result = $db->query($sql);
                            while ($inaic = $db->fetch_assoc($result)){
                                ?>
                                <option value="<?php echo $inaic['inainc_insurance_company_ID'];?>"
                                    <?php if ($data['inapol_insurance_company_ID'] == $inaic['inainc_insurance_company_ID']) echo 'selected';?>
                                ><?php echo $inaic['inainc_name'];?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <label for="fld_type_code_ID" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-4">
                        <select name="fld_type_code_ID" id="fld_type_code_ID"
                                class="form-control"
                                required>
                            <?php
                                $sql = "SELECT * FROM ina_insurance_codes WHERE inaic_section = 'policy_type' ORDER BY inaic_order ASC";
                                $result = $db->query($sql);
                                while ($inaic = $db->fetch_assoc($result)){
                            ?>
                            <option value="<?php echo $inaic['inaic_insurance_code_ID'];?>"
                                <?php if ($data['inapol_type_code_ID'] == $inaic['inaic_insurance_code_ID']) echo 'selected';?>
                            ><?php echo $inaic['inaic_description'];?></option>
                            <?php } ?>
                        </select>
                    </div>


                </div>

                <div class="form-group row">
                    <label for="customerSelect" class="col-sm-2 col-form-label">Customer</label>
                    <div class="col-sm-4">
                        <input name="customerSelect" type="text" id="customerSelect"
                               class="form-control"
                               value="<?php echo $data["cst_name"]." ".$data['cst_surname']; ?>"
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
                               value="<?php echo $data["inapol_policy_number"]; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 text-center">
                        <b>#</b><span id="cus_number"><?php echo $data['cst_customer_ID']; ?></span>
                        <b>ID:</b> <span id="cus_id"><?php echo $data['cst_identity_card']; ?></span>
                        <b>Tel:</b> <span id="cus_work_tel"><?php echo $data['cst_work_tel_1']; ?></span>
                        <b>Mobile:</b> <span id="cus_mobile"><?php echo $data['cst_mobile_1']; ?></span>
                    </div>

                    <label for="fld_period_starting_date" class="col-sm-3 col-form-label">Period Starting Date</label>
                    <div class="col-sm-3">
                        <input name="fld_period_starting_date" type="text" id="fld_period_starting_date"
                               class="form-control"
                               value="<?php echo $data["inapol_period_starting_date"]; ?>">
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
                    <div class="col-sm-4">
                        <?php echo $data['inapol_status'];?>
                    </div>

                    <label for="fld_starting_date" class="col-sm-3 col-form-label">Starting Date</label>
                    <div class="col-sm-3">
                        <input name="fld_starting_date" type="text" id="fld_starting_date"
                               class="form-control"
                               value="<?php echo $data["inapol_starting_date"]; ?>">
                        <script>
                            $(function () {
                                $("#fld_starting_date").datepicker();
                                $("#fld_starting_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                $("#fld_starting_date").val('<?php echo $db->convert_date_format($data["inapol_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                            });
                        </script>
                    </div>
                </div>



                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="vehicles-tab" data-toggle="tab" href="#vehicles" role="tab" aria-controls="vehicles" aria-selected="true">Vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="riskLocation-tab" data-toggle="tab" href="#riskLocation" role="tab" aria-controls="riskLocation" aria-selected="false">Risk Location</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="premium-tab" data-toggle="tab" href="#premium" role="tab" aria-controls="premium" aria-selected="false">Premium</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="vehicles" role="tabpanel" aria-labelledby="vehicles-tab">
                        <iframe src="policyTabs/vehicles.php?pid=<?php echo $_GET["lid"]; ?>"
                                frameborder="0"
                                scrolling="0" width="100%" height="400"></iframe>
                    </div>
                    <div class="tab-pane fade" id="riskLocation" role="tabpanel" aria-labelledby="riskLocation-tab">2</div>
                    <div class="tab-pane fade" id="premium" role="tabpanel" aria-labelledby="premium-tab">3</div>
                </div>


<!-- BUTTONS -->
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('insurance_companies.php')" >
                        <input type="submit" name="Submit" id="Submit"
                               value="Save Policy"
                               class="btn btn-secondary" onclick="submitForm('save')">
                        <input type="submit" name="Submit" id="Submit"
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
    function submitForm(action){
        frm = document.getElementById('myForm');
        if (frm.checkValidity() === false){

        }
        else {
            $('#sub-action').val(action);
            document.getElementById('Submit').disabled = true
        }
    }
</script>
<?php
$db->show_footer();
?>