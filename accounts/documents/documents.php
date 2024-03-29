<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/7/2019
 * Time: 1:46 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts Categories";

$db->show_header();

$table = new draw_table('ac_documents','acdoc_code','ASC');

$table->generate_data();

?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-lg-block"></div>
            <div class="col-12 col-lg-10">
                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><?php $table->display_order_links('Code','acdoc_code');?></th>
                            <th scope="col"><?php $table->display_order_links('Name','acdoc_name');?></th>
                            <th scope="col"><?php $table->display_order_links('Active','acdoc_active');?></th>
                            <th scope="col">
                                <a href="document_modify.php">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            $class = '';

                            if($row["acdoc_active"] != 'Active'){
                                $class .= "alert alert-danger";
                            }

                            ?>
                            <tr class="<?php echo $class; ?>" onclick="editLine(<?php echo $row["acdoc_document_ID"]; ?>);">
                                <th scope="row"><?php echo $row["acdoc_code"];?></td>
                                <td><?php echo $row["acdoc_name"];?></td>
                                <td><?php echo $row["acdoc_active"];?></td>
                                <td>
                                    <a href="document_modify.php?lid=<?php echo $row["acdoc_document_ID"];?>"><i class="fas fa-edit"></i></a>&nbsp
                                    <a href="document_delete.php?lid=<?php echo $row["acdoc_document_ID"];?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this Document?');"><i class="fas fa-minus-circle"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-1 d-none d-lg-block"></div>
        </div>
    </div>
    <script>

        var ignoreEdit = false;
        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('document_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>