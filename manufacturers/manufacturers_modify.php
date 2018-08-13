<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 09-Aug-18
 * Time: 5:41 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Manufacturers Modify";


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: manufacturers.php");
    exit();

}

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->db_tool_insert_row('manufacturers', $_POST, 'fld_',0, 'mnf_');
    header("Location: manufacturers.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $db->db_tool_update_row('manufacturers', $_POST, "`mnf_manufacturer_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'mnf_');
    header("Location: manufacturers.php");
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `manufacturers` WHERE `mnf_manufacturer_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}
else {
    $data['mnf_active'] = 1;
}


$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Manufacturer</b>
                </div>

                <div class="form-group row">
                    <label for="fld_active" class="col-sm-4 col-form-label">Active</label>
                    <div class="col-sm-8">
                        <select name="fld_active" id="fld_active"
                                class="form-control"
                                required>
                            <option value="1" <?php if ($data['mnf_active'] == 1) echo 'selected';?>>Active</option>
                            <option value="0" <?php if ($data['mnf_active'] == 0) echo 'selected';?>>In-active</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                    <div class="col-sm-8">
                        <input name="fld_code" type="text" id="fld_code"
                               class="form-control"
                               value="<?php echo $data["mnf_code"]; ?>"
                               required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name" type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["mnf_name"]; ?>"
                               required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description" type="text" id="fld_description"
                               class="form-control"
                               value="<?php echo $data["mnf_description"]; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_country_code_ID" class="col-sm-4 col-form-label">Country</label>
                    <div class="col-sm-8">
                        <select name="fld_country_code_ID" id="fld_country_code_ID"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <?php
                                $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC");
                                while($bt = $db->fetch_assoc($btResult)){

                            ?>
                            <option value="<?php echo $bt['cde_code_ID'];?>"
                                <?php if ($bt['cde_code_ID'] == $data['mnf_country_code_ID']) echo 'selected';?>>
                                <?php echo $bt['cde_value'];?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('manufacturers.php')" >
                        <input type="submit" name="Submit" id="Submit" value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Manufacturer"
                               class="btn btn-secondary" onclick="submitForm()">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>
<script>
    function submitForm(){
        frm = document.getElementById('myForm');
        if (frm.checkValidity() === false){

        }
        else {
            document.getElementById('Submit').disabled = true
        }
    }
</script>
<?php
$db->show_footer();
?>
