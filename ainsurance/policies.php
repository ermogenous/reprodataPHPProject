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

$db->show_header();

$table = new draw_table('ina_policies', 'inapol_policy_ID', 'ASC');
$table->extra_from_section .= 'JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID';
$table->extra_from_section .= ' JOIN customers ON cst_customer_ID = inapol_customer_ID';

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
                        <th scope="col"><?php $table->display_order_links('ID', 'inapol_policy_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'inapol_policy_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer ID', 'cst_identity_card'); ?></th>
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
                        <tr onclick="editLine(<?php echo $row["inapol_policy_ID"];?>);">
                            <th scope="row"><?php echo $row["inapol_policy_ID"]; ?></th>
                            <td><?php echo $row["inapol_policy_number"]; ?></td>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td><?php echo $row["cst_identity_card"]; ?></td>
                            <td>
                                <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="policy_delete.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this policy?');"><i
                                        class="fas fa-minus-circle"></i></a>
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
            window.location.assign('policy_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
