<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 15-May-19
 * Time: 10:56 AM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "My Users";

$db->show_header();

$table = new draw_table('users', 'usr_users_ID', 'ASC');

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
                        <th scope="col"><?php $table->display_order_links('ID', 'usr_users_ID'); ?></th>
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
                        <tr onclick="editLine(<?php echo $row["usr_users_ID"];?>);">
                            <th scope="row"><?php echo $row["usr_users_ID"]; ?></th>
                            <td><?php echo $row["usr_name"]; ?></td>
                            <td><?php echo $row["usr_user_rights"]; ?></td>
                            <td><?php echo $row["usr_active"]; ?></td>
                            <td>
                                <a href="user_modify.php?lid=<?php echo $row["usr_users_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="user_delete.php?lid=<?php echo $row["usr_users_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this User?');"><i
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
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8 alert alert-warning">
            <?php
            $totalUsers = $db->query_fetch('SELECT COUNT(*)as clo_total_users FROM users WHERE usr_active = 1');
            ?>
            Total Allowed Active Users: <?php echo $db->decrypt($db->get_setting('user_max_user_accounts'));?>
            Total Active: <?php echo $totalUsers['clo_total_users'];?>
            Total Users: <?php echo $table->total_rows;?>
        </div>
        <div class="col-2">
        </div>
    </div>
</div>
<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('user_modify.php?lid=' + id);
        }
    }
</script>
<?php

echo $db->encrypt('60');

echo "<br><br>";

echo $db->decrypt('SVpuNTl5TzhuejlWU3h2VHhQYlkvZz09OjpqrZ48CLfo_jL16ziyLobv');

$db->show_footer();
?>