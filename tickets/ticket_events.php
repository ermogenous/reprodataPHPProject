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

$table = new draw_table('ticket_events', 'tke_incident_date', 'ASC');
$table->extra_from_section = 'JOIN tickets ON tke_ticket_ID = tck_ticket_ID';
$table->extras = 'tke_ticket_ID = '.$_GET["tid"];

$table->generate_data();
//echo $table->sql;

$db->show_empty_header();
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row alert alert-success text-center">
                    <div class="col-12">
                        <b>Events</b>
                    </div>
                </div>
                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr class="alert alert-success">
                            <th scope="col"><?php $table->display_order_links('ID', 'tke_ticket_event_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Type', 'tke_type'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Date', 'tke_incident_date'); ?></th>
                            <th scope="col">
                                <a href="ticket_events_modify.php?tid=<?php echo $_GET["tid"];?>">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr onclick="editLine(<?php echo $row["tke_ticket_event_ID"]; ?>, <?php echo $_GET["tid"];?>);">
                                <th scope="row"><?php echo $row["tke_ticket_event_ID"]; ?></th>
                                <td><?php echo $row["tke_type"]; ?></td>
                                <td><?php echo $row["tke_incident_date"]; ?></td>
                                <td>
                                    <a href="ticket_events_modify.php?tid=<?php echo $_GET["tid"];?>&lid=<?php echo $row["tke_ticket_event_ID"]; ?>"><i
                                                class="fas fa-edit"></i></a>&nbsp
                                    <a href="ticket_events_delete.php?tid=<?php echo $_GET["tid"];?>&lid=<?php echo $row["tke_ticket_event_ID"]; ?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this ticket event?');"><i
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

        var ignoreEdit = false;

        function editLine(id,tid) {
            if (ignoreEdit === false) {
                window.location.assign('ticket_events_modify.php?tid=' + tid + '&lid=' + id);
            }
        }

    </script>

<?php
$db->show_empty_footer();
?>