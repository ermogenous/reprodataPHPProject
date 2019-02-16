<?php
include("../include/main.php");
include("../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Basic Accounts";

$db->show_header();

$table = new draw_table('bc_basic_accounts','bcacc_basic_account_ID','ASC');

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID','bcacc_basic_account_ID');?></th>
                        <th scope="col"><?php $table->display_order_links('Type','bcacc_type');?></th>
                        <th scope="col"><?php $table->display_order_links('Name','bcacc_name');?></th>
                        <th scope="col">
                            <a href="baccounts_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["bcacc_basic_account_ID"]; ?>);">
                            <th scope="row"><?php echo $row["bcacc_basic_account_ID"];?></th>
                            <td><?php echo $row["bcacc_type"];?></td>
                            <td><?php echo $row["bcacc_name"];?></td>
                            <td>
                                <a href="baccounts_modify.php?lid=<?php echo $row["bcacc_basic_account_ID"];?>"><i class="fas fa-edit"></i></a>&nbsp
                                <a href="baccounts_delete.php?lid=<?php echo $row["bcacc_basic_account_ID"];?>"
                                   onclick="return confirm('Are you sure you want to delete this Account?');"><i class="fas fa-minus-circle"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('baccounts_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
