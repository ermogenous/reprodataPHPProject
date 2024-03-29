<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/7/2019
 * Time: 11:29 ΠΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Companies";

$db->show_header();

$table = new draw_table('ina_insurance_company_packages', 'inaincpk_insurance_company_package_ID', 'ASC');
$table->extra_from_section = 'JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaincpk_insurance_company_ID';
$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="text-center col-12"><?php $table->show_pages_links(); ?></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="alert alert-success">
                <tr>
                    <th scope="col"><?php $table->display_order_links('ID', 'inaincpk_insurance_company_package_ID'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Company', 'inainc_name'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Type', 'inaincpk_type'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Code', 'inaincpk_code'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Name', 'inaincpk_name'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Status', 'inaincpk_status'); ?></th>
                    <th scope="col">
                        <a href="insurance_company_package_modify.php">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["inaincpk_insurance_company_package_ID"];?>);">
                        <th scope="row"><?php echo $row["inaincpk_insurance_company_package_ID"]; ?></th>
                        <td><?php echo $row["inainc_name"]; ?></td>
                        <td><?php echo $row["inaincpk_type"]; ?></td>
                        <td><?php echo $row["inaincpk_code"]; ?></td>
                        <td><?php echo $row["inaincpk_name"]; ?></td>
                        <td><?php echo $row["inaincpk_status"]; ?></td>
                        <td>
                            <a href="insurance_company_package_modify.php?lid=<?php echo $row["inaincpk_insurance_company_package_ID"]; ?>"><i
                                    class="fas fa-edit"></i></a>&nbsp
                            <a href="insurance_company_package_delete.php?lid=<?php echo $row["inaincpk_insurance_company_package_ID"]; ?>"
                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this insurance company package?');"><i
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

    <div class="row">
        <div class="col-12 text-center">
            <?php echo $table->show_per_page_links();?>
        </div>
    </div>
</div>

<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('insurance_company_package_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
