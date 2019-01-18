<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 5:17 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Customer Groups Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Customer Group Insert';
    $db->db_tool_insert_row('customer_groups', $_POST, 'fld_',0, 'csg_');
    header("Location: customer_groups.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Customer Group Modify';

    $db->db_tool_update_row('customer_groups', $_POST, "`csg_customer_group_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'csg_');
    header("Location: customer_groups.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'Customer Groups Modify fetch data';
    $sql = "SELECT * FROM `customer_groups` WHERE `csg_customer_group_ID` = " . $_GET["lid"];
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
                        &nbsp;Customer Group</b>
                </div>

                <div class="form-group row">
                    <label for="fld_active" class="col-sm-4 col-form-label">Active</label>
                    <div class="col-sm-8">
                        <select name="fld_active" id="fld_active"
                                class="form-control"
                                required>
                            <option value="1" <?php if ($data['csg_active'] == 1) echo 'selected';?>>Active</option>
                            <option value="0" <?php if ($data['csg_active'] == 0) echo 'selected';?>>In-active</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                    <div class="col-sm-8">
                        <input name="fld_code" type="text" id="fld_code"
                               class="form-control"
                               value="<?php echo $data["csg_code"]; ?>"
                               required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description" type="text" id="fld_description"
                               class="form-control"
                               value="<?php echo $data["csg_description"]; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('customer_groups.php')" >
                        <input type="submit" name="Submit" id="Submit" value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Customer Group"
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