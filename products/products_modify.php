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
    $db->check_restriction_area('insert');

    $newId = $db->db_tool_insert_row('products', $_POST, 'fld_', 1, 'prd_');

    if ($_POST['subaction'] == 'update') {
        header("Location: products.php");
        exit();
    } else {
        $db->generateDismissSuccess('Product created successfully');
        $_GET['lid'] = $newId;
        echo $newId;
    }
} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

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
<form name="myForm" id="myForm" method="post" action="" onsubmit="">
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
                    <?php
                    if ($_GET['lid'] != '') {
                        if ($data['prd_type'] != 'Machine') { ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-machines-tab" data-toggle="pill" href="#pills-machines"
                                   role="tab"
                                   aria-controls="pills-machines" aria-selected="false">Machines</a>
                            </li>
                        <?php }
                        if ($data['prd_type'] == 'Machine') { ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-consumables-tab" data-toggle="pill"
                                   href="#pills-consumables"
                                   role="tab"
                                   aria-controls="pills-consumables" aria-selected="false">Consumables</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-spare-parts-tab" data-toggle="pill"
                                   href="#pills-spare-parts"
                                   role="tab"
                                   aria-controls="pills-spare-parts" aria-selected="false">Spare Parts</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-stock-tab" data-toggle="pill" href="#pills-stock" role="tab"
                               aria-controls="pills-stock" aria-selected="false">Stock</a>
                        </li>
                    <?php } ?>
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
                                        onchange="fillSubType('<?php echo $data['prd_sub_type'];?>');"
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
                            <label for="fld_sub_type" class="col-sm-4 col-form-label">Product Sub Type</label>
                            <div class="col-sm-8">
                                <select name="fld_sub_type" id="fld_sub_type"
                                        class="form-control"
                                        required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
<script>

    function fillSubType(currentValue = ''){
        <?php //get values from codes
            $res = $db->query("SELECT * FROM codes WHERE cde_type = 'ProductsSubType' ORDER BY cde_option_value ASC");
            $machinesTotal = 0;
            $consumablesTotal = 0;
            $sparePartsTotal = 0;
            while ($code = $db->fetch_assoc($res)){
                if ($code['cde_option_value'] == 'Machine'){
                    $machines .= "'".$code['cde_value']."',";
                    $machinesTotal++;
                }
                if ($code['cde_option_value'] == 'Consumables'){
                    $consumables .= "'".$code['cde_value']."',";
                    $consumablesTotal++;
                }
                if ($code['cde_option_value'] == 'Spare Parts'){
                    $spareParts .= "'".$code['cde_value']."',";
                    $sparePartsTotal++;
                }
            }
            $machines = $db->remove_last_char($machines);
            $consumables = $db->remove_last_char($consumables);
            $spareParts = $db->remove_last_char($spareParts);

            echo "var machines = new Array('',".$machines.");\n";
            echo "var consumables = new Array('',".$consumables.");\n";
            echo "var spareParts = new Array('',".$spareParts.");";
            echo "var machinesTotal = ".$machinesTotal.";";
            echo "var consumablesTotal = ".$consumablesTotal.";";
            echo "var sparePartsTotal = ".$sparePartsTotal.";";

        ?>
        var type = $('#fld_type').val();
        if (type == 'Machine'){
            var values = machines;
            var total = machinesTotal;
        }
        else if(type == 'Consumable'){
            var values = consumables;
            var total = consumablesTotal;
        }
        else if(type == 'SparePart'){
            var values = spareParts;
            var total = sparePartsTotal;
        }

        var listItems = '';

        $.each(values, function(key, value){
            if (currentValue == value || total == 1) {
                listItems += '<option value=' + value + ' selected>' + value + '</option>';
            }
            else {
                listItems += '<option value=' + value + '>' + value + '</option>';
            }

        });
        $('#fld_sub_type').empty();
        $('#fld_sub_type').append(listItems);
    }

    <?php if ($_GET["lid"] != ""){
        echo "fillSubType('".$data['prd_sub_type']."');";
    }
    ?>
</script>
                        <div class="form-group row">
                            <label for="fld_size" class="col-sm-4 col-form-label">Size</label>
                            <div class="col-sm-8">
                                <select name="fld_size" id="fld_size"
                                        class="form-control"
                                        required>
                                    <option value="" <?php if ($data['prd_size'] == '') echo 'selected'; ?>></option>
                                    <option value="A4" <?php if ($data['prd_size'] == 'A4') echo 'selected'; ?>>
                                        A4
                                    </option>
                                    <option value="A3" <?php if ($data['prd_size'] == 'A3') echo 'selected'; ?>>
                                        A3
                                    </option>
                                    <option value="Other" <?php if ($data['prd_size'] == 'Other') echo 'selected'; ?>>
                                        Other
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_color" class="col-sm-4 col-form-label">Color</label>
                            <div class="col-sm-8">
                                <select name="fld_color" id="fld_color"
                                        class="form-control"
                                        required>
                                    <option value="" <?php if ($data['prd_color'] == '') echo 'selected'; ?>></option>
                                    <option value="Black" <?php if ($data['prd_color'] == 'Black') echo 'selected'; ?>>
                                        Black
                                    </option>
                                    <option value="Color" <?php if ($data['prd_color'] == 'Color') echo 'selected'; ?>>
                                        Color
                                    </option>
                                    <option value="Other" <?php if ($data['prd_color'] == 'Other') echo 'selected'; ?>>
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
                    <?php if ($data['prd_type'] != 'Machine') { ?>
                        <div class="tab-pane fade" id="pills-machines" role="tabpanel"
                             aria-labelledby="pills-machines-tab">
                            <iframe src="relations.php?lid=<?php echo $_GET["lid"]; ?>&type=<?php echo $data['prd_type']; ?>&area=machines"
                                    frameborder="0"
                                    scrolling="0" width="100%" height="400"></iframe>

                        </div>
                    <?php }
                    if ($data['prd_type'] == 'Machine') { ?>
                        <div class="tab-pane fade" id="pills-consumables" role="tabpanel"
                             aria-labelledby="pills-consumables-tab">

                            <iframe src="relations.php?lid=<?php echo $_GET["lid"]; ?>&type=<?php echo $data['prd_type']; ?>&area=consumables"
                                    frameborder="0"
                                    scrolling="0" width="100%" height="400"></iframe>

                        </div>

                        <div class="tab-pane fade" id="pills-spare-parts" role="tabpanel"
                             aria-labelledby="pills-spare-parts-tab">

                            <iframe src="relations.php?lid=<?php echo $_GET["lid"]; ?>&type=<?php echo $data['prd_type']; ?>&area=spare-parts"
                                    frameborder="0"
                                    scrolling="0" width="100%" height="400"></iframe>

                        </div>
                    <?php } ?>
                    <div class="tab-pane fade" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab">
                        <iframe src="../stock/stock_month_list.php?pid=<?php echo $_GET["lid"]; ?>"
                                frameborder="0"
                                scrolling="0" width="100%" height="700"></iframe>
                    </div>


                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="subaction" type="hidden" id="subaction"
                                   value="">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('products.php')">
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
        var frm = document.getElementById('myForm');
        if (frm.checkValidity() === false) {

        }
        else {
            document.getElementById('Submit').disabled = true;
            document.getElementById('Save').disabled = true;
            document.getElementById('subaction').value = 'save';
        }
    }

    function updateForm() {
        frm = document.getElementById('myForm');
        if (frm.checkValidity() === false) {

        }
        else {
            document.getElementById('Submit').disabled = true;
            document.getElementById('Save').disabled = true;
            document.getElementById('subaction').value = 'update';
        }
    }


</script>

<?php
$db->show_footer();
?>
