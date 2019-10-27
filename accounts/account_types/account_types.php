<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/7/2019
 * Time: 12:52 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts Types";

$db->show_header();

$table = new draw_table('ac_account_types','actpe_code','ASC');

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
                            <th scope="col"><?php $table->display_order_links('ID','actpe_account_type_ID');?></th>
                            <th scope="col"><?php $table->display_order_links('Code','actpe_code');?></th>
                            <th scope="col"><?php $table->display_order_links('Type','actpe_type');?></th>
                            <th scope="col"><?php $table->display_order_links('Name','actpe_name');?></th>
                            <th scope="col"><?php $table->display_order_links('Category','actpe_category');?></th>
                            <th scope="col"><?php $table->display_order_links('Active','actpe_active');?></th>
                            <th scope="col">
                                <a href="account_types_modify.php">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            $class = '';

                            if($row["actpe_active"] != 'Active'){
                                $class .= "alert alert-danger";
                            }

                            ?>
                            <tr class="<?php echo $class; ?>" onclick="editLine(<?php echo $row["actpe_account_type_ID"]; ?>);">
                                <th scope="row"><?php echo $row["actpe_account_type_ID"];?></td>
                                <td><?php echo ($row['actpe_type'] == 'SubType'? '&nbsp;&nbsp;&nbsp;&nbsp;':'').$row["actpe_code"];?></td>
                                <td><?php echo $row["actpe_type"];?></td>
                                <td><?php echo $row["actpe_name"];?></td>
                                <td><?php echo $row["actpe_category"];?></td>
                                <td><?php echo $row["actpe_active"];?></td>
                                <td>
                                    <a href="account_types_modify.php?lid=<?php echo $row["actpe_account_type_ID"];?>"><i class="fas fa-edit"></i></a>&nbsp
                                    <a href="account_type_delete.php?lid=<?php echo $row["actpe_account_type_ID"];?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this Category?');"><i class="fas fa-minus-circle"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-1 d-none d-lg-block"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">
                <?php echo $table->show_per_page_links();?>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <script>

        var ignoreEdit = false;
        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('account_types_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>