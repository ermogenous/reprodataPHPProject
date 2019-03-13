<?php
include("../../include/main.php");
include("../../include/tables.php");
$db = new Main();

$table = new draw_table('oqt_items', 'oqit_quotations_types_ID, oqit_sort', 'ASC');
$table->extra_from_section = "LEFT OUTER JOIN `oqt_quotations_types` ON oqqt_quotations_types_ID = oqit_quotations_types_ID ";

$table->generate_data();

$db->show_header();
$table->show_pages_links();
?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>

                <tr class="alert alert-success">
                    <th width="55" align="center"><?php $table->display_order_links('ID', 'oqit_items_ID'); ?></th>
                    <th width="227" align="left"><?php $table->display_order_links('Name', 'oqit_name'); ?></th>
                    <th width="188" align="left"><?php $table->display_order_links('Quotation', 'oqqt_name'); ?></th>
                    <th width="59" align="center"><?php $table->display_order_links('Sort', 'oqit_sort'); ?></th>
                    <th colspan="2" align="center"><a href="items_modify.php">New</a></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                while ($row = $table->fetch_data()) {
                    $i++;
                    ?>
                    <tr onclick="editLine(<?php echo $row["oqit_items_ID"]; ?>);">
                        <th scope="row"><?php echo $row["oqit_items_ID"]; ?></th>
                        <td align="left"><?php echo $row["oqit_name"]; ?></td>
                        <td align="left"><?php echo $row["oqqt_name"]; ?></td>
                        <td align="center"><?php echo $row["oqit_sort"]; ?></td>
                        <td width="55" align="center"><a
                                    href="items_modify.php?lid=<?php echo $row["oqit_items_ID"]; ?>">Modify</a></td>
                        <td width="55" height="30" align="center"><a
                                    href="quotations_types_modify.php?lid=<?php echo $row["oqit_items_ID"]; ?>"
                                    onclick="return(confirm('Are you sure you want to delte this user?'))">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <th scope="row"><a href="index.php">Back</a></th>
                    <td width="188" align="left">&nbsp;</td>
                    <td width="59" align="center">&nbsp;</td>
                    <td colspan="2" align="center">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('items_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$table->show_pages_links();
$db->show_footer();
?>