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

$table = new draw_table('lcs_intro_extro_test', 'ietst_intro_extro_test_ID', 'DESC');

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="tableHeader">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'ietst_intro_extro_test_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'ietst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'ietst_status'); ?></th>
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
                        $tstResults = getDiSCResults($row);
                        ?>
                        <tr onclick="editLine(<?php echo $row["ietst_intro_extro_test_ID"];?>);" >
                            <th scope="row" class="<?php echo getTestColor($row['ietst_status']);?>"><?php echo $row["ietst_intro_extro_test_ID"]; ?></th>
                            <td><?php echo $row["ietst_name"]; ?></td>
                            <td><?php echo $row["ietst_status"]; ?></td>
                            <td><?php echo $tstResults['HighDominance']; ?></td>
                            <td><?php echo $tstResults['LowDominance']; ?></td>
                            <td><?php echo $tstResults['HighSocial']; ?></td>
                            <td><?php echo $tstResults['LowSocial']; ?></td>
                            <td>
                                <a href="disc_modify.php?lg=tr&lid=<?php echo $row["ietst_intro_extro_test_ID"]; ?>"><i
                                        class="fas fa-edit iconsLines"></i></a>&nbsp
                                <a href="disc_delete.php?lid=<?php echo $row["ietst_intro_extro_test_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this record?');"><i
                                        class="fas fa-minus-circle iconsLines"></i></a>&nbsp
                                <a href="disc_status.php?lid=<?php echo $row["ietst_intro_extro_test_ID"]; ?>"><i class="far fa-hand-point-right iconsLines"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-6 <?php echo getTestColor('Outstanding');?> text-center">
                    Outstanding
                </div>
                <div class="col-6 <?php echo getTestColor('Link');?> text-center">
                    Link
                </div>
                <div class="col-4 <?php echo getTestColor('Completed');?> text-center">
                    Completed
                </div>
                <div class="col-4 <?php echo getTestColor('Paid');?> text-center">
                    Paid
                </div>
                <div class="col-4 <?php echo getTestColor('Deleted');?> text-center">
                    Deleted
                </div>


            </div>


        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('disc_modify.php?lg=tr&lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>