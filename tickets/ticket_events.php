<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/11/2018
 * Time: 4:19 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main();
$db->admin_title = "Tickets events";

$table = new draw_table('tickets', 'tck_ticket_ID', 'ASC');
$table->extra_from_section = 'JOIN customers ON cst_customer_ID = tck_customer_ID';

$table->generate_data();
//echo $table->sql;

$db->show_empty_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row alert alert-success text-center">
                    <div class="col-12">
                        Events
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
                                <a href="ticket_events_modify.php?lid=<?php echo $_GET['lid'];?>">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr onclick="editLine(<?php echo $row["tck_ticket_ID"]; ?>);">
                                <th scope="row"><?php echo $row["tck_ticket_ID"]; ?></th>
                                <td><?php echo $row["tck_ticket_number"]; ?></td>
                                <td><?php echo $row["cst_name"]; ?></td>
                                <td>
                                    <a href="ticket_events_modify.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"><i
                                                class="fas fa-edit"></i></a>&nbsp
                                    <a href="ticket_events_delete.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this event?');"><i
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
        $('#frmTabEvents', window.parent.document).height('500px');
    </script>

<?php
$db->show_empty_footer();
?>