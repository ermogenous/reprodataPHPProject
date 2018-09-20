<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 09-Aug-18
 * Time: 6:32 PM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Products";

$db->show_header();

$table = new draw_table('products', 'prd_product_ID', 'ASC');

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'prd_product_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Type', 'prd_type'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Model', 'prd_model'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'prd_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Current Stock', 'prd_current_stock'); ?></th>
                        <th scope="col">
                            <a href="products_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["prd_product_ID"];?>);">
                        <th scope="row"><?php echo $row["prd_product_ID"]; ?></th>
                        <td><?php echo $row["prd_type"]; ?></td>
                        <td><?php echo $row["prd_model"]; ?></td>
                        <td><?php echo $row["prd_name"]; ?></td>
                        <td><?php echo $row["prd_current_stock"]; ?></td>
                        <td>
                            <a href="products_modify.php?lid=<?php echo $row["prd_product_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                            <a href="products_delete.php?lid=<?php echo $row["prd_product_ID"]; ?>"
                               onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this product?');"><i
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
        <div class="col-lg-2"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('products_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
