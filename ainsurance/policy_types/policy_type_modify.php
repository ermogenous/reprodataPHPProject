<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/2/2019
 * Time: 12:26 ΠΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "Policy Types Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Policy Types Insert';
    $db->db_tool_insert_row('ina_policy_types', $_POST, 'fld_', 0, 'inapot_');
    header("Location: policy_types.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Policy Types Modify';

    $db->db_tool_update_row('ina_policy_types', $_POST, "`inapot_policy_type_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inapot_');
    header("Location: policy_types.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'Policy Types Get data';
    $sql = "SELECT * FROM `ina_policy_types` WHERE `inapot_policy_type_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {
    $data['inint_status'] = 'Active';
}


$db->show_header();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Policy Type</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-3">
                            <select name="fld_status" id="fld_status"
                                    class="form-control"
                                    required>
                                <option value="Active" <?php if ($data['inapot_status'] == 'Active') echo 'selected'; ?>>
                                    Active
                                </option>
                                <option value="InActive" <?php if ($data['inapot_status'] == 'InActive') echo 'selected'; ?>>
                                    In-active
                                </option>
                            </select>
                        </div>

                        <label for="fld_code" class="col-sm-3 col-form-label">Code</label>
                        <div class="col-sm-3">
                            <input name="fld_code" type="text" id="fld_code"
                                   class="form-control"
                                   value="<?php echo $data["inapot_code"]; ?>"
                                   required>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-3">
                            <input name="fld_name" type="text" id="fld_name"
                                   class="form-control"
                                   value="<?php echo $data["inapot_name"]; ?>"
                                   required>
                        </div>

                        <label for="fld_description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-3">
                            <input name="fld_description" type="text" id="fld_description"
                                   class="form-control"
                                   value="<?php echo $data["inapot_description"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_input_data_type" class="col-sm-3 col-form-label">Input Data Type</label>
                        <div class="col-sm-3">
                            <select name="fld_input_data_type" id="fld_input_data_type"
                                    class="form-control"
                                    required>
                                <option value=""></option>
                                <option value="Vehicles" <?php if ($data['inapot_input_data_type'] == 'Vehicles') echo 'selected'; ?>>
                                    Vehicles
                                </option>
                                <option value="Member" <?php if ($data['inapot_input_data_type'] == 'Member') echo 'selected'; ?>>
                                    Member
                                </option>
                                <option value="RiskLocation" <?php if ($data['inapot_input_data_type'] == 'RiskLocation') echo 'selected'; ?>>
                                    Risk Location
                                </option>
                            </select>
                        </div>

                        <label for="fld_description" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">

                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('policy_types.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Policy Type"
                                   class="btn btn-secondary" onclick="submitForm()">
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-lg-1 col-md-1 hidden-xs hidden-sm"></div>
        </div>
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
$db->show_footer();
?>