<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 10-Aug-18
 * Time: 12:41 AM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main();
$db->admin_title = "Product Relations";

$db->show_empty_header();

$table = new draw_table('product_relations', 'prdr_product_relations_ID', 'ASC');
$table->extras = '';

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
                        <th scope="col"><?php $table->display_order_links('ID', 'cst_customer_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'usg_group_name'); ?></th>
                        <th scope="col">
                            <a href="customers_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editCustomer(<?php echo $row["cst_customer_ID"];?>);">
                            <th scope="row"><?php echo $row["cst_customer_ID"]; ?></th>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td>
                                <a href="customers_modify.php?lid=<?php echo $row["cst_customer_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="customers_delete.php?lid=<?php echo $row["cst_customer_ID"]; ?>"
                                   onclick="return confirm('Are you sure you want to delete this customer?');"><i
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
    function editCustomer(id){
        window.location.assign('customers_modify.php?lid='+id);
    }
</script>

<?php
$db->show_empty_footer();
?>
