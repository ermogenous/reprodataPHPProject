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

$table = new draw_table('vitamins', 'vit_vitamin_ID', 'ASC');
$table->per_page = 1000;
$table->extras = ' vit_wholesale > 0';
$table->generate_data();

$removeCost = false;

?>
<style>
    .smallFont {
        font-size: 10px;
    }
</style>

<div class="container smallFont">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('Name', 'vit_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Bottle/Pills', 'vit_bottle_size'); ?></th>
                        <?php if ($removeCost == false){?>
                        <th scope="col">Cost €</th>
                        <?php } ?>
                        <th scope="col">Retail€</th>
                        <th scope="col">%Profit</th>
                        <th scope="col">1+1Free/One€</th>
                        <th scope="col">%Profit</th>
                        <th scope="col">Market Prices</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($row = $table->fetch_data()) {
                        if ($row['vit_wholesale'] > 0) {
                            $retailPer = $row['vit_retail'] / $row['vit_wholesale'];
                            $retailPer = $retailPer - 1;
                            $retailPer = $retailPer * 100;
                            $retailPer = round($retailPer, 2);

                            $freePer = ($row['vit_retail_one_plus_one'] / 2) / $row['vit_wholesale'];
                            $freePer = ($freePer - 1) * 100;
                            $freePer = round($freePer, 2);
                        }
                        ?>
                        <tr onclick="editLine(<?php echo $row["vit_vitamin_ID"]; ?>);">
                            <td><?php echo $row["vit_description"]; ?></td>
                            <td><?php echo $row["vit_bottle_size"]."/".$row['vit_quantity']; ?></td>
                            <?php if ($removeCost == false){?>
                            <td><?php echo $row['vit_wholesale']; ?></td>
                            <?php } ?>
                            <td><?php echo $row["vit_retail"]; ?></td>
                            <td><?php echo $retailPer; ?>%</td>
                            <td><?php echo $row["vit_retail_one_plus_one"]."/".round(($row["vit_retail_one_plus_one"]/2),2); ?></td>
                            <td><?php echo $freePer; ?>%</td>
                            <td><?php echo $row["vit_market_prices"]; ?></td>

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
$db->show_empty_footer();
?>
