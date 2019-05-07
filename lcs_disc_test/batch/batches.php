<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/5/2019
 * Time: 11:52 ΠΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
include('../disc_class.php');


$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test Batches List";


$db->show_header();

$table = new draw_table('lcs_disc_batch', 'lcsdb_disc_batch_ID', 'DESC');
//if to show deleted.
if ($_GET['show'] == 'deleted') {
    $_SESSION['discListShowDeleted'] = 1;

}
if ($_GET['show'] == 'notdeleted') {
    $_SESSION['discListShowDeleted'] = 0;
    $table->extras = "lcsdb_status != 'Deleted'";
}


$table->generate_data();
?>


    <div class="container">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover" id="myTableList">
                        <thead class="tableHeader">
                        <tr>
                            <th scope="col"><?php $table->display_order_links('ID', 'lcsdb_disc_batch_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Name', 'lcsdb_name'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Status', 'lcsdb_status'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Max', 'lcsdb_max_tests'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Used', 'lcsdb_used_tests'); ?></th>
                            <th scope="col">
                                <a href="batch_modify.php">
                                    <i class="fas fa-plus-circle iconsHeader"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) { 
                            //check if a batch status has been changed
                            if ($row['lcsdb_used_tests'] >= $row["lcsdb_max_tests"]) {
                                $row["lcsdb_status"] = 'Completed';
                                $newData['status'] = 'Completed';
                                $db->db_tool_update_row('lcs_disc_batch',
                                    $newData,
                                    'lcsdb_disc_batch_ID = '.$row['lcsdb_disc_batch_ID'],
                                    $row['lcsdb_disc_batch_ID'],
                                    '',
                                    'execute',
                                    'lcsdb_');
                            }
                            
                            ?>
                            <tr>
                                <th scope="row"
                                    class="<?php echo getTestColor($row['lcsdb_status']); ?>"><?php echo $row["lcsdb_disc_batch_ID"]; ?></th>
                                <td><?php echo $row["lcsdb_name"]; ?></td>
                                <td><?php echo $row["lcsdb_status"]; ?></td>
                                <td><?php echo $row["lcsdb_max_tests"]; ?></td>
                                <td><?php echo $row['lcsdb_used_tests']; ?></td>
                                <td>
                                    <input type="hidden" id="myLineID" name="myLineID"
                                           value="<?php echo $row["lcsdc_disc_test_ID"]; ?>">

                                    <a href="batch_modify.php?lg=tr&lid=<?php echo $row["lcsdb_disc_batch_ID"]; ?>"><i
                                                class="fas fa-edit iconsLines"></i></a>&nbsp
                                    <a href="batch_delete.php?lid=<?php echo $row["lcsdb_disc_batch_ID"]; ?>"
                                       onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this record?');"><i
                                                class="fas fa-minus-circle iconsLines"></i></a>

                                    <a href="batch_link.php?lid=<?php echo $row["lcsdb_disc_batch_ID"]; ?>">
                                        <i class="far fa-hand-point-right iconsLines"></i>
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
            <div class="col-lg-1"></div>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('batch_modify.php?lid=' + id);
            }
            ignoreEdit = false;
        }

        $(document).ready(function () {

            $('#myTableList tr').click(function () {
                var href = $(this).find('input[id=myLineID]').val();
                if (href) {
                    editLine(href);
                }
            });

        });

        function showDeleted() {
            if ($('#showDeleted')[0].checked == true) {
                window.location.assign('batches.php?show=deleted');
            }
            else {
                window.location.assign('batches.php?show=notdeleted');
            }
        }

    </script>
<?php
$db->show_footer();
?>