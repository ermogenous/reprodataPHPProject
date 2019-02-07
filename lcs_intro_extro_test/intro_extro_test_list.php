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

$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS Introvert Extrovert Test List";

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
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'ietst_intro_extro_test_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'ietst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'ietst_status'); ?></th>
                        <th scope="col">ΥΚΥ</th>
                        <th scope="col">ΧΚΥ</th>
                        <th scope="col">ΥΚΟΙ</th>
                        <th scope="col">ΧΚΟΙ</th>
                        <th scope="col">
                            <a href="intro_extro_test_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        $tstResults = getIntorExtroResults($row);
                        ?>
                        <tr onclick="editLine(<?php echo $row["ietst_intro_extro_test_ID"];?>);">
                            <th scope="row"><?php echo $row["ietst_intro_extro_test_ID"]; ?></th>
                            <td><?php echo $row["ietst_name"]; ?></td>
                            <td><?php echo $row["ietst_status"]; ?></td>
                            <td><?php echo $tstResults['HighDominance']; ?></td>
                            <td><?php echo $tstResults['LowDominance']; ?></td>
                            <td><?php echo $tstResults['HighSocial']; ?></td>
                            <td><?php echo $tstResults['LowSocial']; ?></td>
                            <td>
                                <a href="intro_extro_test_modify.php?lid=<?php echo $row["ietst_intro_extro_test_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="intro_extro_test_delete.php?lid=<?php echo $row["ietst_intro_extro_test_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this record?');"><i
                                        class="fas fa-minus-circle"></i></a>&nbsp
                                <a href="intro_extro_status.php?lid=<?php echo $row["ietst_intro_extro_test_ID"]; ?>"><i class="far fa-hand-point-right"></i></a>
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
</div>
<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('intro_extro_test_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>