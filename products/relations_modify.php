<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 11-Aug-18
 * Time: 10:45 AM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Relations Modify";


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: manufacturers.php");
    exit();

}

if ($_POST["action"] == "insert") {

    $db->db_tool_insert_row('product_relations', $_POST, 'fld_', 0, 'prdr_');
    header("Location: relations.php?lid=" . $_POST['pid'] . "&type=" . $_POST['type'] . "&area=" . $_POST['area']);
    exit();

} else if ($_POST["action"] == "update") {

    $db->db_tool_update_row('product_relations', $_POST, "`prdr_product_relations_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'prdr_');
    header("Location: relations.php?lid=" . $_POST['pid'] . "&type=" . $_POST['type'] . "&area=" . $_POST['area']);
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `product_relations` WHERE `prdr_product_relations_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}


$db->show_empty_header();
?>
<div class="container">
    <form name="myForm" id="myForm" method="post" action="" onsubmit="">

        <div class="row">
            <div class="alert alert-dark text-center col-12">
                <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                    &nbsp;Relation</b>
            </div>
        </div>

        <?php if ($_GET['type'] == 'Machine' && $_GET['area'] == 'consumables') { ?>
            <div class="form-group row">
                <label for="fld_product_child_ID" class="col-sm-4 col-form-label">Consumable</label>
                <div class="col-sm-8">
                    <select name="fld_product_child_ID" id="fld_product_child_ID"
                            class="form-control"
                            required>
                        <option value=""></option>
                        <?php
                        $prdResult = $db->query("SELECT * FROM products WHERE prd_type = 'Consumable' ORDER BY prd_code ASC");
                        while ($prd = $db->fetch_assoc($prdResult)) {

                            ?>
                            <option value="<?php echo $prd['prd_product_ID']; ?>"
                                <?php if ($prd['prd_product_ID'] == $data['prdr_product_child_ID']) echo 'selected'; ?>>
                                <?php echo $prd['prd_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input name="fld_product_parent_ID" type="hidden" id="fld_product_parent_ID" value="<?php echo $_GET["pid"]; ?>">
                    <input name="fld_child_type" type="hidden" id="fld_child_type" value="Consumable">
                </div>
            </div>
        <?php }
         if ($_GET['type'] == 'Machine' && $_GET['area'] == 'spare-parts') { ?>
            <div class="form-group row">
                <label for="fld_product_child_ID" class="col-sm-4 col-form-label">Spare Part</label>
                <div class="col-sm-8">
                    <select name="fld_product_child_ID" id="fld_product_child_ID"
                            class="form-control"
                            required>
                        <option value=""></option>
                        <?php
                        $prdResult = $db->query("SELECT * FROM products WHERE prd_type = 'SparePart' ORDER BY prd_code ASC");
                        while ($prd = $db->fetch_assoc($prdResult)) {

                            ?>
                            <option value="<?php echo $prd['prd_product_ID']; ?>"
                                <?php if ($prd['prd_product_ID'] == $data['prdr_product_child_ID']) echo 'selected'; ?>>
                                <?php echo $prd['prd_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input name="fld_product_parent_ID" type="hidden" id="fld_product_parent_ID" value="<?php echo $_GET["pid"]; ?>">
                    <input name="fld_child_type" type="hidden" id="fld_child_type" value="SparePart">
                </div>
            </div>
        <?php }
         if ($_GET['type'] == 'Consumable' && $_GET['area'] == 'machines') { ?>
            <div class="form-group row">
                <label for="fld_product_parent_ID" class="col-sm-4 col-form-label">Machine</label>
                <div class="col-sm-8">
                    <select name="fld_product_parent_ID" id="fld_product_parent_ID"
                            class="form-control"
                            required>
                        <option value=""></option>
                        <?php
                        $prdResult = $db->query("SELECT * FROM products WHERE prd_type = 'Machine' ORDER BY prd_code ASC");
                        while ($prd = $db->fetch_assoc($prdResult)) {

                            ?>
                            <option value="<?php echo $prd['prd_product_ID']; ?>"
                                <?php if ($prd['prd_product_ID'] == $data['prdr_product_parent_ID']) echo 'selected'; ?>>
                                <?php echo $prd['prd_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input name="fld_product_child_ID" type="hidden" id="fld_product_child_ID" value="<?php echo $_GET["pid"]; ?>">
                    <input name="fld_child_type" type="hidden" id="fld_child_type" value="Consumable">
                </div>
            </div>
        <?php }
         if ($_GET['type'] == 'SparePart' && $_GET['area'] == 'machines') { ?>
            <div class="form-group row">
                <label for="fld_product_parent_ID" class="col-sm-4 col-form-label">Machine</label>
                <div class="col-sm-8">
                    <select name="fld_product_parent_ID" id="fld_product_parent_ID"
                            class="form-control"
                            required>
                        <option value=""></option>
                        <?php
                        $prdResult = $db->query("SELECT * FROM products WHERE prd_type = 'Machine' ORDER BY prd_code ASC");
                        while ($prd = $db->fetch_assoc($prdResult)) {

                            ?>
                            <option value="<?php echo $prd['prd_product_ID']; ?>"
                                <?php if ($prd['prd_product_ID'] == $data['prdr_product_parent_ID']) echo 'selected'; ?>>
                                <?php echo $prd['prd_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input name="fld_product_child_ID" type="hidden" id="fld_product_child_ID" value="<?php echo $_GET["pid"]; ?>">
                    <input name="fld_child_type" type="hidden" id="fld_child_type" value="SparePart">
                </div>
            </div>
        <?php } ?>

        <div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-8 text-center">
                <input name="action" type="hidden" id="action"
                       value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">

                <input name="pid" type="hidden" id="pid" value="<?php echo $_GET["pid"]; ?>">
                <input name="type" type="hidden" id="type" value="<?php echo $_GET["type"]; ?>">
                <input name="area" type="hidden" id="area" value="<?php echo $_GET["area"]; ?>">





                <input type="submit" name="Submit" id="Submit"
                       value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Relation"
                       class="btn btn-secondary" onclick="submitForm()">
            </div>
        </div>
    </form>
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
$db->show_empty_footer();
?>
