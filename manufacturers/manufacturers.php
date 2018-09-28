<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 09-Aug-18
 * Time: 5:41 PM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Manufacturers";

$db->show_header();

$table = new draw_table('manufacturers', 'mnf_manufacturer_ID', 'ASC');

$table->generate_data();

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
                        <th scope="col"><?php $table->display_order_links('ID', 'mnf_manufacturer_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Code', 'mnf_code'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'mnf_name'); ?></th>
                        <th scope="col">
                            <a href="manufacturers_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["mnf_manufacturer_ID"];?>);">
                        <th scope="row"><?php echo $row["mnf_manufacturer_ID"]; ?></th>
                        <td><?php echo $row["mnf_code"]; ?></td>
                        <td><?php echo $row["mnf_name"]; ?></td>
                        <td>
                            <a href="manufacturers_modify.php?lid=<?php echo $row["mnf_manufacturer_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                            <a href="manufacturers_delete.php?lid=<?php echo $row["mnf_manufacturer_ID"]; ?>"
                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this manufacturer?');"><i
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
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('manufacturers_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
