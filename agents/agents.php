<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/2/2019
 * Time: 11:02 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Agents";

$db->show_header();

$table = new draw_table('agents', 'agnt_agent_ID', 'ASC');

$table->generate_data();

?>


<div class="container">
    <div class="row">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'agnt_agent_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'agnt_status'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'agnt_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Code', 'agnt_code'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Type', 'agnt_type'); ?></th>
                        <th scope="col">
                            <a href="agent_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["agnt_agent_ID"];?>);">
                            <th scope="row"><?php echo $row["agnt_agent_ID"]; ?></th>
                            <td><?php echo $row["agnt_status"]; ?></td>
                            <td><?php echo $row["agnt_name"]; ?></td>
                            <td><?php echo $row["agnt_code"]; ?></td>
                            <td><?php echo $row["agnt_type"]; ?></td>
                            <td>
                                <a href="agent_modify.php?lid=<?php echo $row["agnt_agent_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="agent_delete.php?lid=<?php echo $row["agnt_agent_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this Agent?');"><i
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
</div>
<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('agent_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>