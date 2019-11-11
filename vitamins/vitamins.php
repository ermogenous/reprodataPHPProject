<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27-May-19
 * Time: 12:49 AM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Vitamins";

$db->show_header();

$table = new draw_table('vitamins', 'vit_code', 'ASC');
$table->per_page = 150;

$table->generate_data();

?>


<div class="container-fluid">
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
                        <td scope="col" align="center"><strong><?php $table->display_order_links('Wholesale', 'vit_wholesale'); ?></strong></td>
                        <td scope="col" align="center"><strong><?php $table->display_order_links('Retail', 'vit_retail'); ?></strong></td>
                        <td scope="col" align="center"><strong><?php $table->display_order_links('Stock Bottles', 'vit_stock_bottles'); ?></strong></td>
                        <td scope="col" align="center"><strong><?php $table->display_order_links('Stock Pills', 'vit_stock_pills'); ?></strong></td>
                        <th scope="col">
                            <a href="vitamin_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["vit_vitamin_ID"];?>);">
                            <th scope="row"><?php echo $row["vit_vitamin_ID"]; ?></th>
                            <td><?php echo $row["vit_name"]; ?></td>
                            <td align="center"><?php echo $row["vit_wholesale"]; ?></td>
                            <td align="center"><?php echo $row["vit_retail"]; ?></td>
                            <td align="center"><?php echo $row["vit_stock_bottles"]; ?></td>
                            <td align="center"><?php echo $row["vit_stock_pills"]; ?></td>
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

<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <a href="vitamins_report_1.php">Report 1</a>
            <a href="vitamins_report_2.php">Report 2</a>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('vitamin_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
