<?php
include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Transactions";

$db->show_header();

$table = new draw_table('ac_transactions', 'actrn_transaction_ID', 'ASC');

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
                        <th scope="col"><?php $table->display_order_links('ID', 'actrn_transaction_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Type', 'actrn_type'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Code', 'actrn_status'); ?></th>
                        <th scope="col">
                            <a href="transaction_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row["actrn_transaction_ID"]; ?></th>
                            <td><?php echo $row["actrn_type"]; ?></td>
                            <td><?php echo $row["actrn_status"]; ?></td>
                            <td>
                                <?php
                                if ($row['actrn_status'] == 'Outstanding') {
                                    ?>
                                    <a href="transaction_modify.php?lid=<?php echo $row["actrn_transaction_ID"]; ?>"><i
                                                class="fas fa-edit"></i></a>&nbsp
                                <?php } ?>

                                <?php
                                if ($row['actrn_status'] == 'Locked' || $row['actrn_status'] == 'Active') {
                                    ?>
                                    <a href="transaction_modify.php?lid=<?php echo $row["actrn_transaction_ID"]; ?>"><i
                                                class="fas fa-eye"></i></a>&nbsp
                                <?php } ?>

                                <?php
                                if ($row['actrn_status'] == 'Outstanding') {
                                    ?>
                                    <a href="transaction_delete.php?lid=<?php echo $row["actrn_transaction_ID"]; ?>"
                                       onclick="return confirm('Are you sure you want to delete this Transaction?');"><i
                                                class="fas fa-minus-circle"></i></a>
                                <?php } ?>

                                <?php
                                if ($row['actrn_status'] == 'Outstanding' || $row['actrn_status'] == 'Locked') {
                                    ?>
                                    <a href="transaction_change_status.php?lid=<?php echo $row['actrn_transaction_ID']; ?>">
                                        <i class="fas fa-lock"
                                           title="<?php echo $db->showLangText('Activate Transaction', 'Ενεργοποίηση Πράξης'); ?>"></i>
                                    </a>
                                <?php } ?>

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
