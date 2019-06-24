<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/4/2019
 * Time: 3:04 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
$db = new Main();

$table = new draw_table('ina_underwriters', 'usg_users_groups_ID ASC,usr_name ASC', '');
$table->extra_from_section = 'JOIN users ON usr_users_ID = inaund_user_ID';
$table->extra_from_section .= ' JOIN users_groups ON usr_users_groups_ID = usg_users_groups_ID';

$table->generate_data();

$db->show_header();
?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="alert alert-success">
                    <td align="center"><?php $table->display_order_links('ID', 'inaund_underwriter_ID'); ?></td>
                    <td align="left"><?php $table->display_order_links('Group', 'usg_group_name'); ?></td>
                    <td align="left"><?php $table->display_order_links('Name', 'usr_name'); ?></td>
                    <td align="center"><?php $table->display_order_links('Status', 'inaund_status'); ?></td>
                    <td align="center"><?php $table->display_order_links('V.Level', 'inaund_vertical_level'); ?></td>
                    <td colspan="2" align="center"><a href="underwriters_modify.php">New</a></td>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["inaund_underwriter_ID"]; ?>);">
                        <th scope="row"><?php echo $row["inaund_underwriter_ID"]; ?></th>
                        <td align="left"><?php echo $row["usg_group_name"]; ?></td>
                        <td align="left"><?php echo $row["usr_name"]; ?></td>
                        <td align="center"><?php echo $row["inaund_status"]; ?></td>
                        <td align="center"><?php echo $row["inaund_vertical_level"]; ?></td>
                        <td width="59" align="center"><a
                                href="underwriters_modify.php?lid=<?php echo $row["inaund_underwriter_ID"]; ?>">Modify</a>
                        </td>
                        <td width="58" height="30" align="center"><a
                                href="underwriters_modify.php?lid=<?php echo $row["inaund_underwriter_ID"]; ?>"
                                onclick="return(confirm('Are you sure you want to delte this underwriter?'))">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3" align="left"><a href="underwriters.php">Back</a></td>
                    <td colspan="3" align="center">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('underwriters_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>