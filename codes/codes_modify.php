<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/8/2018
 * Time: 12:02 ΜΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Codes Modify";


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: codes.php");
    exit();

}

if ($_POST["action"] == "insert") {

    $db->db_tool_insert_row('codes', $_POST, 'fld_', 0, 'cde_');
    header("Location: codes.php?type=".$_POST['codeSelection']."&search_code=search");
    exit();

} else if ($_POST["action"] == "update") {

    $db->db_tool_update_row('codes', $_POST, "`cde_code_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'cde_');
    header("Location: codes.php?type=".$_POST['codeSelection']."&search_code=search");
    exit();

}

if ($_GET['codeSelection'] == 'code') {
    $codeLabels['cde_value_label'] = 'Value';
    $codeLabels['cde_value_label_2'] = 'Value 2';
}
else{
    $codeLabels = $db->query_fetch("SELECT * FROM `codes` WHERE `cde_type` = 'code' AND `cde_value` = '".$_GET['codeSelection']."'");
}

if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `codes` WHERE `cde_code_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

}
else {
    $data['cde_type'] = $_GET['codeSelection'];
}
//get the labels



$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="code" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Code</b>
                </div>

                <div class="form-group row">
                    <label for="business_type_ID" class="col-sm-4 col-form-label">Code Type</label>
                    <div class="col-sm-8">
                        <select name="fld_type" id="fld_type"
                                class="form-control"
                                required
                                <?php if($_GET['lid'] != '') echo 'disabled';?>>
                            <option value="code" <?php if ($data['cde_type'] == 'code') echo 'selected'; ?>>Code
                            </option>

                            <?php
                            $sql = "SELECT * FROM codes WHERE cde_type = 'code' ORDER BY cde_value_label";
                            $result = $db->query($sql);
                            while ($codes = $db->fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $codes['cde_value']; ?>"
                                    <?php if ($data['cde_type'] == $codes['cde_value']) echo 'selected'; ?>
                                ><?php echo $codes['cde_value_label']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php
                if ($_GET['codeSelection'] == 'code') {
                ?>
                <div class="form-group row">

                    <label for="name" class="col-sm-4 col-form-label">Value Label</label>
                    <div class="col-sm-8">

                        <input name="fld_value_label" type="text" id="fld_value_label"
                               class="form-control"
                               value="<?php echo $data["cde_value_label"]; ?>">

                    </div>
                </div>
                <?php } else { ?>
                    <input type="hidden" name="fld_value_label" id="fld_value_label" value="<?php echo $codeLabels['cde_value_label'];?>">
                <?php } ?>
                <div class="form-group row">
                    <label for="surname" class="col-sm-4 col-form-label"><?php echo $codeLabels['cde_value_label'];?></label>
                    <div class="col-sm-8">
                        <input name="fld_value" type="text" id="fld_value"
                               class="form-control"
                               value="<?php echo $data["cde_value"]; ?>">
                    </div>
                </div>

                <?php
                if ($_GET['codeSelection'] == 'code') {
                ?>
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Value Label 2</label>
                    <div class="col-sm-8">
                        <input name="fld_value_label_2" type="text" id="fld_value_label_2"
                               class="form-control"
                               value="<?php echo $data["cde_value_label_2"]; ?>">
                    </div>
                </div>
                <?php } else { ?>
                    <input type="hidden" name="fld_value_label_2" id="fld_value_label_2" value="<?php echo $codeLabels['cde_value_label_2'];?>">
                <?php }
                    if ($codeLabels['cde_value_label_2'] != '') {
                ?>
                <div class="form-group row">
                    <label for="surname" class="col-sm-4 col-form-label"><?php echo $codeLabels['cde_value_label_2'];?></label>
                    <div class="col-sm-8">
                        <input name="fld_value_2" type="text" id="fld_value_2"
                               class="form-control"
                               value="<?php echo $data["cde_value_2"]; ?>">
                    </div>
                </div>
                <?php } ?>


                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input name="codeSelection" id="codeSelection" type="hidden" value="<?php echo $_GET['codeSelection'];?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('codes.php?type=<?php echo $_GET['codeSelection'];?>&search_code=search')" >
                        <input type="submit" name="Submit" value="Save Code" class="btn btn-secondary">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>

<?php
$db->show_footer();
?>
