<?php
include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts";

$db->show_header();

$table = new draw_table('ac_accounts','acacc_account_ID','ASC');

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
                        <th scope="col"><?php $table->display_order_links('ID','acacc_account_ID');?></th>
                        <th scope="col"><?php $table->display_order_links('Type','acacc_type');?></th>
                        <th scope="col"><?php $table->display_order_links('Code','acacc_code');?></th>
                        <th scope="col"><?php $table->display_order_links('Name','acacc_name');?></th>
                        <th scope="col"><?php $table->display_order_links('Active','acacc_active');?></th>
                        <th scope="col">
                            <a href="accounts_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr class="<?php if($row["acacc_active"] == 0) echo "alert alert-danger";?>">
                            <th scope="row"><?php echo $row["acacc_account_ID"];?></th>
                            <td><?php echo $row["acacc_type"];?></td>
                            <td><?php echo $row["acacc_code"];?></td>
                            <td><?php echo $row["acacc_name"];?></td>
                            <td><?php echo $row["acacc_active"];?></td>
                            <td>
                                <a href="accounts_modify.php?lid=<?php echo $row["acacc_account_ID"];?>"><i class="fas fa-edit"></i></a>&nbsp
                                <a href="accounts_delete.php?lid=<?php echo $row["acacc_account_ID"];?>"
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

<?php
$db->show_footer();
?>
