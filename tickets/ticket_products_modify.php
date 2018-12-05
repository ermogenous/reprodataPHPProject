<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 3:32 ΜΜ
 */

include("../include/main.php");

$db = new Main();
$db->admin_title = "Tickets products Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Ticket Products Insert';
    $db->start_transaction();

    $_POST['fld_ticket_ID'] = $_GET['tid'];
    $_POST['fld_type'] = $_GET['type'];

    $newID = $db->db_tool_insert_row('ticket_products', $_POST, 'fld_', 1, 'tkp_');
    $db->commit_transaction();

    header("Location: ticket_products.php?tid=".$_POST['tid']."&type=".$_POST['type']);
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Ticket Products Update';
    $db->start_transaction();

    $db->db_tool_update_row('ticket_products', $_POST, "`tkp_ticket_event_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'tkp_');

    $db->commit_transaction();
    header("Location: ticket_products.php?tid=" . $_POST['tid']);
    exit();

}

if ($_GET['type'] == 'SparePart') {
    $frameName = 'frmTabSpareParts';
    $frameTitle = 'Spare Part';
} else if ($_GET['type'] == 'Consumable') {
    $frameName = 'frmTabConsumables';
    $frameTitle = 'Consumable';
} else if ($_GET['type'] == 'Other') {
    $frameName = 'frmTabOther';
    $frameTitle = 'Other';
} else if ($_GET['type'] == 'Machine') {
    $frameName = 'frmTabMachine';
    $frameTitle = 'Machine';
} else {
    exit();
}

if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `ticket_products` JOIN `tickets` ON tkp_ticket_ID = tck_ticket_ID 
            WHERE `tkp_ticket_event_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();

echo "Tid:" . $_GET["tid"] . " - Lid:" . $_GET["lid"] . " - " . $_GET['type'] . "<br>";
//print_r($data);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-success text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Ticket <?php echo $frameTitle; ?></b>
                </div>

                <div class="form-group row">
                    <label for="fld_ticket_event_ID"
                           class="col-2 col-form-label">Select Event</label>
                    <div class="col-4">
                        <select name="fld_ticket_event_ID" id="fld_ticket_event_ID"
                                class="form-control"
                                required onchange="loadProductsFromEvent()">
                            <option value=""></option>
                            <?php
                            $sql = "SELECT * FROM ticket_events
                                        JOIN unique_serials ON uqs_unique_serial_ID = tke_unique_serial_ID
                                        JOIN products ON prd_product_ID = uqs_product_ID
                                        WHERE tke_ticket_ID = " . $_GET["tid"];
                            $ticketsResult = $db->query($sql);
                            while ($ticket = $db->fetch_assoc($ticketsResult)) {
                                echo '<option value="' . $ticket['tke_ticket_event_ID'] . '">
                                    ' . $ticket['tke_ticket_event_ID'] . ' - ' . $ticket['tke_type'] . ' - ' . $ticket['prd_model'] . '
                                    </option>';
                            }
                            ?>
                        </select>
                        <?php //echo $sql; ?>
                    </div>

                    <div class="col-2"><?php echo $frameTitle; ?></div>
                    <div class="col-4">
                        <select name="fld_product_ID" id="fld_product_ID"
                                class="form-control"
                                required>
                        </select>
                        <i class="fas fa-spinner" id="productsSpin" style="display: none"></i>
                    </div>

                    <script>
                        function loadProductsFromEvent() {
                            //show spinner
                            $('#fld_product_ID').hide();
                            $('#productsSpin').show();

                            let eventID = $('#fld_ticket_event_ID').val();

                            Rx.Observable.fromPromise(
                                $.get("../products/products_api.php?section=productsSearchForEvent&eventID=" + eventID + "&type=<?php echo $_GET["type"];?>")
                            )
                                .subscribe(
                                    (response) => {
                                $('#fld_product_ID').show();
                                $('#productsSpin').hide();
                                data = response;
                        },
                            (error) =>
                            {
                                console.log(error);
                            }
                        ,
                            () =>
                            {

                                //first clear the select
                                $("#fld_product_ID option").each(function () {
                                    $(this).remove(); //or whatever else
                                });

                                //add an empty option
                                $('#fld_product_ID').append($('<option>', {
                                    value: '',
                                    text: ''
                                }));

                                $.each(
                                    data,
                                    function (index, value) {

                                        $('#fld_product_ID').append($('<option>', {
                                            value: value['value'],
                                            text: value['model'] + ' ' + value['label']
                                        }));

                                    }
                                );
                            }
                        )
                        };
                    </script>

                </div>
                <div class="form-group row">
                    <div class="col-2">Amount</div>
                    <div class="col-4">
                        <input name="fld_amount" type="text" id="fld_amount"
                               class="form-control"
                               value="<?php echo $data['tkp_amount']; ?>"
                               required>


                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-lg-2 col-sm-3"></div>
                    <div class="col-lg-4 col-sm-3">

                    </div>
                    <div class="col-6">

                    </div>

                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input name="tid" type="hidden" id="tid" value="<?php echo $_GET["tid"]; ?>">
                        <input name="type" type="hidden" id="tid" value="<?php echo $_GET["type"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="goBack();">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert " . $frameTitle; else echo "Update " . $frameTitle; ?> "
                               class="btn btn-secondary"
                               onclick="submitForm('')">
                        <input name="subAction" id="subAction" type="hidden" value="">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>

    $('#<?php echo $frameName;?>', window.parent.document).height('400px');

    function submitForm(action) {
        let frm = document.getElementById('myForm');
        if (frm.checkValidity() === false) {

        }
        else {
            document.getElementById('Submit').disabled = true
        }
        $('#subAction').val(action);
    }

    function goBack() {
        location.href = 'ticket_events.php?tid=<?php echo $_GET['tid'];?>';
    }
</script>

<?php
$db->show_empty_footer();
?>
