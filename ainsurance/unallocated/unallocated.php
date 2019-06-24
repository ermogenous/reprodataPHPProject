<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/6/2019
 * Time: 3:33 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Unallocated Payments";

$table = new draw_table('ina_policy_payments', 'inapp_policy_payment_ID', 'ASC');
$table->extra_from_section .= 'JOIN ina_policies ON inapol_policy_ID = inapp_policy_ID';
$table->extra_from_section .= ' JOIN customers ON cst_customer_ID = inapp_customer_ID';
$table->extras = "inapp_status = 'Unallocated'";

$table->generate_data();

$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover" id="myTableList">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'inapol_policy_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Policy Number', 'inapol_policy_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer ID', 'cst_identity_card'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Amount', 'inapp_amount'); ?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row["inapp_policy_payment_ID"]; ?></th>
                            <td><?php echo $row["inapol_policy_number"]; ?></td>
                            <td><?php echo $row["cst_name"] . " " . $row['cst_surname']; ?></td>
                            <td><?php echo $row["cst_identity_card"]; ?></td>
                            <td><?php echo $row["inapp_amount"]; ?></td>
                            <td>
                                <input type="hidden" id="myLineID" name="myLineID"
                                       value="<?php echo $row["inapp_policy_payment_ID"]; ?>">
                                <a href="unallocated_apply.php?lid=<?php echo $row["inapp_policy_payment_ID"]; ?>">
                                    <i class="fas fa-wrench" title="Apply UnAllocated Record to other policy"></i>
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
            window.location.assign('unallocated_apply.php?lid=' + id);
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
</script>
<?php
$db->show_footer();
?>
