<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/10/2019
 * Time: 10:27 ΠΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts Entities";

$db->show_header();

$table = new draw_table('ac_entities','acet_name','ASC');

$table->generate_data();

?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-lg-block"></div>
            <div class="col-12 col-lg-10">
                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><?php $table->display_order_links('ID','acet_entity_ID');?></th>
                            <th scope="col"><?php $table->display_order_links('Name','acet_name');?></th>
                            <th scope="col"><?php $table->display_order_links('Mobile','acet_mobile');?></th>
                            <th scope="col"><?php $table->display_order_links('Active','acet_active');?></th>
                            <th scope="col">
                                <a href="entity_modify.php">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            $class = '';

                            if($row["acet_active"] != 'Active'){
                                $class .= "alert alert-danger";
                            }

                            ?>
                            <tr class="<?php echo $class; ?>" onclick="editLine(<?php echo $row["acet_entity_ID"]; ?>);">
                                <th scope="row"><?php echo $row["acet_entity_ID"];?></td>
                                <td><?php echo $row["acet_name"];?></td>
                                <td><?php echo $row["acet_mobile"];?></td>
                                <td><?php echo $row["acet_active"];?></td>
                                <td>
                                    <a href="entity_modify.php?lid=<?php echo $row["acet_entity_ID"];?>"><i class="fas fa-edit"></i></a>&nbsp
                                    <a href="entity_delete.php?lid=<?php echo $row["acet_entity_ID"];?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this Entity?');"><i class="fas fa-minus-circle"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-1 d-none d-lg-block"></div>
        </div>
    </div>
    <script>

        var ignoreEdit = false;
        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('entity_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>