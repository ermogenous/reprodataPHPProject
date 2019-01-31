<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 5:33 PM
 */
include("../include/main.php");
include("../include/tables.php");

$db = new Main();
$db->admin_title = "Customers Groups List";


$db->show_empty_header();

$table = new draw_table('customer_group_relation', 'cstg_customer_group_ID', 'ASC');
$table->extra_from_section = "JOIN customer_groups ON cstg_customer_groups_ID = csg_customer_group_ID";
$table->extras = " csg_active = 1 AND cstg_customer_ID = " . $_GET['cid'];
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
                            <th scope="col"><?php $table->display_order_links('ID', 'csg_customer_group_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Code', 'csg_code'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Description', 'csg_description'); ?></th>
                            <th scope="col">
                                <a href="customers_groups_list_modify.php?cid=<?php echo $_GET['cid']; ?>">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr onclick="editLine(<?php echo $row["cstg_customer_group_ID"]; ?>,<?php echo $_GET['cid']; ?>);">
                                <th scope="row"><?php echo $row["csg_customer_group_ID"]; ?></th>
                                <td><?php echo $row["csg_code"]; ?></td>
                                <td><?php echo $row["csg_description"]; ?></td>
                                <td>
                                    <a href="customers_groups_list_modify.php?cid=<?php echo $_GET['cid']; ?>&lid=<?php echo $row["cstg_customer_group_ID"]; ?>">
                                        <i class="fas fa-edit"></i></a>&nbsp
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
        <div class="row">
            <div class="col-12 alert alert-secondary">
                Other Members:
            </div>
            <div class="col-12">
                <?php

                $sqlOtherMembers = 'SELECT * FROM customer_group_relation 
                            JOIN customers ON cst_customer_ID = cstg_customer_ID
                            JOIN customer_groups ON csg_customer_group_ID = cstg_customer_groups_ID
                            WHERE cstg_customer_ID != ' . $_GET['cid']." ORDER BY cstg_customer_groups_ID ASC";
                $resultOtherMembers = $db->query($sqlOtherMembers);
                $i = 0;
                while ($otherMember = $db->fetch_assoc($resultOtherMembers)) {

                    $i++;
                    if ($previousRow['cstg_customer_groups_ID'] != $otherMember['cstg_customer_groups_ID']) {
                        echo "<br><u><b>".$otherMember['csg_code']." - ".$otherMember['csg_description']."</b></u><br>";
                    }
                    echo $otherMember['cst_name'] . " " . $otherMember['cst_surname'].", ";
                    $previousRow = $otherMember;
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id, cid) {
            if (ignoreEdit === false) {
                window.location.assign('customers_groups_list_modify.php?cid=' + cid + '&lid=' + id);
            }
        }
    </script>

<?php
$db->show_empty_footer();
?>