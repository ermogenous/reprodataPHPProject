<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2019
 * Time: 11:53 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policies";

$table = new draw_table('ina_policies', 'inapol_policy_ID', 'ASC');
$table->extra_from_section .= 'JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID';
$table->extra_from_section .= ' JOIN customers ON cst_customer_ID = inapol_customer_ID';

$table->generate_data();

$db->show_header();
?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover" id="myTableList">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'inapol_policy_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'inapol_policy_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer ID', 'cst_identity_card'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'inapol_status'); ?></th>
                        <th scope="col">
                            <a href="policy_modify.php">
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
                            <th scope="row"><?php echo $row["inapol_policy_ID"]; ?></th>
                            <td><?php echo $row["inapol_policy_number"]; ?></td>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td><?php echo $row["cst_identity_card"]; ?></td>
                            <td><?php echo $row["inapol_status"]; ?></td>
                            <td>
                                <input type="hidden" id="myLineID" name="myLineID" value="<?php echo $row["inapol_policy_ID"]; ?>">
                                <?php if ($row['inapol_status'] == 'Outstanding') { ?>
                                    <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>">
                                        <i class="fas fa-edit" title="Modify"></i>
                                    </a>&nbsp
                                    <a href="policy_delete.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this policy?');">
                                        <i class="fas fa-minus-circle" title="Delete"></i>
                                    </a>&nbsp
                                    <a href="policy_change_status.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                                class="fas fa-lock" title="Activate"></i></a>&nbsp
                                <?php }
                                if ($row['inapol_status'] == 'Active') { ?>
                                    <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                                class="fas fa-eye" title="View"></i></a>&nbsp
                                <?php }
                                if ($row['inapol_status'] == 'Cancelled' || $row['inapol_status'] == 'Deleted') { ?>
                                    <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                                class="fas fa-eye" title="View"></i>
                                    </a>&nbsp
                                <?php }
                                if ($row['inapol_status'] == 'Active' && $row['inapol_replaced_by_ID'] == '') { ?>
                                <a href="policy_renewal.php?pid=<?php echo $row["inapol_policy_ID"]; ?>">
                                    <i class="fas fa-retweet" title="Review"></i>
                                </a>&nbsp
                                <?php } ?>
                                <?php
                                if ($row['inapol_status'] == 'Active' && $row['inapol_replaced_by_ID'] == '') { ?>
                                    <a href="policy_endorsement.php?pid=<?php echo $row["inapol_policy_ID"]; ?>">
                                        <i class="fas fa-wrench" title="Endorse"></i>
                                    </a>&nbsp
                                <?php } ?>
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

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('policy_modify.php?lid=' + id);
        }
        ignoreEdit = false;
    }

    $(document).ready(function() {
        $('#myTableList tr').click(function() {
            var href = $(this).find('input[id=myLineID]').val();
            if(href) {
                editLine(href);
            }
        });
    });
</script>
<?php
$db->show_footer();
?>
