<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/2/2019
 * Time: 12:26 ΠΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Policy Input Forms";

$db->show_header();

$table = new draw_table('ina_input_forms', 'inaif_input_form_ID', 'ASC');
$table->extra_from_section = 'LEFT OUTER JOIN ina_insurance_companies ON inaif_insurance_company_ID = inainc_insurance_company_ID';

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'inaif_input_form_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'inaif_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Form Filename', 'inaif_form_filename'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Company', 'inainc_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Type', 'inaif_type'); ?></th>
                        <th scope="col">
                            <a href="input_form_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["inaif_input_form_ID"];?>);">
                            <th scope="row"><?php echo $row["inaif_input_form_ID"]; ?></th>
                            <td><?php echo $row["inaif_name"]; ?></td>
                            <td><?php echo $row["inaif_form_filename"]; ?></td>
                            <td><?php echo $row["inainc_name"]; ?></td>
                            <td><?php echo $row["inaif_type"]; ?></td>
                            <td>
                                <a href="input_form_modify.php?lid=<?php echo $row["inaif_input_form_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="input_from_delete.php?lid=<?php echo $row["inaif_input_form_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this Policy Input Form?');"><i
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
        <div class="col-lg-1"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('input_form_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
