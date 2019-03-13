<?php
include("../../include/main.php");
include("../../include/tables.php");
$db = new Main();

$table = new draw_table('oqt_quotations_types', 'oqqt_quotations_types_ID', 'ASC');

$table->generate_data();


$db->show_header();
?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="alert alert-success">
                    <th width="51"
                        align="center"><?php $table->display_order_links('ID', 'oqqt_quotations_types_ID'); ?></th>
                    <th width="337" align="left"><?php $table->display_order_links('Name', 'oqqt_name'); ?></th>
                    <th width="81" align="center"><?php $table->display_order_links('Status', 'oqqt_status'); ?></th>
                    <th colspan="3" align="center"><a href="quotations_types_modify.php">New</a></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["oqqt_quotations_types_ID"]; ?>);">
                        <th scope="row"><?php echo $row["oqqt_quotations_types_ID"]; ?></th>
                        <td align="left"><?php echo $row["oqqt_name"]; ?></td>
                        <td align="center"><?php echo $row["oqqt_status"]; ?></td>
                        <td width="59" align="center"><a
                                    href="quotations_types_modify.php?lid=<?php echo $row["oqqt_quotations_types_ID"]; ?>">Modify</a>
                        </td>
                        <td width="58" height="30" align="center"><a
                                    href="quotations_types_modify.php?lid=<?php echo $row["oqqt_quotations_types_ID"]; ?>"
                                    onclick="return(confirm('Are you sure you want to delte this user?'))">Delete</a>
                        </td>
                        <td width="53" align="center"><a
                                    href="../quotations_modify.php?quotation_type=<?php echo $row["oqqt_quotations_types_ID"]; ?>">Launch</a>
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
                window.location.assign('quotations_types_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>