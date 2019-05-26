<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27-May-19
 * Time: 12:52 AM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Vitamin Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Vitamin Insert';
    $db->db_tool_insert_row('vitamins', $_POST, 'fld_',0, 'vit_');
    header("Location: vitamins.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Vitamin Modify';

    $db->db_tool_update_row('vitamins', $_POST, "`vit_vitamin_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'vit_');
    header("Location: vitamins.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'Vitamin Get data';
    $sql = "SELECT * FROM `vitamins` WHERE `vit_vitamin_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}
else {
    $data['vit_active'] = 1;
}


$db->show_header();

include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();

?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Vitamin</b>
                </div>

                <div class="form-group row">
                    <label for="fld_active" class="col-sm-4 col-form-label">Active</label>
                    <div class="col-sm-8">
                        <select name="fld_active" id="fld_active"
                                class="form-control"
                                required>
                            <option value="1" <?php if ($data['vit_active'] == 1) echo 'selected';?>>Active</option>
                            <option value="0" <?php if ($data['vit_active'] == 0) echo 'selected';?>>In-active</option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_active',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => ''
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                    <div class="col-sm-8">
                        <input name="fld_code" type="text" id="fld_code"
                               class="form-control"
                               value="<?php echo $data["vit_code"]; ?>"
                               required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name" type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["vit_name"]; ?>"
                               required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description" type="text" id="fld_description"
                               class="form-control"
                               value="<?php echo $data["vit_description"]; ?>">
                    </div>
                </div>



                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('vitamins.php')" >
                        <input type="submit" name="Submit" id="Submit" value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Vitamin"
                               class="btn btn-secondary">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>
<?php
$formValidator->output();
$db->show_footer();
?>
