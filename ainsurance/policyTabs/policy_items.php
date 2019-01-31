<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 1:13 ΜΜ
 */



include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items";

$db->show_empty_header();

$table = new draw_table('ina_policy_items', 'inapit_policy_item_ID', 'ASC');
$table->extra_from_section .= " JOIN ina_insurance_codes AS make ON inaic_insurance_code_ID = inapit_vh_make_code_ID";

$table->generate_data();
echo $_GET['type'];
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'inapit_policy_item_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Registration', 'inapit_vh_registration'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Make', 'inaic_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Model', 'inapit_vh_model'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Ins.Amount', 'inapit_insured_amount'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Excess', 'inapit_excess'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Premium', 'inapit_premium'); ?></th>
                        <th scope="col">
                            <a href="policy_item_modify.php?pid=<?php echo $_GET['pid']."&type=".$_GET['type'];?>">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["inapit_policy_item_ID"].",".$_GET['pid'].",'".$_GET['type']."'";?>);">
                            <th scope="row"><?php echo $row["inapit_policy_item_ID"]; ?></th>
                            <td><?php echo $row["inapit_vh_registration"]; ?></td>
                            <td><?php echo $row["inaic_name"]; ?></td>
                            <td><?php echo $row["inapit_vh_model"]; ?></td>
                            <td><?php echo $row["inapit_insured_amount"]; ?></td>
                            <td><?php echo $row["inapit_excess"]; ?></td>
                            <td><?php echo $row["inapit_premium"]; ?></td>
                            <td>
                                <a href="policy_item_modify.php?lid=<?php echo $row["inapit_policy_item_ID"]."&pid=".$_GET['pid']."&type=".$_GET['type']; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="policy_delete.php?lid=<?php echo $row["inapit_policy_item_ID"]; ?>"
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
    </div>
</div>
<script>
    var ignoreEdit = false;
    function editLine(id,pid,type){
        if (ignoreEdit === false) {
            window.location.assign('policy_item_modify.php?lid=' + id + '&pid=' + pid + '&type=' + type);
        }
    }
</script>
<?php
$db->show_empty_footer();
?>
