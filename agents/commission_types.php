<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 11/2/2019
 * Time: 12:15 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Commission Types";

if ($_GET['aid'] == '' || is_numeric($_GET['aid']) != true) {
    header("Location: ../home.php");
    exit();
}


$db->show_empty_header();

$table = new draw_table('agent_commission_types', 'agcmt_agent_insurance_type_ID', 'ASC');
$table->extra_from_section .= ' JOIN ina_insurance_companies ON inainc_insurance_company_ID = agcmt_insurance_company_ID';
$table->extra_from_section .= ' JOIN ina_policy_types ON inpot_policy_type_ID = agcmt_policy_type_ID';

$table->extras = 'agcmt_agent_ID = ' . $_GET['aid'];

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="text-center"><?php $table->show_pages_links(); ?></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="alert alert-success">
                <tr>
                    <th scope="col"><?php $table->display_order_links('ID', 'agcmt_agent_insurance_type_ID'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Status', 'agcmt_status'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Ins.Company', 'inainc_name'); ?></th>
                    <th scope="col"><?php $table->display_order_links('Policy Type', 'inpot_name'); ?></th>
                    <th scope="col">
                        <a href="commission_type_modify.php?aid=<?php echo $_GET['aid']; ?>">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["agcmt_agent_insurance_type_ID"] . ',' . $_GET['aid']; ?>);">
                        <th scope="row"><?php echo $row["agcmt_agent_insurance_type_ID"]; ?></th>
                        <td><?php echo $row["agcmt_status"]; ?></td>
                        <td><?php echo $row["inainc_name"]; ?></td>
                        <td><?php echo $row["inpot_name"]; ?></td>
                        <td>
                            <a href="commission_type_modify.php?lid=<?php echo $row["agcmt_agent_insurance_type_ID"] . '&aid=' . $_GET['aid']; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                            <a href="commission_type_delete.php?lid=<?php echo $row["agcmt_agent_insurance_type_ID"] . '&aid=' . $_GET['aid']; ?>"
                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this Commission Type?');"><i
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
<script>
    var ignoreEdit = false;

    function editLine(id, aid) {
        if (ignoreEdit === false) {
            window.location.assign('commission_type_modify.php?aid=' + aid + '&lid=' + id);
        }
    }
</script>
<?php
$db->show_empty_footer();
?>
