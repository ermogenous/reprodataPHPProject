<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 31/7/2019
 * Time: 4:30 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Log File View";

if ($db->user_data['usr_user_rights'] > 0){
    header("Location: ../home.php");
    exit();
}

$table = new draw_table('log_file', 'lgf_log_file_ID', 'DESC');

$table->generate_data();

$db->show_header();
?>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="alert alert-success">
                    <td align="center"><?php $table->display_order_links('ID', 'lgf_log_file_ID'); ?></td>
                    <td align="left"><?php $table->display_order_links('User ID', 'lgf_user_ID'); ?></td>
                    <td align="left"><?php $table->display_order_links('IP', 'lgf_ip'); ?></td>
                    <td align="center"><?php $table->display_order_links('Date/Time', 'lgf_date_time'); ?></td>
                    <td align="center"><?php $table->display_order_links('V.Level', 'inaund_vertical_level'); ?></td>
                    <td align="center"><?php $table->display_order_links('Table', 'lgf_table_name'); ?></td>
                    <td colspan="2" align="center"></td>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["lgf_log_file_ID"]; ?>);">
                        <th scope="row"><?php echo $row["lgf_log_file_ID"]; ?></th>
                        <td align="left"><?php echo $row["lgf_user_ID"]; ?></td>
                        <td align="left"><?php echo $row["lgf_ip"]; ?></td>
                        <td align="center"><?php echo $row["lgf_date_time"]; ?></td>
                        <td align="center"><?php echo $row["inaund_vertical_level"]; ?></td>
                        <td align="center"><?php echo $row["lgf_table_name"]; ?></td>
                        <td align="center">
                            <a href="log_file_view_record.php?lid=<?php echo $row['lgf_log_file_ID'];?>">
                                <i class="fas fa-stream"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('log_file_view_record.php?lid=' + id);
            }
        }
    </script>


<?php
$db->show_footer();
?>