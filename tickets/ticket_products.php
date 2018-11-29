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
$db->admin_title = "Tickets products";

if ($_GET['type'] == 'SparePart'){
    $frameName = 'frmTabSpareParts';
    $frameTitle = 'Spare Part';
}
else if ($_GET['type'] == 'Consumable'){
    $frameName = 'frmTabConsumables';
    $frameTitle = 'Consumable';
}
else if ($_GET['type'] == 'Other'){
    $frameName = 'frmTabOther';
    $frameTitle = 'Other';
}
else if ($_GET['type'] == 'Machine'){
    $frameName = 'frmTabMachine';
    $frameTitle = 'Machine';
}

else {
    exit();
}

$db->working_section = 'Ticket Products draw table';
$table = new draw_table('ticket_products', 'tkp_ticket_product_ID');
$table->extra_from_section = 'JOIN tickets ON tkp_ticket_ID = tck_ticket_ID';
$table->extras = 'tkp_ticket_ID = '.$_GET["tid"];
$table->extras .= " AND tkp_type = '".$_GET['type']."'";

$table->generate_data();
//echo $table->sql;

$db->show_empty_header();


?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row alert alert-success text-center">
                    <div class="col-12">
                        <b><?php echo $frameTitle;?></b>
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
                                <a href="ticket_products_modify.php?tid=<?php echo $_GET["tid"];?>&type=<?php echo $_GET['type'];?>">
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
                                    <a href="ticket_products_modify.php?tid=<?php echo $_GET["tid"];?>&lid=<?php echo $row["tke_ticket_event_ID"]; echo '&'.$_GET['type']; ?>"><i
                                                class="fas fa-edit"></i></a>&nbsp
                                    <a href="ticket_products_delete.php?tid=<?php echo $_GET["tid"];?>&lid=<?php echo $row["tke_ticket_event_ID"]; echo '&'.$_GET['type']; ?>"
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
        $('#<?php echo $frameName;?>', window.parent.document).height('500px');

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