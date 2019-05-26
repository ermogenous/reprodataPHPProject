<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27-May-19
 * Time: 1:32 AM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Vitamins";

$db->show_header();

$table = new draw_table('vitamins', 'vit_vitamin_ID', 'ASC');

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'vit_vitamin_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'vit_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Bottle', 'vit_bottle_size'); ?></th>
                        <th scope="col">Cost €</th>
                        <th scope="col">Super €</th>
                        <th scope="col">Wholesale €</th>
                        <th scope="col">Retail €</th>
                        <th scope="col">
                            <a href="vitamin_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $rate = $db->get_setting('vit_gbp_rate');
                    $bottleCostSmall = $db->get_setting('vit_bottle_cost_small');
                    $bottleCostLarge = $db->get_setting('vit_bottle_cost_large');
                    $courierPillCost = $db->get_setting('vit_courier_cost_per_pill');

                    while ($row = $table->fetch_data()) {
                        $totalCost = 0;
                        //get bottle cost
                        if ($row['vit_bottle_size'] == 'Small') {
                            $totalCost = $bottleCostSmall;
                        } else if ($row['vit_bottle_size'] == 'Large') {
                            $totalCost = $bottleCostLarge;
                        }
                        //get pill cost
                        $pillCost = ($row['vit_cost_wholesale'] / $row['vit_cost_quantity']) + $courierPillCost;
                        //all pills
                        $allPillsCost = $pillCost * $row['vit_quantity'];

                        $totalCost += $allPillsCost;

                        //currency conversion
                        $totalCost = round(($totalCost * $rate),2);

                        ?>
                        <tr onclick="editLine(<?php echo $row["vit_vitamin_ID"]; ?>);">
                            <th scope="row"><?php echo $row["vit_vitamin_ID"]; ?></th>
                            <td><?php echo $row["vit_name"]; ?></td>
                            <td><?php echo $row["vit_bottle_size"]; ?></td>
                            <td><?php echo $totalCost; ?></td>
                            <td><?php echo $row["vit_super_wholesale"]; ?></td>
                            <td><?php echo $row["vit_wholesale"]; ?></td>
                            <td><?php echo $row["vit_retail"]; ?></td>
                            <td>
                                <a href="vitamin_modify.php?lid=<?php echo $row["vit_vitamin_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                <a href="vitamin_delete.php?lid=<?php echo $row["vit_vitamin_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this vitamin?');"><i
                                            class="fas fa-minus-circle"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('vitamin_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
