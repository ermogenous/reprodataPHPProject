<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/4/2019
 * Time: 1:01 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
$db = new Main();

$table = new draw_table('oqt_quotations_underwriters', 'oqun_quotations_underwriter_ID', 'ASC');
$table->extra_from_section = 'JOIN users ON usr_users_ID = oqun_user_ID';

$table->generate_data();


$db->show_header();
?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="alert alert-success">
                    <th width="51"
                        align="center"><?php $table->display_order_links('ID', 'oqun_quotations_underwriter_ID'); ?></th>
                    <th width="337" align="left"><?php $table->display_order_links('Name', 'usr_name'); ?></th>
                    <th width="81" align="center"><?php $table->display_order_links('Status', 'oqun_status'); ?></th>
                    <th colspan="2" align="center"><a href="underwriters_modify.php">New</a></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["oqun_quotations_underwriter_ID"]; ?>);">
                        <th scope="row"><?php echo $row["oqun_quotations_underwriter_ID"]; ?></th>
                        <td align="left"><?php echo $row["usr_name"]; ?></td>
                        <td align="center"><?php echo $row["oqun_status"]; ?></td>
                        <td width="59" align="center"><a
                                href="underwriters_modify.php?lid=<?php echo $row["oqun_quotations_underwriter_ID"]; ?>">Modify</a>
                        </td>
                        <td width="58" height="30" align="center"><a
                                href="underwriters_modify.php?lid=<?php echo $row["oqun_quotations_underwriter_ID"]; ?>"
                                onclick="return(confirm('Are you sure you want to delte this underwriter?'))">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3" align="left"><a href="index.php">Back</a></td>
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