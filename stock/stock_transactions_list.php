<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/8/2018
 * Time: 2:41 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Stock Transactions List";

$db->show_header();

$table = new draw_table('stock', 'stk_stock_ID', 'DESC');
$table->extra_from_section = "JOIN products ON stk_product_ID = prd_product_ID";
$table->extra_select_section = ',(stk_add_minus * stk_amount)as clo_amount';
$table->generate_data();
//echo $table->sql;

?>


    <div class="container">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="alert alert-success">
                        <tr>
                            <th scope="col"><?php $table->display_order_links('ID', 'stk_stock_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Status', 'stk_status'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Pr.Name', 'prd_name'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Amount', 'clo_amount'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Description', 'stk_description'); ?></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr <?php if ($row['stk_status'] == 'Pending'){ ?>
                                    onclick="editLine(<?php echo $row["stk_stock_ID"];?>);"
                            <?php } ?>
                            >
                                <th scope="row"><?php echo $row["stk_stock_ID"]; ?></th>
                                <td><?php echo $row["stk_status"]; ?></td>
                                <td><?php echo $row["prd_name"]; ?></td>
                                <td><?php echo $row["clo_amount"]; ?></td>
                                <td><?php echo $row["stk_description"]; ?></td>
                                <td>
                                    <?php if ($row['stk_status'] == 'Pending'){ ?>
                                    <a href="stock_transactions_modify.php?lid=<?php echo $row["stk_stock_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                    <a href="stock_transactions_delete.php?lid=<?php echo $row["stk_stock_ID"]; ?>&pid=<?php echo $row["prd_product_ID"];?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this stock transaction?');"><i
                                            class="fas fa-minus-circle"></i></a>
                                    <?php } ?>
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
                window.location.assign('stock_transactions_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>