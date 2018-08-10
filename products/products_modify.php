<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 09-Aug-18
 * Time: 6:32 PM
 */


include("../include/main.php");
$db = new Main();
$db->admin_title = "Products Modify";


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: products.php");
    exit();

}

if ($_POST["action"] == "insert") {

    $db->db_tool_insert_row('products', $_POST, 'fld_', 0, 'prd_');

    if ($_POST['subaction'] == 'update') {
        header("Location: products.php");
        exit();
    }
} else if ($_POST["action"] == "update") {

    $db->db_tool_update_row('products', $_POST, "`prd_product_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'prd_');

    if ($_POST['subaction'] == 'update') {
        header("Location: products.php");
        exit();
    }


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `products` WHERE `prd_product_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}


$db->show_header();
?>
<form name="groups" method="post" action="" onsubmit="">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-12 text-center alert alert-dark">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Product</b></div>
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                           role="tab"
                           aria-controls="pills-general" aria-selected="true">General</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-consumables-tab" data-toggle="pill" href="#pills-consumables"
                           role="tab"
                           aria-controls="pills-consumables" aria-selected="false">Consumables</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-spare-parts-tab" data-toggle="pill" href="#pills-spare-parts"
                           role="tab"
                           aria-controls="pills-spare-parts" aria-selected="false">Spare Parts</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-stock-tab" data-toggle="pill" href="#pills-stock" role="tab"
                           aria-controls="pills-stock" aria-selected="false">Stock</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                         aria-labelledby="pills-general-tab">

                        <div class="form-group row">
                            <label for="fld_active" class="col-sm-4 col-form-label">Active</label>
                            <div class="col-sm-8">
                                <select name="fld_active" id="fld_active"
                                        class="form-control"
                                        required>
                                    <option value="1" <?php if ($data['prd_active'] == 1) echo 'selected'; ?>>
                                        Active
                                    </option>
                                    <option value="0" <?php if ($data['prd_active'] == 0) echo 'selected'; ?>>
                                        In-active
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_type" class="col-sm-4 col-form-label">Product Type</label>
                            <div class="col-sm-8">
                                <select name="fld_type" id="fld_type"
                                        class="form-control"
                                        required>
                                    <option value="" <?php if ($data['prd_type'] == '') echo 'selected'; ?>></option>
                                    <option value="Machine" <?php if ($data['prd_type'] == 'Machine') echo 'selected'; ?>>
                                        Machine
                                    </option>
                                    <option value="Consumable" <?php if ($data['prd_type'] == 'Consumable') echo 'selected'; ?>>
                                        Consumable
                                    </option>
                                    <option value="SparePart" <?php if ($data['prd_type'] == 'SparePart') echo 'selected'; ?>>
                                        SparePart
                                    </option>
                                    <option value="Other" <?php if ($data['prd_type'] == 'Other') echo 'selected'; ?>>
                                        Other
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                            <div class="col-sm-8">
                                <input name="fld_code" type="text" id="fld_code"
                                       class="form-control"
                                       value="<?php echo $data["prd_code"]; ?>"
                                       required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_bar_code" class="col-sm-4 col-form-label">Bar Code</label>
                            <div class="col-sm-8">
                                <input name="fld_bar_code" type="text" id="fld_bar_code"
                                       class="form-control"
                                       value="<?php echo $data["prd_bar_code"]; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input name="fld_name" type="text" id="fld_name"
                                       class="form-control"
                                       value="<?php echo $data["prd_name"]; ?>"
                                       required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <input name="fld_description" type="text" id="fld_description"
                                       class="form-control"
                                       value="<?php echo $data["prd_description"]; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_manufacturer_ID" class="col-sm-4 col-form-label">Manufacturer</label>
                            <div class="col-sm-8">
                                <select name="fld_manufacturer_ID" id="fld_manufacturer_ID"
                                        class="form-control"
                                        required>
                                    <option value=""></option>
                                    <?php
                                    $mnfResult = $db->query("SELECT * FROM manufacturers ORDER BY mnf_code ASC");
                                    while ($mnf = $db->fetch_assoc($mnfResult)) {

                                        ?>
                                        <option value="<?php echo $mnf['mnf_manufacturer_ID']; ?>"
                                            <?php if ($mnf['mnf_manufacturer_ID'] == $data['prd_manufacturer_ID']) echo 'selected'; ?>>
                                            <?php echo '[' . $mnf['mnf_code'] . '] ' . $mnf['mnf_name'];
                                            if ($mnf['mnf_active'] != 1) echo ' [INACTIVE]'; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-consumables" role="tabpanel"
                         aria-labelledby="pills-consumables-tab">

                        <iframe src="relations.php?lid=<?php echo $_GET["lid"]; ?>&type=consumables" frameborder="0"
                                scrolling="0" width="100%" height="400"></iframe>

                    </div>

                    <div class="tab-pane fade" id="pills-spare-parts" role="tabpanel"
                         aria-labelledby="pills-spare-parts-tab">

                        <iframe src="relations.php?lid=<?php echo $_GET["lid"]; ?>&type=spare-parts" frameborder="0"
                                scrolling="0" width="100%" height="400"></iframe>

                    </div>

                    <div class="tab-pane fade" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab">
                        ...
                    </div>


                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="subaction" type="hidden" id="subaction"
                                   value="">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="submit" name="Save" id="Save"
                                   value="Save"
                                   class="btn btn-secondary"
                                   onclick="saveForm();">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Product"
                                   class="btn btn-secondary"
                                   onclick="updateForm();">

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
</form>
<script>
    function saveForm() {
        document.getElementById('Submit').disabled = true;
        document.getElementById('Save').disabled = true;
        document.getElementById('subaction').value = 'save';
    }

    function updateForm() {
        document.getElementById('Submit').disabled = true;
        document.getElementById('Save').disabled = true;
        document.getElementById('subaction').value = 'update';
    }
</script>
<?php
$db->show_footer();
?>
