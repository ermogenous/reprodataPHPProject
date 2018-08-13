<?php
include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Customers";

$db->show_header();

$table = new draw_table('customers', 'cst_customer_ID', 'ASC');

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
                    <tr onclick="editLine(<?php echo $row["cst_customer_ID"];?>);">
                        <th scope="row"><?php echo $row["cst_customer_ID"]; ?></th>
                        <td><?php echo $row["cst_name"]; ?></td>
                        <td>
                            <a href="customers_modify.php?lid=<?php echo $row["cst_customer_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                            <a href="customers_delete.php?lid=<?php echo $row["cst_customer_ID"]; ?>"
                               onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this customer?');"><i
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
            window.location.assign('customers_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
