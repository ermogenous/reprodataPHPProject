<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/6/2019
 * Time: 10:48 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Vitamins";

$db->show_empty_header();

$table = new draw_table('vitamins', 'vit_name', 'ASC');
$table->per_page = 1000;
//$table->extras = ' vit_wholesale > 0';
$table->generate_data();

$removeCost = false;

include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();

$settings['gbpConvertionRate'] = 1.15;
$settings['packageCostLarge'] = 1.2;
$settings['packageCostSmall'] = 1.2;
$settings['lindensRetailDiscount'] = 0.25;
$settings['lindensWholeSaleCourierCostPerPill'] = 0.008;

//profit
$settings['wholeSaleProfitSmall'] = 5;
$settings['wholeSaleProfitLarge'] = 5;
$settings['retailProfitSmall'] = 3;
$settings['retailProfitLarge'] = 4;




?>
<style>
    .smallFont {
        font-size: 10px;
    }
</style>
<?php
if ($_POST['hideBar'] != 'Yes') {
?>
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <form name="myForm" id="myForm" method="post"
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row form-group">
                    <label for="hideCost" class="col-2 col-form-label">Hide Costs</label>
                    <div class="col-2">
                        <select name="hideCost" id="hideCost"
                                class="form-control">
                            <option value="No" <?php if ($_POST['hideCost'] == 'No') echo 'selected'; ?>>
                                No
                            </option>
                            <option value="Yes" <?php if ($_POST['hideCost'] == 'Yes') echo 'selected'; ?>>
                                Yes
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'hideCost',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Type'
                            ]);
                        ?>
                    </div>

                    <label for="hideBar" class="col-2 col-form-label">Hide Bar</label>
                    <div class="col-2">
                        <select name="hideBar" id="hideBar"
                                class="form-control">
                            <option value="No" <?php if ($_POST['hideBar'] == 'No') echo 'selected'; ?>>
                                No
                            </option>
                            <option value="Yes" <?php if ($_POST['hideBar'] == 'Yes') echo 'selected'; ?>>
                                Yes
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'hideBar',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Type'
                            ]);
                        ?>
                    </div>
                    <label for="showHideDescription" class="col-2 col-form-label">Description</label>
                    <div class="col-2">
                        <select name="showHideDescription" id="showHideDescription"
                                class="form-control">
                            <option value="Show" <?php if ($_POST['showHideDescription'] == 'Show') echo 'selected'; ?>>
                                Show
                            </option>
                            <option value="Hide" <?php if ($_POST['showHideDescription'] == 'Hide') echo 'selected'; ?>>
                                Hide
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'showHideDescription',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Type'
                            ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="wholeRetail" class="col-4 col-form-label">Cost WholeSale OR Retail</label>
                    <div class="col-3">
                        <select name="wholeRetail" id="wholeRetail"
                                class="form-control">
                            <option value="WholeSale" <?php if ($_POST['wholeRetail'] == 'WholeSale') echo 'selected'; ?>>
                                WholeSale
                            </option>
                            <option value="Retail" <?php if ($_POST['wholeRetail'] == 'Retail') echo 'selected'; ?>>
                                Retail
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'wholeRetail',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Type'
                            ]);
                        ?>
                    </div>

                    <label for="showHideMarket" class="col-3 col-form-label">Market Values</label>
                    <div class="col-2">
                        <select name="showHideMarket" id="showHideMarket"
                                class="form-control">
                            <option value="Hide" <?php if ($_POST['showHideMarket'] == 'Hide') echo 'selected'; ?>>
                                Hide
                            </option>
                            <option value="Show" <?php if ($_POST['showHideMarket'] == 'Show') echo 'selected'; ?>>
                                Show
                            </option>
                        </select>
                        <?php
                        $formValidator->addField(
                            [
                                'fieldName' => 'showHideMarket',
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidText' => 'Select Type'
                            ]);
                        ?>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-2">
                        <input type="submit" name="Submit" id="Submit"
                               value="Submit"
                               class="btn btn-secondary">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
}//hideBar
?>

<div class="container smallFont">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('Name', 'vit_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Bottle/Pills', 'vit_bottle_size'); ?></th>
                        <?php if ($_POST['hideCost'] != 'Yes'){?>
                        <th scope="col">Cost WS€</th>
                        <th scope="col">Cost Retail€</th>
                        <?php } ?>
                        <th scope="col">WholeSale€</th>
                        <th scope="col">Retail€</th>
                        <?php if ($_POST['hideCost'] != 'Yes'){?>
                        <th scope="col">WS Profit</th>
                        <th scope="col">Retail Profit</th>
                        <?php } ?>
                        <?php if ($_POST['showHideDescription'] != 'Hide'){?>
                        <th scope="col">Description</th>
                        <?php } ?>
                        <?php if ($_POST['showHideMarket'] == 'Show'){?>
                            <th scope="col">Market</th>
                        <?php } ?>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($row = $table->fetch_data()) {

                        //wholesale as cost
                        $gbpCostRetail = $row['vit_cost_retail'];
                        $gbpCostRetail = $gbpCostRetail - ($gbpCostWS * $settings['lindensRetailDiscount']);
                        //cost per pill
                        $gbpCostRetail = ($gbpCostRetail * $settings['gbpConvertionRate']) / $row['vit_cost_quantity'];
                        //cost all pills
                        $gbpCostRetail = $gbpCostRetail * $row['vit_quantity'];
                        //bottle cost
                        $gbpCostRetail += ( $row["vit_bottle_size"] == 'Small' ? $settings['packageCostSmall'] : $settings['packageCostLarge'] );

                        //retail as cost
                        $gbpCostWS = $row['vit_cost_wholesale'];
                        //cost per pill
                        $gbpCostWS = ($gbpCostWS * $settings['gbpConvertionRate']) / $row['vit_cost_quantity'];
                        //cost all pills added the courier cost per pill
                        $gbpCostWS = ($gbpCostWS + $settings['lindensWholeSaleCourierCostPerPill']) * $row['vit_quantity'];
                        //bottle cost
                        $gbpCostWS += ( $row["vit_bottle_size"] == 'Small' ? $settings['packageCostSmall'] : $settings['packageCostLarge'] );

                        if ($_POST['wholeRetail'] == 'Retail'){
                            $totalCost = $gbpCostRetail;
                        }
                        else {
                            $totalCost = $gbpCostWS;
                        }



                        //wholesale bottle profit
                        $wholeSale = ( $row["vit_bottle_size"] == 'Small' ? $settings['wholeSaleProfitSmall'] : $settings['wholeSaleProfitLarge'] );
                        $wholeSale += $totalCost;
                        $wholeSale = ceil($wholeSale);

                        //retail bottle profit
                        $retail = ( $row["vit_bottle_size"] == 'Small' ? $settings['retailProfitSmall'] : $settings['retailProfitLarge'] );
                        $retail += $wholeSale;
                        $retail = ceil($retail);

                        //wholesale profit
                        $wsProfit = $wholeSale - $totalCost;


                        //retail profit
                        $rtProfit = $retail - $totalCost;

                        //check if the wholesale in the row is empty. if not then take from the row
                        if ($row['vit_wholesale'] > 0){
                            $wholeSale = $row['vit_wholesale'];
                        }

                        //check if the retail in the row is empty. if not then take from the row
                        if ($row['vit_retail'] > 0){
                            $retail = $row['vit_retail'];
                        }

                        ?>
                        <tr onclick="editLine(<?php echo $row["vit_vitamin_ID"]; ?>);">
                            <td><?php echo $row["vit_name"]; ?></td>
                            <td align="center"><?php echo $row["vit_bottle_size"]."/".$row['vit_quantity']; ?></td>
                            <?php if ($_POST['hideCost'] != 'Yes'){?>
                            <td><?php echo round($gbpCostWS,2); ?></td>
                            <td><?php echo round($gbpCostRetail,2); ?></td>
                            <?php } ?>
                            <td align="center"><?php echo $wholeSale; ?></td>
                            <td align="center"><?php echo $retail; ?></td>
                            <?php if ($_POST['hideCost'] != 'Yes'){?>
                            <td><?php echo round($wsProfit,2); ?></td>
                            <td><?php echo round($rtProfit,2); ?></td>
                            <?php } ?>
                            <?php if ($_POST['showHideDescription'] != 'Hide'){ ?>
                            <td><?php echo $row["vit_description"]; ?></td>
                            <?php } ?>

                            <?php if ($_POST['showHideMarket'] == 'Show'){ ?>
                                <td><?php echo $row["vit_market_prices"]; ?></td>
                            <?php } ?>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var ignoreEdit = true;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('vitamin_modify.php?lid=' + id);
        }
    }
</script>
<?php
$formValidator->output();
$db->show_empty_footer();
?>
