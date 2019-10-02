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
    $db->db_tool_insert_row('vitamins', $_POST, 'fld_', 0, 'vit_');
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
} else {
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
            <form name="myForm" id="myForm" method="post"
                <?php $formValidator->echoFormParameters(); ?>>
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Vitamin</b>
                </div>

                <div class="form-group row">
                    <label for="fld_active" class="col-sm-4 col-form-label">Active</label>
                    <div class="col-sm-8">
                        <select name="fld_active" id="fld_active"
                                class="form-control">
                            <option value="1" <?php if ($data['vit_active'] == 1) echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if ($data['vit_active'] == 0) echo 'selected'; ?>>In-active</option>
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
                               value="<?php echo $data["vit_code"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_code',
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidText' => 'Enter Code'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_type" class="col-sm-4 col-form-label">Type</label>
                    <div class="col-sm-8">
                        <select name="fld_type" id="fld_type"
                                class="form-control">
                            <option value="Vitamin" <?php if ($data['vit_type'] == 'Vitamin') echo 'selected'; ?>>
                                Vitamin
                            </option>
                            <option value="Mineral" <?php if ($data['vit_type'] == 'Mineral') echo 'selected'; ?>>
                                Mineral
                            </option>
                            <option value="Supplement" <?php if ($data['vit_type'] == 'Supplement') echo 'selected'; ?>>
                                Supplement
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_type',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Type'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name" type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["vit_name"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_name',
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidText' => 'Enter Name'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description" type="text" id="fld_description"
                               class="form-control"
                               value="<?php echo $data["vit_description"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_description',
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidText' => 'Enter Description'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_has_label" class="col-sm-4 col-form-label">Has Label</label>
                    <div class="col-sm-8">
                        <select name="fld_has_label" id="fld_has_label"
                                class="form-control">
                            <option value="No" <?php if ($data['vit_has_label'] == 'No') echo 'selected'; ?>>
                                No
                            </option>
                            <option value="Small" <?php if ($data['vit_has_label'] == 'Small') echo 'selected'; ?>>
                                Small
                            </option>
                            <option value="Large" <?php if ($data['vit_has_label'] == 'Large') echo 'selected'; ?>>
                                Large
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_has_label',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select if it has label'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_bottle_size" class="col-sm-4 col-form-label">Bottle Size</label>
                    <div class="col-sm-8">
                        <select name="fld_bottle_size" id="fld_bottle_size"
                                class="form-control">
                            <option value="Small" <?php if ($data['vit_bottle_size'] == 'Small') echo 'selected'; ?>>
                                Small
                            </option>
                            <option value="Large" <?php if ($data['vit_bottle_size'] == 'Large') echo 'selected'; ?>>
                                Large
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_bottle_size',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Bottle Size'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_quantity" class="col-sm-4 col-form-label">Quantity In Bottle</label>
                    <div class="col-sm-8">
                        <input name="fld_quantity" type="text" id="fld_quantity"
                               class="form-control"
                               value="<?php echo $data["vit_quantity"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_quantity',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Quantity in Bottle'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_cost_quantity" class="col-sm-4 col-form-label">Cost Quantity</label>
                    <div class="col-sm-8">
                        <input name="fld_cost_quantity" type="text" id="fld_cost_quantity"
                               class="form-control"
                               value="<?php echo $data["vit_cost_quantity"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_cost_quantity',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Cost Quantity'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_cost_wholesale" class="col-sm-4 col-form-label">Cost Wholesale GBP</label>
                    <div class="col-sm-8">
                        <input name="fld_cost_wholesale" type="text" id="fld_cost_wholesale"
                               class="form-control"
                               value="<?php echo $data["vit_cost_wholesale"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_cost_wholesale',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Cost Wholesale'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_cost_retail" class="col-sm-4 col-form-label">Cost Retail GBP</label>
                    <div class="col-sm-8">
                        <input name="fld_cost_retail" type="text" id="fld_cost_retail"
                               class="form-control"
                               value="<?php echo $data["vit_cost_retail"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_cost_retail',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Cost Retail'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_super_wholesale" class="col-sm-4 col-form-label">Super Wholesale</label>
                    <div class="col-sm-6">
                        <input name="fld_super_wholesale" type="text" id="fld_super_wholesale"
                               class="form-control" onkeyup="makeSuperWholeSale();"
                               value="<?php echo $data["vit_super_wholesale"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_super_wholesale',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Super Wholesale valid number'
                            ]);
                        ?>
                    </div>
                    <div class="col-2" id="superWholesale">
                        <?php echo $data['vit_super_wholesale'] * 1.375; ?>
                    </div>
                    <script>
                        function makeSuperWholeSale(){
                            $('#superWholesale').html(
                                (($('#fld_super_wholesale').val() ) * 1.375).toFixed(2)
                            );
                        }
                    </script>
                </div>

                <div class="form-group row">
                    <label for="fld_wholesale" class="col-sm-4 col-form-label">WholeSale</label>
                    <div class="col-sm-6">
                        <input name="fld_wholesale" type="text" id="fld_wholesale"
                               class="form-control" onkeyup="makeWholeSale()"
                               value="<?php echo $data["vit_wholesale"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_wholesale',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Wholesale valid number'
                            ]);
                        ?>
                    </div>
                    <div class="col-2" id="wholeSale">
                        <?php echo $data['vit_wholesale'] * 1.375; ?>
                    </div>
                    <script>
                        function makeWholeSale(){
                            $('#wholeSale').html(
                                (($('#fld_wholesale').val()*1) * 1.375).toFixed(2)
                            );
                        }
                    </script>
                </div>

                <div class="form-group row">
                    <label for="fld_retail" class="col-sm-4 col-form-label">Retail</label>
                    <div class="col-sm-6">
                        <input name="fld_retail" type="text" id="fld_retail"
                               class="form-control" onkeyup="makeRetail()"
                               value="<?php echo $data["vit_retail"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_retail',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Retail valid number'
                            ]);
                        ?>
                    </div>
                    <div class="col-2" id="retail">
                        <?php echo $data['vit_retail'] * 1.375; ?>
                    </div>
                    <script>
                        function makeRetail(){
                            $('#retail').html(
                                (($('#fld_retail').val()*1) * 1.375).toFixed(2)
                            );
                        }
                    </script>
                </div>

                <div class="form-group row">
                    <label for="fld_retail_one_plus_one" class="col-sm-4 col-form-label">Retail 1+1Free</label>
                    <div class="col-sm-3">
                        <input name="fld_retail_one_plus_one" type="text" id="fld_retail_one_plus_one"
                               class="form-control" onkeyup="makeOnePlusOne()"
                               value="<?php echo $data["vit_retail_one_plus_one"]; ?>">
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_retail_one_plus_one',
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidText' => 'Enter Retail 1+1Free valid number'
                            ]);
                        ?>
                    </div>
                    <div class="col-5" id="onePlusOne" style="font-size: 13px;">/2 =
                        <?php
                        echo($data['vit_retail_one_plus_one'] / 2);
                        ?>
                        -37.5%=
                        <?php
                        echo round((($data['vit_retail_one_plus_one'] / 2) / 1.375), 2);
                        ?>
                    </div>
                    <script>
                        function makeOnePlusOne(){
                            $('#onePlusOne').html(
                                '/2 = ' +
                                (($('#fld_retail_one_plus_one').val()*1) / 2).toFixed(2)
                                + ' -37.5%=' +
                                ((($('#fld_retail_one_plus_one').val()*1) / 2)/1.375).toFixed(2)
                            );
                        }
                    </script>
                </div>

                <?php

                if ($data['vit_cost_quantity'] > 0) {
                    $rate = $db->get_setting('vit_gbp_rate');
                    $bottleCostSmall = $db->get_setting('vit_bottle_cost_small');
                    $bottleCostLarge = $db->get_setting('vit_bottle_cost_large');
                    $courierPillCost = $db->get_setting('vit_courier_cost_per_pill');

                    //echo $rate." - Bottle Large:".$bottleCostLarge." Courrier:".$courierPillCost;

                    $totalCost = 0;
                    //get bottle cost
                    if ($data['vit_bottle_size'] == 'Small') {
                        $totalCost = $bottleCostSmall;
                    } else if ($data['vit_bottle_size'] == 'Large') {
                        $totalCost = $bottleCostLarge;
                    }
                    //echo "<br>".$totalCost;
                    //get pill cost
                    $pillCost = ($data['vit_cost_wholesale'] / $data['vit_cost_quantity']) + $courierPillCost;
                    //echo "<br>Pill Cost: ".$pillCost;
                    //all pills
                    $allPillsCost = $pillCost * $data['vit_quantity'];
                    //echo "<br> All Pill Cost: ".$allPillsCost;
                    $totalCost += $allPillsCost;
                    //echo "<br>Total Cost: ".$totalCost;
                    //currency conversion
                    $totalCost = round(($totalCost * $rate), 2);
                }
                ?>

                <div class="form-group row">
                    <label for="fld_retail_one_plus_one" class="col-sm-4 col-form-label">2nd -50%</label>
                    <div class="col-8">
                        Cost: <?php echo ($totalCost*2);?> S.W.Sale <?php echo $data['vit_super_wholesale']*2;?>
                        <br> Retail Final Price <?php echo $data['vit_retail'] + round(($data['vit_retail']/2),2);?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_market_prices" class="col-sm-4 col-form-label">Market Prices</label>
                    <div class="col-sm-8">
                        <textarea name="fld_market_prices" id="fld_market_prices"
                                  class="form-control"><?php echo $data["vit_market_prices"]; ?></textarea>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'fld_market_prices',
                                'fieldDataType' => 'text',
                                'required' => false
                            ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">Total Cost</div>
                    <div class="col-8"><?php echo $totalCost; ?></div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('vitamins.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Vitamin"
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
