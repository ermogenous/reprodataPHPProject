<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 6:23 ΜΜ
 */

include("../../include/main.php");
include("../policy_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Item Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->start_transaction();

    $db->working_section = 'AInsurance Policy Item Insert';
    $_POST['fld_policy_ID'] = $_POST['pid'];
    $_POST['fld_type'] = $_POST['type'];
    $db->db_tool_insert_row('ina_policy_items', $_POST, 'fld_', 0, 'inapit_');

    //update the policy
    $policy = new Policy($_GET['pid']);
    $policy->updatePolicyPremium();

    $db->commit_transaction();

    if ($_POST['sub-action'] == 'exit') {
        header("Location: policy_items.php?pid=" . $_POST['pid'] . "&type=" . $_POST['type']);
        exit();
    }else {
        $_GET['lid'] = $_POST['lid'];
        $_GET['pid'] = $_POST['pid'];
        $_GET['type'] = $_POST['type'];
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Policy Item Modify';
    $db->start_transaction();

    $db->db_tool_update_row('ina_policy_items', $_POST, "`inapit_policy_item_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inapit_');

    //update the policy
    $policy = new Policy($_GET['pid']);
    $policy->updatePolicyPremium();

    $db->commit_transaction();

    if ($_POST['sub-action'] == 'exit') {
        header("Location: policy_items.php?pid=".$_POST['pid']."&type=".$_POST['type']);
        exit();
    }else {
        $_GET['lid'] = $_POST['lid'];
        $_GET['pid'] = $_POST['pid'];
        $_GET['type'] = $_POST['type'];
    }


}


if ($_GET["lid"] != "") {
    $db->working_section = 'AInsurance policy Get data';
    $sql = "SELECT * FROM `ina_policy_items` 
            WHERE `inapit_policy_item_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {

}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;<?php echo $_GET['type'];?></b>
                    </div>



                    <?php
                    if ($_GET['type'] == 'Vehicles'){
                        $label = 'Vehicle';
                    ?>


                    <div class="form-group row">
                        <label for="fld_vh_registration" class="col-sm-3 col-form-label">Registration</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_vh_registration" name="fld_vh_registration"
                                   class="form-control"
                                   required
                                   value="<?php echo $data['inapit_vh_registration']; ?>">
                        </div>

                        <label for="fld_vh_body_type_code_ID" class="col-sm-3 col-form-label">Body Type</label>
                        <div class="col-sm-3">
                            <select name="fld_vh_body_type_code_ID" id="fld_vh_body_type_code_ID"
                                    class="form-control"
                                    required>
                                <?php
                                $sql = "SELECT * FROM ina_insurance_codes WHERE inaic_section = 'vehicle_body_type' ORDER BY inaic_insurance_code_ID ASC";
                                $result = $db->query($sql);
                                while ($inaic = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $inaic['inaic_insurance_code_ID']; ?>"
                                        <?php if ($data['inapit_vh_body_type_code_ID'] == $inaic['inaic_insurance_code_ID']) echo 'selected'; ?>
                                    ><?php echo $inaic['inaic_description']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_vh_cubic_capacity" class="col-sm-3 col-form-label">Cubic Capacity</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_vh_cubic_capacity" id="fld_vh_cubic_capacity"
                                   class="form-control"
                                   required
                                   value="<?php echo $data["inapit_vh_cubic_capacity"]; ?>">
                        </div>

                        <label for="fld_vh_make_code_ID" class="col-sm-3 col-form-label">Make</label>
                        <div class="col-sm-3">
                            <select name="fld_vh_make_code_ID" id="fld_vh_make_code_ID"
                                    class="form-control"
                                    required>
                                <?php
                                $sql = "SELECT * FROM ina_insurance_codes WHERE inaic_section = 'vehicle_make' ORDER BY inaic_insurance_code_ID ASC";
                                $result = $db->query($sql);
                                while ($inaic = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $inaic['inaic_insurance_code_ID']; ?>"
                                        <?php if ($data['inapit_vh_make_code_ID'] == $inaic['inaic_insurance_code_ID']) echo 'selected'; ?>
                                    ><?php echo $inaic['inaic_description']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="fld_vh_manufacture_year" class="col-sm-3 col-form-label">Manufacture Year</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_vh_manufacture_year" name="fld_vh_manufacture_year"
                                   class="form-control"
                                   required
                                   value="<?php echo $data['inapit_vh_manufacture_year'];?>">
                        </div>

                        <label for="fld_vh_model" class="col-sm-3 col-form-label">Model</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_vh_model" id="fld_vh_model"
                                   class="form-control"
                                   required
                                   value="<?php echo $data["inapit_vh_model"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_vh_passengers" class="col-sm-3 col-form-label">Passengers</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_vh_passengers" name="fld_vh_passengers"
                                   class="form-control"
                                   required
                                   value="<?php echo $data["inapit_vh_passengers"]; ?>">
                        </div>

                        <label for="fld_vh_color_code_ID" class="col-sm-3 col-form-label">Color</label>
                        <div class="col-sm-3">
                            <select name="fld_vh_color_code_ID" id="fld_vh_color_code_ID"
                                    class="form-control"
                                    required>
                                <?php
                                $sql = "SELECT * FROM ina_insurance_codes WHERE inaic_section = 'vehicle_color' ORDER BY inaic_insurance_code_ID ASC";
                                $result = $db->query($sql);
                                while ($inaic = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $inaic['inaic_insurance_code_ID']; ?>"
                                        <?php if ($data['inapit_vh_color_code_ID'] == $inaic['inaic_insurance_code_ID']) echo 'selected'; ?>
                                    ><?php echo $inaic['inaic_description']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <?php

                    }//IF VEHICLES
                    else if ($_GET['type'] == 'Risk Locations'){
                    $label = 'Risk Location';

                    ?>

                        <div class="form-group row">
                            <label for="fld_rl_address_1" class="col-sm-3 col-form-label">Address Line 1</label>
                            <div class="col-sm-3">
                                <input type="text" id="fld_rl_address_1" name="fld_rl_address_1"
                                       class="form-control"
                                       value="<?php echo $data["inapit_rl_address_1"]; ?>">
                            </div>

                            <label for="fld_rl_address_2" class="col-sm-3 col-form-label">Address Line 2</label>
                            <div class="col-sm-3">
                                <input type="text" name="fld_rl_address_2" id="fld_rl_address_2"
                                       class="form-control"
                                       value="<?php echo $data["inapit_rl_address_2"]; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_rl_address_number" class="col-sm-3 col-form-label">Address Number</label>
                            <div class="col-sm-3">
                                <input type="text" id="fld_rl_address_number" name="fld_rl_address_number"
                                       class="form-control"
                                       value="<?php echo $data["inapit_rl_address_number"]; ?>">
                            </div>

                            <label for="fld_rl_postal_code" class="col-sm-3 col-form-label">Postal Code</label>
                            <div class="col-sm-3">
                                <input type="text" name="fld_rl_postal_code" id="fld_rl_postal_code"
                                       class="form-control"
                                       value="<?php echo $data["inapit_rl_postal_code"]; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_rl_city_code_ID" class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-3">
                                <select name="fld_rl_city_code_ID" id="fld_rl_city_code_ID"
                                        class="form-control"
                                        required>
                                    <?php
                                    $sql = "SELECT * FROM codes WHERE cde_type = 'Cities' ORDER BY cde_value ASC";
                                    $result = $db->query($sql);
                                    while ($city = $db->fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $city['cde_code_ID']; ?>"
                                            <?php if ($data['inapit_rl_city_code_ID'] == $city['cde_code_ID']) echo 'selected'; ?>
                                        ><?php echo $city['cde_value']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <label for="fld_rl_construction_type" class="col-sm-3 col-form-label">Construction Type</label>
                            <div class="col-sm-3">
                                <select name="fld_rl_construction_type" id="fld_rl_construction_type"
                                        class="form-control"
                                        required>
                                        <option value="House" <?php if ($data['inapit_rl_construction_type'] == 'House') echo 'selected'; ?>>House</option>
                                        <option value="Apartment" <?php if ($data['inapit_rl_construction_type'] == 'Apartment') echo 'selected'; ?>>Apartment</option>
                                        <option value="Office" <?php if ($data['inapit_rl_construction_type'] == 'Office') echo 'selected'; ?>>Office</option>
                                </select>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="form-group row">
                        <label for="fld_insured_amount" class="col-sm-3 col-form-label">Insured Amount</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_insured_amount" name="fld_insured_amount"
                                   class="form-control"
                                   value="<?php echo $data["inapit_insured_amount"]; ?>">
                        </div>

                        <label for="fld_excess" class="col-sm-3 col-form-label">Excess</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_excess" id="fld_excess"
                                   class="form-control"
                                   value="<?php echo $data["inapit_excess"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_premium" class="col-sm-3 col-form-label">Item Premium</label>
                        <div class="col-sm-3">
                            <input type="text" name="fld_premium" id="fld_premium"
                                   class="form-control"
                                   required
                                   value="<?php echo $data["inapit_premium"]; ?>">
                        </div>

                        <?php if ($_GET['type'] == 'Vehicles'){ ?>
                        <label for="fld_mif" class="col-sm-3 col-form-label">MIF</label>
                        <div class="col-sm-3">
                            <input type="text" id="fld_mif" name="fld_mif"
                                   class="form-control"
                                   value="<?php echo $data["inapit_mif"]; ?>">
                        </div>
                        <?php  } ?>
                    </div>

                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="pid" type="hidden" id="pid" value="<?php echo $_GET["pid"]; ?>">
                            <input name="type" type="hidden" id="type" value="<?php echo $_GET["type"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary" name="BtnBack" id="BtnBack"
                                   onclick="window.location.assign('policy_items.php?pid=<?php echo $_GET['pid']."&type=".$_GET['type'];?>')">
                            <input type="button" name="Save" id="Save"
                                   value="Save <?php echo $label;?>"
                                   class="btn btn-secondary" onclick="submitForm('save')">
                            <input type="button" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; echo $label;?>"
                                   class="btn btn-secondary" onclick="submitForm('exit')">
                            <input type="hidden" name="sub-action" id="sub-action" value="">
                        </div>
                    </div>

                </form>
            </div>
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
                document.getElementById('BtnBack').disabled = true
                $('#myForm').submit();
            }
        }

        //every time this page loads reload the premium tab
        $( document ).ready(function() {
            parent.window.frames['premiumTab'].location.reload(true);
        });
    </script>
<?php
$db->show_empty_footer();
?>