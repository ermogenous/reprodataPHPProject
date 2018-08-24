<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/8/2018
 * Time: 4:45 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main();
$db->admin_title = "Customers Products";

$db->show_empty_header();

$table = new draw_table('customer_products', 'cspr_customer_product_ID', 'ASC');
$table->extra_from_section = "JOIN products ON prd_product_ID = cspr_product_ID 
JOIN customers ON cst_customer_ID = cspr_customer_ID";
$table->extras = 'cspr_customer_ID = '.$_GET["cid"];

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
                        <th scope="col"><?php $table->display_order_links('ID', 'cspr_customer_product_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Machine', 'prd_code'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'cst_name'); ?></th>
                        <th scope="col">
                            <a href="customers_products_modify.php?lid=<?php echo $_GET['lid']; ?>">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["cspr_customer_product_ID"]; ?>);">
                            <th scope="row"><?php echo $row["cspr_customer_product_ID"]; ?></th>
                            <td><?php echo $row["prd_code"]; ?></td>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td>
                                <a href="customers_products_modify.php?lid=<?php echo $row["cspr_customer_product_ID"]; ?>">
                                    <i class="fas fa-edit"></i></a>&nbsp
                                <a href="customers_products_delete.php?lid=<?php echo $row["cspr_customer_product_ID"];?>"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this product?');">
                                    <i class="fas fa-minus-circle"></i></a>
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
            window.location.assign('customers_products_modify.php?lid=' + id );
        }
    }
</script>

<?php
$db->show_empty_footer();
?>



