<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 1:13 ΜΜ
 */


include("../../include/main.php");
include("../../include/tables.php");
include("../policy_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items";

$db->show_empty_header();

if ($_GET['pid'] > 0) {

    $table = new draw_table('ina_policy_items', 'inapit_policy_item_ID', 'ASC');
    $table->extra_from_section .= " LEFT OUTER JOIN ina_insurance_codes AS make ON inaic_insurance_code_ID = inapit_vh_make_code_ID";
    $table->extra_from_section .= " LEFT OUTER JOIN codes as city ON cde_code_ID = inapit_rl_city_code_ID";
    $table->extras .= 'inapit_policy_ID = ' . $_GET['pid'];

    $table->generate_data();

    $policy = new Policy($_GET['pid']);

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
                            <?php if ($_GET['type'] == 'Vehicles') { ?>
                                <th scope="col"><?php $table->display_order_links('Registration', 'inapit_vh_registration'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Make', 'inaic_name'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Model', 'inapit_vh_model'); ?></th>
                            <?php } else if ($_GET['type'] == 'Risk Locations') { ?>
                                <th scope="col"><?php $table->display_order_links('Type', 'inapit_rl_construction_type'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Address', 'inapit_rl_address_1'); ?></th>
                                <th scope="col"><?php $table->display_order_links('City', 'cde_value'); ?></th>
                            <?php } ?>
                            <th scope="col"><?php $table->display_order_links('Ins.Amount', 'inapit_insured_amount'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Excess', 'inapit_excess'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Premium', 'inapit_premium'); ?></th>
                            <th scope="col">
                                <a href="policy_item_modify.php?pid=<?php echo $_GET['pid'] . "&type=" . $_GET['type']; ?>">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalLines = 0;
                        while ($row = $table->fetch_data()) {
                            $totalLines++;
                            ?>
                            <tr onclick="editLine(<?php echo $row["inapit_policy_item_ID"] . "," . $_GET['pid'] . ",'" . $_GET['type'] . "'"; ?>);">
                                <th scope="row"><?php echo $row["inapit_policy_item_ID"]; ?></th>
                                <?php if ($_GET['type'] == 'Vehicles') { ?>

                                    <td><?php echo $row["inapit_vh_registration"]; ?></td>
                                    <td><?php echo $row["inaic_name"]; ?></td>
                                    <td><?php echo $row["inapit_vh_model"]; ?></td>

                                <?php } else if ($_GET['type'] == 'Risk Locations') { ?>

                                    <td><?php echo $row["inapit_rl_construction_type"]; ?></td>
                                    <td><?php echo $row["inapit_rl_address_1"]; ?></td>
                                    <td><?php echo $row["cde_value"]; ?></td>

                                <?php } ?>

                                <td><?php echo $row["inapit_insured_amount"]; ?></td>
                                <td><?php echo $row["inapit_excess"]; ?></td>
                                <td><?php echo $row["inapit_premium"]; ?></td>
                                <td>

                                    <?php
                                    if ($policy->policyData['inapol_status'] == 'Oustanding') {
                                        ?>
                                        <a href="policy_item_modify.php?lid=<?php echo $row["inapit_policy_item_ID"] . "&pid=" . $_GET['pid'] . "&type=" . $_GET['type']; ?>"><i
                                                    class="fas fa-edit"></i></a>&nbsp
                                        <a href="policy_item_delete.php?lid=<?php echo $row["inapit_policy_item_ID"] . "&pid=" . $_GET['pid'] . "&type=" . $_GET['type']; ?>"
                                           onclick="ignoreEdit = true;
                                            return confirm('Are you sure you want to delete this policy item?');"><i
                                                    class="fas fa-minus-circle"></i></a>
                                    <?php }else { ?>
                                        <a href="policy_item_modify.php?lid=<?php echo $row["inapit_policy_item_ID"] . "&pid=" . $_GET['pid'] . "&type=" . $_GET['type']; ?>"><i
                                                    class="fas fa-eye"></i></a>&nbsp
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
        </div>
    </div>
    <script>

        var ignoreEdit = false;

        function editLine(id, pid, type) {
            if (ignoreEdit === false) {
                window.location.assign('policy_item_modify.php?lid=' + id + '&pid=' + pid + '&type=' + type);
            }
        }

        //every time this page loads reload the premium tab
        $(document).ready(function () {

            <?php if ($_GET['rel'] == 'yes') { ?>
            parent.window.frames['premTab'].location.reload(true);
            parent.window.frames['installmentsTab'].location.reload(true);
            <?php } ?>

            let fixedPx = 100;
            let totalPx = fixedPx + (<?php echo $totalLines;?> * 60
        )
            ;
            $('#policyItemsTab', window.parent.document).height(totalPx + 'px');

        });
    </script>
    <?php
}
$db->show_empty_footer();
?>
