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

if ($_GET['type'] == 'Machine') {

    $table->extra_from_section = "JOIN products ON prd_product_ID = prdr_product_child_ID";
    if ($_GET['area'] == 'consumables') {
        $table->extras = 'prdr_product_parent_ID = ' . $_GET['lid'] . " AND prdr_child_type = 'Consumable'";
    } else {
        $table->extras = 'prdr_product_parent_ID = ' . $_GET['lid'] . " AND prdr_child_type = 'SparePart'";
    }

} else if ($_GET['type'] == 'SparePart') {
    $table->extra_from_section = "JOIN products ON prd_product_ID = prdr_product_parent_ID";
    $table->extras = 'prdr_product_child_ID = ' . $_GET['lid'] . " AND prdr_child_type = 'SparePart'";

} else if ($_GET['type'] == 'Consumable') {
    $table->extra_from_section = "JOIN products ON prd_product_ID = prdr_product_parent_ID";
    $table->extras = 'prdr_product_child_ID = ' . $_GET['lid'] . " AND prdr_child_type = 'Consumable'";
}


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
                        <th scope="col"><?php $table->display_order_links('ID', 'prdr_product_relations_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Model', 'prd_model'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'prd_name'); ?></th>
                        <th scope="col">
                            <a href="relations_modify.php?pid=<?php echo $_GET['lid'] . "&type=" . $_GET['type'] . "&area=" . $_GET['area']; ?>">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["prdr_product_relations_ID"]; ?>);">
                            <th scope="row"><?php echo $row["prdr_product_relations_ID"]; ?></th>
                            <td><?php echo $row["prd_model"]; ?></td>
                            <td><?php echo $row["prd_name"]; ?></td>
                            <td>
                                <a href="relations_modify.php?lid=<?php echo $row["prdr_product_relations_ID"]; ?>&pid=<?php echo $_GET['lid'] . "&type=" . $_GET['type'] . "&area=" . $_GET['area']; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                <a href="relations_modify.php?lid=<?php echo $row["prdr_product_relations_ID"]; ?>&pid=<?php echo $_GET['lid'] . "&type=" . $_GET['type'] . "&area=" . $_GET['area']; ?>"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this relation?');"><i
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
            window.location.assign('relations_modify.php?lid=' + id + '&pid=<?php echo $_GET['lid'] . "&type=" . $_GET['type'] . "&area=" . $_GET['area'];?>');
        }
    }
</script>

<?php
$db->show_empty_footer();
?>
