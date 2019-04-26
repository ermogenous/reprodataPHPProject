<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/2/2019
 * Time: 3:12 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");
include('questions_list.php');
include('disc_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test List";


$db->show_header();

$table = new draw_table('lcs_disc_test', 'lcsdc_disc_test_ID', 'DESC');
//if to show deleted.
if ($_GET['show'] == 'deleted') {
    $_SESSION['discListShowDeleted'] = 1;

}
if ($_GET['show'] == 'notdeleted') {
    $_SESSION['discListShowDeleted'] = 0;
    $table->extras = "lcsdc_status != 'Deleted'";
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
                            <th scope="col"><?php $table->display_order_links('ID', 'lcsdc_disc_test_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Name', 'lcsdc_name'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Status', 'lcsdc_status'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Process Status', 'lcsdc_process_status'); ?></th>
                            <th scope="col">ΥΚΥ</th>
                            <th scope="col">ΧΚΥ</th>
                            <th scope="col">ΥΚΟΙ</th>
                            <th scope="col">ΧΚΟΙ</th>
                            <th scope="col">
                                <a href="disc_modify.php?lg=tr">
                                    <i class="fas fa-plus-circle iconsHeader"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            $disc = new DiscTest($row['lcsdc_disc_test_ID']);
                            $tstResults = $disc->getTestResults();
                            ?>
                            <tr>
                                <th scope="row"
                                    class="<?php echo getTestColor($row['lcsdc_status']); ?>"><?php echo $row["lcsdc_disc_test_ID"]; ?></th>
                                <td><?php echo $row["lcsdc_name"]; ?></td>
                                <td><?php echo $row["lcsdc_status"]; ?></td>
                                <td><?php echo $row["lcsdc_process_status"]; ?></td>
                                <td><?php echo $tstResults['HighDominance']; ?></td>
                                <td><?php echo $tstResults['LowDominance']; ?></td>
                                <td><?php echo $tstResults['HighSocial']; ?></td>
                                <td><?php echo $tstResults['LowSocial']; ?></td>
                                <td>
                                    <input type="hidden" id="myLineID" name="myLineID"
                                           value="<?php echo $row["lcsdc_disc_test_ID"]; ?>">

                                    <a href="disc_modify.php?lg=tr&lid=<?php echo $row["lcsdc_disc_test_ID"]; ?>"><i
                                                class="fas fa-edit iconsLines"></i></a>&nbsp
                                    <a href="disc_delete.php?lid=<?php echo $row["lcsdc_disc_test_ID"]; ?>"
                                       onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this record?');"><i
                                                class="fas fa-minus-circle iconsLines"></i></a>&nbsp
                                    <a href="disc_status.php?lid=<?php echo $row["lcsdc_disc_test_ID"]; ?>"><i
                                                class="far fa-hand-point-right iconsLines"></i></a>
                                    <a href="disc_report.php?lid=<?php echo $row["lcsdc_disc_test_ID"]; ?>"
                                       target="_blank" onclick="ignoreEdit = true;"><i
                                                class="far fa-flag iconsLines"></i></a>
                                    <?php if ($row['lcsdc_status'] == 'Completed') { ?>
                                        <a href="view_email_html.php?lid=<?php echo $row["lcsdc_disc_test_ID"]; ?>"
                                           target="_blank" onclick="ignoreEdit = true;"><i class="far fa-envelope iconsLines"></i></a>
                                        <a href="disc_pdf.php?lid=<?php echo $row["lcsdc_disc_test_ID"]; ?>&action=pdf"
                                           target="_blank" onclick="ignoreEdit = true;"><i class="fas fa-file-pdf iconsLines"></i></a>
                                    <?php } ?>


                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-4 <?php echo getTestColor('Outstanding'); ?> text-center">
                        Outstanding
                    </div>
                    <div class="col-4 <?php echo getTestColor('Completed'); ?> text-center">
                        Completed
                    </div>
                    <div class="col-4 <?php echo getTestColor('Deleted'); ?> text-center">
                        Deleted
                        <input type="checkbox" value="1" id="showDeleted" name="showDeleted"
                               class="form-control"
                               onclick="showDeleted();"
                            <?php if ($_SESSION['discListShowDeleted'] == 1) {
                                echo 'checked';
                            }; ?>>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('disc_modify.php?lg=tr&lid=' + id);
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
            if ($('#showDeleted')[0].checked == true){
                window.location.assign('disc_list.php?show=deleted');
            }
            else {
                window.location.assign('disc_list.php?show=notdeleted');
            }
        }

    </script>
<?php
$db->show_footer();
?>