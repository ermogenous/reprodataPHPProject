<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/10/2018
 * Time: 3:22 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Tickets";

$db->show_header();

$table = new draw_table('tickets', 'tck_ticket_ID', 'ASC');
$table->extra_from_section = 'JOIN customers ON cst_customer_ID = tck_customer_ID';

$table->generate_data();
//echo $table->sql;
?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="row alert alert-success text-center">
                <div class="col-12">
                    Tickets
                </div>
            </div>
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="alert alert-success">
                        <th scope="col"><?php $table->display_order_links('ID', 'tck_ticket_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'tck_ticket_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col">
                            <a href="ticket_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["tck_ticket_ID"];?>);">
                        <th scope="row"><?php echo $row["tck_ticket_ID"]; ?></th>
                        <td><?php echo $row["tck_ticket_number"]; ?></td>
                        <td><?php echo $row["cst_name"]; ?></td>
                        <td>
                            <a href="ticket_modify.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                            <a href="ticket_delete.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"
                               onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this ticket?');"><i
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

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('ticket_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
