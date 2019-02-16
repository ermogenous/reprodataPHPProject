<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/2/2019
 * Time: 12:26 ΠΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Policy Types";

$db->show_header();

$table = new draw_table('ina_policy_types', 'inapot_policy_type_ID', 'ASC');

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
                        <th scope="col"><?php $table->display_order_links('ID', 'inapot_policy_type_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'inapot_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Code', 'inapot_code'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'inapot_status'); ?></th>
                        <th scope="col">
                            <a href="policy_type_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["inapot_policy_type_ID"];?>);">
                            <th scope="row"><?php echo $row["inapot_policy_type_ID"]; ?></th>
                            <td><?php echo $row["inapot_name"]; ?></td>
                            <td><?php echo $row["inapot_code"]; ?></td>
                            <td><?php echo $row["inapot_status"]; ?></td>
                            <td>
                                <a href="policy_type_modify.php?lid=<?php echo $row["inapot_policy_type_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="policy_type_delete.php?lid=<?php echo $row["inapot_policy_type_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this Policy Type?');"><i
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
            window.location.assign('policy_type_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
