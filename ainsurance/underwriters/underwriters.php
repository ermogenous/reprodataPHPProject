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
$table->extra_select_section = '
,
(
SELECT usr_name FROM users WHERE usr_users_ID = 
(SELECT inaund_user_ID FROM ina_underwriters as subunder WHERE subunder.inaund_underwriter_ID = ina_underwriters.inaund_subagent_ID)
)
as clo_subagent_name
';
$table->extra_from_section = ' JOIN users ON usr_users_ID = inaund_user_ID';
$table->extra_from_section .= ' JOIN users_groups ON usr_users_groups_ID = usg_users_groups_ID';
echo $table->sql;
$table->generate_data();
$db->show_header();
?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="alert alert-success">
                    <td align="center"><?php $table->display_order_links('ID', 'inaund_underwriter_ID'); ?></td>
                    <td align="left"><?php $table->display_order_links('Name', 'usr_name'); ?></td>
                    <td align="left"><?php $table->display_order_links('Group', 'usg_group_name'); ?></td>
                    <td align="center"><?php $table->display_order_links('Status', 'inaund_status'); ?></td>
                    <td align="center"><?php $table->display_order_links('V.Level', 'inaund_vertical_level'); ?></td>
                    <td align="center"><?php $table->display_order_links('SubAgent', 'clo_subagent_name'); ?></td>
                    <td align="center">Commissions</td>
                    <td colspan="2" align="center"><a href="underwriters_modify.php">New</a></td>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    if ($row['inaund_subagent_ID'] == '-1'){
                        $row['clo_subagent_name'] = 'Office Top';
                    }
                    ?>
                    <tr onclick="editLine(<?php echo $row["inaund_underwriter_ID"]; ?>);">
                        <th scope="row"><?php echo $row["inaund_underwriter_ID"]; ?></th>
                        <td align="left"><?php echo $row["usr_name"]; ?></td>
                        <td align="left"><?php echo $row["usg_group_name"]; ?></td>
                        <td align="center"><?php echo $row["inaund_status"]; ?></td>
                        <td align="center"><?php echo $row["inaund_vertical_level"]; ?></td>
                        <td align="center"><?php echo $row["clo_subagent_name"]; ?></td>
                        <td align="center">
                            <a href="underwriter_companies.php?lid=<?php echo $row['inaund_underwriter_ID'];?>">
                                <i class="fas fa-stream"></i>
                            </a>
                        </td>
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