<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/2/2019
 * Time: 12:15 ΠΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Agent Commission Type Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $_POST['fld_agent_ID'] = $_POST['aid'];

    $db->working_section = 'Agent Commission Type Insert';
    $db->db_tool_insert_row('agent_commission_types', $_POST, 'fld_', 0, 'agcmt_');
    header("Location: commission_types.php?aid=" . $_POST['aid']);
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Agent Commission Type Modify';

    $db->db_tool_update_row('agent_commission_types', $_POST, "`agcmt_agent_insurance_type_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'agcmt_');
    header("Location: commission_types.php?aid=" . $_POST['aid']);
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'Agent Commission Type Get data';
    $sql = "SELECT * FROM `agent_commission_types` WHERE `agcmt_agent_insurance_type_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {
    //$data['agcmt_status'] = 'Active';
}


$db->show_empty_header();
?>
    <div class="container">
        <form name="myForm" id="myForm" method="post" action="" onsubmit="">
            <div class="alert alert-dark text-center">
                <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                    &nbsp;Agent Commission Type</b>
            </div>


            <div class="form-group row">
                <label for="fld_status" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-2">
                    <select name="fld_status" id="fld_status"
                            class="form-control"
                            required>
                        <option value="Active" <?php if ($data['agnt_status'] == 'Active') echo 'selected'; ?>>
                            Active
                        </option>
                        <option value="InActive" <?php if ($data['agnt_status'] == 'InActive') echo 'selected'; ?>>
                            In-active
                        </option>
                    </select>
                </div>

                <label for="fld_insurance_company_ID" class="col-sm-2 col-form-label">Ins. Company</label>
                <div class="col-sm-6">
                    <select name="fld_insurance_company_ID" id="fld_insurance_company_ID"
                            class="form-control"
                            required>
                        <option value=""></option>
                        <?php
                        $icResult = $db->query("SELECT * FROM ina_insurance_companies WHERE inainc_status = 'Active' ORDER BY inainc_name ASC");
                        while ($ic = $db->fetch_assoc($icResult)) {

                            ?>
                            <option value="<?php echo $ic['inainc_insurance_company_ID']; ?>"
                                <?php if ($ic['inainc_insurance_company_ID'] == $data['agcmt_insurance_company_ID']) echo 'selected'; ?>>
                                <?php echo $ic['inainc_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

            </div>
            <div class="form-group row">
                <label for="fld_policy_type_ID" class="col-sm-2 col-form-label">Policy Type</label>
                <div class="col-sm-2">
                    <select name="fld_policy_type_ID" id="fld_policy_type_ID"
                            class="form-control"
                            required>
                        <option value=""></option>
                        <?php
                        $ptResult = $db->query("SELECT * FROM ina_policy_types WHERE inapot_status = 'Active' ORDER BY inapot_name ASC");
                        while ($pt = $db->fetch_assoc($ptResult)) {

                            ?>
                            <option value="<?php echo $pt['inapot_policy_type_ID']; ?>"
                                <?php if ($pt['inapot_policy_type_ID'] == $data['agcmt_policy_type_ID']) echo 'selected'; ?>>
                                <?php echo $pt['inapot_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <label for="fld_commission_amount" class="col-sm-2 col-form-label">Commission</label>
                <div class="col-sm-2">
                    <input name="fld_commission_amount" type="text" id="fld_commission_amount"
                           class="form-control"
                           value="<?php echo $data["agcmt_commission_amount"]; ?>"
                           required>
                </div>
                <div class="col-4">%</div>
            </div>


            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label"></label>
                <div class="col-sm-8">
                    <input name="action" type="hidden" id="action"
                           value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                    <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                    <input name="aid" type="hidden" id="aid" value="<?php echo $_GET["aid"]; ?>">
                    <input type="button" value="Back" class="btn btn-secondary"
                           onclick="window.location.assign('commission_types.php?aid=<?php echo $_GET["aid"]; ?>')">
                    <input type="submit" name="Submit" id="Submit"
                           value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Agent Commission Type"
                           class="btn btn-secondary" onclick="submitForm()">
                </div>
            </div>

        </form>
    </div>
    <script>
        function submitForm() {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                document.getElementById('Submit').disabled = true
            }
        }
    </script>
<?php
$db->show_empty_footer();
?>