<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 27/5/2019
 * Time: 7:58 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Therapies";

$db->show_header();

$table = new draw_table('therapies', 'trp_therapy_ID', 'ASC');

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
                            <th scope="col"><?php $table->display_order_links('ID', 'trp_therapy_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Name', 'usr_name'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Rights', 'usr_user_rights'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Active', 'usr_active'); ?></th>
                            <th scope="col">
                                <a href="user_modify.php">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr onclick="editLine(<?php echo $row["trp_therapy_ID"];?>);">
                                <th scope="row"><?php echo $row["trp_therapy_ID"]; ?></th>
                                <td><?php echo $row["usr_name"]; ?></td>
                                <td><?php echo $row["usr_user_rights"]; ?></td>
                                <td><?php echo $row["usr_active"]; ?></td>
                                <td>
                                    <a href="therapy_modify.php?lid=<?php echo $row["trp_therapy_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                    <a href="therapy_delete.php?lid=<?php echo $row["trp_therapy_ID"]; ?>"
                                       onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this Therapy?');"><i
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
                window.location.assign('therapy_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>